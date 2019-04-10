<?php
// 请不要指定路由请求方法，以免发生更改请求方法来绕过路由验证。
\think\facade\Route::rule('api/humanwall/add','api/humanwall/add')
    ->validate('app\common\validate\HumanwallValidate')->middleware(\app\http\middleware\UserBind::class);