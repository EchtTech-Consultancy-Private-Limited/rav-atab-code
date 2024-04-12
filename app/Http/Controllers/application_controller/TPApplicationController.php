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
use App\Models\DocumentRemark;
use App\Models\Application;
use App\Models\Add_Document;
use App\Models\AssessorApplication; 
use App\Models\User; 
use App\Models\Chapter; 
use Carbon\Carbon;
use App\Models\TblNCComments; 
use URL;
use Config;
use Session;
use File;
class TPApplicationController extends Controller
{
    use PdfImageSizeTrait;
    public function __construct()
    {
    }
    public function getApplicationList(){

        $pay_list = DB::table('tbl_application_payment')
          ->where('user_id',Auth::user()->id)
          ->get()
          ->pluck('application_id')
          ->toArray();

        $application = DB::table('tbl_application as a')
        ->where('tp_id',Auth::user()->id)
        ->whereIn('id',$pay_list)
        ->orderBy('id','desc')
        ->get();
        $final_data=array();
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
        // dd($final_data);
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
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get(),
            
                        'nc_comments_course_curiculam' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                            'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get(),
            
                        'nc_comments_course_details' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.details.doc_sr_code'),
                            'doc_unique_id' => config('constant.details.doc_unique_id'),
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
        ])->select('id','doc_unique_id','doc_file_name','doc_sr_code','nc_flag','admin_nc_flag','assessor_type','status')->get();

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


  public function pendingPaymentlist()
  {

      $pending_payment_list = DB::table('tbl_application_payment')
          ->where('user_id',Auth::user()->id)
          ->get()
          ->pluck('application_id')
          ->toArray();

         $pending_list = DB::table('tbl_application')
         ->where('tp_id',Auth::user()->id)
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
public function upgradeNewApplication(Request $request,$reference_id=null){
    if ($reference_id) {
        $applicationData = DB::table('tbl_application')->where('refid', dDecrypt($reference_id))->first();
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
    $this->validate(
        $request,
        [
            // 'Email_ID' => ['required', 'regex:/^(?!.*[@]{2,})(?!.*\s)[a-zA-Z0-9\+_\-]+(\.[a-zA-Z0-9\+_\-]+)*@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/i', 'unique:applications,Email_ID'],
            'Email_ID' => ['required', 'regex:/^(?!.*[@]{2,})(?!.*\s)[a-zA-Z0-9\+_\-]+(\.[a-zA-Z0-9\+_\-]+)*@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/i'],
            'Contact_Number' => 'required|numeric|min:10|digits:10,Contact_Number',
            'Person_Name' => 'required',
            'designation' => 'required',
        ],
        [
            'Email_ID.regex' => "Please Enter a Valid Email Id.",
            'Email_ID.required' => "Please Enter an Email Id.",
        ]
    );
    $currentDateTime = Carbon::now();
    $application_date = Carbon::now()->addDays(365);
    /*check if application already created*/
        
        if($request->application_id && $request->previous_data==1){
            $data = [];
            $data['level_id'] = 1;
            $data['tp_id'] = $request->user_id;
            $data['person_name'] = $request->Person_Name;
            $data['email'] =  $request->Email_ID;
            $data['contact_number'] = $request->Contact_Number;
            $data['designation'] = $request->designation;
            $data['tp_ip'] = getHostByName(getHostName());
            $data['user_type'] = 'tp';
            $data['application_date'] = $application_date;
            $create_new_application = DB::table('tbl_application')->where('id',$request->application_id)->update($data);
            $create_new_application = $request->application_id;
            $msg="Application Updated Successfully";
        }else{
            $data = [];
            $data['level_id'] = 1;
            $data['tp_id'] = $request->user_id;
            $data['person_name'] = $request->Person_Name;
            $data['email'] =  $request->Email_ID;
            $data['contact_number'] = $request->Contact_Number;
            $data['designation'] = $request->designation;
            $data['tp_ip'] = getHostByName(getHostName());
            $data['user_type'] = 'tp';
            $data['application_date'] = $application_date;

            $application = new TblApplication($data);
            $application->save();

            $create_new_application = $application->id;
            // $create_new_application = DB::table('tbl_application')->insertGetId($data);
            $msg="Application Created Successfully";
        }
    /*end here*/
    return redirect(url('create-new-course/' . dEncrypt($create_new_application)))->with('success', $msg);
}

/*end here*/ 

}
