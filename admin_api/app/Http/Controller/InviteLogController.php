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
 * Class InviteLogController
 * @package App\Http\Controller
 * @Controller("/invite_log")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class InviteLogController
{
    /**
     * 邀请记录列表
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
        $toUserName = $params['to_user_name'] ?? '';
        $fromUserName = $params['from_user_name'] ?? '';
        $status = $params['status'] ?? '';

        $where = [];
        if ($toUserName) {
            $where[] = ['ut.nickname', 'like', '%' . $toUserName . '%'];
        }
        if ($fromUserName) {
            $where[] = ['uf.nickname', 'like', '%' . $fromUserName . '%'];
        }
        if ($status || $status === '0') {
            $where[] = ['il.status', '=', $status];
        }

        // 获取邀请记录列表
        $data = PaginationData::table('invite_log as il')
            ->select('il.*', 'ut.nickname as to_user_name', 'uf.nickname as from_user_name')
            ->leftJoin('user_basical_info as ut', 'il.invited_uid', '=', 'ut.id')
            ->leftJoin('user_basical_info as uf', 'il.uid', '=', 'uf.id')
            ->where($where)
            ->orderByDesc('il.id')
            ->forPage($page, $size)
            ->get();

        // 获取id常量，得到推荐id
        $invitePrefix = (int)config('invite_prefix');
        foreach ($data['list'] as $key => $item) {
            $data['list'][$key]['create_time'] = date('Y-m-d H:i:s', $item['create_time']);
            $data['list'][$key]['from_invite_id'] = $item['uid'] + $invitePrefix;
            $data['list'][$key]['to_invite_id'] = $item['invited_uid'] + $invitePrefix;
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

}
