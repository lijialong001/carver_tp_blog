<?php

return [
    // 默认磁盘
    'default' => env('filesystem.driver', 'local'),
    // 磁盘列表
    'disks' => [
        'local' => [
            'type' => 'local',
            'root' => app()->getRuntimePath() . 'public',
        ],
        'public' => [
            // 磁盘类型
            'type' => 'local',
            // 磁盘路径
            'root' => app()->getRootPath() . 'public/uploads',
            // 磁盘路径对应的外部URL路径
            'url' => '/storage',
            // 可见性
            'visibility' => 'public',
        ],
        // 更多的磁盘配置信息
        'qiniu' => [
            'type' => 'qiniu',
            'accessKey' => 'bGjv9BspzxUJL1Igty7tTiZsHt_xdwEctm_nVhC2',
            'secretKey' => 'bWZO3CkKDHRq8-drw0fU7ziSMTZgKJhS5drJumAE',
            'bucket' => 'carver-qiniu',
            'url' => 'qiniu.lijialong.site'
        ],
    ],
];
