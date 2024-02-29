@include('layout.header')

<title>RAV Accreditation</title>

<link rel="stylesheet" href="{{ asset('assets/css/atab-dashboard.css') }}">

</head>



<body class="light

        @if(Auth::user()->role  == 1 )

        @elseif(Auth::user()->role  == 2)

        nav-Tp

        @elseif(Auth::user()->role  == 3)

        nav-Ass

        @elseif(Auth::user()->role  == 4)

        @endif

">  
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30 loader1">
                <!-- <img class="loading-img-spin" style="width: 170px !important;height: auto !important;;" src="{{asset('assets/images/loading-screen-logo.png')}}" alt="admin"> -->
              
            </div>
           <!-- <p>Please wait...</p> -->
        </div>
  </div>

    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

       @include('layout.topbar')

    <div>

        @if(Auth::user()->role  == 1 )

        @include('layout.sidebar')

        @elseif(Auth::user()->role  == 2)

        @include('layout.siderTp')

        @elseif(Auth::user()->role  == 3)

        @include('layout.sideAss')

        @elseif(Auth::user()->role  == 4)

        @include('layout.sideprof')

        @elseif(Auth::user()->role  == 5)

        @include('layout.secretariat')

        @elseif(Auth::user()->role  == 6)

        @include('layout.sidbarAccount')

        @endif

        @include('layout.rightbar')


    </div>



    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Dashboard</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>

                {{-- {{ @unless($breadcrumbs->isEmpty())
                    <ol class="breadcrumb">
                        @foreach($breadcrumbs as $breadcrumb)

                            @if(!is_null($breadcrumb->url) && !$loop->last)
                                <li class="breadcrumb-item"><a href="@{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                            @else
                                <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                            @endif

                        @endforeach
                    </ol>
                @endunless }} --}}

                @if(Session::has('success'))
                <div class="alert alert-success" id="alert" style="padding: 15px;" role="alert">
                    {{session::get('success')}}
                </div>
                @elseif(Session::has('fail'))
                <div class="alert alert-danger" role="alert">
                    {{session::get('fail')}}
                </div>
                @endif
            </div>

@if(Auth::user()->role == 3)

<div class="row ">
    <div class="col-xl-3 col-sm-6">
        <div class="card l-bg-purple">
            <div class="info-box-5 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa fa-india"></i></div>
                <div class="mb-4">
                    <a href="{{ url('/assessor-desktop-assessment') }}">
                    <h5 class="font-20 mb-0">Desktop Applications</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card l-bg-blue-dark">
            <div class="info-box-5 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa-globe"></i></div>
                <div class="mb-4">
                    <a href="{{ url('/assessor-onsite-assessment-page') }}">
                    <h5 class="font-20 mb-0">Onsite Applications</h5>
                    </a>
                </div>

            </div>
        </div>
    </div>


    <div class="col-xl-3 col-sm-6">
        <div class="card l-bg-purple">
            <div class="info-box-5 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa fa-india"></i></div>
                <div class="mb-4">
                    <h5 class="font-20 mb-0">Surveillance Applications</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6">
        <div class="card l-bg-blue-dark">
            <div class="info-box-5 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa-globe"></i></div>
                <div class="mb-4">
                    <h5 class="font-20 mb-0">Surprise Applications</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6">
        <div class="card l-bg-blue-dark">
            <div class="info-box-5 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa-globe"></i></div>
                <div class="mb-4">
                    <h5 class="font-20 mb-0">Re-Assessment Applications</h5>
                </div>
            </div>
        </div>
    </div>

</div>

