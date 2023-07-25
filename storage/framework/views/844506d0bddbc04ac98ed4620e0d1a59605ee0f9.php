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
         

            <?php if(Session::has('success')): ?>
            <div class="alert alert-success" role="alert">
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
                        <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card project_widget">

                                        <div class="body">

                                            
                                                <h4>Create NC</h4><br><br>
                                                <?php if($doc_latest_record_comment>=2): ?> 
                                                <h2 class="text-center">You Have Created Two Times NC So Now You Can not Create NC </h2>
                                                <?php else: ?>
                                                     <form method="post" action="<?php echo e(url('add-accr-comment-view-doc')); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                        <input type="hidden"  value="<?php echo e($doc_id); ?>" name="doc_id">
                                                        <input type="hidden"  value="<?php echo e($doc_code); ?>" name="doc_code">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-4">
                                                                <label>Select Type</label>
                                                                <select class="form-control text-center" id="show-view-doc-options" name="status" required>
                                                                    <option>--Select--</option>
                                                                    <option value="1">Approved</option>
                                                                    <option value="2">Not Approved</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-sm-12 col-md-4" id="doc-comment-textarea">
                                                                
                                                                <label>Add Comment</label>
                                                                <textarea rows="10" cols="60" name="doc_comment" class="form-control"></textarea>
                                                            </div>
                                                            <input type="submit" value="Add Comment" class="btn btn-primary">
                                                        </div>
                                                    </form>

                                                <?php endif; ?>
                                           
                                                
                                               
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

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title"></h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Display file</li>
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

                                        <div class="body">

                                            <object data="<?php echo e(url('level'.'/'.$id)); ?>" type="application/pdf" width="100%" height="500px">
                                                <p>Unable to display PDF file. <a href="<?php echo e(url('level'.'/'.$id)); ?>">Download</a> instead.</p>
                                            </object>

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

   

<br><br><br><br><br><br><br><br>
<script>
    $( document ).ready(function() {
         $('#doc-comment-textarea').hide();
         
      });

          $('#show-view-doc-options').on('change', function(){

          var listvalue = $(this).val();
          //alert(listvalue);   
          if(listvalue==1)
          {
               $('#doc-comment-textarea').hide();
          } 
          else if(listvalue==2)
          {
              $('#doc-comment-textarea').show();
          }

          else if(listvalue=='')
          {
              $('#doc-comment-textarea').hide();
          }
             
            
         });
</script>
    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/asesrar/view-doc-with-comment.blade.php ENDPATH**/ ?>