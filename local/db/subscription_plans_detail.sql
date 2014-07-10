/*
Navicat MySQL Data Transfer

Source Server         : seemytag
Source Server Version : 50536
Source Host           : seemytag.com:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2014-03-24 10:03:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `subscription_plans_detail`
-- ----------------------------
DROP TABLE IF EXISTS `subscription_plans_detail`;
CREATE TABLE `subscription_plans_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_plan` int(11) NOT NULL,
  `ads` smallint(1) DEFAULT '0',
  `banners` smallint(1) DEFAULT '0',
  `num_ads` smallint(1) DEFAULT '0',
  `num_banners` smallint(1) DEFAULT '0',
  `features` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of subscription_plans_detail
-- ----------------------------
INSERT INTO `subscription_plans_detail` VALUES ('1', '2', '2', '0', '0', '0', 'Training webinar');
INSERT INTO `subscription_plans_detail` VALUES ('2', '1', '2', '1', '0', '0', '2-8 Hours Events, 2 Online Managemet Hours');
INSERT INTO `subscription_plans_detail` VALUES ('3', '0', '1', '1', '0', '0', 'TBD');
INSERT INTO `subscription_plans_detail` VALUES ('4', '3', '2', '1', '0', '0', 'One 6 hour Event per Quarter, 4 hours of professional online management each month including placing 2 ads, 1 Banner, 1 Press release.');
INSERT INTO `subscription_plans_detail` VALUES ('5', '4', '111', '111', '0', '0', 'aaaa');
INSERT INTO `subscription_plans_detail` VALUES ('6', '5', '88', '88', '0', '0', 'test ');
INSERT INTO `subscription_plans_detail` VALUES ('7', '6', '2', '5', '0', '0', 'ADRIAN');
INSERT INTO `subscription_plans_detail` VALUES ('8', '7', '0', '0', '0', '0', 'dfsdfsdfsdfs');
INSERT INTO `subscription_plans_detail` VALUES ('9', '8', '6', '6', '0', '0', 'rdfdfdf');
INSERT INTO `subscription_plans_detail` VALUES ('10', '9', '1', '1', '0', '0', 'a');
INSERT INTO `subscription_plans_detail` VALUES ('11', '10', '0', '0', '0', '0', 'a');
INSERT INTO `subscription_plans_detail` VALUES ('12', '11', '1', '1', '0', '0', '1');
