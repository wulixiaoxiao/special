@extends('admin.layouts.index')

@section('title', '会员详情')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        会员详情
        <small>会员详情</small>
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
                            <label for="ad_name" class="col-sm-2 control-label">会员昵称</label>
                            <div class="col-sm-4">{{$memberData->wx_nickname}}</div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">绑定手机号</label>
                            <div class="col-sm-4">{{ $memberData->phone_number }}</div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">微信OpenId</label>
                            <div class="col-sm-4">{{$memberData->wx_openid}}</div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">推荐人</label>
                            <div class="col-sm-4">{{$memberData->parent_name}}</div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">可提现金额</label>
                            <div class="col-sm-4">{{$memberData->format_money}}</div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">是否代言人</label>
                            <div class="col-sm-4">
                                @if($memberData->is_buy == 0)
                                    <span class="label label-danger">否</span>
                                @else
                                    <span class="label label-success">是</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">是否绑定松鼠说</label>
                            <div class="col-sm-4">
                                @if($memberData->is_bind_ssh == 0)
                                    <span class="label label-danger">否</span>
                                @else
                                    <span class="label label-success">是</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">是否关注公众号</label>
                            <div class="col-sm-4">
                                @if($memberData->is_subscribe == 0)
                                    <span class="label label-danger">否</span>
                                @else
                                    <span class="label label-success">是</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">是否实名认证</label>
                            <div class="col-sm-4">
                                @if($memberData->is_certification == 0)
                                    <span class="label label-danger">否</span>
                                @else
                                    <span class="label label-success">是</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">注册时间</label>
                            <div class="col-sm-4">{{$memberData->created_at}}</div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">绑定提现帐号开户名</label>
                            <div class="col-sm-4">{{$memberData->name}}</div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">绑定提现帐号手机</label>
                            <div class="col-sm-4">{{$memberData->bank_phone}}</div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">绑定提现帐号类型</label>
                            <div class="col-sm-4">{{$memberData->format_bank_name}}</div>
                        </div>
                        <div class="form-group">
                            <label for="ad_name" class="col-sm-2 control-label">绑定提现帐号</label>
                            <div class="col-sm-4">{{$memberData->bank_number}}</div>
                        </div>
                    </div>
                    <!-- /.box-body -->
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

@endsection