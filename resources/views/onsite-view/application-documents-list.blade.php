@include('layout.header')
<title>RAV Accreditation</title>
<style>
   .font-12 {
   size: 12px;
   background: rgb(23, 218, 23);
   padding: 3px;
   border-radius: 5px;
   }
   table th,
   table td {
   text-align: center;
   border: 1px solid #eee;
   }
   .highlight {
   background-color: #9789894a;
   }
   .highlight_nc {
   background-color: #ff000042;
   }
   .highlight_nc_approved {
   background-color: #00800040;
   }
   td select.form-control.text-center {
   border: 0;
   }
   .loading-img {
   z-index: 99999999;
   position: fixed;
   top: 0;
   left: 0;
   bottom: 0;
   right: 0;
   width: 100%;
   height: 100%;
   background: rgba(0, 0, 0, 0.5);
   ;
   overflow: hidden;
   text-align: center;
   }
   .loading-img .box {
   position: absolute;
   top: 50%;
   left: 50%;
   margin: auto;
   transform: translate(-50%, -50%);
   z-index: 2;
   }
   .uploading-text {
   padding-top: 10px;
   color: #fff;
   /* font-size: 18px; */
   }
   td.text-justify {
   text-align: left;
   }
   .table th,
   .table td {
   padding: 4px !important;
   /* Adjust this value to your preference */
   }
   .table th {
   font-size: 13px !important;
   font-weight: bold;
   }
   .width-50{
   width:50%;
   }
   .card .header{padding:8px;}
   .card .header h2{font-size:14px;}
   .docBtn {
   padding: 6px 10px !important;
   color: #fff;
   border-radius: 4px !important;
   margin-right: 5px !important;
   height: 30px;
   line-height: 18px !important;
   }