@elseif(Auth::user()->role == 1)

            <div class="row ">
                <div class="col-xl-3 col-sm-6">
                    <div class="card l-bg-purple">
                        <div class="info-box-5 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa fa-india"></i></div>
                            <div class="mb-4">
                               <a href="{{ url('nationl-page') }}"><h5 class="font-20 mb-0">National Application</h5></a>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <div class="col-4 text-left">
                                        <span class="span-width">Active</span>
                                        <h2 class="d-flex align-items-left mb-0">
                                        {{@$dataCount['complete']}}
                                    </h2>
                                    </div>

                                </div>
                                <div class="col-4 text-left">
                                    <span class="span-width">Pending</span>
                                    <h2 class="d-flex align-items-right mb-0 mergin-left">
                                    {{(@$dataCount['pending']+@$dataCount['processing'])}}
                                    </h2>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card l-bg-blue-dark">
                        <div class="info-box-5 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-globe"></i></div>
                            <div class="mb-4">
                                <a href="{{ url('internationl-page') }}" ><h5 class="font-20 mb-0">InterNational Application</h5></a>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <div class="col-4 text-left"   style="cursor:pointer; z-index:1000!important;"  data-bs-toggle="modal" data-bs-target="#international-active-model">
                                        <span class="span-width">Active</span>
                                        <h2 class="d-flex align-items-left mb-0">
                                        {{(@$dataCount['complete'])}}
                                    </h2>
                                    </div>

                                </div>
                                <div class="col-4 text-left"  style="cursor:pointer; z-index:1000!important;"  data-bs-toggle="modal" data-bs-target="#international-pending-model">
                                    <span class="span-width">Pending</span>
                                    <h2 class="d-flex align-items-right mb-0 mergin-left">
                                    {{(@$dataCount['pending']+@$dataCount['processing'])}}
                                    </h2>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6" style="display:none">
                    <div class="card l-bg-green-dark">
                        <div class="info-box-5 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                            <div class="mb-4">
                                <h5 class="font-20 mb-0">Active Users</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                <div class="col-4 text-end">
                                        <span class="span-width">&nbsp;</span>
                                        <h2 class="d-flex align-items-left mb-0">
                                        10,525
                                    </h2>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6"  style="display:none">
                    <div class="card l-bg-orange-dark">
                        <div class="info-box-5 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                            <div class="mb-4">
                                <h5 class="font-20 mb-0">Pending (Verfication)</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                <div class="col-4 text-end">
                                        <span class="span-width">&nbsp;</span>
                                        <h2 class="d-flex align-items-left mb-0">
                                        105
                                    </h2>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
@endif
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">

                        <div class="body">

                    <figure class="highcharts-figure">
                        <div id="container"></div>
                        <!--<p class="highcharts-description">
                             3D pie chart with an inner radius
                        </p>-->
                    </figure>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">

                        <div class="body">

                            <figure class="highcharts-figure">
                                <div id="container2"></div>
                                <!--<p class="highcharts-description">
                                3D pie chart with an inner radius
                                </p>-->
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">

                        <div class="body">
                            <figure class="highcharts-figure">
                                <div id="container3"></div>
                                <!--<p class="highcharts-description">
                                3D pie chart with an inner radius
                                </p>-->
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>


         </div>

        <div class="modal fade" id="international-active-model" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" role="document" >
                <div class="modal-content l-bg-blue-dark">

                <div class="info-box-5">
                <div class="card-icon card-icon-large"><i class="fas fa-globe"></i></div>
                </div>

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">InterNational Application <small>(Active)</small></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" style="z-index:1000001!important;">
                    <div style="float:left; clear:none; width:50%; position:relative;">
                        <div class="text-white">SAARC</div>
                        <div style="font-weight:bold;  font-size:20px;" class="text-white">{{@$dataCount['complete']}}</div>
                        </div>
                        <div style="float:left; clear:none  width:50%;  position:relative;">
                        <div class="text-white">Rest of The World</div>
                        <div class="text-white" style="font-weight:bold;  font-size:20px;">{{@$dataCount['complete']}}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="international-pending-model" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered" role="document" >
            <div class="modal-content l-bg-blue-dark">

           <div class="info-box-5">
             <div class="card-icon card-icon-large"><i class="fas fa-globe"></i></div>
           </div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">InterNational Application <small>(Pending)</small></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" style="z-index:1000001!important;">
                    <div style="float:left; clear:none; width:50%; position:relative;">
                        <div class="text-white">SAARC</div>
                        <div class="text-white" style="font-weight:bold;  font-size:20px;">{{@$dataCount['pending']}}</div>
                        </div>
                        <div style="float:left; clear:none  width:50%;  position:relative;">
                        <div class="text-white">Rest of The World</div>
                        <div class="text-white" style="font-weight:bold;  font-size:20px;">{{@$dataCount['pending']}}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


