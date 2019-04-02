<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-6
 * Time: 上午12:26
 */

namespace app\common\model;


use app\common\ext\RedisPool;
use think\Model;
use think\model\concern\SoftDelete;

class ArticleModel extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';
    protected $pk = 'id';
    protected $table = 'sys_article';
    protected $append = ['create_time_text','update_time_text'];

    public function getDeleteTimeAttr($value)
    {
        return date('Y-m-d H:i:s',$value);
    }

    public function setTagsAttr($value){
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    public function getTagsAttr($value){
        $encode = json_decode($value,true);
        return $encode ? $encode : array();
    }




}