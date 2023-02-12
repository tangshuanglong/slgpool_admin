<?php


namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use Swoft\Db\DB;
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

/**
 * Class RewardLogController
 * @package App\Http\Controller
 * @Controller("/reward_log")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class RewardLogController
{
    /**
     * 返佣记录统计
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function statistic(Request $request)
    {
        $params = $request->params;
        $where = $this->filters($params);
        $totalAmount = DB::table('reward_log as rl')
            ->select('rl.*', 'ut.nickname as to_user_name', 'uf.nickname as from_user_name')
            ->leftJoin('user_basical_info as ut', 'rl.to_uid', '=', 'ut.id')
            ->leftJoin('user_basical_info as uf', 'rl.from_uid', '=', 'uf.id')
            ->where($where)
            ->orderByDesc('rl.id')
            ->sum('rl.amount');
        $data['total_amount'] = $totalAmount;
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 返佣记录列表
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
        $where = $this->filters($params);
        $data = PaginationData::table('reward_log as rl')
            ->select('rl.*', 'ut.nickname as to_user_name', 'uf.nickname as from_user_name')
            ->leftJoin('user_basical_info as ut', 'rl.to_uid', '=', 'ut.id')
            ->leftJoin('user_basical_info as uf', 'rl.from_uid', '=', 'uf.id')
            ->where($where)
            ->orderByDesc('rl.id')
            ->forPage($page, $size)
            ->get();
        // 获取id常量，得到推荐id
        $invitePrefix = (int)config('invite_prefix');
        foreach ($data['list'] as $key => $item) {
            $data['list'][$key]['to_invite_id'] = $item['to_uid'] + $invitePrefix;
            $data['list'][$key]['from_invite_id'] = $item['from_uid'] + $invitePrefix;
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 列表和统计的统一筛选条件
     * @param $params
     * @return array
     */
    protected function filters($params): array
    {
        $toUserName = $params['to_user_name'] ?? '';
        $fromUserName = $params['from_user_name'] ?? '';
        $coinType = $params['coin_type'] ?? '';
        $status = $params['status'] ?? '';
        $where = [];
        if ($toUserName) {
            $where[] = ['ut.nickname', 'like', '%' . $toUserName . '%'];
        }
        if ($fromUserName) {
            $where[] = ['uf.nickname', 'like', '%' . $fromUserName . '%'];
        }
        if ($coinType) {
            $where[] = ['rl.coin_type', '=', $coinType];
        }
        if ($status || $status === '0') {
            $where[] = ['rl.status', '=', $status];
        }
        return $where;
    }
}
