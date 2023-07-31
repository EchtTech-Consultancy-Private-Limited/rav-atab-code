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

use App\Mail\paymentSuccessMail;
use App\Mail\secretariatapplicationmail;
use App\Mail\secretariatadminapplicationmail;

use App\Mail\assessoradminapplicationmail;
use App\Mail\assessorapplicationmail;

use App\Models\User;
use App\Models\Event;
use Mail;
use DB;
use Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

class applicationController extends Controller
{


    public function show_pdf($name)
    {
         $data= $name;

        // dd("$data");

        return view('showfile',['data'=>$data]);

    }

    public function show_course_pdf($name)
    {
       // dd("yes");
          $data= $name;
         return view('course-document.show-course-file',['data'=>$data]);

    }

    public function Assigan_application(Request $request)
    {

       // dd($request->assessor_id);
      
    //return $request->all(); 
   // return $request->application_id;   
    $value= DB::table('asessor_applications')->where('application_id','=',$request->application_id)->get();
    if(count($value) > 0)
    {
            $data= DB::table('asessor_applications')->where('application_id','=',$request->application_id);
            if($data == false)
            {
                $assessor_id=$request->assessor_id;

                for($i=0; $i<count($assessor_id); $i++){

                    $data = new asessor_application();
                    $data->assessor_id=$request->assessor_id[$i];
                    $data->application_id=$request->application_id;
                    $data->status=1;
                    $data->assessment_type=$request->assessment_type;
                    $data->due_date=$due_date = Carbon::now()->addDay(15);
                    $data->save();
                }
                return  back()->with('sussess','Application has been successfully assigned to assessor');
            }
            else{
                return  back()->with('error',' This application has already been assigned to this assesser ');

            }
    }else{
    $assessor_id=$request->assessor_id;

    //dd("in out");

    for($i=0; $i<count($assessor_id); $i++)
    { 
       // dd("in loop");

        $data = new asessor_application();
        $data->assessor_id=$request->assessor_id[$i];
        $data->application_id=$request->application_id;
        $data->status=1;
        $data->assessment_type=$request->assessment_type;
        $data->due_date=$due_date = Carbon::now()->addDay(15);
        $data->save();
        //dd($request->sec_email);
           //mail send
            $asses_email=$request->sec_email;
            $superadminEmail = 'superadmin@yopmail.com';
            $adminEmail = 'admin@yopmail.com';

            //Mail sending scripts starts here
            $adminapplicationsecretariatMail = [
            'title' =>'Application Send to Assessor Successfully!!!!',
            'body' => '',
            'type' => 'Send To Assessor'
            ];
            $application_id=$request->application_id;
            $username=Auth::user()->firstname;

            Mail::to([$superadminEmail,$adminEmail])->send(new assessoradminapplicationmail($adminapplicationsecretariatMail,$application_id,$username));

           for($k=0; $k<= (count($request->assessor_id)-1); $k++)
           {
             $assessor_email=User::select('email')->where('id',$request->assessor_id[$k])->first();
            
            
            $assessorapplicationMail = [
                'title' =>'Application sent by admin, You Have Received a Application from Admin Successfully!!!!',
                'body' => '',
                'type' => 'Assigned By Admin to Assessor'
                ];
            //dd($asses_email);
            Mail::to($assessor_email)->send(new assessorapplicationmail($assessorapplicationMail,$application_id,$username));
            //Mail sending script ends here
            }
            

    }

    return  back()->with('sussess','Application has been successfully assigned to assessor');

  }
}

  public function assigan_secretariat_application(Request $request)
    {
      //  dd("yesssd");
    //return $request->all();   
    $value= DB::table('secretariat')->where('application_id','=',$request->application_id)->get();
    if(count($value) > 0)
    {
            $data= DB::table('asessor_applications')->where('application_id','=',$request->application_id);
            if($data == false)
            {
                $assessor_id=$request->assessor_id;

                for($i=0; $i<count($assessor_id); $i++){

                    $data = new asessor_application();
                    $data->assessor_id=$request->assessor_id[$i];
                    $data->application_id=$request->application_id;
                    $data->status=1;
                    $data->assessment_type=$request->assessment_type;
                    $data->due_date=$due_date = Carbon::now()->addDay(15);
                    $data->save();
                }
                return  back()->with('sussess','Application has been successfully assigned to Secretariat');
            }
            else{
                return  back()->with('error',' This application has already been assigned to this Secretariat ');

            }
    }
    else{
   $secretariat_id=$request->secretariat_id;
   //$secretariat_email=$request->sec_email;

   //return $request->sec_email;

    for($i=0; $i<count($secretariat_id); $i++){

        $data = new SecretariatApplication();
        $data->secretariat_id=$request->secretariat_id[$i];
        $data->application_id=$request->application_id;
        $data->status=1;
        $data->secretariat_type=$request->assessment_type;
        $data->due_date=$due_date = Carbon::now()->addDay(15);
        $data->save();

            //mail send
            $userEmail = 'superadmin@yopmail.com';
            $adminEmail = $request->sec_email;

            //Mail sending scripts starts here
            $applicationsecretariatMail = [
            'title' =>'This Application is  Assigned to You by Admin  Successfully!!!!',
            'body' => ''
            ];
            $application_id=$request->application_id;
            $username=Auth::user()->firstname;

            Mail::to([$userEmail,$adminEmail])->send(new secretariatapplicationmail($applicationsecretariatMail,$application_id,$username));

            $adminapplicationsecretariatMail = [
            'title' =>'You have send this application to Assessor Successfully!!!!',
            'body' => $request->sec_email,
            ];

            Mail::to([$userEmail])->send(new secretariatadminapplicationmail($adminapplicationsecretariatMail,$application_id,$username));
            //Mail sending script ends here

        

       
    }

    
    return  back()->with('sussess','Application has been successfully assigned to Secretariat');

  }
}

