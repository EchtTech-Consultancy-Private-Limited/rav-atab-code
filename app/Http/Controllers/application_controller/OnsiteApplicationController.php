<?php

namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Models\TblApplication; 
use App\Models\TblApplicationPayment; 
use App\Models\TblApplicationCourseDoc; 
use App\Models\TblApplicationCourses; 
use Illuminate\Http\Request;
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
use App\Jobs\SendEmailJob;
class OnsiteApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
     
    /** Application List For Account */
    public function getApplicationList(){

        $assessor_id = Auth::user()->id;
            $assessor_application = DB::table('tbl_assessor_assign')
            ->where('assessor_id',$assessor_id)
            ->pluck('application_id')->toArray();
            $final_data=array();
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
                ])
                ->whereNull('deleted_at') 
                ->count();
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
        
        return view('onsite-view.application-list',['list'=>$final_data]);
    }


    public function getApplicationView($id){
        $application = DB::table('tbl_application')
        ->where('id', dDecrypt($id))
        ->first();
        $assessor_id = Auth::user()->id;
        $show_submit_btn_to_onsite = $this->isShowSubmitBtnToSecretariat(dDecrypt($id));
        $enable_disable_submit_btn = $this->checkSubmitButtonEnableOrDisable(dDecrypt($id));
        $is_all_revert_action_done=$this->checkAllActionDoneOnRevert(dDecrypt($id));
        
        $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->latest('id')->first();
            $obj = new \stdClass;
            $obj->application= $application;
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $application->id,
                ])
                ->whereIn('status',[0,2])
                ->whereNull('deleted_at') 
                ->get();
                if($course){
                    $c = [];
                    foreach($course as $crse){
                        $course_doc_count = DB::table('tbl_application_course_doc')->where(['application_id'=>$application->id,'application_courses_id'=>$crse->id])->count();
                        $crse->is_doc_uploaded = $course_doc_count;
                        
                    }
                    $obj->course = $course;
                }
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                ])->get();
                if($payment){
                    $obj->payment = $payment;
                }
                $final_data = $obj;
                // $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id,'assessor_type'=>'onsite'])->first();
                // if(!empty($is_exists)){
                //     $is_final_submit = true;
                // }else{
                //     $is_final_submit = false;
                // }
                

                    $total_summary_count = DB::table('assessor_final_summary_reports')->where(['application_id' => $application->id])
                    ->where('is_summary_show',1)
                    ->count();
                    $total_courses_count = DB::table('tbl_application_courses')->where('application_id',$application->id)->whereIn('status',[0,2])->count();

                    $is_in_improvement = DB::table('assessor_improvement_form')->where('application_id',$application->id)->first();

                    if (($total_summary_count>=$total_courses_count) && !empty($is_in_improvement) && $total_courses_count!=0) {
                        $is_final_submit = true;
                    } else {
                        $is_final_submit = false;
                    }


                    $total_summary_count = DB::table('assessor_final_summary_reports')->where(['application_id' => $application->id,'assessor_type'=>'onsite'])->count();

                    $is_submitted_final_summary = DB::table('assessor_final_summary_reports')->where(['application_id' => $application->id,'assessor_type'=>'onsite'])->latest('id')->first()?->is_summary_show;

                    $ofi = DB::table('assessor_improvement_form')->where('application_id',$application->id)->first();
                    
                    if(!empty($ofi)){
                        $isOFIExists=true;
                    }else{
                        $isOFIExists=false;
                    }

                    if(!isset($is_submitted_final_summary)){
                        $is_submitted_final_summary=0;
                    }
                    $total_courses_count = DB::table('tbl_application_courses')->where('application_id',$application->id)->whereIn('status',[0,2])->count();

                    // $is_submitted_final_summary = DB::table('assessor_final_summary_reports')->where(['application_id' => $application->id,'assessor_type'=>'onsite'])->latest('id')->first()?->is_summary_show;


                    if(!isset($is_submitted_final_summary)){
                        $is_submitted_final_summary=0;
                    }
                    
                    if ($total_summary_count==$total_courses_count) {
                        $is_all_course_summary_completed=true;
                    } else {
                        $is_all_course_summary_completed=false;
                    }

                return view('onsite-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit,'show_submit_btn_to_onsite'=>$show_submit_btn_to_onsite,'enable_disable_submit_btn'=>$enable_disable_submit_btn,'is_all_revert_action_done'=>$is_all_revert_action_done,'is_all_course_summary_completed'=>$is_all_course_summary_completed,'is_submitted_final_summary'=>$is_submitted_final_summary,'isOFIExists'=>$isOFIExists]);
    }

    public function onsiteGenerateFinalSummary(Request $request)
    {
        try {
            DB::beginTransaction();
            $app_id = dDecrypt($request->app_id);
            $isUpdate = DB::table('assessor_final_summary_reports')->where(['application_id'=>$app_id,'assessor_type'=>'onsite'])->update(['is_summary_show'=>1]);
            if($isUpdate){
                DB::commit();
                return back()->with('success', 'Final summary generated successfully.');
            }else{
                DB::rollBack();
                return back()->with('fail', 'Failed to generate final summary.');
            }

            
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }

    /** Whole Application View for Onsite assessor */
    public function applicationDocumentList($id, $course_id)
    {
        
        $assessor_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;
        $application_uhid = TblApplication::where('id',$application_id)->first()->uhid??'';
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'assessor_type'=>'desktop'
        ])
        ->select('id','doc_unique_id','doc_file_name','doc_sr_code','assessor_type','onsite_status','admin_nc_flag','status','is_revert','is_doc_show')
        ->get();

        $onsite_course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'assessor_type'=>'onsite'
        ])
        ->select('id','doc_unique_id','doc_file_name','doc_sr_code','assessor_type','onsite_status','onsite_doc_file_name','status','onsite_photograph','admin_nc_flag','is_revert','is_doc_show')
        ->get();

        $doc_uploaded_count = DB::table('tbl_nc_comments as asr')
        ->select("asr.application_id","asr.application_courses_id")
        ->where('asr.assessor_type','onsite')
        ->where(['application_id' => $application_id, 'application_courses_id' => $course_id,'assessor_id' => $assessor_id])
        ->groupBy('asr.application_id','asr.application_courses_id')
        ->count();
        /*end here*/
        // dd($onsite_course_doc_uploaded );
      
        $is_doc_uploaded=false;
        if($doc_uploaded_count>=4){
            $is_doc_uploaded=true;
        }
        
        $show_submit_btn_to_secretariat = $this->isShowSubmitBtnToSecretariat($application_id);
        $enable_disable_submit_btn = $this->checkSubmitButtonEnableOrDisable($application_id);
        $is_all_revert_action_done=$this->checkAllActionDoneOnRevert($application_id);
        $isCreateSummaryBtnShow = $this->isCreateSummaryBtnShow($application_id,$course_id);
       
        $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application_id,'application_course_id'=> $course_id,'assessor_type'=>'onsite'])->first();
       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }

       $assessor_designation = DB::table('tbl_assessor_assign')
        ->where('application_id',$application_id)
        ->where('assessor_id',Auth::user()->id)
        ->first();

        $desktopData = $this->onsiteApplicationDocumentList($application_id, $course_id);
        $application_details = DB::table('tbl_application')->where('id',$application_id)->first();

        $encrypted_app_id = $id;
        $encrypted_course_id = dEncrypt($course_id);

        
    //    dd($onsite_course_doc_uploaded);
        return view('onsite-view.application-documents-list', compact('desktopData', 'course_doc_uploaded','onsite_course_doc_uploaded','application_id','course_id','is_final_submit','is_doc_uploaded','application_uhid','show_submit_btn_to_secretariat','enable_disable_submit_btn','is_all_revert_action_done','application_details','assessor_designation','encrypted_app_id','encrypted_course_id','isCreateSummaryBtnShow'));
    }

   
    public function onsiteApplicationDocumentList($id, $course_id)
    {
        $tp_id = Auth::user()->id;
        $application_id = $id;
        
        
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
                        'onsite_nc_comments' => TblNCComments::where([
                            'application_id' => $application_id,
                            'application_courses_id' => $course_id,
                            // 'assessor_type' => 'onsite',
                            'doc_unique_id' => $question->id,
                            'doc_sr_code' => $question->code,
                        ])
                        ->where('nc_type',"!=",null)
                        ->whereIn('assessor_type',['onsite','admin'])
                        ->where(function ($query) {
                            $query->where('assessor_type', 'onsite')
                                ->orWhere('assessor_type', 'admin')
                                ->where('final_status', 'onsite');
                        })
                        ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
                        ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
                        ->get(),


                        'onsite_photograph' =>DB::table('tbl_onsite_photograph')->where([
                            'application_id' => $application_id,
                            'application_courses_id' => $course_id,
                            'assessor_type' => 'onsite',
                            'doc_unique_id' => $question->id,
                            'doc_sr_code' => $question->code
                        ])
                        ->latest('id')
                        ->select('onsite_photograph')
                        ->first()
                    ];
                }

                $final_data[] = $obj;

        }

        return $final_data;
        
    }


    public function onsiteVerfiyDocument($nc_type,$doc_sr_code, $doc_name, $application_id, $doc_unique_code,$application_course_id)
    {
        
        try{   
            if($nc_type == 'nr')
            {
                $nc_type = 'not_recommended';
            } 
            $nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code,'nc_type'=>$nc_type])
            ->whereIn('assessor_type',['onsite','admin'])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->first();     

            $tbl_nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'application_courses_id'=>$application_course_id,'doc_unique_id' => $doc_unique_code,'assessor_type'=>'onsite'])->latest('id')->first();
            
            
            $all_assessor = DB::table('tbl_assessor_assign')->where('application_id',$application_id)->get();
            $view_form = false;
            foreach($all_assessor as $ass){
                if(($ass->assessor_id==Auth::user()->id) && $ass->assessor_designation=="Lead Assessor"){
                    $view_form = true;
                    break;
                }
            }


            $is_nc_exists=false;
            if($nc_type=="view" && $view_form){
                $is_nc_exists=true;
            }

            
            // dd($doc_sr_code, $doc_unique_code);
           
        if(isset($tbl_nc_comments->nc_type)){
           
            if($tbl_nc_comments->nc_type=="NC1"){
                $dropdown_arr = array(
                            "NC2"=>"NC2",
                            "Accept"=>"Accept",
                        );
             }else if($tbl_nc_comments->nc_type=="NC2"){
                $dropdown_arr = array(
                            "not_recommended"=>"Needs Revision",
                            "Accept"=>"Accept",
                        );
             }else if($tbl_nc_comments->nc_type=="not_recommended"){
                $dropdown_arr = array(
                            "Reject"=>"Reject",
                            "Accept"=>"Accept",
                        );
             }else if($tbl_nc_comments->nc_type=="Request_For_Final_Approval"){
                $dropdown_arr = array(
                    "Reject"=>"Reject",
                    "Accept"=>"Accept",
                );
             }else{
                $dropdown_arr = array(
                    "NC1"=>"NC1",
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
        ->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code,'assessor_type'=>'onsite'])
        ->first();
        // $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
        $doc_path = URL::to("/level").'/'.$doc_name;
         
        return view('onsite-view.document-verify', [
            // 'doc_latest_record' => $doc_latest_record,
            'doc_id' => $doc_sr_code,
            'doc_code' => $doc_unique_code,
            'doc_file_name'=>$doc_name,
            'application_id' => $application_id,
            'doc_path' => $doc_path,
            'dropdown_arr'=>$dropdown_arr??[],
            'is_nc_exists'=>$is_nc_exists,
            'nc_comments'=>$nc_comments,
            'application_course_id'=>$application_course_id
        ]);
    }catch(Exception $e){
        return back()->with('fail','Something went wrong');
    }
    }

     // submit nc's
     public function onsiteDocumentVerify(Request $request)
     {
         try{
         $redirect_to=URL::to("/onsite/document-list").'/'.dEncrypt($request->application_id).'/'.dEncrypt($request->application_courses_id);
        
         DB::beginTransaction();
         $assessor_id = Auth::user()->id;
         $assessor_type = Auth::user()->assessment==1?"desktop":"onsite";


        /*get last record of desktop*/
        $last_course_doc_desktop =  TblApplication::where(['id'=> $request->application_id])->first();
        /*end here*/

        if($request->nc_type=="Accept" && $request->comments==""){
            $nc_type="Accept";
            $doc_comment="Document has been approved";
         }else{
             $nc_type=$request->nc_type;
             $doc_comment=$request->comments;
         }



         $data = [];

         if ($request->hasfile('fileup')) {
            $file = $request->file('fileup');
            $name = $file->getClientOriginalName();
            $filename = time() . $name;
            $file->move('level/', $filename);
            $data['doc_file_name'] = $filename;
        }

         /*end here*/
         $data['application_id'] = $request->application_id;
         $data['doc_sr_code'] = $request->doc_sr_code;
         $data['doc_unique_id'] = $request->doc_unique_id;
         $data['application_courses_id'] = $request->application_courses_id;
         $data['assessor_type'] = $assessor_type;
         $data['assessor_id'] = $assessor_id;
         $data['comments'] = $doc_comment;
         $data['nc_type'] = $nc_type;
        //  $data['status'] = 1;

         $nc_comment_status="";
         $nc_raise="";
         if($request->nc_type=="Accept"){
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

         $get_last_nc = TblNCComments::where(['application_id'=>$request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'assessor_type'=>'onsite','nc_type'=>$nc_raise])->select('id')->latest('id')->first();

         $onsite_data = [];
         $onsite_data['application_id'] = $request->application_id;
         $onsite_data['doc_sr_code'] = $request->doc_sr_code;
         $onsite_data['doc_unique_id'] = $request->doc_unique_id;
         $onsite_data['application_courses_id'] = $request->application_courses_id;
         $onsite_data['assessor_type'] = $assessor_type;
         $onsite_data['assessor_id'] = $assessor_id;
         $onsite_data['onsite_doc_file_name'] = $filename;
         $onsite_data['onsite_status'] = $nc_comment_status;
         $onsite_data['onsite_nc_status'] = $nc_flag;
         $onsite_data['onsite_nc_type'] = $nc_raise;
         $onsite_data['tp_id'] = $last_course_doc_desktop->tp_id;
         $onsite_data['is_doc_show'] = 0;
         
         $get_last_doc_of_onsite = TblApplicationCourseDoc::where(['application_id'=>$request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'assessor_type'=>'onsite','onsite_nc_type'=>0])->latest('id')->first();

         if($get_last_doc_of_onsite){
            $create_nc_comments = TblApplicationCourseDoc::where('id',$get_last_doc_of_onsite->id)->update($onsite_data);
         }else{
            $create_nc_comments = TblApplicationCourseDoc::insert($onsite_data);
         }

         if($get_last_nc){
            TblNCComments::where(['application_id'=>$request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'assessor_type'=>'onsite'])->update($data);
         }else{
             $create_nc_comments = TblNCComments::insert($data);
         }
        

        $last_course_doc =  TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'assessor_type'=>'onsite','application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id])->latest('id')->first();
        




        if($last_course_doc){
            TblApplicationCourseDoc::where('id',$last_course_doc->id)->update(['onsite_status'=>$nc_comment_status,'onsite_nc_status'=>$nc_flag]);
        
        
        $tp_email = DB::table('users')->where('id',$last_course_doc->tp_id)->first()->email;

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
        
         //assessor email
        $title="Notification -  ".$request->nc_type." | RAVAP-".$request->application_id;
        $subject="Notification - ".$request->nc_type." | RAVAP-".$request->application_id;
        
        $body = "Dear ,".Auth::user()->firstname." ".PHP_EOL."
        I hope this email finds you well. I am writing to inform you that a NC has been generated for [document/project/process] in accordance with our quality management procedures.
        
        NC Details:

        Document Name: ".$request->doc_file_name."
        Document Sr. No.: ".$request->doc_sr_code."
        Date Created: ".date('d-m-Y')."

        NC Created By: ".Auth::user()->firstname."";

         $details['email'] = $tp_email;
         $details['title'] = $title; 
         $details['subject'] = $subject; 
         $details['body'] = $body; 
          if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
    }
 
         if($last_course_doc){
             DB::commit();
             return response()->json(['success' => true,'message' =>''.$request->nc_type.' comments created successfully','redirect_to'=>$redirect_to],200);
         }else{
             DB::rollBack();
             return response()->json(['success' => false,'message' =>'Failed to create '.$request->nc_type.'  and documents'],200);
         }
     }catch(Exception $e){
         DB::rollBack();
         return response()->json(['success' => false,'message' =>'Something went wrong'],200);
     }
     }
   

     public function onsiteUploadPhotograph(Request $request){
       
        try{
            DB::beginTransaction();
            $assessor_id  = Auth::user()->id;
            $application_id = $request->application_id;
            $application_courses_id = $request->application_courses_id;
            $doc_sr_code = $request->doc_sr_code;
            $doc_unique_id = $request->doc_unique_id;
            $doc_photograph_name = "";
            if ($request->hasfile('fileup_photograph')) {
                $file = $request->file('fileup_photograph');
                $name = $file->getClientOriginalName();
                $filename = time() . $name;
                $file->move('level/', $filename);
                $doc_photograph_name = $filename;
            }
                $photograph_data=[];
                $photograph_data['application_id'] = $application_id;
                $photograph_data['doc_sr_code'] = $doc_sr_code;
                $photograph_data['doc_unique_id'] = $doc_unique_id;
                $photograph_data['application_courses_id'] = $application_courses_id;
                $photograph_data['assessor_id'] = $assessor_id;
                $photograph_data['assessor_type'] = 'onsite';
                $photograph_data['onsite_photograph'] = $doc_photograph_name;

                $upload_photograph = DB::table('tbl_onsite_photograph')->insert($photograph_data);
            if($upload_photograph){
                DB::commit();
                return response()->json(['success' => true,'message' =>'Photograph uploaded successfully'],200);
            }else{
                DB::rollBack();
                return response()->json(['success' => false,'message' =>'Failed to upload photograph'],200);
            }
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' => false,'message' =>'Something went wrong'],200);
        }

     }

     public function getCourseSummariesList(Request $request){

        $get_all_final_course_id = DB::table('assessor_final_summary_reports')
        ->where('application_id',$request->input('application'))
        ->where('assessor_type','onsite')
        ->get()
        ->pluck('application_course_id')
        ->toArray();

        $courses = TblApplicationCourses::where('application_id', $request->input('application'))
        ->whereIn("id",$get_all_final_course_id)
        ->get();

        $assessor_designation = DB::table('tbl_assessor_assign')
        ->where('application_id',$request->input('application'))
        ->where('assessor_id',Auth::user()->id)
        ->first();
        $app_id = $request->input('application');
        
        $course_count = DB::table('tbl_application_courses')->where('application_id',$app_id)->whereIn('status',[0,2])->count();
        $is_all_course_summary_generated = false;
        if(count($get_all_final_course_id)==$course_count){
            $is_all_course_summary_generated=true;
        }
        

        $applicationDetails = TblApplication::find($request->input('application'));
        return view('onsite-view.course-summary-list', compact('courses', 'applicationDetails','assessor_designation','is_all_course_summary_generated'));
    }

    public function onsiteViewFinalSummary(Request $request){
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
            'asr.assessor_type' => 'onsite',
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
                        ->whereIn('assessor_type',['onsite','admin'])
                        ->get();
                      
                        $obj->nc = $value;
                        $final_data[] = $obj;
        }
    $assessement_way = DB::table('asessor_applications')->where(['application_id'=>$application_id])->get();
        return view('onsite-view.onsite-view-final-summary',compact('summeryReport', 'no_of_mandays','final_data','assessement_way'));
    }


    public function updateAssessorOnsiteNotificationStatus(Request $request,$id)
    {
        try{
          $request->validate([
              'id' => 'required',
          ]);
          DB::beginTransaction();
          $is_read = DB::table('tbl_notifications')->where('id',$id)->update(['is_read'=>"1"]);
          $d = DB::table('tbl_notifications')->where('id',$id)->first();
          
          if ($is_read) {
              DB::commit();
              return response()->json(['success' => true, 'message' => 'Read notification successfully.', 'redirect_url' => $d->url], 200);
          } else {
              DB::rollback();
              return response()->json(['success' => false,'message' =>'Notification Already read','redirect_url'=>$d->url],200);
          }
    }
    catch(Exception $e){
          DB::rollback();
          return response()->json(['success' => false,'message' =>'Failed to read notification'],200);
    }
    }


    // 


