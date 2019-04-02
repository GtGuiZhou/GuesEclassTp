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

class Crud extends Command
{
    protected function configure()
    {
        $this->setName('crud')
            ->addArgument('name', Argument::OPTIONAL, "crud名称")
            ->addOption('softdelete', "-s", Option::VALUE_REQUIRED, '是否开启软删除')
            ->addOption('delete', "-d", Option::VALUE_OPTIONAL, '是否删除')
            ->setDescription('自动创建crud');
    }

    protected function execute(Input $input, Output $output)
    {
        $name = ucfirst(strtolower(trim($input->getArgument('name'))));
        $delete = $input->getOption('delete');
        $table = strtolower($name);
        $out_admin_path = "./application/api/controller/".ucfirst(strtolower($name))."Controller.php";
        $out_api_path = "./application/admin/controller/".ucfirst(strtolower($name))."Controller.php";
        $out_model_path = "./application/common/model/".ucfirst(strtolower($name))."Model.php";

        if ($delete){
            unlink($out_model_path);
            unlink($out_admin_path);
            unlink($out_api_path);
            $output->writeln('删除完毕');
            return;
        }

        $tpl_admin_controller = file_get_contents('./application/command/template/AdminController.tpl');
        $tpl_api_controller = file_get_contents('./application/command/template/ApiController.tpl');
        $tpl_model = file_get_contents('./application/command/template/Model.tpl');
        $append = var_export([
            'create_time_text',
            'update_time_text',
            'delete_time_text'
        ],true);
        $display_admin_controller = $this->view($tpl_admin_controller,array('name' => $name));
        $display_api_controller = $this->view($tpl_api_controller,['name' => $name]);
        $display_model = $this->view($tpl_model,['name' => $name,'table' => $table,'append' => $append .';']);

        $this->outDisplay($out_api_path,$display_api_controller);


        $this->outDisplay($out_admin_path,$display_admin_controller);


        $this->outDisplay($out_model_path,$display_model);
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
}