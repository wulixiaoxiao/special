<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/17
 * Time: 17:09
 */
namespace app\Http\Controllers\CommunityApi;

use App\Helper\CommonHelper;
use App\Helper\ResponseJson;
use App\Http\Controllers\Controller;
use App\Models\Attention;
use App\Models\MobileCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class MemberController extends Controller{

    public function getToken($phone, $uid){
        return md5(env('APP_KEY').$phone.$uid);
    }

    /**
     * 获取用户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMemberInfo(Request $request){
        $memberInfo = User::whereApiToken($request->user()->api_token)->first();
        unset($memberInfo->password);
        return ResponseJson::getInstance()->doneJson('获取成功', $memberInfo);
    }

    /**
     * 注册
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $phone = trim($request->input('phone', ''));
        $code = trim($request->input('code'), '');
        $is_exist = User::wherePhone($phone)->first();
        if ($is_exist) return ResponseJson::getInstance()->errorJson("用户已注册!");
        if(!$phone) return ResponseJson::getInstance()->errorJson("手机号码不能为空!");
        $checkPhone = CommonHelper::getInstance()->validatePhoneNumber($phone);
        if(!$checkPhone) return ResponseJson::getInstance()->errorJson("手机号码不正确!");
        if(!$code) return ResponseJson::getInstance()->errorJson("手机验证码不能为空!");
        $codeData = MobileCode::whereMobile($phone)->whereCode($code)->orderBy('id', 'DESC')->first();
        if(!$codeData) return ResponseJson::getInstance()->errorJson("手机验证码不正确!");
        //验证时效 10分钟
        $minuteTime = ceil((time() - $codeData->time) / 60);
        if($minuteTime > 10) return ResponseJson::getInstance()->errorJson("手机验证码已失效!");

        $nickname = trim($request->input('nickname', ''));
        $avatar = trim($request->input('avatar', ''));
        $password = trim($request->input('password', ''));
        $reply_password = trim($request->input('reply_password', ''));
        if($password !== $reply_password) return ResponseJson::getInstance()->errorJson("两次输入密码不一致!");
        $password = Hash::make($password);
        $userData['name'] = $nickname;
        $userData['phone'] = $phone;
        $userData['password'] = $password;
        $userData['avatar'] = $avatar;
        $userInfo = User::create($userData);

        if($userInfo){
            return ResponseJson::getInstance()->doneJson("注册成功!");
        }
        return ResponseJson::getInstance()->errorJson("注册失败!");
    }

    /**
     * 登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $log_type = $request->input('log_type') ? $request->input('log_type') : 1;  //登录类型
        $token = $request->input('token','');  //登录token
        if(empty($token)){
            switch ($log_type){
                case 1:         //手机号
                    return $this->loginByPhone($request);
                    break;
            }
        }else{                  //返回用户信息
            $userInfo = User::whereApiToken($token)->first();
            $r['name'] = $userInfo->name?$userInfo->name:'';
            $r['avatar'] = $userInfo->avatar?$userInfo->avatar:'';
            $r['phone'] = $userInfo->phone;
            $r['token'] = $userInfo->api_token;
        }
        return ResponseJson::getInstance()->doneJson('登录成功', $r);
    }

    /**
     * 通过手机号登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginByPhone(Request $request){
        $phone = trim($request->input('phone', ''));

        if(!$phone) return ResponseJson::getInstance()->errorJson("手机号码不能为空!");
        $checkPhone = CommonHelper::getInstance()->validatePhoneNumber($phone);
        if(!$checkPhone) return ResponseJson::getInstance()->errorJson("手机号码不正确!");

        $userInfo = User::wherePhone($phone)->first();
        if ($userInfo){
            $password = trim($request->input('password'), '');
            if (Hash::check($password, $userInfo->password)) {
                $token = $this->getToken($userInfo->phone, $userInfo->id);
                $r['name'] = $userInfo->name;
                $r['avatar'] = $userInfo->avatar;
                $r['phone'] = $userInfo->phone;
                $r['token'] = $token;
                $userInfo->api_token = $token;
                $userInfo->save();
                return ResponseJson::getInstance()->doneJson('登录成功', $r);
            }
        }
        return ResponseJson::getInstance()->errorJson('不存在此用户');
    }

    /**
     * 更新用户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        $avatar = $request->file('headImg');
        $nickName = $request->input('nickName');

        $imgpath = CommonHelper::getInstance()->uploadImg($avatar);

        $user['avatar'] = $imgpath;
        $user['name'] = $nickName;

        $is_success = User::whereApiToken($this->userInfo->api_token)->update($user);
        if($is_success){
            return ResponseJson::getInstance()->doneJson('更新成功');
        }
        return ResponseJson::getInstance()->errorJson('更新失败');
    }

    /**
     * 绑定手机号
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bingPhone(Request $request){
        $phone = $request->input('phone');
        $code = $request->input('code');

        if(!$phone) return ResponseJson::getInstance()->errorJson("手机号码不能为空!");
        $checkPhone = CommonHelper::getInstance()->validatePhoneNumber($phone);
        if(!$checkPhone) return ResponseJson::getInstance()->errorJson("手机号码不正确!");
        if(!$code) return ResponseJson::getInstance()->errorJson("手机验证码不能为空!");
        $codeData = MobileCode::whereMobile($phone)->whereCode($code)->orderBy('id', 'DESC')->first();
        if(!$codeData) return ResponseJson::getInstance()->errorJson("手机验证码不正确!");
        //验证时效 10分钟
        $minuteTime = ceil((time() - $codeData->time) / 60);
        if($minuteTime > 10) return ResponseJson::getInstance()->errorJson("手机验证码已失效!");

        $me = $request->user();
        if (!empty($me->phone)) return ResponseJson::getInstance()->errorJson("你已绑定手机号!");
        if (User::wherePhone($phone)->exists()) return ResponseJson::getInstance()->errorJson("该手机号已被注册!");

        $is_success = User::where('id', $me->id)->update(['phone' => $phone]);
        if($is_success){
            return ResponseJson::getInstance()->doneJson('绑定成功');
        }
        return ResponseJson::getInstance()->errorJson('绑定失败');
    }

    /**
     * 发送验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMobileCode(Request $request)
    {
        $phone = $request->input('phone', '');
        if(!$phone) return ResponseJson::getInstance()->errorJson("手机号码不能为空!");

        $checkPhone = CommonHelper::getInstance()->validatePhoneNumber($phone);
        if(!$checkPhone) return ResponseJson::getInstance()->errorJson("手机号码不正确!");

//        $checkIsUse = User::wherePhone($phone)->first();
//        if($checkIsUse) return ResponseJson::getInstance()->errorJson("手机号码已经占用!");

        $code = rand(100000, 999999);
        //发送手机验证码
        CommonHelper::getInstance()->sendPhoneCode($phone, $code);

        //记录发送的验证码
        MobileCode::create([
            'mobile' => $phone,
            'code' => $code,
            'type' => 1,
            'status' => 0,
            'num' => 1,
            'time' => time(),
        ]);

        return ResponseJson::getInstance()->doneJson("发送成功!");
    }

    /**
     * 更新用户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserInfo(Request $request){
        $me = $request->user();
        $avatar = trim($request->input('avatar', ''));
        $nickname = trim($request->input('nickname', ''));
        $signature = trim($request->input('signature', ''));
        $cover_img = trim($request->input('cover_img', ''));
        $address = trim($request->input('address', ''));

        $data = [];
        !empty($avatar) && $data['avatar'] = $avatar;
        !empty($nickname) && $data['name'] = $nickname;
        !empty($signature) && $data['signature'] = $signature;
        !empty($cover_img) && $data['cover_img'] = $cover_img;
        !empty($address) && $data['address'] = $address;
        $is_success = User::whereId($me->id)->update($data);
        if ($is_success) {
            return ResponseJson::getInstance()->doneJson('更新成功');
        }
        return ResponseJson::getInstance()->errorJson('更新失败');
    }

    /**
     * 获取我的粉丝列表
     * @param Request $request
     */
    public function getFans(Request $request){
        $me = $request->user();
        $user = User::find($me->id)->followers()->get()->toArray();
        $list = [];
        foreach ($user as $k => $v){
            // 查询是否互相关注
            $list[$k]['is_attention'] = 0;
            if (Attention::whereMemberId($v['id'])->whereAttentionId($me->id)->exists()) {
                $list[$k]['is_attention'] = 1;
            }
            $list[$k]['name'] = $v['name'];
            $list[$k]['avatar'] = $v['avatar'];
            $list[$k]['signature'] = $v['signature'];
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $list);
    }

    /**
     * 获取我的关注列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAttention(Request $request){
        $me = $request->user();
        $user = User::find($me->id)->followings()->get()->toArray();
        $list = [];
        foreach ($user as $k => $v){
            // 查询是否互相关注
            $list[$k]['is_attention'] = 0;
            if (Attention::whereMemberId($v['id'])->whereAttentionId($me->id)->exists()) {
                $list[$k]['is_attention'] = 1;
            }
            $list[$k]['name'] = $v['name'];
            $list[$k]['avatar'] = $v['avatar'];
            $list[$k]['signature'] = $v['signature'];
        }
        return ResponseJson::getInstance()->doneJson('获取成功', $list);
    }

    /**
     * 关注
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attention(Request $request){
        $me = $request->user();
        $id = $request->input('id');
        if ($id == $me->id) return ResponseJson::getInstance()->errorJson('不能关注自己');
        if (!User::whereId($id)->exists()) return ResponseJson::getInstance()->errorJson('用户不存在');

        $attention = Attention::whereMemberId($me->id)->whereAttentionId($id)->first();
        if($attention){
            $attention->delete();
            $data['type'] = 0;
        }else{
            Attention::create([
                'member_id' => $me->id,
                'attention_id' => $id,
            ]);
            $data['type'] = 1;
        }
        return ResponseJson::getInstance()->doneJson('关注成功', $data);
    }




}