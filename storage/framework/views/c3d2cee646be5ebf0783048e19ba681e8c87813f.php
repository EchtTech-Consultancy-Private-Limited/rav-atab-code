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
                                <h4 class="page-title">Manage Profile</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="<?php echo e(url('/dashboard')); ?>">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Edit Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header" style="display:none;">
                            <h2>
                                <strong>Add</strong> User
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu float-end">
                                        <li>
                                            <a href="javascript:void(0);">Action</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">Another action</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">Something else here</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <?php if($message = Session::get('success')): ?>
                            <div class="alert alert-success">
                                <p><?php echo e($message); ?></p>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?php echo e(url('/profile_submit' . '/' .dEncrypt($data->id))); ?>"
                            class="javavoid(0) validation-form123" id="regForm" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($data->id); ?>">

                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Title<span class="text-danger">*</span></label>
                                                <select name="title" class="form-control" id="title">
                                                    <option value="">Select Title </option>
                                                    <option value="Mr" <?php echo e($data->title == 'Mr' ? 'selected' : ''); ?>>
                                                        Mr.</option>
                                                    <option value="Mrs"
                                                        <?php echo e($data->title == 'Mrs' ? 'selected' : ''); ?>>Mrs.</option>
                                                    <option value="Miss"
                                                        <?php echo e($data->title == 'Miss' ? 'selected' : ''); ?>>Miss</option>
                                                    <option value="Ms" <?php echo e($data->title == 'Ms' ? 'selected' : ''); ?>>
                                                        Ms.</option>
                                                    <option value="Dr" <?php echo e($data->title == 'Dr' ? 'selected' : ''); ?>>
                                                        Dr.</option>
                                                    <option value="Vd"
                                                        <?php echo e($data->title == 'Vd' ? 'selected' : ''); ?>>Vd.</option>
                                                </select>
                                            </div>

                                            <label for="title" id="title-error" class="error">
                                                <?php $__errorArgs = ['title'];
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
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>First Name<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="First Name" name="firstname"
                                                    class="special_no" id="firstname" value="<?php echo e($data->firstname); ?>"
                                                    id="firstname">
                                            </div>

                                            <label for="firstname" id="firstname-error" class="error">
                                                <?php $__errorArgs = ['firstname'];
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
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Middle Name</label>
                                                <input type="text" placeholder="Middle Name" id="middlename"
                                                    class="special_no" name="middlename"
                                                    value="<?php echo e($data->middlename); ?>">
                                            </div>

                                            <label for="middlename" id="middlename-error" class="error">
                                                <?php $__errorArgs = ['middlename'];
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


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Last Name<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Last Name" id="lastname"
                                                    class="special_no" name="lastname"
                                                    value="<?php echo e($data->lastname); ?>">
                                            </div>


                                            <label for="lastname" id="lastname-error" class="error">
                                                <?php $__errorArgs = ['lastname'];
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
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Organization/Institute Name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" placeholder="Organization/Institute Name"
                                                    name="organization" value="<?php echo e($data->organization); ?>">
                                            </div>

                                            <label for="organization" id="organization-error" class="error">
                                                <?php $__errorArgs = ['organization'];
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
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Email</label>
                                                <input type="email" placeholder="Enter Email id" id="email"
                                                    name="email" value="<?php echo e($data->email); ?>" id="email"
                                                    onkeydown="validation()" readonly>
                                            </div>

                                            <label for="email" id="email-error" class="error">
                                                <?php $__errorArgs = ['email'];
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

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Address<span class="text-danger">*</span></label>
                                                <textarea cols="15" rows="2" name="address" id="address" class="form-control capitalize"
                                                    placeholder="Street Address"><?php echo e($data->address); ?></textarea>
                                            </div>

                                            <label for="address" id="address-error" class="error">
                                                <?php $__errorArgs = ['address'];
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
                                        <div class="form-group">
                                            <div class="form-line">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Gender<span class="text-danger">*</span></label>
                                                        <div class="name">
                                                            <label for="male">
                                                                <input type="radio" id="male" name="gender"
                                                                    value="Male" class="radio" value="Male"
                                                                    <?php echo e($data->gender == 'Male' ? 'checked' : ''); ?>>
                                                                <span>Male</span>
                                                            </label>
                                                            <label for="Female" class="">
                                                                <input type="radio" id="Female" name="gender"
                                                                    value="Female" class="radio" value="Male"
                                                                    <?php echo e($data->gender == 'Female' ? 'checked' : ''); ?>>
                                                                <span>Female</span>
                                                            </label>
                                                            <label for="Other" class="">
                                                                <input type="radio" id="Other" name="gender"
                                                                    value="Other" class="radio" value="Male"
                                                                    <?php echo e($data->gender == 'Other' ? 'checked' : ''); ?>>
                                                                <span>Other</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label for="gender" id="gender-error" class="error">
                                                    <?php $__errorArgs = ['gender'];
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
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Mobile Number<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Enter Mob No." name="mobile_no"
                                                    id="mobile_no" value="<?php echo e($data->mobile_no); ?>" maxlength="10"
                                                    readonly>
                                            </div>

                                            <label for="mobile_no" id="mobile_no-error" class="error">
                                                <?php $__errorArgs = ['mobile_no'];
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
                                        <div class="form-group">
                                            <div class="form-line">

                                                <label>Designation<span class="text-danger">*</span></label>
                                                <select name="designation" class="form-control" id="designation">
                                                    <option value=""
                                                        <?php echo e($data->designation == '' ? 'selected' : ''); ?>>Select
                                                        Designation</option>
                                                    <option value="Owner"
                                                        <?php echo e($data->designation == 'Owner' ? 'selected' : ''); ?>>Owner
                                                    </option>
                                                    <option value="Coordinator"
                                                        <?php echo e($data->designation == 'Coordinator' ? 'selected' : ''); ?>>
                                                        Coordinator</option>
                                                </select>
                                            </div>

                                            <label for="designation" id="designation-error" class="error">
                                                <?php $__errorArgs = ['designation'];
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
                                        <div class="form-group">
                                            <div class="form-line">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Country<span class="text-danger">*</span></label>

                                                        <select name="Country" class="form-control" id="Country" readonly >
                                                            <option value="">Select Country</option>
                                                            <?php $__currentLoopData = $Country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Countrys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($Countrys->id); ?>"
                                                                    <?php echo e($data->country == $Countrys->id ? 'selected' : ''); ?>>
                                                                    <?php echo e($Countrys->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>

                                                    </div>


                                                <label for="Country" id="Country-error" class="error">
                                                    <?php $__errorArgs = ['Country'];
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
                                    </div>
                                </div>

                                <div class="row clearfix">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="example-text-input" class="form-control-label">State<span
                                                        class="text-danger">*</span></label>


                                                <select name="state" readonly class="form-control" id="state"
                                                    class="select">
                                                    <option value="<?php echo e($data->state); ?>"><?php echo e($data->state_name); ?>

                                                         </option>
                                                </select>

                                            </div>

                                            <label for="state" id="state-error" class="error">
                                                <?php $__errorArgs = ['state'];
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
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="example-text-input" class="form-control-label">City<span
                                                        class="text-danger">*</span></label>

                                                <select name="city" readonly id="city" class="form-control"
                                                    class="select">


                                                    <option value="<?php echo e($data->city); ?>"><?php echo e($data->city_name); ?>

                                                    </option>
                                                </select>

                                            </div>

                                            <label for="city" id="city-error" class="error">
                                                <?php $__errorArgs = ['city'];
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
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="example-text-input" class="form-control-label" >Postal
                                                    Code<span class="text-danger">*</span></label>
                                                    <input type="text" minlength="2" maxlength="6"  name="postal" id="postal"  placeholder="Postal code"
                                                    value="<?php echo e($data->postal); ?>">
                                            </div>
                                        

                                            <label for="postal" id="postal-error" class="error" style="color:#f44336;">
                                                <?php $__errorArgs = ['postal'];
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




                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="example-text-input" class="form-control-label">New
                                                Password</label>
                                            <i class="fa fa-eye " aria-hidden="true" id="togglepassword"></i>
                                            <input type="password" placeholder="Password" id="password" minlength="8"   maxlength="15"
                                                name="password" autocomplete="new-password">

                                        </div>
                                        <label for="password" id="password-error" class="error">
                                            <?php $__errorArgs = ['password'];
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
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="example-text-input" class="form-control-label">Confirm
                                                Password</label>

                                            <i class="fa fa-eye " aria-hidden="true" id="togglecpassword"></i>

                                        <input type="password" placeholder="Confirm Password" name="cpassword"  minlength="8"   maxlength="15"
                                            value="<?php echo e(old('cpassword')); ?>" for="cpassword" id="cpassword">

                                        <label for="cpassword" id="cpassword-error" class="error">
                                            <?php $__errorArgs = ['cpassword'];
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


                    </div>


                    <?php if(Auth::user()->role == '1'): ?>
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label for="example-text-input"
                                        class="form-control-label">Status<span
                                            class="text-danger">*</span></label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="">Select Status</option>
                                        <option value="0"
                                            <?php echo e($data->status == '0' ? 'selected' : ''); ?>>Active
                                        </option>
                                        <option value="1"
                                            <?php echo e($data->status == '1' ? 'selected' : ''); ?>>Inactive
                                        </option>
                                    </select>
                                </div>
                                <label for="status" id="status-error" class="error">
                                    <?php $__errorArgs = ['status'];
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
                    <?php else: ?>


                    <input type="hidden" value="<?php echo e($data->status); ?>" name="status">



                <?php endif; ?>

                <input type="hidden" value="<?php echo e($data->role); ?>" name="role">



                    <div class="col-lg-12 p-t-20 text-center">
                        <button type="submit" class="btn btn-primary waves-effect m-r-10">Submit</button>
                        <a href="<?php echo e(URL::previous()); ?>" class="btn btn-danger waves-effect">Back</a>

                    </div>
                </div>
                </form>


            </div>
        </div>
        </div>
        </div>
        </div>
    </section>

   



    <script>
       
         $(document).ready(function(){

        var myData = $('#Country').val();
                $.ajax({
                    url: "<?php echo e(url('/state-list')); ?>",
                    type: "get",
                    data: {
                        myData: myData,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        $('#state').html('<option value="">-- Select State --</option>');
                        $.each(result, function (key, value) {
                       
                            $("#state").append('<option value="' + value
                                .id + '" '+(value.id==<?php echo e($data->state); ?>?"SELECTED":"")+'>' + value.name + '</option>');
                        });
                        //$('#city-dropdown').html('<option value="">-- Select City --</option>');
                    }
                });



              
            });


            $(document).ready(function(){

            var myData = $('#state').val();

           
     
                $.ajax({
                    url: "<?php echo e(url('/city-list')); ?>",
                    type: "get",
                    data: {
                        myData: myData,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        $('#city').html('<option value="">-- Select City --</option>');
                        $.each(result, function (key, value) {
                       
                            $("#city").append('<option value="' + value
                                .id + '" '+(value.id==<?php echo e($data->city); ?>?"SELECTED":"")+'>' + value.name + '</option>');
                        });
                        //$('#city-dropdown').html('<option value="">-- Select City --</option>');
                    }
                });



              
            });    
    </script>

       <script>
        const pasteBox = document.getElementById("cpassword");
        pasteBox.onpaste = e => {
          e.preventDefault();
          return false;
        };

        // Alternative syntax:

        // pasteBox.addEventListener('paste', e => {
        //   e.preventDefault();
        //   return false;
        // });
    </script>
    <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/stagtbny/accr-rav.staggings.in/resources/views/user/profile.blade.php ENDPATH**/ ?>