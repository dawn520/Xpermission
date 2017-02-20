<?php
/**
 * Created by PhpStorm.
 * User: zhouchenxi
 * Date: 2017/2/17
 * Time: 17:02
 */


namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function addUser(Request $request)
    {
        var_dump($request->input());
    }
}