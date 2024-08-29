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
                     <div class="table-responsive">
                        <table class="table px-0 py-3 text-left" style="width:100%;" id="dataTableMain">
                           <thead>
                              <tr>
                                 <th class="text-left">Sr.No</th>
                                 <th class="text-left">Level </th>
                                 <th class="text-left">Application No. </th>
                                 <th class="text-left">Courses No.</th>
                                 <th class="text-left">Total Fee</th>
                                 <th class="text-left"> Payment Date </th>
                                 <th class="text-left">Status</th>
                                 <th class="text-left">Valid From</th>
                                 <th class="text-left">Valid To</th>
                                 <th class="text-left">Action</th>
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
                                    {{ \Carbon\Carbon::parse($item->payment->payment_date ?? '')->format('d-m-Y') }}
                                 </td>
                                 <td>
                                    @php
                                    $status = getApplicationStatus($item->application_list->status,"Secretariat");
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
                                    @php
                                    $view_url="";
                                    if($item->application_list->level_id==1){
                                    $view_url="/admin/application-view";
                                    }elseif($item->application_list->level_id==2){
                                    $view_url="/admin/application-view-level-2";
                                    }else{
                                    $view_url="/admin/application-view-level-3";
                                    }
                                    @endphp

                                 @if(isset($item->applicationDuration->applicationAction) && $item->applicationDuration->applicationAction =='Y')

                                    <a href="{{ url($view_url, dEncrypt($item->application_list->id)) }}"
                                       class="btn btn-tbl-edit"><i
                                       class="material-icons">visibility</i></a>
                                    @isset($item->payment)
                                    @if($item->payment->aknowledgement_id!==null && $item->doc_uploaded_count>=($item->approved_course * 4) && $item->payment->approve_remark!=null && $item->payment->last_payment->status==2 && $item->application_list->level_id==3)
                                    @php
                                    if($item->assessor_type=="desktop"){
                                    $type_ =  "View_popup_";
                                    }else{
                                    $type_ =  "View_popup_onsite_";
                                    }
                                    $is_all_course_accepted=checkAllCoursesDocAccepted($item->application_list->id);
                                    $is_all_revert = checkAllActionDoneOnRevert($item->application_list->id);
                                    @endphp
                                    
                                    @if($is_all_course_accepted==false  && $item->application_list->level_id==3 && ($item->application_list->approve_status!=3 && $item->application_list->approve_status!=4))
                                    <a class="btn btn-tbl-delete bg-primary font-a"
                                       data-bs-toggle="modal" data-id="{{ $item->application_list->id }}"
                                       data-bs-target="#{{$type_}}{{ $item->application_list->id }}"
                                       id="view_{{ $item->application_list->id }}">
                                    <i class="fa fa-font" aria-hidden="true" title=""></i>
                                    </a>
                                    @else
                                    <!-- <span class="badge badge-main warning ">Action not completed on courses doc</span> -->
                                    @endif
                                    @if($item->application_list->level_id==2)
                                    <a class="btn btn-tbl-delete bg-primary font-a"
                                       data-bs-toggle="modal" data-id="{{ $item->application_list->id }}"
                                       data-bs-target="#{{$type_}}{{ $item->application_list->id }}"
                                       id="view_{{ $item->application_list->id }}">
                                    <i class="fa fa-font" aria-hidden="true" title=""></i>
                                    </a>
                                    @endif
                                    @endif
                                    @endisset  
                                    @isset($item->payment)
                                    
                                    @if($item->payment->aknowledgement_id==null && $item->payment->accountant_id &&  $item->payment->approve_remark!=null)
                                    <button id="acknowledgement_{{$item->application_list->id}}"
                                       class="btn btn-primary btn-sm mb-0 p-2" style="margin-left: 5px !important;" title="Acknowledge Payment"><i class="fa fa-credit-card" aria-hidden="true" onclick="handleAcknowledgementPayment({{$item->application_list->id}})"></i></button>
                                    @endif
                                    @endisset   
                                    <a class="btn btn-tbl-delete bg-history font-a"  data-bs-toggle="modal" data-bs-target="#view_history_{{$item->application_list->id}}">
                                    History
                                    </a>
                                    @else
                                    <a class="btn btn-tbl-edit w-100 border-bottom border badge badge-main danger">  
                                             Contact to admin           
                                          </a>
                                    @endif


                                 </td>
                              </tr>

                              @isset($item->assessor_type)
                              <!-- Modal box assessor assign-->
                              <div class="modal fade" id="View_popup_{{ $item->application_list->id }}"
                                 tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle1" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered modal-lg"
                                    role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalCenterTitle1">
                                             Assign desktop
                                             Assessor to the application from the below list
                                          </h5>
                                          <button type="button" class="close"
                                             data-bs-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body mod-css">
                                          <tabs-group>
                                             <div role="tablist" class="tabs__controls">
                                                <button role="tab" aria-selected="true">ATAB Assessor</button>
                                                <button role="tab">ACB</button>                 
                                             </div>
                                             <div role="tabpanel" class="tabs__panel">
                                                <div class="">
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
                                                         <?php
                                                            $assessor_designation_first = getAssessorDesignation($item->application_list->id,$assesorsData->id);
                                                            ?>
                                                         <input type="hidden" name="application_id" value="{{ $item->application_list->id ?? '' }}">
                                                         <br>
                                                         <div class="row">
                                                            <div class="col-md-5">
                                                               <label>
                                                               <input type="radio"
                                                               id="assesorsid"
                                                               class="assesorsid opacity-1"
                                                               name="assessor_id"
                                                               application-id="{{$item->application_list->id}}"
                                                               value="{{$assesorsData->id}}"
                                                               @if (in_array($assesorsData->id, $application_assessor_arr)) checked @endif 
                                                               />
                                                               <input type="hidden" value="" name="assessor_designation_{{ $item->application_list->id}}" id="assessor_designation_{{ $item->application_list->id}}">
                                                               <input type="hidden" value="{{$item->assessor_type}}"  id="assessor_types_{{ $item->application_list->id}}">
                                                               <input type="hidden" value="" name="assessor_category_{{ $item->application_list->id}}" id="assessor_category_{{ $item->application_list->id}}">
                                                               <span>
                                                               {{ ucfirst($assesorsData->firstname) }}
                                                               {{ ucfirst($assesorsData->lastname) }}
                                                               ({{ $assesorsData->email }})
                                                               </span>
                                                               </label>
                                                            </div>
                                                            @if($item->assessor_type=="onsite")
                                                            <div class="col-md-3">
                                                               <select name="assessor_type_{{ $item->application_list->id}}" id="assessor_type_{{ $assesorsData->id}}" class="d-block assessor_name_with_email" onchange="handleAssessorDesignation('assessor_type_{{ $item->application_list->id}}','{{ $item->application_list->id}}')">
                                                                  <option value="" disabled selected>Please select option</option>
                                                                  <option value="Lead Assessor" @if($assessor_designation_first?->assessor_designation=='Lead Assessor') selected @endif>Lead Assessor</option>
                                                                  <option value="Co-Assessor" @if($assessor_designation_first?->assessor_designation=='Co-Assessor') selected @endif>Co-Assessor</option>
                                                                  <option value="Observer Assessor" @if($assessor_designation_first?->assessor_designation=='Observer Assessor') selected @endif>Observer Assessor</option>
                                                                  <option value="Observer Assessor" @if($assessor_designation_first?->assessor_designation=='Ayurveda Expert') selected @endif>Ayurveda Expert</option>
                                                               </select>
                                                            </div>
                                                            @endif
                                                         </div>
                                                         <div id="assessor_assign_dates_{{$assesorsData->id}}">
                                                            <?php
                                                               foreach(get_accessor_date_new($assesorsData->id,$item->application_list->id,$assesorsData->assessment) as $date){
                                                               ?>
                                                            {!! $date !!}
                                                            <?php }   ?>
                                                         </div>
                                                         @endforeach  
                                                      </div>
                                                      <div class="modal-footer">
                                                         <button type="button" onclick="cancelAssign()"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                         <button type="submit"
                                                            class="btn btn-primary my-button" onclick="handleAdminAssignAssessorValidation()">Submit</button>
                                                      </div>
                                                </div>
                                             </div>
                                             </form>
                                             <div role="tabpanel" class="tabs__panel">
                                                <div class="">
                                                   Test
                                                </div>
                                             </div>
                                          </tabs-group>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- modal end here -->
                              <!-- onsite assessor assign model -->
                              <!-- Modal box assessor assign-->
                              <div class="modal fade" id="View_popup_onsite_{{ $item->application_list->id }}"
                                 tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle2" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-centered modal-lg"
                                    role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalCenterTitle2">
                                             Assign Onsite
                                             Assessor to the application from the below list
                                          </h5>
                                          <button type="button" class="close"
                                             data-bs-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body mod-css">
                                          <tabs-group>
                                             <div role="tablist" class="tabs__controls">
                                                <button role="tab" aria-selected="true">ATAB Assessor</button>
                                                <button role="tab">ACB</button>                 
                                             </div>
                                             <div role="tabpanel" class="tabs__panel">
                                                <div class="">
                                                   <form action="{{ url('/admin-assign-assessor-onsite') }}"
                                                      method="post">
                                                      @csrf
                                                      <!-- <input type="hidden" name="assessor_id_" id="assessor_id_" value=""> -->
                                                      <input type="hidden" name="assessor_type" value="onsite">
                                                      <?php
                                                         $application_assessor_arr = listofapplicationassessor($item->application_list->id);
                                                            
                                                         
                                                         ?>
                                                      <br>
                                                      <label class="mb-3"><b>Assessment
                                                      Type</b></label><br>
                                                      <p>Onsite Assessment</p>
                                                      <!--   -->
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
                                                      <div class="destop-id">
                                                         @foreach ($item->assessor_list as $k => $assesorsData)
                                                         <?php
                                                            $assessor_designation_first = getAssessorDesignation($item->application_list->id,$assesorsData->id);
                                                            
                                                            ?>
                                                         <input type="hidden" name="application_id" value="{{ $item->application_list->id ?? '' }}">
                                                         <br>
                                                         <div class="row">
                                                            <div class="col-md-5">
                                                               <label>
                                                               <input type="checkbox"
                                                               id="assesorsid"
                                                               class="assesorsid opacity-1"
                                                               name="assessor_id[]"
                                                               application-id="{{$item->application_list->id}}"
                                                               value="{{$assesorsData->id}}"
                                                               @if (in_array($assesorsData->id, $application_assessor_arr)) checked="true" @endif 
                                                               />
                                                               <input type="hidden" value="" name="assessor_designation_{{ $item->application_list->id}}[]" id="assessor_designation_{{ $item->application_list->id}}">
                                                               <input type="hidden" value="{{$item->assessor_type}}"  id="assessor_types_{{ $item->application_list->id}}">
                                                               <input type="hidden" value="" name="assessor_category_{{ $item->application_list->id}}[]" id="assessor_category_{{ $item->application_list->id}}">
                                                               <span>
                                                               {{ ucfirst($assesorsData->firstname) }}
                                                               {{ ucfirst($assesorsData->lastname) }}
                                                               ({{ $assesorsData->email }})
                                                               </span>
                                                               </label>
                                                            </div>
                                                            <div class="col-md-3">
                                                               <select name="assessor_type_{{ $item->application_list->id}}[]" id="assessor_type_{{ $assesorsData->id}}" class="d-block assessor_name_with_email" onchange="handleAssessorDesignation('assessor_type_{{ $item->application_list->id}}','{{ $item->application_list->id}}')">
                                                                  <option value="" disabled selected>Please select option</option>
                                                                  <option value="Lead Assessor" @if($assessor_designation_first?->assessor_designation=='Lead Assessor') selected @endif>Lead Assessor</option>
                                                                  <option value="Co-Assessor" @if($assessor_designation_first?->assessor_designation=='Co-Assessor') selected @endif>Co-Assessor</option>
                                                                  <option value="Observer Assessor" @if($assessor_designation_first?->assessor_designation=='Observer Assessor') selected @endif>Observer Assessor</option>
                                                                  <option value="Observer Assessor" @if($assessor_designation_first?->assessor_designation=='Ayurveda Expert') selected @endif>Ayurveda Expert</option>
                                                               </select>
                                                            </div>
                                                         </div>
                                                         <div id="assessor_assign_dates_{{$assesorsData->id}}">
                                                            <?php
                                                               foreach(get_accessor_date_new($assesorsData->id,$item->application_list->id,$assesorsData->assessment) as $date){
                                                               ?>
                                                            {!! $date !!}
                                                            <?php }   ?>
                                                         </div>
                                                         @endforeach  
                                                      </div>
                                                      <div class="modal-footer">
                                                         <button type="button" onclick="cancelAssign()"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                         <button type="submit"
                                                            class="btn btn-primary my-button" onclick="handleAdminAssignAssessorValidation()">Submit</button>
                                                      </div>
                                                </div>
                                             </div>
                                             </form>
                                             <div role="tabpanel" class="tabs__panel">
                                                <div class="">
                                                   Test
                                                </div>
                                             </div>
                                          </tabs-group>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- modal end here -->
                              <!-- end here -->
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
                                 <td>{{$hist->created_at}}</td>
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
          
          $(document).ready(function(){
            const _application_id =localStorage.getItem('application_id');
                if(_application_id){
                    // document.getElementById('view_'+_application_id).click();
                }
          })
          
      </script>
   </section>
   @include('layout.footer')