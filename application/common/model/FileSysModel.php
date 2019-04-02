<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-7
 * Time: 下午12:16
 */

namespace app\common\model;


use think\Model;


class FileSysModel extends Model
{
    protected $table = 'sys_file';
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;
    protected $hidden = ['local_path'];


}