/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2013-11-07 10:25:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `log_actions`
-- ----------------------------
DROP TABLE IF EXISTS `log_actions`;
CREATE TABLE `log_actions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `id_source` int(10) unsigned NOT NULL DEFAULT '0',
  `id_user` int(10) unsigned NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of log_actions
-- ----------------------------
