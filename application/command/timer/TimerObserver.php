<?php

namespace app\command\timer;

use app\common\interfaces\ObserverInterface;
use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * 定时器观察者命令
 * 该命令被执行后，能够自动发现当前目录下的定时器类（即基础了ObserverInterface的类），并且调用该类的handle
 * Class TimerObserver
 * @package app\command\timer
 */
class TimerObserver extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('app\command\timerobserver');
        // 设置参数
        
    }

    protected function execute(Input $input, Output $output)
    {
        $handle = opendir(__DIR__);
        while(($fl = readdir($handle)) !== false){
            if ($fl != '.' && $fl != '..'){
                $class = __NAMESPACE__."\\".$fl;
                $class = trim($class,'.php');
                $timer = new $class;
                if ($timer instanceof ObserverInterface){
                    $timer->handle();
                }
            }
        }
    }
}