public function checkApplicationIsReadyForNextLevelDocList($application_id)
{
  
      
        $all_courses_id = DB::table('tbl_application_courses')->where('application_id', $application_id)->pluck('id');
  
      
        $results = DB::table('tbl_application_course_doc')
            ->select('application_id', 'application_courses_id','assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id','assessor_type')
            ->whereIn('application_courses_id', $all_courses_id)
            ->where('assessor_type','onsite')
            ->where('application_id', $application_id)
            ->where('approve_status',1)
            ->get();
      
            
            
        $additionalFields = DB::table('tbl_application_course_doc')
            ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                    ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                    ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
            })
            ->where('tbl_application_course_doc.assessor_type','onsite')
            ->orderBy('tbl_application_course_doc.id', 'desc')
            ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.onsite_status', 'id', 'admin_nc_flag','approve_status','assessor_type']);
            
            
        $finalResults = [];
        foreach ($results as $key => $result) {
            if ($result->assessor_type == 'onsite') {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('application_courses_id', $result->application_courses_id)
                ->where('doc_sr_code', $result->doc_sr_code)
                ->where('doc_unique_id', $result->doc_unique_id)
                ->where('approve_status',1)
                ->first();
                
            if ($additionalField) {
                $finalResults[$key] = (object)[];
                $finalResults[$key]->onsite_status = $additionalField->onsite_status;
                $finalResults[$key]->id = $additionalField->id;
                $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                $finalResults[$key]->assessor_type = $additionalField->assessor_type;
            }
         }
        }

        $flag = 0;
        $nc_flag = 0;
        $not_any_action_flag = 0;
        $total_courses = DB::table('tbl_application_courses')
        ->where('application_id',$application_id)
        ->whereIn('status',[0,2])
        ->whereNull('deleted_at')
        ->count();
        $total_onsite_final_summary = DB::table('assessor_final_summary_reports')
                            ->where('application_id',$application_id)
                            ->where('assessor_type','onsite')
                            ->count();
        if($total_courses==$total_onsite_final_summary){
            return "all_verified_f";
        }
        foreach ($finalResults as $result) {
            if ($result->onsite_status == 1 || ($result->onsite_status == 4 && $result->admin_nc_flag == 1)) {
                $flag = 0;
            } else {
                $flag = 1;
                break;
            }
        }
  
        foreach ($finalResults as $result) {
            if ($result->onsite_status != 0) {
                $nc_flag = 1;
                break;
            }
        }
        foreach ($finalResults as $result) {
            if ($result->onsite_status == 0) {
                $not_any_action_flag = 1;
                break;
            }
        }
  
        if ($flag == 0) {
          //   DB::table('tbl_application')->where('id', $application_id)->update(['is_all_course_doc_verified' => 1]);
            return "all_verified";
        }
        if ($not_any_action_flag == 1) {
            return "action_not_taken";
        }
  
        if ($nc_flag == 1) {
            return "valid";
        } else {
            return "notValid";
        }
  
}
  
