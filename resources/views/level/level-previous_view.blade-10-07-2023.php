@include('layout.header')


<title>RAV Accreditation || Previous Applications View</title>

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
                                <h4 class="page-title">Previous Application Details</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> level</a>
                            </li>
                            <li class="breadcrumb-item active">Previous Application Details </li>
                        </ul>
                    </div>
                </div>
            </div>

        <div class="row ">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h2>Basic Information</h2>
                                </div>
                                <div class="body">

                                  <div class="row clearfix">
                                    <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label ><strong>Title</strong></label><br>
                                               <label >{{ $data->title  }}</label>
                                        </div>
                                     </div>
                                    </div>

                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label><strong>First Name</strong></label><br>
                                            {{ $data->firstname ??'' }}
                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">

                                            <label><strong>Middle Name</strong></label><br>

                                              <label>{{ $data->middlename ??'' }}</label>

                                        </div>
                                     </div>
                                  </div>
                                </div>


                                  <div class="row clearfix">
                                  <div class="col-sm-4">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label><strong>Last Name</strong></label><br>
                                        <label>{{ $data->lastname ??'' }}</label>
                                      </div>
                                   </div>
                                   </div>

                                   <div class="col-sm-4">
                                   <div class="form-group">
                                      <div class="form-line">
                                         <label><strong>Organization/Institute Name</strong></label><br>
                                         <label>{{ $data->organization ??'' }}</label>
                                      </div>
                                   </div>
                                   </div>

                                   <div class="col-sm-4">
                                   <div class="form-group">
                                      <div class="form-line">
                                         <label><strong>Email</strong></label><br>
                                         <label>{{ $data->email ??'' }}</label>
                                        </div>
                                   </div>
                                   </div>
                                  </div>



                             <div class="row clearfix">
                                <div class="col-sm-4">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label><strong>Mobile Number</strong></label><br>
                                        <label>{{ $data->mobile_no  ??''}}</label>
                                      </div>
                                   </div>
                                </div>



                                <div class="col-sm-4">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label><strong>Designation</strong></label><br>
                                        <label>{{ $data->designation ??''}}</label>
                                    </div>
                                   </div>
                                </div>




                                <div class="col-sm-4">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <div class="form-group">
                                            <div class="form-line">
                                             <label><strong>Country</strong></label><br>
                                              <label>{{ $data->country_name ??'' }}</label>
                                            </div>
                                         </div>
                                    </div>
                                   </div>
                                </div>
                             </div>




                                <div class="row clearfix">

                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                            <label><strong>State</strong></label><br>
                                            <label>{{ $data->state_name ??'' }}</label>
                                        </div>
                                     </div>
                                  </div>


                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                            <label><strong>City</strong></label><br>
                                            <label>{{ $data->city_name ??'' }}</label>
                                        </div>
                                     </div>
                                  </div>


                                  <div class="col-sm-4">
                                    <div class="form-group">
                                       <div class="form-line">
                                        <label><strong>Postal Code</strong></label><br>
                                        <label>{{ $data->postal  ??''}}</label>
                                       </div>
                                    </div>
                                 </div>
                               </div>



                                <div class="row clearfix">
                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                            <label><strong>Address </strong></label><br>
                                            <label>{{ $data->address ??'' }}</label>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                                    
                                <div class="header">
                                    <h2>Single Point of Contact Details (SPoC) Details</h2>
                                </div>   
                                 <div class="row clearfix">
                                    <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label ><strong>Person Name</strong></label><br>
                                               <label >{{ $spocData->Person_Name  }}</label>
                                        </div>
                                     </div>
                                    </div>

                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label><strong>Contact Number</strong></label><br>
                                            {{ $spocData->Contact_Number ??'' }}
                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">

                                            <label><strong>Email Id</strong></label><br>

                                              <label>{{ $spocData->Email_ID ??'' }}</label>

                                        </div>
                                     </div>
                                  </div>
                                </div>

                               <div class="row clearfix">
                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">

                                            @if ($data->status == 1)
                                                 <a href="{{ url('/upload-document' . '/' . dEncrypt($data->id)) }}"
                                                     class="btn btn-tbl-edit bg-primary"><i
                                                         class="fa fa-upload"></i></a>
                                             @endif
                                             @if ($data->status == 2)
                                                 <a href="{{ url('/application-upgrade-second') }}"
                                                     class="btn btn-tbl-edit"><i
                                                         class="material-icons">edit</i></a>
                                             @endif
                                        </div>
                                     </div>
                                  </div>
                               </div>
                                <!-- basic end -->
                              </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>



