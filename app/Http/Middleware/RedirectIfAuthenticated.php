<?php

namespace App\Http\Middleware;

use App\Services\Helper;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
           // return redirect('/home');
            return response()->json(Helper::createResponseData('30003','你已经登录！'));
        }

        return $next($request);
    }
}
