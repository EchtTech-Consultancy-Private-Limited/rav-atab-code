@include('layout.header')



<title>RAV Accreditation</title>

<style>
    table th,
    table td {
        text-align: center;
        border: 1px solid #eee;
    }

    .highlight {
        background-color: #9789894a;
    }

    .highlight_nc {
        background-color: #ff000042;
    }

    .highlight_nc_approved {
        background-color: #00800040;
    }

    td select.form-control.text-center {
        border: 0;
    }

    .loading-img {
        z-index: 99999999;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        ;
        overflow: hidden;
        text-align: center;
    }

    .loading-img .box {
        position: absolute;
        top: 50%;
        left: 50%;
        margin: auto;
        transform: translate(-50%, -50%);
        z-index: 2;
    }

    .uploading-text {
        padding-top: 10px;
        color: #fff;
        /* font-size: 18px; */
    }

    td.text-justify {
        text-align: left;
    }

    .btnDiv a {
        margin-right: 10px !important;
    }



    .file-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .file-label {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #3498db;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 12px;
    }

    .file-label:hover {
        background-color: #2980b9;
    }

    .file-input {
        display: none;
    }
</style>

</head>

<body class="light">


    <!-- Progressbar Modal Poup -->
    <div class="loading-img d-none" id="loader">
        <div class="box">
            <img src="{{ asset('assets/img/VAyR.gif') }}">
            <h5 class="uploading-text"> Uploading... </h5>
        </div>
    </div>
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

    @if (Session::has('sussess'))
        <div class="alert alert-success" role="alert">
            {{ session::get('success') }}
        </div>
    @elseif(Session::has('fail'))
        <div class="alert alert-danger" role="alert">
            {{ session::get('fail') }}
        </div>
    @endif


    <section class="content">
        @if (auth()->user()->assessment == 1)
            <form action="{{ url('submit-remark') }}" method="post">
                @csrf

                <input type="hidden" name="application_id" value="{{ $applicationData->id ?? 0 }}">
                <input type="hidden" name="tpId" value="{{ $applicationData->user_id ?? 0 }}">
                <div class="card">
                    <div class="card-header bg-white text-dark">
                        <h5 class="mt-2">
                            Write Remark
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Select Document</label>
                            <select name="document_id" class="form-control" style="width: 250px;">
                                <option value="">Select Document</option>
                                @foreach ($documents as $item)
                                    <option value="">{{ getButtonText($item->id) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea name="remark" class="form-control" placeholder="Write remark..."></textarea>
                        </div>

                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mb-0">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif

        @if (!$remarks->isEmpty())
            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2">
                        Remarks
                    </h5>
                </div>
                <div class="card-body p-0">
                    <table class="table-responsive table-hover">
                        <thead>
                            <th width="50">Sr.No.</th>
                            <th>Remark</th>
                            <th width="150">Document</th>
                            <th width="200">Added By</th>
                        </thead>
                        <tbody>
                            @foreach ($remarks as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->remark }}</td>
                                    <td>
                                        {{ getButtonText($item->document_id) }}
                                    </td>
                                    <td>{{ $item->user->firstname }} {{ $item->user->middlename }}
                                        {{ $item->user->lastname }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="card text-center">
                <div class="card-body">
                    <i class="fa fa-comments fa-4x text-muted"></i>
                    <h4 class="text-muted mt-4">No Comments Found</h4>
                    <p class="text-muted">There are no remarks available for this application at the moment.</p>
                </div>
            </div>


        @endif
    </section>

    @include('layout.footer')
