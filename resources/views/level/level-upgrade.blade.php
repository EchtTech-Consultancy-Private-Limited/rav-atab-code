@include('layout.header')

<style>

@media (min-width: 900px){
.modal-dialog {
    max-width: 674px;
}
}

</style>


<title>RAV Accreditation</title>

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
                                <h4 class="page-title">Level Upgrade </h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Level Upgrade </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row ">
            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">


                    @if(Session::has('success'))
                    <div class="alert alert-success" style="padding: 15px;" role="alert">
                        {{session::get('success')}}
                    </div>
                    @elseif(Session::has('fail'))
                    <div class="alert alert-danger" role="alert">
                        {{session::get('fail')}}
                    </div>
                    @endif

                    <div class="tab-content">


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
                                               <label >{{ $data->title ??'' }}</label>
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
                                         <label><strong>Orgnisation/Insitute Name</strong></label><br>
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
                                            <label><strong>Desigantion</strong></label><br>
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

                                              <input type="hidden" id="Country" value="{{$data->country ??''}}" >

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
                                        <label><strong>Pastal Code</strong></label><br>
                                        <label>{{ $data->postal  ??''}}</label>
                                       </div>
                                    </div>
                                 </div>
                               </div>



                                <div class="row clearfix">
                                  <div class="col-sm-4">
                                     <div class="form-group">
                                        <div class="form-line">
                                            <label><strong>Address</strong></label><br>
                                            <label>{{ $data->address ??'' }}</label>
                                        </div>
                                     </div>
                                  </div>
                               </div>

                                <!-- basic end -->
                              </div>
                              </div>




                    <div class="card">
                            <div class="header">
                                <h2 style="float:left; clear:none;">


                                    Upgrade Level Courses


                                </h2>
                                <h6 style="float:right; clear:none; cursor:pointer;" onclick="add_new_course();" id="count"  >Add More Course</h2>
                            </div>

                        <form  action="{{ url('/new-application-course') }}"  method="post" class="form" id="regForm">
                            @csrf

                                 @foreach ($Course as $item)

                                    <div class="body" id="courses_body">
                                      <!-- level start -->

                                         <div class="row clearfix">



                                         <input type="hidden" name="id" value="{{ $item->id }}">


                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Course Name<span class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Course Name"  name="course_name[]" value="{{ $item->course_name }}"   required >
                                                    </div>
                                                    @error('course_name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Course Duration(In Days)<span class="text-danger">*</span></label>
                                                        <input type="number" placeholder="Course Duration" name="course_duration[]" value="{{ $item->course_duration }}"  required >
                                                    </div>
                                                    @error('course_duration')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="col-sm-2">
                                               <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Eligibility<span class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Eligibility" name="eligibility[]" value="{{ $item->eligibility }}"  required >
                                                    </div>
                                                    @error('eligibility')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Mode of Course <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="mode_of_course[]"  required >
                                                            <option value="" SELECTED>Select Mode</option>
                                                            <option value="Online"  {{  $item->mode_of_course == "Online" ? "selected" : "" }}    >Online</option>
                                                            <option value="Offline" {{  $item->mode_of_course == "Offline" ? "selected" : "" }}>Offline</option>
                                                        </select>
                                                    </div>

                                                    @error('mode_of_course')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                        <div class="form-line">
                                                            <label>Course Brief <span class="text-danger">*</span></label>
                                                            <input type="text" placeholder="Course Brief" name="course_brief[]" value="{{ $item->course_name }}"  required >
                                                        </div>

                                                        @error('course_brief')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            @if(request()->path() == 'application-upgrade-second')
                                            <input type="hidden" placeholder="level_id" name="level_id" value="{{ 2 }}">
                                            @elseif(request()->path() == 'application-upgrade-third')
                                            <input type="hidden" placeholder="level_id" name="level_id" value="{{ 3 }}">
                                            @elseif(request()->path() == 'application-upgrade-fourth')
                                            <input type="hidden" placeholder="level_id" name="level_id" value="{{ 4 }}">
                                            @endif


                                               <!-- level end -->

                                    </div>

                                    @endforeach

                                    <div class="center">
                                        <button class="btn btn-primary waves-effect m-r-15">Save</button> <button type="button" class="btn btn-danger waves-effect">Back</button>
                                    </div>

                                  </form>
                                </div>




                            <div class="card">
                                <div class="header">
                                    <h2 style="float:left; clear:none;">Payment</h2>
                                    <h6 style="float:right; clear:none;" id="counter">

                                    @if(isset($total_amount ))

                                    Total Amount: {{ $currency ??'' }}.{{ $total_amount  ??''}}

                                    @endif



                                    </h2>
                                </div>
                                <div class="body">
                                        <div class="form-group">
                                           <div class="form-line">
                                              <label >Payment Mode<span class="text-danger">*</span></label>
                                                 <select name="payment" class="form-control" id="payments">
                                                   <option value=""  >Select Option</option>
                                                   <option value="QR-Code"  {{ old('QR-Code') == "QR-Code" ? "selected" : "" }}>QR Code</option>
                                                   <option value="Bank" {{ old('title') == "Bank" ? "selected" : "" }}>Bank Transfers</option>
                                                  </select>
                                           </div>


                                        </div>



                                    <!-- payment start -->

                                    <div  style="text-align:center; width:100%;" id="QR">
                                        <div style="width:100px; height:100px; border:1px solid #ccc; float:right;"><img src="{{asset('/assets/images/demo-qrcode.png')}}" width="100" height="100"></div>
                                    </div>
                                        <div class="row clearfix"  id="bank_id">
                                            <div class="col-sm-2">
                                              <div class="form-group">
                                                <div class="form-line">
                                                    <label><strong>Bank Name</strong></label>
                                                    <p>Punjab National Bank</p>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                  <div class="form-line">
                                                      <label>  <strong>Acccounts Number</strong> </label>
                                                      <p>112233234400987</p>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-sm-2">
                                                <div class="form-group">
                                                  <div class="form-line">
                                                      <label> <strong>IFSC Code</strong> </label>
                                                      <p>PUNB00987</p>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-sm-2">
                                                <div class="form-group">
                                                  <div class="form-line">
                                                      <label> <strong>Branch Name</strong> </label>
                                                      <p>Main Market, Punjabi Bagh, New Delhi</p>
                                                  </div>
                                                </div>
                                              </div>
                                        </div>



                            <form  action="{{ url('/new-application_payment') }}"  method="post" class="form" id="regForm" enctype="multipart/form-data" >
                                @csrf

                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>Payment Date <span class="text-danger">*</span></label>
                                            <input type="date" name="payment_date" class="form-control" id="payment_date" placeholder="Payment Date "aria-label="Date" required value="{{ old('payment_date') }}"  onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>

                                        @error('payment_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror


                                    </div>
                                </div>


                                <input type='hidden' name="amount" value="{{  $total_amount ??'' }}">

                                {{-- <input type='hidden' name="course_count" value="{{  count($course) }}"> --}}

                                <input type='hidden' name="currency" value="{{  $currency  ??''}}">


                                @if(request()->path() == 'application-upgrade-second')
                                <input type="hidden" placeholder="level_id" name="level_id" value="{{ 2 }}">
                                @elseif(request()->path() == 'application-upgrade-third')
                                <input type="hidden" placeholder="level_id" name="level_id" value="{{ 3 }}">
                                @elseif(request()->path() == 'application-upgrade-fourth')
                                <input type="hidden" placeholder="level_id" name="level_id" value="{{ 4 }}">
                                @endif



                                    <div class="col-sm-3">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label>Payment Transaction no. <span class="text-danger">*</span></label>
                                        <input type="number" placeholder="Payment Transaction no." id="payment_transaction_no" name="payment_transaction_no"  required  value="{{ old('payment_transaction_no') }}">
                                      </div>

                                      @error('payment_transaction_no')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label>Payment Reference no. <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Payment Transaction no." name="payment_reference_no" value="{{ old('payment_reference_no') }}">
                                      </div>

                                      @error('payment_reference_no')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                   <div class="form-group">
                                      <div class="form-line">
                                        <label>Payment Screenshot <span class="text-danger">*</span></label>
                                        <input type="file" name="payment_details_file" id="payment_details_file" required   class="form-control"  >
                                      </div>

                                      @error('payment_details_file')
                                      <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>

                             </div>


                                    <!-- payment end -->
                                </div>
                            </div>
                            <div class="center">
                                <button class="btn btn-primary waves-effect m-r-15">Save</button> <button type="button" class="btn btn-danger waves-effect">Back</button>
                            </div>
                            <br>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


                                 <div id="add_courses" style="Display:none">

                                   <div class="row clearfix">

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Name<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Course Name" name="course_name[]"  required >
                                            </div>

                                            @error('course_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror


                                        </div>
                                        </div>

                                        <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Duration<span class="text-danger">*</span></label>
                                                <input type="number" placeholder="Course Duration" name="course_duration[]"  required >
                                            </div>

                                            @error('course_duration')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        </div>
                                        <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Eligibility<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Eligibility" name="eligibility[]"  required >
                                            </div>

                                            @error('eligibility')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror


                                        </div>
                                        </div>

                                        <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Mode of Course <span class="text-danger">*</span></label>
                                                <select class="form-control" name="mode_of_course[]" required >
                                                    <option value="" SELECTED>Select Mode</option>
                                                    <option value="Online">Online</option>
                                                    <option value="Offline">Offline</option>
                                                </select>
                                            </div>

                                            @error('mode_of_course')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                        </div>






                                        <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Course Brief <span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Course Brief" name="course_brief[]"  required >
                                            </div>

                                            @error('course_brief')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

    </div>



<script>
function add_new_course(){

    $("#courses_body").append($("#add_courses").html());

}
</script>

{{-- button click count --}}
<script>
$(document).ready(function() {
  var count = 0;

 $(window).on('load',function(){
   $data =  $('#Country').val();
   // alert($data);

 });


  $("#count").click(function()
    {
        count++;
   //  alert(count)
     if(count <= 4)
     {

        if($data == '101')
        {
            rupess=1000;
         //   alert(rupess)
            $("#counter").html("Total Amount:₹."+rupess);
             $("#counters").html("value="+rupess);


        }else if($data == '167' || $data == '208'|| $data == '19' || $data == '1' || $data == '133')
        {

            rupess=15;
          //alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);


        }else{

            rupess=50;
            // alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);
        }

     }else if(count <= 9)
     {
        if($data == '101')
        {
            rupess=2000;
         //   alert(rupess)
            $("#counter").html("Total Amount:₹."+rupess);

        }else if($data == '167' || $data == '208'|| $data == '19' || $data == '1' || $data == '133')
        {

            rupess=30;
          //  alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);


        }else{

            rupess=100;
         //   alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);
        }
     }else{
        if($data == '101')
        {
            rupess=3000;
          //  alert(rupess)
            $("#counter").html("Total Amount:₹."+rupess);

        }else if($data == '167' || $data == '208'|| $data == '19' || $data == '1' || $data == '133')
        {

            rupess=45;
           // alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);


        }else{

            rupess=150;
          //  alert(rupess)
            $("#counter").html("Total Amount:US $."+rupess);
        }
     }
    }
   );
  });
</script>


<script>
    $(document).ready(function(){



    $( window ).on( "load", function() {
        $("#bank_id").hide();
        $("#QR").hide();
    } );




    $("#payments").on('change',function(){
        $type=$('#payments').val();
        //alert($type);

        if($type == 'QR-Code')
        {
           // alert('hii')
            $("#bank_id").hide();
            $("#QR").show();

        }else if($type == "")
        {
   //  alert('hii1')
           $("#bank_id").hide();
            $("#QR").hide();

        }
        else{

          //  alert('hii1')
            $("#bank_id").show();
            $("#QR").hide();

        }
      });
    });
</script>

@include('layout.footer')
