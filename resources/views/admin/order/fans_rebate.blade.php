<?php
use App\Helper\CommonHelper;
?>
@extends('admin.layouts.index')

@section('title', '粉丝返利列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        粉丝返利列表
        <small>粉丝返利列表</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <form class="form-horizontal form-inline form-group-sm" method="post" enctype="application/x-www-form-urlencoded">
                        {{csrf_field()}}
                        <label>搜索:&nbsp;&nbsp;</label><input type="text" name="search" class="form-control" value="{{$search}}" placeholder="订单号"/>
                        <label>返利状态:&nbsp;&nbsp;
                            <select class="form-control" name="status">
                                <option value="0" @if($status == 0) selected @endif>请选择...</option>
                                <option value="1" @if($status == 1) selected @endif>待返利</option>
                                <option value="2" @if($status == 2) selected @endif>已返利</option>
                                <option value="4" @if($status == 4) selected @endif>已冻结</option>
                                <option value="3" @if($status == 3) selected @endif>已失效</option>
                            </select>
                        </label>
                        <button type="submit" class="btn btn-primary btn-sm">搜索</button>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>
                                <label><input type="checkbox" value="" id="check-all">ID</label>
                            </th>
                            <th>订单号</th>
                            <th>商品名称</th>
                            <th>商品价格</th>
                            <th>商品数量</th>
                            <th>商品毛利(元)</th>
                            <th>返利人</th>
                            <th>返利获得者</th>
                            <th>返利金额(元)</th>
                            <th>返利比率</th>
                            <th>返利类型</th>
                            <th>返利状态</th>
                            <th>返利时间</th>
                        </tr>
                        @foreach($rebates as $key => $value)
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="{{$value['id']}}">{{$value['id']}}</label>
                            </td>
                            <td>{{$value['order_sn']}}</td>
                            <td>{{$value['goods_name']}}</td>
                            <td>{{$value->orderGoods ? CommonHelper::getInstance()->formatPriceToShow($value->orderGoods->goods_price) : ''}}</td>
                            <td>{{$value->orderGoods ? $value->orderGoods->goods_number : 0}}</td>
                            <td>{{$value->orderGoods ? CommonHelper::getInstance()->formatPriceToShow($value->orderGoods->goods_margin) : ''}}</td>
                            <td>{{$value['member_name']}}</td>
                            <td>{{$value['receive_member_name']}}</td>
                            <td>{{CommonHelper::getInstance()->formatPriceToShow($value['rebate_money'])}}</td>
                            <td>{{$value['rebate_interest']}} %</td>
                            <td>
                                @if($value['type'] == 1)
                                    向上一级返利
                                @elseif($value['type'] == 2)
                                    向上二级返利
                                @endif
                            </td>
                            <td>
                                @if($value['rebate_status'] == 1)
                                    <span class="label label-warning">{{$value['status_text']}}</span>
                                @elseif($value['rebate_status'] == 2)
                                    <span class="label label-success">{{$value['status_text']}}</span>
                                @elseif($value['rebate_status'] == 3)
                                    <span class="label label-primary">{{$value['status_text']}}</span>
                                @elseif($value['rebate_status'] == 4)
                                    <span class="label label-default">{{$value['status_text']}}</span>
                                @endif
                            </td>
                            <td>{{$value['finish_order_time'] ? date('Y-m-d H:i:s', $value['finish_order_time']) : ''}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <!-- /.box-footer -->
                <div class="box-footer clearfix">
                    <span class="pull-left">
                        {{--<button type="button" class="btn btn-warning btn-sm">导出</button>--}}
                        {{--<button type="button" class="btn btn-danger btn-sm">批量删除</button>--}}
                    </span>
                    {!! with(new \App\Library\PageLibrary($rebates))->render() !!}
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->

@endsection

@section('css-block')

@endsection

@section('js-block')
    <script>
        // 全选/全不选
        $('#check-all').click(function() {
            $(":checkbox[name='ids[]']").prop('checked', $(this).prop('checked'));
        });
        $(":checkbox[name='ids[]']").click(function() {
            if ($(":checkbox[name='ids[]']:checked").length == $(":checkbox[name='ids[]']").length) {
                $('#check-all').prop('checked', true);
            } else {
                $('#check-all').prop('checked', false);
            }
        });
    </script>
@endsection