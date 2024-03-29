<?php

namespace App\Rpc\Lib;

/**
 * Interface JPushInterface
 * @package App\Rpc\Lib
 */
interface JPushInterface
{

    /**
     * 推送消息给所有设备
     *
     * @param $title
     * @param $content
     * @return array
     */
    public function pushToAll($title, $content);
}
