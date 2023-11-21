
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
        <div class="logo-brand">
            <img src="{{ asset('assets/images/rav-logo.png') }}" alt="" />
            <!-- <p class="logo-name">Accreditation </p> -->
        </div>

            <!-- Menu -->
            <div class="menu" >
                <ul class="list">
                    <li class="sidebar-user-panel">
                         <div class="user-panel">
                           <div class=" image">
                                <img src="{{ asset('assets/images/usrbig.jpg')}}" class="user-img-style" alt="User Image" />
                            </div>
                        </div>
                        <div class="profile-usertitle">
                            <div class="sidebar-userpic-name">{{ Auth::user()->firstname }}</div>
                            <div class="profile-usertitle-job">(Admin)</div>


                        </div>
                    </li>

                <li class="{{ Request::is('dashboard')?'active':''}}" >
                    <a href="{{ url('/dashboard') }}"  >
                        <!-- <i data-feather="monitor"></i> -->
                        <i class="fa fa-television"></i>
                        
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ Request::is('profile-get')?'active':''}}">
                    <a href="{{ url('profile-get') }}" >
                        <!-- <i data-feather="user"></i> -->
                        <i class="fa fa-user"></i>
                        <span>Manage Profile</span>
                    </a>
                </li>


                <li class="{{ (Request::is('admin-user') || Request::is('secrete-user') || Request::is('training-provider') || Request::is('assessor-user') )?'active':''}}" || class="{{ Request::is('training-provider')?'active':''}}" || class="{{ Request::is('assessor-user')?'active':''}}"  >
                    <a href="#" onClick="return false;" class="menu-toggle">
                        <!-- <i data-feather="users"></i> -->
                        <i class="fa fa-users"></i>
                        <span>User Management</span>
                    </a>
                    <ul class="ml-menu">

                        <li  class="{{ Request::is('admin-user')?'active':''}}" >
                            <a  href="{{ url('/admin-user') }}">Admin User List</a>
                        </li>
                        <li class="{{ Request::is('training-provider')?'active':''}}">
                            <a  href="{{ url('/training-provider') }}">Training Provider User List</a>
                        </li>
                        <li class="{{ Request::is('assessor-user')?'active':''}}">
                            <a  href="{{ url('/assessor-user') }}">Assessor User List</a>
                        </li>
                        <li class="{{ Request::is('secrete-user')?'active':''}}">
                            <a  href="{{ url('/secrete-user') }}">Secretariat User List</a>
                        </li>


                    </ul>
                </li>




                <li  class="{{ (Request::is('nationl-page') ||  Request::is('internationl-page') )?'active':''}}" >
                    <a href="#" onClick="return false;" class="menu-toggle" >
                        <!-- <i data-feather="file"></i> -->
                        <i class="fa fa-file-alt"></i>
                        <span>Manage Application</span>
                    </a>
                    <ul class="ml-menu">

                        <li class="{{ Request::is('nationl-page')?'active':''}}" >
                            <a  href="{{ url('nationl-page') }}">National Application</a>
                        </li>

                        <li class="{{ Request::is('internationl-page')?'active':''}}">
                            <a  href="{{ url('/internationl-page') }}">International Application</a>
                        </li>

                    </ul>
                </li>


                    <li class="{{ Request::is('levels')?'active':''}}" >
                        <a href="{{ url('/levels') }}"   >
                            <!-- <i data-feather="info"></i> -->
                            <i class="fa fa-info"></i>
                            <span>Level Information</span>
                        </a>
                    </li>

                    <!-- <li>
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
                    </li> -->

                    <li class="{{ Request::is('show-previous-level')?'active':''}}">
                        <a href="#" onClick="return false;" class="menu-toggle">
                            <i class="fa fa-history" aria-hidden="true"></i>
                            <span>History of Levels</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="{{ url('show-previous-level') }}">Show Previous Level</a>
                                <a href="#">Upgrade  Level</a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="{{ url('/manage-manual') }}" class="{{ Request::is('manage-manual')?'active':''}}" >
                            <!-- <i data-feather="message-circle"></i> -->
                            <i class="fa fa-comment"></i>
                            <span>Manage Manual</span>
                        </a>
                    </li>

                <!--     <li>
                        <a href="{{ url('/email-verification') }}" class="{{ Request::is('email-verification')?'active':''}}" >
                            <i data-feather="message-circle"></i>
                            <span>Email domain verification</span>
                        </a>
                    </li> -->

                    <li class="{{ Request::is('Grievance-list')?'active':''}}">
                        <a href="{{ url('/Grievance-list') }}">
                            <!-- <i data-feather="clipboard"></i> -->
                            <i class="fa fa-clipboard"></i>
                            <span>Grievances</span>
                        </a>
                    </li>


                    <li class="{{ Request::is('show-feedback')?'active':''}}">
                        <a href="{{ url('/show-feedback') }}">
                            <i class="fa fa-comments" aria-hidden="true"></i>
                            <span>Feedback</span>
                        </a>
                    </li>

                    <!-- <li>
                        <a href="#" onClick="return false;" >
                            <i data-feather="message-circle"></i>
                            <span>Remarks</span>
                        </a>
                    </li> -->

                    <li>
                        <a href="{{ url('/get-faqs') }}" class="{{ Request::is('get-faqs')?'active':''}}" >
                            <!-- <i data-feather="message-circle"></i> -->
                            <i class="fa fa-comments"></i>
                            <span>Manage FAQs</span>
                        </a>
                    </li>

                     <li class="{{ (Request::is('admin-models') || (Request::is('model-routes') || Request::is('admin-routes')))?'active':''}}">
                        <a href="#" onClick="return false;" class="menu-toggle">
                            <!-- <i data-feather="monitor"></i> -->
                            <i class="fa fa-television"></i>
                            <span>Masters</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{ Request::is('admin-models')?'active':''}}">
                                <a href="{{url('admin-models')}}" >
                                    <span> Modules </span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin-routes')?'active':''}}">
                                <a href="{{url('admin-routes')}}" >
                                    <span> Routes </span>
                                </a>
                            </li>
                            <li class="{{ Request::is('model-routes')?'active':''}}">
                                <a href="{{url('model-routes')}}" >
                                    <span> Module Routes </span>
                                </a>
                            </li>



                        </ul>
                    </li>


                </ul>
            </div>
            <!-- #Menu -->
        </aside>
        <!-- #END# Left Sidebar -->
