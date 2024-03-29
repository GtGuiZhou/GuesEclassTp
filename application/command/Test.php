<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-28
 * Time: 下午1:11
 */

namespace app\command;


use app\api\controller\ZfController;
use app\common\key\RedisManager;
use app\common\model\UserModel;
use app\http\middleware\SendVideoAuditEmail;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\facade\Session;
use think\facade\View;
use zf\Main;

class Test extends Command
{
    protected function configure()
    {
        $this->setName('test');
    }

    protected function execute(Input $input, Output $output)
    {
        echo __DIR__;
        echo View::fetch('static/view/error/index.html',['content' => 'test']);
    }


}