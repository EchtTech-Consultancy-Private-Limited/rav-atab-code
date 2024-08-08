@include('layout.header')

<style>
    @media (min-width: 900px) {
        .modal-dialog {
            max-width: 674px;
        }
    }
</style>

<style>
    /* Add styles for the active class */
    .nav-active {
        background-color: #e91e63 !important;
        /* Change this to your desired active background color */
        color: #ffffff !important;
        /* Change this to your desired active text color */
    }

    /* Add hover effect for all nav links except the active link */
    .custom-nav-item:not(.nav-active) .custom-nav-link:hover {
        background-color: #e91e63;
        /* Change this to your desired hover background color */
        color: #ffffff !important;
        /* Change this to your desired hover text color */
        border-radius: 20px;
    }

    /* Add border-radius to all nav links */
    .custom-nav-link {
        border-radius: 20px !important;
        /* Apply border-radius to all nav links */
        margin-left: 3px;
        margin-right: 3px;
    }

    /* Remove hover effect on active link */
    .nav-active .custom-nav-link:hover {
        background-color: inherit;
        color: inherit !important;
        border-radius: 20px;
    }

    /* Additional style for hover on active link */
    .nav-active .custom-nav-link:hover {
        background-color: #e91e63 !important;
        /* Change this to your desired hover background color for active link */
        color: #ffffff !important;
        /* Change this to your desired hover text color for active link */
    }
</style>

<title>RAV Accreditation</title>

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
        @endif



        @include('layout.rightbar')


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
                                <div class="p-3">
                                    <ul class="nav ">


                                        <li class="custom-nav-item">
                                            <a class="custom-nav-link nav-active" href="#new_application"
                                                data-bs-toggle="tab">New
                                                Application </a>
                                        </li>
                                        <li class="custom-nav-item">
                                            <a class="custom-nav-link" href="{{ url('level-first/tp/application-list') }}">Previous
                                                Applications</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>



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
                                                    <form class="form" id="spocForm"
                                                        action="{{ url('/store-new-applications') }}" method="post">

                                                        @csrf
                                                        @if ($applicationData && !Request::get('sr_prev_id'))
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
                                                                                value="{{ old('person_name', $applicationData->person_name ?? '') }}"
                                                                                required maxlength="30">
                                                                            @error('Person_Name')
                                                                                <span class="text-danger">
                                                                                    {{ $message }}</span>
                                                                            @enderror
                                                                            <span class="text-danger"
                                                                                id="person_error"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input name="sr_prev_id" type="hidden" name="" value="{{request('sr_prev_id')}}">
                                                                <input name="sr_type" type="hidden" name="" value="{{request('q')}}">
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
                                                                                value="{{ old('contact_number', $applicationData->contact_number ?? '') }}">
                                                                            <!-- <input type="text" required="required"
                                                                                maxlength="10" name="Contact_Number"
                                                                                class="preventalpha"
                                                                                placeholder="Contact Number"
                                                                                id="Contact_Number"
                                                                                value="{{ old('contact_number', $applicationData->contact_number ?? '') }}"> -->
                                                                        </div>
                                                                        @error('Contact_Number')
                                                                            <span class="text-danger">
                                                                                {{ $message }}</span>
                                                                        @enderror
                                                                        <span class="text-danger"
                                                                            id="contact_error"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Email-ID<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input
                                                                               type="text"
                                                                                name="Email_ID"
                                                                                placeholder="Email-ID"
                                                                                required="true"
                                                                                value="{{ old('email', $applicationData->email ?? '') }}">
                                                                       
                                                                        </div>
                                                                        @error('Email_ID')
                                                                            <span id="backendError" class="text-danger">
                                                                                {{ $message }}</span>
                                                                        @enderror
                                                                        <span class="text-danger"
                                                                            id="email_id_error"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>
                                                                                Designation
                                                                                <span class="text-danger">*</span>
                                                                            </label>
                                                                            <input type="text" name="designation"
                                                                                placeholder="Designation"
                                                                                required="true"
                                                                                value="{{ old('designation', $applicationData->designation ?? '') }}">
                                                                        </div>
                                                                        @error('designation')
                                                                            <span class="text-danger">
                                                                                {{ $message }}</span>
                                                                        @enderror
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
                                                <li>
                                                    <button id="nextBtn" type="submit"
                                                        class="btn btn-primary next-step">
                                                        Next
                                                    </button>
                                                </li>
                                            </ul>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <script>
                                    var routePhoneValidation = "{{ route('phone.validation') }}";
                                    var routeEmailValidation = "{{ route('email.validation') }}";
                                    var csrfToken = "{{ csrf_token() }}";
                                </script>
                                <script src="{{ asset('assets/js/new-application-form-validation.js') }}"></script>
                                @include('layout.footer')
