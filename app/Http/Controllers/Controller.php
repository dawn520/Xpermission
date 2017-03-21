<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 错误返回
     *
     * @param $message
     * @param int $status_code
     * @param array $data
     * @return array
     */
    public function error($message, $status_code = -1, $data = [])
    {
        $returnJson = ['message' => $message, 'data' => $data, 'code' => $status_code];
        if (empty($data))
            unset($returnJson['data']);
        if (!config('app.with_msg')) {
            unset($returnJson['msg']);
        }
        return response()->json($returnJson);
    }

    /**
     * 成功返回
     *
     * @param $message
     * @param array $data
     * @param int $status_code
     * @return array
     */
    public function success($message, $data = [], $status_code = 200)
    {
        $returnJson = ['message' => $message, 'data' => $data, 'code' => $status_code];
        if (empty($data))
            unset($returnJson['data']);
        if (!config('app.with_msg')) {
            unset($returnJson['msg']);
        }
        return response()->json($returnJson);
    }
}
