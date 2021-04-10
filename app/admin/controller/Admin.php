<?php
declare (strict_types=1);

namespace app\admin\controller;

use think\App;
use app\admin\validate\AdminValidate;
use app\admin\model\CarverAdmin;
use app\admin\model\CarverRole;
use app\admin\model\CarverAdminRole;
use app\admin\model\CarverAuthNew;
use app\admin\model\CarverRoleAuth;
use app\admin\model\CarverOperateLog;
use app\BaseController;
use think\facade\Lang;
use think\Request;
use app\facade\UploadFile;
use think\facade\Db;
use page\page;

class Admin extends BaseController
{
    protected $auth_code;
    protected $validate;

    //初始化数据
    public function __construct(App $app, Request $request)
    {
        $this->auth_code = parent::__construct($app);
        $this->validate = new AdminValidate();
        Lang::load(base_path() . 'admin/lang/' . config('lang.default_lang') . '/admin.lang.php');
    }

    /**
     * @desc 添加角色
     * @author Carver
     */
    public function addRole()
    {
        //获取全部权限
        $allAuth = Db::name("carver_auth_new")
            ->field("auth_desc as title,auth_id as id,p_id")
            ->where("auth_status", 1)
            ->select()
            ->toArray();

        //被选中的选中
        $selected_auth = array_column($allAuth, "id");

        $getTreeData = $this->getAuthTree($allAuth);

        return view("admin/addRole", ['data' => json_encode($getTreeData), 'auth' => json_encode($selected_auth)]);
    }

    /**
     * @return \think\response\Json
     * @desc 处理添加角色
     * @author Carver
     */
    public function subAddRole()
    {
        $role_info = $_POST;

        $roleData['role_name'] = $role_info['role_name'];
        $roleData['current_status'] = 1;
        $roleData['create_time'] = time();

        $role_id = Db::name("carver_role")->insertGetId($roleData);//角色id
        $auth = explode(",", $role_info['admin_auth']);//角色权限

        $role_auth = array();
        foreach ($auth as $key => $value) {
            $role_auth[$key]['role_id'] = $role_id;
            $role_auth[$key]['auth_id'] = $value;
            $role_auth[$key]['current_status'] = 1;
            $role_auth[$key]['create_time'] = time();
        }
        $authData = Db::name("carver_role_auth")->insertAll($role_auth);//角色及权限
        if ($authData) {
            return json(['code' => 1, 'msg' => \lang('role_auth_add_success')]);
        } else {
            return json(['code' => 0, 'msg' => \lang('role_auth_add_fail')]);
        }
    }

    //递归
    public function getAuthTree($array)
    {

        $items = array();
        foreach ($array as $value) {
            $items[$value['id']] = $value;
        }

        $tree = array();
        foreach ($items as $key => $value) {
            if (isset($items[$value['p_id']])) {
                $items[$value['p_id']]['children'][] = &$items[$key];
            } else {
                $tree[] = &$items[$key];
            }
        }
        return $tree;
    }

    /**
     * @desc 角色列表
     * @author  carver
     */
    public function roleList()
    {
        if ($this->auth_code['auth_code'] == 0) {
            return view("/noAuth");
        }
        //角色列表信息
        $data = CarverRole::field("carver_role.role_id,carver_role.role_name,b.auth_name,b.auth_desc,a.delete_time")
            ->leftJoin("carver_role_auth a", "carver_role.role_id=a.role_id")
            ->leftJoin("carver_auth_new b", "a.auth_id=b.auth_id")
            ->where("carver_role.delete_time", 0)
            ->select()
            ->toArray();

        //取出角色的信息
        $role_info = CarverRole::field("role_id,role_name")->where("delete_time", 0)->select()->toArray();

        //角色
        $role_list = array_column($role_info, "role_name");
        foreach ($role_list as $roleKey => $roleValue) {
            $arr[$roleValue] = [];
        }

        foreach ($data as $key => $value) {
            foreach ($role_info as $k => $v) {
                if ($value['role_id'] == $v['role_id']) {
                    $arr[$value['role_name']][] = $data[$key];
                }
            }
        }

        foreach ($arr as $ka => $kal) {
            $res[$ka]['auth_desc'] = array_column($kal, 'auth_desc');
            $res[$ka]['delete_time'] = array_sum(array_column($kal, 'delete_time'));
            $res[$ka]['role_id'] = array_unique(array_column($kal, 'role_id'));
        }


        foreach ($res as $ke => $kel) {
            if ($kel['delete_time'] == 0) {
                $action[$ke]['auth_desc'] = implode(" | ", $kel['auth_desc']);
            } else {
                $action[$ke]['auth_desc'] = '';
            }

            $action[$ke]['role_id'] = $kel['role_id'];
        }

        return view("admin/roleList", ['data' => $action]);

    }

