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
use App\Models\TblNCComments; 
use App\Jobs\SendEmailJob;
use URL;
use File;
class TPApplicationController extends Controller
{
    use PdfImageSizeTrait;
    public function __construct()
    {
    }
    public function getApplicationList($level_type='level-first'){

        $pay_list = DB::table('tbl_application_payment')
          ->where('user_id',Auth::user()->id)
          ->get()
          ->pluck('application_id')
          ->toArray();
          
        if($level_type=="level-first"){
            $level_id = 1;
        }else if($level_type=="level-second"){
            $level_id = 2;
        }else{
            $level_id = 3;
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
        
        return view('tp-view.application-list',['list'=>$final_data]);
    }

    /** Whole Application View for Account */
    public function getApplicationView($id){
        
        

        
        $application = DB::table('tbl_application')
        ->where('id', dDecrypt($id))
        ->first();
        $json_course_doc = File::get(base_path('/public/course-doc/courses.json'));
        $decoded_json_courses_doc = json_decode($json_course_doc);
        
        $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->latest('id')->first();
        
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
                ])->get();
                if($payment){
                    $obj->payment = $payment;
                }
                $final_data = $obj;
                $tp_final_summary_count =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id])->count();
                if($tp_final_summary_count>1){
                 $is_final_submit = true;
                }else{
                 $is_final_submit = false;
                }

        return view('tp-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit,'courses_doc'=>$decoded_json_courses_doc]);
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
        ])->select('id','doc_unique_id','doc_file_name','doc_sr_code','nc_flag','admin_nc_flag','assessor_type','ncs_flag_status','status')->get();

        $onsite_course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'assessor_type'=>'onsite'
        ])
        ->select('id','doc_unique_id','onsite_doc_file_name','doc_file_name','doc_sr_code','admin_nc_flag','assessor_type','onsite_status','onsite_nc_status','status')
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
                            'doc_sr_code' => $question->code,
                        ])
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
                        ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
                        ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
                        ->get(),
                    ];
                }
                $final_data[] = $obj;
        }

        
        $applicationData = TblApplication::find($application_id);
        return view('tp-upload-documents.tp-upload-documents', compact('final_data','onsite_course_doc_uploaded', 'course_doc_uploaded','application_id','course_id','application_uhid'));
    }
    
    public function addDocument(Request $request)
    {
       try{
        DB::beginTransaction();
        $tp_id = Auth::user()->id;
        $course_doc = new TblApplicationCourseDoc;
        $course_doc->application_id = $request->application_id;
        $course_doc->application_courses_id = $request->application_courses_id;
        $course_doc->doc_sr_code = $request->doc_sr_code;
        $course_doc->doc_unique_id = $request->doc_unique_id;
        $course_doc->tp_id = $tp_id;
        $course_doc->assessor_type =$request->assessor_type;
        if ($request->hasfile('fileup')) {
            $file = $request->file('fileup');
            $name = $file->getClientOriginalName();
            $filename = time() . $name;
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
        
        if($is_already_remark_exists->nc_type!=="Accept" && $is_already_remark_exists->nc_type!=="Request_For_Final_Approval"){
            if($is_already_remark_exists->tp_remark!==null){
                $is_form_view=false;
            }else{
                $is_form_view=true;
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



    function secondPaymentView(Request $request)
    {

        
        return view('tp-upload-documents.tp-show-document-details', [
            'doc_latest_record' => $doc_latest_record,
            'doc_id' => $doc_sr_code,
            'doc_code' => $doc_unique_code,
            'application_id' => $application_id,
            'doc_path' => $doc_path,
            'remarks' => $get_remarks
        ]);
    }


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
         $update_payment = DB::table('tbl_application_payment')->where('id',$request->id)->first();
         $updateArr=[];
         $updateArr['old_payment_transaction_no']=$update_payment->payment_transaction_no;
         $updateArr['new_payment_transaction_no']=$request->payment_transaction_no;
         $updateArr['old_payment_reference_no']=$update_payment->payment_reference_no;
         $updateArr['new_payment_reference_no']=$request->payment_reference_no;
         $updateArr['application_id']=$update_payment->application_id;
         $updateArr['user_id']=Auth::user()->id;
         DB::table('payment_history')->insert($updateArr);
       /*end here*/   

        $get_payment_update_count = DB::table('tbl_application_payment')->where('id',$request->id)->first()->tp_update_count;
       
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


        $update_payment_info = DB::table('tbl_application_payment')->where('id',$request->id)->update($data);

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


  public function pendingPaymentlist($level_type='level-first')
  {

        if($level_type=="level-first"){
            $level_id = 1;
        }else if($level_type=="level-second"){
            $level_id = 2;
        }else{
            $level_id = 3;
        }

      $pending_payment_list = DB::table('tbl_application_payment')
          ->where('user_id',Auth::user()->id)
          ->where('level_id',$level_id)
          ->get()
          ->pluck('application_id')
          ->toArray();

         $pending_list = DB::table('tbl_application')
         ->where('tp_id',Auth::user()->id)
         ->where('level_id',$level_id)
         ->whereNotIn('id',$pending_payment_list)
         ->orderBy('id','desc')
         ->get();

      return view('tp-view.pending-payment-list', ['pending_payment_list' => $pending_list]);
  }

  public function paymentReferenceValidation(Request $request)
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

  public function paymentTransactionValidation(Request $request)
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
        if($is_already_remark_exists->nc_type!=="Accept" && $is_already_remark_exists->nc_type!=="Request_For_Final_Approval"){
            if($is_already_remark_exists->tp_remark!==null){
                $is_form_view=false;
            }else{
                $is_form_view=true;
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
      DB::table('tbl_course_wise_document')->where(['application_id'=> $request->application_id,'course_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id])->whereIn('status',[2,3,4])->update(['nc_flag'=>0]);

      
            
    
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
public function upgradeNewApplication(Request $request,$application_id=null){
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
            $data['refid'] = $request->reference_id;
            $data['application_date'] = $application_date;
            
            TblApplication::where('id',$request->application_id)->update(['upgraded_level_id'=>2]);
            $application = new TblApplication($data);
            $application->save();
            
            $application->refid = $request->reference_id;
            $application->save();

            $create_new_application = $request->application_id;
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
        $applicationData = TblApplication::where('refid',$refid)->latest()->first();
    }else{
        $applicationData=null;
    }
    $first_application_id = TblApplication::where('refid',$refid)->first();
    
    $last_application_id = TblApplication::where('refid',$refid)->latest()->first()->id;
    
    $old_courses = TblApplicationCourses::where('application_id',$first_application_id->id)->where('deleted_by_tp',0)->get();
    
    // $last_application = TblApplication::where('refid',$refid)->first();
    $course = TblApplicationCourses::where('application_id', $last_application_id)->get();
    
    $original_course_count = TblApplicationCourses::where('application_id', $id)->count();
    
    return view('tp-view.create-course', compact('applicationData', 'course','original_course_count','old_courses'));
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
             if($j===0){
                $data['doc_file_name'] = $file->declaration_pdf;
                $data['doc_sr_code'] = config('constant.declaration.doc_sr_code');
                $data['doc_unique_id'] = config('constant.declaration.doc_unique_id');
             }
             if($j===1){
                $data['doc_file_name'] = $file->course_curriculum_pdf;
                $data['doc_sr_code'] = config('constant.curiculum.doc_sr_code');
                $data['doc_unique_id'] = config('constant.curiculum.doc_unique_id');
             }
             if($j===2){
                $data['doc_file_name'] = $file->course_details_xsl;
                $data['doc_sr_code'] = config('constant.details.doc_sr_code');
                $data['doc_unique_id'] = config('constant.details.doc_unique_id');
             }
             $data['application_id'] = $request->application_id;
             $data['course_id'] = $file->id;
             $data['tp_id'] = Auth::user()->id;
             $data['level_id'] = $request->level_id;
             $data['course_name'] = $course_name[$i];
             
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
        
        $checkPaymentAlready = DB::table('tbl_application_payment')->where('application_id', $id)->count();
       
        if ($checkPaymentAlready>1) {
                return redirect(url('get-application-list'))->with('fail', 'Payment has already been submitted for this application.');
        }
        if ($id) {
            $applicationData = DB::table('tbl_application')->where('id', $id)->first();
            
            $get_assessor_user = DB::table('assessor_final_summary_reports')->where('application_id',$id)->count();

            $course = DB::table('tbl_application_courses')->where('application_id', $id)->get();
            if (Auth::user()->country == $this->get_india_id()) {
                  
                    $assessor_type = $get_assessor_user==0 ?'desktop':'onsite';
                    $total_amount = $this->getPaymentFee($assessor_type,"inr",$id,$assessor_type);
                    
                
                $currency = '₹';
            } elseif (in_array(Auth::user()->country, $this->get_saarc_ids())) {
                if (count($course) == '0') {
                    $currency = 'US $';
                    $total_amount = '0';
                } elseif (count($course) <= 5) {
                    $currency = 'US $';
                    $total_amount =  '15';
                } elseif (count($course) <= 10) {
                    $currency = 'US $';
                    $total_amount = '30';
                } else {
                    $currency = 'US $';
                    $total_amount =  '45';
                }
            } else {
                if (count($course) == '0') {
                    $currency = 'US $';
                    $total_amount = '';
                } elseif (count($course) <= 5) {
                    $currency = 'US $';
                    $total_amount = '50';
                } elseif (count($course) <= 10) {
                    $currency = 'US $';
                    $total_amount = '100';
                } else {
                    $currency = 'US $';
                    $total_amount =  '150';
                }
            }
        }
        return view('tp-view.show-course-payment', compact('applicationData', 'course', 'currency', 'total_amount'));
    }
    


    public function upgradeNewApplicationPayment(Request $request)
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
        if (Auth::user()->country == $this->get_india_id()) {
            $assessor_type = $get_assessor_user==0 ?'desktop':'onsite';

            $total_amount = $this->getPaymentFee($assessor_type,"inr",$request->Application_id,$assessor_type);
            $currency = '₹';
        } 
        
        $transactionNumber = trim($request->transaction_no);
        $referenceNumber = trim($request->reference_no);
        $is_exist_t_num_or_ref_num = DB::table('tbl_application_payment')
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
        ->whereNull('remark_by_account')
        ->count();
            if ($checkPaymentAlready>2) {
                return redirect(url('level-second/tp/application-list'))->with('fail', 'Payment has already been submitted for this application.');
            }
        $this->validate($request, [
            'payment_details_file' => 'mimes:pdf,jpeg,png,jpg,gif,svg',
        ]);
        $item = new TblApplicationPayment;
        $item->level_id = $request->level_id;
        $item->user_id = Auth::user()->id;
        $item->amount = $total_amount;
        $item->payment_date = date("d-m-Y");
        $item->payment_mode = $request->payment;
        $item->payment_transaction_no = $transactionNumber;
        $item->payment_reference_no = $referenceNumber;
        // $item->currency = $request->currency;
        $item->application_id = $request->Application_id;
        if ($request->hasfile('payment_details_file')) {
            $img = $request->file('payment_details_file');
            $name = $img->getClientOriginalName();
            $filename = time() . $name;
            $img->move('uploads/', $filename);
            $item->payment_proof = $filename;
        }
        $item->save();


        if(isset($first_app_id)){

            DB::table('tbl_application')->where('id',$first_app_id->id)->update(['is_all_course_doc_verified'=>3]);
        }

        
        DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->Application_id])->update(['second_payment_status' => 1]);

        $application_id = $request->Application_id;
        $userid = Auth::user()->firstname;
        
        if ($request->level_id == '2') {
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
                dispatch(new SendEmailJob($details));
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
                dispatch(new SendEmailJob($details));
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
                dispatch(new SendEmailJob($details));
                
            /*send email end here*/ 
            DB::commit();
            return  redirect(url('/level-second/tp/application-list/'))->with('success', 'Payment Done successfully');
        }else{
            DB::rollBack();
            return  redirect(url('/level-second/tp/application-list/'))->with('failed', 'Failed to make payment');
        }  
       }
       catch(Exception $e){
        DB::rollback();
        return  redirect('/level-fourth')->with('success', 'Payment Done successfully');
       }
    }



    
    public function upgradeGetApplicationView($id){
        
        $application = DB::table('tbl_application')
        ->where('id', dDecrypt($id))
        ->first();
        $json_course_doc = File::get(base_path('/public/course-doc/courses.json'));
        $decoded_json_courses_doc = json_decode($json_course_doc);
        
        $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->latest('id')->first();
        
            $obj = new \stdClass;
            $obj->application= $application;
            $courses = DB::table('tbl_application_courses')->where([
                'application_id'=>$application->id,
                
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
                ])->get();
                if($payment){
                    $obj->payment = $payment;
                }
                $final_data = $obj;
                $tp_final_summary_count =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id])->count();
                if($tp_final_summary_count>1){
                 $is_final_submit = true;
                }else{
                 $is_final_submit = false;
                }

                
        return view('tp-view.upgrade-application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit,'courses_doc'=>$decoded_json_courses_doc]);
    }

    function get_india_id()
    {
        $india = Country::where('name', 'India')->get('id')->first();
        return $india->id;
    }
/*end here*/ 












/*--Level 3----*/ 
public function upgradeNewApplicationLevel3(Request $request,$application_id=null){
    if ($application_id) {
        $applicationData = DB::table('tbl_application')->where('id', dDecrypt($application_id))->first();
    } else {
        $applicationData = null;
    }
    
    $id = Auth::user()->id;
    $item = LevelInformation::whereid('2')->get();
    
    $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
    
    return view('tp-view.level3-upgrade-new-application', ['data' => $data, 'applicationData' => $applicationData, 'item' => $item]);
}

public function  storeNewApplicationLevel3(Request $request)
{
   
    
    $application_date = Carbon::now()->addDays(364);
    
    /*check if application already created*/

            $data = [];
            $data['level_id'] = 3;
            $data['tp_id'] = $request->user_id;
            $data['person_name'] = $request->person_name;
            $data['email'] =  $request->email;
            $data['contact_number'] = $request->contact_number;
            $data['designation'] = $request->designation;
            $data['tp_ip'] = getHostByName(getHostName());
            $data['user_type'] = 'tp';
            $data['refid'] = $request->reference_id;
            $data['application_date'] = $application_date;
           
            TblApplication::where('id',$request->application_id)->update(['upgraded_level_id'=>3,'is_all_course_doc_verified'=>2]);

            

            $application = new TblApplication($data);
            $application->save();

            $application->refid = $request->reference_id;
            $application->save();

            $create_new_application = $request->application_id;
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
    
    $id = dDecrypt($id);
    $refid = dDecrypt($refid);
    
    if ($id) {
        $applicationData = TblApplication::where('refid',$refid)->latest()->first();
    }else{
        $applicationData=null;
    }
    $first_application_id = TblApplication::where('refid',$refid)->first();
    $last_application_id = TblApplication::where('refid',$refid)->latest()->first()->id;
    
    $old_courses = TblApplicationCourses::where('application_id',$first_application_id->id)->where('deleted_by_tp',0)->get();
    
    // $last_application = TblApplication::where('refid',$refid)->first();
    $course = TblApplicationCourses::where('application_id', $last_application_id)->get();
    
    $original_course_count = TblApplicationCourses::where('application_id', $id)->count();
    
    return view('tp-view.level3-create-course', compact('applicationData', 'course','original_course_count','old_courses'));
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
             if($j===0){
                $data['doc_file_name'] = $file->declaration_pdf;
                $data['doc_sr_code'] = config('constant.declaration.doc_sr_code');
                $data['doc_unique_id'] = config('constant.declaration.doc_unique_id');
             }
             if($j===1){
                $data['doc_file_name'] = $file->course_curriculum_pdf;
                $data['doc_sr_code'] = config('constant.curiculum.doc_sr_code');
                $data['doc_unique_id'] = config('constant.curiculum.doc_unique_id');
             }
             if($j===2){
                $data['doc_file_name'] = $file->course_details_xsl;
                $data['doc_sr_code'] = config('constant.details.doc_sr_code');
                $data['doc_unique_id'] = config('constant.details.doc_unique_id');
             }
             $data['application_id'] = $request->application_id;
             $data['course_id'] = $file->id;
             $data['tp_id'] = Auth::user()->id;
             $data['level_id'] = 3;
             $data['course_name'] = $course_name[$i];
             
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
        
    
        $checkPaymentAlready = DB::table('tbl_application_payment')->where('application_id', $id)->count();
    
        if ($checkPaymentAlready>1) {
                return redirect(url('get-application-list'))->with('fail', 'Payment has already been submitted for this application.');
        }
        if ($id) {
            $applicationData = DB::table('tbl_application')->where('id', $id)->first();
            $get_assessor_user = DB::table('assessor_final_summary_reports')->where('application_id',$id)->count();
            $course = DB::table('tbl_application_courses')->where('application_id', $id)->get();
            if (Auth::user()->country == $this->get_india_id()) {
                
                $assessor_type = $get_assessor_user==0 ?'desktop':'onsite';
                
                $total_amount = $this->getPaymentFee($assessor_type,"inr",$id,$assessor_type);
                $currency = '₹';

            } elseif (in_array(Auth::user()->country, $this->get_saarc_ids())) {
                if (count($course) == '0') {
                    $currency = 'US $';
                    $total_amount = '0';
                } elseif (count($course) <= 5) {
                    $currency = 'US $';
                    $total_amount =  '15';
                } elseif (count($course) <= 10) {
                    $currency = 'US $';
                    $total_amount = '30';
                } else {
                    $currency = 'US $';
                    $total_amount =  '45';
                }
            } else {
                if (count($course) == '0') {
                    $currency = 'US $';
                    $total_amount = '';
                } elseif (count($course) <= 5) {
                    $currency = 'US $';
                    $total_amount = '50';
                } elseif (count($course) <= 10) {
                    $currency = 'US $';
                    $total_amount = '100';
                } else {
                    $currency = 'US $';
                    $total_amount =  '150';
                }
            }
        }
        return view('tp-view.level3-show-course-payment', compact('applicationData', 'course', 'currency', 'total_amount'));
    }
    
public function upgradeNewApplicationPaymentLevel3(Request $request)
{

    $first_app_refid = TblApplication::where('id',$request->Application_id)->first();
    $first_app_id = TblApplication::where('refid',$first_app_refid->refid)->get();

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

    /*Implemented by suraj*/
        $get_final_summary = DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->Application_id,'payment_status'=>0,'assessor_type'=>'desktop'])->first();
        if(!empty($get_final_summary)){
        DB::table('assessor_final_summary_reports')->where('application_id',$request->Application_id)->update(['payment_status' => 1]);
        }
    /*end here*/
    $checkPaymentAlready = TblApplicationPayment::where('application_id', $request->Application_id)
    ->whereNull('remark_by_account')
    ->count();
        if ($checkPaymentAlready>2) {
            return redirect(url('level-second/tp/application-list'))->with('fail', 'Payment has already been submitted for this application.');
        }
    $this->validate($request, [
        'payment_details_file' => 'mimes:pdf,jpeg,png,jpg,gif,svg',
    ]);
    $item = new TblApplicationPayment;
    $item->level_id = $request->level_id;
    $item->user_id = Auth::user()->id;
    $item->amount = $request->amount;
    $item->payment_date = date("d-m-Y");
    $item->payment_mode = $request->payment;
    $item->payment_transaction_no = $transactionNumber;
    $item->payment_reference_no = $referenceNumber;
    // $item->currency = $request->currency;
    $item->application_id = $request->Application_id;
    if ($request->hasfile('payment_details_file')) {
        $img = $request->file('payment_details_file');
        $name = $img->getClientOriginalName();
        $filename = time() . $name;
        $img->move('uploads/', $filename);
        $item->payment_proof = $filename;
    }
    $item->save();


    if(isset($first_app_id)){
        DB::table('tbl_application')->whereIn('id',[$first_app_id[0]->id??0,$first_app_id[1]->id??0])->update(['is_all_course_doc_verified'=>3]);
    }


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
            dispatch(new SendEmailJob($details));
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
            dispatch(new SendEmailJob($details));
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
            dispatch(new SendEmailJob($details));
        
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
    
    
    $application = DB::table('tbl_application')
    ->where('id', dDecrypt($id))
    ->first();
    $json_course_doc = File::get(base_path('/public/course-doc/courses.json'));
    $decoded_json_courses_doc = json_decode($json_course_doc);
    
    $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
    $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->latest('id')->first();
    
        $obj = new \stdClass;
        $obj->application= $application;
        $courses = DB::table('tbl_application_courses')->where([
            'application_id'=>$application->id
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
            ])->get();
            if($payment){
                $obj->payment = $payment;
            }
            $final_data = $obj;
            $tp_final_summary_count =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id])->count();
            if($tp_final_summary_count>1){
                $is_final_submit = true;
            }else{
                $is_final_submit = false;
            }

            
    return view('tp-view.level3-upgrade-application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit,'courses_doc'=>$decoded_json_courses_doc]);
}


function getPaymentFee($level,$currency,$application_id,$assessment=null){

    $course = DB::table('tbl_application_courses')->where('application_id', $application_id)->get();

    if (Auth::user()->country == $this->get_india_id() && $assessment=='desktop') {
        $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>$currency,'level'=>'desktop'])->get();
        if (count($course) == '0') {
          
            $total_amount = '0';
        } elseif (count($course) <= 5) {
            
            $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);

        } elseif (count($course)>=5 && count($course) <= 10) {
            
            $total_amount = (int)$get_payment_list[1]->courses_fee +((int)$get_payment_list[1]->courses_fee * 0.18);
            
        } elseif(count($course)>10) {
            
            $total_amount = (int)$get_payment_list[2]->courses_fee +((int)$get_payment_list[2]->courses_fee * 0.18);
        }    
    } 

    if (Auth::user()->country == $this->get_india_id() && $assessment=='onsite') {
        $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>'inr'])->whereIn('level',['annual','assessment'])->get();
        
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
    } 
    return $total_amount;
}
/*end here*/ 






}
