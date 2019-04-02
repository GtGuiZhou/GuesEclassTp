<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\common\model;


use think\model\concern\SoftDelete;

class MusicModel extends BaseModel
{
    use SoftDelete;
    protected $table = 'sys_music';
    protected $append = [
        'create_time',
        'update_time',
        'delete_time'
    ];
}