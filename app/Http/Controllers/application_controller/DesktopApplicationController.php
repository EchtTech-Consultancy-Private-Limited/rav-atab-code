<?php
namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Models\TblApplication; 
use App\Models\TblApplicationPayment; 
use App\Models\TblApplicationCourseDoc; 
use App\Models\DocumentRemark;
use App\Models\DocComment;
use App\Models\Application;
use App\Models\Add_Document;
use App\Models\AssessorApplication; 
use App\Models\User; 
use App\Models\Chapter; 
use App\Models\TblNCComments; 
use Carbon\Carbon;
use URL;
class DesktopApplicationController extends Controller
{
    public function __construct()
    {
    }
    /** Application List For Account */
    public function getApplicationList(){
        $assessor_id = Auth::user()->id;
        $assessor_application = DB::table('tbl_assessor_assign')
        ->where('assessor_id',$assessor_id)
        ->pluck('application_id')->toArray();
            $application = DB::table('tbl_application')
            ->whereIn('payment_status',[1,2,3])
            ->whereIn('id',$assessor_application)
            ->get();
            foreach($application as $app){
                $obj = new \stdClass;
                $obj->application_list= $app;
                    $course = DB::table('tbl_application_courses')->where([
                        'application_id' => $app->id,
                    ])->count();
                    if($course){
                        $obj->course_count = $course;
                    }
                    $payment = DB::table('tbl_application_payment')->where([
                        'application_id' => $app->id,
                    ])->latest('created_at')->first();
                    $payment_amount = DB::table('tbl_application_payment')->where([
                        'application_id' => $app->id,
                    ])->sum('amount');
                    $payment_count = DB::table('tbl_application_payment')->where([
                        'application_id' => $app->id,
                    ])->count();
                    if($payment){
                        $obj->payment = $payment;
                        $obj->payment->payment_count = $payment_count;
                        $obj->payment->payment_amount = $payment_amount ;
                    }
                    $final_data[] = $obj;
            }
        return view('desktop-view.application-list',['list'=>$final_data]);
    }
    /** Whole Application View for Account */
    public function getApplicationView($id){
        $application = DB::table('tbl_application')
        ->where('id', dDecrypt($id))
        ->first();
        $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->latest('id')->first();
            $obj = new \stdClass;
            $obj->application= $application;
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $application->id,
                ])->get();
                if($course){
                    $obj->course = $course;
                }
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                ])->get();
                if($payment){
                    $obj->payment = $payment;
                }
                $final_data = $obj;
        return view('desktop-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status]);
    }
    public function applicationDocumentList($id, $course_id)
    {
        $tp_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;
        $data = TblApplicationPayment::where('application_id',$application_id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
        ])->select('id','doc_unique_id','doc_file_name','doc_sr_code','status')->get();

        $chapters = Chapter::all();
        foreach($chapters as $chapter){
            $obj = new \stdClass;
            $obj->chapters= $chapter;
            
            $questions = DB::table('questions')->where([
                    'chapter_id' => $chapter->id,
                ])->get();

                foreach ($questions as $k => $question) {
                    $obj->questions[] = [
                        'question' => $question,
                        'nc_comments' => TblNCComments::where([
                            'application_id' => $application_id,
                            'application_courses_id' => $course_id,
                            'doc_unique_id' => $question->id,
                            'doc_sr_code' => $question->code
                        ])
                        ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
                        ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
                        ->get(),
                    ];
                }

                $final_data[] = $obj;
        }
        // dd($final_data);
        $applicationData = TblApplication::find($application_id);
        return view('desktop-view.application-documents-list', compact('final_data', 'course_doc_uploaded','application_id','course_id'));
    }
    public function desktopVerfiyDocument($doc_sr_code, $doc_name, $application_id, $doc_unique_code)
    {
        try{
        $doc_latest_record = TblApplicationCourseDoc::latest('id')
        ->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
        ->first();
        $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
        return view('desktop-view.document-verify', [
            'doc_latest_record' => $doc_latest_record,
            'doc_id' => $doc_sr_code,
            'doc_code' => $doc_unique_code,
            'application_id' => $application_id,
            'doc_path' => $doc_path,
        ]);
    }catch(Exception $e){
        return back()->with('fail','Something went wrong');
    }
    }

    public function desktopDocumentVerify(Request $request)
    {
        try{
        DB::beginTransaction();
        $assessor_id = Auth::user()->id;
        $assessor_type = Auth::user()->assessment===1?'desktop':'onsite';

        $data = [];
        $data['application_id'] = $request->application_id;
        $data['doc_sr_code'] = $request->doc_sr_code;
        $data['doc_unique_id'] = $request->doc_unique_id;
        $data['application_courses_id'] = $request->application_courses_id;
        $data['assessor_type'] = $assessor_type;
        $data['comments'] = $request->comments;
        $data['nc_type'] = $request->nc_type;
        $data['assessor_id'] = $assessor_id;

        $nc_comment_status="";
        if($request->nc_type==="accept"){
            $nc_comment_status=1;
        }else if($request->nc_type==="nc1"){
            $nc_comment_status=2;
        }else if($request->nc_type==="nc2"){
            $nc_comment_status=3; 
        }else{
            $nc_comment_status=4; //not recommended
        }


        $create_nc_comments = TblNCComments::insert($data);
        
        TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'assessor_type'=>$assessor_type,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id])->update(['status'=>$nc_comment_status]);

        if($create_nc_comments){
            DB::commit();
            return response()->json(['success' => true,'message' =>'Nc comments created successfully'],200);
        }else{
            return response()->json(['success' => false,'message' =>'Failed to create nc and documents'],200);
        }
    }catch(Exception $e){
        DB::rollBack();
        return response()->json(['success' => false,'message' =>'Something went wrong'],200);
    }
    }
}