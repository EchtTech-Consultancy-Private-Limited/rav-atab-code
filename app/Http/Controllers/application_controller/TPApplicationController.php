<?php
namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use App\Http\Traits\PdfImageSizeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Models\TblApplication; 
use App\Models\TblApplicationPayment; 
use App\Models\TblApplicationCourseDoc; 
use App\Models\LevelInformation;
use App\Models\TblApplicationCourses;
use App\Models\Chapter; 
use App\Models\Country;
use Carbon\Carbon;
use App\Http\Helpers\ApplicationDurationCaculate;
use App\Models\TblNCComments; 
use App\Jobs\SendEmailJob;
use URL;
use File;

use Str;

class TPApplicationController extends Controller
{
    use PdfImageSizeTrait;
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getApplicationList($level_type='level-one'){
        
        $pay_list = DB::table('tbl_application_payment')
          ->where('user_id',Auth::user()->id)
          ->whereNull('payment_ext')
          ->where('pay_status','Y')
          ->get()
          ->pluck('application_id')
          ->toArray();

        if($level_type=="level-one" || $level_type=="level-first"){
            $level_id = 1;
            $level_url="level-first";
        }else if($level_type=="level-second"){
            $level_id = 2;
            $level_url="level-second";
        }else{
            $level_id = 3;
            $level_url="level-third";
        }

        $application = DB::table('tbl_application as a')
        ->where('tp_id',Auth::user()->id)
        ->where('level_id',$level_id)
        ->whereIn('id',$pay_list)
        ->orderBy('id','desc')
        ->get();

        $final_data=array();
        foreach($application as $app){
            $obj = new \stdClass;
            $obj->application_list = $app;
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
                    'payment_ext'=>null,
                    'pay_status'=>'Y'
                ])->latest('created_at')->first();
                $payment_amount = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                    'pay_status'=>'Y'
                ])->sum('amount');
                $payment_count = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                    'pay_status'=>'Y'
                ])->count();
                $app_history = DB::table('tbl_application_status_history')
                ->select('tbl_application_status_history.*','users.firstname','users.middlename','users.lastname','users.role')
                ->leftJoin('users', 'tbl_application_status_history.user_id', '=', 'users.id')
                ->where('tbl_application_status_history.application_id', $app->id)
                ->get();

                if($payment){
                    $obj->payment = $payment;
                    $obj->payment->payment_count = $payment_count;
                    $obj->payment->payment_amount = $payment_amount;
                    $obj->otherCountryPayment = "";
                }
                $appTime = new ApplicationDurationCaculate;
                $surveillance_Renewal =$appTime->surveillanceRenewal(auth::user()->role,$app);
                $obj->surveillanceRenewal = $surveillance_Renewal;

                $application_duration =$appTime->calculateTimeDateTrainingProvider(auth::user()->role,'verify_payment',$app);
                $obj->applicationDuration = $application_duration;
                
                $obj->renewal_url = "renewal/".$level_url."?sr_prev_id=".dEncrypt($app->id)."&q=renewal";
                $obj->surveillance_url ="surveillance/".$level_url."?sr_prev_id=".dEncrypt($app->id)."&q=surveillance";
                $obj->appHistory= $app_history;
                $final_data[] = $obj;
        }
        
        return view('tp-view.application-list',['list'=>$final_data]);
    }

    /** Whole Application View for Account */
    public function getApplicationView($id){
        
        $application = DB::table('tbl_application')
        ->where('id', dDecrypt($id))
        ->first();
        $json_course_doc = File::get(base_path('/public/course-doc/courses.json'));
        $decoded_json_courses_doc = json_decode($json_course_doc);
        
        $user_data = DB::table('users')->where('users.id',  $application->tp_id)
        ->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')
        ->join('countries', 'users.country', '=', 'countries.id')
        ->join('cities', 'users.city', '=', 'cities.id')
        ->join('states', 'users.state', '=', 'states.id')
        ->first();
        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->whereNull('payment_ext')->where('pay_status','Y')->latest('id')->first();

            $showSubmitBtnToTP = $this->checkReuploadBtnL1($application->id);
            
            $enable_disable_submit_btn = $this->checkSubmitButtonEnableOrDisableL1(dDecrypt($id),"secretariat");
        
            $obj = new \stdClass;
            $obj->application= $application;
            $obj->is_all_revert_action_done=$this->checkAllActionDoneOnRevert($application->id);
            $courses = DB::table('tbl_application_courses')->where([
                'application_id' => $application->id,
            ])
            // ->whereIn('status',[0,2]) 
            ->whereNull('deleted_at') 
            ->get();
            
            foreach ($courses as $course) {
                if ($course) {
                    $course_docs=$this->isNcOnCourseDocs($application->id, $course->id);
                    if($application->level_id!=1){
                        $course_docs_lists=$this->isNcOnCourseDocsList($application->id, $course->id);
                    }
                    $obj->course[] = [
                        "course" => $course,
                        'course_wise_document_declaration' => DB::table('tbl_course_wise_document')->where([
                            'application_id' => $application->id,
                            'course_id' => $course->id,
                            'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                            'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                        ])->get(),
                        'isAnyNcOnCourse'=>$course_docs,
                        'isAnyNcOnCourseDocList'=>$course_docs_lists??false,

                            'course_wise_document_curiculum' => DB::table('tbl_course_wise_document')->where([
                                'application_id' => $application->id,
                                'course_id' => $course->id,
                                'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                                'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                            ])->get(),
            
                            'course_wise_document_details' => DB::table('tbl_course_wise_document')->where([
                                'application_id' => $application->id,
                                'course_id' => $course->id,
                                'doc_sr_code' => config('constant.details.doc_sr_code'),
                                'doc_unique_id' => config('constant.details.doc_unique_id'),
                            ])->get(),
                        'nc_comments_course_declaration' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                            'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                            'nc_show_status'=>1,
                            
                        ])
                            ->whereIn('nc_type',['NC1','NC2','not_recommend','Reject'])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get(),
            
                        'nc_comments_course_curiculam' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                            'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                            'nc_show_status'=>1
                        ])
                            ->whereIn('nc_type',['NC1','NC2','not_recommend','Reject'])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get(),
            
                        'nc_comments_course_details' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.details.doc_sr_code'),
                            'doc_unique_id' => config('constant.details.doc_unique_id'),
                            'nc_show_status'=>1
                        ])
                            ->whereIn('nc_type',['NC1','NC2','not_recommend','Reject'])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get()
                            
                    ]; // Added semicolon here
                }
            }

                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                    'payment_ext'=>null,
                    'pay_status'=>'Y'
                ])->get();
                $additional_payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                    'payment_ext'=>'add',
                    'pay_status'=>'Y'
                ])->get();
                if($payment){
                    $obj->payment = $payment;
                    $obj->additional_payment = $additional_payment;
                }
                $final_data = $obj;
                $tp_final_summary_count =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id])->count();
                if($tp_final_summary_count>1){
                 $is_final_submit = true;
                }else{
                 $is_final_submit = false;
                }
                
        return view('tp-view.application-view',['application_details'=>$final_data,
                    'data' => $user_data,'spocData' => $application,
                    'application_payment_status'=>$application_payment_status,
                    'is_final_submit'=>$is_final_submit,'courses_doc'=>$decoded_json_courses_doc,
                    'enable_disable_submit_btn'=>$enable_disable_submit_btn,
                    'showSubmitBtnToTP'=>$showSubmitBtnToTP]);
    }
    public function upload_document($id, $course_id)
    {
        $tp_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $application_uhid = TblApplication::where('id',$application_id)->first()->uhid??'';
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;
        $data = TblApplicationPayment::where('application_id',$application_id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'tp_id'=>$tp_id,
            'assessor_type'=>'desktop'
        ])->select('id','doc_unique_id','doc_file_name','doc_sr_code','nc_flag','admin_nc_flag','assessor_type','ncs_flag_status','status','nc_show_status','is_tp_revert','is_admin_submit')->get();

        $onsite_course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'assessor_type'=>'onsite'
        ])
        ->select('id','doc_unique_id','onsite_doc_file_name','doc_file_name','doc_sr_code','admin_nc_flag','assessor_type','onsite_status','onsite_nc_status','status','nc_show_status','is_tp_revert','is_admin_submit')
        ->get();
        
        $is_payment_done = DB::table('tbl_application_payment')->where('application_id',$application_id)->whereNull('payment_ext')->where('pay_status','Y')->count();
        $total_application_courses_doc = DB::table('tbl_application_course_doc')->where('application_id',$application_id)->where('approve_status',1)->whereNull('deleted_at')->count();
        $total_courses = DB::table('tbl_application_courses')->where('application_id',$application_id)->count();
        $is_all_doc_uploaded=false;
        if(($total_application_courses_doc>=$total_courses*4) && $is_payment_done>0){
            $is_all_doc_uploaded=true;
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
                            'doc_sr_code' => $question->code,
                        ])
                        ->whereIn('tbl_nc_comments.nc_type',['NC1','NC2','not_recommended'])
                        ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
                        ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
                        ->get(),
                        'onsite_nc_comments' => TblNCComments::where([
                            'application_id' => $application_id,
                            'application_courses_id' => $course_id,
                            'doc_unique_id' => $question->id,
                            'doc_sr_code' => $question->code,
                            'assessor_type'=>'onsite'
                        ])
                        ->whereIn('tbl_nc_comments.nc_type',['NC1','NC2','not_recommended'])
                        ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
                        ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
                        ->get(),
                    ];
                }
                $final_data[] = $obj;
        }

        
        $applicationData = TblApplication::find($application_id);
        return view('tp-upload-documents.tp-upload-documents', compact('final_data','onsite_course_doc_uploaded', 'course_doc_uploaded','application_id','course_id','application_uhid','is_all_doc_uploaded'));
    }
    

    public function upload_documentlevel2($id, $course_id)
    {
        
        $tp_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $application_uhid = TblApplication::where('id',$application_id)->first()->uhid??'';
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;
        $data = TblApplicationPayment::where('application_id',$application_id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'tp_id'=>$tp_id,
            'assessor_type'=>'secretariat'
        ])->select('id','doc_unique_id','doc_file_name','doc_sr_code','nc_flag','admin_nc_flag','assessor_type','ncs_flag_status','nc_show_status','status','is_tp_revert','is_admin_submit')->get();

        $is_payment_done = DB::table('tbl_application_payment')->where('application_id',$application_id)->whereNull('payment_ext')->where('pay_status','Y')->count();
        $total_application_courses_doc = DB::table('tbl_application_course_doc')->where('application_id',$application_id)->where('approve_status',1)->whereNull('deleted_at')->count();
        $total_courses = DB::table('tbl_application_courses')->where('application_id',$application_id)->count();
        $is_all_doc_uploaded=false;
        if(($total_application_courses_doc>=$total_courses*4) && $is_payment_done>0){
            $is_all_doc_uploaded=true;
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
                            'doc_sr_code' => $question->code,
                            
                        ])
                        ->whereIn('tbl_nc_comments.nc_type',['NC1','NC2','not_recommended'])
                        ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
                        ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
                        ->get(),

                    ];
                }
                $final_data[] = $obj;
        }
        $applicationData = TblApplication::find($application_id);
        
        return view('level2-tp-upload-documents.tp-upload-documents', compact('final_data','course_doc_uploaded','application_id','course_id','application_uhid','is_all_doc_uploaded'));
    }
    

    public function addDocument(Request $request)
    {
       try{
        DB::beginTransaction();
        $tp_id = Auth::user()->id;
        $is_doc_show = $request->total_uploaded_doc==0?0 : -1;
        $course_doc = new TblApplicationCourseDoc;
        $course_doc->application_id = $request->application_id;
        $course_doc->application_courses_id = $request->application_courses_id;
        $course_doc->doc_sr_code = $request->doc_sr_code;
        $course_doc->doc_unique_id = $request->doc_unique_id;
        $course_doc->tp_id = $tp_id;
        $course_doc->assessor_type =$request->assessor_type;
        $course_doc->is_doc_show =$is_doc_show;
        
        
        if ($request->hasfile('fileup')) {
            $timestamp = now()->format('YmdHis'); 
            $file = $request->file('fileup');
            $randomString = Str::random(8);
            $name = $file->getClientOriginalName();
            $filename="{$timestamp}_{$randomString}".$name;
            $file->move('level/', $filename);
            $course_doc->doc_file_name = $filename;
        }
        $course_doc->save();
        TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'assessor_type'=>'desktop'])->whereIn('status',[2,3,4])->update(['nc_flag'=>0]);

        /*update nc table status oniste*/
        if($request->assessor_type=="onsite"){
            TblNCComments::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'onsite_nc_flag'=>0])->update(['onsite_nc_flag'=>1]);
            
            TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'assessor_type'=>'onsite'])->whereIn('onsite_status',[2,3,4])->update(['onsite_nc_status'=>0]);
        }
        /*end here*/ 
        // DB::table('tbl_application')->where('id',$request->application_id)->update(['status'=>5]);
        if($course_doc){
        DB::commit();
        return response()->json(['success' => true,'message' =>'Document uploaded successfully'],200);
        }else{
            return response()->json(['success' => false,'message' =>'Failed to upload document'],200);
        }
    }
    catch(Exception $e){
        DB::rollback();
        return response()->json(['success' => false,'message' =>'Failed to upload document'],200);
    }
  }

  public function addDocumentLevel2(Request $request)
  {
    
     try{
      DB::beginTransaction();
      $tp_id = Auth::user()->id;
      $is_doc_show = $request->total_uploaded_doc==0?0 : -1;
      
      $course_doc = new TblApplicationCourseDoc;
      $course_doc->application_id = $request->application_id;
      $course_doc->application_courses_id = $request->application_courses_id;
      $course_doc->doc_sr_code = $request->doc_sr_code;
      $course_doc->doc_unique_id = $request->doc_unique_id;
      $course_doc->tp_id = $tp_id;
      $course_doc->assessor_type =$request->assessor_type;
      $course_doc->is_doc_show = $is_doc_show;
      if ($request->hasfile('fileup')) {
          $file = $request->file('fileup');
          $name = $file->getClientOriginalName();
          $filename = time() . $name;
          $file->move('level/', $filename);
          $course_doc->doc_file_name = $filename;
      }
      $course_doc->save();
      TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'assessor_type'=>'secretariat'])->whereIn('status',[2,3,4])->update(['nc_flag'=>0]);

      $get_app = DB::table('tbl_application')->where('id',$request->application_id)->first();
      if($get_app->level_id==1){
        $url= config('notification.secretariatUrl.level1');
        $url=$url.dEncrypt($request->application_id);
        
    }else if($get_app->level_id==2){
        $url= config('notification.secretariatUrl.level2');
        $url=$url.dEncrypt($request->application_id);
        
    }else{
        $url= config('notification.secretariatUrl.level3');
        $url=$url.dEncrypt($request->application_id);
        
    }
       /*send notification*/ 
       $notifiData = [];
       $notifiData['data'] = config('notification.common.upload');
       $notifiData['sender_id'] = Auth::user()->id;
       $notifiData['application_id'] =$request->application_id;
       $notifiData['uhid'] = getUhid($request->application_id)[0];
       $notifiData['level_id'] = getUhid($request->application_id)[1] ;
       $notifiData['user_type'] = "superadmin";
       $sUrl = config('notification.adminUrl.level1');
       $notifiData['url'] = $sUrl.dEncrypt($request->application_id);
    //    sendNotification($notifiData);
       $notifiData['user_type'] = "secretariat";
       $notifiData['receiver_id'] = $get_app->secretariat_id;
       $notifiData['url'] = $url;
    //    sendNotification($notifiData);
       /*end here*/ 

      if($course_doc){
      DB::commit();
      return response()->json(['success' => true,'message' =>'Document uploaded successfully'],200);
      }else{
          return response()->json(['success' => false,'message' =>'Failed to upload document'],200);
      }
  }
  catch(Exception $e){
      DB::rollback();
      return response()->json(['success' => false,'message' =>'Failed to upload document'],200);
  }
}
  public function tpDocumentDetails($nc_status_type,$assessor_type,$doc_sr_code, $doc_name, $application_id, $doc_unique_code,$application_courses_id)
  {
      try{
        $nc_type = "NC1";
        if($nc_status_type==2){
            $nc_type="NC1";
        }
        else if($nc_status_type==3){
            $nc_type="NC2";
        }
        else if($nc_status_type==4){
            $nc_type="not_recommended";
        }
        else if($nc_status_type==6){
            $nc_type="Reject";
        }
        else{
            $nc_type="Accept";
        }

        

        $is_form_view = false;
        if($nc_status_type!=0){
        // is remark form show to top
        $is_already_remark_exists = TblNCComments::where(['application_id' => $application_id,'application_courses_id' => $application_courses_id,'doc_sr_code' => $doc_sr_code,'doc_unique_id' => $doc_unique_code,'assessor_type' => $assessor_type,'nc_type'=>$nc_type])->first();
        
        if(isset($is_already_remark_exists)){
        if($is_already_remark_exists->nc_type!=="Accept" && $is_already_remark_exists->nc_type!=="Request_For_Final_Approval"){
            if($is_already_remark_exists->tp_remark!==null){
                $is_form_view=false;
            }else{
                $is_form_view=true;
            }
        }
      }
    }
        // end here for form

      $doc_latest_record = TblApplicationCourseDoc::latest('id')
      ->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
      ->first();

      $get_remarks = TblNCComments::where([
        'application_id' => $application_id,
        'doc_unique_id' => $doc_unique_code,
        'doc_sr_code' => $doc_sr_code,
        'application_courses_id' => $application_courses_id,
        'assessor_type'=>$assessor_type
    ])
    ->whereNotNull("tp_remark")
    ->where('nc_type',$nc_type)
    ->select("tbl_nc_comments.tp_remark","tbl_nc_comments.created_at","tbl_nc_comments.assessor_id")
    ->first();

    //   $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
      $doc_path = URL::to("/level").'/'.$doc_name;
      return view('tp-upload-documents.tp-show-document-details', [
          'doc_latest_record' => $doc_latest_record,
          'doc_id' => $doc_sr_code,
          'assessor_type'=>$assessor_type,
          'doc_code' => $doc_unique_code,
          'application_course_id'=>$application_courses_id,
          'application_id' => $application_id,
          'doc_path' => $doc_path,
          'remarks' => $get_remarks,
          'nc_type'=>$nc_type,
          'is_form_view'=>$is_form_view,
      ]);
  }catch(Exception $e){
      return back()->with('fail','Something went wrong');
  }
  }


  public function tpDocumentDetailsLevel2($nc_status_type,$assessor_type,$doc_sr_code, $doc_name, $application_id, $doc_unique_code,$application_courses_id)
  {
      try{
        $nc_type = "NC1";
        if($nc_status_type==2){
            $nc_type="NC1";
        }
        else if($nc_status_type==3){
            $nc_type="NC2";
        }
        else if($nc_status_type==4){
            $nc_type="not_recommended";
        }
        else if($nc_status_type==6){
            $nc_type="Reject";
        }
        else{
            $nc_type="Accept";
        }

        
        

        $is_form_view = false;
        if($nc_status_type!=0){
        // is remark form show to top
        $is_already_remark_exists = TblNCComments::where(['application_id' => $application_id,'application_courses_id' => $application_courses_id,'doc_sr_code' => $doc_sr_code,'doc_unique_id' => $doc_unique_code,'assessor_type' => $assessor_type,'nc_type'=>$nc_type])->first();
        if(isset($is_already_remark_exists)){
        if($is_already_remark_exists->nc_type!=="Accept" && $is_already_remark_exists->nc_type!=="Request_For_Final_Approval"){
            if($is_already_remark_exists->tp_remark!==null){
                $is_form_view=false;
            }else{
                $is_form_view=true;
                }
            }
        }
    }
        // end here for form

      $doc_latest_record = TblApplicationCourseDoc::latest('id')
      ->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
      ->first();

      $get_remarks = TblNCComments::where([
        'application_id' => $application_id,
        'doc_unique_id' => $doc_unique_code,
        'doc_sr_code' => $doc_sr_code,
        'application_courses_id' => $application_courses_id,
        'assessor_type'=>$assessor_type
    ])
    ->whereNotNull("tp_remark")
    ->where('nc_type',$nc_type)
    ->select("tbl_nc_comments.tp_remark","tbl_nc_comments.created_at","tbl_nc_comments.assessor_id")
    ->first();

    //   $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
      $doc_path = URL::to("/level").'/'.$doc_name;
      return view('level2-tp-upload-documents.tp-show-document-details', [
          'doc_latest_record' => $doc_latest_record,
          'doc_id' => $doc_sr_code,
          'assessor_type'=>$assessor_type,
          'doc_code' => $doc_unique_code,
          'application_course_id'=>$application_courses_id,
          'application_id' => $application_id,
          'doc_path' => $doc_path,
          'remarks' => $get_remarks,
          'nc_type'=>$nc_type,
          'is_form_view'=>$is_form_view,
      ]);
  }catch(Exception $e){
      return back()->with('fail','Something went wrong');
  }
  }


  public function tpSubmitRemark(Request $request)
  {
      try{
        DB::beginTransaction();
        $submit_remark = TblNCComments::where(['application_id' => $request->application_id,'application_courses_id' => $request->application_course_id,'doc_sr_code' => $request->doc_sr_code,'doc_unique_id' => $request->doc_unique_id,'assessor_type' => $request->assessor_type,'nc_type'=>$request->nc_type])->update(['tp_remark'=>$request->tp_remark]);
        if($submit_remark){
            DB::commit();
            return back()->with('success','Remark created successfully');
        }else{
            DB::rollback();
            return back()->with('fail','Failed to create remark');
        }
  }
  catch(Exception $e){
        DB::rollback();
      return back()->with('fail','Something went wrong');
  }
  }



    // function secondPaymentView(Request $request)
    // {

        
    //     return view('tp-upload-documents.tp-show-document-details', [
    //         'doc_latest_record' => $doc_latest_record,
    //         'doc_id' => $doc_sr_code,
    //         'doc_code' => $doc_unique_code,
    //         'application_id' => $application_id,
    //         'doc_path' => $doc_path,
    //         'remarks' => $get_remarks
    //     ]);
    // }


    public function updatePaynentInfo(Request $request)
  {
    
      try{
        $request->validate([
            'id' => 'required',
            'payment_transaction_no' => 'required',
            'payment_reference_no' => 'required',
            'payment_proof' => 'required',
        ]);

        DB::beginTransaction();
        $slip_by_user_file = "";
        if ($request->hasfile('payment_proof')) {
            $file = $request->file('payment_proof');
            $name = $file->getClientOriginalName();
            $filename = time() . $name;
            $file->move('uploads/', $filename);
            $slip_by_user_file = $filename;
        }
         /*keep history for update payment info*/   
         $update_payment = DB::table('tbl_application_payment')->where('id',$request->id)->whereNull('payment_ext')->where('pay_status','Y')->first();
         $updateArr=[];
         $updateArr['old_payment_transaction_no']=$update_payment->payment_transaction_no;
         $updateArr['new_payment_transaction_no']=$request->payment_transaction_no;
         $updateArr['old_payment_reference_no']=$update_payment->payment_reference_no;
         $updateArr['new_payment_reference_no']=$request->payment_reference_no;
         $updateArr['application_id']=$update_payment->application_id;
         $updateArr['user_id']=Auth::user()->id;
         DB::table('payment_history')->insert($updateArr);
       /*end here*/   

        $get_payment_update_count = DB::table('tbl_application_payment')->where('id',$request->id)->whereNull('payment_ext')->where('pay_status','Y')->first()->tp_update_count;
       
        if($get_payment_update_count > (int)env('TP_PAYMENT_UPDATE_COUNT')-1){
            return response()->json(['success' => false,'message' =>'Your update limit is expired'],200);
        }

        $data = [];
        $data['payment_transaction_no']=$request->payment_transaction_no;
        $data['payment_reference_no']=$request->payment_reference_no;
        $data['tp_update_count']=$get_payment_update_count+1;

        if ($request->hasfile('payment_proof')) {
            $data['payment_proof']=$slip_by_user_file;
        }


        $update_payment_info = DB::table('tbl_application_payment')->where('id',$request->id)->whereNull('payment_ext')->where('pay_status','Y')->update($data);

        if($update_payment_info){
            DB::commit();
            return response()->json(['success' => true,'message' =>'Payment info updated successfully'],200);
        }else{
            DB::rollback();
            return response()->json(['success' => false,'message' =>'Failed to update payment info'],200);
        }
  }
  catch(Exception $e){
        DB::rollback();
        return response()->json(['success' => false,'message' =>'Failed to update payment info'],200);
  }
  }


  public function pendingPaymentlist($level_type)
  {
        if($level_type=="level-one"){
            $level_id = 1;
        }else if($level_type=="level-second"){
            $level_id = 2;
        }else{
            $level_id = 3;
        }
        

      $pending_payment_list = DB::table('tbl_application_payment')
          ->where('user_id',Auth::user()->id)
          ->where('level_id',$level_id)
          ->whereNull('payment_ext')->where('pay_status','Y')
          ->get()
          ->pluck('application_id')
          ->toArray();

          
          
        
         $pending_list = DB::table('tbl_application')
         ->where('tp_id',Auth::user()->id)
         ->where('level_id',$level_id)
         ->whereNotIn('id',$pending_payment_list)
         ->orderBy('id','desc')
         ->get();

        //  dd($pending_list);



      return view('tp-view.pending-payment-list', ['pending_payment_list' => $pending_list]);
  }

  public function paymentReferenceValidation(Request $request)
  {
      $transactionNumber = DB::table('tbl_application_payment')->where('payment_reference_no', $request->payment_reference_no)->whereNull('payment_ext')->where('pay_status','Y')->first();
      if ($transactionNumber) {
          // Transaction number already exists
          return response()->json(['status' => 'error', 'message' => 'This Reference ID is already used']);
      } else {
          // Transaction number doesn't exist, you can proceed or return a success message
          // For example, you can return a success message like this:
          return response()->json(['status' => 'success', 'message' => '']);
      }
  }

  public function paymentTransactionValidation(Request $request)
    {
        $transactionNumber = DB::table('tbl_application_payment')->where('payment_transaction_no', $request->payment_transaction_no)->whereNull('payment_ext')->where('pay_status','Y')->first();

        if ($transactionNumber) {
            // Transaction number already exists
            return response()->json(['status' => 'error', 'message' => 'This transaction ID is already used']);
        } else {
            // Transaction number doesn't exist, you can proceed or return a success message
            // For example, you can return a success message like this:
            return response()->json(['status' => 'success', 'message' => '']);
        }
    }



    public function paymentAdditionalReferenceValidation(Request $request)
    {
        $transactionNumber = DB::table('tbl_application_payment')->where('payment_reference_no', $request->payment_reference_no)->first();
        if ($transactionNumber) {
            // Transaction number already exists
            return response()->json(['status' => 'error', 'message' => 'This Reference ID is already used']);
        } else {
            // Transaction number doesn't exist, you can proceed or return a success message
            // For example, you can return a success message like this:
            return response()->json(['status' => 'success', 'message' => '']);
        }
    }
  
    public function paymentAdditionalTransactionValidation(Request $request)
      {
          $transactionNumber = DB::table('tbl_application_payment')->where('payment_transaction_no', $request->payment_transaction_no)->first();
  
          if ($transactionNumber) {
              // Transaction number already exists
              return response()->json(['status' => 'error', 'message' => 'This transaction ID is already used']);
          } else {
              // Transaction number doesn't exist, you can proceed or return a success message
              // For example, you can return a success message like this:
              return response()->json(['status' => 'success', 'message' => '']);
          }
      }
  

    /*new scope*/
    
  public function tpCourseDocumentDetails($nc_status_type,$doc_sr_code, $doc_name, $application_id, $doc_unique_code,$application_courses_id)
  {

    $doc_sr_code = dDecrypt($doc_sr_code);
    $application_id = dDecrypt($application_id);
    $doc_unique_code= dDecrypt($doc_unique_code);
    $application_courses_id= dDecrypt($application_courses_id);
    

      try{
        $nc_type = "NC1";
        if($nc_status_type==2){
            $nc_type="NC1";
        }
        else if($nc_status_type==3){
            $nc_type="NC2";
        }
        else if($nc_status_type==4){
            $nc_type="not_recommended";
        }
        else if($nc_status_type==6){
            $nc_type="Reject";
        }
        else{
            $nc_type="Accept";
        }

        
        
        $is_form_view = false;
        if($nc_status_type!=0){
        // is remark form show to top
        $is_already_remark_exists = DB::table('tbl_nc_comments_secretariat')->where(['application_id' => $application_id,'application_courses_id' => $application_courses_id,'doc_sr_code' => $doc_sr_code,'doc_unique_id' => $doc_unique_code,'nc_type'=>$nc_type])->first();
      
        $is_form_view=false;
        if(isset($is_already_remark_exists)){
        if($is_already_remark_exists->nc_type!=="Accept" && $is_already_remark_exists->nc_type!=="Request_For_Final_Approval"){
            if($is_already_remark_exists->tp_remark!==null){
                $is_form_view=false;
            }else{
                $is_form_view=true;
            }
        }
      }
    }
        // end here for form
        
      $doc_latest_record = DB::table('tbl_course_wise_document')->orderBy('id', 'desc')
      ->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
      ->first();

      $get_remarks = DB::table('tbl_nc_comments_secretariat')->where([
        'application_id' => $application_id,
        'doc_unique_id' => $doc_unique_code,
        'doc_sr_code' => $doc_sr_code,                    
        'application_courses_id' => $application_courses_id
        
    ])
    ->whereNotNull("tp_remark")
    ->where('nc_type',$nc_type)
    ->select("tbl_nc_comments_secretariat.tp_remark","tbl_nc_comments_secretariat.created_at","tbl_nc_comments_secretariat.secretariat_id")
    ->first();

    //   $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
      $doc_path = URL::to("/documnet").'/'.$doc_name;
      return view('tp-upload-documents.tp-course-show-document-details', [
          'doc_latest_record' => $doc_latest_record,
          'doc_id' => $doc_sr_code,
          'doc_code' => $doc_unique_code,
          'application_course_id'=>$application_courses_id,
          'application_id' => $application_id,
          'doc_path' => $doc_path,
          'remarks' => $get_remarks,
          'nc_type'=>$nc_type,
          'is_form_view'=>$is_form_view,
      ]);
  }catch(Exception $e){
      return back()->with('fail','Something went wrong');
  }
  }


  public function tpCourseSubmitRemark(Request $request)
  {
      try{
        DB::beginTransaction();
        $submit_remark = DB::table('tbl_nc_comments_secretariat')->where(['application_id' => $request->application_id,'application_courses_id' => $request->application_course_id,'doc_sr_code' => $request->doc_sr_code,'doc_unique_id' => $request->doc_unique_id,'nc_type'=>$request->nc_type])->update(['tp_remark'=>$request->tp_remark]);
        if($submit_remark){
            DB::commit();
            return back()->with('success','Remark created successfully');
        }else{
            DB::rollback();
            return back()->with('fail','Failed to create remark');
        }
  }
  catch(Exception $e){
        DB::rollback();
      return back()->with('fail','Something went wrong');
  }
  }


  
  public function addCourseDocument(Request $request)
  {
     try{
        
      DB::beginTransaction();
      $tp_id = Auth::user()->id;
      $courseData = [];
      $courseData['application_id'] = $request->application_id;
      $courseData['course_id'] = $request->application_courses_id;
      $courseData['doc_sr_code'] = $request->doc_sr_code;
      $courseData['doc_unique_id'] = $request->doc_unique_id;
      $courseData['tp_id'] = $tp_id;
      
      $doc_extension = $request->file('fileup')->getClientOriginalExtension();
      if($request->doc_sr_code==config('constant.details.doc_sr_code') && (strtolower($doc_extension)!=='xlsx' && strtolower($doc_extension)!=='xls' && strtolower($doc_extension)!=='xlsb')){
        return response()->json(['success' => false,'message' =>'Invalid File Type'],200);
      }

      if ($request->hasfile('fileup')) {
          $file = $request->file('fileup');
          $name = $file->getClientOriginalName();
          $filename = time() . $name;
          $file->move('documnet/', $filename);
          $courseData['doc_file_name'] = $filename;
      }
     
      $course_doc_get = DB::table('tbl_course_wise_document')->where('application_id',$request->application_id)->first();
      
      $courseData['course_name'] = $course_doc_get->course_name;
      $courseData['level_id'] = $course_doc_get->level_id;

      
      $course_doc =  DB::table('tbl_course_wise_document')->insert($courseData);
      DB::table('tbl_course_wise_document')->where(['application_id'=> $request->application_id,'course_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id])->whereIn('status',[2,3,4])->update(['nc_flag'=>0,'admin_nc_flag'=>0]);

      
            
    
    //   $doc_size = $this->getFileSize($request->file('fileup')->getSize());
      
      
      $query = DB::table('tbl_application_courses')->where(['id'=>$request->application_courses_id,"application_id"=>$request->application_id]);
      if($request->doc_sr_code==config('constant.declaration.doc_sr_code')){
        $query->update(['declaration_pdf'=>$courseData['doc_file_name'],'pdf_1_file_extension'=>$doc_extension]);
      }
      if($request->doc_sr_code==config('constant.curiculam.doc_sr_code')){
        $query->update(['course_curriculum_pdf'=>$courseData['doc_file_name'],'pdf_2_file_extension'=>$doc_extension]);
      }
      if($request->doc_sr_code==config('constant.details.doc_sr_code')){
        $query->update(['course_details_xsl'=>$courseData['doc_file_name'],'xls_file_extension'=>$doc_extension]);
      }

      /*update nc table status oniste*/
    //   if($request->assessor_type=="onsite"){
    //       TblNCComments::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'onsite_nc_flag'=>0])->update(['onsite_nc_flag'=>1]);
          
    //       TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'assessor_type'=>'onsite'])->whereIn('onsite_status',[2,3,4])->update(['onsite_nc_status'=>0]);
    //   }
      /*end here*/ 
      $get_app = DB::table('tbl_application')->where('id',$request->application_id)->first();
            if($get_app->level_id==1){
                $url= config('notification.secretariatUrl.level1');
                $url=$url.dEncrypt($request->application_id);
                
            }else if($get_app->level_id==2){
                $url= config('notification.secretariatUrl.level2');
                $url=$url.dEncrypt($request->application_id);
                
            }else{
                $url= config('notification.secretariatUrl.level3');
                $url=$url.dEncrypt($request->application_id);
                
            }

            $notifiData = [];
            $notifiData['sender_id'] = Auth::user()->id;
            $notifiData['application_id'] = $request->application_id;
            $notifiData['uhid'] = getUhid( $request->application_id)[0];
            $notifiData['level_id'] = getUhid( $request->application_id)[1];
            $notifiData['data'] = config('notification.common.upload');
            $notifiData['user_type'] = "superadmin";
            $sUrl = config('notification.adminUrl.level1');
            $notifiData['url'] = $sUrl.dEncrypt($request->application_id);
      
            /*send notification*/ 
            sendNotification($notifiData);
            $notifiData['user_type'] = "secretariat";
            $notifiData['receiver_id'] = $get_app->secretariat_id;
            $notifiData['url'] = $url;
            sendNotification($notifiData);
            createApplicationHistory($request->application_id,null,config('history.common.upload'),config('history.color.warning'));
            /*end here*/ 
      
   
  

      if($course_doc){
      DB::commit();
      return response()->json(['success' => true,'message' =>'Document uploaded successfully'],200);
      }else{
          return response()->json(['success' => false,'message' =>'Failed to upload document'],200);
      }
  }
  catch(Exception $e){
      DB::rollback();
      return response()->json(['success' => false,'message' =>'Failed to upload document'],200);
  }
}



/*--Level 2----*/ 
public function upgradeNewApplication(Request $request){
    $application_id = $request->application_id;
    if ($application_id) {
        $applicationData = DB::table('tbl_application')->where('id', dDecrypt($application_id))->first();
    } else {
        $applicationData = null;
    }
    
    $id = Auth::user()->id;
    $item = LevelInformation::whereid('2')->get();
    
    $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
    
    return view('tp-view.upgrade-new-application', ['data' => $data, 'applicationData' => $applicationData, 'item' => $item]);
}

public function  storeNewApplication(Request $request)
{
    
    
    $application_date = Carbon::now()->addDays(364);

    $exist = TblApplication::where('id',$request->application_id)->where('upgraded_level_id',2)->first();
    if(!empty($exist)){
        return redirect(url('upgrade-create-new-course/' . dEncrypt($request->application_id).'/'.dEncrypt($request->reference_id)))->with('success', "Application updated successfully.");
        
    }
    
    $saarc_country = [1,19,26,133,154,167,208];
    $india = [101];
    $region="";
    if(in_array(Auth::user()->country,$india)){
        $region ="ind";
    }else if(in_array(Auth::user()->country,$saarc_country)){
        $region ="saarc";
    }else{
        $region ="other";
    }
   
    /*check if application already created*/
            $data = [];
            $data['level_id'] = 2;
            $data['tp_id'] = $request->user_id;
            $data['person_name'] = $request->person_name;
            $data['email'] =  $request->email;
            $data['contact_number'] = $request->contact_number;
            $data['designation'] = $request->designation;
            $data['tp_ip'] = getHostByName(getHostName());
            $data['user_type'] = 'tp';
            // $data['refid'] = $request->reference_id;
            $data['prev_refid'] = $request->reference_id;
            $data['application_date'] = $application_date;
            $data['region'] = $region;
            // TblApplication::where('id',$request->application_id)->update(['upgraded_level_id'=>2]);
            $application = new TblApplication($data);
            $application->save();
            TblApplication::where('id',$request->application_id)->update(['upgraded_level_id'=>2,'prev_id'=>$application->id]);
            $application->prev_refid = $request->reference_id;
            $application->save();            
            $create_new_application = $application->id;
            $msg="Application Created Successfully";
            $first_application = TblApplication::where('refid',$request->reference_id)->first();
            if(!empty($first_application)){
                TblApplication::where('id',$first_application->id)->update(['is_all_course_doc_verified'=>2]);
            }

        
    /*end here*/
    return redirect(url('upgrade-create-new-course/' . dEncrypt($create_new_application).'/'.dEncrypt($request->reference_id)))->with('success', $msg);
}

public function upgradeCreateNewCourse($id = null,$refid=null)
{
    if($id) $id = dDecrypt($id);
    if($refid) $refid = dDecrypt($refid);
    if ($id) {
        $applicationData = TblApplication::where('id',$id)->latest()->first();
    }else{
        $applicationData=null;
    }
    $first_application_id = TblApplication::where('refid',$refid)->first();
    
    $last_application_id =  $id;
    
    $old_courses = TblApplicationCourses::where('application_id',$first_application_id->id)->where('deleted_by_tp',0)->whereNotIn('status',[1,3])->whereNull('deleted_at')->get();
    
    // $last_application = TblApplication::where('refid',$refid)->first();
    $course = TblApplicationCourses::where('application_id', $last_application_id)->whereNull('deleted_at')->get();
    // dd($course);
    $uploaded_docs = DB::table('tbl_application_course_doc')->where('application_id',$last_application_id)->where('approve_status',1)->whereNull('deleted_at')->count();
    $total_docs = count($course) * 4;
    
    $is_show_next_btn = false;
    if($uploaded_docs==$total_docs){
        $is_show_next_btn=true;
    }
    $original_course_count = TblApplicationCourses::where('application_id', $id)->whereNull('deleted_at')->count();
    
    return view('tp-view.create-course', compact('applicationData', 'course','original_course_count','old_courses','is_show_next_btn'));
}


public function deleteCourse($id,$course_id){
    try{
        DB::beginTransaction();
        $is_course_deleted = TblApplicationCourses::where('id',$course_id)->update(['deleted_by_tp'=>1]);
        if($is_course_deleted){
            DB::commit();
            return response()->json(['success' => true,'message' =>'Course Deleted Successfully.'],200);
        }else{
            DB::rollBack();
            return response()->json(['success' => false,'message' =>'Failed to delete course.'],400);
        }
    }catch(Exception $e){
        DB::rollBack();
        return response()->json(['success' => false,'message' =>'Failed to delete course.'],500);
    }
}


public function upgradeStoreNewApplicationCourse(Request $request)
{

    
    try{
        $reference_id = TblApplication::where('id',$request->application_id)->first()->refid;
        
        $course_name = $request->course_name;
        $lowercase_course_name = array_map('strtolower', $course_name);
        $is_course_name_already_exists =TblApplicationCourses::where(['application_id' => $request->application_id,'deleted_at'=>null,'level_id'=>2])->whereIn('course_name', $lowercase_course_name)->get();
        if(count($is_course_name_already_exists)>0){
            return  redirect('upgrade-create-new-course/' . dEncrypt($request->application_id))->with('fail', 'Course name already exists on this application');
        }
        $value_counts = array_count_values($lowercase_course_name);
            foreach ($value_counts as $value => $count) {
                if ($count > 1) {
                    return  redirect('upgrade-create-new-course/' . dEncrypt($request->application_id))->with('fail', 'Failed to create course with same course name');
                }
            }
        $course_duration = $request->course_duration;
        $eligibility = $request->eligibility;
        $mode_of_course = $request->mode_of_course;
        $course_brief = $request->course_brief;
        $years = $request->years;
        $months = $request->months;
        $days = $request->days;
        $hours = $request->hours;
        //document upload
        
        if ($request->hasfile('doc1')) {
            $doc1 = $request->file('doc1');
        }
        if ($request->hasfile('doc2')) {
            $doc2 = $request->file('doc2');
        }
        if ($request->hasfile('doc3')) {
            $doc3 = $request->file('doc3');
        }
        
        for ($i = 0; $i < count($course_name); $i++) {
            if (empty($course_name[$i])) {
                continue;
            }
            $file = new TblApplicationCourses();
            
            $file->application_id = $request->application_id;
            $file->course_name = $course_name[$i];
            $file->course_duration_y = $years[$i];
            $file->course_duration_m = $months[$i];
            $file->course_duration_d = $days[$i];
            $file->course_duration_h = $hours[$i];
            $file->level_id = $request->level_id;
            $file->eligibility = $eligibility[$i];
            $file->mode_of_course = "online";
            // $file->mode_of_course = collect($mode_of_course[$i])->implode(',');
            $file->course_brief = $course_brief[$i];
            $file->tp_id = Auth::user()->id;
            $file->refid = $request->reference_id;
           
    
    
            $doc_size_1 = $this->getFileSize($request->file('doc1')[$i]->getSize());
            $doc_extension_1 = $request->file('doc1')[$i]->getClientOriginalExtension();
            $doc_size_2 = $this->getFileSize($request->file('doc2')[$i]->getSize());
            $doc_extension_2 = $request->file('doc2')[$i]->getClientOriginalExtension();
            $doc_size_3 = $this->getFileSize($request->file('doc3')[$i]->getSize());
            $doc_extension_3 = $request->file('doc3')[$i]->getClientOriginalExtension();
    
            $timestamp = now()->format('YmdHis'); 
            $randomString = Str::random(8);
            $name = $doc1[$i]->getClientOriginalName();
            $filename="{$timestamp}_{$randomString}".$name;
            $doc1[$i]->move('documnet/', $filename);
            $file->declaration_pdf =  $filename;
            
            

            $doc2 = $request->file('doc2');
            $timestamp = now()->format('YmdHis'); 
            $randomString = Str::random(8);
            $name = $doc2[$i]->getClientOriginalName();
            $filename="{$timestamp}_{$randomString}".$name;
            $doc2[$i]->move('documnet/', $filename);
            $file->course_curriculum_pdf =  $filename;
            
            

            $img = $request->file('doc3');
            $timestamp = now()->format('YmdHis'); 
            $randomString = Str::random(8);
            $name = $doc3[$i]->getClientOriginalName();
            $filename="{$timestamp}_{$randomString}".$name;
            $doc3[$i]->move('documnet/', $filename);
            $file->course_details_xsl =  $filename;
            
    
    
            $file->pdf_1_file_size = $doc_size_1 ;
            $file->pdf_1_file_extension =$doc_extension_1;
            $file->pdf_2_file_size = $doc_size_2 ;
            $file->pdf_2_file_extension =$doc_extension_2;
            $file->xls_file_size = $doc_size_3 ;
            $file->xls_file_extension =$doc_extension_3;
            $file->refid =$reference_id;
            $file->save();
            
             /*course wise doc create*/ 
             
             for($j=0;$j<3;$j++){
             $data = [];
             if($j==0){
                $data['doc_file_name'] = $file->declaration_pdf;
                $data['doc_sr_code'] = config('constant.declaration.doc_sr_code');
                $data['doc_unique_id'] = config('constant.declaration.doc_unique_id');
             }
             if($j==1){
                $data['doc_file_name'] = $file->course_curriculum_pdf;
                $data['doc_sr_code'] = config('constant.curiculum.doc_sr_code');
                $data['doc_unique_id'] = config('constant.curiculum.doc_unique_id');
             }
             if($j==2){
                $data['doc_file_name'] = $file->course_details_xsl;
                $data['doc_sr_code'] = config('constant.details.doc_sr_code');
                $data['doc_unique_id'] = config('constant.details.doc_unique_id');
             }
             $data['application_id'] = $request->application_id;
             $data['course_id'] = $file->id;
             $data['tp_id'] = Auth::user()->id;
             $data['level_id'] = $request->level_id;
             $data['course_name'] = $course_name[$i];
             $data['is_doc_show'] = 0;
             
             DB::table('tbl_course_wise_document')->insert($data);
            }
        }
        
        
          return redirect('/upgrade-create-new-course/' . dEncrypt($request->application_id).'/'.dEncrypt($reference_id))->with('success', 'Course  successfully  Added');
    }  catch(Exception $e){
          return redirect('upgrade-create-new-course/' . dEncrypt($request->application_id).'/'.dEncrypt($reference_id))->with('fail', 'Failed to create course');
    }
   
    
}



public function upgradeShowcoursePayment(Request $request, $id = null)
    {
        
        $id = dDecrypt($id);
        
        $checkPaymentAlready = DB::table('tbl_application_payment')->where('application_id', $id)->whereNull('payment_ext')->where('pay_status','Y')->count();
       
        if ($checkPaymentAlready>1) {
                return redirect(url('get-application-list'))->with('fail', 'Payment has already been submitted for this application.');
        }
        if ($id) {
            $applicationData = DB::table('tbl_application')->where('id', $id)->first();
            
            $get_assessor_user = DB::table('assessor_final_summary_reports')->where('application_id',$id)->count();

            $course = DB::table('tbl_application_courses')->where('application_id', $id)->get();
            if (Auth::user()->country == $this->get_india_id()) {
                    $total_amount = $this->getPaymentFeeLevel2('level-2',"INR",$id);
                    $currency = '₹';
            }
            else if(in_array(Auth::User()->country,$this->get_saarc_ids())){
                $total_amount = $this->getPaymentFeeLevel2('level-2',"USD",$id);
                $currency = '$';
            }
             else {
                $total_amount = $this->getPaymentFeeLevel2('level-2',"OTHER",$id);
                $currency = '$';
                
            }
        }
        return view('tp-view.show-course-payment', compact('applicationData', 'course', 'currency', 'total_amount'));
    }
    


    public function upgradeNewApplicationPayment(Request $request)
    {
        
        
        
        $first_app_refid = TblApplication::where('id',$request->Application_id)->first();
        $first_app_id = TblApplication::where('refid',$first_app_refid->prev_refid)->first();
        

        $get_assessor_user = DB::table('assessor_final_summary_reports')->where('application_id',$request->Application_id)->count();
        

        $get_all_account_users = DB::table('users')->whereIn('role',[1,6])->get()->pluck('email')->toArray();
        $get_all_admin_users = DB::table('users')->where('role',1)->get()->pluck('email')->toArray();

        $request->validate([
            'transaction_no' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:application_payments,transaction_no',
            'reference_no' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:application_payments,reference_no',
            'payment' => 'required',
        ], [
            'transaction_no.required' => 'The transaction number is required.',
            'transaction_no.unique' => 'The transaction number is already in use.',
            'transaction_no.regex' => 'The transaction number must not contain special characters or spaces.',
            'reference_no.required' => 'The reference number is required.',
            'reference_no.unique' => 'The reference number is already in use.',
            'reference_no.regex' => 'The reference number must not contain special characters or spaces.',
            'payment.required' => 'Please select a payment mode.'
        ]);
       try{
        DB::beginTransaction();
        $id = $request->Application_id;
        if (Auth::user()->country == $this->get_india_id()) {
                $total_amount = $this->getPaymentFeeLevel2('level-2',"INR",$id);
                $currency = '₹';
        }
        else if(in_array(Auth::User()->country,$this->get_saarc_ids())){
            $total_amount = $this->getPaymentFeeLevel2('level-2',"USD",$id);
            $currency = '$';
        }
         else {
            $total_amount = $this->getPaymentFeeLevel2('level-2',"OTHER",$id);
            $currency = '$';
        }
        $transactionNumber = trim($request->transaction_no);
        $referenceNumber = trim($request->reference_no);
        $is_exist_t_num_or_ref_num = DB::table('tbl_application_payment')
                                    ->where('payment_transaction_no', $transactionNumber)
                                    ->orWhere('payment_reference_no', $referenceNumber)
                                    ->whereNull('payment_ext')->where('pay_status','Y')
                                    ->first();
        
        if(!empty($is_exist_t_num_or_ref_num)){
            return  back()->with('fail', 'Reference number or Transaction number already exists');
        }

        /*Implemented by suraj*/
          $get_final_summary = DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->Application_id,'payment_status'=>0,'assessor_type'=>'desktop'])->first();
          if(!empty($get_final_summary)){
            DB::table('assessor_final_summary_reports')->where('application_id',$request->Application_id)->update(['payment_status' => 1]);
          }
        /*end here*/
        $checkPaymentAlready = TblApplicationPayment::where('application_id', $request->Application_id)
        ->where('pay_status','Y')
        ->whereNull('remark_by_account')
        ->count();
            if ($checkPaymentAlready>2) {
                return redirect(url('level-second/tp/application-list'))->with('fail', 'Payment has already been submitted for this application.');
            }
        $this->validate($request, [
            'payment_details_file' => 'mimes:pdf,jpeg,png,jpg,gif,svg',
        ]);

        $getcountryCode = DB::table('countries')->where([['id',Auth::user()->country]])->first();
        $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>$getcountryCode->currency,'level'=>'level-2'])->first();
        $item = new TblApplicationPayment;
        $item->level_id = $request->level_id;
        $item->user_id = Auth::user()->id;
        $item->amount = $total_amount;
        $item->other_country_payment = $get_payment_list->dollar_fee??null;
        $item->pay_status = 'Y';
        $item->payment_date = date("d-m-Y");
        $item->payment_mode = $request->payment;
        $item->payment_transaction_no = $transactionNumber;
        $item->payment_reference_no = $referenceNumber;
        $item->currency =  $getcountryCode->currency??'INR';
        $item->application_id = $request->Application_id;
        if ($request->hasfile('payment_details_file')) {
            $img = $request->file('payment_details_file');
            $name = $img->getClientOriginalName();
            $filename = rand().'-'.time().'-'.rand() . $name;
            $img->move('uploads/', $filename);
            $item->payment_proof = $filename;
        }
        $item->save();



        /*is_tp_revert make it 1 first time*/ 
        DB::table('tbl_application_course_doc')->where('application_id',$request->Application_id)->update(['is_tp_revert'=>1]);
        /*end here*/ 

         /*send notification*/ 
         $notifiData = [];
         $notifiData['user_type'] = "accountant";
         $notifiData['sender_id'] = Auth::user()->id;
         $notifiData['application_id'] =$request->Application_id;
         $notifiData['uhid'] = getUhid($request->Application_id)[0];
         $notifiData['level_id'] = getUhid($request->Application_id)[1] ;
         $acUrl = config('notification.accountantUrl.level1');
         $notifiData['url'] = $acUrl.dEncrypt($request->Application_id);
         $notifiData['data'] = config('notification.accountant.appCreated');
         sendNotification($notifiData);
         createApplicationHistory($request->Application_id,null,config('history.accountant.appCreated'),config('history.color.warning'));
         /*end here*/ 

        if(isset($first_app_id)){
            DB::table('tbl_application')->where('id',$first_app_id->id)->update(['is_all_course_doc_verified'=>3]);
        }

        // this is for the applicaion status
        DB::table('tbl_application')->where('id',$request->Application_id)->update(['payment_status'=>5,'status'=>0]);

        DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->Application_id])->update(['second_payment_status' => 1]);

        $application_id = $request->Application_id;
        $userid = Auth::user()->firstname;

        DB::table('tbl_application')->where('id',$request->Application_id)->update(['payment_status'=>5]); //payment_status 5 is for done payment by TP.


        foreach ($request->course_id as $items) {
                $ApplicationCourse = TblApplicationCourses::where('id',$items);
                $ApplicationCourse->update(['payment_status' =>1]);
            }
            
            /**
             * Send Email to Accountant
             * */ 
            foreach($get_all_account_users as $email){ 
                $title="New Application Created - Welcome Aboard : RAVAP-".$application_id;
                $subject="New Application Created - Welcome Aboard : RAVAP-".$application_id;
                
                $body="Dear Team,".PHP_EOL."
                I trust this message finds you well. I am writing to request the approval of the payment associated with my recent application for RAVAP-".$application_id." submitted on ".date('d-m-Y').". As part of the application process, a payment of Rs.".$request->amount." was made under the transaction reference ID ".$referenceNumber.". ".PHP_EOL."
                Here are the transaction details: ".PHP_EOL."
                Transaction ID: ".$transactionNumber." ".PHP_EOL."
                Payment Amount: ".$request->amount." ".PHP_EOL."
                Payment Date: ".date("Y-m-d", strtotime($request->payment_date))." ".PHP_EOL."
                
                Best regard,".PHP_EOL."
                RAV Team";

                $details['email'] = $email;
                $details['title'] = $title; 
                $details['subject'] = $subject; 
                $details['body'] = $body; 
                 if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
            }

            foreach($get_all_admin_users as $email){
                $title="New Application Created | RAVAP-".$application_id;
                $subject="New Application Created | RAVAP-".$application_id;
                $body="Dear Team,".PHP_EOL."

                We are thrilled to inform you that your application has been successfully processed, and we are delighted to welcome you to our RAVAP family! Your dedication and skills have truly impressed us, and we are excited about the positive impact we believe you will make.".PHP_EOL."
               Best regard,".PHP_EOL."
               RAV Team";

                $details['email'] = $email;
                $details['title'] = $title; 
                $details['subject'] = $subject; 
                $details['body'] = $body; 
                 if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
            }
            
            //tp email
               $body = "Dear ,".Auth::user()->firstname." ".PHP_EOL."
               We are thrilled to inform you that your application has been successfully processed, and we are delighted to welcome you to our RAVAP family! Your dedication and skills have truly impressed us, and we are excited about the positive impact we believe you will make. ".PHP_EOL."
               Best regards,".PHP_EOL."
               RAV Team";

                $details['email'] = Auth::user()->email;
                $details['title'] = "Payment Approval | RAVAP-".$application_id; 
                $details['subject'] = "Payment Approval | RAVAP-".$application_id; 
                $details['body'] = $body; 
                 if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
            /*send email end here*/ 
            DB::commit();
            return  redirect(url('/level-second/tp/application-list/'))->with('success', 'Payment Done successfully');
         
       }
       catch(Exception $e){
        DB::rollback();
        return  redirect('/level-fourth')->with('fail', 'Failed to make payment');
       }
    }



    
    public function upgradeGetApplicationView($id){
        
        $application = DB::table('tbl_application')
        ->where('id', dDecrypt($id))
        ->first();
        $json_course_doc = File::get(base_path('/public/course-doc/courses.json'));
        $decoded_json_courses_doc = json_decode($json_course_doc);
        
        
        $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->whereNull('payment_ext')->where('pay_status','Y')->latest('id')->first();


        $app_payment = DB::table('tbl_application_payment')->where('application_id',dDecrypt($id))->whereNull('payment_ext')->where('pay_status','Y')->count();
        $get_application = DB::table('tbl_application')->where('id',dDecrypt($id))->first();

            $assessor_type = "";
            if($get_application->level_id==2){
                $assessor_type="secretariat";
            }else if($get_application->level_id==3){
                if($app_payment>1){
                    $assessor_type="onsite";
                }else{
                    $assessor_type="desktop";
                }
            }

            $show_submit_btn_to_tp = $this->isShowSubmitBtnToSecretariat(dDecrypt($id),$assessor_type);
            $enable_disable_submit_btn = $this->checkSubmitButtonEnableOrDisable(dDecrypt($id),$assessor_type);
            $showSubmitBtnToTP = $this->checkReuploadBtn($application->id);

            $obj = new \stdClass;
            $obj->is_all_revert_action_done=$this->checkAllActionDoneOnRevert($application->id);
            
            $obj->is_all_revert_action_done44=$this->checkAllActionDoneOnRevert44($application->id);
            $obj->application= $application;
            $courses = DB::table('tbl_application_courses')->where([
                'application_id'=>$application->id,
                
            ])
            // ->whereIn('status',[0,2]) 
            ->whereNull('deleted_at') 
            ->get();
            // dd($courses);
            foreach ($courses as $course) {
                if ($course) {
                    $course_docs=$this->isNcOnCourseDocs($application->id, $course->id);
                if($application->level_id!=1){
                    $course_docs_lists=$this->isNcOnCourseDocsList($application->id, $course->id);
                }
                    $obj->course[] = [
                        "course" => $course,
                        'course_wise_document_declaration' => DB::table('tbl_course_wise_document')->where([
                            'application_id' => $application->id,
                            'course_id' => $course->id,
                            'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                            'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                        ])->get(),
                        'isAnyNcOnCourse'=>$course_docs,
                        'isAnyNcOnCourseDocList'=>$course_docs_lists??false,

                            'course_wise_document_curiculum' => DB::table('tbl_course_wise_document')->where([
                                'application_id' => $application->id,
                                'course_id' => $course->id,
                                'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                                'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                            ])->get(),
            
                            'course_wise_document_details' => DB::table('tbl_course_wise_document')->where([
                                'application_id' => $application->id,
                                'course_id' => $course->id,
                                'doc_sr_code' => config('constant.details.doc_sr_code'),
                                'doc_unique_id' => config('constant.details.doc_unique_id'),
                            ])->get(),
                        'nc_comments_course_declaration' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                            'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                            'nc_show_status'=>1
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get(),
            
                        'nc_comments_course_curiculam' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                            'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                            'nc_show_status'=>1
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get(),
            
                        'nc_comments_course_details' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.details.doc_sr_code'),
                            'doc_unique_id' => config('constant.details.doc_unique_id'),
                            'nc_show_status'=>1
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get()
                    ]; // Added semicolon here
                }
            }

                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                    'payment_ext'=>null,
                    'pay_status'=>'Y'
                ])->get();
                $additional_payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                    'payment_ext'=>'add',
                    'pay_status'=>'Y'
                ])->get();
                if($payment){
                    $obj->payment = $payment;
                    $obj->additional_payment = $additional_payment;
                }
                $final_data = $obj;
                $tp_final_summary_count =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id])->count();
                if($tp_final_summary_count>1){
                 $is_final_submit = true;
                }else{
                 $is_final_submit = false;
                }
        return view('tp-view.upgrade-application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit,'courses_doc'=>$decoded_json_courses_doc,'show_submit_btn_to_tp'=>$show_submit_btn_to_tp,'enable_disable_submit_btn'=>$enable_disable_submit_btn,'showSubmitBtnToTP'=>$showSubmitBtnToTP]);
    }

  


    public function newAdditionalApplicationPaymentFee(Request $request)
    {
        
        
        $first_app_refid = TblApplication::where('id',$request->Application_id)->first();
        $first_app_id = TblApplication::where('refid',$first_app_refid->refid)->first();
        

        $get_assessor_user = DB::table('assessor_final_summary_reports')->where('application_id',$request->Application_id)->count();
        

        $get_all_account_users = DB::table('users')->whereIn('role',[1,6])->get()->pluck('email')->toArray();
        $get_all_admin_users = DB::table('users')->where('role',1)->get()->pluck('email')->toArray();

        $request->validate([
            'transaction_no' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:application_payments,transaction_no',
            'reference_no' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:application_payments,reference_no',
            'payment' => 'required',
        ], [
            'transaction_no.required' => 'The transaction number is required.',
            'transaction_no.unique' => 'The transaction number is already in use.',
            'transaction_no.regex' => 'The transaction number must not contain special characters or spaces.',
            'reference_no.required' => 'The reference number is required.',
            'reference_no.unique' => 'The reference number is already in use.',
            'reference_no.regex' => 'The reference number must not contain special characters or spaces.',
            'payment.required' => 'Please select a payment mode.'
        ]);
       try{
        DB::beginTransaction();
        
        $transactionNumber = trim($request->transaction_no);
        $referenceNumber = trim($request->reference_no);
        $is_exist_t_num_or_ref_num = DB::table('tbl_application_payment')
                                    ->where('payment_transaction_no', $transactionNumber)
                                    ->orWhere('payment_reference_no', $referenceNumber)
                                    ->first();
        
        if(!empty($is_exist_t_num_or_ref_num)){
            return  back()->with('fail', 'Reference number or Transaction number already exists');
        }

        $this->validate($request, [
            'payment_details_file' => 'mimes:pdf,jpeg,png,jpg,gif,svg',
        ]);
        $application_id = $request->Application_id;
/*calculate amount according to level and courses*/ 
                
                $country_details = DB::table('countries')->where('id',Auth::user()->country)->first();
                $get_app = DB::table('tbl_application')->where('id',$application_id)->first();
                $total_amount = $get_app->raise_amount;
                $payment_type = $get_app->payment_type_level;
        
        $data = [];
        $data['application_id'] = $request->Application_id;
        $data['payment_type'] = $payment_type;
        $data['payment_mode'] = $request->payment;
        $data['amount'] =$total_amount; 
        $data['currency'] = $country_details->currency;
        $data['payment_date'] = date("d-m-Y");
        $data['payment_transaction_no'] = $request->transaction_no;
        $data['payment_reference_no'] = $request->reference_no;
        $data['tp_id'] = Auth::user()->id;
        
        if ($request->hasfile('payment_details_file')) {
            $img = $request->file('payment_details_file');
            $name = $img->getClientOriginalName();
            $filename = rand().'-'.time().'-'.rand() . $name;
            $img->move('uploads/', $filename);
            $data['payment_proof'] = $filename;
        }
        $make_additional_pay = DB::table('tbl_application_payment')->insert($data);

            /**
             * Send Email to Accountant
             * */ 
            foreach($get_all_account_users as $email){
                $title="New Application Created - Welcome Aboard : RAVAP-".$application_id;
                $subject="New Application Created - Welcome Aboard : RAVAP-".$application_id;
                
                $body="Dear Team,".PHP_EOL."
                I trust this message finds you well. I am writing to request the approval of the payment associated with my recent application for RAVAP-".$application_id." submitted on ".date('d-m-Y').". As part of the application process, a payment of Rs.".$request->amount." was made under the transaction reference ID ".$referenceNumber.". ".PHP_EOL."
                Here are the transaction details: ".PHP_EOL."
                Transaction ID: ".$transactionNumber." ".PHP_EOL."
                Payment Amount: ".$request->amount." ".PHP_EOL."
                Payment Date: ".date("Y-m-d", strtotime($request->payment_date))." ".PHP_EOL."
                
                Best regard,".PHP_EOL."
                RAV Team";

                $details['email'] = $email;
                $details['title'] = $title; 
                $details['subject'] = $subject; 
                $details['body'] = $body; 
                 if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
            }

            foreach($get_all_admin_users as $email){
                $title="New Application Created | RAVAP-".$application_id;
                $subject="New Application Created | RAVAP-".$application_id;
                $body="Dear Team,".PHP_EOL."

                We are thrilled to inform you that your application has been successfully processed, and we are delighted to welcome you to our RAVAP family! Your dedication and skills have truly impressed us, and we are excited about the positive impact we believe you will make.".PHP_EOL."
               Best regard,".PHP_EOL."
               RAV Team";

                $details['email'] = $email;
                $details['title'] = $title; 
                $details['subject'] = $subject; 
                $details['body'] = $body; 
                 if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
            }
            
            //tp email
               $body = "Dear ,".Auth::user()->firstname." ".PHP_EOL."
               We are thrilled to inform you that your application has been successfully processed, and we are delighted to welcome you to our RAVAP family! Your dedication and skills have truly impressed us, and we are excited about the positive impact we believe you will make. ".PHP_EOL."
               Best regards,".PHP_EOL."
               RAV Team";

                $details['email'] = Auth::user()->email;
                $details['title'] = "Payment Approval | RAVAP-".$application_id; 
                $details['subject'] = "Payment Approval | RAVAP-".$application_id; 
                $details['body'] = $body; 
                 if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
                // createApplicationHistory($application_id,null,config('history.tp.status'),config('history.color.danger'));
            /*send email end here*/ 
            
            DB::table('tbl_application')->where('id',$application_id)->update(['is_query_raise'=>2]);/*additional payment done by tp*/
            if($make_additional_pay){
                DB::commit();
                return  redirect(url('/tp/application-payment-fee-list'))->with('success', 'Payment Done successfully');
            }else{
                DB::commit();
                return  redirect(url('/tp/application-payment-fee-list'))->with('fail', 'Failed to make additional payment');
            }
       }
       catch(Exception $e){
        DB::rollback();
        return  redirect(url('/tp/application-payment-fee-list'))->with('fail', 'Something went wrong!');
       }
    }


    function get_india_id()
    {
        $india = Country::where('name', 'India')->get('id')->first();
        return $india->id;
    }
