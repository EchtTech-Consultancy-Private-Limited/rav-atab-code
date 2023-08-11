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
                     <h4 class="page-title">Add Model Routes</h4>
                  </li>
                  <li class="breadcrumb-item bcrumb-1">
                     <a>
                     <i class="fas fa-home"></i> Home</a>
                  </li>
                  <li class="breadcrumb-item bcrumb-2">
                     <a href="#" onClick="return false;">Model Routes</a>
                  </li>
                  <li class="breadcrumb-item active">Add Model Routes</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
               <div class="header">
                  <h2> 
                     <strong>Add</strong> Model Routes
                  </h2>
               </div>
               <form action="{{ url('add-model-routes') }}" method="post">
               @csrf
               <div class="body">
                  <div class="row clearfix">
                     <div class="col-sm-6">
                        <div class="form-group default-select select2Style">
                              <label >Models Name</label>
                              <select class="form-control select2" name="model_id">
                                 <option value="">Select Models</option>
                                 @foreach($models as $modelslist)
                                     <option value="{{ $modelslist->id}}">{{ $modelslist->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     <div class="col-sm-6">
                        <div class="form-group default-select select2Style">
                           <label >Routes Name</label>
                              <select class="form-control select2" data-placeholder="Select" name="route_id" required >
                                 <option value="">Select Routes</option>
                                 @foreach($routes as $routeslist)
                                     <option value="{{ $routeslist->id}}">{{ $routeslist->path}} ( {{ $routeslist->method }})</option>
                                 @endforeach
                              </select>
                           </div>
                     </div>

                  </div>


                  <div class="col-lg-12 p-t-20 text-center">
                     <button type="submit" class="btn btn-primary waves-effect m-r-15">Add Model Routes</button>

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
      
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">

               <div class="body">
                  <div class="table-responsive">
                     <table class="table table-hover js-basic-example contact_list">
                        <thead>
                           <tr>

                              <th class="center"> No </th>
                              <th class="center"> Model Name </th>
                              <th class="center"> Route Name </th>
                              <th class="center"> Route  </th>
                              <th class="center"> Action </th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($model_routes as $key => $modelroutes)
                           <tr class="odd gradeX">
                              <td class="center">{{ $key+1 }}</td>
                              <td class="center">{{ $modelroutes->model_name }}</td>
                              <td class="center">{{ $modelroutes->route_name }} </td>
                              <td class="center">{{ $modelroutes->route_path }} ( {{ $modelroutes->method }})</td>
                               <td class="center">
                                    <a href="{{ url('edit-model-routes/'.$modelroutes->id) }}" class="btn btn-tbl-edit">
                                       <i class="material-icons">edit</i>
                                    </a>

                                    <a  href="{{ url('model-routes-dlt/'.$modelroutes->id) }}" class="btn btn-tbl-delete" onclick="return confirm_option('delete')">
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
