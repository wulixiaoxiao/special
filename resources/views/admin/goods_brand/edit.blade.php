@extends('admin.layouts.index')

@section('title', '商品品牌编辑')

@section('content')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        商品品牌编辑
        <small>商品品牌编辑</small>
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
                            <label for="admin_name" class="col-sm-2 control-label">品牌名称</label>
                            <div class="col-sm-4">
                                <input type="text" name="goods_brand_name" id="goods_brand_name" class="form-control" placeholder="品牌名称" value="{{$brand['goods_brand_name']}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="admin_name" class="col-sm-2 control-label">品牌描述</label>
                            <div class="col-sm-4">
                                <input type="text" name="description" id="description" class="form-control" placeholder="品牌描述" value="{{$brand['description']}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="admin_nickname" class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-4">
                                <input type="text" name="sort_order" id="sort_order" class="form-control" id="inputPassword3" placeholder="排序" value="{{$brand['sort_order']}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="admin_nickname" class="col-sm-2 control-label">品牌LOGO</label>
                            <div class="col-sm-4">
                                <input type="file" name="cateImg" class="form-control">
                            </div>
                            <img style="width: 50px;height: 50px;" src="{{$brand['logo']}}">
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">是否显示</label>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" name="is_show" value="1" @if($brand['is_show'] == 1) checked @endif> 是
                                    </label>
                                    <label>
                                        <input type="radio" name="is_show" value="0" @if($brand['is_show'] == 0) checked @endif> 否
                                    </label>
                                </div>
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
            var options = {
                type: 'post',
                success: function (data) {
                    if (data.error == 0) {
                        alert('编辑成功');
                        window.location.href = '{{url('admin/goodsBrand')}}';
                    } else {
                        alert(data.message);
                    }
                }
            };
            $(this).ajaxSubmit(options);
            return false;
        });
    </script>
@endsection