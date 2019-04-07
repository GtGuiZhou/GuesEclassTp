<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-4-3
 * Time: 上午8:35
 */
echo strtolower(preg_replace('/(?<=[a-zA-Z])([A-Z])/', '_$1', 'FooBarNav'));
