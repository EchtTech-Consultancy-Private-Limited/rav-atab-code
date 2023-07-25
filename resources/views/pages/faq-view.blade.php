@include('layout.header')


<title>FAQ: RAV Accreditation</title>

<style>
.error{
     color: red;
}


nav {
    box-shadow:none!important;
    webkit-box-shadow:none!important;
  }
  nav .justify-content-sm-between{
    background-color: #fff!important;
    font-size: 14px;
    color: #555;
    box-shadow:none!important;
    webkit-box-shadow:none!important;
  }
  nav small,nav .small {
    font-size: 14px;
  }

  .page-item .page-link{
    display: inline!important;
  }

  .alert
  {
  	color: #000 !important;
  }
  
</style>


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
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">View FAQs</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">FAQs</a>
                            </li>

                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">General FAQs</a>
                            </li>
                           
                        </ul>
                    </div>
                </div>
            </div>
           

                    
                        @foreach($faqs as $k=>$faq)
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="profile-tab-box">
                                            <div class="p-l-20">
                                            <span style="font-weight:bold">Question {{$k+1}}:</span><br> {{$faq->question}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="profile-tab-box">
                                            <div class="p-l-20">
                                            <span  style="font-weight:bold">Answer:</span><br> {!!$faq->answer!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           @endforeach
                                  
                      
                           
                        </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>

   


    </section>



    @include('layout.footer')
