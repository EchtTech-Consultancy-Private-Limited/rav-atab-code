<?php
namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Models\TblApplication;
use App\Models\TblApplicationPayment;
use App\Models\TblApplicationCourseDoc;
use App\Models\TblApplicationCourses;
use App\Http\Helpers\ApplicationDurationCaculate;
use App\Models\Chapter;
use App\Models\TblNCComments;
use URL;
use App\Jobs\SendEmailJob;
class DesktopApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /** Application List For Account */
    public function getApplicationList()
    {
        
        $assessor_id = Auth::user()->id;
        $assessor_application = DB::table('tbl_assessor_assign')
            ->where('assessor_id', $assessor_id)
            ->pluck('application_id')->toArray();
        $final_data = array();
        $application = DB::table('tbl_application')
            ->whereIn('payment_status', [1, 2, 3, 5])
            ->whereIn('id', $assessor_application)
            ->where('region','ind')
            ->orderBy('id', 'desc')
            ->get();
        foreach ($application as $app) {
            $obj = new \stdClass;
            $obj->application_list = $app;
            $course = DB::table('tbl_application_courses')->where([
                'application_id' => $app->id,
            ])
                ->whereNull('deleted_at')
                ->count();
            if ($course) {
                $obj->course_count = $course;
            }
            $payment = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
                'payment_ext'=>null,
                'pay_status'=>'Y'
            ])->latest('created_at')->first();
            $payment_amount = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
                'payment_ext'=>null,
                'pay_status'=>'Y'
            ])->sum('amount');
            $payment_count = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
                'payment_ext'=>null,
                'pay_status'=>'Y'
            ])->count();
            if ($payment) {
                $obj->payment = $payment;
                $obj->payment->payment_count = $payment_count;
                $obj->payment->payment_amount = $payment_amount;
            }

            $appTime = new ApplicationDurationCaculate;
            $application_duration_accept_doc =$appTime->calculateTimeDateDesktopAssessorAcceptDoc(auth::user()->id, auth::user()->role,'recieved_document_same_assign_date',$app);
            $obj->application_duration_accept_doc = $application_duration_accept_doc;

            $application_duration_verify_doc =$appTime->calculateTimeDateDesktopAssessorVerifyDoc(auth::user()->id, auth::user()->role,'document_check',$app);
            $obj->application_duration_verify_doc = $application_duration_verify_doc;

            $final_data[] = $obj;
        }
       
        return view('desktop-view.application-list', ['list' => $final_data]);
    }

    public function getInternationalApplicationList(Request $request)
    {
        if($request->get('type')=='other-world'){
            $region_type = 'other';
        }else {
            $region_type = 'saarc';
        }
        
        $assessor_id = Auth::user()->id;
        $assessor_application = DB::table('tbl_assessor_assign')
            ->where('assessor_id', $assessor_id)
            ->pluck('application_id')->toArray();
        $final_data = array();
        $application = DB::table('tbl_application')
            ->whereIn('payment_status', [1, 2, 3, 5])
            ->whereIn('id', $assessor_application)
            ->where('region',$region_type)
            ->orderBy('id', 'desc')
            ->get();
            
        foreach ($application as $app) {
            $obj = new \stdClass;
            $obj->application_list = $app;
            $course = DB::table('tbl_application_courses')->where([
                'application_id' => $app->id,
            ])
                ->whereNull('deleted_at')
                ->count();
            if ($course) {
                $obj->course_count = $course;
            }
            $payment = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
                'payment_ext'=>null,
                'pay_status'=>'Y'
            ])->latest('created_at')->first();
            $payment_amount = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
                'payment_ext'=>null,
                'pay_status'=>'Y'
            ])->sum('amount');
            $payment_count = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
                'payment_ext'=>null,
                'pay_status'=>'Y'
            ])->count();
            if ($payment) {
                $obj->payment = $payment;
                $obj->payment->payment_count = $payment_count;
                $obj->payment->payment_amount = $payment_amount;
            }

            $appTime = new ApplicationDurationCaculate;
            $application_duration_accept_doc =$appTime->calculateTimeDateDesktopAssessorAcceptDoc(auth::user()->id, auth::user()->role,'recieved_document_same_assign_date',$app);
            $obj->application_duration_accept_doc = $application_duration_accept_doc;

            $application_duration_verify_doc =$appTime->calculateTimeDateDesktopAssessorVerifyDoc(auth::user()->id, auth::user()->role,'document_check',$app);
            $obj->application_duration_verify_doc = $application_duration_verify_doc;


            $final_data[] = $obj;
        }
       // dd($final_data);
       return view('application.accesser.internation_accesser',['list' => $final_data]);
    }
    /** Whole Application View for desktop */
    public function getApplicationView($id)
    {
        $show_submit_btn_to_desktop = $this->isShowSubmitBtnToSecretariat(dDecrypt($id));
        $enable_disable_submit_btn = $this->checkSubmitButtonEnableOrDisable(dDecrypt($id));
        $is_all_revert_action_done=$this->checkAllActionDoneOnRevert(dDecrypt($id));
        $isAllDocAccepted=$this->isAllDocAccepted(dDecrypt($id));
        $isNrButSummaryNotSubmittedYet = $this->isNrOnDesktopDocList(dDecrypt($id));
        $application = DB::table('tbl_application')
            ->where('id', dDecrypt($id))
            ->first();
        $user_data = DB::table('users')->where('users.id', $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->whereNull('payment_ext')->where('pay_status','Y')->latest('id')->first();
        $obj = new \stdClass;
        $obj->application = $application;
        $course = DB::table('tbl_application_courses')->where([
            'application_id' => $application->id,
        ])
        ->whereIn('status',[0,2])
            ->whereNull('deleted_at')
            ->get();
        if ($course) {
            $obj->course = $course;
        }
        $payment = DB::table('tbl_application_payment')->where([
            'application_id' => $application->id,
            'payment_ext'=>null,
            'pay_status'=>'Y'
        ])->get();
        if ($payment) {
            $obj->payment = $payment;
        }
        $final_data = $obj;
       
        $total_summary_count = DB::table('assessor_final_summary_reports')->where(['application_id' => $application->id,'assessor_type'=>'desktop'])->count();
        
        $is_submitted_final_summary = DB::table('assessor_final_summary_reports')->where(['application_id' => $application->id,'assessor_type'=>'desktop'])->latest('id')->first()?->is_summary_show;


        if(!isset($is_submitted_final_summary)){
            $is_submitted_final_summary=0;
        }

        
        $total_courses_count = DB::table('tbl_application_courses')->where('application_id',$application->id)->whereIn('status',[0,2])->count();
        if ($total_summary_count==$total_courses_count) {
            $is_final_submit = true;
            $is_all_course_summary_completed=true;
        } else {
            $is_final_submit = false;
            $is_all_course_summary_completed=false;
        }
        
        /*  All course summary generated*/
            
        /*end here*/
        return view('desktop-view.application-view', ['application_details' => $final_data, 'data' => $user_data, 'spocData' => $application, 'application_payment_status' => $application_payment_status, 'is_final_submit' => $is_final_submit,'show_submit_btn_to_desktop'=>$show_submit_btn_to_desktop,'enable_disable_submit_btn'=>$enable_disable_submit_btn,'is_all_revert_action_done'=>$is_all_revert_action_done,'is_all_course_summary_completed'=>$is_all_course_summary_completed,'is_submitted_final_summary'=>$is_submitted_final_summary,'isAllDocAccepted'=>$isAllDocAccepted,'isNrButSummaryNotSubmittedYet'=>$isNrButSummaryNotSubmittedYet]);
    }
    public function applicationDocumentList($id, $course_id)
    {
        
        $tp_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $application_uhid = TblApplication::where('id', $application_id)->first()->uhid ?? '';
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;
        $data = TblApplicationPayment::where('application_id', $application_id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id' => $application_id,
            'application_courses_id' => $course_id,
            'assessor_type' => 'desktop'
        ])
            ->select('id', 'doc_unique_id', 'doc_file_name', 'doc_sr_code', 'assessor_type', 'admin_nc_flag', 'status','is_revert','is_doc_show')
            ->get();
        $doc_uploaded_count = DB::table('tbl_nc_comments as asr')
            ->select("asr.application_id", "asr.application_courses_id")
            ->where('asr.assessor_type', 'desktop')
            ->where(['application_id' => $application_id, 'application_courses_id' => $course_id])
            ->groupBy('asr.application_id', 'asr.application_courses_id')
            ->count();
        /*end here*/
        $is_doc_uploaded = false;
        if ($doc_uploaded_count >= 4) {
            $is_doc_uploaded = true;
        }

        $show_submit_btn_to_secretariat = $this->isShowSubmitBtnToSecretariat($application_id);
        $enable_disable_submit_btn = $this->checkSubmitButtonEnableOrDisable($application_id);
        $is_all_revert_action_done=$this->checkAllActionDoneOnRevert($application_id);
        $checkAllActionDoneOnDocList = $this->checkAllActionDoneOnDocList($application_id,$course_id);
        $isCreateSummaryBtnShow = $this->isCreateSummaryBtnShow($application_id,$course_id);
        
        
        
        $chapters = Chapter::all();
        foreach ($chapters as $chapter) {
            $obj = new \stdClass;
            $obj->chapters = $chapter;
            $questions = DB::table('questions')->where([
                'chapter_id' => $chapter->id,
            ])->get();
            foreach ($questions as $k => $question) {
                $obj->questions[] = [
                    'question' => $question,
                    'nc_comments' => TblNCComments::where([
                        'application_id' => $application_id,
                        'application_courses_id' => $course_id,
                        'doc_unique_id' => $question->id,
                        'doc_sr_code' => $question->code
                    ])
                        ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                        ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                        ->whereIn('assessor_type', ['desktop', 'admin'])
                        ->where(function ($query) {
                            $query->where('assessor_type', 'desktop')
                                ->orWhere('assessor_type', 'admin')
                                ->where('final_status', 'desktop');
                        })
                        ->get(),
                ];
            }
            $final_data[] = $obj;
        }
        
        $is_exists = DB::table('assessor_final_summary_reports')->where(['application_id' => $application_id, 'application_course_id' => $course_id])->first();
        if (!empty($is_exists)) {
            $is_final_submit = true;
        } else {
            $is_final_submit = false;
        }
        
        $application_details = TblApplication::find($application_id);
        return view('desktop-view.application-documents-list', compact('final_data', 'course_doc_uploaded', 'application_id', 'course_id', 'is_final_submit', 'is_doc_uploaded', 'application_uhid','application_details','show_submit_btn_to_secretariat','enable_disable_submit_btn','is_all_revert_action_done','checkAllActionDoneOnDocList','isCreateSummaryBtnShow'));
    }
    public function desktopVerfiyDocument($nc_type, $doc_sr_code, $doc_name, $application_id, $doc_unique_code, $application_course_id)
    {
        $doc_sr_code = dDecrypt($doc_sr_code);
        $application_id = dDecrypt($application_id);
        $doc_unique_code= dDecrypt($doc_unique_code);
        $application_course_id= dDecrypt($application_course_id);

        try {
            $tbl_nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code, 'assessor_type' => 'desktop','application_courses_id'=> $application_course_id])->latest('id')->first();
            $is_nc_exists = false;
            // dd($tbl_nc_comments);
            if ($nc_type == "view") {
                $is_nc_exists = true;
            }
            // dd($tbl_nc_comments->nc_type,$nc_type);
            if (isset($tbl_nc_comments->nc_type)) {
                if ($tbl_nc_comments->nc_type == "NC1") {
                    $dropdown_arr = array(
                        "NC2" => "NC2",
                        "Accept" => "Accept",
                    );
                } else if ($tbl_nc_comments->nc_type == "NC2") {
                    $dropdown_arr = array(
                        "not_recommended" => "Needs Revision",
                        "Accept" => "Accept",
                    );
                } else if ($tbl_nc_comments->nc_type == "not_recommended") {
                    $dropdown_arr = array(
                        "Reject" => "Reject",
                        "Accept" => "Accept",
                    );
                } else if ($tbl_nc_comments->nc_type == "Request_For_Final_Approval") {
                    $dropdown_arr = array(
                        "Reject" => "Reject",
                        "Accept" => "Accept",
                    );
                } else {
                    $dropdown_arr = array(
                        "NC1" => "NC1",
                        "Accept" => "Accept",
                    );
                }
            } else {
                $dropdown_arr = array(
                    "NC1" => "NC1",
                    "Accept" => "Accept",
                );
            }
            if ($nc_type == "nr") {
                $nc_type = "not_recommended";
            }
            $nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code, 'nc_type' => $nc_type,'application_courses_id'=> $application_course_id])
                ->whereIn('assessor_type', ['admin', 'desktop'])
                ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                ->first();
            $doc_latest_record = TblApplicationCourseDoc::latest('id')
                ->where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code])
                ->first();
            // $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
            $doc_path = URL::to("/level") . '/' . $doc_name;
            return view('desktop-view.document-verify', [
                // 'doc_latest_record' => $doc_latest_record,
                'application_course_id' => $application_course_id,
                'doc_id' => $doc_sr_code,
                'doc_code' => $doc_unique_code,
                'doc_file_name' => $doc_name,
                'application_id' => $application_id,
                'doc_path' => $doc_path,
                'dropdown_arr' => $dropdown_arr ?? [],
                'is_nc_exists' => $is_nc_exists,
                'nc_comments' => $nc_comments,
            ]);
        } catch (Exception $e) {
            return back()->with('fail', 'Something went wrong');
        }
    }
    // submit nc's
    public function desktopDocumentVerify(Request $request)
    {
        try {
            $redirect_to = URL::to("/desktop/document-list") . '/' . dEncrypt($request->application_id) . '/' . dEncrypt($request->application_courses_id);
            DB::beginTransaction();
            $assessor_id = Auth::user()->id;
            $assessor_type = Auth::user()->assessment == 1 ? "desktop" : "onsite";

            if($request->nc_type=="Accept" && $request->comments==""){
                $nc_type="Accept";
                $doc_comment="Document has been approved";
             }else{
                 $nc_type=$request->nc_type;
                 $doc_comment=$request->comments;
             }

            /*end here*/
            $data = [];
            $data['application_id'] = $request->application_id;
            $data['doc_sr_code'] = $request->doc_sr_code;
            $data['doc_unique_id'] = $request->doc_unique_id;
            $data['application_courses_id'] = $request->application_courses_id;
            $data['assessor_type'] = $assessor_type;
            $data['comments'] = $doc_comment;
            $data['nc_type'] = $nc_type;
            $data['assessor_id'] = $assessor_id;
            $data['doc_file_name'] = $request->doc_file_name;
            $nc_comment_status = "";
            $nc_raise = "";
            if ($request->nc_type == "Accept") {
                $nc_comment_status = 1;
                $nc_flag = 0;
                $nc_raise = "Accept";
            } else if ($request->nc_type == "NC1") {
                $nc_comment_status = 2;
                $nc_flag = 1;
                $nc_raise = "NC1";
            } else if ($request->nc_type == "NC2") {
                $nc_comment_status = 3;
                $nc_flag = 1;
                $nc_raise = "NC2";
            } else if ($request->nc_type == "Reject") {
                $nc_comment_status = 6;
                $nc_flag = 0;
                $nc_raise = "Reject";
            } else {
                $nc_comment_status = 4; //not recommended
                $nc_flag = 0;
                $nc_raise = "Request for final approval";
            }
            $create_nc_comments = TblNCComments::insert($data);
            $tp_id = TblApplicationCourseDoc::where(['application_id' => $request->application_id, 'assessor_type' => $assessor_type, 'application_courses_id' => $request->application_courses_id, 'doc_sr_code' => $request->doc_sr_code, 'doc_unique_id' => $request->doc_unique_id])->first();
            $tp_email = DB::table('users')->where('id', $tp_id->tp_id)->first();
            //commented on 24/04/24
            TblApplicationCourseDoc::where(['application_id' => $request->application_id, 'assessor_type' => $assessor_type, 'application_courses_id' => $request->application_courses_id, 'doc_sr_code' => $request->doc_sr_code, 'doc_unique_id' => $request->doc_unique_id, 'status' => 0])->update(['status' => $nc_comment_status, 'nc_flag' => $nc_flag]);
            
            // TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'assessor_type'=>$assessor_type,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'status'=>0])->update(['status'=>$nc_comment_status]);
            /*Create record for summary report*/
            $data = [];
            $data['application_id'] = $request->application_id;
            $data['object_element_id'] = $request->doc_unique_id;
            $data['application_course_id'] = $request->application_courses_id;
            $data['doc_sr_code'] = $request->doc_sr_code;
            $data['doc_unique_id'] = $request->doc_unique_id;
            $data['date_of_assessement'] = $request->date_of_assessement ?? 'N/A';
            $data['assessor_id'] = Auth::user()->id;
            $data['assessor_type'] = $assessor_type;
            $data['nc_raise'] = $nc_raise ?? 'N/A';
            $data['nc_raise_code'] = $nc_raise ?? 'N/A';
            $data['doc_path'] = $request->doc_file_name;
            $data['capa_mark'] = $request->capa_mark ?? 'N/A';
            $data['doc_against_nc'] = $request->doc_against_nc ?? 'N/A';
            $data['doc_verify_remark'] = $request->remark ?? 'N/A';
            $create_summary_report = DB::table('assessor_summary_reports')->insert($data);
            /*end here*/
            //assessor email
            $title = "Notification -  " . $request->nc_type . " | RAVAP-" . $request->application_id;
            $subject = "Notification - " . $request->nc_type . " | RAVAP-" . $request->application_id;
            $body = "Dear ," . $tp_email->firstname . " " . PHP_EOL . "
        I hope this email finds you well. I am writing to inform you that a " . $request->nc_type . " has been generated for RAVAP-" . $request->application_id . " in accordance with our quality management procedures." . PHP_EOL . "
        NC Details:" . PHP_EOL . "
        Document Name: " . $request->doc_file_name . "" . PHP_EOL . "
        Document Sr. No.: " . $request->doc_sr_code . "" . PHP_EOL . "
        Date Created: " . date('d-m-Y') . "" . PHP_EOL . "
        NC Created By: " . Auth::user()->firstname . "";
            $details['email'] = $tp_email->email;
            $details['title'] = $title;
            $details['subject'] = $subject;
            $details['body'] = $body;
             if(env('MAIL_SEND')){
                    dispatch(new SendEmailJob($details));
                }
            /*end here*/
            if ($create_nc_comments) {
                DB::commit();
                return response()->json(['success' => true, 'message' => '' . $request->nc_type . ' comments created successfully', 'redirect_to' => $redirect_to], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to create ' . $request->nc_type . '  and documents'], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }
    public function getCourseSummariesList(Request $request)
    {
        $get_all_final_course_id = DB::table('assessor_final_summary_reports')->where('application_id', $request->input('application'))->where('assessor_type', 'desktop')->get()->pluck('application_course_id')->toArray();
        $courses = TblApplicationCourses::where('application_id', $request->input('application'))
            ->whereIn("id", $get_all_final_course_id)
            ->get();
        $applicationDetails = TblApplication::find($request->input('application'));
        $app_id = $request->input('application');
        $course_count = DB::table('tbl_application_courses')->where('application_id',$app_id)->whereIn('status',[0,2])->count();
        $is_all_course_summary_generated = false;
        
        if(count($get_all_final_course_id)==$course_count){
            $is_all_course_summary_generated=true;
        }

        return view('desktop-view.course-summary-list', compact('courses', 'applicationDetails','is_all_course_summary_generated'));
    }

    public function desktopViewFinalSummary(Request $request)
    {
        $assessor_id = Auth::user()->id;
        $application_id = $request->input('application');
        $application_course_id = $request->input('course');
        $summeryReport = DB::table('assessor_summary_reports as asr')
            ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id', 'asr.assessor_type', 'asr.object_element_id', 'app.person_name', 'app.id', 'app.uhid', 'app.created_at as app_created_at', 'app_course.course_name', 'usr.firstname', 'usr.middlename', 'usr.lastname')
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
        $assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id' => $application_id, 'assessor_id' => $assessor_id, 'assessor_type' => 'desktop'])->first();
        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id' => $assessor_id, 'application_id' => $application_id])->count();
        $questions = DB::table('questions')->get();
        foreach ($questions as $question) {
            $obj = new \stdClass;
            $obj->title = $question->title;
            $obj->code = $question->code;
            $value = TblNCComments::where([
                'application_id' => $application_id,
                'application_courses_id' => $application_course_id,
                'doc_unique_id' => $question->id,
                'assessor_id' => $assessor_id,
                'doc_sr_code' => $question->code,
            ])
                ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                ->get();
            $value1 = TblNCComments::where([
                'application_id' => $application_id,
                'application_courses_id' => $application_course_id,
                'doc_unique_id' => $question->id,
                'doc_sr_code' => $question->code,
                'assessor_type' => 'admin',
                'final_status' => 'desktop'
            ])
                ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                ->get();
            $accept_reject = TblNCComments::where([
                'application_id' => $application_id,
                'application_courses_id' => $application_course_id,
                'doc_unique_id' => $question->id,
                'doc_sr_code' => $question->code
            ])
                ->select('tbl_nc_comments.*')
                ->whereIn('assessor_type', ['onsite', 'admin'])
                ->where(function ($query) {
                    $query->where('assessor_type', 'onsite')
                        ->orWhere('assessor_type', 'admin')
                        ->whereIn('nc_type', ['Accept', 'Reject']);
                })
                ->first();
            // dd($value1);
            $obj->nc = $value;
            $obj->nc_admin = $value1;
            $obj->accept_reject = $accept_reject;
            $final_data[] = $obj;
        }

        $summary_remark = DB::table('assessor_final_summary_reports')->where(['application_id'=>$application_id,'application_course_id'=>$application_course_id])->first()->remark;


        // dd($final_data);
        $assessement_way = DB::table('asessor_applications')->where(['application_id' => $application_id])->get();
        return view('desktop-view.desktop-view-final-summary', compact('summeryReport', 'no_of_mandays', 'final_data', 'assessement_way', 'assessor_assign','summary_remark'));
    }

    public function updateAssessorDesktopNotificationStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            DB::beginTransaction();
            $is_read = DB::table('tbl_notifications')->where('id',$id)->update(['is_read'=>"1"]);
            $d = DB::table('tbl_notifications')->where('id',$id)->first();
            if ($is_read) {
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Read notification successfully.', 'redirect_url' => $d->url], 200);
            } else {
                DB::rollback();
                return response()->json(['success' => false,'message' =>'Notification Already read','redirect_url'=>$d->url],200);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Failed to read notification'], 200);
        }
    }
    // new scope
    public function desktopUpdateNCFlag($application_id, $course_id)
    {
        try {
            DB::beginTransaction();
            $assessor_id = Auth::user()->id;
            $app_ids = DB::table('tbl_application_course_doc')
                ->where(['application_id' => $application_id, 'application_courses_id' => $course_id])
                ->pluck('id')->toArray();
            $all_app = DB::table('tbl_application_course_doc')
                ->where(['application_id' => $application_id, 'application_courses_id' => $course_id])
                ->whereIn('id', $app_ids)
                ->whereNotIn('status', [0, 1, 4, 6])
                ->get();
            
            foreach ($all_app as $app) {
                $nc_comment_status = "";
                if ($app->status == 1) {
                    $nc_comment_status = 1;
                    $nc_flag = 0;
                } else if ($app->status == 2) {
                    $nc_comment_status = 2;
                    $nc_flag = 1;
                } else if ($app->status == 3) {
                    $nc_comment_status = 3;
                    $nc_flag = 1;
                } else if ($app->status == 6) {
                    $nc_comment_status = 6;
                    $nc_flag = 0;
                } else {
                        $nc_comment_status = 4; //not recommended
                        $nc_flag = 0;
                }
                TblApplicationCourseDoc::where(['id' => $app->id, 'ncs_flag_status' => 0])->update(['ncs_flag_status' => $nc_comment_status, 'nc_flag' => $nc_flag, 'assessor_id' => $assessor_id]);
            }
            DB::commit();

            
            return back()->with('success', 'Enabled Course Doc upload button to TP.');
            
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }

    public function generateFinalSummary(Request $request)
    {
        try {
            DB::beginTransaction();
            $app_id = dDecrypt($request->app_id);
            DB::table('tbl_application')->where('id',$app_id)->update(['status'=>10,'assign_day_for_verify'=>0,'assign_day_for_verify_date'=>null]);
            $isUpdate = DB::table('assessor_final_summary_reports')->where(['application_id'=>$app_id,'assessor_type'=>'desktop'])->update(['is_summary_show'=>1]);
            if($isUpdate){
                DB::commit();
                return back()->with('success', 'Final summary generated successfully.');
            }else{
                DB::rollBack();
                return back()->with('fail', 'Failed to generate final summary.');
            }

            
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }
    public function checkApplicationIsReadyForNextLevel($application_id)
    {
        $all_courses_id = DB::table('tbl_application_courses')->where('application_id', $application_id)->pluck('id');
        $results = DB::table('tbl_course_wise_document')
            ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
            ->whereIn('course_id', $all_courses_id)
            ->where('application_id', $application_id)
            ->get();
        $additionalFields = DB::table('tbl_course_wise_document')
            ->join(DB::raw('(SELECT application_id, course_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_course_wise_document GROUP BY application_id, course_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                $join->on('tbl_course_wise_document.application_id', '=', 'sub.application_id')
                    ->on('tbl_course_wise_document.course_id', '=', 'sub.course_id')
                    ->on('tbl_course_wise_document.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_course_wise_document.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_course_wise_document.id', '=', 'sub.max_id');
            })
            ->where('tbl_course_wise_document.application_id',$application_id)
            ->orderBy('tbl_course_wise_document.id', 'desc')
            ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag']);
        foreach ($results as $key => $result) {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('course_id', $result->course_id)
                ->where('doc_sr_code', $result->doc_sr_code)
                ->where('doc_unique_id', $result->doc_unique_id)
                ->first();
            if ($additionalField) {
                $results[$key]->status = $additionalField->status;
                $results[$key]->id = $additionalField->id;
                $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
            }
        }
        $flag = 0;
        $nc_flag = 0;
        $not_any_action_flag = 0;
        foreach ($results as $result) {
            if ($result->status == 1 || ($result->status == 4 && $result->admin_nc_flag == 1)) {
                $flag = 0;
            } else {
                $flag = 1;
                break;
            }
        }
        foreach ($results as $result) {
            if ($result->status != 0) {
                $nc_flag = 1;
                break;
            }
        }
        foreach ($results as $result) {
            if ($result->status == 0) {
                $not_any_action_flag = 1;
                break;
            }
        }
        if ($flag == 0) {
            DB::table('tbl_application')->where('id', $application_id)->update(['is_all_course_doc_verified' => 1]);
            return "all_verified";
        }
        if ($not_any_action_flag == 1) {
            return "action_not_taken";
        }
        if ($nc_flag == 1) {
            return true;
        } else {
            return false;
        }
    }

    // 

    public function desktopUpdateNCFlagDocList($application_id)
        {
            try {
                $application_id = dDecrypt($application_id);
                DB::beginTransaction();
                $t=0;
                $reuploadbtnToTPorAdmin=0;
                $secretariat_id = Auth::user()->id;
                $get_course_docs = DB::table('tbl_application_course_doc')
                    ->where(['application_id' => $application_id,'approve_status'=>1,'assessor_type'=>'desktop'])
                    // ->whereIn('doc_sr_code',[config('constant.declaration.doc_sr_code'),config('constant.curiculum.doc_sr_code'),config('constant.details.doc_sr_code')])
                    ->latest('id')->get();
                    foreach($get_course_docs as $course_doc){
                        if ($course_doc->status == 4 && $course_doc->is_admin_submit!=1) {
                            $reuploadbtnToTPorAdmin=1;
                        }
                    }
                    foreach($get_course_docs as $course_doc){
                        $nc_comment_status = "";
                        $nc_flag=0;
                        $nc_comments = 0;
                    if ($course_doc->status == 2) {
                            $nc_comment_status = 2;
                            $nc_flag = 1;
                            $nc_comments=1;
                        } else if ($course_doc->status == 3) {
                            $nc_comment_status = 3;
                            $nc_flag = 1;
                            $nc_comments=1;
                        }
                        // else if ($course_doc->status == 4) {
                        //     $nc_comment_status = 4;
                        //     $nc_flag = 1;
                        //     $nc_comments=1;
                        // } 
                        else {
                            $nc_comment_status = 0; //not recommended
                            $nc_flag = 0;
                            $nc_comments=0;
                        }

                        /*if any courses rejected then hide the revert button according to courses*/ 
                

                $is_update=  DB::table('tbl_application_course_doc')
                    ->where(['id' => $course_doc->id, 'application_id' => $application_id,'nc_show_status'=>0,'assessor_type'=>'desktop'])
                    ->update(['nc_flag' => $nc_flag, 'assessor_id' => $secretariat_id,'nc_show_status'=>$nc_comment_status,'is_revert'=>1]);

                    DB::table('tbl_nc_comments')
                    ->where(['application_id' => $application_id, 'application_courses_id' => $course_doc->application_courses_id,'nc_show_status'=>0,'assessor_type'=>'desktop'])
                    ->update(['nc_show_status' => $nc_comments]);

                    if($t==0){
                        if($is_update){
                            $t=1;
                        }
                    }


                }


                $get_application = DB::table('tbl_application')->where('id',$application_id)->first();
                if($get_application->level_id==1){
                    $url= config('notification.secretariatUrl.level1');
                    $url=$url.dEncrypt($application_id);
                    $tpUrl = config('notification.tpUrl.level1');
                    $tpUrl=$tpUrl.dEncrypt($application_id);
                }else if($get_application->level_id==2){
                    $url= config('notification.secretariatUrl.level2');
                    $url=$url.dEncrypt($application_id);
                    $tpUrl = config('notification.tpUrl.level2');
                    $tpUrl=$tpUrl.dEncrypt($application_id);
                }else{
                    $url= config('notification.secretariatUrl.level3');
                    $url=$url.dEncrypt($application_id);
                    $tpUrl = config('notification.tpUrl.level3');
                    $tpUrl=$tpUrl.dEncrypt($application_id);
                }
                $is_all_accepted=$this->isAllCourseDocAccepted($application_id);
                $notifiData = [];
                $notifiData['sender_id'] = Auth::user()->id;
                $notifiData['application_id'] = $application_id;
                $notifiData['uhid'] = getUhid( $application_id)[0];
                $notifiData['level_id'] = getUhid( $application_id)[1];
                $notifiData['data'] = config('notification.common.nc');
                $notifiData['user_type'] = "superadmin";
                $sUrl = config('notification.adminUrl.level1');

                $notifiData['url'] = $sUrl.dEncrypt($application_id);
                if($get_application->level_id==3){
                if($t && !$is_all_accepted){
                     DB::table('tbl_application')->where('id',$application_id)->update(['status'=>4]);
                    /*send notification*/ 
                    sendNotification($notifiData);
                    $notifiData['user_type'] = "tp";
                    $notifiData['receiver_id'] = $get_application->tp_id;
                    $notifiData['url'] = $tpUrl;
                    sendNotification($notifiData);
                    $notifiData['user_type'] = "secretariat";
                    $notifiData['receiver_id'] = $get_application->secretariat_id;
                    $notifiData['url'] = $url;
                    sendNotification($notifiData);
                    createApplicationHistory($application_id,null,config('history.common.nc'),config('history.color.danger'));
                        /*end here*/ 
                    
                }
            
                if($is_all_accepted){
                    $notifiData['data'] = config('notification.admin.acceptCourseDoc');
                    $notifiData['user_type'] = "superadmin";
                    $notifiData['url'] = $sUrl.dEncrypt($application_id);
                    sendNotification($notifiData);
                    createApplicationHistory($application_id,null,config('history.admin.acceptCourseDoc'),config('history.color.success'));
                }
            }
                /*--------To Check All 44 Doc Approved----------*/

                $check_all_doc_verified = $this->checkApplicationIsReadyForNextLevelDocList($application_id);
                /*------end here------*/
                DB::commit();
                // if (!$check_all_doc_verified) {
                //     return back()->with('fail', 'First create NCs on courses doc');
                // }
                if ($check_all_doc_verified == "all_verified") {
                    DB::table('tbl_application')->where('id',$application_id)->update(['is_secretariat_submit_btn_show'=>0]);
                    
                    return back()->with('success', 'All course docs Accepted successfully.');
                }
                if ($check_all_doc_verified == "action_not_taken") {
                    return back()->with('fail', 'Please take any action on course doc.');
                }
                if($reuploadbtnToTPorAdmin){
                    DB::table('tbl_application')->where('id',$application_id)->update(['status'=>16]);
                    return back()->with('success', 'File sent to admin.');
                }
                return back()->with('success', 'Enabled Course Doc upload button to TP.');
                // return redirect($redirect_to);

            } catch (Exception $e) {
                DB::rollBack();
                return back()->with('fail', 'Something went wrong');
            }
    }

    public function checkApplicationIsReadyForNextLevelDocList($application_id)
    {
    
        
            $all_courses_id = DB::table('tbl_application_courses')->where('application_id', $application_id)->pluck('id');
    
        
            $results = DB::table('tbl_application_course_doc')
                ->select('application_id', 'application_courses_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
                ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id')
                ->whereIn('application_courses_id', $all_courses_id)
                ->where('application_id', $application_id)
                ->where('approve_status',1)
                ->get();
        
    
            $additionalFields = DB::table('tbl_application_course_doc')
                ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                    $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                        ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                        ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                        ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                        ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
                })
                ->where('tbl_application_course_doc.application_id',$application_id)

                ->orderBy('tbl_application_course_doc.id', 'desc')
                ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status']);
    
    
            foreach ($results as $key => $result) {
                $additionalField = $additionalFields->where('application_id', $result->application_id)
                    ->where('application_courses_id', $result->application_courses_id)
                    ->where('doc_sr_code', $result->doc_sr_code)
                    ->where('doc_unique_id', $result->doc_unique_id)
                    ->where('approve_status',1)
                    ->first();
                if ($additionalField) {
                    $results[$key]->status = $additionalField->status;
                    $results[$key]->id = $additionalField->id;
                    $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                }
            }
    
            $flag = 0;
            $nc_flag = 0;
            $not_any_action_flag = 0;
            foreach ($results as $result) {
                if ($result->status == 1 || ($result->status == 4 && $result->admin_nc_flag == 1)) {
                    $flag = 0;
                } else {
                    $flag = 1;
                    break;
                }
            }
    
            foreach ($results as $result) {
                if ($result->status != 0) {
                    $nc_flag = 1;
                    break;
                }
            }
            foreach ($results as $result) {
                if ($result->status == 0) {
                    $not_any_action_flag = 1;
                    break;
                }
            }
            
            if ($flag == 0) {
            //   DB::table('tbl_application')->where('id', $application_id)->update(['is_all_course_doc_verified' => 1]);
                return "all_verified";
            }
            if ($not_any_action_flag == 1) {
                return "action_not_taken";
            }
    
            if ($nc_flag == 1) {
                return "valid";
            } else {
                return "notValid";
            }
    
    }
    
    function revertCourseDocListActionDesktop(Request $request){
            try{
                DB::beginTransaction();
                
                $get_course_doc = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name])->latest('id')->first();

                if($get_course_doc->is_revert==1){
                    return response()->json(['success' => false, 'message' => 'Action reverted failed.'], 200);
                }
                    if($get_course_doc->status==4){
                        $revertAction = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name,'is_revert'=>0])->update(['status'=>0,'admin_nc_flag'=>0]);
    
                    }else{
                        $revertAction = DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$request->doc_file_name,'is_revert'=>0])->update(['status'=>0]);
                    }

                        /*Delete nc on course doc*/ 
                        $delete_= DB::table('tbl_nc_comments')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id,'doc_file_name'=>$get_course_doc->doc_file_name])->delete();
                        
                        /*end here*/            
                if($revertAction){
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Action reverted successfully.'], 200);
                }else{
                    DB::rollBack();
                    return response()->json(['success' =>false, 'message' => 'Failed to revert action.'], 200);
                }
            }catch(Exception $e){
                DB::rollBack();
                return response()->json(['success' =>false, 'message' => 'Something went wrong!'], 200);
            }
    }

    public function isShowSubmitBtnToSecretariat($application_id)
    {
        $results = DB::table('tbl_application_course_doc')
            ->select('application_id', 'application_courses_id', 'assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id', 'assessor_type')
            ->where('application_id', $application_id)
            ->whereIn('approve_status', [0,1])
            ->get();
        
        $additionalFields = DB::table('tbl_application_course_doc')
            ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id, assessor_type) as sub'), function ($join) {
                $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                    ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                    ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
            })
            ->where('tbl_application_course_doc.application_id',$application_id)

            ->orderBy('tbl_application_course_doc.id', 'desc')
            ->where('tbl_application_course_doc.assessor_type','desktop')
            ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag', 'approve_status', 'assessor_type']);

        
        $finalResults = [];
        foreach ($results as $key => $result) {
            if ($result->assessor_type == 'desktop') {
                $additionalField = $additionalFields->where('application_id', $result->application_id)
                    ->where('application_courses_id', $result->application_courses_id)
                    ->where('doc_sr_code', $result->doc_sr_code)
                    ->where('doc_unique_id', $result->doc_unique_id)
                    ->where('approve_status', 1)
                    ->first();

                if ($additionalField) {
                    $finalResults[$key] = (object)[];
                    $finalResults[$key]->status = $additionalField->status;
                    $finalResults[$key]->id = $additionalField->id;
                    $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                    $finalResults[$key]->approve_status = $additionalField->approve_status;
                    $finalResults[$key]->assessor_type = $additionalField->assessor_type;
                }
            }
        }

        $flag = 0;
        
        foreach ($finalResults as $result) {
            if (($result->status == 1) || ($result->status == 4 && $result->admin_nc_flag == 1)) {
                $flag = 0;
            } else {
                $flag = 1;
                break;
            }
        }

        return $flag != 0;
    }

    public function checkSubmitButtonEnableOrDisable($application_id)
    {

        $results = DB::table('tbl_application_course_doc')
        ->select('application_id', 'application_courses_id', 'assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
        ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id', 'assessor_type')
        ->where('application_id', $application_id)
        ->where('approve_status', 1)
        ->get();

    $additionalFields = DB::table('tbl_application_course_doc')
        ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id, assessor_type) as sub'), function ($join) {
            $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
        })
        ->where('tbl_application_course_doc.application_id',$application_id)
        ->where('tbl_application_course_doc.assessor_type','desktop')
        ->orderBy('tbl_application_course_doc.id', 'desc')
        ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag', 'approve_status', 'assessor_type']);


            $finalResults = [];
            foreach ($results as $key => $result) {
                if ($result->assessor_type == 'desktop') {
                    $additionalField = $additionalFields->where('application_id', $result->application_id)
                        ->where('application_courses_id', $result->application_courses_id)
                        ->where('doc_sr_code', $result->doc_sr_code)
                        ->where('doc_unique_id', $result->doc_unique_id)
                        ->where('approve_status', 1)
                        ->first();

                    if ($additionalField) {
                        $finalResults[$key] = (object)[];
                        $finalResults[$key]->status = $additionalField->status;
                        $finalResults[$key]->id = $additionalField->id;
                        $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                        $finalResults[$key]->approve_status = $additionalField->approve_status;
                        $finalResults[$key]->assessor_type = $additionalField->assessor_type;
                    }
                }
            }

        
        $flag = 0;

        foreach ($finalResults as $result) {

            if (($result->status!=0)) {
                $flag = 0;
            } else {
                $flag = 1;
                break;
            }
        }
        
        if ($flag == 0) {
            return false;
        } else {
            return true;
        }

    }

    public function checkAllActionDoneOnRevert($application_id)
    {

        $results = DB::table('tbl_application_course_doc')
            ->select('application_id', 'application_courses_id','assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id','assessor_type')
            // ->where('application_courses_id', $application_courses_id)
            ->where('application_id', $application_id)
            ->where('approve_status',1)
            ->get();

            
            

        $additionalFields = DB::table('tbl_application_course_doc')
            ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                    ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                    ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
            })
            ->where('tbl_application_course_doc.application_id',$application_id)

            ->where('tbl_application_course_doc.assessor_type','desktop')
            ->orderBy('tbl_application_course_doc.id', 'desc')
            ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status','is_revert','assessor_type']);

        $finalResults = [];
        foreach ($results as $key => $result) {
            if ($result->assessor_type == 'desktop') {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('application_courses_id', $result->application_courses_id)
                ->where('doc_sr_code', $result->doc_sr_code)
                ->where('doc_unique_id', $result->doc_unique_id)
                ->where('approve_status',1)
                ->first();
            if ($additionalField) {
                $finalResults[$key] = (object)[];
                $finalResults[$key]->status = $additionalField->status;
                $finalResults[$key]->id = $additionalField->id;
                $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                $finalResults[$key]->approve_status = $additionalField->approve_status;
                $finalResults[$key]->is_revert = $additionalField->is_revert;
            }
        }
        }

        
        $flag = 0;

        foreach ($finalResults as $result) {
            if (($result->is_revert == 1)) {
                $flag = 0;
            } else {
                $flag = 1;
                break;
            }
        }
        
        if ($flag == 0) {
            return false;
        } else {
            return true;
        }

    }

    public function checkAllActionDoneOnDocList($application_id,$application_courses_id)
    {

        $results = DB::table('tbl_application_course_doc')
            ->select('application_id', 'application_courses_id','assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id','assessor_type')
            ->where('application_courses_id', $application_courses_id)
            ->where('application_id', $application_id)
            ->where('approve_status',1)
            ->get();

            
            

        $additionalFields = DB::table('tbl_application_course_doc')
            ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                    ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                    ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
            })
            ->where('tbl_application_course_doc.application_id',$application_id)

            ->where('tbl_application_course_doc.assessor_type','desktop')
            ->orderBy('tbl_application_course_doc.id', 'desc')
            ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status','is_revert','assessor_type']);

        $finalResults = [];
        foreach ($results as $key => $result) {
            if ($result->assessor_type == 'desktop') {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('application_courses_id', $result->application_courses_id)
                ->where('doc_sr_code', $result->doc_sr_code)
                ->where('doc_unique_id', $result->doc_unique_id)
                ->where('approve_status',1)
                ->first();
            if ($additionalField) {
                $finalResults[$key] = (object)[];
                $finalResults[$key]->status = $additionalField->status;
                $finalResults[$key]->id = $additionalField->id;
                $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                $finalResults[$key]->approve_status = $additionalField->approve_status;
                $finalResults[$key]->is_revert = $additionalField->is_revert;
            }
        }
        }

        
        $flag = 0;
    
        foreach ($finalResults as $result) {
            if (($result->status != 0) && $result->is_revert==1) {
                $flag = 0;
            } else {
                $flag = 1;
                break;
            }
        }
        
        if ($flag == 0) {
            return false;
        } else {
            return true;
        }

    }

    public function isCreateSummaryBtnShow($application_id,$application_courses_id)
    {

        $results = DB::table('tbl_application_course_doc')
            ->select('application_id', 'application_courses_id','assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id','assessor_type')
            ->where('application_courses_id', $application_courses_id)
            ->where('application_id', $application_id)
            ->where('approve_status',1)
            ->get();

            
            

        $additionalFields = DB::table('tbl_application_course_doc')
            ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                    ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                    ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
            })
            ->where('tbl_application_course_doc.application_id',$application_id)

            ->where('tbl_application_course_doc.assessor_type','desktop')
            ->orderBy('tbl_application_course_doc.id', 'desc')
            ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status','is_revert','assessor_type']);

        $finalResults = [];
        foreach ($results as $key => $result) {
            if ($result->assessor_type == 'desktop') {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('application_courses_id', $result->application_courses_id)
                ->where('doc_sr_code', $result->doc_sr_code)
                ->where('doc_unique_id', $result->doc_unique_id)
                ->where('approve_status',1)
                ->first();
            if ($additionalField) {
                $finalResults[$key] = (object)[];
                $finalResults[$key]->status = $additionalField->status;
                $finalResults[$key]->id = $additionalField->id;
                $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                $finalResults[$key]->approve_status = $additionalField->approve_status;
                $finalResults[$key]->is_revert = $additionalField->is_revert;
            }
        }
        }

        
        $flag = 0;
        // dd($finalResults);
        foreach ($finalResults as $result) {
            if (($result->status==2 && $result->status==3 && $result->is_revert==1) || ($result->status==1) || ($result->status==4) || ($result->status==6)) {
                $flag = 0;
            } else {
               $flag=1;
               break;
            }
           
        }
        
        if ($flag == 0) {
            return "show";
        }else{
            return "hide";
        }
        
    }

    
    public function isAllDocAccepted($application_id)
    {

        $results = DB::table('tbl_application_course_doc')
            ->select('application_id', 'application_courses_id','assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id','assessor_type')
            // ->where('application_courses_id', $application_courses_id)
            ->where('application_id', $application_id)
            ->where('approve_status',1)
            ->get();

            
            

        $additionalFields = DB::table('tbl_application_course_doc')
            ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                    ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                    ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
            })
            ->where('tbl_application_course_doc.application_id',$application_id)

            ->where('tbl_application_course_doc.assessor_type','desktop')
            ->orderBy('tbl_application_course_doc.id', 'desc')
            ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status','is_revert','assessor_type']);

        $finalResults = [];
        foreach ($results as $key => $result) {
            if ($result->assessor_type == 'desktop') {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('application_courses_id', $result->application_courses_id)
                ->where('doc_sr_code', $result->doc_sr_code)
                ->where('doc_unique_id', $result->doc_unique_id)
                ->where('approve_status',1)
                ->first();
            if ($additionalField) {
                $finalResults[$key] = (object)[];
                $finalResults[$key]->status = $additionalField->status;
                $finalResults[$key]->id = $additionalField->id;
                $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                $finalResults[$key]->approve_status = $additionalField->approve_status;
                $finalResults[$key]->is_revert = $additionalField->is_revert;
            }
        }
        }

        
        $flag = 0;

        
        foreach ($finalResults as $result) {
            if ($result->status == 1 || (($result->status==4 || $result->status==5) && in_array($result->admin_nc_flag,[1,2]))) {
                $flag = 0;
            } else {
                $flag = 1;
                break;
            }
        }
        
        if ($flag == 0) {
            return true;
        } else {
            return false;
        }

    }


    public function isNrOnDesktopDocList($application_id)
    {

        $results = DB::table('tbl_application_course_doc')
            ->select('application_id', 'application_courses_id','assessor_type', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id','assessor_type')
            // ->where('application_courses_id', $application_courses_id)
            ->where('application_id', $application_id)
            ->where('approve_status',1)
            ->get();

            
            

        $additionalFields = DB::table('tbl_application_course_doc')
            ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                    ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                    ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
            })
            ->where('tbl_application_course_doc.application_id',$application_id)

            ->where('tbl_application_course_doc.assessor_type','desktop')
            ->orderBy('tbl_application_course_doc.id', 'desc')
            ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status','is_revert','assessor_type']);

        $finalResults = [];
        foreach ($results as $key => $result) {
            if ($result->assessor_type == 'desktop') {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('application_courses_id', $result->application_courses_id)
                ->where('doc_sr_code', $result->doc_sr_code)
                ->where('doc_unique_id', $result->doc_unique_id)
                ->where('approve_status',1)
                ->first();
            if ($additionalField) {
                $finalResults[$key] = (object)[];
                $finalResults[$key]->status = $additionalField->status;
                $finalResults[$key]->id = $additionalField->id;
                $finalResults[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                $finalResults[$key]->approve_status = $additionalField->approve_status;
                $finalResults[$key]->is_revert = $additionalField->is_revert;
            }
        }
        }

        
        $flag = 0;

        
        foreach ($finalResults as $result) {
            if ($result->status == 4) {
                $flag = 1;
                break;
            }
        }
        $total_course = DB::table('tbl_application_courses')
        ->where(['application_id'=>$application_id,'deleted_by_tp'=>0])
        ->whereNull('deleted_at')
        ->count();

        $total_summary = DB::table('assessor_final_summary_reports')
        ->where(['application_id'=>$application_id,'assessor_type'=>'desktop','assessor_id'=>Auth::user()->id])
        ->count();
        
        if ($flag == 1 && ($total_summary!=$total_course)) {
            return true;
        } else {
            return false;
        }

    }


    public function uploadSignedCopy(Request $request)
    {
    try{
        
        DB::beginTransaction();
        if ($request->hasfile('signed_copy_desktop')) {
            $file = $request->file('signed_copy_desktop');
            $name = $file->getClientOriginalName();
            $filename = time() . $name;
            $file->move('level/', $filename);
        }
        $uploaded = DB::table('tbl_application_courses')->where('id',$request->course_id)->update(['signed_copy_desktop'=>$filename]);
        
        // $data = [];
        // $data['application_id']=$request->application_id;
        // $data['doc_file_name']=$filename;
        // $data['user_id']=Auth::user()->id;
        // $uploaded=DB::table('tbl_mom')->insert($data);
        
        if($uploaded){
        DB::commit();
        return response()->json(['success' => true,'message' =>'Signed Copy uploaded successfully'],200);
        }else{
            return response()->json(['success' => false,'message' =>'Failed to upload Signed Copy'],200);
        }
    } 
    catch(Exception $e){
        return response()->json(['success' => false,'message' =>'Someting went wrong'],500);
    }
    }

    public function sigendCopyDesktop($doc_name,$app_id)
    {
        $data = $doc_name;
        return view('doc-view.signed', ['data' => $data]);
        
    }

    public function isAllCourseDocAccepted($application_id)
    {


        $all_courses_id = DB::table('tbl_application_courses')->where('application_id', $application_id)->pluck('id');


        $results = DB::table('tbl_application_course_doc')
            ->select('application_id', 'application_courses_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id')
            ->whereIn('application_courses_id', $all_courses_id)
            ->where('application_id', $application_id)
            ->where('approve_status',1)
            ->get();


        $additionalFields = DB::table('tbl_application_course_doc')
            ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                    ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                    ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
            })
            ->where('tbl_application_course_doc.application_id',$application_id)

            ->orderBy('tbl_application_course_doc.id', 'desc')
            ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status']);


        foreach ($results as $key => $result) {
            $additionalField = $additionalFields->where('application_id', $result->application_id)
                ->where('application_courses_id', $result->application_courses_id)
                ->where('doc_sr_code', $result->doc_sr_code)
                ->where('doc_unique_id', $result->doc_unique_id)
                ->where('approve_status',1)
                ->first();
            if ($additionalField) {
                $results[$key]->status = $additionalField->status;
                $results[$key]->id = $additionalField->id;
                $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
            }
        }

        $flag = 0;
        foreach ($results as $result) {
            if ($result->status == 1 || ($result->status == 4 && $result->admin_nc_flag == 1)) {
                $flag = 1;
            } else {
                $flag = 0;
                break;
            }
        }

    
        if ($flag == 1) {
            return true;
        } else {
            return false;
        }

    }


}
