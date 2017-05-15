<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/17
 * Time: 17:09
 */
namespace app\Http\Controllers\CommunityApi;

use App\Helper\CommonHelper;
use App\Helper\ResponseJson;
use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\Goods;
use App\Models\GoodsSku;
use App\Models\Special;
use App\Models\User;
use Illuminate\Http\Request;
class IndexController extends Controller{

    /**
     * 搜索
     * @param Request $request
     */
    public function search(Request $request){
        $search = trim($request->input('search'));
        if (empty($search)) return ResponseJson::getInstance()->errorJson('参数错误');
        $lists = [];
        # 搜索商品
        $goods = Goods::where('goods_name', 'like', "%$search%")->select(['id', 'goods_name', 'goods_description'])->orderBy('sort_order', 'desc')->whereIsOnline(1)->get()->toArray();
        foreach ($goods as $key => $value) {
            $defaultSku = GoodsSku::whereGoodsId($value['id'])->whereIsDefault(1)->first();
            $goods[$key]['thumb'] = Goods::getInstance()->getGoodsSkuThumb($defaultSku->id);
            $goods[$key]['market_price'] = CommonHelper::getInstance()->formatPriceToShow($defaultSku->market_price);
            $goods[$key]['selling_price'] = CommonHelper::getInstance()->formatPriceToShow($defaultSku->selling_price);
        }
        $lists['goods'] = $goods;
        # 搜索用户
        $users = User::where('name', 'like', "%$search%")->select(['id', 'name', 'avatar', 'signature'])->get()->toArray();
        $lists['users'] = $users;
        # 搜索内容
        $special = Special::where('title', 'like', "%$search%")->orWhere('subtitle', 'like', "%$search%")->select(['id', 'title', 'description'])->get()->toArray();
        $lists['special'] = $special;

        # 搜索圈子
        $circle = Circle::where('title', 'like', "%$search%")->select(['id', 'title', 'type', 'links'])->get()->toArray();
        $lists['circle'] = $circle;

        return ResponseJson::getInstance()->doneJson('搜索成功', $lists);
    }
}