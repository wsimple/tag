/*
Navicat MySQL Data Transfer

Source Server         : tagdb200
Source Server Version : 50166
Source Host           : 68.109.244.200:3306
Source Database       : tagbum200

Target Server Type    : MYSQL
Target Server Version : 50166
File Encoding         : 65001

Date: 2014-12-22 12:39:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for store_raffle_users
-- ----------------------------
DROP TABLE IF EXISTS `store_raffle_users`;
CREATE TABLE `store_raffle_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(250) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of store_raffle_users
-- ----------------------------
INSERT INTO `store_raffle_users` VALUES ('1', 'wpanel@tagbum.com');
INSERT INTO `store_raffle_users` VALUES ('2', 'wpanel@seemytag.com');
INSERT INTO `store_raffle_users` VALUES ('3', 'tagbum@tagbum.com');
