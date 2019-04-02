<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-6
 * Time: 下午12:46
 */

namespace app\common\model;


class SysConfigModel extends BaseModel
{
    protected $table = 'sys_config';

    // 追加属性
    protected $append = [
        'create_time_text',
        'update_time_text'
    ];


    public function setValueAttr($value){
        if (is_array($value) || is_object($value)){
            return json_encode($value);
        } else {
            return $value;
        }
    }

    public function getValueAttr($value,$data){
        $decode = json_decode($value,true);
        if ($decode)
            return $decode;
        else
            if($data['type'] ==  'json')
                return [];
            else
                return $value;
    }
}