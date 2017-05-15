<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Helper\ResponseJson;
use App\Models\Admin;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * 管理员列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $admins = Admin::paginate(10);
        return view('admin.admin.index', [
            'admins' => $admins,
        ]);
    }

    /**
     * 管理员添加
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $adminName = trim($request->input('admin_name'));
            $password = $request->input('password');
            $adminNickname = trim($request->input('admin_nickname'));
            $permissions = !empty($request->input('permissions')) ? implode(',', $request->input('permissions')) : '';

            if (empty($adminName)) {
                return ResponseJson::getInstance()->errorJson('管理员账号不能为空');
            }
            if (Admin::whereAdminName($adminName)->exists()) {
                return ResponseJson::getInstance()->errorJson('账号已存在');
            }
            if (empty($password)) {
                return ResponseJson::getInstance()->errorJson('管理员密码不能为空');
            }
            if (empty($adminNickname)) {
                return ResponseJson::getInstance()->errorJson('管理员昵称不能为空');
            }

            Admin::create([
                'admin_name' => $adminName,
                'admin_nickname' => $adminNickname,
                'password' => md5($password),
                'permissions' => $permissions,
                'create_time' => time(),
                'last_time' => 0,
            ]);
            AdminLog::getInstance()->addLog("添加新的管理员:{$adminName}({$adminNickname})");
            return ResponseJson::getInstance()->doneJson('添加成功');
        }
        return view('admin.admin.add');
    }

    /**
     * 管理员编辑
     *
     * @param Request $request
     * @param Admin $admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request, Admin $admin) {
        if ($request->isMethod('post')) {
            $adminName = trim($request->input('admin_name'));
            $password = $request->input('password');
            $adminNickname = trim($request->input('admin_nickname'));
            $permissions = !empty($request->input('permissions')) ? implode(',', $request->input('permissions')) : '';

            if (empty($adminName)) {
                return ResponseJson::getInstance()->errorJson('管理员账号不能为空');
            }
            if (Admin::whereAdminName($adminName)->where('id', '!=', $admin->id)->exists()) {
                return ResponseJson::getInstance()->errorJson('账号已存在');
            }
            if (!empty($password)) {
                $admin->password = md5($password);
            }
            if (empty($adminNickname)) {
                return ResponseJson::getInstance()->errorJson('管理员昵称不能为空');
            }

            $admin->admin_name = $adminName;
            $admin->admin_nickname = $adminNickname;
            $admin->permissions = $permissions;
            $admin->save();
            AdminLog::getInstance()->addLog("编辑管理员:{$adminName}({$adminNickname})");
            return ResponseJson::getInstance()->doneJson('编辑成功');
        }
        return view('admin.admin.edit', [
            'admin' => $admin,
        ]);
    }

    /**
     * 管理员删除
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request) {
        $ids = trim($request->input('id'));
        if (empty($ids)) {
            return ResponseJson::getInstance()->errorJson('请选择要删除的记录');
        }
        $ids = array_filter(explode(',', $ids));
        $adminNames = Admin::whereIn('id', $ids)->pluck('admin_name')->toArray();
        Admin::whereIn('id', $ids)->delete();
        if (!empty($adminNames)) {
            AdminLog::getInstance()->addLog("删除管理员:".implode(',', $adminNames));
        }
        return ResponseJson::getInstance()->doneJson('删除成功');
    }
}
