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
            
            $last_pay=DB::table('tbl_application_payment')->where(['application_id'=>$application_id])->latest('id')->first();
            DB::table('tbl_application_payment')->where(['application_id'=>$application_id])->update(['status'=>2,'approve_remark'=>$request->final_payment_remark??'','accountant_id'=>Auth::user()->id]);


             /**
             * Send Email to Accountant
             * */ 
            $tp_id = DB::table('tbl_application')->where('id',$application_id)->first()->tp_id;
            $tp_email = DB::table('users')->where('id',$tp_id)->first()->email;
            $account_email = DB::table('users')->where('id',Auth::user()->id)->first()->email;
            $get_all_admin_users = DB::table('users')->where('role',1)->get()->pluck('email')->toArray();

            if(!empty($tp_id)){
            foreach($get_all_admin_users as $email){
                $title="Application Payment Approved : RAVAP-".$application_id;
                $subject="Application Payment Approved : RAVAP-".$application_id;
                $body="Dear Team,".PHP_EOL."

                We hope this message finds you well. We are pleased to inform you that your application payment has been successfully processed and approved. Thank you for your prompt and seamless transaction.".PHP_EOL."

                Best regards,".PHP_EOL."
                RAV Team";

                $details['email'] = $email;
                $details['title'] = $title; 
                $details['subject'] = $subject; 
                $details['body'] = $body; 
                dispatch(new SendEmailJob($details));
            }

            // tp mail
                $title="Payment Approved for Your Application | RAVAP-".$application_id;
                $subject="Payment Approved for Your Application | RAVAP-".$application_id;
                $body="Dear ".Auth::user()->firstname.",".PHP_EOL."

                I hope this email finds you well. I am writing to inform you that the payment associated with your application for RAVAP-".$application_id." has been successfully approved by our accounting department.".PHP_EOL."
                
                Here are the details of your payment:".PHP_EOL."
                
                Transaction ID: ".$last_pay->payment_transaction_no." ".PHP_EOL."
                Payment Amount: ".$last_pay->amount." ".PHP_EOL."
                Payment Date: ".date('d-m-Y',strtotime($last_pay->created_at))." ".PHP_EOL."
                
                Best regards, ".PHP_EOL."
                RAV Team";

                $details['email'] = $tp_email;
                $details['title'] = $title; 
                $details['subject'] = $subject; 
                $details['body'] = $body; 
                dispatch(new SendEmailJob($details));

                 // accountant mail
                 $title="Application Payment Approved  | RAVAP-".$application_id;
                 $subject="Application Payment Approved  | RAVAP-".$application_id;
                 $body="Dear ".Auth::user()->firstname.",".PHP_EOL."

                 We hope this message finds you well. We are pleased to inform you that your application payment has been successfully processed and approved. Thank you for your prompt and seamless transaction.".PHP_EOL."
                 
                 Transaction ID: ".$last_pay->payment_transaction_no." ".PHP_EOL."
                 Payment Amount: ".$last_pay->amount." ".PHP_EOL."
                 Payment Date: ".date('d-m-Y',strtotime($last_pay->created_at))." ".PHP_EOL."
                 
                 Best regards, ".PHP_EOL."
                 RAV Team";
 
                 $details['email'] = $account_email;
                 $details['title'] = $title; 
                 $details['subject'] = $subject; 
                 $details['body'] = $body; 
                 dispatch(new SendEmailJob($details));

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