</style>
</head>
<body class="light">
   <!-- Page Loader -->
   {{-- 
   <div class="page-loader-wrapper">
      <div class="loader">
         <div class="m-t-30">
            <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
         </div>
         <p>Please wait...</p>
      </div>
   </div>
   --}}
   <!-- #END# Page Loader -->
   <!-- Progressbar Modal Poup -->
   <div class="loading-img d-none" id="loader">
      <div class="box">
         <img src="{{ asset('assets/img/VAyR.gif') }}">
         <h5 class="uploading-text"> Uploading... </h5>
      </div>
   </div>
   <div class="full_screen_loading">Loading&#8230;</div>

   <!-- Overlay For Sidebars -->
   <div class="overlay"></div>
   <!-- #END# Overlay For Sidebars -->
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
                     <a href="{{ url("/onsite/application-view/".dEncrypt($application_id)) }}" type="button" class="btn btn-primary "
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
                     <b class="fw-bold">Application ID:</b> <span>{{$application_uhid}}</span>
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
                                             <th class="center">Desktop Assessor
                                             </th>
                                             <th class="center">Onsite Assessor
                                             </th>
                                             <th>Action</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       
                                       @foreach ($desktopData as $chapter_key=>$chapter)
                                          <tr>
                                             <th colspan="4">
                                                <div class="header">
                                                   <h2 class="text-center">
                                                      {{$chapter->chapters->title}}
                                                   </h2>
                                                </div>
                                             </th>
                                          </tr>
                                         
                                          @foreach ($chapter->questions as $key=>$question)
                                        
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

                                    @if($doc->status==0)
                                       <a 
                                        title="{{$doc->doc_file_name}}"
                                        href="{{ url('desktop-view/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                        class="btn btn-primary btn-sm docBtn m-1">
                                        View</a>
                                        @elseif($doc->status==1)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('desktop-accept/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-success btn-sm docBtn m-1">
                                             Accepted</a>
                                    @elseif($doc->status==2)
                                    <a 
                                        title="{{$doc->doc_file_name}}"
                                        href="{{ url('desktop-nc1/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                        class="btn btn-danger btn-sm docBtn m-1">
                                        NC1</a>
                                        @elseif($doc->status==3)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('desktop-nc2/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn m-1">
                                             NC2</a>
                                        @elseif($doc->status==4)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('desktop-nr/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn m-1">
                                              Not Recommended</a>

                                              <!-- admin accept/reject -->
                                              @if($doc->admin_nc_flag==1)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('desktop-accept/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-success btn-sm docBtn docBtn_nc m-1">
                                             Accepted <span>By Admin</span></a>
                                             @endif

                                             @if($doc->admin_nc_flag==2)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('desktop-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Rejected <span>By Admin</span></a>
                                             @endif
                                             <!-- end here -->
                                             
                                             @elseif($doc->status==6)
                                          <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('desktop-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn m-1">
                                             Rejected</a>
                                    @else
                                       <div class="upload-btn-wrapper">
                                                <button class="upld-btn"><i class="fas fa-cloud-upload-alt"></i></button>
                                                <input type="file" class="from-control fileup" name="fileup" id="fileup_{{$question['question']->id}}" data-question-id="{{$question['question']->id}}" />
                                             </div>
                                    @endif 
                                    @endforeach

                                 <!--this else for first time upload doc  -->
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

                                             <!-- Onsite Document NC's -->
                                             <td>
                                             <div class="d-flex">
                                                  
                                                  <div>
                                        
                                   
                                @if(in_array($question['question']->id,$onsite_course_doc_uploaded->pluck('doc_unique_id')->all())) 

                                   @foreach($onsite_course_doc_uploaded->filter(function ($item) use ($question) {
                                       return $item['doc_unique_id'] == $question['question']->id;
                                   }) as $doc)
                                   
                                   
                                   
                                   @if($doc->is_doc_show==0 && $doc->onsite_status==0)
                                   @php
                                     $doc_=$doc->onsite_doc_file_name==null?$doc->doc_file_name:$doc->onsite_doc_file_name;
                                   @endphp
                                      <a 
                                       title="{{$doc->onsite_doc_file_name}}"
                                       href="{{ url('onsite-view/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc_ . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                       class="btn btn-primary btn-sm docBtn m-1">
                                       View</a>
                                    @elseif($doc->onsite_status==1)
                                         <a 
                                            title="{{$doc->onsite_doc_file_name}}"
                                            href="{{ url('onsite-accept/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name. '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                            class="btn btn-success btn-sm docBtn m-1">
                                            Accepted</a>
                                          @elseif($doc->onsite_status==2)
                                          <a 
                                                title="{{$doc->onsite_doc_file_name}}"
                                                href="{{ url('onsite-nc1/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                                class="btn btn-danger btn-sm docBtn m-1">
                                                NC1</a>
                                        @elseif($doc->onsite_status==3)
                                         <a 
                                            title="{{$doc->onsite_doc_file_name}}"
                                            href="{{ url('onsite-nc2/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                            class="btn btn-danger btn-sm docBtn m-1">
                                            NC2</a>
                                       @elseif($doc->onsite_status==4)
                                         <a 
                                            title="{{$doc->onsite_doc_file_name}}"
                                            href="{{ url('onsite-nr/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                            class="btn btn-danger btn-sm docBtn m-1">
                                             Not Recommended</a>

                                              <!-- admin accept/reject -->
                                              @if($doc->admin_nc_flag==1)
                                             <a 
                                             title="{{$doc->onsite_doc_file_name}}"
                                             href="{{ url('onsite-accept/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name. '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-success btn-sm docBtn docBtn_nc m-1">
                                             Accepted <span>By Admin</span></a>
                                             @endif

                                             @if($doc->admin_nc_flag==2)
                                             <a
                                             title="{{$doc->onsite_doc_file_name}}"
                                             href="{{ url('onsite-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Rejected <span>By Admin</span></a>
                                             @endif
                                             <!-- end here -->

                                    @elseif($doc->onsite_status==5)
                                             @if($doc->admin_nc_flag==1)
                                             
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('onsite-accept/verify-doc'. '/'. $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-success btn-sm docBtn docBtn_nc  m-1">
                                             Accepted</a>
                                             @endif

                                             @if($doc->admin_nc_flag==2)
                                             <a 
                                             title="{{$doc->doc_file_name}}"
                                             href="{{ url('onsite-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                             class="btn btn-danger btn-sm docBtn docBtn_nc m-1">
                                             Rejected</a>
                                             @endif
                                             
                                            
                                       @elseif($doc->onsite_status==6)
                                             <a 
                                            title="{{$doc->onsite_doc_file_name}}"
                                            href="{{ url('onsite-reject/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc->onsite_doc_file_name . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}"
                                            class="btn btn-danger btn-sm docBtn m-1">
                                            Need Revision</a>
                                            
                                                
                                   @endif 

                      
                                   @endforeach
                                   
                                   @if($question['onsite_photograph']!=null)
                                            <div>
                                                  <div class="upload-btn-wrapper">
                                                     <button class="upld-btn upload-btn-fn-size" data-bs-toggle="modal" data-bs-target="#view_photograph_modal" data-bs-whatever="@mdo" onclick="handlePdfOrImageForPhotograph('{{$question['onsite_photograph']->onsite_photograph}}')"><i class="fas fa-eye"></i> View Photograph</button>
                                            </div>
                                               </div>
                                            </div>
                                                @else
                                                <!-- upload photograph -->
                                                <div>
                                                  <input type="hidden" id="doc_sr_code_{{$question['question']->id}}" value="{{$question['question']->code}}">
                                                  
                                                  <input type="hidden" id="application_id" value="{{$application_id}}">
                                                  <input type="hidden" id="doc_unique_id_{{$question['question']->id}}" value="{{$question['question']->id}}">
                                                  <input type="hidden" id="application_courses_id" value="{{$course_id}}">
                                                @if($assessor_designation->assessor_designation=="Lead Assessor")      
                                                  <div class="upload-btn-wrapper">
                                                     <button class="upld-btn upload-btn-fn-size"><i class="fas fa-cloud-upload-alt"></i> Upload Photograph</button>

                                                  <input type="file" class="from-control fileup_photograph" name="fileup_photograph" id="fileup_photograph_{{$question['question']->id}}" data-question-id="{{$question['question']->id}}" onchange="onsitePhotographUpload({{$question['question']->id}})"/>
                                            </div>
                                            @endif

                                               </div>
                                            </div>
                                            @endif
                                            <!-- end here -->

                                   @else
                                      <!-- When doc not in courses doc tbl -->
                                       
                                      <div style="padding: 8px;">
                                             <div class="d-flex justify-content-center"></div>
                                             <div class="d-flex justify-content-center">
                                                @php
                                                   $doc_paths=$doc->onsite_doc_file_name!=null?$doc->onsite_doc_file_name:"test11.pdf";
                                                @endphp
                                                
                                                  @if($assessor_designation->assessor_designation=="Lead Assessor")   
                                                <div>
                                                   <a  href="{{ url('onsite-view/verify-doc' . '/' . $doc->doc_sr_code .'/' . $doc_paths . '/' . $application_id . '/' . $doc->doc_unique_id.'/'.$course_id) }}" class="btn btn-primary btn-sm">Upload Document</a>&nbsp;
                                                </div>
                                                @else
                                                <span>Please assign lead assessor</span>
                                                @endif
                                                <!-- upload photograph -->
                                                <div>
                                                  <input type="hidden" id="doc_sr_code_{{$question['question']->id}}" value="{{$question['question']->code}}">
                                                  
                                                  <input type="hidden" id="application_id" value="{{$application_id}}">
                                                  <input type="hidden" id="doc_unique_id_{{$question['question']->id}}" value="{{$question['question']->id}}">
                                                  <input type="hidden" id="application_courses_id" value="{{$course_id}}">
                                                  @if($assessor_designation->assessor_designation=="Lead Assessor") 
                                                  <div class="upload-btn-wrapper">
                                                     <button class="upld-btn upload-btn-fn-size bg-color-btn"><i class="fas fa-cloud-upload-alt"></i> Upload Photograph</button>

                                                  <input type="file" disabled="true" class="from-control fileup_photograph" name="fileup_photograph" id="fileup_photograph_{{$question['question']->id}}" data-question-id="{{$question['question']->id}}" onchange="onsitePhotographUpload({{$question['question']->id}})"/>
                                                  @endif
                                            </div>
                                               </div>
                                            </div>
                                                <!-- end here -->
                                      <!-- end here -->
                                   @endif

                          </div>
                          
                          <div>

                          </div>
                       </div>
                                             
                                          </td>
                                             <!-- end here onsite doc nc -->
                                             <td>
                                            @if(count($question['onsite_nc_comments'])>0)
                                                <button
                                                   class="expand-button btn btn-primary btn-sm mt-3"
                                                   onclick="toggleDocumentDetails(this)">Show Comments</button>
                                    @else
                                    
                                                <span class="text-danger"
                                                   style="font-size: 12px; padding:5px; border-radius:5px;">Comment
                                                pending!</span>
                                                @endif
                                                @if($doc->onsite_status!=0  && $doc->is_revert!=1 )
                                                <button type="button" class="btn btn-primary btn-sm mt-3" onclick="handleRevertActionOnDocListOnsite('{{ $application_id }}', '{{ $course_id }}', '{{ $doc->onsite_doc_file_name }}')">Revert</button>

                                                @endif

                                             </td>
                                          </tr>
                                          <tr class="document-details" style="display: none">
                                             <td colspan="5">
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

                                                 
                                                   @isset($question['onsite_nc_comments'])
                                                      @foreach($question['onsite_nc_comments'] as $k=>$nc_comment)
                                                     
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
                                                         <td>{{$nc_comment->firstname}} {{$nc_comment->middlename}} {{$nc_comment->lastname}}</td>
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
                           
                              @if($is_all_doc_accepted && !$is_final_submit)
                                 <form id="submitForm" action="{{url('onsite/final-summary')}}" method="post">
                                     @csrf
                                       <input type="hidden" name="application_id" value="{{$encrypted_app_id}}">
                                       <input type="hidden" name="application_course_id" value="{{$encrypted_course_id}}">
                                       <div class="col-md-12 p-2" id="comment-section">
                                                                    <label for="comment_text" class="">Remark<span class="text-danger">*</span></label>
                                                                    <textarea rows="30" cols="80" id="comment_text" name="doc_comment" class="form-control" required=""></textarea>
                                                                    <small id="char-count-info">0/250 characters</small>
                                                                </div>
                                    
                                       <div class="col-md-12 p-2 d-flex justify-content-end">
                                       <input type="submit" value="Submit Summary" class="btn btn-primary btn-sm">
                                    </div>
                                 </form>

                              @elseif(count($onsite_course_doc_uploaded)>=4 && $is_any_ncs && !$is_final_submit)
                              <div class="col-md-12 mr-2">
                                          <form action="{{ url('onsite/update-nc-flag-doc-list/course/'.$encrypted_app_id.'/'.$encrypted_course_id) }}" method="post">
                                          @csrf
                                          <div class="col-md-12 p-2" id="comment-section">
                                                                    <label for="comment_text" class="">Remark<span class="text-danger">*</span></label>
                                                                    <input type="hidden" name="nc_type" value="{{$nc_type_str}}"/>
                                                                    <textarea rows="30" cols="80" id="comment_text" name="doc_comment" class="form-control" required=""></textarea>
                                                                    <small id="char-count-info">0/250 characters</small>
                                                                </div>
                                    
                                          <input type="submit" class="btn btn-info float-right" value="Submit " <?php echo $enable_disable_submit_btn_course==true?'disabled':'';?> >
                                          </form>
                                          </div>
                                 </div>
                           @endif


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

<!-- Modal -->
<div class="modal fade" id="view_photograph_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Photograph</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         
         <div id="view_photograph_onsite">
            <object data="http://127.0.0.1:8000/level/170418181317035556641703203498Get_Started_With_Smallpdf.pdf" type="application/pdf" width="100%" height="700px"></object>                   
         </div>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->


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
   <script>
      $(document).ready(function() {
          $('.fileup').change(function() {
              var fileInput = $(this);
              var questionId = fileInput.data('question-id');
              var form = $('#submitform_doc_form_' + questionId)[0];
              var formData = new FormData(form);
              var allowedExtensions = ['pdf', 'doc', 'docx']; // Add more extensions if needed
              var uploadedFileName = fileInput.val();
              var fileExtension = uploadedFileName.split('.').pop().toLowerCase();
              if (allowedExtensions.indexOf(fileExtension) == -1) {
                  Swal.fire({
                      position: 'center',
                      icon: 'error',
                      title: 'Invalid File Type',
                      text: 'Please upload a PDF or DOC file.',
                      showConfirmButton: true
                  });
                  // Clear the file input
                  fileInput.val('');
                  return;
              }
              $("#loader").removeClass('d-none');
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
             
              $.ajax({
                  url: "/tp-add-document", // Your server-side upload endpoint
                  type: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(response) {
                      $("#loader").addClass('d-none');
                      if (response.success) {
                        toastr.success(response.message, {
                            timeOut: 0,
                            extendedTimeOut: 0,
                            closeButton: true,
                            closeDuration: 5000,
                        });
                          location.reload();
                      }
                  },
                  error: function(xhr, status, error) {
                      // Handle errors
                      console.error(error);
                  }
              });
          });
      });
   </script>
   @include('layout.footer')