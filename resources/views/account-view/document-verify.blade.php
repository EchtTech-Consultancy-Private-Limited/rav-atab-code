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
        @elseif(Auth::user()->role == '5')
        @include('layout.secretariat')
        @elseif(Auth::user()->role == '6')
        @include('layout.sidbarAccount')
        @endif
        @include('layout.rightbar')
    </div>

    <section class="content">
        <div>

            @if (Session::has('success'))
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: "Success",
                        text: "{{ session::get('success') }}",
                        showConfirmButton: false,
                        timer: 3000
                    })
                </script>
            @elseif(Session::has('fail'))
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: "Warning",
                        text: "{{ session::get('success') }}",
                        showConfirmButton: false,
                        timer: 3000
                    })
                </script>
            @endif
            
            @isset($nc_comments)
            @if($nc_comments->nc_type=="Request_For_Final_Approval")
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <!-- <strong>Ooh!</strong> Request sent already for final approval -->
            </div>
            @endif
            @endisset
            
            
        </div>
        </div>
        </div>
        </div>

        
        @if($nc_type!="view")
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="body">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table" id="DataTables_Table_0" role="grid"
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
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1"
                                                        aria-label=" Name : activate to sort column ascending">Date
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                  
                                                    @isset($nc_comments)
                                                    <tr class="gradeX odd ">
                                                        <td class="center sorting_1">1</td>
                                                        <td class="center">{{$nc_comments->comments}}
                                                        </td>
                                                        <td class="center">
                                                                  {{$nc_comments->firstname??''}} {{$nc_comments->middlename??''}}
                                                                  {{$nc_comments->lastname??''}} ({{$nc_comments->role==5?"Secretariat":"Super Admin"}})</td>

                                                        <td class="center">
                                                            <a>{{date('d-m-Y',strtotime($nc_comments->created_at))}}</a>
                                                        </td>
                                                    </tr>
                                                    @endisset
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
        @endif


    </section>

    <section class="content" style="margin-top: 5px !important;">
        <div>


            @if (Session::has('sussess'))
                <div class="alert alert-success" role="alert">
                    {{ session::get('sussess') }}
                </div>
            @elseif(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    {{ session::get('fail') }}
                </div>
            @endif



        </div>

        <div class="container">
            <div class="card project-widget">
                <div class="card-body">
                        <object data="{{$doc_path}}" type="application/pdf" width="100%" height="500px">
                            <p>Unable to display PDF. <a href="" target="_blank">Download
                                    Document</a> </p>
                        </object>
                </div>
            </div>
        </div>




    </section>

    <script>
        document.getElementById("status").addEventListener("change", function() {
            var comment_text = document.getElementById("comment_text");
            var commentSection = document.getElementById("comment-section");
            if (this.value == "Accept") { // If "Close" is selected
                comment_text.value = "Document has been approved";
                commentSection.style.display = "none"; // Hide the textarea

            } else if(this.value=="Request_For_Final_Approval"){
                commentSection.style.display = "block"; // Show the textarea for other options
                comment_text.value = "Request for Final Approval";
            } else{
                commentSection.style.display = "block"; // Show the textarea for other options
                comment_text.value = "Document Not approved!";
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("ncForm"); // Change this to your form's actual ID
            const submitBtn = document.getElementById("submitBtn"); // Change this to your button's actual ID

            form.addEventListener("submit", function() {
                submitBtn.disabled = true; // Disable the button when the form is submitted
            });
        });
    </script>

    <script>
        // Get a reference to the comment text area
        var commentTextArea = document.getElementById('comment_text');

        // Get a reference to the character count info
        var charCountInfo = document.getElementById('char-count-info');

        // Get a reference to the submit button
        var submitButton = document.getElementById('submitBtn');

        // Add an input event listener to the text area
        commentTextArea.addEventListener('input', function() {
            var currentCharCount = commentTextArea.value.length;

            // Update the character count info
            charCountInfo.textContent = currentCharCount + '/100 characters';

            // Check if the limit is reached
            // Check if the limit is reached
            if (currentCharCount > 100) {
                // Truncate the text to 100 characters
                commentTextArea.value = commentTextArea.value.substring(0, 100);
                charCountInfo.textContent = '100/100 characters (maximum reached)';
                charCountInfo.style.color = 'red'; // Set text color to red
                submitButton.disabled = true; // Disable the submit button
            } else {
                charCountInfo.style.color = '#000'; // Reset text color to the default
                submitButton.disabled = false; // Enable the submit button
            }
        });
    </script>

    @include('layout.footer')
