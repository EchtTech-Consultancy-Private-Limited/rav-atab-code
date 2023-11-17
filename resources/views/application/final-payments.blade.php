@include('layout.header')
<!-- New CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/form.min.css') }}" class="js">
<title>RAV Accreditation</title>
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
        @endif
        @include('layout.rightbar')
    </div>
    <section class="content">
        <div class="card">
            <div class="card-header text-dark bg-white">
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <h5>Payments</h5>
                <div>
                    
                </div>
                </div>
            </div>
            <div class="card-body">
                <div>
                    @foreach ($payments as $item)
                        <div>
                            {{ $item->transaction_no }}
                        </div>
                    @endforeach
                </div>
                <div>
                    <h6 style="float:right; clear:none;" id="counter">
                        Total Amount (with 18% GST): {{ $total_amount + $total_amount * 0.18 ?? 0 }}
                    </h6>
                </div>
            </div>
        </div>
    </section>
    @include('layout.footer')
