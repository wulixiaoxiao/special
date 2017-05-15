<?php
/**
 * User: dk
 * Date: 17/4/24 15:46
 */

namespace App\Library;


use OSS\OssClient;


/**
 * 阿里云oss
 * 文档:https://help.aliyun.com/document_detail/32099.html?spm=5176.doc31883.6.368.DgR0OA
 * Class AliOss
 * @package App\Librarys
 */
class AliOss extends OssClient{

    private static $getInstance = '';

    protected static $accessKeyId = '';

    protected static $accessKeySecret = '';

    protected static $endpoint = '';

    public static $imgUrl = 'http://hua-ban.oss-cn-shenzhen.aliyuncs.com/';
    //mfordergoods.oss-cn-shenzhen-internal.aliyuncs.com 内网地址

    public static function ossClient()
    {
        if (self::$getInstance instanceof AliOss) {
            return self::$getInstance;
        }
        self::$accessKeyId      = env('accessKeyId');
        self::$accessKeySecret  = env('accessKeySecret');
        self::$endpoint         = env('endpoint');

        self::$getInstance = new AliOss(self::$accessKeyId, self::$accessKeySecret, self::$endpoint);
        return self::$getInstance;
    }


}