@include('layout.header')


<title>RAV Accreditation</title>

<style>
    .selectINputBox {
        padding: 8px !important;
        border: 1px solid #ccc !important;
        width: 300px !important;
    }

    table {
        /* caption-side: bottom; */
        border-collapse: collapse;
        /* border: 1px solid #ddd !important; */
        background: #fff;
        padding: 33px !important;
    }


    table th,
    table td,
    table tr {
        text-align: center;
        border: 1px solid #aaa !important;
        color: #000;
    }

    table td {
        text-align: left !important;
        padding: 10px 10px;
        font-weight: 700;
    }

    .table-summery .table-bordered tbody tr td,
    .table-summery .table-bordered tbody tr th {
        text-emphasis: left !important;
    }

    .next-step, .next-step1, .next-step2, .prev-step, .prev-step1, .preview-step, .btn:not(.btn-link):not(.btn-circle) {
        padding: 6px 18px;
        white-space: nowrap;
    }

    .width-50 {
        width: 50%;
    }

</style>
</head>

<body class="light">


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

@if ($message = Session::get('success'))
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: "Success",
            text: "{{ $message }}",
            showConfirmButton: false,
            timer: 3000
        })
    </script>
@endif

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

                <a href="{{ url('nationl-accesser') }}" type="button" class="btn btn-primary"
                   style="float:right;">Back
                </a>
                <a type="button" class="btn btn-primary float-right me-2" onclick="printDiv('printableArea')">Print
                </a>

            </div>
        </div>
    </div>
    <div id="printableArea">
        <div id="applicationSummaryContainer" class="table-summery">

            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2"> ONSITE ASSESSMENT FORM</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Application No (provided by ATAB) : {{ $applicationDetails->application_uid }} </td>
                            <td>Date of application :
                                {{ \Carbon\Carbon::parse($applicationDetails->created_at)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td>Name and Location of the Training Provider :
                                {{ $summaryReport->location_training_provider }}</td>
                            <td>Name of the course to be assessed : {{ $summaryReport->course_assessed }} </td>
                        </tr>
                        <tr>
                            <td>Way of assessment : {{ $summaryReport->way_of_desktop }}</td>
                            <td>No of Mandays : {{ $summaryReport->mandays }}</td>
                        </tr>
                        <tr>
                            <td>Signature</td>
                            <td>.............</td>
                        </tr>
                        <tr>
                            <td>Assessor Name</td>
                            <td>{{ auth()->user()->firstname . ' ' . auth()->user()->middlename . ' ' . auth()->user()->lastname }}
                            </td>
                        </tr>


                    </table>


                    <table class="table table-bordered">
                        <tr>
                            <th>Sl. No</th>
                            <th class="width-50">Objective Element</th>
                            <th>NC raised</th>
                            <th>CAPA by Training Provider</th>
                            <th>Document submitted <br> against the NC</th>
                            <th>Remarks (Accepted/ Not accepted)</th>
                        </tr>
                        @foreach ($chapters as $chapter)
                            <tr>
                                <td colspan="6" style="font-weight: bold; text-align:center;">
                                    {{ $chapter->title ?? '' }}
                                </td>
                            </tr>
                            @foreach ($chapter->questions as $question)
                                <tr>
                                    <td> {{ $question->code }}</td>
                                    <td>{{ $question->title }}</td>
                                    <td>
                                        @php
                                            $getNCRecords = getNCRecords($question->id, $course, $applicationDetails->id);
                                        @endphp
                                        {{ $getNCRecords }}
                                    </td>
                                    <td>
                                        @php
                                            $documents = getSingleDocument($question->id, $course, $applicationDetails->id);
                                        @endphp
                                        @if ($documents)
                                            @php
                                                $comment = getDocRemarks($documents->id);
                                            @endphp
                                            @if ($comment)
                                                {{ $comment->remark }}
                                                <input type="hidden"
                                                       name="capa_training_provider[]"
                                                       value="{{ $comment->remark }}">
                                            @else
                                                No Remark
                                                <input type="hidden"
                                                       name="capa_training_provider[]"
                                                       value="No remark">
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $documents = getQuestionDocument($question->id, $course, $applicationDetails->id);
                                        @endphp
                                        @if ($documents)
                                            @foreach ($documents as $item)
                                                <div>
                                                    <a target="_blank" href="{{ asset('level/'.$item->doc_file)  }}"
                                                       class="btn btn-primary m-1" href="">View Doc</a>
                                                </div>
                                                <input type="hidden" name="document_submitted_against_nc[]"
                                                       value="{{ $item->doc_file }}">
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @php

                                            $documents = getONeDocument($question->id,$applicationDetails->id,$course);
                                        @endphp
                                        @if($documents)
                                            @php
                                                $comment = getLastComment($documents->id);
                                            @endphp
                                            @if($comment)
                                                {{ ucfirst($comment->comments) }}
                                                <input type="hidden" name="remark[]" value="{{ $comment->comments }}">
                                            @endif
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>

                    <table>

                        <tbody>
                        <tr>
                            <td colspan="4">
                                FORM -3 - OPPORTUNITY FOR IMPROVEMENT FORM
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Name and Location of the Training Provider:
                                {{ $improvementForm->training_provider_name }}</td>
                            <td colspan="2">Name of the course to be assessed:
                                {{ $improvementForm->course_name }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"> Way of assessment (onsite/ hybrid/ virtual):
                                {{ $improvementForm->way_of_assessment }}</td>
                            <td colspan="2"> No of Mandays: {{ $improvementForm->mandays }}</td>
                        </tr>
                        <tr>
                            <td> S. No.</td>
                            <td> Opportunity for improvement Form</td>
                            <td colspan="2"> Standard reference</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> {{ $improvementForm->opportunity_for_improvement }}</td>
                            <td> {{ $improvementForm->standard_reference }}</td>
                        </tr>

                        <tr>
                            <td> Signatures</td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>Name</td>
                            <td>{{ $improvementForm->name }} </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> Team Leader: {{ $improvementForm->team_leader }} </td>
                            <td> Assessor: {{ $improvementForm->assessor_name }} </td>
                            <td> Rep. Assessee Orgn: {{ $improvementForm->rep_assessee_orgn }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"> Date: {{ $improvementForm->date_of_submission }}</td>
                            <td colspan="2"> Signature of the Team Leader</td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3 text-center">
                    <div class="card">
                        <div class="card-body">
                            <h4>Total NC</h4>
                            <div>
                                <span style="font-weight: bold">
                                    {{ $totalNc ?? 0 }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 text-center">
                    <div class="card">
                        <div class="card-body">
                            <h4>Total Accepted</h4>
                            <div>
                                <span style="font-weight: bold">
                                    {{ $totalAccepted ?? 0 }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


@include('layout.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"
        integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
