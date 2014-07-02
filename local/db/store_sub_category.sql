/*
Navicat MySQL Data Transfer

Source Server         : seemytag
Source Server Version : 50535
Source Host           : seemytag.com:3306
Source Database       : seemytag

Target Server Type    : MYSQL
Target Server Version : 50535
File Encoding         : 65001

Date: 2014-02-11 15:19:44
*/

SET FOREIGN_KEY_CHECKS=0;

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
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_sub_category
-- ----------------------------
INSERT INTO `store_sub_category` VALUES ('1', '1', '1', '1069', 'STORE_SUBCATEGORY_ALLBG');
INSERT INTO `store_sub_category` VALUES ('19', '1', '2', '1096', 'STORE_SUBCATEGORY_e6635887a7aa9f447b6f4b34f66f6934');
INSERT INTO `store_sub_category` VALUES ('18', '1', '2', '1095', 'STORE_SUBCATEGORY_acd4a5f93257c35323cdfea949a5b01b');
INSERT INTO `store_sub_category` VALUES ('17', '1', '2', '1094', 'STORE_SUBCATEGORY_4b7bd90d08ee37bfc82baf8e2fdcc25b');
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
