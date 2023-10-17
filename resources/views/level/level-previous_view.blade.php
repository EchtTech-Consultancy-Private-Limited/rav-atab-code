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

            <div class="row ">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
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



                                <div class="header">
                                    <h2>Single Point of Contact Details (SPoC) Details</h2>
                                </div>
                                <div class="row clearfix">
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

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">

                                                @if ($data->status == 1)
                                                    <a href="{{ url('/upload-document' . '/' . dEncrypt($data->id)) }}"
                                                        class="btn btn-tbl-edit bg-primary"><i
                                                            class="fa fa-upload"></i></a>
                                                @endif
                                                @if ($data->status == 2)
                                                    <a href="{{ url('/application-upgrade-second') }}"
                                                        class="btn btn-tbl-edit"><i class="material-icons">edit</i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- basic end -->
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
            <div class="row ">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Add Course Information Record No: {{ $k + 1 }}</h2>
                            </div>
                            <div class="body">

                                <div class="row clearfix">
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
                                    
                                                            @if (in_array($extension, ['xls', 'csv', 'pdf','xlsx']))
                                                                @if (in_array($extension, ['xls', 'csv','xlsx']))
                                                                    <label>
                                                                        <a href="{{ url('show-course-pdf/' . $document->document_file) }}" target="_blank"
                                                                           title="Download Document">
                                                                            <i class="fa fa-download mr-2"></i>&nbsp; Download Document 
                                                                        </a>
                                                                    </label>
                                                                @elseif ($extension === 'pdf')
                                                                    <label>
                                                                        <a href="{{ url('show-course-pdf/' . $document->document_file) }}" target="_blank"
                                                                           title="View Document}">
                                                                           <div class="d-flex align-items-center ">
                                                                                <div>
                                                                                    <i class="fa fa-eye mr-2"></i> 
                                                                                </div>
                                                                                <div>
                                                                                   &nbsp;  Document 
                                                                                </div>
                                                                           </div>
                                                                        </a>
                                                                    </label>
                                                                @endif
                                                            @else
                                                                <label><i class="fa fa-info-circle mr-2"></i> Unsupported File Format</label>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12 text-right">
                                    <div class="form-group">

                                        @if ($spocData->status == 1)
                                            <div class="col-sm-12 text-right">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <a href="{{ url('/upload-document' . '/' . $ApplicationCourses->application_id . '/' . $ApplicationCourses->id) }}"
                                                            class="btn text-white bg-primary"
                                                            style="float:right; color: #fff ; line-height: 25px;">Upload
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
                                                            style="float:right; color: #fff ; line-height: 25px;">Upload
                                                            Documents</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <!-- basic end -->
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
            </div>
        @endforeach

        {{-- payment details  --}}



        @foreach ($ApplicationPayment as $ApplicationPayment)


            <div class="row ">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Payment Information</h2>
                            </div>
                            <div class="body">

                                <div class="row clearfix">
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
                                </div>


                                <div class="row clearfix">
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

                                                {{-- {{ $ApplicationPayment->payment_details_file }} --}}

                                                <label><strong>Payment Proof</strong></label><br>

                                                @if (isset($ApplicationPayment->payment_details_file))
                                                    {{-- <a target="_blank" class="image-link" href="{{ asset('uploads/'.$ApplicationPayment->payment_details_file) }}" >

                                            <img src="{{ asset('uploads/'.$ApplicationPayment->payment_details_file) }}" alt="Payment File" width="100px;" height="100px;"></a> --}}


                                                    <?php
                                                    substr($ApplicationPayment->payment_details_file, -3);
                                                    $data = substr($ApplicationPayment->payment_details_file, -3);
                                                    ?>


                                                    @if ($data == 'pdf')
                                                        <a href="{{ asset('uploads/' . $ApplicationPayment->payment_details_file) }}"
                                                            target="_blank" title="Document 3" id="docpdf3"
                                                            download>
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
                                    <!-- basic end -->
                                </div>
                            </div>
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
