@include('layout.header')
<!-- New CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/form.min.css') }}" class="js">

<style>
    /* Customize the appearance of the tooltip */
    .custom-tooltip {
        background-color: #007bff;
        /* Blue background color */
        color: #fff;
        /* White text color */
        border: 2px solid #0056b3;
        /* Darker blue border */
    }
</style>

<style>
    .button-blinking {
        background-color: #004A7F;
        -webkit-border-radius: 10px;
        border-radius: 10px;
        border: none;
        color: #FFFFFF;
        cursor: pointer;
        display: inline-block;
        font-family: Arial;
        font-size: 16px;
        padding: 5px 10px;
        text-align: center;
        text-decoration: none;
        -webkit-animation: glowing 1500ms infinite;
        -moz-animation: glowing 1500ms infinite;
        -o-animation: glowing 1500ms infinite;
        animation: glowing 1500ms infinite;
    }

    @-webkit-keyframes glowing {
        0% {
            background-color: #B20000;
            -webkit-box-shadow: 0 0 3px #B20000;
        }

        50% {
            background-color: #FF0000;
            -webkit-box-shadow: 0 0 40px #FF0000;
        }

        100% {
            background-color: #B20000;
            -webkit-box-shadow: 0 0 3px #B20000;
        }
    }

    @-moz-keyframes glowing {
        0% {
            background-color: #B20000;
            -moz-box-shadow: 0 0 3px #B20000;
        }

        50% {
            background-color: #FF0000;
            -moz-box-shadow: 0 0 40px #FF0000;
        }

        100% {
            background-color: #B20000;
            -moz-box-shadow: 0 0 3px #B20000;
        }
    }

    @-o-keyframes glowing {
        0% {
            background-color: #B20000;
            box-shadow: 0 0 3px #B20000;
        }

        50% {
            background-color: #FF0000;
            box-shadow: 0 0 40px #FF0000;
        }

        100% {
            background-color: #B20000;
            box-shadow: 0 0 3px #B20000;
        }
    }

    @keyframes glowing {
        0% {
            background-color: #B20000;
            box-shadow: 0 0 3px #B20000;
        }

        50% {
            background-color: #FF0000;
            box-shadow: 0 0 40px #FF0000;
        }

        100% {
            background-color: #B20000;
            box-shadow: 0 0 3px #B20000;
        }
    }
</style>
<style>
    @media (min-width: 900px) {
        .modal-dialog {
            max-width: 674px;
        }
    }

    .mr-2 {
        margin-right: 10px;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .card {
        margin-bottom: 12px;
    }

    div#ui-datepicker-div {
        background: #fff;
        /*    padding: 12px 15px 5px;*/
        border-radius: 10px;
        width: 310px;
        box-shadow: 0 5px 5px 0 rgba(44, 44, 44, 0.2);
    }

    .ui-datepicker-header.ui-widget-header.ui-helper-clearfix.ui-corner-all {
        display: flex;
        justify-content: space-between;
    }

    .payment-status.d-flex {
        align-items: center;
        width: 250px;
    }

    .select-box-hide-class select {
        display: none;
    }

    .form-control[type=file] {
        overflow: hidden;
        height: 3rem;
    }

    .btn_remove {
        background: #fff;
        border: 1px solid red;
        border-radius: 5px;
        padding: 3px 6px;
        color: red;
        transition: background-color 0.3s, color 0.3s;
        /* Add transition for smooth effect */
    }

    .btn_remove:hover {
        background-color: red;
        /* Change background color on hover */
        color: #fff;
        /* Change text color on hover */
    }

    .ui-datepicker-prev,
    .ui-datepicker-next {
        cursor: pointer;
    }
</style>
<title>RAV Accreditation</title>
</head>

