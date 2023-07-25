<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Ayurveda Training Accreditation Board - Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('login/assets/css/bootstrap.min.css')); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('login/assets/fonts/font-awesome/css/font-awesome.min.css')); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('login/assets/fonts/flaticon/font/flaticon.css')); ?>">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="<?php echo e(asset('login/assets/img/logo.png" type="image/x-icon')); ?>" >

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('login/assets/css/style.css')); ?>">
<style>

.error{
   color: red !important;
}
</style>

</head>
<body id="top">
<div class="page_loader"></div>


<!-- Login start -->
<div class="login-2 login-background">
    <div class="login-background-inner">
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
    </div>

    <div class="login-2-inner">
        <div class="container">
            <div class="row login-box">

                <div class="img-left-box">
                    <img src="<?php echo e(asset('login/assets/img/bg-img/img1.png')); ?>" class="img-bga">
                    <img src="<?php echo e(asset('login/assets/img/bg-img/img2.png')); ?>" class="img-bga">
                    <img src="<?php echo e(asset('login/assets/img/bg-img/img3.png')); ?>" class="img-bga">
                </div>
                <div class="img-left-box img-right-box">
                    <img src="<?php echo e(asset('login/assets/img/bg-img/img4.png')); ?>" class="img-bga">
                    <img src="<?php echo e(asset('login/assets/img/bg-img/img5.png')); ?>" class="img-bga">
                    <img src="<?php echo e(asset('login/assets/img/bg-img/img6.png')); ?>" class="img-bga">
                </div>

                <div class="col-lg-6 align-self-center pad-0 form-info">

                    <?php if(request()->path() == 'login/admin'): ?>

                    <?php
                        $data= "Admin"
                     ?>

                  <?php elseif(request()->path() == 'login/TP'): ?>

                  <?php

                    $data= "Training Provider"

                  ?>
                  <?php elseif(request()->path() == 'login/Accessor'): ?>

                  <?php

                  $data= "Assessor"

                   ?>
                  <?php elseif(request()->path() == 'login/professional'): ?>

                  <?php

                  $data= "Professional"

                  ?>

                  <?php endif; ?>



                    <div class="form-section align-self-center">
                        <div class="over">
                            <div class="logo-2 logo">
                                <a href="javascript:void();">
                                    <img src="<?php echo e(asset('login/assets/img/logo.png')); ?>" alt="logo">
                                </a>
                            </div>

                            <h3>Sign Into Your Account  <?php echo e($data); ?>   </h3>


                            <?php if(Session::has('success')): ?>
                            <div class="alert alert-success" style="padding: 15px;" role="alert">
                                <?php echo e(session::get('success')); ?>

                            </div>
                            <?php elseif(Session::has('fail')): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo e(session::get('fail')); ?>

                            </div>
                            <?php endif; ?>

                            <div class="clearfix"></div>
                            <form action="<?php echo e(url('/login_post')); ?>" method="post" class="form" id="loginForm"  autocomplete="off">

                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    

                                    <input type="email" placeholder="Email" class="form-control" aria-label="Email Address" name="email" id="email"  value="<?php echo e(old('email')); ?>" onkeydown="validation()" >

                                    <label for="email"  id="email-error" class="error"  >
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

                                <div class="form-group clearfix">

                                    <input type="password" autocomplete="new-password"  class="form-control" aria-label="Password" placeholder="Password" onpaste="return false;" ondrop="return false;"  name="password" id="password" minlength="8" required   >
                                    <i class="fa fa-eye" aria-hidden="true" id="togglePassword" ></i>
                                   
                                    <label for="password"  id="password-error" class="error" >
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>

                                </div>

                                

                                <?php if(request()->path() == 'login/admin'): ?>
                                <input type="hidden" placeholder="role" name="role" value="<?php echo e(1); ?>">
                                <?php elseif(request()->path() == 'login/TP'): ?>
                                <input type="hidden" placeholder="role" name="role" value="<?php echo e(2); ?>">
                                <?php elseif(request()->path() == 'login/Accessor'): ?>
                                <input type="hidden" placeholder="role" name="role" value="<?php echo e(3); ?>">
                                <?php elseif(request()->path() == 'login/professional'): ?>
                                <input type="hidden" placeholder="role" name="role" value="<?php echo e(4); ?>">
                                <?php endif; ?>


                                <div class="d-flex">
                                    <div class="form-group w-40">
                                        
                                        <input id="captcha" type="text" class="form-control"  aria-label="Captcha Code" placeholder="Enter Captcha" id="captcha" name="captcha">

                                        <label  for="captcha" id="captcha-error" class="error">
                                            <?php $__errorArgs = ['captcha'];
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

                                    <div class="form-group w-40 float-right d-flex">
                                        <div class="captcha">
                                            <span><?php echo captcha_img('math'); ?></span>
                                            <button type="button" class="btn_refresh btn-refresh" id="btn-refresh"><i class="fa
                                                fa-refresh" aria-hidden="true"></i>
                                             </button>
                                         </div>
                                    </div>
                                </div>



                                <div class="form-group clearfix">
                                    <button type="submit" class="btn btn-lg btn-info btn-theme"  class="submit" onclick="return encrypt();">Login</button>
                                    <a href="<?php echo e(route('forget.password.get')); ?>" class="forgot-password float-end link-text">Forgot Password</a>
                                </div>
                            </form>



                            <?php if(request()->path() == 'login/admin'): ?>

                            <?php elseif(request()->path() == 'login/TP'): ?>
                            <p class="mb-0">Don't have an account? <a href="<?php echo e(url(request()->path().'/'.'register')); ?>" class="link-text">Register here</a></p>
                            <?php elseif(request()->path() == 'login/Accessor'): ?>
                            <p class="mb-0">Don't have an account? <a href="<?php echo e(url(request()->path().'/'.'register')); ?>" class="link-text">Register here</a></p>
                            <?php elseif(request()->path() == 'login/professional'): ?>
                            <p class="mb-0">Don't have an account? <a href="<?php echo e(url(request()->path().'/'.'register')); ?>" class="link-text">Register here</a></p>
                            <?php endif; ?>

                            <p class="mb-0 mt-1 back-btn">Back to <a href="<?php echo e(url('/')); ?>" class="link-text">Landing Page</a></p>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center pad-0 bg-img">
                    <div class="info clearfix">
                        <div class="box">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <div class="content">
                                <div class="logo-2">
                                    <a href="<?php echo e(url('/')); ?>">
                                        <img src="assets/img/logo.png" alt="logo">
                                    </a>
                                </div>
                                <h3 class="main-text">Welcome to <br> <p class="font-b">Ayurveda Training Accreditation Board</p></h3>
                                <div class="social-list">
                                    <a href="javascript:void();" class="facebook-bg">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                    <a href="javascript:void();" class="twitter-bg">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                    <a href="javascript:void();" class="google-bg">
                                        <i class="fa fa-google"></i>
                                    </a>
                                    <a href="javascript:void();" class="linkedin-bg">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login end -->

