@include('layout.header')


<title>RAV Accreditation || Previous Applications View</title>

</head>

<body class="light">

    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    @include('layout.topbar')

    <div>



        @if (Auth::user()->role == 1)
            @include('layout.sidebar')
        @elseif(Auth::user()->role == 2)
            @include('layout.siderTp')
        @elseif(Auth::user()->role == 3)
            @include('layout.sideAss')
        @elseif(Auth::user()->role == 4)
            @include('layout.sideprof')
        @elseif(Auth::user()->role == 5)
            @include('layout.secretariat')
        @elseif(Auth::user()->role == 6)
            @include('layout.sidbarAccount')
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
                                <h4 class="page-title">Previous Application Details</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> level</a>
                            </li>
                            <li class="breadcrumb-item active">Previous Application Details </li>
                        </ul>

                        <a href="{{ url('application-list') }}" type="button" class="btn btn-primary"
                            style="float:right;">Back </a>
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
                                    {{ $data->firstname ?? '' }} {{ $data->middlename ?? '' }}
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
                                            <input type="hidden" id="Country" value="{{ $data->country ?? '' }}">
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
                        <div class="col-sm-12">
                            <div>
                                <h5>Single Point of Contact Details (SPoC)</h5>
                            </div>
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

                                            <label><strong>Email</strong></label><br>

                                            <label>{{ $spocData->Email_ID ?? '' }}</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- course detail  --}}

            @foreach ($ApplicationCourse as $k => $ApplicationCourses)
                <div class="card">
                    <div class="card-header bg-white text-dark">
                        <h5 class="mt-2">
                            Course Information Record No. {{ $loop->index + 1 }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label><strong>Course Name</strong></label><br>
                                        <label>{{ $ApplicationCourses->course_name }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label><strong>Course Duration</strong></label><br>
                                        {{ $ApplicationCourses->years ?? '' }} Year(s)
                                        {{ $ApplicationCourses->months ?? '' }} Month(s)
                                        {{ $ApplicationCourses->days ?? '' }} Day(s)
                                        {{ $ApplicationCourses->hours ?? '' }} Hour(s)
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">

                                        <label><strong>Eligibility</strong></label><br>

                                        <label>{{ $ApplicationCourses->eligibility ?? '' }}</label>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label><strong>Mode of Course</strong></label><br>
                                        <label><?php echo get_course_mode($ApplicationCourses->id); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">

                                        <label><strong>Course Brief</strong></label><br>
                                        <label>{{ $ApplicationCourses->course_brief ?? '' }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    @if ($ApplicationCourses->documents)
                                        @foreach ($ApplicationCourses->documents as $document)
                                            @php
                                                $extension = pathinfo($document->document_file, PATHINFO_EXTENSION);
                                            @endphp
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label><strong>
                                                            @if ($loop->iteration == 1)
                                                                Declaration
                                                            @elseif ($loop->iteration == 2)
                                                                Course Curriculum / Material / Syllabus
                                                            @elseif ($loop->iteration == 3)
                                                                Course Details (Excel format)
                                                            @endif
                                                        </strong></label><br />
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
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-dark">
                        <div>
                            @if ($spocData->status == 1)
                                <a href="{{ url('/upload-document' . '/' . $ApplicationCourses->application_id . '/' . $ApplicationCourses->id) }}"
                                    class="btn text-white bg-primary mb-0"
                                    style="float:right; color: #fff ; line-height: 25px;">Upload
                                    Documents</a>
                            @else
                                <a href="javascript:void(0)" class="btn text-white bg-warning payment_alert mb-0"
                                    style="float:right; color: #fff ; line-height: 25px;">Upload
                                    Documents</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @foreach ($applicationData->payments as $ApplicationPayment)
                <div class="card">
                    <div class="card-header bg-white text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mt-2">
                                    Payment Information {{ $loop->iteration }}
                                </h5>
                            </div>
                            <div>
                                @if ($ApplicationPayment->status == 2)
                                    <span class="text-white bg-success p-2">Payment Approved</span>
                                @elseif ($ApplicationPayment->status == 1)
                                    <span class="text-white bg-warning p-2">Payment Processing</span>
                                @else
                                    <span class="text-white bg-danger p-2">Payment approval is pending!</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label><strong>Payment Date</strong></label><br>
                                        <label>
                                            {{ \Carbon\Carbon::parse($ApplicationPayment->payment_date)->format('d-m-Y') }}

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
                                        <label><strong>Course Count</strong></label><br>
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

                                        @if (isset($ApplicationPayment->payment_details_file))
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
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
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
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Document is pending for approval from Accounts department',
                showConfirmButton: true,
                timer: 5000
            });

        });
    </script>



    @include('layout.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
