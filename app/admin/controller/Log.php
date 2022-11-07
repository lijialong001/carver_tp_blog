<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use app\admin\model\CarverSystemLog;
use app\admin\model\CarverOperateLog;
use think\App;
use think\facade\Db;
use think\facade\Lang;
use think\Request;
use page\page;

class Log extends BaseController
{
    protected $auth_code;

    //初始化数据
    public function __construct(App $app, Request $request)
    {
        $this->auth_code = parent::__construct($app);
    }

    /**
     * @desc 操作日志
     * @author Carver
     */
    public function logActIndex()
    {
        if ($this->auth_code['auth_code'] == 0) {
            return view("/noAuth");
        }

        $page_count = 10;
        $data = Db::name("carver_operate_log")
            ->where("log_user_id", session("admin_id"))
            ->order('create_time', 'desc')
            ->paginate($page_count)
            ->toArray();
            
        //分页
        $page = new page($data['total'], $page_count);
        $get_page = $page->fpage();    

        return view("log/actionLog", ['data' => $data,'page' => $get_page]);
    }

    /**
     * @desc 系统日志
     * @author Carver
     */
    public function logSysIndex()
    {
        if ($this->auth_code['auth_code'] == 0) {
            return view("/noAuth");
        }

        $page_count = 10;
        $data = Db::name("carver_system_log")
            ->where("action_user_id", session("admin_id"))
            ->order('create_time', 'desc')
            ->paginate($page_count)
            ->toArray();
            
        //分页
        $page = new page($data['total'], $page_count);
        $get_page = $page->fpage();  

        return view("log/systemLog", ['data' => $data,'page' => $get_page]);
    }

}
