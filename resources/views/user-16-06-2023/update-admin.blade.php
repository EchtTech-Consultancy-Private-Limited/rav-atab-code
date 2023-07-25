@include('layout.header')


<title>RAV Accreditation edit user</title>
</head>

<body class="light">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
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
                                <h4 class="page-title">Edit User</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">User</a>
                            </li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Edit</strong> User
                            </h2>

                        </div>


                        <form method="post" action="{{ url('/update-admin' . '/' . dEncrypt($data->id)) }}"
                            class="javavoid(0) validation-form123" id="regForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Title<span class="text-danger">*</span></label>
                                                <select name="title" class="form-control" id="title">
                                                    <option value="">Select Title </option>
                                                    <option value="Mr" {{ $data->title == 'Mr' ? 'selected' : '' }}>
                                                        Mr.</option>
                                                    <option value="Mrs"
                                                        {{ $data->title == 'Mrs' ? 'selected' : '' }}>Mrs.</option>
                                                    <option value="Miss"
                                                        {{ $data->title == 'Miss' ? 'selected' : '' }}>Miss</option>
                                                    <option value="Ms" {{ $data->title == 'Ms' ? 'selected' : '' }}>
                                                        Ms.</option>
                                                    <option value="Dr"
                                                        {{ $data->title == 'Dr' ? 'selected' : '' }}>Dr.</option>
                                                    <option value="Vd" {{ $data->title == 'Vd' ? 'selected' : '' }}>
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
                                                    class="special_no" id="firstname" value="{{ $data->firstname }}"
                                                    id="firstname">
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
                                                    class="special_no" name="middlename"
                                                    value="{{ $data->middlename }}">
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
                                                    class="special_no" name="lastname" value="{{ $data->lastname }}">
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
                                                <label>Orgnisation/Insitute Name<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" placeholder="Orgnisation/Insitute Name"
                                                    class="special_no" name="organization"
                                                    value="{{ $data->organization }}">
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
                                                <label>Email</label>
                                                <input type="email" placeholder="Enter Email id" id="email"
                                                    name="email" value="{{ $data->email }}" id="email"
                                                    onkeydown="validation()" readonly>
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
                                                <textarea cols="15" rows="2" name="address" id="address" class="form-control capitalize"
                                                    placeholder="Street Address">

                                          {{ $data->address }}

                                        </textarea>
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
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Gender<span class="text-danger">*</span></label>
                                                        <div class="name">
                                                            <label for="male">
                                                                <input type="radio" id="male" name="gender"
                                                                    value="Male" class="radio" value="Male"
                                                                    {{ $data->gender == 'Male' ? 'checked' : '' }}>
                                                                <span>Male</span>
                                                            </label>
                                                            <label for="Female" class="">
                                                                <input type="radio" id="Female" name="gender"
                                                                    value="Female" class="radio" value="Male"
                                                                    {{ $data->gender == 'Female' ? 'checked' : '' }}>
                                                                <span>Female</span>
                                                            </label>
                                                            <label for="Other" class="">
                                                                <input type="radio" id="Other" name="gender"
                                                                    value="Other" class="radio" value="Male"
                                                                    {{ $data->gender == 'Other' ? 'checked' : '' }}>
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
                                                <input type="text" placeholder="Enter Mob No." name="mobile_no"
                                                    id="mobile_no" value="{{ $data->mobile_no }}" readonly>
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
                                            <div class="form-line">

                                                <label>Desigantion<span class="text-danger">*</span></label>
                                                <select name="designation" class="form-control" id="designation">
                                                    <option value=""
                                                        {{ $data->designation == '' ? 'selected' : '' }}>Select
                                                        Desigantion</option>
                                                    <option value="Owner"
                                                        {{ $data->designation == 'Owner' ? 'selected' : '' }}>Owner
                                                    </option>
                                                    <option value="Coordinator"
                                                        {{ $data->designation == 'Coordinator' ? 'selected' : '' }}>
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
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label>Contry<span class="text-danger">*</span></label>
                                                        <select name="Country" class="form-control" id="Country">
                                                            <option value="">Select Title</option>
                                                            @foreach ($Country as $Countrys)
                                                                <option value="{{ $Countrys->id }}"
                                                                    {{ $data->country == $Countrys->id ? 'selected' : '' }}>
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
                                            <div class="form-line">
                                                <label for="example-text-input" class="form-control-label">State<span
                                                        class="text-danger">*</span></label>

                                                {{-- {{ $data->state }} --}}

                                                @if ($data->state)
                                                    <select name="state" class="form-control" id="state"
                                                        class="select">
                                                        <option value="{{ $data->state }}">{{ $data->state_name }}
                                                        </option>
                                                    </select>
                                                @else
                                                    <select name="state" class="form-control" id="state"
                                                        class="select">
                                                        <option value="">Select state</option>
                                                    </select>
                                                @endif

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
                                            <div class="form-line">
                                                <label for="example-text-input" class="form-control-label">City<span
                                                        class="text-danger">*</span></label>
                                                {{--
{{ $data->city }} --}}
                                                @if ($data->city)
                                                    <select name="city" id="city" class="form-control"
                                                        class="select">
                                                        <option value="{{ $data->city }}">{{ $data->city_name }}
                                                        </option>
                                                    </select>
                                                @else
                                                    <select name="city" id="city" class="form-control"
                                                        class="select">
                                                        <option value="">Select city</option>
                                                    </select>
                                                @endif

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
                                                <label for="example-text-input" class="form-control-label">Pastal
                                                    Code<span class="text-danger">*</span></label>
                                                <input type="text" minlength="2" maxlength="6" name="postal"
                                                    id="postal" class="form-control" placeholder="Pastal code"
                                                    aria-label="postal" value="{{ $data->postal }}">
                                            </div>
                                        </div>

                                        <label for="postal" id="postal-error" class="error">
                                            @error('postal')
                                                {{ $message }}
                                            @enderror
                                        </label>

                                    </div>
                                </div>


                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="example-text-input" class="form-control-label">Status<span
                                                        class="text-danger">*</span></label>
                                                <select name="status" class="form-control" id="status">
                                                    <option value="">Select Title</option>
                                                    <option value="0"
                                                        {{ $data->status == '0' ? 'selected' : '' }}>Active</option>
                                                    <option value="1"
                                                        {{ $data->status == '1' ? 'selected' : '' }}>Inactive</option>
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
                                                <label for="example-text-input" class="form-control-label">New
                                                    Password</label>
                                                <i class="fa fa-eye " aria-hidden="true" id="togglepassword"></i>
                                                <input type="password" placeholder="Password" id="password"
                                                    name="password" autocomplete="new-password">

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
                                                    password</label>

                                                <i class="fa fa-eye " aria-hidden="true" id="togglecpassword"></i>
                                            </div>
                                            <input type="password" placeholder="Confirm Password" name="cpassword"
                                                value="{{ old('cpassword') }}" for="cpassword" id="cpassword">

                                            <label for="cpassword" id="cpassword-error" class="error">
                                                @error('cpassword')
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
                                                <label for="example-text-input" class="form-control-label">Role<span
                                                        class="text-danger">*</span></label>
                                                <select name="role" class="form-control" id="role">
                                                    <option value="">Select Title</option>
                                                    <option value="1" {{  $data->role == '1' ? 'selected' : '' }}>
                                                        Admin</option>
                                                    <option value="2" {{ $data->role == '2' ? 'selected' : '' }}>
                                                        Trainng Provider</option>
                                                    <option value="3" {{ $data->role == '3' ? 'selected' : '' }}>
                                                        Assessor</option>
                                                    <option value="4" {{ $data->role == '4' ? 'selected' : '' }}>
                                                        professional</option>
                                                </select>
                                            </div>

                                            <label for="role" id="role-error" class="error">
                                                @error('role')
                                                    {{ $message }}
                                                @enderror
                                            </label>

                                        </div>
                                    </div>

                                </div>


                                @if (request()->path() == 'adduser/admin-user')
                                <input type="text" placeholder="role" name="role"  value="{{ $data->role }}">
                            @elseif(request()->path() == 'adduser/training-provider')
                                <input type="text" placeholder="role" name="role" value="{{ $data->role }}">
                            @elseif(request()->path() == 'adduser/assessor-user')
                                <input type="text" placeholder="role" name="role"  value="{{ $data->role }}">
                            @endif












                            </div>


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


    @include('layout.footer')
