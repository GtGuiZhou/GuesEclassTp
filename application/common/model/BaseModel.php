<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-19
 * Time: 上午9:56
 */

namespace app\common\model;


use think\Model;

class BaseModel extends Model
{

    public $autoWriteTimestamp = true;
    public $dateFormat = false;


    // 只要append属性中有，就自动转换
    public function getCreateTimeTextAttr($value, $data)
    {
        $field = 'create_time';
        $value = $value ? $value : (isset($data[$field]) ? $data[$field] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    // 只要append属性中有，就自动转换
    public function getUpdateTimeTextAttr($value, $data)
    {
        $filed = 'update_time';
        $value = $value ? $value : (isset($data[$filed]) ? $data[$filed] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    // 只要append属性中有，就自动转换
    public function getDeleteTimeTextAttr($value, $data)
    {
        $filed = 'delete_time';
        $value = $value ? $value : (isset($data[$filed]) ? $data[$filed] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }
}