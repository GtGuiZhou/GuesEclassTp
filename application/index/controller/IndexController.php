<?php
namespace app\index\controller;


use think\facade\Log;
use think\facade\Session;
use yb\YBOpenApi;

class IndexController
{
    public function index()
    {

        //初始化
        $api = YBOpenApi::getInstance()->init(config('yb.AppID'), config('yb.AppSecret'), config('yb.CallBack'));
        $iapp  = $api->getIApp();

        //轻应用获取access_token，未授权则跳转至授权页面
        $info = $iapp->perform();

        Log::info($info);

        $token = $info['visit_oauth']['access_token'];//轻应用获取的token

        Session::set('yb:token',$token);
        return $token;
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function index2(){
        return 'index2';
    }
}
