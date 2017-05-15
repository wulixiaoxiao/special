<?php
use App\Helper\CommonHelper;
?>
@extends('admin.layouts.index')

@section('title', '订单详情')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        订单详情
        <small>订单详情</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <button type="button" class="btn btn-info btn-sm" onclick="javascript:window.history.back();">返回</button>
                    </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" enctype="application/x-www-form-urlencoded" id="form-edit">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">订单号</label>
                            <div class="col-sm-4">{{$order['order_sn']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">订单状态</label>
                            <div class="col-sm-4">
                                @if($order['status'] == 0)
                                    <span class="label label-danger">{{$order['status_text']}}</span>
                                @elseif($order['status'] == 1)
                                    <span class="label label-warning">{{$order['status_text']}}</span>
                                @elseif($order['status'] == 2)
                                    <span class="label label-default">{{$order['status_text']}}</span>
                                @elseif($order['status'] == 3)
                                    <span class="label label-primary">{{$order['status_text']}}</span>
                                @elseif($order['status'] == 4)
                                    <span class="label label-success">{{$order['status_text']}}</span>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">支付流水号</label>
                            <div class="col-sm-4">{{$order['pay_number']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">运费金额</label>
                            <div class="col-sm-4">{{$order['freight_price']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">订单金额</label>
                            <div class="col-sm-4">{{$order['order_price']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">是否返利</label>
                            <div class="col-sm-4">
                                @if($order['is_rebate'] == 0)
                                    <span class="label label-danger">否</span>
                                @else
                                    <span class="label label-success">是</span>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">退货状态</label>
                            <div class="col-sm-4">
                                @if($order['is_back_goods'] == 1)
                                    <span class="label label-danger">退货中</span>
                                @else
                                    <span>否</span>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">下单人</label>
                            <div class="col-sm-4">{{$order->member ? $order->member->wx_nickname : ''}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">下单时间</label>
                            <div class="col-sm-4">{{$order['create_time'] ? date('Y-m-d H:i:s', $order['create_time']) : ''}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">支付时间</label>
                            <div class="col-sm-4">{{$order['pay_time'] ? date('Y-m-d H:i:s', $order['pay_time']) : ''}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">发货时间</label>
                            <div class="col-sm-4">{{$order['deliver_time'] ? date('Y-m-d H:i:s', $order['deliver_time']) : ''}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">收货时间</label>
                            <div class="col-sm-4">{{$order['receiving_time'] ? date('Y-m-d H:i:s', $order['receiving_time']) : ''}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">收货人</label>
                            <div class="col-sm-4">{{$order['receiver_name']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">收货人电话</label>
                            <div class="col-sm-4">{{$order['receiver_phone_number']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">收货人地址</label>
                            <div class="col-sm-4">{{$order['receiver_province'].$order['receiver_city'].$order['receiver_city'].$order['receiver_detail']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">订单商品</label>
                            <div class="col-sm-8">
                                @foreach($order->orderGoods as $key => $value)
                                <div>{{$value['goods_name']}}&nbsp;&nbsp;规格:{{$value['sku_str'] ? $value['sku_str'] : '默认'}}&nbsp;&nbsp;单价:{{CommonHelper::getInstance()->formatPriceToShow($value['goods_price'])}}&nbsp;&nbsp;数量:{{$value['goods_number']}}&nbsp;&nbsp;总价:{{CommonHelper::getInstance()->formatPriceToShow($value['goods_price']*$value['goods_number'])}}&nbsp;&nbsp;是否包邮:@if($value['is_free_shipping'] == 1)是@else否@endif&nbsp;&nbsp;退货数量:{{$value['back_goods_number']}}</div>
                                @endforeach
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" style="text-align: center;">
                        <!-- Button trigger modal -->
                        @if($order['status'] == 2)
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">订单发货</button>
                        @endif
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
            <!-- Modal -->
            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="exampleModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">订单发货</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-2">快递名称</div>
                                <div class="col-md-6">
                                    <input type="text" name="express_name" id="express_name">
                                    <button id="express_search">搜索</button>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-2">快递列表</div>
                                <div class="col-md-4">
                                    <select name="express_id" id="express_id" style="width: 150px;">
                                        <option value="">请选择...</option>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-2">快递单号</div>
                                <div class="col-md-5">
                                    <input type="text" name="express_code" id="express_code">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-primary" id="order_deliver">提交</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('css-block')
    <link rel="stylesheet" href="{{url('assets/admin/colorbox/example5/colorbox.css')}}">
@endsection

@section('js-block')
    <script type="text/javascript" src="{{url('assets/admin/colorbox/jquery.colorbox.js')}}"></script>
    <script>
        //初始化快递
        $.get('/admin/order/getExpressList', {search: $('#express_name').val()}, function (data) {
            if (data.error == 0) {
                $('#express_id').empty();
                var result = data.data;
                if (result != '[]') {
                    for (var i = 0; i < result.length; i++) {
                        $('#express_id').append('<option value="' + result[i].id + '">' + result[i].express_name + '</option>');
                    }
                } else {
                    $('#express_id').append('');
                }
            } else {
                alert(data.message);
            }
        });
        $(function () {
            $(".inline").colorbox({inline:true, width:"50%"});

        });
        // 搜索快递
        $('#express_search').click(function () {
            $.get('/admin/order/getExpressList', {search: $('#express_name').val()}, function (data) {
                if (data.error == 0) {
                    $('#express_id').empty();
                    var result = data.data;
                    if (result != '[]') {
                        for (var i = 0; i < result.length; i++) {
                            $('#express_id').append('<option value="' + result[i].id + '">' + result[i].express_name + '</option>');
                        }
                    } else {
                        $('#express_id').append('');
                    }

                } else {
                    alert(data.message);
                }
            });
        });

        // 订单发货
        $('#order_deliver').click(function() {
            var order_id = '{{$order['id']}}';
            var express_id = $('#express_id').val();
            var express_code = $('#express_code').val();
            $.get('/admin/order/orderDeliver', {'order_id': order_id,'express_id': express_id,express_code:express_code}, function (data) {
                if (data.error == 0) {
                    $('#exampleModal').modal('hide');
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            });
        });
    </script>
@endsection