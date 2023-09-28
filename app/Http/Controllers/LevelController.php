<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Application;
use App\Models\ApplicationCourse;
use App\Models\ApplicationPayment;
use App\Models\ApplicationDocument;
use App\Models\LevelInformation;
use App\Models\DocumentReportVerified;
use App\Models\AcknowledgementRecord;
use App\Models\User;
use App\Models\Faq;
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
use App\Mail\paymentSuccessMail;

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
        $ApplicationCourse = ApplicationCourse::whereapplication_id($Application[0]->id)->get();
        $ApplicationPayment = ApplicationPayment::whereapplication_id($Application[0]->id)->get();
        $spocData = DB::table('applications')->where('id', $Application[0]->id)->first();
        $ApplicationDocument = ApplicationDocument::whereapplication_id($Application[0]->id)->get();
        $data = DB::table('users')->where('users.id', $Application[0]->user_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        return view('level.admin_course_view', ['ApplicationDocument' => $ApplicationDocument, 'spocData' => $spocData, 'data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayment' => $ApplicationPayment]);
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
    public function coursePayment(Request $request, $id = null)
    {
        return view('level.course-payment');
    }
    
    public function level1tp(Request $request, $id = null)
    {
        if ($request->input('display') == 'applications') {
           Session::put('session_for_redirections','application-payment');
        }
        if($id!=null){
            Session::put('session_for_redirections','add-course');
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

        if ($id) {
            $id = $id;
        }
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

            $level_list_data = DB::table('applications')
                ->where('applications.user_id', Auth::user()->id)
                ->where('applications.status', '0')
                ->select('applications.*', 'countries.name as country_name')
                ->join('countries', 'applications.country', '=', 'countries.id')->orderBy('applications.id', 'desc')->get();
            /*end level list */

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
            $file->mode_of_course = $mode_of_course;
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
            return  redirect('create-course/' . $data->application_id)->with('success', 'Course  successfully  Added');
            // return  redirect('level-first/'.dEncrypt($data->application_id))->with('success','Course  successfully  Added!!!!');

        } elseif ($request->level_id == '2') {
            //dd("level2");
            return  redirect('level-first/' . encrypt($data->application_id))->with('success', 'Course  successfully  Added');

            //return  redirect('level-first-upgrade/'.$level2_application_id.'/'.$data->applications_id)->with('success','Course  successfully  Added!!!!');

            //return  redirect('level-list')->with('success','Course successfully Added!!!!');

        } elseif ($request->level_id == '3') {

            return  redirect('level-list')->with('success', 'Course successfully Added');
        } else {
            return  redirect('create-course/' . $data->application_id)->with('success', 'Course successfully Added');
        }
    }





    //couser payment


    public function new_application_payment(Request $request)
    {

        //return $request->all();
        $this->validate($request, [
            'payment_details_file' => 'mimes:pdf,jpeg,png,jpg,gif,svg',

        ]);
        $item = new ApplicationPayment;
        $item->level_id = $request->level_id;
        $item->user_id = Auth::user()->id;
        $item->amount = $request->amount;
        $item->payment_date = date("Y-m-d", strtotime($request->payment_date));

        $item->payment_details = $request->payment_transaction_no;
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

            return  redirect('level-first')->with('success', 'Payment Done successfully');


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

    public function previews_application1($ids, $application_id)
    {

        $id = Auth::user()->id;
        $item = LevelInformation::whereid('1')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')
            ->join('countries', 'users.country', '=', 'countries.id')
            ->join('cities', 'users.city', '=', 'cities.id')
            ->join('states', 'users.state', '=', 'states.id')
            ->first();

        $spocData = DB::table('applications')->where('id', $application_id)->first();

        //return $item[0]->id;


        $ApplicationCourse = ApplicationCourse::where('user_id', $id)->wherepayment($ids)->wherelevel_id($item[0]->id)->get();
        $ApplicationPayment = ApplicationPayment::where('user_id', $id)->whereid($ids)->wherelevel_id($item[0]->id)->get();

        $check_payment = ApplicationPayment::where('id', $ids)->first();
        if ($check_payment->level_id == 2) {
            $ApplicationCourse = ApplicationCourse::where('user_id', $id)->wherepayment($ids)->wherelevel_id(2)->get();
            $ApplicationPayment = ApplicationPayment::where('user_id', $id)->whereid($ids)->wherelevel_id(2)->get();
        }


        //return $ApplicationPayment;


        return view('level.level-previous_view', ['spocData' => $spocData, 'data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayment' => $ApplicationPayment]);
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
    public function upload_document($id, $course_id)
    {
        //dd("yes");
        $application_id = $id;
        $course_id = $course_id;
        // dd(dDecrypt($id));
        $data = ApplicationPayment::whereapplication_id($id)->get();
        $file = ApplicationDocument::whereapplication_id($data[0]->application_id)->get();

        //return $file;

        $doc_id1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap1')[1])->where('course_id', $course_id)->first();
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

        // return $doc_id_chap3_1->id;

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


        return view('level.upload_document', ['file' => $file, 'data' => $data], compact(
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
            'doc_id_chap10_4'
        ))->with('success', 'Documents Update Successfully');
    }


    public function accr_upload_document($id, $course_id)
    {

        $application_id = $id;
        $course_id = $course_id;
        // dd(dDecrypt($id));
        $data = ApplicationPayment::whereapplication_id($id)->get();
        $file = ApplicationDocument::whereapplication_id($data[0]->application_id)->get();

        $doc_id1 = Add_Document::orderBy('id', 'desc')->where('doc_id', __('arrayfile.document_doc_id_chap1')[1])->where('course_id', $course_id)->first();
        // dd($doc_id1);


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




        return view('asesrar.view_document', ['file' => $file, 'data' => $data], compact(
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
            'doc_id_chap10_4'
        ))->with('success', 'Documents Update Successfully');
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




        return view('asesrar.admin_view_document', ['file' => $file, 'data' => $data], compact(
            'application_id',
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


    public function show_comment($doc_id)
    {
        $comment = DocComment::orderby('id', 'Desc')->where('doc_id', $doc_id)->get();
        return view('asesrar.show-comment', compact('comment'));
    }

    public function document_comment_admin_assessor($course_id){
        $comment = DocComment::orderby('id', 'Desc')->where('course_id', $course_id)->get();
        return view('asesrar.show-comment-accr-admin', compact('comment'));
    }

    public function add_courses(Request $request)
    {
        //dd($request->all());

        if ($request->add_doc_id) {
            //dd("update");
            $course = Add_Document::find($request->add_doc_id);
            if ($request->hasfile('fileup_update')) {
                //dd("yes");
                File::delete('level/' . $course->doc_file);
                $file = $request->file('fileup_update');
                $name = $file->getClientOriginalName();
                $filename = time() . $name;
                $file->move('level/', $filename);
                //dd($filename);
                $course->doc_file = $filename;
            }
            $course->status = 1;
            $course->application_id = $request->application_id;
            $course->user_id = Auth::user()->id;

            //update document comment latest record
            $document = DocComment::orderBy('id', 'desc')->where('doc_id', $request->add_doc_id)->first();
            $document->status = 0;
            $course->notApraove_count = $course->notApraove_count + 1;
            $document->save();
        } else {

            $course = new Add_Document;
            $course->course_id = $request->course_id;
            $course->section_id = $request->section_id;
            $course->doc_id = $request->doc_id;
            $course->application_id = $request->application_id;
            $course->user_id = Auth::user()->id;
            $course->notApraove_count = 1;


            if ($request->hasfile('fileup')) {
                $file = $request->file('fileup');
                $name = $file->getClientOriginalName();
                $filename = time() . $name;
                $file->move('level/', $filename);
                //dd($filename);
                $course->doc_file = $filename;
            }
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


        return redirect("$request->previous_url")->with('success', 'Documents Update Successfully');
        //return response()->json("Course Added Successfully");
    }

    public function view_doc($doc_code, $id, $doc_id, $course_id)
    {
        $comment = DocComment::orderby('id', 'Desc')->where('doc_id', $doc_id)->get();
        $doc_latest_record_comment = DocComment::orderby('id', 'desc')->where('doc_id', $doc_id)->count();
        $doc_latest_record = Add_Document::orderby('id', 'desc')->where('id', $doc_id)->first();

        return view('asesrar.view-doc-with-comment', ['doc_latest_record' => $doc_latest_record, 'id' => $id, 'doc_id' => $doc_id, 'doc_latest_record_comment' => $doc_latest_record_comment, 'doc_code' => $doc_code, 'comment' => $comment], compact('course_id'));
    }

    public function admin_view_doc($doc_code, $id, $doc_id, $course_id){
        $comment = DocComment::orderby('id', 'Desc')->where('doc_id', $doc_id)->get();
        $doc_latest_record_comment = DocComment::orderby('id', 'desc')->where('doc_id', $doc_id)->count();
        $doc_latest_record = Add_Document::orderby('id', 'desc')->where('id', $doc_id)->first();
        return view('asesrar.view-doc-with-comment-admin', ['doc_latest_record' => $doc_latest_record, 'id' => $id, 'doc_id' => $doc_id, 'doc_latest_record_comment' => $doc_latest_record_comment, 'doc_code' => $doc_code, 'comment' => $comment], compact('course_id'));
    }

    public function acc_doc_comments(Request $request)
    {

        //dd("yesss");
        /*$this->validate($request, [
            'status' => 'required',
        ]);*/
        //return $request->all();
        //return $request->course_id;
        $login_id = Auth::user()->role;
        if ($login_id == 3) {
            $request->doc_code;

            $document = Add_Document::where('doc_id', $request->doc_code)->first();
            $document->assessor_id = Auth::user()->id;
            $document->save();


            $comment = new DocComment;
            $comment->doc_id = $request->doc_id;
            $comment->doc_code = $request->doc_code;
            $comment->status = $request->status;
            $comment->comments = $request->doc_comment;
            $comment->course_id = $request->course_id;
            $comment->user_id = Auth::user()->id;
            $comment->save();

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

        } elseif ($login_id == 1) {      //return $request->course_id;
            $comment = new DocComment;
            $comment->doc_id = $request->doc_id;
            $comment->doc_code = $request->doc_code;
            $comment->status = $request->status;
            $comment->comments = $request->doc_comment;
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

        Mail::to($user_info->email)->send(new SendAcknowledgment($send_acknowledgment_letter));
        //Mail sending script ends here


        // $file=ApplicationPayment::whereid($id)->get('application_id');
        // $file=ApplicationCourse::where('application_id',$file[0]->application_id)->get('id');


        // foreach($file as $item)
        // {
        //     $ApplicationCourse=ApplicationCourse::find($item->id);
        //     $ApplicationCourse->status=($ApplicationCourse->status==1?'0':'1');
        //     $ApplicationCourse->update();
        // }

        //status change in application


        return Redirect::back()->with('success', 'Status Changed Successfully');
    }


    public function  uploads_document(Request $request)
    {

        // dd($request->all());
        // if($request->hasfile('file'))
        // {
        //     $img = $request->file('file');
        //     $name =$img->getClientOriginalName();
        //     $filename = time().$name;
        //     $img->move('profile/',$filename);
        //     $data->file=$filename;
        // }

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
        return  redirect('level-first/' . $file->application_id)->with('success', 'Course Edit successfull');

        // return back()->with('sussess', 'level Update successfull');

    }

    public function Assessor_view($id)
    {
        $Application = Application::whereid(dDecrypt($id))->get();
        $ApplicationCourse = ApplicationCourse::whereapplication_id($Application[0]->id)->get();
        $ApplicationPayment = ApplicationPayment::whereapplication_id($Application[0]->id)->get();
        $ApplicationDocument = ApplicationDocument::whereapplication_id($Application[0]->id)->get();
        // dd($ApplicationDocument);

        // $spocData =DB::table('applications')->where('user_id',$Application[0]->user_id)->first();
        $spocData = DB::table('applications')->where('id', $Application[0]->id)->first();
        $data = DB::table('users')->where('users.id', $Application[0]->user_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        return view('application.accesser.Assessor_view', ['ApplicationDocument' => $ApplicationDocument, 'spocData' => $spocData, 'data' => $data, 'ApplicationCourse' => $ApplicationCourse, 'ApplicationPayment' => $ApplicationPayment]);
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
        if ($request->hasfile('payment_slip')) {
            $doc1 = $request->file('payment_slip');
            $name = $doc1->getClientOriginalName();
            $filename = time() . $name;
            $doc1->move('documnet/', $filename);
            $data->payment_slip = $filename;
        }
        $data->payment_remark = $request->paymentremark;
        $data->save();

        return back()->with('sussess', 'Payment Confirmation is Successfully');;
    }



    public function checkContactNumber(Request $request)
    {
        $contactNumber = $request->contact_number;

        $existingApplication = Application::where('Contact_Number', $contactNumber)->first();

        if ($existingApplication) {
            return response()->json(['status' => 'duplicate']);
        }

        return response()->json(['status' => 'unique']);
    }

    public function checkEmail(Request $request)
    {
        $email = $request->email;

        $existingApplication = Application::where('Email_ID', $email)->first();

        if ($existingApplication) {
            return response()->json(['status' => 'duplicate']);
        }

        return response()->json(['status' => 'unique']);
    }


    public function create_course($id=null){
        if($id){
            $applicationData = DB::table('applications')->where('id',$id)->first();
        }

       $course = DB::table('application_courses')->where('application_id',$id)->get();
        return view('level.create-course',compact('applicationData','course'));
    }
   public function newApplications($id=null){
    if($id){
        $applicationData = DB::table('applications')->where('id',$id)->first();
    }else{
        $applicationData = null;
    }

    $id = Auth::user()->id;
    $item = LevelInformation::whereid('1')->get();
    $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
    return view('level.new_application',['data'=>$data,'applicationData'=>$applicationData,'item'=>$item]);

   }

   public function  newApplicationSave(Request $request){


    if($request->previous_data && $request->application_id){
        return redirect(url('create-course/'.$request->application_id))->with('success','Application Create Successfully');
    }

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



        $application = new Application;
        $application->level_id = $request->level_id;
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
        return redirect(url('create-course/'.$application->id))->with('success','Application Create Successfully');
   }


    public function applictionTable(){
      $collection = ApplicationPayment::orderBy('id', 'desc')->whereuser_id(Auth::user()->id)->get();
      return view('level.application_table',['collection'=>$collection]);
    }

    public function faqslist(){
        $faqs = Faq::where('category', 1)->orderby('sort_order', 'Asc')->get();
        return view('level.applicationFaq',['faqs'=>$faqs]);
    }

    public function pendingPaymentlist(){

        $level_list_data = DB::table('applications')
            ->where('applications.user_id', Auth::user()->id)
            ->where('applications.status', '0')
            ->select('applications.*', 'countries.name as country_name')
            ->join('countries', 'applications.country', '=', 'countries.id')->get();
        return view('level.pendinglistApplication',['level_list_data'=>$level_list_data]);
    }


}
