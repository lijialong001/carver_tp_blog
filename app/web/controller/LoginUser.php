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
    protected $defaultConfig=[];
    protected $apiUrl;

    public function __construct()
    {
        $userIpAddress=$_SERVER['REMOTE_ADDR'];
        $this->apiUrl = 'http://ip-api.com/json/'.$userIpAddress.'?lang=zh-CN';
        $userJsonInfo=getUserIpInfo($this->apiUrl);
        setUserClickInfo($userJsonInfo);
        $this->user = new CarverUser();
        $this->defaultConfig = [
            'query'     =>  input(), //url额外参数
            'fragment'  => '', //url锚点
            'var_page'  => 'page', //分页变量
            'list_rows' => 6, //每页数量
        ];
    }

    /**
     * @desc 前台用户注册
     * @author  Carver
     */
    public function index()
    {
        return \view("/loginUser/loginRegister");
    }


    /**
     * @desc 前台用户注册处理数据
     * @author  Carver
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
        
        
        try {
            DB::beginTransaction();
             
            $data= input();
             
            if(empty($data['user_name']) || empty($data['user_pwd'])){
                DB::rollBack();
                return ['code' => 0, 'msg' => "账号或密码不能为空～", 'data' => null];
            }
            //验证账号是否存在
            $userInfo=$this->user->where(['user_name'=>$data['user_name']])->first();
            
            if($userInfo){
                DB::rollBack();
                return ['code' => 0, 'msg' => "该账号已经被占用～", 'data' => null];
            }

            
            $addUserInfo['user_name']=$data['user_account'];
            $addUserInfo['user_pwd']=md5($data['user_pwd']);
            $addUserInfo['ip']=get_client_ip();
            $addUserInfo['add_time']=time();
            $resData=$this->user->insert($addUserInfo);

            DB::commit();
            return ['code' => 1, 'msg' => "注册成功～", 'data' => $resData];


        }catch (\Exception $e){
            return ['code' => 0, 'msg' => "系统错误～", 'data' => null];
        }
        
        

    }

    /**
     * @desc 前台用户登录处理数据
     * @author  Carver
     */
    public function doLogin()
    {
        try {
            Db::startTrans();
            $data=input();

            if(empty($data['user_name']) || empty($data['user_pwd'])){
                DB::rollBack();
                return ['code' => 0, 'msg' => "账号或密码不能为空～", 'data' => null];
            }
            //验证账号是否存在
            $userInfo = $this->user->where(['user_name'=>$data['user_name']])->find();
            if(!$userInfo){
                DB::rollBack();
                return ['code' => 0, 'msg' => "账号不存在～", 'data' => null];
            }


            //账号是否被锁定🔒
            if($userInfo->is_lock){
                DB::rollBack();
                return ['code' => 0, 'msg' => "您的账号已被锁定～", 'data' => null];
            }

        
            //验证密码
            $userVeryPwd=md5($data['user_pwd']) == $userInfo->user_pwd ? true:false;
            
            if(!$userVeryPwd){
                DB::rollBack();
                return ['code' => 0, 'msg' => "密码不正确～", 'data' => null];
            }

            $upUserInfo['ip']=get_client_ip();
        
            $this->user->where("user_id",$userInfo->id)->update($upUserInfo);
            
            session("user_name", $userInfo['user_name']);
            session("user_id", $userInfo['user_id']);
            
            DB::commit();
            return ['code' => 1, 'msg' => "登录成功～", 'data' => null];


        }catch (\Exception $e){
            return ['code' => 0, 'msg' => "系统错误～", 'data' => null];
        }
        
        
    }

    /**
     * @desc 忘记密码
     * @author Carver
     */
    public function forgetPwd()
    {

        $email = trim($_POST['user_email']);
        $pwd = trim($_POST['user_pwd']);
        $req = $this->user->where("user_email", $email)->findOrEmpty();

        if ($req) {
            $req->user_pwd = md5($pwd);
            $result = $req->save();
            if ($result) {
                return ['code' => 1, 'msg' => "修改成功，请重新登录 ~", 'data' => null];
            }
        } else {
            return ['code' => 0, 'msg' => "请确认邮箱是否正确 ~", 'data' => null];
        }
    }

    /**
     * @desc 退出登录
     * @author Carver
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
     */
    public function userIndex()
    {
        //左侧文章列表
        $articles = CarverArticle::alias("c")->
        field("article_id,article_title,article_desc,article_content,article_img,article_guide,article_label,click_num,c.is_show,add_time,article_author,is_top_show")
            ->join("carver_navigation n","c.article_guide=n.nav_id")
            ->where("n.p_id",1)
            ->where(["c.delete_time" => 0,"c.is_show"=>1])
            ->order("c.article_id", "desc")
            ->paginate($this->defaultConfig,false)->each(function($item,$key){
                $item['article_label']=explode(";",$item['article_label']);
            });
            
            // ->toArray();

        // $count = $articles['total'];//总条数

        //分页
        // $page = new page($count, 6);
        // $get_page = $page->fpage();

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
        $links = CarverLink::where("is_confirm=2")->where("is_doc=1")->limit(20)->select()->toArray();

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
            $click_articles, 'links' => $links, "notice" => $notice, "navigate" => $navigateRes, "label" => $all_label, "carouse" => $carouse, "self" => $self]);
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
