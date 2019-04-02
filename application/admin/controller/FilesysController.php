<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-6
 * Time: 下午6:20
 */

namespace app\admin\controller;


use app\common\controller\FilesysBase;
use app\common\model\FileSysModel;

class FilesysController extends FilesysBase
{

    /**
     * @var FileSysModel
     */
    protected $model = null;

    public function index()
    {
        $order = input('order', 'desc');
        $index = input('index', 1);
        $size = input('size', 10);
        $list = $this->model
            ->order($this->model->getPk(), $order)
            ->page($index, $size)
            ->select();
        $total = $this->model
            ->count($this->model->getPk());
        return success(['list' => $list,'page' => [
            'index' => (int)$index,'size' => (int)$size,'total' =>  (int)$total
        ]]);
    }

    public function delete(){
        $model = $this->model->findOrFail(input('id'));
        $model->delete();
        return success();
    }
}