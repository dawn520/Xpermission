<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Services\Helper;
use App\Models\User;

class AddUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|alpha_dash|min:4|max:16',
            'name'     => 'required|min:2|max:16',
            'email'    => 'required|email',
            'password' => 'required|min:8|max:20|confirmed',
            'password_confirmation' => 'required|min:8|max:20'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'username' => '用户名',
            'name'     => '昵称',
            'email'    => 'email',
            'password' => '密码',
            'password_confirmation'=>'确认的密码'
        ];
    }

    /**
     * 重写响应
     *
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        return response()->json(Helper::createResponseData('31101',$errors));
    }

    /**
     * Return the fields and values to create a new post from.
     */
    public function userFillData()
    {
        return [
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password)
        ];
    }
}
