@include('layout.header')


<title>RAV Accreditation</title>

<style>
    .remarkTable th,
    td {
        padding: 10px !important;
    }
</style>

</head>

<body class="light">

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
                <div class="alert alert-success" role="alert">
                    {{ session::get('success') }}
                </div>
            @elseif(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('fail') }}
                </div>
            @endif

            @if($is_form_view)
            <div class="card">
                        <div class="card-header bg-white text-dark">
                            <h5 class="mt-2">
                                Remark Form
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="container">
                            <div class="row">
                                <div class="col-md-12 p-3">
                                <form action="{{url('tp-submit-remark')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="assessor_type" value="{{$assessor_type}}">
                                    <input type="hidden" name="doc_sr_code" value="{{$doc_id}}">
                                    <input type="hidden" name="application_id" value="{{$application_id}}">
                                    <input type="hidden" name="doc_unique_id" value="{{$doc_code}}">
                                    <input type="hidden" name="application_course_id" value="{{$application_course_id}}">
                                    <input type="hidden" name="nc_type" value="{{$nc_type}}">
                                    <div class="form-group">
                                        <label for="tp_remark">Remark(<span class="text-danger">*</span>)</label>
                                        <input type="text" class="form-control remove_err" id="tp_remark"  name ="tp_remark" aria-describedby="tp_remark" placeholder="Please Enter Remark." required maxlength="100" >
                                        <span class="err remove_err" id="tp_remark_err"></span>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="tp_remark_sb_btn">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                @endif

                @isset($remarks)
                    <div class="card">
                        <div class="card-header bg-white text-dark">
                            <h5 class="mt-2">
                                Remark History
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover remarkTable mb-0">
                                <thead>
                                    <th>Sr.No</th>
                                    <th>Remark</th>
                                    <th>Username</th>
                                    <th>Created At</th>
                                </thead>
                                <tbody>
                                   
                                        <tr>
                                            <td>1</td>
                                            <td>{{$remarks->tp_remark}}</td>
                                            <td>
                                            {{ Auth::user()->firstname ?? '' }}
                                                {{ Auth::user()->middlename ?? '' }}
                                                {{ Auth::user()->lastname ?? '' }}
                                            </td>
                                            <td>
                                                {{ date('d-m-Y',strtotime($remarks->created_at))}}
                                            </td>
                                        </tr>
                               
                            
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endisset


            <div class="row ">

                <div class="row clearfix">

                    <div class="col-lg-12 col-md-12">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card project_widget p-0">

                                            <div class="body p-0">

                                                <object data="{{ url($doc_path) }}" type="application/pdf"
                                                    width="100%" height="1150px">
                                                    <p>Unable to display PDF file. <a
                                                            href="{{ url($doc_path) }}">Download</a> instead.
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
        $(document).ready(function() {
            $('#remark').on('input', function() {
                // Get the current character count
                let currentCharCount = $(this).val().length;

                // Update the character count
                $('#charCount').text(currentCharCount + ' characters');

                // Check if the character limit is exceeded
                if (currentCharCount > 100) {
                    // Trim the text to the maximum allowed characters (100)
                    $(this).val($(this).val().substring(0, 100));
                    $('#charLimitWarning').text('Character limit reached');
                } else {
                    $('#charLimitWarning').text(''); // Clear the warning message
                }
            });

            $('#remarkForm').submit(function(event) {
                // Reset any previous validation messages
                $('.text-danger').remove();

                // Validate the Remark field
                let remark = $('#remark').val();
                if (remark.length === 0) {
                    event.preventDefault();
                    $('#remark').after('<span class="text-danger">Remark is required</span>');
                }
            });
        });
    </script>
    @include('layout.footer')
