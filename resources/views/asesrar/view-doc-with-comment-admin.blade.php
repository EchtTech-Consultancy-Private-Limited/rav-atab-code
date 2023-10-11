@include('layout.header')


<title>RAV Accreditation</title>

</head>

<body class="light">
    <!-- Page Loader -->
    {{-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{asset('assets/images/favicon.png')}}" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div> --}}
    <!-- #END# Page Loader -->
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



    </div>


    <section class="content">
        <div class="container-fluid">


            @if (Session::has('success'))
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

                            <div>
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">

                                        @isset($doc_latest_record)


                                            @if ($doc_latest_record->notApraove_count >= 3)
                                                @if(isset($docByAdmin))
                                                    @if ($docByAdmin->status == 3)
                                                    <div class="card">
                                                        <div class="card-body text-center">
                                                            <h3>
                                                               This document is rejected by admin. This document is currently blocked.
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
                                                                        action="{{ url('add-accr-comment-view-doc') }}">
                                                                        @csrf
                                                                        <input type="hidden" name="previous_url"
                                                                            value="{{ Request::url() }}">
                                                                        <input type="hidden"
                                                                            value="{{ $doc_id }}" name="doc_id">
                                                                        <input type="hidden"
                                                                            value="{{ $doc_code }}" name="doc_code">
                                                                        <input type="hidden"
                                                                            value="{{ $course_id }}"
                                                                            name="course_id">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-md-4">
                                                                                <label
                                                                                    for="show-view-doc-options">Status</label>
                                                                                <select required
                                                                                    class="form-control text-center"
                                                                                    id="show-view-doc-options"
                                                                                    name="status">
                                                                                    <option value="">Select status
                                                                                    </option>
                                                                                    <option value="4">Approved
                                                                                    </option>
                                                                                    <option value="3">Not Approved
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-sm-12"
                                                                                id="doc-comment-textarea">
                                                                                <label for="show-view-doc-options1">Add
                                                                                    Comment</label>
                                                                                <textarea rows="10" cols="60" name="doc_comment" class="form-control" id="show-view-doc-options1"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <input type="submit" value="Add Comment"
                                                                            class="btn btn-primary">
                                                                    </form>
                                                                </div>

                                                            </div>

                                                        </div>

                                                    @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endisset
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
                                        <table
                                            class="table table-hover js-basic-example contact_list dataTable no-footer"
                                            id="DataTables_Table_0" role="grid"
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

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title"></h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Display file</li>
                        </ul>
                    </div>
                </div>
            </div>

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
                            <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget">

                                            <div class="body">

                                                <object data="{{ url('level' . '/' . $id) }}" type="application/pdf"
                                                    width="100%" height="500px">
                                                    <p>Unable to display PDF file. <a
                                                            href="{{ url('level' . '/' . $id) }}">Download</a> instead.
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



    <br><br><br><br><br><br><br><br>
    <script>
        $(document).ready(function() {
            $('#doc-comment-textarea').hide();

        });

        $('#show-view-doc-options').on('change', function() {

            var listvalue = $(this).val();
            // alert(listvalue);
            if (listvalue == 2) {
                $('#doc-comment-textarea').show();
            } else if (listvalue == 1) {
                $('#doc-comment-textarea').hide();
            } else if (listvalue == 0) {
                $('#doc-comment-textarea').show();
            } else if (listvalue == 3) {
                $('#doc-comment-textarea').show();
            } else if (listvalue == '') {
                $('#doc-comment-textarea').hide();
            }


        });
    </script>
    <script>
        $('#show-view-doc-options1').bind('input', function() {
            var c = this.selectionStart,
                r = /[^a-z0-9 .]/gi,
                v = $(this).val();
            if (r.test(v)) {
                $(this).val(v.replace(r, ''));
                c--;
            }
            this.setSelectionRange(c, c);
        });
    </script>
    @include('layout.footer')
