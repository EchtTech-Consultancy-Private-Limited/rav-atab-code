@include('layout.header')


<title>RAV Accreditation</title>

</head>

<body class="light">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{asset('assets/images/favicon.png')}}" alt="admin">
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


        @include('layout.sideAss')



        @include('layout.rightbar')


    </div>



    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Dashboard</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                            <li class="breadcrumb-item active">Internationl</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(Session::has('sussess'))
            <div class="alert alert-success" role="alert">
                {{session::get('sussess')}}
            </div>
            @elseif(Session::has('fail'))
            <div class="alert alert-danger" role="alert">
                {{session::get('fail')}}
            </div>
            @endif

            <div class="row ">

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="profile-tab-box">
                            <div class="p-l-20">
                                <ul class="nav ">
                                    <li class="nav-item tab-all">
                                        <a class="nav-link active show" href="#level_information" data-bs-toggle="tab">SAARC Country</a>
                                    </li>
                                    <li class="nav-item tab-all p-l-20">
                                        <a class="nav-link" href="#new_application" data-bs-toggle="tab">Rest of the Word</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card project_widget">
                                        <div class="header">
                                            <h2>SAARC Country</h2>
                                        </div>
                                        <div class="body">
                                            <div class="table-responsive">
                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">#S.N0</th>
                                                            <th class="center">Level ID</th>
                                                            <th class="center">Application No</th>
                                                            <th class="center">Total Course</th>
                                                            <th class="center">Total Fee</th>
                                                            <th class="center"> Payment Date </th>
                                                            <th class="center">Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($collection as $k=> $item)
                                                        <tr class="odd gradeX">
                                                            <td class="center">{{ $k+1 }}</td>
                                                            <td class="center">{{ $item->level_id  }}</td>
                                                            <td class="center">RAVAP-{{(4000+$item->user_id)}}</td>
                                                            <td class="center">{{  $item->course_count  }}</td>
                                                            <td class="center">{{ $item->currency }}{{  $item->amount  }}</td>
                                                            <td class="center">{{  $item->payment_date  }}</td>

                                                            <td class="center">
                                                                <a href="{{ url('/admin-view') }}" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                 </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="timeline" aria-expanded="false">
                        </div>
                        <div role="tabpanel" class="tab-pane" id="new_application" aria-expanded="false">
                            <div class="card">
                                <div class="header">
                                    <h2>Rest of the word data </h2>
                                </div>
                                <div class="body">



                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example contact_list">
                                            <thead>
                                                <tr>
                                                    <th class="center">#S.N0</th>
                                                    <th class="center">Level ID</th>
                                                    <th class="center">Application No</th>
                                                    <th class="center">Total Course</th>
                                                    <th class="center">Total Fee</th>
                                                    <th class="center"> Payment Date </th>
                                                    <th class="center">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($collection1 as $k=> $item)
                                                <tr class="odd gradeX">
                                                    <td class="center">{{ $k+1 }}</td>
                                                    <td class="center">{{ $item->level_id  }}</td>
                                                    <td class="center">RAVAP-{{(4000+$item->user_id)}}</td>
                                                    <td class="center">{{  $item->course_count  }}</td>
                                                    <td class="center">{{ $item->currency }}{{  $item->amount  }}</td>
                                                    <td class="center">{{  $item->payment_date  }}</td>



                                                    <td class="center">
                                                        <a href="{{ url('/admin-view') }}" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                                    </td>
                                                </tr>
                                                @endforeach
                                         </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
        </div>

    </section>


    @include('layout.footer')

