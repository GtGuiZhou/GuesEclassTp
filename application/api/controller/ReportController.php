<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-26
 * Time: 下午8:44
 */

namespace app\api\controller;


use app\common\controller\ApiBase;
use app\common\key\RedisManager;
use app\common\model\RepairModel;
use app\common\model\ToparticleModel;
use think\facade\View;

class ReportController extends ApiBase
{
    protected $limitAction = ['except' => 'dayIndex'];

    public function dayIndex(){
        $repair = RepairModel::where('state','未处理')->select();
        $topArticle = ToparticleModel::whereTime('update_time','today')->select();
        $view_number = RedisManager::getViewNumber7Days();
        $exception_number = RedisManager::getExceptionNumber7Days();
        $date_range = array_keys($view_number);
        return $this->fetch('report/day',[
            'repair_list' => $repair,
            'top_article_list' => $topArticle,
            'view_number' => $view_number,
            'exception_number' => $exception_number,
            'date_range' => $date_range
        ]);
    }

}   