@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Register'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                         User Register
                        </h5>
                       </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <form class="javavoid(0)"id="form_user">
                @csrf
                <div class="card-body">

                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">First name<span class="text-danger">*</span></label>
                                        <input type="text" name="firstname"  class="form-control" placeholder="First Name" aria-label="Name" value="{{ old('firstname') }}" ><span id="firstname_error" class="text-danger" style="font-size:10px;"></span>@error('firstname') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Middle name</label>
                                        <input type="text" name="middlename" class="form-control" placeholder="Middle Name" aria-label="Name" value="{{ old('middlename') }}" >
                                        @error('middlename') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Last name</label>
                                        <input type="text" name="lastname" class="form-control" placeholder="Last Name" aria-label="Name" value="{{ old('lastname') }}" >
                                        @error('lastname') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Phone</label>
                                        <input type="text" name="phone_no" class="form-control" placeholder="Phone No." aria-label="Phone" value="{{ old('phone_no') }}" >
                                    @error('phone_no') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email<span class="text-danger">*</span></label><span style="font-size: 10px;"> (All communication from RAV Accredatitation will sent on this email id)</span>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-label="Email" value="{{ old('email') }}" >
                                    <span id="email_error" class="text-danger"  style="font-size:10px;"></span>@error('email') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Mobile No.<span class="text-danger">*</span></label>
                                        <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Mobile No." aria-label="Mobile No." value="{{ old('mobile_no') }}" >
                                    <span id="mobile_no_error" class="text-danger"  style="font-size:10px;"></span>@error('mobile_no') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                </div>
                                <div class="row">
<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Address<span class="text-danger">*</span></label>
                                        <textarea cols="45" rows="5" name="address"  class="form-control" value="{{ old('address') }}" aria-label="Address" placeholder="Street Address">
                                        </textarea>
                                       @error('address') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Country<span class="text-danger">*</span></label>
                                        <select id="country" name="country" class="form-control">
                                        <option value="">Please select</option>
                                        </select>
                                        @error('country') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div> 
                                    
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">State<span class="text-danger">*</span></label>
                                        <input type="text" name="state" class="form-control" placeholder="State" aria-label="Country" value="{{ old('State') }}" >
                                        @error('State') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                <button type="button" class="btn btn-warning waves-effect waves-light rounded-pill" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-plus"></i></button>
                                </div>

                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">City<span class="text-danger">*</span></label>
                                        <input type="text" name="city" class="form-control" placeholder="City" aria-label="City" value="{{ old('city') }}" >
                                        @error('city') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Postal code<span id="postal" class="text-danger">*</span></label>
                                        <input type="text" name="postal" id="postal" class="form-control" placeholder="Postal Code" aria-label="Postal Code" value="{{ old('postal') }}" >
                                        @error('postal') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>
                                </div>
                                <style>
                                    a.text-info:hover, a.text-info:focus {
                                            color: #117a8b !important;
                                        }
                                </style>
                                <div class="row">
                                <div class="col-md-6">
                                                    <div class="form-group">
                    <label for="passwordinput">
                        Password
                    <span class="text-danger">*</span></label>
                    <input id="password" class="form-control input-md"
                        name="password" type="password" 
                        placeholder="Enter your password">
                        <span class="text-danger" id="password_error"></span>
                        <span class="show-pass" onclick="toggle()">
                        </span>
                        <div id="popover-password">
                            <p><span id="result"></span></p>
                            <div class="progress">
                                <div id="password-strength" 
                                    class="progress-bar" 
                                    role="progressbar" 
                                    aria-valuenow="40" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100" 
                                    style="width:0%">
                                </div>
                            </div>
                            <ul class="list-unstyled">
                                <li class="">
                                    <span class="low-case">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Lowercase 
                                    </span>
                                </li>
                                <li class="">
                                    <span class="upper-case">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Uppercase
                                    </span>
                                </li>
                                <li class="">
                                    <span class="one-number">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Number (0-9)
                                    </span> 
                                </li>
                                <li class="">
                                    <span class="eight-character">
                                        <i class="fas fa-circle" aria-hidden="true"></i>
                                        &nbsp;Atleast 8 Character
                                    </span>
                                </li>
                            </ul>
                        </div>
                        </div>
                        </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Confirm Password<span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" id="confirm_password" class="form-control" placeholder="Confirm Password" aria-label="Confirm Password"><span id="password" class="text-danger"></span>
                                        @error('confirm password') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                    </div>
                                </div>

                                <div class="text-center col-md-2">
                                    <button type="submit" id="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Save</button>
                                </div>
                                <div class="text-center col-md-2">
                                    <button type="reset" class="btn bg-gradient-dark w-100 my-4 mb-2">Reset</button>
                                </div>
                              </div>
                              <div id="addUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5>Add state</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_state">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
            <label>Country<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="country" value="{{old('Country')}}">
    <select class="form-control" type="text" name="country" id="country">
        <option hidden>Please select</option>
        @foreach($country as $item)
    </select>


    </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
    <label class="form-label my-0">State<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="state" value="{{old('State')}}">
    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="form_state" class="btn btn-primary">Save</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
                            </div>
