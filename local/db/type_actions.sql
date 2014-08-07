/*
Navicat MySQL Data Transfer

Source Server         : tagdb200
Source Server Version : 50166
Source Host           : 68.109.244.200:3306
Source Database       : tagbum200

Target Server Type    : MYSQL
Target Server Version : 50166
File Encoding         : 65001

Date: 2014-08-07 16:02:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `type_actions`
-- ----------------------------
DROP TABLE IF EXISTS `type_actions`;
CREATE TABLE `type_actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_source` varchar(15) DEFAULT NULL,
  `status` smallint(5) unsigned NOT NULL DEFAULT '1',
  `description` varchar(50) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `label_notifications` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of type_actions
-- ----------------------------
INSERT INTO `type_actions` VALUES ('1', 'tag', '1', 'private tag', 'tag privada', null);
INSERT INTO `type_actions` VALUES ('2', 'tag', '1', 'like a tags', 'quiere una tag', null);
INSERT INTO `type_actions` VALUES ('3', null, '1', 'inbox', '', null);
INSERT INTO `type_actions` VALUES ('4', 'tag', '1', 'comment a tags', 'comentar tag', null);
INSERT INTO `type_actions` VALUES ('5', 'usr', '1', 'friend', 'amigos', null);
INSERT INTO `type_actions` VALUES ('6', 'group', '1', 'group', 'grupo', null);
INSERT INTO `type_actions` VALUES ('7', 'tag', '1', 'share a tag', 'compartir tag', null);
INSERT INTO `type_actions` VALUES ('8', 'tag', '1', 'redistribute a tags', 'redistribuye una tag', null);
INSERT INTO `type_actions` VALUES ('9', 'tag', '1', 'sponsor a tags', 'patrocina una tag', null);
INSERT INTO `type_actions` VALUES ('10', 'tag', '1', 'group tag', 'tag de grupo', null);
INSERT INTO `type_actions` VALUES ('11', 'usr', '1', 'follower', 'seguidores', null);
INSERT INTO `type_actions` VALUES ('12', 'group', '1', 'ask joining to a group', 'peticion de unirse a un grupo', null);
INSERT INTO `type_actions` VALUES ('13', 'group', '1', 'aprobe joining to a group', 'aprovada union a un grupo', null);
INSERT INTO `type_actions` VALUES ('14', 'group', '1', 'now admin of a group', 'ahora es administrador de un grupo', null);
INSERT INTO `type_actions` VALUES ('15', 'product', '1', 'store comments', 'comentarios de la tienda', null);
INSERT INTO `type_actions` VALUES ('16', 'order', '1', 'order proccessed succesfully', 'orden procesada exitosamente', null);
INSERT INTO `type_actions` VALUES ('17', 'order', '1', 'order sent to paypal', 'orden enviada a paypal', null);
INSERT INTO `type_actions` VALUES ('18', 'raffle', '1', 'inform about the raffle winner', 'informar sobre el ganador de la rifa', null);
INSERT INTO `type_actions` VALUES ('19', 'raffle', '1', 'raffle winner', 'ganador de la rifa', null);
INSERT INTO `type_actions` VALUES ('20', 'tag', '1', 'dislike a tag', 'no quiere una tag', null);
INSERT INTO `type_actions` VALUES ('21', 'tag', '1', 'report a tag', 'reporta una tag', null);
INSERT INTO `type_actions` VALUES ('22', 'tag', '1', 'tag of day', 'tag del dia', null);
INSERT INTO `type_actions` VALUES ('23', 'tag', '1', 'create tag', 'crear tag', null);
INSERT INTO `type_actions` VALUES ('24', 'tag', '1', 'create personal tag', 'crear tag personal', null);
INSERT INTO `type_actions` VALUES ('25', 'tag', '1', 'tag of week', 'tag de la semana', null);
INSERT INTO `type_actions` VALUES ('26', 'tag', '1', 'Tag of month', 'tag del mes', null);
INSERT INTO `type_actions` VALUES ('27', 'tag', '1', 'Tag of year', 'tag del año', null);
INSERT INTO `type_actions` VALUES ('28', 'tag', '1', 'write in a tag you commented', 'escribieron en una tag que comentaste', null);
INSERT INTO `type_actions` VALUES ('29', 'product', '1', 'Publication of a producto on Store', 'nuevo producto en la tienda', null);
