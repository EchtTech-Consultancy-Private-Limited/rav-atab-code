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
    <div class="full_screen_loading">Loading&#8230;</div>
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

                    <div class="float-right">
                        <a href="{{ url('account/application-list') }}" type="button" class="btn btn-primary">Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-white text-dark d-flex justify-content-between align-items-center">
                <h5 class="mt-2">
                    Basic Information
                </h5>
                <div>
                    <span style="font-weight: bold;">Application ID:</span> RAVAP-{{ $spocData->id }}
                </div>
            </div>
            <div class="card-body">
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
        <div class="card">
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                    Single Point of Contact Details (SPoC)
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Person Name :</strong></label>

                                <label>{{ $spocData->person_name }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Contact Number :</strong></label>
                                {{ $spocData->contact_number ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Designation :</strong></label>
                                {{ $spocData->designation ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Email Id :</strong></label>
                                <label>{{ $spocData->email ?? '' }}</label>
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
                    View Course Information Record No: {{ $k+1 }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Course Name</strong></label><br>
                                <label>{{ $ApplicationCourses->course_name }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Course Duration</strong></label><br>
                                {{ $ApplicationCourses->course_duration_y ?? '' }} Years(s)
                                {{ $ApplicationCourses->course_duration_m ?? '' }} Month(s)
                                {{ $ApplicationCourses->course_duration_d ?? '' }} Day(s)
                                {{ $ApplicationCourses->course_duration_h ?? '' }} Hour(s)
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Eligibility</strong></label><br>
                                <label>{{ $ApplicationCourses->eligibility ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Mode of Course</strong></label>
                                <label> {{$ApplicationCourses->mode_of_course}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Course Brief</strong></label><br>
                                <label>{{ $ApplicationCourses->course_brief ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label for="Declaration">Declaration</label></br>
                                    <span class="badge badge-success">
                                        <a href="{{url('doc').'/'.$ApplicationCourses->declaration_pdf}}"
                                            target="_blank" title="Download Document">
                                            <i class="fa fa-eye mr-2">&nbsp;Document</i>
                                        </a></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label for="Declaration">Course Curriculum / Material / Syllabus</label></br>
                                    <span class="badge badge-success">
                                        <a href="{{url('doc').'/'.$ApplicationCourses->course_curriculum_pdf}}"
                                            target="_blank" title="Download Document">
                                            <i class="fa fa-eye">&nbsp; Document</i>
                                        </a></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label for="Declaration">Course Details (Excel format)
                                    </label>
                                    <span class="badge badge-success">
                                        <a href="{{url('doc').'/'.$ApplicationCourses->course_details_xsl}}"
                                            target="_blank" download title="Download Document">
                                            <i class="fa fa-download mr-2"></i>&nbsp; Download
                                            Document
                                        </a></span>
                                    </span>
                                </div>
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
                            <th>Action</th>

                        </tr>
                        @foreach ($application_details->payment as $key=>$ApplicationPayment)
                        <tr>
                            <td>{{ $key+1 }}</td>
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
                                @if ($ApplicationPayment->status == 1 || $ApplicationPayment->status ==2)
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
                            <td>
                                @if($ApplicationPayment->account_update_count < (int)env('ACCOUNT_PAYMENT_UPDATE_COUNT'))
                                <button class="btn btn-primary btn-xm" data-bs-toggle="modal" data-bs-target="#update_payment_modal" onclick="handleShowPaymentInformation('{{ $ApplicationPayment->payment_transaction_no}}','{{ $ApplicationPayment->payment_reference_no}}',{{$ApplicationPayment->id}})"
                                title="You can update only once"
                                ><i class="fa fa-pencil"></i></button>

                                @else
                                <span class="text-danger payment_update_fn badge badge-danger">Payment Update Limit Expired</span>
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

            @if (isset($ApplicationPayment))
                @if( $application_payment_status->status==0)
                <div class="card p-relative" id="payment_rcv_card">
                <div class="box-overlay-2">
                     <span class="spinner-border"></span>
                </div>
                    <div class="card-header bg-white text-dark">
                        <h5 class="mt-2">
                            Payment Process
                        </h5>
                    </div>
                    <div class="card-body">
                    
                        <div>
                            
                        <form action="#" name="payment_approve_form" id="payment_approve_form" enctype="multipart/form-data">
                            <div class="row">
                                
                                <input type="hidden" name="payment_id" id="payment_id" value="{{$ApplicationPayment->id}}">
                                <div class="col-md-4">
                                    <label for="">Payment Proof Upload <span class="text text-danger">(jpg,jpeg,png,pdf)*</span></label>
                                    <input type="file" required class="form-control" name="payment_proof" id="payment_proof" accept="application/pdf,image/png, image/gif, image/jpeg">
                                </div>
                                <!-- <div class="col-md-5">
                                    <label for="">Remark (Optional)</label>
                                    <textarea class="form-control" name="payment_remark" id="payment_remark" cols="30" rows="10" placeholder="Please Enter the remark"></textarea>
                                </div> -->
                                <div class="col-md-3 mt-4"> 
                                    <button class="btn btn-primary" type="button" onclick="handlePaymentReceived()" id="submit_btn">Payment Received
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>  
                    </div>
                </div>
                @endif


                @if( $application_payment_status->status==1)
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
                                    <button class="btn btn-primary" type="button" onclick="handlePaymentApproved()" id="submit_btn_2">Payment Approved
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
                        <input type="text" class="form-control remove_err" id="payment_transaction_no" placeholder="Please enter payment transaction number." maxlength='18'>
                        <span class="err" id="payment_transaction_no_err"></span>
                </div>
                <div class="mb-3">
                        <label for="payment_reference_no" class="form-label">Payment Reference no<span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control remove_err" id="payment_reference_no" placeholder="Please enter payment reference number." maxlength='18'>
                        <span class="err" id="payment_reference_no_err"></span>
                </div>
                <div class="mb-3">
                        <label for="payment_proof_by_account" class="form-label">Slip by Approver</label>
                        <input type="file" class="form-control" id="payment_proof_by_account">
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="handleUpdatePaymentInformationOfAccount()" class="btn btn-primary">Update</button>
                </div>
                </div>
            </div>
            </div>
        <!-- end here edit payment modal -->
    </section>
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