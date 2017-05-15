<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\MemberBank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\CommonHelper;

class MemberController extends Controller
{
    /**
     * 会员列表
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $memberData = Member::when($search, function ($query) use ($search) {
                return $query->where('id', '=', $search)
                    ->orWhere('wx_nickname', 'like', '%'.$search.'%');
                })
            ->paginate(10);

        if($memberData->isNotEmpty()){
            foreach ($memberData as $key => $value) {
                $parent = Member::whereId($value['parent_id'])->value('wx_nickname');
                $memberData[$key]['parent_name'] = $parent ? $parent : '公司';
                $memberData[$key]['format_money'] = CommonHelper::getInstance()->formatPriceToShow($value['money']);
                $bank = MemberBank::whereMemberId($value['id'])->value('bank_number');
                $memberData[$key]['binding_bank'] = $bank ? 1 : 0;

            }
        }


        return view('admin.member.index', compact('memberData', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 会员详情
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $memberData = Member::leftJoin('member_bank', 'member.id', '=', 'member_bank.member_id')->where('member.id', '=', $id)->first();

        if($memberData['parent_id']){
            $memberData->parent_name = Member::whereId($memberData->parent_id)->value('wx_nickname');
        }else{
            $memberData->parent_name = '公司';
        }

        $memberData->format_money = CommonHelper::getInstance()->formatPriceToShow($memberData->money);
        $memberData->format_bank_name = '支付宝';

        return view('admin.member.edit', compact('memberData'));
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
