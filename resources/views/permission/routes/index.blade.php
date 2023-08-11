@extends('layouts.app-file')
@section('content')


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
                     <h4 class="page-title">Add Routes</h4>
                  </li>
                  <li class="breadcrumb-item bcrumb-1">
                     <a>
                     <i class="fas fa-home"></i> Home</a>
                  </li>
                  <li class="breadcrumb-item bcrumb-2">
                     <a href="#" onClick="return false;">Route</a>
                  </li>
                  <li class="breadcrumb-item active">Add Routes</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
               <div class="header">
                  <h2>
                     <strong>Add</strong> Routes
                  </h2>
               </div>
               <form action="{{ url('add-new-routes') }}" method="post">
               @csrf
               <div class="body">
                  <div class="row clearfix">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <div class="form-line">
                              <label >Routes Name</label>
                              <input type="text" class="form-control" name="name" placeholder="Route Name">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <div class="form-line">
                              <label >Action</label>
                              <input type="text" class="form-control" name="path" placeholder="Action">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group default-select select2Style">
                              <label>Methods</label>
                              <select class="form-control select2" name="method" required>
                                 <option value="">Select Methods ...</option>
                                 <option value="GET">GET</option>
                                 <option value="POST">POST</option>
                                 <option value="PATCH">PATCH</option>
                                 <option value="PUT">PUT</option>
                                 <option value="DELETE">DELETE</option>
                              </select>
                           </div>
                        </div>
                     <div class="col-sm-3">
                        <div class="form-group default-select select2Style">
                               <label>Permissions ...</label>
                                <select class="form-control select2" name="permission_id">
                                    <option value="">Select Permissions ...</option>
                                    @foreach($permission as $permissions)
                                         <option value="{{ $permissions->id}}">{{ $permissions->name}}</option>
                                    @endforeach
                                </select>
                           </div>
                        </div>
                     </div>


                  <div class="col-lg-12 p-t-20 text-center">
                     <button type="submit" class="btn btn-primary waves-effect m-r-15">Add Routes</button>

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
                              <th class="center"> Route Name </th>
                              <th class="center"> Method </th>
                              <th class="center">Route Action </th>
                              <th class="center">Permission </th>
                              <th class="center"> Action </th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($route as $key => $routes)
                           <tr class="odd gradeX">
                              <td class="center">{{ $key+1 }}</td>
                              <td class="center">{{ $routes->name }}</td>
                              <td class="center">{{ $routes->method }}</td>
                              <td class="center">{{ $routes->path }}</td>
                              <td class="center">@foreach($permission as $permission_temp) @if($routes->permission_id==$permission_temp->id) {{$permission_temp->name}} @endif @endforeach</td>
                               <td class="center">
                                    <a href="{{ url('edit-routes/'.$routes->id) }}" class="btn btn-tbl-edit">
                                       <i class="material-icons">edit</i>
                                    </a>

                                    <a  href="{{ url('routes-dlt/'.$routes->id) }}" class="btn btn-tbl-delete" onclick="return confirm_option('delete')">
                                       <i class="material-icons">delete_forever</i>
                                    </a>
                                </td>

                           </tr>
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
@endsection
