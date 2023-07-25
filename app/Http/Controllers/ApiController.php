<?php

namespace App\Http\Controllers;
use App\Models\Usersss;
use Auth;
use Hash;
use Redirect;
use DB;
use Response;


use Illuminate\Http\Request;

class ApiController extends Controller
{


    public function store(Request $request)
    {
        $request->validate(
        [
            'first_name' => ['required'],
            'last_name' => 'required',
            'email' => 'required|max:32|min:2',
            'password' =>'required|max:32|min:2'
        ]
    );

        $data = new usersss;
        $data->title = $request->title;
        $data->fname = $request->first_name;
        $data->lname =$request->last_name;
        $data->email =$request->email;
        $data->password =$request->password;
        $data->save();

        return [
            "status" => 1,
            "data" => $data
        ];
   
        //echo json_decode($data);
    }

    public function loginpost(Request $request) {
        $request->validate(
        [
            'email' => 'required|max:32|min:2',
            'password' =>'required|max:32|min:2'
        ]);
        
        $email = $request->email;
        $password = $request->password;
        
        $users = DB::table('userssses')->where('email','=',$email)->where('password','=',$password)->first();
        
        if(!empty($users))
        {
            return Response::json([
                'data' => $users
            ], 200);
        }
        else
        {
            return Response::json([
                'data' => $users
            ], 201);
        }
    }
}
