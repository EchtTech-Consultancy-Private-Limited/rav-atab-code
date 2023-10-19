@include('layout.header')


<title>RAV Accreditation || Assessor Applications View</title>

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


        @include('layout.sideAss')

        @include('layout.rightbar')


    </div>


    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Assessor View Application</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Applications</a>
                            </li>
                            <li class="breadcrumb-item active"> Assessor View Applications </li>
                        </ul>

                        <a href="{{ url('nationl-accesser') }}" type="button" class="btn btn-primary"
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
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Title</strong></label><br>
                                                <label>{{ $data->title }}</label>
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
                                </div>


                                <div class="row clearfix">
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
                                </div>



                                <div class="row clearfix">
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
                                </div>




                                <div class="row clearfix">

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
                                </div>



                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Address</strong></label><br>
                                                <label>{{ $data->address ?? '' }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div><div class="header">
                                    <h2>Single Point of Contact Details (SPoC) Details</h2>
                                </div>
                                 <div class="row clearfix">
                                    <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label ><strong>Person Name</strong></label><br>
                                               <label >{{ $spocData->Person_Name  }}</label>
                                        </div>
                                     </div>
                                    </div>

                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label><strong>Contact Number</strong></label><br>
                                            {{ $spocData->Contact_Number ??'' }}
                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">

                                            <label><strong>Email Id</strong></label><br>

                                              <label>{{ $spocData->Email_ID ??'' }}</label>

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
                                <h2>View Course Information Record No: {{ $k + 1 }}</h2>
                            </div>
                            <div class="body">

                                <div class="row clearfix">
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
                                                {{ $ApplicationCourses->years ??'' }} Year(s) {{ $ApplicationCourses->months ??'' }} Month(s) {{ $ApplicationCourses->days ??'' }} Day(s)
                                            {{ $ApplicationCourses->hours ??'' }} Hour(s)
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
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Mode of Course</strong></label><br>
                                                <label> <?php echo get_course_mode($ApplicationCourses->id); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong> Valid To</strong></label><br>

                                                <label>{{ date('d F Y', strtotime($ApplicationCourses->created_at)) }}</label>
                                                 </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label><strong>Valid From</strong></label><br>
                                                    <label>{{ date('d F Y', strtotime($ApplicationCourses->created_at->addYear())) }}</label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row clearfix">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Course Brief</strong></label><br>
                                                <label>{{ $ApplicationCourses->course_brief ?? '' }}</label>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Declaration</strong></label><br>
                                                <label><a href="{{ url('show-course-pdf/'.$ApplicationDocument[0]->document_file) }}" target="_blank" id="docpdf1" title="Download Document 1" ><i class="fa fa-download mr-2"></i> PDF 1
                                                </a></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Course Curriculum / Material / Syllabus </strong></label><br>
                                                <label> <a href="{{ url('show-course-pdf/'.$ApplicationDocument[1]->document_file) }}" target="_blank" id="docpdf2" title="Download Document 2" ><i class="fa fa-download mr-2"></i> PDF 2
                                                </a></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Course Details (Excel format) </strong></label><br>
                                                <label>
                                                    <a  href="{{ url('documnet/'.$ApplicationDocument[2]->document_file) }}" target="_blank" title="Document 3" id="docpdf3" download>
                                                        <i class="fa fa-download mr-2"></i> Download Doc
                                                    </a>
                                            </label>
                                            </div>
                                        </div>
                                    </div>







                                    <div class="col-sm-12 text-right">
                                       <div class="form-group">
                                          <div class="form-line">
                                             <a href="{{ url('/accr-view-document' . '/' .$ApplicationCourses->application_id.'/'.$ApplicationCourses->id) }}"
                                      class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">View Documents</a>
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
        @endforeach

        {{-- payment details  --}}


        @isset($ApplicationPayment)
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
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Total Course</strong></label><br>
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
                                                        <i class="fa fa-download mr-2"></i>          Payment pdf
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
        @endisset


{{--
        <div class="col-lg-12 p-t-20 text-center">
            <a href="" class="btn btn-primary waves-effect m-r-15">Approved</a>
            <a href="{{ url()->previous() }} " class="btn btn-danger waves-effect">back</a>
        </div>

 --}}

        </div>
    </section>

    @include('layout.footer')
