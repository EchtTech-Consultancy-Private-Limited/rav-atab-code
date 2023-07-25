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
                                <h4 class="page-title">Email domain verification</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Dasboard </a>
                            </li>
                            <li class="breadcrumb-item active">Email verification<li>
                        </ul>
                    </div>
                </div>
            </div>


            <?php if(Session::has('success')): ?>
            <div class="alert alert-success" id="alert" style="padding: 15px;" role="alert">
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
                                            <div class="header">
                                                <h2>Add Email Domain :-</h2>
                                                </div>
                                                <form method="post" action="<?php echo e(url('email-verification')); ?>"
                                                    id="regForm" >

                                                    <?php echo csrf_field(); ?>
                                                    <div class="body">
                                                        <div class="row clearfix">
                                                            <div class="col-sm-4 mb-0">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label>Email Domain<span
                                                                                class="text-danger">*</span></label>

                                                                         <input type="text" name="emaildomain" placeholder="Enter Email Domain" >

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 p-t-20">
                                                                <button type="submit"
                                                                    class="btn btn-primary waves-effect m-r-10">Submit</button>
                                                               
                                                            </div>
                                                        </div>
                                                </form>


                                                <!-- <hr> -->



                                           <div class="header">
                                                <h2>Email Domain List :-</h2>
                                                </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">#S.N0</th>
                                                            <th class="center">Email Domain</th>
                                                            <th class="center">Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        <?php $__currentLoopData = $email; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $files): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr class="odd gradeX">
                                                                <td class="center"><?php echo e($k+1); ?></td>
                                                                 <td class="center"><?php echo e($files->emaildomain); ?></td>
                                                                <td class="center"> 
                                                                 <a href="<?php echo e(url('/Email-domoin-delete'.'/'.$files->id)); ?>" class="btn btn-tbl-delete mb-0">
                                                                    <i class="material-icons">delete</i>
                                                                 </a>
                                                                </td>

                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/email/email-domain.blade.php ENDPATH**/ ?>