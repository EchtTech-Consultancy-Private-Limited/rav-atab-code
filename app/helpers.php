<?php

use App\Models\Add_Document;
use App\Models\Application;
use App\Models\ApplicationCourse;
use App\Models\ApplicationNotification;
use App\Models\DocComment;
use App\Models\Question;
use App\Models\SummaryReport;
use App\Models\SummaryReportChapter;
use App\Models\User;
use Illuminate\Support\Facades\DB;

function encode5t($str)
{
    for ($i = 0; $i < 5; $i++) //increase the level
    {
        $str = strrev(base64_encode($str)); //apply base64 first and then reverse the string
    }
    return $str;
}

//function to decrypt the string
function decode5t($str)
{
    for ($i = 0; $i < 5; $i++) {
        $str = base64_decode(strrev($str));
    }
    return $str;
}


//id decript & encrypt

function dEncrypt($value)
{

    $newkey = 'AX345678ZX98765Y';

    $newEncrypter = new \Illuminate\Encryption\Encrypter($newkey, 'AES-128-CBC');

    return $newEncrypter->encrypt($value);
}

function dDecrypt($value)
{

    $newkey = 'AX345678ZX98765Y';

    $newEncrypter = new \Illuminate\Encryption\Encrypter($newkey, 'AES-128-CBC');

    return $newEncrypter->decrypt($value);
}


function getFaqCategory()
{

    $data = ['1' => 'Level 1 FAQs', '2' => 'Level 2 FAQs', '3' => 'Level 3 FAQs', '4' => 'Level 4 FAQs', '5' => 'General FAQs'];

    return $data;
}

function application_submission_date($application_id, $secretariat_id)
{
    $applications = DB::table('application_payments')->where('application_id', '=', $application_id)->first();

    //$applications = "Test";
    $application_created_at = date('d-m-Y', strtotime($applications->created_at));
    return $application_created_at;
}
function assessor_assign_date($application_id, $asessor_id)
{
    // dd($application_id, $asessor_id);
    $applications = DB::table('asessor_applications')->where('application_id', '=', $application_id)->where('assessor_id', '=', $asessor_id)->first();


    if ($applications) {
        $application_assign_date = date('d-m-Y', strtotime($applications->created_at));
    }

    //  dd( $application_assign_date);
    return $application_assign_date ?? '';
}

function secretariat_assign_date($application_id, $secretariat_id)
{
    //return $application_id;
    $applications = DB::table('secretariat')->where('application_id', '=', $application_id)->where('secretariat_id', '=', $secretariat_id)->first();


    $application_assign_date = $applications->created_at;
    return $application_assign_date;
}

function assessor_due_date($application_id, $asessor_id)
{
    $applications = DB::table('asessor_applications')->where('application_id', '=', $application_id)->where('assessor_id', '=', $asessor_id)->first();

    $application_due_date = date("Y-m-d", strtotime($applications->due_date));

    $startdate = date("Y-m-d", strtotime("-7 days", strtotime($application_due_date)));
    $application_due_dates = date("Y-m-d", strtotime($startdate));
    $mytime = Carbon\Carbon::now();

    // // // return  $mytime.','.$startdate;

    //    if($application_due_dates >= $mytime){
    //         return true ;
    //     }else{
    //         return false ;
    //     }
    $startdue_date = date("Y-m-d", strtotime("-7 days", strtotime($application_due_date)));
    $startdate = date("Y-m-d", strtotime("-7 days", strtotime($mytime)));
    // $start = Carbon\Carbon::parse($application_due_date);
    // $end =  Carbon\Carbon::parse($startdate);

    // $days = $end->diffInDays($start);
    return $startdate . ',' . $startdue_date;
}

function secretariat_due_date($application_id, $secretariat_id)
{
    $applications = DB::table('secretariat')->where('application_id', '=', $application_id)->where('secretariat_id', '=', $secretariat_id)->first();


    $application_due_date = $applications->due_date;
    return $application_due_date;
}

function listofapplicationsecretariat($application_id)
{
    $assessors = DB::table('secretariat')->where('application_id', '=', $application_id)->get();
    $assessorid = array();
    if (!empty($assessors)) {

        foreach ($assessors as $assessorids) {
            $assessorid[] = $assessorids->secretariat_id;
        }
        return $assessorid;
    } else {
        $assessorid = array();
        return $assessorid;
    }
}

