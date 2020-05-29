/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : app_school

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-05-29 11:01:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tb_admin`
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin`;
CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `title` varchar(10) NOT NULL COMMENT '管理员名称',
  `type` tinyint(2) NOT NULL DEFAULT '2' COMMENT '账号类型：1超级，2普通',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1启用、0关闭',
  `phone` varchar(11) NOT NULL COMMENT '联系电话',
  `content` varchar(200) DEFAULT NULL COMMENT '备注',
  `logo` varchar(200) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of tb_admin
-- ----------------------------
INSERT INTO `tb_admin` VALUES ('1', 'admin', 'b86a2be1ce700c9c87800e81688e6e07', '陶永斌', '1', '1', '13333333334', '', 'uploads/admin/20200503\\842702ed55fe13227ed53c675725f2ba.jpg', '', '1');
INSERT INTO `tb_admin` VALUES ('2', 'test', '9db06bcff9248837f86d1a6bcf41c9e7', '张三w3', '2', '1', '13333333333', null, 'uploads/admin/20200529\\7313885f5a6f5c62a5dad6f18e08d12b.png', 'utQZQ', '2');

-- ----------------------------
-- Table structure for `tb_admin_role`
-- ----------------------------
DROP TABLE IF EXISTS `tb_admin_role`;
CREATE TABLE `tb_admin_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '管理员id',
  `menu_id` int(11) NOT NULL COMMENT '菜单id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=998 DEFAULT CHARSET=utf8 COMMENT='给管理员权限表';

-- ----------------------------
-- Records of tb_admin_role
-- ----------------------------
INSERT INTO `tb_admin_role` VALUES ('981', '2', '34');
INSERT INTO `tb_admin_role` VALUES ('982', '2', '1');
INSERT INTO `tb_admin_role` VALUES ('983', '2', '2');
INSERT INTO `tb_admin_role` VALUES ('984', '2', '3');
INSERT INTO `tb_admin_role` VALUES ('985', '2', '4');
INSERT INTO `tb_admin_role` VALUES ('986', '2', '5');
INSERT INTO `tb_admin_role` VALUES ('987', '2', '6');
INSERT INTO `tb_admin_role` VALUES ('988', '2', '70');
INSERT INTO `tb_admin_role` VALUES ('989', '2', '71');
INSERT INTO `tb_admin_role` VALUES ('990', '2', '26');
INSERT INTO `tb_admin_role` VALUES ('991', '2', '27');
INSERT INTO `tb_admin_role` VALUES ('992', '2', '63');
INSERT INTO `tb_admin_role` VALUES ('993', '2', '72');
INSERT INTO `tb_admin_role` VALUES ('994', '2', '73');
INSERT INTO `tb_admin_role` VALUES ('995', '2', '74');
INSERT INTO `tb_admin_role` VALUES ('996', '2', '75');
INSERT INTO `tb_admin_role` VALUES ('997', '2', '76');

-- ----------------------------
-- Table structure for `tb_menu`
-- ----------------------------
DROP TABLE IF EXISTS `tb_menu`;
CREATE TABLE `tb_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `pid` int(11) NOT NULL,
  `m` varchar(20) NOT NULL COMMENT '模型',
  `c` varchar(20) DEFAULT NULL COMMENT '控制器',
  `f` varchar(20) DEFAULT NULL COMMENT '方法',
  `type` tinyint(4) NOT NULL COMMENT '类型：1菜单，2方法',
  `sort` varchar(11) NOT NULL DEFAULT '999',
  `icon` varchar(15) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '显示隐藏、1显示、0隐藏',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COMMENT='菜单，权限表';

