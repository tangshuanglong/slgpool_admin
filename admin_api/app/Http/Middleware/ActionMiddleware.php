<?php


namespace App\Http\Middleware;


use App\Model\Data\ActionData;
use App\Model\Data\AdminData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\Exception\DbException;
use Swoft\Redis\Redis;

/**
 * 用户访问权限控制
 * Class ActionMiddleware
 * @package App\Http\Middleware
 * @Bean()
 */
class ActionMiddleware implements MiddlewareInterface {

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws DbException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $grantURL = $request->getUri()->getPath();

        $grantURL_arr = explode('/', $grantURL);
        if (isset($grantURL_arr[1]) && isset($grantURL_arr[2])) {
            $grantURL = '/'.$grantURL_arr[1].'/'.$grantURL_arr[2];
        }

        //登录用户信息
        $user = AdminData::get_user_data();
        //对应所有权限
        $role = ActionData::get_user_action($user['id']);
        //左边完整菜单
        $left_menu = Redis::get('left_menu'.$user['id']);
        if (!$left_menu) {
            $left_menu = ActionData::left_menu();
            Redis::set('left_menu'.$user['id'], serialize($left_menu));
            Redis::expire('left_menu'.$user['id'], 60);
        } else {
            $left_menu = unserialize($left_menu);
        }
        //超级管理员跳过
        if(isset($user['admin_type']) && $user['admin_type'] != 1)
        {
            foreach ($left_menu as $key => $value) {
                if(!in_array($value['action_id'],$role['menu_id']) && $value['action_url'] == '') //验证最大导航栏
                {
                    unset($left_menu[$key]);
                }
                if(isset($value['sub_menu']) && !empty($value['sub_menu'])){
                    foreach ($value['sub_menu'] as $k => $v) {
                        if(!in_array($v['action_url'],$role['url_arr'])) //验证子导航栏
                        {
                            unset($left_menu[$key]['sub_menu'][$k]);
                        }
                    }
                }
            }
        }

        $common_info['user'] = $user;
        $common_info['left_menu'] = $left_menu;
        //待渲染模板时传数据
        context()->set('common_info', $common_info);
        context()->set('uid', $user['id']);
        //白名单
        $white_list = array('/logout', '/forbidden');
        $url_arr = array_merge($role['url_arr'], $white_list);
        //验证权限
        if(!in_array($grantURL, $url_arr) && !(isset($user['admin_type']) && $user['admin_type'] == 1)) //超级管理员跳过权限验证
        {
            $response = context()->getResponse();
            return  $response->redirect("/forbidden");
        }

        return $handler->handle($request);
    }
}
