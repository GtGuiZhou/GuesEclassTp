<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 上午10:06
 */

namespace zf;


use think\facade\Config;

class HttpClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    private static $client;

    /**
     * @return \GuzzleHttp\Client
     * @throws ZFException
     */
    public static function instance(){

        $host = Config::get('zf.host',false);

        if (!$host)
            throw new ZFException('未在配置文件中设定正方教务系统的host地址');
        $timeout = Config::get('zf.timeout',5);

        if (!self::$client)
        {
            self::$client = new \GuzzleHttp\Client([
                // Base URI is used with relative requests
                'base_uri' => $host,
                // You can set any number of default request options.
                'timeout'  => $timeout,
                // 自动维护回话
                'cookies' => true,
                // 禁止重定向，教务系统内部回自动重定向
                'allow_redirects' => false
            ]);

        }

        return self::$client;
    }


}