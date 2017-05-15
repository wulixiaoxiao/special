<?php

namespace App\Http\Middleware;

use App\Helper\ResponseJson;
use Closure;

class CheckApiToken
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

//        $tmp = trim($request->input('tmp', ''));
//        $sign = trim($request->input('sign', ''));
//        $key = env('API_KEY');
//
//        if($sign !== encrypt($tmp.$key)){
//            return ResponseJson::getInstance()->errorJson('参数错误');
//        }
        return $next($request);
    }
}
