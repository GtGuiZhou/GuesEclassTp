<?php

namespace app\command;

use app\common\model\EmailTaskModel;
use app\common\task\SendEmail;
use my\Email;
use my\RedisPool;
use phpspider\core\requests;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Exception;
use think\facade\View;

class MySpider extends Command
{

    protected function html() {
        return '
    <table style="width: 600px" border="1" cellspacing="0" cellpadding="0">
    {foreach $list as $v } 
        <tr >
            <td style="padding: 10px">{$v.title}</td>
            <td style="padding: 10px">
                <a href="http://tieba.baidu.com{$v.url}">跳转过去</a>
            </td>
        </tr>
        {/foreach}
    </table>
    ';
    }


    protected function configure()
    {
        // 指令配置
        $this->setName('app\command\myspider');
        // 设置参数
        
    }

    protected function execute(Input $input, Output $output)
    {

        $redis = RedisPool::instance();
        $kws = ['php','html','vue','thinkphp','laravel','javascript'];
        $res = '';
        foreach ($kws as $kw) {
            try {
                $res = $res . requests::get("http://tieba.baidu.com/f?kw=$kw&fr=ala0&tpl=5&traceid=");
                sleep(1);
            } catch (Exception $e) {
                continue;
            }
        }

        $pattern = '@<a rel="noreferrer" href="(.*?)" title=".*?" target="_blank" class=".*?">(.*?)<\/a>@';
        preg_match_all($pattern,$res,$matches);

        $list = [];

        if (count($matches) >= 3){
            foreach ($matches[2] as $index => $item){
                $key = 'myspider:tieba:php';
                if (!$redis->sIsMember($key,$item)){
                    $redis->sAdd($key,$item);
                    // 检测标题是否含有想要的信息
                    $p = ['求','接单','找人','急','有偿','商量','钱','元','人民币','软妹币','RMB','rmb','money'];
                    if ($this->check($item,$p))
                        array_push($list,['title' => $matches[2][$index],'url' => $matches[1][$index]]);
                }
            }
        }

        // 发送邮件
    	if (count($list) > 0){
    	    var_dump($list);
    	    echo '发送邮件';
            $email = new Email('php贴吧监听',View::display($this->html(),['list'=>$list]),["735311619@qq.com"]);
    	    EmailTaskModel::create($email->getConfig());
        }
    }


    public function check($str,$arr){
        foreach ($arr as $item){
            if (strstr($str,$item))
                return true;
        }

        return false;
    }

    /**
     * 回复帖子（pc有验证码保护,手机客户端没有）
     */
    public function reply(){
        requests::post();
    }
}
