<?php

namespace App\Http\Middleware;

use Closure;


// user added included
use Auth;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check())
        {
            return view('user.login');
        }
        return $next($request);
    }
}
