<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $userInfo;

    public function __construct(Request $request)
    {
        $this->userInfo = User::whereApiToken($request->input('token'));
    }

    public function formatJson($code = 0, $msg = '', $data = []){
        $r = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
        \Response::json();
        return response()->json($r);
    }

    public function errorJson($msg = '', $data = []){
        $r = [
            'code' => 0,
            'msg' => $msg,
            'data' => $data,
        ];
        \Response::json();
        return response()->json($r);
    }

    public function successJson($msg = '', $data = []){
        $r = [
            'code' => 1,
            'msg' => $msg,
            'data' => $data,
        ];
        \Response::json();
        return response()->json($r);
    }

}
