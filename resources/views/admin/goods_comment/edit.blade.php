@extends('admin.layouts.index')

@section('title', '商品评价编辑')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        商品评价编辑
        <small>商品评价编辑</small>
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
                            <label for="position_name" class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-4">{{$goodsComment['goods_name']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="position_name" class="col-sm-2 control-label">订单号</label>
                            <div class="col-sm-4">{{$goodsComment['order_sn']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="position_name" class="col-sm-2 control-label">评价人</label>
                            <div class="col-sm-4">{{$goodsComment['member_name']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="position_name" class="col-sm-2 control-label">评价内容</label>
                            <div class="col-sm-4">{{$goodsComment['content']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="position_name" class="col-sm-2 control-label">评价时间</label>
                            <div class="col-sm-4">{{$goodsComment['created_at']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="position_name" class="col-sm-2 control-label">是否显示</label>
                            <div class="col-sm-4">
                                <label class="label label-success"><input type="radio" name="is_show" value="1" @if($goodsComment['is_show'] == 1) checked @endif>是</label>
                                <label class="label label-danger"><input type="radio" name="is_show" value="0" @if($goodsComment['is_show'] == 0) checked @endif>否</label>
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
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
                        window.location.href = '{{url('admin/goodsComment')}}';
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