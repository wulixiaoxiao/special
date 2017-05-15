@extends('admin.layouts.index')

@section('title', '专题添加')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        专题添加
        <small>专题添加</small>
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
                            <label for="goods_name" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-4">
                                <input type="text" name="title" id="title" class="form-control" placeholder="标题">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_name" class="col-sm-2 control-label">副标题</label>
                            <div class="col-sm-4">
                                <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="副标题">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_name" class="col-sm-2 control-label">专题描述</label>
                            <div class="col-sm-4">
                                <textarea name="description" placeholder="" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_name" class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-4">
                                <input type="text" name="sort_order" id="sort_order" class="form-control" placeholder="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_category" class="col-sm-2 control-label">所属分类</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="category_id" id="category_id">
                                    @foreach($categories as $key => $value)
                                    <option value="{{$value['id']}}">{{$value['category_name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_online" class="col-sm-2 control-label">是否推荐</label>
                            <div class="col-sm-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" name="is_recommend" value="1" > 是
                                    </label>
                                    <label>
                                        <input type="radio" name="is_recommend" value="0" checked> 否
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_online" class="col-sm-2 control-label">关联商品</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="goods[]" id="goodsList">
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="search" class="form-control" placeholder="输入商品名称搜索">
                                <input type="button" value="搜索" onclick="searchGoods()">
                                <input type="button" value="确认添加" onclick="addGoods()">
                            </div>
                            <div id="selGoods">

                            </div>
                        </div>

                        <br>
                        {{--------------------------------------------------}}
                        <div id="seltext">
                            -----------------------------------------------------------------------------------------------------------------------------------------------------

                            <div id="addtag0">
                                <div class="form-group">
                                    <label for="is_online" class="col-sm-2 control-label">类型</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="type[]">
                                                <option value="1" selected>图片</option>
                                                <option value="2">视频</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="sontext">
                                    <div class="form-group">
                                        <label for="videofile" class="col-sm-2 control-label">文件</label>
                                        <div class="col-sm-4">
                                            <input type="file" name="videofile[]" style="float: left">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="goods_detail" class="col-sm-2 control-label">内容</label>
                                        <div class="col-sm-4">
                                            <textarea name="content[]"  class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="goods_detail" class="col-sm-2 control-label">内容排序</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="sort[]" class="form-control" placeholder="0">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <label for="videofile" class="col-sm-2 control-label"></label>
                                            <div class="col-sm-4">
                                                <input type="button" value="删除" onclick="deltext(0)" style="float: left">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            -----------------------------------------------------------------------------------------------------------------------------------------------------
                        </div>
                        {{--------------------------------------------------}}
                        <div>
                            <div class="form-group">
                                <label for="videofile" class="col-sm-2 control-label"></label>
                                <div class="col-sm-4">
                                    <input type="button" value="增加" onclick="addtext()" style="float: left">
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
    <link href="{{url('assets/admin/ueditor/themes/default/css/umeditor.css')}}" type="text/css" rel="stylesheet">
@endsection

@section('js-block')
    <script type="text/javascript" charset="utf-8" src="{{url('assets/admin/ueditor/umeditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{url('assets/admin/ueditor/umeditor.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/admin/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script>

        function searchGoods() {
            var search = $("#search").val();
            $.post('{{url('admin/search_goods')}}', {search:search}, function (data) {
                if (data.error == 0) {
                    var obj = $('#goodsList');
                    var str = '';
                    var res = data.data;
                    for (var i=0; i<res.length; i++) {
                        str += '<option value="'+res[i].id+'">'+res[i].goods_name+'</option>';
                    }
                    obj.html(str);
                }else{
                    alert('暂无商品')
                }

            }, 'json');

        }

        $.post('{{url('admin/get_goods')}}', {}, function (data) {

            var obj = $('#goodsList');
            var str = '';
            var res = data.data;
            for (var i=0; i<res.length; i++) {
                str += '<option value="'+res[i].id+'">'+res[i].goods_name+'</option>';
            }
            obj.html(str);
        }, 'json');

        function addGoods(){
            var obj = $('#goodsList');
            var val = obj.val();
            var name = $("#goodsList option[value='"+obj.val()+"']").html();

            var str = '<div id="selGoods'+val+'">\
                    <input type="hidden" value="'+val+'" name="goods[]" readonly>\
                    <a href="javascript:;" onclick="delGoods('+val+')">'+name+'</a>\
                    </div>';
            $('#selGoods').append(str);
        }

        function delGoods(val){
            $('#selGoods'+val).remove();
        }


        var sel_id = 1;
        function addtext(){
            var obj = $('#seltext');
            var str = '<div id="addtag'+sel_id+'">\
                <div class="form-group">\
                <label for="is_online" class="col-sm-2 control-label">类型</label>\
                <div class="col-sm-2">\
                <select class="form-control" name="type[]">\
                <option value="1" selected>图片</option>\
            <option value="2">视频</option>\
                </select>\
                </div>\
                </div>\
                <div class="sontext">\
                <div class="form-group">\
                <label for="videofile" class="col-sm-2 control-label">文件</label>\
                <div class="col-sm-4">\
                <input type="file" name="videofile[]" style="float: left">\
                </div>\
                </div>\
                <div class="form-group">\
                <label for="goods_detail" class="col-sm-2 control-label">内容</label>\
                <div class="col-sm-4">\
                <textarea name="content[]"  class="form-control"></textarea>\
                </div>\
                </div>\
                <div class="form-group">\
                <label for="goods_detail" class="col-sm-2 control-label">内容排序</label>\
                <div class="col-sm-4">\
                <input type="text" name="sort[]" class="form-control" placeholder="0">\
                </div>\
                </div>\
                <div>\
                <div class="form-group">\
                <label for="videofile" class="col-sm-2 control-label"></label>\
                <div class="col-sm-4">\
                <input type="button" value="删除" onclick="deltext('+sel_id+')" style="float: left">\
                </div>\
                </div>\
                </div>\
                </div>\
                <br>\
-----------------------------------------------------------------------------------------------------------------------------------------------------\
                </div>';
            obj.append(str);
            sel_id++;
        }

        function deltext(obj){
            $('#addtag'+obj).remove();
        }
    </script>

    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var um = UM.getEditor('special_detail');
    </script>

    <script>
        $('#form-add').submit(function(){
            if($('#title').val() == ''){
                alert('请填写标题！');
                $('#title').focus();
                return false;
            }

            var options = {
                type: 'post',
                success: function (data) {
                    if (data.error == 0) {
                        alert('添加成功');
                        window.location.href = '{{url('admin/special/index')}}';
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