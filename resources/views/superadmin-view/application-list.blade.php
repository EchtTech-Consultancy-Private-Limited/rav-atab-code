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
                                                <td>{{ $item->application_list->id }}</td>
                                                <td>L-{{ $item->application_list->level_id ?? '' }}</td>
                                                <td>{{ $item->application_list->uhid }}</td>
                                                <td>{{ $item->course_count ?? '' }}</td>
                                                <td>
                                            @isset($item->payment)
                                                ₹ {{ $item->payment->payment_amount}}/- <span class="payment-count">({{$item->payment->payment_count}})</span>
                                            @endisset
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->payment->payment_date ?? '')->format('d-m-Y') }}
                                                </td>
                                                
                                                <td>
                                                @php
                                                        $status = getApplicationStatus($item->application_list->status,"Admin");
                                                    @endphp
                                                <span class="badge badge-main <?php echo $status?->color;?> ">{{$status?->status_text}}</span>
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
                                                    <td>
                                                        <a href="{{ url('/super-admin/application-view', dEncrypt($item->application_list->id)) }}"
                                                            class="btn btn-tbl-edit"><i
                                                                class="material-icons">visibility</i></a>
                                                    @isset($item->payment)
                                                        @if($item->payment->aknowledgement_id==null && $item->payment->accountant_id &&  $item->payment->approve_remark!=null)
                                                        <button id="acknowledgement_{{$item->application_list->id}}"
                                                            class="btn btn-primary btn-sm mb-0 p-2" style="margin-left: 5px !important;" title="Acknowledge Payment"><i class="fa fa-credit-card" aria-hidden="true" onclick="handleAcknowledgementPayment({{$item->application_list->id}})"></i></button>
                                                        @endif
                                                    @endisset   
                                            
                                             @isset($item->payment)
                                             @if(($item->payment->aknowledgement_id!=null && $item->payment->approve_remark!=null && $item->payment->last_payment->status==2) || $item->application_list->second_payment==6)
                                             
                                                   @if($item->application_list->level_id!=1)
                                                   
                                                    <a class="btn btn-tbl-delete bg-danger font-a"
                                                                    data-bs-toggle="modal" data-id="{{ $item->application_list->id }}"
                                                                    data-bs-target="#View_popup_{{ $item->application_list->id }}"
                                                                    id="view">
                                                                    <i class="fa fa-scribd" aria-hidden="true"
                                                                        title=""></i>
                                                    </a>

                                                @else

                                                        @if($item->application_list->level_id==1)
                                                        <a class="btn btn-tbl-delete bg-danger font-a"
                                                                    data-bs-toggle="modal" data-id="{{ $item->application_list->id }}"
                                                                    data-bs-target="#View_popup_{{ $item->application_list->id }}"
                                                                    id="view">
                                                                    <i class="fa fa-scribd" aria-hidden="true"
                                                                        title=""></i>
                                                         </a>
                                                        @endif

                                                    @endif
                                                @endif
                                                
                                            @endisset  

                                                    <a class="btn btn-tbl-delete bg-history font-a"  data-bs-toggle="modal" data-bs-target="#view_history_{{$item->application_list->id}}">
                                                    History
                                                    </a>
                                                  
                                                </td>
                                            </tr>

    @isset($item->assessor_type)
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
               Secretariat to the application from the below list
            </h5>
            <button type="button" class="close"
               data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
        
         <div class="modal-body mod-css">
                    <div class="">
                    <form action="{{ url('/super-admin-assign-secretariat') }}"
               method="post">
               @csrf
                <?php

                    $application_assessor_arr = listofapplicationAssignTosecretariat($item->application_list->id);
                ?>
               <br>
              
            
   
               <div class="destop-id">
               @foreach ($secretariatdata as $k => $secretariatData)
               <?php
                    $assessor_designation_first = getAssessorDesignation($item->application_list->id,$secretariatData->id);
                ?>
               <input type="hidden" name="application_id" value="{{ $item->application_list->id ?? '' }}">
                  <br>
                
                  <div class="row">
                    <div class="col-md-5">
                    <label>
                    
                    <input type="radio"
                    id="secretariatid"
                    class="assesorsid opacity-1"
                    name="secretariat_id"
                    application-id="{{$item->application_list->id}}"
                    value="{{$secretariatData->id}}"
                    @if (in_array($secretariatData->id, $application_assessor_arr)) checked @endif 
                   
                    />

                    <input type="hidden" value="" name="secretariat_designation_{{ $item->application_list->id}}" id="secretariat_designation_{{ $item->application_list->id}}">
                    <input type="hidden" value="" name="secretariat_category_{{ $item->application_list->id}}" id="secretariat_category_{{ $item->application_list->id}}">
                    
                    <span>
                    {{ ucfirst($secretariatData->firstname) }}
                      {{ ucfirst($secretariatData->lastname) }}
                      ({{ $secretariatData->email }})
                    </span>
                    </label>
                    </div>
                  </div>
              @endforeach  
               </div>
     <?php
        $assigend_secret = checkSecretariatAssigned($item->application_list->id);
        
     ?>
    @if($item->application_list->approve_status==0 && !$assigend_secret)
     <div class="modal-footer"  id="onsite_date_selection_footer">
         <button type="button" onclick="cancelAssign()"
            class="btn btn-secondary"
            data-bs-dismiss="modal">Close</button>
         <button type="submit"
            class="btn btn-primary my-button" onclick="handleAdminAssignAssessorValidation()" id="secret_{{$item->application_list->id}}" disabled="true">Submit</button>
         </div>
      </div>
    @endif
      </form>
  
        
    
