<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/24
 * Time: 11:37
 */

namespace App\Http\Controllers\CommunityApi;

use App\Helper\ResponseJson;
use App\Http\Controllers\Controller;
use App\Library\AliOss;
use App\Models\Attention;
use App\Models\Circle;
use App\Models\CircleAttention;
use App\Models\CircleCategory;
use App\Models\CircleComments;
use App\Models\CircleLikes;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Exception;
use OSS\OssClient;

class CircleController extends Controller
{
    /**
     * 获取圈子
     * TODO 图片压缩
     */
    public function circle_list(Request $request){
        $me = $request->user();
        $attention = CircleAttention::whereMemberId($me->id)->pluck('circle_category_id')->toArray();
        $ids = Attention::whereMemberId($me->id)->pluck('attention_id')->toArray();
        $list = Circle::with('user', 'circleLikes', 'circleComments');
        if ($ids) $list = $list->whereIn('member_id', $ids);
        if ($attention) $list = $list->whereIn('category_id', $attention);
        $list = $list->orderBy('id', 'desc')->get();


        if (count($list) <= 0) $list = Circle::with('user', 'circleLikes', 'circleComments')->orderBy('id', 'desc')->get();

        $attentionData = CircleAttention::whereMemberId($me->id)->get();
        $myAttentions = [];
        if ($attentionData->isEmpty()) {
            $attentionData = CircleCategory::get();
            foreach ($attentionData as $k => $v){
                $myAttentions[$k]['category_name'] = $v->category_name;
                $myAttentions[$k]['sort_order'] = $v->sort_order;
                $myAttentions[$k]['img_url'] = $v->img_url;
                $myAttentions[$k]['is_show'] = $v->is_show;
            }
        }else{
            foreach ($attentionData as $k => $v){
                $myAttentions[$k]['category_name'] = $v->category->category_name;
                $myAttentions[$k]['sort_order'] = $v->category->sort_order;
                $myAttentions[$k]['img_url'] = $v->category->img_url;
                $myAttentions[$k]['is_show'] = $v->category->is_show;
            }
        }

        $results = [];
        foreach ($list as $key => $value){
            $circle = $value->toArray();
            unset($circle['circle_likes']);
            unset($circle['circle_comments']);
            $circle['username'] = $circle['user']['name'];
            $circle['avatar'] = $circle['user']['avatar'];
            unset($circle['user']);
            $results[$key] = $circle;
            $comments = $value->circleComments->toArray();
            $likes = $value->circleLikes->toArray();
            foreach ($comments as $k => $v){
                $userinfo = User::whereId($v['member_id'])->select('avatar', 'name')->first()->toArray();
                $comments[$k]['avatar'] = $userinfo['avatar'];
                $comments[$k]['username'] = $userinfo['name'];
            }
            $results[$key]['comments'] = $comments;
            foreach ($likes as $k => $v){
                $userinfo = User::whereId($v['member_id'])->select('avatar', 'name')->first()->toArray();
                $likes[$k]['avatar'] = $userinfo['avatar'];
                $likes[$k]['username'] = $userinfo['name'];
            }
            $results[$key]['likes'] = $likes;
        }
        $results['myAttentions'] = $myAttentions;
        return ResponseJson::getInstance()->doneJson('获取成功', $results);
    }

