@extends('admin.layouts.index')

@section('title', '系统配置列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        系统配置列表
        <small>系统配置列表</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <!-- form start -->
                <form class="form-horizontal" method="post" enctype="application/x-www-form-urlencoded" id="form-edit">
                    {{csrf_field()}}
                    <div class="box-body">
                        @foreach($configs as $key => $value)
                        <div class="form-group">
                            <label for="{{$value['config_name']}}" class="col-sm-2 control-label">{{$configLabels[$value['config_name']]}}</label>
                            <div class="col-sm-4">
                                <input type="text" name="{{$value['config_name']}}" id="{{$value['config_name']}}" class="form-control" placeholder="{{$configLabels[$value['config_name']]}}" value="{{$value['config_value']}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 选填</span>
                            </div>
                        </div>
                        @endforeach
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