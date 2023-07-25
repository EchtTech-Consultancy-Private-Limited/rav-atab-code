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
                                <h4 class="page-title">Manage FAQs</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{url('/dashboard')}}">
                                    <i class="fas fa-home"></i> Home</a>
                            </li>
                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">FAQs</a>
                            </li>

                            <li class="breadcrumb-item bcrumb-2">
                                <a href="#" onClick="return false;">All FAQs</a>
                            </li>
                           
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                            <span style="float:right;" >
                                <a type="button" href="{{ url('/add-faq') }}" class="btn btn-primary waves-effect" style="line-height:2;"  title="Add Record">+ Add Faq</a>
                            </span>
                            <ul style="float:right; overflow:hidden;">
                            <form role="form" method="POST" action="{{ url('get-faqs') }}" id="frmfaqs">
                                @csrf
                                <li style="float:left;clear:none; margin-top:0px; margin-right:10px;"> 
                                    <select class="form-control" name="category" onchange="javascript:$('#frmfaqs').submit();">
                                        <option value="">Filter Category</option>
                                        @php
                                            $categories=getFaqCategory();
                                        @endphp
                                        @foreach($categories as $key=>$value)
                                        <option value="{{$key}}" @if(request()->category==$key) SELECTED @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </li>
                            </form>
                            </ul>
                            {{-- <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu float-end">
                                        <li>
                                            <a href="javascript:void(0);">Action</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">Another action</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">Something else here</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul> --}}
                        </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example contact_list" id="data_table">
                                    <thead>
                                        <tr>
                                            <th class="center">S.No#</th>
                                            <th class="center"> Question </th>
                                            <th class="center"> Category </th>
                                            <th class="center"> Sort Order </th>
                                            <th class="center"> Created At </th>
                                            <th class="center"> Status </th>
                                            <th class="center"> Action </th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                    @foreach($faqs as $k=>$faq)
                                        <tr class="odd gradeX">
                                            <td class="center">@if(request()->page){{(((request()->page-1)*10)+$k+1)}}@else{{($k+1)}}@endif</td>
                                            <td class="center">{{$faq->question}}</td>
                                            <td class="center">{{$categories[$faq->category]}}</td>
                                            <td class="center">{{$faq->sort_order}}</td>
                                            <td class="center">{{date('d-m-Y',strtotime($faq->created_at))}}</td>
                                            <td class="center">
                                                <a href="{{ url('activate-faq/'.dEncrypt($faq->id)) }}" onclick="return confirm('Are you sure to change status?')" class="@if($faq->status==0) btn-tbl-disable @elseif($faq->status==1) btn-tbl-edit @endif" title="Change Status">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                           </td>
                                            <th class="center">
                                                <a class="btn btn-primary btn-sm" href="{{ url('/update-faq'.'/'.dEncrypt($faq->id)) }}" onclick="return confirm('Are you sure to edit this faq record?')" title="Edit Record">
                                                    <i style="line-height:1.5 !important;" class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" href="{{ url('/delete-faq'.'/'.dEncrypt($faq->id)) }}"  onclick="return confirm('Are you sure to delete this faq record?')" title="Delete Record">
                                                    <i class="fa fa-trash" aria-hidden="true" style="line-height:1.5 !important;" ></i>
                                                </a>
                                            </th>
                                           
                                        </tr>
                                        @endforeach
                                    </tbody>
                                   
                                </table>
                                
                            </div>
                            {{ $faqs->links('pagination::bootstrap-5') }}
                        </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>

   


    </section>



    @include('layout.footer')
