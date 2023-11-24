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

    table td {
        text-align: left;
        padding: 10px 10px;
    }

    table th, table td, table tr {
    text-align: center;
    border: 1px solid #aaa !important;
    color: #000;
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

                    <a href="{{ url('nationl-accesser') }}" type="button" class="btn btn-primary" style="float:right;">Back
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
                    <h5 class="mt-2"> ONSITE ASSESSMENT FORM</h5>
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
                        <td>Way of assessment (Desktop) : {{ $applicationDetails->course_assessed }}</td>
                        <td>No of Mandays : N/A</td>
                      </tr>
                      <tr>
                        <td>Signature</td>
                        <td>N/A</td>
                      </tr>
                      <tr>
                        <td>Assessor Name</td>
                        <td>{{ $applicationDetails->assessor }}</td>
                      </tr>
                      <tr>
                        <td>Assessor</td>
                        <td>N/A</td>
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
                            <td> {{ $question->id }}</td>
                           <td>{{ $question->title }}</td>
                           <td>{{ $question->summeryQuestionreport->nc_raised ?? '' }}</td>
                           <td>{{ $question->summeryQuestionreport->capa_training_provider ?? '' }}</td>
                           <td>{{ $question->summeryQuestionreport->document_submitted_against_nc ?? '' }}</td>
                           <td>{{ $question->summeryQuestionreport->remark ?? '' }}</td>
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
                                <td colspan="2">Name and Location of the Training Provider: {{ $improvementForm->training_provider_name }}</td>
                                <td colspan="2">Name of the course  to be assessed:   {{ $improvementForm->course_name }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"> Way of assessment (onsite/ hybrid/ virtual):  {{ $improvementForm->way_of_assessment }}</td>
                                <td colspan="2"> No of Mandays:  {{ $improvementForm->mandays }}</td>
                            </tr>
                            <tr>
                                <td>  S. No. </td>
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