function revertCourseDocListActionOnsite(Request $request){
        try{
            DB::beginTransaction();
            $get_course_doc = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'onsite_doc_file_name'=>$request->doc_file_name])->first();
                if($get_course_doc->onsite_status==4){
                    $revertAction = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'onsite_doc_file_name'=>$request->doc_file_name,'is_revert'=>0])->update(['onsite_status'=>0,'admin_nc_flag'=>0]);
 
                }else{
                    $revertAction = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'onsite_doc_file_name'=>$request->doc_file_name,'is_revert'=>0])->update(['onsite_status'=>0]);

                }
                    /*Delete nc on course doc*/ 
                    $delete_= DB::table('tbl_nc_comments')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name])->delete();
                    
                     /*end here*/            
            if($revertAction){
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Action reverted successfully.'], 200);
            }else{
                DB::rollBack();
                return response()->json(['success' =>false, 'message' => 'Failed to revert action.'], 200);
            }
        }catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' =>false, 'message' => 'Something went wrong!'], 200);
        }
}


public function isShowSubmitBtnToSecretariat($application_id)
{
    $results = DB::table('tbl_application_course_doc')
        ->select('application_id', 'application_courses_id', 'assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id', 'assessor_type')
        ->where('application_id', $application_id)
        ->where('approve_status', 1)
        ->get();

    $additionalFields = DB::table('tbl_application_course_doc')
        ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id, assessor_type) as sub'), function ($join) {
            $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
        })
        ->orderBy('tbl_application_course_doc.id', 'desc')
        ->where('tbl_application_course_doc.assessor_type','onsite')
        ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.onsite_status', 'id', 'admin_nc_flag', 'approve_status', 'assessor_type','is_revert']);

    
    $finalResults = [];
    foreach ($results as $key => $result) {
        if ($result->assessor_type == 'onsite') {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('application_courses_id', $result->application_courses_id)
                ->where('doc_sr_code', $result->doc_sr_code)
                ->where('doc_unique_id', $result->doc_unique_id)
                ->where('approve_status', 1)
                ->first();

            if ($additionalField) {
                $finalResults[$key] = (object)[];
                $finalResults[$key]->onsite_status = $additionalField->onsite_status;
                $finalResults[$key]->id = $additionalField->id;
                $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                $finalResults[$key]->approve_status = $additionalField->approve_status;
                $finalResults[$key]->assessor_type = $additionalField->assessor_type;
                $finalResults[$key]->is_revert = $additionalField->is_revert;
            }
        }
    }
    $flag = 0;
    
    $total_courses = DB::table('tbl_application_courses')
    ->where('application_id',$application_id)
    ->whereIn('status',[0,2])
    ->whereNull('deleted_at')
    ->count();
    $total_onsite_final_summary = DB::table('assessor_final_summary_reports')
                        ->where('application_id',$application_id)
                        ->where('assessor_type','onsite')
                        ->count();
    if($total_courses==$total_onsite_final_summary){
        return 0;
    }

    foreach ($finalResults as $result) {
        if ((($result->onsite_status == 1) || ($result->onsite_status == 4 && $result->admin_nc_flag == 1)) && $result->is_revert==1) {
            $flag = 0;
        } else {
            $flag = 1;
            break;
        }
    }
    
    return $flag != 0;
}


