<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-24
 * Time: 上午10:27
 */

namespace app\admin\controller;


use app\common\controller\AdminBase;
use app\common\model\${uc_name}Model;

class ${uc_name}Controller extends AdminBase
{
    protected function initialize()
    {
        $this->model = new ${uc_name}Model();
    }
}