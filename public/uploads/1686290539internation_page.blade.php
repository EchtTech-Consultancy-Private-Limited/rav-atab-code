@include('layout.header')


<title>RAV Accreditation</title>
<style>

    .mod-css{
    padding:15px !important;
}

.modal-body.mod-css span {
    font-size: 18px !important;
    margin-bottom: 15px !important;
    height: 30px;
    line-height: 26px;
    color: #000;
}

    </style>
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
                                <h4 class="page-title">Dashboard</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                            <li class="breadcrumb-item active">International</li>
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

            <div class="row ">

                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="profile-tab-box">
                                <div class="p-l-20">
                                    <ul class="nav ">
                                        <li class="nav-item tab-all">
                                            <a class="nav-link active show" href="#level_information"
                                                data-bs-toggle="tab">Rest of the World</a>
                                        </li>
                                        <li class="nav-item tab-all p-l-20">
                                            <a class="nav-link" href="#new_application" data-bs-toggle="tab">SAARC Countries
                                                </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget">
                                            <div class="header">
                                                <h2>Rest of the World</h2>
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
                                                                        <td class="center">RAVAP-{{ 4000 + $item->application_id  }}</td>
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
                                                                        data-bs-target="#View_popup_{{$item->application_id}}" id="view"> <i
                                                                            class="material-icons">accessibility</i>
                                                                    </a>

                                                                </td>


                                                                {{-- popup form --}}


                                                                <div class="modal fade" id="View_popup_{{$item->application_id}}" tabindex="-1" role="dialog"
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
                                                                                <?php $application_assessor_arr = listofapplicationassessor($item->application_id);
                                                             $assessment_type = checkapplicationassessmenttype($item->application_id);      
                                                             ?> 
                                                            <br>
                                                             <select name="assessment_type" id="assessment_type" class="form-control">
                                                              <option value="">Select Assessment Type</option>
                                                              <option value="1" @if($assessment_type == 1) { 
                                                               selected @endif>Desktop Assessment</option>
                                                              <option value="2" @if($assessment_type == 2) { 
                                                               selected @endif>On-Site Assessment</option>
                                                              <option value="3" @if($assessment_type == 3) { 
                                                               selected @endif>Surveillance Assessment</option>
                                                              <option value="4" @if($assessment_type == 4) { 
                                                               selected @endif>Surprise Assessment</option>
                                                              <option value="5" @if($assessment_type == 5) { 
                                                               selected @endif>Re-Assessment</option>  

                                                             </select>
                                                                                <div class="modal-body mod-css">

                                                                                    @foreach ($assesors as $k => $assesorsData)
                                                                                        <br>
                                                                                        <label>

                                                                                            <input type="checkbox" id="assesorsid" class="d-none"
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
                            <div role="tabpanel" class="tab-pane" id="timeline" aria-expanded="false">
                            </div>
                            <div role="tabpanel" class="tab-pane" id="new_application" aria-expanded="false">
                                <div class="card">
                                    <div class="header">
                                        <h2>SAARC Countries </h2>
                                    </div>
                                    <div class="body">



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
                                                        @isset($collections)

                                                            @foreach ($collections as $k => $item)
                                                                <tr class="odd gradeX">
                                                                    <td class="center">{{ $k + 1 }}</td>
                                                                    <td class="center">{{ $item->level_id ?? '' }}</td>
                                                                    <td class="center">RAVAP-{{ 4000 + $item->application_id  }}</td>
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
                </div>

            </div>
        </div>
        </div>

    </section>


    @include('layout.footer')