/*end here*/ 












/*--Level 3----*/ 
public function upgradeNewApplicationLevel3(Request $request,$application_id,$prev_refid){

    
    
    if ($application_id) {
        $applicationData = DB::table('tbl_application')->where('id', dDecrypt($application_id))->first();
    } else {
        $applicationData = null;
    }

    $prev_refid = dDecrypt($prev_refid);
    $id = Auth::user()->id;
    $item = LevelInformation::whereid('3')->get();
    
    $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
    
    return view('tp-view.level3-upgrade-new-application', ['data' => $data, 'applicationData' => $applicationData, 'item' => $item,'prev_refid'=>$prev_refid]);
}

public function  storeNewApplicationLevel3(Request $request)
{
    // dd($request->all());
    $application_date = Carbon::now()->addDays(364);
    
    $exist = TblApplication::where('id',$request->application_id)->where('upgraded_level_id',3)->first();
    if(!empty($exist)){
        return redirect(url('upgrade-level-3-create-new-course/' . dEncrypt($request->application_id).'/'.dEncrypt($request->reference_id)))->with('success', "Application updated successfully.");
    }
    /*check if application already created*/
    $saarc_country = [1,19,26,133,154,167,208];
        $india = [101];
        $region="";
        if(in_array(Auth::user()->country,$india)){
            $region ="ind";
        }else if(in_array(Auth::user()->country,$saarc_country)){
            $region ="saarc";
        }else{
            $region ="other";
        }
            $data = [];
            $data['level_id'] = 3;
            $data['tp_id'] = $request->user_id;
            $data['person_name'] = $request->person_name;
            $data['email'] =  $request->email;
            $data['contact_number'] = $request->contact_number;
            $data['designation'] = $request->designation;
            $data['tp_ip'] = getHostByName(getHostName());
            $data['user_type'] = 'tp';
            $data['region'] = $region;
            $data['prev_refid'] = $request->prev_refid?$request->prev_refid : $request->reference_id;
            $data['application_date'] = $application_date;
            
    
            
            
            $application = new TblApplication($data);
            $application->save();

            TblApplication::where('id',$request->application_id)->update(['upgraded_level_id'=>3,'prev_id'=>$application->id]);

            $create_new_application = $application->id;
            $msg="Application Created Successfully";
            $first_application = TblApplication::where('refid',$request->reference_id)->first();
            if(!empty($first_application)){
                TblApplication::where('id',$first_application->id)->update(['is_all_course_doc_verified'=>2]);
            }


        
    /*end here*/
    return redirect(url('upgrade-level-3-create-new-course/' . dEncrypt($create_new_application).'/'.dEncrypt($request->reference_id)))->with('success', $msg);
}

