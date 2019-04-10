<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-21
 * Time: 下午4:19
 */

use think\facade\Env;

return [
    'hostname'        => ENV::get('REDIS_HOSTNAME'),
    'port'        => ENV::get('REDIS_PORT'),
];