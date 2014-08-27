/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : tagbum

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2014-08-27 17:19:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `activity_users`
-- ----------------------------
DROP TABLE IF EXISTS `activity_users`;
CREATE TABLE `activity_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `code` char(32) CHARACTER SET utf8 NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `REMOTE_ADDR` varchar(25) CHARACTER SET utf8 NOT NULL,
  `HTTP_USER_AGENT` varchar(200) CHARACTER SET utf8 NOT NULL,
  `session_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of activity_users
-- ----------------------------
INSERT INTO `activity_users` VALUES ('1', '124', 'f5731f19900e907d55498802fa0be5f2', '2014-08-27 17:18:54', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', 'smdi3tjugurjrs5i6dgs4pt8g4');
INSERT INTO `activity_users` VALUES ('2', '124', 'f5731f19900e907d55498802fa0be5f2', '2014-08-27 17:19:01', '192.168.1.129', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', 'n1atfhbgitlheasnps2m3vpnt4');
