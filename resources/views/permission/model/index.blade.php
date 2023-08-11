 @include('layout.header')
 <title>RAV Accreditation</title>

</head>
 <!-- New CSS -->
 <link rel="stylesheet" href="{{ asset('assets/css/form.min.css') }}" class="js">
  <body class="light">
     <!-- Page Loader -->
     <div class="page-loader-wrapper">
         <div class="loader">
             <div class="m-t-30">
                 <img class="loading-img-spin" src="{{ asset('assets/images/favicon.png') }}" alt="admin">
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

<section class="content">
   <div class="container-fluid">
      <div class="block-header">
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @if ($message = Session::get('success'))
                  <div class="alert alert-success">
                     <p>{{ $message }}</p>
                    </div>
  
                  @endif
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
               <ul class="breadcrumb breadcrumb-style ">
                  <li class="breadcrumb-item">
                     <h4 class="page-title">Add Menu</h4>
                  </li>
                  <li class="breadcrumb-item bcrumb-1">
                     <a href="{{url('/dashboard')}}">
                     <i class="fas fa-home"></i> Home</a>
                  </li>
                 
                  <li class="breadcrumb-item active">Add Menu</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
               <div class="header">
                  <h2>
                     <strong>Add</strong> Menu
                  </h2>
               </div>
               <form action="{{ url('add-new-model') }}" method="post">
               @csrf
                  <div class="body">
                     <div class="row clearfix">
                        <div class="col-sm-3">
                           <div class="form-group">
                              <div class="form-line">
                                 <label>Menu Name</label>
                                 <input type="text" class="form-control" name="name" placeholder="Menu Name">
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <div class="form-line">
                                 <label >Route</label>
                                 <input type="text" class="form-control" name="route" placeholder="Route">
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                               <label class="form-label">Select Parent</label>
                                <select class="form-control select2" name="parent_id">
                                    <option value>Select Parent Menu...</option>
                                    @foreach($modellist as $modellists)
                                         <option value="{{ $modellists->id}}">{{ $modellists->name}}</option>
                                    @endforeach
                                </select>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                               <label class="form-label">Select User Type</label>
                                <select class="form-control select2" name="user_type">
                                    <option value>Select User Type...</option>
                                    @foreach(__('arrayfile.user_type_model') as $key=>$value)
                                       <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <div class="form-line">
                                 <label >Shorting</label>
                                 <input type="number" class="form-control" name="shorting" placeholder="shorting">
                              </div>
                           </div>
                        </div>

                        <div class="col-sm-3">
                           <div class="form-group">
                              <button type="submit" style="float:right;" class="btn btn-primary waves-effect m-r-15">Add Menu </button>
                           </div>
                        </div>
                     </div>
                     
                    
                     
                  </div>
               </form>
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


            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">

               <div class="body">
                  <div class="table-responsive">
                     <table class="table table-hover js-basic-example contact_list">
                        <thead>
                           <tr>

                              <th class="center"> No </th>
                              <th class="center"> Menu Name </th>
                              <th class="center"> Route Name </th>
                              <th class="center"> Action </th>
                           </tr>
                        </thead>
                        <tbody>
                        @php $k=0; @endphp
                        @foreach(main_menu() as  $key=>$models)
                        @php $k++; @endphp
                           <tr class="odd gradeX">
                              <td class="center">{{ $k }}</td>
                              <td class="center">{{ $models->name }}</td>
                              <td class="center">{{ $models->route }}</td>

                              
                               <td class="center">
                                   

                                    <a href="{{ url('edit-model/'.$models->id) }}" class="btn btn-tbl-edit">
                                       <i class="material-icons">edit</i>
                                    </a>

                                    <a  href="{{ url('model-dlt/'.$models->id) }}" class="btn btn-tbl-delete" onclick="return confirm_option('delete')">
                                       <i class="material-icons">delete_forever</i>
                                    </a>
                                </td>

                           </tr>

                              @if(count(main_child($models->id)) > 0 )
                                 @foreach(main_child($models->id) as  $key1=>$model)
                                 @php $k++; @endphp
                           <tr class="odd gradeX">
                              <td class="center">{{ $k }}</td>
                              <td class="center">{{ $model->name }}</td>
                              <td class="center">{{ $model->route }}</td>

                              
                               <td class="center">
                                   

                                    <a href="{{ url('edit-model/'.$model->id) }}" class="btn btn-tbl-edit">
                                       <i class="material-icons">edit</i>
                                    </a>

                                    <a  href="{{ url('model-dlt/'.$model->id) }}" class="btn btn-tbl-delete" onclick="return confirm_option('delete')">
                                       <i class="material-icons">delete_forever</i>
                                    </a>
                                </td>

                           </tr>
                              @endforeach
                              @endif
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<script src="{{ asset('assets/js/custom/alert.js') }}"></script>

   @include('layout.footer')
