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

function listofapplicationassessor($application_id)
{
    $assessors = DB::table('asessor_applications')->where('application_id','=',$application_id)->get();
    $assessorid = array();
    if(!empty($assessors))
    {
        
        foreach($assessors as $assessorids)
        {
            $assessorid[] = $assessorids->assessor_id;
        }
        return $assessorid;
    }
    else
    {
        $assessorid = array();
        return $assessorid;
    }
}
function checkapplicationassessmenttype($application_id)
{
    $application_assess_type = DB::table('asessor_applications')->where('application_id','=',$application_id)->first();

    if(!empty($application_assess_type))
    {
        $application_assessment_type = $application_assess_type->assessment_type;

        return $application_assessment_type;
    }
    else
    {
        $application_assessment_type = '';
        return $application_assessment_type;
    }


}
function checkmanualtype($type)
{
    if($type == 1)
        $manual_type = "Guidelines";
    else
        $manual_type = "Reference Books";

    return $manual_type;
}

function checktppaymentstatus($id)
{
    $application_tp_payment = DB::table('application_payments')->where('application_id','=',$id)->get();

    $count = count($application_tp_payment);
    return $count;
}

function checktppaymentstatustype($id)
{
    $application_payment_confirm = DB::table('application_payments')->where('application_id','=',$id)->first();
    
    if($application_payment_confirm != '')
    {
        $status = $application_payment_confirm->status;
        return $status;
    }
    else
    {
        $status = 0;
        return $status;
    }
    //dd($application_payment_confirm);
    
}


function get_doc_code($id=0)
        {  
            //dd($id);
            //return $id;
            $doc_code=App\Models\DocComment::orderBy('id', 'desc')->where('doc_id',$id)->first();
            if($doc_code)
            {
               $doc_code_show = $doc_code->doc_code;
               return $doc_code_show;
            }
        }

        function get_doccomment_status($id=0)
        {  
            //return $id;
            $doc_code=App\Models\DocComment::orderBy('id', 'desc')->where('doc_id',$id)->first();
            if($doc_code)
            {
               $doc_comment_status = $doc_code->status;
               return $doc_comment_status;
            }
        }
?>
