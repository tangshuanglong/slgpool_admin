<?php

namespace App\Http\Controller;

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;
use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\PowerIncome;
use App\Model\Entity\PowerOrder;
use Swoft\Bean\BeanFactory;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Log\Helper\CLog;
use Throwable;

/**
 * Class PowerOrderController
 * @package App\Http\Controller
 * @Controller("/power_order")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class PowerOrderController
{
    /**
     * 订单统计
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function statistic(Request $request)
    {
        $params = $request->get();
        // 获取id常量，得到推荐id
        $invitePrefix = (int)config('invite_prefix');
        $where = $this->filter($params, $invitePrefix);
        $count = PowerOrder::where($where)->count();
        $totalHash = PowerOrder::where($where)->sum('total_hash');
        $totalPrice = PowerOrder::where($where)->sum('total_price');
        $data = [
            'count'       => $count,
            'total_hash'  => $totalHash,
            'total_price' => $totalPrice
        ];
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 订单列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    function list(Request $request)
    {
        $params = $request->get();
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        // 获取id常量，得到推荐id
        $invitePrefix = (int)config('invite_prefix');
        $where = $this->filter($params, $invitePrefix);
        $data = PaginationData::table('power_order')->where($where)->orderByDesc('id')->forPage($page, $size)->get();
        foreach ($data['list'] as $key => $item) {
            $data['list'][$key]['manage_fee'] = bcmul($item['manage_fee'], 100);
            $data['list'][$key]['user_invite_id'] = $item['uid'] + $invitePrefix;
            $data['list'][$key]['user_group'] = DB::table('user_basical_info')->where(['id' => $item['uid']])->value('user_group');
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 订单单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $invitePrefix = (int)config('invite_prefix');
        $data = DB::table('power_order')->where(['id' => $id])->firstArray();
        if ($data) {
            $data['manage_fee'] = bcmul($data['manage_fee'], 100);
            $data['user_invite_id'] = $data['uid'] + $invitePrefix;
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 上架
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function setOrderToWorks(Request $req)
    {
        $params = $req->post();
        // 判断订单是否为 等待上架中
        $order = PowerOrder::find($params["id"]);
        if (!$order) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '订单不存在');
        }
        if ($order->getOrderStatus() != 0) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '订单已经上架工作了');
        }

        DB::beginTransaction();
        try {
            // 产品上架
            $order->setShelfDate(date('Y-m-d H:i:s'));
            $order->setOrderStatus(1);
            $res = $order->save();
            if (!$res) {
                throw new \Exception('订单保存出错');
            }
            if ($order->getProductType() == 3) {
                if (env('APP_DEBUG') != 1) {//线上
                    $release_date = date('Y-m-d H:i:s', time() + ($order['period'] - 180) * 86400 + 2 * 86400);
                } else {//测试
                    $release_date = date('Y-m-d H:i:s', time() + ($order['period'] - 180) * 60 + 2 * 60);//多加2天：隔天收益、到期后一天返还
                }
                $bt_coin_store_log_res = DB::table('coin_store_log')->where('order_id', $order->getId())->update(['release_date' => $release_date]);
                if (!$bt_coin_store_log_res) {
                    throw new \Exception('存币记录释放日期保存出错');
                }
            }

            DB::commit();
            return MyQuit::returnSuccess([], MyCode::SUCCESS, 'success');
        } catch (\Exception $e) {
            CLog::warning($e->getMessage());
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * 下架
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function set_order_off_shelf(Request $req)
    {
        $params = $req->post();
        $order = PowerOrder::find($params["id"]);
        if (!$order) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '订单不存在');
        }
        // 判断订单是否为“服务中”
        if ($order->getOrderStatus() != 1) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '订单非服务中');
        }
        $order->setOrderStatus(6);
        $res = $order->save();
        if (!$res) {
            throw new \Exception('订单保存出错');
        }
        return MyQuit::returnSuccess([], MyCode::SUCCESS, 'success');
    }

    /**
     * 改价
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function change_price(Request $request)
    {
        $params = $request->post();
        $order = PowerOrder::find($params['id']);
        if (!$order) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '订单不存在！');
        }
        if ($order->getOrderStatus() != 2) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '只有待付款订单才能改价！');
        }
        if ($params['change_price'] == $order->getPrice()) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '订单价格并末改变！');
        }
        $total_price = bcmul($params['change_price'], $order->getBuyQuantity(), 2);
        $order->setPrice($params['change_price']);
        $order->setTotalPrice($total_price);
        $res = $order->save();
        if (!$res) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '修改失败');
        }
        return MyQuit::returnSuccess([], MyCode::SUCCESS, 'success');
    }

    /**
     * 更改有效算力
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function change_valid_hash(Request $request)
    {
        $params = $request->post();
        $order = PowerOrder::find($params['id']);
        if (!$order) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '订单不存在！');
        }
        if ($order->getIsPledge() != 1 && $order->getOrderStatus() != 0) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '只有上架订单才能更改有效算力！');
        }
        if ($params['change_valid_hash'] == $order->getValidHash()) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '有效算力并末改变！');
        }
        $order->setValidHash($params['change_valid_hash']);
        $res = $order->save();
        if (!$res) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '修改失败');
        }
        return MyQuit::returnSuccess([], MyCode::SUCCESS, 'success');
    }

    /**
     * 筛选参数
     * @param $params
     * @param $invitePrefix
     * @return array
     */
    protected function filter($params, $invitePrefix): array
    {
        $orderNumber = $params['order_number'] ?? '';
        $userId = $params['uid'] ?? '';
        $productName = $params['product_name'] ?? '';
        $productType = $params['product_type'] ?? '';
        $orderStatus = $params['order_status'] ?? '';
        $where = [];
        if ($orderNumber) {
            $where[] = ['order_number', '=', $orderNumber];
        }
        if ($userId) {
            $userId = $userId - $invitePrefix;
            $where[] = ['uid', '=', $userId];
        }
        if ($productName) {
            $where[] = ['product_name', 'like', '%' . $productName . '%'];
        }
        if ($productType) {
            $where[] = ['product_type', '=', $productType];
        }
        if ($orderStatus || $orderStatus === "0") {
            $where[] = ['order_status', '=', (int)$orderStatus];
        }
        return $where;
    }
}
