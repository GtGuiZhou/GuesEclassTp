<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-26
 * Time: 下午8:44
 */

namespace app\api\controller;


use app\common\controller\ApiBase;
use app\common\model\CommentModel;
use app\common\model\TipModel;

class CommentController extends ApiBase
{
    protected $limitAction = ['except' => 'indexAll,index,add'];
    protected $addAfterResponseType = 'model';

    protected function initialize()
    {
        $this->model = new CommentModel();
        parent::initialize();
    }

    public function indexAll()
    {
        return success($this->model->where('module',input('module'))->select());
    }

    public function index(){
        return success($this->model->where('module',input('module'))
            ->order('id','desc')
            ->page(input('index'))
            ->select());
    }



}   