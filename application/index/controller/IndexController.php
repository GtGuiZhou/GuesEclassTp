<?php
namespace app\index\controller;


use think\facade\Log;
use think\facade\Session;
use yb\YBOpenApi;
use yb\YBUnPermissiveException;

class IndexController
{
    public function index()
    {

        //初始化
        $api = YBOpenApi::getInstance()->init(config('yb.AppID'), config('yb.AppSecret'), config('yb.CallBack'));
        $iapp  = $api->getIApp();

        //轻应用获取access_token，未授权则跳转至授权页面
        try{
            $info = $iapp->perform();
        } catch (YBUnPermissiveException $e){
            return redirect($iapp->forwardurl());
        }

        $token = $info['visit_oauth']['access_token'];//轻应用获取的token

        Session::set('yb:token',$token);

        var_dump($info);
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
