@include('layout.header')


<title>RAV Accreditation</title>

</head>

<body class="light">
    <div class="overlay"></div>

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

    </div>


    <section class="content">
        <div class="container-fluid">

            @if (Session::has('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('success') }}',
                    });
                </script>
            @elseif (Session::has('fail'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '{{ session('fail') }}',
                    });
                </script>
            @endif

            <div class="row ">

                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">

                        <div class="tab-content">

                            <div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        @if ($doc_latest_record)
                                            @if ($doc_latest_record->notApraove_count >= 3)
                                                @if (isset($docByAdmin))
                                                    @if ($docByAdmin->status == 3)
                                                        <div class="card">
                                                            <div class="card-body text-center">
                                                                <h3>
                                                                    This document is rejected by admin. This document is
                                                                    currently blocked.
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if (isset($doc_latest_record->comment))
                                                        @if ($doc_latest_record->comment->status == 3)
                                                            <div class="card project_widget">
                                                                <div class="body">
                                                                    <h4>Create NC</h4>
                                                                    <div>
                                                                        <form method="post"
                                                                            action="{{ url('add-accr-comment-view-doc') }}"
                                                                            id="adminNcForm">
                                                                            @csrf
                                                                            <input type="hidden" name="previous_url"
                                                                                value="{{ Request::url() }}">
                                                                            <input type="hidden"
                                                                                value="{{ $doc_id }}"
                                                                                name="doc_id">
                                                                            <input type="hidden"
                                                                                value="{{ $doc_code }}"
                                                                                name="doc_code">
                                                                            <input type="hidden"
                                                                                value="{{ $course_id }}"
                                                                                name="course_id">

                                                                                <input type="hidden" name="application_id" value="{{ $app_id }}">
                                                                <input type="hidden" name="question_id" value="{{ Request()->segment(6) }}">
                                                                <input type="hidden" name="application_course_id" value="{{ Request()->segment(5) }}">

                                                                <input type="hidden" name="assessor_id" value="{{ $assesor_id }}">
                                                                <input type="hidden" name="doc_path" value="{{ Request()->segment(3) }}">
                                                                <input type="hidden" name="assesor_type" value="admin">

                                                                            <div class="row">
                                                                                <div class="col-sm-12 col-md-4">
                                                                                    <label
                                                                                        for="show-view-doc-options">Status</label>
                                                                                    <select required
                                                                                        class="form-control text-center"
                                                                                        id="show-view-doc-options"
                                                                                        name="status">
                                                                                        <option value="">Select
                                                                                            status
                                                                                        </option>
                                                                                        <option value="4">Approved
                                                                                        </option>
                                                                                        <option value="3">Not
                                                                                            Approved
                                                                                        </option>
                                                                                        <option value="5">Request
                                                                                            for final approval</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-sm-12"
                                                                                    id="doc-comment-textarea">
                                                                                    <label
                                                                                        for="show-view-doc-options1">Write
                                                                                        comment</label>
                                                                                    <textarea rows="10" cols="60" name="doc_comment" class="form-control" id="doc_comment_textarea" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <input id="adminSubmitBtn" type="submit"
                                                                                value="Submit" class="btn btn-primary">
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @else
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

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-hover " role="grid"
                                            aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="center sorting sorting_asc" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label=" No : activate to sort column descending"> S.No.
                                                    </th>
                                                    <th class="center sorting sorting_asc" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label=" No : activate to sort column descending"> Comments
                                                    </th>

                                                    <th class="center sorting sorting_asc" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label=" No : activate to sort column descending"> User
                                                    </th>
                                                    <th>Status Code</th>

                                                    <th class="center sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-label=" Name : activate to sort column ascending">Date
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>




                                                @foreach ($comment as $key => $comments)
                                                    <tr class="gradeX odd ">
                                                        <td class="center sorting_1">{{ ++$key }}</td>
                                                        <td class="center"><a><b>{{ $comments->comments }}</b></a></td>

                                                        <td class="center"><a><b>
                                                                    @if (get_role($comments->user_id) == 1)
                                                                        {{ get_admin_comments($comments->user_id) }} (
                                                                        Admin )
                                                                    @elseif(get_role($comments->user_id) == 3)
                                                                        {{ get_admin_comments($comments->user_id) }} (
                                                                        Assessor )
                                                                    @endif
                                                                </b></a></td>
                                                        <td>
                                                            @if ($comments->status == 1)
                                                                NC1
                                                            @elseif($comments->status == 2)
                                                                NC2
                                                            @elseif($comments->status == 3)
                                                            Needs Revision
                                                            @elseif($comments->status == 4)
                                                                Approved
                                                            @elseif($comments->status == 5)
                                                                Final Request Approval
                                                            @elseif($comments->status == 6)
                                                                NC3
                                                            @else
                                                                Not Found!
                                                            @endif
                                                        </td>
                                                        <td class="center">
                                                            <a>{{ date('d F Y', strtotime($comments->created_at)) }}</a>
                                                        </td>
                                                    </tr>
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

    </section>

    <section class="content" style="margin-top: 10px !important;">
        <div class="container-fluid">


            @if (Session::has('sussess'))
                <div class="alert alert-success" role="alert">
                    {{ session::get('sussess') }}
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
                            <div role="tabpanel" class="tab-pane active" id="level_information"
                                aria-expanded="true">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget">

                                            <div class="body">

                                                <object data="{{ url('level' . '/' . $id) }}" type="application/pdf"
                                                    width="100%" height="500px">
                                                    <p>Unable to display PDF file. <a
                                                            href="{{ url('level' . '/' . $id) }}">Download</a>
                                                        instead.
                                                    </p>
                                                </object>

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
    <script src="{{ asset('admin-assets/js/admin-js-script.js') }}"></script>
    @include('layout.footer')
