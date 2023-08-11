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
                     <h4 class="page-title">Edit Module</h4>
                  </li>
                  <li class="breadcrumb-item bcrumb-1">
                     <a href="{{url('/dashboard')}}">
                     <i class="fas fa-home"></i> Home</a>
                  </li>
                  <li class="breadcrumb-item bcrumb-2">
                     <a href="{{ url()->previous() }}" onClick="return true;">Module</a>
                  </li>
                  <li class="breadcrumb-item active">Edit Module</li>
               </ul>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
               <div class="header">
                  <h2>
                     <strong>Edit</strong> Module
                  </h2>
               </div>
               <form action="{{ url('update-model/'.$model->id) }}" method="post">
               @csrf
               <div class="body">
                  <div class="row clearfix">
                        <div class="col-sm-3">
                           <div class="form-group">
                              <div class="form-line">
                                 <label>Module Name</label>
                                 <input type="text" class="form-control" name="name" placeholder="Module Name" value="{{ $model->name }}">
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <div class="form-line">
                                 <label >Route</label>
                                 <input type="text" class="form-control" name="route" value="{{ $model->route }}" placeholder="Route">
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <div >
                                  <label class="form-label">Select Parent</label>
                                   <select class="form-control select2" name="parent_id">
                                       <option value>Select Parent Menu...</option>
                                       @foreach($modellist as $modellists)
                                            <option value="{{ $modellists->id}}"  {{$modellists->id == $model->parent_id  ? 'selected' : ''}}>{{ $modellists->name}}</option>
                                       @endforeach
                                   </select>
                              </div>
                           </div>
                        </div>

                        <div class="col-sm-3">
                           <div class="form-group">
                               <label class="form-label">Select User Type</label>
                                <select class="form-control select2" name="user_type">
                                    <option value>Select User Type...</option>
                                    @foreach(__('phr.user_type_model') as $key=>$value)
                                       <option value="{{$key}}" {{$key == $model->user_type  ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                           </div>
                        </div>
                        <div class="col-sm-3">
                           <div class="form-group">
                              <div class="form-line">
                                 <label >Shorting</label>
                                 <input type="number" class="form-control" name="shorting" placeholder="shorting" value="{{ $model->shorting }}">
                              </div>
                           </div>
                        </div>

                        <div class="col-sm-3">
                           <div class="form-group">
                              <button type="submit" class="btn btn-primary waves-effect m-r-15">Update</button>
                              <a href="{{ url('admin-models') }}" type="button" class="btn btn-danger waves-effect">Back To Modules</a>
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

@endsection