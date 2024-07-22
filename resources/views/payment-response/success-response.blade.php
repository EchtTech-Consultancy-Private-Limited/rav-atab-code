@include('layout.header')
<title>RAV Accreditation</title>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
    integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
section.reciept-container {
    background: #f7f7f7;
    height: 100vh !important;
}

section.reciept-container .reciept-wrapper {
    background: #fff;
    padding: 25px;
    border: 1px solid #d1d1d1;
    border-radius: 7px;
    box-shadow: 0px 0px 22px #d9d9d9;
}

.reciept-title {
    font-size: 22px !important;
    text-align: center;
    color: #484848;
    margin-bottom: 30px;
    font-weight: 600;
}

p.receipt-date {
    text-align: center;
    font-size: 14px;
    color: #7e7e7e;
}

table.reciept-table {
    width: 100%;
}

table.reciept-table tr {
    border-bottom: 1px solid #b7b7b7;
}

table.reciept-table tr:first-child {
    border-top: 1px solid #b7b7b7;
}

table.reciept-table tr td {
    padding: 7px 10px;
    color: #000;
}

table.reciept-table tr td:nth-child(2) {
    text-align: right;
}

tr.receipt-total td {
    color: #000 !important;
    font-weight: bold;
}

p.greeting {
    text-align: center;
    padding-top: 23px;
    font-size: 14px;
    color: #006c62;
    margin: 0;
}

.success-trick img {
    width: 54px;
}

.reciept-print {
    position: absolute;
    right: 14px;
    width: 40px;
    height: 32px;
    background: #009045;
    border-radius: 6px;
    color: #fff;
    font-size: 21px;
    cursor: pointer;
}

.card-thank {
    position: relative;
}
</style>

<body class="light">
    <div class="overlay"></div>
    <div class="full_screen_loading">Loading&#8230;</div>
    <section class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="body h-100vh" id="print-reciept-container">


                            <div class="thank-you-container">
                                <div class="card-thank">
                                    <div class="reciept-print" onclick="printReceipt('print-reciept-container')">
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                    </div>
                                    <div class="print-reciept-container">
                                        <h1 class="thank-text">Thank You !</h1>
                                        <p class="thank-subtext">Thank you for visiting my website. You will receive an
                                            email
                                            message shortly.</p>
                                        <div class="checkmark">
                                            <img src="{{ asset('assets/images/check-mark.png') }}" alt="">
                                        </div>
                                        <p class="transaction-id">Your Transaction ID :
                                            <span>{{$data['tran_id']}}</span>
                                        </p>
                                        <div class="text-center mt-4">
                                            <section class="">
                                                <div class="">
                                                    <div
                                                        class="row d-flex justify-content-center h-100 align-items-center">
                                                        <div class="reciept-wrapper">

                                                            <h1 class="reciept-title">
                                                                Ayurveda Training Accreditation Board (ATAB)
                                                            </h1>
                                                            <p class="receipt-date">{{date('l', strtotime($data['datetime']))??''}}, 
                                                                {{date('M', strtotime($data['datetime']))??''}} 
                                                                {{date('Y', strtotime($data['datetime']))??''}} 
                                                                at {{date('g:ia', strtotime($data['datetime']))??''}}</p>

                                                            <table class="reciept-table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Courses Fee</td>
                                                                        <td>{{($data['amount']-($data['amount']-($data['amount']*(100/(100+18)))))??''}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>GST Fee (18%)</td>
                                                                        <td>{{
                                                                            $data['amount']-($data['amount']*(100/(100+18)))
                                                                        }}</td>
                                                                    </tr>
                                                                    <tr class="receipt-total">
                                                                        <td>Total</td>
                                                                        <td>Rs. ={{$data['amount']??''}}/-</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <p class="greeting">Thanks for being a great customer</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- <a href="#" class="btn btn-danger waves-effect pt-2">Back</a> -->
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

    <script>
    function printReceipt(divId) {
    var printContents = document.getElementById(divId).innerHTML;
    
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    var elementsToHide = document.querySelectorAll('.reciept-print');
    elementsToHide.forEach(function(element) {
        element.style.display = 'none';
    });

    window.print();
    document.body.innerHTML = originalContents;
}

    </script>
    @include('layout.footer')