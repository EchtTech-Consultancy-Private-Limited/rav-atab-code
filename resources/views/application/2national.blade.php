@include('layout.header')


<title>RAV Accreditation</title>

</head>

<body class="light">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
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
                                <h4 class="page-title">NATIONAL</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">National</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if (Session::has('sussess'))
                <div class="alert alert-success" role="alert">
                    {{ session::get('sussess') }}
                </div>
            @elseif(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('fail') }}
                </div>
            @endif



            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong></strong> NATIONAL
                            </h2>

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example contact_list">
                                    <thead>
                                        <tr>
                                            <th class="center">#S.N0</th>
                                            <th class="center">Level ID</th>
                                            <th class="center">Application No</th>
                                            <th class="center">Total Course</th>
                                            <th class="center">Total Fee</th>
                                            <th class="center"> Payment Date </th>
                                            <th class="center">Status</th>
                                            <th class="center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($collection)

                                        @foreach ($collection as $k => $item)
                                            <tr class="odd gradeX">
                                                <td class="center">{{ $k + 1 }}</td>
                                                <td class="center">{{ $item->level_id ?? '' }}</td>
                                                <td class="center">RAVAP-{{ 4000 + $item->user_id }}</td>
                                                <td class="center">{{ $item->course_count ?? '' }}</td>
                                                <td class="center">{{ $item->currency ?? '' }}{{ $item->amount ?? '' }}
                                                </td>
                                                <td class="center">{{ $item->payment_date ?? '' }}</td>
                                                <td class="center">


                                                    @if ($item->status == '0')
                                                        <a href="{{ url('preveious-app-status/' . dEncrypt($item->id)) }}"
                                                            onclick="return confirm_option('change status')"
                                                            @if ($item->status == 0) <div class="badge col-black">Pending</div> @elseif($item->status == 1) <div class="badge col-green">Proccess</div> @else @endif
                                                            </a>
                                                </td>
                                        @endif


                                        @if ($item->status == '1')
                                            <a href="{{ url('preveious-app-status/' . dEncrypt($item->id)) }}"
                                                onclick="return confirm_option('change status')"
                                                @if ($item->status == 0) <div class="badge col-black">Pending</div> @elseif($item->status == 1) <div class="badge col-green">Proccess</div> @else @endif
                                                </a>
                                                </td>
                                        @endif

                                        @if ($item->status == '2')
                                            <a href="{{ url('preveious-app-status/' . dEncrypt($item->id)) }}"
                                                onclick="return confirm_option('change status')"
                                                @if ($item->status == 1) <div class="badge col-green">Proccess</div> @elseif($item->status == 2) <div class="badge col-green">Approved</div> @else @endif
                                                </a>
                                                </td>
                                        @endif


                                        <td class="center">
                                            <a href="{{ url('/admin-view', dEncrypt($item->application_id)) }}"
                                                class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>
                                            {{-- <a data-bs-toggle="modal"  data-bs-target="#exampleModal" class="btn btn-tbl-edit"><i class="material-icons">accessibility</i></a> --}}
                                            <a class="btn btn-tbl-delete bg-primary" data-bs-toggle="modal"
                                                data-id='{{ $item->application_id ?? '' }}'
                                                data-bs-target="#View_popup" id="view"> <i
                                                    class="material-icons">accessibility</i>
                                            </a>

                                        </td>


                                        {{-- popup form --}}


                                        <div class="modal fade" id="View_popup" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle"> View
                                                            Details </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>




                                                    <form action="{{ url('/Assigan-application') }}" method="post">

                                                        @csrf
                                                        <div class="modal-body">

                                                            @foreach ($assesors as $k => $assesorsData)
                                                                <br>
                                                                <label>

                                                                    <input type="checkbox" id="assesorsid"
                                                                        name="assessor_id[]"
                                                                        value="{{ $assesorsData->id }}"
                                                                        @foreach ($checkbox as $P)

                                                                           @if ($P->id == $assesorsData->id)

                                                                           checked

                                                                           @endif @endforeach>

                                                                    <span>
                                                                        {{ $assesorsData->firstname }}
                                                                    </span>

                                                                </label>

                                                                <input type="hidden" name="application_id"
                                                                    value="{{ $item->application_id ?? '' }}">
                                                            @endforeach

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">save</button>
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

    {{-- multiple video section shwo --}}

    {{--
<script>
    $(document).on("click", "#view", function() {
        var UserName = $(this).data('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${BASE_URL}/Assigan-application`,
            type: "get",
            data: {
                id: UserName
            },
            success: function(data) {




            }

        });

    });
</script>


 --}}

    @include('layout.footer')
