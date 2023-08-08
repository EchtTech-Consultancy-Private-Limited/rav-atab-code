<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Application;

class UpgradeLevelController extends Controller
{
    public function show_previous_level()
    {   

       $date = Application::where('id',128)->first();
       $applications = Application::where('user_id',Auth::user()->id)->get();
       
        $one_year_future_date=$date->created_at->addDays(365)->subDays(15)->format('Y-m-d');
       //return $one_year_future_date = Carbon::now()->addDays(365)->format('Y-m-d');

      //return   $tets_applications = Application::where('user_id',Auth::user()->id)->where('created_at' , '>',$date->created_at->addDays(365)->subDays(15)->format('Y-m-d'))->get();

       // return   $users = Application::where( 'created_at', '>', Carbon::now()->subDays(2))->get();
       //return $users1=$users[0]->created_at->format('Y-m-d');
       return view('upgrade-level.previous-level',compact('applications'));
    }
}
