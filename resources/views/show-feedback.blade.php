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
                          <table class="table table-hover js-basic-example contact_list" id="export-btn">
                             <thead>
                                <tr>

                                   <th class="center"> Sr.  </th>
                                   <th class="center"> User Name </th>
                                   <th class="center"> User Email </th>
                                   <th class="center"> Remark </th>
                                  
                                </tr>
                             </thead>
                             <tbody>
                                @foreach ($feedback as $key => $feedbacks)
                                <tr class="odd gradeX">
                                   <td class="center">{{ ++$key }}</td>
                                   <td class="center"><?php echo get_user_name($feedbacks->user_id); ?></td>
                                   <td class="center"><?php echo get_user_email($feedbacks->user_id); ?></td>
                                   <td class="center">{{ $feedbacks->remark }}</td>
                           
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
  

    <!--  <script >
         $(document).ready(function() {
       $('#example').DataTable( {
           dom: 'Bfrtip',
           buttons: [
               'copy', 'csv', 'excel', 'pdf', 'print'
           ]
       } );
   } );
     </script> -->
     <script>
   function confirm_option(action){
      if(!confirm("Are you sure to "+action+", this record!")){
         return false;
      }

      return true;

   }
</script>

    @include('layout.footer')
