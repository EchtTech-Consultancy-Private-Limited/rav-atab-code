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
    @php
    $failMessage = session('fail');
@endphp

@if($failMessage)
    <script>
        toastr.error('{{ $failMessage }}', {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 0,
        });
    </script>
@endif
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
                            <li
                                class="progress2 bg_green @if (isset($form_step_type)) @if ($form_step_type == 'add-course' || $form_step_type == 'application-payment') bg_green @else @endif  @endif ">
                                Level Courses
                            </li>
                            <li
                                class="progress3 bg_green @if (isset($form_step_type)) @if ($form_step_type == 'application-payment') bg_green @endif  @endif">
                                Payment
                            </li>
                        </ul>
                        <div class="taboanel" role="tabpanel" id="step3">
                            <div class="card">
                                <div class="header">
                                    <h2 style="float:left; clear:none;">Payment</h2>
                                    <h6 style="float:right; clear:none;" id="counter">
                                        Total Amount (with 18% GST): {{ $total_amount + $total_amount * 0.18 ?? 0 }}
                                    </h6>
                                </div>
                                <div class="body">
                                    <form action="{{ url('/create-application-payment') }}" method="post" class="form"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <div class="form-line select-box-hide-class" style="width:25%">
                                                <label>Payment Mode<span class="text-danger">*</span></label>
                                                <select name="payment" class="form-control payment_mode" id="payments"
                                                    required>
                                                    <option value="">Select Option</option>
                                                    <option value="QR-Code"
                                                        {{ old('QR-Code') == 'QR-Code' ? 'selected' : '' }}>QR
                                                        Code
                                                    </option>
                                                    <option value="Bank"
                                                        {{ old('title') == 'Bank' ? 'selected' : '' }}>
                                                        Bank
                                                        Transfers
                                                    </option>
                                                </select>
                                                <label for="payment" id="payment-error" class="error">
                                                    @error('payment')
                                                        {{ $message }}
                                                    @enderror
                                                </label>
                                            </div>
                                        </div>
                                        <!-- payment start -->
                                        <div style="text-align:center; width:100%;" id="QR">
                                            <div style="width:100px; height:100px; border:1px solid #ccc; float:left;">
                                                <img src="{{ asset('/assets/images/demo-qrcode.png') }}" width="100"
                                                    height="100">
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

                                        <input type="hidden" name="form_step_type" value="application-payment">
                                        <div class="row clearfix">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Payment Date <span class="text-danger">*</span></label>
                                                        <input type="text" name="payment_date"
                                                            class="form-control paymentDate" id="payment_date" required
                                                            placeholder="Payment Date (DD-MM-YY)" aria-label="Date"
                                                            value="{{ old('payment_date') }}" onfocus="showDatePicker()"
                                                            autocomplete="off" min="{{ date('Y-m-d') }}">
                                                    </div>

                                                    <label for="payment_date" id="payment_date-error" class="error">
                                                        @error('payment_date')
                                                            {{ $message }}
                                                        @enderror
                                                    </label>
                                                </div>
                                            </div>
                                            <input type='hidden' name="amount"
                                                @isset($total_amount) @if (Auth::user()->country == '101')
                                             value="{{ $total_amount + $total_amount * (18 / 100) }}"
                                             @else
                                             value="{{ $total_amount }}"
                                             @endif
                                             @endisset>
                                            <input type='hidden' name="course_count"
                                                @isset($course) value="{{ count($course) }}">
                                             @endisset
                                                <input type='hidden' name="currency"
                                                @isset($currency) value="{{ $currency }}" @endisset>
                                            @isset($course)
                                                @foreach ($course as $k => $courses)
                                                    <input type='hidden' name="course_id[]"
                                                        value="{{ $courses->id }}">
                                                @endforeach
                                            @endisset

                                            @if ($applicationData)
                                                <input type="hidden" placeholder="level_id" name="level_id"
                                                    value="{{ $applicationData->level_id ?? '' }}">
                                            @endif

                                            @if (request()->path() == 'level-first')
                                                <input type="hidden" placeholder="level_id" name="level_id"
                                                    value="{{ $Application->level_id ?? '' }}">
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
                                                    <input type="hidden" placeholder="level_id" name="level_id"
                                                        value="1">
                                                @elseif(check_upgraded_level2($Application->id) == 'true')
                                                    <input type="hidden" placeholder="level_id" name="level_id"
                                                        value="2">
                                                @endif
                                            @endif
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="payment_transaction_no">Payment Transaction no.
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Payment Transaction no."
                                                            id="payment_transaction_no" required name="transaction_no"
                                                            minlength="9" maxlength="18" class="transactionNo"
                                                            value="{{ old('transaction_no') }}"
                                                            autocomplete="off" 
                                                            >
                                                    </div>
                                                    <label for="payment_transaction_no"
                                                        id="payment_transaction_no-error" class="error">
                                                        @error('transaction_no')
                                                            {{ $message }}
                                                        @enderror
                                                    </label>
                                                </div>
                                            </div>
                                            <input type="hidden" name="coutry"
                                                value=" {{ $applicationData->country ?? '' }}">
                                            <input type="hidden" name="state"
                                                value=" {{ $applicationData->state ?? '' }}">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="payment_reference_no">Payment Reference no. <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Payment Reference no."
                                                            id="payment_reference_no" required name="reference_no"
                                                            minlength="9" maxlength="18" class="referenceNo"
                                                            value="{{ old('reference_no') }}"
                                                            autocomplete="off"
                                                            >
                                                    </div>
                                                    <label for="payment_reference_no" id="payment_reference_no-error"
                                                        class="error">
                                                        @error('reference_no')
                                                            {{ $message }}
                                                        @enderror
                                                    </label>
                                                </div>
                                            </div>
                                            <input type="hidden" value="{{ $applicationData->id ?? '' }}"
                                                name="Application_id" required class="course_input">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Payment Proof(jpg,png,jpeg,pdf) <span
                                                                class="text-danger">*</span></label>
                                                        <input type="file" name="payment_details_file"
                                                            id="payment_details_file" required class="paymentProof"
                                                            class="form-control payment_details_file  file_size">
                                                    </div>
                                                    <label for="paymentProofError" id="paymentProofError"
                                                        class="error">
                                                        @error('paymentProofError')
                                                            {{ $message }}
                                                        @enderror
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="list-inline pull-right">
                                       
                                            <!-- <li><a href="{{ url('create-new-course/' .  dEncrypt($applicationData->id)) }}"
                                                    class="btn btn-danger prev-step1">Previous</a></li> -->
                                            <li><button id="submitBtn" type="submit"
                                                    class="btn btn-primary btn-info-full">Submit</button>
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

                @include('layout.footer')

                <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>


                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const form = document.getElementById("regForm"); // Change this to your form's actual ID
                        const submitBtn = document.getElementById("submitBtn"); // Change this to your button's actual ID

                        form.addEventListener("submit", function() {
                            submitBtn.disabled = true; // Disable the button when the form is submitted
                        });
                    });
                </script>

                <script>
                    const submitBtn = document.getElementById("submitBtn");
                    $(document).ready(function() {



                        // Hide elements on page load
                        $("#bank_id").hide();
                        $("#QR").hide();

                        // Handle the 'change' event on the payment type dropdown
                        $("#payments").on('change', function() {
                            var type = $('#payments').val();

                            if (type === 'QR-Code') {
                                $("#bank_id").hide();
                                $("#QR").show();
                                submitBtn.disabled = false;
                            } else if (type === 'Bank') {
                                $("#bank_id").show();
                                $("#QR").hide();
                                submitBtn.disabled = false;
                            } else {
                                $("#bank_id").hide();
                                $("#QR").hide();
                                submitBtn.disabled = true;
                            }
                        });

                        // Initialize datepicker for payment_date field
                        $("#payment_date").datepicker({
                            dateFormat: 'dd-mm-yy',
                            maxDate: 0, // Disable future dates
                            defaultDate: 0, // Set the default date to today
                        });

                        // Disable manual typing in the date field
                        $("#payment_date").on('keydown', function(e) {
                            e.preventDefault();
                        });
                    });
                </script>


                <script>
                    $(document).ready(function() {



                        var doc_payment_file = "";

                        $('#payment_details_file').on('change', function() {
                            doc_payment_file = $(this).val();

                            var doc_payment_files = doc_payment_file.split('.').pop();

                            if (doc_payment_files === 'png' || doc_payment_files === 'jpg' || doc_payment_files ===
                                'pdf' || doc_payment_files === 'jpeg') {
                                $('#submitBtn').attr('disabled', false);
                            } else {
                                toastr.error("Only jpg, png, jpeg, pdf are allowed", {
                                    timeOut: 0,
                                    extendedTimeOut: 0,
                                    closeButton: true,
                                    closeDuration: 0,
                                });
                                $(this).val(""); // Clear the input field
                                $('#submitBtn').attr('disabled', true);
                            }
                        });
                    });
                </script>


                <script>
                    // $(document).ready(function() {

                    //     // Get the application_id from your input field or other source.
                    //     var applicationId = {{ $applicationData->id }};
                    //     // Send an AJAX request to check for payment duplicacy.
                    //     $.ajax({
                    //         type: 'POST',
                    //         url: '{{ route('payment.duplicate') }}',
                    //         data: {
                    //             '_token': '{{ csrf_token() }}',
                    //             'application_id': applicationId
                    //         },
                    //         success: function(response) {
                    //             if (response.paymentExist) {
                    //                 toastr.error("Payment has already been submitted for this application.", {
                    //                 timeOut: 0,
                    //                 extendedTimeOut: 0,
                    //                 closeButton: true,
                    //                 closeDuration: 0,
                    //             });

                    //                 window.location.href = '{{ url('get-application-list') }}';
                    //             } else {
                    //                 // Payment does not exist; you can perform another action or show a message.
                    //             }
                    //         },
                    //         error: function(error) {
                    //             console.error('An error occurred: ' + error);
                    //         }
                    //     });

                    // });
                </script>

                <script>
                    $('#payment_transaction_no').on('keyup focusout', function() {
                        // Get the payment transaction number value
                        var paymentTransactionNo = $(this).val();

                        // Check if the payment transaction number is empty
                        if (paymentTransactionNo === '') {
                            // Clear the error message
                            $('#payment_transaction_no-error').text('');
                            // Disable the button
                            // $('#submitBtn').attr('disabled', true);
                            return;
                        }

                        // Remove whitespace from the input
                        paymentTransactionNo = paymentTransactionNo.replace(/\s/g, '');

                        // Update the input value
                        $(this).val(paymentTransactionNo);

                        // Check if the input contains special characters
                        if (!/^[a-zA-Z0-9]+$/.test(paymentTransactionNo)) {
                            $('#payment_transaction_no-error').text(
                                'Payment Transaction no. must not contain special characters');
                            // Disable the button
                            $('#submitBtn').attr('disabled', true);
                            return;
                        }else{
                            $('#submitBtn').attr('disabled', false);

                        }

                        // Check if the length of the input is less than the minimum required length
                        if (paymentTransactionNo.length < 9) {
                            $('#payment_transaction_no-error').text('Payment Transaction no. must be at least 9 characters');
                            // Disable the button
                             $('#submitBtn').attr('disabled', true);
                            return;
                        }else{
                             $('#submitBtn').attr('disabled', false);

                        }

                        $.ajax({
                            type: 'POST', // or 'GET' based on your route
                            url: '{{ route('transaction_validation') }}',
                            data: {
                                _token: $('input[name="_token"]').val(),
                                transaction_no: paymentTransactionNo
                            },
                            success: function(response) {
                                // Handle the response from the server
                                if (response.status == 'error') {
                                    $('#payment_transaction_no-error').html('<p class="text-danger">' + response
                                        .message + '</p');
                                    // Disable the button
                                    $('#submitBtn').attr('disabled', true);
                                } else if (response.status == 'success') {
                                    $('#payment_transaction_no-error').html('<p class="text-success">' + response
                                        .message + '</p');
                                        $('#submitBtn').attr('disabled', false);
                                    
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle AJAX errors if any
                                console.error(error);
                                $('#submitBtn').attr('disabled', false);
                            }
                        });
                    });

                    $('#payment_reference_no').on('keyup', function() {
                        // Get the payment reference number value
                        var paymentReferenceNo = $(this).val();

                        // Check if the payment reference number is empty
                        if (paymentReferenceNo === '') {
                            // Clear the error message and exit
                            $('#payment_reference_no-error').text('');
                            return;
                        }

                        var paymentReferenceNo = $(this).val().replace(/\s/g, '');

                        // Update the input value
                        $(this).val(paymentReferenceNo);

                        // Check if the input contains special characters
                        if (!/^[a-zA-Z0-9]+$/.test(paymentReferenceNo)) {
                            $('#payment_reference_no-error').text(
                                'Payment Reference no. must not contain special characters.');
                                $('#submitBtn').attr('disabled', true);
                            return;
                        }else{
                            $('#submitBtn').attr('disabled', false);
                        }

                        // Check if the length of the input is less than the minimum required length
                        if (paymentReferenceNo.length < 9) {
                            $('#payment_reference_no-error').text('Payment Reference no. must be at least 9 characters.');
                            $('#submitBtn').attr('disabled', true);
                        } else {
                            $('#submitBtn').attr('disabled', false);

                            $.ajax({
                                type: 'POST', // or 'GET' based on your route
                                url: '{{ route('reference_validation') }}',
                                data: {
                                    _token: $('input[name="_token"]').val(),
                                    reference_no: paymentReferenceNo
                                },
                                success: function(response) {
                                    // Handle the response from the server
                                    if (response.status === 'error') {
                                        $('#payment_reference_no-error').html('<p class="text-danger">' + response
                                            .message +
                                            '</p>');
                                        $('#submitBtn').attr('disabled', true);
                                    } else if (response.status === 'success') {
                                        $('#payment_reference_no-error').html('<p class="text-success">' + response
                                            .message +
                                            '</p>');
                                            $('#submitBtn').attr('disabled', false);


                                    }
                                },
                                error: function(xhr, status, error) {
                                    // Handle AJAX errors if any
                                    $('#submitBtn').attr('disabled', false);

                                }
                            });
                            // Clear the error message if the length is valid
                            $('#payment_reference_no-error').text('');
                        }
                    });
                </script>



</body>
