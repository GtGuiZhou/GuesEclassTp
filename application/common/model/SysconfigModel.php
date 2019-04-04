<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\common\model;


class SysconfigModel extends BaseModel
{
    protected $table = 'sys_config';
    protected $append = array(
        0 => 'create_time_text',
        1 => 'update_time_text'
    );

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