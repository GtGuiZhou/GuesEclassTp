<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-9
 * Time: 上午10:55
 */

namespace app\common\lib;


use app\common\model\SysConfigModel;
use think\exception\ValidateException;
use think\facade\Cache;
use think\Model;

trait GroupControllerTrait
{
    /**
     * 永久缓存，在updateGroup的时候更新缓存
     * 当前控制器对应的模型
     * @var $model Model
     */
//    protected $model = null;

    /**
     * 是否允许修改分组，在初始化中设置
     * @var bool
     */
    protected $allowUpdateGroupTree = true;

    public function getGroupTree(){
        $key = $this->getCurrGroupKey();
        // 获取最近的一条配置，这样即使分组配置被损坏也能够还原
        $config = SysConfigModel::where('config_name', $key)
            ->order('create_time','desc')
            ->cache($key,0)->find();
        if (!$config){
            $tree = [['label' => 'root', 'path' => 'root/', 'children' => []]];
        } else {
            $tree = $config['value'];
        }

        return success($tree);
    }

    /**
     * 更新分组数据，并且更新缓存
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function updateGroupTree(){
        if (!$this->allowUpdateGroupTree)
            throw new ValidateException('不允许修改分组');
        $key = $this->getCurrGroupKey();
        $tree = input('tree');
        if (count($tree) < 1){
            throw new ValidateException('子节点不能为空');
        }
        // 添加数据
        SysConfigModel::create([
            'config_name'   => $key,
            'value'         => $tree
        ]);
        // 更新缓存
        Cache::rm($key);
        return success();
    }

    public function getCurrGroupKey(){
        $table = $this->model->getTable();
        $key = "groupTree:$table";
        return $key;
    }
}