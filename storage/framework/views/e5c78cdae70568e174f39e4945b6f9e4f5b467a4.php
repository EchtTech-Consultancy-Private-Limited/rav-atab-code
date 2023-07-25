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
                                <h4 class="page-title">International Applications</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                            <li class="breadcrumb-item active">International Applications</li>
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
                                    <li class="nav-item tab-all p-l-20">
                                        <a class="nav-link active" href="#new_application" data-bs-toggle="tab">Rest of the World</a>
                                    </li>
                                    <li class="nav-item tab-all">
                                        <a class="nav-link  show" href="#level_information" data-bs-toggle="tab">SAARC Countries</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane " id="level_information" aria-expanded="true">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card project_widget">
                                        <div class="header">
                                            <h2>SAARC Countries</h2>
                                        </div>
                                        <div class="body">
                                            <div class="table-responsive">
                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>

                                                            <tr>
                                                                <th class="center">#S.N0</th>
                                                                <th class="center">Level ID</th>
                                                                <th class="center">Application No</th>
                                                                <th class="center">Total Course</th>
                                                                <th class="center">Submissiom date </th>
                                                                <th class="center">Assessment Assign Date </th>
                                                                <th class="center">Due Date </th>

                                                                <th class="center">Action</th>

                                                            </tr>
                                                    </thead>
                                                    <tbody>



                                                <?php if(isset($collections)): ?>



                                                <?php $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php
                                                $assessor_id = listofapplicationassessor($item->application_id);
                                                ?>

                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo e($k+1); ?></td>
                                                    <td class="center"><?php echo e($item->level_id); ?></td>
                                                    <td class="center">RAVAP-<?php echo e((4000+$item->application_id)); ?></td>
                                                    <td class="center"><?php echo e($item->course_count); ?></td>
                                                    <td class="center"><?php echo e(application_submission_date($item->application_id,$assessor_id)); ?></td>
                                                    <td class="center"><?php echo e(assessor_assign_date($item->application_id,$assessor_id)); ?></td>
                                                    <td class="center"><?php echo e(assessor_due_date($item->application_id,$assessor_id)); ?></td>

                                                    <td class="center">
                                                        <a href="<?php echo e(url('/Assessor-view/'.dEncrypt($item->application_id))); ?>" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                                    </td>
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
                        <div role="tabpanel" class="tab-pane" id="timeline" aria-expanded="false">
                        </div>
                        <div role="tabpanel" class="tab-pane active" id="new_application" aria-expanded="false">
                            <div class="card">
                                <div class="header">
                                    <h2>Rest of the world data </h2>
                                </div>
                                <div class="body">



                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example contact_list">
                                            <thead>
                                                <tr>
                                                    <th class="center">#S.N0</th>
                                                    <th class="center">Level ID</th>
                                                    <th class="center">Application No</th>
                                                    <th class="center">Total Course</th>
                                                    <th class="center">Submissiom date </th>
                                                    <th class="center">Assessment Assign Date </th>
                                                    <th class="center">Due Date </th>

                                                    <th class="center">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                        <?php if(isset($collection)): ?>


                                                        <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <?php
                                                        $assessor_id = listofapplicationassessor($item->application_id);
                                                        ?>

                                                        <tr class="odd gradeX">
                                                            <td class="center"><?php echo e($k+1); ?></td>
                                                            <td class="center"><?php echo e($item->level_id); ?></td>
                                                            <td class="center">RAVAP-<?php echo e((4000+$item->application_id)); ?></td>
                                                            <td class="center"><?php echo e($item->course_count); ?></td>
                                                            <td class="center"><?php echo e(application_submission_date($item->application_id,$assessor_id)); ?></td>
                                                            <td class="center"><?php echo e(assessor_assign_date($item->application_id,$assessor_id)); ?></td>
                                                            <td class="center"><?php echo e(assessor_due_date($item->application_id,$assessor_id)); ?></td>

                                                            <td class="center">
                                                                <a href="<?php echo e(url('/Assessor-view/'.dEncrypt($item->application_id))); ?>" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                                            </td>
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

    </section>


    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/application/accesser/internation_accesser.blade.php ENDPATH**/ ?>