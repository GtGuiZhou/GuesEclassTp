<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-5
 * Time: 下午2:13
 */

namespace app\common\validate;


use think\Validate;

class RepairValidate extends Validate
{
    protected $rule =   [
        'user_id|用户id'  => 'require|number',
        'content|内容'  => 'require|length:1,1000',
        'address|地址'  => 'require|length:1,100',
        'phone|手机'    => 'require|mobile'
    ];
}