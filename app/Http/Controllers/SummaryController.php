<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SummaryController extends Controller
{
    public function desktopIndex(){
        return view('assessor-summary.desktop-view-summary');
    }

    public function onSiteIndex(Request $request){
        return view('assessor-summary.on-site-view-summary');
    }

    public function desktopSubmitSummary(Request $request){
        return view('assessor-summary.desktop-submit-summary');
    }

    public function onSiteSubmitSummary(Request $request){
        return view('assessor-summary.on-site-submit-summary');
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
        $data['remark'] = $request->remarks;
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


        // return $add_doc_verify_by_assessor=Add_Document::find($request->doc_id);

        return redirect("$request->previous_url")->with('success', 'Comment Added on this Documents Successfully');
    }
}