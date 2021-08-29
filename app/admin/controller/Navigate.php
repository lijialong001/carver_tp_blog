<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\BaseController;
use app\admin\model\CarverNavigation;
use think\App;
use think\facade\Db;
use page\page;
use think\Request;

class Navigate extends BaseController
{
    protected $auth_code;

    public function __construct(App $app, Request $request)
    {
        $this->auth_code = parent::__construct($app);
    }

    /**
     * @desc 前台导航列表
     * @author Carver
     */
    public function navigateList()
    {
        if ($this->auth_code['auth_code'] == 0) {
            return view("/noAuth");
        }
        $result = CarverNavigation::select()->toArray();
        $data = self::getNavigateTree($result);
        return view("navigate/navigateList", ['data' => $data]);
    }

    //递归
    public static function getNavigateTree($array)
    {

        $items = array();
        foreach ($array as $value) {
            $items[$value['nav_id']] = $value;
        }

        $tree = array();
        foreach ($items as $key => $value) {
            if (isset($items[$value['p_id']])) {
                $items[$value['p_id']]['son'][] = &$items[$key];
            } else {
                $tree[] = &$items[$key];
            }
        }
        return $tree;
    }

    /**
     * @desc 添加前台导航
     * @author Carver
     */
    public function addNavigate()
    {
        $result = Db::name("carver_navigation")->where(["p_id" => 0, "is_show" => 1])->order("sort")->select()->toArray();
        return view("navigate/addNavigate", ['data' => $result]);
    }

    /**
     * @desc 处理添加前台导航
     * @author Carver
     */
    public function doAddNavigate()
    {
        $data['p_id'] = intval($_POST['navigate_name_parent']);
        $data['sort'] = intval($_POST['sort']);
        $data['is_show'] = intval($_POST['is_show']);
        $data['nav_name'] = $_POST['navigate_name'];
        $data['create_time'] = time();
        $result = Db::name("carver_navigation")->insert($data);
        if ($result) {
            return json(['code' => 1, 'msg' => "添加成功!", 'data' => $result]);
        } else {
            return json(['code' => 0, "msg" => "添加失败!", 'data' => null]);
        }

    }

    /**
     * @desc 前台轮播图列表
     * @author Carver
     */
    public function carouseList()
    {
        if ($this->auth_code['auth_code'] == 0) {
            return view("/noAuth");
        }
        $data = Db::name("carver_carouse")->where("delete_time", 0)->field("carouse_id,carouse_img,carouse_desc,carouse_sort,is_show,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as create_time")->paginate(8);

        return view("navigate/carouseList", ['data' => $data]);
    }

    /**
     * @desc 添加轮播图
     * @author Carver
     */
    public function addCarouse()
    {
        $data = Db::name("carver_carouse")->select()->toArray();
        return view("navigate/addCarouse");
    }

    /**
     * @desc 处理添加轮播图
     * @author Carver
     */
    public function doAddCarouse()
    {
        $data['carouse_img'] = $_POST['carouse_img'] ?? '';
        $data['carouse_desc'] = $_POST['carouse_desc'] ?? '';
        $data['carouse_sort'] = is_numeric($_POST['carouse_sort']) ? intval($_POST['carouse_sort']) : $_POST['carouse_sort'];
        $data['is_show'] = isset($_POST['is_show']) ? is_numeric($_POST['is_show']) ? intval($_POST['is_show']) : $_POST['is_show'] : 0;
        $data['create_time'] = time();

        $res = Db::name("carver_carouse")->insert($data);
        if ($res) {
            return json(['code' => 1, 'msg' => '轮播图信息添加成功!']);
        } else {
            return json(['code' => 0, 'msg' => '轮播图信息添加失败!']);
        }
    }

    /**
     * @desc 修改轮播显示状态
     * @author Carver
     */
    public function upCarouse()
    {
        $carouse_id = is_numeric($_POST['id']) ? intval($_POST['id']) : $_POST['id'];
        $is_show = is_numeric($_POST['is_on']) ? intval($_POST['is_on']) : $_POST['is_on'];
        $upRes = Db::name("carver_carouse")->where('carouse_id', $carouse_id)->update(['is_show' => $is_show]);
        if ($upRes) {
            return json(['code' => 1, 'msg' => '修改成功!']);
        } else {
            return json(['code' => 0, 'msg' => '修改失败!']);
        }
    }

    /**
     * @desc 更改轮播图简介
     * @author Carver
     */
    public function upCarouseDesc()
    {
        $carouse_id = is_numeric($_POST['id']) ? intval($_POST['id']) : $_POST['id'];
        $desc = $_POST['content'];
        $data = Db::name("carver_carouse")->where('carouse_id', $carouse_id)->update(['carouse_desc' => $desc]);
        if ($data) {
            return json(['code' => 1, 'msg' => '修改成功!']);
        } else {
            return json(['code' => 0, 'msg' => '请点击修改内容!']);
        }
    }

    /**
     * @desc 删除前台轮播图
     * @author Carver
     */
    public function deleteCarouse()
    {
        $currentActionId = session("admin_id");
        $currentName = Db::name("carver_admin")
            ->alias("a")
            ->where("a.admin_id", $currentActionId)
            ->join("carver_admin_role r", "a.admin_id=r.admin_id")
            ->join("carver_role g", "r.role_id=g.role_id")
            ->value("g.role_name");

        if ($currentName == '超级管理员') {
            $carouse_id = is_numeric($_POST['id']) ? intval($_POST['id']) : $_POST['id'];

            $data = Db::name("carver_carouse")->where('carouse_id', $carouse_id)->update(['delete_time' => time()]);
            if ($data) {
                return json(['code' => 1, 'msg' => '删除成功!']);
            } else {
                return json(['code' => 0, 'msg' => '删除失败!']);
            }
        } else {
            return json(['code' => 0, 'msg' => '请联系超级管理员执行该操作!']);
        }


    }


}