function listofapplicationassessor($application_id)
{
    $assessors = DB::table('asessor_applications')->where('application_id', '=', $application_id)->get();
    $assessorid = array();
    if (!empty($assessors)) {

        foreach ($assessors as $assessorids) {
            $assessorid[] = $assessorids->assessor_id;
        }
        return $assessorid;
    } else {
        $assessorid = array();
        return $assessorid;
    }
}

function checkapplicationassessmenttype($application_id)
{
    $application_assess_type = DB::table('asessor_applications')->where('application_id', '=', $application_id)->first();

    if (!empty($application_assess_type)) {
        $application_assessment_type = $application_assess_type->assessment_type;

        return $application_assessment_type;
    } else {
        $application_assessment_type = '';
        return $application_assessment_type;
    }
}
function checkmanualtype($type)
{
    if ($type == 1)
        $manual_type = "Guidelines";
    else
        $manual_type = "Reference Books";

    return $manual_type;
}

function checktppaymentstatus($id)
{
    $application_tp_payment = DB::table('application_payments')->where('application_id', $id)->get();

    $count = count($application_tp_payment);
    return $count;
}

function checktppaymentstatustype($id)
{
    $application_payment_confirm = DB::table('application_payments')->where('application_id', '=', $id)->first();

    if ($application_payment_confirm != '') {
        $status = $application_payment_confirm->status;
        return $status;
    } else {
        $status = 0;
        return $status;
    }
    //dd($application_payment_confirm);

}

function get_all_comments($id = 0)
{
    //dd($id);
    //return $id;
    return  $doc_code = App\Models\DocComment::select('comments')->where('doc_id', $id)->get();
    /*if($doc_code)
            {
               $doc_comments = $doc_code->comments;
               return $doc_comments;
            }*/
}

function check_document_upload($id = 0)
{
    $document_checked = App\Models\DocComment::where('course_id', $id)->first();
    if ($document_checked) {
        return $document_verify = $document_checked->user_id;
    }
}

function get_doc_code($id = 0)
{
    //dd($id);
    //return $id;
    $doc_code = App\Models\DocComment::orderBy('id', 'desc')->where('doc_id', $id)->first();
    if ($doc_code) {
        $doc_code_show = $doc_code->doc_code;
        return $doc_code_show;
    }
}

function get_doccomment_status($id = 0)
{

    $doc_code = App\Models\DocComment::orderBy('id', 'desc')->where('doc_id', $id)->first();
    if ($doc_code) {
        $doc_comment_status = $doc_code->status;
        return $doc_comment_status;
    }
}

function get_admin_comments($id = 0)
{

    $record = App\Models\User::orderBy('id', 'desc')->where('id', $id)->first();
    if ($record) {
        $user_name = $record->firstname;
        return $user_name;
    }
}

function get_user_email($id = 0)
{

    $record = App\Models\User::where('id', $id)->first();
    if ($record) {
        $user_email = $record->email;
        return $user_email;
    }
}

function get_user_name($id = 0)
{

    $record = App\Models\User::where('id', $id)->first();
    if ($record) {
        $user_email = $record->firstname . ' ' . $record->lastname;
        return $user_email;
    }
}

function check_acknowledgement($id = 0)
{

    $record = App\Models\AcknowledgementRecord::where('course_id', $id)->first();
    if ($record) {
        return $course = $record->course_id;
    }
}

function count_document_record($id = 0)
{

    return $record = App\Models\Add_Document::where('course_id', $id)->count();
}

function get_role($id = 0)
{

    $record = App\Models\User::orderBy('id', 'desc')->where('id', $id)->first();
    if ($record) {
        $user_name = $record->role;
        return $user_name;
    }
}

