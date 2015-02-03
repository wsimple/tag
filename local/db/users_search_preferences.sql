/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : tagbum

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2015-02-03 11:17:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users_search_preferences
-- ----------------------------
DROP TABLE IF EXISTS `users_search_preferences`;
CREATE TABLE `users_search_preferences` (
  `id` int(10) unsigned NOT NULL,
  `sex_preference` tinyint(3) unsigned NOT NULL,
  `wish_to` tinyint(3) unsigned NOT NULL,
  `min_age` tinyint(3) unsigned NOT NULL,
  `max_age` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_search_preferences
-- ----------------------------
INSERT INTO `users_search_preferences` VALUES ('124', '2', '0', '18', '38');
