<?php


namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\MiningMachine;
use App\Model\Entity\PowerMachine;
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
 * Class MiningMachineController
 * @package App\Http\Controller
 * @Controller("/power_machine")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class PowerMachineController
{
    /**
     * 矿机列表（全量）
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function all(Request $request)
    {
        $data = DB::table('power_machine')->select('id', 'name')->get();
        if (!$data) {
            return false;
        }
        return MyQuit::returnSuccess($data->toArray(), MyCode::SUCCESS, 'success');
    }

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
        $data = PaginationData::table('power_machine')->where($where)->forPage($page, $size)->get();
        if (!$data) {
            return false;
        }
        // 处理图片数据
        foreach ($data['list'] as $key => $item) {
            $image = json_decode($item['image'], true);
            $image = $image ?? [];
            if (is_array($image) && array_key_exists("0", $image)) {
                if (!empty($image)) {
                    foreach ($image as $key => $value) {
                        $data['list'][$key]['images'][] = MyCommon::get_filepath($value, 'file');
                    }
                }
            }
            unset($data['list'][$key]['image']);
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 矿机添加、编辑
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
            $miningMachine = PowerMachine::new();
        } else {
            $miningMachine = PowerMachine::find($params['id']);
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
        $miningMachine->setCpu($params["cpu"]);
        $miningMachine->setGPU($params["gpu"]);
        $miningMachine->setMemory($params["memory"]);
        $miningMachine->setMotherboard($params["motherboard"]);
        $miningMachine->setSsd($params["ssd"]);
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
        $data = DB::table('power_machine')->where(['id' => $id])->firstArray();
        if ($data) {
            $image = json_decode($data['image'], true);
            $image = $image ?? [];
            if (is_array($image) && array_key_exists("0", $image)) {
                if (!empty($image)) {
                    foreach ($image as $key => $value) {
                        $data['images'][] = MyCommon::get_filepath($value, 'file');
                    }
                }
            }
            unset($data['image']);
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 矿机删除
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/del")
     */
    public function del(int $id)
    {
        $miningMachine = PowerMachine::find($id);
        if (!$miningMachine) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '矿机不存在');
        }
        //判断是否存在关联产品
        if (DB::table('power_product')->where(['mining_machine_id' => $id])->firstArray()) {
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
