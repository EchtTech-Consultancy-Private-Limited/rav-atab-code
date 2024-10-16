<?php

namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\Level;
use App\Models\LevelRule;
use App\Models\Application;
use App\Models\ApplicationCourse;
use App\Models\ApplicationPayment;
use App\Models\ApplicationAcknowledgement;
use App\Models\ApplicationDocument;
use App\Models\DocumentType;
use App\Models\grievance;
use App\Models\emaildomeins;
use App\Models\ApplicationReport;
use App\mail\Grienvance_tp;
use App\Models\User;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;
use Auth;
use Redirect;

class DashboardController extends Controller
{

   public function email_verification()
   {

    $email=emaildomeins::get();
    return view('email.email-domain',['email'=>$email]);
   }

    public function email_verifications(Request $request)
    {



        $data = new emaildomeins;
        $data->emaildomain = $request->emaildomain;
        $data->save();
        return back()->with('success', 'Email Domin Successfully Added!!!!');;

    }

    public function  email_domoin_delete($id)
    {
        $data =emaildomeins:: find($id);
        $data->delete();
        return back()->with('fail', 'Email Domin Successfully Delete !!!!');;

    }






    public function index(Request $request)
    {
      
        $total_pending_national = DB::table('tbl_application')->where(['payment_status'=>0,'region'=>'ind'])->whereNotIn('status',[1,3])->count();
        $total_active_national = DB::table('tbl_application')->where(['payment_status'=>5,'region'=>'ind'])->whereNotIn('status',[1,3])->count();
        $total_pending_international = DB::table('tbl_application')->where(['payment_status'=>0,'region'=>['saarc','other']])->whereNotIn('status',[1,3])->count();
        $total_active_international = DB::table('tbl_application')->where(['payment_status'=>5,'region'=>['saarc','other']])->whereNotIn('status',[1,3])->count();

        // for admin
        if(Auth::user()->role == 1){
            $arr = [
                'type' => 'tp',
                'graph_count' => 6,
                'data' => [
                    "Level-1" => [
                        'India' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'SAARC' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'Rest of the World' => ["pending" => 0, "processing" => 0, "approved" => 0]
                    ],
                    "Level-2" => [
                        'India' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'SAARC' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'Rest of the World' => ["pending" => 0, "processing" => 0, "approved" => 0]
                    ],
                    "Level-3" => [
                        'India' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'SAARC' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'Rest of the World' => ["pending" => 0, "processing" => 0, "approved" => 0]
                    ]
                ]
            ];
        
            $regionMapping = [
                'ind' => 'India',
                'saarc' => 'SAARC',
                'other' => 'Rest of the World'
            ];
        
            $pendingCounts = DB::table('tbl_application')
                ->select('level_id', 'region', DB::raw('COUNT(*) as pending_count'))
                ->where('payment_status', 0)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id', 'region')
                ->orderBy('level_id')
                ->get();
        
            $processingCounts = DB::table('tbl_application')
                ->select('level_id', 'region', DB::raw('COUNT(*) as processing_count'))
                ->where('payment_status', 5)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id', 'region')
                ->orderBy('level_id')
                ->get();
        
            $approvedCounts = DB::table('tbl_application')
                ->select('level_id', 'region', DB::raw('COUNT(*) as approved_count'))
                ->where('approve_status', 1)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id', 'region')
                ->orderBy('level_id')
                ->get();
        
            foreach ($pendingCounts as $row) {
                $region = $regionMapping[strtolower($row->region)] ?? $row->region;
                if (isset($arr['data']['Level-' . $row->level_id][$region])) {
                    $arr['data']['Level-' . $row->level_id][$region]['pending'] = $row->pending_count;
                }
            }
            foreach ($processingCounts as $row) {
                $region = $regionMapping[strtolower($row->region)] ?? $row->region;
                if (isset($arr['data']['Level-' . $row->level_id][$region])) {
                    $arr['data']['Level-' . $row->level_id][$region]['processing'] = $row->processing_count;
                }
            }
            foreach ($approvedCounts as $row) {
                $region = $regionMapping[strtolower($row->region)] ?? $row->region;
                if (isset($arr['data']['Level-' . $row->level_id][$region])) {
                    $arr['data']['Level-' . $row->level_id][$region]['approved'] = $row->approved_count;
                }
            }
        
            // Prepare the data in the Highcharts format
            $chartData = [];
            foreach (['pending', 'processing', 'approved'] as $type) {
                foreach ($arr['data'] as $level => $regions) {
                    $data = [];
                    foreach ($regions as $region => $counts) {
                        if (isset($counts[$type])) {
                            $data[] = [$region, $counts[$type]];
                        }
                    }
                    $chartData[] = [
                        'name' => ucfirst($type) . ' Applications - ' . $level,
                        'data' => $data
                    ];
                }
            }
        
        }

        // tp dashboard
        if (Auth::user()->role == 2) {
            $user_id = Auth::user()->id;
            $arr = [
                'data' => [
                    'Level-1' => ["pending" => 0, "processing" => 0, "approved" => 0],
                    'Level-2' => ["pending" => 0, "processing" => 0, "approved" => 0],
                    'Level-3' => ["pending" => 0, "processing" => 0, "approved" => 0]
                ]
            ];
        
            $pendingCounts = DB::table('tbl_application')
                ->select('level_id', DB::raw('COUNT(*) as pending_count'))
                ->where('payment_status', 0)
                ->where('tp_id', $user_id)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id')
                ->orderBy('level_id')
                ->get();
        
            $processingCounts = DB::table('tbl_application')
                ->select('level_id', DB::raw('COUNT(*) as processing_count'))
                ->where('payment_status', 5)
                ->where('tp_id', $user_id)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id')
                ->orderBy('level_id')
                ->get();
        
            $approvedCounts = DB::table('tbl_application')
                ->select('level_id', DB::raw('COUNT(*) as approved_count'))
                ->where('approve_status', 1)
                ->where('tp_id', $user_id)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id')
                ->orderBy('level_id')
                ->get();
        
            foreach($pendingCounts as $row){
                $arr['data']['Level-'.$row->level_id]['pending'] = $row->pending_count;
            }
            foreach($processingCounts as $row){
                $arr['data']['Level-'.$row->level_id]['processing'] = $row->processing_count;
            }
            foreach($approvedCounts as $row){
                $arr['data']['Level-'.$row->level_id]['approved'] = $row->approved_count;
            }
        
            // Prepare the data in the Highcharts format
            $chartData = [
                [
                    'name' => 'Pending Applications',
                    'data' => [
                        ['Level-1', $arr['data']['Level-1']['pending']],
                        ['Level-2', $arr['data']['Level-2']['pending']],
                        ['Level-3', 3]
                    ]
                ],
                [
                    'name' => 'Processing Applications',
                    'data' => [
                        ['Level-1', $arr['data']['Level-1']['processing']],
                        ['Level-2', $arr['data']['Level-2']['processing']],
                        ['Level-3', $arr['data']['Level-3']['processing']]
                    ]
                ],
                [
                    'name' => 'Approved Applications',
                    'data' => [
                        ['Level-1', $arr['data']['Level-1']['approved']],
                        ['Level-2', $arr['data']['Level-2']['approved']],
                        ['Level-3', $arr['data']['Level-3']['approved']]
                    ]
                ]
            ];
        
        
        }

        // assessor
        
        if(Auth::user()->role == 3){
            $user_id = Auth::user()->id;
            $assessment = Auth::user()->assessment==1?"desktop":"onsite";
            $arr = [
                'data' => [
                    'India' => ["pending" => 0, "processing" => 0, "approved" => 0],
                    'SAARC' => ["pending" => 0, "processing" => 0, "approved" => 0],
                    'Rest of the World' => ["pending" => 0, "processing" => 0, "approved" => 0]
                ]
            ];
            
            // Mapping from database region values to array keys
            $regionMapping = [
                'ind' => 'India',
                'SAARC' => 'SAARC',
                'Rest of the World' => 'Rest of the World'
            ];
            
            $query = DB::table('tbl_application');
            $query->select('region', DB::raw('COUNT(*) as pending_count'));
            $query->where('payment_status', 0);
            $query->where('level_id', 3);
            // $assessment=="desktop"?$query->where('is_desktop_take_action', 0):$query->where('is_onsite_take_action', 0);
            $query->where('assessor_id', $user_id);
            $query->groupBy('region');
            $query->orderBy('region');
            $pendingCounts =$query->get();
            
            $query = DB::table('tbl_application');
            $query->select('region', DB::raw('COUNT(*) as processing_count'));
            $query->where('payment_status', 5);
            $query->where('level_id', 3);
            $query->where('assessor_id', $user_id);
            // $assessment=="desktop"?$query->where('is_desktop_take_action', 0):$query->where('is_onsite_take_action', 0);
            $query->groupBy('region');
            $query->orderBy('region');
            $processingCounts =$query->get();
            
            $approvedCounts = DB::table('tbl_application');
            $query->select('region', DB::raw('COUNT(*) as approved_count'));
            $query->where('approve_status', 1);
            $query->where('level_id', 3);
            $query->where('assessor_id', $user_id);
            // $assessment=="desktop"?$query->where('is_desktop_take_action', 0):$query->where('is_onsite_take_action', 0);
            $query->groupBy('region');
            $query->orderBy('region');
            $approvedCounts =$query->get();
            
            foreach($pendingCounts as $row){
                $region = $regionMapping[$row->region];
                $arr['data'][$region]['pending'] = $row->pending_count;
            }
            foreach($processingCounts as $row){
                $region = $regionMapping[$row->region];
                $arr['data'][$region]['processing'] = $row->processing_count;
            }
            foreach($approvedCounts as $row){
                $region = $regionMapping[$row->region];
                $arr['data'][$region]['approved'] = $row->approved_count;
            }
            
            // Prepare the data in the Highcharts format
            $chartData = [
                [
                    'name' => 'Pending Applications',
                    'data' => [
                        ['India', $arr['data']['India']['pending']],
                        ['SAARC', $arr['data']['SAARC']['pending']],
                        ['Rest of the World', $arr['data']['Rest of the World']['pending']]
                    ]
                ],
                [
                    'name' => 'Processing Applications',
                    'data' => [
                        ['India', $arr['data']['India']['processing']],
                        ['SAARC', $arr['data']['SAARC']['processing']],
                        ['Rest of the World', $arr['data']['Rest of the World']['processing']]
                    ]
                ],
                [
                    'name' => 'Approved Applications',
                    'data' => [
                        ['India', $arr['data']['India']['approved']],
                        ['SAARC', $arr['data']['SAARC']['approved']],
                        ['Rest of the World', $arr['data']['Rest of the World']['approved']]
                    ]
                ]
            ];
        }
        
        // account detail
        if(Auth::user()->role == 6){
            $arr = [
                'type' => 'tp',
                'graph_count' => 6,
                'data' => [
                    "Level-1" => [
                        'India' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'SAARC' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'Rest of the World' => ["pending" => 0, "processing" => 0, "approved" => 0]
                    ],
                    "Level-2" => [
                        'India' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'SAARC' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'Rest of the World' => ["pending" => 0, "processing" => 0, "approved" => 0]
                    ],
                    "Level-3" => [
                        'India' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'SAARC' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'Rest of the World' => ["pending" => 0, "processing" => 0, "approved" => 0]
                    ]
                ]
            ];
        
            // Map regions from the database to the predefined array keys
            $regionMapping = [
                'ind' => 'India',
                'saarc' => 'SAARC',
                'other' => 'Rest of the World'
            ];
        
            $pendingCounts = DB::table('tbl_application')
                ->select('level_id', 'region', DB::raw('COUNT(*) as pending_count'))
                ->where('payment_status', 0)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id', 'region')
                ->orderBy('level_id')
                ->get();
        
            $processingCounts = DB::table('tbl_application')
                ->select('level_id', 'region', DB::raw('COUNT(*) as processing_count'))
                ->where('payment_status', 5)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id', 'region')
                ->orderBy('level_id')
                ->get();
        
            $approvedCounts = DB::table('tbl_application')
                ->select('level_id', 'region', DB::raw('COUNT(*) as approved_count'))
                ->where('approve_status', 1)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id', 'region')
                ->orderBy('level_id')
                ->get();
        
            foreach ($pendingCounts as $row) {
                $region = $regionMapping[strtolower($row->region)] ?? $row->region;
                if (isset($arr['data']['Level-' . $row->level_id][$region])) {
                    $arr['data']['Level-' . $row->level_id][$region]['pending'] = $row->pending_count;
                }
            }
            foreach ($processingCounts as $row) {
                $region = $regionMapping[strtolower($row->region)] ?? $row->region;
                if (isset($arr['data']['Level-' . $row->level_id][$region])) {
                    $arr['data']['Level-' . $row->level_id][$region]['processing'] = $row->processing_count;
                }
            }
            foreach ($approvedCounts as $row) {
                $region = $regionMapping[strtolower($row->region)] ?? $row->region;
                if (isset($arr['data']['Level-' . $row->level_id][$region])) {
                    $arr['data']['Level-' . $row->level_id][$region]['approved'] = $row->approved_count;
                }
            }
        
            // Prepare the data in the Highcharts format
            $chartData = [];
            foreach (['pending', 'processing', 'approved'] as $type) {
                foreach ($arr['data'] as $level => $regions) {
                    $data = [];
                    foreach ($regions as $region => $counts) {
                        if (isset($counts[$type])) {
                            $data[] = [$region, $counts[$type]];
                        }
                    }
                    $chartData[] = [
                        'name' => ucfirst($type) . ' Applications - ' . $level,
                        'data' => $data
                    ];
                }
            }
        }

        // secretaritat detail
        if(Auth::user()->role == 5){
            $secretariat_id = Auth::user()->id;
            $arr = [
                'data' => [
                    "Level-1" => [
                        'India' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'SAARC' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'Rest of the World' => ["pending" => 0, "processing" => 0, "approved" => 0]
                    ],
                    "Level-2" => [
                        'India' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'SAARC' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'Rest of the World' => ["pending" => 0, "processing" => 0, "approved" => 0]
                    ],
                    "Level-3" => [
                        'India' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'SAARC' => ["pending" => 0, "processing" => 0, "approved" => 0],
                        'Rest of the World' => ["pending" => 0, "processing" => 0, "approved" => 0]
                    ]
                ]
            ];
        
            // Map regions from the database to the predefined array keys
            $regionMapping = [
                'ind' => 'India',
                'saarc' => 'SAARC',
                'other' => 'Rest of the World'
            ];
        
            $pendingCounts = DB::table('tbl_application')
                ->select('level_id', 'region', DB::raw('COUNT(*) as pending_count'))
                ->where('payment_status', 0)
                // ->where('secretariat_id', $secretariat_id)
                // ->where('is_secretariat_take_action', 0)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id', 'region')
                ->orderBy('level_id')
                ->get();
        
            $processingCounts = DB::table('tbl_application')
                ->select('level_id', 'region', DB::raw('COUNT(*) as processing_count'))
                ->where('payment_status', 5)
                // ->where('secretariat_id', $secretariat_id)
                // ->where('is_secretariat_take_action', 1)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id', 'region')
                ->orderBy('level_id')
                ->get();
        
            $approvedCounts = DB::table('tbl_application')
                ->select('level_id', 'region', DB::raw('COUNT(*) as approved_count'))
                ->where('approve_status', 1)
                // ->where('secretariat_id', $secretariat_id)
                // ->where('is_secretariat_take_action', 1)
                ->whereIn('level_id', [1, 2, 3])
                ->groupBy('level_id', 'region')
                ->orderBy('level_id')
                ->get();
        
            foreach ($pendingCounts as $row) {
                $region = $regionMapping[strtolower($row->region)] ?? $row->region;
                if (isset($arr['data']['Level-' . $row->level_id][$region])) {
                    $arr['data']['Level-' . $row->level_id][$region]['pending'] = $row->pending_count;
                }
            }
            foreach ($processingCounts as $row) {
                $region = $regionMapping[strtolower($row->region)] ?? $row->region;
                if (isset($arr['data']['Level-' . $row->level_id][$region])) {
                    $arr['data']['Level-' . $row->level_id][$region]['processing'] = $row->processing_count;
                }
            }
            foreach ($approvedCounts as $row) {
                $region = $regionMapping[strtolower($row->region)] ?? $row->region;
                if (isset($arr['data']['Level-' . $row->level_id][$region])) {
                    $arr['data']['Level-' . $row->level_id][$region]['approved'] = $row->approved_count;
                }
            }
        
            // Prepare the data in the Highcharts format
            $chartData = [];
            foreach (['pending', 'processing', 'approved'] as $type) {
                foreach ($arr['data'] as $level => $regions) {
                    $data = [];
                    foreach ($regions as $region => $counts) {
                        if (isset($counts[$type])) {
                            $data[] = [$region, $counts[$type]];
                        }
                    }
                    $chartData[] = [
                        'name' => ucfirst($type) . ' Applications - ' . $level,
                        'data' => $data
                    ];
                }
            }
        }

        return view("pages.dashboard",['chartData'=>$chartData,'total_pending_national'=>$total_pending_national,'total_active_national'=>$total_active_national,'total_pending_international'=>$total_pending_international,'total_active_international'=>$total_active_international]);
    }

