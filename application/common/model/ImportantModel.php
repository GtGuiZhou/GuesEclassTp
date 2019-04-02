<?php
/**
 * Created by PhpStorm.
 * User: gt
 * Date: 19-2-13
 * Time: 上午12:06
 */

namespace app\common\model;


use think\exception\HttpException;
use think\exception\ValidateException;
use think\Model;
use think\model\concern\SoftDelete;

class ImportantModel extends Model
{
    use SoftDelete;

    protected $table = 'sys_important';
    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = true;
    protected $pk = 'id';
    protected $hidden = ['secret_key','salt'];

    protected static function init()
    {
        self::beforeInsert(function ($model) {
            try {
                $salt = base64_encode(random_bytes(32));
                $secret_key = input('secret_key');
                $secret_key = sha1($secret_key.$salt);
                $model['secret_key'] = $secret_key;
                $model['salt']     = $salt;
                $model['content']  = ImportantModel::enCrypt($model["content"],$secret_key);
            } catch (\Exception $e) {
                throw new ValidateException('加密失败');
            }
        });
    }
    public function getDeleteTimeAttr($value)
    {
        return date('Y-m-d H:i:s',$value);
    }

    public function unlock($id,$secret_key){
        $model = $this->findOrFail($id);
        $salt = $model['salt'];
        $secret_key = sha1($secret_key.$salt);
        $s = $model['secret_key'];
        if ($secret_key != $model['secret_key']){
            throw new ValidateException('密匙错误');
        }
        $model['content'] = $this::deCrypt($model['content'],$model['secret_key']);
        return $model;
    }


    /**
     * 可逆的字符串加密函数[无依赖简版]
     * @param int $txtStream 待加密的字符串内容
     * @param int $password 加密密码
     * @return string 加密后的字符串
     */
    public static function enCrypt($txtStream,$password = 'ENCRYPT_KEY'){
        //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,
        $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';
        //随机找一个数字，并从密锁串中找到一个密锁值
        $lockLen = strlen($lockstream);
        $lockCount = rand(0,$lockLen-1);
        $randomLock = $lockstream[$lockCount];
        //结合随机密锁值生成MD5后的密码
        $password = md5($password.$randomLock);
        //开始对字符串加密
        $txtStream = base64_encode($txtStream);
        $tmpStream = '';
        $i=0;$j=0;$k = 0;
        for ($i=0; $i<strlen($txtStream); $i++) {
            $k = ($k == strlen($password)) ? 0 : $k;
            $j = (strpos($lockstream,$txtStream[$i])+$lockCount+ord($password[$k]))%($lockLen);
            $tmpStream .= $lockstream[$j];
            $k++;
        }
        return $tmpStream.$randomLock;

    }

    /**
     * 可逆的字符串解密函数[无依赖简版]
     * @param int $txtStream 待加密的字符串内容
     * @param int $password 解密密码
     * @return string 解密后的字符串
     */
    public static  function deCrypt($txtStream,$password = 'ENCRYPT_KEY'){
        //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,
        $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';

        $lockLen = strlen($lockstream);
        //获得字符串长度
        $txtLen = strlen($txtStream);
        //截取随机密锁值
        $randomLock = $txtStream[$txtLen - 1];
        //获得随机密码值的位置
        $lockCount = strpos($lockstream,$randomLock);
        //结合随机密锁值生成MD5后的密码
        $password = md5($password.$randomLock);
        //开始对字符串解密
        $txtStream = substr($txtStream,0,$txtLen-1);
        $tmpStream = '';
        $i=0;$j=0;$k = 0;
        for($i=0; $i<strlen($txtStream); $i++){
            $k = ($k == strlen($password)) ? 0 : $k;
            $j = strpos($lockstream,$txtStream[$i]) - $lockCount - ord($password[$k]);
            while($j < 0){
                $j = $j + ($lockLen);
            }
            $tmpStream .= $lockstream[$j];
            $k++;
        }
        return base64_decode($tmpStream);
    }
}