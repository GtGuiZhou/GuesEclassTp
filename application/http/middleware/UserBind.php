<?php

namespace app\http\middleware;

/**
 * 将用户绑定到当前input中
 * 新增数据时用到
 * Class UserBind
 * @package app\http\middleware
 */
class UserBind
{
    public function handle($request, \Closure $next)
    {
        $user = user();
        // 将user的一些信息注入到input中
        $request->user_id = $user['id'];
        $request->user_name = $user['username'];
        return $next($request);
    }
}
