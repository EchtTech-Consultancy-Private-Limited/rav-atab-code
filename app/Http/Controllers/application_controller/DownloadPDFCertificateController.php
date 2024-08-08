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
    public function downloadPDFCertificate($application_id) {
        
        $app_details = DB::table('tbl_certificate as certificate')
                    ->select('certificate.*','certificate.valid_till',
                    'users.address','users.postal',
                    'users.firstname','users.middlename','users.lastname','users.role', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')
                    ->leftJoin('users', 'certificate.user_id', '=', 'users.id')
                    ->leftJoin('countries', 'users.country', '=', 'countries.id')
                    ->leftJoin('cities', 'users.city', '=', 'cities.id')
                    ->leftJoin('states', 'users.state', '=', 'states.id')
                    ->where('certificate.application_id', $application_id)
                    ->first();

        // dd($app_details);
        // $pdf = PDF::loadView('certificate.certificate',compact('app_details'));
        // $file_name = 'training-provider-'.$app_details->certificate_no.'.pdf';
        return view('certificate.aiia_scope_certificate');
        // dd($pdf);
        // return $pdf->download($file_name);
    }
}
