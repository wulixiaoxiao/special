@extends('admin.layouts.index')

@section('title', '专题编辑')

@section('content')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        专题编辑
        <small>专题编辑</small>
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
                            <label for="goods_name" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-4">
                                <input type="text" name="title" id="title" class="form-control" value="{{$special->title}}">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_name" class="col-sm-2 control-label">副标题</label>
                            <div class="col-sm-4">
                                <input type="text" name="subtitle" value="{{$special->subtitle}}" id="subtitle" class="form-control" placeholder="副标题">
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_name" class="col-sm-2 control-label">专题描述</label>
                            <div class="col-sm-4">
                                <textarea name="description" placeholder="" rows="3" class="form-control">{{$special->description}}</textarea>
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;">* 必填</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_name" class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-4">
                                <input type="text" name="sort_order" value="{{$special->sort_order}}" id="sort_order" class="form-control" placeholder="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goods_category" class="col-sm-2 control-label">所属分类</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="category_id" id="category_id">
                                    <option value="">请选择...</option>
                                    @foreach($categories as $key => $value)
                                        <option value="{{$value['id']}}" @if($special->category_id == $value['id']) selected @endif>{{$value['category_name']}}</option>
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
                                        <input type="radio" name="is_recommend" value="1" @if($special->is_recommend == 1) checked @endif> 是
                                    </label>
                                    <label>
                                        <input type="radio" name="is_recommend" value="0" @if($special->is_recommend == 0) checked @endif> 否
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
                                @if($selGoods)
                                    @foreach($selGoods as $v)
                                        <div id="selGoods{{$v['id']}}">
                                            <input type="hidden" value="{{$v['id']}}" name="goods[]" readonly>
                                            <a href="javascript:;" onclick="delGoods({{$v['id']}})">{{$v['goods_name']}}</a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <br>
                        {{--------------------------------------------------}}
                        <div id="seltext">
                            -----------------------------------------------------------------------------------------------------------------------------------------------------

                        @if($specialContents)
                            @foreach($specialContents as $k => $v)
                                <div id="addtag{{$k}}">
                                    <input type="hidden" name="id[]" value="{{$v['id']}}">
                                    <div class="form-group">
                                        <label for="is_online" class="col-sm-2 control-label">类型</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="type[{{$v['id']}}]">
                                                <option value="1" @if($v['type'] == 1) selected @endif>图片</option>
                                                <option value="2" @if($v['type'] == 2) selected @endif>视频</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="sontext">
                                        <div class="form-group">
                                            <label for="videofile" class="col-sm-2 control-label">文件</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="videofile[{{$v['id']}}]" style="float: left">
                                                @if($v['type'] == 1)
                                                    <img style="width: 100px;float: left" src="{{$v['filePath']}}">
                                                @else
                                                    <embed src="{{$v['filePath']}}" height="200" width="200">
                                                @endif

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="goods_detail" class="col-sm-2 control-label">内容</label>
                                            <div class="col-sm-4">
                                                <textarea style="width: 500px;" name="content[{{$v['id']}}]" type="text/plain">{{$v['content']}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="goods_detail" class="col-sm-2 control-label">内容排序</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="sort[{{$v['id']}}]" value="{{$v['sort']}}" class="form-control" placeholder="0">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-group">
                                                <label for="videofile" class="col-sm-2 control-label"></label>
                                                <div class="col-sm-4">
                                                    <input type="button" value="删除" onclick="deltext({{$k}},{{$v['id']}})" style="float: left">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    -----------------------------------------------------------------------------------------------------------------------------------------------------
                                </div>
                            @endforeach
                            @endif
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
                        {{--------------------------------------------------}}
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


        var sel_id = {{count($specialContents)}};
        var maxid = {{max(array_column($specialContents,'id')?array_column($specialContents,'id'):[0])}};
        function addtext(){
            var obj = $('#seltext');
            var str = '<div id="addtag'+sel_id+'">\
                <input type="hidden" name="id[]" value="-1">\
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
                <input type="file" name="videofile['+(maxid+1)+']" style="float: left">\
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
                <input type="button" value="删除" onclick="deltext('+sel_id+',-1)" style="float: left">\
                </div>\
                </div>\
                </div>\
                </div>\
                                            -----------------------------------------------------------------------------------------------------------------------------------------------------\
                <br>\
                </div>';
            obj.append(str);
            maxid++;
            sel_id++;
        }

        function deltext(k, id){
            $.post('{{url('admin/special/delcon')}}', {'id':id}, function(data){
                if (data.error == 0) {
                    $('#addtag'+k).remove();
                }else{
                    alert(data.message);
                }
            }, 'json');
//
        }
    </script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var um = UM.getEditor('goods_detail');
    </script>

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

        function addImgHtml(t) {
            var html = '';
            html += '<div class="form-group" style="margin-bottom: 0px;">';
            html += '<label class="col-sm-2 control-label"></label>';
            html += '<div class="col-sm-4" style="padding-top: 7px;">';
            html += '<input type="file" name="goods_images[]" style="float: left">';
            html += '<span style="font-size: 23px; line-height: 17px;cursor:pointer;" onclick="delImgHtml(this);">-</span>';
            html += '</div>';
            html += '</div>';
            $(t).parents('.form-group').after(html);
        }
        function delImgHtml(t) {
            $(t).parents('.form-group').remove();
        }
        function delImg(t, id) {
            $.post("{{url('admin/goods/delImage')}}", {id: id}, function (data) {
                if (data.error == 0) {
                    alert('删除成功');
                    $(t).parent().remove();
                } else {
                    alert(data.message);
                }
            }, "json");
        }
    </script>
@endsection