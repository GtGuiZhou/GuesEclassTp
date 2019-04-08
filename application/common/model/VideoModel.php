<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\common\model;


class VideoModel extends BaseModel
{

    protected $table = 'sys_video';
    protected $json = ['tags'];

    protected $append = array(
        0 => 'create_time_text',
        1 => 'update_time_text',
    );


    // 定义全局的查询范围
    protected function base($query)
    {
        $query->where('state','通过');
    }
}