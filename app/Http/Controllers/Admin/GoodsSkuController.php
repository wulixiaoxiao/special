<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Models\AdminLog;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\GoodsImages;
use App\Models\GoodsSku;
use App\Models\Sku;
use App\Models\SkuValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\CommonHelper;
use App\Helper\ResponseJson;

class GoodsSkuController extends Controller
{
    /**
     * 商品SKU列表页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $goodsId = intval($request->input('goods_id'));
        $goodsSkus = GoodsSku::whereGoodsId($goodsId)->paginate(10);
        foreach ($goodsSkus as $key => $value) {
            $goodsSkus[$key]['market_price'] = CommonHelper::getInstance()->formatPriceToShow($value->market_price);
            $goodsSkus[$key]['selling_price'] = CommonHelper::getInstance()->formatPriceToShow($value->selling_price);
        }

        return view('admin.goods_sku.index', [
            'goods_skus' => $goodsSkus,
            'goods_id' => $goodsId,
        ]);
    }

    /**
     * 关联商品SKU添加
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Request $request) {
        $goodsId = intval($request->input('goods_id'));
        $goods = Goods::whereId($goodsId)->first();
        $skuIds = $goods->sku->pluck('id');
        $skus = Sku::whereIn('id', $skuIds)->get();
        $skuValues = SkuValue::whereIn('sku_id', $skuIds)->get();
        if ($request->isMethod('post')) {
            $skuIdStr = trim($request->input('sku_id_str'));
            $skuValueStr = trim($request->input('sku_value_str'));
            $marketPrice = CommonHelper::getInstance()->formatPriceToDatabase($request->input('market_price'));
            $sellingPrice = CommonHelper::getInstance()->formatPriceToDatabase($request->input('selling_price'));
            $stock = intval($request->input('stock'));
            $thumb = $request->file('thumb');
            $goodsImages = $request->file('goods_images');
            $goods = Goods::whereId($goodsId)->first();

            if (!$goods) {
                return ResponseJson::getInstance()->errorJson('商品不存在');
            }
            if (empty($skuIdStr) || empty($skuValueStr)) {
                return ResponseJson::getInstance()->errorJson('请选择SKU可选项组合');
            }
            $skuIdStr = array_filter(explode(',', $skuIdStr));
            $skuValueStr = array_filter(explode(',', $skuValueStr));
            if (empty($skuIdStr) || empty($skuValueStr) || count($skuIdStr) != count($skuValueStr)) {
                return ResponseJson::getInstance()->errorJson('请选择SKU可选项组合');
            }
            if (count(array_intersect($skuIds->toArray(), $skuIdStr)) != count($skuIdStr)) {
                return ResponseJson::getInstance()->errorJson('非法SKU');
            }
            if (count(array_intersect($skuValues->pluck('id')->toArray(), $skuValueStr)) != count($skuValueStr)) {
                return ResponseJson::getInstance()->errorJson('非法SKU选项值');
            }
            $skuIdStr = implode(',', $skuIdStr);
            $skuValueStr = implode(',', $skuValueStr);
            if (GoodsSku::whereGoodsId($goods->id)->whereSkuIds($skuIdStr)->whereSkuValueIds($skuValueStr)->exists()) {
                return ResponseJson::getInstance()->errorJson('该SKU选项值组合已存在');
            }
//            if ($marketPrice <= 0) { return ResponseJson::getInstance()->errorJson('市场价格不能为空'); }
            if ($sellingPrice <=0) { return ResponseJson::getInstance()->errorJson('实际价格不能为空'); }
            if ($stock <= 0) { return ResponseJson::getInstance()->errorJson('库存不能为空'); }

            try {
                # 创建规格
                $goodsSku = GoodsSku::create([
                    'goods_id' => $goods->id,
                    'sku_ids' => $skuIdStr,
                    'sku_value_ids' => $skuValueStr,
                    'market_price' => $marketPrice,
                    'selling_price' => $sellingPrice,
                    'stock' => $stock,
                    'is_default' => 0,
                ]);

                # 上传缩略图
                if ($thumb) {
                    if (!$thumb->isValid()) {
                        return ResponseJson::getInstance()->errorJson('商品缩略图不正确');
                    }
                    $thumbPic = CommonHelper::getInstance()->uploadFile(1,$thumb, 'goods_thumb/');
                    GoodsImages::create([
                        'goods_sku_id' => $goodsSku->id,
                        'type' => 1,
                        'img_url' => $thumbPic,
                        'sort_order' => 0,
                        'create_time' => time(),
                    ]);
                }

                # 上传商品相册图
                if ($goodsImages) {
                    foreach ($goodsImages as $goodsFile) {
                        $thumbPic = CommonHelper::getInstance()->uploadFile(1,$goodsFile, 'goods_thumb/');
                        GoodsImages::create([
                            'goods_sku_id' => $goodsSku->id,
                            'type' => 2,
                            'img_url' => $thumbPic,
                            'sort_order' => 0,
                            'create_time' => time(),
                        ]);
                    }
                }
                AdminLog::getInstance()->addLog("添加关联商品SKU:{$goods->goods_name},SKU组合:({$skuIdStr}:{$skuValueStr})");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('添加成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.goods_sku.add', [
            'skus' => $skus,
            'goods' => $goods,
            'skuIds' => $skuIds,
         ]);
    }

    /**
     * 搜索sku值
     */
    public function getsku(Request $request){
        $idtag = $request->input('idtag');
        $id = $request->input('id');
        $sea = trim($request->input('sea'));
        $skuValues = SkuValue::where('sku_id',$id)->where('sku_value_name','like',"%$sea%")->get()->toArray();
        return response()->json(['status'=>1,'data'=>$skuValues]);
    }

