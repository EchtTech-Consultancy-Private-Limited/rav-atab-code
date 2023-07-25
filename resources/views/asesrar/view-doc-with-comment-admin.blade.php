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

                                            
                                                <h4>Create NC</h4><br><br>
                                              
                                                     <form method="post" action="{{ url('add-accr-comment-view-doc') }}">
                                                        @csrf
                                                        <input type="hidden" name="previous_url" value="{{ Request::url() }}">
                                                        <input type="hidden"  value="{{$doc_id}}" name="doc_id">
                                                        <input type="hidden"  value="{{$doc_code}}" name="doc_code">
                                                        <input type="hidden"  value="{{$course_id}}" name="course_id">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-4">
                                                                <label>Select Type</label>
                                                                <select class="form-control text-center" id="show-view-doc-options" name="status" required>
                                                                    <option>--Select--</option>
                                                                    <option value="1">Approved</option>
                                                                    <option value="0">Not Approved</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-sm-12 col-md-4" id="doc-comment-textarea">
                                                                
                                                                <label>Add Comment</label>
                                                                <textarea rows="10" cols="60" name="doc_comment" class="form-control"></textarea>
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

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title"></h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item active">Display file</li>
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
                        <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card project_widget">

                                        <div class="body">

                                            <object data="{{ url('level'.'/'.$id) }}" type="application/pdf" width="100%" height="500px">
                                                <p>Unable to display PDF file. <a href="{{ url('level'.'/'.$id) }}">Download</a> instead.</p>
                                            </object>

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
          else if(listvalue==0)
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

