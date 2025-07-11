<?php

namespace App\Http\Middleware;

use Closure,Auth;
use Illuminate\Http\Request;

class CheckNotSuspendUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if($user->suspend_mode == 0)
        {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
