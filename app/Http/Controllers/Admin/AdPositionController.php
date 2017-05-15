<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Models\Ad;
use App\Models\AdminLog;
use App\Models\AdPosition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\ResponseJson;
use Illuminate\Support\Facades\DB;

class AdPositionController extends Controller
{
    /**
     * 广告位置列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $search = $request->input('search');
        $query = AdPosition::orderBy('id', 'desc');
        if (!empty($search)) {
            $query->where('position_name', 'like', '%'.$search.'%');
        }
        $adPositionList = $query->paginate(10);
        return view('admin.ad_position.index', [
            'adPositionList' => $adPositionList,
            'search' => $search,
        ]);
    }

    /**
     * 广告位置添加
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $positionName = $request->input('position_name');
            $description = $request->input('description');
            if (empty($positionName)) {
                return ResponseJson::getInstance()->errorJson('名称不能为空');
            }
            if (AdPosition::wherePositionName($positionName)->count()) {
                return ResponseJson::getInstance()->errorJson('名称已存在');
            }
            \DB::beginTransaction();
            try {
                AdPosition::create([
                    'position_name' => $positionName,
                    'description' => $description
                ]);
                AdminLog::getInstance()->addLog("广告位置添加:{$positionName}");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('添加成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.ad_position.add');
    }

    /**
     * 广告位置编辑
     *
     * @param Request $request
     * @param AdPosition $adPosition
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request, AdPosition $adPosition) {
        if ($request->isMethod('post')) {
            $positionName = $request->input('position_name');
            $description = $request->input('description');
            if (empty($positionName)) {
                return ResponseJson::getInstance()->errorJson('名称不能为空');
            }
            if (AdPosition::where('id', '!=', $adPosition->id)->wherePositionName($positionName)->count()) {
                return ResponseJson::getInstance()->errorJson('名称已存在');
            }
            \DB::beginTransaction();
            try {
                $adPosition->position_name = $positionName;
                $adPosition->description = $description;
                $adPosition->save();
                AdminLog::getInstance()->addLog("广告位置编辑:{$positionName}");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('编辑成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.ad_position.edit', [
            'adPosition' => $adPosition,
        ]);
    }

    /**
     * 广告位置删除
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request) {
        $ids = $request->input('id');
        if (empty($ids)) {
            return ResponseJson::getInstance()->errorJson('请选择要删除的记录');
        }
        $ids = array_filter(explode(',', $ids));
        \DB::beginTransaction();
        try {
            $adPositionNames = AdPosition::whereIn('id', $ids)->pluck('position_name');
            $adPositionNames = implode(',', $adPositionNames);
            $ads = Ad::whereIn('ad_position_id', $ids)->get();
            foreach ($ads as $key => $value) {
                if (isset($value->pic) && $value->pic) {
                    @unlink(public_path($value->pic));
                }
                $value->delete();
            }
            AdPosition::whereIn('id', $ids)->delete();
            AdminLog::getInstance()->addLog("广告位置删除:{$adPositionNames}");
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('删除成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }
}
