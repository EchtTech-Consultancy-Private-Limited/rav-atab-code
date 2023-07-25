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
                                <h4 class="page-title">Grievance-list</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Grievance</a>
                            </li>
                            <li class="breadcrumb-item active">Grievance-list</li>
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
                            <div role="tabpanel" class="tab-pane active" aria-expanded="true">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget">
                                            <div class="header">
                                                <h2>Grievance list</h2>

                                                @if (Auth::user()->role != '1')
                                                    <a type="button" href="{{ url('/Grievance') }}"
                                                        class="btn btn-primary " style="float: right;line-height:25px;">+
                                                        Add Grievance</a>
                                                @endif

                                            </div>
                                            @if ($message = Session::get('success'))
                                                <div class="alert alert-success">
                                                    <p>{{ $message }}</p>
                                                </div>
                                            @endif


                                            <div class="body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover js-basic-example contact_list">
                                                        <thead>
                                                            <tr>
                                                                <th class="center">#</th>
                                                                <th class="center"> subject </th>
                                                                <th class="center"> details </th>

                                                                @if (Auth::user()->role == '1')
                                                                    <th class="center"> Status </th>
                                                                    <th class="center"> Action </th>
                                                                @endif

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($data as $datas)
                                                                <tr class="odd gradeX">
                                                                    <td class="center">{{ $datas->id }}</td>
                                                                    <td class="center">{{ $datas->subject }}</td>
                                                                    <td class="center">{!! $datas->details !!}</td>

                                                                    @if (Auth::user()->role == '1')
                                                                        <td class="center">
                                                                            <a href="{{ url('active-Grievance' . '/' . $datas->id) }}"
                                                                                onclick="return confirm_option('change status')"
                                                                                @if ($datas->status == 0) <div class="badge col-brown">Pending</div> @elseif($datas->status == 1) <div class="badge col-green">Approved</div> @else @endif
                                                                                </a>
                                                                        </td>

                                                                        <td class="center">
                                                                            <a href="{{ url('view-Grievance' . '/' . $datas->id) }}"
                                                                                class="btn btn-tbl-edit"><i
                                                                                    class="material-icons">visibility</i></a>
                                                                        </td>
                                                                    @endif
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
        </div>
        </div>



    </section>


    @include('layout.footer')
