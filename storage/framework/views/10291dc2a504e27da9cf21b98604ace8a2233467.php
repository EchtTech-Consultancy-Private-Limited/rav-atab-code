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
           <?php if(count($errors) > 0): ?>
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                   <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <li><?php echo e($error); ?></li>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
            <?php endif; ?>
            <div class="container-fluid">
              <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          
                       <ul class="breadcrumb breadcrumb-style ">
                          <li class="breadcrumb-item">
                             <h6 class="page-title"> Documents  History </h6>
                             
                          </li>
                          <li class="breadcrumb-item bcrumb-1">
                            <a href="<?php echo e(url('/dashboard')); ?>">
                             <i class="fas fa-home"></i> Home</a>
                          </li>
                          
                          <li class="breadcrumb-item active">Documents History </li>
                       </ul>
                       <?php if($message = Session::get('success')): ?>
                         <div class="alert alert-success">
                            <p><?php echo e($message); ?></p>
                         </div>
                      <?php endif; ?>
                    </div>
                </div>
              </div>
            <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
               <div class="body">
               <div class="table-responsive">
                     <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row"><div class="col-sm-12">
                            <table class="table table-hover js-basic-example contact_list dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                        <thead>
                           <tr role="row">
                                <th class="center sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label=" No : activate to sort column descending"> S.No. </th>
                                <th class="center sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label=" No : activate to sort column descending"> Comments  </th>
                                <th class="center sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Name : activate to sort column ascending">Date </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                                                                                       
                                                            
                                                            
                                                            
                        <?php $__currentLoopData = $comment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$comments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                                                 
                        <tr class="gradeX odd ">
                                 <td class="center sorting_1"><?php echo e(++$key); ?></td>
                                  <td class="center"><a ><b><?php echo e($comments->comments); ?></b></a></td>
                                 <td class="center"><a ><?php echo e($comments->created_at); ?></a></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </tbody>
                     </table>
                    </div></div>
                    
                  </div>
               </div>
            </div>
         </div>
         <a style="line-height:2;" type="button" class="btn btn-secondary" href="<?php echo e(url()->previous()); ?>">Back To Documents</a>
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

<?php /**PATH D:\xampp\htdocs\atab\resources\views/asesrar/show-comment.blade.php ENDPATH**/ ?>