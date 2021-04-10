<?php
declare (strict_types=1);

namespace app\web\controller;

use think\facade\Db;
use think\facade\Session;
use think\facade\View;
use think\Request;
use app\admin\model\CarverArticle;
use app\web\model\CarverUser;
use app\web\model\CarverNavigation;
use app\admin\model\CarverLink;
use app\admin\model\CarverNotice;
use page\page;
use app\facade\Lang;


class LoginUser
{
    protected $user;

    public function __construct()
    {
        $this->user = new CarverUser();
//        Lang::load(base_path() . 'web/lang/' . config('lang.default_lang') . '/admin.lang.php');
    }

    /**
     * @desc 前台用户注册
     * @author  Carver
     * @date 2020-07-22
     */
    public function index()
    {
        return \view("/loginUser/loginRegister");
    }


    /**
     * @desc 前台用户注册处理数据
     * @author  Carver
     * @date 2020-07-22
     */
    public function doRegister()
    {
        $data['user_name'] = $_POST['user_name'];
        $data['user_email'] = $_POST['user_email'];
        $data['user_pwd'] = md5($_POST['user_pwd']);
        $user_res = $this->user->insert($data);
        if ($user_res) {
            return ['code' => 1, 'msg' => lang("user_register_success"), 'data' => $user_res];
        } else {
            return ['code' => 0, 'msg' => lang("user_register_fail"), 'data' => $user_res];
        }

    }

    /**
     * @desc 前台用户登录处理数据
     * @author  Carver
     * @date 2020-07-22
     */
    public function doLogin()
    {
        $data['user_name'] = $_POST['user_name'];
        $data['user_pwd'] = md5($_POST['user_pwd']);
        $user_res = $this->user->where($data)->find();
        if ($user_res) {
            session("user_name", $data['user_name']);
            session("user_id", $user_res['user_id']);
            return ['code' => 1, 'msg' => lang("user_login_success"), 'data' => null];
        } else {
            return ['code' => 0, 'msg' => lang("user_login_fail"), 'data' => null];
        }
    }

    /**
     * @return \think\response\View
     * @desc 退出登录
     */
    public function outLogin()
    {
        Session::delete("user_name");
        Session::delete("user_id");
        return \view("/loginUser/loginRegister");
    }

    /**
     * @desc 前台用户登录成功的首页
     * @author  Carver
     * @date 2020-07-22
     */
    public function userIndex()
    {
        //左侧文章列表
        $articles = CarverArticle::
        field("article_id,article_title,article_desc,article_content,article_img,article_guide,article_label,click_num,is_show,add_time,article_author,is_top_show")
            ->where("delete_time", 0)
            ->order("article_id", "desc")
            ->paginate(6)
            ->toArray();

        $count = $articles['total'];//总条数

        //分页
        $page = new page($count, 6);
        $get_page = $page->fpage();

        //博客名
        $blog_name = config("common.blog_name");

        //通过点击量进行排行
        $click_articles = CarverArticle::
        field("article_id,article_title,click_num,FROM_UNIXTIME(add_time,'%Y-%m-%d') as add_time")
            ->order("click_num desc")
            ->limit(3)->select()->toArray();


        //公告列表
        $notice = CarverNotice::field("*")->order("create_time", "desc")->limit(3)->select()->toArray();

        //导航栏
        $navigateInfo = CarverNavigation::select()->order("sort", "asc")->toArray();
        $navigateRes = array();
        if ($navigateInfo) {
            $navigateRes = $this->getNavigateTree($navigateInfo);
        }

        //友情链接
        $links = CarverLink::where("is_confirm=2")->limit(20)->select()->toArray();

        //文章标签
        $label = Db::name("carver_article")->column("article_label");
        $label_info = array();
        foreach ($label as $key => $value) {
            $label_info[] = explode(";", $value);
        }
        $temp = array();
        foreach ($label_info as $item) {
            foreach ($item as $k => $v) {
                $temp[] = $v;
            }
        }
        $all_label = array_unique($temp);


        //显示的轮播图
        $carouse = Db::name("carver_carouse")
            ->where("is_show", 1)
            ->order("carouse_sort", "desc")
            ->limit(3)
            ->column("carouse_img,carouse_desc");

        //个人资料
        $self = Db::name("carver_site")
            ->select()->toArray();

        return \view("article/articleIndex", ['articles' => $articles, 'blog_name' => $blog_name, 'click_articles' =>
            $click_articles, 'links' => $links, "notice" => $notice, "navigate" => $navigateRes, "label" => $all_label, "page" => $get_page, "carouse" => $carouse, "self" => $self]);
    }

    //递归
    public function getNavigateTree($array)
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

}