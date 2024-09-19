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
                        <div class="body table-responsive">
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
                                                @if($item->assign_day_for_verify!=0)
                                                <span class="badge badge-main success">Assigned Date[{{\Carbon\Carbon::parse($item->valid_till)->format('d-m-Y')}}]</span>
                                                @else
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#raise_query_payment"
                                                    onclick="setPayModalData({{$item->id}})"
                                                    class="btn btn-tbl-edit bg-warning">
                                                    <i class="material-icons">event</i>
                                                </a>
                                                @endif

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

<!-- Modal -->
<div class="modal fade" id="raise_query_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content time-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="raise_query_payment">Give extra days</h5>
        
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="dateForm">
      <se class="modal-body">
                <label for="dateInput">Select a date and time:</label>
                <input type="text" id="dateInput" name="date" class="form-control custom-input-date-time">
                <input type="text" id="timeInput" name="timeInput" class="form-control custom-input-date-time">

                <input type="hidden" name="application_id" value="" id="application_id"/>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="handleToGiveExtraDates()">Assign extra Date</button>
        </form>
      </div>
    </div>
  </div>
</div>
        <!-- end here edit payment modal -->


    </section>
  
    @include('layout.footer')
