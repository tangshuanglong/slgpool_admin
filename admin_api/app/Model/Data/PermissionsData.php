<?php


namespace App\Model\Data;

use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;

/**
 * Class PermissionsData
 * @package App\Model\Data
 */
class PermissionsData
{

    const TABLE_NAME = 'admin_permissions';

    /**
     * 获取权限列表
     * @param $name
     * @param int $page
     * @param int $size
     * @return array
     * @throws DbException
     */
    public static function get_permissions_list($name, int $page, int $size)
    {
        $where = [];
        $orWhere = [];
        if($name){
            $where[]   = ['name_group_cn', 'like', "%{$name}%"];
            $orWhere[] = ['name_action_cn', 'like', "%{$name}%"];
        }
        $results = DB::table(self::TABLE_NAME)
            ->selectRaw('name_group, MAX(id) AS d')
            ->where($where)
            ->orWhere($orWhere)
            ->groupBy('name_group')
            ->orderBy('d', 'desc')
            ->forPage($page, $size)
            ->get()
            ->toArray();
        $count = DB::table(self::TABLE_NAME)->where($where)->orWhere($orWhere)->distinct()->count('name_group');
        return [
            'list'  => $results,
            'count' => $count
        ];
    }

    /**
     * 获取系统默认组，不允许删除
     * @return array
     */
    public static function get_system_group()
    {
        return [
            'roles', 'permissions', 'account'
        ];
    }

}
