<?php

namespace app\http\middleware;

use app\common\lib\AuditCode;
use think\exception\ValidateException;

/**
 * 临时授权代码检测
 * Class AuditCodeCheck
 * @package app\http\middleware
 */
class AuditCodeCheck
{
    public function handle($request, \Closure $next)
    {
        if (AuditCode::check(input(AuditCode::$key))){
            return $next($request);
        } else {
            throw new ValidateException('您无权执行该操作，或您的权限已经失效');
        }
    }

}