    /**
     * @desc 删除角色
     * @author Carver
     */
    public function delUpRoleAuth()
    {
        $role_id = input("role_id");
        $isHasAuth = CarverRoleAuth::where("role_id", $role_id)->where("delete_time", 0)->select()->toArray();
        if ($isHasAuth) {
            return json(['code' => 0, 'msg' => "请先删除该权限下的用户信息!"]);
        } else {
            $delReq = CarverRole::where("role_id", $role_id)->update(['delete_time' => time()]);

            if ($delReq) {
                return json(['code' => 1, 'msg' => lang("role_delete_success")]);
            } else {
                return json(['code' => 0, 'msg' => lang("role_delete_fail")]);
            }
        }
    }

    /**
     * @desc 清除角色的权限
     * @author Carver
     */
    public function removeRoleAuth()
    {
        $role_id = input("role_id");

        $isHasAuth = CarverRoleAuth::where("role_id", $role_id)->update(['delete_time' => time()]);
        if ($isHasAuth) {
            return json(['code' => 1, 'msg' => lang("role_auth_remove_success")]);
        } else {
            return json(['code' => 0, 'msg' => lang("role_auth_remove_fail")]);
        }
    }

    /**
     * @desc 修改角色权限
     * @author Carver
     */
    public function upRoleAuth()
    {
        $role_id = is_numeric($_POST['role_id']) ? intval($_POST['role_id']) : $_POST['role_id'];
        $auth = explode(",", $_POST['admin_auth']);

        foreach ($auth as $key => $value) {
            $data[$key]['role_id'] = $role_id;
            $data[$key]['auth_id'] = $value;
            $data[$key]['current_status'] = 1;
            $data[$key]['create_time'] = time();
        }

        $delNum = Db::name("carver_role_auth")->where("role_id", $role_id)->delete();

        if ($delNum) {
            $res = Db::name("carver_role_auth")->insertAll($data);
            if ($res) {
                return json(['code' => 1, 'msg' => lang("role_up_success")]);
            } else {
                return json(['code' => 0, 'msg' => lang("role_up_fail")]);
            }
        }
    }


    /**
     * @desc 修改角色页面
     * @author Carver
     */
    public function upRole()
    {

        $role_id = $_GET['role_id'];//修改的角色id

        $role_name = Db::name("carver_role")
            ->where("role_id", $role_id)
            ->value("role_name");//角色名称

        $role_info = Db::name("carver_role_auth")
            ->alias("a")
            ->field("b.auth_id")
            ->leftJoin("carver_auth_new b", "a.auth_id=b.auth_id")
            ->where("a.role_id", $role_id)
            ->select()
            ->toArray();

        $selected_auth = array_column($role_info, "auth_id");//拥有的权限


        $allAuth = Db::name("carver_auth_new")
            ->field("auth_desc as title,auth_id as id,p_id")
            ->where("auth_status", 1)
            ->select()
            ->toArray();

        $getTreeData = $this->getAuthTree($allAuth);//获取全部权限


        return view("admin/upRole", ['data' => json_encode($getTreeData), 'role_name' => $role_name, 'auth' => json_encode($selected_auth), 'role_id' => $role_id]);
    }


    /**
     * @desc 用户列表
     * @author  carver
     */
    public function adminList()
    {
        if ($this->auth_code['auth_code'] == 0) {
            return view("/noAuth");
        }
        //用户列表信息
        $data = Db::name("carver_admin")
            ->alias("b")
            ->field("b.admin_id,b.admin_name,b.admin_email,b.admin_image,b.last_login,b.create_time,b.delete_time,a.role_id")
            ->join("carver_admin_role a", "carver_admin.admin_id=a.admin_id", "left")
            ->where("b.delete_time", 0)
            ->order("b.admin_id", "asc")
            ->paginate(10)
            ->toArray();

        $auth = Db::table('carver_role')->where('current_status', 1)->column("role_name", "role_id");

        foreach ($data['data'] as $key => $item) {
            $data['data'][$key]['role_name'] = $auth[$item['role_id']] ?? '未分配';
        }
        //分页
        $page = new page($data['total'], 10);
        $get_page = $page->fpage();

        return view("admin/adminList", ['data' => $data, 'auth' => $auth, 'page' => $get_page]);


    }

