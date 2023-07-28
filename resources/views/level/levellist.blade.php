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
                                <h4 class="page-title">Applications </h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Applications List</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if (Session::has('sussess'))
                <div class="alert alert-success" role="alert">
                    {{ session::get('sussess') }}
                </div>
            @elseif(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('fail') }}
                </div>
            @endif

            <div class="row ">

                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget">
                                            <div class="header">

                                                <span style="float:right;" >


                                                    <a type="button" href="{{ url('/level-first') }}" class="btn btn-primary waves-effect" style="line-height:2;">+ Add New Application</a>


                                                    </span>
                                            </div>

                                            <div class="body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover js-basic-example contact_list" id="DtTable">
                                                        <thead>
                                                            <tr>

                                                                <th class="center"> Application ID </th>
<!--                                                                <th class="center"> Create User ID </th>-->
                                                                <th class="center"> Level ID </th>
                                                                <th class="center"> Country </th>
                                                                <th class="center"> Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @isset($data)

                                                                <tr>

                                                                    @foreach ($data as $item)

                                                                    @if(checktppaymentstatus($item->id) == 0)

                                                                        <td class="center">  RAVAP-{{ 4000 + $item->id }}</td></td>
<!--                                                                        <td class="center"> {{ $item->user_id ?? '' }}</td>-->
                                                                        <td class="center"> {{ $item->level_id ?? '' }}</td>
                                                                        <td class="center"> {{ $item->country_name ?? '' }}</td>

                                                                        <td class="center"> <a href="{{ url('/level-first'.'/'.$item->id) }}"
                                                                                class="btn btn-tbl-edit bg-success"><i
                                                                                    class="fa fa-edit"></i></a></td>

                                                                    @endif

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
        </div>
        </div>


    </section>

    @include('layout.footer')
