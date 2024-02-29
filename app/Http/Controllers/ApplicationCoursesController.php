<?php
namespace App\Http\Controllers;
use App\Http\Traits\PdfImageSizeTrait;
use App\Http\Controllers\Controller;
use App\Models\ApplicationCourse;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Country;
use App\Models\TblApplication;
use App\Models\TblApplicationCourses;
use App\Models\TblApplicationPayment;
use App\Models\LevelInformation;
use Carbon\Carbon;
use Session;
use App\Jobs\SendEmailJob;

class ApplicationCoursesController extends Controller
{
    use PdfImageSizeTrait;

    public function createNewApplication(Request $request,$id=null){
        if ($id) {
            $applicationData = DB::table('tbl_application')->where('id', dDecrypt($id))->first();
        } else {
            $applicationData = null;
        }
        $id = Auth::user()->id;
        $item = LevelInformation::whereid('1')->get();
        $data = DB::table('users')->where('users.id', $id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        return view('create-application.create-application', ['data' => $data, 'applicationData' => $applicationData, 'item' => $item]);
    }
    public function  storeNewApplication(Request $request)
    {
        $this->validate(
            $request,
            [
                // 'Email_ID' => ['required', 'regex:/^(?!.*[@]{2,})(?!.*\s)[a-zA-Z0-9\+_\-]+(\.[a-zA-Z0-9\+_\-]+)*@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/i', 'unique:applications,Email_ID'],
                'Email_ID' => ['required', 'regex:/^(?!.*[@]{2,})(?!.*\s)[a-zA-Z0-9\+_\-]+(\.[a-zA-Z0-9\+_\-]+)*@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/i'],
                'Contact_Number' => 'required|numeric|min:10|digits:10,Contact_Number',
                'Person_Name' => 'required',
                'designation' => 'required',
            ],
            [
                'Email_ID.regex' => "Please Enter a Valid Email Id.",
                'Email_ID.required' => "Please Enter an Email Id.",
            ]
        );
        $currentDateTime = Carbon::now();
        $application_date = Carbon::now()->addDays(366);
        /*check if application already created*/
            
            if($request->application_id && $request->previous_data==1){
                $data = [];
                $data['level_id'] = 1;
                $data['tp_id'] = $request->user_id;
                $data['person_name'] = $request->Person_Name;
                $data['email'] =  $request->Email_ID;
                $data['contact_number'] = $request->Contact_Number;
                $data['designation'] = $request->designation;
                $data['tp_ip'] = getHostByName(getHostName());
                $data['user_type'] = 'tp';
                $data['application_date'] = $application_date;
                $create_new_application = DB::table('tbl_application')->where('id',$request->application_id)->update($data);
                $create_new_application = $request->application_id;
                $msg="Application Updated Successfully";
            }else{
                $data = [];
                $data['level_id'] = 1;
                $data['tp_id'] = $request->user_id;
                $data['person_name'] = $request->Person_Name;
                $data['email'] =  $request->Email_ID;
                $data['contact_number'] = $request->Contact_Number;
                $data['designation'] = $request->designation;
                $data['tp_ip'] = getHostByName(getHostName());
                $data['user_type'] = 'tp';
                $data['application_date'] = $application_date;

                $application = new TblApplication($data);
                $application->save();

                $create_new_application = $application->id;
                // $create_new_application = DB::table('tbl_application')->insertGetId($data);
                $msg="Application Created Successfully";
            }
        /*end here*/
        return redirect(url('create-new-course/' . dEncrypt($create_new_application)))->with('success', $msg);
    }

    public function getApplicationCourses(Request $request){
        return view('welcome');
    }
    public function getApplicationFees(Request $request){
        return view('welcome');
    }
    public function getApplicationDocuments(Request $request){
        return view('welcome');
    }
    public function createNewCourse($id = null)
    {
       
        $id = dDecrypt($id);
        // dd($id);
        if ($id) {
            $applicationData = DB::table('tbl_application')->where('id', $id)->first();
        }else{
            $applicationData=null;
        }
        $course = TblApplicationCourses::where('application_id', $id)->get();
        return view('create-application.course.create-course', compact('applicationData', 'course'));
    }
    public function storeNewApplicationCourse(Request $request)
    {
        // dd($request->all());
        $course_name = $request->course_name;
        $lowercase_course_name = array_map('strtolower', $course_name);
        $is_course_name_already_exists =TblApplicationCourses::where(['application_id' => $request->application_id,'deleted_at'=>null])->whereIn('course_name', $lowercase_course_name)->get();
        if(count($is_course_name_already_exists)>0){
            return  redirect('create-new-course/' . dEncrypt($request->application_id))->with('fail', 'Course name already exists on this application');
        }
        $value_counts = array_count_values($lowercase_course_name);
            foreach ($value_counts as $value => $count) {
                if ($count > 1) {
                    return  redirect('create-new-course/' . dEncrypt($request->application_id))->with('fail', 'Failed to create course with same course name');
                }
            }
        $course_duration = $request->course_duration;
        $eligibility = $request->eligibility;
        $mode_of_course = $request->mode_of_course;
        $course_brief = $request->course_brief;
        $level_id = $request->level_id;
        $years = $request->years;
        $months = $request->months;
        $days = $request->days;
        $hours = $request->hours;
        $user_id = Auth::user()->id;
        //document upload
        if ($request->hasfile('doc1')) {
            $doc1 = $request->file('doc1');
        }
        if ($request->hasfile('doc2')) {
            $doc2 = $request->file('doc2');
        }
        if ($request->hasfile('doc3')) {
            $doc3 = $request->file('doc3');
        }
        for ($i = 0; $i < count($course_name); $i++) {
            if (empty($course_name[$i])) {
                continue;
            }
            $file = new TblApplicationCourses();
            $file->application_id = $request->application_id;
            $file->course_name = $course_name[$i];
            $file->course_duration_y = $years[$i];
            $file->course_duration_m = $months[$i];
            $file->course_duration_d = $days[$i];
            $file->course_duration_h = $hours[$i];
            $file->level_id = $request->level_id;
            $file->eligibility = $eligibility[$i];
            $file->mode_of_course = collect($mode_of_course[$i + 1])->implode(',');
            $file->course_brief = $course_brief[$i];
            $file->tp_id = Auth::user()->id;
            $doc_size_1 = $this->getFileSize($request->file('doc1')[$i]->getSize());
            $doc_extension_1 = $request->file('doc1')[$i]->getClientOriginalExtension();
            $doc_size_2 = $this->getFileSize($request->file('doc2')[$i]->getSize());
            $doc_extension_2 = $request->file('doc2')[$i]->getClientOriginalExtension();
            $doc_size_3 = $this->getFileSize($request->file('doc3')[$i]->getSize());
            $doc_extension_3 = $request->file('doc3')[$i]->getClientOriginalExtension();
            $name = $doc1[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc1[$i]->move('documnet/', $filename);
            $file->declaration_pdf =  $filename;
            $doc2 = $request->file('doc2');
            $name = $doc2[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc2[$i]->move('documnet/', $filename);
            $file->course_curriculum_pdf =  $filename;
            $img = $request->file('doc3');
            $name = $doc3[$i]->getClientOriginalName();
            $filename = time() . $name;
            $doc3[$i]->move('documnet/', $filename);
            $file->course_details_xsl =  $filename;
            $file->pdf_1_file_size = $doc_size_1 ;
            $file->pdf_1_file_extension =$doc_extension_1;
            $file->pdf_2_file_size = $doc_size_2 ;
            $file->pdf_2_file_extension =$doc_extension_2;
            $file->xls_file_size = $doc_size_3 ;
            $file->xls_file_extension =$doc_extension_3;
            $file->save();
        }
        $session_for_redirection = $request->form_step_type;
        Session::put('session_for_redirections', $session_for_redirection);
        $session_for_redirections = Session::get('session_for_redirections');
        if ($request->level_id == '1') {
            return  redirect('create-new-course/' . dEncrypt($file->application_id))->with('success', 'Course  successfully  Added');
        } elseif ($request->level_id == '2') {
            return  redirect('level-first/' . encrypt($file->application_id))->with('success', 'Course  successfully  Added');
        } elseif ($request->level_id == '3') {
            return  redirect('level-list')->with('success', 'Course successfully Added');
        } else {
            return  redirect('create-new-course/' . dEncrypt($file->application_id))->with('success', 'Course successfully Added');
        }
    }
    public function showcoursePayment(Request $request, $id = null)
    {
        $id = dDecrypt($id);
       
        $checkPaymentAlready = DB::table('tbl_application_payment')->where('application_id', $id)->count();
       
        if ($checkPaymentAlready>1) {
                return redirect(url('get-application-list'))->with('fail', 'Payment has already been submitted for this application.');
        }
   

        if ($id) {
            $applicationData = DB::table('tbl_application')->where('id', $id)->first();
            $course = DB::table('tbl_application_courses')->where('application_id', $id)->get();
            if (Auth::user()->country == $this->get_india_id()) {
                if (count($course) == '0') {
                    $currency = '₹';
                    $total_amount = '0';
                } elseif (count($course) <= 5) {
                    $currency = '₹';
                    $total_amount = '1000';
                } elseif (count($course) <= 10) {
                    $currency = '₹';
                    $total_amount =  '2000';
                } else {
                    $currency = '₹';
                    $total_amount =   '3000';
                }
            } elseif (in_array(Auth::user()->country, $this->get_saarc_ids())) {
                if (count($course) == '0') {
                    $currency = 'US $';
                    $total_amount = '0';
                } elseif (count($course) <= 5) {
                    $currency = 'US $';
                    $total_amount =  '15';
                } elseif (count($course) <= 10) {
                    $currency = 'US $';
                    $total_amount = '30';
                } else {
                    $currency = 'US $';
                    $total_amount =  '45';
                }
            } else {
                if (count($course) == '0') {
                    $currency = 'US $';
                    $total_amount = '';
                } elseif (count($course) <= 5) {
                    $currency = 'US $';
                    $total_amount = '50';
                } elseif (count($course) <= 10) {
                    $currency = 'US $';
                    $total_amount = '100';
                } else {
                    $currency = 'US $';
                    $total_amount =  '150';
                }
            }
        }
        return view('create-application.course-payment.show-course-payment', compact('applicationData', 'course', 'currency', 'total_amount'));
    }
    
    public function getCourseList(Request $request)
    {
        $item = LevelInformation::whereid('1')->get();
        $ApplicationCourse = TblApplicationCourses::whereid($request->id)->where('tp_id',Auth::user()->id)->wherelevel_id($item[0]->id)->first();
        // dd($ApplicationCourse);
        return response()->json(['ApplicationCourse' => $ApplicationCourse]);
    }
    public function deleteCourseById($id)
    {
        $res = TblApplicationCourses::find(dDecrypt($id))->delete();
        if($res){
            return back()->with('success', 'Course Delete successfull');
        }else{
            return back()->with('fail', 'Failed to delete course');
        }
    }
    public function newApplicationPayment(Request $request)
    {

        $get_all_account_users = DB::table('users')->whereIn('role',[1,6])->get()->pluck('email')->toArray();
        $get_all_admin_users = DB::table('users')->where('role',1)->get()->pluck('email')->toArray();

        $request->validate([
            'transaction_no' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:application_payments,transaction_no',
            'reference_no' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:application_payments,reference_no',
            'payment' => 'required',
        ], [
            'transaction_no.required' => 'The transaction number is required.',
            'transaction_no.unique' => 'The transaction number is already in use.',
            'transaction_no.regex' => 'The transaction number must not contain special characters or spaces.',
            'reference_no.required' => 'The reference number is required.',
            'reference_no.unique' => 'The reference number is already in use.',
            'reference_no.regex' => 'The reference number must not contain special characters or spaces.',
            'payment.required' => 'Please select a payment mode.'
        ]);
       try{
        DB::beginTransaction();
        $transactionNumber = trim($request->transaction_no);
        $referenceNumber = trim($request->reference_no);
        $is_exist_t_num_or_ref_num = DB::table('tbl_application_payment')
                                    ->where('payment_transaction_no', $transactionNumber)
                                    ->orWhere('payment_reference_no', $referenceNumber)
                                    ->first();
        
        if(!empty($is_exist_t_num_or_ref_num)){
            return  back()->with('fail', 'Reference number or Transaction number already exists');
        }

        /*Implemented by suraj*/
          $get_final_summary = DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->Application_id,'payment_status'=>0,'assessor_type'=>'desktop'])->first();
          if(!empty($get_final_summary)){
            DB::table('assessor_final_summary_reports')->where('application_id',$request->Application_id)->update(['payment_status' => 1]);
          }
        /*end here*/
        $checkPaymentAlready = TblApplicationPayment::where('application_id', $request->Application_id)
        ->whereNull('remark_by_account')
        ->count();
            if ($checkPaymentAlready>2) {
                return redirect(url('get-application-list'))->with('fail', 'Payment has already been submitted for this application.');
            }
        $this->validate($request, [
            'payment_details_file' => 'mimes:pdf,jpeg,png,jpg,gif,svg',
        ]);
        $item = new TblApplicationPayment;
        $item->level_id = $request->level_id;
        $item->user_id = Auth::user()->id;
        $item->amount = $request->amount;
        $item->payment_date = date("d-m-Y");
        $item->payment_mode = $request->payment;
        $item->payment_transaction_no = $transactionNumber;
        $item->payment_reference_no = $referenceNumber;
        // $item->currency = $request->currency;
        $item->application_id = $request->Application_id;
        if ($request->hasfile('payment_details_file')) {
            $img = $request->file('payment_details_file');
            $name = $img->getClientOriginalName();
            $filename = time() . $name;
            $img->move('uploads/', $filename);
            $item->payment_proof = $filename;
        }
        $item->save();
        DB::table('assessor_final_summary_reports')->where(['application_id'=>$request->Application_id])->update(['second_payment_status' => 1]);

        $application_id = $request->Application_id;
        $userid = Auth::user()->firstname;
        if ($request->level_id == '1') {
            foreach ($request->course_id as $items) {
                $ApplicationCourse = TblApplicationCourses::where('id',$items);
                $ApplicationCourse->update(['payment_status' =>1]);
            }
            
            /**
             * Send Email to Accountant
             * */ 
            foreach($get_all_account_users as $email){
                $title="New Application Created - Welcome Aboard : RAVAP-".$application_id;
                $subject="New Application Created - Welcome Aboard : RAVAP-".$application_id;
                
                $body="Dear Team,".PHP_EOL."
                I trust this message finds you well. I am writing to request the approval of the payment associated with my recent application for RAVAP-".$application_id." submitted on ".date('d-m-Y').". As part of the application process, a payment of Rs.".$request->amount." was made under the transaction reference ID ".$referenceNumber.". ".PHP_EOL."
                Here are the transaction details: ".PHP_EOL."
                Transaction ID: ".$transactionNumber." ".PHP_EOL."
                Payment Amount: ".$request->amount." ".PHP_EOL."
                Payment Date: ".date("Y-m-d", strtotime($request->payment_date))." ".PHP_EOL."
                
                Best regard,".PHP_EOL."
                RAV Team";

                $details['email'] = $email;
                $details['title'] = $title; 
                $details['subject'] = $subject; 
                $details['body'] = $body; 
                dispatch(new SendEmailJob($details));
            }

            foreach($get_all_admin_users as $email){
                $title="New Application Created | RAVAP-".$application_id;
                $subject="New Application Created | RAVAP-".$application_id;
                $body="Dear Team,".PHP_EOL."

                We are thrilled to inform you that your application has been successfully processed, and we are delighted to welcome you to our RAVAP family! Your dedication and skills have truly impressed us, and we are excited about the positive impact we believe you will make.".PHP_EOL."
               Best regard,".PHP_EOL."
               RAV Team";

                $details['email'] = $email;
                $details['title'] = $title; 
                $details['subject'] = $subject; 
                $details['body'] = $body; 
                dispatch(new SendEmailJob($details));
            }

            //tp email
               $body = "Dear ,".Auth::user()->firstname." ".PHP_EOL."
               We are thrilled to inform you that your application has been successfully processed, and we are delighted to welcome you to our RAVAP family! Your dedication and skills have truly impressed us, and we are excited about the positive impact we believe you will make. ".PHP_EOL."
               Best regards,".PHP_EOL."
               RAV Team";

                $details['email'] = Auth::user()->email;
                $details['title'] = "Payment Approval | RAVAP-".$application_id; 
                $details['subject'] = "Payment Approval | RAVAP-".$application_id; 
                $details['body'] = $body; 
                dispatch(new SendEmailJob($details));
           
            /*send email end here*/ 
            DB::commit();
            return  redirect()->route('application-list')->with('success', 'Payment Done successfully');
        } elseif ($request->level_id == '2') {
            return  redirect('level-first')->with('success', 'Course  successfully  Added');
            foreach ($request->course_id as $items) {
                $ApplicationCourse = TblApplicationCourses::where('id',$items);
                $ApplicationCourse->update(['payment_status' =>1]);
            }
            DB::commit();
            return  redirect('/level-second')->with('success', 'Payment Done successfully');;
        } elseif ($request->level_id == '3') {
            foreach ($request->course_id as $item) {
                $ApplicationCourse = ApplicationCourse::find($item);
                $ApplicationCourse->payment = 'True';
                $ApplicationCourse->status = '1';
                $ApplicationCourse->update();
            }
            $ApplicationCourse->save();
            DB::commit();
            return  redirect('/level-third')->with('success', ' Payment Done successfully');
        } else {
            return  redirect('/level-fourth')->with('success', 'Payment Done successfully');
        }
       }
       catch(Exception $e){
        DB::rollback();
        return  redirect('/level-fourth')->with('success', 'Payment Done successfully');
       }
    }
    public function getApplicationList()
    {
        $collection = TblApplication::latest()->get();
        $filteredApplications = [];
        foreach ($collection as $application) {
            $paymentAvailable = TblApplicationPayment::where('application_id', $application->id)->first();
            if (isset($paymentAvailable)) {
                $filteredApplications[] = $application;
            }
        }
        return view('create-application.get-application-list', ['collection' => $filteredApplications]);
    }
    
    public function course_edit(Request $request)
    {
        $item = LevelInformation::whereid('1')->get();
        $ApplicationCourse = TblApplicationCourses::whereid($request->id)->wheretp_id(Auth::user()->id)->wherelevel_id($item[0]->id)->get();
        $course_mode = ['1' => 'Online', '2' => 'Offline', '3' => 'Hybrid'];
        return response()->json(['ApplicationCourse' => $ApplicationCourse]);
    }

    public function course_update(Request $request, $id)
    {
        $Document = TblApplicationCourses::whereid($id)->get();
        if ($request->hasfile('doc1')) {
            $file_size1 = $request->file('doc1')->getSize();
            $doc1 = $request->file('doc1');
            $data = TblApplicationCourses::find($Document[0]->id);
            $old_file_name = $data->declaration_pdf;
            $name = $doc1->getClientOriginalName();
            $filename = time() . $name;
            $doc1->move('documnet/', $filename);
            $data->declaration_pdf =  $filename;
            $data->save();
            if (file_exists(public_path() . '/documnet/'.$old_file_name)) {
                unlink(public_path() . '/documnet/'.$old_file_name);
            } 
        }
        if ($request->hasfile('doc2')) {
            $file_size2 = $request->file('doc2')->getSize();
            $doc2 = $request->file('doc2');
            $data = TblApplicationCourses::find($Document[0]->id);
            $old_file_name = $data->course_curriculum_pdf;
            $name = $doc2->getClientOriginalName();
            $filename = time() . $name;
            $doc2->move('documnet/', $filename);
            $data->	course_curriculum_pdf =  $filename;
            $data->save();
            if (file_exists(public_path() . '/documnet/'.$old_file_name)) {
                unlink(public_path() . '/documnet/'.$old_file_name);
            } 
        }
        if ($request->hasfile('doc3')) {
            $file_size3 = $request->file('doc3')->getSize();
            $doc3 = $request->file('doc3');
            $data = TblApplicationCourses::find($Document[0]->id);
            $old_file_name = $data->course_details_xsl;
            $name = $doc3->getClientOriginalName();
            $filename = time() . $name;
            $doc3->move('documnet/', $filename);
            $data->course_details_xsl =  $filename;
            $data->save();
            if (file_exists(public_path() . '/documnet/'.$old_file_name)) {
                unlink(public_path() . '/documnet/'.$old_file_name);
            } 
        }
        $file = TblApplicationCourses::find($id);
        $file->course_name = $request->Course_Names;
        $file->mode_of_course = collect($request->mode_of_course)->implode(',');
        $file->course_brief = $request->course_brief;
        $file->course_duration_y = $request->years;
        $file->course_duration_m = $request->months;
        $file->course_duration_d = $request->days;
        $file->course_duration_h = $request->hours;
        $file->eligibility = $request->Eligibilitys;
        if($request->hasfile('doc1')){
            $doc_size_1 = $this->getFileSize($file_size1);
            $doc_extension_1 = $request->file('doc1')->getClientOriginalExtension();
            $file->pdf_1_file_size = $doc_size_1;
            $file->pdf_1_file_extension =$doc_extension_1;
        }
        if($request->hasfile('doc2')){
            $doc_size_2 = $this->getFileSize($file_size2);
            $doc_extension_2 = $request->file('doc2')->getClientOriginalExtension();
            $file->pdf_2_file_size = $doc_size_2;
            $file->pdf_2_file_extension =$doc_extension_2;
        }
        if($request->hasfile('doc3')){
            $doc_size_3 = $this->getFileSize($file_size3);
            $doc_extension_3 = $request->file('doc3')->getClientOriginalExtension();
            $file->xls_file_size = $doc_size_3 ;
            $file->xls_file_extension =$doc_extension_3;
        }
        $file->save();
        return back()->with('success', 'Course Update successfully');
    }
    function get_india_id()
    {
        $india = Country::where('name', 'India')->get('id')->first();
        return $india->id;
    }
}