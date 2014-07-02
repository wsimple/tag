/*
Navicat MySQL Data Transfer

Source Server         : seemytag
Source Server Version : 50532
Source Host           : seemytag.com:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2013-11-27 08:53:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `action_points`
-- ----------------------------
DROP TABLE IF EXISTS `action_points`;
CREATE TABLE `action_points` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `points_owner` int(11) NOT NULL DEFAULT '0',
  `points_user` int(11) NOT NULL DEFAULT '0',
  `status` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of action_points
-- ----------------------------
INSERT INTO `action_points` VALUES ('1', '2', '100', '100', '1');
INSERT INTO `action_points` VALUES ('2', '20', '100', '100', '1');
INSERT INTO `action_points` VALUES ('3', '4', '100', '100', '1');
INSERT INTO `action_points` VALUES ('4', '8', '100', '100', '1');
INSERT INTO `action_points` VALUES ('5', '7', '100', '100', '1');
INSERT INTO `action_points` VALUES ('6', '21', '100', '100', '1');
INSERT INTO `action_points` VALUES ('7', '22', '100', '100', '1');
INSERT INTO `action_points` VALUES ('8', '23', '100', '100', '1');
INSERT INTO `action_points` VALUES ('9', '24', '100', '100', '1');
INSERT INTO `action_points` VALUES ('10', '9', '100', '100', '1');
INSERT INTO `action_points` VALUES ('11', '25', '100', '100', '1');
INSERT INTO `action_points` VALUES ('12', '26', '100', '100', '1');
