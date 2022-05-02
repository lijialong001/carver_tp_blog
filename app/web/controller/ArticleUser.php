<?php
declare (strict_types=1);

namespace app\web\controller;

use app\web\model\CarverArticle;
use app\admin\model\CarverLink;
use app\admin\model\CarverNotice;
use app\web\model\CarverNavigation;
use app\web\model\CarverComment;
use app\web\model\CarverCommentToOthers;
use think\facade\Db;
use think\facade\Session;
use think\Request;
use think\View;
use page\page;

class ArticleUser
{
    protected $title;

    /**
     * @desc 文章详情
     * @author Carver
     */
    public function articleDetail()
    {
        $article_id = $_GET['article_id'];
        Session::delete("click_num_api");
        //左侧文章详情
        $article_info = CarverArticle::where("article_id", $article_id)
            ->field("article_id,article_title,article_desc,article_content,article_img,article_guide,article_label,click_num,is_show,add_time,article_author")
            ->find()
            ->toArray();

        //上一篇和下一篇文章
        if (isset($article_id) && $article_id) {
            $pre_article = CarverArticle::where("article_id", ">", $article_id)
                ->field("article_id,article_title,article_desc,article_content,article_img,article_guide,article_label,click_num,is_show,add_time,article_author")
                ->find();

            $next_article = CarverArticle::where("article_id", "<", $article_id)
                ->field("article_id,article_title,article_desc,article_content,article_img,article_guide,article_label,click_num,is_show,add_time,article_author")
                ->order("article_id", "desc")
                ->find();

            $preArticle = $pre_article['article_title'] ?? '没有啦!';
            $nextArticle = $next_article['article_title'] ?? '没有啦!';
        } else {
            $preArticle = "没有啦!";
            $nextArticle = "没有啦!";
        }

        //友情链接
        $links = CarverLink::where("is_confirm=2")->limit(20)->select();

        //通过点击量进行排行
        $click_articles = CarverArticle::field("article_id,article_title,click_num,FROM_UNIXTIME(add_time,'%Y-%m-%d') as add_time")
            ->order("click_num desc")
            ->limit(3)
            ->select()
            ->toArray();

        //文章评论
        $commentData = Db::name("carver_comment")
            ->alias("a")
            ->field("a.*,b.user_name")
            ->where("article_id", $article_id)
            ->Join("carver_user b", "a.user_id=b.user_id")
            ->order("create_time", 'desc')
            ->select()
            ->toArray();

        $commentContent = Db::name("carver_comment_to_others")->select()->toArray();//多级评论

        $result = array();
        $field = array_unique(array_column($commentContent, "comment_id"));

        if ($commentContent) {//是否存在多级评论
            foreach ($commentContent as $k => $v) {
                $v['user_name'] = Db::name("carver_user")->where("user_id", $v['comment_user_id'])->value("user_name");
                foreach ($field as $fieldKey => $fieldValue) {
                    if ($v['comment_id'] == $fieldValue) {
                        $result[$fieldValue][] = $v;
                    }
                }
            }
        }


        foreach ($commentData as $commentKey => &$commentValue) {
            if ($result) {
                foreach ($result as $resKey => $resValue) {
                    if ($commentValue['comment_id'] == $resKey) {
                        $commentValue['tips'][] = $resValue;
                        $commentValue['son'] = [];
                    } else {
                        $commentValue['tips'][] = [];
                        $commentValue['son'] = [];
                    }
                }
            } else {
                $commentValue['tips'][] = [];
                $commentValue['son'] = [];
            }

        }

        foreach ($commentData as $startKey => &$endValue) {
            if ($endValue['tips']) {
                foreach ($endValue['tips'] as $item) {
                    foreach ($item as $itemKey => $itemValue) {
                        $endValue['son'][] = $itemValue;
                    }
                }
            }
        }

        $user_all = Db::name("carver_user")->cache("user_info", 120)->column("user_name", "user_id");

        //导航栏
        $navigateInfo = CarverNavigation::select()->order("sort", "asc")->toArray();
        $navigateRes = array();
        if ($navigateInfo) {
            $navigateRes = $this->getNavigateTree($navigateInfo);
        }

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

        return \view("article/articleDetail", ['click_articles' => $click_articles, 'article_info' => $article_info,
            'pre_article' => $preArticle, 'next_article' => $nextArticle, 'links' => $links, 'comments' => $commentData, "navigate" => $navigateRes, "label" => $all_label, "user_all" => $user_all]);
    }

