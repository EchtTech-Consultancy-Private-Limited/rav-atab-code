<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Application;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Otp;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\emaildomeins;
use Session, Cookie;
use Mail;
use App\Mail\VerificationMobile;
use App\Mail\VerificationEmail;
use App\Mail\SendMail;
use App\Mail\SendMailRegis;

class AuthController extends Controller
{

    public function landing(Request $request)
    {   
        if(isset($_COOKIE['welcome_cookies']) && $_COOKIE['welcome_cookies'] == 'false'){
            return view('auth.landingpage');
        }
        if(isset($_COOKIE['welcome_cookies']) && $_COOKIE['welcome_cookies'] !='true' && $_COOKIE['welcome_cookies'] !='false'){
            setcookie('welcome_cookies','false');
            return view('auth.landingpage');
            
        }else{
            setcookie('welcome_cookies','true');
            return view('welcomePage');
        }
        
    }
    public function landingLogin(Request $request)
    {   
        //setcookie('welcome_cookies','false');
        return view('auth.landingpage');
        
    }
    public function login()
    {
        return view('auth.login');
    }
    public function getCookie(Request $request)
    {
        $value = $request->cookie('welcome_cookies');
    
        // Or using the Cookie facade
        // $value = Cookie::get('cookie_name');
    
        return response("Cookie value: $value");
    }
    protected function authenticated(){
        \Auth::logoutOtherDevices(request('password'));
    }
    public function login_post(Request $request)
    {

        // $a= $request->password;
        $request['password'] = decode5t($request->password); #SKP

        $request->validate(
            [
                'email' => ['required', 'string', 'email', 'max:50', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'password'          => 'required|min:8|max:15', //|alpha_num|min:6
                'captcha'           => 'required|captcha',

            ]
        );
        $data = user::where('email', $request->email)->first();
    //    if ($data){
    //        if ($data->is_loggedin == 1) {
    //            return redirect()->back()->with('warning', 'User is already logged in. Multiple logins are not allowed.');
    //        } else {
                
    //        }
    //    }
        //dd($data->is_loggedin);
        if ($data != null) {
            // if ($data->is_loggedin == 1) {
            //     return redirect()->back()->with('warning', 'User is already logged in. Multiple logins are not allowed.');
            // }else{ 
            if ($data->role == $request->role) {
                //dd($data->status);
                if ($data->status == 0) {
                    //dd($request->all());
                    if (Auth::attempt($request->only('email', 'password'))) {
                        $b = $this->getBrowser();
                        $data->is_loggedin = 1;
                        $data->user_agent = $b['name'];
                        $data->ip = $request->ip();
                        $data->save();
                        //$data->update(['is_loggedin' => 1]);
                        return redirect()->intended('/dashboard')->with('success', 'Login successfull!!');
                    } else {
                        return back()->with('fail', 'Email and/or password invalid.!!');
                    }
                } else {
                    // dd($request->all());
                    return back()->with('fail', 'Your account is not active Yet. please Contact Your website Adminstrator.');
                }
            } else {
                return back()->with('fail', 'Unauthorised User!!');
            }
        // }  //multiple login
    
    
    } else {
            return back()->with('fail', 'Record not exist!!');
        }
    }

    public function register()
    {
        $data = Country::orderBy('name')->get();
        return view('auth.register', compact('data'));
    }
    public function commonRegistration(Request $request)
    {
        //dd('Hello');
        $data = user::where('email', $request->email)->get();
        if (count($data) > 0) {
            $notification = array(
                'message' => 'Email is Already Exit!',
                'alert-type' => 'info'
            );
        } else {
            $request->validate([
                'organization' => 'required',
                'title' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'designation' => 'required',
                'gender' => 'required',
                'landline' => 'required',
                'email' => 'required',
                'email_otp' => 'required',
                'mobile_no' => 'required',
                'Country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'password' => 'required',
                'CaptchaCode' => 'required',
                'check' => 'required',
            ], [
                'organization.required' => 'BKS Organization',
                'title.required' => 'Title is required',
                'firstname.required' => 'First name is required',
                'lastname.required' => 'First name is required',
                'designation.required' => 'Designation  is required',
                'gender.required' => 'Gender is required',
                'landline.required' => 'Please enter landline number',
                'email.required' => 'Email is required',
                'email_otp.required' => 'Email OTP is required',
                'mobile_no.required' => 'Mobile number is required',
                'Country.required' => 'Couuntry is required',
                'state.required' => 'State is required',
                'city.required' => 'City is required',
                'address.required' => 'Address is required',
                'password.required' => 'Password is required',
                'CaptchaCode.required' => 'Captcha is required',
                'check.required' => 'Terms and condition is required',
            ]);
            if ($this->verifyOtp($request->email, $request->email_otp) == false) {
                return back()->with('fail', 'OTP is invalid.!!');
            }
            $result = user::insert([
                'title' =>  $request->title,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' =>   Hash::make($request->password),
                'organization' => $request->organization,
                'designation' => $request->designation,
                'gender' => $request->gender,
                'address' => $request->address,
                'mobile_no' => $request->mobile_no,
                'phonecode' => $request->phonecode,
                'country' => $request->Country,
                'state' => $request->state,
                'city' => $request->city,
                'postal' => $request->pincode,
                'phone_no' => $request->phone_no,
                'landline' => $request->landline,
                'last_login_ip' => $request->last_login_ip,
                'status' => $request->status,
                'role' => $request->role,
                'assessment' => $request->assessment,
                'about' => $request->about,
                'last_login_at' => $request->last_login_at,
            ]);
            // dd($result);
            //if(count($data)>0 && $data[0]->role == $request->role)
            if ($result == true) {
                // if($data[0]->status == 0)
                // {

                //      if(Auth::attempt($request->only('email','password')))
                //      {
                //         $userEmail = $request->email;
                //         //Mail sending scripts starts here
                //         $mailData = [
                //             'title' => 'You have successfully registered',
                //             'body' => 'Welcome to RAV Accredetation application. Please login with your username and password for further process.',
                //             'type' => 'New Registration'
                //         ];

                //         Mail::to($userEmail)->send(new SendMail($mailData));

                //          return redirect()->intended('/dashboard')->with('success', 'login successfull!!');
                //      }
                //      else
                //      {
                //      return back()->with ('fail','Email and/or password invalid.!!');
                //      }

                // }else

                // {
                $userEmail = $request->email;

                //Mail sending scripts starts here
                $mailData = [
                    'title' => 'You have successfully registered',
                    'body' => 'Welcome to RAV Accredetation application. Please login with your username and password for further process.',
                    'type' => 'New Registration'
                ];

                Mail::to($userEmail)->send(new SendMailRegis($mailData));
                //Mail sending script ends here

                return redirect()->intended('/')->with('success', 'Your registration is successfull. your account is not actived yet. please contact your adminstrator to active your account');
                // }
            } else {
                return back()->with('fail', 'Unauthorised User!!');
            }
        }
        //     $notification = array(
        //         'message' => 'Inserted Successfully',
        //         'alert-type' => 'success'
        //     );
        // }
        //     return redirect()->back()->with($notification);

    }
    public function  register_post(Request $request)
    {

        //dd($request->all());
        //        if ( captcha_check($request->captcha) == false ) {
        //            dd("here1");
        //        return back()->with('invalid-captcha','incorrect captcha!');
        //        }
        // else {
        //     dd("here");
        // }
        //return $request->all();
        $request->validate(
            [
                'organization' => ['required'],
                'title' => 'required',
                'firstname' => 'required|max:32|min:2',
                'lastname' => 'required|max:32|min:2',
                'email' => ['required', 'string', 'email', 'max:50', 'unique:users', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
                'email_otp' => 'required',
                'designation' => ['required'],
                'gender' => ['required'],
                'address' => 'required',
                'landline' => 'required',
                'mobile_no' => 'required|numeric|min:10|unique:users,mobile_no|numeric|digits:10',
                // 'phonecode'=> ['required'],
                'Country' => ['required'],
                'state' => 'required',
                // 'city' => 'required',
                //                'captcha' => 'required|captcha',
                'CaptchaCode'  => 'required|captcha',
                'check' => 'required',
                'password'  => 'required|min:8|max:15',
                'cpassword'  => 'required|same:password',

            ]
        );



        //dd($request->all());

        if ($this->verifyOtp($request->email, $request->email_otp) == false) {
            return back()->with('fail', 'OTP is invalid.!!');
        }

        $data = new user;
        $data->title = $request->title;
        $data->firstname = $request->firstname;
        $data->middlename = $request->middlename;
        $data->lastname = $request->lastname;
        $data->email = $request->email;
        $data->password =  Hash::make($request->password);
        $data->organization = $request->organization;
        $data->designation = $request->designation;
        $data->gender = $request->gender;
        $data->address = $request->address;
        $data->mobile_no = $request->mobile_no;
        $data->phonecode = $request->phonecode;
        $data->country = $request->Country;
        $data->state = $request->state;
        $data->city = $request->city;
        $data->postal = $request->pincode;
        $data->phone_no = $request->phone_no;
        $data->landline = $request->landline;
        $data->last_login_ip = $request->last_login_ip;
        $data->status = $request->status;
        $data->role = $request->role;
        $data->about = $request->about;
        $data->last_login_at = $request->last_login_at;
        $data->save();

        //    if(Auth::attempt($request->only('email','password'))){


        //        //Userdetails for mail

        //        $userEmail = $request->email;

        //         //Mail sending scripts starts here
        //         $registerMailData = [
        //         'title' => 'You have successfully registered',
        //         'body' => 'Welcome to RAV Accredetation application. Please login with your username and password for further process.'
        //         ];

        //         Mail::to($userEmail)->send(new SendMail($registerMailData));
        //        //Mail sending script ends here


        //    return redirect()->intended('/dashboard')->with('success','registration and login successfull!!');
        //    }
        //    else
        //    {
        //    return back()->with ('fail','something went be wrong!!');
        //    }


        $data = user::where('email', $request->email)->get();

        if (count($data) > 0 && $data[0]->role == $request->role) {
            if ($data[0]->status == 0) {

                if (Auth::attempt($request->only('email', 'password'))) {

                    $userEmail = $request->email;

                    //Mail sending scripts starts here
                    $mailData = [
                        'title' => 'You have successfully registered',
                        'body' => 'Welcome to RAV Accredetation application. Please login with your username and password for further process.',
                        'type' => 'New Registration'
                    ];

                    Mail::to($userEmail)->send(new SendMail($mailData));

                    return redirect()->intended('/dashboard')->with('success', 'login successfull!!');
                } else {
                    return back()->with('fail', 'Email and/or password invalid.!!');
                }
            } else {
                $userEmail = $request->email;

                //Mail sending scripts starts here
                $mailData = [
                    'title' => 'You have successfully registered',
                    'body' => 'Welcome to RAV Accredetation application. Please login with your username and password for further process.',
                    'type' => 'New Registration'
                ];

                Mail::to($userEmail)->send(new SendMail($mailData));
                //Mail sending script ends here

                return redirect()->intended('/')->with('falils', 'Your registration is successfull. your account is not actived yet. please contact your adminstrator to active your account');
            }
        } else {
            return back()->with('fail', 'Unauthorised User!!');
        }
    }

    public function logout()
    {
        $data = User::where('email',auth()->user()->email)->first();

        if ($data->is_loggedin == 1) {
            $data->update(['is_loggedin' => 0]);
        }

        auth()->logout();
        return redirect('/')->with(['success' => 'User successfully signed out']);
    }

    public function myCaptcha()
    {
        // dd('hello');
        return view('myCaptcha');
    }

    public function myCaptchaPost(Request $request)
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ]);
        dd("You are here :) .");
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img('math')]);
    }




    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;

            if (!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

        return redirect()->route('login')->with('message', $message);
    }


    public function sendEmailOtp(Request $request)
    {

        $request->validate(
            [
                'email' => ['required', 'string', 'email', 'max:50', 'unique:users', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            ]
        );
        //    $new_array = explode('@',$request->email);

        //    $userEmailDomain = emaildomeins::where('emaildomain',$new_array[1])->get();
        $response = array();
        // if(count($userEmailDomain) == 0)
        // {
        //     return response()->json([
        //         'status' => 129,
        //         'error'   => 1,
        //         'message' => 'Email domin is not valid.',
        //    ]);
        // }
        // dd($request->email);
        //if (isset($request->email) && trim($request->email) =="" ) {
        if ($request->email != "") {
            $customer = User::select('id')
                ->distinct()
                ->where('email', $request->email)
                ->limit(1)
                ->get()
                ->first();
            if (!empty($customer['id'])) {
                return response()->json([
                    'status' => 409,
                    'Message' => 'Email id is already exist.'
                ], 409);
            }
            $otp = rand(100000, 999999);

            Otp::where("phone_email", $request->email)->delete();
            Otp::create(["otp" => $otp, "phone_email" => $request->email]);

            Mail::queue(new VerificationEmail(['email' => $request->email, 'otp' => $otp]));
            return response()->json([
                'status' => 200,
                'Message' => 'Email Send in your Email ID!!!. '
            ]);
        } else {
            return response()->json([
                'error'   => 1,
                'message' => 'Email is not valid.',
            ]);
        }
    }



    public function sendOtp(Request $request)
    {



        $response = array();

        if (isset($request->phone) && trim($request->phone) == "") {
            return response()->json([
                'error'   => 1,
                'message' => 'Phone number is not valid.',
            ]);
        } else {


            $customer = User::select('users.id')
                ->distinct()
                ->where('mobile_no', $request->phone)
                ->limit(1)
                ->get()
                ->first();

            if (isset($customer['id'])) {
                return response()->json([
                    'error'   => 1,
                    'message' => 'Phone number is already exist.',

                ]);
            }

            $otp = rand(100000, 999999);

            Otp::where("phone_email", $request->phone)->delete();
            Otp::create(["otp" => $otp, "phone_email" => $request->phone]);

            Mail::queue(new VerificationMobile(['email' => $request->phone . '@yopmail.com', 'otp' => $otp]));
            return response()->json([
                'error'   => 0,
                'message' => 'Your OTP is created.'
            ]);


            /*$MSG91 = new MSG91();

        $msg91Response = $MSG91->sendSMS($otp,$users['phone']);

        if($msg91Response['error']){
            $response['error'] = 1;
            $response['message'] = $msg91Response['message'];
            $response['loggedIn'] = 1;
        }else{*/

            // $response['OTP'] = $otp;

            //}

        }

        // return response()->json($response);
        //echo json_encode($response);
    }

    public function verifyOtp($phone_email, $otp)
    {

        $response = array();

        //$userId = Auth::user()->id;  //Getting UserID.

        $expire_time = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -10 minutes"));
        //$OTP = $request->session()->get('OTP');
        $otpdata = Otp::select('otps.*')
            ->distinct()
            ->where('otp', $otp)
            ->where('phone_email', $phone_email)
            //->where('created_at', '>=', 'DATE_SUB(NOW(), INTERVAL 10 MINUTE)')
            ->where('created_at', '>=', $expire_time)
            ->orderby("id", "desc")
            ->limit(1)
            ->get()
            ->first();


        $OTP = null;
        if (isset($otpdata['otp'])) $OTP = $otpdata['otp'];

        if ($OTP == $otp) {




            Otp::where("otp", $otp)->delete();


            return response()->json([
                'error'   => 0,
                'is_verified'   => 1,
                'message' => 'Your Number is Verified.',
                //"data"=>$otpdata
            ]);

            return true;
        } else {
            return false;

            return response()->json([
                'error'   => 1,
                'is_verified'   => 0,
                'message' => 'OTP does not match.',
                //"data"=>$otpdata
            ]);
        }
    }



    public function state(Request $request)
    {


        $data = State::wherecountry_id($request->myData)->orderBy('name')->get();
        // dd($data);
        return response()->json($data);
    }

    public function city(Request $request)
    {
        $data = City::wherestate_id($request->myData)->orderBy('name')->get();
        return response()->json($data);
    }

    public function list_show()
    {
        $State = State::first();
        $City = City::first();
        return response()->json(['City' => $City, 'State' => $State]);
    }


    function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
    
        // First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
    
        // Next get the name of the useragent yes separately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/OPR|Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/Edge/i', $u_agent)) {
            $bname = 'Edge';
            $ub = "Edge";
        } elseif (preg_match('/Trident/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
    
        // Finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // See how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            // We will have two since we are not using 'other' argument yet
            // See if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                if(count($matches['version'])>0){
                    $version = $matches['version'][1];
                  }
            }
        } else {
            $version = $matches['version'][0];
        }
    
        // Check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }
    
        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'   => $pattern
        );
    }
    
}