<script src="{{asset('assets/js/charts/highcharts.js')}}"></script>
<script src="{{asset('assets/js/charts/highcharts-3d.js')}}"></script>
<script src="{{asset('assets/js/charts/exporting.js')}}"></script>
<script src="{{asset('assets/js/charts/export-data.js')}}"></script>
<script src="{{asset('assets/js/charts/accessibility.js')}}"></script>

        <script>
            // Data retrieved from https://olympics.com/en/olympic-games/beijing-2022/medals
Highcharts.chart('container', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'Pending Applications',
        align: 'left'
    },
    subtitle: {
        text: 'Total Pending Applications: {{(@$dataCount['pending'])}}',
        align: 'left'
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'No of Pending Application',
        data: [
            ['India', {{@$dataCount['pending']}}],
            ['SAARC',  {{@$dataCount['pending']}}],
            ['Rest of the World',  {{@$dataCount['pending']}}],

        ]
    }]
});
Highcharts.chart('container2', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'Processing Applications',
        align: 'left'
    },
    subtitle: {
        text: 'Total Processing Applications: {{(@$dataCount['pending'])}}',
        align: 'left'
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },

    series: [{
        name: 'No of Processing Application',
        data: [
            ['India', {{@$dataCount['processing']}}],
            ['SAARC',  {{@$dataCount['processing']}}],
            ['Rest of the World',  {{@$dataCount['processing']}}],

        ]
    }]
});
Highcharts.chart('container3', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'Approved Applications',
        align: 'left'
    },
    subtitle: {
        text: 'Total Approved Applications: {{(@$dataCount['complete']+@$dataCount['complete']+@$dataCount['complete'])}}',
        align: 'left'
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
   /* series: [{
        name: 'Medals',
        data: [
            ['Norway', 16],
            ['Germany', 12],
            ['USA', 8],
            ['Sweden', 8],
            ['Netherlands', 8],
            ['ROC', 6],
            ['Austria', 7],
            ['Canada', 4],
            ['Japan', 3]

        ]
    }]*/
    series: [{
        name: 'No of Approved Application',
        data: [
            ['India', {{@$dataCount['complete']}}],
            ['SAARC',  {{@$dataCount['complete']}}],
            ['Rest of the World',  {{@$dataCount['complete']}}],

        ]
    }]
});
        </script>

<script>
function showHtmlMessageActive() {
    swal({
        title: "InterNational Application <small>(Active)</small>",
        text: '<div style="float:left; clear:none; width:50%; position:relative;">'
            +'<div>SAARC</div>'
            +'<div style="font-weight:bold;  font-size:20px;">{{@$dataCount['complete']}}</div>'
            +'</div>'
            +'<div style="float:left; clear:none  width:50%;  position:relative;">'
            +'<div>Rest of The World</div>'
            +'<div style="font-weight:bold;  font-size:20px;">{{@$dataCount['complete']}}</div>'
            +'</div>',
        html: true,
       timer: 2000,
        showConfirmButton: false
    });
}

function showHtmlMessagePending() {

   swal({
        title: 'InterNational Application <small>(Pending)</small><button type="button" class="close"  aria-label="Close" style="width:auto;height:auto;"><span aria-hidden="true">×</span></button>',
        text: '<div style="float:left; clear:none; width:50%; position:relative;">'
            +'<div>SAARC</div>'
            +'<div style="font-weight:bold;  font-size:20px;">{{@$dataCount['pending']}}</div>'
            +'</div>'
            +'<div style="float:left; clear:none  width:50%;  position:relative;">'
            +'<div>Rest of The World</div>'
            +'<div style="font-weight:bold;  font-size:20px;">{{@$dataCount['pending']}}</div>'
            +'</div>',
        html: true,
        timer: 2000,
       showConfirmButton: false

    });
}

</script>


    </section>


    @include('layout.footer')
