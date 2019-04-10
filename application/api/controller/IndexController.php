<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-7
 * Time: 下午8:35
 */

namespace app\api\controller;


use app\common\model\HumanwallModel;
use app\common\model\LovewallModel;
use app\common\model\VideoModel;

class IndexController
{
    public function indexall(){
        $appendShowType = function ($type){
            return function ($item) use ($type){
                $item['show_type'] = $type;
                return $item;
            } ;
        };
        $videos = array_map($appendShowType('video'),VideoModel::all()->toArray());
        $loveWall = array_map($appendShowType('lovewall'),LovewallModel::all()->toArray());
        $humanWall = array_map($appendShowType('humanwall'),HumanwallModel::all()->toArray());
        $list = array_merge($videos,$loveWall,$humanWall);
        usort($list,function ($item1,$item2){
            return $item1['create_time'] > $item2['create_time'];
        });
        return success($list);
    }
}