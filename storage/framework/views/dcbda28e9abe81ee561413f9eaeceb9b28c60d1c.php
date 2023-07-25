
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
        <div class="logo-brand">
                    <img src="<?php echo e(asset('assets/images/rav-logo.png')); ?>" alt="" />
                    <p class="logo-name">Accreditation </p>
                </div>
            <!-- Menu -->
            <div class="menu" >
                <ul class="list">
                    <li class="sidebar-user-panel active">
                         <div class="user-panel">
                           <div class=" image">
                                <img src="<?php echo e(asset('assets/images/usrbig.jpg')); ?>" class="user-img-style" alt="User Image" />
                            </div>
                        </div>
                        <div class="profile-usertitle">
                            <div class="sidebar-userpic-name"><?php echo e(Auth::user()->firstname); ?></div>
                            <div class="profile-usertitle-job">(Admin)</div>


                        </div>
                    </li>

                <li class="<?php echo e(Request::is('dashboard')?'active':''); ?>" >
                    <a href="<?php echo e(url('/dashboard')); ?>"  >
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


                <li class="<?php echo e((Request::is('admin-user') || Request::is('training-provider') || Request::is('assessor-user') )?'active':''); ?>" || class="<?php echo e(Request::is('training-provider')?'active':''); ?>" || class="<?php echo e(Request::is('assessor-user')?'active':''); ?>"  >
                    <a href="#" onClick="return false;" class="menu-toggle">
                        <i data-feather="users"></i>
                        <span>User management</span>
                    </a>
                    <ul class="ml-menu">

                        <li  class="<?php echo e(Request::is('admin-user')?'active':''); ?>" >
                            <a  href="<?php echo e(url('/admin-user')); ?>">Admin User list</a>
                        </li>
                        <li class="<?php echo e(Request::is('training-provider')?'active':''); ?>">
                            <a  href="<?php echo e(url('/training-provider')); ?>">Training Provider User list</a>
                        </li>
                        <li class="<?php echo e(Request::is('assessor-user')?'active':''); ?>">
                            <a  href="<?php echo e(url('/assessor-user')); ?>">Assessor User list</a>
                        </li>
                        <li class="<?php echo e(Request::is('secrete-user')?'active':''); ?>">
                            <a  href="<?php echo e(url('/secrete-user')); ?>">Secrate list</a>
                        </li>


                    </ul>
                </li>




                <li  class="<?php echo e((Request::is('nationl-page') ||  Request::is('internationl-page') )?'active':''); ?>" >
                    <a href="#" onClick="return false;" class="menu-toggle" >
                        <i data-feather="file"></i>
                        <span>Manage Application</span>
                    </a>
                    <ul class="ml-menu">

                        <li class="<?php echo e(Request::is('nationl-page')?'active':''); ?>" >
                            <a  href="<?php echo e(url('nationl-page')); ?>">National Application</a>
                        </li>

                        <li class="<?php echo e(Request::is('internationl-page')?'active':''); ?>">
                            <a  href="<?php echo e(url('/internationl-page')); ?>">International Application</a>
                        </li>

                    </ul>
                </li>


                    <li class="<?php echo e(Request::is('levels')?'active':''); ?>" >
                        <a href="<?php echo e(url('/levels')); ?>"   >
                            <i data-feather="info"></i>
                            <span>Level Information</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" onClick="return false;"  class="menu-toggle" >
                            <i data-feather="airplay"></i>
                            <span>Manage Course</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="#">Add New Course</a>
                                <a href="#">Document Information</a>
                                <a href="#">Payment Information</a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="#" onClick="return false;" class="menu-toggle">
                            <i data-feather="monitor"></i>
                            <span>History of Levels</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="#">Show Previous Level</a>
                                <a href="#">Upgrade  Level</a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="<?php echo e(url('/manage-manual')); ?>" class="<?php echo e(Request::is('manage-manual')?'active':''); ?>" >
                            <i data-feather="message-circle"></i>
                            <span>Manage Manual</span>
                        </a>
                    </li>

                <!--     <li>
                        <a href="<?php echo e(url('/email-verification')); ?>" class="<?php echo e(Request::is('email-verification')?'active':''); ?>" >
                            <i data-feather="message-circle"></i>
                            <span>Email domain verification</span>
                        </a>
                    </li> -->

                    <li class="<?php echo e(Request::is('Grievance-list')?'active':''); ?>">
                        <a href="<?php echo e(url('/Grievance-list')); ?>">
                            <i data-feather="clipboard"></i>
                            <span>Grievances</span>
                        </a>
                    </li>


                    <li>
                        <a href="#" onClick="return false;" >
                            <i data-feather="message-circle"></i>
                            <span>Feedbacks</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" onClick="return false;" >
                            <i data-feather="message-circle"></i>
                            <span>Remarks</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo e(url('/get-faqs')); ?>" class="<?php echo e(Request::is('get-faqs')?'active':''); ?>" >
                            <i data-feather="message-circle"></i>
                            <span>Manage FAQs</span>
                        </a>
                    </li>


                </ul>
            </div>
            <!-- #Menu -->
        </aside>
        <!-- #END# Left Sidebar -->
<?php /**PATH D:\xampp\htdocs\atab\resources\views/layout/sidebar.blade.php ENDPATH**/ ?>