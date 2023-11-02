@include('layout.header')
<title>RAV Accreditation</title>

<style>
    .txtBold {
        font-weight: bold;
    }
</style>

</head>

<body class="light">
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    @include('layout.topbar')
    <div>
        @if (Auth::user()->role == 1)
            @include('layout.sidebar')
        @elseif(Auth::user()->role == 2)
            @include('layout.siderTp')
        @elseif(Auth::user()->role == 3)
            @include('layout.sideAss')
        @elseif(Auth::user()->role == 4)
            @include('layout.sideprof')
        @elseif(Auth::user()->role == 5)
            @include('layout.secretariat')
        @elseif(Auth::user()->role == 6)
            @include('layout.sidbarAccount')
        @endif
        @include('layout.rightbar')
    </div>
    <section class="content">
        <div>
            <div>
                <h5>Application Summary</h5>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                    Submit Report
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="txtBold">Application ID</label><br>
                            {{ $applicationData->application_uid }}
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <form action="{{ url('submit-final-report/' . $applicationData->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Remark</label>
                                <textarea name="remark" class="form-control" placeholder="Write remarks...">{{ old('remark') }}</textarea>
                                @error('remark')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="" class="txtBold">Upload GPS Location Picture</label><br>
                                <input type="file" name="gps_pic">
                                @error('gps_pic')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <button class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layout.footer')
