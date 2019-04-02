<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-21
 * Time: 下午4:19
 */

use think\facade\Env;

return [
    'AppID'        => ENV::get('YB_AppID'),
    'AppSecret'        => ENV::get('YB_AppSecret'),
    'CallBack'        => "http://f.yiban.cn/iapp321470"
];