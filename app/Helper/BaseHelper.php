<?php

namespace App\Helper;
/**
 * Created by PhpStorm.
 * User: runong
 * Date: 2017/1/18
 * Time: 上午10:06
 */
trait BaseHelper
{
    static $_instance = null;

    // 单例模式
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new static;
        }
        return self::$_instance;
    }
}