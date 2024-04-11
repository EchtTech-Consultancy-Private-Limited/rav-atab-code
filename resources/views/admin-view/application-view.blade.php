@include('layout.header')
<title>
    RAV Accreditation Previous Applications View</title>
<link rel="stylesheet" type="text/css"
    href="https://rawgithub.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
    
 

</head>

<body class="light">
    <div class="overlay"></div>
    @include('layout.topbar')
    <div>
        @if (Auth::user()->role == '1')
        @include('layout.sidebar')
        @elseif(Auth::user()->role == '2')
        @include('layout.siderTp')
        @elseif(Auth::user()->role == '3')
        @include('layout.sideAss')
        @elseif(Auth::user()->role == '4')
        @include('layout.sideprof')
        @elseif(Auth::user()->role == '5')
        @include('layout.secretariat')
        @elseif(Auth::user()->role == '6')
        @include('layout.sidbarAccount')
        @endif
        @include('layout.rightbar')
    </div>
    @if ($message = Session::get('success'))
    <script>
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: "Success",
        text: "{{ $message }}",
        showConfirmButton: false,
        timer: 3000
    })
    </script>
    @endif
    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Application</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{ url('/dashboard') }}">
                                <i class="fas fa-home"></i> level</a>
                        </li>
                        <li class="breadcrumb-item active"> View Previous Applications </li>
                    </ul>
                    @if($is_final_submit)
                        <a href="{{ url('application-course-summaries') . '?application=' . $spocData->id}}" class="float-left btn btn-primary btn-sm">View Final Summary 
                        </a>
                    @endif
                    <div class="float-right">
                        <a href="{{ url('admin/application-list') }}" type="button" class="btn btn-primary">Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row form-margin-min">
            <div class="col-md-8 pr-2">
            <div class="card h-181">
            <div class="card-header bg-white text-dark d-flex justify-content-between align-items-center">
                <h5 class="mt-2">
                    Basic Information
                </h5>
                <div>
                    <span style="font-weight: bold;" class="mr-3">Reference ID:</span> {{ $spocData->refid }} &nbsp;&nbsp;&nbsp;
                    <span style="font-weight: bold;">Application ID:</span> {{ $spocData->uhid }}
                </div>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Name : </strong></label>
                                <label>{{ $data->title ?? '' }} {{ $data->firstname ?? '' }}
                                    {{ $data->middlename ?? '' }} {{ $data->lastname ?? '' }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Email :</strong></label>
                                <label>{{ $data->email ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Mobile Number :</strong></label>
                                <label>{{ $data->mobile_no ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Designation :</strong></label>
                                <label>{{ $data->designation ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label><strong>Country :</strong></label>
                                        <label>{{ $data->country_name ?? '' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>State : </strong></label>
                                <label>{{ $data->state_name ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>City :</strong></label>
                                <label>{{ $data->city_name ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Postal Code :</strong></label>
                                <label>{{ $data->postal ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Organization/Institute Name : </strong></label>
                                <label>{{ $data->organization ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Address :</strong></label>
                                <label>{{ $data->address ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
            <div class="col-md-4 pl-0">
            <div class="card">
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                    Single Point of Contact Details (SPoC)
                </h5>
            </div>
            <div class="card-body fixed-label-w">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Person Name :</strong></label>

                                <label>{{ $spocData->person_name }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Contact Number :</strong></label>
                                {{ $spocData->contact_number ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Email Id :</strong></label>
                                <label>{{ $spocData->email ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Designation :</strong></label>
                                {{ $spocData->designation ?? '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>

      
       
        @foreach ($application_details->course as $k => $ApplicationCourses)
            
        <div class="card">
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                    View Course Information Record No: {{ $k + 1 }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Course Name</strong></label><br>
                                <label>{{ $ApplicationCourses['course']->course_name }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Course Duration</strong></label><br>
                                {{ $ApplicationCourses['course']->course_duration_y ?? '' }} Years(s)
                                {{ $ApplicationCourses['course']->course_duration_m ?? '' }} Month(s)
                                {{ $ApplicationCourses['course']->course_duration_d ?? '' }} Day(s)
                                {{ $ApplicationCourses['course']->course_duration_h ?? '' }} Hour(s)
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Eligibility</strong></label><br>
                                <label>{{ $ApplicationCourses['course']->eligibility ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Mode of Course</strong></label>
                                <label> {{$ApplicationCourses['course']->mode_of_course}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Course Brief</strong></label><br>
                                <label>{{ $ApplicationCourses['course']->course_brief ?? '' }}</label>
                            </div>
                        </div>
                    </div>



                <div class="row">
                    <div class="col-md-12 text-table-center">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th class="width-100">S.No.</th>
                                    <th>Declaration</th>                                   
                                    <th>Verfiy Document</th>
                                    <th>Comments</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="document-row">
                                    <td>1</td>
                                    <td>Declaration</td>                             
                                    <td> 
                                        
                                          @foreach($ApplicationCourses['course_wise_document_declaration'] as $doc)




                                @if($doc->status==0)
                                       <a 
                                        title="{{$doc->doc_file_name}}"
                                        href="{{ url('secretariat-view/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                        class="btn btn-primary btn-sm docBtn m-1">
                                        View</a>
                                        @elseif($doc->status==1)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('secretariat-accept/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                             class="btn btn-success btn-sm docBtn m-1">
                                             Accepted</a>
                                    @elseif($doc->status==2)
                                    <a 
                                        title="{{$doc->doc_file_name}}"
                                        href="{{ url('secretariat-nc1/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                        class="btn btn-danger btn-sm docBtn m-1">
                                        NC1</a>
                                        @elseif($doc->status==3)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('secretariat-nc2/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                             class="btn btn-danger btn-sm docBtn m-1">
                                             NC2</a>
                                        @elseif($doc->status==4)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('secretariat-nr/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                             class="btn btn-danger btn-sm docBtn m-1">
                                              Not Recommended</a>
                                              <!-- admin accept/reject -->
                                              @if($doc->admin_nc_flag==1)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('secretariat-accept/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                             class="btn btn-success btn-sm docBtn docBtn_nc m-1">
                                             Accepted <span>By Admin</span></a>
                                             @endif

                                             @if($doc->admin_nc_flag==2)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('secretariat-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Rejected <span>By Admin</span></a>
                                             @endif
                                             <!-- end here -->
                                             @elseif($doc->status==6)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('secretariat-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                             class="btn btn-danger btn-sm docBtn m-1">
                                             Rejected</a>
                                    @else
                                       <div class="upload-btn-wrapper">
                                                <button class="upld-btn"><i class="fas fa-cloud-upload-alt"></i></button>
                                                <input type="file" class="from-control fileup" name="fileup" id="fileup_{{$question['question']->id}}" data-question-id="{{$question['question']->id}}" />
                                             </div>
                                    @endif 

                                          @endforeach
                                        
                                        
                                        
                                    
                                    </td>
                                        <td>
                                                  <button
                                                   class="expand-button btn btn-primary btn-sm mt-3"
                                                   onclick="toggleDocumentDetails(this)">Show Comments</button>
                                    </td>
                                </tr>
                                <!-- accordion -->
                            <tr class="document-details" style="display: none">
                                             <td colspan="4">
                                                <table>
                                                   <thead>
                                                      <tr>
                                                         <th class="width-100">Sr. No.</th>
                                                         <th>Document Code</th>
                                                         <th>Date</th>
                                                         <th>Comments</th>
                                                         <th>Status Code</th>
                                                         <th>Approved/Rejected By</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                    @foreach($ApplicationCourses['nc_comments_course_declaration'] as $k=>$nc)
                                                   <tr class="text text-{{$nc->nc_type=='Accept'?'success':'danger'}}" style="border-left:3px solid red">

                                                         <td>{{$k+1}}</td>
                                                         <td>{{$nc->doc_sr_code}}</td>
                                                         <td>{{date('d-m-Y',strtotime($nc->created_at))}}</td>
                                                         <td>{{$nc->comments}}</td>
                                                         <td>
                                                         @php
                                                            $string = $nc->nc_type;
                                                            $explodedArray = explode("_", $string);
                                                            $capitalizedArray = array_map('ucfirst', $explodedArray);
                                                            $resultString = implode(" ", $capitalizedArray);
                                                         @endphp
                                                         {{$resultString}} 
                                                         </td>
                                                         <td>{{ucfirst($nc->firstname)}} {{ucfirst($nc->middlename)}} {{ucfirst($nc->lastname)}} (Secretariat)</td>
                                                      </tr>
                                                    @endforeach
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                <tr class="document-row">
                                    <td>2</td>
                                    <td>Course Curriculum / Material / Syllabus</td>                             
                                    <td>

                                    @foreach($ApplicationCourses['course_wise_document_curiculum'] as $doc)

                                            @if($doc->status==0)
                                                <a 
                                                    title="{{$doc->doc_file_name}}"
                                                    href="{{ url('secretariat-view/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                    class="btn btn-primary btn-sm docBtn m-1">
                                                    View</a>
                                                    @elseif($doc->status==1)
                                                    <a 
                                                        title="{{$doc->doc_file_name}}"
                                                        href="{{ url('secretariat-accept/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                        class="btn btn-success btn-sm docBtn m-1">
                                                        Accepted</a>
                                                @elseif($doc->status==2)
                                                <a 
                                                    title="{{$doc->doc_file_name}}"
                                                    href="{{ url('secretariat-nc1/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                    class="btn btn-danger btn-sm docBtn m-1">
                                                    NC1</a>
                                                    @elseif($doc->status==3)
                                                    <a 
                                                        title="{{$doc->doc_file_name}}"
                                                        href="{{ url('secretariat-nc2/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                        class="btn btn-danger btn-sm docBtn m-1">
                                                        NC2</a>
                                                    @elseif($doc->status==4)
                                                    <a 
                                                        title="{{$doc->doc_file_name}}"
                                                        href="{{ url('secretariat-nr/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                        class="btn btn-danger btn-sm docBtn m-1">
                                                        Not Recommended</a>
                                                        <!-- admin accept/reject -->
                                                        @if($doc->admin_nc_flag==1)
                                                        <a 
                                                        title="{{$doc->doc_file_name}}"
                                                        href="{{ url('secretariat-accept/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                        class="btn btn-success btn-sm docBtn docBtn_nc m-1">
                                                        Accepted <span>By Admin</span></a>
                                                        @endif

                                                        @if($doc->admin_nc_flag==2)
                                                        <a 
                                                        title="{{$doc->doc_file_name}}"
                                                        href="{{ url('secretariat-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                        class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                                        Rejected <span>By Admin</span></a>
                                                        @endif
                                                        <!-- end here -->
                                                        @elseif($doc->status==6)
                                                    <a 
                                                        title="{{$doc->doc_file_name}}"
                                                        href="{{ url('secretariat-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                        class="btn btn-danger btn-sm docBtn m-1">
                                                        Rejected</a>
                                                @else
                                                <div class="upload-btn-wrapper">
                                                            <button class="upld-btn"><i class="fas fa-cloud-upload-alt"></i></button>
                                                            <input type="file" class="from-control fileup" name="fileup" id="fileup_{{$question['question']->id}}" data-question-id="{{$question['question']->id}}" />
                                                        </div>
                                                @endif 

                                                    @endforeach
                                    </td>
                                    <td>
                                                 <button
                                                   class="expand-button btn btn-primary btn-sm mt-3"
                                                   onclick="toggleDocumentDetails(this)">Show Comments</button>
                                    </td>
                                </tr>
                                <!-- accordion -->
                            <tr class="document-details" style="display: none">
                                             <td colspan="4">
                                                <table>
                                                   <thead>
                                                      <tr>
                                                         <th>Sr. No.</th>
                                                         <th>Document Code</th>
                                                         <th>Date</th>
                                                         <th>Comments</th>
                                                         <th>Status Code</th>
                                                         <th>Approved/Rejected By</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                   @foreach($ApplicationCourses['nc_comments_course_curiculam'] as $k=>$nc)
                                                   <tr class="text text-{{$nc->nc_type=='Accept'?'success':'danger'}}" style="border-left:3px solid red">

                                                         <td>{{$k+1}}</td>
                                                         <td>{{$nc->doc_sr_code}}</td>
                                                         <td>{{date('d-m-Y',strtotime($nc->created_at))}}</td>
                                                         <td>{{$nc->comments}}</td>
                                                         <td>
                                                         @php
                                                            $string = $nc->nc_type;
                                                            $explodedArray = explode("_", $string);
                                                            $capitalizedArray = array_map('ucfirst', $explodedArray);
                                                            $resultString = implode(" ", $capitalizedArray);
                                                         @endphp
                                                         {{$resultString}} 
                                                         </td>
                                                         <td>{{ucfirst($nc->firstname)}} {{ucfirst($nc->middlename)}} {{ucfirst($nc->lastname)}} (Secretariat)</td>
                                                      </tr>
                                                    @endforeach
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                <tr class="document-row">
                                    <td>3</td>
                                    <td>Course Details (Excel format)</td>                             
                                    <td>
                                    @foreach($ApplicationCourses['course_wise_document_details'] as $doc)
                                        @if($doc->status==0)
                                            <a 
                                                title="{{$doc->doc_file_name}}"
                                                href="{{ url('secretariat-view/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                class="btn btn-primary btn-sm docBtn m-1">
                                                View</a>
                                                @elseif($doc->status==1)
                                                <a 
                                                    title="{{$doc->doc_file_name}}"
                                                    href="{{ url('secretariat-accept/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                    class="btn btn-success btn-sm docBtn m-1">
                                                    Accepted</a>
                                            @elseif($doc->status==2)
                                            <a 
                                                title="{{$doc->doc_file_name}}"
                                                href="{{ url('secretariat-nc1/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                class="btn btn-danger btn-sm docBtn m-1">
                                                NC1</a>
                                                @elseif($doc->status==3)
                                                <a 
                                                    title="{{$doc->doc_file_name}}"
                                                    href="{{ url('secretariat-nc2/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                    class="btn btn-danger btn-sm docBtn m-1">
                                                    NC2</a>
                                                @elseif($doc->status==4)
                                                <a 
                                                    title="{{$doc->doc_file_name}}"
                                                    href="{{ url('secretariat-nr/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                    class="btn btn-danger btn-sm docBtn m-1">
                                                    Not Recommended</a>
                                                    <!-- admin accept/reject -->
                                                    @if($doc->admin_nc_flag==1)
                                                    <a 
                                                    title="{{$doc->doc_file_name}}"
                                                    href="{{ url('secretariat-accept/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                    class="btn btn-success btn-sm docBtn docBtn_nc m-1">
                                                    Accepted <span>By Admin</span></a>
                                                    @endif

                                                    @if($doc->admin_nc_flag==2)
                                                    <a 
                                                    title="{{$doc->doc_file_name}}"
                                                    href="{{ url('secretariat-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                    class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                                    Rejected <span>By Admin</span></a>
                                                    @endif
                                                    <!-- end here -->
                                                    @elseif($doc->status==6)
                                                <a 
                                                    title="{{$doc->doc_file_name}}"
                                                    href="{{ url('secretariat-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $spocData->id . '/' . $doc->doc_unique_id.'/'.$ApplicationCourses['course']->id) }}"
                                                    class="btn btn-danger btn-sm docBtn m-1">
                                                    Rejected</a>
                                            @else
                                            <div class="upload-btn-wrapper">
                                                        <button class="upld-btn"><i class="fas fa-cloud-upload-alt"></i></button>
                                                        <input type="file" class="from-control fileup" name="fileup" id="fileup_{{$question['question']->id}}" data-question-id="{{$question['question']->id}}" />
                                                    </div>
                                            @endif 

                                                @endforeach
                                    </td>
                                    <td>
                                                 <button
                                                   class="expand-button btn btn-primary btn-sm mt-3"
                                                   onclick="toggleDocumentDetails(this)">Show Comments</button>
                                    </td>
                                </tr>
                            <!-- accordion -->
                            <tr class="document-details" style="display: none">
                                             <td colspan="4">
                                                <table>
                                                   <thead>
                                                      <tr>
                                                         <th>Sr. No.</th>
                                                         <th>Document Code</th>
                                                         <th>Date</th>
                                                         <th>Comments</th>
                                                         <th>Status Code</th>
                                                         <th>Approved/Rejected By</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>

                                                   @foreach($ApplicationCourses['nc_comments_course_details'] as $k=>$nc)
                                                   <tr class="text text-{{$nc->nc_type=='Accept'?'success':'danger'}}" style="border-left:3px solid red">

                                                         <td>{{$k+1}}</td>
                                                         <td>{{$nc->doc_sr_code}}</td>
                                                         <td>{{date('d-m-Y',strtotime($nc->created_at))}}</td>
                                                         <td>{{$nc->comments}}</td>
                                                         <td>
                                                         @php
                                                            $string = $nc->nc_type;
                                                            $explodedArray = explode("_", $string);
                                                            $capitalizedArray = array_map('ucfirst', $explodedArray);
                                                            $resultString = implode(" ", $capitalizedArray);
                                                         @endphp
                                                         {{$resultString}} 
                                                         </td>
                                                         <td>{{ucfirst($nc->firstname)}} {{ucfirst($nc->middlename)}} {{ucfirst($nc->lastname)}} (Secretariat)</td>
                                                      </tr>
                                                    @endforeach
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>


                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{url('secretariat/update-nc-flag/'.$spocData->id.'/'.$ApplicationCourses['course']->id)}}" method="post">
                            @csrf
                            <input type="submit" class="btn btn-info float-right" value="Submit">
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        </div>  
        @endforeach

        <div class="card p-relative">
            <div class="box-overlay">
                <span class="spinner-border"></span>
            </div>
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                    Payment Information
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if (count($application_details->payment) > 0)
                    <table class="table table-bordered">
                        <tr>
                            <th>
                                S.No.
                            </th>
                            <th>
                                Payment Date
                            </th>
                            <th>
                                Payment Transaction no
                            </th>
                            <th>
                                Payment Reference no
                            </th>
                            <!-- <th>Total Courses</th> -->
                            <th>Amount</th>
                            <th>Slip by User</th>
                            <th>Slip by Approver</th>
                            <th>Remarks</th>
                        </tr>
                        @foreach ($application_details->payment as $key => $ApplicationPayment)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($ApplicationPayment->payment_date)->format('d-m-Y') }}
                            </td>
                            <td>{{ $ApplicationPayment->payment_transaction_no ?? '' }}</td>
                            <td>{{ $ApplicationPayment->payment_reference_no ?? '' }}</td>
                            <!-- <td>{{ $ApplicationPayment->course_count ?? '' }}</td> -->
                            <td>
                                ₹ {{ $ApplicationPayment->amount }}</td>
                            <td><?php
        substr($ApplicationPayment->payment_proof, -3);
        $data = substr($ApplicationPayment->payment_proof, -3);
                                        ?>
                                @if ($data == 'pdf')
                                <a href="{{ asset('uploads/' . $ApplicationPayment->payment_proof) }}" target="_blank"
                                    title="Document 3" id="docpdf3" download>
                                    <i class="fa fa-download mr-2"></i> Payment pdf
                                </a>
                                @else
                                @if (isset($ApplicationPayment->payment_proof))
                                <a target="_blank" class="image-link"
                                    href="{{ asset('uploads/' . $ApplicationPayment->payment_proof) }}">
                                    <img src="{{ asset('uploads/' . $ApplicationPayment->payment_proof) }}"
                                        style="width:100px;height:70px;">
                                </a>
                                @endif
                                @endif
                            </td>
                            <td>
                                
                            @if ($ApplicationPayment->status == 0)
                                N/A
                                @endif
                                @if ($ApplicationPayment->status == 1 || $ApplicationPayment->status == 2)
                                @if (!$ApplicationPayment->payment_proof_by_account)
                                File not available!
                                @endif
                                <?php
            substr($ApplicationPayment->payment_proof_by_account, -3);
            $data = substr($ApplicationPayment->payment_proof_by_account, -3);
                                                ?>
                                @if ($data == 'pdf')
                                <a href="{{ asset('documnet/' . $ApplicationPayment->payment_proof_by_account) }}" target="_blank"
                                    title="Document 3" id="docpdf3" download>
                                    <i class="fa fa-download mr-2"></i>Payment pdf 
                                </a>
                                @else
                                @if (isset($ApplicationPayment->payment_proof_by_account))
                                <a target="_blank" class="image-link"
                                    href="{{ asset('documnet/' . $ApplicationPayment->payment_proof_by_account) }}">
                                    <img src="{{ asset('documnet/' . $ApplicationPayment->payment_proof_by_account) }}"
                                        style="width:100px;height:70px;">
                                </a>
                                @endif
                                @endif
                                @endif
                            </td>
                            <td>
                                @if ($ApplicationPayment->status == 0)
                                    Remark not available!
                                @else
                                {{ $ApplicationPayment->approve_remark }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    <p>Payment has not been completed yet.</p>
                    @endif
                </div>
            </div>

        </div>

        </div>
    </section>
    <script>
      function toggleDocumentDetails(button) {
          const documentRow = button.closest('.document-row');
          console.log(documentRow,' button')
          const documentDetails = documentRow.nextElementSibling;
          if (documentDetails && (documentDetails.classList.contains('document-details'))) {
              if (documentDetails.style.display == 'none' || documentDetails.style.display == '') {
                  documentDetails.style.display = 'table-row';
                  button.textContent = 'Hide Comments';
              } else {
                  documentDetails.style.display = 'none';
                  button.textContent = 'Show Comments';
              }
          }
      }
   </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("paymentApproveForm"); // Change this to your form's actual ID
        const submitBtn = document.getElementById(
            "paymentApproveButton"); // Change this to your button's actual ID
        form.addEventListener("submit", function() {
            submitBtn.disabled = true; // Disable the button when the form is submitted
        });
    });
    </script>
    <script>
    function confirm_option() {
        Swal.fire({
            title: 'Do you want to approve this payment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve payment & add remarks',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.btn-payment-approval').attr('disabled', true);
                var anchorLink = document.querySelector('.btn-payment-approval').getAttribute('href');
                window.location.href = anchorLink;
            }
        });
        return false;
    }
    </script>
    <script>
    $(document).ready(function() {
        $('.image-link').magnificPopup({
            type: 'image',
            mainClass: 'mfp-with-zoom',
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true,
                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function
                opener: function(openerElement) {
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });
    });
    $(".payment_alert").click(function() {
        alert('Document is pending for approval from Accounts department')
    });
    </script>
    <script>
    $('.payment_details_file').on('click', function() {
        alert('Payment confirmation is mandatory.Kindly upload a reference file to proceed.')
    });
    </script>
    @include('layout.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>