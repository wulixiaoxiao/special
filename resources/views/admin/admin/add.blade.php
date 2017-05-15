@extends('admin.layouts.index')

@section('title', '管理员添加')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        管理员添加
        <small>管理员添加</small>
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
                            <label for="admin_name" class="col-sm-2 control-label">管理员账号</label>
                            <div class="col-sm-4">
                                <input type="text" name="admin_name" id="admin_name" class="form-control" placeholder="管理员账号">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">管理员密码</label>
                            <div class="col-sm-4">
                                <input type="password" name="password" id="password" class="form-control" id="inputPassword3" placeholder="管理员密码">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="admin_nickname" class="col-sm-2 control-label">管理员昵称</label>
                            <div class="col-sm-4">
                                <input type="text" name="admin_nickname" id="admin_nickname" class="form-control" id="inputPassword3" placeholder="管理员昵称">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">权限</label>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    @foreach(\App\Helper\Menu::getInstance()->getPermissions() as $key => $value)
                                    <label>
                                        <input type="checkbox" name="permissions[]" value="{{$key}}"> {{$value}}
                                    </label>
                                    @endforeach
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
        $('#form-add').submit(function(){
            var options = {
                type: 'post',
                success: function (data) {
                    if (data.error == 0) {
                        alert('添加成功');
                        window.location.href = '{{url('admin/admin')}}';
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