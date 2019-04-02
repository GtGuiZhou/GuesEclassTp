<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-8
 * Time: 上午12:34
 */

namespace app\common\lib;


use think\Model;

/**
 * 为控制器拓展点赞功能
 * Class StarControllerTrait
 * @package app\common\lib
 */
trait StarControllerTrait
{
    /**
     * 当前控制器对应的模型，需要在手动initialize中初始化
     * @var $model Model
     */
//    protected $model = null;

    /**
     * 点赞数量字段名称
     * @var string $starNumField
     */
    protected $starNumField = 'star_num';

    /**
     * 对指定id模型的点赞数量字段自增1
     * @param $id
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function star($id){
        $this->model
            ->where($this->model->getPk(),$id)
            ->inc($this->starNumField)
            ->update();
    }

    public function isStar($id){
        
    }
}