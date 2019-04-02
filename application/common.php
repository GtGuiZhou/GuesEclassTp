<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件



function success($data = null, $msg = 'success') {
    return result($data,$msg, 0);
}

function error($msg = 'error',$data = null) {
    return result($data,$msg,500);
}

function warning($msg = 'warning', $data = null) {
    return result($data, $msg,400);
}

function result($data,$msg,$code){
    return json(['data' => $data, 'code' => $code, 'msg' => $msg]);
}

/**
 * 注册crud路由
 * @param $rule string
 */
function crud_router_set($rule){
    think\facade\Route::get("$rule/read/:id","$rule/read");
    think\facade\Route::get("$rule/index","$rule/index");
    think\facade\Route::post("$rule/add","$rule/add");
    think\facade\Route::delete("$rule/delete/:id","$rule/delete");
    think\facade\Route::delete("$rule/deleteReal/:id","$rule/deleteReal");
    think\facade\Route::put("$rule/recover/:id","$rule/recover");
    think\facade\Route::put("$rule/update/:id","$rule/update");
}

/**
 * 注册软删除路由
 * @param $rule  string
 */
function soft_delete_router_set($rule){
    think\facade\Route::delete("$rule/realDelete/:id","$rule/realDelete");
    think\facade\Route::get("$rule/indexOfTrashed","$rule/indexOfTrashed");
    think\facade\Route::get("$rule/recover","$rule/recover");
}

/**
 * 注册分组路由
 * @param $rule  string
 */
function group_router_set($rule){
    think\facade\Route::get("$rule/getGroupTree","$rule/getGroupTree");
    think\facade\Route::put("$rule/updateGroupTree","$rule/updateGroupTree");
}

/**
 * 获取当前会话用户，不存在抛异常
 */
function user(){
    if (config('app_debug')){
        $user = \app\common\model\UserModel::get(1);
        \think\facade\Session::set('user',$user);
    }

    $user = \think\facade\Session::get('user');


    if (!$user){
        abort(403,'登录已过期');
    }
    return $user;
}

/**
 * 用户是否登录
 * @return bool
 */
function user_is_login(){
    return \think\facade\Session::get('user')?true:false;
}

function throw_validate_exception($err, $code = 0){
    throw  new \think\exception\ValidateException($err,$code);
}


