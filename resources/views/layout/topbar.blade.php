 <style>
     ul.menu h5 {
         text-align: center;
         padding: 10px 30px;
         width: 100%;
     }
 </style>

 <!-- Top Bar -->
 <nav
     class="navbar
       @if (Auth::user()->role == 1) @elseif(Auth::user()->role == 2)

        nav-Tp

        @elseif(Auth::user()->role == 3)

        nav-Ass

        @elseif(Auth::user()->role == 4) @endif
       ">
     <div class="container-fluid">
         <div class="navbar-header">
             <a href="#" onClick="return false;" class="navbar-toggle collapsed" data-bs-toggle="collapse"
                 data-target="#navbar-collapse" aria-expanded="false"></a>
             <a href="#" onClick="return false;" class="bars"></a>


             <a class="navbar-brand" href="{{ url('/dashboard') }}">
                 <img src="{{ asset('login/ATAB.png') }}" alt="" style="max-width: 20%;" />
                 <span class="logo-name">Accreditation</span>
             </a>

         </div>
         <div class="collapse navbar-collapse" id="navbar-collapse">
             <ul class="pull-left">
                 <li>
                     <a href="#" onClick="return false;" class="sidemenu-collapse">
                         <i data-feather="menu"></i>
                     </a>
                 </li>
                 <li>
                     <div class="title-nav">
                         <p>

                             @if (Auth::user()->role == 1)
                                 Administrator
                             @elseif(Auth::user()->role == 2)
                                 Training Provider
                             @elseif(Auth::user()->role == 3)
                                 Assessor
                             @elseif(Auth::user()->role == 4)
                                 Professional
                             @elseif(Auth::user()->role == 5)
                                 Secretariat
                             @elseif(Auth::user()->role == 6)
                                 Accountant
                             @endif


                     </div>
                 </li>
             </ul>
             <ul class="nav navbar-nav navbar-right">
                 <!-- Full Screen Button -->
                 <li class="fullscreen">
                     <a href="javascript:;" class="fullscreen-btn">
                         <i class="fas fa-expand"></i>
                     </a>
                 </li>
                 <!-- #END# Full Screen Button -->
                 <!-- #START# Notifications-->
                 @if (Auth::user()->role == 3)
                     <li class="dropdown">
                         <a href="#" onClick="return false;" class="dropdown-toggle" data-bs-toggle="dropdown"
                             role="button">
                             <i class="far fa-bell"></i>
                             <span class="notify"></span>
                             <span class="heartbeat"></span>
                         </a>


                         <ul class="dropdown-menu pullDown placeholder_input">
                             <li class="header">NOTIFICATIONS </li>
                             <li class="body col-md-12">
                                 <ul class="menu">

                                     @if (Checknotification(Auth::user()->id))
                                           
                                         @foreach (Checknotification(Auth::user()->id) as $item)
                                             <li class="p-2">

                                                 <a href="{{ url('Assessor-view/'.dEncrypt($item['application_id'])) }}"
                                                     class="bg-secondary text-white" style="border-radius: 10px;">
                                                     <div class="d-flex justify-content-between"
                                                         style="font-size: 12px;">
                                                         <div>
                                                             <span id="notification"
                                                                 data-value='{{ $item['id'] }}'>{{ 'Application ID:' . $item['application_uid'] }}</span>
                                                         </div>
                                                         <div>
                                                             <span>
                                                                 {{ date('d-M-Y', strtotime($item['created_at'])) }}
                                                             </span>
                                                         </div>
                                                     </div>
                                                 </a>
                                             </li>
                                         @endforeach
                                     @endif
                                 </ul>
                             </li>
                             <li class="footer">
                                 <a href="#" onClick="return false;">View All Notifications</a>
                             </li>
                         </ul>
                     </li>
                 @endif
                 <!-- #END# Notifications-->
                 <li class="dropdown user_profile">
                     <div class="dropdown-toggle" data-bs-toggle="dropdown">
                         <img src="{{ asset('/assets/images/usrbig.jpg') }}" class="user_profile_img" alt="user">
                     </div>
                     <ul class="dropdown-menu pullDown">
                         <li class="body">
                             <ul class="user_dw_menu">
                                 <li>
                                     <a href="{{ url('/profile-get') }}">
                                         <i class="material-icons">person</i>Profile
                                     </a>
                                 </li>

                                 <li>
                                     <a href="{{ url('/logout') }}">
                                         <i class="material-icons">power_settings_new</i>Logout
                                     </a>
                                 </li>
                             </ul>
                         </li>
                     </ul>
                 </li>
                 <!-- #END# Tasks -->
                 <li class="pull-right">
                     <a href="#" onClick="" class="" data-close="true">
                         <i class=""></i>
                     </a>
                 </li>
             </ul>
         </div>
     </div>
 </nav>
 <!-- #Top Bar -->


<script src="{{ asset('assets/js/atab-top-bar.js') }}"></script>

