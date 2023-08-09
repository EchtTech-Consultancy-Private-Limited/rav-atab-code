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
       if(Auth::user()->role==1)
       {
        $applications = Application::all();
       }
       elseif(Auth::user()->role==2)
       {
        $applications = Application::where('user_id',Auth::user()->id)->get();
       }
       return view('upgrade-level.previous-level',compact('applications'));
    }

   
}
