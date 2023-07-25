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
                                <h4 class="page-title">Email domain verification</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Dasboard </a>
                            </li>
                            <li class="breadcrumb-item active">Email verification<li>
                        </ul>
                    </div>
                </div>
            </div>


            @if(Session::has('success'))
            <div class="alert alert-success" id="alert" style="padding: 15px;" role="alert">
                {{session::get('success')}}
            </div>
            @elseif(Session::has('fail'))
            <div class="alert alert-danger" role="alert">
                {{session::get('fail')}}
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
                                                <h2>Add Email Domain :-</h2>
                                                </div>
                                                <form method="post" action="{{ url('email-verification') }}"
                                                    id="regForm" >

                                                    @csrf
                                                    <div class="body">
                                                        <div class="row clearfix">
                                                            <div class="col-sm-4 mb-0">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label>Email Domain<span
                                                                                class="text-danger">*</span></label>

                                                                         <input type="text" name="emaildomain" placeholder="Enter Email Domain" >

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 p-t-20">
                                                                <button type="submit"
                                                                    class="btn btn-primary waves-effect m-r-10">Submit</button>
                                                               
                                                            </div>
                                                        </div>
                                                </form>


                                                <!-- <hr> -->



                                           <div class="header">
                                                <h2>Email Domain List :-</h2>
                                                </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">#S.N0</th>
                                                            <th class="center">Email Domain</th>
                                                            <th class="center">Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        @foreach ($email as $k=> $files )
                                                            <tr class="odd gradeX">
                                                                <td class="center">{{ $k+1 }}</td>
                                                                 <td class="center">{{ $files->emaildomain }}</td>
                                                                <td class="center"> 
                                                                 <a href="{{ url('/Email-domoin-delete'.'/'.$files->id) }}" class="btn btn-tbl-delete mb-0">
                                                                    <i class="material-icons">delete</i>
                                                                 </a>
                                                                </td>

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



    </section>


    @include('layout.footer')
