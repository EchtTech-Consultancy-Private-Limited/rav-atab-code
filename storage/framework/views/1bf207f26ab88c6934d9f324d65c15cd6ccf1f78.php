<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<title>RAV Accreditation || Previous Applications View</title>

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
                                <h4 class="page-title">Application</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> level</a>
                            </li>
                            <li class="breadcrumb-item active"> View Previous Applications </li>
                        </ul>


                        <a href="<?php echo e(url()->previous()); ?>" type="button" class="btn btn-primary" style="float:right;">Back </a>

                    </div>
                </div>
            </div>

            <div class="row ">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Basic Information</h2>
                            </div>
                            <div class="body">

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Title</strong></label><br>
                                                <label><?php echo e($data->title ??''); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>First Name</strong></label><br>
                                                <?php echo e($data->firstname ?? ''); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">

                                                <label><strong>Middle Name</strong></label><br>

                                                <label><?php echo e($data->middlename ?? ''); ?></label>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Last Name</strong></label><br>
                                                <label><?php echo e($data->lastname ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Organization/Institute Name</strong></label><br>
                                                <label><?php echo e($data->organization ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Email</strong></label><br>
                                                <label><?php echo e($data->email ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Mobile Number</strong></label><br>
                                                <label><?php echo e($data->mobile_no ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Designation</strong></label><br>
                                                <label><?php echo e($data->designation ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label><strong>Country</strong></label><br>
                                                        <label><?php echo e($data->country_name ?? ''); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="row clearfix">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>State</strong></label><br>
                                                <label><?php echo e($data->state_name ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>City</strong></label><br>
                                                <label><?php echo e($data->city_name ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Postal Code</strong></label><br>
                                                <label><?php echo e($data->postal ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Address</strong></label><br>
                                                <label><?php echo e($data->address ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div><div class="header">
                                    <h2>Single Point of Contact Details (SPoC) Details</h2>
                                </div>
                                 <div class="row clearfix">
                                    <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label ><strong>Person Name</strong></label><br>
                                               <label ><?php echo e($spocData->Person_Name); ?></label>
                                        </div>
                                     </div>
                                    </div>

                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label><strong>Contact Number</strong></label><br>
                                            <?php echo e($spocData->Contact_Number ??''); ?>

                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">

                                            <label><strong>Email Id</strong></label><br>

                                              <label><?php echo e($spocData->Email_ID ??''); ?></label>

                                        </div>
                                     </div>
                                  </div>
                                </div>
                                <!-- basic end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>



        

        <?php $__currentLoopData = $ApplicationCourse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $ApplicationCourses): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row ">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Add Course Information Record No: <?php echo e($k + 1); ?></h2>
                            </div>
                            <div class="body">

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Course Name</strong></label><br>
                                                <label><?php echo e($ApplicationCourses->course_name); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Course Duration</strong></label><br>

                                                <?php echo e($ApplicationCourses->years ?? ''); ?> Years(s)
                                                <?php echo e($ApplicationCourses->months ?? ''); ?> Month(s)
                                                <?php echo e($ApplicationCourses->days ?? ''); ?> Day(s)
                                                <?php echo e($ApplicationCourses->hours ?? ''); ?> Hour(s)

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">

                                                <label><strong>Eligibility</strong></label><br>

                                                <label><?php echo e($ApplicationCourses->eligibility ?? ''); ?></label>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Mode of Course</strong></label><br>
                                                <label> <?php echo get_course_mode($ApplicationCourses->id); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Valid From</strong></label><br>
                                                <label><?php echo e(date('d F Y', strtotime($ApplicationCourses->created_at))); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label><strong> Valid To</strong></label><br>
                                                    <label><?php echo e(date('d F Y', strtotime($ApplicationCourses->created_at->addYear()))); ?></label>            </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row clearfix">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Course Brief</strong></label><br>
                                                <label><?php echo e($ApplicationCourses->course_brief ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="col-sm-12 text-right">
                                       <div class="form-group">
                                          <div class="form-line">
                                             <a href="<?php echo e(url('/admin-view-document' . '/' .$ApplicationCourses->application_id.'/'.$ApplicationCourses->id)); ?>"
                                      class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">View Documents</a>
                                          </div>
                                       </div>
                                    </div>
                                </div>
                                <!-- basic end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        



        <?php $__currentLoopData = $ApplicationPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ApplicationPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row ">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Payment Information</h2>
                            </div>
                            <div class="body">

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Payment Date</strong></label><br>
                                                <label><?php echo e($ApplicationPayment->payment_date); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Payment Transaction no</strong></label><br>
                                                <?php echo e($ApplicationPayment->payment_details ?? ''); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">

                                                <label><strong>Payment Reference no</strong></label><br>

                                                <label><?php echo e($ApplicationPayment->payment_details ?? ''); ?></label>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Course Count</strong></label><br>
                                                <label><?php echo e($ApplicationPayment->course_count ?? ''); ?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Amount</strong></label><br>
                                                <label><?php echo e($ApplicationPayment->currency ?? ''); ?>

                                                    <?php echo e($ApplicationPayment->amount); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>Verify Payment </strong></label><br>
                                                <label><br>

                                                 <?php if($ApplicationPayment->status == '0'): ?>
                                                            <a href="<?php echo e(url('preveious-app-status/' . dEncrypt($ApplicationPayment->id))); ?>"
                                                                onclick="return confirm_option('change status')"
                                                                <?php if($ApplicationPayment->status == 0): ?> <div class=" col-black"><strong class="btn btn-secondary btn-sm">Pending</strong></div> <?php elseif($ApplicationPayment->status == 1): ?> <div class="badge col-green">Proccess</div> <?php else: ?> <?php endif; ?>
                                                                </a>
                                                    
                                            <?php endif; ?>


                                            <?php if($ApplicationPayment->status == '1'): ?>
                                                <a href="<?php echo e(url('preveious-app-status/' . dEncrypt($ApplicationPayment->id))); ?>"
                                                    onclick="return confirm_option('change status')"
                                                    <?php if($ApplicationPayment->status == 0): ?> <div class="col-black"><strong class="btn btn-secondary">Pending</strong></div>

                                                     <?php elseif($ApplicationPayment->status == 1): ?>
                                                      <div class=" col-green" ><strong class="btn btn-success">Proccess</strong></div> <?php else: ?> <?php endif; ?>
                                                    </a>
                                                  
                                            <?php endif; ?>

                                            <?php if($ApplicationPayment->status == '2'): ?>
                                                <a href="<?php echo e(url('preveious-app-status/' . dEncrypt($ApplicationPayment->id))); ?>"
                                                    onclick="return confirm_option('change status')"
                                                    <?php if($ApplicationPayment->status == 1): ?> <div class="badge col-green">Proccess</div> <?php elseif($ApplicationPayment->status == 2): ?> <div class=" col-green"><strong class="btn btn-success">Approved</strong></div> <?php else: ?> <?php endif; ?>
                                                    </a>
                                                    
                                            <?php endif; ?>
                                                  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- basic end -->
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



        

        </div>
    </section>
        <script>
   function confirm_option(){
      if(!confirm("Are you sure to change action of this record!")){
         return false;
      }

      return true;
 
   }
</script>

    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp\htdocs\atab\resources\views/level/admin_course_view.blade.php ENDPATH**/ ?>