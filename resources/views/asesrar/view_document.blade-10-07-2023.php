@include('layout.header')


   
<title>RAV Accreditation</title>

<style>
table th, table td {
    text-align:center;
    border: 1px solid #eee;
}

.highlight
{
    background-color: #9789894a;
}

.highlight_nc
{
    background-color: #ff000042;
}

.highlight_nc_approved
{
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
    background:rgba(0,0,0,0.5);;
    overflow: hidden;
    text-align: center; 
}
.loading-img .box {
    position: absolute;
    top: 50%;
    left: 50%;
    margin: auto;
    transform: translate(-50% , -50%);
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


</style>

</head>

<body class="light">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->

    
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
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
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
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <ul class="breadcrumb breadcrumb-style ">
                             <a href="{{ url()->previous() }}" type="button" class="btn btn-primary" style="float:right;">Back To Documents</a>
                        </ul>
                    </div>
                </div>
            </div>

            @if (Session::has('sussess'))
                <div class="alert alert-success" role="alert">
                    {{ session::get('success') }}
                </div>
            @elseif(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('fail') }}
                </div>
            @endif

            <div class="row ">

                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" aria-expanded="true">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget">
                                            <!-- <div class="header">
                                                <h2>Upload Document</h2>

                                                <form method="post" action="{{ url('upload-document') }}"
                                                    id="regForm" enctype="multipart/form-data">

                                                    @csrf
                                                    <div class="body">
                                                        <div class="row clearfix">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label>document type<span
                                                                                class="text-danger">*</span></label>
                                                                        <select name="document_type_id" required
                                                                            class="form-control" id="title">
                                                                            <option value="">Select Type </option>
                                                                            <option value="Infrastructure Details">
                                                                                Infrastructure Details</option>
                                                                            <option
                                                                                value="Re-evaluation of unsuccessful candidates">
                                                                                Re-evaluation of unsuccessful candidates
                                                                            </option>
                                                                            <option
                                                                                value="Details of Manpower along with Qualification and Experience">
                                                                                Details of Manpower along with
                                                                                Qualification and Experience</option>
                                                                            <option
                                                                                value="Details of outsourced facilities">
                                                                                Details of outsourced facilities
                                                                            </option>
                                                                            <option value="Lists of courses applid for">
                                                                                Lists of courses applid for</option>
                                                                            <option value="Detailed syllabus">Detailed
                                                                                syllabus</option>
                                                                            <option value="Exam pattern">Exam pattern
                                                                            </option>
                                                                            <option value="Policy and procedures">Policy
                                                                                and procedures</option>
                                                                        </select>
                                                                    </div>

                                                                    <label for="title" id="title-error"
                                                                        class="error"></label>

                                                                </div>
                                                            </div>


                                                            <input type="hidden" name="application_id" value="{{ $data[0]->application_id }}">
                                                            <input type="hidden" name="level_id" value="{{ $data[0]->level_id }}">



                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label class="active">Upload pdf<span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="file" required
                                                                            class="special_no valid form-control"
                                                                            name="file">
                                                                    </div>


                                                                    <label for="lastname" id="lastname-error"
                                                                        class="error" style="display: none;">
                                                                    </label>

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12 p-t-20 text-center">
                                                                <button type="submit"
                                                                    class="btn btn-primary waves-effect m-r-10">Submit</button>
                                                                <a href="http://localhost/Accreditation/rav-accr/public/dashboard"
                                                                    class="btn btn-danger waves-effect">Back</a>

                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                            
                                            <hr> -->


                                          <div class="header">
                                             <h2 class="text-center">CHAPTER 1- (VMO) VISION MISSION AND OBJECTIVES </h2>
                                          </div>
                                            @if ($message = Session::get('success'))
                                                <div class="alert alert-success">
                                                   <p>{{ $message }}</p>
                                                </div>
                                              @endif
                                              <div id="success-msg" class="alert alert-success d-none" role="alert">
                                                <p class=" msg-none ">Documents Update Successfully</p>
                                              </div>
                                          <!-- table-striped  -->
                                            <div class="table-responsive mt-3">
                                            
                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">#S.N0</th>
                                                            <th class="center">Objective criteria</th>
                                                           <!--  <th class="center" style="white-space: nowrap;width:85px;">Yes / No</th> -->
                                                            <th class="center">View Documents</th>
                                                            <th>Comments</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">

