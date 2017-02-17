<?php
/**
 * Created by PhpStorm.
 * User: zhouchenxi
 * Date: 2017/2/17
 * Time: 17:22
 */

namespace app\Http\Middleware;

use Closure;

class VerifyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha_dash|min:4|max:16',
            'name'     => 'required|min:2|max:10',
            'email'    => 'required|email',
            'password' => 'required|min:8|max:20|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json(Helper::createResponseData('21001','登录成功'));
        }
        return $next($request);
    }
}