@include('layout.header')



<title>RAV Accreditation</title>

<style>
    .selectINputBox {
        padding: 8px !important;
        border: 1px solid #ccc !important;
        width: 300px !important;
    }

    table {
        /* caption-side: bottom; */
        border-collapse: collapse;
        /* border: 1px solid #ddd !important; */
        background: #fff;
        padding: 33px !important;
    }


    table th,
    table td,
    table tr {
        text-align: center;
        border: 1px solid #aaa !important;
        color: #000;
    } 
    table td {
        text-align: left;
        padding: 10px 10px;
        font-weight:700;
    }
</style>
</head>

<body class="light">



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

    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: "Success",
                text: "{{ $message }}",
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    @endif

    <section class="content">
        @if ($applicationData->gps_pic == null && $applicationData->final_remark == null)
        <form action="{{ url('add-final-remark-onsite') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="application_id" value="{{ $applicationData->id }}">
            <input type="hidden" name="course_id" value="{{ $courseDetail->id }}">
            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2">
                        Add Remark & Upload GPS Location Picture
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea name="remark" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="gps_pic">GPS Picture</label><br />
                        <input type="file" name="gps_pic" id="gps_pic" accept=".jpg, .jpeg, .png" required onchange="validateFile()">
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary mb-0">Submit</button>
                    </div>
                </div>
            </div>
        </form>
        @endif
       @if ($applicationData->gps_pic != null && $applicationData->final_remark != null)
       <div class="card">
        <form action="{{ url('save-on-site-report') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="application_id" value="{{ $applicationData->id }}">
            <input type="hidden" name="course_id" value="{{ $courseDetail->id }}">
            <div class="card-body">
                <table>

                    <tbody>
                        <tr>
                            <th colspan="6">FORM -2 - ONSITE ASSESSMENT FORM.</th>
                        </tr>
                        <tr>
                            <td colspan="3">Application No (provided by ATAB): <span>
                                    <input type="text" name="application_uid"
                                        value="{{ $applicationData->application_uid }}"></span>
                            </td>
                            <td colspan="3">Date of Application: <span> <input type="text"
                                        value="{{ \Carbon\Carbon::parse($applicationData->created_at)->format('d-m-Y') }}">
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">Name and Location of the Training Provider: <span>
                                    <input type="text" name="location_training_provider"
                                        value="{{ $applicationData->user->firstname . ' ' . $applicationData->user->middlename . ' ' . $applicationData->user->lastname }}({{ $applicationData->user->address }})">
                                </span>
                            </td>
                            <td colspan="3">Name of the course to be assessed:

                                <span> <input name="course_assessed" type="text"
                                        value="{{ $courseDetail->course_name }}"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">Way of assessment (onsite/ hybrid/ virtual): <span> <input
                                        type="text" name="way_of_desktop"
                                        value="{{ auth()->user()->assessorDetail->assessment_way ?? '' }}"></span>
                            </td>
                            <td colspan="2">No of Mandays: <span> <input type="text" name="mandays" value="{{ getMandays($applicationData->id, auth()->user()->id) }}"></span>
                            </td>
                        </tr>

                        <tr>
                            <td> Signature:</td>
                            <td> </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> Name</td>
                            <td> <input type="text" name="assessor"
                                    value="{{ auth()->user()->firstname . ' ' . auth()->user()->middlename . ' ' . auth()->user()->lastname }}">
                            </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> Team: <input type="text" name="team"></td>
                            <td colspan="2"> Team Leader: <input type="text" name="team_leader"></td>
                            <td> Assessor: <input type="text"
                                    value="{{ auth()->user()->firstname . ' ' . auth()->user()->middlename . ' ' . auth()->user()->lastname }}">
                            </td>
                            <td colspan="2"> Rep. Assessee Orgn: <input type="text" name="assess_org"></td>
                        </tr>
                        <tr>
                            <td colspan="6">Brief about the Opening Meeting: <input type="text"
                                    name="brief_opening_meeting"></td>
                        </tr>

                        <tr>
                            <td> Sl. No</td>
                            <td>Objective Element </td>
                            <td> NC raised</td>
                            <td> CAPA by Training Provider</td>
                            <td> Document submitted against the NC</td>
                            <td> Remarks (Accepted/ Not accepted)</td>
                        </tr>
                        @foreach ($chapters as $item)
                            <tr>
                                <td colspan="6">
                                    <div class="text-center ">
                                        <h5>
                                            {{ $item->title }}
                                        </h5>

                                    </div>
                                </td>
                            </tr>
                            @foreach ($item->questions as $question)
                                @php
                                    $comment = getDocumentComment($question->id, $applicationData->id, $courseDetail->id);
                                @endphp
                                @if ($comment)
                                    @if ($comment->status != 4)
                                        <tr>
                                            <td>
                                                <input type="text" value="{{ $question->code }}">
                                                <input type="hidden" name="question_ids[]"
                                                    value="{{ $question->id }}">
                                            </td>
                                            <td><input type="text" value="{{ $question->title }}"></td>
                                            <td>
                                                @php
                                                    $getNCRecords = getNCRecords($question->id,$courseDetail->id,$applicationData->id);
                                                @endphp
                                                <input type="text" name="nc_raised[]" value=" {{ $getNCRecords }}">
                                            </td>
                                            <td>
                                                @php
                                                    $getNCComments = getNCRecordsComments($question->id,$courseDetail->id,$applicationData->id);
                                                @endphp
                                                <input type="text" name="capa_training_provider[]" value="{{  $getNCComments }}">
                                            </td>
                                            <td>
                                                <input type="text" name="document_submitted_against_nc[]">
                                            </td>
                                            <td>
                                                <input type="text" name="remark[]">
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                        <tr>
                            <td colspan="5">
                                <textarea id cols="30" rows="2" placeholder="Brief Summary (4000 words) ----" name="summary1"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <textarea id cols="30" rows="2" placeholder="Brief about the Closing Meeting:" name="summary2"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date : <input type="date" name="date">
                            </td>
                            <td>
                                Signature 
                                <div style="padding-top: 10px;">
                                   ................
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
                <div class="d-flex justify-content-end mt-2">
                    <button class="btn btn-success">Next</button>
                </div>
            </div>
        </form>
    </div>
       @endif

    </section>


    <script>
        function validateFile() {
            var fileInput = document.getElementById('gps_pic');
            var filePath = fileInput.value;
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    
            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type. Please choose a JPG, JPEG, or PNG file.');
                fileInput.value = '';
            }
        }
    
        function validateForm() {
            var fileInput = document.getElementById('gps_pic');
            var filePath = fileInput.value;
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    
            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type. Please choose a JPG, JPEG, or PNG file.');
                fileInput.value = '';
                return false;
            }
    
            // Add additional validation if needed
    
            document.getElementById('remarkForm').submit();
        }
    </script>
    @include('layout.footer')
