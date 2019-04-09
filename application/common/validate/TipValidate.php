<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-5
 * Time: 下午2:13
 */

namespace app\common\validate;


use think\Validate;

class TipValidate extends Validate
{
    protected $rule = array (
  'title|标题' => 'require|length:1,50',
  'content|提示内容' => 'require|length:1,1000',
  'redirect|跳转位置' => 'length:1,255',
  'user_id|提示用户' => 'require|number',
  'state|查看状态' => 'length:1,3',
);
}