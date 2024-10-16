<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Level;
use App\Models\LevelRule;
use App\Models\Application;
use App\Models\SecretariatApplication;
use App\Models\ApplicationCourse;
use App\Models\ApplicationPayment;
use App\Models\ApplicationAcknowledgement;
use App\Models\ApplicationDocument;
use App\Models\DocumentType;
use App\Models\ApplicationReport;
use App\Models\asessor_application;
use App\Models\SummeryReport;
use App\Models\SummeryReportChapter;
use App\Mail\SendMail;
use App\Mail\paymentSuccessMail;
use App\Mail\secretariatapplicationmail;
use App\Mail\secretariatadminapplicationmail;

use App\Mail\assessoradminapplicationmail;
use App\Mail\assessorapplicationmail;
use App\Models\Add_Document;
use App\Models\AssessorApplication;
use App\Models\Chapter;
use App\Models\DocComment;
use App\Models\DocumentRemark;
use App\Models\User;
use App\Models\Event;
use App\Models\ImprovementForm;
use App\Models\Question;
use App\Models\SummaryReport;
use App\Models\SummaryReportChapter;
use Mail;
use DB;
use Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

class applicationController extends Controller
{


    public function show_pdf($name)
    {
        $data = $name;

        // dd("$data");

        return view('showfile', ['data' => $data]);
    }

    public function remarksData($applicationId, $courseId, $questionId)
    {


        $applicationData = Application::find($applicationId);

        $documents = Add_Document::where('question_id', $questionId)->where('application_id', $applicationId)->where('course_id', $courseId)->get();

        $remarks = DocumentRemark::where('application_id', $applicationId)->where('assessor_id', auth()->user()->id)->get();

        return view('remarks-index', compact('applicationData', 'documents', 'remarks'));
    }

    public function documentDetails($name, $applicationId, $document_id)
    {
        $data = $name;

        $remarks = DocumentRemark::where('document_id', $document_id)->where('application_id', $applicationId)->get();

        $tpId = Application::find($applicationId);
        $tpId = $tpId->user_id;

        $documentData = Add_Document::find($document_id);

        return view('showfile', ['data' => $data, 'remarks' => $remarks, 'application_id' => $applicationId, 'document_id' => $document_id, 'tpId' => $tpId, 'documentData' => $documentData]);
    }

