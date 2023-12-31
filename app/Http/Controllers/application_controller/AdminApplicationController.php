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
class AdminApplicationController extends Controller
{
    public function __construct()
    {
    }
    public function getApplicationList(){
        $application = DB::table('tbl_application as a')
        ->whereIn('a.payment_status',[1,2,3])
        ->orderBy('id','desc')
        ->get();
        
        $desktop_assessor_list = DB::table('users')->where(['assessment'=>1,'role'=>3])->orderBy('id', 'DESC')->get();
        $desktop_assessor_pluck = DB::table('users')->where(['assessment'=>1,'role'=>3])->where(['assessment'=>2,'role'=>3])->orderBy('id', 'DESC')->pluck(
            'id'
        )->toArray();
        $onsite_assessor_list = DB::table('users')->where(['assessment'=>2,'role'=>3])->orderBy('id', 'DESC')->get();
        $secretariatdata = DB::table('users')->where('role', '5')->orderBy('id', 'DESC')->get();
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
                $doc_uploaded_count = DB::table('tbl_application_course_doc')->where(['application_id' => $app->id])->count();
                $obj->doc_uploaded_count = $doc_uploaded_count;
                if($payment){
                    $obj->payment = $payment;
                    $obj->payment->payment_count = $payment_count;
                    $obj->payment->payment_amount = $payment_amount ;
                }
                $final_data[] = $obj;
        }
        // dd($final_data);
        
