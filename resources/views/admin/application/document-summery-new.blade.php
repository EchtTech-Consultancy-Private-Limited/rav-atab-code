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
                        <td>Application No (provided by ATAB) : {{ $applicationDetails->application_uid }} </td>
                        <td>Date of application : {{ $applicationDetails->date_of_application }}</td>
                      </tr>
                      <tr>
                        <td>Name and Location of the Training Provider : {{ $applicationDetails->location_training_provider }}</td>
                        <td>Name of the course to be assessed : {{ $applicationDetails->course_assessed }} </td>
                      </tr>
                      <tr>
                      <td>Way of assessment (Desktop) : {{ $applicationDetails->way_of_desktop }}</td>
                        <td>No of Mandays : {{ getMandays($applicationDetails->id, auth()->user()->id) }}</td>
                      </tr>
                      <tr>
                        <td>Signature</td>
                        <td>N/A</td>
                      </tr>
                      <tr>
                        <td>Assessor Name</td>
                        <td>{{ $applicationDetails->assessor }}</td>
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
                            $documentsData = getSummerDocument($question->id, $applicationDetails->application_id) ?? 0;
                            $docId = $documentsData ? $documentsData->id : null;
                        @endphp
                        <tr>
                            <td> {{ $question->id }}</td>
                           <td>{{ $question->title }}</td>
                           <td>{{ $question->summeryQuestionreport->nc_raised ?? '' }}</td>
                           <td>{{ $question->summeryQuestionreport->capa_training_provider ?? '' }}</td>
                           <td>{{ $question->summeryQuestionreport->document_submitted_against_nc ?? '' }}</td>
                           @if(getButtonText($docId) == "Accepted")
                           <td>{{ $question->summeryQuestionreport->remark ??  getButtonText($docId) ?? '' }}</td>
                           @else
                           <td>{{ $question->summeryQuestionreport->remark ?? '' }}</td>
                           @endif
                        </tr>                       
                        @endforeach
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    </section>




@include('layout.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
function printDiv(divId) {
     var printContents = document.getElementById(divId).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
</script>