public function upgradeCreateNewCourseLevel3($id = null,$refid=null)
{
    // dd(dDecrypt($id));
    
    if($id) $id = dDecrypt($id);
    if($refid) $refid = dDecrypt($refid);
    
    if ($id) {
        $applicationData = TblApplication::where('id',$id)->first();
    }else{
        $applicationData=null;
    }

    $old_app = TblApplication::where('prev_id',$id)->first();
    $old_courses =[];
    if(isset($old_app)){
        $old_courses = TblApplicationCourses::where('application_id',$old_app->id)->where('deleted_by_tp',0)->get();
    }
  
    $course = TblApplicationCourses::where('application_id', $id)->get();
    
    $original_course_count = TblApplicationCourses::where('application_id', $id)->whereNull('deleted_at')->count();
    $uploaded_docs = DB::table('tbl_application_course_doc')->whereNull('deleted_at')->where('application_id',$id)->where('approve_status',1)->count();
    $total_docs = $original_course_count * 4;

    $is_show_next_btn = false;
    if($uploaded_docs==$total_docs){
        $is_show_next_btn=true;
    }
    

    return view('tp-view.level3-create-course', compact('applicationData', 'course','original_course_count','old_courses','is_show_next_btn'));
}


public function deleteCourseLevel3($id,$course_id){
    try{
        DB::beginTransaction();
        $is_course_deleted = TblApplicationCourses::where('id',$course_id)->update(['deleted_by_tp'=>1]);
        if($is_course_deleted){
            DB::commit();
            return response()->json(['success' => true,'message' =>'Course Deleted Successfully.'],200);
        }else{
            DB::rollBack();
            return response()->json(['success' => false,'message' =>'Failed to delete course.'],400);
        }
    }catch(Exception $e){
        DB::rollBack();
        return response()->json(['success' => false,'message' =>'Failed to delete course.'],500);
    }
}


