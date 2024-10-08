<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Application;
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

use App\Models\Add_Document;
use App\Models\DocComment;
use App\Models\Chapter;
use App\Mail\paymentSuccessMail;
use App\Models\ApplicationNotification;
use App\Models\AssessorApplication;

class LevelController extends Controller
{


    public function level_list()
    {


        //$data=Application::whereuser_id(Auth::user()->id)->get();
        //$data=Application::whereuser_id(Auth::user()->id)->where('status','0')->get();
        $Country = Country::get();
        $data = DB::table('applications')
            ->where('applications.user_id', Auth::user()->id)
            ->where('applications.status', '0')
            ->select('applications.*', 'countries.name as country_name')
            ->join('countries', 'applications.country', '=', 'countries.id')->get();
        //dd($data);

        if (count($data) > 0) {

            return view("level.levellist", ['data' => $data]);
        } else {  // dd("else");
            return redirect('level-first');
        }
    }

    //admin part
    public function index(Request $request)
    {

        $level =  LevelInformation::get();
        $collection = ApplicationPayment::where('status', '0')->get();
        $collection1 = ApplicationPayment::where('status', '1')->get();
        $collection2 = ApplicationPayment::where('status', '2')->get();
        return view("level.level", ['level' => $level, 'collection' => $collection, 'collection1' => $collection1, 'collection2' => $collection2]);
    }

    public function admin_view($id)
    {
        $Application = Application::whereid(dDecrypt($id))->get();
        $applicationData = Application::find(dDecrypt($id));
        $ApplicationCourse = ApplicationCourse::whereapplication_id($applicationData->id)->get();
        $ApplicationPayment = ApplicationPayment::where('application_id', $applicationData->id)->get();

        $spocData = DB::table('applications')->where('id', $applicationData->id)->first();
        $ApplicationDocument = ApplicationDocument::whereapplication_id($applicationData->id)->get();
        $data = DB::table('users')->where('users.id', $applicationData->user_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();

        $final_count =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$applicationData->id,'application_course_id'=>$ApplicationCourse[0]->id])->whereIn('assessor_type',['desktop','onsite'])->count();

        if($final_count>1){
         $is_final_submit = true;
        }else{
         $is_final_submit = false;
        }

