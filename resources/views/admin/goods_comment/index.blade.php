@extends('admin.layouts.index')

@section('title', '商品评价列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        商品评价列表
        <small>商品评价列表</small>
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
                        <label>搜索:&nbsp;&nbsp;</label><input type="text" name="search" class="form-control" value="{{$search}}" placeholder="订单号,商品名称,会员名称,内容"/>
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
                            <th>商品名称</th>
                            <th>订单号</th>
                            <th>评价人</th>
                            <th>内容</th>
                            <th>是否显示</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($goodsComments as $key => $value)
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="{{$value['id']}}">{{$value['id']}}</label>
                            </td>
                            <td>{{$value['goods_name']}}</td>
                            <td>{{$value['order_sn']}}</td>
                            <td>{{$value['member_name']}}</td>
                            <td>{{str_limit($value['content'], 30)}}</td>
                            <td>
                                @if($value['is_show'] == 1)
                                    <span class="label label-success">是</span>
                                @else
                                    <span class="label label-danger">否</span>
                                @endif
                            </td>
                            <td>{{$value['created_at']}}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='{{url('admin/goodsComment/edit/'.$value['id'])}}'">编辑</button>
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
                    {!! with(new \App\Library\PageLibrary($goodsComments))->render() !!}
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