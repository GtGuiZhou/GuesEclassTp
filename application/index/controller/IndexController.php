<?php
namespace app\index\controller;


use app\common\model\UserModel;
use think\Controller;
use think\facade\Log;
use think\facade\Session;
use yb\YBOpenApi;
use yb\YBUnPermissiveException;

class IndexController extends Controller
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
//        var_export($info['visit_user']);
//        echo "<br/>";
        // 获取用户信息
        $user = UserModel::where('userid' , $info['visit_user']['userid'])->find();
        if (!$user){
            $user = UserModel::create($info['visit_user']);
            $user = $user->findOrFail($user['id']); // 防止字段缺失
        }

        Session::set(config('session.key_user'),$user);

        return $this->redirect('/static/confront');
    }
}
