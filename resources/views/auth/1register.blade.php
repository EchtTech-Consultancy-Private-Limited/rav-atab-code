<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Accreditation User Registration</title>

        <link rel="stylesheet" href="{{ asset('ragistration/css/style.css') }}">

        <!-- font awesome -->
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        </head>
    <body>

        <div class="form-container">
            <div class="logo_container">
                <div class="logo">
                    <img src="{{asset('ragistration/img/ATAB.png')}}" alt="ATAB" title="ATAB">
                </div>
                <h1 class="brand_title">AYURVEDA TRAINING ACCEREDITATION BOARD</h1>
            </div>
            <form  action="{{ url('/register') }}"  method="post" class="form" id="regForm" >
                @csrf
                <span class="title">Accreditation User Registration</span>

                 <span>
                   @if(session()->has('fail'))
                        {{ session()->get('fail') }}
                    @endif
                 </span>

                <div class="form-item">

                    <div class="iconInput_container">
                        <label  class="label_input"> organization*</label>
                        <div class="iconInput email">
                            <i class="fa fa-university" aria-hidden="true"></i>
                            <input type="text" placeholder="organization/Insitute Name" id="organization" name="organization" value="{{ old('organization') }}" onkeydown="validation()">
                        </div>


                        <label for="organization"  id="organization-error" class="error">
                            @error('organization')
                            {{ $message }}
                            @enderror
                        </label>

                    </div>

                    <div class="iconInput_container">
                        <label  class="label_input"> Title*</label>
                    <div class="iconInput email">
                        <select name="title" id="title" class="select">
                            <option value="">Select Title</option>
                            <option value="Mr"  {{ old('title') == "Mr" ? "selected" : "" }}>Mr.</option>
                            <option value="Mrs" {{ old('title') == "Mrs" ? "selected" : "" }}>Mrs.</option>
                            <option value="Miss" {{ old('title') == "Miss" ? "selected" : "" }}>Miss</option>
                            <option value="Ms" {{ old('title') == "Ms" ? "selected" : "" }}>Ms.</option>
                        </select>
                    </div>

                    <label for="title"  id="title-error" class="error">
                        @error('title')
                        {{ $message }}
                        @enderror</label>
                    </div>



                    <div class="iconInput_container">
                        <label  class="label_input"> First Name*</label>
                    <div class="iconInput email">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <input type="text" placeholder="First Name" name="firstname"  name="firstname" value="{{ old('firstname') }}"  id="firstname">
                    </div>
                    {{-- <p class="error">This field is required</p> --}}
                    <label for="firstname"  id="firstname-error" class="error">
                    @error('firstname')
                    {{ $message }}
                    @enderror</label>
                </div>


                <div class="iconInput_container">
                    <label  class="label_input" > Middle Name</label>
                    <div class="iconInput email">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <input type="text" placeholder="Middle Name" name="middlename" value="{{ old('middlename') }}"  id="middlename">
                    </div>
                    {{-- <p class="error">This field is required</p> --}}
                    <label for="middlename"  id="middlename-error" class="error">
                    @error('middlename')
                    {{ $message }}
                    @enderror</label>
                </div>


                <div class="iconInput_container">
                    <label  class="label_input" > Last Name*</label>
                    <div class="iconInput email">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <input type="text" placeholder="Last Name" name="lastname" value="{{ old('lastname') }}" id="lastname">
                    </div>
                    {{-- <p class="error">This field is required</p> --}}
                    <label for="lastname"  id="lastname-error" class="error">
                    @error('lastname')
                    {{ $message }}
                    @enderror</label>
                </div>

                    <div class="iconInput_container">
                        <label  class="label_input"> designation*</label>
                    <div class="iconInput email">

                        <select name="designation" id="designation" class="select" >

                            <option value="Select" {{ old('designation') == "Select" ? "selected" : "" }}>Select  designation</option>
                            <option value="Owner" {{ old('designation') == "Owner" ? "selected" : "" }}>Owner</option>
                            <option value="Coordinator" {{ old('designation') == "Coordinator" ? "selected" : "" }}>Coordinator</option>
                        </select>
                    </div>
                    {{-- <p class="error">This field is required</p> --}}
                    <label for="designation"  id="designation-error" class="error">
                    @error('designation')
                    {{ $message }}
                    @enderror</label>
                </div>

                    <div class="iconInput_container">
                        <label for="gender" class="label_input"> <span>Gender*:</span> </label>
                    <div class="iconInput">

                        <div class="name">
                            <label for="male" class="sex label">
                                <input type="radio" id="male" name="gender"  @if(old('gender')) checked @endif
                                    value="Male" class="radio">
                                <span>Male</span>
                            </label>
                            <label for="Female" class="sex label">
                                <input type="radio" id="Female" name="gender"
                                    value="Female" class="radio">
                                <span>Female</span>
                            </label>
                            <label for="Other" class="sex label">
                                <input type="radio" id="Other" name="gender"
                                    value="Female" class="radio">
                                <span>Other</span>
                            </label>
                        </div>
                    </div>
                    <label for="gender"  id="gender-error" class="error">
                    @error('gender')
                    {{ $message }}
                    @enderror</label>
                </div>

                    <div class="iconInput email">

                    </div>

                    <div class="iconInput_container">
                        <label for="email" class="label_input"> Email id*</label>
                    <div class="iconInput email">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <input type="email" placeholder="Enter Email id" name="email" id="email" name="email" value="{{ old('email') }}">
                    </div>
                    <label for="email"  id="email-error" class="error">
                    @error('email')
                    {{ $message }}
                    @enderror</label>
                </div>


                <div class="iconInput_container">
                    <label   class="label_input"> Enter OTP*</label>
                <div class="iconInput email">
                    <input type="number" name="email_otp" id="email_otp" value="{{ old('email_otp') }}" placeholder="Email OTP">
                    <button type="button" class="btn_verify" onclick="sendemailotp()">
                        OTP
                    </button>
                </div>
                <label for="email_otp"  id="email_otp-error" class="error">

                    @if(session()->has('fail'))
                        {{ session()->get('fail') }}
                    @endif

                 </label>
                </div>


                    <div class="iconInput_container">
                        <label  class="label_input"> Mobile No*.</label>
                    <div class="iconInput email">
                        <i class="fa fa-mobile" aria-hidden="true"></i>
                        <input type="text" placeholder="Enter mobile Number." value="{{ old('mobile_no') }}"  id="mobile_no" name="mobile_no" minlength="2" maxlength="10"  >
                    </div>
                    <label for="mobile_no"  id="mobile_no-error" class="error">
                        @error('mobile_no')
                        {{ $message }}
                        @enderror
                    </label>
                </div>





                    <div class="iconInput_container">
                        <label for="email" class="label_input"> Mobile OTP</label>
                    <div class="iconInput email">
                        <input type="number" name="mobile_otp" value="{{ old('mobile_otp') }}"  placeholder="Mob OTP" >

                        {{-- onclick="sendemailotp()" --}}

                        <button type="button" class="btn_verify" >
                            OTP
                        </button>
                    </div>
                          @error('email_otp')
                            <p class="error">{{ $message }}</p>
                            @enderror
                    </div>


                    <div class="iconInput_container">
                        <label  class="label_input"> Password*</label>
                    <div class="iconInput email">
                        <i class="fa fa-lock" aria-hidden="true"></i>

                        <input type="password" value="{{ old('password') }}" placeholder="Password" id="password"  name="password" >
                        <i class="fa fa-eye " aria-hidden="true" id="togglepassword" ></i>

                    </div>
                    {{-- <p class="error">This field is required</p> --}}
                    <label for="password"  id="password-error" class="error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </label>
                </div>


                    <div class="iconInput_container">
                        <label class="label_input"> Confirm Password*</label>
                    <div class="iconInput email">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <input type="password" placeholder="Confirm Password"  name="cpassword" value="{{ old('cpassword') }}" for="cpassword" id="cpassword">
                        <i class="fa fa-eye " aria-hidden="true" id="togglecpassword"></i>
                    </div>
                    {{-- <p class="error">This field is required</p> --}}
                    <label for="cpassword"  id="cpassword-error" class="error">
                        @error('cpassword')
                        {{ $message }}
                        @enderror
                    </label>
                </div>

                <div class="iconInput_container">
                    <label  class="label_input"> Country</label>
                <div class="iconInput email">

                    <select name="Country" id="Country" class="select Country">

                        <option value="" SELECTED>Select Country</option>

                        @foreach ($data as $item)

                        <option value="{{ $item->id }}" {{ old('Country') == $item->id ? "SELECTED" : "" }}>{{ $item->name }}</option>

                        @endforeach

                    </select>

                </div>
                {{-- <p class="error">This field is required</p> --}}
                <label for="Country"  id="Country-error" class="error">
                    @error('Country')
                    {{ $message }}
                    @enderror
                </label>

                </div>
                <div class="iconInput_container">
                    <label  class="label_input"> State*</label>
                <div class="iconInput email">

                    <select name="state" id="state" class="select">
                        <option value="">Select State</option>
                    </select>
                </div>
                {{-- <p class="error">This field is required</p> --}}
                <label for="state"  id="state-error" class="error">
                    @error('state')
                    {{ $message }}
                    @enderror
                </label>
                </div>
                <div class="iconInput_container">
                    <label  class="label_input"> City</label>
                <div class="iconInput email">

                    <select name="city" id="city" class="select">
                        <option value="">Select City*</option>
                    </select>
                </div>
                <label for="city"  id="city-error" class="error">
                    @error('city')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </label>
                </div>

                <div class="iconInput_container">
                    <label  class="label_input"> Address*</label>
                <div class="iconInput email">
                    <input type="text" placeholder="Address" name="address" value="{{ old('address') }}" id="address" >

                </div>
                {{-- <p class="error">This field is required</p> --}}
                <label  for="address" id="address-error" class="error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </label>
                </div>

                <input type="hidden"  value="1"  name="status">



                <input type="hidden"  value="2"  name="role">



