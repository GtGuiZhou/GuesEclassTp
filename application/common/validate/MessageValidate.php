<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-5
 * Time: 下午2:13
 */

namespace app\common\validate;


use think\Validate;

class MessageValidate extends Validate
{
    protected $rule = array (
  'content|content' => 'require|length:1,1000',
  'user_id|user_id' => 'require|number',
);
}