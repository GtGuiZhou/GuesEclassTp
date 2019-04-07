<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-26
 * Time: 下午8:41
 */

namespace app\common\controller;


use app\common\exception\UnLoginException;
use think\facade\Session;

class ApiBase extends CrudBase
{
    public function user(){
        $user = Session::get(config('session.user'));
        if (!$user){
            throw new UnLoginException();
        }

        return $user;
    }
}