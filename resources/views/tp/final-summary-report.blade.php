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

                    <a href="{{ url('application-list') }}" type="button" class="btn btn-primary"
                        style="float:right;">Back
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
                                FORM -1 DESKTOP ASSESSMENT FORM
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
                                            <td> {{ $question->code }}</td>
                                            <td>{{ $question->title }}</td>
                                            <td>
                                                @php
                                                    $summeryReportQuestion = getQuestionSummary($question->id, $summaries->id);
                                                @endphp
                                                @if ($summeryReportQuestion)
                                                    @if ($summeryReportQuestion != null)
                                                        {{ $summeryReportQuestion->nc_raised }}
                                                    @endif
                                                @else
                                                    @php
                                                        $documents = getAllDocumentsForSummary($question->id, $applicationDetails->id, $summaries->course_id);
                                                    @endphp
                                                    @if (count($documents) > 0)
                                                        @foreach ($documents as $doc)
                                                            @php
                                                                $comment = getDocComment($doc->id);
                                                            @endphp
                                                            @if ($comment)
                                                                <span>{{ printStatus($doc->id) }}</span>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <span>Document not uploaded!</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($summeryReportQuestion)
                                                    @if ($summeryReportQuestion->capa_training_provider != null)
                                                        {{ $summeryReportQuestion->capa_training_provider }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($summeryReportQuestion)
                                                @if ($summeryReportQuestion->document_submitted_against_nc != null)
                                                    {{ $summeryReportQuestion->document_submitted_against_nc }}
                                                @endif
                                            @endif
                                            </td>
                                            <td>
                                                @php
                                                    $documents = getAllDocumentsForSummary($question->id, $applicationDetails->id, $course);
                                                @endphp
                                                @if (count($documents) > 0)
                                                    @foreach ($documents as $doc)
                                                      @if ($loop->iteration == 1)
                                                      @php
                                                      $comment = getDocComment($doc->id);
                                                  @endphp
                                                  @if ($comment)
                                                      <span>{{ printRemark($doc->id) }}</span>
                                                  @endif
                                                      @endif
                                                    @endforeach
                                                @else
                                                    <span>Document not uploaded!</span>
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
                            <h5 class="mt-2"> FORM -1 ONSITE ASSESSMENT FORM</h5>
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
                                    <td>No of Mandays : {{ $summaryReport->mandays ?? '' }}</td>
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
                                                    $summeryReportQuestion = getQuestionSummary($question->id, $summaryReport->id);
                                                @endphp
                                                @if ($summeryReportQuestion)
                                                    @if ($summeryReportQuestion != null)
                                                        {{ $summeryReportQuestion->nc_raised }}
                                                    @endif
                                                @else
                                                    @php
                                                        $documents = getAllDocumentsForSummary($question->id, $applicationDetails->id, $course);
                                                    @endphp
                                                    @if (count($documents) > 0)
                                                        @foreach ($documents as $doc)
                                                            @php
                                                                $comment = getDocComment($doc->id);
                                                            @endphp
                                                            @if ($comment)
                                                                <span>{{ printStatus($doc->id) }}</span>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <span>Document not uploaded!</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($summeryReportQuestion)
                                                    @if ($summeryReportQuestion->capa_training_provider != null)
                                                        {{ $summeryReportQuestion->capa_training_provider }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($summeryReportQuestion)
                                                @if ($summeryReportQuestion->document_submitted_against_nc != null)
                                                    {{ $summeryReportQuestion->document_submitted_against_nc }}
                                                @endif
                                            @endif
                                            </td>
                                            <td>
                                                @php
                                                    $documents = getAllDocumentsForSummary($question->id, $applicationDetails->id, $course);
                                                @endphp
                                                @if (count($documents) > 0)
                                                    @foreach ($documents as $doc)
                                                      @if ($loop->iteration == 1)
                                                      @php
                                                      $comment = getDocComment($doc->id);
                                                  @endphp
                                                  @if ($comment)
                                                      <span>{{ printRemark($doc->id) }}</span>
                                                  @endif
                                                      @endif
                                                    @endforeach
                                                @else
                                                    <span>Document not uploaded!</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </table>
@if ($improvementForm != null)
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
@endif
                            
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </section>




    @include('layout.footer')