    function get_india_id(){
        $india=Country::where('name','India')->get('id')->first();
       return $india->id;
    }

    function get_saarc_ids(){
        //Afghanistan, Bangladesh, Bhutan, India, Maldives, Nepal, Pakistan and Sri-Lanka
        $saarc=Country::whereIn('name',Array('Afghanistan', 'Bangladesh', 'Bhutan', 'Maldives', 'Nepal', 'Pakistan', 'Sri Lanka'))->get('id');
        $saarc_ids=Array();
        foreach($saarc as $val)$saarc_ids[]=$val->id;
        return $saarc_ids;
    }

    function get_application_india($status='0',$date1='0',$date2='0'){
        //0 pending, 1 approved, 2 processing
        $applications=Application::where('country',$this->get_india_id())->where('status',$status)->get('id');
        $total=$applications->count();
        return $total;
    }

    function get_application_saarc($status='0',$date1='0',$date2='0'){
        //0 pending, 1 approved, 2 processing
        $applications=Application::whereIn('country',$this->get_saarc_ids())->where('status',$status)->get('id');
        $total=$applications->count();
        return $total;
    }

    function get_application_world($status='0',$date1='0',$date2='0'){
        //0 pending, 1 approved, 2 processing
        $india_id=$this->get_india_id();
        $saarc_ids=$this->get_saarc_ids();
        array_push($saarc_ids,$india_id);
        //dd($saarc_ids);
        $applications=Application::whereNotIn('country',$saarc_ids)->where('status',$status)->get('id');
        $total=$applications->count();
        return $total;
    }

