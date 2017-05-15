<?php
use App\Helper\CommonHelper;
?>
@extends('admin.layouts.index')

@section('title', '松鼠币返利记录')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        松鼠币返利记录
        <small>松鼠币返利记录</small>
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
                            <select class="form-control" name="is_rebate">
                                <option value="-1">请选择...</option>
                                <option value="0" @if($is_rebate == 0) selected @endif>待返利</option>
                                <option value="1" @if($is_rebate == 1) selected @endif>已返利</option>
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
                            <th>返利获得者</th>
                            <th>松鼠币数量</th>
                            <th>返利状态</th>
                            <th>创建时间</th>
                            <th>返利时间</th>
                        </tr>
                        @foreach($rebates as $key => $value)
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="{{$value['id']}}">{{$value['id']}}</label>
                            </td>
                            <td>{{$value->order->order_sn}}</td>
                            <td>{{$value->goods_name}}</td>
                            <td>{{$value->member->wx_nickname}}</td>
                            <td>{{$value->coin_number}}</td>
                            <td>
                                @if($value->is_rebate == 0)
                                    <span class="label label-danger">{{$value->status_text}}</span>
                                @elseif($value->is_rebate == 1)
                                    <span class="label label-success">{{$value->status_text}}</span>
                                @endif
                            </td>
                            <td>{{$value->create_time ? date('Y-m-d H:i:s', $value->create_time) : ''}}</td>
                            <td>{{$value->rebate_time ? date('Y-m-d H:i:s', $value->rebate_time) : ''}}</td>
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