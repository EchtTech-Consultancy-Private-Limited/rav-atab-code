@include('layout.header')
<title>RAV Accreditation</title>

</head>
<body class="light">
@include('layout.topbar')
   <div>
   @if (Auth::user()->role == '1')
        @include('layout.sidebar')
        @elseif(Auth::user()->role == '2')
        @include('layout.siderTp')
        @elseif(Auth::user()->role == '3')
        @include('layout.sideAss')
        @elseif(Auth::user()->role == '4')
        @include('layout.sideprof')
        @elseif(Auth::user()->role == '5')
        @include('layout.secretariat')
        @elseif(Auth::user()->role == '6')
        @include('layout.sidbarAccount')
        @endif
        @include('layout.rightbar')
   </div>
   
   <section class="content">
      <div class="container-fluid">
         <div class="block-header">
            <div class="row p-3">
               <div class="col-sm-6">
                  <ul class="breadcrumb breadcrumb-style ">
                     <li class="breadcrumb-item">
                        <h4 class="page-title">Documents List</h4>
                     </li>
                     <li class="breadcrumb-item bcrumb-1">
                        <a href="{{ url('/dashboard') }}">
                        <i class="fas fa-home"></i> Level </a>
                     </li>
                     <li class="breadcrumb-item active">Document List</li>
                  </ul>
               </div>
               <div class="col-sm-6">
                  <div class="pr-2">
                     <a href="{{ url()->previous() }}" type="button" class="btn btn-primary "
                        style="float:right;">Back</a>
      

                  </div>
               </div>
            </div>
         </div>
         @if (Session::has('sussess'))
         <div class="alert alert-success" role="alert">
            {{ session::get('success') }}
         </div>
         @elseif(Session::has('fail'))
         <div class="alert alert-danger" role="alert">
            {{ session::get('fail') }}
         </div>
         @endif
         <div>
            <div class="row clearfix">
               <div class="col-lg-12 col-md-12">
                  <div>
                     <b class="fw-bold">Application ID:</b> <span>{{$applicationData->uhid??''}}</span>
                  </div>
                  <div>
                     <div>
                        <div class="row clearfix">
                           <div class="col-lg-12 col-md-12 col-sm-12">
                              <div class="card project_widget">
                                 @if ($message = Session::get('success'))
                                 <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                 </div>
                                 @endif
                                 <div id="success-msg" class="alert alert-success d-none" role="alert">
                                    <p class=" msg-none ">Documents Update Successfully</p>
                                 </div>
                                 <!-- table-striped  -->
                                 <div class="table-responsive">
                                    <table class="table table-hover table-responsive">
                                       <thead>
                                          <tr>
                                             <th class="center">Sr.No.</th>
                                             <th class="center width-50">Objective criteria</th>
                                             <!--  <th class="center" style="white-space: nowrap;width:85px;">Yes / No</th> -->
                                             <th class="center">Assessor
                                             </th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       
                                       @foreach ($final_data as $chapter)
                                          <tr>
                                             <th colspan="4">
                                                <div class="header">
                                                   <h2 class="text-center">
                                                      {{$chapter->chapters->title}}
                                                   </h2>
                                                </div>
                                             </th>
                                          </tr>
                                         
                                          @foreach ($chapter->questions as $question)
                                          <tr class="document-row">
                                             <td>{{$question['question']->code??''}}</td>
                                             <td style="text-align: left;">{{$question['question']->title}}
                                             </td>
                                             <td>
                                                <div class="d-flex">
                                                  
                                                   <div>
                                                      <form
                                                         name="submitform_doc_form"
                                                         id="submitform_doc_form_{{$question['question']->id}}"
                                                         class="submitform_doc_form"
                                                         enctype="multipart/form-data">
                                    <input type="hidden" name="previous_url" value="{{ Request::url() }}">
                                    <input type="hidden" name="application_id" value="{{$application_id}}">
                                    <input type="hidden" name="application_courses_id" value="{{$course_id}}">
                                    <input type="hidden" name="doc_sr_code" value="{{$question['question']->code}}">
                                    <input type="hidden" name="doc_unique_id" value="{{$question['question']->id}}">
                                  
                                   
                        @if(in_array($question['question']->id,$course_doc_uploaded->pluck('doc_unique_id')->all())) 
                                    @foreach($course_doc_uploaded->filter(function ($item) use ($question) {
                                        return $item['doc_unique_id'] == $question['question']->id;
                                    }) as $doc)
                                    
                                    
                                    @if($doc->is_doc_show==0 && $doc->status==0)
                                       <a 
                                        title="{{$doc->doc_file_name}}"
                                        href="{{ url('super-admin-view/desktop/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                        class="btn btn-primary btn-sm docBtn m-1">
                                        View</a>
                                        @elseif($doc->status==1)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-accept/desktop/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-success btn-sm docBtn docBtn_nc m-1">
                                             Accept <span>{{ucfirst($doc->assessor_type)}} Assessor</span></a>
                                    @elseif($doc->status==2)
                                    <a 
                                        title="{{$doc->doc_file_name}}"
                                        href="{{ url('super-admin-nc1/desktop/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                        class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                        NC1 <span>{{ucfirst($doc->assessor_type)}} Assessor</span></a>
                                        @elseif($doc->status==3)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-nc2/desktop/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             NC2 <span>{{ucfirst($doc->assessor_type)}} Assessor</span></a>
                                             @elseif($doc->status==6)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-reject/desktop/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Reject <span>{{ucfirst($doc->assessor_type)}} Assessor</span></a>
                                        @elseif($doc->status==4)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-nr/desktop/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Not Recommended <span>{{ucfirst($doc->assessor_type)}} Assessor</span></a>
                                             @if($doc->admin_nc_flag==1)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-accept/admin/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-success btn-sm docBtn docBtn_nc m-1">
                                             Accepted <span>By Admin</span></a>
                                             @endif

                                             @if($doc->admin_nc_flag==2)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-reject/admin/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Rejected <span>By Admin</span></a>
                                             @endif




                                             @elseif($doc->status==5)
                                             @if($doc->admin_nc_flag==1)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-accept/admin/verify-doc'. '/' . $doc->status .'/'. $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-success btn-sm docBtn docBtn_nc  m-1">
                                             Accepted</a>
                                             @endif

                                             @if($doc->admin_nc_flag==2)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-reject/admin/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Rejected</a>
                                             @endif




                                    @else
                                     
                                    @endif 
                                    @endforeach

                                     <!-- Onsite nc's list -->
                                     @if(in_array($question['question']->id,$onsite_course_doc_uploaded->pluck('doc_unique_id')->all())) 
                                    @foreach($onsite_course_doc_uploaded->filter(function ($item) use ($question) {
                                        return $item['doc_unique_id'] == $question['question']->id;
                                    }) as $doc)
                                    
                                    
                                    @if($doc->is_doc_show==0 && $doc->onsite_status==0)
                                       <a 
                                        title="{{$doc->doc_file_name}}"
                                        href="{{ url('super-admin-view/onsite/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                        class="btn btn-primary btn-sm docBtn m-1">
                                        View</a>
                                        @elseif($doc->onsite_status==1)
                                          <a 
                                             title="{{$doc->onsite_doc_file_name}}"
                                             href="{{ url('super-admin-accept/onsite/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-success btn-sm docBtn docBtn_nc m-1">
                                             Accept <span>{{ucfirst($doc->assessor_type)}} Assessor</span></a>
                                    @elseif($doc->onsite_status==2)
                                    <a 
                                        title="{{$doc->onsite_doc_file_name}}"
                                        href="{{ url('super-admin-nc1/onsite/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                        class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                        NC1 <span>{{ucfirst($doc->assessor_type)}} Assessor</span></a>
                                        @elseif($doc->onsite_status==3)
                                          <a 
                                             title="{{$doc->onsite_doc_file_name}}"
                                             href="{{ url('super-admin-nc2/onsite/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             NC2 <span>{{ucfirst($doc->assessor_type)}} Assessor</span></a>
                                             @elseif($doc->onsite_status==6)
                                          <a 
                                             title="{{$doc->onsite_doc_file_name}}"
                                             href="{{ url('super-admin-reject/onsite/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Reject <span>{{ucfirst($doc->assessor_type)}} Assessor</span></a>
                                        @elseif($doc->onsite_status==4)
                                          <a 
                                             title="{{$doc->onsite_doc_file_name}}"
                                             href="{{ url('super-admin-nr/onsite/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Not Recommended <span>{{ucfirst($doc->assessor_type)}} Assessor</span></a>
                                             @if($doc->admin_nc_flag==1)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-accept/admin/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-success btn-sm docBtn docBtn_nc m-1">
                                             Accepted <span>By Admin</span></a>
                                             @endif

                                             @if($doc->admin_nc_flag==2)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-reject/admin/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Rejected <span>By Admin</span></a>
                                             @endif


                                             @elseif($doc->onsite_status==5)
                                             @if($doc->admin_nc_flag==1)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-accept/admin/verify-doc'. '/' .  $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-success btn-sm docBtn docBtn_nc  m-1">
                                             Accepted<span>By Admin</span></a>
                                             @endif

                                             @if($doc->admin_nc_flag==2)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('super-admin-reject/admin/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Rejected<span>By Admin</span></a>
                                             @endif


                                    @else
                                      
                                    @endif 
                                    @endforeach
                                    
                                   @endif

                                    <!-- Onsite nc's list end here -->

                                 <!--this else for first time upload doc  -->
                                      @if($doc->is_doc_show==-1 && $doc->status!=0)
                                       N/A
                                      @endif
                                    @else
                                       N/A
                                    @endif

                                </form>
                                                   </div>
                                                   
                                                   <div>

                                                   </div>
                                                </div>
                                              
                                              
                                                {{-- getting documents for each row end point --}}
                                             </td>
                                             <td>
                                             @if(in_array($question['question']->id,$course_doc_uploaded->pluck('doc_unique_id')->all())) 
                                                @if($doc->is_doc_show==-1 && $doc->status!=0)
                                                <span class="text-danger"
                                                   style="font-size: 12px; padding:5px; border-radius:5px;">Comment
                                                pending!</span>
                                                @else
                                                <button
                                                   class="expand-button btn btn-primary btn-sm mt-3"
                                                   onclick="toggleDocumentDetails(this)">Show Comments</button>
                                                @endif
                                                
                                    @else
                                  
                                                <span class="text-danger"
                                                   style="font-size: 12px; padding:5px; border-radius:5px;">Comment
                                                pending!</span>
                                             </td>
                                     @endif
                                          </tr>
                                          <tr class="document-details" style="display: none">
                                             <td colspan="4">
                                                <table>
                                                   <thead>
                                                      <tr>
                                                         <th>Sr. No.</th>
                                                         <th>Document Code</th>
                                                         <th>Date</th>
                                                         <th>Comments</th>
                                                         <th>Status Code</th>
                                                         <th>Approved/Rejected By</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>

                                                   @isset($question['nc_comments'])
                                                      @foreach($question['nc_comments'] as $k=>$nc_comment)
                                                      <tr class="text-{{$nc_comment->nc_type=='Accept'?'success':'danger'}}" style="border-left:3px solid red">
                                                         <td width="60">{{$k+1}}</td>
                                                         <td width="130">{{$nc_comment->doc_sr_code}}</td>
                                                         <td width="120">{{date('d-m-Y',strtotime($nc_comment->created_at))}}</td>
                                                         <td>{{$nc_comment->comments}}</td>
                                                         <td>
                                                         @php
                                                            $string = $nc_comment->nc_type;
                                                            $explodedArray = explode("_", $string);
                                                            $capitalizedArray = array_map('ucfirst', $explodedArray);
                                                            $resultString = implode(" ", $capitalizedArray);
                                                         @endphp
                                                         {{$resultString}} 
                                                         </td>
                                                         <td>{{$nc_comment->firstname}} {{$nc_comment->middlename}} {{$nc_comment->lastname}} ({{ucfirst($nc_comment->assessor_type)}})</td>
                                                      </tr>
                                                     @endforeach
                                                     @endisset
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          
                                        
                                          @endforeach
                                        @endforeach


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
   <script>
      function toggleDocumentDetails(button) {
          const documentRow = button.closest('.document-row');
          const documentDetails = documentRow.nextElementSibling;
          if (documentDetails && (documentDetails.classList.contains('document-details'))) {
              if (documentDetails.style.display == 'none' || documentDetails.style.display == '') {
                  documentDetails.style.display = 'table-row';
                  button.textContent = 'Hide Comments';
              } else {
                  documentDetails.style.display = 'none';
                  button.textContent = 'Show Comments';
              }
          }
      }
   </script>
   
   @include('layout.footer')

