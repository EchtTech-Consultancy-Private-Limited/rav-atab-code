@include('layout.header')

<style>

@media (min-width: 900px){
.modal-dialog {
    max-width: 674px;
}

.btn-tbl-edit{
    color: rgb(255, 255, 255);
    background: red;
}
}

</style>


<title>RAV Accreditation</title>

</head>

<body class="light">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="loading-img-spin" src="{{asset('assets/images/favicon.png')}}" alt="admin">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

       @include('layout.topbar')

    <div>


        @include('layout.siderTp')



        @include('layout.rightbar')


    </div>



    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Acknowledgement letter</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Acknowledgement</li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(Session::has('sussess'))
            <div class="alert alert-success" role="alert">
                {{session::get('sussess')}}
            </div>
            @elseif(Session::has('fail'))
            <div class="alert alert-danger" role="alert">
                {{session::get('fail')}}
            </div>
            @endif

            <div class="row ">

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">

                    <div class="tab-content">


                            <div class="card">
                                <div class="header">
                                <h2>Acknowledgement Letter</h2>
                                </div>
                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example contact_list">
                                            <thead>
                                                <tr>
                                                    <th class="center">#S.N0</th>
                                                    <th class="center">Application Number</th>
                                                    <th class="center">Donwloard</th>
                                                </tr>
                                            </thead>
                                            <tbody>



                                                    <tr class="odd gradeX">
                                                        <td class="center">1</td>
                                                        <td class="center">second</td>

                                                        <td class="center">

                                                        <button  class="btn btn-tbl-edit" data-toggle="modal" data-target="#exampleModal"><i class="material-icons">create</i></button>

                                                        </td>


                                                    </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>


                    </div>
                </div>
            </div>

            </div>
        </div>
        </div>



    </section>


    @include('layout.footer')
