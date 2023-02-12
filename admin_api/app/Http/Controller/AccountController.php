<?php
namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyGA;
use App\Lib\MyQuit;
use App\Model\Data\RolesData;
use App\Model\Data\AdminData;
use App\Model\Entity\AdminUserHasRoles;
use App\Model\Entity\AdminUsers;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Db\DB;
use Swoft\Http\Message\Request;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class AccountController
 * @package App\Http\Controller\Admin
 * @Controller("/account")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class AccountController
{
    /**
     * @Inject()
     * @var MyGA
     */
    private $myGa;

    /**
     * 管理员列表
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        //初始化参数
        $page = $request->params['page'] ?? 1;
        $size = $request->params['size'] ?? 10;
        $name = $request->params['name'] ?? '';
        $role_ids = $request->params['role_ids'] ?? [];
        $status = $request->params['status'] ?? null;
        $where = [];
        if ($name) {
            $where[] = ['user_name', 'like', '%' . $name . '%'];
        }
        if ($status !== null) {
            $where[] = ['status', '=', $status];
        }
        $user_ids = [];
        if ($role_ids) {
            //查询该角色的所有用户ID
            $user_ids = DB::table('admin_user_has_roles')->whereIn('role_id', $role_ids)->get(['user_id'])->toArray();
            $user_ids = array_column($user_ids, 'user_id');
        }
        $field = ['t1.user_id', 'user_name', 'email', 'google_auth_code', 'status', 't1.created_at', 't1.updated_at', 't3.name_cn'];
        $user_obj = DB::table('admin_users as t1')
            ->leftJoin('admin_user_has_roles as t2', 't1.user_id', '=', 't2.user_id')
            ->leftJoin('admin_roles as t3', 't2.role_id', '=', 't3.id')
            ->where($where);
        if ($role_ids) {
            $user_obj->whereIn('t1.user_id', $user_ids);
        }
        $count = $user_obj->count();
        $user_data = $user_obj->forPage($page, $size)->get($field)->toArray();
        $data = [
            'list'  => $user_data,
            'count' => $count
        ];
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 管理员添加
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function add(Request $request)
    {
        $params = $request->params;
        validate($params, 'AccountValidator', ['user_name', 'email', 'password', 'role_ids']);
        //验证role_ids是否存在
        foreach ($params['role_ids'] as $role_id) {
            $role_info = RolesData::get_role_info($role_id);
            if (!$role_info) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '角色错误');
            }
        }
        if (AdminUsers::where(['user_name' => $params['user_name']])->exists()) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '用户名已存在');
        }
        if (AdminUsers::where(['email' => $params['email']])->exists()) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '邮箱已存在');
        }
        //生成密码
        $password = MyCommon::create_user_password($params['password']);
        //生成谷歌秘钥
        $google_secret = $this->myGa->createSecret();
        try {
            DB::beginTransaction();
            $user = AdminUsers::new();
            $user->setUserName($params['user_name']);
            $user->setEmail($params['email']);
            $user->setPassword($password);
            $user->setGoogleAuthCode($google_secret);
            $user->setStatus(1);
            $user->setCreatedId($request->uid);
            $res = $user->save();
            if (!$res) {
                throw new \Exception('添加账号错误');
            }
            $user_id = $user->getUserId();
            foreach ($params['role_ids'] as $role_id) {
                $user_has_role = AdminUserHasRoles::new();
                $user_has_role->setUserId($user_id);
                $user_has_role->setRoleId($role_id);
                $res = $user_has_role->save();
                if (!$res) {
                    throw new \Exception('添加账号角色错误');
                }
            }
            DB::commit();
            return MyQuit::returnMessage(MyCode::SUCCESS, '添加成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * 管理员编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT})
     */
    public function edit(Request $request)
    {
        $params = $request->params;
        validate($params, 'AccountValidator', ['id']);
        $user = AdminUsers::find($params['id']);
        if (!$user) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '用户不存在');
        }
        if (isset($params['user_name'])) {
            validate($params, 'AccountValidator', ['user_name']);
            if (AdminUsers::where(['user_name' => $params['user_name']])
                ->where([['user_id', '!=', $params['id']]])
                ->exists()
            ) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '用户名已存在');
            }
            $user->setUserName($params['user_name']);
        }
        if (isset($params['email'])) {
            validate($params, 'AccountValidator', ['email']);
            if (AdminUsers::where(['email' => $params['email']])
                ->where([['user_id', '!=', $params['id']]])
                ->exists()
            ) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '邮箱已存在');
            }
            $user->setEmail($params['email']);
        }
        if (isset($params['password']) && !empty($params['password'])) {
            validate($params, 'AccountValidator', ['password']);
            $password = MyCommon::create_user_password($params['password']);
            $user->setPassword($password);
        }
        if (isset($params['secret'])) {
            validate($params, 'AccountValidator', ['secret']);
            $user->setGoogleAuthCode($params['secret']);
        }
        $user->save();
        return MyQuit::returnMessage(MyCode::SUCCESS, '修改成功');
    }

    /**
     * 管理员删除
     * @param Request $request
     * @param int $user_id
     * @return array
     * @RequestMapping(method={RequestMethod::DELETE}, route="{user_id}/delete")
     */
    public function delete(Request $request, int $user_id)
    {
        $user = AdminUsers::find($user_id);
        if (!$user) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '用户不存在');
        }
        if ($user_id == $request->uid) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '不能删除自己');
        }
        DB::beginTransaction();
        try {
            $res = $user->delete();
            if (!$res) {
                throw new \Exception('删除账号失败');
            }
            //删除权限
            $res = AdminUserHasRoles::where(['user_id' => $user_id])->delete();
            if (!$res) {
                throw new \Exception('删除权限失败');
            }
            DB::commit();
            return MyQuit::returnMessage(MyCode::SUCCESS, '删除成功');
        } catch (\Exception $e) {
            DB::rollBack();
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * 管理员拥有的角色
     * @param int $user_id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{user_id}/role")
     */
    public function role(int $user_id)
    {
        $role_ids = AdminData::user_role_ids($user_id);
        $data = AdminData::get_roles($role_ids);
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 修改状态
     * @param Request $request
     * @param int $user_id
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT}, route="{user_id}/set_status")
     */
    public function set_status(Request $request, int $user_id)
    {
        $params = $request->params;
        validate($params, 'AccountValidator', ['status']);
        $user = AdminUsers::find($user_id);
        if (!$user) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '用户不存在');
        }
        $user->setStatus($params['status']);
        $user->save();
        return MyQuit::returnMessage(MyCode::SUCCESS, '成功');
    }

    /**
     * 获取谷歌验证秘钥
     * @return array
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function google_secret()
    {
        $data = ['secret' => $this->myGa->createSecret()];
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }
}
