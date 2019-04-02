<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-8
 * Time: 上午12:34
 */

namespace app\common\lib;


use think\facade\Cache;
use think\Request;

/**
 * 在访问点赞功能之前，调用当前中间件，能够检测同一IP是否点过赞
 * 点赞过后继续点赞会报错
 * Class StarControllerTrait
 * @package app\common\lib
 */
class StarValidateIpMiddle
{
    public function handle($request, \Closure $next)
    {
        $ip = request()->ip();
        if (Cache::get("star:ip:$ip")){
            return warning('您已经点赞过了');
        }
        return $next($request);
    }
}