public function checkSubmitButtonEnableOrDisable($application_id)
{

    $results = DB::table('tbl_application_course_doc')
    ->select('application_id', 'application_courses_id', 'assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
    ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id', 'assessor_type')
    ->where('application_id', $application_id)
    ->where('approve_status', 1)
    ->get();

$additionalFields = DB::table('tbl_application_course_doc')
    ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id, assessor_type) as sub'), function ($join) {
        $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
            ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
            ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
            ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
            ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
    })
    ->orderBy('tbl_application_course_doc.id', 'desc')
    ->where('tbl_application_course_doc.assessor_type','onsite')
    ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.onsite_status', 'id', 'admin_nc_flag', 'approve_status', 'assessor_type']);


        $finalResults = [];
        foreach ($results as $key => $result) {
            if ($result->assessor_type == 'onsite') {
                $additionalField = $additionalFields->where('application_id', $result->application_id)
                    ->where('application_courses_id', $result->application_courses_id)
                    ->where('doc_sr_code', $result->doc_sr_code)
                    ->where('doc_unique_id', $result->doc_unique_id)
                    ->where('approve_status', 1)
                    ->first();

                if ($additionalField) {
                    $finalResults[$key] = (object)[];
                    $finalResults[$key]->onsite_status = $additionalField->onsite_status;
                    $finalResults[$key]->id = $additionalField->id;
                    $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                    $finalResults[$key]->approve_status = $additionalField->approve_status;
                    $finalResults[$key]->assessor_type = $additionalField->assessor_type;
                }
            }
        }

    
    $flag = 0;
    foreach ($finalResults as $result) {

        if (($result->onsite_status!=0)) {
            $flag = 0;
        } else {
            $flag = 1;
            break;
        }
    }
    
    if ($flag == 0) {
        return false;
    } else {
        return true;
    }

}