    /**
     * @desc 用户点赞
     * @author Carver
     */
    public function clickPrize()
    {

        $article_id = $_GET['article_id'];
        $key_time = $_GET['key_time'];

        if (!session("user_id")) {
            return json(['code' => 0, 'msg' => '请先登录!']);
        }

        $click_time = Db::name("carver_user_click")->where(["user_id" => session("user_id"), "article_id" => $article_id])->findOrEmpty();

        if ($click_time) {
            if (time() - $click_time['click_time'] < 86400) {
                return json(['code' => 0, 'msg' => '今天已经点赞过啦!']);
            }
        }

        session("click_num_api", session("click_num_api") + 1);


        if (session("click_num_api") > 3) {
            return json(['code' => 0, 'msg' => '点击太频繁!']);
        }

        if (time() - $key_time > 60) {
            return json(['code' => 0, 'msg' => '重新访问当前页面!']);
        }


        //文章是否被点击

        if ($article_id) {
            $lastClickInfo = Db::name("carver_user_click")->where(["user_id" => session("user_id"), "article_id" => $article_id])->findOrEmpty();
            if ($lastClickInfo) {

                $diffTime = time() - $lastClickInfo['click_time'];

                if ($diffTime > 86400) {//一天只能点赞一次
                    Db::name("carver_user_click")->where(["user_id" => session("user_id"), "article_id" => $article_id])->update(['click_time' => time(), 'update_time' => time()]);
                    Db::table('carver_article')->where('article_id', $article_id)->inc('click_num', 1)->update();
                    return json(['code' => 1, 'msg' => '点赞成功!']);
                } else {
                    return json(['code' => 0, 'msg' => '明天再来吧~']);
                }

            } else {
                $isAddUser = Db::name("carver_user_click")->insert(
                    [
                        'user_id' => session("user_id"),
                        'click_time' => time(),
                        'article_id' => $article_id,
                        'create_time' => time()
                    ]
                );
                if ($isAddUser) {
                    Db::table('carver_article')->where('article_id', $article_id)->inc('click_num', 1)->update();
                }
                return json(['code' => 1, 'msg' => '点赞成功!']);
            }
        }
    }

    /**
     * @desc 发布评论
     * @author Carver
     */
    public function addComment()
    {
        $data['article_id'] = $_POST['article_id'];
        $data['comment_content'] = $_POST['comment_content'];
        $data['user_id'] = session("user_id");
        $data['create_time'] = time();
        $result = CarverComment::insert($data);
        if ($result) {
            return json(['code' => 1, 'msg' => '发布成功!']);
        } else {
            return json(['code' => 0, 'msg' => '发布失败!']);
        }

    }

    /**
     * @desc 查看评论的权限
     * @author Carver
     */
    public function searchRepeatUser()
    {
        if ($_POST['user_id'] == session("user_id")) {
            return json(['code' => -1, 'msg' => '您不能给自己评论!']);
        }

        if (!session("user_id")) {
            return json(['code' => -1, 'msg' => '请先登录!']);
        }

        $newData['comment_id'] = $_POST['comment_id'];
        $newData['comment_user_id'] = session("user_id");
        $newData['article_id'] = $_POST['article_id'];
        $newData['comment_to_content'] = $_POST['comment_content'];
        $newData['comment_to_user_id'] = $_POST['user_id'];//被回复的用户id
        $newData['create_time'] = time();
        $resultData = CarverCommentToOthers::insert($newData);
        if ($resultData) {
            return json(['code' => 1, 'msg' => '评论回复成功!']);
        } else {
            return json(['code' => 0, 'msg' => '评论回复失败!']);
        }
    }

