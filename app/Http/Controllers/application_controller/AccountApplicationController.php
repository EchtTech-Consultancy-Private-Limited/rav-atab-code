<?php

namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class AccountApplicationController extends Controller
{
    public function __construct()
    {

    }
     
    /** Application List For Account */
    public function getApplicationList(){

        $application = DB::table('tbl_application as a')
        ->get();
        foreach($application as $app){
            $obj = new \stdClass;
            $obj->application_list= $app;
    
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $app->id,
                ])->count();
                if($course){
                    $obj->course_count = $course;
                }
                
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                ])->latest('created_at')->first();
                $payment_amount = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                ])->sum('amount');
                $payment_count = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                ])->count();
                if($payment){
                    $obj->payment = $payment;
                    $obj->payment->payment_count = $payment_count;
                    $obj->payment->payment_amount = $payment_amount ;
                }
                $final_data[] = $obj;
                
        }
        
        return view('account-view.application-list',['list'=>$final_data]);
    }

    /** Whole Application View for Account */
    public function getApplicationView($id){
        $application = DB::table('tbl_application')
        ->where('id', dDecrypt($id))
        ->first();
       
        $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        
        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->latest('id')->first();
            $obj = new \stdClass;
            $obj->application= $application;
    
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $application->id,
                ])->get();
                if($course){
                    $obj->course = $course;
                }
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                ])->get();
                if($payment){
                    $obj->payment = $payment;
                }
                $final_data = $obj;
        return view('account-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status]);
    }
}

