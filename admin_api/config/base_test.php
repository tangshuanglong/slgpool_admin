<?php
return [
    'name'  => 'Swoft framework 2.0',
    'debug' => env('SWOFT_DEBUG', 1),

    'app_sign_timeout'       => 86400,//签名超时时间
    'app_sign_cache_timeout' => 3600,//签名缓存超时时间

    'aes_encryption_key' => '43743c86523cd414916415229e3241d2f174dc14133999c4f093054172ec1261',//aes秘钥
    'hmac_key'           => '5f6e16554bfb8437799765659f3b1b5c69fbcfe0f65747f69231dcb2065227aa',


    'invite_prefix'            => 16598450,//推荐id前缀

    //登录错误次数
    'login_error_limit'        => 5,

    //二步登录过期时间
    'second_login_expire_time' => 3600,

    //consul注册配置
    'consul'                   => [
        'address' => '127.0.0.1',
        'port'    => 86,
        'name'    => 'at',
        'id'      => 'at',
    ],

    //rabbitmq
    'rabbitmq'                 => [
        'host'     => '127.0.0.1',
        'port'     => 5672,
        'user'     => 'slg_prod',
        'password' => 'Shuanglong_1732',
        'vhost'    => 'slg_vhost',
    ],

    //登录的用户信息缓存key
    'login_user_info_key'      => 'login_user_info_key',
    'field_prefix'             => 'login_',

    //不能提现的缓存k
    'not_withdraw_key'         => 'not_withdraw_key',
    'not_withdraw_time'        => 86400,

    //谷歌验证码
    'google_secret_key'        => 'google_secret_key',
    'google_secret_title'      => 'bits',

    //修改手机
    'modify_mobile_key'        => 'modify_mobile_key',

    //七牛 AccessKey/SecretKey
    'accesskey'                => 'LwXbwtlypcFrWkOQuUCiIgosKN0HW05xGDXy5wkU',
    'secretkey'                => 'gm2_QVnh_Cg6F5g8opKppOHz98c0L7wC_JIlNI6t',
    'bucket'                   => 'bitsw',
    'qiniu_domain'             => 'https://file.slgpool.com',  //访问七牛云域名
    'qi_niu_callback_url'      => 'https://app-test.slgpool.com/api/sys/v1/callback/index',
//    'ssldir' => '/kyquant/ssl/coin/',  // SSL证书路径
//    'user_upload_path' => 'static/images/Upload/user/', //用户上传图片主路径
//    'qiniu_domain' => 'https://images.kyquant.com',  //访问七牛云域名
//    'accesskey' => 'LwXbwtlypcFrWkOQuUCiIgosKN0HW05xGDXy5wkU', //七牛云ak
//    'secretkey' => 'gm2_QVnh_Cg6F5g8opKppOHz98c0L7wC_JIlNI6t', //七牛云sk
//    'bucket' => 'kyquant',  //七牛云存储空间名


    'per_page_num' => 2, //分页数

    'user_online_key'     => 'user:online', // 在线用户
    'user_online_ids_key' => 'user:online:ids', // 在线用户ID

    'login_error_key'   => 'user:login:error:',//登录错误次数记录key
    'login_error_times' => 5,

    'file_domain' => 'http://192.168.0.187:8880',

    'table_coin' => 'cache:table:coin',

    'mining_product_limited' => 'mining:product:limited:',
    'power_product_limited'  => 'power:product:limited:',
    'chia_product_limited'   => 'chia:product:limited:',
    'bzz_product_limited'    => 'bzz:product:limited:'


];
