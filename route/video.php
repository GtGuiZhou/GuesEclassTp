<?php

\think\facade\Route::rule('api/video/add','api/video/add')
    ->validate('app\common\validate\VideoValidate')
    ->middleware(\app\http\middleware\UserBind::class)
    ->middleware(\app\http\middleware\AddIndexList::class,'video')
    ->middleware(\app\http\middleware\BindTag::class,[config('redis.key_tag_video_list'),config('redis.key_tag_video_relation')])
    ->middleware(\app\http\middleware\SendVideoAuditEmail::class);

\think\facade\Route::rule('api/video/through','api/video/through')
    ->middleware(\app\http\middleware\AuditCodeCheck::class);

\think\facade\Route::rule('api/video/through','api/video/unthrough')
    ->middleware(\app\http\middleware\AuditCodeCheck::class);