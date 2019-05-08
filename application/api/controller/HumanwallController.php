<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-26
 * Time: 下午8:44
 */

namespace app\api\controller;


use app\common\controller\ApiBase;
use app\common\key\RedisKey;
use app\common\model\CommentModel;
use app\common\model\HumanwallModel;
use my\RedisPool;

class HumanwallController extends ApiBase
{
    protected $limitAction = ['except' => 'read,indexAll,index,commentList,add'];

    protected function initialize()
    {
        $this->model = new HumanwallModel();
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * 获取指定人人墙当前2秒的评论数据
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function commentList(){
        $id = input('id');
        $list = CommentModel::where('module','humanwall:'.$id)
            ->where('create_time',time() - 2)
            ->field('user_name,content')
            ->select();
        return success($list);
    }



}   