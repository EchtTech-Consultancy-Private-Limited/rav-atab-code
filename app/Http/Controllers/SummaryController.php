<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\ApplicationCourse;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\TblApplication; 
use App\Models\TblApplicationCourses; 
use App\Models\TblNCComments; 
use DB;
use Carbon\Carbon;
use Auth;
use App\Jobs\SendEmailJob;
class SummaryController extends Controller
{
    public function desktopIndex(Request $request,$application_id,$application_course_id){
        $assessor_id = Auth::user()->id;
        $final_data = array();
        $summertReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id','asr.application_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.person_name','app_course.course_name','app.uhid','app.created_at','usr.firstname','usr.middlename','usr.lastname')
        ->leftJoin('tbl_application as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('tbl_application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => dDecrypt($application_id),
            'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' => dDecrypt($application_course_id),
            'app_course.application_id' => dDecrypt($application_id),
            'app_course.id' => dDecrypt($application_course_id),
            'asr.assessor_type' => 'desktop',
        ])
        ->first();
        $assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id'=>dDecrypt($application_id),'assessor_id'=>$assessor_id,'assessor_type'=>'desktop'])->first();
        
        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_id'=>$assessor_id,'application_id'=>dDecrypt($application_id)])->count();
        /*get distinct question id*/
        $assesor_distinct_report = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id','asr.assessor_id','asr.object_element_id')
        ->where('asr.assessor_type','desktop')
        ->where(['application_id' => dDecrypt($application_id), 'assessor_id' => $assessor_id])
        ->whereIn('nc_raise_code', ['NC1', 'NC2'])
        ->groupBy('asr.application_id','asr.assessor_id','asr.object_element_id')
        ->get()->pluck('object_element_id');
        /*end here*/
    $questions = DB::table('questions')->whereIn('id',$assesor_distinct_report)->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
            // $value = DB::table('assessor_summary_reports')->where([
            //     'application_id' => dDecrypt($application_id),
            //     'assessor_id' => $assessor_id,
            //     'application_course_id'=>dDecrypt($application_course_id),
            //     'object_element_id' => $question->id,
            //     'doc_sr_code' => $question->code,
            // ])->get();

            $value = TblNCComments::where([
                'application_id' =>  dDecrypt($application_id),
                'application_courses_id' =>  dDecrypt($application_course_id),
                'assessor_id' => $assessor_id,
                'doc_unique_id' => $question->id,
                'doc_sr_code' => $question->code
            ])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->get();


