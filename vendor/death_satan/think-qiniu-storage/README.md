# thinkphp6 filesystem 七牛云驱动
## 使用方法
### modify /your_project/config/filesystem.php
```php
<?php

use think\facade\Env;

return [
    // 默认磁盘
    'default' => Env::get('filesystem.driver', 'local'),
    // 磁盘列表
    'disks'   => [
        'local'  => [
            'type' => 'local',
            'root' => app()->getRuntimePath() . 'storage',
        ],
        'public' => [
            // 磁盘类型
            'type'       => 'local',
            // 磁盘路径
            'root'       => app()->getRootPath() . 'public/storage',
            // 磁盘路径对应的外部URL路径
            'url'        => '/storage',
            // 可见性
            'visibility' => 'public',
        ],
         //newly added
        'qiniu'=>[
           'type'=>'qiniu',
           'accessKey'=>'your accessKey',
           'secretKey'=>'your secretKey',
           'bucket'=>'your qiniu bucket name',
           'domain'=>'your qiniu bind domain' 
        ]   
        // 更多的磁盘配置信息
    ],
];

```
## 在控制器中
```php
<?php
namespace app\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        //获取上传文件
        $image = $this->request->file('image');
        //获取上传后的文件路径
        $qiniu_file = \think\facade\Filesystem::disk('qiniu')->put('image',$image);
        dd($qiniu_file);
    }
}
```
