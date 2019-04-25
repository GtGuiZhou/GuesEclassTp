<?php
// 请不要指定路由请求方法，以免发生更改请求方法来绕过路由验证。
\think\facade\Route::rule('api/message/index','api/message/index')
    ->middleware(\app\http\middleware\UserBind::class);