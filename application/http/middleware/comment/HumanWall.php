<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-9
 * Time: 下午7:53
 */

namespace app\http\middleware\comment;


use app\common\interfaces\ObserverInterface;
use app\common\key\RedisKey;
use my\RedisPool;

class HumanWall implements ObserverInterface
{

    public function handle()
    {
        $module = input('module');
        if (strpos($module,'humanwall') === 0){
            // id为当前人人墙的id
            list($module,$id) = explode(':',input('module'));
            $redis = RedisPool::instance();
            $key = RedisKey::$HumanwallCommentList;
            $key = "$key:$id";
            $redis->lPush($key,input('content'));
            $redis->expire($key,config('humanwall.expire'));
        }
    }
}