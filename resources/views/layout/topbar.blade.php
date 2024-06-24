<style>
ul.menu h5 {
    text-align: center;
    padding: 10px 30px;
    width: 100%;
}
</style>

<!-- Top Bar -->
<nav class="navbar
       @if (Auth::user()->role == 1) @elseif(Auth::user()->role == 2)

        nav-Tp

        @elseif(Auth::user()->role == 3)

        nav-Ass

        @elseif(Auth::user()->role == 4) @endif
       ">

    <div class="full_screen_loading">Loading&#8230;</div>
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
                            Assessor(<small>{{ Auth::user()->assessment == 1 ? 'Desktop' : 'On-Site' }}</small>)
                            @elseif(Auth::user()->role == 4)
                            Professional
                            @elseif(Auth::user()->role == 5)
                            Secretariat
                            @elseif(Auth::user()->role == 6)
                            Accountant
                            @endif

                        </p>
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

                @if (Auth::user()->role == 1)
                @php
                $notifications = getNotificationByUser('superadmin');
                @endphp
                <li class="dropdown">

                    <a href="#" onClick="return false;" class="dropdown-toggle" data-bs-toggle="dropdown" role="button">
                        <i class="far fa-bell"></i>
                        @isset($notifications)
                        @if(count($notifications)>0)
                        <span class="notify" style="background-color: #ff5722 !important;"></span>
                        <span class="heartbeat" style="background-color: #ff5722 !important;"></span>
                        @endif
                        @endisset
                    </a>
                    <ul class="dropdown-menu pullDown placeholder_input notification">
                        <li class="header">NOTIFICATIONS </li>
                        <li class="body col-md-12">
                            <ul class="text-dark menu" style="padding: 0px !important;">
                                @if (count($notifications)>0)
                                @foreach ($notifications as $notification)
                                <li onclick="handleSuperAdminNotification({{$notification->id}})">                                  
                                <div class="notification-card <?php echo $notification->is_read==0?'active':'';?>">
                                        <div class="content-card">
                                            <div class="flex-box">
                                                <span>App. ID : {{ $notification->uhid }}</span>
                                                <span>{{$notification->created_at}}</span>
                                            </div>
                                            <div class="normal-text">
                                                <p class="mb-0">{{$notification->data}}</p>
                                             </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @else
                                <li class="text-center">
                                    No New Notifications!
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    @endif



                    @if (Auth::user()->role == 5)
                    @php
                    $notifications = getNotificationByUser('secretariat');
                    @endphp
                <li class="dropdown">

                <a href="#" onClick="return false;" class="dropdown-toggle" data-bs-toggle="dropdown" role="button">
                        <i class="far fa-bell"></i>
                        @isset($notifications)
                        @if(count($notifications)>0)
                        <span class="notify" style="background-color: #ff5722 !important;"></span>
                        <span class="heartbeat" style="background-color: #ff5722 !important;"></span>
                        @endif
                        @endisset
                    </a>
                    <ul class="dropdown-menu pullDown placeholder_input notification">
                        <li class="header">NOTIFICATIONS </li>
                        <li class="body col-md-12">
                            <ul class="text-dark menu" style="padding: 0px !important;">
                                @if (count($notifications)>0)
                                @foreach ($notifications as $notification)
                                <li onclick="handleAdminNotification({{$notification->id}})">                                  
                                    <div class="notification-card <?php echo $notification->is_read==0?'active':'';?>">
                                        <div class="content-card">
                                            <div class="flex-box">
                                                <span>App. ID : {{ $notification->uhid }}</span>
                                                {{ \Carbon\Carbon::parse($notification->created_at)->format('d-m-Y') }}
                                            </div>
                                            <div class="normal-text">
                                                <p class="mb-0">{{$notification->data}}</p>
                                             </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @else
                                <li class="text-center">
                                    No New Notifications!
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    @endif




                    @if (Auth::user()->role == 6)
                    @php
                    $notifications = getNotificationByUser('accountant');
                    @endphp
                <li class="dropdown">
                <a href="#" onClick="return false;" class="dropdown-toggle" data-bs-toggle="dropdown" role="button">
                        <i class="far fa-bell"></i>
                        @isset($notifications)
                        @if(count($notifications)>0)
                        <span class="notify" style="background-color: #ff5722 !important;"></span>
                        <span class="heartbeat" style="background-color: #ff5722 !important;"></span>
                        @endif
                        @endisset
                    </a>
                    <ul class="dropdown-menu pullDown placeholder_input notification">
                        <li class="header">NOTIFICATIONS </li>
                        <li class="body col-md-12">
                            <ul class="text-dark menu" style="padding: 0px !important;">
                                @if (count($notifications)>0)
                                @foreach ($notifications as $notification)
                                <li onclick="handleNotification({{$notification->id}})">                                  
                                <div class="notification-card <?php echo $notification->is_read==0?'active':'';?>">
                                        <div class="content-card">
                                            <div class="flex-box">
                                                <span>App. ID : {{ $notification->uhid }}</span>
                                                {{ \Carbon\Carbon::parse($notification->created_at)->format('d-m-Y') }}
                                            </div>
                                            <div class="normal-text">
                                                <p class="mb-0">{{$notification->data}}</p>
                                             </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @else
                                <li class="text-center">
                                    No New Notifications!
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    @endif

                    @if (Auth::user()->role == 2)
                    @php
                    $notifications = getNotificationByUser('tp');
                    @endphp
                <li class="dropdown">
                    <a href="#" onClick="return false;" class="dropdown-toggle" data-bs-toggle="dropdown" role="button">
                        <i class="far fa-bell"></i>
                        @if (getNotificationByUser('tp'))
                        @if(count($notifications)>0)
                        <span class="notify" style="background-color: #ff5722 !important;"></span>
                        <span class="heartbeat" style="background-color: #ff5722 !important;"></span>
                        @endif
                        @endif
                    </a>
                    <ul class="dropdown-menu pullDown placeholder_input notification">
                        <li class="header">NOTIFICATIONS </li>
                        <li class="body col-md-12">
                            <ul class="text-dark menu" style="padding: 0px !important;">
                                @if (count($notifications)>0)
                                @foreach ($notifications as $notification)
                                
                                <li>
                                    <a href="{{ url($notification->url) }}"
                                        style="color: #000;" class="p-0">                                      
                                        <div class="notification-card <?php echo $notification->is_read==0?'active':'';?>">
                                            <div class="content-card">
                                                <div class="flex-box">
                                                    <span>App. ID : {{ $notification->uhid }}</span>
                                                    {{ \Carbon\Carbon::parse($notification->created_at)->format('d-m-Y') }}
                                                </div>
                                                <div class="normal-text">
                                                    <p class="mb-0">{{$notification->data}}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </a>
                                </li>
                            
                                @endforeach
                                @else
                                <li class="text-center">
                                    No New Notifications!
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    @endif

                    <!-- #END# Full Screen Button -->
                    <!-- #START# Notifications-->
                    <!-- assessor desktop -->
                    @if (Auth::user()->role == 3 && Auth::user()->assessment == 1)
                    @php
                    $notifications = getNotificationByUser('desktop');
                    @endphp
                <li class="dropdown">
                <a href="#" onClick="return false;" class="dropdown-toggle" data-bs-toggle="dropdown" role="button">
                        <i class="far fa-bell"></i>
                        @isset($notifications)
                        @if(count($notifications)>0)
                        <span class="notify" style="background-color: #ff5722 !important;"></span>
                        <span class="heartbeat" style="background-color: #ff5722 !important;"></span>
                        @endif
                        @endisset
                    </a>
                    <ul class="dropdown-menu pullDown placeholder_input notification">
                        <li class="header">NOTIFICATIONS </li>
                        <li class="body col-md-12">
                            <ul class="text-dark menu" style="padding: 0px !important;">
                                @if (count($notifications)>0)
                                @foreach ($notifications as $notification)
                                <li onclick="handleDesktopNotification({{$notification->id}})">                                  
                                <div class="notification-card <?php echo $notification->is_read==0?'active':'';?>">
                                        <div class="content-card">
                                            <div class="flex-box">
                                                <span>App. ID : {{ $notification->uhid }}</span>
                                                {{ \Carbon\Carbon::parse($notification->created_at)->format('d-m-Y') }}
                                            </div>
                                            <div class="normal-text">
                                                <p class="mb-0">{{$notification->data}}</p>
                                             </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @else
                                <li class="text-center">
                                    No New Notifications!
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    @endif
                    <!-- #END# Notifications-->

                    <!-- assessor onsite notification -->
                    @if (Auth::user()->role == 3 && Auth::user()->assessment == 2)
                    @php
                    $notifications = getNotificationByUser('onsite');
                    @endphp
                <li class="dropdown">
                <a href="#" onClick="return false;" class="dropdown-toggle" data-bs-toggle="dropdown" role="button">
                        <i class="far fa-bell"></i>
                        @isset($notifications)
                        @if(count($notifications)>0)
                        <span class="notify" style="background-color: #ff5722 !important;"></span>
                        <span class="heartbeat" style="background-color: #ff5722 !important;"></span>
                        @endif
                        @endisset
                    </a>
                    <ul class="dropdown-menu pullDown placeholder_input notification">
                        <li class="header">NOTIFICATIONS </li>
                        <li class="body col-md-12">
                            <ul class="text-dark menu" style="padding: 0px !important;">
                                @if (count($notifications)>0)
                                @foreach ($notifications as $notification)
                                <li onclick="handleOnsiteNotification({{$notification->id}})">                                  
                                    <div class="notification-card">
                                    <div class="notification-card <?php echo $notification->is_read==0?'active':'';?>">
                                            <div class="flex-box">
                                                <span>App. ID : {{ $notification->uhid }}</span>
                                                {{ \Carbon\Carbon::parse($notification->created_at)->format('d-m-Y') }}
                                            </div>
                                            <div class="normal-text">
                                                <p class="mb-0">{{$notification->data}}</p>
                                             </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @else
                                <li class="text-center">
                                    No New Notifications!
                                </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                    @endif
                    <!-- end here onsite notification -->
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