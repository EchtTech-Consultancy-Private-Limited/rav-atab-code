@include('layout.header')


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


        @include('layout.sideAss')



        @include('layout.rightbar')


    </div>


    <section class="content">
        <div class="container-fluid">
           <div class="block-header">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">





                    <ul class="breadcrumb breadcrumb-style ">
                       <li class="breadcrumb-item">
                          <h4 class="page-title">Manuals</h4>

                       </li>
                       <li class="breadcrumb-item bcrumb-1">
                          <a href="{{url('/dashboard')}}">
                          <i class="fas fa-home"></i> Home</a>
                       </li>
                       
                       <li class="breadcrumb-item active">Manuals List</li>
                    </ul>
                 </div>
              </div>
           </div>



           <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                 <div class="card">
                    <div class="header">
                       <h2>

                       </h2>

                    </div>
                    
                       <div class="table-responsive">
                          <table class="table table-hover js-basic-example contact_list">
                             <thead>
                                <tr>

                                   <th class="center"> S.No. </th>
                                   <th class="center"> Manual Type </th>
                                   <th class="center"> Description </th>
                                   <th class="center"> Status </th>
                                   <th class="center"> Action </th>
                                </tr>
                             </thead>
                             <tbody>
                                @php $k = 1; @endphp
                                @foreach ($data as $datalist)
                                <tr class="odd gradeX">
                                   <td class="center">{{$k}}</td>
                                   <td class="center">{{checkmanualtype($datalist->type)}}</td>
                                   <td class="center">{{$datalist->description}}</td>
                                   <td class="center">{{ $datalist->status ? 'Active' : 'In-Active' }}</td>
                                   <td class="center">
                                       <a target="_blank" href="{{asset('manuals/')}}/{{$datalist->manual_file}}" class="" id="view"><img height="30" width="30" src="{{asset('assets/images/file-download-icon.png')}}" alt="" title=""/>
                                       </a>
                                   </td>
                                </tr>
                                 @php $k ++; @endphp
                                @endforeach
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
