<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 上午8:35
 */
require_once __DIR__ . '/vendor/autoload.php';

use phpspider\core\phpspider;

//
//$html = file_get_contents('test.html');
//// 学校
//$data = selector::select($html, "//section[@class='yiban-news']//a//b//text()");
//var_dump($data);
//// 标题
//$data = selector::select($html, "//section[@class='yiban-news']//a//span/text()");
//var_dump($data);

$configs = array(
    'name' => '糗事百科',
    'domains' => array(
        'qiushibaike.com',
        'www.qiushibaike.com'
    ),
    'scan_urls' => array(
        'http://www.qiushibaike.com/'
    ),
    'content_url_regexes' => array(
        "http://www.qiushibaike.com/article/\d+"
    ),
    'list_url_regexes' => array(
        "http://www.qiushibaike.com/8hr/page/\d+\?s=\d+"
    ),
    'fields' => array(
        array(
            // 抽取内容页的文章内容
            'name' => "article_content",
            'selector' => "//*[@id='single-next-link']",
            'required' => true
        ),
        array(
            // 抽取内容页的文章作者
            'name' => "article_author",
            'selector' => "//div[contains(@class,'author')]//h2",
            'required' => true
        ),
    ),
);
$spider = new phpspider($configs);
$spider->start();