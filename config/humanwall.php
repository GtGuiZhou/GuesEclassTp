<?php
/**
 * Created by PhpStorm.
 * Desc: 人人墙配置
 * User: gtguizhou
 * Date: 19-4-9
 * Time: 下午8:21
 */

return [
    // 保存在redis中数据的过期时间
    'expire' => 3600,
    // redis保存最大评论数量
    'max_number' => 300,
    // 每次最多取多少条评论
    'each_number' => 30
];