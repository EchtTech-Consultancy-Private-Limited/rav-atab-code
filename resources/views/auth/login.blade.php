<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Ayurveda Training Accreditation Board - Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ asset('login/assets/css/bootstrap.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{ asset('login/assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{ asset('login/assets/fonts/flaticon/font/flaticon.css')}}">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ asset('login/assets/img/logo.png" type="image/x-icon')}}" >

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('login/assets/css/style.css') }}">
<style>

.error{
   color: red !important;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body id="top">
<div class="page_loader"></div>

@if ($message = Session::get('success'))
<script>
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: "Success",
        text: "{{ $message }}",
        showConfirmButton: false,
        timer: 5000
    })
</script>
@endif

@if ($message = Session::get('warning'))
<script>
    Swal.fire({
        position: 'center',
        icon: 'warning',
        title: "Warning",
        text: "{{ $message }}",
        showConfirmButton: false,
        timer: 5000
    })
</script>
@endif
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
                    <img src="{{ asset('login/assets/img/bg-img/img1.png')}}" class="img-bga">
                    <img src="{{ asset('login/assets/img/bg-img/img2.png')}}" class="img-bga">
                    <img src="{{ asset('login/assets/img/bg-img/img3.png')}}" class="img-bga">
                </div>
                <div class="img-left-box img-right-box">
                    <img src="{{ asset('login/assets/img/bg-img/img4.png')}}" class="img-bga">
                    <img src="{{ asset('login/assets/img/bg-img/img5.png')}}" class="img-bga">
                    <img src="{{ asset('login/assets/img/bg-img/img6.png')}}" class="img-bga">
                </div>

                <div class="col-lg-6 align-self-center pad-0 form-info">

                    @if(request()->path() == 'login/admin')

                    <?php
                        $data= "Admin"
                     ?>

                  @elseif(request()->path() == 'login/TP')

                  <?php

                    $data= "Training Provider"

                  ?>
                  @elseif(request()->path() == 'login/Accessor')

                  <?php

                  $data= "Assessor"

                   ?>
                  @elseif(request()->path() == 'login/professional')

                  <?php

                  $data= "Professional"

                  ?>

                  @elseif(request()->path() == 'login/secretariat')

                  <?php

                  $data= "Secretariat"

                  ?>

                @elseif(request()->path() == 'login/account')

                <?php

                $data= "Accountant"

                ?>

                  @endif



                    <div class="form-section align-self-center">
                        <div class="over">
                            <div class="logo-2 logo">
                                <a href="javascript:void();">
                                    <img src="{{ asset('login/assets/img/logo.png')}}" alt="logo">
                                </a>
                            </div>

                            <h3>Sign Into {{ $data }}   </h3>


                            @if(Session::has('success'))
                            <div class="alert alert-success" style="padding: 15px;" role="alert">
                                {{session::get('success')}}
                            </div>
                            @elseif(Session::has('fail'))
                            <div class="alert alert-danger" role="alert">
                                {{session::get('fail')}}
                            </div>
                            @endif

                            <div class="clearfix"></div>
                            <form action="{{ url('/login_post') }}" method="post" class="form" id="loginForm"  autocomplete="off">

                                @csrf
                                <div class="form-group">
                                    {{-- <input name="email" type="email" class="form-control" placeholder="Email Address" aria-label="Email Address"> --}}

                                    <input type="email" placeholder="Email" class="form-control" aria-label="Email Address" name="email" id="email"  value="{{ old('email') }}" onkeydown="validation()" >

                                    <label for="email"  id="email-error" class="error"  >
                                        @error('email')
                                        {{ $message }}
                                        @enderror
                                   </label>

                                </div>

                                <div class="form-group clearfix">

                                    <input type="password" autocomplete="new-password"  class="form-control" aria-label="Password" placeholder="Password" onpaste="return false;" ondrop="return false;"  name="password" id="password" minlength="8" required   >
                                    <i class="fa fa-eye-slash" aria-hidden="true" id="togglePassword" ></i>

                                    <label for="password"  id="password-error" class="error" >
                                        @error('password')
                                        {{ $message }}
                                    @enderror</label>

                                </div>

                                {{-- <input type="hidden" placeholder="role" name="status" value=""> --}}

                                @if(request()->path() == 'login/admin')
                                <input type="hidden" placeholder="role" name="role" value="{{ 1 }}">
                                @elseif(request()->path() == 'login/TP')
                                <input type="hidden" placeholder="role" name="role" value="{{ 2 }}">
                                @elseif(request()->path() == 'login/Accessor')
                                <input type="hidden" placeholder="role" name="role" value="{{ 3 }}">
                                @elseif(request()->path() == 'login/professional')
                                <input type="hidden" placeholder="role" name="role" value="{{ 4 }}">
                                @elseif(request()->path() == 'login/secretariat')
                                <input type="hidden" placeholder="role" name="role" value="{{ 5 }}">
                                @elseif(request()->path() == 'login/account')
                                <input type="hidden" placeholder="role" name="role" value="{{ 6 }}">
                                @endif


                                <div class="d-flex">
                                    <div class="form-group w-60">
                                        {{-- <input name="Captcha" type="text" class="form-control" placeholder="Enter Captcha" aria-label="Captcha Code"> --}}
                                        <input id="captcha" type="text" class="form-control"  aria-label="Captcha Code" placeholder="Enter Captcha" id="captcha" name="captcha">

                                        <label  for="captcha" id="captcha-error" class="error">
                                            @error('captcha')
                                            {{ $message }}
                                        @enderror
                                        </label>

                                    </div>

                                    <div class="form-group w-40 float-right d-flex">
                                        <div class="captcha">
                                            <span>{!! captcha_img('math') !!}</span>
                                            <button type="button" class="btn_refresh btn-refresh" id="btn-refresh"><i class="fa
                                                fa-refresh" aria-hidden="true"></i>
                                             </button>
                                         </div>
                                    </div>
                                </div>



                                <div class="form-group clearfix">
                                    <button type="submit" class="btn btn-lg btn-info btn-theme"  class="submit" onclick="return encrypt();">Login</button>
                                    <a href="{{ route('forget.password.get') }}" class="forgot-password float-end link-text">Forgot Password</a>
                                </div>
                            </form>



                            @if(request()->path() == 'login/admin')

                            @elseif(request()->path() == 'login/TP')
                            <p class="mb-0">Don't have an account? <a href="{{ url(request()->path().'/'.'register') }}" class="link-text">Register here</a></p>

                            @elseif(request()->path() == 'login/Accessor')
                            <p class="mb-0">Don't have an account? <a href="{{ url(request()->path().'/'.'register') }}" class="link-text">Register here</a></p>

                            @elseif(request()->path() == 'login/professional')
                            <p class="mb-0">Don't have an account? <a href="{{ url(request()->path().'/'.'register') }}" class="link-text">Register here</a></p>

                            @elseif(request()->path() == 'login/secretariat')
                            <p class="mb-0">Don't have an account? <a href="{{ url(request()->path().'/'.'register') }}" class="link-text">Register here</a></p>

                            @endif

                            <p class="mb-0 mt-1 back-btn">Back to <a href="{{ url('/') }}" class="link-text">Landing Page</a></p>

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
                                    <a href="{{ url('/') }}">
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
<script src="{{ asset('login/assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('login/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('login/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{ asset('login/assets/js/app.js')}}"></script>
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
         url:"{{ url('/refresh_captcha') }}",
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


{{-- back button  disable --}}

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

        this.classlist.toggle('fa fa-eye-slash');
    });
</script>




</body>

</html>


