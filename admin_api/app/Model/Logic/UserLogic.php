<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Model\Logic;

use Swoft\Db\DB;

class UserLogic
{
    /**
     * 判断是否死循环
     * @param $uid int 用户id
     * @param $invitor_uid int 邀请推荐id
     * @return boolean
     * */
    public function is_endless_loop($uid, $invitor_uid)
    {
        $invitor_uid_arr = $this->getParent($invitor_uid);
        if(empty($invitor_uid_arr)){
            return false;
        }
        return in_array($uid, $invitor_uid_arr);
    }

    /**
     * 查找所有上级
     * @$uid 用户id
     * @return array
     * */
    public function getParent(int $uid, &$arr = []): array
    {
        $user = DB::table('user_basical_info')->select('id', 'invitor_uid')->where(['id' => $uid])->first();
        if ($user['invitor_uid'] > 0) {
            $arr[] = $user['invitor_uid'];
            $this->getParent($user['invitor_uid'], $arr);
        }
        return $arr;
    }

}
