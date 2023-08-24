<style>
.sidebar{
    background:#ffb46336;
}
.logo-brand {
    background: #f4e5d8;
    width: 260px;
}
</style>
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="logo-brand">
        <img src="{{ asset('assets/images/rav-logo.png') }}" alt="" />
        <p class="logo-name">Accreditation </p>
    </div>
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="sidebar-user-panel active">
                <div class="user-panel">
                    <div class=" image">
                        <img src="{{ asset('assets/images/usrbig.jpg') }}" class="user-img-style" alt="User Image" />
                    </div>
                </div>
                <div class="profile-usertitle">
                    <div class="sidebar-userpic-name">{{ ucfirst(Auth::user()->firstname) }}</div>
                    <div class="profile-usertitle-job">(Assessor)</div>

                </div>
            </li>



            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}">
                    <i data-feather="monitor"></i>
                    <span>Dashboard</span>
                </a>
            </li>


            <li class="{{ Request::is('profile-get')?'active':''; }}">
                    <a href="{{ url('profile-get') }}" >
                        <i data-feather="user"></i>
                        <span>Manage Profile</span>
                    </a>
            </li>

            <li  class="{{ (Request::is('nationl-accesser') ||  Request::is('internationl-accesser') )?'active':''; }}" >
                <a href="#" onClick="return false;" class="menu-toggle" >
                    <i data-feather="file"></i>
                    <span>Manage Application</span>
                </a>
                <ul class="ml-menu">

                    <li class="{{ Request::is('nationl-accesser')?'active':''; }}" >
                        <a  href="{{ url('nationl-accesser') }}">National Application</a>
                    </li>

                    <li class="{{ Request::is('internationl-accesser')?'active':''; }}">
                        <a  href="{{ url('/internationl-accesser') }}">International Application</a>
                    </li>

                </ul>
            </li>

            <li  class="{{ (Request::is('assessor-desktop-assessment') ||  Request::is('assessor-onsite-assessment-page') )?'active':''; }}" >
                <a href="#" onClick="return false;" class="menu-toggle" >
                    <i data-feather="file"></i>
                    <span>My Availability</span>
                </a>
                <ul class="ml-menu">

                    <li class="{{ Request::is('assessor-desktop-assessment')?'active':''; }}" >
                        <a  href="{{ url('assessor-desktop-assessment') }}">Desktop Assessment</a>
                    </li>

                    <li class="{{ Request::is('assessor-onsite-assessment-page')?'active':''; }}">
                        <a  href="{{ url('assessor-onsite-assessment-page') }}">Onsite / Virtual Assessment</a>
                    </li>

                </ul>
            </li>


            <li>
                <a href="javascript void(0)" onClick="return false;">
                    <i data-feather="message-circle"></i>
                    <span>Capacity Building</span>
                </a>
            </li>

            <li>
                <a href="#" onClick="return false;">
                    <i data-feather="message-circle"></i>
                    <span>Circulars & Notifications</span>
                </a>
            </li>


            <li class="{{ Request::is('assessor-user-manuals')?'active':''; }}">
                <a href="{{ url('assessor-user-manuals') }}">
                    <i data-feather="message-circle"></i>
                    <span>Assessor Manual</span>
                    

                </a>
            </li>



            <li>
                <a href="#" onClick="return false;">
                    <i data-feather="message-circle"></i>
                    <span>Grievance</span>
                </a>
            </li>


            <li class="{{ Request::is('send-feedback')?'active':''; }}">
                <a href="{{ url('/send-feedback') }}">
                    <i data-feather="message-circle"></i>
                    <span>Help Desk</span>
                </a>
            </li>

            <li>
                <a href="#" onClick="return false;">
                    <i data-feather="message-circle"></i>
                    <span>Remark</span>
                </a>
            </li>


            <li>
                <a href="{{ url('/view-faqs') }}" class="{{ Request::is('view-faqs') ? 'active' : '' }}">
                    <i data-feather="file-text"></i>
                    <span>FAQs</span>
                </a>
            </li>


        </ul>
    </div>
    <!-- #Menu -->
</aside>
<!-- #END# Left Sidebar -->
