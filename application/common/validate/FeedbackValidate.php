<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-5
 * Time: 下午2:13
 */

namespace app\common\validate;


use think\Validate;

class FeedbackValidate extends Validate
{
    protected $rule = array (
        'content|内容' => 'require|length:1,1000'
);
}