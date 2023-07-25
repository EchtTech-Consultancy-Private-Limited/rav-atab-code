<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<title>
    RAV Accreditation</title>

<style>
    .error {
        color: red;
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
                                <h4 class="page-title">Edit Level</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Level</a>
                            </li>
                            <li class="breadcrumb-item active">Edit Level</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Edit</strong> Level
                            </h2>
                            
                        </div>
                          <?php if(Session::has('sussess')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(session::get('sussess')); ?>

            </div>
            <?php elseif(Session::has('fail')): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo e(session::get('fail')); ?>

            </div>
            <?php endif; ?>
                        <form action="<?php echo e(url('update-level_post' . '/' . dEncrypt($data->id))); ?>" method="post"
                            enctype="multipart/form-data">

                            <?php echo csrf_field(); ?>
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label><strong>level Information</strong></label>
                                            <div class="form-line">
                                                <textarea class="form-control" name="level_Information" placeholder="Level Information"><?php echo e($data->level_Information); ?></textarea>
                                            </div><br>


                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label class="active">level Information pdf<span
                                                                class="text-danger">*</span></label>
                                                        <input type="file" 
                                                            class="special_no valid form-control"
                                                            name="level_Information_pdf">
                                                    </div>


                                                </div>


                                                <?php if($data->level_Information_pdf != ""): ?>

                                                <a href="<?php echo e(url('level/' . $data->level_Information_pdf)); ?>"
                                                    title="level Information pdf" download><i
                                                        class="fa fa-download mr-2"></i> PDF level Information pdf </a>

                                                 <?php endif; ?>

                                            </div>






                                        </div>

                                    </div>


                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label> <strong>Prerequisites</strong> </label>
                                            <div class="form-line">
                                                <textarea class="form-control" name="Prerequisites" placeholder="Prerequisites"><?php echo e($data->Prerequisites); ?></textarea>
                                            </div>
                                        </div>

                                        <br>


                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label class="active">Prerequisites pdf<span
                                                            class="text-danger">*</span></label>
                                                    <input type="file"  class="special_no valid form-control"
                                                        name="Prerequisites_pdf">
                                                </div>

                                            </div>


                                            <?php if($data->Prerequisites_pdf != ""): ?>

                                            <a href="<?php echo e(url('level/' . $data->Prerequisites_pdf)); ?>"
                                                title="level Information pdf" download><i
                                                    class="fa fa-download mr-2"></i> PDF Prerequisites pdf </a>

                                                    <?php endif; ?>

                                        </div>
                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label><strong>Documents Required</strong></label>
                                            <div class="form-line">

                                                <textarea class="form-control" name="documents_required" placeholder="Documents required"><?php echo e($data->documents_required); ?></textarea>
                                            </div>

                                            <label for="documents_required" id="documents_required-error"
                                                class="error">
                                                <?php $__errorArgs = ['documents_required'];
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
                                            <br>


                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label class="active">Documents Required pdf<span
                                                                class="text-danger">*</span></label>
                                                        <input type="file" 
                                                            class="special_no valid form-control"
                                                            name="documents_required_pdf">
                                                    </div>





                                                </div>

                                                  <?php if($data->documents_required_pdf != ""): ?>

                                                   <a href="<?php echo e(url('level/' . $data->documents_required_pdf)); ?>"
                                                        title="level Information pdf" download><i
                                                            class="fa fa-download mr-2"></i> PDF Documents Required pdf </a>

                                                   <?php endif; ?>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> <strong>Validity</strong></label>
                                            <div class="form-line">
                                                
                                                <input class="form-control" name="validity" placeholder="validity"
                                                    value="<?php echo e($data->validity); ?>">
                                            </div>
                                        </div>
                                        <label for="validity" id="validity-error" class="error">
                                            <?php $__errorArgs = ['validity'];
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

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><strong>Timelines</strong></label>
                                            <div class="form-line">

                                                <input class="form-control" name="timelines" placeholder="Timelines"
                                                    value="<?php echo e($data->timelines); ?>">

                                            </div>

                                            <label for="timelines" id="timelines-error" class="error">
                                                <?php $__errorArgs = ['timelines'];
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

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label><strong>Fee Structure</strong> </label>
                                            <div class="form-line">

                                                
                                                <input class="form-control" name="fee_structure"
                                                    placeholder="Fee Structure" value="<?php echo e($data->fee_structure); ?>">
                                            </div>
                                            <label for="fee_structure" id="fee_structure-error" class="error">
                                                <?php $__errorArgs = ['fee_structure'];
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

                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="active">Fee Structure pdf<span
                                                        class="text-danger">*</span></label>
                                                <input type="file"  class="special_no valid form-control"
                                                    name="Fee_Structure_pdf">
                                            </div>


                                        </div>

                                        <?php if($data->Fee_Structure_pdf != ""): ?>

                                        <a href="<?php echo e(url('level/' . $data->Fee_Structure_pdf)); ?>"
                                            title="level Information pdf" download><i
                                                class="fa fa-download mr-2"></i> PDF Fee Structure pdf</a>

                                        <?php endif; ?>
                                    </div>
                                </div>






                                <div class="col-lg-12 p-t-20 text-center">
                                    <button type="submit" class="btn btn-primary waves-effect m-r-15">Submit</button>
                                    <button type="button" class="btn btn-danger waves-effect">Cancel</button>
                                </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>



    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/level/update_level.blade.php ENDPATH**/ ?>