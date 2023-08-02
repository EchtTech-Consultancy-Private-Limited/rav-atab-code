 @include('layout.header')
 <!-- New CSS -->
 <link rel="stylesheet" href="{{ asset('assets/css/form.min.css') }}" class="js">

 <style>
     @media (min-width: 900px) {
         .modal-dialog {
             max-width: 674px;
         }
     }

     .mr-2 {
         margin-right: 10px;
     }

     .form-group {
    margin-bottom: 10px;
}

.card{
    margin-bottom: 12px;
}
div#ui-datepicker-div {
    background: #fff;
/*    padding: 12px 15px 5px;*/
    border-radius: 10px;
    width: 310px;
    box-shadow: 0 5px 5px 0 rgba(44, 44, 44, 0.2);
}

.ui-datepicker-header.ui-widget-header.ui-helper-clearfix.ui-corner-all {
    display: flex;
    justify-content: space-between;
}

.payment-status.d-flex {
    align-items: center;
    width: 250px;
}

 </style>




 <title>RAV Accreditation</title>

 </head>

 <body class="light">
     <!-- Page Loader -->
     <div class="page-loader-wrapper">
         <div class="loader">
             <div class="m-t-30">
                 <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
             </div>
             <p>Please wait...</p>
         </div>
     </div>
     <!-- #END# Page Loader -->
     <!-- Overlay For Sidebars -->
     <div class="overlay"></div>
     <!-- #END# Overlay For Sidebars -->
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
         @endif
         @include('layout.rightbar')
     </div>
     <section class="content">
         <div class="container-fluid">

             <div class="block-header">
                 <div class="row">
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                         <ul class="breadcrumb breadcrumb-style ">
                             <li class="breadcrumb-item">
                                 <h4 class="page-title">

                                    Manage Applications


                                 </h4>

                             </li>
                             <li class="breadcrumb-item bcrumb-1">
                                 <a href="{{ url('/dashboard') }}">
                                     <i class="fas fa-home"></i> Home</a>
                             </li>
                             <li class="breadcrumb-item active">


                                @if (request()->path() == 'level-first')

                                Level First

                                @elseif(request()->path() == 'level-second')

                                Level Second

                                @elseif(request()->path() == 'level-third')

                                Level Third

                                @elseif(request()->path() == 'level-fourth')

                                Level Fourth

                                @endif

                             </li>
                         </ul>
                     </div>
                 </div>
             </div>

             <div class="row clearfix">
                 <div class="col-lg-12 col-md-12">
                     <div class="card">
                         <div class="profile-tab-box">
                             <div class="p-l-20">
                                 <ul class="nav ">
                                     <li class="nav-item tab-all">
                                         <a class="nav-link show active" href="#general_information"
                                             data-bs-toggle="tab" >General Information</a>
                                     </li>

                                     <li class="nav-item tab-all" >
                                         <a class="nav-link show" href="#pending_payment_list"
                                             data-bs-toggle="tab">Pending Payment List</a>
                                     </li>

                                     <li class="nav-item tab-all p-l-20">
                                         <a class="nav-link" href="#preveious_application" data-bs-toggle="tab">Previous
                                             Applications</a>
                                     </li>

                                     <li class="nav-item tab-all p-l-20">
                                         <a class="nav-link " href="#new_application" data-bs-toggle="tab">New
                                             Application</a>
                                     </li>
                                     
                                     <li class="nav-item tab-all p-l-20">
                                         <a class="nav-link" href="#faqs" data-bs-toggle="tab">FAQs</a>
                                     </li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                     @if (Session::has('success'))
                         <div class="alert alert-success" style="padding: 15px;" role="alert">
                             {{ session::get('success') }}
                         </div>
                     @elseif(Session::has('fail'))
                         <div class="alert alert-danger" role="alert">
                             {{ session::get('fail') }}
                         </div>
                     @endif

                      @if (count($errors) > 0)
                          <div class="alert alert-danger">
                             <ul>
                               @foreach ($errors->all() as $error)
                                 <li>{{ $error }}</li>
                               @endforeach
                            </ul>
                          </div>
                        @endif

{{--

                     @if (Session::has('success'))

                           @if( session::get('success') == 'Course  successfully  Added!!!!' )

                              @php

                              $active = 'active'

                              @endphp

                              @php
                                    $unactives = ''
                              @endphp



                          @endif

                        @else
                          @php
                          $unactives = 'active'
                           @endphp

                          @php   $active = ''      @endphp

                     @endif --}}

                     <div class="tab-content">

                        <div role="tabpanel" class="tab-pane" id="pending_payment_list" aria-expanded="true">
                             <div class="row clearfix">
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                     <div class="card project_widget">
                                         <div class="header">
                                         </div>
                                          <div class="body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover js-basic-example contact_list">
                                                        <thead>
                                                            <tr>

                                                                <th class="center"> Application ID </th>
<!--                                                                <th class="center"> Create User ID </th>-->
                                                                <th class="center"> Level ID </th>
                                                                <th class="center"> Country </th>
                                                                <th class="center"> Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @isset($level_list_data)

                                                                <tr>

                                                                    @foreach ($level_list_data as $item_level_list)

                                                                    @if(checktppaymentstatus($item_level_list->id) == 0)

                                                                        <td class="center">  RAVAP-{{ 4000 + $item_level_list->id }}</td></td>
