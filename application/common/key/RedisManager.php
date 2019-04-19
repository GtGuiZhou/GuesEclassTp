<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-9
 * Time: 下午8:42
 */

namespace app\common\key;


use my\RedisPool;

if (!RedisManager::$redis )
    RedisManager::$redis  = RedisPool::instance();
class RedisManager
{
    /**
     * @var \Redis
     */
    public static $redis = null;

    /**
     * 自增浏览量
     */
    public static function incViewNumber(){
        self::$redis->incr('view:number:'.date('Y:m:d'));
    }

    /**
     * 获取最近七天的浏览量
     * @return mixed
     */
    public static function getViewNumber7Days(){
        return self::getDaysDate('view:number',7,0);
    }


    /**
     * 自增异常量
     */
    public static function incExceptionNumber(){
        self::$redis->incr('exception:number:'.date('Y:m:d'));
    }


    /**
     * 获取最近七天的异常数量
     * @return mixed
     */
    public static function getExceptionNumber7Days(){
        return self::getDaysDate('view:number',7,0);
    }

    /**
     * 返回最近指定天数的数据
     * @return mixed
     */
    private static function getDaysDate($key,$day_number,$default_value = false){
        $i = 0;
        $list = [];
        while ($i < $day_number){
            $year = date("Y", strtotime("-$i day"));
            $mon = date("m", strtotime("-$i day"));
            $day = date("d", strtotime("-$i day"));
            $val = self::$redis->get("$key:$year:$mon:$day");
            $list["$year-$mon-$day"] = $val?$val:$default_value;
            $i++;
        }

        return $list;
    }

}