<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//# 社区页面路由组
//Route::group(['namespace'=>'Community'],function (){
//    Route::get('/', function () {return view('community.index');});
//    Route::get('/', function () {return view('welcome');});
//});
//



# 社区Api路由组
# 登录
Route::get('/test', function() {
    return 'hello world';
});
Route::post('/upload_file', 'CommunityApi\CircleController@uploadFile');

Route::group(['middleware' => 'checkApiToken'], function (){

    Route::group(['namespace'=>'CommunityApi', 'prefix' => 'capi'], function (){

        Route::post('/login', 'MemberController@login');
        Route::post('/reg', 'MemberController@register');
        Route::post('/sendcode', 'MemberController@sendMobileCode');
        Route::get('/', 'IndexController@index');

        Route::group(['middleware' => ['checkLogin']], function (){
            # 搜索
            Route::post('/search', 'IndexController@search');

            ##################################社区###################################
            # 获取圈子列表
            Route::post('/circle_list', 'CircleController@circle_list');
            # 关注圈子
            Route::post('/circle_attention', 'CircleController@circle_attention');
            # 取消关注圈子
            Route::post('/circle_attention_cancel', 'CircleController@circle_attention_cancel');
            # 获取动态详情
            Route::post('/circle_detial', 'CircleController@circle_detial');
            # 获取圈子分类
            Route::post('/circle_category', 'CircleController@circle_category');
            # 发布圈子
            Route::post('/circle_pub', 'CircleController@circle_pub');
            # 删除圈子
            Route::post('/circle_del', 'CircleController@circle_del');
            # 获取点赞人列表
            Route::post('/cicle_likes_list', 'CircleController@cicle_likes_list');

            # 点赞
            Route::post('/circle_give_likes', 'CircleController@circle_give_likes');
            # 取消点赞
            Route::post('/circle_cancel_likes', 'CircleController@circle_cancel_likes');
            # 评论圈子
            Route::post('/circle_comment', 'CircleController@circle_comment');
            # 回复评论
            Route::post('/circle_reply', 'CircleController@circle_reply');
            # 获取动态评论
            Route::post('/circle_get_comment', 'CircleController@circle_get_comment');

            ##################################专题###################################
            # 专题列表
            Route::post('/special_list', 'SpecialController@specialList');
            Route::post('/special_detial', 'SpecialController@specialDetial');
            Route::post('/special_likes', 'SpecialController@specialLikes');
            Route::post('/special_reply', 'SpecialController@specialComments');

            ##################################用户相关###################################
            # 获取用户信息
            Route::post('/get_userinfo', 'MemberController@getMemberInfo');
            # 绑定手机号
            Route::post('/bind_phone', 'MemberController@bingPhone');
            # 更新用户信息
            Route::post('/update_userinfo', 'MemberController@updateUserInfo');
            # 获取粉丝
            Route::post('/get_fans', 'MemberController@getFans');
            ###### 关注
            Route::post('/attention', 'MemberController@attention');
            # 我的关注列表
            Route::post('/attention_list', 'MemberController@getAttention');

            ##################################订单###################################
            # 订单列表
            Route::post('/order_list', 'OrderController@getOrderList');
            # 订单详情
            Route::post('/order_detail', 'OrderController@orderDetail');
            # 创建订单
            Route::post('/order_create', 'OrderController@doneOrder');
            # 提交订单
            Route::post('/order_submit', 'OrderController@submitOrder');
            # 关闭订单
            Route::post('/order_close', 'OrderController@closeOrder');
            # 取消订单
            Route::post('/order_cancel', 'OrderController@cancelOrder');
            # 确认收货
            Route::post('/order_finish', 'OrderController@finishOrder');
            # 查看物流
            Route::post('/order_logistics', 'OrderController@orderLogistics');
            # 计算邮费
            Route::post('/order_freight', 'OrderController@getOrderFreight');

            ##################################售后###################################
            Route::post('/after_backorder_lists', 'AfterSaleController@backOrderList');
            Route::post('/after_repairorder_lists', 'AfterSaleController@repairOrderList');
            Route::post('/after_back_goods', 'AfterSaleController@backGoods');
            Route::post('/get_back_goods', 'AfterSaleController@getBackGoodsDetail');

            Route::post('/get_repair_goods', 'AfterSaleController@getRepairGoods');
            Route::post('/after_repair_goods', 'AfterSaleController@repairGoods');

            ##################################商品相关###################################
            # 获取商品分类
            Route::post('/get_category', 'GoodsController@getCategory');
            # 商品详情
            Route::post('/goods_details', 'GoodsController@index');
            # 商品列表
            Route::post('/goods_list', 'GoodsController@goodslist');
            # 收藏商品
            Route::post('/goods_collection', 'GoodsController@addGoodsCollection');
            # 获取商品评价
            Route::post('/goods_comments', 'GoodsController@getGoodsComments');
            # 提交商品评价
            Route::post('/sub_goods_comments', 'GoodsController@subGoodsComments');


            ##################################购物车列表###################################
            Route::post('/cart_list', 'CartController@index');
            # 添加购物车
            Route::post('/cart_add', 'CartController@add');
            # 删除购物车商品
            Route::post('/cart_delete', 'CartController@delete');
            # 增减购物车商品购买数量
            Route::post('/cart_change_goods_num', 'CartController@changeGoodsNumber');

            ##################################收货地址###################################
            # 获取省市区信息
            Route::post('/get_area', 'OrderController@getArea');
            # 获取收货地址列表
            Route::post('/get_address', 'OrderController@getAddressList');
            # 创建收货地址
            Route::post('/create_address', 'OrderController@addAddress');
            # 删除收货地址
            Route::post('/delete_address', 'OrderController@deleteAddress');
            # 设置默认收货地址
            Route::post('/set_default_address', 'OrderController@setDefaultAddress');
        });
    });

});


