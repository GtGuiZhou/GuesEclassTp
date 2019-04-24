<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-6
 * Time: 上午1:44
 */



if (\think\facade\Env::get('APP_DEBUG',false))
    return [
        'host' => 'ssl://smtp.qq.com',
        'port' => 465,
        'username' => \think\facade\Env::get('EMAIL_USERNAME'),
        'password' => \think\facade\Env::get('EMAIL_PASSWORD'),
        'name' => '贵州工程应用技术学院易班发展中心后台系统',

        // 发送邮箱列表
        'to_video_audit' => ['735311619@qq.com'],
        'to_repair' => [ '735311619@qq.com'],
        'to_report_day' => [ '735311619@qq.com'],
        'to_feedback' => ['735311619@qq.com']
    ];
else
    return [
        'host' => 'ssl://smtp.qq.com',
        'port' => 465,
        'username' => \think\facade\Env::get('EMAIL_USERNAME'),
        'password' => \think\facade\Env::get('EMAIL_PASSWORD'),
        'name' => '贵州工程应用技术学院易班发展中心后台系统',

        // 发送邮箱列表
        'to_video_audit' => ['735311619@qq.com'],
        'to_repair' => ['2631790782@qq.com', '735311619@qq.com'],
        'to_report_day' => ['2631790782@qq.com', '735311619@qq.com'],
        'to_feedback' => ['735311619@qq.com']
    ];