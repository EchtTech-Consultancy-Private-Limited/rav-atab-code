<?php

namespace App\Http\Controllers\application_controller;
use App\Http\Controller;
use DB;


class AccountApplicationController extends Controller
{
    public function __construct()
    {

    }
     
    /** Application List For Account */
    public function getApplicationList(){

        $application = DB::table('tbl_application')->get();
        if(!empty($application)){
            $data = $application;
        }else{
            $data = '';
        }
        //dd($data);
        return view('account-view',['list'=>$data]);
    }

    /** Whole Application View for Account */
    public function applicationView(){

        $application = DB::table('tbl_application')->get();
        if(!empty($application)){
            $data = $application;
        }else{
            $data = '';
        }
        //dd($data);
        return view('account-view',['list'=>$data]);
    }
}

