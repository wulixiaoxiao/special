@extends('admin.layouts.index')

@section('title', 'SKU编辑')

@section('content')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        SKU编辑
        <small>SKU编辑</small>
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
                            <label for="sku_name" class="col-sm-2 control-label">SKU名称</label>
                            <div class="col-sm-4">
                                <input type="text" name="sku_name" id="sku_name" class="form-control" value="{{$sku->sku_name}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sku_values" class="col-sm-2 control-label">SKU值</label>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    @if($sku->skuValue && count($sku->skuValue) > 0)
                                        @foreach($sku->skuValue as $key => $value)
                                            <label>
                                                <input type="checkbox" name="sku_values[]" value="{{$value['id']}}" checked onclick="delSkuValue({{$value['id']}})"> {{$value['sku_value_name']}}&nbsp;&nbsp;
                                            </label>
                                        @endforeach
                                    @else
                                        <label>暂无SKU选项值</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 点击选项可删除</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" style="text-align: center;">
                        <button type="button" class="btn btn-success" onclick="addSkuValue({{$sku->id}})"> 添加SKU可选项</button>&nbsp;&nbsp;&nbsp;
                        <button type="submit" class="btn btn-primary"> 确定</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

@endsection

@section('css-block')

@endsection

@section('js-block')
    <script>
        $('#form-edit').submit(function(){
            var options = {
                type: 'post',
                success: function (data) {
                    if (data.error == 0) {
                        alert('编辑成功');
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                }
            };
            $(this).ajaxSubmit(options);
            return false;
        });

        function delSkuValue(id) {
            if (confirm('删除不可恢复,确定要删除此关联项吗?')) {
                $.post('{{url('admin/sku/delSkuValue')}}', {sku_value_id:id}, function(data) {
                    if (data.error == 0) {
                        alert('删除成功');
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                });
            }
        }

        function addSkuValue(sku_id) {
            var sku_value = prompt('请输入SKU可选项值');
            if (sku_value == null || sku_value == '') {
                return false;
            }
            $.post('{{url('admin/sku/addSkuValue')}}', {sku_id:sku_id, sku_value:sku_value}, function(data) {
                if (data.error == 0) {
                    alert('添加成功');
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    </script>
@endsection