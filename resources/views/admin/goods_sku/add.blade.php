@extends('admin.layouts.index')

@section('title', '商品SKU添加')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        商品SKU添加
        <small>商品SKU添加</small>
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
                <form class="form-horizontal" method="post" enctype="application/x-www-form-urlencoded" id="form-add">
                    {{csrf_field()}}
                    <input type="hidden" name="goods_id" id="goods_id" value="{{$goods->id}}">
                    <input type="hidden" name="sku_id_str" id="sku_id_str" value="">
                    <input type="hidden" name="sku_value_str" id="sku_value_str" value="">
                    <div class="box-body">
                        @if(count($skus))
                            @foreach($skus as $key => $value)
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">{{$value->sku_name}}</label>
                                    <div class="col-sm-4">
                                        {{--<div class="checkbox">--}}
                                            {{--@foreach($value->skuValue as $k => $v)--}}
                                            {{--<label>--}}
                                                {{--<input type="radio" name="sku_{{$value->id}}" value="{{$v->id}}"> {{$v->sku_value_name}}--}}
                                            {{--</label>--}}
                                            {{--@endforeach--}}
                                        {{--</div>--}}

                                        <div>
                                            <select name="sku_{{$value->id}}">
                                                @foreach($value->skuValue as $k => $v)
                                                    <option value="{{$v->id}}">{{$v->sku_value_name}}</option>
                                                @endforeach
                                            </select>
                                            <input id="sku_{{$value->id}}" type="text" placeholder="搜索">
                                            <input type="button" value="搜索" onclick="search('sku_{{$value->id}}',{{$value->id}})">
                                        </div>
                                    </div>
                            </div>
                            @endforeach
                        @else
                            <label>该商品暂时没有关联SKU,请添加</label>
                        @endif

                            <div class="form-group">
                                <label for="market_price" class="col-sm-2 control-label">市场价格</label>
                                <div class="col-sm-4">
                                    <input type="text" name="market_price" id="market_price" class="form-control" placeholder="市场价格">
                                </div>
                                <div class="col-sm-4">
                                    {{--<span style="color: red;">* 必填</span>--}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="selling_price" class="col-sm-2 control-label">实际价格</label>
                                <div class="col-sm-4">
                                    <input type="text" name="selling_price" id="selling_price" class="form-control" placeholder="实际价格">
                                </div>
                                <div class="col-sm-4">
                                    <span style="color: red;">* 必填</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="stock" class="col-sm-2 control-label">库存</label>
                                <div class="col-sm-4">
                                    <input type="text" name="stock" id="stock" class="form-control" placeholder="库存">
                                </div>
                                <div class="col-sm-4">
                                    <span style="color: red;">* 必填</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="thumb" class="col-sm-2 control-label">商品缩略图</label>
                                <div class="col-sm-4">
                                    <input type="file" name="thumb" id="thumb" class="form-control">
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
                    </div>
                    @if(count($skus))
                    <!-- /.box-body -->
                    <div class="box-footer" style="text-align: center;">
                        <button type="submit" class="btn btn-primary"> 确定</button>
                    </div>
                    <!-- /.box-footer -->
                    @endif
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
        function search(idtag,id) {
            var sea = $('#'+idtag).val();
            $.get('/admin/goods_sku/getsku','idtag='+idtag+'&id='+id+'&sea='+sea,function(res){
                var str = '';
                for(var i = 0; i<res.data.length; i++){
                    str += '<option value="'+res.data[i].id+'">'+res.data[i].sku_value_name+'</option>';
                }
                $("select[name='"+idtag+"']").html('');

                $("select[name='"+idtag+"']").html(str);
            },'json');
        }



        var goods_id = {{$goods->id}};
        var sku_ids = {!! $skuIds->toJson() !!};
        $('#form-add').submit(function(){
            if (!checkGoodsSku()) {
                return false;
            }
            var options = {
                type: 'post',
                success: function (data) {
                    if (data.error == 0) {
                        alert('添加成功');
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                }
            };
            $(this).ajaxSubmit(options);
            return false;
        });

        function checkGoodsSku() {
            var sku_id_str = '';
            var sku_value_str = '';
            for(var i in sku_ids) {
                if ($("select[name=sku_"+sku_ids[i]+"]").val()) {
                    sku_id_str += sku_ids[i] + ',';
                    sku_value_str += $("select[name=sku_"+sku_ids[i]+"]").val() + ',';
                }
            }
            if (!sku_value_str) {
                alert('请选择SKU可选项');
                return false;
            }
            sku_id_str = sku_id_str.substr(0, (sku_id_str.length-1));
            sku_value_str = sku_value_str.substr(0, (sku_value_str.length-1));
            $('#sku_id_str').val(sku_id_str);
            $('#sku_value_str').val(sku_value_str);
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
            return true;
        }

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
    </script>
@endsection