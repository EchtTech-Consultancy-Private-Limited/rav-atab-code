@include('layout.header')


<title>RAV Accreditation Previous Applications View</title>
<link rel="stylesheet" type="text/css"
    href="https://rawgithub.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
{{--
<link rel="stylesheet" type="text/css" href="https://rawgithub.com/dimsemenov/Magnific-Popup/master/dist/magnific-popup.css">
 --}}
<style>
    .text-size-11 {
        font-size: 11px !important;
    }
</style>
</head>

<body class="light">

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
        <div class="block-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="breadcrumb breadcrumb-style ">
                        <li class="breadcrumb-item">
                            <h4 class="page-title">Application</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a href="{{ url('/dashboard') }}">
                                <i class="fas fa-home"></i> level</a>
                        </li>
                        <li class="breadcrumb-item active">Application Summary</li>
                    </ul>

                    <a href="{{ url('nationl-page') }}" type="button" class="btn btn-primary" style="float:right;">Back
                    </a> 
                 
                </div>
            </div>
        </div>
   
        <div class="card">
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                    Summary Reports
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Course Name</th>
                        <th>Eligibility</th>
                        <th>Mode of course</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($courses as $course)
                    @foreach ($summeryReport as $summerycourse)
                    @if($course->id == $summerycourse->course_id)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $course->course_name }}</td>
                        <td>{{ $course->eligibility }}</td>
                        <td> {{ json_encode($course->mode_of_course) }}</td>
                        <td>
                            <a href="{{ url('view-summery-report/'.$course->id,$applicationData->id) }}" class="btn btn-primary">View Report</a>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </table>
            </div>
        </div>

       
    </section>




@include('layout.footer')