{{-- {{ request()->path() }} --}}


            @if(request()->path() == 'login/admin/register')
              <input type="hidden" placeholder="role" name="role" value="{{ 1 }}">
            @elseif(request()->path() == 'login/TP/register')
               <input type="hidden" placeholder="role" name="role" value="{{ 2 }}">
            @elseif(request()->path() == 'login/Accessor/register')
                <input type="hidden" placeholder="role" name="role" value="{{ 3 }}">
            @elseif(request()->path() == 'login/professional/register')
               <input type="hidden" placeholder="role" name="role" value="{{ 4 }}">
            @endif



                <div class="iconInput_container">
                    <label  class="label_input"> Enter Captcha*:</label>
                    <div class="captcha">
                        <div class="captcha-item">
                            <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                        </div>


                    </div>
                    <label  for="captcha" id="captcha-error" class="error">
                        @error('captcha')
                        {{ $message }}
                        @enderror
                    </label>
                </div>

                    <div class="iconInput_container">
                        <label for="Orgnisation" class="label_input"> Captcha code:</label>
                    <div class="iconInput email">
                        <div class="captcha-item code">
                            <div class="security captcha">
                                 <span>{!! captcha_img() !!}</span>
                                 <button class="btn_refresh btn-refresh"><i class="fa
                                    fa-refresh" aria-hidden="true"></i>
                                 </button>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    <ul>


                    <li class="iconInput email">

                    </li>
                    <li class="iconInput email">
                        <label  class="check">
                            <input type="checkbox" id="check" name="check">
                            <span>I agree with terms and conditions ℹ</span>
                        </label>
                    </li>
                    <label  for="check" id="check-error" class="error">
                        @error('check')
                        {{ $message }}
                        @enderror
                    </label>


                    <li class="btn_submit">
                        <input type="submit" value="Submit" class="submit">
                    </li>
                </ul>

                <div class="address">
                    <ul>
                        <li>{{ now()}}</li>
                        <li>2023 &copy; RAV Accreditation
                        </li>
                        <li> Powered by Netprophets Cyberworks Pvt. Ltd.
                        </li>
                    </ul>
                </div>
            </form>
        </div>


        <script>
            let password = document.querySelector('#password');
            let togglePassword = document.querySelector('#togglepassword');

            togglePassword.addEventListener('click', (e)=>{
                const type = password.getAttribute('type') === 'password' ? 'text' :'password';
                password.setAttribute('type', type);
                this.classlist.toggle('fa fa-eye');
            });


            let cpassword = document.querySelector('#cpassword');
            let togglecpassword = document.querySelector('#togglecpassword');

            togglecpassword.addEventListener('click', (e)=>{
                const type = cpassword.getAttribute('type') === 'cpassword' ? 'text' :'cpassword';

                cpassword.setAttribute('type', type);

                this.classlist.toggle('fa fa-eye');
            })

        </script>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {
        $("#regForm").validate({
            rules: {
                check:{
                    required: true,
                },
                captcha:{
                    required: true,
                },
                organization: {
                    required: true,
                    maxlength: 20,
                },
                title: {
                    required: true,
                    maxlength: 20,
                },
                firstname: {
                    required: true,
                    maxlength: 20,
                },
                lastname:{
                    required: true,
                    maxlength: 20,
                },
                designation:{
                    required: true,
                    maxlength: 20,
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 50
                },
                mobile_no: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                cpassword: {
                    required: true,
                    equalTo: "#password"
                },
                gender: {
                    required: true,
                },
                Country: {
                    required: true,
                },
                address: {
                    required: true,
                    maxlength: 50
                },
                city: {
                    required: true,
                    maxlength: 40
                },
                state: {
                    required: true,
                    maxlength: 40
                },
                email_otp:{
                    required: true,
                },

            },
            messages: {

                check:{
                    required: "Terms and conditions is required",
                },
                captcha:{
                    required: "captcha is required",
                    reCaptchaMethod: true
                },
                organization:{
                    required: "Orgnisation is required",
                },
                firstname: {
                    required: "First name is required",
                    maxlength: "First name cannot be more than 20 characters"
                },
                lastname: {
                    required: "lastname is required",
                    maxlength: "lastname cannot be more than 20 characters"
                },
                email: {
                    required: "Email is required",
                    email: "Email must be a valid email address",
                    maxlength: "Email cannot be more than 50 characters",
                },
                mobile_no: {
                    required: "Phone number is required",
                    minlength: "Phone number must be of 10 digits"
                },
                password: {
                    required: "Password is required",
                    minlength: "Password must be at least 5 characters"
                },
                cpassword: {
                    required:  "Confirm password is required",
                    equalTo: "Password and confirm password should same"
                },
                gender: {
                    required:  "Please select the gender",
                },

                address: {
                    required: "Address is required",

                },
                city: {
                    required: "City is required",

                },
                state: {
                    required: "State is required",

                },
                email_otp:{
                    required: "Email verification is Must",
                }

            }
        });
    });
