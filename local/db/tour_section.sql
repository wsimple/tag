/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2013-11-04 10:41:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tour_section`
-- ----------------------------
DROP TABLE IF EXISTS `tour_section`;
CREATE TABLE `tour_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sectionTour` varchar(30) NOT NULL,
  `active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tour_section
-- ----------------------------
INSERT INTO `tour_section` VALUES ('1', 'creation', '1');
INSERT INTO `tour_section` VALUES ('2', 'home', '1');
INSERT INTO `tour_section` VALUES ('3', 'timeline', '1');
