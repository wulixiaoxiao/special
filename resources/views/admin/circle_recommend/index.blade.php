@extends('admin.layouts.index')

@section('title', '专题分类列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        圈子分类列表
        <small>圈子分类列表</small>
        <button type="button" class="btn btn-success btn-sm pull-right" onclick="javascript:window.location.href='{{url('admin/circle/recommend/add')}}'">增加</button>
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
                            <th>推荐标题</th>
                            <th>分类</th>
                            <th>排序</th>
                            <th>时长</th>
                            <th>封面图片</th>
                            <th>是否显示</th>
                            <th>操作</th>
                        </tr>
                        @if(isset($lists))
                        @foreach($lists as $key => $value)
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="{{$value['id']}}">{{$value['id']}}</label>
                            </td>
                            <td>{{$value['title']}}</td>
                            <td>{{$value['categroy_name']}}</td>
                            <td>{{$value['sort']}}</td>
                            <td>{{$value['length']}}</td>
                            <td><img style="width: 50px" src="{{$value['cover_img']}}"></td>
                            <td>
                                @if($value['is_show'] == 1)
                                    <span class="label label-success">是</span>
                                @else
                                    <span class="label label-danger">否</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs" onclick="window.location.href='{{url('admin/circle/recommend/edit/'.$value['id'])}}'">编辑</button>
                                <button type="button" class="btn btn-danger btn-xs" onclick="del({{$value['id']}})">删除</button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
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
{{--                    {!! with(new \App\Library\PageLibrary($categories))->render() !!}--}}
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
                $.post('{{url('admin/circle/category/del')}}', {'id' : id}, function(data) {
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