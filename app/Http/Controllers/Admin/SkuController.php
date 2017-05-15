<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Helper\ResponseJson;
use App\Models\AdminLog;
use App\Models\GoodsSku;
use App\Models\Sku;
use App\Models\SkuValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkuController extends Controller
{
    /**
     * SKU管理列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $skus = Sku::where(function($query) use ($request) {
            if (!empty($request->input('search'))) {
                $query->where('sku_name', 'like', '%'.$request->input('search').'%');
            }
        })->paginate(10);
        return view('admin.sku.index', [
            'skus' => $skus,
            'search' => $request->input('search', ''),
        ]);
    }


    /**
     * SKU添加
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $skuName = trim($request->input('sku_name'));

            if (empty($skuName)) {
                return ResponseJson::getInstance()->errorJson('SKU名称不能为空');
            }
            if (Sku::whereSkuName($skuName)->exists()) {
                return ResponseJson::getInstance()->errorJson('SKU名称已存在');
            }

            \DB::beginTransaction();
            try {
                Sku::create([
                    'sku_name' => $skuName,
                ]);
                AdminLog::getInstance()->addLog("添加商品SKU:{$skuName}");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('商品SKU添加成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.sku.add');
    }

    /**
     * SKU编辑
     *
     * @param Request $request
     * @param Sku $sku
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request, Sku $sku) {
        if ($request->isMethod('post')) {
            $skuName = trim($request->input('sku_name'));

            if (empty($skuName)) {
                return ResponseJson::getInstance()->errorJson('SKU名称不能为空');
            }
            if (Sku::where('id', '!=', $sku->id)->whereSkuName($skuName)->exists()) {
                return ResponseJson::getInstance()->errorJson('SKU名称已存在');
            }

            \DB::beginTransaction();
            try {
                $sku->sku_name = $skuName;
                $sku->save();
                AdminLog::getInstance()->addLog("编辑商品SKU:{$sku->sku_name}");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('SKU编辑成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.sku.edit', [
            'sku' => $sku,
        ]);
    }

    /**
     * SKU删除
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete(Request $request) {
        $id = intval($request->input('id'));
        $sku = Sku::whereId($id)->first();
        if (!$sku) {
            return ResponseJson::getInstance()->errorJson('请选择要删除的记录');
        }
        if (GoodsSku::whereRaw("FIND_IN_SET({$sku->id},sku_ids)")->exists()) {
            return ResponseJson::getInstance()->errorJson('当前SKU仍被商品使用,请先取消该SKU的商品关联');
        }
        $skuName = $sku->sku_name;
        \DB::beginTransaction();
        try {
            $sku->delete();
            SkuValue::whereSkuId($sku->id)->delete();
            AdminLog::getInstance()->addLog("删除SKU:".$skuName);
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('删除成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }

    /**
     * 删除SKU可选项
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delSkuValue(Request $request) {
        $skuValueId = intval($request->input('sku_value_id'));
        $skuValue = SkuValue::whereId($skuValueId)->first();
        if (GoodsSku::whereRaw("FIND_IN_SET({$skuValue->id},sku_value_ids)")->exists()) {
            return ResponseJson::getInstance()->errorJson('当前SKU可选项仍被商品使用,请先取消该SKU可选项的商品关联');
        }

        \DB::beginTransaction();
        try {
            AdminLog::getInstance()->addLog("删除SKU可选项:({$skuValue['sku_name']}:{$skuValue['sku_value_name']})");
            $skuValue->delete();
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('删除成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }

    /**
     * 添加SKU可选项
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addSkuValue(Request $request) {
        $skuId = intval($request->input('sku_id'));
        $skuValueName = trim($request->input('sku_value'));
        $sku = Sku::whereId($skuId)->first();

        if (!$sku) {
            return ResponseJson::getInstance()->errorJson('SKU不存在');
        }
        if (empty($skuValueName)) {
            return ResponseJson::getInstance()->errorJson('可选项值不能为空');
        }
        if (SkuValue::whereSkuValueName($skuValueName)->exists()) {
            return ResponseJson::getInstance()->errorJson('可选项值已存在');
        }

        \DB::beginTransaction();
        try {
            SkuValue::create([
               'sku_id' => $skuId,
                'sku_value_name' => $skuValueName,
            ]);
            AdminLog::getInstance()->addLog("添加SKU可选项:({$sku['sku_name']}:{$skuValueName})");
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('添加成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }
}
