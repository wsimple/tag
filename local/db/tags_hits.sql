/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2013-11-01 15:13:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tags_hits`
-- ----------------------------
DROP TABLE IF EXISTS `tags_hits`;
CREATE TABLE `tags_hits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tag` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tags_hits
-- ----------------------------
