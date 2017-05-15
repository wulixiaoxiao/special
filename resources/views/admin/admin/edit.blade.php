@extends('admin.layouts.index')

@section('title', '管理员编辑')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        管理员编辑
        <small>管理员编辑</small>
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
                            <label for="admin_name" class="col-sm-2 control-label">管理员账号</label>
                            <div class="col-sm-4">
                                <input type="text" name="admin_name" id="admin_name" class="form-control" placeholder="管理员账号" value="{{$admin['admin_name']}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">管理员密码</label>
                            <div class="col-sm-4">
                                <input type="password" name="password" id="password" class="form-control" id="inputPassword3" placeholder="管理员密码" readonly ondblclick="javascript:$(this).removeAttr('readonly');">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填,双击可修改,为空则不修改</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="admin_nickname" class="col-sm-2 control-label">管理员昵称</label>
                            <div class="col-sm-4">
                                <input type="text" name="admin_nickname" id="admin_nickname" class="form-control" id="inputPassword3" placeholder="管理员昵称" value="{{$admin['admin_nickname']}}">
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
                                            <input type="checkbox" name="permissions[]" value="{{$key}}" @if(in_array($key, (!empty($admin->permissions) ? explode(',', $admin->permissions) : []))) checked @endif> {{$value}}
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
    </script>
@endsection