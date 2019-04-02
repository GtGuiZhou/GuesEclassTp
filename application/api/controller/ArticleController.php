<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-6
 * Time: 上午12:16
 */

namespace app\api\controller;


use app\common\controller\ApiBase;
use app\common\lib\StarControllerTrait;
use app\common\model\ArticleModel;
use think\db\Query;

class ArticleController extends ApiBase
{
    use StarControllerTrait;

    protected $limitAction = ['except' => 'index'];

    protected function initialize()
    {
        $this->model = new ArticleModel();
    }

    public function index()
    {
        var_dump(input());
        $this->indexWhere = function (Query $query){
          $query->whereLike('tags',"%".input('tag')."%");
        };
        return parent::index(); // TODO: Change the autogenerated stub
    }
}