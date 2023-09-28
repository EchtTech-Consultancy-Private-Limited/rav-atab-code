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

    .select-box-hide-class select {
        display: none;
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
                    @if (Session::has('success'))
                        <div class="alert alert-success" style="padding: 15px;" role="alert">
                            {{ session::get('success') }}
                        </div>
                    @elseif(Session::has('fail'))
                        <div class="alert alert-danger" role="alert">
                            {{ session::get('fail') }}
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card">
                        <div class="header mb-4">
                            <h2 style="float:left; clear:none;">Level Courses </h2>
                            {{-- @if (count($course) > 0) --}}

                            <a href="javascript:void(0);" class="btn btn-outline-primary mb-0"
                                style="float:right; clear:none; cursor:pointer;line-height: 24px;"
                                onclick="addNewCourse();">
                                <i class="fa fa-plus font-14"></i> Add More Course
                            </a>

                            {{-- @endif --}}
                        </div>
                        <form action="{{ url('/new-application-course') }}" enctype="multipart/form-data" method="post"
                            class="form" id="regForm">
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
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Name<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Course Name" name="course_name[]"
                                                    required class="preventnumeric" maxlength="50">
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


                                    <input type="hidden" name="coutry"
                                        value=" {{ $applicationData->country ?? '' }}">
                                    <input type="hidden" name="state" value=" {{ $applicationData->state ?? '' }}">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Duration<span class="text-danger">*</span></label>

                                                <div class="course_group">
                                                    <input type="text" placeholder="Years" name="years[]"
                                                        maxlength="4" required class="course_i nput preventalpha">
                                                    <input type="text" placeholder="Months" name="months[]"
                                                        maxlength="2" required class="course_input preventalpha">
                                                    <input type="text" maxlength="2" placeholder="Days "
                                                        name="days[]" required class="course_input preventalpha">
                                                    <input type="number" placeholder="Hours" name="hours[]" required
                                                        class="course_input">
                                                </div>
                                            </div>
                                            @error('course_duration')
                                                <div class="alert alert-danger">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
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
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Mode of Course <span class="text-danger">*</span></label>
                                                <div class="form-group">
                                                    <select class="form-control select2" name="mode_of_course[]"
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
                                    <div class="col-sm-8">
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

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Declaration (PDF)<span class="text-danger">*</span></label>
                                                <input type="file" name="doc1[]" id="payment_reference_no"
                                                    required class="form-control doc_1 file_size">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Curriculum / Material / Syllabus
                                                    (PDF)<span class="text-danger">*</span></label>
                                                <input type="file" name="doc2[]" id="payment_reference_no"
                                                    required class="form-control doc_2 file_size">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Details (Excel format)<span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="doc3[]" id="payment_reference_no"
                                                    required class="form-control doc_3 file_size">
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


                            <div class="row clearfix new-course-row">

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
                                            <th class="center"> Course Duration </th>
                                            <th class="center"> Eligibility </th>
                                            <th class="center"> Mode Of Course </th>
                                            <th class="center"> Course Brief</th>
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
                                                    <td class="center">
                                                        years:{{ $courses->years }},
                                                        Months: {{ $courses->months }},
                                                        days: {{ $courses->days }},
                                                        Hours: {{ $courses->hours }}
                                                    </td>
                                                    <td class="center">{{ $courses->eligibility }}
                                                    </td>
                                                    <td class="center">
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
                                                        <a onclick="return confirm_option('delete')"
                                                            href="{{ url('/delete-course' . '/' . dEncrypt($courses->id)) }}"
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
                                                <select class="form-control select2 width" name="mode_of_course[]">
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
                        <ul class="list-inline pull-right mt-5">
                            <li><a href="{{ url('new-applications/'.$applicationData->id) }}" class="btn btn-danger prev-step">Previous</a>
                            </li>

                            <li>

                                @isset($course)
                                    @if (count($course) > 0)
                                        <button type="button" class="btn btn-primary next-step1">Next</button>
                                    @endif
                                @endisset
                            </li>
                        </ul>
                    </div>
                    @include('layout.footer')
                    <script>

                        var isAppending = false; // Flag to prevent multiple append requests

                        function addNewCourse() {
                            if (!isAppending) {
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
                                $('.new-course-html:last-child').css('padding-left', '10px');
                                $('.new-course-html:last-child').css('padding-right', '10px');

                                // add top and bottom margin 10px;
                                $('.new-course-html:last-child').css('margin-top', '10px');
                                $('.new-course-html:last-child').css('margin-bottom', '10px');


                                // Append the hidden input elements
                                newRow.append(
                                    '<input type="hidden" name="application_id" value="{{ $collections->id ?? '' }}" class="form-control" readonly>'
                                );
                                newRow.append(
                                    '<input type="hidden" placeholder="level_id" name="level_id" value="@if (isset($Application)) {{ $Application->level_id ?? '' }} @endif">'
                                );
                                newRow.append('<input type="hidden" name="country" value="{{ $data->country ?? '' }}">');
                                newRow.append('<input type="hidden" name="state" value="{{ $data->state ?? '' }}">');


                                $('.select2').select2();

                                isAppending = false; // Reset the flag
                            }
                        }

                        function removeCourse(button) {
                            // Find the parent row and remove it
                            $(button).closest('.new-course-html').remove();
                        }
                    </script>
