<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 上午9:05
 */

namespace zf;


class ParserPage
{
    public function viewstate($page){
        $pattern = <<<p
    /<input type="hidden" name="__VIEWSTATE" value="(.*?)" \/>/
p;
        preg_match($pattern,$page,$matchs);

        if (count($matchs) != 2){
            throw new ZFException('解析viewstate失败');
        }

        return $matchs[1];
    }

    /**
     * 登陆后，解析登录状态，如果有js语句那就说明没登录成功
     * @param $page
     * @return bool
     */
    public function loginState($page){
        $pattern = <<<__
/<script language='javascript' defer>alert\('(.*?)'\);document.getElementById\('TextBox2'\).focus\(\);<\/script>/
__;
        preg_match($pattern,$page,$matchs);

        if (count($matchs) != 2){
            return true;
        }

        return $matchs[1];

    }

    /**
     * 将课表解析成数组
     * @param $page
     * @return array
     */
    public function timetable($page){
        $pattern = <<<p
/<td align="Center".*?>(.*?)<\/td>/
p;
        preg_match_all($pattern,$page,$matchs);

        $matchs = array_filter($matchs[1],function ($val){return mb_strlen($val) > 20;});

        return $matchs;
    }

    /**
     * 学弟or学妹，当你看到下面的代码时,是不是觉得自己年纪轻轻就快要不行了，不要慌！一定要沉住气，这只是提取了表格的一行的正则表达式而已n(*≧▽≦*)n～
     * 解析成绩单页面
     * @param $page
     * @return array
     */
    public function scoreReport($page){
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

        preg_match_all($pattern,$page,$matches);
        $res = [];
        // 逆转数组
        for ($i = 1; $i < count($matches[1]) ;++$i){
            for ($j =1; $j < count($matches) - 1; ++$j){
                $res[$i - 1][$j - 1] =  $matches[$j][$i];
            }
        }

        return $res;
    }
}