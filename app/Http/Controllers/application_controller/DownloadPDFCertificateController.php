<?php

namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use App\Models\TblNCComments; 
use DB;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DownloadPDFCertificateController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth')->except('logout');
    }
    public function downloadPDFCertificate(PDF $application_id) {
        
        $pdf = PDF::loadView('certificate.certificate');
        // $file_name = 'onsite-'.$summertReport->uhid.'.pdf';
        // return view('certificate.certificate');
        // dd($pdf);
        return $pdf->download("text.pdf");
    }
}
