@include('layout.header')


<title>RAV Accreditation</title>

</head>

<body class="light">
    <!-- Page Loader -->
    {{-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{asset('assets/images/favicon.png')}}" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div> --}}
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
        @endif



        @include('layout.rightbar')


    </div>

<style>

.blinking-btn{
    background-color: #004A7F;
  -webkit-border-radius: 10px;
  border-radius: 10px;
  border: none;
  color: #FFFFFF;
  cursor: pointer;
  display: inline-block;
  font-family: Arial;
  font-size: 15px;
    padding: 3px 7px;
  text-align: center;
  text-decoration: none;
  -webkit-animation: glowing 1500ms infinite;
  -moz-animation: glowing 1500ms infinite;
}

@-webkit-keyframes glowing {
  0% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; -webkit-box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
}

@-moz-keyframes glowing {
  0% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; -moz-box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
}
/*
@-o-keyframes glowing {
  0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
}

@keyframes glowing {
  0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
} */

</style>


    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">National Applications</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">National Applications</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header bg-white text-dark">
                            <h4 class="header-title mt-2"> National Applications</h2>

                        </div>
                        <div class="body">
                            <div class="table-responsive" style="width:100%; overflow:hidden; padding-bottom:20px;">
                                <table class="table display nowrap" style="width:100%; overflow:hidden;" id="dataTableMain">
                                    <thead>
                                        <tr>
                                            <th class="center">Sr.No</th>
                                            <th class="center">Level</th>
                                            <th class="center">Application No.</th>
                                            <th class="center">Total Course</th>
                                            <th class="center">Date of Application </th>
                                            <th class="center">Assessment Date </th>
                                            <th class="center">State </th>

                                            <!-- <th class="center">Due Date </th> -->

                                            <th class="center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($collection)
                                        @foreach ($collection as $k=> $item)

                                        <?php
                                        $assessor_id = listofapplicationassessor($item->application_id);
                                        ?>

                                        <tr class="odd gradeX">
                                            <td class="center">{{ $k+1 }}</td>
                                            <td class="center">{{ $item->level_id  }}</td>
                                            <td class="center">{{($item->application_uid ?? 'something went wrong!')}}</td>
                                            <td class="center">{{  $item->course_count  }}</td>
                                            <td class="center">{{application_submission_date($item->application_id,$assessor_id)}}</td>
                                            <td class="center">{{assessor_assign_date($item->application_id,$assessor_id)}}</td>
                                            <td class="center">{{ showstate($item->state)}}</td>

                                            <td class="center">
                                                <a href="{{ url('/Assessor-view/'.dEncrypt($item->application_id)) }}" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                            </td>
                                        </tr>
                                        @endforeach
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
    </section>

    @include('layout.footer')

