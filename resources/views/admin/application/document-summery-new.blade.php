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
                    <a type="button" class="btn btn-danger float-right me-2" onclick="printDiv('printableArea')"><i class="fas fa-print mr-2"></i> Print
                    </a>

                </div>
            </div>
        </div>

        <div id="printableArea">
            <div id="applicationSummaryContainer" class="table-summery">
                @php
                    $summaries = getSummaries($applicationDetails->id, $course);

                @endphp

                @if ($summaries != null)
                    <div class="card">
                        <div class="card-header bg-white text-dark">
                            <h5 class="mt-2">
                                DESKTOP ASSESSMENT FORM
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Application No (provided by ATAB) :
                                        {{ $summaries->application->application_uid }} </td>
                                    <td>Date of application :
                                        {{ \Carbon\Carbon::parse($summaries->application->created_at)->format('d-m-Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name and Location of the Training Provider :
                                        {{ $summaries->location_training_provider }}</td>
                                    <td>Name of the course to be assessed : {{ $summaries->course_assessed }} </td>
                                </tr>
                                <tr>
                                    <td>Way of assessment : {{ $summaries->way_of_desktop }}</td>
                                    <td>No of Mandays : {{ $summaries->mandays ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Signature</td>
                                    <td>.............</td>
                                </tr>
                                <tr>
                                    <td>Assessor Name</td>
                                    <td>{{ $summaries->assessor }}
                                    </td>
                                </tr>

                            </table>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Objective Element</th>
                                    <th>NC raised</th>
                                    <th>CAPA by Training Provider</th>
                                    <th>Document submitted against the NC</th>
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
                                            <td>{{ $question->code }}</td>
                                            <td>{{ $question->title }}</td>
                                            <td>
                                                @php
                                                    $documents = getAllDocumentsForSummaryForDesktop($question->id, $applicationDetails->id, $course);
                                                @endphp
                                                @if (count($documents) > 0)
                                                    @foreach ($documents as $doc)
                                                        @php
                                                            $comment = getDocComment($doc->id);
                                                        @endphp
                                                        @if ($comment)
                                                            @if ($comment->status == 1)
                                                                NC1
                                                            @elseif($comment->status == 2)
                                                                NC2
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <span>Document not uploaded!</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $documents = getSingleDocumentForDesktop($question->id, $course, $applicationDetails->id);
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
                                                    $documents = getQuestionDocumentDesktop($question->id, $course, $applicationDetails->id);
                                                @endphp
                                                @if ($documents)
                                                    @foreach ($documents as $item)
                                                        <div>
                                                            <a class="btn btn-primary m-1" href="">View Doc</a>
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

                        </div>
                    </div>
                @endif

                @if ($summaryReport != null)
                    <div class="card">
                        <div class="card-header bg-white text-dark">
                            <h5 class="mt-2"> ONSITE ASSESSMENT FORM</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Application No (provided by ATAB) : {{ $applicationDetails->application_uid }}
                                    </td>
                                    <td>Date of application :
                                        {{ \Carbon\Carbon::parse($applicationDetails->created_at)->format('d-m-Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name and Location of the Training Provider :
                                        {{ $summaryReport->location_training_provider }}</td>
                                    <td>Name of the course to be assessed : {{ $summaryReport->course_assessed }} </td>
                                </tr>
                                <tr>
                                    <td>Way of assessment : {{ $summaryReport->way_of_desktop }}</td>
                                    <td>No of Mandays : {{ $summaryReport->mandays ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Signature</td>
                                    <td>.............</td>
                                </tr>
                                <tr>
                                    <td>Assessor Name</td>
                                    <td>{{ $summaryReport->assessor }}
                                    </td>
                                </tr>


                            </table>


                            <table class="table table-bordered">
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Objective Element</th>
                                    <th>NC raised</th>
                                    <th>CAPA by Training Provider</th>
                                    <th>Document submitted against the NC</th>
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
                                                    $documents = getAllDocumentsForSummaryForOnsite($question->id, $applicationDetails->id, $course);
                                                @endphp
                                                @if (count($documents) > 0)
                                                    @foreach ($documents as $doc)
                                                        @php
                                                            $comment = getDocComment($doc->id);
                                                        @endphp
                                                        @if ($comment)
                                                            @if ($comment->status == 1)
                                                                NC1
                                                            @elseif($comment->status == 2)
                                                                NC2
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <span>Document not uploaded!</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $documents = getSingleDocumentForONSite($question->id, $course, $applicationDetails->id);
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
                                                    $documents = getQuestionDocumentOnsite($question->id, $course, $applicationDetails->id);
                                                @endphp
                                                @if ($documents)
                                                    @foreach ($documents as $item)
                                                        <div>
                                                            <a class="btn btn-primary m-1" href="">View Doc</a>
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
                            <div>
                                <div>
                                    <span style="font-weight: bold;">Brief Summary 1</span>
                                    <div>
                                        {{ $summaryReport->summary1 ?? '' }}
                                    </div>
                                </div>
                                <div>
                                    <hr>
                                </div>
                                <div>
                                    <span style="font-weight: bold;">Brief Summary 2</span>
                                    <div>
                                        {{ $summaryReport->summary2 ?? '' }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    @if ($improvementForm != null)
                        <div class="card">
                            <div class="card-header bg-white text-dark">
                                <h5 class="mt-2">
                                    OPPORTUNITY FOR IMPROVEMENT FORM
                                </h5>
                            </div>
                            <table class="table table-bordered">

                                <tbody>

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
                                        <td> S. No. </td>
                                        <td> Opportunity for improvement Form</td>
                                        <td colspan="2"> Standard reference</td>
                                    </tr>
                                    <tr>
                                        <td> </td>
                                        <td> {{ $improvementForm->opportunity_for_improvement }}</td>
                                        <td> {{ $improvementForm->standard_reference }}</td>
                                    </tr>

                                    <tr>
                                        <td> Signatures</td>
                                        <td> </td>
                                        <td> </td>
                                    </tr>

                                    <tr>
                                        <td>Name </td>
                                        <td>{{ $improvementForm->name }} </td>
                                        <td> </td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td> </td>
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
                    @endif


                @endif
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

        {{-- @if ($applicationDetails->final_remark != null)
            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2">
                        Remark & GPS Picture
                    </h5>
                </div>
                <div class="card-body">
                    <div>
                        {{ $applicationDetails->final_remark }}
                    </div>
                    <div class="mt-2">
                        <span style="font-weight: bold;">GPC Picture</span>
                        <div>
                            <a href="{{ asset('level/' . $applicationDetails->gps_pic) }}" target="_blank">
                                <img style="width:300px;" src="{{ asset('level/' . $applicationDetails->gps_pic) }}"
                                    alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif --}}

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
