<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-5
 * Time: 下午2:13
 */

namespace app\common\validate;


use think\Validate;

class LovewallValidate extends Validate
{
    protected $rule = array (
  'content|内容' => 'require|length:1,10000',
  'image_url|表白图片' => 'require|length:1,255|url',
  'user_id|当前用户' => 'require|number',
  'from_email|当前用户邮件' => 'length:1,255|email',
  'to_email|表白用户的邮件' => 'length:1,255|email',
  'to_name|他/她的名字' => 'length:1,255',
  'form_name|你的名字' => 'length:1,255',
  'delete_time|delete_time' => 'number',
);
}