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

    @php
    $successMessage = session('success');
    $failMessage = session('fail');
@endphp

@if($successMessage)
    <script>
        toastr.success('{{ $successMessage }}', {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
        });
    </script>
@endif

@if($failMessage)
    <script>
        toastr.error('{{ $failMessage }}', {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: true,
            closeDuration: 5000,
        });
    </script>
@endif



    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Applications</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Applications</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                    <div class="card">
                        @include('level.inner-nav')
                    </div>
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
                                        <th> Payment Date </th>
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
                                                ₹ {{ $item->payment->payment_amount}}/- <span class="payment-count">({{$item->payment->payment_count}})</span>
                                                @endisset
                                                </td>
                                                <td>
                                                @isset($item->payment)
                                                    {{ \Carbon\Carbon::parse($item->payment->payment_date)->format('d-m-Y') }}
                                                    @endisset
                                                </td>
                                                <td>
                                                @if($item->application_list->level_id==3)
                                                <span class="badge badge-main <?php echo $item->application_list->status_color;?> ">{{$item->application_list->status_text}}</span>
                                                @else
                                                    @php
                                                        $status = getApplicationStatus($item->application_list->status,"TP");
                                                    @endphp
                                                <span class="badge badge-main <?php echo $status?->color;?> ">{{$status?->status_text}}</span>
                                                
                                                @endif
                                                
                                                
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
                                                    <td class="p-0-lg1">

                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                            @if($item->application_list->level_id == 1)
                                                                <a href="{{ url('/tp/application-view', dEncrypt($item->application_list->id)) }}" class="btn btn-tbl-edit">
                                                                    <i class="material-icons">visibility</i>
                                                                </a>
                                                            @elseif($item->application_list->level_id == 2)
                                                                <a href="{{ url('/upgrade/tp/application-view', dEncrypt($item->application_list->id)) }}" class="btn btn-tbl-edit">
                                                                    <i class="material-icons">visibility</i>
                                                                </a>
                                                            @elseif($item->application_list->level_id == 3)
                                                                <a href="{{ url('/upgrade/level-3/tp/application-view', dEncrypt($item->application_list->id)) }}" class="btn btn-tbl-edit">
                                                                    <i class="material-icons">visibility</i>
                                                                </a>
                                                            @endif

                                                            <a class="btn btn-tbl-delete bg-history font-a" data-bs-toggle="modal" data-bs-target="#view_history_{{$item->application_list->id}}">
                                                                History
                                                            </a>
                                                            <!-- If level - 1 -->
                                                        @if($item->application_list->approve_status == 1 && $item->application_list->upgraded_level_id == 1 && $item->application_list->level_id==1)
                                                                <div class="d-flex action-button-div">
                                                                    <?php
                                                                        $isApplicationBeingExpired = checkApplicationValidityExpire($item->application_list->id, $item->application_list->valid_till);
                                                                    ?>
                                                                    @if($isApplicationBeingExpired)
                                                                        <button class="btn btn-primary bg-history blink-btn text-white" data-bs-toggle="modal" data-bs-target="#expiry_popup">Upgrade</button>
                                                                    @else
                                                                        <!-- If previous application upgraded then need not to show l-1 and l-2 -->
                                                                        @if($item->application_list->upgraded_level_id == 1)
                                                                            <a href="{{ url('/upgrade-new-application/'.dEncrypt($item->application_list->id).'/'.dEncrypt($item->application_list->refid)) }}" class="btn btn-warning">L-2</a>
                                                                            <a href="{{ url('/upgrade-level-3-new-application/'.dEncrypt($item->application_list->id).'/'.dEncrypt($item->application_list->refid)) }}" class="btn btn-warning">L-3</a>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            @elseif($item->application_list->is_all_course_doc_verified == 2 && $item->application_list->approve_status == 1 && $item->application_list->level_id==1)
                                                                     @if($item->application_list->upgraded_level_id == 2)
                                                                    <a href="{{ url('/upgrade-create-new-course', dEncrypt($item->application_list->id).'/'.dEncrypt($item->application_list->refid)) }}" class="btn btn-success">Upgraded</a>
                                                                     @elseif($item->application_list->upgraded_level_id == 3)
                                                                    <a href="{{ url('/upgrade-level-3-create-new-course', dEncrypt($item->application_list->id).'/'.dEncrypt($item->application_list->refid)) }}" class="btn btn-success">Upgraded</a>
                                                                @endif
                                                            @elseif($item->application_list->is_all_course_doc_verified == 3 && $item->application_list->approve_status == 1 && $item->application_list->level_id==1)
                                                                <span class="badge badge-main success">Upgraded</span>
                                                            @endif
                                                            <!-- End here level - 1  -->

                                                            <!-- If level - 2 -->
                                                            @if($item->application_list->level_id == 2)
                                                                @php
                                                                    $reference_id = $item->application_list->prev_refid == null ? $item->application_list->refid : $item->application_list->prev_refid;
                                                                    
                                                                @endphp
                                                                
                                                                @if($item->application_list->upgraded_level_id == 1 && $item->application_list->approve_status == 1)
                                                                    <a href="{{ url('/upgrade-level-3-new-application/'.dEncrypt($item->application_list->id).'/'.dEncrypt($reference_id)) }}" class="btn btn-warning">L-3</a>
                                                                @elseif($item->application_list->is_all_course_doc_verified == 2 && $item->application_list->approve_status == 1)
                                                                    @if($item->application_list->upgraded_level_id == 3)
                                                                        <a href="{{ url('/upgrade-level-3-create-new-course', dEncrypt($item->application_list->prev_id).'/'.dEncrypt($item->application_list->refid)) }}" class="btn btn-success">Upgraded</a>
                                                                    @endif
                                                                @elseif($item->application_list->is_all_course_doc_verified == 3 && $item->application_list->approve_status == 1 && $item->application_list->upgraded_level_id == 3)
                                                                    <span class="badge badge-main success">Upgraded</span>
                                                                @endif
                                                            @endif
                                                            <!-- End here level - 2  -->

                                                            <!-- level-3 -->
                                                            @php
                                                                $is_second_payment = isSecondPayment($item->application_list->id);
                                                                
                                                            @endphp

                                                            @if($is_second_payment && $item->application_list->level_id==3)
                                                            <a href="{{ url('makepayment/'.dEncrypt($item->application_list->id)) }}" class="btn btn-primary btn-tbl-delete">S-Pay</a>
                                                            @endif
                                                            <!-- end here -->
                                                        </div>

                                                            </td>

                                                    
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
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
                            <td>{{$hist->created_at}}</td>
                            <td><span class="badge badge-main {{$hist->status_color}}">{{$hist->status_text}}</span></td>
                            
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


             <!-- Edit Payment modal  -->
             <div class="modal fade" id="expiry_popup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Expiry </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  
                </div>
                <div class="modal-body">
                <div class="mb-4 text-center">
                    <button type="button" class="btn btn-primary bg-history me-3">Level 2</button>
                    <button type="button" class="btn btn-success">Level 3</button>
                </div>
              <p class="font-16"> <b class="text-danger">Note :</b> Now your application is ready to move into next level. So please upgrade your application</p>
                </div>
            </div>
            </div>
        <!-- end here edit payment modal -->



    </section>
   
    @include('layout.footer')
