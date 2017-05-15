@extends('admin.layouts.index')

@section('title', '商品SKU集合列表')

@section('content')

        <!-- Content Header (Page header) -->
<section class="content-header" xmlns="http://www.w3.org/1999/html">
    <h1>
        商品SKU集合列表
        <small>商品SKU集合列表</small>
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
                    </h3>&nbsp;&nbsp;
                    <span>
                        <span style="font-weight: bolder;">[{{$goods->goods_name}}]</span>已选择的SKU:&nbsp;&nbsp;
                        @if($skuNames)
                            <span style="font-weight: bolder;">{{$skuNames}}</span>
                        @else
                            <span style="font-weight: bolder;">暂无关联SKU</span>
                        @endif
                    </span>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" enctype="application/x-www-form-urlencoded" id="form-add">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">SKU列表</label>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    @if($skus)
                                        @foreach($skus as $key => $value)
                                        <label>
                                            <input type="checkbox" name="sku_ids[]" value="{{$value->id}}" class="sku_ids" @if(!empty($skuIds) && in_array($value->id, $skuIds)) checked @endif> {{$value->sku_name}}&nbsp;&nbsp;
                                        </label>
                                        @endforeach
                                    @else
                                        暂时没有可选的SKU,请添加
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" style="text-align: center;">
                        {{--<button type="submit" class="btn btn-primary"> 确定</button>--}}
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
        var goods_id = {{$goods->id}};
        $('#form-add').submit(function(){
            var options = {
                type: 'post',
                success: function (data) {
                    if (data.error == 0) {
                        alert('添加成功');
                        window.location.href = '{{url('admin/goodsCategory')}}';
                    } else {
                        alert(data.message);
                    }
                }
            };
            $(this).ajaxSubmit(options);
            return false;
        });

        $('.sku_ids').click(function() {
            var type = 'del';
            if ($(this).prop('checked')) {
                type = 'add';
            } else {
                type = 'del';
            }

            $.post('{{url('admin/goods_sku_set/chooseSku')}}', {sku_id:$(this).val(), goods_id:goods_id, type:type}, function(data) {
                if (data.error == 0) {
                    alert('编辑成功');
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            });
        });
    </script>
@endsection