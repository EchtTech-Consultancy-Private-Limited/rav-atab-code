<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SecretariatApplication;
use App\Models\User;
use DB;
use Auth;
use Carbon\Carbon;

class SecretariatController extends Controller
{
    public function nationl_secretariat()
   {

        /*$collection = DB::table('asessor_applications')
        ->join('applications', 'asessor_applications.application_id', '=', 'applications.id')
        ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
        ->where('asessor_applications.assessor_id','=',Auth::user()->id)
        ->where('applications.country','=',101)
        ->get();*/

        $collection = DB::table('secretariat')
        ->join('applications', 'secretariat.application_id', '=', 'applications.id')
        ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
        ->where('secretariat.secretariat_id','=',Auth::user()->id)
        ->where('applications.country','=',101)
        ->get();

        //return $collection;
            if(count($collection)){
            return view('secretariat.national',['collection'=>$collection]);
            }
        return view('secretariat.national');
   }


   public function internationl_secretariat()
   {
    //return Auth::user()->id;
   //dd("tes");
   // SAARC Countries
    $collections = DB::table('secretariat')
    ->Where('applications.country', '=', 167)
    ->orWhere('applications.country', '=', 208)
    ->orWhere('applications.country', '=', 19)
    ->orWhere('applications.country', '=', 133)
    ->orWhere('applications.country', '=', 1)
    ->join('applications', 'secretariat.application_id', '=', 'applications.id')
    ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
    ->where('secretariat.secretariat_id','=',Auth::user()->id)
    ->get();

    //dd("$collections");
    //rest of the would
    $collection = DB::table('secretariat')->whereNot('application_payments.country', 167)
    ->whereNot('application_payments.country', 208)
    ->whereNot('application_payments.country', 19)
    ->whereNot('application_payments.country', 133)
    ->whereNot('application_payments.country', 1)
    ->whereNot('application_payments.country', 101)
     ->join('applications', 'secretariat.application_id', '=', 'applications.id')
    ->join('application_payments', 'application_payments.application_id', '=', 'applications.id')
    ->where('secretariat.secretariat_id','=',Auth::user()->id)
    ->get();
  // dd($collection);
    if(count($collections) || count( $collection)){
        $assessordata = user::where('role','5')->orderBy('id','DESC')->get();
    return view('secretariat.international',['collections'=>$collections,'collection'=>$collection]);
   }
   return view('secretariat.international');
}
}
