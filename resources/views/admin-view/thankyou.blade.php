@include('layout.header')
<title>RAV Accreditation</title>
</head>

<body class="light">
    <div class="overlay"></div>
    @include('layout.topbar')
    <div>
        @if (Auth::user()->role == 1)
        @include('layout.sidebar')
        @elseif(Auth::user()->role == 2)
        @include('layout.siderTp')
        @elseif(Auth::user()->role == 3)
        @include('layout.sideAss')
        @elseif(Auth::user()->role == 4)
        @include('layout.sideprof')
        @elseif(Auth::user()->role == 5)
        @include('layout.secretariat')
        @elseif(Auth::user()->role == 6)
        @include('layout.sidbarAccount')
        @endif
        @include('layout.rightbar')
    </div>


    @if ($message = Session::get('success'))
    <script>
    toastr.success('{{$message}}', {
        timeOut: 0,
        extendedTimeOut: 0,
        closeButton: true,
        closeDuration: 5000,
    });
    </script>
    @endif
    @if ($message = Session::get('fail'))
    <script>
    toastr.error('{{$message}}', {
        timeOut: 0,
        extendedTimeOut: 0,
        closeButton: true,
        closeDuration: 5000,
    });
    </script>
    @endif
    <div class="full_screen_loading">Loading&#8230;</div>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">National Application</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">National Application</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="body h-100vh">
                            <div class="thank-you-container">
                               <div class="card-thank">
                               <h1 class="thank-text">Thank You !</h1>
                                <p class="thank-subtext">Thank you for visiting my website. You will receive an email
                                    message shortly.</p>
                                <div class="checkmark">
                                    <img src="{{ asset('assets/images/check-mark.png') }}" alt="">
                                </div>
                                <p class="transaction-id">Transaction Id : <span>2515426452</span></p>
                                <div class="text-center mt-4">
                                    <a href="#" class="btn btn-danger waves-effect">Back</a>
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