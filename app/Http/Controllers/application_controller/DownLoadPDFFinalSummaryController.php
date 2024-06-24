<?php

namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;


class DownLoadPDFFinalSummaryController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth')->except('logout');
    }

    public function downloadFinalSummaryOnsiteAssessor() {

        $data = [
            [
                'quantity' => 1,
                'description' => '1 Year Subscription',
                'price' => '129.00'
            ]
        ];
     
        $pdf = Pdf::loadView('onsite-view.download-finalsummary', ['data' => $data]);
     
        return $pdf->download();
    }
}
