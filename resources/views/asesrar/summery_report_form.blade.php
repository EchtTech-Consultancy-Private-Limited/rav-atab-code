@include('layout.header')
<title>RAV Accreditation</title>
<style>
    table th,
    table td {
        text-align: center;
        border: 1px solid #eee;
        color: #000;
    }

    .highlight {
        background-color: #9789894a;
    }

    .highlight_nc {
        background-color: #ff000042;
    }

    .highlight_nc_approved {
        background-color: #00800040;
    }

    td select.form-control.text-center {
        border: 0;
    }

    .loading-img {
        z-index: 99999999;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        ;
        overflow: hidden;
        text-align: center;
    }

    .loading-img .box {
        position: absolute;
        top: 50%;
        left: 50%;
        margin: auto;
        transform: translate(-50%, -50%);
        z-index: 2;
    }

    .uploading-text {
        padding-top: 10px;
        color: #fff;
        /* font-size: 18px; */
    }

    td.text-justify {
        text-align: left;
    }

    .btnDiv a {
        margin-right: 10px !important;
    }



    .file-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .file-label {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #3498db;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 12px;
    }

    .file-label:hover {
        background-color: #2980b9;
    }

    .file-input {
        display: none;
    }

    table {
        /* caption-side: bottom; */
        border-collapse: collapse;
        /* border: 1px solid #ddd !important; */
        background: #fff;
        padding: 33px !important;
    }

    table td {
        text-align: left;
        padding: 10px 10px;
    }

    table th,
    table td,
    table tr {
        text-align: center;
        border: 1px solid #aaa !important;
        color: #000;
    }
</style>

</head>

<body class="light">
    <!-- Progressbar Modal Poup -->
    <div class="loading-img d-none" id="loader">
        <div class="box">
            <img src="{{ asset('assets/img/VAyR.gif') }}">
            <h5 class="uploading-text"> Uploading... </h5>
        </div>
    </div>
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
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">View Documents</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Level </a>
                            </li>
                            <li class="breadcrumb-item active">View Documents</li>
                        </ul>
                    </div>

                </div>
            </div>
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session::get('success') }}
                </div>
            @elseif(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('fail') }}
                </div>
            @endif
            @foreach ($applicationDetails->courses as $item)
                <div>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12">
                            <form id="submitForm" action="{{ route('submit-final-report-by-desktop') }}"method="post">
                                @csrf
                                <div class="p-3  bg-white">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td colspan="2">FORM -1 DESKTOP ASSESSMENT FORM</td>
                                            </tr>
                                            <tr>
                                                <input type="hidden" name="course_id" value="{{ $_GET['course'] }}">
                                                <input type="hidden" name="summary_type" value="desktop">
                                                <input type="hidden" name="application_id"
                                                    value="{{ $applicationDetails->id }}" readonly>`
                                                <td>Application No (provided by ATAB): <span> <input type="text"
                                                            name="application_uid"
                                                            value="{{ $applicationDetails->application_uid }}"
                                                            readonly></span> </td>
                                                <td>Date of application: <span> <input type="text"
                                                            name="date_of_application"
                                                            value="{{ date('d-m-Y', strtotime($applicationDetails->created_at)) }}"
                                                            readonly></span> </td>
                                            </tr>
                                            <tr>
                                                <td>Name and Location of the Training Provider: <span> <input
                                                            type="text" name="location_training_provider"
                                                            value="{{ $applicationDetails->user->firstname . ' ' . $applicationDetails->user->lastname . ' (' . $applicationDetails->user->address . ')' }}"
                                                            readonly></span> </td>
                                                <td>Name of the course to be assessed:

                                                    <span> <input type="text" name="course_assessed"
                                                            value="{{ Str::ucfirst($item->course_name) }}"
                                                            readonly></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Way of assessment (Desktop): <span> <input type="text"
                                                            name="way_of_desktop" value="Desktop" readonly></span> </td>
                                                <td>No of Mandays: <span> {{ getMandays($applicationDetails->id, auth()->user()->id) }}</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td> Signature</td>
                                                <td><span> <input type="hidden" name="signature"> </span></td>
                                            </tr>
                                            <tr>
                                                <td> Assessor Name</td>
                                                <td><span> <input type="text" name="assessor"
                                                            value="{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}"
                                                            readonly> </span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sl. No </th>
                                                    <th>Objective Element</th>
                                                    <th> NC raised</th>
                                                    <th> CAPA by Training Provider</th>
                                                    <th> Document submitted against the NC</th>
                                                    <th> Remarks (Accepted/ Not accepted)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($chapters as $chapter)
                                                    <tr>
                                                        <td colspan="6"
                                                            style="font-weight: bold; text-align:center;">
                                                            {{ $chapter->title ?? '' }}
                                                        </td>
                                                    </tr>
                                                    @foreach ($chapter->questions as $question)
                                                        @php
                                                            $comment = getDocumentComment($question->id, $applicationDetails->id,$_GET['course']) ?? 0;
                                                        @endphp
                                                        @if ($comment)
                                                            @if ($comment->status != 4)
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="question_id[]"
                                                                            value="{{ $question->id }}" readonly>
                                                                        {{ $question->code }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $question->title }}
                                                                    </td>
                                                                    <td> <input type="text" name="nc_raised[]" required></td>
                                                                    <td> <input type="text"
                                                                            name="capa_training_provider[]" required></td>
                                                                    <td> <input type="text"
                                                                            name="document_submitted_against_nc[]" required></td>
                                                                    <td> <input type="text" name="remark[]" required></td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success float-right"
                                    onclick="confirmSubmit()">Submit</button>
                            </form>
            @endforeach
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
    </section>
    <script>
        function confirmSubmit() {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to submit the report?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms, manually submit the form
                    document.getElementById('submitForm').submit();
                }
            });
        }
    </script>
    @include('layout.footer')
