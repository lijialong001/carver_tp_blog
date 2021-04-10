/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 80012
Source Host           : localhost:3306
Source Database       : carver

Target Server Type    : MYSQL
Target Server Version : 80012
File Encoding         : 65001

Date: 2021-04-10 23:30:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for carver_admin
-- ----------------------------
DROP TABLE IF EXISTS `carver_admin`;
CREATE TABLE "carver_admin" (
  "admin_id" int(11) NOT NULL AUTO_INCREMENT,
  "admin_name" varchar(60) NOT NULL COMMENT '用户名',
  "admin_pwd" varchar(60) NOT NULL COMMENT '用户密码',
  "admin_email" varchar(60) NOT NULL COMMENT '用户邮箱',
  "last_login" bigint(9) NOT NULL DEFAULT '0' COMMENT '上一次登录的时间',
  "admin_image" varchar(200) NOT NULL COMMENT '头像',
  "token" varchar(200) NOT NULL,
  "create_time" bigint(9) NOT NULL DEFAULT '0',
  "update_time" bigint(9) NOT NULL DEFAULT '0',
  "delete_time" bigint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY ("admin_id")
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of carver_admin
-- ----------------------------
INSERT INTO `carver_admin` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@qq.com', '1618068194', '/static/admin/img/admin.jpg', '', '0', '0', '0');

-- ----------------------------
-- Table structure for carver_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `carver_admin_role`;
CREATE TABLE "carver_admin_role" (
  "id" int(11) NOT NULL AUTO_INCREMENT,
  "admin_id" int(11) NOT NULL COMMENT '用户id',
  "role_id" int(11) NOT NULL COMMENT '角色id',
  "create_time" bigint(9) NOT NULL DEFAULT '0',
  "update_time" bigint(9) NOT NULL DEFAULT '0',
  "delete_time" bigint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY ("id")
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户角色表';

-- ----------------------------
-- Records of carver_admin_role
-- ----------------------------
INSERT INTO `carver_admin_role` VALUES ('1', '1', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for carver_article
-- ----------------------------
DROP TABLE IF EXISTS `carver_article`;
CREATE TABLE "carver_article" (
  "article_id" int(11) NOT NULL AUTO_INCREMENT,
  "article_title" varchar(100) NOT NULL COMMENT '文章标题',
  "article_desc" varchar(200) NOT NULL COMMENT '文章简介',
  "article_content" longtext NOT NULL COMMENT '文章内容',
  "article_img" varchar(200) NOT NULL COMMENT '文章封面',
  "article_guide" int(11) NOT NULL COMMENT '文章导航',
  "article_label" varchar(200) NOT NULL COMMENT '文章标签',
  "click_num" int(11) NOT NULL COMMENT '点击量',
  "is_show" int(11) NOT NULL COMMENT '是否显示',
  "is_top_show" int(11) NOT NULL COMMENT '是否置顶',
  "article_author" varchar(30) NOT NULL COMMENT '文章作者',
  "add_time" bigint(9) NOT NULL,
  "update_time" bigint(9) unsigned NOT NULL DEFAULT '0',
  "delete_time" bigint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY ("article_id"),
  UNIQUE KEY "article" ("article_id") USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of carver_article
-- ----------------------------

-- ----------------------------
-- Table structure for carver_auth_new
-- ----------------------------
DROP TABLE IF EXISTS `carver_auth_new`;
CREATE TABLE "carver_auth_new" (
  "auth_id" int(11) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  "auth_name" varchar(255) DEFAULT NULL COMMENT '权限路径标识',
  "auth_desc" varchar(255) DEFAULT NULL COMMENT '权限中文描述',
  "p_id" int(11) DEFAULT NULL,
  "auth_status" smallint(2) NOT NULL COMMENT '当前使用状态 0 禁用 1 启用',
  "create_time" bigint(9) NOT NULL DEFAULT '0' COMMENT '创建时间',
  "update_time" bigint(9) NOT NULL DEFAULT '0',
  "delete_time" bigint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY ("auth_id")
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='权限新表';

-- ----------------------------
-- Records of carver_auth_new
-- ----------------------------
INSERT INTO `carver_auth_new` VALUES ('1', 'Login', '登录管理', '0', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('2', 'Admin', '用户管理', '0', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('3', 'Index', '首页管理', '0', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('4', 'login', '登录', '1', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('5', 'outLogin', '退出登录', '3', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('6', 'adminList', '用户列表', '2', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('7', 'roleList', '角色列表', '2', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('8', 'adminIndex', '首页列表', '3', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('9', 'Article', '文章管理', '0', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('10', 'articleList', '文章列表', '9', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('11', 'Navigate', '导航管理', '0', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('12', 'carouseList', '轮播图列表', '11', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('13', 'navigateList', '前台导航列表', '11', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('14', 'Link', '友情链接管理', '0', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('15', 'linkList', '友情列表', '14', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('16', 'Notice', '公告管理', '0', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('17', 'noticeList', '公告列表', '16', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('18', 'Site', '网站管理', '0', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('19', 'index', '网站设置', '18', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('20', 'Log', '日志管理', '0', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('21', 'logActIndex', '行为日志列表', '20', '1', '0', '0', '0');
INSERT INTO `carver_auth_new` VALUES ('22', 'logSysIndex', '系统日志列表', '20', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for carver_carouse
-- ----------------------------
DROP TABLE IF EXISTS `carver_carouse`;
CREATE TABLE "carver_carouse" (
  "carouse_id" int(11) NOT NULL AUTO_INCREMENT,
  "carouse_img" varchar(200) NOT NULL COMMENT '轮播图片',
  "carouse_desc" varchar(30) NOT NULL COMMENT '轮播图片描述',
  "carouse_sort" int(11) NOT NULL COMMENT '轮播图片排序',
  "is_show" tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否显示',
  "create_time" bigint(9) NOT NULL DEFAULT '0' COMMENT '添加时间',
  "update_time" bigint(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  "delete_time" bigint(9) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY ("carouse_id")
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='前台轮播图表';

-- ----------------------------
-- Records of carver_carouse
-- ----------------------------
INSERT INTO `carver_carouse` VALUES ('1', '/uploads/20210328/309b289d3ff9752e05ccce3cd599963a.jpg', '最好的生活是用心甘情愿的态度，过随遇而安的生活', '100', '1', '1616943267', '0', '0');
INSERT INTO `carver_carouse` VALUES ('2', '/uploads/20210328/3e89f0b62e4b897e78a2660b7d59ae94.jpeg', '愿你的未来可以早九晚五，又可以浪迹天涯', '99', '1', '1616943392', '0', '0');
INSERT INTO `carver_carouse` VALUES ('3', '/uploads/20210328/149605344bf3cfa2415b57b242645a66.jpeg', '希望未来有朝一日，能站在巴黎塔下仰望你', '98', '1', '1616943643', '0', '0');

-- ----------------------------
-- Table structure for carver_comment
-- ----------------------------
DROP TABLE IF EXISTS `carver_comment`;
CREATE TABLE "carver_comment" (
  "comment_id" int(11) NOT NULL AUTO_INCREMENT,
  "article_id" int(11) DEFAULT NULL COMMENT '文章id',
  "user_id" int(11) DEFAULT NULL COMMENT '用户id',
  "comment_content" longtext COMMENT '评论内容',
  "create_time" bigint(9) DEFAULT NULL COMMENT '评论时间',
  "delete_time" bigint(9) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY ("comment_id")
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论主表';

-- ----------------------------
-- Records of carver_comment
-- ----------------------------

-- ----------------------------
-- Table structure for carver_comment_to_others
-- ----------------------------
DROP TABLE IF EXISTS `carver_comment_to_others`;
CREATE TABLE "carver_comment_to_others" (
  "id" int(11) NOT NULL AUTO_INCREMENT,
  "comment_user_id" int(11) DEFAULT NULL COMMENT '回复的用户id',
  "comment_id" int(11) DEFAULT NULL COMMENT '评论id',
  "comment_to_content" longtext COMMENT '评论内容',
  "article_id" int(11) DEFAULT NULL COMMENT '回复的文章id',
  "comment_to_user_id" int(11) DEFAULT NULL COMMENT '被回复的用户id',
  "create_time" bigint(20) DEFAULT NULL COMMENT '回复时间',
  "delete_time" bigint(20) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY ("id")
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论附表';

-- ----------------------------
-- Records of carver_comment_to_others
-- ----------------------------

-- ----------------------------
-- Table structure for carver_link
-- ----------------------------
DROP TABLE IF EXISTS `carver_link`;
CREATE TABLE "carver_link" (
  "link_id" int(11) NOT NULL AUTO_INCREMENT,
  "link_name" varchar(200) NOT NULL COMMENT '链接名字',
  "link_site" varchar(200) NOT NULL COMMENT '链接地址',
  "is_confirm" int(10) NOT NULL COMMENT '0 待审核  1 审核中  2 审核通过   3 审核不通过',
  "create_time" bigint(9) DEFAULT NULL,
  "update_time" bigint(9) DEFAULT NULL,
  "delete_time" bigint(9) DEFAULT NULL,
  PRIMARY KEY ("link_id")
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of carver_link
-- ----------------------------

-- ----------------------------
-- Table structure for carver_navigation
-- ----------------------------
DROP TABLE IF EXISTS `carver_navigation`;
CREATE TABLE "carver_navigation" (
  "nav_id" int(11) NOT NULL AUTO_INCREMENT,
  "nav_name" varchar(100) NOT NULL COMMENT '前台导航名字',
  "sort" int(11) DEFAULT NULL COMMENT '排序',
  "p_id" int(11) DEFAULT NULL,
  "is_show" smallint(1) DEFAULT NULL COMMENT '是否显示',
  "create_time" bigint(9) DEFAULT NULL,
  "update_time" bigint(9) DEFAULT NULL,
  "delete_time" bigint(9) DEFAULT NULL,
  PRIMARY KEY ("nav_id")
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='前台导航表';

-- ----------------------------
-- Records of carver_navigation
-- ----------------------------
INSERT INTO `carver_navigation` VALUES ('1', '我的博文', '1', '0', '1', '1616676378', null, null);
INSERT INTO `carver_navigation` VALUES ('2', '我的记录', '1', '0', '1', '1616676436', null, null);
INSERT INTO `carver_navigation` VALUES ('3', '我的分享', '1', '0', '1', '1616676478', null, null);
INSERT INTO `carver_navigation` VALUES ('4', '关于我', '1', '0', '1', '1616676497', null, null);
INSERT INTO `carver_navigation` VALUES ('5', 'PHP', '1', '1', '1', '1616676519', null, null);
INSERT INTO `carver_navigation` VALUES ('6', '前端', '1', '1', '1', '1616676549', null, null);
INSERT INTO `carver_navigation` VALUES ('7', '开源项目', '1', '3', '1', '1617030886', null, null);
INSERT INTO `carver_navigation` VALUES ('8', 'Linux', '1', '1', '1', '1617808388', null, null);

-- ----------------------------
-- Table structure for carver_notice
-- ----------------------------
DROP TABLE IF EXISTS `carver_notice`;
CREATE TABLE "carver_notice" (
  "notice_id" int(11) NOT NULL AUTO_INCREMENT,
  "notice_content" text NOT NULL,
  "add_user" varchar(20) NOT NULL COMMENT '操作人',
  "create_time" bigint(9) DEFAULT NULL,
  "update_time" bigint(9) DEFAULT NULL,
  "delete_time" bigint(9) DEFAULT NULL,
  PRIMARY KEY ("notice_id")
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公告表';

-- ----------------------------
-- Records of carver_notice
-- ----------------------------

-- ----------------------------
-- Table structure for carver_operate_log
-- ----------------------------
DROP TABLE IF EXISTS `carver_operate_log`;
CREATE TABLE "carver_operate_log" (
  "log_id" int(11) NOT NULL AUTO_INCREMENT,
  "log_name" varchar(30) NOT NULL,
  "log_user_id" int(11) DEFAULT NULL,
  "log_user" varchar(30) NOT NULL,
  "create_time" bigint(9) NOT NULL,
  PRIMARY KEY ("log_id")
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of carver_operate_log
-- ----------------------------

-- ----------------------------
-- Table structure for carver_role
-- ----------------------------
DROP TABLE IF EXISTS `carver_role`;
CREATE TABLE "carver_role" (
  "role_id" int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  "role_name" varchar(60) NOT NULL COMMENT '角色名称',
  "current_status" smallint(2) NOT NULL DEFAULT '1' COMMENT '0 禁用 1启用',
  "create_time" bigint(9) NOT NULL DEFAULT '0' COMMENT '创建时间',
  "update_time" bigint(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  "delete_time" bigint(9) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY ("role_id")
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of carver_role
-- ----------------------------
INSERT INTO `carver_role` VALUES ('1', '超级管理员', '1', '0', '0', '0');

-- ----------------------------
-- Table structure for carver_role_auth
-- ----------------------------
DROP TABLE IF EXISTS `carver_role_auth`;
CREATE TABLE "carver_role_auth" (
  "id" int(11) NOT NULL AUTO_INCREMENT,
  "role_id" int(11) NOT NULL COMMENT '角色id',
  "auth_id" int(11) NOT NULL COMMENT '权限id',
  "current_status" smallint(3) NOT NULL COMMENT '0 禁用 1 启用',
  "create_time" bigint(9) NOT NULL DEFAULT '0' COMMENT '创建时间',
  "delete_time" bigint(9) NOT NULL COMMENT '清除时间',
  "update_time" bigint(9) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY ("id")
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='角色权限表';

-- ----------------------------
-- Records of carver_role_auth
-- ----------------------------
INSERT INTO `carver_role_auth` VALUES ('1', '1', '1', '1', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('2', '1', '2', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('3', '1', '3', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('4', '1', '4', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('5', '1', '5', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('6', '1', '6', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('7', '1', '7', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('8', '1', '8', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('9', '1', '9', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('10', '1', '10', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('11', '1', '11', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('12', '1', '12', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('13', '1', '13', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('14', '1', '14', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('15', '1', '15', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('16', '1', '16', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('17', '1', '17', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('18', '1', '18', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('19', '1', '19', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('20', '1', '20', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('21', '1', '21', '0', '0', '0', '0');
INSERT INTO `carver_role_auth` VALUES ('22', '1', '22', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for carver_site
-- ----------------------------
DROP TABLE IF EXISTS `carver_site`;
CREATE TABLE "carver_site" (
  "site_id" int(11) NOT NULL AUTO_INCREMENT,
  "site_title" varchar(30) DEFAULT NULL COMMENT '网站标题',
  "site_description" varchar(255) DEFAULT NULL COMMENT '网站描述',
  "site_image" varchar(200) DEFAULT NULL COMMENT '网站图标',
  "blog_name" varchar(30) NOT NULL COMMENT '博客名',
  "blog_work" varchar(100) NOT NULL COMMENT '博主职业',
  "blog_home" varchar(100) NOT NULL COMMENT '现居地址',
  "blog_site" varchar(200) NOT NULL COMMENT '博客网址',
  "create_time" bigint(9) DEFAULT NULL COMMENT '创建时间',
  "update_time" bigint(9) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY ("site_id")
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of carver_site
-- ----------------------------

-- ----------------------------
-- Table structure for carver_system_log
-- ----------------------------
DROP TABLE IF EXISTS `carver_system_log`;
CREATE TABLE "carver_system_log" (
  "action_id" int(11) NOT NULL AUTO_INCREMENT,
  "action_name" varchar(30) DEFAULT NULL COMMENT '操作内容',
  "action_ip" varchar(20) DEFAULT NULL COMMENT '操作者的ip',
  "action_user_id" int(11) DEFAULT NULL COMMENT '用户id',
  "action_user" varchar(30) DEFAULT NULL COMMENT '操作者',
  "create_time" bigint(9) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY ("action_id")
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of carver_system_log
-- ----------------------------

-- ----------------------------
-- Table structure for carver_user
-- ----------------------------
DROP TABLE IF EXISTS `carver_user`;
CREATE TABLE "carver_user" (
  "user_id" int(11) NOT NULL AUTO_INCREMENT,
  "user_name" varchar(60) NOT NULL,
  "user_pwd" varchar(200) NOT NULL,
  "user_email" varchar(30) NOT NULL,
  PRIMARY KEY ("user_id")
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of carver_user
-- ----------------------------

-- ----------------------------
-- Table structure for carver_user_click
-- ----------------------------
DROP TABLE IF EXISTS `carver_user_click`;
CREATE TABLE "carver_user_click" (
  "click_id" int(11) NOT NULL AUTO_INCREMENT COMMENT '点击的id',
  "user_id" int(11) DEFAULT NULL COMMENT '用户id',
  "article_id" int(11) DEFAULT NULL COMMENT '文章id',
  "click_time" bigint(9) DEFAULT NULL COMMENT '上一次点击的时间',
  "create_time" bigint(9) DEFAULT NULL COMMENT '创建时间',
  "update_time" bigint(9) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY ("click_id"),
  KEY "user_id" ("user_id") USING BTREE COMMENT '用户id',
  KEY "click_time" ("click_time") USING BTREE COMMENT '上一次点击的时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of carver_user_click
-- ----------------------------
