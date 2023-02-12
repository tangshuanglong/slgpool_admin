<?php


namespace App\Model\Data;


use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Eloquent\Model;
use Swoft\Db\Exception\DbException;
use Swoft\Db\Query\Builder;

class ConfigData
{
    /**
     * 判断配置是否存在
     *
     * @param $group
     * @param $name
     * @param null $id
     * @return bool|object|Model|Builder|null
     * @throws DbException
     */
    public static function exitConfigGroupName($group, $name, $id = null)
    {
        $where = [
            ['group', '=', $group],
            ['name', '=', $name]
        ];
        if ($id) {
            $where = array_merge($where, [['id', '!=', $id]]);
        }

        $config = DB::table('config')->where($where)->firstArray();

        if (!$config) {
            return false;
        }
        return true;
    }

    /**
     * 删除配置
     * @param $id
     * @return int
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function delete_config($id)
    {
        $res = DB::table('config')
            ->where('id', $id)
            ->delete();

        return $res;
    }
}
