<?php
namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Models\TblApplication; 
use App\Models\TblApplicationPayment; 
use App\Models\TblApplicationCourseDoc; 
use App\Models\AssessorApplication; 
use App\Models\asessor_application; 
use App\Models\Chapter; 
use App\Models\TblNCComments; 
use Carbon\Carbon;
use URL;
use App\Jobs\SendEmailJob;

use File;
class SuperAdminApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getApplicationList(){

        $application_time = DB::table('tbl_application_time')->where([
            'role_id' => 6,
            'user_action'=>'verify_payment'
        ])->first()->number_of_days;

        $NewDate=Date('y:m:d H:i:s', strtotime('+'.$application_time.' days'));
       //dd($NewDate);

        $application = DB::table('tbl_application as a')
        ->whereIn('a.payment_status',[2,3,5])
        ->Orwhere('a.second_payment',6)
        ->orderBy('a.id','desc')
        ->where('region','ind')
        ->get();
        // dd($application);
        $final_data=array();
        // $payment_count = DB::table("tbl_application_payment")->where('')
        
        
        
        $desktop_assessor_list = DB::table('users')->where(['assessment'=>1,'role'=>3,'status'=>0])->orderBy('id', 'DESC')->get();
        
        $onsite_assessor_list = DB::table('users')->where(['assessment'=>2,'role'=>3,'status'=>0])->orderBy('id', 'DESC')->get();
       
