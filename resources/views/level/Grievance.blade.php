@include('layout.header')


<title>RAV Accreditation || Grievance</title>

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


        @include('layout.siderTp')



        @include('layout.rightbar')


    </div>


    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Add Grievance </h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Grievance</a>
                            </li>
                            <li class="breadcrumb-item active">Add Grievance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Add</strong> Grievance</h2>

                        </div>


                        <form  method="post"  action="{{ url('/Add-Grievance') }}" class="javavoid(0) validation-form123" id="regForm"   enctype="multipart/form-data">
                            @csrf
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label >Issue Type<span class="text-danger">*</span></label>
                                                    <select name="subject" class="form-control" id="subject">
                                                    <option value="">Select Section </option>
                                                    <option value="website-issue">website issue</option>
                                                    <option value="process-related-issues">process related issues</option>

                                                    </select>
                                            </div>

                                                <label for="issue"  id="issue-error" class="error">
                                                    @error('issue')
                                                    {{ $message }}
                                                    @enderror
                                                </label>
                                        </div>
                                    </div>



                                    <div class="col-sm-12">
                                        <div class="form-group">
                                                <label><strong>Remark</strong></label>
                                            <div class="form-line">
                                                <textarea class="form-control" name="details" id="details"  placeholder="Ender Grievance Information"></textarea>
                                                @error('details')
                                                    <label for="details"  id="details-error" class="error">
                                                    {{ $message }}
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                </div>


{{-- {{ Auth::user()->email }} --}}


                               <div class="col-lg-12 p-t-20 text-center">
                                  <button type="submit" class="btn btn-primary waves-effect m-r-15">Submit</button>
                                  <a  href="{{ URL::previous() }}" class="btn btn-danger waves-effect">Back</a>
                               </div>
                            </div>
                        </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="{{asset('assets/js/bundles/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
    <script>
         tinymce.init({
        selector: 'textarea#details',
        menubar: 'edit insert view format table tools'
      });
    </script>

    @include('layout.footer')

