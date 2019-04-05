<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-6
 * Time: 上午1:44
 */

return [
    'username' => \think\facade\Env::get('EMAIL_USERNAME'),
    'password' => \think\facade\Env::get('EMAIL_PASSWORD'),

    // 发送邮箱列表
    'to_video_audit' => ['735311619@qq.com']
];