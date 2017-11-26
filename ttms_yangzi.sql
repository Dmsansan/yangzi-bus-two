/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : ttms_yangzi

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-11-26 13:53:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(32) DEFAULT NULL COMMENT '管理员用户名',
  `password` varchar(32) DEFAULT NULL COMMENT '登录密码',
  `pass_key` varchar(32) DEFAULT NULL COMMENT '密码重置标志',
  `real_name` varchar(32) DEFAULT NULL COMMENT '管理员真实姓名',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱地址，通常用邮箱登陆系统',
  `tel` varchar(32) DEFAULT NULL COMMENT '联系电话',
  `mobile` varchar(32) DEFAULT NULL COMMENT '联系人手机号',
  `qq` varchar(16) DEFAULT NULL COMMENT 'QQ号码',
  `weixin` varchar(32) DEFAULT NULL COMMENT '微信号码',
  `remark` varchar(300) DEFAULT NULL COMMENT '备注',
  `role_id` int(11) DEFAULT NULL COMMENT '用户角色',
  `store_id` int(11) DEFAULT NULL COMMENT 'ä»“åº“/è½¦é˜ŸID',
  `is_term` char(1) DEFAULT NULL COMMENT '是否终端用户',
  `status` char(8) DEFAULT NULL COMMENT '状态',
  `last_ip` varchar(64) DEFAULT NULL COMMENT '最后一次登录IP',
  `last_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后一次登录时间',
  `login_times` int(11) DEFAULT '0' COMMENT '登录次数',
  `reg_ip` varchar(64) DEFAULT NULL COMMENT '注册时使用的IP',
  `reg_stamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '注册时间',
  `company_id` int(11) unsigned DEFAULT NULL COMMENT '分公司ID',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_name` (`admin_name`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', '25d55ad283aa400af464c76d713c07ad', null, '系统管理员', 'admin@ttms.com', '', '', null, null, '默认登录账号', '1', '0', 'N', null, '', '0000-00-00 00:00:00', '0', null, '0000-00-00 00:00:00', '0');
INSERT INTO `admins` VALUES ('2', '轮胎注册', '25d55ad283aa400af464c76d713c07ad', null, '轮胎注册', '', '', '', null, null, '轮胎信息录入员', '3', '0', 'N', null, '', '0000-00-00 00:00:00', '0', null, '0000-00-00 00:00:00', '0');
INSERT INTO `admins` VALUES ('3', '王司机', '550e1bafe077ff0b0b67f4e32f29d751', null, '老王', '', '', '', null, null, '栏目权限测试', '4', '6', 'N', null, null, '2017-11-17 10:03:14', '0', null, '0000-00-00 00:00:00', '14');

-- ----------------------------
-- Table structure for brand
-- ----------------------------
DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_no` varchar(20) DEFAULT NULL COMMENT '品牌代码',
  `brand_name` varchar(100) DEFAULT NULL COMMENT '品牌名称',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `norms_name` varchar(200) DEFAULT NULL,
  `class_name` varchar(200) DEFAULT NULL,
  `figure_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`brand_id`),
  UNIQUE KEY `brand_no` (`brand_no`),
  UNIQUE KEY `brand_name` (`brand_name`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of brand
-- ----------------------------
INSERT INTO `brand` VALUES ('5', null, '米其林', '备注', '56PR/CR/DP', '8PR', '花纹');
INSERT INTO `brand` VALUES ('6', null, '鲁朗', '普通参数', '67I/U/R', '12pr', '普通花纹');
INSERT INTO `brand` VALUES ('7', null, '特绑', '备注', '67T/E/R', '77PR', '螺旋花纹');

-- ----------------------------
-- Table structure for bt_history_log
-- ----------------------------
DROP TABLE IF EXISTS `bt_history_log`;
CREATE TABLE `bt_history_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_id` int(11) DEFAULT NULL COMMENT '车辆ID',
  `speed` int(11) DEFAULT NULL COMMENT '速度',
  `max_speed` int(11) DEFAULT NULL COMMENT '最高速度',
  `tire_id1` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure1` float(6,2) DEFAULT NULL,
  `overflow_pressure1` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp1` int(11) NOT NULL DEFAULT '255',
  `overflow_temp1` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id2` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure2` float(6,2) DEFAULT NULL,
  `overflow_pressure2` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp2` int(11) NOT NULL DEFAULT '255',
  `overflow_temp2` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id3` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure3` float(6,2) DEFAULT NULL,
  `overflow_pressure3` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp3` int(11) NOT NULL DEFAULT '255',
  `overflow_temp3` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id4` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure4` float(6,2) DEFAULT NULL,
  `overflow_pressure4` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp4` int(11) NOT NULL DEFAULT '255',
  `overflow_temp4` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id5` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure5` float(6,2) DEFAULT NULL,
  `overflow_pressure5` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp5` int(11) NOT NULL DEFAULT '255',
  `overflow_temp5` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id6` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure6` float(6,2) DEFAULT NULL,
  `overflow_pressure6` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp6` int(11) NOT NULL DEFAULT '255',
  `overflow_temp6` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id7` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure7` float(6,2) DEFAULT NULL,
  `overflow_pressure7` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp7` int(11) NOT NULL DEFAULT '255',
  `overflow_temp7` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id8` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure8` float(6,2) DEFAULT NULL,
  `overflow_pressure8` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp8` int(11) NOT NULL DEFAULT '255',
  `overflow_temp8` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id9` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure9` float(6,2) DEFAULT NULL,
  `overflow_pressure9` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp9` int(11) NOT NULL DEFAULT '255',
  `overflow_temp9` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id10` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure10` float(6,2) DEFAULT NULL,
  `overflow_pressure10` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp10` int(11) NOT NULL DEFAULT '255',
  `overflow_temp10` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录时间',
  PRIMARY KEY (`id`),
  KEY `log_stamp_idx` (`log_stamp`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bt_history_log
-- ----------------------------
INSERT INTO `bt_history_log` VALUES ('1', '2', null, null, '9', '6.70', '0', '33', '0', '10', '6.70', '0', '35', '0', '11', '7.80', '0', '26', '0', '12', '8.80', '0', '34', '0', '13', '8.70', '0', '35', '0', '14', '7.80', '0', '36', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', '2017-10-28 11:54:47');
INSERT INTO `bt_history_log` VALUES ('2', '2', null, null, '9', '7.00', '0', '34', '0', '10', '7.80', '0', '36', '0', '11', '8.80', '0', '35', '0', '12', '8.90', '0', '35', '0', '13', '8.80', '0', '36', '0', '14', '7.70', '0', '38', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', '2017-10-29 14:31:15');

-- ----------------------------
-- Table structure for bt_real_log
-- ----------------------------
DROP TABLE IF EXISTS `bt_real_log`;
CREATE TABLE `bt_real_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_id` int(11) DEFAULT NULL COMMENT '车辆ID',
  `speed` int(11) DEFAULT NULL COMMENT '速度',
  `max_speed` int(11) DEFAULT NULL COMMENT '最高速度',
  `tire_id1` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure1` float(6,2) DEFAULT NULL,
  `overflow_pressure1` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp1` int(11) NOT NULL DEFAULT '255',
  `overflow_temp1` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id2` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure2` float(6,2) DEFAULT NULL,
  `overflow_pressure2` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp2` int(11) NOT NULL DEFAULT '255',
  `overflow_temp2` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id3` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure3` float(6,2) DEFAULT NULL,
  `overflow_pressure3` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp3` int(11) NOT NULL DEFAULT '255',
  `overflow_temp3` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id4` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure4` float(6,2) DEFAULT NULL,
  `overflow_pressure4` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp4` int(11) NOT NULL DEFAULT '255',
  `overflow_temp4` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id5` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure5` float(6,2) DEFAULT NULL,
  `overflow_pressure5` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp5` int(11) NOT NULL DEFAULT '255',
  `overflow_temp5` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id6` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure6` float(6,2) DEFAULT NULL,
  `overflow_pressure6` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp6` int(11) NOT NULL DEFAULT '255',
  `overflow_temp6` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id7` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure7` float(6,2) DEFAULT NULL,
  `overflow_pressure7` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp7` int(11) NOT NULL DEFAULT '255',
  `overflow_temp7` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id8` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure8` float(6,2) DEFAULT NULL,
  `overflow_pressure8` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp8` int(11) NOT NULL DEFAULT '255',
  `overflow_temp8` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id9` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure9` float(6,2) DEFAULT NULL,
  `overflow_pressure9` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp9` int(11) NOT NULL DEFAULT '255',
  `overflow_temp9` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `tire_id10` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `pressure10` float(6,2) DEFAULT NULL,
  `overflow_pressure10` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `temp10` int(11) NOT NULL DEFAULT '255',
  `overflow_temp10` char(1) NOT NULL DEFAULT '0' COMMENT '是否在范围内，不是为1，正常为0',
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录时间',
  `mile_state1` varchar(20) NOT NULL DEFAULT '正常' COMMENT '是否过保',
  `mile_state2` varchar(20) NOT NULL DEFAULT '正常' COMMENT '是否过保',
  `mile_state3` varchar(20) NOT NULL DEFAULT '正常' COMMENT '是否过保',
  `mile_state4` varchar(20) NOT NULL DEFAULT '正常' COMMENT '是否过保',
  `mile_state5` varchar(20) NOT NULL DEFAULT '正常' COMMENT '是否过保',
  `mile_state6` varchar(20) NOT NULL DEFAULT '正常' COMMENT '是否过保',
  `mile_state7` varchar(20) NOT NULL DEFAULT '正常' COMMENT '是否过保',
  `mile_state8` varchar(20) NOT NULL DEFAULT '正常' COMMENT '是否过保',
  `mile_state9` varchar(20) NOT NULL DEFAULT '正常' COMMENT '是否过保',
  `mile_state10` varchar(20) NOT NULL DEFAULT '正常' COMMENT '是否过保',
  PRIMARY KEY (`id`),
  UNIQUE KEY `bus_id` (`bus_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bt_real_log
-- ----------------------------
INSERT INTO `bt_real_log` VALUES ('1', '1', null, null, '3', '6.80', '0', '30', '0', '4', '7.80', '0', '34', '0', '4', '7.00', '0', '35', '0', '5', '7.60', '0', '35', '0', '6', '7.00', '0', '36', '0', '7', '7.70', '0', '34', '0', '8', '8.00', '0', '35', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', '2017-10-29 17:03:37', '正常', '正常', '正常', '正常', '正常', '正常', '正常', '正常', '正常', '正常');
INSERT INTO `bt_real_log` VALUES ('2', '2', null, null, '9', '7.70', '0', '36', '0', '10', '7.60', '0', '35', '', '11', '8.20', '0', '33', '0', '12', '7.70', '0', '36', '0', '13', '7.80', '0', '38', '0', '14', '8.70', '0', '35', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', null, null, '0', '255', '0', '2017-10-30 13:22:20', '正常', '正常', '正常', '正常', '正常', '正常', '正常', '正常', '正常', '正常');

-- ----------------------------
-- Table structure for bus_alarm_log
-- ----------------------------
DROP TABLE IF EXISTS `bus_alarm_log`;
CREATE TABLE `bus_alarm_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bus_id` int(11) DEFAULT NULL COMMENT '车辆ID',
  `tire_id` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `place` int(11) DEFAULT NULL COMMENT '轮胎位置',
  `v_term_id` int(11) DEFAULT NULL COMMENT '车载终端ID',
  `pressure` float(6,2) DEFAULT NULL COMMENT '胎压',
  `pressure_ul` float(6,2) DEFAULT NULL COMMENT '胎压上限',
  `pressure_ll` float(6,2) DEFAULT NULL COMMENT '胎压下限',
  `temp` int(11) DEFAULT NULL COMMENT '温度',
  `temp_ul` int(11) DEFAULT NULL COMMENT '温度上限',
  `temp_ll` int(11) DEFAULT NULL COMMENT '温度下限',
  `speed` int(11) DEFAULT NULL COMMENT '速度',
  `speed_limit` int(11) DEFAULT NULL COMMENT '速度限制',
  `is_read` char(1) DEFAULT '0' COMMENT '是否已读，0表示未读，1表示已读',
  `alarm_type` varchar(20) DEFAULT NULL COMMENT '告警类型',
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bus_alarm_log
-- ----------------------------
INSERT INTO `bus_alarm_log` VALUES ('1', '1', '3', '1', '1', '10.00', '9.00', '4.00', '40', '35', '20', '60', '40', '0', '1', '2017-10-31 13:46:16');

-- ----------------------------
-- Table structure for bus_info
-- ----------------------------
DROP TABLE IF EXISTS `bus_info`;
CREATE TABLE `bus_info` (
  `bus_id` int(11) NOT NULL AUTO_INCREMENT,
  `plate_no` varchar(20) DEFAULT NULL COMMENT '车牌号码',
  `bus_no` varchar(32) DEFAULT NULL COMMENT '车辆编号',
  `bus_type` varchar(32) DEFAULT NULL COMMENT '车辆型号',
  `mile_count` int(11) DEFAULT '0' COMMENT '累计里程',
  `speed_limit` int(11) DEFAULT '80' COMMENT '速度上限',
  `factory` varchar(100) DEFAULT NULL COMMENT '厂商',
  `wheel_count` int(11) DEFAULT '0' COMMENT '轮数',
  `store_id` int(11) DEFAULT NULL COMMENT '仓库/车队ID',
  `v_term_id` int(11) DEFAULT NULL COMMENT '车载终端ID',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `add_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `company_id` int(255) unsigned DEFAULT NULL,
  `roules_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`bus_id`),
  UNIQUE KEY `plate_no` (`plate_no`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bus_info
-- ----------------------------
INSERT INTO `bus_info` VALUES ('1', '苏A8888', '', '', '5462', '0', '', '6', null, '1', '测试', '2017-11-14 10:04:52', null, null);
INSERT INTO `bus_info` VALUES ('2', '苏A6666', '', '', '78910', '0', '', '6', null, '2', 'a4b0', '2017-11-14 10:05:00', null, null);
INSERT INTO `bus_info` VALUES ('3', '1-5612', '', '', '0', '0', '', '6', null, '3', '备注1', '2017-11-17 17:00:12', null, null);
INSERT INTO `bus_info` VALUES ('4', '5624', '', '', '0', '0', '', '6', null, '7', '宇通', '2017-11-17 06:21:50', '14', '92');

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_no` varchar(20) DEFAULT NULL COMMENT '层级代码',
  `class_name` varchar(40) DEFAULT NULL COMMENT '层级名称',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`class_id`),
  UNIQUE KEY `class_no` (`class_no`),
  UNIQUE KEY `class_name` (`class_name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of class
-- ----------------------------
INSERT INTO `class` VALUES ('1', null, '12PR', '');
INSERT INTO `class` VALUES ('2', null, '14pr', '');
INSERT INTO `class` VALUES ('3', null, '77PR', null);
INSERT INTO `class` VALUES ('4', null, '22PR', null);

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `company_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('14', '备注', '公司二');
INSERT INTO `company` VALUES ('16', '大厂公司', '分公司三');
INSERT INTO `company` VALUES ('17', '南京扬子公交最大的分公司', '江南分公司');
INSERT INTO `company` VALUES ('18', '', '11');

-- ----------------------------
-- Table structure for figure_type
-- ----------------------------
DROP TABLE IF EXISTS `figure_type`;
CREATE TABLE `figure_type` (
  `figure_id` int(11) NOT NULL AUTO_INCREMENT,
  `figure_no` varchar(20) DEFAULT NULL COMMENT '花纹代码',
  `figure_name` varchar(40) DEFAULT NULL COMMENT '花纹名称',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`figure_id`),
  UNIQUE KEY `figure_no` (`figure_no`),
  UNIQUE KEY `figure_name` (`figure_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of figure_type
-- ----------------------------
INSERT INTO `figure_type` VALUES ('1', null, '一般花纹', '');

-- ----------------------------
-- Table structure for modules
-- ----------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_code` varchar(16) DEFAULT NULL COMMENT '模块代码',
  `parent_id` int(11) DEFAULT NULL COMMENT '上级模块ID',
  `ico` varchar(256) DEFAULT NULL COMMENT '模块图标',
  `module_level` int(11) DEFAULT NULL COMMENT '模块层级',
  `module_name` varchar(32) DEFAULT NULL COMMENT '模块英文名',
  `title` varchar(64) DEFAULT NULL COMMENT '模块中文名',
  `menu_name` varchar(64) DEFAULT NULL COMMENT '模块对应的菜单名（备用）',
  `menu_url` varchar(256) DEFAULT NULL COMMENT '模块对应的菜单URL（备用）',
  `seq` int(11) DEFAULT '0' COMMENT '排序',
  `remark` varchar(300) DEFAULT NULL COMMENT '模块说明',
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `module_name` (`module_name`)
) ENGINE=MyISAM AUTO_INCREMENT=141012 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of modules
-- ----------------------------
INSERT INTO `modules` VALUES ('10', '10', '-1', 'iconCls:\'icon-ok\'', '1', '10', '系统管理', '系统管理', '', '0', null);
INSERT INTO `modules` VALUES ('11', '11', '-1', 'iconCls:\'icon-help\'', '1', '11', '轮胎管理', '轮胎管理', '', '0', null);
INSERT INTO `modules` VALUES ('12', '12', '-1', 'iconCls:\'icon-search\'', '1', '12', '车辆管理', '车辆管理', '', '0', null);
INSERT INTO `modules` VALUES ('13', '13', '-1', 'iconCls:\'icon-redo\'', '1', '13', '监测系统', '监测系统', '', '0', null);
INSERT INTO `modules` VALUES ('14', '14', '-1', 'iconCls:\'icon-filter\'', '1', '14', '报表分析', '报表分析', '', '0', null);
INSERT INTO `modules` VALUES ('1010', '1010', '10', 'iconCls:\'icon-filter\'', '2', '1010', '用户权限管理', '用户权限管理', '', '0', null);
INSERT INTO `modules` VALUES ('101010', '101010', '1010', 'images/icon/33.png', '3', '101010', '角色管理', '角色管理', 'module_sys/sys.roles_show.php', '0', null);
INSERT INTO `modules` VALUES ('101011', '101011', '1010', 'images/icon/37.png', '3', '101011', '用户管理', '用户管理', 'module_sys/sys.users_show.php', '0', null);
INSERT INTO `modules` VALUES ('1011', '1011', '10', 'images/icon/1.png', '2', '1011', '基本数据管理', '基本数据管理', '', '0', null);
INSERT INTO `modules` VALUES ('101110', '101110', '1011', 'images/icon/37.png', '3', '101110', '修理厂管理', '修理厂管理', 'module_sys/repairDepotManger.php', '0', null);
INSERT INTO `modules` VALUES ('101112', '101112', '1011', 'images/icon/27.png', '3', '101112', '轮胎基本参数管理', '轮胎基本参数管理', 'module_sys/tireParameter.php', '0', null);
INSERT INTO `modules` VALUES ('101116', '101116', '1011', 'images/icon/27.png', '3', '101116', '车载终端管理', '车载终端管理', 'module_sys/sys.vehicle_show.php', '0', null);
INSERT INTO `modules` VALUES ('1110', '1110', '11', 'images/icon/37.png', '2', '1110', '轮胎相关管理', '轮胎相关管理', '', '0', null);
INSERT INTO `modules` VALUES ('111010', '111010', '1110', 'images/icon/33.png', '3', '111010', '轮胎参数管理', '轮胎参数管理', 'module_11/sys.tireparam_show.php', '0', null);
INSERT INTO `modules` VALUES ('111011', '111011', '1110', 'images/icon/33.png', '3', '111011', '传感器管理', '传感器管理', 'module_11/sys.sensor_show.php', '0', null);
INSERT INTO `modules` VALUES ('1111', '1111', '11', 'images/icon/1.png', '2', '1111', '轮胎维护', '轮胎维护', '', '0', null);
INSERT INTO `modules` VALUES ('111110', '111110', '1111', 'images/icon/37.png', '3', '111110', '轮胎管理', '轮胎管理', 'module_11/sys.tireinfo_show.php', '0', null);
INSERT INTO `modules` VALUES ('1210', '1210', '12', 'images/icon/37.png', '2', '1210', '车辆管理', '车辆管理', '', '0', null);
INSERT INTO `modules` VALUES ('121010', '121010', '1210', 'images/icon/33.png', '3', '121010', '车辆维护', '车辆维护', 'module_12/vehicle.php', '0', null);
INSERT INTO `modules` VALUES ('1310', '1310', '13', 'images/icon/37.png', '2', '1310', '实时状态', '实时状态', '', '0', null);
INSERT INTO `modules` VALUES ('131010', '131010', '1310', 'images/icon/33.png', '3', '131010', '车辆轮胎状态', '车辆轮胎状态', 'module_13/sys.real_show.php', '0', null);
INSERT INTO `modules` VALUES ('1311', '1311', '13', 'images/icon/1.png', '2', '1311', '历史状态', '历史状态', '', '0', null);
INSERT INTO `modules` VALUES ('131110', '131110', '1311', 'images/icon/37.png', '3', '131110', '车辆轮胎历史状态', '车辆轮胎历史状态', 'module_13/sys.his_show.php', '0', null);
INSERT INTO `modules` VALUES ('131210', '131210', '1311', 'images/icon/37.png', '3', '131210', '告警历史状态', '告警历史状态', 'module_13/sys.alarm_his131210_show.php', '0', null);
INSERT INTO `modules` VALUES ('1313', '1313', '15', 'images/icon/37.png', '2', '1313', '轮胎使用查询', '轮胎使用查询', '', '0', null);
INSERT INTO `modules` VALUES ('15', '15', '-1', 'iconCls:\'icon-undo\'', '1', '15', '统计分析', '统计分析', null, '0', null);
INSERT INTO `modules` VALUES ('131311', '131311', '1313', 'images/icon/33.png', '3', '131311', '轮胎总时长总里程查询', '轮胎总时长总里程查询', 'module_13/sys.tire_runhis_show.php', '0', null);
INSERT INTO `modules` VALUES ('1315', '1315', '15', 'images/icon/37.png', '2', '1315', '库存状态查询', '库存状态查询', '', '0', null);
INSERT INTO `modules` VALUES ('131510', '131510', '1315', 'images/icon/33.png', '3', '131510', '轮胎库存查询', '轮胎库存查询', 'module_13/sys.tirestore_charts_show.php', '0', null);
INSERT INTO `modules` VALUES ('1316', '1316', '15', 'images/icon/37.png', '2', '1316', '统计分析', '统计分析', '', '0', null);
INSERT INTO `modules` VALUES ('131610', '131610', '1316', 'images/icon/33.png', '3', '131610', '轮胎历史曲线', '轮胎历史曲线', 'module_13/sys.tirehis_charts_10.php', '0', null);
INSERT INTO `modules` VALUES ('131612', '131612', '1316', 'images/icon/33.png', '3', '131612', '轮胎历史告警', '轮胎历史告警', 'module_13/sys.tirehis_charts_12.php', '0', null);
INSERT INTO `modules` VALUES ('1410', '1410', '14', 'images/icon/37.png', '2', '1410', '报表分析', '报表分析', '', '0', null);
INSERT INTO `modules` VALUES ('141010', '141010', '1410', 'images/icon/33.png', '3', '141010', '车辆轮胎时长里程报表', '车辆轮胎时长里程报表', 'module_13/tirecourse.php', '0', null);
INSERT INTO `modules` VALUES ('141011', '141011', '1410', 'images/icon/33.png', '3', '141011', '轮胎保养记录报表', '轮胎保养记录报表', 'module_13/tireProtect.php', '0', null);
INSERT INTO `modules` VALUES ('101117', '101117', '1011', 'images/iocn/33.png', '3', '101117', '分公司管理', '分公司管理', 'module_sys/sys.company_show.php', '0', null);
INSERT INTO `modules` VALUES ('101118', '101118', '1011', 'images/icon/33.png', '3', '101118', '线路管理', '线路管理', 'module_sys/sys.roules_show.php', '0', null);

-- ----------------------------
-- Table structure for norms
-- ----------------------------
DROP TABLE IF EXISTS `norms`;
CREATE TABLE `norms` (
  `norms_id` int(11) NOT NULL AUTO_INCREMENT,
  `norms_no` varchar(20) DEFAULT NULL COMMENT '规格代码',
  `norms_name` varchar(40) DEFAULT NULL COMMENT '规格名称',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`norms_id`),
  UNIQUE KEY `norms_no` (`norms_no`),
  UNIQUE KEY `norms_name` (`norms_name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of norms
-- ----------------------------
INSERT INTO `norms` VALUES ('1', null, 'norms_name', '');
INSERT INTO `norms` VALUES ('2', null, '275/80R22.5', '');
INSERT INTO `norms` VALUES ('3', null, '77pr/889', '');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) DEFAULT NULL COMMENT '角色英文名',
  `title` varchar(64) DEFAULT NULL COMMENT '角色中文名',
  `modules_list_val` text,
  `modules_list` text COMMENT '模块列表，用逗号分隔',
  `operlist` varchar(64) DEFAULT NULL COMMENT '权限列表',
  `remark` varchar(300) DEFAULT NULL COMMENT '角色说明',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '超级管理员', '超级管理员', '10;1010;101010;101011;1011;101110;101112;101116;101117;101118;11;1110;111010;111011;1111;111110;12;1210;121010;13;1310;131010;1311;131110;131210;14;1410;141010;141011;15;1313;131311;1315;131510;1316;131610;131612;101111;101113;101114;101115;111111;131112;131614', '系统管理,用户权限管理,角色管理,用户管理,基本数据管理,修理厂管理,轮胎基本参数管理,车载终端管理,分公司管理,线路管理,轮胎管理,轮胎相关管理,轮胎参数管理,传感器管理,轮胎维护,轮胎管理,车辆管理,车辆管理,车辆维护,监测系统,实时状态,车辆轮胎状态,历史状态,车辆轮胎历史状态,告警历史状态,报表分析,报表分析,车辆轮胎时长里程报表,轮胎保养记录报表,统计分析,轮胎使用查询,轮胎总时长总里程查询,库存状态查询,轮胎库存查询,统计分析,轮胎历史曲线,轮胎历史告警,101111,101113,101114,101115,111111,131112,131614', '查看,修改,删除,添加', '拥有系统所有权限');
INSERT INTO `roles` VALUES ('2', '手持终端人员', '手持终端人员', '11;1110;111010;111011;1111;111110;111111', '轮胎管理,轮胎相关管理,轮胎参数管理,传感器管理,轮胎维护,轮胎管理,轮胎配送', '添加,删除,修改,查看', 'APP轮胎信息录入人员');
INSERT INTO `roles` VALUES ('3', '胎管员', '胎管员', '1011;101110;101111;101112;101113;101114;101115;101116;11;1110;111010;111011;1111;111110;111111;12;1210;121010;13;1310;131010;1311;131110;131210;1313;131310;131311;1315;131510;1316;131610;131612;131614;101117;101118;15', '系统管理,用户权限管理,角色管理,用户管理,基本数据管理,车队(仓库)管理,手持终端管理,轮胎品牌管理,轮胎规格管理,轮胎层级管理,轮胎花纹管理,车载终端管理,分公司管理,线路管理', '', '测试');
INSERT INTO `roles` VALUES ('4', '司机', '司机', '10;1010;101010;101011;1011;101110;101112;101116;101117;101118', '系统管理,用户权限管理,角色管理,用户管理,基本数据管理,修理厂管理,轮胎基本参数管理,车载终端管理,分公司管理,线路管理', '查看,添加,删除,修改', '车队一司机');
INSERT INTO `roles` VALUES ('5', '仓库管理人员', '仓库管理人员', '1010;101010;101011;101110;101116;101117;101118;101111;101113;101114;101115;', '用户权限管理,角色管理,用户管理,修理厂管理,车载终端管理,分公司管理,线路管理,101111,101113,101114,101115,', '添加,修改', '管理仓库');

-- ----------------------------
-- Table structure for roules
-- ----------------------------
DROP TABLE IF EXISTS `roules`;
CREATE TABLE `roules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `remark` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `roules_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of roules
-- ----------------------------
INSERT INTO `roules` VALUES ('92', '测试', '线路三');
INSERT INTO `roules` VALUES ('93', '宁航线', '808');
INSERT INTO `roules` VALUES ('94', '上班线路', '158');

-- ----------------------------
-- Table structure for sensor
-- ----------------------------
DROP TABLE IF EXISTS `sensor`;
CREATE TABLE `sensor` (
  `sensor_id` int(11) NOT NULL AUTO_INCREMENT,
  `sensor_no` varchar(20) DEFAULT NULL COMMENT '传感器编号',
  `pressure_ul` float(6,2) DEFAULT NULL COMMENT '压力上限',
  `pressure_ll` float(6,2) DEFAULT NULL COMMENT '压力下限',
  `temp_ul` int(11) DEFAULT NULL COMMENT '温度上限',
  `temp_ll` int(11) DEFAULT NULL COMMENT '温度下限',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`sensor_id`),
  UNIQUE KEY `sensor_no` (`sensor_no`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sensor
-- ----------------------------
INSERT INTO `sensor` VALUES ('1', 'd5611', '6.50', '12.50', '-40', '125', '传感器添加');
INSERT INTO `sensor` VALUES ('2', '52111', '6.50', '12.50', '-40', '125', 'BEIZHU');
INSERT INTO `sensor` VALUES ('3', 'd4511', '6.50', '12.50', '-40', '125', '单个传感器添加');
INSERT INTO `sensor` VALUES ('4', 'a1b11', '10.00', '0.00', '125', '-40', '批量添加传感器');
INSERT INTO `sensor` VALUES ('5', 'a1b12', '10.00', '0.00', '125', '-40', '批量添加传感器');
INSERT INTO `sensor` VALUES ('6', 'a1b13', '10.00', '0.00', '125', '-40', '批量添加传感器');
INSERT INTO `sensor` VALUES ('7', 'a1b14', '10.00', '0.00', '125', '-40', '批量添加传感器');
INSERT INTO `sensor` VALUES ('8', 'a1b15', '10.00', '0.00', '125', '-40', '批量添加传感器');
INSERT INTO `sensor` VALUES ('10', 'a4b01', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('11', 'a4b02', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('12', 'a4b03', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('13', 'a4b04', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('14', 'a4b05', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('15', 'a4b06', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('16', '34611', '12.50', '6.50', '125', '-40', 'test add_stamp');
INSERT INTO `sensor` VALUES ('17', 'a1b21', '10.00', '4.00', '125', '-90', '');
INSERT INTO `sensor` VALUES ('18', 'a1b22', '10.00', '4.00', '125', '-90', '');
INSERT INTO `sensor` VALUES ('19', 'a1b23', '10.00', '4.00', '125', '-90', '');
INSERT INTO `sensor` VALUES ('20', 'a1b24', '10.00', '4.00', '125', '-90', '');
INSERT INTO `sensor` VALUES ('21', 'a1b25', '10.00', '4.00', '125', '-90', '');
INSERT INTO `sensor` VALUES ('22', 'a1b26', '10.00', '4.00', '125', '-90', '');
INSERT INTO `sensor` VALUES ('23', '3d5d1', '12.00', '6.50', '125', '-40', '');
INSERT INTO `sensor` VALUES ('24', '3d5d2', '12.00', '6.50', '125', '-40', '');
INSERT INTO `sensor` VALUES ('25', '3d5d3', '12.00', '6.50', '125', '-40', '');
INSERT INTO `sensor` VALUES ('26', '3d5d4', '12.00', '6.50', '125', '-40', '');
INSERT INTO `sensor` VALUES ('27', '3d5d5', '12.00', '6.50', '125', '-40', '');
INSERT INTO `sensor` VALUES ('28', '3d5d6', '12.00', '6.50', '125', '-40', '');
INSERT INTO `sensor` VALUES ('39', 'a1b16', '12.50', '6.50', '125', '-40', '');

-- ----------------------------
-- Table structure for store
-- ----------------------------
DROP TABLE IF EXISTS `store`;
CREATE TABLE `store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `store_no` varchar(20) DEFAULT NULL COMMENT '仓库内部编号',
  `store_name` varchar(60) DEFAULT NULL COMMENT '仓库中文名',
  `contact` varchar(32) DEFAULT NULL COMMENT '联系人姓名',
  `tel` varchar(32) DEFAULT NULL COMMENT '联系电话',
  `mobile` varchar(32) DEFAULT NULL COMMENT '联系人手机号',
  `fax` varchar(32) DEFAULT NULL COMMENT '仓库传真',
  `country` varchar(100) DEFAULT NULL COMMENT '国家',
  `province` varchar(60) DEFAULT NULL COMMENT '省、直辖市',
  `city` varchar(60) DEFAULT NULL COMMENT '地级市',
  `county` varchar(60) DEFAULT NULL COMMENT '区、县',
  `address` varchar(300) DEFAULT NULL COMMENT '仓库地址',
  `remark` varchar(300) DEFAULT NULL COMMENT '仓库说明',
  PRIMARY KEY (`store_id`),
  UNIQUE KEY `store_name` (`store_name`),
  UNIQUE KEY `store_no` (`store_no`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store
-- ----------------------------
INSERT INTO `store` VALUES ('6', null, 'C001', '大厂修理厂', '李四', '13567891762', '13567891762', null, null, null, null, null, '大厂', '测试');
INSERT INTO `store` VALUES ('2', null, 'C002', '禄口修理厂', '张三', '13456712673', '13564521731', null, null, null, null, null, '禄口', '测试');
INSERT INTO `store` VALUES ('3', null, 'C003', '雨花修理厂', '王五', '13569081313', '131317367167', null, null, null, null, null, '雨花', '测试');
INSERT INTO `store` VALUES ('4', null, 'C004', '马鞍山修理厂', '稔田', '15436738178', '1231637167', null, null, null, null, null, '马鞍山', '测试');
INSERT INTO `store` VALUES ('5', null, 'C005', '淳化修理厂', '范圣贤', '1345678776', '1313978789', null, null, null, null, null, '淳化', '主要修理厂');

-- ----------------------------
-- Table structure for sys_log
-- ----------------------------
DROP TABLE IF EXISTS `sys_log`;
CREATE TABLE `sys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_type` varchar(20) DEFAULT NULL COMMENT '类型',
  `title` varchar(40) DEFAULT NULL COMMENT '标题',
  `content` varchar(200) DEFAULT NULL COMMENT '内容',
  `admin_id` int(11) DEFAULT NULL COMMENT '操作员',
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '记录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=565 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_log
-- ----------------------------
INSERT INTO `sys_log` VALUES ('1', '通用功能', '登录', 'admin登录了系统', '1', '2017-10-24 09:15:20');
INSERT INTO `sys_log` VALUES ('2', '车队(仓库)管理', '修改', '修改了车队(仓库)信息大厂修理厂', '1', '2017-10-24 09:17:14');
INSERT INTO `sys_log` VALUES ('3', '车队(仓库)管理', '新增', '添加了新车队(仓库)禄口修理厂', '1', '2017-10-24 09:18:37');
INSERT INTO `sys_log` VALUES ('4', '车队(仓库)管理', '新增', '添加了新车队(仓库)雨花修理厂', '1', '2017-10-24 09:19:38');
INSERT INTO `sys_log` VALUES ('5', '车队(仓库)管理', '新增', '添加了新车队(仓库)马鞍山修理厂', '1', '2017-10-24 09:21:35');
INSERT INTO `sys_log` VALUES ('6', '车队(仓库)管理', '新增', '添加了新车队(仓库)淳化修理厂', '1', '2017-10-24 09:24:26');
INSERT INTO `sys_log` VALUES ('7', '角色管理', '修改', '修改了角色信息胎管员', '1', '2017-10-24 09:24:45');
INSERT INTO `sys_log` VALUES ('8', '车载终端管理', '新增', '添加了新车载终端车载终端', '1', '2017-10-24 10:18:00');
INSERT INTO `sys_log` VALUES ('9', '车载终端管理', '修改', '修改了车载终端信息车载终端', '1', '2017-10-24 10:25:26');
INSERT INTO `sys_log` VALUES ('10', '车载终端管理', '修改', '修改了车载终端信息车载终端', '1', '2017-10-24 10:26:46');
INSERT INTO `sys_log` VALUES ('11', '车载终端管理', '修改', '修改了车载终端信息车载终端3', '1', '2017-10-24 10:32:38');
INSERT INTO `sys_log` VALUES ('12', '车载终端管理', '新增', '添加了新车载终端002', '1', '2017-10-24 10:33:44');
INSERT INTO `sys_log` VALUES ('13', '车载终端管理', '新增', '添加了新车载终端003', '1', '2017-10-24 10:33:56');
INSERT INTO `sys_log` VALUES ('14', '车载终端管理', '新增', '添加了新车载终端004', '1', '2017-10-24 10:34:27');
INSERT INTO `sys_log` VALUES ('15', '车载终端管理', '修改', '修改了车载终端信息002', '1', '2017-10-24 10:38:32');
INSERT INTO `sys_log` VALUES ('16', '车载终端管理', '修改', '修改了车载终端信息003', '1', '2017-10-24 10:38:42');
INSERT INTO `sys_log` VALUES ('17', '车载终端管理', '修改', '修改了车载终端信息003', '1', '2017-10-24 10:42:39');
INSERT INTO `sys_log` VALUES ('18', '车载终端管理', '修改', '修改了车载终端信息001', '1', '2017-10-24 10:43:19');
INSERT INTO `sys_log` VALUES ('19', '轮胎品牌管理', '新增', '添加了新的轮胎参数', '1', '2017-10-24 14:11:39');
INSERT INTO `sys_log` VALUES ('20', '轮胎品牌管理', '新增', '添加了新的轮胎参数', '1', '2017-10-24 14:27:09');
INSERT INTO `sys_log` VALUES ('21', '轮胎品牌管理', '新增', '添加了新的轮胎参数', '1', '2017-10-24 14:31:52');
INSERT INTO `sys_log` VALUES ('22', '轮胎品牌管理', '新增', '添加了新的轮胎参数', '1', '2017-10-24 14:39:25');
INSERT INTO `sys_log` VALUES ('23', '轮胎品牌管理', '修改', '修改了参数信息', '1', '2017-10-24 15:47:57');
INSERT INTO `sys_log` VALUES ('24', '通用功能', '登录', 'admin登录了系统', '1', '2017-10-25 08:31:38');
INSERT INTO `sys_log` VALUES ('25', '通用功能', '登录', 'admin登录了系统', '1', '2017-10-26 09:10:10');
INSERT INTO `sys_log` VALUES ('26', '通用功能', '登录', 'admin登录了系统', '1', '2017-10-26 09:10:11');
INSERT INTO `sys_log` VALUES ('27', '轮胎参数管理', '新增', '添加了新轮胎参数4', '1', '2017-10-26 09:13:39');
INSERT INTO `sys_log` VALUES ('28', '传感器管理', '新增', '添加了新传感器52111', '1', '2017-10-26 09:15:32');
INSERT INTO `sys_log` VALUES ('29', '传感器管理', '新增', '添加了新传感器d4511', '1', '2017-10-26 09:43:54');
INSERT INTO `sys_log` VALUES ('30', '传感器管理', '新增', '添加了新传感器a1b11', '1', '2017-10-26 10:29:00');
INSERT INTO `sys_log` VALUES ('31', '传感器管理', '新增', '添加了新传感器a1b12', '1', '2017-10-26 10:29:00');
INSERT INTO `sys_log` VALUES ('32', '传感器管理', '新增', '添加了新传感器a1b13', '1', '2017-10-26 10:29:00');
INSERT INTO `sys_log` VALUES ('33', '传感器管理', '新增', '添加了新传感器a1b14', '1', '2017-10-26 10:29:00');
INSERT INTO `sys_log` VALUES ('34', '传感器管理', '新增', '添加了新传感器a1b15', '1', '2017-10-26 10:29:00');
INSERT INTO `sys_log` VALUES ('35', '传感器管理', '新增', '添加了新传感器a1b16', '1', '2017-10-26 10:29:00');
INSERT INTO `sys_log` VALUES ('36', '传感器管理', '新增', '添加了新传感器a4b01', '1', '2017-10-26 10:35:15');
INSERT INTO `sys_log` VALUES ('37', '传感器管理', '新增', '添加了新传感器a4b02', '1', '2017-10-26 10:35:15');
INSERT INTO `sys_log` VALUES ('38', '传感器管理', '新增', '添加了新传感器a4b03', '1', '2017-10-26 10:35:15');
INSERT INTO `sys_log` VALUES ('39', '传感器管理', '新增', '添加了新传感器a4b04', '1', '2017-10-26 10:35:15');
INSERT INTO `sys_log` VALUES ('40', '传感器管理', '新增', '添加了新传感器a4b05', '1', '2017-10-26 10:35:15');
INSERT INTO `sys_log` VALUES ('41', '传感器管理', '新增', '添加了新传感器a4b06', '1', '2017-10-26 10:35:15');
INSERT INTO `sys_log` VALUES ('42', '轮胎管理', '新增', '添加了新轮胎d5611000', '1', '2017-10-26 13:04:59');
INSERT INTO `sys_log` VALUES ('43', '轮胎管理', '新增', '添加了新轮胎d4511000', '1', '2017-10-26 13:17:07');
INSERT INTO `sys_log` VALUES ('44', '通用功能', '登录', 'admin登录了系统', '1', '2017-10-26 13:40:44');
INSERT INTO `sys_log` VALUES ('45', '通用功能', '登录', 'admin登录了系统', '1', '2017-10-27 11:53:43');
INSERT INTO `sys_log` VALUES ('46', '车辆管理', '新增', '添加了新车辆苏A8888', '1', '2017-10-29 16:00:54');
INSERT INTO `sys_log` VALUES ('47', '轮胎替换管理', '安装', '苏A8888在所有号位安装了轮胎', '1', '2017-10-29 16:01:11');
INSERT INTO `sys_log` VALUES ('48', '通用功能', '登录', 'admin登录了系统', '1', '2017-10-29 16:12:18');
INSERT INTO `sys_log` VALUES ('49', '轮胎替换管理', '安装', '苏A8888在右前轮号位安装了轮胎', '1', '2017-10-29 16:27:46');
INSERT INTO `sys_log` VALUES ('50', '轮胎替换管理', '卸载', '苏A8888在00000000001号位卸载了轮胎', '1', '2017-10-29 16:49:43');
INSERT INTO `sys_log` VALUES ('51', '轮胎替换管理', '安装', '苏A8888在5号位安装了轮胎', '1', '2017-10-29 16:50:10');
INSERT INTO `sys_log` VALUES ('52', '轮胎管理', '新增', '添加了新轮胎a1b11000', '1', '2017-10-29 16:58:08');
INSERT INTO `sys_log` VALUES ('53', '轮胎管理', '新增', '添加了新轮胎a1b12000', '1', '2017-10-29 16:58:46');
INSERT INTO `sys_log` VALUES ('54', '轮胎管理', '新增', '添加了新轮胎a1b13000', '1', '2017-10-29 16:58:53');
INSERT INTO `sys_log` VALUES ('55', '轮胎管理', '新增', '添加了新轮胎a1b14000', '1', '2017-10-29 16:59:00');
INSERT INTO `sys_log` VALUES ('56', '轮胎管理', '新增', '添加了新轮胎a1b15000', '1', '2017-10-29 16:59:06');
INSERT INTO `sys_log` VALUES ('57', '轮胎管理', '新增', '添加了新轮胎a1b16000', '1', '2017-10-29 16:59:12');
INSERT INTO `sys_log` VALUES ('58', '轮胎替换管理', '卸载', '苏A8888在00000000005号位卸载了轮胎', '1', '2017-10-29 16:59:30');
INSERT INTO `sys_log` VALUES ('59', '轮胎替换管理', '卸载', '苏A8888在00000000001号位卸载了轮胎', '1', '2017-10-29 16:59:32');
INSERT INTO `sys_log` VALUES ('60', '轮胎替换管理', '安装', '苏A8888在1号位安装了轮胎', '1', '2017-10-29 16:59:46');
INSERT INTO `sys_log` VALUES ('61', '轮胎替换管理', '安装', '苏A8888在2号位安装了轮胎', '1', '2017-10-29 16:59:53');
INSERT INTO `sys_log` VALUES ('62', '轮胎替换管理', '安装', '苏A8888在3号位安装了轮胎', '1', '2017-10-29 16:59:59');
INSERT INTO `sys_log` VALUES ('63', '轮胎替换管理', '安装', '苏A8888在4号位安装了轮胎', '1', '2017-10-29 17:00:05');
INSERT INTO `sys_log` VALUES ('64', '轮胎替换管理', '安装', '苏A8888在5号位安装了轮胎', '1', '2017-10-29 17:00:10');
INSERT INTO `sys_log` VALUES ('65', '轮胎替换管理', '安装', '苏A8888在6号位安装了轮胎', '1', '2017-10-29 17:00:15');
INSERT INTO `sys_log` VALUES ('66', '车辆管理', '新增', '添加了新车辆苏A6666', '1', '2017-10-30 13:15:14');
INSERT INTO `sys_log` VALUES ('67', '车载终端管理', '修改', '修改了车载终端信息a4b0', '1', '2017-10-30 13:15:33');
INSERT INTO `sys_log` VALUES ('68', '车载终端管理', '修改', '修改了车载终端信息a4b0', '1', '2017-10-30 13:16:05');
INSERT INTO `sys_log` VALUES ('69', '轮胎管理', '新增', '添加了新轮胎a4b01000', '1', '2017-10-30 13:17:31');
INSERT INTO `sys_log` VALUES ('70', '轮胎管理', '新增', '添加了新轮胎a4b02000', '1', '2017-10-30 13:17:38');
INSERT INTO `sys_log` VALUES ('71', '轮胎管理', '新增', '添加了新轮胎a4b03000', '1', '2017-10-30 13:17:44');
INSERT INTO `sys_log` VALUES ('72', '轮胎管理', '新增', '添加了新轮胎a4b04000', '1', '2017-10-30 13:17:49');
INSERT INTO `sys_log` VALUES ('73', '轮胎管理', '新增', '添加了新轮胎a4b05000', '1', '2017-10-30 13:17:55');
INSERT INTO `sys_log` VALUES ('74', '轮胎管理', '新增', '添加了新轮胎a4b06000', '1', '2017-10-30 13:18:00');
INSERT INTO `sys_log` VALUES ('75', '轮胎替换管理', '安装', '苏A6666在1号位安装了轮胎', '1', '2017-10-30 13:18:48');
INSERT INTO `sys_log` VALUES ('76', '轮胎替换管理', '安装', '苏A6666在2号位安装了轮胎', '1', '2017-10-30 13:18:56');
INSERT INTO `sys_log` VALUES ('77', '轮胎替换管理', '安装', '苏A6666在3号位安装了轮胎', '1', '2017-10-30 13:19:01');
INSERT INTO `sys_log` VALUES ('78', '轮胎替换管理', '安装', '苏A6666在4号位安装了轮胎', '1', '2017-10-30 13:19:07');
INSERT INTO `sys_log` VALUES ('79', '轮胎替换管理', '安装', '苏A6666在5号位安装了轮胎', '1', '2017-10-30 13:19:14');
INSERT INTO `sys_log` VALUES ('80', '轮胎替换管理', '安装', '苏A6666在6号位安装了轮胎', '1', '2017-10-30 13:19:21');
INSERT INTO `sys_log` VALUES ('81', '通用功能', '登录', 'admin登录了系统', '1', '2017-10-30 15:02:55');
INSERT INTO `sys_log` VALUES ('82', '通用功能', '登录', 'admin登录了系统', '1', '2017-10-31 08:37:59');
INSERT INTO `sys_log` VALUES ('83', '通用功能', '登出', 'admin登出了系统', '1', '2017-10-31 11:31:07');
INSERT INTO `sys_log` VALUES ('84', '通用功能', '登录', 'admin登录了系统', '1', '2017-10-31 11:31:14');
INSERT INTO `sys_log` VALUES ('85', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-01 09:13:23');
INSERT INTO `sys_log` VALUES ('86', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-02 09:14:31');
INSERT INTO `sys_log` VALUES ('87', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-02 11:30:28');
INSERT INTO `sys_log` VALUES ('88', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-02 15:16:40');
INSERT INTO `sys_log` VALUES ('89', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-03 08:36:03');
INSERT INTO `sys_log` VALUES ('90', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-03 08:52:20');
INSERT INTO `sys_log` VALUES ('91', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-03 13:27:15');
INSERT INTO `sys_log` VALUES ('92', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-03 13:27:15');
INSERT INTO `sys_log` VALUES ('93', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-03 13:27:20');
INSERT INTO `sys_log` VALUES ('94', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-04 16:27:29');
INSERT INTO `sys_log` VALUES ('95', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-07 08:36:25');
INSERT INTO `sys_log` VALUES ('96', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-07 13:26:52');
INSERT INTO `sys_log` VALUES ('97', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-07 15:00:32');
INSERT INTO `sys_log` VALUES ('98', '用户管理', '修改', '修改了用户信息admin', '1', '2017-11-07 15:02:42');
INSERT INTO `sys_log` VALUES ('99', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-08 13:24:56');
INSERT INTO `sys_log` VALUES ('100', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-09 13:34:34');
INSERT INTO `sys_log` VALUES ('101', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-09 14:36:32');
INSERT INTO `sys_log` VALUES ('102', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-09 14:37:44');
INSERT INTO `sys_log` VALUES ('103', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-09 14:39:29');
INSERT INTO `sys_log` VALUES ('104', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-09 14:39:50');
INSERT INTO `sys_log` VALUES ('105', '角色管理', '修改', '修改了角色信息手持终端人员', '1', '2017-11-09 14:49:14');
INSERT INTO `sys_log` VALUES ('106', '用户管理', '修改', '修改了用户信息admin', '1', '2017-11-09 15:13:40');
INSERT INTO `sys_log` VALUES ('107', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-09 15:15:35');
INSERT INTO `sys_log` VALUES ('108', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-09 15:15:48');
INSERT INTO `sys_log` VALUES ('109', '车载终端管理', '修改', '修改了车载终端信息004', '1', '2017-11-09 15:21:16');
INSERT INTO `sys_log` VALUES ('110', '车载终端管理', '修改', '修改了车载终端信息004', '1', '2017-11-09 15:21:33');
INSERT INTO `sys_log` VALUES ('111', '车载终端管理', '修改', '修改了车载终端信息003', '1', '2017-11-09 15:21:38');
INSERT INTO `sys_log` VALUES ('112', '车载终端管理', '修改', '修改了车载终端信息001', '1', '2017-11-09 15:21:41');
INSERT INTO `sys_log` VALUES ('113', '车队(仓库)管理', '修改', '修改了车队(仓库)信息淳化修理厂', '1', '2017-11-09 15:45:50');
INSERT INTO `sys_log` VALUES ('114', '车队(仓库)管理', '修改', '修改了车队(仓库)信息淳化修理厂', '1', '2017-11-09 15:45:56');
INSERT INTO `sys_log` VALUES ('115', '轮胎品牌管理', '修改', '修改了参数信息', '1', '2017-11-09 15:53:48');
INSERT INTO `sys_log` VALUES ('116', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-10 09:24:43');
INSERT INTO `sys_log` VALUES ('117', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-10 13:03:39');
INSERT INTO `sys_log` VALUES ('118', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-10 13:03:44');
INSERT INTO `sys_log` VALUES ('119', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-10 13:09:45');
INSERT INTO `sys_log` VALUES ('120', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-10 13:09:53');
INSERT INTO `sys_log` VALUES ('121', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-10 13:48:29');
INSERT INTO `sys_log` VALUES ('122', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-10 13:48:42');
INSERT INTO `sys_log` VALUES ('123', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-10 13:48:49');
INSERT INTO `sys_log` VALUES ('124', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-10 13:49:51');
INSERT INTO `sys_log` VALUES ('125', '车载终端管理', '修改', '修改了车载终端信息a4b0', '1', '2017-11-10 13:50:29');
INSERT INTO `sys_log` VALUES ('126', '轮胎参数管理', '修改', '修改了轮胎参数信息2', '1', '2017-11-10 16:16:58');
INSERT INTO `sys_log` VALUES ('127', '轮胎参数管理', '修改', '修改了轮胎参数信息2', '1', '2017-11-10 16:17:05');
INSERT INTO `sys_log` VALUES ('128', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-13 09:22:26');
INSERT INTO `sys_log` VALUES ('129', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-13 11:41:42');
INSERT INTO `sys_log` VALUES ('130', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-14 09:15:23');
INSERT INTO `sys_log` VALUES ('131', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-14 11:11:26');
INSERT INTO `sys_log` VALUES ('132', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-14 13:15:49');
INSERT INTO `sys_log` VALUES ('133', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-14 15:29:33');
INSERT INTO `sys_log` VALUES ('134', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-15 09:07:37');
INSERT INTO `sys_log` VALUES ('135', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-15 09:11:52');
INSERT INTO `sys_log` VALUES ('136', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-15 10:10:12');
INSERT INTO `sys_log` VALUES ('137', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-15 10:12:05');
INSERT INTO `sys_log` VALUES ('138', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-15 10:18:54');
INSERT INTO `sys_log` VALUES ('139', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-15 10:18:55');
INSERT INTO `sys_log` VALUES ('140', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-15 10:26:02');
INSERT INTO `sys_log` VALUES ('141', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-15 13:36:39');
INSERT INTO `sys_log` VALUES ('142', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-15 18:22:25');
INSERT INTO `sys_log` VALUES ('143', '轮胎管理', '新增', '添加了新轮胎52111000', '1', '2017-11-16 15:33:03');
INSERT INTO `sys_log` VALUES ('144', '传感器管理', '新增', '添加了新传感器34611', '1', '2017-11-16 15:36:54');
INSERT INTO `sys_log` VALUES ('145', '车载终端管理', '新增', '添加了新车载终端3461', '1', '2017-11-16 15:37:38');
INSERT INTO `sys_log` VALUES ('146', '轮胎管理', '新增', '添加了新轮胎34611000', '1', '2017-11-16 15:38:00');
INSERT INTO `sys_log` VALUES ('147', '传感器管理', '新增', '添加了新传感器a1b21', '1', '2017-11-16 16:17:44');
INSERT INTO `sys_log` VALUES ('148', '传感器管理', '新增', '添加了新传感器a1b22', '1', '2017-11-16 16:17:44');
INSERT INTO `sys_log` VALUES ('149', '传感器管理', '新增', '添加了新传感器a1b23', '1', '2017-11-16 16:17:44');
INSERT INTO `sys_log` VALUES ('150', '传感器管理', '新增', '添加了新传感器a1b24', '1', '2017-11-16 16:17:44');
INSERT INTO `sys_log` VALUES ('151', '传感器管理', '新增', '添加了新传感器a1b25', '1', '2017-11-16 16:17:44');
INSERT INTO `sys_log` VALUES ('152', '传感器管理', '新增', '添加了新传感器a1b26', '1', '2017-11-16 16:17:44');
INSERT INTO `sys_log` VALUES ('153', '车载终端管理', '新增', '添加了新车载终端a1b2', '1', '2017-11-16 16:18:34');
INSERT INTO `sys_log` VALUES ('154', '轮胎管理', '新增', '添加了新轮胎a1b21000', '1', '2017-11-16 16:20:11');
INSERT INTO `sys_log` VALUES ('155', '轮胎管理', '新增', '添加了新轮胎a1b22000', '1', '2017-11-16 16:20:57');
INSERT INTO `sys_log` VALUES ('156', '轮胎管理', '新增', '添加了新轮胎a1b23000', '1', '2017-11-16 16:22:11');
INSERT INTO `sys_log` VALUES ('157', '轮胎管理', '新增', '添加了新轮胎a1b24000', '1', '2017-11-16 16:23:05');
INSERT INTO `sys_log` VALUES ('158', '轮胎管理', '删除', '删除了轮胎信息a1b11000', '1', '2017-11-16 16:50:54');
INSERT INTO `sys_log` VALUES ('159', '轮胎管理', '删除', '删除了轮胎信息d4511000', '1', '2017-11-16 16:51:37');
INSERT INTO `sys_log` VALUES ('160', '轮胎管理', '删除', '删除了轮胎信息d5611000', '1', '2017-11-16 16:54:10');
INSERT INTO `sys_log` VALUES ('161', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-16 21:57:22');
INSERT INTO `sys_log` VALUES ('162', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-16 22:11:51');
INSERT INTO `sys_log` VALUES ('163', '轮胎管理', '修改', '修改了轮胎信息a1b14000', '1', '2017-11-16 22:26:28');
INSERT INTO `sys_log` VALUES ('164', '轮胎管理', '修改', '修改了轮胎信息a1b14000', '1', '2017-11-16 22:26:57');
INSERT INTO `sys_log` VALUES ('165', '轮胎管理', '修改', '修改了轮胎信息a1b14000', '1', '2017-11-16 22:36:34');
INSERT INTO `sys_log` VALUES ('166', '轮胎管理', '修改', '修改了轮胎信息a1b14000', '1', '2017-11-16 22:36:49');
INSERT INTO `sys_log` VALUES ('167', '轮胎管理', '修改', '修改了轮胎信息a4b03000', '1', '2017-11-16 22:38:29');
INSERT INTO `sys_log` VALUES ('168', '轮胎管理', '修改', '修改了轮胎信息a4b03000', '1', '2017-11-16 22:38:43');
INSERT INTO `sys_log` VALUES ('169', '轮胎管理', '修改', '修改了轮胎信息a1b16000', '1', '2017-11-16 22:44:27');
INSERT INTO `sys_log` VALUES ('170', '轮胎管理', '修改', '修改了轮胎信息a1b16000', '1', '2017-11-16 22:46:05');
INSERT INTO `sys_log` VALUES ('171', '轮胎管理', '修改', '修改了轮胎信息a1b15000', '1', '2017-11-16 22:47:49');
INSERT INTO `sys_log` VALUES ('172', '轮胎管理', '修改', '修改了轮胎信息a1b14000', '1', '2017-11-16 22:50:05');
INSERT INTO `sys_log` VALUES ('173', '轮胎管理', '修改', '修改了轮胎信息a1b15000', '1', '2017-11-16 22:50:42');
INSERT INTO `sys_log` VALUES ('174', '轮胎管理', '修改', '修改了轮胎信息a1b14000', '1', '2017-11-16 22:51:22');
INSERT INTO `sys_log` VALUES ('175', '车辆管理', '新增', '添加了新车辆1-5612', '1', '2017-11-16 23:38:21');
INSERT INTO `sys_log` VALUES ('176', '车辆管理', '修改', '修改了车辆信息1-5612', '1', '2017-11-16 23:39:15');
INSERT INTO `sys_log` VALUES ('177', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-17 08:29:37');
INSERT INTO `sys_log` VALUES ('178', '分公司管理', '修改', '修改了分公司信息', '1', '2017-11-17 09:21:17');
INSERT INTO `sys_log` VALUES ('179', '分公司管理', '修改', '修改了分公司信息', '1', '2017-11-17 09:21:28');
INSERT INTO `sys_log` VALUES ('180', '分公司管理', '新增', '添加了新分公司', '1', '2017-11-17 09:27:10');
INSERT INTO `sys_log` VALUES ('181', '分公司管理', '删除', '删除了分公司信息分公司三', '1', '2017-11-17 09:28:08');
INSERT INTO `sys_log` VALUES ('182', '分公司管理', '新增', '添加了新分公司', '1', '2017-11-17 09:29:24');
INSERT INTO `sys_log` VALUES ('183', '线路管理', '修改', '修改了分公司信息', '1', '2017-11-17 09:36:45');
INSERT INTO `sys_log` VALUES ('184', '线路管理', '新增', '添加了新线路', '1', '2017-11-17 09:37:24');
INSERT INTO `sys_log` VALUES ('185', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-17 09:56:08');
INSERT INTO `sys_log` VALUES ('186', '角色管理', '修改', '修改了角色信息手持终端人员', '1', '2017-11-17 09:56:28');
INSERT INTO `sys_log` VALUES ('187', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 09:57:33');
INSERT INTO `sys_log` VALUES ('188', '角色管理', '修改', '修改了角色信息胎管员', '1', '2017-11-17 09:57:54');
INSERT INTO `sys_log` VALUES ('189', '角色管理', '修改', '修改了角色信息胎管员', '1', '2017-11-17 09:58:09');
INSERT INTO `sys_log` VALUES ('190', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-17 09:59:03');
INSERT INTO `sys_log` VALUES ('191', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-17 09:59:19');
INSERT INTO `sys_log` VALUES ('192', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-17 09:59:34');
INSERT INTO `sys_log` VALUES ('193', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-17 10:01:43');
INSERT INTO `sys_log` VALUES ('194', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-17 10:02:19');
INSERT INTO `sys_log` VALUES ('195', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 10:02:28');
INSERT INTO `sys_log` VALUES ('196', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 10:02:42');
INSERT INTO `sys_log` VALUES ('197', '用户管理', '新增', '添加了新用户王司机', '1', '2017-11-17 10:03:14');
INSERT INTO `sys_log` VALUES ('198', '用户管理', '修改', '修改了用户信息王司机', '1', '2017-11-17 10:03:31');
INSERT INTO `sys_log` VALUES ('199', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-17 10:43:14');
INSERT INTO `sys_log` VALUES ('200', '通用功能', '登录', '王司机登录了系统', '3', '2017-11-17 10:44:57');
INSERT INTO `sys_log` VALUES ('201', '角色管理', '修改', '修改了角色信息司机', '3', '2017-11-17 10:46:26');
INSERT INTO `sys_log` VALUES ('202', '通用功能', '登出', '王司机登出了系统', '3', '2017-11-17 10:46:36');
INSERT INTO `sys_log` VALUES ('203', '通用功能', '登录', '王司机登录了系统', '3', '2017-11-17 10:46:54');
INSERT INTO `sys_log` VALUES ('204', '角色管理', '修改', '修改了角色信息司机', '3', '2017-11-17 10:47:24');
INSERT INTO `sys_log` VALUES ('205', '通用功能', '登出', '王司机登出了系统', '3', '2017-11-17 10:47:35');
INSERT INTO `sys_log` VALUES ('206', '通用功能', '登录', '王司机登录了系统', '3', '2017-11-17 10:47:41');
INSERT INTO `sys_log` VALUES ('207', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-17 10:58:14');
INSERT INTO `sys_log` VALUES ('208', '通用功能', '登录', '王司机登录了系统', '3', '2017-11-17 11:12:22');
INSERT INTO `sys_log` VALUES ('209', '通用功能', '登出', '王司机登出了系统', '3', '2017-11-17 11:23:27');
INSERT INTO `sys_log` VALUES ('210', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-17 11:23:38');
INSERT INTO `sys_log` VALUES ('211', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-17 11:27:31');
INSERT INTO `sys_log` VALUES ('212', '通用功能', '登录', '王司机登录了系统', '3', '2017-11-17 11:27:39');
INSERT INTO `sys_log` VALUES ('213', '通用功能', '登出', '王司机登出了系统', '3', '2017-11-17 11:28:13');
INSERT INTO `sys_log` VALUES ('214', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-17 11:28:16');
INSERT INTO `sys_log` VALUES ('215', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 11:28:59');
INSERT INTO `sys_log` VALUES ('216', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-17 11:29:06');
INSERT INTO `sys_log` VALUES ('217', '通用功能', '登录', '王司机登录了系统', '3', '2017-11-17 11:29:11');
INSERT INTO `sys_log` VALUES ('218', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-17 11:29:45');
INSERT INTO `sys_log` VALUES ('219', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-17 11:30:35');
INSERT INTO `sys_log` VALUES ('220', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-17 11:30:37');
INSERT INTO `sys_log` VALUES ('221', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-17 11:30:42');
INSERT INTO `sys_log` VALUES ('222', '通用功能', '登录', '王司机登录了系统', '3', '2017-11-17 11:30:48');
INSERT INTO `sys_log` VALUES ('223', '通用功能', '登出', '王司机登出了系统', '3', '2017-11-17 11:30:58');
INSERT INTO `sys_log` VALUES ('224', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-17 11:31:00');
INSERT INTO `sys_log` VALUES ('225', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-17 11:32:05');
INSERT INTO `sys_log` VALUES ('226', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-17 11:32:06');
INSERT INTO `sys_log` VALUES ('227', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 11:33:18');
INSERT INTO `sys_log` VALUES ('228', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 11:33:39');
INSERT INTO `sys_log` VALUES ('229', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 11:33:56');
INSERT INTO `sys_log` VALUES ('230', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 11:34:30');
INSERT INTO `sys_log` VALUES ('231', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 11:36:59');
INSERT INTO `sys_log` VALUES ('232', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 11:56:09');
INSERT INTO `sys_log` VALUES ('233', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-17 11:57:25');
INSERT INTO `sys_log` VALUES ('234', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-17 16:37:43');
INSERT INTO `sys_log` VALUES ('235', '车辆管理', '修改', '修改了车辆信息1-5612', '1', '2017-11-17 17:00:12');
INSERT INTO `sys_log` VALUES ('236', '轮胎替换管理', '卸载', '苏A6666在00000000001号位卸载了轮胎', '1', '2017-11-17 17:07:24');
INSERT INTO `sys_log` VALUES ('237', '轮胎替换管理', '安装', '苏A6666在1号位安装了轮胎', '1', '2017-11-17 17:08:12');
INSERT INTO `sys_log` VALUES ('238', '轮胎替换管理', '卸载', '苏A6666在00000000001号位卸载了轮胎', '1', '2017-11-17 17:09:32');
INSERT INTO `sys_log` VALUES ('239', '轮胎替换管理', '卸载', '苏A8888在00000000002号位卸载了轮胎', '1', '2017-11-17 17:09:33');
INSERT INTO `sys_log` VALUES ('240', '轮胎替换管理', '安装', '苏A6666在1号位安装了轮胎', '1', '2017-11-17 17:11:17');
INSERT INTO `sys_log` VALUES ('241', '轮胎替换管理', '安装', '苏A8888在1号位安装了轮胎', '1', '2017-11-17 17:11:58');
INSERT INTO `sys_log` VALUES ('242', '轮胎替换管理', '卸载', '苏A8888在00000000001号位卸载了轮胎', '1', '2017-11-17 17:13:18');
INSERT INTO `sys_log` VALUES ('243', '轮胎替换管理', '卸载', '苏A6666在00000000002号位卸载了轮胎', '1', '2017-11-17 17:13:19');
INSERT INTO `sys_log` VALUES ('244', '轮胎替换管理', '安装', '苏A8888在1号位安装了轮胎', '1', '2017-11-17 17:13:43');
INSERT INTO `sys_log` VALUES ('245', '轮胎替换管理', '安装', '1-5612在1号位安装了轮胎', '1', '2017-11-17 17:14:35');
INSERT INTO `sys_log` VALUES ('246', '轮胎管理', '新增', '添加了新轮胎0000aa43', '1', '2017-11-17 17:17:45');
INSERT INTO `sys_log` VALUES ('247', '轮胎替换管理', '卸载', '苏A8888在00000000003号位卸载了轮胎', '1', '2017-11-17 18:26:53');
INSERT INTO `sys_log` VALUES ('248', '轮胎替换管理', '安装', '苏A8888在2号位安装了轮胎', '1', '2017-11-17 18:27:32');
INSERT INTO `sys_log` VALUES ('249', '轮胎替换管理', '卸载', '苏A8888在00000000002号位卸载了轮胎', '1', '2017-11-17 18:43:12');
INSERT INTO `sys_log` VALUES ('250', '轮胎替换管理', '安装', '苏A8888在2号位安装了轮胎', '1', '2017-11-17 18:43:17');
INSERT INTO `sys_log` VALUES ('251', '轮胎替换管理', '卸载', '苏A8888在00000000002号位卸载了轮胎', '1', '2017-11-17 18:43:56');
INSERT INTO `sys_log` VALUES ('252', '轮胎替换管理', '卸载', '苏A8888在00000000001号位卸载了轮胎', '1', '2017-11-17 18:43:57');
INSERT INTO `sys_log` VALUES ('253', '轮胎替换管理', '安装', '苏A8888在2号位安装了轮胎', '1', '2017-11-17 18:44:35');
INSERT INTO `sys_log` VALUES ('254', '轮胎替换管理', '卸载', '苏A8888在00000000002号位卸载了轮胎', '1', '2017-11-17 18:49:16');
INSERT INTO `sys_log` VALUES ('255', '轮胎替换管理', '卸载', '苏A8888在00000000004号位卸载了轮胎', '1', '2017-11-17 18:49:16');
INSERT INTO `sys_log` VALUES ('256', '轮胎替换管理', '卸载', '苏A8888在00000000005号位卸载了轮胎', '1', '2017-11-17 18:49:23');
INSERT INTO `sys_log` VALUES ('257', '轮胎替换管理', '安装', '苏A8888在1号位安装了轮胎', '1', '2017-11-17 18:49:46');
INSERT INTO `sys_log` VALUES ('258', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-20 09:30:03');
INSERT INTO `sys_log` VALUES ('259', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-20 09:30:23');
INSERT INTO `sys_log` VALUES ('260', '分公司管理', '新增', '添加了新分公司', '1', '2017-11-20 09:35:50');
INSERT INTO `sys_log` VALUES ('261', '分公司管理', '修改', '修改了分公司信息', '1', '2017-11-20 09:36:08');
INSERT INTO `sys_log` VALUES ('262', '线路管理', '新增', '添加了新线路', '1', '2017-11-20 09:36:28');
INSERT INTO `sys_log` VALUES ('263', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 11:35:17');
INSERT INTO `sys_log` VALUES ('264', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-21 13:31:20');
INSERT INTO `sys_log` VALUES ('265', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-21 13:34:27');
INSERT INTO `sys_log` VALUES ('266', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-21 13:37:04');
INSERT INTO `sys_log` VALUES ('267', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-21 13:52:17');
INSERT INTO `sys_log` VALUES ('268', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-21 13:57:52');
INSERT INTO `sys_log` VALUES ('269', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-21 14:15:20');
INSERT INTO `sys_log` VALUES ('270', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-21 14:17:15');
INSERT INTO `sys_log` VALUES ('271', '角色管理', '修改', '修改了角色信息手持终端人员', '1', '2017-11-21 14:18:02');
INSERT INTO `sys_log` VALUES ('272', '角色管理', '新增', '添加了新角色仓库管理人员', '1', '2017-11-21 14:20:43');
INSERT INTO `sys_log` VALUES ('273', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-21 14:40:58');
INSERT INTO `sys_log` VALUES ('274', '角色管理', '修改', '修改了角色信息司机', '1', '2017-11-21 14:52:51');
INSERT INTO `sys_log` VALUES ('275', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-21 14:52:59');
INSERT INTO `sys_log` VALUES ('276', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 14:57:14');
INSERT INTO `sys_log` VALUES ('277', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-21 14:57:19');
INSERT INTO `sys_log` VALUES ('278', '通用功能', '登录', '王司机登录了系统', '3', '2017-11-21 14:57:28');
INSERT INTO `sys_log` VALUES ('279', '通用功能', '登出', '王司机登出了系统', '3', '2017-11-21 14:57:40');
INSERT INTO `sys_log` VALUES ('280', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 14:57:44');
INSERT INTO `sys_log` VALUES ('281', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 15:59:22');
INSERT INTO `sys_log` VALUES ('282', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 15:59:46');
INSERT INTO `sys_log` VALUES ('283', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:00:25');
INSERT INTO `sys_log` VALUES ('284', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:01:29');
INSERT INTO `sys_log` VALUES ('285', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:07:56');
INSERT INTO `sys_log` VALUES ('286', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:16:21');
INSERT INTO `sys_log` VALUES ('287', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:16:42');
INSERT INTO `sys_log` VALUES ('288', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:17:29');
INSERT INTO `sys_log` VALUES ('289', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:17:49');
INSERT INTO `sys_log` VALUES ('290', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:24:10');
INSERT INTO `sys_log` VALUES ('291', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:24:33');
INSERT INTO `sys_log` VALUES ('292', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:24:38');
INSERT INTO `sys_log` VALUES ('293', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:33:35');
INSERT INTO `sys_log` VALUES ('294', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:34:16');
INSERT INTO `sys_log` VALUES ('295', '通用功能', '登录', '王司机登录了系统', '3', '2017-11-21 16:34:55');
INSERT INTO `sys_log` VALUES ('296', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:42:01');
INSERT INTO `sys_log` VALUES ('297', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:42:05');
INSERT INTO `sys_log` VALUES ('298', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:43:01');
INSERT INTO `sys_log` VALUES ('299', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:44:05');
INSERT INTO `sys_log` VALUES ('300', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:44:26');
INSERT INTO `sys_log` VALUES ('301', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:48:54');
INSERT INTO `sys_log` VALUES ('302', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 16:49:44');
INSERT INTO `sys_log` VALUES ('303', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:02:09');
INSERT INTO `sys_log` VALUES ('304', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:03:01');
INSERT INTO `sys_log` VALUES ('305', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:03:06');
INSERT INTO `sys_log` VALUES ('306', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:03:16');
INSERT INTO `sys_log` VALUES ('307', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:05:33');
INSERT INTO `sys_log` VALUES ('308', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:06:07');
INSERT INTO `sys_log` VALUES ('309', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:06:12');
INSERT INTO `sys_log` VALUES ('310', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:06:54');
INSERT INTO `sys_log` VALUES ('311', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:07:19');
INSERT INTO `sys_log` VALUES ('312', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:07:56');
INSERT INTO `sys_log` VALUES ('313', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:08:28');
INSERT INTO `sys_log` VALUES ('314', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:09:29');
INSERT INTO `sys_log` VALUES ('315', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:12:17');
INSERT INTO `sys_log` VALUES ('316', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:12:58');
INSERT INTO `sys_log` VALUES ('317', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:13:32');
INSERT INTO `sys_log` VALUES ('318', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:16:51');
INSERT INTO `sys_log` VALUES ('319', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:17:05');
INSERT INTO `sys_log` VALUES ('320', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:17:33');
INSERT INTO `sys_log` VALUES ('321', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:25:53');
INSERT INTO `sys_log` VALUES ('322', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:26:43');
INSERT INTO `sys_log` VALUES ('323', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:35:32');
INSERT INTO `sys_log` VALUES ('324', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:50:04');
INSERT INTO `sys_log` VALUES ('325', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:50:16');
INSERT INTO `sys_log` VALUES ('326', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:56:42');
INSERT INTO `sys_log` VALUES ('327', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-21 17:57:33');
INSERT INTO `sys_log` VALUES ('328', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 08:22:05');
INSERT INTO `sys_log` VALUES ('329', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 08:24:10');
INSERT INTO `sys_log` VALUES ('330', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 08:33:42');
INSERT INTO `sys_log` VALUES ('331', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 08:53:44');
INSERT INTO `sys_log` VALUES ('332', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 08:56:33');
INSERT INTO `sys_log` VALUES ('333', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:00:25');
INSERT INTO `sys_log` VALUES ('334', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:04:41');
INSERT INTO `sys_log` VALUES ('335', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:09:33');
INSERT INTO `sys_log` VALUES ('336', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:09:55');
INSERT INTO `sys_log` VALUES ('337', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:11:12');
INSERT INTO `sys_log` VALUES ('338', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:14:53');
INSERT INTO `sys_log` VALUES ('339', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:15:05');
INSERT INTO `sys_log` VALUES ('340', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 09:16:25');
INSERT INTO `sys_log` VALUES ('341', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:19:03');
INSERT INTO `sys_log` VALUES ('342', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:21:09');
INSERT INTO `sys_log` VALUES ('343', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:45:25');
INSERT INTO `sys_log` VALUES ('344', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:47:46');
INSERT INTO `sys_log` VALUES ('345', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 09:49:30');
INSERT INTO `sys_log` VALUES ('346', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:49:36');
INSERT INTO `sys_log` VALUES ('347', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 09:49:52');
INSERT INTO `sys_log` VALUES ('348', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:49:57');
INSERT INTO `sys_log` VALUES ('349', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:55:42');
INSERT INTO `sys_log` VALUES ('350', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 09:59:43');
INSERT INTO `sys_log` VALUES ('351', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:00:55');
INSERT INTO `sys_log` VALUES ('352', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:01:26');
INSERT INTO `sys_log` VALUES ('353', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:01:42');
INSERT INTO `sys_log` VALUES ('354', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:02:23');
INSERT INTO `sys_log` VALUES ('355', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:02:35');
INSERT INTO `sys_log` VALUES ('356', '角色管理', '修改', '修改了角色信息仓库管理人员', '1', '2017-11-22 10:03:00');
INSERT INTO `sys_log` VALUES ('357', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:03:30');
INSERT INTO `sys_log` VALUES ('358', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:04:01');
INSERT INTO `sys_log` VALUES ('359', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:04:35');
INSERT INTO `sys_log` VALUES ('360', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:05:07');
INSERT INTO `sys_log` VALUES ('361', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:07:42');
INSERT INTO `sys_log` VALUES ('362', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:08:09');
INSERT INTO `sys_log` VALUES ('363', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:08:34');
INSERT INTO `sys_log` VALUES ('364', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:10:59');
INSERT INTO `sys_log` VALUES ('365', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:11:09');
INSERT INTO `sys_log` VALUES ('366', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:15:49');
INSERT INTO `sys_log` VALUES ('367', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:16:19');
INSERT INTO `sys_log` VALUES ('368', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:17:29');
INSERT INTO `sys_log` VALUES ('369', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:17:34');
INSERT INTO `sys_log` VALUES ('370', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:17:48');
INSERT INTO `sys_log` VALUES ('371', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:17:53');
INSERT INTO `sys_log` VALUES ('372', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:19:37');
INSERT INTO `sys_log` VALUES ('373', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:26:24');
INSERT INTO `sys_log` VALUES ('374', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:26:53');
INSERT INTO `sys_log` VALUES ('375', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:27:54');
INSERT INTO `sys_log` VALUES ('376', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 10:28:08');
INSERT INTO `sys_log` VALUES ('377', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:28:13');
INSERT INTO `sys_log` VALUES ('378', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 10:42:54');
INSERT INTO `sys_log` VALUES ('379', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-22 13:36:02');
INSERT INTO `sys_log` VALUES ('380', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 13:36:06');
INSERT INTO `sys_log` VALUES ('381', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 13:38:16');
INSERT INTO `sys_log` VALUES ('382', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 13:58:48');
INSERT INTO `sys_log` VALUES ('383', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 13:58:55');
INSERT INTO `sys_log` VALUES ('384', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 14:17:09');
INSERT INTO `sys_log` VALUES ('385', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 14:17:17');
INSERT INTO `sys_log` VALUES ('386', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 14:18:44');
INSERT INTO `sys_log` VALUES ('387', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 14:18:48');
INSERT INTO `sys_log` VALUES ('388', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 14:24:12');
INSERT INTO `sys_log` VALUES ('389', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 15:04:36');
INSERT INTO `sys_log` VALUES ('390', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 15:07:03');
INSERT INTO `sys_log` VALUES ('391', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 15:20:18');
INSERT INTO `sys_log` VALUES ('392', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 15:20:23');
INSERT INTO `sys_log` VALUES ('393', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 15:20:44');
INSERT INTO `sys_log` VALUES ('394', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 15:20:50');
INSERT INTO `sys_log` VALUES ('395', '角色管理', '修改', '修改了角色信息胎管员', '1', '2017-11-22 15:26:17');
INSERT INTO `sys_log` VALUES ('396', '角色管理', '修改', '修改了角色信息胎管员', '1', '2017-11-22 15:26:26');
INSERT INTO `sys_log` VALUES ('397', '角色管理', '修改', '修改了角色信息手持终端人员', '1', '2017-11-22 15:26:55');
INSERT INTO `sys_log` VALUES ('398', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 15:59:50');
INSERT INTO `sys_log` VALUES ('399', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 16:07:37');
INSERT INTO `sys_log` VALUES ('400', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 16:07:41');
INSERT INTO `sys_log` VALUES ('401', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 16:07:55');
INSERT INTO `sys_log` VALUES ('402', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 16:08:01');
INSERT INTO `sys_log` VALUES ('403', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 16:08:39');
INSERT INTO `sys_log` VALUES ('404', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 16:40:04');
INSERT INTO `sys_log` VALUES ('405', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 16:40:09');
INSERT INTO `sys_log` VALUES ('406', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-22 16:41:04');
INSERT INTO `sys_log` VALUES ('407', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 16:41:19');
INSERT INTO `sys_log` VALUES ('408', '轮胎参数管理', '修改', '修改了轮胎参数信息4', '1', '2017-11-22 17:07:57');
INSERT INTO `sys_log` VALUES ('409', '轮胎参数管理', '修改', '修改了轮胎参数信息4', '1', '2017-11-22 17:08:02');
INSERT INTO `sys_log` VALUES ('410', '轮胎参数管理', '新增', '添加了新轮胎参数5', '1', '2017-11-22 17:08:48');
INSERT INTO `sys_log` VALUES ('411', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-22 18:21:14');
INSERT INTO `sys_log` VALUES ('412', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 08:25:24');
INSERT INTO `sys_log` VALUES ('413', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 09:04:04');
INSERT INTO `sys_log` VALUES ('414', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 14:08:08');
INSERT INTO `sys_log` VALUES ('415', '传感器管理', '新增', '添加了新传感器11', '1', '2017-11-23 14:26:47');
INSERT INTO `sys_log` VALUES ('416', '传感器管理', '新增', '添加了新传感器21', '1', '2017-11-23 14:28:17');
INSERT INTO `sys_log` VALUES ('417', '传感器管理', '删除', '删除了传感器信息21', '1', '2017-11-23 14:32:18');
INSERT INTO `sys_log` VALUES ('418', '传感器管理', '删除', '删除了传感器信息11', '1', '2017-11-23 14:32:28');
INSERT INTO `sys_log` VALUES ('419', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-23 14:34:31');
INSERT INTO `sys_log` VALUES ('420', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 14:34:35');
INSERT INTO `sys_log` VALUES ('421', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 14:34:52');
INSERT INTO `sys_log` VALUES ('422', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-23 14:34:59');
INSERT INTO `sys_log` VALUES ('423', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 14:35:02');
INSERT INTO `sys_log` VALUES ('424', '通用功能', '登录', '轮胎注册登录了系统', '2', '2017-11-23 14:35:09');
INSERT INTO `sys_log` VALUES ('425', '通用功能', '登出', '轮胎注册登出了系统', '2', '2017-11-23 14:35:24');
INSERT INTO `sys_log` VALUES ('426', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 14:35:26');
INSERT INTO `sys_log` VALUES ('427', '传感器管理', '新增', '添加了新传感器11', '1', '2017-11-23 14:35:53');
INSERT INTO `sys_log` VALUES ('428', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 14:36:01');
INSERT INTO `sys_log` VALUES ('429', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 14:36:07');
INSERT INTO `sys_log` VALUES ('430', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-23 14:56:49');
INSERT INTO `sys_log` VALUES ('431', '用户管理', '修改', '修改了用户信息admin', '1', '2017-11-23 14:57:35');
INSERT INTO `sys_log` VALUES ('432', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 14:57:38');
INSERT INTO `sys_log` VALUES ('433', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 14:57:44');
INSERT INTO `sys_log` VALUES ('434', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 14:57:48');
INSERT INTO `sys_log` VALUES ('435', '通用功能', '登录', '轮胎注册登录了系统', '2', '2017-11-23 14:57:56');
INSERT INTO `sys_log` VALUES ('436', '传感器管理', '新增', '添加了新传感器21', '2', '2017-11-23 14:58:35');
INSERT INTO `sys_log` VALUES ('437', '传感器管理', '新增', '添加了新传感器31', '2', '2017-11-23 15:01:37');
INSERT INTO `sys_log` VALUES ('438', '传感器管理', '新增', '添加了关联轮胎31000', '2', '2017-11-23 15:01:37');
INSERT INTO `sys_log` VALUES ('439', '传感器管理', '新增', '添加了新传感器41', '2', '2017-11-23 15:04:36');
INSERT INTO `sys_log` VALUES ('440', '传感器管理', '新增', '添加了关联轮胎41000', '2', '2017-11-23 15:04:36');
INSERT INTO `sys_log` VALUES ('441', '通用功能', '', '修改了密码', '2', '2017-11-23 15:08:26');
INSERT INTO `sys_log` VALUES ('442', '通用功能', '登出', '轮胎注册登出了系统', '2', '2017-11-23 15:08:29');
INSERT INTO `sys_log` VALUES ('443', '通用功能', '登录', '轮胎注册登录了系统', '2', '2017-11-23 15:08:37');
INSERT INTO `sys_log` VALUES ('444', '通用功能', '', '修改了密码', '2', '2017-11-23 15:08:55');
INSERT INTO `sys_log` VALUES ('445', '通用功能', '登出', '轮胎注册登出了系统', '2', '2017-11-23 15:08:57');
INSERT INTO `sys_log` VALUES ('446', '通用功能', '登录', '轮胎注册登录了系统', '2', '2017-11-23 15:09:09');
INSERT INTO `sys_log` VALUES ('447', '通用功能', '登出', '轮胎注册登出了系统', '2', '2017-11-23 15:09:20');
INSERT INTO `sys_log` VALUES ('448', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:09:41');
INSERT INTO `sys_log` VALUES ('449', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 16:09:46');
INSERT INTO `sys_log` VALUES ('450', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:10:32');
INSERT INTO `sys_log` VALUES ('451', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:10:39');
INSERT INTO `sys_log` VALUES ('452', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:14:26');
INSERT INTO `sys_log` VALUES ('453', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:23:13');
INSERT INTO `sys_log` VALUES ('454', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 16:23:20');
INSERT INTO `sys_log` VALUES ('455', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:24:41');
INSERT INTO `sys_log` VALUES ('456', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 16:24:45');
INSERT INTO `sys_log` VALUES ('457', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:24:59');
INSERT INTO `sys_log` VALUES ('458', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 16:25:03');
INSERT INTO `sys_log` VALUES ('459', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:26:11');
INSERT INTO `sys_log` VALUES ('460', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 16:26:15');
INSERT INTO `sys_log` VALUES ('461', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:26:22');
INSERT INTO `sys_log` VALUES ('462', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 16:26:25');
INSERT INTO `sys_log` VALUES ('463', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:26:27');
INSERT INTO `sys_log` VALUES ('464', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 16:27:08');
INSERT INTO `sys_log` VALUES ('465', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:27:09');
INSERT INTO `sys_log` VALUES ('466', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 16:27:12');
INSERT INTO `sys_log` VALUES ('467', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:27:19');
INSERT INTO `sys_log` VALUES ('468', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 16:27:22');
INSERT INTO `sys_log` VALUES ('469', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 16:27:36');
INSERT INTO `sys_log` VALUES ('470', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 17:51:02');
INSERT INTO `sys_log` VALUES ('471', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 17:51:05');
INSERT INTO `sys_log` VALUES ('472', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-23 17:55:02');
INSERT INTO `sys_log` VALUES ('473', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-23 18:00:16');
INSERT INTO `sys_log` VALUES ('474', '角色管理', '修改', '修改了角色信息', '1', '2017-11-23 19:30:45');
INSERT INTO `sys_log` VALUES ('475', '角色管理', '修改', '修改了角色信息手持终端人员', '1', '2017-11-23 19:31:01');
INSERT INTO `sys_log` VALUES ('476', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-24 08:45:20');
INSERT INTO `sys_log` VALUES ('477', '角色管理', '新增', '添加了新角色超级管理员2', '1', '2017-11-24 10:02:01');
INSERT INTO `sys_log` VALUES ('478', '角色管理', '删除', '删除了角色信息超级管理员2', '1', '2017-11-24 10:02:57');
INSERT INTO `sys_log` VALUES ('479', '角色管理', '新增', '添加了新角色11', '1', '2017-11-24 10:15:25');
INSERT INTO `sys_log` VALUES ('480', '角色管理', '删除', '删除了角色信息11', '1', '2017-11-24 10:15:33');
INSERT INTO `sys_log` VALUES ('481', '角色管理', '新增', '添加了新角色11', '1', '2017-11-24 10:15:48');
INSERT INTO `sys_log` VALUES ('482', '角色管理', '删除', '删除了角色信息11', '1', '2017-11-24 10:15:52');
INSERT INTO `sys_log` VALUES ('483', '角色管理', '新增', '添加了新角色22', '1', '2017-11-24 10:16:36');
INSERT INTO `sys_log` VALUES ('484', '角色管理', '删除', '删除了角色信息22', '1', '2017-11-24 10:16:47');
INSERT INTO `sys_log` VALUES ('485', '角色管理', '修改', '修改了角色信息', '1', '2017-11-24 10:22:10');
INSERT INTO `sys_log` VALUES ('486', '角色管理', '修改', '修改了角色信息超级管理员', '1', '2017-11-24 10:22:24');
INSERT INTO `sys_log` VALUES ('487', '用户管理', '新增', '添加了新用户11', '1', '2017-11-24 10:47:15');
INSERT INTO `sys_log` VALUES ('488', '用户管理', '修改', '修改了用户信息1122', '1', '2017-11-24 10:47:33');
INSERT INTO `sys_log` VALUES ('489', '用户管理', '删除', '删除了用户信息1122', '1', '2017-11-24 10:47:38');
INSERT INTO `sys_log` VALUES ('490', '用户管理', '新增', '添加了新用户11', '1', '2017-11-24 10:47:47');
INSERT INTO `sys_log` VALUES ('491', '用户管理', '删除', '删除了用户信息11', '1', '2017-11-24 10:47:51');
INSERT INTO `sys_log` VALUES ('492', '用户管理', '新增', '添加了新用户11', '1', '2017-11-24 10:48:13');
INSERT INTO `sys_log` VALUES ('493', '用户管理', '删除', '删除了用户信息11', '1', '2017-11-24 10:48:19');
INSERT INTO `sys_log` VALUES ('494', '用户管理', '新增', '添加了新用户11', '1', '2017-11-24 10:50:08');
INSERT INTO `sys_log` VALUES ('495', '用户管理', '删除', '删除了用户信息11', '1', '2017-11-24 10:50:14');
INSERT INTO `sys_log` VALUES ('496', '用户管理', '新增', '添加了新用户111', '1', '2017-11-24 10:53:35');
INSERT INTO `sys_log` VALUES ('497', '用户管理', '删除', '删除了用户信息111', '1', '2017-11-24 10:53:39');
INSERT INTO `sys_log` VALUES ('498', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-24 10:54:18');
INSERT INTO `sys_log` VALUES ('499', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-24 10:54:30');
INSERT INTO `sys_log` VALUES ('500', '用户管理', '修改', '修改了用户信息admin1', '1', '2017-11-24 11:09:20');
INSERT INTO `sys_log` VALUES ('501', '用户管理', '修改', '修改了用户信息admin', '1', '2017-11-24 11:09:59');
INSERT INTO `sys_log` VALUES ('502', '用户管理', '修改', '修改了用户信息admin', '1', '2017-11-24 11:16:18');
INSERT INTO `sys_log` VALUES ('503', '用户管理', '修改', '修改了用户信息王司机', '1', '2017-11-24 11:22:05');
INSERT INTO `sys_log` VALUES ('504', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-24 11:32:40');
INSERT INTO `sys_log` VALUES ('505', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-24 11:32:59');
INSERT INTO `sys_log` VALUES ('506', '用户管理', '修改', '修改了用户信息轮胎注册', '1', '2017-11-24 11:35:28');
INSERT INTO `sys_log` VALUES ('507', '车队(仓库)管理', '新增', '添加了新车队(仓库)淳化修理厂1', '1', '2017-11-24 11:57:27');
INSERT INTO `sys_log` VALUES ('508', '车队(仓库)管理', '修改', '修改了车队(仓库)信息淳化修理厂1', '1', '2017-11-24 11:57:48');
INSERT INTO `sys_log` VALUES ('509', '车队(仓库)管理', '删除', '删除了车队(仓库)信息淳化修理厂1', '1', '2017-11-24 11:57:55');
INSERT INTO `sys_log` VALUES ('510', '轮胎品牌管理', '新增', '添加了新的轮胎参数', '1', '2017-11-24 12:45:30');
INSERT INTO `sys_log` VALUES ('511', '轮胎品牌管理', '删除', '删除了品牌信息1', '1', '2017-11-24 12:45:36');
INSERT INTO `sys_log` VALUES ('512', '轮胎品牌管理', '新增', '添加了新的轮胎参数', '1', '2017-11-24 12:45:40');
INSERT INTO `sys_log` VALUES ('513', '轮胎品牌管理', '修改', '修改了参数信息', '1', '2017-11-24 12:45:45');
INSERT INTO `sys_log` VALUES ('514', '轮胎品牌管理', '删除', '删除了品牌信息12', '1', '2017-11-24 12:45:50');
INSERT INTO `sys_log` VALUES ('515', '轮胎品牌管理', '新增', '添加了新的轮胎参数', '1', '2017-11-24 12:45:59');
INSERT INTO `sys_log` VALUES ('516', '轮胎品牌管理', '删除', '删除了品牌信息1', '1', '2017-11-24 12:46:03');
INSERT INTO `sys_log` VALUES ('517', '轮胎品牌管理', '新增', '添加了新的轮胎参数', '1', '2017-11-24 12:46:16');
INSERT INTO `sys_log` VALUES ('518', '轮胎品牌管理', '删除', '删除了品牌信息12', '1', '2017-11-24 12:46:20');
INSERT INTO `sys_log` VALUES ('519', '轮胎品牌管理', '新增', '添加了新的轮胎参数', '1', '2017-11-24 12:46:29');
INSERT INTO `sys_log` VALUES ('520', '轮胎品牌管理', '删除', '删除了品牌信息12', '1', '2017-11-24 12:46:33');
INSERT INTO `sys_log` VALUES ('521', '轮胎品牌管理', '新增', '添加了新的轮胎参数', '1', '2017-11-24 12:47:32');
INSERT INTO `sys_log` VALUES ('522', '轮胎品牌管理', '删除', '删除了品牌信息1', '1', '2017-11-24 12:47:37');
INSERT INTO `sys_log` VALUES ('523', '车载终端管理', '新增', '添加了新车载终端1', '1', '2017-11-24 13:23:01');
INSERT INTO `sys_log` VALUES ('524', '车载终端管理', '修改', '修改了车载终端信息1', '1', '2017-11-24 13:23:18');
INSERT INTO `sys_log` VALUES ('525', '车载终端管理', '修改', '修改了车载终端信息1', '1', '2017-11-24 13:23:30');
INSERT INTO `sys_log` VALUES ('526', '车载终端管理', '修改', '修改了车载终端信息1', '1', '2017-11-24 13:23:36');
INSERT INTO `sys_log` VALUES ('527', '车载终端管理', '修改', '修改了车载终端信息1', '1', '2017-11-24 13:23:49');
INSERT INTO `sys_log` VALUES ('528', '车载终端管理', '修改', '修改了车载终端信息1', '1', '2017-11-24 13:25:13');
INSERT INTO `sys_log` VALUES ('529', '车载终端管理', '修改', '修改了车载终端信息1', '1', '2017-11-24 13:25:19');
INSERT INTO `sys_log` VALUES ('530', '车载终端管理', '删除', '删除了车载终端信息1', '1', '2017-11-24 13:25:24');
INSERT INTO `sys_log` VALUES ('531', '车载终端管理', '修改', '修改了车载终端信息3d5d', '1', '2017-11-24 13:25:36');
INSERT INTO `sys_log` VALUES ('532', '分公司管理', '新增', '添加了新分公司', '1', '2017-11-24 13:33:55');
INSERT INTO `sys_log` VALUES ('533', '分公司管理', '新增', '添加了新分公司', '1', '2017-11-24 13:33:57');
INSERT INTO `sys_log` VALUES ('534', '分公司管理', '修改', '修改了分公司信息', '1', '2017-11-24 13:34:12');
INSERT INTO `sys_log` VALUES ('535', '分公司管理', '删除', '删除了分公司信息22', '1', '2017-11-24 13:34:14');
INSERT INTO `sys_log` VALUES ('536', '轮胎参数管理', '修改', '修改了轮胎参数信息3', '1', '2017-11-24 13:54:07');
INSERT INTO `sys_log` VALUES ('537', '轮胎参数管理', '修改', '修改了轮胎参数信息5', '1', '2017-11-24 14:02:09');
INSERT INTO `sys_log` VALUES ('538', '轮胎参数管理', '修改', '修改了轮胎参数信息2', '1', '2017-11-24 14:02:36');
INSERT INTO `sys_log` VALUES ('539', '通用功能', '登出', 'admin登出了系统', '1', '2017-11-24 14:04:58');
INSERT INTO `sys_log` VALUES ('540', '通用功能', '登录', 'admin登录了系统', '1', '2017-11-24 14:04:59');
INSERT INTO `sys_log` VALUES ('541', '轮胎参数管理', '新增', '添加了新轮胎参数6', '1', '2017-11-24 14:06:11');
INSERT INTO `sys_log` VALUES ('542', '轮胎参数管理', '修改', '修改了轮胎参数信息6', '1', '2017-11-24 14:06:16');
INSERT INTO `sys_log` VALUES ('543', '轮胎参数管理', '删除', '删除了轮胎参数信息6', '1', '2017-11-24 14:06:21');
INSERT INTO `sys_log` VALUES ('544', '传感器管理', '新增', '添加了新传感器111111', '1', '2017-11-24 14:13:47');
INSERT INTO `sys_log` VALUES ('545', '传感器管理', '新增', '添加了新传感器121', '1', '2017-11-24 14:13:58');
INSERT INTO `sys_log` VALUES ('546', '传感器管理', '删除', '删除了传感器信息111111', '1', '2017-11-24 14:14:06');
INSERT INTO `sys_log` VALUES ('547', '传感器管理', '删除', '删除了传感器信息121', '1', '2017-11-24 14:14:13');
INSERT INTO `sys_log` VALUES ('548', '传感器管理', '删除', '删除了传感器信息41', '1', '2017-11-24 14:14:22');
INSERT INTO `sys_log` VALUES ('549', '传感器管理', '删除', '删除了传感器信息31', '1', '2017-11-24 14:14:29');
INSERT INTO `sys_log` VALUES ('550', '传感器管理', '新增', '添加了新传感器1', '1', '2017-11-24 14:14:48');
INSERT INTO `sys_log` VALUES ('551', '传感器管理', '删除', '删除了传感器信息a1b16', '1', '2017-11-24 14:14:59');
INSERT INTO `sys_log` VALUES ('552', '传感器管理', '删除', '删除了传感器信息11', '1', '2017-11-24 14:14:59');
INSERT INTO `sys_log` VALUES ('553', '传感器管理', '删除', '删除了传感器信息1', '1', '2017-11-24 14:15:39');
INSERT INTO `sys_log` VALUES ('554', '传感器管理', '删除', '删除了传感器信息21', '1', '2017-11-24 14:17:39');
INSERT INTO `sys_log` VALUES ('555', '传感器管理', '新增', '添加了新传感器1', '1', '2017-11-24 14:18:38');
INSERT INTO `sys_log` VALUES ('556', '传感器管理', '删除', '删除了传感器信息1', '1', '2017-11-24 14:18:48');
INSERT INTO `sys_log` VALUES ('557', '传感器管理', '新增', '添加了新传感器a1b16', '1', '2017-11-24 14:32:28');
INSERT INTO `sys_log` VALUES ('558', '轮胎管理', '删除', '删除了轮胎信息a1b16000', '1', '2017-11-24 14:34:13');
INSERT INTO `sys_log` VALUES ('559', '轮胎管理', '修改', '修改了轮胎信息a1b15000', '1', '2017-11-24 14:38:55');
INSERT INTO `sys_log` VALUES ('560', '车辆管理', '新增', '添加了新车辆1', '1', '2017-11-24 14:58:39');
INSERT INTO `sys_log` VALUES ('561', '车辆管理', '修改', '修改了车辆信息1', '1', '2017-11-24 14:58:50');
INSERT INTO `sys_log` VALUES ('562', '车辆管理', '修改', '修改了车辆信息1', '1', '2017-11-24 14:59:43');
INSERT INTO `sys_log` VALUES ('563', '车辆管理', '删除', '删除了车辆信息1', '1', '2017-11-24 15:03:27');
INSERT INTO `sys_log` VALUES ('564', '轮胎替换管理', '安装', '苏A8888在2号位安装了轮胎', '1', '2017-11-24 15:23:35');

-- ----------------------------
-- Table structure for terminal
-- ----------------------------
DROP TABLE IF EXISTS `terminal`;
CREATE TABLE `terminal` (
  `terminal_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `terminal_ip` varchar(64) DEFAULT NULL COMMENT '终端IP',
  `store_id` int(11) DEFAULT NULL COMMENT '终端归属车队',
  `status` char(8) DEFAULT NULL COMMENT '状态',
  `last_admin_id` int(11) DEFAULT NULL COMMENT '最后一次登录该设备的用户ID',
  `last_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后一次登录时间',
  `remark` varchar(300) DEFAULT NULL COMMENT '终端备注',
  PRIMARY KEY (`terminal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of terminal
-- ----------------------------

-- ----------------------------
-- Table structure for tire_addmore
-- ----------------------------
DROP TABLE IF EXISTS `tire_addmore`;
CREATE TABLE `tire_addmore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) DEFAULT NULL COMMENT '轮胎品牌',
  `tire_param_id` int(11) DEFAULT NULL COMMENT '轮胎参数ID',
  `tire_switch` char(4) DEFAULT NULL COMMENT '开关',
  `add_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '时间',
  `store_id` int(11) DEFAULT '0' COMMENT '仓库(车队)编号',
  `admin_name` varchar(20) DEFAULT NULL COMMENT '手续终端用户名',
  `figure_mile` float(11,2) unsigned DEFAULT NULL COMMENT '花纹深度',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_name` (`admin_name`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tire_addmore
-- ----------------------------
INSERT INTO `tire_addmore` VALUES ('20', '5', '4', 'on', '2017-11-23 14:22:46', '6', 'admin', '6.70');
INSERT INTO `tire_addmore` VALUES ('21', '5', '4', 'on', '2017-11-23 14:58:13', '6', '轮胎注册', '6.70');

-- ----------------------------
-- Table structure for tire_exchg_log
-- ----------------------------
DROP TABLE IF EXISTS `tire_exchg_log`;
CREATE TABLE `tire_exchg_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tire_id` int(11) DEFAULT NULL COMMENT '轮胎ID',
  `bus_id` int(11) DEFAULT NULL COMMENT '车辆ID',
  `v_term_id` int(11) DEFAULT NULL COMMENT '车载终端ID',
  `place` int(11) DEFAULT NULL COMMENT '胎位',
  `install_stamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '安装时间',
  `uninstall_stamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '卸载时间',
  `mile_count` int(11) DEFAULT NULL COMMENT '累计里程',
  `stamp_count` int(11) DEFAULT NULL COMMENT '累计装车时间',
  `action` varchar(20) DEFAULT NULL COMMENT '动作：装上、卸下、入库、报废等',
  `log_stamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '记录时间',
  `figure_mile` float(11,1) unsigned DEFAULT NULL COMMENT '装车花纹深度',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tire_exchg_log
-- ----------------------------
INSERT INTO `tire_exchg_log` VALUES ('1', '1', '1', '1', '0', '2017-10-29 16:01:11', '0000-00-00 00:00:00', '0', '0', '装上', '2017-11-15 14:48:06', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('2', '2', '1', '1', '0', '2017-10-29 16:27:46', '0000-00-00 00:00:00', '0', '0', '装上', '2017-11-15 14:48:04', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('3', '1', '1', '1', '1', '2017-10-29 16:49:43', '2017-10-29 16:49:43', '0', '0', '装上', '2017-11-15 14:48:02', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('4', '1', '1', '1', '5', '2017-10-29 16:50:10', '2017-10-29 16:59:30', '0', '560', '卸下', '2017-11-15 14:48:00', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('5', '2', '1', '1', '1', '2017-10-29 16:59:32', '2017-10-29 16:59:32', '0', '0', '装上', '2017-11-15 14:47:58', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('6', '3', '1', '1', '1', '2017-10-29 16:59:46', '0000-00-00 00:00:00', '0', '0', '装上', '2017-11-15 14:47:56', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('7', '4', '1', '1', '2', '2017-10-29 16:59:53', '2017-11-17 17:09:33', '0', '1642180', '卸下', '2017-11-17 17:09:33', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('8', '5', '1', '1', '3', '2017-10-29 16:59:59', '2017-11-17 18:26:53', '0', '1646814', '卸下', '2017-11-17 18:26:53', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('9', '6', '1', '1', '4', '2017-10-29 17:00:05', '2017-11-17 18:49:16', '0', '1648151', '卸下', '2017-11-17 18:49:16', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('10', '7', '1', '1', '5', '2017-10-29 17:00:10', '2017-11-17 18:49:23', '0', '1648153', '卸下', '2017-11-17 18:49:23', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('11', '8', '1', '1', '6', '2017-10-29 17:00:15', '0000-00-00 00:00:00', '0', '0', '装上', '2017-11-15 14:47:32', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('12', '9', '2', '2', '1', '2017-10-30 13:18:48', '2017-11-17 17:07:24', '0', '1568916', '卸下', '2017-11-17 17:07:24', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('13', '10', '2', '2', '2', '2017-10-30 13:18:56', '2017-11-17 17:13:19', '0', '1569263', '卸下', '2017-11-17 17:13:19', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('14', '11', '2', '2', '3', '2017-10-30 13:19:01', '0000-00-00 00:00:00', '0', '0', '装上', '2017-11-15 14:47:39', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('15', '12', '2', '2', '4', '2017-10-30 13:19:07', '0000-00-00 00:00:00', '0', '0', '装上', '2017-11-15 14:47:41', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('16', '13', '2', '2', '5', '2017-10-30 13:19:14', '0000-00-00 00:00:00', '0', '0', '装上', '2017-11-15 14:47:43', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('17', '14', '2', '2', '6', '2017-10-30 13:19:21', '0000-00-00 00:00:00', '0', '0', '装上', '2017-11-15 14:47:46', '6.5');
INSERT INTO `tire_exchg_log` VALUES ('18', '9', '2', '2', '1', '2017-11-17 17:08:12', '2017-11-17 17:09:32', '78910', '80', '卸下', '2017-11-17 17:09:32', null);
INSERT INTO `tire_exchg_log` VALUES ('19', '17', '2', '2', '1', '2017-11-17 17:11:17', '0000-00-00 00:00:00', '78910', '0', '装上', '2017-11-17 17:11:17', null);
INSERT INTO `tire_exchg_log` VALUES ('20', '4', '1', '1', '1', '2017-11-17 17:11:58', '2017-11-17 17:13:18', '5462', '80', '卸下', '2017-11-17 17:13:18', null);
INSERT INTO `tire_exchg_log` VALUES ('21', '10', '1', '1', '1', '2017-11-17 17:13:43', '2017-11-17 18:43:57', '5462', '5414', '卸下', '2017-11-17 18:43:57', null);
INSERT INTO `tire_exchg_log` VALUES ('22', '4', '3', '3', '1', '2017-11-17 17:14:35', '0000-00-00 00:00:00', '0', '0', '装上', '2017-11-17 17:14:35', null);
INSERT INTO `tire_exchg_log` VALUES ('23', '5', '1', '1', '2', '2017-11-17 18:27:32', '2017-11-17 18:43:12', '5462', '940', '卸下', '2017-11-17 18:43:12', null);
INSERT INTO `tire_exchg_log` VALUES ('24', '5', '1', '1', '2', '2017-11-17 18:43:17', '2017-11-17 18:43:56', '5462', '39', '卸下', '2017-11-17 18:43:56', null);
INSERT INTO `tire_exchg_log` VALUES ('25', '10', '1', '1', '2', '2017-11-17 18:44:35', '2017-11-17 18:49:16', '5462', '281', '卸下', '2017-11-17 18:49:16', null);
INSERT INTO `tire_exchg_log` VALUES ('26', '6', '1', '1', '1', '2017-11-17 18:49:46', '0000-00-00 00:00:00', '5462', '0', '装上', '2017-11-17 18:49:46', null);
INSERT INTO `tire_exchg_log` VALUES ('27', '5', '1', '1', '2', '2017-11-24 15:23:35', '0000-00-00 00:00:00', '5462', '0', '装上', '2017-11-24 15:23:35', null);

-- ----------------------------
-- Table structure for tire_info
-- ----------------------------
DROP TABLE IF EXISTS `tire_info`;
CREATE TABLE `tire_info` (
  `tire_id` int(11) NOT NULL AUTO_INCREMENT,
  `sensor_id` int(11) DEFAULT NULL COMMENT '传感器编号',
  `tire_rfid` varchar(20) NOT NULL COMMENT '轮胎身份ID 就是传感器编号',
  `factory_code` varchar(20) DEFAULT NULL COMMENT '轮胎出厂编码',
  `history_state` varchar(20) DEFAULT NULL COMMENT '轮胎原始状态',
  `brand_id` int(11) DEFAULT NULL COMMENT '轮胎品牌',
  `tire_param_id` int(11) DEFAULT NULL COMMENT '轮胎参数ID',
  `figure_value` float(11,1) DEFAULT NULL COMMENT '花纹深度',
  `rated_mile` int(11) DEFAULT '180000' COMMENT '额定里程',
  `rated_hour` int(11) DEFAULT NULL COMMENT '标称使用小时数',
  `order_num` varchar(24) DEFAULT NULL COMMENT '订单号',
  `price` float(8,2) DEFAULT NULL COMMENT '价格',
  `p_staff` varchar(24) DEFAULT NULL COMMENT '采购人员',
  `status` char(8) NOT NULL COMMENT '状态',
  `last_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最近操作时间',
  `add_stamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '入库时间',
  `store_id` int(11) unsigned zerofill NOT NULL DEFAULT '00000000000' COMMENT '仓库编号',
  `to_store_id` int(11) unsigned zerofill NOT NULL DEFAULT '00000000000' COMMENT '待配送仓库编号',
  `plate_no` varchar(20) DEFAULT NULL COMMENT '车牌号码',
  `place` int(11) unsigned zerofill DEFAULT '00000000000' COMMENT '装车位置(当前胎位)',
  `place_stamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '装车时间(当前胎位装车时间)',
  `fst_place_stamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '装车时间(首次胎位装车时间)',
  `reject_stamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '报废时间',
  `bus_mile_count` int(11) DEFAULT '0' COMMENT '装车时，车辆累计里程',
  `tire_mile_count` int(11) DEFAULT '0' COMMENT '装车时，轮胎累计里程',
  `mile_count` int(11) DEFAULT '0' COMMENT '累计里程',
  `stamp_count` int(11) DEFAULT NULL COMMENT '累计装车时间',
  `reason` varchar(256) DEFAULT NULL COMMENT '报废理由',
  `exchg_id` int(11) unsigned zerofill NOT NULL DEFAULT '00000000000' COMMENT '最后一次安装时产生的安装记录号',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`tire_id`),
  UNIQUE KEY `tire_id` (`tire_id`),
  UNIQUE KEY `factory_code` (`factory_code`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tire_info
-- ----------------------------
INSERT INTO `tire_info` VALUES ('4', '5', 'a1b12', 'a1b12000', null, '5', '4', '0.0', '0', '0', '', '0.00', '', '装上', '2017-10-29 16:58:46', '2017-11-16 15:29:25', '00000000000', '00000000000', '1-5612', '00000000001', '2017-11-17 17:14:35', '2017-10-29 16:59:53', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000022', '');
INSERT INTO `tire_info` VALUES ('5', '6', 'a1b13', 'a1b13000', null, '5', '4', '0.0', '0', '0', '', '0.00', '', '装上', '2017-10-29 16:58:53', '2017-11-16 15:29:27', '00000000000', '00000000000', '苏A8888', '00000000002', '2017-11-24 15:23:35', '2017-10-29 16:59:59', '0000-00-00 00:00:00', '5462', '0', '0', null, null, '00000000027', '');
INSERT INTO `tire_info` VALUES ('6', '7', 'a1b14', 'a1b14000', null, '5', '4', '6.3', '0', '0', '', '0.00', '', '装上', '2017-10-29 16:59:00', '2017-11-16 15:29:30', '00000000000', '00000000000', '苏A8888', '00000000001', '2017-11-17 18:49:46', '2017-10-29 17:00:05', '0000-00-00 00:00:00', '5462', '0', '0', null, null, '00000000026', '');
INSERT INTO `tire_info` VALUES ('7', '8', 'a1b15', 'a1b15000', null, '5', '4', '5.5', '0', '0', '', '0.00', '', '卸下', '2017-10-29 16:59:06', '2017-11-16 15:29:33', '00000000000', '00000000000', '', '00000000000', '2017-11-17 18:49:23', '2017-10-29 17:00:10', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000010', '');
INSERT INTO `tire_info` VALUES ('9', '10', 'a4b01', 'a4b01000', null, '5', '4', '0.0', '0', '0', '', '0.00', '', '卸下', '2017-10-30 13:17:31', '2017-11-16 15:29:38', '00000000000', '00000000000', '', '00000000000', '2017-11-17 17:09:32', '2017-10-30 13:18:48', '0000-00-00 00:00:00', '78910', '0', '0', null, null, '00000000018', '');
INSERT INTO `tire_info` VALUES ('10', '11', 'a4b02', 'a4b02000', null, '5', '4', '0.0', '0', '0', '', '0.00', '', '卸下', '2017-10-30 13:17:38', '2017-11-16 15:29:40', '00000000000', '00000000000', '', '00000000000', '2017-11-17 18:49:16', '2017-10-30 13:18:56', '0000-00-00 00:00:00', '5462', '0', '0', null, null, '00000000025', '');
INSERT INTO `tire_info` VALUES ('11', '12', 'a4b03', 'a4b03000', null, '5', '4', '1.0', '0', '0', '', '0.00', '', '装上', '2017-10-30 13:17:44', '2017-11-16 15:29:43', '00000000000', '00000000000', '苏A6666', '00000000003', '2017-10-30 13:19:01', '2017-10-30 13:19:01', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000014', '');
INSERT INTO `tire_info` VALUES ('12', '13', 'a4b04', 'a4b04000', null, '5', '4', '0.0', '0', '0', '', '0.00', '', '装上', '2017-10-30 13:17:49', '2017-11-16 15:29:46', '00000000000', '00000000000', '苏A6666', '00000000004', '2017-10-30 13:19:07', '2017-10-30 13:19:07', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000015', '');
INSERT INTO `tire_info` VALUES ('13', '14', 'a4b05', 'a4b05000', null, '5', '4', '0.0', '0', '0', '', '0.00', '', '装上', '2017-10-30 13:17:55', '2017-11-16 15:29:49', '00000000000', '00000000000', '苏A6666', '00000000005', '2017-10-30 13:19:14', '2017-10-30 13:19:14', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000016', '');
INSERT INTO `tire_info` VALUES ('14', '15', 'a4b06', 'a4b06000', null, '5', '4', '0.0', '0', '0', '', '0.00', '', '装上', '2017-10-30 13:18:00', '2017-11-16 15:29:51', '00000000000', '00000000000', '苏A6666', '00000000006', '2017-10-30 13:19:21', '2017-10-30 13:19:21', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000017', '');
INSERT INTO `tire_info` VALUES ('15', '2', '52111', '52111000', null, '5', '3', '0.0', '0', '0', '', '0.00', '', '', '2017-11-16 15:33:03', '0000-00-00 00:00:00', '00000000000', '00000000000', null, '00000000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('16', '16', '34611', '34611000', null, '5', '4', '0.0', '0', '0', '', '0.00', '', '', '2017-11-16 15:38:00', '2017-11-17 15:38:00', '00000000000', '00000000000', null, '00000000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('17', '17', 'a1b21', 'a1b21000', null, '5', '4', '0.0', '0', '0', '', '0.00', '', '装上', '2017-11-16 16:20:11', '2017-11-16 16:20:11', '00000000000', '00000000000', '苏A6666', '00000000001', '2017-11-17 17:11:17', '2017-11-17 17:11:17', '0000-00-00 00:00:00', '78910', '0', '0', null, null, '00000000019', '');
INSERT INTO `tire_info` VALUES ('18', '18', 'a1b22', 'a1b22000', null, '5', '4', '0.0', '0', '0', '', '0.00', '', '', '2017-11-16 16:20:57', '2017-11-16 16:20:57', '00000000000', '00000000000', null, '00000000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('19', '19', 'a1b23', 'a1b23000', null, '5', '4', '5.0', '0', '0', '', '0.00', '', '', '2017-11-16 16:22:11', '2017-11-16 16:22:11', '00000000000', '00000000000', null, '00000000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('20', '20', 'a1b24', 'a1b24000', null, '5', '4', '5.0', '0', '0', '', '0.00', '', '', '2017-11-16 16:23:05', '2017-11-16 16:23:05', '00000000000', '00000000000', null, '00000000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('21', '23', '3d5d1', '3d5d1000', null, '5', '4', '0.0', '0', '0', '0', '0.00', '0', '装上', '2017-11-17 06:21:50', '0000-00-00 00:00:00', '00000000000', '00000000000', '5624', '00000000001', '2017-11-17 06:21:50', '2017-11-17 06:21:50', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('22', '24', '3d5d2', '3d5d2000', null, '5', '4', '0.0', '0', '0', '0', '0.00', '0', '装上', '2017-11-17 06:21:51', '0000-00-00 00:00:00', '00000000000', '00000000000', '5624', '00000000002', '2017-11-17 06:21:51', '2017-11-17 06:21:51', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('23', '25', '3d5d3', '3d5d3000', null, '5', '4', '0.0', '0', '0', '0', '0.00', '0', '装上', '2017-11-17 06:21:51', '0000-00-00 00:00:00', '00000000000', '00000000000', '5624', '00000000003', '2017-11-17 06:21:51', '2017-11-17 06:21:51', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('24', '26', '3d5d4', '3d5d4000', null, '5', '4', '0.0', '0', '0', '0', '0.00', '0', '装上', '2017-11-17 06:21:51', '0000-00-00 00:00:00', '00000000000', '00000000000', '5624', '00000000004', '2017-11-17 06:21:51', '2017-11-17 06:21:51', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('25', '27', '3d5d5', '3d5d5000', null, '5', '4', '0.0', '0', '0', '0', '0.00', '0', '装上', '2017-11-17 06:21:51', '0000-00-00 00:00:00', '00000000000', '00000000000', '5624', '00000000005', '2017-11-17 06:21:51', '2017-11-17 06:21:51', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('26', '28', '3d5d6', '3d5d6000', null, '5', '4', '0.0', '0', '0', '0', '0.00', '0', '装上', '2017-11-17 06:21:51', '0000-00-00 00:00:00', '00000000000', '00000000000', '5624', '00000000006', '2017-11-17 06:21:51', '2017-11-17 06:21:51', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('28', '33', '31', '31000', null, '5', '4', '0.0', '0', '0', '0', '0.00', '0', '', '2017-11-23 15:01:37', '0000-00-00 00:00:00', '00000000000', '00000000000', null, '00000000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('27', '1', 'd5611', '0000aa43', null, '5', '4', '5.0', '0', '0', '', '0.00', '', '', '2017-11-17 17:17:45', '2017-11-17 17:17:45', '00000000000', '00000000000', null, '00000000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('29', '34', '41', '41000', null, '5', '4', '6.7', '0', '0', '0', '0.00', '0', '', '2017-11-23 15:04:36', '0000-00-00 00:00:00', '00000000000', '00000000000', null, '00000000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');

-- ----------------------------
-- Table structure for tire_param_info
-- ----------------------------
DROP TABLE IF EXISTS `tire_param_info`;
CREATE TABLE `tire_param_info` (
  `tire_param_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(40) DEFAULT NULL COMMENT '制造商',
  `brand_id` int(11) DEFAULT NULL COMMENT '品牌ID',
  `norms_id` int(11) DEFAULT NULL COMMENT '规格ID',
  `class_id` int(11) DEFAULT NULL COMMENT '层级ID',
  `figure_id` int(11) DEFAULT NULL COMMENT '花纹ID',
  `pressure_ul` float(6,2) DEFAULT NULL COMMENT '胎压上限',
  `pressure_ll` float(6,2) DEFAULT NULL COMMENT '胎压下限',
  `speed_ul` int(11) DEFAULT NULL,
  `temp_ul` int(11) DEFAULT NULL COMMENT '温度上限',
  `tkph_val` int(11) DEFAULT NULL COMMENT 'TKPH值',
  `baro_val` int(11) DEFAULT NULL COMMENT '标准充气压力',
  `mainterance1` int(11) DEFAULT '50000' COMMENT '一保',
  `mainterance2` int(11) DEFAULT '80000' COMMENT '二保',
  `rated_mile` int(11) DEFAULT '180000' COMMENT '额定里程',
  `figure_mile1` int(11) unsigned DEFAULT NULL COMMENT '初始花纹深度',
  `figure_mile2` int(11) unsigned DEFAULT NULL COMMENT '极限花纹深度',
  PRIMARY KEY (`tire_param_id`),
  UNIQUE KEY `brand_id` (`brand_id`,`norms_id`,`class_id`,`figure_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tire_param_info
-- ----------------------------
INSERT INTO `tire_param_info` VALUES ('4', '杭州', '5', '5', '5', '6', '20.00', '0.00', '200', '20', '10', '8', '2000', '4000', '0', '4', '2');
INSERT INTO `tire_param_info` VALUES ('2', '南京', '6', '5', '6', '6', '10.00', '0.00', '200', '120', '20', '0', '4000', '8000', '0', '6', '2');
INSERT INTO `tire_param_info` VALUES ('3', '米其林', '5', '6', '5', '5', '10.00', '4.00', '200', '90', '20', '4', '2000', '4000', '0', '7', '5');
INSERT INTO `tire_param_info` VALUES ('5', '固特异', '5', '6', '6', '5', '10.00', '0.00', '200', '150', '1', '10', '50000', '80000', '0', '10', '1');

-- ----------------------------
-- Table structure for vehicle_term
-- ----------------------------
DROP TABLE IF EXISTS `vehicle_term`;
CREATE TABLE `vehicle_term` (
  `v_term_id` int(11) NOT NULL AUTO_INCREMENT,
  `plate_no` varchar(20) DEFAULT NULL COMMENT '车牌号码',
  `v_term_no` varchar(20) DEFAULT NULL COMMENT '车载终端编号',
  `v_term_name` varchar(40) DEFAULT NULL COMMENT '车载终端名称',
  `renew_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '里程更新时间',
  `store_id` int(11) DEFAULT NULL COMMENT '所属仓库车队',
  `mile_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '累计里程',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`v_term_id`),
  UNIQUE KEY `v_term_no` (`v_term_no`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vehicle_term
-- ----------------------------
INSERT INTO `vehicle_term` VALUES ('1', '', '001', '001', '2017-11-09 15:21:41', '6', '0', '');
INSERT INTO `vehicle_term` VALUES ('2', '', 'a4b0', 'a4b0', '2017-11-10 13:50:29', '2', '0', '');
INSERT INTO `vehicle_term` VALUES ('3', '', '003', '003', '2017-11-09 15:21:38', '6', '0', '');
INSERT INTO `vehicle_term` VALUES ('4', '', '004', '004', '2017-11-09 15:21:33', '6', '0', '手持终端');
INSERT INTO `vehicle_term` VALUES ('5', '', '3461', '3461', '2017-11-16 15:37:38', '6', '0', '');
INSERT INTO `vehicle_term` VALUES ('6', '', 'a1b2', 'a1b2', '2017-11-16 16:18:34', '6', '0', '');
INSERT INTO `vehicle_term` VALUES ('7', '', '3d5d', '3d5d', '2017-11-24 13:25:36', '2', '0', '');

-- ----------------------------
-- Event structure for real_to_his
-- ----------------------------
DROP EVENT IF EXISTS `real_to_his`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` EVENT `real_to_his` ON SCHEDULE EVERY 10 MINUTE STARTS '2017-08-31 22:14:48' ON COMPLETION NOT PRESERVE ENABLE DO insert into bt_history_log (bus_id,speed,max_speed,tire_id1,pressure1,overflow_pressure1,temp1,overflow_temp1,tire_id2,pressure2,overflow_pressure2,temp2,overflow_temp2,tire_id3,pressure3,overflow_pressure3,temp3,overflow_temp3,tire_id4,pressure4,overflow_pressure4,temp4,overflow_temp4,tire_id5,pressure5,overflow_pressure5,temp5,overflow_temp5,tire_id6,pressure6,overflow_pressure6,temp6,overflow_temp6,tire_id7,pressure7,overflow_pressure7,temp7,overflow_temp7,tire_id8,pressure8,overflow_pressure8,temp8,overflow_temp8,tire_id9,pressure9,overflow_pressure9,temp9,overflow_temp9,tire_id10,pressure10,overflow_pressure10,temp10,overflow_temp10,log_stamp) select bus_id,speed,max_speed,tire_id1,pressure1,overflow_pressure1,temp1,overflow_temp1,tire_id2,pressure2,overflow_pressure2,temp2,overflow_temp2,tire_id3,pressure3,overflow_pressure3,temp3,overflow_temp3,tire_id4,pressure4,overflow_pressure4,temp4,overflow_temp4,tire_id5,pressure5,overflow_pressure5,temp5,overflow_temp5,tire_id6,pressure6,overflow_pressure6,temp6,overflow_temp6,tire_id7,pressure7,overflow_pressure7,temp7,overflow_temp7,tire_id8,pressure8,overflow_pressure8,temp8,overflow_temp8,tire_id9,pressure9,overflow_pressure9,temp9,overflow_temp9,tire_id10,pressure10,overflow_pressure10,temp10,overflow_temp10,log_stamp from bt_real_log
;;
DELIMITER ;
