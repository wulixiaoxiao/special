@extends('admin.layouts.index')

@section('title', '会员列表')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        会员列表
        <small>会员列表</small>
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
                        <label>搜索:&nbsp;&nbsp;</label>
                        <input type="text" name="search" class="form-control" value="{{$search}}" placeholder="会员ID，会员昵称"/>

                        {{--<label>返利状态:&nbsp;&nbsp;
                            <select class="form-control" name="is_rebate">
                                <option value="-1" @if($is_rebate == -1) selected @endif>请选择...</option>
                                <option value="0" @if($is_rebate == 0) selected @endif>待返利</option>
                                <option value="1" @if($is_rebate == 1) selected @endif>已返利</option>
                            </select>
                        </label>--}}
                        <button type="submit" class="btn btn-primary btn-sm">搜索</button>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th><label><input type="checkbox" value="" id="check-all"></label></th>
                            <th>会员ID</th>
                            <th>推荐人</th>
                            <th>手机号码</th>
                            <th>账户余额(元)</th>
                            <th>微信Openid</th>
                            <th>微信昵称</th>
                            <th>性别</th>
                            <th>注册时间</th>
                            <th>是否购买过</th>
                            <th>是否绑定松鼠说账户</th>
                            <th>是否关注微信公众号</th>
                            <th>是否实名认证</th>
                            <th>是否绑定提现帐号</th>
                            <th>操作</th>
                        </tr>
                        @foreach($memberData as $key => $value)
                        <tr>
                            <td><label><input type="checkbox" name="ids[]" value="{{$value['id']}}"></label></td>
                            <td>{{$value['id']}}</td>
                            <td>{{$value['parent_name']}}</td>
                            <td>{{$value['phone_number']}}</td>
                            <td>{{$value['format_money']}}</td>
                            <td>{{$value['wx_openid']}}</td>
                            <td>{{$value['wx_nickname']}}</td>{{--<span class="label label-success">{{$value['status_text']}}</span>--}}
                            <td>@if($value['wx_sex'] == 1) 男 @else 女 @endif</td>
                            <td>{{$value['created_at']}}</td>
                            <td>@if($value['is_buy'] == 1) <span class="label label-success">是</span> @else <span class="label label-danger">否</span> @endif</td>
                            <td>@if($value['is_bind_ssh'] == 1) <span class="label label-success">是</span> @else <span class="label label-danger">否</span> @endif</td>
                            <td>@if($value['is_subscribe'] == 1) <span class="label label-success">是</span> @else <span class="label label-danger">否</span> @endif</td>
                            <td>@if($value['is_certification'] == 1) <span class="label label-success">是</span> @else <span class="label label-danger">否</span> @endif</td>
                            <td>@if($value['binding_bank'] == 1) <span class="label label-success">是</span> @else <span class="label label-danger">否</span> @endif</td>
                            <td><button type="button" class="btn btn-info btn-xs" onclick="window.location.href='{{url('admin/member/edit/'.$value['id'])}}'">详情</button></td>
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
                    {!! with(new \App\Library\PageLibrary($memberData))->render() !!}
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
    <link rel="stylesheet" href="{{url('assets/admin/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
@endsection

@section('js-block')
    <script type="text/javascript" src="{{url('assets/admin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/admin/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')}}"></script>
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

        $('#start_time').datetimepicker({
            language:  'zh-CN',
            format: 'yyyy-mm-dd hh:ii:ss',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0
        });
        $('#end_time').datetimepicker({
            language:  'zh-CN',
            format: 'yyyy-mm-dd hh:ii:ss',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0
        });
    </script>
@endsection