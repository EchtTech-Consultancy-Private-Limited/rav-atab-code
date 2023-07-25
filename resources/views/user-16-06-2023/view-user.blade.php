@include('layout.header')

<title>RAV Accreditation</title>

</head>

<body class="light">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    @include('layout.topbar')

    <div>

        @include('layout.sidebar')


        @include('layout.rightbar')


    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">User Management</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">View User</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row ">
                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">


                        @if (Session::has('success'))
                            <div class="alert alert-success" style="padding: 15px;" role="alert">
                                {{ session::get('success') }}
                            </div>
                        @elseif(Session::has('fail'))
                            <div class="alert alert-danger" role="alert">
                                {{ session::get('fail') }}
                            </div>
                        @endif

                        <div class="tab-content">


                            <div role="tabpanel" class="tab-pane" id="timeline" aria-expanded="false">
                            </div>





                            <div role="tabpanel" class="tab-pane active" id="new_application" aria-expanded="false">

                                {{--
                            <form  action="{{ url('/new-application') }}"  method="post" class="form" id="regForm" enctype="multipart/form-data" >
                                @csrf --}}
                                <div class="card">
                                    <div class="header">
                                        <h2>User Details</h2>
                                    </div>
                                    <div class="body">

                                        <div class="row clearfix">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label><strong>Title</strong></label><br>
                                                        <label>{{ $data->title ?? '' }}</label>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label><strong>First Name</strong></label><br>
                                                        {{ $data->firstname ?? '' }}
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">

                                                        <label><strong>Middle Name</strong></label><br>

                                                        <label>{{ $data->middlename ?? '' }}</label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row clearfix">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">



                                                        <label><strong>Last Name</strong></label><br>

                                                        <label>{{ $data->lastname ?? '' }}</label>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">


                                                        <label><strong>Orgnisation/Insitute Name</strong></label><br>

                                                        <label>{{ $data->organization ?? '' }}</label>

                                                    </div>


                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">

                                                        <label><strong>Email</strong></label><br>
                                                        <label>{{ $data->email ?? '' }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row clearfix">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">

                                                        <label><strong>Mobile Number</strong></label><br>

                                                        <label>{{ $data->mobile_no ?? '' }}</label>


                                                    </div>


                                                </div>
                                            </div>



                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label><strong>Desigantion</strong></label><br>
                                                        <label>{{ $data->designation ?? '' }}</label>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <label><strong>Country</strong></label><br>
                                                                <label>{{ $data->country_name ?? '' }}</label>
                                                                <input type="hidden" id="Country"
                                                                    value="{{ $data->country ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="row clearfix">

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label><strong>State</strong></label><br>
                                                        <label>{{ $data->state_name ?? '' }}</label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">

                                                        <label><strong>City</strong></label><br>

                                                        <label>{{ $data->city_name ?? '' }}</label>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label><strong>Pastal Code</strong></label><br>
                                                        <label>{{ $data->postal ?? '' }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row clearfix">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">


                                                        <label><strong>Address</strong></label><br>

                                                        <label>{{ $data->address ?? '' }}</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- basic end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>



    @include('layout.footer')
