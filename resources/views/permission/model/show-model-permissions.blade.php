@extends('layouts.app-file')
@section('content')



<section class="content">
    @if ($message = Session::get('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p> Permission Granted Successfully</p>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
                            <h4 class="page-title">Add User Permissions</h4>
                        </li>
                        <li class="breadcrumb-item bcrumb-1">
                            <a>
                            <i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item bcrumb-2">
                            <a href="#" onClick="return false;">Permissions</a>
                        </li>
                        <li class="breadcrumb-item active">Add Permissions</li>
                    </ul>
                </div>
                </div>
            </div>
                <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">



                    <div class="body">
                        <!-- New Table Code -->
                        <div id="success-box" style="display:none;" >
                            <div class="card-body">
                                <!-- <div id="" class="alert alert-success alert-dismissible fade show"  role="alert" >
                                    <a href="#" class="close" style="float: right;font-size:20px;">&times;</a>
                                    <p class="mb-0" id="permission_added"></p>
                                </div> -->

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="mb-0" id="permission_added"></p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                            </div>
                            <div id="danger-box" style="display:none;">
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p class="mb-0" id="permission_removed"></p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>

                            </div>
                            </div>
                        <div class="table-responsive">


                            <table class="table table-hover  contact_list">
                                <p style="float:right;padding:10px;">Username: @if($user){{ $user->firstname }} @endif</p>
                            <thead>
                                <tr>
                                    <th> Model Name</th>
                                    <th ><input type="checkbox"  id="addall" onclick="umltiple_permission(this,'{{$user->id}}','1')"> Add</th> 
                                    <th><input type="checkbox" id="editall"  onclick="umltiple_permission(this,'{{$user->id}}','2')"> Edit/Update</th>
                                    <th><input type="checkbox" id="viewall"  onclick="umltiple_permission(this,'{{$user->id}}','3')"> View</th>
                                    <th><input type="checkbox" id="deleteall"  onclick="umltiple_permission(this,'{{$user->id}}','4')"> Delete</th>
                                </tr>
                            </thead>
                                @foreach(main_menu() as  $key=>$models)
                                <tbody>
                                    <tr>
                                    <th> {{$models->name}} @if($models->user_type==1) ( Admin ) @elseif($models->user_type==2) ( Guru ) @elseif($models->user_type==3) ( Shishya ) @endif</th>

                                        <td>
                                            @php $check='0'; @endphp
                                            @foreach($permission as $per)
                                            @if($per->permission_id==1 && $per->model_id==$models->id)
                                                @php $check='1'; @endphp @break;
                                            @endif
                                            @endforeach
                                            <input type="checkbox" name="add_checkbox_field[]" value="1" @if($check==1) checked @endif onclick="add_permission(this,'{{$models->id}}','{{$user->id}}','1')" class="add" >

                                            <input type="hidden" name="model_id[]" id="model_id"  value="{{ $models->id }}">
                                            <input type="hidden" name="user_id[]" value="{{ $user->id }}">
                                        </td>

                                        <td>
                                            @php $editcheck='0'; @endphp
                                            @foreach($editpermission as $per)
                                            @if($per->permission_id==2 && $per->model_id==$models->id)
                                                @php $editcheck='1'; @endphp @break;
                                            @endif
                                            @endforeach
                                            <input type="checkbox" name="edit_checkbox_field[]" value="2" class="edit" @if($editcheck==1) checked @endif onclick="add_permission(this,'{{$models->id}}','{{$user->id}}','2')">


                                        </td>

                                        <td>
                                            @php $viewcheck='0'; @endphp
                                            @foreach($viewpermission as $per)
                                            @if($per->permission_id==3 && $per->model_id==$models->id)
                                                @php $viewcheck='1'; @endphp @break;
                                            @endif
                                            @endforeach
                                            <input type="checkbox" name="view_checkbox_field[]" value="3" class="view" @if($viewcheck==1) checked @endif onclick="add_permission(this,'{{$models->id}}','{{$user->id}}','3')">


                                        </td>
                                        <td>
                                            @php $dltcheck='0'; @endphp
                                            @foreach($dltpermission as $per)
                                            @if($per->permission_id==4 && $per->model_id==$models->id)
                                                @php $dltcheck='1'; @endphp @break;
                                            @endif
                                            @endforeach
                                            <input type="checkbox" name="dlt_checkbox_field" value="4" class="delete" @if($dltcheck==1) checked @endif onclick="add_permission(this,'{{$models->id}}','{{$user->id}}','4')"></td>
                                    </tr>
                                    
                                    @if(count(main_child($models->id)) > 0 )
                                    @foreach(main_child($models->id) as  $model)
                                    <tr>
                                    <th> {{$model->name}} @if($model->user_type==1) ( Admin ) @elseif($model->user_type==2) ( Guru ) @elseif($model->user_type==3) ( Shishya ) @endif</th>

                                        <td>
                                            @php $check='0'; @endphp
                                            @foreach($permission as $per)
                                            @if($per->permission_id==1 && $per->model_id==$model->id)
                                                @php $check='1'; @endphp @break;
                                            @endif
                                            @endforeach
                                            <input type="checkbox" name="add_checkbox_field[]" value="1" @if($check==1) checked @endif onclick="add_permission(this,'{{$model->id}}','{{$user->id}}','1')" class="add" >

                                            <input type="hidden" name="model_id[]" id="model_id"  value="{{ $model->id }}">
                                            <input type="hidden" name="user_id[]" value="{{ $user->id }}">
                                        </td>

                                        <td>
                                            @php $editcheck='0'; @endphp
                                            @foreach($editpermission as $per)
                                            @if($per->permission_id==2 && $per->model_id==$model->id)
                                                @php $editcheck='1'; @endphp @break;
                                            @endif
                                            @endforeach
                                            <input type="checkbox" name="edit_checkbox_field[]" value="2" class="edit" @if($editcheck==1) checked @endif onclick="add_permission(this,'{{$model->id}}','{{$user->id}}','2')">


                                        </td>

                                        <td>
                                            @php $viewcheck='0'; @endphp
                                            @foreach($viewpermission as $per)
                                            @if($per->permission_id==3 && $per->model_id==$model->id)
                                                @php $viewcheck='1'; @endphp @break;
                                            @endif
                                            @endforeach
                                            <input type="checkbox" name="view_checkbox_field[]" value="3" class="view" @if($viewcheck==1) checked @endif onclick="add_permission(this,'{{$model->id}}','{{$user->id}}','3')">


                                        </td>
                                        <td>
                                            @php $dltcheck='0'; @endphp
                                            @foreach($dltpermission as $per)
                                            @if($per->permission_id==4 && $per->model_id==$model->id)
                                                @php $dltcheck='1'; @endphp @break;
                                            @endif
                                            @endforeach
                                            <input type="checkbox" name="dlt_checkbox_field" value="4" class="delete" @if($dltcheck==1) checked @endif onclick="add_permission(this,'{{$model->id}}','{{$user->id}}','4')"></td>
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

<!-- here -->

<script>
    $("#addall").click(function() {
      
     $("input[class=add]").prop("checked", $(this).prop("checked"));
});

$("input[class=add]").click(function() {
    if (!$(this).prop("checked")) {
        $("#addall").prop("checked", false);
    }
});



</script>
<script>
    $("#editall").click(function() {
     $("input[class=edit]").prop("checked", $(this).prop("checked"));
});

$("input[class=edit]").click(function() {
    if (!$(this).prop("checked")) {
        $("#editall").prop("checked", false);
    }
});



</script>

<script>
    $("#deleteall").click(function() {
     $("input[class=delete]").prop("checked", $(this).prop("checked"));
});

$("input[class=delete]").click(function() {
    if (!$(this).prop("checked")) {
        $("#deleteall").prop("checked", false);
    }
});

/*jackHarnerSig();*/

</script>

<script>
    $("#viewall").click(function() {
     $("input[class=view]").prop("checked", $(this).prop("checked"));
});

$("input[class=view]").click(function() {
    if (!$(this).prop("checked")) {
        $("#viewall").prop("checked", false);
    }
});



</script>

<script type="text/javascript">


         function add_permission(obj,model_id,user_id,permission_id)
         {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

          $.ajax({

           url:$baseurl+"/add-user-permissions",
           type:"POST",
           data: {"user_id":user_id,"model_id":model_id,"permission_id":permission_id,"action_id":($(obj).prop("checked")?'1':'0')},
          // processData:false,
           dataType:'json',
           //contentType:false,
           success:function(response){
             if(response) {

                     if(response.success)
                     {
                        $("#permission_added").show().html(response.success);
                        document.getElementById("success-box").style.display = 'block';
                     }

                      if(response.error)
                      {
                        $("#permission_removed").show().html(response.error);
                        document.getElementById("danger-box").style.display = 'block';
                      }

                    }

                   },

           error: function (err)
            {

                alert("error");


            },

           });

        };


</script>

<script type="text/javascript">


         function umltiple_permission(obj,user_id,permission_id)
         {
           

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var model_ids = $("input[name='model_id[]']").map(function(){return $(this).val();}).get();
            
            console.log(model_ids);


          $.ajax({
          url:$baseurl+"/user-multiple-permissions",
           type:"POST",
           data: {"user_id":user_id,"model_ids":model_ids,"permission_id":permission_id,"action_id":($(obj).prop("checked")?'1':'0')},
          // processData:false,
           dataType:'json',
           //contentType:false,
          success:function(response){
             if(response) {

                     if(response.success)
                     {
                        $("#permission_added").show().html(response.success);
                        document.getElementById("success-box").style.display = 'block';
                     }

                      if(response.error)
                      {
                        $("#permission_removed").show().html(response.error);
                        document.getElementById("danger-box").style.display = 'block';
                      }

                    }

                   },

           error: function (err)
            {

                alert("No");


            },

           });

        };


</script>
@endsection
