<?php
namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Lib\MyToken;
use App\Model\Data\AdminData;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Message\Request;
use App\Http\Middleware\ActionMiddleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;

/**
 * 后台首页 不需要权限的接口
 * Class IndexController
 * @package App\Http\Controller\Admin
 * @Controller("/admin/index")
 * @Middleware(AuthMiddleware::class)
 */
class IndexController
{
    /**
     * @Inject()
     * @var MyToken
     */
    private $myToken;

    /**
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function info(Request $request)
    {
        $user_info = $request->user_info;
        $uid = $request->uid;
        $role_ids  = AdminData::user_role_ids($uid); //角色信息
        $roles    = AdminData::get_roles($role_ids);

        //用户的权限信息
        $permissionsList = AdminData::user_permissions($role_ids);
        $permissions     = [];//初始化权限信息
        $menus           = [];//初始化菜单信息

        if ($permissionsList) {
            //信息有点多，重新拿一下给前端
            foreach ($permissionsList as $k => $v) {
                $permissions[$k] = [
                    "id"             => $v["id"],
                    "name"           => $v["name"],
                    "name_group"     => $v["name_group"],
                    "name_group_cn"  => $v["name_group_cn"],
                    "name_action_cn" => $v["name_action_cn"],
                    'permission_uri' => $v['permission_uri']
                ];
            }

            //菜单
            $tmpMenus = AdminData::menusDataSpecification($permissions);
            foreach ($tmpMenus as $value) {
                $menus[$value['module']] = $value['moduleName'];
            }
        }

        $data = [
            'base'   => $user_info,
            'extend' => [
                'roles'       => $roles,
                'permissions' => $permissions,
                'menus'       => $menus,
            ],
        ];
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 退出登录
     * @param Request $request
     * @return array
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function logout(Request $request)
    {
        $token = $request->getHeaderLine('authorization');
        $this->myToken->deleteToken($token);
        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }

}
