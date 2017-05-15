<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CheckLogin
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
        $api_token = $request->input('token', '');
        $user = User::whereApiToken($api_token)->first();
        if(!isset($user) || empty($user)){
            return response()->json(['code'=>0, 'msg'=>'未登录']);
        }

        $request->setUserResolver((function () use ($user) {
            return $user;
        }));
        return $next($request);
    }
}
