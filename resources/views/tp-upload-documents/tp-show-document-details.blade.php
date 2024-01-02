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


            @if (Session::has('sussess'))
                <div class="alert alert-success" role="alert">
                    {{ session::get('sussess') }}
                </div>
            @elseif(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('fail') }}
                </div>
            @endif

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
                                    <th>Added By</th>
                                    <th>Created At</th>
                                </thead>
                                <tbody>
                                    @isset($remarks)
                                        @foreach($remarks as $k=>$remark)
                                    
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$remark->comments}}</td>
                                            <td>
                                            {{ $remark->firstname ?? '' }}
                                                {{ $remark->middlename ?? '' }}
                                                {{ $remark->lastname ?? '' }}
                                            </td>
                                            <td>
                                                {{ date('m-d-Y',strtotime($remark->created_at))}}
                                            </td>
                                        </tr>
                                    @endforeach
                                 @endisset
                            
                                </tbody>
                            </table>
                        </div>
                    </div>


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
