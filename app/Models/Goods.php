<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper\CommonHelper;

/**
 * App\Models\Goods
 *
 * @property int $id
 * @property int $goods_category_id 商品分类ID
 * @property string $goods_name 商品名称
 * @property string $goods_description 商品描述
 * @property int $goods_weight 商品重量,以克为单位
 * @property int $goods_margin 商品毛利,以分为单位
 * @property int $market_price 市场价格,以分为单位
 * @property int $selling_price 实际价格,以分为单位
 * @property int $stock 库存数
 * @property int $sort_order 商品排序
 * @property string $goods_detail 商品详情
 * @property bool $is_free_shipping 是否包邮(1:是,0:否)
 * @property bool $is_online 是否上架(1:是,0:否)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereGoodsCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereGoodsName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereGoodsDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereGoodsWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereGoodsMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereMarketPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereSellingPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereStock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereGoodsDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereIsFreeShipping($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereIsOnline($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\GoodsCategory $goodsCategory
 * @property-read mixed $goods_category_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GoodsSku[] $goodsSku
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sku[] $sku
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GoodsComment[] $goodsComment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $cart
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GoodsCollection[] $goodsCollection
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderGoods[] $orderGoods
 * @property bool $goods_brand_id 商品所属品牌id
 * @property string $tag 商品标签
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereGoodsBrandId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Goods whereTag($value)
 */
class Goods extends Model
{
    use BaseModelTrait;

    protected $table = 'goods';

    protected $guarded = ['id'];

    protected $appends = ['goods_category_name'];

    public function getGoodsCategoryNameAttribute() {
        return $this->goodsCategory()->value('goods_category_name');
    }

    public function goodsCategory() {
        return $this->belongsTo(GoodsCategory::class, 'goods_category_id', 'id');
    }

    public function goodsSku() {
        return $this->hasMany(GoodsSku::class, 'goods_id', 'id');
    }

    public function sku() {
        return $this->belongsToMany(Sku::class, 'goods_sku_set', 'goods_id', 'sku_id');
    }

    public function goodsComment() {
        return $this->hasMany(GoodsComment::class, 'goods_id', 'id');
    }

    public function cart() {
        return $this->hasMany(Cart::class, 'goods_id', 'id');
    }

    public function goodsCollection() {
        return $this->hasMany(GoodsCollection::class, 'goods_id', 'id');
    }

    public function orderGoods() {
        return $this->hasMany(OrderGoods::class, 'goods_id', 'id');
    }

    /**
     * 组装商品SKU
     *
     * @param $goods_id
     * @return array
     */
    public function formatGoodsSku($goods_id) {
        $goods = Goods::whereId($goods_id)->first();
        $goodsSkus = GoodsSku::whereGoodsId($goods_id)->whereIsDefault(0)->get();
        $skuIds = $skuValueIds = [];
        $defaultGoodsSku = GoodsSku::whereGoodsId($goods_id)->whereIsDefault(1)->first();
        $goodsSkusArr = [];
        $skuItems = [];
        $skus = [];
        $defaultSku = [];

        foreach ($goodsSkus as $key => $value) {
            $str = '';
            $skuIdsArr = explode(',', $value->sku_ids);
            $skuValueIdsArr = explode(',', $value->sku_value_ids);

            foreach ($skuIdsArr as $k => $v) {
                !isset($skuIds[$v]) && $skuIds[$v] = [];
                $skuIds[$v][] = $skuValueIdsArr[$k];
                $str .= $v.':'.$skuValueIdsArr[$k].',';
             }
            $str = trim($str, ',');
            $goodsSkusArr[$value->id] = $str;

            # 格式化SKU
            $skus[$value->id]['id'] = $value->id;
            $skus[$value->id]['goods_id'] = $value->goods_id;
            $skus[$value->id]['market_price'] = CommonHelper::getInstance()->formatPriceToShow($value->market_price);
            $skus[$value->id]['selling_price'] = CommonHelper::getInstance()->formatPriceToShow($value->selling_price);
            $skus[$value->id]['stock'] = $value->stock;
            $skus[$value->id]['is_default'] = $value->is_default;
            $skus[$value->id]['thumb'] = $this->getGoodsSkuThumb($value->id);
            $skus[$value->id]['images'] = $this->getGoodsSkuImages($value->id);
//            $skus[$value->id]['coin_rebate'] = $this->getCoinRebate($value->selling_price);
        }

        # 格式化默认SKU
        $defaultSku['id'] = $defaultGoodsSku->id;
        $defaultSku['goods_id'] = $defaultGoodsSku->goods_id;
        $defaultSku['market_price'] = CommonHelper::getInstance()->formatPriceToShow($defaultGoodsSku->market_price);
        $defaultSku['selling_price'] = CommonHelper::getInstance()->formatPriceToShow($defaultGoodsSku->selling_price);
        $defaultSku['stock'] = $defaultGoodsSku->stock;
        $defaultSku['is_default'] = $defaultGoodsSku->is_default;
        $defaultSku['thumb'] = $this->getGoodsSkuThumb($defaultGoodsSku->id);
        $defaultSku['images'] = $this->getGoodsSkuImages($defaultGoodsSku->id);
//        $defaultSku['coin_rebate'] = $this->getCoinRebate($defaultGoodsSku->selling_price);

        # 格式化商品
//        $goods['goods_rebate'] = CommonHelper::getInstance()->formatPriceToShow($this->getGoodsRebate($goods->goods_margin));
//        $goods['member_rebate'] = CommonHelper::getInstance()->formatPriceToShow($this->getMemberRebate($goods->goods_margin));
//        $goods['coin_rebate'] = $this->getCoinRebate($goods->selling_price); // 注意顺序
        $goods['market_price'] = CommonHelper::getInstance()->formatPriceToShow($goods->market_price);
        $goods['selling_price'] = CommonHelper::getInstance()->formatPriceToShow($goods->selling_price);

        foreach($skuIds as $key => $value) {
            $skuItems[$key]['skuItem'] = Sku::whereId($key)->first()->toArray();
            $skuItems[$key]['skuValueItems'] = SkuValue::whereIn('id', array_unique($value))->get()->toArray();
        }
        return [
            'skuIds' => !empty($skuIds) ? array_keys($skuIds) : [],
            'skuValueIds' => $skuValueIds,
            'defaultGoodsSku' => $defaultGoodsSku,
            'goodsSkusArr' => $goodsSkusArr,
            'skuItems' => $skuItems,
            'goods' => $goods,
            'skus' => $skus,
            'defaultSku' => $defaultSku,
        ];
    }

