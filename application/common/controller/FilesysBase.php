<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-6
 * Time: 下午6:20
 */

namespace app\common\controller;


use app\common\model\FileSysModel;
use think\Controller;
use think\File;

class FilesysBase extends Controller
{

    /**
     * 上传模型
     * @var $model FileSysModel
     */
    protected $model = null;

    /**
     * 现在上传文件大小（单位：M)
     * @var int $limitUploadSize
     */
    protected $limitUploadSize = 2;

    /**
     * 允许上传的文件拓展
     * @var string $allowUploadExt
     */
    protected $allowUploadExt  = 'bmp,jpeg,jpg,png,gif,mp3,mp4';

    public function initialize()
    {
        $this->model = new FileSysModel();
    }

    public function index(){
        switch (input('action')){
            case 'config':
                return $this->config();
        }
    }



    public function read(){
        $file = $this->model
                ->where('filename',input('filename'))
                ->findOrFail();

        if ($file['device'] == 'local'){
            return $this->localFileResponse($file,input('?unOpeninBrowser'));
        } else {
            return redirect($file['url']);
        }
    }

    /**
     * 下载本地的文件
     * @param $file
     * @param bool $unOpeninBrowser 是否不在浏览器中打开，意思就是如果是图像这个参数为false那么就直接显示图片，而不是下载图片
     * @return \think\response\Download
     */
    private function localFileResponse($file,$unOpeninBrowser = false){
        return download('./uploads/'.$file['local_path'],time(),false,360,$unOpeninBrowser);
    }

    /**
     * 上传文件
     * @return \think\response\Json
     */
    public function upload(){
        $file = request()->file('file');
        if (!$file){
            return json([
                'code' => 1011,
                'msg'  => '上传文件不存在',
                'data' => null
            ]);
        }
        // 移动到框架应用/public/uploads/ 目录下
        /**
         * @var $file File
         */
        $info = $file
            ->validate(['size'=>$this->limitUploadSize * 1024 * 1024,'ext'=>$this->allowUploadExt])
            ->move( './uploads');

        if($info){
            $model = FileSysModel::create([
                // 文件名称当前系统时间微秒的md5值
                'filename' => $info->getFileName(),
                'url'      => request()->domain() . '/api/filesys/read?filename='.$info->getFileName(),
                'local_path'    => $info->getSaveName(),
                'mime'     => $info->getMime(),
                'device'   => 'local',
            ]);
            return json([
               'code' => 0,
               'msg'  => 'success',
               'data' => $model
            ]);
        }else{
            return json([
                'code' => 1012,
                'msg'  => $file->getError(),
                'data' => null
            ]);
        }}


        /**
         * 添加允许上传的文件类型
         * @param $ext string
         */
        protected function appendAllowExt($ext){
            $this->allowUploadExt = "$this->allowUploadExt,$ext";
        }
}