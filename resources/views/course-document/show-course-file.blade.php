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


        @if(Auth::user()->role  == '1' )

        @include('layout.sidebar')

        @elseif(Auth::user()->role  == '2')

        @include('layout.siderTp')

        @elseif(Auth::user()->role  == '3')

        @include('layout.sideAss')

        @elseif(Auth::user()->role  == '4')

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
                                <h4 class="page-title"></h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Display file</li>
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

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card project_widget">

                                        <div class="body">

                                            <object data="{{ asset('documnet'.'/'.$data) }}" type="application/pdf" width="100%" height="500px">
                                                <p>Unable to display PDF file. 
                                               <a href="{{ asset('documnet'.'/'.$data) }}">Download</a> instead.</p>
                                            </object>







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

