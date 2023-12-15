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


        @if(Auth::user()->role  == '1' )

        @include('layout.sidebar')

        @elseif(Auth::user()->role  == '2')

        @include('layout.siderTp')

        @elseif(Auth::user()->role  == '3')

        @include('layout.sideAss')

        @elseif(Auth::user()->role  == '4')

        @include('layout.sideprof')

        @endif

        @include('layout.rightbar')

    </div>



<section class="content">
           @if (count($errors) > 0)
              <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                   @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                   @endforeach
                </ul>
              </div>
            @endif
            <div class="container-fluid">
              <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">

                       <ul class="breadcrumb breadcrumb-style ">
                          <li class="breadcrumb-item">
                             <h6 class="page-title"> Documents  History </h6>

                          </li>
                          <li class="breadcrumb-item bcrumb-1">
                            <a href="{{url('/dashboard')}}">
                             <i class="fas fa-home"></i> Home</a>
                          </li>

                          <li class="breadcrumb-item active">Documents History </li>
                       </ul>
                       @if ($message = Session::get('success'))
                         <div class="alert alert-success">
                            <p>{{ $message }}</p>
                         </div>
                      @endif
                    </div>

                    <div class="col-md-3">
                    <div class="text-right float-right">
                                <a href="{{ url()->previous() }}" type="button" class="btn btn-primary" style="float:right;">Back</a>
                             </div>
                    </div>
                </div>
              </div>
            <div class="row">

                 <div class="col-lg-12 col-md-12 col-sm-12">

                    <div class="card">

                           

                       <div class="body">

                        <div class="table-responsive">

                             <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row"><div class="col-sm-12">
                                    <table class="table table-hover js-basic-example contact_list dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                   <tr role="row">
                                        <th class="center sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label=" No : activate to sort column descending"> S.No. </th>
                                        <th class="center sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label=" No : activate to sort column descending"> Comments  </th>
                                        <th class="center sorting sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label=" No : activate to sort column descending"> User  </th>
                                        <th class="center sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=" Name : activate to sort column ascending">Date </th>

                                    </tr>
                                </thead>
                                <tbody>



                                @foreach($comment as $key=>$comments)

                                <tr class="gradeX odd ">
                                         <td class="center sorting_1">{{ ++$key }}</td>
                                          <td class="center"><a ><b>{{$comments->comments}}</b></a></td>
                                          <td class="center"><a ><b>@if(get_role($comments->user_id)==1)  {{ get_admin_comments($comments->user_id) }} ( Admin ) @elseif(get_role($comments->user_id)==3)  {{ get_admin_comments($comments->user_id) }} ( Assessor ) @endif</b></a></td>
                                         <td class="center"><a >{{ date('d F Y', strtotime($comments->created_at)) }}                                        </a></td>
                                </tr>

                                @endforeach

                            </tbody>
                             </table>
                            </div></div>

                          </div>
                       </div>
                    </div>
                 </div>

              </div>
           </div>
</section>


<br><br><br><br><br><br><br><br>
<script>
    $( document ).ready(function() {
         $('#doc-comment-textarea').hide();

      });

          $('#show-view-doc-options').on('change', function(){

          var listvalue = $(this).val();
          //alert(listvalue);
          if(listvalue==1)
          {
               $('#doc-comment-textarea').hide();
          }
          else if(listvalue==2)
          {
              $('#doc-comment-textarea').show();
          }

          else if(listvalue=='')
          {
              $('#doc-comment-textarea').hide();
          }


         });
</script>
    @include('layout.footer')

