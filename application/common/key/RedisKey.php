<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-9
 * Time: 下午8:42
 */

namespace app\common\key;


class RedisKey
{
    // 首页显示列表
    public static $IndexList = 'index:list';
    // 视频标签集合
    public static $TagVideoList = 'tag:video:list';
    // 视频标签关联
    public static $TagVideoRelation = 'tag:video:relation';
    // 人人墙评论列表
    public static $HumanwallCommentList = 'humanwall:comment:list';
}