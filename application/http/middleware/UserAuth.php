<?php

namespace app\http\middleware;

use think\Model;
use think\Request;

/**
 * 用户鉴权中间件
 * 删除数据、编辑数据的时候用到
 * 数据库必须按照id为主键字段,user_id为关联用户的格式才能正常工作
 */
class UserAuth
{
    public function handle(Request $request, \Closure $next,Model $model)
    {
        $model = $model
            ->where('id',$request->param('id'))
            ->where('user_id',user()['id'])
            ->findOrFail();
        return $next($request);
    }
}
