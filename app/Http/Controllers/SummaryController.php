<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    public function desktopIndex(Request $request){
        return view('assessor-summary.desktop-view-summary');
    }

    public function onSiteIndex(Request $request){
        return view('assessor-summary.on-site-view-summary');
    }

    public function desktopSubmitSummary(Request $request){
        return view('assessor-summary.desktop-submit-summary');
    }

    public function onSiteSubmitSummary(Request $request){
        return view('assessor-summary.on-site-submit-summary');
    }
}
