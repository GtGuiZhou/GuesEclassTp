<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-6
 * Time: 上午12:42
 */

namespace app\common\lib;



use my\RedisPool;

class AuditCode
{
    public static $key = 'audit_code';
    public static function check($code){
        $redis = RedisPool::instance();
        if (!$code || !$redis->sIsMember(self::$key,$code)){
            return false;
        } else {
            // 删除临时授权代码
            $redis->sRemove(self::$key,$code);
            return true;
        }
    }

    public static function build(){
        $code = self::uuid();
        $redis = RedisPool::instance();
        $redis->sAdd(self::$key,$code);
        return $code;
    }

    /**
     * 返回一个含有id的授权地址
     * @param $url
     * @param $id
     * @return string
     */
    public static function auditUrl($url,$id){
        return url($url,'audit_code='.AuditCode::build().'&id='.$id,false,request()->domain());
    }


    /**
     * 获取全球唯一标识
     * @return string
     */
    private static function uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}