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
    @if (Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('error') }}
                </div>
    @endif
    @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session::get('success') }}
                </div>
    @endif
    <div class="full_screen_loading">Loading&#8230;</div>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($list)
                                        @foreach ($list as $k => $item)
                                            <tr
                                                class="odd gradeX @if ($item->application_list->status == 2) approved_status @elseif($item->application_list->status == 1) process_status @elseif($item->application_list->status == 0) pending_status @endif">
                                                <td>{{ $k + 1 }}</td>
                                                <td>Level-{{ $item->application_list->level_id ?? '' }}</td>
                                                <td>RAVAP-{{ $item->application_list->id }}</td>
                                                <td>Course ({{ $item->course_count ?? '' }})</td>
                                                <td>
                                            @isset($item->payment)
                                                ₹ {{ $item->payment->payment_amount}}/- <span class="payment-count">({{$item->payment->payment_count}})</span>
                                            @endisset
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->payment->payment_date ?? '')->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                @if($item->application_list->payment_status==0 || $item->application_list->payment_status==1)
                                                    <span class="badge badge-main danger">{{config('status_text.admin_status_pending')}}</span>
                                                    @elseif($item->application_list->payment_status==2)
                                                    <span class="badge badge-main warning">{{config('status_text.admin_status_process')}}</span>
                                                    @else
                                                    <span class="badge badge-main success">{{config('status_text.admin_status_completed')}}</span>
                                                    @endif
                                                </td>
                                                    <td>
                                                        <a href="{{ url('/admin/application-view', dEncrypt($item->application_list->id)) }}"
                                                            class="btn btn-tbl-edit"><i
                                                                class="material-icons">visibility</i></a>

                                                    @isset($item->payment)
                                                        @if($item->payment->aknowledgement_id==null)
                                                        <button id="acknowledgement_{{$item->application_list->id}}"
                                                            class="btn btn-primary btn-sm mb-0 p-2" style="margin-left: 5px !important;" title="Acknowledege Payment"><i class="fa fa-credit-card" aria-hidden="true" onclick="handleAcknowledgementPayment({{$item->application_list->id}})"></i></button>
                                                        @endif
                                                    @endisset   
                                                    

                                                    @isset($item->payment)
                                                        @if($item->payment->aknowledgement_id!==null && $item->doc_uploaded_count>=4    )
                                                    <a class="btn btn-tbl-delete bg-primary font-a"
                                                                    data-bs-toggle="modal" data-id="{{ $item->application_list->id }}"
                                                                    data-bs-target="#View_popup_{{ $item->application_list->id }}"
                                                                    id="view">
                                                    <i class="fa fa-font" aria-hidden="true" title=""></i>
                                                    </a>


                                                    <a class="btn btn-tbl-delete bg-danger font-a"
                                                                    data-bs-toggle="modal" data-id="{{ $item->application_list->id }}"
                                                                    data-bs-target="#view_secreate_popup_{{ $item->application_list->id }}"
                                                                    id="view">
                                                                    <i class="fa fa-scribd" aria-hidden="true"
                                                                        title=""></i>
                                                    </a>
                                                    @endif
                                                    @endisset  
                                                </td>
                                            </tr>
                                           
  <!-- Modal box assessor assign-->
<div class="modal fade" id="View_popup_{{ $item->application_list->id }}"
   tabindex="-1" role="dialog"
   aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
            <form action="{{ url('/admin-assign-assessor') }}"
               method="post">
               @csrf
               <!-- <input type="hidden" name="assessor_id_" id="assessor_id_" value=""> -->
                <input type="hidden" name="assessor_type" value="{{$item->assessor_type=='desktop'?'desktop':'onsite'}}">
                <?php
                    $application_assessor_arr = listofapplicationassessor($item->application_list->id);

                ?>
               <br>
               <label class="mb-3"><b>Assessment
               Type</b></label><br>

               <p>{{$item->assessor_type=="desktop"?'Desktop Assessment':'Onsite Assessment'}}</p>
               <!--   -->
                @if($item->assessor_type=="onsite")
               <div class="form-check form-check-inline radio-ass">
               <label>
                   <input type="radio" id="assesorsid_{{ $item->application_list->id }}" class="" name="on_site_type" value="onsite" checked @if($item->assessment_way=='onsite') checked @endif>
                    <span>
                        Onsite                     
                    </span>
                    </label>  

                    <label>
                   <input type="radio" id="assesorsid_{{ $item->application_list->id }}" class="" name="on_site_type" value="hybrid" @if($item->assessment_way=='hybrid') checked @endif>
                    <span>
                        Hybrid                     
                    </span>
                    </label>  

                    <label>
                   <input type="radio" id="assesorsid_{{ $item->application_list->id }}" class="" name="on_site_type" value="virtual" @if($item->assessment_way=='virtual') checked @endif>
                    <span>
                        Virtual                     
                    </span>
                    </label>  

              </div>
              @endif
            
             
                    
                   



               <div class="destop-id">
               @foreach ($item->assessor_list as $k => $assesorsData)
               <input type="hidden" name="application_id" value="{{ $item->application_list->id ?? '' }}">
                  <br>
                  <label>
                    
                  <input type="radio"
                  id="assesorsid"
                  class="d-none assesorsid"
                  name="assessor_id"
                  value="{{$assesorsData->id}}"
                  @if (in_array($assesorsData->id, $application_assessor_arr)) checked @endif 
                 
                  />
                  <span>
                  {{ ucfirst($assesorsData->firstname) }}
                    {{ ucfirst($assesorsData->lastname) }}
                    ({{ $assesorsData->email }})
                  </span>
                  </label>
              
                  <div id="assessor_assign_dates_{{$assesorsData->id}}">
                  <?php
                    foreach(get_accessor_date_new($assesorsData->id,$item->application_list->id,$assesorsData->assessment) as $date){
                    ?>
                    {!! $date !!}
                <?php }   ?>
                  </div>
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
