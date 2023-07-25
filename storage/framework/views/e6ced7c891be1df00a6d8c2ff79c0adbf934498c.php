<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


   
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
                <img class="loading-img-spin" src="<?php echo e(asset('assets/images/favicon.png')); ?>" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->

    
<!-- Progressbar Modal Poup -->
<div class="loading-img d-none" id="loader">                 
    <div class="box">
    <img src="<?php echo e(asset('assets/img/VAyR.gif')); ?>">  
    <h5 class="uploading-text"> Uploading... </h5>
</div>       
            </div>
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <?php echo $__env->make('layout.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div>

        <?php if(Auth::user()->role == '1'): ?>
            <?php echo $__env->make('layout.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(Auth::user()->role == '2'): ?>
            <?php echo $__env->make('layout.siderTp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(Auth::user()->role == '3'): ?>
            <?php echo $__env->make('layout.sideAss', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif(Auth::user()->role == '4'): ?>
            <?php echo $__env->make('layout.sideprof', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>


        <?php echo $__env->make('layout.rightbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    </div>



    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Upload Documents</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Level </a>
                            </li>
                            <li class="breadcrumb-item active">Upload document</li>

                           
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <ul class="breadcrumb breadcrumb-style ">
                             <a href="<?php echo e(url()->previous()); ?>" type="button" class="btn btn-primary" style="float:right;">Back To Documents</a>
                        </ul>
                    </div>
                </div>
            </div>

            <?php if(Session::has('sussess')): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo e(session::get('success')); ?>

                </div>
            <?php elseif(Session::has('fail')): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo e(session::get('fail')); ?>

                </div>
            <?php endif; ?>

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

                                                <form method="post" action="<?php echo e(url('upload-document')); ?>"
                                                    id="regForm" enctype="multipart/form-data">

                                                    <?php echo csrf_field(); ?>
                                                    <div class="body">
                                                        <div class="row clearfix">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label>document type<span
                                                                                class="text-danger">*</span></label>
                                                                        <select name="document_type_id" required
                                                                             id="title">
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


                                                            <input type="hidden" name="application_id" value="<?php echo e($data[0]->application_id); ?>">
                                                            <input type="hidden" name="level_id" value="<?php echo e($data[0]->level_id); ?>">



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
                                             <h2 class="text-center"> CHAPTER 1- (VMO) VISION MISSION AND OBJECTIVES </h2>
                                          </div>
                                            <?php if($message = Session::get('success')): ?>
                                                <div class="alert alert-success">
                                                   <p><?php echo e($message); ?></p>
                                                </div>
                                              <?php endif; ?>
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
                                                            <th class="center">Cross reference to supporting evidence provided</th>
                                                            <th>Uploaded Documents</th>
                                                            <th>Comments</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">

<!-- 
                                                        <?php $__currentLoopData = $file; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $files): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr class="odd gradeX">
                                                                <td class="center"><?php echo e($k+1); ?></td>
                                                                 <td class="center"><?php echo e($files->document_type_name); ?></td>

                                                               <td> <img src="<?php echo e(asset('documnet/'.$files->document_file)); ?>" width="150" height="120" /> </td>


                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->
<tr class="<?php if(isset($doc_id1->doc_file)): ?> highlight <?php if(get_doc_code($doc_id1->id)==__('arrayfile.document_doc_id_chap1')[1] && get_doccomment_status($doc_id1->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id1->id)==__('arrayfile.document_doc_id_chap1')[1] && get_doccomment_status($doc_id1->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>VMO.1</td>
                                                                    <td class="text-justify">The institution shall have a clearly defined and documented mission and vision. </td>
                                                                    <!--<td> <div class="form-group default-select mb-0">
                                                                        <select class="form-control text-center">
                                                                            <option>--Select--</option>
                                                                            <option>Yes</option>
                                                                            <option>No</option>
                                                                        </select>
                                                                    </div>  </td>-->
                                                                    <td> 
                                                                        
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form_1" class="submitform_doc_form" enctype="multipart/form-data">

                                                                        
                                                                        <?php if(isset($doc_id1->doc_file)): ?>
                                                                        <?php else: ?>
                                                                        <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                        <?php endif; ?>
                                                                        <?php if(isset($doc_id1->id)): ?>
                                                                        <?php if(get_doc_code($doc_id1->id) && get_doccomment_status($doc_id1->id)==2): ?>
                                                                     
                                                                        <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                        <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id1->id); ?>" />
                                                                        <?php endif; ?>
                                                                        <?php endif; ?>
  
                                                                        
                                                                        <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                        <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                        <input type="hidden" class="section_id" name="section_id" value="VMO">
                                                                        <input type="hidden" class="doc_id" id="doc_id" name="doc_id" value="VMO.1">
                                                                       </form>
                                                                        
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id1->doc_file)): ?>
                                                                     
                                                                         <!--<a href="#"><?php echo e($doc_id1->doc_file); ?> </a> -->
                                                                        <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id1->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id1->doc_file); ?></a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php if(isset($doc_id1->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id1->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id2->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id2->id)==__('arrayfile.document_doc_id_chap1')[2] && get_doccomment_status($doc_id2->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id2->id)==__('arrayfile.document_doc_id_chap1')[2] && get_doccomment_status($doc_id2->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
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

                                                                        <form   name="submitform_doc_form" id="submitform_doc_form_2" class="submitform_doc_form" enctype="multipart/form-data">

                                                                        <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                        

                                                                        <?php if(isset($doc_id2->doc_file)): ?>
                                                                        <?php else: ?>
                                                                        <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                        <?php endif; ?>
                                                                        <?php if(isset($doc_id2->id)): ?>
                                                                        <?php if(get_doccomment_status($doc_id2->id)==2): ?>
                                                                     
                                                                        <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                        <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id2->id); ?>" />
                                                                        <?php endif; ?>
                                                                        <?php endif; ?>


                                                                        <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                        <input type="hidden" class="section_id" name="section_id" value="VMO">
                                                                        <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="VMO.2">
                                                                        
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id2->doc_file)): ?>
                                                                        <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id2->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id2->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id2->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id2->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id3->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id3->id)==__('arrayfile.document_doc_id_chap1')[3] && get_doccomment_status($doc_id3->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id3->id)==__('arrayfile.document_doc_id_chap1')[3] && get_doccomment_status($doc_id3->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>VMO.3</td>
                                                                    <td class="text-justify">The institution shall have mentioned activities that are taken to achieve these objectives. </td>
                                                
                                                                    <td>
                                                                       
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form_3" enctype="multipart/form-data">

                                                                          <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                        
                                                                            <?php if(isset($doc_id3->doc_file)): ?>
                                                                                <?php else: ?>
                                                                                <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>
                                                                            <?php if(isset($doc_id3->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id3->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id3->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="VMO">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="VMO.3">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                     <?php if(isset($doc_id3->doc_file)): ?>
                                                             
                                                                       <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id3->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id3->doc_file); ?></a>

                                                                    <?php endif; ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php if(isset($doc_id3->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id3->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>                                                              
                                                                <tr class="<?php if(isset($doc_id4->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id4->id)==__('arrayfile.document_doc_id_chap1')[4] && get_doccomment_status($doc_id4->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id4->id)==__('arrayfile.document_doc_id_chap1')[4] && get_doccomment_status($doc_id4->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>VMO.4</td>
                                                                    <td class="text-justify">The institution shall define its quality policy. </td>
                                                                    <td class="chapter1_vmo_3">
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form4" enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                            <?php if(isset($doc_id4->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>
                                                                            <?php if(isset($doc_id4->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id4->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id4->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="VMO">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="VMO.4">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id4->doc_file)): ?>
                                                                 
                                                                          <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id4->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id4->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                     <td>
                                                                        <?php if(isset($doc_id4->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id4->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id5->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id5->id)==__('arrayfile.document_doc_id_chap1')[5] && get_doccomment_status($doc_id5->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id5->id)==__('arrayfile.document_doc_id_chap1')[5] && get_doccomment_status($doc_id5->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>VMO.5</td>
                                                                    <td class="text-justify">The institution shall have a policy for evaluation of human resources engaged in training. </td>
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form5" enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id5->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>
                                                                            <?php if(isset($doc_id5->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id5->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id5->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="VMO">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="VMO.5">
                                                                           
                                                                        </form>
                                                                    </td>
                                                                     <td>
                                                                        <?php if(isset($doc_id5->doc_file)): ?>
                                                                 
                                                                        <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id5->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id5->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                     <td>
                                                                        <?php if(isset($doc_id5->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id5->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id6->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id6->id)==__('arrayfile.document_doc_id_chap1')[6] && get_doccomment_status($doc_id6->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id6->id)==__('arrayfile.document_doc_id_chap1')[6] && get_doccomment_status($doc_id6->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>VMO.6</td>
                                                                    <td class="text-justify">The institution shall have policy for evaluation of the students </td>
                                                                 
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form6" enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id6->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>
                                                                            <?php if(isset($doc_id6->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id6->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id6->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="VMO">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="VMO.6">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id6->doc_file)): ?>
                                                                 
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id6->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id6->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id6->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id6->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>


                                                                <tr >
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 2(OGA) ORGANIZATION, GOVERNANCE AND ADMINISTRATION </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                            <tr class="<?php if(isset($doc_id_chap2_1->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap2_1->id)==__('arrayfile.document_doc_id_chap2')[1] && get_doccomment_status($doc_id_chap2_1->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap2_1->id)==__('arrayfile.document_doc_id_chap2')[1] && get_doccomment_status($doc_id_chap2_1->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>OGA.1</td>
                                                                    <td class="text-justify">
                                                                      The institution shall declare its ownership and legal status and details of ownership.
                                                                    </td>
                                                                   
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form7"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                            <?php if(isset($doc_id_chap2_1->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>
                                                                            <?php if(isset($doc_id_chap2_1->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap2_1->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap2_1->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="OGA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="OGA.1">
                                                                           
                                                                        </form>
                                                                    </td>
                                                                     <td>
                                                                        <?php if(isset($doc_id_chap2_1->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap2_1->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap2_1->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php if(isset($doc_id_chap2_1->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap2_1->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap2_2->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap2_2->id)==__('arrayfile.document_doc_id_chap2')[2] && get_doccomment_status($doc_id_chap2_2->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap2_2->id)==__('arrayfile.document_doc_id_chap2')[2] && get_doccomment_status($doc_id_chap2_2->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>OGA.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define its organizational structure or organogram
                                                                    </td>
                                                               
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form8"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                             <?php if(isset($doc_id_chap2_2->doc_file)): ?>
                                                                                <?php else: ?>
                                                                                <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                             <?php endif; ?>
                                                                             <?php if(isset($doc_id_chap2_2->id)): ?>
                                                                             <?php if(get_doccomment_status($doc_id_chap2_2->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap2_2->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="OGA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="OGA.2">
                                                                         </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap2_2->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap2_2->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap2_2->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap2_2->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap2_2->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap2_3->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap2_3->id)==__('arrayfile.document_doc_id_chap2')[3] && get_doccomment_status($doc_id_chap2_3->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap2_3->id)==__('arrayfile.document_doc_id_chap2')[3] && get_doccomment_status($doc_id_chap2_3->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>OGA.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the roles and responsibilities of all personnel.
                                                                    </td>
                                                                   
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form9"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                            <?php if(isset($doc_id_chap2_3->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap2_3->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap2_3->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap2_3->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="OGA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="OGA.3">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap2_3->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap2_3->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap2_3->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap2_3->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap2_3->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap2_4->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap2_4->id)==__('arrayfile.document_doc_id_chap2')[4] && get_doccomment_status($doc_id_chap2_4->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap2_4->id)==__('arrayfile.document_doc_id_chap2')[4] && get_doccomment_status($doc_id_chap2_4->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>OGA.4</td>
                                                                    <td class="text-justify">
                                                                      The institution shall define rules applicable to all personnel.
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form10"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                             <?php if(isset($doc_id_chap2_4->doc_file)): ?>
                                                                                <?php else: ?>
                                                                                <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                                <?php endif; ?>
                                                                            <?php if(isset($doc_id_chap2_4->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap2_4->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap2_4->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="OGA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="OGA.4">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap2_4->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap2_4->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap2_4->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>

                                                                     <td>
                                                                        <?php if(isset($doc_id_chap2_4->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap2_4->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap2_5->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap2_5->id)==__('arrayfile.document_doc_id_chap2')[5] && get_doccomment_status($doc_id_chap2_5->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap2_5->id)==__('arrayfile.document_doc_id_chap2')[5] && get_doccomment_status($doc_id_chap2_5->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>OGA.5</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a policy and procedure for outsourcing, if any. The policy shall ensure that the
                                                                    outsourced entity complies with applicable parts of the standards and part of the assessment. 
                                                                    The accredited training providers must witness the delivery of the outsourced entity at least once annually.
                                                                    </td>
                                                                 
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form11"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                             <?php if(isset($doc_id_chap2_5->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap2_5->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap2_5->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap2_5->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="OGA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="OGA.5">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap2_5->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap2_5->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap2_5->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                            </td>

                                                                     <td>
                                                                        <?php if(isset($doc_id_chap2_5->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap2_5->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                                <tr class="<?php if(isset($doc_id_chap2_6->doc_file)): ?> highlight    <?php if(get_doc_code($doc_id_chap2_6->id)==__('arrayfile.document_doc_id_chap2')[6] && get_doccomment_status($doc_id_chap2_6->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap2_6->id)==__('arrayfile.document_doc_id_chap2')[6] && get_doccomment_status($doc_id_chap2_6->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>OGA.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall identify regulations applicable to its activities and shall have a system to meet the regulations.
                                                                    </td>
                                                            
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form12" class="" enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                             <?php if(isset($doc_id_chap2_6->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap2_6->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap2_6->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap2_6->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="OGA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="OGA.6">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap2_6->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap2_6->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap2_6->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>

                                                                     <td>
                                                                        <?php if(isset($doc_id_chap2_6->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap2_6->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 3- (FA) FINANCIAL RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr class="<?php if(isset($doc_id_chap3_1->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap3_1->id)==__('arrayfile.document_doc_id_chap3')[1] && get_doccomment_status($doc_id_chap3_1->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap3_1->id)==__('arrayfile.document_doc_id_chap3')[1] && get_doccomment_status($doc_id_chap3_1->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>FA.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have suitable mechanism to monitor its financial resources.
                                                                    </td>
                                                                 
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form13"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                             <?php if(isset($doc_id_chap3_1->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                           
                                                                            <?php if(isset($doc_id_chap3_1->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap3_1->id)==2): ?>
                                                                          
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap3_1->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="FA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="FA.1">
                                                                         </form>
                                                                    </td>

                                                                    <td>
                                                                        <?php if(isset($doc_id_chap3_1->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap3_1->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap3_1->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap3_1->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap3_1->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 4- (HR) HUMAN RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr class="<?php if(isset($doc_id_chap4_1->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap4_1->id)==__('arrayfile.document_doc_id_chap4')[1] && get_doccomment_status($doc_id_chap4_1->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap4_1->id)==__('arrayfile.document_doc_id_chap4')[1] && get_doccomment_status($doc_id_chap4_1->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>HR.1 </td>
                                                                    <td class="text-justify">
                                                                    The institution shall have sufficient resources to operate the training courses.
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form14"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                             <?php if(isset($doc_id_chap4_1->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            
                                                                            <?php if(isset($doc_id_chap4_1->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap4_1->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap4_1->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="HR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="HR.1">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap4_1->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap4_1->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap4_1->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap4_1->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap4_1->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap4_2->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap4_2->id)==__('arrayfile.document_doc_id_chap4')[2] && get_doccomment_status($doc_id_chap4_2->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap4_2->id)==__('arrayfile.document_doc_id_chap4')[2] && get_doccomment_status($doc_id_chap4_2->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>HR.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a procedure for engaging personnel.
                                                                    </td>
                                                                    
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form15"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                            <?php if(isset($doc_id_chap4_2->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>
                                                                            <?php if(isset($doc_id_chap4_2->id)): ?>
                                                                            <?php if(get_doccomment_status(isset($doc_id_chap4_2->id))==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap4_2->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>



                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="HR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="HR.2">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap4_2->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap4_2->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap4_2->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap4_2->doc_file)): ?>
                                                                     
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap4_2->id)); ?>" 
                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                         
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap4_3->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap4_3->id)==__('arrayfile.document_doc_id_chap4')[3] && get_doccomment_status($doc_id_chap4_3->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap4_3->id)==__('arrayfile.document_doc_id_chap4')[3] && get_doccomment_status($doc_id_chap4_3->id)==2): ?> highlight_nc <?php endif; ?>  <?php endif; ?>">
                                                                    <td>HR.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a mechanism to identify training needs of its personnel. 
                                                                    The feedback of the training is to be collected, analyzed and used for improvement.
                                                                    </td>
                                                                 
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form16"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                            <?php if(isset($doc_id_chap4_3->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>
                                                                            <?php if(isset($doc_id_chap4_3->id)): ?>
                                                                            <?php if(get_doccomment_status(isset($doc_id_chap4_3->id))==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap4_3->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="HR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="HR.3">
                                                                           
                                                                        </form>
                                                                    </td>
                                                                     <td>
                                                                        <?php if(isset($doc_id_chap4_3->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap4_3->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap4_3->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                     <td>
                                                                            <?php if(isset($doc_id_chap4_3->doc_file)): ?>
                                                                         
                                                                               <a href="<?php echo e(url('show-comment/'.$doc_id_chap4_3->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                            <?php endif; ?>
                                                                     </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap4_4->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap4_4->id)==__('arrayfile.document_doc_id_chap4')[4] && get_doccomment_status($doc_id_chap4_4->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap4_4->id)==__('arrayfile.document_doc_id_chap4')[3] && get_doccomment_status($doc_id_chap4_4->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>HR.4</td>
                                                                    <td class="text-justify">
                                                                    The organization shall have appraisal system for its personnel.
                                                                    </td>
                                                                   
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form17"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                            <?php if(isset($doc_id_chap4_4->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>
                                                                            <?php if(isset($doc_id_chap4_4->id)): ?>
                                                                            <?php if(get_doccomment_status(isset($doc_id_chap4_4->id))==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap4_4->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="HR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="HR.4">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap4_4->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap4_4->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap4_4->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>

                                                                    <td>
                                                                            <?php if(isset($doc_id_chap4_4->doc_file)): ?>
                                                                         
                                                                               <a href="<?php echo e(url('show-comment/'.$doc_id_chap4_4->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                            <?php endif; ?>
                                                                     </td>

                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap4_5->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap4_5->id)==__('arrayfile.document_doc_id_chap4')[5] && get_doccomment_status($doc_id_chap4_5->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap4_5->id)==__('arrayfile.document_doc_id_chap4')[5] && get_doccomment_status($doc_id_chap4_5->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>HR.5</td>
                                                                    <td class="text-justify">
                                                                    The organization shall follow a grievance handling mechanism.
                                                                    </td>
                                                                  
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form18"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                            <?php if(isset($doc_id_chap4_5->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>
                                                                            <?php if(isset($doc_id_chap4_5->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap4_5->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap4_5->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="HR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="HR.5">
                                                                            
                                                                        </form>
                                                                    </td>

                                                                    <td>
                                                                            <?php if(isset($doc_id_chap4_5->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap4_5->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap4_5->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                    </td>

                                                                    <td>
                                                                            <?php if(isset($doc_id_chap4_5->doc_file)): ?>
                                                                         
                                                                               <a href="<?php echo e(url('show-comment/'.$doc_id_chap4_5->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                            <?php endif; ?>
                                                                     </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap4_6->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap4_6->id)==__('arrayfile.document_doc_id_chap4')[6] && get_doccomment_status($doc_id_chap4_6->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap4_6->id)==__('arrayfile.document_doc_id_chap4')[6] && get_doccomment_status($doc_id_chap4_6->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>HR.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall adopt measures to prevent the spread of infectious diseases. If applicable.
                                                                    </td>
                                                                   
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form19"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">

                                                                            <?php if(isset($doc_id_chap4_6->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>
                                                                            <?php if(isset($doc_id_chap4_6->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap4_6->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap4_6->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="HR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="HR.6">
                                                                            <td>
                                                                            <?php if(isset($doc_id_chap4_6->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap4_6->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap4_6->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                            </td>
                                                                        </form>
                                                                    </td>

                                                                    <td>
                                                                            <?php if(isset($doc_id_chap4_6->doc_file)): ?>
                                                                         
                                                                               <a href="<?php echo e(url('show-comment/'.$doc_id_chap4_6->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>

                                                                            <?php endif; ?>
                                                                     </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap4_7->doc_file)): ?> highlight   <?php if(get_doc_code($doc_id_chap4_7->id)==__('arrayfile.document_doc_id_chap4')[7] && get_doccomment_status($doc_id_chap4_7->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap4_7->id)==__('arrayfile.document_doc_id_chap4')[7] && get_doccomment_status($doc_id_chap4_7->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>HR.7</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a record of the personnel details like name, age, sex, qualification, designation, experience, training etc.

                                                                    </td>
                                                                  
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form20"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                             <?php if(isset($doc_id_chap4_7->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap4_7->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap4_7->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap4_7->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="HR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="HR.7">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap4_7->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap4_7->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap4_7->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap4_7->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap4_4->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 5- (IR) INFRASTRUCTURE RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr class="<?php if(isset($doc_id_chap5_1->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap5_1->id)==__('arrayfile.document_doc_id_chap5')[1] && get_doccomment_status($doc_id_chap5_1->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap5_1->id)==__('arrayfile.document_doc_id_chap5')[1] && get_doccomment_status($doc_id_chap5_1->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>IR.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall determine and provide infrastructure needed to operate training courses.
                                                                    </td>
                                                                 
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form21"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                             <?php if(isset($doc_id_chap5_1->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap5_1->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap5_1->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap5_1->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="IR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="IR.1">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap5_1->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap5_1->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap5_1->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap5_1->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap5_1->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap5_2->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap5_2->id)==__('arrayfile.document_doc_id_chap5')[2] && get_doccomment_status($doc_id_chap5_2->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap5_2->id)==__('arrayfile.document_doc_id_chap5')[2] && get_doccomment_status($doc_id_chap5_2->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>IR.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall organize for periodic maintenance of infrastructure.
                                                                    </td>
                                                                
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form22"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                             <?php if(isset($doc_id_chap5_2->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap5_2->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap5_2->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap5_2->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="IR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="IR.2">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                         <?php if(isset($doc_id_chap5_2->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap5_2->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap5_2->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap5_2->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap5_2->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap5_3->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap5_3->id)==__('arrayfile.document_doc_id_chap5')[3] && get_doccomment_status($doc_id_chap5_3->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap5_3->id)==__('arrayfile.document_doc_id_chap5')[3] && get_doccomment_status($doc_id_chap5_3->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>IR.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall ensure for periodic calibration of equipment, if required.
                                                                    </td>
                                                                  
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form23"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                             <?php if(isset($doc_id_chap5_3->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap5_3->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap5_3->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap5_3->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="IR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="IR.3">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap5_3->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap5_3->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap5_3->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                    </td>
                                                                     <td>
                                                                        <?php if(isset($doc_id_chap5_3->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap5_3->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 6- (SS) STUDENT SERVICES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr  class="<?php if(isset($doc_id_chap6_1->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap6_1->id)==__('arrayfile.document_doc_id_chap6')[1] && get_doccomment_status($doc_id_chap6_1->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap6_1->id)==__('arrayfile.document_doc_id_chap6')[1] && get_doccomment_status($doc_id_chap6_1->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>SS.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the eligibility requirements for each training course, including prior knowledge needed, if any and make it publicly available without request.
                                                                    </td>
                                                                  
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form24"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap6_1->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap6_1->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap6_1->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap6_1->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="SS">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="SS.1">
                                                                            <td>
                                                                            <?php if(isset($doc_id_chap6_1->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap6_1->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap6_1->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php if(isset($doc_id_chap6_1->id)): ?>
                                                                                <a href="<?php echo e(url('show-comment/'.$doc_id_chap6_1->id)); ?>" 
                                                                                        class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </form>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap6_2->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap6_2->id)==__('arrayfile.document_doc_id_chap6')[2] && get_doccomment_status($doc_id_chap6_2->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap6_2->id)==__('arrayfile.document_doc_id_chap6')[2] && get_doccomment_status($doc_id_chap6_2->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>SS.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have the code of conduct for trainees and shall have a system for addressing any breach of code of conduct.
                                                                    </td>
                                                                 
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form25"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap6_2->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap6_2->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap6_2->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap6_2->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="SS">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="SS.2">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap6_2->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap6_2->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap6_2->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap6_2->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap6_2->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap6_3->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap6_3->id)==__('arrayfile.document_doc_id_chap6')[3] && get_doccomment_status($doc_id_chap6_3->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap6_3->id)==__('arrayfile.document_doc_id_chap6')[3] && get_doccomment_status($doc_id_chap6_3->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>SS.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a system to address any issues related to the trainees
                                                                    </td>
                                                               
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form26"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap6_3->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap6_3->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap6_3->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap6_3->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="SS">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="SS.3">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap6_3->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap6_3->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap6_3->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap6_3->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap6_3->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 7- (CC) COURSE CURRICULUM </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>


                                                                <tr class="<?php if(isset($doc_id_chap7_1->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap7_1->id)==__('arrayfile.document_doc_id_chap7')[1] && get_doccomment_status($doc_id_chap7_1->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap7_1->id)==__('arrayfile.document_doc_id_chap7')[1] && get_doccomment_status($doc_id_chap7_1->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>CC.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall identify the courses it wishes to operate, including courses developed by others.
                                                                    </td>
                                                
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form27"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap7_1->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap7_1->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap7_1->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap7_1->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="CC">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="CC.1">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap7_1->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap7_1->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap7_1->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap7_1->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap7_1->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap7_2->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap7_2->id)==__('arrayfile.document_doc_id_chap7')[2] && get_doccomment_status($doc_id_chap7_2->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap7_2->id)==__('arrayfile.document_doc_id_chap7')[2] && get_doccomment_status($doc_id_chap7_2->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>CC.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have procedure to decide on course content, duration, eligibility etc. for each course that it operates, unless these are decided by an external course
                                                                    provider. In case the courses are designed by the external course provider, the training institution shall ensure that the courses meet all the applicable requirements of this standard.
                                                                    </td>
                                          
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form28"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap7_2->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap7_2->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap7_2->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap7_2->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="CC">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="CC.2">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap7_2->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap7_2->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap7_2->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap7_2->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap7_2->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap7_3->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap7_3->id)==__('arrayfile.document_doc_id_chap7')[3] && get_doccomment_status($doc_id_chap7_3->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap7_3->id)==__('arrayfile.document_doc_id_chap7')[3] && get_doccomment_status($doc_id_chap7_3->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>CC.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the competence of those who develop the courses and if needed take external help to develop courses.
                                                                </td>
                                                              
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form29"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap7_3->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap7_3->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap7_3->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap7_3->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="CC">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="CC.3">
                                                                           
                                                                        </form>
                                                                    </td>
                                                                     <td>
                                                                            <?php if(isset($doc_id_chap7_3->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap7_3->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap7_3->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                         </td>
                                                                     <td>
                                                                        <?php if(isset($doc_id_chap7_3->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap7_3->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap7_4->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap7_4->id)==__('arrayfile.document_doc_id_chap7')[4] && get_doccomment_status($doc_id_chap7_4->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap7_4->id)==__('arrayfile.document_doc_id_chap7')[4] && get_doccomment_status($doc_id_chap7_4->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>CC.4</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have procedure to decide on course content, duration, eligibility etc. for each course that it operates, unless these are decided by an external course
                                                                    provider. In case the courses are designed by the external course provider, the training institution shall ensure that the courses meet all the applicable requirements of this standard.
                                                                    </td>
                                                                
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form30"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap7_4->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap7_4->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap7_4->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap7_4->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="CC">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="CC.4">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap7_4->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap7_4->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap7_4->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                         </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap7_4->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap7_4->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap7_5->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap7_5->id)==__('arrayfile.document_doc_id_chap7')[5] && get_doccomment_status($doc_id_chap7_5->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap7_5->id)==__('arrayfile.document_doc_id_chap7')[5] && get_doccomment_status($doc_id_chap7_5->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>CC.5</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the learning outcome of its training courses. 
                                                                    </td>
                                                    
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form31"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap7_5->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap7_5->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap7_5->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap7_5->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="CC">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="CC.5">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap7_5->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap7_5->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap7_5->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                         </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap7_5->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap7_5->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap7_6->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap7_6->id)==__('arrayfile.document_doc_id_chap7')[6] && get_doccomment_status($doc_id_chap7_6->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap7_6->id)==__('arrayfile.document_doc_id_chap7')[6] && get_doccomment_status($doc_id_chap7_6->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>CC.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall ensure the courses are delivered as designed.
                                                                    </td>
                                                          
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form32"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap7_6->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap7_6->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap7_6->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap7_6->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="CC">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="CC.6">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap7_6->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap7_6->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap7_6->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap7_6->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap7_6->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 8- (EA) EVALUATION AND ASSESSMENT </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap8_1->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap8_1->id)==__('arrayfile.document_doc_id_chap8')[1] && get_doccomment_status($doc_id_chap8_1->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap8_1->id)==__('arrayfile.document_doc_id_chap8')[1] && get_doccomment_status($doc_id_chap8_1->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>EA.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have evaluation at the end of training/year for each course
                                                                    </td>
                                                              
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form33"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap8_1->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap8_1->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap8_1->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap8_1->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="EA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="EA.1">
                                                                            <td>
                                                                           
                                                                        </form>
                                                                    </td>
                                                                     <?php if(isset($doc_id_chap8_1->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap8_1->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap8_1->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                     </td>
                                                                      <td>
                                                                        <?php if(isset($doc_id_chap8_1->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap8_1->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>

                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap8_2->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap8_2->id)==__('arrayfile.document_doc_id_chap8')[2] && get_doccomment_status($doc_id_chap8_2->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap8_2->id)==__('arrayfile.document_doc_id_chap8')[2] && get_doccomment_status($doc_id_chap8_2->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>EA.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the criteria of evaluation for each training course.
                                                                    </td>
                                            
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form34"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap8_2->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap8_2->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap8_2->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap8_2->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="EA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="EA.2">
                                                                           
                                                                        </form>
                                                                    </td>
                                                                     <td>
                                                                            <?php if(isset($doc_id_chap8_2->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap8_2->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap8_2->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap8_2->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap8_2->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>


                                                                <tr class="<?php if(isset($doc_id_chap8_3->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap8_3->id)==__('arrayfile.document_doc_id_chap8')[3] && get_doccomment_status($doc_id_chap8_3->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap8_3->id)==__('arrayfile.document_doc_id_chap8')[3] && get_doccomment_status($doc_id_chap8_3->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>EA.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define the process of evaluation for each training course.
                                                                    </td>
                                           
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form35"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap8_3->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap8_3->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap8_3->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap8_3->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="EA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="EA.3">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap8_3->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap8_3->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap8_3->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap8_3->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap8_3->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>


                                                                <tr class="<?php if(isset($doc_id_chap8_4->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap8_4->id)==__('arrayfile.document_doc_id_chap8')[4] && get_doccomment_status($doc_id_chap8_4->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap8_4->id)==__('arrayfile.document_doc_id_chap8')[4] && get_doccomment_status($doc_id_chap8_4->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>EA.4</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define if the student is not successful in evaluation and if student can appear again
                                                                    without training if yes, how many times.                                                                     </td>
                                         
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form36"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap8_4->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap8_4->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap8_4->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap8_4->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="EA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="EA.4">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap8_4->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap8_4->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap8_4->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                         </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap8_4->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap8_4->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>


                                                                <tr class="<?php if(isset($doc_id_chap8_5->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap8_5->id)==__('arrayfile.document_doc_id_chap8')[5] && get_doccomment_status($doc_id_chap8_5->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap8_5->id)==__('arrayfile.document_doc_id_chap8')[5] && get_doccomment_status($doc_id_chap8_5->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>EA.5</td>
                                                                    <td class="text-justify">
                                                                    The institution defines conditions under which, students Page 36 may be required to repeat the training to be revaluated.
                                                                    </td>
                                                         
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form37"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap8_5->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap8_5->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap8_5->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap8_5->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="EA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="EA.5">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                            <?php if(isset($doc_id_chap8_5->doc_file)): ?>
                                                                         
                                                                               <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap8_5->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap8_5->doc_file); ?></a>

                                                                            <?php endif; ?>
                                                                        </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap8_5->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap8_5->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap8_6->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap8_6->id)==__('arrayfile.document_doc_id_chap8')[6] && get_doccomment_status($doc_id_chap8_6->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap8_6->id)==__('arrayfile.document_doc_id_chap8')[6] && get_doccomment_status($doc_id_chap8_6->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>EA.6</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have an independent process for appeal against the decision on evaluation.
                                                                    </td>
                                                     
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form38"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap8_6->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap8_6->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap8_6->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap8_6->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="EA">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="EA.6">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap8_6->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap8_6->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap8_6->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap8_6->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap8_6->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 9- (LR)- LEARNING RESOURCES </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap9_1->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap9_1->id)==__('arrayfile.document_doc_id_chap9')[1] && get_doccomment_status($doc_id_chap9_1->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap9_1->id)==__('arrayfile.document_doc_id_chap9')[1] && get_doccomment_status($doc_id_chap9_1->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>"> 
                                                                    <td>LR.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall provide information on learning resources – both physical and virtual for self-learning.
                                                                    </td>
                                                     
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form39"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap9_1->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap9_1->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap9_1->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap9_1->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="LR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="LR.1">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap9_1->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap9_1->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap9_1->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php if(isset($doc_id_chap9_1->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap9_1->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap9_2->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap9_2->id)==__('arrayfile.document_doc_id_chap9')[2] && get_doccomment_status($doc_id_chap9_2->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap9_2->id)==__('arrayfile.document_doc_id_chap9')[2] && get_doccomment_status($doc_id_chap9_2->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>LR.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall encourage research, publication, article writing or dissertation work.
                                                                    </td>
                                                                   
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form40"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap9_2->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap9_2->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap9_2->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap9_2->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="LR">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="LR.2">
                                                                           
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap9_2->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap9_2->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap9_2->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap9_2->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap9_2->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th colspan="4">                                                                        
                                                                        <div class="header">
                                                                          <h2 class="text-center">CHAPTER 10- (QI)- QUALITY IMPROVEMENT </h2>
                                                                        </div>
                                                                    </td>                                                                   
                                                              
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap10_1->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap10_1->id)==__('arrayfile.document_doc_id_chap10')[1] && get_doccomment_status($doc_id_chap10_1->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap10_1->id)==__('arrayfile.document_doc_id_chap10')[1] && get_doccomment_status($doc_id_chap10_1->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>QI.1</td>
                                                                    <td class="text-justify">
                                                                    The institution shall establish a monitoring system for quality improvement.
                                                                    </td>
                                                                   
                                                                    <td>
                                                                        <form   name="submitform_doc_form" id="submitform_doc_form41"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap10_1->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap10_1->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap10_1->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap10_1->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="QI">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="QI.1">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap10_1->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap10_1->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap10_1->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap10_1->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap10_1->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap10_2->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap10_2->id)==__('arrayfile.document_doc_id_chap10')[2] && get_doccomment_status($doc_id_chap10_2->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap10_2->id)==__('arrayfile.document_doc_id_chap10')[2] && get_doccomment_status($doc_id_chap10_2->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>QI.2</td>
                                                                    <td class="text-justify">
                                                                    The institution shall define its quality indicators/ learning outcome indicators to promote quality in training.
                                                                    </td>
                                                         
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form42"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap10_2->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap10_2->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap10_2->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap10_2->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="QI">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="QI.2">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap10_2->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap10_2->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap10_2->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                     <td>
                                                                        <?php if(isset($doc_id_chap10_2->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap10_2->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap10_3->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap10_3->id)==__('arrayfile.document_doc_id_chap10')[3] && get_doccomment_status($doc_id_chap10_3->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap10_3->id)==__('arrayfile.document_doc_id_chap10')[3] && get_doccomment_status($doc_id_chap10_3->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>QI.3</td>
                                                                    <td class="text-justify">
                                                                    The institution shall collect feedback from students and other stakeholders and analyze it for improvement of quality.
                                                                    </td>
                                                       
                                                                    <td>
                                                                         <form   name="submitform_doc_form" id="submitform_doc_form43"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap10_3->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap10_3->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap10_3->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap10_3->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>

                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="QI">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="QI.3">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap10_3->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap10_3->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap10_3->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap10_3->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap10_3->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr class="<?php if(isset($doc_id_chap10_4->doc_file)): ?> highlight  <?php if(get_doc_code($doc_id_chap10_4->id)==__('arrayfile.document_doc_id_chap10')[4] && get_doccomment_status($doc_id_chap10_4->id)==1): ?> highlight_nc_approved <?php elseif(get_doc_code($doc_id_chap10_4->id)==__('arrayfile.document_doc_id_chap10')[4] && get_doccomment_status($doc_id_chap10_4->id)==2): ?> highlight_nc <?php endif; ?> <?php endif; ?>">
                                                                    <td>QI.4</td>
                                                                    <td class="text-justify">
                                                                    The institution shall have a system of internal audit annually and address the findings for improvement.
                                                                    </td>
                                                          
                                                                    <td>
                                                                       <form   name="submitform_doc_form" id="submitform_doc_form44"  enctype="multipart/form-data">

                                                                            <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                                            <?php if(isset($doc_id_chap10_4->doc_file)): ?>
                                                                            <?php else: ?>
                                                                            <input type="file"  class="from-control fileup" name="fileup" id="fileup"/><br>
                                                                            <?php endif; ?>

                                                                            <?php if(isset($doc_id_chap10_4->id)): ?>
                                                                            <?php if(get_doccomment_status($doc_id_chap10_4->id)==2): ?>
                                                                     
                                                                            <input type="file"  class="fileup_update" name="fileup_update" id="fileup"/>
                                                                            <input type="hidden"  name="add_doc_id" id="add_doc_id" value="<?php echo e($doc_id_chap10_4->id); ?>" />
                                                                            <?php endif; ?>
                                                                            <?php endif; ?>


                                                                            <input type="hidden" id="course_id" name="course_id" value="<?php echo e($course_id); ?>">
                                                                            <input type="hidden" class="section_id" name="section_id" value="QI">
                                                                            <input type="hidden" class="doc_id" id="doc_id_1" name="doc_id" value="QI.4">
                                                                            
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap10_4->doc_file)): ?>
                                                                     
                                                                           <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$doc_id_chap10_4->doc_file)); ?>" title="Fee Structure PDF"><?php echo e($doc_id_chap10_4->doc_file); ?></a>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if(isset($doc_id_chap10_4->id)): ?>
                                                                        <a href="<?php echo e(url('show-comment/'.$doc_id_chap10_4->id)); ?>" 
                                                                                class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Comments</a>
                                                                        <?php endif; ?>
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
   $('.fileup').on('change',function(e){
           e.preventDefault();
           
           let sbformId = $(this).closest("form").attr('id');
           let formData = new FormData(document.getElementById(sbformId));
           console.log(formData);
           formData.append('fileup', $('input[type=file]').val().split('\\').pop()); 

           //formData.append('fileup', $('input[type=file]').val().split('\\').pop()); 
           $("#success-msg").removeClass('d-none');
           $("#loader").removeClass('d-none');
           var data ="<?php echo e(url(Request::url())); ?>";
           //alert(data);
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

           $.ajax({

            url: " <?php echo e(url('add-courses')); ?>",
            type: "POST",
            data: formData,
            processData:false,
            contentType: false,
            enctype: 'multipart/form-data',
            
            

            success: function (response) {
                $("#loader").addClass('d-none');
                //$("#success-msg").addClass('d-none');
                alert("Document Added Successfully");
                window.location.href= "<?php echo e(url(Request::url())); ?>";
                //$("#mydiv").load(location.href + " #mydiv");
              
                
            }
        });
     });
</script>

<script>
  $('.fileup_update').on('change',function(e){
           e.preventDefault();
           
           let sbformId = $(this).closest("form").attr('id');
           let formData = new FormData(document.getElementById(sbformId));
           console.log(formData);
           formData.append('fileup', $('input[type=file]').val().split('\\').pop()); 

           //formData.append('fileup', $('input[type=file]').val().split('\\').pop()); 
           $("#success-msg").removeClass('d-none');
           $("#loader").removeClass('d-none');
           var data ="<?php echo e(url(Request::url())); ?>";
           //alert(data);
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

           $.ajax({

            url: " <?php echo e(url('add-courses')); ?>",
            type: "POST",
            data: formData,
            processData:false,
            contentType: false,
            enctype: 'multipart/form-data',
            
            

            success: function (response) {
                $("#loader").addClass('d-none');
                //$("#success-msg").addClass('d-none');
                alert("Document Updated Successfully");
                window.location.href= "<?php echo e(url(Request::url())); ?>";
                //$("#mydiv").load(location.href + " #mydiv");
              
                
            }
        });
     });
</script>      

    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp\htdocs\atab\resources\views/level/upload_document.blade.php ENDPATH**/ ?>