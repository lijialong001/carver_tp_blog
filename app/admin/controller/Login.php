<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use app\admin\controller\Auth;
use app\facade\Env;
use think\App;
use think\facade\Db;
use think\facade\Lang;
use think\facade\View;
use app\admin\model\CarverAdmin;
use app\admin\model\CarverSystemLog;

class Login extends Auth
{
    public function __construct()
    {
        Lang::load(base_path() . 'admin/lang/' . config('lang.default_lang') . '/login.lang.php');
    }

    /**
     * @desc 后台登录
     * @author  carver
     */
    public function login()
    {
        //登录之前判断是否已经登录
        if (session("admin_id")) {
           return redirect("/admin/Index/adminIndex");
        }else{
            return View('login/login');
        }


    }

    /**
     * @desc 后台处理登录
     * @author  carver
     */
    public function doLogin()
    {
        //记录登录的次数
        session("login_num", session("login_num") + 1);
        //验证用户信息
        $arr['admin_name'] = $_GET['admin_name'];
        $arr['admin_pwd'] = $_GET['admin_pwd'];
        $name = CarverAdmin::where(['admin_name' => $arr['admin_name'], 'delete_time' => 0])->find();
        $pwd = CarverAdmin::where(['admin_pwd' => md5($arr['admin_pwd']), 'delete_time' => 0])->find();
        $info = CarverAdmin::where(['admin_name' => $arr['admin_name'], 'admin_pwd' => md5($arr['admin_pwd']), 'delete_time' => 0])->find();

        if (!$name) {
            // 验证失败
            return ['code' => 0, 'msg' => lang("admin_validate_name"), 'data' => null];
        }
        if (!$pwd) {
            // 验证失败
            return ['code' => 2, 'msg' => lang("admin_validate_pwd"), 'data' => null];
        }
        if (isset($_GET['captcha']) && session("login_num") >= 3) {
            if (!captcha_check($_GET['captcha'])) {
                // 验证失败
                return ['code' => 4, 'msg' => lang("admin_validate_captcha"), 'data' => null];
            };
        }
        if ($info) {
            session("login_num", null);
            session("admin_id", $info['admin_id']);
            session("admin_image", $info['admin_image']);
            $res = session("admin_name", $info['admin_name']);
            CarverAdmin::where(['admin_name' => $arr['admin_name'], 'admin_pwd' => md5($arr['admin_pwd'])])->update(['last_login' => time()]);
            logMsg("system_login_module");

            return ['code' => 1, 'msg' => lang("admin_login_success"), ['data' => $res, 'num' => $_GET['click_num']]];
        }
    }


}