public function upgradeStoreNewApplicationCourseLevel3(Request $request)
{

    
    try{
        // dd($request->all());
        $reference_id = TblApplication::where('id',$request->application_id)->first()->refid;
        $course_name = $request->course_name;
        $lowercase_course_name = array_map('strtolower', $course_name);
        $is_course_name_already_exists =TblApplicationCourses::where(['application_id' => $request->application_id,'deleted_at'=>null,'level_id'=>3])->whereIn('course_name', $lowercase_course_name)->get();
        if(count($is_course_name_already_exists)>0){
            return  redirect('upgrade-level-3-create-new-course/' . dEncrypt($request->application_id))->with('fail', 'Course name already exists on this application');
        }
        $value_counts = array_count_values($lowercase_course_name);
            foreach ($value_counts as $value => $count) {
                if ($count > 1) {
                    return  redirect('upgrade-level-3-create-new-course/' . dEncrypt($request->application_id))->with('fail', 'Failed to create course with same course name');
                }
            }
        $course_duration = $request->course_duration;
        $eligibility = $request->eligibility;
        $mode_of_course = $request->mode_of_course;
        $course_brief = $request->course_brief;
        $years = $request->years;
        $months = $request->months;
        $days = $request->days;
        $hours = $request->hours;
        //document upload
        
        if ($request->hasfile('doc1')) {
            $doc1 = $request->file('doc1');
        }
        if ($request->hasfile('doc2')) {
            $doc2 = $request->file('doc2');
        }
        if ($request->hasfile('doc3')) {
            $doc3 = $request->file('doc3');
        }
        
        for ($i = 0; $i < count($course_name); $i++) {
            if (empty($course_name[$i])) {
                continue;
            }
            $file = new TblApplicationCourses();
            
            $file->application_id = $request->application_id;
            $file->course_name = $course_name[$i];
            $file->course_duration_y = $years[$i];
            $file->course_duration_m = $months[$i];
            $file->course_duration_d = $days[$i];
            $file->course_duration_h = $hours[$i];
            $file->level_id = 3;
            $file->eligibility = $eligibility[$i];
            $file->mode_of_course = "online";
            // $file->mode_of_course = collect($mode_of_course[$i])->implode(',');
            $file->course_brief = $course_brief[$i];
            $file->tp_id = Auth::user()->id;
            $file->refid = $request->reference_id;
           
    
    
            $doc_size_1 = $this->getFileSize($request->file('doc1')[$i]->getSize());
            $doc_extension_1 = $request->file('doc1')[$i]->getClientOriginalExtension();
            $doc_size_2 = $this->getFileSize($request->file('doc2')[$i]->getSize());
            $doc_extension_2 = $request->file('doc2')[$i]->getClientOriginalExtension();
            $doc_size_3 = $this->getFileSize($request->file('doc3')[$i]->getSize());
            $doc_extension_3 = $request->file('doc3')[$i]->getClientOriginalExtension();
    
            $name = $doc1[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc1[$i]->move('documnet/', $filename);
            $file->declaration_pdf =  $filename;
            
            
    
            $doc2 = $request->file('doc2');
            $name = $doc2[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc2[$i]->move('documnet/', $filename);
            $file->course_curriculum_pdf =  $filename;
            
            
    
            $img = $request->file('doc3');
            $name = $doc3[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc3[$i]->move('documnet/', $filename);
            $file->course_details_xsl =  $filename;
            
    
    
            $file->pdf_1_file_size = $doc_size_1 ;
            $file->pdf_1_file_extension =$doc_extension_1;
            $file->pdf_2_file_size = $doc_size_2 ;
            $file->pdf_2_file_extension =$doc_extension_2;
            $file->xls_file_size = $doc_size_3 ;
            $file->xls_file_extension =$doc_extension_3;
            $file->refid =$reference_id;
            $file->save();
            
             /*course wise doc create*/ 
             
             for($j=0;$j<3;$j++){
             $data = [];
             if($j==0){
                $data['doc_file_name'] = $file->declaration_pdf;
                $data['doc_sr_code'] = config('constant.declaration.doc_sr_code');
                $data['doc_unique_id'] = config('constant.declaration.doc_unique_id');
             }
             if($j==1){
                $data['doc_file_name'] = $file->course_curriculum_pdf;
                $data['doc_sr_code'] = config('constant.curiculum.doc_sr_code');
                $data['doc_unique_id'] = config('constant.curiculum.doc_unique_id');
             }
             if($j==2){
                $data['doc_file_name'] = $file->course_details_xsl;
                $data['doc_sr_code'] = config('constant.details.doc_sr_code');
                $data['doc_unique_id'] = config('constant.details.doc_unique_id');
             }
             $data['application_id'] = $request->application_id;
             $data['course_id'] = $file->id;
             $data['tp_id'] = Auth::user()->id;
             $data['level_id'] = 3;
             $data['course_name'] = $course_name[$i];
             $data['is_doc_show'] = 0;
             
             DB::table('tbl_course_wise_document')->insert($data);
            }
        }
        
        
          return redirect('/upgrade-level-3-create-new-course/' . dEncrypt($request->application_id).'/'.dEncrypt($reference_id))->with('success', 'Course  successfully  Added');
    }  catch(Exception $e){
          return redirect('upgrade-level-3-create-new-course/' . dEncrypt($request->application_id).'/'.dEncrypt($reference_id))->with('fail', 'Failed to create course');
    }
   
    
}


public function upgradeShowcoursePaymentLevel3(Request $request, $id = null)
    {
        $id = dDecrypt($id);
        $checkPaymentAlready = DB::table('tbl_application_payment')->where([['application_id', $id]])->whereNull('payment_ext')->where('pay_status','Y')->count();
        
        if ($checkPaymentAlready>1) {
                return redirect(url('get-application-list'))->with('fail', 'Payment has already been submitted for this application.');
        }
        if ($id) {
            $applicationData = DB::table('tbl_application')->where('id', $id)->first();
            $get_assessor_user = DB::table('assessor_final_summary_reports')->where('application_id',$id)->count();
            $course = DB::table('tbl_application_courses')->where('application_id', $id)->get();
            $assessor_type = $get_assessor_user==0 ?'desktop':'onsite';
         


            if (Auth::user()->country == $this->get_india_id()) {
                    $total_amount = $this->getPaymentFee($assessor_type,"INR",$id);
                    $currency = '₹';
            }
            else if(in_array(Auth::User()->country,$this->get_saarc_ids())){
                $total_amount = $this->getPaymentFee($assessor_type,"USD",$id);
                $currency = '$';
            }
            else {
                $total_amount = $this->getPaymentFee($assessor_type,"OTHER",$id);
                $currency = '$';
            }



        }
        return view('tp-view.level3-show-course-payment', compact('applicationData', 'course', 'currency', 'total_amount'));
    }
    
public function upgradeNewApplicationPaymentLevel3(Request $request)
{

    $first_app_refid = TblApplication::where('id',$request->Application_id)->first();
    
    $ref_count = TblApplication::where('prev_refid',$first_app_refid->prev_refid)->count();
    if($ref_count>1){
        $first_app_id = TblApplication::where('prev_refid',$first_app_refid->prev_refid)->get();
    }else{
        $first_app_id = TblApplication::where('refid',$first_app_refid->prev_refid)->get();
    }
    
    // dd($first_app_id);
    $pay_count = TblApplicationPayment::where('application_id', $request->Application_id)->whereNull('deleted_at')->where('pay_status','Y')->count();
    
    if($pay_count==0){
        DB::table('tbl_application')->where('id',$request->Application_id)->update(['status'=>0]);
    }else if($pay_count>0){
        DB::table('tbl_application')->where('id',$request->Application_id)->update(['status'=>11]);
    }
    
    $get_all_account_users = DB::table('users')->whereIn('role',[1,6])->get()->pluck('email')->toArray();
    $get_all_admin_users = DB::table('users')->where('role',1)->get()->pluck('email')->toArray();

    $request->validate([
        'transaction_no' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:application_payments,transaction_no',
        'reference_no' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:application_payments,reference_no',
        'payment' => 'required',
    ], [
        'transaction_no.required' => 'The transaction number is required.',
        'transaction_no.unique' => 'The transaction number is already in use.',
        'transaction_no.regex' => 'The transaction number must not contain special characters or spaces.',
        'reference_no.required' => 'The reference number is required.',
        'reference_no.unique' => 'The reference number is already in use.',
        'reference_no.regex' => 'The reference number must not contain special characters or spaces.',
        'payment.required' => 'Please select a payment mode.'
    ]);
    try{
    DB::beginTransaction();
    $transactionNumber = trim($request->transaction_no);
    $referenceNumber = trim($request->reference_no);
    $is_exist_t_num_or_ref_num = DB::table('tbl_application_payment')
                                ->whereNull('payment_ext')->where('pay_status','Y')
                                ->where('payment_transaction_no', $transactionNumber)
                                ->orWhere('payment_reference_no', $referenceNumber)
                                ->first();
    
    if(!empty($is_exist_t_num_or_ref_num)){
        return  back()->with('fail', 'Reference number or Transaction number already exists');
    }

    /*Implemented by suraj*/
        $get_final_summary = DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->Application_id,'payment_status'=>0,'assessor_type'=>'desktop'])->first();
        if(!empty($get_final_summary)){
        DB::table('assessor_final_summary_reports')->where('application_id',$request->Application_id)->update(['payment_status' => 1]);
        }
    /*end here*/
    $checkPaymentAlready = TblApplicationPayment::where('application_id', $request->Application_id)
    ->where('pay_status','Y')
    ->whereNull('remark_by_account')
    ->count();
   
    if($checkPaymentAlready>1){
        DB::table('tbl_application')->where('id',$request->Application_id)->update(['payment_status'=>6]);
    }
    
    // dd($checkPaymentAlready);
        if ($checkPaymentAlready>2) {
            return redirect(url('level-third/tp/application-list'))->with('fail', 'Payment has already been submitted for this application.');
        }
    $this->validate($request, [
        'payment_details_file' => 'mimes:pdf,jpeg,png,jpg,gif,svg',
    ]);

    $getcountryCode = DB::table('countries')->where([['id',Auth::user()->country]])->first();
    $appdetails = DB::table('tbl_application')->where('id',$request->Application_id)->first();
    $final_summary = DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->Application_id,'assessor_type'=>'desktop','is_summary_show'=>1])->first();
    if(empty($final_summary)){
        $assessor_type_ = "desktop";
    }else{
        $assessor_type_ = "onsite";
    }
    if($appdetails->level_id==3){
        $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>$getcountryCode->currency,'level'=>$assessor_type_])->first();
    }else{
        $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>$getcountryCode->currency,'level'=>$assessor_type_])->first();
    }
    $item = new TblApplicationPayment;
    $item->level_id = $request->level_id;
    $item->user_id = Auth::user()->id;
    $item->amount = $request->amount;
    $item->other_country_payment = $get_payment_list->dollar_fee??null;
    $item->payment_date = date("d-m-Y");
    $item->payment_mode = $request->payment;
    $item->payment_transaction_no = $transactionNumber;
    $item->payment_reference_no = $referenceNumber;
    $item->pay_status = 'Y';
    $item->currency =  $getcountryCode->currency??'INR';
    $item->application_id = $request->Application_id;
    if ($request->hasfile('payment_details_file')) {
        $img = $request->file('payment_details_file');
        $name = $img->getClientOriginalName();
        $filename = rand().'-'.time().'-'.rand() . $name;
        $img->move('uploads/', $filename);
        $item->payment_proof = $filename;
    }
    $item->save();


    /*If tp pay second time then show the application admin as well*/ 
   
    if($pay_count>1){
        DB::table('tbl_application')->where('id',$request->Application_id)->update(['second_payment'=>6]);
    }
    /*end here*/ 



          /*send notification*/ 
          $notifiData = [];
          $notifiData['user_type'] = "accountant";
          $notifiData['sender_id'] = Auth::user()->id;
          $notifiData['application_id'] =$request->Application_id;
          $notifiData['uhid'] = getUhid($request->Application_id)[0];
          $notifiData['level_id'] = getUhid($request->Application_id)[1] ;
          $acUrl = config('notification.accountantUrl.level1');
          $notifiData['url'] = $acUrl.dEncrypt($request->Application_id);
          if($checkPaymentAlready>1){
            $notifiData['data'] = config('notification.accountant.doneSecPay');
          }else{
              $notifiData['data'] = config('notification.accountant.appCreated');
          }

          sendNotification($notifiData);
          /*end here*/ 

    if(isset($first_app_id)){
        DB::table('tbl_application')->whereIn('id',[$first_app_id[0]->id??0,$first_app_id[1]->id??0])->update(['is_all_course_doc_verified'=>3]);
    }

    DB::table('tbl_application')->where('id',$request->Application_id)->update(['payment_status'=>5]); //payment_status 5 is for done payment by TP.


    DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->Application_id])->update(['second_payment_status' => 1]);

    $application_id = $request->Application_id;
    $userid = Auth::user()->firstname;
    if ($request->level_id == '3') {
        foreach ($request->course_id as $items) {
            $ApplicationCourse = TblApplicationCourses::where('id',$items);
            $ApplicationCourse->update(['payment_status' =>1]);
        }
        
        /**
         * Send Email to Accountant
         * */ 
        foreach($get_all_account_users as $email){
            $title="New Application Created - Welcome Aboard : RAVAP-".$application_id;
            $subject="New Application Created - Welcome Aboard : RAVAP-".$application_id;
            
            $body="Dear Team,".PHP_EOL."
            I trust this message finds you well. I am writing to request the approval of the payment associated with my recent application for RAVAP-".$application_id." submitted on ".date('d-m-Y').". As part of the application process, a payment of Rs.".$request->amount." was made under the transaction reference ID ".$referenceNumber.". ".PHP_EOL."
            Here are the transaction details: ".PHP_EOL."
            Transaction ID: ".$transactionNumber." ".PHP_EOL."
            Payment Amount: ".$request->amount." ".PHP_EOL."
            Payment Date: ".date("Y-m-d", strtotime($request->payment_date))." ".PHP_EOL."
            
            Best regard,".PHP_EOL."
            RAV Team";

            $details['email'] = $email;
            $details['title'] = $title; 
            $details['subject'] = $subject; 
            $details['body'] = $body; 
             if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
        }

        foreach($get_all_admin_users as $email){
            $title="New Application Created | RAVAP-".$application_id;
            $subject="New Application Created | RAVAP-".$application_id;
            $body="Dear Team,".PHP_EOL."

            We are thrilled to inform you that your application has been successfully processed, and we are delighted to welcome you to our RAVAP family! Your dedication and skills have truly impressed us, and we are excited about the positive impact we believe you will make.".PHP_EOL."
            Best regard,".PHP_EOL."
            RAV Team";

            $details['email'] = $email;
            $details['title'] = $title; 
            $details['subject'] = $subject; 
            $details['body'] = $body; 
             if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
        }

        //tp email
            $body = "Dear ,".Auth::user()->firstname." ".PHP_EOL."
            We are thrilled to inform you that your application has been successfully processed, and we are delighted to welcome you to our RAVAP family! Your dedication and skills have truly impressed us, and we are excited about the positive impact we believe you will make. ".PHP_EOL."
            Best regards,".PHP_EOL."
            RAV Team";

            $details['email'] = Auth::user()->email;
            $details['title'] = "Payment Approval | RAVAP-".$application_id; 
            $details['subject'] = "Payment Approval | RAVAP-".$application_id; 
            $details['body'] = $body; 
             if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
        
        /*send email end here*/ 
        DB::commit();
        return  redirect(url('/level-third/tp/application-list/'))->with('success', 'Payment Done successfully');
    }  
    }
    catch(Exception $e){
    DB::rollback();
    return  redirect('/level-fourth')->with('success', 'Payment Done successfully');
    }
}

