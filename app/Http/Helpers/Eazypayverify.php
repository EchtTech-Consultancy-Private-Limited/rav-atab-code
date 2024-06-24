<?php
namespace App\Http\Helpers;

class Eazypay
{
    public $merchant_id;
    public $encryption_key;
    public $sub_merchant_id;
    public $reference_no;
    public $paymode;
    public $return_url;

    const DEFAULT_BASE_URL = 'https://eazypayuat.icicibank.com/EazyPG?';

    public function __construct()
    {
        $this->merchant_id              =    139762;
        $this->encryption_key           =    1300011197605020;
        $this->sub_merchant_id          =    45;
        $this->paymode                  =    9;
        $this->return_url               =    env('APP_URL').'paymentresponse';
    }
    public function getPaymentUrl($amount, $reference_no, $email, $mobile, $optionalField='')
    {
        $opt_fields = "";
        $man_fields = $reference_no.'|'.$this->sub_merchant_id.'|'.$amount.'|'.'aaa'.'|'.$email.'|'.$mobile;

        $e_sub_mer_id = $this->aes128Encrypt($this->sub_merchant_id, $this->encryption_key);
        $e_ref_no = $this->aes128Encrypt($reference_no, $this->encryption_key);
        $e_amt = $this->aes128Encrypt($amount, $this->encryption_key);
        $e_return_url = $this->aes128Encrypt($this->return_url, $this->encryption_key);
        $e_paymode = $this->aes128Encrypt($this->paymode, $this->encryption_key);
        $mandatoryField = $this->aes128Encrypt($man_fields, $this->encryption_key);
        $e_opt_fields = $this->aes128Encrypt($opt_fields, $this->encryption_key);

        $paymentUrl = $this->generatePaymentUrl($mandatoryField, $optionalField,$e_return_url,$e_ref_no,$e_sub_mer_id,$e_amt,$e_paymode);
      
        return $paymentUrl;
    }

    function aes128Encrypt($plaintext,$key){
        $cipher = "aes-128-ecb";
        in_array($cipher, openssl_get_cipher_methods(true));
        {
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes(1);
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, "");
        return $ciphertext;
        }
    }

}