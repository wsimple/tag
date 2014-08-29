/*
Navicat MySQL Data Transfer

Source Server         : tagdb200
Source Server Version : 50166
Source Host           : 68.109.244.200:3306
Source Database       : tagbum200

Target Server Type    : MYSQL
Target Server Version : 50166
File Encoding         : 65001

Date: 2014-08-29 14:11:36
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

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

-- ----------------------------
-- Table structure for `store_logs`
-- ----------------------------
DROP TABLE IF EXISTS `store_logs`;
CREATE TABLE `store_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `sesion` int(11) NOT NULL,
  `dateAction` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of store_logs
-- ----------------------------

-- ----------------------------
-- Table structure for `store_orders`
-- ----------------------------
DROP TABLE IF EXISTS `store_orders`;
CREATE TABLE `store_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_status` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=284 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_orders
-- ----------------------------
INSERT INTO `store_orders` VALUES ('1', '2', '6', '2013-05-24 04:19:21');
INSERT INTO `store_orders` VALUES ('2', '2', '435', '2013-05-24 04:21:31');
INSERT INTO `store_orders` VALUES ('3', '2', '435', '2013-05-24 05:39:30');
INSERT INTO `store_orders` VALUES ('4', '2', '1', '2013-05-24 05:48:03');
INSERT INTO `store_orders` VALUES ('5', '2', '1', '2013-05-24 05:48:19');
INSERT INTO `store_orders` VALUES ('6', '2', '435', '2013-05-24 05:51:30');
INSERT INTO `store_orders` VALUES ('7', '2', '435', '2013-05-24 06:08:36');
INSERT INTO `store_orders` VALUES ('8', '2', '6', '2013-05-24 06:10:57');
INSERT INTO `store_orders` VALUES ('9', '2', '6', '2013-05-24 06:18:22');
INSERT INTO `store_orders` VALUES ('10', '2', '435', '2013-05-24 06:19:52');
INSERT INTO `store_orders` VALUES ('11', '2', '435', '2013-05-24 06:23:39');
INSERT INTO `store_orders` VALUES ('12', '2', '6', '2013-05-24 06:28:03');
INSERT INTO `store_orders` VALUES ('13', '2', '435', '2013-05-24 07:15:22');
INSERT INTO `store_orders` VALUES ('14', '2', '435', '2013-05-24 08:06:20');
INSERT INTO `store_orders` VALUES ('15', '2', '6', '2013-05-24 08:10:58');
INSERT INTO `store_orders` VALUES ('16', '2', '6', '2013-05-24 08:15:31');
INSERT INTO `store_orders` VALUES ('17', '2', '6', '2013-05-24 08:24:16');
INSERT INTO `store_orders` VALUES ('18', '2', '6', '2013-05-24 08:27:04');
INSERT INTO `store_orders` VALUES ('19', '2', '6', '2013-05-24 08:30:49');
INSERT INTO `store_orders` VALUES ('20', '2', '6', '2013-05-24 08:34:24');
INSERT INTO `store_orders` VALUES ('21', '2', '435', '2013-05-24 08:44:44');
INSERT INTO `store_orders` VALUES ('22', '2', '16', '2013-05-24 08:50:16');
INSERT INTO `store_orders` VALUES ('23', '2', '6', '2013-05-24 09:12:57');
INSERT INTO `store_orders` VALUES ('24', '2', '6', '2013-05-27 07:19:01');
INSERT INTO `store_orders` VALUES ('25', '2', '6', '2013-05-27 07:33:38');
INSERT INTO `store_orders` VALUES ('26', '2', '6', '2013-05-27 08:19:44');
INSERT INTO `store_orders` VALUES ('27', '2', '6', '2013-05-27 08:19:57');
INSERT INTO `store_orders` VALUES ('28', '2', '6', '2013-05-27 08:31:18');
INSERT INTO `store_orders` VALUES ('29', '2', '6', '2013-05-27 08:34:47');
INSERT INTO `store_orders` VALUES ('30', '2', '6', '2013-05-27 08:40:27');
INSERT INTO `store_orders` VALUES ('31', '2', '6', '2013-05-27 08:44:38');
INSERT INTO `store_orders` VALUES ('32', '2', '6', '2013-05-27 08:46:23');
INSERT INTO `store_orders` VALUES ('33', '2', '16', '2013-05-28 09:07:14');
INSERT INTO `store_orders` VALUES ('34', '2', '16', '2013-05-31 18:31:19');
INSERT INTO `store_orders` VALUES ('35', '2', '16', '2013-05-31 18:31:22');
INSERT INTO `store_orders` VALUES ('36', '2', '437', '2013-06-03 07:53:04');
INSERT INTO `store_orders` VALUES ('37', '2', '437', '2013-06-03 08:10:41');
INSERT INTO `store_orders` VALUES ('38', '2', '437', '2013-06-03 08:11:33');
INSERT INTO `store_orders` VALUES ('39', '2', '437', '2013-06-03 08:18:07');
INSERT INTO `store_orders` VALUES ('40', '2', '6', '2013-06-04 09:09:04');
INSERT INTO `store_orders` VALUES ('41', '2', '6', '2013-06-05 06:38:02');
INSERT INTO `store_orders` VALUES ('42', '2', '1', '2013-06-18 01:56:24');
INSERT INTO `store_orders` VALUES ('43', '2', '1', '2013-06-18 02:15:45');
INSERT INTO `store_orders` VALUES ('44', '2', '16', '2013-06-18 02:29:21');
INSERT INTO `store_orders` VALUES ('45', '2', '9', '2013-06-18 02:50:51');
INSERT INTO `store_orders` VALUES ('46', '2', '16', '2013-06-18 04:13:36');
INSERT INTO `store_orders` VALUES ('47', '2', '9', '2013-06-19 04:17:09');
INSERT INTO `store_orders` VALUES ('48', '2', '9', '2013-06-19 14:34:22');
INSERT INTO `store_orders` VALUES ('49', '2', '58', '2013-06-20 05:32:53');
INSERT INTO `store_orders` VALUES ('50', '2', '1', '2013-06-25 06:20:09');
INSERT INTO `store_orders` VALUES ('51', '2', '437', '2013-06-28 07:00:55');
INSERT INTO `store_orders` VALUES ('52', '2', '1', '2013-07-02 03:17:53');
INSERT INTO `store_orders` VALUES ('53', '2', '58', '2013-07-05 06:40:41');
INSERT INTO `store_orders` VALUES ('54', '2', '1', '2013-07-09 11:11:15');
INSERT INTO `store_orders` VALUES ('57', '2', '435', '2013-07-10 06:19:25');
INSERT INTO `store_orders` VALUES ('58', '2', '437', '2013-07-10 06:59:14');
INSERT INTO `store_orders` VALUES ('60', '2', '437', '2013-07-10 07:05:05');
INSERT INTO `store_orders` VALUES ('62', '2', '437', '2013-07-10 07:35:29');
INSERT INTO `store_orders` VALUES ('63', '2', '437', '2013-07-10 07:35:57');
INSERT INTO `store_orders` VALUES ('64', '2', '437', '2013-07-10 07:58:09');
INSERT INTO `store_orders` VALUES ('66', '2', '437', '2013-07-10 08:06:45');
INSERT INTO `store_orders` VALUES ('67', '2', '437', '2013-07-10 08:11:14');
INSERT INTO `store_orders` VALUES ('68', '2', '437', '2013-07-11 02:08:36');
INSERT INTO `store_orders` VALUES ('69', '2', '437', '2013-07-11 02:20:32');
INSERT INTO `store_orders` VALUES ('70', '2', '437', '2013-07-11 06:05:32');
INSERT INTO `store_orders` VALUES ('71', '2', '437', '2013-07-11 07:13:29');
INSERT INTO `store_orders` VALUES ('72', '2', '433', '2013-07-11 08:39:50');
INSERT INTO `store_orders` VALUES ('73', '2', '435', '2013-07-12 00:58:33');
INSERT INTO `store_orders` VALUES ('74', '2', '435', '2013-07-12 01:06:55');
INSERT INTO `store_orders` VALUES ('76', '2', '435', '2013-07-12 09:12:14');
INSERT INTO `store_orders` VALUES ('77', '2', '435', '2013-07-12 09:14:45');
INSERT INTO `store_orders` VALUES ('79', '2', '435', '2013-07-16 06:50:46');
INSERT INTO `store_orders` VALUES ('80', '2', '435', '2013-07-16 06:52:40');
INSERT INTO `store_orders` VALUES ('81', '2', '435', '2013-07-16 07:02:38');
INSERT INTO `store_orders` VALUES ('82', '2', '435', '2013-07-16 07:33:01');
INSERT INTO `store_orders` VALUES ('83', '2', '619', '2013-07-16 07:52:10');
INSERT INTO `store_orders` VALUES ('84', '2', '6', '2013-07-16 08:01:55');
INSERT INTO `store_orders` VALUES ('85', '2', '6', '2013-07-16 08:15:16');
INSERT INTO `store_orders` VALUES ('86', '2', '435', '2013-07-16 08:23:12');
INSERT INTO `store_orders` VALUES ('87', '2', '435', '2013-07-16 08:27:55');
INSERT INTO `store_orders` VALUES ('88', '2', '435', '2013-07-17 01:57:34');
INSERT INTO `store_orders` VALUES ('89', '2', '1', '2013-07-17 02:52:59');
INSERT INTO `store_orders` VALUES ('90', '2', '2', '2013-07-17 07:43:44');
INSERT INTO `store_orders` VALUES ('91', '1', '58', '2014-08-23 19:44:50');
INSERT INTO `store_orders` VALUES ('92', '2', '437', '2013-07-19 08:37:18');
INSERT INTO `store_orders` VALUES ('93', '2', '437', '2013-07-19 09:16:58');
INSERT INTO `store_orders` VALUES ('94', '2', '437', '2013-07-19 09:21:08');
INSERT INTO `store_orders` VALUES ('96', '2', '437', '2013-07-22 05:50:02');
INSERT INTO `store_orders` VALUES ('97', '2', '437', '2013-07-22 05:52:24');
INSERT INTO `store_orders` VALUES ('98', '2', '437', '2013-07-22 05:53:57');
INSERT INTO `store_orders` VALUES ('99', '2', '437', '2013-07-22 06:07:22');
INSERT INTO `store_orders` VALUES ('100', '2', '437', '2013-07-22 06:24:38');
INSERT INTO `store_orders` VALUES ('101', '2', '437', '2013-07-22 06:38:31');
INSERT INTO `store_orders` VALUES ('102', '2', '437', '2013-07-22 07:35:30');
INSERT INTO `store_orders` VALUES ('103', '2', '437', '2013-07-22 07:36:11');
INSERT INTO `store_orders` VALUES ('104', '2', '437', '2013-07-22 07:37:31');
INSERT INTO `store_orders` VALUES ('105', '2', '437', '2013-07-22 07:45:23');
INSERT INTO `store_orders` VALUES ('106', '2', '437', '2013-07-22 07:55:49');
INSERT INTO `store_orders` VALUES ('107', '2', '437', '2013-07-22 08:11:17');
INSERT INTO `store_orders` VALUES ('109', '2', '437', '2013-07-22 09:31:25');
INSERT INTO `store_orders` VALUES ('110', '2', '437', '2013-07-22 09:31:52');
INSERT INTO `store_orders` VALUES ('111', '2', '437', '2013-07-22 09:42:31');
INSERT INTO `store_orders` VALUES ('112', '2', '437', '2013-07-22 09:45:38');
INSERT INTO `store_orders` VALUES ('113', '2', '437', '2013-07-22 09:46:35');
INSERT INTO `store_orders` VALUES ('114', '2', '437', '2013-07-22 09:48:42');
INSERT INTO `store_orders` VALUES ('115', '2', '437', '2013-07-22 10:11:47');
INSERT INTO `store_orders` VALUES ('116', '2', '1', '2013-07-23 06:41:03');
INSERT INTO `store_orders` VALUES ('117', '2', '1', '2013-07-23 06:41:38');
INSERT INTO `store_orders` VALUES ('118', '2', '9', '2013-07-24 06:51:41');
INSERT INTO `store_orders` VALUES ('119', '2', '437', '2013-07-31 02:26:10');
INSERT INTO `store_orders` VALUES ('120', '1', '168', '2013-08-02 16:24:48');
INSERT INTO `store_orders` VALUES ('123', '2', '435', '2013-08-05 07:49:25');
INSERT INTO `store_orders` VALUES ('124', '2', '435', '2013-08-06 07:23:20');
INSERT INTO `store_orders` VALUES ('125', '2', '435', '2013-08-05 09:28:03');
INSERT INTO `store_orders` VALUES ('126', '2', '435', '2013-08-06 01:11:16');
INSERT INTO `store_orders` VALUES ('127', '2', '435', '2013-08-06 02:51:03');
INSERT INTO `store_orders` VALUES ('129', '2', '435', '2013-08-06 06:36:26');
INSERT INTO `store_orders` VALUES ('132', '2', '435', '2013-08-06 04:23:09');
INSERT INTO `store_orders` VALUES ('133', '2', '435', '2013-08-06 07:17:30');
INSERT INTO `store_orders` VALUES ('134', '2', '435', '2013-08-06 07:14:45');
INSERT INTO `store_orders` VALUES ('135', '2', '435', '2013-08-06 06:47:52');
INSERT INTO `store_orders` VALUES ('136', '11', '435', '2013-08-06 08:11:02');
INSERT INTO `store_orders` VALUES ('137', '12', '2', '2013-08-06 08:20:47');
INSERT INTO `store_orders` VALUES ('138', '1', '2', '2014-08-29 09:54:13');
INSERT INTO `store_orders` VALUES ('140', '12', '374', '2013-09-18 08:48:21');
INSERT INTO `store_orders` VALUES ('141', '2', '437', '2013-08-09 08:00:55');
INSERT INTO `store_orders` VALUES ('142', '2', '437', '2013-08-09 08:03:20');
INSERT INTO `store_orders` VALUES ('143', '2', '437', '2013-08-09 08:07:26');
INSERT INTO `store_orders` VALUES ('145', '2', '438', '2013-08-09 08:41:12');
INSERT INTO `store_orders` VALUES ('146', '2', '438', '2013-08-09 08:44:19');
INSERT INTO `store_orders` VALUES ('147', '2', '439', '2013-08-09 08:50:01');
INSERT INTO `store_orders` VALUES ('148', '2', '437', '2013-08-09 08:53:46');
INSERT INTO `store_orders` VALUES ('149', '2', '437', '2013-08-09 08:55:55');
INSERT INTO `store_orders` VALUES ('150', '2', '438', '2013-08-09 09:06:17');
INSERT INTO `store_orders` VALUES ('151', '2', '438', '2013-08-09 09:07:44');
INSERT INTO `store_orders` VALUES ('152', '2', '438', '2013-08-09 09:13:17');
INSERT INTO `store_orders` VALUES ('153', '2', '438', '2013-08-09 09:15:42');
INSERT INTO `store_orders` VALUES ('155', '2', '438', '2013-08-12 06:09:25');
INSERT INTO `store_orders` VALUES ('156', '2', '438', '2013-08-12 06:12:27');
INSERT INTO `store_orders` VALUES ('158', '2', '438', '2013-08-12 06:22:29');
INSERT INTO `store_orders` VALUES ('159', '2', '438', '2013-08-12 06:23:51');
INSERT INTO `store_orders` VALUES ('160', '2', '438', '2013-08-12 07:31:31');
INSERT INTO `store_orders` VALUES ('163', '2', '438', '2013-08-12 08:00:44');
INSERT INTO `store_orders` VALUES ('164', '2', '438', '2013-08-12 08:30:51');
INSERT INTO `store_orders` VALUES ('165', '2', '438', '2013-08-12 08:33:47');
INSERT INTO `store_orders` VALUES ('166', '2', '438', '2013-08-12 08:45:12');
INSERT INTO `store_orders` VALUES ('167', '2', '438', '2013-08-12 08:56:09');
INSERT INTO `store_orders` VALUES ('168', '12', '438', '2013-08-16 03:24:31');
INSERT INTO `store_orders` VALUES ('169', '2', '439', '2013-08-15 03:14:36');
INSERT INTO `store_orders` VALUES ('170', '2', '439', '2013-08-15 03:17:58');
INSERT INTO `store_orders` VALUES ('171', '2', '439', '2013-08-15 03:20:35');
INSERT INTO `store_orders` VALUES ('173', '11', '1', '2014-07-17 16:50:15');
INSERT INTO `store_orders` VALUES ('174', '11', '439', '2013-08-16 01:49:20');
INSERT INTO `store_orders` VALUES ('175', '2', '439', '2013-08-16 03:10:33');
INSERT INTO `store_orders` VALUES ('176', '2', '439', '2013-08-16 04:16:05');
INSERT INTO `store_orders` VALUES ('177', '12', '439', '2013-08-16 04:24:02');
INSERT INTO `store_orders` VALUES ('178', '12', '439', '2013-08-16 08:57:20');
INSERT INTO `store_orders` VALUES ('179', '12', '439', '2013-08-16 09:06:39');
INSERT INTO `store_orders` VALUES ('180', '2', '439', '2013-08-16 09:26:29');
INSERT INTO `store_orders` VALUES ('181', '12', '439', '2013-08-16 09:27:20');
INSERT INTO `store_orders` VALUES ('182', '12', '439', '2013-08-16 09:30:09');
INSERT INTO `store_orders` VALUES ('183', '12', '435', '2013-08-19 00:57:45');
INSERT INTO `store_orders` VALUES ('184', '12', '435', '2013-08-19 01:11:29');
INSERT INTO `store_orders` VALUES ('185', '2', '435', '2013-08-19 03:20:37');
INSERT INTO `store_orders` VALUES ('186', '12', '437', '2013-08-19 03:20:07');
INSERT INTO `store_orders` VALUES ('187', '2', '435', '2013-08-19 04:09:04');
INSERT INTO `store_orders` VALUES ('188', '12', '437', '2013-08-19 04:07:48');
INSERT INTO `store_orders` VALUES ('189', '12', '435', '2013-08-19 07:12:20');
INSERT INTO `store_orders` VALUES ('190', '2', '437', '2013-08-19 07:48:53');
INSERT INTO `store_orders` VALUES ('191', '2', '435', '2013-08-19 07:18:34');
INSERT INTO `store_orders` VALUES ('192', '2', '435', '2013-08-19 07:52:23');
INSERT INTO `store_orders` VALUES ('193', '12', '437', '2013-08-19 08:52:14');
INSERT INTO `store_orders` VALUES ('194', '2', '435', '2013-08-19 07:56:49');
INSERT INTO `store_orders` VALUES ('195', '12', '435', '2013-08-19 08:04:34');
INSERT INTO `store_orders` VALUES ('196', '12', '435', '2013-08-19 08:07:21');
INSERT INTO `store_orders` VALUES ('197', '2', '435', '2013-08-19 08:12:48');
INSERT INTO `store_orders` VALUES ('198', '12', '435', '2013-08-19 08:27:10');
INSERT INTO `store_orders` VALUES ('199', '12', '435', '2013-08-19 08:30:31');
INSERT INTO `store_orders` VALUES ('200', '12', '435', '2013-08-19 08:52:25');
INSERT INTO `store_orders` VALUES ('201', '12', '437', '2013-08-19 09:08:54');
INSERT INTO `store_orders` VALUES ('202', '12', '435', '2013-08-19 09:09:17');
INSERT INTO `store_orders` VALUES ('203', '12', '437', '2013-08-19 09:28:57');
INSERT INTO `store_orders` VALUES ('204', '12', '435', '2013-08-19 09:29:17');
INSERT INTO `store_orders` VALUES ('205', '12', '435', '2013-08-20 01:58:33');
INSERT INTO `store_orders` VALUES ('206', '12', '435', '2013-08-20 02:22:51');
INSERT INTO `store_orders` VALUES ('207', '12', '437', '2013-08-20 02:32:22');
INSERT INTO `store_orders` VALUES ('208', '12', '435', '2013-08-20 02:33:38');
INSERT INTO `store_orders` VALUES ('209', '2', '427', '2013-08-20 06:42:56');
INSERT INTO `store_orders` VALUES ('210', '12', '427', '2013-08-20 06:47:38');
INSERT INTO `store_orders` VALUES ('211', '11', '427', '2013-08-20 06:53:05');
INSERT INTO `store_orders` VALUES ('212', '12', '435', '2014-01-15 01:36:54');
INSERT INTO `store_orders` VALUES ('213', '2', '439', '2013-08-21 08:57:22');
INSERT INTO `store_orders` VALUES ('214', '1', '427', '2013-12-12 23:24:50');
INSERT INTO `store_orders` VALUES ('215', '12', '6', '2013-08-28 08:41:56');
INSERT INTO `store_orders` VALUES ('216', '1', '2', '2014-08-29 09:54:13');
INSERT INTO `store_orders` VALUES ('217', '2', '439', '2013-09-02 07:18:30');
INSERT INTO `store_orders` VALUES ('218', '11', '439', '2013-09-02 08:59:03');
INSERT INTO `store_orders` VALUES ('219', '12', '437', '2013-09-13 09:51:51');
INSERT INTO `store_orders` VALUES ('220', '12', '6', '2013-09-18 09:33:37');
INSERT INTO `store_orders` VALUES ('221', '1', '157', '2014-08-28 15:17:08');
INSERT INTO `store_orders` VALUES ('222', '1', '16', '2014-08-27 11:23:50');
INSERT INTO `store_orders` VALUES ('223', '12', '386', '2013-09-18 08:48:25');
INSERT INTO `store_orders` VALUES ('224', '12', '437', '2013-09-18 00:21:50');
INSERT INTO `store_orders` VALUES ('225', '12', '437', '2013-09-18 01:10:03');
INSERT INTO `store_orders` VALUES ('226', '12', '437', '2013-09-18 08:26:40');
INSERT INTO `store_orders` VALUES ('227', '12', '437', '2013-09-18 08:30:33');
INSERT INTO `store_orders` VALUES ('228', '12', '437', '2013-09-19 01:06:08');
INSERT INTO `store_orders` VALUES ('229', '2', '386', '2013-09-20 06:45:55');
INSERT INTO `store_orders` VALUES ('230', '12', '374', '2013-09-18 09:35:57');
INSERT INTO `store_orders` VALUES ('231', '2', '433', '2013-10-27 04:01:57');
INSERT INTO `store_orders` VALUES ('232', '12', '437', '2014-01-16 06:04:27');
INSERT INTO `store_orders` VALUES ('233', '1', '409', '2013-10-06 12:48:35');
INSERT INTO `store_orders` VALUES ('234', '2', '105', '2013-10-09 08:32:49');
INSERT INTO `store_orders` VALUES ('235', '5', '435', '2013-10-11 03:48:20');
INSERT INTO `store_orders` VALUES ('236', '5', '386', '2013-10-16 03:05:26');
INSERT INTO `store_orders` VALUES ('237', '5', '439', '2013-10-17 03:21:49');
INSERT INTO `store_orders` VALUES ('238', '5', '1', '2013-10-22 05:10:10');
INSERT INTO `store_orders` VALUES ('239', '5', '157', '2013-10-22 05:10:15');
INSERT INTO `store_orders` VALUES ('240', '12', '433', '2014-07-28 08:34:22');
INSERT INTO `store_orders` VALUES ('241', '5', '58', '2013-11-15 02:18:07');
INSERT INTO `store_orders` VALUES ('242', '5', '627', '2013-12-04 05:26:32');
INSERT INTO `store_orders` VALUES ('243', '5', '437', '2013-12-04 05:35:04');
INSERT INTO `store_orders` VALUES ('244', '1', '105', '2014-08-28 08:46:31');
INSERT INTO `store_orders` VALUES ('245', '5', '409', '2013-12-10 05:08:06');
INSERT INTO `store_orders` VALUES ('246', '12', '9', '2013-12-19 07:54:56');
INSERT INTO `store_orders` VALUES ('247', '12', '9', '2013-12-20 10:26:28');
INSERT INTO `store_orders` VALUES ('248', '1', '438', '2014-01-29 23:47:45');
INSERT INTO `store_orders` VALUES ('249', '12', '435', '2014-01-15 01:51:00');
INSERT INTO `store_orders` VALUES ('250', '2', '435', '2014-01-29 23:56:24');
INSERT INTO `store_orders` VALUES ('251', '2', '429', '2014-01-21 04:48:06');
INSERT INTO `store_orders` VALUES ('252', '12', '439', '2014-01-24 01:37:32');
INSERT INTO `store_orders` VALUES ('253', '1', '9', '2014-08-29 03:03:40');
INSERT INTO `store_orders` VALUES ('254', '2', '435', '2014-01-29 23:56:48');
INSERT INTO `store_orders` VALUES ('255', '2', '435', '2014-01-29 23:57:35');
INSERT INTO `store_orders` VALUES ('256', '2', '435', '2014-01-29 23:58:20');
INSERT INTO `store_orders` VALUES ('257', '2', '435', '2014-01-30 00:07:25');
INSERT INTO `store_orders` VALUES ('258', '2', '435', '2014-01-30 00:08:39');
INSERT INTO `store_orders` VALUES ('259', '2', '435', '2014-01-30 00:10:23');
INSERT INTO `store_orders` VALUES ('260', '2', '435', '2014-01-30 00:11:40');
INSERT INTO `store_orders` VALUES ('261', '2', '435', '2014-01-30 00:14:21');
INSERT INTO `store_orders` VALUES ('262', '2', '435', '2014-01-30 06:03:03');
INSERT INTO `store_orders` VALUES ('263', '12', '435', '2014-01-30 06:18:20');
INSERT INTO `store_orders` VALUES ('264', '12', '435', '2014-01-30 06:22:54');
INSERT INTO `store_orders` VALUES ('265', '12', '435', '2014-01-30 06:25:09');
INSERT INTO `store_orders` VALUES ('266', '12', '435', '2014-01-30 06:38:07');
INSERT INTO `store_orders` VALUES ('267', '11', '435', '2014-02-04 06:25:50');
INSERT INTO `store_orders` VALUES ('268', '12', '435', '2014-02-10 23:06:14');
INSERT INTO `store_orders` VALUES ('269', '12', '6', '2014-02-10 22:50:34');
INSERT INTO `store_orders` VALUES ('270', '12', '435', '2014-02-10 23:18:51');
INSERT INTO `store_orders` VALUES ('271', '12', '435', '2014-02-10 23:32:00');
INSERT INTO `store_orders` VALUES ('272', '12', '435', '2014-02-10 23:48:53');
INSERT INTO `store_orders` VALUES ('273', '1', '386', '2014-08-05 09:16:36');
INSERT INTO `store_orders` VALUES ('274', '5', '16', '2014-03-03 04:56:07');
INSERT INTO `store_orders` VALUES ('275', '2', '374', '2014-03-06 04:58:49');
INSERT INTO `store_orders` VALUES ('276', '12', '374', '2014-03-06 05:00:29');
INSERT INTO `store_orders` VALUES ('277', '12', '435', '2014-07-25 14:50:41');
INSERT INTO `store_orders` VALUES ('278', '12', '374', '2014-03-06 06:11:11');
INSERT INTO `store_orders` VALUES ('279', '1', '6', '2014-08-28 08:25:05');
INSERT INTO `store_orders` VALUES ('280', '12', '1', '2014-07-22 13:20:37');
INSERT INTO `store_orders` VALUES ('281', '11', '435', '2014-07-28 08:33:32');
INSERT INTO `store_orders` VALUES ('282', '12', '433', '2014-08-04 12:21:57');
INSERT INTO `store_orders` VALUES ('283', '2', '3', '2014-08-06 08:48:57');

-- ----------------------------
-- Table structure for `store_orders_detail`
-- ----------------------------
DROP TABLE IF EXISTS `store_orders_detail`;
CREATE TABLE `store_orders_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `cant` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `formPayment` char(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=468 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_orders_detail
-- ----------------------------
INSERT INTO `store_orders_detail` VALUES ('1', '1', '5', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('2', '1', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('3', '1', '8', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('4', '2', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('5', '2', '3', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('6', '2', '4', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('7', '3', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('8', '3', '3', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('9', '3', '4', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('10', '4', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('11', '4', '5', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('12', '5', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('13', '5', '5', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('14', '6', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('15', '6', '3', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('16', '6', '4', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('17', '7', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('18', '7', '3', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('19', '7', '4', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('20', '8', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('21', '9', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('22', '10', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('23', '10', '3', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('24', '10', '4', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('25', '11', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('26', '11', '3', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('27', '11', '4', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('28', '12', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('29', '13', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('30', '13', '3', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('31', '13', '4', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('32', '14', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('33', '14', '3', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('34', '14', '4', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('35', '15', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('36', '16', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('37', '17', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('38', '18', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('39', '19', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('40', '20', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('41', '21', '2', '6', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('42', '21', '3', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('43', '21', '4', '6', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('44', '22', '5', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('45', '23', '5', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('46', '24', '9', '1', '1', '23', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('47', '25', '9', '1', '1', '23', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('48', '26', '9', '1', '1', '23', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('49', '27', '9', '1', '1', '23', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('50', '28', '9', '1', '1', '23', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('51', '29', '9', '1', '1', '23', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('52', '30', '9', '1', '1', '23', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('53', '31', '9', '1', '1', '23', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('54', '32', '9', '1', '1', '23', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('55', '32', '5', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('56', '33', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('57', '36', '8', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('58', '37', '8', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('59', '37', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('60', '38', '8', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('61', '38', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('62', '39', '8', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('63', '39', '6', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('64', '40', '14', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('65', '40', '8', '435', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('66', '42', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('67', '42', '6', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('68', '43', '7', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('69', '44', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('70', '45', '6', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('71', '46', '8', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('72', '47', '11', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('73', '48', '7', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('74', '49', '11', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('75', '50', '28', '437', '10', '5000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('76', '50', '4', '427', '1', '5000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('77', '51', '31', '435', '1', '130', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('78', '52', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('79', '53', '8', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('80', '54', '4', '427', '1', '5000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('81', '54', '30', '437', '1', '15', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('84', '57', '30', '437', '1', '15', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('85', '58', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('89', '60', '20', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('91', '62', '22', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('92', '63', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('93', '64', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('95', '66', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('96', '67', '31', '435', '1', '130', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('99', '67', '21', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('109', '68', '34', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('110', '68', '31', '435', '1', '130', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('111', '69', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('112', '69', '34', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('113', '70', '34', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('115', '71', '34', '439', '3', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('116', '71', '31', '435', '1', '130', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('119', '73', '33', '437', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('120', '73', '34', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('121', '73', '36', '437', '1', '15', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('122', '73', '38', '439', '1', '153', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('123', '73', '37', '439', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('124', '74', '1', '437', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('125', '74', '39', '439', '1', '150', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('126', '74', '37', '439', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('128', '76', '34', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('129', '77', '33', '437', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('131', '79', '38', '439', '1', '153', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('132', '80', '35', '437', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('133', '81', '35', '437', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('134', '82', '34', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('135', '83', '33', '437', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('136', '84', '39', '439', '1', '150', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('137', '84', '10', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('138', '85', '37', '439', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('139', '86', '40', '6', '1', '200', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('140', '72', '35', '437', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('141', '87', '40', '6', '1', '1000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('142', '88', '35', '437', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('143', '89', '39', '439', '1', '150', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('144', '89', '40', '6', '1', '4000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('145', '90', '39', '439', '6', '150', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('147', '92', '34', '439', '20', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('148', '93', '34', '439', '1', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('149', '93', '31', '435', '1', '130', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('150', '93', '29', '1', '1', '23', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('151', '94', '34', '439', '1', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('152', '94', '31', '435', '1', '130', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('156', '96', '38', '439', '1', '153', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('157', '97', '34', '439', '30', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('158', '98', '34', '439', '1', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('159', '99', '34', '439', '1', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('160', '100', '34', '439', '1', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('161', '101', '34', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('162', '102', '34', '439', '3', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('163', '103', '39', '439', '1', '150', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('164', '104', '39', '439', '1', '150', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('165', '104', '34', '439', '5', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('166', '105', '39', '439', '1', '150', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('167', '105', '34', '439', '1', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('168', '106', '34', '439', '10', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('169', '107', '40', '6', '1', '4000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('170', '107', '34', '439', '30', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('172', '109', '31', '435', '1', '130', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('173', '110', '34', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('174', '111', '39', '439', '2', '150', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('175', '111', '34', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('176', '112', '39', '439', '3', '150', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('177', '113', '34', '439', '5', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('178', '114', '38', '439', '1', '153', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('179', '114', '39', '439', '1', '150', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('180', '115', '40', '6', '1', '4000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('181', '116', '41', '437', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('182', '117', '39', '439', '1', '150', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('183', '118', '2', '427', '1', '1234', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('184', '115', '34', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('185', '119', '34', '439', '3', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('186', '120', '35', '437', '1', '10', null, '0');
INSERT INTO `store_orders_detail` VALUES ('189', '123', '41', '437', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('190', '124', '35', '437', '1', '10', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('191', '124', '34', '439', '1', '1', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('192', '125', '42', '58', '1', '250', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('193', '126', '38', '439', '1', '153', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('194', '127', '41', '437', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('196', '129', '33', '437', '1', '1', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('197', '129', '34', '439', '1', '1', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('200', '132', '41', '437', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('201', '133', '39', '439', '1', '150', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('202', '134', '34', '439', '1', '1', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('203', '135', '42', '58', '1', '250', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('204', '136', '34', '439', '1', '1', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('205', '137', '42', '58', '1', '250', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('206', '137', '39', '439', '1', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('207', '138', '36', '437', '1', '15', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('208', '138', '40', '6', '1', '4000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('213', '140', '41', '437', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('214', '119', '5', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('215', '141', '34', '439', '1', '1', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('216', '142', '42', '58', '1', '250', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('217', '142', '34', '439', '3', '1', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('218', '143', '39', '439', '10', '150', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('219', '143', '26', '435', '1', '10', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('220', '143', '22', '435', '1', '10', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('227', '149', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('228', '150', '25', '435', '1', '5', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('230', '152', '34', '439', '1', '1', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('231', '153', '39', '439', '10', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('232', '153', '34', '439', '100', '1', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('239', '158', '25', '435', '1', '5', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('241', '160', '25', '435', '1', '5', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('246', '163', '41', '437', '2', '100', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('247', '163', '39', '439', '1', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('248', '164', '39', '439', '1', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('249', '165', '39', '439', '10', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('250', '166', '44', '439', '3', '5000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('251', '166', '39', '439', '1', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('252', '167', '45', '439', '10', '5000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('253', '167', '35', '437', '1', '10', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('254', '168', '45', '439', '1', '5000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('256', '91', '46', '427', '1', '100000', '11', '');
INSERT INTO `store_orders_detail` VALUES ('257', '169', '32', '437', '1', '650', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('258', '170', '35', '437', '1', '10', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('259', '170', '33', '437', '1', '1', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('260', '170', '25', '435', '1', '5', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('261', '171', '41', '437', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('263', '173', '40', '6', '1', '4000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('264', '174', '48', '437', '4', '1', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('265', '174', '40', '6', '1', '4000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('266', '175', '48', '437', '5', '1', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('267', '176', '48', '437', '0', '1', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('268', '168', '48', '437', '1', '1', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('269', '176', '47', '437', '10', '55', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('270', '177', '41', '427', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('271', '178', '47', '437', '29', '55', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('272', '179', '47', '437', '1', '55', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('273', '179', '45', '427', '1', '5000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('274', '180', '41', '427', '1', '100', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('275', '181', '41', '427', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('276', '182', '35', '437', '1', '10', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('277', '183', '39', '439', '10', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('278', '183', '38', '439', '10', '153', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('279', '184', '39', '439', '10', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('280', '184', '38', '439', '10', '153', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('281', '185', '50', '439', '1', '1', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('282', '186', '50', '439', '9', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('283', '187', '50', '439', '8', '1', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('284', '188', '50', '439', '7', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('285', '187', '32', '437', '1', '650', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('286', '189', '50', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('287', '189', '39', '439', '1', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('288', '190', '50', '439', '8', '1', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('289', '191', '50', '439', '7', '1', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('290', '191', '36', '437', '1', '15', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('291', '192', '50', '439', '10', '1', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('292', '193', '50', '439', '15', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('293', '192', '39', '439', '1', '150', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('294', '192', '36', '437', '1', '15', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('295', '194', '50', '439', '15', '1', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('296', '194', '36', '437', '1', '15', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('297', '195', '50', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('298', '195', '36', '437', '1', '15', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('299', '196', '39', '439', '8', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('300', '196', '45', '427', '1', '5000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('301', '197', '39', '439', '1', '150', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('302', '198', '39', '439', '1', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('303', '199', '39', '439', '1', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('304', '199', '36', '437', '1', '15', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('305', '200', '50', '439', '4', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('306', '200', '36', '437', '1', '15', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('307', '201', '51', '439', '15', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('308', '202', '36', '437', '1', '15', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('309', '202', '51', '439', '5', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('310', '203', '52', '439', '8', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('311', '204', '36', '437', '1', '15', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('312', '204', '52', '439', '2', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('313', '205', '53', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('314', '206', '53', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('315', '207', '53', '439', '5', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('316', '208', '53', '439', '5', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('317', '208', '42', '58', '1', '250', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('318', '208', '41', '427', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('319', '208', '36', '437', '1', '15', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('320', '209', '42', '58', '1', '250', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('321', '210', '53', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('322', '211', '39', '439', '1', '150', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('323', '212', '41', '427', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('324', '213', '35', '437', '1', '10', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('325', '214', '53', '439', '1', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('326', '214', '39', '439', '1', '150', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('327', '215', '33', '437', '2', '1', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('328', '215', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('329', '215', '20', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('330', '215', '42', '58', '1', '250', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('331', '216', '41', '427', '1', '100', null, '0');
INSERT INTO `store_orders_detail` VALUES ('332', '217', '45', '427', '1', '5000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('333', '217', '41', '427', '2', '100', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('334', '217', '35', '437', '4', '10', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('335', '217', '42', '58', '1', '250', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('336', '217', '36', '437', '5', '15', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('337', '218', '45', '427', '10', '5000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('338', '218', '45', '427', '1', '5000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('339', '218', '42', '58', '1', '250', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('340', '218', '47', '437', '1', '55', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('341', '219', '45', '427', '1', '5000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('342', '220', '36', '437', '1', '15', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('343', '221', '36', '437', '1', '15', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('344', '138', '48', '437', '1', '1', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('345', '222', '57', '58', '2', '500000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('346', '223', '56', '374', '1', '300', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('347', '224', '54', '58', '1', '500000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('348', '224', '45', '427', '8', '5000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('349', '224', '38', '439', '1', '153', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('350', '225', '38', '439', '1', '153', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('351', '173', '35', '437', '4', '10', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('352', '226', '38', '439', '2', '153', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('353', '227', '39', '439', '5', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('354', '223', '55', '374', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('355', '140', '53', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('356', '228', '37', '439', '9', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('357', '228', '8', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('358', '229', '56', '374', '1', '300', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('359', '220', '58', '627', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('360', '229', '58', '627', '1', '50', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('361', '230', '58', '627', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('362', '228', '34', '439', '1', '1', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('363', '231', '57', '58', '1', '500000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('364', '231', '58', '627', '1', '50', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('365', '232', '62', '1', '1', '1234', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('366', '233', '2', '427', '1', '1234', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('367', '234', '69', '433', '1', '800000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('368', '235', '68', '433', '1', '350000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('369', '235', '68', '433', '1', '350000', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('370', '235', '39', '439', '1', '150', '5', '1');
INSERT INTO `store_orders_detail` VALUES ('371', '236', '68', '433', '1', '350000', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('372', '212', '1', '437', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('373', '237', '68', '433', '1', '350000', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('374', '238', '35', '437', '1', '10', '5', '1');
INSERT INTO `store_orders_detail` VALUES ('375', '239', '68', '433', '1', '350000', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('376', '138', '68', '433', '1', '350000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('377', '231', '71', '439', '1', '100', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('378', '231', '70', '437', '2', '2222222', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('379', '240', '71', '439', '1', '100', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('380', '240', '70', '437', '6', '2222222', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('381', '240', '67', '437', '1', '100', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('382', '240', '62', '1', '1', '1234', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('383', '240', '58', '627', '1', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('384', '232', '2', '427', '2', '1234', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('385', '232', '4', '427', '1', '5000', '11', '');
INSERT INTO `store_orders_detail` VALUES ('386', '243', '7', '435', '1', '10', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('387', '241', '36', '437', '1', '15', '5', '1');
INSERT INTO `store_orders_detail` VALUES ('388', '242', '68', '433', '1', '350000', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('389', '243', '71', '439', '1', '100', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('390', '244', '47', '437', '1', '55', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('391', '245', '68', '433', '1', '350000', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('392', '246', '26', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('393', '247', '67', '437', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('394', '241', '47', '437', '1', '55', '5', '1');
INSERT INTO `store_orders_detail` VALUES ('395', '248', '77', '58', '1', '250', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('396', '212', '39', '439', '1', '150', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('397', '249', '34', '439', '1', '1', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('398', '250', '77', '58', '1', '250', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('399', '250', '39', '439', '1', '150', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('400', '91', '55', '374', '2', '100', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('401', '232', '22', '435', '1', '10', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('402', '251', '69', '433', '1', '800000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('403', '252', '33', '437', '1', '1', '12', '1');
INSERT INTO `store_orders_detail` VALUES ('404', '253', '53', '439', '1', '1', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('405', '254', '68', '433', '1', '350000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('406', '255', '56', '374', '1', '300', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('407', '256', '39', '439', '1', '150', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('408', '257', '68', '433', '1', '350000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('409', '258', '68', '433', '1', '350000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('410', '259', '39', '439', '1', '150', '2', '1');
INSERT INTO `store_orders_detail` VALUES ('411', '260', '4', '427', '1', '5000', '2', '');
INSERT INTO `store_orders_detail` VALUES ('412', '261', '53', '439', '1', '1', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('413', '262', '77', '58', '1', '250', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('414', '262', '70', '437', '1', '2222222', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('415', '263', '71', '439', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('416', '264', '53', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('417', '265', '53', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('418', '266', '53', '439', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('419', '267', '55', '374', '1', '100', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('420', '267', '76', '58', '1', '250', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('421', '267', '39', '439', '5', '150', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('422', '268', '56', '374', '1', '300', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('423', '269', '31', '435', '1', '130', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('424', '269', '2', '427', '1', '1234', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('425', '268', '45', '427', '1', '5000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('426', '270', '45', '427', '1', '5000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('427', '271', '45', '427', '1', '5000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('428', '272', '45', '427', '1', '5000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('429', '273', '40', '6', '1', '4000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('430', '273', '68', '433', '1', '350000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('431', '273', '27', '435', '1', '100', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('432', '273', '26', '435', '1', '10', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('433', '273', '69', '433', '1', '800000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('434', '273', '23', '437', '1', '3456', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('435', '273', '21', '435', '1', '10', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('436', '241', '55', '374', '1', '100', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('437', '274', '68', '433', '1', '350000', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('438', '273', '31', '435', '1', '130', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('439', '275', '31', '435', '1', '130', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('440', '276', '27', '435', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('441', '276', '45', '427', '2', '5000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('442', '277', '2', '427', '1', '1234', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('443', '276', '68', '433', '1', '350000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('444', '276', '84', '58', '1', '1', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('445', '278', '76', '58', '9', '250', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('446', '278', '58', '627', '5', '50', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('447', '279', '68', '433', '1', '350000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('448', '240', '38', '439', '1', '153', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('449', '277', '82', '58', '1', '250000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('450', '277', '56', '374', '1', '300', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('451', '173', '1', '437', '1', '100', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('452', '173', '2', '427', '1', '1234', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('453', '280', '82', '58', '1', '250000', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('454', '241', '39', '439', '1', '150', '5', '1');
INSERT INTO `store_orders_detail` VALUES ('455', '253', '87', '435', '1', '90000', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('456', '240', '89', '386', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('457', '235', '37', '439', '1', '100', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('458', '281', '39', '439', '1', '150', '11', '1');
INSERT INTO `store_orders_detail` VALUES ('459', '282', '90', '386', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('460', '282', '89', '386', '1', '100', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('461', '282', '77', '58', '1', '250', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('462', '282', '75', '58', '1', '20', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('463', '282', '63', '1', '1', '12', '12', '0');
INSERT INTO `store_orders_detail` VALUES ('464', '283', '88', '435', '1', '9000000', '2', '0');
INSERT INTO `store_orders_detail` VALUES ('465', '245', '2', '427', '1', '1234', '5', '0');
INSERT INTO `store_orders_detail` VALUES ('466', '222', '89', '386', '1', '100', '11', '0');
INSERT INTO `store_orders_detail` VALUES ('467', '222', '2', '427', '1', '1234', '11', '0');

-- ----------------------------
-- Table structure for `store_products`
-- ----------------------------
DROP TABLE IF EXISTS `store_products`;
CREATE TABLE `store_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `id_sub_category` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` mediumtext,
  `stock` int(11) DEFAULT NULL,
  `sale_points` int(11) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  `place` char(1) DEFAULT NULL,
  `formPayment` char(2) DEFAULT NULL,
  `hits` bigint(11) NOT NULL DEFAULT '0',
  `video_url` varchar(200) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_products
-- ----------------------------
INSERT INTO `store_products` VALUES ('1', '437', '1', '2', '18', 'smartphone', 'lo mejor', '998', '100', 'store/7ba044ff1da7c91be37453143202e027/322b66fbdd4c6683a98239d1133c5181.jpg', '2013-06-05', '2013-06-05', '1', '0', '7', '');
INSERT INTO `store_products` VALUES ('2', '427', '1', '3', '20', 'MacBook Pro 13\"', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', '995', '1234', 'store/4411a206fe0515494698b6e933bb179b/e503fc8639127fbb7b93c81ad1e7d4c4.jpg', '2013-06-05', '2013-06-05', '1', '0', '7', '');
INSERT INTO `store_products` VALUES ('4', '427', '1', '5', '24', 'God of War: Ascension', '* Multiplayer comes to God of War for the first time. Take the epic God of War combat online with 8-player objective-based combat. * Align yourself to Zeus, Ares, Poseidon, or Hades and earn their Favor to unlock new customization options for your multiplayer Gladiator. * Experience Kratos? quest for freedom from the very beginning with an epic new single-player story. * New combat and puzzle mechanics build on the award-winning God of War gameplay', '10', '5000', 'store/a87ff679a2f3e71d9181a67b7542122c/c4ca4238a0b923820dcc509a6f75849b.jpg', '2013-06-07', '2013-06-07', '1', null, '1', '');
INSERT INTO `store_products` VALUES ('5', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/4b3fee462c04fff0793e3845c7875e62.jpg', '2013-06-07', '2013-06-07', null, '0', '2', '');
INSERT INTO `store_products` VALUES ('6', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/b7adf66ba46382d3eef93067aa6fc1ce.jpg', '2013-06-07', '2013-06-07', null, '0', '37', '');
INSERT INTO `store_products` VALUES ('7', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/bc9b4b0e9b609f8c504a81ab1ea1ddc8.jpg', '2013-06-07', '2013-06-07', null, '0', '6', '');
INSERT INTO `store_products` VALUES ('8', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/d34c28f9999c0fdee26cf786825a62c6.jpg', '2013-06-07', '2013-06-07', null, '0', '3', '');
INSERT INTO `store_products` VALUES ('9', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/bd010fa9832242e4b6bcdc54c22ee368.jpg', '2013-06-07', '2013-06-07', null, '0', '28', '');
INSERT INTO `store_products` VALUES ('10', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/93cd6ab0b761ff2da34def0a27800b05.jpg', '2013-06-07', '2013-06-07', null, '0', '1', '');
INSERT INTO `store_products` VALUES ('11', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/a97e24a2ab3028592d988dcbaab4fb8f.jpg', '2013-06-07', '2013-06-07', null, '0', '0', '');
INSERT INTO `store_products` VALUES ('12', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/a017ee7f27f7c36da7a333a6d9553e25.jpg', '2013-06-07', '2013-06-07', null, '0', '0', '');
INSERT INTO `store_products` VALUES ('13', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/2db9ae4c0aa4b23f25e1b52a8e8244d6.jpg', '2013-06-07', '2013-06-07', null, '0', '1', '');
INSERT INTO `store_products` VALUES ('14', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/a0de3d6df1f532f3a3b8309da67d69c6.jpg', '2013-06-07', '2013-06-07', null, '0', '11', '');
INSERT INTO `store_products` VALUES ('15', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/0986fcf652b5c4b7335b32fad788d7b5.jpg', '2013-06-07', '2013-06-07', null, '0', '0', '');
INSERT INTO `store_products` VALUES ('16', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/c7b422fdcdbfc8e09bb19386f2bfa62a.jpg', '2013-06-07', '2013-06-07', null, '0', '0', '');
INSERT INTO `store_products` VALUES ('17', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/91c604ea45fb7f06f2e8698fdb5a6099.jpeg', '2013-06-07', '2013-06-07', null, '0', '1', '');
INSERT INTO `store_products` VALUES ('18', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/b472073ae847bb582c538df6e7c00962.jpg', '2013-06-07', '2013-06-07', null, '0', '0', '');
INSERT INTO `store_products` VALUES ('19', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/f657f62151590897c72f21729f4cfb6a.jpg', '2013-06-07', '2013-06-07', null, '0', '11', '');
INSERT INTO `store_products` VALUES ('20', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/c40989f94e5068b594a9a69b16ff3255.jpg', '2013-06-07', '2013-06-07', null, '0', '5', '');
INSERT INTO `store_products` VALUES ('21', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/afbb21acefeaccf8a50433ebbee57e4a.jpg', '2013-06-07', '2013-06-07', null, '0', '0', '');
INSERT INTO `store_products` VALUES ('22', '435', '1', '1', '1', 'wallpapers black', 'wallpapers black', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/ca8afc879a29f6b19bca97eed44a40f7.jpg', '2013-06-07', '2013-06-07', null, '0', '0', '');
INSERT INTO `store_products` VALUES ('23', '437', '1', '1', '1', 'Tomb Raider', 't has superb physics-based gameplay\r\nA heart-pounding narrative in Lara\'s most personal, character-defining adventure to date.\r\nThe games present a world in 3D: a series of tombs, and other locations, through which the player must guide Lara.', '1000', '3456', 'store/7ba044ff1da7c91be37453143202e027/032b2cc936860b03048302d991c3498f.jpg|5', '2013-06-07', '2013-06-07', null, '0', '3', '');
INSERT INTO `store_products` VALUES ('24', '437', '1', '5', '24', 'playstation 3 guitar hero', 'playstation 3 guitar hero NEW', '1000', '5900', 'store/7ba044ff1da7c91be37453143202e027/96dda289f59b9c3b1f62f863f32c17bd.jpg', '2013-06-07', '2013-06-07', '1', '0', '1', '');
INSERT INTO `store_products` VALUES ('25', '435', '1', '1', '1', 'Mac', 'Mac', '1000', '5', 'templates/dee6f90d13fa944969f1c83770a22561/8560d443580e979745954d51da82cdeb.jpg', '2013-06-07', '2013-06-07', null, '0', '8', '');
INSERT INTO `store_products` VALUES ('26', '435', '1', '1', '1', 'MAc', 'Mac', '1000', '10', 'templates/dee6f90d13fa944969f1c83770a22561/8560d443580e979745954d51da82cdeb.jpg', '2013-06-07', '2013-06-07', null, '0', '2', '');
INSERT INTO `store_products` VALUES ('27', '435', '1', '1', '1', 'wallpapers sangre', '<b>wallpapers sangre</b>', '1000', '100', 'templates/dee6f90d13fa944969f1c83770a22561/62c261eed8dfee6a91e1e7c6e07d190f.jpg', '2013-06-11', '2013-06-11', null, '0', '9', '');
INSERT INTO `store_products` VALUES ('28', '437', '1', '5', '24', 'infamous play 3', '<i><b>infamous play 3</b></i>', '1000', '5000', 'store/7ba044ff1da7c91be37453143202e027/2be29dc100c9235594ced7b32692e227.jpg', '2013-06-11', '2013-06-11', '1', '0', '16', '');
INSERT INTO `store_products` VALUES ('29', '1', '1', '5', '24', 'Testing store', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', '1000', '23', 'store/4411a206fe0515494698b6e933bb179b/ff813b8d83af4509037f452c7a4210c3.jpg', '2013-06-18', '2013-06-18', '1', '0', '20', '');
INSERT INTO `store_products` VALUES ('30', '437', '1', '5', '24', 'dragon ball z ultimate tenkaichi', 'genero: full action<p><br></p>', '1000', '15', 'store/7ba044ff1da7c91be37453143202e027/c1137649f9fb16425664505933a7d8c3.jpg', '2013-06-28', '2013-06-28', '1', '0', '0', '');
INSERT INTO `store_products` VALUES ('31', '435', '1', '1', '1', 'sol', 'sol', '1000', '130', 'templates/dee6f90d13fa944969f1c83770a22561/2dd5bd3cd4fcb064104d2a09d8a9d54d.jpg', '2013-06-28', '2013-06-28', null, '0', '0', '');
INSERT INTO `store_products` VALUES ('32', '437', '1', '2', '18', 'Samsung Galaxy IV', 'Te lo tengo el galaxy nuevesito de paquetico', '999', '650', 'store/7ba044ff1da7c91be37453143202e027/bc5c4e330cd1c7ef91e8afdfcb1f49fc.jpg', '2013-07-02', '2013-07-02', '1', '1', '7', '');
INSERT INTO `store_products` VALUES ('33', '437', '1', '5', '24', 'fondo de naruto', 'anime de naruto', '999', '1', 'store/7ba044ff1da7c91be37453143202e027/17ba8e5a3fbf30abd3a5d6c0027c07f1.jpg', '2013-07-10', '2013-07-10', '1', '1', '5', '');
INSERT INTO `store_products` VALUES ('34', '439', '1', '5', '24', 'naruto anime', 'un dollars', '893', '1', 'store/9b305304faf18538bdd298a8eadebbc6/cc149edcd5bc15c9cf9f3fbddcdc36df.jpg', '2013-07-10', '2013-07-10', '1', '1', '21', '');
INSERT INTO `store_products` VALUES ('35', '437', '1', '3', '21', 'hp pavilion', 'hp', '996', '10', 'store/7ba044ff1da7c91be37453143202e027/61c05fdfc21378a0b853606cf0187466.jpg', '2013-07-12', '2013-07-12', '1', '1', '10', '');
INSERT INTO `store_products` VALUES ('36', '437', '1', '3', '22', 'Dell', 'Dell ', '999', '15', 'store/7ba044ff1da7c91be37453143202e027/ba92135f38e16474348607c72f6ebf91.jpg', '2013-07-12', '2013-07-12', '1', '1', '22', '');
INSERT INTO `store_products` VALUES ('37', '439', '1', '5', '24', 'the simpsons', 'the simpsons gamer', '992', '100', 'store/9b305304faf18538bdd298a8eadebbc6/83ed903e6a8c9b4868b51c7959db07ce.jpg', '2013-07-12', '2013-07-12', '1', '0', '4', '');
INSERT INTO `store_products` VALUES ('38', '439', '1', '5', '24', 'Futurama play gamer', 'muy buen muy bueno ', '956', '153', 'store/9b305304faf18538bdd298a8eadebbc6/4b4131536c04bd2ef54b0801b6f9be83.jpg', '2013-07-12', '2013-07-12', '1', '0', '18', '');
INSERT INTO `store_products` VALUES ('39', '439', '1', '5', '24', 'God of War Original', 'God of War Original nuevo, original, por favor no comprar...', '932', '150', 'store/9b305304faf18538bdd298a8eadebbc6/8034f9d1a23191c56709046216886432.jpg', '2013-07-12', '2013-07-12', '1', '1', '30', '');
INSERT INTO `store_products` VALUES ('40', '6', '1', '1', '1', 'Cultura Profetica', 'Grupo de Reggae Cultura Profetica, de Puerto Rico', '1006', '4000', 'templates/9f2451877cdaff4a811c2c283c2b7164/7fdc1a630c238af0815181f9faa190f5.jpg', '2013-07-16', '2013-07-16', null, '0', '2', '');
INSERT INTO `store_products` VALUES ('41', '427', '1', '3', '20', 'sekirei', 'un manga muy bueno', '992', '100', 'store/7ba044ff1da7c91be37453143202e027/309bb9126cfb9d9015e599a87f413646.jpg', '2013-07-22', '2013-08-15', '1', '0', '15', '');
INSERT INTO `store_products` VALUES ('42', '58', '2', '6', '25', 'Kid Rock', 'Get Your Game On... <span style=\"color:rgb(56,118,29);\"><b style=\"color:rgb(56,118,29);\">Born Free</b></span>.. <br>', '0', '250', 'store/edc3eb56b556258033074e62d6473507/504bd7482a2907b87ca15927cd636ea7.jpg', '2013-07-29', '2013-12-12', '1', '0', '40', '');
INSERT INTO `store_products` VALUES ('43', '427', '1', '2', '17', 'LG 2.0', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', '4', '5', 'store/17e62166fc8586dfa4d1bc0e1742c08b/c4ca4238a0b923820dcc509a6f75849b.jpg', '2013-08-08', null, '1', null, '2', '');
INSERT INTO `store_products` VALUES ('44', '439', '2', '3', '21', 'condominio', '55555', '10', '5000', 'store/9b305304faf18538bdd298a8eadebbc6/388e69cc2ccf72d3362b356463cb1dfc.jpg', '2013-08-12', '2013-08-12', '1', '0', '6', '');
INSERT INTO `store_products` VALUES ('45', '427', '1', '3', '21', 'condominio', '333', '5', '5000', 'store/9b305304faf18538bdd298a8eadebbc6/388e69cc2ccf72d3362b356463cb1dfc.jpg', '2013-08-12', '2013-08-15', '1', '0', '13', '');
INSERT INTO `store_products` VALUES ('46', '427', '1', '3', '20', 'MiniMac', 'Whatever....', '10', '100000', 'store/d9d4f495e875a2e075a1a4a6e1b9770f/c4ca4238a0b923820dcc509a6f75849b.jpeg', '2013-08-12', null, '1', null, '7', '');
INSERT INTO `store_products` VALUES ('47', '437', '1', '3', '21', 'hp hp', '9999999999', '9', '55', 'store/7ba044ff1da7c91be37453143202e027/d8668a61df7f69743bfb211f20b6ab3c.jpg', '2013-08-16', '2013-08-16', '1', '1', '14', '');
INSERT INTO `store_products` VALUES ('48', '437', '2', '3', '21', 'hp 1', '1200', '0', '1', 'store/7ba044ff1da7c91be37453143202e027/d8668a61df7f69743bfb211f20b6ab3c.jpg', '2013-08-16', '2013-08-16', '1', '1', '7', '');
INSERT INTO `store_products` VALUES ('49', '439', '2', '2', '19', '22222', '5000', '5000', '50000', 'store/9b305304faf18538bdd298a8eadebbc6/d8668a61df7f69743bfb211f20b6ab3c.jpg', '2013-08-16', '2013-08-16', '1', '1', '1', '');
INSERT INTO `store_products` VALUES ('50', '439', '2', '2', '19', 'nokia logo', 'nokia logo', '0', '1', 'store/9b305304faf18538bdd298a8eadebbc6/c65391f6ec936429ae52dda4703a7d4f.jpg', '2013-08-19', '2013-08-19', '1', '0', '31', '');
INSERT INTO `store_products` VALUES ('51', '439', '2', '2', '19', 'otro logo nokia', '222222222222222222222', '0', '1', 'store/9b305304faf18538bdd298a8eadebbc6/c29bab59adc572d01d7ee922686b97fe.jpg', '2013-08-19', '2013-08-19', '1', '0', '5', '');
INSERT INTO `store_products` VALUES ('52', '439', '2', '2', '19', 'otro nokia mas', 'nokia', '0', '1', 'store/9b305304faf18538bdd298a8eadebbc6/c29bab59adc572d01d7ee922686b97fe.jpg', '2013-08-19', '2013-08-19', '1', '0', '4', '');
INSERT INTO `store_products` VALUES ('53', '439', '1', '2', '19', 'mi nuevo nokia', ' ', '13', '1', 'store/9b305304faf18538bdd298a8eadebbc6/c29bab59adc572d01d7ee922686b97fe.jpg', '2013-08-20', '2013-08-20', '1', '0', '20', '');
INSERT INTO `store_products` VALUES ('54', '58', '1', '7', '53', 'Ferrari', '<b>Pre-owned Ferraris guaranteed by Ferrari</b><br>Ferrari Approved is a pre-owned certification programme designed to guarantee maximum security and peace of mind to owners purchasing Ferraris registered within the last 9 years.<br>The programme encompasses a comprehensive series of controls and warranties issued by Maranello itself, including:<br><br>- A detailed technical inspection by Ferrari technicians<br>- Provenance and maintenance history verification<br>- Exterior and interior pre-sale preparation<br>- Up to 24 months Ferrari Warranty in Europe and 12 months in the rest of the world <br>- Up to 24 months Ferrari roadside assistance in Europe and 12 months in the rest of the world<br>', '1', '500000', 'store/edc3eb56b556258033074e62d6473507/9952e33ee47b80f4b5e7f829d3ebe37a.jpg', '2013-09-10', '2013-09-10', '1', '0', '13', '');
INSERT INTO `store_products` VALUES ('55', '374', '1', '6', '28', 'Reggae Style', 'Estilo Reggae, interpretando la musica...', '2', '100', 'store/3ddec16ec87ba077ceb26c5bf0d3bc2c/f81d5f3752f8cffd7d410f736e7c0461.jpg', '2013-09-12', '2014-01-15', '1', '0', '10', 'http://');
INSERT INTO `store_products` VALUES ('56', '374', '2', '6', '25', 'Paisajes', 'Bellos paisajes que ofrece Venezuela #pais', '0', '300', 'store/3ddec16ec87ba077ceb26c5bf0d3bc2c/6becc3605c51928d4376e4015d363903.jpg', '2013-09-12', '2014-01-17', '1', '0', '21', 'http://');
INSERT INTO `store_products` VALUES ('57', '58', '1', '7', '53', 'Honda Crosstour', 'Great Road Warrior for the men and women who like to dance on the road!!', '2', '500000', 'store/edc3eb56b556258033074e62d6473507/94e073199287db504f45c4e3de3ef7ec.jpg', '2013-09-17', '2013-09-17', '1', '0', '11', '');
INSERT INTO `store_products` VALUES ('58', '627', '1', '6', '25', 'Variadas', 'Fondos variados<br>', '42', '50', 'store/e5ab961d1cc6378bf0fd282379e0fc1f/6becc3605c51928d4376e4015d363903.jpg', '2013-09-18', '2013-09-18', '1', '0', '14', '');
INSERT INTO `store_products` VALUES ('59', '437', '2', '3', '20', 'stock', 'stock', '50', '100', 'store/7ba044ff1da7c91be37453143202e027/f9791199bcfc38c7dc9589b2de5c7eed.jpg', '2013-09-18', '2013-09-18', '1', '0', '0', '');
INSERT INTO `store_products` VALUES ('60', '437', '2', '6', '29', 'one piece', 'no hay nada para vender', '0', '100', 'store/7ba044ff1da7c91be37453143202e027/f9791199bcfc38c7dc9589b2de5c7eed.jpg', '2013-09-19', '2013-09-19', '1', '0', '2', '');
INSERT INTO `store_products` VALUES ('61', '437', '2', '7', '52', 'loaaaaaaaaaaaaa', 'RAMON ES UN LOCOTE <span style=\"font-size:24px;color:rgb(0,0,255);\"><i style=\"font-size:24px;color:rgb(0,0,255);\"><u style=\"font-size:24px;color:rgb(0,0,255);\"><b style=\"font-size: 24px; color: rgb(0, 0, 255);\"><span style=\"color:rgb(255,0,0);font-size: 24px;\"><br></span></b></u></i></span></p><p style=\"text-align: center;\"><span style=\"font-size:24px;color:rgb(0,0,255);\"><i style=\"font-size:24px;color:rgb(0,0,255);\"><u style=\"font-size:24px;color:rgb(0,0,255);\"><b style=\"font-size: 24px; color: rgb(0, 0, 255);\"><span style=\"font-size: 24px; color: rgb(0, 0, 255);\">es una ratada</span></b></u></i></span></p><p style=\"text-align: center;\"><span style=\"font-size:24px;color:rgb(0,0,255);\"><i style=\"font-size:24px;color:rgb(0,0,255);\"><u style=\"font-size:24px;color:rgb(0,0,255);\"><b style=\"font-size: 24px; color: rgb(0, 0, 255);\"><span style=\"font-size: 24px; color: rgb(0, 0, 255);\"><br></span></b></u></i></span></p><p style=\"text-align: center;\"><span style=\"font-size:24px;color:rgb(0,0,255);\"><i style=\"font-size:24px;color:rgb(0,0,255);\"><u style=\"font-size:24px;color:rgb(0,0,255);\"><b style=\"font-size: 24px; color: rgb(0, 0, 255);\"><span style=\"font-size: 24px; color: rgb(0, 0, 255);\"><br></span></b></u></i></span></p><p style=\"text-align: right;\"><span style=\"font-size:24px;color:rgb(0,0,255);\"><i style=\"font-size:24px;color:rgb(0,0,255);\"><u style=\"font-size:24px;color:rgb(0,0,255);\"><b style=\"font-size: 24px; color: rgb(0, 0, 255);\"><span style=\"color: rgb(0, 0, 255); font-size: 24px;\"><span style=\"font-size:16px;color: rgb(0, 0, 255);\">esto es muy malo</span></b></u></i></span></p>', '0', '5', 'store/7ba044ff1da7c91be37453143202e027/f99687dd719c4e8bc6a39e946c3d9ef7.jpg', '2013-09-19', '2013-09-19', '1', '0', '1', '');
INSERT INTO `store_products` VALUES ('62', '1', '2', '2', '19', 'Love', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', '0', '1234', 'store/4411a206fe0515494698b6e933bb179b/609f50e5a9c90e009b84354d33d1e56d.jpg', '2013-09-24', '2013-09-24', '1', '0', '2', '');
INSERT INTO `store_products` VALUES ('63', '1', '2', '2', '19', 'Wallpaper Apple', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', '0', '12', 'store/4411a206fe0515494698b6e933bb179b/d9300ae646d9eef8e05079c48c17931f.jpg', '2013-09-24', '2013-09-24', '1', '0', '3', '');
INSERT INTO `store_products` VALUES ('64', '437', '2', '3', '21', 'git hub', 'ramón bebe adrían, . \"ramon\" \'ramon\' pedro', '0', '50', 'store/7ba044ff1da7c91be37453143202e027/2c33efc16b9cb02b89628e2aca3d4d1f.jpg', '2013-09-26', '2013-09-26', '1', '0', '1', '');
INSERT INTO `store_products` VALUES ('65', '437', '2', '5', '24', 'pedrito', 'bebebebebenbebebeb ñññññññññññ áéíóú !¡ ¿? \"\" \'\' .. ,,', '0', '50', 'store/7ba044ff1da7c91be37453143202e027/dd962925d0351fc7085d732782bf0680.jpg', '2013-09-26', '2013-09-26', '1', '0', '1', '');
INSERT INTO `store_products` VALUES ('66', '437', '2', '3', '21', 'locura 3d', 'a  #queloco #loco #carrito', '0', '1000', 'store/7ba044ff1da7c91be37453143202e027/f99687dd719c4e8bc6a39e946c3d9ef7.jpg', '2013-09-30', '2013-09-30', '1', '0', '12', '');
INSERT INTO `store_products` VALUES ('67', '437', '2', '5', '24', 'carrito', '100 #carrito #loco', '0', '100', 'store/7ba044ff1da7c91be37453143202e027/f99687dd719c4e8bc6a39e946c3d9ef7.jpg', '2013-09-30', '2013-09-30', '1', '0', '9', '');
INSERT INTO `store_products` VALUES ('68', '433', '1', '2', '17', 'Iphone 5c', 'Apple Iphone 5c', '1', '350000', 'store/6e0cfddf56a8b612c8b6e4af7e27c5fe/29bc27360f4fed33ad206e4136718899.jpg', '2013-10-08', '2013-10-11', '1', '0', '31', '');
INSERT INTO `store_products` VALUES ('69', '433', '1', '2', '17', 'Iphone 5s', ' apple iphone 5s', '1', '800000', 'store/6e0cfddf56a8b612c8b6e4af7e27c5fe/29bc27360f4fed33ad206e4136718899.jpg', '2013-10-08', '2013-10-08', '1', '0', '11', '');
INSERT INTO `store_products` VALUES ('70', '437', '1', '3', '21', 'dragones', '222', '22', '2222222', 'store/7ba044ff1da7c91be37453143202e027/4c21174b863af98cc1f4f14bc87cda1a.jpg', '2013-10-24', '2013-10-24', '1', '0', '1', 'http://');
INSERT INTO `store_products` VALUES ('71', '439', '2', '2', '19', 'Prueba', 'testing', '0', '100', 'store/9b305304faf18538bdd298a8eadebbc6/a9a6982e2d2abac96ea451f6a5462ebd.jpg', '2013-10-24', '2013-10-24', '1', '0', '3', 'http://');
INSERT INTO `store_products` VALUES ('72', '437', '2', '3', '21', '1', '0', '0', '1', 'store/7ba044ff1da7c91be37453143202e027/0f5bb6eb8b5441062beb6a4c848e1527.jpg', '2013-10-25', '2013-10-25', '1', '0', '2', 'http://');
INSERT INTO `store_products` VALUES ('73', '437', '2', '5', '24', 'test', 'ola', '0', '100', 'store/7ba044ff1da7c91be37453143202e027/3e79c05e413e6be1c3e28694f82d5764.jpg', '2013-11-26', '2013-11-26', '1', '0', '0', 'http://');
INSERT INTO `store_products` VALUES ('74', '627', '2', '2', '19', 'rasta', 'rasta peluche', '0', '1000', 'store/e5ab961d1cc6378bf0fd282379e0fc1f/690f87840ab45f862ebec312e32887d6.jpg', '2013-12-04', '2013-12-04', '1', '0', '0', 'http://');
INSERT INTO `store_products` VALUES ('75', '58', '2', '6', '42', 'Sports Talk Radio Mark Rodgers Bobble Head', 'Get the new Mark Rodgers Fake, non-published <span style=\"color:rgb(0,255,0);\">Bobble Head</span> while supplies last.  <span style=\"color:rgb(255,0,0);\"><b style=\"color:rgb(255,0,0);\">Notice to public..</b></span> <u>Production was limited on this product.</u>  So limited in that zero were produced.', '0', '20', 'store/edc3eb56b556258033074e62d6473507/8f894302093084259d01b5d1972ce689.jpg', '2013-12-12', '2013-12-12', '1', '0', '3', 'http://');
INSERT INTO `store_products` VALUES ('76', '58', '2', '6', '42', 'JR\'s Beef Jerky!', '<font face=\"Lucida Grande, Lucida, Verdana, sans-serif\"><span style=\"line-height: 22px;\">It </span></font><span style=\"line-height: 22px; color: rgb(51, 51, 51); \">doesn\'t matter what it is.. <b style=\"line-height: 22px; color: rgb(51, 51, 51); \"><span style=\"color:rgb(106,168,79);line-height: 22px; \">Triple Threat Teriyaki</span></b>, <span style=\"color:rgb(166,77,121);line-height: 22px; \"><b style=\"color:rgb(166,77,121);line-height: 22px; \">Pepper Power Slam</b></span>, <span style=\"color:rgb(255,0,0);line-height: 22px; \"><b style=\"color:rgb(255,0,0);line-height: 22px; \">Slobber Knocker Hot</b></span> or <span style=\"color:rgb(0,0,255);line-height: 22px; \"><b style=\"color:rgb(0,0,255);line-height: 22px; \">Mexicana Style</b></span>..  Good Ol\' JR has the <u style=\"line-height: 22px; color: rgb(51, 51, 51); \">Beef Jerky</u> for you!</span>', '0', '250', 'store/edc3eb56b556258033074e62d6473507/bbbd44753b452feb9b79e411371ed5c5.jpg', '2013-12-19', '2013-12-19', '1', '0', '5', '');
INSERT INTO `store_products` VALUES ('77', '58', '1', '6', '42', 'BBQ SAUCE', '<span style=\"color: rgb(0, 0, 0); font-size: 16px; \"><span style=\"color: rgb(0, 0, 0); font-size: 16px; \"><b style=\"color: rgb(0, 0, 0); \"><span style=\"color:rgb(11,83,148);\">\"Stone Cold\"</span> </b><span style=\"color: rgb(0, 0, 0); font-size: 16px; \"><span style=\"font-size: 12px; color: rgb(0, 0, 0); \">Steve Austin and Terry</span><b style=\"color: rgb(0, 0, 0); \"> <span style=\"font-size:12px;color: rgb(0, 0, 0); \">Lawler is not the guy\'s you want knocking at your door!</span><span style=\"color: rgb(0, 0, 0); font-size: 14px; \"><span style=\"font-size:12px;color: rgb(0, 0, 0); \">JR\'s BBQ Sauce is the only sauce to be thrown down!</span></div>', '9', '250', 'store/edc3eb56b556258033074e62d6473507/4aa395c0c282f092c8a232f4db7f55b8.jpg', '2013-12-19', '2013-12-19', '1', '0', '10', 'http://');
INSERT INTO `store_products` VALUES ('78', '438', '2', '25', '47', 'sensual woman', 'test', '0', '5000', 'store/97521eaf894417053b73316e60b66c7a/c39029c5f5b098823d7287574034feb0.jpg', '2014-01-14', '2014-01-14', '1', '0', '0', 'http://vimeo.com/78265513');
INSERT INTO `store_products` VALUES ('79', '435', '2', '2', '19', 'sha', 'sha', '0', '5000', 'store/dee6f90d13fa944969f1c83770a22561/c39029c5f5b098823d7287574034feb0.jpg', '2014-01-15', '2014-01-15', '1', '0', '0', 'http://vimeo.com/16915864');
INSERT INTO `store_products` VALUES ('80', '374', '2', '2', '19', 'Coala', 'coala', '0', '100', 'store/3ddec16ec87ba077ceb26c5bf0d3bc2c/c270eb7dd0e8b6b2e46e7b8efb3a1362.jpg', '2014-01-17', '2014-01-17', '1', '0', '0', 'http://');
INSERT INTO `store_products` VALUES ('81', '435', '2', '7', '52', 'caballo negro blanco y dalmata', '<p>caballos listo para carrera,</p><p>envió por MRW</p><p>no endosable</p><p>envuelto en papel aluminio</p>#dalmata', '0', '9999999', 'store/dee6f90d13fa944969f1c83770a22561/47a5e85260f93d7049819bd7f496da8e.jpg', '2014-01-22', '2014-01-22', '1', '0', '0', 'http://');
INSERT INTO `store_products` VALUES ('82', '58', '2', '7', '54', 'KIA REO SPORT', '<b><span style=\"color:rgb(61,133,198);\">2014 Kia Rio</span></b> Special Financing Available: <span style=\"color:rgb(255,0,0);\">APR AS LOW AS 1.9%</span> OR REBATES AS HIGH AS $500.. This is the vehicle for you if you\'re looking to get great gas mileage on your way to work*** $ $ $ $ $ I knew that would get your attention!!! Now that I have it, let me tell you a little bit about this outstanding Rio that is currently priced right.. A real head turner!!! It has nice optional equipment like: Convenience Package, EC Mirror w/Compass &amp; Homelink, Carpet Floor Mat, Wheel Locks... **Dealer Discount may include additional rebates for which not all customers may qualify.  (Kia Owner Loyalty/Competitive, Military, &amp; College Grad). Discount does include Bob Moore Kia NW Loyalty Incentive of $500.  Previous Kia NW vehicle must be traded in to receive extra $500 incentive.', '0', '250000', 'store/edc3eb56b556258033074e62d6473507/192b0b19643df684812800a4d00df64b.jpg', '2014-02-06', '2014-02-06', '1', '0', '8', 'http://youtu.be/gLuPiLdgRiY');
INSERT INTO `store_products` VALUES ('83', '435', '2', '25', '47', 'mujer dibujo', '#<span style=\"color: rgb(0, 0, 0); font-family: \'Helvetica Neue\', Helvetica, Arial, san-serif; font-size: 13px; line-height: 16.25px;\">Hola,este-tipo-de-pruebas-son-proyectivas.</span><span style=\"color: rgb(0, 0, 0); font-family: \'Helvetica Neue\', Helvetica, Arial, san-serif; font-size: 13px; line-height: 16.25px;\">Por-medio-de-dibujos,-historias-y-asociaciones-evalúan-la-personalidad-consciente-e-inconsciente-de-las-personas.-Hay-muchos-criterios-para-calificarlos:-desde-como-trazas,-por-donde-empiezas-a-dibujar-etc...</span>', '0', '9000000', 'store/dee6f90d13fa944969f1c83770a22561/98679fdb5f4ae8b7136a7d0b76bc5394.jpg', '2014-02-11', '2014-02-11', '1', '0', '0', 'http://');
INSERT INTO `store_products` VALUES ('84', '58', '2', '6', '25', 'Elvis Party', 'Today is the Elvis Birthday Party... Are you joining Elvis and friends?', '0', '1', 'store/edc3eb56b556258033074e62d6473507/3f109c8a392fb2c3b198aefe15d6f31a.jpg', '2014-03-02', '2014-03-02', '1', '0', '2', 'http://youtu.be/WYJKm6JB-nk');
INSERT INTO `store_products` VALUES ('85', '435', '1', '2', '17', 'iphone used', 'iphone used good stat', '2', '6890', 'store/dee6f90d13fa944969f1c83770a22561/fe5df232cafa4c4e0f1a0294418e5660.jpg', '2014-07-23', '2014-07-23', '1', '0', '3', 'http://');
INSERT INTO `store_products` VALUES ('86', '435', '1', '7', '52', 'scrap car', 'car in bad state', '3', '1000', 'store/dee6f90d13fa944969f1c83770a22561/9414a8f5b810972c3c9a0e2860c07532.jpg', '2014-07-23', '2014-07-23', '1', '0', '3', 'http://');
INSERT INTO `store_products` VALUES ('87', '435', '1', '2', '17', 'super iphone', 'the super and best iphone', '5', '90000', 'store/dee6f90d13fa944969f1c83770a22561/d0096ec6c83575373e3a21d129ff8fef.jpg', '2014-07-23', '2014-07-23', '1', '0', '2', 'http://');
INSERT INTO `store_products` VALUES ('88', '435', '1', '2', '18', 'iphone', 'iphone', '9000', '9000000', 'store/dee6f90d13fa944969f1c83770a22561/fe5df232cafa4c4e0f1a0294418e5660.jpg', '2014-07-23', '2014-07-23', '1', '0', '6', 'http://');
INSERT INTO `store_products` VALUES ('89', '386', '1', '6', '39', 'Rasta Gallery', 'Rasta gallery', '98', '100', 'store/0d631032b9e751accbd6b85aa848b2bc/ba6067bdbc8daa579310089ff29f274f.jpg', '2014-07-28', '2014-07-28', '1', '0', '16', 'http://');
INSERT INTO `store_products` VALUES ('90', '386', '2', '6', '39', 'German helmet', '<span class=\"Apple-style-span\" style=\"font-family: Arial, sans-serif; font-size: 13px; line-height: 19px; \"><ul class=\"a-vertical a-spacing-none\" style=\"box-sizing: border-box; margin-top: 0px; margin-right: 0px; margin-bottom: 0px !important; margin-left: 18px; color: rgb(170, 170, 170); padding-top: 0px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px; \"><li style=\"box-sizing: border-box; list-style-type: disc; list-style-position: initial; list-style-image: initial; word-wrap: break-word; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; \"><span class=\"a-list-item\" style=\"box-sizing: border-box; color: rgb(51, 51, 51); \">XL Helmet Inside Circumference: 23 1/4 - 24 inches (60-61 cm)</span></li><li style=\"box-sizing: border-box; list-style-type: disc; list-style-position: initial; list-style-image: initial; word-wrap: break-word; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; \"><span class=\"a-list-item\" style=\"box-sizing: border-box; color: rgb(51, 51, 51); \">Stainless Steel Dual D-Rings</span></li><li style=\"box-sizing: border-box; list-style-type: disc; list-style-position: initial; list-style-image: initial; word-wrap: break-word; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; \"><span class=\"a-list-item\" style=\"box-sizing: border-box; color: rgb(51, 51, 51); \">USA safety approval DOT FMVSS218 standard</span></li><li style=\"box-sizing: border-box; list-style-type: disc; list-style-position: initial; list-style-image: initial; word-wrap: break-word; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; \"><span class=\"a-list-item\" style=\"box-sizing: border-box; color: rgb(51, 51, 51); \">Polycarbonate shell</span></li></ul></span>', '0', '100', 'store/0d631032b9e751accbd6b85aa848b2bc/3697951f0ef8d672d90a0d80b8cbecef.jpg', '2014-07-29', '2014-07-29', '1', '0', '11', 'http://');

-- ----------------------------
-- Table structure for `store_products_picture`
-- ----------------------------
DROP TABLE IF EXISTS `store_products_picture`;
CREATE TABLE `store_products_picture` (
  `id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of store_products_picture
-- ----------------------------
INSERT INTO `store_products_picture` VALUES ('1', '1', 'store/7ba044ff1da7c91be37453143202e027/322b66fbdd4c6683a98239d1133c5181.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '1', 'store/7ba044ff1da7c91be37453143202e027/f666bd9129ea5d7c1e32254e7843eac0.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '1', 'store/7ba044ff1da7c91be37453143202e027/c333c2b445eb8c605875cdc0605f7978.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('1', '2', 'store/4411a206fe0515494698b6e933bb179b/e503fc8639127fbb7b93c81ad1e7d4c4.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '2', 'store/4411a206fe0515494698b6e933bb179b/51ec1d3cd8c5d4d2bc4f552ea6c9a396.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '2', 'store/4411a206fe0515494698b6e933bb179b/e0205fb706a70296101685e8e22a99ae.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '2', 'store/4411a206fe0515494698b6e933bb179b/9a2d14d4dd5f03d1996f297955cd740b.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('1', '4', 'store/a87ff679a2f3e71d9181a67b7542122c/c4ca4238a0b923820dcc509a6f75849b.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '4', 'store/a87ff679a2f3e71d9181a67b7542122c/c81e728d9d4c2f636f067f89cc14862c.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '4', 'store/a87ff679a2f3e71d9181a67b7542122c/eccbc87e4b5ce2fe28308fd9f2a7baf3.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '4', 'store/a87ff679a2f3e71d9181a67b7542122c/a87ff679a2f3e71d9181a67b7542122c.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '4', 'store/a87ff679a2f3e71d9181a67b7542122c/ae7779f11825a76bde62c058122875f9.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '24', 'store/7ba044ff1da7c91be37453143202e027/96dda289f59b9c3b1f62f863f32c17bd.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '24', 'store/7ba044ff1da7c91be37453143202e027/228a703723ed8c1c1f33540c00621602.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '24', 'store/7ba044ff1da7c91be37453143202e027/7b9725cd2f6345346372c9905c2b6a14.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '24', 'store/7ba044ff1da7c91be37453143202e027/2932626b96f98e8f072e75f54c81dfd7.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '24', 'store/7ba044ff1da7c91be37453143202e027/41032a8d4b0131f689656f7a14059a9c.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '28', 'store/7ba044ff1da7c91be37453143202e027/2be29dc100c9235594ced7b32692e227.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '28', 'store/7ba044ff1da7c91be37453143202e027/c6e0574cc7ff3a858f415b4c22cc06ad.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '28', 'store/7ba044ff1da7c91be37453143202e027/da37444602bd03b0ce783e54b93d3b1c.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('5', '28', 'store/7ba044ff1da7c91be37453143202e027/eccea9d829ad72df02bada6d720a6c39.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '29', 'store/4411a206fe0515494698b6e933bb179b/ff813b8d83af4509037f452c7a4210c3.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '29', 'store/4411a206fe0515494698b6e933bb179b/d9300ae646d9eef8e05079c48c17931f.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '29', 'store/4411a206fe0515494698b6e933bb179b/a8446c5ad77470530b324887644f605e.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '29', 'store/4411a206fe0515494698b6e933bb179b/10283575c27b8c087a584ad09e6864f2.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '29', 'store/4411a206fe0515494698b6e933bb179b/68b2eb07b7668601d9dcfd304091dd8a.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '30', 'store/7ba044ff1da7c91be37453143202e027/c1137649f9fb16425664505933a7d8c3.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '30', 'store/7ba044ff1da7c91be37453143202e027/8ffa64391e7480646b231d647de6edbc.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '30', 'store/7ba044ff1da7c91be37453143202e027/b94a60cc8de2210d058c01cd514cc4f0.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('1', '32', 'store/7ba044ff1da7c91be37453143202e027/bc5c4e330cd1c7ef91e8afdfcb1f49fc.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '33', 'store/7ba044ff1da7c91be37453143202e027/17ba8e5a3fbf30abd3a5d6c0027c07f1.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('3', '33', 'store/7ba044ff1da7c91be37453143202e027/fea8e8b388759d4b6b24a67f346545b0.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('5', '33', 'store/7ba044ff1da7c91be37453143202e027/cc149edcd5bc15c9cf9f3fbddcdc36df.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '34', 'store/9b305304faf18538bdd298a8eadebbc6/cc149edcd5bc15c9cf9f3fbddcdc36df.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('5', '34', 'store/9b305304faf18538bdd298a8eadebbc6/fea8e8b388759d4b6b24a67f346545b0.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('2', '35', 'store/7ba044ff1da7c91be37453143202e027/61c05fdfc21378a0b853606cf0187466.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '36', 'store/7ba044ff1da7c91be37453143202e027/ba92135f38e16474348607c72f6ebf91.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('5', '36', 'store/7ba044ff1da7c91be37453143202e027/72856b8bef4c6a22bb9d28381b026250.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '37', 'store/9b305304faf18538bdd298a8eadebbc6/83ed903e6a8c9b4868b51c7959db07ce.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('3', '37', 'store/9b305304faf18538bdd298a8eadebbc6/e75c44f357f6b89633d5d5b799584736.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('5', '37', 'store/9b305304faf18538bdd298a8eadebbc6/fce7f66ef3088cf536636dcc2a14b3ef.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '38', 'store/9b305304faf18538bdd298a8eadebbc6/4b4131536c04bd2ef54b0801b6f9be83.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('3', '38', 'store/9b305304faf18538bdd298a8eadebbc6/4b4131536c04bd2ef54b0801b6f9be83.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '38', 'store/9b305304faf18538bdd298a8eadebbc6/b9cb91a995e50a8b354c80468b0e3fb6.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '38', 'store/9b305304faf18538bdd298a8eadebbc6/f3354753de65500243311418432b0d2d.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '39', 'store/9b305304faf18538bdd298a8eadebbc6/8034f9d1a23191c56709046216886432.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '39', 'store/9b305304faf18538bdd298a8eadebbc6/31c211311c97245e7bb535a505534efb.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '39', 'store/9b305304faf18538bdd298a8eadebbc6/1ce872d3041c7ac67746aadced45ecad.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '39', 'store/9b305304faf18538bdd298a8eadebbc6/8fabb5638e1a1263606f69c806e8ede2.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('1', '41', 'store/7ba044ff1da7c91be37453143202e027/309bb9126cfb9d9015e599a87f413646.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '42', 'store/edc3eb56b556258033074e62d6473507/504bd7482a2907b87ca15927cd636ea7.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '42', 'store/edc3eb56b556258033074e62d6473507/68d5535b971d558f594f10a5affd0a71.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '42', 'store/edc3eb56b556258033074e62d6473507/4ca4716db1786bf2ea953f5dfc8e91b1.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '42', 'store/edc3eb56b556258033074e62d6473507/73aa8942061834aae498e253324c8a67.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '42', 'store/edc3eb56b556258033074e62d6473507/1167dfeb58e648408f875230e7617e4f.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '43', 'store/17e62166fc8586dfa4d1bc0e1742c08b/c4ca4238a0b923820dcc509a6f75849b.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '43', 'store/17e62166fc8586dfa4d1bc0e1742c08b/c81e728d9d4c2f636f067f89cc14862c.png', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '44', 'store/9b305304faf18538bdd298a8eadebbc6/388e69cc2ccf72d3362b356463cb1dfc.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('5', '44', 'store/9b305304faf18538bdd298a8eadebbc6/388e69cc2ccf72d3362b356463cb1dfc.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '45', 'store/9b305304faf18538bdd298a8eadebbc6/388e69cc2ccf72d3362b356463cb1dfc.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('5', '45', 'store/9b305304faf18538bdd298a8eadebbc6/388e69cc2ccf72d3362b356463cb1dfc.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '46', 'store/d9d4f495e875a2e075a1a4a6e1b9770f/c4ca4238a0b923820dcc509a6f75849b.jpeg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '46', 'store/d9d4f495e875a2e075a1a4a6e1b9770f/c81e728d9d4c2f636f067f89cc14862c.jpeg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '47', 'store/7ba044ff1da7c91be37453143202e027/d8668a61df7f69743bfb211f20b6ab3c.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('3', '47', 'store/7ba044ff1da7c91be37453143202e027/5dfb22663a5aa382226d7b93880b3c22.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('1', '48', 'store/7ba044ff1da7c91be37453143202e027/d8668a61df7f69743bfb211f20b6ab3c.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '49', 'store/9b305304faf18538bdd298a8eadebbc6/d8668a61df7f69743bfb211f20b6ab3c.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '50', 'store/9b305304faf18538bdd298a8eadebbc6/c65391f6ec936429ae52dda4703a7d4f.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('3', '50', 'store/9b305304faf18538bdd298a8eadebbc6/4a7d8a6a9c877601051416f52ff5341e.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('5', '50', 'store/9b305304faf18538bdd298a8eadebbc6/a5b3ecdd3e183ccab13f2c33d7040144.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '51', 'store/9b305304faf18538bdd298a8eadebbc6/c29bab59adc572d01d7ee922686b97fe.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('3', '51', 'store/9b305304faf18538bdd298a8eadebbc6/a5b3ecdd3e183ccab13f2c33d7040144.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('5', '51', 'store/9b305304faf18538bdd298a8eadebbc6/8ce60b69e6b73bd981d75f1fa365e463.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '52', 'store/9b305304faf18538bdd298a8eadebbc6/c29bab59adc572d01d7ee922686b97fe.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('3', '52', 'store/9b305304faf18538bdd298a8eadebbc6/8ce60b69e6b73bd981d75f1fa365e463.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('5', '52', 'store/9b305304faf18538bdd298a8eadebbc6/a5b3ecdd3e183ccab13f2c33d7040144.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '53', 'store/9b305304faf18538bdd298a8eadebbc6/c29bab59adc572d01d7ee922686b97fe.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('3', '53', 'store/9b305304faf18538bdd298a8eadebbc6/a5b3ecdd3e183ccab13f2c33d7040144.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('5', '53', 'store/9b305304faf18538bdd298a8eadebbc6/8ce60b69e6b73bd981d75f1fa365e463.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '54', 'store/edc3eb56b556258033074e62d6473507/9952e33ee47b80f4b5e7f829d3ebe37a.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '54', 'store/edc3eb56b556258033074e62d6473507/4527dc2e63f9f3b07f50d2d5c7966f23.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '54', 'store/edc3eb56b556258033074e62d6473507/279d664f26d6f18276a46cd0939073b4.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '54', 'store/edc3eb56b556258033074e62d6473507/a7d4b9e4074412ff6ccaa8d41c0dbcfe.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '54', 'store/edc3eb56b556258033074e62d6473507/34ab31da9e6ca91110f1c3892aa86082.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '55', 'store/3ddec16ec87ba077ceb26c5bf0d3bc2c/f81d5f3752f8cffd7d410f736e7c0461.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '56', 'store/3ddec16ec87ba077ceb26c5bf0d3bc2c/6becc3605c51928d4376e4015d363903.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '56', 'store/3ddec16ec87ba077ceb26c5bf0d3bc2c/9d8430324cfde043f8625d57fe95d936.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '56', 'store/3ddec16ec87ba077ceb26c5bf0d3bc2c/adc4c478809c412dea96e177997ca01b.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '56', 'store/3ddec16ec87ba077ceb26c5bf0d3bc2c/8ba286db76d0d8b80d3330125482d54d.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('1', '57', 'store/edc3eb56b556258033074e62d6473507/94e073199287db504f45c4e3de3ef7ec.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '57', 'store/edc3eb56b556258033074e62d6473507/2b728b87ea51e724b175bdf18c6f02ed.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '58', 'store/e5ab961d1cc6378bf0fd282379e0fc1f/6becc3605c51928d4376e4015d363903.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '58', 'store/e5ab961d1cc6378bf0fd282379e0fc1f/da9e78f180de1500ba2fee872f6528da.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '58', 'store/e5ab961d1cc6378bf0fd282379e0fc1f/d95318c3fbabc20442475fc837e9ce28.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('1', '59', 'store/7ba044ff1da7c91be37453143202e027/f9791199bcfc38c7dc9589b2de5c7eed.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '60', 'store/7ba044ff1da7c91be37453143202e027/f9791199bcfc38c7dc9589b2de5c7eed.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '61', 'store/7ba044ff1da7c91be37453143202e027/f99687dd719c4e8bc6a39e946c3d9ef7.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '62', 'store/4411a206fe0515494698b6e933bb179b/609f50e5a9c90e009b84354d33d1e56d.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '63', 'store/4411a206fe0515494698b6e933bb179b/d9300ae646d9eef8e05079c48c17931f.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '63', 'store/4411a206fe0515494698b6e933bb179b/9e367ea862f22cbecdfc4329230f1ed4.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '64', 'store/7ba044ff1da7c91be37453143202e027/2c33efc16b9cb02b89628e2aca3d4d1f.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '65', 'store/7ba044ff1da7c91be37453143202e027/dd962925d0351fc7085d732782bf0680.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '66', 'store/7ba044ff1da7c91be37453143202e027/f99687dd719c4e8bc6a39e946c3d9ef7.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '67', 'store/7ba044ff1da7c91be37453143202e027/f99687dd719c4e8bc6a39e946c3d9ef7.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '68', 'store/6e0cfddf56a8b612c8b6e4af7e27c5fe/29bc27360f4fed33ad206e4136718899.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '69', 'store/6e0cfddf56a8b612c8b6e4af7e27c5fe/29bc27360f4fed33ad206e4136718899.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '70', 'store/7ba044ff1da7c91be37453143202e027/4c21174b863af98cc1f4f14bc87cda1a.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('5', '70', 'store/7ba044ff1da7c91be37453143202e027/355f0c0af5d2dc22586a6c8cfe43ffbe.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '71', 'store/9b305304faf18538bdd298a8eadebbc6/a9a6982e2d2abac96ea451f6a5462ebd.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '71', 'store/9b305304faf18538bdd298a8eadebbc6/d805f89a28fc3374fcfc08b5c1e64102.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '72', 'store/7ba044ff1da7c91be37453143202e027/0f5bb6eb8b5441062beb6a4c848e1527.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '72', 'store/7ba044ff1da7c91be37453143202e027/9cde1b9da77d5f59e5b0c648f54f18bb.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '73', 'store/7ba044ff1da7c91be37453143202e027/3e79c05e413e6be1c3e28694f82d5764.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '74', 'store/e5ab961d1cc6378bf0fd282379e0fc1f/690f87840ab45f862ebec312e32887d6.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '74', 'store/e5ab961d1cc6378bf0fd282379e0fc1f/588abfde4837f335a0995a8c518daaf9.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '75', 'store/edc3eb56b556258033074e62d6473507/8f894302093084259d01b5d1972ce689.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '75', 'store/edc3eb56b556258033074e62d6473507/50a56b38eb2e1b76bf0cb639fd341598.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '75', 'store/edc3eb56b556258033074e62d6473507/39b4bc5cbf3fa72fd430d4abe6a9615a.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '75', 'store/edc3eb56b556258033074e62d6473507/78432728aee65cbb49ab27bea9f7a67a.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '75', 'store/edc3eb56b556258033074e62d6473507/f9d559181aa3b235f985355609ba7738.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '76', 'store/edc3eb56b556258033074e62d6473507/bbbd44753b452feb9b79e411371ed5c5.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '76', 'store/edc3eb56b556258033074e62d6473507/e08629553ba326df3b0440d9d53f9b27.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '76', 'store/edc3eb56b556258033074e62d6473507/5d5c6a84792225377b2dead06653ec71.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '76', 'store/edc3eb56b556258033074e62d6473507/f6c17c5b571dfb4b2638bc52e70957c3.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '76', 'store/edc3eb56b556258033074e62d6473507/801104462db3441698bee955dbd3765c.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '77', 'store/edc3eb56b556258033074e62d6473507/4aa395c0c282f092c8a232f4db7f55b8.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '77', 'store/edc3eb56b556258033074e62d6473507/4166a1768db2390bf1dc6c22915cab1f.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '77', 'store/edc3eb56b556258033074e62d6473507/0a71dcbedf78becab2b5b56e324add5f.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '77', 'store/edc3eb56b556258033074e62d6473507/c294491dd732fda2ba35b11afa18a0a0.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '77', 'store/edc3eb56b556258033074e62d6473507/635842f523db72b0d9d496b1d82520a2.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('2', '78', 'store/97521eaf894417053b73316e60b66c7a/c39029c5f5b098823d7287574034feb0.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '79', 'store/dee6f90d13fa944969f1c83770a22561/c39029c5f5b098823d7287574034feb0.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '80', 'store/3ddec16ec87ba077ceb26c5bf0d3bc2c/c270eb7dd0e8b6b2e46e7b8efb3a1362.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '81', 'store/dee6f90d13fa944969f1c83770a22561/47a5e85260f93d7049819bd7f496da8e.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '81', 'store/dee6f90d13fa944969f1c83770a22561/7fdc1a630c238af0815181f9faa190f5.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '81', 'store/dee6f90d13fa944969f1c83770a22561/b75d888cfeaf16b263bda31c0dfbb6eb.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('1', '82', 'store/edc3eb56b556258033074e62d6473507/192b0b19643df684812800a4d00df64b.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '82', 'store/edc3eb56b556258033074e62d6473507/7bbc28cf07047b5dcdc1595e59ae804b.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '82', 'store/edc3eb56b556258033074e62d6473507/3c31cf35369e3d06ed9d92cff6452927.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('2', '83', 'store/dee6f90d13fa944969f1c83770a22561/98679fdb5f4ae8b7136a7d0b76bc5394.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('1', '84', 'store/edc3eb56b556258033074e62d6473507/3f109c8a392fb2c3b198aefe15d6f31a.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '84', 'store/edc3eb56b556258033074e62d6473507/cbca16eb50329c69a5cd62a379feb236.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '84', 'store/edc3eb56b556258033074e62d6473507/dd4ad02510c7429edd75d1edcaf45660.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '84', 'store/edc3eb56b556258033074e62d6473507/4c0341189fb5baf8c137a4eb35194248.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '84', 'store/edc3eb56b556258033074e62d6473507/7cafff4b0d04f2c268d6f1536845e1b9.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '85', 'store/dee6f90d13fa944969f1c83770a22561/fe5df232cafa4c4e0f1a0294418e5660.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('5', '85', 'store/dee6f90d13fa944969f1c83770a22561/d0096ec6c83575373e3a21d129ff8fef.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '86', 'store/dee6f90d13fa944969f1c83770a22561/9414a8f5b810972c3c9a0e2860c07532.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '86', 'store/dee6f90d13fa944969f1c83770a22561/edab7ba7e203cd7576d1200465194ea8.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('5', '86', 'store/dee6f90d13fa944969f1c83770a22561/db3a17f7bcac837ecc1fe2bc630a5473.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('3', '87', 'store/dee6f90d13fa944969f1c83770a22561/d0096ec6c83575373e3a21d129ff8fef.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('1', '88', 'store/dee6f90d13fa944969f1c83770a22561/fe5df232cafa4c4e0f1a0294418e5660.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('1', '0', 'store/edc3eb56b556258033074e62d6473507/4527dc2e63f9f3b07f50d2d5c7966f23.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '0', 'store/edc3eb56b556258033074e62d6473507/820b846ff5f34b2902e4e827f31da5b8.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '0', 'store/edc3eb56b556258033074e62d6473507/34ab31da9e6ca91110f1c3892aa86082.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '0', 'store/edc3eb56b556258033074e62d6473507/279d664f26d6f18276a46cd0939073b4.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('5', '0', 'store/edc3eb56b556258033074e62d6473507/9952e33ee47b80f4b5e7f829d3ebe37a.jpg', '5', '1');
INSERT INTO `store_products_picture` VALUES ('1', '89', 'store/0d631032b9e751accbd6b85aa848b2bc/ba6067bdbc8daa579310089ff29f274f.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '89', 'store/0d631032b9e751accbd6b85aa848b2bc/86d2b1287329c459bd2cb9e52ca69c57.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '89', 'store/0d631032b9e751accbd6b85aa848b2bc/1e677244362a9af8d84d3ebab40f6ab1.jpg', '3', '1');
INSERT INTO `store_products_picture` VALUES ('4', '89', 'store/0d631032b9e751accbd6b85aa848b2bc/a82765930fe1110311c8ae4c5c26bf65.jpg', '4', '1');
INSERT INTO `store_products_picture` VALUES ('1', '90', 'store/0d631032b9e751accbd6b85aa848b2bc/3697951f0ef8d672d90a0d80b8cbecef.jpg', '1', '1');
INSERT INTO `store_products_picture` VALUES ('2', '90', 'store/0d631032b9e751accbd6b85aa848b2bc/656ac00fc7029a9c0f82df108714e1a1.jpg', '2', '1');
INSERT INTO `store_products_picture` VALUES ('3', '90', 'store/0d631032b9e751accbd6b85aa848b2bc/ee1035a7fef5f028934ac1c435749cc7.jpg', '3', '1');

-- ----------------------------
-- Table structure for `store_raffle`
-- ----------------------------
DROP TABLE IF EXISTS `store_raffle`;
CREATE TABLE `store_raffle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `cant_users` int(11) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` date DEFAULT NULL,
  `status` int(11) NOT NULL,
  `winner` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_raffle
-- ----------------------------
INSERT INTO `store_raffle` VALUES ('18', '13', '6', '100', '3', '2013-05-31 07:06:49', '2013-06-14', '2', null);
INSERT INTO `store_raffle` VALUES ('19', '9', '1', '12', '2', '2013-05-31 07:08:19', '2013-06-12', '2', null);
INSERT INTO `store_raffle` VALUES ('23', '2', '6', '15', '3', '2013-06-03 09:04:17', '2013-06-03', '2', null);
INSERT INTO `store_raffle` VALUES ('24', '29', '1', '12', '56', '2013-06-18 02:02:43', null, '1', null);
INSERT INTO `store_raffle` VALUES ('25', '24', '437', '30', '3', '2013-06-25 01:16:40', '2013-06-25', '2', null);
INSERT INTO `store_raffle` VALUES ('26', '31', '435', '100', '1', '2013-06-28 07:45:19', '2013-06-28', '2', null);
INSERT INTO `store_raffle` VALUES ('27', '34', '439', '500', '500', '2013-08-22 08:10:29', null, '1', null);

-- ----------------------------
-- Table structure for `store_raffle_join`
-- ----------------------------
DROP TABLE IF EXISTS `store_raffle_join`;
CREATE TABLE `store_raffle_join` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_raffle` int(11) NOT NULL,
  `date_join` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_raffle_join
-- ----------------------------
INSERT INTO `store_raffle_join` VALUES ('1', '386', '23', '2013-06-03 09:04:57');
INSERT INTO `store_raffle_join` VALUES ('2', '157', '23', '2013-06-03 09:07:05');
INSERT INTO `store_raffle_join` VALUES ('3', '2', '23', '2013-06-03 09:07:51');
INSERT INTO `store_raffle_join` VALUES ('4', '16', '18', '2013-06-04 08:09:50');
INSERT INTO `store_raffle_join` VALUES ('5', '16', '19', '2013-06-04 09:41:04');
INSERT INTO `store_raffle_join` VALUES ('6', '58', '19', '2013-06-12 03:22:03');
INSERT INTO `store_raffle_join` VALUES ('7', '58', '18', '2013-06-12 04:38:37');
INSERT INTO `store_raffle_join` VALUES ('8', '16', '18', '2013-06-14 08:56:39');
INSERT INTO `store_raffle_join` VALUES ('9', '58', '24', '2013-06-19 04:22:51');
INSERT INTO `store_raffle_join` VALUES ('10', '495', '24', '2013-06-20 04:53:18');
INSERT INTO `store_raffle_join` VALUES ('11', '435', '25', '2013-06-25 01:18:47');
INSERT INTO `store_raffle_join` VALUES ('12', '439', '25', '2013-06-25 01:24:30');
INSERT INTO `store_raffle_join` VALUES ('13', '6', '25', '2013-06-25 01:27:03');
INSERT INTO `store_raffle_join` VALUES ('14', '437', '26', '2013-06-28 07:45:42');
INSERT INTO `store_raffle_join` VALUES ('15', '16', '24', '2013-06-28 12:37:16');
INSERT INTO `store_raffle_join` VALUES ('16', '439', '24', '2013-08-14 08:08:31');
INSERT INTO `store_raffle_join` VALUES ('17', '2', '24', '2013-09-16 04:35:27');
INSERT INTO `store_raffle_join` VALUES ('18', '437', '24', '2013-09-18 08:52:33');
INSERT INTO `store_raffle_join` VALUES ('19', '437', '27', '2013-09-18 09:00:43');
INSERT INTO `store_raffle_join` VALUES ('20', '435', '27', '2013-09-19 01:29:13');
INSERT INTO `store_raffle_join` VALUES ('21', '16', '27', '2014-02-24 05:07:45');
INSERT INTO `store_raffle_join` VALUES ('22', '1', '27', '2014-07-17 16:49:02');

-- ----------------------------
-- Table structure for `store_sub_category`
-- ----------------------------
DROP TABLE IF EXISTS `store_sub_category`;
CREATE TABLE `store_sub_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_status` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `id_template` int(11) DEFAULT NULL,
  `name` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_sub_category
-- ----------------------------
INSERT INTO `store_sub_category` VALUES ('1', '1', '1', '1069', 'STORE_SUBCATEGORY_ALLBG');
INSERT INTO `store_sub_category` VALUES ('17', '1', '2', '1094', 'STORE_SUBCATEGORY_4b7bd90d08ee37bfc82baf8e2fdcc25b');
INSERT INTO `store_sub_category` VALUES ('18', '1', '2', '1095', 'STORE_SUBCATEGORY_acd4a5f93257c35323cdfea949a5b01b');
INSERT INTO `store_sub_category` VALUES ('19', '1', '2', '1096', 'STORE_SUBCATEGORY_e6635887a7aa9f447b6f4b34f66f6934');
INSERT INTO `store_sub_category` VALUES ('20', '1', '3', '1097', 'STORE_SUBCATEGORY_3fc3cc901882c74c62b79ae1199ac5c6');
INSERT INTO `store_sub_category` VALUES ('21', '1', '3', '1098', 'STORE_SUBCATEGORY_06211f6762ec8ef81e6bcc523dca8e47');
INSERT INTO `store_sub_category` VALUES ('22', '1', '3', '1099', 'STORE_SUBCATEGORY_1c62a9dc599818ef06fa10ef14707d43');
INSERT INTO `store_sub_category` VALUES ('23', '1', '4', '1100', 'STORE_SUBCATEGORY_2eab72cd48e265b681ad36bfafca890d');
INSERT INTO `store_sub_category` VALUES ('24', '1', '5', '1116', 'STORE_SUBCATEGORY_d35753a8c52b7149fbe168b503c7b018');
INSERT INTO `store_sub_category` VALUES ('25', '1', '6', '1175', 'STORE_SUBCATEGORY_dbbdd5caf25678310873617a99a99972');
INSERT INTO `store_sub_category` VALUES ('26', '1', '6', '1176', 'STORE_SUBCATEGORY_d80e12564e5cfa5c270136a9c8cd8d30');
INSERT INTO `store_sub_category` VALUES ('27', '1', '6', '1177', 'STORE_SUBCATEGORY_10c0b1f5db80301d5df029ef9025cfeb');
INSERT INTO `store_sub_category` VALUES ('28', '1', '6', '1178', 'STORE_SUBCATEGORY_57d3685e456af477c89391472c58dcc6');
INSERT INTO `store_sub_category` VALUES ('29', '1', '6', '1179', 'STORE_SUBCATEGORY_f8fe48c2cfe8efa808a458bb2929aa44');
INSERT INTO `store_sub_category` VALUES ('30', '1', '6', '1180', 'STORE_SUBCATEGORY_3880b02215f17200743ea45f2e44992c');
INSERT INTO `store_sub_category` VALUES ('31', '1', '6', '1181', 'STORE_SUBCATEGORY_4b8679c93aca743ade4455d66db4c72e');
INSERT INTO `store_sub_category` VALUES ('32', '1', '6', '1182', 'STORE_SUBCATEGORY_d4c45cdce8c5e4eb7f15fec5a2b663ef');
INSERT INTO `store_sub_category` VALUES ('33', '1', '6', '1183', 'STORE_SUBCATEGORY_3a47dc6d657949a28c16d6421eff0be6');
INSERT INTO `store_sub_category` VALUES ('34', '2', '6', '1184', 'STORE_SUBCATEGORY_42987f3a2e6f0ab1ed6057262834d2ce');
INSERT INTO `store_sub_category` VALUES ('35', '1', '6', '1185', 'STORE_SUBCATEGORY_3796f8a6998202a5174a3610930a24f0');
INSERT INTO `store_sub_category` VALUES ('36', '1', '6', '1186', 'STORE_SUBCATEGORY_62081219b3ed9e39df5278243606dd6a');
INSERT INTO `store_sub_category` VALUES ('37', '1', '6', '1187', 'STORE_SUBCATEGORY_35a128b287db1ac4972ea629eec3a6b8');
INSERT INTO `store_sub_category` VALUES ('38', '1', '6', '1188', 'STORE_SUBCATEGORY_afc7751696d9b11f118a61de8400da80');
INSERT INTO `store_sub_category` VALUES ('39', '1', '6', '1189', 'STORE_SUBCATEGORY_eef68170b08fb2d45d7287e5189ae3eb');
INSERT INTO `store_sub_category` VALUES ('40', '1', '6', '1190', 'STORE_SUBCATEGORY_4cc4cac6e61db8ba38f4ed3d564eb7fe');
INSERT INTO `store_sub_category` VALUES ('41', '1', '6', '1191', 'STORE_SUBCATEGORY_39cb481fefd6d6d146564e359fcfddae');
INSERT INTO `store_sub_category` VALUES ('42', '1', '6', '1192', 'STORE_SUBCATEGORY_658830c7e344ba36531d38a60ba4c38e');
INSERT INTO `store_sub_category` VALUES ('43', '1', '6', '1193', 'STORE_SUBCATEGORY_311ce7f494ee416be49d50f13da3c37f');
INSERT INTO `store_sub_category` VALUES ('44', '1', '6', '1194', 'STORE_SUBCATEGORY_da9704b4735855cfffff3519549f3513');
INSERT INTO `store_sub_category` VALUES ('45', '1', '6', '1195', 'STORE_SUBCATEGORY_7f9a3a3dcecb6468b8a878de1a093622');
INSERT INTO `store_sub_category` VALUES ('46', '1', '6', '1196', 'STORE_SUBCATEGORY_33ad99ea94ff63b56659c638b802f6f1');
INSERT INTO `store_sub_category` VALUES ('47', '1', '25', '1200', 'STORE_SUBCATEGORY_0277bec5210ad7d1f32d739123488913');
INSERT INTO `store_sub_category` VALUES ('48', '1', '25', '1201', 'STORE_SUBCATEGORY_61c31350043de2ba8ff168a1f06130ac');
INSERT INTO `store_sub_category` VALUES ('49', '1', '25', '1202', 'STORE_SUBCATEGORY_034dae04c82d0609eaa6a07672b0b4a3');
INSERT INTO `store_sub_category` VALUES ('50', '1', '25', '1203', 'STORE_SUBCATEGORY_d3d89975be4aa8978eed0237ad34464d');
INSERT INTO `store_sub_category` VALUES ('51', '1', '7', '1204', 'STORE_SUBCATEGORY_8fd97cb19075abf07e75547866492ea2');
INSERT INTO `store_sub_category` VALUES ('52', '1', '7', '1205', 'STORE_SUBCATEGORY_f2a58c2516da33777ce100f84d98393f');
INSERT INTO `store_sub_category` VALUES ('53', '1', '7', '1206', 'STORE_SUBCATEGORY_6685b45adbcf74351bd53107220ccca5');
INSERT INTO `store_sub_category` VALUES ('54', '1', '7', '1207', 'STORE_SUBCATEGORY_421b6953a0604d2ef01b4db06f445cb5');
