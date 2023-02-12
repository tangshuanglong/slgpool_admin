<?php

/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

function user_func(): string
{
    return 'hello';
}

/**
 * 后台公共部分
 * @param $route
 * @param $data
 * @return mixed
 * @throws Throwable
 */
function admin_view($route, $data)
{
    //默认布局
    $layout = 'layouts/default.php';
    //获取公共信息（head,footer,left_menu,user）
    $common_info = context()->get('common_info');
    if (!$common_info) {
        $data['common_info'] = ['暂无信息'];
    } else {
        $data['common_info'] = $common_info;
    }

    return view($route, $data, $layout);
}

function get_decimal($number) {
    $number = strval($number);
    $count = 0;
    if (strpos($number, 'E-') !== false) {
        $temp = explode('E-', $number);
        $count = end($temp);
    } else {
        if (! is_numeric($number)) return 0;
        $temp = explode('.', $number);
        if (sizeof($temp) > 1) {
            $decimal = end($temp);
            $count = strlen($decimal);
        }
    }
    return $count;
}

/**
 * 数字格式化
 * @param $number
 * @return int|string
 */
function my_number_format($number) {
    if (! is_numeric($number)) return 0;
    $number_decimal = get_decimal($number);
    $number = number_format($number, $number_decimal, '.', '');
    return $number;
}
