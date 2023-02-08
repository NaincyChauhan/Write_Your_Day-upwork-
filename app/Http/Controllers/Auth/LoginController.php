<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Hash,Auth,Session,Mail;
use App\Mail\UserMail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::USER_HOME;
    protected $username = ['email', 'username', 'phone'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $identity  = request()->get('email');
        if(is_numeric(request()->get('email'))){
            $field = 'phone';
        }
        elseif (filter_var(request()->get('email'), FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        }else{
            $field = 'username';
        }
        request()->merge([$field => $identity]);
        return $field;
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function login(Request $request)
    {
        $user = User::withTrashed()->where($this->username(), $request->email)->first();
        if($user){
            if($user->status==0){
                return response()->json([
                    'status' => 0,
                    'message' => 'Your Accounts has been Deactive,Please Contact Support Center.',
                ], 200);
            }
            if($this->username()=="phone" && $user->phone_verified==0){
                return response()->json([
                    'status' => 0,
                    'message' => 'Your Phone Number is not Verified. Please Try with Username and Email Id!',
                ], 200);
            }
            if (!$user->trashed()) {
                if (Auth::attempt([$this->username() => $request->email, 'password' => $request->password])) {
                    return response()->json([
                        'status' => 1,
                        'message' => 'Authentication Successfully.',
                    ], 200);
                } else {                        
                    return response()->json([
                        'status' => 0,
                        'message' => 'Invalid login credentials.',
                    ], 200);
                }
            } else {
                if(Hash::check($request->password, $user->password)){                      
                    if(isset($request->otp) && Session::has('login_otp')){                        
                        if($request->otp == Session::get('login_otp')){                            
                            $user->deleted_at = null;
                            $user->save();
                            Session::forget('login_top');
                            Auth::loginUsingId($user->id,$request->remember);
                            return response()->json([
                                'status' => 1,
                                'message' => 'Authentication Successfully.',
                                'type' => 2,
                            ], 200);                            
                        }else{
                            return response()->json([
                                'status' => 0,
                                'message' => 'Invalid OTP.',
                            ], 200);
                        }
                    }
                    if(isset($request->type) && $request->type==1){
                        $otp = rand(100000, 999999);
                        $mailData = [ 'name' => $user->name,'otp' => $otp,'template' => 'mail.otp','subject' => 'Login OTP(One Time Password)'];
                        Mail::to($user->email)->send(new UserMail($mailData));
                        Session::put('login_otp', $otp);
                        return response()->json([
                            'status' => 1, 
                            'message' => 'Login OTP has been sent In your email('.substr($user->email, 0, 10).'****). if  you missed  please check your spam folder.', 
                            'type' => 1
                        ]); 
                    }
                    return response()->json([
                        'status' => 0,
                        'message' => 'Your account has been Deleted.If you want to login anywhere click proceed button.',
                        'type' => 0,
                    ], 200);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => 'Invalid login credentials.',
                    ], 200);
                }
            }
        }else{
            // return redirect()->back()->with('error', 'Invalid login credentials.');
            return response()->json([
                'status' => 0,
                'message' => 'Invalid login credentials.',
            ], 200);
        }
    }
}
