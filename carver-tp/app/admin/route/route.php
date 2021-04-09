<?php
/**
 * Created by PhpStorm.
 * User: Carver
 * Date: 2020/7/16
 * Time: 23:23
 */

namespace app\admin\route;

use think\facade\Route;

Route::rule('login', 'admin/Login/login', "get");//登录页面
Route::rule('doLogin', 'admin/Login/doLogin', "get");//处理登录
Route::rule('outLogin', 'admin/Login/outLogin', "get");//退出登录
Route::rule('outLogin', 'admin/Login/outLogin', "get");//退出登录
Route::rule('adminIndex', 'admin/Index/adminIndex', "get");//登录后的首页
Route::rule('addAdmin', 'admin/Admin/addAdmin', "get");//添加用户
Route::rule('doAddAdmin', 'admin/Admin/doAddAdmin', "post");//处理添加用户
Route::rule('delAdmin', 'admin/Admin/delAdmin', "get");//删除用户
Route::rule('updateAdmin', 'admin/Admin/updateAdmin', "get");//修改用户
Route::rule('updateAdmin', 'admin/Admin/updateAdmin', "get");//处理修改用户
Route::rule('adminList', 'admin/Admin/adminList', "get");//用户列表
Route::rule('noticeList', 'admin/Admin/noticeList', "get");//公告列表
Route::rule('delNotice', 'admin/Admin/delNotice', "get");//删除公告
Route::rule('uploadInfo', 'admin/Admin/uploadInfo', "get");//文件上传
Route::rule('logActIndex', 'admin/Log/logActIndex', "get");//操作日志
Route::rule('logSysIndex', 'admin/Log/logSysIndex', "get");//系统日志
Route::rule('applyLink', 'admin/Link/applyLink', "get");//申请友情链接
Route::rule('navigateList', 'admin/Navigate/navigateList');//前台导航管理




