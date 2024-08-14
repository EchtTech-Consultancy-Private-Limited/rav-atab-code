<?php
namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Application;
use App\Models\TblApplication;
use App\Models\TblApplicationCourses;
use App\Models\ApplicationCourse;
use App\Models\ApplicationPayment;
use App\Models\ApplicationDocument;
use App\Models\LevelInformation;
use App\Models\DocumentReportVerified;
use App\Models\AcknowledgementRecord;
use App\Models\SummeryReport;
use App\Models\SummeryReportChapter;
use App\Models\User;
use App\Models\Faq;
use App\Models\SummaryReport;
use App\Models\SummaryReportChapter;
use App\Models\ApplicationLevel2;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;
use Redirect;
use Auth;
use File;
use Session;
use DB;
use Carbon\Carbon;
use PDF;
use Mail;
use App\Mail\SendMail;
use App\Mail\SendAcknowledgment;
use App\Mail\AdmintoAssessorSingleFinalMail;
use App\Mail\assessorAdminFinalApplicationMail;
use App\Mail\adminSingleDocumentMail;
use App\Mail\uploadDocumentFirstMail;
use App\Mail\tpAdminApplicationmail;
use App\Mail\assessorFinalApplicationMail;
use App\Mail\assessorToself;
use App\Mail\assessorSingleAdminFinalApplicationMail;
use App\Mail\assessorSingleFinalMail;

use App\Mail\tpApplicationmail;
use App\Http\Traits\PdfImageSizeTrait;

use App\Models\Add_Document;
use App\Models\DocComment;
use App\Models\Chapter;
use App\Mail\paymentSuccessMail;
use App\Models\ApplicationNotification;
use App\Models\AssessorApplication;
use Str;

