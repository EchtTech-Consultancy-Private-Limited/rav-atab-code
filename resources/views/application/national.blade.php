@include('layout.header')
<title>RAV Accreditation</title>
<style>
    .process_status {
        background-color: #d9e42657;
    }

    .pending_status {
        background-color: #ff000042;
    }

    .approved_status {
        background-color: #00800040;
    }

    .mod-css {
        padding: 15px !important;
    }

    .modal-body.mod-css span {
        font-size: 18px !important;
        margin-bottom: 15px !important;
        height: 30px;
        line-height: 26px;
        color: #000;
    }

    .font-a {
        line-height: 20px !important;
    }

    .buttonBadge {
        font-size: 12px;
        border-radius: 5px;
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
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">National Applications</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">National Applications</li>
                        </ul>
                    </div>
                </div>
            </div>
            @if (Session::has('success'))
                <script>
                    Swal.fire({
                        title: "Success",
                        icon: "success",
                        text: "{{ session('success') }}",
                        timer: 3000, // Time in milliseconds (2 seconds in this example)
                        showConfirmButton: false,
                    });
                </script>
            @elseif(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('fail') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('error') }}
                </div>
            @elseif(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('fail') }}
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header bg-white text-dark">
                            <h4 class="header-title mt-2">
                                National Applications
                                </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive" style="width:100%; overflow:hidden; padding-bottom:20px;">


                                <!-- The Modal -->
                                <div class="modal" id="myModal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Modal Heading</h4>
                                                <button type="button" class="close"
                                                    data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                Modal body..
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <table class="table table-responsive" style="width:100%;" id="dataTableMain">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Level </th>
                                        <th>Application No. </th>
                                        <th>Courses</th>
                                        <th>Total Fee</th>
                                        <th> Payment Date </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($collection)
                                        @foreach ($collection as $k => $item)
                                            <tr
                                                class="odd gradeX @if ($item->status == '2') approved_status @elseif($item->status == '1') process_status @elseif($item->status == '0') pending_status @endif">
                                                <td>{{ $k + 1 }}</td>
                                                <td>{{ $item->level_id ?? '' }}</td>
                                                <td>{{ $item->application_uid }}</td>
                                                <td>{{ $item->courses->count() ?? '' }}</td>
                                                <td>
                                                    @php
                                                        $totalAmount = 0;
                                                        $paymentNumbers = [];
                                                    @endphp
                                                    @foreach ($item->payments as $payment)
                                                        @php
                                                            $totalAmount += $payment->amount;
                                                            $paymentNumbers[] = $loop->iteration;
                                                        @endphp
                                                        @if ($loop->iteration === 1)
                                                            {{ $payment->currency }}
                                                        @endif
                                                    @endforeach
                                                    @if ($totalAmount !== 0)
                                                        {{ $totalAmount }}({{ implode(', ', $paymentNumbers) }})
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->payment_date)->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    @if (totalDocumentsCount($item->id) > 0)
                                                        <div class="d-flex">
                                                            <a href="{{ auth()->user()->role == 1 ? url('admin/application/documents/' . $item->id . '/summary') : '' }}"
                                                                class="p-2 buttonBadge text-white bg-warning"
                                                                style="margin-right: 5px;">Application In
                                                                Processing</a>
                                                            @if ($item->is_payment_acknowledge !== 1)
                                                                <form action="{{ route('payment.acknowledge') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="applicationID"
                                                                        value="{{ $item->id }}">
                                                                    <button
                                                                        class="btn btn-primary btn-sm mb-0 p-2">Acknowledge
                                                                        Payment</button>
                                                                </form>
                                                            @endif

                                                        </div>
                                                    @else
                                                        @if ($item->payment != null)
                                                            @if ($item->payment->status == '0')
                                                                <a href="{{ auth()->user()->role == 1 ? url('admin/application/documents/' . $item->id . '/summary') : '' }}"
                                                                    class="p-2 buttonBadge text-white bg-danger">Payment
                                                                    Pending</a>
                                                            @elseif($item->payment->status == 1)
                                                                <a href="{{ auth()->user()->role == 1 ? url('admin/application/documents/' . $item->id . '/summary') : '' }}"
                                                                    class="p-2 buttonBadge text-light bg-warning">Payment
                                                                    Proccess</a>
                                                            @elseif ($item->payment->status == '2')
                                                                <a href="{{ auth()->user()->role == 1 ? url('admin/application/documents/' . $item->id . '/summary') : '' }}"
                                                                    class="p-2 buttonBadge text-white bg-primary">Payment
                                                                    Approved</a>
                                                            @endif
                                                            @else
                                                            <a 
                                                                class="p-2 buttonBadge text-white bg-danger">Payment
                                                                Pending</a>
                                                        @endif
                                                    @endif
                                                </td>

                                                @if (Auth::user()->role == 6)
                                                    <td>
                                                        <a href="{{ url('/admin-view', dEncrypt($item->id)) }}"
                                                            class="btn btn-tbl-edit"><i
                                                                class="material-icons">visibility</i></a>
                                                    </td>
                                                @endif
                                                @if (Auth::user()->role == 1)
                                                    <td>
                                                        <a href="{{ url('/admin-view', dEncrypt($item->id)) }}"
                                                            class="btn btn-tbl-edit">
                                                            <i class="material-icons">visibility</i>
                                                        </a>

                                                        {{-- @if (totalDocumentsCount($item->id) >= totalQuestionsCount($item->id)) --}}
                                                        @if (totalDocumentsCount($item->id) >= 2 && $item->acknowledged_by != null && $item->is_payment_acknowledge == 1)
                                                            @if (in_array(checktppaymentstatustype($item->id), [2, 3]))
                                                                <a class="btn btn-tbl-delete bg-primary font-a"
                                                                    data-bs-toggle="modal" data-id="{{ $item->id }}"
                                                                    data-bs-target="#View_popup_{{ $item->id }}"
                                                                    id="view">
                                                                    <i class="fa fa-font" aria-hidden="true"
                                                                        title=""></i>
                                                                </a>
                                                            @endif

                                                            @if (in_array(checktppaymentstatustype($item->id), [2, 3]))
                                                                <a class="btn btn-tbl-delete bg-danger font-a"
                                                                    data-bs-toggle="modal" data-id="{{ $item->id }}"
                                                                    data-bs-target="#view_secreate_popup_{{ $item->id }}"
                                                                    id="view">
                                                                    <i class="fa fa-scribd" aria-hidden="true"
                                                                        title=""></i>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                @endif
                                                {{-- popup form --}}
                                                <div class="modal fade" id="View_popup_{{ $item->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalCenterTitle">
                                                                    Assign an
                                                                    Assessor to the application from the below list
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body mod-css">
                                                                <form action="{{ url('/Assigan-application') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="application_id"
                                                                        value="{{ $item->id }}">
                                                                    <?php
                                                                    $application_assessor_arr = listofapplicationassessor($item->id);
                                                                    $assessment_type = checkapplicationassessmenttype($item->id);
                                                                    ?>
                                                                    <br>
                                                                    <label class="mb-3"><b>Assessment
                                                                            Type</b></label><br>
                                                                    <select name="assessment_type" required
                                                                        class="form-control assessment_type">
                                                                        <option value="0">Select Assessment Type
                                                                        </option>
                                                                        @if ($item->desktop_status !== 1 && count($item->payments) == 1)
                                                                            <option value="1">Desktop Assessment
                                                                            </option>
                                                                        @endif
                                                                        @if ($item->desktop_status == 1 && count($item->payments) > 1)
                                                                            <option value="2">On-Site Assessment
                                                                            </option>
                                                                        @endif

                                                                    </select>
                                                                    <div class="destop-id" data-id="{{ $item->id }}">
                                                                        @foreach ($assesors as $k => $assesorsData)
                                                                            @if ($assesorsData->assessment == 1)
                                                                                <br>

                                                                                <label>

                                                                                    <input type="radio" id="assesorsid"
                                                                                        class="d-none assesorsid "
                                                                                        name="assessor_id"
                                                                                        data-application-id="{{ $item->id }}"
                                                                                        value="{{ $assesorsData->id }}"
                                                                                        @if (in_array($assesorsData->id, $application_assessor_arr)) checked @endif>
                                                                                    <span>
                                                                                        {{ ucfirst($assesorsData->firstname) }}
                                                                                        {{ ucfirst($assesorsData->lastname) }}
                                                                                        ({{ $assesorsData->email }})
                                                                                    </span>
                                                                                </label>
                                                                                <input type="hidden" name="sec_email[]"
                                                                                    value="{{ $assesorsData->email }}">
                                                                                <div>
                                                                                    <?php
                                                         foreach(get_accessor_date($assesorsData->id) as $date){
                                                         ?>
                                                                                    {!! $date !!}
                                                                                    <?php }   ?>
                                                                                </div>
                                                                                <input type="hidden"
                                                                                    name="application_id"
                                                                                    value="{{ $item->id ?? '' }}">
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="onsite-id">
                                                                        @foreach ($assesors as $k => $assesorsData)
                                                                            @if ($assesorsData->assessment == 2)
                                                                                <br>
                                                                                <label>
                                                                                    <input type="radio" id="assesorsid"
                                                                                        class="d-none "
                                                                                        name="assessor_radio"
                                                                                        value="{{ $assesorsData->id }}"
                                                                                        @if (in_array($assesorsData->id, $application_assessor_arr)) checked @endif>
                                                                                    <span>
                                                                                        {{ $assesorsData->firstname }}
                                                                                        {{ $assesorsData->lastname }}
                                                                                        ({{ $assesorsData->email }})
                                                                                    </span>
                                                                                </label>
                                                                                <input type="hidden" name="sec_email"
                                                                                    value="{{ $assesorsData->email }}">
                                                                                <div>
                                                                                    <?php
                                                         foreach(get_accessor_date($assesorsData->id) as $date){
                                                         ?>
                                                                                    {!! $date !!}
                                                                                    <?php }   ?>
                                                                                </div>
                                                                                <input type="hidden"
                                                                                    name="application_id"
                                                                                    value="{{ $item->id ?? '' }}">
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" onclick="cancelAssign()"
                                                                    class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary my-button">Submit</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- secreate user popup-->
                                                <div class="modal fade" id="view_secreate_popup_{{ $item->id }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalCenterTitle">
                                                                    Assign
                                                                    an Secretariat to the application from the below
                                                                    list </h5>
                                                                <button type="button" class="close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ url('/assigan-secretariat-application') }}"
                                                                method="post">
                                                                @csrf
                                                                <?php
                                                                $application_assessor_arr = listofapplicationsecretariat($item->id);
                                                                $assessment_type = checkapplicationassessmenttype($item->id);
                                                                ?>
                                                                <br>

                                                                <div class="modal-body mod-css">
                                                                    @foreach ($secretariatdata as $k => $assesorsData)
                                                                        <br>
                                                                        <label>
                                                                            <input type="checkbox" id="assesorsid"
                                                                                class="d-none" name="secretariat_id[]"
                                                                                value="{{ $assesorsData->id }}"
                                                                                @if (in_array($assesorsData->id, $application_assessor_arr)) checked @endif>
                                                                            <span>
                                                                                {{ $assesorsData->firstname }}
                                                                            </span>
                                                                        </label>
                                                                        <input type="hidden" name="sec_email"
                                                                            value="{{ $assesorsData->email }}">

                                                                        <input type="hidden" name="application_id"
                                                                            class="application_id"
                                                                            value="{{ $item->id ?? '' }}">
                                                                    @endforeach
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Save</button>
                                                                </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
    <div class="modal fade" id="applicationModalAndData" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content p-0 m-0">
                <div class="modal-body p-0 m-0">
                    <div class="card m-0">
                        <div class="card-header bg-white text-dark">
                            <h5>Application Detail</h5>
                        </div>
                        <div class="card-body">
                            <div id="applicationDetailContainer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.assessment_type').on('change', function() {

            var data = $(this).val();
            ///  alert(data);

            if (data == 1) {
                //alert('1');
                $('.destop-id').show();
                $('.onsite-id').hide();
                $('.my-button').prop('disabled', false)
                $('.modal-footer').show();

            } else if (data == 2) {

                // alert('2');
                $('.destop-id').hide();
                $('.onsite-id').show();
                $('.modal-footer').show();
                $('.my-button').prop('disabled', false)

            } else {
                //alert('hii')
                $('.destop-id').hide();
                $('.onsite-id').hide();
                $('.my-button').attr('disabled', false)
                $('.modal-footer').hide();
            }
        });


        $(document).ready(function() {
            $('.destop-id').hide();
            $('.onsite-id').hide();
            $('.my-button').prop('disabled', true)
            $('.modal-footer').hide();
        });




        $('.assesorsid').on('click', function() {

            var application_id = $(this).data('application-id');

            var assessor_id = $(this).val();


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                url: "{{ url('/assigin-check-delete') }}",
                type: "get",
                data: {
                    id: application_id,
                    assessor_id
                },
                success: function(data) {
                    //alert(data)

                    if (data === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Application has been unassigned from the assessor successfully.',
                        }).then(() => {
                            location.reload(true);
                        });
                    }


                }

            });

        });

        function cancelAssign() {
            location.reload(true);
        }
    </script>


    @include('layout.footer')
