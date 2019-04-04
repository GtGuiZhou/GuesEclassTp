<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 上午8:35
 */
$str = iconv('gb2312','utf-8',file_get_contents('test.html'));

$pattern = <<<p
/ <tr.*?>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                        <td>(.*?)<\/td>
                                    <\/tr>/
p;



preg_match_all($pattern,$str,$matches);
$res = [];

for ($i = 1; $i < count($matches[1]) ;++$i){
    for ($j =1; $j < count($matches) - 1; ++$j){
        $res[$i - 1][$j - 1] =  $matches[$j][$i];
    }
}

file_put_contents('res.json',json_encode($matches[1]));