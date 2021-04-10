<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use app\admin\model\CarverAdmin;
use app\admin\model\CarverNotice;
use think\App;
use think\facade\Lang;
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
        //超级管理员角色名字（管理删除公告信息的权限）
        $manager_info = CarverAdmin::where("admin_name", session("admin_name"))
            ->field("b.role_name")
            ->join("carver_admin_role a", "carver_admin.admin_id=a.admin_id", "left")
            ->join("carver_role b", "a.role_id=b.role_id", "left")
            ->find();
        $role_name['role_name'] = '普通管理员';
        if ($manager_info) {
            $role_name = $manager_info->toArray();
        }

        $data = CarverNotice::field("notice_id,notice_content,add_user,from_unixtime(create_time,'%Y-%m-%d %H:%i:%s') as createtime")
            ->select()
            ->order("create_time", "desc")
            ->toArray();

        return view("notice/noticeList", ['data' => $data, 'manager_info' => $role_name['role_name']]);
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
        $req = CarverNotice::where(compact("notice_id"))->delete();
        if ($req) {
            logMsg("notice_delete_module");
            return json(['code' => 1, 'msg' => lang("notice_delete_success")]);
        } else {
            return json(['code' => 0, 'msg' => lang("notice_delete_fail")]);
        }
    }


}
