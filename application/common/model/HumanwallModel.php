<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\common\model;


class HumanwallModel extends BaseModel
{
    protected $table = 'sys_human_wall';
    protected $append = array (
  0 => 'create_time_text',
  1 => 'update_time_text',
  2 => 'begin_time_text',
);

    // 定义全局的查询范围
    protected function base($query)
    {
        $query->order('id','desc');
    }

    // 只要append属性中有，就自动转换
    public function getBeginTimeTextAttr($value, $data)
    {
        $filed = 'begin_time';
        $value = $value ? $value : (isset($data[$filed]) ? $data[$filed] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }
}