<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\LovewallModel;

class LovewallController extends AdminBase
{
    protected function initialize()
    {
        $this->model = new LovewallModel();
    }
}