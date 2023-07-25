<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<title>FAQ: RAV Accreditation</title>

<style>
.error{
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
                                <h4 class="page-title">Manage FAQs</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">FAQ</a>
                            </li>
                            <li class="breadcrumb-item active">Add FAQ</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Edit</strong> FAQ</h2>
                            
                        </div>

                        <form action="<?php echo e(url('add-faq')); ?>" method="post">

                            <?php echo csrf_field(); ?>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                            <label><strong>FAQ Cateogry</strong></label>
                                        <div class="form-line">
                                            <select class="form-control"  name="category" id="category">
                                                <option value="1">Select Category</option>
                                            <?php if(count(getFaqCategory())>0): ?>
                                                <?php $__currentLoopData = getFaqCategory(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            </select>
                                            <?php $__errorArgs = ['cetagory'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <label for="documents_required"  id="documents_required-error" class="error">
                                                <?php echo e($message); ?>

                                                </label>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                            
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                            <label><strong>Question</strong></label>
                                        <div class="form-line">
                                            <textarea class="form-control" name="question" id="question"  placeholder="Enter Question"></textarea>
                                            <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <label for="documents_required"  id="documents_required-error" class="error">
                                                <?php echo e($message); ?>

                                                </label>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                            <label><strong>Answer</strong></label>
                                        <div class="form-line">
                                            <textarea class="form-control" name="answer" id="answer"  placeholder="Enter Answer"></textarea>
                                            <?php $__errorArgs = ['answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <label for="documents_required"  id="documents_required-error" class="error">
                                                <?php echo e($message); ?>

                                                </label>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                            <label><strong>Sort Order</strong></label>
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="sort_order" id="sort_order"  placeholder="Enter Sort Order">
                                            <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <label for="documents_required"  id="documents_required-error" class="error">
                                                <?php echo e($message); ?>

                                                </label>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit" class="btn btn-primary waves-effect m-r-15">Submit</button>
                                <a  href="<?php echo e(URL::previous()); ?>" class="btn btn-danger waves-effect">Back</a>
                            </div>

                         </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="<?php echo e(asset('assets/js/bundles/tinymce/tinymce.min.js')); ?>" referrerpolicy="origin"></script>
    <script>
         tinymce.init({
        selector: 'textarea#answer',
        menubar: 'edit insert view format table tools',
        plugins: 'lists',
        toolbar: 'undo redo styles bold italic alignleft aligncenter alignright alignjustify | bullist numlist outdent indent'
      });
    </script>



    </section>



    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/pages/faq-add.blade.php ENDPATH**/ ?>