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

    .width-50{width:50%}
    .width-10{width:10%}
    .card .header h2{font-size:14px;}
    .card .header{padding:8px}
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



    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">View Documents</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Level </a>
                            </li>
                            <li class="breadcrumb-item active">View Documents</li>


                        </ul>
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

                                        <div class="d-flex justify-content-between align-items-center mb-3">

                                        <div>
                                            <span style="font-weight: bold;">Application ID:</span>
                                            {{ $applicationData->application_uid }}
                                        </div>

                                         <div>
                                         @if (check_document_upload($course_id) == Auth::user()->id)
                                                {{-- <a href="{{ url('document-report-toadmin/' . $course_id) }}"
                                                    class="btn btn-primary">Send Document To Admin</a> --}}
                                            @else
                                                {{-- <a href="#" class="btn btn-danger">Send Document To Admin</a> --}}
                                            @endif

                                            <a href="{{ url('document-comment-admin-assessor/' . $course_id) }}"
                                                class="btn btn-dark" style="margin-right:10px;">History Log</a>
                                                <a href="{{ url('Assessor-view/' . dEncrypt($application_id)) }}"
                                            class="btn btn-primary btn-sm">Back</a>
                                         </div>

                                        </div>

                                        <div class="card project_widget">
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
                                            <div id="success-msg" class="alert alert-success d-none" role="alert">
                                                <p class=" msg-none ">Documents Update Successfully</p>
                                            </div>
                                            <!-- table-striped  -->

                                            <div class="table-responsive">

                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>
                                                        <tr>
                                                            <th class="width-10">Sr.No.</th>
                                                            <th class="width-50">Objective criteria</th>
                                                            <th>{{ auth()->user()->assessment == 1 ? 'Desktop' : 'On-site' }} Assessor</th>
                                                            <th rowspan="2" class="width-10">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($chapters as $chapter)
                                                            <tr>
                                                                <th colspan="4">
                                                                    <div class="header">
                                                                        <h2 class="text-center">{{ $chapter->title }}
                                                                        </h2>
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                            @foreach ($chapter->questions as $question)
                                                                <tr>
                                                                    <td>{{ $question->code ?? '' }}</td>
                                                                    <td class="text-justify">
                                                                        {{ $question->title ?? '' }}
                                                                    </td>
                                                                    <td>
                                                                        <div style="border-radius: 10px;  color:#000;">
                                                                            <!-- <div
                                                                                style="border-bottom: 1px solid #ddd; padding:3px; font-size:11px;">
                                                                                Desktop Assessor
                                                                            </div> -->
                                                                            <div class="d-flex justify-content-center"
                                                                                style="padding: 8px; text-align:center;">
                                                                                @if ($question->documents->isEmpty())
                                                                                    <div class="text-center">
                                                                                        <span
                                                                                            class="docBtn btn-warning btn-sm text-white">Documents
                                                                                            not uploaded</span>
                                                                                    </div>
                                                                                @else
                                                                                    @if (count(getAssessorDocument($question->id, $application_id, $course_id)) > 0)
                                                                                        @php
                                                                                            $documentData = getAssessorDocument($question->id, $application_id, $course_id);
                                                                                        @endphp
                                                                                        @if (count(getAssessorDocument($question->id, $application_id, $course_id)) == 1)
                                                                                            @if (count(getAssessorComments($documentData[0]->id)))
                                                                                                <div>
                                                                                                    <a class="docBtn {{ checkDocumentCommentStatus($documentData[0]->id) }} btn-sm"
                                                                                                        title="{{ checkDocumentCommentStatusreturnText($documentData[0]->id) }}"

                                                                                                        href="{{ url('view-doc' . '/' . $documentData[0]->id . '/' . $documentData[0]->doc_file . '/' . $documentData[0]->id . '/' . $course_id) }}">{{ getButtonText($documentData[0]->id) }}</a>
                                                                                                    <div
                                                                                                        style="font-size: 10px; margin-top:5px; margin-bottom:5px;">
                                                                                                        {{ checkFinalRequest($documentData[0]->id) }}
                                                                                                    </div>
                                                                                                </div>
                                                                                            @else
                                                                                                <div>
                                                                                                    <a class="docBtn {{ checkDocumentCommentStatus($documentData[0]->id) }} btn-sm"
                                                                                                        title="{{ checkDocumentCommentStatusreturnText($documentData[0]->id) }}"

                                                                                                        href="{{ url('view-doc' . '/' . $documentData[0]->doc_id . '/' . $documentData[0]->doc_file . '/' . $documentData[0]->id . '/' . $course_id) }}">{{ getButtonText($documentData[0]->id) }}</a>
                                                                                                    <div
                                                                                                        style="font-size: 10px; margin-top:5px; margin-bottom:5px;">
                                                                                                        {{ checkFinalRequest($documentData[0]->id) }}
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        @endif
                                                                                        @if (count(getAssessorDocument($question->id, $application_id, $course_id)) == 2)
                                                                                            @foreach ($documentData as $docItem)
                                                                                                <div>
                                                                                                    <a class="docBtn {{ checkDocumentCommentStatus($docItem->id) }} btn-sm"
                                                                                                        title="{{ checkDocumentCommentStatusreturnText($docItem->id) }}"

                                                                                                        href="{{ url('view-doc' . '/' . $docItem->doc_id . '/' . $docItem->doc_file . '/' . $docItem->id . '/' . $course_id) }}">{{ getButtonText($docItem->id) }}</a>
                                                                                                    <div
                                                                                                        style="font-size: 10px; margin-top:5px; margin-bottom:5px;">
                                                                                                        {{ checkFinalRequest($docItem->id) }}
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        @endif
                                                                                        @if (count(getAssessorDocument($question->id, $application_id, $course_id)) >= 3)
                                                                                            @foreach ($documentData as $docItem)
                                                                                                <div>
                                                                                                    <a class="docBtn {{ checkDocumentCommentStatus($docItem->id) }} btn-sm"
                                                                                                        title="{{ checkDocumentCommentStatusreturnText($docItem->id) }}"

                                                                                                        href="{{ url('view-doc' . '/' . $docItem->doc_id . '/' . $docItem->doc_file . '/' . $docItem->id . '/' . $course_id) }}">{{ getButtonText($docItem->id) }}
                                                                                                    </a>
                                                                                                    <div
                                                                                                        style="font-size: 10px; margin-top:5px; margin-bottom:5px;">
                                                                                                        {{ checkFinalRequest($docItem->id) }}
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    @else
                                                                                        <span
                                                                                            class="badge bg-danger text-white">Documents
                                                                                            not uploaded</span>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>

                                                                        @if (auth()->user()->assessment == 2)
                                                                            @php
                                                                                $documentData = getAssessorDocument($question->id, $application_id, $course_id);
                                                                                $approvedDocumentID = 0;
                                                                                foreach ($documentData as $document) {
                                                                                    $comments = getAssessorComments($document->id);
                                                                                    foreach ($comments as $comment) {
                                                                                        if ($comment->status == 4) {
                                                                                            $approvedDocumentID = $document->id;
                                                                                        }
                                                                                    }
                                                                                }

                                                                            @endphp
                                                                            <div class="text-dark mt-1"
                                                                                style="border-radius: 10px;">
                                                                                <div
                                                                                    style="padding: 3px; font-size: 11px; border-bottom: 1px solid #ddd;">
                                                                                    On-Site Assessor
                                                                                </div>
                                                                                <div style="padding: 8px;">
                                                                                    @php
                                                                                        $documents = getOnSiteAssessorDocument($question->id, $applicationData->id, $course_id);
                                                                                    @endphp
                                                                                    @if ($documents !== null)
                                                                                        <div
                                                                                            class="d-flex justify-content-center">
                                                                                            @foreach ($documents as $document)
                                                                                                @if ($document->is_displayed_onsite != 2)
                                                                                                    <div
                                                                                                        style="margin:4px;">
                                                                                                        <a target="_blank"
                                                                                                            href="{{ url('on-site/view/document/' . $document->doc_file . '/' . $document->id . '/' . $question->id . '/' . $applicationData->id . '/' . $course_id) }}"
                                                                                                            class="btn {{ checkDocumentCommentStatus($document->id) }} btn-sm mb-0">{{ getButtonText($document->id) }}
                                                                                                        </a>

                                                                                                    </div>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </div>
                                                                                    @endif
                                                                                    <div
                                                                                        class="d-flex justify-content-center">
                                                                                        @if (count($documents) == 0)
                                                                                            <div>
                                                                                                <a target="_blank"
                                                                                                    href="{{ route('on-site.upload-document', ['applicationID' => $applicationData->id, 'courseID' => $course_id, 'questionID' => $question->id, 'documentID' => $approvedDocumentID]) }}"
                                                                                                    class="btn btn-primary btn-sm">Upload
                                                                                                    Document</a>&nbsp;
                                                                                            </div>
                                                                                            &nbsp;
                                                                                        @endif
                                                                                        @php
                                                                                            $photographs = getOnSiteAssessorPhotograph($question->id, $applicationData->id, $course_id);
                                                                                        @endphp
                                                                                        @if ($photographs !== null)
                                                                                            @foreach ($photographs as $document)
                                                                                                <a target="_blank"
                                                                                                    href="{{ route('on-site.upload-photograph', ['applicationID' => $applicationData->id, 'courseID' => $course_id, 'questionID' => $question->id, 'documentID' => $approvedDocumentID]) }}"
                                                                                                    class="btn btn-info btn-sm">{{ getButtonText($document->id) }}
                                                                                                    Photograph</a>
                                                                                            @endforeach
                                                                                        @endif
                                                                                        @if (count($photographs) == 0)
                                                                                            <div>
                                                                                                <a target="_blank"
                                                                                                    href="{{ route('on-site.upload-photograph', ['applicationID' => $applicationData->id, 'courseID' => $course_id, 'questionID' => $question->id, 'documentID' => $approvedDocumentID]) }}"
                                                                                                    class="btn btn-info btn-sm">Upload
                                                                                                    Photograph</a>
                                                                                            </div>
                                                                                    </div>
                                                                        @endif
                                            </div>
                                        </div>
                                        @endif


                                        </td>
                                        <td>
                                            <a target="_blank"
                                                href="{{ url('remarks/' . $applicationData->id . '/' . $course_id . '/' . $question->id) }}"
                                                class="btn btn-info btn-sm p-2 mb-0"><i class="fa fa-comments"></i>
                                                Remarks</a>
                                        </td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                        </tbody>
                                        </table>


                                    </div>

                                    @if (auth()->user()->assessment == 2)
                                        @if ($applicationData->gps_pic == null && $applicationData->onsite_status != 1)
                                            @if (totalDocumentsCount($application_id) >= 0)
                                                <div class="d-flex justify-content-end">
                                                    <a target="_blank" class="btn btn-primary mr-2"
                                                        href="{{ url('on-site/report/?application=' . $applicationData->id . '&course=' . $course_id) }}">
                                                        Submit
                                                    </a>
                                                </div>
                                            @else

                                            <p>Report submitted</p>
                                        @endif
                                    @endif
                                    @endif
                                    @if (auth()->user()->assessment == 1)
                                        @php
                                            $applicationCompletedCount = applicationDocuments($application_id);
                                        @endphp

                                        {{-- Desktop Assessor --}}
                                        @if ($summeryReport == null)
                                            <div class="d-flex justify-content-end">
                                                <!-- <form id="submitForm"
                action="{{ route('submit-final-report-by-desktop') }}"
                method="post">
                @csrf
                <input type="hidden" name="applicationID"
                    value="{{ $application_id }}">
                <button type="button" class="btn btn-success"
                    style="margin-right: 10px;"
                    onclick="confirmSubmit()">Submit</button>
            </form> -->

                                                @if (totalDocumentsCount($application_id) >= 0)
                                                    <a
                                                        href="{{ url('/submit-report-by-desktop' . '/' . $application_id . '/' . $course_id) }}">
                                                        <button type="button" class="btn btn-success"
                                                            style="margin-right: 10px;">Submit Report</button>
                                                    </a>
                                                @endif
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <h5>Report Submitted By Desktop Assessor</h5>
                                            </div>
                                        @endif
                                    @endif



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
        function confirmSubmit() {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to submit the report?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms, manually submit the form
                    document.getElementById('submitForm').submit();
                }
            });
        }
    </script>

    <script>
        $('.fileup').on('change', function(e) {
            e.preventDefault();

            let sbformId = $(this).closest("form").attr('id');
            let formData = new FormData(document.getElementById(sbformId));
            console.log(formData);
            formData.append('fileup', $('input[type=file]').val().split('\\').pop());

            //formData.append('fileup', $('input[type=file]').val().split('\\').pop());
            $("#success-msg").removeClass('d-none');
            $("#loader").removeClass('d-none');
            var data = "{{ url(Request::url()) }}";
            //alert(data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({

                url: " {{ url('add-courses') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',



                success: function(response) {
                    $("#loader").addClass('d-none');
                    //$("#success-msg").addClass('d-none');
                    alert("Document Added Successfully");
                    window.location.href = "{{ url(Request::url()) }}";
                    //$("#mydiv").load(location.href + " #mydiv");


                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#view_doc').hide();
            $('#show_comments').hide();
        });

        $('#show_view_doc_options').on('change', function() {

            var listvalue = $(this).val();
            //alert(listvalue);
            if (listvalue == 1) {
                $("#view_doc").show();
                $("#show_comments").show();
            } else if (listvalue == 2) {
                $("#view_doc").hide();
                $("#show_comments").hide();
            } else if (listvalue == '') {
                $("#view_doc").hide();
                $("#show_comments").hide();
            }
        });
    </script>
    <script>
        function displayFileName(labelId, inputId) {
            const label = document.getElementById(labelId);
            const input = document.getElementById(inputId);

            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = 'Upload Document'; // or 'Upload Photograph'
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function uploadFile(inputId, labelId, questionId, applicationId, courseId, documentType) {
            const input = document.getElementById(inputId);
            const label = document.getElementById(labelId);

            if (input.files.length > 0) {
                const file = input.files[0];
                const formData = new FormData();
                formData.append('file', file);
                formData.append('questionId', questionId);
                formData.append('applicationId', applicationId);
                formData.append('courseId', courseId);
                formData.append('documentType', documentType);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('upload-document-by-onsite-assessor') }}", // Your server route
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.error) {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Invalid file extension',
                                text: response.error,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            label.textContent = 'Invalid file extension';
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Success',
                                text: 'File uploaded successfully', // Update this with the actual success message
                                showConfirmButton: false,
                                timer: 3000
                            }).then(() => {
                                window.location.reload();
                            });

                        }

                        // You can handle the response from the server here if needed
                    },
                    error: function() {
                        label.textContent = 'File upload failed';
                        label.style.backgroundColor = "red";

                    }
                });
            }
        }
    </script>

    @include('layout.footer')
