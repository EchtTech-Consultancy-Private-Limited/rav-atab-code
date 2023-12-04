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
                                    <tr>
                                        <td> {{ $question->code }}</td>
                                        <td>{{ $question->title }}</td>
                                        <td>
                                            @php
                                                $documents = getAllDocumentsForSummary($question->id, $applicationDetails->id, $course);
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
                                                $getNCComments = getNCRecordsComments($question->id, $course, $applicationDetails->id);
                                            @endphp
                                            @if ($getNCComments)
                                                @foreach ($getNCComments as $item)
                                                    <div>
                                                        <div class="bg-danger p-1 m-2">
                                                            {{ $item->comments ?? '' }}
                                                        </div>
                                                        <input type="hidden" name="capa_training_provider[]"
                                                            value="{{ $item->comments ?? '' }}">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $documents = getQuestionDocument($question->id, $course, $applicationDetails->id);
                                            @endphp
                                            @if ($documents)
                                                @foreach ($documents as $item)
                                                    <div>
                                                        <a class="btn btn-primary" href="">View Doc</a>
                                                    </div>
                                                    <input type="hidden" name="document_submitted_against_nc[]"
                                                        value="{{ $item->doc_file }}">
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $documents = getAllDocumentsForSummary($question->id, $applicationDetails->id, $course);
                                            @endphp
                                            @if (count($documents) > 0)
                                                @foreach ($documents as $doc)
                                                    @php
                                                        $comment = getDocComment($doc->id);
                                                    @endphp
                                                    @if ($comment)
                                                        @if ($comment->status == 4)
                                                            Accepted
                                                        @else
                                                            Not Accepted
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
