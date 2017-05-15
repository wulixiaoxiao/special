<?php
/**
 * Created by PhpStorm.
 * User: runong
 * Date: 2017/1/21
 * Time: 下午4:41
 */

namespace App\Exceptions;

use App\Helper\BaseLogger;

class ApiException extends \RuntimeException
{
    public function __construct($message = "", $code = 503, \Exception $previous = null) {
        if ($message instanceof \Exception) {
            $errorTemplate = "\n\n异常信息:{$message->getMessage()},\n";
            $errorTemplate .= "异常文件:{$message->getFile()},\n";
            $errorTemplate .= "异常行数:{$message->getLine()},\n";
            $errorTemplate .= "异常错误码:{$message->getCode()},\n\n";
            //$errorTemplate .= "异常堆栈:{$message->getTraceAsString()},\n";
            BaseLogger::getInstance()->addApiExceptionLog($errorTemplate);
            $message = $message->getMessage();
        }
        return parent::__construct($message, $code, $previous);
    }
}