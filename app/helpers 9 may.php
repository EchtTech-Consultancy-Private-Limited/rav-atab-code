<?php
use Illuminate\Support\Facades\DB;
function encode5t($str)
{
  for($i=0; $i<5;$i++) //increase the level
  {
$str=strrev(base64_encode($str)); //apply base64 first and then reverse the string
  }
  return $str;
}


//function to decrypt the string
function decode5t($str)
{
  for($i=0; $i<5;$i++)
  {
    $str=base64_decode(strrev($str));
  }
  return $str;
}


//id decript & encrypt

 function dEncrypt($value){

      $newkey='AX345678ZX98765Y';

      $newEncrypter = new \Illuminate\Encryption\Encrypter($newkey,'AES-128-CBC');

      return $newEncrypter->encrypt($value);

   }

 function dDecrypt($value){

      $newkey='AX345678ZX98765Y';

      $newEncrypter = new \Illuminate\Encryption\Encrypter($newkey,'AES-128-CBC');

      return $newEncrypter->decrypt($value);

   }


   function getFaqCategory(){

    $data=['1'=>'Level 1 FAQs','2'=>'Level 2 FAQs','3'=>'Level 3 FAQs','4'=>'Level 4 FAQs','5'=>'General FAQs'];

    return $data;

 }

 function application_submission_date($application_id,$asessor_id)
 {
    $applications=DB::table('application_payments')->where('application_id','=',$application_id)->first();
    
    //$applications = "Test";
    $application_created_at = $applications->created_at;
    return $application_created_at; 
 }
 function assessor_assign_date($application_id,$asessor_id)
 {
    $applications=DB::table('asessor_applications')->where('application_id','=',$application_id)->where('assessor_id','=',$asessor_id)->first();
    
    
    $application_assign_date = $applications->created_at;
    return $application_assign_date; 
 }
function assessor_due_date($application_id,$asessor_id)
 {
    $applications=DB::table('asessor_applications')->where('application_id','=',$application_id)->where('assessor_id','=',$asessor_id)->first();
    
    
    $application_due_date = $applications->due_date;
    return $application_due_date; 
 }

?>
