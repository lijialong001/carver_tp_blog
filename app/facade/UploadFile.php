<?php

namespace app\facade;

use think\Facade;

class   UploadFile extends Facade
{

    protected static function getFacadeClass()
    {
        return 'app\common\UpFiles';
    }


}
