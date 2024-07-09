<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Eazypay;
use App\Models\TblApplicationPayment;
use DB, Auth;
use App\Models\Country;
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
        $reference_no= rand();
        //$reference_no= $app_id;
        $mobile=Auth::user()->mobile_no;
        $email=Auth::user()->email;
       // dd(count($paymentCheck));                        
        if(isset($checkpayment) && count($checkpayment)==0){
            DB::beginTransaction();
                $app_id = dDecrypt($id);
                $appdetails = DB::table('tbl_application')->where('id',$app_id)->first();
                $amount = $this->getPaymentFee('level-1', $getcountryCode->currency, $app_id);
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
            $appdetails = DB::table('tbl_application')->where('id',$app_id)->first();
            $amount = $this->getPaymentFee('level-1',$getcountryCode->currency,$app_id);
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
            $result= TblApplicationPayment::where('payment_reference_no',$request['ReferenceNo'])->update([
                'payment_mode' => $request['Payment_Mode'],
                'payment_transaction_no' =>$request['Unique_Ref_Number'],
                'pay_status' =>$request['TPS']??'N',
            ]);
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