</div>
<!-- modal end here -->

@endisset



           

      
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




        @foreach($list as $item)
<!-- Modal reject -->
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
                                <th>User Name</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @isset($item->appHistory)
                        @foreach($item->appHistory as $key=>$hist)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$hist->firstname??''}} {{$hist->middlename??''}} {{$hist->lastname??''}}</td>
                            <td>{{ \Carbon\Carbon::parse($hist->created_at)->format('d-m-Y')}}</td>
                            <td><span class="badge badge-main {{$hist->status_color}}">{{$hist->status_text}}</span></td>
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

@endforeach
<!-- end here  -->
<script>
 class TabsGroup extends HTMLElement {
    constructor() {
      super();
      this.tabs = this.querySelectorAll('[role="tab"]');
      this.panels = this.querySelectorAll('[role="tabpanel"]');
    }

    get selected() {
      return this.querySelector('[role="tab"][aria-selected="true"]');
    }

    set selected(element) {
      this.selected?.setAttribute('aria-selected', 'false');
      element?.setAttribute('aria-selected', 'true');
      element?.focus();
      this.updateSelected();
    }

    connectedCallback() {
      this.setIds();
      this.updateSelected();
      this.initEvents();
    }

    setIds() {
      this.tabs.forEach((tab, index) => {
        const panel = this.panels[index];

        tab.id ||= `tab-${index}`;
        panel.id ||= `panel-${index}`;

        tab.setAttribute('aria-controls', panel.id);
        panel.setAttribute('aria-labelledby', tab.id);
      });
    }

    updateSelected() {
      this.tabs.forEach((tab, index) => {
        const panel = this.panels[index];
        const isSelected = tab.getAttribute('aria-selected') === 'true';

        tab.setAttribute('aria-selected', isSelected ? 'true' : 'false');
        tab.setAttribute('tabindex', isSelected ? '0' : '-1');
        panel.setAttribute('tabindex', isSelected ? '0' : '-1');
        panel.hidden = !isSelected;
      });
    }

    initEvents() {
      this.tabs.forEach((tab) => {
        tab.addEventListener('click', () => this.selected = tab);

        tab.addEventListener('keydown', (event) => {
          if (event.key === 'ArrowLeft') {
            this.selected = tab.previousElementSibling ?? this.tabs.at(-1);
          } else if (event.key === 'ArrowRight') {
            this.selected = tab.nextElementSibling ?? this.tabs.at(0);
          }
        });
      });
    }
  }

  customElements.define('tabs-group', TabsGroup);
</script>
   
    </section>
   
    @include('layout.footer')
