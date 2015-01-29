/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : tagbum

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2015-01-29 14:09:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users_interests
-- ----------------------------
DROP TABLE IF EXISTS `users_interests`;
CREATE TABLE `users_interests` (
  `id` tinyint(11) unsigned NOT NULL,
  `label` varchar(10) NOT NULL,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_interests
-- ----------------------------
INSERT INTO `users_interests` VALUES ('0', 'all', 'all / todo');
INSERT INTO `users_interests` VALUES ('1', 'chat', 'chat / chatear');
INSERT INTO `users_interests` VALUES ('2', 'date', 'date / cita');
INSERT INTO `users_interests` VALUES ('3', 'frienship', 'friendship / amistad');
