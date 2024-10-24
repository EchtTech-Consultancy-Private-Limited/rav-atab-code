@include('layout.header')


<title>RAV Accreditation</title>
</head>

<body class="light">
    <!-- Page Loader -->
    {{-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div> --}}
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    @include('layout.topbar')

    <div>


        @include('layout.sidebar')



        @include('layout.rightbar')


    </div>


    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Add User</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">User</a>
                            </li>
                            <li class="breadcrumb-item active">Add User</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Add</strong> User
                            </h2>

                        </div>


                        <form method="post" action="{{ url('/adduser') }}" class="javavoid(0) validation-form123"
                            id="regForm" enctype="multipart/form-data">
                            @csrf
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line mb-3">
                                                <label>Title<span class="text-danger">*</span></label>
                                                <select name="title" class="form-control" id="title">
                                                    <option value="">Select Title </option>
                                                    <option value="Mr" {{ old('title') == 'Mr' ? 'selected' : '' }}>
                                                        Mr.</option>
                                                    <option value="Mrs"
                                                        {{ old('title') == 'Mrs' ? 'selected' : '' }}>Mrs.</option>
                                                    <option value="Miss"
                                                        {{ old('title') == 'Miss' ? 'selected' : '' }}>Miss</option>
                                                    <option value="Ms" {{ old('title') == 'Ms' ? 'selected' : '' }}>
                                                        Ms.</option>
                                                    <option value="Dr" {{ old('title') == 'Dr' ? 'selected' : '' }}>
                                                        Dr.</option>
                                                    <option value="Vd" {{ old('title') == 'Vd' ? 'selected' : '' }}>
                                                        Vd.</option>
                                                </select>
                                            </div>

                                            <label for="title" id="title-error" class="error">
                                                @error('title')
                                                    {{ $message }}
                                                @enderror
                                            </label>

                                        </div>
                                    </div>





                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>First Name<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="First Name" name="firstname"
                                                    id="firstname" value="{{ old('firstname') }}" id="firstname" class="preventnumeric">
                                            </div>

                                            <label for="firstname" id="firstname-error" class="error">
                                                @error('firstname')
                                                    {{ $message }}
                                                @enderror
                                            </label>

                                        </div>
                                    </div>



                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Middle Name</label>
                                                <input type="text" placeholder="Middle Name" id="middlename"
                                                    name="middlename" value="{{ old('middlename') }}" class="preventnumeric">
                                            </div>

                                            <label for="middlename" id="middlename-error" class="error">
                                                @error('middlename')
                                                    {{ $message }}
                                                @enderror
                                            </label>


                                        </div>
                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Last Name<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Last Name" id="lastname"
                                                    name="lastname" value="{{ old('lastname') }}" class="preventnumeric">
                                            </div>


                                            <label for="lastname" id="lastname-error" class="error">
                                                @error('lastname')
                                                    {{ $message }}
                                                @enderror
                                            </label>

                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Organization/Institute Name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" placeholder="Organization/Institute Name"
                                                    name="organization" value="{{ old('organization') }}">
                                            </div>

                                            <label for="organization" id="organization-error" class="error">
                                                @error('organization')
                                                    {{ $message }}
                                                @enderror
                                            </label>

                                        </div>
                                    </div>



                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <input type="email" placeholder="Enter Email id" id="email"
                                                    name="email" value="{{ old('email') }}" id="email"
                                                    onkeydown="validation()">
                                            </div>

                                            <label for="email" id="email-error" class="error">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Address<span class="text-danger">*</span></label>
                                                <textarea cols="15" rows="2" name="address" id="address" class="form-control capitalize" value="{{ old('address') }}" placeholder="Street Address"></textarea>
                                            </div>

                                            <label for="address" id="address-error" class="error">
                                                @error('address')
                                                    {{ $message }}
                                                @enderror
                                            </label>

                                        </div>
                                    </div>




                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <div class="form-group mb-3">
                                                    <div class="form-line">
                                                        <label>Gender<span class="text-danger">*</span></label>
                                                        <div class="name mt-2">
                                                            <label for="male">
                                                                <input type="radio" id="male" name="gender"
                                                                    value="Male" class="radio"
                                                                    @if (old('gender')) checked @endif>
                                                                <span>Male</span>
                                                            </label>
                                                            <label for="Female" class="">
                                                                <input type="radio" id="Female" name="gender"
                                                                    value="Female" class="radio">
                                                                <span>Female</span>
                                                            </label>
                                                            <label for="Other" class="">
                                                                <input type="radio" id="Other" name="gender"
                                                                    value="Female" class="radio">
                                                                <span>Other</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label for="gender" id="gender-error" class="error">
                                                    @error('gender')
                                                        {{ $message }}
                                                    @enderror
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Mobile Number<span class="text-danger">*</span></label>
                                                <input type="text" placeholder="Enter Mobile No." name="mobile_no"
                                                    minlength="10" maxlength="10" id="mobile_no"
                                                    value="{{ old('mobile_no') }}">
                                            </div>

                                            <label for="mobile_no" id="mobile_no-error" class="error">
                                                @error('mobile_no')
                                                    {{ $message }}
                                                @enderror
                                            </label>

                                        </div>
                                    </div>



                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line mb-3">

                                                <label>Designation<span class="text-danger">*</span></label>
                                                <select name="designation" class="form-control" id="designation">
                                                    <option value=""
                                                        {{ old('designation') == '' ? 'selected' : '' }}>Select
                                                        Designation</option>
                                                    <option value="Owner"
                                                        {{ old('designation') == 'Owner' ? 'selected' : '' }}>Owner
                                                    </option>
                                                    <option value="Coordinator"
                                                        {{ old('designation') == 'Coordinator' ? 'selected' : '' }}>
                                                        Coordinator</option>
                                                </select>
                                            </div>

                                            <label for="designation" id="designation-error" class="error">
                                                @error('designation')
                                                    {{ $message }}
                                                @enderror
                                            </label>


                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <div class="form-group mb-3">
                                                    <div class="form-line mb-2">
                                                        <label>Country<span class="text-danger">*</span></label>
                                                        <select name="Country" class="form-control" id="Country">
                                                            <option value="">Select Country</option>
                                                            @foreach ($Country as $Countrys)
                                                                <option value="{{ $Countrys->id }}">
                                                                    {{ $Countrys->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="Country" id="Country-error" class="error">
                                                    @error('Country')
                                                        {{ $message }}
                                                    @enderror
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row clearfix">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line mb-3">
                                                <label for="example-text-input" class="form-control-label">State<span
                                                        class="text-danger">*</span></label>
                                                <select name="state" class="form-control" id="state"
                                                    class="select">
                                                    <option value="">Select State</option>
                                                </select>
                                            </div>

                                            <label for="state" id="state-error" class="error">
                                                @error('state')
                                                    {{ $message }}
                                                @enderror
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line mb-3">
                                                <label for="example-text-input" class="form-control-label">City<span
                                                        class="text-danger">*</span></label>
                                                <select name="city" id="city" class="form-control"
                                                    class="select">
                                                    <option value="">Select city</option>
                                                </select>
                                            </div>

                                            <label for="city" id="city-error" class="error">
                                                @error('city')
                                                    {{ $message }}
                                                @enderror
                                            </label>


                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="example-text-input" class="form-control-label">Postal
                                                    Code<span class="text-danger">*</span></label>
                                                <input type="text" name="postal" id="postal" minlength="2"
                                                    maxlength="6"  placeholder="Postal Code"
                                                   value="{{ old('postal') }}">
                                            </div>


                                        <label for="postal" id="postal-error" class="error">
                                            @error('postal')
                                                {{ $message }}
                                            @enderror
                                        </label>
                                        </div>

                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line mb-3">
                                                <label for="example-text-input" class="form-control-label">Status<span
                                                        class="text-danger">*</span></label>
                                                <select name="status" class="form-control" id="status">
                                                    <option value="">Select Title</option>
                                                    <option value="0"
                                                        {{ old('status') == '0' ? 'selected' : '' }}>Active</option>
                                                    <option value="1"
                                                        {{ old('status') == '1' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>

                                            <label for="status" id="status-error" class="error">
                                                @error('status')
                                                    {{ $message }}
                                                @enderror
                                            </label>

                                        </div>
                                    </div>





                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="example-text-input"
                                                    class="form-control-label">Password<span
                                                        class="text-danger">*</span></label>
                                                <i class="fa fa-eye-slash" aria-hidden="true" id="togglepassword"></i>
                                                <input type="password" value="{{ old('password') }}"
                                                    placeholder="Password" id="password" name="password"
                                                    autocomplete="new-password" required>

                                            </div>
                                            <label for="password" id="password-error" class="error">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="example-text-input" class="form-control-label">Confirm
                                                    password<span class="text-danger">*</span></label>

                                                <i class="fa fa-eye-slash" aria-hidden="true" id="togglecpassword"></i>
                                           
                                            <input type="password" placeholder="Confirm Password" name="cpassword"
                                                value="{{ old('cpassword') }}" for="cpassword" id="cpassword" required>
                                                </div>
                                            <label for="cpassword" id="cpassword-error" class="error">
                                                @error('cpassword')
                                                    {{ $message }}
                                                @enderror
                                            </label>
                                        </div>
                                    </div>


                                </div>
                            {{-- </div> --}}

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line mb-3">
                                            <label for="example-text-input" class="form-control-label">User Type<span
                                                    class="text-danger">*</span></label>
                                            <select name="role" class="form-control" id="role">
                                                <option value="">Select User Type</option>
                                                <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>
                                                    Admin</option>
                                                <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>
                                                    Training Provider</option>
                                                <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>
                                                    Assessor</option>
                                                <option value="4" {{ old('role') == '4' ? 'selected' : '' }}>
                                                    Professional</option>
                                                <option value="5" {{ old('role') == '5' ? 'selected' : '' }}>
                                                    Secretariat</option>
                                            </select>
                                        </div>

                                        <label for="role" id="role-error" class="error">
                                            @error('role')
                                                {{ $message }}
                                            @enderror
                                        </label>

                                    </div>
                                </div>

                           


                            @if (request()->path() == 'adduser/assessor-user')
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="example-text-input" class="form-control-label">Assessment Type<span
                                                class="text-danger">*</span></label>
                                                <select name="assessment" id="assessment" class="form-control"  required>

                                                    <option value="">Select Assessment Type</option>
                                                    <option value="1" {{ old('assessment') == '1' ? 'selected' : '' }}>Desktop Assessment</option>
                                                    <option value="2" {{ old('assessment') == '2' ? 'selected' : '' }}>Onsite Assessment</option>
                                                </select>
                                    </div>

                                    <label for="assessment" id="assessment-error" class="error">
                                        @error('assessment')
                                            {{ $message }}
                                        @enderror
                                    </label>

                                </div>
                            </div>
                            @endif
                            </div>
                            {{-- <input type="text" placeholder="role" name="role" value="1">
                            @elseif(request()->path() == 'adduser/training-provider')
                            <input type="text" placeholder="role" name="role" value="2">
                            @elseif(request()->path() == 'adduser/assessor-user')
                            <input type="text" placeholder="role" name="role" value="3">
                            @endif --}}


                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit" class="btn btn-primary waves-effect m-r-15">Submit</button>
                                <button type="button" class="btn btn-danger waves-effect">Cancel</button>
                            </div>
                    </div>
                    </form>

                </div>

            </div>
        </div>
        </div>
        </div>
    </section>

<script>
     $('.preventnumeric').keypress(function (e) {
          //alert("yes");
         var regex = new RegExp("^[a-z,A-Z_]");
         var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
         if (regex.test(str)) {
             return true;
         }
         e.preventDefault();
         return false;
     });
</script>
    @include('layout.footer')
