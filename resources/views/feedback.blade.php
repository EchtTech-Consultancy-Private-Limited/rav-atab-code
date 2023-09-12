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

        @if(Auth::user()->role=='3')
        @include('layout.sideAss')
        @elseif(Auth::user()->role=='2')
        @include('layout.siderTp')

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
                                <h4 class="page-title">Feedback</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Feedback</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                        	@if ($message = Session::get('success'))
					           <div class="alert alert-success">
					              <p>{{ $message }}</p>
					           </div>
					           @endif
                            <h2>
                                <strong class="text-center">Send</strong> Feedback
                            </h2><HR>


                        </div>


                        <form method="post" action="{{ url('/send-feedback') }}" class="javavoid(0) validation-form123"
                          enctype="multipart/form-data">
                          <input type="hidden" name="user_id" value="@if(Auth::user()) {{ Auth::user()->id }} @endif">
                            @csrf
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label>Remark</label>
                                                <textarea class="form-control" name="remark" required></textarea>
                                            </div>

                                            <label for="middlename" id="middlename-error" class="error">
                                                @error('remark')
                                                    {{ $message }}
                                                @enderror
                                            </label>


                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit" class="btn btn-primary waves-effect m-r-15">Send Feedback</button>
                                <a type="button" class="btn btn-primary" href="{{ URL::previous() }}"> Back </a>
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
