<?php


namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\ConfigData;
use App\Model\Data\PaginationData;
use App\Model\Entity\Config;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Redis\Redis;
use Swoft\Stdlib\Helper\JsonHelper;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class ConfigController
 * @package App\Http\Controller
 * @Controller("/config")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class ConfigController
{

    const TABLE_NAME = 'config';
    const REDIS_KEY = 'config:group';

    /**
     * 配置列表
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
        $group = $params['group'] ?? '';
        $name = $params['name'] ?? '';
        $where = [];
        if ($group) {
            $where[] = ['group', 'like', '%' . $group . '%'];
        }
        if ($name) {
            $where[] = ['name', 'like', '%' . $name . '%'];
        }
        // 获取配置列表
        $data = PaginationData::table(self::TABLE_NAME)->where($where)->forPage($page, $size)->get();
        foreach ($data['list'] as $key => $item) {
            $data['list'][$key]['start_time'] = date('Y-m-d H:i:s', $item['start_time']);
            $data['list'][$key]['end_time'] = date('Y-m-d H:i:s', $item['end_time']);
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 配置添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_config(Request $request)
    {
        $params = $request->post();
        validate($params, 'ConfigValidator',
            ['group', 'name', 'value', 'start_time', 'end_time', 'cancel_flag', 'remark']);
        $originGroup = $originName = '';

        if ($params['action_type'] == 'add') {
            $config = Config::new();
            $exit = ConfigData::exitConfigGroupName($params['group'], $params['name']);
        } else {
            $config = Config::find($params['id']);
            if (!$config) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '配置信息不存在');
            }
            $exit = ConfigData::exitConfigGroupName($params['group'], $params['name'], $params['id']);
            $originGroup = $config['group'];
            $originName = $config['name'];
        }

        // 配置名不能重复判定
        if ($exit) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '该配置已存在');
        }

        //时间处理
        $params['start_time'] = strtotime($params['start_time']);
        $params['end_time'] = strtotime($params['end_time']);

        $config->setGroup($params['group']);
        $config->setName($params['name']);
        $config->setValue($params['value']);
        $config->setStartTime($params['start_time']);
        $config->setEndTime($params['end_time']);
        $config->setCancelFlag($params['cancel_flag']);
        $config->setRemark($params['remark']);
        $res = $config->save();
        if (!$res) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '操作配置表错误');
        }

        // 编辑数据时，先删除缓存
        if ($params['action_type'] != 'add') {
            //删除缓存
            $key = self::REDIS_KEY;
            $new_key = $key . ':' . $originGroup;
            $field = $new_key . ':' . $originName;
            Redis::hDel($new_key, $field);
        }

        // 重新使用DB读取数据库数据，Data的会造成字段变成驼峰
        if ($params['action_type'] == 'add') {
            $id = $config->getId();
        } else {
            $id = $params['id'];
        }
        $config = DB::table('config')->find($id);

        // 写入缓存
        $key = self::REDIS_KEY;
        $new_key = $key . ':' . $params['group'];
        $field = $new_key . ':' . $params['name'];
        Redis::hSet($new_key, $field, json_encode($config));

        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }

    /**
     * 配置单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $config = DB::table(self::TABLE_NAME)->where(['id' => $id])->firstArray();
        if ($config) {
            $config['start_time'] = date('Y-m-d H:i:s', $config['start_time']);
            $config['end_time'] = date('Y-m-d H:i:s', $config['end_time']);
        }

        return MyQuit::returnSuccess($config, MyCode::SUCCESS, 'success');
    }

    /**
     * 配置信息删除
     * @param int $id
     * @return array
     * @throws DbException
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/del")
     */
    public function del(int $id)
    {
        $config = DB::table(self::TABLE_NAME)->where(['id' => $id])->firstArray();
        if (!$config) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '配置不存在');
        }

        $res = ConfigData::delete_config($id);
        if (!$res) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '配置删除失败');
        }

        //删除缓存
        $key = self::REDIS_KEY;
        $new_key = $key . ':' . $config['group'];
        $field = $new_key . ':' . $config['name'];
        Redis::hDel($new_key, $field);

        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }
}
