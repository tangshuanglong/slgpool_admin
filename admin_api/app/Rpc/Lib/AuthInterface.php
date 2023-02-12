<?php

namespace App\Rpc\Lib;

/**
 * Interface VerifyCodeInterface
 */
interface AuthInterface{

    /**
     * 刷新用户信息缓存
     * @param int $uid
     * @return bool|int|string
     * @throws \Swoft\Db\Exception\DbException
     */
    public function reset_user_all_info(int $uid);

}
