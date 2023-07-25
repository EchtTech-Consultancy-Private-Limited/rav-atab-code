<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Level;
use App\Models\LevelRule;
use App\Models\Application;
use App\Models\ApplicationCourse;
use App\Models\ApplicationPayment;
use App\Models\ApplicationAcknowledgement;
use App\Models\ApplicationDocument;
use App\Models\DocumentType;
use App\Models\ApplicationReport;
use App\Models\asessor_application;
use App\Models\User;
use DB;
use Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

class applicationController extends Controller
{


public function show_pdf($name)
{
    $data= $name;
    return view('showfile',['data'=>$data]);

}

    public function Assigan_application(Request $request)
    {

        $assessor_id=$request->assessor_id;

        for($i=0; $i<count($assessor_id); $i++){

            $data = new asessor_application();
            $data->assessor_id=$request->assessor_id[$i];
            $data->application_id=$request->application_id;
            $data->status=$request->status;
            $data->due_date=$due_date = Carbon::now()->addDay(15);
            $data->save();
        }
        return  back()->with('sussess','Application has been successfully assigned to assessor');

    }

   public  function internationl_index()
   {

    $Country=Country::get();
    $collection=ApplicationPayment::where('country' ,167)->orWhere( 'country',208)->orWhere( 'country',19)->orWhere( 'country',1)->orWhere( 'country',133)->get();
    $collection1=ApplicationPayment::whereNotIn('country',[167,208,19,1,133,101])->get();
    return view('application.internation_page',['collection'=>$collection,'collection1'=>$collection1]);
   }

   public function nationl_page()
   {
        $Country=Country::get();
        $Application=Application::where('country',101)->get();
       // dd($Application);
        $collection=ApplicationPayment::where('application_id',$Application[0]->id)->get();
        $ApplicationDocument=ApplicationDocument::where('application_id',$Application[0]->id)->get();
        $ApplicationCourse=ApplicationCourse::where('application_id',$Application[0]->id)->get();

        $assessordata = user::where('role','3')->orderBy('id','DESC')->get();
        $checkbox = asessor_application::get();

        return view('application.national',['checkbox'=>$checkbox,'collection'=>$collection,'Application'=>$Application,'assesors'=>$assessordata]);
   }


   public function nationl_accesser()
   {
    $Country=Country::get();
    $checkbox = asessor_application::get();

          //dd($checkbox[0]->application_id);

    $Application=Application::where('country',101)->where('id','=',$checkbox[0]->application_id)->get();

    $collection=ApplicationPayment::whereapplication_id($Application[0]->id)->get();

    $assessor_id = $checkbox[0]->assessor_id;
    //dd($collection);

    return view('application.accesser.national_accesser',['collection'=>$collection,'assessor_id'=>$assessor_id]);
   }

   public function internationl_accesser()
   {

    $Country=Country::get();
    $collection=ApplicationPayment::where('country' ,167)->orWhere( 'country',208)->orWhere( 'country',19)->orWhere( 'country',1)->orWhere( 'country',133)->get();
    $collection1=ApplicationPayment::whereNotIn('country',[167,208,19,1,133,101])->get();
    return view('application.accesser.internation_accesser',['collection'=>$collection,'collection1'=>$collection1]);
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
}
