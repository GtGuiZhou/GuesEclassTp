<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 下午4:46
 */

namespace app\behavior;


use app\common\model\UserModel;
use think\facade\Session;

class DebugBind
{
    public function run(){
        if (config('app_debug')){
            $user = UserModel::find(1);
            Session::set(config('session.user'),$user);
        }
    }
}