<?php
/**
 * Created by PhpStorm.
 * User: zhouchenxi
 * Date: 2017/2/14
 * Time: 13:31
 */

namespace App\Services;


class Helper
{
    /**
     * 创建返回数据
     *
     * @param  int  $code
     * @param  string   $msg
     * @param  array   $data
     * @return array $responseData
     */
    public static function createResponseData($code, $msg, $data=[])
    {
        $responseData = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        ];
        if(empty($data)){
            unset($responseData['data']);
        }
        if(!config('app.with_msg')){
           unset($responseData['msg']);
        }
        return $responseData;
    }
}