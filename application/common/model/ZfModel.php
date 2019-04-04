<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\common\model;


use think\model\concern\SoftDelete;

class ZfModel extends BaseModel
{
    use SoftDelete;
    protected $table = 'sys_zf';
    protected $append = array(
        0 => 'create_time_text',
        1 => 'update_time_text',
        2 => 'delete_time_text',
    );
}