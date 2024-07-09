<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\Level;
use App\Models\LevelRule;
use App\Models\Application;
use App\Models\ApplicationCourse;
use App\Models\ApplicationPayment;
use App\Models\ApplicationAcknowledgement;
use App\Models\ApplicationDocument;
use App\Models\DocumentType;
use App\Models\grievance;
use App\Models\emaildomeins;
use App\Models\ApplicationReport;
use App\mail\Grienvance_tp;
use App\Models\User;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;
use Auth;
use Redirect;

class DashboardController extends Controller
{

   public function email_verification()
   {

    $email=emaildomeins::get();
    return view('email.email-domain',['email'=>$email]);
   }

    public function email_verifications(Request $request)
    {



        $data = new emaildomeins;
        $data->emaildomain = $request->emaildomain;
        $data->save();
        return back()->with('success', 'Email Domin Successfully Added!!!!');;

    }

    public function  email_domoin_delete($id)
    {
        $data =emaildomeins:: find($id);
        $data->delete();
        return back()->with('fail', 'Email Domin Successfully Delete !!!!');;

    }






    public function index(Request $request)
    {
        // $data['pending']=[
        //     'india'=>$this->get_application_india(0),
        //     'saarc'=>$this->get_application_saarc(0),
        //     'world'=>$this->get_application_world(0)
        // ];
        // $data['processing']=[
        //     'india'=>$this->get_application_india(2),
        //     'saarc'=>$this->get_application_saarc(2),
        //     'world'=>$this->get_application_world(2)
        // ];
        // $data['approved']=[
        //     'india'=>$this->get_application_india(1),
        //     'saarc'=>$this->get_application_saarc(1),
        //     'world'=>$this->get_application_world(1)
        // ];
        // dd(Auth::user()->role);

        // for admin
        if(Auth::user()->role == 1){
            $application = DB::table('tbl_application as a')
            ->whereIn('a.payment_status',[0,1,2,3])
            ->orderBy('id','desc')
            ->get();
        }
        if(Auth::user()->role == 2){
            // tp dashboard
            $application = DB::table('tbl_application as a')
            ->where('tp_id',Auth::user()->id)
            ->whereIn('a.payment_status',[0,1,2,3])
            ->orderBy('id','desc')
            ->get();
        }        
        // onsite-assessor
        if(Auth::user()->role == 3){
            $assessor_id = Auth::user()->id;
            $assessor_application = DB::table('tbl_assessor_assign')
                ->where('assessor_id',$assessor_id)
                ->pluck('application_id')->toArray();
            $application = DB::table('tbl_application')
            ->whereIn('payment_status',[1,2,3])
            ->whereIn('id',$assessor_application)
            ->orderBy('id','desc')
            ->get();
        }
        // account detail
        if(Auth::user()->role == 6){
            $application = DB::table('tbl_application as a')
            ->whereIn('payment_status',[0,1,2,3])
            ->orderBy('id','desc')
            ->get();
        }

        // secretaritat detail
        if(Auth::user()->role == 5){
            $application = DB::table('tbl_application as a')
            ->whereIn('a.payment_status',[0,1,2,3])
            ->where('secretariat_id',Auth::user()->id)
            ->orderBy('id','desc')
            ->get();
        }

        $final_data=array();
        $dataCount = [
            'pending' => 0,
            'processing' => 0,
            'complete' => 0,
        ];
        foreach($application as $app){
            $obj = new \stdClass;
            $obj->application_list= $app;
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $app->id,
                ])
                ->whereNull('deleted_at') 
                ->count();
                if($course){
                    $obj->course_count = $course;
                }
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    
                ])
                ->first();
                $payment_amount = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                ])
                ->where('status',2)
                ->sum('amount');
                $payment_count = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                ])
                ->where('status',2)
                ->count();
                $final_data[] = $obj;
            }
            foreach($final_data as $key => $data)
            {
                if ($data->application_list->payment_status == 0 || $data->application_list->payment_status == 1) {
                    // pending
                    $dataCount['pending']++;
                } elseif ($data->application_list->payment_status == 2) {
                    // process
                    $dataCount['processing']++;
                } else {
                    // complete
                    $dataCount['complete']++;
                }
            }
        // dd($dataCount);
        return view("pages.dashboard",['dataCount'=>$dataCount]);
    }

    function get_india_id(){
        $india=Country::where('name','India')->get('id')->first();
       return $india->id;
    }

    function get_saarc_ids(){
        //Afghanistan, Bangladesh, Bhutan, India, Maldives, Nepal, Pakistan and Sri-Lanka
        $saarc=Country::whereIn('name',Array('Afghanistan', 'Bangladesh', 'Bhutan', 'Maldives', 'Nepal', 'Pakistan', 'Sri Lanka'))->get('id');
        $saarc_ids=Array();
        foreach($saarc as $val)$saarc_ids[]=$val->id;
        return $saarc_ids;
    }

    function get_application_india($status='0',$date1='0',$date2='0'){
        //0 pending, 1 approved, 2 processing
        $applications=Application::where('country',$this->get_india_id())->where('status',$status)->get('id');
        $total=$applications->count();
        return $total;
    }

    function get_application_saarc($status='0',$date1='0',$date2='0'){
        //0 pending, 1 approved, 2 processing
        $applications=Application::whereIn('country',$this->get_saarc_ids())->where('status',$status)->get('id');
        $total=$applications->count();
        return $total;
    }

    function get_application_world($status='0',$date1='0',$date2='0'){
        //0 pending, 1 approved, 2 processing
        $india_id=$this->get_india_id();
        $saarc_ids=$this->get_saarc_ids();
        array_push($saarc_ids,$india_id);
        //dd($saarc_ids);
        $applications=Application::whereNotIn('country',$saarc_ids)->where('status',$status)->get('id');
        $total=$applications->count();
        return $total;
    }

    function get_users_count($status='0'){
        //0 pending, 1 approved, 2 processing
        $applications=User::whereIn('country',$this->get_saarc_ids())->where('status',$status)->get('id');
        $total=$applications->count();
        return $total;
    }


   

    public function Grievance()
    {
        return view('level.Grievance');
    }

    public function Grievance_list()
    {
        if(Auth::user()->role == '1')
        {
        $data=grievance::get();
      //  dd($data);
        }else
        {
        $data=grievance::wheresend_email(Auth::user()->email)->get();
       // dd($data);
        }

        return view('level.addGrievance',['data'=>$data]);
    }

    public function active_Grievance($id)
    {
        $user=grievance::find($id);
        $user->status=($user->status==1?'0':'1');
        $user->update();
        return Redirect::back()->with('success', 'Status Changed Successfully');
    }


    public function view_Grievance($id)
    {
        $user=grievance::find($id);
        $data=grievance::whereid($id)->get();
        return  view('level.grievance-view',['data'=>$data]);


    }


    public function Add_Grievance(Request $request)
    {
       //dd($request);
        $request->validate(
            [
            'details' =>'required',
            'subject'=>'required'
            ]
        );
         // dd($request->all());
            $data= new grievance;
            $data->subject = $request->subject;
            $data->details = $request->details;
            $data->status =  '0';
            $data->send_email=Auth::user()->email;

            $details = [
                'title' => $data->subject,
                'body' => $request->details
            ];

            \Mail::to(Auth::user()->email)->send(new \App\Mail\Grienvance_tp($details));


//second mail function

    $details = [
        'title' => $data->subject,
        'body' => $request->details
    ];

    \Mail::to('monu@yopmail.com')->send(new \App\Mail\Grienvance_admin($details));

    // dd("Email is Sent.");

    $data->save();
    return redirect('/Grievance-list')->with('success', 'grievance Mail send successfull!! ');
    }
}
