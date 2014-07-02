/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2013-11-04 10:41:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tour_position`
-- ----------------------------
DROP TABLE IF EXISTS `tour_position`;
CREATE TABLE `tour_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tour_position
-- ----------------------------
INSERT INTO `tour_position` VALUES ('1', 'top-right');
INSERT INTO `tour_position` VALUES ('2', 'top-middle');
INSERT INTO `tour_position` VALUES ('3', 'top-left');
INSERT INTO `tour_position` VALUES ('4', 'middle-right');
INSERT INTO `tour_position` VALUES ('5', 'middle-middle');
INSERT INTO `tour_position` VALUES ('6', 'middle-left');
INSERT INTO `tour_position` VALUES ('7', 'bottom-right');
INSERT INTO `tour_position` VALUES ('8', 'bottom-middle');
INSERT INTO `tour_position` VALUES ('9', 'bottom-left');
