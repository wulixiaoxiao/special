<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Helper\CommonHelper;
use App\Helper\ResponseJson;
use App\Models\AdminLog;
use App\Models\GoodsBrand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsBrandController extends Controller
{
    /**
     * 商品品牌首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $brands = GoodsBrand::orderBy('sort_order', 'desc')->paginate(10);
        return view('admin.goods_brand.index', [
            'brands' => $brands,
        ]);
    }

    /**
     * 商品品牌添加
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $brandName = trim($request->input('goods_brand_name'));
            $description = trim($request->input('description'));
            $sortOrder = intval($request->input('sort_order'));
            $isShow = intval($request->input('is_show'));
            $brandIcon = $request->file('brandIcon');
            if (!$brandIcon) return ResponseJson::getInstance()->errorJson('请上传品牌logo');

            if (empty($brandName)) {
                return ResponseJson::getInstance()->errorJson('品牌名称不能为空');
            }
            if (GoodsBrand::whereGoodsBrandName($brandName)->exists()) {
                return ResponseJson::getInstance()->errorJson('品牌名称已存在');
            }

            if($brandIcon){
                if (!$brandIcon->isValid()) {
                    return ResponseJson::getInstance()->errorJson('品牌LOGO不正确');
                }
                $brandIcon = CommonHelper::getInstance()->uploadFile(1,$brandIcon, 'goods_brand/');
            }

            \DB::beginTransaction();
            try {
                GoodsBrand::create([
                    'goods_brand_name' => $brandName,
                    'description' => $description,
                    'sort_order' => $sortOrder,
                    'is_show' => $isShow,
                    'logo' => isset($brandIcon)?$brandIcon:'',
                ]);
                AdminLog::getInstance()->addLog("添加商品品牌:{$brandName}");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('商品品牌添加成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.goods_brand.add');
    }

    /**
     * 商品品牌编辑
     *
     * @param Request $request
     * @param GoodsBrand $goodsBrand
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request, GoodsBrand $goodsBrand) {
        if ($request->isMethod('post')) {
            $brandName = trim($request->input('goods_brand_name'));
            $description = trim($request->input('description'));
            $sortOrder = intval($request->input('sort_order'));
            $isShow = intval($request->input('is_show'));
            $brandIcon = $request->file('cateImg');

            if (empty($brandName)) {
                return ResponseJson::getInstance()->errorJson('品牌名称不能为空');
            }
            if (GoodsBrand::where('id', '!=', $goodsBrand->id)->whereGoodsBrandName($brandName)->exists()) {
                return ResponseJson::getInstance()->errorJson('品牌名称已存在');
            }

            if($brandIcon){
                if (!$brandIcon->isValid()) {
                    return ResponseJson::getInstance()->errorJson('品牌LOGO不正确');
                }
                $brandIcon = CommonHelper::getInstance()->uploadFile(1,$brandIcon, 'goods_brand/');

            }

            \DB::beginTransaction();
            try {
                $goodsBrand->goods_brand_name = $brandName;
                $goodsBrand->description = $description;
                $goodsBrand->sort_order = $sortOrder;
                $goodsBrand->is_show = $isShow;
                if (isset($brandIcon)) $goodsBrand->logo = $brandIcon;
                $goodsBrand->save();
                AdminLog::getInstance()->addLog("编辑商品品牌:{$brandName}");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('商品品牌编辑成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.goods_brand.edit', [
            'brand' => $goodsBrand,
        ]);
    }

    /**
     * 商品品牌删除
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
        $adminNames = GoodsBrand::whereIn('id', $ids)->pluck('goods_brand_name')->toArray();
        GoodsBrand::whereIn('id', $ids)->delete();
        if (!empty($adminNames)) {
            AdminLog::getInstance()->addLog("删除商品品牌:".implode(',', $adminNames));
        }
        return ResponseJson::getInstance()->doneJson('删除成功');
    }
}
