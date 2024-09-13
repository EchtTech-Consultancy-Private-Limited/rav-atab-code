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
        $application_id  = dDecrypt($application_id);
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

        $pdf = PDF::loadView('certificate.certificate',compact('app_details'));
        $file_name = 'training-provider-certificate-'.$app_details->certificate_no.'.pdf';
        return $pdf->download($file_name);
    }

    public function downloadPDFAIIAScopeCertificate($application_id) {
        $application_id  = dDecrypt($application_id);
        $app_details = DB::table('tbl_certificate as certificate')
                    ->select('certificate.*','certificate.valid_till',
                    'users.address','users.postal',
                    'users.firstname','users.middlename','users.lastname','users.role', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')
                    ->leftJoin('users', 'certificate.user_id', '=', 'users.id')
                    ->leftJoin('countries', 'users.country', '=', 'countries.id')
                    ->leftJoin('cities', 'users.city', '=', 'cities.id')
                    ->leftJoin('states', 'users.state', '=', 'states.id')
                    ->first();
        $courses = DB::table('tbl_application_courses')
                ->where('application_id',$application_id)
                ->whereNull('deleted_at')
                ->get();

        $pdf = PDF::loadView('certificate.aiia_scope_certificate',compact('app_details','courses')) ->setPaper('A4', 'portrait');;
        $file_name = 'training-provider-certificate-'.$app_details->certificate_no.'.pdf';
        // return view('certificate.aiia_scope_certificate');
        // dd($pdf);
        return $pdf->download($file_name);
    }
}
