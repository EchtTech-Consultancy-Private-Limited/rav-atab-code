<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ApplicationCourse;
use App\Models\Application;
use Illuminate\Http\Request;
use DB;
use Auth;
class SummaryController extends Controller
{
    public function desktopIndex(Request $request){
        $assessor_id = Auth::user()->id;
        $summertReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.Person_Name','app.application_uid','app.created_at as app_created_at','app_course.course_name','usr.firstname','usr.middlename','usr.lastname')
        ->leftJoin('applications as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => $request->application,
            'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' => $request->course,
            'app_course.application_id' => $request->application,
            'app_course.id' => $request->course,
            'asr.assessor_type' => 'desktop',
        ])
        ->first();

        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$assessor_id,'application_id'=>$request->application])->count();
  
  
    $questions = DB::table('questions')->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
            $value = DB::table('assessor_summary_reports')->where([
                'application_id' => $request->application,
                'assessor_id' => $assessor_id,
                'object_element_id' => $question->id,
                'doc_sr_code' => $question->code,
            ])->get();
                $obj->nc = $value;
                $final_data[] = $obj;
            
    }
    $assessement_way = DB::table('asessor_applications')->where(['assessor_id'=>$assessor_id,'application_id'=>$request->application])->first()->assessment_way;

       $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->application_,'application_course_id'=>$request->course])->first();
       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }
        return view('assessor-summary.desktop-view-summary',compact('summertReport', 'no_of_mandays','final_data','is_final_submit','assessement_way'));
    }

    public function onSiteIndex(Request $request){
        $assessor_id = Auth::user()->id;
        $assessor_name = Auth::user()->firstname.' '.Auth::user()->middlename.' '.Auth::user()->lastname;

        $summertReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.Person_Name','app.application_uid','app.created_at as app_created_at','app_course.course_name','usr.firstname','usr.lastname','ass_impr_form.assessee_org','ass_impr_form.sr_no','ass_impr_form.improvement_form','ass_impr_form.standard_reference','final_summary_repo.brief_open_meeting','final_summary_repo.brief_summary','final_summary_repo.brief_closing_meeting','final_summary_repo.summary_date','ass_impr_form.assessee_org as onsite_assessee_org')
        ->leftJoin('applications as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->leftJoin('assessor_improvement_form as ass_impr_form', 'ass_impr_form.assessor_id', '=', 'asr.assessor_id')
        ->leftJoin('assessor_final_summary_reports as final_summary_repo', 'final_summary_repo.assessor_id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => $request->application,
            'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' => $request->course,
            'app_course.application_id' => $request->application,
            'app_course.id' => $request->course,
            'asr.assessor_type' => 'onsite',
            'ass_impr_form.assessor_id'=>$assessor_id,
            'ass_impr_form.application_id'=>$request->application,
            'ass_impr_form.application_course_id'=>$request->course,
            'final_summary_repo.assessor_id'=>$assessor_id,
            'final_summary_repo.application_id'=>$request->application,
            'final_summary_repo.application_course_id'=>$request->course,
        ])
        ->first();
       
        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$assessor_id,'application_id'=>$request->application])->count();
            
   
        
  
    $questions = DB::table('questions')->get();

    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;

            $value = DB::table('assessor_summary_reports')->where([
                'application_id' => $request->application,
                'assessor_id' => $assessor_id,
                'object_element_id' => $question->id,
                'doc_sr_code' => $question->code,
            ])->get();
                $obj->nc = $value;
                $final_data[] = $obj;
            
    }

    
       $assessement_way = DB::table('asessor_applications')->where(['assessor_id'=>$assessor_id,'application_id'=>$summertReport->application_id])->first()->assessment_way;
    
       $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->application_,'application_course_id'=>$request->course])->first();

       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }
        return view('assessor-summary.on-site-view-summary',compact('summertReport', 'no_of_mandays','final_data','is_final_submit','assessor_name','assessement_way'));
        // return view('assessor-summary.on-site-view-summary');
    }

    public function desktopSubmitSummary(Request $request){
        $assessor_id = Auth::user()->id;
        $summertReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.Person_Name','app.application_uid','app.created_at as app_created_at','app_course.course_name','usr.firstname','usr.lastname')
        ->leftJoin('applications as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => $request->application_id,
            'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' => $request->application_course_id,
            'app_course.application_id' => $request->application_id,
            'app_course.id' => $request->application_course_id,
            'asr.assessor_type'=>'desktop'
        ])
        ->first();

        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$summertReport->assessor_id,'application_id'=>$summertReport->application_id])->count();

  
    $assesor_distinct_report = DB::table('assessor_summary_reports as asr')
    ->select('asr.application_id','asr.assessor_id','asr.object_element_id')
    ->where('asr.assessor_type','desktop')
    ->where(['application_id' => $request->application_id, 'assessor_id' => $assessor_id])
    ->whereIn('nc_raise_code', ['1', '2'])
    ->groupBy('asr.application_id','asr.assessor_id','asr.object_element_id')
    ->get()->pluck('object_element_id');
        
  
    $questions = DB::table('questions')->whereIn('id',$assesor_distinct_report)->get();

    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;

            $value = DB::table('assessor_summary_reports')->where([
                'application_id' => $request->application_id,
                'assessor_id' => $assessor_id,
                'object_element_id' => $question->id,
                'doc_sr_code' => $question->code,
            ])->get();
                $obj->nc = $value;
                $final_data[] = $obj;
            
    }
       $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->application_id,'application_course_id'=>$request->application_course_id,'assessor_id'=>$assessor_id])->first();

       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }
   
        return view('assessor-summary.desktop-submit-summary', compact('summertReport', 'no_of_mandays','final_data','is_final_submit'));
    }


    public function desktopFinalSubmitSummaryReport(Request $request){

        $check_report = DB::table('assessor_final_summary_reports')->where(['application_id' => $request->application_id,'application_course_id' => $request->application_course_id,'assessor_type'=>'desktop'])->first();
        if(!empty($check_report)){
            return back()->with('fail', 'This application record already submitted');
        }
        $assessor_id = Auth::user()->id;
        $data = [];
        $data['application_id']=$request->application_id;
        $data['assessor_id']=$assessor_id;
        $data['application_course_id']=$request->application_course_id;
        $data['assessor_type']='desktop';
        $create_final_summary_report=DB::table('assessor_final_summary_reports')->insert($data);
        return redirect('accr-view-document'.'/'.$request->application_id.'/'.$request->application_course_id); 
    }

    public function onSiteFinalSubmitSummaryReport(Request $request){

        $check_report = DB::table('assessor_final_summary_reports')->where(['application_id' => $request->application_id,'application_course_id' => $request->application_course_id,'assessor_type'=>'onsite'])->first();
        if(!empty($check_report)){
            return back()->with('fail', 'This application record already submitted');
        }
        $assessor_id = Auth::user()->id;
        $data = [];
        $data['application_id']=$request->application_id;
        $data['assessor_id']=$assessor_id;
        $data['application_course_id']=$request->application_course_id;
        $data['assessor_type']='onsite';
        $data['brief_open_meeting']=$request->brief_open_meeting??'N/A';
        $data['brief_summary']=$request->brief_summary??'N/A';
        $data['brief_closing_meeting']=$request->brief_closing_meeting??'N/A';
        $data['assessee_org']=$request->assessee_org??'N/A';
        $data['summary_date']=$request->summary_date??'N/A';
        $create_final_summary_report=DB::table('assessor_final_summary_reports')->insert($data);
        
        $dataImprovement= [];
        $dataImprovement['assessor_id']=$assessor_id;
        $dataImprovement['application_id']=$request->application_id;
        $dataImprovement['application_course_id']=$request->application_course_id;
        $dataImprovement['sr_no']=$request->sr_no??'N/A';
        $dataImprovement['standard_reference']=$request->standard_reference??'N/A';
        $dataImprovement['improvement_form']=$request->improvement_form??'N/A';
        $dataImprovement['signatures']=$request->signatures??'N/A';
        $dataImprovement['signatures_of_team_leader']=$request->signatures_of_team_leader??'N/A';
        $dataImprovement['assessee_org']=$request->improve_assessee_org??'N/A';
        $create_onsite_final_summary_report=DB::table('assessor_improvement_form')->insert($dataImprovement);

        // return redirect(url('opportunity-form/report?application=' . $request->application_id . '&course=' . $request->application_course_id))->with('success', "Data saved successfully");

        return redirect(url('accr-view-document/' . $request->application_id . '/' . $request->application_course_id))->with('success', "Data saved successfully");
    }

    public function onSiteSubmitSummary(Request $request,$application_id,$application_course_id){

        $assessor_id = Auth::user()->id;
        $assessor_name = Auth::user()->firstname.' '.Auth::user()->middlename.' '.Auth::user()->lastname;
        $summertReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.Person_Name','app.application_uid','app.created_at as app_created_at','app_course.course_name','usr.firstname','usr.lastname')
        ->leftJoin('applications as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => $application_id,
            'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' =>$application_course_id,
            'app_course.application_id' => $application_id,
            'app_course.id' =>$application_course_id,
            'asr.assessor_type'=>'onsite',
           
        ])
        ->first();
        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=> $assessor_id,'application_id'=> $application_id])->count();
  
    $assesor_distinct_report = DB::table('assessor_summary_reports as asr')
    ->select('asr.application_id','asr.assessor_id','asr.object_element_id')
    ->where('asr.assessor_type','onsite')
    ->where(['application_id' => $application_id, 'assessor_id' => $assessor_id])
    ->whereIn('nc_raise_code', ['1', '2'])
    ->groupBy('asr.application_id','asr.assessor_id','asr.object_element_id')
    ->get()->pluck('object_element_id');
    

    $assessement_way = DB::table('asessor_applications')->where(['assessor_id'=>$assessor_id,'application_id'=>$application_id])->first()->assessment_way;
  
    $questions = DB::table('questions')->whereIn('id',$assesor_distinct_report)->get();
    $final_data=[];
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;

            $value = DB::table('assessor_summary_reports')->where([
                'application_id' => $application_id,
                'assessor_id' => $assessor_id,
                'object_element_id' => $question->id,
                'doc_sr_code' => $question->code,
            ])->get();
                $obj->nc = $value;
                $final_data[] = $obj;
            
    }
       $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application_id,'application_course_id'=>$request->application_course_id])->first();

       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }
        return view('assessor-summary.on-site-submit-summary', compact('summertReport', 'no_of_mandays','final_data','is_final_submit','assessor_name','assessement_way'));
    }



    public function desktopVerifiedDocuments(Request $request){

        /*---Written by suraj---*/
        // $request->validate([
        //     'application_id' => 'required',
        //     'assessor_id' => 'required',
        // ]);
        $data=[];
        $data['application_id'] = $request->application_id;
        $data['date_of_assessement'] = $request->date_of_assessement;
        $data['assessor_id'] = $request->assessor_id;
        $data['assessor_type'] = $request->assessor_type;
        $data['nc_raise'] = $request->nc_raise;
        $data['doc_path'] = $request->doc_path;
        $data['capa_mark'] = $request->capa_mark??'';
        $data['doc_against_nc'] = $request->doc_against_nc??'';
        $data['doc_verify_remark'] = $request->remarks;
        $create_summary_report = DB::table('assessor_summary_reports')->insert($data);

        dd($create_summary_report);
        /*End here*/


        $login_id = Auth::user()->role;

        if ($login_id == 3) {

            $document = Add_Document::where('id', $request->doc_id)->first();
            $document->assessor_id = Auth::user()->id;
            $document->assesment_type = Auth::user()->assessment == 1 ? 'desktop' : 'onsite';
            $document->save();


            $comment = new DocComment;
            $comment->doc_id = $request->doc_id;
            $comment->doc_code = $request->doc_code;
            $comment->status = $request->status;
            $comment->comments = $request->doc_comment;
            $comment->course_id = $request->course_id;
            $comment->user_id = Auth::user()->id;

            $comment->save();

            if ($request->status != 4) {
                ApplicationNotification::create([
                    'application_id' => $request->application_id,
                    'is_read' => 0,
                    'notification_type' => 'document'
                ]);
            }



            if ($request->status == 1) {
                $mailstatus = "Approved";
            } else {
                $mailstatus = "Not Approved";
            }
            //mail send
            $admin = user::where('role', '1')->orderBy('id', 'DESC')->whereNotIn('id', ['superadmin@yopmail.com'])->first();
            $adminEmail = $admin->email;
            $superadminEmail = 'superadmin@yopmail.com';
            $asses_email = Auth::user()->email;


            //Mail sending scripts starts here
            /* $assessorToAdminSingle = [
            'title' =>'You Have Received a Report of this Application from Assessor Successfully!!!!',
            'body' => $request->sec_email,
            'status' =>$mailstatus,
            ];*/

            $mailData =
                [
                    'from' => "T.P",
                    'applicationNo' => $request->application_id,
                    'applicationStatus' => "Application Assessor to Admin",
                    'subject' => "You Have Received a Report of this Application from Assessor Successfully",
                ];

            $application_id = $request->application_id;
            $username = "Auth::user()->firstname TP Name";

            Mail::to([$superadminEmail, $adminEmail])->send(new SendMail($mailData));

            /*$assessorToSingleApplication = [
            'title' =>'You Have Send a Report of this Application to Admin Successfully!!!!',

            'status' =>$mailstatus,
            ];*/
            $mailData =
                [
                    'from' => "T.P",
                    'applicationNo' => $request->application_id,
                    'applicationStatus' => "Application Assessor to Admin",
                    'subject' => "You Have Send a Report of this Application to Admin Successfully",
                ];

            Mail::to([$asses_email])->send(new SendMail($mailData));
            //Mail sending script ends here

        } elseif ($login_id == 1) {
            //return $request->course_id;
            $txt = "";
            if ($request->status == 4) {
                $txt = "Document has been approved";
            } else {
                $txt = $request->doc_comment;
            }
            $comment = new DocComment;
            $comment->doc_id = $request->doc_id;
            $comment->doc_code = $request->doc_code;
            $comment->status = $request->status;
            $comment->comments = $txt;
            $comment->course_id = $request->course_id;
            $comment->user_id = Auth::user()->id;
            $comment->save();

            //mail send
            $document = Add_Document::where('doc_id', $request->doc_code)->first();
            $user = User::where('id', $document->assessor_id)->first();

            if ($user) {
                $asses_email = $user->email;
            }

            $user = ApplicationCourse::where('id', $request->course_id)->first();

            // $user->user_id;

            if ($request->status == 1) {
                $mailstatus = "Approved";
            } else {
                $mailstatus = "Not Approved";
            }
            $admin = user::where('role', '1')->orderBy('id', 'DESC')->whereNotIn('id', ['superadmin@yopmail.com'])->first();

            $adminEmail = $admin->email;
            $superadminEmail = 'superadmin@yopmail.com';
            /* $dasses_email = "my@yopmail.com";*/


            //Mail sending scripts starts here


            $mailData =
                [
                    'from' => "Admin",
                    'applicationNo' => $request->application_id,
                    'applicationStatus' => "Application Admin to Assessor",
                    'subject' => "You Have Send a Report of this Application to Assessor Successfully",
                ];

            Mail::to([$superadminEmail, $adminEmail])->send(new SendMail($mailData));


            $mailData =
                [
                    'from' => "Admin",
                    'applicationNo' => $request->application_id,
                    'applicationStatus' => "Application Admin to Assessor",
                    'subject' => "You Have Received a Report of this Application From Admin Successfully",
                ];

            Mail::to([$asses_email])->send(new SendMail($mailData));
            //Mail sending script ends here

        }
        return redirect("$request->previous_url")->with('success', 'Comment Added on this Documents Successfully');
    }


    public function getCourseSummariesList(Request $request){
        $courses = ApplicationCourse::where('application_id', $request->input('application'))->get();
        $applicationDetails = Application::find($request->input('application'));
        return view('tp-admin-summary.course-summary-list', compact('courses', 'applicationDetails'));
    }


    public function tpViewFinalSummary(Request $request){
        $application_id = $request->input('application');
        $application_course_id = $request->input('course');


        $summeryReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.Person_Name','app.application_uid','app.created_at as app_created_at','app_course.course_name','usr.firstname','usr.lastname')
        ->leftJoin('applications as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => $application_id,
            'asr.application_course_id' => $application_course_id,
            'app_course.application_id' => $application_id,
            'app_course.id' => $application_course_id,
            'asr.assessor_type' => 'desktop',
        ])
        ->first();

        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$summeryReport->assessor_id,'application_id'=>$application_id])->count();
  
  
    $questions = DB::table('questions')->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
            $value = DB::table('assessor_summary_reports')->where([
                'application_id' => $application_id,
                'assessor_id' => $summeryReport->assessor_id,
                'object_element_id' => $question->id,
                'doc_sr_code' => $question->code,
            ])->get();
                $obj->nc = $value;
                $final_data[] = $obj;
            
    }
    $assessement_way = DB::table('asessor_applications')->where(['application_id'=>$application_id])->get();

    // dd($assessement_way);

       /*On Site Final Summary Report*/
        $onsiteSummaryReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.Person_Name','app.application_uid','app.created_at as app_created_at','app_course.course_name','usr.firstname','usr.middlename','usr.lastname','ass_impr_form.assessee_org','ass_impr_form.sr_no','ass_impr_form.improvement_form','ass_impr_form.standard_reference','ass_impr_form.standard_reference','final_summary_repo.brief_open_meeting','final_summary_repo.brief_summary','final_summary_repo.brief_closing_meeting','final_summary_repo.summary_date','final_summary_repo.assessee_org as onsite_assessee_org')
        ->leftJoin('applications as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->leftJoin('assessor_improvement_form as ass_impr_form', 'ass_impr_form.assessor_id', '=', 'asr.assessor_id')
        ->leftJoin('assessor_final_summary_reports as final_summary_repo', 'final_summary_repo.assessor_id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => $application_id,
            // 'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' => $application_course_id,
            'app_course.application_id' => $application_id,
            'app_course.id' => $application_course_id,
            'asr.assessor_type' => 'onsite',
            // 'ass_impr_form.assessor_id'=>$assessor_id,
            'ass_impr_form.application_id'=>$application_id,
            'ass_impr_form.application_course_id'=>$application_course_id,
            // 'final_summary_repo.assessor_id'=>$assessor_id,
            'final_summary_repo.application_id'=>$application_id,
            'final_summary_repo.application_course_id'=>$application_course_id,
        ])
        ->first();
        /*count the no of mandays*/
        $onsite_no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$onsiteSummaryReport->assessor_id,'application_id'=>$application_id])->count();
  

    $questions = DB::table('questions')->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;

            $value = DB::table('assessor_summary_reports')->where([
                'application_id' => $application_id,
                'assessor_id' => $onsiteSummaryReport->assessor_id,
                'object_element_id' => $question->id,
                'doc_sr_code' => $question->code,
            ])->get();
                $obj->nc = $value;
                $onsite_final_data[] = $obj;
            
    }


        $onsite_assessement_way = DB::table('asessor_applications')->where(['assessor_id'=>$onsiteSummaryReport->assessor_id,'application_id'=>$application_id])->first()->assessment_way;

       
      
      /*End here*/    

        return view('tp-admin-summary.tp-view-final-summary',compact('summeryReport', 'no_of_mandays','final_data','assessement_way','onsiteSummaryReport','onsite_no_of_mandays','onsite_final_data','onsite_assessement_way'));
    }
    public function adminViewFinalSummary(Request $request){
        $application_id = $request->input('application');
        $application_course_id = $request->input('course');


        $summeryReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.Person_Name','app.application_uid','app.created_at as app_created_at','app_course.course_name','usr.firstname','usr.lastname')
        ->leftJoin('applications as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => $application_id,
            'asr.application_course_id' => $application_course_id,
            'app_course.application_id' => $application_id,
            'app_course.id' => $application_course_id,
            'asr.assessor_type' => 'desktop',
        ])
        ->first();
            // dd($summeryReport);
        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$summeryReport->assessor_id,'application_id'=>$application_id])->count();
  
  
    $questions = DB::table('questions')->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
            $value = DB::table('assessor_summary_reports')->where([
                'application_id' => $application_id,
                'assessor_id' => $summeryReport->assessor_id,
                'object_element_id' => $question->id,
                'doc_sr_code' => $question->code,
            ])->get();
                $obj->nc = $value;
                $final_data[] = $obj;
            
    }
    $assessement_way = DB::table('asessor_applications')->where(['application_id'=>$application_id])->get();



       /*On Site Final Summary Report*/
        $onsiteSummaryReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.Person_Name','app.application_uid','app.created_at as app_created_at','app_course.course_name','usr.firstname','usr.middlename','usr.lastname','ass_impr_form.assessee_org','ass_impr_form.sr_no','ass_impr_form.improvement_form','ass_impr_form.standard_reference','ass_impr_form.standard_reference','final_summary_repo.brief_open_meeting','final_summary_repo.brief_summary','final_summary_repo.brief_closing_meeting','final_summary_repo.summary_date','final_summary_repo.assessee_org as onsite_assessee_org')
        ->leftJoin('applications as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->leftJoin('assessor_improvement_form as ass_impr_form', 'ass_impr_form.assessor_id', '=', 'asr.assessor_id')
        ->leftJoin('assessor_final_summary_reports as final_summary_repo', 'final_summary_repo.assessor_id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => $application_id,
            // 'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' => $application_course_id,
            'app_course.application_id' => $application_id,
            'app_course.id' => $application_course_id,
            'asr.assessor_type' => 'onsite',
            // 'ass_impr_form.assessor_id'=>$assessor_id,
            'ass_impr_form.application_id'=>$application_id,
            'ass_impr_form.application_course_id'=>$application_course_id,
            // 'final_summary_repo.assessor_id'=>$assessor_id,
            'final_summary_repo.application_id'=>$application_id,
            'final_summary_repo.application_course_id'=>$application_course_id,
        ])
        ->first();
        /*count the no of mandays*/
        $onsite_no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$onsiteSummaryReport->assessor_id,'application_id'=>$application_id])->count();
  

    $questions = DB::table('questions')->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;

            $value = DB::table('assessor_summary_reports')->where([
                'application_id' => $application_id,
                'assessor_id' => $onsiteSummaryReport->assessor_id,
                'object_element_id' => $question->id,
                'doc_sr_code' => $question->code,
            ])->get();
                $obj->nc = $value;
                $onsite_final_data[] = $obj;
            
    }


        $onsite_assessement_way = DB::table('asessor_applications')->where(['assessor_id'=>$onsiteSummaryReport->assessor_id,'application_id'=>$application_id])->first()->assessment_way;

       
      
      /*End here*/    

        return view('tp-admin-summary.admin-view-final-summary',compact('summeryReport', 'no_of_mandays','final_data','assessement_way','onsiteSummaryReport','onsite_no_of_mandays','onsite_final_data','onsite_assessement_way'));
    }
}