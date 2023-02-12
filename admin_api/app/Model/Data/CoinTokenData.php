<?php


namespace App\Model\Data;


use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Eloquent\Model;
use Swoft\Db\Exception\DbException;
use Swoft\Db\Query\Builder;

class CoinTokenData
{
    /**
     * @param $chain_id
     * @param $search_key
     * @param $page_index
     * @return array
     * @throws DbException
     */
    public static function get_coin_token_list($chain_id, $search_key, $page_index)
    {
        if (!empty($search_key)) {
            $where = array(
                ['chain.chain_name', 'LIKE', '%'.$search_key.'%', 'OR'],
                ['coin_token.coin_name', 'LIKE', '%'.$search_key.'%', 'OR']
            );
        }

        $where[] = ['coin_token.chain_id', '=', $chain_id];
        $data['info'] = DB::table('coin_token')
                    ->leftJoin('chain', 'chain.id', '=', 'coin_token.chain_id')
                    ->where($where)
                    ->select('coin_token.*', 'chain.chain_name')
                    ->get()
                    ->toArray();

        $data['count'] = DB::table('coin_token')
                    ->leftJoin('chain', 'chain.id', '=', 'coin_token.chain_id')
                    ->where($where)
                    ->count();

        return $data;
    }

    /**
     * @param $id
     * @return bool|object|Model|Builder|null
     * @throws DbException
     */
    public static function get_coin_token_info($id)
    {
        $coin_token = DB::table('coin_token')->find($id);

        if ($coin_token) {
            return $coin_token;
        } else {
            return false;
        }
    }

    /**
     * @param $info
     * @return bool
     * @throws DbException
     * @throws ReflectionException
     * @throws ContainerException
     */
    public static function add_coin_token($info)
    {
        if (isset($info['contract_address']) && ! empty($info['contract_address'])) {
            $info['contract_address'] = strtolower(trim(htmlspecialchars($info['contract_address'])));
        }
        if (isset($info['contract_abi']) && ! empty($info['contract_abi'])) {
            $info['contract_abi'] = trim(htmlspecialchars($info['contract_abi']));
        }
        if (isset($info['next_start_sequence']) && empty(my_number_format($info['next_start_sequence']))) {
            $info['next_start_sequence'] = 0;
        }
        if (isset($info['property_id']) && empty(my_number_format($info['property_id']))) {
            $info['property_id'] = 0;
        }
        if (isset($info['decimals']) && empty(my_number_format($info['decimals']))) {
            $info['decimals'] = 0;
        }
        if (isset($info['asset_id']) && !empty($info['asset_id'])) {
            $info['asset_id'] = strtolower(trim(htmlspecialchars($info['asset_id'])));
        }

        $res = DB::table('coin_token')
            ->insertGetId([
                'coin_id'  => $info['coin_id'],
                'coin_name'  => $info['coin_name'],
                'chain_id'  => $info['chain_id'],
                'withdraw_theshold'  => $info['withdraw_theshold'],
                'warning_amount'  => $info['warning_amount'],
                'explorer_url'  => $info['explorer_url'],
                'explorer_url_parameter_address'  => $info['explorer_url_parameter_address'],
                'explorer_url_parameter_tx'  => $info['explorer_url_parameter_tx'],
                'is_main' => $info['is_main'],
                'cancel_flag' => $info['cancel_flag'],
                'coin_serials_id' => 0,
                'create_time' => time(),
                'next_start_sequence' => $info['next_start_sequence'],
                'asset_id' => $info['asset_id'],
                'contract_address' => $info['contract_address'],
                'contract_abi' => $info['contract_abi'],
                'decimals' => $info['decimals'],
                'property_id' => $info['property_id'],
                'min_withdraw'  => $info['min_withdraw'],
                'max_withdraw'  => $info['max_withdraw'],
                'min_deposit'  => $info['min_deposit']
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
    public static function update_coin_token($info)
    {
        $res = DB::table('coin_token')
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
     * @param $chain_id
     * @param $coin_name
     * @return bool
     * @throws DbException
     */
    public static function check_unique($chain_id, $coin_name)
    {
        $where = array(
            ['chain_id', '=', $chain_id],
            ['is_main', '=', 1],
            ['coin_name', '!=', $coin_name]
        );

        $check_unique = DB::table('coin_token')
            ->where($where)
            ->get()->toArray();

        if (!empty($check_unique)) {
            return false;
        } else {
            return true;
        }

    }

}
