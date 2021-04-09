<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use think\App;
use think\facade\Db;
use think\Request;

class Site extends BaseController
{
    protected $auth_code;

    public function __construct(App $app, Request $request)
    {
        $this->auth_code = parent::__construct($app);
    }


    public function index()
    {
        if ($this->auth_code['auth_code'] == 0) {
            return view("/noAuth");
        }

        $site_info = Db::name("carver_site")->select()->toArray();

        return view("site/site", ['siteInfo' => $site_info[0]]);
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DbException
     * @desc 设置网站信息
     */
    public function setSiteInfo()
    {
        $info = urldecode(mb_unserialize($_POST['info']));
        $data = explode("&", $info);
        $site_id = is_numeric($_POST['site_id']) ? intval($_POST['site_id']) : $_POST['site_id'];

        foreach ($data as $key => $value) {
            $infoRes = explode("=", $value);
            $result[$infoRes[0]] = $infoRes[1];
        }
        $res = Db::name("carver_site")->where('site_id', $site_id)->update($result);

        switch ($_POST['setType']) {
            case 'site_info':
                $msg_success = '网址设置成功!';
                $msg_fail = '重新设置网址!';
                break;
            case 'blog_info':
                $msg_success = '个人资料设置成功!';
                $msg_fail = '重新设置个人资料!';
                break;
        }

        if ($res) {
            return json(['code' => 1, 'msg' => $msg_success]);
        } else {
            return json(['code' => 0, 'msg' => $msg_fail]);
        }
    }
}
