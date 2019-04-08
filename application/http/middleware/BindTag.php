<?php

namespace app\http\middleware;

use my\RedisPool;

/**
 * 绑定标签中间件
 * Class BindTag
 * @package app\http\middleware
 */
class BindTag
{
    public function handle($request, \Closure $next,$params)
    {
        $tags = input('tags');
        if ($tags && !is_array($tags)){
            throw_validate_exception('标签必须是数组类型');
        }

        // 执行中间件
        $res = $next($request);

        // 执行标签绑定操作
        list($key_list,$key_relation) = $params;
        $this->bind($res->getData()['data']['id'],$tags,$key_list,$key_relation);

        return $res;
    }

    private function bind($id,$tags,$key_list,$key_relation){
        $redis = RedisPool::instance();
        // 将标签添加到标签集合
        $redis->sAddArray($key_list,$tags);

        // 将标签和目标关联
        foreach ($tags as $tag){
            $redis->sAdd("$key_relation:$tag",$id);
        }
    }
}
