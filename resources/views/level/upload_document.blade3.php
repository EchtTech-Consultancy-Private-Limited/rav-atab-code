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
                                <h4 class="page-title">Upload Documents</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Level </a>
                            </li>
                            <li class="breadcrumb-item active">Upload document</li>

                           
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
                    {{ session::get('sussess') }}
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
                                              <div class="success-msg alert alert-success d-none" role="alert">
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
                                                            <th class="center">Cross reference to supporting evidence provided</th>
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

                                                                <tr class="@if(isset($document->doc_file)) highlight  @endif">
                                                                    <td>VMO.1</td>
                                                                    <td class="text-justify">The institution shall have a clearly defined and documented mission and vision. </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td class="chapter1_vmo_1 " > 
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form" class="form-control" enctype="multipart/form-data">


                                                                        <input type="file"  class="from-control" name="fileup" id="fileup"/><br>
                                                                        <a href="#">{{ isset($document->doc_file) }}</a>

                                                                        <input type="hidden" name="previous_url" value="{{ Request::url() }}">

                                                                        <input type="hidden" id="course_id" name="course_id" value="{{ $course_id }}">
                                                                        <input type="hidden" class="section_id" name="section_id" value="VMO">
                                                                        <input type="hidden" class="doc_id" name="doc_id" value="VMO1">
                                                                        
                                                                        </form>
                                                                        
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>VMO.2</td>
                                                                    <td class="text-justify">The institution shall have defined objectives and measure them periodically</td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>VMO.3</td>
                                                                    <td class="text-justify">The institution shall have mentioned activities that are taken to achieve these objectives. </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>                                                              
                                                                <tr>
                                                                    <td>VMO.4</td>
                                                                    <td class="text-justify">The institution shall define its quality policy. </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>VMO.5</td>
                                                                    <td class="text-justify">The institution shall have a policy for evaluation of human resources engaged in training. </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>VMO.6</td>
                                                                    <td class="text-justify">The institution shall have policy for evaluation of the students </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 2(OGA) ORGANIZATION, GOVERNANCE AND ADMINISTRATION </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr>
                                                                    <td>OGA.1</td>
                                                                    <td class="text-justify">
                                                                      The institution shall declare its ownership and legal status and details of ownership.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>OGA.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define its organizational structure or organogram
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>OGA.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the roles and responsibilities of all personnel.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>OGA.4</td>
                                                                    <td class="text-justify">
                                                                      The institution shall define rules applicable to all personnel.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>OGA.5</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a policy and procedure for outsourcing, if any. The policy shall ensure that the
                                                                    outsourced entity complies with applicable parts of the standards and part of the assessment. 
                                                                    The accredited training providers must witness the delivery of the outsourced entity at least once annually.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>OGA.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall identify regulations applicable to its activities and shall have a system to meet the regulations.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 3- (FA) FINANCIAL RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr>
                                                                    <td>FA.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have suitable mechanism to monitor its financial resources.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 4- (HR) HUMAN RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr>
                                                                    <td>HR.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have sufficient resources to operate the training courses.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>HR.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a procedure for engaging personnel.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>HR.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a mechanism to identify training needs of its personnel. 
                                                                    The feedback of the training is to be collected, analyzed and used for improvement.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>HR.4</td>
                                                                    <td class="text-justify">
                                                                    The organization shall have appraisal system for its personnel.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>HR.5</td>
                                                                    <td class="text-justify">
                                                                    The organization shall follow a grievance handling mechanism.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>HR.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall adopt measures to prevent the spread of infectious diseases. If applicable.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>HR.7</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a record of the personnel details like name, age, sex, qualification, designation, experience, training etc.

                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 5- (IR) INFRASTRUCTURE RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr>
                                                                    <td>IR.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall determine and provide infrastructure needed to operate training courses.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>IR.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall organize for periodic maintenance of infrastructure.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>IR.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall ensure for periodic calibration of equipment, if required.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 6- (SS) STUDENT SERVICES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr>
                                                                    <td>SS.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the eligibility requirements for each training course, including prior knowledge needed, if any and make it publicly available without request.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>SS.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have the code of conduct for trainees and shall have a system for addressing any breach of code of conduct.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>SS.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a system to address any issues related to the trainees
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 7- (CC) COURSE CURRICULUM </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr>
                                                                    <td>CC.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall identify the courses it wishes to operate, including courses developed by others.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>CC.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have procedure to decide on course content, duration, eligibility etc. for each course that it operates, unless these are decided by an external course
                                                                    provider. In case the courses are designed by the external course provider, the training institution shall ensure that the courses meet all the applicable requirements of this standard.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>CC.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the competence of those who develop the courses and if needed take external help to develop courses.
                                                                </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>CC.4</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have procedure to decide on course content, duration, eligibility etc. for each course that it operates, unless these are decided by an external course
                                                                    provider. In case the courses are designed by the external course provider, the training institution shall ensure that the courses meet all the applicable requirements of this standard.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>CC.5</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the learning outcome of its training courses. 
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>CC.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall ensure the courses are delivered as designed.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 8- (EA) EVALUATION AND ASSESSMENT </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>

                                                                <tr>
                                                                    <td>EA.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have evaluation at the end of training/year for each course
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>EA.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the criteria of evaluation for each training course.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td>EA.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the process of evaluation for each training course.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td>EA.4</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define if the student is not successful in evaluation and if student can appear again
                                                                    without training if yes, how many times.                                                                     </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td>EA.5</td>
                                                                    <td class="text-justify">
                                                                    The institution defines conditions under which, students Page 36 may be required to repeat the training to be revaluated.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>EA.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have an independent process for appeal against the decision on evaluation.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 9- (LR)- LEARNING RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>

                                                                <tr>
                                                                    <td>LR.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall provide information on learning resources – both physical and virtual for self-learning.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>LR.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall encourage research, publication, article writing or dissertation work.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 10- (QI)- QUALITY IMPROVEMENT </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>

                                                                <tr>
                                                                    <td>QI.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall establish a monitoring system for quality improvement.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>QI.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define its quality indicators/ learning outcome indicators to promote quality in training.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>QI.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall collect feedback from students and other stakeholders and analyze it for improvement of quality.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>QI.4</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a system of internal audit annually and address the findings for improvement.
                                                                    </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
    <select class="form-control text-center">
        <option>--Select--</option>
        <option>Yes</option>
        <option>No</option>
    </select>
</div>  </td>-->
                                                                    <td>
                                                                        <input type="file" class="from-control"/>
                                                                    </td>
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
   $('.chapter1_vmo_1').on('change',function(e) {
           e.preventDefault();
           
           let formData = new FormData(document.getElementById('submitform_doc_form'));    
           formData.append('fileup', $('input[type=file]').val().split('\\').pop()); 
           
           $("#loader").removeClass('d-none');
           $(".success-msg").removeClass('d-none');
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
                $(".success-msg").addClass('d-none');
                //alert("Document Added Successfully");
                window.location.href= "{{ url(Request::url()) }}";
                $("#loader").append('d-none');
                //$("#mydiv").load(location.href + " #mydiv");
              
                
            }
        });
     });
</script>

    @include('layout.footer')
