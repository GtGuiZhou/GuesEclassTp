<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-11
 * Time: 下午7:53
 */

namespace app\common\task;


use app\common\model\EmailTaskModel;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendEmail extends TaskBase
{

    public function handle()
    {
        $list = EmailTaskModel::where('state', 0)->select();
        foreach ($list as $item) {
            $title = $item['title'];
            $to = $item['to_email'];
            $content = $item['content'];
            $type = $item['content_type'];
            // 发送邮件
            $transport = (new Swift_SmtpTransport(config('email.host'), config('email.port')))
                ->setUsername(config('email.username'))
                ->setPassword(config('email.password'));
            $mailer = new Swift_Mailer($transport);
            $message = (new Swift_Message($title))
                ->setFrom([config('email.username') => config('email.name')])
                ->setTo($to)
                ->setBody($content, $type);
            $mailer->send($message);
        }
    }
}