    function get_users_count($status='0'){
        //0 pending, 1 approved, 2 processing
        $applications=User::whereIn('country',$this->get_saarc_ids())->where('status',$status)->get('id');
        $total=$applications->count();
        return $total;
    }


   

    public function Grievance()
    {
        return view('level.Grievance');
    }

    public function Grievance_list()
    {
        if(Auth::user()->role == '1')
        {
        $data=grievance::get();
      //  dd($data);
        }else
        {
        $data=grievance::wheresend_email(Auth::user()->email)->get();
       // dd($data);
        }

        return view('level.addGrievance',['data'=>$data]);
    }

    public function active_Grievance($id)
    {
        $user=grievance::find($id);
        $user->status=($user->status==1?'0':'1');
        $user->update();
        return Redirect::back()->with('success', 'Status Changed Successfully');
    }


    public function view_Grievance($id)
    {
        $user=grievance::find($id);
        $data=grievance::whereid($id)->get();
        return  view('level.grievance-view',['data'=>$data]);


    }


    public function Add_Grievance(Request $request)
    {
       //dd($request);
        $request->validate(
            [
            'details' =>'required',
            'subject'=>'required'
            ]
        );
         // dd($request->all());
            $data= new grievance;
            $data->subject = $request->subject;
            $data->details = $request->details;
            $data->status =  '0';
            $data->send_email=Auth::user()->email;

            $details = [
                'title' => $data->subject,
                'body' => $request->details
            ];

            \Mail::to(Auth::user()->email)->send(new \App\Mail\Grienvance_tp($details));


//second mail function

    $details = [
        'title' => $data->subject,
        'body' => $request->details
    ];

    \Mail::to('monu@yopmail.com')->send(new \App\Mail\Grienvance_admin($details));

    // dd("Email is Sent.");

    $data->save();
    return redirect('/Grievance-list')->with('success', 'grievance Mail send successfull!! ');
    }
}
