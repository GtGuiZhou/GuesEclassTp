<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 上午8:35
 */
require_once __DIR__ . '/vendor/autoload.php';


use \phpspider\core\requests;


$page = requests::get('http://www.yiban.cn');



$p = <<<EOF
@<a.*?href="([^"]*?)"[^>]*?>\s+<span><b>(.+?)</b>(.+?)</span>\s+?</a>@s
EOF;

preg_match_all($p,$page,$matches);
$list = [];
for ($i =0;$i < count($matches[1]);$i++){
    $link = $matches[1][$i];
    list ($read_number,$like_number,$content) = parserArticle($link);
    array_push($list,[
            'school' => $matches[2][$i],
            'title' => $matches[3][$i],
            'link' => $matches[1][$i],
            'read_number' => $read_number,
            'like_number' => $like_number,
            'content'   => $content
        ]
    );
}

\think\Db::table('yb_top_article')->insertAll([$list]);
//var_dump($list);

function parserArticle($url){
    var_dump($url);
    preg_match("@article_id/(\d+)@",$url,$matches);
    $article_id = $matches[1];
    preg_match("@channel_id/(\d+)@",$url,$matches);
    $channel_id = $matches[1];
    preg_match("@puid/(\d+)@",$url,$matches);
    $puid = $matches[1];
    $url = 'http://www.yiban.cn/forum/reply/listAjax';

    $json = requests::post($url,[
        'article_id' => $article_id,
        'channel_id' => $channel_id,
        'puid' => $puid
    ]);


    $json = json_decode($json,true);
    $article = $json['data']['list']['article'];
    $read_number = $article['clicks'];
    $like_number = $article['upCount'];
    $content = $article['content'];
    $id = $article['id'];
    return [$id,$read_number,$like_number,$content];
//    preg_match('@阅读数： (\d+)@',$page,$matches);
}