<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-6
 * Time: 下午6:20
 */

namespace app\api\controller;


use app\common\controller\FilesysBase;

class FilesysController extends FilesysBase
{
    protected $limitAction = ['except' => 'upload'];
}