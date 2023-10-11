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
                                            <!-- <div class="header">
                                                <h2>Upload Document</h2>

                                                <form method="post" action="{{ url('upload-document') }}"
                                                    id="regForm" enctype="multipart/form-data">

                                                    @csrf
                                                    <div class="body">
                                                        <div class="row clearfix">
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label>document type<span
                                                                                class="text-danger">*</span></label>
                                                                        <select name="document_type_id" required
                                                                            class="form-control" id="title">
                                                                            <option value="">Select Type </option>
                                                                            <option value="Infrastructure Details">
                                                                                Infrastructure Details</option>
                                                                            <option
                                                                                value="Re-evaluation of unsuccessful candidates">
                                                                                Re-evaluation of unsuccessful candidates
                                                                            </option>
                                                                            <option
                                                                                value="Details of Manpower along with Qualification and Experience">
                                                                                Details of Manpower along with
                                                                                Qualification and Experience</option>
                                                                            <option
                                                                                value="Details of outsourced facilities">
                                                                                Details of outsourced facilities
                                                                            </option>
                                                                            <option value="Lists of courses applid for">
                                                                                Lists of courses applid for</option>
                                                                            <option value="Detailed syllabus">Detailed
                                                                                syllabus</option>
                                                                            <option value="Exam pattern">Exam pattern
                                                                            </option>
                                                                            <option value="Policy and procedures">Policy
                                                                                and procedures</option>
                                                                        </select>
                                                                    </div>

                                                                    <label for="title" id="title-error"
                                                                        class="error"></label>

                                                                </div>
                                                            </div>


                                                            <input type="hidden" name="application_id" value="{{ $data[0]->application_id }}">
                                                            <input type="hidden" name="level_id" value="{{ $data[0]->level_id }}">



                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <label class="active">Upload pdf<span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="file" required
                                                                            class="special_no valid form-control"
                                                                            name="file">
                                                                    </div>


                                                                    <label for="lastname" id="lastname-error"
                                                                        class="error" style="display: none;">
                                                                    </label>

                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12 p-t-20 text-center">
                                                                <button type="submit"
                                                                    class="btn btn-primary waves-effect m-r-10">Submit</button>
                                                                <a href="http://localhost/Accreditation/rav-accr/public/dashboard"
                                                                    class="btn btn-danger waves-effect">Back</a>

                                                            </div>
                                                        </div>
                                                </form>
                                            </div>

                                            <hr> -->



                                            @if ($message = Session::get('success'))
                                                <div class="alert alert-success">
                                                    <p>{{ $message }}</p>
                                                </div>
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
                                                                            <span class="badge bg-danger text-white">Documents not uploaded</span>
                                                                        @else
                                                                            @if ($question->documents)
                                                                                @if (count($question->documents) == 1)
                                                                                    @foreach ($question->documents as $doc)
                                                                                    @if ($doc->application_id == $application_id)
                                                                                    <div>
                                                                                        <a class="btn btn-primary btn-sm" target="_blank"
                                                                                        href="{{ url('view-doc' . '/' . __('arrayfile.document_doc_id_chap1')[1] . '/' . $doc->doc_file . '/' . $doc->id . '/' . $course_id) }}">View
                                                                                        Document</a>
                                                                                    </div>
                                                                                    @else
                                                                                    <span class="badge bg-danger text-white">Documents not uploaded</span>
                                                                                    @endif
                                                                                    @endforeach
                                                                                @elseif (count($question->documents) > 1)
                                                                                    <div class="d-flex">
                                                                                        @foreach ($question->documents as $doc)
                                                                                        @if ($doc->application_id == $application_id)
                                                                                            <a target="_blank"
                                                                                            href="{{ url('view-doc' . '/' . __('arrayfile.document_doc_id_chap1')[1] . '/' . $doc->doc_file . '/' . $doc->id . '/' . $course_id) }}"
                                                                                            class="btn btn-sm @if (get_doccomment_status($doc->id) == 1) btn-warning @elseif (get_doccomment_status($doc->id) == 2) btn-warning @elseif (get_doccomment_status($doc->id) == 3) btn-danger @elseif (get_doccomment_status($doc->id) == 4) btn-success
                                                                                                @elseif (get_doccomment_status($doc->id) == 0)
                                                                                                    btn-primary
                                                                                                @endif"
                                                                                            style="color: #fff; margin: 10px;"
                                                                                            id="view_doc1"
                                                                                            title="@if (get_doccomment_status($doc->id) == 1) NC1 @elseif (get_doccomment_status($doc->id) == 2) NC2 @elseif (get_doccomment_status($doc->id) == 3) Not Recommended @elseif (get_doccomment_status($doc->id) == 4) Document Approved @endif">V{{ $loop->iteration }}</a>
                                                                                        @endif
                                                                                        @endforeach
                                                                                    </div>
                                                                                @endif
                                                                            @else
                                                                                <span class="badge bg-danger text-white">Documents not uploaded</span>
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
