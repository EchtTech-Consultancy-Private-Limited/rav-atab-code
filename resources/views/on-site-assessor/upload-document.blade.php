@include('layout.header')



<title>RAV Accreditation</title>

<style>
    .selectINputBox {
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

    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: "Success",
                text: "{{ $message }}",
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Upload Document</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Level </a>
                            </li>
                            <li class="breadcrumb-item active">Upload Documents</li>


                        </ul>
                    </div>

                </div>
            </div>

            @php
                $document = checkOnSiteDoc($applicationData->id, $questionID, $courseID, auth()->user()->id);
            @endphp

            @if ($document != null)
                @php
                    $comment = getLastComment($document->id);
                @endphp


                <div class="card">
                    <div class="card-header bg-white text-dark">
                        <h5 class="mt-2">
                            ON SITE ASSESSOR
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $pdfUrl = url('documnet' . '/' . $document->doc_file);
                            $fileExtension = pathinfo($pdfUrl, PATHINFO_EXTENSION);
                        @endphp

                        @if ($fileExtension === 'pdf')
                            <object data="{{ $pdfUrl }}" type="application/pdf" width="100%" height="500px">
                                <p>Unable to display PDF. <a href="{{ $pdfUrl }}" target="_blank">Download
                                        Document</a> </p>
                            </object>
                        @else
                            <a class="btn btn-info btn-sm" href="{{ $pdfUrl }}" target="_blank">Download
                                Document</a>
                        @endif
                    </div>
                </div>
            @else
                <form action="{{ route('on-site.upload-document.post') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-white text-dark">
                            <h5 class="mt-2">
                                Upload Document
                            </h5>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="documentID" value="{{ $documentID }}">
                            <input type="hidden" name="courseID" value="{{ $courseID }}">
                            <input type="hidden" name="questionID" value="{{ $questionID }}">
                            <input type="hidden" name="applicationID" value="{{ $applicationData->id }}">
                            <input type="hidden" name="user_id" value="{{ $applicationData->user_id }}">
                            <input type="hidden" name="question_code" value="{{ $question->code }}">
                            <div class="form-group">
                                <label for="status">Select Status</label>
                                <select class="selectINputBox form-control" id="status" name="status">
                                    <option value="">Select</option>
                                    <option value="11">NC1</option>
                                    <option value="14">Approve</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea name="remark" id="remark" class="form-control" style="border: 1px solid #ccc; padding:10px;"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="document">Upload Document</label><br />
                                <input type="file" name="document" id="document">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mb-0">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            @endif

        </div>
    </section>
    @include('layout.footer')