<!-- 
                                                        @foreach ($file as $k=> $files )
                                                            <tr class="odd gradeX">
                                                                <td class="center">{{  $k+1 }}</td>
                                                                 <td class="center">{{  $files->document_type_name }}</td>

                                                               <td> <img src="{{ asset('documnet/'.$files->document_file) }}" width="150" height="120" /> </td>


                                                                @endforeach -->

                                                                <tr class="@if(isset($doc_id1->doc_file)) highlight   @if(get_doc_code($doc_id1->id)==__('arrayfile.document_doc_id_chap1')[1] && get_doccomment_status($doc_id1->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id1->id)==__('arrayfile.document_doc_id_chap1')[1] && get_doccomment_status($doc_id1->id)==0) highlight_nc @endif @endif">
                                                                    <td>VMO.1</td>
                                                                   <td class="text-justify">The institution shall have a clearly defined and documented mission and vision. </td>
                                                                   @if(isset($doc_id1->doc_file))
                                                                    <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap1')[1].'/'.$doc_id1->doc_file.'/'.$doc_id1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                    <td>
                                                                          <!-- <a href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap1')[1].'/'.$doc_id1->doc_file.'/'.$doc_id1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc">View Documents</a> -->

                                                                        

                                                                        <a href="{{ url('show-comment/'.$doc_id1->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                    
                                                                    <!-- <td>
                                                                        @if(isset($doc_id1->doc_file))
                                                                     
                                                                        
                                                                        <a target="_blank" href="{{ url('show-pdf'.'/'.$doc_id1->doc_file) }}" title="Fee Structure PDF">{{$doc_id1->doc_file}}</a>

                                                                         
                                                                        @endif
                                                                    </td> -->

                                                                    
                                                                </tr>

                                                                <tr class="@if(isset($doc_id2->doc_file)) highlight  @if(get_doc_code($doc_id2->id)==__('arrayfile.document_doc_id_chap1')[2] && get_doccomment_status($doc_id2->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id2->id)==__('arrayfile.document_doc_id_chap1')[2] && get_doccomment_status($doc_id2->id)==0) highlight_nc @endif @endif">
                                                                    <td>VMO.2</td>
                                                                    <td class="text-justify">The institution shall have defined objectives and measure them periodically</td>
                                                                     @if(isset($doc_id2->doc_file))
                                                                    <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap1')[2].'/'.$doc_id2->doc_file.'/'.$doc_id2->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id2->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif

                                                                    
                                                                </tr>

                                                                <tr class="@if(isset($doc_id3->doc_file)) highlight   @if(get_doc_code($doc_id3->id)==__('arrayfile.document_doc_id_chap1')[3] && get_doccomment_status($doc_id3->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id3->id)==__('arrayfile.document_doc_id_chap1')[3] && get_doccomment_status($doc_id3->id)==0) highlight_nc @endif @endif">
                                                                    <td>VMO.3</td>
                                                                    <td class="text-justify">The institution shall have mentioned activities that are taken to achieve these objectives. </td>
                                                                     @if(isset($doc_id3->doc_file))
                                                                    <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap1')[3].'/'.$doc_id3->doc_file.'/'.$doc_id3->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id3->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                </tr>                                                              
                                                                <tr class="@if(isset($doc_id4->doc_file)) highlight   @if(get_doc_code($doc_id4->id)==__('arrayfile.document_doc_id_chap1')[4] && get_doccomment_status($doc_id4->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id4->id)==__('arrayfile.document_doc_id_chap1')[4] && get_doccomment_status($doc_id4->id)==0) highlight_nc @endif @endif">
                                                                    <td>VMO.4</td>
                                                                    <td class="text-justify">The institution shall define its quality policy. </td>
                                                                    @if(isset($doc_id4->doc_file))
                                                                    <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap1')[4].'/'.$doc_id4->doc_file.'/'.$doc_id4->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id4->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                </tr>

                                                                <tr class="@if(isset($doc_id5->doc_file)) highlight   @if(get_doc_code($doc_id5->id)==__('arrayfile.document_doc_id_chap1')[5] && get_doccomment_status($doc_id5->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id5->id)==__('arrayfile.document_doc_id_chap1')[5] && get_doccomment_status($doc_id5->id)==0) highlight_nc @endif @endif">
                                                                    <td>VMO.5</td>
                                                                    <td class="text-justify">The institution shall have a policy for evaluation of human resources engaged in training. </td>
                                                                     @if(isset($doc_id5->doc_file))
                                                                    <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap1')[5].'/'.$doc_id5->doc_file.'/'.$doc_id5->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id5->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                </tr>

                                                                <tr class="@if(isset($doc_id6->doc_file)) highlight   @if(get_doc_code($doc_id6->id)==__('arrayfile.document_doc_id_chap1')[6] && get_doccomment_status($doc_id6->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id6->id)==__('arrayfile.document_doc_id_chap1')[6] && get_doccomment_status($doc_id6->id)==0) highlight_nc @endif @endif">
                                                                    <td>VMO.6</td>
                                                                    <td class="text-justify">The institution shall have policy for evaluation of the students </td>
                                                                     @if(isset($doc_id6->doc_file))
                                                                   <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap1')[6].'/'.$doc_id6->doc_file.'/'.$doc_id6->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id6->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                </tr>


                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 2(OGA) ORGANIZATION, GOVERNANCE AND ADMINISTRATION </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr class="@if(isset($doc_id_chap2_1->doc_file)) highlight   @if(get_doc_code($doc_id_chap2_1->id)==__('arrayfile.document_doc_id_chap2')[1] && get_doccomment_status($doc_id_chap2_1->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap2_1->id)==__('arrayfile.document_doc_id_chap2')[1] && get_doccomment_status($doc_id_chap2_1->id)==0) highlight_nc @endif @endif">
                                                                    <td>OGA.1</td>
                                                                    <td class="text-justify">
                                                                      The institution shall declare its ownership and legal status and details of ownership.
                                                                    </td>
                                                                    @if(isset($doc_id_chap2_1->doc_file))
                                                                    <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap2')[1].'/'.$doc_id_chap2_1->doc_file.'/'.$doc_id_chap2_1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap2_1->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                           
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap2_2->doc_file)) highlight   @if(get_doc_code($doc_id_chap2_2->id)==__('arrayfile.document_doc_id_chap2')[2] && get_doccomment_status($doc_id_chap2_2->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap2_2->id)==__('arrayfile.document_doc_id_chap2')[2] && get_doccomment_status($doc_id_chap2_2->id)==0) highlight_nc @endif @endif">
                                                                    <td>OGA.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define its organizational structure or organogram
                                                                    </td>
                                                                    @if(isset($doc_id_chap2_2->doc_file))
                                                                     <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap2')[2].'/'.$doc_id_chap2_2->doc_file.'/'.$doc_id_chap2_2->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap2_2->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap2_3->doc_file)) highlight   @if(get_doc_code($doc_id_chap2_3->id)==__('arrayfile.document_doc_id_chap2')[3] && get_doccomment_status($doc_id_chap2_3->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap2_3->id)==__('arrayfile.document_doc_id_chap2')[3] && get_doccomment_status($doc_id_chap2_3->id)==0) highlight_nc @endif @endif">
                                                                    <td>OGA.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the roles and responsibilities of all personnel.
                                                                    </td>
                                                                   @if(isset($doc_id_chap2_3->doc_file))
                                                                    <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap2')[3].'/'.$doc_id_chap2_3->doc_file.'/'.$doc_id_chap2_3->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap2_3->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap2_4->doc_file)) highlight   @if(get_doc_code($doc_id_chap2_4->id)==__('arrayfile.document_doc_id_chap2')[4] && get_doccomment_status($doc_id_chap2_4->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap2_4->id)==__('arrayfile.document_doc_id_chap2')[4] && get_doccomment_status($doc_id_chap2_4->id)==0) highlight_nc @endif @endif">
                                                                    <td>OGA.4</td>
                                                                    <td class="text-justify">
                                                                      The institution shall define rules applicable to all personnel.
                                                                    </td>
                                                                    @if(isset($doc_id_chap2_4->doc_file))
                                                                    <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap2')[4].'/'.$doc_id_chap2_4->doc_file.'/'.$doc_id_chap2_4->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap2_4->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap2_5->doc_file)) highlight   @if(get_doc_code($doc_id_chap2_5->id)==__('arrayfile.document_doc_id_chap2')[5] && get_doccomment_status($doc_id_chap2_5->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap2_5->id)==__('arrayfile.document_doc_id_chap2')[5] && get_doccomment_status($doc_id_chap2_5->id)==0) highlight_nc @endif @endif">
                                                                    <td>OGA.5</td>
                                                                 
                                                                    <td class="text-justify">
                                                                    The institution shall have a policy and procedure for outsourcing, if any. The policy shall ensure that the
                                                                    outsourced entity complies with applicable parts of the standards and part of the assessment. 
                                                                    The accredited training providers must witness the delivery of the outsourced entity at least once annually.
                                                                    </td>
                                                                   @if(isset($doc_id_chap2_5->doc_file))
                                                                    <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap2')[5].'/'.$doc_id_chap2_5->doc_file.'/'.$doc_id_chap2_5->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                    

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap2_5->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap2_6->doc_file)) highlight   @if(get_doc_code($doc_id_chap2_6->id)==__('arrayfile.document_doc_id_chap2')[6] && get_doccomment_status($doc_id_chap2_6->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap2_6->id)==__('arrayfile.document_doc_id_chap2')[6] && get_doccomment_status($doc_id_chap2_6->id)==0) highlight_nc @endif @endif">
                                                                    <td>OGA.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall identify regulations applicable to its activities and shall have a system to meet the regulations.
                                                                    </td>
                                                                   @if(isset($doc_id_chap2_6->doc_file))
                                                                    <td>

                                                                        <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap2')[6].'/'.$doc_id_chap2_6->doc_file.'/'.$doc_id_chap2_6->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap2_6->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 3- (FA) FINANCIAL RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr class="@if(isset($doc_id_chap3_1->doc_file)) highlight   @if(get_doc_code($doc_id_chap3_1->id)==__('arrayfile.document_doc_id_chap3')[1] && get_doccomment_status($doc_id_chap3_1->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap3_1->id)==__('arrayfile.document_doc_id_chap3')[1] && get_doccomment_status($doc_id_chap3_1->id)==0) highlight_nc @endif @endif">
                                                                    <td>FA.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have suitable mechanism to monitor its financial resources.
                                                                    </td>
                                                                    @if(isset($doc_id_chap3_1->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap3')[1].'/'.$doc_id_chap3_1->doc_file.'/'.$doc_id_chap3_1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap3_1->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                    
                                                                </tr>

                                                                <tr >
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 4- (HR) HUMAN RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr class="@if(isset($doc_id_chap4_1->doc_file)) highlight  @if(get_doc_code($doc_id_chap4_1->id)==__('arrayfile.document_doc_id_chap4')[1] && get_doccomment_status($doc_id_chap4_1->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap4_1->id)==__('arrayfile.document_doc_id_chap4')[1] && get_doccomment_status($doc_id_chap4_1->id)==0) highlight_nc @endif @endif ">
                                                                    <td>HR.1 </td>
                                                                    <td class="text-justify">
                                                                    The institution shall have sufficient resources to operate the training courses.
                                                                    </td>
                                                                    @if(isset($doc_id_chap4_1->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap4')[1].'/'.$doc_id_chap4_1->doc_file.'/'.$doc_id_chap4_1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap4_1->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                
                                                                    
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap4_2->doc_file)) highlight   @if(get_doc_code($doc_id_chap4_2->id)==__('arrayfile.document_doc_id_chap4')[2] && get_doccomment_status($doc_id_chap4_2->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap4_2->id)==__('arrayfile.document_doc_id_chap4')[2] && get_doccomment_status($doc_id_chap4_2->id)==0) highlight_nc @endif @endif">
                                                                    <td>HR.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a procedure for engaging personnel.
                                                                    </td>

                                                                    @if(isset($doc_id_chap4_2->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap4')[2].'/'.$doc_id_chap4_2->doc_file.'/'.$doc_id_chap4_2->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap4_2->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                      
                                                                    
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap4_3->doc_file)) highlight  @if(get_doc_code($doc_id_chap4_3->id)==__('arrayfile.document_doc_id_chap4')[3] && get_doccomment_status($doc_id_chap4_3->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap4_3->id)==__('arrayfile.document_doc_id_chap4')[3] && get_doccomment_status($doc_id_chap4_3->id)==0) highlight_nc @endif  @endif">
                                                                    <td>HR.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a mechanism to identify training needs of its personnel. 
                                                                    The feedback of the training is to be collected, analyzed and used for improvement.
                                                                    </td>

                                                                    @if(isset($doc_id_chap4_3->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap4')[3].'/'.$doc_id_chap4_3->doc_file.'/'.$doc_id_chap4_3->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap4_3->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap4_4->doc_file)) highlight   @if(get_doc_code($doc_id_chap4_4->id)==__('arrayfile.document_doc_id_chap4')[4] && get_doccomment_status($doc_id_chap4_4->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap4_4->id)==__('arrayfile.document_doc_id_chap4')[3] && get_doccomment_status($doc_id_chap4_4->id)==0) highlight_nc @endif @endif">
                                                                    <td>HR.4</td>
                                                                    <td class="text-justify">
                                                                    The organization shall have appraisal system for its personnel.
                                                                    </td>

                                                                    @if(isset($doc_id_chap4_4->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap4')[4].'/'.$doc_id_chap4_4->doc_file.'/'.$doc_id_chap4_4->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap4_4->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap4_5->doc_file)) highlight   @if(get_doc_code($doc_id_chap4_5->id)==__('arrayfile.document_doc_id_chap4')[5] && get_doccomment_status($doc_id_chap4_5->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap4_5->id)==__('arrayfile.document_doc_id_chap4')[5] && get_doccomment_status($doc_id_chap4_5->id)==0) highlight_nc @endif @endif">
                                                                    <td>HR.5</td>
                                                                    <td class="text-justify">
                                                                    The organization shall follow a grievance handling mechanism.
                                                                    </td>

                                                                    @if(isset($doc_id_chap4_5->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap4')[5].'/'.$doc_id_chap4_5->doc_file.'/'.$doc_id_chap4_5->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap4_5->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>

                                                                <tr  class="@if(isset($doc_id_chap4_6->doc_file)) highlight   @if(get_doc_code($doc_id_chap4_6->id)==__('arrayfile.document_doc_id_chap4')[6] && get_doccomment_status($doc_id_chap4_6->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap4_6->id)==__('arrayfile.document_doc_id_chap4')[6] && get_doccomment_status($doc_id_chap4_6->id)==2) highlight_nc @endif @endif">
                                                                    <td>HR.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall adopt measures to prevent the spread of infectious diseases. If applicable.
                                                                    </td>

                                                                     @if(isset($doc_id_chap4_6->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap4')[6].'/'.$doc_id_chap4_6->doc_file.'/'.$doc_id_chap4_6->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap4_6->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap4_7->doc_file)) highlight   @if(get_doc_code($doc_id_chap4_7->id)==__('arrayfile.document_doc_id_chap4')[7] && get_doccomment_status($doc_id_chap4_7->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap4_7->id)==__('arrayfile.document_doc_id_chap4')[7] && get_doccomment_status($doc_id_chap4_7->id)==0) highlight_nc @endif @endif">
                                                                    <td>HR.7</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a record of the personnel details like name, age, sex, qualification, designation, experience, training etc.

                                                                    </td>

                                                                    @if(isset($doc_id_chap4_7->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap4')[7].'/'.$doc_id_chap4_7->doc_file.'/'.$doc_id_chap4_7->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap4_7->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                    
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 5- (IR) INFRASTRUCTURE RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr class="@if(isset($doc_id_chap5_1->doc_file)) highlight  @if(get_doc_code($doc_id_chap5_1->id)==__('arrayfile.document_doc_id_chap5')[1] && get_doccomment_status($doc_id_chap5_1->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap5_1->id)==__('arrayfile.document_doc_id_chap5')[1] && get_doccomment_status($doc_id_chap5_1->id)==0) highlight_nc @endif @endif">
                                                                    <td>IR.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall determine and provide infrastructure needed to operate training courses.
                                                                    </td>

                                                                     @if(isset($doc_id_chap5_1->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap5')[1].'/'.$doc_id_chap5_1->doc_file.'/'.$doc_id_chap5_1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap5_1->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                  
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap5_2->doc_file)) highlight  @if(get_doc_code($doc_id_chap5_2->id)==__('arrayfile.document_doc_id_chap5')[2] && get_doccomment_status($doc_id_chap5_2->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap5_2->id)==__('arrayfile.document_doc_id_chap5')[2] && get_doccomment_status($doc_id_chap5_2->id)==0) highlight_nc @endif @endif">
                                                                    <td>IR.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall organize for periodic maintenance of infrastructure.
                                                                    </td>

                                                                     @if(isset($doc_id_chap5_2->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap5')[2].'/'.$doc_id_chap5_2->doc_file.'/'.$doc_id_chap5_2->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap5_2->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap5_3->doc_file)) highlight  @if(get_doc_code($doc_id_chap5_3->id)==__('arrayfile.document_doc_id_chap5')[3] && get_doccomment_status($doc_id_chap5_3->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap5_3->id)==__('arrayfile.document_doc_id_chap5')[3] && get_doccomment_status($doc_id_chap5_3->id)==0) highlight_nc @endif @endif">
                                                                    <td>IR.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall ensure for periodic calibration of equipment, if required.
                                                                    </td>

                                                                    @if(isset($doc_id_chap5_3->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap5')[3].'/'.$doc_id_chap5_3->doc_file.'/'.$doc_id_chap5_3->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap5_3->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                 
                                                                   
                                                                </tr>


                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 6- (SS) STUDENT SERVICES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr class="@if(isset($doc_id_chap6_1->doc_file)) highlight  @if(get_doc_code($doc_id_chap6_1->id)==__('arrayfile.document_doc_id_chap6')[1] && get_doccomment_status($doc_id_chap6_1->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap6_1->id)==__('arrayfile.document_doc_id_chap6')[1] && get_doccomment_status($doc_id_chap6_1->id)==0) highlight_nc @endif @endif">
                                                                    <td>SS.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the eligibility requirements for each training course, including prior knowledge needed, if any and make it publicly available without request.
                                                                    </td>

                                                                     @if(isset($doc_id_chap6_1->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap6')[1].'/'.$doc_id_chap6_1->doc_file.'/'.$doc_id_chap6_1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap6_1->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                              
                                                                   
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap6_2->doc_file)) highlight  @if(get_doc_code($doc_id_chap6_2->id)==__('arrayfile.document_doc_id_chap6')[2] && get_doccomment_status($doc_id_chap6_2->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap6_2->id)==__('arrayfile.document_doc_id_chap6')[2] && get_doccomment_status($doc_id_chap6_2->id)==0) highlight_nc @endif @endif">
                                                                    <td>SS.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have the code of conduct for trainees and shall have a system for addressing any breach of code of conduct.
                                                                    </td>

                                                                    @if(isset($doc_id_chap6_2->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap6')[2].'/'.$doc_id_chap6_2->doc_file.'/'.$doc_id_chap6_2->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap6_2->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                          
                                                                   
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap6_3->doc_file)) highlight  @if(get_doc_code($doc_id_chap6_3->id)==__('arrayfile.document_doc_id_chap6')[3] && get_doccomment_status($doc_id_chap6_3->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap6_3->id)==__('arrayfile.document_doc_id_chap6')[3] && get_doccomment_status($doc_id_chap6_3->id)==0) highlight_nc @endif @endif">
                                                                    <td>SS.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a system to address any issues related to the trainees
                                                                    </td>

                                                                     @if(isset($doc_id_chap6_3->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap6')[3].'/'.$doc_id_chap6_3->doc_file.'/'.$doc_id_chap6_3->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap6_3->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                   
                                                                </tr>


                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 7- (CC) COURSE CURRICULUM </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr class="@if(isset($doc_id_chap7_1->doc_file)) highlight  @if(get_doc_code($doc_id_chap7_1->id)==__('arrayfile.document_doc_id_chap7')[1] && get_doccomment_status($doc_id_chap7_1->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap7_1->id)==__('arrayfile.document_doc_id_chap7')[1] && get_doccomment_status($doc_id_chap7_1->id)==0) highlight_nc @endif @endif">
                                                                    <td>CC.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall identify the courses it wishes to operate, including courses developed by others.
                                                                    </td>

                                                                    @if(isset($doc_id_chap7_1->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap7')[1].'/'.$doc_id_chap7_1->doc_file.'/'.$doc_id_chap7_1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap7_1->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap7_2->doc_file)) highlight  @if(get_doc_code($doc_id_chap7_2->id)==__('arrayfile.document_doc_id_chap7')[2] && get_doccomment_status($doc_id_chap7_2->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap7_2->id)==__('arrayfile.document_doc_id_chap7')[2] && get_doccomment_status($doc_id_chap7_2->id)==0) highlight_nc @endif @endif">
                                                                    <td>CC.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have procedure to decide on course content, duration, eligibility etc. for each course that it operates, unless these are decided by an external course
                                                                    provider. In case the courses are designed by the external course provider, the training institution shall ensure that the courses meet all the applicable requirements of this standard.
                                                                    </td>

                                                                    @if(isset($doc_id_chap7_2->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap7')[2].'/'.$doc_id_chap7_2->doc_file.'/'.$doc_id_chap7_2->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap7_2->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                 
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap7_3->doc_file)) highlight  @if(get_doc_code($doc_id_chap7_3->id)==__('arrayfile.document_doc_id_chap7')[3] && get_doccomment_status($doc_id_chap7_3->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap7_3->id)==__('arrayfile.document_doc_id_chap7')[3] && get_doccomment_status($doc_id_chap7_3->id)==0) highlight_nc @endif @endif">
                                                                    <td>CC.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the competence of those who develop the courses and if needed take external help to develop courses.
                                                                </td>

                                                                 @if(isset($doc_id_chap7_3->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap7')[3].'/'.$doc_id_chap7_3->doc_file.'/'.$doc_id_chap7_3->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap7_3->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                  
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap7_4->doc_file)) highlight  @if(get_doc_code($doc_id_chap7_4->id)==__('arrayfile.document_doc_id_chap7')[4] && get_doccomment_status($doc_id_chap7_4->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap7_4->id)==__('arrayfile.document_doc_id_chap7')[4] && get_doccomment_status($doc_id_chap7_4->id)==0) highlight_nc @endif @endif">
                                                                    <td>CC.4</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have procedure to decide on course content, duration, eligibility etc. for each course that it operates, unless these are decided by an external course
                                                                    provider. In case the courses are designed by the external course provider, the training institution shall ensure that the courses meet all the applicable requirements of this standard.
                                                                    </td>

                                                                    @if(isset($doc_id_chap7_4->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap7')[4].'/'.$doc_id_chap7_4->doc_file.'/'.$doc_id_chap7_4->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap7_4->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap7_5->doc_file)) highlight  @if(get_doc_code($doc_id_chap7_5->id)==__('arrayfile.document_doc_id_chap7')[5] && get_doccomment_status($doc_id_chap7_5->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap7_5->id)==__('arrayfile.document_doc_id_chap7')[5] && get_doccomment_status($doc_id_chap7_5->id)==0) highlight_nc @endif @endif">
                                                                    <td>CC.5</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the learning outcome of its training courses. 
                                                                    </td>
                                                                    @if(isset($doc_id_chap7_5->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap7')[5].'/'.$doc_id_chap7_5->doc_file.'/'.$doc_id_chap7_5->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap7_5->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                  
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap7_6->doc_file)) highlight  @if(get_doc_code($doc_id_chap7_6->id)==__('arrayfile.document_doc_id_chap7')[6] && get_doccomment_status($doc_id_chap7_6->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap7_6->id)==__('arrayfile.document_doc_id_chap7')[6] && get_doccomment_status($doc_id_chap7_6->id)==0) highlight_nc @endif @endif">
                                                                    <td>CC.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall ensure the courses are delivered as designed.
                                                                    </td>

                                                                    @if(isset($doc_id_chap7_6->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap7')[6].'/'.$doc_id_chap7_6->doc_file.'/'.$doc_id_chap7_6->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap7_6->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                  
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 8- (EA) EVALUATION AND ASSESSMENT </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap8_1->doc_file)) highlight  @if(get_doc_code($doc_id_chap8_1->id)==__('arrayfile.document_doc_id_chap8')[1] && get_doccomment_status($doc_id_chap8_1->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap8_1->id)==__('arrayfile.document_doc_id_chap8')[1] && get_doccomment_status($doc_id_chap8_1->id)==0) highlight_nc @endif @endif">
                                                                    <td>EA.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have evaluation at the end of training/year for each course
                                                                    </td>

                                                                     @if(isset($doc_id_chap8_1->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap8')[1].'/'.$doc_id_chap8_1->doc_file.'/'.$doc_id_chap8_1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap8_1->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                    
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap8_2->doc_file)) highlight  @if(get_doc_code($doc_id_chap8_2->id)==__('arrayfile.document_doc_id_chap8')[2] && get_doccomment_status($doc_id_chap8_2->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap8_2->id)==__('arrayfile.document_doc_id_chap8')[2] && get_doccomment_status($doc_id_chap8_2->id)==0) highlight_nc @endif @endif">
                                                                    <td>EA.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the criteria of evaluation for each training course.
                                                                    </td>

                                                                      @if(isset($doc_id_chap8_2->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap8')[2].'/'.$doc_id_chap8_2->doc_file.'/'.$doc_id_chap8_2->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap8_2->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>


                                                                <tr  class="@if(isset($doc_id_chap8_3->doc_file)) highlight  @if(get_doc_code($doc_id_chap8_3->id)==__('arrayfile.document_doc_id_chap8')[3] && get_doccomment_status($doc_id_chap8_3->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap8_3->id)==__('arrayfile.document_doc_id_chap8')[3] && get_doccomment_status($doc_id_chap8_3->id)==0) highlight_nc @endif @endif">
                                                                    <td>EA.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the process of evaluation for each training course.
                                                                    </td>

                                                                     @if(isset($doc_id_chap8_3->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap8')[3].'/'.$doc_id_chap8_3->doc_file.'/'.$doc_id_chap8_3->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap8_3->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>


                                                                <tr class="@if(isset($doc_id_chap8_4->doc_file)) highlight  @if(get_doc_code($doc_id_chap8_4->id)==__('arrayfile.document_doc_id_chap8')[4] && get_doccomment_status($doc_id_chap8_4->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap8_4->id)==__('arrayfile.document_doc_id_chap8')[4] && get_doccomment_status($doc_id_chap8_4->id)==0) highlight_nc @endif @endif">
                                                                    <td>EA.4</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define if the student is not successful in evaluation and if student can appear again
                                                                    without training if yes, how many times.                                                                    </td>

                                                                     @if(isset($doc_id_chap8_4->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap8')[4].'/'.$doc_id_chap8_4->doc_file.'/'.$doc_id_chap8_4->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap8_4->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>


                                                                <tr class="@if(isset($doc_id_chap8_5->doc_file)) highlight  @if(get_doc_code($doc_id_chap8_5->id)==__('arrayfile.document_doc_id_chap8')[5] && get_doccomment_status($doc_id_chap8_5->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap8_5->id)==__('arrayfile.document_doc_id_chap8')[5] && get_doccomment_status($doc_id_chap8_5->id)==0) highlight_nc @endif @endif">
                                                                    <td>EA.5</td>
                                                                    <td class="text-justify">
                                                                    The institution defines conditions under which, students Page 36 may be required to repeat the training to be revaluated.
                                                                    </td>

                                                                    @if(isset($doc_id_chap8_5->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap8')[5].'/'.$doc_id_chap8_5->doc_file.'/'.$doc_id_chap8_5->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap8_5->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap8_6->doc_file)) highlight  @if(get_doc_code($doc_id_chap8_6->id)==__('arrayfile.document_doc_id_chap8')[6] && get_doccomment_status($doc_id_chap8_6->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap8_6->id)==__('arrayfile.document_doc_id_chap8')[6] && get_doccomment_status($doc_id_chap8_6->id)==0) highlight_nc @endif @endif">
                                                                    <td>EA.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have an independent process for appeal against the decision on evaluation.
                                                                    </td>

                                                                    @if(isset($doc_id_chap8_6->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap8')[6].'/'.$doc_id_chap8_6->doc_file.'/'.$doc_id_chap8_6->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap8_6->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 9- (LR)- LEARNING RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap9_1->doc_file)) highlight  @if(get_doc_code($doc_id_chap9_1->id)==__('arrayfile.document_doc_id_chap9')[1] && get_doccomment_status($doc_id_chap9_1->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap9_1->id)==__('arrayfile.document_doc_id_chap9')[1] && get_doccomment_status($doc_id_chap9_1->id)==0) highlight_nc @endif @endif">
                                                                    <td>LR.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall provide information on learning resources – both physical and virtual for self-learning.
                                                                    </td>

                                                                    @if(isset($doc_id_chap9_1->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap9')[1].'/'.$doc_id_chap9_1->doc_file.'/'.$doc_id_chap9_1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap9_1->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                 
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap9_2->doc_file)) highlight  @if(get_doc_code($doc_id_chap9_2->id)==__('arrayfile.document_doc_id_chap9')[2] && get_doccomment_status($doc_id_chap9_2->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap9_2->id)==__('arrayfile.document_doc_id_chap9')[2] && get_doccomment_status($doc_id_chap9_2->id)==0) highlight_nc @endif @endif">
                                                                    <td>LR.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall encourage research, publication, article writing or dissertation work.
                                                                    </td>

                                                                    @if(isset($doc_id_chap9_2->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap9')[2].'/'.$doc_id_chap9_2->doc_file.'/'.$doc_id_chap9_2->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap9_2->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 10- (QI)- QUALITY IMPROVEMENT </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap10_1->doc_file)) highlight  @if(get_doc_code($doc_id_chap10_1->id)==__('arrayfile.document_doc_id_chap10')[1] && get_doccomment_status($doc_id_chap10_1->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap10_1->id)==__('arrayfile.document_doc_id_chap10')[1] && get_doccomment_status($doc_id_chap10_1->id)==0) highlight_nc @endif @endif">
                                                                    <td>QI.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall establish a monitoring system for quality improvement.
                                                                    </td>

                                                                    @if(isset($doc_id_chap10_1->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap10')[1].'/'.$doc_id_chap10_1->doc_file.'/'.$doc_id_chap10_1->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap10_1->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                  
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap10_2->doc_file)) highlight  @if(get_doc_code($doc_id_chap10_2->id)==__('arrayfile.document_doc_id_chap10')[2] && get_doccomment_status($doc_id_chap10_2->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap10_2->id)==__('arrayfile.document_doc_id_chap10')[2] && get_doccomment_status($doc_id_chap10_2->id)==0) highlight_nc @endif @endif">
                                                                    <td>QI.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define its quality indicators/ learning outcome indicators to promote quality in training.
                                                                    </td>

                                                                    @if(isset($doc_id_chap10_2->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap10')[2].'/'.$doc_id_chap10_2->doc_file.'/'.$doc_id_chap10_2->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap10_2->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                  
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap10_3->doc_file)) highlight  @if(get_doc_code($doc_id_chap10_3->id)==__('arrayfile.document_doc_id_chap10')[3] && get_doccomment_status($doc_id_chap10_3->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap10_3->id)==__('arrayfile.document_doc_id_chap10')[3] && get_doccomment_status($doc_id_chap10_3->id)==0) highlight_nc @endif @endif">
                                                                    <td>QI.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall collect feedback from students and other stakeholders and analyze it for improvement of quality.
                                                                    </td>

                                                                     @if(isset($doc_id_chap10_3->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap10')[3].'/'.$doc_id_chap10_3->doc_file.'/'.$doc_id_chap10_3->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap10_3->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                
                                                                </tr>

                                                                <tr class="@if(isset($doc_id_chap10_4->doc_file)) highlight  @if(get_doc_code($doc_id_chap10_4->id)==__('arrayfile.document_doc_id_chap10')[4] && get_doccomment_status($doc_id_chap10_4->id)==1) highlight_nc_approved @elseif(get_doc_code($doc_id_chap10_4->id)==__('arrayfile.document_doc_id_chap10')[4] && get_doccomment_status($doc_id_chap10_4->id)==0) highlight_nc @endif @endif">
                                                                    <td>QI.4</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a system of internal audit annually and address the findings for improvement.
                                                                    </td>

                                                                    @if(isset($doc_id_chap10_4->doc_file))
                                                                    <td>

                                                                    <a target="_blank" href="{{ url('view-doc'.'/'.__('arrayfile.document_doc_id_chap10')[4].'/'.$doc_id_chap10_4->doc_file.'/'.$doc_id_chap10_4->id) }}"
                                                                        class="btn text-white bg-primary btn-sm" style="color: #fff ;margin:10px;" id="view_doc1">View Documents</a>  
                                                                    </td>

                                                                     <td>
                                                                          <a href="{{ url('show-comment/'.$doc_id_chap10_4->id) }}" 
                                                                        class="btn text-white bg-primary" style="color: #fff;margin:10px;">Comments</a>

                                                                    </td>
                                                                    @endif
                                                                   
                                                                </tr>


                                                              
                                                    </tbody>
                                                </table>

                                            
                                          </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
   $('.fileup').on('change',function(e){
           e.preventDefault();
           
           let sbformId = $(this).closest("form").attr('id');
           let formData = new FormData(document.getElementById(sbformId));
           console.log(formData);
           formData.append('fileup', $('input[type=file]').val().split('\\').pop()); 

           //formData.append('fileup', $('input[type=file]').val().split('\\').pop()); 
           $("#success-msg").removeClass('d-none');
           $("#loader").removeClass('d-none');
           var data ="{{url(Request::url())}}";
           //alert(data);
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

           $.ajax({

            url: " {{ url('add-courses') }}",
            type: "POST",
            data: formData,
            processData:false,
            contentType: false,
            enctype: 'multipart/form-data',
            
            

            success: function (response) {
                $("#loader").addClass('d-none');
                //$("#success-msg").addClass('d-none');
                alert("Document Added Successfully");
                window.location.href= "{{url(Request::url())}}";
                //$("#mydiv").load(location.href + " #mydiv");
              
                
            }
        });
     });
</script>
<script>
    $( document ).ready(function() {
         $('#view_doc').hide();
         $('#show_comments').hide();
      });

          $('#show_view_doc_options').on('change', function(){

          var listvalue = $(this).val();
          //alert(listvalue);   
          if(listvalue==1)
          {
              $("#view_doc").show();
              $("#show_comments").show();
          } 
          else if(listvalue==2)
          {
             $("#view_doc").hide();
             $("#show_comments").hide();
          }

          else if(listvalue=='')
          {
             $("#view_doc").hide();
             $("#show_comments").hide();
          }
             
            
         });
</script>
    @include('layout.footer')
