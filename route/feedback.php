<?php
// 请不要指定路由请求方法，以免发生更改请求方法来绕过路由验证。
\think\facade\Route::rule('api/feedback/add','api/feedback/add')
    ->validate('app\common\validate\FeedbackValidate')
    ->middleware(\app\http\middleware\UserBind::class);