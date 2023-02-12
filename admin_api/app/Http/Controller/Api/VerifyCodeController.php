<?php

namespace App\Http\Controller\Api;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Lib\MyValidator;
use App\Model\Entity\Captcha;
use App\Model\Entity\CountryCode;
use App\Model\Entity\UserBasicalInfo;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Db\DB;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Log\Helper\CLog;
use Swoft\Log\Helper\Log;
use Swoft\Redis\Redis;
use Swoft\Stdlib\Helper\JsonHelper;

/**
 * 验证码控制器
 * Class CaptchaController
 * @package App\Http\Controller\Api
 * @Controller("v1/verifyCode")
 */
class VerifyCodeController{

    /**
     * @Inject()
     * @var MyValidator
     */
    private $myValidator;

    /**
     * @Inject()
     * @var MyCommon
     */
    private $myCommon;

    /**
     * @RequestMapping(method={RequestMethod::POST})
     * @param Request $request
     * @return
     * @throws \Swoft\Validator\Exception\ValidatorException
     */
    public function send(Request $request)
    {
        $params = $request->params;
        //验证参数
        $params = validate($params, 'AuthValidator', ['account', 'action', 'country_id']);
        //验证account类型
        $account_type = $this->myValidator->account_check($params['account']);
        if ($account_type === false) {
            return MyQuit::returnMessage(MyCode::ACCOUNT_ERROR, '账号必须为邮箱/手机号码！');
        }
        //验证action
        if (!array_key_exists($params['action'], config('actions'))){
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '参数错误');
        }
        //获取国家信息
        $country_info = CountryCode::select('area_code')->where(['country_id' => $params['country_id']])->first();
        if (empty($country_info)){
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '参数错误！');
        }
        $code_key = $params['action']. '_code_key';
        $redis_data = Redis::hget($code_key, $params['account']);
        if (! empty($redis_data))
        {
            $redis_data = json_decode($redis_data, true);
            if (time() < $redis_data['create_time'] + config('code_operate_expire_time'))
            {
                return MyQuit::returnMessage(MyCode::INTERVAL_AGAIN_SEND_CPATCHA, '一分钟内只能发送一次验证码');
            }
        }
        $user_info = UserBasicalInfo::select('id')->where([$account_type => $params['account']])->first();
        switch ($params['action']) {
            case 'register':
                if (!empty($user_info)){
                    return MyQuit::returnMessage(MyCode::REGISTER_ALREADY, '已经注册！');
                }
                break;
        }
        try{
            $code = $this->myCommon->send_verify_code($params['account'], $country_info['area_code'], $params['action']);
            if (!$code){
                throw new \Exception('push list error');
            }
            $data = [
                'account' => $params['account'],
                'type' => $account_type,
                'ip' => $request->ip,
                'create_time' => time(),
                'code' => $code,
                'action' => $params['action'],
                'user_agent' => $request->getHeaderLine('user-agent'),
            ];
            $res = Captcha::insert($data);
            if (!$res){
                throw new \Exception('insert captcha log error');
            }
            $response =  MyQuit::returnMessage(MyCode::SUCCESS, '发送成功！');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            CLog::error($e->getMessage());
            $response = MyQuit::returnMessage(MyCode::SERVER_ERROR, '服务器繁忙');
        }
        return $response;
    }

}
