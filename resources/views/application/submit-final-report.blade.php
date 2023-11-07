@include('layout.header')
<title>RAV Accreditation</title>

<style>
    .txtBold {
        font-weight: bold;
    }
</style>

</head>

<body class="light">
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    @include('layout.topbar')
    <div>
        @if (Auth::user()->role == 1)
            @include('layout.sidebar')
        @elseif(Auth::user()->role == 2)
            @include('layout.siderTp')
        @elseif(Auth::user()->role == 3)
            @include('layout.sideAss')
        @elseif(Auth::user()->role == 4)
            @include('layout.sideprof')
        @elseif(Auth::user()->role == 5)
            @include('layout.secretariat')
        @elseif(Auth::user()->role == 6)
            @include('layout.sidbarAccount')
        @endif
        @include('layout.rightbar')
    </div>
    <section class="content">
        <div>
            <div>
                <h5>Application Summary</h5>
            </div>
        </div>
        @if ($applicationData->gps_pic == "" || $applicationData->gps_pic == null || $applicationData->final_remark == "" || $applicationData->final_remark == null)
        <div class="card mt-4">
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                    Submit Report
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="txtBold">Application ID</label><br>
                            {{ $applicationData->application_uid }}
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <form action="{{ url('submit-final-report/' . $applicationData->id) }}" method="post"
                            enctype="multipart/form-data" id="finalReportForm">
                            @csrf
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea name="remark" class="form-control" id="remark" placeholder="Write remarks..." maxlength="500">{{ old('remark') }}</textarea>
                                <span id="charCount" class="text-muted">500 characters remaining</span><br />
                                <span id="charLimitWarning" class="text-danger"></span>
                                <!-- Added warning message element -->
                                @error('remark')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="gps_pic" class="txtBold">Upload GPS Location Picture</label><br>
                                <input type="file" name="gps_pic" id="gps_pic" required><br/>
                                <span id="gps_pic_error" class="text-danger"></span>
                                <!-- Define the error element here -->
                                @error('gps_pic')
                                    <span class="text-danger" id="gps_pic_server_side_error_msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <button class="btn btn-primary btn-sm" type="submit" id="submitBtn">
                                    <i class="fa fa-paper-plane"></i> Submit Final Report
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <i class="fas fa-check-circle fa-5x text-success"></i>
                    <h5 class="mt-3">Report Successfully Submitted</h5>
                </div>
            </div>
        </div>
        
        @endif
       
    </section>

    <script>
        $(document).ready(function() {
            $('#remark').on('input', function() {
                let charCount = 500 - $(this).val().length;
                $('#charCount').text(charCount + ' characters remaining');

                if (charCount <= 0) {
                    $('#charLimitWarning').text('Character limit reached').removeClass().addClass(
                        'text-primary');

                    // Automatically hide the message after 5 seconds
                    setTimeout(function() {
                        $('#charLimitWarning').text('');
                    }, 5000);
                } else {
                    $('#charLimitWarning').text(''); // Clear the warning message
                }
            });

            $('#finalReportForm').submit(function(event) {
                // Reset any previous validation messages
                $('.text-danger').remove();

                // Validate the Remark field
                let remark = $('#remark').val();
                if (remark.length > 500) {
                    event.preventDefault();
                    $('#remark').after(
                        '<span class="text-danger">Remark cannot exceed 500 characters</span>');
                }
            });

            // Add an event listener to the file input for immediate feedback
            $('#gps_pic').on('change', function() {
                let gpsPic = $(this).val();
                if (!gpsPic) {
                    $('#gps_pic_error').text('GPS Location Picture is required');
                } else {
                    // Check the file extension
                    let allowedExtensions = ['jpg', 'jpeg', 'png'];
                    let fileExtension = gpsPic.split('.').pop().toLowerCase();
                    if (allowedExtensions.indexOf(fileExtension) === -1) {
                        Swal.fire({
                            icon: 'error',
                            title: "Invalid File Extension",
                            text: 'Allowed file extensions are .jpg, .jpeg, and .png'
                        });
                        $('#gps_pic_error').text('Allowed file extensions are .jpg, .jpeg, and .png');
                    }else{
                        $('#gps_pic_error').text('');
                        $('#gps_pic_server_side_error_msg').text('');
                    }
                }
            });
        });
    </script>
    @include('layout.footer')
