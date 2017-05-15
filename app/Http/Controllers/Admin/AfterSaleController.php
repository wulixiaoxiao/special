<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Models\AdminLog;
use App\Models\AfterSale;
use App\Models\AfterSaleLog;
use App\Models\BackGoodsRebate;
use App\Models\FansRebate;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\OrderRebate;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\CommonHelper;
use App\Helper\ResponseJson;
use Illuminate\Support\Facades\DB;

class AfterSaleController extends Controller
{
    /**
     * 退货列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backGoodsList(Request $request) {
        $search = $request->input('search');
        $status = intval($request->input('status'));
        $query = AfterSale::whereType(1)->orderBy('id','desc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $orderIds = Order::where('order_sn', 'like', '%'.$search.'%')->pluck('id');
                $memberIds = User::where('name', 'like', '%'.$search.'%')->pluck('id');
                $q->where('service_number', 'like', '%'.$search.'%')->orWhereIn('order_id', $orderIds)->orWhereIn('member_id', $memberIds);
            });
        }

        if ($status > 0) {
            $query->whereStatus($status);
        }
        $afterSales = $query->paginate(10);
        return view('admin.after_sale.back_goods_list', [
            'afterSales' => $afterSales,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * 退货编辑
     *
     * @param Request $request
     * @param AfterSale $backGoods
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function backGoodsEdit(Request $request, AfterSale $backGoods) {
        if ($request->isMethod('post')) {
            $status = intval($request->input('status'));
            $statusNote = $request->input('status_note');
            if ($status > 0) {
                if (!in_array($backGoods->status, [1, 2, 4]) || !in_array($status, [2, 3, 4, 5, 6])) {
                    return ResponseJson::getInstance()->errorJson('非法操作');
                }
                if ($backGoods->status == 1 && !in_array($status, [2, 3])) {
                    return ResponseJson::getInstance()->errorJson('非法操作');
                }
                if ($backGoods->status == 2 && $status != 4) {
                    return ResponseJson::getInstance()->errorJson('非法操作');
                }
                if ($backGoods->status == 4 && !in_array($status, [5, 6])) {
                    return ResponseJson::getInstance()->errorJson('非法操作');
                }
                if (empty($statusNote)) {
                    return ResponseJson::getInstance()->errorJson('审核留言不能为空');
                }
                if (strlen($statusNote) > 200) {
                    return ResponseJson::getInstance()->errorJson('审核留言字数仅限200');
                }

                \DB::beginTransaction();
                try {
                    $backGoods->status = $status;
                    $backGoods->status_note = $statusNote;
                    $backGoods->admin_id = \Auth::guard('admin')->user()->id;
                    $backGoods->save();

                    # 记录操作日志
                    AfterSaleLog::create([
                        'admin_id' => \Auth::guard('admin')->user()->id,
                        'after_sale_id' => $backGoods->id,
                        'service_number' => $backGoods->service_number,
                        'status' => $backGoods->status,
                        'status_note' => $backGoods->status_note,
                    ]);

                    $orderGoods = OrderGoods::whereId($backGoods['order_goods_id'])->first();
                    if ($status == 5) {
                        # 退货成功
                        if ($backGoods['goods_number'] == $orderGoods['goods_number']) {
                            # 退还全部商品:删除退货返利;修改订单退货状态;返还退货商品金额
                            $totalGoodsMoney = $orderGoods->goods_price * $orderGoods->goods_number;

                            # 查询是否有其他退货记录,如果没有,则取消订单退货状态
                            $backGoodsCount = AfterSale::where('id', '!=', $backGoods['id'])
                                ->whereOrderId($backGoods['order_id'])
                                ->whereType(1)
                                ->whereNotIn('status', [3, 5, 6])
                                ->count();
                            if ($backGoodsCount == 0) {
                                Order::whereId($backGoods['order_id'])->update(['is_back_goods' => 0]);
                            }

                            # 退还商品金额
                            User::getInstance()->addMoney($orderGoods->order->member_id, $totalGoodsMoney, $backGoods->id, Transactions::TYPE_BACK_GOODS, '退货成功');
                        } elseif ($backGoods['goods_number'] < $orderGoods['goods_number']) {
                            # 退还部分商品:重新计算退货商品返利;修改订单退货状态;返还退货商品金额
                            $totalGoodsMoney = $orderGoods->goods_price * $backGoods->goods_number;

                            # 查询是否有其他退货记录,如果没有,则取消订单退货状态
                            $backGoodsCount = AfterSale::where('id', '!=', $backGoods['id'])
                                ->whereOrderId($backGoods['order_id'])
                                ->whereType(1)
                                ->whereNotIn('status', [3, 5, 6])
                                ->count();
                            if ($backGoodsCount == 0) {
                                Order::whereId($backGoods['order_id'])->update(['is_back_goods' => 0]);
                            }

                            # 退还商品金额
                            User::getInstance()->addMoney($orderGoods->order->member_id, $totalGoodsMoney, $backGoods->id, Transactions::TYPE_BACK_GOODS, '退货成功');
                        } else {
                            return ResponseJson::getInstance()->errorJson('退还商品数量不得大于订单商品数量');
                        }
                    } elseif ($status == 6 || $status == 3) {
                        # 减少退货数量
                        $orderGoods->back_goods_number -= $backGoods->goods_number;
                        $orderGoods->save();

                        # 退货失败,还原状态,查询是否有其他退货记录,如果没有,则取消订单退货状态
                        $backGoodsCount = AfterSale::where('id', '!=', $backGoods['id'])
                            ->whereOrderId($backGoods['order_id'])
                            ->whereType(1)
                            ->whereNotIn('status', [3, 5, 6])
                            ->count();
                        if ($backGoodsCount == 0) {
                            Order::whereId($backGoods['order_id'])->update(['is_back_goods' => 0]);
                        }
                    }
                    \DB::commit();
                    return ResponseJson::getInstance()->doneJson('操作成功');
                } catch (\Exception $e) {
                    \DB::rollBack();
                    throw new ApiException($e);
                }
            }
            return ResponseJson::getInstance()->doneJson('操作成功');
        }
        return view('admin.after_sale.back_goods_edit', [
            'backGoods' => $backGoods,
        ]);
    }

    /**
     * 返修列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function repairGoodsList(Request $request) {
        $search = $request->input('search');
        $status = intval($request->input('status'));
        $query = AfterSale::whereType(2);

        if ($search) {
            $query->where(function($q) use ($search) {
                $orderIds = Order::where('order_sn', 'like', '%'.$search.'%')->pluck('id');
                $memberIds = Member::where('wx_nickname', 'like', '%'.$search.'%')->pluck('id');
                $q->where('service_number', 'like', '%'.$search.'%')->orWhereIn('order_id', $orderIds)->orWhereIn('member_id', $memberIds);
            });
        }

        if ($status > 0) {
            $query->whereStatus($status);
        }
        $afterSales = $query->paginate(10);
        return view('admin.after_sale.repair_goods_list', [
            'afterSales' => $afterSales,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * 返修编辑
     *
     * @param Request $request
     * @param AfterSale $repairGoods
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function repairGoodsEdit(Request $request, AfterSale $repairGoods) {
        if ($request->isMethod('post')) {
            $status = intval($request->input('status'));
            $statusNote = $request->input('status_note');
            if ($status > 0) {
                if (!in_array($repairGoods->status, [1, 2, 4]) || !in_array($status, [2, 3, 4, 5, 6])) {
                    return ResponseJson::getInstance()->errorJson('非法操作');
                }
                if ($repairGoods->status == 1 && !in_array($status, [2, 3])) {
                    return ResponseJson::getInstance()->errorJson('非法操作');
                }
                if ($repairGoods->status == 2 && $status != 4) {
                    return ResponseJson::getInstance()->errorJson('非法操作');
                }
                if ($repairGoods->status == 4 && !in_array($status, [5, 6])) {
                    return ResponseJson::getInstance()->errorJson('非法操作');
                }
                if (empty($statusNote)) {
                    return ResponseJson::getInstance()->errorJson('审核留言不能为空');
                }
                if (strlen($statusNote) > 200) {
                    return ResponseJson::getInstance()->errorJson('审核留言字数仅限200');
                }

                \DB::beginTransaction();
                try {
                    $repairGoods->status = $status;
                    $repairGoods->status_note = $statusNote;
                    $repairGoods->admin_id = \Auth::guard('admin')->user()->id;
                    $repairGoods->save();

                    # 记录操作日志
                    AfterSaleLog::create([
                        'admin_id' => \Auth::guard('admin')->user()->id,
                        'after_sale_id' => $repairGoods->id,
                        'service_number' => $repairGoods->service_number,
                        'status' => $repairGoods->status,
                        'status_note' => $repairGoods->status_note,
                    ]);

                    \DB::commit();
                    return ResponseJson::getInstance()->doneJson('操作成功');
                } catch (\Exception $e) {
                    \DB::rollBack();
                    throw new ApiException($e);
                }
            }
            return ResponseJson::getInstance()->doneJson('操作成功');
        }
        $picArr = json_decode($repairGoods['pic']);
        foreach ($picArr as $k => $v) {
            $picArr[$k] = CommonHelper::getInstance()->formatImageToShow($v);
        }
        $repairGoods['pic'] = $picArr;
        return view('admin.after_sale.repair_goods_edit', [
            'repairGoods' => $repairGoods,
        ]);
    }
}
