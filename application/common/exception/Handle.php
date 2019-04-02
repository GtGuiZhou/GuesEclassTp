<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-11
 * Time: 下午12:44
 */

namespace app\common\exception;


use Exception;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle as HandleBase;
use think\exception\HttpException;
use think\exception\ValidateException;

class Handle extends HandleBase
{
    private $modelNotFoundMsg = [
        'app\common\model\FileSysModel' => '该文件不存在'
    ];

    public function render(Exception $e)
    {
        // 参数验证错误
        if ($e instanceof ValidateException) {
            return warning($e->getMessage());
        }

        // 请求数据不存在
        if ($e instanceof ModelNotFoundException) {
            $modelMsg = $e->getModel().'不存在';
            isset($this->modelNotFoundMsg[$e->getModel()]) && $modelMsg = $this->modelNotFoundMsg[$e->getModel()];
            return warning($modelMsg);
        }

        // 用户操作不规范产生的异常，例如密码输入错误
        if ($e instanceof HttpException){
            return error($e->getMessage());
        }

        // 其他错误交给系统处理
        return parent::render($e);
    }
}