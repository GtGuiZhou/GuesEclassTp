<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\common\model;


class RepairModel extends BaseModel
{
    protected $table = 'sys_repair';
    protected $append = array (
  0 => 'create_time_text',
  1 => 'update_time_text',
);
}