<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-26
 * Time: 下午8:44
 */

namespace app\api\controller;


use app\common\controller\ApiBase;
use app\common\model\VideoModel;
use think\View;

class VideoController extends ApiBase
{
    protected $limitAction = ['except' => 'add,indexall,through,unthrough,read'];
    protected $filterInputField = ['create_time','update_time','delete_time','state'];
    protected $addAfterResponseType = 'model';

    protected function initialize()
    {
        $this->model = new VideoModel();
        parent::initialize(); // TODO: Change the autogenerated stub
    }



    public function through(){
        $this->model
            ::useGlobalScope(false)
            ->where('id',input('id'))
            ->update(['state' => '通过']);
        $this->redirect('static/view/audit_success.html');
//        return success();
    }

    public function unthrough(){
        $this->model
            ::useGlobalScope(false)
            ->where('id',input('id'))->update(['state' => '未通过']);
        $this->redirect('static/view/audit_reject.html');
//        return success();
    }
}
