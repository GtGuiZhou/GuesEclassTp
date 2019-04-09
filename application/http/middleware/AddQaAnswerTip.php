<?php

namespace app\http\middleware;

use app\common\model\TipModel;

/**
 * 当用户在问答模块回答问题，就提醒用户有人来回答问题了
 * Class AddQaAnswerTip
 * @package app\http\middleware
 */
class AddQaAnswerTip
{
    public function handle($request, \Closure $next)
    {
        $res = $next($request);

        $tip = new TipModel();
        $tip->save([
            'title' => input('user_name').'回复了你',
            'content' => input('content'),
            'user_id' => input('answer_id')
        ]);

        $next($res);
    }
}
