<?php

namespace App\Http\Controllers\CommunityApi;

use App\Helper\ResponseJson;
use App\Models\Goods;
use App\Models\GoodsBrand;
use App\Models\GoodsCategory;
use App\Models\GoodsCollection;
use App\Models\GoodsComment;
use App\Models\GoodsImages;
use App\Models\GoodsSku;
use App\Models\Order;
use App\Models\Sku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\CommonHelper;

class GoodsController extends Controller
{
    /**
     * 商品详情页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $memberId = $request->user()->id;
        $goodsId = intval($request->input('id',''));
        $goods = Goods::whereId($goodsId)->first();
        if (!$goods) return ResponseJson::getInstance()->errorJson('商品不存在');

        //读取goods_sku
        $goodsSku = GoodsSku::whereGoodsId($goodsId)->get()->toArray();

        foreach ($goodsSku as $k=>$v){
            if (!isset($v['sku_ids']) || empty($v['sku_ids'])){
                unset($goodsSku[$k]);
//                $goodsSku[$k]['sku_values'] = '';
            }else{
//                $skuids = Sku::whereIn('id', explode(',', $v['sku_ids']))->select('sku_name')->get()->toArray();
//                $skuValues = implode(',', array_column($skuids, 'sku_name'));
//                $goodsSku[$k]['sku_values'] = $skuValues;
                // 读取商品图片
                $goodsSku[$k]['goods_images'] = GoodsImages::whereGoodsSkuId($v['id'])->get()->toArray();
            }
        }

        $goods['goods_sku'] = array_values($goodsSku);

        $params = Goods::getInstance()->formatGoodsSku($goods->id);
        $params['brandInfo'] = GoodsBrand::whereId($goods->goods_brand_id)->first();
        $goods['is_comment'] = 0;
        if ($memberId > 0 && GoodsCollection::whereMemberId($memberId)->whereGoodsId($goodsId)->exists()) {
            $goods['is_comment'] = 1;
        }

        // 读取商品收藏
        $collectionInfo = GoodsCollection::with('member')->whereGoodsId($goodsId)->get();
        $collectionList = [];
        foreach ($collectionInfo as $k => $v) {
            $collectionList[$k]['member_id'] = $v['member_id'];
            $collectionList[$k]['name'] = $v['member']['name'];
            $collectionList[$k]['avatar'] = $v['member']['avatar'];
        }
        $params['collectionList'] = $collectionList;
        $params['commentNum'] = GoodsComment::whereGoodsId($goodsId)->count();
        // TODO 可能喜欢
        $goodsList = Goods::orderBy('sort_order', 'desc')->limit(4)->get()->toArray();
        $params['goodsList'] = $goodsList;
        return ResponseJson::getInstance()->doneJson('获取成功', $params);
    }

    /**
     * 获取商品分类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategory(Request $request){
        $categorys = GoodsCategory::whereIsShow(1)->get();
        return ResponseJson::getInstance()->doneJson('获取成功', $categorys);
    }

    /**
     * 商品列表页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodslist(Request $request){
        $search = $request->input('search','');
        $cate = $request->input('cate',0);
        $page = $request->input('page',1);
        $pagesize = $request->input('pagesize',10);
        $cateInfo = GoodsCategory::where('id',$cate)->first();
        if (!$cateInfo) $cateInfo = new \stdClass();
        if ($search){
            $goods = Goods::where('goods_name','like',"%$search%")->orderBy('sort_order', 'desc')->whereIsOnline(1)->offset(($page - 1)*$pagesize)->limit($pagesize)->get()->toArray();
        }else if ($cate){
            $goods = Goods::where('goods_category_id',$cate)->orderBy('sort_order', 'desc')->whereIsOnline(1)->offset(($page - 1)*$pagesize)->limit($pagesize)->get()->toArray();
        }else{
            $goods = Goods::orderBy('sort_order', 'desc')->whereIsOnline(1)->offset(($page - 1)*$pagesize)->limit($pagesize)->get()->toArray();
        }
        foreach ($goods as $key => $value) {
            // 读取商品收藏
            $collectionInfo = GoodsCollection::with('member')->whereGoodsId($value['id'])->get()->toArray();
            $collectionList = [];
            foreach ($collectionInfo as $k => $v) {
                $collectionList[$k]['member_id'] = $v['member_id'];
                $collectionList[$k]['name'] = $v['member']['name'];
                $collectionList[$k]['avatar'] = $v['member']['avatar'];
            }
            $goods[$key]['commentNum'] = GoodsComment::whereGoodsId($value['id'])->count();
            $goods[$key]['collection'] = $collectionList;
            $defaultSku = GoodsSku::whereGoodsId($value['id'])->whereIsDefault(1)->first();
            $goods[$key]['thumb'] = Goods::getInstance()->getGoodsSkuThumb($defaultSku->id);
            $goods[$key]['market_price'] = CommonHelper::getInstance()->formatPriceToShow($defaultSku->market_price);
            $goods[$key]['selling_price'] = CommonHelper::getInstance()->formatPriceToShow($defaultSku->selling_price);
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $goods);
    }

    /**
     * Ajax获取商品评价
     *
     * @param Request $request
     * @return array
     */
    public function getGoodsComments(Request $request) {
        $goodsId = intval($request->input('goods_id'));
        $page = $request->input('page',1);
        $pagesize = $request->input('pagesize',10);
        $comments = GoodsComment::whereGoodsId($goodsId)->whereIsShow(1)->orderBy('create_time', 'desc')->offset(($page-1)*$pagesize)->limit($pagesize)->get();
        $lists = [];
        foreach ($comments as $key => $value) {
            $lists[$key]['goods_id'] = $value['goods_id'];
            $lists[$key]['order_id'] = $value['order_id'];
            $lists[$key]['goods_name'] = isset($value->goods) ? $value->goods->goods_name : '';
            $lists[$key]['order_sn'] = isset($value->order) ? $value->order->order_sn : '';
            $lists[$key]['phone'] = isset($value->member->phone) ? CommonHelper::getInstance()->encryptMobile($value->member->phone) : '';
            $lists[$key]['name'] = isset($value->member->name) ? CommonHelper::getInstance()->unicodeDecode($value->member->name) : '';
            $lists[$key]['avatar'] = isset($value->member->avatar) ? $value->member->avatar : '';
            $lists[$key]['content'] = $value['content'];
            $lists[$key]['create_time'] = $value['created_at'];
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $lists);
    }

