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
                    <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <ul class="breadcrumb breadcrumb-style ">
                             <a href="{{ url()->previous() }}" type="button" class="btn btn-primary" style="float:right;">Back To Documents</a>
                        </ul>
                    </div> -->
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

            <div class="row ">

                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" aria-expanded="true">
                                <div class="row clearfix">
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <a href="{{ url('Assessor-view/' . dEncrypt($application_id)) }}"
                                            class="btn btn-primary btn-sm">Back</a>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div>
                                            @if (check_document_upload($course_id) == Auth::user()->id)
                                                <a href="{{ url('document-report-toadmin/' . $course_id) }}"
                                                    class="btn btn-primary">Send Document To Admin</a>
                                            @else
                                                <a href="#" class="btn btn-danger">Send Document To Admin</a>
                                            @endif

                                            <a style="float:right;"
                                                href="{{ url('document-comment-admin-assessor/' . $course_id) }}"
                                                class="btn btn-primary">History Log</a>

                                        </div>
                                        <div class="card project_widget">
                                            @if ($message = Session::get('success'))
                                                <script>
                                                    Swal.fire({
                                                        position: 'center',
                                                        icon: 'success',
                                                        title: "{{ $message }}",
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                    })
                                                </script>
                                            @endif
                                            <div id="success-msg" class="alert alert-success d-none" role="alert">
                                                <p class=" msg-none ">Documents Update Successfully</p>
                                            </div>
                                            <!-- table-striped  -->
                                            <div class="table-responsive mt-3">

                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">#S.N0</th>
                                                            <th class="center">Objective criteria</th>
                                                            <th class="center">View Documents</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
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
                                                                        @if ($question->documents->isEmpty())
                                                                            <span
                                                                                class="badge bg-danger text-white">Documents
                                                                                not uploaded</span>
                                                                        @else
                                                                            @if (count(getAssessorDocument($question->id, $application_id)) > 0)
                                                                                @php
                                                                                    $documentData = getAssessorDocument($question->id, $application_id);
                                                                                @endphp
                                                                                @if (count(getAssessorDocument($question->id, $application_id)) == 1)
                                                                                    @if (count(getAssessorComments($documentData[0]->id)))
                                                                                        <a class="btn {{ checkDocumentCommentStatus($documentData[0]->id) }}"
                                                                                            title="{{ checkDocumentCommentStatusreturnText($documentData[0]->id) }}"
                                                                                            target="_blank"
                                                                                            href="{{ url('view-doc' . '/' . __('arrayfile.document_doc_id_chap1')[1] . '/' . $documentData[0]->doc_file . '/' . $documentData[0]->id . '/' . $course_id) }}">View
                                                                                            Document</a>
                                                                                    @else
                                                                                        <a class="btn {{ checkDocumentCommentStatus($documentData[0]->id) }}"
                                                                                            title="{{ checkDocumentCommentStatusreturnText($documentData[0]->id) }}"
                                                                                            target="_blank"
                                                                                            href="{{ url('view-doc' . '/' . __('arrayfile.document_doc_id_chap1')[1] . '/' . $documentData[0]->doc_file . '/' . $documentData[0]->id . '/' . $course_id) }}">View
                                                                                            Document</a>
                                                                                    @endif
                                                                                @endif
                                                                                @if (count(getAssessorDocument($question->id, $application_id)) == 2)
                                                                                    @foreach ($documentData as $docItem)
                                                                                        <a class="btn {{ checkDocumentCommentStatus($docItem->id) }}"
                                                                                            title="{{ checkDocumentCommentStatusreturnText($docItem->id) }}"
                                                                                            target="_blank"
                                                                                            href="{{ url('view-doc' . '/' . __('arrayfile.document_doc_id_chap1')[1] . '/' . $docItem->doc_file . '/' . $docItem->id . '/' . $course_id) }}">V{{ $loop->iteration }}</a>
                                                                                    @endforeach
                                                                                @endif
                                                                                @if (count(getAssessorDocument($question->id, $application_id)) == 3)
                                                                                    @foreach ($documentData as $docItem)
                                                                                        <a class="btn {{ checkDocumentCommentStatus($docItem->id) }}"
                                                                                            title="{{ checkDocumentCommentStatusreturnText($docItem->id) }}"
                                                                                            target="_blank"
                                                                                            href="{{ url('view-doc' . '/' . __('arrayfile.document_doc_id_chap1')[1] . '/' . $docItem->doc_file . '/' . $docItem->id . '/' . $course_id) }}">V{{ $loop->iteration }}</a>
                                                                                    @endforeach
                                                                                @endif
                                                                            @else
                                                                                <span
                                                                                    class="badge bg-danger text-white">Documents
                                                                                    not uploaded</span>
                                                                            @endif
                                                                        @endif
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
    @include('layout.footer')
