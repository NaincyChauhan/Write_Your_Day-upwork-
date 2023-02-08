<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Hash,Auth;

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
                // return redirect()->back()->with('error', 'Your Accounts has been Deactive,Please Contact Support Center.');
                return response()->json([
                    'status' => 0,
                    'message' => 'Your Accounts has been Deactive,Please Contact Support Center.',
                ], 200);
            }
            if($this->username()=="phone" && $user->phone_verified==0){
                // return redirect()->back()->with('error', 'Your Phone Number is not Verified.Please Try with Username and Email Id!');
                return response()->json([
                    'status' => 0,
                    'message' => 'Your Phone Number is not Verified. Please Try with Username and Email Id!',
                ], 200);
            }
            if (!$user->trashed()) {
                if (Auth::attempt([$this->username() => $request->email, 'password' => $request->password])) {
                    // return redirect()->intended('dashboard');
                    return response()->json([
                        'status' => 1,
                        'message' => 'Authentication Successfully.',
                    ], 200);
                } else {    
                    // return redirect()->back()->with('error', 'Invalid login credentials.');
                    return response()->json([
                        'status' => 0,
                        'message' => 'Invalid login credentials.',
                    ], 200);
                }
            } else {
                if(Hash::check($request->password, $user->password)){
                    // $loginAttempts = $user->login_attempts + 1;
                    // // return response()->json([
                    // //     'status' => 0,
                    // //     'message' => 'this is debugging 111'.$loginAttempts." and ". $user->login_attempts,
                    // // ], 200);
                    // if ($loginAttempts >= 2) {
                    //     // $user->delete();
                    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    //         $user->login_attempts = 0;
                    //         $user->save();
                    //         return redirect()->intended('dashboard');
                    //     }
                    // } else {
                    //     $user->login_attempts = $loginAttempts;
                    //     $user->save();
                    //     return response()->json([
                    //         'status' => 0,
                    //         'message' => 'Your account has been soft-deleted. If you will try again to login Your Account will Recover! '.$user->login_attempts.'second is ehrer '.$loginAttempts,
                    //     ], 200);
                    // }    
                    return response()->json([
                        'status' => 0,
                        'message' => 'Your account has been Deleted.',
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
