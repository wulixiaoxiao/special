<?php
/**
 * Created by PhpStorm.
 * User: runong
 * Date: 2017/2/5
 * Time: 上午11:25
 */

namespace App\Helper;

use App\Library\AliOss;
use Ixudra\Curl\Facades\Curl;

class CommonHelper
{
    use BaseHelper;

    /**
     * 上传文件
     * @param Request $request
     * @return array
     */
    public function uploadFile($type = 1, $files = [], $path = ''){
        switch ($type){
            case 1;                 //图片
                if (!$files->isValid()) {
                    return ResponseJson::getInstance()->errorJson('图片不正确');
                }
                $extension = $files->getClientOriginalExtension();
                $oldName = mt_rand(0, mt_rand());
                $fileName = $_ENV['imgPath']. 'images/' . $path . $oldName . '' . time() . '.' . $extension;
                AliOss::ossClient()->putObject(env('bucketName'), $fileName, file_get_contents($files->getPathname()));
                return $fileName;
                break;
            case 2:
                if (!$files->isValid()) {
                    return ResponseJson::getInstance()->errorJson('图片不正确');
                }
                $extension = $files->getClientOriginalExtension();
                $oldName = mt_rand(0, mt_rand());
                $fileName = $_ENV['imgPath']. 'video/'. $path . $oldName . '' . time() . '.' . $extension;
                AliOss::ossClient()->putObject(env('bucketName'), $fileName, file_get_contents($files->getPathname()));
                return $fileName;
                break;
        }
    }

    public function getOssPath($filePath = ''){
        if (!$filePath) return false;
        return AliOss::$imgUrl.$filePath;
//        return AliOss::ossClient()->signUrl(env('bucketName'), $filePath, 3600);
    }

    /**
     * 价格转换入库
     *
     * @param $value
     * @return float
     */
    public function formatPriceToDatabase($value) {
        return floatval($value) * 100;
    }

    /**
     * 价格转换出库
     *
     * @param $value
     * @return string
     */
    public function formatPriceToShow($value) {
        return number_format($value / 100, 2, '.', '');
    }

    /**
     * 重量转换入库
     *
     * @param $value
     * @return float
     */
    public function formatWeightToDatabase($value) {
        return floatval($value) * 1000;
    }

    /**
     * 重量转换出库
     *
     * @param $value
     * @return string
     */
    public function formatWeightToShow($value) {
        return number_format($value / 1000, 2);
    }

    /**
     * 图片路径转换出库
     *
     * @param $value
     * @return string
     */
    public function formatImageToShow($value) {
        if (empty($value)) { return ''; }
        return request()->getBaseUrl().'/'.$value;
    }

    /**
     * 加密银行卡卡号或身份证号码(左右保留4位字符,中间加密)
     *
     * @param $cardNumber
     * @return string
     */
    public function encryptCardNumber($cardNumber) {
        if (empty($cardNumber) || strlen($cardNumber) <= 8) {
            return $cardNumber;
        }
        return substr($cardNumber, 0, 4).str_repeat('*', (strlen($cardNumber) - 8)).substr($cardNumber, -4);
    }

    /**
     * 转换编码，将Unicode编码转换成中文
     *
     * @param $name
     * @return string
     */
    public function unicodeDecode($name){
        $json = '{"str":"'.$name.'"}';
        $arr = json_decode($json,true);
        if(empty($arr)) return '';
        return $arr['str'];
    }

    /**
     * 加密手机号码
     *
     * @param $mobile
     * @return string
     */
    public function encryptMobile($mobile) {
        if (empty($mobile) || strlen($mobile) <= 6) {
            return $mobile;
        }
        return substr($mobile, 0, 3).str_repeat('*', (strlen($mobile) - 6)).substr($mobile, -3);
    }

    /**
     * 验证手机号码
     *
     * @param $mobile
     * @return bool|int
     */
    public function validatePhoneNumber($mobile) {
        if (empty($mobile)) { return false; }
        return preg_match('/^1[34578][0-9]{9}$/', $mobile);
    }

    /**
     * 发送手机短信验证码
     *
     * @param $phone
     * @param $code
     */
    public function sendPhoneCode($phone, $code)
    {
        Curl::to('http://61.129.57.234:7891/mt')
            ->withData([
                'dc'    => 15,
                'un'    => '100134',
                'pw'    => '100134',
                'da'    => $phone,
                'sm'    => '您的验证码是'.$code.',短信10分钟内有效，为了您的信息安全，打死也不要告诉别人喔！【松鼠淘】',
                'sa'    => '4443',
                'tf'    => '3'
            ])->get();
    }

    /**
     * 判断数据是否是json字符串
     *
     * @param $string
     * @return bool
     */
    public function isJson($string) {
        return json_decode($string) && json_last_error() == JSON_ERROR_NONE ? true : false;
    }

    /**
     * 上传图片文件
     * @param $Img
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function uploadImg($Img){
        if (!$Img->isValid()) {
            return ResponseJson::getInstance()->errorJson('商品缩略图不正确');
        }
        $extension = $Img->getClientOriginalExtension();
        $oldName = rand(10000,99999);
        $fileName = $oldName . time() . '.' . $extension;
        $Img->move('upload/goods_thumb/', $fileName);
        $thumbPic = 'upload/goods_thumb/'.$fileName;
        return $thumbPic;
    }


}