<?php


namespace App\Http\Controller;


use App\Lib\MyCode;
use App\Lib\MyQuit;
use Qiniu\Auth;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use App\Http\Middleware\ActionMiddleware;
use App\Http\Middleware\AuthMiddleware;
/**
 * Class QinniuUploadController
 * @package App\Http\Controller\Api
 * @Controller("/qiniu_upload")
 * @Middleware(AuthMiddleware::class),
 */
class QinniuUploadController
{
    /**
     * 获取七牛token
     * @param Request $request
     * @return array
     * @RequestMapping(route="get_token")
     */
    public function get_token(Request $request)
    {
        $uid = $request->uid;
        //实例化鉴权类
        $ak = config('accesskey');
        $sk = config('secretkey');
        $bucket = config('bucket');

        $auth = new Auth($ak, $sk);
        $body = [
            "filename" => "$(key)",
            "uid" => $uid,
        ];
        $policy = [
            //回调url
            'callbackUrl' => config('qi_niu_callback_url'),
            //回调服务器收到的body
            'callbackBody' => json_encode($body, JSON_UNESCAPED_UNICODE),//"filename=$(key)&uid=".$this->uid."&uploadType=".$type
        ];
        $upToken = $auth->uploadToken($bucket, null, 600, $policy);
        $data['upToken'] = $upToken;
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'Successfully');
    }
}