        return view('level.admin_course_view', ['ApplicationDocument' => $ApplicationDocument, 'spocData' => $spocData, 'data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayments' => $ApplicationPayment, 'applicationData' => $applicationData,'is_final_submit'=>$is_final_submit]);
    }

    public function level_view($id)
    {
        $data = LevelInformation::find(dDecrypt($id));
        return view('level.levelview_page', ['data' => $data]);
    }

    public function update_level($id)
    {
        $data = LevelInformation::find(dDecrypt($id));
        return view('level.update_level', ['data' => $data]);
    }


    public function update_level_post(Request $request, $id)
    {
        //dd("yes");
        $request->validate(
            [
                'level_Information' => 'required',
                'Prerequisites' => 'required',
                'documents_required' => 'required',
                'validity' => 'required',
                'fee_structure' => 'required',
                'timelines' => 'required',
                'image' => 'mimes:jpeg,bmp,png,gif,svg,pdf',
            ]


        );
        // dd($request->all());
        $data = LevelInformation::find(dDecrypt($id));


        $data->level_Information = $request->level_Information;
        $data->Prerequisites = $request->Prerequisites;
        $data->documents_required = $request->documents_required;
        $data->validity = $request->validity;
        $data->fee_structure = $request->fee_structure;
        $data->timelines = $request->timelines;

        // file1
        if ($request->hasfile('level_Information_pdf')) {
            $img = $request->file('level_Information_pdf');
            $name = $img->getClientOriginalName();
            $filename = time() . $name;
            $img->move('level/', $filename);
            $data->level_Information_pdf = $filename;
        }

        // file2
        if ($request->hasfile('Prerequisites_pdf')) {
            $img = $request->file('Prerequisites_pdf');
            $name = $img->getClientOriginalName();
            $filename = time() . $name;
            $img->move('level/', $filename);
            $data->Prerequisites_pdf = $filename;
        }


        // file3
        if ($request->hasfile('documents_required_pdf')) {
            $img = $request->file('documents_required_pdf');
            $name = $img->getClientOriginalName();
            $filename = time() . $name;
            $img->move('level/', $filename);
            $data->documents_required_pdf    = $filename;
        }


        // file4
        if ($request->hasfile('Fee_Structure_pdf')) {
            $img = $request->file('Fee_Structure_pdf');
            $name = $img->getClientOriginalName();
            $filename = time() . $name;
            $img->move('level/', $filename);
            $data->Fee_Structure_pdf = $filename;
        }

        $data->save();

        return redirect()->back()->with('sussess', 'level Update successfull!! ');
    }

    //form part in Tp




    public function level1tp_upgrade(Request $request, $upgrade_application_id = null, $id = null)
    {
        //dd("we are work on manage ");
        $form_step_type = Session::get('session_for_redirections');
        /* if(empty($form_step_type))
         {
           $form_step_type="withour-session-step";
         }*/

        //return $form_step_type;

        // if($id)
        // {
        //     $id=decrypt($id);
        // }


        if ($id) {

            $id = $id;
            $faqs = Faq::where('category', 1)->orderby('sort_order', 'Asc')->get();
            $item = LevelInformation::whereid('1')->get();
            $file = ApplicationDocument::get();

            //$1Application =Applicationevel2::find($id);
            $Application = Applicationlevel2::where('level2_application_id', $upgrade_application_id)->first();

            $course = ApplicationCourse::whereapplication_id($id)->wherestatus('0')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();

            $collection = ApplicationPayment::orderBy('id', 'desc')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
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

            // return $Application;

            return view('level.leveltp', ['level_list_data' => $level_list_data, 'id' => $id, 'collections' => $collections, 'Application' => $Application, 'item' => $item, 'Country' => $Country, 'data' => $data, 'course' => $course, 'currency' => $currency, 'total_amount' => $total_amount, 'collection' => $collection, 'file' => $file, 'faqs' => $faqs], compact('form_step_type'));
        } else {

            $id = Auth::user()->id;
            $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
            $Country = Country::get();
            $faqs = Faq::where('category', 1)->orderby('sort_order', 'Asc')->get();
            $item = LevelInformation::whereid('1')->get();

            $course = ApplicationCourse::whereapplication_id($id)->wherestatus('0')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();

            $collection = ApplicationPayment::orderBy('id', 'desc')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
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

            $level_list_data = DB::table('applications')
                ->where('applications.user_id', Auth::user()->id)
                ->where('applications.status', '0')
                ->select('applications.*', 'countries.name as country_name')
                ->join('countries', 'applications.country', '=', 'countries.id')->get();
            /*end level list */

            return view('level.leveltp', ['level_list_data' => $level_list_data, 'collection' => $collection, 'collections' => $collections, 'item' => $item, 'data' => $data, 'faqs' => $faqs], compact('form_step_type'));
        }
    }

    /*end upgrade part*/

    /**
     * @ coursePayment method of level 1
     *
     * @param  mixed $id
     * @return void
     */


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





    //Code by gaurav
    public function newapplication()
    {
        $item = LevelInformation::whereid('1')->get();
        $collection = ApplicationPayment::whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
        $collections = Application::whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
        $course = ApplicationCourse::wherestatus('0')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
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
        // dd($id);
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $Country = Country::get();
        return view('level.newapplication', ['item' => $item, 'Country' => $Country, 'data' => $data, 'course' => $course, 'currency' => $currency, 'total_amount' => $total_amount, 'collection' => $collection]);
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
    public function level4tp()
    {
        $faqs = Faq::where('category', 4)->orderby('sort_order', 'Asc')->get();

        $item = LevelInformation::whereid('4')->get();
        $Application = Application::whereuser_id(Auth::user()->id)->first();
        $course = ApplicationCourse::whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
        $collection = ApplicationPayment::wherestatus('1')->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
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

    public function delete_course($id)
    {
        $res = ApplicationCourse::find(dDecrypt($id))->delete();
        return back()->with('success', 'Course Delete successfull!!');
    }



    public function new_application(Request $request)
    {

        //dd("yes");

        $this->validate(
            $request,
            [
                'Email_ID' => ['required', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'Contact_Number' => 'required|numeric|min:10,mobile_no|digits:10|unique:applications',
                'Person_Name' => 'required',
                'designation' => 'required',
                'Email_ID'     => 'required|unique:applications',
            ],
            [
                'Email_ID.regex' => "Please Enter Valid Email Id",
                'Email_ID.required' => "Please Enter Email Id",
            ]

        );

        //dd($request->all());
        $aplication = new Application;
        $aplication->level_id = $request->level_id;
        $aplication->user_id = $request->user_id;
        $aplication->state = $request->state_id;
        $aplication->country = $request->country_id;
        $aplication->Person_Name = $request->Person_Name;
        $aplication->Contact_Number = $request->Contact_Number;
        $aplication->Email_ID = $request->Email_ID;
        $aplication->city = $request->city_id;
        $aplication->designation = $request->designation;
        $aplication->ip = getHostByName(getHostName());
        $aplication->save();
        $Application = Application::whereid($aplication->id)->first();
        return response()->json($Application);
    }



    //course payment  controller

    //course payment  controller

    public function new_application_course(Request $request)
    {
        // dd($request->all());
        $active = 'active';
        $course_name = $request->course_name;
        $course_duration = $request->course_duration;
        $eligibility = $request->eligibility;
        $mode_of_course = $request->mode_of_course;


        $course_brief = $request->course_brief;
        $level_id = $request->level_id;
        $years = $request->years;
        $months = $request->months;
        $days = $request->days;
        $hours = $request->hours;

        $user_id = Auth::user()->id;

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
            $file = new ApplicationCourse();

            if ($request->application_id == NULL) {
                $file->application_id = $request->application;
            } else {
                $file->application_id = $request->application_id;
            }

            $file->course_name = $course_name[$i];
            $file->years = $years[$i];
            $file->months = $months[$i];
            $file->days = $days[$i];
            $file->hours = $hours[$i];
            $file->level_id = $request->level_id;
            $file->user_id = Auth::user()->id;
            $file->country = Auth::user()->country;
            /* $file->course_duration=$course_duration[$i];*/
            $file->eligibility = $eligibility[$i];
            $file->mode_of_course = $mode_of_course[$i + 1];
            $file->course_brief = $course_brief[$i];
            $file->valid_from = $request->created_at;
            $file->status = '0';
            $file->payment = 'false';
            $file->save();


            $data = new ApplicationDocument;
            $data->document_type_name = 'doc1';
            $name = $doc1[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc1[$i]->move('documnet/', $filename);
            $data->document_file =  $filename;
            $data->user_id = Auth::user()->id;

            if ($request->application_id == NULL) {
                $data->application_id = $request->application;
            } else {
                $data->application_id = $request->application_id;
            }

            $data->level_id = $request->level_id;
            $data->course_number = $file->id;
            $data->save();

            $data = new ApplicationDocument;
            $data->document_type_name = 'doc2';
            $doc2 = $request->file('doc2');
            $name = $doc2[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc2[$i]->move('documnet/', $filename);
            $data->document_file =  $filename;
            $data->user_id = Auth::user()->id;

            if ($request->application_id == NULL) {
                $data->application_id = $request->application;
            } else {
                $data->application_id = $request->application_id;
            }

            $data->level_id = $request->level_id;
            $data->course_number = $file->id;
            $data->save();


            $data = new ApplicationDocument;
            $data->document_type_name = 'doc3';
            $img = $request->file('doc3');
            $name = $doc3[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc3[$i]->move('documnet/', $filename);
            $data->document_file =  $filename;
            $data->user_id = Auth::user()->id;


            if ($request->application_id == NULL) {
                $data->application_id = $request->application;
            } else {
                $data->application_id = $request->application_id;
            }

            $data->level_id = $request->level_id;
            $data->course_number = $file->id;
            $data->save();
        }
        //dd($request->form_step_type);

        $session_for_redirection = $request->form_step_type;
        Session::put('session_for_redirections', $session_for_redirection);
        $session_for_redirections = Session::get('session_for_redirections');

        $level2_application_id = $data->applications_id;

        //return $request->level_id;
        if ($request->level_id == '1') {
            return  redirect('create-course/' . dEncrypt($data->application_id))->with('success', 'Course  successfully  Added');
            // return  redirect('level-first/'.dEncrypt($data->application_id))->with('success','Course  successfully  Added!!!!');

        } elseif ($request->level_id == '2') {
            //dd("level2");
            return  redirect('level-first/' . encrypt($data->application_id))->with('success', 'Course  successfully  Added');

            //return  redirect('level-first-upgrade/'.$level2_application_id.'/'.$data->applications_id)->with('success','Course  successfully  Added!!!!');

            //return  redirect('level-list')->with('success','Course successfully Added!!!!');

        } elseif ($request->level_id == '3') {

            return  redirect('level-list')->with('success', 'Course successfully Added');
        } else {
            return  redirect('create-course/' . dEncrypt($data->application_id))->with('success', 'Course successfully Added');
        }
    }

    public function new_application_payment(Request $request)
    {
        $request->validate([
            'transaction_no' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:application_payments,transaction_no',
            'reference_no' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:application_payments,reference_no',
            'payment' => 'required',
        ], [
            'transaction_no.required' => 'The transaction number is required.',
            'transaction_no.unique' => 'The transaction number is already in use.',
            'transaction_no.regex' => 'The transaction number must not contain special characters or spaces.',

            'reference_no.required' => 'The reference number is required.',
            'reference_no.unique' => 'The reference number is already in use.',
            'reference_no.regex' => 'The reference number must not contain special characters or spaces.',

            'payment.required' => 'Please select a payment mode.'
        ]);

        $transactionNumber = trim($request->transaction_no);
        $referenceNumber = trim($request->reference_no);


        /*Implemented by suraj*/
          $get_final_summary = DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->Application_id,'payment_status'=>0,'assessor_type'=>'desktop'])->first();
          if(!empty($get_final_summary)){
            DB::table('assessor_final_summary_reports')->where('application_id',$request->Application_id)->update(['payment_status' => 1]);
          }
        /*end here*/

        $checkPaymentAlready = DB::table('application_payments')->where('application_id', $request->Application_id)->first();
        if (!$request->coursePayment) {
            if ($checkPaymentAlready) {
                return redirect(url('application-list'))->with('fail', 'Payment has already been submitted for this application.');
            }
        }
        // return $request->all();
        $this->validate($request, [
            'payment_details_file' => 'mimes:pdf,jpeg,png,jpg,gif,svg',

        ]);
        $item = new ApplicationPayment;
        $item->level_id = $request->level_id;
        $item->user_id = Auth::user()->id;
        $item->amount = $request->amount;
        $item->payment_date = date("Y-m-d", strtotime($request->payment_date));

        $item->transaction_no = $transactionNumber;
        $item->reference_no = $referenceNumber;
        $item->course_count = $request->course_count;
        $item->currency = $request->currency;
        $item->country = $request->coutry;
        $item->status = '0';
        $item->application_id = $request->Application_id;
        if ($request->hasfile('payment_details_file')) {
            $img = $request->file('payment_details_file');
            $name = $img->getClientOriginalName();
            $filename = time() . $name;
            $img->move('uploads/', $filename);
            $item->payment_details_file = $filename;
        }
        $item->save();

        //mail send
        $userEmail = 'superadmin@yopmail.com';
        //$adminEmail = 'admin@yopmail.com';
        //$admin = user::where('role','1')->orderBy('id','DESC')->whereNotIn('id', ['superadmin@yopmail.com'])->first();
        // $adminEmail = isset(level-first)?level-first:'brijesh-admin@yopmail.com';
        //Mail sending scripts starts here
        $paymentMail = [
            'title' => 'Traing Provider Ctreate a New Application. and Course Payment Successfully Done',
            'body' => '',
            'type' => 'New Application'
        ];

        $mailData =
            [
                'from' => "T.P",
                'applicationNo' => $request->Application_id,
                'applicationStatus' => "T.P Created Application Successfully",
                'subject' => "T.P Created Application Successfully",
            ];
        $paymentid = $request->Application_id;
        $userid = Auth::user()->firstname;

        // dd($mailData);

        Mail::to([$userEmail])->send(new SendMail($mailData));

        // Mail::to([$userEmail])->send(new paymentSuccessMail($paymentMail,$paymentid,$userid));
        //Mail sending script ends here

        if ($request->level_id == '1') {
            // dd($request->course_id);

            foreach ($request->course_id as $items) {
                $ApplicationCourse = ApplicationCourse::find($items);
                $ApplicationCourse->status = '1';
                $ApplicationCourse->payment = $item->id;
                $ApplicationCourse->update();
            }
            $ApplicationCourse->save();

            // return  redirect('/level-first')->with('success','Payment Done successfully!!!!');



            $session_for_redirection = $request->form_step_type;
            Session::put('session_for_redirections', $session_for_redirection);
            $session_for_redirections = Session::get('session_for_redirections');

            return  redirect('application-list')->with('success', 'Payment Done successfully');


            //count payment in course status true

        } elseif ($request->level_id == '2') {

            return  redirect('level-first')->with('success', 'Course  successfully  Added');

            foreach ($request->course_id as $item) {
                $ApplicationCourse = ApplicationCourse::find($item);
                $ApplicationCourse->payment = 'True';
                $ApplicationCourse->status = '1';
                $ApplicationCourse->update();
            }
            $ApplicationCourse->save();

            return  redirect('/level-second')->with('success', 'Payment Done successfully');;
        } elseif ($request->level_id == '3') {
            foreach ($request->course_id as $item) {
                $ApplicationCourse = ApplicationCourse::find($item);
                $ApplicationCourse->payment = 'True';
                $ApplicationCourse->status = '1';
                $ApplicationCourse->update();
            }
            $ApplicationCourse->save();

            return  redirect('/level-third')->with('success', ' Payment Done successfully');;
        } else {
            return  redirect('/level-fourth')->with('success', 'Payment Done successfully');;
        }
    }

    //level information view page 4 url

    public function previews_application1($application_id, $notificationId = 0)
    {
        $application_id = dDecrypt($application_id);
        if ($notificationId > 0) {
            $notification = ApplicationNotification::find($notificationId);
            $notification->update(['is_read' => 1]);
        }

        $id = Auth::user()->id;
        $item = LevelInformation::whereid('1')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')
            ->join('countries', 'users.country', '=', 'countries.id')
            ->join('cities', 'users.city', '=', 'cities.id')
            ->join('states', 'users.state', '=', 'states.id')
            ->first();

        $spocData = DB::table('applications')->where('id', $application_id)->first();
        $applicationData = Application::find($application_id);

        //return $item[0]->id;


        $ApplicationCourse = ApplicationCourse::where('user_id', $id)->where('application_id', $application_id)->wherelevel_id($item[0]->id)->get();

        $application_course_id = $ApplicationCourse[0]->id;

        $ApplicationPayment = ApplicationPayment::where('user_id', $id)->whereid($application_id)->wherelevel_id($item[0]->id)->get();



        $check_payment = ApplicationPayment::where('id', $application_id)->first();
        if (isset($check_payment->level_id)) {
            if ($check_payment->level_id == 2) {
                $ApplicationCourse = ApplicationCourse::where('user_id', $id)->wherepayment($application_id)->wherelevel_id(2)->get();
                $ApplicationPayment = ApplicationPayment::where('user_id', $id)->whereid($application_id)->wherelevel_id(2)->get();
            }
        }

        // dd($application_course_id);
        // dd($application_id);

        $count =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application_id,'application_course_id'=>$application_course_id])->whereIn('assessor_type',['desktop','onsite'])->count();
        if($count>1){
         $is_final_submit = true;
        }else{
         $is_final_submit = false;
        }


        //return $ApplicationPayment;


        return view('level.level-previous_view', ['spocData' => $spocData, 'applicationData' => $applicationData, 'data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayment' => $ApplicationPayment,'is_final_submit'=>$is_final_submit]);
    }

    public function previews_application2($ids)
    {
        $id = Auth::user()->id;
        $item = LevelInformation::whereid('2')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $ApplicationCourse = ApplicationCourse::where('user_id', $id)->wherepayment($ids)->wherelevel_id($item[0]->id)->get();
        $ApplicationPayment = ApplicationPayment::where('user_id', $id)->whereid($ids)->wherelevel_id($item[0]->id)->get();
        return view('level.level-previous_view', ['data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayment' => $ApplicationPayment]);
    }


    public function previews_application3($ids)
    {
        $id = Auth::user()->id;
        $item = LevelInformation::whereid('3')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $ApplicationCourse = ApplicationCourse::where('user_id', $id)->wherepayment($ids)->wherelevel_id($item[0]->id)->get();
        $ApplicationPayment = ApplicationPayment::where('user_id', $id)->whereid($ids)->wherelevel_id($item[0]->id)->get();
        return view('level.level-previous_view', ['data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayment' => $ApplicationPayment]);
    }


    public function previews_application4()
    {
        $id = Auth::user()->id;
        $item = LevelInformation::whereid('4')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $ApplicationCourse = ApplicationCourse::where('user_id', $id)->wherelevel_id($item[0]->id)->get();
        $ApplicationPayment = ApplicationPayment::where('user_id', $id)->wherelevel_id($item[0]->id)->get();
        return view('level.level-previous_view', ['data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayment' => $ApplicationPayment]);
    }


    //level upgrade section
    public function application_upgrade2()
    {
        $id = Auth::user()->id;
        $item = LevelInformation::whereid('1')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $Course = ApplicationCourse::where('user_id', $id)->wherelevel_id($item[0]->id)->get();
        return view('level.level-upgrade', ['Course' => $Course, 'data' => $data])->with('success', 'upgrade level Courses First ');
    }


    public function application_upgrade3()
    {
        $id = Auth::user()->id;
        $item = LevelInformation::whereid('2')->get();
        //  dd($item);
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        $Course = ApplicationCourse::where('user_id', $id)->wherelevel_id($item[0]->id)->get();
        return view('level.level-upgrade', ['Course' => $Course, 'data' => $data])->with('success', 'Upgrade level Course Second ');
    }


    public function application_upgrade4()
    {
        return view('level.level-upgrade');
    }



    function get_india_id()
    {
        $india = Country::where('name', 'India')->get('id')->first();
        if($india){
            return $india->id;
        }else{
            return null;
        }
        
    }

    function get_saarc_ids()
    {
        //Afghanistan, Bangladesh, Bhutan, India, Maldives, Nepal, Pakistan and Sri-Lanka
        $saarc = Country::whereIn('name', array('Afghanistan', 'Bangladesh', 'Bhutan', 'Maldives', 'Nepal', 'Pakistan', 'Sri Lanka'))->get('id');
        $saarc_ids = array();
        foreach ($saarc as $val) $saarc_ids[] = $val->id;
        return $saarc_ids;
    }
    public function upload_document($id, $course_id)
    {

        $application_id = $id ? dDecrypt($id) : $id;
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;

        $data = ApplicationPayment::whereapplication_id($id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();

        $chapters = Chapter::all();

        $applicationData = Application::find($application_id);

        return view('level.upload_document', compact('chapters', 'file', 'data', 'course_id', 'application_id', 'applicationData'));
    }


    public function accr_upload_document($id, $course_id)
    {
        $assessor_id = Auth::user()->id;
        $application_id = $id;
        $course_id = $course_id;
        $data = ApplicationPayment::whereapplication_id($id)->get();
        $file = ApplicationDocument::whereapplication_id($data[0]->application_id)->get();
        $chapters = Chapter::all();
        $applicationData = Application::find($id);
        $summeryReport = SummaryReport::where(['application_id' => $id,'course_id'=> $course_id])->first();

        /*Created by Suraj*/
       $count_action_taken_on_doc =  DB::table("assessor_summary_reports")->where(['application_id' => $data[0]->application_id,'application_course_id'=>$course_id,'assessor_id'=> $assessor_id])->count();

        $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$data[0]->application_id,'application_course_id'=>$course_id,'assessor_id'=>$assessor_id ])->first();


        if(!empty($is_exists) && ($count_action_taken_on_doc <= 44)){
         $is_final_submit = true;
        }else{
         $is_final_submit = false;
        }
        /*end here*/
        return view('asesrar.view_document', compact('chapters', 'course_id', 'data', 'file', 'application_id', 'applicationData','summeryReport','is_final_submit'));
    }

    public function document_report_verified_by_assessor($id, $course_id)
    {
        //return $course_id;
        $application_id = $id;
        $course_id = $course_id;

        $check_admin = Add_Document::orderBy('id', 'desc')->where('course_id', $course_id)->where('send_to_admin', 1)->first();

        //Comments



        // dd(dDecrypt($id));
        $data = ApplicationPayment::whereapplication_id($id)->get();
        $file = ApplicationDocument::whereapplication_id($data[0]->application_id)->get();

        $doc_id1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap1')[1])->where('course_id', $course_id)->first();
        // dd($doc_id1);

        //return __('arrayfile.document_doc_id_chap1')[2];
        $doc_id2 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap1')[2])->where('course_id', $course_id)->first();
        $doc_id3 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap1')[3])->where('course_id', $course_id)->first();
        $doc_id4 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap1')[4])->where('course_id', $course_id)->first();
        $doc_id5 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap1')[5])->where('course_id', $course_id)->first();
        $doc_id6 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap1')[6])->where('course_id', $course_id)->first();

        $doc_id_chap2_1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap2')[1])->where('course_id', $course_id)->first();
        $doc_id_chap2_2 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap2')[2])->where('course_id', $course_id)->first();
        $doc_id_chap2_3 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap2')[3])->where('course_id', $course_id)->first();
        $doc_id_chap2_4 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap2')[4])->where('course_id', $course_id)->first();
        $doc_id_chap2_5 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap2')[5])->where('course_id', $course_id)->first();
        $doc_id_chap2_6 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap2')[6])->where('course_id', $course_id)->first();


        $doc_id_chap3_1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap3')[1])->where('course_id', $course_id)->first();

        $doc_id_chap4_1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap4')[1])->where('course_id', $course_id)->first();

        $doc_id_chap4_2 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap4')[2])->where('course_id', $course_id)->first();
        $doc_id_chap4_3 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap4')[3])->where('course_id', $course_id)->first();
        $doc_id_chap4_4 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap4')[4])->where('course_id', $course_id)->first();
        $doc_id_chap4_5 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap4')[5])->where('course_id', $course_id)->first();
        $doc_id_chap4_6 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap4')[6])->where('course_id', $course_id)->first();

        $doc_id_chap4_7 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap4')[7])->where('course_id', $course_id)->first();

        $doc_id_chap5_1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap5')[1])->where('course_id', $course_id)->first();
        $doc_id_chap5_2 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap5')[2])->where('course_id', $course_id)->first();
        $doc_id_chap5_3 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap5')[3])->where('course_id', $course_id)->first();

        $doc_id_chap6_1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap6')[1])->where('course_id', $course_id)->first();
        $doc_id_chap6_2 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap6')[2])->where('course_id', $course_id)->first();
        $doc_id_chap6_3 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap6')[3])->where('course_id', $course_id)->first();

        $doc_id_chap7_1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap7')[1])->where('course_id', $course_id)->first();
        $doc_id_chap7_2 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap7')[2])->where('course_id', $course_id)->first();
        $doc_id_chap7_3 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap7')[3])->where('course_id', $course_id)->first();
        $doc_id_chap7_4 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap7')[4])->where('course_id', $course_id)->first();
        $doc_id_chap7_5 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap7')[5])->where('course_id', $course_id)->first();
        $doc_id_chap7_6 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap7')[6])->where('course_id', $course_id)->first();

        $doc_id_chap8_1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap8')[1])->where('course_id', $course_id)->first();
        $doc_id_chap8_2 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap8')[2])->where('course_id', $course_id)->first();
        $doc_id_chap8_3 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap8')[3])->where('course_id', $course_id)->first();
        $doc_id_chap8_4 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap8')[4])->where('course_id', $course_id)->first();
        $doc_id_chap8_5 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap8')[5])->where('course_id', $course_id)->first();
        $doc_id_chap8_6 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap8')[6])->where('course_id', $course_id)->first();

        $doc_id_chap9_1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap9')[1])->where('course_id', $course_id)->first();
        $doc_id_chap9_2 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap9')[2])->where('course_id', $course_id)->first();

        $doc_id_chap10_1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap10')[1])->where('course_id', $course_id)->first();
        $doc_id_chap10_2 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap10')[2])->where('course_id', $course_id)->first();
        $doc_id_chap10_3 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap10')[3])->where('course_id', $course_id)->first();
        $doc_id_chap10_4 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap10')[4])->where('course_id', $course_id)->first();




        return view('asesrar.document_report_verified_by_assessor', ['file' => $file, 'data' => $data], compact(
            'course_id',
            'doc_id1',
            'doc_id2',
            'doc_id3',
            'doc_id4',
            'doc_id5',
            'doc_id6',
            'doc_id_chap2_1',
            'doc_id_chap2_2',
            'doc_id_chap2_3',
            'doc_id_chap2_4',
            'doc_id_chap2_5',
            'doc_id_chap2_6',
            'doc_id_chap3_1',
            'doc_id_chap4_1',
            'doc_id_chap4_2',
            'doc_id_chap4_3',
            'doc_id_chap4_4',
            'doc_id_chap4_5',
            'doc_id_chap4_6',
            'doc_id_chap4_7',
            'doc_id_chap5_1',
            'doc_id_chap5_2',
            'doc_id_chap5_3',
            'doc_id_chap6_1',
            'doc_id_chap6_2',
            'doc_id_chap6_3',
            'doc_id_chap7_1',
            'doc_id_chap7_2',
            'doc_id_chap7_3',
            'doc_id_chap7_4',
            'doc_id_chap7_5',
            'doc_id_chap7_6',
            'doc_id_chap8_1',
            'doc_id_chap8_2',
            'doc_id_chap8_3',
            'doc_id_chap8_4',
            'doc_id_chap8_5',
            'doc_id_chap8_6',
            'doc_id_chap9_1',
            'doc_id_chap9_2',
            'doc_id_chap10_1',
            'doc_id_chap10_2',
            'doc_id_chap10_3',
            'doc_id_chap10_4',
            'check_admin'
        ))->with('success', 'Documents Update Successfully');
    }


    public function admin_view_document($id, $course_id)
    {
        //return $course_id;
        $application_id = $id;
        $course_id = $course_id;

        $check_admin = Add_Document::orderBy('id', 'desc')->where('course_id', $course_id)->whereIn('send_to_admin', [0, 1])->first();

        //Comments



        // dd(dDecrypt($id));
        $data = ApplicationPayment::whereapplication_id($id)->get();
        $file = ApplicationDocument::whereapplication_id($data[0]->application_id)->get();

        $chapters = Chapter::all();



        return view('asesrar.admin_view_document', ['file' => $file, 'data' => $data], compact(
            'application_id',
            'course_id',
            'chapters',
            'check_admin'
        ))->with('success', 'Documents Update Successfully');
    }


    public function show_comment($doc_id)
    {
        $comment = DocComment::orderby('id', 'Desc')->where('doc_id', $doc_id)->get();
        return view('asesrar.show-comment', compact('comment'));
    }

    public function document_comment_admin_assessor($course_id)
    {
        $comment = DocComment::orderby('id', 'Desc')->where('course_id', $course_id)->get();
        return view('asesrar.show-comment-accr-admin', compact('comment'));
    }

    public function add_courses(Request $request)
    {
        $notApprove = 0;
        $oldFile = Add_Document::orderby('id', 'desc')->where('doc_id', $request->question_id)->where('application_id', $request->application_id)->where('course_id', $request->course_id)->first();
        if ($oldFile) {
            $notApprove = $oldFile->notApraove_count ?? 0;
        }

//        check assigned assessor
        $assessor = null;
        $assignedAssessor = AssessorApplication::where('application_id',$request->application_id)->get();

        if (count($assignedAssessor) > 1){
            $assessor = AssessorApplication::where('application_id',$request->application_id)->orderBy('id','desc')->first();
        }elseif(count($assignedAssessor) == 1){
            $assessor = AssessorApplication::where('application_id',$request->application_id)->first();
        }



        $course = new Add_Document;
        $course->course_id = $request->course_id;
        $course->doc_id = $request->question_id;
        $course->question_id = $request->question_pid;
        $course->application_id = $request->application_id;
        if ($assessor){
            $course->assesment_type = $assessor->assessment_type == 1 ? 'desktop' : 'onsite';
        }else{
            $course->assesment_type = 'desktop';
        }
        $course->user_id = Auth::user()->id;
        if ($oldFile) {
            if ($oldFile->on_site_assessor_Id != null) {
                $course->on_site_assessor_Id = $oldFile->on_site_assessor_Id;
            }
        }
        $course->parent_doc_id = $request->parent_doc_id ?? null;

        $course->notApraove_count = $notApprove + 1 ?? 1;

        if ($request->is_displayed_onsite > 0) {
            $course->is_displayed_onsite = 1;
        }


        if ($request->hasfile('fileup')) {
            $file = $request->file('fileup');
            $name = $file->getClientOriginalName();
            $filename = time() . $name;
            $file->move('level/', $filename);
            //dd($filename);
            $course->doc_file = $filename;
        }


        $course->save();

        $admin = user::where('role', '1')->orderBy('id', 'DESC')->whereNotIn('id', ['superadmin@yopmail.com'])->first();
        if ($admin) {
            $adminEmail = $admin->email;
        } else {
            $adminEmail = "adminuser@yopmail.com";
        }

        $superadminEmail = "superadmin@yopmail.com";
        $mailData =
            [
                'from' => "T.P",
                'applicationNo' => $request->application_id,
                'applicationStatus' => "T.P Uploaded Document Successfully",
                'subject' => "T.P Uploaded Document Successfully",
            ];

        Mail::to([$superadminEmail, $adminEmail])->send(new SendMail($mailData));

        return response()->json(['message' => 'success']);
    }

    public function view_doc($doc_code, $id, $doc_id, $course_id)
    {
        // Fetch the latest comments for the document.
        $comment = DocComment::latest('id')->where('doc_id', $doc_id)->get();

        // Count the latest comments.
        $doc_latest_record_comment = $comment->count();

        // Fetch the latest document record.
        $doc_latest_record = Add_Document::latest('id')->find($doc_id);

       $application_id = DB::table('application_courses')->where(['id'=>$course_id])->first()->application_id;

        return view('asesrar.view-doc-with-comment', [
            'doc_latest_record' => $doc_latest_record,
            'id' => $id,
            'doc_id' => $doc_id,
            'doc_latest_record_comment' => $doc_latest_record_comment,
            'doc_code' => $doc_code,
            'comment' => $comment,
            'application_id' => $course_id,
            'app_id'=>$application_id
        ], compact('course_id'));
    }


    public function admin_view_doc($doc_code, $id, $doc_id, $course_id,$question_id)
    {
        $assesor_id = Auth::user()->id;
        $comment = DocComment::orderby('id', 'Desc')->where('doc_id', $doc_id)->get();
        $doc_latest_record_comment = DocComment::orderby('id', 'desc')->where('doc_id', $doc_id)->count();
        $doc_latest_record = Add_Document::orderby('id', 'desc')->where('id', $doc_id)->first();
        $docByAdmin = DocComment::orderby('id', 'Desc')->where('doc_id', $doc_id)->where('user_id', auth()->user()->id)->first();
        $app_id = DB::table('application_courses')->where(['id'=>$course_id])->first()->application_id;
        return view('asesrar.view-doc-with-comment-admin', ['doc_latest_record' => $doc_latest_record, 'id' => $id, 'doc_id' => $doc_id, 'doc_latest_record_comment' => $doc_latest_record_comment, 'doc_code' => $doc_code, 'comment' => $comment], compact('course_id', 'docByAdmin','question_id','app_id','assesor_id'));
    }

    public function acc_doc_comments(Request $request)
    {
        $check_nc = DB::table('assessor_summary_reports')->where(['application_id'=>$request->application_id,'nc_raise_code'=>$request->status,'object_element_id'=>$request->question_id,'assessor_id'=> $request->assessor_id,'assessor_type'=>$request->assesor_type])->first();

        if(!empty($check_nc)){
            return redirect("$request->previous_url")->with('error', 'NC already created on this document.');
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
        $data['application_id'] = $request->application_id;
        $data['application_course_id'] = $request->application_course_id;
        $data['object_element_id'] = $request->question_id;
        $data['doc_sr_code'] = $request->doc_code;
        $data['doc_unique_id'] = $request->doc_unique_id;
        $data['date_of_assessement'] = $request->date_of_assessement??'';
        $data['assessor_id'] = $request->assessor_id;
        $data['assessor_type'] = $request->assesor_type;
        $data['nc_raise'] = $nc_raise??'';
        $data['nc_raise_code'] = $request->status??'';
        $data['doc_path'] = $request->doc_path;
        $data['capa_mark'] = $request->capa_mark??'';
        $data['doc_against_nc'] = $request->doc_against_nc??'';
        $data['doc_verify_remark'] = $request->doc_comment;
        $create_summary_report = DB::table('assessor_summary_reports')->insert($data);

        /*end here*/
        $login_id = Auth::user()->role;
        if ($login_id == 3) {
            $request->doc_code;

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
            $newDocument = null;
            if ($request->status == 4){
                $document = Add_Document::find($request->doc_id);

                $newDocument = new Add_Document;
                $newDocument->application_id = $document->application_id;
                $newDocument->course_id = $document->course_id;
                $newDocument->section_id = $document->section_id;
                $newDocument->doc_id = $document->doc_id;
                $newDocument->status = $document->status;
                $newDocument->doc_file = $document->doc_file;
                $newDocument->question_id = $document->question_id;
                $newDocument->user_id = $document->user_id;
                $newDocument->assessor_id = $document->assessor_id;
                $newDocument->notApraove_count = $document->notApraove_count;
                $newDocument->assesment_type = $document->assesment_type;
                $newDocument->verified_document = $document->verified_document;
                $newDocument->on_site_assessor_Id = $document->on_site_assessor_Id;
                $newDocument->photograph = $document->photograph;
                $newDocument->photograph_comment = $document->photograph_comment;
                $newDocument->parent_doc_id = $document->parent_doc_id;
                $newDocument->is_displayed_onsite = $document->is_displayed_onsite;
                $newDocument->save();

            }

            //return $request->course_id;
            $txt = "";
            if ($request->status == 4) {
                $txt = "Document has been approved";
            } else {
                $txt = $request->doc_comment;
            }
            $comment = new DocComment;
            $comment->doc_id = $newDocument ? $newDocument->id : $request->doc_id;
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

    public function doc_to_admin($course_id)
    {
        return view('asesrar.report-to-admin', compact('course_id'));
    }

    public function document_report_by_admin($course_id)
    {

        $acknow_record = AcknowledgementRecord::select('course_id')->where('course_id', $course_id)->first();
        //return $acknow_record->course_id;
        return view('asesrar.document-report-by-admin', compact('course_id', 'acknow_record'));
    }

    public function doc_to_admin_sumit(Request $request)
    {
        dd("yesss");
        $finalcomment = new DocumentReportVerified;
        $finalcomment->user_id = Auth::user()->id;
        $finalcomment->comment_by_assessor = $request->doc_admin_comment;
        $finalcomment->course_id = $request->course_id;
        $finalcomment->save();

        $course_id = $request->course_id;
        $doc_admin = Add_Document::orderBy('id', 'desc')->where('course_id', $course_id)->first();
        $doc_admin->doc_admin_comment = $request->doc_admin_comment;
        $doc_admin->send_to_admin = 1;
        $doc_admin->save();

        //mail send
        $admin = user::where('role', '1')->orderBy('id', 'DESC')->whereNotIn('id', ['superadmin@yopmail.com'])->first();
        $adminEmail = $admin->email;
        $superadminEmail = 'superadmin@yopmail.com';
        $asses_email = Auth::user()->email;


        //Mail sending scripts starts here
        /*$assessorToAdmin = [
    'title' =>'You Have Received a Final Report of this Application from Assessor Successfully!!!!',
    'body' => $request->sec_email,
    ];*/
        $mailData =
            [
                'from' => "Assessor",
                'applicationNo' => $request->application_id,
                'applicationStatus' => "Application Assessor to Admin",
                'subject' => "Application Submit from Assessor Successfully",
            ];

        $application_id = $request->application_id;
        $username = "Auth::user()->firstname TP Name";

        Mail::to([$superadminEmail, $adminEmail])->send(new SendMail($mailData));

        $mailData =
            [
                'from' => "Assessor",
                'applicationNo' => $request->application_id,
                'applicationStatus' => "Application Assessor to Admin",
                'subject' => "Application Submit from Assessor Successfully",
            ];

        Mail::to([$asses_email])->send(new SendMail($mailData));
        //Mail sending script ends here
        return redirect("$request->previous_url")->with('success', 'This Document Send to Admin Successfully');
    }

    public function document_report_by_admin_submit1(Request $request)
    {
        $data["email"] = "test1@yopmail.com";
        $data["title"] = "Laravel 8 send email with attachment - Techsolutionstuff";
        $data["body"] = "Laravel 8 send email with attachment";

        $pdf = PDF::loadView('pdf_mail', $data);

        Mail::send('pdf_mail', $data, function ($message) use ($data, $pdf) {

            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($pdf->output(), "test.pdf");
        });

        echo "email send successfully";
    }

    public function document_report_by_admin_submit(Request $request)
    {

        /*send attachment mail to tp and assessor*/
        $course = ApplicationCourse::where('id', $request->course_id)->first();
        if ($course) {
            $user_id = $course->user_id;
            $data = User::where('id', $user_id)->first();
            $tp_email = $data->email;
            $tp_name = $data->firstname;
            $application_id = $course->application_id;
            $data1["email"] = $tp_email;
            $data1["title"] = $tp_name;
            $data1["body"] = "";
        }

        $data = (array) $data1;
        //dd(gettype($data));
        $pdf = PDF::loadView('pdf_mail', $data);

        Mail::send('pdf_mail', $data, function ($message) use ($data, $pdf) {

            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($pdf->output(), "acknowledgement.pdf");
        });

        /*end send attachment mail to tp and assessor*/
        $filename = $course->application_id;
        $acknowledgement_pdf = $filename . '.pdf';
        $content = $pdf->download()->getOriginalContent();
        Storage::put('public/pdf/' . $filename . '.pdf', $content);




        /*update statur that acknowledgement send or not*/
        if ($course) {

            $currentdatetime = Carbon::now();
            $current_date = $currentdatetime->toDateString();
            $acknowledgement = new AcknowledgementRecord;
            $acknowledgement->application_id = $course->application_id;
            $acknowledgement->course_id = $request->course_id;
            $acknowledgement->acknowledgement_id = 1;
            $acknowledgement->status = 1;
            $acknowledgement->send_date = $current_date;
            $acknowledgement->user_id = $course->user_id;
            $acknowledgement->pdf = $acknowledgement_pdf;
            $acknowledgement->save();
        }
        /*end update statur that acknowledgement send or not*/

        //return $request->all();
        $finalcomment = new DocumentReportVerified;
        $finalcomment->user_id = Auth::user()->id;
        $finalcomment->comment_by_assessor = $request->doc_admin_comment;
        $finalcomment->course_id = $request->course_id;
        $finalcomment->save();

        $course_id = $request->course_id;
        $doc_record_status = DocComment::where('status', 3)->where('course_id', $course_id)->get();

        foreach ($doc_record_status as $doc_status) {

            $doc_status->status;
            $doc_record_status = DocComment::where('status', $doc_status->status)->where('course_id', $course_id)->first();
            $doc_record_status->status = 2;
            $doc_record_status->doc_comment_assessor_admin = $request->doc_admin_comment;
            $doc_record_status->save();
        }

        $doc_record_status = DocComment::where('status', 0)->where('course_id', $course_id)->get();

        foreach ($doc_record_status as $doc_status) {

            $doc_status->status;
            $doc_record_status = DocComment::where('status', $doc_status->status)->where('course_id', $course_id)->first();
            $doc_record_status->status = 2;
            $doc_record_status->doc_comment_assessor_admin = $request->doc_admin_comment;
            $doc_record_status->save();
        }
        /*dd("ye");
   return $doc_record_status;
   $doc_admin=Add_Document::orderBy('id','desc')->where('course_id',$course_id)->first();
   $doc_admin->doc_admin_comment=$request->doc_admin_comment;
   $doc_admin->send_to_admin=1;
   $doc_admin->save();*/

        //mail send
        $superadminEmail = 'superadmin@yopmail.com';
        //$adminEmail = 'admin@yopmail.com';

        $admin = user::where('role', '1')->orderBy('id', 'DESC')->whereNotIn('email', ['superadmin@yopmail.com'])->first();
        if ($admin) {
            $adminEmail = $admin->email;
        }
        /*$asses_email = $request->sec_email;*/

        $request->course_id;
        $document_data = DocComment::where('course_id', $request->course_id)->first();
        if ($document_data) {
            $doc_code = $document_data->doc_code;
            $add_document = Add_Document::where('doc_id', $doc_code)->first();
            $data = User::where('id', $add_document->assessor_id)->first();
            $assessor_email = $data->email;
        }


        $course = ApplicationCourse::where('id', $request->course_id)->first();

        if ($course) {
            $user_id = $course->user_id;
            $data = User::where('id', $user_id)->first();
            $tp_email = $data->email;
            $tp_name = $data->firstname;
            $application_id = $course->application_id;
        }

        //Mail sending scripts starts here
        $mailData =
            [
                'from' => "Admin",
                'applicationNo' => $application_id,
                'applicationStatus' => "Admin send Final Report of this Application",
                'subject' => "Application Final Report Send Successfully with Acknowledgment Attachment",
            ];
        Mail::to([$superadminEmail, $adminEmail])->send(new SendMail($mailData));

        return redirect("$request->previous_url")->with('success', 'This Document Send to Admin Successfully');
    }


    public function acc_doc_comments_backup(Request $request)
    {
        //return $request->all();
        $comment = new DocComment;
        $comment->doc_id = $request->doc_id;
        $comment->doc_code = $request->doc_code;
        $comment->status = $request->status;
        $comment->comments = $request->doc_comment;
        $comment->save();

        return redirect("$request->previous_url")->with('success', 'Comment Added on this Documents Successfully');
    }


    //public function upload_document($id,$course_id)
    //{
    //
    //     $application_id=$id;
    //     $course_id=$course_id;
    //    // dd(dDecrypt($id));
    //    $data =ApplicationPayment::whereapplication_id($id)->get();
    //    $file =ApplicationDocument::whereapplication_id($data[0]->application_id)->get();
    //
    //
    //    $doc_id1=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap1')[1])->where('course_id',$course_id)->first();
    //    $doc_id2=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap1')[2])->where('course_id',$course_id)->first();
    //    $doc_id3=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap1')[3])->where('course_id',$course_id)->first();
    //    $doc_id4=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap1')[4])->where('course_id',$course_id)->first();
    //    $doc_id5=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap1')[5])->where('course_id',$course_id)->first();
    //    $doc_id6=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap1')[6])->where('course_id',$course_id)->first();
    //
    //    $doc_id_chap2_1=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap2')[1])->where('course_id',$course_id)->first();
    //    $doc_id_chap2_2=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap2')[2])->where('course_id',$course_id)->first();
    //    $doc_id_chap2_3=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap2')[3])->where('course_id',$course_id)->first();
    //    $doc_id_chap2_4=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap2')[4])->where('course_id',$course_id)->first();
    //    $doc_id_chap2_5=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap2')[5])->where('course_id',$course_id)->first();
    //    $doc_id_chap2_6=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap2')[6])->where('course_id',$course_id)->first();
    //
    //    $doc_id_chap3_1=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap3')[1])->where('course_id',$course_id)->first();
    //
    //    $doc_id_chap4_1=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap4')[1])->where('course_id',$course_id)->first();
    //    $doc_id_chap4_2=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap4')[2])->where('course_id',$course_id)->first();
    //    $doc_id_chap4_3=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap4')[3])->where('course_id',$course_id)->first();
    //    $doc_id_chap4_4=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap4')[4])->where('course_id',$course_id)->first();
    //    $doc_id_chap4_5=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap4')[5])->where('course_id',$course_id)->first();
    //    $doc_id_chap4_6=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap4')[6])->where('course_id',$course_id)->first();
    //
    //    $doc_id_chap5_1=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap5')[1])->where('course_id',$course_id)->first();
    //    $doc_id_chap5_2=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap5')[2])->where('course_id',$course_id)->first();
    //    $doc_id_chap5_3=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap5')[3])->where('course_id',$course_id)->first();
    //
    //    $doc_id_chap6_1=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap6')[1])->where('course_id',$course_id)->first();
    //    $doc_id_chap6_2=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap6')[2])->where('course_id',$course_id)->first();
    //    $doc_id_chap6_3=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap6')[3])->where('course_id',$course_id)->first();
    //
    //    $doc_id_chap7_1=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap7')[1])->where('course_id',$course_id)->first();
    //    $doc_id_chap7_2=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap7')[2])->where('course_id',$course_id)->first();
    //    $doc_id_chap7_3=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap7')[3])->where('course_id',$course_id)->first();
    //     $doc_id_chap7_4=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap7')[4])->where('course_id',$course_id)->first();
    //    $doc_id_chap7_5=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap7')[5])->where('course_id',$course_id)->first();
    //    $doc_id_chap7_6=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap7')[6])->where('course_id',$course_id)->first();
    //
    //    $doc_id_chap8_1=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap8')[1])->where('course_id',$course_id)->first();
    //    $doc_id_chap8_2=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap8')[2])->where('course_id',$course_id)->first();
    //    $doc_id_chap8_3=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap8')[3])->where('course_id',$course_id)->first();
    //     $doc_id_chap8_4=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap8')[4])->where('course_id',$course_id)->first();
    //    $doc_id_chap8_5=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap8')[5])->where('course_id',$course_id)->first();
    //    $doc_id_chap8_6=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap8')[6])->where('course_id',$course_id)->first();
    //
    //    $doc_id_chap9_1=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap9')[1])->where('course_id',$course_id)->first();
    //    $doc_id_chap9_2=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap9')[2])->where('course_id',$course_id)->first();
    //
    //    $doc_id_chap10_1=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap10')[1])->where('course_id',$course_id)->first();
    //    $doc_id_chap10_2=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap10')[2])->where('course_id',$course_id)->first();
    //    $doc_id_chap10_3=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap10')[3])->where('course_id',$course_id)->first();
    //    $doc_id_chap10_4=Add_Document::orderBy('id', 'desc')->where('doc_id',__('arrayfile.document_doc_id_chap10')[4])->where('course_id',$course_id)->first();
    //
    //
    //    return view('level.upload_document',['file'=>$file,'data'=>$data],compact('course_id','doc_id1','doc_id2','doc_id3','doc_id4','doc_id5','doc_id6','doc_id_chap2_1','doc_id_chap2_2','doc_id_chap2_3','doc_id_chap2_4','doc_id_chap2_5','doc_id_chap2_6','doc_id_chap3_1',
    //        'doc_id_chap4_1','doc_id_chap4_2','doc_id_chap4_3','doc_id_chap4_4','doc_id_chap4_5','doc_id_chap4_6','doc_id_chap5_1','doc_id_chap5_2','doc_id_chap5_3','doc_id_chap6_1','doc_id_chap6_2','doc_id_chap6_3','doc_id_chap7_1','doc_id_chap7_2','doc_id_chap7_3','doc_id_chap7_4','doc_id_chap7_5','doc_id_chap7_6','doc_id_chap8_1','doc_id_chap8_2','doc_id_chap8_3','doc_id_chap8_4','doc_id_chap8_5','doc_id_chap8_6','doc_id_chap9_1','doc_id_chap9_2','doc_id_chap10_1','doc_id_chap10_2','doc_id_chap10_3','doc_id_chap10_4'))->with('success', 'Documents Update Successfully');
    //
    //}

    //public function add_courses(Request $request)
    // {
    //    //dd($request->all());
    //    $course=new Add_Document;
    //    $course->course_id=$request->course_id;
    //    $course->section_id=$request->section_id;
    //    $course->doc_id=$request->doc_id;
    //    //$course->doc_file=$request->fileup;
    //
    //    if($request->hasfile('fileup'))
    //           {
    //            $file = $request->file('fileup');
    //            $name = $file->getClientOriginalName();
    //            $filename = time().$name;
    //            $file->move('level/',$filename);
    //            //dd($filename);
    //            $course->doc_file= $filename;
    //           }
    //           else
    //           {
    //
    //           }
    //
    //    $course->save();
    //   // dd("added");
    //    $document_record=Add_Document::where('id',$course->id)->first();
    //
    //    //dd("$request->previous_url");
    //    return redirect("$request->previous_url")->with('success', 'eee Documents Update Successfully dd');
    //
    //    //dd("$document_record");
    //    //return response()->json("Course Added Successfully");
    // }




    public function  course_status()
    {
    }



    public function  payment_status()
    {
    }


    public function appliction_status()
    {
    }

    public function preveious_app_status($id)
    {


        $user = ApplicationPayment::find(dDecrypt($id));
        // dd($user);
        $user_info = User::find($user->user_id);

        if ($user->status == '0') {
            // dd('hello');
            $user->status = '1';
        } elseif ($user->status == '1') {
            //dd("hii");
            $user->status = '2';
            $file = ApplicationPayment::whereid(dDecrypt($id))->get('application_id');
            $files = Application::whereid($file[0]->application_id)->get('id');

            $file = Application::find($files[0]->id);
            $file->status = '1';
            $file->update();
        }
        $user->update();

        //Mail sending scripts starts here
        $send_acknowledgment_letter = [
            'subject' => 'Acknowledgment letter for application',
            'body' => 'Payment has been approved for your application, please check attachment as pdf for acknowledgment letter.',
            'attachment' => asset('acknowledgment-letter.pdf')
        ];



        if (url('/') != 'http://127.0.0.1:8000') {
            Mail::to($user_info->email)->send(new SendAcknowledgment($send_acknowledgment_letter));
        }

        return Redirect::back()->with('success', 'Payment Status Changed Successfully');
    }


    public function  uploads_document(Request $request)
    {


        $aplication = Application::whereuser_id(Auth::user()->id)->wherelevel_id($request->level_id)->get();
        if (count($aplication) == 0) {
            $aplication = Application::create(['country' => $request->coutry, 'state' => $request->state, 'user_id' => Auth::user()->id, 'level_id' => $request->level_id]);
            // dd($aplication);
        }
        $aplication = $aplication->first();


        if ($request->hasfile('doc1')) {
            $data = new ApplicationDocument;
            $img = $request->file('doc1');
            $name = $img->getClientOriginalName();
            $filename = time() . $name;
            $img->move('documnet/', $filename);

            $data->status = 1;
            $data->document_type_name = "Doc 1";
            $data->document_file =  $filename;
            $data->user_id = Auth::user()->id;
            $data->application_id = $aplication->id;
            $data->level_id = $request->level_id;
            $data->save();
        }
        if ($request->hasfile('doc2')) {

            $data = new ApplicationDocument;

            $img = $request->file('doc2');
            $name = $img->getClientOriginalName();
            $filename = time() . $name;
            $img->move('documnet/', $filename);
            $data->status = 1;
            $data->document_type_name = "Doc 2";
            $data->document_file =  $filename;
            $data->user_id = Auth::user()->id;
            $data->application_id = $aplication->id;
            $data->level_id = $request->level_id;

            $data->save();
        }
        if ($request->hasfile('doc3')) {

            $data = new ApplicationDocument;

            $img = $request->file('doc3');
            $name = $img->getClientOriginalName();
            $filename = time() . $name;
            $img->move('documnet/', $filename);
            $data->status = 1;
            $data->document_type_name = "Doc 3";
            $data->document_file =  $filename;
            $data->user_id = Auth::user()->id;
            $data->application_id = $aplication->id;
            $data->level_id = $request->level_id;
            $data->save();
        }
        return back()->with('success', 'Done successfully');
    }

    //course model data get
    public function course_list(Request $request)
    {
        $item = LevelInformation::whereid('1')->get();
        $ApplicationCourse = ApplicationCourse::whereid($request->id)->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();

        //return $ApplicationCourse[0]->id;
        $Document = ApplicationDocument::wherecourse_number($ApplicationCourse[0]->id)->get();

        // return $Document;
        /* dd("$Document");*/
        return response()->json(['ApplicationCourse' => $ApplicationCourse, 'Document' => $Document]);
    }


    public function course_edit(Request $request)
    {
        $item = LevelInformation::whereid('1')->get();
        $ApplicationCourse = ApplicationCourse::whereid($request->id)->whereuser_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
        $Document = ApplicationDocument::wherecourse_number($ApplicationCourse[0]->id)->get();
        $course_mode = ['1' => 'Online', '2' => 'Offline', '3' => 'Hybrid'];

        return response()->json(['ApplicationCourse' => $ApplicationCourse, 'Document' => $Document]);
    }


    public function course_edits(Request $request, $id)
    {
        // dd($id);
        //return  $request->all();
        $mode_of_course = $request->mode_of_course;

        $Document = ApplicationDocument::wherecourse_number($id)->get();
        //document upload
        if ($request->hasfile('doc1')) {
            $doc1 = $request->file('doc1');
            $data = ApplicationDocument::find($Document[0]->id);
            $data->document_type_name = 'doc1';
            $name = $doc1[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc1[$i]->move('documnet/', $filename);
            $data->document_file =  $filename;
            $data->save();
        }

        if ($request->hasfile('doc2')) {
            $doc2 = $request->file('doc2');
            $data = ApplicationDocument::find($Document[2]->id);
            $data->document_type_name = 'doc2';
            $doc2 = $request->file('doc2');
            $name = $doc2[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc2[$i]->move('documnet/', $filename);
            $data->document_file =  $filename;
            $data->save();
        }
        if ($request->hasfile('doc3')) {
            $doc3 = $request->file('doc3');
            $data = ApplicationDocument::find($Document[3]->id);
            $data->document_type_name = 'doc3';
            $img = $request->file('doc3');
            $name = $doc3[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc3[$i]->move('documnet/', $filename);
            $data->document_file =  $filename;
            $data->save();
        }


        $file = ApplicationCourse::find($id);
        $file->course_name = $request->Course_Names;
        $file->user_id = Auth::user()->id;
        $file->country = Auth::user()->country;
        $file->eligibility = $request->Eligibilitys;
        $file->mode_of_course = $request->mode_of_course;
        $file->course_brief = $request->course_brief;
        $file->valid_from = $request->created_at;

        //dd($request->years);

        $file->years = $request->years;
        $file->months = $request->months;
        $file->days = $request->days;
        $file->hours = $request->hours;

        //dd($file->application_id);

        $session_for_redirection = $request->form_step_type;
        Session::put('session_for_redirections', $session_for_redirection);
        $session_for_redirections = Session::get('session_for_redirections');

        $file->save();
        return  redirect('edit-application/' . $file->application_id)->with('success', 'Course Edit successfull');

        // return back()->with('sussess', 'level Update successfull');

    }

    public function Assessor_view($id)
    {
        $appId = dDecrypt($id);
        $assesorId = auth()->user()->id;
        $notifications = AssessorApplication::where('application_id', $appId)->where('notification_status', 0)->where('read_by', 0)->get();
        $alreadyPicked = [];
        if (count($notifications) > 0) {
            foreach ($notifications as $notification) {
                $notification->update([
                    'notification_status' => 1,
                    'read_by' => $assesorId
                ]);
            }
        } else {
            $notifications = AssessorApplication::where('application_id', $appId)->get();

            foreach ($notifications as $item) {
                if ($item->read_by !== $assesorId) {
                    $alreadyPicked = 1;
                }
            }

            if ($alreadyPicked === 1) {
                $alreadyPicked = AssessorApplication::where('application_id', $appId)->first();
            }
        }


        $Application = Application::whereid(dDecrypt($id))->get();
        $ApplicationCourse = ApplicationCourse::whereapplication_id($Application[0]->id)->get();
        $ApplicationPayment = ApplicationPayment::whereapplication_id($Application[0]->id)->get();
        $ApplicationDocument = ApplicationDocument::whereapplication_id($Application[0]->id)->get();
        // dd($Application);
        // dd($ApplicationCourse);

        // $spocData =DB::table('applications')->where('user_id',$Application[0]->user_id)->first();
        $spocData = DB::table('applications')->where('id', $Application[0]->id)->first();
        $data = DB::table('users')->where('users.id', $Application[0]->user_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();

        /*Written by suraj*/
        // dd($assesorId);
        $is_exists =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$appId,'assessor_id'=>$assesorId])->first();

        if(!empty($is_exists)){
         $is_final_submit = true;
        }else{
         $is_final_submit = false;
        }

        /*end here*/

        return view('application.accesser.Assessor_view', ['ApplicationDocument' => $ApplicationDocument, 'spocData' => $spocData, 'data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayment' => $ApplicationPayment, 'applicationData' => $Application, 'alreadyPicked' => $alreadyPicked,'is_final_submit'=>$is_final_submit]);
    }

    public function summery_course_report($applicationID)
    {
        $courses = ApplicationCourse::where('application_id', $applicationID)->get();
        $applicationData = Application::find($applicationID);
        $summeryReport = SummaryReport::where('application_id', $applicationID)->get();
        return view('application.accesser.assessor_summery_course_list',compact('courses','applicationData','summeryReport'));
    }

    public function view_summery_report($courseID,$applicationID)
    {
        $applicationDetails = Application::find($applicationID);
        $chapters = Chapter::all();
        $summaryReport = SummeryReport::with('SummeryReportChapter')->where(['application_id'=> $applicationID,'course_id' => $courseID])->first();

        $documentIds = Add_Document::where('course_id', $courseID)->where('application_id', $applicationID)->get(['id']);
        $totalNc = DocComment::whereIn('doc_id',$documentIds)->where('status','!=',4)->where('status','!=',3)->get()->count();
        $totalAccepted = DocComment::whereIn('doc_id',$documentIds)->where('status',4)->get()->count();
        $course = $courseID;
        return view('application.accesser.assessor_summery_report',compact('course','chapters','applicationDetails','totalNc','totalAccepted','summaryReport'));
    }

    public function secretariat_view($id)
    {
        $Application = Application::whereid(dDecrypt($id))->get();
        $ApplicationCourse = ApplicationCourse::whereapplication_id($Application[0]->id)->get();
        $ApplicationPayment = ApplicationPayment::whereapplication_id($Application[0]->id)->get();
        $ApplicationDocument = ApplicationDocument::whereapplication_id($Application[0]->id)->get();
        // $spocData =DB::table('applications')->where('user_id',$Application[0]->user_id)->first();
        $spocData = DB::table('applications')->where('id', $Application[0]->id)->first();


        $data = DB::table('users')->where('users.id', $Application[0]->user_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        return view('secretariat.secretariat-view', ['ApplicationDocument' => $ApplicationDocument, 'spocData' => $spocData, 'data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayment' => $ApplicationPayment]);
    }

    public function document_view($id)
    {


        $data = DB::table('users')->where('users.id', $Application[0]->user_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        return view('secretariat.secretariat-view', ['spocData' => $spocData, 'data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayment' => $ApplicationPayment]);
    }

    public function document_view_accessor($id)
    {

        $ApplicationDocument = ApplicationDocument::find(dDecrypt($id));
        $ApplicationDocument->document_show = 2;
        $ApplicationDocument->save();
        return back();
    }

    public function image_app_status(Request $request, $id)
    {


        $request->validate(
            [
                'payment_slip' => 'mimes:jpeg,png,pdf',
            ]

        );

        $data = ApplicationPayment::find(dDecrypt($id));
        $applicationId = $data->application_id;
        $applicationData = Application::find($applicationId);
        if ($applicationData) {
            $applicationData->status = 1;
            $applicationData->update();
        }
        if ($request->hasfile('payment_slip')) {
            $doc1 = $request->file('payment_slip');
            $name = $doc1->getClientOriginalName();
            $filename = time() . $name;
            $doc1->move('documnet/', $filename);
            $data->payment_slip = $filename;
        }
        $data->status = $request->status ?? 1;
        $data->payment_remark = $request->paymentremark;
        $data->save();

        return back()->with('success', 'Payment confirmation has been successfully processed.');
    }



    public function phoneValidaion(Request $request)
    {
        $contactNumber = $request->contact_number;

        $existingApplication = DB::table('tbl_application')->where('contact_number', $contactNumber)->first();
        if ($existingApplication) {
            return response()->json(['status' => 'duplicate']);
        }

        return response()->json(['status' => 'unique']);
    }


    public function coursePayment(Request $request, $id = null)
    {
        $id = dDecrypt($id);
        $checkPaymentAlready = DB::table('application_payments')->where('application_id', $id)->first();
        if ($checkPaymentAlready) {
            return redirect(url('application-list'))->with('payment_fail', 'Payment has already been submitted for this application.');
        }
        if ($id) {
            $applicationData = DB::table('applications')->where('id', $id)->first();
            $course = DB::table('application_courses')->where('application_id', $id)->get();

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
        }



        return view('level.course-payment', compact('applicationData', 'course', 'currency', 'total_amount'));
    }

    public function create_course($id = null)
    {
        $id = dDecrypt($id);
        if ($id) {
            $applicationData = DB::table('applications')->where('id', $id)->first();
        }

        $course = DB::table('application_courses')->where('application_id', $id)->get();
        return view('level.create-course', compact('applicationData', 'course'));
    }

    public function newApplications($id = null)
    {
        if ($id) {
            $id = dDecrypt($id);
        }
        if ($id) {
            $applicationData = DB::table('applications')->where('id', $id)->first();
        } else {
            $applicationData = null;
        }

        $id = Auth::user()->id;
        $item = LevelInformation::whereid('1')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        return view('level.new_application', ['data' => $data, 'applicationData' => $applicationData, 'item' => $item]);
    }

    public function edit_application(Request $request, $id = null)
    {
        if ($id) {
            $applicationData = DB::table('applications')->where('id', $id)->first();
        }

        $course = DB::table('application_courses')->where('application_id', $id)->get();
        return view('level.edit_application', compact('applicationData', 'course'));
    }


    public function  newApplicationSave(Request $request)
    {

        if ($request->previous_data && $request->application_id) {
            return redirect(url('create-course/' . dEncrypt($request->application_id)));
        }

        $this->validate(
            $request,
            [
                'Email_ID' => ['required', 'regex:/^(?!.*[@]{2,})(?!.*\s)[a-zA-Z0-9\+_\-]+(\.[a-zA-Z0-9\+_\-]+)*@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/i', 'unique:applications,Email_ID'],
                'Contact_Number' => 'required|numeric|min:10|digits:10|unique:applications,Contact_Number',
                'Person_Name' => 'required',
                'designation' => 'required',
            ],
            [
                'Email_ID.regex' => "Please Enter a Valid Email Id.",
                'Email_ID.required' => "Please Enter an Email Id.",
            ]
        );




        $application = new Application;
        $application->level_id = 1;
        $application->user_id = $request->user_id;
        $application->state = $request->state_id;
        $application->country = $request->country_id;
        $application->Person_Name = $request->Person_Name;
        $application->Contact_Number = $request->Contact_Number;
        $application->Email_ID = $request->Email_ID;
        $application->city = $request->city_id;
        $application->designation = $request->designation;
        $application->ip = getHostByName(getHostName());
        $application->save();
        return redirect(url('create-course/' . dEncrypt($application->id)))->with('success', 'Application Create Successfully');
    }


    public function applictionTable()
    {
        // $collection = ApplicationPayment::orderBy('application_id', 'desc')->whereuser_id(Auth::user()->id)->get();
        $collection = Application::latest()->get();
        $filteredApplications = [];

        foreach ($collection as $application) {
            $paymentAvailable = ApplicationPayment::where('application_id', $application->id)->first();

            if (isset($paymentAvailable)) {
                $filteredApplications[] = $application;
            }
        }
        return view('level.application_table', ['collection' => $filteredApplications]);
    }

    public function faqslist()
    {
        $faqs = Faq::where('category', 1)->orderby('sort_order', 'Asc')->get();
        return view('level.applicationFaq', ['faqs' => $faqs]);
    }

    public function pendingPaymentlist()
    {

        $level_list_data = DB::table('applications')
            ->where('applications.user_id', Auth::user()->id)
            ->where('applications.status', '0')
            ->select('applications.*', 'countries.name as country_name')
            ->join('countries', 'applications.country', '=', 'countries.id')->latest()->get();



        $finalData = [];
        foreach ($level_list_data as $item) {
            $paymentData = DB::table('application_payments')->where('application_id', $item->id)->first();
            $country = DB::table('countries')->where('id', $item->country)->orderBy('id', 'desc')->first();
            if (!$paymentData) {
                $finalData[] = [
                    'id' => $item->id,
                    'application_uid' => $item->application_uid,
                    'level_id' => $item->level_id,
                    'user_id ' => $item->user_id,
                    'Person_Name' => $item->Person_Name,
                    'Contact_Number' => $item->Contact_Number,
                    'Email_ID' => $item->Email_ID,
                    'designation' => $item->designation,
                    'city' => $item->city,
                    'state' => $item->state,
                    'country_name' => $country->name,
                    'status' => $item->status,

                ];
            }
        }

        $level_list_data = $finalData;

        return view('level.pendinglistApplication', ['level_list_data' => $level_list_data]);
    }

    public function emailValidaion(Request $request)
    {
        $email = $request->email;

        $existingApplication = DB::table('tbl_application')->where('email', $email)->first();

        if ($existingApplication) {
            return response()->json(['status' => 'duplicate']);
        }

        return response()->json(['status' => 'unique']);
    }

    public function paymentTransactionValidation(Request $request)
    {
        $transactionNumber = DB::table('tbl_application_payment')->where('payment_transaction_no', $request->transaction_no)->whereNull('payment_ext')->where('pay_status','Y')->first();

        if ($transactionNumber) {
            // Transaction number already exists
            return response()->json(['status' => 'error', 'message' => 'This transaction ID is already used']);
        } else {
            // Transaction number doesn't exist, you can proceed or return a success message
            // For example, you can return a success message like this:
            return response()->json(['status' => 'success', 'message' => '']);
        }
    }

    public function paymentReferenceValidation(Request $request)
    {
        $transactionNumber = DB::table('tbl_application_payment')->where('payment_reference_no', $request->reference_no)->whereNull('payment_ext')->where('pay_status','Y')->first();
        if ($transactionNumber) {
            // Transaction number already exists
            return response()->json(['status' => 'error', 'message' => 'This Reference ID is already used']);
        } else {
            // Transaction number doesn't exist, you can proceed or return a success message
            // For example, you can return a success message like this:
            return response()->json(['status' => 'success', 'message' => '']);
        }
    }

    public function paymentDuplicateCheck(Request $request)
    {
        $id = $request->application_id;
        $checkPaymentAlready = DB::table('application_payments')->where('application_id', $id)->first();
        if ($checkPaymentAlready) {
            return response()->json(['paymentExist' => true]);
        }
    }

    //  upgrade application logic //



    // public function upgradeApplicationLevel(Request $request){
    //     $application_id = $request->application_id;
    //     $user_id = auth()->user()->id;

    //     // Find the application
    //     $applicationData = Application::where('id', $application_id)
    //         ->where('user_id', $user_id)
    //         ->first();

    //     if ($applicationData) {
    //         $levelId = $applicationData->level_id;

    //         // Increment the level_id
    //         $applicationData->level_id = $levelId + 1;

    //         // Update the created_at date (add 1 year)
    //         $applicationData->created_at = now();

    //         // Save the changes to the application
    //         $applicationData->save();

    //         // Update related tables manually
    //         DB::table('application_payments')
    //             ->where('user_id', $user_id)
    //             ->where('application_id', $application_id)
    //             ->update([
    //                 'level_id' => $applicationData->level_id,
    //                 'created_at' => $applicationData->created_at,
    //             ]);

    //         DB::table('application_documents')
    //             ->where('user_id', $user_id)
    //             ->where('application_id', $application_id)
    //             ->update([
    //                 'level_id' => $applicationData->level_id,
    //                 'created_at' => $applicationData->created_at,
    //             ]);

    //         DB::table('application_courses')
    //             ->where('user_id', $user_id)
    //             ->where('application_id', $application_id)
    //             ->update([
    //                 'level_id' => $applicationData->level_id,
    //                 'created_at' => $applicationData->created_at,
    //             ]);

    //         return redirect()->back()->with('success', 'Your application has been upgraded from level ' . $levelId . ' to ' . $applicationData->level_id);
    //     } else {
    //         return redirect()->back()->with('fail', 'Something went wrong!');
    //     }
    // }



    //  upgrade application logic //


    public function uploadVerificationDocuments(Request $request)
    {
        // dd($request->all());
        $fileExtension = $request->file->getClientOriginalExtension();

        if ($fileExtension === 'pdf' || $fileExtension === 'jpg') {

            $document = Add_Document::where('question_id', $request->questionId)->where('application_id', $request->applicationId)->where('course_id', $request->courseId)->first();

            if ($document) {
                $doc1 = $request->file('file');
                $name = $doc1->getClientOriginalName();
                $filename = time() . $name;
                $doc1->move('documnet/', $filename);
                $fileName = $filename;

                $document->on_site_assessor_Id = auth()->user()->id;
                if ($request->documentType === 'document') {
                    $document->verified_document = $fileName;
                } elseif ($request->documentType === 'photograph') {
                    $document->photograph = $fileName;
                } else {
                    return response()->json(['error' => 'Document Type Mismatch!']);
                }

                $document->update();
                return response()->json(['success' => 'File uploaded successfully.']);
            } else {
                return response()->json(['error' => 'Record not find.']);
            }
        } else {
            // Invalid file extension
            return response()->json(['error' => 'Invalid file extension. Only PDF and JPG files are allowed.']);
        }
    }

    public function submitFinalReport($id)
    {
        $applicationData = Application::find($id);
        return view('application.submit-final-report', compact('applicationData'));
    }

    public function submitFinalReportPost(Request $request, $id)
    {
        $request->validate([
            'gps_pic' => 'required|image|mimes:jpg,png|max:2048', // Adjust the image size limit as needed
            'remark' => 'required|max:500',
        ], [
            'gps_pic.required' => 'The GPS picture is required.',
            'gps_pic.image' => 'The GPS picture must be an image (jpg or png).',
            'gps_pic.mimes' => 'The GPS picture must be in jpg or png format.',
            'gps_pic.max' => 'The GPS picture must not be larger than 2MB.',
            'remark.required' => 'The remark field is required.',
            'remark.max' => 'The remark must not exceed 500 characters.',
        ]);

        $doc1 = $request->file('gps_pic');
        $name = $doc1->getClientOriginalName();
        $filename = time() . $name;
        $doc1->move('documnet/', $filename);
        $fileName = $filename;

        $applicationData = Application::find($id);

        $update = $applicationData->update([
            'final_remark' => $request->remark,
            'gps_pic' => $fileName
        ]);

        if ($update) {
            return redirect()->back()->with('success', "Report submit successfully");
        } else {
            return "fail";
        }
    }

    public function submitReportByDesktopAssessor($application_id,$course_id)
    {
        $applicationDetails = Application::find($application_id);

        $chapters = Chapter::all();

        //dd($applicationDetails);

        return view('asesrar.summery_report_form',compact('chapters','applicationDetails','course_id'));
    }

    public function submitFinalReportByDesktopAssessor(Request $request)
    {
        $data = $request->all();
        $data['summary_type'] = 'desktop';

        $summaryReport = SummaryReport::create($data);

        if(isset($data['question_ids'])){
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
        }
        $application = Application::find($data['application_id']);
        $updated = $application->update([
            'desktop_status' => 1
        ]);
        ApplicationNotification::create([
            'application_id' => $data['application_id'],
            'is_read' => 0,
            'notification_type' => 'payment'
        ]);
        return redirect('/nationl-accesser')->with('success', "Report submit successfully");
    }

    public function pendingPayments($application_id)
    {


        $applicationData = Application::find($application_id);

        if (count($applicationData->payments) > 1 && $applicationData->is_read == 1) {
            return redirect(url('application-list'))->with('warning', 'Payment has already been made.');
        }

        DB::table('applications')->where('id', $application_id)->update(['is_read' => 1]);

        $course = DB::table('application_courses')->where('application_id', $application_id)->get();

        $applicationNotification =  ApplicationNotification::where('application_id', $application_id)->first();

        $applicationNotification->update(['is_read' => 1]);

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

        $payments = ApplicationPayment::where('application_id', $application_id)->get();
        return view('application.final-payments', compact('total_amount', 'payments', 'applicationData', 'course', 'currency'));
    }
}
