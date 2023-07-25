 @include('layout.header')

 <style>
     @media (min-width: 900px) {
         .modal-dialog {
             max-width: 674px;
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
                 <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
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
                                 <a href="{{ url('/dashboard') }}">
                                     <i class="fas fa-home"></i> Home</a>
                             </li>
                             <li class="breadcrumb-item active">Dashboard</li>
                         </ul>
                     </div>
                 </div>
             </div>

             @if (Session::has('sussess'))
                 <div class="alert alert-success" role="alert">
                     {{ session::get('sussess') }}
                 </div>
             @elseif(Session::has('fail'))
                 <div class="alert alert-danger" role="alert">
                     {{ session::get('fail') }}
                 </div>
             @endif

             <div class="row ">

                 <div class="row clearfix">

                     <div class="col-lg-12 col-md-12">
                         <div class="card">
                             <div class="profile-tab-box">
                                 <div class="p-l-20">
                                     <ul class="nav ">
                                         <li class="nav-item tab-all">
                                             <a class="nav-link active show" href="#general_information"
                                                 data-bs-toggle="tab">General Information</a>
                                         </li>
                                         <li class="nav-item tab-all p-l-20">
                                             <a class="nav-link" href="#new_application" data-bs-toggle="tab">New
                                                 Application</a>
                                         </li>
                                         <li class="nav-item tab-all p-l-20">
                                             <a class="nav-link" href="#preveious_application"
                                                 data-bs-toggle="tab">Previous Applications</a>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                         <div class="tab-content">
                             <div role="tabpanel" class="tab-pane active" id="general_information" aria-expanded="true">
                                 <div class="row clearfix">
                                     <div class="col-lg-12 col-md-12 col-sm-12">
                                         <div class="card project_widget">
                                             <div class="header">

                                             </div>
                                             <div class="body">
                                                 <div class="row">
                                                     <div class="col-md-4 col-6 b-r">
                                                         <h5> <strong>Validity </strong></h5>
                                                         <p class="text-muted">{{ $data[0]->validity }}</p>
                                                     </div>
                                                     <div class="col-md-4 col-6 b-r">
                                                         <h5> <strong>Fee Structure </strong></h5>
                                                         <p class="text-muted">{{ $data[0]->fee_structure }}</p>
                                                     </div>
                                                     <div class="col-md-4 col-6 b-r">
                                                         <h5> <strong>Timelines </strong></h5>
                                                         <p class="text-muted"> {{ $data[0]->timelines }}</p>
                                                     </div>
                                                 </div><br>


                                                 <h5>Level Information</h5>
                                                 <p>{{ $data[0]->level_Information }}</p><br>



                                                 <h5>Prerequisites</h5>
                                                 <p>{{ $data[0]->Prerequisites }}</p><br>


                                                 <h5>Documents Required</h5>
                                                 <p>{{ $data[0]->documents_required }}</p><br>
                                                 <br>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>



                             <div role="tabpanel" class="tab-pane" id="timeline" aria-expanded="false">
                             </div>
                             <div role="tabpanel" class="tab-pane" id="new_application" aria-expanded="false">
                                 <div class="card">
                                     <div class="header">
                                         <h2>New Application</h2>
                                     </div>
                                     <div class="body">
                                         <div class="form-group">
                                             <input type="text" class="form-control" placeholder="Username">
                                         </div>
                                         <div class="form-group">
                                             <input type="password" class="form-control" placeholder="Current Password">
                                         </div>
                                         <div class="form-group">
                                             <input type="password" class="form-control" placeholder="New Password">
                                         </div>
                                         <button class="btn btn-info btn-round">Save Changes</button>
                                     </div>
                                 </div>

                             </div>
                             <div role="tabpanel" class="tab-pane" id="preveious_application" aria-expanded="false">
                                 <div class="card">
                                     <div class="header">
                                         <h2>Previous Applications</h2>
                                     </div>
                                     <div class="body">



                                         <div class="table-responsive">
                                             <table class="table table-hover js-basic-example contact_list">
                                                 <thead>
                                                     <tr>
                                                         <th class="center">#S.N0</th>
                                                         <th class="center"> Name of the Ayouthveda course</th>
                                                         <th class="center">Duration of the course</th>
                                                         <th class="center">Mode of the course </th>
                                                         <th class="center"> Date of Application </th>
                                                         <th class="center"> Current Status </th>
                                                         <th class="center">Remake History</th>

                                                     </tr>
                                                 </thead>
                                                 <tbody>



                                                     <tr class="odd gradeX">
                                                         <td class="center">1</td>
                                                         <td class="center">second</td>
                                                         <td class="center">third</td>
                                                         <td class="center">fourth</td>
                                                         <td class="center">five</td>
                                                         <td class="center">six</td>


                                                         <td class="center">

                                                             <button class="btn btn-tbl-symbols" data-toggle="modal"
                                                                 data-target="#exampleModal"><i
                                                                     class="material-icons">create</i></button>

                                                         </td>


                                                     </tr>

                                                 </tbody>
                                             </table>




                                             <!-- Modal -->
                                             <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                 <div class="modal-dialog" role="document">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <h5 class="modal-title" id="exampleModalLabel">Modal
                                                                 title</h5>
                                                             <button type="button" class="close"
                                                                 data-dismiss="modal" aria-label="Close">
                                                                 <span aria-hidden="true">&times;</span>
                                                             </button>
                                                         </div>
                                                         <div class="modal-body">
                                                             ...
                                                         </div>
                                                         <div class="modal-footer">
                                                             <button type="button" class="btn btn-secondary"
                                                                 data-dismiss="modal">Close</button>
                                                             <button type="button" class="btn btn-primary">Save
                                                                 changes</button>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
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
