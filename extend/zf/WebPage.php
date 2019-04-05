<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 上午8:43
 */

namespace zf;

use think\facade\Config;
use think\facade\Session;

class WebPage
{
    /**
     * @var HttpClient;
     */
    private $client;

    public function __construct()
    {
        $this->client = HttpClient::instance();
    }

    public function login()
    {
        $cookie = Session::get('zf:cookie');
        if (!$cookie)
            throw new ZFException('会话不存在，无法获取登录页面');
        $headers = [
            'Cookie' => $cookie
        ];
        return $this->client->get("default2.aspx", ['headers' => $headers])->getBody();
    }

    public function timetable($account)
    {
        $cookie = Session::get('zf:cookie');
        $host = Config::get('zf.host', false);
        if (!$cookie)
            throw new ZFException('会话不存在，无法获取课表');
        if (!$host)
            throw new ZFException('未在配置文件中设定正方教务系统的host地址');
        $host = rtrim($host, '/');
        $headers = [
            'Cookie' => $cookie,
            'Referer' => "$host/xs_main.aspx?xh=$account"
        ];
        return $this->client->get("xskbcx.aspx?xh=$account&gnmkdm=N121603", ['headers' => $headers])->getBody();
    }


    /**
     * 预览成绩页面，用于提取viewstate
     */
    public function indexScore($account)
    {
        $cookie = Session::get('zf:cookie');
        $host = Config::get('zf.host', false);
        if (!$cookie)
            throw new ZFException('会话不存在，无法获取课表预览页');
        if (!$host)
            throw new ZFException('未在配置文件中设定正方教务系统的host地址');
        $host = rtrim($host, '/');
        $headers = [
            'Cookie' => $cookie,
            'Referer' => "$host/xs_main.aspx?xh=$account"
        ];
        return $this->client->get("xscjcx.aspx?xh=$account&gnmkdm=N121603", ['headers' => $headers])->getBody();
    }

    /**
     * 总成绩页面
     * @param $account
     * @param $viewstate
     * @return \Psr\Http\Message\StreamInterface
     * @throws ZFException
     */
    public function scoreReport($account, $viewstate)
    {
        $cookie = Session::get('zf:cookie');
        $host = Config::get('zf.host', false);
        if (!$cookie)
            throw new ZFException('会话不存在，无法获取课表');
        if (!$host)
            throw new ZFException('未在配置文件中设定正方教务系统的host地址');
        $host = rtrim($host, '/');
        $headers = [
            'Cookie' => $cookie,
            'Referer' => "$host/xscjcx.aspx?xh=$account&gnmkdm=N121605",
            'Origin' => $host
        ];
        $data = [
            '__EVENTTARGET' => '',
            '__EVENTARGUMENT' => '',
            '__VIEWSTATE' => $viewstate,
            'hidLanguage' => '',
            'ddlXN' => '',
            'ddlXQ' => '',
            'ddl_kcxz' => '',
            'btn_zcj' => iconv('utf-8', 'gb2312', '历年成绩')
        ];
        $url = "$host/xscjcx.aspx?xh=$account&gnmkdm=N121605";
        return $this->client->post($url,
            ['form_params'=>$data,'headers' => $headers])
            ->getBody();
    }

}