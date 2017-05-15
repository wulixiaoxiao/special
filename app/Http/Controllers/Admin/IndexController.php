<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ResponseJson;
use App\Models\Admin;
use App\Models\AfterSale;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;

class IndexController extends Controller
{
    /**
     * 后台首页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $totalOrderNumber = Order::count();
        $deliverOrderNumber = Order::whereStatus(2)->count();
        $backGoodsNumber = AfterSale::whereType(1)->whereIn('status', [1, 2, 4])->count();
        $repairGoodsNumber = AfterSale::whereType(2)->whereIn('status', [1, 2, 4])->count();
        return view('admin.index.index', [
            'totalOrderNumber' => $totalOrderNumber,
            'deliverOrderNumber' => $deliverOrderNumber,
            'backGoodsNumber' => $backGoodsNumber,
            'repairGoodsNumber' => $repairGoodsNumber,
        ]);
    }

    /**
     * 管理员登录
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function login(Request $request) {
        if ($request->isMethod('post')) {
            $userName = trim($request->input('admin_name'));
            $password = $request->input('password');
            $code = $request->input('code');

            if (empty($userName)) {
                return ResponseJson::getInstance()->errorJson('管理员名称不能为空');
            }
            if (empty($password)) {
                return ResponseJson::getInstance()->errorJson('管理员密码不能为空');
            }
            if ($code != \Session::get('code')) {
                return ResponseJson::getInstance()->errorJson('验证码不正确');
            }
            $admin = Admin::whereAdminName($userName)->first();
            if (!$admin) {
                return ResponseJson::getInstance()->errorJson('管理员账号不存在');
            }
            if ($admin->password != md5($password)) {
                return ResponseJson::getInstance()->errorJson('管理员密码不正确');
            }
            \Auth::guard('admin')->login($admin);
            \Session::put('last_login_time', $admin->last_time);
            Admin::whereId($admin->id)->update([
                'last_time' => time(),
            ]);
            \Session::forget('code');
            return ResponseJson::getInstance()->doneJson('登录成功');
        }
        return view('admin.index.login');
    }

    /**
     * 退出登录
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logout(Request $request) {
        \Auth::guard('admin')->logout();
        return view('admin.index.login');
    }

    /**
     * 获取登录验证码
     *
     * @param Request $request
     * @return mixed
     */
    public function getVerifyCode(Request $request) {
        $captcha = new CaptchaBuilder();
        $captcha->build(150, 34);
        \Session::put('code', $captcha->getPhrase()); //存储验证码
        return response($captcha->output())->header('Content-type', 'image/jpeg');
    }
}
