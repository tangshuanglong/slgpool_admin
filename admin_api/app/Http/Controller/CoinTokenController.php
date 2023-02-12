<?php

namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\Coin;
use App\Model\Entity\CoinToken;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class CoinTokenController
 * @package App\Http\Controller
 * @Controller("/coin_token")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class CoinTokenController
{
    /**
     * 币种Token列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        $params = $request->params;
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        $coinName = $params['coin_name'] ?? '';
        $where = [];
        if ($coinName) {
            $where[] = ['ct.coin_name', 'like', '%' . $coinName . '%'];
        }

        $data = PaginationData::table('coin_token as ct')
            ->select('ct.*', 'chain.chain_name')
            ->leftJoin('chain', 'chain.id', '=', 'ct.chain_id')
            ->where($where)
            ->forPage($page, $size)
            ->get();
        if (!$data) {
            return false;
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 币种Token添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_coin_token(Request $request)
    {
        $params = $request->params;
        validate($params, 'CoinTokenValidator',
            ['coin_id', 'chain_id', 'display_name', 'contract_address', 'contract_abi', 'decimals',
                'account_name', 'is_main', 'property_id', 'explorer_url', 'explorer_url_parameter_address',
                'explorer_url_parameter_tx', 'withdraw_theshold', 'warning_amount', 'withdraw_fee', 'min_withdraw',
                'max_withdraw', 'min_deposit', 'cancel_flag']);

        // 检测公链和币种组合是否唯一的条件
        $where = [
            ['coin_id', '=', $params['coin_id']],
            ['chain_id', '=', $params['chain_id']]
        ];

        if ($params['action_type'] === 'add') {
            $coinToken = CoinToken::new();
        } else {
            $coinToken = CoinToken::find($params['id']);
            if (!$coinToken) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '公链信息不存在');
            }
            // 如果是编辑，检测时需要排除自身
            $where = array_merge($where, [['id', '!=', $params['id']]]);
        }

        // 获取币种信息
        $coin = Coin::find($params['coin_id']);
        if (!$coin) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '所选币种不存在');
        }

        // 检测币种和公链组合是否唯一
        if (DB::table('coin_token')->where($where)->firstArray()) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '该币种公链组合已存在，请更换币种或者公链');
        }

        $coinToken->setCoinId($params['coin_id']);
        $coinToken->setCoinName($coin['coin_name_en']);
        $coinToken->setChainId($params['chain_id']);
        $coinToken->setDisplayName($params['display_name']);
        $coinToken->setContractAddress($params['contract_address']);
        $coinToken->setContractAbi($params['contract_abi']);
        $coinToken->setDecimals($params['decimals']);
        $coinToken->setAccountName($params['account_name']);
        $coinToken->setIsMain($params['is_main']);
        $coinToken->setPropertyId($params['property_id']);
        $coinToken->setExplorerUrl($params['explorer_url']);
        $coinToken->setExplorerUrlParameterAddress($params['explorer_url_parameter_address']);
        $coinToken->setExplorerUrlParameterTx($params['explorer_url_parameter_tx']);
        $coinToken->setWithdrawTheshold($params['withdraw_theshold']);
        $coinToken->setWarningAmount($params['warning_amount']);
        $coinToken->setWithdrawFee($params['withdraw_fee']);
        $coinToken->setMinWithdraw($params['min_withdraw']);
        $coinToken->setMaxWithdraw($params['max_withdraw']);
        $coinToken->setMinDeposit($params['min_deposit']);
        $coinToken->setCancelFlag($params['cancel_flag']);
        $res = $coinToken->save();
        if (!$res) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '操作币种token表错误');
        }
        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }

    /**
     * 获取单条币种Token数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('coin_token')->where(['id' => $id])->firstArray();

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }
}
