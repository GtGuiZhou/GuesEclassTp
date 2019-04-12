<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-12
 * Time: 下午4:43
 */

namespace app\command\timer;


use app\common\interfaces\ObserverInterface;
use app\common\model\EmailTaskModel;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

/**
 * 定时检测邮件并发送
 * Class EmailTaskTimer
 * @package app\command\timer
 */
class EmailTaskTimer implements ObserverInterface
{

    function handle()
    {
        swoole_timer_tick(5000,function (){
            $list = EmailTaskModel::where('state', 0)->select();
            echo "预备发送邮件数量<".count($list).'> - '.date('y-m-d h:i:s')."\r\n";
            foreach ($list as $item) {
                // 更改邮件状态为占用
                $item->save(['state' => '2']);
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
                // 更改邮件状态为已发送
                $item->save(['state' => '1']);
            }
        });
    }
}