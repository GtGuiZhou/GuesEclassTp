<?php

namespace app\command;

use app\common\model\ToparticleModel;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class TopArticleSpider extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('app\command\TopArticleSpider');
        // 设置参数
        
    }

    protected function execute(Input $input, Output $output)
    {
        (new ToparticleModel())->spider();
    }
}
