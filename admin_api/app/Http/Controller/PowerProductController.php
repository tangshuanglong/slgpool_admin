<?php

namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
// use App\Lib\MyRabbitMq;
use App\Model\Data\PaginationData;
use App\Model\Entity\PowerProduct;
use App\Rpc\Lib\KlineInterface;
use Swoft\Bean\BeanFactory;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Redis\Redis;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class ProductController
 * @package App\Http\Controller
 * @Controller("/power_product")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class PowerProductController
{
    /**
     * 所有矿机列表（全量）
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function all(Request $request)
    {
        $data = DB::table('power_product')->select('id', 'product_name')->where('is_activity', 1)->get();

        return MyQuit::returnSuccess($data->toArray(), MyCode::SUCCESS, 'success');
    }

    /**
     * 产品列表
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
        $coinType = $params['coin_type'] ?? '';
        $productType = $params['product_type'] ?? '';
        $statusFlag = $params['status_flag'] ?? '';
        $isActivity = $params['is_activity'] ?? '';
        $productName = $params['product_name'] ?? '';

        $where = [];
        if ($coinType) {
            $where[] = ['mp.coin_type', '=', $coinType];
        }
        if ($productType) {
            $where[] = ['mp.product_type', '=', $productType];
        }
        if ($statusFlag || $statusFlag === "0") {
            $where[] = ['mp.status_flag', '=', (int)$statusFlag];
        }
        if ($isActivity || $isActivity === "0") {
            $where[] = ['mp.is_activity', '=', (int)$isActivity];
        }
        if ($productName) {
            $where[] = ['mp.product_name', 'like', '%' . $productName . '%'];
        }

        $data = PaginationData::table('power_product as mp')
            ->select('mp.*', 'mm.name')
            ->leftJoin('power_machine as mm', 'mp.mining_machine_id', '=', 'mm.id')
            ->where($where)
            ->forPage($page, $size)
            ->orderByDesc('mp.order_num')
            ->get();
        if (!$data) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
        }
        foreach ($data['list'] as $key => $val) {
            $data['list'][$key]['manage_fee'] = bcmul($val['manage_fee'], 100);
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 产品添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_product(Request $request)
    {
        $params = $request->post();
        // validate($params, 'ProductValidator', [
        //     'mining_machine_id', 'coin_type', 'product_type', 'product_name', 'total_quantity',
        //     'last_quantity', 'product_hash', 'real_hash', 'price', 'period', 'manage_fee', 'added_time', 'property',
        //     'detail', 'feature', 'limited', 'is_sell', 'is_limit_time', 'is_limited', 'is_activity', 'is_resell',
        //     'is_recommend', 'is_experience', 'status_flag', 'pledge', 'is_pledge', 'product_init_work_day', 'work_number',
        //     'product_tag_ids', 'start_time', 'end_time'
        // ]);
        if ($params['action_type'] === 'add') {
            $product = PowerProduct::new();
        } else {
            $product = PowerProduct::find($params['id']);
        }
        $product->setMiningMachineId($params['mining_machine_id']);
        $product->setCoinType($params['coin_type']);
        $product->setProductType($params['product_type']);
        $product->setProductName($params['product_name']);
        $product->setTotalQuantity($params['total_quantity']);
        $product->setLastQuantity($params['last_quantity']);
        $product->setProductHash($params['product_hash']);
        $product->setRealHash($params['real_hash'] ?? '');
        $product->setPrice($params['price']);
        $product->setPeriod($params['period']);
        $product->setManageFee($params['manage_fee'] / 100);
        $product->setAddedTime($params['added_time']);
        $product->setProperty($params['property']);
        $product->setDetail($params['detail']);
        $product->setFeature($params['feature']);
        $product->setLimited($params['limited']);
        $product->setIsSell($params['is_sell']);
        $product->setIsLimitTime($params['is_limit_time']);
        if (isset($params['is_limit_time']) && !empty($params['is_limit_time'])) {
            if (empty($params['start_time']) || empty($params['end_time'])) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '限时抢购产品请设置开始时间、结束时间');
            }
            $product->setStartTime($params['start_time']);
            $product->setEndTime($params['end_time']);
        }
        $product->setIsLimited($params['is_limited']);
        $product->setIsActivity($params['is_activity']);
        $product->setIsRecommend($params['is_recommend']);
        $product->setIsExperience($params['is_experience']);
        $product->setStatusFlag($params['status_flag']);
        $product->setPledge($params['pledge']);
        $product->setIsPledge($params['is_pledge']);
        if ($params['is_pledge'] == 0 && $params['pledge'] > 0) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '抵押金额只能为0');
        }
        if (isset($params['product_init_work_day']) && !empty($params['product_init_work_day'])) {
            $product->setProductInitWorkDay($params['product_init_work_day']);
        }
        $product->setWorkNumber($params['work_number']);
        $product->setProductTagIds($params['product_tag_ids']);
        $product->setOrderNum($params['order_num']);
        $res = $product->save();
        if ($res) {
            if ($params['status_flag'] == 0) {
                Redis::del(config('power_product_limited') . $product->getId());
            }
            //抢购结束产品下架
            // if (isset($params['is_limit_time']) && !empty($params['is_limit_time'])) {
            //     //计算延时时间*1000
            //     $ttl = 1000 * (strtotime($params['end_time']) - time());
            //     if($ttl > 0){
            //         $init_queue = [
            //             'id' => $product->getId(),
            //         ];
            //         /**
            //          * @var MyRabbitMq $myRabbitMq
            //          * */
            //         $myRabbitMq = BeanFactory::getBean('MyRabbitMq');
            //         $is_succsess = $myRabbitMq->push_delay_queue(
            //             'power:product:limit:queue:cache',
            //             'power:product:limit:queue',
            //             $init_queue,
            //             $ttl
            //         );
            //     }
            // }
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }

    /**
     * 产品单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('power_product as mp')
            ->select('mp.*', 'mm.name')
            ->leftJoin('power_machine as mm', 'mp.mining_machine_id', '=', 'mm.id')
            ->where(['mp.id' => $id])
            ->firstArray();
        if (!empty($data)) {
            $data['manage_fee'] = bcmul($data['manage_fee'], 100);
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

}