        return view('admin-view.application-list',['list'=>$final_data, 'assessor_list' => $desktop_assessor_list,'secretariatdata' => $secretariatdata,'assessor_pluck'=>$desktop_assessor_pluck]);
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
        return view('admin-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status]);
    }
    public function adminPaymentAcknowledge(Request $request)
    {
        try{
            $application = TblApplication::find($request->post('application_id'));
            $is_exists = DB::table('tbl_application_payment')->where('aknowledgement_id',null)->first();
            if(!$is_exists){
                return response()->json(['success' =>false,'message'=>'Payment Acknowledgement Already Done'], 409);
            }
            DB::beginTransaction();
            DB::table('tbl_application_payment')->update(['aknowledgement_id' => auth()->user()->id]);
            DB::commit();
            return response()->json(['success' => true,'message' => 'Payment acknowledged successfully'], 200);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' =>false,'message'=>'Failed to make acknowledged payment'], 500);
        }
    }
    public function assignAssessor(Request $request){
        try{
            DB::beginTransaction();
            $data = [];
            $data['application_id']=$request->application_id;
            $data['assessor_id']=$request->assessor_id;
            $data['course_id']=$request->course_id??null;
            $data['assessor_type']=Auth::user()->assessment==1?'desktop':'onsite';
            $data['due_date']=Carbon::now()->addDay(365);
            $is_assign_assessor_date = DB::table('tbl_assessor_assign')->where(['application_id'=>$request->application_id,'assessor_id'=>$request->assessor_id,'assessor_type'=>$request->assessor_type])->first();
            if($is_assign_assessor_date!=null){
                $update_assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id'=>$request->application_id,'assessor_id'=>$request->assessor_id,'assessor_type'=>$request->assessor_type])->update($data);
            }else{
                $create_assessor_assign = DB::table('tbl_assessor_assign')->insert($data);
            }
            if($request->assessor_type==="desktop"){
                $assessment_type = 1;
            }else{
                $assessment_type = 2;
            }
            if ($request->assessment_type == 2) {
                $data = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessor_id', '=', $request->assessor_radio)->count()  > 0;
                if ($data == false) {
                    $value = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessment_type', '=', '2')->count() > 0;
                    if ($value == false) {
                        $data = new asessor_application();
                        $data->assessor_id = $request->assessor_radio;
                        $data->application_id = $request->application_id;
                        $data->status = 1;
                        $data->assessment_type = $request->assessment_type;
                        $data->due_date = $due_date = Carbon::now()->addDay(15);
                        $data->notification_status = 0;
                        $data->read_by = 0;
                        $data->assessment_way = $request->on_site_type;
                        $data->save();
                        return  back()->with('success', 'Application has been successfully assigned to assessor');
                    } else {
                        $item = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessment_type', '=', '2')->first();
                        $data = asessor_application::find($item->id);
                        $data->assessor_id = $request->assessor_radio;
                        $data->application_id = $request->application_id;
                        $data->status = 1;
                        $data->assessment_type = $request->assessment_type;
                        $data->due_date = $due_date = Carbon::now()->addDay(15);
                        $data->notification_status = 0;
                        $data->read_by = 0;
                        $data->assessment_way = $request->on_site_type;
                        $data->save();
                        return  back()->with('success', 'Application has been successfully assigned to assessor');
                    }
                } else {
                    $value = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessor_id', '=', $request->assessor_radio)->first();
                    //dd($value);
                    $data = asessor_application::find($value->id);
                    $data->assessor_id = $request->assessor_radio;
                    $data->application_id = $request->application_id;
                    $data->status = 1;
                    $data->assessment_type = $request->assessment_type;
                    $data->due_date = $due_date = Carbon::now()->addDay(15);
                    $data->notification_status = 0;
                    $data->read_by = 0;
                    $data->assessment_way = $request->on_site_type;
                    $data->save();
                    DB::commit();
                    return redirect()->route('admin-app-list')->with('success', 'Application has been successfully assigned to assessor');
                }
            } else {
                AssessorApplication::where('application_id', $request->application_id)->delete();
                $assessor = $request->assessor_id;
                $newApplicationAssign = new AssessorApplication;
                $newApplicationAssign->application_id = $request->application_id;
                $newApplicationAssign->assessment_type = $request->assessment_type;
                $newApplicationAssign->assessor_id = $assessor;
                $newApplicationAssign->status = 1;
                $newApplicationAssign->notification_status = 0;
                $newApplicationAssign->read_by = 0;
                $newApplicationAssign->save();
                $superadminEmail = 'superadmin@yopmail.com';
                $adminEmail = 'admin@yopmail.com';
                $mailData = [
                    'from' => "Admin",
                    'applicationNo' => $request->application_id,
                    'applicationStatus' => "Admin Assigned Application to Assessor Successfully",
                    'subject' => "Application Assigned",
                ];
                // Mail::to([$superadminEmail, $adminEmail])->send(new SendMail($mailData));
                $assessor_email = User::select('email')->where('id', $assessor)->first();
                $mailData = [
                    'from' => "Admin",
                    'applicationNo' => $request->application_id,
                    'applicationStatus' => "Admin Assigned Application to Assessor Successfully",
                    'subject' => "Application Assigned",
                ];
                // Mail::to($assessor_email)->send(new SendMail($mailData));
                DB::commit();
                return redirect()->route('admin-app-list')->with('success', 'Application has been successfully assigned to assessor');
            }
        }
        catch(Exception $e){
            DB::rolback();
            return redirect()->back()->with('fail', $e->getMessage());
        }
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
        ->select('id','doc_unique_id','doc_file_name','doc_sr_code','admin_nc_flag','assessor_type','status')
        ->get();
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
        return view('admin-view.application-documents-list', compact('final_data', 'course_doc_uploaded','application_id','course_id'));
    }
    public function adminVerfiyDocument($nc_type,$doc_sr_code, $doc_name, $application_id, $doc_unique_code)
    {
        try{
            $nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->latest('id')
            ->get();
            $tbl_nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])->latest('id')->first();
            $form_view=0;
            if($nc_type==="nr" && ($tbl_nc_comments->nc_type!=="Reject") && ($tbl_nc_comments->nc_type!=="Accept")){
                $form_view=1;
            }else if($nc_type=="reject"){
                $form_view=0;
            }
            // dd($form_view);
        if(isset($tbl_nc_comments->nc_type)){
                if($tbl_nc_comments->nc_type==="not_recommended"){
                    $dropdown_arr = array(
                                "Reject"=>"Reject",
                                "Accept"=>"Accept",
                                "Request_For_Final_Approval"=>'Request For Final Approval'
                            );
                }
       }
        $doc_latest_record = TblApplicationCourseDoc::latest('id')
        ->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
        ->first();
        // $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
        $doc_path = URL::to("/level").'/'.$doc_name;
        return view('admin-view.document-verify', [
            'doc_latest_record' => $doc_latest_record,
            'doc_id' => $doc_sr_code,
            'doc_code' => $doc_unique_code,
            'application_id' => $application_id,
            'doc_path' => $doc_path,
            'dropdown_arr'=>$dropdown_arr??[],
            'nc_comments'=>$nc_comments,
            'form_view'=>$form_view,
        ]);
    }catch(Exception $e){
        return back()->with('fail','Something went wrong');
    }
    }
    public function adminDocumentVerify(Request $request)
    {
        try{
        $redirect_to=URL::to("/admin/document-list").'/'.dEncrypt($request->application_id).'/'.dEncrypt($request->application_courses_id);
        DB::beginTransaction();
        $assessor_id = Auth::user()->id;
        $assessor_type = 'admin';
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
        $admin_nc_flag=0;
        if($request->nc_type==="Accept"){
            $nc_comment_status=1;
            $admin_nc_flag=1;
            $nc_flag=0;
        }else if($request->nc_type=="Reject"){
            $nc_comment_status=1;
            $admin_nc_flag=2;
            $nc_flag=0;
        }else{
            $nc_comment_status=4; //request for final approval
            $nc_flag=1;
        }
        $create_nc_comments = TblNCComments::insert($data);
        TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'status'=>4])->update(['nc_flag'=>$nc_flag,'admin_nc_flag'=>$admin_nc_flag]);
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
}