public function checkAllActionDoneOnRevert($application_id)
{

    $results = DB::table('tbl_application_course_doc')
        ->select('application_id', 'application_courses_id','assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id','assessor_type')
        // ->where('application_courses_id', $application_courses_id)
        ->where('application_id', $application_id)
        ->where('approve_status',1)
        ->get();

        
        

    $additionalFields = DB::table('tbl_application_course_doc')
        ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
            $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
        })
        ->where('tbl_application_course_doc.assessor_type','onsite')
        ->orderBy('tbl_application_course_doc.id', 'desc')
        ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.onsite_status', 'id', 'admin_nc_flag','approve_status','is_revert','assessor_type']);

    $finalResults = [];
    foreach ($results as $key => $result) {
        if ($result->assessor_type == 'onsite') {
        $additionalField = $additionalFields->where('application_id', $result->application_id)
            ->where('application_courses_id', $result->application_courses_id)
            ->where('doc_sr_code', $result->doc_sr_code)
            ->where('doc_unique_id', $result->doc_unique_id)
            ->where('approve_status',1)
            ->first();
        if ($additionalField) {
            $finalResults[$key] = (object)[];
            $finalResults[$key]->onsite_status = $additionalField->onsite_status;
            $finalResults[$key]->id = $additionalField->id;
            $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
            $finalResults[$key]->approve_status = $additionalField->approve_status;
            $finalResults[$key]->is_revert = $additionalField->is_revert;
        }
     }
    }

    
    $flag = 0;

    foreach ($finalResults as $result) {
        if (($result->is_revert == 1)) {
            $flag = 0;
        } else {
            $flag = 1;
            break;
        }
    }
    
    if ($flag == 0) {
        return false;
    } else {
        return true;
    }

}




