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
               <ul class="breadcrumb breadcrumb-style ">
                  <li class="breadcrumb-item">
                     <h4 class="page-title">Edit Model Routes</h4>
                  </li>
                  <li class="breadcrumb-item bcrumb-1">
                     <a>
                     <i class="fas fa-home"></i> Home</a>
                  </li>
                  <li class="breadcrumb-item bcrumb-2">
                     <a href="#" onClick="return false;">Model</a>
                  </li>
                  <li class="breadcrumb-item active">Edit Model Routes</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
               <div class="header">
                  <h2>
                     <strong>Edit</strong> Model Routes
                  </h2>
               </div>
               <form action="{{ url('update-model-routes/'.$model_routes->id) }}" method="post">
               @csrf
               <div class="body">
                  <div class="row clearfix">
                     <div class="col-sm-6">
                        <div class="form-group default-select select2Style">
                              <label >Models Name</label>
                              <select class="form-control select2" name="model_id">
                                 <option value="">Select Models</option>
                                 @foreach($models as $modelslist)
                                     <option value="{{ $modelslist->id}}" {{$model_routes->model_id == $modelslist->id  ? 'selected' : ''}}>{{ $modelslist->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     <div class="col-sm-6">
                        <div class="form-group default-select select2Style">
                              <label >Routes Name</label>
                              <select class="form-control select2" name="route_id" required>
                                 <option value="">Select Routes</option>
                                 @foreach($routes as $routeslist)
                                     <option value="{{ $routeslist->id}}" {{$model_routes->route_id == $routeslist->id  ? 'selected' : ''}}>{{ $routeslist->path}} ( {{ $routeslist->method }})</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>

                  </div>
                  
                 
                  <div class="col-lg-12 p-t-20 text-center">
                     <button type="submit" class="btn btn-primary waves-effect m-r-15">Update</button>
                     <a href="{{ url('model-routes') }}" type="button" class="btn btn-danger waves-effect">Back To Model Routes</a>
                  </div>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>

@endsection