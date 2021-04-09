<?php
declare (strict_types=1);

namespace app\admin\controller;

use AlibabaCloud\Dbs\Dbs;
use app\BaseController;
use think\App;
use think\Exception;
use think\facade\Cache;
use think\facade\View;
use app\admin\model\CarverAdmin;
use app\admin\model\CarverRole;
use app\admin\model\CarverAdminRole;
use app\admin\model\CarverAuth;
use app\admin\model\CarverRoleAuth;
use think\Request;

class Index extends BaseController
{
    protected $auth_code;

    //初始化数据
    public function __construct(App $app, Request $request)
    {
        $this->auth_code = parent::__construct($app);
    }

    /**
     * @desc 退出登录
     * @author  carver
     * @date 2020-07-18
     */
    public function outLogin()
    {
        $req = session("admin_id", null);
        if (is_null($req)) {
            $this->success("退出成功,请稍后...", "Login/login");
        }
    }

    /**
     * @desc 登录后的首页
     * @author  carver
     * @date 2020-07-18
     */
    public function adminIndex()
    {

        if ($this->auth_code['auth_code'] == 1) {
            $data['ip'] = $_SERVER['SERVER_ADDR'];//服务器地址ip
            $data['host_name']=$_SERVER['SERVER_NAME'];//服务器域名
            $data['server_port']=$_SERVER['SERVER_PORT'];//服务web端口
            $data['php_version']=PHP_VERSION;//php版本
            $data['system_info']=php_uname('s');//操作系统类型
            $data['php_run_method']=php_sapi_name() ;//php运行模式
            $data['web_server']=$_SERVER['SERVER_SOFTWARE'];//获取服务器解译引擎
            $data['http_info']=$_SERVER['SERVER_PROTOCOL'];//获取请求页面时通信协议的名称和版本

            return \view("index/index",['data'=>$data]);
        } else {
            return view("/noAuth");
        }

    }

    /**
     * @desc 无权访问的页面
     * @author  carver
     * @date 2020-07-19
     */
    public function noAuth()
    {
        return view("noAuth");
    }


}
