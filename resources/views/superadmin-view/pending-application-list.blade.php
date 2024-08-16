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
                            <table class="table table-responsive" style="width:100%;" id="dataTableMain-admin">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Level </th>
                                        <th>Application No. </th>
                                        <th>Status</th>
                                        <th>Valid From</th>
                                        <th>Valid To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($list)
                                        @foreach ($list as $k => $item)
                                            <tr
                                                class="odd gradeX @if ($item->status == 2) approved_status @elseif($item->status == 1) process_status @elseif($item->status == 0) pending_status @endif">
                                                <td>{{ $item->id }}</td>
                                                <td>L-{{ $item->level_id ?? '' }}</td>
                                                <td>{{ $item->uhid }}</td>
                                                <td>
                                                @php
                                                        $status = getApplicationStatus($item->status,"Admin");
                                                    @endphp
                                                <span class="badge badge-main <?php echo $status?->color;?> ">{{$status?->status_text}}</span>
                                                </td>
                                                <td>
                                                @if($item->valid_from)
                                                {{\Carbon\Carbon::parse($item->valid_from)->format('d-m-Y')}}
                                                @else
                                                <span>N/A</span>
                                                @endif
                                                </td>
                                                <td>
                                                @if($item->valid_till)
                                                {{\Carbon\Carbon::parse($item->valid_till)->format('d-m-Y')}}
                                                @else
                                                <span>N/A</span>
                                                @endif
                                                </td>
                                                   <td>

                                                   </td>
                                            </tr>

           

      
   </div>
</div>



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
   
    @include('layout.footer')
