<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use Session, Auth,Hash,Mail;
use App\Mail\UserMail;

class UserController extends Controller
{

    public  function loginuser(Request $request){
        $request->validate([
            'password' => 'required',
            'email' => 'required',
        ]);

        if(is_numeric($request->email)){
            $field = 'phone';
        }
        elseif (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        }else{
            $field = 'username';
        }

        $user = User::where($field, $request->email)->first();
        if (isset($user)) {
            if(Hash::check($request->password, $user->password))
            {                
                Auth::loginUsingId($user->id,$request->remember);
                return response()->json(['status' => 1, 'message' => 'True'], 200); 
            }
        }

        return response()->json(['status' => 0, 'message' => "Credentials Does't not match"], 200);
    }

    // Create User Registertion
    public function registeruser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'confirmed',Password::min(8)
            ->letters()->numbers()->symbols()],
            'username' => ['required','unique:users','max:20'],
            'phone' => ['required','min:10','max:10'],
            'dob' => 'required',
            'privacypolicy' => 'required',
        ]);
        
        if(Session::has('user_register_otp') && isset($request->otp))
        {
            if(Session::get('user_register_otp') == $request->otp)
            {
                if(Session::has('user_register_email') && isset($request->email))
                {
                    if (Session::get('user_register_email') == $request->email) {
                        $user = new User();
                        $user->name = $request->name;
                        $user->username = $request->username;
                        $user->phone = $request->phone;
                        $user->email = $request->email;
                        $user->dob = $request->dob;
                        $user->password =Hash::make($request->password);
                        $user->save();
        
                        $role = Role::where('slug', 'user')->first();
                        $user->roles()->attach($role);
                        $user->permissions()->attach($role->permissions);
        
                        Auth::loginUsingId($user->id);
                        return response()->json(['status' => 1, 'message' => 'User registered successfully.', 'type' => 1]);
                    }else
                    {
                        return response()->json(['status' => 0, 'message' => 'Do not try to scam , Email-Id must be same where OTP is sened..', 'type' => 1]);
                    }
                }
            }
            else
            {
                return response()->json(['status' => 0, 'message' => 'Invalid OTP.', 'type' => 1]);
            }
        }


        $otp = rand(100000, 999999);
        $mailData = [ 'name' => $request->name,'otp' => $otp,'template' => 'mail.otp','subject' => 'One Time Password'];
        try {
            Mail::to($request->email)->send(new UserMail($mailData));
        } catch (error) {
            return response()->json(['status' => 0, 'message' => $error, 'type' => 1]);
        }
        Session::put('user_register_otp', $otp);
        Session::put('user_register_email', $request->email);
        return response()->json(['status' => 1, 'message' => 'OTP has been sent In your email('.substr($request->email, 0, 10).'****). if  you missed  please check your spam folder.', 'type' => 0]);        
    }

    public function changePassword(Request $request){
        return view('site.user.change-password',[
            'active' => $request->active,
        ]);
    }

    public function editProfile(Request $request){
        return view('site.user.update-profile',[
            'user' => User::where('id',Auth::user()->id)->select('name','email','address','image','mobile')->first(),
            'active' => $request->active,
        ]);
    }

    public function updateProfile(Request $request){
        $user = User::where('id',Auth::user()->id)->first();
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'mobile' => 'required',
            'address' => 'required',
        ]);

        //Uploading Image
        if($request->hasFIle('image'))
        {
            $file_name = '';
            $file = $request->file('image');
            $file_name = 'user_'.rand(00000, 99999).'.'. $file-> getClientOriginalExtension();
            if($file->move(public_path("storage/users"), $file_name)){   
                if(is_file(public_path('storage/users/'.$user->image))){
                    unlink(public_path('storage/users/'.$user->image));
                }             
            }
            $user->image = $file_name;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->save();

        return response()->json([
            'status' => 1, 
            'message' => "Success.! Profile has been updated successfully.",  
            'img' => $user->image != null ? '<img src="'.asset('storage/users/'.$user->image) .'" class="img-thumbnail rounded-circle user-profile-image"  alt="User Profile">' : '',  
            'profileimage' => $user->image != null ? '<img class="rounded-circle" src="'.asset('storage/users/'.$user->image).'" alt="user" width="50px">' : '',        
        ], 200);
    }

    public function forgetPasswordView(){
        if (Auth::check() && Auth::user()) {
            return redirect()->route('home');
        }
        return view('auth.forgotpass');
    }


    public function forgetPassword(Request $request)
    {
        $request->validate(['email' => 'required']);        
        if(!User::where('email', $request->email)->exists())
        {
            return response()->json([
                'status' => 0, 
                'message' => 'We could not find your account with '.$request->email.'. ',  
            ], 200);
        }
        $user = User::where('email',$request->email)->first(); 

        if (isset($request->type) && $request->type=='otp') {
            $otp = rand(100000, 99999999);    
            $mailData = [ 'name' =>  $user->name,'otp' => $otp,'template' => 'mail.email','subject' => 'Password Reset OTP'];
            Mail::to($request->email)->send(new UserMail($mailData));
            Session::put('user_forget_password_otp', $otp);
            return response()->json([
                'status' => 1, 
                'message' => 'A OTP has been sent to your registered '.substr($user->email, 0, 10). "***** email. if you missed please check your spam folder.OTP Valid only for 10 mintues",  
            ], 200);
        }elseif(!Session::has('user_forget_password_otp')){
            return response()->json([
                'status' => 0, 
                'message' => 'You did not send request for Email OTP, for change password send otp request!',  
            ], 200);
        }else{
            if(Session::has('user_forget_password_otp') && isset($request->otp))
            {
                if(Session::get('user_forget_password_otp') == $request->otp)
                {
                    $request->validate([
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                    ]);
                                       
                    $user->password =Hash::make($request->password);
                    $user->save();
                    Session::forget('user_forget_password_otp');
                    Auth::loginUsingId($user->id);
                    return response()->json(['status' => 1, 'message' => 'User Password Reset Successfully.', 'type' => 1]);
                }
                else
                {
                    return response()->json(['status' => 0, 'message' => 'Invalid OTP.', 'type' => 0]);
                }
            }
        }
    }
}
