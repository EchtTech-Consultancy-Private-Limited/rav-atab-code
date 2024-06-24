<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AYURVEDA TRAINING ACCEREDITATION BOARD</title>

    <link rel="stylesheet" href="{{ asset('login1/css/style.css') }}">

     {{-- custom file  --}}

         <link rel="stylesheet" href="{{ asset('custom/costam.js') }}" class="js">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

      <!-- jQuery -->
      <script src="{{ asset('assets/js/atab-jquery-3.7.1.min.js') }}" ></script>
   <!-- SweetAlert2 -->
   <script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>

    <style>
        .form {
            width: 40%;
        }

        @media (min-width: 1200px){
            .container.width-80 {
                max-width: 1440px;
            }
        }

    </style>



</head>

<body class="body-bg">
   <section class="landing-page-main">
      <div class="container width-80">
         <div class="row align-item-center d-m-flex">
            <div class="col-md-3 order-logo-1">
               <div class="logo-rav logo-m">
                  <a href="javascript:void();">
                  <img src="{{ asset('landing_page/rav_logo.png')}}" alt="title">
                  </a>
               </div>
            </div>
           <div class="col-md-6 order-logo-3"></div>
            <!-- <div class="col-md-6 order-logo-3">
               <div class="logo-center">
                  <a href="javascript:void();">
                     <img src="{{ asset('landing_page/gov.png')}}" alt="title">
                     <p class="site-title">आयुष मंत्रालय, भारत सरकार </p>
                     <small>Ministry of Ayush, Government of India</small>
                  </a>
               </div>
            </div> -->
            <div class="col-md-3 order-logo-2">
               <div class="logo-atab logo-m">
                  <a href="javascript:void();">
                  <img src="{{ asset('landing_page/ATAB.png')}}" alt="title">
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>
   <footer class="footer">
      <p>© 2023 Rashtriya Ayurveda Vidyapeeth, An Autonomous Institute Under Ministry of India | All Rights Reserved.</p>
   </footer>
</body>
</html>
