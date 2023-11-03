@include('layout.header')


<title>RAV Accreditation</title>

<style>
    .remarkTable th, td{
        padding: 10px !important;
    }
</style>

</head>

<body class="light">
   
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
            

            @if(Session::has('sussess'))
            <div class="alert alert-success" role="alert">
                {{session::get('sussess')}}
            </div>
            @elseif(Session::has('fail'))
            <div class="alert alert-danger" role="alert">
                {{session::get('fail')}}
            </div>
            @endif

            @if (auth()->user()->role == 2 || auth()->user()->role == 3)
            <form action="{{ url('submit-remark') }}" method="post">
                @csrf
                <input type="hidden" name="document_id" value="{{ $document_id ?? 0 }}">
                <input type="hidden" name="application_id" value="{{ $application_id ?? 0 }}">
                <input type="hidden" name="tpId" value="{{ $tpId ?? 0 }}">
                <div class="card">
                    <div class="card-header bg-white text-dark">
                        <h5 class="mt-2">
                           Write Remark
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea name="remark" class="form-control" placeholder="Write remark..."></textarea>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mb-0">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            @if (!$remarks->isEmpty())
            <div class="card">
                <div class="card-header bg-white text-dark">
                    <h5 class="mt-2">
                        Remark History
                    </h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover remarkTable mb-0">
                        <thead>
                            <th>Sr.No</th>
                            <th>Remark</th>
                            <th>Added By</th>
                        </thead>
                        <tbody>
                            @foreach ($remarks as $remark)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $remark->remark }}</td>
                                    <td>{{ $remark->user->firstname ?? '' }} {{ $remark->user->middlename ?? '' }} {{ $remark->user->lastname ?? '' }}{{ $remark->created_by === auth()->user()->id ? '(You)' : ''}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @endif
          
            <div class="row ">

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="level_information" aria-expanded="true">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card project_widget p-0">

                                        <div class="body p-0">

                                            <object data="{{ url('level'.'/'.$data) }}" type="application/pdf" width="100%" height="1150px">
                                                <p>Unable to display PDF file. <a href="{{ url('level'.'/'.$data) }}">Download</a> instead.</p>
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

