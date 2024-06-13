<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Eazypay;

class PaymentController extends Controller
{
    public function makePayment(){


        $post_data= array(
            'merchantid'=> Config('constant.eazypay.STORE_ID'),
            'submerchantid'=> Config('constant.eazypay.STORE_ID'),
            'amount'=> $amount??'00',
            'returnurl' => Config('constant.eazypay.POST_BACK_URL2'),
            'paymode' => 9,
            'Reference No' =>rand(),
        );
        $amount = 10;
        $reference_no= rand();
        $mobile=7982889567;
        $email='brijesh.mca12@gmail.com';

        $eazypay_integration=new Eazypay();
        $payment_url=$eazypay_integration->getPaymentUrl($amount, $reference_no, $email, $mobile, $optionalField=null);
        header('Location: '.$payment_url);
        exit;
       // return $post_data;
    }
    public function paymentResponse(){
        dd('payment-response');
        $status='success';
        if($status =='success'){
            return view('success-response');
        }else{
            return view('error-response');
        }
        

    }
}
