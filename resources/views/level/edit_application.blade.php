@include('layout.header')
<!-- New CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/form.min.css') }}" class="js">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .custom-button {
        display: inline-block;
        padding: 5px 10px;
        margin-right: 10px;
        background-color: #eee;
        border: 1px solid #ccc;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .custom-button input[type="checkbox"] {
        display: none;
    }

    /* .custom-button input[type="checkbox"]:checked + .checkbox-label {
    background-color: #81a1c4;
    color: #fff;
    border: 1px solid #007bff;
} */

    .checkbox-label {
        display: inline-block;
        vertical-align: middle;
        cursor: pointer;
    }
</style>

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

    .select-box-hide-class select {
        display: none;
    }

    .form-control[type=file] {
        overflow: hidden;
        height: 3rem;
    }


    .choices__inner {
        border: none;
        background: inherit;
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
</style>
<title>RAV Accreditation</title>
</head>

<body class="light">

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

    @if (Session::flash('success'))
        <script>
            var message = "{{ session::get('success') }}";
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Success',
                text: message,
                showConfirmButton: false,
                timer: 3000
            })
        </script>
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
                    <div class="card nav-tab">
                        @include('level.inner-nav')
                    </div>
                    <div>
                        <ul id="progressbar">
                            <li class="progress1 bg_green">Basic Information</li>
                            <li
                                class="progress2 bg_green @if (isset($form_step_type)) @if ($form_step_type == 'add-course' || $form_step_type == 'application-payment') bg_green @else @endif  @endif ">
                                Level Courses
                            </li>
                            <li
                                class="progress3 @if (isset($form_step_type)) @if ($form_step_type == 'application-payment') bg_green @endif  @endif">
                                Payment
                            </li>
                        </ul>
                    </div>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card shadow-md">
                        <div class="card-header text-dark bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="card-title mt-2">Create Courses </h4>
                                </div>
                                <div>
                                    {{-- <span title="Total forms"  id="formCount" style="margin-bottom: 0px !important; cursor: default; background-color:#f09525; padding:8px 10px; border-radius:10px; color:#fff;"></span> --}}

                                    <button id="add-course-button" class="btn btn-primary btn-sm"
                                        style="margin-bottom: 0px !important;" data-toggle="tooltip"
                                        data-placement="top" title="You can create a maximum of 10 courses at one time"
                                        onclick="addNewCourse();">
                                        <i class="fa fa-plus"></i> Add More Course
                                    </button>
                                </div>
                            </div>
                        </div>
                        <form action="{{ url('/new-application-course') }}" enctype="multipart/form-data" method="post"
                            class="form">
                            @csrf
                            <input type="hidden" name="form_step_type" value="add-course">
                            <div class="body pb-0" id="courses_body">
                                <!-- level start -->
                                <div class="row clearfix" id="new_course_html">
                                    <div class="col-sm-12 text-righ">

                                        <div class="d-flex justify-content-end">
                                            <button type="button" title="Remove course form"
                                                class="btn_remove remove-course" onclick="removeCourse(this);"
                                                style="display: none;">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 create-course-left-field">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Name<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Course Name" name="course_name[]"
                                                    class="preventnumeric" maxlength="50" required>
                                            </div>
                                            @error('course_name')
                                                <div class="alert alert-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="hidden" name="application" class="content_id" readonly>

                                    <input type="hidden" name="application_id" value="{{ $applicationData->id ?? '' }}"
                                        class="form-control" readonly>


                                    <input type="hidden" placeholder="level_id" name="level_id"
                                        value="@if (isset($applicationData)) {{ $applicationData->level_id ?? '' }} @endif">


                                    <input type="hidden" name="coutry" value=" {{ $applicationData->country ?? '' }}">
                                    <input type="hidden" name="state" value=" {{ $applicationData->state ?? '' }}">
                                    <div class="col-sm-6 create-course-right-field">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Duration<span class="text-danger">*</span></label>

                                                <div class="course_group">

                                                    <span style="margin-top:10px; margin-right:5px;">Y</span>
                                                    <input type="text" placeholder="Years" name="years[]"
                                                        maxlength="4" required class="course_i nput preventalpha">

                                                    <span style="margin-top:10px; margin-right:5px;">M</span>
                                                    <input type="text" placeholder="Months" name="months[]"
                                                        maxlength="2" required class="course_input preventalpha">


                                                    <span style="margin-top:10px; margin-right:5px;">D</span> <input
                                                        type="text" maxlength="2" placeholder="Days "
                                                        name="days[]" required class="course_input preventalpha">

                                                    <span style="margin-top:10px; margin-right:5px;">H</span><input
                                                        type="number" placeholder="Hours" name="hours[]" required
                                                        class="course_input">
                                                </div>
                                            </div>
                                            @error('course_duration')
                                                <div class="alert alert-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Eligibility<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Eligibility" name="eligibility[]"
                                                    required id="eligibility">
                                            </div>
                                            @error('eligibility')
                                                <div class="alert alert-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group" style="margin-top: 5px;">
                                            <div class="form-line">
                                                <label>Mode of Course <span class="text-danger">*</span></label>
                                                <div class="form-group default-select">

                                                    <select class="form-control select2" name="mode_of_course[1][]"
                                                        required multiple="" style="width:200px;">
                                                        <option disabled>Select Mode of Course</option>
                                                        @foreach (__('arrayfile.mode_of_course_array') as $key => $value)
                                                            <option value="{{ $value }}">
                                                                {{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @error('mode_of_course')
                                                <div class="alert alert-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Brief <span class="text-danger">*</span></label>

                                                <textarea rows="4" cols="50" class="form-control" name="course_brief[]" required></textarea>
                                            </div>
                                            @error('course_brief')
                                                <div class="alert alert-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Declaration (PDF)<span class="text-danger">*</span></label>
                                                <input type="file" name="doc1[]"
                                                    class="form-control doc_1 file_size" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Curriculum / Material / Syllabus
                                                    (PDF)<span class="text-danger">*</span></label>
                                                <input type="file" name="doc2[]"
                                                    class="form-control doc_2 file_size" required>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Details (Excel format)<span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="doc3[]" id="payment_reference_no"
                                                    required class="form-control doc_3 file_size_exl">
                                            </div>
                                        </div>
                                    </div>
                                    @if (request()->path() == 'level-first')
                                        <input type="hidden" placeholder="level_id" name="level_id"
                                            value="{{ 1 }}">
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
                                </div>
                                @if (request()->path() == 'level-first')
                                    <input type="hidden" placeholder="level_id" name="level_id"
                                        value="{{ 1 }}">
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
                                <!-- level end -->
                            </div>


                            <div class="p-3 new-course-row">

                            </div>
                            <div class="center">
                                <button class="btn btn-primary waves-effect m-r-15 add_course">Save</button>
                            </div>
                            {{-- @endif --}}
                        </form>
                        <div class="body mt-5">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example contact_list">
                                    <thead>
                                        <tr>
                                            <th class="center">S.No.</th>
                                            <th class="center"> Course Name </th>
                                            <th class="center"> Duration </th>
                                            <th class="center"> Eligibility </th>
                                            <th class="center"> Mode </th>
                                            <th class="center"> Brief</th>
                                            <th class="center">Payment Status</th>

                                            <th class="center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($course)
                                            @foreach ($course as $k => $courses)
                                                <tr class="odd gradeX">
                                                    <td class="center">{{ $k + 1 }}</td>
                                                    <td class="center">{{ $courses->course_name }}
                                                    </td>
                                                    <td class="center course-duration-table">
                                                        years:{{ $courses->years }} <br>
                                                        Months: {{ $courses->months }} <br>
                                                        days: {{ $courses->days }} <br>
                                                        Hours: {{ $courses->hours }}
                                                    </td>
                                                    <td class="center">{{ $courses->eligibility }}
                                                    </td>
                                                    <td class="center mode-of-course-table">
                                                        [ <?php echo get_course_mode($courses->id); ?> ]
                                                    </td>
                                                    <td class="center">



                                                        {{ substr_replace($courses->course_brief, '...', 15) }}


                                                    </td>
                                                    <td class="center">
                                                        @if ($courses->payment == 'false')
                                                            Pending
                                                        @endif
                                                    </td>

                                                    <td class="center btn-ved">
                                                        <a class="btn btn-tbl-delete bg-primary" data-bs-toggle="modal"
                                                            data-id='{{ $courses->id }}' data-bs-target="#View_popup"
                                                            id="view">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @if ($courses->payment == 'false')
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-id="{{ $courses->id }}"
                                                                data-bs-target="#edit_popup" id="edit_course"
                                                                class="btn btn-tbl-delete bg-primary">
                                                                <i class="material-icons">edit</i>
                                                            </a>
                                                        @endif
                                                        <a onclick="confirmDelete('{{ url('/delete-course' . '/' . dEncrypt($courses->id)) }}')"
                                                            class="btn btn-tbl-delete bg-danger">
                                                            <i class="material-icons">delete</i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="add_courses" style="Display:none" class="faqs-row' + faqs_row + '">
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>Course Name<span class="text-danger">*</span></label>
                                            <input type="text" placeholder="Course Name" name="course_name[]"
                                                required>
                                        </div>
                                        @error('course_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="application_id" value="{{ $collections->id ?? '' }}"
                                    class="form-control" readonly>
                                <input type="hidden" placeholder="level_id" name="level_id[]"
                                    value="{{ 1 }}">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>Course Duration<span class="text-danger">*</span>
                                            </label>

                                            <div class="course_group">
                                                <input type="text" placeholder="Years" name="years[]"
                                                    maxlength="4" required class="course_input preventalpha">
                                                <input type="text" placeholder="Months" name="months[]"
                                                    maxlength="2" required class="course_input preventalpha">
                                                <input type="text" maxlength="2" placeholder="Days preventalpha"
                                                    name="days[]" required class="course_input">
                                                <input type="number" placeholder="Hours" name="hours[]" required
                                                    class="course_input">
                                            </div>
                                        </div>
                                        @error('course_duration')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>Eligibility<span class="text-danger">*</span></label>
                                            <input type="text" placeholder="Eligibility" name="eligibility[]"
                                                required>
                                        </div>
                                        @error('eligibility')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>Mode of Course <span class="text-danger">*</span></label>
                                            <div class="form-group default-select select2Style">
                                                <select class="form-control width" name="mode_of_course[]">
                                                    <option value="" disabled>Select Mode
                                                    </option>
                                                    <option value="Online">Online</option>
                                                    <option value="Offline">Offline</option>
                                                </select>
                                            </div>
                                        </div>
                                        @error('mode_of_course')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @if (request()->path() == 'level-first')
                                    <input type="hidden" placeholder="level_id" name="level_id"
                                        value="{{ 1 }}">
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

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>Course Brief <span class="text-danger">*</span></label>

                                            <textarea rows="4" cols="50" class="form-control" placeholder="Course Brief" name="course_brief[]"></textarea>
                                        </div>
                                        @error('course_brief')
                                            <div class="alert alert-danger">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>Declaration<span class="text-danger">*</span></label>
                                            <input type="file" name="doc1[]" id="payment_reference_no" required
                                                class="form-control file_size">
                                        </div>
                                        <label for="payment_reference_no" id="payment_reference_no-error"
                                            class="error">
                                            @error('payment_reference_no')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>Course Curriculum / Material / Syllabus <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="doc2[]" id="payment_reference_no" required
                                                class="form-control file_size">
                                        </div>
                                        <label for="payment_reference_no" id="payment_reference_no-error"
                                            class="error">
                                            @error('payment_reference_no')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>Course Details (Excel / CSV format) <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="doc3[]" id="payment_reference_no" required
                                                class="form-control">
                                        </div>
                                        <label for="payment_reference_no" id="payment_reference_no-error"
                                            class="error">
                                            @error('payment_reference_no')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div>
                                <hr>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <div>
                                    <a href="{{ url('new-applications/' . $applicationData->id) }}"
                                        class="btn btn-danger prev-step">Previous</a>
                                </div>
                                <div>
                                    @isset($course)
                                        @if (count($course) > 0)
                                            <a href="{{ url('course-payment/' . $applicationData->id) }}"
                                                class="btn btn-primary next-step1 mr-2">Next</a>
                                        @endif
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- View Modal Popup -->
                    <div class="modal fade" id="View_popup" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg modal-create-course" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle"> View Course Details</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="body">
                                        <div class="table-responsive table-con-free">
                                            <table
                                                class="table table-hover js-basic-example contact_list table-bordered">
                                                <tbody>
                                                    <tr class="odd gradeX">
                                                        <th class="center"> Course Name </th>
                                                        <td class="center">
                                                            <input type="text" id="Course_Name" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <th class="center"> Eligibility </th>
                                                        <td class="center">
                                                            <input type="text" id="Eligibility" required readonly>
                                                        </td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <th class="center"> Mode Of Course </th>
                                                        <td class="center">
                                                            <input type="text" id="Mode_Of_Course" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <th class="center">Payment Status</th>
                                                        <td class="center">
                                                            <input type="text" id="Payment_Status" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <th class="center">Course Brief</th>
                                                        <td class="text-center" id="view_course_brief">
                                                            <!-- <input type="text" name="course_brief[]"
                                                                id="view_course_brief" readonly> -->
                                                        </td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <th class="center">Duration</th>
                                                        <td class="center">
                                                            <span id="view_years"></span>
                                                            <span id="view_months"></span>
                                                            <span id="view_days"></span>
                                                            <span id="view_hours"></span>
                                                        </td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <th class="center">Declaration </th>
                                                        <td class="center">
                                                            <a href="" target="_blank" id="docpdf1"
                                                                title="Download Document 1"><i
                                                                    class="fa fa-eye mr-2"></i>
                                                                Doc 1
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <th class="center">Course Curriculum / Material / Syllabus
                                                        </th>
                                                        <td class="center">
                                                            <a href="" target="_blank" id="docpdf2"
                                                                title="Download Document 2"><i
                                                                    class="fa fa-eye mr-2"></i>
                                                                Doc 2
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr class="odd gradeX">
                                                        <th class="center">Course Details (Excel format) </th>
                                                        <td class="center">
                                                            <a target="_blank" href="" title="Document 3"
                                                                id="docpdf3" download>
                                                                <i class="fa fa-download mr-2"></i> Doc 3
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Modal Poup -->
                    <div class="modal fade" id="edit_popup">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle"> Edit Details </h5>
                                    <div class="payment-status d-flex">
                                        <label class="active">Payment Status : </label>
                                        <input type="text" name="Payment_Statuss" id="Payment_Statuss"
                                            class="btn btn-danger shadow-none p-0"
                                            style="border-bottom: 1px solid #fb483a !important; cursor: default !important;"
                                            readonly>
                                    </div>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body edit-popup">
                                    <div class="body col-md-12">
                                        <form action="" id="form_update" method="post">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label class="active">Course Name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="Course_Names"
                                                                id="Course_Names" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="form_step_type" value="add-course">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label>Course Duration <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="course_group">
                                                                Y <input type="number" placeholder="Years"
                                                                    name="years" required class="course_input"
                                                                    id="years">
                                                                M <input type="number" placeholder="Months"
                                                                    name="months" required class="course_input"
                                                                    id="months">
                                                                D <input type="number" placeholder="Days"
                                                                    name="days" required class="course_input"
                                                                    id="days">
                                                                H <input type="number" placeholder="Hours"
                                                                    name="hours" required class="course_input"
                                                                    id="hours">
                                                            </div>
                                                        </div>
                                                        @error('course_duration')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 pt-3">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label class="active">Eligibility<span> </label>
                                                            <input type="text" name="Eligibilitys" required
                                                                id="Eligibilitys" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group" style="margin-top: 5px;">
                                                        <div class="form-line">
                                                            <label>Mode of Course <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="custom-checkbox-group">
                                                                <label class="custom-button">
                                                                    <input type="checkbox" name="mode_of_course[]"
                                                                        id="offline_checkbox" value="Offline">
                                                                    <span class="checkbox-label">Offline</span>
                                                                </label>
                                                                <label class="custom-button">
                                                                    <input type="checkbox" name="mode_of_course[]"
                                                                        id="online_checkbox" value="Online">
                                                                    <span class="checkbox-label">Online</span>
                                                                </label>
                                                                <label class="custom-button">
                                                                    <input type="checkbox" name="mode_of_course[]"
                                                                        id="hybrid_checkbox" value="Hybrid">
                                                                    <span class="checkbox-label">Hybrid</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @error('mode_of_course')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>


                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label>Course Brief <span
                                                                    class="text-danger">*</span></label>
                                                            <textarea rows="4" cols="50" class="form-control" required placeholder="Course Brief"
                                                                name="course_brief" id="course_brief"></textarea>
                                                        </div>
                                                        @error('course_brief')
                                                            <div class="alert alert-danger">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label>Declaration<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="file" name="doc1" id="doc1_edit"
                                                                class="form-control doc_edit_1 file_size">
                                                            <a target="_blank" href="" id="docpdf1ss"
                                                                title=" Document 1"><i
                                                                    class="fa fa-eye mr-2 d-inline-block w-auto"></i>
                                                                Doc 1 </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label>Course Curriculum / Material / Syllabus <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="file" name="doc2"
                                                                id="payment_reference_no"
                                                                class="form-control doc_edit_2 file_size">
                                                            <a target="_blank" href="" id="docpdf2ss"
                                                                title=" Document 1"><i
                                                                    class="fa fa-eye mr-2 d-inline-block w-auto"></i>
                                                                Doc 2</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label>Course Details (Excel format) <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="file" name="doc3"
                                                                id="payment_reference_no"
                                                                class="form-control doc_edit_3 file_size">
                                                            <a href="" id="docpdf3ss"
                                                                title="Download Document 1" download><i
                                                                    class="fa fa-download mr-2 d-inline-block w-"></i>
                                                                Doc 3 </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" class="btn btn-primary waves-effect m-r-15"
                                                        onclick="load();">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    @include('layout.footer')

                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('.select2').select2();
                        });
                    </script>

                    <script>
                        $(document).on("click", "#view", function() {

                            var UserName = $(this).data('id');
                            console.log(UserName);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: "{{ url('course-list') }}",
                                type: "get",
                                data: {
                                    id: UserName
                                },
                                success: function(data) {


                                    console.log(data.ApplicationCourse[0].eligibility)
                                    console.log(data.Document[0].document_file)

                                    $("#Course_id").val(data.ApplicationCourse[0].id);
                                    $("#Course_Name").val(data.ApplicationCourse[0].course_name);
                                    $("#Eligibility").val(data.ApplicationCourse[0].eligibility);
                                    $("#Mode_Of_Course").val(data.ApplicationCourse[0].mode_of_course);
                                    if (data.ApplicationCourse[0].payment == "false") {
                                        $("#Payment_Status").val("Pending");
                                    }
                                    $("#view_course_brief").text(data.ApplicationCourse[0].course_brief);


                                    $("#view_years").html(data.ApplicationCourse[0].years + " Year(s)");
                                    $("#view_months").html(data.ApplicationCourse[0].months + " Month(s)");
                                    $("#view_days").html(data.ApplicationCourse[0].days + " Day(s)");
                                    $("#view_hours").html(data.ApplicationCourse[0].hours + " Hour(s)");

                                    //alert(data.Document[2].document_file);

                                    $("a#docpdf1").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[
                                            0]
                                        .document_file);
                                    $("a#docpdf2").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[
                                            1]
                                        .document_file);

                                    $("a#docpdf3").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[2]
                                        .document_file);
                                    /*$("a#docpdf3").attr("href", "{{ url('show-course-pdf') }}" + '/' + data.Document[2]
                                        .document_file);*/




                                }

                            });

                        });
                    </script>
                    <script>
                        $(document).on("click", "#edit_course", function() {

                            var offline_checkbox = $('#offline_checkbox').val();
                            var online_checkbox = $('#online_checkbox').val();
                            var hybrid_checkbox = $('#hybrid_checkbox').val();

                            //alert("edit course second 2420");
                            var UserName = $(this).data('id');
                            console.log(UserName);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: "{{ url('course-edit') }}",
                                type: "get",
                                data: {
                                    id: UserName
                                },
                                success: function(data) {



                                    var values = data.ApplicationCourse[0].mode_of_course;
                                    $.each(values, function(i, e) {
                                        $("#mode_of_course_edit option[value='" + e + "']").prop("selected",
                                            true);
                                    });

                                    $('#form_update').attr('action', '{{ url('/course-edit') }}' + '/' + data
                                        .ApplicationCourse[0].id)
                                    $("#Course_Names").val(data.ApplicationCourse[0].course_name);
                                    $("#Eligibilitys").val(data.ApplicationCourse[0].eligibility);

                                    const checkboxes = document.querySelectorAll(
                                        'input[type="checkbox"][name="mode_of_course[]"]');
                                    var modeOfCourseItems = data.ApplicationCourse[0].mode_of_course;

                                    checkboxes.forEach(checkbox => {
                                        if (modeOfCourseItems.includes(checkbox.value)) {
                                            checkbox.checked = true;
                                        } else {
                                            checkbox.checked = false;
                                        }
                                    });




                                    if (data.ApplicationCourse[0].payment == "false") {
                                        $("#Payment_Statuss").val("Pending");
                                    }

                                    $("#years").val(data.ApplicationCourse[0].years);
                                    $("#months").val(data.ApplicationCourse[0].months);
                                    $("#days").val(data.ApplicationCourse[0].days);
                                    $("#hours").val(data.ApplicationCourse[0].hours);
                                    $("#course_brief").val(data.ApplicationCourse[0].course_brief);

                                    //$("#doc1_edit").val(data.Document[0].document_file);



                                    //alert("yes");
                                    $("a#docpdf1ss").attr("href", "{{ url('show-course-pdf') }}" + '/' + data
                                        .Document[0]
                                        .document_file);
                                    $("a#docpdf2ss").attr("href", "{{ url('show-course-pdf') }}" + '/' + data
                                        .Document[1]
                                        .document_file);
                                    /*$("a#docpdf1ss").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[0]
                                        .document_file);
                                    $("a#docpdf2ss").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[1]
                                        .document_file);*/
                                    $("a#docpdf3ss").attr("href", "{{ asset('/documnet') }}" + '/' + data.Document[2]
                                        .document_file);

                                    //dd
                                }

                            });

                        });
                    </script>
                    <script>
                        var isAppending = false; // Flag to prevent multiple append requests
                        var cloneCounter = 1;
                        var maxClones = 10;

                        function updateCloneCount() {
                            // Update the formCount span with the current clone count
                            // $('#formCount').text(cloneCounter);
                        }

                        function addNewCourse() {
                            if (!isAppending && cloneCounter <= maxClones) {
                                isAppending = true;

                                // Clone the template row
                                var newRow = $('#new_course_html').clone();

                                // Clear input fields and remove any unwanted attributes
                                newRow.find('input, textarea').val('');
                                newRow.find('input[type="file"]').removeAttr('id').val('');

                                // Remove the ID attribute from the remove button
                                newRow.find('.remove-course').removeAttr('id');

                                // Show the remove button for the new row
                                newRow.find('.remove-course').show();

                                // Increment the cloneCounter for unique IDs
                                cloneCounter++;

                                if (cloneCounter >= maxClones) {
                                    // If the maximum limit is reached, disable the button
                                    $('#add-course-button').prop('disabled', true);
                                    // Change the background color of the #formCount span to red
                                    $('#formCount').css('background-color', 'red');
                                    Swal.fire({
                                        title: "Warning",
                                        text: "You've reached the maximum limit of " + maxClones +
                                            " courses, including the original course form.",
                                        icon: "warning",
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }

                                updateCloneCount();

                                // Update the name attribute of the mode_of_course select field
                                var modeOfCourseSelect = newRow.find('.select2[name^="mode_of_course[1]"]');
                                modeOfCourseSelect.attr('name', `mode_of_course[${cloneCounter}][]`);

                                $("#mode-of-course-edit").select2({
                                    placeholder: "Select a programming language",
                                    allowClear: true
                                });
                                // Reset Select2 for the cloned select element
                                modeOfCourseSelect.select2();
                                modeOfCourseSelect.select2('destroy'); // Destroy the previous instance

                                // Add a class to the new row
                                newRow.addClass('new-course-html');

                                // Append the new row to the container
                                $('.new-course-row').append(newRow); // Append to the existing .new-course-row div


                                // add top border
                                $('.new-course-html:last-child').css('border-top', '1px solid #ccc');

                                // add bottom border
                                $('.new-course-html:last-child').css('border-bottom', '1px solid #ccc');

                                // add left border
                                $('.new-course-html:last-child').css('border-left', '1px solid #ccc');

                                // add right border
                                $('.new-course-html:last-child').css('border-right', '1px solid #ccc');

                                // add top and bottom padding 10px;
                                $('.new-course-html:last-child').css('padding-top', '10px');
                                $('.new-course-html:last-child').css('padding-bottom', '10px');

                                // add left and right padding 10px;
                                $('.new-course-html:last-child').css('padding-left', '5px');
                                $('.new-course-html:last-child').css('padding-right', '5px');

                                // add top and bottom margin 10px;
                                $('.new-course-html:last-child').css('margin-top', '10px');
                                $('.new-course-html:last-child').css('margin-bottom', '10px');


                                // Append the hidden input elements
                                // Manually set values for "application_id" and "level_id"

                                // Set the values for "application_id" and "level_id"
                                var applicationId = '{{ $applicationData->id ?? '' }}';
                                var levelId = '{{ $applicationData->level_id ?? '' }}';

                                newRow.find('input[name="application_id"]').val(applicationId);
                                newRow.find('input[name="level_id"]').val(levelId);


                                newRow.append('<input type="hidden" name="country" value="{{ $data->country ?? '' }}">');
                                newRow.append('<input type="hidden" name="state" value="{{ $data->state ?? '' }}">');

                                $('.select2').select2();

                                $('.select2-selection--single').hide();


                                isAppending = false; // Reset the flag


                            }
                        }

                        function removeCourse(button) {
                            // Find the parent row and remove it
                            $(button).closest('.new-course-html').remove();
                        }

                        $(document).ready(function() {
                            updateCloneCount();
                        });
                    </script>

                    <script>
                        function confirmDelete(deleteUrl) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // If the user confirms, proceed with the delete operation by navigating to the delete URL
                                    window.location.href = deleteUrl;
                                }
                            });
                        }

                        // select2 multiple
                        $(document).ready(function() {
                            var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                                removeItemButton: true,
                                maxItemCount: 3,
                                searchResultLimit: 5,
                                renderChoiceLimit: 5
                            });

                        });
                    </script>

                    <script>
                        var doc_file1 = "";

                        $('.doc_1').on('change', function() {

                            doc_file1 = $(".doc_1").val();
                            console.log(doc_file1);
                            var doc_file1 = doc_file1.split('.').pop();
                            if (doc_file1 == 'pdf') {
                                // alert("File uploaded is pdf");
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Validation error!',
                                    text: 'Only PDF files are allowed',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                                $('.doc_1').val("");
                            }

                        });
                    </script>
                    <script>
                        var doc_file2 = "";
                        $('.doc_2').on('change', function() {

                            doc_file2 = $(".doc_2").val();
                            console.log(doc_file2);
                            var doc_file2 = doc_file2.split('.').pop();
                            if (doc_file2 == 'pdf') {
                                // alert("File uploaded is pdf");
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Validation error!',
                                    text: 'Only PDF files are allowed',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                                $('.doc_2').val("");
                            }

                        });
                    </script>
                    <script>
                        var doc_file3 = "";
                        $('.doc_3').on('change', function() {

                            doc_file3 = $(".doc_3").val();
                            console.log(doc_file3);
                            var doc_file3 = doc_file3.split('.').pop();


                            if (doc_file3 == 'csv' || doc_file3 == 'xlsx' || doc_file3 == 'xls') {
                                // alert("File uploaded is pdf");
                            } else {
                                //  alert("Only csv,xlsx,xls  are allowed")
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'Validation error!',
                                    text: 'Only csv,xlsx, and xlsx are allowed',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                                $('.doc_3').val("");
                            }

                        });
                    </script>
