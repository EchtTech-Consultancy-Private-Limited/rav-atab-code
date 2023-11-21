@include('layout.header')



<title>RAV Accreditation</title>

<style>
    .selectINputBox{
        padding: 8px !important;
        border: 1px solid #ccc !important;
        width: 300px !important;
    }
</style>
</head>

<body class="light">


  
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
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Upload Photograph</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Level </a>
                            </li>
                            <li class="breadcrumb-item active">Upload Photographs</li>


                        </ul>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2">
                        Upload Photograph
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="status">Select Status</label>
                        <select class="selectINputBox form-control" id="status">
                            <option value="">Select</option>
                            <option value="1">NC1</option>
                            <option value="4">Approve</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea name="remark" id="remark" class="form-control" style="border: 1px solid #ccc; padding:10px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="document">Upload Photograph</label><br/>
                        <input type="file" name="document" id="document">
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary mb-0">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layout.footer')