<!--                                                                        <td class="center"> {{ $item_level_list->user_id ?? '' }}</td>-->
                                                                        <td class="center"> {{ $item_level_list->level_id ?? '' }}</td>
                                                                        <td class="center"> {{ $item_level_list->country_name ?? '' }}</td>

                                                                        <td class="center"> <a href="{{ url('/level-first'.'/'.$item_level_list->id) }}"
                                                                                class="btn btn-tbl-edit bg-success"><i
                                                                                    class="fa fa-edit"></i></a></td>

                                                                    @endif

                                                                </tr>
                                                                @endforeach

                                                            @endisset

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                     </div>
                                 </div>
                             </div>
                        </div>

                         <div role="tabpanel" class="tab-pane active" id="general_information" aria-expanded="true">
                             <div class="row clearfix">
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                     <div class="card project_widget">
                                         <div class="header">
                                         </div>
                                         <div class="body">
                                             <div class="row">
                                                 <div class="col-md-4 col-6 b-r">
                                                     <h5> <strong>Validity </strong></h5>
                                                     <p class="text-muted">{{ $item[0]->validity }}</p>
                                                 </div>
                                                 <div class="col-md-4 col-6 b-r">
                                                     <h5> <strong>Fee Structure </strong></h5>
                                                     <p class="text-muted">{{ $item[0]->fee_structure }}</p><br>

                                                     @if($item[0]->Fee_Structure_pdf != "")

                                                     <a target="_blank" href="{{ url('show-pdf'.'/'.$item[0]->Fee_Structure_pdf) }}"
                                                         title="level Information pdf"><i
                                                             class="fa fa-download mr-2"></i> PDF Fee Structure pdf</a>




                                                     @endif


                                                     <br>
                                                 </div>
                                                 <div class="col-md-4 col-6 b-r">
                                                     <h5> <strong>Timelines </strong></h5>
                                                     <p class="text-muted"> {{ $item[0]->timelines }}</p>
                                                 </div>
                                             </div>
                                             <br>
                                             <h5>Level Information</h5>
                                             <p>{{ $item[0]->level_Information }}</p><br>

                                             @if($item[0]->level_Information_pdf != "")

                                             <a target="_blank" href="{{ url('show-pdf'.'/'.$item[0]->level_Information_pdf) }}"
                                                 title="level Information pdf"><i
                                                     class="fa fa-download mr-2"></i> PDF level Information pdf </a>

                                              @endif

                                             <br><br>
                                             <h5>Prerequisites</h5>
                                             <p>{{ $item[0]->Prerequisites }}</p><br>

                                             <br>

                                             @if($item[0]->Prerequisites_pdf != "")

                                             <a target="_blank" href="{{ url('show-pdf'.'/'.$item[0]->Prerequisites_pdf) }}"
                                                 title="level Information pdf"><i
                                                     class="fa fa-download mr-2"></i> PDF Prerequisites pdf </a>

                                            @endif

                                            <br>


                                             <br>
                                             <h5>Documents Required</h5>
                                             <p>{{ $item[0]->documents_required }}</p><br>
                                             <br>

                                             @if($item[0]->documents_required_pdf != "")

                                             <a target="_blank" href="{{ url('show-pdf'.'/'.$item[0]->documents_required_pdf) }}"
                                                  title="level Information pdf"><i
                                                      class="fa fa-download mr-2"></i> PDF Documents Required pdf </a>

                                             @endif


                                             <br>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <!-- <div role="tabpanel" class="tab-pane" id="timeline" aria-expanded="false">
                                        </div> -->
                         <div role="tabpanel" class="tab-pane " id="new_application" aria-expanded="false">


                         {{--
                             <form action="{{ url('/new-application') }}" method="post" class="form wizard"
                                 id="regForm" enctype="multipart/form-data"> --}}
                             <div class="tab-content p-relative">

                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <li class="progress1 bg_green">Basic Information</li>
                                    <li class="progress2">Level Courses</li>
                                    <li class="progress3">Payment</li>
                                </ul>

                                 <div class="tab-pane active" role="tabpanel" id="step1">
                                     <div class="card">
                                         <div class="header">
                                             <h2>Basic Information</h2>
                                         </div>
                                         <div class="body">
                                             <div class="row clearfix">
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Title</strong></label><br>
                                                             <label>{{ $data->title ??'' }}</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                  <div class="col-sm-3">
                                                   <div class="form-group">
                                                        <div class="form-line">
                                                           <label><strong> Name </strong></label><br>
                                                            {{ $data->firstname ??'' }} {{ $data->middlename ??'' }} {{ $data->lastname ??'' }}
                                                        </div>
                                                     </div>
                                                  </div>
                                                   <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Organization/Institute Name
                                                                     </strong></label><br>
                                                             <label>{{ $data->organization ?? '' }}</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Email</strong></label><br>
                                                             <label>{{ $data->email ?? '' }}</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Mobile Number</strong></label><br>
                                                             <label>{{ $data->mobile_no ?? '' }}</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Designation</strong></label><br>
                                                             <label>{{ $data->designation ?? '' }}</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <div class="form-group">
                                                                 <div class="form-line">
                                                                     <label><strong>Country</strong></label><br>
                                                                     <label>{{ $data->country_name ?? '' }}</label>
                                                                     <input type="hidden" id="Country"
                                                                         value="{{ $data->country ?? '' }}">
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>State</strong></label><br>
                                                             <label>{{ $data->state_name ?? '' }}</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>City</strong></label><br>
                                                             <label>{{ $data->city_name ?? '' }}</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Postal Code</strong></label><br>
                                                             <label>{{ $data->postal ?? '' }}</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Address</strong></label><br>
                                                             <label>{{ $data->address ?? '' }}</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 
                                             </div>
                                             <!-- Form  -->
                                             <div class="row">
                                                 <div class="header">
                                                     <h2>Single Point of Contact Details (SPoC)</h2>
                                                 </div>

                                                 <div class="col-md-12">
                                                    
                                                    <form class="form" id="regForm">
                                                        @csrf
                                                        <div class="body pb-0">
                                                            <!-- level start -->
                                                            <div class="row clearfix">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Person Name<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="Person_Name"
                                                                                placeholder="Person Name" class="preventnumeric" id="person_name"
                                                                                @isset($id)
                                                                                value="{{ $Application->Person_Name ?? '' }}"
                                                                                @endisset
                                                                                required maxlength="30">
                                                                                <span class="text-danger" id="person_error"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <input type="hidden" name="user_id"
                                                                    value="{{ Auth::user()->id }}">
                                                                <input type="hidden" name="state_id"
                                                                    value="{{ Auth::user()->state }}">
                                                                <input type="hidden" name="country_id"
                                                                    value="{{ Auth::user()->country }}">
                                                                <input type="hidden" name="city_id"
                                                                    value="{{ Auth::user()->city }}">

                                                                @if (request()->path() == 'level-first')
                                                                    <input type="hidden" placeholder="level_id"
                                                                        name="level_id" id="level_id"
                                                                        value="{{ 1 }}">
                                                                @elseif(request()->path() == 'level-second')
                                                                    <input type="hidden" placeholder="level_id"
                                                                        name="level_id" id="level_id"
                                                                        value="{{ 2 }}">
                                                                @elseif(request()->path() == 'level-third')
                                                                    <input type="hidden" placeholder="level_id"
                                                                        name="level_id" id="level_id"
                                                                        value="{{ 3 }}">
                                                                @elseif(request()->path() == 'level-fourth')
                                                                    <input type="hidden" placeholder="level_id"
                                                                        name="level_id" id="level_id"
                                                                        value="{{ 4 }}">
                                                                @endif
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Contact Number<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" required="required"
                                                                                name="Contact_Number" class="preventalpha" 
                                                                                placeholder="Contact Number" id="Contact_Number" 
                                                                                @isset($id)
                                                                                value="{{ $Application->Contact_Number ?? '' }}"
                                                                                @endisset >
                                                                        </div>
                                                                        <span class="text-danger" id="contact_error"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Email-ID<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text"  name="Email_ID"
                                                                                placeholder="Email-ID"
                                                                                @isset($id)
                                                                                 value="{{ $Application->Email_ID ?? '' }}"
                                                                                 @endisset
                                                                                >
                                                                        </div>
                                                                        <span class="text-danger" id="email_id_error"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Designation<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text"  name="designation"
                                                                                placeholder="Designation"
                                                                                @isset($id)
                                                                                 value="{{ $Application->designation ?? '' }}"
                                                                                 @endisset
                                                                                >
                                                                        </div>
                                                                        <span class="text-danger" id="designation_error"></span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                </div>
                                            </div>
                                            <!-- basic end -->
                                                    <ul class="list-inline pull-right">


                                                 @if( request()->path() ==  'level-first')
                                                        <li><button type="submit" class="btn btn-info mr-2 save">Save
                                                        </button></li>
                                                 @else
                                                        <li><button type="button" class="btn btn-primary next-step">
                                                                Next</button></li>
                                                @endif

                                                    </ul>
                                            </form>


                                         </div>
                                     </div>
                                 </div>
                                 <div class="tab-pane" role="tabpanel" id="step2">
                                     <div class="card">
                                         <div class="header mb-4">
                                             <h2 style="float:left; clear:none;">Level Courses </h2>
                                             {{-- @if (count($course) > 0) --}}
                                             {{-- @else --}}
                                             <a href="javascript:void();" class="btn btn-outline-primary mb-0"
                                                 style="float:right; clear:none; cursor:pointer;line-height: 24px;"
                                                 onclick="add_new_courses();"
                                                 @if (request()->path() == 'level-first') id="count" @elseif(request()->path() == 'level-second') id="count_second" @endif>
                                                 <i class="fa fa-plus font-14"></i> Add More Course</a>
                                             {{-- @endif --}}
                                         </div>

                                         <form action="{{ url('/new-application-course') }}"
                                             enctype="multipart/form-data" method="post" class="form"
                                             id="regForm">
                                             @csrf
                                             <input type="hidden"  name="form_step_type"  value="step2">
                                             <div class="body pb-0" id="courses_body">
                                                 <!-- level start -->
                                                 <div class="row clearfix">
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Name<span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="text" placeholder="Course Name"
                                                                     name="course_name[]"  required class="preventnumeric" maxlength="50">
                                                             </div>
                                                             @error('course_name')
                                                                 <div class="alert alert-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                         </div>
                                                     </div>



                                                   

                                                     <input type="hidden" name="application"  class="content_id" readonly>

                                                     <input type="hidden" name="application_id"   value="{{ $collections->id ?? '' }}"  class="form-control" readonly>

                                                 <input type="hidden" placeholder="level_id"   name="level_id" value="{{ 1 }}">

                                                     <input type="hidden" name="coutry"
                                                         value=" {{ $data->country ??'' }}">
                                                     <input type="hidden" name="state"
                                                         value=" {{ $data->state ??'' }}">

                                                     <div class="col-sm-4">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Duration<span class="text-danger">*</span></label>

                                                                 <!-- <input type="number" placeholder="Course Duration"
                                                                     name="course_duration[]" required> -->
                                                                    <div class="course_group">
                                                                        <input type="number" placeholder="Years" name="years[]" required class="course_input">
                                                                         <input type="number" placeholder="Months" name="months[]" required class="course_input">
                                                                         <input type="number" placeholder="Days" name="days[]" required class="course_input">
                                                                         <input type="number" placeholder="Hours" name="hours[]" required class="course_input">
                                                                     </div>
                                                             </div>
                                                             @error('course_duration')
                                                                 <div class="alert alert-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                         </div>
                                                     </div>
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Eligibility<span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="text" placeholder="Eligibility"
                                                                     name="eligibility[]" required id="eligibility">
                                                             </div>
                                                             @error('eligibility')
                                                                 <div class="alert alert-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                         </div>
                                                     </div>
                                                     <div class="col-sm-2">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Mode of Course <span
                                                                         class="text-danger">*</span></label>
                                                                <div class="form-group default-select select2Style">
                                                                 <select class="form-control select2" name="mode_of_course[]"
                                                                     required multiple="" style="width:200px;" >
                                                                     <option>Select Mode of Course</option>
                                                                    @foreach(__('arrayfile.mode_of_course_array') as $key=>$value)
                                                                       <option value="{{$value}}">{{$value}}</option>
                                                                    @endforeach
                                                                 </select>

                                                                   

                                                             </div>
                                                             </div>
                                                             @error('mode_of_course')
                                                                 <div class="alert alert-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                         </div>
                                                     </div>
                                                     <div class="col-sm-12">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Brief <span
                                                                         class="text-danger">*</span></label>
                                                                 <!-- <input type="text" placeholder="Course Brief"
                                                                     name="course_brief[]" required> -->
                                                                <textarea rows="4" cols="50" class="form-control" placeholder="Course Brief" name="course_brief[]"></textarea>
                                                            </div>
                                                             @error('course_brief')
                                                                 <div class="alert alert-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                         </div>
                                                     </div>
                                                 <!-- </div>

                                                 <div class="row clearfix"> -->
                                                     {{-- <!-- <form action="{{ url('/upload-document') }}" method="post" class="form" id="regForm" enctype="multipart/form-data"> -->
                                                            @csrf --}}

                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Declaration (PDF)<span
                                                                         class="text-danger">*</span></label>

                                                                 <input type="file" name="doc1[]"
                                                                     id="payment_reference_no" required
                                                                     class="form-control doc_1">
                                                             </div>

                                                             {{-- <label for="payment_reference_no"
                                                                     id="payment_reference_no-error" class="error">
                                                                     @error('payment_reference_no')
                                                                         {{ $message }}
                                                                     @enderror
                                                                 </label> --}}
                                                         </div>
                                                     </div>

                                                     <div class="col-sm-4">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course  Curriculum / Material / Syllabus (PDF)<span
                                                                         class="text-danger">*</span></label>

                                                                <input type="file" name="doc2[]"
                                                                     id="payment_reference_no"  required
                                                                     class="form-control doc_2"> 

                                                                     
                                                             </div>

                                                             {{-- <label for="payment_reference_no"
                                                                     id="payment_reference_no-error" class="error">
                                                                     @error('payment_reference_no')
                                                                         {{ $message }}
                                                                     @enderror
                                                                 </label> --}}
                                                         </div>
                                                     </div>

                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Details  (Excel format)<span
                                                                         class="text-danger">*</span></label>



                                                                 <input type="file" name="doc3[]"
                                                                     id="payment_reference_no" required
                                                                     class="form-control doc_3">
                                                             </div>

                                                             {{-- <label for="payment_reference_no"
                                                                     id="payment_reference_no-error" class="error">
                                                                     @error('payment_reference_no')
                                                                         {{ $message }}
                                                                     @enderror
                                                                 </label> --}}
                                                         </div>
                                                     </div>

                                                     @if (request()->path() == 'level-first')
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="{{ 1 }}">
                                                     @elseif(request()->path() == 'level-second')
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="{{ 2 }}">
                                                     @elseif(request()->path() == 'level-third')
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="{{ 3 }}">
                                                     @elseif(request()->path() == 'level-fourth')
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="{{ 4 }}">
                                                     @endif


                                                     <!-- payment end -->
                                                 </div>



                                                 @if (request()->path() == 'level-first')
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="{{ 1 }}">
                                                 @elseif(request()->path() == 'level-second')
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="{{ 2 }}">
                                                 @elseif(request()->path() == 'level-third')
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="{{ 3 }}">
                                                 @elseif(request()->path() == 'level-fourth')
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="{{ 4 }}">
                                                 @endif
                                                 <!-- level end -->
                                             </div>

                                             {{--
                                                @if (count($course) > 0)
                                                <h2 style="float:center;"> # Do payment First</h2>
                                                @else --}}
                                             <div class="center">
                                                 <button class="btn btn-primary waves-effect m-r-15 add_course">Save</button>
                                             </div>
                                             {{-- @endif --}}
                                         </form>
                                         <div class="body mt-5">
                                             <div class="table-responsive">
                                                 <table class="table table-hover js-basic-example contact_list">
                                                     <thead>
                                                         <tr>
                                                             <th class="center">S.No.</th>
                                                             <th class="center"> Course Name </th>
                                                             <th class="center"> Course Duration </th>
                                                             <th class="center"> Eligibility </th>
                                                             <th class="center"> Mode Of Course </th>
                                                             <th class="center"> Course Brief</th>
                                                             <th class="center">Payment Status</th>
                                                             <!-- <th class="center">Valid From</th>
                                                             <th class="center">Valid To </th> -->
                                                             <th class="center" >Action</th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>


                                                        @isset($course)

                                                         @foreach ($course as $k => $courses)
                                                             <tr class="odd gradeX">
                                                                 <td class="center">{{ $k + 1 }}</td>
                                                                 <td class="center">{{ $courses->course_name }}
                                                                 </td>

                                                                <td class="center">
                                                                    years:{{ $courses->years }},
                                                                    Months: {{ $courses->months }},
                                                                    days: {{$courses->days }},
                                                                    Hours: {{ $courses->hours }}

                                                                </td>
                                                                 <td class="center">{{ $courses->eligibility }}
                                                                 </td>
                                                                <td class="center">
                                                                    <!-- {{$courses->id}} -->
                                                                   [ <?php echo get_course_mode($courses->id); ?> ]
                                                                  
                                                                </td>
                                                                 <td class="center">{{ $courses->course_brief }}
                                                                 </td>
                                                                 <td class="center">@if($courses->payment=="false") Pending @endif</td>
                                                                 <!-- <td class="center">
                                                                     {{ date('d F Y', strtotime($courses->created_at)) }}
                                                                 </td>
                                                                 <td class="center">
                                                                     {{ date('d F Y', strtotime($courses->created_at->addYear())) }}
                                                                 </td> -->
                                                                 <td class="center btn-ved">
                                                                     <a class="btn btn-tbl-delete bg-primary"
                                                                         data-bs-toggle="modal"
                                                                         data-id='{{ $courses->id }}'
                                                                         data-bs-target="#View_popup" id="view">
                                                                         <i class="fa fa-eye"></i>
                                                                     </a>

                                                                     @if ($courses->payment == 'false')
                                                                         <a href="#" data-bs-toggle="modal"
                                                                             data-id="{{ $courses->id }}"
                                                                             data-bs-target="#edit_popup"
                                                                             id="edit_course"
                                                                             class="btn btn-tbl-delete bg-primary">
                                                                             <i class="material-icons">edit</i>
                                                                         </a>
                                                                     @endif


                                                                     <a href="{{ url('/delete-course' . '/' . dEncrypt($courses->id)) }}"
                                                                         class="btn btn-tbl-delete bg-danger">
                                                                         <i class="material-icons">delete</i>
                                                                     </a>
                                                                 </td>
                                                             </tr>
                                                         @endforeach

                                                         @endisset
                                                     </tbody>
                                                 </table>
                                             </div>
                                         </div>

                                         <div id="add_courses" style="Display:none" class="faqs-row' + faqs_row + '">
                                             <div class="row clearfix">
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course Name<span
                                                                     class="text-danger">*</span></label>
                                                             <input type="text" placeholder="Course Name"
                                                                 name="course_name[]" required>
                                                         </div>
                                                         @error('course_name')
                                                             <div class="alert alert-danger">{{ $message }}</div>
                                                         @enderror
                                                     </div>
                                                 </div>



                                             {{-- <input type="text" name="application"  class="content_id" readonly> --}}

                                             <input type="hidden" name="application_id" value="{{ $collections->id ?? '' }}"  class="form-control" readonly>

                                             <input type="hidden" placeholder="level_id"   name="level_id[]" value="{{ 1 }}">



                                                 <div class="col-sm-4">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course Duration<span class="text-danger">*</span>
                                                                    </label>
                                                             <!-- <input type="number" placeholder="Course Duration"
                                                                 name="course_duration[]" required> -->

                                                                 <div class="course_group">
                                                                    <input type="number" placeholder="Years" name="years[]" required class="course_input">
                                                                     <input type="number" placeholder="Months" name="months[]" required class="course_input">
                                                                     <input type="number" placeholder="Days"  name="days[]" required class="course_input">
                                                                     <input type="number" placeholder="Hours" name="hours[]"  required class="course_input">
                                                                     </div>
                                                         </div>
                                                         @error('course_duration')
                                                             <div class="alert alert-danger">{{ $message }}</div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Eligibility<span
                                                                     class="text-danger">*</span></label>
                                                             <input type="text" placeholder="Eligibility"
                                                                 name="eligibility[]" required>
                                                         </div>
                                                         @error('eligibility')
                                                             <div class="alert alert-danger">{{ $message }}</div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-2">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Mode of Course <span
                                                                     class="text-danger">*</span></label>
                                                                      <div class="form-group default-select select2Style">
                                                                     <select class="form-control select2 width" name="mode_of_course[]"
                                                                         >
                                                                         <option value="" SELECTED>Select Mode
                                                                         </option>
                                                                         <option value="Online">Online</option>
                                                                         <option value="Offline">Offline</option>
                                                                     </select>
                                                         </div>
                                                         </div>
                                                         @error('mode_of_course')
                                                             <div class="alert alert-danger">{{ $message }}</div>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 @if (request()->path() == 'level-first')
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="{{ 1 }}">
                                                 @elseif(request()->path() == 'level-second')
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="{{ 2 }}">
                                                 @elseif(request()->path() == 'level-third')
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="{{ 3 }}">
                                                 @elseif(request()->path() == 'level-fourth')
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="{{ 4 }}">
                                                 @endif
                                                 <!-- <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course Brief <span
                                                                     class="text-danger">*</span></label>
                                                             <input type="text" placeholder="Course Brief"
                                                                 name="course_brief[]" required>
                                                         </div>
                                                         @error('course_brief')
                                                             <div class="alert alert-danger">{{ $message }}</div>
                                                         @enderror
                                                     </div>
                                                 </div> -->

                                                 <div class="col-sm-12">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Brief <span
                                                                         class="text-danger">*</span></label>
                                                                 <!-- <input type="text" placeholder="Course Brief"
                                                                     name="course_brief[]" required> -->
                                                                <textarea rows="4" cols="50" class="form-control" placeholder="Course Brief" name="course_brief[]"></textarea>
                                                            </div>
                                                             @error('course_brief')
                                                                 <div class="alert alert-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                         </div>
                                                     </div>

                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Declaration<span
                                                                     class="text-danger">*</span></label>



                                                             <input type="file" name="doc1[]"
                                                                 id="payment_reference_no" required
                                                                 class="form-control">
                                                         </div>

                                                         <label for="payment_reference_no"
                                                             id="payment_reference_no-error" class="error">
                                                             @error('payment_reference_no')
                                                                 {{ $message }}
                                                             @enderror
                                                         </label>
                                                     </div>
                                                 </div>

                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course  Curriculum / Material / Syllabus <span
                                                                     class="text-danger">*</span></label>



                                                             <input type="file" name="doc2[]"
                                                                 id="payment_reference_no" required
                                                                 class="form-control">
                                                         </div>

                                                         <label for="payment_reference_no"
                                                             id="payment_reference_no-error" class="error">
                                                             @error('payment_reference_no')
                                                                 {{ $message }}
                                                             @enderror
                                                         </label>
                                                     </div>
                                                 </div>

                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course Details (Excel format) <span
                                                                     class="text-danger">*</span></label>


                                                             <input type="file" name="doc3[]"
                                                                 id="payment_reference_no" required
                                                                 class="form-control">
                                                         </div>

                                                         <label for="payment_reference_no"
                                                             id="payment_reference_no-error" class="error">
                                                             @error('payment_reference_no')
                                                                 {{ $message }}
                                                             @enderror
                                                         </label>
                                                     </div>
                                                 </div>

                                               </div>
                                         </div>

                                         <ul class="list-inline pull-right mt-5">
                                             <li><button type="button"
                                                     class="btn btn-danger prev-step">Previous</button>
                                             </li>
                                             <li><button type="button"
                                                     class="btn btn-primary next-step1">Next</button></li>
                                         </ul>
                                     </div>
                                 </div>

                                 <div class="tab-pane" role="tabpanel" id="step3">
                                     <div class="card">
                                         <div class="header">
                                             <h2 style="float:left; clear:none;">Payment</h2>
                                             <h6 style="float:right; clear:none;" id="counter">
                                                 @if (isset($total_amount))
                                                     Total Amount: {{ $currency }} {{ $total_amount }}
                                                 @endif
                                                 </h2>
                                         </div>
                                         <div class="body">
                                             <div class="form-group">
                                                 <div class="form-line">
                                                     <label>Payment Mode<span class="text-danger">*</span></label>
                                                     <select name="payment" class="form-control" id="payments">
                                                         <option value="">Select Option</option>
                                                         <option value="QR-Code"
                                                             {{ old('QR-Code') == 'QR-Code' ? 'selected' : '' }}>QR
                                                             Code
                                                         </option>
                                                         <option value="Bank"
                                                             {{ old('title') == 'Bank' ? 'selected' : '' }}>Bank
                                                             Transfers
                                                         </option>
                                                     </select>
                                                 </div>
                                             </div>
                                             <!-- payment start -->
                                             <div style="text-align:center; width:100%;" id="QR">
                                                 <div
                                                     style="width:100px; height:100px; border:1px solid #ccc; float:right;">
                                                     <img src="{{ asset('/assets/images/demo-qrcode.png') }}"
                                                         width="100" height="100">
                                                 </div>
                                             </div>
                                             <div class="row clearfix" id="bank_id">
                                                 <div class="col-sm-2">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Bank Name</strong></label>
                                                             <p>Punjab National Bank</p>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label> <strong>Branch Name</strong> </label>
                                                            <p>Main Market, Punjabi Bagh, New Delhi</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label> <strong>IFSC Code</strong> </label>
                                                            <p>PUNB00987</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="col-sm-2">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label> <strong>Accounts Number</strong> </label>
                                                             <p>112233234400987</p>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-2">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label> <strong>CIF</strong> </label>
                                                             <p>112233234400987</p>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-2">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label> <strong>MICR Number</strong> </label>
                                                             <p>112233234400987</p>
                                                         </div>
                                                     </div>
                                                 </div>


                                             </div>


                                            <form action="{{ url('/new-application_payment') }}" method="post"
                                                 class="form" id="regForm" enctype="multipart/form-data">
                                                 @csrf
                                                 <div class="row clearfix">
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                <label>Payment Date <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="payment_date"
                                                                    class="form-control" id="payment_date" required
                                                                    placeholder="Payment Date "aria-label="Date"
                                                                    value="{{ old('payment_date') }}"
                                                                    onfocus="focused(this)"
                                                                    onfocusout="defocused(this)">
                                                             </div>
                                                             <label for="payment_date" id="payment_date-error"
                                                                 class="error">
                                                                 @error('payment_date')
                                                                     {{ $message }}
                                                                 @enderror
                                                             </label>
                                                         </div>
                                                     </div>
                                                     <input type='hidden' name="amount"
                                                      @isset($total_amount)
                                                      value="{{ $total_amount }}"
                                                      @endisset  >
                                                     <input type='hidden' name="course_count"
                                                     @isset($course)
                                                     value="{{ count($course) }}">
                                                     @endisset

                                                     <input type='hidden' name="currency"
                                                       @isset($currency)
                                                       value="{{ $currency }}"
                                                       @endisset   >



                                                       @isset($course)

                                                       @foreach ($course as $k => $courses)
                                                       <input type='hidden' name="course_id[]"
                                                           value="{{ $courses->id }}">
                                                       @endforeach




                                                       @endisset




                                                     @if (request()->path() == 'level-first')
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="{{ 1 }}">
                                                     @elseif(request()->path() == 'level-second')
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="{{ 2 }}">
                                                     @elseif(request()->path() == 'level-third')
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="{{ 3 }}">
                                                     @elseif(request()->path() == 'level-fourth')
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="{{ 4 }}">
                                                     @endif
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label for="payment_transaction_no">Payment
                                                                     Transaction
                                                                     no. <span class="text-danger">*</span></label>
                                                                 <input type="text"
                                                                     placeholder="Payment Transaction no."
                                                                     id="payment_transaction_no" required
                                                                     name="payment_transaction_no" minlength="9"
                                                                     maxlength="18"
                                                                     value="{{ old('payment_transaction_no') }}">
                                                             </div>
                                                             <label for="payment_transaction_no"
                                                                 id="payment_transaction_no-error" class="error">
                                                                 @error('payment_transaction_no')
                                                                     {{ $message }}
                                                                 @enderror
                                                             </label>
                                                         </div>
                                                     </div>
                                                     <input type="hidden" name="coutry"
                                                         value=" {{ $data->country ??'' }}">
                                                     <input type="hidden" name="state"
                                                         value=" {{ $data->state  ??'' }}">
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Payment Reference no. <span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="text" required
                                                                     placeholder="Payment Reference no."
                                                                     name="payment_reference_no" minlength="9"
                                                                     maxlength="18"
                                                                     value="{{ old('payment_reference_no') }}">
                                                             </div>
                                                             <label for="payment_reference_no"
                                                                 id="payment_reference_no-error" class="error">
                                                                 @error('payment_reference_no')
                                                                     {{ $message }}
                                                                 @enderror
                                                             </label>
                                                         </div>
                                                     </div>

                                                     <input type="hidden" value="{{ $collections->id ?? '' }}"
                                                     name="Application_id" required class="course_input">

                                                    <input type="hidden" placeholder="level_id"
                                                     value="{{ $collections->level_id ?? '' }}" name="level_id"
                                                     value="{{ 1 }}">




                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Payment Screenshot <span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="file" name="payment_details_file"
                                                                     id="payment_details_file" required
                                                                     class="form-control payment_details_file">
                                                             </div>
                                                             <label for="payment_reference_no"
                                                                 id="payment_reference_no-error" class="error">
                                                                 @error('payment_reference_no')
                                                                     {{ $message }}
                                                                 @enderror
                                                             </label>
                                                         </div>
                                                     </div>
                                                 </div>


                                                 <ul class="list-inline pull-right">
                                                    <li><button type="button"
                                                            class="btn btn-danger prev-step1">Previous</button></li>
                                                   <!--  <li><button type="button"
                                                            class="btn btn-info preview-step mr-2">Preview</button></li> -->
                                                    <li><button type="submit"
                                                            class="btn btn-primary btn-info-full ">Submit</button>
                                                    </li>
                                                </ul>


                                            </form>
                                         </div>

                                         <!-- payment end -->

                                     </div>




                                 </div>

                             </div>
                             </form>
                             </div>
                                 <div role="tabpanel" class="tab-pane" id="preveious_application"
                                     aria-expanded="false">
                                     <div class="card">
                                         <div class="header">

                                             <h2>Previous Applications</h2>
                                         </div>
                                         <div class="body">
                                             <div class="table-responsive">
                                                 <table class="table table-hover js-basic-example contact_list">
                                                     <thead>
                                                         <tr>
                                                             <th class="center">#S.N0</th>
                                                             <th class="center">Application No</th>
                                                             <th class="center">Level ID</th>
                                                             <th class="center">Total Course</th>
                                                             <th class="center">Total Fee</th>
                                                             <th class="center"> Payment Date </th>
                                                             <th class="center">Status</th>
                                                             <th class="center">Action</th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>

                                                        @isset($collection)



                                                         @foreach ($collection as $k => $item)
                                                             <tr class="odd gradeX">
                                                                 <td class="center">{{ $k + 1 }}</td>
                                                                 <td class="center">
                                                                     RAVAP-{{ 4000 + $item->application_id }}</td>
                                                                 <td class="center">{{ $item->level_id }}</td>
                                                                 <td class="center">{{ $item->course_count }}</td>
                                                                 <td class="center">
                                                                     {{ $item->currency }}{{ $item->amount }}
                                                                 </td>
                                                                 <td class="center">{{ $item->payment_date }}</td>
                                                                 <td class="center">
                                                                     <a href="javascript:void(0)"
                                                                         onclick="return confirm_option('change status')"
                                                                         @if ($item->status == 0) <div class="badge col-brown">Pending</div>
                                                                    @elseif($item->status == 1)
                                                                    <div class="badge col-green">InProssess</div>
                                                                    @elseif($item->status == 2)
                                                                    <div class="badge col-red">Approved</div> @endif
                                                                         </a>
                                                                 </td>




                                                                 <td class="center">
                                                                    <a href="{{ url('/previews-application-first' . '/' . $item->id.'/'.$item->application_id) }}"
                                                                        class="btn btn-tbl-edit"><i
                                                                            class="material-icons">visibility</i></a>
                                                                    <!-- @if ($item->status == 1)
                                                                        <a href="{{ url('/upload-document' . '/' . dEncrypt($item->id)) }}"
                                                                            class="btn btn-tbl-edit bg-primary"><i
                                                                                class="fa fa-upload"></i></a>
                                                                    @endif
                                                                    @if ($item->status == 2)
                                                                        <a href="{{ url('/application-upgrade-second') }}"
                                                                            class="btn btn-tbl-edit"><i
                                                                                class="material-icons">edit</i></a>
                                                                    @endif -->
                                                                </td>


                                                                 @if (request()->path() == 'level-first')

                                                                 @elseif(request()->path() == 'level-second')
                                                                     <td class="center">
                                                                         <a href="{{ url('/previews-application-second' . '/' . $item->id) }}"
                                                                             class="btn btn-tbl-edit"><i
                                                                                 class="material-icons">visibility</i></a>
                                                                         @if ($item->status == 1)
                                                                             <a href="{{ url('/upload-document') }}"
                                                                                 class="btn btn-tbl-upload"><i
                                                                                     class="material-icons">upload</i></a>
                                                                         @endif
                                                                         @if ($item->status == 2)
                                                                             <a href="{{ url('/application-upgrade-third') }}"
                                                                                 class="btn btn-tbl-edit"><i
                                                                                     class="material-icons">edit</i></a>
                                                                         @endif
                                                                     </td>
                                                                 @elseif(request()->path() == 'level-third')
                                                                     <td class="center">
                                                                         <a href="{{ url('/previews-application-third' . '/' . $item->id) }}"
                                                                             class="btn btn-tbl-edit"><i
                                                                                 class="material-icons">visibility</i></a>
                                                                         @if ($item->status == 1)
                                                                             <a href="{{ url('/upload-document') }}"
                                                                                 class="btn btn-tbl-upload"><i
                                                                                     class="material-icons">upload</i></a>
                                                                         @endif
                                                                         @if ($item->status == 2)
                                                                             <a href="{{ url('/application-upgrade-forth') }}"
                                                                                 class="btn btn-tbl-edit"><i
                                                                                     class="material-icons">edit</i></a>
                                                                         @endif
                                                                     </td>
                                                                 @elseif(request()->path() == 'level-fourth')
                                                                     <td class="center">
                                                                         <a href="{{ url('/previews-application-fourth') }}"
                                                                             class="btn btn-tbl-edit"><i
                                                                                 class="material-icons">visibility</i></a>
                                                                     </td>
                                                                 @endif
                                                             </tr>
                                                         @endforeach


                                                         @endisset
                                                     </tbody>
                                                 </table>
                                                 <!-- Modal -->
                                                 <div class="modal fade" id="exampleModal" tabindex="-1"
                                                     role="dialog" aria-labelledby="exampleModalLabel"
                                                     aria-hidden="true">
                                                     <div class="modal-dialog" role="document">
                                                         <div class="modal-content">
                                                             <div class="modal-header">
                                                                 <h5 class="modal-title" id="exampleModalLabel">
                                                                     Modal
                                                                     title
                                                                 </h5>
                                                                 <button type="button" class="close"
                                                                     data-dismiss="modal" aria-label="Close">
                                                                     <span aria-hidden="true">&times;</span>
                                                                 </button>
                                                             </div>
                                                             <div class="modal-body">
                                                                 ...
                                                             </div>
                                                             <div class="modal-footer">
                                                                 <button type="button" class="btn btn-secondary"
                                                                     data-dismiss="modal">Close</button>
                                                                 <button type="button" class="btn btn-primary">Save
                                                                     changes</button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>



                                 <div role="tabpanel" class="tab-pane" id="faqs" aria-expanded="false">
                                     <div class="card">
                                         <div class="header">
                                             <h2>FAQs</h2>
                                         </div>
                                         <div class="body">
                                             @if (count($faqs) > 0)
                                                 @foreach ($faqs as $k => $faq)
                                                     <div class="row clearfix">
                                                         <div class="col-lg-12 col-md-12">

                                                             <span style="font-weight:bold">Question
                                                                 {{ $k + 1 }}:</span><br>
                                                             {{ $faq->question }}

                                                         </div>
                                                     </div>
                                                     <div class="row clearfix">
                                                         <div class="col-lg-12 col-md-12">

                                                             <span style="font-weight:bold">Answer:</span><br>
                                                             {!! $faq->answer !!}

                                                         </div>
                                                     </div>
                                                 @endforeach
                                             @endif

                                         </div>
                                     </div>
                                 </div>

                     </div>
                 </div>




                 <!-- View Modal Popup -->

                 <div class="modal fade" id="View_popup" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalCenterTitle"> View Course Details</h5>
                                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             <div class="modal-body">

                                 <div class="body">
                                     <div class="table-responsive table-con-free">
                                         <table class="table table-hover js-basic-example contact_list table-bordered">
                                             <tbody>


                                                 <!-- <tr class="odd gradeX">
                                                     <th class="center">S.No.</th>
                                                     <td class="center">
                                                         <input type="text" id="Course_id" readonly>
                                                     </td>

                                                 </tr> -->

                                                 <tr class="odd gradeX">
                                                     <th class="center"> Course Name </th>
                                                     <td class="center">

                                                         <input type="text" id="Course_Name" readonly>

                                                     </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center"> Eligibility </th>
                                                     <td class="center">

                                                         <input type="text" id="Eligibility" readonly>

                                                     </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center"> Mode Of Course </th>
                                                     <td class="center">

                                                         <input type="text" id="Mode_Of_Course" readonly>


                                                     </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center">Payment Status</th>
                                                     <td class="center">


                                                         <input type="text" id="Payment_Status" readonly>

                                                     </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center">Course Brief</th>
                                                     <td class="center">
                                                     <input type="text" name="course_brief[]" id="view_course_brief" readonly>
                                                     </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center">Duration</th>
                                                     <td class="center">
                                                         <span id="view_years"></span>
                                                         <span id="view_months"></span>
                                                         <span id="view_days"></span>
                                                         <span id="view_hours"></span>
                                                     </td>
                                                 </tr>



                                                 <tr class="odd gradeX">
                                                     <th class="center">Declaration </th>
                                                     <td class="center">

                                                         <a href="" target="_blank" id="docpdf1" title="Download Document 1" ><i class="fa fa-download mr-2"></i> PDF 1
                                                         </a>
                                                     </td>

                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center">Course Curriculum / Material / Syllabus </th>
                                                     <td class="center">

                                                         <a href="" target="_blank" id="docpdf2" title="Download Document 2" ><i class="fa fa-download mr-2"></i> PDF 2
                                                         </a>
                                                    </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center">Course Details (Excel format)  </th>
                                                     <td class="center">

                                                        <a  target="_blank"  href="" title="Document 3" id="docpdf3" download>
                                                             <i class="fa fa-download mr-2"></i> PDF 3
                                                         </a>

                                                     </td>
                                                 </tr>

                                             </tbody>
                                         </table>
                                     </div>
                                 </div>

                             </div>

                         </div>
                     </div>
                 </div>


                <!-- Edit Modal Poup -->

                 <div class="modal fade" id="edit_popup">
                     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                         <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle"> Edit Details </h5>

                                    <div class="payment-status d-flex">
                                        <label class="active">Payment Status : </label>
                                        <input type="text" name="Payment_Statuss" id="Payment_Statuss" class="form-control btn btn-outline-danger p-0" style="border-bottom: 1px solid #fb483a !important;">
                                    </div>

                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                             <div class="modal-body edit-popup">
                                 <div class="body col-md-12">

                                     <form action="" id="form_update" method="post">

                                         @csrf

                                         <div class="row mt-4">
                                             <div class="col-sm-3">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label class="active">Course Name<span
                                                                 class="text-danger">*</span></label>
                                                         <input type="text" name="Course_Names" id="Course_Names"
                                                             class="form-control">
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-sm-4">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course Duration <span class="text-danger">*</span>
                                                                    </label>
                                                             <!-- <input type="number" placeholder="Course Duration"
                                                                 name="course_duration[]" required> -->

                                                                 <div class="course_group">
                                                                    <input type="number" placeholder="Years" name="years" required class="course_input" id="years">
                                                                     <input type="number" placeholder="Months" name="months" required class="course_input" id="months">
                                                                     <input type="number" placeholder="Days"  name="days" required class="course_input" id="days">
                                                                     <input type="number" placeholder="Hours" name="hours"  required class="course_input" id="hours">
                                                                     </div>
                                                         </div>
                                                         @error('course_duration')
                                                             <div class="alert alert-danger">{{ $message }}</div>
                                                         @enderror
                                                     </div>
                                                 </div>

                                             <div class="col-sm-3">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label class="active">Eligibility<span> </label>
                                                         <input type="text" name="Eligibilitys" id="Eligibilitys" class="form-control">
                                                     </div>
                                                 </div>
                                             </div>

                                              <div class="col-sm-2">
                                                         <div class="form-group select-modal">
                                                             <div class="form-line">
                                                                 <label>Mode of Course  <span class="text-danger">*</span></label>
                                                               
                                                              <!--  <select class="form-control" name="mode_of_course[]"
                                                                     required multiple="" style="width:160px;" id="mode_of_course_edit">
                                                                     <option value="1">Online</option>
                                                                     <option value="2">Offline</option>
                                                                     <option value="3">Hybrid</option> -->

                                                                   
                                                                     <!-- <option>Select Mode of Course</option> -->
                                                                    <!-- @foreach(__('arrayfile.mode_of_course_array') as $key=>$value)
                                                                       <option value="{{$value}}">{{$value}}</option>
                                                                    @endforeach -->
                                                                 <!-- </select> -->

                                                                <select multiple name="myselect" id="mode_of_course_edit">
                                                                      <option value="Online">Online</option>
                                                                      <option value="Offline">Offline</option>
                                                                      <option value="Hybrid">Hybrid</option>
                                                                </select>

                                                                   

                                                         
                                                             </div>
                                                             @error('mode_of_course')
                                                                 <div class="alert alert-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                         </div>
                                                     </div>


                                             <div class="col-sm-12">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Brief <span
                                                                         class="text-danger">*</span></label>
                                                                 <!-- <input type="text" placeholder="Course Brief"
                                                                     name="course_brief[]" required> -->
                                                                <textarea rows="4" cols="50" class="form-control" placeholder="Course Brief" name="course_brief" id="course_brief"></textarea>
                                                            </div>
                                                             @error('course_brief')
                                                                 <div class="alert alert-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                         </div>
                                                     </div>



                                               <div class="col-sm-4">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Declaration<span class="text-danger">*</span></label>
                                                         <input type="file" name="doc1"
                                                             id="payment_reference_no"
                                                             class="form-control doc_edit_1">


                                                         <a target="_blank" href="" id="docpdf1ss" title=" Document 1"
                                                             ><i class="fa fa-download mr-2"></i> PDF 1 </a>

                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-sm-4">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label>Course Curriculum / Material / Syllabus <span class="text-danger">*</span></label>
                                                         <input type="file" name="doc2"
                                                             id="payment_reference_no"
                                                             class="form-control doc_edit_2">

                                                         <a target="_blank" href="" id="docpdf2ss" title=" Document 1"
                                                             ><i class="fa fa-download mr-2"></i> PDF 2</a>

                                                     </div>
                                                 </div>
                                             </div>

                                             {{-- @if ($id) [{{$data->image}}] @endif --}}

                                             <div class="col-sm-4">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label>Course Details (Excel format) <span class="text-danger">*</span></label>
                                                         <input type="file" name="doc3"
                                                             id="payment_reference_no"
                                                             class="form-control doc_edit_3">


                                                         <a href="" id="docpdf3ss" title="Download Document 1"
                                                             download><i class="fa fa-download mr-2"></i> PDF 3 </a>
                                                     </div>


                                                 </div>
                                             </div>

                                             <div class="col-md-12 text-center">
                                                 <button type="submit"
                                                     class="btn btn-primary waves-effect m-r-15">Save</button>
                                             </div>
                                         </div>

                                     </form>

                                 </div>

                             </div>
                         </div>
                    </div>
                 </div>







                                      {{-- @if($id) [{{$data->image}}] @endif --}}

                                      <script>
                                         function add_new_course() {
                                             $("#courses_body").append($("#add_courses").html());
                                         }
                                     </script>
     {{-- button click count --}}
     <script>
         $(document).ready(function() {
             var count = 0;

             $(window).on('load', function() {
                 $data = $('#Country').val();
                 // alert($data);

             });


             $("#count").click(function() {
                 count++;
                 //  alert(count)
                 if (count <= 4) {

                     if ($data == '101') {
                         rupess = 1000;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);
                         $("#counters").html("value=" + rupess);


                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 15;
                         //alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 50;
                         // alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }

                 } else if (count <= 9) {
                     if ($data == '101') {
                         rupess = 2000;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);

                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 30;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 100;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }
                 } else {
                     if ($data == '101') {
                         rupess = 3000;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);

                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 45;
                         // alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 150;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }
                 }
             });
         });
     </script>
     <script>
         $(document).ready(function() {



             $(window).on("load", function() {
                 $("#bank_id").hide();
                 $("#QR").hide();
             });

             $("#payments").on('change', function() {
                 $type = $('#payments').val();
                 //alert($type);

                 if ($type == 'QR-Code') {
                     // alert('hii')
                     $("#bank_id").hide();
                     $("#QR").show();

                 } else if ($type == "") {
                     //  alert('hii1')
                     $("#bank_id").hide();
                     $("#QR").hide();

                 } else {

                     //  alert('hii1')
                     $("#bank_id").show();
                     $("#QR").hide();

                 }
             });
         });
     </script>
     {{-- second payment section   --}}
     <script>
         $(document).ready(function() {
             var count = 0;

             $(window).on('load', function() {
                 $data = $('#Country').val();
                 // alert($data);

             });


             $("#count_second").click(function() {
                 count++;
                 //  alert(count)
                 if (count <= 4) {

                     if ($data == '101') {
                         rupess = 2500;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);
                         $("#counters").html("value=" + rupess);


                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 35;
                         //alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 100;
                         // alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }

                 } else if (count <= 9) {
                     if ($data == '101') {
                         rupess = 5000;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);

                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 75;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 200;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }
                 } else {
                     if ($data == '101') {
                         rupess = 10000;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);

                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 150;
                         // alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 400;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }
                 }
             });
         });
     </script>
     <!-- step Tabs js -->
     <script>
         $(document).ready(function() {

             $(".next-step").click(function() {
                 $("#step1").removeClass("active");
                 $("#step2").addClass("active");
                 $(".progress1").removeClass("active");
                 $(".progress2").addClass("active");

             });

             $(".prev-step").click(function() {
                 $("#step2").removeClass("active");
                 $("#step1").addClass("active");
                 $(".progress2").removeClass("active");
                 $(".progress1").addClass("active");
                 $(".progress2").removeClass("bg_green");
             });

             $(".next-step1").click(function() {
                 $("#step2").removeClass("active");
                 $("#step3").addClass("active");
                 $(".progress2").removeClass("active");
                 $(".progress3").addClass("active");
                 $(".progress2").addClass("bg_green");
             });

             $(".prev-step1").click(function() {
                 $("#step3").removeClass("active");
                 $("#step2").addClass("active");
                 $(".progress3").removeClass("active");
                 $(".progress2").addClass("active");
             });

         });
     </script>



     {{-- eyes button id get in model --}}

                                 {{-- multiple video section shwo --}}
                                 <script>
                                    $(document).on("click", "#view", function() {
                                        var UserName = $(this).data('id');
                                        console.log(UserName);

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({
                                            url: "{{ url('course-list') }}",
                                            type: "get",
                                            data: {
                                                id: UserName
                                            },
                                            success: function(Document) {

                                               /* console.log(data.ApplicationCourse[0].eligibility)
                                                console.log(data.Document[0].document_file)*/

                                                console.log(Document);

                                                $("#Course_id").val(data.ApplicationCourse[0].id);
                                                $("#Course_Name").val(data.ApplicationCourse[0].course_name);
                                                $("#Eligibility").val(data.ApplicationCourse[0].eligibility);
                                                $("#Mode_Of_Course").val(data.ApplicationCourse[0].mode_of_course);
                                                if(data.ApplicationCourse[0].payment=="false")
                                                {
                                                    $("#Payment_Status").val("Pending");
                                                }
                                                
                                             

                                                $("a#docpdf1").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[0]
                                                    .document_file);
                                                $("a#docpdf2").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[0]
                                                    .document_file);
                                                $("a#docpdf3").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[0]
                                                    .document_file);

                                            }

                                        });

                                    });
                                </script>


                               



                                {{-- multiple video section shwo --}}
                                <script>
                                    $(window).on("load", function() {
                                        var UserName = $('$level_id').data('id');
                                        console.log(UserName);

                                        $('')

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });


                                        $.ajax({
                                            url: "{{ url('/level-first') }}",
                                            type: "get",
                                            data: {
                                                id: UserName
                                            },
                                            success: function(data) {



                                            }

                                        });

                                    });
                                </script>


                                {{-- form2 --}}
                                <script type="text/javascript">
                                    $('.save').on('click', function(e) {

                                        e.preventDefault();

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({
                                            type: "POST",
                                            url: '{{ url('/new-application') }}',
                                            data: new FormData(document.getElementById("regForm")),
                                            processData: false,
                                            dataType: 'json',
                                            contentType: false,
                                            success: function(response) {

                                                console.log(response.id)
                                                
 
                                                if (response.id) {

                                                    $('.content_id').val(response.id);
                                                    $('.content_ids').val(response.id);
                                                    $("#step1").removeClass('active')
                                                    $("#step2").addClass('active')

                                                }


                                            },

                                            error: function(response) 
                                            {
                                                //console.log(response);
                                                $("#email_id_error").empty();
                                                $("#contact_error").empty();
                                                $("#person_error").empty();
                                                $("#designation_error").empty();

                                                $('#email_id_error').text(response.responseJSON.errors.Email_ID);
                                                $('#contact_error').text(response.responseJSON.errors.Contact_Number);
                                                $('#person_error').text(response.responseJSON.errors.Person_Name);
                                                $('#designation_error').text(response.responseJSON.errors.designation);
                                                //alert(response.responseJSON.errors.Email_ID);
                                            },


                                        });

                                    });
                                </script>


                                <script>
                                    function add_new_course() {

                                        $("#courses_body").append($("#add_courses").html());
                                    }
                                </script>




    {{-- multiple video section shwo --}}
    <script>
       $(document).on("click", "#view", function() {

           var UserName = $(this).data('id');
           console.log(UserName);

           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $.ajax({
               url: "{{ url('course-list') }}",
               type: "get",
               data: {
                   id: UserName
               },
               success: function(data) {
                   

                   console.log(data.ApplicationCourse[0].eligibility)
                   console.log(data.Document[0].document_file)

                   $("#Course_id").val(data.ApplicationCourse[0].id);
                   $("#Course_Name").val(data.ApplicationCourse[0].course_name);
                   $("#Eligibility").val(data.ApplicationCourse[0].eligibility);
                   $("#Mode_Of_Course").val(data.ApplicationCourse[0].mode_of_course);
                   if(data.ApplicationCourse[0].payment=="false")
                    {
                        $("#Payment_Status").val("Pending");
                    }
                   $("#view_course_brief").val(data.ApplicationCourse[0].course_brief);

                   $("#view_years").html(data.ApplicationCourse[0].years + " Year(s)");
                   $("#view_months").html(data.ApplicationCourse[0].months + " Month(s)");
                   $("#view_days").html(data.ApplicationCourse[0].days + " Day(s)");
                   $("#view_hours").html(data.ApplicationCourse[0].hours + " Hour(s)");
                   
                   //alert(data.Document[2].document_file);

                   $("a#docpdf1").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[0]
                       .document_file);
                   $("a#docpdf2").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[1]
                       .document_file);

                   $("a#docpdf3").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[2]
                       .document_file);
                   /*$("a#docpdf3").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[2]
                       .document_file);*/




               }

           });

       });
   </script>


   {{-- multiple video section shwo --}}
    <script>
       $(document).on("click", "#edit_course", function() {

       //alert("edit course second 2420");
           var UserName = $(this).data('id');
           console.log(UserName);
          
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $.ajax({
               url: "{{ url('course-edit') }}",
               type: "get",
               data: {
                   id: UserName
               },
               success: function(data) {
                   
               console.log(data.ApplicationCourse[0].mode_of_course);
              


                var values=data.ApplicationCourse[0].mode_of_course;
                $.each(values, function(i,e){
                    $("#mode_of_course_edit option[value='" + e + "']").prop("selected", true);
                });

                   $('#form_update').attr('action', '{{ url('/course-edit') }}' + '/' + data
                       .ApplicationCourse[0].id)
                   $("#Course_Names").val(data.ApplicationCourse[0].course_name);
                   $("#Eligibilitys").val(data.ApplicationCourse[0].eligibility);
                   $("#Mode_Of_Courses").val(data.ApplicationCourse[0].mode_of_course);
                   //$("#Payment_Statuss").val(data.ApplicationCourse[0].payment);

                   if(data.ApplicationCourse[0].payment=="false")
                    {
                        $("#Payment_Statuss").val("Pending");
                    }

              $("#years").val(data.ApplicationCourse[0].years);
                $("#months").val(data.ApplicationCourse[0].months);
                $("#days").val(data.ApplicationCourse[0].days);
                $("#hours").val(data.ApplicationCourse[0].hours);
                $("#course_brief").val(data.ApplicationCourse[0].course_brief);

                  //alert("yes");
                  $("a#docpdf1ss").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[0]
                       .document_file);
                   $("a#docpdf2ss").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[1]
                       .document_file);
                   /*$("a#docpdf1ss").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[0]
                       .document_file);
                   $("a#docpdf2ss").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[1]
                       .document_file);*/
                   $("a#docpdf3ss").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[2]
                       .document_file);

                   //dd
               }

           });

       });
   </script> 



   {{-- multiple video section shwo --}}
   <script>
       $(window).on("load", function() {
           var UserName = $('$level_id').data('id');
           console.log(UserName);

           $('')

           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });


           $.ajax({
               url: "{{ url('/level-first') }}",
               type: "get",
               data: {
                   id: UserName
               },
               success: function(data) {



               }

           });

       });
       $(function() {
        $("#payment_date").datepicker({
            maxDate: new Date()
        });
    });


    

    // disable alphate
    $('#postal').keypress(function (e) {
       // alert('hello');
        var regex = new RegExp("^[0-9_]");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
   </script>
   <script>
   
    $('.preventalpha').keypress(function (e) {
          //alert("yes");
         var regex = new RegExp("^[0-9_]");
         var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
         if (regex.test(str)) {
             return true;
         }
         e.preventDefault();
         return false;
     });

    $('.preventnumeric').keypress(function (e) {
          //alert("yes");
         var regex = new RegExp("^[a-z,A-Z_]");
         var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
         if (regex.test(str)) {
             return true;
         }
         e.preventDefault();
         return false;
     });

    $('#eligibility').bind('input', function() {
      var c = this.selectionStart,
          r = /[^a-z0-9 .]/gi,
          v = $(this).val();
      if(r.test(v)) {
        $(this).val(v.replace(r, ''));
        c--;
      }
      this.setSelectionRange(c, c);
    });

   </script>
   
    <script>
       var doc_payment_file="";
       
       $('.payment_details_file').on('change',function(){

          doc_payment_file = $(".payment_details_file").val();
          
          var doc_payment_files = doc_payment_file.split('.').pop();
         
          if(doc_payment_files=='png' || doc_payment_files=='jpg' || doc_payment_files=='jpeg')
          {
          // alert("File uploaded is pdf");
           }
          else{
            alert("Only jpg, png, jpeg are allowed")
             $('.payment_details_file').val("");
          }
         
        });

        
        
   </script>

   <script>
       var doc_file1="";
       
       $('.doc_1').on('change',function(){

          doc_file1 = $(".doc_1").val();
          console.log(doc_file1);
          var doc_file1 = doc_file1.split('.').pop();
          if(doc_file1=='pdf'){
          // alert("File uploaded is pdf");
           }
          else{
            alert("Only PDF are allowed")
             $('.doc_1').val("");
          }
         
        });

        
        
   </script>



   <script>

    var doc_file2="";
    $('.doc_2').on('change',function(){
          
          doc_file2 = $(".doc_2").val();
          console.log(doc_file2);
          var doc_file2 = doc_file2.split('.').pop();
          if(doc_file2=='pdf'){
          // alert("File uploaded is pdf");
           }
          else{
            alert("Only PDF are allowed");
             $('.doc_2').val("");
          }
         
        });

   </script>

   <script>
   
    var doc_file3="";
    $('.doc_3').on('change',function(){
        
          doc_file3 = $(".doc_3").val();
          console.log(doc_file3);
          var doc_file3 = doc_file3.split('.').pop();

         
          if(doc_file3=='csv' || doc_file3=='xlsx' || doc_file3=='xls'){
          // alert("File uploaded is pdf");
           }
          else{
            alert("Only csv,xlsx,xls  are allowed")
             $('.doc_3').val("");
          }
         
        });
   </script>

   <script>
       var doc_file1="";
       
       $('.doc_edit_1').on('change',function(){

          doc_file1 = $(".doc_edit_1").val();
         // alert(doc_file1);
          console.log(doc_file1);
          var doc_file1 = doc_file1.split('.').pop();
          if(doc_file1=='pdf'){
          // alert("File uploaded is pdf");
           }
          else{
            alert("Only PDF are allowed")
             $('.doc_edit_1').val("");
          }
         
        });
    </script>
     <script>
       var doc_file_edit2="";
       
       $('.doc_edit_2').on('change',function(){

          doc_file_edit2 = $(".doc_edit_2").val();
         // alert(doc_file1);
          console.log(doc_file_edit2);
          var doc_file1 = doc_file_edit2.split('.').pop();
          if(doc_file1=='pdf'){
          // alert("File uploaded is pdf");
           }
          else{
            alert("Only PDF are allowed")
             $('.doc_edit_2').val("");
          }
         
        });
    </script>
     <script>
       var doc_file_edit3="";
       
       $('.doc_edit_3').on('change',function()
       {

          doc_file_edit3 = $(".doc_edit_3").val();
         // alert(doc_file1);
          console.log(doc_file_edit3);
          var doc_file = doc_file_edit3.split('.').pop();
           if(doc_file=='csv' || doc_file=='xlsx' || doc_file=='xls'){
          // alert("File uploaded is pdf");
           }
          else{
            alert("Only PDF are allowed");
             $('.doc_edit_3').val("");
          }
         
        });
    </script>


 <script>
    $(function () {
            //Multi-select
            $("#optgroup").multiSelect({ selectableOptgroup: true });

            //Select2
            $(".select2").select2();

            $("#select2-search-hide").select2({
            minimumResultsForSearch: Infinity,
            });

            $("#select2-rtl-multiple").select2({
            placeholder: "RTL Select",
            dir: "rtl",
            });

            $("#select2-max-length").select2({
            maximumSelectionLength: 2,
            placeholder: "Select only maximum 2 items",
            });
});
</script>

     @include('layout.footer')
     <!-- New JS -->

<script src="{{ asset('assets/js/form.min.js') }} "></script>
<script src="{{ asset('assets/js/bundles/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('assets/js/bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js') }} "></script>
<script src=" {{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>
 </body>
