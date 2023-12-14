@include('layout.header')
<title>RAV Accreditation</title>
<style>
    table th {
        text-align: center;
        border: 1px solid #eee;
        color: #000;
    }

    table td {
        text-align: left;
        border: 1px solid #eee;
        color: #000;
    }

    .highlight {
        background-color: #9789894a;
    }

    .highlight_nc {
        background-color: #ff000042;
    }

    .highlight_nc_approved {
        background-color: #00800040;
    }

    td select.form-control.text-center {
        border: 0;
    }

    .loading-img {
        z-index: 99999999;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);;
        overflow: hidden;
        text-align: center;
    }

    .loading-img .box {
        position: absolute;
        top: 50%;
        left: 50%;
        margin: auto;
        transform: translate(-50%, -50%);
        z-index: 2;
    }

    .uploading-text {
        padding-top: 10px;
        color: #fff;
        /* font-size: 18px; */
    }

    td.text-justify {
        text-align: left;
    }

    .btnDiv a {
        margin-right: 10px !important;
    }


    .file-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .file-label {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #3498db;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 12px;
    }

    .file-label:hover {
        background-color: #2980b9;
    }

    .file-input {
        display: none;
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
        text-align: left;
        padding: 10px 10px;
        /* font-weight: 700; */
    }
</style>

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
                        <form id="submitForm" action="#" method="#">
                            @csrf
                            <input type="hidden" name="application_id" value="{{Request()->segment(3)}}">
                            <input type="hidden" name="application_course_id" value="{{Request()->segment(4)}}">
                            <div class="p-3  bg-white">
                                <table>

                                    <tbody>
                                        <tr>
                                            <td colspan="2">DESKTOP ASSESSMENT FORM</td>
                                        </tr>
                                        <tr>
                                            <td>Application No (provided by ATAB): <span> <input type="text" disabled value="{{$summeryReport->application_uid}}"></span> </td>
                                            <td>Date of application: </br><span class="fw-normal">{{date('d-m-Y',strtotime($summeryReport->app_created_at))}}</span> </td>
                                        </tr>
                                        <tr>
                                            <td>Name and Location of the Training Provider: <span> <input type="text" disabled value="{{$summeryReport->Person_Name}}"></span> </td>
                                            <td>Name of the course to be assessed:
                                
                                                <span> <input type="text" disabled value="{{$summeryReport->course_name}}"></span> </td>
                                        </tr>
                                        <tr>
                                            <td>Way of assessment (Desktop): <span> <input type="text" disabled value="{{$assessement_way}}"></span> </td>
                                            <td>No of Mandays:  <span> <input type="text" disabled value="{{$no_of_mandays}}"></span> </td>
                                        </tr>
                                
                                        <tr>
                                            <td> Signature</td>
                                            <td>........</td>
                                        </tr>
                                        <tr>
                                            <td> Assessor</td>
                                            <td>{{$summeryReport->firstname??''}}  {{$summeryReport->middlename??''}} {{$summeryReport->lastname??''}}</td>
                                        </tr>
                                    </tbody>
                                
                                </table>
                                <div class="table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Sl. No </th>
                                                <th>Objective Element</th>
                                                <th> NC raised</th>
                                                <th> CAPA by Training Provider</th>
                                                <th> Document submitted against the NC</th>
                                                <th> Remarks (Accepted/ Not accepted)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($final_data as $key=>$rows)
                                            <tr>
                                                <td>{{$rows->code}}</td>
                                                <td>{{$rows->title}}</td>
                                                <td>
                                                    @foreach($rows->nc as $row)
                                                    @if($row->nc_raise_code!=4 && $row->nc_raise_code!=3)
                                                      {{$row->nc_raise}}
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td>

                                                @foreach($rows->nc as $row)
                                                    @if($row->nc_raise_code!=4 && $row->nc_raise_code!=3)
                                                      {{$row->capa_mark}}
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                @foreach($rows->nc as $key=>$row)
                                                    @if($row->nc_raise_code==4)
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-success m-1" href="">Accepted Doc</a>       
                                                    @elseif($row->nc_raise_code==3)
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-danger m-1" href="">Not Recommended</a>  
                                                    @else
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-primary m-1" href="">NC{{$key+1}} Doc</a>      
                                                    @endif
                                                    @endforeach
                                            
                                            </td>
                                            <td>
                                                @php
                                                $count = count($rows->nc);
                                                @endphp
                                             
                                                @if($count==1)
                                                    {{$rows->nc[0]->doc_verify_remark??''}}
                                                @elseif($count==2)
                                                {{$rows->nc[1]->doc_verify_remark??''}}
                                                @elseif($count==3)
                                                {{$rows->nc[2]->doc_verify_remark??''}}
                                                @elseif($count==4)
                                                {{$rows->nc[3]->doc_verify_remark??''}}
                                                @elseif($count==5)
                                                {{$rows->nc[4]->doc_verify_remark??''}}
                                                @elseif($count==6)
                                                {{$rows->nc[5]->doc_verify_remark??''}}
                                                @else
                                                {{$rows->nc[6]->doc_verify_remark??''}}
                                                @endif
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    
                                    </table>
                                
                            </button>
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


