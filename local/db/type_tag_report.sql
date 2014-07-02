/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2013-10-23 11:14:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `type_tag_report`
-- ----------------------------
DROP TABLE IF EXISTS `type_tag_report`;
CREATE TABLE `type_tag_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descrip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=433 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of type_tag_report
-- ----------------------------
INSERT INTO `type_tag_report` VALUES ('1', 'ACTIONSTAGS_REPORTTAG_SPAMORSCAM');
INSERT INTO `type_tag_report` VALUES ('2', 'ACTIONSTAGS_REPORTTAG_HATEPERSONALATTACK');
INSERT INTO `type_tag_report` VALUES ('3', 'ACTIONSTAGS_REPORTTAG_VIOLENCE');
INSERT INTO `type_tag_report` VALUES ('4', 'ACTIONSTAGS_REPORTTAG_SEXUALLYCONTENT');
INSERT INTO `type_tag_report` VALUES ('5', 'ACTIONSTAGS_REPORTTAG_HIDE');
INSERT INTO `type_tag_report` VALUES ('6', 'ACTIONSTAGS_REPORTTAG_DELETE');
INSERT INTO `type_tag_report` VALUES ('7', 'ACTIONSTAGS_REPORTTAG_HIDEHOME');
