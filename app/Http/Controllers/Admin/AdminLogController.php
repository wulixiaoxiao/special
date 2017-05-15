<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLogController extends Controller
{
    /**
     * 管理日志列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $adminLogs = AdminLog::where(function($query) use ($request) {
            if (!empty($request->input('search'))) {
                $query->where('description', 'like', '%'.$request->input('search').'%');
            }
        })->orderBy('id', 'desc')->paginate(10);

        return view('admin.admin_log.index', [
            'adminLogs' => $adminLogs,
            'search' => $request->input('search'),
        ]);
    }

    /**
     * 管理日志详情
     *
     * @param Request $request
     * @param AdminLog $adminLog
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, AdminLog $adminLog) {
        return view('admin.admin_log.edit', [
            'adminLog' => $adminLog,
        ]);
    }
}
