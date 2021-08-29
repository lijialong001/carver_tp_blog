<?php
declare (strict_types=1);

namespace app\admin\controller;

use app\admin\model\CarverArticle;
use app\admin\model\CarverNavigation;
use app\admin\model\CarverOperateLog;
use app\BaseController;
use think\App;
use think\facade\Db;
use think\facade\Lang;
use page\page;
use think\Request;

class Article extends BaseController
{
    protected $auth_code;

    public function __construct(App $app, Request $request)
    {
        $this->auth_code = parent::__construct($app);
        Lang::load(base_path() . 'admin/lang/' . config('lang.default_lang') . '/article.lang.php');
    }


    /**
     * @desc 文章列表页面
     * @author Carver
     */
    public function articleList()
    {
        if ($this->auth_code['auth_code'] == 0) {
            return view("/noAuth");
        }

        $guide_info = Db::name("carver_navigation")->column("nav_name", "nav_id");

        $articleList = Db::name("carver_article")
            ->field("article_id,article_title,article_guide,article_label,article_desc,article_content,article_img,is_show,is_top_show,click_num,FROM_UNIXTIME(update_time,'%Y-%m-%d %H:%i:%s') as update_time,add_time,delete_time")
            ->where("delete_time", 0)
            ->order("add_time", "desc")
            ->paginate(10)
            ->toArray();

        foreach ($articleList['data'] as $key => $value) {
            $articleList['data'][$key]['labels'] = array_filter(explode(";", $value['article_label']));
        }

        //分页
        $page = new page($articleList['total'], 10);
        $get_page = $page->fpage();

        return view("article/articleList", ['data' => $articleList, 'page' => $get_page, 'guide_info' => $guide_info]);
    }


    /**
     * @desc 添加文章页面
     * @author Carver
     */
    public function addArticle()
    {
        $currentActionId = session("admin_id");
        $currentName = Db::name("carver_admin")
            ->alias("a")
            ->where("a.admin_id", $currentActionId)
            ->join("carver_admin_role r", "a.admin_id=r.admin_id")
            ->join("carver_role g", "r.role_id=g.role_id")
            ->value("g.role_name");
        if ($currentName == '超级管理员') {
            $navigations = CarverNavigation::where("is_show", 1)->where("p_id", "<>", 0)->select()->toArray();

            return view("article/addArticle", ['navigations' => $navigations]);
        } else {
            return json("请联系超级管理员执行该操作！");
        }


    }

    /**
     * @desc 处理添加文章数据
     * @author Carver
     */
    public function doAddArticle()
    {
        $data = $_POST;
        $res['article_title'] = $data['article_title'];
        $res['article_label'] = trim($data['article_label'], ";");
        $res['article_desc'] = $data['article_desc'];
        $res['article_content'] = $data['article_content'];
        $res['article_guide'] = $data['article_guide'];
        $res['click_num'] = $data['click_num'];
        $res['article_img'] = $data['article_img'] ?? "";
        $res['is_show'] = is_numeric($data['is_show']) ? intval($data['is_show']) : $data['is_show'];
        $res['is_top_show'] = is_numeric($data['is_top_show']) ? intval($data['is_top_show']) : $data['is_top_show'];
        $res['article_author'] = session("admin_name");
        $res['add_time'] = time();
        $res['update_time'] = time();
        $addArticleResult = CarverArticle::insert($res);
        if ($addArticleResult) {
            logMsg("article_add_module");
            return json(['code' => 1, 'msg' => lang("article_add_success")]);
        } else {
            return json(['code' => 0, 'msg' => lang("article_add_fail")]);
        }

    }

    /**
     * @desc 删除文章
     * @author  carver
     */
    public function delArticle()
    {
        $currentActionId = session("admin_id");
        $currentName = Db::name("carver_admin")
            ->alias("a")
            ->where("a.admin_id", $currentActionId)
            ->join("carver_admin_role r", "a.admin_id=r.admin_id")
            ->join("carver_role g", "r.role_id=g.role_id")
            ->value("g.role_name");

        if ($currentName == '超级管理员') {
            $id = is_numeric($_GET['article_id']) ? intval($_GET['article_id']) : $_GET['article_id'];

            $del_result = CarverArticle::where("article_id", $id)->update(['delete_time' => time()]);
            if ($del_result) {
                logMsg("article_delete_module");
                return json(['code' => 1, 'msg' => lang("article_delete_success")]);
            } else {
                return json(['code' => 0, 'msg' => lang("article_delete_fail")]);
            }
        } else {
            return json(['code' => 0, 'msg' => "请联系超级管理员执行该操作！"]);
        }


    }


    /**
     * @desc 处理修改文章
     * @author  carver
     */
    public function doEditArticle()
    {
        $data = $_POST;
        $upInfo['article_id'] = $data['article_id'];
        $upInfo['article_title'] = $data['article_title'];
        $upInfo['article_desc'] = $data['article_desc'];
        $upInfo['article_content'] = $data['article_content'];
        $upInfo['article_guide'] = $data['article_guide'];
        $upInfo['article_label'] = trim($data['article_label'], ";");
        $upInfo['article_img'] = $data['article_img'] ?? '';
        $upInfo['is_show'] = intval($data['is_show']);
        $upInfo['click_num'] = intval($data['click_num']);
        $upInfo['is_top_show'] = intval($data['is_top_show']);
        $upInfo['update_time'] = time();
        $upResult = CarverArticle::where("article_id", $data['article_id'])->update($upInfo);
        if ($upResult) {
            return json(['code' => 1, 'msg' => "修改成功!"]);
        } else {
            return json(['code' => 0, 'msg' => "修改失败!"]);
        }

    }

    /**
     * @desc 修改文章
     * @author Carver
     */
    public function editArticle()
    {

        $currentActionId = session("admin_id");
        $currentName = Db::name("carver_admin")
            ->alias("a")
            ->where("a.admin_id", $currentActionId)
            ->join("carver_admin_role r", "a.admin_id=r.admin_id")
            ->join("carver_role g", "r.role_id=g.role_id")
            ->value("g.role_name");

        if ($currentName == '超级管理员') {
            $article_id = intval($_GET['id']);//文章id
            $navigations = CarverNavigation::where("is_show", 1)->where("p_id", "<>", 0)->select()->toArray();
            $data = Db::name("carver_article")
                ->where("article_id", $article_id)
                ->field("article_id,article_title,article_guide,article_label,article_desc,article_content,article_img,is_show,is_top_show,click_num,FROM_UNIXTIME(update_time,'%Y-%m-%d %H:%i:%s') as update_time")
                ->findOrEmpty();

            return view("article/editArticle", ['navigations' => $navigations, 'data' => $data]);
        } else {
            return json("请联系超级管理员执行该操作！");
        }


    }


}
