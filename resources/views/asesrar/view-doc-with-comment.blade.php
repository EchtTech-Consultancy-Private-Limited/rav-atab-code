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

                                            <a href="{{ url('nationl-accesser')}}" type="button" class="btn btn-primary" style="float:right;">Back</a>


                                                <h4>Create NC</h4><br><br>

                                                     <!--you can send comment to admin on this record only one time -->
                                                    @if(get_doccomment_status($doc_id)==3 || get_doccomment_status($doc_id) != null && get_doccomment_status($doc_id)!=1 && get_doccomment_status($doc_id)!=2 )
                                                     <h4 class="text-center">You Have Send Comment to Admin</h4>

                                                     @elseif(get_doccomment_status($doc_id)==1 || get_doccomment_status($doc_id)==2)

                                                     <h4 class="text-center">You Document Profile Locked Successfully</h4>

                                                     @else
                                                     <form method="post" action="{{ url('add-accr-comment-view-doc') }}">
                                                        @csrf
                                                        <input type="hidden" name="previous_url" value="{{ Request::url() }}">
                                                        <input type="hidden"  value="{{$doc_id}}" name="doc_id">
                                                        <input type="hidden"  value="{{$doc_code}}" name="doc_code">
                                                        <input type="hidden"  value="{{$course_id}}" name="course_id">
                                                        <div class="row">



                                                        @if($doc_latest_record->notApraove_count == 1)

                                                            <div class="col-sm-12 col-md-4">
                                                                <label>Select Type</label>
                                                                <select required class="form-control required text-center" id="show-view-doc-options" name="status">
                                                                    <option value="">--Select--</option>
                                                                    <option value="2">NC 1</option>
                                                                    <option value="1">Close</option>
                                                                </select>
                                                            </div>

                                                        @endif


                                                        @if($doc_latest_record->notApraove_count == 2)
                                                            <div class="col-sm-12 col-md-4">
                                                                <label>Select Type</label>
                                                                <select required class="form-control required text-center" id="show-view-doc-options" name="status">
                                                                    <option value="">--Select--</option>
                                                                    <option value="2">NC 2</option>
                                                                    <option value="1">Close</option>
                                                                </select>
                                                            </div>
                                                        @endif

                                                        @if($doc_latest_record->notApraove_count  >= 3)
                                                            <div class="col-sm-12 col-md-4">
                                                                <label>Select Type</label>
                                                                <select required class="form-control required text-center" id="show-view-doc-options" name="status">
                                                                    <option value="">--Select--</option>
                                                                    <option value="1">Close</option>
                                                                    <option value="0">Not Recommended</option>
                                                                </select>
                                                            </div>
                                                        @endif


                                                            <div class="col-sm-12 col-md-4" id="doc-comment-textarea">

                                                                <label>Add Comment</label>
                                                                <textarea rows="10" cols="60" name="doc_comment" class="form-control"></textarea>
                                                            </div>
                                                            <input type="submit" value="Add Comment" class="btn btn-primary">
                                                        </div>
                                                    </form>
                                                    @endif





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

                                         <td class="center"><a>{{

                                            date('d F Y', strtotime( $comments->created_at))


                                          }}</a></td>
                                    </tr>
                                @endforeach

                            </tbody>
                             </table>
                            </div></div>

                          </div>
                       </div>
                    </div>
                 </div>
                 {{-- <a style="line-height:2;" type="button" class="btn btn-secondary" href="{{ url('nationl-accesser')}}">Back To Documents</a> --}}
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
         // alert(listvalue);
          if(listvalue==2){
            $('#doc-comment-textarea').show();
          }
          else if(listvalue==1)
          {
               $('#doc-comment-textarea').hide();
          }
          else if(listvalue==2)
          {
              $('#doc-comment-textarea').show();
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