    /**
     * 关注圈子
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function circle_attention(Request $request){
        $me = $request->user();
        $id = intval($request->input('id', 0));
        if (!$id) ResponseJson::getInstance()->errorJson('缺少参数');
        $circleCategory = CircleCategory::whereId($id)->first();
        if (!($circleCategory)) return ResponseJson::getInstance()->errorJson('圈子不存在');
        $attention = CircleAttention::whereMemberId($me->id)->whereCircleCategoryId($id)->first();
        if ($attention) return ResponseJson::getInstance()->errorJson('已关注');
        \DB::beginTransaction();
        try{
            $is_success = CircleAttention::create([
                'member_id' => $me->id,
                'circle_category_id' => $id,
            ]);
            $is_success = $circleCategory->increment('people_num', 1);
            if(!$is_success) {
                \DB::rollBack();
                return ResponseJson::getInstance()->doneJson('关注失败');
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('关注成功');
        }catch (Exception $e){
            \DB::rollBack();
            return ResponseJson::getInstance()->errorJson('关注失败');
        }
    }

    /**
     * 取消关注圈子
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function circle_attention_cancel(Request $request){
        $me = $request->user();
        $id = intval($request->input('id', 0));
        if (!$id) ResponseJson::getInstance()->errorJson('缺少参数');
        $attention = CircleAttention::whereMemberId($me->id)->whereCircleCategoryId($id)->first();
        if (!$attention) return ResponseJson::getInstance()->errorJson('未关注');
        $circleCategory = CircleCategory::whereId($id)->first();
        if (!($circleCategory)) return ResponseJson::getInstance()->errorJson('圈子不存在');
        \DB::beginTransaction();
        try{
            $is_success = $attention->delete();
            $is_success = $circleCategory->decrement('people_num', 1);
            if(!$is_success) {
                \DB::rollBack();
                return ResponseJson::getInstance()->doneJson('取消关注失败');
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('取消关注成功');
        }catch (Exception $e){
            \DB::rollBack();
            return ResponseJson::getInstance()->errorJson('取消关注失败');
        }
    }

    /**
     * 获取动态详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function circle_detial(Request $request) {
        $id = intval($request->input('id', 0));
        $circle = Circle::with('user', 'circleLikes')->whereId($id)->first()->toArray();
        if (!$circle) return ResponseJson::getInstance()->errorJson('动态不存在');
        $list['type'] = $circle['type'];
        $list['title'] = $circle['title'];
        $list['content'] = $circle['content'];
        $list['links'] = $circle['links'];
        $list['likes'] = $circle['likes'];
        $list['comments'] = $circle['comments'];
        $list['tag'] = $circle['tag'];
        $list['category_id'] = $circle['category_id'];
        $list['coordinate'] = $circle['coordinate'];
        $list['user']['name'] = $circle['user']['name'];
        $list['user']['avatar'] = $circle['user']['avatar'];
        $list['user']['signature'] = $circle['user']['signature'];
        $list['circle_likes'] = $circle['circle_likes'];
        return ResponseJson::getInstance()->doneJson('获取成功', $list);
    }

    /**
     * 获取圈子评论
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function circle_get_comment(Request $request){
        $id = intval($request->input('id', 0));
        if (!$id) return ResponseJson::getInstance()->errorJson('缺少参数');
        $circle = Circle::whereId($id)->first()->toArray();
        if (!$circle) return ResponseJson::getInstance()->errorJson('动态不存在');

        $comments = CircleComments::whereCircleId($id)->get();
        foreach ($comments as $k => $v) {
            unset($comments[$k]['created_at']);
            unset($comments[$k]['updated_at']);
            $list[$k] = $v->toArray();
            $list[$k]['user']['name'] = $v->user->name;
            $list[$k]['user']['avatar'] = $v->user->avatar;
            $list[$k]['user']['signature'] = $v->user->signature;
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $list);

    }

    /**
     * 发布动态
     * @param Request $request
     */
    public function circle_pub(Request $request){
        $me = $request->user();
        $type           = intval($request->input('type',1));
        $data['member_id'] = intval($me->id);
        $data['type'] = intval($type);
        $data['content'] = trim($request->input('content',''));
        $data['links'] = trim($request->input('links',''));
        $data['title'] = trim($request->input('title', ''));
        $data['category_id'] = $request->input('category_id', '');
        $data['tag'] = $request->input('tag', '');
        $data['coordinate'] = $request->input('coordinate', '');
        $data['length'] = $request->input('length', 0);
        Circle::create($data);
        return ResponseJson::getInstance()->doneJson('发布成功');
    }

    /**
     * 获取点赞列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cicle_likes_list(Request $request){
        $id = $request->input('id');
        $list = CircleLikes::whereCircleId($id)->with('user')->get()->toArray();
        foreach ($list as $k=>$v){
            $list[$k]['username'] = $v['user']['name'];
            $list[$k]['avatar'] = $v['user']['avatar'];
            unset($list[$k]['user']);
        }

        $list['total'] = Circle::whereId($id)->pluck('likes')->first();
        return ResponseJson::getInstance()->doneJson('获取成功', $list);
    }

    /**
     * 获取圈子分类
     * @return \Illuminate\Http\JsonResponse
     */
    public function circle_category(Request $request){
        $me = $request->user();
        $categorys = CircleCategory::whereIsShow(1)->orderBy('sort_order')->get()->toArray();
        foreach ($categorys as $k => $v) {
            $categorys[$k]['is_attention'] = 0;
            if (CircleAttention::whereMemberId($me->id)->whereCircleCategoryId($v['id'])->exists()) {
                $categorys[$k]['is_attention'] = 1;
            }
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $categorys);
    }

