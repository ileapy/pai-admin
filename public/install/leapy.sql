/*
 Navicat Premium Data Transfer

 Source Server         : learn_leapy_cn
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 182.254.133.82:3306
 Source Schema         : learn_leapy_cn

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 16/12/2020 17:28:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for lea_admin
-- ----------------------------
DROP TABLE IF EXISTS `lea_admin`;
CREATE TABLE `lea_admin`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(10) NOT NULL DEFAULT 0 COMMENT '前台用户ID',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `nickname` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '昵称',
  `pwd` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `realname` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '真实姓名',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `role_id` int(4) NOT NULL DEFAULT 0 COMMENT '角色id',
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  `mail` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '简介',
  `status` tinyint(1) NOT NULL COMMENT '状态1:正常0冻结',
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注册ip',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台人员列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_admin
-- ----------------------------
INSERT INTO `lea_admin` VALUES (1, 0, 'admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '/upload/image/20201216/ca79d51bded87deebd47b70b26ed5129.jpeg', 1, '10000000000', 'cfn@leapy.cn', '这家伙很懒，什么也没留下。', 1, '219.156.190.47', '1', '1581846541', '1', '1608107383');

-- ----------------------------
-- Table structure for lea_admin_auth
-- ----------------------------
DROP TABLE IF EXISTS `lea_admin_auth`;
CREATE TABLE `lea_admin_auth`  (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '权限id',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限名称',
  `icon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图标',
  `pid` int(4) NOT NULL DEFAULT 0 COMMENT '父id',
  `module` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模块名',
  `controller` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '控制器名称',
  `action` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '方法名名称',
  `params` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '参数',
  `font_family` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '字体',
  `spreed` tinyint(1) NULL DEFAULT 0 COMMENT 'spreed',
  `is_check` tinyint(1) NULL DEFAULT 0 COMMENT '是否选中',
  `is_menu` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否菜单',
  `path` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '路径',
  `rank` int(2) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态 1可用',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 72 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_admin_auth
-- ----------------------------
INSERT INTO `lea_admin_auth` VALUES (1, '查看日志', '', 8, 'admin', 'admin.admin_log', 'index', '', 'ok-icon', 0, 0, 1, '/admin/admin.admin_log/index', 0, 1, NULL, NULL, NULL, '1581664102');
INSERT INTO `lea_admin_auth` VALUES (2, '控制台', 'mdi mdi-home', 0, 'admin', 'index', 'main', '', 'ok-icon', 0, 1, 1, '/admin/index/main', 99, 1, NULL, NULL, '1', '1605358475');
INSERT INTO `lea_admin_auth` VALUES (4, '账号管理', 'mdi mdi-account', 0, 'admin', 'admin.admin', 'index', '', 'ok-icon', 0, 0, 1, '/admin/admin.admin/index', 0, 1, NULL, NULL, NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (5, '用户管理', '', 4, 'admin', 'admin.admin', 'index', '', NULL, 0, 0, 1, '/admin/admin.admin/index', 0, 1, NULL, NULL, NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (6, '权限管理', '', 4, 'admin', 'admin.admin_auth', 'index', '', NULL, 0, 0, 1, '/admin/admin.admin_auth/index', 0, 1, NULL, NULL, '1', '1582263685');
INSERT INTO `lea_admin_auth` VALUES (7, '角色管理', '', 4, 'admin', 'admin.admin_role', 'index', '', NULL, 0, 0, 1, '/admin/admin.admin_role/index', 0, 1, NULL, NULL, '1', '1597655581');
INSERT INTO `lea_admin_auth` VALUES (8, '系统管理', 'mdi mdi-settings', 0, 'admin', 'admin.admin_log', 'index', '', 'ok-icon', 1, 1, 1, '/admin/admin.admin_log/index', 0, 1, NULL, NULL, NULL, '1606295821');
INSERT INTO `lea_admin_auth` VALUES (14, '系统图标', '', 8, 'admin', 'admin.admin_icon', 'index', '', NULL, 0, 0, 1, '/admin/admin.admin_icon/index', 99, 1, '1', '1581668876', '1', '1581669026');
INSERT INTO `lea_admin_auth` VALUES (20, '修改密码', '', 8, 'admin', 'admin.admin', 'pwd', '', NULL, 0, 0, 1, '/admin/admin.admin/pwd', 0, 1, '1', '1582093161', NULL, '1597398791');
INSERT INTO `lea_admin_auth` VALUES (21, '清理缓存', '', 8, 'admin', 'index', 'clearCache', '', NULL, 0, 0, 0, '/admin/index/clearCache', 0, 1, '1', '1582093658', NULL, '1582093666');
INSERT INTO `lea_admin_auth` VALUES (23, '数据库管理', 'mdi mdi-database', 0, 'admin', 'database', 'index', '', NULL, 0, 0, 1, '/admin/database/index', 60, 1, '1', '1582169891', '1', '1582170211');
INSERT INTO `lea_admin_auth` VALUES (24, 'CMS管理', 'mdi mdi-file-document-box', 0, 'admin', 'cms', 'index', '', NULL, 0, 0, 1, '/admin/cms/index', 91, 1, '1', '1582170069', '1', '1582170142');
INSERT INTO `lea_admin_auth` VALUES (26, '网站配置', '', 8, 'admin', 'system.system_config', 'base', '', NULL, 0, 0, 1, '/admin/system.system_config/base', 0, 1, '1', '1582266348', '1', '1582781624');
INSERT INTO `lea_admin_auth` VALUES (27, '开发者配置', '', 8, 'admin', 'system.system_config_tab', 'index', '', NULL, 0, 0, 1, '/admin/system.system_config_tab/index', 0, 1, '1', '1582266439', '1', '1596001888');
INSERT INTO `lea_admin_auth` VALUES (35, '后台登录', '', 8, 'admin', 'login', 'login', '', NULL, 0, 0, 0, '/admin/login/login', 0, 1, '1', '1582707133', NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (36, '上传配置', '', 8, 'admin', 'system.system_config', 'upload', '', NULL, 0, 0, 0, '/admin/system.system_config/upload', 0, 1, '1', '1582781658', NULL, '1582781667');
INSERT INTO `lea_admin_auth` VALUES (37, '短信配置', '', 8, 'admin', 'system.system_config', 'sms', '', NULL, 0, 0, 0, '/admin/system.system_config/sms', 0, 1, '1', '1582781757', NULL, '1582781796');
INSERT INTO `lea_admin_auth` VALUES (38, '邮件配置', '', 8, 'admin', 'system.system_config', 'email', '', NULL, 0, 0, 0, '/admin/system.system_config/email', 0, 1, '1', '1582781787', NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (40, '微信配置', '', 8, 'admin', 'system.system_config', 'wechat', '', NULL, 0, 0, 1, '/admin/system.system_config/wechat', 80, 1, '1', '1583221636', '1', '1583221816');
INSERT INTO `lea_admin_auth` VALUES (41, 'MYSQL', '', 23, 'admin', 'database.mysql', 'index', '', NULL, 0, 0, 1, '/admin/database.mysql/index', 0, 1, '1', '1583387156', '1', '1583387537');
INSERT INTO `lea_admin_auth` VALUES (42, 'REDIS', '', 23, 'admin', 'database.redis', 'index', '', NULL, 0, 0, 1, '/admin/database.redis/index', 0, 1, '1', '1583387567', '1', '1597124400');
INSERT INTO `lea_admin_auth` VALUES (43, '微信公众号', 'mdi mdi-wechat', 0, 'admin', 'wechat.wechat_menu', 'index', '', NULL, 0, 0, 1, '/admin/wechat.wechat_menu/index', 65, 1, '1', '1583414051', '1', '1583414216');
INSERT INTO `lea_admin_auth` VALUES (44, '菜单管理', '', 43, 'admin', 'wechat.wechat_menu', 'menu', '', NULL, 0, 0, 1, '/admin/wechat.wechat_menu/menu', 0, 1, '1', '1583414106', NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (45, '自动回复', '', 43, 'admin', 'wechat.wechat_reply', 'index', '', NULL, 0, 0, 1, '/admin/wechat.wechat_reply/index', 0, 1, '1', '1583414161', NULL, '1597398784');
INSERT INTO `lea_admin_auth` VALUES (46, '关注时回复', '', 45, 'admin', 'wechat.wechat_reply', 'focus', '', NULL, 0, 0, 1, '/admin/wechat.wechat_reply/focus', 0, 1, '1', '1583417667', '1', '1584149678');
INSERT INTO `lea_admin_auth` VALUES (47, '栏目管理', '', 24, 'admin', 'cms.cms_category', 'index', '', NULL, 0, 0, 1, '/admin/cms.cms_category/index', 0, 1, '1', '1583421123', NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (48, '单页管理', '', 24, 'admin', 'cms.cms_page', 'index', '', NULL, 0, 0, 1, '/admin/cms.cms_page/index', 0, 1, '1', '1583463448', NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (49, '文章管理', '', 24, 'admin', 'cms.cms_article', 'index', '', NULL, 0, 0, 1, '/admin/cms.cms_article/index', 0, 1, '1', '1583463481', NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (50, '留言反馈', 'mdi mdi-message', 0, 'admin', 'user.user_message', 'index', '', NULL, 0, 0, 1, '/admin/user.user_message/index', 80, 1, '1', '1583464152', '1', '1583558450');
INSERT INTO `lea_admin_auth` VALUES (51, '文章标签', '', 24, 'admin', 'cms.cms_tag', 'index', '', NULL, 0, 0, 1, '/admin/cms.cms_tag/index', 0, 1, '1', '1583464330', '1', '1583510977');
INSERT INTO `lea_admin_auth` VALUES (52, '轮播管理', '', 24, 'admin', 'cms.cms_banner', 'index', '', NULL, 0, 0, 1, '/admin/cms.cms_banner/index', 0, 1, '1', '1583464406', NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (53, '留言反馈', '', 50, 'admin', 'user.user_message', 'index', '', NULL, 0, 0, 1, '/admin/user.user_message/index', 0, 1, '1', '1583558491', '1', '1583558582');
INSERT INTO `lea_admin_auth` VALUES (54, '无效词回复', '', 45, 'admin', 'wechat.wechat_reply', 'default', '', NULL, 0, 0, 1, '/admin/wechat.wechat_reply/default', 0, 1, '1', '1584149748', '1', '1584150322');
INSERT INTO `lea_admin_auth` VALUES (55, '关键词回复', '', 45, 'admin', 'wechat.wechat_reply', 'keyword', '', NULL, 0, 0, 1, '/admin/wechat.wechat_reply/keyword', 0, 1, '1', '1584149911', NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (56, '附件管理', '', 8, 'admin', 'widget', 'index', '', NULL, 0, 0, 0, '/admin/widget/index', 0, 1, '1', '1584758583', '1', '1584758865');
INSERT INTO `lea_admin_auth` VALUES (57, '选择图标', '', 56, 'admin', 'widget_icon', 'index', '', NULL, 0, 0, 0, '/admin/widget_icon/index', 0, 1, '1', '1584758637', NULL, '1584758874');
INSERT INTO `lea_admin_auth` VALUES (58, '单图片上传1', '', 56, 'admin', 'widget.files', 'image', '', NULL, 0, 0, 0, '/admin/widget.files/image', 0, 1, '1', '1584758709', NULL, '1584758878');
INSERT INTO `lea_admin_auth` VALUES (59, 'bs64上传转图片', '', 56, 'admin', 'widget_files', 'baseToImage', '', NULL, 0, 0, 0, '/admin/widget_files/baseToImage', 0, 1, '1', '1584758783', NULL, '1584758881');
INSERT INTO `lea_admin_auth` VALUES (60, 'tinymce图片上传', '', 56, 'admin', 'widget.files', 'tinymce', '', NULL, 0, 0, 0, '/admin/widget.files/tinymce', 0, 1, '1', '1584758813', NULL, '1584758870');
INSERT INTO `lea_admin_auth` VALUES (62, '小程序管理', 'mdi mdi-video', 0, 'admin', 'video.video', 'index', '', NULL, 0, 0, 1, '/admin/video.video/index', 99, 1, '1', '1587786268', '1', '1608107268');
INSERT INTO `lea_admin_auth` VALUES (63, '视频列表', '', 62, 'admin', 'mini.mini_video', 'index', '', NULL, 0, 0, 1, '/admin/mini.mini_video/index', 0, 1, '1', '1587904804', '1', '1608107247');
INSERT INTO `lea_admin_auth` VALUES (64, '视频标签', '', 62, 'admin', 'mini.mini_video_tag', 'index', '', NULL, 0, 0, 1, '/admin/mini.mini_video_tag/index', 0, 1, '1', '1587904881', NULL, '1608107248');
INSERT INTO `lea_admin_auth` VALUES (65, '视频轮播', '', 62, 'admin', 'mini.mini_video_banner', 'index', '', NULL, 0, 0, 1, '/admin/mini.mini_video_banner/index', 0, 1, '1', '1588077460', NULL, '1608107250');
INSERT INTO `lea_admin_auth` VALUES (66, '支付配置', '', 8, 'admin', 'system.system_config', 'base', '?tab_id=38', NULL, 0, 0, 1, '/admin/system.system_config/base', 0, 1, '1', '1588847202', '1', '1588854156');
INSERT INTO `lea_admin_auth` VALUES (67, '删除用户', '', 5, 'admin', 'admin.admin', 'del', '', NULL, 0, 0, 0, '/admin/admin.admin/del', 0, 1, '1', '1591411284', '1', '1591411303');
INSERT INTO `lea_admin_auth` VALUES (68, '删除权限', '', 6, 'admin', 'admin.admin_auth', 'del', '', NULL, 0, 0, 0, '/admin/admin.admin_auth/del', 0, 1, '1', '1591411848', NULL, NULL);
INSERT INTO `lea_admin_auth` VALUES (69, '删除', '', 47, 'admin', 'cms.cms_category', 'del', '', NULL, 0, 0, 0, '/admin/cms.cms_category/del', 0, 1, '1', '1591412907', NULL, '1591779278');
INSERT INTO `lea_admin_auth` VALUES (71, '用户管理', '', 43, 'admin', 'wechat.wechat_user', 'index', '', NULL, 0, 0, 1, '/admin/wechat.wechat_user/index', 0, 1, '1', '1591772350', NULL, NULL);

-- ----------------------------
-- Table structure for lea_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `lea_admin_log`;
CREATE TABLE `lea_admin_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
  `admin_id` int(10) NOT NULL COMMENT '操作人id',
  `admin_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作人名字',
  `module` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模块名',
  `controller` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '控制器名',
  `action` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '方法名',
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ip',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作时间',
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'User-Agent',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_admin_log
-- ----------------------------
INSERT INTO `lea_admin_log` VALUES (1, 1, 'admin', 'admin', 'index', 'main', '127.0.0.1', '1608109419', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (2, 1, 'admin', 'admin', 'mini.mini_video', 'index', '127.0.0.1', '1608109424', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (3, 1, 'admin', 'admin', 'mini.mini_video_tag', 'index', '127.0.0.1', '1608109425', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (4, 1, 'admin', 'admin', 'wechat.wechat_menu', 'menu', '127.0.0.1', '1608109429', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (5, 1, 'admin', 'admin', 'wechat.wechat_reply', 'focus', '127.0.0.1', '1608109433', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (6, 1, 'admin', 'admin', 'login', 'login', '222.210.214.92', '1608109440', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (7, 1, 'admin', 'admin', 'index', 'main', '222.210.214.92', '1608109441', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (8, 1, 'admin', 'admin', 'mini.mini_video', 'index', '222.210.214.92', '1608109452', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (9, 1, 'admin', 'admin', 'mini.mini_video_tag', 'index', '222.210.214.92', '1608109453', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (10, 1, 'admin', 'admin', 'mini.mini_video_banner', 'index', '222.210.214.92', '1608109454', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (11, 1, 'admin', 'admin', 'login', 'login', '223.98.149.188', '1608110486', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 Edg/87.0.664.57');
INSERT INTO `lea_admin_log` VALUES (12, 1, 'admin', 'admin', 'index', 'main', '223.98.149.188', '1608110487', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 Edg/87.0.664.57');
INSERT INTO `lea_admin_log` VALUES (13, 1, 'admin', 'admin', 'cms.cms_category', 'index', '223.98.149.188', '1608110512', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 Edg/87.0.664.57');
INSERT INTO `lea_admin_log` VALUES (14, 1, 'admin', 'admin', 'cms.cms_article', 'index', '223.98.149.188', '1608110527', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 Edg/87.0.664.57');
INSERT INTO `lea_admin_log` VALUES (15, 1, 'admin', 'admin', 'mini.mini_video', 'index', '223.98.149.188', '1608110544', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 Edg/87.0.664.57');
INSERT INTO `lea_admin_log` VALUES (16, 1, 'admin', 'admin', 'system.system_config', 'wechat', '127.0.0.1', '1608110669', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (17, 1, 'admin', 'admin', 'system.system_config', 'base', '127.0.0.1', '1608110671', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (18, 1, 'admin', 'admin', 'admin.admin_icon', 'index', '127.0.0.1', '1608110675', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (19, 1, 'admin', 'admin', 'system.system_config_tab', 'index', '127.0.0.1', '1608110692', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');
INSERT INTO `lea_admin_log` VALUES (20, 1, 'admin', 'admin', 'system.system_config_tab', 'index', '127.0.0.1', '1608110729', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36');

-- ----------------------------
-- Table structure for lea_admin_notify
-- ----------------------------
DROP TABLE IF EXISTS `lea_admin_notify`;
CREATE TABLE `lea_admin_notify`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `aid` int(10) NOT NULL COMMENT '管理员ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `from` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '消息来源 谁发的',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '消息类型 timer:定时器 system:系统',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '跳转路径 不填写时自动判断',
  `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否已读',
  `add_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_admin_notify
-- ----------------------------

-- ----------------------------
-- Table structure for lea_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `lea_admin_role`;
CREATE TABLE `lea_admin_role`  (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '角色状态',
  `pid` int(4) NOT NULL DEFAULT 0 COMMENT '上级id',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名称',
  `auth` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限',
  `tree_data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'treedata',
  `rank` tinyint(2) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '角色状态1可用0不用',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_admin_role
-- ----------------------------
INSERT INTO `lea_admin_role` VALUES (1, 0, '超级管理员', '2,62,63,64,65,24,47,69,48,49,51,52,50,53,43,44,45,46,54,55,71,23,41,42,4,5,67,6,68,7,8,14,40,1,20,21,26,27,35,36,37,38,56,57,58,59,60,66', '2,62,63,64,65,24,47,69,48,49,51,52,50,53,43,44,45,46,54,55,71,23,41,42,4,5,67,6,68,7,8,14,40,1,20,21,26,27,35,36,37,38,56,57,58,59,60,66', 0, 1, '1', '1581734943', '1', '1608107298');

-- ----------------------------
-- Table structure for lea_attachment
-- ----------------------------
DROP TABLE IF EXISTS `lea_attachment`;
CREATE TABLE `lea_attachment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '附件ID',
  `cid` int(2) NOT NULL COMMENT '所属目录',
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '附件名称',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '附件地址',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类型',
  `mime` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'mime',
  `size` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '大小',
  `storage` int(2) NULL DEFAULT NULL COMMENT '存储方式1本地2腾讯云',
  `upload_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '附件表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for lea_attachment_category
-- ----------------------------
DROP TABLE IF EXISTS `lea_attachment_category`;
CREATE TABLE `lea_attachment_category`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '目录ID',
  `pid` int(10) NOT NULL DEFAULT 0 COMMENT '上级分类',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '目录名称',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所属附件类型',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '附件分类' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_attachment_category
-- ----------------------------

-- ----------------------------
-- Table structure for lea_cms_article
-- ----------------------------
DROP TABLE IF EXISTS `lea_cms_article`;
CREATE TABLE `lea_cms_article`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章名称',
  `cid` int(8) NOT NULL COMMENT '所属分类',
  `author` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '作者',
  `is_recommend` tinyint(1) NOT NULL DEFAULT 0 COMMENT '推荐文章',
  `is_hot` tinyint(1) NOT NULL COMMENT '热门文章',
  `is_top` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否置顶',
  `tag` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章标签',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '推荐图',
  `abstract` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '摘要',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `show_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '发布时间',
  `rank` tinyint(2) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'CMS文章' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_cms_article
-- ----------------------------

-- ----------------------------
-- Table structure for lea_cms_banner
-- ----------------------------
DROP TABLE IF EXISTS `lea_cms_banner`;
CREATE TABLE `lea_cms_banner`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '轮播ID',
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '轮播名称',
  `position` tinyint(2) NOT NULL COMMENT '位置',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '轮播图片',
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接地址',
  `rank` tinyint(2) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'CMS轮播' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_cms_banner
-- ----------------------------

-- ----------------------------
-- Table structure for lea_cms_category
-- ----------------------------
DROP TABLE IF EXISTS `lea_cms_category`;
CREATE TABLE `lea_cms_category`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类目名称',
  `pid` int(8) NOT NULL DEFAULT 0 COMMENT '上级ID',
  `type` tinyint(1) NOT NULL COMMENT '栏目类型 1单页2列表3外链',
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接',
  `is_menu` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否菜单',
  `rank` tinyint(2) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态1可用0不可用',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'CMS栏目' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_cms_category
-- ----------------------------

-- ----------------------------
-- Table structure for lea_cms_page
-- ----------------------------
DROP TABLE IF EXISTS `lea_cms_page`;
CREATE TABLE `lea_cms_page`  (
  `cid` int(8) NOT NULL COMMENT '单页ID-栏目ID',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `show_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '发布时间',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'CMS单页' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_cms_page
-- ----------------------------

-- ----------------------------
-- Table structure for lea_cms_record
-- ----------------------------
DROP TABLE IF EXISTS `lea_cms_record`;
CREATE TABLE `lea_cms_record`  (
  `id` int(8) NOT NULL COMMENT '记录ID',
  `aid` int(8) NOT NULL COMMENT '文章ID',
  `uid` int(8) NOT NULL DEFAULT 0 COMMENT '操作人',
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '操作类型 1浏览 2点赞',
  `ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'IP',
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'user_agent',
  `add_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'CMS用户阅读点赞' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_cms_record
-- ----------------------------

-- ----------------------------
-- Table structure for lea_cms_tag
-- ----------------------------
DROP TABLE IF EXISTS `lea_cms_tag`;
CREATE TABLE `lea_cms_tag`  (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标签名称',
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图标',
  `rank` tinyint(2) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'CMS标签' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_cms_tag
-- ----------------------------
INSERT INTO `lea_cms_tag` VALUES (1, '标签1', '', 2, 1, '1', '1583512673', '1', '1591607845');
INSERT INTO `lea_cms_tag` VALUES (2, '标签2', '', 2, 1, '1', '1583512673', '1', '1591607845');
INSERT INTO `lea_cms_tag` VALUES (3, '标签3', '', 0, 1, '1', '1583512683', NULL, NULL);

-- ----------------------------
-- Table structure for lea_mini_video
-- ----------------------------
DROP TABLE IF EXISTS `lea_mini_video`;
CREATE TABLE `lea_mini_video`  (
  `vid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频ID',
  `source` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '来源 qq iqiyi youku',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频类型',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频名称',
  `tinyname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '视频简称',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '视频地址',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '首页图片',
  `cover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面',
  `skip_sec` int(8) NULL DEFAULT NULL COMMENT '跳过多少秒',
  `fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '费用',
  `discount` decimal(8, 2) NULL DEFAULT NULL COMMENT '折扣',
  `recommend` tinyint(1) NULL DEFAULT NULL COMMENT '是否推荐',
  `love` tinyint(1) NULL DEFAULT NULL COMMENT '猜你喜欢',
  `actor` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '演员',
  `num` int(8) NULL DEFAULT NULL COMMENT '集数',
  `now_num` int(8) NULL DEFAULT NULL COMMENT '更新到第几集',
  `time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '时间',
  `desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '简介',
  `rank` tinyint(2) NULL DEFAULT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '是否启用',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`vid`) USING BTREE,
  UNIQUE INDEX `vid`(`vid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_mini_video
-- ----------------------------

-- ----------------------------
-- Table structure for lea_mini_video_banner
-- ----------------------------
DROP TABLE IF EXISTS `lea_mini_video_banner`;
CREATE TABLE `lea_mini_video_banner`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '轮播ID',
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '轮播名称',
  `tinyname` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '简称',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '轮播图片',
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '链接地址',
  `rank` tinyint(2) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '小程序视频轮播' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_mini_video_banner
-- ----------------------------

-- ----------------------------
-- Table structure for lea_mini_video_collect
-- ----------------------------
DROP TABLE IF EXISTS `lea_mini_video_collect`;
CREATE TABLE `lea_mini_video_collect`  (
  `uid` int(8) NOT NULL COMMENT '用户ID',
  `vid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频ID',
  `add_time` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收藏时间',
  PRIMARY KEY (`uid`, `vid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频收藏表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_mini_video_collect
-- ----------------------------

-- ----------------------------
-- Table structure for lea_mini_video_item
-- ----------------------------
DROP TABLE IF EXISTS `lea_mini_video_item`;
CREATE TABLE `lea_mini_video_item`  (
  `xid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '集数ID',
  `vid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频ID',
  `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '当前集数',
  `skip_sec` int(8) NULL DEFAULT NULL COMMENT '跳过多少秒',
  `fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '费用',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '视频地址',
  `rank` int(8) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`xid`, `vid`, `name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '电视剧分集表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_mini_video_item
-- ----------------------------

-- ----------------------------
-- Table structure for lea_mini_video_order
-- ----------------------------
DROP TABLE IF EXISTS `lea_mini_video_order`;
CREATE TABLE `lea_mini_video_order`  (
  `oid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '购买订单',
  `vid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频ID',
  `uid` int(10) NOT NULL COMMENT '用户ID',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频类型',
  `xid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '当是电视剧必填',
  `cost` decimal(8, 2) NOT NULL COMMENT '费用',
  `paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否支付',
  `pay_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付时间',
  `is_refund` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否退款',
  `is_inform` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否通知',
  `refund_cost` decimal(8, 2) NULL DEFAULT NULL COMMENT '退款金额',
  `refund_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '退款时间',
  `add_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单状态 0付款中 1 已付款 2 已退款',
  PRIMARY KEY (`oid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频购买订单' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_mini_video_order
-- ----------------------------

-- ----------------------------
-- Table structure for lea_mini_video_plan
-- ----------------------------
DROP TABLE IF EXISTS `lea_mini_video_plan`;
CREATE TABLE `lea_mini_video_plan`  (
  `uid` int(8) NOT NULL COMMENT '用户ID',
  `vid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频id',
  `xid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '剧集id',
  `sec` decimal(8, 2) NOT NULL COMMENT '播放时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`vid`, `xid`, `uid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '播放进度' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_mini_video_plan
-- ----------------------------

-- ----------------------------
-- Table structure for lea_mini_video_record
-- ----------------------------
DROP TABLE IF EXISTS `lea_mini_video_record`;
CREATE TABLE `lea_mini_video_record`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `vid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频ID',
  `xid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电视剧集数ID',
  `add_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '浏览时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1661 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频浏览记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_mini_video_record
-- ----------------------------

-- ----------------------------
-- Table structure for lea_mini_video_t_v
-- ----------------------------
DROP TABLE IF EXISTS `lea_mini_video_t_v`;
CREATE TABLE `lea_mini_video_t_v`  (
  `vid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频ID',
  `tid` int(8) NOT NULL COMMENT '标签ID',
  `add_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`vid`, `tid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频标签对应表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_mini_video_t_v
-- ----------------------------

-- ----------------------------
-- Table structure for lea_mini_video_tag
-- ----------------------------
DROP TABLE IF EXISTS `lea_mini_video_tag`;
CREATE TABLE `lea_mini_video_tag`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `type` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标签类型',
  `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标签名称',
  `rank` tinyint(2) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否启用',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '视频标签' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_mini_video_tag
-- ----------------------------
INSERT INTO `lea_mini_video_tag` VALUES (1, 'tv', '奇幻', 0, 1, '1', '1587906993', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (2, 'tv', '动作', 0, 1, '1', '1587907037', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (3, 'tv', '冒险', 0, 1, '1', '1587907047', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (4, 'tv', '剧情', 0, 1, '1', '1587907056', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (5, 'tv', '爱情', 0, 1, '1', '1587907101', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (6, 'tv', '古装', 0, 1, '1', '1587907109', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (7, 'tv', '青春', 0, 1, '1', '1587907121', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (8, 'tv', '喜剧', 0, 1, '1', '1587907146', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (9, 'tv', '犯罪', 0, 1, '1', '1587907166', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (10, 'tv', '历史', 0, 1, '1', '1587907221', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (11, 'tv', '都市', 0, 1, '1', '1587907239', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (12, 'tv', '偶像', 0, 1, '1', '1587907282', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (13, 'tv', '情感', 0, 1, '1', '1587907311', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (14, 'tv', '悬疑', 0, 1, '1', '1587907348', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (15, 'tv', '家庭', 0, 1, '1', '1587907436', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (16, 'tv', '励志', 0, 1, '1', '1587907461', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (18, 'movie', '动作', 0, 1, '1', '1587907515', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (19, 'movie', '犯罪', 0, 1, '1', '1587907522', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (20, 'movie', '战争', 0, 1, '1', '1587907530', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (21, 'movie', '科幻', 0, 1, '1', '1587907554', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (22, 'movie', '奇幻', 0, 1, '1', '1587907563', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (23, 'movie', '冒险', 0, 1, '1', '1587907576', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (24, 'movie', '院线', 0, 1, '1', '1587907586', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (25, 'movie', '古装', 0, 1, '1', '1587907611', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (26, 'movie', '爱情', 0, 1, '1', '1587907619', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (27, 'movie', '喜剧', 0, 1, '1', '1587907655', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (28, 'movie', '传记', 0, 1, '1', '1587907734', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (29, 'movie', '悬疑', 0, 1, '1', '1587907761', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (30, 'movie', '惊悚', 0, 1, '1', '1587907838', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (31, 'movie', '灾难', 0, 1, '1', '1587907861', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (32, 'movie', '历史', 0, 1, '1', '1587907875', NULL, NULL);
INSERT INTO `lea_mini_video_tag` VALUES (33, 'movie', '战争', 0, 1, '1', '1587907883', NULL, NULL);

-- ----------------------------
-- Table structure for lea_system_config
-- ----------------------------
DROP TABLE IF EXISTS `lea_system_config`;
CREATE TABLE `lea_system_config`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `tab_id` int(8) NULL DEFAULT NULL COMMENT '分组id',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题名称',
  `form_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '表单名称',
  `form_type` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '表单类型',
  `tag_type` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标签类型',
  `upload_type` tinyint(1) NULL DEFAULT NULL COMMENT '上传配置',
  `param` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '参数',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `rank` tinyint(2) NOT NULL DEFAULT 0 COMMENT '排序',
  `is_show` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否显示',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '角色状态1可用0不用',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 65 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_system_config
-- ----------------------------
INSERT INTO `lea_system_config` VALUES (1, 1, '网站标题', 'title', 'text', 'input', 0, '', '派 后台管理系统', 'systemConfig(\"title\")', 90, 1, 1, '1', '1582792265', '1', '1583855342');
INSERT INTO `lea_system_config` VALUES (2, 1, '网站图标', 'favicon', 'file', 'input', 0, '', 'http://file.cos.leapy.cn/image/20200615/4a8c120200615143812469.png', '', 89, 1, 1, '1', '1582793160', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (3, 1, '站点关键词', 'keywords', 'text', 'input', 0, '', '派后台管理系统', '', 88, 1, 1, '1', '1582793221', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (4, 1, '站点描述', 'description', 'text', 'input', 0, '', '派后台管理系统', '', 87, 1, 1, '1', '1582793248', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (5, 1, '网站作者', 'author', 'text', 'input', 0, '', 'cfn', '', 86, 1, 1, '1', '1582793305', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (6, 1, '后台LOGO', 'admin_logo', 'file', 'input', 0, '', '/upload/image/20200228/c42005f7fafb58106c33e58279b2f396.png', '', 85, 1, 1, '1', '1582793393', '1', '1582793700');
INSERT INTO `lea_system_config` VALUES (7, 1, '版权信息', 'copyright', 'text', 'textarea', 0, '', 'Power by LEARY.', '', 84, 1, 1, '1', '1582793470', '1', '1582793495');
INSERT INTO `lea_system_config` VALUES (8, 1, '备案信息', 'icp', 'text', 'textarea', 0, '', 'xxx', '', 83, 1, 1, '1', '1582793563', '1', '1583375542');
INSERT INTO `lea_system_config` VALUES (9, 3, '短信平台', 'sms_type', 'radio', 'input', 0, '1=>腾讯云\n2=>阿里云', '1', '', 99, 1, 1, '1', '1583126643', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (10, 3, 'AppID', 'sms_appid', 'text', 'input', 0, '', '', '', 98, 1, 1, '1', '1583126757', '1', '1583126769');
INSERT INTO `lea_system_config` VALUES (11, 3, 'App Key', 'sms_appkey', 'text', 'input', 0, '', '', '', 97, 1, 1, '1', '1583126826', '1', '1583131539');
INSERT INTO `lea_system_config` VALUES (12, 3, '短信登录模板ID', 'sms_login', 'number', 'input', 0, '', '545149', '', 0, 0, 1, '1', '1583137085', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (13, 3, '短信签名', 'sms_sign', 'text', 'input', 0, '', '里派LEAPY', '', 0, 1, 1, '1', '1583137174', '1', '1583140447');
INSERT INTO `lea_system_config` VALUES (14, 3, '找回密码', 'sms_retrieve', 'number', 'input', 0, '', '545151', '', 0, 0, 1, '1', '1583138408', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (15, 3, '注册', 'sms_register', 'number', 'input', 0, '', '545150', '', 0, 0, 1, '1', '1583138507', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (17, 13, '公众号名称', 'wechat_app_name', 'text', 'input', 0, '', '', '', 99, 1, 1, '1', '1583221905', '1', '1583222192');
INSERT INTO `lea_system_config` VALUES (18, 13, '微信号', 'wechat_app_number', 'text', 'input', 0, '', '', '', 98, 1, 1, '1', '1583221970', '1', '1583222198');
INSERT INTO `lea_system_config` VALUES (19, 13, '原始ID', 'wechat_app_origin_id', 'text', 'input', 0, '', '', '', 97, 1, 1, '1', '1583222185', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (20, 13, 'AppID', 'wechat_appid', 'text', 'input', 0, '', '', '', 96, 1, 1, '1', '1583222266', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (21, 13, 'AppSecret', 'wechat_appsecret', 'text', 'input', 0, '', '', '', 95, 1, 1, '1', '1583222345', '1', '1583222356');
INSERT INTO `lea_system_config` VALUES (22, 13, '微信验证TOKEN', 'wechat_token', 'text', 'input', 0, '', 'learn', '', 94, 1, 1, '1', '1583222439', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (23, 13, '消息加解密方式', 'wechat_encry', 'radio', 'input', 0, '1=>明文模式\n2=>兼容模式\n3=>安全模式', '1', '', 93, 1, 1, '1', '1583222535', '1', '1583223241');
INSERT INTO `lea_system_config` VALUES (24, 13, 'EncodingAESKey', 'wechat_aeskey', 'text', 'input', 0, '', '', '', 92, 1, 1, '1', '1583223110', '1', '1583223252');
INSERT INTO `lea_system_config` VALUES (25, 13, '公众号类型', 'wechat_type', 'radio', 'input', 0, '1=>服务号\n2=>订阅号', '1', '', 91, 1, 1, '1', '1583223219', '1', '1583223257');
INSERT INTO `lea_system_config` VALUES (26, 13, '接口地址', 'wechat_url', 'text', 'input', 0, '', 'https://learn.leapy.cn/api/wechat/serve', '', 90, 1, 1, '1', '1583223343', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (29, 14, '小程序APPID', 'miniprogram_appid', 'text', 'input', 0, '', '', '', 99, 1, 1, '1', '1587732068', '1', '1587967147');
INSERT INTO `lea_system_config` VALUES (30, 14, '小程序密钥', 'miniprogram_appsecret', 'text', 'input', 0, '', '', '', 98, 1, 1, '1', '1587732178', '1', '1587967175');
INSERT INTO `lea_system_config` VALUES (31, 14, '小程序LOGO', 'miniprogram_logo', 'file', 'input', 0, '', 'http://file.cos.leapy.cn/image/20200509/29a4a202005092052147675.jpg', '', 0, 1, 1, '1', '1588201532', '1', '1589028469');
INSERT INTO `lea_system_config` VALUES (32, 14, '小程序名称', 'miniprogram_name', 'text', 'input', 0, '', '里派社区', '', 0, 1, 1, '1', '1588202282', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (33, 2, '存储方式', 'storage_type', 'radio', 'input', 0, '1=>本地储存\n2=>腾讯云COS', '2', '', 0, 1, 1, '1', '1588819285', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (34, 2, 'CDN域名', 'storage_domain', 'text', 'input', 0, '', 'http://file.cos.leapy.cn', '', 0, 1, 1, '1', '1588819651', '1', '1588828871');
INSERT INTO `lea_system_config` VALUES (35, 2, 'SecretId', 'storage_secretid', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588820386', '1', '1608110715');
INSERT INTO `lea_system_config` VALUES (36, 2, 'SecretKey', 'storage_secretkey', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588820426', '1', '1608110724');
INSERT INTO `lea_system_config` VALUES (37, 2, '存储位置', 'storage_region', 'text', 'input', 0, '', '', '腾讯云COS填写', 0, 1, 1, '1', '1588821134', '1', '1588828897');
INSERT INTO `lea_system_config` VALUES (38, 2, '存储桶名称', 'storage_bucket', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588821538', '1', '1608110744');
INSERT INTO `lea_system_config` VALUES (39, 4, 'SMTP服务器', 'mail_host', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588835717', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (40, 4, '邮箱用户名', 'mail_username', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588835775', '1', '1588836096');
INSERT INTO `lea_system_config` VALUES (41, 4, '授权码', 'mail_password', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588835807', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (42, 4, '服务器端口', 'mail_port', 'text', 'input', 0, '', '25', '', 0, 1, 1, '1', '1588836004', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (43, 4, '发件人', 'mail_from', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588836080', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (44, 4, '发件人签名', 'mail_from_name', 'text', 'input', 0, '', '里派', '', 0, 1, 1, '1', '1588844572', '1', '1588845488');
INSERT INTO `lea_system_config` VALUES (45, 38, 'APP支付APPID', 'pay_wechat_appid', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588854973', '1', '1588855071');
INSERT INTO `lea_system_config` VALUES (46, 38, '公众号APPID', 'pay_wechat_app_id', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588855050', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (47, 38, '小程序APPID', 'pay_wechat_miniapp_id', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588855120', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (48, 38, '商户号', 'pay_wechat_mch_id', 'text', 'input', 0, '', '1588549971', '', 0, 1, 1, '1', '1588855177', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (49, 38, 'API密钥', 'pay_wechat_key', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588855400', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (50, 38, '支付证书', 'pay_wechat_apiclient_cert', 'file', 'input', 0, '', '', '', 0, 1, 1, '1', '1588855742', '1', '1588856093');
INSERT INTO `lea_system_config` VALUES (51, 38, '支付密钥', 'pay_wechat_apiclient_key', 'file', 'input', 0, '', '', '', 0, 1, 1, '1', '1588855797', '1', '1588856105');
INSERT INTO `lea_system_config` VALUES (52, 1, '网站域名', 'domain', 'text', 'input', 0, '', 'https://learn.leapy.cn', '', 0, 1, 1, '1', '1588858018', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (53, 39, '支付宝APPID', 'pay_alipay_app_id', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588894650', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (54, 39, '支付宝公钥', 'pay_alipay_ali_public_key', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588894847', '1', '1588895236');
INSERT INTO `lea_system_config` VALUES (55, 39, '支付宝私钥', 'pay_alipay_private_key', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1588894902', '1', '1588895266');
INSERT INTO `lea_system_config` VALUES (56, 39, '应用公钥证书路径', 'pay_alipay_app_cert_public_key', 'file', 'input', 0, '', '', '公钥证书模式使用', 0, 1, 1, '1', '1588895349', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (57, 39, '支付宝根证书路径', 'pay_alipay_alipay_root_cert', 'file', 'input', 0, '', '', '公钥证书模式使用', 0, 1, 1, '1', '1588895390', '1', '1588895402');
INSERT INTO `lea_system_config` VALUES (58, 14, '小程序Token', 'miniprogram_token', 'text', 'input', 0, '', 'learn.leapy.cn', '', 0, 1, 1, '1', '1589007729', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (59, 14, 'EncodingAESKey', 'miniprogram_aeskey', 'text', 'input', 0, '', '', '', 0, 1, 1, '1', '1589007789', '1', '1589007836');
INSERT INTO `lea_system_config` VALUES (60, 14, '加密方式', 'miniprogram_encry', 'radio', 'input', 0, '1=>明文模式\n2=> 兼容模式\n3=> 安全模式（推荐）', '1', '', 0, 1, 1, '1', '1589007953', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (61, 14, '接口地址', 'miniprogram_url', 'text', 'input', 0, '', 'https://learn.leapy.cn/api/mini_program/serve', '', 0, 1, 1, '1', '1589008013', '1', '1589008053');
INSERT INTO `lea_system_config` VALUES (62, 14, '审核模式', 'miniprogram_audit', 'radio', 'input', 0, '0=>关闭\n1=>开启', '0', '', 0, 1, 1, '1', '1589177436', '1', '1593151328');
INSERT INTO `lea_system_config` VALUES (63, 14, '搜索提示', 'miniprogram_search', 'text', 'input', 0, '', '里派社区', '', 0, 1, 1, '1', '1589178363', NULL, NULL);
INSERT INTO `lea_system_config` VALUES (64, 4, '邮件类型', 'mail_type', 'radio', 'input', 0, '0=>其它\n1=>宝塔邮件', '1', '0::其它,1宝塔', 0, 1, 1, '1', '1589507116', NULL, NULL);

-- ----------------------------
-- Table structure for lea_system_config_tab
-- ----------------------------
DROP TABLE IF EXISTS `lea_system_config_tab`;
CREATE TABLE `lea_system_config_tab`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '分类名称',
  `rank` tinyint(2) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '角色状态1可用0不用',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统配置分类' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_system_config_tab
-- ----------------------------
INSERT INTO `lea_system_config_tab` VALUES (1, '基础配置', 99, 1, '1', '1582784937', '1', '1583385482');
INSERT INTO `lea_system_config_tab` VALUES (2, '上传配置', 98, 1, '1', '1582785701', '1', '1594175937');
INSERT INTO `lea_system_config_tab` VALUES (3, '短信配置', 97, 1, '1', '1582785710', '1', '1583385498');
INSERT INTO `lea_system_config_tab` VALUES (4, '邮件配置', 96, 1, '1', '1582785719', '1', '1583385506');
INSERT INTO `lea_system_config_tab` VALUES (13, '公众号配置', 95, 1, '1', '1583221840', '1', '1583385525');
INSERT INTO `lea_system_config_tab` VALUES (14, '小程序配置', 94, 1, '1', '1583221850', '1', '1583385532');
INSERT INTO `lea_system_config_tab` VALUES (38, '微信支付', 0, 1, '1', '1588854047', '1', '1588854054');
INSERT INTO `lea_system_config_tab` VALUES (39, '支付宝支付', 0, 1, '1', '1588854063', NULL, NULL);

-- ----------------------------
-- Table structure for lea_user
-- ----------------------------
DROP TABLE IF EXISTS `lea_user`;
CREATE TABLE `lea_user`  (
  `uid` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `nickname` varbinary(64) NOT NULL COMMENT '用户昵称',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '头像',
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录密码',
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `sex` tinyint(2) NOT NULL DEFAULT 0 COMMENT '性别',
  `money` decimal(8, 2) NOT NULL COMMENT '钱数',
  `integral` int(8) NOT NULL DEFAULT 0 COMMENT '积分',
  `level` tinyint(2) NOT NULL DEFAULT 1 COMMENT '用户等级',
  `last_ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '上次登录IP',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '介绍',
  `register_ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注册IP',
  `register_type` tinyint(1) NOT NULL COMMENT '注册类型 1微信 2手机号 3 小程序',
  `register_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '注册时间',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 118 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_user
-- ----------------------------

-- ----------------------------
-- Table structure for lea_user_bill
-- ----------------------------
DROP TABLE IF EXISTS `lea_user_bill`;
CREATE TABLE `lea_user_bill`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '账单ID',
  `uid` int(10) NOT NULL COMMENT '用户ID',
  `source` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '来源',
  `oid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单ID',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `cost` decimal(8, 2) NOT NULL COMMENT '金额',
  `io` tinyint(1) NOT NULL COMMENT '1收入2支出',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订单备注',
  `add_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_user_bill
-- ----------------------------

-- ----------------------------
-- Table structure for lea_user_message
-- ----------------------------
DROP TABLE IF EXISTS `lea_user_message`;
CREATE TABLE `lea_user_message`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '留言ID',
  `type` tinyint(2) NOT NULL COMMENT '留言来源 1CMS 2小程序',
  `uid` int(8) NOT NULL DEFAULT 0 COMMENT '用户ID 0为游客',
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮件',
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '留言内容',
  `add_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'IP',
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'user_agent',
  `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否已读',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户留言表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_user_message
-- ----------------------------

-- ----------------------------
-- Table structure for lea_user_order
-- ----------------------------
DROP TABLE IF EXISTS `lea_user_order`;
CREATE TABLE `lea_user_order`  (
  `id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `oid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单编号',
  `uid` int(9) NOT NULL COMMENT '用户ID',
  `source` int(8) NOT NULL COMMENT '订单来源 1 视频小程序',
  `pay_price` decimal(10, 2) NOT NULL COMMENT '支付金额',
  `pay_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付时间',
  `paid` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否支付',
  `add_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付时间',
  `is_refund` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否退款 1 退款',
  `refund_price` decimal(10, 2) NULL DEFAULT NULL COMMENT '退款金额',
  `refund_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '退款原因',
  `refund_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '退款时间',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `status` tinyint(255) NOT NULL DEFAULT 0 COMMENT '状态 0付款中 1 已付款 2 已退款',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_user_order
-- ----------------------------

-- ----------------------------
-- Table structure for lea_wechat_media
-- ----------------------------
DROP TABLE IF EXISTS `lea_wechat_media`;
CREATE TABLE `lea_wechat_media`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '素材类型',
  `media_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '素材ID',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信素材URL',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '本地地址',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `temporary` tinyint(1) NOT NULL COMMENT '是否是临时的 1是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信素材ID' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_wechat_media
-- ----------------------------

-- ----------------------------
-- Table structure for lea_wechat_message
-- ----------------------------
DROP TABLE IF EXISTS `lea_wechat_message`;
CREATE TABLE `lea_wechat_message`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `openid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'openid',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作类型',
  `message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '详消息内容',
  `add_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '添加事件',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 528 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_wechat_message
-- ----------------------------

-- ----------------------------
-- Table structure for lea_wechat_news
-- ----------------------------
DROP TABLE IF EXISTS `lea_wechat_news`;
CREATE TABLE `lea_wechat_news`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章Id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章名称',
  `author` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '作者',
  `digest` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '简介',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `content_source_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '原文链接地址',
  `thumb_media_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图片media_id',
  `show_cover_pic` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否显示封面',
  `thumb_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片地址',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章url',
  `need_open_comment` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否运行评论',
  `only_fans_can_comment` tinyint(1) NOT NULL DEFAULT 0 COMMENT '仅粉丝可见',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '图文文章' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_wechat_news
-- ----------------------------

-- ----------------------------
-- Table structure for lea_wechat_news_list
-- ----------------------------
DROP TABLE IF EXISTS `lea_wechat_news_list`;
CREATE TABLE `lea_wechat_news_list`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图文id',
  `media_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图文素材ID',
  `item` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章ID',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '图文列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_wechat_news_list
-- ----------------------------

-- ----------------------------
-- Table structure for lea_wechat_reply
-- ----------------------------
DROP TABLE IF EXISTS `lea_wechat_reply`;
CREATE TABLE `lea_wechat_reply`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '回复ID',
  `keyword` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '关键词',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '回复类型',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加人',
  `create_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  `update_user` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '修改时间',
  `update_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信回复表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_wechat_reply
-- ----------------------------

-- ----------------------------
-- Table structure for lea_wechat_user
-- ----------------------------
DROP TABLE IF EXISTS `lea_wechat_user`;
CREATE TABLE `lea_wechat_user`  (
  `uid` int(10) NOT NULL COMMENT '用户id',
  `openid` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'openid',
  `nickname` varbinary(64) NOT NULL COMMENT '微信昵称',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '微信头像',
  `sex` tinyint(1) NULL DEFAULT NULL COMMENT '1男',
  `city` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '城市',
  `language` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '语言',
  `province` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '省',
  `country` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '国家',
  `subscribe` tinyint(1) NULL DEFAULT NULL COMMENT '是否订阅',
  `subscribe_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '订阅时间',
  `groupid` int(8) NULL DEFAULT NULL COMMENT '分组ID',
  `tagid_list` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户标签',
  `remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `add_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '微信用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lea_wechat_user
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
