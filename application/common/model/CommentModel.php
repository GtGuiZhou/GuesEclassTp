<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\common\model;


class CommentModel extends BaseModel
{
    protected $table = 'sys_comment';
    protected $append = array (
      0 => 'create_time_text',
      1 => 'update_time_text',
    );

    protected static function init()
    {
        self::event('after_insert',function ($comment){
            list($module,$id) = implode(':',$comment['module']);
            if ($module == 'lovewall'){
                VideoModel::where('id',$id)->setInc('comment_number');
            }
        });
    }
}