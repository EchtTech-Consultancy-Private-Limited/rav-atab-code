@include('layout.header')
<title>RAV Accreditation</title>

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
            <div>
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <form id="submitForm" action="{{url('onsite/final-summary')}}" method="post">
                            @csrf
                             <input type="hidden" name="application_id" value="{{Request()->segment(4)}}">
                            <input type="hidden" name="application_course_id" value="{{Request()->segment(5)}}">
                            <div class="p-3  bg-white">
                                <table>

                                    <tbody>
                                        <tr>
                                            <td colspan="6">ONSITE ASSESSMENT FORM.</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Application No (provided by ATAB): <span> {{$summertReport->uhid}}</span>
                                            </td>
                                            <td colspan="3">Date of Application: <span> {{date('d-m-Y',strtotime($summertReport->app_created_at))}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Name and Location of the Training Provider: <span> {{$summertReport->person_name}}</span>
                                            </td>
                                            <td colspan="3">Name of the course  to be assessed:
                                
                                                 <span> {{$summertReport->course_name}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Way of assessment (onsite/ hybrid/ virtual):</br> <span> {{$assessement_way}}</span>
                                            </td>
                                            <td colspan="2">No of Mandays: <span> {{$no_of_mandays}}</span>
                                            </td>
                                        </tr>
                                
                                        <tr>
                                            <td> Signature:</td>
                                            <td>.................</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Assessor Name</td>
                                            <td> {{$assessor_name}} ({{$assessor_assign->assessor_designation}}) </td>
                                            <td> </td>
                                            <td> </td>
                                        </tr>
                                        <tr>
                                            <td> Team Leader: </td>
                                            <td> {{$assessor_name}} ({{$assessor_assign->assessor_designation}})</td>
                                            <td colspan="2"> Rep. Assessee Orgn:</td>
                                            <td colspan="2"><input type="text" class="remove_err" name="assessee_org" id="assessee_org" placeholder="Please Enter Rep. Assessee Orgn" required maxLength="100">
                                            <span id="assessee_org_err" class="err"></span>
                                        
                                        </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Brief about the Opening Meeting: <input
                                                    type="text" id="brief_open_meeting" class="remove_err" name="brief_open_meeting" placeholder="Brief about the Opening Meeting" required maxLength="2000">
                                                    <span id="brief_open_meeting_err" class="err"></span>
                                                </td>
                                        </tr>
                                
                                        <tr>
                                            <td> Sl. No</td>
                                            <td>Objective Element </td>
                                            <td> NC raised</td>
                                            <td> CAPA by Training Provider</td>
                                            <td> Document submitted against the NC</td>
                                            <td> Remarks (Accepted/ Not accepted)</td>
                                        </tr>
                                        <tbody>
                                            @foreach ($final_data as $key=>$rows)
                                            <tr>
                                                <td>{{$rows->code}}</td>
                                                <td>{{$rows->title}}</td>
                                                <td class="remove_extra_comma">
                                                @foreach($rows->nc as $row)
                                                    @if($row->nc_type!=="Accept" && $row->nc_type!=="Reject" && $row->nc_type!=="not_recommended" && $row->nc_type!=="Request for final approval")
                                                      <span>{{$row->nc_type}}</span><span>,</span>
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td class="remove_extra_comma">

                                                @foreach($rows->nc as $row)
                                                    @if($row->nc_type!=="Accept" && $row->nc_type!=="not_recommended" && $row->nc_type!=="Request for final approval")
                                                    <span>{{$row->tp_remark}}</span><span>,</span></br>
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                @foreach($rows->nc as $key=>$row)
                                                    @if($row->nc_type=="NC1")
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_file_name) }}" class="btn btn-danger m-1" href="">NC1</a>  
                                                    @elseif($row->nc_type=="NC2")
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_file_name) }}" class="btn btn-danger m-1" href="">NC2</a>
                                                    @endif
                                                    @endforeach
                                            
                                            </td>
                                            <td>
                                            @php
                                                    $count = count($rows->nc);
                                                    $admin_count = count($rows->nc_admin);
                                                    @endphp

                                                
                                                        @if(@$rows->nc_admin && (@$rows->nc_admin[0]->nc_type=="Accept" || @$rows->nc_admin[0]->nc_type=="Reject"))
                                                        {{$rows->nc_admin[0]->comments??''}}
                                                    @else
                                                            @if($count==1)
                                                            {{$rows->nc[0]->comments??''}}
                                                            @elseif($count==2)
                                                            {{$rows->nc[1]->comments??''}}
                                                            @elseif($count==3)
                                                            {{$rows->nc[2]->comments??''}}
                                                            @elseif($count==4)
                                                            {{$rows->nc[3]->comments??''}}
                                                            @elseif($count==5)
                                                            {{$rows->nc[4]->comments??''}}
                                                            @elseif($count==6)
                                                            {{$rows->nc[5]->comments??''}}
                                                            @else
                                                            {{$rows->nc[6]->comments??''}}
                                                            @endif
                                                    @endif
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tr>
                                            <td colspan="6">Brief Summary: <input
                                                    type="text" id="brief_summary" class="remove_err" name="brief_summary" placeholder="Please Enter Brief Summary" required maxLength="4000">
                                                    <span id="brief_summary_err" class="err"></span>

                                                </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Brief about the closing meeting: <input
                                                    type="text" id="brief_closing_meeting" name="brief_closing_meeting" placeholder="Please Enter Brief about the closing meeting" class="remove_err" required maxLength="2000
                                                    ">
                                                    <span id="brief_closing_meeting_err" class="err"></span>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Date : <input type="text" id="summary_date" name="summary_date" value="" disabled>
                                            </td>
                                            <td>
                                                Signature : ..........
                                            </td>
                                        </tr>
                                    </tbody>
                                
                                </table>
                                <div class="table-responsive">
                                    <table>

                                        <tbody>
                                            <tr>
                                                <td colspan="4">
                                                    OPPORTUNITY FOR IMPROVEMENT FORM
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Name and Location of the Training Provider: {{$summertReport->person_name}}</td>
                                                <td colspan="2">Name of the course  to be assessed: {{$summertReport->course_name}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"> Way of assessment (onsite/ hybrid/ virtual):</br> {{$assessement_way}}</td>
                                                <td colspan="2"> No of Mandays: {{$no_of_mandays}}</td>
                                            </tr>
                                            <tr>
                                                <td>  S. No. </td>
                                                <td> Opportunity for improvement Form</td>
                                                <td colspan="2"> Standard reference</td>
                                            </tr>
                                            <tr>
                                                <td> <input type="text" name="sr_no" id="sr_no" placeholder="Enter Serial No." class="remove_err" required maxlength="10" minlength="1">
                                                <span id="sr_no_err" class="err"></span>

                                            </td>
                                                <td><input type="text" name="improvement_form" id="improvement_form" placeholder="Enter Opportunity for improvement Form" class="remove_err" maxlength="1000"> 
                                                <span id="improvement_form_err" class="err"></span>

                                            </td>
                                                <td><input type="text" name="standard_reference" id="standard_reference" maxlength="1000" placeholder="Enter Standard Reference" class="remove_err" required> 
                                                <span id="standard_reference_err" class="err"></span>

                                            </td>
                                            </tr>
                                    
                                            <tr>
                                                <td> Signatures</td>
                                                <td>.......... </td>
                                                <td> </td>
                                            </tr>
                                    
                                            <tr>
                                                <td>Assessor Name </td>
                                                
                                                <td>{{$assessor_name}} ({{$assessor_assign->assessor_designation}})</td>
                                                <td> </td>
                                                
                                            </tr>
                                            <tr>
                                                <td>Team Leader </td>
                                                <td>{{$assessor_name}} ({{$assessor_assign->assessor_designation}})</td>
                                                
                                                <td> Rep. Assessee Orgn. <input type="text" name="improve_assessee_org" id="improve_assessee_org" placeholder="Please Enter Rep. Assessee Orgn" class="remove_err" required maxlength="100">
                                                <span id="improve_assessee_org_err" class="err"></span>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"> Date: {{date('d-m-Y',strtotime($summertReport->app_created_at))}}</td>
                                                <td colspan="2"> Signature of the Team Leader</td>
                                    
                                            </tr>
                                        </tbody>
                                    </table>
                                    </br>
                                    <button type="submit" class="btn btn-success float-right" onclick="handleOnsiteSummerySubmitReport()">Submit</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </div>
    </div>
</section>
@include('layout.footer')
