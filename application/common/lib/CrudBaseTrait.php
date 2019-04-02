<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-7
 * Time: 下午10:49
 */

namespace app\common\lib;


use think\Model;

trait CrudBaseTrait
{
    /**
     * 当前控制器对应的模型，需要在手动initialize中初始化
     * @var $model Model
     */
//    protected $model = null;

    /**
     * 执行add方法后的返回值类型,可选model或者null或者pk
     * 默认返回pk(主键)
     * model即为刚创建的model
     * @var string
     */
    protected $addAfterResponseType = 'pk';

    public function index()
    {
        $order = input('order', 'desc');
        $index = input('index', 1);
        $size = input('size', 10);
        $list = $this->model
            ->order($this->model->getPk(), $order)
            ->page($index, $size)
            ->select();
        $total = $this->model
            ->count($this->model->getPk());
        return success(['list' => $list,'page' => [
            'index' => (int)$index,'size' => (int)$size,'total' =>  (int)$total
        ]]);
    }

    public function read()
    {
        $id = input('id');
        return success($this->model->where($this->model->getPk(),$id)->findOrFail());
    }

    public function add()
    {
        $this->model->allowField(true)->save(input());
        switch ($this->addAfterResponseType){
            case 'model':
                return success($this->model);
            case 'pk':
                $pk = $this->model->getpk();
                return success([$pk => $this->model->$pk]);
            default:
                return success();
        }
    }

    public function delete()
    {
        /**
         * 这么写是为了能够在模型开启软删除的时候，能够正常使用软删除
         */
        $model = $this->model->findOrFail(input('id'));
        $model->delete();
        return success();
    }

    public function update()
    {
        $data = input();
        // 不允许更新软删除字段
        if ($this->model->deleteTime){
            unset($data[$this->model->deleteTime]);
        }

        $this->model
            ->isUpdate(true)
            ->save(input());

        return success();
    }
}