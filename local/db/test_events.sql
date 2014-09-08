/*
Navicat MySQL Data Transfer

Source Server         : tagdb200
Source Server Version : 50166
Source Host           : 68.109.244.200:3306
Source Database       : tagbum200

Target Server Type    : MYSQL
Target Server Version : 50166
File Encoding         : 65001

Date: 2014-09-08 13:50:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `test_events`
-- ----------------------------
DROP TABLE IF EXISTS `test_events`;
CREATE TABLE `test_events` (
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `event` tinytext CHARACTER SET utf8,
  PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of test_events
-- ----------------------------
