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


                                                <h4>Update Document Status </h4><br><br>

                                                     <form method="post" action="{{ url('document-report-by-admin') }}">
                                                        @csrf
                                                        <input type="hidden" name="previous_url" value="{{ Request::url() }}">
                                                        <input type="hidden"  value="{{$course_id}}" name="course_id">

                                                        <div class="row" id="first-page">
                                                            <div class="col-sm-12 col-md-8" >

                                                                <label>Add Comment</label>
                                                                <input type="text" name="doc_admin_comment" class="form-control" required>
                                                            </div>

                                                             <div class="col-sm-12 col-md-4">

                                                                <input type="hidden" name="send_to_admin" value="1" >
                                                            </div>
                                                            @if(isset($acknow_record))
                                                            @if($acknow_record->course_id==$course_id)
                                                            <input  value="Comment Send Already" class="btn btn-danger">
                                                            @else
                                                            <input type="submit" value="Add Comment" class="btn btn-primary">
                                                            @endif
                                                            @else
                                                            <input type="submit" value="Add Comment" class="btn btn-primary">
                                                            @endif
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


   <script>
       $('#exportForm').click(function(){
  var pdf = new jsPDF('a', 'mm', 'a4');
  var firstPage;
  var secondPage;

  html2canvas($('#first-page'), {
    onrendered: function(canvas) {
      firstPage = canvas.toDataURL('image/jpeg', 1.0);
    }
  });

  html2canvas($('#second-page'), {
    onrendered: function(canvas) {
      secondPage = canvas.toDataURL('image/jpeg', 1.0);
    }
  });


  setTimeout(function(){
    pdf.addImage(firstPage, 'JPEG', 5, 5, 200, 0);
    pdf.addPage();
    pdf.addImage(secondPage, 'JPEG', 5, 5, 200, 0);
    pdf.save("export.pdf");
  }, 150);
});
   </script>

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

