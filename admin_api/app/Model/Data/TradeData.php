<?php


namespace App\Model\Data;


use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Redis\Redis;

class TradeData
{

    /**
     * 获取提现/充值记录
     * @param $page_index
     * @param $search_key
     * @param $order_type
     * @param $coin_type
     * @param $start_time
     * @param $end_time
     * @param $get_cash
     * @param $recharge
     * @return mixed
     * @throws DbException
     */
    public static function get_user_trade_log($page_index, $search_key, $order_type, $coin_type, $start_time, $end_time, $get_cash, $recharge)
    {
        $where = [];

//        if (!empty($search_key)) {
//            $where = array(
//                ['email', 'LIKE', '%'.$search_key.'%', 'or'],
//                ['id', 'LIKE', '%'.$search_key.'%', 'or'],
//                ['mobile', 'LIKE', '%'.$search_key.'%', 'or'],
//            );
//        }
//        if (! empty($search_key))
//        {
//            $clauses['group'] = array();
//            $clauses['group']['like'] = array(
//                'user_basical_info.invite_id' => $search_key
//            );
//        }

        if (!empty($order_type))
        {
            $where[] = ['user_trade_amount_log_dw.trade_order_type_id', $order_type];
        }
//        if (!empty($coin_type))
//        {
//            $coin_data = self::get_redisCoinByCoinType($coin_type);
//            $where[] = ['user_trade_amount_log_dw.trade_coin_id', $coin_data['id']];
//        }
        if (!empty($start_time))
        {
            $where[] = ['user_trade_amount_log_dw.create_time', '>=', strtotime($start_time)];
        }
        if (!empty($end_time))
        {
            $where[] = ['user_trade_amount_log_dw.trade_order_type_id', '<=', strtotime($end_time)];
        }

        $wherein = [$get_cash['type'], $recharge['type']];

        $per_num = config('per_page_num');
        $data['info'] = DB::table('user_amount_log_dw')
                ->leftjoin('user_basical_info', 'user_amount_log_dw.uid', '=', 'user_basical_info.id')
                ->select('user_basical_info.invite_id', 'user_amount_log_dw.*')
                ->where($where)
                ->whereIn('trade_type_id', $wherein)
                ->orderByDesc('create_time')
                ->forPage($page_index, $per_num)
                ->get()->toArray();

        $data['count'] = DB::table('user_amount_log_dw')
            ->leftjoin('user_basical_info', 'user_amount_log_dw.uid', '=', 'user_basical_info.id')
            ->where($where)
            ->whereIn('trade_type_id', $wherein)
            ->count();

        return $data;
    }

    public static function get_user_trade_sum($search_key, $coin_type, $start_time, $end_time)
    {

        if(!empty($coin_type)){
            $where[] = ['trade_coin_type', '=', $coin_type]  ;
        }
//        if(!empty($search_key)){
//            $clauses_deposit['group']['like'] = array(
//                'uid' => (int)$search_key - INVITE_PREFIX,
//            );
//            $clauses_deposit['group']['or_like'] = array(
//                'trade_sn' => $search_key,
//            );
//        }
        if (! empty($start_time)){
            $where[] = ['create_time', '>=', strtotime($start_time)];
        }
        if (! empty($end_time)){
            $where[] = ['create_time', '<=', strtotime($end_time)];
        }

        $where[] = ['trade_type_id', '=', 6];
        $where[] = ['uid', '>=', '515'];

//        vdump($where);
        $trade = DB::table('user_amount_log_dw')
            ->where($where)
            ->selectRaw('trade_coin_type as coin_name, sum(trade_coin_amount) as amount')
            ->groupBy('trade_coin_type')
            ->get()
            ->toArray();

        return $trade;
    }

    /**
     * 根据交易类型的名称获取对应信息
     * @param $type_name_en
     * @return array|mixed
     * @throws DbException
     */
    public static function get_trade_type_info($type_name_en){
        $key = "table:trade_type";
        $field = "trade_type:name".$type_name_en;
        $re = Redis::hget($key,$field);
        if(!$re){
            $bool = self::set_trade_type();
            if(!$bool) return array();

            $re = Redis::hget($key,$field);
            return json_decode($re,1);
        }else{
            return json_decode($re,1);
        }
    }

    /**
     * 获取交易类型
     * @return array
     * @throws DbException
     */
    public static function get_trade_type(){
        $trade_type = DB::table('trade_type_dw')->get()->toArray();
//        vdump($trade_type);
        return $trade_type;
    }

    /**
     * 缓存交易类型
     * @return bool
     * @throws DbException
     */
    public static function set_trade_type(){
        $key = "table:trade_type";
        $re = self::get_trade_type();
        if($re){
            foreach ($re as $row){
                $value = json_encode($row);
                $field = "trade_type:name".$row['type_name_en'];
                Redis::hset($key,$field,$value);
            }
            return true;
        }else{
            return false;
        }
    }
}