    /**
     * 动态删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function circle_del(Request $request){
        $me = $request->user();
        $id = intval($request->input('id', ''));
        if(!$id) return ResponseJson::getInstance()->errorJson('参数错误');
        $info = Circle::whereId($id)->whereMemberId($me->id)->first();
        if(!$info) return ResponseJson::getInstance()->errorJson('该动态不存在');
        $is_success = $info->delete();
        if ($is_success){
            CircleLikes::whereCircleId($id)->delete();
            CircleComments::whereCircleId($id)->delete();
            return ResponseJson::getInstance()->doneJson('删除成功');
        }
        return ResponseJson::getInstance()->errorJson('删除失败');
    }

    /**
     * 动态点赞与取消
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function circle_give_likes(Request $request){
        $me = $request->user();
        $id = $request->input('id');
        if(!$id) return ResponseJson::getInstance()->errorJson('参数错误');
        $circle_info = Circle::whereId($id)->first();
        if(!$circle_info) return ResponseJson::getInstance()->errorJson('动态不存在');
        if (CircleLikes::whereCircleId($id)->whereMemberId($me->id)->exists()) return ResponseJson::getInstance()->errorJson('已点赞');
        \DB::beginTransaction();
        try{
            CircleLikes::create([
                'member_id' => $me->id,
                'circle_id' => $id,
            ]);
            $is_success = $circle_info->increment('likes', 1);

            if(!$is_success) {
                \DB::rollBack();
                return ResponseJson::getInstance()->errorJson('点赞失败');
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('点赞成功');
        }catch (Exception $e){
            \DB::rollBack();
            return ResponseJson::getInstance()->errorJson('点赞失败');
        }

    }

    /**
     * 取消点赞
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function circle_cancel_likes(Request $request){
        $me = $request->user();
        $id = $request->input('id');
        if(!$id) return ResponseJson::getInstance()->errorJson('参数错误');
        $circle_info = Circle::whereId($id)->first();
        if(!$circle_info) return ResponseJson::getInstance()->errorJson('动态不存在');

        \DB::beginTransaction();
        try{
            CircleLikes::whereCircleId($id)->whereMemberId($me->id)->delete();
            $is_success = $circle_info->decrement('likes', 1);

            if(!$is_success) {
                \DB::rollBack();
                return ResponseJson::getInstance()->errorJson('取消点赞失败');
            }
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('取消点赞成功');
        }catch (Exception $e){
            \DB::rollBack();
            return ResponseJson::getInstance()->errorJson('取消点赞失败');
        }

    }

    /**
     * 评论
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function circle_comment(Request $request){
        $me = $request->user();
        $comment = $request->input('comment', '');
        $id = $request->input('id', '');

        $circle = Circle::whereId($id)->first();
        if (!$circle) return ResponseJson::getInstance()->errorJson('该内容已被删除');
        if (empty($comment) || empty($id)) return ResponseJson::getInstance()->errorJson('评论内容不能为空');

        $data['member_id'] = $me->id;
        $data['reply_id'] = 0;
        $data['circle_id'] = $id;
        $data['comment'] = $comment;
        $is_success = CircleComments::create($data);
        if($is_success){
            Circle::whereId($id)->increment('comments', 1);
            return ResponseJson::getInstance()->doneJson('成功');
        }else{
            return ResponseJson::getInstance()->errorJson('失败');
        }
    }

    public function circle_reply(Request $request){
        $me = $request->user();
        $comment = $request->input('comment', '');
        $id = $request->input('id', '');
        $reply_id = $request->input('reply_id', '');

        $circle = Circle::whereId($id)->first();
        if (!$circle) return ResponseJson::getInstance()->errorJson('该内容已被删除');
        $circleComment = CircleComments::whereId($reply_id)->first();
        if (!$circleComment) return ResponseJson::getInstance()->errorJson('该条评论已被删除');
        if (empty($comment) || empty($id)) return ResponseJson::getInstance()->errorJson('评论内容不能为空');

        $data['member_id'] = $me->id;

        $data['reply_id'] = $reply_id;

        $data['circle_id'] = $id;
        $data['comment'] = $comment;
        $is_success = CircleComments::create($data);
        if($is_success){
            Circle::whereId($id)->increment('comments', 1);
            return ResponseJson::getInstance()->doneJson('成功');
        }else{
            return ResponseJson::getInstance()->errorJson('失败');
        }
    }

    /**
     * 上传文件
     * @param Request $request
     * @return array
     */
    public function uploadFile(Request $request){
        $type = $request->input('type');
        $files = $request->file('filename');
        switch ($type){
            case 1;                 //图片
                $imgList = [];
                foreach ($files as $file){
                    if (!$file->isValid()) {
                        return ResponseJson::getInstance()->errorJson('图片不正确');
                    }
                    $extension = $file->getClientOriginalExtension();
                    $oldName = mt_rand(0, mt_rand());
                    $fileName = $_ENV['imgPath']. 'images/' . $oldName . '' . time() . '.' . $extension;
                    AliOss::ossClient()->putObject(env('bucketName'), $fileName, file_get_contents($file->getPathname()));
                    $imgList[] = $fileName;
                }
                return ResponseJson::getInstance()->doneJson('上传成功', implode(',', $imgList));
                break;
            case 2:
                if (!$files->isValid()) {
                    return ResponseJson::getInstance()->errorJson('图片不正确');
                }
                $extension = $files->getClientOriginalExtension();
                $oldName = mt_rand(0, mt_rand());
                $fileName = $_ENV['imgPath']. 'video/'. $oldName . '' . time() . '.' . $extension;
                AliOss::ossClient()->putObject(env('bucketName'), $fileName, file_get_contents($files->getPathname()));
                return ResponseJson::getInstance()->doneJson('上传成功', $fileName);
                break;
        }
    }

}