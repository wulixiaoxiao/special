<?php

namespace App\Models;

use App\Helper\CommonHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AfterSale
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property int $order_id 订单ID
 * @property int $order_goods_id 订单商品ID
 * @property int $goods_number 商品数量
 * @property bool $type 售后类型(1:退货,2:返修)
 * @property string $service_number 服务单号
 * @property string $question 问题描述
 * @property string $pic 图片
 * @property int $apply_time 提交申请时间
 * @property bool $status 状态(1:等待审核,2:审核通过，请寄送快递,3:审核不通过,4:已收到寄件，检测中,5:退换货成功,6:退换货失败)
 * @property string $status_note 审核留言
 * @property int $admin_id 管理员ID
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereApplyTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereGoodsNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereOrderGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale wherePic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereServiceNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereStatusNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSale whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\BackGoodsRebate $backGoodsRebate
 * @property-read mixed $goods_name
 * @property-read mixed $member_name
 * @property-read mixed $order_sn
 * @property-read mixed $status_text
 * @property-read mixed $type_text
 * @property-read mixed $admin_name
 * @property-read \App\Models\OrderGoods $orderGoods
 */
class AfterSale extends Model
{
    use BaseModelTrait;

    protected $table = 'after_sale';

    protected $guarded = ['id'];

    protected $appends = ['member_name', 'order_sn', 'goods_name', 'type_text', 'status_text', 'admin_name'];

    public function backGoodsRebate() {
        return $this->hasOne(BackGoodsRebate::class, 'after_sale_id', 'id');
    }

    public function orderGoods() {
        return $this->belongsTo(OrderGoods::class, 'order_goods_id', 'id');
    }

    public function getMemberNameAttribute() {
        return User::whereId($this->member_id)->value('name');
    }

    public function getOrderSnAttribute() {
        return Order::whereId($this->order_id)->value('order_sn');
    }

    public function getPicAttribute($value) {
        $value = json_decode($value);
        foreach ($value as &$v){
            $v = CommonHelper::getInstance()->getOssPath($v);
        }
        return $value;
    }

    public function getGoodsNameAttribute() {
        $orderGoods = OrderGoods::whereId($this->order_goods_id)->first();
        return ($orderGoods ? $orderGoods->goods_name : '');
    }

    public function getTypeTextAttribute() {
        if ($this->type == 1) {
            return '申请退货';
        } elseif ($this->type == 2) {
            return '申请返修';
        }
    }

    public function getStatusTextAttribute() {
        if ($this->status == 1) {
            return '等待审核';
        } elseif ($this->status == 2) {
            return '审核通过，请寄送快递';
        } elseif ($this->status == 3) {
            return '审核不通过';
        } elseif ($this->status == 4) {
            return '已收到寄件，检测中';
        } elseif ($this->status == 5) {
            return '退换货成功';
        } elseif ($this->status == 6) {
            return '退换货失败';
        }
    }

    public function getAdminNameAttribute() {
        if ($this->admin_id > 0) {
            return Admin::whereId($this->admin_id)->value('admin_name');
        }
        return '';
    }

    /**
     * 获取唯一服务工号
     *
     * @return string
     */
    public function getServiceNumber()
    {
        do{
            $orderSn = (string) date('ymd').substr(time(), 5).mt_rand(1000,9999);
        }while(AfterSale::whereServiceNumber($orderSn)->value('id'));
        return $orderSn;
    }
}