public function upgradeGetApplicationViewLevel3($id){
    
    
    $app_id = dDecrypt($id);
    $application = DB::table('tbl_application')
    ->where('id', $app_id)
    ->first();

    $json_course_doc = File::get(base_path('/public/course-doc/courses.json'));
    $decoded_json_courses_doc = json_decode($json_course_doc);
    
    $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
    $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->whereNull('payment_ext')->where('pay_status','Y')->latest('id')->first();


    
    $app_payment = DB::table('tbl_application_payment')->where('application_id',$app_id)->whereNull('payment_ext')->where('pay_status','Y')->count();
    $get_application = DB::table('tbl_application')->where('id',$app_id)->first();

        $assessor_type = "";
        if($get_application->level_id==2){
            $assessor_type="secretariat";
        }else if($get_application->level_id==3){
            if($app_payment>1){
                $assessor_type="onsite";
            }else{
                $assessor_type="desktop";
            }
        }

        
        $total_courses = DB::table('tbl_application_courses')->where('application_id',$app_id)->whereNull('deleted_at')->count();
        $total_docs    = DB::table('tbl_application_course_doc')->where(['application_id'=>$app_id,'approve_status'=>1,'assessor_type'=>$assessor_type])->count();
        $final_total_count = $total_courses * 4;
        if($total_docs>$final_total_count){
            $doc_list_count=1;
        }else{
            $doc_list_count=0;
        }
        
        $show_submit_btn_to_tp = $this->isShowSubmitBtnToSecretariat($app_id,$assessor_type);
        $enable_disable_submit_btn = $this->checkSubmitButtonEnableOrDisable($app_id,$assessor_type);
        $showSubmitBtnToTP = $this->checkReuploadBtn($application->id);
        
        $obj = new \stdClass;
        $obj->is_all_revert_action_done=$this->checkAllActionDoneOnRevert($application->id);
        $obj->is_all_revert_action_done44=$this->checkAllActionDoneOnRevert44($application->id);
        $obj->application= $application;
        $courses = DB::table('tbl_application_courses')->where([
            'application_id'=>$application->id
        ])
        // ->whereIn('status',[0,2])
        ->whereNull('deleted_at') 
        ->get();
        
        foreach ($courses as $course) {
            if ($course) {
                $course_docs=$this->isNcOnCourseDocs($application->id, $course->id);
                if($application->level_id!=1){
                    $course_docs_lists=$this->isNcOnCourseDocsList($application->id, $course->id);
                }
                $obj->course[] = [
                    "course" => $course,
                    'course_wise_document_declaration' => DB::table('tbl_course_wise_document')->where([
                        'application_id' => $application->id,
                        'course_id' => $course->id,
                        'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                        'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                    ])->get(),
                    'isAnyNcOnCourse'=>$course_docs,
                    'isAnyNcOnCourseDocList'=>$course_docs_lists??false,

                        'course_wise_document_curiculum' => DB::table('tbl_course_wise_document')->where([
                            'application_id' => $application->id,
                            'course_id' => $course->id,
                            'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                            'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                        ])->get(),
        
                        'course_wise_document_details' => DB::table('tbl_course_wise_document')->where([
                            'application_id' => $application->id,
                            'course_id' => $course->id,
                            'doc_sr_code' => config('constant.details.doc_sr_code'),
                            'doc_unique_id' => config('constant.details.doc_unique_id'),
                        ])->get(),
                    'nc_comments_course_declaration' => DB::table('tbl_nc_comments_secretariat')->where([
                        'application_id' => $application->id,
                        'application_courses_id' => $course->id,
                        'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                        'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                        'nc_show_status'=>1
                    ])
                        ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                        ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                        ->get(),
        
                    'nc_comments_course_curiculam' => DB::table('tbl_nc_comments_secretariat')->where([
                        'application_id' => $application->id,
                        'application_courses_id' => $course->id,
                        'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                        'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                        'nc_show_status'=>1
                    ])
                        ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                        ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                        ->get(),
        
                    'nc_comments_course_details' => DB::table('tbl_nc_comments_secretariat')->where([
                        'application_id' => $application->id,
                        'application_courses_id' => $course->id,
                        'doc_sr_code' => config('constant.details.doc_sr_code'),
                        'doc_unique_id' => config('constant.details.doc_unique_id'),
                        'nc_show_status'=>1
                    ])
                        ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                        ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                        ->get()
                ]; // Added semicolon here
            }
        }

            $payment = DB::table('tbl_application_payment')->where([
                'application_id' => $application->id,
                'payment_ext'=>null,
                'pay_status'=>'Y'
            ])->get();
            $additional_payment = DB::table('tbl_application_payment')->where([
                'application_id' => $application->id,
                'payment_ext'=>'add',
                'pay_status'=>'Y'
            ])->get();
            if($payment){
                $obj->payment = $payment;
                $obj->additional_payment = $additional_payment;
            }
            $final_data = $obj;
            $tp_final_summary_count =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id])->count();
            if($tp_final_summary_count>1){
                $is_final_submit = true;
            }else{
                $is_final_submit = false;
            }

            
            $checkViewLevelUrl = DB::table('tbl_application')->where('prev_id',dDecrypt($id))->first();
            
            if(!empty($checkViewLevelUrl) && $checkViewLevelUrl->upgraded_level_id==3 && $checkViewLevelUrl->prev_refid!=null){
                $viewLevelUrl = true;
            }else{
                $viewLevelUrl = false;
            }
            
            
    return view('tp-view.level3-upgrade-application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit,'courses_doc'=>$decoded_json_courses_doc,'show_submit_btn_to_tp'=>$show_submit_btn_to_tp,'enable_disable_submit_btn'=>$enable_disable_submit_btn,'showSubmitBtnToTP'=>$showSubmitBtnToTP,'viewLevelUrl'=>$viewLevelUrl,'doc_list_count'=>$doc_list_count]);
}


