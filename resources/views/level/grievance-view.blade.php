@include('layout.header')


<title>RAV Accreditation  Grievance</title>

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
                                <h4 class="page-title">Grievance </h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Grievance</a>
                            </li>
                            <li class="breadcrumb-item active">View Grievance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>view</strong> Grievance</h2>

                        </div>

                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">

                                                <label><strong>Issue Type</strong></label> </br>
                                                <label >{{ $data[0]->subject }}</label>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-sm-12">
                                        <div class="form-group">
                                                <label><strong>Remark</strong></label></br>
                                                <div class="form-line">
                                                    {!! $data[0]->details !!}
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


    <script src="{{asset('assets/js/bundles/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
    <script>
         tinymce.init({
        selector: 'textarea#details',
        menubar: 'edit insert view format table tools'
      });
    </script>

    @include('layout.footer')

