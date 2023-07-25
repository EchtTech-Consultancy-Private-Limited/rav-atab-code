<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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

        <?php echo $__env->make('layout.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <?php echo $__env->make('layout.rightbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">User Management</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">View User</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row ">
                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">


                        <?php if(Session::has('success')): ?>
                            <div class="alert alert-success" style="padding: 15px;" role="alert">
                                <?php echo e(session::get('success')); ?>

                            </div>
                        <?php elseif(Session::has('fail')): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo e(session::get('fail')); ?>

                            </div>
                        <?php endif; ?>

                        <div class="tab-content">


                            <div role="tabpanel" class="tab-pane" id="timeline" aria-expanded="false">
                            </div>





                            <div role="tabpanel" class="tab-pane active" id="new_application" aria-expanded="false">

                                
                                <div class="card">
                                    <div class="header">
                                        <h2>User Details</h2>
                                    </div>
                                    <div class="body">

                                        <div class="row clearfix">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label><strong>Title</strong></label><br>
                                                        <label><?php echo e($data->title ?? ''); ?></label>
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
                                                                <input type="hidden" id="Country"
                                                                    value="<?php echo e($data->country ?? ''); ?>">
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
                                        </div>

                                        <!-- basic end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>



    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/user/view-user.blade.php ENDPATH**/ ?>