@extends('admin.layouts.index')

@section('title', '退货列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        退货列表
        <small>退货列表</small>
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
                        <label>搜索:&nbsp;&nbsp;</label><input type="text" name="search" class="form-control" value="{{$search}}" placeholder="订单号,申请人,服务单号"/>
                        <label>退货状态:&nbsp;&nbsp;
                            <select class="form-control" name="status">
                                <option value="0" @if($status == 0) selected @endif>请选择...</option>
                                <option value="1" @if($status == 1) selected @endif>等待审核</option>
                                <option value="2" @if($status == 2) selected @endif>审核通过，请寄送快递</option>
                                <option value="3" @if($status == 3) selected @endif>审核不通过</option>
                                <option value="4" @if($status == 4) selected @endif>已收到寄件，检测中</option>
                                <option value="5" @if($status == 5) selected @endif>退换货成功</option>
                                <option value="6" @if($status == 6) selected @endif>退换货失败</option>
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
                            <th>服务单号</th>
                            <th>订单号</th>
                            <th>申请人</th>
                            <th>商品名称</th>
                            <th>退货数量</th>
                            <th>退货状态</th>
                            <th>申请时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($afterSales as $key => $value)
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="{{$value['id']}}">{{$value['id']}}</label>
                            </td>
                            <td>{{$value['service_number']}}</td>
                            <td>{{$value['order_sn']}}</td>
                            <td>{{$value['member_name']}}</td>
                            <td>{{$value['goods_name']}}</td>
                            <td>{{$value['goods_number']}}</td>
                            <td>
                                @if($value['status'] == 1)
                                    <span class="label label-danger">{{$value['status_text']}}</span>
                                @elseif($value['status'] == 2)
                                    <span class="label label-warning">{{$value['status_text']}}</span>
                                @elseif($value['status'] == 3)
                                    <span class="label label-default">{{$value['status_text']}}</span>
                                @elseif($value['status'] == 4)
                                    <span class="label label-primary">{{$value['status_text']}}</span>
                                @elseif($value['status'] == 5)
                                    <span class="label label-success">{{$value['status_text']}}</span>
                                @elseif($value['status'] == 6)
                                    <span>{{$value['status_text']}}</span>
                                @endif
                            </td>
                            <td>{{date('Y-m-d H:i:s', $value['apply_time'])}}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='{{url('admin/backGoodsEdit/'.$value['id'])}}'">编辑</button>
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
                    {!! with(new \App\Library\PageLibrary($afterSales))->render() !!}
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
    </script>
@endsection