-- ----------------------------
-- Records of tb_menu
-- ----------------------------
INSERT INTO `tb_menu` VALUES ('1', '后台管理员', '34', 'admin', 'Admin', '', '1', '3', 'icon-banji2', '1');
INSERT INTO `tb_menu` VALUES ('2', '管理员--列表', '1', 'admin', 'Admin', 'getlist', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('3', '管理员--添加', '1', 'admin', 'Admin', 'add', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('4', '管理员--修改', '1', 'admin', 'Admin', 'edit', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('5', '管理员--删除', '1', 'admin', 'Admin', 'dele', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('6', '管理员--首页', '1', 'admin', 'Admin', 'index', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('18', '角色管理', '34', 'admin', 'Role', '', '1', '2', 'icon-fangfa', '1');
INSERT INTO `tb_menu` VALUES ('19', '权限配置--所属列表', '18', 'admin', 'Role', 'getallrole', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('20', '权限配置--查询一条消息', '18', 'admin', 'Role', 'getinfo', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('21', '权限配置--修改', '18', 'admin', 'Role', 'edit', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('22', '权限配置--删除', '18', 'admin', 'Role', 'dele', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('25', '权限配置--首页', '18', 'admin', 'Role', 'index', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('26', '系统信息', '34', 'admin', 'System', '', '1', '4', 'icon-jinggao1', '1');
INSERT INTO `tb_menu` VALUES ('27', '系统信息--首页', '26', 'admin', 'System', 'index', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('28', '菜单管理', '34', 'admin', 'Menu', '', '1', '3', 'icon-caidan1', '1');
INSERT INTO `tb_menu` VALUES ('29', '菜单管理--首页', '28', 'admin', 'Menu', 'index', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('30', '菜单管理--列表', '28', 'admin', 'Menu', 'getmenu', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('31', '菜单管理--添加', '28', 'admin', 'Menu', 'add', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('32', '菜单管理--修改', '28', 'admin', 'Menu', 'edit', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('33', '菜单管理--删除', '28', 'admin', 'Menu', 'dele', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('34', '后台管理', '0', '000', '', '', '1', '999', 'icon-xitong', '1');
INSERT INTO `tb_menu` VALUES ('63', '公共-管理员信息修改', '0', 'admin', 'Admininfo', 'index', '0', '0', '', '1');
INSERT INTO `tb_menu` VALUES ('64', '权限配置--列表', '18', 'admin', 'Role', 'getlist', '0', '22', '', '1');
INSERT INTO `tb_menu` VALUES ('65', '菜单管理--获取一条信息', '28', 'admin', 'Menu', 'getinfo', '0', '22', null, '1');
INSERT INTO `tb_menu` VALUES ('66', '菜单管理--重新获取选项列表', '28', 'admin', 'Menu', 'getallmenu', '0', '999', null, '1');
INSERT INTO `tb_menu` VALUES ('67', '权限配置--菜单列表', '18', 'admin', 'Role', 'getallrole', '0', '999', null, '1');
INSERT INTO `tb_menu` VALUES ('70', '管理员--获取一条信息', '1', 'admin', 'Admin', 'getinfo', '0', '999', '', '1');
INSERT INTO `tb_menu` VALUES ('71', '管理员--角色重新获取', '1', 'admin', 'Admin', 'getrole', '0', '999', '', '1');
INSERT INTO `tb_menu` VALUES ('72', '公共--管理员头像上传', '0', 'admin', 'Admininfo', 'uploadimg', '0', '99', '', '1');
INSERT INTO `tb_menu` VALUES ('73', '公共--后台首页', '0', 'admin', 'Index', 'index', '0', '99', '', '1');
INSERT INTO `tb_menu` VALUES ('74', '公共--获取权限', '0', 'admin', 'Index', 'getrolemenu', '0', '99', '', '1');
INSERT INTO `tb_menu` VALUES ('75', '公共--退出登录', '0', 'admin', 'Index', 'logout', '0', '99', '', '1');
INSERT INTO `tb_menu` VALUES ('76', '公共--修改个人信息', '0', 'admin', 'Admininfo', 'edit', '0', '99', '', '1');

-- ----------------------------
-- Table structure for `tb_role`
-- ----------------------------
DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE `tb_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `content` varchar(100) NOT NULL,
  `status` tinyint(2) DEFAULT '1',
  `type` tinyint(2) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='菜单，权限表';

-- ----------------------------
-- Records of tb_role
-- ----------------------------
INSERT INTO `tb_role` VALUES ('1', '超级管理员', '0', '1', '1');
INSERT INTO `tb_role` VALUES ('2', '普通管理员', '12312312', '1', '2');

-- ----------------------------
-- Table structure for `tb_user`
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名、账号',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `title` varchar(10) NOT NULL COMMENT '姓名',
  `idcode` varchar(20) DEFAULT NULL COMMENT '证件号、身份证',
  `address` varchar(50) DEFAULT NULL COMMENT '地址、住址',
  `phone` varchar(11) NOT NULL COMMENT '联系电话',
  `phone1` varchar(11) DEFAULT NULL COMMENT '第二联系方式',
  `status` tinyint(2) DEFAULT '1' COMMENT '登录状态：1离线，2登录',
  `time` datetime DEFAULT NULL COMMENT '添加、注册日期',
  `login_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1116 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES ('1', 'tyb', '9db06bcff9248837f86d1a6bcf41c9e7', '陶永斌', '532626199403291122', null, '18314425252', '1333333333', '2', null, '2020-05-15 13:27:41', null);
INSERT INTO `tb_user` VALUES ('1112', 'test', 'a02cc9a3fc5def5275b5ca22f0d8f414', 'test测试', '', null, '18314452115', '18314454554', '1', null, null, null);
INSERT INTO `tb_user` VALUES ('1113', '101010', '9db06bcff9248837f86d1a6bcf41c9e7', '111111', '', null, '13333333333', '13333333333', '1', null, null, null);
INSERT INTO `tb_user` VALUES ('1114', '22222', 'a02cc9a3fc5def5275b5ca22f0d8f414', '22200', '222', null, '18314431313', '18341144114', '1', null, null, null);
INSERT INTO `tb_user` VALUES ('1115', '333', 'd930807e48a46653a72ccba6f5290bb1', '333', '333', null, '13333333333', '13333333333', '1', null, null, null);
