<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ResponseJson;
use App\Models\AdminLog;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    /**
     * 系统配置列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request) {
        $deleteData = Config::getInstance()->getDeleteConfigData();
        foreach ($deleteData as $key => $value) {
            Config::whereConfigName($key)->delete();
        }
        $labelData = Config::getInstance()->getConfigData();

        foreach ($labelData as $key => $value) {
            if (!Config::whereConfigName($key)->exists()) {
                Config::create([
                    'config_name' => $key,
                ]);
            }
        }

        if ($request->isMethod('post')) {
            foreach ($labelData as $key => $value) {
                Config::whereConfigName($key)->update([
                    'config_value' => $request->input($key),
                ]);
            }
            AdminLog::getInstance()->addLog('更新系统配置');
            return ResponseJson::getInstance()->doneJson('编辑成功');
        }

        $configData = Config::all();
        return view('admin.config.index', [
            'configs' => $configData,
            'configLabels' => $labelData,
        ]);
    }
}
