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
                        <form id="submitForm" action="#" method="post">
                            @csrf
                            <div class="p-3  bg-white">
                                <table>

                                    <tbody>
                                        <tr>
                                            <td colspan="2">FORM -1 DESKTOP ASSESSMENT FORM</td>
                                        </tr>
                                        <tr>
                                            <td>Application No (provided by ATAB): <span> <input type="text" disabled value="{{$summertReport->application_uid}}"></span> </td>
                                            <td>Date of application: <span> <input type="text" ></span> </td>
                                        </tr>
                                        <tr>
                                            <td>Name and Location of the Training Provider: <span> <input type="text" disabled></span> </td>
                                            <td>Name of the course to be assessed:
                                
                                                <span> <input type="text"></span> </td>
                                        </tr>
                                        <tr>
                                            <td>Way of assessment (Desktop): <span> <input type="text"></span> </td>
                                            <td>No of Mandays:  <span> <input type="text"></span> </td>
                                        </tr>
                                
                                        <tr>
                                            <td> Signature</td>
                                            <td> After print</td>
                                        </tr>
                                        <tr>
                                            <td> Assessor</td>
                                            <td> Assessor Name</td>
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
                                            <tr>
                                                <td> <input type="text" placeholder=""></td>
                                                <td> <input type="text" placeholder=""></td>
                                                <td> <input type="text" placeholder=""></td>
                                                <td> <input type="text" placeholder=""></td>
                                                <td> <input type="text" placeholder=""></td>
                                            </tr>
                                        </tbody>
                                    
                                    </table>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success float-right"
                                    onclick="confirmSubmit()">Submit
                            </button>
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
