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
                     <div class="tab-content">
                         <!-- progressbar -->
                         <ul id="progressbar">
                             <li class="progress1 bg_green">Basic Information</li>
                             <li class="progress2 bg_green @if (isset($form_step_type)) @if ($form_step_type == 'add-course' || $form_step_type == 'application-payment') bg_green @else @endif  @endif ">
                                 Level Courses
                             </li>
                             <li class="progress3 bg_green @if (isset($form_step_type)) @if ($form_step_type == 'application-payment') bg_green @endif  @endif">
                                 Payment
                             </li>
                         </ul>
                         <div class="taboanel" role="tabpanel" id="step3">
                             <div class="card">
                                 <div class="header">
                                     <h2 style="float:left; clear:none;">Payment</h2>
                                     <h6 style="float:right; clear:none;" id="counter">
                                         Total Amount: 1000
                                         </h2>
                                 </div>
                                 <div class="body">
                                     <div class="form-group">
                                         <div class="form-line select-box-hide-class" style="width:25%">
                                             <label>Payment Mode<span class="text-danger">*</span></label>
                                             <select name="payment" class="form-control" id="payments">
                                                 <option value="">Select Option</option>
                                                 <option value="QR-Code" {{ old('QR-Code') == 'QR-Code' ? 'selected' : '' }}>QR
                                                     Code
                                                 </option>
                                                 <option value="Bank" {{ old('title') == 'Bank' ? 'selected' : '' }}>Bank
                                                     Transfers
                                                 </option>
                                             </select>
                                         </div>
                                     </div>
                                     <!-- payment start -->
                                     <div style="text-align:center; width:100%;" id="QR">
                                         <div style="width:100px; height:100px; border:1px solid #ccc; float:left;">
                                             <img src="{{ asset('/assets/images/demo-qrcode.png') }}" width="100" height="100">
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
                                    <form action="{{ url('/new-application_payment') }}" method="post" class="form" id="regForm" enctype="multipart/form-data">
                                         @csrf

                                         <input type="hidden" name="form_step_type" value="application-payment">
                                         <div class="row clearfix">
                                             <div class="col-sm-3">
                                                 <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Payment Date <span class="text-danger">*</span></label>
                                                        <input type="text" name="payment_date" class="form-control" id="payment_date" required placeholder="Payment Date" aria-label="Date" value="{{ old('payment_date') }}" onfocus="showDatePicker()" autocomplete="off" min="{{ date('Y-m-d') }}">
                                                    </div>

                                                     <label for="payment_date" id="payment_date-error" class="error">
                                                         @error('payment_date')
                                                         {{ $message }}
                                                         @enderror
                                                     </label>
                                                 </div>
                                             </div>
                                             <input type='hidden' name="amount" @isset($total_amount) @if (Auth::user()->country == '101')
                                             value="{{ $total_amount + $total_amount * (18 / 100) }}"
                                             @else
                                             value="{{ $total_amount }}"
                                             @endif
                                             @endisset>
                                             <input type='hidden' name="course_count" @isset($course) value="{{ count($course) }}">
                                             @endisset
                                             <input type='hidden' name="currency" @isset($currency) value="{{ $currency }}" @endisset>
                                             @isset($course)
                                             @foreach ($course as $k => $courses)
                                             <input type='hidden' name="course_id[]" value="{{ $courses->id }}">
                                             @endforeach
                                             @endisset

                                             @if ($applicationData)
                                             <input type="hidden" placeholder="level_id" name="level_id" value="{{ $applicationData->level_id ?? '' }}">
                                             @endif

                                             @if (request()->path() == 'level-first')
                                             <input type="hidden" placeholder="level_id" name="level_id" value="{{ $Application->level_id ?? '' }}">
                                             @elseif(request()->path() == 'level-second')
                                             <input type="hidden" placeholder="level_id" name="level_id" value="{{ 2 }}">
                                             @elseif(request()->path() == 'level-third')
                                             <input type="hidden" placeholder="level_id" name="level_id" value="{{ 3 }}">
                                             @elseif(request()->path() == 'level-fourth')
                                             <input type="hidden" placeholder="level_id" name="level_id" value="{{ 4 }}">
                                             @endif
                                             @if (isset($Application->id))
                                             @if (check_upgraded_level2($Application->id) == 'false')
                                             <input type="hidden" placeholder="level_id" name="level_id" value="1">
                                             @elseif(check_upgraded_level2($Application->id) == 'true')
                                             <input type="hidden" placeholder="level_id" name="level_id" value="2">
                                             @endif
                                             @endif
                                             <div class="col-sm-3">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label for="payment_transaction_no">Payment
                                                             Transaction
                                                             no. <span class="text-danger">*</span></label>
                                                         <input type="text" placeholder="Payment Transaction no." id="payment_transaction_no" required name="payment_transaction_no" minlength="9" maxlength="18" value="{{ old('payment_transaction_no') }}" autocomplete="off">
                                                     </div>
                                                     <label for="payment_transaction_no" id="payment_transaction_no-error" class="error">
                                                         @error('payment_transaction_no')
                                                         {{ $message }}
                                                         @enderror
                                                     </label>
                                                 </div>
                                             </div>
                                             <input type="hidden" name="coutry" value=" {{ $applicationData->country ?? '' }}">
                                             <input type="hidden" name="state" value=" {{ $applicationData->state ?? '' }}">
                                             <div class="col-sm-3">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label>Payment Reference no. <span class="text-danger">*</span></label>
                                                         <input type="text" required placeholder="Payment Reference no." name="payment_reference_no" minlength="9" maxlength="18" value="{{ old('payment_reference_no') }}" autocomplete="off">
                                                     </div>
                                                     <label for="payment_reference_no" id="payment_reference_no-error" class="error">
                                                         @error('payment_reference_no')
                                                         {{ $message }}
                                                         @enderror
                                                     </label>
                                                 </div>
                                             </div>
                                             <input type="hidden" value="{{ $applicationData->id ?? '' }}" name="Application_id" required class="course_input">
                                             <div class="col-sm-3">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label>Payment Proof(jpg,png,jpeg,pdf) <span class="text-danger">*</span></label>
                                                         <input type="file" name="payment_details_file" id="payment_details_file" required class="form-control payment_details_file  file_size">
                                                     </div>
                                                     <label for="payment_reference_no" id="payment_reference_no-error" class="error">
                                                         @error('payment_reference_no')
                                                         {{ $message }}
                                                         @enderror
                                                     </label>
                                                 </div>
                                             </div>
                                         </div>
                                         <ul class="list-inline pull-right">
                                             <li><a href="{{ url('create-course/'.$applicationData->id) }}" class="btn btn-danger prev-step1">Previous</a></li>
                                             <li><button type="submit" class="btn btn-primary btn-info-full">Submit</button>
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

    <script src="{{ asset('assets/js/jquery-3.6.0.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>

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
                                 $("#bank_id").show();
                                 $("#QR").show();

                             } else {

                                 //  alert('hii1')
                                 $("#bank_id").show();
                                 $("#QR").hide();

                             }
                         });
                     });

         $(function() {
            $("#payment_date").datepicker();
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
    // Initialize the datepicker with options
    var datePicker = new Datepicker(document.getElementById('payment_date'), {
        format: 'yyyy-mm-dd',
        autohide: true,
        startDate: new Date(), // Start from today's date
        endDate: new Date(2099, 12, 31) // Set an upper limit for future dates
    });
</script>
 </body>
