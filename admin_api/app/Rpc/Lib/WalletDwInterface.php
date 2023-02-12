<?php

namespace App\Rpc\Lib;

/**
 * Interface WalletDwInterface
 */
interface WalletDwInterface{
    /**
     * 扣除可用金额，追加冻结金额
     * @param $uid
     * @param $amount
     * @param $coin_id
     * @param string $trade_type
     * @return bool
     * @throws \Swoft\Db\Exception\DbException
     */
    public function append_wallet_frozen(int $uid, string $amount, int $coin_id, string $trade_type);

    /**
     * 扣除冻结金额,返还可用金额
     * @param $uid
     * @param $amount
     * @param $coin_id
     * @param string $trade_type
     * @return bool
     * @throws \Swoft\Db\Exception\DbException
     */
    public function return_wallet_frozen(int $uid, string $amount, int $coin_id, string $trade_type);

    /**
     * 直接追加可用金额
     * @param $uid
     * @param $amount
     * @param $coin_id
     * @param string $trade_type
     * @return bool
     * @throws \Swoft\Db\Exception\DbException
     */
    public function append_wallet_free(int $uid, string $amount, int $coin_id, string $trade_type);

    /**
     * 直接扣除可用金额
     * @param $uid
     * @param $amount
     * @param $coin_id
     * @param string $trade_type
     * @return bool
     * @throws \Swoft\Db\Exception\DbException
     */
    public function deduct_wallet_free(int $uid, string $amount, int $coin_id, string $trade_type);

    /**
     * 直接扣除冻结金额
     * @param $uid
     * @param $amount
     * @param $coin_id
     * @param string $trade_type
     * @return bool
     * @throws \Swoft\Db\Exception\DbException
     */
    public function deduct_wallet_frozen(int $uid, string $amount, int $coin_id, string $trade_type);
}
