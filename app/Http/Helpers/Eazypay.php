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
        // $mandatoryField   =    $this->aes128Encrypt($reference_no, $amount, $email, $mobile);
        // $optionalField    =    $this->aes128Encrypt($optionalField,$this->encryption_key );
        // $amount           =    $this->aes128Encrypt($amount,$this->encryption_key );
        // $reference_no     =    $this->aes128Encrypt($reference_no,$this->encryption_key );
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
       // $paymentUrl = $this->generatePaymentUrl($mandatoryField, $optionalField, $amount, $reference_no);
        //dd($paymentUrl);
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

    protected function generatePaymentUrl($mandatoryField, $optionalField, $e_return_url, $e_ref_no, $e_sub_mer_id, $e_amt, $e_paymode)
    {
        $encryptedUrl = self::DEFAULT_BASE_URL."merchantid=".$this->merchant_id.
            "&mandatory fields=".$mandatoryField."&optional fields=".$optionalField.
            "&returnurl=".$e_return_url."&Reference No=".$e_ref_no.
            "&submerchantid=".$e_sub_mer_id."&transaction amount=".
            $e_amt."&paymode=".$e_paymode;

        $encryptedUrlplain = self::DEFAULT_BASE_URL."merchantid=".$this->merchant_id.
            "&mandatory fields=456789|45|10|aaa|brijesh.mca12@gmail.com|7982889567&optional fields=".$optionalField.
            "&returnurl=".$this->return_url."&Reference No=456789&submerchantid=".$this->sub_merchant_id."&transaction amount=10&paymode=".$this->paymode;

        return $encryptedUrl;
    }

    protected function getMandatoryField($reference_no, $amount,$email,$mobile)
    {
        return $this->getEncryptValue($reference_no.'|'.$this->sub_merchant_id.'|'.$amount.'|'.'aaa'.'|'.$email.'|'.$mobile);
    }

    // optional field must be seperated with | eg. (20|20|20|20)
    protected function getOptionalField($optionalField=null)
    {
        if (!is_null($optionalField)) {
            return $this->getEncryptValue($optionalField);
        }
        return null;
    }

    protected function getAmount($amount)
    {
        return $this->getEncryptValue($amount);
    }

    protected function getReturnUrl()
    {
        return $this->getEncryptValue($this->return_url);
    }

    protected function getReferenceNo($reference_no)
    {
        return $this->getEncryptValue($reference_no);
    }

    protected function getSubMerchantId()
    {
        return $this->getEncryptValue($this->sub_merchant_id);
    }

    protected function getPaymode()
    {
        return $this->getEncryptValue($this->paymode);
    }

    // use @ to avoid php warning php 

    protected function getEncryptValue($data)
    {
        // Generate an initialization vector
        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 128 encryption in ecb mode using our encryption key and initialization vector.
      $encrypted = openssl_encrypt($data, 'aes-128-ecb', $this->encryption_key, OPENSSL_RAW_DATA);
      // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
      return base64_encode($encrypted);
    }
}