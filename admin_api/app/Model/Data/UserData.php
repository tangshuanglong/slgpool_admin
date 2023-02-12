<?php


namespace App\Model\Data;


use App\Rpc\Lib\CoinInterface;
use ReflectionException;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Redis\Redis;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;

/**
 * Class UserData
 * @package App\Model\Data
 * @Bean("UserData")
 */
class UserData
{

    /**
     * @Reference(pool="system.pool")
     * @var CoinInterface
     */
    private $coinService;

    /**
     * 获取用户列表
     * @param $select_type
     * @param $page
     * @param $size
     * @param $search_key
     * @param $invitor_uid
     * @param $uid
     * @param $user_group
     * @return array|int
     * @throws DbException
     */
    public static function get_user_list($select_type, $page, $size, $search_key, $invitor_uid, $uid, $user_group)
    {
        $where = [];
        if (!empty($search_key)) {
            $where = array(
                ['email', 'LIKE', '%' . $search_key . '%', 'or'],
                ['mobile', 'LIKE', '%' . $search_key . '%', 'or'],
            );
        }
        if (!empty($invitor_uid)) {
            $where[] = ['invitor_uid', '=', $invitor_uid];
        }
        if (!empty($uid)) {
            $where[] = ['invite_id', '=', $uid];
        }
        if (!empty($user_group)) {
            $where[] = ['user_group', '=', $user_group];
        }
        if ($select_type == 1) {
            $data['list'] = DB::table('user_basical_info as t1')
                ->select('t1.*', 't2.name_cn')
                ->where($where)
                ->leftJoin('country_code as t2', 't1.area_code', '=', 't2.area_code')
                ->orderByDesc('id')
                ->forPage($page, $size)
                ->get()
                ->toArray();
            $data['count'] = DB::table('user_basical_info')->where($where)->count();
        } else {
            $data = DB::table('user_basical_info')
                ->where($where)
                ->count('invite_total_times');
        }

        return $data;
    }

    /**
     * 获取用户所有信息
     * @param $uid
     * @return array|bool|mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function get_user_all_info($uid)
    {
        $key = config('login_user_info_key');
        $field = config('field_prefix').$uid;
        $data = Redis::hGet($key, $field);
        //如果缓存获取不到
        if (!$data) {
            $data = DB::table('user_basical_info')->where(['id' => $uid])->first();
            if (!$data) {
                return false;
            }
            //设置缓存
            Redis::hSet($key, $field, json_encode($data));
        }else{
            $data = json_decode($data, true);
        }
        return $data;
    }


    /**
     * 重置用户所有信息的缓存
     * @param $uid
     * @return bool|int|string
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function reset_user_all_info($uid)
    {
        $key = config('login_user_info_key');
        $field = config('field_prefix').$uid;
        $res = Redis::hDel($key, $field);
        if ($res) {
            $data = DB::table('user_basical_info')->where(['id' => $uid])->first();
            if (!$data) {
                return false;
            }
            //设置缓存
            return Redis::hSet($key, $field, json_encode($data));
        }
        return $res;
    }

    /**
     * 总金额和实际金额统计
     * @param array $total_amounts
     * @param array $real_amounts
     * @return mixed
     */
    public function statistic(array $total_amounts, array $real_amounts)
    {
        $total_amount = '0';
        //缓存价格，可复用
        $cache_price = [];
        //统计总金额，单位usdt
        foreach ($total_amounts as $value) {
            $usdt_price = $this->coinService->get_coin_last_price($value['coin_name'], 'usdt');
            $cache_price[$value['coin_name'] . 'usdt'] = $usdt_price;
            $total_amount = bcadd($usdt_price * $value['amount'], $total_amount, 8);
        }
        $real_amount = '0';
        $fee_amount = '0';
        //统计实际完成金额，单位usdt
        foreach ($real_amounts as $value) {
            if (isset($cache_price[$value['coin_name'] . 'usdt'])) {
                $usdt_price = $cache_price[$value['coin_name'] . 'usdt'];
            } else {
                $usdt_price = $this->coinService->get_coin_last_price($value['coin_name'], 'usdt');
            }
            $real_amount = bcadd($usdt_price * $value['amount'], $real_amount, 8);
            if (isset($value['fee_amount'])) {
                $fee_amount = bcadd($usdt_price * $value['fee_amount'], $fee_amount, 8);
            }
        }
        $data['success_amount'] = $real_amount;
        $data['total_coin_amount'] = $total_amount;
        $data['fee_amount'] = $fee_amount;
        return $data;
    }

    /**
     * 查询条件
     * @param $params
     * @return array
     */
    public static function filter($params)
    {
        $invite_id = $params['invite_id'] ?? '';
        $coin_id = $params['coin_id'] ?? '';
        $start_date = $params['start_date'] ?? '';
        $end_date = $params['end_date'] ?? '';
        $status = $params['status'] ?? '';
        //需要和提币列表一样的查询条件
        $where = [];
        if ($coin_id) {
            $where[] = ['coin_id', '=', $coin_id];
        }
        if ($status) {
            $where[] = ['status', '=', $status];
        }
        if ($invite_id) {
            $uid = $invite_id - config('invite_prefix');
            $where[] = ['uid', '=', $uid];
        }
        if ($start_date) {
            $where[] = ['created_at', '>=', $start_date];
        }
        if ($end_date) {
            $where[] = ['created_at', '<=', $end_date];
        }
        return $where;
    }
}
