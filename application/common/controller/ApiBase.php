<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-26
 * Time: 下午8:41
 */

namespace app\common\controller;


use app\common\exception\UnLoginException;
use app\common\key\SessionKey;
use think\facade\Session;

class ApiBase extends CrudBase
{
    public function user(){
        $user = Session::get(SessionKey::$User);
        if (!$user){
            throw new UnLoginException();
        }

        return $user;
    }
}