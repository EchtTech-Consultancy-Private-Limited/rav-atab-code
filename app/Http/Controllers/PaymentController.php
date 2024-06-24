<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Eazypay;
use App\Models\TblApplicationPayment;
use DB, Auth;
use App\Models\Country;

class PaymentController extends Controller
{
    public function makePayment($id){


        DB::beginTransaction();
        
        $app_id = dDecrypt($id);
        $appdetails = DB::table('tbl_application')->where('id',$app_id)->first();
        $amount = $this->getPaymentFee('level-1',"inr",$app_id);

        $reference_no= rand();
        $mobile=Auth::user()->mobile_no;
        $email=Auth::user()->email;
        $item = new TblApplicationPayment;
        $item->level_id = $appdetails->level_id;
        $item->user_id = Auth::user()->id;
        $item->amount = $amount;
        $item->payment_date = date("d-m-Y");
        $item->payment_mode = 'mode';
        $item->payment_transaction_no = '1234567';
        $item->payment_reference_no = $reference_no;
        $item->payment_proof ='png.image';
        // $item->currency = $request->currency;
        $item->application_id = $app_id;
        // if ($request->hasfile('payment_details_file')) {
        //     $img = $request->file('payment_details_file');
        //     $name = $img->getClientOriginalName();
        //     $filename = time() . $name;
        //     $img->move('uploads/', $filename);
        //     $item->payment_proof = $filename;
        // }
        $item->save();
        DB::commit();
        $eazypay_integration=new Eazypay();
        
        $payment_url=$eazypay_integration->getPaymentUrl($amount, $reference_no, $email, $mobile, $optionalField=null);
      //dd($payment_url);
        header('Location: '.$payment_url);
        exit;
       // return $post_data;
    }
    public function paymentResponseSuccessFailer(Request $request){

        //dd($request['Response_Code']);
        if(isset($request['Response_Code']) && $request['Response_Code'] =='E000'){
            DB::beginTransaction();
            $result= TblApplicationPayment::where('payment_reference_no',$request['ReferenceNo'])->update([
                'payment_mode' => $request['Payment_Mode'],
                'payment_transaction_no' =>$request['Unique_Ref_Number'],
            ]);
            DB::commit();

            return view('payment-response.success-response');
        }else{
            return view('payment-response.error-response');
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
