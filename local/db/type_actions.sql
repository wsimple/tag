/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : tagbum

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-08-11 09:32:47
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
  `label_name` varchar(70) DEFAULT NULL,
  `label_desc` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of type_actions
-- ----------------------------
INSERT INTO `type_actions` VALUES ('1', 'tag', '1', 'private tag', 'tag privada', 'NOTIFICATIONS_TITLEPRIVATETAGMSJUSER', 'NOTIFICATIONS_PRIVATETAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('2', 'tag', '1', 'like a tag', 'quiere una tag', 'NOTIFICATIONS_TITLELIKETAGMSJUSER', 'NOTIFICATIONS_LIKETAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('3', 'tag', '1', 'inbox', '', 'NOTIFICATIONS_TITLEIMBOXTAGMSJUSER', null);
INSERT INTO `type_actions` VALUES ('4', 'tag', '1', 'comment a tag', 'comentar tag', 'NOTIFICATIONS_TITLECOMMENTSTAGMSJUSER', 'NOTIFICATIONS_COMMENTSTAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('5', 'usr', '1', 'friend', 'amigos', 'NOTIFICATIONS_TITLEFRIENDTAGMSJUSER', 'NOTIFICATIONS_FRIENDTAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('6', 'group', '1', 'group', 'grupo', 'NOTIFICATIONS_TITLEGROUPSTAGMSJUSER', 'NOTIFICATIONS_GROUPSTAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('7', 'tag', '1', 'share a tag', 'compartir tag', 'NOTIFICATIONS_TITLESHARETAGMSJUSER', 'NOTIFICATIONS_SHARETAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('8', 'tag', '1', 'redistribute a tag', 'redistribuye una tag', 'NOTIFICATIONS_TITLEREDISTRIBUTIONTAGMSJUSER', 'NOTIFICATIONS_REDISTRIBUTIONTAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('9', 'tag', '1', 'patrocinate a tag', 'patrocina una tag', 'NOTIFICATIONS_TITLESPONSORTAGMSJUSER', 'NOTIFICATIONS_SPONSORTAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('10', 'tag', '1', 'group tag', 'tag de grupo', 'NOTIFICATIONS_TITLEGROUPSTAGUSER', 'NOTIFICATIONS_GROUPSTAGUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('11', 'usr', '1', 'follower', 'seguidores', 'NOTIFICATIONS_TITLEFOLLOWERTAGMSJUSER', 'NOTIFICATIONS_FOLLOWERTAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('12', 'group', '1', 'ask joining to a group', 'peticion de unirse a un grupo', 'NOTIFICATIONS_TITLEMSGGROUPADMINUSER', 'NOTIFICATIONS_MSGGROUPADMINUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('13', 'group', '1', 'aprobe joining to a group', 'aprovada union a un grupo', 'NOTIFICATIONS_TITLEADMINREQUESTUSER', 'NOTIFICATIONS_ADMINREQUESTUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('14', 'group', '1', 'now admin of a group', 'ahora es administrador de un grupo', 'NOTIFICATIONS_TITLENEWADMINGROUPMSJUSER', 'NOTIFICATIONS_NEWADMINGROUPMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('15', 'product', '1', 'store comments', 'comentarios de la tienda', 'NOTIFICATIONS_TITLESTORECOMMENTSMSJUSER', 'NOTIFICATIONS_STORECOMMENTMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('16', 'order', '1', 'order proccessed succesfully', 'orden procesada exitosamente', 'NOTIFICATIONS_TITLESTOREORDERMSJUSER', 'NOTIFICATIONS_STOREORDERMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('17', 'order', '1', 'order sent to paypal', 'orden enviada a paypal', 'NOTIFICATIONS_TITLESTOREORDERPAYMSJUSER', 'NOTIFICATIONS_STOREORDERPAYMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('18', 'raffle', '1', 'inform about the free producs winner', 'informar sobre el ganador del producto gratis', 'NOTIFICATIONS_TITLESTORERAFFLEMSJUSER', 'NOTIFICATIONS_STORERAFFLEMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('19', 'raffle', '1', 'free producs winner', 'ganador del producto gratis', 'NOTIFICATIONS_TITLESTORERAFFLEWINNERMSJUSER', 'NOTIFICATIONS_STORERAFFLEWINNERMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('20', 'tag', '1', 'dislike a tag', 'no quiere una tag', 'NOTIFICATIONS_TITLETAGDISLIKEMSJUSER', 'NOTIFICATIONS_TAGDISLIKEMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('21', 'tag', '1', 'report a tag', 'reporta una tag', 'NOTIFICATIONS_TITLETAGREPORTMSJUSER', 'NOTIFICATIONS_TAGREPORTMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('22', 'tag', '1', 'tag of day', 'tag del dia', 'NOTIFICATIONS_TITLETOPTAGOFDAYMSJUSER', 'NOTIFICATIONS_TOPTAGOFDAYMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('23', 'tag', '1', 'create tag', 'crear tag', 'NOTIFICATIONS_TITLENEWTAGMSJUSER', 'NOTIFICATIONS_NEWTAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('24', 'tag', '1', 'create personal tag', 'crear tag personal', 'NOTIFICATIONS_TITLEPERSONALTAGMSJUSER', 'NOTIFICATIONS_PERSONALTAGMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('25', 'tag', '1', 'tag of week', 'tag de la semana', 'NOTIFICATIONS_TITLETOPTAGOFWEEKMSJUSER', 'NOTIFICATIONS_TOPTAGOFWEEKMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('26', 'tag', '1', 'Tag of month', 'tag del mes', 'NOTIFICATIONS_TITLETOPTAGOFMONTHMSJUSER', 'NOTIFICATIONS_TOPTAGOFMONTHMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('27', 'tag', '1', 'Tag of year', 'tag del aÃ±o', 'NOTIFICATIONS_TITLETOPTAGOFYEARMSJUSER', 'NOTIFICATIONS_TOPTAGOFYEARMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('28', 'tag', '1', 'write in a tag you commented', 'escribieron en una tag que comentaste', 'NOTIFICATIONS_TITLECOMMENTTAGYOUCOMMENTMSJUSER', 'NOTIFICATIONS_COMMENTTAGYOUCOMMENTMSJUSERMESSAGE');
INSERT INTO `type_actions` VALUES ('29', 'product', '1', 'Publication of a productoen Store', 'nuevo producto en la tienda', 'NOTIFICATIONS_TITLENEWPRODUCTSTOREMSJUSER', 'NOTIFICATIONS_NEWPRODUCTSTOREMSJUSERMESSAGE');