function getPaymentFeeLevel2($level,$currency,$application_id){
    if($currency!="INR" && $currency!="USD"){
        $currency="OTHER";
    }
    
    $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>$currency,'level'=>$level])->get();
    
    $course = DB::table('tbl_application_courses')->where('application_id', $application_id)->whereNull('deleted_at')->get();
    
    if($level=='onsite'){
    $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>$currency])->whereIn('level',['annual','assessment'])->get();
    
    if (count($course) == '0') {
      
        $total_amount = '0';
    } elseif (count($course) <= 5) {
        $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);
        $total_amount = $total_amount +  (int)$get_payment_list[1]->courses_fee +((int)$get_payment_list[1]->courses_fee * 0.18);
    } elseif (count($course)>=5 && count($course) <= 10) {
        $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);
        $total_amount = $total_amount +  (int)$get_payment_list[2]->courses_fee +((int)$get_payment_list[2]->courses_fee * 0.18);
    } elseif(count($course)>10) {
        $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);
        $total_amount = $total_amount +  (int)$get_payment_list[3]->courses_fee +((int)$get_payment_list[3]->courses_fee * 0.18);
    }    
    
    return $total_amount;
}else{
        if (count($course) == '0') {
          
            $total_amount = '0';
        } elseif (count($course) <= 5 && count($get_payment_list)>0) {
            
            $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);

        } elseif (count($course)>=5 && count($course) <= 10 && count($get_payment_list)>0) {
            
            $total_amount = (int)$get_payment_list[1]->courses_fee +((int)$get_payment_list[1]->courses_fee * 0.18);
        } elseif(count($course)>10 && count($get_payment_list)>0) {
            
            $total_amount = (int)$get_payment_list[2]->courses_fee +((int)$get_payment_list[2]->courses_fee * 0.18);
        }    
    return $total_amount;
}
}

// function getPaymentFee($level,$currency,$application_id,$assessment=null){

//     $course = DB::table('tbl_application_courses')->where('application_id', $application_id)->get();

//     if (Auth::user()->country == $this->get_india_id() && $assessment=='desktop') {
//         $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>$currency,'level'=>'desktop'])->get();
//         if (count($course) == '0') {
          
//             $total_amount = '0';
//         } elseif (count($course) <= 5) {
            
//             $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);

//         } elseif (count($course)>=5 && count($course) <= 10) {
            
//             $total_amount = (int)$get_payment_list[1]->courses_fee +((int)$get_payment_list[1]->courses_fee * 0.18);
            
//         } elseif(count($course)>10) {
            
//             $total_amount = (int)$get_payment_list[2]->courses_fee +((int)$get_payment_list[2]->courses_fee * 0.18);
//         }    
//     } 

//     if (Auth::user()->country == $this->get_india_id() && $assessment=='onsite') {
//         $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>'inr'])->whereIn('level',['annual','assessment'])->get();
        
//         if (count($course) == '0') {
          
//             $total_amount = '0';
//         } elseif (count($course) <= 5) {
            
//             $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);
            
//             $total_amount = $total_amount +  (int)$get_payment_list[1]->courses_fee +((int)$get_payment_list[1]->courses_fee * 0.18);

//         } elseif (count($course)>=5 && count($course) <= 10) {
//             $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);
//             $total_amount = $total_amount +  (int)$get_payment_list[2]->courses_fee +((int)$get_payment_list[2]->courses_fee * 0.18);
            
//         } elseif(count($course)>10) {
//             $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);
//             $total_amount = $total_amount +  (int)$get_payment_list[3]->courses_fee +((int)$get_payment_list[3]->courses_fee * 0.18);
//         }    
//     } 
//     return $total_amount;
// }


function getPaymentFee($level,$currency,$application_id){

    
    if($currency!="INR" && $currency!="USD"){
        $currency="OTHER";
    }
    $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>$currency,'level'=>$level])->get();
    $course = DB::table('tbl_application_courses')->where('application_id', $application_id)->whereNull('deleted_at')->get();
    if($level=='onsite'){
    $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>$currency])->whereIn('level',['annual','assessment'])->get();
    
    if (count($course) == '0') {
      
        $total_amount = '0';
    } elseif (count($course) <= 5) {
        $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);
        $total_amount = $total_amount +  (int)$get_payment_list[1]->courses_fee +((int)$get_payment_list[1]->courses_fee * 0.18);
    } elseif (count($course)>=5 && count($course) <= 10) {
        $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);
        $total_amount = $total_amount +  (int)$get_payment_list[2]->courses_fee +((int)$get_payment_list[2]->courses_fee * 0.18);
    } elseif(count($course)>10) {
        $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);
        $total_amount = $total_amount +  (int)$get_payment_list[3]->courses_fee +((int)$get_payment_list[3]->courses_fee * 0.18);
    }    
    
    return $total_amount;
}else{
        if (count($course) == '0') {
          
            $total_amount = '0';
        } elseif (count($course) <= 5 && count($get_payment_list)>0) {
            
            $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);

        } elseif (count($course)>=5 && count($course) <= 10 && count($get_payment_list)>0) {
            
            $total_amount = (int)$get_payment_list[1]->courses_fee +((int)$get_payment_list[1]->courses_fee * 0.18);
        } elseif(count($course)>10 && count($get_payment_list)>0) {
            
            $total_amount = (int)$get_payment_list[2]->courses_fee +((int)$get_payment_list[2]->courses_fee * 0.18);
        }    
    return $total_amount;
}

}
/*end here*/ 



public function getApplicationPaymentFeeList(){
        
    $pay_list = DB::table('tbl_application_payment')
      ->where('user_id',Auth::user()->id)
      ->whereNull('payment_ext')->where('pay_status','Y')
      ->get()
      ->pluck('application_id')
      ->toArray();
    
    $application = DB::table('tbl_application as a')
    ->where('tp_id',Auth::user()->id)
    ->whereIn('is_query_raise',[1,2])
    ->whereIn('id',$pay_list)
    ->orderBy('id','desc')
    ->get();

    $final_data=array();
    foreach($application as $app){
        $obj = new \stdClass;
        $obj->application_list = $app;
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
                'payment_ext'=>null,
            ])->latest('created_at')->first();
            $payment_amount = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
                'payment_ext'=>null,
            ])->sum('amount');
            $payment_count = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
                'payment_ext'=>null,
            ])->count();
            
            if($payment){
                $obj->payment = $payment;
                $obj->payment->payment_count = $payment_count;
                $obj->payment->payment_amount = $payment_amount ;
            }
            $final_data[] = $obj;
    }
    
    return view('tp-view.payment.application-list',['list'=>$final_data]);
}

/** Whole Application View for Account */
public function getApplicationPaymentFeeView($id){
    
    $application = DB::table('tbl_application')
    ->where('id', dDecrypt($id))
    ->first();
    $json_course_doc = File::get(base_path('/public/course-doc/courses.json'));
    $decoded_json_courses_doc = json_decode($json_course_doc);
    
    $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
    $application_payment_status = DB::table('tbl_application_payment')->where([['application_id', '=', $application->id]])->whereNull('payment_ext')->where('pay_status','Y')->latest('id')->first();
    
        $obj = new \stdClass;
        $obj->application= $application;
        $courses = DB::table('tbl_application_courses')->where([
            'application_id' => $application->id,
        ])
        ->whereIn('status',[0,2]) 
        ->whereNull('deleted_at') 
        ->get();
        foreach ($courses as $course) {
            if ($course) {
                $obj->course[] = [
                    "course" => $course,
                    'course_wise_document_declaration' => DB::table('tbl_course_wise_document')->where([
                        'application_id' => $application->id,
                        'course_id' => $course->id,
                        'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                        'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                    ])->get(),

                        'course_wise_document_curiculum' => DB::table('tbl_course_wise_document')->where([
                            'application_id' => $application->id,
                            'course_id' => $course->id,
                            'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                            'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                        ])->get(),
        
                        'course_wise_document_details' => DB::table('tbl_course_wise_document')->where([
                            'application_id' => $application->id,
                            'course_id' => $course->id,
                            'doc_sr_code' => config('constant.details.doc_sr_code'),
                            'doc_unique_id' => config('constant.details.doc_unique_id'),
                        ])->get(),
                    'nc_comments_course_declaration' => DB::table('tbl_nc_comments_secretariat')->where([
                        'application_id' => $application->id,
                        'application_courses_id' => $course->id,
                        'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                        'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                        'nc_show_status'=>1
                    ])
                        ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                        ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                        ->get(),
        
                    'nc_comments_course_curiculam' => DB::table('tbl_nc_comments_secretariat')->where([
                        'application_id' => $application->id,
                        'application_courses_id' => $course->id,
                        'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                        'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                        'nc_show_status'=>1
                    ])
                        ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                        ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                        ->get(),
        
                    'nc_comments_course_details' => DB::table('tbl_nc_comments_secretariat')->where([
                        'application_id' => $application->id,
                        'application_courses_id' => $course->id,
                        'doc_sr_code' => config('constant.details.doc_sr_code'),
                        'doc_unique_id' => config('constant.details.doc_unique_id'),
                        'nc_show_status'=>1
                    ])
                        ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                        ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                        ->get()
                ]; // Added semicolon here
            }
        }

            $payment = DB::table('tbl_application_payment')->where([
                'application_id' => $application->id,
                'payment_ext'=>null,
            ])->get();
            $additional_payment = DB::table('tbl_application_payment')->where([
                'application_id' => $application->id,
                'payment_ext'=>'add',
                'pay_status'=>'Y'
            ])->get();
            if($payment){
                $obj->payment = $payment;
                $obj->additional_payment = $additional_payment;
            }
            $final_data = $obj;
            $tp_final_summary_count =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id])->count();
            if($tp_final_summary_count>1){
             $is_final_submit = true;
            }else{
             $is_final_submit = false;
            }

    return view('tp-view.payment.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit,'courses_doc'=>$decoded_json_courses_doc]);
}



