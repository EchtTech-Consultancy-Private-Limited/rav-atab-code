<?php
namespace App\Http\Controllers\application_controller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Mail\SendEMail;

use App\Models\TblApplication;
use App\Models\TblApplicationPayment;
use App\Models\TblApplicationCourseDoc;
use App\Models\DocumentRemark;
use App\Models\DocComment;
use App\Models\Application;
use App\Models\Add_Document;
use App\Models\AssessorApplication;
use App\Models\asessor_application;
use App\Models\User;
use App\Models\Chapter;
use App\Models\TblNCComments;
use Carbon\Carbon;
use URL;
use App\Jobs\SendEmailJob;
use File;

class AdminApplicationController extends Controller
{
    public function __construct()
    {
    }
    public function getApplicationList()
    {
        $application = DB::table('tbl_application as a')
            ->whereIn('a.payment_status', [2, 3])
            ->where('secretariat_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();
        $final_data = array();
        // $payment_count = DB::table("tbl_application_payment")->where('')

        $desktop_assessor_list = DB::table('users')->where(['assessment' => 1, 'role' => 3, 'status' => 0])->orderBy('id', 'DESC')->get();

        $onsite_assessor_list = DB::table('users')->where(['assessment' => 2, 'role' => 3, 'status' => 0])->orderBy('id', 'DESC')->get();

        $secretariatdata = DB::table('users')->where('role', '5')->orderBy('id', 'DESC')->get();
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

            ])
                ->first();
            $last_payment = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
            ])
                ->latest('id')
                ->first();

            $payment_amount = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
            ])
                ->where('status', 2)
                ->sum('amount');
            $payment_count = DB::table('tbl_application_payment')->where([
                'application_id' => $app->id,
            ])
                ->where('status', 2)
                ->count();

            $doc_uploaded_count = DB::table('tbl_application_course_doc')->where(['application_id' => $app->id])->count();
            $obj->doc_uploaded_count = $doc_uploaded_count;

            $assessment_way = DB::table('asessor_applications')->where('application_id', $app->id)->first()->assessment_way ?? '';

            if ($payment) {
                $obj->assessor_list = $payment_count > 1 ? $onsite_assessor_list : $desktop_assessor_list;
                $obj->assessor_type = $payment_count > 1 ? "onsite" : "desktop";
                $obj->payment = $payment;
                $obj->assessment_way = $assessment_way;
                $obj->payment->payment_count = $payment_count;
                $obj->payment->payment_amount = $payment_amount;
                $obj->payment->last_payment = $last_payment;
            }
            $final_data[] = $obj;
        }
        // dd($final_data);
        return view('admin-view.application-list', ['list' => $final_data, 'secretariatdata' => $secretariatdata]);
    }
    /** Whole Application View for Account */
    public function getApplicationView($id)
    {
        $json_course_doc = File::get(base_path('/public/course-doc/courses.json'));
        $decoded_json_courses_doc = json_decode($json_course_doc);

        $application = DB::table('tbl_application')
            ->where('id', dDecrypt($id))
            ->first();



        $user_data = DB::table('users')->where('users.id', $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();

        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->latest('id')->first();
        $obj = new \stdClass;
        $obj->application = $application;
        $obj->show_submit_btn_to_secretariat = $this->checkApplicationIsReadyForNextLevel($application->id);
        
        $courses = DB::table('tbl_application_courses')->where([
            'application_id' => $application->id,
        ])
            ->whereNull('deleted_at')
            ->get();

        foreach ($courses as $course) {
            if ($course) {
                $obj->course[] = [
                    "course" => $course,
                    "course_doc_flag" => DB::table('tbl_course_wise_document')->where([
                        'application_id' => $application->id,
                        'course_id' => $course->id

                    ])->where('status', '<>', 0)->count(),
                    // "show_submit_btn_to_secretariat" => $this->checkApplicationIsReadyForNextLevel($application->id, $course->id),
                    "show_reject_button_to_tp" => $this->checkApplicationIsReadyForNextLevelByCourseAndApplication($application->id, $course->id),

                    'course_wise_document_declaration' => DB::table('tbl_course_wise_document')->where([
                        'application_id' => $application->id,
                        'course_id' => $course->id,
                        'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                        'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                    ])->get(),

                    'course_wise_document_curiculum' => DB::table('tbl_course_wise_document')->where([
                        'application_id' => $application->id,
                        'course_id' => $course->id,
                        'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                        'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                    ])->get(),

                    'course_wise_document_details' => DB::table('tbl_course_wise_document')->where([
                        'application_id' => $application->id,
                        'course_id' => $course->id,
                        'doc_sr_code' => config('constant.details.doc_sr_code'),
                        'doc_unique_id' => config('constant.details.doc_unique_id'),
                    ])->get(),


                    'nc_comments_course_declaration' => DB::table('tbl_nc_comments_secretariat')->where([
                        'application_id' => $application->id,
                        'application_courses_id' => $course->id,
                        'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                        'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                    ])
                        ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname', 'users.role')
                        ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                        ->get(),

                    'nc_comments_course_curiculam' => DB::table('tbl_nc_comments_secretariat')->where([
                        'application_id' => $application->id,
                        'application_courses_id' => $course->id,
                        'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                        'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                    ])
                        ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname', 'users.role')
                        ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                        ->get(),

                    'nc_comments_course_details' => DB::table('tbl_nc_comments_secretariat')->where([
                        'application_id' => $application->id,
                        'application_courses_id' => $course->id,
                        'doc_sr_code' => config('constant.details.doc_sr_code'),
                        'doc_unique_id' => config('constant.details.doc_unique_id'),
                    ])
                        ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname', 'users.role')
                        ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                        ->get()
                ];
            }
        }


        $payment = DB::table('tbl_application_payment')->where([
            'application_id' => $application->id,
            'status' => 2 //paymnet approved by accountant 
        ])->get();

        if ($payment) {
            $obj->payment = $payment;
        }
        $final_data = $obj;

        $admin_final_summary_count = DB::table('assessor_final_summary_reports')->where(['application_id' => $application->id])->count();
        if ($admin_final_summary_count > 1) {
            $is_final_submit = true;
        } else {
            $is_final_submit = false;
        }

        // dd($final_data);
        return view('admin-view.application-view', ['application_details' => $final_data, 'data' => $user_data, 'spocData' => $application, 'application_payment_status' => $application_payment_status, 'is_final_submit' => $is_final_submit, 'courses_doc' => $decoded_json_courses_doc]);
    }



    public function checkApplicationIsReadyForNextLevel($application_id)
    {

        $results = DB::table('tbl_course_wise_document')
            ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
            // ->where('course_id', $course_id)
            ->where('application_id', $application_id)
            ->where('approve_status',1)
            ->get();

            

        $additionalFields = DB::table('tbl_course_wise_document')
            ->join(DB::raw('(SELECT application_id, course_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_course_wise_document GROUP BY application_id, course_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                $join->on('tbl_course_wise_document.application_id', '=', 'sub.application_id')
                    ->on('tbl_course_wise_document.course_id', '=', 'sub.course_id')
                    ->on('tbl_course_wise_document.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_course_wise_document.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_course_wise_document.id', '=', 'sub.max_id');
            })
            ->orderBy('tbl_course_wise_document.id', 'desc')
            ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag','approve_status']);


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
                $results[$key]->approve_status = $additionalField->approve_status;
            }
        }

        
        $flag = 0;

        foreach ($results as $result) {
            
            if (($result->status === 1 && $result->approve_status==1) || ($result->status == 4 && $result->admin_nc_flag == 1)) {
                $flag = 0;
            } else {
                $flag = 1;
                break;
            }
        }

        if ($flag === 0) {
            return false;
        } else {
            return true;
        }

    }


    public function checkApplicationIsReadyForNextLevelByCourseAndApplication($application_id,$course_id)
    {

        $results = DB::table('tbl_course_wise_document')
            ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
            ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
            ->where('course_id', $course_id)
            ->where('application_id', $application_id)
            ->where('approve_status',1)
            ->get();

            

        $additionalFields = DB::table('tbl_course_wise_document')
            ->join(DB::raw('(SELECT application_id, course_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_course_wise_document GROUP BY application_id, course_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                $join->on('tbl_course_wise_document.application_id', '=', 'sub.application_id')
                    ->on('tbl_course_wise_document.course_id', '=', 'sub.course_id')
                    ->on('tbl_course_wise_document.doc_sr_code', '=', 'sub.doc_sr_code')
                    ->on('tbl_course_wise_document.doc_unique_id', '=', 'sub.doc_unique_id')
                    ->on('tbl_course_wise_document.id', '=', 'sub.max_id');
            })
            ->orderBy('tbl_course_wise_document.id', 'desc')
            ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag','approve_status']);


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
                $results[$key]->approve_status = $additionalField->approve_status;
            }
        }

        
        $flag = 0;

        foreach ($results as $result) {
            
            if (($result->status === 1 && $result->approve_status==1) || ($result->status == 4 && $result->admin_nc_flag == 1)) {
                $flag = 0;
            } else {
                $flag = 1;
                break;
            }
        }

        if ($flag === 0) {
            return false;
        } else {
            return true;
        }

    }


    public function approveCourseRejectBySecretariat($id,$course_id){
        try {
            
            DB::beginTransaction();
            $get_course_docs = DB::table('tbl_course_wise_document')
                ->where(['application_id' => $id,'course_id'=>$course_id])
                ->update(['approve_status'=>1]); 

                DB::table('tbl_application_courses')
                ->where(['id'=>$course_id])
                ->update(['status'=>2]); //approved by admin

                if($get_course_docs){
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Course approved  successfully'], 200);
                }else{
                    DB::rollBack();
                    return response()->json(['success' =>false, 'message' => 'Failed to approved course'], 200);
                }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }

    public function adminRejectCourse($id,$course_id){
        try {
            
            DB::beginTransaction();
            $get_course_docs = DB::table('tbl_course_wise_document')
                ->where(['application_id' => $id,'course_id'=>$course_id])
                ->update(['approve_status'=>2]); 

                DB::table('tbl_application_courses')
                ->where(['id'=>$course_id])
                ->update(['status'=>3]); //reject by admin

                if($get_course_docs){
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Course rejected  successfully.'], 200);
                }else{
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Failed to reject course'], 200);
                }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }

    public function adminPaymentAcknowledge(Request $request)
    {
        try {
            $application = TblApplication::find($request->post('application_id'));
            $is_exists = DB::table('tbl_application_payment')->where('aknowledgement_id', null)->first();
            if (!$is_exists) {
                return response()->json(['success' => false, 'message' => 'Payment Acknowledgement Already Done'], 409);
            }
            DB::beginTransaction();
            DB::table('tbl_application_payment')->where('application_id', '=', $request->post('application_id'))->update(['aknowledgement_id' => auth()->user()->id]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Payment acknowledged successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to make acknowledged payment'], 500);
        }
    }
    public function assignAssessor(Request $request)
    {
        try {
            $a_id = "assessor_type_" . $request->application_id;
            // $a_id = "assessor_type_".$request->assessor_id;
            $assessor_designation = $a_id;
            if ($request->$assessor_designation == null) {
                return redirect()->route('admin-app-list')->with('fail', 'Please select assessor designation');
            }
            if ($request->assessor_id == null) {
                return redirect()->route('admin-app-list')->with('fail', 'Please select assessor');
            }
            DB::beginTransaction();

            $get_assessor_type = DB::table('users')->where('id', $request->assessor_id)->first()->assessment;
            $assessor_types = $get_assessor_type == 1 ? 'desktop' : 'onsite';

            /*to check date is selected or not*/
            $get_date_count = DB::table('assessor_assigne_date')->where(['application_id' => $request->application_id, 'assessor_Id' => $request->assessor_id])->count();
            // $get_assessor_designation = DB::table('tbl_assessor_assign')->where(['application_id'=>$request->application_id,'assessor_Id'=>$request->assessor_id,'assessor_type'=>$assessor_types])->first();
            if ($get_date_count < 1) {
                return redirect()->route('admin-app-list')->with('fail', 'Please select date');
            }
            /*end here*/
            $assessorType = $get_assessor_type == 1 ? 'desktop' : 'onsite';
            $assessment_type_ = $assessorType == "desktop" ? 1 : 2;
            DB::table('assessor_assigne_date')->where('application_id', $request->application_id)->whereNotIn('assessor_id', [$request->assessor_id])->where('assesment_type', $assessment_type_)->delete();

            DB::table('tbl_assessor_assign')->where(['application_id' => $request->application_id, 'assessor_type' => $assessorType])->whereNotIn('assessor_id', [$request->assessor_id])->delete();

            $assessor_details = DB::table('users')->where('id', $request->assessor_id)->first();
            $data = [];
            $data['application_id'] = $request->application_id;
            $data['assessor_id'] = $request->assessor_id;
            $data['course_id'] = $request->course_id ?? null;
            $data['assessor_type'] = $get_assessor_type == 1 ? 'desktop' : 'onsite';
            $data['due_date'] = Carbon::now()->addDay(366);
            $data['assessor_designation'] = $request->$assessor_designation;
            $data['assessor_category'] = "atab_assessor";

            $is_assign_assessor_date = DB::table('tbl_assessor_assign')->where(['application_id' => $request->application_id, 'assessor_id' => $request->assessor_id, 'assessor_type' => $request->assessor_type])->first();
            if ($is_assign_assessor_date != null) {
                $update_assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id' => $request->application_id, 'assessor_id' => $request->assessor_id, 'assessor_type' => $request->assessor_type])->update($data);
            } else {
                $create_assessor_assign = DB::table('tbl_assessor_assign')->insert($data);
            }
            if ($request->assessor_type === "desktop") {
                $assessment_type = 1;
            } else {
                $assessment_type = 2;
            }


            DB::table('tbl_application')->where('id', $request->application_id)->update(['admin_id' => Auth::user()->id, 'assessor_id' => $request->assessor_id]);

            DB::table('tbl_application_course_doc')->where(['application_id' => $request->application_id, 'assessor_type' => $assessor_types])->update(['admin_id' => Auth::user()->id, 'assessor_id' => $request->assessor_id]);

            /**
             * Mail Sending
             * 
             * */

            //admin mail
            $title = "Application Successfully Assigned | RAVAP-" . $request->application_id;
            $subject = "Application Successfully Assigned | RAVAP-" . $request->application_id;
            $body = "Dear Team," . PHP_EOL . "

                I hope this message finds you well. We are thrilled to inform you that you have assigned the " . $request->application_id . " to the assessor.

                Here are the transaction details: " . PHP_EOL . "
                Position: Admin " . PHP_EOL . "
                Reporting to: " . $assessor_details->firstname . " " . PHP_EOL . "
                Start Date: " . $assessor_details->created_at . "
                
                Best regard," . PHP_EOL . "
                RAV Team";

            $details['email'] = Auth::user()->email;
            $details['title'] = $title;
            $details['subject'] = $subject;
            $details['body'] = $body;
            dispatch(new SendEmailJob($details));
            /*end here*/

            //assessor mail
            $title = "Assignment Confirmation - Welcome Aboard! | RAVAP-" . $request->application_id;
            $subject = "Assignment Confirmation - Welcome Aboard! | RAVAP-" . $request->application_id;
            $body = "Dear Team," . PHP_EOL . "

                I trust this message finds you well. I am delighted to inform you that you have assigned the application with RAVAP-" . $request->application_id . "." . PHP_EOL . "
                
                Best regard," . PHP_EOL . "
                RAV Team";

            $details['email'] = $assessor_details->email;
            $details['title'] = $title;
            $details['subject'] = $subject;
            $details['body'] = $body;
            dispatch(new SendEmailJob($details));
            /*end here*/

            //tp mail
            $title = "Application Successfully Assigned | RAVAP-" . $request->application_id;
            $subject = "Application Successfully Assigned | RAVAP-" . $request->application_id;
            $body = "Dear Team," . PHP_EOL . "

                I trust this message finds you well. I am delighted to inform you that application  with RAVAP-" . $request->application_id . " has been assigned to " . $assessor_details->firstname . "(Assessor) ." . PHP_EOL . "
                
                Best regard," . PHP_EOL . "
                RAV Team";

            $details['email'] = $assessor_details->email;
            $details['title'] = $title;
            $details['subject'] = $subject;
            $details['body'] = $body;
            dispatch(new SendEmailJob($details));
            /*end here*/

            if ($request->assessment_type == 2) {

                $data = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessor_id', '=', $request->assessor_id)->count() > 0;
                if ($data == false) {
                    $value = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessment_type', '=', '2')->count() > 0;
                    if ($value == false) {
                        $data = new asessor_application();
                        $data->assessor_id = $request->assessor_id;
                        $data->application_id = $request->application_id;
                        $data->status = 1;
                        $data->assessment_type = $assessment_type;
                        $data->due_date = $due_date = Carbon::now()->addDay(15);
                        $data->notification_status = 0;
                        $data->read_by = 0;
                        $data->assessment_way = $request->on_site_type;
                        $data->save();
                        return back()->with('success', 'Application has been successfully assigned to assessor');
                    } else {
                        $item = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessment_type', '=', '2')->first();
                        $data = asessor_application::find($item->id);
                        $data->assessor_id = $request->assessor_id;
                        $data->application_id = $request->application_id;
                        $data->status = 1;
                        $data->assessment_type = $assessment_type;
                        $data->due_date = $due_date = Carbon::now()->addDay(15);
                        $data->notification_status = 0;
                        $data->read_by = 0;
                        $data->assessment_way = $request->on_site_type;
                        $data->save();
                        return back()->with('success', 'Application has been successfully assigned to assessor');
                    }
                } else {
                    $value = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessor_id', '=', $request->assessor_id)->first();
                    // dd($value);
                    $data = asessor_application::find($value->id);
                    $data->assessor_id = $request->assessor_id;
                    $data->application_id = $request->application_id;
                    $data->status = 1;
                    $data->assessment_type = $assessment_type;
                    $data->due_date = $due_date = Carbon::now()->addDay(15);
                    $data->notification_status = 0;
                    $data->read_by = 0;
                    $data->assessment_way = $request->on_site_type;
                    $data->save();
                    DB::commit();
                    return redirect()->route('admin-app-list')->with('success', 'Application has been successfully assigned to assessor');
                }
            } else {

                AssessorApplication::where('application_id', $request->application_id)->delete();
                $assessor = $request->assessor_id;
                $newApplicationAssign = new AssessorApplication;
                $newApplicationAssign->application_id = $request->application_id;
                $newApplicationAssign->assessment_type = $assessment_type;
                $newApplicationAssign->assessor_id = $assessor;
                $newApplicationAssign->status = 1;
                $newApplicationAssign->notification_status = 0;
                $newApplicationAssign->read_by = 0;
                $newApplicationAssign->assessment_way = $request->on_site_type;
                $newApplicationAssign->save();
                // dd("hello");
                DB::commit();
                return redirect()->route('admin-app-list')->with('success', 'Application has been successfully assigned to assessor');
            }
        } catch (Exception $e) {
            DB::rolback();
            return redirect()->back()->with('fail', $e->getMessage());
        }
    }
    public function applicationDocumentList($id, $course_id)
    {
        $tp_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;
        $data = TblApplicationPayment::where('application_id', $application_id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id' => $application_id,
            'application_courses_id' => $course_id,
            'assessor_type' => 'desktop'
        ])
            ->select('id', 'doc_unique_id', 'doc_file_name', 'doc_sr_code', 'admin_nc_flag', 'assessor_type', 'status')
            ->get();
        $onsite_course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id' => $application_id,
            'application_courses_id' => $course_id,
            'assessor_type' => 'onsite'
        ])
            ->select('id', 'doc_unique_id', 'onsite_doc_file_name', 'doc_file_name', 'doc_sr_code', 'assessor_type', 'onsite_status', 'onsite_nc_status', 'admin_nc_flag', 'status')
            ->get();
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
                        ->get(),
                    'onsite_nc_comments' => TblNCComments::where([
                        'application_id' => $application_id,
                        'application_courses_id' => $course_id,
                        'doc_unique_id' => $question->id,
                        'doc_sr_code' => $question->code,
                        'assessor_type' => 'onsite'
                    ])
                        ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                        ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                        ->get(),
                ];
            }
            $final_data[] = $obj;
        }
        $applicationData = TblApplication::find($application_id);
        return view('admin-view.application-documents-list', compact('final_data', 'onsite_course_doc_uploaded', 'course_doc_uploaded', 'application_id', 'course_id', 'applicationData'));
    }
    public function adminVerfiyDocument($nc_type, $assessor_type, $doc_sr_code, $doc_name, $application_id, $doc_unique_code, $application_course_id)
    {

        try {
            $accept_nc_type_status = $nc_type;
            $final_approval = TblNCComments::where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code, 'assessor_type' => 'admin', 'final_status' => $assessor_type])
                ->where('nc_type', "Request_For_Final_Approval")
                ->latest('id')->first();

            // dd($final_approval);
            $ass_type = $assessor_type == "desktop" ? "desktop" : "onsite";

            if ($nc_type == "nr") {
                $nc_type = "not_recommended";
            }

            if ($nc_type != "nc1" && $nc_type != "nc2" && $nc_type != "accept" && $nc_type != "reject") {
                if (!empty($final_approval)) {
                    $nc_type = "Request_For_Final_Approval";
                    $assessor_type = "admin";
                } else {
                    $ass_type = null;
                }
            }

            // $nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
            // ->where('nc_type',$nc_type)
            // ->where('assessor_type',$assessor_type)
            // ->where('final_status',$ass_type)
            // ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            // ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            // ->first();

            $query = TblNCComments::where([
                'doc_sr_code' => $doc_sr_code,
                'application_id' => $application_id,
                'doc_unique_id' => $doc_unique_code
            ])
                ->where('nc_type', $nc_type)
                ->where('assessor_type', $assessor_type);
            if ($nc_type == "not_recommended" || $nc_type == "Request_For_Final_Approval") {
                $query->where('final_status', $ass_type);
            }
            $nc_comments = $query
                ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                ->first();

            // dd($nc_comments);

            $tbl_nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code])
                ->where('final_status', $ass_type)
                ->latest('id')
                ->first();



            /*Don't show form if doc is accepted*/
            $accepted_doc = TblNCComments::where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code])
                ->whereIn('nc_type', ["Accept", "Reject"])
                ->where('final_status', $assessor_type)
                ->latest('id')
                ->first();

            /*end here*/
            $form_view = 0;
            if ($nc_type === "not_recommended" && ($tbl_nc_comments->nc_type !== "Reject") && ($tbl_nc_comments->nc_type !== "Accept") && ($tbl_nc_comments->nc_type !== "NC1") && ($tbl_nc_comments->nc_type !== "NC2") && ($tbl_nc_comments->nc_type !== "Request_For_Final_Approval")) {
                if (empty($accepted_doc)) {
                    $form_view = 1;
                }
            } else if ($nc_type == "reject") {
                $form_view = 0;
            }


            if (isset($tbl_nc_comments->nc_type)) {
                if ($tbl_nc_comments->nc_type === "not_recommended") {
                    $dropdown_arr = array(
                        "Reject" => "Reject",
                        "Accept" => "Accept",
                        "Request_For_Final_Approval" => 'Request For Final Approval'
                    );
                }
            }
            $doc_latest_record = TblApplicationCourseDoc::latest('id')
                ->where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code])
                ->first();
            // $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
            $doc_path = URL::to("/level") . '/' . $doc_name;
            return view('admin-view.document-verify', [
                'doc_latest_record' => $doc_latest_record,
                'doc_id' => $doc_sr_code,
                'doc_code' => $doc_unique_code,
                'application_id' => $application_id,
                'application_course_id' => $application_course_id,
                'doc_path' => $doc_path,
                'doc_file_name' => $doc_name,
                'dropdown_arr' => $dropdown_arr ?? [],
                'nc_comments' => $nc_comments,
                'form_view' => $form_view,
                'assessor_type' => $assessor_type,
                'nc_type' => $nc_type,
            ]);
        } catch (Exception $e) {
            return back()->with('fail', 'Something went wrong');
        }
    }
    public function adminDocumentVerify(Request $request)
    {
        try {
            $redirect_to = URL::to("/admin/document-list") . '/' . dEncrypt($request->application_id) . '/' . dEncrypt($request->application_courses_id);
            DB::beginTransaction();
            $assessor_id = Auth::user()->id;
            $assessor_type = 'admin';
            /*end here*/
            $data = [];
            $data['application_id'] = $request->application_id;
            $data['doc_sr_code'] = $request->doc_sr_code;
            $data['doc_unique_id'] = $request->doc_unique_id;
            $data['application_courses_id'] = $request->application_courses_id;
            $data['assessor_type'] = $assessor_type;
            $data['comments'] = $request->comments;
            $data['nc_type'] = $request->nc_type;
            $data['assessor_id'] = $assessor_id;
            $data['doc_file_name'] = $request->doc_file_name;
            $data['final_status'] = $request->assessor_type;

            $nc_comment_status = "";
            $admin_nc_flag = 0;
            if ($request->nc_type === "Accept") {
                $nc_comment_status = 1;
                $admin_nc_flag = 1;
                $nc_flag = 0;
            } else if ($request->nc_type == "Reject") {
                $nc_comment_status = 1;
                $admin_nc_flag = 2;
                $nc_flag = 0;
            } else {
                $admin_nc_flag = 3;
                $nc_comment_status = 4; //request for final approval
                $nc_flag = 1;
            }

            $create_nc_comments = TblNCComments::insert($data);

            if ($request->assessor_type == "onsite") {
                TblApplicationCourseDoc::where(['application_id' => $request->application_id, 'application_courses_id' => $request->application_courses_id, 'doc_sr_code' => $request->doc_sr_code, 'doc_unique_id' => $request->doc_unique_id, 'onsite_status' => 4])->update(['onsite_nc_status' => $nc_flag, 'admin_nc_flag' => $admin_nc_flag]);
            } else {
                TblApplicationCourseDoc::where(['application_id' => $request->application_id, 'application_courses_id' => $request->application_courses_id, 'doc_sr_code' => $request->doc_sr_code, 'doc_unique_id' => $request->doc_unique_id, 'status' => 4])->update(['nc_flag' => $nc_flag, 'admin_nc_flag' => $admin_nc_flag]);
            }



            if ($create_nc_comments) {
                DB::commit();
                return response()->json(['success' => true, 'message' => '' . $request->nc_type . ' comments created successfully', 'redirect_to' => $redirect_to], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to create ' . $request->nc_type . ' and documents'], 200);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }


    public function updateAdminNotificationStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
            DB::beginTransaction();

            $update_admin_received_payment_status = DB::table('tbl_application')->where('id', $id)->update(['admin_received_payment' => 1]);
            if ($update_admin_received_payment_status) {
                DB::commit();
                $redirect_url = URL::to('/admin/application-view/' . dEncrypt($id));
                return response()->json(['success' => true, 'message' => 'Read notification successfully.', 'redirect_url' => $redirect_url], 200);
            } else {
                DB::rollback();
                return response()->json(['success' => false, 'message' => 'Failed to read notification'], 200);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Failed to read notification'], 200);
        }
    }


   


}