    /**
     * @desc 搜索文章
     * @author Carver
     */
    public function searchArticle()
    {
        $this->title = $_GET['article_title'] ?? '';
        $searchResult = Db::name("carver_article")->whereLike('article_title', "%{$this->title}%")->where(["delete_time" => 0, "is_show" => 1])->paginate(6)->toArray();
        $count = $searchResult['total'];//总条数
        //分页
        $page = new page($count, 6);
        $get_page = $page->fpage();

        //博客名
        $blog_name = config("common.blog_name");

        //通过点击量进行排行
        $click_articles = CarverArticle::
        field("article_id,article_title,click_num,FROM_UNIXTIME(add_time,'%Y-%m-%d') as add_time")
            ->where(["delete_time" => 0, "is_show" => 1])
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
        $links = CarverLink::where("is_confirm=2")->limit(20)->select();

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

        return \view("article/searchArticle", ['articles' => $searchResult, 'blog_name' => $blog_name, 'click_articles' =>
            $click_articles, 'links' => $links, "notice" => $notice, 'page' => $get_page, "navigate" => $navigateRes, 'label' => $all_label, 'carouse' => $carouse, 'self' => $self]);

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


    /**
     * @desc 搜索导航栏主题的文章
     * @author Carver
     */
    public function searchLabel()
    {
        $nav_id = $_GET['nav_id'];
        $searchResult = Db::name("carver_article")->where(["article_guide" => $nav_id, "delete_time" => 0, "is_show" => 1])->order("add_time", "desc")->paginate(6)->toArray();
        $count = $searchResult['total'];//总条数
        //分页
        $page = new page($count, 6);
        $get_page = $page->fpage();

        //博客名
        $blog_name = config("common.blog_name");

        //通过点击量进行排行
        $click_articles = CarverArticle::
        field("article_id,article_title,click_num,FROM_UNIXTIME(add_time,'%Y-%m-%d') as add_time")
            ->where(["is_show" => 1, "delete_time" => 0])
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

        //文章标签
        $label = Db::name("carver_article")->column("article_label");

        $label_info = array();
        foreach ($label as $key => $value) {
            $label_info[] = explode(",", $value);
        }
        $temp = array();
        foreach ($label_info as $item) {
            foreach ($item as $k => $v) {
                $temp[] = $v;
            }
        }
        $all_label_info = array_unique($temp);
        $tempLabel=array();
        $resultLabel=array();
        foreach ($all_label_info as $allKey => $allValue){
            $tempLabel[]=explode(";",$allValue);
        }
        foreach ($tempLabel as $labelKey => $labelValue){
            foreach ($labelValue as $labelItem){
                $resultLabel[]=$labelItem;
            }

        }
        $all_label=array_unique($resultLabel);


        //显示的轮播图
        $carouse = Db::name("carver_carouse")
            ->where("is_show", 1)
            ->order("carouse_sort", "desc")
            ->limit(3)
            ->column("carouse_img,carouse_desc");

        //友情链接
        $links = CarverLink::where("is_confirm=2")->limit(20)->select();

        //个人资料
        $self = Db::name("carver_site")
            ->select()->toArray();

        return \view("article/searchArticle", ['articles' => $searchResult, 'blog_name' => $blog_name, 'click_articles' =>
            $click_articles, 'links' => $links, "notice" => $notice, 'page' => $get_page, "navigate" => $navigateRes, "label" => $all_label, 'carouse' => $carouse, 'self' => $self]);

    }


    /**
     * @desc 搜索文章标签
     * @author Carver
     */
    public function searchArticleLabel()
    {

        $label = $_GET['label'];
        $searchResult = Db::name("carver_article")->whereLike("article_label", "%{$label}%")->where(["delete_time" => 0, "is_show" => 1])->paginate(6)->toArray();

        $count = $searchResult['total'];//总条数
        //分页
        $page = new page($count, 6);
        $get_page = $page->fpage();

        //博客名
        $blog_name = config("common.blog_name");

        //通过点击量进行排行
        $click_articles = CarverArticle::
        field("article_id,article_title,click_num,FROM_UNIXTIME(add_time,'%Y-%m-%d') as add_time")
            ->where(["is_show" => 1, "delete_time" => 0])
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
        $links = CarverLink::where("is_confirm=2")->limit(20)->select();

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

        return \view("article/searchArticle", ['articles' => $searchResult, 'blog_name' => $blog_name, 'click_articles' =>
            $click_articles, 'links' => $links, "notice" => $notice, 'page' => $get_page, "navigate" => $navigateRes, "label" => $all_label, 'carouse' => $carouse, 'self' => $self]);

    }


    /**
     * @desc 申请友情页面
     * @author Carver
     */
    public function addLink()
    {
        return view("link/addLink");
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
        $res['is_doc'] = $form_data['is_doc'];
        $result = CarverLink::insert($res);
        if ($result === false) {
            return json(['code' => 0, 'msg' => lang("link_apply_fail")]);
        }

        return json(['code' => 1, 'msg' => lang("link_apply_confirm")]);
    }
    
    /**
     * @desc 在线文档
     * @author Carver
     */
    public function onDoc()
    {
        $searchResult = Db::name("carver_link")->where(["delete_time" => null, "is_doc" => 0])->paginate(20)->toArray();
      

        $count = $searchResult['total'];//总条数
        //分页
        $page = new page($count, 20);
        $get_page = $page->fpage();

        //博客名
        $blog_name = config("common.blog_name");

        //通过点击量进行排行
        $click_articles = CarverArticle::
        field("article_id,article_title,click_num,FROM_UNIXTIME(add_time,'%Y-%m-%d') as add_time")
            ->where(["is_show" => 1, "delete_time" => 0])
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
        $links = CarverLink::where("is_confirm=2")->limit(20)->select();

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


        return \view("article/onDoc", ['articles' => $searchResult, 'blog_name' => $blog_name, 'click_articles' =>
            $click_articles, 'links' => $links, "notice" => $notice, 'page' => $get_page, "navigate" => $navigateRes, "label" => $all_label, 'carouse' => $carouse, 'self' => $self]);
    }

}
