<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Eazypay;
use App\Models\TblApplicationPayment;
use DB, Auth;
use App\Models\Country;
use App\Models\TblApplicationCourses;
use App\Models\TblApplication; 

use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function makePayment($id=null){

        $app_id = dDecrypt($id);

        $checkpayment = DB::table('tbl_application_payment')->where([
                                ['payment_mode','mode'],
                                ['payment_transaction_no',1234567],
                                ['application_id',$app_id]])->get();

        $paymentCheck = DB::table('tbl_application_payment')->where([
                        ['pay_status','Y'],['application_id',$app_id]])->get();

        $getcountryCode = DB::table('countries')->where([['id',Auth::user()->country]])->first();
        $appdetails = DB::table('tbl_application')->where('id',$app_id)->first();
        $reference_no= rand().'-'.$app_id ;
        //$reference_no= $app_id;
        $mobile=Auth::user()->mobile_no;
        $email=Auth::user()->email;
       // dd(count($paymentCheck));       
       


       

        if(isset($checkpayment) && count($checkpayment)==0){
            DB::beginTransaction();
                $app_id = dDecrypt($id);
               
                $amount = $this->getPaymentFee('level-'.$appdetails->level_id, $getcountryCode->currency, $app_id);
                $item = new TblApplicationPayment;
                $item->level_id = $appdetails->level_id;
                $item->user_id = Auth::user()->id;
                $item->amount = $amount;
                $item->payment_date = date("d-m-Y");
                $item->payment_mode = 'mode';
                $item->payment_transaction_no = 1234567;
                $item->payment_reference_no = $reference_no;
                $item->payment_proof ='image.png';
                $item->currency = $getcountryCode->currency??'inr';
                $item->application_id = $app_id;
                $item->save();


            DB::commit();
            $eazypay_integration=new Eazypay();
            $payment_url=$eazypay_integration->getPaymentUrl($amount, $reference_no, $email, $mobile, $optionalField=null);
            header('Location: '.$payment_url);
            exit;
        }elseif(isset($checkpayment) && count($checkpayment)>0){
            //dd(count($checkpayment));  
            DB::beginTransaction();
            $app_id = dDecrypt($id);
          
            $amount = $this->getPaymentFee('level-'.$appdetails->level_id, $getcountryCode->currency, $app_id);
            $result= TblApplicationPayment::where('application_id',$app_id)->update([
                'level_id' => $appdetails->level_id,
                'user_id' => Auth::user()->id,
                'amount' =>$amount,
                'payment_date' =>date("d-m-Y"),
                'payment_mode' =>'mode',
                'payment_transaction_no' =>1234567,
                'payment_reference_no' => $reference_no,
                'payment_proof' =>'image.png',
                'currency' =>$getcountryCode->currency??'inr',
            ]);
            DB::commit();
            $eazypay_integration=new Eazypay();
            $payment_url=$eazypay_integration->getPaymentUrl($amount, $reference_no, $email, $mobile, $optionalField=null);
            header('Location: '.$payment_url);
            exit;
        }
        else{
            $checkpayment = DB::table('tbl_application_payment')->where([
                ['application_id',$app_id]])->first();
            $data = [
                'ReferenceNo' =>$checkpayment->payment_reference_no, 
                'tran_id' =>$checkpayment->payment_transaction_no, 
            ];
            return view('payment-response.success-response',['data'=>$data]);
        }
        
       // return $post_data;
    }
    public function paymentResponseSuccessFailer(Request $request){

       // dd('f');
        if(isset($request['Response_Code']) && $request['Response_Code'] =='E000' && $request['TPS'] == 'Y'){
            
            DB::beginTransaction();
            $result = TblApplicationPayment::where('payment_reference_no',$request['ReferenceNo'])->update([
                'payment_mode' => $request['Payment_Mode'],
                'payment_transaction_no' =>$request['Unique_Ref_Number'],
                'pay_status' =>$request['TPS']??'N',
            ]);
            $application_id = explode('-', $request['ReferenceNo'])[1];
            DB::table('tbl_application')->where('id',$application_id)->update(['payment_status'=>5]); //status 5 is for done payment by TP.
            DB::table('assessor_final_summary_reports')->where(['application_id'=>$application_id])->update(['second_payment_status' => 1]);
           $courses= DB::table('tbl_application_courses')->where('application_id',$application_id)->whereNull('deleted_at')->get(); //status 5 is for done payment by TP.
       
                foreach ($courses as $items) {
                    $ApplicationCourse = TblApplicationCourses::where('id',$items);
                    $ApplicationCourse->update(['payment_status' =>1]);
                }

                $appdetails = DB::table('tbl_application')->where('id',$application_id)->first();
                if(isset($appdetails->level_id) && $appdetails->level_id==2){
                    
                    $first_app_refid = TblApplication::where('id',$appdetails->id)->first();
                    $first_app_id = TblApplication::where('refid',$first_app_refid->prev_refid)->first();
                    
                    if(isset($first_app_id)){
                        DB::table('tbl_application')->where('id',$first_app_id->id)->update(['is_all_course_doc_verified'=>3]);
                    }
                  
                }else if(isset($appdetails->level_id) && $appdetails->level_id==3){
                    $first_app_refid = TblApplication::where('id',$appdetails->id)->first();
    
                    $ref_count = TblApplication::where('prev_refid',$first_app_refid->prev_refid)->count();
                    if($ref_count>1){
                        $first_app_id = TblApplication::where('prev_refid',$first_app_refid->prev_refid)->get();
                    }else{
                        $first_app_id = TblApplication::where('refid',$first_app_refid->prev_refid)->get();
                    }

                }
                

                     /*send notification*/ 
                    $acUrl = config('notification.accountantUrl.level1');
                    $notifiData = [];
                    $notifiData['user_type'] = "accountant";
                    $notifiData['sender_id'] = Auth::user()->id;
                    $notifiData['application_id'] =$application_id;
                    $notifiData['uhid'] = getUhid($application_id)[0];
                    $notifiData['level_id'] = getUhid($application_id)[1];
                    $notifiData['url'] = $acUrl.dEncrypt($application_id);
                    $notifiData['data'] = config('notification.accountant.appCreated');
                    sendNotification($notifiData);
                    /*end here*/ 
        

            DB::commit();
            $data = [
                'ReferenceNo' =>$request['ReferenceNo'], 
                'tran_id' =>$request['Unique_Ref_Number'], 
            ];
            return view('payment-response.success-response',['data'=>$data]);
        }else{
            $data = [
                'ReferenceNo' =>$request['ReferenceNo'], 
                'tran_id' =>$request['Unique_Ref_Number'], 
            ];
            return view('payment-response.error-response',['data'=>$data]);
        }

    }

    public function processPayment(){

        $eazypay_integration=new Eazypay();
        $reference_no= rand();
        $mobile=7982889567;
        $email='brijesh.mca12@gmail.com';
        $amount= 10;
        $payment_url=$eazypay_integration->getPaymentUrl($amount, $reference_no, $email, $mobile, $optionalField=null);
        $response = Http::post($payment_url); // Update with the correct Eazypay API endpoint
       // dd($response);
        // Handle the response from Eazypay
        if ($response->successful()) {
            return response()->json(['status' => 'success', 'message' => 'Payment processed successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Payment failed. Please try again.']);
        }
    }
    function getPaymentFee($level,$currency,$application_id){
        $get_payment_list = DB::table('tbl_fee_structure')->where(['currency_type'=>$currency,'level'=>$level])->get();
        
        $course = DB::table('tbl_application_courses')->where('application_id', $application_id)->get();
        
        if (Auth::user()->country == $this->get_india_id()) {
            if (count($course) == '0') {
              
                $total_amount = '0';
            } elseif (count($course) <= 5 && count($get_payment_list)>0) {
                
                $total_amount = (int)$get_payment_list[0]->courses_fee +((int)$get_payment_list[0]->courses_fee * 0.18);
    
            } elseif (count($course)>=5 && count($course) <= 10 && count($get_payment_list)>0) {
                
                $total_amount = (int)$get_payment_list[1]->courses_fee +((int)$get_payment_list[1]->courses_fee * 0.18);
            } elseif(count($course)>10 && count($get_payment_list)>0) {
                
                $total_amount = (int)$get_payment_list[2]->courses_fee +((int)$get_payment_list[2]->courses_fee * 0.18);
            }    
        } 

        return $total_amount;
    }
    function get_india_id()
    {
        $india = Country::where('name', 'India')->get('id')->first();
        return $india->id;
    }
}