{{-- course detail  --}}

@foreach ($ApplicationCourse as $k=> $ApplicationCourses )

        <div class="row ">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h2>Add Course Information  Record No: {{ $k+1 }}</h2>
                                </div>
                                <div class="body">

                                  <div class="row clearfix">
                                    <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label ><strong>Course Name</strong></label><br>
                                               <label >{{ $ApplicationCourses->course_name  }}</label>
                                        </div>
                                     </div>
                                    </div>

                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label><strong>Course Duration</strong></label><br>
                                            {{ $ApplicationCourses->years ??'' }} Year(s) {{ $ApplicationCourses->months ??'' }} Month(s) {{ $ApplicationCourses->days ??'' }} Day(s)
                                            {{ $ApplicationCourses->hours ??'' }} Hour(s)
                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">

                                            <label><strong>Eligibility</strong></label><br>

                                              <label>{{ $ApplicationCourses->eligibility ??'' }}</label>

                                        </div>
                                     </div>
                                  </div>
                                </div>


                                  <div class="row clearfix">
                                  <div class="col-sm-4">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label><strong>Mode of Course</strong></label><br>
                                        <label>{{ $ApplicationCourses->mode_of_course ??'' }}</label>
                                      </div>
                                   </div>
                                   </div>

                                   <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                           <label><strong></strong>Valid To</label><br>
                                           <label>{{ date('d F Y', strtotime($ApplicationCourses->created_at->addYear())) }}</label>
                                          </div>
                                     </div>
                                   </div>

                                   <div class="col-sm-4">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                           <div class="form-line">

                                          <label><strong> Valid From</strong></label><br>
                                             <label>{{ date('d F Y', strtotime($ApplicationCourses->created_at)) }}</label>
                                           </div>
                                        </div>
                                     </div>
                                  </div>



                             <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-line">

                                       <label><strong>Course Brief</strong></label><br>
                                       <label>{{ $ApplicationCourses->course_brief ??'' }}</label>
                                    </div>
                                 </div>
                               </div>
                            <div class="col-sm-12 text-right">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <a href="{{ url('/upload-document' . '/' .$ApplicationCourses->application_id.'/'.$ApplicationCourses->id) }}"
                                            class="btn text-white bg-primary" style="float:right; color: #fff ; line-height: 25px;">Upload Documents</a>
                                    </div>
                                   </div>
                                   </div>

                             </div>
                                <!-- basic end -->
                              </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
     @endforeach

{{-- payment details  --}}



@foreach ($ApplicationPayment as $ApplicationPayment)


        <div class="row ">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h2>Payment Information</h2>
                                </div>
                                <div class="body">

                                  <div class="row clearfix">
                                    <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label ><strong>Payment Date</strong></label><br>
                                               <label >{{ $ApplicationPayment->payment_date  }}</label>
                                        </div>
                                     </div>
                                    </div>

                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                           <label><strong>Payment Transaction no</strong></label><br>
                                            {{ $ApplicationPayment->payment_details ??'' }}
                                        </div>
                                     </div>
                                  </div>
                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">

                                            <label><strong>Payment Reference no</strong></label><br>

                                              <label>{{ $ApplicationPayment->payment_details ??'' }}</label>

                                        </div>
                                     </div>
                                  </div>
                                </div>


                                  <div class="row clearfix">
                                  <div class="col-sm-4">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label><strong>Course Count</strong></label><br>
                                        <label>{{ $ApplicationPayment->course_count ??'' }}</label>
                                      </div>
                                   </div>
                                   </div>

                                   <div class="col-sm-4">
                                   <div class="form-group">
                                      <div class="form-line">
                                         <label><strong>Amount</strong></label><br>
                                         <label>{{ $ApplicationPayment->currency ??'' }} {{ $ApplicationPayment->amount  }}</label>
                                      </div>
                                   </div>
                                   </div>





                                  </div>
                                <!-- basic end -->
                              </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
@endforeach




        </div>
    </section>

    @include('layout.footer')

