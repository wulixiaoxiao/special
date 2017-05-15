<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Helper\CommonHelper;
use App\Helper\ResponseJson;
use App\Models\AdminLog;
use App\Models\GoodsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsCategoryController extends Controller
{
    /**
     * 商品分类首页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $categories = GoodsCategory::orderBy('sort_order', 'desc')->paginate(10);
        return view('admin.goods_category.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * 商品分类添加
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $categoryName = trim($request->input('goods_category_name'));
            $sortOrder = intval($request->input('sort_order'));
            $isShow = intval($request->input('is_show'));
            $cateImg = $request->file('cateImg');
            $cateIcon = $request->file('cateIcon');

            if (!$cateImg) return ResponseJson::getInstance()->errorJson('请上传分类图片');
            if (!$cateIcon) return ResponseJson::getInstance()->errorJson('请上传分类图标');

            if (empty($categoryName)) {
                return ResponseJson::getInstance()->errorJson('分类名称不能为空');
            }
            if (GoodsCategory::whereGoodsCategoryName($categoryName)->exists()) {
                return ResponseJson::getInstance()->errorJson('分类名称已存在');
            }

            if($cateImg){
                if (!$cateImg->isValid()) {
                    return ResponseJson::getInstance()->errorJson('商品缩略图不正确');
                }
                $categoryImg = CommonHelper::getInstance()->uploadFile(1,$cateImg, 'goods_category/');
            }
            if($cateIcon){
                if (!$cateIcon->isValid()) {
                    return ResponseJson::getInstance()->errorJson('商品缩略图不正确');
                }
                $categoryIcon = CommonHelper::getInstance()->uploadFile(1,$cateIcon, 'goods_category/');
            }

            \DB::beginTransaction();
            try {
                GoodsCategory::create([
                    'goods_category_name' => $categoryName,
                    'sort_order' => $sortOrder,
                    'is_show' => $isShow,
                    'category_img' => isset($categoryImg)?$categoryImg:'',
                    'category_icon' => isset($categoryIcon)?$categoryIcon:'',
                ]);
                AdminLog::getInstance()->addLog("添加商品分类:{$categoryName}");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('商品分类添加成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.goods_category.add');
    }

    /**
     * 商品分类编辑
     *
     * @param Request $request
     * @param GoodsCategory $goodsCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request, GoodsCategory $goodsCategory) {
        if ($request->isMethod('post')) {
            $categoryName = trim($request->input('goods_category_name'));
            $sortOrder = intval($request->input('sort_order'));
            $isShow = intval($request->input('is_show'));
            $cateImg = $request->file('cateImg');
            $cateIcon = $request->file('cateIcon');

            if (empty($categoryName)) {
                return ResponseJson::getInstance()->errorJson('分类名称不能为空');
            }
            if (GoodsCategory::where('id', '!=', $goodsCategory->id)->whereGoodsCategoryName($categoryName)->exists()) {
                return ResponseJson::getInstance()->errorJson('分类名称已存在');
            }

            if($cateImg){
                if (!$cateImg->isValid()) {
                    return ResponseJson::getInstance()->errorJson('商品缩略图不正确');
                }
                $categoryImg = CommonHelper::getInstance()->uploadFile(1,$cateImg, 'goods_category/');
            }
            if($cateIcon){
                if (!$cateIcon->isValid()) {
                    return ResponseJson::getInstance()->errorJson('商品缩略图不正确');
                }
                $categoryIcon = CommonHelper::getInstance()->uploadFile(1,$cateIcon, 'goods_category/');
            }

            \DB::beginTransaction();
            try {
                $goodsCategory->goods_category_name = $categoryName;
                $goodsCategory->sort_order = $sortOrder;
                $goodsCategory->is_show = $isShow;
                if (isset($categoryImg)) $goodsCategory->category_img = $categoryImg;
                if (isset($categoryIcon)) $goodsCategory->category_icon = $categoryIcon;
                $goodsCategory->save();

                AdminLog::getInstance()->addLog("编辑商品分类:{$categoryName}");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('商品分类编辑成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }

        return view('admin.goods_category.edit', [
            'category' => $goodsCategory,
        ]);
    }

    /**
     * 商品分类删除
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
        $adminNames = GoodsCategory::whereIn('id', $ids)->pluck('goods_category_name')->toArray();
        GoodsCategory::whereIn('id', $ids)->delete();
        if (!empty($adminNames)) {
            AdminLog::getInstance()->addLog("删除商品分类:".implode(',', $adminNames));
        }
        return ResponseJson::getInstance()->doneJson('删除成功');
    }
}
