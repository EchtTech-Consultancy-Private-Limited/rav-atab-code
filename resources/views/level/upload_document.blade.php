@include('layout.header')



<title>RAV Accreditation</title>

<style>
    .font-12 {
        size: 12px;
        background: rgb(23, 218, 23);
        padding: 3px;
        border-radius: 5px;
    }

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
    .table th, .table td {
    padding: 4px !important; /* Adjust this value to your preference */
  }
</style>

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



    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row p-3">
                    <div class="col-sm-6">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Upload Documents</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Level </a>
                            </li>
                            <li class="breadcrumb-item active">Upload document</li>


                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <div class="pr-2">
                            <a href="{{ url()->previous() }}" type="button" class="btn btn-primary "
                                style="float:right;">Back</a>
                        </div>
                    </div>

                </div>
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

            <div>

                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">

                        <div>
                            <div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget">
                                            @if ($message = Session::get('success'))
                                                <div class="alert alert-success">
                                                    <p>{{ $message }}</p>
                                                </div>
                                            @endif
                                            <div id="success-msg" class="alert alert-success d-none" role="alert">
                                                <p class=" msg-none ">Documents Update Successfully</p>
                                            </div>
                                            <!-- table-striped  -->
                                            <div class="table-responsive">

                                                <table class="table table-bordered someCustomStyleForTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">#S.N0</th>
                                                            <th class="center">Objective criteria</th>
                                                            <!--  <th class="center" style="white-space: nowrap;width:85px;">Yes / No</th> -->
                                                            <th class="center">Cross reference to supporting evidence
                                                                provided</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        @foreach ($chapters as $chapter)
                                                            <tr>
                                                                <th colspan="4">
                                                                    <div class="header">
                                                                        <h2 class="text-center">
                                                                            {{ $chapter->title ?? '' }}
                                                                        </h2>
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                            @foreach ($chapter->questions as $question)
                                                                <tr class="document-row">
                                                                    <td>{{ $question->code ?? '' }}</td>
                                                                    <td>{{ $question->title }}</td>
                                                                    <td>
                                                                        @php
                                                                        $documentsData = [];
                                                                            if (isset($file[0])) {
                                                                                $documentsData = getDocument($question->id, $application_id,$course_id) ?? 0;
                                                                            }
                                                                        @endphp
                                                                        {{-- getting documents for each row --}}
                                                                        @if (count($documentsData) > 0)
                                                                            <div class="d-flex">
                                                                                @if (count($documentsData) >= 3)
                                                                                    @foreach ($documentsData as $docItem)
                                                                                   
                                                                                        <div>
                                                                                            <a target="_blank"
                                                                                                title="{{ checkDocumentCommentStatusreturnText($docItem->id) }}"
                                                                                                href="{{ url('show-pdf' . '/' . $docItem->doc_file) }}"
                                                                                                class="btn {{ checkDocumentCommentStatus($docItem->id) }} btn-sm m-1"> {{ getButtonText($docItem->id) }}</a>
                                                                                        </div>
                                                                                         <div>
                                                                                        @if (getCommentsData($docItem->id) && getCommentsData($docItem->id)->status == 5 && count($documentsData) < 4)
                                                                                        <div>
                                                                                            <form
                                                                                                name="submitform_doc_form"
                                                                                                id="submitform_doc_form_{{ $question->id }}"
                                                                                                class="submitform_doc_form"
                                                                                                enctype="multipart/form-data">
                                                                                                <input type="hidden"
                                                                                                    name="previous_url"
                                                                                                    value="{{ Request::url() }}">
                                                                                                <input type="hidden"
                                                                                                    name="application_id"
                                                                                                    value="{{ $application_id }}">
                                                                                                <input type="hidden"
                                                                                                    name="course_id"
                                                                                                    value="{{ $course_id }}">
                                                                                                <input type="hidden"
                                                                                                    name="question_id"
                                                                                                    value="{{ $question->code }}">
                                                                                                <input type="hidden"
                                                                                                    name="question_pid"
                                                                                                    value="{{ $question->id }}">
                                                                                                <input type="file"
                                                                                                    class="from-control fileup"
                                                                                                    name="fileup"
                                                                                                    id="fileup_{{ $question->id }}"
                                                                                                    data-question-id="{{ $question->id }}" />
                                                                                            </form>
                                                                                        </div>
                                                                                        @endif
                                                                                    </div>
                                                                                    @endforeach
                                                                                @endif
                                                                                @if (count($documentsData) == 2)
                                                                                    @if (count(commentsCountForTP($question->id, $application_id)) == 2 &&  checkApproveComment($documentsData[1]->id) !== 4)
                                                                                        <div>
                                                                                            <form
                                                                                                name="submitform_doc_form"
                                                                                                id="submitform_doc_form_{{ $question->id }}"
                                                                                                class="submitform_doc_form"
                                                                                                enctype="multipart/form-data">
                                                                                                <input type="hidden"
                                                                                                    name="previous_url"
                                                                                                    value="{{ Request::url() }}">
                                                                                                <input type="hidden"
                                                                                                    name="application_id"
                                                                                                    value="{{ $application_id }}">
                                                                                                <input type="hidden"
                                                                                                    name="course_id"
                                                                                                    value="{{ $course_id }}">
                                                                                                <input type="hidden"
                                                                                                    name="question_id"
                                                                                                    value="{{ $question->code }}">
                                                                                                <input type="hidden"
                                                                                                    name="question_pid"
                                                                                                    value="{{ $question->id }}">
                                                                                                <input type="file"
                                                                                                    class="from-control fileup"
                                                                                                    name="fileup"
                                                                                                    id="fileup_{{ $question->id }}"
                                                                                                    data-question-id="{{ $question->id }}" />
                                                                                            </form>
                                                                                        </div>
                                                                                    @endif
                                                                                    @foreach ($documentsData as $docItem)
                                                                                        <div>
                                                                                            <a target="_blank"
                                                                                                title="{{ checkDocumentCommentStatusreturnText($docItem->id) }}"
                                                                                                href="{{ url('show-pdf' . '/' . $docItem->doc_file) }}"
                                                                                                class="btn {{ checkDocumentCommentStatus($docItem->id) }} btn-sm m-1">
                                                                                                {{ getButtonText($docItem->id) }}
                                                                                            </a>
                                                                                        </div>
                                                                                    @endforeach
                                                                                @endif
                                                                                @if (count($documentsData) == 1)
                                                                                    @if (checkCommentsExist($question->id, $application_id,$documentsData[0]) == true && checkApproveComment($documentsData[0]->id) !== 4)
                                                                                        <div>
                                                                                            <form
                                                                                                name="submitform_doc_form"
                                                                                                id="submitform_doc_form_{{ $question->id }}"
                                                                                                class="submitform_doc_form"
                                                                                                enctype="multipart/form-data">
                                                                                                <input type="hidden"
                                                                                                    name="previous_url"
                                                                                                    value="{{ Request::url() }}">
                                                                                                <input type="hidden"
                                                                                                    name="application_id"
                                                                                                    value="{{ $application_id }}">
                                                                                                <input type="hidden"
                                                                                                    name="course_id"
                                                                                                    value="{{ $course_id }}">
                                                                                                <input type="hidden"
                                                                                                    name="question_id"
                                                                                                    value="{{ $question->code }}">
                                                                                                <input type="hidden"
                                                                                                    name="question_pid"
                                                                                                    value="{{ $question->id }}">
                                                                                                <input type="file"
                                                                                                    class="from-control fileup"
                                                                                                    name="fileup"
                                                                                                    id="fileup_{{ $question->id }}"
                                                                                                    data-question-id="{{ $question->id }}" />
                                                                                            </form>
                                                                                        </div>
                                                                                        <div>
                                                                                            <a target="_blank"
                                                                                                title="{{ checkDocumentCommentStatusreturnText($documentsData[0]->id) }}"
                                                                                                href="{{ url('show-pdf' . '/' . $documentsData[0]->doc_file) }}"
                                                                                                class="btn {{ checkDocumentCommentStatus($documentsData[0]->id) }} btn-sm m-1">{{ getButtonText($documentsData[0]->id) }}</a>
                                                                                        </div>
                                                                                    @else
                                                                                        <a target="_blank"
                                                                                            title="{{ checkDocumentCommentStatusreturnText($documentsData[0]->id) }}"
                                                                                            href="{{ url('show-pdf' . '/' . $documentsData[0]->doc_file) }}"
                                                                                            class="btn {{ checkDocumentCommentStatus($documentsData[0]->id) }} btn-sm m-1">{{ getButtonText($documentsData[0]->id) }}</a>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        @else
                                                                            <form name="submitform_doc_form"
                                                                                id="submitform_doc_form_{{ $question->id }}"
                                                                                class="submitform_doc_form"
                                                                                enctype="multipart/form-data">
                                                                                <input type="hidden"
                                                                                    name="previous_url"
                                                                                    value="{{ Request::url() }}">
                                                                                <input type="hidden"
                                                                                    name="application_id"
                                                                                    value="{{ $application_id }}">
                                                                                <input type="hidden" name="course_id"
                                                                                    value="{{ $course_id }}">
                                                                                <input type="hidden"
                                                                                    name="question_id"
                                                                                    value="{{ $question->code }}">
                                                                                <input type="hidden"
                                                                                    name="question_pid"
                                                                                    value="{{ $question->id }}">
                                                                                <input type="file"
                                                                                    class="from-control fileup"
                                                                                    name="fileup"
                                                                                    id="fileup_{{ $question->id }}"
                                                                                    data-question-id="{{ $question->id }}" />
                                                                            </form>
                                                                        @endif
                                                                        {{-- getting documents for each row end point --}}
                                                                    </td>
                                                                    <td>

                                                                        @if (checkCommentsExist($question->id, $application_id) == true)
                                                                            <button
                                                                                class="expand-button btn btn-primary btn-sm mt-3"
                                                                                onclick="toggleDocumentDetails(this)">Comments</button>
                                                                        @else
                                                                            <span class="text-danger"
                                                                                style="font-size: 12px; padding:5px; border-radius:5px;">No
                                                                                comments available!</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>

                                                                <tr class="document-details" style="display: none;">
                                                                    <td colspan="4">
                                                                        {!! getComments($question->id, $application_id) !!}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


    <script>
        function toggleDocumentDetails(button) {
            const documentRow = button.closest('.document-row');
            const documentDetails = documentRow.nextElementSibling;

            if (documentDetails && (documentDetails.classList.contains('document-details'))) {
                if (documentDetails.style.display === 'none' || documentDetails.style.display === '') {
                    documentDetails.style.display = 'table-row';
                    button.textContent = 'Collapse';



                } else {
                    documentDetails.style.display = 'none';
                    button.textContent = 'Expand';
                }
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            $('.fileup').change(function() {
                var fileInput = $(this);
                var questionId = fileInput.data('question-id');
                var form = $('#submitform_doc_form_' + questionId)[0];
                var formData = new FormData(form);
                var allowedExtensions = ['pdf', 'doc', 'docx']; // Add more extensions if needed

                var uploadedFileName = fileInput.val();
                var fileExtension = uploadedFileName.split('.').pop().toLowerCase();

                if (allowedExtensions.indexOf(fileExtension) === -1) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Invalid File Type',
                        text: 'Please upload a PDF or DOC file.',
                        showConfirmButton: true
                    });

                    // Clear the file input
                    fileInput.val('');
                    return;
                }

                $("#loader").removeClass('d-none');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('add-courses') }}", // Your server-side upload endpoint
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#loader").addClass('d-none');
                        if (response.message == 'success') {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Upload Successful',
                                text: 'Your documents have been successfully uploaded.',
                                showConfirmButton: false,
                                timer: 2000
                            });

                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(error);
                    }
                });
            });
        });
    </script>


    @include('layout.footer')
