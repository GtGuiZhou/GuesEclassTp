<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-6
 * Time: 下午6:20
 */

namespace app\common\controller;


use app\common\model\FileSysModel;
use think\exception\ValidateException;
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

        return $this->moveFile($file);
    }



        public function clipUpload(){
            $res = $this->validate(input(),[
                'filename' => 'require|length:1,255',
                'index' => 'require|number',
                'totalPieces' => 'require|number',
            ]);

            if (true !== $res){
                return json([
                    'code' => 1011,
                    'msg'  => $res,
                    'data' => null
                ]);
            }

            if (input('index') > input('totalPieces')){
                return json([
                    'code' => 1011,
                    'msg'  => 'index不能大于totalPieces',
                    'data' => null
                ]);
            }

            if (!isset($_FILES['file']) || !isset($_FILES['file']['tmp_name']))
            {
                return json([
                    'code' => 1011,
                    'msg'  => '上传文件不存在',
                    'data' => null
                ]);
            }

            $temp_path = $_FILES['file']['tmp_name'];
            $file = file_get_contents($temp_path);
            $filename = input('filename');
            $path = '/tmp/'.$filename;
            file_put_contents($path,$file,FILE_APPEND);
            unlink($temp_path);
            if (input('index') == input('totalPieces')){
                // 无法使用file的move方法，因为move方法内只能移动上传文件
                $file = new File($path);
                // 规则验证
                if(!$file->validate(['size'=>$this->limitUploadSize * 1024 * 1024,'ext'=>$this->allowUploadExt])->check())
                    throw new ValidateException($file->getError());
                // 验证上传
                if (!$file->check())
                    throw new ValidateException($file->getError());
                $path = './uploads';
                $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
                // 文件保存命名规则
                $saveName = $file->buildSaveName(true, true);
                $filename = $path . $saveName;

                // 检测目录
                if (false === $file->checkPath(dirname($filename))) {
                    throw new ValidateException($file->getError());
                }

                /* 不覆盖同名文件 */
                if (is_file($filename)) {
                    throw new ValidateException('文件重复，请重新上传');
                }


                /* 移动文件 */
                if (!move_uploaded_file($file->getRealPath() ?: $file->getPathname(), $filename)) {
                    return false;
                }

                // 返回 File对象实例
                $file = new File($filename);
                $file->setSaveName($saveName);
                $file->setUploadInfo($this->info);
            }

            return json([
                'code' => 0,
                'msg'  => 'success',
            ]);
        }


        /**
         * 添加允许上传的文件类型
         * @param $ext string
         */
        protected function appendAllowExt($ext){
            $this->allowUploadExt = "$this->allowUploadExt,$ext";
        }


        protected function moveFile($file){
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
            }
        }



}