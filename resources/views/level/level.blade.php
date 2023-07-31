@include('layout.header')


<title>RAV Accreditation</title>

</head>

<body class="light">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{asset('assets/images/favicon.png')}}" alt="admin">
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


        @if(Auth::user()->role  == '1' )

        @include('layout.sidebar')

        @elseif(Auth::user()->role  == '2')

        @include('layout.siderTp')

        @elseif(Auth::user()->role  == '3')

        @include('layout.sideAss')

        @elseif(Auth::user()->role  == '4')

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
                                <h4 class="page-title">Level Information</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Level List</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(Session::has('sussess'))
            <div class="alert alert-success" role="alert">
                {{session::get('sussess')}}
            </div>
            @elseif(Session::has('fail'))
            <div class="alert alert-danger" role="alert">
                {{session::get('fail')}}
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
                                        <a class="nav-link active show" href="#level_information" data-bs-toggle="tab">Level Information</a>
                                    </li>
                                    {{-- <li class="nav-item tab-all p-l-20">
                                        <a class="nav-link" href="#new_application" data-bs-toggle="tab">Pending Application</a>
                                    </li>
                                    <li class="nav-item tab-all p-l-20">
                                        <a class="nav-link" href="#preveious_application" data-bs-toggle="tab">Processing Applications</a>
                                    </li>
                                    <li class="nav-item tab-all p-l-20">
                                        <a class="nav-link" href="#prossing_application" data-bs-toggle="tab">Approvel Applications</a>
                                    </li> --}}
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
                                            <h2>Level Information</h2>
                                        </div>
                                        <div class="body">
                                            <div class="table-responsive">
                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">#</th>
                                                            <th class="center"> Level Information </th>
                                                            <th class="center"> Prerequisites  </th>
                                                            <th class="center"> Documents Required </th>
                                                            <th class="center"> Validity </th>
                                                            <th class="center"> Fee Structure </th>
                                                            <th class="center">Timelines</th>
                                                            <th class="center"> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            @foreach ( $level as  $levels )
                                                            <tr class="odd gradeX">
                                                                <td class="center">{{ $levels->id }}</td>
                                                                <td class="center">{{substr_replace($levels->level_Information,'...',30)}}</td>
                                                                <td class="center">{{substr_replace($levels->Prerequisites,'...',30)}}</td>
                                                                <td class="center">{{substr_replace($levels->documents_required,'...',30)}}</td>
                                                                <td class="center">{{substr_replace($levels->validity ,'...',30)}}</td>
                                                                <td class="center">{{substr_replace($levels->fee_structure,'...',30)}}</td>
                                                                <td class="center">{{substr_replace( $levels->timelines,'...',30)}}</td>
                                                                <td class="center" style="white-space:nowrap;">
                                                                <a href="{{ url('/update-level'.'/'.dEncrypt($levels->id)) }}" class="btn btn-tbl-edit"><i class="material-icons">create</i></a>
                                                                <a href="{{ url('/level-view'.'/'.dEncrypt($levels->id)) }}" class="btn btn-tbl-delete"><i class="material-icons">description</i></a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
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

{{-- panding application  --}}

                         <div role="tabpanel" class="tab-pane" id="new_application" aria-expanded="false">
{{--

                            <div class="card">
                                <div class="header">
                                    <h2>Pending Application</h2>
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


                                                @foreach ($collection as $k=> $item)
                                                <tr class="odd gradeX">
                                                    <td class="center">{{ $k+1 }}</td>
                                                    <td class="center">{{ $item->level_id  }}</td>
                                                    <td class="center">RAVAP-{{(4000+$item->user_id)}}</td>
                                                    <td class="center">{{  $item->course_count  }}</td>
                                                    <td class="center">{{ $item->currency }}{{  $item->amount  }}</td>
                                                    <td class="center">{{  $item->payment_date  }}</td>
                                                    <td class="center">
                                                    <a href="{{ url('preveious-app-status/'.dEncrypt($item->id)) }}" onclick="return confirm_option('change status')"
                                                        @if($item->status == 0)<div class="badge col-black">Pending</div> @elseif( $item->status == 1) <div class="badge col-green">Proccess</div> @else    @endif
                                                        </a>
                                                    </td>


                                                    <td class="center">
                                                        <a href="{{ url('/admin-view') }}" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> --}}



{{-- prossing application  --}}

                        {{-- <div role="tabpanel" class="tab-pane" id="preveious_application" aria-expanded="false">
                            <div class="card">
                                <div class="header">
                                <h2>Processing Applications</h2>
                                </div>
                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example contact_list">
                                            <thead>
                                                <tr>
                                                    <th class="center">#S.N0</th>

                                                    <th class="center">Application No</th>
                                                    <th class="center">Level ID</th>
                                                    <th class="center">Total Course</th>
                                                    <th class="center">Total Fee</th>
                                                    <th class="center"> Payment Date </th>
                                                    <th class="center">Status</th>
                                                    <th class="center">Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($collection1 as $k=> $item)
                                                <tr class="odd gradeX">
                                                    <td class="center">{{ $k+1 }}</td>
                                                    <td class="center">RAVAP-{{(4000+$item->user_id)}}</td>
                                                    <td class="center">{{ $item->level_id  }}</td>
                                                    <td class="center">{{  $item->course_count  }}</td>
                                                    <td class="center">{{ $item->currency }}{{  $item->amount  }}</td>
                                                    <td class="center">{{  $item->payment_date  }}</td>
                                                    <td class="center">
                                                    <a href="{{ url('preveious-app-status/'.dEncrypt($item->id))}}" onclick="return confirm_option('change status')"
                                                        @if($item->status == 1)<div class="badge col-green">Proccess</div> @elseif( $item->status == 2) <div class="badge col-green">Approved</div> @else    @endif
                                                        </a>
                                                    </td>


                                                    <td class="center">
                                                        <a href="{{ url('/admin-view') }}" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div> --}}

{{-- prossing application  --}}

                        {{-- <div role="tabpanel" class="tab-pane" id="prossing_application" aria-expanded="false">
                            <div class="card">
                                <div class="header">
                                <h2>Approvel Applications</h2>
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

                                                @foreach ($collection2 as $k=> $item)
                                                <tr class="odd gradeX">
                                                    <td class="center">{{ $k+1 }}</td>
                                                    <td class="center">{{ $item->level_id  }}</td>
                                                    <td class="center">RAVAP-{{(4000+$item->user_id)}}</td>
                                                    <td class="center">{{  $item->course_count  }}</td>
                                                    <td class="center">{{ $item->currency }}{{  $item->amount  }}</td>
                                                    <td class="center">{{  $item->payment_date  }}</td>
                                                    <td class="center">
                                                    <a href="{{ url('preveious-app-status/'.dEncrypt($item->id)) }}" onclick="return confirm_option('change status')"
                                                        @if($item->status == 2)<div class="badge col-red">Approved</div> @elseif( $item->status == 3) <div class="badge col-green">Final Approved</div> @else    @endif
                                                        </a>
                                                    </td>
                                                    <td class="center">
                                                        <a href="{{ url('/admin-view') }}" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>



    </section>


    @include('layout.footer')

