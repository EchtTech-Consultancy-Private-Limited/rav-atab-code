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
                          <h4 class="page-title">Manage Manual</h4>

                       </li>
                       <li class="breadcrumb-item bcrumb-1">
                          <a href="<?php echo e(url('/dashboard')); ?>">
                          <i class="fas fa-home"></i> Home</a>
                       </li>
                       
                       <li class="breadcrumb-item active">Manage Manual</li>
                    </ul>
                 </div>
              </div>
           </div>





           <?php if($message = Session::get('success')): ?>
           <div class="alert alert-success">
              <p><?php echo e($message); ?></p>
           </div>
           <?php endif; ?>

           <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                 <div class="card">
                    <div class="header">
                       <h2>



                <!-- <span style="float:right;" >
                <a type="button" href="<?php echo e(url('/adduser/admin-user')); ?>" class="btn btn-primary waves-effect" style="line-height:2;">+ Add Manual</a>
                </span> -->

                       </h2>

                    </div>
                    <div class="body">

                     <div class="row">
                        
                        <form method="post" action="<?php echo e(url('/save-manual')); ?>"
                            class="javavoid(0) validation-form123" id="regForm" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group mb-0">
                                            <div class="form-line">
                                                <label>Select Manual Type<span class="text-danger">*</span></label>
                                                <select name="m_type" class="form-control" id="m_type">
                                                    <option value="">Select Title </option>
                                                    <option value="1">Guidelines </option>
                                                    <option value="2">Reference Books </option>
                                                </select>
                                            </div>

                                            <label for="m_type" id="m_type-error" class="error">
                                                <?php $__errorArgs = ['m_type'];
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





                                    <div class="col-sm-4">
                                        <div class="form-group mb-0">
                                            <div class="form-line">
                                                <label>Description<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Manual Short Description" name="m_description"
                                                    class="special_no" id="m_description" value="">
                                            </div>

                                            <label for="m_description" id="m_description" class="error">
                                                <?php $__errorArgs = ['m_description'];
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



                                    <div class="col-sm-4">
                                        <div class="form-group mb-0">
                                            <div class="form-line">
                                                <label>Select File<span class="text-danger">*</span></label>
                                                <input type="file" id="file" class="special_no form-control pt-3" name="file" value="">
                                            </div>

                                            <label for="manual_file" id="manual_file" class="error">
                                                <?php $__errorArgs = ['manual_file'];
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


                                <div class="col-lg-12 p-t-10 text-center">
                        <button type="submit" class="btn btn-primary waves-effect m-r-10">Submit</button>
                        

                    </div>
                            

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
                                   <td class="center"><a href="<?php echo e(url('/delete-manual')); ?>/<?php echo e($datalist->id); ?>" class="btn btn-tbl-delete bg-danger" id="delete"> <i
                                                        class="material-icons">delete</i>
                                                </a></td>
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
     </section>

     <script>
   function confirm_option(action){
      if(!confirm("Are you sure to "+action+", this record!")){
         return false;
      }

      return true;

   }
</script>
    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/user/manage-manual.blade.php ENDPATH**/ ?>