<style>
.sidebar{
    background:#01d8da14 !important;
}

.logo-brand {
    background: #def0f5;
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
                            <div class="sidebar-userpic-name"><?php echo e(Auth::user()->firstname); ?></div>
                            <div class="profile-usertitle-job">(Training Provider)</div>
                        </div>
                    </li>

                <li class="<?php echo e(Request::is('dashboard')?'active':''); ?>">
                    <a href="<?php echo e(url('/dashboard')); ?>" >
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


                <li class="<?php echo e(Request::is('Akment-letter')?'active':''); ?>">
                    <a href="<?php echo e(url('/Akment-letter')); ?>"  >
                        <i data-feather="file-text"></i>
                        <span>Acknowledgement Letter </span>
                    </a>
                </li>

                

                    <li class="<?php echo e((Request::is('level-first') || Request::is('level-second') || Request::is('level-third') || Request::is('level-fourth') )?'active':''); ?>">
                        <a href="#" onClick="return false;" class="menu-toggle" >
                            <i data-feather="info"></i>
                            <span>Manage Applications</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php echo e(Request::is('level-first')?'active':''); ?>" >
                                <a href="<?php echo e(url('/level-list')); ?>">Level 1</a>
                            </li>

                            <li class="<?php echo e(Request::is('level-second')?'active':''); ?>">
                                 <a href="<?php echo e(url('/level-second')); ?>">Level 2</a>
                            </li>
                            <li class="<?php echo e(Request::is('level-third')?'active':''); ?>">
                                <a href="<?php echo e(url('/level-third')); ?>">Level 3</a>
                            </li>
                            <li class="<?php echo e(Request::is('level-fourth')?'active':''); ?>" >
                                 <a href="<?php echo e(url('/level-fourth')); ?>">Level 4</a>
                            </li>
                            </li>

                        </ul>
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


                    <li class="<?php echo e(Request::is('Grievance-list')?'active':''); ?>">
                        <a href="<?php echo e(url('Grievance-list')); ?>" >
                            <i data-feather="clipboard"></i>
                            <span>Grievance</span>
                        </a>
                    </li>


                    <li>
                        <a href="#" onClick="return false;" >
                            <i data-feather="message-circle"></i>
                            <span>Feedback</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" onClick="return false;" >
                            <i data-feather="message-circle"></i>
                            <span>Remark</span>
                        </a>
                    </li>




                    <li>
                        <a href="<?php echo e(url('/view-faqs')); ?>" class="<?php echo e(Request::is('view-faqs')?'active':''); ?>" >
                            <i data-feather="message-circle"></i>
                            <span>FAQs</span>
                        </a>
                    </li>



                </ul>
            </div>
            <!-- #Menu -->
        </aside>
        <!-- #END# Left Sidebar -->
<?php /**PATH D:\xampp\htdocs\atab\resources\views/layout/siderTp.blade.php ENDPATH**/ ?>