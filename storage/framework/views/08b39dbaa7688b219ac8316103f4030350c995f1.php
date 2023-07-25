<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<title>FAQ: RAV Accreditation</title>

<style>
.error{
     color: red;
}


nav {
    box-shadow:none!important;
    webkit-box-shadow:none!important;
  }
  nav .justify-content-sm-between{
    background-color: #fff!important;
    font-size: 14px;
    color: #555;
    box-shadow:none!important;
    webkit-box-shadow:none!important;
  }
  nav small,nav .small {
    font-size: 14px;
  }

  .page-item .page-link{
    display: inline!important;
  }

  .alert
  {
  	color: #000 !important;
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
                                <h4 class="page-title">View FAQs</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">FAQs</a>
                            </li>

                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">General FAQs</a>
                            </li>
                           
                        </ul>
                    </div>
                </div>
            </div>
           

                    
                        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="profile-tab-box">
                                            <div class="p-l-20">
                                            <span style="font-weight:bold">Question <?php echo e($k+1); ?>:</span><br> <?php echo e($faq->question); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="profile-tab-box">
                                            <div class="p-l-20">
                                            <span  style="font-weight:bold">Answer:</span><br> <?php echo $faq->answer; ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  
                      
                           
                        </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>

   


    </section>



    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/pages/faq-view.blade.php ENDPATH**/ ?>