class RenewalController extends Controller
{
    use PdfImageSizeTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){
        return view('renewal-view.create-application');
    }
    public function renewalCreate(Request $request){
        
    }

    public function level1tp(Request $request, $id = null)
    {
        
        if ($request->input('display') == 'applications') {
            Session::put('session_for_redirections', 'application-payment');
        }
        if ($id != null) {
            Session::put('session_for_redirections', 'add-course');
        }

        //dd("we are work on manage ");
        $form_step_type = Session::get('session_for_redirections');

        $payment_list = "active_payment_list";
        /*
         if(empty($form_step_type))
         {
            $form_step_type="withour-session-step";
         }
        */

        //dd('hii');

        //return $form_step_type;

        //  return $id;

        if ($id) {


            $id = $id;
            $faqs = Faq::where('category', 1)->orderby('sort_order', 'Asc')->get();
            $item = LevelInformation::whereid('1')->get();
            $file = ApplicationDocument::get();

            $Application = Application::find($id);
            /*$course=ApplicationCourse::whereapplication_id($id)->wherestatus('0')->whereuser_id(Auth::user()->id)->wherelevel_id(2)->get();*/
            $course = ApplicationCourse::whereapplication_id($id)->wherestatus('0')->whereuser_id(Auth::user()->id)->get();

            //   dd($course);
            /*$collection=ApplicationPayment::orderBy('id','desc')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();*/

            //we show previous application listing without copmare level below

            $collection = ApplicationPayment::orderBy('id', 'desc')->whereuser_id(Auth::user()->id)->get();
            $collections = Application::orderBy('id', 'desc')->whereid($id)->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->first();

            if (Auth::user()->country == $this->get_india_id()) {

                if (count($course) == '0') {
                    $currency = '₹';
                    $total_amount = '0';
                } elseif (count($course) <= 5) {
                    $currency = '₹';
                    $total_amount = '1000';
                } elseif (count($course) <= 10) {
                    $currency = '₹';
                    $total_amount =  '2000';
                } else {
                    $currency = '₹';
                    $total_amount =   '3000';
                }
            } elseif (in_array(Auth::user()->country, $this->get_saarc_ids())) {
                if (count($course) == '0') {
                    $currency = 'US $';
                    $total_amount = '0';
                } elseif (count($course) <= 5) {
                    $currency = 'US $';
                    $total_amount =  '15';
                } elseif (count($course) <= 10) {
                    $currency = 'US $';
                    $total_amount = '30';
                } else {
                    $currency = 'US $';
                    $total_amount =  '45';
                }
            } else {

                if (count($course) == '0') {
                    $currency = 'US $';
                    $total_amount = '';
                } elseif (count($course) <= 5) {
                    $currency = 'US $';
                    $total_amount = '50';
                } elseif (count($course) <= 10) {
                    $currency = 'US $';
                    $total_amount = '100';
                } else {
                    $currency = 'US $';
                    $total_amount =  '150';
                }
            }

            $id = Auth::user()->id;
            $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
            $Country = Country::get();

            /*level list */

            $level_list_data = DB::table('applications')
                ->where('applications.user_id', Auth::user()->id)
                ->where('applications.status', '0')
                ->select('applications.*', 'countries.name as country_name')
                ->join('countries', 'applications.country', '=', 'countries.id')->get();
            /*end level list */

            return view('level.leveltp', ['level_list_data' => $level_list_data, 'id' => $id, 'collections' => $collections, 'Application' => $Application, 'item' => $item, 'Country' => $Country, 'data' => $data, 'course' => $course, 'currency' => $currency, 'total_amount' => $total_amount, 'collection' => $collection, 'file' => $file, 'faqs' => $faqs], compact('form_step_type', 'payment_list'));
        } else {

            // dd("ds");
            $id = Auth::user()->id;
            $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
            $Country = Country::get();
            $faqs = Faq::where('category', 1)->orderby('sort_order', 'Asc')->get();
            $item = LevelInformation::whereid('1')->get();

            /*$course=ApplicationCourse::whereapplication_id($id)->wherestatus('0')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();*/
            
            if(isset($item[0])){
            $course = ApplicationCourse::whereapplication_id($id)->wherestatus('0')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
       
            /*$collection=ApplicationPayment::orderBy('id','desc')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();*/

            //we show previous application listing without copmare level below

            $collection = ApplicationPayment::orderBy('id', 'desc')->whereuser_id(Auth::user()->id)->get();
            //dd("$collection");
            $collections = Application::orderBy('id', 'desc')->whereid($id)->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->first();
            $Application = new Application;

            $course = ApplicationCourse::get();

            if (Auth::user()->country == $this->get_india_id()) {

                if (count($course) == '0') {
                    $currency = '₹';
                    $total_amount = '0';
                } elseif (count($course) <= 5) {
                    $currency = '₹';
                    $total_amount = '1000';
                } elseif (count($course) <= 10) {
                    $currency = '₹';
                    $total_amount =  '2000';
                } else {
                    $currency = '₹';
                    $total_amount =   '3000';
                }
            } elseif (in_array(Auth::user()->country, $this->get_saarc_ids())) {
                if (count($course) == '0') {
                    $currency = 'US $';
                    $total_amount = '0';
                } elseif (count($course) <= 5) {
                    $currency = 'US $';
                    $total_amount =  '15';
                } elseif (count($course) <= 10) {
                    $currency = 'US $';
                    $total_amount = '30';
                } else {
                    $currency = 'US $';
                    $total_amount =  '45';
                }
            } else {

                if (count($course) == '0') {
                    $currency = 'US $';
                    $total_amount = '';
                } elseif (count($course) <= 5) {
                    $currency = 'US $';
                    $total_amount = '50';
                } elseif (count($course) <= 10) {
                    $currency = 'US $';
                    $total_amount = '100';
                } else {
                    $currency = 'US $';
                    $total_amount =  '150';
                }
            }
            /*level list */
        }
            $level_list_data = DB::table('applications')
                ->where('applications.user_id', Auth::user()->id)
                ->where('applications.status', '0')
                ->select('applications.*', 'countries.name as country_name')
                ->join('countries', 'applications.country', '=', 'countries.id')->orderBy('applications.id', 'desc')->get();
            /*end level list */
            $collection = "";
            $collections="";
            return view('level.leveltp', ['level_list_data' => $level_list_data, 'collection' => $collection, 'collections' => $collections, 'item' => $item, 'data' => $data, 'faqs' => $faqs], compact('form_step_type'));
        }
    }

    
    public function level2tp()
    {
        $faqs = Faq::where('category', 2)->orderby('sort_order', 'Asc')->get();

        $item = LevelInformation::whereid('2')->get();
        $Application = Application::whereuser_id(Auth::user()->id)->first();
        $collection = ApplicationPayment::whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
        $course = ApplicationCourse::wherestatus('0')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
        if (Auth::user()->country == $this->get_india_id()) {

            if (count($course) == '0') {
                $currency = '₹';
                $total_amount = '0';
            } elseif (count($course) <= 5) {
                $currency = '₹';
                $total_amount = '2500';
            } elseif (count($course) <= 10) {
                $currency = '₹';
                $total_amount =  '5000';
            } else {
                $currency = '₹';
                $total_amount =   '10000';
            }
        } elseif (in_array(Auth::user()->country, $this->get_saarc_ids())) {


            if (count($course) == '0') {
                $currency = 'US $';
                $total_amount = '0';
            } elseif (count($course) <= 5) {
                $currency = 'US $';
                $total_amount =  '35';
            } elseif (count($course) <= 10) {
                $currency = 'US $';
                $total_amount = '75';
            } else {
                $currency = 'US $';
                $total_amount =  '150';
            }
        } else {

            if (count($course) == '0') {
                $currency = 'US $';
                $total_amount = '0';
            } elseif (count($course) <= 5) {
                $currency = 'US $';
                $total_amount = '100';
            } elseif (count($course) <= 10) {
                $currency = 'US $';
                $total_amount = '200';
            } else {
                $currency = 'US $';
                $total_amount =  '400';
            }
        }
        $id = Auth::user()->id;
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $Country = Country::get();
        return view('level.leveltp', ['Application' => $Application, 'item' => $item, 'Country' => $Country, 'data' => $data, 'course' => $course, 'currency' => $currency, 'collection' => $collection, 'total_amount' => $total_amount, 'faqs' => $faqs]);
    }


    public function level3tp()
    {
        $faqs = Faq::where('category', 3)->orderby('sort_order', 'Asc')->get();

        $item = LevelInformation::whereid('3')->get();
        $course = ApplicationCourse::wherestatus('0')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
        //  dd($course);
        $Application = Application::whereuser_id(Auth::user()->id)->first();
        $collection = ApplicationPayment::whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();

        if (Auth::user()->country == $this->get_india_id()) {


            if (count($course) == '0') {
                $currency = '₹';
                $total_amount = '0';
            } elseif (count($course) <= 5) {
                $currency = '₹';
                $total_amount = '1000';
            } elseif (count($course) <= 10) {
                $currency = '₹';
                $total_amount =  '2000';
            } else {
                $currency = '₹';
                $total_amount =   '3000';
            }
        } elseif (in_array(Auth::user()->country, $this->get_saarc_ids())) {


            if (count($course) == '0') {
                $currency = 'US $';
                $total_amount = '0';
            } elseif (count($course) <= 5) {
                $currency = 'US $';
                $total_amount =  '15';
            } elseif (count($course) <= 10) {
                $currency = 'US $';
                $total_amount = '30';
            } else {
                $currency = 'US $';
                $total_amount =  '45';
            }
        } else {

            if (count($course) == '0') {
                $currency = 'US $';
                $total_amount = '';
            } elseif (count($course) <= 5) {
                $currency = 'US $';
                $total_amount = '50';
            } elseif (count($course) <= 10) {
                $currency = 'US $';
                $total_amount = '100';
            } else {
                $currency = 'US $';
                $total_amount =  '150';
            }
        }
        $id = Auth::user()->id;

        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $Country = Country::get();
        return view('level.leveltp', ['Application' => $Application, 'item' => $item, 'Country' => $Country, 'data' => $data, 'course' => $course, 'currency' => $currency, 'collection' => $collection, 'total_amount' => $total_amount, 'faqs' => $faqs]);
    }
    
    public function createNewApplication(Request $request,$id=null){

        $id = $id??$request->get('sr_prev_id');
        if ($id) {
            $applicationData = DB::table('tbl_application')->where('id', dDecrypt($id))->first();
        } else {
            $applicationData = null;
        }
        $id = Auth::user()->id;
        $item = LevelInformation::whereid('1')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        return view('create-application.create-application', ['data' => $data, 'applicationData' => $applicationData, 'item' => $item]);
    }

    public function createLevel2NewApplication(Request $request,$id=null){
        if ($id) {
            $applicationData = DB::table('tbl_application')->where('id', dDecrypt($id))->first();
        } else {
            $applicationData = null;
        }
        $id = Auth::user()->id;
        $item = LevelInformation::whereid('2')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        return view('create-application.create-application-level-2', ['data' => $data, 'applicationData' => $applicationData, 'item' => $item]);
    }
    
    public function createLevel3NewApplication(Request $request,$id=null){
        if ($id) {
            $applicationData = DB::table('tbl_application')->where('id', dDecrypt($id))->first();
        } else {
            $applicationData = null;
        }
        $id = Auth::user()->id;
        $item = LevelInformation::whereid('3')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        return view('create-application.create-application-level-3', ['data' => $data, 'applicationData' => $applicationData, 'item' => $item]);
    }
    

