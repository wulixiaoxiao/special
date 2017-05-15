@extends('admin.layouts.index')

@section('title', '首页推荐添加')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            首页推荐添加
            <small>首页推荐添加</small>
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
                                <label for="admin_name" class="col-sm-2 control-label">标题</label>
                                <div class="col-sm-4">
                                    <input type="text" name="title" value="{{$data['title']}}" class="form-control" placeholder="标题">
                                </div>
                                <div class="col-sm-4">
                                    <span style="color: red;">* 必填</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="admin_nickname" class="col-sm-2 control-label">排序</label>
                                <div class="col-sm-4">
                                    <input type="text" name="sort" value="{{$data['sort']}}" class="form-control" id="inputPassword3" placeholder="排序">
                                </div>
                                <div class="col-sm-4">
                                    <span style="color: red;"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="admin_nickname" class="col-sm-2 control-label">封面图片</label>
                                <div class="col-sm-4">
                                    <input type="file" name="img" class="form-control">
                                    <img style="width: 100px" src="{{$data['cover_img']}}">
                                </div>
                                <div class="col-sm-4">
                                    <span style="color: red;"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">是否显示</label>
                                <div class="col-sm-4">
                                    <div class="checkbox">
                                        <label>

                                            <input type="radio" name="is_show" value="1" <?php echo $data['is_show']==1?'checked':'';?>> 是
                                        </label>
                                        <label>
                                            <input type="radio" name="is_show" value="0" <?php echo $data['is_show']==0?'checked':'';?>> 否
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="goods_category" class="col-sm-2 control-label">选择已发布的圈子</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="circle_id" id="circle_list">
                                        @foreach($lists as $key => $value)
                                            <option value="{{$value['id']}}"  <?php echo $data['circle_id'] == $value['id']?'selected':'';?>>{{$data['circle_id']}}{{$value['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-1">
                                    <input type="text" name="img_url" class="form-control" oninput="searchCircle(this.value)" placeholder="搜索">
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
        function searchCircle(val){
            $.post('{{url('admin/circle/recommend/searchCircle')}}', {search:val}, function (data) {
                if (data.error == 0){
                    var data = data.data;
                    var str = '';
                    for (var i=0; i<data.length; i++) {
                        str += '<option value="'+data[i].id+'">'+data[i].title+'</option>'
                    }
                    $('#circle_list').html(str);
                    return false;
                }
                alert('修改失败，请重试')
            }, 'json');

        }

        $('#form-add').submit(function(){
            var options = {
                type: 'post',
                success: function (data) {
                    if (data.error == 0) {
                        alert('修改成功');
                        window.location.href = '{{url('admin/circle/recommend')}}';
                    } else {
                        alert('修改失败');
                    }
                }
            };
            $(this).ajaxSubmit(options);
            return false;
        });
    </script>
@endsection