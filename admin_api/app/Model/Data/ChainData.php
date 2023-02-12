<?php


namespace App\Model\Data;


use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Eloquent\Model;
use Swoft\Db\Exception\DbException;
use Swoft\Db\Query\Builder;

class ChainData
{
    /**
     * @param $id
     * @return bool|object|Model|Builder|null
     * @throws DbException
     */
    public static function get_chain_info($id)
    {
        $chain = DB::table('chain')
            ->find($id);

        if (!$chain) {
            return false;
        }
        return $chain;
    }

    /**
     * @param $info
     * @return bool
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function add_chain($info)
    {
        $res = DB::table('chain')
            ->insertGetId([
                'chain_name'  => $info['chain_name'],
                'confirmation_time'  => $info['confirmation_time'],
                'next_start_sequence'  => 0,
                'system_hot_wallet'  => $info['system_hot_wallet'],
                'cancel_flag'  => isset($info['cancel_flag']) ? 1 : 0,
                'create_time'  => time(),
                'update_time'  => time(),
                'system_cold_wallet'  => $info['system_cold_wallet'],
                'is_graphene'  => isset($info['is_graphene']) ? 1 : 0,
                'is_anonymous'  => isset($info['is_anonymous']) ? 1 : 0
            ]);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $info
     * @return bool
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function update_chain($info)
    {
        $res = DB::table('chain')
            ->where('id', $info['id'])
            ->update([
                'chain_name'  => $info['chain_name'],
                'confirmation_time'  => $info['confirmation_time'],
                'system_hot_wallet'  => $info['system_hot_wallet'],
                'update_time'  => time(),
                'system_cold_wallet'  => $info['system_cold_wallet'],
                'is_graphene'  => isset($info['is_graphene']) ? 1 : 0,
                'is_anonymous'  => isset($info['is_anonymous']) ? 1 : 0
            ]);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取所有chain
     * @return array|bool
     * @throws DbException
     */
    public static function get_chain_all()
    {
        $chain = DB::table('chain')
            ->get()
            ->toArray();

        if ($chain) {
            return $chain;
        } else {
            return false;
        }
    }
}