    public function subGoodsComments(Request $request){
        $me = $request->user();
        $orderId = intval($request->input('order_id'));
        $goodsId = intval($request->input('goods_id'));
        $content = trim($request->input('content'));
        if (empty($orderId) || empty($goodsId) || empty($content)) return ResponseJson::getInstance()->errorJson('参数错误');
        $orderInfo = Order::whereId($orderId)->whereStatus(4)->first();
        if (!$orderInfo || $orderInfo->member_id != $me->id) return ResponseJson::getInstance()->errorJson('错误');
        GoodsComment::create([
            'member_id' => $me->id,
            'order_id' => $orderId,
            'goods_id' => $goodsId,
            'content' => $content,
            'is_show' => 0,
            'create_time' => time(),
        ]);
        return ResponseJson::getInstance()->doneJson('成功');
    }

    /**
     * 商品收藏
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addGoodsCollection(Request $request) {
        $memberId = $request->user()->id;
        $goodsId = intval($request->input('goods_id'));
        $goods = Goods::whereId($goodsId)->first();

        if (!$goods) {
            return ResponseJson::getInstance()->errorJson('该商品不存在');
        }
        if ($goods->is_online == 0) {
            return ResponseJson::getInstance()->errorJson('该商品已下架');
        }
        $collection = GoodsCollection::whereMemberId($memberId)->whereGoodsId($goodsId)->first();
        if (!$collection) {
            GoodsCollection::create([
                'member_id' => $memberId,
                'goods_id' => $goods->id,
                'create_time' => time(),
            ]);
            return ResponseJson::getInstance()->doneJson('收藏成功', 1);
        } else {
            $collection->delete();
            return ResponseJson::getInstance()->doneJson('取消收藏', 0);
        }
    }
}
