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
        <img src="<?php echo e(asset('assets/images/rav-logo.png')); ?>" alt="" />
        <p class="logo-name">Accreditation </p>
    </div>
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="sidebar-user-panel active">
                <div class="user-panel">
                    <div class=" image">
                        <img src="<?php echo e(asset('assets/images/usrbig.jpg')); ?>" class="user-img-style" alt="User Image" />
                    </div>
                </div>
                <div class="profile-usertitle">
                    <div class="sidebar-userpic-name"><?php echo e(ucfirst(Auth::user()->firstname)); ?></div>
                    <div class="profile-usertitle-job">(Assessor)</div>

                </div>
            </li>



            <li class="<?php echo e(Request::is('dashboard') ? 'active' : ''); ?>">
                <a href="<?php echo e(url('dashboard')); ?>">
                    <i data-feather="monitor"></i>
                    <span>Dashboard</span>
                </a>
            </li>


            <li class="<?php echo e(Request::is('profile-get')?'active':''); ?>">
                    <a href="<?php echo e(url('profile-get')); ?>" >
                        <i data-feather="user"></i>
                        <span>Manage Profile</span>
                    </a>
            </li>

            <li  class="<?php echo e((Request::is('nationl-accesser') ||  Request::is('internationl-accesser') )?'active':''); ?>" >
                <a href="#" onClick="return false;" class="menu-toggle" >
                    <i data-feather="file"></i>
                    <span>Manage Application</span>
                </a>
                <ul class="ml-menu">

                    <li class="<?php echo e(Request::is('nationl-accesser')?'active':''); ?>" >
                        <a  href="<?php echo e(url('nationl-accesser')); ?>">National Application</a>
                    </li>

                    <li class="<?php echo e(Request::is('internationl-accesser')?'active':''); ?>">
                        <a  href="<?php echo e(url('/internationl-accesser')); ?>">International Application</a>
                    </li>

                </ul>
            </li>

            <li  class="<?php echo e((Request::is('assessor-desktop-assessment') ||  Request::is('assessor-onsite-assessment-page') )?'active':''); ?>" >
                <a href="#" onClick="return false;" class="menu-toggle" >
                    <i data-feather="file"></i>
                    <span>My Availability</span>
                </a>
                <ul class="ml-menu">

                    <li class="<?php echo e(Request::is('assessor-desktop-assessment')?'active':''); ?>" >
                        <a  href="<?php echo e(url('assessor-desktop-assessment')); ?>">Desktop Assessment</a>
                    </li>

                    <li class="<?php echo e(Request::is('assessor-onsite-assessment-page')?'active':''); ?>">
                        <a  href="<?php echo e(url('assessor-onsite-assessment-page')); ?>">Onsite / Virtual Assessment</a>
                    </li>

                </ul>
            </li>


            <li>
                <a href="#" onClick="return false;">
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


            <li class="<?php echo e(Request::is('assessor-user-manuals')?'active':''); ?>">
                <a href="<?php echo e(url('assessor-user-manuals')); ?>">
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


            <li>
                <a href="#" onClick="return false;">
                    <i data-feather="message-circle"></i>
                    <span>Feedback</span>
                </a>
            </li>

            <li>
                <a href="#" onClick="return false;">
                    <i data-feather="message-circle"></i>
                    <span>Remark</span>
                </a>
            </li>


            <li>
                <a href="<?php echo e(url('/view-faqs')); ?>" class="<?php echo e(Request::is('view-faqs') ? 'active' : ''); ?>">
                    <i data-feather="file-text"></i>
                    <span>FAQs</span>
                </a>
            </li>


        </ul>
    </div>
    <!-- #Menu -->
</aside>
<!-- #END# Left Sidebar -->
<?php /**PATH D:\xampp\htdocs\atab\resources\views/layout/sideAss.blade.php ENDPATH**/ ?>