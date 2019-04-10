<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-9
 * Time: 下午7:36
 */

namespace app\http\middleware\comment;


class Observer
{
    private static $observerList = [];

    public function addObserver(ObserverInterface $observer){
        array_push(self::$observerList,$observer);
    }

    public function update(){
        foreach (self::$observerList as $observer){
            $observer->handle();
        }
    }

}