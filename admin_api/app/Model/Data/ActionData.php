<?php


namespace App\Model\Data;

use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;

/**
 * Class ActionData
 * @package App\Model\Data
 */
class ActionData
{
    /**
     * 获取权限列表
     * @param int $page_index
     * @param string $search_key
     * @return array|bool
     * @throws DbException
     */
    public static function get_action_list(int $page_index, string $search_key)
    {
        if (!empty($search_key)) {
            $where = array(['action_name', 'LIKE', "%$search_key%"]);
        } else {
            $where = [];
        }
        $per_num = config('per_page_num');
        $action = DB::table('admin_actions as t1')
            ->select('t1.action_id', 't1.action_name', 't1.action_url', 't1.parent_id', 't1.label', 't2.action_name as parent_name')
            ->leftjoin('admin_actions as t2', 't2.action_id', '=', 't1.parent_id')
            ->where('t1.action_name', 'LIKE', '%'.$search_key.'%')
            ->forPage($page_index, $per_num)
            ->get()
            ->toArray();

        if (!$action) {
            return false;
        }

        $data = [];
        foreach ($action as $key => $value) {
            //数据处理
            if($value['label'] == '1'){
                $value['label'] = '第一层';
            }elseif($value['label'] == '2'){
                $value['label'] = '第二层';
            }elseif($value['label'] == '3'){
                $value['label'] = '第三层';
            }
            if(empty($value['action_url'])){
                $value['action_url'] = '无';
            }
            if(empty($value['parent_name'])){
                $value['parent_name'] = '无';
            }
            $data['info'][] = $value;
        }
        $data['count'] = DB::table('admin_actions')->where($where)->count();
        return $data;
    }

    /**
     * 删除权限
     * @param $id
     * @return bool
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function delete_action($id)
    {
        $res = DB::table('admin_actions')
            ->where('action_id', $id)
            ->delete();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取权限信息
     * @param $id
     * @return array|bool
     * @throws DbException
     */
    public static function get_action_info($id)
    {
        $action = DB::table('admin_actions')
            ->select('action_id', 'action_name', 'action_url', 'parent_id', 'label')
            ->where('action_id', $id)
            ->get();

        if (!$action) {
            return false;
        }

        $data = [];
        foreach ($action as $v) {
            $data = $v;
        }
        return $data;
    }

    /**
     * 获取父级权限信息
     * @param $label
     * @return array|bool|mixed
     * @throws DbException
     */
    public static function get_label($label)
    {
         $action = DB::table('admin_actions')
            ->select('action_id', 'action_name')
            ->where('label', $label - 1) //取父级层次
            ->get();
        if (!$action) {
            return false;
        }
        $data = [];
        foreach ($action as $v) {
            $data[] = $v;
        }
        return $data;
    }

    /**
     * 添加权限
     * @param $info
     * @return bool|string
     * @throws DbException
     * @throws ReflectionException
     * @throws ContainerException
     */
    public static function add_action($info)
    {
        //添加管理员
        $id = DB::table('admin_actions')->insertGetId([
            'action_name'  => $info['action_name'],
            'action_url'  => $info['action_url'],
            'parent_id'  => $info['parent_id'],
            'label'  => $info['label']
        ]);
        if ($id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新权限
     * @param $info
     * @return bool|int
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function update_action($info)
    {
         $res = DB::table('admin_actions')
            ->where('action_id', $info['action_id'])
            ->update([
                'action_name' => $info['action_name'],
                'action_url' => $info['action_url'],
                'label' => $info['label'],
                'parent_id' => $info['parent_id']
            ]);
        return $res;
    }

    /**
     *获取权限树状图
     */
    public static function  get_action_tree()
    {
        $action = DB::table('admin_actions')
            ->select('action_id', 'action_name', 'action_url', 'parent_id', 'label')
            ->get();

        if (!$action) {
            return false;
        }
        $data = [];
        //数据分层
        foreach($action as $value){
            if($value['label'] == '1'){
                $data['first'][$value['action_id']] = $value;
            }
            if($value['label'] == '2'){
                $data['first'][$value['parent_id']]['second'][$value['action_id']] = $value;
            }
            if($value['label'] == '3'){
                foreach($data['first'] as $k => $val){
                    if(isset($data['first'][$k]['second'][$value['parent_id']])){
                        $data['first'][$k]['second'][$value['parent_id']]['third'][$value['action_id']] = $value;
                    }

                }
            }
        }
        return $data;
    }

    /**
     * 获取左边菜单栏信息
     * @return array
     * @throws DbException
     */
    public static function left_menu()
    {
        $menu        = array();
        $sub_menu    = array();

        $parent_menu = DB::table('admin_actions')
            ->where(['label'=>'1'])
            ->get()->toArray(); //获取父集

        $result = DB::table('admin_actions')
            ->where(['label'=>'2'])
            ->get()->toArray(); //获取子集

        //子集分组
        foreach ($result as $value) {
            $sub_menu[$value['parent_id']][] = $value;
        }
        //父集分组
        foreach ($parent_menu as $val) {
            $menu[$val['action_id']] = $val;
            if(isset($sub_menu[$val['action_id']])){
                $menu[$val['action_id']]['sub_menu'] = $sub_menu[$val['action_id']];
            }
        }
        return $menu;
    }

    /**
     * 获取用户的所有权限列表
     * @param $user_id
     * @return array
     * @throws DbException
     */
    public static function get_user_action($user_id)
    {
        $url_arr  = array();
        $menu_id = array();
        $arr = array();
        $res = array();
        $role_data = DB::table('admin_role_user')->where('user_id', $user_id)
            ->get()->toArray();
        //获取用户所属的所有角色的权限
        foreach($role_data as $val){
            $arr[] = DB::table('admin_auth as p1')
                ->leftjoin('admin_actions as p2', 'p1.action_id', '=', 'p2.action_id')
                ->where(array('p1.role_id' => $val['role_id']))->get()->toArray();
        }
        //数组处理，取出所有权限url和菜单栏id
        if(!empty($arr))
        {
            foreach($arr as $val){
                foreach($val as $v){
                    $res[$v['action_id']] = $v;
                }
            }
            foreach ($res as $value) {
                $url_arr[] = $value['action_url'];
                //记录导航栏id
                if($value['action_url'] == '') //最大导航栏
                {
                    $menu_id[] = $value['action_id'];
                }
            }
        }
        return array(
            'url_arr' => $url_arr,
            'menu_id' => $menu_id,
        );

    }


}
