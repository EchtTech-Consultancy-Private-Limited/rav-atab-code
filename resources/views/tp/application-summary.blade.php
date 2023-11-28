@include('layout.header')


<title>RAV Accreditation Previous Applications View</title>
<link rel="stylesheet" type="text/css"
    href="https://rawgithub.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
{{--
<link rel="stylesheet" type="text/css" href="https://rawgithub.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
 --}}
<style>
    .text-size-11 {
        font-size: 11px !important;
    }
</style>
</head>

<body class="light">

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
        @elseif(Auth::user()->role == '5')
            @include('layout.secretariat')
        @elseif(Auth::user()->role == '6')
            @include('layout.sidbarAccount')
        @endif

        @include('layout.rightbar')


    </div>


    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Application</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{ url('/dashboard') }}">
                                <i class="fas fa-home"></i> level</a>
                        </li>
                        <li class="breadcrumb-item active">Application Summary</li>
                    </ul>

                    <a href="{{ url('application-list') }}" type="button" class="btn btn-primary" style="float:right;">Back
                    </a>

                </div>
            </div>
        </div>

     
       
    </section>




    @include('layout.footer')