public function onsiteUpdateNCFlagDocList($application_id)
    {

        
        try {
            $application_id = dDecrypt($application_id);
            
            DB::beginTransaction();
            $t=0;
            $secretariat_id = Auth::user()->id;


            $check_all_doc_verified = $this->checkApplicationIsReadyForNextLevelDocList($application_id);
            /*------end here------*/
            DB::commit();
            if ($check_all_doc_verified == "all_verified") {
                DB::table('tbl_application')->where('id',$application_id)->update(['is_secretariat_submit_btn_show'=>0]);
                return back()->with('success', 'All course docs Accepted successfully.');
            }

            $get_course_docs = DB::table('tbl_application_course_doc')
                ->where(['application_id' => $application_id,'approve_status'=>1,'assessor_type'=>'onsite'])
                // ->whereIn('doc_sr_code',[config('constant.declaration.doc_sr_code'),config('constant.curiculum.doc_sr_code'),config('constant.details.doc_sr_code')])
                ->latest('id')->get();
                

                foreach($get_course_docs as $course_doc){
                    $nc_comment_status = "";
                    $nc_flag=0;
                    $nc_comments = 0;
                   if ($course_doc->onsite_status == 2) {
                        $nc_comment_status = 2;
                        $nc_flag = 1;
                        $nc_comments=1;
                    } else if ($course_doc->onsite_status == 3) {
                        $nc_comment_status = 3;
                        $nc_flag = 1;
                        $nc_comments=1;
                    }
                    // else if ($course_doc->onsite_status == 4) {
                    //     $nc_comment_status = 4;
                    //     $nc_flag = 1;
                    //     $nc_comments=1;
                    // } 
                    else {
                        $nc_comment_status = 0; //not recommended
                        $nc_flag = 0;
                        $nc_comments=0;
                    }

                $is_update= DB::table('tbl_application_course_doc')
                ->where(['id' => $course_doc->id, 'application_id' => $application_id,'nc_show_status'=>0,'assessor_type'=>'onsite'])
                ->update(['nc_flag' => $nc_flag, 'assessor_id' => $secretariat_id,'nc_show_status'=>$nc_comment_status,'is_revert'=>1]);

                DB::table('tbl_nc_comments')
                ->where(['application_id' => $application_id, 'application_courses_id' => $course_doc->application_courses_id,'nc_show_status'=>0,'assessor_type'=>'onsite'])
                ->update(['nc_show_status' => $nc_comments]);

                if($t==0){
                    if($is_update){
                        $t=1;
                    }
                }
            }
            $get_application = DB::table('tbl_application')->where('id',$application_id)->first();

            if($get_application->level_id==1){
                $url= config('notification.secretariatUrl.level1');
                $url=$url.dEncrypt($application_id);
                $tpUrl = config('notification.tpUrl.level1');
                $tpUrl=$tpUrl.dEncrypt($application_id);
            }else if($get_application->level_id==2){
                $url= config('notification.secretariatUrl.level2');
                $url=$url.dEncrypt($application_id);
                $tpUrl = config('notification.tpUrl.level2');
                $tpUrl=$tpUrl.dEncrypt($application_id);
            }else{
                $url= config('notification.secretariatUrl.level3');
                $url=$url.dEncrypt($application_id);
                $tpUrl = config('notification.tpUrl.level3');
                $tpUrl=$tpUrl.dEncrypt($application_id);
            }

            $is_all_accepted=$this->isAllCourseDocAccepted($application_id);
            $notifiData = [];
            $notifiData['sender_id'] = Auth::user()->id;
            $notifiData['application_id'] = $application_id;
            $notifiData['uhid'] = getUhid( $application_id)[0];
            $notifiData['level_id'] = getUhid( $application_id)[1];
            $notifiData['data'] = config('notification.common.nc');
            $notifiData['user_type'] = "superadmin";
            $sUrl = config('notification.adminUrl.level1');
            $notifiData['url'] = $sUrl.dEncrypt($application_id);
            if($get_application->level_id==3){
            if($t && !$is_all_accepted){
                
                  /*send notification*/ 
                  sendNotification($notifiData);
                  $notifiData['user_type'] = "tp";
                  $notifiData['url'] = $tpUrl;
                  $notifiData['receiver_id'] = $get_application->tp_id;
                  sendNotification($notifiData);
                  $notifiData['user_type'] = "secretariat";
                  $notifiData['url'] = $url;
                  $notifiData['receiver_id'] = $get_application->secretariat_id;
                  sendNotification($notifiData);
                    /*end here*/ 
                  createApplicationHistory($application_id,null,config('history.common.nc'),config('history.color.danger'));
            }
           
            if($is_all_accepted){
                $notifiData['data'] = config('notification.admin.acceptCourseDoc');
                $notifiData['user_type'] = "superadmin";
                $notifiData['url'] = $sUrl.dEncrypt($application_id);
                sendNotification($notifiData);
            }
        }
            /*--------To Check All 44 Doc Approved----------*/

            $check_all_doc_verified = $this->checkApplicationIsReadyForNextLevelDocList($application_id);
            /*------end here------*/
            DB::commit();
            // if (!$check_all_doc_verified) {
            //     return back()->with('fail', 'First create NCs on courses doc');
            // }
            if ($check_all_doc_verified == "all_verified") {
                DB::table('tbl_application')->where('id',$application_id)->update(['is_secretariat_submit_btn_show'=>0]);
                
                return back()->with('success', 'All course docs Accepted successfully.');
            }
            if ($check_all_doc_verified == "action_not_taken") {
                return back()->with('fail', 'Please take any action on course doc.');
            }
            return back()->with('success', 'Enabled Course Doc upload button to TP.');
            // return redirect($redirect_to);

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('fail', 'Something went wrong');
        }
}



