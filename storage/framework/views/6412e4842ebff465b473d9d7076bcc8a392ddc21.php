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


        <?php echo $__env->make('layout.sideAss', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



        <?php echo $__env->make('layout.rightbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    </div>


    <section class="content">
        <div class="container-fluid">
           <div class="block-header">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">





                    <ul class="breadcrumb breadcrumb-style ">
                       <li class="breadcrumb-item">
                          <h4 class="page-title">Manuals</h4>

                       </li>
                       <li class="breadcrumb-item bcrumb-1">
                          <a href="<?php echo e(url('/dashboard')); ?>">
                          <i class="fas fa-home"></i> Home</a>
                       </li>
                       
                       <li class="breadcrumb-item active">Manuals List</li>
                    </ul>
                 </div>
              </div>
           </div>



           <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                 <div class="card">
                    <div class="header">
                       <h2>

                       </h2>

                    </div>
                    
                       <div class="table-responsive">
                          <table class="table table-hover js-basic-example contact_list">
                             <thead>
                                <tr>

                                   <th class="center"> S.No. </th>
                                   <th class="center"> Manual Type </th>
                                   <th class="center"> Description </th>
                                   <th class="center"> Status </th>
                                   <th class="center"> Action </th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php $k = 1; ?>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datalist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="odd gradeX">
                                   <td class="center"><?php echo e($k); ?></td>
                                   <td class="center"><?php echo e(checkmanualtype($datalist->type)); ?></td>
                                   <td class="center"><?php echo e($datalist->description); ?></td>
                                   <td class="center"><?php echo e($datalist->status ? 'Active' : 'In-Active'); ?></td>
                                   <td class="center">
                                       <a target="_blank" href="<?php echo e(asset('manuals/')); ?>/<?php echo e($datalist->manual_file); ?>" class="" id="view"><img height="30" width="30" src="<?php echo e(asset('assets/images/file-download-icon.png')); ?>" alt="" title=""/>
                                       </a>
                                   </td>
                                </tr>
                                 <?php $k ++; ?>
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
     </section>

     
    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/asesrar/list-manual.blade.php ENDPATH**/ ?>