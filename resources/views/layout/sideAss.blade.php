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
<aside id="leftsidebar" class="sidebar asse">
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
                    <div class="sidebar-userpic-name">{{ ucfirst(Auth::user()->firstname) }}</div>
                    <div class="profile-usertitle-job">(Assessor)</div>

                </div>
            </li>



            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}">
                <i class="fa fa-television" aria-hidden="true"></i>
                    <span>Dashboard</span>
                </a>
            </li>


            <li class="{{ Request::is('profile-get')?'active':''}}">
                    <a href="{{ url('profile-get') }}" >
                    <i class="fa fa-user"></i>
                        <span>Manage Profile</span>
                    </a>
            </li>

            <li  class="{{ (Request::is('nationl-accesser') ||  Request::is('internationl-accesser') )?'active':''}}" >
                <a href="#" onClick="return false;" class="menu-toggle" >
                <i class="fa fa-cog"></i>
                    <span>Manage Application</span>
                </a>
                <ul class="ml-menu">

                    <li class="{{ Request::is('nationl-accesser')?'active':''}}" >
                        <a  href="{{ url('nationl-accesser') }}">National Application</a>
                    </li>

                    <li class="{{ Request::is('internationl-accesser')?'active':''}}">
                        <a  href="{{ url('/internationl-accesser') }}">International Application</a>
                    </li>

                </ul>
            </li>

            <li  class="{{ (Request::is('assessor-desktop-assessment') ||  Request::is('assessor-onsite-assessment-page') )?'active':''}}" >
                <a href="#" onClick="return false;" class="menu-toggle" >
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <span>My Availability</span>
                </a>
                <ul class="ml-menu">

                    <li class="{{ Request::is('assessor-desktop-assessment')?'active':''}}" >
                        <a  href="{{ url('assessor-desktop-assessment') }}">Desktop Assessment</a>
                    </li>

                    <li class="{{ Request::is('assessor-onsite-assessment-page')?'active':''}}">
                        <a  href="{{ url('assessor-onsite-assessment-page') }}">Onsite / Virtual Assessment</a>
                    </li>

                </ul>
            </li>


            <li>
                <a href="#" onClick="return false;">
                    <i class="fa fa-building" aria-hidden="true"></i>
                    <span>Capacity Building</span>
                </a>
            </li>

            <li>
                <a href="#" onClick="return false;">
                    <i class="fa fa-bell"></i>
                    <span>Circulars & Notifications</span>
                </a>
            </li>


            <li class="{{ Request::is('assessor-user-manuals')?'active':''}}">
                <a href="{{ url('assessor-user-manuals') }}">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    <span>Assessor Manual</span>


                </a>
            </li>

            <li>
                <a href="#" onClick="return false;">
                    <i class="fa fa-clipboard"></i>
                    <span>Grievance</span>
                </a>
            </li>


            <li class="{{ Request::is('send-feedback')?'active':''}}">
                <a href="{{ url('/send-feedback') }}">
                    <i class="fa fa-comments" aria-hidden="true"></i>
                    <span>Feedback</span>
                </a>
            </li>

            <!-- <li>
                <a href="#" onClick="return false;">
                    <i data-feather="message-circle"></i>
                    <span>Remark</span>
                </a>
            </li> -->

            <li>
                <a href="{{ url('/view-faqs') }}" class="{{ Request::is('view-faqs') ? 'active' : '' }}">
                <i class="fa fa-comment" aria-hidden="true"></i>
                    <span>FAQs</span>
                </a>
            </li>


        </ul>
    </div>
    <!-- #Menu -->
</aside>
<!-- #END# Left Sidebar -->
