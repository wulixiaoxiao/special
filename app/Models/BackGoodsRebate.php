<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BackGoodsRebate
 *
 * @property int $id
 * @property int $after_sale_id 售后服务ID
 * @property int $goods_rebate_receiver 商品返利受益人ID
 * @property int $goods_rebate_money 商品返利金额(以分为单位)
 * @property int $first_rebate_receiver 一级返利受益人ID
 * @property int $first_rebate_money 一级返利金额(以分为单位)
 * @property int $second_rebate_receiver 二级返利受益人ID
 * @property int $second_rebate_money 二级返利金额(以分为单位)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereAfterSaleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereFirstRebateMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereFirstRebateReceiver($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereGoodsRebateMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereGoodsRebateReceiver($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereSecondRebateMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereSecondRebateReceiver($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $coin_rebate 松鼠币返利
 * @property-read \App\Models\AfterSale $afterSale
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereCoinRebate($value)
 * @property int $goods_money 商品金额(以分为单位)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereGoodsMoney($value)
 * @property int $goods_rebate_rate 商品返利率
 * @property int $coin_rebate_rate 松鼠币返利率
 * @property int $first_rebate_rate 一级返利率
 * @property int $second_rebate_rate 二级返利率
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereCoinRebateRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereFirstRebateRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereGoodsRebateRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BackGoodsRebate whereSecondRebateRate($value)
 */
class BackGoodsRebate extends Model
{
    use BaseModelTrait;

    protected $table = 'back_goods_rebate';

    protected $guarded = ['id'];

    public function afterSale() {
        return $this->belongsTo(AfterSale::class, 'after_sale_id', 'id');
    }

    /**
     * 计算返利(以分为单位)
     *
     * @param $goodsMargin
     * @param $firstRebate
     * @return float
     */
    function getGoodsRebate($goodsMargin, $firstRebate) {
        $money = ($firstRebate * $goodsMargin) / 100;
        return $money;
    }

    /**
     * 计算松鼠币返利
     *
     * @param $sellingPrice
     * @param $coinRebate
     * @return float
     */
    function getCoinRebate($sellingPrice, $coinRebate) {
        $money = round(($coinRebate * $sellingPrice) / 10000);
        return $money;
    }

    /**
     * 计算一级粉丝返利(以分为单位)
     *
     * @param $goodsMargin
     * @param $secondRate
     * @return float
     */
    function getFirstRebate($goodsMargin, $secondRate) {
        $money = ($secondRate * $goodsMargin) / 100;
        return $money;
    }

    /**
     * 计算二级粉丝返利(以分为单位)
     *
     * @param $goodsMargin
     * @param $thirdRate
     * @return float
     */
    function getSecondRebate($goodsMargin, $thirdRate) {
        $money = ($thirdRate * $goodsMargin) / 100;
        return $money;
    }
}
