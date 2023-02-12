<?php
namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\CoinData;
use App\Model\Data\PaginationData;
use App\Model\Entity\Coin;
use App\Rpc\Lib\KlineInterface;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Log\Helper\CLog;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class CoinController
 * @package App\Http\Controller
 * @Controller("/coin")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class CoinController
{
    /**
     * @Reference(pool="system.pool")
     *
     * @var KlineInterface
     */
    private $klineService;

    /**
     * 币种列表(全量)
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function coin_all(Request $request)
    {
        $data = PaginationData::table('coin')->select('id', 'coin_name_cn', 'coin_name_en', 'mining_enable')->get();
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 币种列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function coin_list(Request $request)
    {
        $params = $request->params;
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        $coin_name_en = $params['coin_name_en'] ?? '';
        $where = [];
        if ($coin_name_en) {
            $where[] = ['coin_name_en', '=', $coin_name_en];
        }
        $data = PaginationData::table('coin')->where($where)->forPage($page, $size)->get();
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 币种添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_coin(Request $request)
    {
        $params = $request->params;
        validate($params, 'CoinValidator');
        if ($params['action_type'] === 'add') {
            $coin = Coin::new();
        } else {
            $coin = Coin::find($params['id']);
            if (!$coin) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '币种信息不存在');
            }
            $old_coin_type = $coin->getCoinNameEn();
        }
        DB::beginTransaction();
        try {
            $coin->setCoinNameEnComplete($params['coin_name_en_complete']);
            $coin->setCoinNameCn($params['coin_name_cn']);
            $coin->setCoinNameEn($params['coin_name_en']);
            $coin->setCoinIcon($params['coin_icon'] ?? '');
            $coin->setPublicDate(date("Y-m-d H:i:s", strtotime($params['public_date'])));
            $coin->setTotalPublicNumber($params['total_public_number']);
            $coin->setCoinAlgorithm($params['coin_algorithm']);
            $coin->setOfficialWalletLink($params['official_wallet_link']);
            $coin->setOfficialWebsiteLink($params['official_website_link']);
            $coin->setSourceCodeLink($params['source_code_link']);
            $coin->setMiningLink($params['mining_link']);
            $coin->setForumLink($params['forum_link']);
            $coin->setCoinIntroduction($params['coin_introduction']);
            $coin->setInventory($params['inventory']);
            $coin->setChargeStatus($params['charge_status']);
            $coin->setGetCashStatus($params['get_cash_status']);
            $coin->setShowFlag($params['show_flag']);
            $coin->setMiningEnable($params['mining_enable']);
            $res = $coin->save();
            if (!$res) {
                throw new \Exception('操作币种表错误');
            }
            if ($params['action_type'] === 'add') {
                $res = CoinData::create_amount_log_table($params['coin_name_en']);
                if (!$res) {
                    throw new \Exception('创建余额记录表错误');
                }
            }else{
                if($params['coin_name_en'] != $old_coin_type){
                    $res = CoinData::rename_amount_log_table($old_coin_type, $params['coin_name_en']);
                    if (!$res) {
                        throw new \Exception('修改余额记录表错误');
                    }
                }
            }
            unset($params['action_type']);
            $params['id'] = $coin->getId();
            DB::commit();
            CoinData::update_redis_coin($params);
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        } catch (\Exception $e) {
            CLog::warning($e->getMessage());
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * 币种单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get_coin")
     */
    public function get_coin(int $id)
    {
        $data = DB::table('coin')->where(['id' => $id])->firstArray();

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 单条币种区块信息
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function get_coin_block_stats(Request $request)
    {
        $param = $request->params;

        if (!$param['coin_type']) {
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }

        $data = DB::table('coin_block_stats')->where(['coin_type' => $param['coin_type']])->firstArray();
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 获取交易的价格
     * @param Request $request
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function get_exchange_price(Request $request)
    {
        $params = $request->params;
        $coinType = $params['coin_type'] ?? '';
        $priceType = $params['price_type'] ?? '';

        // 获取最新价格
        $price = $this->klineService->get_last_close_price($coinType, $priceType);
        $data = ['price' => $price];

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }
}
