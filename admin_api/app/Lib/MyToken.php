<?php

namespace App\Lib;

use Swoft\Redis\Redis;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use App\Lib\MyAes;
use Swoft\Stdlib\Helper\JsonHelper;

/**
 * Class MyToken
 * @package App\Lib
 * 生成登录token
 * @Bean("MyToken")
 */
class MyToken
{
    /**
     * @var string
     */
    private $redis_token_key = 'admin:user:token';

    /**
     * @var string
     */
    private $redis_sign_token_key = 'admin_sign_token';

    /**
     * @var
     */
    private $hmac_key;

    /**
     * @Inject("MyAes")
     * @var MyAes
     */
    private $myAes;


    public function __construct()
    {
        $this->hmac_key = config('hmac_key');
    }

    /**
     * 生成token
     * @param int $invite_id
     * @param string $account
     * @param string $client_type
     * @param string $device_id
     * @return string
     */
    public function generateToken(int $uid, string $account)
    {
        $time = time();
        $exp = $time + 28800;
        $payload = [
            'user_id' => $uid,
            'account' => $account,
            'exp' => $exp,
        ];
        $header = [
            'alg' => 'SHA256',
            'typ' => 'JWT',
        ];
        //对头信息进行aes加密
        $aes_header = $this->myAes->encrypt(JsonHelper::encode($header));
        //对载荷信息进行base64编码
        $base64_payload = base64_encode(JsonHelper::encode($payload));
        //生成签名
        $sign = base64_encode(hash_hmac('sha256', $aes_header.'.'.$base64_payload, $this->hmac_key, true));
        //拼接token
        $token = $aes_header.'.'.$base64_payload.'.'.$sign;
        //设置缓存
        Redis::set(md5($token), 1, $exp);
        return $token;
    }


    /**
     * 验证token
     * @param string $userToken
     * @param string $client_type
     * @param string $device_id
     * @return array|bool
     */
    public function checkToken(string $userToken)
    {
        if($userToken === '0' || $userToken === ''){
            return false;
        }
        $explode_token = explode('.', $userToken);
        if (count($explode_token) !== 3){
            return false;
        }
        list($aes_header, $base64_payload, $verify_sign) = $explode_token;
        //生成签名
        $sign = base64_encode(hash_hmac('sha256', $aes_header.'.'.$base64_payload, $this->hmac_key, true));
        //签名不一致返回登录过期
        if(strcasecmp($verify_sign, $sign) != 0){
            return false;
        }
        $header = JsonHelper::decode($this->myAes->decrypt($aes_header), true);
        $payload = JsonHelper::decode(base64_decode($base64_payload), true);
        if(!$payload || !$header){
            //MyCommon::write_log('解析不到数据', '/logs/token');
            return false;
        }
        //如果缓存不存在或did不一致，或过期返回登录过期
        if($payload['exp'] < time() || !Redis::exists(md5($userToken))){
            //MyCommon::write_log('过期返回登录过期', '/logs/token');
            return false;
        }
        return [
            'uid' => $payload['user_id'],
            'user_name' => $payload['account'],
        ];
    }

    /**
     * @param string $token
     * @return string
     */
    public function deleteToken(string $token)
    {
        return Redis::del(md5($token));
    }


}
