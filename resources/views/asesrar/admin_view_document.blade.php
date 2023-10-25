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
                        <div class="d-flex justify-content-end">
                            <a href="{{ URL::previous() }}" class="btn btn-primary">Go Back </a>
                        </div>
                        <div class="header">


                            @if (check_acknowledgement($course_id) == $course_id)
                                <a class="btn btn-danger">Final Approval Done</a>
                            @else
                                @if (count_document_record($course_id) == 44)
                                    <a href="{{ url('document-report-by-admin/' . $course_id) }}"
                                        class="btn btn-primary">Final Approval</a>
                                @else
                                    <a class="btn btn-danger">All Document Not Uploaded</a>
                                @endif
                            @endif


                            <a style="float:right;margin:10px;"
                                href="{{ url('document-report-verified-by-assessor/' . $application_id . '/' . $course_id) }}"
                                class="btn btn-info"> Verified Report</a>

                            <a style="float:right;margin:10px;"
                                href="{{ url('document-comment-admin-assessor/' . $course_id) }}"
                                class="btn btn-success">Assessor & Admin Conversation</a>
                        </div>
                        <div>
                            <div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget">

                                            @if (isset($check_admin))


                                                @if ($message = Session::get('success'))
                                                    <div class="alert alert-success">
                                                        <p>{{ $message }}</p>
                                                    </div>
                                                @endif
                                                <div id="success-msg" class="alert alert-success d-none" role="alert">
                                                    <p class=" msg-none ">Documents Update Successfully</p>
                                                </div>
                                                <!-- table-striped  -->
                                                <div class="table-responsive" style="margin-top:-10px;">


                                                    <table class="table table-hover js-basic-example contact_list">
                                                        <thead>
                                                            <tr>
                                                                <th class="center">#Sr.N0</th>
                                                                <th class="center">Objective criteria</th>
                                                                <!--  <th class="center" style="white-space: nowrap;width:85px;">Yes / No</th> -->
                                                                <th class="center">View Documents</th>
                                                                <!--  <th>Comments</th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">

                                                            @foreach ($chapters as $chapter)
                                                                <tr>
                                                                    <th colspan="3" class="text-justify">
                                                                        <h3 class="text-center">
                                                                            {{ $chapter->title ?? '' }}</h3>
                                                                    </th>
                                                                </tr>
                                                                @foreach ($chapter->questions as $question)
                                                                    <tr>
                                                                        <td>{{ $question->code ?? '' }}</td>
                                                                        <td>{{ $question->title ?? '' }}</td>
                                                                        <td>
                                                                            @php
                                                                                $documentsData = getAdminDocument($question->id, $file[0]->application_id) ?? 0;
                                                                            @endphp
                                                                            @if (count($documentsData) > 0)
                                                                                <div class="d-flex">
                                                                                    @if (count($documentsData) <= 1)
                                                                                        @foreach ($documentsData as $doc)
                                                                                            @if ($doc->application_id == $application_id)
                                                                                                <a target="_blank"
                                                                                                    title="{{ checkDocumentCommentStatusreturnText($doc->id) }}"
                                                                                                    href="{{ url('admin-view-doc' . '/' .$doc->doc_id . '/' . $doc->doc_file . '/' . $doc->id . '/' . $course_id) }}"
                                                                                                    class="btn text-white {{ checkDocumentCommentStatus($doc->id) }}"
                                                                                                    style="color: #fff ;margin:10px;"
                                                                                                    id="view_doc1">{{ getButtonText($doc->id) ?? '' }}</a>
                                                                                            @else
                                                                                                <span
                                                                                                    class="bg-danger p-2 text-white"
                                                                                                    style="border-radius: 5px;  font-size:12px;">
                                                                                                    Documents not
                                                                                                    uploaded
                                                                                                </span>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @else
                                                                                        @foreach ($documentsData as $doc)
                                                                                            @if ($doc->application_id == $application_id)
                                                                                                <a target="_blank"
                                                                                                    title="{{ checkDocumentCommentStatusreturnText($doc->id) }}"
                                                                                                    href="{{ url('admin-view-doc' . '/' . $doc->doc_id . '/' . $doc->doc_file . '/' . $doc->id . '/' . $course_id) }}"
                                                                                                    class="btn text-white {{ checkDocumentCommentStatus($doc->id) }}"
                                                                                                    style="color: #fff ;margin:10px;"
                                                                                                    id="view_doc1">{{ getButtonText($doc->id) ?? '' }}</a>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                </div>
                                                                            @else
                                                                                <span class="bg-danger p-2 text-white"
                                                                                    style="border-radius: 5px; font-size:12px;">
                                                                                    Documents not uploaded
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endforeach
                                                        </tbody>
                                                    </table>



                                                </div>
                                            @else
                                                <h3 class="text-center">You dont have any document</h3>
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
