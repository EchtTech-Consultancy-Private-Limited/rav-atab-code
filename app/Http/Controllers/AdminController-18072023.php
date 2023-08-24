<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use Hash;
use Redirect;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Manuals;
use DB;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
        return view("dashboard");
        }
        return redirect('/');
    }

//Admin user crud

    public function  user_index()
    {
      $data = user::where('role','1')->orderBy('id','DESC')->get();
      return view('user.index',['data'=> $data]);
    }

    public function  add_user()
    {
        $Country =Country::get();
        return view('user.manageuser',['Country'=>$Country]);
    }

    public function aduser_post(Request $request)
    {
        $request->validate(
        [
            'organization' => ['required'],
            'title' => 'required',
            'firstname' => 'required|max:32|min:2',
            'lastname' =>'required|max:32|min:2',
            'email' => ['required','string','email','max:50','unique:users'],
            'designation' => ['required'],
            'gender' => ['required'],
            'address' => 'required',
            'mobile_no'=>'required|numeric|min:10|unique:users,mobile_no|numeric|digits:10',
            'Country'=> ['required'],
            'state' => 'required',
            'city' => 'required',
            'postal'=> 'required',
        ]
    );

        $data = new user;
        $data->title = $request->title;
        $data->firstname =$request->firstname;
        $data->middlename =$request->middlename;
        $data->lastname =$request->lastname;
        $data->email =$request->email;
        $data->password =  Hash::make($request->password);
        $data->organization =$request->organization;
        $data->designation =$request->designation;
        $data->gender =$request->gender;
        $data->address =$request->address;
        $data->mobile_no =$request->mobile_no;
        $data->country =$request->Country;
        $data->state =$request->state;
        $data->city =$request->city;
        $data->postal =$request->postal;
        $data->phone_no =$request->phone_no;
        $data->last_login_ip =$request->last_login_ip;
        $data->status =$request->status;
        $data->role =$request->role;
        $data->about =$request->about;
        $data->last_login_at =$request->last_login_at;
        $data->save();

        if( $request->role = '1')
        {
        return redirect('/admin-user')->with('success', 'User Add successfull!!');
        }
        elseif($request->role = '2')
        {
        return redirect('/training-provider')->with('success', 'User Add successfull!!');
        }
        elseif($request->role = '3')
        {
        return redirect('/assessor-user')->with('success', 'User Add successfull!!');
        }

    }

    public function deleteRecord($id){
        $e = user::find(dDecrypt($id));
        $e->delete();
        return back()->with('success', 'Delete successfull!!');
    }


    public function updateRecord($slug,$id){
     $data=DB::table('users')->where('users.id',dDecrypt($id))->select('users.*','cities.name as city_name','states.name as state_name')->join('cities','users.city', '=', 'cities.id')->join('states','users.state', '=', 'states.id')->first();
     $Country =Country::get();
     return view('user.update-admin',['data'=>$data,'Country'=>$Country]);
    }



    public function updateRecord_post(Request $request,$id)
    {

      $request->validate(
        [
            'organization' => ['required'],
            'title' => 'required',
            'firstname' => 'required',
            'lastname' =>'required',
            'email' => ['required'],
            'designation' => ['required'],
            'gender' => ['required'],
            'address' => 'required',
            'mobile_no'=>'required',
            'Country'=> ['required'],
            'state' => 'required',
            'city' => 'required',
            'postal'=> 'required',
        ]
    );


        $data=user::find(dDecrypt($id));
        $data->title = $request->title;
        $data->firstname =$request->firstname;
        $data->middlename =$request->middlename;
        $data->lastname =$request->lastname;
        $data->email =$request->email;
        if(!empty($request->password))
         {
          $data->password = Hash::make($request->password);
         }
        $data->organization =$request->organization;
        $data->designation =$request->designation;
        $data->gender =$request->gender;
        $data->address =$request->address;
        $data->mobile_no =$request->mobile_no;
        $data->country =$request->Country;
        $data->state =$request->state;
        $data->city =$request->city;
        $data->postal =$request->postal;
        $data->phone_no =$request->phone_no;
        $data->last_login_ip =$request->last_login_ip;
        $data->status =$request->status;
        $data->role =$request->role;
        $data->about =$request->about;
        $data->last_login_at =$request->last_login_at;
        $data->save();

         if( $request->role = '1')
        {
        return redirect('/admin-user')->with('success', 'User Add successfull!!');
        }
        elseif($request->role = '2')
        {
        return redirect('/training-provider')->with('success', 'User Add successfull!!');
        }
        elseif($request->role = '3')
        {
        return redirect('/assessor-user')->with('success', 'User Add successfull!!');
        }

    }


