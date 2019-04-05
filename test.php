<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 上午8:35
 */
$str = "<script language='javascript' defer>alert('密码错误！！');document.getElementById('txtUserName').focus();</script>";

$pattern = <<<p
/<script language='javascript' defer>alert\('(.*?)'\);/
p;

preg_match($pattern,$str,$mt);

var_export($mt);