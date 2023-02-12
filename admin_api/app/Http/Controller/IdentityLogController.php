<?php


namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\IdentityLog;
use App\Model\Entity\UserBasicalInfo;
use App\Rpc\Lib\AuthInterface;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class IdentityLogController
 * @package App\Http\Controller
 * @Controller("/identity_log")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class IdentityLogController
{
    /**
     * @Reference(pool="auth.pool")
     *
     * @var AuthInterface
     */
    private $authService;

    /**
     * 用户身份审核列表
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
        $userId = $params['user_id'] ?? '';
        $statusFlag = $params['status_flag'] ?? '';
        $where = [];

        // 获取id常量，得到推荐id
        $invitePrefix = (int)config('invite_prefix');
        if ($statusFlag || $statusFlag === "0") {
            $where = ['status_flag' => (int)$statusFlag];
        }
        if ($userId) {
            $userId = $userId - $invitePrefix;
            $where = ['uid' => $userId];
        }
        $data = PaginationData::table('identity_log')->where($where)->forPage($page, $size)->orderByDesc('id')->get();
        foreach ($data['list'] as $key => $item) {
            $data['list'][$key]['invite_id'] = $item['uid'] + $invitePrefix;
            $data['list'][$key]['identity_front'] = MyCommon::get_filepath($item['identity_front']);
            $data['list'][$key]['identity_reverse'] = MyCommon::get_filepath($item['identity_reverse']);
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 用户身份审核
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT}, route="check")
     */
    public function check(Request $request): array
    {
        $params = $request->params;
        validate($params, 'IdentityLogValidator', ['id', 'status_flag', 'reject_reason']);
        $identityLog = IdentityLog::where(['id' => $params['id'], 'status_flag' => 3])->first();
        if (!$identityLog) {
            return MyQuit::returnError(MyCode::PARAM_ERROR, '申请记录不存在');
        }
        $user = UserBasicalInfo::find($identityLog->getUid());
        if (!$user) {
            return MyQuit::returnError(MyCode::PARAM_ERROR, '审核失败,无法获取用户');
        }

        //开启事务
        DB::beginTransaction();
        $identityLog->setStatusFlag($params['status_flag']);
        $identityLog->setRejectReason($params['reject_reason'] ?? '');
        $res = $identityLog->save();
        if (!$res) {
            DB::rollBack();
            return MyQuit::returnError(MyCode::SERVER_ERROR, '审核失败');
        }
        if ($params['status_flag'] == 4) {
            $user->setRealNameCert(2);
            $userRes = $user->save();
            if (!$userRes) {
                DB::rollBack();
                return MyQuit::returnError(MyCode::SERVER_ERROR, '审核失败');
            }
            DB::commit();
            //RPC调用，重置用户信息
            $this->authService->reset_user_all_info($identityLog->getUid());
        } else {
            DB::commit();
        }
        return MyQuit::returnMessage(MyCode::SUCCESS, '审核成功');
    }
}
