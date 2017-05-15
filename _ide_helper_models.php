<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Ad
 *
 * @property int $id
 * @property int $ad_position_id 广告位置ID
 * @property string $ad_name 广告名称
 * @property string $title 标题
 * @property string $pic 广告图片路径
 * @property string $link 广告链接
 * @property int $sort_order 排序
 * @property bool $is_show 是否显示
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereAdName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereAdPositionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereIsShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad wherePic($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Ad whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\AdPosition $adPosition
 * @property-read mixed $pic_path
 * @property-read mixed $position_name
 */
	class Ad extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $admin_name 管理员账号
 * @property string $password 管理员密码
 * @property int $create_time 注册时间
 * @property int $last_time 最后登录时间
 * @property string $permissions 权限组
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereAdminName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereLastTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin wherePermissions($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $remember_token 记住我
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereRememberToken($value)
 * @property string $admin_nickname 管理员昵称
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin whereAdminNickname($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdminLog[] $adminLog
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdminLog
 *
 * @property int $id
 * @property int $admin_id 管理员ID
 * @property string $description 日志描述
 * @property string $sql 执行的sql语句
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereSql($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdminLog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Admin $admin
 * @property-read mixed $admin_name
 */
	class AdminLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdPosition
 *
 * @property int $id
 * @property string $position_name 广告位置名称
 * @property string $description 广告位置描述
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdPosition whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdPosition whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdPosition wherePositionName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdPosition whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ad[] $ad
 */
	class AdPosition extends \Eloquent {}
}

namespace App\Models{
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
	class AfterSale extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AfterSaleLog
 *
 * @property int $id
 * @property int $admin_id 管理员ID
 * @property int $after_sale_id 售后ID
 * @property int $service_number 服务单号
 * @property bool $status 审核状态
 * @property string $status_note 审核留言
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereAfterSaleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereServiceNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereStatusNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AfterSaleLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AfterSaleLog extends \Eloquent {}
}

namespace App\Models{
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
	class BackGoodsRebate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cart
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property int $goods_id 商品ID
 * @property int $goods_number 购买商品数量
 * @property int $sku_id 规格ID
 * @property int $create_time 添加时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\Goods $goods
 * @property-read \App\Models\GoodsSku $goodsSku
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereGoodsNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereSkuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Circle
 *
 * @property int $id
 * @property int $member_id 作者id
 * @property string $author 作者昵称
 * @property bool $type 动态类型,1文字,2文字加图片,3文字加视频
 * @property string $title 标题
 * @property string $content 内容，图片链接或视频链接
 * @property int $likes 点赞数
 * @property int $comments 评论数
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereComments($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereLikes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Circle whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Circle extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CircleLikes
 *
 * @property int $id
 * @property int $member_id 点赞人id
 * @property int $circle_id 动态id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereCircleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $reply_id 回复id
 * @property string $comment 评论内容
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleComments whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleComments whereReplyId($value)
 */
	class CircleComments extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CircleLikes
 *
 * @property int $id
 * @property int $member_id 点赞人id
 * @property int $circle_id 动态id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereCircleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CircleLikes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class CircleLikes extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Express
 *
 * @property int $id
 * @property string $express_name 快递公司名称
 * @property string $express_code 快递公司编码
 * @property int $is_open 是否开启
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereExpressName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereExpressCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereIsOpen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Express whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Express extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Goods extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GoodsCategory
 *
 * @property int $id
 * @property string $goods_category_name 商品分类名称
 * @property int $sort_order 排序
 * @property bool $is_show 是否显示
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereGoodsCategoryName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereIsShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goods[] $goods
 * @property string $category_img 商品分类图片
 * @property string $category_icon 分类图标
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereCategoryIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCategory whereCategoryImg($value)
 */
	class GoodsCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GoodsCollection
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property int $goods_id 商品ID
 * @property int $create_time 添加时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\Goods $goods
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsCollection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class GoodsCollection extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GoodsComment
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property int $order_id 订单ID
 * @property int $goods_id 商品ID
 * @property string $content 评论内容
 * @property bool $is_show 是否显示(1:显示,0:隐藏,默认显示)
 * @property int $create_time 添加时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Goods $goods
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereIsShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Member $member
 * @property int $order_goods_id 订单商品ID
 * @property-read mixed $goods_name
 * @property-read mixed $member_name
 * @property-read mixed $order_sn
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsComment whereOrderGoodsId($value)
 * @property-read \App\Models\OrderGoods $orderGoods
 */
	class GoodsComment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GoodsImages
 *
 * @property int $id
 * @property int $goods_sku_id 商品规格ID
 * @property bool $type 图片类型(1:缩略图,2:商品图片)
 * @property string $img_url 图片路径
 * @property int $sort_order 排序
 * @property int $create_time 添加时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Goods $sku
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereGoodsSkuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereImgUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereSortOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsImages whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Goods $goodsSku
 */
	class GoodsImages extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GoodsSku
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property string $sku_ids 规格ID值组合
 * @property string $sku_values 规格属性值组合
 * @property int $market_price 市场价格,以分为单位
 * @property int $selling_price 实际价格,以分为单位
 * @property int $stock 库存数
 * @property bool $is_default 是否默认规格(1:是,0否)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goods[] $goodsImages
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereSkuIds($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereSkuValues($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereMarketPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereSellingPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereStock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereIsDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $sku_value_ids 规格属性值组合
 * @property-read \App\Models\Goods $goods
 * @property-read mixed $goods_name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSku whereSkuValueIds($value)
 * @property-read mixed $sku_ids_string
 * @property-read mixed $sku_value_ids_string
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $cart
 */
	class GoodsSku extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GoodsSkuSet
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property int $sku_id SKU id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Goods $goods
 * @property-read mixed $sku_name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSkuSet whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSkuSet whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSkuSet whereSkuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSkuSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSkuSet whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Sku $sku
 */
	class GoodsSkuSet extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MemberAddress
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property string $name 姓名
 * @property string $phone_number 手机号码
 * @property int $province 省份
 * @property int $city 城市
 * @property int $area 区域
 * @property string $detail_address 详细地址
 * @property bool $is_default 是否是默认(1:是,0:否,默认否)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Member $member
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress wherePhoneNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereDetailAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereIsDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class MemberAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MobileCode
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $mobile 手机号码
 * @property int $code 验证码
 * @property string $type 验证码类型，详见model
 * @property bool $status 是否已使用
 * @property int $num 发送次数
 * @property int $time 发送时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MobileCode whereUpdatedAt($value)
 */
	class MobileCode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $member_id 会员ID
 * @property string $order_sn 订单编号
 * @property int $order_price 订单总金额,以分为单位
 * @property int $goods_price 商品总金额,以分为单位
 * @property int $freight_price 运费金额,以分为单位
 * @property int $goods_number 订单产品总数量
 * @property int $goods_weight 订单产品总重量
 * @property int $pay_price 订单支付金额,以分为单位
 * @property bool $pay_type 支付类型(1:余额,2:微信,3:支付宝)
 * @property string $pay_number 支付流水号
 * @property int $pay_time 支付时间
 * @property bool $is_pay 是否支付(1:是,0:否)
 * @property string $order_note 订单备注
 * @property int $status 订单状态(0:交易取消,1:未付款,2:已付款,3:已发货,4:退货中,5:交易完成,6:交易关闭,7:退货完成,8:满7天,9:未审核,10:订单关闭)
 * @property int $member_address_id 收货地址ID
 * @property int $express_id 快递公司ID
 * @property string $tracking_number 快递单号
 * @property bool $is_rebate 是否返利(1:是,0:否)
 * @property int $create_time 订单生成时间
 * @property int $deliver_time 订单发货时间
 * @property int $receiving_time 订单收货时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GoodsComment[] $goodsComment
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOrderSn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOrderPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereGoodsPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereFreightPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereGoodsNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereGoodsWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePayPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePayType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePayNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePayTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereIsPay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOrderNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereMemberAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereExpressId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereTrackingNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereIsRebate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereDeliverTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceivingTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Member $member
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderLog[] $orderLog
 * @property string $receiver_name 收货人姓名
 * @property string $receiver_phone_number 收货人手机号码
 * @property string $receiver_province 收货人身份
 * @property string $receiver_city 收货人城市
 * @property string $receiver_area 收货人区域
 * @property string $receiver_detail 收货人详细地址
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderGoods[] $orderGoods
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverArea($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverPhoneNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereReceiverProvince($value)
 * @property-read mixed $status_text
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FansRebate[] $fansRebate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderRebate[] $orderRebate
 * @property bool $is_back_goods 是否退货中(1:是,0:否)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereIsBackGoods($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderGoods
 *
 * @property int $id
 * @property int $order_id 订单ID
 * @property int $goods_id 商品ID
 * @property int $goods_price 商品单价(单位:分)
 * @property int $goods_number 商品数量
 * @property int $goods_weight 商品重量(单位:克)
 * @property int $sku_id 规格ID
 * @property string $sku_str 规格属性值组合
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereGoodsPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereGoodsNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereGoodsWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereSkuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereSkuStr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\OrderRebate $orderRebate
 * @property-read mixed $goods_name
 * @property-read \App\Models\Goods $goods
 * @property-read \App\Models\Order $order
 * @property bool $is_free_shipping 是否免邮
 * @property int $goods_margin 商品毛利
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereGoodsMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereIsFreeShipping($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FansRebate[] $fansRebate
 * @property-read \App\Models\GoodsComment $goodsComment
 * @property int $back_goods_number 退货数量
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGoods whereBackGoodsNumber($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AfterSale[] $afterSale
 */
	class OrderGoods extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderLog
 *
 * @property int $id
 * @property int $admin_id 管理员ID
 * @property int $order_id 订单ID
 * @property string $description 描述
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderLog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Order $order
 * @property-read mixed $admin_name
 */
	class OrderLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Sku
 *
 * @property int $id
 * @property string $sku_name 规格名称
 * @property string $sku_values 规格值组(英文逗号分隔)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goods[] $goodsImages
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereSkuName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereSkuValues($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Sku whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SkuValue[] $skuValue
 * @property-read \App\Models\GoodsSkuSet $goodsSkuSet
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Goods[] $goods
 * @property-read mixed $sku_value_names
 */
	class Sku extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SkuValue
 *
 * @property int $id
 * @property int $sku_id SKU id
 * @property string $sku_value_name SKU可选项名称
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Sku $sku
 * @property-read mixed $sku_name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SkuValue whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SkuValue whereSkuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SkuValue whereSkuValueName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SkuValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SkuValue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SkuValue extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transactions
 *
 * @property int $id
 * @property string $type 类型，确定target_id是哪个表的数据
 * @property int $target_id 目标id,根据type确定
 * @property int $member_id 会员ID
 * @property int $money 金额(以分为单位)
 * @property int $balance 用户余额(以分为单位)
 * @property string $description 描述
 * @property int $create_time 生成时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereTargetId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Transactions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Transactions extends \Eloquent {}
}

namespace App\Models{
/**
 * App\User
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 用户名
 * @property string $phone 手机号
 * @property string $password 密码
 * @property string $api_token api令牌
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereApiToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @property string $avatar 头像
 * @property string $balance 余额
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereBalance($value)
 * @property int $money 账户余额(单位:分)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $cart
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GoodsCollection[] $goodsCollection
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GoodsComment[] $goodsComment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MemberAddress[] $memberAddress
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $order
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereMoney($value)
 */
	class User extends \Eloquent {}
}

