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
        @elseif(Auth::user()->role == '5')
        @include('layout.secretariat')
        @elseif(Auth::user()->role == '6')
        @include('layout.sidbarAccount')
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
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->course_name }}</td>
                        <td>   {{ $item->course_duration_y ?? '' }} Years(s)
                        {{ $item->course_duration_m ?? '' }} Month(s)
                        {{ $item->course_duration_d ?? '' }} Day(s)
                        {{ $item->course_duration_h ?? '' }} Hour(s)</td>
                        <td>{{ $item->eligibility }}</td>
                        <th>
                            @if(Auth::user()->role == 1 && $applicationDetails->level_id==2)
                            <a href="{{ url('super-admin/view-final-summary?application='.dEncrypt($applicationDetails->id).'&course='.dEncrypt($item->id)) }}" class="btn btn-primary">View Summary Report</a>
                            @endif
                            @if(Auth::user()->role == 1 && $applicationDetails->level_id==3)
                            <a href="{{ url('view-final_summaries?application='.dEncrypt($applicationDetails->id).'&course='.dEncrypt($item->id)) }}" class="btn btn-primary">View Summary Report</a>
                            @endif
                        </th>
                    </tr>
                @endforeach
            </table>
           

        </div>
      </div>
    </section>

   
    @include('layout.footer')
