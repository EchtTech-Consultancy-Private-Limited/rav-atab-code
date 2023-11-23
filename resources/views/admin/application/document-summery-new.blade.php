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
                @foreach ($applicationDetails->courses as $item)
                <div class="card-body">
                    <table class="table table-bordered">
                      <tr>
                        <td>Application No (provided by ATAB) : {{ $applicationDetails->application_uid }} </td>
                        <td>Date of application : {{ date('d-m-Y', strtotime($applicationDetails->created_at)) }}</td>
                      </tr>
                      <tr>
                        <td>Name and Location of the Training Provider : {{ $applicationDetails->user->firstname }} {{ $applicationDetails->user->lastname }} - {{ @$applicationDetails->user->address }}</td>
                        <td>Name of the course to be assessed : {{ Str::ucfirst($item->course_name) }} </td>
                      </tr>
                      <tr>
                        <td>Way of assessment (Desktop) : 
                            @if($applicationDetails->desktop_status != NULL)
                                Desktop                           
                            @endif</td>
                        <td>No of Mandays : N/A</td>
                      </tr>
                      <tr>
                        <td>Signature</td>
                        <td>N/A</td>
                      </tr>
                      <tr>
                        <td>Name</td>
                        <td>{{ $applicationDetails->Person_Name }}</td>
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
                                {{ $chapter->title ?? '' }}</td>
                        </tr>                
                        @foreach ($chapter->questions as $question)
                        <tr>
                           <td> {{ $question->code }}</td>
                           <td>{{ @$question->title }}</td>
                           <td> 
                            @php
                                $documentsData = getAdminDocument($question->id, $applicationDetails->id) ?? 0;
                            @endphp
                            @if (count($documentsData) > 0)
                                <div class="d-flex justify-content-center">
                                    @if (count($documentsData) <= 1)
                                        @foreach ($documentsData as $doc)
                                            @if ($doc->application_id == $applicationDetails->id)
                                                <div>
                                                    @if(getButtonText($doc->id) != "Accepted")
                                                    <a target="_blank"
                                                        title="{{ checkDocumentCommentStatusreturnText($doc->id) }}"
                                                        href="{{ url('admin-view-doc' . '/' . $doc->doc_id . '/' . $doc->doc_file . '/' . $doc->id . '/' . $item->id) }}"
                                                        class="docBtn text-size-11 text-white {{ checkDocumentCommentStatus($doc->id) }}"
                                                        style="color: #fff ;margin:10px;"
                                                        id="view_doc1">{{ getButtonText($doc->id) ?? '' }}</a>
                                                        @endif
                                                    <div
                                                        style="font-size: 10px; padding-top:3px; padding-bottom:3px;">
                                                        {{ checkFinalRequest($doc->id) }}
                                                    </div>
                                                </div>
                                            @else
                                                <span class="bg-danger p-2 text-white"
                                                    style="border-radius: 5px;  font-size:10px;">
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
                                                    @if(getButtonText($doc->id) != "Accepted")
                                                        <a target="_blank"
                                                        title="{{ checkDocumentCommentStatusreturnText($doc->id) }}"
                                                        href="{{ url('admin-view-doc' . '/' . $doc->doc_id . '/' . $doc->doc_file . '/' . $doc->id . '/' . $item->id) }}"
                                                        class="docBtn text-size-11 text-white {{ checkDocumentCommentStatus($doc->id) }}"
                                                        style="color: #fff ;margin:10px;"
                                                        id="view_doc1">{{ getButtonText($doc->id) ?? '' }}</a>
                                                    @endif
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
                                    style="border-radius: 5px; font-size:7px;">
                                    Documents not uploaded
                                </span>
                            @endif
                        </td>
                           <td>N/A</td>
                           <td>N/A</td>
                           <td>@php
                                $documentsData = getAdminDocument($question->id, $applicationDetails->id) ?? 0;
                            @endphp
                            @if (count($documentsData) > 0)
                                <div class="d-flex justify-content-center">
                                    @if (count($documentsData) <= 1)
                                        @foreach ($documentsData as $doc)
                                            @if ($doc->application_id == $applicationDetails->id)
                                                <div>
                                                    @if(getButtonText($doc->id) == "Accepted")
                                                    <a target="_blank"
                                                        title="{{ checkDocumentCommentStatusreturnText($doc->id) }}"
                                                        href="{{ url('admin-view-doc' . '/' . $doc->doc_id . '/' . $doc->doc_file . '/' . $doc->id . '/' . $item->id) }}"
                                                        class="docBtn text-size-11 text-white {{ checkDocumentCommentStatus($doc->id) }}"
                                                        style="color: #fff ;margin:10px;"
                                                        id="view_doc1">{{ getButtonText($doc->id) ?? '' }}</a>
                                                        @endif
                                                    <div
                                                        style="font-size: 10px; padding-top:3px; padding-bottom:3px;">
                                                        {{ checkFinalRequest($doc->id) }}
                                                    </div>
                                                </div>
                                            @else
                                                <span class="bg-danger p-2 text-white"
                                                    style="border-radius: 5px;  font-size:10px;">
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
                                                    @if(getButtonText($doc->id) == "Accepted")
                                                        <a target="_blank"
                                                        title="{{ checkDocumentCommentStatusreturnText($doc->id) }}"
                                                        href="{{ url('admin-view-doc' . '/' . $doc->doc_id . '/' . $doc->doc_file . '/' . $doc->id . '/' . $item->id) }}"
                                                        class="docBtn text-size-11 text-white {{ checkDocumentCommentStatus($doc->id) }}"
                                                        style="color: #fff ;margin:10px;"
                                                        id="view_doc1">{{ getButtonText($doc->id) ?? '' }}</a>
                                                    @endif
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
                                    style="border-radius: 5px; font-size:7px;">
                                    Documents not uploaded
                                </span>
                            @endif</td>
                        </tr>
                        @endforeach
                        @endforeach
                    </table>
                </div>
                @endforeach
            </div>
        </div>

        <div id="applicationSummaryContainer">
            
            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2">FORM -2 ONSITE ASSESSMENT FORM</h5>
                </div>
                @foreach ($applicationDetails->courses as $item)
                <div class="card-body">
                    <table class="table table-bordered">
                      <tr>
                        <td>Application No (provided by ATAB) : {{ $applicationDetails->application_uid }} </td>
                        <td>Date of application : {{ date('d-m-Y', strtotime($applicationDetails->created_at)) }}</td>
                      </tr>
                      <tr>
                        <td>Name and Location of the Training Provider : {{ $applicationDetails->user->firstname }} {{ $applicationDetails->user->lastname }} - {{ @$applicationDetails->user->address }}</td>
                        <td>Name of the course to be assessed : {{ Str::ucfirst($item->course_name) }} </td>
                      </tr>
                      <tr>
                        <td>Way of assessment (onsite/ hybrid/ virtual) : 
                            @if($applicationDetails->onsite_status != NULL)
                                Onsite                                
                            @endif
                        </td>
                        <td>No of Mandays : N/A</td>
                      </tr>
                      <tr>
                        <td>Signature</td>
                        <td>N/A</td>
                      </tr>
                      <tr>
                        <td>Name</td>
                        <td>{{ $applicationDetails->Person_Name }}</td>
                      </tr>
                      <tr>
                        <td>Assessor</td>
                        <td>N/A</td>
                      </tr>
                    </table>
                    <table class="table table-bordered">
                      <tr>                        
                        <td>Team : N/A</td>
                        <td>Team Leader : N/A</td>
                        <td>Assessor : N/A</td>
                        <td>Rep. Assessee Orgn : N/A</td>
                      </tr>
                      <tr>                        
                        <td colspan="4">Brief about the Opening Meeting: N/A</td>
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
                                {{ $chapter->title ?? '' }}</td>
                        </tr>                
                        @foreach ($chapter->questions as $question)
                        <tr>
                           <td> {{ $question->code }}</td>
                           <td>{{ @$question->title }}</td>
                           <td> 
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
                           <td>N/A</td>
                           <td>N/A</td>
                           <td>
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
                    </table>
                    <table class="table table-bordered">                     
                      <tr>                        
                        <td colspan="2">Brief Summary (4000 words): N/A</td>
                      </tr>
                      <tr>                        
                        <td colspan="2">Brief about the Closing Meeting: N/A</td>
                      </tr>
                      <tr>                        
                        <td>Date : {{ date('d-m-Y', strtotime($applicationDetails->created_at)) }}</td>
                        <td>Signature of the Team Leader : N/A</td>
                      </tr>
                    </table>
                </div>
                @endforeach
            </div>
        </div>

        <div id="applicationSummaryContainer">
            
            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2">FORM -3 - OPPORTUNITY FOR IMPROVEMENT FORM</h5>
                </div>
                @foreach ($applicationDetails->courses as $item)
                <div class="card-body">
                    <table class="table table-bordered">
                      <tr>
                        <td>Application No (provided by ATAB) : {{ $applicationDetails->application_uid }} </td>
                        <td>Date of application : {{ date('d-m-Y', strtotime($applicationDetails->created_at)) }}</td>
                      </tr>
                      <tr>
                        <td>Name and Location of the Training Provider : {{ $applicationDetails->user->firstname }} {{ $applicationDetails->user->lastname }} - {{ @$applicationDetails->user->address }}</td>
                        <td>Name of the course to be assessed : {{ Str::ucfirst($item->course_name) }} </td>
                      </tr>
                      <tr>
                        <td>Way of assessment (onsite/ hybrid/ virtual) : 
                            @if($applicationDetails->onsite_status != NULL)
                                Onsite                                
                            @endif
                        </td>
                        <td>No of Mandays : N/A</td>
                      </tr>                      
                    </table>                                       
                    <table class="table table-bordered">                    
                        <tr>
                            <th>S.No</th>
                            <th>Opportunity for improvement Form</th>
                            <th>Standard reference</th>                            
                        </tr>
                        <tr>
                            <td>1</td>
                           <td>N/A</td>
                           <td>N/A</td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                    <tr>
                        <td colspan="2">Signature</td>
                        <td colspan="2">N/A</td>
                    </tr>
                    <tr>                        
                        <td>Team : N/A</td>
                        <td>Team Leader : N/A</td>
                        <td>Assessor : N/A</td>
                        <td>Rep. Assessee Orgn : N/A</td>
                    </tr> 
                      <tr>
                        <td colspan="4">Brief Summary (4000 words): N/A</td>
                      </tr>
                      <tr>                        
                        <td colspan="4">Brief about the Closing Meeting: N/A</td>
                      </tr>
                      <tr>                        
                        <td colspan="2">Date : {{ date('d-m-Y', strtotime($applicationDetails->created_at)) }}</td>
                        <td colspan="2">Signature of the Team Leader : N/A</td>
                      </tr>
                    </table>
                </div>
                @endforeach
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