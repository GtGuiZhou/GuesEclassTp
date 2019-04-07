<?php

namespace app\http\middleware;

use my\RedisPool;

/**
 * 将响应数据添加进首页列表
 * Class AddIndexList
 * @package app\http\middleware
 */
class AddIndexList
{
    /**
     * @param $request
     * @param \Closure $next
     * @param string $type 添加项的类型
     * @return mixed
     */
    public function handle($request, \Closure $next,$type)
    {
        $res = $next($request);
        $this->add($res->getData()['data'],$type);
        return $res;
    }

    private function add($item,$type){
        $redis = RedisPool::instance();
        $item['show_type'] = $type;
        $redis->lPush(config('redis.key_index_list'),json_encode($item));
    }
}