public function renewalNewCourse($id = null,$refid=null)
{
    if($id) $id = dDecrypt($id);
    if($refid) $refid = dDecrypt($refid);
    if ($id) {
        $applicationData = TblApplication::where('id',$id)->latest()->first();
    }else{
        $applicationData=null;
    }
    // dd($applicationData);
    $first_application_id = TblApplication::where('id',$applicationData->sr_prev_id)->first();
    
    $last_application_id =  $id;
    
    $old_courses = TblApplicationCourses::where('application_id',$first_application_id->id)->where('deleted_by_tp',0)->whereNotIn('status',[1,3])->whereNull('deleted_at')->get();
    // dd($old_courses);

    // $last_application = TblApplication::where('refid',$refid)->first();
    $course = TblApplicationCourses::where('application_id', $last_application_id)->whereNull('deleted_at')->get();
    $uploaded_docs = DB::table('tbl_application_course_doc')->where('application_id',$last_application_id)->where('approve_status',1)->whereNull('deleted_at')->count();
    $total_docs = count($course) * 4;
    
    $is_show_next_btn = false;
    if($uploaded_docs==$total_docs){
        $is_show_next_btn=true;
    }
    $original_course_count = TblApplicationCourses::where('application_id', $id)->whereNull('deleted_at')->count();
    
    return view('renewal-view.create-course-renewal', compact('applicationData', 'course','original_course_count','old_courses','is_show_next_btn'));
}



