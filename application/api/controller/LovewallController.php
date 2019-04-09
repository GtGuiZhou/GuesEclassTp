<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-26
 * Time: 下午8:44
 */

namespace app\api\controller;


use app\common\controller\ApiBase;
use app\common\model\LovewallModel;
use my\Email;

class LovewallController extends ApiBase
{
    protected $limitAction = ['except' => 'readTemplate,indexAll,index,add,read,indexOfTemplate'];
    protected $addAfterResponseType = 'model';
    protected function initialize()
    {
        $this->model = new LovewallModel();
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function indexOfTemplate(){
        $templates = [
            'template1',
            'template2',
            'template3'
            ];
        $res = [];
        foreach ($templates as $template){
            array_push($res,$this->fetch($template,input()));
        }
        return  success($res);
    }

    public function add()
    {
        $res = parent::add(); // TODO: Change the autogenerated stub
        $res = $res->getData();
        $res['data']['qr_code'] = url('/api/lovewall/readTemplate/id/'.$res['data']['id'],'',false,true);

        $from = input('from_name');
        $template = input('template');
        $to_email = input('to_email');
        $content = input('content');

        $from = $from?$from:'某个匿名';

        if ($to_email){
            $email = new Email();
            $email->setTitle("来至".$from."同学的一封信")
                ->setContent($template?$template:$content)
                ->setTo($to_email)->send();
        }

        // 删除template，减少传输数据
        unset($res['template']);
        return json($res);
    }

    /**
     * 读指定信件的模板
     */
    public function readTemplate(){
        $model = $this->model->findOrFail(input('id'));
        return $model['template'];
    }
}   