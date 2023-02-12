<?php


namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\CoinData;
use App\Model\Data\ConfigData;
use App\Model\Data\PaginationData;
use App\Model\Data\RebateLevelConfigData;
use App\Model\Entity\Chain;
use App\Model\Entity\Coin;
use App\Model\Entity\Config;
use App\Model\Entity\RebateLevelConfig;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Log\Helper\CLog;
use Swoft\Redis\Redis;
use Swoft\Stdlib\Helper\JsonHelper;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class RebateLevelConfigController
 * @package App\Http\Controller
 * @Controller("/rebate_level_config")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class RebateLevelConfigController
{

    const TABLE_NAME = 'rebate_level_config';
    const REDIS_KEY = 'table:rebate:level:config';

    /**
     * 邀请返佣等级列表
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
        $data = PaginationData::table(self::TABLE_NAME)->orderByRaw('unit, coin_type, level asc')->forPage($page, $size)->get();
        foreach ($data['list'] as $key => $item) {
            $data['list'][$key]['rebate'] = round($item['rebate'] * 100, 4);
            $data['list'][$key]['rebate_mining'] = round($item['rebate_mining'] * 100, 4);
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 邀请返佣等级添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_rebate_level_config(Request $request)
    {
        $params = $request->post();
        validate($params, 'RebateLevelConfigValidator', ['consume_before', 'consume_after', 'level', 'unit', 'coin_type', 'rebate_mining', 'rebate']);
        $originLevel = '';

        if ($params['action_type'] === 'add') {
            $rebateLevelConfig = RebateLevelConfig::new();
            $exit = RebateLevelConfigData::exitConfigLevel($params['level'], $params['unit'], $params['coin_type']);
        } else {
            $rebateLevelConfig = RebateLevelConfig::find($params['id']);
            if (!$rebateLevelConfig) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '邀请返佣等级信息不存在');
            }
            $exit = RebateLevelConfigData::exitConfigLevel($params['level'], $params['unit'], $params['coin_type'], $params['id']);
            $originLevel = $rebateLevelConfig['level'] . '_' . $rebateLevelConfig['unit'] . '_' . $rebateLevelConfig['coin_type'];
        }

        // 判断等级是否重复存在
        if ($exit) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '该等级已存在，请修改等级');
        }
        $rebateLevelConfig->setConsumeBefore($params['consume_before']);
        $rebateLevelConfig->setConsumeAfter($params['consume_after']);
        $rebateLevelConfig->setLevel($params['level']);
        $rebateLevelConfig->setUnit($params['unit']);
        $rebateLevelConfig->setCoinType($params['coin_type']);
        $rebateLevelConfig->setRebate((string)($params['rebate'] / 100));
        $rebateLevelConfig->setRebateMining((string)($params['rebate_mining'] / 100));
        $res = $rebateLevelConfig->save();
        if (!$res) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '操作邀请返佣等级表错误');
        }

        // 编辑记录时先删除缓存
        if ($params['action_type'] !== 'add') {
            $key = self::REDIS_KEY;
            $field = 'level:' . $originLevel;
            Redis::hDel($key, $field);
        }

        // 写入缓存
        $params['id'] = $rebateLevelConfig->getId();

        $rebateLevelConfig = DB::table('rebate_level_config')->find($params['id']);
        $key = self::REDIS_KEY;
        $field = 'level:' . $params['level'] . '_' . $params['unit'] . '_' . $params['coin_type'];
        Redis::hSet($key, $field, json_encode($rebateLevelConfig));

        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }

    /**
     * 邀请返佣等级单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $rebateLevelConfig = DB::table(self::TABLE_NAME)->where(['id' => $id])->firstArray();
        if ($rebateLevelConfig) {
            $rebateLevelConfig['rebate_mining'] = (string)($rebateLevelConfig['rebate_mining'] * 100);
            $rebateLevelConfig['rebate'] = (string)($rebateLevelConfig['rebate'] * 100);
        }

        return MyQuit::returnSuccess($rebateLevelConfig, MyCode::SUCCESS, 'success');
    }

    /**
     * 邀请返佣等级删除
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/del")
     */
    public function del(int $id)
    {
        $rebateLevelConfig = RebateLevelConfig::find($id);
        if (!$rebateLevelConfig) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '等级不存在');
        }
        // 执行删除
        $res = $rebateLevelConfig->delete();
        if ($res) {
            $key = self::REDIS_KEY;
            $originLevel = $rebateLevelConfig['level'] . '_' . $rebateLevelConfig['unit'] . '_' . $rebateLevelConfig['coin_type'];
            $field = 'level:' . $originLevel;
            Redis::hDel($key, $field);
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }

        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }
}
