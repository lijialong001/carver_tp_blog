<?php
/**
 * 安装向导
 */
header('Content-type:text/html;charset=utf-8');
// 检测是否安装过
if (file_exists('./install.lock')) {
    echo "<span style='color: red'> 你已经安装过该系统，重新安装需要先删除</span>./public/install/install.lock 文件";
    die;
}
// 同意协议页面
if(@!isset($_GET['c']) || @$_GET['c']=='agreement'){
    require './agreement.html';
}
// 检测环境页面
if(@$_GET['c']=='agree'){
    require './agree.html';
}
// 创建数据库页面
if(@$_GET['c']=='create'){
    require './create.html';
}
// 安装成功页面
if(@$_GET['c']=='success'){
    // 判断是否为post
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $data=$_POST;
        // 连接数据库
        $link=@new mysqli("{$data['DB_HOST']}:{$data['DB_PORT']}",$data['DB_USER'],$data['DB_PWD']);
        // 获取错误信息
        $error=$link->connect_error;
        if (!is_null($error)) {
            // 转义防止和alert中的引号冲突
            $error=addslashes($error);
            die("<script>alert('数据库链接失败:$error');history.go(-1)</script>");
        }
        // 设置字符集
        $link->query("SET NAMES 'utf8'");
        $link->server_info>5.0 or die("<script>alert('请将您的mysql升级到5.0以上');history.go(-1)</script>");
        // 创建数据库并选中
        if(!$link->select_db($data['DB_NAME'])){
            $create_sql='CREATE DATABASE IF NOT EXISTS '.$data['DB_NAME'].' DEFAULT CHARACTER SET utf8;';
            $link->query($create_sql) or die('创建数据库失败');
            $link->select_db($data['DB_NAME']);
        }
        // 导入sql数据并创建表
        $carver_str=file_get_contents('./carver-tp.sql');
        $sql_array=preg_split("/;[\r\n]+/", str_replace('carver_',$data['DB_PREFIX'],$carver_str));
        foreach ($sql_array as $k => $v) {
            if (!empty($v)) {
                $link->query($v);
            }
        }
        $link->close();

        $dbInfo=<<<php
APP_DEBUG = true

[APP]
DEFAULT_TIMEZONE = Asia/Shanghai

[DATABASE]
TYPE = mysql
HOSTNAME = {$data['DB_HOST']}
DATABASE = {$data['DB_NAME']}
USERNAME = {$data['DB_USER']}
PASSWORD = {$data['DB_PWD']}
HOSTPORT = {$data['DB_PORT']}
CHARSET = utf8
DEBUG = true

[LANG]
default_lang = zh-cn
php;

        // 创建数据库链接配置文件
        file_put_contents('../../.env', $dbInfo );

        @touch('./install.lock');
        require './success.html';
    }

}

