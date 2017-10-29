/*
Navicat MySQL Data Transfer

Source Server         : phpstudyMysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : ttms_yangzi

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-10-29 15:55:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admins`
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
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_name` (`admin_name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', '25d55ad283aa400af464c76d713c07ad', null, '系统管理员', 'admin@ttms.com', null, null, null, null, null, '1', '0', 'N', null, '', '0000-00-00 00:00:00', '0', null, '0000-00-00 00:00:00');
INSERT INTO `admins` VALUES ('2', '轮胎注册', '25d55ad283aa400af464c76d713c07ad', null, '轮胎注册', '', '', '', null, null, '', '1', '0', 'Y', null, '', '0000-00-00 00:00:00', '0', null, '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `brand`
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of brand
-- ----------------------------
INSERT INTO `brand` VALUES ('5', null, '米其林', '备注', '56PR/CR/DP', '8PR', '花纹');
INSERT INTO `brand` VALUES ('6', null, '鲁朗', '', '67I/U/R', '12pr', '普通花纹');
INSERT INTO `brand` VALUES ('7', null, '特绑', '备注', '67T/E/R', '77PR', '螺旋花纹');

-- ----------------------------
-- Table structure for `bt_history_log`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bt_history_log
-- ----------------------------

-- ----------------------------
-- Table structure for `bt_real_log`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bt_real_log
-- ----------------------------

-- ----------------------------
-- Table structure for `bus_alarm_log`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bus_alarm_log
-- ----------------------------

-- ----------------------------
-- Table structure for `bus_info`
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
  PRIMARY KEY (`bus_id`),
  UNIQUE KEY `plate_no` (`plate_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bus_info
-- ----------------------------

-- ----------------------------
-- Table structure for `class`
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
-- Table structure for `figure_type`
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
-- Table structure for `modules`
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
) ENGINE=MyISAM AUTO_INCREMENT=141011 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of modules
-- ----------------------------
INSERT INTO `modules` VALUES ('10', '10', '-1', 'images/icon/62.png', '1', '10', '系统管理', '系统管理', '', '0', null);
INSERT INTO `modules` VALUES ('11', '11', '-1', 'images/icon/85.png', '1', '11', '轮胎管理', '轮胎管理', '', '0', null);
INSERT INTO `modules` VALUES ('12', '12', '-1', 'images/icon/cl.png', '1', '12', '车辆管理', '车辆管理', '', '0', null);
INSERT INTO `modules` VALUES ('13', '13', '-1', 'images/icon/jc.png', '1', '13', '监测系统', '监测系统', '', '0', null);
INSERT INTO `modules` VALUES ('14', '14', '-1', 'images/icon/29.png', '1', '14', '系统日志', '系统日志', '', '0', null);
INSERT INTO `modules` VALUES ('1010', '1010', '10', 'images/icon/37.png', '2', '1010', '用户权限管理', '用户权限管理', '', '0', null);
INSERT INTO `modules` VALUES ('101010', '101010', '1010', 'images/icon/33.png', '3', '101010', '角色管理', '角色管理', 'module_sys/sys.roles_show.php', '0', null);
INSERT INTO `modules` VALUES ('101011', '101011', '1010', 'images/icon/37.png', '3', '101011', '用户管理', '用户管理', 'module_sys/sys.users_show.php', '0', null);
INSERT INTO `modules` VALUES ('1011', '1011', '10', 'images/icon/1.png', '2', '1011', '基本数据管理', '基本数据管理', '', '0', null);
INSERT INTO `modules` VALUES ('101110', '101110', '1011', 'images/icon/37.png', '3', '101110', '车队(仓库)管理', '车队(仓库)管理', 'module_sys/sys.store_show.php', '0', null);
INSERT INTO `modules` VALUES ('101111', '101111', '1011', 'images/icon/sc.png', '3', '101111', '手持终端管理', '手持终端管理', 'module_sys/sys.terminal_show.php', '0', null);
INSERT INTO `modules` VALUES ('101112', '101112', '1011', 'images/icon/27.png', '3', '101112', '轮胎品牌管理', '轮胎品牌管理', 'module_sys/sys.brand_show.php', '0', null);
INSERT INTO `modules` VALUES ('101113', '101113', '1011', 'images/icon/27.png', '3', '101113', '轮胎规格管理', '轮胎规格管理', 'module_sys/sys.norms_show.php', '0', null);
INSERT INTO `modules` VALUES ('101114', '101114', '1011', 'images/icon/27.png', '3', '101114', '轮胎层级管理', '轮胎层级管理', 'module_sys/sys.class_show.php', '0', null);
INSERT INTO `modules` VALUES ('101115', '101115', '1011', 'images/icon/27.png', '3', '101115', '轮胎花纹管理', '轮胎花纹管理', 'module_sys/sys.figure_show.php', '0', null);
INSERT INTO `modules` VALUES ('101116', '101116', '1011', 'images/icon/27.png', '3', '101116', '车载终端管理', '车载终端管理', 'module_sys/sys.vehicle_show.php', '0', null);
INSERT INTO `modules` VALUES ('1110', '1110', '11', 'images/icon/37.png', '2', '1110', '轮胎相关管理', '轮胎相关管理', '', '0', null);
INSERT INTO `modules` VALUES ('111010', '111010', '1110', 'images/icon/33.png', '3', '111010', '轮胎参数管理', '轮胎参数管理', 'module_11/sys.tireparam_show.php', '0', null);
INSERT INTO `modules` VALUES ('111011', '111011', '1110', 'images/icon/33.png', '3', '111011', '传感器管理', '传感器管理', 'module_11/sys.sensor_show.php', '0', null);
INSERT INTO `modules` VALUES ('1111', '1111', '11', 'images/icon/1.png', '2', '1111', '轮胎维护', '轮胎维护', '', '0', null);
INSERT INTO `modules` VALUES ('111110', '111110', '1111', 'images/icon/37.png', '3', '111110', '轮胎管理', '轮胎管理', 'module_11/sys.tireinfo_show.php', '0', null);
INSERT INTO `modules` VALUES ('1210', '1210', '12', 'images/icon/37.png', '2', '1210', '车辆管理', '车辆管理', '', '0', null);
INSERT INTO `modules` VALUES ('121010', '121010', '1210', 'images/icon/33.png', '3', '121010', '车辆维护', '车辆维护', 'module_12/sys.bus_manage.php', '0', null);
INSERT INTO `modules` VALUES ('1310', '1310', '13', 'images/icon/37.png', '2', '1310', '实时状态', '实时状态', '', '0', null);
INSERT INTO `modules` VALUES ('131010', '131010', '1310', 'images/icon/33.png', '3', '131010', '车辆轮胎状态', '车辆轮胎状态', 'module_13/sys.real_show.php', '0', null);
INSERT INTO `modules` VALUES ('1311', '1311', '13', 'images/icon/1.png', '2', '1311', '历史状态', '历史状态', '', '0', null);
INSERT INTO `modules` VALUES ('131110', '131110', '1311', 'images/icon/37.png', '3', '131110', '车辆轮胎历史状态', '车辆轮胎历史状态', 'module_13/sys.his_show.php', '0', null);
INSERT INTO `modules` VALUES ('131210', '131210', '1311', 'images/icon/37.png', '3', '131210', '告警历史状态', '告警历史状态', 'module_13/sys.alarm_his131210_show.php', '0', null);
INSERT INTO `modules` VALUES ('1313', '1313', '13', 'images/icon/37.png', '2', '1313', '轮胎使用查询', '轮胎使用查询', '', '0', null);
INSERT INTO `modules` VALUES ('131112', '131112', '1311', 'images/icon/37.png', '3', '131112', '胎压告警历史', '胎压告警历史', 'module_13/sys.alarm_his131112_show.php', '0', null);
INSERT INTO `modules` VALUES ('131311', '131311', '1313', 'images/icon/33.png', '3', '131311', '轮胎运行总时长总里程查询', '轮胎运行总时长总里程查询', 'module_13/sys.tire_runhis_show.php', '0', null);
INSERT INTO `modules` VALUES ('1315', '1315', '13', 'images/icon/37.png', '2', '1315', '库存状态查询', '库存状态查询', '', '0', null);
INSERT INTO `modules` VALUES ('131510', '131510', '1315', 'images/icon/33.png', '3', '131510', '轮胎库存查询', '轮胎库存查询', 'module_13/sys.tirestore_charts_show.php', '0', null);
INSERT INTO `modules` VALUES ('1316', '1316', '13', 'images/icon/37.png', '2', '1316', '统计分析', '统计分析', '', '0', null);
INSERT INTO `modules` VALUES ('131610', '131610', '1316', 'images/icon/33.png', '3', '131610', '轮胎历史曲线', '轮胎历史曲线', 'module_13/sys.tirehis_charts_10.php', '0', null);
INSERT INTO `modules` VALUES ('131612', '131612', '1316', 'images/icon/33.png', '3', '131612', '轮胎历史告警', '轮胎历史告警', 'module_13/sys.tirehis_charts_12.php', '0', null);
INSERT INTO `modules` VALUES ('1410', '1410', '14', 'images/icon/37.png', '2', '1410', '历史记录', '历史记录', '', '0', null);
INSERT INTO `modules` VALUES ('141010', '141010', '1410', 'images/icon/33.png', '3', '141010', '历史记录查询', '历史记录查询', 'module_14/sys.sys_his141010_show.php', '0', null);
INSERT INTO `modules` VALUES ('111111', '111111', '1111', 'images/icon/37.png', '3', '111111', '轮胎配送', '轮胎配送', 'module_11/sys.tire_manage.php', '0', null);
INSERT INTO `modules` VALUES ('131614', '131614', '1316', 'images/icon/33.png', '3', '131614', '车辆车速分析', '车辆车速分析', 'module_13/sys.carspeed_charts_show.php', '0', null);

-- ----------------------------
-- Table structure for `norms`
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
-- Table structure for `roles`
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '超级管理员', '超级管理员', '10;1010;101010;101011;1011;101110;101111;101112;101113;101114;101115;101116;11;1110;111010;111011;1111;111110;111111;12;1210;121010;13;1310;131010;1311;131110;131210;131112;1313;131311;1315;131510;1316;131610;131612;131614;14;1410;141010', '系统管理;用户权限管理;角色管理;用户管理;基本数据管理;车队(仓库)管理;手持终端管理;轮胎品牌管理;轮胎规格管理;轮胎层级管理;轮胎花纹管理;车载终端管理;轮胎管理;轮胎相关管理;轮胎参数管理;传感器管理;轮胎维护;轮胎管理;轮胎配送;车辆管理;车辆管理;车辆维护;监测系统;实时状态;车辆轮胎状态;历史状态;车辆轮胎历史状态;告警历史状态;胎压告警历史;轮胎使用查询;轮胎运行总时长总里程查询;库存状态查询;轮胎库存查询;统计分析;轮胎历史曲线;轮胎历史告警;车辆车速分析;系统日志;历史记录;历史记录查询', '添加;修改;删除', '');
INSERT INTO `roles` VALUES ('2', '手持终端人员', '手持终端人员', '10;1010;101010;101011;1011;101110;101111;101112;101113;101114;101115;101116;11;1110;111010;111011;1111;111110;111111;12;1210;121010', '系统管理;用户权限管理;角色管理;用户管理;基本数据管理;车队(仓库)管理;手持终端管理;轮胎品牌管理;轮胎规格管理;轮胎层级管理;轮胎花纹管理;车载终端管理;轮胎管理;轮胎相关管理;轮胎参数管理;传感器管理;轮胎维护;轮胎管理;轮胎配送;车辆管理;车辆管理;车辆维护', '添加;修改;删除', '');
INSERT INTO `roles` VALUES ('3', '胎管员', '胎管员', '1011;101110;101111;101112;101113;101114;101115;101116;11;1110;111010;111011;1111;111110;111111;12;1210;121010;13;1310;131010;1311;131110;131210;1313;131310;131311;1315;131510;1316;131610;131612;131614', '基本数据管理;车队(仓库)管理;手持终端管理;轮胎品牌管理;轮胎规格管理;轮胎层级管理;轮胎花纹管理;车载终端管理;轮胎管理;轮胎相关管理;轮胎参数管理;传感器管理;轮胎维护;轮胎管理;轮胎配送;车辆管理;车辆管理;车辆维护;监测系统;实时状态;车辆轮胎状态;历史状态;车辆轮胎历史状态;告警历史状态;轮胎使用查询;轮胎使用总时间查询;轮胎运行总时长总里程查询;库存状态查询;轮胎库存查询;统计分析;轮胎历史曲线;轮胎历史告警;车辆车速分析', '', '测试');
INSERT INTO `roles` VALUES ('4', '司机', '司机', '1310;131010;1313;131310;131311', '实时状态;车辆轮胎状态;轮胎使用查询;轮胎使用总时间查询;轮胎运行总时长总里程查询', '查看', '车队一司机');

-- ----------------------------
-- Table structure for `sensor`
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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

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
INSERT INTO `sensor` VALUES ('9', 'a1b16', '10.00', '0.00', '125', '-40', '批量添加传感器');
INSERT INTO `sensor` VALUES ('10', 'a4b01', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('11', 'a4b02', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('12', 'a4b03', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('13', 'a4b04', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('14', 'a4b05', '10.00', '0.00', '125', '-40', '备注');
INSERT INTO `sensor` VALUES ('15', 'a4b06', '10.00', '0.00', '125', '-40', '备注');

-- ----------------------------
-- Table structure for `store`
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store
-- ----------------------------
INSERT INTO `store` VALUES ('0', null, 'C001', '大厂修理厂', '李四', '13567891762', '13567891762', null, null, null, null, null, '大厂', '测试');
INSERT INTO `store` VALUES ('2', null, 'C002', '禄口修理厂', '张三', '13456712673', '13564521731', null, null, null, null, null, '禄口', '测试');
INSERT INTO `store` VALUES ('3', null, 'C003', '雨花修理厂', '王五', '13569081313', '131317367167', null, null, null, null, null, '雨花', '测试');
INSERT INTO `store` VALUES ('4', null, 'C004', '马鞍山修理厂', '稔田', '15436738178', '1231637167', null, null, null, null, null, '马鞍山', '测试');
INSERT INTO `store` VALUES ('5', null, 'C005', '淳化修理厂', '范圣贤', '1345678776', '1313978789', null, null, null, null, null, '淳化', '主要修理厂');

-- ----------------------------
-- Table structure for `sys_log`
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
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

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

-- ----------------------------
-- Table structure for `terminal`
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
-- Table structure for `tire_addmore`
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_name` (`admin_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tire_addmore
-- ----------------------------

-- ----------------------------
-- Table structure for `tire_exchg_log`
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tire_exchg_log
-- ----------------------------

-- ----------------------------
-- Table structure for `tire_info`
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
  `figure_value` int(11) DEFAULT NULL COMMENT '花纹深度',
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tire_info
-- ----------------------------
INSERT INTO `tire_info` VALUES ('1', '1', 'd5611', 'd5611000', null, '5', '4', '0', '0', '0', '', '0.00', '', '', '2017-10-26 13:04:59', '0000-00-00 00:00:00', '00000000000', '00000000000', null, '00000000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');
INSERT INTO `tire_info` VALUES ('2', '3', 'd4511', 'd4511000', null, '6', '2', '0', '0', '0', '', '0.00', '', '', '2017-10-26 13:17:07', '0000-00-00 00:00:00', '00000000000', '00000000000', null, '00000000000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0', '0', null, null, '00000000000', '');

-- ----------------------------
-- Table structure for `tire_param_info`
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
  PRIMARY KEY (`tire_param_id`),
  UNIQUE KEY `brand_id` (`brand_id`,`norms_id`,`class_id`,`figure_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tire_param_info
-- ----------------------------
INSERT INTO `tire_param_info` VALUES ('4', '杭州', '5', '5', '5', '6', '20.00', '0.00', '200', '20', '10', '8', '2000', '4000', '10000');
INSERT INTO `tire_param_info` VALUES ('2', '南京', '6', '5', '6', '6', '10.00', '0.00', '200', '120', '20', '0', '4000', '8000', '10000');
INSERT INTO `tire_param_info` VALUES ('3', '米其林', '5', '6', '5', '5', '10.00', '4.00', '200', '90', '20', '4', '2000', '4000', '10000');

-- ----------------------------
-- Table structure for `vehicle_term`
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vehicle_term
-- ----------------------------
INSERT INTO `vehicle_term` VALUES ('1', '', '001', '001', '2017-10-24 10:43:19', '3', '0', '313131313');
INSERT INTO `vehicle_term` VALUES ('2', '', '002', '002', '2017-10-24 10:41:09', '2', '0', '');
INSERT INTO `vehicle_term` VALUES ('3', '', '003', '003', '2017-10-24 10:42:39', '3', '0', '31231');
INSERT INTO `vehicle_term` VALUES ('4', '', '004', '004', '2017-10-24 10:41:12', '0', '0', '');

-- ----------------------------
-- Event structure for `real_to_his`
-- ----------------------------
DROP EVENT IF EXISTS `real_to_his`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` EVENT `real_to_his` ON SCHEDULE EVERY 10 MINUTE STARTS '2017-08-31 22:14:48' ON COMPLETION NOT PRESERVE ENABLE DO insert into bt_history_log (bus_id,speed,max_speed,tire_id1,pressure1,overflow_pressure1,temp1,overflow_temp1,tire_id2,pressure2,overflow_pressure2,temp2,overflow_temp2,tire_id3,pressure3,overflow_pressure3,temp3,overflow_temp3,tire_id4,pressure4,overflow_pressure4,temp4,overflow_temp4,tire_id5,pressure5,overflow_pressure5,temp5,overflow_temp5,tire_id6,pressure6,overflow_pressure6,temp6,overflow_temp6,tire_id7,pressure7,overflow_pressure7,temp7,overflow_temp7,tire_id8,pressure8,overflow_pressure8,temp8,overflow_temp8,tire_id9,pressure9,overflow_pressure9,temp9,overflow_temp9,tire_id10,pressure10,overflow_pressure10,temp10,overflow_temp10,log_stamp) select bus_id,speed,max_speed,tire_id1,pressure1,overflow_pressure1,temp1,overflow_temp1,tire_id2,pressure2,overflow_pressure2,temp2,overflow_temp2,tire_id3,pressure3,overflow_pressure3,temp3,overflow_temp3,tire_id4,pressure4,overflow_pressure4,temp4,overflow_temp4,tire_id5,pressure5,overflow_pressure5,temp5,overflow_temp5,tire_id6,pressure6,overflow_pressure6,temp6,overflow_temp6,tire_id7,pressure7,overflow_pressure7,temp7,overflow_temp7,tire_id8,pressure8,overflow_pressure8,temp8,overflow_temp8,tire_id9,pressure9,overflow_pressure9,temp9,overflow_temp9,tire_id10,pressure10,overflow_pressure10,temp10,overflow_temp10,log_stamp from bt_real_log
;
;;
DELIMITER ;
