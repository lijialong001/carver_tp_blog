<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use think\App;
use think\facade\Lang;
use think\Request;
use app\admin\model\CarverLink;
use think\facade\Db;

class Link extends BaseController
{
    protected $auth_code;
    public function __construct(App $app, Request $request)
    {
        $this->auth_code = parent::__construct($app);
        Lang::load(base_path() . 'admin/lang/' . config('lang.default_lang') . '/link.lang.php');
    }


    public function addLink()
    {
        return view("link/link");
    }

    /**
     * @desc 申请友情
     * @author Carver
     */
    public function applyLink()
    {
        $form_data = $_POST;
        $res['link_name'] = $form_data['link_name'];
        $res['link_site'] = $form_data['link_site'];
        $res['is_confirm'] = 0;
        $res['create_time'] = time();
        $result = CarverLink::insert($res);
        if ($result === false) {
            return json(['code' => 0, 'msg' => lang("link_apply_fail")]);
        }

        return json(['code' => 1, 'msg' => lang("link_apply_confirm")]);
    }

    /**
     * @desc 友情列表
     * @author  Carver
     */
    public function linkList()
    {
        if($this->auth_code['auth_code']==0){
            return view("/noAuth");
        }

        $linkList =Db::name("carver_link")->paginate(10);

        return view("link/linkList", ['linkList' => $linkList]);
    }

    /**
     * @desc 更改友情链接状态
     * @author  Carver
     */
    public function upLink()
    {
        $id = trim($_GET['id']);
        $data = CarverLink::where("link_id", $id)->find();

        return view("link/upLink", ['data' => $data]);
    }

    /**
     * @desc 处理修改友情链接
     * @author Carver
     */
    public function doLink()
    {
        $link_id = trim($_POST['link_id']);//修改的id
        $is_confirm = trim($_POST['is_confirm']);//修改的状态
        $res = CarverLink::where("link_id", $link_id)->save(['is_confirm' => $is_confirm]);
        if ($res === false) {
            return json(['code' => 0, 'msg' => lang("link_update_fail")]);
        }
        logMsg("link_update_module");

        return json(['code' => 1, 'msg' => lang("link_update_success")]);
    }


}
