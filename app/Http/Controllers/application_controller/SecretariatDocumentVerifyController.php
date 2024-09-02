<?php

namespace App\Http\Controllers\application_controller;

use App\Http\Controllers\Controller;
use App\Models\TblApplicationCourseDoc; 
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\TblApplication;
use App\Models\TblApplicationPayment;
use App\Models\Chapter;
use App\Models\TblNCComments;
use Auth;
use URL;
use App\Jobs\SendEmailJob;

class SecretariatDocumentVerifyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function showCoursePdf($name)
    {
        $data = $name;
        return view('doc-view.file-view', ['data' => $data]);
    }

    public function secretariatVerfiyDocument($nc_type, $doc_sr_code, $doc_name, $application_id, $doc_unique_code, $application_course_id)
    {
        try {
            $tbl_nc_comments = DB::table('tbl_nc_comments_secretariat')->where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code])->latest('id')->first();

            $is_nc_exists = false;
            if ($nc_type == "view") {
                $is_nc_exists = true;
            }



            if (isset($tbl_nc_comments->nc_type)) {
                if ($tbl_nc_comments->nc_type == "NC1") {
                    $dropdown_arr = array(
                        "NC2" => "NC2",
                        "Accept" => "Accept",
                    );
                } else if ($tbl_nc_comments->nc_type == "NC2") {
                    $dropdown_arr = array(
                        "not_recommended" => "Needs Revision",
                        "Accept" => "Accept",
                    );
                } else if ($tbl_nc_comments->nc_type == "not_recommended") {
                    $dropdown_arr = array(
                        "Reject" => "Reject",
                        "Accept" => "Accept",
                    );
                } else if ($tbl_nc_comments->nc_type == "Request_For_Final_Approval") {
                    $dropdown_arr = array(
                        "Reject" => "Reject",
                        "Accept" => "Accept",
                    );
                } else {
                    $dropdown_arr = array(
                        "NC1" => "NC1",
                        "Accept" => "Accept",
                    );
                }
            } else {
                $dropdown_arr = array(
                    "NC1" => "NC1",
                    "Accept" => "Accept",
                );
            }
            if ($nc_type == "nr") {
                $nc_type = "not_recommended";
            }

            $nc_comments = DB::table('tbl_nc_comments_secretariat')->where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code, 'nc_type' => $nc_type])
                ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname')
                ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                ->first();

            $doc_path = URL::to("/documnet") . '/' . $doc_name;

            return view('admin-view.course-verify', [
                // 'doc_latest_record' => $doc_latest_record,
                'application_course_id' => $application_course_id,
                'doc_id' => $doc_sr_code,
                'doc_code' => $doc_unique_code,
                'doc_file_name' => $doc_name,
                'application_id' => $application_id,
                'doc_path' => $doc_path,
                'dropdown_arr' => $dropdown_arr ?? [],
                'is_nc_exists' => $is_nc_exists,
                'nc_comments' => $nc_comments,
            ]);
        } catch (Exception $e) {
            return back()->with('fail', 'Something went wrong');
        }
    }


    public function accountReceivedPayment(Request $request)
    {

        try {
            DB::beginTransaction();
            $application_id = dDecrypt($request->application_id);

            $is_exists = DB::table('tbl_application_payment')->where('application_id', $application_id)->where('status', 1)->whereNull('payment_ext')->where('pay_status','Y')->first();

            if ($is_exists) {
                return response()->json(['success' => false, 'message' => 'Payment already done.'], 200);
            }
            $get_application = DB::table('tbl_application')->where('id', $application_id)->first();
            if ($request->hasfile('payment_proof')) {
                $payment_proof = $request->file('payment_proof');
                $name = $payment_proof->getClientOriginalName();
                $filename = time() . $name;
                $payment_proof->move('documnet/', $filename);

                // $application_id = dDecrypt($request->application_id);

                if ($get_application->payment_status != 2) {
                    DB::table('tbl_application')->where('id', $application_id)->update(['payment_status' => 1]); //payment_status = 1 for payment received 2 for payment approved
                }


                $last_payment = DB::table('tbl_application_payment')->where('application_id', $application_id)->whereNull('payment_ext')->where('pay_status','Y')->latest('id')->first();
                if ($last_payment) {
                    DB::table('tbl_application_payment')->where(['application_id' => $application_id, 'id' => $last_payment->id,'payment_ext'=>null,'pay_status'=>'Y'])->update(['status' => 1, 'remark_by_account' => $request->payment_remark ?? '', 'payment_proof_by_account' => $filename, 'accountant_id' => Auth::user()->id]);
                } else {
                    DB::table('tbl_application_payment')->where(['application_id' => $application_id])->update(['status' => 1, 'remark_by_account' => $request->payment_remark ?? '', 'payment_proof_by_account' => $filename, 'accountant_id' => Auth::user()->id,'payment_ext'=>null,'pay_status'=>'Y']);
                }
            } else {

                // $application_id = dDecrypt($request->application_id);

                if ($get_application->payment_status != 2) {
                    DB::table('tbl_application')->where('id', $application_id)->update(['payment_status' => 1]); //payment_status = 1 for payment received 2 for payment approved
                }

                $last_payment = DB::table('tbl_application_payment')->where('application_id', $application_id)->whereNull('payment_ext')->where('pay_status','Y')->latest('id')->first();
                if ($last_payment) {
                    DB::table('tbl_application_payment')->where(['application_id' => $application_id, 'id' => $last_payment->id])->update(['status' => 1, 'remark_by_account' => $request->payment_remark ?? '', 'accountant_id' => Auth::user()->id,'payment_ext'=>null,'pay_status'=>'Y']);
                } else {
                    DB::table('tbl_application_payment')->where(['application_id' => $application_id])->update(['status' => 1, 'remark_by_account' => $request->payment_remark ?? '', 'accountant_id' => Auth::user()->id,'payment_status'=>null]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Payment received successfully.'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to make payment'], 200);
        }

    }


    public function accountApprovePayment(Request $request)
    {

        try {
            DB::beginTransaction();
            $application_id = dDecrypt($request->application_id);
            DB::table('tbl_application')->where('id', $application_id)->update(['payment_status' => 2]); //payment_status = 1 for payment received 2 for payment approved

            $last_pay = DB::table('tbl_application_payment')->where(['application_id' => $application_id])->whereNull('payment_ext')->where('pay_status','Y')->latest('id')->first();
            DB::table('tbl_application_payment')->where(['application_id' => $application_id, 'id' => $last_pay->id,'payment_ext'=>null,'pay_status'=>'Y'])->update(['status' => 2, 'approve_remark' => $request->final_payment_remark ?? '', 'accountant_id' => Auth::user()->id]);


            /**
             * Send Email to Accountant
             * */
            $tp_id = DB::table('tbl_application')->where('id', $application_id)->first()->tp_id;
            $tp_email = DB::table('users')->where('id', $tp_id)->first()->email;
            $account_email = DB::table('users')->where('id', Auth::user()->id)->first()->email;
            $get_all_admin_users = DB::table('users')->where('role', 1)->get()->pluck('email')->toArray();

            if (!empty($tp_id)) {
                foreach ($get_all_admin_users as $email) {
                    $title = "Application Payment Approved : RAVAP-" . $application_id;
                    $subject = "Application Payment Approved : RAVAP-" . $application_id;
                    $body = "Dear Team," . PHP_EOL . "

                We hope this message finds you well. We are pleased to inform you that your application payment has been successfully processed and approved. Thank you for your prompt and seamless transaction." . PHP_EOL . "

                Best regards," . PHP_EOL . "
                RAV Team";

                    $details['email'] = $email;
                    $details['title'] = $title;
                    $details['subject'] = $subject;
                    $details['body'] = $body;
                     if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
                }

                // tp mail
                $title = "Payment Approved for Your Application | RAVAP-" . $application_id;
                $subject = "Payment Approved for Your Application | RAVAP-" . $application_id;
                $body = "Dear " . Auth::user()->firstname . "," . PHP_EOL . "

                I hope this email finds you well. I am writing to inform you that the payment associated with your application for RAVAP-" . $application_id . " has been successfully approved by our accounting department." . PHP_EOL . "
                
                Here are the details of your payment:" . PHP_EOL . "
                
                Transaction ID: " . $last_pay->payment_transaction_no . " " . PHP_EOL . "
                Payment Amount: " . $last_pay->amount . " " . PHP_EOL . "
                Payment Date: " . date('d-m-Y', strtotime($last_pay->created_at)) . " " . PHP_EOL . "
                
                Best regards, " . PHP_EOL . "
                RAV Team";

                $details['email'] = $tp_email;
                $details['title'] = $title;
                $details['subject'] = $subject;
                $details['body'] = $body;
                 if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }

                // accountant mail
                $title = "Application Payment Approved  | RAVAP-" . $application_id;
                $subject = "Application Payment Approved  | RAVAP-" . $application_id;
                $body = "Dear " . Auth::user()->firstname . "," . PHP_EOL . "

                 We hope this message finds you well. We are pleased to inform you that your application payment has been successfully processed and approved. Thank you for your prompt and seamless transaction." . PHP_EOL . "
                 
                 Transaction ID: " . $last_pay->payment_transaction_no . " " . PHP_EOL . "
                 Payment Amount: " . $last_pay->amount . " " . PHP_EOL . "
                 Payment Date: " . date('d-m-Y', strtotime($last_pay->created_at)) . " " . PHP_EOL . "
                 
                 Best regards, " . PHP_EOL . "
                 RAV Team";

                $details['email'] = $account_email;
                $details['title'] = $title;
                $details['subject'] = $subject;
                $details['body'] = $body;
                 if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }

            }

            /*send email end here*/
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Payment approved successfully.'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed approved payment.'], 500);
        }

    }




    public function secretariatDocumentVerify(Request $request)
    {

        try {
            $nc_type="";
            $doc_comment = "";
            $redirect_to = URL::to("/admin/application-view") . '/' . dEncrypt($request->application_id);
            /*custom_url*/ 
            $get_application = DB::table('tbl_application')->where('id',$request->application_id)->first();
            if($get_application->level_id==1){
                $redirect_to = URL::to("/admin/application-view") . '/' . dEncrypt($request->application_id);
            }else if($get_application->level_id==2){
                $redirect_to = URL::to("/admin/application-view-level-2") . '/' . dEncrypt($request->application_id);
            }else{
                $redirect_to = URL::to("/admin/application-view-level-3") . '/' . dEncrypt($request->application_id);
            }
            /*end here*/ 
            if($request->nc_type=="Accept" && $request->comments==""){
               $nc_type="Accept";
               $doc_comment="Document has been approved";
            }else{
                $nc_type=$request->nc_type;
                $doc_comment=$request->comments;
            }
            DB::beginTransaction();
            $secretariat_id = Auth::user()->id;

            $data = [];
            $data['application_id'] = $request->application_id;
            $data['doc_sr_code'] = $request->doc_sr_code;
            $data['doc_unique_id'] = $request->doc_unique_id;
            $data['application_courses_id'] = $request->application_courses_id;
            $data['comments'] = $doc_comment;
            $data['nc_type'] = $nc_type;
            $data['secretariat_id'] = $secretariat_id;
            $data['doc_file_name'] = $request->doc_file_name;
            
            $nc_comment_status = "";
            $nc_raise = "";
            if ($request->nc_type == "Accept") {
                $nc_comment_status = 1;
                $nc_flag = 0;
                $nc_raise = "Accept";
            } else if ($request->nc_type == "NC1") {
                $nc_comment_status = 2;
                $nc_flag = 1;
                $nc_raise = "NC1";
            } else if ($request->nc_type == "NC2") {
                $nc_comment_status = 3;
                $nc_flag = 1;
                $nc_raise = "NC2";
            } else if ($request->nc_type == "Reject") {
                $nc_comment_status = 6;
                $nc_flag = 0;
                $nc_raise = "Reject";
            } else {
                $nc_comment_status = 4; //not recommended
                $nc_flag = 0;
                $nc_raise = "Request for final approval";
            }

            $create_nc_comments = DB::table('tbl_nc_comments_secretariat')->insert($data);


            // $tp_id = TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'assessor_type'=>$assessor_type,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id])->first();

            // $tp_email = DB::table('users')->where('id',$tp_id->tp_id)->first();


            // DB::table('tbl_course_wise_document')->where(['application_id'=> $request->application_id,'course_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'status'=>0])->update(['status'=>$nc_comment_status,'nc_flag'=>$nc_flag]);

            DB::table('tbl_course_wise_document')->where(['application_id' => $request->application_id, 'course_id' => $request->application_courses_id, 'doc_sr_code' => $request->doc_sr_code, 'doc_unique_id' => $request->doc_unique_id, 'status' => 0])->update(['status' => $nc_comment_status]);

            /*--------To Check All Course Doc Approved----------*/

            //  $this->checkApplicationIsReadyForNextLevel($request->application_id); //02/05/2024

            /*------end here------*/

            /*Create record for summary report*/
            // $data=[];
            // $data['application_id'] = $request->application_id;
            // $data['object_element_id'] = $request->doc_unique_id;
            // $data['application_course_id'] = $request->application_courses_id;
            // $data['doc_sr_code'] = $request->doc_sr_code;
            // $data['doc_unique_id'] = $request->doc_unique_id;

            // $data['date_of_assessement'] = $request->date_of_assessement??'N/A';
            // $data['secretariat_id'] = Auth::user()->id;
            // $data['assessor_type'] = $assessor_type;
            // $data['nc_raise'] = $nc_raise??'N/A';
            // $data['nc_raise_code'] = $nc_raise??'N/A';
            // $data['doc_path'] = $request->doc_file_name;
            // $data['capa_mark'] = $request->capa_mark??'N/A';
            // $data['doc_against_nc'] = $request->doc_against_nc??'N/A';
            // $data['doc_verify_remark'] = $request->remark??'N/A';
            // $create_summary_report = DB::table('assessor_summary_reports')->insert($data);
            /*end here*/

            //assessor email
            // $title="Notification -  ".$request->nc_type." | RAVAP-".$request->application_id;
            // $subject="Notification - ".$request->nc_type." | RAVAP-".$request->application_id;

            // $body = "Dear ,".$tp_email->firstname." ".PHP_EOL."
            // I hope this email finds you well. I am writing to inform you that a ".$request->nc_type." has been generated for RAVAP-".$request->application_id." in accordance with our quality management procedures.".PHP_EOL."

            // NC Details:".PHP_EOL."

            // Document Name: ".$request->doc_file_name."".PHP_EOL."
            // Document Sr. No.: ".$request->doc_sr_code."".PHP_EOL."
            // Date Created: ".date('d-m-Y')."".PHP_EOL."

            // NC Created By: ".Auth::user()->firstname."";

            //  $details['email'] = $tp_email->email;
            //  $details['title'] = $title; 
            //  $details['subject'] = $subject; 
            //  $details['body'] = $body; 
            //   if(env('MAIL_SEND')){
            //         dispatch(new SendEmailJob($details));
            //     }

            /*end here*/

            if ($create_nc_comments) {
                DB::commit();
                return response()->json(['success' => true, 'message' => $request->nc_type . ' comments created successfully', 'redirect_to' => $redirect_to], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to create ' . $request->nc_type . '  and documents'], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }



    public function secretariatUpdateNCFlag($application_id)
    {
        
        try {
            DB::beginTransaction();
            $secretariat_id = Auth::user()->id;
            $get_all_courses = DB::table('tbl_application_courses')->where('application_id',$application_id)->get();
            $get_course_docs = DB::table('tbl_course_wise_document')
                ->where(['application_id' => $application_id,'approve_status'=>1])
                ->whereIn('doc_sr_code',[config('constant.declaration.doc_sr_code'),config('constant.curiculum.doc_sr_code'),config('constant.details.doc_sr_code')])
                ->latest('id')->get();

                /*reject course and revert back before click on submit button*/
                DB::table('tbl_application_courses')->where('application_id',$application_id)->update(['is_revert'=>2]);
                
                $t = 0;
                $reuploadbtnToTPorAdmin = 0;
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
                        $nc_flag = 0;
                        $nc_comments=0;
                        $reuploadbtnToTPorAdmin=1;
                    } 
                    else if ($course_doc->status == 6) {
                        $nc_comment_status = 6;
                        $nc_flag = 0;
                        $nc_comments=0;
                    } 
                    else {
                        $nc_comment_status = 0; //not recommended
                        $nc_flag = 0;
                        $nc_comments=0;
                    }

               $is_update = DB::table('tbl_course_wise_document')
                ->where(['id' => $course_doc->id, 'application_id' => $application_id,'nc_show_status'=>0,'nc_flag'=>0])
                ->update(['nc_flag' => $nc_flag, 'secretariat_id' => $secretariat_id,'nc_show_status'=>$nc_comment_status,'is_revert'=>1]);

                DB::table('tbl_nc_comments_secretariat')
                ->where(['application_id' => $application_id, 'application_courses_id' => $course_doc->course_id,'nc_show_status'=>0])
                ->update(['nc_show_status' => $nc_comments]);

                /*if any courses rejected then hide the revert button according to courses*/ 
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
                
                if($get_application->level_id==1 || $get_application->level_id==2){
                if($t && !$is_all_accepted){
                      /*send notification*/ 
                      sendNotification($notifiData);
                      $notifiData['user_type'] = "tp";
                      $notifiData['receiver_id'] = $get_application->tp_id;
                      $notifiData['url'] = $tpUrl;
                      sendNotification($notifiData);
                        /*end here*/ 
                    createApplicationHistory($application_id,null,config('history.common.nc'),config('history.color.danger'));
                }
               
                if($is_all_accepted){
                    $notifiData['data'] = config('notification.admin.acceptCourseDoc');
                    $notifiData['user_type'] = "superadmin";
                    $notifiData['url'] = $sUrl.dEncrypt($application_id);
                    sendNotification($notifiData);
                    createApplicationHistory($application_id,null,config('history.admin.acceptCourseDoc'),config('history.color.success'));

                }
            }

            if($get_application->level_id==3){
                $notifiData['user_type'] = "tp";
                $notifiData['receiver_id'] = $get_application->tp_id;
                $notifiData['url'] = $tpUrl;
                sendNotification($notifiData);
                createApplicationHistory($application_id,null,config('history.common.nc'),config('history.color.danger'));
            }
            
            

            foreach($get_all_courses as $course){
                if($course_doc->status==1){
                    DB::table('tbl_course_wise_document')->where('course_id',$course->id)->update(['is_revert'=>1]);
                }
            }


            /*--------To Check All Course Doc Approved----------*/

            $check_all_doc_verified = $this->checkApplicationIsReadyForNextLevel($application_id);
            if($get_application->level_id==2){
                $check_all_doc_verifiedDocList = $this->secretariatUpdateNCFlagDocList($application_id);
            }else{
                $check_all_doc_verifiedDocList=null;
            }

            // this is for the applicaion status
            
           
            
           
            /*------end here------*/
            // DB::commit();
            
            if($get_application->level_id==1 || $get_application->level_id==3){
                
                if ($check_all_doc_verified == "all_verified") {
                    DB::table('tbl_application')->where('id',$application_id)->update(['is_secretariat_submit_btn_show'=>0]);
                    return back()->with('success', 'All course docs Accepted successfully.');
                }
                if ($check_all_doc_verified == "action_not_taken") {
                    return back()->with('fail', 'Please take any action on course doc.');
                }

                DB::table('tbl_application')->where('id',$application_id)->update(['status'=>4]);
                DB::commit();
                if($reuploadbtnToTPorAdmin){
                    return back()->with('success', 'Enabled Course Doc upload button to TP.');
                }
                return back()->with('success', 'Enabled Course Doc upload button to TP.');
                
            }else{
               
            // if (!$check_all_doc_verified && !$check_all_doc_verifiedDocList) {
            //     return back()->with('fail', 'First create NCs on courses doc');
            // }
            if ($check_all_doc_verified == "all_verified" && $check_all_doc_verifiedDocList=="all_verified") {
                DB::commit();
                DB::table('tbl_application')->where('id',$application_id)->update(['is_secretariat_submit_btn_show'=>0]);
                
                return back()->with('success', 'All course docs Accepted successfully.');
            }
            if ($check_all_doc_verified == "action_not_taken" && $check_all_doc_verifiedDocList=="action_not_taken") {
                return back()->with('fail', 'Please take any action on course doc.');

            }

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
            $notifiData = [];
            $notifiData['sender_id'] = Auth::user()->id;
            $notifiData['application_id'] = $application_id;
            $notifiData['uhid'] = getUhid( $application_id)[0];
            $notifiData['level_id'] = getUhid( $application_id)[1];
            $notifiData['data'] = config('notification.common.nc');
            $notifiData['user_type'] = "superadmin";
            $sUrl = config('notification.adminUrl.level1');
            $notifiData['url'] = $sUrl.dEncrypt($application_id);
            
            /*send notification*/ 
            sendNotification($notifiData);
            $notifiData['user_type'] = "tp";
            $notifiData['url'] = $tpUrl;
            sendNotification($notifiData);
            createApplicationHistory($application_id,null,config('history.common.nc'),config('history.color.danger'));

            /*end here*/ 
            DB::commit();
            DB::table('tbl_application')->where('id',$application_id)->update(['status'=>4]);
            return back()->with('success', 'Enabled Course Doc upload button to TP.');
            // return redirect($redirect_to);
         }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('fail', 'Something went wrong');
        }
    }


    public function secretariatUpdateNCFlagDocList($application_id)
    {
        
        try {
            
            DB::beginTransaction();
            $secretariat_id = Auth::user()->id;
            $get_course_docs = DB::table('tbl_application_course_doc')
            // ->where(['application_id' => $application_id,'approve_status'=>1])
            ->where(['application_id' => $application_id])
            ->latest('id')->get();
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
                        $nc_flag = 0;
                        $nc_comments=0;
                    } 
                    else if ($course_doc->status == 6) {
                        $nc_comment_status = 6;
                        $nc_flag = 0;
                        $nc_comments=0;
                    } 
                    else {
                        $nc_comment_status = 0; //not recommended
                        $nc_flag = 0;
                        $nc_comments=0;
                    }

                DB::table('tbl_application_course_doc')
                ->where(['id' => $course_doc->id, 'application_id' => $application_id,'nc_show_status'=>0])
                ->update(['nc_flag' => $nc_flag, 'assessor_id' => $secretariat_id,'nc_show_status'=>$nc_comment_status,'is_revert'=>1]);

                DB::table('tbl_nc_comments')
                ->where(['application_id' => $application_id, 'application_courses_id' => $course_doc->application_courses_id,'nc_show_status'=>0])
                ->update(['nc_show_status' => $nc_comments]);

                
            }

            /*--------To Check All 44 Doc Approved----------*/
            
            $check_all_doc_verified = $this->checkApplicationIsReadyForNextLevelDocList($application_id);
            /*------end here------*/
            DB::commit();
            return $check_all_doc_verified;
            // if (!$check_all_doc_verified) {
            //     return back()->with('fail', 'First create NCs on courses doc');
            // }
            // if ($check_all_doc_verified == "all_verified") {
            //     DB::table('tbl_application')->where('id',$application_id)->update(['is_secretariat_submit_btn_show'=>0]);
                
            //     return back()->with('success', 'All course docs Accepted successfully.');
            // }
            // if ($check_all_doc_verified == "action_not_taken") {
            //     return back()->with('fail', 'Please take any action on course doc.');
            // }
            // return back()->with('success', 'Enabled Course Doc upload button to TP.');
            // return redirect($redirect_to);

        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('fail', 'Something went wrong');
        }
    }


    public function rejectApplication($application_id)
    {
        
        $app_id = $application_id;
        try {
            DB::beginTransaction();

            /*TP show ncs*/
            DB::table('tbl_course_wise_document')
            ->where(['application_id' => $application_id])
            ->update(['approve_status'=>2,'is_revert'=>1]); 
            
            DB::table('tbl_application_courses')->where('application_id',$application_id)->update(['is_revert'=>1]);

            $all_docs = DB::table('tbl_course_wise_document')
            ->where(['application_id' => $application_id,'approve_status'=>2])
            ->whereNotIn('status',[2,3,4,6])
            ->get(); 
            

            foreach($all_docs as $doc){
                if($doc->status==0){
                    DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>5,'admin_nc_flag'=>2,'nc_show_status'=>5,'is_secretariat_reject'=>1]);
                }else{
                    DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>$doc->status,'admin_nc_flag'=>2,'nc_show_status'=>5,'is_secretariat_reject'=>1]);

                }
                // $data = [];
                //     $data['application_id'] = $doc->application_id;
                //     $data['application_courses_id'] = $doc->course_id;
                //     $data['secretariat_id'] = Auth::user()->id;
                //     $data['doc_sr_code'] = $doc->doc_sr_code;
                //     $data['doc_unique_id'] = $doc->doc_unique_id;
                //     $data['nc_type'] = 'Accept';
                //     $data['doc_file_name'] = $doc->doc_file_name;
                //     $data['comments'] = 'Document has been approved';
                //     $data['nc_show_status'] = 1;
                //     DB::table('tbl_nc_comments_secretariat')->insert($data);
            }
            /*end here*/


                $get_app = DB::table('tbl_application')->where('id',$application_id)->first();
           
                $url= config('notification.amdinUrl.level1');
                $url=$url.dEncrypt($application_id);
                $tpUrl = config('notification.tpUrl.level3');
                $tpUrl=$tpUrl.dEncrypt($application_id);
            

            $approve_app = DB::table('tbl_application')
                ->where(['id' => $app_id])
                ->update(['approve_status'=>4,'is_all_course_doc_verified'=>0]); //4 for rejected application by secretariat

                $notifiData = [];
                $notifiData['sender_id'] = Auth::user()->id;
                $notifiData['application_id'] = $app_id;
                $notifiData['uhid'] = getUhid( $app_id)[0];
                $notifiData['level_id'] = getUhid( $app_id)[1];
                $notifiData['data'] = config('notification.common.appRejected');
                $notifiData['user_type'] = "superadmin";
                $notifiData['url'] = $url;
          
                /*send notification*/ 
                sendNotification($notifiData);
                $notifiData['user_type'] = "tp";
                $notifiData['receiver_id'] = $get_app->tp_id;
                $notifiData['url'] = $tpUrl;
                sendNotification($notifiData);
                /*end here*/ 

                // this is for the applicaion status
                DB::table('tbl_application')->where('id',$application_id)->update(['status'=>8]);
                if($approve_app){
                    createApplicationHistory($app_id,null,config('history.secretariat.rejectApplication'),config('history.color.danger'));
                    DB::commit();
                    return true;
                }else{
                    DB::rollBack();
                    return false;
                }

        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }


    public function secretariatRejectCourse(Request $request)
    {

        try {
            DB::beginTransaction();
            $get_application = DB::table('tbl_application')->where('id', $request->application_id)->first();
            // this is for the level-2 and level-3
            if(isset($get_application) && ($get_application->level_id==2 || $get_application->level_id==3)){
                DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id])->update(['approve_status'=>2,'is_revert'=>1]);
            }

            $get_course_docs = DB::table('tbl_course_wise_document')
                ->where(['application_id' => $request->application_id,'course_id'=>$request->course_id])
                ->update(['approve_status'=>0,'nc_flag'=>0]);



                
                 DB::table('tbl_application_courses')
                ->where(['id'=>$request->course_id])
                ->update(['status'=>1,'sec_reject_remark'=>$request->reject_remark,'is_revert'=>0]);

                /*while rejecting course in level-3 we need to identify for rejection of the application in l-3*/ 
                    if($get_application->level_id==3){
                    $total_courses =  DB::table('tbl_application_courses')->where('application_id',$request->application_id)->count();
                    $total_rejected_courses =  DB::table('tbl_application_courses')->where('application_id',$request->application_id)->whereIn('status',[1,3])->count();
                    if($total_courses==$total_rejected_courses){
                        $is_app_rejected = $this->rejectApplication($request->application_id);
                        
                        if($is_app_rejected){
                            DB::commit();
                            return response()->json(['success' => true, 'message' => 'Application rejected successfully.'], 200);
                        }

                    }
                }
                /*end here*/ 

                
                if($get_course_docs){
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Course rejected by secretariat successfully.'], 200);
                }else{
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Failed to reject course'], 200);
                }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }



    public function sendAdminApproval($application_id)
    {

        $app_id = dDecrypt($application_id);
        try {
            DB::beginTransaction();
            $approve_app = DB::table('tbl_application')
                ->where(['id' => $app_id])
                ->update(['approve_status'=>2,'assign_day_for_verify'=>0,'assign_day_for_verify_date'=>null]);
                
                /*Make revert button hide according to course wise*/ 
                DB::table('tbl_application_courses')->where('application_id',$app_id)->update(['is_revert'=>1]);
                DB::table('tbl_course_wise_document')->where('application_id',$app_id)->update(['is_revert'=>1]);
                $notifiData = [];
                $notifiData['sender_id'] = Auth::user()->id;
                $notifiData['application_id'] = $app_id;
                $notifiData['uhid'] = getUhid( $app_id)[0];
                $notifiData['level_id'] = getUhid( $app_id)[1];
                $notifiData['data'] = config('notification.secretariat.sendApproval');
                $notifiData['user_type'] = "superadmin";
                $sUrl = config('notification.adminUrl.level1');
                $notifiData['url'] = $sUrl.dEncrypt($app_id);
          
                /*send notification*/ 
                sendNotification($notifiData);
                /*end here*/ 
                
                // this is for the applicaion status
                DB::table('tbl_application')->where('id',$app_id)->update(['status'=>6]);
                if($approve_app){
                    createApplicationHistory($app_id,null,config('history.secretariat.status'),config('history.color.warning'));
                    DB::commit();
                    return back()->with('success', 'Application send for approval to admin.');
                }else{
                    DB::rollBack();
                    return back()->with('fail', 'Failed to send the application for approval to admin');
                }

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('fail', 'Something went wrong');
        }
    }


    public function sendAdminApprovalDocList($application_id)
    {

        $app_id = dDecrypt($application_id);
        try {
            DB::beginTransaction();
            $approve_app = DB::table('tbl_application')
                ->where(['id' => $app_id])
                ->update(['doc_list_approve_status'=>2]);

                if($approve_app){
                    createApplicationHistory($app_id,null,config('history.secretariat.status'),config('history.color.warning'));
                    DB::commit();
                    return back()->with('success', 'Application send for approval to admin.');
                }else{
                    DB::rollBack();
                    return back()->with('fail', 'Failed to send the application for approval to admin');
                }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }
   
 
    public function checkApplicationIsReadyForNextLevel($application_id)
    {


        $all_courses_id = DB::table('tbl_application_courses')->where('application_id', $application_id)->pluck('id');


        $results = DB::table('tbl_course_wise_document')
            ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
            ->whereIn('course_id', $all_courses_id)
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
            ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag','approve_status']);


        foreach ($results as $key => $result) {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('course_id', $result->course_id)
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
            DB::table('tbl_application')->where('id', $application_id)->update(['is_all_course_doc_verified' => 1]);
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


    function revertCourseDocAction(Request $request){
        try{
            
            DB::beginTransaction();

            
            $get_course_doc = DB::table('tbl_course_wise_document')->where(['application_id'=>$request->application_id,'course_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name])->latest('id')->first();

            if($get_course_doc->is_revert==1){
                return response()->json(['success' => false, 'message' => 'Action reverted failed.'], 200);
            }
                if($get_course_doc->status==4){
                    $revertAction = DB::table('tbl_course_wise_document')->where(['application_id'=>$request->application_id,'course_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name,'is_revert'=>0])->update(['status'=>0,'admin_nc_flag'=>0]);
 
                }else{
                    $revertAction = DB::table('tbl_course_wise_document')->where(['application_id'=>$request->application_id,'course_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name,'is_revert'=>0])->update(['status'=>0]);
                }

                    /*Delete nc on course doc*/ 
                    $delete_= DB::table('tbl_nc_comments_secretariat')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$get_course_doc->doc_file_name])->delete();
                    
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

    function revertCourseDocListAction(Request $request){
        try{
            
            DB::beginTransaction();
            
            $get_course_doc = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name])->latest('id')->first();

                if($get_course_doc->is_revert==1){
                    return response()->json(['success' => false, 'message' => 'Action reverted failed.'], 200);
                }

                if($get_course_doc->status==4){
                    $revertAction = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name,'is_revert'=>0])->update(['status'=>0,'admin_nc_flag'=>0]);
 
                }else{
                    $revertAction = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name,'is_revert'=>0])->update(['status'=>0]);
                }

                    /*Delete nc on course doc*/ 
                    $delete_= DB::table('tbl_nc_comments')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$get_course_doc->doc_file_name])->delete();
                    
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



    /*secretariat nc's 44 documents*/ 
    public function applicationDocumentList($id, $course_id)
    {
        
        $tp_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $app_detail = TblApplication::where('id', $application_id)->first();
        $application_uhid = $app_detail->uhid ?? '';
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;

        $data = TblApplicationPayment::where('application_id', $application_id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();
        $is_onsite_assessor_assigned = DB::table('tbl_assessor_assign')->where(['application_id'=>$application_id,'assessor_type'=>'onsite'])->first();
        if($app_detail->level_id==3){
            
            if(count($data)>1 && !empty($is_onsite_assessor_assigned)){
                $assessor_type = 'onsite';
            }else{
                $assessor_type = 'desktop';
            }
            
        }else{
            $assessor_type = 'secretariat';
        }
        
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id' => $application_id,
            'application_courses_id' => $course_id,
            'assessor_type' => $assessor_type
        ])
            ->select('id', 'doc_unique_id', 'doc_file_name','onsite_doc_file_name', 'doc_sr_code', 'assessor_type', 'admin_nc_flag', 'status','is_revert','is_doc_show')
            ->get();
        $doc_uploaded_count = DB::table('tbl_nc_comments as asr')
            ->select("asr.application_id", "asr.application_courses_id")
            ->where('asr.assessor_type', $assessor_type)
            ->where(['application_id' => $application_id, 'application_courses_id' => $course_id])
            ->groupBy('asr.application_id', 'asr.application_courses_id')
            ->count();
        /*end here*/
        $is_doc_uploaded = false;
        if ($doc_uploaded_count >= 4) {
            $is_doc_uploaded = true;
        }
        
        $show_submit_btn_to_secretariat = $this->isShowSubmitBtnToSecretariat($application_id);
        $is_all_revert_action_done=$this->checkAllActionDoneOnRevert($application_id);
        $enable_disable_submit_btn = $this->checkSubmitButtonEnableOrDisable($application_id,$course_id);
        
        $chapters = Chapter::all();
        foreach ($chapters as $chapter) {
            $obj = new \stdClass;    
            $obj->chapters = $chapter;
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
                        'doc_sr_code' => $question->code
                    ])
                        ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                        ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                        ->whereIn('assessor_type', [$assessor_type, 'admin'])
                        ->where(function ($query) use ($assessor_type) {
                            $query->where('assessor_type', $assessor_type)
                                  ->orWhere('assessor_type', 'admin')
                                  ->where('final_status', $assessor_type);
                        })
                        ->get(),
                ];
            }
            $final_data[] = $obj;
        }
        // dd($final_data);
        $is_exists = DB::table('assessor_final_summary_reports')->where(['application_id' => $application_id, 'application_course_id' => $course_id])->first();
        if (!empty($is_exists)) {
            $is_final_submit = true;
        } else {
            $is_final_submit = false;
        }
        
        $application_details = TblApplication::find($application_id);
        return view('admin-view.secretariat.application-documents-list', compact('final_data', 'course_doc_uploaded', 'application_id', 'course_id', 'is_final_submit', 'is_doc_uploaded', 'application_uhid','application_details','show_submit_btn_to_secretariat','enable_disable_submit_btn','is_all_revert_action_done'));
    }

    public function applicationDocumentListDAOA($id, $course_id)
    {
        

        $level_id = DB::table('tbl_application')->where('id',dDecrypt($id))->first()->level_id;
        
        if($level_id!=3){
            return $this->applicationDocumentList($id,$course_id);
        }else{

        
        $tp_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;
        $data = TblApplicationPayment::where('application_id',$application_id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'assessor_type'=>'desktop'
        ])
        ->select('id','doc_unique_id','doc_file_name','doc_sr_code','admin_nc_flag','assessor_type','status','is_doc_show')
        ->get();
        $onsite_course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'assessor_type'=>'onsite'
        ])
        ->select('id','doc_unique_id','onsite_doc_file_name','doc_file_name','doc_sr_code','assessor_type','onsite_status','onsite_nc_status','admin_nc_flag','status','is_doc_show')
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
                            'doc_sr_code' => $question->code
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
        // dd($final_data);
        $applicationData = TblApplication::find($application_id);
        return view('admin-view.secretariat.application-document-list-l3', compact('final_data','onsite_course_doc_uploaded', 'course_doc_uploaded','application_id','course_id','applicationData'));
      }
    }
    public function secretariatVerfiyDocumentLevel2($nc_type, $doc_sr_code, $doc_name, $application_id, $doc_unique_code, $application_course_id)
    {
        try {
            $tbl_nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code, 'assessor_type' => 'secretariat','application_courses_id'=>$application_course_id])->latest('id')->first();
            $application_details = TblApplication::find($application_id);
            $is_nc_exists = false;
            $course_rejected=false;
            if ($nc_type == "view" && $application_details->level_id!=3) {
                $is_nc_exists = true;
            }
            $course = DB::table('tbl_application_courses')->where('id',$application_course_id)->whereIn('status',[1,3])->first();

            if(!empty($course)){
                $course_rejected=true;
                $is_nc_exists=false;
            }
            // dd($tbl_nc_comments->nc_type,$nc_type);
            if (isset($tbl_nc_comments->nc_type)) {
                if ($tbl_nc_comments->nc_type == "NC1") {
                    $dropdown_arr = array(
                        "NC2" => "NC2",
                        "Accept" => "Accept",
                    );
                } else if ($tbl_nc_comments->nc_type == "NC2") {
                    $dropdown_arr = array(
                        "not_recommended" => "Needs Revision",
                        "Accept" => "Accept",
                    );
                } else if ($tbl_nc_comments->nc_type == "not_recommended") {
                    $dropdown_arr = array(
                        "Reject" => "Reject",
                        "Accept" => "Accept",
                    );
                } else if ($tbl_nc_comments->nc_type == "Request_For_Final_Approval") {
                    $dropdown_arr = array(
                        "Reject" => "Reject",
                        "Accept" => "Accept",
                    );
                } else {
                    $dropdown_arr = array(
                        "NC1" => "NC1",
                        "Accept" => "Accept",
                    );
                }
            } else {
                $dropdown_arr = array(
                    "NC1" => "NC1",
                    "Accept" => "Accept",
                );
            }
            if ($nc_type == "nr") {
                $nc_type = "not_recommended";
            }
            $nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code, 'nc_type' => $nc_type,'application_courses_id'=> $application_course_id])
                ->whereIn('assessor_type', ['admin', 'secretariat'])
                ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                ->first();
            $doc_latest_record = TblApplicationCourseDoc::latest('id')
                ->where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code])
                ->first();
            // $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
            $doc_path = URL::to("/level") . '/' . $doc_name;
            return view('admin-view.secretariat.document-verify', [
                // 'doc_latest_record' => $doc_latest_record,
                'application_course_id' => $application_course_id,
                'doc_id' => $doc_sr_code,
                'doc_code' => $doc_unique_code,
                'doc_file_name' => $doc_name,
                'application_id' => $application_id,
                'doc_path' => $doc_path,
                'dropdown_arr' => $dropdown_arr ?? [],
                'is_nc_exists' => $is_nc_exists,
                'nc_comments' => $nc_comments,
                'is_course_rejected'=>$course_rejected
            ]);
        } catch (Exception $e) {

            return back()->with('fail', 'Something went wrong');
        }
    }
    
    public function secretariatDocumentVerifyLevel2(Request $request)
    {
        
        try {
            $redirect_to = URL::to("/secretariat/document-list") . '/' . dEncrypt($request->application_id) . '/' . dEncrypt($request->application_courses_id);
            DB::beginTransaction();
            $assessor_id = Auth::user()->id;
            $assessor_type = 'secretariat';
            if($request->nc_type=="Accept" && $request->comments==""){
                $nc_type="Accept";
                $doc_comment="Document has been approved";
             }else{
                 $nc_type=$request->nc_type;
                 $doc_comment=$request->comments;
             }
            /*end here*/
            $data = [];
            $data['application_id'] = $request->application_id;
            $data['doc_sr_code'] = $request->doc_sr_code;

            $data['doc_unique_id'] = $request->doc_unique_id;
            $data['application_courses_id'] = $request->application_courses_id;
            $data['assessor_type'] = $assessor_type;
            $data['comments'] = $doc_comment;
            $data['nc_type'] = $nc_type;
            $data['assessor_id'] = $assessor_id;
            $data['doc_file_name'] = $request->doc_file_name;
            $nc_comment_status = "";
            $nc_raise = "";
            if ($request->nc_type == "Accept") {
                $nc_comment_status = 1;
                $nc_flag = 0;
                $nc_raise = "Accept";
            } else if ($request->nc_type == "NC1") {
                $nc_comment_status = 2;
                $nc_flag = 1;
                $nc_raise = "NC1";
            } else if ($request->nc_type == "NC2") {
                $nc_comment_status = 3;
                $nc_flag = 1;
                $nc_raise = "NC2";
            } else if ($request->nc_type == "Reject") {
                $nc_comment_status = 6;
                $nc_flag = 0;
                $nc_raise = "Reject";
            } else {
                $nc_comment_status = 4; //not recommended
                $nc_flag = 0;
                $nc_raise = "Request for final approval";
            }
            $create_nc_comments = TblNCComments::insert($data);
            $tp_id = TblApplicationCourseDoc::where(['application_id' => $request->application_id, 'assessor_type' => $assessor_type, 'application_courses_id' => $request->application_courses_id, 'doc_sr_code' => $request->doc_sr_code, 'doc_unique_id' => $request->doc_unique_id])->first();
            $tp_email = DB::table('users')->where('id', $tp_id->tp_id)->first();
            //commented on 24/04/24
            TblApplicationCourseDoc::where(['application_id' => $request->application_id, 'assessor_type' => $assessor_type, 'application_courses_id' => $request->application_courses_id, 'doc_sr_code' => $request->doc_sr_code, 'doc_unique_id' => $request->doc_unique_id, 'status' => 0])->update(['status' => $nc_comment_status, 'nc_flag' => $nc_flag,'assessor_id'=>$assessor_id]);
            
            // TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'assessor_type'=>$assessor_type,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'status'=>0])->update(['status'=>$nc_comment_status]);
            /*Create record for summary report*/
            $data = [];
            $data['application_id'] = $request->application_id;
            $data['object_element_id'] = $request->doc_unique_id;
            $data['application_course_id'] = $request->application_courses_id;
            $data['doc_sr_code'] = $request->doc_sr_code;
            $data['doc_unique_id'] = $request->doc_unique_id;
            $data['date_of_assessement'] = $request->date_of_assessement ?? 'N/A';
            $data['assessor_id'] = Auth::user()->id;
            $data['assessor_type'] = $assessor_type;
            $data['nc_raise'] = $nc_raise ?? 'N/A';
            $data['nc_raise_code'] = $nc_raise ?? 'N/A';
            $data['doc_path'] = $request->doc_file_name;
            $data['capa_mark'] = $request->capa_mark ?? 'N/A';
            $data['doc_against_nc'] = $request->doc_against_nc ?? 'N/A';
            $data['doc_verify_remark'] = $request->remark ?? 'N/A';
            $create_summary_report = DB::table('assessor_summary_reports')->insert($data);
            /*end here*/
            //assessor email
            $title = "Notification -  " . $request->nc_type . " | RAVAP-" . $request->application_id;
            $subject = "Notification - " . $request->nc_type . " | RAVAP-" . $request->application_id;
            $body = "Dear ," . $tp_email->firstname . " " . PHP_EOL . "
        I hope this email finds you well. I am writing to inform you that a " . $request->nc_type . " has been generated for RAVAP-" . $request->application_id . " in accordance with our quality management procedures." . PHP_EOL . "
        NC Details:" . PHP_EOL . "
        Document Name: " . $request->doc_file_name . "" . PHP_EOL . "
        Document Sr. No.: " . $request->doc_sr_code . "" . PHP_EOL . "
        Date Created: " . date('d-m-Y') . "" . PHP_EOL . "
        NC Created By: " . Auth::user()->firstname . "";
            $details['email'] = $tp_email->email;
            $details['title'] = $title;
            $details['subject'] = $subject;
            $details['body'] = $body;
             if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
            /*end here*/
            if ($create_nc_comments) {
                DB::commit();
                return response()->json(['success' => true, 'message' => '' . $request->nc_type . ' comments created successfully', 'redirect_to' => $redirect_to], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to create ' . $request->nc_type . '  and documents'], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
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


  function revertCourseRejectAction(Request $request){
    try{
        
        
        DB::beginTransaction();
        $revertAction = DB::table('tbl_application_courses')->where(['id'=>$request->course_id])->update(['status'=>0,'is_revert'=>0,'sec_reject_remark'=>null]);
        
        DB::table('tbl_course_wise_document')->where(['application_id'=>$request->application_id,'course_id'=>$request->course_id])->update(['approve_status'=>1]);

        DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id])->update(['approve_status'=>0]);

        if($revertAction){
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Action reverted successfully.'], 200);
        }else{
            DB::rollBack();
            return response()->json(['success' =>false, 'message' => 'Failed to revert action.'], 200);
        }
    }catch(Exception $e){
        dd($e);
        DB::rollBack();
        return response()->json(['success' =>false, 'message' => 'Something went wrong!'], 200);
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

//   

public function isShowSubmitBtnToSecretariat($application_id)
{

    $results = DB::table('tbl_application_course_doc')
        ->select('application_id', 'application_courses_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id')
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
            $results[$key]->approve_status = $additionalField->approve_status;
        }
    }

    
    $flag = 0;

    foreach ($results as $result) {
        
        // if (($result->status == 1 && $result->approve_status==1) || ($result->status == 4 && $result->admin_nc_flag == 1)) {

        if (($result->status == 1) || ($result->status == 4 && $result->admin_nc_flag == 1)) {
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

public function checkSubmitButtonEnableOrDisable($application_id,$application_courses_id)
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
            $results[$key]->approve_status = $additionalField->approve_status;
        }
    }

    // dd($results);
    
    $flag = 0;

    foreach ($results as $result) {

        if (($result->status!=0)) {
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
        ->select('application_id', 'application_courses_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id')
        // ->where('application_courses_id', $application_courses_id)
        ->where('application_id', $application_id)
        ->whereIn('approve_status',[0,1])
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
            ->whereIn('approve_status',[0,1])
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


public function uploadMoM(Request $request)
{
   try{
    
    DB::beginTransaction();
    if ($request->hasfile('mom')) {
        $file = $request->file('mom');
        $name = $file->getClientOriginalName();
        $filename = time() . $name;
        $file->move('level/', $filename);
    }
    $uploaded = DB::table('tbl_application')->where('id',$request->application_id)->update(['mom_file_name'=>$filename]);
    // $data = [];
    // $data['application_id']=$request->application_id;
    // $data['doc_file_name']=$filename;
    // $data['user_id']=Auth::user()->id;
    // $uploaded=DB::table('tbl_mom')->insert($data);
    
    if($uploaded){
    DB::commit();
    return response()->json(['success' => true,'message' =>'MoM uploaded successfully'],200);
    }else{
        return response()->json(['success' => false,'message' =>'Failed to upload MoM'],200);
    }
   } 
   catch(Exception $e){
    return response()->json(['success' => false,'message' =>'Someting went wrong'],500);
   }
 }


 public function isAllCourseDocAccepted($application_id)
 {


     $all_courses_id = DB::table('tbl_application_courses')->where('application_id', $application_id)->pluck('id');


     $results = DB::table('tbl_course_wise_document')
         ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
         ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
         ->whereIn('course_id', $all_courses_id)
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
         ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag','approve_status']);


     foreach ($results as $key => $result) {
         $additionalField = $additionalFields->where('application_id', $result->application_id)
             ->where('course_id', $result->course_id)
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



 
}