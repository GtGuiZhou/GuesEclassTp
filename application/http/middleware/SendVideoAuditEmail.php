<?php

namespace app\http\middleware;

use app\common\lib\AuditCode;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use think\Db;

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
        $email_content = file_get_contents('static/view/VideoAuditEmail.html');
        // 生成临时授权代码
        $code = AuditCode::build();
        $param = "audit_code=$code&id=".$res->getData()['data']['id'];
        $email_content = $this->view($email_content,[
            'video_url' => input('url'),
            'through_url' => url('video/through?'.$param,'',false,true),
            'unthrough_url' => url('video/unthrough?'.$param,'',false,true),
        ]);
        // 发送邮件
        send_email(config('email.to_video_audit'),'视频审核通知',$email_content,'text/html');

        return $res;
    }

    public function view ($content,$vars) {
        foreach ($vars as $key => $var){
            $content = str_replace('${'.$key.'}',$var,$content);
        }

        return $content;
    }
}

