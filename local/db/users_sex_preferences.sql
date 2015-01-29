/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : tagbum

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2015-01-29 14:09:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users_sex_preferences
-- ----------------------------
DROP TABLE IF EXISTS `users_sex_preferences`;
CREATE TABLE `users_sex_preferences` (
  `id` tinyint(4) unsigned NOT NULL,
  `label` varchar(15) DEFAULT NULL,
  `description` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_sex_preferences
-- ----------------------------
INSERT INTO `users_sex_preferences` VALUES ('0', 'all', 'all / todos');
INSERT INTO `users_sex_preferences` VALUES ('1', 'males', 'males / hombres');
INSERT INTO `users_sex_preferences` VALUES ('2', 'females', 'females / mujeres');
