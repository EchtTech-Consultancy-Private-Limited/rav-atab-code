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
                    Basic Information
                </h5>
            </div>
            <div class="card-body">
                <div>
                    <h6>Single Point of Contact Details (SPoC) Details</h6>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <span class="txtBold">Person Name</span> <br>
                        <span class="text-dark">
                            {{ $applicationDetails->Person_Name }}
                        </span>
                    </div>
                    <div class="col-sm-3">
                        <span class="txtBold">Contact Number</span> <br>
                        <span class="text-dark">
                            {{ $applicationDetails->Contact_Number }}
                        </span>
                    </div>
                    <div class="col-sm-3">
                        <span class="txtBold">Email</span> <br>
                        <span class="text-dark">
                            {{ $applicationDetails->Email_ID }}
                        </span>
                    </div>
                    <div class="col-sm-3">
                        <span class="txtBold">Designation</span> <br>
                        <span class="text-dark">
                            {{ $applicationDetails->designation }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-dark bg-white">
                <h5 class="mt-2">Documents</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Objective criteria</th>
                            <th>Documents</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chapters as $chapter)
                            <tr>
                                <td colspan="4" class="p-2 pt-3 text-center">
                                    <h5>
                                        {{ $chapter->title }}
                                    </h5>
                                </td>
                            </tr>
                            @foreach ($chapter->questions as $question)
                                <tr>
                                    <td width="30">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $question->title }}
                                    </td>
                                    <td width="300">
                                        <div class="d-flex justify-content-center">
                                            <div style="margin-right: 10px;">
                                                <div>
                                                    Desktop
                                                </div>
                                                <div>
                                                    <button>NC1</button>
                                                    <button>NC1</button>
                                                    <button>NC1</button>
                                                </div>
                                            </div>
                                            <div>
                                                <div>
                                                    On-Site
                                                </div>
                                                <div>
                                                    <button>Document</button>
                                                    <button>Photograph</button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary mb-0">Comments</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @include('layout.footer')
