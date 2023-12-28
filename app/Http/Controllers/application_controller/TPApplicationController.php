<?php
namespace App\Http\Controllers\application_controller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Models\TblApplication; 
use App\Models\TblApplicationPayment; 
use App\Models\TblApplicationCourseDoc; 
use App\Models\DocumentRemark;
use App\Models\Application;
use App\Models\Add_Document;
use App\Models\AssessorApplication; 
use App\Models\User; 
use App\Models\Chapter; 
use Carbon\Carbon;
use App\Models\TblNCComments; 
class TPApplicationController extends Controller
{
    public function __construct()
    {
    }
    public function getApplicationList(){
        $application = DB::table('tbl_application as a')
        ->get();
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
        return view('tp-view.application-list',['list'=>$final_data]);
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
        return view('tp-view.application-view',['application_details'=>$final_data,'data' => $user_data,'spocData' => $application,'application_payment_status'=>$application_payment_status]);
    }
    public function upload_document($id, $course_id)
    {
        $tp_id = Auth::user()->id;
        $application_id = $id ? dDecrypt($id) : $id;
        $course_id = $course_id ? dDecrypt($course_id) : $course_id;
        $data = TblApplicationPayment::where('application_id',$application_id)->get();
        $file = DB::table('add_documents')->where('application_id', $application_id)->where('course_id', $course_id)->get();
        $course_doc_uploaded = TblApplicationCourseDoc::where([
            'application_id'=>$application_id,
            'application_courses_id'=>$course_id,
            'tp_id'=>$tp_id
        ])->select('id','doc_unique_id','doc_file_name','doc_sr_code','status')->get();

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
        // dd($final_data);
        $applicationData = TblApplication::find($application_id);
        return view('tp-upload-documents.tp-upload-documents', compact('final_data', 'course_doc_uploaded','application_id','course_id'));
    }
    public function addDocument(Request $request)
    {
       try{
        DB::beginTransaction();
        $tp_id = Auth::user()->id;
        $course_doc = new TblApplicationCourseDoc;
        $course_doc->application_id = $request->application_id;
        $course_doc->application_courses_id = $request->application_courses_id;
        $course_doc->doc_sr_code = $request->doc_sr_code;
        $course_doc->doc_unique_id = $request->doc_unique_id;
        $course_doc->tp_id = $tp_id;
        $course_doc->assessor_type = 'desktop';
        if ($request->hasfile('fileup')) {
            $file = $request->file('fileup');
            $name = $file->getClientOriginalName();
            $filename = time() . $name;
            $file->move('level/', $filename);
            $course_doc->doc_file_name = $filename;
        }
        $course_doc->save();
        if($course_doc){
        DB::commit();
        return response()->json(['success' => true,'message' =>'Document uploaded successfully'],200);
        }else{
            return response()->json(['success' => false,'message' =>'Failed to upload document'],200);
        }
    }
    catch(Exception $e){
        DB::rollback();
        return response()->json(['success' => false,'message' =>'Failed to upload document'],200);
    }
  }
  public function tpDocumentDetails($name, $applicationId, $document_id)
  {
      $data = $name;
      $remarks = DocumentRemark::where('document_id', $document_id)->where('application_id', $applicationId)->get();
      $tpId = Application::find($applicationId);
      $tpId = $tpId->user_id;
      $documentData = Add_Document::find($document_id);
      return view('tp-upload-documents.tp-show-document-details', ['data' => $data, 'remarks' => $remarks, 'application_id' => $applicationId, 'document_id' => $document_id, 'tpId' => $tpId, 'documentData' => $documentData]);
  }
}