function get_course_mode($id)
{
    $course_mode = App\Models\ApplicationCourse::where('id', $id)->first();

    $vartype = gettype($course_mode->mode_of_course);
    if ($vartype == "array") {
        return $course_modes = implode(',', $course_mode->mode_of_course);
    } else {
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
    $events = DB::table('events_record')->where('asesrar_id', $id)->where('availability', 2)->pluck('start');
    $arr_data = [];
    $eventsDate = [];
    $entArr = [];

    for ($i = 0; $i <= (count($events) - 1); $i++) {
        $entArr[] = $events[$i];
    }
    $eventsDate = [];
    for ($j = $begin; $j <= $end; $j->modify('+1 day')) {

        if (in_array($j->format("Y-m-d"), $entArr)) {
            $eventsDate[] = '<span onclick="saveDates({{ $item->id }},{{ $assesorsData->id }},{{ $assesorsData->assessment }},{{ $selectedDate }})" data-id="'. $j->format("Y-m-d").'" class="btn btn-danger" style="color:red">' . $j->format("Y-m-d") . '</span>';
        } else {
            $eventsDate[] = '<span data-id="'. $j->format("Y-m-d").'" class="btn btn-success" style="color:green">' . $j->format("Y-m-d") . '</span>';
        }
    }
    return $eventsDate;
}

function get_accessor_date_new($id,$applicationID,$assessmentType)
{

    $begin = Carbon\Carbon::now();
    $end = Carbon\Carbon::now()->addDays(15)->format('Y-m-d');

    $fifteenthDaysadd = Carbon\Carbon::now()->addDays(15)->format('Y-m-d');
    $events = DB::table('events_record')->where('asesrar_id', $id)->where('availability', 2)->pluck('start')->toArray();
    $selectedDate = DB::table('assessor_assigne_date')->where('assessor_Id', $id)->where('application_id', $applicationID)->pluck('selected_date')->toArray();
    $arr_data = [];
    $eventsDate = [];
    $entArr = [];

    for ($i = 0; $i <= (count($events) - 1); $i++) {
        $entArr[] = $events[$i];
    }
    $eventsDate = [];
    $allSelectedDates = [];
    $allSelectedDates = array_merge($events,$selectedDate);
    for ($j = $begin; $j <= $end; $j->modify('+1 day')) {
       
        if (in_array($j->format("Y-m-d"), $allSelectedDates) ) {
            $eventsDate[] = "<span class='btn btn-danger dateID'  data-id='".$applicationID.','.$id.','.$assessmentType.','.$j->format("Y-m-d")."'>".$j->format("Y-m-d")."</span>";

        } else {
           $eventsDate[] = "<span class='btn btn-success dateID' data-id='".$applicationID.','.$id.','.$assessmentType.','.$j->format("Y-m-d")."' >".$j->format("Y-m-d")."</span>";
        }
    }
    return $eventsDate;
}

// function selectedDates($applicationID,$assesorID,$selectedDate,$assessmentType){
//     $selectedDate = DB::table('assessor_assigne_date')->where('assessor_Id',$assesorID)
//         ->where('assesment_type',$assessmentType)
//         ->where('application_id',$applicationID)
//         ->where('selected_date',$selectedDate)->first();

//         if ($selectedDate) {
//             return $selectedDate;
//         }else{
//             return false;
//         }
// }


function check_upgrade($id = 0)
{
    $created_at = $id;

    $todate = Carbon\Carbon::now();

    $result = $todate->diffInDays($created_at);

    if ($result >= 350 && $result <= 365) {
        return "true";
    }
    /*else
                {
                    return "no";
                }*/
}

function check_upgraded_level2($id = 0)
{

    $level2 = App\Models\ApplicationLevel2::where('level1_application_id', $id)->first();
    if ($level2) {
        return 'true';
    } else {
        return 'false';
    }
}

function main_menu()
{

    $data = App\Models\Menu::orderBy('sorting', 'ASC')->whereparent_id('0')->get();
    return $data;
}

function show_btn($date)
{


    $application_due_date = date("Y-m-d", strtotime($date));
    $startdate = date("Y-m-d", strtotime("-7 days", strtotime($application_due_date)));

    $mytime = Carbon\Carbon::now();
    $mytime->toDateTimeString();

    return $startdate;

    if ($startdate  ==  $mytime->toDateTimeString()) {

        return "1";
    } else {

        return "0";
    }
}




function Checknotification($id = 0)
{

    $assessors = DB::table('asessor_applications')->orderBy('id', 'desc')->select('id', 'created_at', 'application_id')->where('notification_status', 0)->where('assessor_id', $id)->get();

    $assesorWithApplicationData = [];

    foreach ($assessors as $assesor) {
        $applicationData = DB::table('applications')->orderBy('id', 'desc')->select('id', 'application_uid')->where('id', $assesor->application_id)->first();

        if ($applicationData) {
            $assesorWithApplicationData[] = [
                'application_uid' => $applicationData->application_uid ?? 0,
                'id' => $assesor->id,
                'created_at' => $assesor->created_at,
                'application_id' => $assesor->application_id
            ];
        }
    }

    if ($assesorWithApplicationData != NULL) {

        return $assesorWithApplicationData;
    } else {
        return false;
    }
}

function showstate($id)
{

    $state = DB::table('states')->where('id', $id)->first();

    return $state->name;
}


function checkDocumentCommentStatus($id)
{
    $commentData = DB::table('doc_comments')->where('doc_id', $id)->latest()->first();

    if ($commentData) {
        if ($commentData->status == 4) {
            return "btn-success";
        } elseif ($commentData->status == 5) {
            return "btn-warning";
        } else {
            return "btn-danger";
        }
    } else {
        return "btn-primary";
    }
}

function checkDocumentCommentStatusreturnText($id)
{
    $commentData = DB::table('doc_comments')->where('doc_id', $id)->latest()->first();

    if ($commentData) {
        if ($commentData->status == 4) {
            return "File Approved";
        } else {
            return "File not approved";
        }
    } else {
        return "View Document";
    }
}


function getComments($id = null, $applicationID)
{
    $documents = DB::table('add_documents')->where('question_id', $id)->where('application_id', $applicationID)->get();

    $docIds = $documents->pluck('id');

    $comments = DB::table('doc_comments')->orderByDesc('id')->whereIn('doc_id', $docIds)->get();

    $html = "";
    if ($comments) {
        $num = 1;
        $html = "<table>
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Document Code</th>
                <th>Date</th>
                <th>Comments</th>
                <th>Status Code</th>
                <th>Approved/Rejected By</th>
            </tr>
        </thead>
        <tbody>";
        $class = "";
        foreach ($comments as $comment) {

            $statusCode = "";
            if ($comment->status == 4) {
                $statusCode = "Close";
            } elseif ($comment->status == 3) {
                $statusCode = "Not Recommended";
            } elseif ($comment->status == 2) {
                $statusCode = "NC2";
            } elseif ($comment->status == 1) {
                $statusCode = "NC1";
            } elseif ($comment->status == 5) {
                $statusCode = "Request final approval";
            } elseif ($comment->status == 6) {
                $statusCode = "NC3";
            } else {
                $statusCode = "Close";
            }


            if ($comment->status == 4) {
                $html .= "<tr class='text-success' style='border-left:3px solid green'>";
            } else {
                $html .= "<tr class='text-danger' style='border-left:3px solid red'>";
            }

            $html .= "<td width='60'>" . $num++ . "</td>";
            $html .= "<td width='130'>" . $comment->doc_code . "</td>";
            $html .= "<td width='120'>" . \Carbon\Carbon::parse($comment->created_at)->format('d-m-Y') . "</td>";
            $html .= "<td>" . $comment->comments . "</td>";
            $html .= "<td>" . $statusCode ?? '' . "</td>";
            $html .= "<td>" . getUserDetails($comment->user_id) . "</td>";
            $html .= "</tr>";
        }

        $html .= "</tbody>
        </table>";
    }

    return $html;
}

function getCommentsForAdmin($id = null, $applicationID)
{
    $documents = DB::table('add_documents')->where('question_id', $id)->where('application_id', $applicationID)->get();

    $docIds = $documents->pluck('id');

    $comments = DB::table('doc_comments')->orderByDesc('id')->whereIn('doc_id', $docIds)->get();

    $html = "";
    if ($comments) {
        $num = 1;
        $html = "<table class='table table-bordered'>
     
            <tr>
                <th>Sr. No.</th>
                <th>Document Code</th>
                <th>Date</th>
                <th>Comments</th>
                <th>Status Code</th>
                <th>Approved/Rejected By</th>
            </tr>
      
        <tbody>";
        $class = "";
        foreach ($comments as $comment) {

            $statusCode = "";
            if ($comment->status == 4) {
                $statusCode = "Close";
            } elseif ($comment->status == 3) {
                $statusCode = "Not Recommended";
            } elseif ($comment->status == 2) {
                $statusCode = "NC2";
            } elseif ($comment->status == 1) {
                $statusCode = "NC1";
            } elseif ($comment->status == 5) {
                $statusCode = "Request final approval";
            } elseif ($comment->status == 6) {
                $statusCode = "NC3";
            } else {
                $statusCode = "Close";
            }


            if ($comment->status == 4) {
                $html .= "<tr class='text-success' style='border-left:3px solid green'>";
            } else {
                $html .= "<tr class='text-danger' style='border-left:3px solid red'>";
            }

            $html .= "<td width='60'>" . $num++ . "</td>";
            $html .= "<td width='130'>" . $comment->doc_code . "</td>";
            $html .= "<td width='120'>" . \Carbon\Carbon::parse($comment->created_at)->format('d-m-Y') . "</td>";
            $html .= "<td>" . $comment->comments . "</td>";
            $html .= "<td>" . $statusCode ?? '' . "</td>";
            $html .= "<td>" . getUserDetails($comment->user_id) . "</td>";
            $html .= "</tr>";
        }

        $html .= "</tbody>
        </table>";
    }

    return $html;
}



function getUserDetails($userId)
{
    $user =  DB::table('users')->where('id', $userId)->first();
    return $user->firstname . ' ' . $user->lastname;
}

function checkCommentsExist($id = null, $applicationId = null)
{
    $authId = auth()->user()->id;

    $documents = DB::table('add_documents')->where('question_id', $id)->where('user_id', $authId)->where('application_id', $applicationId)->get();


    if ($documents) {
        $docIds = $documents->pluck('id');

        $comments = DB::table('doc_comments')->orderByDesc('id')->whereIn('doc_id', $docIds)->get();

        if (count($comments) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

function getDocument($questionID, $applicationId, $course_id)
{
    $authId = auth()->user()->id;

    $documents = DB::table('add_documents')->where('question_id', $questionID)->where('user_id', $authId)->where('application_id', $applicationId)->where('course_id', $course_id)->get();

    if (count($documents) > 0) {
        return $documents;
    } else {
        return $documents = [];
    }
}

function getAssessorDocument($questionID, $applicationId, $course_id)
{


    $documents = DB::table('add_documents')->where('course_id', $course_id)->where('question_id', $questionID)->where('application_id', $applicationId)->where('on_site_assessor_Id', null)->get();

    if (count($documents) > 0) {
        return $documents;
    } else {
        return $documents = []; 
    }
}

function getOnSiteAssessorDocument($questionID, $applicationId, $course_id)
{


    $documents = DB::table('add_documents')->where('course_id', $course_id)->where('question_id', $questionID)->where('application_id', $applicationId)->where('on_site_assessor_Id', '!=', null)->where('photograph', null)->get();

    if (count($documents) > 0) {
        return $documents;
    } else {
        return $documents = [];
    }
}

function getMandays($applicationID,$assesorID){
    $dates =  DB::table('assessor_assigne_date')->where('assessor_Id',$assesorID)->where('application_id',$applicationID)->get();
    return count($dates);
}

function getOnSiteAssessorPhotograph($questionID, $applicationId, $course_id)
{


    $documents = DB::table('add_documents')->where('course_id', $course_id)->where('question_id', $questionID)->where('application_id', $applicationId)->where('photograph', 1)->get();

    if (count($documents) > 0) {
        return $documents;
    } else {
        return $documents = [];
    }
}

function getAdminDocument($questionID, $applicationId)
{

    $documents = DB::table('add_documents')->where('question_id', $questionID)->where('application_id', $applicationId)->get();

    if (count($documents) > 0) {
        return $documents;
    } else {
        return $documents = [];
    }
}

// only for summery report
function getSummerDocument($questionID, $applicationId)
{
    // dd($questionID);
    $documents = DB::table('add_documents')->where('question_id', $questionID)->where('application_id', $applicationId)->first();
    // dd($documents);
    // if (count($documents) > 0) {
        return $documents;
    // } else {
    //     return $documents = [];
    // }
}
// end summery report

function getAssessorComments($docID)
{
    $comments = DocComment::where('doc_id', $docID)->get();
    if (count($comments) > 0) {
        return $comments;
    } else {
        return [];
    }
}

function commentsCountForTP($id, $applicationID)
{
    $documents = DB::table('add_documents')->where('question_id', $id)->where('application_id', $applicationID)->get();

    $docIds = $documents->pluck('id');

    $comments = DB::table('doc_comments')->orderByDesc('id')->whereIn('doc_id', $docIds)->get();
    if (count($comments) > 0) {
        return $comments;
    } else {
        return [];
    }
}


function checkApproveComment($doc_id)
{
    $comment = DocComment::where('doc_id', $doc_id)->first();

    if ($comment->status == 4) {
        return 4;
    } else {
        return 0;
    }
}

function checkFinalRequest($id)
{
    $commentData = DB::table('doc_comments')->where('doc_id', $id)->latest()->first();
    if ($commentData) {
        if ($commentData->status == 5) {
            return "Request for final approval!";
        }
    } else {
        return "";
    }
}

function getButtonText($id)
{
    $commentData = DB::table('doc_comments')->where('doc_id', $id)->latest()->first();

    if ($commentData) {
        if ($commentData->status == 4) {
            return "Accepted";
        } elseif ($commentData->status == 3 || $commentData->status == 5) {
            return "Not Recommended";
        } elseif ($commentData->status == 2) {
            return "NC2";
        } elseif ($commentData->status == 1) {
            return "NC1";
        } elseif ($commentData->status == 6) {
            return "NC3";
        } else {
            return "Not Approved";
        }
    } else {
        return "View";
    }
}

function getCommentsData($docID)
{
    $comment = DocComment::where('doc_id', $docID)->latest()->first();
    return $comment ?? [];
}

function totalQuestionsCount($applicationId)
{
    $courses = ApplicationCourse::where('application_id', $applicationId)->get()->count();
    $questions = Question::all()->count();
    $questions = $questions * $courses;
    return $questions;
}


function totalDocumentsCount($applicationId)
{
    $totalDocuments = DB::table('add_documents')->where('application_id', $applicationId)->get()->count();

    return $totalDocuments;
}

function getUserDetail($userId)
{
    $user = User::find($userId);
    return $user;
}

function checkVerifiedDocumentUploaded($applicationId, $courseId, $assessorid, $questionId)
{

    $document = Add_Document::where('question_id', $applicationId)->where('application_id', $questionId)->where('course_id', $courseId)->where('on_site_assessor_Id', $assessorid)->first(['verified_document']);

    if ($document) {
        return $document;
    } else {
        return false;
    }
}


function checkVerifiedPhotographUploaded($applicationId, $courseId, $assessorid, $questionId)
{
    $document = Add_Document::where('question_id', $applicationId)->where('application_id', $questionId)->where('course_id', $courseId)->where('on_site_assessor_Id', $assessorid)->first(['photograph']);
    if ($document) {
        return $document;
    } else {
        return false;
    }
}


function checkVerifiedDocumentAvailable($application_id, $course_id, $assessor_id, $question_id)
{
    $document = DB::table('add_documents')->where('question_id', $question_id)->where('application_id', $application_id)
        ->where('course_id', $course_id)
        ->where('on_site_assessor_Id', $assessor_id)
        ->first();

    if ($document) {
        return $document;
    } else {
        return false;
    }
}

function checkVerifiedDocumentAvailableForAdmin($application_id, $course_id, $question_id)
{
    $document = DB::table('add_documents')->where('question_id', $question_id)->where('application_id', $application_id)
        ->where('course_id', $course_id)
        ->first();
    if ($document) {
        return $document;
    } else {
        return false;
    }
}

function applicationDocuments($applicationId)
{
    $documents = Add_Document::where('application_id', $applicationId)->whereHas('comments', function ($query) {
        $query->where('status', 4);
    })
        ->get();

    $questions = Question::all();

    if (3 == count($documents)) {
        return true;
    } else {
        return false;
    }
}

function getVerifiedApplications()
{
    $applicationsIds = Application::where('user_id', auth()->user()->id)->get(['id']);
    $applications = ApplicationNotification::whereIn('application_id', $applicationsIds)->where('is_read', 0)->get();
    return $applications;
}

function getApplicationPaymentNotificationStatus()
{
    $applicationsIds = Application::where('user_id', auth()->user()->id)->get(['id']);
    $applications = ApplicationNotification::whereIn('application_id', $applicationsIds)->where('is_read', 0)->get();
    if (count($applications) > 0) {
        return true;
    } else {
        return false;
    }
}

function checkOnSiteDoc($applicationID, $questionID, $courseID, $assesorID)
{
    $document = Add_Document::where('question_id', $questionID)
        ->where('application_id', $applicationID)
        ->where('course_id', $courseID)
        ->where('on_site_assessor_Id', $assesorID)->orderBy('id', 'desc')->first();


    return $document;
}

function checkOnSitePhotograph($applicationID, $questionID, $courseID, $assesorID)
{
    $document = Add_Document::where('question_id', $questionID)
        ->where('application_id', $applicationID)
        ->where('course_id', $courseID)
        ->where('on_site_assessor_Id', $assesorID)->where('photograph', 1)->orderBy('id', 'desc')->first();


    return $document;
}

function getLastComment($docID)
{

    $comment = DocComment::where('doc_id', $docID)->orderBy('id', 'desc')->first();

    return $comment;
}

function updatedBy($docId)
{
    $document = Add_Document::find($docId);
    $comment = DocComment::where('doc_id', $docId)->first();

    if ($comment) {
        if ($document->on_site_assessor_Id != null && $document->notApraove_count != 0) {
            return "Updated by On-Site Assessor";
        } elseif ($document->on_site_assessor_Id != null && $document->notApraove_count == 0) {
            return "Uploaded by On-Site Assessor";
        } else {
            return "Updated by Desktop Assessor";
        }
    } elseif ($document->photograph) {
        return "Photograph uploaded by On-Site Assessor";
    } else {
        return "Training Provider";
    }
}


function getRejectedDocOnly($questionID,$applicationID,$courseID){
    $documents = Add_Document::where('application_id',$applicationID)->where('course_id',$courseID)->where('question_id',$questionID)->get();
    foreach ($documents as $document) {
       $comments = DocComment::where('doc_id',$document->id)->get();
       foreach ($comments as $comment) {
            if ($comment->status != 4) {
                return $comment;
            }
       }
    }
}

function checkReportAvailableOrNot($applicationID){
    $reportAvailable = SummaryReport::where('application_id',$applicationID)->first();

    return $reportAvailable;
}


function checkDocumentsStatus($applicationID,$courseID){
    $documentsIds = Add_Document::where('application_id',$applicationID)->where('course_id',$courseID)->get(['id']);
    $comments = DocComment::whereIn('doc_id',$documentsIds)->where('status','!=',4)->get();
    return $comments;

}

function getDocumentComment($questionID,$applicationID,$courseID){
    $document =  Add_Document::where('question_id',$questionID)->where('application_id',$applicationID)->where('course_id',$courseID)->first();
   if ($document) {
    $comment = DB::table('doc_comments')->where('doc_id',$document->id)->first();
    return $comment;
   }
}

function getAllDocumentsForSummary($questionID,$applicationID,$courseID){
    return Add_Document::where('question_id',$questionID)->where('application_id',$applicationID)->where('course_id',$courseID)->get();
}

function getDocComment($docID){
    return DocComment::where('doc_id',$docID)->first();
}

function printStatus($docID){
    $comment = DocComment::where('doc_id',$docID)->first();

   if ( $comment ) {
    if ($comment->status == 1) {
        return "NC1";
    } elseif ($comment->status == 2) {
        return "NC2";
    } 
    elseif ($comment->status == 3) {
        return "Not Recommended";
    } 
    elseif ($comment->status == 4) {
        return "No NC";
    } 
   } else {
    return "Document not uploaded!";
   }
   
    
}

function printRemark($docID){
    $comment = DocComment::where('doc_id',$docID)->first();

   if ( $comment ) {
  if ($comment->status == 4) {
        return "Accepted";
    } else{
        return "Not Accepted";
    }
   } else {
    return "Document not uploaded!";
   }
   
    
}

function getSummaries($applicationID,$courseID){
    return SummaryReport::where('summary_type','desktop')->where('course_id',$courseID)->where('application_id',$applicationID)->first();
}

function getQuestionSummary($question_id,$summaryReport_id){
    return SummaryReportChapter::where('summary_report_application_id',$summaryReport_id)->where('question_id',$question_id)->first();
}