<!-- Onsite Assessor Final summary Report -->
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item active">On-Site Final Summary Reports</li>
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
                        <form id="submitForm" action="#" method="#">
                            @csrf
                            <div class="p-3  bg-white">
                                <!-- <div class="row">
                                    <div class="col-md-12 d-flex p-2 gap-2 flex-row-reverse">
                                        <button class="btn btn-primary" onclick="printDiv('on-site-print')">Print</button>
                                    </div>
                                </div> -->
                                <section id="on-site-print">
                                <table >

                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="fw-bold">ONSITE ASSESSMENT FORM.</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="fw-bold">Application No (provided by ATAB):</br> <span class="fw-normal"> {{$onsiteSummaryReport->application_uid}}</span>
                                            </td>
                                            <td colspan="3" class="fw-bold">Date of Application: </br><span class="fw-normal"> {{date('d-m-Y',strtotime($onsiteSummaryReport->app_created_at))}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="fw-bold">Name and Location of the Training Provider: </br><span class="fw-normal"> {{$onsiteSummaryReport->Person_Name}}</span>
                                            </td>
                                            <td colspan="3" class="fw-bold">Name of the course  to be assessed:
                                            </br>
                                                 <span class="fw-normal"> {{$onsiteSummaryReport->course_name}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="fw-bold">Way of assessment (onsite/ hybrid/ virtual):</br> <span class="fw-normal"> {{$assessement_way??''}}</span>
                                            </td>
                                            <td colspan="2" class="fw-bold">No of Mandays: </br><span class="fw-normal"> {{$no_of_mandays}}</span>
                                            </td>
                                        </tr>
                                
                                        <tr>
                                            <td class="fw-bold"> Signature:</td>
                                            <td>.................</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Assessor Name</td>
                                            <td> {{$assessor_name??''}} </td>
                                            <td> </td>
                                            <td> </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"> Team Leader: </td>
                                            <td> {{$assessor_name??''}}</td>
                                            <td colspan="2" class="fw-bold"> Rep. Assessee Orgn:</td>
                                            <td colspan="2">{{$onsiteSummaryReport->assessee_org}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="fw-bold">Brief about the Opening Meeting: <span class="fw-normal">{{$onsiteSummaryReport->brief_open_meeting}}</span></td>
                                        </tr>
                                
                                        <tr>
                                            <td class="fw-bold"> Sl. No</td>
                                            <td class="fw-bold">Objective Element </td>
                                            <td class="fw-bold"> NC raised</td>
                                            <td class="fw-bold"> CAPA by Training Provider</td>
                                            <td class="fw-bold"> Document submitted against the NC</td>
                                            <td class="fw-bold"> Remarks (Accepted/ Not accepted)</td>
                                        </tr>
                                        <tbody>
                                            @foreach ($final_data as $key=>$rows)
                                            <tr>
                                                <td class="fw-bold">{{$rows->code}}</td>
                                                <td>{{$rows->title}}</td>
                                                <td class="fw-bold">
                                                    @foreach($rows->nc as $row)
                                                    @if($row->nc_raise_code!=4 && $row->nc_raise_code!=3)
                                                      {{$row->nc_raise}}
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td>

                                                @foreach($rows->nc as $row)
                                                    @if($row->nc_raise_code!=4 && $row->nc_raise_code!=3)
                                                      {{$row->capa_mark}}
                                                      @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                @foreach($rows->nc as $key=>$row)
                                                    @if($row->nc_raise_code==4)
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-success m-1" href="">Accepted Doc</a>       
                                                    @elseif($row->nc_raise_code==3)
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-danger m-1" href="">Not Recommended</a>  
                                                    @else
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-primary m-1" href="">NC{{$key+1}} Doc</a>      
                                                    @endif
                                                    @endforeach
                                            
                                            </td>
                                            <td>
                                                {{-- 
                                                @php
                                                $count = count($rows->nc);
                                                @endphp
                                             
                                                @if($count==1)
                                                    {{$rows->nc[0]->doc_verify_remark}}
                                                @elseif($count==2)
                                                {{$rows->nc[1]->doc_verify_remark}}
                                                @elseif($count==3)
                                                {{$rows->nc[2]->doc_verify_remark}}
                                                @elseif($count==4)
                                                {{$rows->nc[3]->doc_verify_remark}}
                                                @elseif($count==5)
                                                {{$rows->nc[4]->doc_verify_remark}}
                                                @elseif($count==6)
                                                {{$rows->nc[5]->doc_verify_remark}}
                                                @else
                                                {{$rows->nc[6]->doc_verify_remark}}
                                                @endif
                                                --}}
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tr>
                                            <td colspan="6" class="fw-bold">Brief Summary: <span class="fw-normal">{{$onsiteSummaryReport->brief_summary}}</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="fw-bold">Brief about the closing meeting: <span class="fw-bold">{{$onsiteSummaryReport->brief_closing_meeting}}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">
                                                Date : <span class="fw-normal">{{date('d-m-Y',strtotime($onsiteSummaryReport->summary_date))}}</span>
                                            </td>
                                            <td class="fw-bold">
                                                Signature : ..........
                                            </td>
                                        </tr>
                                    </tbody>
                                
                                </table>
                                <div class="table-responsive">
                                    <table>

                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="fw-bold">
                                                    OPPORTUNITY FOR IMPROVEMENT FORM
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="fw-bold">Name and Location of the Training Provider: <span class="fw-normal">{{$onsiteSummaryReport->Person_Name}}</span></td>
                                                <td colspan="2" class="fw-bold">Name of the course  to be assessed: <span class="fw-normal">{{$onsiteSummaryReport->course_name}}</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="fw-bold"> Way of assessment (onsite/ hybrid/ virtual):</br> <span class="fw-normal">{{$assessement_way??'N/A'}}</span></td>
                                                <td colspan="2" class="fw-bold"> No of Mandays: <span class="fw-normal">{{$no_of_mandays}}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">S.No.</td>
                                                <td class="fw-bold"> Opportunity for improvement Form</td>
                                                <td class="fw-bold" colspan="2"> Standard reference</td>
                                            </tr>
                                            <tr>
                                                <td>{{$onsiteSummaryReport->sr_no}}</td>
                                                <td>{{$onsiteSummaryReport->improvement_form}}</td>
                                                <td>{{$onsiteSummaryReport->standard_reference}}</td>
                                            </tr>
                                    
                                            <tr>
                                                <td class="fw-bold"> Signatures</td>
                                                <td class="fw-bold">.......... </td>
                                                <td> </td>
                                            </tr>
                                    
                                            <tr>
                                                <td class="fw-bold">Assessor Name </td>
                                                
                                                <td>{{$onsiteSummaryReport->firstname.' '.$onsiteSummaryReport->middlename.' '. $onsiteSummaryReport->lastname ??''}} </td>
                                                <td> </td>
                                                
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Team Leader </td>
                                                <td >{{$onsiteSummaryReport->firstname.' '.$onsiteSummaryReport->middlename.' '. $onsiteSummaryReport->lastname ??''}} </td>
                                                <td class="fw-bold"> Rep. Assessee Orgn : <span class="fw-normal">{{$onsiteSummaryReport->onsite_assessee_org}}</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="fw-bold"> Date: {{date('d-m-Y',strtotime($onsiteSummaryReport->app_created_at))}}</td>
                                                <td colspan="2" class="fw-bold"> Signature of the Team Leader</td>
                                    
                                            </tr>
                                        </tbody>
                                    </table>
                                    </br>
                                </div>
                            </section>
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
<!-- End here -->
@include('layout.footer')
