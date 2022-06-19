<?php
/**
 * Created by PhpStorm.
 * User: Carver
 * Date: 2020/7/16
 * Time: 23:23
 */

namespace app\admin\route;

use think\facade\Route;
use think\facade\Request;

// 检测PHP环境
if (version_compare(PHP_VERSION, '7.2.0', '<')) die('require PHP > 7.0.0 !');

// 检测是否是新安装
if (file_exists(public_path() . "install") && !file_exists(public_path() . "install/install.lock")) {
    // 组装安装url
    $url = $_SERVER['HTTP_HOST'] . trim($_SERVER['SCRIPT_NAME'], 'index.php') . 'install/index.php';
    // 使用http://域名方式访问；避免./Public/install 路径方式的兼容性和其他出错问题
    header("Location:http://$url");
    die;
}




Route::rule('/', 'web/LoginUser/userIndex');//用户注册
Route::rule('index', 'web/LoginUser/index');//用户注册
Route::rule('doRegister', 'web/LoginUser/doRegister');//处理用户注册的数据
Route::rule('doLogin', 'web/LoginUser/doLogin');//处理用户登录的数据
Route::rule('userIndex', 'web/LoginUser/userIndex');//处理用户登录成功首页数据

Route::rule('articleDetail ', 'web/ArticleUser/articleDetail');//文章详情
Route::rule('searchRepeatUser ', 'web/ArticleUser/searchRepeatUser', 'post');//检测是否是给自己回复评论
Route::rule('searchArticle ', 'web/ArticleUser/searchArticle');//搜索文章



//验证登录
Route::group(function () {
    Route::post('clickPrize','web/ArticleUser/clickPrize');//点赞
    Route::post('addComment','web/ArticleUser/addComment');//发布评论

})->middleware(\app\middleware\CarverJwt::class);




