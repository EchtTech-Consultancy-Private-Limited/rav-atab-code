
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
                                <img src="{{ asset('assets/images/usrbig.jpg')}}" class="user-img-style" alt="User Image" />
                            </div>
                        </div>
                        <div class="profile-usertitle">
                            <div class="sidebar-userpic-name">{{ Auth::user()->firstname;}}</div>
                            <div class="sidebar-userpic-name">Training Provider Login</div>
                        </div>
                    </li>

                <li>
                    <a href="{{ url('/dashboard') }}" >
                        <i data-feather="anchor"></i>
                        <span>Dashboard</span>
                    </a>
                </li>




                <li>
                    <a href="#" onClick="return false;" class="menu-toggle">
                        <i data-feather="anchor"></i>
                        <span>User management</span>
                    </a>
                    <ul class="ml-menu">

                        <li>
                            <a  href="{{ url('/user') }}">User list</a>
                        </li>

                    </ul>
                </li>

                    <li>
                        <a href="#" onClick="return false;" class="menu-toggle" >
                            <i data-feather="users"></i>
                            <span>Level Information</span>
                        </a>
                        <ul class="ml-menu">
                            <li>

                                <a href="{{url('/level')}}">Level 1</a>
                                <a href="{{url('/level')}}">Level 2</a>
                                <a href="{{url('/level')}}">Level 3</a>
                                <a href="{{url('/level')}}">Level 4</a>

                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="#" onClick="return false;"  class="menu-toggle" >
                            <i data-feather="users"></i>
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
                        <a href="#" onClick="return false;"   >
                            <i data-feather="users"></i>
                            <span>Grievance</span>
                        </a>
                    </li>


                    <li>
                        <a href="#" onClick="return false;"  class="menu-toggle" >
                            <i data-feather="users"></i>
                            <span>Feedback / Remark</span>
                        </a>
                    </li>


                    <li>
                        <a href="#" onClick="return false;" class="menu-toggle">
                            <i data-feather="users"></i>
                            <span>History of Levels</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="#">show previous Level</a>
                                <a href="#">upgrade  Level</a>
                            </li>

                        </ul>
                    </li>


                    <li>
                    <a href="{{ url('/logout') }}">
                        <i data-feather="message-circle"></i>
                        <span>Logout</span>
                    </a>
                </li>


                </ul>
            </div>
            <!-- #Menu -->
        </aside>
        <!-- #END# Left Sidebar -->