public function renewalStoreNewApplicationCourse(Request $request)
{

    
    try{
        $reference_id = TblApplication::where('id',$request->application_id)->first()->refid;
        
        $course_name = $request->course_name;
        $lowercase_course_name = array_map('strtolower', $course_name);
        $is_course_name_already_exists =TblApplicationCourses::where(['application_id' => $request->application_id,'deleted_at'=>null,'level_id'=>2])->whereIn('course_name', $lowercase_course_name)->get();
        if(count($is_course_name_already_exists)>0){
            return  redirect('upgrade-create-new-course/' . dEncrypt($request->application_id))->with('fail', 'Course name already exists on this application');
        }
        $value_counts = array_count_values($lowercase_course_name);
            foreach ($value_counts as $value => $count) {
                if ($count > 1) {
                    return  redirect('upgrade-create-new-course/' . dEncrypt($request->application_id))->with('fail', 'Failed to create course with same course name');
                }
            }
        $course_duration = $request->course_duration;
        $eligibility = $request->eligibility;
        $mode_of_course = $request->mode_of_course;
        $course_brief = $request->course_brief;
        $years = $request->years;
        $months = $request->months;
        $days = $request->days;
        $hours = $request->hours;
        //document upload
        
        if ($request->hasfile('doc1')) {
            $doc1 = $request->file('doc1');
        }
        if ($request->hasfile('doc2')) {
            $doc2 = $request->file('doc2');
        }
        if ($request->hasfile('doc3')) {
            $doc3 = $request->file('doc3');
        }
        
        for ($i = 0; $i < count($course_name); $i++) {
            if (empty($course_name[$i])) {
                continue;
            }
            $file = new TblApplicationCourses();
            
            $file->application_id = $request->application_id;
            $file->course_name = $course_name[$i];
            $file->course_duration_y = $years[$i];
            $file->course_duration_m = $months[$i];
            $file->course_duration_d = $days[$i];
            $file->course_duration_h = $hours[$i];
            $file->level_id = $request->level_id;
            $file->eligibility = $eligibility[$i];
            $file->mode_of_course = "online";
            // $file->mode_of_course = collect($mode_of_course[$i])->implode(',');
            $file->course_brief = $course_brief[$i];
            $file->tp_id = Auth::user()->id;
            $file->refid = $request->reference_id;
           
    
    
            $doc_size_1 = $this->getFileSize($request->file('doc1')[$i]->getSize());
            $doc_extension_1 = $request->file('doc1')[$i]->getClientOriginalExtension();
            $doc_size_2 = $this->getFileSize($request->file('doc2')[$i]->getSize());
            $doc_extension_2 = $request->file('doc2')[$i]->getClientOriginalExtension();
            $doc_size_3 = $this->getFileSize($request->file('doc3')[$i]->getSize());
            $doc_extension_3 = $request->file('doc3')[$i]->getClientOriginalExtension();
    
            $timestamp = now()->format('YmdHis'); 
            $randomString = Str::random(8);
            $name = $doc1[$i]->getClientOriginalName();
            $filename="{$timestamp}_{$randomString}".$name;
            $doc1[$i]->move('documnet/', $filename);
            $file->declaration_pdf =  $filename;
            
            

            $doc2 = $request->file('doc2');
            $timestamp = now()->format('YmdHis'); 
            $randomString = Str::random(8);
            $name = $doc2[$i]->getClientOriginalName();
            $filename="{$timestamp}_{$randomString}".$name;
            $doc2[$i]->move('documnet/', $filename);
            $file->course_curriculum_pdf =  $filename;
            
            

            $img = $request->file('doc3');
            $timestamp = now()->format('YmdHis'); 
            $randomString = Str::random(8);
            $name = $doc3[$i]->getClientOriginalName();
            $filename="{$timestamp}_{$randomString}".$name;
            $doc3[$i]->move('documnet/', $filename);
            $file->course_details_xsl =  $filename;
            
    
    
            $file->pdf_1_file_size = $doc_size_1 ;
            $file->pdf_1_file_extension =$doc_extension_1;
            $file->pdf_2_file_size = $doc_size_2 ;
            $file->pdf_2_file_extension =$doc_extension_2;
            $file->xls_file_size = $doc_size_3 ;
            $file->xls_file_extension =$doc_extension_3;
            $file->refid =$reference_id;
            $file->save();
            
             /*course wise doc create*/ 
             
             for($j=0;$j<3;$j++){
             $data = [];
             if($j==0){
                $data['doc_file_name'] = $file->declaration_pdf;
                $data['doc_sr_code'] = config('constant.declaration.doc_sr_code');
                $data['doc_unique_id'] = config('constant.declaration.doc_unique_id');
             }
             if($j==1){
                $data['doc_file_name'] = $file->course_curriculum_pdf;
                $data['doc_sr_code'] = config('constant.curiculum.doc_sr_code');
                $data['doc_unique_id'] = config('constant.curiculum.doc_unique_id');
             }
             if($j==2){
                $data['doc_file_name'] = $file->course_details_xsl;
                $data['doc_sr_code'] = config('constant.details.doc_sr_code');
                $data['doc_unique_id'] = config('constant.details.doc_unique_id');
             }
             $data['application_id'] = $request->application_id;
             $data['course_id'] = $file->id;
             $data['tp_id'] = Auth::user()->id;
             $data['level_id'] = $request->level_id;
             $data['course_name'] = $course_name[$i];
             $data['is_doc_show'] = 0;
             
             DB::table('tbl_course_wise_document')->insert($data);
            }
        }
        
        
          return redirect('/renewal-new-course/' . dEncrypt($request->application_id).'/'.dEncrypt($reference_id))->with('success', 'Course  successfully  Added');
    }  catch(Exception $e){
          return redirect('renewal-new-course/' . dEncrypt($request->application_id).'/'.dEncrypt($reference_id))->with('fail', 'Failed to create course');
    }
   
    
}


    function get_saarc_ids(){
        //Afghanistan, Bangladesh, Bhutan, India, Maldives, Nepal, Pakistan and Sri-Lanka
        // $saarc=Country::whereIn('name',Array('Afghanistan', 'Bangladesh', 'Bhutan', 'Maldives', 'Nepal', 'Pakistan', 'Sri Lanka'))->get('id');
        $saarc=Country::whereIn('name',Array('American Samoa'))->get('id');
        $saarc_ids=Array();
        foreach($saarc as $val)$saarc_ids[]=$val->id;
        return $saarc_ids;
    }
    
    function get_india_id()
        {
            $india = Country::where('name', 'India')->get('id')->first();
            return $india->id;
        }
}