//profile section
public function  profile()
{
  //  dd('yes');
    $id = Auth::user()->id;
    $data=DB::table('users')->where('users.id',$id)->select('users.*','cities.name as city_name','states.name as state_name')->join('cities','users.city', '=', 'cities.id')->join('states','users.state', '=', 'states.id')->first();
    $Country =Country::get();
    return view('user.profile',['data'=>$data,'Country'=>$Country]);
}


public function profile_submit(Request $request,$id)
{

      dd($id);

  $request->validate(
    [
        'organization' => ['required'],
        'title' => 'required',
        'firstname' => 'required',
        'lastname' =>'required',
        'email' => ['required'],
        'designation' => ['required'],
        'gender' => ['required'],
        'address' => 'required',
        'mobile_no'=>'required',
        'Country'=> ['required'],
        'state' => 'required',
        'city' => 'required',
        'postal'=> 'required',
    ]
);


    $data=user::find(dDecrypt($id));
    $data->title = $request->title;
    $data->firstname =$request->firstname;
    $data->middlename =$request->middlename;
    $data->lastname =$request->lastname;
    $data->email =$request->email;
    $data->organization =$request->organization;
    $data->designation =$request->designation;
    $data->gender =$request->gender;
    $data->address =$request->address;
    $data->mobile_no =$request->mobile_no;
    $data->country =$request->Country;
    $data->state =$request->state;
    $data->city =$request->city;
    $data->postal =$request->postal;
    $data->phone_no =$request->phone_no;
    $data->last_login_ip =$request->last_login_ip;
    $data->status =$request->status;
    $data->role =$request->role;
    $data->about =$request->about;
    $data->last_login_at =$request->last_login_at;

    if(!empty($request->password))
     {
        $data->password = Hash::make($request->password);

     }


    // if($request->hasfile('file'))
    // {
    //     $img = $request->file('file');
    //     $name =$img->getClientOriginalName();
    //     $filename = time().$name;
    //     $img->move('profile/',$filename);
    //     $data->file=$filename;
    // }
    $data->save();
    return back()->with('success', 'Your profile successfully updated !!!!!');

}


//active user section
public function active_user($id)
{
    $user=User::find(dDecrypt($id));
    $user->status=($user->status==1?'0':'1');
    $user->update();
    return Redirect::back()->with('success', 'Status Changed Successfully');
}

//index page
public function  tp_index()
{
    $data = user::where('role','2')->orderBy('id','DESC')->get();
 return view('user.index',['data'=> $data]);
}

public function  assessor_user()
{
    $data = user::where('role','3')->orderBy('id','DESC')->get();
return view('user.index',['data'=> $data]);
}

public function  professional_user()
{
    $data = user::where('role','4')->orderBy('id','DESC')->get();
return view('user.index',['data'=> $data]);
}


//phone_code

public function phone_code()
{
  $data =Country::get();
  return response()->json($data, 200);
}

public function user_view($id)
{

    // $data = user::where('id',dDecrypt($id))->first();

     $data=DB::table('users')->where('users.id',dDecrypt($id))->select('users.*','cities.name as city_name','states.name as state_name','countries.name as country_name')->join('countries','users.country', '=', 'countries.id')->join('cities','users.city', '=', 'cities.id')->join('states','users.state', '=', 'states.id')->first();
     return view('user.view-user',['data'=>$data]);

}


public function manage_manual()
{
    $data = manuals::where('status','1')->orderBy('id','DESC')->get();
    return view('user.manage-manual',['data'=>$data]);
}

public function save_manual(Request $request)
{
        $data = new manuals;
        $data->type = $request->m_type;
        $data->description = $request->m_description;
        $data->status = 1;

        if($request->hasfile('file'))
        {
            $img = $request->file('file');
            $name =$img->getClientOriginalName();
            $filename = time().$name;
            $img->move('manuals/',$filename);
            $data->manual_file=$filename;
        }
        $data->save();
        return back()->with('success', 'Manual has been successfully added!');
}

public function delete_manual($id)
{
    $delete = manuals::where('id', $id)->firstorfail()->delete();
    return redirect()->route('manage-manual');
}

}