# 后台路由群组
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    # 登录
    Route::match(['get', 'post'], 'login', 'IndexController@login');
    Route::get('/getVerifyCode', 'IndexController@getVerifyCode');

    Route::group(['middleware' => ['admin-login']], function() {
        #######################################################
        # 专题分类
        Route::get('/special/category', 'SpecialController@categorys');
        Route::match(['get', 'post'], '/special/category/add', 'SpecialController@categorysAdd');
        Route::match(['get', 'post'], '/special/category/edit/{specialCategory}', 'SpecialController@categorysEdit');
        Route::match(['get', 'post'], '/special/category/del', 'SpecialController@categorysDel');
        # 专题
        Route::match(['get', 'post'], '/special/index', 'SpecialController@index');
        Route::match(['get', 'post'], '/special/add', 'SpecialController@add');
        Route::match(['get', 'post'], '/special/edit/{special}', 'SpecialController@edit');
        Route::match(['get', 'post'], '/special/del', 'SpecialController@del');
        Route::match(['get', 'post'], '/special/delcon', 'SpecialController@delSpecialContent');


        # 圈子分类
        Route::get('/circle/category', 'CircleController@categorys');
        Route::match(['get', 'post'], '/circle/category/add', 'CircleController@categorysAdd');
        Route::match(['get', 'post'], '/circle/category/edit/{circleCategory}', 'CircleController@categorysEdit');
        Route::match(['get', 'post'], '/circle/category/del', 'CircleController@categorysDel');
        # 首页推荐
        Route::match(['get', 'post'], '/circle/recommend', 'CircleController@recommend');
        Route::match(['get', 'post'], '/circle/recommend/add', 'CircleController@recommendAdd');
        Route::match(['get', 'post'], '/circle/recommend/edit/{circleRecommend}', 'CircleController@recommendEdit');
        Route::match(['get', 'post'], '/circle/recommend/del', 'CircleController@recommendDel');
        Route::post('/circle/recommend/searchCircle', 'CircleController@searchCircle');


        ############################################################
        # 首页
        Route::get('/', 'IndexController@index');
        Route::get('/logout', 'IndexController@logout');

        #会员管理
        Route::get('member', 'MemberController@index');
        Route::get('member/edit/{id}', 'MemberController@edit');

        # 用户
        Route::get('user', 'UserController@index');
        Route::match(['get', 'post'], 'user/add', 'UserController@add');
        Route::match(['get', 'post'], 'user/edit', 'UserController@edit');
        Route::post('user/del', 'UserController@delete');

        # 管理员管理
        Route::get('admin', 'AdminController@index');
        Route::match(['get', 'post'], 'admin/add', 'AdminController@add');
        Route::match(['get', 'post'], 'admin/edit/{admin}', 'AdminController@edit');
        Route::post('admin/del', 'AdminController@delete');

        # 系统配置
        Route::match(['get', 'post'], 'config', 'ConfigController@index');

        # 管理日志
        Route::get('adminLog', 'AdminLogController@index');
        Route::get('adminLog/edit/{adminLog}', 'AdminLogController@edit');

        # 商品品牌管理
        Route::get('goodsBrand', 'GoodsBrandController@index');
        Route::match(['get', 'post'], 'goodsBrand/add', 'GoodsBrandController@add');
        Route::match(['get', 'post'], 'goodsBrand/edit/{goodsBrand}', 'GoodsBrandController@edit');
        Route::post('goodsBrand/del', 'GoodsBrandController@delete');


        # 商品分类管理
        Route::get('goodsCategory', 'GoodsCategoryController@index');
        Route::match(['get', 'post'], 'goodsCategory/add', 'GoodsCategoryController@add');
        Route::match(['get', 'post'], 'goodsCategory/edit/{goodsCategory}', 'GoodsCategoryController@edit');
        Route::post('goodsCategory/del', 'GoodsCategoryController@delete');

        # 商品管理
        Route::match(['get', 'post'], 'goods', 'GoodsController@index');
        Route::match(['get', 'post'], 'goods/add', 'GoodsController@add');
        Route::match(['get', 'post'], 'goods/edit/{goods}', 'GoodsController@edit');
        Route::post('goods/del', 'GoodsController@delete');
        Route::post('goods/delImage', 'GoodsController@deleteImage');
        Route::post('goods/changerec', 'GoodsController@changerec');
        # 获取商品
        Route::post('/get_goods', 'GoodsController@getGoods');
        Route::post('/search_goods', 'GoodsController@searchGoods');

        # SKU管理
        Route::match(['get', 'post'], 'sku', 'SkuController@index');
        Route::match(['get', 'post'], 'sku/add', 'SkuController@add');
        Route::match(['get', 'post'], 'sku/edit/{sku}', 'SkuController@edit');
        Route::post('sku/del', 'SkuController@delete');
        Route::post('sku/delSkuValue', 'SkuController@delSkuValue');
        Route::post('sku/addSkuValue', 'SkuController@addSkuValue');

        # 商品SKU管理
        Route::match(['get', 'post'], 'goods_sku', 'GoodsSkuController@index');
        Route::match(['get', 'post'], 'goods_sku/add', 'GoodsSkuController@add');
        Route::match(['get', 'post'], 'goods_sku/edit/{goodsSku}', 'GoodsSkuController@edit');
        Route::post('goods_sku/del', 'GoodsSkuController@delete');
        Route::get('goods_sku/getsku', 'GoodsSkuController@getsku');

        # 商品SKU集合管理
        Route::match(['get', 'post'], 'goods_sku_set', 'GoodsSkuSetController@index');
        Route::post('goods_sku_set/chooseSku', 'GoodsSkuSetController@chooseSku');

        # 广告位置
        Route::match(['get', 'post'], 'adPosition', 'AdPositionController@index');
        Route::match(['get', 'post'], 'adPosition/add', 'AdPositionController@add');
        Route::match(['get', 'post'], 'adPosition/edit/{adPosition}', 'AdPositionController@edit');
        Route::post('adPosition/del', 'AdPositionController@delete');

        # 广告
        Route::match(['get', 'post'], 'ad', 'AdController@index');
        Route::match(['get', 'post'], 'ad/add', 'AdController@add');
        Route::match(['get', 'post'], 'ad/edit/{ad}', 'AdController@edit');
        Route::post('ad/del', 'AdController@delete');

        # 订单
        Route::match(['get', 'post'], 'order', 'OrderController@index');
        Route::match(['get', 'post'], 'order/edit/{order}', 'OrderController@edit');
        Route::match(['get', 'post'], 'order/goodsRebate', 'OrderController@goodsRebate');
        Route::match(['get', 'post'], 'order/fansRebate', 'OrderController@fansRebate');
        Route::get('order/getExpressList', 'OrderController@getExpressList');
        Route::get('order/orderDeliver', 'OrderController@orderDeliver');
        Route::match(['get', 'post'], 'order/coinRebate', 'OrderController@coinRebate');

        # 商品评价
        Route::match(['get', 'post'], 'goodsComment', 'GoodsCommentController@index');
        Route::match(['get', 'post'], 'goodsComment/edit/{goodsComment}', 'GoodsCommentController@edit');

        # 退货和返修
        Route::match(['get', 'post'], 'backGoodsList', 'AfterSaleController@backGoodsList');
        Route::match(['get', 'post'], 'backGoodsEdit/{backGoods}', 'AfterSaleController@backGoodsEdit');
        Route::match(['get', 'post'], 'repairGoodsList', 'AfterSaleController@repairGoodsList');
        Route::match(['get', 'post'], 'repairGoodsEdit/{repairGoods}', 'AfterSaleController@repairGoodsEdit');

        #提现管理
        Route::get('withdraw', 'WithdrawController@index');
        Route::post('approved', 'WithdrawController@approved');
        Route::post('rejected', 'WithdrawController@rejected');
        Route::post('payMoney', 'WithdrawController@payMoney');
    });
});