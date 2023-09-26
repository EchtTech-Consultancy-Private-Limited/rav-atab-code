<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\Application;
use App\Models\ApplicationLevel2;

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

    public function upgrade_level(Request $request)
    {
         $input = $request->all();


         $applications_id = $request->application_id_upgrade;
         $level1=Application::where('id',$applications_id)->first();

         $level2_application_id=$applications_id+1;
         //$level2_application_id='';
         $level2_check_record=ApplicationLevel2::where('level2_application_id',$level2_application_id)->first();
         if(empty($level2_check_record))
         {
             $level2 = new ApplicationLevel2;
             $level2->level_id=$level1->level_id+1;
             $level2->user_id=$level1->user_id;
             $level2->Person_Name=$level1->Person_Name;
             $level2->Contact_Number=$level1->Contact_Number;
             $level2->Email_ID=$level1->Email_ID;
             $level2->country=$level1->country;
             $level2->state=$level1->state;
             $level2->city=$level1->city;
             $level2->ip=$level1->ip;
             $level2->status=$level1->status;
             $level2->designation=$level1->designation;
             $level2->level1_application_id=$applications_id;
             $level2->level2_application_id=$applications_id+1;
             $level2->save();
             return  redirect('level-first-upgrade/'.$level2_application_id.'/'.$applications_id)->with('success','Course  successfully  Added!!!!');
         }
         else
         {
            return back();
            dd("you already in upgraded");

         }

         return  redirect('level-first')->with('success','Course  successfully  Added!!!!');



    }


}
