@include('layout.header')
<title>RAV Accreditation</title>
</head>
<body class="light">
    <div class="overlay"></div>
    <div class="full_screen_loading">Loading&#8230;</div>
    <section class="">
        <div class="container-fluid">
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
                                <p class="transaction-id">Your Transaction ID : <span>{{$data['tran_id']}}</span></p>
                                <div class="text-center mt-4">
                                    <!-- <a href="#" class="btn btn-danger waves-effect pt-2">Back</a> -->
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