                $obj->nc = $value;
                $final_data[] = $obj;
    }
    $assessement_way="N/A";
       $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>dDecrypt($application_id),'application_course_id'=>dDecrypt($application_course_id)])->first();
       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }
       
    //    dd($final_data);
        return view('assessor-summary.desktop-view-summary',compact('summertReport', 'no_of_mandays','final_data','is_final_submit','assessement_way','assessor_assign'));
    }

     public function onSiteIndex(Request $request,$application_id,$application_course_id){
        $assessor_id = Auth::user()->id;
        $assessor_name = Auth::user()->firstname.' '.Auth::user()->middlename.' '.Auth::user()->lastname;
        $summertReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.person_name','app.id','app.created_at as app_created_at','app.uhid','app_course.course_name','usr.firstname','usr.lastname','ass_impr_form.assessee_org','ass_impr_form.sr_no','ass_impr_form.improvement_form','ass_impr_form.standard_reference','final_summary_repo.brief_open_meeting','final_summary_repo.brief_summary','final_summary_repo.brief_closing_meeting','final_summary_repo.summary_date','ass_impr_form.assessee_org as onsite_assessee_org')
        ->leftJoin('tbl_application as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('tbl_application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->leftJoin('assessor_improvement_form as ass_impr_form', 'ass_impr_form.assessor_id', '=', 'asr.assessor_id')
        ->leftJoin('assessor_final_summary_reports as final_summary_repo', 'final_summary_repo.assessor_id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => dDecrypt($application_id),
            'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' => dDecrypt($application_course_id),
            'app_course.application_id' => dDecrypt($application_id),
            'app_course.id' => dDecrypt($application_course_id),
            'asr.assessor_type' => 'onsite',
            'ass_impr_form.assessor_id'=>$assessor_id,
            'ass_impr_form.application_id'=>dDecrypt($application_id),
            'ass_impr_form.application_course_id'=>dDecrypt($application_course_id),
            'final_summary_repo.assessor_id'=>$assessor_id,
            'final_summary_repo.application_id'=>dDecrypt($application_id),
            'final_summary_repo.application_course_id'=>dDecrypt($application_course_id),
        ])
        ->first();
        $assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id'=>dDecrypt($application_id),'assessor_id'=>$assessor_id,'assessor_type'=>'onsite'])->first();
        
        /*count the no of mandays*/
    $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$assessor_id,'application_id'=>dDecrypt($application_id)])->count();

    // dd(dDecrypt($application_id),dDecrypt($application_course_id),$assessor_id);
    $questions = DB::table('questions')->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
            // $value = DB::table('assessor_summary_reports')->where([
            //     'application_id' => dDecrypt($application_id),
            //     'assessor_id' => $assessor_id,
            //     'object_element_id' => $question->id,
            //     'doc_sr_code' => $question->code,
            //     'application_course_id' => dDecrypt($application_course_id)
            // ])->get();

            $value = TblNCComments::where([
                'application_id' =>  dDecrypt($application_id),
                'application_courses_id' =>  dDecrypt($application_course_id),
                'assessor_id' => $assessor_id,
                'doc_unique_id' => $question->id,
                'doc_sr_code' => $question->code
            ])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->get();

                $obj->nc = $value;
                $final_data[] = $obj;
    }   
       $assessement_way = DB::table('asessor_applications')->where(['assessor_id'=>$assessor_id,'application_id'=>$summertReport->application_id])->first()->assessment_way;
       $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>dDecrypt($application_id),'application_course_id'=>dDecrypt($application_course_id)])->first();
       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }
       
    //    dd("tbl_nc_comments");
        return view('assessor-summary.on-site-view-summary',compact('summertReport', 'no_of_mandays','final_data','is_final_submit','assessor_name','assessement_way','assessor_assign'));
    }


    public function desktopSubmitSummary(Request $request,$application_id,$application_course_id){
        $assessor_id = Auth::user()->id;
        $summertReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.person_name','app.id','app.created_at as app_created_at','app_course.course_name','usr.firstname','usr.lastname')
        ->leftJoin('tbl_application as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('tbl_application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => dDecrypt($application_id),
            'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' => dDecrypt($application_course_id),
            'app_course.application_id' => dDecrypt($application_id),
            'app_course.id' => dDecrypt($application_course_id),
            'asr.assessor_type'=>'desktop'
            ])
            ->first();
            
            $assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id'=>dDecrypt($application_id),'assessor_id'=>$assessor_id,'assessor_type'=>'desktop'])->first();

        /*count the no of mandays*/
        $no_of_mandays = DB::table('tbl_assessor_assign')->where(['assessor_Id'=>$summertReport->assessor_id,'application_id'=>$summertReport->application_id])->count();

    $assesor_distinct_report = DB::table('assessor_summary_reports as asr')
    ->select('asr.application_id','asr.assessor_id','asr.object_element_id')
    ->where('asr.assessor_type','desktop')
    ->where(['application_id' => dDecrypt($application_id), 'assessor_id' => $assessor_id])
    ->whereIn('nc_raise_code', ['NC1', 'NC2'])
    ->groupBy('asr.application_id','asr.assessor_id','asr.object_element_id')
    ->get()->pluck('object_element_id');
    $questions = DB::table('questions')->whereIn('id',$assesor_distinct_report)->get();

    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
            // $value = DB::table('assessor_summary_reports')->where([
            //     'application_id' => dDecrypt($application_id),
            //     'assessor_id' => $assessor_id,
            //     'object_element_id' => $question->id,
            //     'doc_sr_code' => $question->code,
            //     'nc_raise_code'=>['NC1', 'NC2'],
            //     'application_course_id' =>$request->application_course_id,
            //     'assessor_type'=>'desktop'
            // ])->get();

            $value =  TblNCComments::where([
                'application_id' => dDecrypt($application_id),
                'application_courses_id' => dDecrypt($application_course_id),
                'doc_unique_id' => $question->id,
                'nc_type'=>['NC1', 'NC2'],
                'assessor_type'=>'desktop',
                'doc_sr_code' => $question->code
            ])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->where('assessor_type','desktop')
            ->get();

                $obj->nc = $value;
                $final_data[] = $obj;
    }
       $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>dDecrypt($application_id),'application_course_id'=>dDecrypt($application_course_id),'assessor_id'=>$assessor_id])->first();
       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }
        return view('assessor-summary.desktop-submit-summary', compact('summertReport', 'no_of_mandays','final_data','is_final_submit','assessor_assign'));
    }

   
    public function desktopFinalSubmitSummaryReport(Request $request,$application_id,$application_course_id){
        $check_report = DB::table('assessor_final_summary_reports')->where(['application_id' => dDecrypt($application_id),'application_course_id' => dDecrypt($application_course_id),'assessor_type'=>'desktop'])->first();
        $tbl_application = DB::table('tbl_application')->where('id',dDecrypt($application_id))->first();
        if(!empty($check_report)){
            return back()->with('fail', 'This application record already submitted');
        }
        $assessor_id = Auth::user()->id;
        $data = [];
        $data['application_id']=dDecrypt($application_id);
        $data['assessor_id']=$assessor_id;
        $data['application_course_id']=dDecrypt($application_course_id);
        $data['assessor_type']='desktop';
        $create_final_summary_report=DB::table('assessor_final_summary_reports')->insert($data);
        $application_id = dDecrypt($application_id);
        /*Mail to assessor*/
            $title=" Assignment Confirmation - Welcome Aboard! | RAVAP-".$application_id;
            $subject="Assignment Confirmation - Welcome Aboard! | RAVAP-".$application_id;

            $body = "Dear Team, ".PHP_EOL."
            I hope this message finds you well. It is with great pleasure that I inform you that your application of RAVAP-".$application_id." has been thoroughly reviewed and approved.

            Application Details:".PHP_EOL."

            Application ID: RAVAP-".$tbl_application->uhid." ".PHP_EOL."
            Application Date: ".$tbl_application->created_at."".PHP_EOL."

            Best regards,".PHP_EOL."
            RAV Team";

            $details['email'] = Auth::user()->email;
            $details['title'] = $title; 
            $details['subject'] = $subject; 
            $details['body'] = $body; 
            dispatch(new SendEmailJob($details));

            /*end here*/

            /*Mail to tp*/
            $tp_users = DB::table('users')->where('id',$tbl_application->tp_id)->first();

            $title="Application Approved - Congratulations! | RAVAP-".$tbl_application->uhid;
            $subject="Application Approved - Congratulations! | RAVAP-".$tbl_application->uhid;

            $body = "Dear Team, ".PHP_EOL."
            I hope this message finds you well. It is with great pleasure that I inform you that your application of RAVAP-".$tbl_application->uhid." has been thoroughly reviewed and approved.

            Application Details:".PHP_EOL."

            Application ID: RAVAP-".$tbl_application->uhid." ".PHP_EOL."
            Application Date: ".$tbl_application->created_at."".PHP_EOL."

            Your qualifications, experience, and enthusiasm have made a significant impression on our selection committee, and we are delighted to welcome you to RAVAP. Congratulations on this achievement!".PHP_EOL."

            Best regards,".PHP_EOL."
            RAV Team";

            $details['email'] = $tp_users->email;
            $details['title'] = $title; 
            $details['subject'] = $subject; 
            $details['body'] = $body; 
            dispatch(new SendEmailJob($details));

            /*end here*/

             /*Mail to admin*/
             $admin = DB::table('tbl_application')->where('id',$application_id)->first();
             $admin_users = DB::table('users')->where('id',$admin->admin_id)->first();
             $title="Application Successfully Assigned | RAVAP-".$tbl_application->uhid;
             $subject="Application Successfully Assigned | RAVAP-".$tbl_application->uhid;
 
             $body = "Dear Team, ".PHP_EOL."
             I hope this message finds you well. It is with great pleasure that I inform you that your application of RAVAP-".$tbl_application->uhid." has been thoroughly reviewed and approved.
 
             Application Details:".PHP_EOL."
 
             Application ID: RAVAP-".$tbl_application->uhid." ".PHP_EOL."
             Application Date: ".$tbl_application->created_at."".PHP_EOL."
 
             Best regards,".PHP_EOL."
             RAV Team";
 
             $details['email'] = $admin_users->email;
             $details['title'] = $title; 
             $details['subject'] = $subject; 
             $details['body'] = $body; 
             dispatch(new SendEmailJob($details));
 
             /*end here*/


        return redirect('desktop/application-view'.'/'.$request->application_id)->with('success','Successfully submitted final summary report'); 
        // return redirect('desktop/document-list'.'/'.$application_id.'/'.$application_course_id); 

    }
       
    public function onSiteFinalSubmitSummaryReport(Request $request){
        try{
            DB::beginTransaction();
            $application_id = dDecrypt($request->application_id);
            $check_report = DB::table('assessor_final_summary_reports')->where(['application_id' => $application_id,'application_course_id' => dDecrypt($request->application_course_id),'assessor_type'=>'onsite'])->first();
            $tbl_application = DB::table('tbl_application')->where('id',$application_id)->first();
            if(!empty($check_report)){
                return back()->with('fail', 'This application record already submitted');
            }
            $assessor_id = Auth::user()->id;
            $data = [];
            $data['application_id']=$application_id;
            $data['assessor_id']=$assessor_id;
            $data['application_course_id']=dDecrypt($request->application_course_id);
            $data['assessor_type']='onsite';
            $data['brief_open_meeting']=$request->brief_open_meeting??'N/A';
            $data['brief_summary']=$request->brief_summary??'N/A';
            $data['brief_closing_meeting']=$request->brief_closing_meeting??'N/A';
            $data['assessee_org']=$request->assessee_org??'N/A';
            $data['summary_date']=$request->summary_date??Carbon::now();
            $create_final_summary_report=DB::table('assessor_final_summary_reports')->insert($data);
            $dataImprovement= [];
            $dataImprovement['assessor_id']=$assessor_id;
            $dataImprovement['application_id']=$application_id;
            $dataImprovement['application_course_id']=dDecrypt($request->application_course_id);
            $dataImprovement['sr_no']=$request->sr_no??'N/A';
            $dataImprovement['standard_reference']=$request->standard_reference??'N/A';
            $dataImprovement['improvement_form']=$request->improvement_form??'N/A';
            $dataImprovement['signatures']=$request->signatures??'N/A';
            $dataImprovement['signatures_of_team_leader']=$request->signatures_of_team_leader??'N/A';
            $dataImprovement['assessee_org']=$request->improve_assessee_org??'N/A';
            $create_onsite_final_summary_report=DB::table('assessor_improvement_form')->insert($dataImprovement);
        
            /*Completed the application and make the app payment_status =3 for completed*/
                DB::table('tbl_application')->where('id',$application_id)->update(['payment_status'=>3]);
            /*end here*/



            /*Mail to assessor*/
            $title=" Assignment Confirmation - Welcome Aboard! | RAVAP-".$application_id;
            $subject="Assignment Confirmation - Welcome Aboard! | RAVAP-".$application_id;

            $body = "Dear Team, ".PHP_EOL."
            I hope this message finds you well. It is with great pleasure that I inform you that your application of RAVAP-".$application_id." has been thoroughly reviewed and approved.

            Application Details:".PHP_EOL."

            Application ID: RAVAP-".$application_id." ".PHP_EOL."
            Application Date: ".$tbl_application->created_at."".PHP_EOL."

            Best regards,".PHP_EOL."
            RAV Team";

            $details['email'] = Auth::user()->email;
            $details['title'] = $title; 
            $details['subject'] = $subject; 
            $details['body'] = $body; 
            dispatch(new SendEmailJob($details));

            /*end here*/

            /*Mail to tp*/
            $tp_users = DB::table('users')->where('id',$tbl_application->tp_id)->first();
            
            $title="Application Approved - Congratulations! | RAVAP-".$application_id;
            $subject="Application Approved - Congratulations! | RAVAP-".$application_id;

            $body = "Dear Team, ".PHP_EOL."
            I hope this message finds you well. It is with great pleasure that I inform you that your application of RAVAP-".$application_id." has been thoroughly reviewed and approved.

            Application Details:".PHP_EOL."

            Application ID: RAVAP-".$application_id." ".PHP_EOL."
            Application Date: ".$tbl_application->created_at."".PHP_EOL."

            Your qualifications, experience, and enthusiasm have made a significant impression on our selection committee, and we are delighted to welcome you to RAVAP. Congratulations on this achievement!".PHP_EOL."

            Best regards,".PHP_EOL."
            RAV Team";

            $details['email'] = $tp_users->email;
            $details['title'] = $title; 
            $details['subject'] = $subject; 
            $details['body'] = $body; 
            dispatch(new SendEmailJob($details));

            /*end here*/

            /*Mail to admin*/
            $admin = DB::table('tbl_application')->where('id',$application_id)->first();
            $admin_users = DB::table('users')->where('id',$admin->admin_id)->first();
            $title="Application Successfully Assigned | RAVAP-".$application_id;
            $subject="Application Successfully Assigned | RAVAP-".$application_id;

            $body = "Dear Team, ".PHP_EOL."
            I hope this message finds you well. It is with great pleasure that I inform you that your application of RAVAP-".$application_id." has been thoroughly reviewed and approved.

            Application Details:".PHP_EOL."

            Application ID: RAVAP-".$application_id." ".PHP_EOL."
            Application Date: ".$tbl_application->created_at."".PHP_EOL."

            Best regards,".PHP_EOL."
            RAV Team";

            $details['email'] = $admin_users->email;
            $details['title'] = $title; 
            $details['subject'] = $subject; 
            $details['body'] = $body; 
            dispatch(new SendEmailJob($details));

            /*end here*/



            DB::commit();
            return redirect('onsite/application-view'.'/'.$request->application_id)->with('success','Successfully submitted final summary report'); 
        }
        catch(Exception $e){
            DB::rollback();
            return redirect('onsite/application-view'.'/'.$request->application_id)->with('success','Successfully submitted final summary report');  

        }

        // return redirect(url('accr-view-document/' . $request->application_id . '/' . $request->application_course_id))->with('success', "Data saved successfully");
    }

    // view summary report
    public function onSiteSubmitSummary(Request $request,$application_id,$application_course_id){
        $assessor_id = Auth::user()->id;
        $assessor_name = Auth::user()->firstname.' '.Auth::user()->middlename.' '.Auth::user()->lastname;
        $summertReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.person_name','app.id','app.created_at as app_created_at','app.uhid','app_course.course_name','usr.firstname','usr.lastname')
        ->leftJoin('tbl_application as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('tbl_application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => dDecrypt($application_id),
            'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' =>dDecrypt($application_course_id),
            'app_course.application_id' => dDecrypt($application_id),
            'app_course.id' =>dDecrypt($application_course_id),
            'asr.assessor_type'=>'onsite',
        ])
        ->first();
        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=> $assessor_id,'application_id'=> dDecrypt($application_id)])->count();
        $assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id'=>dDecrypt($application_id),'assessor_id'=>$assessor_id,'assessor_type'=>'onsite'])->first();

    $assesor_distinct_report = DB::table('assessor_summary_reports as asr')
    ->select('asr.application_id','asr.assessor_id','asr.object_element_id')
    ->where('asr.assessor_type','onsite')
    ->where(['asr.application_id' => dDecrypt($application_id), 'asr.assessor_id' => $assessor_id,
    'asr.application_course_id'=>dDecrypt($application_course_id)])
    ->whereIn('asr.nc_raise_code', ['NC1', 'NC2'])
    ->groupBy('asr.application_id','asr.assessor_id','asr.object_element_id')
    ->get()->pluck('object_element_id');

    //  dd($assesor_distinct_report);

    $assessement_way = DB::table('asessor_applications')->where(['assessor_id'=>$assessor_id,'application_id'=>dDecrypt($application_id)])->first()->assessment_way;
    $questions = DB::table('questions')->whereIn('id',$assesor_distinct_report)->get();

    $final_data=[];
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
            // $value = DB::table('assessor_summary_reports')->where([
            //     'application_id' => dDecrypt($application_id),
            //     'application_course_id' => dDecrypt($application_course_id),
            //     'assessor_id' => $assessor_id,
            //     'object_element_id' => $question->id,
            //     'doc_sr_code' => $question->code,
            //     'assessor_type'=>'onsite'
            // ])->get();

            $value =  TblNCComments::where([
                'application_id' => dDecrypt($application_id),
                'application_courses_id' => dDecrypt($application_course_id),
                'doc_unique_id' => $question->id,
                // 'nc_type'=>['NC1', 'NC2'],
                'assessor_type'=>'onsite',
                'doc_sr_code' => $question->code
            ])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->where('assessor_type','onsite')
            ->get();

                $obj->nc = $value;
                $final_data[] = $obj;
    }
       $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>dDecrypt($application_id),'application_course_id'=>$request->application_course_id])->first();
       if(!empty($is_exists)){
        $is_final_submit = true;
       }else{
        $is_final_submit = false;
       }
        return view('assessor-summary.on-site-submit-summary', compact('summertReport', 'no_of_mandays','final_data','is_final_submit','assessor_name','assessement_way','assessor_assign'));
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
        $courses = TblApplicationCourses::where('application_id', $request->input('application'))->get();

        $applicationDetails = TblApplication::find($request->input('application'));
        return view('tp-admin-summary.course-summary-list', compact('courses', 'applicationDetails'));
    }


    public function tpViewFinalSummary(Request $request){
        $application_id = $request->input('application');
        $application_course_id = $request->input('course');
        $summeryReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.person_name','app.id','app.created_at as app_created_at','app.uhid','app_course.course_name','usr.firstname','usr.lastname')
        ->leftJoin('tbl_application as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('tbl_application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
        ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
        ->where([
            'asr.application_id' => $application_id,
            'asr.application_course_id' => $application_course_id,
            'app_course.application_id' => $application_id,
            'app_course.id' => $application_course_id,
            'asr.assessor_type' => 'desktop',
        ])
        ->first();
        $assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id'=>$application_id])->get();
        
        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$summeryReport->assessor_id,'application_id'=>$application_id])->count();
    $questions = DB::table('questions')->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
           
            $value = TblNCComments::where([
                'application_id' => $application_id,
                'assessor_id' => $summeryReport->assessor_id,
                'application_courses_id' => $application_course_id,
                'doc_unique_id' => $question->id,
                'doc_sr_code' => $question->code
            ])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->where('assessor_type','desktop')
            ->get();
                $obj->nc = $value;
                $final_data[] = $obj;
    }
    $assessement_way = DB::table('asessor_applications')->where(['application_id'=>$application_id])->get();
       /*On Site Final Summary Report*/
        $onsiteSummaryReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.person_name','app.id','app.created_at as app_created_at','app.uhid','app_course.course_name','usr.firstname','usr.middlename','usr.lastname','ass_impr_form.assessee_org','ass_impr_form.sr_no','ass_impr_form.improvement_form','ass_impr_form.standard_reference','ass_impr_form.standard_reference','final_summary_repo.brief_open_meeting','final_summary_repo.brief_summary','final_summary_repo.brief_closing_meeting','final_summary_repo.summary_date','final_summary_repo.assessee_org as onsite_assessee_org')
        ->leftJoin('tbl_application as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('tbl_application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
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
            // dd($onsiteSummaryReport);

        /*count the no of mandays*/
        $onsite_no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$onsiteSummaryReport->assessor_id,'application_id'=>$application_id])->count();
        
    $questions = DB::table('questions')->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
            $value = TblNCComments::where([
                'application_id' => $application_id,
                'assessor_id' => $onsiteSummaryReport->assessor_id,
                'application_courses_id' => $application_course_id,
                'doc_unique_id' => $question->id,
                'doc_sr_code' => $question->code
            ])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->where('assessor_type','onsite')
            ->get();
                $obj->nc = $value;
                $onsite_final_data[] = $obj;
    }

       
        $onsite_assessement_way = DB::table('asessor_applications')->where(['assessor_id'=>$onsiteSummaryReport->assessor_id,'application_id'=>$application_id])->first()->assessment_way;
      /*End here*/    
        return view('tp-admin-summary.tp-view-final-summary',compact('summeryReport', 'no_of_mandays','final_data','assessement_way','onsiteSummaryReport','onsite_no_of_mandays','onsite_final_data','onsite_assessement_way','assessor_assign'));
    }


    public function adminViewFinalSummary(Request $request){
        $application_id = $request->input('application');
        $application_course_id = $request->input('course');
        $summeryReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.person_name','app.id','app.created_at as app_created_at','app.uhid','app_course.course_name','usr.firstname','usr.lastname')
        ->leftJoin('tbl_application as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('tbl_application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
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
            $assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id'=>$application_id])->get();

        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$summeryReport->assessor_id,'application_id'=>$application_id])->count();
    $questions = DB::table('questions')->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
           
            $value = TblNCComments::where([
                'application_id' => $application_id,
                'assessor_id' => $summeryReport->assessor_id,
                'application_courses_id' => $application_course_id,
                'doc_unique_id' => $question->id,
                'doc_sr_code' => $question->code
            ])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->where('assessor_type','desktop')
            ->get();
                $obj->nc = $value;
                $final_data[] = $obj;
    }
     
    $assessement_way = DB::table('asessor_applications')->where(['application_id'=>$application_id])->get();
       /*On Site Final Summary Report*/
        $onsiteSummaryReport = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id','asr.assessor_type','asr.object_element_id', 'app.person_name','app.id','app.created_at as app_created_at','app.uhid','app_course.course_name','usr.firstname','usr.middlename','usr.lastname','ass_impr_form.assessee_org','ass_impr_form.sr_no','ass_impr_form.improvement_form','ass_impr_form.standard_reference','ass_impr_form.standard_reference','final_summary_repo.brief_open_meeting','final_summary_repo.brief_summary','final_summary_repo.brief_closing_meeting','final_summary_repo.summary_date','final_summary_repo.assessee_org as onsite_assessee_org')
        ->leftJoin('tbl_application as app', 'app.id', '=', 'asr.application_id')
        ->leftJoin('tbl_application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
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
            // dd($onsiteSummaryReport);

        /*count the no of mandays*/
        $onsite_no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id'=>$onsiteSummaryReport->assessor_id,'application_id'=>$application_id])->count();
    $questions = DB::table('questions')->get();
    foreach($questions as $question){
        $obj = new \stdClass;
        $obj->title= $question->title;
        $obj->code= $question->code;
            $value = TblNCComments::where([
                'application_id' => $application_id,
                'assessor_id' => $onsiteSummaryReport->assessor_id,
                'application_courses_id' => $application_course_id,
                'doc_unique_id' => $question->id,
                'doc_sr_code' => $question->code
            ])
            ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            ->where('assessor_type','onsite')
            ->get();
                $obj->nc = $value;
                $onsite_final_data[] = $obj;
    }
        $onsite_assessement_way = DB::table('asessor_applications')->where(['assessor_id'=>$onsiteSummaryReport->assessor_id,'application_id'=>$application_id])->first()->assessment_way;
      /*End here*/    
      
        return view('tp-admin-summary.admin-view-final-summary',compact('summeryReport', 'no_of_mandays','final_data','assessement_way','onsiteSummaryReport','onsite_no_of_mandays','onsite_final_data','onsite_assessement_way','assessor_assign'));
    }
}