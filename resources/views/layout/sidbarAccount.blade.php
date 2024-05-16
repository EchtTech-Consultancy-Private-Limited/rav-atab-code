<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="logo-brand">
        <img src="{{ asset('assets/images/rav-logo.png') }}" alt="" />
        <!-- <p class="logo-name">Accreditation </p> -->
    </div>
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="sidebar-user-panel">
                <div class="user-panel">
                    <div class=" image">
                        <img src="{{ asset('assets/images/usrbig.jpg') }}" class="user-img-style" alt="User Image" />
                    </div>
                </div>
                <div class="profile-usertitle">
                    <div class="sidebar-userpic-name">{{ Auth::user()->firstname }}</div>
                    <div class="profile-usertitle-job">(Account)</div>
                </div>
            </li>
    
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}">
                <i class="fa fa-desktop" aria-hidden="true"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ Request::is('profile-get') ? 'active' : '' }}">
                <a href="{{ url('profile-get') }}">
                <i class="fa fa-user" aria-hidden="true"></i>
                    <span>Manage Profile</span>
                </a>
            </li>


            <li class="{{ Request::is('nationl-page') || Request::is('internationl-page') ? 'active' : '' }}">
                <a href="#" onClick="return false;" class="menu-toggle">
                <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span>Manage Application</span>
                </a>
                <ul class="ml-menu">

                    <li class="{{ Request::is('account/application-list') ? 'active' : '' }}">
                        <a href="{{ url('account/application-list') }}">National Application</a>
                    </li>

                    <li class="{{ Request::is('internationl-page') ? 'active' : '' }}">
                        <a href="{{ url('/internationl-page') }}">International Application</a>
                    </li>

                </ul>
            </li>

            <li class="{{ Request::is('account/application-payment-fee-list') ? 'active' : '' }}">
            <a href="{{ url('account/application-payment-fee-list') }}">
                <!-- <i data-feather="clipboard"></i> -->
                <i class="material-icons">payment</i>
                <span>Payment Fee</span>
            </a>
        </li>













            <li class="{{ Request::is('show-feedback') ? 'active' : '' }}">
                <a href="{{ url('/show-feedback') }}">
                <i class="fa fa-comment" aria-hidden="true"></i>
                    <span>Help Desk</span>
                </a>
            </li>








        </ul>
    </div>
    <!-- #Menu -->
</aside>
<!-- #END# Left Sidebar -->
