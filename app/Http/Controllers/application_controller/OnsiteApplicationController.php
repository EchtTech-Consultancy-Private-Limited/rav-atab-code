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

        $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->latest('id')->first();
            $obj = new \stdClass;
            $obj->application= $application;
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $application->id,
                ])
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
                $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id,'assessor_type'=>'onsite'])->first();
                if(!empty($is_exists)){
                    $is_final_submit = true;
                }else{
                    $is_final_submit = false;
                }
                
                return view('onsite-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit]);
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
        ->select('id','doc_unique_id','doc_file_name','doc_sr_code','assessor_type','onsite_status','admin_nc_flag','status')
        ->get();

        $onsite_course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'assessor_type'=>'onsite'
        ])
        ->select('id','doc_unique_id','doc_file_name','doc_sr_code','assessor_type','onsite_status','onsite_doc_file_name','status','onsite_photograph','admin_nc_flag')
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
        
       
        $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application_id,'application_course_id'=> $course_id,'assessor_type'=>'onsite'])->first();
       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }

        $desktopData = $this->onsiteApplicationDocumentList($application_id, $course_id);
    //    dd($onsite_course_doc_uploaded);
        return view('onsite-view.application-documents-list', compact('desktopData', 'course_doc_uploaded','onsite_course_doc_uploaded','application_id','course_id','is_final_submit','is_doc_uploaded','application_uhid'));
    }

   
    public function onsiteApplicationDocumentList($id, $course_id)
    {
        $tp_id = Auth::user()->id;
        $application_id = $id;
        $course_id = $course_id;
        
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
                            'assessor_type' => 'onsite',
                            'doc_unique_id' => $question->id,
                            'doc_sr_code' => $question->code,
                        ])
                        ->where('nc_type',"!=",null)
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
            $nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code,'assessor_type'=>'onsite','nc_type'=>$nc_type])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->first();           
            $tbl_nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'application_courses_id'=>$application_course_id,'doc_unique_id' => $doc_unique_code,'assessor_type'=>'onsite'])->latest('id')->first();
        
            $is_nc_exists=false;
            if($nc_type==="view"){
                $is_nc_exists=true;
            }
            // dd($doc_sr_code, $doc_unique_code);
           
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
         $data['comments'] = $request->comments;
         $data['nc_type'] = $request->nc_type;
        //  $data['status'] = 1;

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
         dispatch(new SendEmailJob($details));
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

        $applicationDetails = TblApplication::find($request->input('application'));
        return view('onsite-view.course-summary-list', compact('courses', 'applicationDetails'));
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


    public function updateAssessorOnsiteNotificationStatus(Request $request)
    {
        try{
          $request->validate([
              'id' => 'required',
          ]);
          DB::beginTransaction();
          $update_assessor_received_payment_status = DB::table('tbl_application')->where('id',$request->id)->update(['assessor_onsite_received_payment'=>1]);
          if($update_assessor_received_payment_status){
              DB::commit();
              $redirect_url = URL::to('/onsite/application-view/'.dEncrypt($request->id));
              return response()->json(['success' => true,'message' =>'Read notification successfully.','redirect_url'=>$redirect_url],200);
          }else{
              DB::rollback();
              return response()->json(['success' => false,'message' =>'Failed to read notification'],200);
          }
    }
    catch(Exception $e){
          DB::rollback();
          return response()->json(['success' => false,'message' =>'Failed to read notification'],200);
    }
    }

}

