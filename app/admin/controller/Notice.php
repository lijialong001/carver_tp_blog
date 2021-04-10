<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use app\admin\model\CarverAdmin;
use app\admin\model\CarverNotice;
use think\App;
use think\facade\Lang;
use think\facade\Db;
use think\Request;

class Notice extends BaseController
{
    protected $auth_code;

    public function __construct(App $app, Request $request)
    {
        $this->auth_code = parent::__construct($app);
        Lang::load(base_path() . 'admin/lang/' . config('lang.default_lang') . '/notice.lang.php');
    }

    /**
     * @desc 公告列表
     * @author Carver
     */
    public function noticeList()
    {
        
        if ($this->auth_code['auth_code'] == 0) {
            return view("/noAuth");
        }

        $data = CarverNotice::field("notice_id,notice_content,add_user,from_unixtime(create_time,'%Y-%m-%d %H:%i:%s') as createtime")
            ->select()
            ->order("create_time", "desc")
            ->toArray();

        return view("notice/noticeList", ['data' => $data]);
    }

    /**
     * @desc 添加公告页面
     * @author  Carver
     */
    public function addNotice()
    {
        return view("notice/addNotice");
    }

    /**
     * @desc 提交添加公告数据
     * @author  Carver
     */
    public function doNotice()
    {
        $data['notice_content'] = $_POST['content'];//公告内容
        $data['add_user'] = session("admin_name");//操作人
        $data['create_time'] = time();//添加时间

        $req = CarverNotice::insert($data);
        if ($req) {
            logMsg("notice_add_module");
            return json(['code' => 1, 'msg' => lang("notice_add_success")]);
        } else {
            return json(['code' => 0, 'msg' => lang("notice_add_fail")]);
        }
    }

    /**
     * @desc 删除公告
     * @author Carver
     */
    public function delNotice()
    {
        $notice_id = $_POST['notice_id'];//公告iD

        $roleId = Db::name("carver_admin_role")->value("role_id");//当前操作者的角色

        //只有超级管理员才能删除公告
        if ($roleId != 1) {
            return json(['code' => 0, 'msg' => "爱卿，你没有删除的权限！"]);
        }

        $req = CarverNotice::where(compact("notice_id"))->delete();
        if ($req) {
            logMsg("notice_delete_module");
            return json(['code' => 1, 'msg' => lang("notice_delete_success")]);
        } else {
            return json(['code' => 0, 'msg' => lang("notice_delete_fail")]);
        }
    }


}
