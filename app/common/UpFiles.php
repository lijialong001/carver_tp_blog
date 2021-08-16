<?php

namespace app\common;

// 引入鉴权类
use Qiniu\Auth as qiniuAuth;
// 引入上传类
use \Qiniu\Storage\UploadManager;

class UpFiles
{

    //上传本地
    public function upLocal($file)
    {
        // 移动到框架应用根目录/uploads/ 目录下
        try {
            // 验证
            validate(['imgFile' => [
                'fileSize' => 410241024,
                'fileExt' => 'jpg,jpeg,png,bmp,gif',
                'fileMime' => 'image/jpeg,image/png,image/gif', //这个一定要加上，很重要我认为！
            ]])->check(['imgFile' => $file]);
            // 上传图片到本地服务器
            $saveName = \think\facade\Filesystem::disk('public')->putFile('', $file);
            $arr = ['code' => 1, 'data' => $saveName];
            return $arr;
        } catch (\Exception $e) {
            // 验证失败 输出错误信息
            return ['code' => 0, 'data' => $e->getMessage()];
        }
    }

    public function upQiniu($file)
    {
        // 用于签名的公钥和私钥
        $accessKey = config("filesystem.disks.qiniu.accessKey");
        $secretKey = config("filesystem.disks.qiniu.secretKey");
        // 初始化签权对象
        $auth = new qiniuAuth($accessKey, $secretKey);
        // 空间名  https://developer.qiniu.io/kodo/manual/concepts
        $bucket = config("filesystem.disks.qiniu.bucket");
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        // 上传文件到七牛
        //拿到上传文件的格式
        $pathinfo = pathinfo($file['name']);
        //获取图片后缀名
        $ext = $pathinfo['extension'];
        // 要上传文件的本地路径
        $filePath = $file['tmp_name'];
        // 上传到七牛后保存的文件名
        $saveName = date("Y/m/d") . substr(md5($filePath), 0, 6) . rand(0000, 9999) . "." . $ext;
        list($ret, $err) = $uploadMgr->putFile($token, $saveName, $filePath);
        if ($err !== null) {//为空说明报错
            return ['code' => 0, 'data' => $err];
        } else {
            return ['code' => 1, 'data' => $saveName];
        }
    }


}
