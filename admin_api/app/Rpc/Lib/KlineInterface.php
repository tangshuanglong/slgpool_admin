<?php

namespace App\Rpc\Lib;

/**
 * Interface KlineInterface
 * @package App\Rpc\Lib
 */
interface KlineInterface
{

    /**
     * 获取币币价格
     *
     * @param string $coin_name
     * @param string $quote_name
     * @return int|mixed
     * @throws \Swoft\Db\Exception\DbException
     */
    public function get_last_close_price(string $coin_name, string $quote_name);
}
