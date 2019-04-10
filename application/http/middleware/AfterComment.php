<?php

namespace app\http\middleware;

use app\http\middleware\comment\HumanWall;
use app\http\middleware\comment\Observer;

class AfterComment
{
    public function handle($request, \Closure $next)
    {
        $res = $next($request);
        $observer = new Observer();
        $observer->addObserver(new HumanWall());

        $observer->update();
        return $res;
    }
}
