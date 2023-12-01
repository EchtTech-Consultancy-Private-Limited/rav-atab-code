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



            @if ($document != null)
                @php
                    $comment = getLastComment($document->id);
                @endphp
                @if ($comment)
                    <div class="card">
                        <div class="card-header bg-white text-dark">
                            <h5 class="mt-2">
                                Comments
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <h5>
                                {{ $comment->comments }}
                            </h5>
                        </div>
                    </div>
                @else
                    <form action="{{ route('on-site.upload-document.post') }}" method="post"
                        enctype="multipart/form-data" id="createNcForm">
                        @csrf
                        <div class="card">
                            <div class="card-header bg-white text-dark">
                                <h5 class="mt-2">
                                    Upload Document
                                </h5>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="documentID" value="{{ $document->id }}">
                                <input type="hidden" name="courseID" value="{{ $courseID }}">
                                <input type="hidden" name="questionID" value="{{ $questionID }}">
                                <input type="hidden" name="applicationID" value="{{ $applicationData->id }}">
                                <input type="hidden" name="user_id" value="{{ $applicationData->user_id }}">
                                <input type="hidden" name="question_code" value="{{ $question->code }}">
                                <input type="hidden" name="parent_doc_id" value="{{ $document->parent_doc_id }}">
                                @php
                                    $lastDocComment = getLastDocCommentData($document->parent_doc_id);
                                @endphp
                                <div class="form-group">
                                    <label for="status">Select Status</label>
                                    <select class="selectINputBox form-control" id="status" name="status">
                                        <option value="">Select</option>

                                        @if ($lastDocComment != null)
                                            @if ($lastDocComment->status == 1)
                                                <option value="2">NC2</option>
                                            @elseif ($lastDocComment->status == 2)
                                                <option value="3">Not Recommended</option>
                                            @endif
                                        @else
                                            <option value="1">NC1</option>
                                        @endif


                                        <option value="4">Approve</option>
                                    </select>
                                    <span id="statusError" class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="remark">Remark</label>
                                    <textarea name="remark" id="remark" class="form-control" style="border: 1px solid #ccc; padding:10px;"></textarea>
                                    <span id="remarkError" class="text-danger"></span>
                                </div>
                                <div class="form-group">
                                    <label for="document">Upload Document</label><br />
                                    <input type="file" name="document" id="document">
                                    <div>
                                        <span id="documentError" class="text-danger"></span>
                                    </div>
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

                <div class="card">
                    <div class="card-header bg-white text-dark">
                        <h5 class="mt-2">
                            ON SITE ASSESSOR
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $pdfUrl = url('level' . '/' . $document->doc_file);
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
            @endif

        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the form element
            var form = document.getElementById('createNcForm');

            // Attach event listeners to form fields
            document.getElementById('status').addEventListener('input', removeErrorMessage);
            document.getElementById('remark').addEventListener('input', removeErrorMessage);

            // Attach an event listener to the file input for immediate file type validation
            var documentInput = document.getElementById('document');
            documentInput.addEventListener('change', function() {
                // Reset document error message
                document.getElementById('documentError').textContent = '';

                // Check the file type of the document
                var allowedExtensions = /(\.pdf|\.jpg|\.jpeg|\.png)$/i;
                var fileName = documentInput.value;
                if (!allowedExtensions.test(fileName)) {
                    document.getElementById('documentError').textContent =
                        'Invalid file type. Please upload a PDF, JPG, JPEG, or PNG file.';
                }
            });

            // Attach an event listener to the form
            form.addEventListener('submit', function(event) {
                // Reset error messages
                document.getElementById('statusError').textContent = '';
                document.getElementById('remarkError').textContent = '';

                // Check if the status is selected
                var status = document.getElementById('status').value;
                if (!status) {
                    document.getElementById('statusError').textContent = 'Please select a status.';
                    event.preventDefault();
                    return false;
                }

                // Check if the remark is filled out
                var remark = document.getElementById('remark').value;
                if (!remark) {
                    document.getElementById('remarkError').textContent = 'Please provide a remark.';
                    event.preventDefault();
                    return false;
                }

                // Check if a document is selected
                if (documentInput.files.length === 0) {
                    document.getElementById('documentError').textContent = 'Please upload a document.';
                    event.preventDefault();
                    return false;
                }

                // Check the file type of the document
                var allowedExtensions = /(\.pdf|\.jpg|\.jpeg|\.png)$/i;
                var fileName = documentInput.files[0].name;
                if (!allowedExtensions.test(fileName)) {
                    document.getElementById('documentError').textContent =
                        'Invalid file type. Please upload a PDF, JPG, JPEG, or PNG file.';
                    event.preventDefault();
                    return false;
                }

                // If all validations pass, the form will be submitted
            });

            // Function to remove error messages on input/change
            function removeErrorMessage() {
                document.getElementById(this.id + 'Error').textContent = '';
            }
        });
    </script>
    @include('layout.footer')
