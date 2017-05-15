@extends('admin.layouts.index')

@section('title', '首页')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        会员添加
        <small>会员添加</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="#">会员管理</a></li>
        <li class="active">会员添加</li>
    </ol>
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
                <form class="form-horizontal" method="post" enctype="application/x-www-form-urlencoded">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                            <div class="col-sm-4">
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                            </div>
                            <div class="col-sm-4">
                                <label class="label label-danger">email不能为空</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>

                            <div class="col-sm-4">
                                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                            </div>

                            <div class="col-sm-4">
                                <label class="label label-danger">密码不能为空</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">地区</label>

                            <div class="col-sm-4">
                                <select class="form-control">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                    <option>option 5</option>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="label label-danger"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">性别</label>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" name="sex" value="1"> 男
                                    </label>
                                    <label>
                                        <input type="radio" name="sex" value="2"> 女
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer" style="text-align: center;">
                        <button type="button" class="btn btn-primary ajax"> 确定</button>
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
        $('.ajax').click(function(){
            $.get({url: '#', success: function(result){
                $('.ajax-content').html('<hr>Ajax Request Completed !');
            }});
        });
    </script>
@endsection