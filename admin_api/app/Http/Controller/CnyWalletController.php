<?php

namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\WalletPayMethod;
use App\Model\Entity\WalletPayOrders;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Throwable;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use App\Rpc\Lib\WalletDwInterface;

/**
 * Class CnyWalletController
 * @package App\Http\Controller
 * @Controller("/cny_wallet")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class CnyWalletController
{

    /**
     * @Reference(pool="user.pool")
     *
     * @var WalletDwInterface
     */
    private $walletService;

    /**
     * 充值订单列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        $params = $request->get();
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        $where = [];
        if (isset($params["order_number"]) && !empty($params["order_number"])) {
            $where['wpo.order_id'] = $params["order_number"];
        }
        if (isset($params["uid"]) && !empty($params["uid"])) {
            $where['wpo.uid'] = $params["uid"] - config('invite_prefix');
        }
        if (isset($params["order_type"]) && !empty($params["order_type"])) {
            $where['wpm.pay_type'] = $params["order_type"];
        }
        if (isset($params["order_status"]) && $params["order_status"] !== "") {
            $where['wpo.status'] = $params["order_status"];
        }
        $data = PaginationData::table('wallet_pay_orders as wpo')
            ->select('wpo.*', 'il.real_name', 'au.user_name as reviewer', 'wpm.pay_type', 'wpm.pay_name')
            ->leftJoin('identity_log as il', 'il.uid', '=', 'wpo.uid')
            ->leftJoin('admin_users as au', 'au.user_id', '=', 'wpo.reviewer_by')
            ->leftJoin('wallet_pay_method as wpm', 'wpm.id', '=', 'wpo.method_id')
            ->where($where)
            ->whereNotIn('il.status_flag', [0, 2])
            ->orderByDesc('wpo.id')
            ->forPage($page, $size)
            ->get();
        foreach ($data['list'] as &$row) {
            $row['uid'] = $row['uid'] + config('invite_prefix');
            unset($row);
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 充值订单审核
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function setOrderStatus(Request $req)
    {
        $params = $req->params;
        $status = $params["status"];
        $price = $params["price"];

        // 判断订单及设置订单状态
        $order = WalletPayOrders::find($params["id"]);
        if (!$order) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '订单不存在');
        }

        // 检查订单状态
        if ($order->getStatus() != 0) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '订单已审核！');
        }
        $order->setStatus($status);
        $order->setUpdateTime(time());
        $order->setReviewerBy($req->uid);
        $order->setReviewTime(date("Y-m-d H:i:s"));
        $order->setActualPrice($price);
        //给用户添加余额
        $res = $this->walletService->append_wallet_free($order->getUid(), $price, '26', "deposit");
        if ($res === false) {
            return MyQuit::returnMessage(MyCode::BALANCE_ERROR, '用户充值失败！');
        }
        $res = $order->save();
        if (!$res) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '订单保存出错');
        }

        return MyQuit::returnSuccess([], MyCode::SUCCESS, 'success');
    }

    /**
     * 老板钱包列表
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function pay_channel_list(Request $request)
    {
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        $data = PaginationData::table('wallet_pay_method')
            ->forPage($page, $size)
            ->orderByDesc('id')
            ->get();

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 老板钱包添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function pay_channel_add(Request $request): array
    {
        $params = $request->params;

        $method = WalletPayMethod::find($params["id"] ?? 0);
        if (!$method) {
            $method = new WalletPayMethod();
        }

        $method->setAccountNumber($params["account_number"]);
        $method->setAccountName($params["account_name"]);
        $method->setBankName($params["bank_name"]);
        if ($params['pay_type'] == 1) {
            $method->setPayName("银行转账");
        } elseif ($params['pay_type'] == 2) {
            $method->setPayName("支付宝转账");
        }
        $method->setPayType($params["pay_type"]);
        if ($method->save()) {
            return MyQuit::returnSuccess([], MyCode::SUCCESS, 'success');
        } else {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '收款方式保存出错');
        }
    }

    /**
     * 老板钱包单条数据
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function pay_channel_get(Request $request): array
    {
        $params = $request->params;
        $method = WalletPayMethod::find($params["id"] ?? 0);
        if (!$method) {
            $method = new WalletPayMethod();
        }

        return MyQuit::returnSuccess($method->toArray(), MyCode::SUCCESS, 'success');
    }

    /**
     * 老板钱包删除
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function pay_channel_del(Request $request): array
    {
        $params = $request->params;
        $id = $params['id'] ?? 0;
        $is_success = WalletPayMethod::find($id);
        if (!empty($is_success)) {
            if ($is_success->delete()) {
                return MyQuit::returnSuccess([], MyCode::SUCCESS, 'success');
            } else {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '删除失败！');
            }
        } else {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '删除失败！');
        }
    }
}
