<?php

namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\CoinExchange;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * Class CoinExchangeController【暂时没用】
 * @package App\Http\Controller
 * @Controller("/coin_exchange")
 * @Middlewares({
 * })
 */
class CoinExchangeController
{
    /**
     * 闪兑交易记录列表
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        $params = $request->params;
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;

        // 获取id常量，得到推荐id
        $invitePrefix = (int)config('invite_prefix');
        $where = $this->filter($params, $invitePrefix);

        $data = PaginationData::table('coin_exchange')->where($where)->forPage($page, $size)->get();
        foreach ($data['list'] as $key => $item) {
            $data['list'][$key]['user_invite_id'] = $item['uid'] + $invitePrefix;
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 闪兑交易记录统计
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function exchange_statistic(Request $request)
    {
        $params = $request->params;

        // 获取id常量，得到推荐id
        $invitePrefix = (int)config('invite_prefix');
        $where = $this->filter($params, $invitePrefix);

        $count = CoinExchange::where($where)->count();
        $serviceChargeTotal = CoinExchange::where($where)->sum('service_charge');
        $amountTotal = CoinExchange::where($where)->sum('amount');
        $data = [
            'count' => $count,
            'service_charge_total' => $serviceChargeTotal,
            'amount_total' => $amountTotal
        ];

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 闪兑交易记录单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('coin_exchange')->where(['id' => $id])->firstArray();

        // 获取id常量，得到推荐id
        $invitePrefix = (int)config('invite_prefix');
        if ($data) {
            $data['uid'] = $data['uid'] + $invitePrefix;
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 筛选
     * @param $params
     * @param int $invitePrefix
     * @return array
     */
    protected function filter($params, int $invitePrefix): array
    {
        $userId = $params['uid'] ?? '';
        $coinType = $params['coin_type'] ?? '';
        $priceType = $params['price_type'] ?? '';
        $exchangeMethod = $params['exchange_method'] ?? '';
        $startTime = $params['start_date'] ?? '';
        $endTime = $params['end_date'] ?? '';
        $where = [];

        if ($userId) {
            $userId = $userId - $invitePrefix;
            $where[] = ['uid', '=', $userId];
        }
        if ($coinType) {
            $where[] = ['coin_type', '=', $coinType];
        }
        if ($priceType) {
            $where[] = ['price_type', '=', $priceType];
        }
        if ($exchangeMethod) {
            $where[] = ['exchange_method', '=', $exchangeMethod];
        }
        if ($startTime) {
            $where[] = ['created_at', '>', $startTime];
        }
        if ($endTime) {
            $where[] = ['created_at', '<', $endTime];
        }
        return $where;
    }
}
