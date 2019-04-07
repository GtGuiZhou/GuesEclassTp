<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-5
 * Time: 下午2:13
 */

namespace app\common\validate;


use think\Validate;

class CommentValidate extends Validate
{
    protected $rule = array(
        'content|评论内容' => 'require|length:1,10000',
        'user_id|评论用户' => 'require|number',
        'call_id|回复评论' => 'number',
    );
}