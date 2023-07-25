<!DOCTYPE html>
 <!-- saved from url=(0065)http://localhost/Accr-Gireesh/accr_project/public/forget-password -->
 <html>

 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <title>Forget password </title>
     <!-- External CSS libraries -->
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta charset="UTF-8">
     <!-- External CSS libraries -->
     <link type="text/css" rel="stylesheet" href="{{ asset('login/assets/css/bootstrap.min.css') }}">
     <link type="text/css" rel="stylesheet" href="{{ asset('login/assets/fonts/font-awesome/css/font-awesome.min.css') }}">
     <link type="text/css" rel="stylesheet" href="{{ asset('login/assets/fonts/flaticon/font/flaticon.css') }}">

     <!-- Favicon icon -->
     <link rel="shortcut icon" href="{{ asset('login/assets/img/logo.png" type="image/x-icon') }}">

     <!-- Google fonts -->
     <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap"
         rel="stylesheet">

     <!-- Custom Stylesheet -->
     <link type="text/css" rel="stylesheet" href="{{ asset('login/assets/css/style.css') }}">

     <style type="text/css">
         @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

         body {
             margin: 0;
             font-size: .9rem;
             font-weight: 400;
             line-height: 1.6;
             color: #212529;
             text-align: left;
             background-color: #f5f8fa;
         }

         .navbar-laravel {
             box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
         }

         .navbar-brand,
         .nav-link,
         .my-form,
         .login-form {
             font-family: Raleway, sans-serif;
         }

         .my-form {
             padding-top: 1.5rem;
             padding-bottom: 1.5rem;
         }

         .my-form .row {
             margin-left: 0;
             margin-right: 0;
         }

         /* for password eye */
         .eye {
             position: relative;
             right: 5%;
             margin: auto;
             float: right;
         }

         .input_password {}

         .login-form {
             padding-top: 1.5rem;
             padding-bottom: 1.5rem;
         }

         .login-form .row {
             margin-left: 0;
             margin-right: 0;
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
                         <img src="{{ asset('login/assets/img/bg-img/img1.png') }}" class="img-bga">
                         <img src="{{ asset('login/assets/img/bg-img/img2.png') }}" class="img-bga">
                         <img src="{{ asset('login/assets/img/bg-img/img3.png') }}" class="img-bga">
                     </div>
                     <div class="img-left-box img-right-box">
                         <img src="{{ asset('login/assets/img/bg-img/img4.png') }}" class="img-bga">
                         <img src="{{ asset('login/assets/img/bg-img/img5.png') }}" class="img-bga">
                         <img src="{{ asset('login/assets/img/bg-img/img6.png') }}" class="img-bga">
                     </div>

                     <div class="col-lg-6 align-self-center pad-0 form-info">
                         <div class="form-section align-self-center">
                             <div class="over">
                                 <div class="logo-2 logo">
                                     <a href="javascript:void();">
                                         <img src="{{ asset('login/assets/img/logo.png') }}" alt="logo">
                                     </a>
                                 </div>

                                 <h3>Forgot Password</h3>
                                 @if (Session::has('message'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('message') }}
                                    </div>
                                @endif

                                 <div class="clearfix"></div>

                                 <form action="{{ route('forget.password.post') }}" method="POST">
                                     @csrf

                                     <div class="form-group">
                                         <input type="text" id="email_address" class="form-control" value="{{ old('email') }}" placeholder="Enter your Email ID!!"
                                             {{ old('email') }} name="email" required autofocus>
                                         @if ($errors->has('email'))
                                             <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                         @endif

                                     </div>


                                     <div class="d-flex">
                                         <div class="form-group w-40">
                                             {{-- <input name="Captcha" type="text" class="form-control" placeholder="Enter Captcha" aria-label="Captcha Code"> --}}
                                             <input id="captcha" type="text" class="form-control"
                                                 aria-label="Captcha Code" placeholder="Enter Captcha" id="captcha"
                                                 name="captcha">

                                             <label for="captcha" id="captcha-error" class="error">
                                                 @error('captcha')
                                                     {{ $message }}
                                                 @enderror
                                             </label>

                                         </div>

                                         <div class="form-group w-40 float-right d-flex">
                                             <div class="captcha">
                                                 <span>{!! captcha_img('math') !!}</span>
                                                 <button type="button" class="btn_refresh btn-refresh"
                                                     id="btn-refresh"><i
                                                         class="fa
                                                 fa-refresh"
                                                         aria-hidden="true"></i>
                                                 </button>
                                             </div>
                                         </div>
                                     </div>


                                     <div class="form-group clearfix">
                                         <button type="submit" class="btn btn-lg btn-info btn-theme" onclick="return encrypt();">Send Password Reset Link</button>
                                         <!-- <a href="{{ url('/') }}" class="forgot-password float-end link-text">Back to Login</a> -->
                                     </div>
                                 </form>

                                 <p class="mb-0 mt-1 back-btn">Back to <a
                                         href="{{ url('/') }}"
                                         class="link-text">Landing Page</a></p>

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
                                             <img src="{{ asset('login/assets/img/logo.png') }}" alt="logo">
                                         </a>
                                     </div>
                                     <h3 class="main-text">Welcome to <br>
                                         <p class="font-b">Ayurveda Training Accreditation Board</p>
                                     </h3>
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



     <script src="{{ asset('login/assets/js/jquery-3.6.0.min.js') }}"></script>
     <script src="{{ asset('login/assets/js/bootstrap.bundle.min.js') }}"></script>
     <script src="{{ asset('login/assets/js/jquery.validate.min.js') }}"></script>
     <script src="{{ asset('login/assets/js/app.js') }}"></script>
     <!-- Custom JS Script -->


     <script src="https://code.jquery.com/jquery-3.5.1.min.js"
         integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
         integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
     </script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
         integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
     </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>



     <script type="text/javascript">
         $(".btn-refresh").click(function() {
             // alert('hello')
             $('#captcha').val("")
             $.ajax({
                 type: 'GET',
                 url: "{{ url('/refresh_captcha') }}",
                 success: function(data) {
                     $(".captcha span").html(data.captcha);
                 }
             });
         });
     </script>

     <script type="text/javascript">
         $(document).ready(function() {
             // alert('hello')
             $('#captcha').val("")
             $.ajax({
                 type: 'GET',
                 url: "{{ url('/refresh_captcha') }}",
                 success: function(data) {
                     $(".captcha span").html(data.captcha);
                 }
             });
         });
     </script>



 </body><!-- External JS libraries -->

 </html>
