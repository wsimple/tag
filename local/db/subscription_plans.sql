/*
Navicat MySQL Data Transfer

Source Server         : seemytag
Source Server Version : 50536
Source Host           : seemytag.com:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2014-03-24 10:03:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `subscription_plans`
-- ----------------------------
DROP TABLE IF EXISTS `subscription_plans`;
CREATE TABLE `subscription_plans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `price` double(5,0) NOT NULL,
  `days` int(3) NOT NULL,
  `description` tinytext CHARACTER SET utf8,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of subscription_plans
-- ----------------------------
INSERT INTO `subscription_plans` VALUES ('1', 'Cruising', '9', '365', 'Promo Pack 1', '1');
INSERT INTO `subscription_plans` VALUES ('2', 'School Zone', '2', '365', 'Self-Starter', '1');
INSERT INTO `subscription_plans` VALUES ('0', 'Nonprofit ', '0', '365', 'Nonprofit Company', '1');
INSERT INTO `subscription_plans` VALUES ('3', 'Top Fuel', '5', '365', 'Do more than just advertise your business, Fill it up!  Top Fuel is a Premium Grade Marketing Package.  You work hard to make your business look good, now make it run good.  Top Fuel delivers the performance to give your company the winning edge!', '1');
