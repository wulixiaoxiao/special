@extends('admin.layouts.index')

@section('title', '商品SKU编辑')

@section('content')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        商品SKU编辑
        <small>商品SKU编辑</small>
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
                            <label for="market_price" class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-4">
                                {{$goods->goods_name}}
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="market_price" class="col-sm-2 control-label">SKU名称</label>
                            <div class="col-sm-4">
                                {{$goodsSku->sku_ids_string}}
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="market_price" class="col-sm-2 control-label">SKU组合</label>
                            <div class="col-sm-4">
                                {{$goodsSku->sku_value_ids_string}}
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="market_price" class="col-sm-2 control-label">市场价格</label>
                            <div class="col-sm-4">
                                <input type="text" name="market_price" id="market_price" class="form-control" value="{{$goodsSku->market_price}}">
                            </div>
                            <div class="col-sm-4">
                                {{--<span style="color: red;">* 必填</span>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="selling_price" class="col-sm-2 control-label">实际价格</label>
                            <div class="col-sm-4">
                                <input type="text" name="selling_price" id="selling_price" class="form-control" value="{{$goodsSku->selling_price}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stock" class="col-sm-2 control-label">库存</label>
                            <div class="col-sm-4">
                                <input type="text" name="stock" id="stock" class="form-control" value="{{$goodsSku->stock}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="thumb" class="col-sm-2 control-label">商品缩略图</label>
                            <div class="col-sm-4">
                                <input type="file" name="thumb" id="thumb" class="form-control">
                                @if($goods_thumb)
                                    <img onclick="window.open('{{$goods_thumb->img_url}}');" src="{{$goods_thumb->img_url}}"
                                         style="width: 50px;height: 50px;">
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_images[]" class="col-sm-2 control-label">商品相册图</label>
                            <div class="col-sm-4">
                                <input type="file" name="goods_images[]" style="float: left">
                                <span style="font-size: 23px; line-height: 17px;cursor:pointer;" onclick="addImgHtml(this);">+</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-4">
                                @foreach($goods_images as $key => $value)
                                    <div style="float: left; padding-right: 5px;">
                                        <img onclick="window.open('{{$value->img_url}}');" src="{{$value->img_url}}" style="width: 50px;height: 50px;">
                                        <span style="cursor:pointer;border: 1px solid #8f8f8f;display: block;float: left;height: 21px; width: 17px;" onclick="delImg(this, '{{$value->id}}');">ㄨ</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                     <!-- /.box-body -->
                    <div class="box-footer" style="text-align: center;">
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
//            if (!$('#market_price').val()) {
//                alert('市场价格不能为空');
//                return false;
//            }
            if (!$('#selling_price').val()) {
                alert('实际价格不能为空');
                return false;
            }
            if (!$('#stock').val()) {
                alert('库存不能为空');
                return false;
            }

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

        function addImgHtml(t) {
            var html = '';
            html += '<div class="form-group" style="margin-bottom: 0px;">';
            html += '<label class="col-sm-2 control-label"></label>';
            html += '<div class="col-sm-4" style="padding-top: 7px;">';
            html += '<input type="file" name="goods_images[]" style="float: left">';
            html += '<span style="font-size: 23px; line-height: 17px;cursor:pointer;" onclick="delImgHtml(this);">-</span>';
            html += '</div>';
            html += '</div>';
            $(t).parents('.form-group').after(html);
        }

        function delImgHtml(t) {
            $(t).parents('.form-group').remove();
        }

        function delImg(t, id) {
            $.post("{{url('admin/goods/delImage')}}", {id: id}, function (data) {
                if (data.error == 0) {
                    alert('删除成功');
                    $(t).parent().remove();
                } else {
                    alert(data.message);
                }
            }, "json");
        }
    </script>
@endsection