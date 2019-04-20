<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 下午4:46
 */

namespace app\behavior;


/**
 * 维护
 * Class Wh
 * @package app\behavior
 */
class Wh
{
    public function run(){
         $url = request()->domain().'/wh.html';
        header("Location: $url");
         exit();
    }
}