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
                                <h4 class="page-title">Manage FAQs</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">FAQs</a>
                            </li>

                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">All FAQs</a>
                            </li>
                           
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                            <span style="float:right;" >
                                <a type="button" href="<?php echo e(url('/add-faq')); ?>" class="btn btn-primary waves-effect" style="line-height:2;"  title="Add Record">+ Add Faq</a>
                            </span>
                            <ul style="float:right; overflow:hidden;">
                            <form role="form" method="POST" action="<?php echo e(url('get-faqs')); ?>" id="frmfaqs">
                                <?php echo csrf_field(); ?>
                                <li style="float:left;clear:none; margin-top:0px; margin-right:10px;"> 
                                    <select class="form-control" name="category" onchange="javascript:$('#frmfaqs').submit();">
                                        <option value="">Filter Category</option>
                                        <?php
                                            $categories=getFaqCategory();
                                        ?>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php if(request()->category==$key): ?> SELECTED <?php endif; ?>><?php echo e($value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </li>
                            </form>
                            </ul>
                            
                        </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example contact_list" id="data_table">
                                    <thead>
                                        <tr>
                                            <th class="center">S.No#</th>
                                            <th class="center"> Question </th>
                                            <th class="center"> Category </th>
                                            <th class="center"> Sort Order </th>
                                            <th class="center"> Created At </th>
                                            <th class="center"> Status </th>
                                            <th class="center"> Action </th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                    <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="odd gradeX">
                                            <td class="center"><?php if(request()->page): ?><?php echo e((((request()->page-1)*10)+$k+1)); ?><?php else: ?><?php echo e(($k+1)); ?><?php endif; ?></td>
                                            <td class="center"><?php echo e($faq->question); ?></td>
                                            <td class="center"><?php echo e($categories[$faq->category]); ?></td>
                                            <td class="center"><?php echo e($faq->sort_order); ?></td>
                                            <td class="center"><?php echo e(date('d-m-Y',strtotime($faq->created_at))); ?></td>
                                            <td class="center">
                                                <a href="<?php echo e(url('activate-faq/'.dEncrypt($faq->id))); ?>" onclick="return confirm('Are you sure to change status?')" class="<?php if($faq->status==0): ?> btn-tbl-disable <?php elseif($faq->status==1): ?> btn-tbl-edit <?php endif; ?>" title="Change Status">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                           </td>
                                            <th class="center">
                                                <a class="btn btn-primary btn-sm" href="<?php echo e(url('/update-faq'.'/'.dEncrypt($faq->id))); ?>" onclick="return confirm('Are you sure to edit this faq record?')" title="Edit Record">
                                                    <i style="line-height:1.5 !important;" class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" href="<?php echo e(url('/delete-faq'.'/'.dEncrypt($faq->id))); ?>"  onclick="return confirm('Are you sure to delete this faq record?')" title="Delete Record">
                                                    <i class="fa fa-trash" aria-hidden="true" style="line-height:1.5 !important;" ></i>
                                                </a>
                                            </th>
                                           
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                   
                                </table>
                                
                            </div>
                            <?php echo e($faqs->links('pagination::bootstrap-5')); ?>

                        </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>

   


    </section>



    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/pages/faq-index.blade.php ENDPATH**/ ?>