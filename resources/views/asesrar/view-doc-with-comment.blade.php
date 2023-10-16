@include('layout.header')


<title>RAV Accreditation</title>

</head>

<body class="light">

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
        @include('layout.rightbar')
    </div>

    <section class="content">
        <div class="container-fluid">

            @if (Session::has('success'))
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: "{{ session::get('success') }}",
                        showConfirmButton: false,
                        timer: 3000
                    })
                </script>
            @elseif(Session::has('fail'))
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: "{{ session::get('success') }}",
                        showConfirmButton: false,
                        timer: 3000
                    })
                </script>
            @endif
            @if (!get_doccomment_status($doc_id))
                <div class="row ">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12">
                            <div>
                                <div>
                                    <a href="{{ url('nationl-accesser') }}" type="button" class="btn btn-primary"
                                        style="float:right;">Back</a>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div>
                                    <form method="post" action="{{ url('add-accr-comment-view-doc') }}">
                                        @csrf
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="card project_widget">
                                                    <div class="card-header">
                                                        <h4>Create NC</h4>
                                                    </div>
                                                    <div class="body">


                                                        @if (in_array(get_doccomment_status($doc_id), [1, 2]))
                                                            <h4 class="text-center">
                                                                Document not approved - Rejected with
                                                                @if (get_doccomment_status($doc_id) == 1)
                                                                    NC1
                                                                @elseif (get_doccomment_status($doc_id) == 2)
                                                                    NC2
                                                                @endif
                                                            </h4>
                                                        @elseif (get_doccomment_status($doc_id) == 3)
                                                            <h4 class="text-center">
                                                                Document not approved and this document has been sent to
                                                                admin
                                                            </h4>
                                                        @elseif (get_doccomment_status($doc_id) == 4)
                                                            <h4 class="text-center">
                                                                Your Document has been approved
                                                            </h4>
                                                        @else
                                                            <input type="hidden" name="previous_url"
                                                                value="{{ Request::url() }}">
                                                            <input type="hidden" name="doc_id"
                                                                value="{{ $doc_id }}">
                                                            <input type="hidden" name="doc_code"
                                                                value="{{ $doc_code }}">
                                                            <input type="hidden" name="course_id"
                                                                value="{{ $course_id }}">
                                                            <div class="row">
                                                                @if ($doc_latest_record->notApraove_count == 1)
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <label>Select Type</label>
                                                                        <select required
                                                                            class="form-control required text-center"
                                                                            name="status" id="status">
                                                                            <option value="">--Select--</option>
                                                                            <option value="1">NC 1</option>
                                                                            <option value="4">Close</option>
                                                                        </select>
                                                                    </div>
                                                                @endif

                                                                @if ($doc_latest_record->notApraove_count == 2)
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <label>Select Type</label>
                                                                        <select required
                                                                            class="form-control required text-center"
                                                                            name="status" id="status">
                                                                            <option value="">--Select--</option>
                                                                            <option value="2">NC 2</option>
                                                                            <option value="4">Close</option>
                                                                        </select>
                                                                    </div>
                                                                @endif

                                                                @if ($doc_latest_record->notApraove_count >= 3)
                                                                    <div class="col-sm-12 col-md-4">
                                                                        <label>Select Type</label>
                                                                        <select required
                                                                            class="form-control required text-center"
                                                                            name="status" id="status">
                                                                            <option value="">--Select--</option>
                                                                            <option value="4">Close</option>
                                                                            <option value="3">Not Recommended
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                @endif

                                                                <div class="col-sm-12" id="comment-section">
                                                                    <label>Add Comment</label>
                                                                    <textarea rows="10" cols="60" id="comment_text" name="doc_comment" class="form-control"></textarea>
                                                                </div>
                                                            </div>


                                                        @endif
                                                    </div>

                                                    <div class="card-footer">
                                                        <input type="submit" value="Add Comment"
                                                            class="btn btn-primary">
                                                    </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        @if (in_array(get_doccomment_status($doc_id), [1, 2]))
                    <h4 class="text-center">
                        Document not approved - Rejected with
                        @if (get_doccomment_status($doc_id) == 1)
                            NC1
                        @elseif (get_doccomment_status($doc_id) == 2)
                            NC2
                        @endif
                    </h4>
                @elseif (get_doccomment_status($doc_id) == 3)
                    <h4 class="text-center">
                        Document not approved and this document has been sent to
                        admin
                    </h4>
                @elseif (get_doccomment_status($doc_id) == 4)
                    <h4 class="text-center">
                        Your Document has been approved
                    </h4>
                @else
                    Something went wrong! Please contact administrator.
                @endif
                    </div>
                </div>
            @endif
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
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-sort="ascending"
                                                        aria-label=" No : activate to sort column descending"> User
                                                    </th>

                                                    <th class="center sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1"
                                                        aria-label=" Name : activate to sort column ascending">Date
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>




                                                @foreach ($comment as $key => $comments)
                                                    <tr class="gradeX odd ">

                                                        <td class="center sorting_1">{{ ++$key }}</td>
                                                        <td class="center"><a><b>{{ $comments->comments }}</b></a>
                                                        </td>


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
                {{-- <a style="line-height:2;" type="button" class="btn btn-secondary" href="{{ url('nationl-accesser')}}">Back To Documents</a> --}}
            </div>
        </div>



    </section>

    <section class="content" style="margin-top: 5px !important;">
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

    <script>
        document.getElementById("status").addEventListener("change", function() {
            var comment_text = document.getElementById("comment_text");
            var commentSection = document.getElementById("comment-section");
            if (this.value === "4") { // If "Close" is selected
                comment_text.value = "Document has been approved";
                commentSection.style.display = "none"; // Hide the textarea
            } else {
                commentSection.style.display = "block"; // Show the textarea for other options
                comment_text.value = "Document Not approved!";
            }
        });
    </script>

    @include('layout.footer')
