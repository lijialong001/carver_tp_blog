<?php
declare (strict_types=1);

namespace app\admin\controller;

use AlibabaCloud\Dbs\Dbs;
use app\BaseController;
use think\App;
use think\Exception;
use think\facade\Cache;
use think\facade\View;
use app\admin\model\CarverAdmin;
use app\admin\model\CarverRole;
use app\admin\model\CarverAdminRole;
use app\admin\model\CarverAuth;
use app\admin\model\CarverRoleAuth;
use app\admin\model\CarverArticle;
use app\admin\model\CarverLink;
use app\admin\model\CarverComment;
use app\web\model\CarverUser;
use think\Request;
use think\facade\Db;

class Index extends BaseController
{
    protected $auth_code;

    //初始化数据
    public function __construct(App $app, Request $request)
    {
        $this->auth_code = parent::__construct($app);
    }

    /**
     * @desc 退出登录
     * @author  Carver
     */
    public function outLogin()
    {

        $req = session("admin_id", null);
        if (is_null($req)) {
            $this->success("退出成功,请稍后...", "Login/login");
        }
    }

    /**
     * @desc 登录后的首页
     * @author  Carver
     */
    public function adminIndex()
    {

        if ($this->auth_code['auth_code'] == 1) {
            $data['ip'] = getLocalIp();//服务器地址ip
            $data['host_name'] = $_SERVER['SERVER_NAME'];//服务器域名
            $data['server_port'] = $_SERVER['SERVER_PORT'];//服务web端口
            $data['php_version'] = PHP_VERSION;//php版本
            $data['system_info'] = php_uname('s');//操作系统类型
            $data['php_run_method'] = php_sapi_name();//php运行模式
            $data['web_server'] = $_SERVER['SERVER_SOFTWARE'];//获取服务器解译引擎
            $data['http_info'] = $_SERVER['SERVER_PROTOCOL'];//获取请求页面时通信协议的名称和版本
            
            //评论数
            $comment_count = CarverComment::getInstance()->getCommentCount();
            $data['comment_count'] = $comment_count;
            
            //文章数
            $article_count = CarverArticle::getInstance()->getArticleCount();
            $data['article_count'] = $article_count;
            //友情链接数
            $link_count = CarverLink::getInstance()->getLinkCount();
            $data['link_count'] = $link_count;
            //注册新用户
            $register_user = CarverUser::getInstance()->getRegisterUserCount();
            $data['register_user'] = $register_user;
            //在线用户数
            $online_user_count = CarverUser::getInstance()->getOnlineUserCount();
            $data['online_user_count'] = $online_user_count;
            //待处理的友情链接数
            $wait_deal_link = CarverLink::getInstance()->getNewLinkCount();
            $data['wait_deal_link'] = $wait_deal_link;
        
            
            //用户点击的统计数量
            $file = file_get_contents("click.txt");
            $content = explode(chr(13),$file);
            foreach ($content as $key => $value){
                $userAddress[]=getStrBetData($value,"【","】");
            }
        
            $userResult=merge_arr_column($userAddress);
        
            $userData=[];
            $userJson=array();
            foreach ($userResult as $k => $v){
                // $userResult[$k]=count($v);
                $userData[$k]['info']['country']=explode("-",$k)[0]??'未知';
                $userData[$k]['info']['province']=explode("-",$k)[1]??'未知';
                $userData[$k]['info']['city']=explode("-",$k)[2]??'未知';
                $userData[$k]['count']=count($v);
            }
            
            foreach ($userData as $ks => $val){
                $userJson[]=$val;
            }
            
            
            $range_list = array_slice(arraySort($userJson,'count'),0,20);
        
        

            return \view("index/index", ['data' => $data,'countryList'=>$range_list]);
        } else {
            return view("/noAuth");
        }

    }
    
    
    
     

    /**
     * @desc 无权访问的页面
     * @author  Carver
     */
    public function noAuth()
    {
        return view("noAuth");
    }


}