</script>

<script>
    function sendotp(){

        var frmdata = {
            'phone':$("#mobile_no").val()
    }

            $('#btn_sendotp').hide();
            $('#target').html('sending..');

        $.ajax({
            url: '{{url("/sendOtp")}}',
            type: 'post',
            dataType: 'json',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (data) {
                $('#target').html(data.message);
                $('#btn_sendotp').show();
            },
            data: JSON.stringify(frmdata)
        });
    }



    function sendemailotp(){


//check email fied

      var email =  $("#email").val()

        if(email != "")
        {


            var frmdata = {
            'email':$("#email").val()
        }

        $('#btn_sendemailotp').hide();
        // $('#targetemail').html('sending..');

        $.ajax({
            url: '{{url("/sendEmailOtp")}}',
            type: 'post',
            dataType: 'json',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (data) {

                //  console.log(data);
                     if(data.status == 200)
                        {
                        Swal.fire(
                            'OTP Sent Successfully!',
                            'Please check your email box for OTP and verify here!',
                            'success'
                             )

                        }
                        else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: ' 409 Email id is already exist',
                            })
                        }
                    },
                    error:function(error)
                    {


                $('#targetemail').html(data.message);
                $('#btn_sendemailotp').show();
            },
            data: JSON.stringify(frmdata)
        });

        }
        else{
            $("#email").focus();
        }

    }

