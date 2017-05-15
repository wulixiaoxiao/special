<?php
/**
 * User: huangyugui
 * Date: 16/6/28 11:26
 */

namespace App\Helper;

class Menu
{
    use BaseHelper;

    public function getMenu()
    {
        $controllerPath = explode('\\', current(explode('@', \Route::current()->getActionName())));
        $controllerName = end($controllerPath);
        $arr = [
            'AdminController' => 'menu_admin',
            'OrderController' => 'menu_order',
            'UserController' => 'menu_user',
            'AdminLogController' => 'menu_admin',
            'GoodsCategoryController' => 'menu_goods',
            'SkuController' => 'menu_goods',
            'GoodsSkuController' => 'menu_goods',
            'GoodsBrandController' => 'menu_goods',
            'GoodsController' => 'menu_goods',
            'AdController' => 'menu_ad',
            'AdPositionController' => 'menu_ad',
            'GoodsCommentController' => 'menu_goods',
            'AfterSaleController' => 'menu_after_sale',
            'MemberController' => 'menu_member',
            'WithdrawController' => 'menu_withdraw',
            'SpecialController' => 'menu_special',
            'CircleController' => 'menu_circle',
        ];
        return isset($arr[$controllerName]) ? $arr[$controllerName] : '';
    }

    public function getPermissions()
    {
        $permission = [
            'menu_order' => '订单管理',
            'menu_goods' => '商品管理',
            'menu_user' => '用户管理',
            'menu_admin' => '管理员管理',
            'menu_ad' => '广告管理',
            'menu_after_sale' => '售后管理',
            'menu_member' => '会员管理',
            'menu_special' => '专题管理',
            'menu_circle' => '圈子管理',
        ];

        return $permission;
    }
} 