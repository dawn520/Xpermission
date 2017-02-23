<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use App\Services\Helper;
use App\Models\User;

class AddRoleRequest extends Request
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
            'name'        => 'required|min:4|max:16',
            'displayName' => 'required|min:2|max:16',
            'discription' => 'max:40',
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
            'name'        => '角色名',
            'displayName' => '角色显示名称',
            'description' => '描述'
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
        return response()->json(Helper::createResponseData('31203',$errors));
    }
}
