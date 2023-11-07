@include('layout.header')


<title>RAV Accreditation Previous Applications View</title>
<link rel="stylesheet" type="text/css"
    href="https://rawgithub.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
{{--
<link rel="stylesheet" type="text/css" href="https://rawgithub.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
 --}}
</head>

<body class="light">

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
        @elseif(Auth::user()->role == '5')
            @include('layout.secretariat')
        @elseif(Auth::user()->role == '6')
            @include('layout.sidbarAccount')
        @endif

        @include('layout.rightbar')


    </div>


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
                    @if (auth()->user()->role == 1)
                        <a class="btn btn-info"
                            href="{{ url('admin/application/documents/' . $applicationData->id . '/summary') }}">Document
                            Summary</a>
                    @endif
                    <a href="{{ url('nationl-page') }}" type="button" class="btn btn-primary" style="float:right;">Back
                    </a>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                    Basic Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Title</strong></label><br>
                                <label>{{ $data->title ?? '' }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>First Name</strong></label><br>
                                {{ $data->firstname ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Middle Name</strong></label><br>
                                <label>{{ $data->middlename ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Last Name</strong></label><br>
                                <label>{{ $data->lastname ?? '' }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Organization/Institute Name</strong></label><br>
                                <label>{{ $data->organization ?? '' }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Email</strong></label><br>
                                <label>{{ $data->email ?? '' }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Mobile Number</strong></label><br>
                                <label>{{ $data->mobile_no ?? '' }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Designation</strong></label><br>
                                <label>{{ $data->designation ?? '' }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label><strong>Country</strong></label><br>
                                        <label>{{ $data->country_name ?? '' }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>State</strong></label><br>
                                <label>{{ $data->state_name ?? '' }}</label>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>City</strong></label><br>
                                <label>{{ $data->city_name ?? '' }}</label>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Postal Code</strong></label><br>
                                <label>{{ $data->postal ?? '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Address</strong></label><br>
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
                                <label><strong>Person Name</strong></label><br>
                                <label>{{ $spocData->Person_Name }}</label>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Contact Number</strong></label><br>
                                {{ $spocData->Contact_Number ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
                                <label><strong>Designation</strong></label><br>
                                {{ $spocData->designation ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-line">
    
                                <label><strong>Email Id</strong></label><br>
    
                                <label>{{ $spocData->Email_ID ?? '' }}</label>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($ApplicationCourse as $k => $ApplicationCourses)
            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2">
                        View Course Information Record No: {{ $loop->iteration }}
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
                                    {{ $ApplicationCourses->years ?? '' }} Years(s)
                                    {{ $ApplicationCourses->months ?? '' }} Month(s)
                                    {{ $ApplicationCourses->days ?? '' }} Day(s)
                                    {{ $ApplicationCourses->hours ?? '' }} Hour(s)
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
                                    <label> <?php echo get_course_mode($ApplicationCourses->id); ?></label>
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
                            @if (count($ApplicationCourses->documents) > 0)
                                @foreach ($ApplicationCourses->documents as $document)
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>
                                                        @if ($loop->iteration == 1)
                                                            Declaration
                                                        @elseif ($loop->iteration == 2)
                                                            Course Curriculum / Material / Syllabus
                                                        @elseif ($loop->iteration == 3)
                                                            Course Details (Excel format)
                                                        @endif
                                                    </strong></label><br>

                                                @php
                                                    $extension = pathinfo($document->document_file, PATHINFO_EXTENSION);
                                                @endphp

                                                @if (in_array($extension, ['xls', 'csv', 'pdf', 'xlsx']))
                                                    @if (in_array($extension, ['xls', 'csv', 'xlsx']))
                                                        <label>
                                                            <a href="{{ url('show-course-pdf/' . $document->document_file) }}"
                                                                download title="Download Document">
                                                                <i class="fa fa-download mr-2"></i>&nbsp; Download
                                                                Document
                                                            </a>
                                                        </label>
                                                    @elseif ($extension === 'pdf')
                                                        <label>
                                                            <a href="{{ url('show-course-pdf/' . $document->document_file) }}"
                                                                target="_blank" title="View Document}">
                                                                <div class="d-flex align-items-center ">
                                                                    <div>
                                                                        <i class="fa fa-eye mr-2"></i>
                                                                    </div>
                                                                    <div>
                                                                        &nbsp; Document
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </label>
                                                    @endif
                                                @else
                                                    <label><i class="fa fa-info-circle mr-2"></i> Unsupported File
                                                        Format</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            @endif
                        </div>

                        @if (Auth::user()->role != '6')
                            @if ($ApplicationPayment[0]->status == '2')
                                <div class="col-sm-12 text-right">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <a href="{{ url('/admin-view-document' . '/' . $ApplicationCourses->application_id . '/' . $ApplicationCourses->id) }}"
                                                class="btn text-white bg-primary"
                                                style="float:right; color: #fff ; line-height: 25px;">View
                                                Documents</a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-12 text-right">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <a href="javascript:void(0)"
                                                class="btn text-white bg-primary payment_alert"
                                                style="float:right; color: #fff ; line-height: 25px;">View
                                                Documents</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            </div>
        @endforeach

        @foreach ($ApplicationPayment as $ApplicationPayment)
            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2">
                        Payment Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label><strong>Payment Date</strong></label><br>
                                    <label>{{ \Carbon\Carbon::parse($ApplicationPayment->payment_date)->format('d-m-Y') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label><strong>Payment Transaction no</strong></label><br>
                                    {{ $ApplicationPayment->transaction_no ?? '' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">

                                    <label><strong>Payment Reference no</strong></label><br>

                                    <label>{{ $ApplicationPayment->reference_no ?? '' }}</label>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label><strong>Total Courses</strong></label><br>
                                    <label>{{ $ApplicationPayment->course_count ?? '' }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label><strong>Amount</strong></label><br>
                                    <label>{{ $ApplicationPayment->currency ?? '' }}
                                        {{ $ApplicationPayment->amount }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label><strong>Payment Proof</strong></label><br>

                                    <?php
                                    substr($ApplicationPayment->payment_details_file, -3);
                                    
                                    $data = substr($ApplicationPayment->payment_details_file, -3);
                                    ?>


                                    @if ($data == 'pdf')
                                        <a href="{{ asset('uploads/' . $ApplicationPayment->payment_details_file) }}"
                                            target="_blank" title="Document 3" id="docpdf3" download>
                                            <i class="fa fa-download mr-2"></i> Payment pdf
                                        </a>
                                    @else
                                        @if (isset($ApplicationPayment->payment_details_file))
                                            <a target="_blank" class="image-link"
                                                href="{{ asset('uploads/' . $ApplicationPayment->payment_details_file) }}">
                                                <img src="{{ asset('uploads/' . $ApplicationPayment->payment_details_file) }}"
                                                    style="width:100px;height:70px;">
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($ApplicationPayment->status == '2')
                            <div class="col-sm-4 payment_file">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label><strong>Payment Slip</strong></label><br>



                                        <div class="mt-2 text-danger">
                                            @if (!$ApplicationPayment->payment_slip)
                                                File not available!
                                            @endif
                                        </div>

                                        <?php
                                        substr($ApplicationPayment->payment_slip, -3);
                                        
                                        $data = substr($ApplicationPayment->payment_slip, -3);
                                        ?>


                                        @if ($data == 'pdf')
                                            <a href="{{ asset('documnet/' . $ApplicationPayment->payment_slip) }}"
                                                target="_blank" title="Document 3" id="docpdf3" download>
                                                <i class="fa fa-download mr-2"></i>Payment pdf
                                            </a>
                                        @else
                                            @if (isset($ApplicationPayment->payment_slip))
                                                <a target="_blank" class="image-link"
                                                    href="{{ asset('documnet/' . $ApplicationPayment->payment_slip) }}">
                                                    <img src="{{ asset('documnet/' . $ApplicationPayment->payment_slip) }}"
                                                        style="width:100px;height:70px;">
                                                </a>
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label><strong>Payment Remark </strong></label><br>

                                        <div class="col-md-12">
                                            <input type="text" name="paymentremark" disabled
                                                value="{{ $ApplicationPayment->payment_remark }}" required>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (Auth::user()->role == '6')
                            @if ($ApplicationPayment->status == '1')
                                <div class="col-sm-12 payment_file">
                                    <form action="{{ url('image-app-status/' . dEncrypt($ApplicationPayment->id)) }}"
                                        method="post" enctype="multipart/form-data" id="paymentApproveForm">
                                        @csrf
                                        <div class="card" style="border:1px solid #ccc;">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between p-2">
                                                    <b>Payment Approval</b>
                                                    <div>
                                                        @if ($ApplicationPayment->status == 1)
                                                            <span class="bg-warning p-2 text-dark"
                                                                style="border-radius: 5px;">Application In
                                                                Process</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row pt-3">
                                                    <div class="col-sm-6">
                                                        <div class="form-group" style="margin-top: 10px;">
                                                            <label for="payment_slip"><strong>Upload
                                                                    Payment Slip</strong></label>
                                                            <input type="file" name="payment_slip"
                                                                class="form-control" id="payment_slip"
                                                                value="{{ $ApplicationPayment->payment_slip }}">
                                                            <?php
                                                            $fileExtension = substr($ApplicationPayment->payment_slip, -3);
                                                            ?>
                                                            @if ($fileExtension == 'pdf')
                                                                <a href="{{ asset('document/' . $ApplicationPayment->payment_slip) }}"
                                                                    target="_blank" title="Payment PDF"
                                                                    id="docpdf3" download>
                                                                    <i class="fa fa-download mr-2"></i>Payment
                                                                    pdf
                                                                </a>
                                                            @else
                                                                @if (isset($ApplicationPayment->payment_slip))
                                                                    <a target="_blank" class="image-link"
                                                                        href="{{ asset('document/' . $ApplicationPayment->payment_slip) }}">
                                                                        <img src="{{ asset('document/' . $ApplicationPayment->payment_slip) }}"
                                                                            style="width:100px;height:70px;"
                                                                            alt="Payment Slip">
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label><strong>Payment Remark <span
                                                                            class="text-danger">*</span></strong></label><br>
                                                                <input type="text" name="paymentremark" required
                                                                    value="{{ $ApplicationPayment->payment_remark }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-end">
                                                <input type="hidden" name="status" value="2">
                                                <button class="btn btn-primary" type="submit"
                                                    id="paymentApproveButton">Click to Approve
                                                    Payment</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endif

                        @if (Auth::user()->role == '6')
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <div class="form-line">
                                        @if ($ApplicationPayment->status == 0)
                                            <label><strong>Verify Payment </strong></label><br>
                                            <label><br>
                                                <a href="{{ url('preveious-app-status/' . dEncrypt($ApplicationPayment->id)) }}"
                                                    class="btn btn-primary btn-sm payment-pending btn-payment-approval"
                                                    onclick="return confirm_option('Approve Payment & Add Remark')">Approve
                                                    Payment & Add Remark</a>
                                        @endif




                                        @if ($ApplicationPayment->status == '2')
                                            @if ($ApplicationPayment->status == 1)
                                                <div class="badge col-green">Application Proccess</div>
                                            @elseif($ApplicationPayment->status == 2)
                                                <label><strong>Payment Status </strong></label>
                                                <br>
                                                <div class="pt-2">
                                                    <span class="bg-success text-white p-2"
                                                        style="cursor: default;">Payment
                                                        Approved</span>
                                                </div>
                                            @else
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
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
