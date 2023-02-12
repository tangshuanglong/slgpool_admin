<?php


namespace App\Http\Controller\Api;


use App\Lib\MyCode;
use App\Lib\MyQuit;
use Qiniu\Auth;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use App\Http\Middleware\ActionMiddleware;
/**
 * Class QinniuUploadController
 * @package App\Http\Controller\Api
 * @Controller("/api/qiniu_upload")
 * @Middleware(ActionMiddleware::class)
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
        if ($request->isAjax()) {
            $uid = context()->get('uid');
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
        return MyQuit::returnMessage(MyCode::FAIL, 'only isAjax');
    }
}
