<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\common\model;


class LovewallModel extends BaseModel
{
    protected $table = 'sys_love_wall';
    protected $append = array(
        'create_time_text',
        'update_time_text',
        'comment_number'
    );

    public function getCommentNumberAttr($value,$data){
        return CommentModel::where('module','lovewall:'.$data['id'])
            ->cache(60) // 缓存一分钟
            ->count();
    }

    // 定义全局的查询范围
    protected function base($query)
    {


        $query->order('id','desc');
    }
}