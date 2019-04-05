<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-5
 * Time: 下午2:13
 */

namespace app\common\validate;


use think\Validate;

class VideoValidate extends Validate
{
    protected $rule = array (
  'url|视频' => 'require|length:1,255|url',
  'title|标题' => 'require|length:1,255',
  'desc_text|描述' => 'require|length:1,255',
  'user_id|user_id' => 'require|number',
  'cover_url|封面' => 'require|length:1,255|url',
);
}