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
        <div class="card-header bg-white text-dark">
            <h5 class="mt-2">
                Summary Reports
            </h5>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>Sr. No.</th>
                    <th>Course Name</th>
                    <th>Duration</th>
                    <th>Eligibilty</th>
                    <th>Action</th>
                </tr>
                @foreach ($courses as $item)
                @if($item->application_id!==null)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->course_name }}</td>
                        <td>
                            {{ $item->years }} Year(s) {{ $item->months }} Month(s) {{ $item->days }} Day(s) {{ $item->hours }} Hour(s)
                        
                        </td>
                        <td>{{ $item->eligibility }}</td>
                        <th>
                            @if(Auth::user()->assessment==2)
                                @if($item->application_id!==null)
                                <a href="{{ url('onsite/view?application='.$applicationDetails->id.'&course='.$item->id) }}" class="btn btn-primary">View Summary report</a>
                                @else
                                <a href="#" class="btn btn-warning" disabled>Report Not Generated</a>
                                @endif
                            
                            @else
                                @if($item->application_id!==null)
                                <a href="{{ url('desktop/view?application='.$applicationDetails->id.'&course='.$item->id) }}" class="btn btn-primary">View Summary report</a>
                                @else
                                <a href="#" class="btn btn-warningg" disabled>Report Not Generated</a>
                                @endif
                            @endif
                        </th>
                    </tr>
                    @endif
                @endforeach
            </table>
        </div>
      </div>
    </section>

   
    @include('layout.footer')
