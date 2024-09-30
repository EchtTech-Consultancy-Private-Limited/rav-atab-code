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
    <script>
    @if ($message = Session::get('success'))
       
        toastr.success("{{ $message }}", {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
    @endif
    @if ($message = Session::get('fail'))
       
        toastr.error("{{ $message }}", {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
    @endif
    </script>
    <div class="loading-img d-none" id="loader">
      <div class="box">
         <img src="{{ asset('assets/img/VAyR.gif') }}">
         <h5 class="uploading-text"> Uploading... </h5>
      </div>
   </div>
   <div class="full_screen_loading">Loading&#8230;</div>

   <!-- Overlay For Sidebars -->
   <div class="overlay"></div>
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
                    {{-- @if($is_final_submit)
                        <a href="{{ url('application-course-summaries').'?application='.$spocData->id}}" class="float-left btn btn-primary ">View Final Summary </a>
                    @endif --}}
                    <div class="float-right">
                        <a href="{{ url('level-second/tp/application-list') }}" type="button" class="btn btn-primary">Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-margin-min">
        <div class="previous_refid">
                @if(!empty($spocData->prev_refid))
                @php
                    $text = $spocData->prev_refid;
                    $parts = explode("/", $text);
                    $app_id = explode('-',implode('-',$parts))[2];
                    $lastDigit=0;
                    if($app_id<10){
                        $number = $app_id;
                        $app_id = substr((string)$number, -1);
                    } 
                    
                @endphp

                <span><a href="{{url('tp/application-view'.'/'.dEncrypt($app_id))}}">{{$spocData->prev_refid}}</a></span>
                @endif
            </div>
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


        <div class="card p-3 accordian-card">
            <div class="accordion" id="accordionExample">
                    @foreach ($application_details->course as $k => $ApplicationCourses)
                        <div class="accordion-item <?php if(($ApplicationCourses['course']->status == 1 || $ApplicationCourses['course']->status == 3) ||($ApplicationCourses['isAnyNcOnCourse']==true || $ApplicationCourses['isAnyNcOnCourseDocList']==true)) echo 'border-reject'; else echo ''; ?>">
                            <h2 class="accordion-header" id="heading{{ $k+1 }}">
                                <button class="accordion-button {{$k==0?'':'collapsed'}} <?php echo (($ApplicationCourses['course']->status == 1 || $ApplicationCourses['course']->status == 3) ||($ApplicationCourses['isAnyNcOnCourse']==true || $ApplicationCourses['isAnyNcOnCourseDocList']==true)) ? 'bg-danger text-white' :'bg-transparent text-dark' ;?>"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $k + 1 }}" aria-expanded="true"
                                    aria-controls="collapse{{ $k + 1 }}">
                                    <h5 class="mt-2">
                                        View Course Information Record No: {{ $k + 1 }}
                                    </h5>
                                </button>
                            </h2>
                            <div id="collapse{{ $k + 1 }}" class="accordion-collapse collapse {{$k==0?'show':''}}"
                                aria-labelledby="heading{{ $k + 1 }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
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
                                                    </br><label>{{$ApplicationCourses['course']->mode_of_course}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label><strong>Course Brief</strong></label><br>
                                                    <label>{{ $ApplicationCourses['course']->course_brief ?? '' }}</label>
                                                </div>
                                            </div>
                                        </div>
                    
                                        <div class="row">
                                                <div class="col-md-12 text-table-center">
                                                    <table class="table table-bordered text-left">
                                                        <thead>
                                                        <tr>
                                                            <th class="width-100">S.No.</th>
                                                            <th>Declaration</th>                                   
                                                            <th>Verify Document</th>
                                                            <th>Comments</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($courses_doc->courses_doc as $k=>$course_doc)
                                                            <tr class="document-row">
                                                            <td>{{$k+1}}</td>
                                                            <td>{{$course_doc->name}}</td>      
                                                            <td> 
                                                                <span class="d-flex flex-wrap comon-table">
                                                            @foreach($ApplicationCourses[$course_doc->nc] as $doc)
                                                            <form
                                                                                name="submitform_doc_form_{{$doc->id}}"
                                                                                id="submitform_doc_form_{{$doc->id}}"
                                                                                class="submitform_doc_form"
                                                                                enctype="multipart/form-data">
                                                            
                                                            <input type="hidden" name="application_id" value="{{$spocData->id}}">
                                                            <input type="hidden" name="application_courses_id" value="{{$ApplicationCourses['course']->id}}">
                                                            <input type="hidden" name="doc_sr_code" value="{{$doc->doc_sr_code}}">
                                                            <input type="hidden" name="doc_unique_id" value="{{$doc->doc_unique_id}}">
                                                            
                                                            @if($doc->nc_show_status==0)
                                                            <a target="_blank"
                                                                title="{{$doc->doc_file_name}}"
                                                                href="{{ url('tp-course-document-detail'. '/' . $doc->nc_show_status  . '/' . dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                class="btn btn-primary btn-sm docBtn m-1">
                                                                View</a>
                                                            @elseif($doc->nc_show_status==1)
                                                            <a target="_blank"
                                                                title="{{$doc->doc_file_name}}"
                                                                href="{{ url('tp-course-document-detail'. '/' . $doc->nc_show_status  . '/' . dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                class="btn btn-success btn-sm docBtn  m-1">
                                                                Accepted</span></a>
                                                            @elseif($doc->nc_show_status==2)
                                                            <a target="_blank"
                                                                title="{{$doc->doc_file_name}}"
                                                                href="{{ url('tp-course-document-detail'. '/' . $doc->nc_show_status   . '/' . dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                class="btn btn-danger btn-sm docBtn  m-1">
                                                                
                                                                NC1</span>
                                                            <!-- <img src="{{url('assets/images/nc1.png')}}" alt=""> -->
                                                            </a>
                                                                @if($doc->nc_flag==1)
                                                               
                                                                    <div class="upload-btn-wrapper">
                                                                                    <button class="upld-btn"><i class="fas fa-cloud-upload-alt"></i></button>
                                                                                    <input type="file" class="from-control fileup" name="fileup" id="fileup_{{$doc->id}}" doc-primary-id="{{$doc->id}}" doc-sr-code="{{$doc->doc_sr_code}}"/>
                                                                                </div>
                                                            @endif

                                                            @elseif($doc->nc_show_status==3)
                                                                <a target="_blank"
                                                                    title="{{$doc->doc_file_name}}"
                                                                    href="{{ url('tp-course-document-detail'. '/' . $doc->nc_show_status  . '/' . dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                    class="btn btn-danger btn-sm docBtn  m-1">
                                                                    NC2</span></a>
                                                                    @if($doc->nc_flag==1)
                                                               
                                                                    <div class="upload-btn-wrapper">
                                                                                    <button class="upld-btn"><i class="fas fa-cloud-upload-alt"></i></button>
                                                                                    <input type="file" class="from-control fileup" name="fileup" id="fileup_{{$doc->id}}" doc-primary-id="{{$doc->id}}" doc-sr-code="{{$doc->doc_sr_code}}"/>
                                                                                </div>
                                                                    @endif
                                                                    
                                                            @elseif($doc->nc_show_status==6)
                                                                    <a target="_blank"
                                                                        title="{{$doc->doc_file_name}}"
                                                                        href="{{ url('tp-course-document-detail'. '/' . $doc->nc_show_status.  '/' . dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                        class="btn btn-danger btn-sm docBtn  m-1">
                                                                        Rejected</span></a>

                                                            @elseif($doc->nc_show_status==4)
                                                            @if(in_array($doc->admin_nc_flag,[0,3]) && $doc->is_admin_submit)
                                                            <a target="_blank"
                                                                    title="{{$doc->doc_file_name}}"
                                                                    href="{{ url('tp-course-document-detail'. '/' . $doc->nc_show_status.  '/' . dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                    class="btn btn-danger btn-sm docBtn  m-1">
                                                                    Needs Revision</span></a>
                                                                @else
                                                                    @if(in_array($doc->admin_nc_flag,[1,2,3]) && $doc->is_admin_submit==0)
                                                                    <a target="_blank"
                                                                        title="{{$doc->doc_file_name}}"
                                                                        href="{{ url('tp-course-document-detail'. '/' . $doc->nc_show_status  . '/' . dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                        class="btn btn-primary btn-sm docBtn m-1">
                                                                        View</a>
                                                                    @endif
                                                                @endif

                                                                
                                                                    @if($doc->admin_nc_flag==1 && $doc->is_admin_submit)
                                                                    <a target="_blank"
                                                                    title="{{$doc->doc_file_name}}"
                                                                    href="{{ url('tp-course-document-detail'. '/' . '5/' . dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                    class="btn btn-success btn-sm docBtn docBtn_nc m-1">
                                                                    Accepted <span>By Admin</span></a>
                                                                    @endif

                                                                    @if($doc->admin_nc_flag==2 && $doc->is_admin_submit)
                                                                    <a target="_blank"
                                                                    title="{{$doc->doc_file_name}}"
                                                                    href="{{ url('tp-course-document-detail'. '/' . '6/' . dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                    class="btn btn-danger btn-sm docBtn docBtn_nc  m-1">
                                                                    Rejected <span>By Admin</span></a>
                                                                    @endif
                                                                    @if($doc->nc_flag==1 && ($doc->nc_show_status==4 && $doc->is_admin_submit))
                                                                    <div class="upload-btn-wrapper">
                                                                            <button class="upld-btn"><i class="fas fa-cloud-upload-alt"></i></button>
                                                                            <input type="file" class="from-control fileup" name="fileup" doc-sr-code="{{$doc->doc_sr_code}}" id="fileup_{{$doc->id}}" doc-primary-id="{{$doc->id}}"/>
                                                                        </div>
                                                                        @endif

                                                            @elseif($doc->nc_show_status==5)
                                                                    @if($doc->admin_nc_flag==1)
                                                                    <a 
                                                                    title="{{$doc->doc_file_name}}"
                                                                    href="{{ url('tp-course-document-detail'. '/' . $doc->nc_show_status .'/'. dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                    class="btn btn-success btn-sm docBtn docBtn_nc  m-1">
                                                                    Accepted</a>
                                                                    @endif

                                                                    @if($doc->admin_nc_flag==2)
                                                                    <a 
                                                                    title="{{$doc->doc_file_name}}"
                                                                    href="{{ url('super-admin-reject/verify-doc' . '/' . dEncrypt($doc->doc_sr_code) .'/' . $doc->doc_file_name . '/' . dEncrypt($spocData->id) . '/' . dEncrypt($doc->doc_unique_id).'/'.dEncrypt($ApplicationCourses['course']->id)) }}"
                                                                    class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                                                    Rejected</a>
                                                                    @endif

                                                                    
                                                                    @if($doc->nc_show_status==1)
                                                                    <div class="upload-btn-wrapper">
                                                                        <button class="upld-btn"><i class="fas fa-cloud-upload-alt"></i></button>
                                                                        <input type="file" class="from-control fileup" name="fileup" id="fileup_{{$doc->id}}" doc-primary-id="{{$doc->id}}" doc-sr-code="{{$doc->doc_sr_code}}"/>
                                                                    </div>
                                                                    </div>
                                                                    @endif
                                                                                                        

                                                                @else
                                                                        <div class="upload-btn-wrapper">
                                                                            
                                                                                    <button class="upld-btn"><i class="fas fa-cloud-upload-alt"></i></button>
                                                                                    <input type="file" class="from-control fileup" name="fileup" id="fileup_{{$doc->id}}" doc-primary-id="{{$doc->id}}" doc-sr-code="{{$doc->doc_sr_code}}"/>
                                                                                </div>
                                                                        @endif 
                                                                        {{-- @if($doc->nc_flag==1)
                                                                        
                                                                        <div class="upload-btn-wrapper">
                                                                                    <button class="upld-btn"><i class="fas fa-cloud-upload-alt"></i></button>
                                                                                    <input type="file" class="from-control fileup" name="fileup" id="fileup_{{$doc->id}}" doc-primary-id="{{$doc->id}}" doc-sr-code="{{$doc->doc_sr_code}}"/>
                                                                                </div>
                                                                        @endif --}}

                                                                        </form>
                                                                        @endforeach
                                                                        </span>
                                                                        </td>
                                                                            <td>
                                                                            <button
                                                                        class="expand-button btn btn-primary btn-sm mt-3"
                                                                        onclick="toggleDocumentDetails(this)">Show Comments</button>
                                                                        @if($doc->status==0 && $doc->is_tp_revert==0)
                                                                        <button type="button" class="btn btn-primary btn-sm mt-3" onclick="handleTPRevertAction('{{ $doc->application_id }}', '{{ $doc->course_id }}', '{{ $doc->doc_file_name }}','{{$doc->doc_sr_code}}')">Revert</button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                
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
                                                                        @foreach($ApplicationCourses[$course_doc->comments] as $k=>$nc)
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
                                                                                {{$resultString=="Not Recommended"?"Needs Revision":$resultString}}  
                                                                                </td>
                                                                                <td>{{ucfirst($nc->firstname)}} {{ucfirst($nc->middlename)}} {{ucfirst($nc->lastname)}} ({{$nc->role==5?"Secretariat":"Super Admin"}})</td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </thead>
                                                    </table>
                                                </div>
                                            <!-- Tp Upload doc -->
                                            <div class="col-md-9"></div>
                                                <div class="col-md-3 text-center">
                                                    {{--  @if ($spocData->payment_status == 2 && $spocData->approve_status==1) --}}
                                                            <a href="{{ url('/tp-upload-document-level-2' . '/' . dEncrypt($spocData->id) . '/' .dEncrypt($ApplicationCourses['course']->id) ) }}"
                                                                class="btn text-white bg-primary mb-0"
                                                                style="color: #fff ; line-height: 25px;">Upload
                                                                Documents</a>
                                                        {{-- @endif --}}                           
                                                </div>
                                                <!-- end here -->
                                            </div>                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
               
            </div>
        </div>

        @if(($show_submit_btn_to_tp) && ($application_details->application->approve_status==0 && $application_details->application->level_id==2)) 
        
        <div class="row">
                        <div class="col-md-12">
                            <form action="{{url('tp/update-nc-flag/'.$spocData->id)}}" method="post">
                            @csrf
                            <input type="submit" class="btn btn-info float-right" value="Submit
                            
                            "<?php 
                            if(($enable_disable_submit_btn || $showSubmitBtnToTP) || ($application_details->is_all_revert_action_done44==false || $application_details->is_all_revert_action_done==false)){
                                echo 'disabled';
                            }else{
                                echo '';
                            }
                            
                            ?> >
                            

                            </form>
                        </div>
                    </div>
        @endif











        @if($spocData->is_all_course_doc_verified==1)
        <!-- <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
            <a href="{{ url('/upgrade-new-application', dEncrypt($spocData->id)) }}"
                                                            class="btn btn-warning">Upgrade</a>
            </div>
        </div> -->
        @endif

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
                            <!-- <th>Slip by User</th> -->
                            <th>Slip by Accountant Approver</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($application_details->payment as $key=>$ApplicationPayment)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td class="text-nowrap">{{ \Carbon\Carbon::parse($ApplicationPayment->payment_date)->format('d-m-Y') }}
                            </td>
                            <td>{{ $ApplicationPayment->payment_transaction_no ?? '' }}</td>
                            <td>{{ $ApplicationPayment->payment_reference_no ?? '' }}</td>
                            <!-- <td>{{ $ApplicationPayment->course_count ?? '' }}</td> -->
                            <td>
                                ₹ {{ $ApplicationPayment->amount }}</td>
                            <!-- <td><?php
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
                            </td> -->
                            <td>
                            @if ($ApplicationPayment->status == 0 && $ApplicationPayment->payment_proof_by_account==null)
                                N/A
                                @endif
                                @if ($ApplicationPayment->status == 0 || $ApplicationPayment->status == 1 || $ApplicationPayment->status ==2)
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
                                @if($ApplicationPayment->approve_remark)
                                        {{$ApplicationPayment->approve_remark}}
                                @else
                                    @if($ApplicationPayment->remark_by_account)
                                    {{$ApplicationPayment->remark_by_account}}
                                    @endif
                                @endif

                                @endif
                            </td>
                            <td>
                                @if($ApplicationPayment->tp_update_count < (int)env('TP_PAYMENT_UPDATE_COUNT') && $ApplicationPayment->status!=2)
                                <button class="btn btn-primary btn-xm" data-bs-toggle="modal" data-bs-target="#update_payment_modal" onclick="handleShowPaymentInformation('{{ $ApplicationPayment->payment_transaction_no}}','{{ $ApplicationPayment->payment_reference_no}}',{{$ApplicationPayment->id}})"
                                title="You can update only once"
                                ><i class="fa fa-pencil"></i></button>
                                @else
                                
                                    @if($ApplicationPayment->tp_update_count==(int)env('TP_PAYMENT_UPDATE_COUNT'))
                                    <span class="text-danger payment_update_fn badge badge-danger">
                                    Payment Update Limit Expired
                                    </span>
                                    @else
                                    <span class="text-success payment_update_fn badge badge-success">
                                    Payment Approved
                                    </span>
                                    @endif
                                
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







        <div class="card p-relative">
            <div class="box-overlay">
                <span class="spinner-border"></span>
            </div>
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                   Additional Payment Information
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if (count($application_details->additional_payment) > 0)
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
                            <!-- <th>Slip by User</th> -->
                            <th>Slip by Accountant Approver</th>
                            <th>Remarks</th>
                            <th>Action</th>

                        </tr>
                        @foreach ($application_details->additional_payment as $key=>$ApplicationPayment)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($ApplicationPayment->payment_date)->format('d-m-Y') }}
                            </td>
                            <td>{{ $ApplicationPayment->payment_transaction_no ?? '' }}</td>
                            <td>{{ $ApplicationPayment->payment_reference_no ?? '' }}</td>
                            <!-- <td>{{ $ApplicationPayment->course_count ?? '' }}</td> -->
                            <td>
                                ₹ {{ $ApplicationPayment->amount }}</td>
                            <!-- <td><?php
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
                            </td> -->
                            <td>
                                @if ($ApplicationPayment->status == 0 && $ApplicationPayment->payment_proof_by_account==null)
                                N/A
                                @endif
                                @if ($ApplicationPayment->status ==0 || $ApplicationPayment->status == 1 || $ApplicationPayment->status ==2)
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

                                @if($ApplicationPayment->approve_remark)
                                        {{$ApplicationPayment->approve_remark}}
                                @else
                                    @if($ApplicationPayment->remark_by_account)
                                    {{$ApplicationPayment->remark_by_account}}
                                    @endif
                                @endif


                                @endif
                            </td>
                            <td>
                                
                                @if($ApplicationPayment->account_update_count < (int)env('ACCOUNT_PAYMENT_UPDATE_COUNT') && $ApplicationPayment->status!=2)
                                <button class="btn btn-primary btn-xm" data-bs-toggle="modal" data-bs-target="#update_payment_modal" onclick="handleShowPaymentInformation('{{ $ApplicationPayment->payment_transaction_no}}','{{ $ApplicationPayment->payment_reference_no}}',{{$ApplicationPayment->id}})"
                                title="You can update only once"
                                ><i class="fa fa-pencil"></i></button>

                                @else
                                @if($ApplicationPayment->account_update_count==(int)env('ACCOUNT_PAYMENT_UPDATE_COUNT'))
                                    <span class="text-danger payment_update_fn badge badge-danger">
                                    Payment Update Limit Expired
                                    </span>
                                    @else
                                    <span class="text-success payment_update_fn badge badge-success">
                                    Payment Approved
                                    </span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    <p>No additional payment received</p>
                    @endif
                </div>
            </div>

            @if (isset($ApplicationPayment))
                @if($application_payment_status &&  $application_payment_status->status==1)
                <div class="card" id="payment_apr_card">
                    <div class="card-header bg-white text-dark">
                        <h5 class="mt-2">
                            Payment Process
                        </h5>
                    </div>
                    <div class="card-body">
                        <div>
                        <form  action="#" name="final_payment_approve_form" id="final_payment_approve_form" >
                            <div class="row" >
                                <input type="hidden" name="payment_id" id="payment_id" value="{{$ApplicationPayment->id}}">
                                <div class="col-md-5">
                                    <label for="">Remark<span class="text text-danger">*</span> </label>
                                    <textarea class="form-control remove_err" required name="final_payment_remark" id="final_payment_remark" cols="30" rows="10" placeholder="Please Enter the remark"></textarea>
                                    <span class="err" id="final_payment_remark_err"></span>
                                </div>
                                <div class="col-md-3 mt-4"> 
                                    <button class="btn btn-primary" type="button" onclick="handleAdditionalPaymentApproved()" id="submit_btn_2">Payment Approved
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                @endif
        @endif


        </div>











        <!-- Edit Payment modal  -->
        <div class="modal fade" id="update_payment_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Payment Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <input type="hidden" id="payment_info_id" value="">
                </div>
                <div class="modal-body">
                <div class="mb-3">
                        <label for="payment_transaction_no" class="form-label">Payment Transaction no<span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control remove_err placeholder_fn_size" maxlength='18' id="payment_transaction_no" placeholder="Please enter payment transaction number" onkeyup="handleTransactionNumberValidationDebounce()">
                        <span class="err" id="payment_transaction_no_err"></span>
                </div>
                <div class="mb-3">
                        <label for="payment_reference_no" class="form-label">Payment Reference no<span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control remove_err placeholder_fn_size" maxlength='18' id="payment_reference_no" placeholder="Please enter payment reference number" onkeyup="handleReferenceNumberValidationDebounce()">
                        <span class="err" id="payment_reference_no_err"></span>
                </div>
                <div class="mb-3">
                        <label for="payment_proof" class="form-label">Slip by User</label>
                        <input type="file" class="form-control" id="payment_proof">
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="handleUpdatePaymentInformation()" id="update-payment_info" class="btn btn-primary">Update</button>
                </div>
                </div>
            </div>
            </div>
        <!-- end here edit payment modal -->
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

<script>
      $(document).ready(function() {
          $('.fileup').change(function() {
              const fileInput = $(this);
              const doc_primary_id = fileInput.attr('doc-primary-id');
              const doc_sr_code  = fileInput.attr('doc-sr-code');
              const form = $('#submitform_doc_form_' + doc_primary_id)[0];
              const formData = new FormData(form);
              let allowedExtensions="";
              let uploadedFileName="";
              let fileExtension="";
              if(doc_sr_code=="co03"){
              allowedExtensions = ['xlsx', 'xls', 'xlsb']; // Add more extensions if needed
              uploadedFileName = fileInput.val();
              fileExtension = uploadedFileName.split('.').pop().toLowerCase();
              }else{
              allowedExtensions = ['pdf', 'doc', 'docx']; // Add more extensions if needed
              uploadedFileName = fileInput.val();
              fileExtension = uploadedFileName.split('.').pop().toLowerCase();
              }
              

              if (allowedExtensions.indexOf(fileExtension) == -1) {
                if(doc_sr_code=="co03"){
                    toastr.error("Please upload a xls file.", "Invalid File type",{
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                }else{
                    toastr.error("Please upload a PDF or DOC file.", "Invalid File type",{
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: true,
                        closeDuration: 5000,
                    });
                }
                
                  // Clear the file input
                  fileInput.val('');
                  return;
              }
              $("#loader").removeClass('d-none');
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
             
              $.ajax({
                  url: `${BASE_URL}/tp-course-add-document`, // Your server-side upload endpoint
                  type: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(response) {
                      $("#loader").addClass('d-none');
                      if (response.success) {
                        toastr.success(response.message, {
                            timeOut: 0,
                            extendedTimeOut: 0,
                            closeButton: true,
                            closeDuration: 5000,
                        });
                          location.reload();
                      }
                  },
                  error: function(xhr, status, error) {
                      // Handle errors
                      console.error(error);
                  }
              });
          });
      });
   </script>
    @include('layout.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>