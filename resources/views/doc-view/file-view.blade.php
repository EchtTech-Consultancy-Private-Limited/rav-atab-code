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


        @if(Auth::user()->role  == 1 )

        @include('layout.sidebar')

        @elseif(Auth::user()->role  == 2)

        @include('layout.siderTp')

        @elseif(Auth::user()->role  == 3)

        @include('layout.sideAss')

        @elseif(Auth::user()->role  == 4)

        @include('layout.sideprof')

        @elseif(Auth::user()->role  == 5)

        @include('layout.secretariat')

        @elseif(Auth::user()->role  == 6)

        @include('layout.sidbarAccount')

        @endif

        @include('layout.rightbar')

    </div>



    <section class="content">
        <div class="container-fluid">
            

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

                                <div>
                                        <!-- <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="card project_widget">
                                                    <div class="card-header">
                                                        <h4>Create NC</h4>
                                                    </div>
                                                    <div class="body">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-4">
                                                                  

                                                                    <label>Select Type</label>

                                                                    <select required
                                                                        class="form-control required text-center"
                                                                        name="status" id="status">
                                                                        <option value="" selected disabled>--Select--</option>
                                                                        
                                                                    </select>

                                                                </div>


                                                                <div class="col-sm-12" id="comment-section">
                                                                    <label for="comment_text">Remark</label>
                                                                    <textarea rows="10" cols="60" id="comment_text" name="doc_comment" class="form-control" required></textarea>
                                                                    <small id="char-count-info">0/500 characters</small>
                                                                </div>
                                                            </div>


                                                    </div>

                                                    <div class="card-footer">
                                                        <button id="submitBtn" type="button" value="Submit"
                                                            class="btn btn-primary" onclick="desktopDocumentVerfiy()">Submit</button>
                                                    </div>

                                </div>


                            </div>
                        </div> -->
                    </div>

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card project_widget">

                                        <div class="body">
                                            
                                            <object data="{{ asset('documnet'.'/'.$data) }}" type="application/pdf" width="100%" height="500px">
                                                <p>Unable to display PDF file.
                                               <a href="{{ asset('documnet'.'/'.$data) }}">Download</a> instead.</p>
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


    @include('layout.footer')

