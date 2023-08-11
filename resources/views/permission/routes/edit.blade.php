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
                     <h4 class="page-title">Edit Route</h4>
                  </li>
                  <li class="breadcrumb-item bcrumb-1">
                     <a>
                     <i class="fas fa-home"></i> Home</a>
                  </li>
                  <li class="breadcrumb-item bcrumb-2">
                     <a href="#" onClick="return false;">Route</a>
                  </li>
                  <li class="breadcrumb-item active">Edit Route</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
               <div class="header">
                  <h2>
                     <strong>Edit</strong> Route
                  </h2>
               </div>
               <form action="{{ url('update-routes/'.$route->id) }}" method="post">
               @csrf
               <div class="body">
                  <div class="row clearfix">
                     <div class="col-sm-3">
                        <div class="form-group">
                           <div class="form-line">
                            <label >Route Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $route->name }}">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <div class="form-line">
                            <label >Action</label>
                            <input type="text" class="form-control" name="path" value="{{ $route->path }}">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <div class="form-line">
                              <label>Method</label>
                              <select class="form-control" name="method" required>
                                 <option value="">Select Methods ...</option>
                                 <option value="GET" @if($route->method=='GET') SELECTED @endif>GET</option>
                                 <option value="POST" @if($route->method=='POST') SELECTED @endif>POST</option>
                                 <option value="PATCH" @if($route->method=='PATCH') SELECTED @endif>PATCH</option>
                                 <option value="PUT" @if($route->method=='PUT') SELECTED @endif>PUT</option>
                                 <option value="DELETE" @if($route->method=='DELETE') SELECTED @endif>DELETE</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group">
                           <div class="form-line">
                              <label>Permission</label>
                                <select class="form-control" name="permission_id">
                                    <option value>Select Permission ...</option>
                                    @foreach($permission as $permissions)
                                            <option value="{{ $permissions->id}}" {{$permissions->id == $route->permission_id  ? 'selected' : ''}}>{{ $permissions->name}}</option>
                                    @endforeach
                                </select>
                           </div>
                        </div>
                     </div>
                  </div>


                  <div class="col-lg-12 p-t-20 text-center">
                     <button type="submit" class="btn btn-primary waves-effect m-r-15">Update</button>
                     <a href="{{ url('admin-routes') }}" type="button" class="btn btn-danger waves-effect">Back To Routes</a>
                  </div>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>

@endsection
