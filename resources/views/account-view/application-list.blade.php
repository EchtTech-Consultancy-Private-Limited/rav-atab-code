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
                            <table class="table table-responsive" style="width:100%;" id="dataTableMain">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Level </th>
                                        <th>Application No. </th>
                                        <th>Courses</th>
                                        <th>Total Fee</th>
                                        <th>Payment Date </th>
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
                                                class="odd gradeX @if ($item->application_list->status == 2) approved_status @elseif($item->application_list->status == 1) process_status @elseif($item->application_list->status == 0) pending_status @endif">
                                                <td>{{ $k + 1 }}</td>
                                                <td>L-{{ $item->application_list->level_id ?? '' }}</td>
                                                <td>{{ $item->application_list->uhid }}</td>
                                                <td>{{ $item->course_count ?? '' }}</td>
                                                <td>
                                                @isset($item->payment)
                                                    @if($item->payment)
                                                    ₹ {{ $item->payment->payment_amount}}/- 
                                                    @else 
                                                        N/A 
                                                    @endif
                                                @endisset
                                                <span class="payment-count">
                                                @isset($item->payment)
                                                    @if($item?->payment)
                                                    ({{$item->payment->payment_count}})
                                                    @else
                                                        0
                                                    @endif
                                                @endisset
                                                </span>
                                                </td>
                                                <td>
                                                @isset($item->payment)
                                                    @if($item->payment)
                                                    {{\Carbon\Carbon::parse($item->payment->payment_date ?? '')->format('d-m-Y')}}
                                                    @else
                                                    N/A
                                                    @endif
                                                @endisset
                                                  
                                                </td>
                                                <td>
                                                <span class="badge badge-main <?php echo $item->application_list->status_color;?> ">{{$item->application_list->status_text}}</span>
                                                
                                                </td>
                                                <td>
                                                @if($item->application_list->valid_from)
                                                {{\Carbon\Carbon::parse($item->application_list->valid_from)->format('d-m-Y')}}
                                                @else
                                                <span>N/A</span>
                                                @endif
                                                </td>
                                                <td>
                                                @if($item->application_list->valid_till)
                                                {{\Carbon\Carbon::parse($item->application_list->valid_till)->format('d-m-Y')}}
                                                @else
                                                <span>N/A</span>
                                                @endif
                                                </td>
                                                <!-- <td>
                                                {{\Carbon\Carbon::parse($item->application_list->application_date ?? '')->format('d-m-Y')}}
                                                </td> -->
                                                    <td>
                                                        <a href="{{ url('/account/application-view', dEncrypt($item->application_list->id)) }}"
                                                            class="btn btn-tbl-edit"><i
                                                                class="material-icons">visibility</i></a>
                                                                
                                                    <a class="btn btn-tbl-delete bg-history font-a"  data-bs-toggle="modal" data-bs-target="#view_history_{{$item->application_list->id}}">
                                                    History
                                                    </a>
                                                    </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>

           



                </div>

@foreach($list as $item)

<!-- Modal history -->
<div class="modal fade" id="view_history_{{$item->application_list->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Application History</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                       <table class="table table-responsive-sm">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($item->appHistory as $key=>$hist)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$hist->created_at??''}}</td>
                            <td><span class="badge badge-main {{$hist->status_color??''}}">{{$hist->status_text??''}}</span></td>
                            
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
@endforeach
<!-- end here  -->

            </div>
        </div>
        </div>
        </div>
    </section>
   
    @include('layout.footer')
