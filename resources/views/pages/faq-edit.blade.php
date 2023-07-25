@include('layout.header')


<title>FAQ: RAV Accreditation</title>

<style>
.error{
     color: red;
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
                                <a href="#" onClick="return false;">FAQ</a>
                            </li>
                            <li class="breadcrumb-item active">Edit FAQ</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>Edit</strong> FAQ</h2>
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

                        <form action="{{ url('update-faq'.'/'.dEncrypt($data->id))  }}" method="post">

                            @csrf
                        <div class="body">
                                <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                            <label><strong>FAQ Cateogry</strong></label>
                                        <div class="form-line">
                                            <select class="form-control"  name="category" id="category">
                                            @if(count(getFaqCategory())>0)
                                                @foreach(getFaqCategory() as $key=>$value)
                                                    <option value="{{$key}}" @if($data->category ==$key) SELECTED @endif>{{$value}}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                            @error('question')
                                                <label for="documents_required"  id="documents_required-error" class="error">
                                                {{ $message }}
                                                </label>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                            <label><strong>Question</strong></label>
                                        <div class="form-line">
                                            <textarea class="form-control" name="question" id="question"  placeholder="Enter Question">{{ $data->question }}</textarea>
                                            @error('question')
                                                <label for="documents_required"  id="documents_required-error" class="error">
                                                {{ $message }}
                                                </label>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                            <label><strong>Answer</strong></label>
                                        <div class="form-line">
                                            <textarea class="form-control" name="answer" id="answer"  placeholder="Enter Answer">{{ $data->answer }}</textarea>
                                            @error('answer')
                                                <label for="documents_required"  id="documents_required-error" class="error">
                                                {{ $message }}
                                                </label>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                            <label><strong>Sort Order</strong></label>
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="sort_order" id="sort_order"  placeholder="Enter Sort Order" value="{{ $data->sort_order }}">
                                            @error('sort_order')
                                                <label for="documents_required"  id="documents_required-error" class="error">
                                                {{ $message }}
                                                </label>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 p-t-20 text-center">
                                <button type="submit" class="btn btn-primary waves-effect m-r-15">Submit</button>
                                <a  href="{{ URL::previous() }}" class="btn btn-danger waves-effect">Back</a>
                            </div>

                         </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="{{asset('assets/js/bundles/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
    <script>
         tinymce.init({
        selector: 'textarea#answer',
        menubar: 'edit insert view format table tools',
        plugins: 'lists',
        toolbar: 'undo redo styles bold italic alignleft aligncenter alignright alignjustify | bullist numlist outdent indent'
      });
    </script>



    </section>



    @include('layout.footer')
