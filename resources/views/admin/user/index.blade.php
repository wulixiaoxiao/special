@extends('admin.layouts.index')

@section('title', '首页')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        会员列表
        <small>会员列表</small>
        <button type="button" class="btn btn-success btn-sm pull-right">增加</button>
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
                        <label>搜索:&nbsp;&nbsp;</label><input type="text" name="search" class="form-control"/>
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
                            <th>用户</th>
                            <th>日期</th>
                            <th>状态</th>
                            <th>描述</th>
                            <th>操作</th>
                        </tr>
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="183">183</label>
                            </td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-success">Approved</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs">详情</button>
                                <button type="button" class="btn btn-danger btn-xs">删除</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="219">219</label>
                            </td>
                            <td>Alexander Pierce</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-warning">Pending</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs">详情</button>
                                <button type="button" class="btn btn-danger btn-xs">删除</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="657">657</label>
                            </td>
                            <td>Bob Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-primary">Approved</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs">详情</button>
                                <button type="button" class="btn btn-danger btn-xs">删除</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label><input type="checkbox" name="ids[]" value="175">175</label>
                            </td>
                            <td>Mike Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-danger">Denied</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                            <td>
                                <button type="button" class="btn btn-info btn-xs">详情</button>
                                <button type="button" class="btn btn-danger btn-xs">删除</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <!-- /.box-footer -->
                <div class="box-footer clearfix">
                    <span class="pull-left">
                        <button type="button" class="btn btn-warning btn-sm">导出</button>
                        <button type="button" class="btn btn-danger btn-sm">批量删除</button>
                    </span>
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li><a href="#">«</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">»</a></li>
                    </ul>
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
    </script>
@endsection