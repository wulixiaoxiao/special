@extends('admin.layouts.index')

@section('title', '提现列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        提现列表
        <small>提现列表</small>
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
                        {{--<label>搜索:&nbsp;&nbsp;</label>
                        <input type="text" name="search" class="form-control" value="{{$search}}" placeholder="会员昵称"/>--}}

                        {{--<label>返利状态:&nbsp;&nbsp;
                            <select class="form-control" name="is_rebate">
                                <option value="-1" @if($is_rebate == -1) selected @endif>请选择...</option>
                                <option value="0" @if($is_rebate == 0) selected @endif>待返利</option>
                                <option value="1" @if($is_rebate == 1) selected @endif>已返利</option>
                            </select>
                        </label>--}}
                        {{--<button type="submit" class="btn btn-primary btn-sm">搜索</button>--}}
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th><label><input type="checkbox" value="" id="check-all"></label></th>
                            <th>会员ID</th>
                            <th>会员昵称</th>
                            <th>提现金额(元)</th>
                            <th>提现开户行</th>
                            <th>提现帐号</th>
                            <th>认证姓名</th>
                            <th>提现状态</th>
                            <th>审核时间</th>
                            <th>打款时间</th>
                            <th>打款流水号</th>
                            <th>审核驳回原因</th>
                            <th>申请时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($withdrawData as $key => $value)
                        <tr>
                            <td><label><input type="checkbox" name="ids[]" value="{{$value['id']}}"></label></td>
                            <td>{{$value['id']}}</td>
                            <td>{{$value['member_wx_nickname']}}</td>
                            <td>{{$value['format_money']}}</td>
                            <td>{{$value['bank_name']}}</td>
                            <td>{{$value['bank_number']}}</td>
                            <td>{{$value['member_name']}}</td>
                            <td>
                                @if($value['audit_status'] == 0)
                                    <span class="label label-warning">待审核</span>
                                @endif
                                @if($value['audit_status'] == 1)
                                        <span class="label label-info">已审核</span>
                                @endif
                                @if($value['audit_status'] == 2)
                                        <span class="label label-success">已打款</span>
                                @endif
                                @if($value['audit_status'] == 3)
                                        <span class="label label-danger">已驳回</span>
                                @endif
                            </td>
                            <td>{{isset($value['audit_time']) ? date('Y-m-d H:i:s',$value['audit_time']) : ''}}</td>{{--<span class="label label-success">{{$value['status_text']}}</span>--}}

                            <td>{{isset($value['remit_time']) ? date('Y-m-d H:i:s',$value['remit_time']) : ''}}</td>
                            <td>{{$value['pay_number']}}</td>
                            <td>{{$value['audit_fail_message']}}</td>
                            <td>{{$value['created_at']}}</td>
                            <td>
                                @if($value['audit_status'] == 0)
                                    <button type="button" class="btn btn-info btn-xs" onclick="approved({{$value['id']}})">通过</button>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="rejected({{$value['id']}})">驳回</button>
                                @endif
                                @if($value['audit_status'] == 1)
                                    <button type="button" class="btn btn-success btn-xs" onclick="payMoney({{$value['id']}})">打款</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <!-- /.box-footer -->
                <div class="box-footer clearfix">
                    {{--<span class="pull-left">
                        <button type="button" class="btn btn-warning btn-sm">导出</button>
                        <button type="button" class="btn btn-danger btn-sm">批量删除</button>
                    </span>--}}
                    {!! with(new \App\Library\PageLibrary($withdrawData))->render() !!}
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
    <script type="text/javascript" charset="utf-8">
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

        //审核通过
        function approved(id){
            layer.confirm('确定审核通过？', function(index){
                var index = layer.load();
                $.post('{{url('admin/approved')}}', {'id' : id}, function(data) {
                    layer.close(index);
                    if (data.error == 0) {
                        layer.alert('审核通过!');
                        window.location.reload();
                    } else {
                        layer.alert(data.message);
                    }
                }, 'json');

                layer.close(index);
            });
        }

        //驳回申请
        function rejected(id){
            layer.confirm('确定驳回申请？', function(index){
                layer.prompt({
                    title: '输入驳回申请原因，并确认',
                    formType: 0,
                }, function(value, index, elem){
                    var index = layer.load();
                    $.post('{{url('admin/rejected')}}', {'id' : id, 'failMessage':value}, function(data) {
                        layer.close(index);
                        if (data.error == 0) {
                            layer.alert('驳回申请!');
                            window.location.reload();
                        } else {
                            layer.alert(data.message);
                        }
                    }, 'json');

                    layer.close(index);
                });

                layer.close(index);
            });
        }

        //打款
        function payMoney(id){
            layer.confirm('确定打款？', function(index){
                layer.prompt({
                    title: '输入打款流水号，并确认',
                    formType: 0,
                }, function(value, index, elem){
                    var index = layer.load();
                    $.post('{{url('admin/payMoney')}}', {'id' : id,'pay_number':value}, function(data) {
                        layer.close(index);
                        if (data.error == 0) {
                            layer.alert('打款成功!');
                            window.location.reload();
                        } else {
                            layer.alert(data.message);
                        }
                    }, 'json');

                    layer.close(index);
                });

                layer.close(index);
            });
        }
    </script>
@endsection