@extends('layouts.app-file')
@section('content')

<section class="content">
<style>
	.unauthorised
	{
        text-align:center;
        font-size:16px!important;
        color:red;
	}
</style>
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
            <div class="container-fluid">

        <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
         <div class="card">
         
         <div class="header">
         </div>
            
           
                        <div class="body">
                            <div class="table-responsive unauthorised">
                               
                           <i class="icons-stop">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i> You have no permission to perform this task!
                                
                            </div>
                           
                        </div>
                       
               
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   
        
      </section>   
   

@endsection