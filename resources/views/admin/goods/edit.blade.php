@extends('admin.layouts.index')

@section('title', '商品编辑')

@section('content')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        商品编辑
        <small>商品编辑</small>
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
                            <label for="goods_name" class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-4">
                                <input type="text" name="goods_name" id="goods_name" class="form-control" value="{{$goods->goods_name}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_category" class="col-sm-2 control-label">所属分类</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="goods_category" id="goods_category">
                                    <option value="">请选择...</option>
                                    @foreach($categories as $key => $value)
                                        <option value="{{$value['id']}}" @if($goods->goods_category_id == $value['id']) selected @endif>{{$value['goods_category_name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_brand" class="col-sm-2 control-label">所属品牌</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="goods_brand" id="goods_brand">
                                    <option value="">请选择...</option>
                                    @foreach($brands as $key => $value)
                                        <option value="{{$value['id']}}" @if($goods->goods_brand_id == $value['id']) selected @endif>{{$value['goods_brand_name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">商品描述</label>
                            <div class="col-sm-4">
                                <input type="text" name="description" id="description" class="form-control" value="{{$goods->goods_description}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tag" class="col-sm-2 control-label">商品标签</label>
                            <div class="col-sm-4">
                                <input type="text" name="tag" id="tag" class="form-control" value="{{$goods->tag}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">英文逗号隔开,例:艺术,滑板,生活</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_weight" class="col-sm-2 control-label">重量(kg)</label>
                            <div class="col-sm-4">
                                <input type="text" name="goods_weight" id="goods_weight" class="form-control" value="{{$goods->goods_weight}}">
                            </div>
                            <div class="col-sm-4">
                                {{--<span style="color: red;">* 必填</span>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_margin" class="col-sm-2 control-label">毛利(元)</label>
                            <div class="col-sm-4">
                                <input type="text" name="goods_margin" id="goods_margin" class="form-control" value="{{$goods->goods_margin}}">
                            </div>
                            <div class="col-sm-4">
                                {{--<span style="color: red;">* 必填</span>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="market_price" class="col-sm-2 control-label">市场价格(元)</label>
                            <div class="col-sm-4">
                                <input type="text" name="market_price" id="market_price" class="form-control" value="{{$goods->market_price}}">
                            </div>
                            <div class="col-sm-4">
                                {{--<span style="color: red;">* 必填</span>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="selling_price" class="col-sm-2 control-label">实际价格(元)</label>
                            <div class="col-sm-4">
                                <input type="text" name="selling_price" id="selling_price" class="form-control" value="{{$goods->selling_price}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stock" class="col-sm-2 control-label">库存数</label>
                            <div class="col-sm-4">
                                <input type="text" name="stock" id="stock" class="form-control" value="{{$goods->stock}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sort_order" class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-4">
                                <input type="text" name="sort_order" id="sort_order" class="form-control" value="{{$goods->sort_order}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_free_shipping" class="col-sm-2 control-label">是否包邮</label>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" name="is_free_shipping" value="1" @if($goods->is_free_shipping == 1) checked @endif> 是
                                    </label>
                                    <label>
                                        <input type="radio" name="is_free_shipping" value="0" @if($goods->is_free_shipping == 0) checked @endif> 否
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_online" class="col-sm-2 control-label">是否上架</label>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" name="is_online" value="1" @if($goods->is_online == 1) checked @endif> 是
                                    </label>
                                    <label>
                                        <input type="radio" name="is_online" value="0" @if($goods->is_online == 0) checked @endif> 否
                                    </label>
                                </div>
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
                        <div class="form-group">
                            <label for="goods_detail" class="col-sm-2 control-label">商品详情</label>
                            <div class="col-sm-4">
                                <textarea style="width: 500px;" id="goods_detail" name="goods_detail" type="text/plain">{!! $goods->goods_detail !!}</textarea>
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
    <link href="{{url('assets/admin/ueditor/themes/default/css/umeditor.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('js-block')
    <script type="text/javascript" charset="utf-8" src="{{url('assets/admin/ueditor/umeditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{url('assets/admin/ueditor/umeditor.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/admin/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var um = UM.getEditor('goods_detail');
    </script>

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