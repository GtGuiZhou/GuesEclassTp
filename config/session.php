<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 会话设置
// +----------------------------------------------------------------------

return [
    'id'             => '',
    // SESSION_ID的提交变量,解决flash上传跨域
    'var_session_id' => '',
    // SESSION 前缀
    'prefix'         => 'tp_session',
    // 驱动方式 支持redis memcache memcached
    'type'           => 'redis',
    // 是否自动开启 SESSION
    'auto_start'     => true,

    // redis主机
    'host' => \think\facade\Env::get('REDIS_HOSTNAME'),

    // redis端口
    'port'       => \think\facade\Env::get('REDIS_PORT'),
    // 密码
    'password'   => \think\facade\Env::get('REDIS_PASSWORD'),

    // 会话过期时间
    'expire'  => '86400' //24小时
];
