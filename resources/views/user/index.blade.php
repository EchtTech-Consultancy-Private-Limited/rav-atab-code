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


        @include('layout.sidebar')



        @include('layout.rightbar')


    </div>


    <section class="content">
        <div class="container-fluid">
           <div class="block-header">
              <div class="row">
                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">





                    <ul class="breadcrumb breadcrumb-style ">
                       <li class="breadcrumb-item">
                          <h4 class="page-title">All Users</h4>

                       </li>
                       <li class="breadcrumb-item bcrumb-1">
                          <a href="{{url('/dashboard')}}">
                          <i class="fas fa-home"></i> Home</a>
                       </li>
                       <li class="breadcrumb-item bcrumb-2">
                          <a href="#" onClick="return false;">Users</a>
                       </li>
                       <li class="breadcrumb-item active">All Users</li>
                    </ul>
                 </div>
              </div>
           </div>





           @if ($message = Session::get('success'))
           <div class="alert alert-success">
              <p>{{ $message }}</p>
           </div>
           @endif

           <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                 <div class="card">
                    <div class="header">
                       <h2>



                <span style="float:right;" >

                    {{-- {{request()->path()}} --}}

                @if(request()->path() == 'admin-user')

                <a type="button" href="{{ url('/adduser/admin-user') }}" class="btn btn-primary waves-effect" style="line-height:2;">+ Add User</a>

                @elseif(request()->path() == 'training-provider')

                <a type="button" href="{{ url('/adduser/training-provider') }}" class="btn btn-primary waves-effect" style="line-height:2;">+ Add User</a>

                @elseif(request()->path() == 'assessor-user')

                    <a type="button" href="{{ url('/adduser/assessor-user') }}" class="btn btn-primary waves-effect" style="line-height:2;">+ Add User</a>

               @elseif(request()->path() == 'secrete-user')

                    <a type="button" href="{{ url('/adduser/secrete-user') }}" class="btn btn-primary waves-effect" style="line-height:2;">+ Add User</a>

                @endif

                </span>

                       </h2>

                    </div>
                    <div class="body">
                       <div class="table-responsive">
                          <table class="table table-hover js-basic-example contact_list">
                             <thead>
                                <tr>

                                   <th class="center"> Registration No. </th>
                                   <th class="center"> Registration Date </th>
                                   <th class="center"> Valid Upto </th>
                                   <th class="center"> Name </th>
                                   <th class="center"> Email </th>
                                   <th class="center"> Status </th>
                                   <th class="center"> Action </th>
                                </tr>
                             </thead>
                             <tbody>
                                @foreach ($data as $key => $user)
                                <tr class="odd gradeX">
                                   <td class="center">RAVTP-{{ $user->id }}</td>
                                   <td class="center">{{ date('d F Y', strtotime($user->created_at)) }}</td>
                                   <td class="center">@if(isset($user->created_at)) {{ date('d F Y', strtotime($user->created_at->addYear())) }} @endif</td>
                                   <td class="center">{{ $user->firstname }}</td>
                                   <td class="center">{{ $user->email }}</td>
                                   <td class="text-center">
                                    @if(Auth::user()->user_type=='2')
                                        <a href="{{ url('active-users/'.dEncrypt($user->id)) }}" onclick="return confirm_option('change status')" class="@if($user->status==0) btn-tbl-disable @elseif($user->status==1) btn-tbl-edit @endif" title="Verify Users">
                                          <i class="fas fa-ban"></i>
                                       </a>
                                    @else
                                    <a href="{{ url('active-users/'.dEncrypt($user->id)) }}" onclick="return confirm_option('change status')" class="@if($user->status==1) btn-tbl-disable @elseif($user->status==0) btn-tbl-edit @endif" title="Status">
                                          <i class="fas fa-ban"></i>
                                       </a>
                                    @endif
                                    </td>

                                   <td class="center">


                                    {{-- {{request()->path()}} --}}

                                    @if(request()->path() == 'admin-user')

                                      <a class="btn btn-tbl-edit btn-primary btn-sm" href="{{ url('/update-admin'.'/admin-user'.'/'.dEncrypt($user->id)) }}" onclick="return confirm_option('edit')"><i style="line-height:22px !important;" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                    @elseif(request()->path() == 'training-provider')

                                     <a class="btn btn-tbl-edit btn-primary btn-sm" href="{{ url('/update-admin'.'/training-provider'.'/'.dEncrypt($user->id)) }}" onclick="return confirm_option('edit')"><i style="line-height:22px !important;" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                    @elseif(request()->path() == 'assessor-user')

                                    <a class="btn btn-tbl-edit btn-primary btn-sm" href="{{ url('/update-admin'.'/assessor-user'.'/'.dEncrypt($user->id)) }}"  onclick="return confirm_option('edit')"><i style="line-height:22px !important;" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                    @endif

                         {{-- delete code  --}}

                         @if($user->id != 1)

                                    <a class="btn btn-tbl-edit btn-danger btn-sm" href="{{ url('/delete-admin'.'/'.dEncrypt($user->id)) }}"  onclick="return confirm_option('delete')"><i class="fa fa-trash" aria-hidden="true" style="line-height:22px !important;" ></i></a>

                        @endif

                                    <a href="{{ url('view-user'.'/'.dEncrypt($user->id)) }}" class="btn btn-tbl-edit"><i class="material-icons">visibility</i></a>

                                 </td>

                                </tr>
                                @endforeach
                             </tbody>
                          </table>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </section>

     <script>
   function confirm_option(action){
      if(!confirm("Are you sure to "+action+", this record!")){
         return false;
      }

      return true;

   }
</script>
    @include('layout.footer')
