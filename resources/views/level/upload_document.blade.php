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
                                <h4 class="page-title">Upload Documents</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Level </a>
                            </li>
                            <li class="breadcrumb-item active">Upload document</li>


                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <ul class="breadcrumb breadcrumb-style ">
                            <a href="{{ url()->previous() }}" type="button" class="btn btn-primary"
                                style="float:right;">Back To Documents</a>
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

            <div class="row ">

                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" aria-expanded="true">
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
                                            <div class="table-responsive mt-3">

                                                <table class="table table-hover js-basic-example contact_list">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">#S.N0</th>
                                                            <th class="center">Objective criteria</th>
                                                            <!--  <th class="center" style="white-space: nowrap;width:85px;">Yes / No</th> -->
                                                            <th class="center">Cross reference to supporting evidence
                                                                provided</th>
                                                            <th>Comments</th>
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
                                                                <tr>
                                                                    <td>{{ $question->code ?? '' }}</td>
                                                                    <td>{{ $question->title }}</td>
                                                                    <td>
                                                                            {{-- getting documents for each row --}}
                                                                                 @if ($question->documents->isEmpty())
                                                                                    <div>
                                                                                        <form name="submitform_doc_form" id="submitform_doc_form_{{ $question->id }}"
                                                                                            class="submitform_doc_form" enctype="multipart/form-data">
                                                                                            <input type="hidden" name="previous_url" value="{{ Request::url() }}">
                                                                                            <input type="hidden" name="application_id" value="{{ $file[0]->application_id }}">
                                                                                            <input type="hidden" name="course_id" value="{{ $course_id }}">
                                                                                            <input type="hidden" name="question_id" value="{{ $question->code }}">
                                                                                            <input type="file" class="from-control-input fileup" name="fileup" id="fileup_{{ $question->id }}" data-question-id="{{ $question->id }}" />
                                                                                        </form>
                                                                                    </div>
                                                                                @else
                                                                                     @if (count($question->documents) == 1)
                                                                                            @foreach ($question->documents as $doc)
                                                                                            <div class="d-flex">
                                                                                                <div>
                                                                                                    @if (get_doccomment_status($doc->id) == 1)
                                                                                                    <form name="submitform_doc_form" id="submitform_doc_form_{{ $question->id }}"
                                                                                                        class="submitform_doc_form" enctype="multipart/form-data">
                                                                                                        <input type="hidden" name="previous_url" value="{{ Request::url() }}">
                                                                                                        <input type="hidden" name="application_id" value="{{ $file[0]->application_id }}">
                                                                                                        <input type="hidden" name="course_id" value="{{ $course_id }}">
                                                                                                        <input type="hidden" name="question_id" value="{{ $question->code }}">
                                                                                                        <input type="file" class="from-control-input fileup" name="fileup" id="fileup_{{ $question->id }}" data-question-id="{{ $question->id }}" />
                                                                                                    </form>
                                                                                                    @endif
                                                                                                </div>
                                                                                                <a target="_blank" href="{{ url('show-pdf' . '/' . $doc->doc_file) }}" class="btn {{ get_doccomment_status($doc->id) == 1 ? 'btn-warning' : 'btn-primary' }}">View Document</a>
                                                                                            </div>
                                                                                            @endforeach
                                                                                        @elseif (count($question->documents) > 1)
                                                                                            @foreach ($question->documents as $doc)
                                                                                            <a target="_blank" href="{{ url('show-pdf' . '/' . $doc->doc_file) }}" class="btn {{ get_doccomment_status($doc->id) == 1 ? 'btn-warning' : 'btn-primary' }}">V{{ $loop->iteration  }}</a>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <div>
                                                                                                112<input type="file" class="from-control-input fileup" name="fileup" id="fileup" />
                                                                                            </div>
                                                                                     @endif
                                                                                @endif
                                                                             {{-- getting documents for each row end point --}}

                                                                    </td>
                                                                    <td></td>
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
    $(document).ready(function () {
    $('.fileup').change(function () {
        var fileInput = $(this);
        var questionId = fileInput.data('question-id');
        var form = $('#submitform_doc_form_' + questionId)[0];
        var formData = new FormData(form);

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
            success: function (response) {
                $("#loader").addClass('d-none');
                if(response.message == 'success'){
                    Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Upload Successful',
                            text: 'Your documents have been successfully uploaded.',
                            showConfirmButton: false,
                            timer: 1500
                        });


                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(error);
            }
        });
    });
});
</script>
    @include('layout.footer')