   public  function internationl_index()
   {
    // SAARC Countries
    $collections= DB::table('applications')
            ->Where('applications.country', '=', 167)
            ->orWhere('applications.country', '=', 208)
            ->orWhere('applications.country', '=', 19)
            ->orWhere('applications.country', '=', 133)
            ->orWhere('applications.country', '=', 1)
            ->orderBy('applications.id', 'DESC')
            ->join('application_payments', 'application_payments.application_id', '=','applications.id')
            ->get();
    

    //rest of the would
    $collection= DB::table('applications')
            ->whereNot('applications.country', 167)
            ->whereNot('applications.country', 208)
            ->whereNot('applications.country', 19)
            ->whereNot('applications.country', 133)
            ->whereNot('applications.country', 1)
            ->whereNot('applications.country', 101)
            ->join('application_payments', 'application_payments.application_id', '=','applications.id')
            ->orderBy('applications.id', 'DESC')
            ->get();
   
     //dd($collection);   
    if(count($collections) || count( $collection))
    {
        $assessordata = user::where('role','3')->orderBy('id','DESC')->get();
        $secretariatdata = user::where('role','5')->orderBy('id','DESC')->get();
        return view('application.internation_page',['collection'=>$collection,'collections'=>$collections,'assesors'=>$assessordata,'secretariatdata'=>$secretariatdata]);
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
        $collection = DB::table('asessor_applications')
        ->join('applications', 'asessor_applications.application_id', '=', 'applications.id')
        ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
        ->where('asessor_applications.assessor_id','=',Auth::user()->id)
        ->where('applications.country','=',101)
        ->get();
            if(count($collection)){
            return view('application.accesser.national_accesser',['collection'=>$collection]);
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
    ->where('asessor_applications.assessor_id','=',Auth::user()->id)
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
    ->where('asessor_applications.assessor_id','=',Auth::user()->id)
    ->get();
   // dd($collection);
    if(count($collections) || count( $collection)){
        $assessordata = user::where('role','3')->orderBy('id','DESC')->get();
    return view('application.accesser.internation_accesser',['collections'=>$collections,'collection'=>$collection]);
   }
   return view('application.accesser.internation_accesser');
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
      //$applications=Application::where('country',$this->get_india_id())->where('status',$status)->get();
      $applications=DB::table('applications')->select('applications.*','countries.name as country_name','states.name as state_name','level_information.level_information as level_name')->join('states', 'applications.state', '=', 'states.id')->join('countries', 'applications.country', '=', 'countries.id')->join('level_information', 'applications.level_id', '=', 'level_information.id')->where('country',$this->get_india_id())->get();
      return $applications;
  }

  function get_application_saarc($status='0',$date1='0',$date2='0'){
      //0 pending, 1 approved, 2 processing
     // $applications=Application::whereIn('country',$this->get_saarc_ids())->where('status',$status)->get();
      $applications=DB::table('applications')->select('applications.*','countries.name as country_name','states.name as state_name','level_information.level_information as level_name')->join('states', 'applications.state', '=', 'states.id')->join('countries', 'applications.country', '=', 'countries.id')->join('level_information', 'applications.level_id', '=', 'level_information.id')->whereIn('country',$this->get_saarc_ids())->get();
      return $applications;
  }

  function get_application_world($status='0',$date1='0',$date2='0'){
      //0 pending, 1 approved, 2 processing
      $india_id=$this->get_india_id();
      $saarc_ids=$this->get_saarc_ids();
      array_push($saarc_ids,$india_id);
      //dd($saarc_ids);
     // $applications=Application::whereNotIn('country',$saarc_ids)->where('status',$status)->get();
     //$applications=Application::whereNotIn('country',$saarc_ids)->get();
     $applications=DB::table('applications')->select('applications.*','countries.name as country_name','states.name as state_name','level_information.level_information as level_name')->join('states', 'applications.state', '=', 'states.id')->join('countries', 'applications.country', '=', 'countries.id')->join('level_information', 'applications.level_id', '=', 'level_information.id')->whereNotIn('country',$saarc_ids)->get();

      return $applications;
  }

  public function nationl_page()
   {
         //dd("yes");
        $Application = DB::table('applications')
        ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
        ->where('applications.country','=',101)
        ->orderBy('applications.id', 'DESC')
        ->get();
        
        if(count($Application))
        {

            $assessordata = user::where('role','3')->orderBy('id','DESC')->get();

            $secretariatdata = user::where('role','5')->orderBy('id','DESC')->get();

           // return $secretariatdata;
             //code for event date

             $begin = Carbon::now();
             $end = Carbon::now()->addDays(15);
            /* $begin = new DateTime('2023-07-19');
             $end = new DateTime('2023-07-30');*/


            
            $fifteenthDaysadd = Carbon::now()->addDays(15)->format('Y-m-d');
            $events=Event::select('start')->where('asesrar_id',76)->whereDate('start','<=',$fifteenthDaysadd)->where('availability',2)->get();
             //return count($events);
             //dd($events);
              //return  $events;

            return view('application.national',['collection'=>$Application,'assesors'=>$assessordata,'secretariatdata'=>$secretariatdata]);
        }
        return view('application.national');
   }
}
