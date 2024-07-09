@include('layout.header')
<title>RAV Accreditation</title>
</head>
<body class="light">
    <div class="full_screen_loading">Loading&#8230;</div>
    <section class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="body h-100vh">
                            <div class="thank-you-container">
                               <div class="card-thank">
                               <h1 class="thank-text">Transaction Failed</h1>
                                <p class="thank-subtext">Please check your security code, card details and connection and try again.</p>
                                <div class="checkmark">
                                    <img src="{{ asset('assets/images/erroe-status.png') }}" alt="">
                                </div>
                                @if(isset($data['tran_id']) && $data['tran_id'] !='')
                                <p class="transaction-id">Transaction Id : <span>{{$data['tran_id']}}</span></p>
                                @endif
                                <div class="text-center mt-4">
                                    <!-- <a href="#" class="btn btn-danger waves-effect pt-2">Back to Payment Selection</a> -->
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