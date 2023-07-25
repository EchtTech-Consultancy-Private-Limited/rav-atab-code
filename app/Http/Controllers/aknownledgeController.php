<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class aknownledgeController extends Controller
{
   public  function index()
   {
    return view('acknow-letter.acknowledge-letter');
   }
}
