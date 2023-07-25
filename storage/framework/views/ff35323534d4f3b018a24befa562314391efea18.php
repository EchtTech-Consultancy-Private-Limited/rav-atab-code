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

<h1>Hreeeeeeeeeeeeeeee</h1>
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

                                            
                                                <h4>Update Document Status</h4><br><br>
                                              
                                                     <form method="post" action="<?php echo e(url('document-report-by-admin')); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="previous_url" value="<?php echo e(Request::url()); ?>">
                                                        <input type="hidden"  value="<?php echo e($course_id); ?>" name="course_id">
                                                        
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-8" >
                                                                
                                                                <label>Add Comment</label>
                                                                <input type="text" name="doc_admin_comment" class="form-control">
                                                            </div>

                                                             <div class="col-sm-12 col-md-4">
                                                               
                                                                <input type="hidden" name="send_to_admin" value="1">
                                                            </div>

                                                            <input type="submit" value="Add Comment" class="btn btn-primary">
                                                        </div>
                                                    </form>

                                            
                                           
                                                
                                               
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

<?php /**PATH D:\xampp\htdocs\atab\resources\views/asesrar/document-report-by-admin.blade.php ENDPATH**/ ?>