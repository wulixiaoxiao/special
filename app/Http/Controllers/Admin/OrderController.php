<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Models\AdminLog;
use App\Models\CoinRebate;
use App\Models\Express;
use App\Models\FansRebate;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderGoods;
use App\Models\OrderLog;
use App\Models\OrderRebate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\CommonHelper;
use App\Helper\ResponseJson;

class OrderController extends Controller
{
    /**
     * 订单列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $search = $request->input('search');
        $status = intval($request->input('status', '-1'));
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $isRebate = intval($request->input('is_rebate', '-1'));

        $query = Order::whereRaw('1=1')->orderBy('id', 'desc');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $memberIds = Member::where('wx_nickname', 'like', '%'.$search.'%')->pluck('id');
                $q->where('order_sn', 'like', '%'.$search.'%')
                    ->orWhere('receiver_name', 'like', '%'.$search.'%')
                    ->orWhereIn('member_id', $memberIds);
            });
        }
        if ($status >= 0) {
            $query->whereStatus($status);
        }
        if ($isRebate >= 0) {
            $query->whereIsRebate($isRebate);
        }
        if (!empty($startTime)) {
            $query->where('create_time', '>', strtotime($startTime));
        }
        if (!empty($endTime)) {
            $query->where('create_time', '<', strtotime($endTime));
        }
        $orders = $query->paginate(10);
        foreach ($orders as $key => $value) {
            $orders[$key]['goods_price'] = CommonHelper::getInstance()->formatPriceToShow($value['goods_price']);
            $orders[$key]['freight_price'] = CommonHelper::getInstance()->formatPriceToShow($value['freight_price']);
            $orders[$key]['order_price'] = CommonHelper::getInstance()->formatPriceToShow($value['order_price']);
        }
        return view('admin.order.index', [
            'orders' => $orders,
            'status' => $status,
            'search' => $search,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_rebate' => $isRebate,
        ]);
    }

    /**
     * 订单详情
     *
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Order $order) {
        # 格式化信息
        $order['goods_price'] = CommonHelper::getInstance()->formatPriceToShow($order['goods_price']);
        $order['freight_price'] = CommonHelper::getInstance()->formatPriceToShow($order['freight_price']);
        $order['order_price'] = CommonHelper::getInstance()->formatPriceToShow($order['order_price']);

        return view('admin.order.edit', [
            'order' => $order,
        ]);
    }

    /**
     * 订单返利
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodsRebate(Request $request) {
        $search = $request->input('search');
        $status = intval($request->input('status'));

        $query = OrderRebate::orderBy('id', 'desc');
        if ($search) {
            $query->where(function($q) use ($search) {
                $orderIds = Order::where('order_sn', 'like', '%'.$search.'%')->pluck('id');
                $q->whereIn('order_id', $orderIds);
            });
        }
        if ($status > 0) {
            $query->whereStatus($status);
        }
        $rebates = $query->paginate(10);
        return view('admin.order.goods_rebate', [
            'rebates' => $rebates,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * 粉丝返利
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fansRebate(Request $request) {
        $search = $request->input('search');
        $status = intval($request->input('status'));

        $query = FansRebate::orderBy('id', 'desc');
        if ($search) {
            $query->whereOrderSn($search);
        }
        if ($status > 0) {
            $query->whereRebateStatus($status);
        }
        $rebates = $query->paginate(10);
        return view('admin.order.fans_rebate', [
            'rebates' => $rebates,
            'search' => $search,
            'status' => $status,
        ]);
    }

    /**
     * 获取快递列表
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExpressList(Request $request) {
        $expressList = Express::select(['id', 'express_name'])
            ->whereIsOpen(1)
            ->where(function($query) use ($request) {
                if (!empty($request->input('search'))) {
                    $query->where('express_name', 'like', '%'.$request->input('search').'%');
                }
            })->get()->toArray();
        return ResponseJson::getInstance()->doneJson('查询成功', $expressList);
    }

    /**
     * 订单发货
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderDeliver(Request $request) {
        $orderId = intval($request->input('order_id'));
        $expressId = intval($request->input('express_id'));
        $expressCode = trim($request->input('express_code'));

        $order = Order::where('id', $orderId)->first();
        if (!$order) {
            return ResponseJson::getInstance()->errorJson('订单不存在');
        }

        if ($order->status != 2) {
            return ResponseJson::getInstance()->errorJson('只有待发货的订单才可以进行发货操作');
        }

        if ($expressId <= 0 || !Express::where('id', $expressId)->where('is_open', 1)->exists()) {
            return ResponseJson::getInstance()->errorJson('快递不存在');
        }

        if (empty($expressCode)) {
            return ResponseJson::getInstance()->errorJson('快递单号不能为空');
        }
        \DB::beginTransaction();
        try {
            $order->status = 3;
            $order->express_id = $expressId;
            $order->tracking_number = $expressCode;
            $order->deliver_time = time();
            $order->save();
            OrderLog::getInstance()->addLog($order->id, '订单发货:'.$order->order_sn, \Auth::guard('admin')->user()->id);
            AdminLog::getInstance()->addLog('订单发货:'.$order->order_sn);
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('发货成功');
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ApiException($e);
        }
    }

    /**
     * 松鼠币返利记录
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function coinRebate(Request $request) {
        $search = $request->input('search');
        $isRebate = intval($request->input('is_rebate', -1));

        $query = CoinRebate::orderBy('id', 'desc');
        if ($search) {
            $query->where(function($q) use ($search) {
                $orderIds = Order::where('order_sn', 'like', '%'.$search.'%')->pluck('id');
                $q->whereIn('order_id', $orderIds);
            });
        }
        if ($isRebate >= 0) {
            $query->whereIsRebate($isRebate);
        }
        $rebates = $query->paginate(10);
        return view('admin.order.coin_rebate', [
            'rebates' => $rebates,
            'search' => $search,
            'is_rebate' => $isRebate,
        ]);
    }
}
