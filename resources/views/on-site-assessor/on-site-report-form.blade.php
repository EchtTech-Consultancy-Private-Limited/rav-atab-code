@include('layout.header')



<title>RAV Accreditation</title>

<style>
    .selectINputBox {
        padding: 8px !important;
        border: 1px solid #ccc !important;
        width: 300px !important;
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
            <div class="card-body">
                <table>

                    <tbody>
                        <tr>
                            <td colspan="6">FORM -2 - ONSITE ASSESSMENT FORM.</td>
                        </tr>
                        <tr>
                            <td colspan="3">Application No (provided by ATAB): <span> <input type="text"></span>
                            </td>
                            <td colspan="3">Date of Application: <span> <input type="text"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">Name and Location of the Training Provider: <span> <input type="text"></span>
                            </td>
                            <td colspan="3">Name of the course  to be assessed:
        
                                 <span> <input type="text"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">Way of assessment (onsite/ hybrid/ virtual): <span> <input type="text"></span>
                            </td>
                            <td colspan="2">No of Mandays: <span> <input type="text"></span>
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
                            <td>  </td>
                            <td> </td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> Team: <input type="text"></td>
                            <td colspan="2"> Team Leader: <input type="text"></td>
                            <td> Assessor: <input type="text"></td>
                            <td colspan="2"> Rep. Assessee Orgn: <input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="6">Brief about the Opening Meeting: <input
                                    type="text"></td>
                        </tr>
        
                        <tr>
                            <td> Sl. No</td>
                            <td>Objective Element </td>
                            <td> NC raised</td>
                            <td> CAPA by Training Provider</td>
                            <td> Remarks (Accepted/ Not accepted)</td>
                            <td> Remarks (Accepted/ Not accepted)</td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <textarea name id cols="30" rows="2"
                                    placeholder="Brief Summary (4000 words) ----"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <textarea name id cols="30" rows="2"
                                    placeholder="Brief about the Closing Meeting:"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Date : <input type="date">
                            </td>
                            <td>
                                Signature : <input type="file">
                            </td>
                        </tr>
                    </tbody>
        
                </table>
            </div>
        </div>
    </section>
    @include('layout.footer')
