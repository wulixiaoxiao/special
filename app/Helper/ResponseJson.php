<?php
/**
 * Created by PhpStorm.
 * User: runong
 * Date: 2017/1/18
 * Time: 上午10:12
 */

namespace App\Helper;


class ResponseJson
{
    use BaseHelper;
    /**
     * 接口成功返回
     *
     * @param $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function doneJson($message = '', $data = '') {
        return \Response::json([
            'error' => 0,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * 接口失败返回
     *
     * @param $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorJson($message = '', $data = '') {
        return \Response::json([
            'error' => 1,
            'message' => $message,
            'data' => $data,
        ]);
    }
}