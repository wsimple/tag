/*
Navicat MySQL Data Transfer

Source Server         : tagdb200
Source Server Version : 50166
Source Host           : 68.109.244.200:3306
Source Database       : tagbum200

Target Server Type    : MYSQL
Target Server Version : 50166
File Encoding         : 65001

Date: 2015-02-03 10:23:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users_wish_to
-- ----------------------------
DROP TABLE IF EXISTS `users_wish_to`;
CREATE TABLE `users_wish_to` (
  `id` tinyint(11) unsigned NOT NULL,
  `label` varchar(10) NOT NULL,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_wish_to
-- ----------------------------
INSERT INTO `users_wish_to` VALUES ('0', 'all', 'all / todo');
INSERT INTO `users_wish_to` VALUES ('1', 'chat', 'chat / chatear');
INSERT INTO `users_wish_to` VALUES ('2', 'date', 'date / cita');
INSERT INTO `users_wish_to` VALUES ('4', 'friendship', 'friendship / amistad');
