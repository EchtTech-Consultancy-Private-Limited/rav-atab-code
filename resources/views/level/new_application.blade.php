 @include('layout.header')

 <style>
     @media (min-width: 900px) {
         .modal-dialog {
             max-width: 674px;
         }
     }
 </style>


 <title>RAV Accreditation</title>

 </head>

 <body class="light">
     <!-- Page Loader -->
     {{-- <div class="page-loader-wrapper">
         <div class="loader">
             <div class="m-t-30">
                 <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
             </div>
             <p>Please wait...</p>
         </div>
     </div> --}}
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
                                 <h4 class="page-title">Level</h4>
                             </li>
                             <li class="breadcrumb-item bcrumb-1">
                                 <a href="{{ url('/dashboard') }}">
                                     <i class="fas fa-home"></i> Home</a>
                             </li>
                             <li class="breadcrumb-item active">Level </li>
                         </ul>
                     </div>
                 </div>
             </div>

             <div class="row ">
                 <div class="row clearfix">

                     <div class="col-lg-12 col-md-12">
                         <div class="card">
                             <div>
                                 <div class="p-2">
                                     <ul class="nav ">


                                         <li class="nav-item">
                                             <a class="nav-link active" href="#new_application" data-bs-toggle="tab">New
                                                 Application </a>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" href="{{ url('/appliction-list') }}">Previous
                                                 Applications</a>
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

                         <div>
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
                                                     <form class="form" action="{{ url('/new-applications') }}"
                                                         method="post">
                                                         @csrf
                                                         @if ($applicationData)
                                                             <input type="hidden" name="previous_data" value="1">
                                                             <input type="hidden" name="application_id"
                                                                 value="{{ $applicationData->id }}">
                                                         @endif
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
                                                                                 @isset($applicationData)
                                                                                  value="{{ $applicationData->Person_Name ?? '' }}"
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
                                                                                 @isset($applicationData)
                                                                              value="{{ $applicationData->Contact_Number ?? '' }}"
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
                                                                                 @isset($applicationData)
           value="{{ $applicationData->Email_ID ?? '' }}"
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
                                                                                 @isset($applicationData)
                                                                                value="{{ $applicationData->designation ?? '' }}"
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
                                                 <li><button type="submit" class="btn btn-primary next-step">
                                                         Next</button></li>
                                             </ul>
                                             </form>
                                         </div>
                                     </div>
                                 </div>


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


                                 <script>
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
                                                 url: '/phone-validation', // Update with your Laravel route URL
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
                                                 url: '/email-validation', // Update with your Laravel route URL
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


                                 @include('layout.footer')
