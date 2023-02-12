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
use Swoft\Db\DB;

/**
 * Class AuthMiddleware
 * 验证权限
 * @package App\Http\Middleware
 * @Bean()
 */
class PermissionMiddleware implements MiddlewareInterface{


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
        $request_path = $request->getUri()->getPath();
        $explode_path = explode('/', $request_path);
        $path = '';
        foreach ($explode_path as $val) {
            if (is_numeric($val)) {
                $val = '*';
            }
            if ($val){
                $path .= '/'.$val;
            }
        }
        //$permission_name = trim(implode(' ', $explode_path));
        //获取用户是否有该权限
/*        $exists = AdminData::verify_permission($request->uid, $path);
        if (!$exists) {
            $json_data = MyQuit::returnMessage(MyCode::USER_PERMISSION_ERROR, '没有操作权限');
            $response = Context::mustGet()->getResponse();
            return $response->withData($json_data);
        }*/
        return $handler->handle($request);
    }

}
