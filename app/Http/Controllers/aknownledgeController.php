<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcknowledgementRecord;
use Auth;
class aknownledgeController extends Controller
{
   public  function index()
   {
      $final_application=AcknowledgementRecord::where('acknowledgement_id',1)->where('user_id',Auth::user()->id)->get();
      return view('acknow-letter.acknowledge-letter',compact('final_application'));
   }
}
