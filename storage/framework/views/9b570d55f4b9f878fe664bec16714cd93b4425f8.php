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


        <?php if(Auth::user()->role  == '1' ): ?>

        <?php echo $__env->make('layout.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php elseif(Auth::user()->role  == '2'): ?>

        <?php echo $__env->make('layout.siderTp', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php elseif(Auth::user()->role  == '3'): ?>

        <?php echo $__env->make('layout.sideAss', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php elseif(Auth::user()->role  == '4'): ?>

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
                                <h4 class="page-title">Level Information</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Level List</li>
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
                    <div class="card">
                        <div class="profile-tab-box">
                            <div class="p-l-20">
                                <ul class="nav ">
                                    <li class="nav-item tab-all">
                                        <a class="nav-link active show" href="#level_information" data-bs-toggle="tab">Level Information</a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card project_widget">
                                        <div class="header">
                                            <h2>Level Information</h2>
                                        </div>
                                        <div class="body">
                                            <div class="table-responsive">
                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">#</th>
                                                            <th class="center"> Level Information </th>
                                                            <th class="center"> Prerequisites  </th>
                                                            <th class="center"> Documents Required </th>
                                                            <th class="center"> Validity </th>
                                                            <th class="center"> Fee Structure </th>
                                                            <th class="center">Timelines</th>
                                                            <th class="center"> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <?php $__currentLoopData = $level; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $levels): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr class="odd gradeX">
                                                                <td class="center"><?php echo e($levels->id); ?></td>
                                                                <td class="center"><?php echo e(substr_replace($levels->level_Information,'...',30)); ?></td>
                                                                <td class="center"><?php echo e(substr_replace($levels->Prerequisites,'...',30)); ?></td>
                                                                <td class="center"><?php echo e(substr_replace($levels->documents_required,'...',30)); ?></td>
                                                                <td class="center"><?php echo e(substr_replace($levels->validity ,'...',30)); ?></td>
                                                                <td class="center"><?php echo e(substr_replace($levels->fee_structure,'...',30)); ?></td>
                                                                <td class="center"><?php echo e(substr_replace( $levels->timelines,'...',30)); ?></td>
                                                                <td class="center" style="white-space:nowrap;">
                                                                <a href="<?php echo e(url('/update-level'.'/'.dEncrypt($levels->id))); ?>" class="btn btn-tbl-edit"><i class="material-icons">create</i></a>
                                                                <a href="<?php echo e(url('/level-view'.'/'.dEncrypt($levels->id))); ?>" class="btn btn-tbl-delete"><i class="material-icons">description</i></a>
                                                                </td>
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
                        <div role="tabpanel" class="tab-pane" id="timeline" aria-expanded="false">
                        </div>



                         <div role="tabpanel" class="tab-pane" id="new_application" aria-expanded="false">






                        



                        
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>



    </section>


    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH D:\xampp\htdocs\atab\resources\views/level/level.blade.php ENDPATH**/ ?>