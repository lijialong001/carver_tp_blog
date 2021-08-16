<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;

class Log extends BaseController
{
    public function logActIndex()
    {
        return view("log/actionLog");
    }
}
