<?php

\think\facade\Route::post('api/video/add','api/video/add')
    ->validate('app\common\validate\VideoValidate')
    ->middleware(\app\http\middleware\UserBind::class)
    ->middleware(\app\http\middleware\SendVideoAuditEmail::class);

\think\facade\Route::get('api/video/through','api/video/through')
    ->middleware(\app\http\middleware\AuditCodeCheck::class);

\think\facade\Route::get('api/video/through','api/video/unthrough')
    ->middleware(\app\http\middleware\AuditCodeCheck::class);