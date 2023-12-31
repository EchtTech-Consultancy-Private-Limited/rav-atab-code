<?php
namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Models\TblApplication; 
use App\Models\TblApplicationPayment; 
use App\Models\TblApplicationCourseDoc; 
use App\Models\TblApplicationCourses; 
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
            ->orderBy('id','desc')
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
                $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id])->first();
                if(!empty($is_exists)){
                    $is_final_submit = true;
                }else{
                    $is_final_submit = false;
                }
        return view('desktop-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit]);
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
        ])
        ->select('id','doc_unique_id','doc_file_name','doc_sr_code','assessor_type','status')
        ->get();

        $doc_uploaded_count = DB::table('tbl_nc_comments as asr')
        ->select("asr.application_id","asr.application_courses_id")
        ->where('asr.assessor_type','desktop')
        ->where(['application_id' => $application_id, 'application_courses_id' => $course_id])
        ->groupBy('asr.application_id','asr.application_courses_id')
        ->count();
        /*end here*/
        $is_doc_uploaded=false;
        if($doc_uploaded_count>=4){
            $is_doc_uploaded=true;
        }

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
                        ->where('assessor_type','desktop')
                        ->get(),
                    ];
                }

                $final_data[] = $obj;
        }
        $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application_id,'application_course_id'=> $course_id])->first();
       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }
        $applicationData = TblApplication::find($application_id);
        return view('desktop-view.application-documents-list', compact('final_data', 'course_doc_uploaded','application_id','course_id','is_final_submit','is_doc_uploaded'));
    }

    public function desktopVerfiyDocument($nc_type,$doc_sr_code, $doc_name, $application_id, $doc_unique_code)
    {
        try{
   
            $nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->latest('id')
            ->get();

            $tbl_nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])->latest('id')->first();
        
            $is_nc_exists=false;
            if($nc_type==="view"){
                $is_nc_exists=true;
            }

        if(isset($tbl_nc_comments->nc_type)){
            if($tbl_nc_comments->nc_type==="NC1"){
                $dropdown_arr = array(
                            "NC2"=>"NC2",
                            "Accept"=>"Accept",
                        );
             }else if($tbl_nc_comments->nc_type==="NC2"){
                $dropdown_arr = array(
                            "not_recommended"=>"Not Recommended",
                            "Accept"=>"Accept",
                        );
             }else if($tbl_nc_comments->nc_type==="not_recommended"){
                $dropdown_arr = array(
                            "Reject"=>"Reject",
                            "Accept"=>"Accept",
                        );
             }else if($tbl_nc_comments->nc_type==="Request_For_Final_Approval"){
                $dropdown_arr = array(
                    "Reject"=>"Reject",
                    "Accept"=>"Accept",
                );
             }
        }else{
            $dropdown_arr = array(
                "NC1"=>"NC1",
                "Accept"=>"Accept",
            );
        }



        $doc_latest_record = TblApplicationCourseDoc::latest('id')
        ->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
        ->first();
        // $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
        $doc_path = URL::to("/level").'/'.$doc_name;
         
        return view('desktop-view.document-verify', [
            // 'doc_latest_record' => $doc_latest_record,
            'doc_id' => $doc_sr_code,
            'doc_code' => $doc_unique_code,
            'application_id' => $application_id,
            'doc_path' => $doc_path,
            'dropdown_arr'=>$dropdown_arr??[],
            'is_nc_exists'=>$is_nc_exists,
            'nc_comments'=>$nc_comments,
        ]);
    }catch(Exception $e){
        return back()->with('fail','Something went wrong');
    }
    }

    // submit nc's
    public function desktopDocumentVerify(Request $request)
    {
        try{
          
        $redirect_to=URL::to("/desktop/document-list").'/'.dEncrypt($request->application_id).'/'.dEncrypt($request->application_courses_id);
       
        DB::beginTransaction();
        $assessor_id = Auth::user()->id;
        $assessor_type = Auth::user()->assessment==1?"desktop":"onsite";

        /*end here*/
        $data = [];
        $data['application_id'] = $request->application_id;
        $data['doc_sr_code'] = $request->doc_sr_code;
        $data['doc_unique_id'] = $request->doc_unique_id;
        $data['application_courses_id'] = $request->application_courses_id;
        $data['assessor_type'] = $assessor_type;
        $data['comments'] = $request->comments;
        $data['nc_type'] = $request->nc_type;
        $data['assessor_id'] = $assessor_id;
        $data['doc_file_name'] = $request->doc_file_name;

        $nc_comment_status="";
        $nc_raise="";
        if($request->nc_type==="Accept"){
            $nc_comment_status=1;
            $nc_flag=0;
            $nc_raise="Accept";
        }else if($request->nc_type=="NC1"){
            $nc_comment_status=2;
            $nc_flag=1;
            $nc_raise = "NC1";
        }else if($request->nc_type=="NC2"){
            $nc_comment_status=3;
            $nc_flag=1; 
            $nc_raise = "NC2";
        }
        else if($request->nc_type=="Reject"){
            $nc_comment_status=6;
            $nc_flag=0; 
            $nc_raise = "Reject";
        }
        else{
            $nc_comment_status=4; //not recommended
            $nc_flag=0;
            $nc_raise="Request for final approval";
        }

        $create_nc_comments = TblNCComments::insert($data);
        
        TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'assessor_type'=>$assessor_type,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'status'=>0])->update(['status'=>$nc_comment_status,'nc_flag'=>$nc_flag]);

        /*Create record for summary report*/
        $data=[];
        $data['application_id'] = $request->application_id;
        $data['object_element_id'] = $request->doc_unique_id;
        $data['application_course_id'] = $request->application_courses_id;
        $data['doc_sr_code'] = $request->doc_sr_code;
        $data['doc_unique_id'] = $request->doc_unique_id;
        
        $data['date_of_assessement'] = $request->date_of_assessement??'N/A';
        $data['assessor_id'] = Auth::user()->id;
        $data['assessor_type'] = $assessor_type;
        $data['nc_raise'] = $nc_raise??'N/A';
        $data['nc_raise_code'] = $nc_raise??'N/A';
        $data['doc_path'] = $request->doc_file_name;
        $data['capa_mark'] = $request->capa_mark??'N/A';
        $data['doc_against_nc'] = $request->doc_against_nc??'N/A';
        $data['doc_verify_remark'] = $request->remark??'N/A';
        $create_summary_report = DB::table('assessor_summary_reports')->insert($data);
        /*end here*/
       

        if($create_nc_comments){
            DB::commit();
            return response()->json(['success' => true,'message' =>'Nc comments created successfully','redirect_to'=>$redirect_to],200);
        }else{
            return response()->json(['success' => false,'message' =>'Failed to create nc and documents'],200);
        }
    }catch(Exception $e){
        DB::rollBack();
        return response()->json(['success' => false,'message' =>'Something went wrong'],200);
    }
    }


    public function getCourseSummariesList(Request $request){

        $get_all_final_course_id = DB::table('assessor_final_summary_reports')->where('application_id',$request->input('application'))->get()->pluck('application_course_id')->toArray();

        $courses = TblApplicationCourses::where('application_id', $request->input('application'))
        ->whereIn("id",$get_all_final_course_id)
        ->get();

        $applicationDetails = TblApplication::find($request->input('application'));
        return view('desktop-view.course-summary-list', compact('courses', 'applicationDetails'));
    }


    public function desktopViewFinalSummary(Request $request){
        $assessor_id = Auth::user()->id;
        $application_id = $request->input('application');
        $application_course_id = $request->input('course');
        $summeryReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.person_name','app.id','app.created_at as app_created_at','app_course.course_name','usr.firstname','usr.middlename','usr.lastname')
        ->leftJoin('tbl_application as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('tbl_application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => $application_id,
            'asr.application_course_id' => $application_course_id,
            'app_course.application_id' => $application_id,
            'app_course.id' => $application_course_id,
            'asr.assessor_type' => 'desktop',
        ])
        ->first();
        /*count the no of mandays*/
        $no_of_mandays = DB::table('tbl_assessor_assign')->where(['assessor_id'=>$assessor_id,'application_id'=>$application_id])->count();
   
        $questions = DB::table('questions')->get();
            

        foreach($questions as $question){
            $obj = new \stdClass;
            $obj->title= $question->title;
            $obj->code= $question->code;
                    $value = TblNCComments::where([
                            'application_id' => $application_id,
                            'application_courses_id' => $application_course_id,
                            'doc_unique_id' => $question->id,
                            'doc_sr_code' => $question->code
                        ])
                        ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
                        ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
                        ->where('assessor_type','desktop')
                        ->get();
                      
                        $obj->nc = $value;
                        $final_data[] = $obj;
        }

    // foreach($questions as $question){
    //     $obj = new \stdClass;
    //     $obj->title= $question->title;
    //     $obj->code= $question->code;
    //         $value = DB::table('assessor_summary_reports')->where([
    //             'application_id' => $application_id,
    //             'assessor_id' => $assessor_id,
    //             'object_element_id' => $question->id,
    //             'doc_sr_code' => $question->code,
    //         ])->get();
    //             $obj->nc = $value;
    //             $final_data[] = $obj;
    // }
    // dd($final_data);
    $assessement_way = DB::table('asessor_applications')->where(['application_id'=>$application_id])->get();
      
        return view('desktop-view.desktop-view-final-summary',compact('summeryReport', 'no_of_mandays','final_data','assessement_way'));
    }
}
