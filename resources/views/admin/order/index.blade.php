@extends('admin.layouts.index')

@section('title', '订单列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        订单列表
        <small>订单列表</small>
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
                        <label>搜索:&nbsp;&nbsp;</label><input type="text" name="search" class="form-control" value="{{$search}}" placeholder="订单号,下单人,收货人"/>
                        <label>订单状态:&nbsp;&nbsp;
                            <select class="form-control" name="status">
                                <option value="-1" @if($status == -1) selected @endif>请选择...</option>
                                <option value="0" @if($status == 0) selected @endif>已取消</option>
                                <option value="1" @if($status == 1) selected @endif>待付款</option>
                                <option value="2" @if($status == 2) selected @endif>待发货</option>
                                <option value="3" @if($status == 3) selected @endif>待收货</option>
                                <option value="4" @if($status == 4) selected @endif>已完成</option>
                            </select>
                        </label>
                        <label>返利状态:&nbsp;&nbsp;
                            <select class="form-control" name="is_rebate">
                                <option value="-1" @if($is_rebate == -1) selected @endif>请选择...</option>
                                <option value="0" @if($is_rebate == 0) selected @endif>待返利</option>
                                <option value="1" @if($is_rebate == 1) selected @endif>已返利</option>
                            </select>
                        </label>
                        <label>开始时间 :
                            <input
                                    name="start_time" id="start_time" value="{{$start_time}}"
                                    class="form-control input-sm border-radius">
                        </label>
                        <label>结束时间 :
                            <input
                                    name="end_time" id="end_time" value="{{$end_time}}"
                                    class="form-control input-sm border-radius">
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
                            <th>下单人</th>
                            <th>收货人</th>
                            <th>订单价格(元)</th>
                            <th>订单状态</th>
                            <th>是否返利</th>
                            <th>退货状态</th>
                            <th>下单时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($orders as $key => $value)
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="{{$value['id']}}">{{$value['id']}}</label>
                            </td>
                            <td>{{$value['order_sn']}}</td>
                            <td>{{$value->member ? $value->member->wx_nickname : ''}}</td>
                            <td>{{$value['receiver_name']}}</td>
                            <td>{{$value['order_price']}}</td>
                            <td>
                                @if($value['status'] == 0)
                                    <span class="label label-danger">{{$value['status_text']}}</span>
                                @elseif($value['status'] == 1)
                                    <span class="label label-warning">{{$value['status_text']}}</span>
                                @elseif($value['status'] == 2)
                                    <span class="label label-default">{{$value['status_text']}}</span>
                                @elseif($value['status'] == 3)
                                    <span class="label label-primary">{{$value['status_text']}}</span>
                                @elseif($value['status'] == 4)
                                    <span class="label label-success">{{$value['status_text']}}</span>
                                @endif
                            </td>
                            <td>@if($value['is_rebate'] == 1) <span class="label label-success">是</span> @else <span class="label label-danger">否</span> @endif</td>
                            <td>
                                @if($value['is_back_goods'] == 1)
                                    <span class="label label-danger">退货中</span>
                                @else
                                    <span>否</span>
                                @endif
                            </td>
                            <td>{{$value['created_at']}}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='{{url('admin/order/edit/'.$value['id'])}}'">详情</button>
                            </td>
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
                    {!! with(new \App\Library\PageLibrary($orders))->render() !!}
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
    <link rel="stylesheet" href="{{url('assets/admin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js-block')
    <script type="text/javascript" src="{{url('assets/admin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/admin/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')}}"></script>
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

        $('#start_time').datetimepicker({
            language:  'zh-CN',
            format: 'yyyy-mm-dd hh:ii:ss',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0
        });
        $('#end_time').datetimepicker({
            language:  'zh-CN',
            format: 'yyyy-mm-dd hh:ii:ss',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0
        });
    </script>
@endsection