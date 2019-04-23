<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-11
 * Time: 下午12:44
 */

namespace app\common\exception;


use app\common\key\RedisManager;
use Exception;
use function GuzzleHttp\Psr7\uri_for;
use think\cache\driver\Redis;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle as HandleBase;
use think\exception\HttpException;
use think\exception\ValidateException;
use think\facade\View;
use zf\ZFException;

class Handle extends HandleBase
{
    private $modelNotFoundMsg = [
        'app\common\model\FileSysModel' => '该文件不存在',
        'app\common\model\VideoMOdel' => '视频不存在，或暂时还未通过审核'
    ];

    public function render(Exception $e)
    {

        RedisManager::incExceptionNumber();

        if (config('app_debug'))
            return parent::render($e);// 调试时，错误交给系统处理

        // 参数验证错误
        if ($e instanceof ValidateException) {
            return warning($e->getMessage());
        }

        // 请求数据不存在
        if ($e instanceof ModelNotFoundException) {
            $modelMsg = $e->getModel() . '不存在';
            isset($this->modelNotFoundMsg[$e->getModel()]) && $modelMsg = $this->modelNotFoundMsg[$e->getModel()];
            return warning($modelMsg);
        }

        // 用户操作不规范产生的异常，例如密码输入错误
        if ($e instanceof HttpException) {
            return error($e->getMessage());
        }

        if ($e instanceof UnLoginException) {
            return result(null, '未登录，不允许操作', 401);
        }

        if ($e instanceof ZFException) {
            return warning($e->getMessage());
        }


        return error($e->getMessage());

    }
}