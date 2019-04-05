<?php
/**
 * Created by PhpStorm.
 * User: gtguizhou
 * Date: 19-3-28
 * Time: 下午1:11
 */

namespace app\command;


use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\Db;
use think\Exception;

class Crud extends Command
{
    /**
     * 前缀
     * @var string
     */
    protected $prefix = 'sys_';

    /**
     * 过滤验证字段
     * 这里面的字段不会生成验证规则
     * @var array
     */
    private $filterValidateField = ['create_time','update_time'];

    protected function configure()
    {
        $this->setName('crud')
            ->addArgument('name', Argument::OPTIONAL, "crud名称")
            ->addOption('softdelete', "-s", Option::VALUE_REQUIRED, '是否开启软删除')
            ->addOption('delete', "-d", Option::VALUE_OPTIONAL, '是否删除')
            ->addOption('binduser', "-b", Option::VALUE_OPTIONAL, '是否设定绑定用户中间件')
            ->setDescription('自动创建crud');
    }

    protected function execute(Input $input, Output $output)
    {
        $low_name =  strtolower(trim($input->getArgument('name')));
        $uc_name = ucfirst($low_name);
        $delete = $input->getOption('delete');
        $softdelete = $input->getOption('softdelete');
        $table = strtolower($uc_name);
        $binduser = $input->getOption('binduser');

        if (!$uc_name){
            throw new Exception('name不能为空');
        }

        $out_admin_path = "./application/admin/controller/".$uc_name."Controller.php";
        $out_api_path = "./application/api/controller/".$uc_name."Controller.php";
        $out_model_path = "./application/common/model/".$uc_name."Model.php";
        $out_validate_path = "./application/common/validate/".$uc_name."Validate.php";
        $out_route_path = "./route/".$low_name.".php";

        if ($delete){
            $this->delFile($out_model_path);
            $this->delFile($out_admin_path);
            $this->delFile($out_api_path);
            $this->delFile($out_route_path);
            $this->delFile($out_validate_path);
            $output->writeln('删除完毕');
            return;
        }


        $tpl_admin_controller = file_get_contents('./application/command/template/AdminController.tpl');
        $tpl_api_controller = file_get_contents('./application/command/template/ApiController.tpl');
        $tpl_model = file_get_contents('./application/command/template/Model.tpl');
        $tpl_validate = file_get_contents('./application/command/template/Validate.tpl');
        if ($softdelete)
            $tpl_model = file_get_contents('./application/command/template/SoftDeleteModel.tpl');

        $append = [
            'create_time_text',
            'update_time_text',
        ];
        if ($softdelete){
            array_push($append,'delete_time_text');
        }
        $append = var_export($append,true);
        $rule = var_export($this->parserValidate($this->prefix.$table),true);
        $display_admin_controller = $this->view($tpl_admin_controller,array('uc_name' => $uc_name));
        $display_api_controller = $this->view($tpl_api_controller,['uc_name' => $uc_name]);
        $display_model = $this->view($tpl_model,['uc_name' => $uc_name,'table' => $table,'append' => $append]);
        $display_validate = $this->view($tpl_validate,['uc_name' => $uc_name,'rule' => $rule]);
        $display_route = $this->parserRouter($low_name,$binduser);

        $this->outDisplay($out_api_path,$display_api_controller);
        $this->outDisplay($out_admin_path,$display_admin_controller);
        $this->outDisplay($out_model_path,$display_model);
        $this->outDisplay($out_validate_path,$display_validate);
        $this->outDisplay($out_route_path,$display_route);
    }

    protected function outDisplay($path,$content){
        $handle = fopen($path,'w');
        fwrite($handle,$content);
        fclose($handle);
    }

    public function view ($content,$vars) {
        foreach ($vars as $key => $var){
            $content = str_replace('${'.$key.'}',$var,$content);
        }

        return $content;
    }

    public function parserRouter($name,$isBindUser){
        $name = strtolower($name);
        $uc_name = ucfirst($name);
        $validate = 'app\\common\\validate\\'.$uc_name.'Validate';
        $middle = $isBindUser?"->middleware(\\app\\http\\middleware\\UserBind::class)":'';
        $route = <<<p
<?php

\\think\\facade\\Route::post('api/$name/add','api/$name/add')
    ->validate('$validate')$middle;
p;
        return $route;
    }

    public function parserValidate($table){
        $fields = Db::query("select * from information_schema.columns where table_name='$table'");
        $res = [];
        foreach ($fields as $field){

            if ($field['COLUMN_KEY'] != 'PRI' && !in_array( $field['COLUMN_NAME'],$this->filterValidateField)) {
                $key = $field['COLUMN_NAME'] . '|' . ($field['COLUMN_COMMENT'] ? $field['COLUMN_COMMENT'] : $field['COLUMN_NAME']);
                $require = $field['IS_NULLABLE'] == 'NO' ? 'require' : '';
                $length = $field['CHARACTER_MAXIMUM_LENGTH'] ? "length:1," . $field['CHARACTER_MAXIMUM_LENGTH'] : '';
                $mobile = strpos($field['COLUMN_NAME'], 'phone') !== false || strpos($field['COLUMN_NAME'], 'mobile') !== false ? 'mobile' : '';
                $number = strpos($field['DATA_TYPE'], 'int') !== false ? 'number' : '';
                $url = strpos($field['COLUMN_NAME'], 'url') !== false?'url':'';
                // 过滤空规则
                $rules = array_filter([
                    $require, $length, $mobile, $number,$url
                ], function ($item) {
                    return $item;
                });
                $res[$key] = implode($rules, "|");
            }
        }
        return $res;
    }


    protected function delFile($path){
        if (file_exists($path))
            unlink($path);
    }
}