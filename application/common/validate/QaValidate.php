<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-5
 * Time: 下午2:13
 */

namespace app\common\validate;


use think\Validate;

class QaValidate extends Validate
{
    protected $rule = array (
  'content|问题内容' => 'require|length:1,255',
  'user_id|user_id' => 'require|number',
);
}