public function uploadSignedCopy(Request $request)
{
   try{
    
    DB::beginTransaction();
    
    if ($request->hasfile('signed_copy_onsite')) {
        $file = $request->file('signed_copy_onsite');
        $name = $file->getClientOriginalName();
        $filename = rand().'-'.time().rand().'-'. $name;
        $file->move('level/', $filename);
    }
    $uploaded = DB::table('tbl_application')->where('id',$request->application_id)->update(['signed_copy_onsite'=>$filename]);
    
    if($uploaded){
    DB::commit();
    return response()->json(['success' => true,'message' =>'Signed Copy uploaded successfully'],200);
    }else{
        return response()->json(['success' => false,'message' =>'Failed to upload Signed Copy'],200);
    }
   } 
   catch(Exception $e){
    return response()->json(['success' => false,'message' =>'Someting went wrong'],500);
   }
 }

 public function sigendCopyOnsite($doc_name,$app_id)
 {
     $data = $doc_name;
     return view('doc-view.signed', ['data' => $data]);
    
 }

 public function isAllCourseDocAccepted($application_id)
 {


     $all_courses_id = DB::table('tbl_application_courses')->where('application_id', $application_id)->pluck('id');


     $results = DB::table('tbl_application_course_doc')
         ->select('application_id', 'application_courses_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
         ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id')
         ->whereIn('application_courses_id', $all_courses_id)
         ->where('application_id', $application_id)
         ->where('approve_status',1)
         ->get();


     $additionalFields = DB::table('tbl_application_course_doc')
         ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
             $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                 ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                 ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                 ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                 ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
         })
         ->orderBy('tbl_application_course_doc.id', 'desc')
         ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status']);


     foreach ($results as $key => $result) {
         $additionalField = $additionalFields->where('application_id', $result->application_id)
             ->where('application_courses_id', $result->application_courses_id)
             ->where('doc_sr_code', $result->doc_sr_code)
             ->where('doc_unique_id', $result->doc_unique_id)
             ->where('approve_status',1)
             ->first();
         if ($additionalField) {
             $results[$key]->status = $additionalField->status;
             $results[$key]->id = $additionalField->id;
             $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
         }
     }

     $flag = 0;
     foreach ($results as $result) {
         if ($result->status == 1 || ($result->status == 4 && $result->admin_nc_flag == 1)) {
             $flag = 1;
         } else {
             $flag = 0;
             break;
         }
     }

  
     if ($flag == 1) {
         return true;
     } else {
         return false;
     }

 }

 public function isCreateSummaryBtnShow($application_id,$application_courses_id)
 {

     $results = DB::table('tbl_application_course_doc')
         ->select('application_id', 'application_courses_id','assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
         ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id','assessor_type')
         ->where('application_courses_id', $application_courses_id)
         ->where('application_id', $application_id)
         ->where('approve_status',1)
         ->get();

         
         

     $additionalFields = DB::table('tbl_application_course_doc')
         ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
             $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                 ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                 ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                 ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                 ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
         })
         ->where('tbl_application_course_doc.assessor_type','onsite')
         ->orderBy('tbl_application_course_doc.id', 'desc')
         ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status','tbl_application_course_doc.onsite_status', 'id', 'admin_nc_flag','approve_status','is_revert','assessor_type']);

     $finalResults = [];
     foreach ($results as $key => $result) {
         if ($result->assessor_type == 'onsite') {
         $additionalField = $additionalFields->where('application_id', $result->application_id)
             ->where('application_courses_id', $result->application_courses_id)
             ->where('doc_sr_code', $result->doc_sr_code)
             ->where('doc_unique_id', $result->doc_unique_id)
             ->where('approve_status',1)
             ->first();
         if ($additionalField) {
             $finalResults[$key] = (object)[];
             $finalResults[$key]->status = $additionalField->status;
             $finalResults[$key]->onsite_status = $additionalField->onsite_status;
             $finalResults[$key]->id = $additionalField->id;
             $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
             $finalResults[$key]->approve_status = $additionalField->approve_status;
             $finalResults[$key]->is_revert = $additionalField->is_revert;
         }
     }
     }

     
     $flag = 0;
    //  dd($finalResults);
     foreach ($finalResults as $result) {
         if (((($result->onsite_status==2 || $result->onsite_status==3)) && $result->is_revert==1)) {
             $flag = 0;
             break;
         } else {
            $flag=1;
         }
         if($result->onsite_status==0){
             $flag=0;
             break;
         }
     }
     
     if ($flag == 0) {
         return "hide";
     }else{
         return "show";
     }
     
 }

}

