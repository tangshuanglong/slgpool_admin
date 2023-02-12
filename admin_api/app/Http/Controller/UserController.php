<?php


namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Data\UserData;
use App\Model\Entity\Coin;
use App\Model\Entity\CoinDepositLog;
use App\Model\Entity\CoinWithdrawLog;
use App\Model\Entity\InviteLog;
use App\Model\Entity\UserBasicalInfo;
use App\Model\Logic\UserLogic;
use App\Rpc\Lib\WalletDwInterface;
use Swoft\Bean\Annotation\Mapping\Inject;
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
 * Class UserController
 * @package App\Http\Controller
 * @Controller("/user")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class UserController
{
    /**
     * @Inject()
     * @var MyCommon
     */
    private $myCommon;

    /**
     * @Reference(pool="user.pool")
     * @var WalletDwInterface
     */
    private $walletDWService;

    /**
     * @Inject()
     * @var UserData
     */
    private $userData;

    /**
     * 用户列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        $params      = $request->get();
        $page        = $params['page'] ?? 1;
        $size        = $params['size'] ?? 10;
        $invite_id   = $params['invite_id'] ?? '';
        $invitor_uid = $params['invitor_uid'] ?? '';
        $search_key  = $params['key'] ?? '';
        $user_group  = $params['user_group'] ?? 10;
        $data        = UserData::get_user_list(1, $page, $size, $search_key, $invitor_uid, $invite_id, $user_group);
        if (!$data) {
            return false;
        }
        foreach ($data['list'] as $key => $item) {
            unset($data['list'][$key]['login_pwd'], $data['list'][$key]['trade_pwd'], $data['list'][$key]['salt']);
            $data['list'][$key]['online']        = !empty(Redis::hget(config('login_user_info_key'), config('field_prefix') . $item['id'])) ? 1 : 0;
            $data['list'][$key]['register_time'] = date('Y-m-d H:i:s', $item['register_time']);
            $data['list'][$key]['login_time']    = date('Y-m-d H:i:s', $item['login_time']);
            if ($item['mobile'] === "NULL") {
                $data['list'][$key]['mobile'] = '';
            }
            if ($item['email'] === "NULL") {
                $data['list'][$key]['email'] = '';
            }
            if ($item['real_name_cert'] != 0) {
                $real_name = DB::table('identity_log')->where(['uid' => $item['id']])->value('real_name');
            }
            $data['list'][$key]['real_name'] = $item['real_name_cert'] != 0 ? $real_name : '';
        }

        //总注册数
        $data['total_register'] = $data['count'];
        //总推荐人数
        $total_recommend_data = UserData::get_user_list(2, $page, $size, $search_key, $invitor_uid, $invite_id, $user_group);
        if (empty($total_recommend_data)) {
            $data['total_recommend'] = 0;
        } else {
            $data['total_recommend'] = $total_recommend_data;
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 用户单条数据
     * @param int $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('user_basical_info')->where(['id' => $id])->firstArray();
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 用户编辑
     * @param int $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST}, route="")
     */
    public function do_user(Request $request)
    {
        $params            = $request->post();
        $user_basical_info = UserBasicalInfo::find($params['id']);
        $user_basical_info->setUserGroup($params['user_group']);
        $res = $user_basical_info->save();
        if ($res) {
            //重置缓存信息
            UserData::reset_user_all_info($params['id']);
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }

    /**
     * 用户绑定
     * @param int $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST}, route="")
     */
    public function user_bind(Request $request)
    {
        $params = $request->post();
        validate($params, 'UserValidator', ['user_id', 'invitor_code']);
        $user = UserBasicalInfo::find($params['user_id']);
        if (!$user) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '参数错误');
        }
        if (!empty($user['invitor_uid'])) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '该用户已经被绑定');
        }
        $invitor_id = UserBasicalInfo::where(['invite_id' => $params['invitor_code']])->value('id');
        if (!$invitor_id) {
            return MyQuit::returnMessage(MyCode::INVITE_CODE_NOT_EXISTS, '推荐码不存在');
        }
        if ($invitor_id == $user->getId()) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '不能绑定自己');
        }
        //判断是否死循环
        $user_logic      = new UserLogic();
        $is_endless_loop = $user_logic->is_endless_loop($user->getId(), $invitor_id);
        if ($is_endless_loop === true) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '邀请人死循环');
        }
        DB::beginTransaction();
        try {
            //上级邀请总数+1
            $res = UserBasicalInfo::where(['id' => $invitor_id])->increment('invite_total_times', 1);
            if (!$res) {
                throw new \Exception('上级邀请总数加一失败');
            }
            //更改推荐人的推荐ID
            $user->setInvitorUid($invitor_id);
            $res = $user->save();
            if (!$res) {
                throw new \Exception('更改推荐人的推荐ID失败');
            }
            //新增invite_log表
            $invite_log_params = [
                'uid'             => $invitor_id,
                'invited_uid'     => $params['user_id'],
                'invited_account' => $user->getMobile(),
                'status'          => 1,
                'create_time'     => time(),
            ];
            $res               = InviteLog::insert($invite_log_params);
            if (!$res) {
                throw new \Exception('新增邀请记录失败');
            }
            DB::commit();
            //重置缓存信息
            UserData::reset_user_all_info($params['user_id']);
            return MyQuit::returnMessage(MyCode::SUCCESS, '成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * 用户解绑
     * @param int $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST}, route="")
     */
    public function user_unbind(Request $request)
    {
        $params = $request->post();
        validate($params, 'UserValidator', ['user_id']);
        $user = UserBasicalInfo::find($params['user_id']);
        if (!$user) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '参数错误');
        }
        if (empty($user['invitor_uid'])) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '该用户末绑定任何人');
        }
        DB::beginTransaction();
        try {
            //上级邀请总数-1
            $res = UserBasicalInfo::where(['id' => $user['invitor_uid']])->decrement('invite_total_times', 1);
            if (!$res) {
                throw new \Exception('上级邀请总数减一失败');
            }
            //更改推荐人的推荐ID为0
            $user->setInvitorUid(0);
            $res = $user->save();
            if (!$res) {
                throw new \Exception('更改推荐人的推荐ID失败');
            }
            //删除invite_log表
            $res = InviteLog::where(['invited_uid' => $params['user_id']])->delete();
            if (!$res) {
                throw new \Exception('删除邀请记录失败');
            }
            DB::commit();
            //重置缓存信息
            UserData::reset_user_all_info($params['user_id']);
            return MyQuit::returnMessage(MyCode::SUCCESS, '成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * 用户上下分
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT})
     */
    public function modify_amount(Request $request)
    {
        $params = $request->post();
        validate($params, 'UserValidator', ['user_id', 'amount', 'coin_id', 'trade_type']);
        $user = UserBasicalInfo::find($params['user_id']);
        if (!$user) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '用户不存在');
        }
        $exists = DB::table('trade_type_dw')->where(['type_name_en' => $params['trade_type'], 'show_type' => 2])->exists();
        if (!$exists) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '类型不允许');
        }
        $amount = bcadd($params['amount'], 0, 8);
        if ($amount <= 0) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '金额不能等于0');
        }
        if ($params['trade_type'] == 'system_recharge') {//系统充值
            $res = $this->walletDWService->append_wallet_free($params['user_id'], $amount, $params['coin_id'], $params['trade_type']);
        } elseif ($params['trade_type'] == 'system_subdivided') {//系统下分
            $res = $this->walletDWService->deduct_wallet_free($params['user_id'], $amount, $params['coin_id'], $params['trade_type']);
        } elseif ($params['trade_type'] == 'system_unfrozen') {//解冻金额
            $res = $this->walletDWService->return_wallet_frozen($params['user_id'], $amount, $params['coin_id'], $params['trade_type']);
        }
        if ($res === false) {
            return MyQuit::returnMessage(MyCode::BALANCE_ERROR, '用户余额不足');
        }
        return MyQuit::returnMessage(MyCode::SUCCESS, '成功');
    }

    /**
     * 用户钱包详情
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function wallet_detail(Request $request)
    {
        $params = $request->params;
        validate($params, 'UserValidator', ['user_id', 'wallet_type']);
        $table_name = 'user_wallet_' . $params['wallet_type'];
        $data       = DB::table($table_name)->where(['uid' => $params['user_id']])->orderBy('coin_type')->get()->toArray();
        foreach ($data as $key => $val) {
            $total                           = bcadd($val['free_coin_amount'], $val['frozen_coin_amount'] + $val['pledge_coin_amount'] + $val['experience_coin_amount'], 8);
            $data[$key]['total_coin_amount'] = $total;
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 用户邀请返佣等级
     * @param int $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/rebate_level")
     */
    public function rebate_level(int $id)
    {
        $data = DB::table('rebate_level')->where(['uid' => $id])->firstArray();
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 余额变化记录
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function amount_log(Request $request)
    {
        $params = $request->params;
        validate($params, 'UserValidator', ['wallet_type', 'coin_id']);
        $page          = $params['page'] ?? 1;
        $size          = $params['size'] ?? 10;
        $invite_id     = $params['invite_id'] ?? '';
        $coin_id       = $params['coin_id'] ?? '';
        $trade_type_id = $params['trade_type_id'] ?? '';
        $start_date    = $params['start_date'] ?? '';
        $end_date      = $params['end_date'] ?? '';

        $coin       = Coin::find($coin_id);
        $table_name = 'user_amount_log_' . $params['wallet_type'];
        if ($params['wallet_type'] === 'mining') {
            $table_name .= '_' . $coin->getCoinNameEn();
        }
        $trade_type_table = 'trade_type_' . $params['wallet_type'];
        $where            = [];
        if ($coin_id) {
            $where[] = ['trade_coin_id', '=', $coin_id];
        }
        if ($trade_type_id) {
            $where[] = ['trade_type_id', '=', $trade_type_id];
        }
        if ($invite_id) {
            $uid     = $invite_id - config('invite_prefix');
            $where[] = ['uid', '=', $uid];
        }
        if ($start_date) {
            $where[] = ['create_time', '>=', $start_date];
        }
        if ($end_date) {
            $where[] = ['create_time', '<=', $end_date];
        }
        $data = PaginationData::table($table_name . ' as t1')
            ->select('t1.*', 't2.type_name_cn')
            ->leftJoin($trade_type_table . ' as t2', 't1.trade_type_id', '=', 't2.id')
            ->where($where)
            ->forPage($page, $size)
            ->orderByDesc('t1.id')
            ->get();
        foreach ($data['list'] as $key => $val) {
            $data['list'][$key]['uid']                 = $val['uid'] + config('invite_prefix');
            $data['list'][$key]['before_total_amount'] = bcadd($val['before_free_amount'], $val['before_frozen_amount'] + $val['before_pledge_amount'] + $val['before_experience_amount'], 8);
            $data['list'][$key]['after_total_amount']  = bcadd($val['after_free_amount'], $val['after_frozen_amount'] + $val['after_pledge_amount'] + $val['after_experience_amount'], 8);
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 充币统计
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function deposit_statistic(Request $request)
    {
        $where         = UserData::filter($request->params);
        $count         = CoinDepositLog::where($where)->count();
        $total_amounts = CoinDepositLog::selectRaw('coin_name, sum(amount) as amount')
            ->where($where)->groupBy('coin_name')
            ->get()->toArray();

        $real_amounts  = CoinDepositLog::selectRaw('coin_name, sum(amount) as amount')
            ->where(['status' => 200])->where($where)
            ->groupBy('coin_name')
            ->get()->toArray();
        $data          = $this->userData->statistic($total_amounts, $real_amounts);
        $data['count'] = $count;
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 充币记录
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function deposit_record(Request $request)
    {
        $params     = $request->params;
        $page       = $params['page'] ?? 1;
        $size       = $params['size'] ?? 10;
        $invite_id  = $params['invite_id'] ?? '';
        $coin_id    = $params['coin_id'] ?? '';
        $start_date = $params['start_date'] ?? '';
        $end_date   = $params['end_date'] ?? '';

        $where = [];
        if ($coin_id) {
            $where[] = ['t1.coin_id', '=', $coin_id];
        }
        if ($invite_id) {
            $uid     = $invite_id - config('invite_prefix');
            $where[] = ['uid', '=', $uid];
        }
        if ($start_date) {
            $where[] = ['t1.created_at', '>=', $start_date];
        }
        if ($end_date) {
            $where[] = ['t1.created_at', '<=', $end_date];
        }

        $data = PaginationData::table('coin_deposit_log as t1')
            ->select('t1.*', 't2.chain_name', 't3.explorer_url', 't3.explorer_url_parameter_address', 't3.explorer_url_parameter_tx')
            ->leftJoin('chain as t2', 't1.chain_id', '=', 't2.id')
            ->leftJoin('coin_token as t3', 't1.token_id', '=', 't3.id')
            ->where($where)
            ->forPage($page, $size)
            ->orderByDesc('t1.id')
            ->get();
        foreach ($data['list'] as $key => $val) {
            $data['list'][$key]['uid']          = $val['uid'] + config('invite_prefix');
            $data['list'][$key]['explorer_url'] = $val['explorer_url'] . $val['explorer_url_parameter_address'] . $val['explorer_url_parameter_tx'] . $val['tx_hash'];
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 提币统计
     * @param Request $request
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function withdraw_statistic(Request $request)
    {
        $where         = UserData::filter($request->params);
        $count         = CoinWithdrawLog::where($where)->count();
        $total_amounts = CoinWithdrawLog::selectRaw('coin_name, sum(coin_amount) as amount')
            ->where($where)->groupBy('coin_name')
            ->get()->toArray();

        $real_amounts        = CoinWithdrawLog::selectRaw('coin_name, sum(coin_amount) as amount, sum(trade_handling_fee) as fee_amount')
            ->where(['status' => 50])->where($where)
            ->groupBy('coin_name')
            ->get()->toArray();
        $data                = $this->userData->statistic($total_amounts, $real_amounts);
        $data['real_amount'] = bcsub($data['success_amount'], $data['fee_amount'], 8);
        $data['count']       = $count;
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 提币记录
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function withdraw_record(Request $request)
    {
        $params     = $request->params;
        $page       = $params['page'] ?? 1;
        $size       = $params['size'] ?? 10;
        $invite_id  = $params['invite_id'] ?? '';
        $coin_id    = $params['coin_id'] ?? '';
        $start_date = $params['start_date'] ?? '';
        $end_date   = $params['end_date'] ?? '';
        $status     = $params['status'] ?? '';
        $where      = [];
        if ($coin_id) {
            $where[] = ['t1.coin_id', '=', $coin_id];
        }
        if ($status) {
            $where[] = ['t1.status', '=', $status];
        }
        if ($invite_id) {
            $uid     = $invite_id - config('invite_prefix');
            $where[] = ['uid', '=', $uid];
        }
        if ($start_date) {
            $where[] = ['t1.created_at', '>=', $start_date];
        }
        if ($end_date) {
            $where[] = ['t1.created_at', '<=', $end_date];
        }
        $data = PaginationData::table('coin_withdraw_log as t1')
            ->select('t1.*', 't2.chain_name', 't3.explorer_url', 't3.explorer_url_parameter_address', 't3.explorer_url_parameter_tx')
            ->leftJoin('chain as t2', 't1.chain_id', '=', 't2.id')
            ->leftJoin('coin_token as t3', 't1.token_id', '=', 't3.id')
            ->where($where)->forPage($page, $size)->orderByDesc('t1.id')->get();
        foreach ($data['list'] as $key => $val) {
            $data['list'][$key]['uid']          = $val['uid'] + config('invite_prefix');
            $data['list'][$key]['explorer_url'] = $val['explorer_url'] . $val['explorer_url_parameter_address'] . $val['explorer_url_parameter_tx'] . $val['tx_hash'];
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 提币审核
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT})
     */
    public function withdraw_check(Request $request)
    {
        $params = $request->params;
        validate($params, 'UserValidator', ['id', 'status', 'remark']);
        $withdraw_log = CoinWithdrawLog::where(['id' => $params['id'], 'status' => 10])->first();
        if (!$withdraw_log) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '提币记录不存在');
        }
        $user_info = UserData::get_user_all_info($withdraw_log['uid']);
        //检测用户组
        if ($user_info['user_group'] == 30 && $params['status'] == 20) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '测试用户组不能提币');
        }
        $withdraw_log->setStatus($params['status']);
        $withdraw_log->setRemark($params['remark']);
        $res = $withdraw_log->save();
        //审核不通过
        if ($params['status'] == 30) {
            //减少用户提现数量
            $this->myCommon->set_withdraw_amount(config('redis_key.withdraw_limit') . $withdraw_log->getCoinName(),
                $withdraw_log->getUid(), '-' . $withdraw_log->getCoinAmount());
            //把冻结金额返还到可用余额
            $res = $this->walletDWService->return_wallet_frozen($withdraw_log['uid'], $withdraw_log['coin_amount'], $withdraw_log['coin_id'], 'withdraw_back');
            if ($res === false) {
                return MyQuit::returnMessage(MyCode::BALANCE_ERROR, '返还可用余额失败');
            }
        }
        //todo 审核通过 直接扣除冻结金额
        if ($res) {
            return MyQuit::returnMessage(MyCode::SUCCESS, '审核成功');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, '服务器错误');
    }
}
