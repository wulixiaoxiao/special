<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Models\Ad;
use App\Models\AdminLog;
use App\Models\AdPosition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\ResponseJson;
use App\Helper\CommonHelper;

class AdController extends Controller
{
    /**
     * 广告列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $search = $request->input('search');
        $ad_position_id = intval($request->input('ad_position_id'));
        $query = Ad::orderBy('id', 'desc');
        if (!empty($search)) {
            $query->where('ad_name', 'like', '%'.$search.'%');
        }
        if ($ad_position_id > 0) {
            $query->whereAdPositionId($ad_position_id);
        }
        $adList = $query->paginate(10);
        return view('admin.ad.index', [
            'adList' => $adList,
            'search' => $search,
        ]);
    }

    /**
     * 广告添加
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $adName = $request->input('ad_name');
            $adPositionId = intval($request->input('ad_position_id'));
            $title = $request->input('title');
            $file = $request->file('pic');
            $link = $request->input('link');
            $isShow = intval($request->input('is_show'));
            $sortOrder = intval($request->input('sort_order'));
            $pic = '';

            if (empty($adName)) {
                return ResponseJson::getInstance()->errorJson('名称不能为空');
            }
            if (Ad::whereAdName($adName)->count()) {
                return ResponseJson::getInstance()->errorJson('名称已存在');
            }
            if (!AdPosition::whereId($adPositionId)->count()) {
                return ResponseJson::getInstance()->errorJson('请选择广告位置');
            }
            if ($file) {
                if (!$file->isValid()) {
                    return ResponseJson::getInstance()->errorJson('图片不正确');
                }
                $extension = $file->getClientOriginalExtension();
//                $oldName = str_replace('.' . $extension, '', $file->getClientOriginalName());
                $oldName = rand(10000,99999);
                $fileName = $oldName . time() . '.' . $extension;
                $file->move('upload/ad/', $fileName);
                $pic = 'upload/ad/'.$fileName;
            }
            \DB::beginTransaction();
            try {
                Ad::create([
                    'ad_name' => $adName,
                    'ad_position_id' => $adPositionId,
                    'title' => $title,
                    'pic' => $pic,
                    'link' => $link,
                    'is_show' => $isShow ? 1 : 0,
                    'sort_order' => $sortOrder,
                ]);
                AdminLog::getInstance()->addLog("广告添加:{$adName}");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('添加成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.ad.add', [
            'adPositionList' => AdPosition::all()
        ]);
    }

    public function edit(Request $request, Ad $ad) {
        if ($request->isMethod('post')) {
            $adName = $request->input('ad_name');
            $adPositionId = intval($request->input('ad_position_id'));
            $title = $request->input('title');
            $file = $request->file('pic');
            $link = $request->input('link');
            $isShow = intval($request->input('is_show'));
            $sortOrder = intval($request->input('sort_order'));

            if (empty($adName)) {
                return ResponseJson::getInstance()->errorJson('名称不能为空');
            }
            if (Ad::where('id', '!=', $ad->id)->whereAdName($adName)->count()) {
                return ResponseJson::getInstance()->errorJson('名称已存在');
            }
            if (!AdPosition::whereId($adPositionId)->count()) {
                return ResponseJson::getInstance()->errorJson('请选择广告位置');
            }
            if ($file) {
                if (!$file->isValid()) {
                    return ResponseJson::getInstance()->errorJson('图片不正确');
                }
                $extension = $file->getClientOriginalExtension();
//                $oldName = str_replace('.' . $extension, '', $file->getClientOriginalName());
                $oldName = rand(10000,99999);
                $fileName = $oldName . time() . '.' . $extension;
                $file->move('upload/ad/', $fileName);
                // 删除旧图片
                if (!empty($ad->pic)) { @unlink(public_path($ad->pic)); }
                $ad->pic = 'upload/ad/'.$fileName;
            }
            $ad->ad_name = $adName;
            $ad->ad_position_id = $adPositionId;
            $ad->title = $title;
            $ad->link = $link;
            $ad->is_show = $isShow ? 1 : 0;
            $ad->sort_order = $sortOrder;
            \DB::beginTransaction();
            try {
                $ad->save();
                AdminLog::getInstance()->addLog("广告编辑:{$ad->ad_name}");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('编辑成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        $ad->pic = CommonHelper::getInstance()->formatImageToShow($ad->pic);

        return view('admin.ad.edit', [
            'adPositionList' => AdPosition::all(),
            'ad' => $ad,
        ]);
    }

    public function delete(Request $request) {
        $ids = $request->input('id');
        if (empty($ids)) {
            return ResponseJson::getInstance()->errorJson('请选择要删除的记录');
        }
        $ids = array_filter(explode(',', $ids));
        $ads = Ad::whereIn('id', $ids)->get();
        $adNames = Ad::whereIn('id', $ids)->pluck('ad_name');
        $adNames = implode(',', $adNames);
        \DB::beginTransaction();
        try {
            foreach ($ads as $key => $value) {
                if (!empty($value->pic)) { @unlink(public_path($value->pic)); }
                $value->delete();
            }
            AdminLog::getInstance()->addLog("广告删除:{$adNames}");
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('删除成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }
}
