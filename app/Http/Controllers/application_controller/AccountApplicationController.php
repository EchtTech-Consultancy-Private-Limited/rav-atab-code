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
    
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $application->id,
                ])
                ->whereNull('deleted_at') 
                ->get();
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
        return view('account-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status]);
    }

    public function updatePaynentInfo(Request $request)
    {

        try{
          $request->validate([
              'id' => 'required',
              'payment_transaction_no' => 'required',
              'payment_reference_no' => 'required',
              'payment_proof_by_account' => 'required',
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


    public function updateAccountNotificationStatus(Request $request)
    {
        
        try{
          $request->validate([
              'id' => 'required',
          ]);
          DB::beginTransaction();
          $application_id = DB::table('tbl_application_payment')->where('id',$request->id)->first()->application_id;
          $update_account_received_payment_status = DB::table('tbl_application_payment')->where('id',$request->id)->update(['account_received_payment'=>1]);
          if($update_account_received_payment_status){
              DB::commit();
              $redirect_url = URL::to('/account/application-view/'.dEncrypt($application_id));
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