    /**
     * @desc 添加用户
     * @author  carver
     */
    public function addAdmin()
    {
        $auth = Db::name("carver_role")
            ->where(["delete_time" => 0, 'current_status' => 1])
            ->column("role_name", "role_id");

        return view("admin/addAdmin", ['auth' => $auth]);
    }

    /**
     * @desc 处理添加用户信息
     * @author  carver
     */
    public function doAddAdmin()
    {
        $data = input("post.");
        $admin['admin_image'] = "/uploads/" . $data['admin_img'];
        $admin['admin_name'] = $data['admin_name'];
        $admin['admin_pwd'] = md5($data['admin_pwd']);
        $admin['admin_email'] = $data['admin_email'];
        $admin['create_time'] = time();
        //添加用户信息
        $add_admin = CarverAdmin::insert($admin);
        //添加用户类型信息
        $role['admin_id'] = CarverAdmin::getLastInsID();

        $role['role_id'] = $data['auth'];
        $add_role = CarverAdminRole::insert($role);

        if ($add_admin && $add_role) {
            logMsg("admin_add_module");
            $this->success(lang("admin_add_success"), "admin/adminList");
        } else {
            $this->error(lang("admin_add_fail"));
        }
    }

    /**
     * @desc 删除用户
     * @author  carver
     */
    public function delAdmin()
    {
        $id = is_numeric($_GET['admin_id']) ? intval($_GET['admin_id']) : $_GET['admin_id'];

        //删除用户信息
        $del_admin = CarverAdmin::where("admin_id", $id)->update(['delete_time' => time()]);
        //删除用户角色信息
        $del_role = CarverAdminRole::where("admin_id", $id)->update(['delete_time' => time()]);
        if ($del_admin && $del_role) {
            logMsg("admin_delete_module");
            return json(['code' => 1, 'msg' => lang("admin_delete_success")]);
        } else {
            return json(['code' => 1, 'msg' => lang("admin_delete_fail")]);
        }
    }

    /**
     * @desc 修改用户
     * @author  carver
     */
    public function updateAdmin()
    {
        $auth = Db::name("carver_role")->column("role_name", "role_id");
        $update_id = $_GET['admin_id'];

        $role_id = Db::name("carver_admin")
            ->alias("a")
            ->where("a.admin_id", $update_id)
            ->leftJoin("carver_admin_role b", "a.admin_id=b.admin_id")
            ->value("b.role_id");

        $data = CarverAdmin::where("admin_id", $update_id)->find()->toArray();

        return view("admin/updateAdmin", ['auth' => $auth, 'admin_id' => $update_id, 'data' => $data, 'role_id' => $role_id]);
    }

    /**
     * @desc 处理修改用户信息
     * @author  carver
     */
    public function doUpdateAdmin()
    {
        $admin_info = $_POST['admin_info'];//用户信息

        $strInfo = explode("&", urldecode(mb_unserialize($admin_info)));

        $newInfo = array();
        foreach ($strInfo as $key => $value) {
            $strValue = explode("=", $value);
            $newInfo[$strValue[0]] = $strValue[1];
        }

        //修改用户信息
        $new_admin['admin_name'] = $newInfo['admin_name'];
        $new_admin['admin_pwd'] = md5($newInfo['admin_pwd']);
        $new_admin['admin_email'] = $newInfo['admin_email'];
        $new_admin['admin_image'] = "/uploads/" . $newInfo['admin_image'];
        $up_admin = CarverAdmin::where("admin_id", $newInfo['admin_id'])->save($new_admin);
        //删除用户角色信息
        $new_role['role_id'] = is_numeric($newInfo['auth']) ? intval($newInfo['auth']) : $newInfo['auth'];
        CarverAdminRole::where("admin_id", $newInfo['admin_id'])->save($new_role);
        if ($up_admin !== false) {
            logMsg("admin_update_module");
            if ($newInfo['admin_id'] == session("admin_id")) {
                session("admin_id", null);
                return json(['code' => 2, 'msg' => lang("admin_update_ok")]);
            }
            return json(['code' => 1, 'msg' => lang("admin_update_success")]);
        } else {
            return json(['code' => 0, 'msg' => lang("admin_update_fail")]);
        }
    }


    /**
     * @desc 上传类
     * @author Carver
     */
    public function uploadInfo(Request $request)
    {
        $qiniuFile = $_FILES['file'];
        $localFile = $request->file("file");
        $info = UploadFile::upLocal($localFile);//调用上传类
        if ($info['code'] == 1) {
            return json(['code' => 1, 'msg' => '上传成功!', 'data' => $info['data']]);
        } else {
            return json(['code' => 0, 'msg' => '上传失败!', 'data' => null]);
        }
    }


}