    /**
     * 获取商品SKU对应的商品缩略图
     *
     * @param $goodsSKuId
     * @return string
     */
    function getGoodsSkuThumb($goodsSKuId) {
        $thumb = GoodsImages::whereGoodsSkuId($goodsSKuId)->whereType(1)->value('img_url');
        if (empty($thumb)) { $thumb = 'assets/front/images/default_goods_thumb.jpg'; }
        return $thumb;
    }

    /**
     * 获取商品SKU对应的商品相册图
     *
     * @param $goodsSKuId
     * @return array
     */
    function getGoodsSkuImages($goodsSKuId) {
        $images = GoodsImages::whereGoodsSkuId($goodsSKuId)->whereType(2)->pluck('img_url')->toArray();
        if (empty($images)) { $images[] = 'assets/front/images/default_goods_images.jpg'; }
        foreach ($images as $key => $value) {
            $images[$key] = $value;
        }
        return $images;
    }

    /**
     * 计算返利(以分为单位)
     *
     * @param $goodsMargin
     * @return mixed
     */
    function getGoodsRebate($goodsMargin) {
        $firstRebate = Config::getInstance()->getConfigValue('first_rebate');
        $money = ($firstRebate * $goodsMargin) / 100;
        return $money;
    }

    /**
     * 计算代言人总奖金(以分为单位)
     *
     * @param $goodsMargin
     * @return mixed
     */
    function getMemberRebate($goodsMargin) {
        $secondRebate = Config::getInstance()->getConfigValue('second_rebate');
        $thirdRebate = Config::getInstance()->getConfigValue('third_rebate');
        $money = (($secondRebate + $thirdRebate) * $goodsMargin) / 100;
        return $money;
    }

    /**
     * 计算松鼠币返利
     *
     * @param $sellingPrice
     * @return float
     */
    function getCoinRebate($sellingPrice) {
        $coinRebate = Config::getInstance()->getConfigValue('coin_rebate');
        $money = round(($coinRebate * $sellingPrice) / 10000);
        return $money;
    }

    /**
     * 计算一级粉丝返利(以分为单位)
     *
     * @param $goodsMargin
     * @return float
     */
    function getFirstRebate($goodsMargin) {
        $secondRebate = Config::getInstance()->getConfigValue('second_rebate');
        $money = ($secondRebate * $goodsMargin) / 100;
        return $money;
    }

    /**
     * 计算二级粉丝返利(以分为单位)
     *
     * @param $goodsMargin
     * @return float
     */
    function getSecondRebate($goodsMargin) {
        $thirdRebate = Config::getInstance()->getConfigValue('third_rebate');
        $money = ($thirdRebate * $goodsMargin) / 100;
        return $money;
    }
}
