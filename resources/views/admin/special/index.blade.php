@extends('admin.layouts.index')

@section('title', '专题列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        专题列表
        <small>专题列表</small>
        <button type="button" class="btn btn-success btn-sm pull-right" onclick="javascript:window.location.href='{{url('admin/special/add')}}'">增加</button>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <form class="form-horizontal form-inline form-group-sm" method="post" enctype="application/x-www-form-urlencoded">
                        {{csrf_field()}}
                        <label>搜索:&nbsp;&nbsp;</label><input type="text" name="search" class="form-control" value=""/>
                        <button type="submit" class="btn btn-primary btn-sm">搜索</button>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>
                                <label><input type="checkbox" value="" id="check-all">ID</label>
                            </th>
                            <th>专题标题</th>
                            <th>分类</th>
                            <th>是否推荐</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($lists as $key => $value)
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="{{$value['id']}}">{{$value['id']}}</label>
                            </td>
                            <td>{{$value['title']}}</td>
                            <td>{{$value['sort_order']}}</td>
                            <td>
                                @if($value['is_recommend'] == 1)
                                    <input type="checkbox" checked onclick="changeRec(0,{{$value['id']}})">
                                @else
                                    <input type="checkbox" onclick="changeRec(1,{{$value['id']}})">
                                @endif
                            </td>
                            <td>{{$value['created_at']}}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='{{url('admin/special/edit/'.$value['id'])}}'">编辑</button>
                                <button type="button" class="btn btn-danger btn-xs" onclick="del({{$value['id']}})">删除</button>
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
                    {{--{!! with(new \App\Library\PageLibrary($goods))->render() !!}--}}
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
        function changeRec(tag,sid) {
            $.post('/admin/goods/changerec',{tag:tag,sid:sid},function(res){
                console.log(res.error);
                if(res.error == 0){
                    alert(res.message);
                }else{
                    alert(res.message);
                }
            },'json');
        }

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
                $.post('{{url('admin/special/del')}}', {'id' : id}, function(data) {
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