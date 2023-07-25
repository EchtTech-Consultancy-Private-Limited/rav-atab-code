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

<h1>Hreeeeeeeeeeeeeeee</h1>
     <section class="content">
        <div class="container-fluid">
         

            @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{session::get('success')}}
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
                        <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card project_widget">

                                        <div class="body">

                                            
                                                <h4>Send Document to Admin</h4><br><br>
                                              
                                                     <form method="post" action="{{ url('document-report-toadmin') }}">
                                                        @csrf
                                                        <input type="hidden" name="previous_url" value="{{ Request::url() }}">
                                                        <input type="hidden"  value="{{$course_id}}" name="course_id">
                                                        
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-8" >
                                                                
                                                                <label>Add Comment</label>
                                                                <input type="text" name="doc_admin_comment" class="form-control">
                                                            </div>

                                                             <div class="col-sm-12 col-md-4">
                                                               
                                                                <input type="hidden" name="send_to_admin" value="1">
                                                            </div>

                                                            <input type="submit" value="Add Comment" class="btn btn-primary">
                                                        </div>
                                                    </form>

                                            
                                           
                                                
                                               
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

