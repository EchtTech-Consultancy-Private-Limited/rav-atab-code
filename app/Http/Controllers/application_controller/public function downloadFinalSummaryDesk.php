 public function downloadFinalSummaryDesktopAssessor($application_id)
    {
        $assessor_id = Auth::user()->id;
        $application_id = dDecrypt($application_id);
        $summeryReport = DB::table('assessor_summary_reports as asr')
            ->select('asr.application_id', 'asr.application_course_id', 'asr.assessor_id', 'asr.assessor_type', 'asr.object_element_id', 'app.person_name', 'app.id', 'app.uhid', 'app.created_at as app_created_at', 'app_course.course_name', 'usr.firstname', 'usr.middlename', 'usr.lastname')
            ->leftJoin('tbl_application as app', 'app.id', '=', 'asr.application_id')
            ->leftJoin('tbl_application_courses as app_course', 'app_course.id', '=', 'asr.application_course_id')
            ->leftJoin('users as usr', 'usr.id', '=', 'asr.assessor_id')
            ->where([
                'asr.application_id' => $application_id,
                // 'asr.application_course_id' => $application_course_id,
                'app_course.application_id' => $application_id,
                // 'app_course.id' => $application_course_id,
                'asr.assessor_type' => 'desktop',
            ])
            ->first();
        $assessor_assign = DB::table('tbl_assessor_assign')->where(['application_id' => $application_id, 'assessor_id' => $assessor_id, 'assessor_type' => 'desktop'])->first();
        /*count the no of mandays*/
        $no_of_mandays = DB::table('assessor_assigne_date')->where(['assessor_Id' => $assessor_id, 'application_id' => $application_id])->count();


        $get_all_courses = DB::table('tbl_application_courses')->where('application_id', $application_id)->whereIn('status', [0, 2])->get();
        $original_data = [];
        
        foreach($get_all_courses as $key => $course) {
        $assesor_distinct_report = DB::table('assessor_summary_reports as asr')
        ->select('asr.application_id', 'asr.assessor_id', 'asr.object_element_id')
        ->where('asr.assessor_type', 'desktop')
        ->where([
            'asr.application_id' => $application_id,
            'asr.assessor_id' => $assessor_id,
            'asr.application_course_id' => $course->id
        ])
        ->whereIn('asr.nc_raise_code', ['NC1', 'NC2', 'Reject'])
        ->groupBy('asr.application_id', 'asr.assessor_id', 'asr.object_element_id')
        ->get()
        ->pluck('object_element_id');
            
        $questions = DB::table('questions')->whereIn('id', $assesor_distinct_report)->get();
        
        $final_data=[];

        foreach ($questions as $question) {
            $obj = new \stdClass;
            $obj->title = $question->title;
            $obj->code = $question->code;
            $value = TblNCComments::where([
                'application_id' => $application_id,
                'application_courses_id' => $course->id,
                'doc_unique_id' => $question->id,
                'assessor_id' => $assessor_id,
                'doc_sr_code' => $question->code,
            ])
                ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                ->get();
            $value1 = TblNCComments::where([
                'application_id' => $application_id,
                'application_courses_id' => $course->id,
                'doc_unique_id' => $question->id,
                'doc_sr_code' => $question->code,
                'assessor_type' => 'admin',
                'final_status' => 'desktop'
            ])
                ->select('tbl_nc_comments.*', 'users.firstname', 'users.middlename', 'users.lastname')
                ->leftJoin('users', 'tbl_nc_comments.assessor_id', '=', 'users.id')
                ->get();
            $accept_reject = TblNCComments::where([
                'application_id' => $application_id,
                'application_courses_id' => $course->id,
                'doc_unique_id' => $question->id,
                'doc_sr_code' => $question->code
            ])
                ->select('tbl_nc_comments.*')
                ->whereIn('assessor_type', ['desktop', 'admin'])
                ->where(function ($query) {
                    $query->where('assessor_type', 'desktop')
                        ->orWhere('assessor_type', 'admin')
                        ->whereIn('nc_type', ['Accept', 'Reject']);
                })
                ->first();
            $obj->nc = $value;
            $obj->nc_admin = $value1;
            $obj->accept_reject = $accept_reject;
            $final_data[] = $obj;
        }
        $original_data[$course->course_name] = $final_data;

     }

        $summary_remark = DB::table('assessor_final_summary_reports')->where(['application_id'=>$application_id])->first()->remark;
        
        $assessement_way = DB::table('asessor_applications')->where(['application_id' => $application_id])->get();

        
        $pdf = PDF::loadView('assessor-summary.desktop-download-final-summary', compact('summeryReport', 'no_of_mandays', 'final_data', 'assessement_way', 'assessor_assign','summary_remark','original_data'));

        $file_name = 'desktop-'.$summeryReport->uhid.'.pdf';
        return $pdf->download($file_name);
    }