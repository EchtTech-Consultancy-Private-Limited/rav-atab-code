<?php

namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Jobs\SendEmailJob;
class DocApplicationController extends Controller
{
    public function __construct()
    {

    }
    public function showCoursePdf($name)
    {
        $data = $name;
        return view('doc-view.file-view', ['data' => $data]);
    }

    public function accountReceivedPayment(Request $request)
    {

        try{
             DB::beginTransaction();
             $application_id = dDecrypt($request->application_id);
             
            $is_exists = DB::table('tbl_application_payment')->where('application_id',$application_id)->where('status',1)->first();
            
            if($is_exists){
                return response()->json(['success' =>false,'message'=>'Payment already done.'], 200);
            }
            
            
            if ($request->hasfile('payment_proof')) {
                $payment_proof = $request->file('payment_proof');
            }
            $name = $payment_proof->getClientOriginalName();
            $filename = time() . $name;
            $payment_proof->move('documnet/', $filename);

            $application_id = dDecrypt($request->application_id);

            DB::table('tbl_application')->where('id',$application_id)->update(['payment_status'=>1]); //payment_status = 1 for payment received 2 for payment approved

            DB::table('tbl_application_payment')->where(['application_id'=>$application_id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','payment_proof_by_account'=>$filename,'accountant_id'=>Auth::user()->id]);
            DB::commit();
            return response()->json(['success' => true,'message' => 'Payment received successfully.'], 200);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' =>false,'message'=>'Failed to make payment'], 200);
        }
       
    }


    public function accountApprovePayment(Request $request)
    {

        try{
            DB::beginTransaction();
            $application_id = dDecrypt($request->application_id);
            DB::table('tbl_application')->where('id',$application_id)->update(['payment_status'=>2]); //payment_status = 1 for payment received 2 for payment approved
            
            DB::table('tbl_application_payment')->where(['application_id'=>$application_id])->update(['status'=>2,'approve_remark'=>$request->final_payment_remark??'','accountant_id'=>Auth::user()->id]);


             /**
             * Send Email to Accountant
             * */ 
            $tp_id = DB::table('tbl_application')->where('id',$application_id)->first()->tp_id;
            $tp_email = DB::table('users')->where('id',$tp_id)->first()->email;
            $get_all_admin_users = DB::table('users')->where('role',1)->get()->pluck('email')->toArray();

            if(!empty($tp_id)){
            array_push($get_all_admin_users,$tp_email);
            
            foreach($get_all_admin_users as $email){
                $details['email'] = $email;
                $details['title'] = 'Traing Provider Created a New Application and Course Payment Successfully Done'; 
                $details['subject'] = 'New Application | RAVAP-'.$application_id; 
                $details['content'] = 'New Application has been created with RAVAP-'.$application_id; 
                dispatch(new SendEmailJob($details));
            }
        }
           
            /*send email end here*/ 
            DB::commit();
            return response()->json(['success' => true,'message' => 'Payment approved successfully.'], 200);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' => false,'message' => 'Failed approved payment.'], 500);
        }
       
    }
}