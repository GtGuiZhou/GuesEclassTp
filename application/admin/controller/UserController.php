<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\UserModel;

class UserController extends AdminBase
{
    protected function initialize()
    {
        $this->model = new UserModel();
    }
}