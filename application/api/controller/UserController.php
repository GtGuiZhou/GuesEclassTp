<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-26
 * Time: 下午8:44
 */

namespace app\api\controller;


use app\common\controller\ApiBase;
use app\common\model\UserModel;

class UserController extends ApiBase
{
    protected $limitAction = ['except' => 'info'];

    protected function initialize()
    {
        $this->model = new UserModel();
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function info(){
        return success($this->user());
    }
}   