@include('layout.header')


<title>RAV Accreditation</title>

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
                                <h4 class="page-title">National Application</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">National Application</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong></strong> NATIONAL</h2>

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example contact_list">
                                    <thead>
                                        <tr>
                                            <th class="center">#S.N0</th>
                                            <th class="center">Level ID</th>
                                            <th class="center">Application No</th>
                                            <th class="center">Total Course</th>
                                            <th class="center">Submissiom date </th>
                                            <th class="center">Assessment Assign Date </th>
                                            <th class="center">Due Date </th>

                                            <th class="center">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($collection)
                                        @foreach ($collection as $k=> $item)

                                        <?php
                                        $secretariat_id = listofapplicationsecretariat($item->application_id);
                                        ?>

                                        <tr class="odd gradeX">
                                            <td class="center">{{ $k+1 }}</td>
                                            <td class="center">{{ $item->level_id  }}</td>
                                            <td class="center">RAVAP-{{(4000+$item->application_id)}}</td>
                                            <td class="center">{{  $item->course_count  }}</td>
                                            <td class="center">{{application_submission_date($item->application_id,$secretariat_id)}}</td>
                                            <td class="center">{{secretariat_assign_date($item->application_id,$secretariat_id)}}</td>
                                            <td class="center">{{secretariat_due_date($item->application_id,$secretariat_id)}}</td>



                                            <td class="center">
                                                <a href="{{ url('/secretariat-view/'.dEncrypt($item->application_id)) }}" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

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

