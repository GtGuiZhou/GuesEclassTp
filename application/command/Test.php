<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-28
 * Time: 下午1:11
 */

namespace app\command;


use think\console\Command;
use think\console\Input;
use think\console\Output;
use zf\Main;

class Test extends Command
{
    protected function configure()
    {
        $this->setName('test');
    }

    protected function execute(Input $input, Output $output)
    {
        $main = new Main();
        $main->checkCode();
//        $page = $main->login('35351316237','guotao48','2134');
    }


}