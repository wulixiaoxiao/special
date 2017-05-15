<?php

namespace App\Models;

use App\Exceptions\ApiException;
use App\Helper\CommonHelper;
use App\Models\MemberAddress;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name 用户名
 * @property string $avatar 头像
 * @property string $phone 手机号
 * @property string $balance 余额
 * @property string $password 密码
 * @property string $api_token api令牌
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $money 账户余额(单位:分)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cart[] $cart
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CircleComments[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GoodsCollection[] $goodsCollection
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GoodsComment[] $goodsComment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CircleLikes[] $likes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MemberAddress[] $memberAddress
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $order
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereApiToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Circle[] $circle
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attention[] $attention
 * @property string $signature 个性签名
 * @property string $cover_img 个人主页封面图
 * @property string $address 居住地
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $followers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $followings
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCoverImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSignature($value)
 */
class User extends Model
{
    use BaseModelTrait;

    protected $table = 'users';

    protected $guarded = ['id'];

    // 用户粉丝列表
    public function followers(){
        return $this->belongsToMany(User::class, 'attention', 'attention_id', 'member_id');
    }
    // 用户关注列表
    public function followings(){
        return $this->belongsToMany(User::class, 'attention', 'member_id', 'attention_id');
    }

    public function circle(){
        return $this->hasMany(Circle::class, 'member_id', 'id');
    }

    public function comments(){
        return $this->hasMany(CircleComments::class, 'member_id', 'id');
    }

    public function likes(){
        return $this->hasMany(CircleLikes::class, 'member_id', 'id');
    }

    public function goodsComment() {
        return $this->hasMany(GoodsComment::class, 'member_id', 'id');
    }

    public function cart() {
        return $this->hasMany(Cart::class, 'member_id', 'id');
    }

    public function goodsCollection() {
        return $this->hasMany(GoodsCollection::class, 'member_id', 'id');
    }

    public function order() {
        return $this->hasMany(Order::class, 'member_id', 'id');
    }

    public function memberAddress() {
        return $this->hasMany(MemberAddress::class, 'member_id', 'id');
    }

    public function getAvatarAttribute($value) {
        return CommonHelper::getInstance()->getOssPath($value);
    }

//    public function orderRebate() {
//        return $this->hasMany(OrderRebate::class, 'member_id', 'id');
//    }
//
//    public function fansRebateFrom() {
//        return $this->hasMany(FansRebate::class, 'order_member_id', 'id');
//    }
//
//    public function fansRebateFor() {
//        return $this->hasMany(FansRebate::class, 'member_id', 'id');
//    }
//
//    public function coinRebate() {
//        return $this->hasMany(CoinRebate::class, 'member_id', 'id');
//    }

    /**
     * 增加金额
     *
     * @param $member_id
     * @param $money
     * @param $target_id
     * @param $type
     * @param $description
     * @return bool
     */
    public function addMoney($member_id, $money, $target_id, $type, $description) {
        $member = User::whereId($member_id)->first();
        if (!$member) {
            return false;
        }
        $member->balance += $money;
        if (!$member->save()) {
            throw new ApiException('增加金额失败');
        }
        Transactions::create([
            'type' => $type,
            'target_id' => $target_id,
            'member_id' => $member_id,
            'money' => $money,
            'balance' => $member->balance,
            'description' => $description,
            'create_time' => time(),
        ]);
        return true;
    }

    /**
     * 减少金额
     *
     * @param $member_id
     * @param $money
     * @param $target_id
     * @param $type
     * @param $description
     * @return bool
     */
    public function subtractMoney($member_id, $money, $target_id, $type, $description) {
        $member = User::whereId($member_id)->first();
        if (!$member) {
            return false;
        }
        if ($member->balance < $money) {
            throw new ApiException('余额不足');
        }
        $member->balance -= $money;
        if (!$member->save()) {
            throw new ApiException('减少金额失败');
        }
        Transactions::create([
            'type' => $type,
            'target_id' => $target_id,
            'member_id' => $member_id,
            'money' => $money,
            'balance' => $member->balance,
            'description' => $description,
            'create_time' => time(),
        ]);
        return true;
    }


}
