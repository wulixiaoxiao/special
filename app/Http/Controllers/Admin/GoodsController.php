<?php

namespace App\Http\Controllers\Admin;

use App\Helper\CommonHelper;
use App\Helper\ResponseJson;
use App\Models\AdminLog;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\GoodsBrand;
use App\Models\GoodsCategory;
use App\Models\GoodsCollection;
use App\Models\GoodsImages;
use App\Models\GoodsSku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiException;

class GoodsController extends Controller
{
    /**
     * 商品列表首页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $goods = Goods::where(function($query) use ($request) {
            if (!empty($request->input('search'))) {
                $query->where('goods_name', 'like', '%'.trim($request->input('search')).'%');
            }
        })->orderBy('id', 'desc')->paginate();
        return view('admin.goods.index', [
            'goods' => $goods,
            'search' => $request->input('search', ''),
        ]);
    }

    /**
     * 更改商品推荐状态
     * @param Request $request
     */
    public function changerec(Request $request){
        $tag = $request->input('tag',0);
        $sid = $request->input('sid',0);
        if(!$sid) return ResponseJson::getInstance()->doneJson('失败');
        $is_success = Goods::where('id',$sid)->update(['is_recommend'=>$tag]);
        if($is_success) return ResponseJson::getInstance()->doneJson('成功');
        return ResponseJson::getInstance()->doneJson('失败');
    }

