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
                @foreach ($courses as $key=>$item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->course_name }}</td>
                        <td>
                        {{ $item->course_duration_y ?? '' }} Years(s)
                        {{ $item->course_duration_m ?? '' }} Month(s)
                        {{ $item->course_duration_d ?? '' }} Day(s)
                        {{ $item->course_duration_h ?? '' }} Hour(s)
                        </td>
                        <td>{{ $item->eligibility }}</td>
                        <th>
                            <a href="{{ url('desktop-view-final_summaries?application='.$applicationDetails->id.'&course='.$item->id) }}" class="float-left btn btn-primary btn-sm">View Summary 
                          
                        </a>
                        @if($item->signed_copy_desktop!=null)
                                    
                                    <a href="{{ url('desktop/doc/'.$item->signed_copy_desktop.'/'.dEncrypt($item->id).'?secret=true')}}" class="float-left btn btn-primary btn-sm"> View Signed Copy
                                    </a>  
                                     
                                    {{-- 
                                    @else
                                    <label for="signed_copy">Signed Copy</label> 
                                                        <input type="file" name="sigend_copy" id="sigend_copy"  data-course-id="{{$item->id}}">
                                    --}}
                                    @endif
                        </th>
                    </tr>
                @endforeach
                
            </table>
            @if($is_all_course_summary_generated)
            <div class="row">
                <div class="col-md-12 mt-3 d-flex justify-content-end">
                    <a href="{{url('/desktop/download/pdf',dEncrypt($applicationDetails->id))}}" class="btn btn-primary">Download Summary</a>
                </div>
            </div>
            @endif
        </div>
      </div>
    </section>

   
    @include('layout.footer')
