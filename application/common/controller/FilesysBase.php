<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-6
 * Time: 下午6:20
 */

namespace app\common\controller;


use app\common\model\FileSysModel;
use think\facade\Log;
use think\File;

class FilesysBase extends CrudBase
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
    protected $limitUploadSize = 50;

    /**
     * 允许上传的文件拓展
     * @var string $allowUploadExt
     */
    protected $allowUploadExt  = 'bmp,jpeg,jpg,png,gif,mp3,mp4,flv,rmvb,avi';

    public function initialize()
    {
        $this->model = new FileSysModel();
        parent::initialize();
    }



    public function read(){
        // 获取原文件
        $file = $this->model
                ->where('filename',input('filename'))
                ->cache(true) // 永久缓存
                ->findOrFail();

        // 获取压缩文件
        $size = input('size');
        if ($size){
            return $this->thumbResponse($file['local_path'],$size);
        }

        if ($file['device'] == 'local'){
            return redirect($file['local_path']);
        } else {
            return redirect($file['url']);
        }
    }

    public function thumbResponse($path,$size){
        $info = pathinfo($path);
        $thumbPath = $info['dirname']."/$size".'_'.$info['basename'];
        if (!file_exists($thumbPath)){
            $image = \think\Image::open($path);
            // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
            $image->thumb($size, $size)->save($thumbPath);
        }
        return redirect($thumbPath);
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
                'local_path' => 'uploads/'.$info->getSaveName(),
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