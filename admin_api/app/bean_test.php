<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

use App\Common\DbSelector;
use App\Process\MonitorProcess;
use Swoft\Crontab\Process\CrontabProcess;
use Swoft\Db\Pool;
use Swoft\Http\Server\HttpServer;
use Swoft\Task\Swoole\SyncTaskListener;
use Swoft\Task\Swoole\TaskListener;
use Swoft\Task\Swoole\FinishListener;
use Swoft\Rpc\Client\Client as ServiceClient;
use Swoft\Rpc\Client\Pool as ServicePool;
use Swoft\Rpc\Server\ServiceServer;
use Swoft\Http\Server\Swoole\RequestListener;
use Swoft\WebSocket\Server\WebSocketServer;
use Swoft\Server\SwooleEvent;
use Swoft\Db\Database;
use Swoft\Redis\RedisDb;

return [
    'view'               => [
        // class 配置是可以省略的, 因为 view 组件里已经配置了它
        // 'class' => \Swoft\View\Renderer::class,
        'viewsPath' => dirname(__DIR__) . '/resource/views/',
        //  'layout' => 'layouts/default.php'
    ],
    'noticeHandler'      => [
        'logFile' => '@runtime/logs/notice-%d{Y-m-d-H}.log',
    ],
    'applicationHandler' => [
        'logFile' => '@runtime/logs/error-%d{Y-m-d}.log',
    ],
    'logger'             => [
        'flushRequest' => false,
        'enable'       => false,
        'json'         => false,
    ],
    'httpServer'         => [
        'class'    => HttpServer::class,
        'port'     => 8800,
        'pidName'  => 'admin-http',
        //同时启动的服务
        'listener' => [
            //'rpc' => bean('rpcServer')
        ],
        //同时启动的进程
        'process'  => [
//            'monitor' => bean(MonitorProcess::class)
//            'crontab' => bean(CrontabProcess::class)
        ],
        //绑定事件
        'on'       => [
            SwooleEvent::TASK   => bean(SyncTaskListener::class),  // Enable sync task
            SwooleEvent::TASK   => bean(TaskListener::class),  // Enable task must task and finish event
            SwooleEvent::FINISH => bean(FinishListener::class)
        ],
        //设置进程数和task进程数
        /* @see HttpServer::$setting */
        'setting'  => [
            'task_worker_num'       => 12,
            'task_enable_coroutine' => true,
            'worker_num'            => 6,
            //设置最大上传文件大小8m
            'package_max_length'    => 8 * 1024 * 1024,
            // enable static handle
            //'enable_static_handler'    => true,
            // swoole v4.4.0以下版本, 此处必须为绝对路径
            //'document_root'            => dirname(__DIR__) . '/public',
            'log_file'              => alias('/logs/web_server/admin_api.log')
        ]
    ],
    'httpRoute'          => [
        'class'                  => HttpServer::class,
        //是否忽略url path最后的/, 默认值为true
        'ignoreLastSlash'        => false,
        //是否处理 MethodNotAllowed,为了加快匹配速度，默认method不匹配也是直接抛出 Route not found 错误。如有特殊需要可以开启此选项，开启后将会抛出 Method Not Allowed 错误
        'handleMethodNotAllowed' => true,
        //动态参数路由匹配后会缓存下来，下次相同的路由将会更快的匹配命中。
        'tmpCacheNumber'         => 500,
    ],
    'httpDispatcher'     => [
        // Add global http middleware
        'middlewares'      => [
            //\Swoft\Http\Session\SessionMiddleware::class,
            // Allow use @View tag
            //\Swoft\View\Middleware\ViewMiddleware::class,
            \App\Http\Middleware\BaseMiddleware::class,
            \App\Http\Middleware\FavIconMiddleware::class,
            //   \App\Http\Middleware\AdminAuthMiddleware::class,
        ],
        'afterMiddlewares' => [
            \Swoft\Http\Server\Middleware\ValidatorMiddleware::class
        ]
    ],
    'db'                 => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=slgpool_online;host=127.0.0.1:3306',
        'username' => 'root',
        'password' => 'Shuanglong_1732',
        'charset'  => 'utf8mb4',
        'prefix'   => 'bt_',
    ],

    // 注意Bean大小写
//    'sessionManager' => [
//        'class' => \Swoft\Http\Session\SessionManager::class,
//        'config' => [
//            'driver' => 'redis',
//            'name' => 'SWOFT_SESSION_ID',
//            'lifetime' => 3600*8,
//            'expire_on_close' => false,
//            'encrypt' => false,
//            //'storage' => '@runtime/sessions',
//        ],
//    ],

    'migrationManager'  => [
        'migrationPath' => '@database/Migration',
    ],
    'redis'             => [
        'class'    => RedisDb::class,
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'password' => 'Shuanglong_1732',
        'database' => 0,
        'option'   => [
            'prefix'     => '',
            'serializer' => 0
        ]
    ],
    'redis.pool'        => [
        'class'       => \Swoft\Redis\Pool::class,
        'redisDb'     => bean('redis'),
        'minActive'   => 2,
        'MaxActive'   => 10,
        'maxWait'     => 0,
        'maxWaitTime' => 0,
        'maxIdleTime' => 5,
    ],
    'user'              => [
        'class'       => ServiceClient::class,
        'host'        => '127.0.0.1',
        'port'        => 18311,
        'setting'     => [
            'timeout'         => 5,
            'connect_timeout' => 2.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 5,
        ],
        'packet'      => bean('rpcClientPacket'),
        'isReconnect' => true
    ],
    'user.pool'         => [
        'class'  => ServicePool::class,
        'client' => bean('user'),
    ],
    'system'            => [
        'class'   => ServiceClient::class,
        'host'    => '127.0.0.1',
        'port'    => 18309,
        'setting' => [
            'timeout'         => 5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'system.pool'       => [
        'class'  => ServicePool::class,
        'client' => bean('system'),
    ],
    'auth'              => [
        'class'   => ServiceClient::class,
        'host'    => '127.0.0.1',
        'port'    => 18307,
        'setting' => [
            'timeout'         => 5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'auth.pool'         => [
        'class'  => ServicePool::class,
        'client' => bean('auth'),
    ],
    'rpcServer'         => [
        'class' => ServiceServer::class,
        'port'  => 18307,
    ],
    'wsServer'          => [
        'class'   => WebSocketServer::class,
        'port'    => 18308,
        'on'      => [
            // Enable http handle
            SwooleEvent::REQUEST => bean(RequestListener::class),
        ],
        'debug'   => 1,
        // 'debug'   => env('SWOFT_DEBUG', 0),
        /* @see WebSocketServer::$setting */
        'setting' => [
            'log_file' => alias('@runtime/swoole.log'),
        ],
    ],
    'tcpServer'         => [
        'port'  => 18307,
        'debug' => 1,
    ],
    /** @see \Swoft\Tcp\Protocol */
    'tcpServerProtocol' => [
        // 'type'            => \Swoft\Tcp\Packer\JsonPacker::TYPE,
        'type' => \Swoft\Tcp\Packer\SimpleTokenPacker::TYPE,
        // 'openLengthCheck' => true,
    ],
    'cliRouter'         => [
        // 'disabledGroups' => ['demo', 'test'],
    ]
];
