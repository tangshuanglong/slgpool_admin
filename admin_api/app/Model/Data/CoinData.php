<?php


namespace App\Model\Data;


use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Redis\Redis;
use Swoft\Stdlib\Helper\JsonHelper;

class CoinData
{
    /**
     * 设置所有货币存到redis（包含所有的货币币种）
     * @return array|bool
     * @throws DbException
     */
    public static function set_redis_coins()
    {
        $re = self::get_coin_all();
        if ($re) {
            foreach ($re as $row) {
                $value = JsonHelper::encode($row);
                $field = $row['coin_name_en'];
                Redis::hset(config('table_coin'), $field, $value);
            }
            return $re;
        }
        return [];
    }

    /**
     * 设置单条
     * @param string $coin_type
     * @return array
     * @throws DbException
     */
    public static function set_redis_coin(string $coin_type)
    {
        $field = strtolower($coin_type);
        $data = self::get_coin_info_by_coin_type($coin_type);
        if ($data) {
            $value = JsonHelper::encode($data);
            Redis::hset(config('table_coin'), $field, $value);
        }
        return $data;
    }

    /**
     * 获取所有货币信息
     * return array
     * @throws DbException
     */
    public static function get_coins()
    {
        $res = Redis::hgetall(config('table_coin'));
        if (!$res) {
            return self::set_redis_coins();
        }
        $coins = [];
        foreach ($res as $val) {
            $coins[] = JsonHelper::decode($val, true);
        }
        return $coins;
    }

    /**
     * 根据货币英文名获取一条redis信息
     * @param $coin_type
     * @return array|mixed
     * @throws DbException
     */
    public static function get_coin(string $coin_type)
    {
        $coin_type = strtolower($coin_type);
        $field = strtolower($coin_type);
        $res = Redis::hget(config('table_coin'), $field);
        if (!$res) {
            return self::set_redis_coin($coin_type);
        } else {
            return JsonHelper::decode($res, true);
        }
    }

    /**
     * 删除redis coin
     * @param $coin_type
     * @return string
     */
    public static function del_redis_coin(string $coin_type)
    {
        $field = strtolower($coin_type);
        return Redis::hDel(config('table_coin'), $field);
    }

    /**
     * 更新coin
     * @param $data
     */
    public static function update_redis_coin(array $data)
    {
        // $field = $data['coin_name_en'];
        // Redis::hset(config('table_coin'), $field, json_encode($data));
        //循环删除
        $coin_list = self::get_coins();
        foreach ($coin_list as $v) {
            self::del_redis_coin($v['coin_name_en']);
        }
        //循环设置
        self::set_redis_coins();
    }

    /**
     * 获取单条币种信息
     * @param $id
     * @return array
     * @throws DbException
     */
    public static function get_coin_info(int $id)
    {
        return DB::table('coin')
            ->leftJoin('coin_token', 'coin.id', '=', 'coin_token.coin_id')
            ->leftJoin('chain', 'chain.id', '=', 'coin_token.chain_id')
            ->where(array(
                ['show_flag', '!=', 0],
                ['coin.id', '=', $id]
            ))->firstArray();
    }

    /**
     * 获取单条币种信息
     * @param string $coin_type
     * @return array
     * @throws DbException
     */
    public static function get_coin_info_by_coin_type(string $coin_type)
    {
        return DB::table('coin')
            ->where(array(
                ['show_flag', '!=', 0],
                ['coin_name_en', '=', strtolower($coin_type)]
            ))->firstArray();
    }

    /**
     * 获取所有coin
     * @return array|bool
     * @throws DbException
     */
    public static function get_coin_all()
    {
        return DB::table('coin')
            ->where('show_flag', '!=', '0')
            ->get()->toArray();
    }


    //获取金额数组
    public function get_price_list()
    {
        return array('usdt', 'eth', 'btc');
    }


    /**
     * 创建挖矿余额记录表
     * @param $coin_type
     * @return bool
     */
    public static function create_amount_log_table($coin_type)
    {
        $sql = "CREATE TABLE IF NOT EXISTS `bt_user_amount_log_mining_{$coin_type}` (
                  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '挖矿余额记录表',
                  `uid` int(11) NOT NULL,
                  `trade_type_id` smallint(4) NOT NULL COMMENT '交易类型id',
                  `trade_coin_type` varchar(32) NOT NULL COMMENT '交易货币类型',
                  `trade_coin_id` int(11) NOT NULL COMMENT '交易币种id',
                  `trade_coin_amount` varchar(32) NOT NULL COMMENT '交易币的数量',
                  `after_free_amount` varchar(32) NOT NULL COMMENT '用户该币种在交易前的可用余额',
                  `before_free_amount` varchar(32) NOT NULL COMMENT '用户该币种在交易后的可用余额',
                  `after_frozen_amount` varchar(32) NOT NULL COMMENT '用户该币种在交易前的冻结余额',
                  `before_frozen_amount` varchar(32) NOT NULL COMMENT '用户该币种在交易后的冻结余额',
                  `after_pledge_amount` varchar(32) NOT NULL COMMENT '用户该币种在交易前的抵押余额',
                  `before_pledge_amount` varchar(32) NOT NULL COMMENT '用户该币种在交易后的抵押余额',
                  `create_time` datetime NOT NULL COMMENT '创建记录的时间',
                  PRIMARY KEY (`id`),
                  KEY `uid` (`uid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";
        return DB::statement($sql);
    }

    /**
     * 重命名挖矿余额记录表
     * @param $coin_type
     * @return bool
     */
    public static function rename_amount_log_table($old_coin_type, $coin_type)
    {
        $sql = "RENAME TABLE `bt_user_amount_log_mining_{$old_coin_type}` TO `bt_user_amount_log_mining_{$coin_type}`";
        return DB::statement($sql);
    }
}
