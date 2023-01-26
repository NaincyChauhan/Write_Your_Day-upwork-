<?php

namespace App\Traits\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait LoginUser
{

    /**
     * Handle a Authenticates the User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            return $this->successfulLogin($request);
        }
        return $this->failedLogin($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
    }
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {   
        //Try with email AND username fields
        if (Auth::attempt([
            'phone' => $request['username'],
            'password' => $request['password']
            ],$request->has('remember'))
            || Auth::attempt([
            'email' => $request['username'],
            'password' => $request['password']
            ],$request->has('remember'))){
                return true;
        }
        return false;
    }

    /**
     * This is executed when the user successfully logs in
     * 
     * @var Request $request
     * @return Reponse
     */
    protected function successfulLogin(Request $request){
        return redirect($this->redirectTo);
    }

    /**
     * This is executed when the user fails to log in
     * 
     * @var Request $request
     * @return Reponse
     */
    protected function failedLogin(Request $request){
        return redirect()->back()->withErrors(['password' => 'You entered the wrong username or password']);
    }

}