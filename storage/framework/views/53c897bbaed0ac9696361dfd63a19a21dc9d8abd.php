<?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>

@media (min-width: 900px){
.modal-dialog {
    max-width: 674px;
}
}

</style>


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
                                <h4 class="page-title">Level Upgrade </h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Level Upgrade </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row ">
            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">


                    <?php if(Session::has('success')): ?>
                    <div class="alert alert-success" style="padding: 15px;" role="alert">
                        <?php echo e(session::get('success')); ?>

                    </div>
                    <?php elseif(Session::has('fail')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo e(session::get('fail')); ?>

                    </div>
                    <?php endif; ?>

                    <div class="tab-content">


                            <div class="card">
                                <div class="header">
                                    <h2>Basic Information</h2>
                                </div>
                                <div class="body">

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                         <div class="form-line">
                                           <label ><strong>Title</strong></label><br>
                                               <label ><?php echo e($data->title ??''); ?></label>
                                         </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                        <div class="form-line">
                                           <label><strong>First Name</strong></label><br>
                                            <?php echo e($data->firstname ??''); ?>

                                        </div>
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">

                                            <label><strong>Middle Name</strong></label><br>

                                              <label><?php echo e($data->middlename ??''); ?></label>

                                        </div>
                                     </div>
                                     </div>
                                </div>
                                <div class="row clearfix">
                                   <div class="col-sm-4">
                                     <div class="form-group">
                                      <div class="form-line">
                                        <label><strong>Last Name</strong></label><br>
                                        <label><?php echo e($data->lastname ??''); ?></label>
                                      </div>
                                      </div>
                                    </div>

                                   <div class="col-sm-4">
                                      <div class="form-group">
                                        <div class="form-line">
                                         <label><strong>Orgnisation/Insitute Name</strong></label><br>
                                         <label><?php echo e($data->organization ??''); ?></label>
                                        </div>
                                      </div>
                                   </div>

                                   <div class="col-sm-4">
                                     <div class="form-group">
                                       <div class="form-line">
                                         <label><strong>Email</strong></label><br>
                                         <label><?php echo e($data->email ??''); ?></label>
                                        </div>
                                      </div>
                                     </div>
                                </div>



                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                            <label><strong>Mobile Number</strong></label><br>
                                            <label><?php echo e($data->mobile_no  ??''); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label><strong>Desigantion</strong></label><br>
                                            <label><?php echo e($data->designation ??''); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <div class="form-group">
                                            <div class="form-line">
                                             <label><strong>Country</strong></label><br>

                                              <label><?php echo e($data->country_name ??''); ?></label>

                                              <input type="hidden" id="Country" value="<?php echo e($data->country ??''); ?>" >

                                            </div>
                                         </div>
                                    </div>
                                   </div>
                                </div>
                            </div>




                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>State</strong></label><br>
                                                <label><?php echo e($data->state_name ??''); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label><strong>City</strong></label><br>
                                                <label><?php echo e($data->city_name ??''); ?></label>
                                            </div>
                                        </div>
                                    </div>


                                  <div class="col-sm-4">
                                    <div class="form-group">
                                       <div class="form-line">
                                        <label><strong>Pastal Code</strong></label><br>
                                        <label><?php echo e($data->postal  ??''); ?></label>
                                       </div>
                                    </div>
                                 </div>
                               </div>



                                <div class="row clearfix">
                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                            <label><strong>Address</strong></label><br>
                                            <label><?php echo e($data->address ??''); ?></label>
                                        </div>
                                     </div>
                                  </div>
                               </div>

                                <!-- basic end -->
                              </div>
                              </div>




                    <div class="card">
                            <div class="header">
                                <h2 style="float:left; clear:none;">


                                    Upgrade Level Courses


                                </h2>
                                <h6 style="float:right; clear:none; cursor:pointer;" onclick="add_new_course();" id="count"  >Add More Course</h2>
                            </div>

                        <form  action="<?php echo e(url('/new-application-course')); ?>"  method="post" class="form" id="regForm">
                            <?php echo csrf_field(); ?>

                                 <?php $__currentLoopData = $Course; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="body" id="courses_body">
                                      <!-- level start -->

                                         <div class="row clearfix">



                                         <input type="hidden" name="id" value="<?php echo e($item->id); ?>">


                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Course Name<span class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Course Name"  name="course_name[]" value="<?php echo e($item->course_name); ?>"   required >
                                                    </div>
                                                    <?php $__errorArgs = ['course_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Course Duration(In Days)<span class="text-danger">*</span></label>
                                                        <input type="number" placeholder="Course Duration" name="course_duration[]" value="<?php echo e($item->course_duration); ?>"  required >
                                                    </div>
                                                    <?php $__errorArgs = ['course_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>



                                            <div class="col-sm-2">
                                               <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Eligibility<span class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Eligibility" name="eligibility[]" value="<?php echo e($item->eligibility); ?>"  required >
                                                    </div>
                                                    <?php $__errorArgs = ['eligibility'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Mode of Course <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="mode_of_course[]"  required >
                                                            <option value="" SELECTED>Select Mode</option>
                                                            <option value="Online"  <?php echo e($item->mode_of_course == "Online" ? "selected" : ""); ?>    >Online</option>
                                                            <option value="Offline" <?php echo e($item->mode_of_course == "Offline" ? "selected" : ""); ?>>Offline</option>
                                                        </select>
                                                    </div>

                                                    <?php $__errorArgs = ['mode_of_course'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                        <div class="form-line">
                                                            <label>Course Brief <span class="text-danger">*</span></label>
                                                            <input type="text" placeholder="Course Brief" name="course_brief[]" value="<?php echo e($item->course_name); ?>"  required >
                                                        </div>

                                                        <?php $__errorArgs = ['course_brief'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="alert alert-danger"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if(request()->path() == 'application-upgrade-second'): ?>
                                            <input type="hidden" placeholder="level_id" name="level_id" value="<?php echo e(2); ?>">
                                            <?php elseif(request()->path() == 'application-upgrade-third'): ?>
                                            <input type="hidden" placeholder="level_id" name="level_id" value="<?php echo e(3); ?>">
                                            <?php elseif(request()->path() == 'application-upgrade-fourth'): ?>
                                            <input type="hidden" placeholder="level_id" name="level_id" value="<?php echo e(4); ?>">
                                            <?php endif; ?>


                                               <!-- level end -->

                                    </div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <div class="center">
                                        <button class="btn btn-primary waves-effect m-r-15">Save</button> <button type="button" class="btn btn-danger waves-effect">Back</button>
                                    </div>

                                  </form>
                                </div>




                            <div class="card">
                                <div class="header">
                                    <h2 style="float:left; clear:none;">Payment</h2>
                                    <h6 style="float:right; clear:none;" id="counter">

                                    <?php if(isset($total_amount )): ?>

                                    Total Amount: <?php echo e($currency ??''); ?>.<?php echo e($total_amount  ??''); ?>


                                    <?php endif; ?>



                                    </h2>
                                </div>
                                <div class="body">
                                        <div class="form-group">
                                           <div class="form-line">
                                              <label >Payment Mode<span class="text-danger">*</span></label>
                                                 <select name="payment" class="form-control" id="payments">
                                                   <option value=""  >Select Option</option>
                                                   <option value="QR-Code"  <?php echo e(old('QR-Code') == "QR-Code" ? "selected" : ""); ?>>QR Code</option>
                                                   <option value="Bank" <?php echo e(old('title') == "Bank" ? "selected" : ""); ?>>Bank Transfers</option>
                                                  </select>
                                           </div>


                                        </div>



                                    <!-- payment start -->

                                    <div  style="text-align:center; width:100%;" id="QR">
                                        <div style="width:100px; height:100px; border:1px solid #ccc; float:right;"><img src="<?php echo e(asset('/assets/images/demo-qrcode.png')); ?>" width="100" height="100"></div>
                                    </div>
                                        <div class="row clearfix"  id="bank_id">
                                            <div class="col-sm-2">
                                              <div class="form-group">
                                                <div class="form-line">
                                                    <label><strong>Bank Name</strong></label>
                                                    <p>Punjab National Bank</p>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                  <div class="form-line">
                                                      <label>  <strong>Acccounts Number</strong> </label>
                                                      <p>112233234400987</p>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-sm-2">
                                                <div class="form-group">
                                                  <div class="form-line">
                                                      <label> <strong>IFSC Code</strong> </label>
                                                      <p>PUNB00987</p>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-sm-2">
                                                <div class="form-group">
                                                  <div class="form-line">
                                                      <label> <strong>Branch Name</strong> </label>
                                                      <p>Main Market, Punjabi Bagh, New Delhi</p>
                                                  </div>
                                                </div>
                                              </div>
                                        </div>



                            <form  action="<?php echo e(url('/new-application_payment')); ?>"  method="post" class="form" id="regForm" enctype="multipart/form-data" >
                                <?php echo csrf_field(); ?>

                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>Payment Date <span class="text-danger">*</span></label>
                                            <input type="date" name="payment_date" class="form-control" id="payment_date" placeholder="Payment Date "aria-label="Date" required value="<?php echo e(old('payment_date')); ?>"  onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>

                                        <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="alert alert-danger"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                                    </div>
                                </div>


                                <input type='hidden' name="amount" value="<?php echo e($total_amount ??''); ?>">

                                

                                <input type='hidden' name="currency" value="<?php echo e($currency  ??''); ?>">


                                <?php if(request()->path() == 'application-upgrade-second'): ?>
                                <input type="hidden" placeholder="level_id" name="level_id" value="<?php echo e(2); ?>">
                                <?php elseif(request()->path() == 'application-upgrade-third'): ?>
                                <input type="hidden" placeholder="level_id" name="level_id" value="<?php echo e(3); ?>">
                                <?php elseif(request()->path() == 'application-upgrade-fourth'): ?>
                                <input type="hidden" placeholder="level_id" name="level_id" value="<?php echo e(4); ?>">
                                <?php endif; ?>



                                    <div class="col-sm-3">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label>Payment Transaction no. <span class="text-danger">*</span></label>
                                        <input type="number" placeholder="Payment Transaction no." id="payment_transaction_no" name="payment_transaction_no"  required  value="<?php echo e(old('payment_transaction_no')); ?>">
                                      </div>

                                      <?php $__errorArgs = ['payment_transaction_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                      <div class="alert alert-danger"><?php echo e($message); ?></div>
                                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label>Payment Reference no. <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Payment Transaction no." name="payment_reference_no" value="<?php echo e(old('payment_reference_no')); ?>">
                                      </div>

                                      <?php $__errorArgs = ['payment_reference_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                      <div class="alert alert-danger"><?php echo e($message); ?></div>
                                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label>Payment Screenshot <span class="text-danger">*</span></label>
                                        <input type="file" name="payment_details_file" id="payment_details_file" required   class="form-control"  >
                                      </div>

                                      <?php $__errorArgs = ['payment_details_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                      <div class="alert alert-danger"><?php echo e($message); ?></div>
                                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                             </div>


                                    <!-- payment end -->
                                </div>
                            </div>
                            <div class="center">
                                <button class="btn btn-primary waves-effect m-r-15">Save</button> <button type="button" class="btn btn-danger waves-effect">Back</button>
                            </div>
                            <br>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


                                 <div id="add_courses" style="Display:none">

                                   <div class="row clearfix">

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Name<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Course Name" name="course_name[]"  required >
                                            </div>

                                            <?php $__errorArgs = ['course_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                                        </div>
                                        </div>

                                        <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Duration<span class="text-danger">*</span></label>
                                                <input type="number" placeholder="Course Duration" name="course_duration[]"  required >
                                            </div>

                                            <?php $__errorArgs = ['course_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        </div>
                                        <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Eligibility<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Eligibility" name="eligibility[]"  required >
                                            </div>

                                            <?php $__errorArgs = ['eligibility'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                                        </div>
                                        </div>

                                        <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Mode of Course <span class="text-danger">*</span></label>
                                                <select class="form-control" name="mode_of_course[]" required >
                                                    <option value="" SELECTED>Select Mode</option>
                                                    <option value="Online">Online</option>
                                                    <option value="Offline">Offline</option>
                                                </select>
                                            </div>

                                            <?php $__errorArgs = ['mode_of_course'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>






                                        <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Brief <span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Course Brief" name="course_brief[]"  required >
                                            </div>

                                            <?php $__errorArgs = ['course_brief'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

    </div>



<script>
function add_new_course(){

    $("#courses_body").append($("#add_courses").html());

}
</script>


<script>
$(document).ready(function() {
  var count = 0;

 $(window).on('load',function(){
   $data =  $('#Country').val();
   // alert($data);

 });


  $("#count").click(function()
    {
        count++;
   //  alert(count)
     if(count <= 4)
     {

        if($data == '101')
        {
            rupess=1000;
         //   alert(rupess)
            $("#counter").html("Total Amount:₹."+rupess);
             $("#counters").html("value="+rupess);


        }else if($data == '167' || $data == '208'|| $data == '19' || $data == '1' || $data == '133')
        {

            rupess=15;
          //alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);


        }else{

            rupess=50;
            // alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);
        }

     }else if(count <= 9)
     {
        if($data == '101')
        {
            rupess=2000;
         //   alert(rupess)
            $("#counter").html("Total Amount:₹."+rupess);

        }else if($data == '167' || $data == '208'|| $data == '19' || $data == '1' || $data == '133')
        {

            rupess=30;
          //  alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);


        }else{

            rupess=100;
         //   alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);
        }
     }else{
        if($data == '101')
        {
            rupess=3000;
          //  alert(rupess)
            $("#counter").html("Total Amount:₹."+rupess);

        }else if($data == '167' || $data == '208'|| $data == '19' || $data == '1' || $data == '133')
        {

            rupess=45;
           // alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);


        }else{

            rupess=150;
          //  alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);
        }
     }
    }
   );
  });
</script>


<script>
    $(document).ready(function(){



    $( window ).on( "load", function() {
        $("#bank_id").hide();
        $("#QR").hide();
    } );




    $("#payments").on('change',function(){
        $type=$('#payments').val();
        //alert($type);

        if($type == 'QR-Code')
        {
           // alert('hii')
            $("#bank_id").hide();
            $("#QR").show();

        }else if($type == "")
        {
   //  alert('hii1')
           $("#bank_id").hide();
            $("#QR").hide();

        }
        else{

          //  alert('hii1')
            $("#bank_id").show();
            $("#QR").hide();

        }
      });
    });
</script>

<?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/level/level-upgrade.blade.php ENDPATH**/ ?>