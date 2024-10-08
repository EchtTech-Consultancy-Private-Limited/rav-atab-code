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
                            <b>Application ID:</b><span
                                style="font-weight: bold;">{{ $applicationData->application_uid }}</span>
                        </div>
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

                                                <table class="table table-hover table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">Sr.No.</th>
                                                            <th class="center width-50">Objective criteria</th>
                                                            <!--  <th class="center" style="white-space: nowrap;width:85px;">Yes / No</th> -->
                                                            <th class="center">Cross reference to supporting evidence
                                                                provided</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
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
                                                                    <td style="text-align: left;">{{ $question->title }}
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $documentsData = [];
                                                                            if (isset($file[0])) {
                                                                                $documentsData = getDocument($question->id, $application_id, $course_id) ?? 0;
                                                                                $photographdata = getPhotograph($question->id, $application_id, $course_id) ?? 0;
                                                                            }
                                                                        @endphp
                                                                        {{-- getting documents for each row --}}
                                                                        @if (count($documentsData) > 0)
                                                                            <div class="d-flex">

                                                                                @foreach ($documentsData as $docItem)
                                                                                    <div>
                                                                                        <a target="_blank"
                                                                                            title="{{ checkDocumentCommentStatusreturnText($docItem->id) }}"
                                                                                            href="{{ url('document-detail' . '/' . $docItem->doc_file . '/' . $applicationData->id . '/' . $docItem->id) }}"
                                                                                            class="btn {{ checkDocumentCommentStatus($docItem->id) }} btn-sm docBtn m-1">
                                                                                            {{ getButtonText($docItem->id) }}</a>
                                                                                        <div
                                                                                            style="font-size: 10px; margin:2px; margin-top:0px; font-weight:bold;">
                                                                                            {{ updatedBy($docItem->id) }}
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                               
                                                                                @php
                                                                                    $last_document = $documentsData[count($documentsData) - 1];

                                                                                @endphp
                                                                                @if (getCommentsData($last_document->id))
                                                                                    {{-- @dd(getCommentsData($last_document->id)) --}}
                                                                                    @if (
                                                                                        $last_document &&
                                                                                            getCommentsData($last_document->id)->status != 4 &&
                                                                                            getCommentsData($last_document->id)->status != 3 &&
                                                                                            getCommentsData($last_document->id)->status != 6)
                                                                                        <div>
                                                                                            <form
                                                                                                name="submitform_doc_form"
                                                                                                id="submitform_doc_form_{{ $question->id }}"
                                                                                                class="submitform_doc_form"
                                                                                                enctype="multipart/form-data">
                                                                                                <input type="hidden" name="parent_doc_id" value="{{ $last_document->id }}">
                                                                                                <input type="hidden" name="is_displayed_onsite" value="{{ $last_document->on_site_assessor_Id ? 1 : 0 }}">
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
                                                                                @endif
                                                                                @foreach ($photographdata as $photo)
                                                                                <div>
                                                                                 <a target="_blank"
                                                                                 title="{{ checkDocumentCommentStatusreturnText($photo->id) }}"
                                                                                 href="{{ url('document-detail' . '/' . $photo->doc_file . '/' . $applicationData->id . '/' . $photo->id) }}"
                                                                                 class="btn {{ checkDocumentCommentStatus($photo->id) }} docBtn btn-sm m-1">
                                                                                 {{ getButtonText($photo->id) }}</a>
                                                                             <div
                                                                                 style="font-size: 10px; margin:2px; margin-top:0px; font-weight:bold;">
                                                                                 {{ updatedBy($photo->id) }}
                                                                             </div>
                                                                                </div>
                                                                             @endforeach
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

                                                                        @if (checkCommentsExist($question->id, $application_id,$course_id) == true)
                                                                            <button
                                                                                class="expand-button btn btn-primary btn-sm mt-3"
                                                                                onclick="toggleDocumentDetails(this)">Show Comments</button>
                                                                        @else
                                                                            <span class="text-danger"
                                                                                style="font-size: 12px; padding:5px; border-radius:5px;">Comment
                                                                                pending!</span>
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
                    button.textContent = 'Hide Comments';

                } else {
                    documentDetails.style.display = 'none';
                    button.textContent = 'Show Comments';
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
