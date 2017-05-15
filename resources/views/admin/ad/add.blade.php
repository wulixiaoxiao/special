@extends('admin.layouts.index')

@section('title', '广告添加')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        广告添加
        <small>广告添加</small>
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
                    <div class="box-body">
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-4">
                                <input type="text" name="ad_name" id="ad_name" class="form-control" placeholder="名称">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_position_id" class="col-sm-2 control-label">广告位置</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="ad_position_id" id="ad_position_id">
                                    <option value="0">请选择</option>
                                    @foreach($adPositionList as $key => $value)
                                    <option value="{{$value['id']}}">{{$value['position_name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="label label-danger"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-4">
                                <input type="text" name="title" id="title" class="form-control" placeholder="标题">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pic" class="col-sm-2 control-label">广告图片</label>
                            <div class="col-sm-4">
                                <input type="file" name="pic" id="pic" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="link" class="col-sm-2 control-label">广告链接</label>
                            <div class="col-sm-4">
                                <input type="text" name="link" id="link" class="form-control" placeholder="广告链接">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sort_order" class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-4">
                                <input type="text" name="sort_order" id="sort_order" class="form-control" placeholder="排序">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_show" class="col-sm-2 control-label">是否显示</label>
                            <div class="col-sm-4">
                                <label>
                                    <input type="radio" name="is_show" value="1" checked> 是
                                </label>
                                <label>
                                    <input type="radio" name="is_show" value="0"> 否
                                </label>
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
        $('#form-add').submit(function(){
            var options = {
                type: 'post',
                success: function (data) {
                    if (data.error == 0) {
                        alert('添加成功');
                        window.location.href = '{{url('admin/ad')}}';
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