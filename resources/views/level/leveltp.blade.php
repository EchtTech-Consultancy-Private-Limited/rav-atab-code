 @include('layout.header')
 <!-- New CSS -->
 <link rel="stylesheet" href="{{ asset('assets/css/form.min.css') }}" class="js">
 <style>
     .button-blinking {
         background-color: #004A7F;
         -webkit-border-radius: 10px;
         border-radius: 10px;
         border: none;
         color: #FFFFFF;
         cursor: pointer;
         display: inline-block;
         font-family: Arial;
         font-size: 16px;
         padding: 5px 10px;
         text-align: center;
         text-decoration: none;
         -webkit-animation: glowing 1500ms infinite;
         -moz-animation: glowing 1500ms infinite;
         -o-animation: glowing 1500ms infinite;
         animation: glowing 1500ms infinite;
     }

     @-webkit-keyframes glowing {
         0% {
             background-color: #B20000;
             -webkit-box-shadow: 0 0 3px #B20000;
         }

         50% {
             background-color: #FF0000;
             -webkit-box-shadow: 0 0 40px #FF0000;
         }

         100% {
             background-color: #B20000;
             -webkit-box-shadow: 0 0 3px #B20000;
         }
     }

     @-moz-keyframes glowing {
         0% {
             background-color: #B20000;
             -moz-box-shadow: 0 0 3px #B20000;
         }

         50% {
             background-color: #FF0000;
             -moz-box-shadow: 0 0 40px #FF0000;
         }

         100% {
             background-color: #B20000;
             -moz-box-shadow: 0 0 3px #B20000;
         }
     }

     @-o-keyframes glowing {
         0% {
             background-color: #B20000;
             box-shadow: 0 0 3px #B20000;
         }

         50% {
             background-color: #FF0000;
             box-shadow: 0 0 40px #FF0000;
         }

         100% {
             background-color: #B20000;
             box-shadow: 0 0 3px #B20000;
         }
     }

     @keyframes glowing {
         0% {
             background-color: #B20000;
             box-shadow: 0 0 3px #B20000;
         }

         50% {
             background-color: #FF0000;
             box-shadow: 0 0 40px #FF0000;
         }

         100% {
             background-color: #B20000;
             box-shadow: 0 0 3px #B20000;
         }
     }
 </style>
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

     .card {
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

     .select-box-hide-class select {
         display: none;
     }

     .form-control[type=file] {
         overflow: hidden;
         height: 3rem;
     }

     .btn_remove {
         background: #fff;
         border: 1px solid red;
         border-radius: 5px;
         padding: 3px 6px;
         color: red;
         transition: background-color 0.3s, color 0.3s;
         /* Add transition for smooth effect */
     }

     .btn_remove:hover {
         background-color: red;
         /* Change background color on hover */
         color: #fff;
         /* Change text color on hover */
     }

     .ui-datepicker-prev,
     .ui-datepicker-next {
         cursor: pointer;
     }
 </style>
 <title>RAV Accreditation</title>
 </head>

 <body class="light">
     <!-- Page Loader -->
     {{--
   <div class="page-loader-wrapper">
      <div class="loader">
         <div class="m-t-30">
            <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
         </div>
         <p>Please wait...</p>
      </div>
   </div>
   --}}
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
                         @include('level.inner-nav')
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



                     <div class="tab-content">

                         {{-- pending application table --}}
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
                                                             <th> Application ID </th>
                                                             <!--<th class="center"> Create User ID </th>-->
                                                             <th> Level ID </th>
                                                             <th> Country </th>
                                                             <th> Action </th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>
                                                         @isset($level_list_data)
                                                             <tr>
                                                                 @foreach ($level_list_data as $item_level_list)
                                                                     @if (checktppaymentstatus($item_level_list->id) == 0)
                                                                         <td> RAVAP-{{ 4000 + $item_level_list->id }}</td>
                                                                         </td>
                                                                         <!-- <td class="center">{{ $item_level_list->user_id ?? '' }}</td>-->
                                                                         <td> {{ $item_level_list->level_id ?? '' }}</td>
                                                                         <td> {{ $item_level_list->country_name ?? '' }}
                                                                         </td>
                                                                         <td> <a href="{{ url('/level-first' . '/' . $item_level_list->id) }}"
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

                         {{-- Validity Structure --}}
                         <div role="tabpanel" class="tab-pane active" id="general_information" aria-expanded="true">
                             <div class="row clearfix">
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                     <div class="card project_widget">
                                         <div class="header">
                                         </div>
                                         <div class="body">
                                             <div class="row">
                                                 <div class="col-md-4 ">
                                                     <h5> <strong>Validity </strong></h5>
                                                     <p class="text-muted">{{ $item[0]->validity }}</p>
                                                 </div>
                                                 <div class="col-md-4 ">
                                                     <h5> <strong>Fee Structure </strong></h5>
                                                     <p class="text-muted">{{ $item[0]->fee_structure }}</p>
                                                     <div class="d-flex align-item-center">
                                                        @if ($item[0]->Fee_Structure_pdf != '')
                                                        <a target="_blank"
                                                            href="{{ url('show-pdf' . '/' . $item[0]->Fee_Structure_pdf) }}"
                                                            title="level Information pdf">PDF Fee Structure </a>
                                                            
                                                    @endif
                                                     </div>
                                                 </div>
                                                 <div class="col-md-4 ">
                                                     <h5> <strong>Timelines </strong></h5>
                                                     <p class="text-muted"> {{ $item[0]->timelines }}</p>
                                                 </div>
                                                 <div class="col-sm-4">
                                                     <h5>Level Information</h5>
                                                     <p>{{ $item[0]->level_Information }}</p>
                                                     <br>
                                                     @if ($item[0]->level_Information_pdf != '')
                                                         <a target="_blank"
                                                             href="{{ url('show-pdf' . '/' . $item[0]->level_Information_pdf) }}"
                                                             title="level Information pdf">
                                                             PDF level Information </a>
                                                     @endif
                                                 </div>
                                             </div>
                                             <br>


                                             <br><br>
                                             <h5>Prerequisites</h5>
                                             <p>{{ $item[0]->Prerequisites }}</p>
                                             <br>
                                             <br>
                                             @if ($item[0]->Prerequisites_pdf != '')
                                                 <a target="_blank" 
                                                     href="{{ url('show-pdf' . '/' . $item[0]->Prerequisites_pdf) }}"
                                                     title="level Information pdf">
                                                     PDF Prerequisites  </a>
                                             @endif
                                             <br>
                                             <br>
                                             <h5>Documents Required</h5>
                                             <p>{{ $item[0]->documents_required }}</p>
                                             <br>
                                             <br>
                                             @if ($item[0]->documents_required_pdf != '')
                                                 <a target="_blank"
                                                     href="{{ url('show-pdf' . '/' . $item[0]->documents_required_pdf) }}"
                                                     title="level Information pdf"><i class="fa fa-download mr-2"></i>
                                                     PDF Documents Required </a>
                                             @endif
                                             <br>
                                         </div>
                                         <div class="col-md-12 ml-auto" style="text-align: right">
                                             <a href="{{ url('/create-new-applications') }}" class="btn btn-info">New
                                                 Application</a>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div role="tabpanel"
                             class="tab-pane @if (isset($form_step_type)) @if ($form_step_type == 'add-course') active @else @endif  @endif"
                             id="new_application" aria-expanded="false">

                             <div class="tab-content p-relative">
                                 <!-- progressbar -->
                                 <ul id="progressbar">
                                     <li class="progress1 bg_green">Basic Information</li>
                                     <li
                                         class="progress2 @if (isset($form_step_type)) @if ($form_step_type == 'add-course' || $form_step_type == 'application-payment') bg_green @else @endif  @endif ">
                                         Level Courses
                                     </li>
                                     <li
                                         class="progress3 @if (isset($form_step_type)) @if ($form_step_type == 'application-payment') bg_green @endif  @endif">
                                         Payment
                                     </li>
                                 </ul>

                                 {{-- new application start --}}

                                 <div class="tab-pane @if (isset($form_step_type)) @if ($form_step_type == 'add-course') @else active @endif
@else
active @endif"
                                     role="tabpanel" id="step1">
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
                                                             <label>{{ $data->title ?? '' }}</label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong> Name </strong></label><br>
                                                             {{ $data->firstname ?? '' }}
                                                             {{ $data->middlename ?? '' }}
                                                             {{ $data->lastname ?? '' }}
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
                                                                                 placeholder="Person Name"
                                                                                 class="preventnumeric"
                                                                                 id="person_name"
                                                                                 @isset($id)
                                                                                   value="{{ $Application->Person_Name ?? '' }}"
                                                                                @endisset
                                                                                 required maxlength="30">
                                                                             <span class="text-danger"
                                                                                 id="person_error"></span>
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
                                                                                 maxlength="10" name="Contact_Number"
                                                                                 class="preventalpha"
                                                                                 placeholder="Contact Number"
                                                                                 id="Contact_Number"
                                                                                 @isset($id)
                                                                               value="{{ $Application->Contact_Number ?? '' }}"
                                                                               @endisset>
                                                                         </div>
                                                                         <span class="text-danger"
                                                                             id="contact_error"></span>
                                                                     </div>
                                                                 </div>
                                                                 <div class="col-sm-3">
                                                                     <div class="form-group">
                                                                         <div class="form-line">
                                                                             <label>Email-ID<span
                                                                                     class="text-danger">*</span></label>
                                                                             <input id="emailId" type="text"
                                                                                 name="Email_ID"
                                                                                 placeholder="Email-ID"
                                                                                 @isset($id)
                                                                                    value="{{ $Application->Email_ID ?? '' }}"
                                                                                   @endisset>
                                                                         </div>
                                                                         <span class="text-danger"
                                                                             id="email_id_error"></span>
                                                                     </div>
                                                                 </div>
                                                                 <div class="col-sm-3">
                                                                     <div class="form-group">
                                                                         <div class="form-line">
                                                                             <label>Designation<span
                                                                                     class="text-danger">*</span></label>
                                                                             <input type="text" name="designation"
                                                                                 placeholder="Designation"
                                                                                 @isset($id)
                                                                                 value="{{ $Application->designation ?? '' }}"
                                                                                 @endisset>
                                                                         </div>
                                                                         <span class="text-danger"
                                                                             id="designation_error"></span>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                 </div>
                                             </div>
                                             <!-- basic end -->
                                             <ul class="list-inline pull-right">
                                                 @if (request()->path() == 'level-first')
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
                                 {{-- new application end --}}


                                 {{-- course section start --}}
                                 <div class="tab-pane @if (isset($form_step_type)) @if ($form_step_type == 'add-course' || $form_step_type == 'withour-session-step') active @else @endif  @endif"
                                     role="tabpanel" id="step2">
                                     <div class="card">
                                         <div class="header mb-4">
                                             <h2 style="float:left; clear:none;">Level Courses </h2>


                                             <a href="javascript:void(0);" class="btn btn-outline-primary mb-0"
                                                 style="float:right; clear:none; cursor:pointer;line-height: 24px;"
                                                 onclick="addNewCourse();">
                                                 <i class="fa fa-plus font-14"></i> Add More Course
                                             </a>

                                         </div>
                                         <form action="{{ url('/new-application-course') }}"
                                             enctype="multipart/form-data" method="post" class="form"
                                             id="regForm">
                                             @csrf
                                             <input type="hidden" name="form_step_type" value="add-course">
                                             <div class="body pb-0" id="courses_body">
                                                 <!-- level start -->
                                                 <div class="row clearfix" id="new_course_html"
                                                     data-application-id="{{ $collections->id ?? '' }}"
                                                     data-level-id="{{ isset($Application) ? $Application->level_id : '' }}"
                                                     data-country="{{ $data->country ?? '' }}"
                                                     data-state="{{ $data->state ?? '' }}">
                                                     <div class="col-sm-12 text-righ">

                                                         <div class="d-flex justify-content-end">
                                                             <button type="button" title="Remove course form"
                                                                 class="btn_remove remove-course"
                                                                 onclick="removeCourse(this);" style="display: none;">
                                                                 <i class="fa fa-trash" aria-hidden="true"></i>
                                                             </button>
                                                         </div>
                                                     </div>
                                                     <div class="col-sm-4">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Name<span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="text" placeholder="Course Name"
                                                                     name="course_name[]" required
                                                                     class="preventnumeric" maxlength="50">
                                                             </div>
                                                             @error('course_name')
                                                                 <div class="alert alert-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                         </div>
                                                     </div>
                                                     <input type="hidden" name="application" class="content_id"
                                                         readonly>
                                                     <input type="hidden" name="application_id"
                                                         value="{{ $collections->id ?? '' }}" class="form-control"
                                                         readonly>
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="@if (isset($Application)) {{ $Application->level_id ?? '' }} @endif">
                                                     <input type="hidden" name="coutry"
                                                         value=" {{ $data->country ?? '' }}">
                                                     <input type="hidden" name="state"
                                                         value=" {{ $data->state ?? '' }}">
                                                     <div class="col-sm-4">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Duration<span
                                                                         class="text-danger">*</span></label>

                                                                 <div class="course_group">
                                                                     <input type="text" placeholder="Years"
                                                                         name="years[]" maxlength="4" required
                                                                         class="course_i nput preventalpha">
                                                                     <input type="text" placeholder="Months"
                                                                         name="months[]" maxlength="2" required
                                                                         class="course_input preventalpha">
                                                                     <input type="text" maxlength="2"
                                                                         placeholder="Days " name="days[]" required
                                                                         class="course_input preventalpha">
                                                                     <input type="number" placeholder="Hours"
                                                                         name="hours[]" required class="course_input">
                                                                 </div>
                                                             </div>
                                                             @error('course_duration')
                                                                 <div class="alert alert-danger">{{ $message }}
                                                                 </div>
                                                             @enderror
                                                         </div>
                                                     </div>
                                                     <div class="col-sm-4">
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
                                                     <div class="col-sm-4">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Mode of Course <span
                                                                         class="text-danger">*</span></label>
                                                                 <div class="form-group default-select select2Style">
                                                                     <select class="form-control select2"
                                                                         name="mode_of_course[]" required
                                                                         multiple="" style="width:200px;">
                                                                         <option disabled>Select Mode of Course</option>
                                                                         @foreach (__('arrayfile.mode_of_course_array') as $key => $value)
                                                                             <option value="{{ $value }}">
                                                                                 {{ $value }}</option>
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
                                                     <div class="col-sm-8">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Brief <span
                                                                         class="text-danger">*</span></label>

                                                                 <textarea rows="4" cols="50" class="form-control" name="course_brief[]" required></textarea>
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
                                                                 <label>Declaration (PDF)<span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="file" name="doc1[]"
                                                                     id="payment_reference_no" required
                                                                     class="form-control doc_1 file_size">
                                                             </div>

                                                         </div>
                                                     </div>
                                                     <div class="col-sm-4">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Curriculum / Material / Syllabus
                                                                     (PDF)<span class="text-danger">*</span></label>
                                                                 <input type="file" name="doc2[]"
                                                                     id="payment_reference_no" required
                                                                     class="form-control doc_2 file_size">
                                                             </div>

                                                         </div>
                                                     </div>
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Details (Excel format)<span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="file" name="doc3[]"
                                                                     id="payment_reference_no" required
                                                                     class="form-control doc_3 file_size">
                                                             </div>

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


                                             <div class="row clearfix new-course-row">

                                             </div>
                                             <div class="center">
                                                 <button
                                                     class="btn btn-primary waves-effect m-r-15 add_course">Save</button>
                                             </div>
                                             {{-- @endif --}}
                                         </form>


                                         {{-- course tabel --}}
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

                                                             <th class="center">Action</th>
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
                                                                         days: {{ $courses->days }},
                                                                         Hours: {{ $courses->hours }}
                                                                     </td>
                                                                     <td class="center">{{ $courses->eligibility }}
                                                                     </td>
                                                                     <td class="center">
                                                                         <!-- {{ $courses->id }} -->
                                                                         [ <?php echo get_course_mode($courses->id); ?> ]
                                                                     </td>
                                                                     <td class="center">



                                                                         {{ substr_replace($courses->course_brief, '...', 15) }}


                                                                     </td>
                                                                     <td class="center">
                                                                         @if ($courses->payment == 'false')
                                                                             Pending
                                                                         @endif
                                                                     </td>
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
                                                                         <a onclick="confirmDelete('{{ url('/delete-course' . '/' . dEncrypt($courses->id)) }}')"
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


                                         <script>
                                             function confirmDelete(deleteUrl) {
                                                 Swal.fire({
                                                     title: 'Are you sure?',
                                                     text: "You won't be able to revert this!",
                                                     icon: 'warning',
                                                     showCancelButton: true,
                                                     confirmButtonColor: '#d33',
                                                     cancelButtonColor: '#3085d6',
                                                     confirmButtonText: 'Yes, delete it!',
                                                     cancelButtonText: 'Cancel'
                                                 }).then((result) => {
                                                     if (result.isConfirmed) {
                                                         // If the user confirms, proceed with the delete operation by navigating to the delete URL
                                                         window.location.href = deleteUrl;
                                                     }
                                                 });
                                             }
                                         </script>


                                         <ul class="list-inline pull-right mt-5">
                                             <li><button type="button"
                                                     class="btn btn-danger prev-step">Previous</button>
                                             </li>

                                             <li>

                                                 @isset($course)
                                                     @if (count($course) > 0)
                                                         <button type="button"
                                                             class="btn btn-primary next-step1">Next</button>
                                                     @endif
                                                 @endisset
                                             </li>
                                         </ul>
                                     </div>
                                 </div>
                                 {{-- course section end  --}}

                                 {{-- payment section start --}}
                                 <div class="tab-pane " role="tabpanel" id="step3">
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
                                                 <div class="form-line select-box-hide-class" style="width:25%">
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
                                             <!-- payment start  -->
                                             <div style="text-align:center; width:100%;" id="QR">
                                                 <div
                                                     style="width:100px; height:100px; border:1px solid #ccc; float:left;">
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

                                                 <input type="hidden" name="form_step_type"
                                                     value="application-payment">
                                                 <div class="row clearfix">
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Payment Date <span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="text" name="payment_date"
                                                                     class="form-control" id="payment_date" required
                                                                     placeholder="Payment Date" aria-label="Date"
                                                                     value="{{ old('payment_date') }}"
                                                                     onfocus="focused(this)"
                                                                     onfocusout="defocused(this)"
                                                                     onfocus="showDatePicker()">
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
                                                            @if (Auth::user()->country == '101')
                                                            value="{{ $total_amount + $total_amount * (18 / 100) }}"
                                                            @else
                                                            value="{{ $total_amount }}"
                                                            @endif
                                                            @endisset>
                                                     <input type='hidden' name="course_count"
                                                         @isset($course)
                                                                value="{{ count($course) }}">
                                                                @endisset
                                                         <input type='hidden' name="currency"
                                                         @isset($currency)
                                                                value="{{ $currency }}"
                                                                @endisset>
                                                     @isset($course)
                                                         @foreach ($course as $k => $courses)
                                                             <input type='hidden' name="course_id[]"
                                                                 value="{{ $courses->id }}">
                                                         @endforeach
                                                     @endisset
                                                     @if (request()->path() == 'level-first')
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="sasa {{ $Application->level_id ?? '' }}">
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
                                                     @if (isset($Application->id))
                                                         @if (check_upgraded_level2($Application->id) == 'false')
                                                             <input type="hidden" placeholder="level_id"
                                                                 name="level_id" value="1">
                                                         @elseif(check_upgraded_level2($Application->id) == 'true')
                                                             <input type="hidden" placeholder="level_id"
                                                                 name="level_id" value="2">
                                                         @endif
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
                                                         value=" {{ $data->country ?? '' }}">
                                                     <input type="hidden" name="state"
                                                         value=" {{ $data->state ?? '' }}">
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

                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Payment Proof(jpg,png,jpeg,pdf) <span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="file" name="payment_details_file"
                                                                     id="payment_details_file" required
                                                                     class="form-control payment_details_file  file_size">
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

                                                     <li><button type="submit"
                                                             class="btn btn-primary btn-info-full">Submit</button>
                                                     </li>
                                                 </ul>
                                             </form>
                                         </div>

                                     </div>
                                 </div>
                                 {{-- payment section end --}}

                             </div>
                         </div>


                         {{-- payment application tabel  --}}



                         {{-- faq section start --}}
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
                         {{-- faq section end --}}


                     </div>
                 </div>





                 {{-- @if ($id) [{{$data->image}}] @endif --}}
                 <script>
                     function add_new_course() {
                         $("#courses_body").append($("#add_courses").html());
                     }



                     $(document).ready(function() {

                         $(".prev-step").click(function() {
                             $(".progress3").removeClass('bg_green');
                         })

                     });
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

                                 if (data.ApplicationCourse[0].payment == "false") {
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
                                 Swal.fire({
                                     position: 'center',
                                     icon: 'success',
                                     title: 'Success!',
                                     text: 'Your application has been submitted successfully.',
                                     showConfirmButton: false,
                                     timer: 3000
                                 })

                                 //alert(response.id);
                                 if (response.id) {

                                     $('.content_id').val(response.id);
                                     $('.content_ids').val(response.id);
                                     $("#step1").removeClass('active')
                                     $("#step2").addClass('active')

                                 }


                             },

                             error: function(response) {
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
                                 if (data.ApplicationCourse[0].payment == "false") {
                                     $("#Payment_Status").val("Pending");
                                 }
                                 $("#view_course_brief").val(data.ApplicationCourse[0].course_brief);

                                 $("#view_years").html(data.ApplicationCourse[0].years + " Year(s)");
                                 $("#view_months").html(data.ApplicationCourse[0].months + " Month(s)");
                                 $("#view_days").html(data.ApplicationCourse[0].days + " Day(s)");
                                 $("#view_hours").html(data.ApplicationCourse[0].hours + " Hour(s)");

                                 //alert(data.Document[2].document_file);

                                 $("a#docpdf1").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[
                                         0]
                                     .document_file);
                                 $("a#docpdf2").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[
                                         1]
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

                                 //console.log(data.ApplicationCourse[0].mode_of_course);

                                 console.log(data.ApplicationCourse[0].mode_of_course)

                                 var values = data.ApplicationCourse[0].mode_of_course;
                                 $.each(values, function(i, e) {
                                     $("#mode_of_course_edit option[value='" + e + "']").prop("selected",
                                         true);
                                 });

                                 $('#form_update').attr('action', '{{ url('/course-edit') }}' + '/' + data
                                     .ApplicationCourse[0].id)
                                 $("#Course_Names").val(data.ApplicationCourse[0].course_name);
                                 $("#Eligibilitys").val(data.ApplicationCourse[0].eligibility);
                                 $("#Mode_Of_Courses").val(data.ApplicationCourse[0].mode_of_course);



                                 if (data.ApplicationCourse[0].payment == "false") {
                                     $("#Payment_Statuss").val("Pending");
                                 }

                                 $("#years").val(data.ApplicationCourse[0].years);
                                 $("#months").val(data.ApplicationCourse[0].months);
                                 $("#days").val(data.ApplicationCourse[0].days);
                                 $("#hours").val(data.ApplicationCourse[0].hours);
                                 $("#course_brief").val(data.ApplicationCourse[0].course_brief);

                                 //$("#doc1_edit").val(data.Document[0].document_file);



                                 //alert("yes");
                                 $("a#docpdf1ss").attr("href", "{{ url('show-course-pdf') }}" + '/' + data
                                     .Document[0]
                                     .document_file);
                                 $("a#docpdf2ss").attr("href", "{{ url('show-course-pdf') }}" + '/' + data
                                     .Document[1]
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


                     $.ajax({
                         url: "{{ url('/level-first') }}",
                         type: "get",
                         data: {
                             id: UserName
                         },
                         success: function(data) {


                             // disable alphate
                             $('#postal').keypress(function(e) {
                                 // alert('hello');
                                 var regex = new RegExp("^[0-9_]");
                                 var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                                 if (regex.test(str)) {
                                     return true;
                                 }
                                 e.preventDefault();
                                 return false;


                             });

                         }

                     });
                 </script>



                 <script>
                     $('.preventalpha').keypress(function(e) {
                         //alert("yes");
                         var regex = new RegExp("^[0-9_]");
                         var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                         if (regex.test(str)) {
                             return true;
                         }
                         e.preventDefault();
                         return false;
                     });





                     $('.preventnumeric').keypress(function(e) {
                         //alert("yes");
                         var regex = new RegExp(/^[a-zA-Z\s]+$/);
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
                         if (r.test(v)) {
                             $(this).val(v.replace(r, ''));
                             c--;
                         }
                         this.setSelectionRange(c, c);
                     });
                 </script>
                 <script>
                     var doc_payment_file = "";

                     $('.payment_details_file').on('change', function() {

                         doc_payment_file = $(".payment_details_file").val();

                         var doc_payment_files = doc_payment_file.split('.').pop();

                         if (doc_payment_files == 'png' || doc_payment_files == 'jpg' || doc_payment_files == 'pdf' ||
                             doc_payment_files == 'jpeg') {
                             // alert("File uploaded is pdf");
                         } else {

                             Swal.fire({
                                 position: 'center',
                                 icon: 'error',
                                 title: 'Validation error!',
                                 text: 'Only jpg, png, jpeg ,pdf are allowed',
                                 showConfirmButton: false,
                                 timer: 3000
                             })
                             $('.payment_details_file').val("");
                         }

                     });
                 </script>
                 <script>
                     var doc_file1 = "";

                     $('.doc_1').on('change', function() {

                         doc_file1 = $(".doc_1").val();
                         console.log(doc_file1);
                         var doc_file1 = doc_file1.split('.').pop();
                         if (doc_file1 == 'pdf') {
                             // alert("File uploaded is pdf");
                         } else {
                             Swal.fire({
                                 position: 'center',
                                 icon: 'error',
                                 title: 'Validation error!',
                                 text: 'Only PDF files are allowed',
                                 showConfirmButton: false,
                                 timer: 3000
                             })
                             $('.doc_1').val("");
                         }

                     });
                 </script>
                 <script>
                     var doc_file2 = "";
                     $('.doc_2').on('change', function() {

                         doc_file2 = $(".doc_2").val();
                         console.log(doc_file2);
                         var doc_file2 = doc_file2.split('.').pop();
                         if (doc_file2 == 'pdf') {
                             // alert("File uploaded is pdf");
                         } else {
                             Swal.fire({
                                 position: 'center',
                                 icon: 'error',
                                 title: 'Validation error!',
                                 text: 'Only PDF files are allowed',
                                 showConfirmButton: false,
                                 timer: 3000
                             })
                             $('.doc_2').val("");
                         }

                     });
                 </script>
                 <script>
                     var doc_file3 = "";
                     $('.doc_3').on('change', function() {

                         doc_file3 = $(".doc_3").val();
                         console.log(doc_file3);
                         var doc_file3 = doc_file3.split('.').pop();


                         if (doc_file3 == 'csv' || doc_file3 == 'xlsx' || doc_file3 == 'xls') {
                             // alert("File uploaded is pdf");
                         } else {
                             //  alert("Only csv,xlsx,xls  are allowed")
                             Swal.fire({
                                 position: 'center',
                                 icon: 'error',
                                 title: 'Validation error!',
                                 text: 'Only csv,xlsx, and xlsx are allowed',
                                 showConfirmButton: false,
                                 timer: 3000
                             })
                             $('.doc_3').val("");
                         }

                     });
                 </script>
                 <script>
                     var doc_file1 = "";

                     $('.doc_edit_1').on('change', function() {

                         doc_file1 = $(".doc_edit_1").val();
                         // alert(doc_file1);
                         console.log(doc_file1);
                         var doc_file1 = doc_file1.split('.').pop();
                         if (doc_file1 == 'pdf') {
                             // alert("File uploaded is pdf");
                         } else {
                             Swal.fire({
                                 position: 'center',
                                 icon: 'error',
                                 title: 'Validation error!',
                                 text: 'Only PDF files are allowed',
                                 showConfirmButton: false,
                                 timer: 3000
                             })
                             $('.doc_edit_1').val("");
                         }

                     });
                 </script>
                 <script>
                     var doc_file_edit2 = "";

                     $('.doc_edit_2').on('change', function() {

                         doc_file_edit2 = $(".doc_edit_2").val();
                         // alert(doc_file1);
                         console.log(doc_file_edit2);
                         var doc_file1 = doc_file_edit2.split('.').pop();
                         if (doc_file1 == 'pdf') {
                             // alert("File uploaded is pdf");
                         } else {
                             Swal.fire({
                                 position: 'center',
                                 icon: 'error',
                                 title: 'Validation error!',
                                 text: 'Only PDF files are allowed',
                                 showConfirmButton: false,
                                 timer: 3000
                             })
                             $('.doc_edit_2').val("");
                         }

                     });
                 </script>
                 <script>
                     var doc_file_edit3 = "";

                     $('.doc_edit_3').on('change', function() {
                         doc_file_edit3 = $(".doc_edit_3").val();
                         // alert(doc_file1);
                         console.log(doc_file_edit3);
                         var doc_file = doc_file_edit3.split('.').pop();
                         if (doc_file == 'csv' || doc_file == 'xlsx' || doc_file == 'xls') {
                             // alert("File uploaded is pdf");
                         } else {
                             Swal.fire({
                                 position: 'center',
                                 icon: 'error',
                                 title: 'Validation error!',
                                 text: 'Only PDF files are allowed',
                                 showConfirmButton: false,
                                 timer: 3000
                             })
                             $('.doc_edit_3').val("");
                         }

                     });
                 </script>
                 <script>
                     $(function() {
                         //Multi-select
                         $("#optgroup").multiSelect({
                             selectableOptgroup: true
                         });

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
                 @if ($message = Session::has('session_for_redirections'))
                     @php
                         Session::forget('session_for_redirections');
                     @endphp
                 @endif
                 @include('layout.footer')
                 <!-- New JS -->
                 <script>
                     function confirm_option(action) {
                         if (!confirm("Are you sure to " + action + ", this record!")) {
                             return false;
                         }

                         return true;

                     }
                 </script>
                 <script>
                     function confirm_to_switch() {
                         if (!confirm("Are you sure to switch to upgrade level!")) {
                             return false;
                         }

                         $('#exampleModalToggle').modal('show');
                         return true;

                     }


                     $(document).ready(function() {
                         $("#add-new-application").click(function() {
                             $("#new_application").addClass('active');
                             $(".add-active-b").addClass('active');
                             $("#general_information").removeClass('active');
                         })
                     });
                 </script>
                 <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                     aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                     <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalToggleLabel">Upgrade Level Model</h5>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal"
                                     aria-label="Close"></button>
                             </div>
                             <div class="modal-body">
                                 <form action="{{ url('upgrade-level') }}" method="post">
                                     <input type="hidden" id="application_id_upgrade" name="application_id_upgrade">
                                     <input type="hidden" id="level_id_upgrade1" name="level_id_upgrade">
                                     @csrf
                                     <div class="row">
                                         <div class="col-sm-12 col-md-3">
                                             <span style="float:left;"> Current Level </span>
                                         </div>
                                         <div class="col-sm-12 col-md-9" style="float:right;">
                                             <input type="text" id="level_id_upgrade" name="level_id_upgrade">
                                         </div>
                                         <br><br>
                                         <div class="col-sm-12 col-md-12">
                                             <input type="submit" class="btn" value="Upgrade to next levet">
                                         </div>
                                     </div>
                                     <p>
                                 </form>
                             </div>
                             <div class="modal-footer">
                                 <!-- <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Open second modal</button> -->
                             </div>
                         </div>
                     </div>
                 </div>
                 <script>
                     $(document).ready(function() {
                         $(".button-blinking").click(function() {

                             let level_id = $(this).closest('.gradeX').find('#upgrade-btn-level-id').val();
                             let application_id = $(this).closest('.gradeX').find('#upgrade-btn-application-id').val();
                             $('#level_id_upgrade').val(level_id);
                             $('#application_id_upgrade').val(application_id);
                             /*  alert(application_id);
                                 alert(level_id);*/


                         });
                     })
                 </script>

                 <script>
                     function load() {
                         $('.btn').prop('disabled', true);
                         setTimeout(function() {
                             $('.btn').prop('disabled', false);
                         }, 10000);
                         $("#form").submit();
                     }
                 </script>
                 <!-- <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Open first modal</a> -->
                 <script src="{{ asset('assets/js/form.min.js') }} "></script>
                 <script src="{{ asset('assets/js/bundles/multiselect/js/jquery.multi-select.js') }}"></script>
                 <script src="{{ asset('assets/js/bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js') }} "></script>
                 <script src=" {{ asset('assets/js/pages/forms/advanced-form-elements.js') }}"></script>


                 <script>
                     var isAppending = false; // Flag to prevent multiple append requests

                     function addNewCourse() {
                         if (!isAppending) {
                             isAppending = true;

                             // Clone the template row
                             var newRow = $('#new_course_html').clone();

                             // Clear input fields and remove any unwanted attributes
                             newRow.find('input, textarea').val('');
                             newRow.find('input[type="file"]').removeAttr('id').val('');

                             // Remove the ID attribute from the remove button
                             newRow.find('.remove-course').removeAttr('id');

                             // Show the remove button for the new row
                             newRow.find('.remove-course').show();

                             // Add a class to the new row
                             newRow.addClass('new-course-html');

                             // Append the new row to the container
                             $('.new-course-row').append(newRow); // Append to the existing .new-course-row div

                             // Read data attributes and set hidden field values
                             var applicationId = newRow.data('application-id');
                             var levelId = newRow.data('level-id');
                             var country = newRow.data('country');
                             var state = newRow.data('state');

                             // Set values for the hidden fields
                             newRow.find('input[name="application_id"]').val(applicationId);
                             newRow.find('input[name="level_id"]').val(levelId);
                             newRow.find('input[name="country"]').val(country);
                             newRow.find('input[name="state"]').val(state);

                             // Initialize select2 for the cloned <select> elements
                             newRow.find('.select2').select2();

                             isAppending = false; // Reset the flag
                         }
                     }

                     function removeCourse(button) {
                         // Find the parent row and remove it
                         $(button).closest('.new-course-html').remove();
                     }


                     $('#Contact_Number').on('keyup', function() {
                         // Get the contact number value
                         var contactNumber = $(this).val();

                         // Check if the contact number is empty
                         if (contactNumber === '') {
                             // Clear the error message and exit
                             $('#contact_error').text('');
                             return;
                         }

                         // Check if the contact number is numeric and has exactly 10 digits
                         if (/^\d{10}$/.test(contactNumber)) {
                             // Send an AJAX request
                             $.ajax({
                                 type: 'POST',
                                 url: '/checkContactNumber', // Update with your Laravel route URL
                                 data: {
                                     contact_number: contactNumber,
                                     _token: '{{ csrf_token() }}' // Replace with the way you generate CSRF token in your Blade view
                                 },
                                 success: function(response) {
                                     if (response.status === 'duplicate') {
                                         // Display the error message in the #contact_error span
                                         $('#contact_error').text('Contact number is already in use.');
                                     } else {
                                         // Clear the error message if the contact number is unique
                                         $('#contact_error').text('');
                                     }
                                 },
                                 error: function(xhr, status, error) {
                                     // Handle AJAX errors if needed
                                 }
                             });
                         } else {
                             // Display an error message for an invalid contact number
                             $('#contact_error').text('Contact number must be 10 digits and numeric.');
                         }
                     });


                     $('#emailId').on('keyup', function() {
                         // Get the email value
                         var email = $(this).val();

                         // Check if the email is empty
                         if (email === '') {
                             // Clear the error message and exit
                             $('#email_id_error').text('');
                             return;
                         }

                         // Check if the email format is valid
                         if (/^\S+@\S+\.\S+$/.test(email)) {
                             // Send an AJAX request
                             $.ajax({
                                 type: 'POST',
                                 url: '/checkEmail', // Update with your Laravel route URL
                                 data: {
                                     email: email,
                                     _token: '{{ csrf_token() }}' // Replace with the way you generate CSRF token in your Blade view
                                 },
                                 success: function(response) {
                                     if (response.status === 'duplicate') {
                                         // Display the error message in the #email_id_error span
                                         $('#email_id_error').text('Email is already in use.');
                                     } else {
                                         // Clear the error message if the email is unique
                                         $('#email_id_error').text('');
                                     }
                                 },
                                 error: function(xhr, status, error) {
                                     // Handle AJAX errors if needed
                                 }
                             });
                         } else {
                             // Display an error message for an invalid email format
                             $('#email_id_error').text('Invalid email format.');
                         }
                     });
                 </script>

                 <script>
                     function showDatePicker() {
                         // Get the current year
                         var currentYear = new Date().getFullYear();

                         // Set the minimum date to January 1st of the current year
                         var minDate = currentYear + "-01-01";

                         // Set the minimum date for the input field
                         document.getElementById("payment_date").setAttribute("min", minDate);
                     }
                 </script>
 </body>
