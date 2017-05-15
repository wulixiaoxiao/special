<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/24
 * Time: 11:37
 */

namespace App\Http\Controllers\CommunityApi;

use App\Helper\CommonHelper;
use App\Helper\ResponseJson;
use App\Http\Controllers\Controller;
use App\Library\AliOss;
use App\Models\Circle;
use App\Models\CircleCategory;
use App\Models\CircleComments;
use App\Models\CircleLikes;
use App\Models\Goods;
use App\Models\GoodsCollection;
use App\Models\GoodsComment;
use App\Models\GoodsSku;
use App\Models\Special;
use App\Models\SpecialComments;
use App\Models\SpecialContent;
use App\Models\SpecialLikes;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Exception;

class SpecialController extends Controller
{

    /**
     * 专题列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function specialList(){
        $lists = Special::orderBy('sort_order', 'desc')->get();

        foreach ($lists as $k => $v) {
            $specialContents = SpecialContent::whereSpecialId($v->id)->get();
            foreach ($specialContents as $key=>$val){
                $specialContents[$key]['filePath'] = AliOss::ossClient()->signUrl(env('bucketName'), $val['filePath'], 3600);
            }
            $lists[$k]->category_name = $v->category->category_name;
            $lists[$k]['special_contents'] = $specialContents;
            unset($lists[$k]->category);
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $lists);
    }

    public function specialDetial(Request $request) {
        $id = $request->input('id');
        if (!$id) return ResponseJson::getInstance()->errorJson('缺少参数');
        $special = Special::with('content', 'likes', 'comments')->find($id)->toArray();
        foreach ($special['content'] as $k => $v) {
            $special['content'][$k]['filePath'] = AliOss::ossClient()->signUrl(env('bucketName'), $v['filePath'], 3600);

        }
        $goods = [];
        if ($special['goodids']) {
            // 获取相关商品
            $goods = Goods::whereIn('id', explode(',', $special['goodids']))->select(['id', 'goods_name', 'goods_description'])->orderBy('sort_order', 'desc')->whereIsOnline(1)->get()->toArray();
            foreach ($goods as $key => $value) {
                $defaultSku = GoodsSku::whereGoodsId($value['id'])->whereIsDefault(1)->first();
                $goods[$key]['thumb'] = url(Goods::getInstance()->getGoodsSkuThumb($defaultSku->id));
                $goods[$key]['market_price'] = CommonHelper::getInstance()->formatPriceToShow($defaultSku->market_price);
                $goods[$key]['selling_price'] = CommonHelper::getInstance()->formatPriceToShow($defaultSku->selling_price);
            }
        }
        $special['goods'] = $goods;
        return ResponseJson::getInstance()->doneJson('获取成功', $special);
    }

    /**
     * 专题点赞
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function specialLikes(Request $request) {
        $me = $request->user();
        $id = $request->input('id');
        $special = Special::whereId($id)->first();
        if(!$special || !$id) return ResponseJson::getInstance()->errorJson('缺少参数');

        \DB::beginTransaction();
        try{
            $is_exists = SpecialLikes::whereSpecialId($id)->whereMemberId($me->id)->first();
            if(!$is_exists){
                SpecialLikes::create([
                    'member_id' => $me->id,
                    'special_id' => $id,
                ]);
                $special->increment('likes', 1);
                $msg = '点赞成功';
                $data = ['type' => 1];
            }else{
                SpecialLikes::whereSpecialId($id)->whereMemberId($me->id)->delete();
                $special->decrement('likes', 1);
                $msg = '取消点赞成功';
                $data = ['type' => 0];
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson($msg, $data);
        }catch (Exception $e){
            \DB::rollBack();
            return ResponseJson::getInstance()->doneJson('失败');
        }

    }

    /**
     * 主题评论与回复
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function specialComments(Request $request){
        $me = $request->user();
        $id = $request->input('id');
        $comment = $request->input('comment', '');
        $reply_id = $request->input('reply_id');
        $type = $request->input('type');
        if(!Special::whereId($id)->exists() || empty($comment) || empty($id)) return ResponseJson::getInstance()->errorJson('缺少参数');

        $data['member_id'] = $me->id;
        if($type == 1) {
            $data['reply_id'] = 0;
        }else{
            $data['reply_id'] = $reply_id;
        }
        $data['special_id'] = $id;
        $data['comment'] = $comment;
        $is_success = SpecialComments::create($data);
        if($is_success){
            Special::whereId($id)->increment('comments', 1);
            return ResponseJson::getInstance()->doneJson('成功');
        }else{
            return ResponseJson::getInstance()->errorJson('失败');
        }
    }





}