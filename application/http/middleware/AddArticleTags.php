<?php

namespace app\http\middleware;

use app\common\ext\RedisPool;

class AddArticleTags
{
    public function handle($request, \Closure $next)
    {

        if (is_array(input('tags'))){
            $redis = RedisPool::instance();
            $redis->sAddArray('article:tags',input('tags'));
        }

        return $next($request);
    }
}
