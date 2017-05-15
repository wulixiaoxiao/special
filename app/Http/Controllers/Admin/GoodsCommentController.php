<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Models\AdminLog;
use App\Models\Goods;
use App\Models\GoodsComment;
use App\Models\Member;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\ResponseJson;

class GoodsCommentController extends Controller
{
    /**
     * 商品评价列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $search = $request->input('search');
        $query = GoodsComment::orderBy('id', 'desc');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $memberIds = User::where('name', 'like', '%'.$search.'%')->pluck('id');
                $orderIds = Order::where('order_sn', 'like', '%'.$search.'%')->pluck('id');
                $goodsIds = Goods::where('goods_name', 'like', '%'.$search.'%')->pluck('id');
                $q->whereIn('member_id', $memberIds)
                    ->orWhereIn('order_id', $orderIds)
                    ->orWhereIn('goods_id', $goodsIds)
                    ->orWhere('content', 'like', '%'.$search.'%');
            });
        }
        $goodsComments = $query->paginate(10);
        return view('admin.goods_comment.index', [
            'search' => $search,
            'goodsComments' => $goodsComments,
        ]);
    }

    /**
     * 商品评价编辑
     *
     * @param Request $request
     * @param GoodsComment $goodsComment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request, GoodsComment $goodsComment) {
        if ($request->isMethod('post')) {
            $isShow = intval($request->input('is_show'));
            if (!in_array($isShow, [0, 1])) {
                return ResponseJson::getInstance()->errorJson('非法操作');
            }
            \DB::beginTransaction();
            try {
                $goodsComment->is_show = $isShow;
                $goodsComment->save();
                AdminLog::getInstance()->addLog('商品评价编辑:'.$goodsComment->id);
                \DB::commit();
                return ResponseJson::getInstance()->doneJson('编辑成功');
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new ApiException($e);
            }
        }
        return view('admin.goods_comment.edit', [
            'goodsComment' => $goodsComment,
        ]);
    }
}
