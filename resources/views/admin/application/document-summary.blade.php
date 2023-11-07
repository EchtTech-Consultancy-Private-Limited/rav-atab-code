@include('layout.header')


<title>RAV Accreditation Previous Applications View</title>
<link rel="stylesheet" type="text/css"
    href="https://rawgithub.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
{{--
<link rel="stylesheet" type="text/css" href="https://rawgithub.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
 --}}
<style>
    .text-size-11 {
        font-size: 11px !important;
    }
</style>
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
                        <li class="breadcrumb-item active">Application Summary</li>
                    </ul>

                    <a href="{{ url('nationl-page') }}" type="button" class="btn btn-primary" style="float:right;">Back
                    </a>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">Basic Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Organization/Institute</th>
                        <th>Email</th>
                        <th>Mobile</th>
                    </tr>
                    <tr>
                        <td>{{ $applicationDetails->user->firstname }}</td>
                        <td>{{ $applicationDetails->user->middlename }}</td>
                        <td>{{ $applicationDetails->user->lastname }}</td>
                        <td>{{ $applicationDetails->user->organization }}</td>
                        <td>{{ $applicationDetails->user->email }}</td>
                        <td>{{ $applicationDetails->user->mobile_no }}</td>
                    </tr>
                    <tr>
                        <th>Designation</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th colspan="2">Postal Code</th>
                    </tr>
                    <tr>
                        <td>{{ $applicationDetails->user->designation }}</td>
                        <td>{{ $applicationDetails->user->countryDetail->name }}</td>
                        <td>{{ $applicationDetails->user->stateDetail->name }}</td>
                        <td>{{ $applicationDetails->user->cityDetail->name }}</td>
                        <td colspan="2">{{ $applicationDetails->user->postal }}</td>
                    </tr>
                    <tr>
                        <th colspan="6">Address</th>
                    </tr>
                    <tr>
                        <td colspan="6">{{ $applicationDetails->user->address }}</td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="4">Single Point of Contact Details (SPoC)</th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Designation</th>
                    </tr>
                    <tr>
                        <td>{{ $applicationDetails->Person_Name }}</td>
                        <td>{{ $applicationDetails->Contact_Number }}</td>
                        <td>{{ $applicationDetails->Email_ID }}</td>
                        <td>{{ $applicationDetails->designation }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @foreach ($applicationDetails->courses as $item)
            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2">
                        {{ Str::ucfirst($item->course_name) }}
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Course Name</th>
                            <th>Duration</th>
                            <th>Eligibility</th>
                            <th>Mode of Course</th>
                            <th>Valid To</th>
                            <th>Valid From</th>
                        </tr>
                        <tr>
                            <td>
                                {{ Str::ucfirst($item->course_name) }}
                            </td>
                            <td>
                                {{ $item->years ?? '' }} Years(s)
                                {{ $item->months ?? '' }} Month(s)
                                {{ $item->days ?? '' }} Day(s)
                                {{ $item->hours ?? '' }} Hour(s)
                            </td>
                            <td>
                                {{ $item->eligibility ?? '' }}
                            </td>
                            <td>
                                {{ get_course_mode($item->id) }}
                            </td>
                            <td>
                                {{ date('d F Y', strtotime($item->created_at)) }}
                            </td>
                            <td>
                                {{ date('d F Y', strtotime($item->created_at->addYear())) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <table>
                                    <tr>
                                        @if (count($item->documents) > 0)
                                            @foreach ($item->documents as $document)
                                                <th>
                                                    @if ($loop->iteration == 1)
                                                        Declaration
                                                    @elseif ($loop->iteration == 2)
                                                        Course Curriculum / Material / Syllabus
                                                    @elseif ($loop->iteration == 3)
                                                        Course Details (Excel format)
                                                    @endif
                                                </th>
                                                <td>
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
                                                </td>
                                            @endforeach
                                        @endif
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <th>Documents</th>
                        </tr>
                        <tr>
                            <td class="p-0">
                                <table class="table table-bordered m-0">
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th width="500">Objective Criteria</th>
                                            <th>Desktop Assessor</th>
                                            <th>On-Site Assessor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($chapters as $chapter)
                                            <tr>
                                                <td colspan="4" style="font-weight: bold; text-align:center;">
                                                    {{ $chapter->title ?? '' }}</td>
                                            </tr>
                                            @foreach ($chapter->questions as $question)
                                                <tr>
                                                    <td>{{ $question->code }}</td>
                                                    <td>{{ $question->title }}</td>
                                                    <td class="text-center">
                                                        @php
                                                            $documentsData = getAdminDocument($question->id, $applicationDetails->id) ?? 0;
                                                        @endphp
                                                        @if (count($documentsData) > 0)
                                                            <div class="d-flex justify-content-center">
                                                                @if (count($documentsData) <= 1)
                                                                    @foreach ($documentsData as $doc)
                                                                        @if ($doc->application_id == $applicationDetails->id)
                                                                            <div>
                                                                                <a target="_blank"
                                                                                    title="{{ checkDocumentCommentStatusreturnText($doc->id) }}"
                                                                                    href="{{ url('admin-view-doc' . '/' . $doc->doc_id . '/' . $doc->doc_file . '/' . $doc->id . '/' . $item->id) }}"
                                                                                    class="docBtn text-size-11 text-white {{ checkDocumentCommentStatus($doc->id) }}"
                                                                                    style="color: #fff ;margin:10px;"
                                                                                    id="view_doc1">{{ getButtonText($doc->id) ?? '' }}</a>
                                                                                <div
                                                                                    style="font-size: 10px; padding-top:3px; padding-bottom:3px;">
                                                                                    {{ checkFinalRequest($doc->id) }}
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <span class="bg-danger p-2 text-white"
                                                                                style="border-radius: 5px;  font-size:12px;">
                                                                                Documents
                                                                                not
                                                                                uploaded
                                                                            </span>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    @foreach ($documentsData as $doc)
                                                                        @if ($doc->application_id == $applicationDetails->id)
                                                                            <div>
                                                                                <a target="_blank"
                                                                                    title="{{ checkDocumentCommentStatusreturnText($doc->id) }}"
                                                                                    href="{{ url('admin-view-doc' . '/' . $doc->doc_id . '/' . $doc->doc_file . '/' . $doc->id . '/' . $item->id) }}"
                                                                                    class="docBtn text-size-11 text-white {{ checkDocumentCommentStatus($doc->id) }}"
                                                                                    style="color: #fff ;margin:10px;"
                                                                                    id="view_doc1">{{ getButtonText($doc->id) ?? '' }}</a>
                                                                                <div
                                                                                    style="font-size: 10px; padding-top:3px; padding-bottom:3px;">
                                                                                    {{ checkFinalRequest($doc->id) }}
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="bg-danger p-2 text-white"
                                                                style="border-radius: 5px; font-size:12px;">
                                                                Documents not uploaded
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @php
                                                            $verifiedDocumentForAdmin = checkVerifiedDocumentAvailableForAdmin($applicationDetails->id, $item->id, $question->id);
                                                        @endphp
                                                        @if (isset($verifiedDocumentForAdmin->verified_document) && !empty($verifiedDocumentForAdmin->verified_document))
                                                            @php
                                                                $fileExtension = pathinfo($verifiedDocumentForAdmin->verified_document, PATHINFO_EXTENSION);
                                                            @endphp
                                                            @if ($fileExtension === 'pdf')
                                                                <a target="_blank"
                                                                    href="{{ url('show-course-pdf/' . $verifiedDocumentForAdmin->verified_document) }}"
                                                                    class="docBtn text-size-11 bg-primary"
                                                                    style="margin-right: 10px !important; ">View
                                                                    Document </a>
                                                            @else
                                                                <a target="_blank"
                                                                    href="{{ asset('documnet/' . $verifiedDocumentForAdmin->verified_document) }}"
                                                                    class="docBtn text-size-11 bg-primary"
                                                                    style="margin-right: 10px !important; ">View
                                                                    Document </a>
                                                            @endif
                                                        @endif
                                                        <div style="height: 10px;"></div>
                                                        @php
                                                            $verifiedPhotograph = checkVerifiedDocumentAvailableForAdmin($applicationDetails->id, $item->id, $question->id);
                                                        @endphp
                                                        @if (isset($verifiedPhotograph->photograph) && !empty($verifiedPhotograph->photograph))
                                                            @php
                                                                $fileExtension = pathinfo($verifiedPhotograph->photograph, PATHINFO_EXTENSION);
                                                            @endphp

                                                            @if ($fileExtension === 'pdf')
                                                                <a target="_blank"
                                                                    href="{{ url('show-course-pdf/' . $verifiedPhotograph->photograph) }}"
                                                                    class="docBtn text-size-11 bg-secondary">View
                                                                    Photograph </a>
                                                            @else
                                                                <a target="_blank"
                                                                    href="{{ asset('documnet/' . $verifiedPhotograph->photograph) }}"
                                                                    class="docBtn text-size-11 bg-secondary">View
                                                                    Photograph </a>
                                                            @endif
                                                        @endif
                                                        @if (
                                                            !isset($verifiedDocumentForAdmin->verified_document) &&
                                                                empty($verifiedDocumentForAdmin->verified_document) &&
                                                                !isset($verifiedPhotograph->photograph) &&
                                                                empty($verifiedPhotograph->photograph))
                                                            <span class="bg-danger text-white p-2"
                                                                style="font-size: 12px; border-radius:5px;">
                                                                No Action!
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endforeach

        <div class="card">
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                    Remark by on-site assessor
                </h5>
            </div>
            <div class="card-body">
                @if (
                    $applicationDetails->gps_pic == '' ||
                        $applicationDetails->gps_pic == null ||
                        $applicationDetails->final_remark == '' ||
                        $applicationDetails->final_remark == null)
                    Data not available!
                @else
                    <div>
                        <span style="font-weight: bold;">GPS Picture</span>
                        <div>
                            <a href="{{ asset('documnet/' . $applicationDetails->gps_pic) }}" target="_blank">
                                <img style="width: 200px; padding-top:10px; padding-bottom:20px;" src="{{ asset('documnet/' . $applicationDetails->gps_pic) }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div>
                        <span style="font-weight: bold;">Remark</span>
                        <div style="font-size: 12px;">
                            {{ $applicationDetails->final_remark }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>




    @include('layout.footer')
