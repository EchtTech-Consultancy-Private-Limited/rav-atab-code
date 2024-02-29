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
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3">
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
                    <a type="button" class="btn btn-dark float-right me-2" onclick="printDiv('printableArea')"><i class="fas fa-print"></i> Print
                    </a>

                </div>
            </div>
        </div>
        <div id="printableArea">
            <div id="applicationSummaryContainer">
                <div class="card">
                    <div class="card-header bg-white text-dark">
                        <h5 class="mt-2">FORM -1 DESKTOP ASSESSMENT FORM</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>Application No (provided by ATAB) : {{ $summaryReport->application_uid }} </td>
                                <td>Date of application : {{ $summaryReport->date_of_application }}</td>
                            </tr>
                            <tr>
                                <td>Name and Location of the Training Provider :
                                    {{ $summaryReport->location_training_provider }}</td>
                                <td>Name of the course to be assessed : {{ $summaryReport->course_assessed }} </td>
                            </tr>
                            <tr>
                                <td>Way of assessment (Desktop) : {{ $summaryReport->way_of_desktop }}</td>
                                <td>No of Mandays : {{ $summaryReport->mandays }}</td>
                            </tr>
                            <tr>
                                <td>Signature</td>
                                <td>......</td>
                            </tr>
                            <tr>
                                <td>Assessor Name</td>
                                <td>{{ $summaryReport->assessor }}</td>
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
                                    @php
                                        $comment = getDocumentComment($question->id, $applicationDetails->id, $course);

                                    @endphp
                                    @if ($comment)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="question_ids[]"
                                                       value="{{ $question->id }}" readonly>
                                                {{ $question->code }}
                                            </td>
                                            <td>
                                                {{ $question->title }}
                                            </td>
                                            <td>
                                                @php
                                                    $getNCRecords = getNCRecords($question->id, $course, $applicationDetails->id);
                                                @endphp
                                                <input type="text" name="nc_raised[]"
                                                       value=" {{ $getNCRecords }}" readonly>
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
                                                            <a target="_blank" href="{{ asset('level/'.$item->doc_file) }}" class="btn btn-primary m-1" href="">View Doc</a>
                                                        </div>
                                                        <input type="hidden"
                                                               name="document_submitted_against_nc[]"
                                                               value="{{ $item->doc_file }}">
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $documents = getAllDocumentsForSummary($question->id,$applicationDetails->id,$course);
                                                    $lastDocument = $documents[count($documents) - 1];
                                                $comment = getLastComment($lastDocument->id);

                                                @endphp

                                                @if($comment)
                                                    {{ $comment->comments }}
                                                    <input type="hidden" name="remark[]" value="{{ $comment->comments }}">
                                                @endif


                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
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
