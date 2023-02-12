<?php
namespace App\Http\Middleware;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Model\Data\AdminData;
use App\Model\Data\UserData;
use App\Model\Entity\AdminUsers;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Context\Context;

/**
 * Class AuthMiddleware
 * 验证登录
 * @package App\Http\Middleware
 * @Bean()
 */
class AuthMiddleware implements MiddlewareInterface{


    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Swoft\Db\Exception\DbException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaderLine('authorization');
        if (empty($token)){
            $json_data = MyQuit::returnMessage(MyCode::USER_NOT_LOGIN, '未登录');
            $response = Context::mustGet()->getResponse();
            return $response->withData($json_data);
        }

        //保存基础信息
        $ip = MyCommon::get_ip($request);
        $request_data = $request->input();
        $request->ip = $ip;

        $request->params = $request_data;
        //验证登录
        $res_data = AdminData::verify_login($token);
        if ($res_data == false) {
            $json_data = MyQuit::returnMessage(MyCode::LOGIN_EXPIRE, '登录已过期');
            $response = Context::mustGet()->getResponse();
            return $response->withData($json_data);
        }
        //保存登录信息
        $request->user_info = $res_data;
        $request->uid = $res_data['user_id'];
        return $handler->handle($request);
    }

}
