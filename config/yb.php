<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-21
 * Time: 下午4:19
 */

use think\facade\Env;

return [
    'AppID'        => ENV::get('YB_AppID'),
    'AppSecret'        => ENV::get('YB_AppSecret'),
    'CallBack'        =>  ENV::get('YB_CallBack'),

    // 爬虫配置
    'index_worm' => [
        'name' => '易班爬虫',
        'domains' => array(
            'www.yiban.cn',
        ),
        'scan_urls' => array(
            'http://www.yiban.cn/'
        ),
        'content_url_regexes' => array(
            "http://www.qiushibaike.com/article/\d+"
        ),
        // 由于只需要爬取头条，一层就够了
        'max_depth' => 1,

        'list_url_regexes' => array(
            "http://www.yiban.cn"
        ),
        'log_show' => true,
        'fields' => array(
            array(
                // 抽取内容页的文章内容
                'name' => "title",
                'selector' => "//*[@id='single-next-link']",
                'required' => true
            ),
            array(
                // 抽取内容页的文章作者
                'name' => "school",
                'selector' => "//div[contains(@class,'author')]//h2",
                'required' => true
            ),
        )
    ]

];