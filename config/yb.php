<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-21
 * Time: 下午4:19
 */

use think\facade\Env;

return [
    'AppID'        => ENV::get('AppID'),
    'AppSecret'        => ENV::get('AppSecret'),
    'CallBack'        => ENV::get('CallBack'),
];