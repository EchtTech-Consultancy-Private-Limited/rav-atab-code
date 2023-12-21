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
        font-weight: 700;
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
                        <form id="submitForm" action="{{url('desktop/final-summary')}}" method="post">
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
                                            <td>Application No (provided by ATAB): <span> <input type="text" disabled value="{{$summertReport->application_uid}}"></span> </td>
                                            <td>Date of application: <span> <input type="text" disabled value="{{$summertReport->app_created_at}}" ></span> </td>
                                        </tr>
                                        <tr>
                                            <td>Name and Location of the Training Provider: <span> <input type="text" disabled value="{{$summertReport->Person_Name}}"></span> </td>
                                            <td>Name of the course to be assessed:
                                
                                                <span> <input type="text" disabled value="{{$summertReport->course_name}}"></span> </td>
                                        </tr>
                                        <tr>
                                            <td>Way of assessment (Desktop): <span> <input type="text" disabled value="{{$summertReport->assessor_type}}"></span> </td>
                                            <td>No of Mandays:  <span> <input type="text" disabled value="{{$no_of_mandays}}"></span> </td>
                                        </tr>
                                
                                        <tr>
                                            <td> Signature</td>
                                            <td>........</td>
                                        </tr>
                                        <tr>
                                            <td> Assessor</td>
                                            <td>{{$summertReport->firstname??''}}  {{$summertReport->lastname??''}}</td>
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
                                                    @if($row->nc_raise_code==1)
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-warning m-1" href="">NC1</a>  
                                                    @elseif($row->nc_raise_code==2)
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-warning m-1" href="">NC2</a>
                                                    @elseif($row->nc_raise_code==4)
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-success m-1" href="">Accepted Doc</a>       
                                                    @elseif($row->nc_raise_code==3)
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-danger m-1" href="">Not Recommended</a>  
                                                    @else
                                                    <a target="_blank" href="{{ asset('level/'.$row->doc_path) }}" class="btn btn-danger m-1" href="">Not Accepted</a>      
                                                    @endif
                                                    @endforeach
                                            
                                            </td>
                                            <td>
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
                                                {{$rows->nc[6]->doc_verify_remark??''}}
                                                @endif
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    
                                    </table>
                                    
                                    @if(!$is_final_submit)
                                    <button type="submit" class="btn btn-success float-right mt-3"
                                   >Submit
                                   @endif
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
@include('layout.footer')
