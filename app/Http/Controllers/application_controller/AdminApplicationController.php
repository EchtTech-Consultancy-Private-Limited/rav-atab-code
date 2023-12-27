<?php

namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Models\TblApplication; 
use App\Models\AssessorApplication; 
use App\Models\User; 
use Carbon\Carbon;
class AdminApplicationController extends Controller
{
    public function __construct()
    {

    }
    
    public function getApplicationList(){

        $application = DB::table('tbl_application as a')
        ->whereIn('payment_status',[1,2,3])
        ->get();

        
        // $application = DB::table('tbl_application')
        // ->where(['assessor_id'=>null])
        // ->get();


        $desktop_assessor_list = DB::table('users')->where(['assessment'=>1,'role'=>3])->orderBy('id', 'DESC')->get();
        $desktop_assessor_pluck = DB::table('users')->where(['assessment'=>1,'role'=>3])->where(['assessment'=>2,'role'=>3])->orderBy('id', 'DESC')->pluck(
            'id'
        )->toArray();
        
        $onsite_assessor_list = DB::table('users')->where(['assessment'=>2,'role'=>3])->orderBy('id', 'DESC')->get();

        $secretariatdata = DB::table('users')->where('role', '5')->orderBy('id', 'DESC')->get();

        foreach($application as $app){
            $obj = new \stdClass;
            $obj->application_list= $app;
    
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $app->id,
                ])->count();
                if($course){
                    $obj->course_count = $course;
                }
                
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                ])->latest('created_at')->first();
                $payment_amount = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                ])->sum('amount');
                $payment_count = DB::table('tbl_application_payment')->where([
                    'application_id' => $app->id,
                ])->count();
                if($payment){
                    $obj->payment = $payment;
                    $obj->payment->payment_count = $payment_count;
                    $obj->payment->payment_amount = $payment_amount ;
                }
                $final_data[] = $obj;
                
        }
        return view('admin-view.application-list',['list'=>$final_data, 'assessor_list' => $desktop_assessor_list,'secretariatdata' => $secretariatdata,'assessor_pluck'=>$desktop_assessor_pluck]);
    }
    /** Whole Application View for Account */
    public function getApplicationView($id){

        $application = DB::table('tbl_application')
        ->where('id', dDecrypt($id))
        ->first();
       
        $user_data = DB::table('users')->where('users.id',  $application->tp_id)->select('users.*', 'cities.name as city_name', 'states.name as state_name', 'countries.name as country_name')->join('countries', 'users.country', '=', 'countries.id')->join('cities', 'users.city', '=', 'cities.id')->join('states', 'users.state', '=', 'states.id')->first();
        
        $application_payment_status = DB::table('tbl_application_payment')->where('application_id', '=', $application->id)->latest('id')->first();
            $obj = new \stdClass;
            $obj->application= $application;
    
                $course = DB::table('tbl_application_courses')->where([
                    'application_id' => $application->id,
                ])->get();
                if($course){
                    $obj->course = $course;
                }
                $payment = DB::table('tbl_application_payment')->where([
                    'application_id' => $application->id,
                ])->get();
                if($payment){
                    $obj->payment = $payment;
                }
                $final_data = $obj;
        return view('admin-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status]);
    }


    public function adminPaymentAcknowledge(Request $request)
    {

        try{
            $application = TblApplication::find($request->post('application_id'));
            $is_exists = DB::table('tbl_application_payment')->where('aknowledgement_id',null)->first();
            if(!$is_exists){
                return response()->json(['success' =>false,'message'=>'Payment Acknowledgement Already Done'], 409);
            }
            DB::beginTransaction();
            DB::table('tbl_application_payment')->update(['aknowledgement_id' => auth()->user()->id]);
            DB::commit();
            return response()->json(['success' => true,'message' => 'Payment acknowledged successfully'], 200);
        }
        catch(Exception $e){
            DB::rollBack();
            return response()->json(['success' =>false,'message'=>'Failed to make acknowledged payment'], 500);
        }

    }


    public function assignAssessor(Request $request){
        try{
          
            DB::beginTransaction();
            $data = [];
            $data['application_id']=$request->application_id;
            $data['assessor_id']=$request->assessor_id;
            $data['course_id']=$request->course_id??null;
            $data['assessor_type']=$request->assessor_type??'desktop';
            $data['due_date']=Carbon::now()->addDay(15);

            $is_assign_assessor_date = DB::table('tbl_assessor_assign')->where(['application_id'=>$request->application_id,'assessor_id'=>$request->assessor_id,'assessor_type'=>$request->assessor_type])->first();

            if($is_assign_assessor_date!=null){
                $update_assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id'=>$request->application_id,'assessor_id'=>$request->assessor_id,'assessor_type'=>$request->assessor_type])->update($data);
            }else{
                $create_assessor_assign = DB::table('tbl_assessor_assign')->insert($data);
            }
            

           

            if($request->assessor_type==="desktop"){
                $assessment_type = 1;
            }else{
                $assessment_type = 2;
            }

            if ($request->assessment_type == 2) {

                $data = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessor_id', '=', $request->assessor_radio)->count()  > 0;
    
                if ($data == false) {
    
                    $value = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessment_type', '=', '2')->count() > 0;
    
                    if ($value == false) {
    
                        $data = new asessor_application();
                        $data->assessor_id = $request->assessor_radio;
                        $data->application_id = $request->application_id;
                        $data->status = 1;
                        $data->assessment_type = $request->assessment_type;
                        $data->due_date = $due_date = Carbon::now()->addDay(15);
                        $data->notification_status = 0;
                        $data->read_by = 0;
                        $data->assessment_way = $request->on_site_type;
                        $data->save();
                        return  back()->with('success', 'Application has been successfully assigned to assessor');
                    } else {
                        $item = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessment_type', '=', '2')->first();
    
                        $data = asessor_application::find($item->id);
                        $data->assessor_id = $request->assessor_radio;
                        $data->application_id = $request->application_id;
                        $data->status = 1;
                        $data->assessment_type = $request->assessment_type;
                        $data->due_date = $due_date = Carbon::now()->addDay(15);
                        $data->notification_status = 0;
                        $data->read_by = 0;
                        $data->assessment_way = $request->on_site_type;
                        $data->save();
                        return  back()->with('success', 'Application has been successfully assigned to assessor');
                    }
                } else {
    
    
                    $value = DB::table('asessor_applications')->where('application_id', '=', $request->application_id)->where('assessor_id', '=', $request->assessor_radio)->first();
    
                    //dd($value);
                    $data = asessor_application::find($value->id);
                    $data->assessor_id = $request->assessor_radio;
                    $data->application_id = $request->application_id;
                    $data->status = 1;
                    $data->assessment_type = $request->assessment_type;
                    $data->due_date = $due_date = Carbon::now()->addDay(15);
                    $data->notification_status = 0;
                    $data->read_by = 0;
                    $data->assessment_way = $request->on_site_type;
                    $data->save();

                    DB::commit();
                    return redirect()->route('admin-app-list')->with('success', 'Application has been successfully assigned to assessor');
                }
            } else {
    
                AssessorApplication::where('application_id', $request->application_id)->delete();
    
                $assessor = $request->assessor_id;
    
                $newApplicationAssign = new AssessorApplication;
                $newApplicationAssign->application_id = $request->application_id;
                $newApplicationAssign->assessment_type = $request->assessment_type;
                $newApplicationAssign->assessor_id = $assessor;
                $newApplicationAssign->status = 1;
    
                $newApplicationAssign->notification_status = 0;
                $newApplicationAssign->read_by = 0;
    
    
    
                $newApplicationAssign->save();
                $superadminEmail = 'superadmin@yopmail.com';
                $adminEmail = 'admin@yopmail.com';
    
                $mailData = [
                    'from' => "Admin",
                    'applicationNo' => $request->application_id,
                    'applicationStatus' => "Admin Assigned Application to Assessor Successfully",
                    'subject' => "Application Assigned",
                ];
    
                // Mail::to([$superadminEmail, $adminEmail])->send(new SendMail($mailData));
    
    
                $assessor_email = User::select('email')->where('id', $assessor)->first();
    
                $mailData = [
                    'from' => "Admin",
                    'applicationNo' => $request->application_id,
                    'applicationStatus' => "Admin Assigned Application to Assessor Successfully",
                    'subject' => "Application Assigned",
                ];
    
                // Mail::to($assessor_email)->send(new SendMail($mailData));
    
    
                DB::commit();
                return redirect()->route('admin-app-list')->with('success', 'Application has been successfully assigned to assessor');
            }
          
        }
        catch(Exception $e){
            DB::rolback();
            return redirect()->back()->with('fail', $e->getMessage());
        }







      
    }
}

