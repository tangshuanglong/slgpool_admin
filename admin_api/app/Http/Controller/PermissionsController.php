<?php


namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyGA;
use App\Lib\MyQuit;
use App\Lib\MyToken;
use App\Model\Data\PermissionsData;
use App\Model\Data\RolesData;
use App\Model\Data\AdminData;
use App\Model\Entity\AdminPermissions;
use App\Model\Entity\AdminRoleHasPermissions;
use App\Model\Entity\AdminUserHasRoles;
use App\Model\Entity\AdminUsers;
use ReflectionException;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Db\DB;
use Swoft\Http\Message\Request;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class AdminUserController
 * @package App\Http\Controller\Admin
 * @Controller("/permissions")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class PermissionsController
{

    /**
     * 权限列表
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        $params = $request->params;
        //初始化参数
        $name = $params['name'] ?? '';  //模糊搜索的名字
        $page = $params['page'] ?? 1;   //页码
        $size = $params['size'] ?? 10;  //条数
        //获取分组的信息
        $data = PermissionsData::get_permissions_list($name, $page, $size);
        $list = $data['list'] ?? [];
        if ($list) {
            //获取查询详细信息
            $groupArray = array_column($list, 'name_group');
            $getField = ['id', 'name', 'name_group', 'name_group_cn', 'name_action_cn', 'permission_uri'];
            $permissionList = DB::table('admin_permissions')
                ->whereIn('name_group', $groupArray)
                ->orderBy('id', 'desc')
                ->get($getField)
                ->toArray();
            //格式处理
            $data['list'] = AdminData::menusDataSpecification($permissionList, false);
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 权限添加
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function create(Request $request)
    {
        $params = $request->params;
        validate($params, 'PermissionValidator', ['name_group', 'name_group_cn', 'permissions']);
        validate($params['permissions'][0], 'PermissionValidator', ['name', 'name_action_cn', 'permission_uri']);
        //获取同个分组队名称, 如果出现组名相同，就默认归入已存在的
        $permission = DB::table('admin_permissions')
            ->where(['name_group' => $params['name_group']])
            ->orWhere(['name_group_cn' => $params['name_group_cn']])
            ->first(['name_group', 'name_group_cn']);
        if ($permission) {
            $params['name_group_cn'] = $permission['name_group_cn'];
            $params['name_group'] = $permission['name_group'];
        }
        $list = $params['permissions'];
        DB::beginTransaction();
        try {
            foreach ($list as $value) {
                $value['name_group'] = $params['name_group'];
                $value['name_group_cn'] = $params['name_group_cn'];
                $res = AdminPermissions::insert($value);
                if (!$res) {
                    throw new \Exception('服务器异常');
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, $e->getMessage());
        }
        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }

    /**
     * 更新权限
     * @param Request $request
     * @param int $permission_id
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT}, route="{permission_id}/update")
     */
    public function update(Request $request, int $permission_id)
    {
        $params = $request->params;
        $permission = AdminPermissions::find($permission_id);
        if (!$permission) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '权限不存在');
        }
        //验证
        validate($params, 'PermissionValidator', ['name', 'name_action_cn', 'permission_uri']);

        $permission->update($params);
        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }

    /**
     * 权限删除
     * @param int $permission_id
     * @return array
     * @RequestMapping(method={RequestMethod::DELETE}, route="{permission_id}/delete")
     */
    public function delete(int $permission_id)
    {
        $permission = AdminPermissions::find($permission_id);
        if (!$permission) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '权限不存在');
        }
        if ($permission->getCannotDelete() === 1) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, "代号:{$permission->getName()},是系统预定义菜单，暂不支持删除");
        }
        DB::beginTransaction();
        try {
            //删除表记录
            $res = $permission->delete();
            if (!$res) {
                throw new \Exception('删除权限失败');
            }
            //删除角色权限
            AdminRoleHasPermissions::where(['permission_id' => $permission_id])->delete();
            DB::commit();
            return MyQuit::returnMessage(MyCode::SUCCESS, "删除成功");
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * 权限组修改
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT})
     */
    public function update_group(Request $request)
    {
        $params = $request->params;
        validate($params, 'PermissionValidator', ['name_group', 'name_group_cn']);
        $where = ['name_group' => $params['name_group']];
        $permission = AdminPermissions::where($where)->exists();
        if (!$permission) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '权限组不存在');
        }
        AdminPermissions::where($where)->update($params);
        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }

    /**
     * 权限组删除
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::DELETE})
     */
    public function delete_group(Request $request)
    {
        $params = $request->params;
        validate($params, 'PermissionValidator', ['name_group']);
        $permission = AdminPermissions::where(['name_group' => $params['name_group']])->get(['id'])->toArray();
        if (!$permission) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '权限组不存在');
        }

        if (in_array($params['name_group'], PermissionsData::get_system_group())) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, "分组代号：" . $params['name_group'] . ",是系统预定义权限分组，暂不支持删除");
        }
        $permissionIds = array_column($permission, 'id');
        DB::beginTransaction();
        try {
            //删除表id
            $res = AdminPermissions::whereIn('id', $permissionIds)->delete();
            if (!$res) {
                throw new \Exception('删除权限组失败');
            }
            //删除角色权限
            AdminRoleHasPermissions::whereIn('permission_id', $permissionIds)->delete();
            DB::commit();
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, $e->getMessage());
        }
    }

}
