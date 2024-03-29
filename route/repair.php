<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


\think\facade\Route::rule('api/repair/add','api/repair/add')
    ->validate('app\common\validate\RepairValidate')
    ->middleware(\app\http\middleware\UserBind::class);

\think\facade\Route::rule('api/repair/handled','api/repair/handled')
    ->middleware(\app\http\middleware\UserBind::class);

\think\facade\Route::rule('api/repair/close','api/repair/close')
    ->middleware(\app\http\middleware\UserBind::class);

\think\facade\Route::rule('api/repair/cnt','api/repair/cnt')
    ->middleware(\app\http\middleware\UserBind::class);