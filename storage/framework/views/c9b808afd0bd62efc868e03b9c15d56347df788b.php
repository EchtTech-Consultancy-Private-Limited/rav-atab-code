 <?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

 <style>
     @media (min-width: 900px) {
         .modal-dialog {
             max-width: 674px;
         }
     }

     .mr-2 {
         margin-right: 10px;
     }

     .form-group {
    margin-bottom: 10px;
}

.card{
    margin-bottom: 12px;
}
div#ui-datepicker-div {
    background: #fff;
/*    padding: 12px 15px 5px;*/
    border-radius: 10px;
    width: 310px;
    box-shadow: 0 5px 5px 0 rgba(44, 44, 44, 0.2);
}

.ui-datepicker-header.ui-widget-header.ui-helper-clearfix.ui-corner-all {
    display: flex;
    justify-content: space-between;
}

.payment-status.d-flex {
    align-items: center;
    width: 250px;
}

 </style>




 <title>RAV Accreditation</title>

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
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                         <ul class="breadcrumb breadcrumb-style ">
                             <li class="breadcrumb-item">
                                 <h4 class="page-title">

                                    Manage Applications


                                 </h4>

                             </li>
                             <li class="breadcrumb-item bcrumb-1">
                                 <a href="<?php echo e(url('/dashboard')); ?>">
                                     <i class="fas fa-home"></i> Home</a>
                             </li>
                             <li class="breadcrumb-item active">


                                <?php if(request()->path() == 'level-first'): ?>

                                Level First

                                <?php elseif(request()->path() == 'level-second'): ?>

                                Level Second

                                <?php elseif(request()->path() == 'level-third'): ?>

                                Level Third

                                <?php elseif(request()->path() == 'level-fourth'): ?>

                                Level Fourth

                                <?php endif; ?>

                             </li>
                         </ul>
                     </div>
                 </div>
             </div>

             <div class="row clearfix">
                 <div class="col-lg-12 col-md-12">
                     <div class="card">
                         <div class="profile-tab-box">
                             <div class="p-l-20">
                                 <ul class="nav ">
                                     <li class="nav-item tab-all">
                                         <a class="nav-link show" href="#general_information"
                                             data-bs-toggle="tab">General Information</a>
                                     </li>
                                     <li class="nav-item tab-all p-l-20">
                                         <a class="nav-link active" href="#new_application" data-bs-toggle="tab">New
                                             Application</a>
                                     </li>
                                     <li class="nav-item tab-all p-l-20">
                                         <a class="nav-link" href="#preveious_application" data-bs-toggle="tab">Previous
                                             Applications</a>
                                     </li>
                                     <li class="nav-item tab-all p-l-20">
                                         <a class="nav-link" href="#faqs" data-bs-toggle="tab">FAQs</a>
                                     </li>
                                 </ul>
                             </div>
                         </div>
                     </div>
                     <?php if(Session::has('success')): ?>
                         <div class="alert alert-success" style="padding: 15px;" role="alert">
                             <?php echo e(session::get('success')); ?>

                         </div>
                     <?php elseif(Session::has('fail')): ?>
                         <div class="alert alert-danger" role="alert">
                             <?php echo e(session::get('fail')); ?>

                         </div>
                     <?php endif; ?>

                      <?php if(count($errors) > 0): ?>
                          <div class="alert alert-danger">
                             <ul>
                               <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <li><?php echo e($error); ?></li>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                          </div>
                        <?php endif; ?>



                     <div class="tab-content">
                         <div role="tabpanel" class="tab-pane" id="general_information" aria-expanded="true">
                             <div class="row clearfix">
                                 <div class="col-lg-12 col-md-12 col-sm-12">
                                     <div class="card project_widget">
                                         <div class="header">
                                         </div>
                                         <div class="body">
                                             <div class="row">
                                                 <div class="col-md-4 col-6 b-r">
                                                     <h5> <strong>Validity </strong></h5>
                                                     <p class="text-muted"><?php echo e($item[0]->validity); ?></p>
                                                 </div>
                                                 <div class="col-md-4 col-6 b-r">
                                                     <h5> <strong>Fee Structure </strong></h5>
                                                     <p class="text-muted"><?php echo e($item[0]->fee_structure); ?></p><br>

                                                     <?php if($item[0]->Fee_Structure_pdf != ""): ?>

                                                     <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$item[0]->Fee_Structure_pdf)); ?>"
                                                         title="level Information pdf"><i
                                                             class="fa fa-download mr-2"></i> PDF Fee Structure pdf</a>




                                                     <?php endif; ?>


                                                     <br>
                                                 </div>
                                                 <div class="col-md-4 col-6 b-r">
                                                     <h5> <strong>Timelines </strong></h5>
                                                     <p class="text-muted"> <?php echo e($item[0]->timelines); ?></p>
                                                 </div>
                                             </div>
                                             <br>
                                             <h5>Level Information</h5>
                                             <p><?php echo e($item[0]->level_Information); ?></p><br>

                                             <?php if($item[0]->level_Information_pdf != ""): ?>

                                             <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$item[0]->level_Information_pdf)); ?>"
                                                 title="level Information pdf"><i
                                                     class="fa fa-download mr-2"></i> PDF level Information pdf </a>

                                              <?php endif; ?>

                                             <br><br>
                                             <h5>Prerequisites</h5>
                                             <p><?php echo e($item[0]->Prerequisites); ?></p><br>

                                             <br>

                                             <?php if($item[0]->Prerequisites_pdf != ""): ?>

                                             <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$item[0]->Prerequisites_pdf)); ?>"
                                                 title="level Information pdf"><i
                                                     class="fa fa-download mr-2"></i> PDF Prerequisites pdf </a>

                                            <?php endif; ?>

                                            <br>


                                             <br>
                                             <h5>Documents Required</h5>
                                             <p><?php echo e($item[0]->documents_required); ?></p><br>
                                             <br>

                                             <?php if($item[0]->documents_required_pdf != ""): ?>

                                             <a target="_blank" href="<?php echo e(url('show-pdf'.'/'.$item[0]->documents_required_pdf)); ?>"
                                                  title="level Information pdf"><i
                                                      class="fa fa-download mr-2"></i> PDF Documents Required pdf </a>

                                             <?php endif; ?>


                                             <br>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <!-- <div role="tabpanel" class="tab-pane" id="timeline" aria-expanded="false">
                                        </div> -->
                         <div role="tabpanel" class="tab-pane active" id="new_application" aria-expanded="false">


                         
                             <div class="tab-content p-relative">

                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <li class="progress1 bg_green">Basic Information</li>
                                    <li class="progress2">Level Courses</li>
                                    <li class="progress3">Payment</li>
                                </ul>

                                 <div class="tab-pane active" role="tabpanel" id="step1">
                                     <div class="card">
                                         <div class="header">
                                             <h2>Basic Information</h2>
                                         </div>
                                         <div class="body">
                                             <div class="row clearfix">
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Title</strong></label><br>
                                                             <label><?php echo e($data->title ??''); ?></label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                  <div class="col-sm-3">
                                                   <div class="form-group">
                                                        <div class="form-line">
                                                           <label><strong> Name </strong></label><br>
                                                            <?php echo e($data->firstname ??''); ?> <?php echo e($data->middlename ??''); ?> <?php echo e($data->lastname ??''); ?>

                                                        </div>
                                                     </div>
                                                  </div>
                                                   <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Organization/Institute Name
                                                                     </strong></label><br>
                                                             <label><?php echo e($data->organization ?? ''); ?></label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Email</strong></label><br>
                                                             <label><?php echo e($data->email ?? ''); ?></label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Mobile Number</strong></label><br>
                                                             <label><?php echo e($data->mobile_no ?? ''); ?></label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Designation</strong></label><br>
                                                             <label><?php echo e($data->designation ?? ''); ?></label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <div class="form-group">
                                                                 <div class="form-line">
                                                                     <label><strong>Country</strong></label><br>
                                                                     <label><?php echo e($data->country_name ?? ''); ?></label>
                                                                     <input type="hidden" id="Country"
                                                                         value="<?php echo e($data->country ?? ''); ?>">
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>State</strong></label><br>
                                                             <label><?php echo e($data->state_name ?? ''); ?></label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>City</strong></label><br>
                                                             <label><?php echo e($data->city_name ?? ''); ?></label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Postal Code</strong></label><br>
                                                             <label><?php echo e($data->postal ?? ''); ?></label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Address</strong></label><br>
                                                             <label><?php echo e($data->address ?? ''); ?></label>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 
                                             </div>
                                             <!-- Form  -->
                                             <div class="row">
                                                 <div class="header">
                                                     <h2>Single Point of Contact Details (SPoC)</h2>
                                                 </div>

                                                 <div class="col-md-12">
                                                    
                                                    <form class="form" id="regForm">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="body pb-0">
                                                            <!-- level start -->
                                                            <div class="row clearfix">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Person Name<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="Person_Name"
                                                                                placeholder="Person Name" class="preventnumeric" id="person_name"
                                                                                <?php if(isset($id)): ?>
                                                                                value="<?php echo e($Application->Person_Name ?? ''); ?>"
                                                                                <?php endif; ?>
                                                                                required maxlength="30">
                                                                                <span class="text-danger" id="person_error"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <input type="hidden" name="user_id"
                                                                    value="<?php echo e(Auth::user()->id); ?>">
                                                                <input type="hidden" name="state_id"
                                                                    value="<?php echo e(Auth::user()->state); ?>">
                                                                <input type="hidden" name="country_id"
                                                                    value="<?php echo e(Auth::user()->country); ?>">
                                                                <input type="hidden" name="city_id"
                                                                    value="<?php echo e(Auth::user()->city); ?>">

                                                                <?php if(request()->path() == 'level-first'): ?>
                                                                    <input type="hidden" placeholder="level_id"
                                                                        name="level_id" id="level_id"
                                                                        value="<?php echo e(1); ?>">
                                                                <?php elseif(request()->path() == 'level-second'): ?>
                                                                    <input type="hidden" placeholder="level_id"
                                                                        name="level_id" id="level_id"
                                                                        value="<?php echo e(2); ?>">
                                                                <?php elseif(request()->path() == 'level-third'): ?>
                                                                    <input type="hidden" placeholder="level_id"
                                                                        name="level_id" id="level_id"
                                                                        value="<?php echo e(3); ?>">
                                                                <?php elseif(request()->path() == 'level-fourth'): ?>
                                                                    <input type="hidden" placeholder="level_id"
                                                                        name="level_id" id="level_id"
                                                                        value="<?php echo e(4); ?>">
                                                                <?php endif; ?>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Contact Number<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" required="required"
                                                                                name="Contact_Number" class="preventalpha" 
                                                                                placeholder="Contact Number" id="Contact_Number" 
                                                                                <?php if(isset($id)): ?>
                                                                                value="<?php echo e($Application->Contact_Number ?? ''); ?>"
                                                                                <?php endif; ?> >
                                                                        </div>
                                                                        <span class="text-danger" id="contact_error"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Email-ID<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text"  name="Email_ID"
                                                                                placeholder="Email-ID"
                                                                                <?php if(isset($id)): ?>
                                                                                 value="<?php echo e($Application->Email_ID ?? ''); ?>"
                                                                                 <?php endif; ?>
                                                                                >
                                                                        </div>
                                                                        <span class="text-danger" id="email_id_error"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <label>Designation<span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text"  name="designation"
                                                                                placeholder="Designation"
                                                                                <?php if(isset($id)): ?>
                                                                                 value="<?php echo e($Application->designation ?? ''); ?>"
                                                                                 <?php endif; ?>
                                                                                >
                                                                        </div>
                                                                        <span class="text-danger" id="designation_error"></span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                </div>
                                            </div>
                                            <!-- basic end -->
                                                    <ul class="list-inline pull-right">


                                                 <?php if( request()->path() ==  'level-first'): ?>
                                                        <li><button type="submit" class="btn btn-info mr-2 save">Save
                                                        </button></li>
                                                 <?php else: ?>
                                                        <li><button type="button" class="btn btn-primary next-step">
                                                                Next</button></li>
                                                <?php endif; ?>

                                                    </ul>
                                            </form>


                                         </div>
                                     </div>
                                 </div>
                                 <div class="tab-pane" role="tabpanel" id="step2">
                                     <div class="card">
                                         <div class="header mb-4">
                                             <h2 style="float:left; clear:none;">Level Courses</h2>
                                             
                                             
                                             <a href="javascript:void();" class="btn btn-outline-primary mb-0"
                                                 style="float:right; clear:none; cursor:pointer;line-height: 24px;"
                                                 onclick="add_new_course();"
                                                 <?php if(request()->path() == 'level-first'): ?> id="count" <?php elseif(request()->path() == 'level-second'): ?> id="count_second" <?php endif; ?>>
                                                 <i class="fa fa-plus font-14"></i> Add More Course</a>
                                             
                                         </div>

                                         <form action="<?php echo e(url('/new-application-course')); ?>"
                                             enctype="multipart/form-data" method="post" class="form"
                                             id="regForm">
                                             <?php echo csrf_field(); ?>
                                             <div class="body pb-0" id="courses_body">
                                                 <!-- level start -->
                                                 <div class="row clearfix">
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Name<span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="text" placeholder="Course Name"
                                                                     name="course_name[]"  required class="preventnumeric" maxlength="50">
                                                             </div>
                                                             <?php $__errorArgs = ['course_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <div class="alert alert-danger"><?php echo e($message); ?>

                                                                 </div>
                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </div>
                                                     </div>



                                                   

                                                     <input type="hidden" name="application"  class="content_id" readonly>

                                                     <input type="hidden" name="application_id"   value="<?php echo e($collections->id ?? ''); ?>"  class="form-control" readonly>

                                                 <input type="hidden" placeholder="level_id"   name="level_id" value="<?php echo e(1); ?>">

                                                     <input type="hidden" name="coutry"
                                                         value=" <?php echo e($data->country ??''); ?>">
                                                     <input type="hidden" name="state"
                                                         value=" <?php echo e($data->state ??''); ?>">

                                                     <div class="col-sm-4">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Duration<span class="text-danger">*</span></label>

                                                                 <!-- <input type="number" placeholder="Course Duration"
                                                                     name="course_duration[]" required> -->
                                                                    <div class="course_group">
                                                                        <input type="number" placeholder="Years" name="years[]" required class="course_input">
                                                                         <input type="number" placeholder="Months" name="months[]" required class="course_input">
                                                                         <input type="number" placeholder="Days" name="days[]" required class="course_input">
                                                                         <input type="number" placeholder="Hours" name="hours[]" required class="course_input">
                                                                     </div>
                                                             </div>
                                                             <?php $__errorArgs = ['course_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <div class="alert alert-danger"><?php echo e($message); ?>

                                                                 </div>
                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </div>
                                                     </div>
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Eligibility<span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="text" placeholder="Eligibility"
                                                                     name="eligibility[]" required id="eligibility">
                                                             </div>
                                                             <?php $__errorArgs = ['eligibility'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <div class="alert alert-danger"><?php echo e($message); ?>

                                                                 </div>
                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </div>
                                                     </div>
                                                     <div class="col-sm-2">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Mode of Course <span
                                                                         class="text-danger">*</span></label>
                                                                 <select class="form-control" name="mode_of_course[]"
                                                                     required multiple="">
                                                                     <option value="" SELECTED>Select Mode
                                                                     </option>
                                                                     <option value="Online">Online</option>
                                                                     <option value="Offline">Offline</option>
                                                                 </select>
                                                             </div>
                                                             <?php $__errorArgs = ['mode_of_course'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <div class="alert alert-danger"><?php echo e($message); ?>

                                                                 </div>
                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </div>
                                                     </div>
                                                     <div class="col-sm-12">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Brief <span
                                                                         class="text-danger">*</span></label>
                                                                 <!-- <input type="text" placeholder="Course Brief"
                                                                     name="course_brief[]" required> -->
                                                                <textarea rows="4" cols="50" class="form-control" placeholder="Course Brief" name="course_brief[]"></textarea>
                                                            </div>
                                                             <?php $__errorArgs = ['course_brief'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <div class="alert alert-danger"><?php echo e($message); ?>

                                                                 </div>
                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </div>
                                                     </div>
                                                 <!-- </div>

                                                 <div class="row clearfix"> -->
                                                     

                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Declaration (PDF)<span
                                                                         class="text-danger">*</span></label>

                                                                 <input type="file" name="doc1[]"
                                                                     id="payment_reference_no" required
                                                                     class="form-control doc_1">
                                                             </div>

                                                             
                                                         </div>
                                                     </div>

                                                     <div class="col-sm-4">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course  Curriculum / Material / Syllabus (PDF)<span
                                                                         class="text-danger">*</span></label>

                                                                <input type="file" name="doc2[]"
                                                                     id="payment_reference_no"  required
                                                                     class="form-control doc_2"> 

                                                                     
                                                             </div>

                                                             
                                                         </div>
                                                     </div>

                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Details  (Excel format)<span
                                                                         class="text-danger">*</span></label>



                                                                 <input type="file" name="doc3[]"
                                                                     id="payment_reference_no" required
                                                                     class="form-control doc_3">
                                                             </div>

                                                             
                                                         </div>
                                                     </div>

                                                     <?php if(request()->path() == 'level-first'): ?>
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="<?php echo e(1); ?>">
                                                     <?php elseif(request()->path() == 'level-second'): ?>
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="<?php echo e(2); ?>">
                                                     <?php elseif(request()->path() == 'level-third'): ?>
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="<?php echo e(3); ?>">
                                                     <?php elseif(request()->path() == 'level-fourth'): ?>
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="<?php echo e(4); ?>">
                                                     <?php endif; ?>


                                                     <!-- payment end -->
                                                 </div>



                                                 <?php if(request()->path() == 'level-first'): ?>
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="<?php echo e(1); ?>">
                                                 <?php elseif(request()->path() == 'level-second'): ?>
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="<?php echo e(2); ?>">
                                                 <?php elseif(request()->path() == 'level-third'): ?>
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="<?php echo e(3); ?>">
                                                 <?php elseif(request()->path() == 'level-fourth'): ?>
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="<?php echo e(4); ?>">
                                                 <?php endif; ?>
                                                 <!-- level end -->
                                             </div>

                                             
                                             <div class="center">
                                                 <button class="btn btn-primary waves-effect m-r-15 add_course">Save</button>
                                             </div>
                                             
                                         </form>
                                         <div class="body mt-5">
                                             <div class="table-responsive">
                                                 <table class="table table-hover js-basic-example contact_list">
                                                     <thead>
                                                         <tr>
                                                             <th class="center">S.No.</th>
                                                             <th class="center"> Course Name </th>
                                                             <th class="center"> Course Duration </th>
                                                             <th class="center"> Eligibility </th>
                                                             <th class="center"> Mode Of Course </th>
                                                             <th class="center"> Course Brief</th>
                                                             <th class="center">Payment Status</th>
                                                             <!-- <th class="center">Valid From</th>
                                                             <th class="center">Valid To </th> -->
                                                             <th class="center" >Action</th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>


                                                        <?php if(isset($course)): ?>

                                                         <?php $__currentLoopData = $course; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $courses): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                             <tr class="odd gradeX">
                                                                 <td class="center"><?php echo e($k + 1); ?></td>
                                                                 <td class="center"><?php echo e($courses->course_name); ?>

                                                                 </td>

                                                                <td class="center">
                                                                    years:<?php echo e($courses->years); ?>,
                                                                    Months: <?php echo e($courses->months); ?>,
                                                                    days: <?php echo e($courses->days); ?>,
                                                                    Hours: <?php echo e($courses->hours); ?>


                                                                </td>
                                                                 <td class="center"><?php echo e($courses->eligibility); ?>

                                                                 </td>
                                                                <td class="center">
                                                                    <!-- <?php echo e($courses->id); ?> -->
                                                                    <?php echo get_course_mode($courses->id); ?>
                                                                  
                                                                </td>
                                                                 <td class="center"><?php echo e($courses->course_brief); ?>

                                                                 </td>
                                                                 <td class="center"><?php if($courses->payment=="false"): ?> Not Done <?php endif; ?></td>
                                                                 <!-- <td class="center">
                                                                     <?php echo e(date('d F Y', strtotime($courses->created_at))); ?>

                                                                 </td>
                                                                 <td class="center">
                                                                     <?php echo e(date('d F Y', strtotime($courses->created_at->addYear()))); ?>

                                                                 </td> -->
                                                                 <td class="center btn-ved">
                                                                     <a class="btn btn-tbl-delete bg-primary"
                                                                         data-bs-toggle="modal"
                                                                         data-id='<?php echo e($courses->id); ?>'
                                                                         data-bs-target="#View_popup" id="view">
                                                                         <i class="fa fa-eye"></i>
                                                                     </a>

                                                                     <?php if($courses->payment == 'false'): ?>
                                                                         <a href="#" data-bs-toggle="modal"
                                                                             data-id="<?php echo e($courses->id); ?>"
                                                                             data-bs-target="#edit_popup"
                                                                             id="edit_course"
                                                                             class="btn btn-tbl-delete bg-primary">
                                                                             <i class="material-icons">edit</i>
                                                                         </a>
                                                                     <?php endif; ?>


                                                                     <a href="<?php echo e(url('/delete-course' . '/' . dEncrypt($courses->id))); ?>"
                                                                         class="btn btn-tbl-delete bg-danger">
                                                                         <i class="material-icons">delete</i>
                                                                     </a>
                                                                 </td>
                                                             </tr>
                                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                         <?php endif; ?>
                                                     </tbody>
                                                 </table>
                                             </div>
                                         </div>

                                         <div id="add_courses" style="Display:none" class="faqs-row' + faqs_row + '">
                                             <div class="row clearfix">
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course Name<span
                                                                     class="text-danger">*</span></label>
                                                             <input type="text" placeholder="Course Name"
                                                                 name="course_name[]" required>
                                                         </div>
                                                         <?php $__errorArgs = ['course_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                             <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                         <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                     </div>
                                                 </div>



                                             

                                             <input type="hidden" name="application_id" value="<?php echo e($collections->id ?? ''); ?>"  class="form-control" readonly>

                                             <input type="hidden" placeholder="level_id"   name="level_id[]" value="<?php echo e(1); ?>">



                                                 <div class="col-sm-4">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course Duration<span class="text-danger">*</span>
                                                                    </label>
                                                             <!-- <input type="number" placeholder="Course Duration"
                                                                 name="course_duration[]" required> -->

                                                                 <div class="course_group">
                                                                    <input type="number" placeholder="Years" name="years[]" required class="course_input">
                                                                     <input type="number" placeholder="Months" name="months[]" required class="course_input">
                                                                     <input type="number" placeholder="Days"  name="days[]" required class="course_input">
                                                                     <input type="number" placeholder="Hours" name="hours[]"  required class="course_input">
                                                                     </div>
                                                         </div>
                                                         <?php $__errorArgs = ['course_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                             <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                         <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Eligibility<span
                                                                     class="text-danger">*</span></label>
                                                             <input type="text" placeholder="Eligibility"
                                                                 name="eligibility[]" required>
                                                         </div>
                                                         <?php $__errorArgs = ['eligibility'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                             <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                         <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-2">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Mode of Course <span
                                                                     class="text-danger">*</span></label>
                                                                      <div class="form-group default-select select2Style">
                                                             <select class="form-control select2 width" name="mode_of_course[]"
                                                                 required>
                                                                 <option value="" SELECTED>Select Mode
                                                                 </option>
                                                                 <option value="Online">Online</option>
                                                                 <option value="Offline">Offline</option>
                                                             </select>
                                                         </div>
                                                         </div>
                                                         <?php $__errorArgs = ['mode_of_course'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                             <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                         <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                     </div>
                                                 </div>
                                                 <?php if(request()->path() == 'level-first'): ?>
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="<?php echo e(1); ?>">
                                                 <?php elseif(request()->path() == 'level-second'): ?>
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="<?php echo e(2); ?>">
                                                 <?php elseif(request()->path() == 'level-third'): ?>
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="<?php echo e(3); ?>">
                                                 <?php elseif(request()->path() == 'level-fourth'): ?>
                                                     <input type="hidden" placeholder="level_id" name="level_id"
                                                         value="<?php echo e(4); ?>">
                                                 <?php endif; ?>
                                                 <!-- <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course Brief <span
                                                                     class="text-danger">*</span></label>
                                                             <input type="text" placeholder="Course Brief"
                                                                 name="course_brief[]" required>
                                                         </div>
                                                         <?php $__errorArgs = ['course_brief'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                             <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                         <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                     </div>
                                                 </div> -->

                                                 <div class="col-sm-12">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Brief <span
                                                                         class="text-danger">*</span></label>
                                                                 <!-- <input type="text" placeholder="Course Brief"
                                                                     name="course_brief[]" required> -->
                                                                <textarea rows="4" cols="50" class="form-control" placeholder="Course Brief" name="course_brief[]"></textarea>
                                                            </div>
                                                             <?php $__errorArgs = ['course_brief'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <div class="alert alert-danger"><?php echo e($message); ?>

                                                                 </div>
                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </div>
                                                     </div>

                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Declaration<span
                                                                     class="text-danger">*</span></label>



                                                             <input type="file" name="doc1[]"
                                                                 id="payment_reference_no" required
                                                                 class="form-control">
                                                         </div>

                                                         <label for="payment_reference_no"
                                                             id="payment_reference_no-error" class="error">
                                                             <?php $__errorArgs = ['payment_reference_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <?php echo e($message); ?>

                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </label>
                                                     </div>
                                                 </div>

                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course  Curriculum / Material / Syllabus <span
                                                                     class="text-danger">*</span></label>



                                                             <input type="file" name="doc2[]"
                                                                 id="payment_reference_no" required
                                                                 class="form-control">
                                                         </div>

                                                         <label for="payment_reference_no"
                                                             id="payment_reference_no-error" class="error">
                                                             <?php $__errorArgs = ['payment_reference_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <?php echo e($message); ?>

                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </label>
                                                     </div>
                                                 </div>

                                                 <div class="col-sm-3">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course Details (Excel format) <span
                                                                     class="text-danger">*</span></label>


                                                             <input type="file" name="doc3[]"
                                                                 id="payment_reference_no" required
                                                                 class="form-control">
                                                         </div>

                                                         <label for="payment_reference_no"
                                                             id="payment_reference_no-error" class="error">
                                                             <?php $__errorArgs = ['payment_reference_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <?php echo e($message); ?>

                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </label>
                                                     </div>
                                                 </div>

                                               </div>
                                         </div>

                                         <ul class="list-inline pull-right mt-5">
                                             <li><button type="button"
                                                     class="btn btn-danger prev-step">Previous</button>
                                             </li>
                                             <li><button type="button"
                                                     class="btn btn-primary next-step1">Next</button></li>
                                         </ul>
                                     </div>
                                 </div>

                                 <div class="tab-pane" role="tabpanel" id="step3">
                                     <div class="card">
                                         <div class="header">
                                             <h2 style="float:left; clear:none;">Payment</h2>
                                             <h6 style="float:right; clear:none;" id="counter">
                                                 <?php if(isset($total_amount)): ?>
                                                     Total Amount: <?php echo e($currency); ?> <?php echo e($total_amount); ?>

                                                 <?php endif; ?>
                                                 </h2>
                                         </div>
                                         <div class="body">
                                             <div class="form-group">
                                                 <div class="form-line">
                                                     <label>Payment Mode<span class="text-danger">*</span></label>
                                                     <select name="payment" class="form-control" id="payments">
                                                         <option value="">Select Option</option>
                                                         <option value="QR-Code"
                                                             <?php echo e(old('QR-Code') == 'QR-Code' ? 'selected' : ''); ?>>QR
                                                             Code
                                                         </option>
                                                         <option value="Bank"
                                                             <?php echo e(old('title') == 'Bank' ? 'selected' : ''); ?>>Bank
                                                             Transfers
                                                         </option>
                                                     </select>
                                                 </div>
                                             </div>
                                             <!-- payment start -->
                                             <div style="text-align:center; width:100%;" id="QR">
                                                 <div
                                                     style="width:100px; height:100px; border:1px solid #ccc; float:right;">
                                                     <img src="<?php echo e(asset('/assets/images/demo-qrcode.png')); ?>"
                                                         width="100" height="100">
                                                 </div>
                                             </div>
                                             <div class="row clearfix" id="bank_id">
                                                 <div class="col-sm-2">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label><strong>Bank Name</strong></label>
                                                             <p>Punjab National Bank</p>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label> <strong>Branch Name</strong> </label>
                                                            <p>Main Market, Punjabi Bagh, New Delhi</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <label> <strong>IFSC Code</strong> </label>
                                                            <p>PUNB00987</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="col-sm-2">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label> <strong>Accounts Number</strong> </label>
                                                             <p>112233234400987</p>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-2">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label> <strong>CIF</strong> </label>
                                                             <p>112233234400987</p>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="col-sm-2">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label> <strong>MICR Number</strong> </label>
                                                             <p>112233234400987</p>
                                                         </div>
                                                     </div>
                                                 </div>


                                             </div>


                                            <form action="<?php echo e(url('/new-application_payment')); ?>" method="post"
                                                 class="form" id="regForm" enctype="multipart/form-data">
                                                 <?php echo csrf_field(); ?>
                                                 <div class="row clearfix">
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                <label>Payment Date <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="payment_date"
                                                                    class="form-control" id="payment_date" required
                                                                    placeholder="Payment Date "aria-label="Date"
                                                                    value="<?php echo e(old('payment_date')); ?>"
                                                                    onfocus="focused(this)"
                                                                    onfocusout="defocused(this)">
                                                             </div>
                                                             <label for="payment_date" id="payment_date-error"
                                                                 class="error">
                                                                 <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                     <?php echo e($message); ?>

                                                                 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                             </label>
                                                         </div>
                                                     </div>
                                                     <input type='hidden' name="amount"
                                                      <?php if(isset($total_amount)): ?>
                                                      value="<?php echo e($total_amount); ?>"
                                                      <?php endif; ?>  >
                                                     <input type='hidden' name="course_count"
                                                     <?php if(isset($course)): ?>
                                                     value="<?php echo e(count($course)); ?>">
                                                     <?php endif; ?>

                                                     <input type='hidden' name="currency"
                                                       <?php if(isset($currency)): ?>
                                                       value="<?php echo e($currency); ?>"
                                                       <?php endif; ?>   >



                                                       <?php if(isset($course)): ?>

                                                       <?php $__currentLoopData = $course; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $courses): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                       <input type='hidden' name="course_id[]"
                                                           value="<?php echo e($courses->id); ?>">
                                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




                                                       <?php endif; ?>




                                                     <?php if(request()->path() == 'level-first'): ?>
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="<?php echo e(1); ?>">
                                                     <?php elseif(request()->path() == 'level-second'): ?>
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="<?php echo e(2); ?>">
                                                     <?php elseif(request()->path() == 'level-third'): ?>
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="<?php echo e(3); ?>">
                                                     <?php elseif(request()->path() == 'level-fourth'): ?>
                                                         <input type="hidden" placeholder="level_id" name="level_id"
                                                             value="<?php echo e(4); ?>">
                                                     <?php endif; ?>
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label for="payment_transaction_no">Payment
                                                                     Transaction
                                                                     no. <span class="text-danger">*</span></label>
                                                                 <input type="text"
                                                                     placeholder="Payment Transaction no."
                                                                     id="payment_transaction_no" required
                                                                     name="payment_transaction_no" minlength="9"
                                                                     maxlength="18"
                                                                     value="<?php echo e(old('payment_transaction_no')); ?>">
                                                             </div>
                                                             <label for="payment_transaction_no"
                                                                 id="payment_transaction_no-error" class="error">
                                                                 <?php $__errorArgs = ['payment_transaction_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                     <?php echo e($message); ?>

                                                                 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                             </label>
                                                         </div>
                                                     </div>
                                                     <input type="hidden" name="coutry"
                                                         value=" <?php echo e($data->country ??''); ?>">
                                                     <input type="hidden" name="state"
                                                         value=" <?php echo e($data->state  ??''); ?>">
                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Payment Reference no. <span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="text" required
                                                                     placeholder="Payment Reference no."
                                                                     name="payment_reference_no" minlength="9"
                                                                     maxlength="18"
                                                                     value="<?php echo e(old('payment_reference_no')); ?>">
                                                             </div>
                                                             <label for="payment_reference_no"
                                                                 id="payment_reference_no-error" class="error">
                                                                 <?php $__errorArgs = ['payment_reference_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                     <?php echo e($message); ?>

                                                                 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                             </label>
                                                         </div>
                                                     </div>

                                                     <input type="hidden" value="<?php echo e($collections->id ?? ''); ?>"
                                                     name="Application_id" required class="course_input">

                                                    <input type="hidden" placeholder="level_id"
                                                     value="<?php echo e($collections->level_id ?? ''); ?>" name="level_id"
                                                     value="<?php echo e(1); ?>">




                                                     <div class="col-sm-3">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Payment Screenshot <span
                                                                         class="text-danger">*</span></label>
                                                                 <input type="file" name="payment_details_file"
                                                                     id="payment_reference_no" required
                                                                     class="form-control">
                                                             </div>
                                                             <label for="payment_reference_no"
                                                                 id="payment_reference_no-error" class="error">
                                                                 <?php $__errorArgs = ['payment_reference_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                     <?php echo e($message); ?>

                                                                 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                             </label>
                                                         </div>
                                                     </div>
                                                 </div>


                                                 <ul class="list-inline pull-right">
                                                    <li><button type="button"
                                                            class="btn btn-danger prev-step1">Previous</button></li>
                                                    <li><button type="button"
                                                            class="btn btn-info preview-step mr-2">Preview</button></li>
                                                    <li><button type="submit"
                                                            class="btn btn-primary btn-info-full ">Submit</button>
                                                    </li>
                                                </ul>


                                            </form>
                                         </div>

                                         <!-- payment end -->

                                     </div>




                                 </div>

                             </div>
                             </form>
                             </div>
                                 <div role="tabpanel" class="tab-pane" id="preveious_application"
                                     aria-expanded="false">
                                     <div class="card">
                                         <div class="header">

                                             <h2>Previous Applications</h2>
                                         </div>
                                         <div class="body">
                                             <div class="table-responsive">
                                                 <table class="table table-hover js-basic-example contact_list">
                                                     <thead>
                                                         <tr>
                                                             <th class="center">#S.N0</th>
                                                             <th class="center">Application No</th>
                                                             <th class="center">Level ID</th>
                                                             <th class="center">Total Course</th>
                                                             <th class="center">Total Fee</th>
                                                             <th class="center"> Payment Date </th>
                                                             <th class="center">Status</th>
                                                             <th class="center">Action</th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>

                                                        <?php if(isset($collection)): ?>



                                                         <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                             <tr class="odd gradeX">
                                                                 <td class="center"><?php echo e($k + 1); ?></td>
                                                                 <td class="center">
                                                                     RAVAP-<?php echo e(4000 + $item->application_id); ?></td>
                                                                 <td class="center"><?php echo e($item->level_id); ?></td>
                                                                 <td class="center"><?php echo e($item->course_count); ?></td>
                                                                 <td class="center">
                                                                     <?php echo e($item->currency); ?><?php echo e($item->amount); ?>

                                                                 </td>
                                                                 <td class="center"><?php echo e($item->payment_date); ?></td>
                                                                 <td class="center">
                                                                     <a href="javascript:void(0)"
                                                                         onclick="return confirm_option('change status')"
                                                                         <?php if($item->status == 0): ?> <div class="badge col-brown">Pending</div>
                                                                    <?php elseif($item->status == 1): ?>
                                                                    <div class="badge col-green">InProssess</div>
                                                                    <?php elseif($item->status == 2): ?>
                                                                    <div class="badge col-red">Approved</div> <?php endif; ?>
                                                                         </a>
                                                                 </td>




                                                                 <td class="center">
                                                                    <a href="<?php echo e(url('/previews-application-first' . '/' . $item->id)); ?>"
                                                                        class="btn btn-tbl-edit"><i
                                                                            class="material-icons">visibility</i></a>
                                                                    <!-- <?php if($item->status == 1): ?>
                                                                        <a href="<?php echo e(url('/upload-document' . '/' . dEncrypt($item->id))); ?>"
                                                                            class="btn btn-tbl-edit bg-primary"><i
                                                                                class="fa fa-upload"></i></a>
                                                                    <?php endif; ?>
                                                                    <?php if($item->status == 2): ?>
                                                                        <a href="<?php echo e(url('/application-upgrade-second')); ?>"
                                                                            class="btn btn-tbl-edit"><i
                                                                                class="material-icons">edit</i></a>
                                                                    <?php endif; ?> -->
                                                                </td>


                                                                 <?php if(request()->path() == 'level-first'): ?>

                                                                 <?php elseif(request()->path() == 'level-second'): ?>
                                                                     <td class="center">
                                                                         <a href="<?php echo e(url('/previews-application-second' . '/' . $item->id)); ?>"
                                                                             class="btn btn-tbl-edit"><i
                                                                                 class="material-icons">visibility</i></a>
                                                                         <?php if($item->status == 1): ?>
                                                                             <a href="<?php echo e(url('/upload-document')); ?>"
                                                                                 class="btn btn-tbl-upload"><i
                                                                                     class="material-icons">upload</i></a>
                                                                         <?php endif; ?>
                                                                         <?php if($item->status == 2): ?>
                                                                             <a href="<?php echo e(url('/application-upgrade-third')); ?>"
                                                                                 class="btn btn-tbl-edit"><i
                                                                                     class="material-icons">edit</i></a>
                                                                         <?php endif; ?>
                                                                     </td>
                                                                 <?php elseif(request()->path() == 'level-third'): ?>
                                                                     <td class="center">
                                                                         <a href="<?php echo e(url('/previews-application-third' . '/' . $item->id)); ?>"
                                                                             class="btn btn-tbl-edit"><i
                                                                                 class="material-icons">visibility</i></a>
                                                                         <?php if($item->status == 1): ?>
                                                                             <a href="<?php echo e(url('/upload-document')); ?>"
                                                                                 class="btn btn-tbl-upload"><i
                                                                                     class="material-icons">upload</i></a>
                                                                         <?php endif; ?>
                                                                         <?php if($item->status == 2): ?>
                                                                             <a href="<?php echo e(url('/application-upgrade-forth')); ?>"
                                                                                 class="btn btn-tbl-edit"><i
                                                                                     class="material-icons">edit</i></a>
                                                                         <?php endif; ?>
                                                                     </td>
                                                                 <?php elseif(request()->path() == 'level-fourth'): ?>
                                                                     <td class="center">
                                                                         <a href="<?php echo e(url('/previews-application-fourth')); ?>"
                                                                             class="btn btn-tbl-edit"><i
                                                                                 class="material-icons">visibility</i></a>
                                                                     </td>
                                                                 <?php endif; ?>
                                                             </tr>
                                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                         <?php endif; ?>
                                                     </tbody>
                                                 </table>
                                                 <!-- Modal -->
                                                 <div class="modal fade" id="exampleModal" tabindex="-1"
                                                     role="dialog" aria-labelledby="exampleModalLabel"
                                                     aria-hidden="true">
                                                     <div class="modal-dialog" role="document">
                                                         <div class="modal-content">
                                                             <div class="modal-header">
                                                                 <h5 class="modal-title" id="exampleModalLabel">
                                                                     Modal
                                                                     title
                                                                 </h5>
                                                                 <button type="button" class="close"
                                                                     data-dismiss="modal" aria-label="Close">
                                                                     <span aria-hidden="true">&times;</span>
                                                                 </button>
                                                             </div>
                                                             <div class="modal-body">
                                                                 ...
                                                             </div>
                                                             <div class="modal-footer">
                                                                 <button type="button" class="btn btn-secondary"
                                                                     data-dismiss="modal">Close</button>
                                                                 <button type="button" class="btn btn-primary">Save
                                                                     changes</button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>



                                 <div role="tabpanel" class="tab-pane" id="faqs" aria-expanded="false">
                                     <div class="card">
                                         <div class="header">
                                             <h2>FAQs</h2>
                                         </div>
                                         <div class="body">
                                             <?php if(count($faqs) > 0): ?>
                                                 <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <div class="row clearfix">
                                                         <div class="col-lg-12 col-md-12">

                                                             <span style="font-weight:bold">Question
                                                                 <?php echo e($k + 1); ?>:</span><br>
                                                             <?php echo e($faq->question); ?>


                                                         </div>
                                                     </div>
                                                     <div class="row clearfix">
                                                         <div class="col-lg-12 col-md-12">

                                                             <span style="font-weight:bold">Answer:</span><br>
                                                             <?php echo $faq->answer; ?>


                                                         </div>
                                                     </div>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             <?php endif; ?>

                                         </div>
                                     </div>
                                 </div>

                     </div>
                 </div>




                 <!-- View Modal Popup -->

                 <div class="modal fade" id="View_popup" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalCenterTitle"> View Course Details</h5>
                                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             <div class="modal-body">

                                 <div class="body">
                                     <div class="table-responsive table-con-free">
                                         <table class="table table-hover js-basic-example contact_list table-bordered">
                                             <tbody>


                                                 <!-- <tr class="odd gradeX">
                                                     <th class="center">S.No.</th>
                                                     <td class="center">
                                                         <input type="text" id="Course_id" readonly>
                                                     </td>

                                                 </tr> -->

                                                 <tr class="odd gradeX">
                                                     <th class="center"> Course Name </th>
                                                     <td class="center">

                                                         <input type="text" id="Course_Name" readonly>

                                                     </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center"> Eligibility </th>
                                                     <td class="center">

                                                         <input type="text" id="Eligibility" readonly>

                                                     </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center"> Mode Of Course </th>
                                                     <td class="center">

                                                         <input type="text" id="Mode_Of_Course" readonly>


                                                     </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center">Payment Status</th>
                                                     <td class="center">


                                                         <input type="text" id="Payment_Status" readonly>

                                                     </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center">Course Brief</th>
                                                     <td class="center">
                                                     <input type="text" name="course_brief[]" id="view_course_brief" readonly>
                                                     </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center">Duration</th>
                                                     <td class="center">
                                                         <span id="view_years"></span>
                                                         <span id="view_months"></span>
                                                         <span id="view_days"></span>
                                                         <span id="view_hours"></span>
                                                     </td>
                                                 </tr>



                                                 <tr class="odd gradeX">
                                                     <th class="center">Declaration </th>
                                                     <td class="center">

                                                         <a href="" target="_blank" id="docpdf1" title="Download Document 1" ><i class="fa fa-download mr-2"></i> PDF 1
                                                         </a>
                                                     </td>

                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center">Course Curriculum / Material / Syllabus </th>
                                                     <td class="center">

                                                         <a href="" target="_blank" id="docpdf2" title="Download Document 2" ><i class="fa fa-download mr-2"></i> PDF 2
                                                         </a>
                                                    </td>
                                                 </tr>

                                                 <tr class="odd gradeX">
                                                     <th class="center">Course Details (Excel format)  </th>
                                                     <td class="center">

                                                        <a  target="_blank"  href="" title="Document 3" id="docpdf3" download>
                                                             <i class="fa fa-download mr-2"></i> PDF 3
                                                         </a>

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


                <!-- Edit Modal Poup -->

                 <div class="modal fade" id="edit_popup">
                     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                         <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle"> Edit Details </h5>

                                    <div class="payment-status d-flex">
                                        <label class="active">Payment Status : </label>
                                        <input type="text" name="Payment_Statuss" id="Payment_Statuss" class="form-control btn btn-outline-danger p-0" style="border-bottom: 1px solid #fb483a !important;">
                                    </div>

                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                             <div class="modal-body edit-popup">
                                 <div class="body col-md-12">

                                     <form action="" id="form_update" method="post">

                                         <?php echo csrf_field(); ?>

                                         <div class="row mt-4">
                                             <div class="col-sm-3">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label class="active">Course Name<span
                                                                 class="text-danger">*</span></label>
                                                         <input type="text" name="Course_Names" id="Course_Names"
                                                             class="form-control">
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-sm-4">
                                                     <div class="form-group">
                                                         <div class="form-line">
                                                             <label>Course Duration <span class="text-danger">*</span>
                                                                    </label>
                                                             <!-- <input type="number" placeholder="Course Duration"
                                                                 name="course_duration[]" required> -->

                                                                 <div class="course_group">
                                                                    <input type="number" placeholder="Years" name="years" required class="course_input" id="years">
                                                                     <input type="number" placeholder="Months" name="months" required class="course_input" id="months">
                                                                     <input type="number" placeholder="Days"  name="days" required class="course_input" id="days">
                                                                     <input type="number" placeholder="Hours" name="hours"  required class="course_input" id="hours">
                                                                     </div>
                                                         </div>
                                                         <?php $__errorArgs = ['course_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                             <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                         <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                     </div>
                                                 </div>

                                             <div class="col-sm-3">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label class="active">Eligibility<span> </label>
                                                         <input type="text" name="Eligibilitys" id="Eligibilitys" class="form-control">
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-sm-2">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label class="active">Mode Of Courses<span
                                                                 class="text-danger">*</span></label>
                                                         <input type="text" name="Mode_Of_Courses"
                                                             id="Mode_Of_Courses" class="form-control">

                                                       <!--   <select id="courses_mode" class="form-control state" name="Mode_Of_Courses" >
                                                             <option > </option>
                                                          </select> -->


                                                     </div>
                                                 </div>
                                             </div>


                                             <div class="col-sm-12">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Course Brief <span
                                                                         class="text-danger">*</span></label>
                                                                 <!-- <input type="text" placeholder="Course Brief"
                                                                     name="course_brief[]" required> -->
                                                                <textarea rows="4" cols="50" class="form-control" placeholder="Course Brief" name="course_brief" id="course_brief"></textarea>
                                                            </div>
                                                             <?php $__errorArgs = ['course_brief'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                 <div class="alert alert-danger"><?php echo e($message); ?>

                                                                 </div>
                                                             <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                         </div>
                                                     </div>



                                               <div class="col-sm-4">
                                                         <div class="form-group">
                                                             <div class="form-line">
                                                                 <label>Declaration<span class="text-danger">*</span></label>
                                                         <input type="file" name="doc1"
                                                             id="payment_reference_no"
                                                             class="form-control">


                                                         <a target="_blank" href="" id="docpdf1ss" title=" Document 1"
                                                             ><i class="fa fa-download mr-2"></i> PDF 1 </a>

                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-sm-4">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label>Course Curriculum / Material / Syllabus <span class="text-danger">*</span></label>
                                                         <input type="file" name="doc2"
                                                             id="payment_reference_no"
                                                             class="form-control">

                                                         <a target="_blank" href="" id="docpdf2ss" title=" Document 1"
                                                             ><i class="fa fa-download mr-2"></i> PDF 2</a>

                                                     </div>
                                                 </div>
                                             </div>

                                             

                                             <div class="col-sm-4">
                                                 <div class="form-group">
                                                     <div class="form-line">
                                                         <label>Course Details (Excel format) <span class="text-danger">*</span></label>
                                                         <input type="file" name="doc3"
                                                             id="payment_reference_no"
                                                             class="form-control">


                                                         <a href="" id="docpdf3ss" title="Download Document 1"
                                                             download><i class="fa fa-download mr-2"></i> PDF 3 </a>
                                                     </div>


                                                 </div>
                                             </div>

                                             <div class="col-md-12 text-center">
                                                 <button type="submit"
                                                     class="btn btn-primary waves-effect m-r-15">Save</button>
                                             </div>
                                         </div>

                                     </form>

                                 </div>

                             </div>
                         </div>
                    </div>
                 </div>







                                      

                                      <script>
                                         function add_new_course() {
                                             $("#courses_body").append($("#add_courses").html());
                                         }
                                     </script>
     
     <script>
         $(document).ready(function() {
             var count = 0;

             $(window).on('load', function() {
                 $data = $('#Country').val();
                 // alert($data);

             });


             $("#count").click(function() {
                 count++;
                 //  alert(count)
                 if (count <= 4) {

                     if ($data == '101') {
                         rupess = 1000;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);
                         $("#counters").html("value=" + rupess);


                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 15;
                         //alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 50;
                         // alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }

                 } else if (count <= 9) {
                     if ($data == '101') {
                         rupess = 2000;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);

                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 30;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 100;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }
                 } else {
                     if ($data == '101') {
                         rupess = 3000;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);

                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 45;
                         // alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 150;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }
                 }
             });
         });
     </script>
     <script>
         $(document).ready(function() {



             $(window).on("load", function() {
                 $("#bank_id").hide();
                 $("#QR").hide();
             });

             $("#payments").on('change', function() {
                 $type = $('#payments').val();
                 //alert($type);

                 if ($type == 'QR-Code') {
                     // alert('hii')
                     $("#bank_id").hide();
                     $("#QR").show();

                 } else if ($type == "") {
                     //  alert('hii1')
                     $("#bank_id").hide();
                     $("#QR").hide();

                 } else {

                     //  alert('hii1')
                     $("#bank_id").show();
                     $("#QR").hide();

                 }
             });
         });
     </script>
     
     <script>
         $(document).ready(function() {
             var count = 0;

             $(window).on('load', function() {
                 $data = $('#Country').val();
                 // alert($data);

             });


             $("#count_second").click(function() {
                 count++;
                 //  alert(count)
                 if (count <= 4) {

                     if ($data == '101') {
                         rupess = 2500;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);
                         $("#counters").html("value=" + rupess);


                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 35;
                         //alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 100;
                         // alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }

                 } else if (count <= 9) {
                     if ($data == '101') {
                         rupess = 5000;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);

                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 75;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 200;
                         //   alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }
                 } else {
                     if ($data == '101') {
                         rupess = 10000;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:₹." + rupess);

                     } else if ($data == '167' || $data == '208' || $data == '19' || $data == '1' || $data ==
                         '133') {

                         rupess = 150;
                         // alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);


                     } else {

                         rupess = 400;
                         //  alert(rupess)
                         $("#counter").html("Total Amount:US $." + rupess);
                     }
                 }
             });
         });
     </script>
     <!-- step Tabs js -->
     <script>
         $(document).ready(function() {

             $(".next-step").click(function() {
                 $("#step1").removeClass("active");
                 $("#step2").addClass("active");
                 $(".progress1").removeClass("active");
                 $(".progress2").addClass("active");

             });

             $(".prev-step").click(function() {
                 $("#step2").removeClass("active");
                 $("#step1").addClass("active");
                 $(".progress2").removeClass("active");
                 $(".progress1").addClass("active");
                 $(".progress2").removeClass("bg_green");
             });

             $(".next-step1").click(function() {
                 $("#step2").removeClass("active");
                 $("#step3").addClass("active");
                 $(".progress2").removeClass("active");
                 $(".progress3").addClass("active");
                 $(".progress2").addClass("bg_green");
             });

             $(".prev-step1").click(function() {
                 $("#step3").removeClass("active");
                 $("#step2").addClass("active");
                 $(".progress3").removeClass("active");
                 $(".progress2").addClass("active");
             });

         });
     </script>



     

                                 
                                 <script>
                                    $(document).on("click", "#view", function() {
                                        var UserName = $(this).data('id');
                                        console.log(UserName);

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({
                                            url: "<?php echo e(url('course-list')); ?>",
                                            type: "get",
                                            data: {
                                                id: UserName
                                            },
                                            success: function(Document) {

                                               /* console.log(data.ApplicationCourse[0].eligibility)
                                                console.log(data.Document[0].document_file)*/

                                                console.log(Document);

                                                $("#Course_id").val(data.ApplicationCourse[0].id);
                                                $("#Course_Name").val(data.ApplicationCourse[0].course_name);
                                                $("#Eligibility").val(data.ApplicationCourse[0].eligibility);
                                                $("#Mode_Of_Course").val(data.ApplicationCourse[0].mode_of_course);
                                                if(data.ApplicationCourse[0].payment=="false")
                                                {
                                                    $("#Payment_Status").val("Not Done");
                                                }
                                                
                                             

                                                $("a#docpdf1").attr("href", "<?php echo e(asset('/documnet')); ?>" + '/' + data.Document[0]
                                                    .document_file);
                                                $("a#docpdf2").attr("href", "<?php echo e(asset('/documnet')); ?>" + '/' + data.Document[0]
                                                    .document_file);
                                                $("a#docpdf3").attr("href", "<?php echo e(asset('/documnet')); ?>" + '/' + data.Document[0]
                                                    .document_file);

                                            }

                                        });

                                    });
                                </script>


                                
                                <script>
                                    $(document).on("click", "#edit_course", function() {
                                        var UserName = $(this).data('id');
                                        console.log(UserName);

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({
                                            url: "<?php echo e(url('course-edit')); ?>",
                                            type: "get",
                                            data: {
                                                id: UserName
                                            },
                                            success: function(data) {

                                                //console.log(data.ApplicationCourse[0].id)
                                                // console.log(data.Document[0].document_file)
                                               //alert(data.ApplicationCourse[0].mode_of_course);
                                              /* alert(data.ApplicationCourse[0].mode_of_course);*/

                                               /* $('#courses_mode').html('<option value="">-- Select Mode Of Course --</option>');*/
                                                  

                                               




                                                $('#form_update').attr('action', '<?php echo e(url('/course-edit')); ?>' + '/' + data
                                                    .ApplicationCourse[0].id)
                                                $("#Course_Names").val(data.ApplicationCourse[0].course_name);
                                                $("#Eligibilitys").val(data.ApplicationCourse[0].eligibility);
                                                $("#Mode_Of_Courses").val(data.ApplicationCourse[0].mode_of_course);
                                                if(data.ApplicationCourse[0].payment=="false")
                                                {  
                                                    $("#Payment_Status").val("Not Done");
                                                }

                                                $("#years").val(data.ApplicationCourse[0].years);
                                                $("#months").val(data.ApplicationCourse[0].months);
                                                $("#days").val(data.ApplicationCourse[0].days);
                                                $("#hours").val(data.ApplicationCourse[0].hours);

                                                
                                                $("a#docpdf1ss").attr("href", "<?php echo e(asset('/documnet')); ?>" + '/' + data.Document[0]
                                                    .document_file);
                                                $("a#docpdf2ss").attr("href", "<?php echo e(asset('/documnet')); ?>" + '/' + data.Document[1]
                                                    .document_file);
                                                $("a#docpdf3ss").attr("href", "<?php echo e(asset('/documnet')); ?>" + '/' + data.Document[2]
                                                    .document_file);

                                                


                                            }

                                        });

                                    });
                                </script>



                                
                                <script>
                                    $(window).on("load", function() {
                                        var UserName = $('$level_id').data('id');
                                        console.log(UserName);

                                        $('')

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });


                                        $.ajax({
                                            url: "<?php echo e(url('/level-first')); ?>",
                                            type: "get",
                                            data: {
                                                id: UserName
                                            },
                                            success: function(data) {



                                            }

                                        });

                                    });
                                </script>


                                
                                <script type="text/javascript">
                                    $('.save').on('click', function(e) {

                                        e.preventDefault();

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({
                                            type: "POST",
                                            url: '<?php echo e(url('/new-application')); ?>',
                                            data: new FormData(document.getElementById("regForm")),
                                            processData: false,
                                            dataType: 'json',
                                            contentType: false,
                                            success: function(response) {

                                                console.log(response.id)
                                                
 
                                                if (response.id) {

                                                    $('.content_id').val(response.id);
                                                    $('.content_ids').val(response.id);
                                                    $("#step1").removeClass('active')
                                                    $("#step2").addClass('active')

                                                }


                                            },

                                            error: function(response) 
                                            {
                                                //console.log(response);
                                                $("#email_id_error").empty();
                                                $("#contact_error").empty();
                                                $("#person_error").empty();
                                                $("#designation_error").empty();

                                                $('#email_id_error').text(response.responseJSON.errors.Email_ID);
                                                $('#contact_error').text(response.responseJSON.errors.Contact_Number);
                                                $('#person_error').text(response.responseJSON.errors.Person_Name);
                                                $('#designation_error').text(response.responseJSON.errors.designation);
                                                //alert(response.responseJSON.errors.Email_ID);
                                            },


                                        });

                                    });
                                </script>


                                <script>
                                    function add_new_course() {

                                        $("#courses_body").append($("#add_courses").html());
                                    }
                                </script>




    
    <script>
       $(document).on("click", "#view", function() {

           var UserName = $(this).data('id');
           console.log(UserName);

           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $.ajax({
               url: "<?php echo e(url('course-list')); ?>",
               type: "get",
               data: {
                   id: UserName
               },
               success: function(data) {
                   

                   console.log(data.ApplicationCourse[0].eligibility)
                   console.log(data.Document[0].document_file)

                   $("#Course_id").val(data.ApplicationCourse[0].id);
                   $("#Course_Name").val(data.ApplicationCourse[0].course_name);
                   $("#Eligibility").val(data.ApplicationCourse[0].eligibility);
                   $("#Mode_Of_Course").val(data.ApplicationCourse[0].mode_of_course);
                   if(data.ApplicationCourse[0].payment=="false")
                    {
                        $("#Payment_Status").val("Not Done");
                    }
                   $("#view_course_brief").val(data.ApplicationCourse[0].course_brief);

                   $("#view_years").html(data.ApplicationCourse[0].years + " Year(s)");
                   $("#view_months").html(data.ApplicationCourse[0].months + " Month(s)");
                   $("#view_days").html(data.ApplicationCourse[0].days + " Day(s)");
                   $("#view_hours").html(data.ApplicationCourse[0].hours + " Hour(s)");
                   
                   //alert(data.Document[2].document_file);

                   $("a#docpdf1").attr("href", "<?php echo e(url('show-course-pdf')); ?>" + '/' + data.Document[0]
                       .document_file);
                   $("a#docpdf2").attr("href", "<?php echo e(url('show-course-pdf')); ?>" + '/' + data.Document[1]
                       .document_file);

                   $("a#docpdf3").attr("href", "<?php echo e(asset('/documnet')); ?>" + '/' + data.Document[2]
                       .document_file);
                   /*$("a#docpdf3").attr("href", "<?php echo e(url('show-course-pdf')); ?>" + '/' + data.Document[2]
                       .document_file);*/




               }

           });

       });
   </script>


   
   <script>
       $(document).on("click", "#edit_course", function() {
           var UserName = $(this).data('id');
           console.log(UserName);

           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $.ajax({
               url: "<?php echo e(url('course-edit')); ?>",
               type: "get",
               data: {
                   id: UserName
               },
               success: function(data) {

                   //console.log(data.ApplicationCourse[0].id)
                   // console.log(data.Document[0].document_file)
                
                   

                   $('#form_update').attr('action', '<?php echo e(url('/course-edit')); ?>' + '/' + data
                       .ApplicationCourse[0].id)
                   $("#Course_Names").val(data.ApplicationCourse[0].course_name);
                   $("#Eligibilitys").val(data.ApplicationCourse[0].eligibility);
                   $("#Mode_Of_Courses").val(data.ApplicationCourse[0].mode_of_course);
                   //$("#Payment_Statuss").val(data.ApplicationCourse[0].payment);

                   if(data.ApplicationCourse[0].payment=="false")
                    {
                        $("#Payment_Statuss").val("Not Done");
                    }

              $("#years").val(data.ApplicationCourse[0].years);
                $("#months").val(data.ApplicationCourse[0].months);
                $("#days").val(data.ApplicationCourse[0].days);
                $("#hours").val(data.ApplicationCourse[0].hours);
                $("#course_brief").val(data.ApplicationCourse[0].course_brief);

                  //alert("yes");
                  $("a#docpdf1ss").attr("href", "<?php echo e(url('show-course-pdf')); ?>" + '/' + data.Document[0]
                       .document_file);
                   $("a#docpdf2ss").attr("href", "<?php echo e(url('show-course-pdf')); ?>" + '/' + data.Document[1]
                       .document_file);
                   /*$("a#docpdf1ss").attr("href", "<?php echo e(asset('/documnet')); ?>" + '/' + data.Document[0]
                       .document_file);
                   $("a#docpdf2ss").attr("href", "<?php echo e(asset('/documnet')); ?>" + '/' + data.Document[1]
                       .document_file);*/
                   $("a#docpdf3ss").attr("href", "<?php echo e(asset('/documnet')); ?>" + '/' + data.Document[2]
                       .document_file);

                   //dd

                    
                   


               }

           });

       });
   </script>



   
   <script>
       $(window).on("load", function() {
           var UserName = $('$level_id').data('id');
           console.log(UserName);

           $('')

           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });


           $.ajax({
               url: "<?php echo e(url('/level-first')); ?>",
               type: "get",
               data: {
                   id: UserName
               },
               success: function(data) {



               }

           });

       });
       $(function() {
        $("#payment_date").datepicker({
            maxDate: new Date()
        });
    });


    

    // disable alphate
    $('#postal').keypress(function (e) {
       // alert('hello');
        var regex = new RegExp("^[0-9_]");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
   </script>
   <script>
   
    $('.preventalpha').keypress(function (e) {
          //alert("yes");
         var regex = new RegExp("^[0-9_]");
         var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
         if (regex.test(str)) {
             return true;
         }
         e.preventDefault();
         return false;
     });

    $('.preventnumeric').keypress(function (e) {
          //alert("yes");
         var regex = new RegExp("^[a-z,A-Z_]");
         var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
         if (regex.test(str)) {
             return true;
         }
         e.preventDefault();
         return false;
     });

    $('#eligibility').bind('input', function() {
      var c = this.selectionStart,
          r = /[^a-z0-9 .]/gi,
          v = $(this).val();
      if(r.test(v)) {
        $(this).val(v.replace(r, ''));
        c--;
      }
      this.setSelectionRange(c, c);
    });

   </script>
   
   <script>
       var doc_file1="";
       
       $('.doc_1').on('change',function(){

          doc_file1 = $(".doc_1").val();
          console.log(doc_file1);
          var doc_file1 = doc_file1.split('.').pop();
          if(doc_file1=='pdf'){
          // alert("File uploaded is pdf");
           }
          else{
            alert("Only PDF are allowed")
             $('.doc_1').val("");
          }
         
        });

        
        
   </script>

   <script>

    var doc_file2="";
    $('.doc_2').on('change',function(){
          
          doc_file2 = $(".doc_2").val();
          console.log(doc_file2);
          var doc_file2 = doc_file2.split('.').pop();
          if(doc_file2=='pdf'){
          // alert("File uploaded is pdf");
           }
          else{
            alert("Only PDF are allowed");
             $('.doc_2').val("");
          }
         
        });

   </script>

   <script>
   
    var doc_file3="";
    $('.doc_3').on('change',function(){
        
          doc_file3 = $(".doc_3").val();
          console.log(doc_file3);
          var doc_file3 = doc_file3.split('.').pop();

         
          if(doc_file3=='csv' || doc_file3=='xlsx' || doc_file3=='xls'){
          // alert("File uploaded is pdf");
           }
          else{
            alert("Only csv,xlsx,xls  are allowed")
             $('.doc_3').val("");
          }
         
        });
   </script>


 <script>
    $(function () {
            //Multi-select
            $("#optgroup").multiSelect({ selectableOptgroup: true });

            //Select2
            $(".select2").select2();

            $("#select2-search-hide").select2({
            minimumResultsForSearch: Infinity,
            });

            $("#select2-rtl-multiple").select2({
            placeholder: "RTL Select",
            dir: "rtl",
            });

            $("#select2-max-length").select2({
            maximumSelectionLength: 2,
            placeholder: "Select only maximum 2 items",
            });
});
</script>

     <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 </body>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/level/leveltp.blade.php ENDPATH**/ ?>