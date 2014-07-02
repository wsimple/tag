/*
Navicat MySQL Data Transfer

Source Server         : seemytag
Source Server Version : 50535
Source Host           : seemytag.com:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50535
File Encoding         : 65001

Date: 2014-02-11 15:19:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `store_category`
-- ----------------------------
DROP TABLE IF EXISTS `store_category`;
CREATE TABLE `store_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_status` int(11) DEFAULT NULL,
  `id_template` int(11) DEFAULT NULL,
  `name` mediumtext,
  `photo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_category
-- ----------------------------
INSERT INTO `store_category` VALUES ('1', '1', '1068', 'STORE_CATEGORY_BACKGROUNS', null);
INSERT INTO `store_category` VALUES ('2', '1', '1091', 'STORE_CATEGORY_1eb030b63d22f6546248141a36997451', null);
INSERT INTO `store_category` VALUES ('3', '1', '1092', 'STORE_CATEGORY_c2ddc6ddece26c8a50ff79e827209d90', null);
INSERT INTO `store_category` VALUES ('4', '2', '1093', 'STORE_CATEGORY_74e35d065571c8a6ca9318f3cd4313c7', null);
INSERT INTO `store_category` VALUES ('5', '1', '1115', 'STORE_CATEGORY_862f676f238dfcc32234d494573ba1d2', null);
INSERT INTO `store_category` VALUES ('6', '1', '1157', 'STORE_CATEGORY_92970c47f705bd4fe06c53d8b33925fa', null);
INSERT INTO `store_category` VALUES ('7', '1', '1158', 'STORE_CATEGORY_ce5fe2e06b33becb4844f7850895634f', null);
INSERT INTO `store_category` VALUES ('8', '1', '1159', 'STORE_CATEGORY_6ad391233131691906660a3663677339', null);
INSERT INTO `store_category` VALUES ('9', '1', '1160', 'STORE_CATEGORY_be06a5fcd5bb413dafde13437e2ea739', null);
INSERT INTO `store_category` VALUES ('10', '1', '1161', 'STORE_CATEGORY_3a923c99b81bcc407b22b14fa4a37f1a', null);
INSERT INTO `store_category` VALUES ('11', '1', '1162', 'STORE_CATEGORY_3e2df5c46a9a68bb0832686d2e7e1e09', null);
INSERT INTO `store_category` VALUES ('12', '1', '1163', 'STORE_CATEGORY_e156977757c085305c63ead999ac4e2c', null);
INSERT INTO `store_category` VALUES ('13', '1', '1164', 'STORE_CATEGORY_30a518ab7b97ec70be41ae6d309d83b0', null);
INSERT INTO `store_category` VALUES ('14', '1', '1165', 'STORE_CATEGORY_901393c75cbdcba8365a2dc9091191b5', null);
INSERT INTO `store_category` VALUES ('15', '1', '1166', 'STORE_CATEGORY_631f6515b4e7fc1548cf0f9dd1d31a4e', null);
INSERT INTO `store_category` VALUES ('16', '1', '1167', 'STORE_CATEGORY_7a2f73560c2648bda9db676f250cc870', null);
INSERT INTO `store_category` VALUES ('17', '1', '1168', 'STORE_CATEGORY_261b63a6bd982dd719af46db80040241', null);
INSERT INTO `store_category` VALUES ('18', '1', '1169', 'STORE_CATEGORY_734c554f6bda65221e036cb6f764fbf2', null);
INSERT INTO `store_category` VALUES ('19', '1', '1170', 'STORE_CATEGORY_a0f0aa8c972c3b1828f715432960d526', null);
INSERT INTO `store_category` VALUES ('20', '1', '1171', 'STORE_CATEGORY_2289bb35949c5083694c54f4160b6dbf', null);
INSERT INTO `store_category` VALUES ('21', '1', '1172', 'STORE_CATEGORY_9d99f4b20e51cb3a317f5d7f47a284ff', null);
INSERT INTO `store_category` VALUES ('22', '1', '1173', 'STORE_CATEGORY_8579f382c2245af2302e14959633e049', null);
INSERT INTO `store_category` VALUES ('23', '1', '1174', 'STORE_CATEGORY_780907fcc47942a87c03430c7dfe680e', null);
INSERT INTO `store_category` VALUES ('24', '1', '1197', 'STORE_CATEGORY_58067ca8b19451701406e7859c5115d8', null);
INSERT INTO `store_category` VALUES ('25', '1', '1199', 'STORE_CATEGORY_9a48374be7ea99e0255d052d1e6a1248', null);
