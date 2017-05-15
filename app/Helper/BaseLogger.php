<?php
/**
 * Created by PhpStorm.
 * User: runong
 * Date: 2017/1/21
 * Time: 下午4:15
 */

namespace App\Helper;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class BaseLogger
{
    use BaseHelper;

    /**
     * 订单日志
     *
     * @param $message
     * @param array $context
     */
    public function addOrderLog($message, array $context = array()) {
        $logger = new Logger('Order');
        $logFile = storage_path('logs/order-'.date('Y-m-d').'.log');
        $logger->pushHandler(new StreamHandler($logFile, Logger::ERROR));
        $logger->addError($message, $context);
    }

    /**
     * 支付日志
     *
     * @param $message
     * @param array $context
     */
    public function addPayLog($message, array $context = array()) {
        $logger = new Logger('Pay');
        $logFile = storage_path('logs/pay-'.date('Y-m-d').'.log');
        $logger->pushHandler(new StreamHandler($logFile, Logger::ERROR));
        $logger->addError($message, $context);
    }

    /**
     * 微信支付通知日志
     *
     * @param $message
     * @param array $context
     */
    public function addWeiXinPayNotifyLog($message, array $context = array()) {
        $logger = new Logger('wei_xin_pay_notify');
        $logFile = storage_path('logs/wei_xin_pay_notify-'.date('Y-m-d').'.log');
        $logger->pushHandler(new StreamHandler($logFile, Logger::ERROR));
        $logger->addError($message, $context);
    }

    /**
     * 定时脚本日志
     *
     * @param $message
     * @param array $context
     */
    public function addCronLog($message, array $context = array()) {
        $logger = new Logger('Cron');
        $logFile = storage_path('logs/cron-'.date('Y-m-d').'.log');
        $logger->pushHandler(new StreamHandler($logFile, Logger::INFO));
        $logger->addInfo($message, $context);
    }

    /**
     * 记录自定义异常日志
     *
     * @param $message
     * @param array $context
     */
    public function addApiExceptionLog($message, array $context = array()) {
        $logger = new Logger('ApiException');
        $logFile = storage_path('logs/ApiException-'.date('Y-m-d').'.log');
        $logger->pushHandler(new StreamHandler($logFile, Logger::ERROR));
        $logger->addError($message, $context);
    }
}