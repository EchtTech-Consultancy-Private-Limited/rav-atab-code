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
        toastr.success("{{ $message }}", {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: true,
                    closeDuration: 5000,
                });
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
                    <div class="">
                    @if($spocData->signed_copy_onsite!=null)
                    <a href="{{ url('onsite/doc/'.$spocData->signed_copy_onsite).'/'.$spocData->id}}" class="float-left btn btn-primary btn-sm" target="_blank">View Signed Copy 
                    </a>
                    @endif
                    @if($is_submitted_final_summary)
                        <a href="{{ url('onsite-application-course-summaries').'?application='.$spocData->id}}" class="float-left btn btn-primary btn-sm">View Final Summary 
                        </a>
                    @endif
                        <a href="{{ url('onsite/application-list') }}" class="float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back
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
                    <span style="font-weight: bold;">Application ID:</span> {{ $spocData->uhid }}
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

        <div class="card p-3 accordian-card">
            <div class="accordion" id="accordionExample">
                    @foreach ($application_details->course as $k => $ApplicationCourses)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $k + 1 }}">
                                <button class="accordion-button {{$k==0?'':'collapsed'}}"
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
                                    </label></br>
                                    <span class="badge badge-success">
                                        <a href="{{url('doc').'/'.$ApplicationCourses->course_details_xsl}}"
                                            target="_blank" download title="Download Document">
                                            <i class="fa fa-download mr-2"></i> &nbsp;Download
                                            Document
                                        </a></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end">
                                @if($ApplicationCourses->is_doc_uploaded>=4)
                                <a href="{{ url('/onsite/document-list' . '/' . dEncrypt($ApplicationCourses->application_id) . '/' .dEncrypt($ApplicationCourses->id) ) }}"
                                    class="btn text-white bg-primary mb-0"
                                    style="float:right; color: #fff ; line-height: 25px;">View Documents</a>
                                @endif
                           
                        </div>
                    </div>
                </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div> 
        </div>
        
        @if(($show_submit_btn_to_onsite) || $is_all_revert_action_done) 
        <div class="row">
                <div class="col-md-12 mr-2">
                <form action="{{url('onsite/update-nc-flag-doc-list/'.dEncrypt($spocData->id))}}" method="post">
                @csrf
                <input 
                        type="submit" 
                        class="btn btn-info float-right" 
                        value="Submit" 

                        <?php echo ($enable_disable_submit_btn==true || !$is_all_action_taken_on_docs || $spocData->signed_copy_onsite==null || $is_in_improvement==null) ? 'disabled' : ''; ?>
                    >
                </form>
                </div>
        </div>
        @elseif($is_all_course_summary_completed && $is_submitted_final_summary!=1)
        <div class="row mb-5">
                <div class="col-md-12 mr-2">
                <form action="{{url('/onsite/generate/final-summary')}}" method="post">
                @csrf
                <input type="hidden" name="app_id" value="{{dEncrypt($spocData->id)}}">
                <input type="submit" class="btn btn-info float-right" value="Final Submit" {{ $isOFIExists ? '' : 'disabled' }} {{$spocData->signed_copy_onsite==null?'disabled':''}}>
                
                
                </div>
              
                </form>
        @else

    @endif
    <!-- <div class="btn btn-primary me-4 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Create OFI and Summary</div> -->

            @if($is_all_action_taken_on_docs)
                <div class="d-flex align-items-center">
                @if(!$isOFIExists)
                <div class="btn btn-primary me-4 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Create OFI and Summary</div>
                @endif
                  <!-- signed copy -->
                      @if($spocData->signed_copy_onsite==null)
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="signed_copy_label">Signed Copy(<span class="text-danger">*</span>)</label>
                                        <input type="file" name="signed_copy" id="signed_copy" class="form-control" data-app-id="{{$spocData->id}}">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <a href="{{url('onsite/download/pdf/first/visit/'.dEncrypt($spocData->id))}}" class="btn btn-primary">Download Summary</a>
                                    </div>
                                </div>
                            
                      @endif
                   <!-- end here -->
                </div>
            @endif 

        </div>

                






<!-- OFI model form -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">OFI and Brief Summary Form</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{url('create/ofi')}}" method="post" onsubmit="return handleImporveMentForm();">
                        @csrf
                        <table class="table-form">
                            <thead>
                                <tr>
                                    <th>S.No.<span class="text-danger">*</span></th>
                                    <th>Standard Reference<span class="text-danger">*</span></th>
                                    <th>Improvement Form<span class="text-danger">*</span></th>
                                    <th>Improvement Form Assessee Org.<span class="text-danger">*</span></th>
                                    <th><button type="button" class="btn btn-success add-row-btn">+</button></th>
                                </tr>
                            </thead>
                            <tbody id="form-body">
                                <tr>
                                    <td><input type="text" class="form-control" name="serial_number[]" placeholder="Enter Serial number" required></td>
                                    <td><input type="text" class="form-control" name="standard_reference[]" placeholder="Enter Standard Reference" required></td>
                                    <td><input type="text" class="form-control" name="improvement_form[]" placeholder="Enter Improvement form" required></td>
                                    <td><input type="text" class="form-control" name="improve_assessee_org[]" placeholder="Enter improve assessee org" required></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <label for="">Brief Summary <span class="text-danger">(*)</span></label>
                                    <textarea name="brief_summary" id="brief_summary" class="form-control mb-3 remark_text_area" maxlength="500" required="true">

                                    </textarea>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" id="app_Id" value="{{dEncrypt($spocData->id)}}" name="app_Id">
                        <span id="sr_no_err" class="err"></span>
                        <span id="improvement_form_err" class="err"></span>
                        <span id="standard_reference_err" class="err"></span>
                        <span id="improve_assessee_org_err" class="err"></span>
                        <button type="submit" class="btn btn-primary float-right mt-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- OFI model form end here -->

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
                            <th>Slip by Approver</th>
                            <th>Remarks</th>
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
                        </tr>
                        @endforeach
                    </table>
                    @else
                    <p>Payment has not been completed yet.</p>
                    @endif
                </div>
            </div>

            <!-- @if (isset($ApplicationPayment))
                @if( $application_payment_status->status==0)
                <div class="card p-relative" id="payment_rcv_card">
                <div class="box-overlay">
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
                                <div class="col-md-5">
                                    <label for="">Remark (Optional)</label>
                                    <textarea class="form-control" name="payment_remark" id="payment_remark" cols="30" rows="10" placeholder="Please Enter the remark"></textarea>
                                </div>
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
        @endif -->


        </div>

        </div>
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