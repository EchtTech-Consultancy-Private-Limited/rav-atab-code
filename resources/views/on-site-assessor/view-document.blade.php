@include('layout.header')



<title>RAV Accreditation</title>

<style>
    .selectINputBox {
        padding: 8px !important;
        border: 1px solid #ccc !important;
        width: 300px !important;
    }
</style>
</head>

<body class="light">



    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    @include('layout.topbar')

    <div>

        @if (Auth::user()->role == '1')
            @include('layout.sidebar')
        @elseif(Auth::user()->role == '2')
            @include('layout.siderTp')
        @elseif(Auth::user()->role == '3')
            @include('layout.sideAss')
        @elseif(Auth::user()->role == '4')
            @include('layout.sideprof')
        @endif


        @include('layout.rightbar')


    </div>

    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: "Success",
                text: "{{ $message }}",
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">Upload Document</h4>
                            </li>
                            <li class="breadcrumb-item bcrumb-1">
                                <a href="{{ url('/dashboard') }}">
                                    <i class="fas fa-home"></i> Level </a>
                            </li>
                            <li class="breadcrumb-item active">Upload Documents</li>


                        </ul>
                    </div>

                </div>
            </div>

    

            @if ($document != null)
                @php
                    $comment = getLastComment($document->id);
                @endphp
                @if ($comment != null)
                <div class="card">
                    <div class="card-header bg-white text-dark">
                        <h5 class="mt-2">
                             Comments
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <h5>
                            {{ $comment->comments }}
                        </h5>
                    </div>
                   </div>
                @endif
         
         <div class="card">
            <div class="card-header bg-white text-dark">
                <h5 class="mt-2">
                    ON SITE ASSESSOR
                </h5>
            </div>
            <div class="card-body">
                @php
                    $pdfUrl = url('level' . '/' . $document->doc_file);
                    $fileExtension = pathinfo($pdfUrl, PATHINFO_EXTENSION);
                @endphp

                @if ($fileExtension === 'pdf')
                    <object data="{{ $pdfUrl }}" type="application/pdf" width="100%" height="500px">
                        <p>Unable to display PDF. <a href="{{ $pdfUrl }}" target="_blank">Download
                                Document</a> </p>
                    </object>
                @else
                    <a class="btn btn-info btn-sm" href="{{ $pdfUrl }}" target="_blank">Download
                        Document</a>
                @endif
            </div>
        </div>
         @endif

        </div>
    </section>
    @include('layout.footer')
