@include('layout.header')


<title>RAV Accreditation</title>

</head>

<body class="light">
    <!-- Page Loader -->
    {{-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{asset('assets/images/favicon.png')}}" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div> --}}
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

       @include('layout.topbar')

    <div>


        @if (Auth::user()->role == '1')
        @include('layout.sidebar')
    @elseif(Auth::user()->role == '2')
        @include('layout.siderTp')
    @elseif(Auth::user()->role == '3')
        @include('layout.sideAss')
    @elseif(Auth::user()->role == '4')
        @include('layout.sideprof')
    @endif



        @include('layout.rightbar')


    </div>



    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">InterNational Application</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                            <li class="breadcrumb-item active">InterNational Application</li>
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
                                    <li class="nav-item tab-all p-l-20">
                                        <a class="nav-link active" href="#new_application" data-bs-toggle="tab">Rest of the World</a>
                                    </li>
                                    <li class="nav-item tab-all">
                                        <a class="nav-link  show" href="#level_information" data-bs-toggle="tab">SAARC Countries</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane " id="level_information" aria-expanded="true">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card project_widget">
                                        <div class="header">
                                            <h2>SAARC Countries</h2>
                                        </div>
                                        <div class="body">
                                            <div class="table-responsive">
                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>

                                                            <tr>
                                                                <th class="center">Sr.No</th>
                                                                <th class="center">Level</th>
                                                                <th class="center">Application Number</th>
                                                                <th class="center">Total Course</th>
                                                                <th class="center">Date of Application </th>
                                                                <th class="center">Assessment Date </th>
                                                                <!-- <th class="center">Due Date </th> -->

                                                                <th class="center">Action</th>

                                                            </tr>
                                                    </thead>
                                                    <tbody>



                                                @isset($collections)



                                                @foreach ($collections as $k=> $item)

                                                <?php
                                                $assessor_id = listofapplicationassessor($item->application_id);
                                                ?>

                                                <tr class="odd gradeX">
                                                    <td class="center">{{ $k+1 }}</td>
                                                    <td class="center">{{ $item->level_id  }}</td>
                                                    <td class="center">RAVAP-{{(4000+$item->application_id)}}</td>
                                                    <td class="center">{{  $item->course_count  }}</td>
                                                    <td class="center">{{application_submission_date($item->application_id,$assessor_id)}}</td>
                                                    <td class="center">{{assessor_assign_date($item->application_id,$assessor_id)}}</td>
                                                    <!-- <td class="center">{{assessor_due_date($item->application_id,$assessor_id)}}</td> -->

                                                    <td class="center">
                                                        <a href="{{ url('/Assessor-view/'.dEncrypt($item->application_id)) }}" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                                    </td>
                                                </tr>
                                                @endforeach

                                                @endisset
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
                        <div role="tabpanel" class="tab-pane active" id="new_application" aria-expanded="false">
                            <div class="card">
                                <div class="header">
                                    <h2>Rest of the world data </h2>
                                </div>
                                <div class="body">



                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example contact_list">
                                            <thead>
                                                <tr>
                                                    <th class="center">Sr.No</th>
                                                    <th class="center">Level </th>
                                                    <th class="center">Application Number</th>
                                                    <th class="center">Total Course</th>
                                                    <th class="center">Date of Application </th>
                                                    <th class="center">Assessment Date </th>
                                                    <!-- <th class="center">Due Date </th> -->

                                                    <th class="center">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                        @isset($collection)


                                                        @foreach ($collection as $k=> $item)

                                                        <?php
                                                        $assessor_id = listofapplicationassessor($item->application_id);
                                                        ?>

                                                        <tr class="odd gradeX">
                                                            <td class="center">{{ $k+1 }}</td>
                                                            <td class="center">{{ $item->level_id  }}</td>
                                                            <td class="center">RAVAP-{{(4000+$item->application_id)}}</td>
                                                            <td class="center">{{  $item->course_count  }}</td>
                                                            <td class="center">{{application_submission_date($item->application_id,$assessor_id)}}</td>
                                                            <td class="center">{{assessor_assign_date($item->application_id,$assessor_id)}}</td>
                                                            <!-- <td class="center">{{assessor_due_date($item->application_id,$assessor_id)}}</td> -->

                                                            <td class="center">
                                                                <a href="{{ url('/Assessor-view/'.dEncrypt($item->application_id)) }}" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                                            </td>
                                                        </tr>
                                                        @endforeach

                                                        @endisset
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

