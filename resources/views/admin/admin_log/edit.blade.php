@extends('admin.layouts.index')

@section('title', '管理日志详情')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        管理日志详情
        <small>管理日志详情</small>
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
                            <label for="admin_name" class="col-sm-2 control-label">操作人</label>
                            <div class="col-sm-4">
                                {{$adminLog['admin_name']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="admin_name" class="col-sm-2 control-label">日志描述</label>
                            <div class="col-sm-4">
                                {{$adminLog['description']}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="admin_nickname" class="col-sm-2 control-label">sql语句</label>
                            <div class="col-sm-4">
                                <textarea class="form-control" rows="5" readonly>{{$adminLog['sql']}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="admin_name" class="col-sm-2 control-label">操作时间</label>
                            <div class="col-sm-4">
                                {{$adminLog['created_at']}}
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
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

    </script>
@endsection