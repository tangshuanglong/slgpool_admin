<?php

namespace App\Rpc\Lib;

/**
 * Interface CoinInterface
 * @package App\Lib
 */
interface CoinInterface{

    /**
     * 获取币种对应换算单位的最新价格
     * @param string $coin_type
     * @param string $price_type
     * @return string
     */
    public function get_coin_last_price(string $coin_type, string $price_type);
}
