<?php


namespace App\Model\Data;


use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Eloquent\Model;
use Swoft\Db\Exception\DbException;
use Swoft\Db\Query\Builder;

class RebateLevelConfigData
{
    /**
     * 判断邀请返佣等级是否存在
     *
     * @param $level
     * @param $unit
     * @param $coin_type
     * @param null $id
     * @return bool|object|Model|Builder|null
     * @throws DbException
     */
    public static function exitConfigLevel($level, $unit, $coin_type, $id = null)
    {
        $where = [
            ['level', '=', $level],
            ['unit', '=', $unit],
            ['coin_type', '=', $coin_type]
        ];
        if ($id) {
            $where = array_merge($where, [['id', '!=', $id]]);
        }

        $config = DB::table('rebate_level_config')->where($where)->firstArray();
        if (!$config) {
            return false;
        }
        return true;
    }
}
