<?php

namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\Chain;
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
 * Class ChainController
 * @package App\Http\Controller
 * @Controller("/chain")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class ChainController
{
    /**
     * 公链列表(全量获取)
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function all(Request $request)
    {
        $data = PaginationData::table('chain')->select('id', 'chain_name')->get();
        if (!$data) {
            return false;
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 公链列表
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
        $chainName = $params['chain_name'] ?? '';
        $where = [];
        if ($chainName) {
            $where[] = ['chain_name', 'like', '%' . $chainName . '%'];
        }
        $data = PaginationData::table('chain')->where($where)->forPage($page, $size)->get();

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 公链添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_chain(Request $request)
    {
        $params = $request->params;
        validate($params, 'ChainValidator');
        if ($params['action_type'] === 'add') {
            $chain = Chain::new();
        } else {
            $chain = Chain::find($params['id']);
            if (!$chain) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '公链信息不存在');
            }
        }

        $chain->setChainName($params['chain_name']);
        $chain->setConfirmationTime($params['confirmation_time']);
        $chain->setNextStartSequence($params['next_start_sequence']);
        $chain->setSystemHotWallet($params['system_hot_wallet']);
        $chain->setSystemColdWallet($params['system_cold_wallet']);
        $chain->setIsGraphene($params['is_graphene']);
        $chain->setIsAnonymous($params['is_anonymous']);
        $chain->setCancelFlag($params['cancel_flag']);
        $res = $chain->save();
        if (!$res) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '操作公链表错误');
        }

        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }

    /**
     * 公链单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('chain')->where(['id' => $id])->firstArray();

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }
}
