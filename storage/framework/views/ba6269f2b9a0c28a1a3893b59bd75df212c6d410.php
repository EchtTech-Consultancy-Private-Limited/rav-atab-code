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
                                <h4 class="page-title">Grievance-list</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Grievance</a>
                            </li>
                            <li class="breadcrumb-item active">Grievance-list</li>
                        </ul>
                    </div>
                </div>
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

            <div class="row ">

                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" aria-expanded="true">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget">
                                            <div class="header">
                                                <h2>Grievance list</h2>

                                                <?php if(Auth::user()->role != '1'): ?>
                                                    <a type="button" href="<?php echo e(url('/Grievance')); ?>"
                                                        class="btn btn-primary " style="float: right;line-height:25px;">+
                                                        Add Grievance</a>
                                                <?php endif; ?>

                                            </div>
                                            <?php if($message = Session::get('success')): ?>
                                                <div class="alert alert-success">
                                                    <p><?php echo e($message); ?></p>
                                                </div>
                                            <?php endif; ?>


                                            <div class="body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover js-basic-example contact_list">
                                                        <thead>
                                                            <tr>
                                                                <th class="center">#</th>
                                                                <th class="center"> subject </th>
                                                                <th class="center"> details </th>

                                                                <?php if(Auth::user()->role == '1'): ?>
                                                                    <th class="center"> Status </th>
                                                                    <th class="center"> Action </th>
                                                                <?php endif; ?>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr class="odd gradeX">
                                                                    <td class="center"><?php echo e($datas->id); ?></td>
                                                                    <td class="center"><?php echo e($datas->subject); ?></td>
                                                                    <td class="center"><?php echo $datas->details; ?></td>

                                                                    <?php if(Auth::user()->role == '1'): ?>
                                                                        <td class="center">
                                                                            <a href="<?php echo e(url('active-Grievance' . '/' . $datas->id)); ?>"
                                                                                onclick="return confirm_option('change status')"
                                                                                <?php if($datas->status == 0): ?> <div class="badge col-brown">Pending</div> <?php elseif($datas->status == 1): ?> <div class="badge col-green">Approved</div> <?php else: ?> <?php endif; ?>
                                                                                </a>
                                                                        </td>

                                                                        <td class="center">
                                                                            <a href="<?php echo e(url('view-Grievance' . '/' . $datas->id)); ?>"
                                                                                class="btn btn-tbl-edit"><i
                                                                                    class="material-icons">visibility</i></a>
                                                                        </td>
                                                                    <?php endif; ?>
                                                                </tr>
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
        </div>



    </section>


    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/level/addGrievance.blade.php ENDPATH**/ ?>