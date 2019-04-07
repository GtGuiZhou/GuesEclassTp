<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-7
 * Time: 下午8:35
 */

namespace app\api\controller;


use my\RedisPool;

class IndexController
{
    public function indexall(){
        $redis = RedisPool::instance();
        return success($redis->lGetRange(config('redis.key_index_list'),0,-1));
    }
}