<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ModelName;
use App\Models\User;
use App\Models\ModelPermission;
use App\Models\ModelRoute;
use App\Models\RouteName;
use App\Models\Menu;
use DB;
use Session;
use Redirect;

class ModelController extends Controller
{
    public function index()
    {
        $model=ModelName::orderBy('shorting','asc')->get();
        $modellist=ModelName::orderBy('shorting','asc')->where('is_parent',0)->get();
        return view('permission.model.index',compact('model','modellist'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $model=new ModelName;
        $model->name=$request->name;



        if(!empty($request->parent_id))
        {
            $model->is_parent=1;
        }
        else
        {
            $model->is_parent=0;
        }
        $model->name=$request->name;
        $model->route=$request->route;
        $model->user_type=$request->user_type;
        $model->shorting=$request->shorting;
        if(!empty($request->parent_id))
        {
            $model->parent_id=$request->parent_id;
        }
        else
        {
            $model->parent_id=0;
        }
        $model->save();
        return redirect('admin-models')->with('success','Model Created Successfully');
    }

    public function edit_model(Request $request,$id)
    {   
        $model=ModelName::find($id);
        $modellist=ModelName::where('is_parent',0)->get();
        return view("permission.model.edit",compact("model","modellist"));


    }

    public function update_model(Request $request, $id)
    {
        $model = ModelName::findOrFail($id);
        $model->name=$request->name;
        $model->route=$request->route;
        $model->user_type=$request->user_type;
        $model->shorting=$request->shorting;
        if(!empty($request->parent_id))
        {
            $model->parent_id=$request->parent_id;
        }
        else
        {
            $model->parent_id=0;
        }
        $model->update();
        return redirect('admin-models')->with('success','Model Updated successfully');
    }

    public function delete_model($id)
    {
        $model=ModelName::findOrFail($id);
        $model->delete();
        return redirect('admin-models')->with('success','Model Deleted successfully');
       
    }

    public function assign_role($id)
    {
        $user=User::find($id);
        $permission=ModelPermission::where('permission_id',1)->where('user_id',$user->id)->get();
        $editpermission=ModelPermission::where('permission_id',2)->where('user_id',$user->id)->get();
        $viewpermission=ModelPermission::where('permission_id',3)->where('user_id',$user->id)->get();
        $dltpermission=ModelPermission::where('permission_id',4)->where('user_id',$user->id)->get();
        //dd("$permission");
        return view('permission.model.show-model-permissions',compact('user','permission','editpermission','viewpermission','dltpermission'));

    }

    public function add_user_permissions(Request $request)
    {    
        //dd($request->checkboxvalue);
        $data=ModelPermission::where('model_id',$request->model_id)->where('permission_id',1)->where('user_id',$request->user_id)->get();
        if($request->action_id==0)
        {
             $data=ModelPermission::where('model_id',$request->model_id)->where('permission_id',$request->permission_id)->where('user_id',$request->user_id)->first();
            $data->delete();
            return response()->json(['error'=>'Permission Removed Successfully']);
            
        }
        else
        {
            $model_permissions=new ModelPermission;
            $model_permissions->model_id=$request->model_id;
            $model_permissions->user_id=$request->user_id;
            $model_permissions->permission_id=$request->permission_id;
            $model_permissions->save();
        }
       
        
        $data=ModelPermission::where('model_id',$request->model_id)->where('permission_id',1)->where('user_id',$request->user_id)->get();
        return response()->json(['success'=>'Permission Granted Successfully']);
        
         
    }
    

    public function user_multiple_permissions(Request $request)
    {    
        //return response()->json([$request->model_ids]);
        
        $delete=ModelPermission::where("user_id",$request->user_id)->where("permission_id",$request->permission_id)->delete();
        if($request->action_id){
            foreach($request->model_ids as $model_id)
            {   
                //dd($add_checkbox_field);
                $model_permissions=new ModelPermission;
                $model_permissions->model_id=$model_id;
                $model_permissions->user_id=$request->user_id;
                $model_permissions->permission_id=$request->permission_id;
                $model_permissions->save();
            } 
            return response()->json(['success'=>'Permission Granted Successfully']);
              
        }
        
        return response()->json(['success'=>'Permission Removed Successfully']);
    }

    public function model_routes()
    {   
        //$model_routes=ModelRoute::all();
        
        $model_routes=DB::table('model_routes')->select('model_routes.*','route_names.method','route_names.name as route_name','route_names.path as route_path','model_names.name as model_name')
        ->join('route_names','model_routes.route_id','=','route_names.id')
        ->join('model_names','model_routes.model_id','=','model_names.id')
        ->get();
        //return $model_routes;
        $routes=RouteName::all();
        $models=ModelName::all();
        return view('permission.model.model-routes',compact('model_routes','routes','models'));
    }

    public function add_model_routes(Request $request)
    {
        $this->validate($request, [
            'model_id' => 'required',
            'route_id' => 'required',
        ]);
        $model_route=new ModelRoute;
        $model_route->model_id=$request->model_id;
        $model_route->route_id=$request->route_id;
        $model_route->save();
        return redirect('model-routes')->with('success','Model Routes Created Successfully');
    }

    public function edit_model_routes(Request $request,$id)
    {   
        $model_routes=ModelRoute::find($id);
        $routes=RouteName::all();
        $models=ModelName::all();

        return view("permission.model.edit-model-routes",compact("model_routes",'routes','models'));
    }
    
    public function update_model_routes(Request $request,$id)
    {
        $this->validate($request, [
            'model_id' => 'required',
            'route_id' => 'required',
        ]);
        $model_route=ModelRoute::find($id);
        $model_route->model_id=$request->model_id;
        $model_route->route_id=$request->route_id;
        $model_route->save();
        return redirect('model-routes')->with('success','Model Routes Updated Successfully');
    }

    public function delete_model_route(Request $request,$id)
    {
       $model_route=ModelRoute::find($id);
       $model_route->delete();
       return redirect('model-routes')->with('success','Model Routes Deleted Successfully');
    }

}
