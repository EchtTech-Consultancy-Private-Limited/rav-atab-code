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

    table td {
        text-align: left;
        padding: 10px 10px;
    }

    table th, table td, table tr {
    text-align: center;
    border: 1px solid #aaa !important;
    color: #000;
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
        <div class="card">
           <form action="{{ url('save-on-site-report-improvment-form') }}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="application_id" value="{{ $applicationData->id }}">
            <input type="hidden" name="course_id" value="{{ $courseDetail->id }}"> 
            <div class="card-body">
                <table>

                    <tbody>
                        <tr>
                            <td colspan="4">
                                FORM -3 - OPPORTUNITY FOR IMPROVEMENT FORM
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Name and Location of the Training Provider: <input name="training_provider_name" type="text" value="{{ $applicationData->user->firstname . ' ' . $applicationData->user->middlename . ' ' . $applicationData->user->lastname }}({{ $applicationData->user->address }})"></td>
                            <td colspan="2">Name of the course  to be assessed:  <input type="text" name="course_name" value="{{ $courseDetail->course_name }} "></td>
                        </tr>
                        <tr>
                            <td colspan="2"> Way of assessment (onsite/ hybrid/ virtual): <input name="way_of_assessment" type="text" value="{{ $assessorDetail->assessment_way ?? '' }}"></td>
                            <td colspan="2"> No of Mandays: <input type="text" name="mandays" value="{{ getMandays($applicationData->id, auth()->user()->id) }}"></td>
                        </tr>
                        <tr>
                            <td>  S. No. </td>
                            <td> Opportunity for improvement Form</td>
                            <td colspan="2"> Standard reference</td>
                        </tr>
                        <tr>
                            <td> <input type="text" name="sr_no"> </td>
                            <td> <input type="text" name="opportunity_for_improvment"></td>
                            <td colspan="2"><input type="text" name="standard_reference"></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                
                        <tr>
                            <td> Signatures</td>
                            <td><input type="hidden" name="signature"> </td>
                            <td> </td>
                        </tr>
                
                        <tr>
                            <td>Assessor Name </td>
                            <td> <input type="text" name="name" value="{{ $assessorDetail->user->firstname.' '.$assessorDetail->user->middlename.' '.$assessorDetail->user->lastname }}"></td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> Team Leader</td>
                            <td> Assessor</td>
                            <td> Rep. Assessee Orgn.</td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> <input type="text" name="team_leader"></td>
                            <td> <input type="text" name="assessor_name" value="{{ $assessorDetail->user->firstname.' '.$assessorDetail->user->middlename.' '.$assessorDetail->user->lastname }}"></td>
                            <td> <input type="text" name="rep_assessee_orgn"></td>
                        </tr>
                        <tr>
                            <td colspan="2"> Date:</td>
                            <td colspan="2"> Signature of the Team Leader</td>
                
                        </tr>
                        <tr>
                            <td colspan="2"> <input type="date" name="date_of_submission"></td>
                            <td colspan="2"> </td>
                
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mt-2">
                    <button class="btn btn-success">Submit Report</button>
                </div>
            </div>
           </form>
        </div>
        
    </section>

   
    @include('layout.footer')