<body class="light">

    @if (Session::has('success'))
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@elseif (Session::has('fail'))
    <script>
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: '{{ session('fail') }}',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@elseif (Session::has('payment_fail'))
    <script>
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: '{{ session('fail') }}',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif


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
                                <h4 class="page-title">
                                    Manage Applications
                                </h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                @if (request()->path() == 'level-first')
                                    Level First
                                @elseif(request()->path() == 'level-second')
                                    Level Second
                                @elseif(request()->path() == 'level-third')
                                    Level Third
                                @elseif(request()->path() == 'level-fourth')
                                    Level Fourth
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        @include('level.inner-nav')
                    </div>
                   

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    <div class="tab-content">

                        {{-- application payment table start --}}
                        <div>
                            <div class="card">
                                <div class="card-header bg-white text-dark">
                                    <h4 class="header-title mt-2"> Applications</h4>
                                </div>
                                <div class="body">
                                    <div class="table-responsive" style="width:100%; overflow-x:hidden; padding-bottom:20px;">
                                        <table class="table table-responsive" style="width:100%; overflow:hidden;" id="dataTableMain">
                                            <thead>
                                                <tr>
                                                    <th class="center">Sr.No</th>
                                                    <th class="center">Application No</th>
                                                    <th class="center">Level ID</th>
                                                    <th class="center">Courses</th>
                                                    <th class="center">Total Fee</th>
                                                    <th class="center"> Payment Date </th>
                                                    <th class="center">Status</th>
                                                    <th class="center">Upgrade</th>
                                                    <th class="center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @isset($collection)
                                                    @foreach ($collection as $k => $item)
                                                        <tr class="odd gradeX align-item-center"
                                                            style="font-size: 13px !important;">
                                                            <td class="center">{{ $k + 1 }}</td>
                                                            <td class="center">
                                                                {{ $item->application->application_uid }}
                                                            </td>
                                                            <td class="center level-id">{{ $item->level_id }}
                                                            </td>
                                                            <td class="center">{{ $item->course_count }}</td>
                                                            <td class="center">
                                                                {{ $item->currency }}{{ $item->amount }}
                                                            </td>
                                                            <td class="center">
                                                                {{ \Carbon\Carbon::parse($item->payment_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td class="center">
                                                                <a href="javascript:void(0)"
                                                                    @if ($item->status == 0) <div class="badge col-red">Applications Pending</div>
                                                                         @elseif($item->status == 1)
                                                                       <div class="badge col-orange">Applications In Process</div>
                                                                          @elseif($item->status == 2)
                                                                           <div class="badge col-orange">Applications In Process</div> @endif
                                                                    </a>
                                                            </td>
                                                            <td width="180">
                                                                @php
                                                                    $createdDate = \Carbon\Carbon::parse($item->created_at);
                                                                    $expiryDate = $createdDate->addYear();
                                                                    $currentDate = \Carbon\Carbon::now();

                                                                    // Calculate the difference in days between the current date and the expiry date
                                                                    $daysRemaining = $currentDate->diffInDays($expiryDate);
                                                                @endphp

                                                                @if ($daysRemaining <= 15)
                                                                    <form action="#" method="post">
                                                                        @csrf
                                                                        <button type="button" class="btn btn-primary"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            data-html="true"
                                                                            title='
                                                                                Upgrade Recommended:
                                                                                Your course expiry date is approaching,
                                                                                and you have only {{ $daysRemaining }} days left to upgrade your course.
                                                                            '>Upgrade
                                                                            Now</button>
                                                                    </form>
                                                                @else
                                                                    <span
                                                                        title="Expiry Date">{{ $expiryDate->format('d-m-Y') }}</span>
                                                                @endif
                                                            </td>
                                                            <td class="center">
                                                                <a href="{{ url('/previews-application-first' . '/' . $item->id . '/' . $item->application_id) }}"
                                                                    class="btn btn-tbl-edit"><i
                                                                        class="material-icons">visibility</i></a>

                                                            </td>
                                                            @if (request()->path() == 'level-first')
                                                            @elseif(request()->path() == 'level-second')
                                                                <td class="center">
                                                                    <!-- <a href="{{ url('/previews-application-second' . '/' . $item->id) }}"
                                                                                   class="btn btn-tbl-edit"><i
                                                                                       class="material-icons">visibility</i></a> -->
                                                                    @if ($item->status == 1)
                                                                        <a href="{{ url('/upload-document') }}"
                                                                            class="btn btn-tbl-upload"><i
                                                                                class="material-icons">upload</i></a>
                                                                    @endif
                                                                    @if ($item->status == 2)
                                                                        <a href="{{ url('/application-upgrade-third') }}"
                                                                            class="btn btn-tbl-edit"><i
                                                                                class="material-icons">edit</i></a>
                                                                    @endif
                                                                </td>
                                                            @elseif(request()->path() == 'level-third')
                                                                <td class="center">
                                                                    <a href="{{ url('/previews-application-third' . '/' . $item->id) }}"
                                                                        class="btn btn-tbl-edit"><i
                                                                            class="material-icons">visibility</i></a>
                                                                    @if ($item->status == 1)
                                                                        <a href="{{ url('/upload-document') }}"
                                                                            class="btn btn-tbl-upload"><i
                                                                                class="material-icons">upload</i></a>
                                                                    @endif
                                                                    @if ($item->status == 2)
                                                                        <a href="{{ url('/application-upgrade-forth') }}"
                                                                            class="btn btn-tbl-edit"><i
                                                                                class="material-icons">edit</i></a>
                                                                    @endif
                                                                </td>
                                                            @elseif(request()->path() == 'level-fourth')
                                                                <td class="center">
                                                                    <a href="{{ url('/previews-application-fourth') }}"
                                                                        class="btn btn-tbl-edit"><i
                                                                            class="material-icons">visibility</i></a>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @endisset
                                            </tbody>
                                        </table>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Modal
                                                            title
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ...
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- application payment table end --}}

                    </div>
                </div>


                @include('layout.footer')
                <!-- New JS -->
                <script>
                    $(document).ready(function() {
                        $('[data-toggle="tooltip"]').each(function() {
                            $(this).tooltip();
                        });
                    });
                </script>

</body>
