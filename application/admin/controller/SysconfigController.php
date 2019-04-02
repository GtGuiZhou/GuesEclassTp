<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-6
 * Time: 下午12:25
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\SysConfigModel;

class SysconfigController extends AdminBase
{

    protected $addAfterResponseType = 'model';

    protected function initialize()
    {
        $this->model = new SysConfigModel();
    }

    public function add()
    {
        if ($this->model->where('field',input('field'))->find())
            throw_validate_exception('该字段已存在');
        return parent::add();
    }

    public function indexAll()
    {
        // 将索引变为field
        $res = $this->model->select();
        $config = [];
        foreach ($res as &$val){
            $config[$val['field']] = $val;
        }
        return success($config);
    }
}