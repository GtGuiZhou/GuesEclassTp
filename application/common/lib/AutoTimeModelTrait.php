<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-16
 * Time: 上午8:51
 */

namespace app\common\lib;


trait AutoTimeModelTrait
{
    // 追加属性，在使用该trait的模型中写，在这写会与think/model类冲突
//    protected $append = [
//        'create_time_text',
//        'update_time_text'
//    ];

    public function setCreateTimeAttr($value)
    {
        // autoWriteTimestamp在model类的TimeStamp里
        return $this->autoWriteTimestamp('create_time');
    }

    public function setUpdateTimeAttr($value)
    {
        // autoWriteTimestamp在model类的TimeStamp里
        return $this->autoWriteTimestamp('update_time');
    }

    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;

    }

    public function getUpdateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['update_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }
}