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
        // 将userid注入到input中
        $request->user_id = $user['id'];
        return $next($request);
    }
}