<!-- External JS libraries -->
<script src="<?php echo e(asset('login/assets/js/jquery-3.6.0.min.js')); ?>"></script>
<script src="<?php echo e(asset('login/assets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('login/assets/js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('login/assets/js/app.js')); ?>"></script>
<!-- Custom JS Script -->


<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>


<script>
    $(document).ready(function() {
        $("#togglePassword").click(function(){
            $(this).toggleClass('fa-eye')
            $(this).toggleClass('fa-eye-slash')
        })
    })

    

 </script>

<script>
    $(document).ready(function() {
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 50
                },
                password: {
                    required: true,
                    minlength: 8
                },
                captcha:{
                    required: true,
                },

            },
            messages: {

                email: {
                    required: "Email is required",
                    email: "Email must be a valid email address",
                    maxlength: "Email cannot be more than 50 characters",
                },

                password: {
                    required: "Password is required",
                    minlength: "Password must be 8 to 15 characters"
                },
                captcha:{
                    required: "captcha is required",
                    reCaptchaMethod: true
                },

            }
        });
    });
</script>


<script type="text/javascript">

    $(".btn-refresh").click(function(){
       // alert('hello')
        $('#captcha').val("")
      $.ajax({
         type:'GET',
         url:"<?php echo e(url('/refresh_captcha')); ?>",
         success:function(data){
            $(".captcha span").html(data.captcha);
         }
      });
    });


  /*
 function encrypt()
{
/var pass=document.getElementById('password').value;
var hide=document.getElementById('hide').value;
alert();
if(pass=="")
{
document.getElementById('err').innerHTML='Error:Password is missing';
return false;
}
else
{
document.getElementById("hide").value = document.getElementById("password").value;
var hash = CryptoJS.MD5(pass);
document.getElementById('password').value=hash;
return true;
}

}*/



function encrypt()
{

  $str=$("#password").val();
  for($i=0; $i<5;$i++)
  {
    $str=reverseString(btoa($str));
  }
  $("#password").val($str);

  $("#loginForm").submit();

}

function reverseString(str) {
    var splitString = str.split("");
    var reverseArray = splitString.reverse();
    var joinArray = reverseArray.join("");
    return joinArray;
}
</script>




<script>
    $(document).ready(function() {
        function disableBack() {
            window.history.forward()
        }
        window.onload = disableBack();
        window.onpageshow = function(e) {
            if (e.persisted)
                disableBack();
        }
    });
</script>


<script>
    let password = document.querySelector('#password');
    let togglePassword = document.querySelector('#togglePassword');

    togglePassword.addEventListener('click', (e)=>{
        const type = password.getAttribute('type') === 'password' ? 'text' :'password';

        password.setAttribute('type', type);

        this.classlist.toggle('fa-eye-slash');
    });
</script>




</body>

</html>


<?php /**PATH D:\xampp\htdocs\atab\resources\views/auth/login.blade.php ENDPATH**/ ?>