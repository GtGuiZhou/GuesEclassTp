<?php

namespace app\http\middleware;

use think\facade\Request;

/**
 * 将用户绑定到当前input中
 * 新增数据时用到
 * Class UserBind
 * @package app\http\middleware
 */
class UserBind
{
    public function handle(Request $request, \Closure $next)
    {
        $user = user();
        // 将userid注入到input中
        $request->__set('user_id',$user['id']);
        return $next($request);
    }
}
