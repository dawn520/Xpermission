<?php
/**
 * Created by PhpStorm.
 * User: zhouchenxi
 * Date: 2017/2/17
 * Time: 17:22
 */

namespace app\Http\Middleware;

use Closure;
use Validator;
use App\Services\Helper;

class VerifyUser
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
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha_dash|min:4|max:10',
            'name'     => 'required|min:2|max:16',
            'email'    => 'required|email',
            'password' => 'required|min:8|max:20|confirmed',
            'password_confirmation' => 'required|min:8|max:20'
        ]);
        $friendly_names = [
            'username' => '用户名',
            'name'     => '昵称',
            'email'    => 'email',
            'password' => '密码',
            'password_confirmation'=>'确认的密码'
        ];
        $validator->setAttributeNames($friendly_names);
        if ($validator->fails()) {
            return response()->json(Helper::createResponseData('31101',$validator->errors()));
        }
        return $next($request);
    }
}