public function tpUpdateNCFlagDocList($application_id)
    {
        try {
            $app_payment = DB::table('tbl_application_payment')->where([['application_id',$application_id]])->whereNull('payment_ext')->where('pay_status','Y')->count();
            $get_application = DB::table('tbl_application')->where('id',$application_id)->first();

            $assessor_type = "";
            if($get_application->level_id==2){
                $assessor_type="secretariat";
            }else if($get_application->level_id==3){
                if($app_payment>1){
                    $assessor_type="onsite";
                }else{
                    $assessor_type="desktop";
                }
            }
            DB::beginTransaction();
            $t=0;
            $get_course_docs = DB::table('tbl_application_course_doc')
                ->where(['application_id' => $application_id,'approve_status'=>1,'assessor_type'=>$assessor_type])
                ->whereNull('deleted_at')
                ->latest('id')->get();
                $is_nr = false;
                $is_nr_list = false;
                
                foreach($get_course_docs as $course_doc){
                    if($course_doc->assessor_type=="onsite"){
                        if(in_array($course_doc->onsite_status,[2,3,4]) && $course_doc->onsite_nc_status==1){
                            DB::rollBack();
                            return back()->with('fail', 'Please first take all action on doc');
                        }
                    }else{
                        if(in_array($course_doc->status,[2,3,4]) && $course_doc->nc_flag==1){
                            DB::rollBack();
                            return back()->with('fail', 'Please first take all action on doc');
                            
                        }
                    }
                    
                }
                
                foreach($get_course_docs as $course_doc){
                    $nc_comment_status = "";
                    $nc_flag=0;
                    $nc_comments = 0;
                   if ($course_doc->status == 2) {
                        $nc_comment_status = 2;
                        $nc_flag = 1;
                        $nc_comments=1;
                    } else if ($course_doc->status == 3) {
                        $nc_comment_status = 3;
                        $nc_flag = 1;
                        $nc_comments=1;
                    }
                    else if ($course_doc->status == 4) {
                        $nc_comment_status = 4;
                        $nc_flag = 1;
                        $nc_comments=1;
                        $is_nr=true;
                    } 
                    else {
                        $nc_comment_status = 0; //not recommended
                        $nc_flag = 0;
                        $nc_comments=0;
                    }

            /*if any courses rejected then hide the revert button according to courses*/ 
               
              $is_update =  DB::table('tbl_application_course_doc')
                ->where(['id' => $course_doc->id, 'application_id' => $application_id,'assessor_type'=>$assessor_type])
                ->update(['is_doc_show'=>$course_doc->status,'is_tp_revert'=>1]);
              
                if($t==0){
                    if($is_update){
                        $t=1;
                    }
                }


            }

            $get_course_wise_docs = DB::table('tbl_course_wise_document')
                ->where(['application_id' => $application_id,'approve_status'=>1])
                ->latest('id')->get();

                
                foreach($get_course_wise_docs as $course_doc){
                    if(in_array($course_doc->status,[2,3,4]) && $course_doc->nc_flag==1){
                        return back()->with('fail', 'Please first take all action on doc');
                        
                    }
                }


                foreach($get_course_wise_docs as $course_doc){
                    $nc_comment_status = "";
                    $nc_flag=0;
                    $nc_comments = 0;
                   if ($course_doc->status == 2) {
                        $nc_comment_status = 2;
                        $nc_flag = 1;
                        $nc_comments=1;
                    } else if ($course_doc->status == 3) {
                        $nc_comment_status = 3;
                        $nc_flag = 1;
                        $nc_comments=1;
                    }
                    else if ($course_doc->status == 4) {
                        $nc_comment_status = 4;
                        $nc_flag = 1;
                        $nc_comments=1;
                        $is_nr_list=true;
                    } 
                    else {
                        $nc_comment_status = 0; //not recommended
                        $nc_flag = 0;
                        $nc_comments=0;
                    }

            /*if any courses rejected then hide the revert button according to courses*/ 
               
             $is_update=  DB::table('tbl_course_wise_document')
            ->where(['id' => $course_doc->id, 'application_id' => $application_id])
            ->update(['is_doc_show'=>$course_doc->nc_show_status,'is_tp_revert'=>1]);
              
                if($t==0){
                    if($is_update){
                        $t=1;
                    }
                }


            }

            



            
        //     if($get_application->level_id==1){
        //         $url= config('notification.secretariatUrl.level1');
        //         $url=$url.dEncrypt($application_id);
        //         $tpUrl = config('notification.tpUrl.level1');
        //         $tpUrl=$tpUrl.dEncrypt($application_id);
        //     }else if($get_application->level_id==2){
        //         $url= config('notification.secretariatUrl.level2');
        //         $url=$url.dEncrypt($application_id);
        //         $tpUrl = config('notification.tpUrl.level2');
        //         $tpUrl=$tpUrl.dEncrypt($application_id);
        //     }else{
        //         $url= config('notification.secretariatUrl.level3');
        //         $url=$url.dEncrypt($application_id);
        //         $tpUrl = config('notification.tpUrl.level3');
        //         $tpUrl=$tpUrl.dEncrypt($application_id);
        //     }
        //     $is_all_accepted=$this->isAllCourseDocAccepted($application_id);
        //     $notifiData = [];
        //     $notifiData['sender_id'] = Auth::user()->id;
        //     $notifiData['application_id'] = $application_id;
        //     $notifiData['uhid'] = getUhid( $application_id)[0];
        //     $notifiData['level_id'] = getUhid( $application_id)[1];
        //     $notifiData['data'] = config('notification.common.nc');
        //     $notifiData['user_type'] = "superadmin";
        //     $sUrl = config('notification.adminUrl.level1');

        //     $notifiData['url'] = $sUrl.dEncrypt($application_id);
        //     if($get_application->level_id==3){
        //     if($t && !$is_all_accepted){
                
        //           /*send notification*/ 
        //           sendNotification($notifiData);
        //           $notifiData['user_type'] = "tp";
        //           $notifiData['url'] = $tpUrl;
        //           sendNotification($notifiData);
        //           $notifiData['user_type'] = "secretariat";
        //           $notifiData['url'] = $url;
        //           sendNotification($notifiData);
        //             /*end here*/ 
        //         createApplicationHistory($application_id,null,config('history.common.nc'),config('history.color.danger'));
        //     }
           
        //     if($is_all_accepted){
        //         $notifiData['data'] = config('notification.admin.acceptCourseDoc');
        //         $notifiData['user_type'] = "superadmin";
        //         $notifiData['url'] = $sUrl.dEncrypt($application_id);
        //         sendNotification($notifiData);
        //     }
        // }

            /*--------To Check All 44 Doc Approved----------*/

            // $check_all_doc_verified = $this->checkApplicationIsReadyForNextLevelDocList($application_id);
            /*------end here------*/
            if($t==1){
                DB::table('tbl_application')->where('id',$application_id)->update(['status'=>5]);
            }

            if($is_nr || $is_nr_list){
                DB::table('tbl_application')->where('id',$application_id)->update(['status'=>18]);
            }
            
            DB::commit();
            // if ($check_all_doc_verified == "all_verified") {
            //     return back()->with('success', 'All course docs Accepted successfully.');
            // }
            // if ($check_all_doc_verified == "action_not_taken") {
            //     return back()->with('fail', 'Please take any action on course doc.');
            // }
            return back()->with('success', 'Submit successfully.');
            // return redirect($redirect_to);

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('fail', 'Something went wrong');
        }
}


public function tpUpdateNCFlagCourseDoc($application_id)
    {
        
        try {
            DB::beginTransaction();
            $application_id = dDecrypt($application_id);
            $t=0;
            $get_course_wise_docs = DB::table('tbl_course_wise_document')
                ->where(['application_id' => $application_id,'approve_status'=>1,'is_doc_show'=>-1])
                ->latest('id')->get();
                $is_nr = false;
                
                foreach($get_course_wise_docs as $course_doc){
                    $nc_comment_status = "";
                    $nc_flag=0;
                    $nc_comments = 0;
                   if ($course_doc->status == 2) {
                        $nc_comment_status = 2;
                        $nc_flag = 1;
                        $nc_comments=1;
                    } else if ($course_doc->status == 3) {
                        $nc_comment_status = 3;
                        $nc_flag = 1;
                        $nc_comments=1;
                    }
                    else if ($course_doc->status == 4) {
                        $nc_comment_status = 4;
                        $nc_flag = 1;
                        $nc_comments=1;
                        $is_nr = true;
                    } 
                    else {
                        $nc_comment_status = 0; //not recommended
                        $nc_flag = 0;
                        $nc_comments=0;
                    }

            /*if any courses rejected then hide the revert button according to courses*/ 
               
             $is_update=  DB::table('tbl_course_wise_document')
            ->where(['id' => $course_doc->id, 'application_id' => $application_id,'is_doc_show'=>-1])
            ->update(['is_doc_show'=>$course_doc->nc_show_status,'is_tp_revert'=>1,'is_admin_submit'=>0]);
              
                if($t==0){
                    if($is_update){
                        $t=1;
                    }
                }
            }

            



            
        //     if($get_application->level_id==1){
        //         $url= config('notification.secretariatUrl.level1');
        //         $url=$url.dEncrypt($application_id);
        //         $tpUrl = config('notification.tpUrl.level1');
        //         $tpUrl=$tpUrl.dEncrypt($application_id);
        //     }else if($get_application->level_id==2){
        //         $url= config('notification.secretariatUrl.level2');
        //         $url=$url.dEncrypt($application_id);
        //         $tpUrl = config('notification.tpUrl.level2');
        //         $tpUrl=$tpUrl.dEncrypt($application_id);
        //     }else{
        //         $url= config('notification.secretariatUrl.level3');
        //         $url=$url.dEncrypt($application_id);
        //         $tpUrl = config('notification.tpUrl.level3');
        //         $tpUrl=$tpUrl.dEncrypt($application_id);
        //     }
        //     $is_all_accepted=$this->isAllCourseDocAccepted($application_id);
        //     $notifiData = [];
        //     $notifiData['sender_id'] = Auth::user()->id;
        //     $notifiData['application_id'] = $application_id;
        //     $notifiData['uhid'] = getUhid( $application_id)[0];
        //     $notifiData['level_id'] = getUhid( $application_id)[1];
        //     $notifiData['data'] = config('notification.common.nc');
        //     $notifiData['user_type'] = "superadmin";
        //     $sUrl = config('notification.adminUrl.level1');

        //     $notifiData['url'] = $sUrl.dEncrypt($application_id);
        //     if($get_application->level_id==3){
        //     if($t && !$is_all_accepted){
                
        //           /*send notification*/ 
        //           sendNotification($notifiData);
        //           $notifiData['user_type'] = "tp";
        //           $notifiData['url'] = $tpUrl;
        //           sendNotification($notifiData);
        //           $notifiData['user_type'] = "secretariat";
        //           $notifiData['url'] = $url;
        //           sendNotification($notifiData);
        //             /*end here*/ 
        //         createApplicationHistory($application_id,null,config('history.common.nc'),config('history.color.danger'));
        //     }
           
        //     if($is_all_accepted){
        //         $notifiData['data'] = config('notification.admin.acceptCourseDoc');
        //         $notifiData['user_type'] = "superadmin";
        //         $notifiData['url'] = $sUrl.dEncrypt($application_id);
        //         sendNotification($notifiData);
        //     }
        // }

            /*--------To Check All 44 Doc Approved----------*/

            // $check_all_doc_verified = $this->checkApplicationIsReadyForNextLevelDocList($application_id);
            /*------end here------*/

            // this is for the applicaion status
            
            if($t==1){
                DB::table('tbl_application')->where('id',$application_id)->update(['status'=>5]);
            }
            if($is_nr){
                DB::table('tbl_application')->where('id',$application_id)->update(['status'=>18]);
            }
            DB::commit();
            // if ($check_all_doc_verified == "all_verified") {
            //     return back()->with('success', 'All course docs Accepted successfully.');
            // }
            // if ($check_all_doc_verified == "action_not_taken") {
            //     return back()->with('fail', 'Please take any action on course doc.');
            // }
            return back()->with('success', 'Submit successfully.');
            // return redirect($redirect_to);

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('fail', 'Something went wrong');
        }
}

public function checkApplicationIsReadyForNextLevelDocList($application_id)
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
            ->where('tbl_application_course_doc.application_id',$application_id)

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
        $nc_flag = 0;
        $not_any_action_flag = 0;
        foreach ($results as $result) {
            if ($result->status == 1 || ($result->status == 4 && $result->admin_nc_flag == 1)) {
                $flag = 0;
            } else {
                $flag = 1;
                break;
            }
        }
  
        foreach ($results as $result) {
            if ($result->status != 0) {
                $nc_flag = 1;
                break;
            }
        }
        foreach ($results as $result) {
            if ($result->status == 0) {
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



public function isShowSubmitBtnToSecretariat($application_id,$assessor_type)
{
    $results = DB::table('tbl_application_course_doc')
        ->select('application_id', 'application_courses_id', 'assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id', 'assessor_type')
        ->where('application_id', $application_id)
        ->whereIn('approve_status', [0,1])
        ->get();
    
    $additionalFields = DB::table('tbl_application_course_doc')
        ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id, assessor_type) as sub'), function ($join) {
            $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
        })
        ->where('tbl_application_course_doc.application_id',$application_id)
        ->orderBy('tbl_application_course_doc.id', 'desc')
        ->where('tbl_application_course_doc.assessor_type',$assessor_type)
        ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status','nc_show_status', 'id', 'admin_nc_flag', 'approve_status', 'assessor_type']);

    
    $finalResults = [];
    foreach ($results as $key => $result) {
        if ($result->assessor_type == $assessor_type) {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('application_courses_id', $result->application_courses_id)
                ->where('doc_sr_code', $result->doc_sr_code)
                ->where('doc_unique_id', $result->doc_unique_id)
                ->where('approve_status', 1)
                ->first();

            if ($additionalField) {
                $finalResults[$key] = (object)[];
                $finalResults[$key]->status = $additionalField->status;
                $finalResults[$key]->nc_show_status = $additionalField->nc_show_status;
                $finalResults[$key]->id = $additionalField->id;
                $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                $finalResults[$key]->approve_status = $additionalField->approve_status;
                $finalResults[$key]->assessor_type = $additionalField->assessor_type;
            }
        }
    }

    $flag = 0;
    foreach ($finalResults as $result) {
        if (($result->nc_show_status == 1) || ($result->nc_show_status == 4 && $result->admin_nc_flag == 1)) {
            $flag = 0;
        } else {
            $flag = 1;
            break;
        }
    }
    return $flag != 0;
}

public function checkSubmitButtonEnableOrDisable($application_id,$assessor_type)
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
    ->where('tbl_application_course_doc.assessor_type',$assessor_type)
    ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag', 'nc_flag','approve_status', 'assessor_type','onsite_status','onsite_nc_status']);


        $finalResults = [];
        foreach ($results as $key => $result) {
            if ($result->assessor_type == $assessor_type) {
                $additionalField = $additionalFields->where('application_id', $result->application_id)
                    ->where('application_courses_id', $result->application_courses_id)
                    ->where('doc_sr_code', $result->doc_sr_code)
                    ->where('doc_unique_id', $result->doc_unique_id)
                    ->where('approve_status', 1)
                    ->first();

                if ($additionalField) {
                    $finalResults[$key] = (object)[];
                    $finalResults[$key]->status = $additionalField->status;
                    $finalResults[$key]->onsite_status = $additionalField->onsite_status;
                    $finalResults[$key]->onsite_nc_status = $additionalField->onsite_nc_status;
                    $finalResults[$key]->id = $additionalField->id;
                    $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                    $finalResults[$key]->nc_flag = $additionalField->nc_flag;
                    $finalResults[$key]->approve_status = $additionalField->approve_status;
                    $finalResults[$key]->assessor_type = $additionalField->assessor_type;
                }
            }
        }

    
    $flag = 0;    
    foreach ($finalResults as $result) {
        if($assessor_type=="desktop" || $assessor_type=="secretariat"){
            if (($result->status==2 || $result->status==3 || $result->status==4) && ($result->nc_flag==1 || $result->admin_nc_flag==3)) {
                $flag = 1;
                break;
            }
        }else{
            if (($result->onsite_status==2 || $result->onsite_status==3 || $result->onsite_status==4) && ($result->onsite_nc_status==1 || $result->admin_nc_flag==3)) {
                $flag = 1;
                break;
            }
        }
        
    }
    $get_docs_count = DB::table('tbl_application_course_doc')->where('application_id',$application_id)->count();
    $get_course_count = DB::table('tbl_application_courses')->where('application_id',$application_id)->where('deleted_at',null)->count();
    
    $total_docs = $get_course_count*4;
    if(($get_docs_count<$total_docs) || $flag == 1){
     return true;
    }else{
     return false;
    }


}

