<?php


namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\MiningMachine;
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
 * Class MiningMachineController【暂时没用】
 * @package App\Http\Controller
 * @Controller("/mining_machine")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class MiningMachineController
{
    /**
     * 矿机列表
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
        $name = $params['name'] ?? '';
        $where = [];
        if ($name) {
            $where[] = ['name', 'like', '%' . $name . '%'];
        }
        // 获取矿机列表
        $data = PaginationData::table('mining_machine')->where($where)->forPage($page, $size)->get();
        if (!$data) {
            return false;
        }
        // 处理图片数据
        foreach ($data['list'] as $key => $item) {
            $images = json_decode($item['image'], true);
            foreach ($images as $k => $image) {
                $data['list'][$key]['images'][$k]['url'] = MyCommon::get_filepath($image);
                $data['list'][$key]['images'][$k]['name'] = $image;
            }
            unset($data['list'][$key]['image']);
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 矿机所有数据（不分页）
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function all(Request $request)
    {
        // 获取矿机数据
        $data = PaginationData::table('mining_machine')->get();
        if (!$data) {
            return false;
        }

        // 处理图片数据
        foreach ($data['list'] as $key => $item) {
            $images = json_decode($item['image'], true);
            foreach ($images as $k => $image) {
                $data['list'][$key]['images'][$k]['url'] = MyCommon::get_filepath($image);
                $data['list'][$key]['images'][$k]['name'] = $image;
            }
            unset($data['list'][$key]['image']);
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 添加、编辑矿机
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_mining_machine(Request $request)
    {
        $params = $request->params;
        validate($params, 'MiningMachineValidator',
            ['name', 'power', 'images', 'hash_rate', 'voltage', 'weight', 'size',
                'worker_temp', 'worker_hum', 'noise', 'algorithm', 'description']);

        if ($params['action_type'] === 'add') {
            $miningMachine = MiningMachine::new();
        } else {
            $miningMachine = MiningMachine::find($params['id']);
            if (!$miningMachine) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '矿机信息不存在');
            }
        }

        // 转化图片url
        $imageArr = [];
        foreach ($params['images'] as $image) {
            $imageArr[] = MyCommon::get_filename($image);
        }

        $miningMachine->setName($params['name']);
        $miningMachine->setPower($params['power']);
        $miningMachine->setImage(json_encode($imageArr));
        $miningMachine->setHashRate($params['hash_rate']);
        $miningMachine->setVoltage($params['voltage']);
        $miningMachine->setWeight($params['weight']);
        $miningMachine->setSize($params['size']);
        $miningMachine->setWorkerTemp($params['worker_temp']);
        $miningMachine->setWorkerHum($params['worker_hum']);
        $miningMachine->setNoise($params['noise']);
        $miningMachine->setAlgorithm($params['algorithm']);
        $miningMachine->setDescription($params['description']);
        $res = $miningMachine->save();

        if ($res) {
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');

    }

    /**
     * 矿机单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('mining_machine')->where(['id' => $id])->firstArray();
        if ($data) {
            $images = json_decode($data['image'], true);
            foreach ($images as $key => $image) {
                $data['images'][$key]['url'] = MyCommon::get_filepath($image);
                $data['images'][$key]['name'] = $image;
            }
            unset($data['image']);
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 矿机数据删除
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/del")
     */
    public function del(int $id)
    {
        $miningMachine = MiningMachine::find($id);
        if (!$miningMachine) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '矿机不存在');
        }

        //判断是否存在关联产品
        if(DB::table('mining_product')->where(['mining_machine_id' => $id])->firstArray()) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '此矿机有关联产品，不可删除');
        }

        // 执行删除
        $res = $miningMachine->delete();
        if ($res) {
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }

        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }
}
