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
                                <h4 class="page-title">Applications </h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Applications List</li>
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
                            <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget">
                                            <div class="header">

                                                <span style="float:right;" >


                                                    <a type="button" href="<?php echo e(url('/level-first')); ?>" class="btn btn-primary waves-effect" style="line-height:2;">+ Add New Application</a>


                                                    </span>
                                            </div>

                                            <div class="body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover js-basic-example contact_list">
                                                        <thead>
                                                            <tr>

                                                                <th class="center"> Application ID </th>
<!--                                                                <th class="center"> Create User ID </th>-->
                                                                <th class="center"> Level ID </th>
                                                                <th class="center"> Country </th>
                                                                <th class="center"> Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php if(isset($data)): ?>

                                                                <tr>

                                                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                    <?php if(checktppaymentstatus($item->id) == 0): ?>

                                                                        <td class="center">  RAVAP-<?php echo e(4000 + $item->id); ?></td></td>
<!--                                                                        <td class="center"> <?php echo e($item->user_id ?? ''); ?></td>-->
                                                                        <td class="center"> <?php echo e($item->level_id ?? ''); ?></td>
                                                                        <td class="center"> <?php echo e($item->country_name ?? ''); ?></td>

                                                                        <td class="center"> <a href="<?php echo e(url('/level-first'.'/'.$item->id)); ?>"
                                                                                class="btn btn-tbl-edit bg-success"><i
                                                                                    class="fa fa-edit"></i></a></td>

                                                                    <?php endif; ?>

                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <?php endif; ?>

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
<?php /**PATH D:\xampp\htdocs\atab\resources\views/level/levellist.blade.php ENDPATH**/ ?>