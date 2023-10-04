@include('layout.header')


<title>RAV Accreditation Previous Applications View</title>
{{--
<link rel="stylesheet" type="text/css" href="https://rawgithub.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
 --}}
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
        @elseif(Auth::user()->role == '5')
            @include('layout.secretariat')
        @elseif(Auth::user()->role == '6')
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
                                <h4 class="page-title">Application</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> level</a>
                            </li>
                            <li class="breadcrumb-item active"> View Previous Applications </li>
                        </ul>

                        <a href="{{ url('nationl-page') }}" type="button" class="btn btn-primary" style="float:right;">Back
                        </a>

                    </div>
                </div>
            </div>

            @if (Session::has('sussess'))
                <div class="alert alert-success" role="alert">
                    {{ session::get('sussess') }}
                </div>
            @elseif(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('error') }}
                </div>
            @endif





            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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
                                </div>
                                <div class="header">
                                    <h2>Single Point of Contact Details (SPoC) Details</h2>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Person Name</strong></label><br>
                                                <label>{{ $spocData->Person_Name }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Contact Number</strong></label><br>
                                                {{ $spocData->Contact_Number ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Designation</strong></label><br>
                                                {{ $spocData->designation ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">

                                                <label><strong>Email Id</strong></label><br>

                                                <label>{{ $spocData->Email_ID ?? '' }}</label>

                                            </div>
                                        </div>
                                    </div>





                                    {{--

                                    @if ($ApplicationDocument[0]->document_show == 0)
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <a href="{{ url('document-view/' . dEncrypt($ApplicationDocument[0]->id)) }}"
                                                    onclick="return confirm_option('change status')"
                                                    @if ($ApplicationDocument[0]->document_show == 0) <div class="badge col-green">hide</div> @elseif ($ApplicationDocument[0]->document_show == 1) <div class=" col-green"><strong class="btn btn-success">show</strong></div> @else @endif
                                                    </a>
                                            </div>
                                        </div>
                                    @elseif($ApplicationDocument[0]->document_show == 1)
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <a href="{{ url('document-view-accessor/' . dEncrypt($ApplicationDocument[0]->id)) }}"
                                                    onclick="return confirm_option('change status')"
                                                    @if ($ApplicationDocument[0]->document_show == 1) <div class="badge col-green">hide</div> @elseif ($ApplicationDocument[0]->document_show == 2) <div class=" col-green"><strong class="btn btn-success">show</strong></div> @else @endif
                                                    </a>
                                            </div>
                                        </div>
                                    @else
                                    @endif --}}
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

                                    <!-- <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Valid From</strong></label><br>
                                                <label>{{ date('d F Y', strtotime($ApplicationCourses->created_at)) }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label><strong> Valid To</strong></label><br>
                                                    <label>{{ date('d F Y', strtotime($ApplicationCourses->created_at->addYear())) }}</label>            </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Course Brief</strong></label><br>
                                                <label>{{ $ApplicationCourses->course_brief ?? '' }}</label>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- <div class="row clearfix">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Course Brief</strong></label><br>
                                                <label>{{ $ApplicationCourses->course_brief ?? '' }}</label>
                                            </div>
                                        </div>
                                    </div> -->






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
                                                <label>{{ $ApplicationPayment->payment_date }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Payment Transaction no</strong></label><br>
                                                {{ $ApplicationPayment->payment_details ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">

                                                <label><strong>Payment Reference no</strong></label><br>

                                                <label>{{ $ApplicationPayment->payment_details ?? '' }}</label>

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



                                    {{-- @if (Auth::user()->role != '6') --}}
                                    @if ($ApplicationPayment->status == '2')


                                        <div class="col-sm-4 payment_file">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label><strong>Upload Payment Slip</strong></label><br>

                                                <br>

                                                    {{-- {{ $ApplicationPayment->payment_slip }} --}}

                                                    <?php
                                                    substr($ApplicationPayment->payment_slip, -3);

                                                    $data = substr($ApplicationPayment->payment_slip, -3);
                                                    ?>


                                                    @if ($data == 'pdf')
                                                        <a href="{{ asset('documnet/' . $ApplicationPayment->payment_slip) }}"
                                                            target="_blank" title="Document 3" id="docpdf3"
                                                            download>
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
                                                            value="{{ $ApplicationPayment->payment_remark }}"
                                                            required>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- @endif --}}


                                    @if (Auth::user()->role == '6')
                                        @if ($ApplicationPayment->status == '1')

                                                <div class="col-sm-4 payment_file">
                                                    <form
                                                    action="{{ url('image-app-status/' . dEncrypt($ApplicationPayment->id)) }}"
                                                    method="post" id="frmtypes" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label><strong>Upload Payment Slip </strong></label><br>

                                                            <div class="col-md-12">
                                                                <input type="file" name="payment_slip"
                                                                    class="form-control " required
                                                                    value="{{ $ApplicationPayment->payment_slip }}">
                                                            </div>

                                                            {{-- {{ $ApplicationPayment->payment_slip }} --}}

                                                            <?php
                                                            substr($ApplicationPayment->payment_slip, -3);

                                                            $data = substr($ApplicationPayment->payment_slip, -3);
                                                            ?>


                                                            @if ($data == 'pdf')
                                                                <a href="{{ asset('documnet/' . $ApplicationPayment->payment_slip) }}"
                                                                    target="_blank" title="Document 3" id="docpdf3"
                                                                    download>
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
                                                            <label><strong>Payment Remark <span
                                                                        class="text-danger">*</span></strong></label><br>

                                                            <div class="col-md-12">
                                                                <input type="text" name="paymentremark" required
                                                                    value="{{ $ApplicationPayment->payment_remark }}"
                                                                    onchange="javascript:$('#frmtypes').submit();">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        @endif
                                    @endif

                                    @if (Auth::user()->role == '6')
                                        <div class="col-sm-4">
                                            <div class="form-group ">
                                                <div class="form-line">
                                                    <label><strong>Verify Payment </strong></label><br>
                                                    <label><br>
                                                        @if ($ApplicationPayment->status == '0')
                                                            <a href="{{ url('preveious-app-status/' . dEncrypt($ApplicationPayment->id)) }}" class="payment-pending"
                                                                onclick="return confirm_option('change status')">
                                                                @if ($ApplicationPayment->status == 0) <div class=" col-black"><strong class="btn btn-primary btn-sm"> Payment Pending</strong></div> @elseif($ApplicationPayment->status == 1) <div class="badge col-green">Application Proccess</div> @else @endif
                                                                </a>
                                                        @endif



                                                        @if ($ApplicationPayment->payment_remark != '')
                                                            @if ($ApplicationPayment->status == '1')
                                                                <a href="{{ url('preveious-app-status/' . dEncrypt($ApplicationPayment->id)) }}"
                                                                    onclick="return confirm_option('change status')">
                                                                    @if ($ApplicationPayment->status == 0) <div class="col-black"><strong class="btn btn-warning">Pending</strong></div>

                                                                    @elseif($ApplicationPayment->status == 1)
                                                                    <div class=" col-green" ><strong class="btn btn-warning">Final Approval</strong></div> @else @endif
                                                                    </a>
                                                            @endif
                                                        @else
                                                            @if ($ApplicationPayment->status == '1')
                                                                <a href="javascript:void(0)"
                                                                    class="payment_details_file">
                                                                    <div class=" col-green"><strong
                                                                            class="btn btn-warning">Final
                                                                            Approval</strong></div>
                                                                @else
                                                            @endif
                                                            </a>
                                                        @endif


                                                        @if ($ApplicationPayment->status == '2')
                                                            {{-- <a href="{{ url('preveious-app-status/' . dEncrypt($ApplicationPayment->id)) }}" --}}
                                                            {{-- onclick="return confirm_option('change status')" --}}
                                                            @if ($ApplicationPayment->status == 1)
                                                                <div class="badge col-green">Application Proccess</div>
                                                            @elseif($ApplicationPayment->status == 2)
                                                                <div class=" col-green" style="font-size:17px"><strong
                                                                        class="">Application Payment
                                                                        Approved</strong>
                                                                </div>
                                                            @else
                                                            @endif
                                                            {{-- </a> --}}
                                                        @endif

                                                </div>
                                            </div>
                                        </div>
                                    @endif




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



        {{-- <div class="col-lg-12 p-t-20 text-center">
            <a href="" class="btn btn-primary waves-effect m-r-15">Approved</a>
            <a href="{{ url()->previous() }} " class="btn btn-danger waves-effect">back</a>
        </div> --}}

        </div>
    </section>







    <script>
        function confirm_option() {
            if (!confirm("Are you sure to approved the payment of this application!")) {
                return false;
            }

            return true;

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
