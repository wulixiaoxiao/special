<?php
use App\Helper\CommonHelper;
?>
@extends('admin.layouts.index')

@section('title', '退货编辑')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        退货编辑
        <small>退货编辑</small>
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
                            <label for="ad_name" class="col-sm-2 control-label">服务单号</label>
                            <div class="col-sm-4">{{$backGoods['service_number']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">订单号</label>
                            <div class="col-sm-4">{{$backGoods['order_sn']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">申请人</label>
                            <div class="col-sm-4">{{$backGoods['member_name']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-4">{{$backGoods['goods_name']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">退货数量</label>
                            <div class="col-sm-4">{{$backGoods['goods_number']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">退货状态</label>
                            <div class="col-sm-4">
                                @if($backGoods['status'] == 1)
                                    <span class="label label-danger">{{$backGoods['status_text']}}</span>
                                @elseif($backGoods['status'] == 2)
                                    <span class="label label-warning">{{$backGoods['status_text']}}</span>
                                @elseif($backGoods['status'] == 3)
                                    <span class="label label-default">{{$backGoods['status_text']}}</span>
                                @elseif($backGoods['status'] == 4)
                                    <span class="label label-primary">{{$backGoods['status_text']}}</span>
                                @elseif($backGoods['status'] == 5)
                                    <span class="label label-success">{{$backGoods['status_text']}}</span>
                                @elseif($backGoods['status'] == 6)
                                    <span>{{$backGoods['status_text']}}</span>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">申请时间</label>
                            <div class="col-sm-4">{{date('Y-m-d H:i:s', $backGoods['apply_time'])}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">问题描述</label>
                            <div class="col-sm-4">{{$backGoods['question']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">图片</label>
                            <div class="col-sm-4">
                                @foreach($backGoods['pic'] as $key => $value)
                                    <img src="{{$value}}" alt="" onclick="window.open('{{$value}}')" style="width: 100px;height: 100px;">
                                @endforeach
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">审核人</label>
                            <div class="col-sm-4">{{$backGoods['admin_name']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">最新审核留言</label>
                            <div class="col-sm-4">{{$backGoods['status_note']}}</div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>

                        @if($backGoods['status'] == 1)
                            <div class="form-group">
                                <label for="ad_name" class="col-sm-2 control-label">审核状态</label>
                                <div class="col-sm-4">
                                    <label><input type="radio" name="status" value="2"/>审核通过，请寄送快递</label><br/>
                                    <label><input type="radio" name="status" value="3"/>审核不通过</label><br/>
                                </div>
                                <div class="col-sm-4">
                                    <span style="color: red;"></span>
                                </div>
                            </div>
                        @elseif($backGoods['status'] == 2)
                             <div class="form-group">
                                 <label for="ad_name" class="col-sm-2 control-label">审核状态</label>
                                 <div class="col-sm-4">
                                    <label><input type="radio" name="status" value="4"/>已收到寄件，检测中</label><br/>
                                 </div>
                                 <div class="col-sm-4">
                                     <span style="color: red;"></span>
                                 </div>
                             </div>
                        @elseif($backGoods['status'] == 4)
                            <div class="form-group">
                                <label for="ad_name" class="col-sm-2 control-label">审核状态</label>
                                <div class="col-sm-4">
                                    <label><input type="radio" name="status" value="5"/>退换货成功</label><br/>
                                    <label><input type="radio" name="status" value="6"/>退换货失败</label><br/>
                                </div>
                                <div class="col-sm-4">
                                    <span style="color: red;"></span>
                                </div>
                            </div>
                        @endif
                        @if($backGoods['status'] != 3 &&$backGoods['status'] != 5 && $backGoods['status'] != 6)
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">审核留言</label>
                            <div class="col-sm-4">
                                <textarea name="status_note" rows="3" class="form-control" placeholder="仅限200字"></textarea>
                            </div>
                            <div class="col-sm-4">
                                <span style="color: red;"></span>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- /.box-body -->
                    @if($backGoods['status'] != 6 && $backGoods['status'] != 5)
                        <div class="box-footer" style="text-align: center;">
                            <button type="submit" class="btn btn-primary"> 确定</button>
                        </div>
                    @endif
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