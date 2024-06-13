<style>
    .sidebar {
        background: #01d8da14 !important;
    }

    .logo-brand {
        background: #def0f5;
        width: 260px;
    }
</style>
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
                    <div class="profile-usertitle-job">(Training Provider)</div>
                </div>
            </li>

            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}">
                    <!-- <i data-feather="monitor"></i> -->
                    <i class="fa fa-television" aria-hidden="true"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ Request::is('profile-get') ? 'active' : '' }}">
                <a href="{{ url('profile-get') }}">
                    <!-- <i data-feather="user"></i> -->
                    <i class="fa fa-user"></i>
                    <span>Manage Profile</span>
                </a>
            </li>

            <li class="{{ Request::is('Akment-letter') ? 'active' : '' }}">
                <a href="{{ url('/Akment-letter') }}">
                    <!-- <i data-feather="file-text"></i> -->
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    <span>Acknowledgement Letter </span>
                </a>
            </li>

            <li
                class="{{ Request::is('level-first') || Request::is('level-second') || Request::is('level-third') || Request::is('level-fourth') || Request::is('level-first/tp/application-list')  || Request::is('level-second/tp/application-list') || Request::is('level-third/tp/application-list') || Request::is('*tp/application-view*') ? 'active' : '' }}">
                <a href="#" onClick="return false;" class="menu-toggle">
                    <!-- <i data-feather="settings"></i> -->
                    <i class="fa fa-cog"></i>
                    <span>Manage Applications</span>
                </a>
                <ul class="ml-menu">
                    <!--  <li class="{{ Request::is('level-first') ? 'active' : '' }}" >
                                    <a href="{{ url('/level-list') }}">Level 1</a>
                                </li> -->

                    <li class="{{ Request::is('level-first') || Request::is('level-first/tp/application-list') || Request::is('tp/application-view*') ? 'active' : '' }}">
                        <a href="{{ url('/level-first') }}">Level 1 </a>
                    </li>

                    <li class="{{ Request::is('level-second') || Request::is('level-second/tp/application-list') || Request::is('upgrade/tp/application-view*')? 'active' : '' }}">
                        <a href="{{ url('/level-second') }}">Level 2</a>
                    </li>
                    <li class="{{ Request::is('level-third') || Request::is('level-third/tp/application-list') || Request::is('upgrade/level-3*')? 'active' : '' }}">
                        <a href="{{ url('/level-third') }}">Level 3</a>
                    </li>
                   
            </li>

        </ul>
        </li>

        <li class="{{ Request::is('tp/application-payment-fee-list') ? 'active' : '' }}">
            <a href="{{ url('tp/application-payment-fee-list') }}">
                <!-- <i data-feather="clipboard"></i> -->
                <i class="material-icons">payment</i>
                <span>Payment Fee</span>
            </a>
        </li>

        <li class="{{ Request::is('show-previous-level') ? 'active' : '' }}">
            <a href="#" onClick="return false;" class="menu-toggle">
                {{-- <i data-feather="history"></i> --}}
                <i class="fa fa-history" aria-hidden="true"></i>
                <span>History of Levels</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="{{ url('show-previous-level') }}">Show Previous Level</a>
                    <a href="#">Upgrade Level</a>
                </li>

            </ul>
        </li>

        <li class="{{ Request::is('Grievance-list') ? 'active' : '' }}">
            <a href="{{ url('Grievance-list') }}">
                <!-- <i data-feather="clipboard"></i> -->
                <i class="fa fa-clipboard" aria-hidden="true"></i>
                <span>Grievance</span>
            </a>
        </li>


        <li class="{{ Request::is('send-feedback') ? 'active' : '' }}">
            <a href="{{ url('/send-feedback') }}">
                <i class="fa fa-comments" aria-hidden="true"></i>
                <span>Feedback</span>
            </a>
        </li>

        <li>
            <a href="{{ url('/view-faqs') }}" class="{{ Request::is('view-faqs') ? 'active' : '' }}">
                <!-- <i data-feather="message-circle"></i> -->
                <i class="fa fa-comment" aria-hidden="true"></i>
                <span>FAQs</span>
            </a>
        </li>



        </ul>
    </div>
    <!-- #Menu -->
</aside>
<!-- #END# Left Sidebar -->
