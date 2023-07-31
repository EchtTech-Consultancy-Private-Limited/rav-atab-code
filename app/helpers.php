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

 function application_submission_date($application_id,$secretariat_id)
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

 function secretariat_assign_date($application_id,$secretariat_id)
 {
    //return $application_id;
    $applications=DB::table('secretariat')->where('application_id','=',$application_id)->where('secretariat_id','=',$secretariat_id)->first();


    $application_assign_date = $applications->created_at;
    return $application_assign_date;
 }

function assessor_due_date($application_id,$asessor_id)
 {
    $applications=DB::table('asessor_applications')->where('application_id','=',$application_id)->where('assessor_id','=',$asessor_id)->first();


    $application_due_date = $applications->due_date;
    return $application_due_date;
 }

 function secretariat_due_date($application_id,$secretariat_id)
 {
    $applications=DB::table('secretariat')->where('application_id','=',$application_id)->where('secretariat_id','=',$secretariat_id)->first();


    $application_due_date = $applications->due_date;
    return $application_due_date;
 }

 function listofapplicationsecretariat($application_id)
{
    $assessors = DB::table('secretariat')->where('application_id','=',$application_id)->get();
    $assessorid = array();
    if(!empty($assessors))
    {
        
        foreach($assessors as $assessorids)
        {
            $assessorid[] = $assessorids->secretariat_id;
        }
        return $assessorid;
    }
    else
    {
        $assessorid = array();
        return $assessorid;
    }
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

     function get_all_comments($id=0)
        {  
            //dd($id);
            //return $id;
          return  $doc_code=App\Models\DocComment::select('comments')->where('doc_id',$id)->get();
            /*if($doc_code)
            {
               $doc_comments = $doc_code->comments;
               return $doc_comments;
            }*/
        }

    function check_document_upload($id=0)
        {  
           $document_checked=App\Models\DocComment::where('course_id',$id)->first();
           if($document_checked)
           {
             return $document_verify=$document_checked->user_id;
           }
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

         function get_admin_comments($id=0)
        {  
           
            $record=App\Models\User::orderBy('id', 'desc')->where('id',$id)->first();
            if($record)
            {
               $user_name = $record->firstname;
               return $user_name;
            }
        }

        function get_role($id=0)
        {  
           
            $record=App\Models\User::orderBy('id', 'desc')->where('id',$id)->first();
            if($record)
            {
               $user_name = $record->role;
               return $user_name;
            }
        }

        function get_course_mode($id)
        {
             $course_mode=App\Models\ApplicationCourse::where('id',$id)->first();
            
             $vartype=gettype($course_mode->mode_of_course);
             if($vartype=="array")
             {
               return $course_modes = implode(',', $course_mode->mode_of_course);
             }
             else
             {
                $course_modes = $course_mode->mode_of_course;
                return $course_modes;
             }
           
            
            //dd("$course_modes");
            //return $course_modes;
        }
        function get_accessor_date($id)
        {
            
             $begin = Carbon\Carbon::now();
             $end = Carbon\Carbon::now()->addDays(15)->format('Y-m-d');

            $fifteenthDaysadd = Carbon\Carbon::now()->addDays(15)->format('Y-m-d');
            $events = DB::table('events_record')->where('asesrar_id',$id)->where('availability',2)->pluck('start');
              $arr_data = [];
              $eventsDate = [];
              $entArr=[];
              
              for($i=0; $i<=(count($events)-1); $i++){
                    $entArr[] =$events[$i];
              } 
              $eventsDate=[];
              for($j = $begin; $j <= $end; $j->modify('+1 day')){ 

                if(in_array($j->format("Y-m-d"), $entArr)){
                    $eventsDate[] = '<span class="btn btn-danger" style="color:red">'.$j->format("Y-m-d").'</span>';
                  }else{
                    $eventsDate[] = '<span class="btn btn-success" style="color:green">'.$j->format("Y-m-d").'</span>';
                  }
                
             }
               return $eventsDate;
            
        }
?>
