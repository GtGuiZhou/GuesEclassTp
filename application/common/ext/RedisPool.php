<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-21
 * Time: 下午4:07
 */

namespace app\common\ext;


class RedisPool
{
    /**
     * @var \Redis
     */
    private static $redis;

    public static function instance(){
        if (!self::$redis){
            self::$redis = new \Redis();
            if (!self::$redis)
                throw_validate_exception('redis服务初始化失败');
            self::$redis->connect(config('redis.hostname','127.0.0.1'),config('redis.port','6379'));
        }

        return self::$redis;
    }
}