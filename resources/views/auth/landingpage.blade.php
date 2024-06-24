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
   @if (Session::has('success'))
   <script>
      var message = "{{ session::get('success') }}";
      Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Success',
          text: message,
          showConfirmButton: false,
          timer: 3000
      })
   </script>
   @elseif(Session::has('fail'))
   <div class="alert alert-danger" role="alert">
      {{ session::get('fail') }}
   </div>
   @endif
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
         <div class="row">
            <div class="col-md-12 text-center">
               <h2 class="text-main"> AYURVEDA TRAINING ACCEREDITATION BOARD </h2>
            </div>
         </div>
         <a href="{{ route('makepayment') }}" class="btn btn-success text-center">Payment</a>
         <div class="row pt-lg-60">
            <div class="col-md-5">
               <div class="gif-box">
                  <img src="{{ asset('landing_page/ayurveda.png')}}" alt="title">
                  <h2 class="text-title-l"> About Us </h2>
                  <p class="sub-text-l">
                     ATAB Has Been Set Up By The Ministry Of Ayush For Accreditation Of Ayurveda Courses
                     Operating In India And Abroad, Which Do Not Fall Under The Purview Of NCISM Act 2020
                     (Earlier IMCC Act, 1970). Rashtriya Ayurveda Vidyapeeth Has Been Notified As Accreditation
                     Agency For Various Ayurveda Professional Courses Operating In India As Well As Various
                     Countries Through The Gazette Notification Dated 5th December 2019.
                  </p>
               </div>
            </div>
            <div class="col-md-7">
               <div class="box-card row">
                  <div class="col-md-4">
                     <div class="inner-box">
                        <a href="{{ url('/login/admin') }}">
                           <img src="{{ asset('landing_page/businessman.png') }}" alt="admin-login">
                           <h4>Admin Login <i class="fa fa-long-arrow-right" aria-hidden="true"></i> </h4>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="inner-box">
                        <a href="{{ url('/login/TP')}}">
                           <img src="{{ asset('landing_page/presentation.png')}}" alt="admin-login">
                           <h4>Training Provider Login <i class="fa fa-long-arrow-right" aria-hidden="true"></i> </h4>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="inner-box">
                        <a href="{{ url('/login/Accessor') }}">
                           <img src="{{ asset('landing_page/employee.png')}}" alt="admin-login">
                           <h4>Assessor Login <i class="fa fa-long-arrow-right" aria-hidden="true"></i> </h4>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="inner-box">
                        <a href="{{ url('/login/secretariat') }}">
                           <img src="{{ asset('landing_page/businessman2.png')}}" alt="admin-login">
                           <h4>Secretariat Login <i class="fa fa-long-arrow-right" aria-hidden="true"></i> </h4>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="inner-box">
                        <a href="{{ url('/login/professional') }}">
                           <img src="{{ asset('landing_page/businessman1.png')}}" alt="admin-login">
                           <h4>Professional Login<i class="fa fa-long-arrow-right" aria-hidden="true"></i> </h4>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="inner-box">
                        <a href="{{ url('/login/account') }}">
                           <img src="{{ asset('landing_page/account.png')}}" alt="admin-login">
                           <h4>Accountant Login<i class="fa fa-long-arrow-right" aria-hidden="true"></i> </h4>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <footer class="footer">
      <p>© 2023 Rashtriya Ayurveda Vidyapeeth, An Autonomous Institute Under Ministry of India | All Rights Reserved.</p>
   </footer>
   <script>
      $("document").ready(function () {
          setTimeout(function () {
              $("#alert").remove();
          }, 5000); // 5 secs
      
      });
      
      $(document).ready(function () {
          function disableBack() {
              window.history.forward()
          }
          window.onload = disableBack();
          window.onpageshow = function (e) {
              if (e.persisted)
                  disableBack();
          }
      });
   </script>
</body>

</html>
