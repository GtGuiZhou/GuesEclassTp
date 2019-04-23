<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 上午8:41
 */
namespace zf;
use GuzzleHttp\Client;
use think\facade\Config;
use think\facade\Session;

class Main
{
    /**
     * @var WebPage
     */
    private $page;

    /**
     * @var ParserPage
     */
    private $parser;

    /**
     * @var HttpClient
     */
    private $client;

    public function __construct()
    {

        $this->page = new WebPage();
        $this->parser = new ParserPage();
        $this->client = HttpClient::instance();
    }

    /**
     * 登录失败抛出异常
     * @param $act
     * @param $pwd
     * @param $code
     * @return bool
     * @throws ZFException
     */
    public function login($act,$pwd,$code){
        $loginPage = $this->page->login();
        $viewstate = $this->parser->viewstate($loginPage);
        $data = [
            '__VIEWSTATE' =>  $viewstate,
            'txtUserName' => $act,
            'Textbox1',
            'TextBox2'=> iconv('utf-8', 'gb2312', $pwd),
            'txtSecretCode' => $code,
            'RadioButtonList1' => iconv('utf-8', 'gb2312', '学生'),
            'Button1' => iconv('utf-8', 'gb2312', '登录'),
            'lbLanguage',
            'hidPdrs',
            'hidsc',
        ];
        $cookie = Session::get('zf:cookie');
        if (!$cookie)
            throw new ZFException('会话不存在，无法获取登录页面');
        $headers = [
            'Cookie' => $cookie
        ];
        $page = $this->client->post('default2.aspx',['form_params'=>$data,'headers' => $headers])->getBody();
        $page = iconv( 'gb2312','utf-8', $page);
        $res = $this->parser->loginState($page) ;
        if($res !== true){
            throw new ZFException($res);
        }
    }

    /**
     * 获取验证码图片，返回gif图片流
     * @return \Psr\Http\Message\StreamInterface
     */
    public function checkCode(){
        $res = $this->client->get('CheckCode.aspx');
        $cookie = $res->getHeaders()['Set-Cookie'][0];
        Session::set('zf:cookie',$cookie);
        return $res->getBody();
    }

    /**
     * 获取课表数据
     * @param $act
     * @return array
     * @throws ZFException
     */
    public function timetable($act){
        $page =  $this->page->timetable($act);
        $page = iconv('gbk','utf-8',$page);
        return $this->parser->timetable($page);
    }



    /**
     * 总成绩
     * @param $act
     * @return mixed
     * @throws ZFException
     */
    public function scoreReport($act){
        $page = $this->page->indexScore($act);
        $viewstate = $this->parser->viewstate($page);
        $page =  $this->page->scoreReport($act,$viewstate);
        $page = iconv('gbk','utf-8',$page);
        return $this->parser->scoreReport($page);
    }



}