</form>
</div>
            </div>  
        </div>
        @include('layouts.footers.auth.footer')
    </div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<script>
    $(document).ready(function(){

                        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
$("#form_user").submit(function(e)
        {   
            e.preventDefault();
            var Values = $("#form_user").serialize();
  
            $.ajax({
                type: 'post',
                url: "{{url('/user-register')}}",
                data: Values,
                dataType: 'json',
                error: function (response) {
            $('#firstname_error').html(response.responseJSON.errors.firstname);
                $('#email_error').html(response.responseJSON.errors.email);
                $('#mobile_no_error').html(response.responseJSON.errors.mobile_no);
                $('#password_error').html(response.responseJSON.errors.password);
},
               success: function (response) {
                console.log(response);
                }
                
                });
        });
let statepassword = false;
let password = document.getElementById("password");
let passwordStrength = document.getElementById("password-strength");
let lowCase = document.querySelector(".low-case i");
let wUpperCase = document.querySelector(".upper-case i");
let number = document.querySelector(".one-number i");
let eightChar = document.querySelector(".eight-character i");


password.addEventListener("keyup", function(){
    let pass = document.getElementById("password").value;
    checkStrength(pass);
});

function toggle(){
    if(statepassword){
        document.getElementById("password").setAttribute("type","password");
        statepassword = false;
    }else{
        document.getElementById("password").setAttribute("type","text")
        statepassword = true;
    }

}

function myFunction(show){
    show.classList.toggle("fa-eye-slash");
}

function checkStrength(password) {
    let strength = 0;

    //If password contains both lower and uppercase characters
    if (password.match(/([a-z])/)) {
        strength += 1;
        lowCase.classList.remove('fa-circle');
        lowCase.classList.add('fa-check');
    } else {
        lowCase.classList.add('fa-circle');
        lowCase.classList.remove('fa-check');
    }
    if (password.match(/([A-Z])/)) {
        strength += 1;
        wUpperCase.classList.remove('fa-circle');
        wUpperCase.classList.add('fa-check');
    } else {
        wUpperCase.classList.add('fa-circle');
        wUpperCase.classList.remove('fa-check');
    }
    //If it has numbers and characters
    if (password.match(/([0-9])/)) {
        strength += 1;
        number.classList.remove('fa-circle');
        number.classList.add('fa-check');
    } else {
        number.classList.add('fa-circle');
        number.classList.remove('fa-check');
    }

    //If password is greater than 7
    if (password.length > 7) {
        strength += 1;
        eightChar.classList.remove('fa-circle');
        eightChar.classList.add('fa-check');
    } else {
        eightChar.classList.add('fa-circle');
        eightChar.classList.remove('fa-check');   
    }

    // If value is less than 2
    if (strength < 2) {
        passwordStrength.classList.remove('progress-bar-warning');
        passwordStrength.classList.remove('progress-bar-success');
        passwordStrength.classList.add('progress-bar-danger');
        passwordStrength.style.width = '10%';
        passwordStrength.style.background = "yellow";

    } else if (strength == 3) {
        passwordStrength.classList.remove('progress-bar-success');
        passwordStrength.classList.remove('progress-bar-danger');
        passwordStrength.classList.add('progress-bar-warning');
        passwordStrength.style = 'width: 60%';
        passwordStrength.style.background = "yellow";
    }
     else if (strength == 4) {
        passwordStrength.classList.remove('progress-bar-warning');
        passwordStrength.classList.remove('progress-bar-danger');
        passwordStrength.classList.add('progress-bar-success');
        passwordStrength.style = 'width: 100%';
        passwordStrength.style.background = "yellow";
    }
}
    });
</script>
@endsection
