<?php

namespace App\Http\Controllers\application_controller;
use App\Http\Controller;

class DesktopApplicationController extends Controller
{
    public function __construct()
    {

    }
    
    public function getApplicationList(){

        $application = DB::table('tbl_application')->get();
        if(!empty($application)){
            $data = $application;
        }else{
            $data = '';
        }
        //dd($data);
        return view('desktop-view',['list'=>$data]);
    }
}

