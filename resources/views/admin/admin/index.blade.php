@extends('admin.layouts.index')

@section('title', '管理员列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        管理员列表
        <small>管理员列表</small>
        <button type="button" class="btn btn-success btn-sm pull-right" onclick="javascript:window.location.href='{{url('admin/admin/add')}}'">增加</button>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>
                                <label><input type="checkbox" value="" id="check-all">ID</label>
                            </th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th>权限</th>
                            <th>创建时间</th>
                            <th>最后登录时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($admins as $key => $value)
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="{{$value['id']}}">{{$value['id']}}</label>
                            </td>
                            <td>{{$value['admin_name']}}</td>
                            <td>{{$value['admin_nickname']}}</td>
                            <td>{{$value['permissions']}}</td>
                            <td>{{date('Y-m-d H:i:s', $value['create_time'])}}</td>
                            <td>{{date('Y-m-d H:i:s', $value['last_time'])}}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='{{url('admin/admin/edit/'.$value['id'])}}'">编辑</button>
                                @if($value['id'] !=1 && $value['admin_name'] != 'admin')
                                <button type="button" class="btn btn-danger btn-xs" onclick="del({{$value['id']}})">删除</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <!-- /.box-footer -->
                <div class="box-footer clearfix">
                    <span class="pull-left">
                        {{--<button type="button" class="btn btn-warning btn-sm">导出</button>--}}
                        {{--<button type="button" class="btn btn-danger btn-sm">批量删除</button>--}}
                    </span>
                    {!! with(new \App\Library\PageLibrary($admins))->render() !!}
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->

@endsection

@section('css-block')

@endsection

@section('js-block')
    <script>
        // 全选/全不选
        $('#check-all').click(function() {
            $(":checkbox[name='ids[]']").prop('checked', $(this).prop('checked'));
        });
        $(":checkbox[name='ids[]']").click(function() {
            if ($(":checkbox[name='ids[]']:checked").length == $(":checkbox[name='ids[]']").length) {
                $('#check-all').prop('checked', true);
            } else {
                $('#check-all').prop('checked', false);
            }
        });

        // 删除
        function del(id) {
            if (!id) {
                return false;
            }
            if (confirm('删除后不可恢复,确定要删除吗?')) {
                $.post('{{url('admin/admin/del')}}', {'id' : id}, function(data) {
                    if (data.error == 0) {
                        alert('删除成功');
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                }, 'json');
            }
        }
    </script>
@endsection