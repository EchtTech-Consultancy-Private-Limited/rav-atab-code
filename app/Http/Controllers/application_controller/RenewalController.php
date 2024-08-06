<?php
namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth, DB;

class RenewalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){
        return view('renewal-view.create-application');
    }
    public function renewalCreate(Request $request){
        
    }
}
