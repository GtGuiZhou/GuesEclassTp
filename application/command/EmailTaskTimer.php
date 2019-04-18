<?php

namespace app\command;

use app\common\model\EmailTaskModel;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Exception;
use think\facade\Log;

class EmailTaskTimer extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('app\command\emailtasktimer');
    }

    protected function execute(Input $input, Output $output)
    {
        $list = EmailTaskModel::where('state', 0)->select();
        Log::notice("预备发送邮件数量<".count($list).'> - '.date('y-m-d h:i:s'));
        foreach ($list as $item) {
            // 更改邮件状态为占用
            $item->save(['state' => '2']);
            try{
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
            } catch (Exception $e){
                // 更改邮件状态为发送失败
                $item->save(['state' => '3']);
                Log::notice($e->getMessage() . ' - ' .date('y-m-d h:i:s'));
            }
        }
    }
}