    public function saveRemark(Request $request)
    {
        $request->validate([
            'remark' => 'required|max:100',
        ]);

        if (auth()->user()->role == 2) {
            $assessorId = DB::table('asessor_applications')->where('application_id', $request->application_id)->where('assessment_type', 1)->first(['assessor_id']);
            $assessorId = $assessorId->assessor_id;
        } else {
            $assessorId = auth()->user()->id;
        }

        DB::table('assessor_summary_reports')->where(['doc_unique_id'=>$request->document_id])->update(['capa_mark'=>$request->remark]);

        $saved = DocumentRemark::create([
            'application_id' => $request->application_id,
            'document_id' => $request->document_id,
            'assessor_id' => $assessorId,
            'tp_id' => $request->tpId,
            'remark' => $request->remark,
            'created_by' => auth()->user()->id
        ]);

        if ($saved) {
            return redirect()->back()->with('success', 'Remark Added Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function show_course_pdf($name)
    {
        // dd("yes");
        $data = $name;
        return view('course-document.show-course-file', ['data' => $data]);
    }

    public function Assigan_application(Request $request)
    {


        if ($request->assessment_type == 2) {

            $data = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessor_id', '=', $request->assessor_radio)->count()  > 0;


            if ($data == false) {


                $value = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessment_type', '=', '2')->count() > 0;

                if ($value == false) {

                    $data = new asessor_application();
                    $data->assessor_id = $request->assessor_radio;
                    $data->application_id = $request->application_id;
                    $data->status = 1;
                    $data->assessment_type = $request->assessment_type;
                    $data->due_date = $due_date = Carbon::now()->addDay(15);
                    $data->notification_status = 0;
                    $data->read_by = 0;
                    $data->assessment_way = $request->on_site_type;
                    $data->save();
                    return  back()->with('success', 'Application has been successfully assigned to assessor');
                } else {
                    $item = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessment_type', '=', '2')->first();

                    $data = asessor_application::find($item->id);
                    $data->assessor_id = $request->assessor_radio;
                    $data->application_id = $request->application_id;
                    $data->status = 1;
                    $data->assessment_type = $request->assessment_type;
                    $data->due_date = $due_date = Carbon::now()->addDay(15);
                    $data->notification_status = 0;
                    $data->read_by = 0;
                    $data->assessment_way = $request->on_site_type;
                    $data->save();
                    return  back()->with('success', 'Application has been successfully assigned to assessor');
                }
            } else {


                $value = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessor_id', '=', $request->assessor_radio)->first();

                //dd($value);
                $data = asessor_application::find($value->id);
                $data->assessor_id = $request->assessor_radio;
                $data->application_id = $request->application_id;
                $data->status = 1;
                $data->assessment_type = $request->assessment_type;
                $data->due_date = $due_date = Carbon::now()->addDay(15);
                $data->notification_status = 0;
                $data->read_by = 0;
                $data->assessment_way = $request->on_site_type;
                $data->save();
                return  back()->with('success', 'Application has been successfully assigned to assessor');
            }
        } else {

            AssessorApplication::where('application_id', $request->application_id)->delete();

            $assessor = $request->assessor_id;

            $newApplicationAssign = new AssessorApplication;
            $newApplicationAssign->application_id = $request->application_id;
            $newApplicationAssign->assessment_type = $request->assessment_type;
            $newApplicationAssign->assessor_id = $assessor;
            $newApplicationAssign->status = 1;

            $newApplicationAssign->notification_status = 0;
            $newApplicationAssign->read_by = 0;



            $newApplicationAssign->save();
            $superadminEmail = 'superadmin@yopmail.com';
            $adminEmail = 'admin@yopmail.com';

            $mailData = [
                'from' => "Admin",
                'applicationNo' => $request->application_id,
                'applicationStatus' => "Admin Assigned Application to Assessor Successfully",
                'subject' => "Application Assigned",
            ];

            Mail::to([$superadminEmail, $adminEmail])->send(new SendMail($mailData));


            $assessor_email = User::select('email')->where('id', $assessor)->first();

            $mailData = [
                'from' => "Admin",
                'applicationNo' => $request->application_id,
                'applicationStatus' => "Admin Assigned Application to Assessor Successfully",
                'subject' => "Application Assigned",
            ];

            Mail::to($assessor_email)->send(new SendMail($mailData));



            return redirect()->back()->with('success', 'Application assigned successfully');
        }
    }

    public function Assigan_application_old_27_10_2023(Request $request)
    {


        if ($request->assessment_type == 2) {

            $data = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessor_id', '=', $request->assessor_radio)->count()  > 0;


            if ($data == false) {


                $value = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessment_type', '=', '2')->count() > 0;

                if ($value == false) {

                    $data = new asessor_application();
                    $data->assessor_id = $request->assessor_radio;
                    $data->application_id = $request->application_id;
                    $data->status = 1;
                    $data->assessment_type = $request->assessment_type;
                    $data->due_date = $due_date = Carbon::now()->addDay(15);
                    $data->notification_status = 0;
                    $data->read_by = 0;
                    $data->save();
                    return  back()->with('success', 'Application has been successfully assigned to assessor');
                } else {
                    $item = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessment_type', '=', '2')->first();

                    $data = asessor_application::find($item->id);
                    $data->assessor_id = $request->assessor_radio;
                    $data->application_id = $request->application_id;
                    $data->status = 1;
                    $data->assessment_type = $request->assessment_type;
                    $data->due_date = $due_date = Carbon::now()->addDay(15);
                    $data->notification_status = 0;
                    $data->read_by = 0;
                    $data->save();
                    return  back()->with('success', 'Application has been successfully assigned to assessor');
                }
            } else {


                $value = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessor_id', '=', $request->assessor_radio)->first();

                //dd($value);
                $data = asessor_application::find($value->id);
                $data->assessor_id = $request->assessor_radio;
                $data->application_id = $request->application_id;
                $data->status = 1;
                $data->assessment_type = $request->assessment_type;
                $data->due_date = $due_date = Carbon::now()->addDay(15);
                $data->notification_status = 0;
                $data->read_by = 0;
                $data->save();
            }
        } else {

            $assessors = $request->assessor_id;

            foreach ($assessors as $key => $value) {
                $alreadyWorking = AssessorApplication::where('application_id', $request->application_id)->latest()->first();

                $exist = AssessorApplication::where('application_id', $request->application_id)->where('assessor_id', $value)->first();
                if (!$exist) {
                    $newApplicationAssign = new AssessorApplication;
                    $newApplicationAssign->application_id = $request->application_id;
                    $newApplicationAssign->assessment_type = $request->assessment_type;
                    $newApplicationAssign->assessor_id = $value;
                    $newApplicationAssign->status = 1;
                    if ($alreadyWorking) {

                        if ($alreadyWorking->notification_status > 0 && $alreadyWorking->read_by > 0) {
                            $newApplicationAssign->notification_status = $alreadyWorking->notification_status;
                            $newApplicationAssign->read_by = $alreadyWorking->read_by;
                        } else {
                            $newApplicationAssign->notification_status = 0;
                            $newApplicationAssign->read_by = 0;
                        }
                    } else {
                        $newApplicationAssign->notification_status = 0;
                        $newApplicationAssign->read_by = 0;
                    }


                    $newApplicationAssign->save();
                }
            }

            $superadminEmail = 'superadmin@yopmail.com';
            $adminEmail = 'admin@yopmail.com';

            $mailData = [
                'from' => "Admin",
                'applicationNo' => $request->application_id,
                'applicationStatus' => "Admin Assigned Application to Assessor Successfully",
                'subject' => "Application Assigned",
            ];

            Mail::to([$superadminEmail, $adminEmail])->send(new SendMail($mailData));

            foreach ($request->assessor_id as $assessorId) {
                $assessor_email = User::select('email')->where('id', $assessorId)->first();

                $mailData = [
                    'from' => "Admin",
                    'applicationNo' => $request->application_id,
                    'applicationStatus' => "Admin Assigned Application to Assessor Successfully",
                    'subject' => "Application Assigned",
                ];

                Mail::to($assessor_email)->send(new SendMail($mailData));
            }


            return redirect()->back()->with('success', 'Application assigned successfully');
        }
    }

    public function assigan_secretariat_application(Request $request)
    {
        //  dd("yesssd");
        //return $request->all();
        $value = DB::table('secretariat')->where('application_id', '=', $request->application_id)->get();
        if (count($value) > 0) {
            $data = DB::table('asessor_applications')->where('application_id', '=', $request->application_id);
            if ($data == false) {
                $assessor_id = $request->assessor_id;

                for ($i = 0; $i < count($assessor_id); $i++) {

                    $data = new asessor_application();
                    $data->assessor_id = $request->assessor_id[$i];
                    $data->application_id = $request->application_id;
                    $data->status = 1;
                    $data->assessment_type = $request->assessment_type;
                    $data->due_date = $due_date = Carbon::now()->addDay(15);
                    $data->save();
                }
                return  back()->with('sussess', 'Application has been successfully assigned to Secretariat');
            } else {
                return  back()->with('error', ' This application has already been assigned to this Secretariat ');
            }
        } else {
            $secretariat_id = $request->secretariat_id;
            //$secretariat_email=$request->sec_email;

            //return $request->sec_email;

            for ($i = 0; $i < count($secretariat_id); $i++) {

                $data = new SecretariatApplication();
                $data->secretariat_id = $request->secretariat_id[$i];
                $data->application_id = $request->application_id;
                $data->status = 1;
                $data->secretariat_type = $request->assessment_type;
                $data->due_date = $due_date = Carbon::now()->addDay(15);
                $data->save();

                //mail send
                $userEmail = 'superadmin@yopmail.com';
                $adminEmail = $request->sec_email;

                //Mail sending scripts starts here
                $applicationsecretariatMail = [
                    'title' => 'This Application is  Assigned to You by Admin  Successfully!!!!',
                    'body' => ''
                ];
                $application_id = $request->application_id;
                $username = Auth::user()->firstname;

                Mail::to([$userEmail, $adminEmail])->send(new secretariatapplicationmail($applicationsecretariatMail, $application_id, $username));

                $adminapplicationsecretariatMail = [
                    'title' => 'You have send this application to Assessor Successfully!!!!',
                    'body' => $request->sec_email,
                ];

                Mail::to([$userEmail])->send(new secretariatadminapplicationmail($adminapplicationsecretariatMail, $application_id, $username));
                //Mail sending script ends here




            }


            return  back()->with('sussess', 'Application has been successfully assigned to Secretariat');
        }
    }

    public  function internationl_index()
    {
        // SAARC Countries
        $collections = DB::table('applications')
            ->Where('applications.country', '=', 167)
            ->orWhere('applications.country', '=', 208)
            ->orWhere('applications.country', '=', 19)
            ->orWhere('applications.country', '=', 133)
            ->orWhere('applications.country', '=', 1)
            ->orderBy('applications.id', 'DESC')
            ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
            ->get();


        //rest of the would
        $collection = DB::table('applications')
            ->whereNot('applications.country', 167)
            ->whereNot('applications.country', 208)
            ->whereNot('applications.country', 19)
            ->whereNot('applications.country', 133)
            ->whereNot('applications.country', 1)
            ->whereNot('applications.country', 101)
            ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
            ->orderBy('applications.id', 'DESC')
            ->get();

        //dd($collection);
        if (count($collections) || count($collection)) {
            $assessordata = user::where('role', '3')->orderBy('id', 'DESC')->get();
            $secretariatdata = user::where('role', '5')->orderBy('id', 'DESC')->get();
            return view('application.internation_page', ['collection' => $collection, 'collections' => $collections, 'assesors' => $assessordata, 'secretariatdata' => $secretariatdata]);
        }
        return view('application.internation_page');
    }


    //    public function nationl_page()
    //    {
    //         $Application = DB::table('applications')
    //         ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
    //         ->where('applications.country','=',101)
    //         ->get();
    //         if(count($Application)){
    //         $assessordata = user::where('role','3')->orderBy('id','DESC')->get();

    //         return view('application.national',['collection'=>$Application,'assesors'=>$assessordata]);
    //         }
    //         return view('application.national');
    //    }


    public function nationl_accesser()
    {
        // $collection = DB::table('asessor_applications')->orderByDesc('asessor_applications.id')
        //     ->join('applications', 'asessor_applications.application_id', '=', 'applications.id')
        //     ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
        //     ->where('asessor_applications.assessor_id', '=', Auth::user()->id)
        //     ->where('applications.country', '=', 101)
        //     ->get();

        $collectionIds = AssessorApplication::where('assessor_id', Auth::user()->id)->get(['application_id']);
        $collection = Application::whereIn('id', $collectionIds)->latest()->get();
        $filteredApplications = [];

        foreach ($collection as $application) {
            $paymentAvailable = ApplicationPayment::where('application_id', $application->id)->first();

            if (isset($paymentAvailable)) {
                $filteredApplications[] = $application;
            }
        }

        $collection = $filteredApplications;

        if (count($collection)) {
            return view('application.accesser.national_accesser', ['collection' => $collection]);
        }


        return view('application.accesser.national_accesser');
    }

    public function internationl_accesser()
    {

        // SAARC Countries
        $collections = DB::table('asessor_applications')
            ->Where('applications.country', '=', 167)
            ->orWhere('applications.country', '=', 208)
            ->orWhere('applications.country', '=', 19)
            ->orWhere('applications.country', '=', 133)
            ->orWhere('applications.country', '=', 1)
            ->join('applications', 'asessor_applications.application_id', '=', 'applications.id')
            ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
            ->where('asessor_applications.assessor_id', '=', Auth::user()->id)
            ->get();

        //dd($collections);
        //rest of the would
        $collection = DB::table('asessor_applications')->whereNot('application_payments.country', 167)
            ->whereNot('application_payments.country', 208)
            ->whereNot('application_payments.country', 19)
            ->whereNot('application_payments.country', 133)
            ->whereNot('application_payments.country', 1)
            ->whereNot('application_payments.country', 101)
            ->join('applications', 'asessor_applications.application_id', '=', 'applications.id')
            ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
            ->where('asessor_applications.assessor_id', '=', Auth::user()->id)
            ->get();
        // dd($collection);
        if (count($collections) || count($collection)) {
            $assessordata = user::where('role', '3')->orderBy('id', 'DESC')->get();
            return view('application.accesser.internation_accesser', ['collections' => $collections, 'collection' => $collection]);
        }
        return view('application.accesser.internation_accesser');
    }

    function get_india_id()
    {
        $india = Country::where('name', 'India')->get('id')->first();
        return $india->id;
    }

    function get_saarc_ids()
    {
        //Afghanistan, Bangladesh, Bhutan, India, Maldives, Nepal, Pakistan and Sri-Lanka
        $saarc = Country::whereIn('name', array('Afghanistan', 'Bangladesh', 'Bhutan', 'Maldives', 'Nepal', 'Pakistan', 'Sri Lanka'))->get('id');
        $saarc_ids = array();
        foreach ($saarc as $val) $saarc_ids[] = $val->id;
        return $saarc_ids;
    }

    function get_application_india($status = '0', $date1 = '0', $date2 = '0')
    {
        //0 pending, 1 approved, 2 processing
        //$applications=Application::where('country',$this->get_india_id())->where('status',$status)->get();
        $applications = DB::table('applications')->select('applications.*', 'countries.name as country_name', 'states.name as state_name', 'level_information.level_information as level_name')->join('states', 'applications.state', '=', 'states.id')->join('countries', 'applications.country', '=', 'countries.id')->join('level_information', 'applications.level_id', '=', 'level_information.id')->where('country', $this->get_india_id())->get();
        return $applications;
    }

    function get_application_saarc($status = '0', $date1 = '0', $date2 = '0')
    {
        //0 pending, 1 approved, 2 processing
        // $applications=Application::whereIn('country',$this->get_saarc_ids())->where('status',$status)->get();
        $applications = DB::table('applications')->select('applications.*', 'countries.name as country_name', 'states.name as state_name', 'level_information.level_information as level_name')->join('states', 'applications.state', '=', 'states.id')->join('countries', 'applications.country', '=', 'countries.id')->join('level_information', 'applications.level_id', '=', 'level_information.id')->whereIn('country', $this->get_saarc_ids())->get();
        return $applications;
    }

    function get_application_world($status = '0', $date1 = '0', $date2 = '0')
    {
        //0 pending, 1 approved, 2 processing
        $india_id = $this->get_india_id();
        $saarc_ids = $this->get_saarc_ids();
        array_push($saarc_ids, $india_id);
        //dd($saarc_ids);
        // $applications=Application::whereNotIn('country',$saarc_ids)->where('status',$status)->get();
        //$applications=Application::whereNotIn('country',$saarc_ids)->get();
        $applications = DB::table('applications')->select('applications.*', 'countries.name as country_name', 'states.name as state_name', 'level_information.level_information as level_name')->join('states', 'applications.state', '=', 'states.id')->join('countries', 'applications.country', '=', 'countries.id')->join('level_information', 'applications.level_id', '=', 'level_information.id')->whereNotIn('country', $saarc_ids)->get();

        return $applications;
    }

    public function nationl_page()
    {
        $Application = Application::where('applications.country', '=', 101)
            ->orderBy('applications.id', 'DESC')
            ->get();

        if (count($Application)) {

            $assessordata = user::where('role', '3')->orderBy('id', 'DESC')->get();

            $secretariatdata = user::where('role', '5')->orderBy('id', 'DESC')->get();

            $begin = Carbon::now();
            $end = Carbon::now()->addDays(15);


            $fifteenthDaysadd = Carbon::now()->addDays(15)->format('Y-m-d');
            $events = Event::select('start')->where('asesrar_id', 76)->whereDate('start', '<=', $fifteenthDaysadd)->where('availability', 2)->get();

            $totalQuestion = Question::all();
            $totalQuestion = count($totalQuestion);

            return view('application.national', ['collection' => $Application, 'assesors' => $assessordata, 'secretariatdata' => $secretariatdata, 'totalQuestion' => $totalQuestion]);
        }
        return view('application.national');
    }

    public function assigin_check_delete(Request $request)
    {

        $existData = DB::table('asessor_applications')
            ->where('application_id', $request->id)
            ->where('assessor_id', $request->assessor_id)
            ->delete();

        $assignedToThisUser =  DB::table('asessor_applications')
            ->where('application_id', $request->id)
            ->where('assessor_id', $request->assessor_id)
            ->where('read_by', $request->assessor_id)
            ->first();

        if ($assignedToThisUser) {
            DB::table('asessor_applications')
                ->where('application_id', $request->id)
                ->update([
                    'notification_status' => 0,
                    'read_by' => 0,
                ]);
        }

        if ($existData) {
            return response()->json('success');
        } else {
            return response()->json('fail');
        }
    }


    public function applicationDetailData($id)
    {
        $applicationDetails = Application::find($id);
        $chapters = Chapter::all();
        return view('application.application-show', compact('applicationDetails', 'chapters'));
    }

    public function applicationDocumentsSummary($application_id)
    {
        $applicationDetails = SummeryReport::with('SummeryReportChapter')->where('application_id', $application_id)->first();
        if ($applicationDetails == null) {
            return redirect(url('nationl-page'))->with('warning', 'Summary report not created yet!');
        }
        if ($applicationDetails->application->desktop_status == null && $applicationDetails->application->onsite_status == null) {
            return redirect(url('nationl-page'))->with('warning', 'Summary report not created yet!');
        }
        $chapters = Chapter::all();
        return view('admin.application.document-summery-new', compact('chapters', 'applicationDetails'));
    }

    public function applicationDocumentsSummaryTP($application_id)
    {
        $applicationDetails = Application::find($application_id);
        $chapters = Chapter::all();
        return view('tp.application-summary', compact('chapters', 'applicationDetails'));
    }

    public function uploadDocumentByOnSiteAssessor($applicationID, $courseID, $questionID, $documentID)
    {
    
        $applicationData = Application::find($applicationID);
        $question = Question::find($questionID);
        $assessor_id = Auth::user()->id;
        return view('on-site-assessor.upload-document', compact('applicationData', 'courseID', 'questionID', 'documentID', 'question','assessor_id'));
    }

    public function uploadDocumentByOnSiteAssessorPost(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'remark' => 'required',
            'document' => 'required'
        ]);
      

        if ($request->hasfile('document')) {
            $file = $request->file('document');
            $name = $file->getClientOriginalName();
            $filename = time() . $name;
            $file->move('level/', $filename);
        }


            $commentTxt = $request->remark;


        if ($request->parent_doc_id) {
            Add_Document::where('id', $request->documentID)->update(['is_displayed_onsite' => 2]);
        }

/*Written By Suraj*/
        if($request->status==1){
            $nc_raise = "NC1";
        }
        else if($request->status==2){
            $nc_raise = "NC2";
        }
        else if($request->status==3){
            $nc_raise = "Not Approved";
        }
        else if($request->status==4){
            $nc_raise="Approved";
        }else{
            $nc_raise="Request for final approval";
        }
        $data=[];
        $data['application_id'] = $request->applicationID;
        $data['object_element_id'] = $request->questionID;
      
        $data['application_course_id'] = $request->courseID;
        $data['doc_sr_code'] = $request->question_code;
        $data['doc_unique_id'] = $request->documentID;
        
        $data['date_of_assessement'] = $request->date_of_assessement??'N/A';
        $data['assessor_id'] = Auth::user()->id;
        $data['assessor_type'] = $request->assessor_type??'onsite';
        $data['nc_raise'] = $nc_raise??'N/A';
        $data['nc_raise_code'] = $request->status??'N/A';
        $data['doc_path'] = $filename;
        $data['capa_mark'] = $request->capa_mark??'N/A';
        $data['doc_against_nc'] = $request->doc_against_nc??'N/A';
        $data['doc_verify_remark'] = $request->remark??'N/A';
        $create_summary_report = DB::table('assessor_summary_reports')->insert($data);
        /*end here*/

        $document = Add_Document::create([
            'assessor_id' => auth()->user()->id,
            'assesment_type' => auth()->user()->assessment == 1 ? 'desktop' : 'onsite',
            'question_id' => $request->questionID,
            'application_id' => $request->applicationID,
            'course_id' => $request->courseID,
            'doc_id' => $request->question_code,
            'doc_file' => $filename,
            'user_id' => $request->user_id,
            'on_site_assessor_Id' => auth()->user()->id,
        ]);

        // DocComment::create([
        //     'doc_id' => $request->documentID,
        //     'comments' => $commentTxt,
        //     'status' => $request->status,
        //     'doc_code' => $request->question_code,
        //     'user_id' => auth()->user()->id,
        //     'course_id' => $request->courseID,
        //     'by_onsite_assessor' => 1
        // ]);

        DocComment::create([
            'doc_id' => $document->id,
            'comments' => $commentTxt ?? '',
            'status' => $request->status,
            'doc_code' => $request->question_code,
            'user_id' => auth()->user()->id,
            'course_id' => $request->courseID,
            'by_onsite_assessor' => 1
        ]);




        if ($document) {
            return redirect(url('on-site/upload-document/' . $request->applicationID . '/' . $request->courseID . '/' . $request->questionID . '/' . $document->id))->with('success', 'Document status has been updated');
        } else {
            return redirect()->back()->with('error', 'Something went wrong. Please try again!');
        }
    }

    public function uploadPhotographByOnSiteAssessor($applicationID, $courseID, $questionID, $documentID)
    {
        $applicationData = Application::find($applicationID);
        $question = Question::find($questionID);
        return view('on-site-assessor.upload-photograph', compact('applicationData', 'courseID', 'questionID', 'documentID', 'question'));
    }

    public function uploadPhotographByOnSiteAssessorPost(Request $request)
    {

        $request->validate([
            'remark' => 'required',
            'document' => 'required'
        ]);

        if ($request->hasfile('document')) {
            $file = $request->file('document');
            $name = $file->getClientOriginalName();
            $filename = time() . $name;
            $file->move('level/', $filename);
        }



        // dd($request->all());

        $document = Add_Document::create([
            'question_id' => $request->questionID,
            'application_id' => $request->applicationID,
            'course_id' => $request->courseID,
            'doc_id' => $request->question_code,
            'doc_file' => $filename,
            'user_id' => $request->user_id,
            'on_site_assessor_Id' => auth()->user()->id,
            'photograph' => 1,
            'photograph_comment' => $request->remark,
        ]);

        if ($document) {
            return redirect()->back()->with('success', 'Document status has been updated');
        } else {
            return redirect()->back()->with('error', 'Something went wrong. Please try again!');
        }
    }


    public function paymentAcknowledge(Request $request)
    {
        $application = Application::find($request->applicationID);

        if (!$application) {
            // Handle the case where the application is not found
            return redirect()->back()->with('error', 'Application not found.');
        }

        $application->update([
            'is_payment_acknowledge' => 1,
            'acknowledged_by' => auth()->user()->id
        ]);

        return redirect()->back()->with('success', 'Payment has been successfully acknowledged.');
    }

    public function viewDocumentData($document, $document_id, $questionID, $application_id, $courseID)
    {
        $document = Add_Document::find($document_id);
        $question = Question::find($questionID);
        $applicationData = Application::find($application_id);
        return view('on-site-assessor.view-document', compact('document', 'question', 'applicationData', 'courseID', 'questionID'));
    }

    public function on_site_report_format(Request $request)
    {

        $applicationData = Application::find($request->input('application'));
        // $applicationAlreadySubmitted = SummaryReport::where('application_id', $request->input('application'))->where('course_id', $request->input('course'))->first();
        // if ($applicationAlreadySubmitted) {
        //     return redirect(url('opportunity-form/report?application=' . $applicationAlreadySubmitted->application_id . '&course=' . $request->course));
        // }
        $assessorDetail = AssessorApplication::where('application_id', $applicationData->id)->where('assessor_id', auth()->user()->id)->first();


        $courseDetail = ApplicationCourse::find($request->course);

        $chapters = Chapter::all();

        return view('on-site-assessor.on-site-report-form', compact('applicationData', 'courseDetail', 'assessorDetail', 'chapters'));
    }

    public function saveFormDataOnSite(Request $request)
    {
        $data = $request->all();
        $data['summary_type'] = 'onsite';

        $summaryReport = SummaryReport::create($data);

        $questionData = [];
        foreach ($data['question_ids'] as $key => $questionId) {
            $questionData[] = [
                'question_id' => $questionId,
                'nc_raised' => $data['nc_raised'][$key],
                'capa_training_provider' => $data['capa_training_provider'][$key],
                'document_submitted_against_nc' => $data['document_submitted_against_nc'][$key],
                'remark' => $data['remark'][$key],
                'summary_report_application_id' => $summaryReport->id,
            ];
        }

        $insrted = SummaryReportChapter::insert($questionData);

        if ($insrted) {
            return redirect(url('opportunity-form/report?application=' . $request->application_id . '&course=' . $request->course_id))->with('success', "Data saved successfully");
        }
    }

    
    public function opportunityForm(Request $request)
    {
//        $existingEntry = ImprovementForm::where('application_id', $request->input('application'))
//            ->where('course_id', $request->input('course'))
//            ->first();
//
//        if ($existingEntry) {
//            // Entry already exists, redirect with flash message
//            return redirect(url('nationl-accesser'))->with('success', 'Report already exists for the given application and course.');
//        }
        $applicationData = Application::find($request->input('application'));
        $assessorDetail = AssessorApplication::where('application_id', $applicationData->id)->where('assessor_id', auth()->user()->id)->first();

        $courseDetail = ApplicationCourse::find($request->course);

        $chapters = Chapter::all();
        return view('on-site-assessor.opportunityForm', compact('applicationData', 'courseDetail', 'assessorDetail', 'chapters'));
    }

    public function saveImprovmentForm(Request $request)
    {

        $existingEntry = ImprovementForm::where('application_id', $request->application_id)
            ->where('course_id', $request->course_id)
            ->first();

        if ($existingEntry) {
            // Entry already exists, redirect with flash message
            return redirect(url('nationl-accesser'))->with('success', 'Report already exists for the given application and course.');
        }
        $data = $request->all(); // Assuming you are receiving this data in a request

        // Insert into ImprovementForm table
        $improvementForm = ImprovementForm::create($data);

        $application = Application::find($request->application_id);

        $application->update([
            'onsite_status' => 1,
        ]);

        return redirect(url('nationl-accesser'))->with('success', 'Report already exists for the given application and course.');
    }

    public function summaryReport(Request $request)
    {
        $applicationDetails = Application::find($request->input('application'));
        $chapters = Chapter::all();
        $improvementForm = ImprovementForm::where('application_id', $request->input('application'))->first();
        $summaryReport = SummaryReport::where('summary_type', 'onsite')->where('course_id', $request->input('course'))->where('application_id', $request->input('application'))->first();
        $course = $request->input('course');
        $mandays = DB::table('assessor_assigne_date')->where('assessor_id', auth()->user()->id)->where('application_id', $request->input('application'))->where('assesment_type', 2)->get();
        $mandays = count($mandays);


        $documentIds = Add_Document::where('course_id', $request->input('course'))->where('application_id', $request->input('application'))->get(['id']);
        $totalNc = DocComment::whereIn('doc_id', $documentIds)->where('status', '!=', 4)->where('status', '!=', 3)->get()->count();
        $totalAccepted = DocComment::whereIn('doc_id', $documentIds)->where('status', 4)->get()->count();

        return view('on-site-assessor.final-summary', compact('applicationDetails', 'chapters', 'improvementForm', 'summaryReport', 'course', 'mandays', 'totalNc', 'totalAccepted'));
    }

    public function getSummariesList(Request $request)
    {
        $courses=DB::table('application_courses as app_crs')
        ->select('app_crs.*','final_summary_repo.application_id')
        ->leftJoin('assessor_final_summary_reports as final_summary_repo', 'final_summary_repo.application_course_id', '=', 'app_crs.id')
        ->where('app_crs.application_id',$request->input('application'))
        ->get();

        $collection = collect($courses);
        $courses = $collection->unique(function ($item) {
            return $item->course_name;
        })->values()->all();
        
        // $courses = ApplicationCourse::where('application_id', $request->input('application'))->get();
        $applicationDetails = Application::find($request->input('application'));
        return view('on-site-assessor.summary-list', compact('courses', 'applicationDetails'));
    }

    public function saveSelectedDates(Request $request)
    {
        DB::beginTransaction();
        // dd($request->all());

        if($request->assessmentType==1){
            DB::table('assessor_assigne_date')
            ->where('assessor_Id', $request->assessorID)
            ->where('application_id', $request->applicationID)
            ->delete();
        }

        $exitValCheck = DB::table('assessor_assigne_date')->where('assessor_Id', $request->assessorID)
            ->where('application_id', $request->applicationID)
            ->where('selected_date', $request->selectedDate)
            ->first();

        if ($exitValCheck != null) {
                $get_all_dates = DB::table('assessor_assigne_date')
                ->where([
                'assessor_Id' => $request->assessorID,
                'assesment_type' => $request->assessmentType,
                'application_id' => $request->applicationID
                ])
                ->get()
                ->pluck('selected_date')->toArray();
                $flag = 0;
                 $is_consecutive_dates = $this->checkDates($get_all_dates);
                $query =  DB::table('assessor_assigne_date');
                $query->where('assessor_Id', $request->assessorID);
                $query->where('application_id', $request->applicationID);
                if($is_consecutive_dates){
                    $query->where('selected_date', $request->selectedDate);
                    $flag=1;
                }
                $query->delete();
                DB::commit();
                if($flag==1){
                    return response()->json(['status' => '201', 'message' => 'all_deleted']);
                }else{
                    return response()->json(['status' => '201', 'message' => 'deleted']);
                }
        } else {
            //dd($exitValCheck);
            DB::table('assessor_assigne_date')->insert([
                'assessor_Id' => $request->assessorID,
                'assesment_type' => $request->assessmentType,
                'application_id' => $request->applicationID,
                'selected_date' => $request->selectedDate,
                'status' => 1
            ]);

            $get_all_dates = DB::table('assessor_assigne_date')
                ->where([
                'assessor_Id' => $request->assessorID,
                'assesment_type' => $request->assessmentType,
                'application_id' => $request->applicationID
                ])
                ->get()
                ->pluck('selected_date')->toArray();


            $is_consecutive_dates = $this->checkDates($get_all_dates);
            if($is_consecutive_dates){
                DB::commit();
                return response()->json(['status' => '200', 'message' => 'inserted']);
            }else{
                DB::rollBack();
                return response()->json(['status' => '200', 'message' => 'failed']);
            }
        }
    }

    public function checkDates($dates)
    {
        // dd($dates);
        // Convert the date strings to Carbon instances
        $carbonDates = array_map(function($dates) {
            return Carbon::createFromFormat('Y-m-d', $dates);
        }, $dates);
        
        // Sort the dates just in case they are not in order
        usort($carbonDates, function($a, $b) {
            return $a->timestamp - $b->timestamp;
        });

        // Check if each date is one day after the previous date
        for ($i = 1; $i < count($carbonDates); $i++) {
            if (!$carbonDates[$i]->isSameDay($carbonDates[$i - 1]->copy()->addDay())) {
               return false;
            }
        }
        return true;
    }

    public function submitFinalRemark(Request $request)
    {
        $application = Application::find($request->application_id);
        if ($request->hasfile('gps_pic')) {
            $file = $request->file('gps_pic');
            $name = $file->getClientOriginalName();
            $filename = time() . $name;
            $file->move('level/', $filename);
        }


        if ($application) {
            $application->update([
                'final_remark' => $request->remark,
                'gps_pic' => $filename,
            ]);

            return redirect()->back()->with('success', 'Remark and GPS Picture has been updated');
        }
    }

    public function getapplicationcourses($applicationID)
    {
        $courses = ApplicationCourse::where('application_id', $applicationID)->get();
        $applicationData = Application::find($applicationID);
        return view('tp.course-list', compact('courses', 'applicationData'));
    }

    public function getSummaryReportDataTP($course, $application)
    {
        $checkSummaryReport = SummaryReport::where('course_id', $course)->where('application_id', $application)->get();
        if (count($checkSummaryReport) == 0) {
            return redirect()->back()->with('warning', 'Report not created yet!');
        }
        $applicationDetails = Application::find($application);
        $chapters = Chapter::all();
        $summaryReport = SummaryReport::where('summary_type', 'onsite')->where('course_id', $course)->where('application_id', $application)->first();
        $improvementForm = ImprovementForm::where('course_id', $course)->where('application_id', $application)->first();

        $documentIds = Add_Document::where('course_id', $course)->where('application_id', $application)->get(['id']);
        $totalNc = DocComment::whereIn('doc_id', $documentIds)->where('status', '!=', 4)->where('status', '!=', 3)->get()->count();
        $totalAccepted = DocComment::whereIn('doc_id', $documentIds)->where('status', 4)->get()->count();

        return view('tp.final-summary-report', compact('applicationDetails', 'chapters', 'improvementForm', 'summaryReport', 'course', 'totalNc', 'totalAccepted'));
    }

    public function getAdminApplicationCoursesLIst($applicationID)
    {
        $courses = ApplicationCourse::where('application_id', $applicationID)->get();
        $applicationData = Application::find($applicationID);
        return view('admin.summary.courses-list', compact('courses', 'applicationData'));
    }

    public function getAdminApplicationSummary($courseID, $applicationID)
    {
        $checkSummaryReport = SummaryReport::where('course_id', $courseID)->where('application_id', $applicationID)->get();
        if (count($checkSummaryReport) == 0) {
            return redirect()->back()->with('warning', 'Report not created yet!');
        }
        $applicationDetails = Application::find($applicationID);
        $chapters = Chapter::all();
        $summaryReport = SummaryReport::where('summary_type', 'onsite')->where('course_id', $courseID)->where('application_id', $applicationID)->first();
        $improvementForm = ImprovementForm::where('course_id', $courseID)->where('application_id', $applicationID)->first();
        $course = $courseID;

        $documentIds = Add_Document::where('course_id', $courseID)->where('application_id', $applicationID)->get(['id']);
        $totalNc = DocComment::whereIn('doc_id', $documentIds)->where('status', '!=', 4)->where('status', '!=', 3)->get()->count();
        $totalAccepted = DocComment::whereIn('doc_id', $documentIds)->where('status', 4)->get()->count();


        return view('admin.application.document-summery-new', compact('applicationDetails', 'chapters', 'improvementForm', 'summaryReport', 'course', 'totalNc', 'totalAccepted'));
    }
}
