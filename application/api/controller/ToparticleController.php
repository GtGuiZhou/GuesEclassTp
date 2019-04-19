<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-26
 * Time: 下午8:44
 */

namespace app\api\controller;


use app\common\controller\ApiBase;
use app\common\model\ToparticleModel;

class ToparticleController extends ApiBase
{
    protected $limitAction = ['except' => 'indexAll,index'];

    protected function initialize()
    {
        $this->model = new ToparticleModel();
        parent::initialize(); // TODO: Change the autogenerated stub
    }
}   