<?php

namespace App\Http\Middleware;

use App\Library\ResponseJson;
use Closure;

class AdminLogin
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
        if (\Auth::guard('admin')->guest()) {
            if ($request->ajax()) {
                return ResponseJson::getInstance()->doneJson('请登录');
            }
            return redirect()->to('admin/login');
        }
        return $next($request);
    }
}
