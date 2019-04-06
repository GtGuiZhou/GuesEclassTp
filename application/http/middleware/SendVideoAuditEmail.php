<?php

namespace app\http\middleware;

use app\common\lib\AuditCode;
use my\Email;
use think\facade\Log;

/**
 * 发送视频审核邮件
 * Class SendVideoAuditEmail
 * @package app\http\middleware
 */
class SendVideoAuditEmail
{
    public function handle($request, \Closure $next)
    {
        $res = $next($request);
        // 生成邮件内容
        $email_content = file_get_contents('static/view/video_audit_email.html');
        $email = new Email();
        $email->setContent($email_content)
            ->setTitle('视频审核通知')
            ->setTo(config('email.to_video_audit'))
            ->setVars([
                'through_url' => AuditCode::auditUrl('api/video/through',$res->getData()['data']['id']),
                'unthrough_url' => AuditCode::auditUrl('api/video/unthrough',$res->getData()['data']['id']),
                'video_url' => input('url')
            ])->send();
        Log::notice('视频审核通知');

        return $res;
    }

}