    /**
     * 商品添加
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Request $request) {
        $categories = GoodsCategory::whereIsShow(1)->orderBy('sort_order', 'desc')->get();
        $brands = GoodsBrand::whereIsShow(1)->orderBy('sort_order', 'desc')->get();
        if ($request->isMethod('post')) {
            $goodsName = trim($request->input('goods_name'));
            $category = intval($request->input('goods_category'));
            $brand = intval($request->input('goods_brand'));
            $description = trim($request->input('description', ''));
            $tag = trim($request->input('tag', ''));
            $weight = CommonHelper::getInstance()->formatWeightToDatabase($request->input('goods_weight'));
            $goodsMargin = CommonHelper::getInstance()->formatPriceToDatabase($request->input('goods_margin'));
            $marketPrice = CommonHelper::getInstance()->formatPriceToDatabase($request->input('market_price'));
            $sellingPrice = CommonHelper::getInstance()->formatPriceToDatabase($request->input('selling_price'));
            $stock = intval($request->input('stock'));
            $sortOrder = intval($request->input('sort_order'));
            $isFreeShipping = intval($request->input('is_free_shipping'));
            $isOnline = intval($request->input('is_online'));
            $thumb = $request->file('thumb');
            $goodsImages = $request->file('goods_images');
            $detail = $request->input('goods_detail', '');

            if (empty($goodsName)) { return ResponseJson::getInstance()->errorJson('商品名称不能为空'); }
            if (Goods::whereGoodsName($goodsName)->exists()) { return ResponseJson::getInstance()->errorJson('商品已存在'); }
            if (!GoodsCategory::whereId($category)->whereIsShow(1)->exists()) { return ResponseJson::getInstance()->errorJson('请选择商品分类'); }
//            if ($weight <= 0) { return ResponseJson::getInstance()->errorJson('商品重量不能为空'); }
//            if ($goodsMargin <= 0) { return ResponseJson::getInstance()->errorJson('商品毛利不能为空'); }
//            if ($marketPrice <= 0) { return ResponseJson::getInstance()->errorJson('市场价格不能为空'); }
            if ($sellingPrice <=0) { return ResponseJson::getInstance()->errorJson('实际价格不能为空'); }
            if ($stock <= 0) { return ResponseJson::getInstance()->errorJson('库存不能为空'); }

            \DB::beginTransaction();
            try {
                # 创建商品
                $goods = Goods::create([
                    'goods_name' => $goodsName,
                    'goods_category_id' => $category,
                    'goods_brand_id' => $brand,
                    'goods_description' => $description,
                    'tag' => $tag,
                    'goods_weight' => $weight,
                    'goods_margin' => $goodsMargin,
                    'market_price' => $marketPrice,
                    'selling_price' => $sellingPrice,
                    'stock' => $stock,
                    'sort_order' => $sortOrder,
                    'goods_detail' => $detail,
                    'is_free_shipping' => $isFreeShipping,
                    'is_online' => $isOnline
                ]);
                # 创建默认规格
                $goodsSku = GoodsSku::where('goods_id', $goods->id)->whereIsDefault(1)->first();
                if ($goodsSku) { $goodsSku->delete(); }
                $goodsSku = GoodsSku::create([
                    'goods_id' => $goods->id,
                    'sku_ids' => '',
                    'sku_value_ids' => '',
                    'market_price' => $goods->market_price,
                    'selling_price' => $goods->selling_price,
                    'stock' => $goods->stock,
                    'is_default' => 1,
                ]);
                # 上传缩略图
                if ($thumb) {
                    if (!$thumb->isValid()) {
                        return ResponseJson::getInstance()->errorJson('商品缩略图不正确');
                    }
                    $thumbPic = CommonHelper::getInstance()->uploadFile(1,$thumb, 'goods/');
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
                        $thumbPic = CommonHelper::getInstance()->uploadFile(1,$goodsFile, 'goods/');
                        GoodsImages::create([
                            'goods_sku_id' => $goodsSku->id,
                            'type' => 2,
                            'img_url' => $thumbPic,
                            'sort_order' => 0,
                            'create_time' => time(),
                        ]);
                    }
                }
                AdminLog::getInstance()->addLog('添加商品:'.$goods->goods_name);
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('商品添加成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.goods.add', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    /**
     * 商品编辑
     *
     * @param Request $request
     * @param Goods $goods
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Goods $goods) {
        $categories = GoodsCategory::whereIsShow(1)->orderBy('sort_order', 'desc')->get();
        $brands = GoodsBrand::whereIsShow(1)->orderBy('sort_order', 'desc')->get();
        if ($request->isMethod('post')) {
            $goodsName = trim($request->input('goods_name'));
            $category = intval($request->input('goods_category'));
            $brand = intval($request->input('goods_brand'));
            $description = trim($request->input('description', ''));
            $tag = trim($request->input('tag', ''));
            $weight = CommonHelper::getInstance()->formatWeightToDatabase($request->input('goods_weight'));
            $goodsMargin = CommonHelper::getInstance()->formatPriceToDatabase($request->input('goods_margin'));
            $marketPrice = CommonHelper::getInstance()->formatPriceToDatabase($request->input('market_price'));
            $sellingPrice = CommonHelper::getInstance()->formatPriceToDatabase($request->input('selling_price'));
            $stock = intval($request->input('stock'));
            $sortOrder = intval($request->input('sort_order'));
            $isFreeShipping = intval($request->input('is_free_shipping'));
            $isOnline = intval($request->input('is_online'));
            $thumb = $request->file('thumb');
            $goodsImages = $request->file('goods_images');
            $detail = $request->input('goods_detail', '');

            if (empty($goodsName)) { return ResponseJson::getInstance()->errorJson('商品名称不能为空'); }
            if (Goods::whereGoodsName($goodsName)->where('id', '!=', $goods->id)->exists()) { return ResponseJson::getInstance()->errorJson('商品已存在'); }
            if (!GoodsCategory::whereId($category)->whereIsShow(1)->exists()) { return ResponseJson::getInstance()->errorJson('请选择商品分类'); }
//            if ($weight <= 0) { return ResponseJson::getInstance()->errorJson('商品重量不能为空'); }
//            if ($goodsMargin <= 0) { return ResponseJson::getInstance()->errorJson('商品毛利不能为空'); }
//            if ($marketPrice <= 0) { return ResponseJson::getInstance()->errorJson('市场价格不能为空'); }
            if ($sellingPrice <=0) { return ResponseJson::getInstance()->errorJson('实际价格不能为空'); }
            if ($stock <= 0) { return ResponseJson::getInstance()->errorJson('库存不能为空'); }

            \DB::beginTransaction();
            try {
                # 编辑商品
                $goods->goods_name = $goodsName;
                $goods->goods_category_id = $category;
                $goods->goods_brand_id = $brand;
                $goods->goods_description = $description;
                $goods->tag = $tag;
                $goods->goods_weight = $weight;
                $goods->goods_margin = $goodsMargin;
                $goods->market_price = $marketPrice;
                $goods->selling_price = $sellingPrice;
                $goods->stock = $stock;
                $goods->sort_order = $sortOrder;
                $goods->goods_detail = $detail;
                $goods->is_free_shipping = $isFreeShipping;
                $goods->is_online = $isOnline;
                $goods->save();

                # 编辑默认规格
                $goodsSku = GoodsSku::where('goods_id', $goods->id)->whereIsDefault(1)->first();
                $goodsSku->market_price = $goods->market_price;
                $goodsSku->selling_price = $goods->selling_price;
                $goodsSku->stock = $goods->stock;
                $goodsSku->save();

                # 上传缩略图
                if ($thumb) {
                    if (!$thumb->isValid()) {
                        return ResponseJson::getInstance()->errorJson('商品缩略图不正确');
                    }
                    $thumbPic = CommonHelper::getInstance()->uploadFile(1,$thumb, 'goods/');
                    $image = GoodsImages::whereGoodsSkuId($goodsSku->id)->whereType(1)->first();
                    if ($image) {
                        if ($image->img_url) { @unlink(public_path($image->img_url)); }
                        $image->img_url = $thumbPic;
                        $image->sort_order = $goods->sort_order;
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
                        $thumbPic = CommonHelper::getInstance()->uploadFile(1,$goodsFile, 'goods/');
                        GoodsImages::create([
                            'goods_sku_id' => $goodsSku->id,
                            'type' => 2,
                            'img_url' => $thumbPic,
                            'sort_order' => 0,
                            'create_time' => time(),
                        ]);
                    }
                }
                AdminLog::getInstance()->addLog('编辑商品:'.$goods->goods_name);
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('商品编辑成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }

        $goods->goods_weight = CommonHelper::getInstance()->formatWeightToShow($goods->goods_weight);
        $goods->goods_margin = CommonHelper::getInstance()->formatPriceToShow($goods->goods_margin);
        $goods->market_price = CommonHelper::getInstance()->formatPriceToShow($goods->market_price);
        $goods->selling_price = CommonHelper::getInstance()->formatPriceToShow($goods->selling_price);
        $defaultSku = GoodsSku::whereGoodsId($goods->id)->whereIsDefault(1)->first();
        $goodsThumb = GoodsImages::whereGoodsSkuId($defaultSku->id)->whereType(1)->first();
        $goodsImages = GoodsImages::whereGoodsSkuId($defaultSku->id)->whereType(2)->get();
//        $goodsThumb && ($goodsThumb->img_url = CommonHelper::getInstance()->formatImageToShow($goodsThumb->img_url));
//        $goodsThumb && ($goodsThumb->img_url = CommonHelper::getInstance()->getOssPath($goodsThumb->img_url));
//        if ($goodsImages) {
//            foreach ($goodsImages as $key => &$value) {
////                $value->img_url = CommonHelper::getInstance()->formatImageToShow($value->img_url);
//                $value->img_url = CommonHelper::getInstance()->getOssPath($value->img_url);
//            }
//        }
        return view('admin.goods.edit', [
            'categories' => $categories,
            'brands' => $brands,
            'goods' => $goods,
            'goods_thumb' => $goodsThumb,
            'goods_images' => $goodsImages,
        ]);
    }

    /**
     * 删除商品
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request) {
        $id = intval($request->input('id'));
        $goods = Goods::whereId($id)->firstOrFail();
        \DB::beginTransaction();
        try {
            $goodsName = $goods->goods_name;
            $goodsSkuIds = GoodsSku::whereGoodsId($goods->id)->pluck('id');
            $goodsImagesUrl = GoodsImages::whereIn('goods_sku_id', $goodsSkuIds)->pluck('img_url');
            GoodsSku::whereGoodsId($goods->id)->delete();
            GoodsImages::whereIn('goods_sku_id', $goodsSkuIds)->delete();
            Cart::whereGoodsId($goods->id)->delete(); // 删除购物车与此相关的记录
            GoodsCollection::whereGoodsId($goods->id)->delete(); // 删除收藏与此相关的记录
            $goods->delete();
            AdminLog::getInstance()->addLog('删除商品:'.$goodsName);
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

    /**
     * 删除商品相册图片
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request) {
        $id = intval($request->input('id'));
        $image = GoodsImages::whereId($id)->first();
        $image && @unlink(public_path($image->img_url));
        $image->delete();
        return ResponseJson::getInstance()->doneJson('图片删除成功');
    }

    /**
     * 获取商品
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGoods(){
        $lists = Goods::whereIsOnline(1)->select(['id', 'goods_name'])->get();
        return ResponseJson::getInstance()->doneJson('获取成功', $lists);
    }

    /**
     * 搜索商品
     */
    public function searchGoods(Request $request){
        $name = $request->input('search');
        if (!$name) {
            $lists = Goods::whereIsOnline(1)->select(['id', 'goods_name'])->get();
        }else{
            $lists = Goods::where('goods_name', 'like', "%$name%")->whereIsOnline(1)->select(['id', 'goods_name'])->get();
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $lists);
    }

}
