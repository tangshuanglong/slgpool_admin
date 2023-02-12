<?php

namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Model\Data\ActionData;
use App\Model\Data\AdminData;
use App\Model\Data\RolesData;
use App\Model\Entity\AdminPermissions;
use App\Model\Entity\AdminRoleHasPermissions;
use App\Model\Entity\AdminRoles;
use App\Model\Entity\AdminUserHasRoles;
use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
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
 * Class RolesController
 * @package App\Http\Controller\Admin
 * @Controller("/roles")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class RolesController
{
    /**
     * 角色列表（全量）
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function role(Request $request)
    {
        $result = DB::table('admin_roles')->get(['id', 'name', 'name_cn'])->toArray();
        return MyQuit::returnSuccess($result, MyCode::SUCCESS, 'success');
    }

    /**
     * 角色列表
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        $page = $request->params['page'] ?? 1;
        $size = $request->params['size'] ?? 10;
        $field = ['id', 'name', 'name_cn', 'description', 'pid'];
        $roles_obj = DB::table('admin_roles');
        $count = $roles_obj->count();
        $result = $roles_obj->forPage($page, $size)->get($field)->toArray();
        if ($result) {
            $roleIds = array_column($result, 'pid');
            $pidList = $roles_obj->whereIn('id', $roleIds)->get()->pluck('name_cn', 'id')->toArray();
            foreach ($result as $key => $value) {
                $result[$key]['p_name'] = $pidList[$value['pid']] ?? '';
            }
        }
        $data = [
            'list'  => $result,
            'count' => $count
        ];
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 角色权限详情
     * @param int $role_id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{role_id}/detail")
     */
    public function detail(int $role_id)
    {
        $role = RolesData::get_role_info($role_id);
        if (!$role) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '角色不存在');
        }
        $result = RolesData::get_role_has_permissions($role_id);
        $data = [
            'detail'     => $role,
            'permission' => $result
        ];
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 角色及权限添加
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function create(Request $request)
    {
        $params = $request->params;
        validate($params, 'RoleValidator', ['pid', 'name', 'name_cn', 'description', 'permission_ids']);
        $exists = AdminRoles::where(['name' => $params['name']])->exists();
        if ($exists) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '角色已经存在');
        }
        //判断选定上级
        $p_role = AdminRoles::find($params['pid']);
        if (!$p_role) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '上级角色不存在');
        }
        $superiorList = RolesData::superior_roles(true);
        if (!in_array($p_role->getName(), $superiorList)) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, "角色，{$p_role->getNameCn()},指定上级指定有误，请联系技术人员");
        }
        $params['level'] = $p_role->getLevel() + 1;
        $permission_ids = $params['permission_ids'];
        unset($params['permission_ids']);
        DB::beginTransaction();
        try {
            //创建角色
            $role = AdminRoles::create($params);
            //更新权限
            RolesData::update_permissions($role->getId(), $permission_ids);
            DB::commit();
            return MyQuit::returnMessage(MyCode::SUCCESS, '创建成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '失败');
        }
    }

    /**
     * 角色及权限更新
     * @param Request $request
     * @return array
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT})
     */
    public function update(Request $request)
    {
        $params = $request->params;
        validate($params, 'RoleValidator', ['pid', 'name', 'name_cn', 'description', 'permission_ids']);
        $role = AdminRoles::find($params['id']);
        if (!$role) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '角色不存在');
        }
        $permission_ids = $params['permission_ids'];
        unset($params['permission_ids']);
        DB::beginTransaction();
        try {
            //更新角色
            $role->update($params);
            //删除角色所有权限
            AdminRoleHasPermissions::where(['role_id' => $params['id']])->delete();
            //更新权限
            RolesData::update_permissions($params['id'], $permission_ids);
            DB::commit();
            return MyQuit::returnMessage(MyCode::SUCCESS, '更新成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '失败');
        }
    }

    /**
     * 角色的单个权限组更新
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT})
     */
    public function update_permission(Request $request)
    {
        $params = $request->params;
        validate($params, 'RoleValidator', ['id', 'name_group', 'permission_ids']);
        $role = AdminRoles::find($params['id']);
        if (!$role) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '角色不存在');
        }
        $permission = AdminPermissions::where(['name_group' => $params['name_group']])->get(['id'])->toArray();
        if (!$permission) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '权限组不存在');
        }
        $permission_ids = array_column($permission, 'id');
        //要修改的权限
        $permissionArray = $params['permission_ids'] ?? [];
        DB::beginTransaction();
        try {
            //删除该角色下该权限组的所有权限
            AdminRoleHasPermissions::where(['role_id' => $params['id']])->whereIn('permission_id', $permission_ids)->delete();
            //更新权限
            RolesData::update_permissions($params['id'], $permissionArray);
            DB::commit();
            return MyQuit::returnMessage(MyCode::SUCCESS, '分配成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '失败');
        }
    }

    /**
     * 角色删除
     * @param int $role_id
     * @return array
     * @RequestMapping(method={RequestMethod::DELETE}, route="{role_id}/delete")
     */
    public function delete(int $role_id)
    {
        $role = AdminRoles::find($role_id);
        if (!$role) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '角色不存在');
        }
        if (in_array($role->getName(), RolesData::get_system_roles())) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, "角色代号：" . $role->getNameCn() . ",是系统预定义的角色，暂不支持删除");
        }
        //判断帐号是否拥有角色
        $has_roles = AdminUserHasRoles::find($role_id);
        if($has_roles){
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '后台帐号拥有此角色');
        }
        DB::beginTransaction();
        try {
            //删除角色
            $role->delete();
            //删除角色所有权限
            AdminRoleHasPermissions::where(['role_id' => $role_id])->delete();
            DB::commit();
            return MyQuit::returnMessage(MyCode::SUCCESS, '删除成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '失败');
        }
    }

}
