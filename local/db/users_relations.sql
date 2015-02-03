/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : tagbum

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2015-02-03 14:59:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users_relations
-- ----------------------------
DROP TABLE IF EXISTS `users_relations`;
CREATE TABLE `users_relations` (
  `id` tinyint(3) unsigned NOT NULL,
  `label` varchar(20) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_relations
-- ----------------------------
INSERT INTO `users_relations` VALUES ('1', 'single', 'single / soltero');
INSERT INTO `users_relations` VALUES ('2', 'dating', 'dating / buscando pareja');
INSERT INTO `users_relations` VALUES ('3', 'OPEN_RELATIONSHIP', 'open relatipnship . relacion abierta');
INSERT INTO `users_relations` VALUES ('4', 'CLOSED_RELATIONSHIP', 'closed relationship / relacion cerrada');
INSERT INTO `users_relations` VALUES ('5', 'married', 'married / casado');
INSERT INTO `users_relations` VALUES ('6', 'separated', 'separated / separados');
INSERT INTO `users_relations` VALUES ('7', 'divorced', 'divorced / divorciado');
INSERT INTO `users_relations` VALUES ('8', 'widow', 'widow / viudo');
