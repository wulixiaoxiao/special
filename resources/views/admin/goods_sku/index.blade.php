@extends('admin.layouts.index')

@section('title', '商品SKU列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        商品SKU列表
        <small>商品SKU列表</small>
        <button type="button" class="btn btn-success btn-sm pull-right" onclick="javascript:window.location.href='{{url('admin/goods_sku/add')}}?goods_id={{$goods_id}}'">增加</button>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <button type="button" class="btn btn-info btn-sm" onclick="javascript:window.history.back();">返回</button>
                    </h3>
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
                            <th>SKU名称</th>
                            <th>SKU组合</th>
                            <th>市场价格(元)</th>
                            <th>实际价格(元)</th>
                            <th>库存</th>
                            <th>是否是默认</th>
                            <th>操作</th>
                        </tr>
                        @foreach($goods_skus as $key => $value)
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="{{$value['id']}}">{{$value['id']}}</label>
                            </td>
                            <td>{{$value['goods_name']}}</td>
                            <td>{{$value['sku_ids_string']}}</td>
                            <td>{{$value['sku_value_ids_string']}}</td>
                            <td>{{$value['market_price']}}</td>
                            <td>{{$value['selling_price']}}</td>
                            <td>{{$value['stock']}}</td>
                            <td>
                                @if($value['is_default'] == 1)
                                    <span class="label label-success">是</span>
                                    @else
                                    <span>否</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='{{url('admin/goods_sku/edit/'.$value['id'])}}'">编辑</button>
                                @if($value['is_default'] == 0)<button type="button" class="btn btn-danger btn-xs" onclick="del({{$value['id']}})">删除</button>@endif
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
                    {!! with(new \App\Library\PageLibrary($goods_skus))->render() !!}
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

        // 删除
        function del(id) {
            if (!id) {
                return false;
            }
            if (confirm('删除后不可恢复,确定要删除吗?')) {
                $.post('{{url('admin/goods_sku/del')}}', {'id' : id}, function(data) {
                    if (data.error == 0) {
                        alert('删除成功');
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                }, 'json');
            }
        }
    </script>
@endsection