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
                        <form id="submitForm" action="{{url('onsite/final-summary')}}" method="post">
                            @csrf
                             <input type="hidden" name="application_id" value="{{Request()->segment(3)}}">
                            <input type="hidden" name="application_course_id" value="{{Request()->segment(4)}}">
                            <div class="p-3  bg-white">
                                <div class="row">
                                <div class="col-md-12 d-flex p-2 gap-2 flex-row-reverse pe-4">
                                    <button class="btn btn-warning" onclick="printDiv('on-site-print')">
                                    <i class="fa fa-print"></i>
                                    </button>
                                </div>
                                </div>
                                <section id="on-site-print">
                                <table >

                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="fw-bold">ONSITE ASSESSMENT FORM.</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="fw-bold">Application No (provided by ATAB):</br> <span class="fw-normal"> {{$summertReport->id}}</span>
                                            </td>
                                            <td colspan="3" class="fw-bold">Date of Application: </br><span class="fw-normal"> {{date('d-m-Y',strtotime($summertReport->app_created_at))}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="fw-bold">Name and Location of the Training Provider: </br><span class="fw-normal"> {{$summertReport->person_name}}</span>
                                            </td>
                                            <td colspan="3" class="fw-bold">Name of the course  to be assessed:
                                            </br>
                                                 <span class="fw-normal"> {{$summertReport->course_name}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="fw-bold">Way of assessment (onsite/ hybrid/ virtual):</br> <span class="fw-normal"> {{$assessement_way??'N/A'}}</span>
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
                                            <td colspan="2">{{$summertReport->assessee_org}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="fw-bold">Brief about the Opening Meeting: <span class="fw-normal">{{$summertReport->brief_open_meeting}}</span></td>
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
                                                <td class="fw-bold remove_extra_comma">
                                                @foreach($rows->nc as $row)
                                                      <span>{{$row->nc_type}}</span><span>,</span>
                                                    @endforeach
                                                </td>
                                                <td>

                                                @foreach($rows->nc as $key=>$row)
                                                    @if($row->tp_remark!=null)
                                                        {{$key+1}} : {{ucfirst($row->tp_remark)}},
                                                    @else
                                                    N/A
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                @foreach($rows->nc as $key=>$row)
                                                        <?php 
                                                                $color_code = ["NC1"=>"danger", "NC2"=>"danger", "Accept"=>"success","not_recommended"=>"danger"];
                                                                if (array_key_exists($row->nc_type, $color_code)) {
                                                                    $final_color_value = $color_code[$row->nc_type];
                                                                } else {
                                                                    $final_color_value = "danger";
                                                                }
                                                        ?>
                                                        <a target="_blank" href="{{ asset('level/'.$row->doc_file_name) }}" class="btn btn-{{$final_color_value}} m-1" href="">
                                                            @if($row->nc_type=="not_recommended")
                                                            {{ucfirst($row->nc_type)}}
                                                            @else
                                                            {{$row->nc_type}}
                                                            @endif
                                                        
                                                    </a>  
                                                        @endforeach
                                            
                                            </td>
                                            <td>
                                                
                                                @php
                                                $count = count($rows->nc);
                                                @endphp
                                             
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
                                           
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tr>
                                            <td colspan="6" class="fw-bold">Brief Summary: <span class="fw-normal">{{$summertReport->brief_summary}}</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="fw-bold">Brief about the closing meeting: <span class="fw-bold">{{$summertReport->brief_closing_meeting}}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">
                                                Date : <span class="fw-normal">{{date('d-m-Y',strtotime($summertReport->summary_date))}}</span>
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
                                                <td colspan="2" class="fw-bold">Name and Location of the Training Provider: <span class="fw-normal">{{$summertReport->person_name}}</span></td>
                                                <td colspan="2" class="fw-bold">Name of the course  to be assessed: <span class="fw-normal">{{$summertReport->course_name}}</span></td>
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
                                                <td>{{$summertReport->sr_no}}</td>
                                                <td>{{$summertReport->improvement_form}}</td>
                                                <td>{{$summertReport->standard_reference}}</td>
                                            </tr>
                                    
                                            <tr>
                                                <td class="fw-bold"> Signatures</td>
                                                <td class="fw-bold">.......... </td>
                                                <td> </td>
                                            </tr>
                                    
                                            <tr>
                                                <td class="fw-bold">Assessor Name </td>
                                                
                                                <td>{{$assessor_name??''}} </td>
                                                <td> </td>
                                                
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Team Leader </td>
                                                <td>{{$assessor_name??''}}</td>
                                                
                                                <td class="fw-bold"> Rep. Assessee Orgn : <span class="fw-normal">{{$summertReport->onsite_assessee_org}}</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="fw-bold"> Date: {{date('d-m-Y',strtotime($summertReport->app_created_at))}}</td>
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
<script>
    function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
</script>
@include('layout.footer')