public function checkSubmitButtonEnableOrDisableL1($application_id,$assessor_type)
{

    $results = DB::table('tbl_course_wise_document')
    ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
    ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
    ->where('application_id', $application_id)
    ->where('approve_status', 1)
    ->get();

$additionalFields = DB::table('tbl_course_wise_document')
    ->join(DB::raw('(SELECT application_id, course_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_course_wise_document GROUP BY application_id, course_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
        $join->on('tbl_course_wise_document.application_id', '=', 'sub.application_id')
            ->on('tbl_course_wise_document.course_id', '=', 'sub.course_id')
            ->on('tbl_course_wise_document.doc_sr_code', '=', 'sub.doc_sr_code')
            ->on('tbl_course_wise_document.doc_unique_id', '=', 'sub.doc_unique_id')
            ->on('tbl_course_wise_document.id', '=', 'sub.max_id');
    })
    ->where('tbl_course_wise_document.application_id',$application_id)
    ->orderBy('tbl_course_wise_document.id', 'desc')
    // ->where('tbl_course_wise_document.assessor_type',$assessor_type)
    ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag', 'approve_status','nc_flag']);


        $finalResults = [];
        foreach ($results as $key => $result) {
            if ($result) {
                $additionalField = $additionalFields->where('application_id', $result->application_id)
                    ->where('course_id', $result->course_id)
                    ->where('doc_sr_code', $result->doc_sr_code)
                    ->where('doc_unique_id', $result->doc_unique_id)
                    ->where('approve_status', 1)
                    ->first();

                if ($additionalField) {
                    $finalResults[$key] = (object)[];
                    $finalResults[$key]->status = $additionalField->status;
                    $finalResults[$key]->id = $additionalField->id;
                    $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                    $finalResults[$key]->nc_flag = $additionalField->nc_flag;
                    $finalResults[$key]->approve_status = $additionalField->approve_status;
                    // $finalResults[$key]->assessor_type = $additionalField->assessor_type;
                }
            }
        }

    
    $flag = 0;
    
    foreach ($finalResults as $result) {
        if (($result->status==2 || $result->status==3 || $result->status==4) && ($result->nc_flag==1)) {
            $flag = 1;
            break;
        }
    }
    if($flag==1) return true;else return false;
    

  


}

// public function checkSubmitButtonEnableOrDisable($application_id,$assessor_type)
// {

//    $get_payment = DB::table('tbl_application_payment')->where('application_id',$application_id)->count();
//    $get_docs_count = DB::table('tbl_application_course_doc')->where('application_id',$application_id)->count();
//    $get_course_count = DB::table('tbl_application_courses')->where('application_id',$application_id)->where('deleted_at',null)->count();


//    $total_docs = $get_course_count*4;
//    if($get_docs_count<$total_docs){
//     return true;
//    }else{
//     return false;
//    }

// }

public function checkReuploadBtn($application_id)
{

    $results = DB::table('tbl_course_wise_document')
        ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
        // ->where('course_id', $course_id)
        ->where('application_id', $application_id)
        ->where('approve_status',1)
        ->get();


    $additionalFields = DB::table('tbl_course_wise_document')
        ->join(DB::raw('(SELECT application_id, course_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_course_wise_document GROUP BY application_id, course_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
            $join->on('tbl_course_wise_document.application_id', '=', 'sub.application_id')
                ->on('tbl_course_wise_document.course_id', '=', 'sub.course_id')
                ->on('tbl_course_wise_document.doc_sr_code', '=', 'sub.doc_sr_code')
                ->on('tbl_course_wise_document.doc_unique_id', '=', 'sub.doc_unique_id')
                ->on('tbl_course_wise_document.id', '=', 'sub.max_id');
        })
        ->where('tbl_course_wise_document.application_id',$application_id)
        ->orderBy('tbl_course_wise_document.id', 'desc')
        ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag','nc_flag','approve_status','is_revert']);


    foreach ($results as $key => $result) {
        $additionalField = $additionalFields->where('application_id', $result->application_id)
            ->where('course_id', $result->course_id)
            ->where('doc_sr_code', $result->doc_sr_code)
            ->where('doc_unique_id', $result->doc_unique_id)
            // ->where('approve_status',1)
            ->first();
        if ($additionalField) {
            $results[$key]->status = $additionalField->status;
            $results[$key]->id = $additionalField->id;
            $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
            $results[$key]->nc_flag = $additionalField->nc_flag;
            $results[$key]->approve_status = $additionalField->approve_status;
            $results[$key]->is_revert = $additionalField->is_revert;
        }
    }

    
    $flag = 0;
    foreach ($results as $result) {
        if (($result->status == 2 || $result->status == 3 || $result->status == 4) && ($result->nc_flag==1 || $result->admin_nc_flag==3)) {
            $flag = 1;
            break;
        } else {
            $flag = 0;
        }
    }

    
    
    if ($flag == 1) {
        return true;
    } else {
        return false;
    }

}
public function checkReuploadBtnL1($application_id)
{

    $results = DB::table('tbl_course_wise_document')
        ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
        // ->where('course_id', $course_id)
        ->where('application_id', $application_id)
        ->where('approve_status',1)
        ->get();


    $additionalFields = DB::table('tbl_course_wise_document')
        ->join(DB::raw('(SELECT application_id, course_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_course_wise_document GROUP BY application_id, course_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
            $join->on('tbl_course_wise_document.application_id', '=', 'sub.application_id')
                ->on('tbl_course_wise_document.course_id', '=', 'sub.course_id')
                ->on('tbl_course_wise_document.doc_sr_code', '=', 'sub.doc_sr_code')
                ->on('tbl_course_wise_document.doc_unique_id', '=', 'sub.doc_unique_id')
                ->on('tbl_course_wise_document.id', '=', 'sub.max_id');
        })
        ->where('tbl_course_wise_document.application_id',$application_id)
        ->orderBy('tbl_course_wise_document.id', 'desc')
        ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag','nc_flag','approve_status','is_revert']);


    foreach ($results as $key => $result) {
        $additionalField = $additionalFields->where('application_id', $result->application_id)
            ->where('course_id', $result->course_id)
            ->where('doc_sr_code', $result->doc_sr_code)
            ->where('doc_unique_id', $result->doc_unique_id)
            // ->where('approve_status',1)
            ->first();
        if ($additionalField) {
            $results[$key]->status = $additionalField->status;
            $results[$key]->id = $additionalField->id;
            $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
            $results[$key]->nc_flag = $additionalField->nc_flag;
            $results[$key]->approve_status = $additionalField->approve_status;
            $results[$key]->is_revert = $additionalField->is_revert;
        }
    }

    
    $flag = 0;
    
    foreach ($results as $result) {
        if (($result->status == 2 || $result->status == 3 || $result->status == 4) && ($result->nc_flag==1 || $result->admin_nc_flag==1)) {
            $flag = 1;
            break;
        } else {
            $flag = 0;
            
        }
    }

    if ($flag == 1) {
        return true;
    } else {
        return false;
    }

}

public function isNcOnCourseDocs($application_id,$course_id)
{

    $results = DB::table('tbl_course_wise_document')
        ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
        ->where('course_id', $course_id)
        ->where('application_id', $application_id)
        ->where('approve_status',1)
        ->get();

        
        

    $additionalFields = DB::table('tbl_course_wise_document')
        ->join(DB::raw('(SELECT application_id, course_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_course_wise_document GROUP BY application_id, course_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
            $join->on('tbl_course_wise_document.application_id', '=', 'sub.application_id')
                ->on('tbl_course_wise_document.course_id', '=', 'sub.course_id')
                ->on('tbl_course_wise_document.doc_sr_code', '=', 'sub.doc_sr_code')
                ->on('tbl_course_wise_document.doc_unique_id', '=', 'sub.doc_unique_id')
                ->on('tbl_course_wise_document.id', '=', 'sub.max_id');
        })
        ->where('tbl_course_wise_document.application_id',$application_id)
        ->orderBy('tbl_course_wise_document.id', 'desc')
        ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag','approve_status','is_revert']);


    foreach ($results as $key => $result) {
        $additionalField = $additionalFields->where('application_id', $result->application_id)
            ->where('course_id', $result->course_id)
            ->where('doc_sr_code', $result->doc_sr_code)
            ->where('doc_unique_id', $result->doc_unique_id)
            // ->where('approve_status',1)
            ->first();
        if ($additionalField) {
            $results[$key]->status = $additionalField->status;
            $results[$key]->id = $additionalField->id;
            $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
            $results[$key]->approve_status = $additionalField->approve_status;
            $results[$key]->is_revert = $additionalField->is_revert;
        }
    }

    
    $flag = 0;
    
    foreach ($results as $result) {
        if (($result->status == 2 || $result->status == 3 || $result->status == 4)  && $result->is_revert==1) {
            $flag = 1;
            break;
        } else {
            $flag = 0;
            
        }
    }

    
    if ($flag == 1) {
        return true;
    } else {
        return false;
    }

}
public function isNcOnCourseDocsList($application_id,$application_courses_id)
{
    
    $results = DB::table('tbl_application_course_doc')
        ->select('application_id', 'application_courses_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id')
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
        ->where('tbl_application_course_doc.application_id',$application_id)
        ->orderBy('tbl_application_course_doc.id', 'desc')
        ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status','is_revert']);


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
            $results[$key]->approve_status = $additionalField->approve_status;
            $results[$key]->is_revert = $additionalField->is_revert;
        }
    }

    
    $flag = 0;
    

    foreach ($results as $result) {
        
        // if (($result->status == 1 && $result->approve_status==1) || ($result->status == 4 && $result->admin_nc_flag == 1)) {

        if (($result->status == 2 || $result->status == 3 || $result->status == 4) && $result->is_revert==1) {
            $flag = 1;
            break;
        } else {
            $flag = 0;
            
        }
    }

    
    
    if ($flag == 1) {
        return true;
    } else {
        return false;
    }

}

public function checkAllActionDoneOnRevert($application_id)
{

    $results = DB::table('tbl_course_wise_document')
        ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
        // ->where('course_id', $course_id)
        ->where('application_id', $application_id)
        ->where('approve_status',1)
        ->get();

        
        

    $additionalFields = DB::table('tbl_course_wise_document')
        ->join(DB::raw('(SELECT application_id, course_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_course_wise_document GROUP BY application_id, course_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
            $join->on('tbl_course_wise_document.application_id', '=', 'sub.application_id')
                ->on('tbl_course_wise_document.course_id', '=', 'sub.course_id')
                ->on('tbl_course_wise_document.doc_sr_code', '=', 'sub.doc_sr_code')
                ->on('tbl_course_wise_document.doc_unique_id', '=', 'sub.doc_unique_id')
                ->on('tbl_course_wise_document.id', '=', 'sub.max_id');
        })
        ->where('tbl_course_wise_document.application_id',$application_id)
        ->orderBy('tbl_course_wise_document.id', 'desc')
        ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag','approve_status','is_revert','is_tp_revert']);


    foreach ($results as $key => $result) {
        $additionalField = $additionalFields->where('application_id', $result->application_id)
            ->where('course_id', $result->course_id)
            ->where('doc_sr_code', $result->doc_sr_code)
            ->where('doc_unique_id', $result->doc_unique_id)
            // ->where('approve_status',1)
            ->first();
        if ($additionalField) {
            $results[$key]->status = $additionalField->status;
            $results[$key]->id = $additionalField->id;
            $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
            $results[$key]->approve_status = $additionalField->approve_status;
            $results[$key]->is_revert = $additionalField->is_revert;
            $results[$key]->is_tp_revert = $additionalField->is_tp_revert;
        }
    }

    
    $flag = 0;
    
    foreach ($results as $result) {
        if ($result->is_tp_revert == 1 && $result->status!=1) {
        // if ($result->is_tp_revert == 1) {
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

public function checkAllActionDoneOnRevert44($application_id)
{

    $results = DB::table('tbl_application_course_doc')
        ->select('application_id', 'application_courses_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id')
        // ->where('application_courses_id', $application_courses_id)
        ->whereNull('deleted_at')
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
        ->where('tbl_application_course_doc.application_id',$application_id)

        ->orderBy('tbl_application_course_doc.id', 'desc')
        ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status','is_revert','is_tp_revert']);


    foreach ($results as $key => $result) {
        $additionalField = $additionalFields->where('application_id', $result->application_id)
            ->where('application_courses_id', $result->application_courses_id)
            ->where('doc_sr_code', $result->doc_sr_code)
            ->where('doc_unique_id', $result->doc_unique_id)
            ->where('approve_status',1)
            ->whereNull('deleted_at')
            ->first();
        if ($additionalField) {
            $results[$key]->status = $additionalField->status;
            $results[$key]->id = $additionalField->id;
            $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
            $results[$key]->approve_status = $additionalField->approve_status;
            $results[$key]->is_revert = $additionalField->is_revert;
            $results[$key]->is_tp_revert = $additionalField->is_tp_revert;
        }
    }

    
    $flag = 0;
    
    foreach ($results as $result) {
        if ($result->is_tp_revert == 1) {
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

function revertTPCourseDocAction(Request $request){
    try{
        
        DB::beginTransaction();

        $get_course_doc = DB::table('tbl_course_wise_document')->where(['application_id'=>$request->application_id,'course_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name])->latest('id')->first();

        if($get_course_doc->is_tp_revert==1){
            return response()->json(['success' => false, 'message' => 'Action reverted failed.'], 200);
        }

        $revertAction = DB::table('tbl_course_wise_document')->where(['application_id'=>$request->application_id,'course_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name,'is_tp_revert'=>0])->delete();
            
        /*Delete nc on course doc*/ 
        $delete_= DB::table('tbl_nc_comments_secretariat')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$get_course_doc->doc_file_name])->delete();
                
                 /*end here*/            
        if($revertAction){
        $last_docs = DB::table('tbl_course_wise_document')->where(['application_id'=>$request->application_id,'course_id'=>$request->course_id,'doc_sr_code'=>$request->doc_sr_code])->latest('id')->first();
        
        if($last_docs->status==4){
            DB::table('tbl_course_wise_document')->where('id',$last_docs->id)->update(['nc_flag'=>1,'admin_nc_flag'=>3]);
        }else{
            DB::table('tbl_course_wise_document')->where('id',$last_docs->id)->update(['nc_flag'=>1]);
        }

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

function revertTPCourseDocListAction(Request $request){
    try{
        
        DB::beginTransaction();

        $get_course_doc = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name])->latest('id')->first();

        
        
        if($get_course_doc->is_tp_revert==1){
            return response()->json(['success' => false, 'message' => 'Action reverted failed.'], 200);
        }

        $revertAction = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name,'is_tp_revert'=>0])->delete();
            
        /*Delete nc on course doc*/ 
        $delete_= DB::table('tbl_nc_comments')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$get_course_doc->doc_file_name])->delete();
                
                 /*end here*/            
                 
        if($revertAction){
        $last_docs = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_sr_code'=>$request->doc_sr_code])->latest('id')->first();
        if($get_course_doc->assessor_type=="onsite"){
            $status_type='onsite_nc_status';
        }else{
            $status_type='nc_flag';
        }

        if(isset($last_docs)){
            if($last_docs->status==4){

                DB::table('tbl_application_course_doc')->where('id',$last_docs->id)->update([$status_type=>1,'admin_nc_flag'=>3]);
            }else{
                DB::table('tbl_application_course_doc')->where('id',$last_docs->id)->update([$status_type=>1]);
            }
        }
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

   function get_saarc_ids(){
    //Afghanistan, Bangladesh, Bhutan, India, Maldives, Nepal, Pakistan and Sri-Lanka
    // $saarc=Country::whereIn('name',Array('Afghanistan', 'Bangladesh', 'Bhutan', 'Maldives', 'Nepal', 'Pakistan', 'Sri Lanka'))->get('id');
    $saarc=Country::whereIn('name',Array('American Samoa'))->get('id');
    $saarc_ids=Array();
    foreach($saarc as $val)$saarc_ids[]=$val->id;
    return $saarc_ids;
}


}
