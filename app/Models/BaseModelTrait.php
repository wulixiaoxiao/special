<?php
namespace APP\Models;
/**
 * Created by PhpStorm.
 * User: runong
 * Date: 2017/1/18
 * Time: 上午10:58
 */

trait BaseModelTrait {
    static $_instance = null;

    // 单例模式
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new static;
        }
        return self::$_instance;
    }
}