    /**
     * 关联商品SKU编辑
     *
     * @param Request $request
     * @param GoodsSku $goodsSku
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request, GoodsSku $goodsSku) {
        $goods = Goods::whereId($goodsSku->goods_id)->first();
        if ($request->isMethod('post')) {
            $marketPrice = CommonHelper::getInstance()->formatPriceToDatabase($request->input('market_price'));
            $sellingPrice = CommonHelper::getInstance()->formatPriceToDatabase($request->input('selling_price'));
            $stock = intval($request->input('stock'));
            $thumb = $request->file('thumb');
            $goodsImages = $request->file('goods_images');

//            if ($marketPrice <= 0) { return ResponseJson::getInstance()->errorJson('市场价格不能为空'); }
            if ($sellingPrice <=0) { return ResponseJson::getInstance()->errorJson('实际价格不能为空'); }
            if ($stock <= 0) { return ResponseJson::getInstance()->errorJson('库存不能为空'); }

            try {
                # 编辑规格
                $goodsSku->market_price = $marketPrice;
                $goodsSku->selling_price = $sellingPrice;
                $goodsSku->stock = $stock;
                $goodsSku->save();

                # 上传缩略图
                if ($thumb) {
                    if (!$thumb->isValid()) {
                        return ResponseJson::getInstance()->errorJson('商品缩略图不正确');
                    }
                    $thumbPic = CommonHelper::getInstance()->uploadFile(1,$thumb, 'goods_thumb/');
                    $image = GoodsImages::whereGoodsSkuId($goodsSku->id)->whereType(1)->first();
                    if ($image) {
                        if ($image->img_url) { @unlink(public_path($image->img_url)); }
                        $image->img_url = $thumbPic;
                        $image->sort_order = 0;
                        $image->save();
                    } else {
                        GoodsImages::create([
                            'goods_sku_id' => $goodsSku->id,
                            'type' => 1,
                            'img_url' => $thumbPic,
                            'sort_order' => 0,
                            'create_time' => time(),
                        ]);
                    }
                }

                # 上传商品相册图
                if ($goodsImages) {
                    foreach ($goodsImages as $goodsFile) {
                        $thumbPic = CommonHelper::getInstance()->uploadFile(1,$goodsFile, 'goods_thumb/');
                        GoodsImages::create([
                            'goods_sku_id' => $goodsSku->id,
                            'type' => 2,
                            'img_url' => $thumbPic,
                            'sort_order' => 0,
                            'create_time' => time(),
                        ]);
                    }
                }
                AdminLog::getInstance()->addLog("编辑关联商品SKU:{$goods->goods_name},SKU组合:({$goodsSku->sku_ids}:{$goodsSku->sku_value_ids})");
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('编辑成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        $goodsSku->market_price = CommonHelper::getInstance()->formatPriceToShow($goodsSku->market_price);
        $goodsSku->selling_price = CommonHelper::getInstance()->formatPriceToShow($goodsSku->selling_price);
        $goodsThumb = GoodsImages::whereGoodsSkuId($goodsSku->id)->whereType(1)->first();
        $goodsImages = GoodsImages::whereGoodsSkuId($goodsSku->id)->whereType(2)->get();
//        $goodsThumb && ($goodsThumb->img_url = CommonHelper::getInstance()->getOssPath($goodsThumb->img_url));
//        if ($goodsImages) {
//            foreach ($goodsImages as $key => &$value) {
//                $value->img_url = CommonHelper::getInstance()->getOssPath($value->img_url);
//            }
//        }
        return view('admin.goods_sku.edit', [
            'goods' => $goods,
            'goodsSku' => $goodsSku,
            'goods_thumb' => $goodsThumb,
            'goods_images' => $goodsImages,
        ]);
    }

    /**
     * 关联商品SKU删除
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request) {
        $id = intval($request->input('id'));
        $goodsSku = GoodsSku::whereId($id)->whereIsDefault(0)->firstOrFail();
        \DB::beginTransaction();
        try {
            $goodsImagesUrl = GoodsImages::whereGoodsSkuId($goodsSku->id)->pluck('img_url');
            GoodsImages::whereGoodsSkuId($goodsSku->id)->delete();
            Cart::whereSkuId($goodsSku->id)->delete(); // 删除购物车中相关记录
            AdminLog::getInstance()->addLog("删除关联商品SKU:{$goodsSku->goods_name},SKU组合:({$goodsSku->sku_ids}:{$goodsSku->sku_value_ids})");
            $goodsSku->delete();
            foreach ($goodsImagesUrl as $key => $value) {
                @unlink(public_path($value));
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('删除成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }
}
