<?php


namespace App\Model\Data;

use App\Model\Entity\AdminRoleHasPermissions;
use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;

/**
 * Class AdminRoleData
 * @package App\Model\Data
 */
class RolesData
{

    const TABLE_NAME = 'admin_roles';

    /**
     * 获取角色信息
     * @param $role_id
     * @return array|bool
     * @throws DbException
     */
    public static function get_role_info($role_id)
    {
        return DB::table(self::TABLE_NAME)
            ->where('id', $role_id)
            ->firstArray();
    }

    /**
     * 获取权限信息
     * @param $role_id
     * @return array
     * @throws DbException
     */
    public static function get_role_has_permissions($role_id)
    {
        return DB::table('admin_role_has_permissions as t1')
            ->leftJoin('admin_permissions as t2', 't1.permission_id', '=', 't2.id')
            ->where(['t1.role_id' => $role_id])
            ->get(['id', 'name', 'name_group'])
            ->toArray();
    }

    /**
     * 获取上级角色
     * @param bool $column
     * @return array
     * @throws DbException
     */
    public static function superior_roles(bool $column = false)
    {
        $max = DB::table(self::TABLE_NAME)->max('level');
        $result = DB::table(self::TABLE_NAME)->where('level', '<=', $max)->get(['id', 'name', 'name_cn'])->toArray();
        if ($column) {
            return array_column($result, 'name');
        }
        return $result;
    }

    /**
     * 更新角色权限
     * @param int $role_id
     * @param array $permission_ids
     * @return bool
     */
    public static function update_permissions(int $role_id, array $permission_ids)
    {
        //要修改的权限
        $role_has_permissions = [];
        if (!empty($permission_ids)) {
            foreach ($permission_ids as $val) {
                $role_has_permissions[] = ['permission_id' => $val, 'role_id' => $role_id];
            }
        }
        //添加权限
        return AdminRoleHasPermissions::insert($role_has_permissions);
    }

    /**
     * 获取系统预定义的权限
     * @return array
     */
    public static function get_system_roles()
    {
        return ['admin', 'development'];
    }


}
