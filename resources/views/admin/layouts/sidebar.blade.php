<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header" style="text-align: center;font-size: 14px;">系统菜单面板</li>
            @if(Auth::guard('admin')->user() && in_array('menu_member', !empty(Auth::guard('admin')->user()->permissions) ? explode(',', Auth::guard('admin')->user()->permissions) : []))
            <li class="treeview" id="menu_member">
                <a href="#">
                    <i class="fa fa-user"></i> <span>会员管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="{{ url('admin/member') }}"><i class="fa fa-circle-o"></i> 会员信息</a></li>
                    {{--<li><a href="index2.html"><i class="fa fa-circle-o"></i> 会员日志</a></li>--}}
                </ul>
            </li>
            @endif
            @if(Auth::guard('admin')->user() && in_array('menu_goods', !empty(Auth::guard('admin')->user()->permissions) ? explode(',', Auth::guard('admin')->user()->permissions) : []))
            <li class="treeview" id="menu_goods">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span>商品管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('admin/goodsCategory')}}"><i class="fa fa-circle-o"></i>商品分类管理</a></li>
                    <li><a href="{{url('admin/goodsBrand')}}"><i class="fa fa-circle-o"></i>商品品牌管理</a></li>
                    <li><a href="{{url('admin/goods')}}"><i class="fa fa-circle-o"></i>商品信息管理</a></li>
                    <li><a href="{{url('admin/sku')}}"><i class="fa fa-circle-o"></i>SKU管理</a></li>
                    <li><a href="{{url('admin/goodsComment')}}"><i class="fa fa-circle-o"></i>商品评价管理</a></li>
                </ul>
            </li>
            @endif
            @if(Auth::guard('admin')->user() && in_array('menu_order', !empty(Auth::guard('admin')->user()->permissions) ? explode(',', Auth::guard('admin')->user()->permissions) : []))
                <li class="treeview" id="menu_order">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>订单管理</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('admin/order')}}"><i class="fa fa-circle-o"></i>订单信息管理</a></li>
                    </ul>
                </li>
            @endif

            @if(Auth::guard('admin')->user() && in_array('menu_ad', !empty(Auth::guard('admin')->user()->permissions) ? explode(',', Auth::guard('admin')->user()->permissions) : []))
                <li class="treeview" id="menu_ad">
                    <a href="#">
                        <i class="fa fa-image"></i> <span>广告管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="{{url('admin/adPosition')}}"><i class="fa fa-circle-o"></i> 广告位置管理</a></li>
                        <li><a href="{{url('admin/ad')}}"><i class="fa fa-circle-o"></i> 广告信息管理</a></li>
                    </ul>
                </li>
            @endif
            @if(Auth::guard('admin')->user() && in_array('menu_after_sale', !empty(Auth::guard('admin')->user()->permissions) ? explode(',', Auth::guard('admin')->user()->permissions) : []))
                <li class="treeview" id="menu_after_sale">
                    <a href="#">
                        <i class="fa fa-headphones"></i>
                        <span>售后管理</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('admin/backGoodsList')}}"><i class="fa fa-circle-o"></i>退货管理</a></li>
                        <li><a href="{{url('admin/repairGoodsList')}}"><i class="fa fa-circle-o"></i>返修管理</a></li>
                    </ul>
                </li>
            @endif

            {{-----------------分割线（TODO 权限菜单添加）-------------------}}
            @if(Auth::guard('admin')->user() && in_array('menu_special', !empty(Auth::guard('admin')->user()->permissions) ? explode(',', Auth::guard('admin')->user()->permissions) : []))
                <li class="treeview" id="menu_special">
                    <a href="#">
                        <i class="fa fa-headphones"></i>
                        <span>专题管理</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('admin/special/category')}}"><i class="fa fa-circle-o"></i>分类管理</a></li>
                        <li><a href="{{url('admin/special/index')}}"><i class="fa fa-circle-o"></i>专题管理</a></li>
                    </ul>
                </li>
            @endif

            @if(Auth::guard('admin')->user() && in_array('menu_circle', !empty(Auth::guard('admin')->user()->permissions) ? explode(',', Auth::guard('admin')->user()->permissions) : []))
                <li class="treeview" id="menu_circle">
                    <a href="#">
                        <i class="fa fa-headphones"></i>
                        <span>圈子管理</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{url('admin/circle/category')}}"><i class="fa fa-circle-o"></i>分类管理</a></li>
                        <li><a href="{{url('admin/circle/recommend')}}"><i class="fa fa-circle-o"></i>首页推荐</a></li>
                    </ul>
                </li>
            @endif

            @if(Auth::guard('admin')->user()->admin_name == 'admin' && Auth::guard('admin')->user()->id == 1)
                <li class="treeview" id="menu_admin">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>管理员管理</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="{{url('admin/admin')}}"><i class="fa fa-circle-o"></i> 管理员管理</a></li>
                        <li><a href="{{url('admin/adminLog')}}"><i class="fa fa-circle-o"></i> 管理日志</a></li>
                    </ul>
                </li>
            @endif

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>