</script>

{{-- state dropdown --}}

<script>

    $(document).ready(function(){
    $("#Country").on('change',function(){

    //  alert('hello');

        $.ajaxSetup({
            headers:
            {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var myVar=$("#Country").val();

            $.ajax({
            url: "{{url('/state-list')}}",
            type: "get",
            data:{"myData":myVar},
            success: function(resdata){

                var formoption = "<option value=''>Please select</option>";
                for(i=0; i<resdata.length; i++)
                {
                formoption += "<option value='"+resdata[i].id+"' >"+resdata[i].name+"</option>";
                }
                $('#state').html(formoption);

              }

        });



  });
});


    </script>


{{-- city dropdown --}}

<script>

    $(document).ready(function(){
    $("#state").on('change',function(){

    //   alert('hello');

        $.ajaxSetup({
            headers:
            {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var myVars=$("#state").val();


       //  alert(myVars);

            $.ajax({
            url: "{{url('/city-list')}}",
            type: "get",
            data:{"myData":myVars},
            success: function(resdata){

             //   console.log(resdata);

                var formoption = "<option value=''>Please select</option>";
                for(i=0; i<resdata.length; i++)
                {
                formoption += "<option value='"+resdata[i].id+"'>"+resdata[i].name+"</option>";
                }
                $('#city').html(formoption);

              }

        });

    });
});


    </script>

<script type="text/javascript">

    $(".btn-refresh").click(function(){
      $.ajax({
         type:'GET',
         url:"{{ url('/refresh_captcha') }}",
         success:function(data){
            $(".captcha span").html(data.captcha);
         }
      });
    });


    </script>
<script>
// disable alphate
$('#mobile_no').keypress(function (e) {
    var regex = new RegExp("^[0-9_]");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
});
</script>


</body>
</html>
