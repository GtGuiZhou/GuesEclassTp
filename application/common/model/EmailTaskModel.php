<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\common\model;


class EmailTaskModel extends BaseModel
{

    protected $table = 'sys_email_task';
    protected $json = ['to_email'];
    protected $append = array(
        0 => 'create_time_text',
    );

}