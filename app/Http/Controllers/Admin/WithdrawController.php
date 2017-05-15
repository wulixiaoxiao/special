<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ApiException;
use App\Models\Member;
use App\Models\MemberBank;
use App\Models\MemberWithdraw;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\CommonHelper;
use App\Helper\ResponseJson;
use Mockery\Exception;

class WithdrawController extends Controller
{
    /**
     * 显示提现列表
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$search = $request->input('search');

        $withdrawData = MemberWithdraw::paginate(10);

        if($withdrawData->isNotEmpty()){
            foreach ($withdrawData as $key => $value) {
                $memberBankData = MemberBank::whereId($value->member_bank_id)->first();
                $withdrawData[$key]['member_wx_nickname'] = Member::whereId($memberBankData->member_id)->value('wx_nickname');
                $withdrawData[$key]['member_name'] = $memberBankData->name;
                $withdrawData[$key]['bank_name'] = '支付宝';
                $withdrawData[$key]['bank_number'] = $memberBankData->bank_number;
                $withdrawData[$key]['bank_phone'] = $memberBankData->bank_phone;
                $withdrawData[$key]['format_money'] = CommonHelper::getInstance()->formatPriceToShow($value->money);
            }
        }

        return view('admin.withdraw.index', compact('withdrawData'));
    }

    /**
     * 审核通过提现申请
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function approved(Request $request)
    {
        $id = $request->get('id', 0);

        MemberWithdraw::whereId($id)->update([
            'audit_status' => 1,
            'audit_time' => time(),
        ]);

        return ResponseJson::getInstance()->doneJson('审核通过！');
    }

    /**
     * 驳回提现申请
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rejected(Request $request)
    {
        $id = $request->get('id', 0);
        $audit_fail_message = $request->get('failMessage', 0);

        \DB::beginTransaction();
        try{
            MemberWithdraw::whereId($id)->update([
                'audit_status'      => 3,
                'audit_time'        => time(),
                'audit_fail_message' => $audit_fail_message,
            ]);

            $withdraw = MemberWithdraw::whereId($id)->first();
            Transactions::create([
                'type'          => 'withdraw_pass',
                'target_id'     => $id,
                'member_id'     => $withdraw->member_id,
                'money'         => $withdraw->money,
                'balance'       => Member::whereId($withdraw->member_id)->value('money'),
                'description'   => '用户申请提现审核驳回，返回账户余额！',
                'create_time'   => time(),
            ]);

            //返还余额
            Member::where('id',$withdraw->member_id)->increment('money',$withdraw->money);
            \DB::commit();
            return ResponseJson::getInstance()->doneJson('驳回申请！');
        }catch (Exception $e){
            \DB::rollBack();
            throw new ApiException($e);
            return ResponseJson::getInstance()->doneJson('驳回申请失败！');
        }

    }

    /**
     * 打款
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function payMoney(Request $request)
    {
        $id = $request->get('id', 0);
        $payNumber = $request->get('pay_number', 0);

        //更新提现申请表信息
        MemberWithdraw::whereId($id)->update([
            'audit_status'  => 2,
            'pay_number'    => $payNumber,
            'remit_time'    => time(),
        ]);

        //更新流水记录信息
        $withdraw = MemberWithdraw::whereId($id)->first();
        Transactions::create([
            'type'          => 'withdraw_pass',
            'target_id'     => $id,
            'member_id'     => $withdraw->member_id,
            'money'         => $withdraw->money,
            'balance'       => Member::whereId($withdraw->member_id)->value('money'),
            'description'   => '用户申请提现审核通知，并打款！',
            'create_time'   => time(),
        ]);

        return ResponseJson::getInstance()->doneJson('打款成功！');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