        $secretariatdata = DB::table('users')->where('role', '5')->orderBy('id', 'DESC')->get();
        foreach($application as $app){
            $obj = new \stdClass;
            $obj->application_list= $app;
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $app->id,
                ])
                ->whereNull('deleted_at') 
                ->count();
                if($course){
                    $obj->course_count = $course;
                }
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                    
                ])
                ->first();
                $last_payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                ])
                ->latest('id')
                ->first();

                $payment_amount = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                ])
                ->where('status',2)
                ->sum('amount');
                $payment_count = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                ])
                ->where('status',2)
                ->count();
                $app_history = DB::table('tbl_application_status_history')
                ->select('tbl_application_status_history.*','users.firstname','users.middlename','users.lastname','users.role')
                ->leftJoin('users', 'tbl_application_status_history.user_id', '=', 'users.id')
                ->where('tbl_application_status_history.application_id', $app->id)
                ->get();
                

                $doc_uploaded_count = DB::table('tbl_application_course_doc')->where(['application_id' => $app->id])->count();
                $obj->doc_uploaded_count = $doc_uploaded_count;
                
                $assessment_way = DB::table('asessor_applications')->where('application_id',$app->id)->first()->assessment_way??'';

                if($payment){
                    $obj->assessor_list = $payment_count>1 ?$onsite_assessor_list :$desktop_assessor_list;
                    $obj->assessor_type = $payment_count>1?"onsite":"desktop";
                    $obj->payment = $payment;
                    $obj->assessment_way = $assessment_way;
                    $obj->payment->payment_count = $payment_count;
                    $obj->payment->payment_amount = $payment_amount;
                    $obj->payment->last_payment = $last_payment;
                    $obj->appHistory= $app_history;
                    $obj->is_all_docs_uploaded = $this->checkAllDocsUploaded($app->id,$payment_count);
                }
                $final_data[] = $obj;
        }
        // dd($final_data);
        return view('superadmin-view.application-list',['list'=>$final_data,'secretariatdata' => $secretariatdata]);
    }

    public function getInternationApplicationList(Request $request){


        $application_time = DB::table('tbl_application_time')->where([
            'role_id' => 6,
            'user_action'=>'verify_payment'
        ])->first()->number_of_days;

        $NewDate=Date('y:m:d H:i:s', strtotime('+'.$application_time.' days'));
       //dd($NewDate);

       if($request->get('type')=='other-world'){
        $region_type = 'other';
    }else {
        $region_type = 'saarc';
    }

        $application = DB::table('tbl_application as a')
        ->whereIn('a.payment_status',[2,3,5])
        ->where('region',$region_type)
        ->Orwhere('a.second_payment',6)
        ->orderBy('a.id','desc')
        ->get();
        $final_data=array();
        
        $desktop_assessor_list = DB::table('users')->where(['assessment'=>1,'role'=>3,'status'=>0])->orderBy('id', 'DESC')->get();
        
        $onsite_assessor_list = DB::table('users')->where(['assessment'=>2,'role'=>3,'status'=>0])->orderBy('id', 'DESC')->get();
       
        $secretariatdata = DB::table('users')->where('role', '5')->orderBy('id', 'DESC')->get();
        foreach($application as $app){
            $obj = new \stdClass;
            $obj->application_list= $app;
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $app->id,
                ])
                ->whereNull('deleted_at') 
                ->count();
                if($course){
                    $obj->course_count = $course;
                }
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                    
                ])
                ->first();
                $last_payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                ])
                ->latest('id')
                ->first();

                $payment_amount = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                ])
                ->where('status',2)
                ->sum('amount');
                $payment_count = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                ])
                ->where('status',2)
                ->count();
                $app_history = DB::table('tbl_application_status_history')
                ->select('tbl_application_status_history.*','users.firstname','users.middlename','users.lastname','users.role')
                ->leftJoin('users', 'tbl_application_status_history.user_id', '=', 'users.id')
                ->where('tbl_application_status_history.application_id', $app->id)
                ->get();
                

                $doc_uploaded_count = DB::table('tbl_application_course_doc')->where(['application_id' => $app->id])->count();
                $obj->doc_uploaded_count = $doc_uploaded_count;
                
                $assessment_way = DB::table('asessor_applications')->where('application_id',$app->id)->first()->assessment_way??'';

                if($payment){
                    $obj->assessor_list = $payment_count>1 ?$onsite_assessor_list :$desktop_assessor_list;
                    $obj->assessor_type = $payment_count>1?"onsite":"desktop";
                    $obj->payment = $payment;
                    $obj->assessment_way = $assessment_way;
                    $obj->payment->payment_count = $payment_count;
                    $obj->payment->payment_amount = $payment_amount;
                    $obj->payment->last_payment = $last_payment;
                    $obj->appHistory= $app_history;
                    $obj->is_all_docs_uploaded = $this->checkAllDocsUploaded($app->id,$payment_count);
                }
                $final_data[] = $obj;
        }
        // dd($final_data);
        return view('application.international_page',['list'=>$final_data,'secretariatdata' => $secretariatdata]);
    }
    /** Whole Application View for Account */
    public function getApplicationView($id){
        $application = DB::table('tbl_application')
        ->where('id', dDecrypt($id))
        ->first();
        $mom = DB::table('tbl_mom')->where('application_id',dDecrypt($id))->latest('id')->first();
        
        $json_course_doc = File::get(base_path('/public/course-doc/courses.json'));
        $decoded_json_courses_doc = json_decode($json_course_doc);

        $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();

        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->whereNull('payment_ext')->where('pay_status','Y')->latest('id')->first();
            $obj = new \stdClass;
            $obj->application= $application;
            $obj->is_course_rejected=$this->checkAnyCoursesRejected($application->id);

            $courses = DB::table('tbl_application_courses')->where([
                'application_id' => $application->id,
            ])
            ->whereNull('deleted_at') 
            ->get();
            foreach ($courses as $course) {
                if ($course) {
                    $course_docs=$this->isNcOnCourseDocs($application->id, $course->id);
                    if($application->level_id!=1){
                        $course_docs_lists=$this->isNcOnCourseDocsList($application->id, $course->id);
                    }
                    $obj->course[] = [
                        "course" => $course,
                        'course_wise_document_declaration' => DB::table('tbl_course_wise_document')->where([
                            'application_id' => $application->id,
                            'course_id' => $course->id,
                            'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                            'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                        ])->get(),
                        'isAnyNcOnCourse'=>$course_docs,
                        'isAnyNcOnCourseDocList'=>$course_docs_lists??false,

                            'course_wise_document_curiculum' => DB::table('tbl_course_wise_document')->where([
                                'application_id' => $application->id,
                                'course_id' => $course->id,
                                'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                                'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                            ])->get(),
            
                            'course_wise_document_details' => DB::table('tbl_course_wise_document')->where([
                                'application_id' => $application->id,
                                'course_id' => $course->id,
                                'doc_sr_code' => config('constant.details.doc_sr_code'),
                                'doc_unique_id' => config('constant.details.doc_unique_id'),
                            ])->get(),
                        'nc_comments_course_declaration' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                            'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get(),
            
                        'nc_comments_course_curiculam' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                            'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get(),
            
                        'nc_comments_course_details' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.details.doc_sr_code'),
                            'doc_unique_id' => config('constant.details.doc_unique_id'),
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get()
                    ]; // Added semicolon here
                }
            }
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                    'payment_ext'=>null,
                    'status'=>2 //paymnet approved by accountant 
                ])->get();
                $additional_payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                    'payment_ext'=>'add',
                    'pay_status'=>'Y'
                ])->get();
                if($payment){
                    $obj->payment = $payment;
                    $obj->additional_payment = $additional_payment;
                }
                $final_data = $obj;
                $total_summary_count = DB::table('assessor_final_summary_reports')->where(['application_id' => $application->id])
                ->where('is_summary_show',1)
                ->count();
                
                $total_courses_count = DB::table('tbl_application_courses')->where('application_id',$application->id)->whereIn('status',[0,2])->whereNull('deleted_at')->count();
                
                if (($total_summary_count>=$total_courses_count) && $total_courses_count!=0) {
                    $is_final_submit = true;
                } else {
                    $is_final_submit = false;
                }
        return view('superadmin-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit,'courses_doc'=>$decoded_json_courses_doc,'mom'=>$mom]);
    }
    public function adminPaymentAcknowledge(Request $request)
    {
        try{
            $application = TblApplication::find($request->post('application_id'));
            $is_exists = DB::table('tbl_application_payment')->where('aknowledgement_id',null)->whereNull('payment_ext')->where('pay_status','Y')->first();
            if(!$is_exists){
                return response()->json(['success' =>false,'message'=>'Payment Acknowledgement Already Done'], 409);
            }
            DB::beginTransaction();
            DB::table('tbl_application_payment')->where('application_id', '=', $request->post('application_id'))->update(['aknowledgement_id' => auth()->user()->id]);

            createApplicationHistory($request->post('application_id'),null,config('history.admin.status'),config('history.color.warning'));
            DB::commit();
            return response()->json(['success' => true,'message' => 'Payment acknowledged successfully'], 200);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' =>false,'message'=>'Failed to make acknowledged payment'], 500);
        }
    }
    public function assignSecretariat(Request $request){
        try{
            if($request->secretariat_id==null){
                return redirect()->route('superadmin-app-list')->with('fail', 'Please select secretariat');
            }
            DB::beginTransaction();

            $get_secretariat_type = DB::table('users')->where('id',$request->secretariat_id)->first()->role;

            DB::table('tbl_secretariat_assign')->where(['application_id' => $request->application_id])->whereNotIn('secretariat_id',[$request->secretariat_id])->delete();

            $secretariat_details = DB::table('users')->where('id',$request->secretariat_id)->first();

            $data = [];
            $data['application_id']=$request->application_id;
            $data['secretariat_id']=$request->secretariat_id;
            $data['course_id']=$request->course_id??null;
            $data['secretariat_type']=$get_secretariat_type==5?'secretariat':'';
            $data['due_date']=Carbon::now()->addDay(366);
            $data['secretariat_designation']=$request->secretariat_designation??"";
            $data['secretariat_category']="atab_secretariat";
            
            $is_assigned_secretariat = DB::table('tbl_secretariat_assign')->where(['application_id'=>$request->application_id,'secretariat_id'=>$request->secretariat_id])->first();

            $get_app = DB::table('tbl_application')->where('id',$request->application_id)->first();
            
            if($get_app->level_id==1){
                $url= config('notification.secretariatUrl.level1');
                $url=$url.dEncrypt($request->application_id);
                
            }else if($get_app->level_id==2){
                $url= config('notification.secretariatUrl.level2');
                $url=$url.dEncrypt($request->application_id);
                
            }else{
                $url= config('notification.secretariatUrl.level3');
                $url=$url.dEncrypt($request->application_id);
                
            }

              /*send notification*/ 
              $notifiData = [];
              $notifiData['user_type'] = "secretariat";
              $notifiData['sender_id'] = Auth::user()->id;
              $notifiData['receiver_id'] = $request->secretariat_id;
              $notifiData['application_id'] = $request->application_id;
              $notifiData['uhid'] = getUhid( $request->application_id)[0];
              $notifiData['level_id'] = getUhid( $request->application_id)[1];
              $notifiData['url'] = $url;
              $notifiData['data'] = config('notification.secretariat.assigned');
              
              sendNotification($notifiData);
              createApplicationHistory($request->application_id,null,config('history.secretariat.assigned'),config('history.color.warning'));
            /*end here*/ 

            if($is_assigned_secretariat!=null){
                DB::table('tbl_secretariat_assign')->where(['application_id'=>$request->application_id,'secretariat_id'=>$request->secretariat_id,'secretariat_type'=>$request->secretariat_type])->update($data);
            }else{
                DB::table('tbl_secretariat_assign')->insert($data);
               
            }

            DB::table('tbl_application')->where('id',$request->application_id)->update(['admin_id'=>Auth::user()->id,'secretariat_id'=>$request->secretariat_id,'assign_secretariat'=>1]);

            /**
             * Mail Sending
             * 
             * */ 
                
               //admin mail
                
            /*end here*/

            // this is for the applicaion status
            DB::table('tbl_application')->where('id',$request->application_id)->update(['status'=>3]);
            DB::commit();
            return redirect()->route('superadmin-app-list')->with('success', 'Application has been successfully assigned to Secretariat');
        }

        catch(Exception $e){
            DB::rolback();
            return redirect()->back()->with('fail', $e->getMessage());
        }
    }
    public function applicationDocumentList($id, $course_id)
    {
        
        $tp_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;
        $data = TblApplicationPayment::where('application_id',$application_id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'assessor_type'=>'desktop'
        ])
        ->select('id','doc_unique_id','doc_file_name','doc_sr_code','admin_nc_flag','assessor_type','status','is_doc_show')
        ->get();
        $onsite_course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'assessor_type'=>'onsite'
        ])
        ->select('id','doc_unique_id','onsite_doc_file_name','doc_file_name','doc_sr_code','assessor_type','onsite_status','onsite_nc_status','admin_nc_flag','status','is_doc_show')
        ->get();
        $chapters = Chapter::all();
        foreach($chapters as $chapter){ 
            $obj = new \stdClass;
            $obj->chapters= $chapter;
            $questions = DB::table('questions')->where([
                    'chapter_id' => $chapter->id,
                ])->get();
                foreach ($questions as $k => $question) {
                    $obj->questions[] = [
                        'question' => $question,
                        'nc_comments' => TblNCComments::where([
                            'application_id' => $application_id,
                            'application_courses_id' => $course_id,
                            'doc_unique_id' => $question->id,
                            'doc_sr_code' => $question->code
                        ])
                        ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
                        ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
                        ->get(),
                        'onsite_nc_comments' => TblNCComments::where([
                            'application_id' => $application_id,
                            'application_courses_id' => $course_id,
                            'doc_unique_id' => $question->id,
                            'doc_sr_code' => $question->code,
                            'assessor_type'=>'onsite'
                        ])
                        ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
                        ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
                        ->get(),
                    ];
                }
                $final_data[] = $obj;
        }
        // dd($final_data);
        $applicationData = TblApplication::find($application_id);
        return view('superadmin-view.application-documents-list', compact('final_data','onsite_course_doc_uploaded', 'course_doc_uploaded','application_id','course_id','applicationData'));
    }
    public function adminVerfiyDocument($nc_type,$doc_sr_code, $doc_name, $application_id, $doc_unique_code,$application_course_id)
    {
        
        try{
            $accept_nc_type_status = $nc_type;
            $final_approval = DB::table('tbl_nc_comments_secretariat')->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code,'assessor_type'=>'admin','application_courses_id'=>$application_course_id])
            ->where('nc_type',"Request_For_Final_Approval")
            ->latest('id')->first();
            
            // $ass_type = $assessor_type=="desktop"?"desktop":"onsite";

            if($nc_type=="nr"){
                $nc_type="not_recommended";
            }
            
            if($nc_type!="nc1" && $nc_type!="nc2" && $nc_type!="accept" && $nc_type!="reject"){
                if(!empty($final_approval)){
                    $nc_type="Request_For_Final_Approval";
                    $assessor_type="admin";
                }else{
                    // $ass_type=null;
                }
            }
          

            $query = DB::table('tbl_nc_comments_secretariat')->where([
                'doc_sr_code' => $doc_sr_code,
                'application_id' => $application_id,
                'application_courses_id'=>$application_course_id,
                'doc_unique_id' => $doc_unique_code
            ])
            ->where('nc_type', $nc_type);
            

            // if ($nc_type=="not_recommended" || $nc_type=="Request_For_Final_Approval") {
            //     $query->where('final_status', $ass_type);
            // }
            $nc_comments = $query
                ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role', 'users.role')
                ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                ->first();
            
            // dd($nc_comments);

            $tbl_nc_comments = DB::table('tbl_nc_comments_secretariat')->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code,'application_courses_id'=>$application_course_id])
            // ->where('final_status',$ass_type)
            ->latest('id')
            ->first();

            
            
            /*Don't show form if doc is accepted*/ 
            $accepted_doc = DB::table('tbl_nc_comments_secretariat')->where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code,'application_courses_id'=>$application_course_id])
            ->whereIn('nc_type',["Accept","Reject"])
            // ->where('final_status',$assessor_type)
            ->latest('id')
            ->first();
            
            /*end here*/
            $form_view=0;
            if($nc_type=="not_recommended" && ($tbl_nc_comments->nc_type!=="Reject") && ($tbl_nc_comments->nc_type!=="Accept") && ($tbl_nc_comments->nc_type!=="NC1") && ($tbl_nc_comments->nc_type!=="NC2") && ($tbl_nc_comments->nc_type!=="Request_For_Final_Approval")){

                if(empty($accepted_doc)){
                    $form_view=1;
                }
            }else if($nc_type=="reject"){
                $form_view=0;
            }
            
        if(isset($tbl_nc_comments->nc_type)){
                if($tbl_nc_comments->nc_type=="not_recommended"){
                    $dropdown_arr = array(
                                "Reject"=>"Reject",
                                "Accept"=>"Accept",
                                "Request_For_Final_Approval"=>'Request For Final Approval'
                            );
                }
       }
        
        $doc_path = URL::to("/documnet").'/'.$doc_name;
        return view('superadmin-view.document-verify', [
            'doc_id' => $doc_sr_code,
            'doc_code' => $doc_unique_code,
            'application_id' => $application_id,
            'application_course_id'=>$application_course_id,
            'doc_path' => $doc_path,
            'doc_file_name'=>$doc_name,
            'dropdown_arr'=>$dropdown_arr??[],
            'nc_comments'=>$nc_comments,
            'form_view'=>$form_view,
            'nc_type'=>$nc_type,
        ]);
    }catch(Exception $e){
        return back()->with('fail','Something went wrong');
    }
    }
    public function adminDocumentVerify(Request $request)
    {
        try{
    
        $redirect_to=URL::to("/admin/document-list").'/'.dEncrypt($request->application_id).'/'.dEncrypt($request->application_courses_id);
        DB::beginTransaction();
        $assessor_id = Auth::user()->id;
        $assessor_type = 'admin';
        /*end here*/
        $data = [];
        $data['application_id'] = $request->application_id;
        $data['doc_sr_code'] = $request->doc_sr_code;
        $data['doc_unique_id'] = $request->doc_unique_id;
        $data['application_courses_id'] = $request->application_courses_id;
        $data['assessor_type'] = $assessor_type;
        $data['comments'] = $request->comments;
        $data['nc_type'] = $request->nc_type;
        $data['assessor_id'] = $assessor_id; 
        $data['doc_file_name'] = $request->doc_file_name;
        $data['final_status'] = $request->assessor_type;

        $nc_comment_status="";
        $admin_nc_flag=0;
        if($request->nc_type=="Accept"){
            $nc_comment_status=1;
            $admin_nc_flag=1;
            $nc_flag=0;
        }else if($request->nc_type=="Reject"){
            $nc_comment_status=1;
            $admin_nc_flag=2;
            $nc_flag=0;
        }else{
            $admin_nc_flag=3;
            $nc_comment_status=4; //request for final approval
            $nc_flag=1;
        }

        $create_nc_comments = TblNCComments::insert($data);

        if($request->assessor_type=="onsite"){
            TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'onsite_status'=>4])->update(['onsite_nc_status'=>$nc_flag,'admin_nc_flag'=>$admin_nc_flag]);
        }else{
            TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'status'=>4])->update(['nc_flag'=>$nc_flag,'admin_nc_flag'=>$admin_nc_flag]);
        }
        


        if($create_nc_comments){
            DB::commit();
            return response()->json(['success' => true,'message' =>''.$request->nc_type.' comments created successfully','redirect_to'=>$redirect_to],200);
        }else{
            return response()->json(['success' => false,'message' =>'Failed to create '.$request->nc_type.' and documents'],200);
        }
    }catch(Exception $e){
        DB::rollBack();
        return response()->json(['success' => false,'message' =>'Something went wrong'],200);
    }
    }


    /*Secretariat nc's from admin side*/ 
    public function applicationDocumentListLevel2($id, $course_id)
    {
        $tp_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;
        $data = TblApplicationPayment::where('application_id',$application_id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'assessor_type'=>'secretariat'
        ])
        ->select('id','doc_unique_id','doc_file_name','doc_sr_code','admin_nc_flag','assessor_type','status','is_doc_show')
        ->get();
        
        $chapters = Chapter::all();
        foreach($chapters as $chapter){ 
            $obj = new \stdClass;
            $obj->chapters= $chapter;
            $questions = DB::table('questions')->where([
                    'chapter_id' => $chapter->id,
                ])->get();
                foreach ($questions as $k => $question) {
                    $obj->questions[] = [
                        'question' => $question,
                        'nc_comments' => TblNCComments::where([
                            'application_id' => $application_id,
                            'application_courses_id' => $course_id,
                            'doc_unique_id' => $question->id,
                            'doc_sr_code' => $question->code
                        ])
                        ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
                        ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
                        ->get(),
                    ];
                }
                $final_data[] = $obj;
        }
        
        $applicationData = TblApplication::find($application_id);
        return view('superadmin-view.secretariat.application-documents-list', compact('final_data','course_doc_uploaded','application_id','course_id','applicationData'));
    }
    
    public function superAdminVerfiyDocumentLevel2($nc_type, $assessor_type, $doc_sr_code, $doc_name, $application_id, $doc_unique_code, $application_course_id)
    {
        
        try {
            $accept_nc_type_status = $nc_type;
            $final_approval = TblNCComments::where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code, 'assessor_type' => 'admin', 'final_status' => $assessor_type,'application_courses_id'=> $application_course_id])
                ->where('nc_type', "Request_For_Final_Approval")
                ->latest('id')->first();

            // dd($final_approval);
            $ass_type = $assessor_type == "desktop" ? "desktop" : "onsite";

            if ($nc_type == "nr") {
                $nc_type = "not_recommended";
            }

            if ($nc_type != "nc1" && $nc_type != "nc2" && $nc_type != "accept" && $nc_type != "reject") {
                if (!empty($final_approval)) {
                    $nc_type = "Request_For_Final_Approval";
                    $assessor_type = "admin";
                } else {
                    $ass_type = null;
                }
            }
            // $nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code,'application_id' => $application_id,'doc_unique_id' => $doc_unique_code])
            // ->where('nc_type',$nc_type)
            // ->where('assessor_type',$assessor_type)
            // ->where('final_status',$ass_type)
            // ->select('tbl_nc_comments.*','users.firstname','users.middlename','users.lastname')
            // ->leftJoin('users','tbl_nc_comments.assessor_id','=','users.id')
            // ->first();

            $query = TblNCComments::where([
                'doc_sr_code' => $doc_sr_code,
                'application_id' => $application_id,
                'doc_unique_id' => $doc_unique_code
            ])
                ->where('nc_type', $nc_type)
                ->where('assessor_type', $assessor_type);
            if ($nc_type == "not_recommended" || $nc_type == "Request_For_Final_Approval") {
                $query->where('final_status', $ass_type);
            }
            $nc_comments = $query
                ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                ->first();

            // dd($nc_comments);

            $tbl_nc_comments = TblNCComments::where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code,'application_courses_id'=> $application_course_id])
                ->where('final_status', $ass_type)
                ->latest('id')
                ->first();

                


            /*Don't show form if doc is accepted*/
            $accepted_doc = TblNCComments::where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code,'application_courses_id'=> $application_course_id])
                ->whereIn('nc_type', ["Accept", "Reject"])
                ->where('final_status', $assessor_type)
                ->latest('id')
                ->first();

            /*end here*/
            $form_view = 0;
            if ($nc_type == "not_recommended" && ($tbl_nc_comments->nc_type !== "Reject") && ($tbl_nc_comments->nc_type !== "Accept") && ($tbl_nc_comments->nc_type !== "NC1") && ($tbl_nc_comments->nc_type !== "NC2") && ($tbl_nc_comments->nc_type !== "Request_For_Final_Approval")) {
                if (empty($accepted_doc)) {
                    $form_view = 1;
                }
            } else if ($nc_type == "reject") {
                $form_view = 0;
            }
            if($assessor_type=='desktop'){
                $form_view=0;
            }


            if (isset($tbl_nc_comments->nc_type)) {
                if ($tbl_nc_comments->nc_type == "not_recommended") {
                    $dropdown_arr = array(
                        "Reject" => "Reject",
                        "Accept" => "Accept",
                        "Request_For_Final_Approval" => 'Request For Final Approval'
                    );
                }
            }
            $doc_latest_record = TblApplicationCourseDoc::latest('id')
                ->where(['doc_sr_code' => $doc_sr_code, 'application_id' => $application_id, 'doc_unique_id' => $doc_unique_code])
                ->first();
            // $doc_path = URL::to("/level").'/'.$doc_latest_record->doc_file_name;
            $doc_path = URL::to("/level") . '/' . $doc_name;
            return view('superadmin-view.secretariat.document-verify', [
                'doc_latest_record' => $doc_latest_record,
                'doc_id' => $doc_sr_code,
                'doc_code' => $doc_unique_code,
                'application_id' => $application_id,
                'application_course_id' => $application_course_id,
                'doc_path' => $doc_path,
                'doc_file_name' => $doc_name,
                'dropdown_arr' => $dropdown_arr ?? [],
                'nc_comments' => $nc_comments,
                'form_view' => $form_view,
                'assessor_type' => $assessor_type,
                'nc_type' => $nc_type,
            ]);
        } catch (Exception $e) {
            return back()->with('fail', 'Something went wrong');
        }
    }

    public function adminDocumentVerifyLevel2(Request $request)
    {
        
        try{
        $redirect_to=URL::to("/super-admin/document-list-level-2").'/'.dEncrypt($request->application_id).'/'.dEncrypt($request->application_courses_id);
        DB::beginTransaction();
        $assessor_id = Auth::user()->id;
        $assessor_type = 'admin';
        /*end here*/
        $data = [];
        $data['application_id'] = $request->application_id;
        $data['doc_sr_code'] = $request->doc_sr_code;
        $data['doc_unique_id'] = $request->doc_unique_id;
        $data['application_courses_id'] = $request->application_courses_id;
        $data['assessor_type'] = $assessor_type;
        $data['comments'] = $request->comments;
        $data['nc_type'] = $request->nc_type;
        $data['assessor_id'] = $assessor_id; 
        $data['doc_file_name'] = $request->doc_file_name;
        $data['final_status'] = $request->assessor_type;

        $nc_comment_status="";
        $admin_nc_flag=0;
        if($request->nc_type=="Accept"){
            $nc_comment_status=1;
            $admin_nc_flag=1;
            $nc_flag=0;
        }else if($request->nc_type=="Reject"){
            $nc_comment_status=1;
            $admin_nc_flag=2;
            $nc_flag=0;
        }else{
            $admin_nc_flag=3;
            $nc_comment_status=4; //request for final approval
            $nc_flag=1;
        }

        $create_nc_comments = TblNCComments::insert($data);

        if($request->assessor_type=="onsite"){
            TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'onsite_status'=>4])->update(['onsite_nc_status'=>$nc_flag,'admin_nc_flag'=>$admin_nc_flag]);
        }else{
            TblApplicationCourseDoc::where(['application_id'=> $request->application_id,'application_courses_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'status'=>4])->update(['nc_flag'=>$nc_flag,'admin_nc_flag'=>$admin_nc_flag,'nc_show_status'=>4]);
        }
        


        if($create_nc_comments){
            DB::commit();
            return response()->json(['success' => true,'message' =>''.$request->nc_type.' comments created successfully','redirect_to'=>$redirect_to],200);
        }else{
            return response()->json(['success' => false,'message' =>'Failed to create '.$request->nc_type.' and documents'],200);
        }
    }catch(Exception $e){
        DB::rollBack();
        return response()->json(['success' => false,'message' =>'Something went wrong'],200);
    }
    }

    /*end here*/ 

    public function updateAdminNotificationStatus(Request $request,$id)
    {
        
        try{
          $request->validate([
              'id' => 'required',
          ]);
          DB::beginTransaction();
          
          DB::table('tbl_application')->where('id',$id)->update(['admin_received_payment'=>1]);
          
          $is_read = DB::table('tbl_notifications')->where('id',$id)->update(['is_read'=>"1"]);
          $d=DB::table('tbl_notifications')->where('id',$id)->first();
          
          if($is_read){
              DB::commit();
              return response()->json(['success' => true,'message' =>'Read notification successfully.','redirect_url'=>$d->url],200);
          }else{
              DB::rollback();
              return response()->json(['success' => false,'message' =>'Notification Already read','redirect_url'=>$d->url],200);
          }
    }
    catch(Exception $e){
          DB::rollback();
          return response()->json(['success' => false,'message' =>'Failed to read notification'],200);
    }
    }
    

    public function adminCourseDocumentVerify(Request $request)
    {
        try{
        $redirect_to=URL::to("/super-admin/application-view").'/'.dEncrypt($request->application_id);
        
        DB::beginTransaction();
        $assessor_id = Auth::user()->id;
        $assessor_type = 'admin';
        /*end here*/
        $data = [];
        $data['application_id'] = $request->application_id;
        $data['doc_sr_code'] = $request->doc_sr_code;
        $data['doc_unique_id'] = $request->doc_unique_id;
        $data['application_courses_id'] = $request->application_courses_id;
        $data['assessor_type'] = $assessor_type;
        $data['comments'] = $request->comments;
        $data['nc_type'] = $request->nc_type;
        $data['secretariat_id'] = $assessor_id; 
        $data['doc_file_name'] = $request->doc_file_name;
        $data['final_status'] = $assessor_type;

        $nc_comment_status="";
        $admin_nc_flag=0;
        if($request->nc_type=="Accept"){
            $nc_comment_status=1;
            $admin_nc_flag=1;
            $nc_flag=0;
        }else if($request->nc_type=="Reject"){
            $nc_comment_status=1;
            $admin_nc_flag=2;
            $nc_flag=0;
        }else{
            $admin_nc_flag=3;
            $nc_comment_status=4; //request for final approval
            $nc_flag=1;
        }

        $create_nc_comments = DB::table('tbl_nc_comments_secretariat')->insert($data);

            DB::table('tbl_course_wise_document')
            ->where(['application_id'=> $request->application_id,'course_id'=>$request->application_courses_id,'doc_sr_code'=>$request->doc_sr_code,'doc_unique_id'=>$request->doc_unique_id,'status'=>4])->update(['nc_flag'=>$nc_flag,'admin_nc_flag'=>$admin_nc_flag]);

            DB::table('tbl_nc_comments_secretariat')
                ->where(['application_id' => $request->application_id, 'application_courses_id' => $request->application_courses_id,'nc_show_status'=>0])
                ->update(['nc_show_status' => 1]);

        if($create_nc_comments){
            DB::commit();
            return response()->json(['success' => true,'message' =>''.$request->nc_type.' comments created successfully','redirect_to'=>$redirect_to],200);
        }else{
            return response()->json(['success' => false,'message' =>'Failed to create '.$request->nc_type.' and documents'],200);
        }
    }catch(Exception $e){
        DB::rollBack();
        return response()->json(['success' => false,'message' =>'Something went wrong'],200);
    }
    }

    public function approvedApplication(Request $request)
    {
        $app_id = $request->application_id;
        try {
            DB::beginTransaction();
            $valid_from = Carbon::now();
            $valid_till = Carbon::now()->addDays(364);
            $approve_app = DB::table('tbl_application')
                ->where(['id' => $app_id])
                ->update(['approve_status'=>1,'accept_remark'=>$request->approve_remark,'valid_till'=>$valid_till,'valid_from'=>$valid_from,'is_all_course_doc_verified'=>1]);
                $get_application= DB::table('tbl_application')->where('id',$app_id)->first();
                if($approve_app){
                    
                    if($get_application->level_id==1){
                        createApplicationHistory($app_id,null,config('history.admin.acceptApplication'),config('history.color.success'));
                    }
                    if($get_application->level_id==2){
                        createApplicationHistory($app_id,null,config('history.admin.approvedApplication'),config('history.color.success'));
                    }

                    if($get_application->level_id==3){
                        /*Certificate generation*/ 
                        $data = [];
                        $data['application_id'] = $app_id;
                        $data['refid'] = $get_application->refid;
                        $data['certificate_no'] = 1;
                        $data['certificate_file'] = 1;
                        $data['valid_from'] = $valid_from;
                        $data['valid_till'] = $valid_till;
                        $data['level_id'] = $get_application->level_id;
                        DB::table('tbl_certificate')->insert($data);

                        
                        /*end here*/ 

                        /*To show docs to TP*/ 
                        $all_docs_desktop = DB::table('tbl_application_course_doc')
                        ->where(['application_id' => $request->application_id,'approve_status'=>1])
                        ->where('assessor_type','desktop')
                        ->whereNotIn('status',[2,3,4,5]) 
                        ->get(); 

                        $all_docs_onsite = DB::table('tbl_application_course_doc')
                        ->where(['application_id' => $request->application_id,'approve_status'=>1])
                        ->where('assessor_type','onsite')
                        ->whereNotIn('onsite_status',[2,3,4,5]) 
                        ->get(); 
                        $all_docs = $all_docs_desktop->merge($all_docs_onsite);

                        
                        foreach($all_docs as $doc){
                            if($doc->status==0){
                                DB::table('tbl_application_course_doc')->where('id',$doc->id)->update(['status'=>5,'onsite_status'=>5,'admin_nc_flag'=>1,'nc_show_status'=>5,'is_revert'=>1]);
                                
                            }else{
                                DB::table('tbl_application_course_doc')->where('id',$doc->id)->update(['status'=>$doc->status,'onsite_status'=>$doc->onsite_status,'admin_nc_flag'=>1,'nc_show_status'=>5,'is_revert'=>1]);

                            }
                            // $data = [];
                            //     $data['application_id'] = $doc->application_id;
                            //     $data['application_courses_id'] = $doc->course_id;
                            //     $data['secretariat_id'] = Auth::user()->id;
                            //     $data['doc_sr_code'] = $doc->doc_sr_code;
                            //     $data['doc_unique_id'] = $doc->doc_unique_id;
                            //     $data['nc_type'] = 'Accept';
                            //     $data['doc_file_name'] = $doc->doc_file_name;
                            //     $data['comments'] = 'Document has been approved';
                            //     $data['nc_show_status'] = 1;
                            //     DB::table('tbl_nc_comments_secretariat')->insert($data);
                        }

                        // rejected courses list doc
                        
                         /*To show docs to TP*/ 
                         $all_docs_desktop = DB::table('tbl_application_course_doc')
                         ->where(['application_id' => $request->application_id])
                         ->whereIn('approve_status',[0,2])
                         ->where('assessor_type','desktop')
                         ->whereNotIn('status',[2,3,4,5]) 
                         ->get(); 
 
                         $all_docs_onsite = DB::table('tbl_application_course_doc')
                         ->where(['application_id' => $request->application_id])
                         ->whereIn('approve_status',[0,2])
                         ->where('assessor_type','onsite')
                         ->whereNotIn('onsite_status',[2,3,4,5]) 
                         ->get(); 
                         $all_docs = $all_docs_desktop->merge($all_docs_onsite);
 
                         
                         foreach($all_docs as $doc){
                            DB::table('tbl_application_course_doc')->where('id',$doc->id)->update(['status'=>5,'onsite_status'=>5,'admin_nc_flag'=>1,'nc_show_status'=>5,'is_revert'=>1]);
                         }


                        //  course wise document
                    $all_docs = DB::table('tbl_course_wise_document')
                    ->where(['application_id' => $request->application_id,'approve_status'=>1])
                    ->whereNotIn('status',[2,3,4,6]) 
                    ->get();
                 
                    foreach($all_docs as $doc){
                        if($doc->status==0){
                            DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>5,'admin_nc_flag'=>1,'nc_show_status'=>5,'is_revert'=>1]);
                            }else{
                                DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>$doc->status,'admin_nc_flag'=>1,'nc_show_status'=>5,'is_revert'=>1]);
                            }
                      
                    }
                    /*change docs status only of reject course*/ 
                    $all_docs = DB::table('tbl_course_wise_document')
                    ->where(['application_id' => $request->application_id])
                    ->whereIn('approve_status',[0,2])  //get only rejected courses
                    ->whereNotIn('status',[2,3,4,6]) 
                    ->get(); 
                    foreach($all_docs as $doc){
                            DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>5,'admin_nc_flag'=>2,'nc_show_status'=>5,'is_revert'=>1]);
                    }
                    DB::table('tbl_application_courses')->where('application_id',$request->application_id)->update(['is_revert'=>1]);
                    /*end here*/ 
                    }else{


                        if($get_application->level_id==2){
                            $all_docs = DB::table('tbl_application_course_doc')
                            ->where(['application_id' => $request->application_id,'approve_status'=>1])
                            ->where('assessor_type','secretariat')
                            ->whereNotIn('status',[2,3,4,6]) 
                            ->get(); 
                            
                            
                            // dd($all_docs);
                            foreach($all_docs as $doc){
                                if($doc->status==0){
                                    DB::table('tbl_application_course_doc')->where('id',$doc->id)->update(['status'=>5,'admin_nc_flag'=>1,'nc_show_status'=>5,'is_revert'=>1]);
                                }else{
                                    DB::table('tbl_application_course_doc')->where('id',$doc->id)->update(['status'=>$doc->status,'admin_nc_flag'=>1,'nc_show_status'=>5,'is_revert'=>1]);
                                }
                            }
                            
                            // taking only the rejected course
                            $all_docs = DB::table('tbl_application_course_doc')
                            ->where(['application_id' => $request->application_id])
                            ->whereIn('approve_status',[0,3])
                            ->where('assessor_type','secretariat')
                            ->whereNotIn('status',[2,3,4,6]) 
                            ->get(); 
                            
                            // dd($all_docs);
                            foreach($all_docs as $doc){
                                    DB::table('tbl_application_course_doc')->where('id',$doc->id)->update(['status'=>5,'admin_nc_flag'=>2,'nc_show_status'=>5,'is_revert'=>1]);
                                
                            }

                            // taking only the rejected course
                            // $all_docs = DB::table('tbl_application_course_doc')
                            // ->where(['application_id' => $request->application_id,'approve_status'=>1])
                            // ->where('assessor_type','secretariat')
                            // ->whereNotIn('status',[0,2]) 
                            // ->get(); 


                            // foreach($all_docs as $doc){

                            //         DB::table('tbl_application_course_doc')->where('id',$doc->id)->update(['status'=>5,'admin_nc_flag'=>2,'nc_show_status'=>5,'is_revert'=>1]);
                            // }
    
    
                        }


                    /*To show docs to TP*/ 
                    $all_docs = DB::table('tbl_course_wise_document')
                    ->where(['application_id' => $request->application_id,'approve_status'=>1])
                    ->whereNotIn('status',[2,3,4,6]) 
                    ->get();
                    
                    
                 
                    foreach($all_docs as $doc){
                        if($doc->status==0){
                            DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>5,'admin_nc_flag'=>1,'nc_show_status'=>5,'is_revert'=>1]);
                            }else{
                                DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>$doc->status,'admin_nc_flag'=>1,'nc_show_status'=>5,'is_revert'=>1]);
                            }
                      
                    }


                    /*change docs status only of reject course*/ 
                    $all_docs = DB::table('tbl_course_wise_document')
                    ->where(['application_id' => $request->application_id])
                    ->whereIn('approve_status',[0,2])  //get only rejected courses
                    ->whereNotIn('status',[2,3,4,6]) 
                    ->get(); 
                    // dd($all_docs);
                    foreach($all_docs as $doc){
                            DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>5,'admin_nc_flag'=>2,'nc_show_status'=>5,'is_revert'=>1]);
                    }

                    DB::table('tbl_application_courses')->where('application_id',$request->application_id)->update(['is_revert'=>1]);
                    /*end here*/ 
                  }

                  $get_app = DB::table('tbl_application')->where('id',$request->application_id)->first();
                 
                  if( $get_app->level_id==1){
                    $url= config('notification.secretariatUrl.level1');
                    $url=$url.dEncrypt($request->application_id);
                    $tpUrl = config('notification.tpUrl.level1');
                    $tpUrl=$tpUrl.dEncrypt($request->application_id);
                }else if( $get_app->level_id==2){
                    $url= config('notification.secretariatUrl.level2');
                    $url=$url.dEncrypt($request->application_id);
                    $tpUrl = config('notification.tpUrl.level2');
                    $tpUrl=$tpUrl.dEncrypt($request->application_id);
                }else{
                    $url= config('notification.secretariatUrl.level3');
                    $url=$url.dEncrypt($request->application_id);
                    $tpUrl = config('notification.tpUrl.level3');
                    $tpUrl=$tpUrl.dEncrypt($request->application_id);
                }
                  
                  $notifiData = [];
                  $notifiData['sender_id'] = Auth::user()->id;
                  $notifiData['receiver_id'] = $get_app->secretariat_id;
                  $notifiData['application_id'] = $app_id;
                  $notifiData['uhid'] = getUhid( $app_id)[0];
                  $notifiData['level_id'] = getUhid( $app_id)[1];
                  $notifiData['data'] = config('notification.common.appApproved');
                  $notifiData['user_type'] = "secretariat";
                  $notifiData['url'] = $url;
            
                  /*send notification*/ 
                  sendNotification($notifiData);
                  $notifiData['sender_id'] = $get_app->tp_id;
                  $notifiData['user_type'] = "tp";
                  $notifiData['url'] = $tpUrl;
                  sendNotification($notifiData);
                  createApplicationHistory($request->application_id,null,config('history.common.appApproved'),config('history.color.success'));
                  /*end here*/ 

                  // this is for the applicaion status
                    DB::table('tbl_application')->where('id',$app_id)->update(['status'=>7]);
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Application approved successfully.'], 200);
                }else{
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Failed to approved successfully.'], 200);
                }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }

    public function rejectApplication($application_id)
    {
        
        $app_id = $application_id;
        try {
            DB::beginTransaction();

            /*TP show ncs*/
            DB::table('tbl_course_wise_document')
            ->where(['application_id' => $application_id])
            ->update(['approve_status'=>2,'is_revert'=>1]); 
            
            DB::table('tbl_application_courses')->where('application_id',$application_id)->update(['is_revert'=>1]);

            $all_docs = DB::table('tbl_course_wise_document')
            ->where(['application_id' => $application_id,'approve_status'=>2])
            ->whereNotIn('status',[2,3,4,6])
            ->get(); 

            foreach($all_docs as $doc){
                if($doc->status==0){
                    DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>5,'admin_nc_flag'=>2,'nc_show_status'=>5]);
                }else{
                    DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>$doc->status,'admin_nc_flag'=>2,'nc_show_status'=>5]);

                }
                // $data = [];
                //     $data['application_id'] = $doc->application_id;
                //     $data['application_courses_id'] = $doc->course_id;
                //     $data['secretariat_id'] = Auth::user()->id;
                //     $data['doc_sr_code'] = $doc->doc_sr_code;
                //     $data['doc_unique_id'] = $doc->doc_unique_id;
                //     $data['nc_type'] = 'Accept';
                //     $data['doc_file_name'] = $doc->doc_file_name;
                //     $data['comments'] = 'Document has been approved';
                //     $data['nc_show_status'] = 1;
                //     DB::table('tbl_nc_comments_secretariat')->insert($data);
            }
            /*end here*/


            $get_app = DB::table('tbl_application')->where('id',$application_id)->first();
            if($get_app->level_id==1){
                $url= config('notification.secretariatUrl.level1');
                $url=$url.dEncrypt($application_id);
                $tpUrl = config('notification.tpUrl.level1');
                $tpUrl=$tpUrl.dEncrypt($application_id);
            }else if($get_app->level_id==2){
                $url= config('notification.secretariatUrl.level2');
                $url=$url.dEncrypt($application_id);
                $tpUrl = config('notification.tpUrl.level2');
                $tpUrl=$tpUrl.dEncrypt($application_id);
            }else{
                $url= config('notification.secretariatUrl.level3');
                $url=$url.dEncrypt($application_id);
                $tpUrl = config('notification.tpUrl.level3');
                $tpUrl=$tpUrl.dEncrypt($application_id);
            }

            $approve_app = DB::table('tbl_application')
                ->where(['id' => $app_id])
                ->update(['approve_status'=>3,'is_all_course_doc_verified'=>0]); //3 for rejected application by admin

                // ->update(['approve_status'=>3,'reject_remark'=>$request->remark,'is_all_course_doc_verified'=>0]); //3 for rejected application by admin
                $notifiData = [];
                $notifiData['sender_id'] = Auth::user()->id;
                $notifiData['receiver_id'] = $get_app->secretariat_id;
                $notifiData['application_id'] = $app_id;
                $notifiData['uhid'] = getUhid( $app_id)[0];
                $notifiData['level_id'] = getUhid( $app_id)[1];
                $notifiData['data'] = config('notification.common.appRejected');
                $notifiData['user_type'] = "secretariat";
                $notifiData['url'] = $url;
          
                /*send notification*/ 
                sendNotification($notifiData);
                $notifiData['user_type'] = "tp";
                $notifiData['receiver_id'] = $get_app->tp_id;
                $notifiData['url'] = $tpUrl;
                sendNotification($notifiData);
                /*end here*/ 
                // this is for the applicaion status
                DB::table('tbl_application')->where('id',$application_id)->update(['status'=>8]);
                if($approve_app){
                    createApplicationHistory($app_id,null,config('history.admin.rejectApplication'),config('history.color.danger'));
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Application rejected successfully.'], 200);
                }else{
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Failed to reject  application.'], 200);
                }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }

    public function approveCourseRejectBySecretariat(Request $request){
        try {
            DB::beginTransaction();
            
                DB::table('tbl_course_wise_document')
                ->where(['application_id' => $request->application_id,'course_id'=>$request->course_id])
                ->whereNotIn('status',[2,3,4,6]) 
                ->update(['approve_status'=>1]);
                
             
                // foreach($all_docs as $doc){
                //     if($doc->status==0){
                //         DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>5,'admin_nc_flag'=>1,'nc_show_status'=>5]);
                        
                //     }else{
                //         DB::table('tbl_course_wise_document')->where('id',$doc->id)->update(['status'=>$doc->status,'admin_nc_flag'=>1,'nc_show_status'=>5]);

                //     }
                //     $data = [];
                //         $data['application_id'] = $doc->application_id;
                //         $data['application_courses_id'] = $doc->course_id;
                //         $data['secretariat_id'] = Auth::user()->id;
                //         $data['doc_sr_code'] = $doc->doc_sr_code;
                //         $data['doc_unique_id'] = $doc->doc_unique_id;
                //         $data['nc_type'] = 'Accept';
                //         $data['doc_file_name'] = $doc->doc_file_name;
                //         $data['comments'] = 'Document has been approved';
                //         $data['nc_show_status'] = 1;
                //         DB::table('tbl_nc_comments_secretariat')->insert($data);
                   

                // }

               $abc = DB::table('tbl_application_courses')
                ->where(['id'=>$request->course_id])
                ->update(['status'=>2,'admin_accept_remark'=>$request->approve_remark]); //approved by admin

                if($abc){
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Course approved  successfully'], 200);
                }else{
                    DB::rollBack();
                    return response()->json(['success' =>false, 'message' => 'Failed to approved course'], 200);
                }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }

    public function adminRejectCourse(Request $request){
        try {
            DB::beginTransaction();
                
            $get_application = DB::table('tbl_application')->where('id', $request->application_id)->first();
            // this is for the level-2 and level-3
            if(isset($get_application) && ($get_application->level_id==2 || $get_application->level_id==3)){
                DB::table('tbl_application_course_doc')->where(['application_id'=>$request->application_id,'application_courses_id'=>$request->course_id])->update(['approve_status'=>3]);
            }
            
                $updateStatus = DB::table('tbl_application_courses')
                ->where(['id'=>$request->course_id])
                ->update(['status'=>3,'admin_reject_remark'=>$request->remark]); //reject by admin

               $abc = DB::table('tbl_course_wise_document')
                ->where(['application_id' => $request->application_id,'course_id'=>$request->course_id])
                ->whereNotIn('status',[2,3,4,6]) 
                ->update(['approve_status'=>2]);
                

                if($updateStatus){
                    $is_all_course_rejected =  $this->checkAllCourseRejected($request->application_id);
                    DB::commit();
                  if($is_all_course_rejected){
                    return response()->json(['success' => true, 'message' => 'Application rejected  successfully.'], 200);
                  }
                    return response()->json(['success' => true, 'message' => 'Course rejected  successfully.'], 200);
                }else{
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Failed to reject course'], 200);
                }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Something went wrong'], 200);
        }
    }

    public function checkAllCourseRejected($application_id){
        
        $all_courses = DB::table('tbl_application_courses')->where(['application_id'=>$application_id])->get();
        $total_reject_course_count = 0;
        $total_course_count = count($all_courses);

        foreach($all_courses as $course){
            if($course->status==3){
                $total_reject_course_count++;
            }
        }
        if($total_reject_course_count==$total_course_count){
            $this->rejectApplication($application_id);
            return true;
        }else{
            return false;
        }
    }

    public function checkAnyCoursesRejected($application_id){
        $is_any_courses_rejected = DB::table('tbl_application_courses')
        ->where('application_id',$application_id)
        ->whereIn('status',[0,1])->first();
        $flag="";
        if($is_any_courses_rejected){
            return $flag="rejected";
        }
        $flag = "all_approved";
        return $flag;
    }

    public function checkAllDocsUploaded($application_id,$paymentCount){
        
        try{
            
            if($application_id){
                $app_details = DB::table('tbl_application')->where('id',$application_id)->first();
                if($app_details->level_id==2){
                    $assessor_type="secretariat";
                }else{
                    $assessor_type = $paymentCount>1?'onsite':'desktop';
                }
                
                $get_courses_count = DB::table('tbl_application_courses')->where('application_id',$application_id)->whereNull('deleted_at')->count();
                $courses_doc_list = DB::table('tbl_application_course_doc')->where('application_id',$application_id)
                ->where('assessor_type',$assessor_type)
                ->count();
                $total_docs = $get_courses_count*4;
                if($courses_doc_list>=$total_docs){
                    return true;
                }else{
                    return false;
                }

            }else{
                return false;
            }
        }catch(Exception $e){
            return false;
        }

    }

    /*additional payment fee list*/ 
    public function getApplicationPaymentFeeList(){
        $application = DB::table('tbl_application as a')
        ->whereIn('a.payment_status',[2,3,5])
        ->whereIn('a.is_query_raise',[1,2])
        ->orderBy('id','desc')
        ->get();
        $final_data=array();
        // $payment_count = DB::table("tbl_application_payment")->where('')
        
        $desktop_assessor_list = DB::table('users')->where(['assessment'=>1,'role'=>3,'status'=>0])->orderBy('id', 'DESC')->get();
        
        $onsite_assessor_list = DB::table('users')->where(['assessment'=>2,'role'=>3,'status'=>0])->orderBy('id', 'DESC')->get();
       
        $secretariatdata = DB::table('users')->where('role', '5')->orderBy('id', 'DESC')->get();
        foreach($application as $app){
            $obj = new \stdClass;
            $obj->application_list= $app;
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $app->id,
                ])
                ->whereNull('deleted_at') 
                ->count();
                if($course){
                    $obj->course_count = $course;
                }
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                    
                ])
                ->first();
                $last_payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                ])
                ->latest('id')
                ->first();

                $payment_amount = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                ])
                ->where('status',2)
                ->sum('amount');
                $payment_count = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                    'payment_ext'=>null,
                ])
                ->where('status',2)
                ->count();
                $app_history = DB::table('tbl_application_status_history')
                ->select('tbl_application_status_history.*','users.firstname','users.middlename','users.lastname','users.role')
                ->leftJoin('users', 'tbl_application_status_history.user_id', '=', 'users.id')
                ->where('tbl_application_status_history.application_id', $app->id)
                ->get();

                $doc_uploaded_count = DB::table('tbl_application_course_doc')->where(['application_id' => $app->id])->count();
                $obj->doc_uploaded_count = $doc_uploaded_count;
                
                $assessment_way = DB::table('asessor_applications')->where('application_id',$app->id)->first()->assessment_way??'';

                if($payment){
                  $obj->assessor_list = $payment_count>1 ?$onsite_assessor_list :$desktop_assessor_list;
                   $obj->assessor_type = $payment_count>1?"onsite":"desktop";
                    $obj->payment = $payment;
                    $obj->assessment_way = $assessment_way;
                    $obj->payment->payment_count = $payment_count;
                    $obj->payment->payment_amount = $payment_amount;
                    $obj->payment->last_payment = $last_payment;
                    $obj->appHistory= $app_history;

                }
                $final_data[] = $obj;
        }
        // dd($final_data);
        return view('superadmin-view.payment.application-list',['list'=>$final_data,'secretariatdata' => $secretariatdata]);
    }
    
    public function getApplicationPaymentFeeView($id){
        $application = DB::table('tbl_application')
        ->where('id', dDecrypt($id))
        ->first();

        $json_course_doc = File::get(base_path('/public/course-doc/courses.json'));
        $decoded_json_courses_doc = json_decode($json_course_doc);

        $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();

        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->latest('id')->first();
            $obj = new \stdClass;
            $obj->application= $application;
            $obj->is_course_rejected=$this->checkAnyCoursesRejected($application->id);

            $courses = DB::table('tbl_application_courses')->where([
                'application_id' => $application->id,
            ])
            ->whereNull('deleted_at') 
            ->get();
            foreach ($courses as $course) {
                if ($course) {
                    $obj->course[] = [
                        "course" => $course,
                        'course_wise_document_declaration' => DB::table('tbl_course_wise_document')->where([
                            'application_id' => $application->id,
                            'course_id' => $course->id,
                            'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                            'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                        ])->get(),

                            'course_wise_document_curiculum' => DB::table('tbl_course_wise_document')->where([
                                'application_id' => $application->id,
                                'course_id' => $course->id,
                                'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                                'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                            ])->get(),
            
                            'course_wise_document_details' => DB::table('tbl_course_wise_document')->where([
                                'application_id' => $application->id,
                                'course_id' => $course->id,
                                'doc_sr_code' => config('constant.details.doc_sr_code'),
                                'doc_unique_id' => config('constant.details.doc_unique_id'),
                            ])->get(),
                        'nc_comments_course_declaration' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.declaration.doc_sr_code'),
                            'doc_unique_id' => config('constant.declaration.doc_unique_id'),
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get(),
            
                        'nc_comments_course_curiculam' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.curiculum.doc_sr_code'),
                            'doc_unique_id' => config('constant.curiculum.doc_unique_id'),
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get(),
            
                        'nc_comments_course_details' => DB::table('tbl_nc_comments_secretariat')->where([
                            'application_id' => $application->id,
                            'application_courses_id' => $course->id,
                            'doc_sr_code' => config('constant.details.doc_sr_code'),
                            'doc_unique_id' => config('constant.details.doc_unique_id'),
                        ])
                            ->select('tbl_nc_comments_secretariat.*', 'users.firstname', 'users.middlename', 'users.lastname','users.role')
                            ->leftJoin('users', 'tbl_nc_comments_secretariat.secretariat_id', '=', 'users.id')
                            ->get()
                    ]; // Added semicolon here
                }
            }
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                    'payment_ext'=>null,
                    'status'=>2 //paymnet approved by accountant 
                ])->get();
                $additional_payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                    'payment_ext'=>'add',
                    'pay_status'=>'Y'
                ])->get();
                if($payment){
                    $obj->payment = $payment;
                    $obj->additional_payment = $additional_payment;
                }
                $final_data = $obj;

                $admin_final_summary_count =  DB::table('assessor_final_summary_reports')->where(['application_id'=>$application->id])->count();
                if($admin_final_summary_count>1){
                 $is_final_submit = true;
                }else{
                 $is_final_submit = false;
                }
            
        return view('superadmin-view.payment.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status,'is_final_submit'=>$is_final_submit,'courses_doc'=>$decoded_json_courses_doc,'']);
    }
    /*additional payemnt fee list end here*/ 



      /*Is there any nc's on courses docs and doc's list*/ 
      public function isNcOnCourseDocs($application_id,$course_id)
      {
  
          $results = DB::table('tbl_course_wise_document')
              ->select('application_id', 'course_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
              ->groupBy('application_id', 'course_id', 'doc_sr_code', 'doc_unique_id')
              ->where('course_id', $course_id)
              ->where('application_id', $application_id)
              ->where('approve_status',1)
              ->get();
  
              
              
  
          $additionalFields = DB::table('tbl_course_wise_document')
              ->join(DB::raw('(SELECT application_id, course_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_course_wise_document GROUP BY application_id, course_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                  $join->on('tbl_course_wise_document.application_id', '=', 'sub.application_id')
                      ->on('tbl_course_wise_document.course_id', '=', 'sub.course_id')
                      ->on('tbl_course_wise_document.doc_sr_code', '=', 'sub.doc_sr_code')
                      ->on('tbl_course_wise_document.doc_unique_id', '=', 'sub.doc_unique_id')
                      ->on('tbl_course_wise_document.id', '=', 'sub.max_id');
              })
              ->where('tbl_course_wise_document.application_id',$application_id)
              ->orderBy('tbl_course_wise_document.id', 'desc')
              ->get(['tbl_course_wise_document.application_id', 'tbl_course_wise_document.course_id', 'tbl_course_wise_document.doc_sr_code', 'tbl_course_wise_document.doc_unique_id', 'tbl_course_wise_document.status', 'id', 'admin_nc_flag','approve_status','is_revert']);
  
  
          foreach ($results as $key => $result) {
              $additionalField = $additionalFields->where('application_id', $result->application_id)
                  ->where('course_id', $result->course_id)
                  ->where('doc_sr_code', $result->doc_sr_code)
                  ->where('doc_unique_id', $result->doc_unique_id)
                  // ->where('approve_status',1)
                  ->first();
              if ($additionalField) {
                  $results[$key]->status = $additionalField->status;
                  $results[$key]->id = $additionalField->id;
                  $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                  $results[$key]->approve_status = $additionalField->approve_status;
                  $results[$key]->is_revert = $additionalField->is_revert;
              }
          }
  
          
          $flag = 0;
  
          foreach ($results as $result) {
              if ($result->status == 2 || $result->status == 3 || $result->status == 4) {
                  $flag = 1;
                  break;
              } else {
                  $flag = 0;
                  
              }
          }
  
          
          if ($flag == 1) {
              return true;
          } else {
              return false;
          }
  
      }
  
      public function isNcOnCourseDocsList($application_id,$application_courses_id)
      {
      
          $results = DB::table('tbl_application_course_doc')
              ->select('application_id', 'application_courses_id', DB::raw('MAX(doc_sr_code) as doc_sr_code'), DB::raw('MAX(doc_unique_id) as doc_unique_id'))
              ->groupBy('application_id', 'application_courses_id', 'doc_sr_code', 'doc_unique_id')
              ->where('application_courses_id', $application_courses_id)
              ->where('application_id', $application_id)
              ->where('approve_status',1)
              ->get();
      
              
              
      
          $additionalFields = DB::table('tbl_application_course_doc')
              ->join(DB::raw('(SELECT application_id, application_courses_id, doc_sr_code, doc_unique_id, MAX(id) as max_id FROM tbl_application_course_doc GROUP BY application_id, application_courses_id, doc_sr_code, doc_unique_id) as sub'), function ($join) {
                  $join->on('tbl_application_course_doc.application_id', '=', 'sub.application_id')
                      ->on('tbl_application_course_doc.application_courses_id', '=', 'sub.application_courses_id')
                      ->on('tbl_application_course_doc.doc_sr_code', '=', 'sub.doc_sr_code')
                      ->on('tbl_application_course_doc.doc_unique_id', '=', 'sub.doc_unique_id')
                      ->on('tbl_application_course_doc.id', '=', 'sub.max_id');
              })
              ->where('tbl_application_course_doc.application_id',$application_id)

              ->orderBy('tbl_application_course_doc.id', 'desc')
              ->get(['tbl_application_course_doc.application_id', 'tbl_application_course_doc.application_courses_id', 'tbl_application_course_doc.doc_sr_code', 'tbl_application_course_doc.doc_unique_id', 'tbl_application_course_doc.status', 'id', 'admin_nc_flag','approve_status']);
      
      
          foreach ($results as $key => $result) {
              $additionalField = $additionalFields->where('application_id', $result->application_id)
                  ->where('application_courses_id', $result->application_courses_id)
                  ->where('doc_sr_code', $result->doc_sr_code)
                  ->where('doc_unique_id', $result->doc_unique_id)
                  ->where('approve_status',1)
                  ->first();
              if ($additionalField) {
                  $results[$key]->status = $additionalField->status;
                  $results[$key]->id = $additionalField->id;
                  $results[$key]->admin_nc_flag = $additionalField->admin_nc_flag;
                  $results[$key]->approve_status = $additionalField->approve_status;
              }
          }
      
          
          $flag = 0;
      
          foreach ($results as $result) {
              
              // if (($result->status == 1 && $result->approve_status==1) || ($result->status == 4 && $result->admin_nc_flag == 1)) {
      
              if ($result->status == 2 || $result->status == 3 || $result->status == 4) {
                  $flag = 1;
                  break;
              } else {
                  $flag = 0;
                  
              }
          }
  
          
          
          if ($flag == 1) {
              return true;
          } else {
              return false;
          }
      
      }
      /*end here*/ 
}
