<?php

namespace app\http\middleware;

use app\common\model\UserModel;
use think\exception\ValidateException;
use think\Model;
use think\Request;

/**
 * 用户鉴权中间件
 * 删除数据、编辑数据的时候用到
 * 数据库必须按照id为主键字段,user_id为关联用户的格式才能正常工作
 */
class UserAuth
{
    public function handle(Request $request, \Closure $next, Model $model)
    {

        $flag = $model
            ->where('id', $request->param('id'))
            ->where('user_id', user()['id'])
            ->find();
        if (!$flag)
            throw new ValidateException('该项数据不属于您，或您无权操作');
        return $next($request);
    }
}
