<?php

namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use URL;
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

    public function momPdf($doc_name,$app_id)
    {
        
        $is_form_show = request()->query('secret');
        
        $application_details = DB::table('tbl_application')->where('id',dDecrypt($app_id))->first();
        $data = $doc_name;
        return view('doc-view.mom-file-view', ['data' => $data,'application_details'=>$application_details,'is_form_show'=>$is_form_show]);


        // $mom = DB::table('tbl_mom')->where('application_id',dDecrypt($app_id))->latest('id')->first();
        // $app_approve_status = DB::table('tbl_application')->where('id',dDecrypt($app_id))->first()->approve_status;
        // $data = $doc_name;
        // return view('doc-view.mom-file-view', ['data' => $data,'application_id'=>$app_id,'mom'=>$mom,'app_approve_status'=>$app_approve_status]);
    }
    public function secretariatVerfiyDocument($nc_type,$doc_sr_code, $doc_name, $application_id, $doc_unique_code,$application_course_id)
    {
       
        try{
            $tbl_nc_comments = DB::table('tbl_nc_comments_secretariat')->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code,'application_courses_id'=>$application_course_id])->latest('id')->first();
            
            $is_course_rejected = DB::table('tbl_application_courses')
            ->where(['id'=>$application_course_id])
            ->whereIn('status',[1,3])
            ->first();
            $is_nc_exists = false;
            if ($nc_type == "view" && empty($is_course_rejected)) {
                $is_nc_exists = true;
            }

            

        if(isset($tbl_nc_comments->nc_type)){
            if($tbl_nc_comments->nc_type=="NC1"){
                $dropdown_arr = array(
                            "NC2"=>"NC2",
                            "Accept"=>"Accept",
                        );
             }else if($tbl_nc_comments->nc_type=="NC2"){
                $dropdown_arr = array(
                            "not_recommended"=>"Not Recommended",
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
        if($nc_type=="nr"){
            $nc_type="not_recommended";
        }

        $nc_comments = DB::table('tbl_nc_comments_secretariat')->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code,'nc_type'=>$nc_type])
            ->select('tbl_nc_comments_secretariat.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments_secretariat.secretariat_id','=','users.id')
            ->first();

        $doc_path = URL::to("/documnet").'/'.$doc_name;
         
        return view('admin-view.course-verify', [
            // 'doc_latest_record' => $doc_latest_record,
            'application_course_id'=>$application_course_id,
            'doc_id' => $doc_sr_code,
            'doc_code' => $doc_unique_code,
            'doc_file_name' => $doc_name,
            'application_id' => $application_id,
            'doc_path' => $doc_path,
            'dropdown_arr'=>$dropdown_arr??[],
            'is_nc_exists'=>$is_nc_exists,
            'nc_comments'=>$nc_comments,
            'is_course_rejected'=>$is_course_rejected
        ]);
    }catch(Exception $e){
        return back()->with('fail','Something went wrong');
    }
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
            $get_application = DB::table('tbl_application')->where('id',$application_id)->first();
            if ($request->hasfile('payment_proof')) {
                $payment_proof = $request->file('payment_proof');
                $name = $payment_proof->getClientOriginalName();
                $filename = time() . $name;
                $payment_proof->move('documnet/', $filename);

                // $application_id = dDecrypt($request->application_id);
                
                if($get_application->payment_status!=2){
                    DB::table('tbl_application')->where('id',$application_id)->update(['payment_status'=>1]); //payment_status = 1 for payment received 2 for payment approved
                }
                
    
                $last_payment = DB::table('tbl_application_payment')->where('application_id',$application_id)->latest('id')->first();
                if($last_payment){
                    DB::table('tbl_application_payment')->where(['application_id'=>$application_id,'id'=>$last_payment->id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','payment_proof_by_account'=>$filename,'accountant_id'=>Auth::user()->id]);
                }else{
                    DB::table('tbl_application_payment')->where(['application_id'=>$application_id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','payment_proof_by_account'=>$filename,'accountant_id'=>Auth::user()->id]);
                }
            }else{

                // $application_id = dDecrypt($request->application_id);

                if($get_application->payment_status!=2){
                    DB::table('tbl_application')->where('id',$application_id)->update(['payment_status'=>1]); //payment_status = 1 for payment received 2 for payment approved
                }
    
                $last_payment = DB::table('tbl_application_payment')->where('application_id',$application_id)->latest('id')->first();
                if($last_payment){
                    DB::table('tbl_application_payment')->where(['application_id'=>$application_id,'id'=>$last_payment->id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','accountant_id'=>Auth::user()->id]);
                }else{
                    DB::table('tbl_application_payment')->where(['application_id'=>$application_id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','accountant_id'=>Auth::user()->id]);
                }
            }
            createApplicationHistory($application_id,null,config('history.accountant.status'),config('history.color.warning'));
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
            DB::table('tbl_application_payment')->where(['application_id'=>$application_id,'id'=>$last_pay->id])->update(['status'=>2,'approve_remark'=>$request->final_payment_remark??'','accountant_id'=>Auth::user()->id]);


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
           
        createApplicationHistory($application_id,null,config('history.accountant.status2'),config('history.color.warning'));
            /*send email end here*/ 
            DB::commit();
            return response()->json(['success' => true,'message' => 'Payment approved successfully.'], 200);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' => false,'message' => 'Failed approved payment.'], 500);
        }
       
    }


    public function accountReceivedPaymentAdditional(Request $request)
    {

        try{
             DB::beginTransaction();
             $application_id = dDecrypt($request->application_id);
             
            $is_exists = DB::table('tbl_additional_fee')->where('application_id',$application_id)->where('status',1)->first();
            
            if($is_exists){
                return response()->json(['success' =>false,'message'=>'Payment already done.'], 200);
            }
            
            if ($request->hasfile('payment_proof')) {
                $payment_proof = $request->file('payment_proof');
                $name = $payment_proof->getClientOriginalName();
                $filename = time() . $name;
                $payment_proof->move('documnet/', $filename);

                // $application_id = dDecrypt($request->application_id);
    
                $last_payment = DB::table('tbl_additional_fee')->where('application_id',$application_id)->latest('id')->first();
                if($last_payment){
                    DB::table('tbl_additional_fee')->where(['application_id'=>$application_id,'id'=>$last_payment->id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','payment_proof_by_account'=>$filename,'accountant_id'=>Auth::user()->id]);
                }else{
                    DB::table('tbl_additional_fee')->where(['application_id'=>$application_id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','payment_proof_by_account'=>$filename,'accountant_id'=>Auth::user()->id]);
                }
            }else{

                // $application_id = dDecrypt($request->application_id);

    
                $last_payment = DB::table('tbl_additional_fee')->where('application_id',$application_id)->latest('id')->first();
                if($last_payment){
                    DB::table('tbl_additional_fee')->where(['application_id'=>$application_id,'id'=>$last_payment->id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','accountant_id'=>Auth::user()->id]);
                }else{
                    DB::table('tbl_additional_fee')->where(['application_id'=>$application_id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','accountant_id'=>Auth::user()->id]);
                }
            }
            createApplicationHistory($application_id,null,config('history.accountant.status'),config('history.color.warning'));
            DB::commit();
            return response()->json(['success' => true,'message' => 'Payment received successfully.'], 200);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' =>false,'message'=>'Failed to make payment'], 200);
        }
       
    }


    public function accountApprovePaymentAdditional(Request $request)
    {

        try{
            DB::beginTransaction();
            $application_id = dDecrypt($request->application_id);
            
            $last_pay=DB::table('tbl_additional_fee')->where(['application_id'=>$application_id])->latest('id')->first();
            DB::table('tbl_additional_fee')->where(['application_id'=>$application_id,'id'=>$last_pay->id])->update(['status'=>2,'approve_remark'=>$request->final_payment_remark??'','accountant_id'=>Auth::user()->id]);

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
           
        createApplicationHistory($application_id,null,config('history.accountant.status2'),config('history.color.warning'));
            /*send email end here*/ 
            DB::commit();
            return response()->json(['success' => true,'message' => 'Payment approved successfully.'], 200);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' => false,'message' => 'Failed approved payment.'], 500);
        }
       
    }


    public function accountReceivedAdditionalPayment(Request $request)
    {
        
        try{
             DB::beginTransaction();
             $application_id = dDecrypt($request->application_id);
             
            $is_exists = DB::table('tbl_additional_fee')->where('application_id',$application_id)->where('status',1)->first();
            
            if($is_exists){
                return response()->json(['success' =>false,'message'=>'Payment already done.'], 200);
            }
            $get_application = DB::table('tbl_application')->where('id',$application_id)->first();
            if ($request->hasfile('payment_proof')) {
                $payment_proof = $request->file('payment_proof');
                $name = $payment_proof->getClientOriginalName();
                $filename = time() . $name;
                $payment_proof->move('documnet/', $filename);
                // $application_id = dDecrypt($request->application_id);
                
                if($get_application->payment_status!=2){
                    DB::table('tbl_application')->where('id',$application_id)->update(['payment_status'=>1]); //payment_status = 1 for payment received 2 for payment approved
                }
                
    
                $last_payment = DB::table('tbl_additional_fee')->where('application_id',$application_id)->latest('id')->first();
                if($last_payment){
                    DB::table('tbl_additional_fee')->where(['application_id'=>$application_id,'id'=>$last_payment->id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','payment_proof_by_account'=>$filename,'accountant_id'=>Auth::user()->id]);
                }else{
                    DB::table('tbl_additional_fee')->where(['application_id'=>$application_id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','payment_proof_by_account'=>$filename,'accountant_id'=>Auth::user()->id]);
                }
            }else{
                // $application_id = dDecrypt($request->application_id);
                if($get_application->payment_status!=2){
                    DB::table('tbl_application')->where('id',$application_id)->update(['payment_status'=>1]); //payment_status = 1 for payment received 2 for payment approved
                }
    
                $last_payment = DB::table('tbl_additional_fee')->where('application_id',$application_id)->latest('id')->first();
                if($last_payment){
                    DB::table('tbl_additional_fee')->where(['application_id'=>$application_id,'id'=>$last_payment->id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','accountant_id'=>Auth::user()->id]);
                }else{
                    DB::table('tbl_additional_fee')->where(['application_id'=>$application_id])->update(['status'=>1,'remark_by_account'=>$request->payment_remark??'','accountant_id'=>Auth::user()->id]);
                }
            }
            // createApplicationHistory($application_id,null,config('history.accountant.status'),config('history.color.warning'));
            DB::commit();
            return response()->json(['success' => true,'message' => 'Payment received successfully.'], 200);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' =>false,'message'=>'Failed to make payment'], 200);
        }
       
    }


    public function accountApproveAdditionalPayment(Request $request)
    {
        
        try{
            DB::beginTransaction();
            $application_id = dDecrypt($request->application_id);
            DB::table('tbl_application')->where('id',$application_id)->update(['payment_status'=>2]); //payment_status = 1 for payment received 2 for payment approved
            
            $last_pay=DB::table('tbl_additional_fee')->where(['application_id'=>$application_id])->latest('id')->first();
            DB::table('tbl_additional_fee')->where(['application_id'=>$application_id,'id'=>$last_pay->id])->update(['status'=>2,'approve_remark'=>$request->final_payment_remark??'','accountant_id'=>Auth::user()->id]);


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
           
        // createApplicationHistory($application_id,null,config('history.accountant.status2'),config('history.color.warning'));
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