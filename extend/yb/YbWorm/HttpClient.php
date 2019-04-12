<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 上午10:06
 */

namespace zf;


namespace yb\YbWorm;

use think\facade\Config;
use zf\ZFException;

class HttpClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    private static $client;

    /**
     * @return \GuzzleHttp\Client
     */
    public static function instance(){

        $host = Config::get('yb.host',false);
        $timeout = Config::get('yb.timeout',5);

        if (!self::$client)
        {
            self::$client = new \GuzzleHttp\Client([
                // Base URI is used with relative requests
                'base_uri' => $host,
                // You can set any number of default request options.
                'timeout'  => $timeout,
                // 自动维护回话
                'cookies' => true,
                // 禁止重定向
                'allow_redirects' => false
            ]);

        }

        return self::$client;
    }


}