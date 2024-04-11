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
use App\Models\Application;
use App\Models\Add_Document;
use App\Models\AssessorApplication; 
use App\Models\User; 
use App\Models\Chapter; 
use Carbon\Carbon;
use App\Models\TblNCComments; 
use URL;

class AccountApplicationController extends Controller
{
    public function __construct()
    {

    }
     
    /** Application List For Account */
    public function getApplicationList(){
        $application = DB::table('tbl_application as a')
        ->whereIn('payment_status',[0,1,2,3])
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
        
        return view('account-view.application-list',['list'=>$final_data]);
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
        return view('account-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status]);
    }

    public function updatePaynentInfo(Request $request)
    {

        // dd($request->all());
        try{
          $request->validate([
              'id' => 'required',
              'payment_transaction_no' => 'required',
              'payment_reference_no' => 'required',
              'payment_proof_by_account' => '',
          ]);
  
          DB::beginTransaction();
          $slip_by_approver_file = "";
          if ($request->hasfile('payment_proof_by_account')) {
              $file = $request->file('payment_proof_by_account');
              $name = $file->getClientOriginalName();
              $filename = time() . $name;
              $file->move('documnet/', $filename);
              $slip_by_approver_file = $filename;
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


          $get_payment_update_count = DB::table('tbl_application_payment')->where('id',$request->id)->first()->account_update_count;
         
          if($get_payment_update_count > (int)env('ACCOUNT_PAYMENT_UPDATE_COUNT')-1){
              return response()->json(['success' => false,'message' =>'Your update limit is expired'],200);
          }

          $data = [];
          $data['payment_transaction_no']=$request->payment_transaction_no;
          $data['payment_reference_no']=$request->payment_reference_no;
          $data['account_update_count']=$get_payment_update_count+1;

          if ($request->hasfile('payment_proof_by_account')) {
              $data['payment_proof_by_account']=$slip_by_approver_file;
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


    public function updateAccountNotificationStatus(Request $request,$id)
    {
        try{
          $request->validate([
              'id' => 'required',
          ]);
          DB::beginTransaction();
        //   $application_id = DB::table('tbl_application')->where('id',$request->id)->first()->application_id;
          $update_account_received_payment_status = DB::table('tbl_application_payment')->where('application_id',$id)->update(['account_received_payment'=>1]);

          if($update_account_received_payment_status){
              DB::commit();
              $redirect_url = URL::to('/account/application-view/'.dEncrypt($id));
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



    public function accountantVerfiyDocument($nc_type,$doc_sr_code, $doc_name, $application_id, $doc_unique_code,$application_course_id)
    {
        
        try{
            $final_approval = DB::table('tbl_nc_comments_secretariat')->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code,'assessor_type'=>'admin'])
            ->where('nc_type',"Request_For_Final_Approval")
            ->latest('id')->first();

            // dd($final_approval);
            // $ass_type = $assessor_type=="desktop"?"desktop":"onsite";

            if($nc_type=="nr"){
                $nc_type="not_recommended";
            }
            
            if($nc_type!="nc1" && $nc_type!="nc2" && $nc_type!="accept" && $nc_type!="reject"){
                if(!empty($final_approval)){
                    $nc_type="Request_For_Final_Approval";
                    $assessor_type="admin";
                }else{
                    // $ass_type=null;
                }
            }
          

            $query = DB::table('tbl_nc_comments_secretariat')->where([
                'doc_sr_code' => $doc_sr_code,
                'application_id' => $application_id,
                'doc_unique_id' => $doc_unique_code
            ])
            ->where('nc_type', $nc_type);
            

            // if ($nc_type=="not_recommended" || $nc_type=="Request_For_Final_Approval") {
            //     $query->where('final_status', $ass_type);
            // }
            $nc_comments = $query
                ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role', 'users.role')
                ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                ->first();
            
            // dd($nc_comments);

            $tbl_nc_comments = DB::table('tbl_nc_comments_secretariat')->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
            // ->where('final_status',$ass_type)
            ->latest('id')
            ->first();

            
            
            /*Don't show form if doc is accepted*/ 
            $accepted_doc = DB::table('tbl_nc_comments_secretariat')->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
            ->whereIn('nc_type',["Accept","Reject"])
            // ->where('final_status',$assessor_type)
            ->latest('id')
            ->first();
            
            /*end here*/
            $form_view=0;
            if($nc_type==="not_recommended" && ($tbl_nc_comments->nc_type!=="Reject") && ($tbl_nc_comments->nc_type!=="Accept") && ($tbl_nc_comments->nc_type!=="NC1") && ($tbl_nc_comments->nc_type!=="NC2") && ($tbl_nc_comments->nc_type!=="Request_For_Final_Approval")){
                if(empty($accepted_doc)){
                    $form_view=1;
                }
            }else if($nc_type=="reject"){
                $form_view=0;
            }

            
        if(isset($tbl_nc_comments->nc_type)){
                if($tbl_nc_comments->nc_type==="not_recommended"){
                    $dropdown_arr = array(
                                "Reject"=>"Reject",
                                "Accept"=>"Accept",
                                "Request_For_Final_Approval"=>'Request For Final Approval'
                            );
                }
       }
        
        $doc_path = URL::to("/documnet").'/'.$doc_name;
        return view('account-view.document-verify', [
            'doc_id' => $doc_sr_code,
            'doc_code' => $doc_unique_code,
            'application_id' => $application_id,
            'application_course_id'=>$application_course_id,
            'doc_path' => $doc_path,
            'doc_file_name'=>$doc_name,
            'dropdown_arr'=>$dropdown_arr??[],
            'nc_comments'=>$nc_comments,
            'form_view'=>$form_view,
            'nc_type'=>$nc_type,
        ]);
    }catch(Exception $e){
        return back()->with('fail','Something went wrong');
    }
    }
}

