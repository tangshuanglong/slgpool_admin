<?php


namespace App\Model\Data;

use App\Lib\MyToken;
use ReflectionException;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Bean\BeanFactory;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Eloquent\Model;
use Swoft\Db\Exception\DbException;
use Swoft\Db\Query\Builder;
use Swoft\Http\Session\HttpSession;

/**
 * Class AdminUserData
 * @package App\Model\Data
 */
class AdminData
{

    /**
     * @param $old_pwd
     * @param $new_pwd
     * @return bool
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function modify_pwd($old_pwd, $new_pwd)
    {
        $session = context()->get(HttpSession::CONTEXT_KEY);
        $uid = $session->get('uid');
        $res1 = DB::table('admin_user')->where(['password' => md5($old_pwd)], ['id' => $uid])->exists();
        if ($res1) {
            $new_pwd = md5($new_pwd);
            $res2 = DB::table('admin_user')->where('id', $uid)->update(['password' => $new_pwd]);
            if ($res2) {
                return true;
            }
        }
        return false;
    }

    /**
     * * 获取登录者信息
     * @return bool|object|Model|Builder|null
     * @throws DbException
     */

    public static function get_user_data()
    {
        $session = context()->get(HttpSession::CONTEXT_KEY);
        $uid = $session->get('uid');
        $user = DB::table('admin_user')->find($uid);
        if (!$user) {
            return false;
        }
        return $user;
    }

    /**
     * 获取管理员信息及对应的角色信息
     * @param $id
     * @return array|bool
     * @throws DbException
     */
    public static function get_role_user($id)
    {
        $role = DB::table('admin_user')
            ->leftjoin('admin_role_user', 'admin_user.id', '=', 'admin_role_user.user_id')
            ->leftjoin('admin_role', 'admin_role_user.role_id', '=', 'admin_role.role_id')
            ->where('admin_user.id', $id)
            ->select('admin_user.id', 'admin_user.account', 'admin_user.password', 'admin_user.admin_type', 'admin_role.role_id')
            ->get()
            ->toArray();

        if (!$role) {
            return false;
        }
        return $role;
    }

    /**
     * 添加管理员信息
     * @param $info
     * @return bool|string
     * @throws DbException
     * @throws ReflectionException
     * @throws ContainerException
     */
    public static function add_user($info)
    {
        //判断帐号是否存在
        $res = DB::table('admin_user')->where('account', $info['account'])->exists();
        if ($res) {
            return false;
        }

        DB::beginTransaction();
        //添加管理员
        $id = DB::table('admin_user')->insertGetId([
            'account'  => $info['account'],
            'password'  => password_hash($info['password'], PASSWORD_DEFAULT),
            'admin_type'  => $info['admin_type'],
            'login_time'  => time()
        ]);
        //绑定管理员对应的角色
        $arr = [];
        foreach ($info['role_id'] as $v) {
            $arr[] = ['role_id' => $v, 'user_id' => $id];
        }
        $res = DB::table('admin_role_user')->insert($arr);
        if ($res && $id) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 更新管理员信息
     * @param $info
     * @return bool|int
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function update_user($info)
    {
        //判断帐号是否存在
        $res = DB::table('admin_user')
            ->where('account', $info['account'])
            ->where('id', '!=', $info['id'])
            ->exists();
        if ($res) {
            return false;
        }
        DB::beginTransaction();
        DB::table('admin_user')
            ->where('id', $info['id'])
            ->update([
                'account' => $info['account'],
                'admin_type' => $info['admin_type']
            ]);
        //绑定管理员对应的角色
        //清除原绑定关系
        DB::table('admin_role_user')->where('user_id', '=', $info['id'])->delete();
        //添加新绑定关系
        $arr = [];
        if (isset($info['role_id']) && !empty($info['role_id'])) {
            foreach ($info['role_id'] as $v) {
                $arr[] = ['role_id' => $v, 'user_id' => $info['id']];
            }
            DB::table('admin_role_user')->insert($arr);
        }
        DB::commit();
        return true;
    }

    /**
     * 验证后台登录
     * @param string $token
     * @return array|bool
     * @throws DbException
     */
    public static function verify_login(string $token)
    {
        $myToken = BeanFactory::getBean('MyToken');
        $verify_res = $myToken->checkToken($token);
        if (!$verify_res) {
            return false;
        }
        $field = ['user_id', 'user_name', 'email', 'avatar', 'status', 'created_at', 'updated_at'];
        return DB::table('admin_users')->where(['user_id' => $verify_res['uid']])->firstArray($field);
    }

    /**
     * 获取用户所属角色
     * @param int $uid
     * @return array
     * @throws DbException
     */
    public static function user_role_ids(int $uid)
    {
        $data = DB::table('admin_user_has_roles')->where(['user_id' => $uid])->get();
        $res = [];
        if (!$data) {
            return $res;
        }
        foreach ($data as $value) {
            $res[] = $value['role_id'];
        }
        return $res;
    }

    /**
     * 获取角色信息
     * @param array $role_ids
     * @return array
     * @throws DbException
     */
    public static function get_roles(array $role_ids)
    {
        return DB::table('admin_roles')->select('id', 'name', 'name_cn')->whereIn('id', $role_ids)->get()->toArray();
    }

    /**
     * 获取用户所有权限
     * @param array $role_ids
     * @return array
     * @throws DbException
     */
    public static function user_permissions(array $role_ids)
    {
        return DB::table('admin_role_has_permissions as t1')->select('t2.*')->whereIn('t1.role_id', $role_ids)
            ->leftJoin('admin_permissions as t2', 't1.permission_id', '=', 't2.id')->get()->toArray();
    }

    /**
     * 组装菜单栏数据
     * @param array $list
     * @param bool $filter
     * @return array
     */
    public static function menusDataSpecification(array $list, bool $filter = true)
    {
        if(!$list){
            return $list;
        }

        //格式处理
        $array = [];
        foreach ($list as $v){
            //不存在相同的key，添加新的一块
            if(!array_key_exists($v['name_group'], $array)){
                $array[$v['name_group']]['module']     = $v['name_group'];
                $array[$v['name_group']]['moduleName'] = $v['name_group_cn'];
            }
            if(!$filter){
                $tmpName = explode(' ', $v['name']);
                $action  = $tmpName[0];
                //拼接数据
                $tmp = [
                    'id'     => $v['id'],
                    'action' => $action,
                    'name'   => $v['name_action_cn'],
                    'key'    => $v['name'],             //数据库原始key
                    'path'   => $v['permission_uri']
                ];
                $array[$v['name_group']]['permissions'][] = $tmp;
            }
        }
        //重置key值
        return array_values($array);
    }

    /**
     * 验证是否有权限
     * @param int $uid
     * @param string $path
     * @return bool
     * @throws DbException
     */
    public static function verify_permission(int $uid, string $path)
    {
        return DB::table('admin_user_has_roles as t1')->leftJoin('admin_role_has_permissions as t2', 't1.role_id', '=', 't2.role_id')
            ->leftJoin('admin_permissions as t3', 't2.permission_id', '=', 't3.id')
            ->where(['t1.user_id' => $uid, 't3.permission_uri' => $path])->exists();
    }

}
