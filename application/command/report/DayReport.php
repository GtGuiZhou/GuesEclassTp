<?php

namespace app\command\report;

use app\common\key\RedisManager;
use app\common\model\EmailTaskModel;
use app\common\model\RepairModel;
use app\common\model\ToparticleModel;
use my\Email;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\View;

class DayReport extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('app\command\dayreport');
        // 设置参数
        
    }

    protected function execute(Input $input, Output $output)
    {

        $repair = RepairModel::where('state','未处理')->select();
        $topArticle = ToparticleModel::whereTime('update_time','today')->select();
        $view_number = RedisManager::getViewNumber7Days();
        $exception_number = RedisManager::getExceptionNumber7Days();
        $date_range = array_keys($view_number);

        $html = View::display(file_get_contents('application/api/view/report/day.html'),[
            'repair_list' => $repair,
            'top_article_list' => $topArticle,
            'view_number' => $view_number,
            'exception_number' => $exception_number,
            'date_range' => $date_range
        ]);

    	$email = new Email('日常报告',$html,config('email.to_report_day'));
        EmailTaskModel::create($email->getConfig());
    	$output->writeln('发送报告成功');
    }
}
