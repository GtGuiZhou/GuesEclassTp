<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-26
 * Time: 下午8:44
 */

namespace app\api\controller;


use app\common\controller\ApiBase;
use app\common\model\RepairModel;

class RepairController extends ApiBase
{
    protected $limitAction = ['except' => 'add,handled,close,cnt'];
    protected $filterInputField = ['create_time','update_time','delete_time','state'];


    protected function initialize()
    {
        $this->model = new RepairModel();
        parent::initialize(); // TODO: Change the autogenerated stub
    }


    /**
     * 将维修工单设定为已处理
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function handled(){
        $this->model
            ->where('user_id',input('user_id'))
            ->where('id',input('id'))
            ->update(['state' => '已处理']);
        return success();
    }

    /**
     * 将维修工单设定为已关闭
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function close(){
        $this->model
            ->where('user_id',input('user_id'))
            ->where('id',input('id'))
            ->update(['state' => '已关闭']);
        return success();
    }

    /**
     * 增加催促次数
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function cnt(){
        $this->model
            ->where('user_id',input('user_id'))
            ->where('id',input('id'))
            ->setInc('cnt');

        return success();
    }

}   