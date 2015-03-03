/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : tagbum

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2015-03-03 10:40:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for user_type
-- ----------------------------
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE `user_type` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `description` varchar(150) NOT NULL,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_type
-- ----------------------------
INSERT INTO `user_type` VALUES ('5', 'Users', '1');
INSERT INTO `user_type` VALUES ('1', 'Company', '1');
INSERT INTO `user_type` VALUES ('2', 'Root', '1');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `screen_name` varchar(15) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `date_birth` date NOT NULL,
  `profile_image_url` varchar(200) DEFAULT NULL,
  `updatePicture` char(1) NOT NULL,
  `location` varchar(30) DEFAULT NULL,
  `url` varchar(800) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `referee_number` varchar(10) DEFAULT NULL,
  `referee_user` varchar(10) NOT NULL,
  `password_user` varchar(100) NOT NULL,
  `password_system` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `followers_count` int(10) unsigned NOT NULL DEFAULT '0',
  `friends_count` int(10) unsigned NOT NULL DEFAULT '0',
  `following_count` int(10) unsigned NOT NULL DEFAULT '0',
  `tags_count` int(10) unsigned DEFAULT NULL,
  `references_count` int(7) NOT NULL,
  `time_zone` varchar(5) DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `accumulated_points` bigint(20) NOT NULL,
  `current_points` bigint(20) NOT NULL,
  `status` char(1) NOT NULL,
  `language` char(2) NOT NULL DEFAULT 'en',
  `type` char(1) NOT NULL DEFAULT '0',
  `show_my_birthday` char(1) NOT NULL DEFAULT '1',
  `home_phone` varchar(15) DEFAULT NULL,
  `mobile_phone` varchar(15) DEFAULT NULL,
  `work_phone` varchar(15) DEFAULT NULL,
  `pay_personal_tag` char(1) DEFAULT '0',
  `pay_bussines_card` int(11) DEFAULT '0',
  `logins_count` int(11) NOT NULL,
  `super_user` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `chat_last_update` datetime NOT NULL DEFAULT '2011-01-01 00:00:00',
  `status_chat` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '1',
  `user_background` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `view_creation_tag` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `view_type_timeline` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `sex` char(1) CHARACTER SET utf8 DEFAULT '1',
  `paypal` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `taxId` varchar(11) CHARACTER SET utf8 NOT NULL,
  `fbid` int(10) unsigned DEFAULT NULL,
  `personal_messages` varchar(160) CHARACTER SET utf8 DEFAULT NULL,
  `user_cover` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `interest` tinyint(3) unsigned NOT NULL,
  `relationship` tinyint(3) unsigned NOT NULL,
  `wish_to` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `user_name` (`name`),
  KEY `last_update` (`last_update`),
  KEY `screen_name` (`screen_name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM AUTO_INCREMENT=210 DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('2', 'gustavoocanto@gmail.com', 'gocanto', 'gusi', 'Gustavo', '', '1979-10-18', '5d30c6124c0272b571aff50d64528bfe.jpg', '0', '99.157.172.119', '', '', '229', '', '4045412', 'san diego', '73172', '5b4a84f7a', '88cd85c03', '123456', '5b4a84f7af', '2011-08-25 21:19:20', '6', '5', '6', '163', '4', '', '2015-01-15 15:45:31', '165085', '164485', '1', 'es', '1', '', '-', '+376-5555555555', '+213-3434343434', '1', '8', '504', '0', '2012-12-18 14:49:29', '0', '#fff', '1', '0', '', 'test@paypal.com', '100', null, '', null, '0', '0', '0');
INSERT INTO `users` VALUES ('7', 'miharbihernandez@gmail.com', 'miharbi', 'luis', 'Miharbi', 'Hernandez', '1981-09-03', '9fd717170aaf70732784adc1778c9937.jpg', '0', '190.79.79.42', '', '', '229', '', '4045416', 'valencia', '309992', '3915f770e', '', '123456', '3915f770ea', '2011-03-03 23:39:23', '3', '1', '0', '245', '0', '', '2011-03-03 23:39:23', '343915', '343915', '1', 'es', '1', '1', '+58-4167301061', '+994-2222222222', '+1-888888888888', '0', '1', '395', '1', '2012-04-30 11:47:26', '0', '92c74392e9d72d416f6553be3799f5c8/98679fdb5f4ae8b7136a7d0b76bc5394.jpg', '1', '0', '1', '', '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('83', 'info@websarrollo.com', '', 'Websarrollo', 'Websarrollo, C.A.', '', '1998-02-01', '', '', '192.168.0.101', '', '', '0', '', '', '', '00501', 'c930ff4f7', '', '123456', '', '2011-07-12 16:27:48', '4', '0', '0', '35', '0', '', '2011-07-12 16:27:48', '500', '500', '3', 'en', '1', '', '', '', '', '0', '0', '11', '0', '2012-02-22 09:33:55', '1', null, '', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('84', 'luisarraezd@gmail.com', 'lad', 'lad', 'Luis', 'Alfredo', '1986-05-05', '', '0', '192.168.0.103', '', '', '215', '', '', '', '', '8bc937ae5', '', '123456', '', '2011-07-30 12:15:46', '5', '0', '0', '6', '0', '', '2014-12-05 14:36:46', '1850', '1000', '1', 'en', '0', '1', '+57-1111111', '+593-3333333', '+56-2222222', '0', '22', '344', '0', '2012-07-25 09:44:55', '0', '', '1', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('125', 'aesqueda15@gmail.com', '', 'alfredo', 'alfredo', 'esqueda', '1991-07-14', '', '0', '192.168.1.141', '', '', '215', '', '', '', '', '', '', '123456', '', '2012-02-15 09:13:06', '4', '0', '0', '7', '83', '', '2012-02-15 09:13:06', '200', '200', '1', 'en', '0', '1', '-', '-', '-', '0', '0', '6', '0', '2012-03-06 16:19:46', '1', '#fff', '1', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('85', 'info@soportesti.com', '', 'SoportesTI', 'FranciscoCulo', 'potato', '2011-07-01', 'a565067f5d8bc86e37062fa9b479cbaf.jpg', '0', '192.168.0.102', '', '', '0', '', '', '', '00603', 'af405b0f5', '', '123456', '', '2011-07-26 15:24:39', '3', '0', '0', '2', '0', '', '2011-07-26 15:24:39', '0', '0', '3', 'en', '0', '1', '', '+58-414585463', '+58-2415865', '0', '0', '9', '0', '2012-04-09 10:55:52', '1', null, '', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('118', 'miharbihernandezee@gmail.com', '', 'Jhon Doe', 'Mechada', 'Doe', '1999-02-02', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-01-05 11:54:21', '2', '0', '0', '1', '7', '', '2012-01-05 11:54:21', '25', '25', '1', 'en', '0', '1', '', '', '', '0', '0', '6', '0', '2012-01-18 09:13:50', '1', '#ffffff', '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('101', 'aesqueda14@gmail.com', '', 'YoElPipe', 'Adrian', 'esqueda', '1983-07-14', '880c1b2090a6458607f493a71313233a.png', '0', '192.168.1.143', '', '', '229', '', '4045409', 'japom', '00501', '3f526c62b', '', '123456', '', '2011-09-16 10:06:21', '0', '5', '18', '189', '0', '', '2011-09-16 10:06:21', '20075', '54519', '1', 'es', '0', '1', '-987654', '-876543', '-987654', '0', '-4', '350', '1', '2012-11-07 16:00:25', '0', '#255e1d', '1', '0', '1', '', '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('103', 'rastashe14@hotmail.com', 'holaaaa', 'Rastashe I', 'Rastashe', '', '1931-01-01', 'f92c044fc833ef064e2a043451c1e96e.jpg', '0', '192.168.1.143', '', '', '227', '', '4045577', 'san diego la esmeralda', '00501', '2d0c1aa7d', '', '123456', '', '2011-09-19 09:51:41', '8', '8', '56', '108', '0', '', '2015-01-15 15:45:31', '169000', '169000', '1', 'es', '1', '', '-', '+58-4168409529', '+58-08765432', '0', '0', '122', '0', '2012-04-12 16:07:50', '0', '#cdf8c9', '1', '0', '', 'a@a.com', '666-66-1234', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('119', 'ertesteo@hotmail.com', '', 'johenn flores', 'Johen', 'flores', '1999-02-01', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-01-26 16:40:09', '2', '0', '0', '2', '0', '', '2012-01-26 16:40:09', '50', '50', '1', 'en', '0', '1', null, null, null, '0', '0', '3', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('120', 'aesqueda@websarrollo.com', 'Yo', 'AesWeb', 'Asbesto', '', '1999-01-01', '74660a3d2e888b8c9ea43710aa4d561e.gif', '0', '192.168.1.140', '', '', '229', '', '4045423', 'valencia san diego', '2006', '', '', '123456', '', '2012-01-26 16:43:57', '0', '3', '6', '29', '0', '', '2012-01-26 16:43:57', '111111111111072740', '199899999999961636', '1', 'es', '1', '', '-', '+58-04168409529', '+376-8787878787', '0', '0', '28', '0', '2011-01-01 00:00:00', '1', '#fff', '1', '0', '', 'rjoserivas@gmail.com', '223-32-2332', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('121', 'miharbihe123rnandez@gmail.com', '', 'IphoneArt', 'IphoneArt', 'Maldonado', '1998-02-02', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-01-26 16:53:14', '2', '0', '0', '0', '0', '', '2012-01-26 16:53:14', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('122', 'miharbiheasdasdasdasrnandez@hotmail.com', '', 'Adrian Esqueda', 'Twister', 'perez', '1998-01-03', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-01-26 16:56:49', '2', '0', '0', '0', '0', '', '2012-01-26 16:56:49', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('123', 'gustavooasdasdsdsdsdsdsdsdcanto@gmail.com', '', 'test', 'Caramolida', 'docedoce', '1999-01-02', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-01-26 16:58:37', '3', '0', '0', '0', '0', '', '2012-01-26 16:58:37', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('124', 'willemfranco@gmail.com', 'wfranco', 'wfranco', 'Willem', 'Franco', '1979-04-26', '9e72ca0d0e50fcda05bcd87f6806ea4d.jpg', '0', '192.168.1.125', '', '', '229', '', '', '', '', '', '', '123456', '', '2012-01-30 13:44:06', '4', '4', '9', '28', '0', '', '2015-01-20 15:52:43', '1650', '1650', '1', 'es', '0', '1', '-', '-', '-', '0', '0', '177', '0', '2012-11-07 15:58:46', '1', '#fff', '1', '0', '1', '', '', '11', '', 'f5731f19900e907d55498802fa0be5f2/75f557dfe1f71ee760b183a6dc1506fc.jpg', '0', '0', '0');
INSERT INTO `users` VALUES ('126', 'luisca@gmail.com', '', 'luisca', 'Luci', 'Damian', '2012-01-01', '', '', '192.168.1.123', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-02-22 09:45:27', '4', '0', '0', '0', '0', '', '2012-02-22 09:45:27', '0', '0', '1', 'en', '1', '1', null, null, null, '0', '0', '1', '0', '2012-02-22 09:46:50', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('127', 'lad@gmail.com', '', 'lad', 'Pacoelo', 'lad', '1999-01-01', '4f7289466e01c0e2d65e70a965b70b2c.jpg', '0', '192.168.1.123', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-02 14:28:07', '2', '0', '0', '1', '0', '', '2012-03-02 14:28:07', '25', '25', '1', 'en', '0', '1', '-', '-', '-', '0', '0', '4', '0', '2012-04-09 10:49:03', '1', '#fff', '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('157', 'javivi@nopresto.com', null, 'javivi', 'javivi', 'codo', '1995-02-04', '16f51b2a36bbfddaa185d8ace7634b2b.jpg', '0', '192.168.1.141', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-06 16:17:22', '2', '0', '0', '1', '0', '', '2012-03-06 16:17:22', '25', '25', '1', 'en', '0', '1', '-', '-', '-', '0', '0', '7', '0', '2012-04-09 10:02:49', '1', '#fff', '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('131', 'jose@hotmail.com', null, 'jose', 'Blackberry', 'jose', '1981-02-04', '963a598bacaf8b0cded8a7d51d9800ed.gif', '0', '192.168.1.141', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-06 09:33:31', '3', '0', '0', '0', '0', '', '2012-03-06 09:33:31', '0', '0', '1', 'en', '0', '1', '-', '-', '-', '0', '0', '8', '0', '2012-04-09 10:06:25', '1', '#fff', '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('158', 'gustavooasd2222222dssdsdsdsdasdcanto@gmail.com', null, 'Kiki', 'Eliezer', 'Chessman', '1991-05-10', '', '', '192.168.1.133', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-06 16:58:52', '2', '0', '0', '0', '0', '', '2012-03-06 16:58:52', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('159', 'adjgcvdkcjbb@hbdc.com', null, 'Miharbiooo', 'JOsebaute', 'Fsuj doom', '1995-03-03', '', '', '192.168.1.105', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:13:43', '2', '0', '0', '0', '0', '', '2012-03-07 09:13:43', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('160', 'idshcbsdck@shbcus.com', null, 'Ugadljsdi', 'Alessandra', 'Alex', '1996-03-04', '', '', '192.168.1.105', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:14:24', '3', '0', '0', '0', '0', '', '2012-03-07 09:14:24', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('161', 'ojdncisn@sidhburc.com', null, 'Icily', 'Maridto', 'Jicuh', '1995-05-04', '', '', '192.168.1.105', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:16:20', '2', '0', '0', '0', '0', '', '2012-03-07 09:16:20', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('162', 'ibciusr@ushebuce.djo', null, 'Jbdcihsbi', 'Danilo', 'pedro', '1996-03-04', '', '', '192.168.1.105', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:22:02', '3', '0', '0', '0', '0', '', '2012-03-07 09:22:02', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('163', 'sdfsdf@sddfsd.com', null, 'sdfsdf', 'EliJoseBo', 'ramirez', '1992-04-08', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:26:27', '3', '0', '0', '0', '0', '', '2012-03-07 09:26:27', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('164', 'xzcvzxcv@sdfsdf.com', null, 'zxczxc', 'Gusi', 'hernandez', '1992-06-08', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:29:52', '2', '0', '0', '0', '0', '', '2012-03-07 09:29:52', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('165', 'asdasd@sdfsdf.com', null, 'zsdfasd', 'DavidZam', 'mrque', '1993-07-09', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:32:21', '3', '0', '0', '0', '0', '', '2012-03-07 09:32:21', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('166', 'dasdas@asdad.com', null, 'asdasd', 'PabloJO', 'juliz', '1993-08-06', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:34:50', '2', '0', '0', '0', '0', '', '2012-03-07 09:34:50', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('167', 'asdasd@sdfsd.com', null, 'asdasdas', 'Jorga', 'Sadan', '1990-04-10', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:41:19', '2', '0', '0', '0', '0', '', '2012-03-07 09:41:19', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('168', 'asdasd@asdasd.com', null, 'asdasd', 'Hector', 'Rafita', '1990-05-07', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:42:29', '2', '0', '0', '0', '0', '', '2012-03-07 09:42:29', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('169', 'asdasdqweqwvsdfw@sdfsfsdfs.com', null, 'asdasd', 'Rango', 'Franquito', '1992-05-05', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:43:54', '3', '0', '0', '0', '0', '', '2012-03-07 09:43:54', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('170', 'asdasdasd@asdasdasdasddew.pco', null, 'ASDASD', 'Antonio', 'el babi', '1992-06-07', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:45:52', '2', '0', '0', '0', '0', '', '2012-03-07 09:45:52', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('171', 'asdasdkjpm@sdfsod.cgf', null, 'asdasd', 'Maurto', 'Marjorieth', '1989-04-06', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:46:44', '2', '0', '0', '0', '0', '', '2012-03-07 09:46:44', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('172', 'asdasdasdasewqwer@sfsdfsdf.fsd', null, 'dasdasd', 'andreina', 'Petra', '1992-05-08', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 09:55:33', '2', '0', '0', '0', '0', '', '2012-03-07 09:55:33', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('173', 'asdasdasqwe123@asda.com', null, 'asdasd', 'Gissel', 'Luisa', '1991-07-07', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 10:08:36', '2', '0', '0', '0', '0', '', '2012-03-07 10:08:36', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('174', 'asdasdasd1231@asdas1223.com', null, 'asdasd', 'Astrid', 'josefa', '1992-07-07', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 10:10:08', '4', '0', '0', '0', '0', '', '2015-01-20 15:52:43', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('175', 'asdasdasdas12312@qweqwe21.com', null, 'asdasdas', 'JuanaMaria', 'Paula', '1994-06-05', '', '', '192.168.1.140', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 10:13:08', '3', '0', '0', '0', '0', '', '2012-03-07 10:13:08', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('176', 'pepitoperez@gmail.com', null, 'Pepito', 'Sneider', 'Perez', '1987-04-12', '', '', '192.168.1.125', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 10:14:53', '2', '0', '0', '0', '0', '', '2012-03-07 10:14:53', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('177', 'lscnvdjfnvkd@sdvijsbvd.com', null, 'Mdicb', 'Victor', 'Musculo', '1996-03-04', '', '', '192.168.1.105', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 10:16:38', '2', '0', '0', '0', '0', '', '2012-03-07 10:16:38', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('178', 'xxxxxxx@ssssssss.ccccc', null, 'kkkk', 'Osneida', 'C', '1992-05-08', '', '', '192.168.1.139', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 10:20:13', '3', '0', '0', '0', '0', '', '2012-03-07 10:20:13', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('179', 'zzzzzxxxxxx@sssss.cccc', null, '11111122', 'Nilda', 'Ernesto', '1968-08-12', '', '', '192.168.1.139', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 10:21:17', '3', '0', '0', '0', '0', '', '2012-03-07 10:21:17', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('180', 'webo@nalga.culo', null, 'culo', 'Pene', 'cuca', '1989-05-11', '', '', '192.168.1.139', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 10:23:09', '2', '0', '0', '0', '0', '', '2012-03-07 10:23:09', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('181', 'hdhs@44.com', null, 'Hash d hd hd', 'Beba', 'rojas', '1997-02-04', '', '', '192.168.1.109', '', '', '0', '', '', '', '', '', '', '123456', '', '2012-03-07 10:25:31', '3', '0', '0', '0', '0', '', '2012-03-07 10:25:31', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('183', 'wpanel@seemytag.com', 'wpanel', 'wpanel', 'Administra', 'admin', '1983-07-14', '62c80fdb56558db9f348191d25bb8262.jpg', '0', '192.168.1.110', null, null, '0', null, null, null, null, null, '', '123456', '', '2012-03-07 10:34:37', '2', '2', '3', '4', '0', null, '2015-01-15 10:38:19', '100', '100', '1', 'en', '0', '1', null, null, null, '0', '0', '2', '0', '2011-01-01 00:00:00', '1', null, '1', '0', '1', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('184', 'maxtri@hotmail.com', 'ramon', 'ramon', 'ramon', '', '0000-00-00', '17c5b8ffdbe270cc294f3ec0b15ef36a.png', '0', '192.168.1.141', '', '', '11', '', '4045415', '9569569569', '20021', '', '', '123456', '', '2013-04-16 10:59:38', '7', '7', '55', '52', '0', '', '2015-01-15 10:38:13', '-6194661', '183043', '1', 'es', '1', '', '-', '+673-256', '+1-456', '0', '0', '86', '0', '2011-01-01 00:00:00', '1', '#0803c9', '0', '0', '1', '9855', '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('195', 'cuentacuentacuenta@cuenta.com', '', 'ramon', 'Tulio', 'talvez', '1995-04-04', '', '', '192.168.1.141', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-04-18 15:42:37', '3', '0', '0', '0', '0', '', '2013-04-18 15:42:37', '0', '0', '3', 'en', '0', '1', null, null, null, '0', '0', '4', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('196', 'cuentacuentacuenta2@cuenta.com', '', 'ramon', 'ramon', 'ramon', '1995-04-13', '', '', '192.168.1.141', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-04-18 15:44:28', '3', '0', '0', '0', '0', '', '2014-08-18 10:35:17', '0', '0', '3', 'en', '0', '1', null, null, null, '0', '0', '2', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('197', 'ramomonchi@joseriv.com', '', 'Momchi', 'Profeee', 'Maestre', '1994-04-04', '', '', '192.168.1.103', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-04-24 09:47:45', '2', '0', '0', '1', '0', '', '2013-04-24 09:47:45', '175', '175', '3', 'en', '0', '1', null, null, null, '0', '0', '2', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('198', 'ramonramon@ramon.com', '', 'ramon', 'LuisaFa', 'ramon', '1995-04-10', '', '', '192.168.1.141', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-04-24 13:51:39', '2', '0', '0', '0', '0', '', '2013-04-24 13:51:39', '0', '0', '2', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('199', 'mierda_mierda@hotmail.com', '', 'mierda', 'Merda', 'mierda', '1973-08-07', '', '', '192.168.1.141', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-04-26 09:34:23', '2', '0', '0', '17', '0', '', '2013-04-26 09:34:23', '425', '425', '3', 'en', '0', '1', null, null, null, '0', '0', '4', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('200', 'guevopelado@asjdhaksjd.com', '', 'guevo ', 'Pelado', 'pelado', '1953-12-15', '', '', '192.168.1.141', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-05-03 14:02:41', '2', '0', '0', '0', '0', '', '2013-05-03 14:02:41', '0', '0', '2', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('201', 'aaaaaaaaaaaramon_227_jr@hotmail.com', '', 'maric&', 'Julio', 'Jhon', '1984-12-14', '', '', '192.168.1.141', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-05-03 14:03:15', '2', '0', '0', '0', '0', '', '2013-05-03 14:03:15', '0', '0', '3', 'en', '1', '1', null, null, null, '0', '0', '1', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('202', 'aaaaaaaaaaaaaaaaaaaaaalberto_melendez@aol.com', '', 'draaa....', 'frank', 'adasdasdsdasdasdasd', '1982-12-16', '', '', '192.168.1.141', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-05-03 14:06:13', '2', '0', '0', '0', '0', '', '2013-05-03 14:06:13', '0', '0', '2', 'en', '1', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('203', 'franciscoesqueda14@gmail.com', '', 'Frankauto ca', 'Francisco', 'Alfonzo', '1995-08-24', '', '', '192.168.1.123', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-08-09 20:41:56', '2', '0', '0', '0', '0', '', '2013-08-09 20:41:56', '0', '0', '2', 'en', '1', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('204', 'aw@aw.com', '', 'a', 'Maricarmen', 'a', '1995-08-15', '', '', '192.168.1.123', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-08-20 14:18:33', '3', '0', '0', '0', '0', '', '2013-08-20 14:18:33', '0', '0', '1', 'en', '0', '1', null, null, null, '0', '0', '3', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('205', 'ul@ul.com', '', 'Ultimo', 'Ultimo', 'Last', '1995-08-09', '', '', '192.168.1.123', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-08-27 21:35:38', '3', '0', '0', '0', '0', '', '2014-12-11 10:15:16', '0', '0', '3', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('206', 'ale@ale.com', '', 'ale', 'ale', 'ale', '1995-10-17', '283d512aefe53e8fc5e81747e463f8c5.png', '0', '192.168.1.123', '', '', '0', '', '', '', '', '', '', '123456', '', '2013-10-15 15:45:38', '0', '2', '1', '3', '0', '', '2013-10-15 15:45:38', '75', '75', '1', 'en', '0', '1', '-', '-', '-', '0', '0', '7', '0', '2011-01-01 00:00:00', '1', '#fff', '1', '0', '', '', '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('207', 'ass@as.com', '', 'hola', 'hola', '', '1995-11-14', '', '', '::1', '', '', '0', '', '', '', '', '', '', '111111', '', '2013-11-12 21:11:54', '0', '0', '0', '0', '0', '', '2013-11-12 21:11:54', '0', '0', '2', 'en', '1', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('208', 's@ee.com', '', 'aaaa', 'aaaa', 'aaaa', '1995-11-16', '', '', '::1', '', '', '0', '', '', '', '', '', '', 'qqqqqqq', '', '2013-11-12 21:17:12', '0', '0', '0', '0', '0', '', '2013-11-12 21:17:12', '0', '0', '2', 'en', '0', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', null, null, null, '0', '0', '0');
INSERT INTO `users` VALUES ('209', 'yp@op.com', '', 'yo', 'yo', '', '1995-12-14', '', '', '192.168.1.123', '', '', '0', '', '', '', '', '', '', '111111', '', '2013-12-03 20:59:45', '0', '0', '0', '0', '0', '', '2013-12-03 20:59:45', '0', '0', '2', '', '1', '1', null, null, null, '0', '0', '0', '0', '2011-01-01 00:00:00', '1', null, '0', '0', '', null, '', '0', null, null, '0', '0', '0');

-- ----------------------------
-- Table structure for users_config_notifications
-- ----------------------------
DROP TABLE IF EXISTS `users_config_notifications`;
CREATE TABLE `users_config_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_notification` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_config_notifications
-- ----------------------------
INSERT INTO `users_config_notifications` VALUES ('51', '7', '12');
INSERT INTO `users_config_notifications` VALUES ('57', '7', '5');
INSERT INTO `users_config_notifications` VALUES ('56', '7', '6');
INSERT INTO `users_config_notifications` VALUES ('54', '7', '9');
INSERT INTO `users_config_notifications` VALUES ('58', '7', '4');
INSERT INTO `users_config_notifications` VALUES ('50', '2', '2');
INSERT INTO `users_config_notifications` VALUES ('53', '7', '10');
INSERT INTO `users_config_notifications` VALUES ('55', '7', '8');
INSERT INTO `users_config_notifications` VALUES ('59', '7', '2');
INSERT INTO `users_config_notifications` VALUES ('52', '7', '11');
INSERT INTO `users_config_notifications` VALUES ('61', '7', '1');

-- ----------------------------
-- Table structure for users_copy
-- ----------------------------
DROP TABLE IF EXISTS `users_copy`;
CREATE TABLE `users_copy` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `code` char(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `fbid` int(10) unsigned DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `screen_name` varchar(15) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `date_birth` date NOT NULL,
  `profile_image_url` varchar(200) DEFAULT NULL,
  `updatePicture` char(1) NOT NULL,
  `location` varchar(30) DEFAULT NULL,
  `url` varchar(800) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `referee_number` varchar(10) DEFAULT NULL,
  `referee_user` varchar(10) NOT NULL,
  `password_user` varchar(100) NOT NULL,
  `password_system` varchar(100) NOT NULL,
  `followers_count` int(10) unsigned NOT NULL DEFAULT '0',
  `friends_count` int(10) unsigned NOT NULL DEFAULT '0',
  `following_count` int(10) unsigned NOT NULL DEFAULT '0',
  `tags_count` int(10) unsigned DEFAULT NULL,
  `references_count` int(7) NOT NULL,
  `time_zone` varchar(5) DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `accumulated_points` bigint(20) NOT NULL,
  `current_points` bigint(20) NOT NULL,
  `status` char(1) NOT NULL,
  `language` char(2) NOT NULL DEFAULT 'en',
  `type` char(1) NOT NULL DEFAULT '0',
  `show_my_birthday` char(1) NOT NULL DEFAULT '1',
  `home_phone` varchar(15) DEFAULT NULL,
  `mobile_phone` varchar(15) DEFAULT NULL,
  `work_phone` varchar(15) DEFAULT NULL,
  `pay_personal_tag` char(1) DEFAULT '0',
  `pay_bussines_card` int(11) DEFAULT '0',
  `logins_count` int(11) NOT NULL,
  `super_user` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `chat_last_update` datetime NOT NULL DEFAULT '2011-01-01 00:00:00',
  `status_chat` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '1',
  `user_background` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `view_creation_tag` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `view_type_timeline` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `sex` char(1) CHARACTER SET utf8 DEFAULT '1',
  `paypal` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `taxId` varchar(11) CHARACTER SET utf8 NOT NULL,
  `personal_messages` varchar(160) CHARACTER SET utf8 DEFAULT NULL,
  `user_cover` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `code` (`code`),
  KEY `user_name` (`name`),
  KEY `last_update` (`last_update`),
  KEY `screen_name` (`screen_name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=0;

-- ----------------------------
-- Records of users_copy
-- ----------------------------

-- ----------------------------
-- Table structure for users_device_login
-- ----------------------------
DROP TABLE IF EXISTS `users_device_login`;
CREATE TABLE `users_device_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `agent` mediumtext NOT NULL,
  `remote_addr` varchar(20) NOT NULL,
  `remote_host` varchar(100) NOT NULL,
  `remote_port` varchar(20) NOT NULL,
  `language` varchar(30) NOT NULL,
  `is_mobile` char(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1787 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_device_login
-- ----------------------------
INSERT INTO `users_device_login` VALUES ('1', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.139', '', '52236', 'es-es', '0', '2011-11-18 12:21:48');
INSERT INTO `users_device_login` VALUES ('2', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '57181', 'en-us', '0', '2011-11-18 12:22:26');
INSERT INTO `users_device_login` VALUES ('3', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '57181', 'en-us', '0', '2011-11-18 12:22:38');
INSERT INTO `users_device_login` VALUES ('4', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '35372', 'en-us', '0', '2011-11-18 12:23:30');
INSERT INTO `users_device_login` VALUES ('5', '84', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.124', '', '41254', 'en-GB', '1', '2011-11-18 12:24:33');
INSERT INTO `users_device_login` VALUES ('6', '2', 'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_5 like Mac OS X; es-es) AppleWebKit/533.17.9 (KHTML, like Gecko) Mobile/8L1', '192.168.1.121', '', '61331', 'es-es', '1', '2011-11-18 12:28:47');
INSERT INTO `users_device_login` VALUES ('7', '2', 'Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en-US) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.246 Mobile Safari/534.1+', '192.168.1.125', '', '51648', 'en-US', '1', '2011-11-18 12:32:34');
INSERT INTO `users_device_login` VALUES ('8', '2', 'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_5 like Mac OS X; es-es) AppleWebKit/533.17.9 (KHTML, like Gecko) Mobile/8L1', '192.168.1.121', '', '61372', 'es-es', '1', '2011-11-18 12:35:44');
INSERT INTO `users_device_login` VALUES ('9', '84', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.124', '', '39821', 'en-GB', '1', '2011-11-18 12:36:06');
INSERT INTO `users_device_login` VALUES ('10', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5', '192.168.1.142', '', '50413', 'en-us', '1', '2011-11-18 12:37:36');
INSERT INTO `users_device_login` VALUES ('11', '84', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.124', '', '53096', 'en-GB', '1', '2011-11-18 14:53:18');
INSERT INTO `users_device_login` VALUES ('12', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.140', '', '52874', 'en-us', '0', '2011-11-18 15:57:25');
INSERT INTO `users_device_login` VALUES ('13', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.139', '', '56181', 'es-es', '0', '2011-11-18 16:47:53');
INSERT INTO `users_device_login` VALUES ('14', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '45458', 'en-us', '0', '2011-11-21 10:25:48');
INSERT INTO `users_device_login` VALUES ('15', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '42295', 'en-us', '0', '2011-11-21 10:34:35');
INSERT INTO `users_device_login` VALUES ('16', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.139', '', '49581', 'es-es', '0', '2011-11-21 14:08:46');
INSERT INTO `users_device_login` VALUES ('17', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2', '192.168.1.139', '', '53395', 'en-US', '0', '2011-11-22 10:04:45');
INSERT INTO `users_device_login` VALUES ('18', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '53909', 'en-us', '0', '2011-11-22 11:17:43');
INSERT INTO `users_device_login` VALUES ('19', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.140', '', '53870', 'en-us', '0', '2011-11-22 11:25:08');
INSERT INTO `users_device_login` VALUES ('20', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '48400', 'en-us', '0', '2011-11-23 13:43:14');
INSERT INTO `users_device_login` VALUES ('21', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '48927', 'en-us', '0', '2011-11-23 15:17:27');
INSERT INTO `users_device_login` VALUES ('22', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '49235', 'es-es', '0', '2011-11-24 09:39:06');
INSERT INTO `users_device_login` VALUES ('23', '111', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '48341', 'en-us', '0', '2011-11-24 10:26:01');
INSERT INTO `users_device_login` VALUES ('24', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '48377', 'en-us', '0', '2011-11-24 10:27:24');
INSERT INTO `users_device_login` VALUES ('25', '111', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '48377', 'en-us', '0', '2011-11-24 10:27:46');
INSERT INTO `users_device_login` VALUES ('26', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '58472', 'en-us', '0', '2011-11-24 11:02:07');
INSERT INTO `users_device_login` VALUES ('27', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '59221', 'en-us', '0', '2011-11-24 11:15:28');
INSERT INTO `users_device_login` VALUES ('28', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '39932', 'en-us', '0', '2011-11-24 11:18:03');
INSERT INTO `users_device_login` VALUES ('29', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '38055', 'en-us', '0', '2011-11-24 11:36:11');
INSERT INTO `users_device_login` VALUES ('30', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '51707', 'en-us', '0', '2011-11-24 11:47:43');
INSERT INTO `users_device_login` VALUES ('31', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '51737', 'en-us', '0', '2011-11-24 11:52:28');
INSERT INTO `users_device_login` VALUES ('32', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '51737', 'en-us', '0', '2011-11-24 11:52:42');
INSERT INTO `users_device_login` VALUES ('33', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '53478', 'en-us', '0', '2011-11-24 11:52:52');
INSERT INTO `users_device_login` VALUES ('34', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '51773', 'en-us', '0', '2011-11-24 11:58:18');
INSERT INTO `users_device_login` VALUES ('35', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '51865', 'en-us', '0', '2011-11-24 13:25:21');
INSERT INTO `users_device_login` VALUES ('36', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '48801', 'en-us', '0', '2011-11-24 13:50:07');
INSERT INTO `users_device_login` VALUES ('37', '84', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '58962', 'en-us', '0', '2011-11-24 16:06:17');
INSERT INTO `users_device_login` VALUES ('38', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '59602', 'en-us', '0', '2011-11-25 08:59:56');
INSERT INTO `users_device_login` VALUES ('39', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '47678', 'en-us', '0', '2011-11-25 09:43:49');
INSERT INTO `users_device_login` VALUES ('40', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '34272', 'en-us', '0', '2011-11-25 09:58:44');
INSERT INTO `users_device_login` VALUES ('41', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '40433', 'en-us', '0', '2011-11-25 11:07:39');
INSERT INTO `users_device_login` VALUES ('42', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '63969', 'en-us', '0', '2011-11-25 12:36:43');
INSERT INTO `users_device_login` VALUES ('43', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '64325', 'en-us', '0', '2011-11-25 13:01:24');
INSERT INTO `users_device_login` VALUES ('44', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '49638', 'en-us', '0', '2011-11-25 13:39:33');
INSERT INTO `users_device_login` VALUES ('45', '111', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '53619', 'en-us', '0', '2011-11-25 13:40:49');
INSERT INTO `users_device_login` VALUES ('46', '111', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '49668', 'en-us', '0', '2011-11-25 13:41:14');
INSERT INTO `users_device_login` VALUES ('47', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '52913', 'en-us', '0', '2011-11-25 14:36:47');
INSERT INTO `users_device_login` VALUES ('48', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '49145', 'en-us', '0', '2011-11-25 14:39:56');
INSERT INTO `users_device_login` VALUES ('49', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '50754', 'en-us', '0', '2011-11-25 14:44:04');
INSERT INTO `users_device_login` VALUES ('50', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '50802', 'en-us', '0', '2011-11-25 14:47:40');
INSERT INTO `users_device_login` VALUES ('51', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '50901', 'en-us', '0', '2011-11-25 14:58:48');
INSERT INTO `users_device_login` VALUES ('52', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '50941', 'en-us', '0', '2011-11-25 15:02:06');
INSERT INTO `users_device_login` VALUES ('53', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '50990', 'en-us', '0', '2011-11-25 15:07:15');
INSERT INTO `users_device_login` VALUES ('54', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '51006', 'en-us', '0', '2011-11-25 15:08:05');
INSERT INTO `users_device_login` VALUES ('55', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '51012', 'en-us', '0', '2011-11-25 15:08:44');
INSERT INTO `users_device_login` VALUES ('56', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '38022', 'en-us', '0', '2011-11-25 16:03:50');
INSERT INTO `users_device_login` VALUES ('57', '111', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '55705', 'en-us', '0', '2011-11-25 16:47:07');
INSERT INTO `users_device_login` VALUES ('58', '103', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '57143', 'en-us', '0', '2011-11-28 08:47:04');
INSERT INTO `users_device_login` VALUES ('59', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '51444', 'es-es', '0', '2011-11-28 09:03:23');
INSERT INTO `users_device_login` VALUES ('60', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57839', 'en-us', '0', '2011-11-28 12:00:48');
INSERT INTO `users_device_login` VALUES ('61', '103', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '47651', 'en-us', '0', '2011-11-28 12:21:01');
INSERT INTO `users_device_login` VALUES ('62', '84', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '60949', 'en-us', '0', '2011-11-28 15:58:03');
INSERT INTO `users_device_login` VALUES ('63', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '59355', 'en-us', '0', '2011-11-28 16:00:38');
INSERT INTO `users_device_login` VALUES ('64', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '59618', 'en-us', '0', '2011-11-28 16:18:58');
INSERT INTO `users_device_login` VALUES ('65', '103', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '48585', 'en-us', '0', '2011-11-28 17:07:21');
INSERT INTO `users_device_login` VALUES ('66', '103', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '34466', 'en-us', '0', '2011-11-29 10:11:41');
INSERT INTO `users_device_login` VALUES ('67', '84', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '50998', 'en-us', '0', '2011-11-29 11:19:36');
INSERT INTO `users_device_login` VALUES ('68', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '59655', 'en-us', '0', '2011-11-29 11:26:26');
INSERT INTO `users_device_login` VALUES ('69', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '50908', 'en-us', '0', '2011-11-29 14:48:27');
INSERT INTO `users_device_login` VALUES ('70', '84', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '55072', 'en-us', '0', '2011-11-29 14:59:52');
INSERT INTO `users_device_login` VALUES ('71', '84', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2', '192.168.1.123', '', '36310', 'en-US', '0', '2011-11-29 15:41:49');
INSERT INTO `users_device_login` VALUES ('72', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5', '192.168.1.142', '', '55990', 'en-us', '1', '2011-11-29 16:03:24');
INSERT INTO `users_device_login` VALUES ('73', '84', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2', '192.168.1.123', '', '59380', 'en-US', '0', '2011-11-29 16:31:38');
INSERT INTO `users_device_login` VALUES ('74', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '59519', 'en-us', '0', '2011-11-29 16:45:44');
INSERT INTO `users_device_login` VALUES ('75', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '58318', 'en-us', '0', '2011-11-30 09:47:01');
INSERT INTO `users_device_login` VALUES ('76', '104', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '58354', 'en-us', '0', '2011-11-30 09:53:02');
INSERT INTO `users_device_login` VALUES ('77', '104', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '58354', 'en-us', '0', '2011-11-30 09:54:18');
INSERT INTO `users_device_login` VALUES ('78', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '58382', 'en-us', '0', '2011-11-30 09:58:10');
INSERT INTO `users_device_login` VALUES ('79', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '50551', 'en-us', '0', '2011-11-30 14:18:10');
INSERT INTO `users_device_login` VALUES ('80', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '50558', 'en-us', '0', '2011-11-30 14:19:10');
INSERT INTO `users_device_login` VALUES ('81', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '61072', 'en-us', '0', '2011-11-30 16:13:16');
INSERT INTO `users_device_login` VALUES ('82', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '48835', 'en-us', '0', '2011-12-01 09:31:42');
INSERT INTO `users_device_login` VALUES ('83', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '59294', 'en-us', '0', '2011-12-01 09:44:15');
INSERT INTO `users_device_login` VALUES ('84', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '49554', 'es-es', '0', '2011-12-01 13:15:21');
INSERT INTO `users_device_login` VALUES ('85', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '52905', 'en-us', '0', '2011-12-01 16:09:50');
INSERT INTO `users_device_login` VALUES ('86', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '43576', 'en-us', '0', '2011-12-02 09:28:24');
INSERT INTO `users_device_login` VALUES ('87', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '45294', 'en-us', '0', '2011-12-02 11:21:03');
INSERT INTO `users_device_login` VALUES ('88', '7', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '45294', 'en-us', '0', '2011-12-02 11:21:34');
INSERT INTO `users_device_login` VALUES ('89', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '45445', 'en-us', '0', '2011-12-02 11:30:42');
INSERT INTO `users_device_login` VALUES ('90', '108', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '45482', 'en-us', '0', '2011-12-02 11:35:47');
INSERT INTO `users_device_login` VALUES ('91', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '46282', 'en-us', '0', '2011-12-02 12:21:52');
INSERT INTO `users_device_login` VALUES ('92', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '46046', 'en-us', '0', '2011-12-05 09:16:37');
INSERT INTO `users_device_login` VALUES ('93', '111', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '48824', 'en-us', '0', '2011-12-05 09:47:06');
INSERT INTO `users_device_login` VALUES ('94', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '48824', 'en-us', '0', '2011-12-05 09:49:03');
INSERT INTO `users_device_login` VALUES ('95', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '52947', 'es-es', '0', '2011-12-05 14:12:35');
INSERT INTO `users_device_login` VALUES ('96', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5', '192.168.1.142', '', '53476', 'en-us', '1', '2011-12-05 15:38:39');
INSERT INTO `users_device_login` VALUES ('97', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '49791', 'en-us', '0', '2011-12-05 16:06:55');
INSERT INTO `users_device_login` VALUES ('98', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '39732', 'en-us', '0', '2011-12-06 10:18:02');
INSERT INTO `users_device_login` VALUES ('99', '113', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.125', '', '59017', 'es-MX', '0', '2011-12-06 13:37:52');
INSERT INTO `users_device_login` VALUES ('100', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '56949', 'en-us', '0', '2011-12-06 16:26:37');
INSERT INTO `users_device_login` VALUES ('101', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57196', 'en-us', '0', '2011-12-06 16:42:06');
INSERT INTO `users_device_login` VALUES ('102', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57196', 'en-us', '0', '2011-12-06 16:42:36');
INSERT INTO `users_device_login` VALUES ('103', '113', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.125', '', '49984', 'es-MX', '0', '2011-12-06 16:55:32');
INSERT INTO `users_device_login` VALUES ('104', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '39704', 'en-us', '0', '2011-12-07 10:41:47');
INSERT INTO `users_device_login` VALUES ('105', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '42290', 'en-us', '0', '2011-12-07 11:43:50');
INSERT INTO `users_device_login` VALUES ('106', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '43341', 'en-us', '0', '2011-12-07 14:38:52');
INSERT INTO `users_device_login` VALUES ('107', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '39855', 'en-us', '0', '2011-12-07 14:40:49');
INSERT INTO `users_device_login` VALUES ('108', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '44296', 'en-us', '0', '2011-12-07 15:58:44');
INSERT INTO `users_device_login` VALUES ('109', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '50063', 'es-es', '0', '2011-12-08 10:16:25');
INSERT INTO `users_device_login` VALUES ('110', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '48140', 'en-us', '0', '2011-12-08 10:54:38');
INSERT INTO `users_device_login` VALUES ('111', '101', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.141', '', '46752', 'en-us', '0', '2011-12-08 11:06:37');
INSERT INTO `users_device_login` VALUES ('112', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '54758', 'en-us', '0', '2011-12-08 14:37:37');
INSERT INTO `users_device_login` VALUES ('113', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '38906', 'en-us', '0', '2011-12-08 15:11:15');
INSERT INTO `users_device_login` VALUES ('114', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '38907', 'en-us', '0', '2011-12-08 15:11:16');
INSERT INTO `users_device_login` VALUES ('115', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.51.22 (KHTML, like Gecko) Version/5.1.1 Safari/534.51.22', '192.168.1.140', '', '52954', 'en-us', '0', '2011-12-08 15:52:20');
INSERT INTO `users_device_login` VALUES ('116', '7', 'Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.9.168 Version/11.52', '192.168.1.140', '', '53012', 'en', '0', '2011-12-08 15:53:59');
INSERT INTO `users_device_login` VALUES ('117', '84', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2', '192.168.1.140', '', '53061', 'en-US', '0', '2011-12-08 15:55:32');
INSERT INTO `users_device_login` VALUES ('118', '2', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2)', '192.168.1.139', '', '54302', 'en-us', '0', '2011-12-08 15:57:52');
INSERT INTO `users_device_login` VALUES ('119', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.202 Safari/535.1', '192.168.1.141', '', '41153', 'en-US', '0', '2011-12-08 16:04:03');
INSERT INTO `users_device_login` VALUES ('120', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5', '192.168.1.142', '', '58034', 'en-us', '1', '2011-12-08 16:23:54');
INSERT INTO `users_device_login` VALUES ('121', '7', 'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_5 like Mac OS X; es-es) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8L1 Safari/6533.18.5', '192.168.1.111', '', '55548', 'es-es', '1', '2011-12-08 16:34:51');
INSERT INTO `users_device_login` VALUES ('122', '83', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2', '192.168.1.139', '', '56127', 'en-US', '0', '2011-12-09 09:55:18');
INSERT INTO `users_device_login` VALUES ('123', '84', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2', '192.168.1.123', '', '43934', 'en-US', '0', '2011-12-09 10:40:21');
INSERT INTO `users_device_login` VALUES ('124', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:6.0.2) Gecko/20100101 Firefox/6.0.2', '127.0.0.1', '', '52158', 'en-us', '0', '2011-12-09 11:22:02');
INSERT INTO `users_device_login` VALUES ('125', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:6.0.2) Gecko/20100101 Firefox/6.0.2', '192.168.1.100', '', '52167', 'en-us', '0', '2011-12-09 11:22:17');
INSERT INTO `users_device_login` VALUES ('126', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '57225', 'es-es', '0', '2011-12-09 11:28:31');
INSERT INTO `users_device_login` VALUES ('127', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57881', 'en-us', '0', '2011-12-09 14:26:32');
INSERT INTO `users_device_login` VALUES ('128', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '50064', 'en-us', '0', '2011-12-12 08:25:15');
INSERT INTO `users_device_login` VALUES ('129', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '50073', 'es-es', '0', '2011-12-12 08:33:05');
INSERT INTO `users_device_login` VALUES ('130', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2', '192.168.1.139', '', '50090', 'en-US', '0', '2011-12-12 08:36:27');
INSERT INTO `users_device_login` VALUES ('131', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '61859', 'en-us', '0', '2011-12-12 09:02:31');
INSERT INTO `users_device_login` VALUES ('132', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '57619', 'en-us', '0', '2011-12-12 09:05:29');
INSERT INTO `users_device_login` VALUES ('133', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '58988', 'en-us', '0', '2011-12-12 10:35:40');
INSERT INTO `users_device_login` VALUES ('134', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '59016', 'en-us', '0', '2011-12-12 10:40:45');
INSERT INTO `users_device_login` VALUES ('135', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '59114', 'en-us', '0', '2011-12-12 10:52:32');
INSERT INTO `users_device_login` VALUES ('136', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '51527', 'es-es', '0', '2011-12-12 10:54:27');
INSERT INTO `users_device_login` VALUES ('137', '84', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2', '192.168.1.123', '', '59224', 'en-US', '0', '2011-12-12 11:03:44');
INSERT INTO `users_device_login` VALUES ('138', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '51447', 'es-es', '0', '2011-12-14 12:05:08');
INSERT INTO `users_device_login` VALUES ('139', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '60303', 'en-us', '0', '2011-12-14 16:33:36');
INSERT INTO `users_device_login` VALUES ('140', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '60605', 'en-us', '0', '2011-12-14 16:47:15');
INSERT INTO `users_device_login` VALUES ('141', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '60675', 'en-us', '0', '2011-12-14 16:52:23');
INSERT INTO `users_device_login` VALUES ('142', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5', '192.168.1.142', '', '59747', 'en-us', '1', '2011-12-15 09:15:09');
INSERT INTO `users_device_login` VALUES ('143', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5', '192.168.1.142', '', '59844', 'en-us', '1', '2011-12-15 09:24:49');
INSERT INTO `users_device_login` VALUES ('144', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '46054', 'en-us', '0', '2011-12-15 11:09:20');
INSERT INTO `users_device_login` VALUES ('145', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '51200', 'en-us', '0', '2011-12-15 14:24:35');
INSERT INTO `users_device_login` VALUES ('146', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '62067', 'es-es', '0', '2011-12-16 09:31:47');
INSERT INTO `users_device_login` VALUES ('147', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '39397', 'en-us', '0', '2011-12-16 11:11:54');
INSERT INTO `users_device_login` VALUES ('148', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '40766', 'en-us', '0', '2011-12-16 13:58:01');
INSERT INTO `users_device_login` VALUES ('149', '111', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '41688', 'en-us', '0', '2011-12-16 14:48:37');
INSERT INTO `users_device_login` VALUES ('150', '111', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '41691', 'en-us', '0', '2011-12-16 14:48:38');
INSERT INTO `users_device_login` VALUES ('151', '101', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.9.168 Version/11.52', '192.168.1.141', '', '50861', 'en-US', '0', '2011-12-16 15:02:18');
INSERT INTO `users_device_login` VALUES ('152', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '42179', 'en-us', '0', '2011-12-16 15:12:15');
INSERT INTO `users_device_login` VALUES ('153', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '54674', 'es-es', '0', '2011-12-20 14:40:41');
INSERT INTO `users_device_login` VALUES ('154', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '53375', 'en-us', '0', '2011-12-22 09:13:31');
INSERT INTO `users_device_login` VALUES ('155', '2', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.133', '', '49338', 'en-us', '1', '2011-12-22 09:17:39');
INSERT INTO `users_device_login` VALUES ('156', '7', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.133', '', '49894', 'en-us', '1', '2011-12-22 10:35:52');
INSERT INTO `users_device_login` VALUES ('157', '7', 'Mozilla/5.0 (iPad; U; CPU OS 3_2_2 like Mac OS X; zh-cn) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B500 Safari/531.21.10', '192.168.1.136', '', '38215', 'en-US', '1', '2011-12-22 11:23:44');
INSERT INTO `users_device_login` VALUES ('158', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '59224', 'en-us', '0', '2011-12-23 14:08:18');
INSERT INTO `users_device_login` VALUES ('159', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '57228', 'en-us', '0', '2011-12-26 11:10:21');
INSERT INTO `users_device_login` VALUES ('160', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '51436', 'es-es', '0', '2011-12-26 11:41:10');
INSERT INTO `users_device_login` VALUES ('161', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '58569', 'en-us', '0', '2011-12-27 10:08:56');
INSERT INTO `users_device_login` VALUES ('162', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57079', 'en-us', '0', '2011-12-27 12:07:18');
INSERT INTO `users_device_login` VALUES ('163', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '55600', 'es-es', '0', '2011-12-27 12:22:07');
INSERT INTO `users_device_login` VALUES ('164', '84', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.140', '', '57560', 'en-US', '0', '2011-12-27 12:41:58');
INSERT INTO `users_device_login` VALUES ('165', '7', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.134', '', '50083', 'en-us', '1', '2011-12-27 15:29:17');
INSERT INTO `users_device_login` VALUES ('166', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5', '192.168.1.140', '', '61000', 'en-us', '1', '2011-12-27 15:41:40');
INSERT INTO `users_device_login` VALUES ('167', '7', 'Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.10.229 Version/11.60', '192.168.1.140', '', '61205', 'en', '0', '2011-12-27 15:47:17');
INSERT INTO `users_device_login` VALUES ('168', '7', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0)', '192.168.1.140', '', '61371', 'en-us', '0', '2011-12-27 15:54:10');
INSERT INTO `users_device_login` VALUES ('169', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '33878', 'en-us', '0', '2011-12-27 16:34:42');
INSERT INTO `users_device_login` VALUES ('170', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '54115', 'en-us', '0', '2011-12-28 14:52:19');
INSERT INTO `users_device_login` VALUES ('171', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '60717', 'en-us', '0', '2011-12-28 14:52:56');
INSERT INTO `users_device_login` VALUES ('172', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '32914', 'en-us', '0', '2011-12-28 15:21:49');
INSERT INTO `users_device_login` VALUES ('173', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '49984', 'en-us', '0', '2012-01-03 10:51:40');
INSERT INTO `users_device_login` VALUES ('174', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '53095', 'en-us', '0', '2012-01-04 16:58:41');
INSERT INTO `users_device_login` VALUES ('175', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '54831', 'en-us', '0', '2012-01-04 16:59:23');
INSERT INTO `users_device_login` VALUES ('176', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41356', 'en-us', '0', '2012-01-04 16:59:54');
INSERT INTO `users_device_login` VALUES ('177', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '53125', 'en-us', '0', '2012-01-04 17:03:09');
INSERT INTO `users_device_login` VALUES ('178', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '49184', 'es-es', '0', '2012-01-04 17:03:31');
INSERT INTO `users_device_login` VALUES ('179', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41397', 'en-us', '0', '2012-01-04 17:05:30');
INSERT INTO `users_device_login` VALUES ('180', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41429', 'en-us', '0', '2012-01-04 17:09:41');
INSERT INTO `users_device_login` VALUES ('181', '85', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '54975', 'en-us', '0', '2012-01-04 17:13:04');
INSERT INTO `users_device_login` VALUES ('182', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '54982', 'en-us', '0', '2012-01-04 17:13:47');
INSERT INTO `users_device_login` VALUES ('183', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '55042', 'en-us', '0', '2012-01-04 17:19:04');
INSERT INTO `users_device_login` VALUES ('184', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '50389', 'es-es', '0', '2012-01-05 09:54:00');
INSERT INTO `users_device_login` VALUES ('185', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '50601', 'es-es', '0', '2012-01-05 10:10:47');
INSERT INTO `users_device_login` VALUES ('186', '118', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '58048', 'en-us', '0', '2012-01-05 11:56:23');
INSERT INTO `users_device_login` VALUES ('187', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '52051', 'es-es', '0', '2012-01-05 14:08:26');
INSERT INTO `users_device_login` VALUES ('188', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '56341', 'en-us', '0', '2012-01-05 15:42:38');
INSERT INTO `users_device_login` VALUES ('189', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '56341', 'en-us', '0', '2012-01-05 15:42:55');
INSERT INTO `users_device_login` VALUES ('190', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '59811', 'en-us', '0', '2012-01-06 10:58:59');
INSERT INTO `users_device_login` VALUES ('191', '118', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '63951', 'en-us', '0', '2012-01-06 14:43:54');
INSERT INTO `users_device_login` VALUES ('192', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '60520', 'es-es', '0', '2012-01-06 15:36:23');
INSERT INTO `users_device_login` VALUES ('193', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '39193', 'en-us', '0', '2012-01-06 15:36:59');
INSERT INTO `users_device_login` VALUES ('194', '85', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '60544', 'es-es', '0', '2012-01-06 15:38:00');
INSERT INTO `users_device_login` VALUES ('195', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '50902', 'es-es', '0', '2012-01-09 13:11:22');
INSERT INTO `users_device_login` VALUES ('196', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '50936', 'es-es', '0', '2012-01-09 13:18:21');
INSERT INTO `users_device_login` VALUES ('197', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '52585', 'es-es', '0', '2012-01-09 15:11:23');
INSERT INTO `users_device_login` VALUES ('198', '84', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.123', '', '33351', 'en-us', '0', '2012-01-09 16:10:57');
INSERT INTO `users_device_login` VALUES ('199', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7', '192.168.1.139', '', '53560', 'en-US', '0', '2012-01-09 16:45:43');
INSERT INTO `users_device_login` VALUES ('200', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '54593', 'en-us', '0', '2012-01-10 14:59:52');
INSERT INTO `users_device_login` VALUES ('201', '101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7', '192.168.1.139', '', '56339', 'en-US', '0', '2012-01-11 09:34:14');
INSERT INTO `users_device_login` VALUES ('202', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '52172', 'es-es', '0', '2012-01-12 14:28:06');
INSERT INTO `users_device_login` VALUES ('203', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '47413', 'en-us', '0', '2012-01-12 15:47:15');
INSERT INTO `users_device_login` VALUES ('204', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7', '192.168.1.140', '', '50237', 'en-US', '0', '2012-01-13 09:29:42');
INSERT INTO `users_device_login` VALUES ('205', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.52.7 (KHTML, like Gecko) Version/5.1.2 Safari/534.52.7', '192.168.1.140', '', '50273', 'en-us', '0', '2012-01-13 09:30:47');
INSERT INTO `users_device_login` VALUES ('206', '7', 'Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.10.229 Version/11.60', '192.168.1.140', '', '50304', 'en', '0', '2012-01-13 09:31:20');
INSERT INTO `users_device_login` VALUES ('207', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '51447', 'es-es', '0', '2012-01-16 10:30:45');
INSERT INTO `users_device_login` VALUES ('208', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '52647', 'es-es', '0', '2012-01-16 12:05:20');
INSERT INTO `users_device_login` VALUES ('209', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '52550', 'en-us', '0', '2012-01-16 14:34:19');
INSERT INTO `users_device_login` VALUES ('210', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '51370', 'es-es', '0', '2012-01-17 09:08:36');
INSERT INTO `users_device_login` VALUES ('211', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5', '192.168.1.142', '', '51637', 'en-us', '1', '2012-01-17 11:54:53');
INSERT INTO `users_device_login` VALUES ('212', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7', '192.168.1.139', '', '52443', 'en-US', '0', '2012-01-17 12:03:22');
INSERT INTO `users_device_login` VALUES ('213', '7', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.128', '', '51653', 'en-us', '1', '2012-01-17 16:19:05');
INSERT INTO `users_device_login` VALUES ('214', '84', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7', '192.168.1.139', '', '50408', 'en-US', '0', '2012-01-18 09:19:50');
INSERT INTO `users_device_login` VALUES ('215', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '50417', 'es-es', '0', '2012-01-18 09:20:21');
INSERT INTO `users_device_login` VALUES ('216', '118', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.52.7 (KHTML, like Gecko) Version/5.1.2 Safari/534.52.7', '192.168.1.139', '', '50467', 'en-us', '0', '2012-01-18 09:22:35');
INSERT INTO `users_device_login` VALUES ('217', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.52.7 (KHTML, like Gecko) Version/5.1.2 Safari/534.52.7', '192.168.1.139', '', '50505', 'en-us', '0', '2012-01-18 09:24:58');
INSERT INTO `users_device_login` VALUES ('218', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '53426', 'en-us', '0', '2012-01-18 09:50:28');
INSERT INTO `users_device_login` VALUES ('219', '2', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.2)', '192.168.1.139', '', '52616', 'en-us', '0', '2012-01-18 11:29:20');
INSERT INTO `users_device_login` VALUES ('220', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '51533', 'en-us', '0', '2012-01-19 10:49:03');
INSERT INTO `users_device_login` VALUES ('221', '84', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7', '192.168.1.140', '', '52208', 'en-US', '0', '2012-01-20 10:47:11');
INSERT INTO `users_device_login` VALUES ('222', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7', '192.168.1.139', '', '53625', 'en-US', '0', '2012-01-20 14:26:43');
INSERT INTO `users_device_login` VALUES ('223', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '51135', 'en-us', '0', '2012-01-20 15:29:02');
INSERT INTO `users_device_login` VALUES ('224', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '51723', 'es-es', '0', '2012-01-23 08:57:41');
INSERT INTO `users_device_login` VALUES ('225', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '51728', 'es-es', '0', '2012-01-23 08:57:54');
INSERT INTO `users_device_login` VALUES ('226', '2', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.147', '', '52566', 'en-us', '1', '2012-01-23 10:55:29');
INSERT INTO `users_device_login` VALUES ('227', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5', '192.168.1.140', '', '59715', 'en-us', '1', '2012-01-23 15:05:51');
INSERT INTO `users_device_login` VALUES ('228', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5', '192.168.1.142', '', '59505', 'en-us', '1', '2012-01-23 15:38:33');
INSERT INTO `users_device_login` VALUES ('229', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '54760', 'en-us', '0', '2012-01-24 09:34:41');
INSERT INTO `users_device_login` VALUES ('230', '101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7', '192.168.1.139', '', '57951', 'en-US', '0', '2012-01-24 09:35:18');
INSERT INTO `users_device_login` VALUES ('231', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7', '192.168.1.139', '', '58132', 'en-US', '0', '2012-01-24 09:48:06');
INSERT INTO `users_device_login` VALUES ('232', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.75 Safari/535.7', '192.168.1.139', '', '58156', 'en-US', '0', '2012-01-24 09:52:02');
INSERT INTO `users_device_login` VALUES ('233', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '37011', 'en-us', '0', '2012-01-24 14:59:06');
INSERT INTO `users_device_login` VALUES ('234', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '65089', 'es-es', '0', '2012-01-25 09:45:41');
INSERT INTO `users_device_login` VALUES ('235', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', '192.168.1.139', '', '51138', 'en-US', '0', '2012-01-25 13:10:21');
INSERT INTO `users_device_login` VALUES ('236', '2', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.111', '', '53444', 'en-us', '1', '2012-01-26 09:41:07');
INSERT INTO `users_device_login` VALUES ('237', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41724', 'en-us', '0', '2012-01-26 13:53:14');
INSERT INTO `users_device_login` VALUES ('238', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', '192.168.1.139', '', '57860', 'en-US', '0', '2012-01-26 15:14:10');
INSERT INTO `users_device_login` VALUES ('239', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '58703', 'en-us', '0', '2012-01-27 09:24:52');
INSERT INTO `users_device_login` VALUES ('240', '7', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '58737', 'en-us', '0', '2012-01-27 09:27:38');
INSERT INTO `users_device_login` VALUES ('241', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '58922', 'en-us', '0', '2012-01-27 09:41:41');
INSERT INTO `users_device_login` VALUES ('242', '7', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '59000', 'en-us', '0', '2012-01-27 09:58:04');
INSERT INTO `users_device_login` VALUES ('243', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '52429', 'es-es', '0', '2012-01-27 12:44:53');
INSERT INTO `users_device_login` VALUES ('244', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '60439', 'en-us', '0', '2012-01-27 12:59:38');
INSERT INTO `users_device_login` VALUES ('245', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '49906', 'es-es', '0', '2012-01-30 09:39:06');
INSERT INTO `users_device_login` VALUES ('246', '124', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0) Gecko/20100101 Firefox/10.0', '192.168.1.125', '', '45581', 'es-MX', '0', '2012-01-30 13:44:26');
INSERT INTO `users_device_login` VALUES ('247', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '59867', 'en-us', '0', '2012-01-30 14:09:13');
INSERT INTO `users_device_login` VALUES ('248', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '40600', 'en-us', '0', '2012-01-30 14:21:41');
INSERT INTO `users_device_login` VALUES ('249', '7', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41683', 'en-us', '0', '2012-01-30 15:32:47');
INSERT INTO `users_device_login` VALUES ('250', '2', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41690', 'en-us', '0', '2012-01-30 15:33:13');
INSERT INTO `users_device_login` VALUES ('251', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41690', 'en-us', '0', '2012-01-30 15:34:12');
INSERT INTO `users_device_login` VALUES ('252', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '34034', 'en-us', '0', '2012-01-30 16:25:16');
INSERT INTO `users_device_login` VALUES ('253', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '50166', 'en-us', '0', '2012-01-31 09:18:34');
INSERT INTO `users_device_login` VALUES ('254', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '53207', 'en-us', '0', '2012-01-31 10:15:44');
INSERT INTO `users_device_login` VALUES ('255', '101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', '192.168.1.139', '', '56109', 'en-US', '0', '2012-01-31 10:23:13');
INSERT INTO `users_device_login` VALUES ('256', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '57839', 'en-us', '0', '2012-01-31 10:28:55');
INSERT INTO `users_device_login` VALUES ('257', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '58258', 'en-us', '0', '2012-01-31 10:29:35');
INSERT INTO `users_device_login` VALUES ('258', '2', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.148', '', '54332', 'en-us', '1', '2012-01-31 13:46:59');
INSERT INTO `users_device_login` VALUES ('259', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '60512', 'en-us', '0', '2012-01-31 15:40:06');
INSERT INTO `users_device_login` VALUES ('260', '2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '48149', 'en-US', '0', '2012-01-31 15:49:02');
INSERT INTO `users_device_login` VALUES ('261', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '47972', 'en-us', '0', '2012-01-31 16:00:38');
INSERT INTO `users_device_login` VALUES ('262', '2', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '48322', 'en-us', '0', '2012-01-31 16:24:32');
INSERT INTO `users_device_login` VALUES ('263', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '48336', 'en-us', '0', '2012-01-31 16:26:04');
INSERT INTO `users_device_login` VALUES ('264', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5', '192.168.1.142', '', '50933', 'en-us', '1', '2012-02-01 12:44:29');
INSERT INTO `users_device_login` VALUES ('265', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '56458', 'en-us', '0', '2012-02-01 16:16:06');
INSERT INTO `users_device_login` VALUES ('266', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '56634', 'en-us', '0', '2012-02-01 16:25:11');
INSERT INTO `users_device_login` VALUES ('267', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '56643', 'en-us', '0', '2012-02-01 16:26:06');
INSERT INTO `users_device_login` VALUES ('268', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '58441', 'en-us', '0', '2012-02-01 16:54:06');
INSERT INTO `users_device_login` VALUES ('269', '124', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0) Gecko/20100101 Firefox/10.0', '192.168.1.125', '', '43330', 'es-MX', '0', '2012-02-02 08:34:18');
INSERT INTO `users_device_login` VALUES ('270', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '55724', 'en-us', '0', '2012-02-02 09:54:45');
INSERT INTO `users_device_login` VALUES ('271', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '43544', 'en-us', '0', '2012-02-02 11:48:28');
INSERT INTO `users_device_login` VALUES ('272', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '59282', 'es-es', '0', '2012-02-02 11:55:44');
INSERT INTO `users_device_login` VALUES ('273', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '50933', 'en-us', '0', '2012-02-02 14:47:38');
INSERT INTO `users_device_login` VALUES ('274', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '50996', 'en-us', '0', '2012-02-02 14:49:34');
INSERT INTO `users_device_login` VALUES ('275', '7', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '58923', 'en-US', '0', '2012-02-02 16:05:59');
INSERT INTO `users_device_login` VALUES ('276', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '41179', 'en-us', '0', '2012-02-03 10:12:24');
INSERT INTO `users_device_login` VALUES ('277', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '41495', 'en-us', '0', '2012-02-03 10:40:40');
INSERT INTO `users_device_login` VALUES ('278', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '64359', 'en-us', '0', '2012-02-03 14:36:31');
INSERT INTO `users_device_login` VALUES ('279', '124', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', '192.168.1.125', '', '50794', 'es-419', '0', '2012-02-03 15:19:48');
INSERT INTO `users_device_login` VALUES ('280', '2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '50265', 'en-US', '0', '2012-02-03 15:26:03');
INSERT INTO `users_device_login` VALUES ('281', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '50166', 'es-es', '0', '2012-02-06 08:39:07');
INSERT INTO `users_device_login` VALUES ('282', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '40550', 'en-us', '0', '2012-02-06 08:50:53');
INSERT INTO `users_device_login` VALUES ('283', '2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '40626', 'en-US', '0', '2012-02-06 08:54:07');
INSERT INTO `users_device_login` VALUES ('284', '124', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0) Gecko/20100101 Firefox/10.0', '192.168.1.125', '', '50672', 'es-MX', '0', '2012-02-06 16:43:24');
INSERT INTO `users_device_login` VALUES ('285', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '56125', 'en-us', '0', '2012-02-07 09:03:34');
INSERT INTO `users_device_login` VALUES ('286', '84', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '62993', 'es-es', '0', '2012-02-07 17:01:50');
INSERT INTO `users_device_login` VALUES ('287', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '63013', 'es-es', '0', '2012-02-07 17:06:01');
INSERT INTO `users_device_login` VALUES ('288', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '63032', 'es-es', '0', '2012-02-07 17:06:42');
INSERT INTO `users_device_login` VALUES ('289', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '63043', 'es-es', '0', '2012-02-07 17:07:37');
INSERT INTO `users_device_login` VALUES ('290', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1', '192.168.1.123', '', '41011', 'en-us', '0', '2012-02-07 17:08:55');
INSERT INTO `users_device_login` VALUES ('291', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '56781', 'en-us', '0', '2012-02-08 11:02:19');
INSERT INTO `users_device_login` VALUES ('292', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '40437', 'en-us', '0', '2012-02-08 14:00:53');
INSERT INTO `users_device_login` VALUES ('293', '84', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7', '192.168.1.123', '', '58780', 'en-US', '0', '2012-02-08 14:22:41');
INSERT INTO `users_device_login` VALUES ('294', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0) Gecko/20100101 Firefox/10.0', '192.168.1.123', '', '45401', 'en-us', '0', '2012-02-08 15:21:22');
INSERT INTO `users_device_login` VALUES ('295', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '46529', 'en-us', '0', '2012-02-08 16:50:20');
INSERT INTO `users_device_login` VALUES ('296', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '58900', 'es-es', '0', '2012-02-10 09:44:11');
INSERT INTO `users_device_login` VALUES ('297', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '54103', 'en-us', '0', '2012-02-10 15:29:19');
INSERT INTO `users_device_login` VALUES ('298', '124', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.46 Safari/535.11', '192.168.1.125', '', '45587', 'es-419', '0', '2012-02-10 15:49:17');
INSERT INTO `users_device_login` VALUES ('299', '124', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:11.0) Gecko/20100101 Firefox/11.0', '192.168.1.125', '', '45835', 'es-MX', '0', '2012-02-10 16:01:42');
INSERT INTO `users_device_login` VALUES ('300', '124', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.46 Safari/535.11', '192.168.1.125', '', '58042', 'es-419', '0', '2012-02-13 09:25:53');
INSERT INTO `users_device_login` VALUES ('301', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57490', 'en-us', '0', '2012-02-13 09:32:29');
INSERT INTO `users_device_login` VALUES ('302', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57490', 'en-us', '0', '2012-02-13 09:32:39');
INSERT INTO `users_device_login` VALUES ('303', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '41129', 'en-US', '0', '2012-02-13 09:32:50');
INSERT INTO `users_device_login` VALUES ('304', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57492', 'en-us', '0', '2012-02-13 09:32:56');
INSERT INTO `users_device_login` VALUES ('305', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '41129', 'en-US', '0', '2012-02-13 09:33:00');
INSERT INTO `users_device_login` VALUES ('306', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '41129', 'en-US', '0', '2012-02-13 09:33:12');
INSERT INTO `users_device_login` VALUES ('307', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57495', 'en-us', '0', '2012-02-13 09:33:25');
INSERT INTO `users_device_login` VALUES ('308', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57496', 'en-us', '0', '2012-02-13 09:33:41');
INSERT INTO `users_device_login` VALUES ('309', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '41154', 'en-US', '0', '2012-02-13 09:33:59');
INSERT INTO `users_device_login` VALUES ('310', '2', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41373', 'en-us', '0', '2012-02-13 09:41:50');
INSERT INTO `users_device_login` VALUES ('311', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '49804', 'es-es', '0', '2012-02-13 10:02:55');
INSERT INTO `users_device_login` VALUES ('312', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.140', '', '57977', 'en-us', '0', '2012-02-13 12:16:59');
INSERT INTO `users_device_login` VALUES ('313', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '38422', 'en-US', '0', '2012-02-14 11:35:41');
INSERT INTO `users_device_login` VALUES ('314', '124', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:11.0) Gecko/20100101 Firefox/11.0', '192.168.1.125', '', '52326', 'es-MX', '0', '2012-02-14 13:35:49');
INSERT INTO `users_device_login` VALUES ('315', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '59692', 'en-us', '0', '2012-02-15 09:00:51');
INSERT INTO `users_device_login` VALUES ('316', '125', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '59800', 'en-us', '0', '2012-02-15 09:15:44');
INSERT INTO `users_device_login` VALUES ('317', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '59860', 'en-US', '0', '2012-02-15 09:18:20');
INSERT INTO `users_device_login` VALUES ('318', '2', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '60040', 'en-US', '0', '2012-02-15 09:34:58');
INSERT INTO `users_device_login` VALUES ('319', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '61269', 'es-es', '0', '2012-02-15 11:25:48');
INSERT INTO `users_device_login` VALUES ('320', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.46 Safari/535.11', '192.168.1.139', '', '63666', 'en-US', '0', '2012-02-15 14:45:39');
INSERT INTO `users_device_login` VALUES ('321', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '40928', 'en-US', '0', '2012-02-16 11:52:00');
INSERT INTO `users_device_login` VALUES ('322', '2', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '40986', 'en-us', '0', '2012-02-16 11:54:17');
INSERT INTO `users_device_login` VALUES ('323', '125', 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '49714', 'en-us', '0', '2012-02-16 13:46:14');
INSERT INTO `users_device_login` VALUES ('324', '2', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '47740', 'en-us', '0', '2012-02-16 13:59:27');
INSERT INTO `users_device_login` VALUES ('325', '7', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '47891', 'en-us', '0', '2012-02-16 14:00:57');
INSERT INTO `users_device_login` VALUES ('326', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '48093', 'en-US', '0', '2012-02-16 14:06:28');
INSERT INTO `users_device_login` VALUES ('327', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.1) Gecko/20100101 Firefox/10.0.1', '192.168.1.140', '', '54557', 'en-us', '0', '2012-02-16 14:22:52');
INSERT INTO `users_device_login` VALUES ('328', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '60289', 'en-US', '0', '2012-02-17 11:19:46');
INSERT INTO `users_device_login` VALUES ('329', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '60334', 'en-us', '0', '2012-02-17 11:21:23');
INSERT INTO `users_device_login` VALUES ('330', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.1) Gecko/20100101 Firefox/10.0.1', '192.168.1.140', '', '50898', 'en-us', '0', '2012-02-17 12:21:42');
INSERT INTO `users_device_login` VALUES ('331', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:8.0.1) Gecko/20100101 Firefox/8.0.1', '192.168.1.139', '', '63654', 'es-es', '0', '2012-02-17 14:59:17');
INSERT INTO `users_device_login` VALUES ('332', '124', 'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1', '192.168.1.125', '', '35265', 'es-cl', '0', '2012-02-17 14:59:30');
INSERT INTO `users_device_login` VALUES ('333', '124', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.125', '', '51176', 'es-es', '0', '2012-02-22 09:29:39');
INSERT INTO `users_device_login` VALUES ('334', '83', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.1) Gecko/20100101 Firefox/10.0.1', '192.168.1.123', '', '59402', 'en-us', '0', '2012-02-22 09:40:55');
INSERT INTO `users_device_login` VALUES ('335', '126', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.1) Gecko/20100101 Firefox/10.0.1', '192.168.1.123', '', '59448', 'en-us', '0', '2012-02-22 09:46:50');
INSERT INTO `users_device_login` VALUES ('336', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.1) Gecko/20100101 Firefox/10.0.1', '192.168.1.139', '', '52834', 'es-es', '0', '2012-02-22 10:41:20');
INSERT INTO `users_device_login` VALUES ('337', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.125', '', '49391', 'es-MX', '0', '2012-02-23 14:09:50');
INSERT INTO `users_device_login` VALUES ('338', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '51939', 'en-us', '0', '2012-02-23 15:46:32');
INSERT INTO `users_device_login` VALUES ('339', '7', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.123', '', '39607', 'en-US', '0', '2012-02-23 15:57:45');
INSERT INTO `users_device_login` VALUES ('340', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '39960', 'en-us', '0', '2012-02-23 16:07:04');
INSERT INTO `users_device_login` VALUES ('341', '7', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.111', '', '58002', 'en-us', '1', '2012-02-23 16:29:44');
INSERT INTO `users_device_login` VALUES ('342', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '46563', 'en-us', '0', '2012-02-24 10:31:44');
INSERT INTO `users_device_login` VALUES ('343', '2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '46582', 'en-US', '0', '2012-02-24 10:32:08');
INSERT INTO `users_device_login` VALUES ('344', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '56754', 'es-es', '0', '2012-02-24 11:57:03');
INSERT INTO `users_device_login` VALUES ('345', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '42740', 'en-us', '0', '2012-02-24 13:50:29');
INSERT INTO `users_device_login` VALUES ('346', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '51515', 'en-us', '0', '2012-02-24 13:58:16');
INSERT INTO `users_device_login` VALUES ('347', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '43858', 'en-us', '0', '2012-02-24 14:00:08');
INSERT INTO `users_device_login` VALUES ('348', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '61018', 'es-es', '0', '2012-02-24 15:38:05');
INSERT INTO `users_device_login` VALUES ('349', '101', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '46235', 'en-us', '0', '2012-02-24 16:08:51');
INSERT INTO `users_device_login` VALUES ('350', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '46251', 'en-us', '0', '2012-02-24 16:09:50');
INSERT INTO `users_device_login` VALUES ('351', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '51858', 'es-es', '0', '2012-02-27 11:53:25');
INSERT INTO `users_device_login` VALUES ('352', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '49353', 'en-us', '0', '2012-02-27 14:07:09');
INSERT INTO `users_device_login` VALUES ('353', '2', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '38403', 'en-US', '0', '2012-02-28 09:00:06');
INSERT INTO `users_device_login` VALUES ('354', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '38426', 'en-us', '0', '2012-02-28 09:00:47');
INSERT INTO `users_device_login` VALUES ('355', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '33208', 'en-us', '0', '2012-02-28 11:56:07');
INSERT INTO `users_device_login` VALUES ('356', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '64209', 'es-es', '0', '2012-02-28 14:43:01');
INSERT INTO `users_device_login` VALUES ('357', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '50882', 'es-es', '0', '2012-02-28 17:28:57');
INSERT INTO `users_device_login` VALUES ('358', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '52771', 'en-us', '0', '2012-02-29 10:25:20');
INSERT INTO `users_device_login` VALUES ('359', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '55634', 'es-es', '0', '2012-02-29 12:53:22');
INSERT INTO `users_device_login` VALUES ('360', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '57572', 'en-us', '0', '2012-02-29 15:34:52');
INSERT INTO `users_device_login` VALUES ('361', '124', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5', '192.168.1.125', '', '57311', 'es-ES', '1', '2012-02-29 16:47:38');
INSERT INTO `users_device_login` VALUES ('362', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.125', '', '50044', 'es-ES', '0', '2012-03-01 09:11:50');
INSERT INTO `users_device_login` VALUES ('363', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41241', 'en-us', '0', '2012-03-01 09:12:02');
INSERT INTO `users_device_login` VALUES ('364', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '36570', 'en-us', '0', '2012-03-01 09:12:07');
INSERT INTO `users_device_login` VALUES ('365', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41282', 'en-us', '0', '2012-03-01 09:12:28');
INSERT INTO `users_device_login` VALUES ('366', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '36601', 'en-us', '0', '2012-03-01 09:12:50');
INSERT INTO `users_device_login` VALUES ('367', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.125', '', '50052', 'es-ES', '0', '2012-03-01 09:12:56');
INSERT INTO `users_device_login` VALUES ('368', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '36610', 'en-us', '0', '2012-03-01 09:13:12');
INSERT INTO `users_device_login` VALUES ('369', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.125', '', '50059', 'es-MX', '0', '2012-03-01 09:13:52');
INSERT INTO `users_device_login` VALUES ('370', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '36618', 'en-us', '0', '2012-03-01 09:14:13');
INSERT INTO `users_device_login` VALUES ('371', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '41308', 'en-us', '0', '2012-03-01 09:14:24');
INSERT INTO `users_device_login` VALUES ('372', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.125', '', '50178', 'es-ES', '0', '2012-03-01 09:14:59');
INSERT INTO `users_device_login` VALUES ('373', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '36796', 'en-us', '0', '2012-03-01 09:21:15');
INSERT INTO `users_device_login` VALUES ('374', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '41732', 'en-US', '0', '2012-03-01 09:34:55');
INSERT INTO `users_device_login` VALUES ('375', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '41783', 'en-US', '0', '2012-03-01 09:37:31');
INSERT INTO `users_device_login` VALUES ('376', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.125', '', '51044', 'es-ES', '0', '2012-03-01 09:40:15');
INSERT INTO `users_device_login` VALUES ('377', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.125', '', '56217', 'es-MX', '0', '2012-03-01 12:05:39');
INSERT INTO `users_device_login` VALUES ('378', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '39793', 'en-us', '0', '2012-03-01 12:15:20');
INSERT INTO `users_device_login` VALUES ('379', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '49642', 'es-es', '0', '2012-03-01 12:23:32');
INSERT INTO `users_device_login` VALUES ('380', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '50853', 'en-us', '0', '2012-03-01 13:35:54');
INSERT INTO `users_device_login` VALUES ('381', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '50861', 'en-us', '0', '2012-03-01 13:36:11');
INSERT INTO `users_device_login` VALUES ('382', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '50868', 'en-us', '0', '2012-03-01 13:36:39');
INSERT INTO `users_device_login` VALUES ('383', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.125', '', '59725', 'es-MX', '0', '2012-03-01 14:12:59');
INSERT INTO `users_device_login` VALUES ('384', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '43582', 'en-us', '0', '2012-03-01 15:23:49');
INSERT INTO `users_device_login` VALUES ('385', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '35196', 'en-US', '0', '2012-03-01 15:51:12');
INSERT INTO `users_device_login` VALUES ('386', '2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '54542', 'en-US', '0', '2012-03-02 09:21:28');
INSERT INTO `users_device_login` VALUES ('387', '2', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '54562', 'en-us', '0', '2012-03-02 09:22:53');
INSERT INTO `users_device_login` VALUES ('388', '2', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '54562', 'en-us', '0', '2012-03-02 09:22:58');
INSERT INTO `users_device_login` VALUES ('389', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '54572', 'en-us', '0', '2012-03-02 09:23:31');
INSERT INTO `users_device_login` VALUES ('390', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '54572', 'en-us', '0', '2012-03-02 09:23:34');
INSERT INTO `users_device_login` VALUES ('391', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '51211', 'en-us', '0', '2012-03-02 10:35:59');
INSERT INTO `users_device_login` VALUES ('392', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '60643', 'en-us', '0', '2012-03-02 13:44:14');
INSERT INTO `users_device_login` VALUES ('393', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '54408', 'en-us', '0', '2012-03-02 13:51:41');
INSERT INTO `users_device_login` VALUES ('394', '127', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '55209', 'en-us', '0', '2012-03-02 14:28:19');
INSERT INTO `users_device_login` VALUES ('395', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '55967', 'en-us', '0', '2012-03-02 14:59:22');
INSERT INTO `users_device_login` VALUES ('396', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '33160', 'en-us', '0', '2012-03-02 15:19:03');
INSERT INTO `users_device_login` VALUES ('397', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '55972', 'en-US', '0', '2012-03-05 08:39:33');
INSERT INTO `users_device_login` VALUES ('398', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '55983', 'en-us', '0', '2012-03-05 08:40:33');
INSERT INTO `users_device_login` VALUES ('399', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '55983', 'en-us', '0', '2012-03-05 08:40:37');
INSERT INTO `users_device_login` VALUES ('400', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.139', '', '49748', 'en-US', '0', '2012-03-05 08:41:20');
INSERT INTO `users_device_login` VALUES ('401', '2', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '56166', 'en-US', '0', '2012-03-05 08:46:31');
INSERT INTO `users_device_login` VALUES ('402', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '49482', 'en-us', '0', '2012-03-05 09:48:48');
INSERT INTO `users_device_login` VALUES ('403', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '58968', 'en-us', '0', '2012-03-05 10:22:09');
INSERT INTO `users_device_login` VALUES ('404', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148a Safari/6533.18.5', '192.168.1.142', '', '49945', 'en-us', '1', '2012-03-05 11:02:35');
INSERT INTO `users_device_login` VALUES ('405', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '51384', 'en-us', '0', '2012-03-05 11:27:30');
INSERT INTO `users_device_login` VALUES ('406', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '51322', 'es-es', '0', '2012-03-05 11:31:49');
INSERT INTO `users_device_login` VALUES ('407', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.125', '', '53671', 'es-ES', '0', '2012-03-05 14:40:50');
INSERT INTO `users_device_login` VALUES ('408', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '46127', 'en-us', '0', '2012-03-05 14:43:30');
INSERT INTO `users_device_login` VALUES ('409', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.125', '', '53901', 'es-ES', '0', '2012-03-05 15:07:31');
INSERT INTO `users_device_login` VALUES ('410', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.125', '', '53901', 'es-ES', '0', '2012-03-05 15:07:51');
INSERT INTO `users_device_login` VALUES ('411', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.125', '', '54052', 'es-ES', '0', '2012-03-05 15:18:39');
INSERT INTO `users_device_login` VALUES ('412', '124', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5', '192.168.1.125', '', '54110', 'es-ES', '1', '2012-03-05 15:21:04');
INSERT INTO `users_device_login` VALUES ('413', '124', 'Mozilla/5.0 (iPad; U; CPU OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5', '192.168.1.125', '', '54174', 'es-ES', '1', '2012-03-05 15:27:06');
INSERT INTO `users_device_login` VALUES ('414', '7', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.133', '', '58920', 'en-us', '1', '2012-03-05 15:27:08');
INSERT INTO `users_device_login` VALUES ('415', '7', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.133', '', '58935', 'en-us', '1', '2012-03-05 15:28:25');
INSERT INTO `users_device_login` VALUES ('416', '7', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.133', '', '58979', 'en-us', '1', '2012-03-05 15:29:39');
INSERT INTO `users_device_login` VALUES ('417', '7', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.133', '', '58992', 'en-us', '1', '2012-03-05 15:31:08');
INSERT INTO `users_device_login` VALUES ('418', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '54123', 'en-us', '0', '2012-03-05 15:32:22');
INSERT INTO `users_device_login` VALUES ('419', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '54140', 'en-us', '0', '2012-03-05 15:32:45');
INSERT INTO `users_device_login` VALUES ('420', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '54174', 'en-us', '0', '2012-03-05 15:33:07');
INSERT INTO `users_device_login` VALUES ('421', '124', 'Mozilla/5.0 (iPad; U; CPU OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5', '192.168.1.125', '', '54445', 'es-ES', '1', '2012-03-05 15:47:32');
INSERT INTO `users_device_login` VALUES ('422', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '48184', 'en-us', '0', '2012-03-05 16:06:12');
INSERT INTO `users_device_login` VALUES ('423', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '54969', 'es-es', '0', '2012-03-05 16:32:07');
INSERT INTO `users_device_login` VALUES ('424', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '55071', 'en-us', '0', '2012-03-06 08:45:58');
INSERT INTO `users_device_login` VALUES ('425', '130', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '50860', 'en-us', '0', '2012-03-06 09:30:33');
INSERT INTO `users_device_login` VALUES ('426', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '51501', 'en-us', '0', '2012-03-06 09:31:46');
INSERT INTO `users_device_login` VALUES ('427', '130', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '51504', 'en-us', '0', '2012-03-06 09:32:07');
INSERT INTO `users_device_login` VALUES ('428', '131', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '52402', 'en-us', '0', '2012-03-06 09:33:45');
INSERT INTO `users_device_login` VALUES ('429', '131', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '52507', 'en-us', '0', '2012-03-06 09:53:13');
INSERT INTO `users_device_login` VALUES ('430', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.52.7 (KHTML, like Gecko) Version/5.1.2 Safari/534.52.7', '192.168.1.125', '', '50979', 'es-ES', '0', '2012-03-06 11:53:45');
INSERT INTO `users_device_login` VALUES ('431', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '60553', 'en-us', '0', '2012-03-06 13:39:20');
INSERT INTO `users_device_login` VALUES ('432', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '60574', 'en-us', '0', '2012-03-06 13:41:42');
INSERT INTO `users_device_login` VALUES ('433', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '60662', 'es-es', '0', '2012-03-06 13:50:26');
INSERT INTO `users_device_login` VALUES ('434', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '61010', 'es-es', '0', '2012-03-06 14:10:04');
INSERT INTO `users_device_login` VALUES ('435', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.65 Safari/535.11', '192.168.1.139', '', '61042', 'en-US', '0', '2012-03-06 14:13:22');
INSERT INTO `users_device_login` VALUES ('436', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '61326', 'es-es', '0', '2012-03-06 14:33:10');
INSERT INTO `users_device_login` VALUES ('437', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '56978', 'en-US', '0', '2012-03-06 15:07:04');
INSERT INTO `users_device_login` VALUES ('438', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '36182', 'en-us', '0', '2012-03-06 16:10:06');
INSERT INTO `users_device_login` VALUES ('439', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.125', '', '55317', 'es-MX', '0', '2012-03-06 16:12:21');
INSERT INTO `users_device_login` VALUES ('440', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.125', '', '55369', 'es-MX', '0', '2012-03-06 16:18:29');
INSERT INTO `users_device_login` VALUES ('441', '157', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '37766', 'en-us', '0', '2012-03-06 16:20:36');
INSERT INTO `users_device_login` VALUES ('442', '125', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '37878', 'en-US', '0', '2012-03-06 16:29:07');
INSERT INTO `users_device_login` VALUES ('443', '101', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '37960', 'en-US', '0', '2012-03-06 16:31:04');
INSERT INTO `users_device_login` VALUES ('444', '131', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '37971', 'en-US', '0', '2012-03-06 16:31:25');
INSERT INTO `users_device_login` VALUES ('445', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.125', '', '55657', 'es-MX', '0', '2012-03-06 16:34:26');
INSERT INTO `users_device_login` VALUES ('446', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.125', '', '55667', 'es-MX', '0', '2012-03-06 16:34:51');
INSERT INTO `users_device_login` VALUES ('447', '157', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '38385', 'en-US', '0', '2012-03-06 16:37:44');
INSERT INTO `users_device_login` VALUES ('448', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11', '192.168.1.125', '', '55868', 'es-ES', '0', '2012-03-06 16:48:52');
INSERT INTO `users_device_login` VALUES ('449', '124', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5', '192.168.1.125', '', '56029', 'es-ES', '1', '2012-03-06 17:03:52');
INSERT INTO `users_device_login` VALUES ('450', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '47643', 'en-us', '0', '2012-03-07 08:26:12');
INSERT INTO `users_device_login` VALUES ('451', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '45981', 'en-us', '0', '2012-03-07 10:27:36');
INSERT INTO `users_device_login` VALUES ('452', '182', 'Mozilla/5.0 (iPad; U; CPU OS 3_2_2 like Mac OS X; zh-cn) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B500 Safari/531.21.10', '192.168.1.110', '', '40153', 'en-US', '1', '2012-03-07 10:38:04');
INSERT INTO `users_device_login` VALUES ('453', '157', 'Mozilla/5.0 (iPad; U; CPU OS 3_2_2 like Mac OS X; zh-cn) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B500 Safari/531.21.10', '192.168.1.110', '', '49536', 'en-US', '0', '2012-03-07 10:50:50');
INSERT INTO `users_device_login` VALUES ('454', '157', 'Mozilla/5.0 (iPad; U; CPU OS 3_2_2 like Mac OS X; zh-cn) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B500 Safari/531.21.10', '192.168.1.110', '', '32932', 'en-US', '0', '2012-03-07 10:52:33');
INSERT INTO `users_device_login` VALUES ('455', '7', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5', '192.168.1.140', '', '49491', 'en-us', '1', '2012-03-07 14:05:10');
INSERT INTO `users_device_login` VALUES ('456', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '47321', 'en-us', '0', '2012-03-07 15:18:39');
INSERT INTO `users_device_login` VALUES ('457', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '51893', 'en-us', '0', '2012-03-07 15:22:05');
INSERT INTO `users_device_login` VALUES ('458', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '38458', 'en-us', '0', '2012-03-07 16:55:03');
INSERT INTO `users_device_login` VALUES ('459', '2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '38486', 'en-US', '0', '2012-03-07 16:56:43');
INSERT INTO `users_device_login` VALUES ('460', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '32874', 'en-us', '0', '2012-03-08 08:58:16');
INSERT INTO `users_device_login` VALUES ('461', '2', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '32885', 'en-US', '0', '2012-03-08 08:58:42');
INSERT INTO `users_device_login` VALUES ('462', '103', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '32928', 'en-US', '0', '2012-03-08 09:01:02');
INSERT INTO `users_device_login` VALUES ('463', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '38004', 'en-us', '0', '2012-03-09 09:19:10');
INSERT INTO `users_device_login` VALUES ('464', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.78 Safari/535.11', '192.168.1.139', '', '50838', 'en-US', '0', '2012-03-09 11:36:15');
INSERT INTO `users_device_login` VALUES ('465', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '51179', 'es-es', '0', '2012-03-09 11:50:28');
INSERT INTO `users_device_login` VALUES ('466', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '57575', 'en-us', '0', '2012-03-12 08:44:35');
INSERT INTO `users_device_login` VALUES ('467', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '55600', 'en-us', '0', '2012-03-13 08:57:18');
INSERT INTO `users_device_login` VALUES ('468', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '39623', 'en-us', '0', '2012-03-13 15:53:08');
INSERT INTO `users_device_login` VALUES ('469', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.140', '', '57809', 'en-us', '0', '2012-03-14 10:34:18');
INSERT INTO `users_device_login` VALUES ('470', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '58752', 'en-us', '0', '2012-03-14 13:43:32');
INSERT INTO `users_device_login` VALUES ('471', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '58769', 'en-us', '0', '2012-03-14 13:44:52');
INSERT INTO `users_device_login` VALUES ('472', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '58819', 'en-us', '0', '2012-03-14 13:51:49');
INSERT INTO `users_device_login` VALUES ('473', '84', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11', '192.168.1.123', '', '44062', 'en-US', '0', '2012-03-14 14:13:20');
INSERT INTO `users_device_login` VALUES ('474', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11', '192.168.1.125', '', '57618', 'es-ES', '0', '2012-03-14 14:14:21');
INSERT INTO `users_device_login` VALUES ('475', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '59372', 'en-US', '0', '2012-03-14 14:43:09');
INSERT INTO `users_device_login` VALUES ('476', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.123', '', '44147', 'en-us', '0', '2012-03-14 14:43:57');
INSERT INTO `users_device_login` VALUES ('477', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '59550', 'en-us', '0', '2012-03-14 15:01:29');
INSERT INTO `users_device_login` VALUES ('478', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '59564', 'en-US', '0', '2012-03-14 15:04:02');
INSERT INTO `users_device_login` VALUES ('479', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '59567', 'en-us', '0', '2012-03-14 15:04:27');
INSERT INTO `users_device_login` VALUES ('480', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '57421', 'es-es', '0', '2012-03-14 15:09:27');
INSERT INTO `users_device_login` VALUES ('481', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11', '192.168.1.139', '', '57732', 'en-US', '0', '2012-03-14 15:56:59');
INSERT INTO `users_device_login` VALUES ('482', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11', '192.168.1.139', '', '61056', 'en-US', '0', '2012-03-15 11:46:03');
INSERT INTO `users_device_login` VALUES ('483', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:10.0.2) Gecko/20100101 Firefox/10.0.2', '192.168.1.139', '', '62155', 'es-es', '0', '2012-03-15 14:24:20');
INSERT INTO `users_device_login` VALUES ('484', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '44883', 'en-us', '0', '2012-03-16 11:38:31');
INSERT INTO `users_device_login` VALUES ('485', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11', '192.168.1.140', '', '63046', 'en-US', '0', '2012-03-16 12:01:50');
INSERT INTO `users_device_login` VALUES ('486', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '47767', 'en-us', '0', '2012-03-16 15:16:17');
INSERT INTO `users_device_login` VALUES ('487', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:11.0) Gecko/20100101 Firefox/11.0', '192.168.1.123', '', '43599', 'en-us', '0', '2012-03-19 13:45:30');
INSERT INTO `users_device_login` VALUES ('488', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:11.0) Gecko/20100101 Firefox/11.0', '192.168.1.123', '', '44827', 'en-us', '0', '2012-03-19 13:48:35');
INSERT INTO `users_device_login` VALUES ('489', '2', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.133', '', '51434', 'en-us', '1', '2012-03-20 11:16:10');
INSERT INTO `users_device_login` VALUES ('490', '101', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.133', '', '51694', 'en-us', '1', '2012-03-20 12:10:36');
INSERT INTO `users_device_login` VALUES ('491', '101', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.133', '', '51736', 'en-us', '1', '2012-03-20 16:31:54');
INSERT INTO `users_device_login` VALUES ('492', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '58165', 'en-us', '0', '2012-03-20 16:32:52');
INSERT INTO `users_device_login` VALUES ('493', '2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '59720', 'en-US', '0', '2012-03-21 13:47:46');
INSERT INTO `users_device_login` VALUES ('494', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '58049', 'en-US', '0', '2012-03-22 11:55:57');
INSERT INTO `users_device_login` VALUES ('495', '2', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '58104', 'en-US', '0', '2012-03-22 11:56:56');
INSERT INTO `users_device_login` VALUES ('496', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11', '192.168.1.140', '', '52850', 'en-US', '0', '2012-03-22 12:10:17');
INSERT INTO `users_device_login` VALUES ('497', '103', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11', '192.168.1.140', '', '52888', 'en-US', '0', '2012-03-22 12:20:55');
INSERT INTO `users_device_login` VALUES ('498', '7', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '59496', 'en-US', '0', '2012-03-22 13:37:59');
INSERT INTO `users_device_login` VALUES ('499', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11', '192.168.1.139', '', '62911', 'en-US', '0', '2012-03-22 14:51:24');
INSERT INTO `users_device_login` VALUES ('500', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.83 Safari/535.11', '192.168.1.139', '', '63331', 'en-US', '0', '2012-03-22 15:23:42');
INSERT INTO `users_device_login` VALUES ('501', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.142 Safari/535.19', '192.168.1.125', '', '51041', 'es-ES', '0', '2012-03-29 10:09:00');
INSERT INTO `users_device_login` VALUES ('502', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:11.0) Gecko/20100101 Firefox/11.0', '192.168.1.123', '', '33509', 'en-us', '0', '2012-03-29 10:11:20');
INSERT INTO `users_device_login` VALUES ('503', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '38082', 'en-US', '0', '2012-03-29 10:42:25');
INSERT INTO `users_device_login` VALUES ('504', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:11.0) Gecko/20100101 Firefox/11.0', '192.168.1.123', '', '54609', 'en-us', '0', '2012-03-29 15:30:10');
INSERT INTO `users_device_login` VALUES ('505', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.83 Safari/535.11', '192.168.1.140', '', '57407', 'en-US', '0', '2012-03-29 16:01:59');
INSERT INTO `users_device_login` VALUES ('506', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.83 Safari/535.11', '192.168.1.140', '', '57415', 'en-US', '0', '2012-03-29 16:02:28');
INSERT INTO `users_device_login` VALUES ('507', '124', 'Opera/9.80 (Windows NT 6.1; U; es-ES) Presto/2.10.229 Version/11.61', '127.0.0.1', '', '58816', 'es-VE', '0', '2012-03-29 16:26:27');
INSERT INTO `users_device_login` VALUES ('508', '124', 'Opera/9.80 (Windows NT 6.1; U; es-ES) Presto/2.10.229 Version/11.61', '127.0.0.1', '', '58920', 'es-VE', '0', '2012-03-29 16:29:38');
INSERT INTO `users_device_login` VALUES ('509', '2', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '::1', '', '60548', 'en-us', '0', '2012-03-30 12:50:32');
INSERT INTO `users_device_login` VALUES ('510', '101', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '127.0.0.1', '', '48857', 'en-US', '0', '2012-03-30 14:56:51');
INSERT INTO `users_device_login` VALUES ('511', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.142 Safari/535.19', '127.0.0.1', '', '57397', 'en-US', '0', '2012-03-30 16:09:31');
INSERT INTO `users_device_login` VALUES ('512', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.142 Safari/535.19', '127.0.0.1', '', '62575', 'en-US', '0', '2012-04-02 09:36:16');
INSERT INTO `users_device_login` VALUES ('513', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '::1', '', '44590', 'en-us', '0', '2012-04-02 09:36:37');
INSERT INTO `users_device_login` VALUES ('514', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '44664', 'en-US', '0', '2012-04-02 09:37:42');
INSERT INTO `users_device_login` VALUES ('515', '84', 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.10.229 Version/11.60', '127.0.0.1', '', '59450', 'en-US', '0', '2012-04-02 11:03:06');
INSERT INTO `users_device_login` VALUES ('516', '7', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '46069', 'en-US', '0', '2012-04-02 11:21:18');
INSERT INTO `users_device_login` VALUES ('517', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '46654', 'en-US', '0', '2012-04-02 11:58:48');
INSERT INTO `users_device_login` VALUES ('518', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '46857', 'en-US', '0', '2012-04-02 12:15:29');
INSERT INTO `users_device_login` VALUES ('519', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '60010', 'en-US', '0', '2012-04-02 14:51:06');
INSERT INTO `users_device_login` VALUES ('520', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '60580', 'en-US', '0', '2012-04-02 15:52:03');
INSERT INTO `users_device_login` VALUES ('521', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '::1', '', '60586', 'en-us', '0', '2012-04-02 15:52:09');
INSERT INTO `users_device_login` VALUES ('522', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '33028', 'en-US', '0', '2012-04-02 16:28:30');
INSERT INTO `users_device_login` VALUES ('523', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '46522', 'en-US', '0', '2012-04-03 09:57:38');
INSERT INTO `users_device_login` VALUES ('524', '7', 'Opera/9.80 (X11; Linux x86_64; U; es-ES) Presto/2.10.229 Version/11.60', '127.0.0.1', '', '43542', 'es-ES', '0', '2012-04-03 10:20:23');
INSERT INTO `users_device_login` VALUES ('525', '2', 'Opera/9.80 (X11; Linux x86_64; U; es-ES) Presto/2.10.229 Version/11.60', '127.0.0.1', '', '43740', 'es-ES', '0', '2012-04-03 10:31:30');
INSERT INTO `users_device_login` VALUES ('526', '7', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '47345', 'en-US', '0', '2012-04-03 10:40:49');
INSERT INTO `users_device_login` VALUES ('527', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '::1', '', '60542', 'en-us', '0', '2012-04-09 09:18:09');
INSERT INTO `users_device_login` VALUES ('528', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '60574', 'en-US', '0', '2012-04-09 09:18:28');
INSERT INTO `users_device_login` VALUES ('529', '2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '60672', 'en-US', '0', '2012-04-09 09:21:34');
INSERT INTO `users_device_login` VALUES ('530', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '43352', 'en-us', '0', '2012-04-09 09:44:07');
INSERT INTO `users_device_login` VALUES ('531', '2', 'Opera/9.80 (X11; Linux x86_64; U; es-ES) Presto/2.10.229 Version/11.60', '127.0.0.1', '', '40445', 'es-ES', '0', '2012-04-09 09:45:35');
INSERT INTO `users_device_login` VALUES ('532', '2', 'Opera/9.80 (X11; Linux x86_64; U; es-ES) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '43662', 'es-ES', '0', '2012-04-09 09:58:30');
INSERT INTO `users_device_login` VALUES ('533', '7', 'Opera/9.80 (X11; Linux x86_64; U; es-ES) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '43690', 'es-ES', '0', '2012-04-09 09:59:20');
INSERT INTO `users_device_login` VALUES ('534', '157', 'Opera/9.80 (X11; Linux x86_64; U; es-ES) Presto/2.10.229 Version/11.60', '192.168.1.141', '', '43762', 'es-ES', '0', '2012-04-09 10:02:49');
INSERT INTO `users_device_login` VALUES ('535', '131', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '43771', 'en-US', '0', '2012-04-09 10:03:00');
INSERT INTO `users_device_login` VALUES ('536', '127', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '43963', 'en-US', '0', '2012-04-09 10:18:11');
INSERT INTO `users_device_login` VALUES ('537', '85', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '44014', 'en-US', '0', '2012-04-09 10:22:44');
INSERT INTO `users_device_login` VALUES ('538', '85', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '44133', 'en-us', '0', '2012-04-09 10:32:13');
INSERT INTO `users_device_login` VALUES ('539', '85', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '::1', '', '33733', 'en-us', '0', '2012-04-09 10:38:25');
INSERT INTO `users_device_login` VALUES ('540', '127', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '44467', 'en-US', '0', '2012-04-09 10:49:03');
INSERT INTO `users_device_login` VALUES ('541', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '44617', 'en-us', '0', '2012-04-09 10:56:00');
INSERT INTO `users_device_login` VALUES ('542', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '::1', '', '34290', 'en-us', '0', '2012-04-09 11:07:08');
INSERT INTO `users_device_login` VALUES ('543', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:11.0) Gecko/20100101 Firefox/11.0', '127.0.0.1', '', '52993', 'en-us', '0', '2012-04-11 14:05:57');
INSERT INTO `users_device_login` VALUES ('544', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:11.0) Gecko/20100101 Firefox/11.0', '192.168.1.123', '', '49847', 'en-us', '0', '2012-04-11 15:47:39');
INSERT INTO `users_device_login` VALUES ('545', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '43204', 'en-us', '0', '2012-04-11 16:00:28');
INSERT INTO `users_device_login` VALUES ('546', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.151 Safari/535.19', '127.0.0.1', '', '54335', 'en-US', '0', '2012-04-11 16:04:50');
INSERT INTO `users_device_login` VALUES ('547', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.54.16 (KHTML, like Gecko) Version/5.1.4 Safari/534.54.16', '127.0.0.1', '', '49727', 'en-us', '0', '2012-04-12 09:16:50');
INSERT INTO `users_device_login` VALUES ('548', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '50973', 'en-US', '0', '2012-04-12 09:41:12');
INSERT INTO `users_device_login` VALUES ('549', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.151 Safari/535.19', '127.0.0.1', '', '56585', 'en-US', '0', '2012-04-12 10:21:16');
INSERT INTO `users_device_login` VALUES ('550', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.151 Safari/535.19', '127.0.0.1', '', '56987', 'en-US', '0', '2012-04-12 10:44:32');
INSERT INTO `users_device_login` VALUES ('551', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.151 Safari/535.19', '127.0.0.1', '', '56987', 'en-US', '0', '2012-04-12 10:44:44');
INSERT INTO `users_device_login` VALUES ('552', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.151 Safari/535.19', '127.0.0.1', '', '57058', 'en-US', '0', '2012-04-12 10:52:51');
INSERT INTO `users_device_login` VALUES ('553', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.151 Safari/535.19', '127.0.0.1', '', '57071', 'en-US', '0', '2012-04-12 10:53:19');
INSERT INTO `users_device_login` VALUES ('554', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.55.3 (KHTML, like Gecko) Version/5.1.5 Safari/534.55.3', '127.0.0.1', '', '50819', 'es-ES', '0', '2012-04-12 10:56:57');
INSERT INTO `users_device_login` VALUES ('555', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.55.3 (KHTML, like Gecko) Version/5.1.5 Safari/534.55.3', '127.0.0.1', '', '50825', 'es-ES', '0', '2012-04-12 10:57:17');
INSERT INTO `users_device_login` VALUES ('556', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.55.3 (KHTML, like Gecko) Version/5.1.5 Safari/534.55.3', '127.0.0.1', '', '51012', 'es-ES', '0', '2012-04-12 11:01:55');
INSERT INTO `users_device_login` VALUES ('557', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:11.0) Gecko/20100101 Firefox/11.0', '127.0.0.1', '', '57677', 'es-es', '0', '2012-04-12 11:41:56');
INSERT INTO `users_device_login` VALUES ('558', '101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:11.0) Gecko/20100101 Firefox/11.0', '127.0.0.1', '', '57733', 'es-es', '0', '2012-04-12 11:42:53');
INSERT INTO `users_device_login` VALUES ('559', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '54795', 'en-US', '0', '2012-04-12 11:57:45');
INSERT INTO `users_device_login` VALUES ('560', '84', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '54801', 'en-US', '0', '2012-04-12 11:58:12');
INSERT INTO `users_device_login` VALUES ('561', '84', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '54801', 'en-US', '0', '2012-04-12 11:58:19');
INSERT INTO `users_device_login` VALUES ('562', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '54846', 'en-us', '0', '2012-04-12 11:59:34');
INSERT INTO `users_device_login` VALUES ('563', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '54847', 'en-us', '0', '2012-04-12 11:59:38');
INSERT INTO `users_device_login` VALUES ('564', '157', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '54919', 'en-us', '0', '2012-04-12 12:03:08');
INSERT INTO `users_device_login` VALUES ('565', '157', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '54920', 'en-us', '0', '2012-04-12 12:03:14');
INSERT INTO `users_device_login` VALUES ('566', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '51698', 'es-ES', '0', '2012-04-12 12:06:58');
INSERT INTO `users_device_login` VALUES ('567', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '51920', 'es-ES', '0', '2012-04-12 12:18:07');
INSERT INTO `users_device_login` VALUES ('568', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '52011', 'es-ES', '0', '2012-04-12 12:23:25');
INSERT INTO `users_device_login` VALUES ('569', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '55366', 'en-US', '0', '2012-04-12 13:11:46');
INSERT INTO `users_device_login` VALUES ('570', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '55366', 'en-US', '0', '2012-04-12 13:11:55');
INSERT INTO `users_device_login` VALUES ('571', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '49389', 'es-ES', '0', '2012-04-12 14:06:17');
INSERT INTO `users_device_login` VALUES ('572', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '49460', 'es-ES', '0', '2012-04-12 14:12:25');
INSERT INTO `users_device_login` VALUES ('573', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '49502', 'es-ES', '0', '2012-04-12 14:14:27');
INSERT INTO `users_device_login` VALUES ('574', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '49591', 'es-ES', '0', '2012-04-12 14:16:36');
INSERT INTO `users_device_login` VALUES ('575', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '50264', 'es-ES', '0', '2012-04-12 14:46:50');
INSERT INTO `users_device_login` VALUES ('576', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '50528', 'es-ES', '0', '2012-04-12 15:02:57');
INSERT INTO `users_device_login` VALUES ('577', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '50577', 'es-ES', '0', '2012-04-12 15:03:39');
INSERT INTO `users_device_login` VALUES ('578', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '50669', 'es-ES', '0', '2012-04-12 15:07:57');
INSERT INTO `users_device_login` VALUES ('579', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.151 Safari/535.19', '192.168.1.139', '', '61800', 'en-US', '0', '2012-04-12 15:39:02');
INSERT INTO `users_device_login` VALUES ('580', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '57314', 'en-US', '0', '2012-04-12 15:47:03');
INSERT INTO `users_device_login` VALUES ('581', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '57332', 'en-us', '0', '2012-04-12 15:49:40');
INSERT INTO `users_device_login` VALUES ('582', '7', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '57350', 'en-us', '0', '2012-04-12 15:51:07');
INSERT INTO `users_device_login` VALUES ('583', '124', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '57419', 'en-us', '0', '2012-04-12 16:00:19');
INSERT INTO `users_device_login` VALUES ('584', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '57478', 'en-us', '0', '2012-04-12 16:07:04');
INSERT INTO `users_device_login` VALUES ('585', '2', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '57665', 'en-us', '0', '2012-04-12 16:19:07');
INSERT INTO `users_device_login` VALUES ('586', '84', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '57697', 'en-us', '0', '2012-04-12 16:22:07');
INSERT INTO `users_device_login` VALUES ('587', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '52652', 'es-ES', '0', '2012-04-12 16:48:47');
INSERT INTO `users_device_login` VALUES ('588', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '52654', 'es-ES', '0', '2012-04-12 16:49:01');
INSERT INTO `users_device_login` VALUES ('589', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '52752', 'es-ES', '0', '2012-04-12 16:55:29');
INSERT INTO `users_device_login` VALUES ('590', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '127.0.0.1', '', '52820', 'es-ES', '0', '2012-04-12 16:56:38');
INSERT INTO `users_device_login` VALUES ('591', '103', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '54072', 'en-us', '0', '2012-04-13 09:18:38');
INSERT INTO `users_device_login` VALUES ('592', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '54258', 'en-US', '0', '2012-04-13 09:30:53');
INSERT INTO `users_device_login` VALUES ('593', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.152 Safari/535.19', '192.168.1.125', '', '53062', 'es-ES', '0', '2012-04-13 09:48:46');
INSERT INTO `users_device_login` VALUES ('594', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:11.0) Gecko/20100101 Firefox/11.0', '192.168.1.123', '', '43347', 'en-us', '0', '2012-04-13 11:37:22');
INSERT INTO `users_device_login` VALUES ('595', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.162 Safari/535.19', '127.0.0.1', '', '51220', 'en-US', '0', '2012-04-16 10:41:04');
INSERT INTO `users_device_login` VALUES ('596', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.162 Safari/535.19', '127.0.0.1', '', '50693', 'en-US', '0', '2012-04-16 11:48:16');
INSERT INTO `users_device_login` VALUES ('597', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.162 Safari/535.19', '127.0.0.1', '', '53655', 'en-US', '0', '2012-04-16 14:16:21');
INSERT INTO `users_device_login` VALUES ('598', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '::1', '', '37030', 'en-us', '0', '2012-04-16 14:29:27');
INSERT INTO `users_device_login` VALUES ('599', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '38572', 'en-US', '0', '2012-04-16 16:04:10');
INSERT INTO `users_device_login` VALUES ('600', '84', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; sdk Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.123', '', '55506', 'en-US', '1', '2012-04-16 16:18:42');
INSERT INTO `users_device_login` VALUES ('601', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '45358', 'en-US', '0', '2012-04-17 09:05:37');
INSERT INTO `users_device_login` VALUES ('602', '84', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; sdk Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.123', '', '41379', 'en-US', '1', '2012-04-17 09:50:07');
INSERT INTO `users_device_login` VALUES ('603', '84', 'Mozilla/5.0 (iPad; CPU OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3', '192.168.1.128', '', '50691', 'en-us', '1', '2012-04-17 09:55:33');
INSERT INTO `users_device_login` VALUES ('604', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '59874', 'en-US', '0', '2012-04-17 10:13:11');
INSERT INTO `users_device_login` VALUES ('605', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '60224', 'en-US', '0', '2012-04-17 11:04:43');
INSERT INTO `users_device_login` VALUES ('606', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.162 Safari/535.19', '127.0.0.1', '', '52463', 'en-US', '0', '2012-04-17 11:27:59');
INSERT INTO `users_device_login` VALUES ('607', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '::1', '', '48777', 'en-US', '0', '2012-04-17 16:15:21');
INSERT INTO `users_device_login` VALUES ('608', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '::1', '', '46663', 'en-us', '0', '2012-04-20 09:28:23');
INSERT INTO `users_device_login` VALUES ('609', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.163 Safari/535.19', '127.0.0.1', '', '49285', 'en-US', '0', '2012-04-20 11:11:29');
INSERT INTO `users_device_login` VALUES ('610', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.55.3 (KHTML, like Gecko) Version/5.1.5 Safari/534.55.3', '127.0.0.1', '', '49603', 'es-ES', '0', '2012-04-23 08:27:04');
INSERT INTO `users_device_login` VALUES ('611', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.163 Safari/535.19', '127.0.0.1', '', '54739', 'en-US', '0', '2012-04-23 08:44:28');
INSERT INTO `users_device_login` VALUES ('612', '101', 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '49290', 'en-us', '0', '2012-04-23 13:51:16');
INSERT INTO `users_device_login` VALUES ('613', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.162 Safari/535.19', '192.168.1.125', '', '58264', 'es-ES', '0', '2012-04-23 17:01:21');
INSERT INTO `users_device_login` VALUES ('614', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '36500', 'en-us', '0', '2012-04-26 14:58:45');
INSERT INTO `users_device_login` VALUES ('615', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '34463', 'en-US', '0', '2012-04-30 11:46:03');
INSERT INTO `users_device_login` VALUES ('616', '7', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '34495', 'en-us', '0', '2012-04-30 11:50:48');
INSERT INTO `users_device_login` VALUES ('617', '7', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '34586', 'en-US', '0', '2012-04-30 11:58:24');
INSERT INTO `users_device_login` VALUES ('618', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '34594', 'en-us', '0', '2012-04-30 11:58:42');
INSERT INTO `users_device_login` VALUES ('619', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '37683', 'en-US', '0', '2012-04-30 16:05:20');
INSERT INTO `users_device_login` VALUES ('620', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '36815', 'en-us', '0', '2012-05-02 10:22:27');
INSERT INTO `users_device_login` VALUES ('621', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '60280', 'en-us', '0', '2012-05-03 10:35:41');
INSERT INTO `users_device_login` VALUES ('622', '103', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '60303', 'en-US', '0', '2012-05-03 10:36:03');
INSERT INTO `users_device_login` VALUES ('623', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '51266', 'en-us', '0', '2012-05-11 16:18:03');
INSERT INTO `users_device_login` VALUES ('624', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '51416', 'en-us', '0', '2012-05-11 16:24:15');
INSERT INTO `users_device_login` VALUES ('625', '101', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '54679', 'en-us', '0', '2012-05-14 08:40:29');
INSERT INTO `users_device_login` VALUES ('626', '84', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:12.0) Gecko/20100101 Firefox/12.0', '192.168.1.123', '', '34309', 'en-us', '0', '2012-05-24 16:34:12');
INSERT INTO `users_device_login` VALUES ('627', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '::1', '', '59911', 'en-US', '1', '2012-06-01 14:16:31');
INSERT INTO `users_device_login` VALUES ('628', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12.0) Gecko/20100101 Firefox/12.0', '::1', '', '60995', 'es-es', '0', '2012-06-01 15:07:30');
INSERT INTO `users_device_login` VALUES ('629', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '64549', 'en-US', '1', '2012-06-04 10:46:59');
INSERT INTO `users_device_login` VALUES ('630', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.53 Safari/536.5', '192.168.1.139', '', '51612', 'en-US', '0', '2012-06-04 14:12:48');
INSERT INTO `users_device_login` VALUES ('631', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.53 Safari/536.5', '192.168.1.139', '', '51624', 'en-US', '0', '2012-06-04 14:14:00');
INSERT INTO `users_device_login` VALUES ('632', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.53 Safari/536.5', '192.168.1.139', '', '51682', 'en-US', '0', '2012-06-04 14:15:07');
INSERT INTO `users_device_login` VALUES ('633', '2', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '51990', 'en-US', '1', '2012-06-04 14:38:29');
INSERT INTO `users_device_login` VALUES ('634', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '52025', 'en-US', '1', '2012-06-04 14:39:31');
INSERT INTO `users_device_login` VALUES ('635', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '::1', '', '55571', 'en-US', '1', '2012-06-05 07:46:26');
INSERT INTO `users_device_login` VALUES ('636', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.134', '', '55126', 'en-us', '1', '2012-06-05 11:22:59');
INSERT INTO `users_device_login` VALUES ('637', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12.0) Gecko/20100101 Firefox/12.0', '::1', '', '62540', 'es-es', '0', '2012-06-05 14:31:02');
INSERT INTO `users_device_login` VALUES ('638', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.134', '', '55539', 'en-us', '1', '2012-06-05 16:21:04');
INSERT INTO `users_device_login` VALUES ('639', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '53088', 'en-US', '1', '2012-06-06 10:34:51');
INSERT INTO `users_device_login` VALUES ('640', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12.0) Gecko/20100101 Firefox/12.0', '192.168.1.139', '', '53631', 'es-es', '0', '2012-06-06 11:14:49');
INSERT INTO `users_device_login` VALUES ('641', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.122', '', '57215', 'en-us', '1', '2012-06-06 11:54:54');
INSERT INTO `users_device_login` VALUES ('642', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.122', '', '57494', 'en-us', '1', '2012-06-06 14:49:45');
INSERT INTO `users_device_login` VALUES ('643', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.129', '', '49168', 'en-US', '1', '2012-06-06 14:58:37');
INSERT INTO `users_device_login` VALUES ('644', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.126', '', '57025', 'es-es', '1', '2012-06-06 15:02:02');
INSERT INTO `users_device_login` VALUES ('645', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '56821', 'en-US', '1', '2012-06-06 15:22:13');
INSERT INTO `users_device_login` VALUES ('646', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.138', '', '57580', 'en-us', '1', '2012-06-06 15:56:21');
INSERT INTO `users_device_login` VALUES ('647', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '60117', 'en-US', '1', '2012-06-07 09:13:53');
INSERT INTO `users_device_login` VALUES ('648', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12.0) Gecko/20100101 Firefox/12.0', '192.168.1.139', '', '60810', 'es-es', '0', '2012-06-07 11:07:39');
INSERT INTO `users_device_login` VALUES ('649', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '61310', 'en-US', '1', '2012-06-07 13:29:15');
INSERT INTO `users_device_login` VALUES ('650', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.134', '', '58704', 'en-us', '1', '2012-06-07 13:38:27');
INSERT INTO `users_device_login` VALUES ('651', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '58318', 'en-US', '1', '2012-06-11 10:08:55');
INSERT INTO `users_device_login` VALUES ('652', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12.0) Gecko/20100101 Firefox/12.0', '192.168.1.139', '', '58550', 'es-es', '0', '2012-06-11 10:18:54');
INSERT INTO `users_device_login` VALUES ('653', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.121', '', '64715', 'en-us', '1', '2012-06-11 10:24:18');
INSERT INTO `users_device_login` VALUES ('654', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12.0) Gecko/20100101 Firefox/12.0', '192.168.1.139', '', '59404', 'es-es', '0', '2012-06-11 11:11:35');
INSERT INTO `users_device_login` VALUES ('655', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '::1', '', '51109', 'en-US', '1', '2012-06-11 16:08:28');
INSERT INTO `users_device_login` VALUES ('656', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.143', '', '51153', 'en-us', '1', '2012-06-12 10:54:55');
INSERT INTO `users_device_login` VALUES ('657', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '56123', 'en-US', '1', '2012-06-12 10:57:35');
INSERT INTO `users_device_login` VALUES ('658', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', '192.168.1.139', '', '60281', 'en-US', '0', '2012-06-12 15:56:00');
INSERT INTO `users_device_login` VALUES ('659', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', '192.168.1.139', '', '62935', 'en-US', '0', '2012-06-13 13:55:05');
INSERT INTO `users_device_login` VALUES ('660', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12.0) Gecko/20100101 Firefox/12.0', '192.168.1.139', '', '63155', 'es-es', '0', '2012-06-13 14:01:24');
INSERT INTO `users_device_login` VALUES ('661', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '::1', '', '63208', 'en-us', '0', '2012-06-13 14:02:31');
INSERT INTO `users_device_login` VALUES ('662', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', '192.168.1.139', '', '61897', 'en-US', '0', '2012-06-15 08:44:31');
INSERT INTO `users_device_login` VALUES ('663', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12.0) Gecko/20100101 Firefox/12.0', '192.168.1.139', '', '63306', 'es-es', '0', '2012-06-19 16:03:22');
INSERT INTO `users_device_login` VALUES ('664', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '64871', 'en-US', '0', '2012-06-20 07:55:32');
INSERT INTO `users_device_login` VALUES ('665', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '64881', 'en-US', '0', '2012-06-20 07:56:00');
INSERT INTO `users_device_login` VALUES ('666', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '64916', 'en-US', '0', '2012-06-20 07:59:41');
INSERT INTO `users_device_login` VALUES ('667', '0', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '50631', 'en-US', '1', '2012-06-20 10:23:25');
INSERT INTO `users_device_login` VALUES ('668', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12.0) Gecko/20100101 Firefox/12.0', '192.168.1.139', '', '52747', 'es-es', '0', '2012-06-20 12:26:08');
INSERT INTO `users_device_login` VALUES ('669', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', '192.168.1.139', '', '53652', 'en-US', '0', '2012-07-02 11:14:14');
INSERT INTO `users_device_login` VALUES ('670', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', '192.168.1.139', '', '53785', 'en-US', '0', '2012-07-02 11:19:00');
INSERT INTO `users_device_login` VALUES ('671', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', '192.168.1.139', '', '53823', 'en-US', '0', '2012-07-02 11:19:45');
INSERT INTO `users_device_login` VALUES ('672', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', '192.168.1.139', '', '53862', 'en-US', '0', '2012-07-02 11:20:29');
INSERT INTO `users_device_login` VALUES ('673', '2', 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8A293 Safari/6531.22.7', '192.168.1.139', '', '54959', 'en-US', '1', '2012-07-02 12:16:50');
INSERT INTO `users_device_login` VALUES ('674', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', '192.168.1.139', '', '64842', 'en-US', '1', '2012-07-03 09:35:25');
INSERT INTO `users_device_login` VALUES ('675', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.134', '', '57259', 'en-us', '1', '2012-07-03 14:00:55');
INSERT INTO `users_device_login` VALUES ('676', '0', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:12.0) Gecko/20100101 Firefox/12.0', '192.168.1.123', '', '46557', 'en-us', '1', '2012-07-03 14:02:01');
INSERT INTO `users_device_login` VALUES ('677', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.134', '', '57525', 'en-us', '1', '2012-07-03 14:41:33');
INSERT INTO `users_device_login` VALUES ('678', '2', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.134', '', '57588', 'en-us', '1', '2012-07-03 14:48:32');
INSERT INTO `users_device_login` VALUES ('679', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '62315', 'es-es', '1', '2012-07-04 12:41:45');
INSERT INTO `users_device_login` VALUES ('680', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.139', '', '49847', 'en-US', '0', '2012-07-04 15:31:05');
INSERT INTO `users_device_login` VALUES ('681', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.139', '', '49829', 'en-US', '0', '2012-07-04 16:44:16');
INSERT INTO `users_device_login` VALUES ('682', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.121', '', '49735', 'en-us', '1', '2012-07-06 12:22:06');
INSERT INTO `users_device_login` VALUES ('683', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '61252', 'es-es', '1', '2012-07-06 15:40:29');
INSERT INTO `users_device_login` VALUES ('684', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.139', '', '50567', 'en-US', '0', '2012-07-09 08:53:32');
INSERT INTO `users_device_login` VALUES ('685', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '58851', 'es-es', '0', '2012-07-09 15:38:58');
INSERT INTO `users_device_login` VALUES ('686', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '58871', 'es-es', '1', '2012-07-09 15:39:12');
INSERT INTO `users_device_login` VALUES ('687', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '65432', 'es-es', '0', '2012-07-10 11:08:33');
INSERT INTO `users_device_login` VALUES ('688', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '65447', 'es-es', '1', '2012-07-10 11:09:04');
INSERT INTO `users_device_login` VALUES ('689', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.139', '', '49242', 'en-US', '0', '2012-07-10 11:17:36');
INSERT INTO `users_device_login` VALUES ('690', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '50632', 'es-es', '0', '2012-07-10 13:34:50');
INSERT INTO `users_device_login` VALUES ('691', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '53910', 'es-es', '1', '2012-07-10 16:46:17');
INSERT INTO `users_device_login` VALUES ('692', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '53991', 'es-es', '1', '2012-07-10 16:52:06');
INSERT INTO `users_device_login` VALUES ('693', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '56375', 'es-es', '1', '2012-07-11 09:16:20');
INSERT INTO `users_device_login` VALUES ('694', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '57215', 'es-es', '1', '2012-07-11 09:55:54');
INSERT INTO `users_device_login` VALUES ('695', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '49413', 'es-es', '0', '2012-07-11 10:39:49');
INSERT INTO `users_device_login` VALUES ('696', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '49660', 'es-es', '1', '2012-07-11 10:43:12');
INSERT INTO `users_device_login` VALUES ('697', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.139', '', '53038', 'en-US', '0', '2012-07-11 13:39:55');
INSERT INTO `users_device_login` VALUES ('698', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.144', '', '57943', 'en-us', '1', '2012-07-11 15:21:16');
INSERT INTO `users_device_login` VALUES ('699', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.139', '', '57842', 'en-US', '1', '2012-07-11 17:31:47');
INSERT INTO `users_device_login` VALUES ('700', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '60844', 'es-es', '1', '2012-07-12 09:37:12');
INSERT INTO `users_device_login` VALUES ('701', '0', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.123', '', '40616', 'en-us', '0', '2012-07-12 10:56:58');
INSERT INTO `users_device_login` VALUES ('702', '0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.123', '', '40632', 'en-US', '1', '2012-07-12 10:57:23');
INSERT INTO `users_device_login` VALUES ('703', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.144', '', '60296', 'en-us', '0', '2012-07-12 12:50:05');
INSERT INTO `users_device_login` VALUES ('704', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.144', '', '60323', 'en-us', '1', '2012-07-12 12:51:20');
INSERT INTO `users_device_login` VALUES ('705', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.144', '', '61279', 'en-us', '0', '2012-07-12 14:22:06');
INSERT INTO `users_device_login` VALUES ('706', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.144', '', '61302', 'en-us', '1', '2012-07-12 14:27:49');
INSERT INTO `users_device_login` VALUES ('707', '0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '47196', 'en-US', '1', '2012-07-12 14:46:23');
INSERT INTO `users_device_login` VALUES ('708', '0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '47416', 'en-US', '1', '2012-07-12 14:56:02');
INSERT INTO `users_device_login` VALUES ('709', '0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7', '192.168.1.141', '', '47423', 'en-US', '1', '2012-07-12 14:56:22');
INSERT INTO `users_device_login` VALUES ('710', '0', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.143', '', '52912', 'en-us', '1', '2012-07-12 17:15:00');
INSERT INTO `users_device_login` VALUES ('711', '0', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.143', '', '52919', 'en-us', '1', '2012-07-12 17:15:38');
INSERT INTO `users_device_login` VALUES ('712', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.139', '', '60737', 'en-US', '0', '2012-07-13 13:22:48');
INSERT INTO `users_device_login` VALUES ('713', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.139', '', '60950', 'en-US', '1', '2012-07-13 13:32:49');
INSERT INTO `users_device_login` VALUES ('714', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.147', '', '65196', 'en-us', '1', '2012-07-13 14:03:03');
INSERT INTO `users_device_login` VALUES ('715', '0', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.123', '', '39802', 'en-us', '0', '2012-07-13 14:19:12');
INSERT INTO `users_device_login` VALUES ('716', '0', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.123', '', '39797', 'en-us', '1', '2012-07-13 14:19:24');
INSERT INTO `users_device_login` VALUES ('717', '0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.123', '', '39861', 'en-US', '0', '2012-07-13 14:21:34');
INSERT INTO `users_device_login` VALUES ('718', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11', '192.168.1.139', '', '63133', 'en-US', '1', '2012-07-13 15:04:36');
INSERT INTO `users_device_login` VALUES ('719', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1', '192.168.1.139', '', '63194', 'es-es', '0', '2012-07-13 15:06:18');
INSERT INTO `users_device_login` VALUES ('720', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11', '192.168.1.139', '', '51499', 'en-US', '0', '2012-07-18 11:03:37');
INSERT INTO `users_device_login` VALUES ('721', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11', '192.168.1.139', '', '51576', 'en-US', '0', '2012-07-18 11:04:44');
INSERT INTO `users_device_login` VALUES ('722', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11', '192.168.1.139', '', '59559', 'en-US', '0', '2012-07-18 16:18:47');
INSERT INTO `users_device_login` VALUES ('723', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '59723', 'es-es', '0', '2012-07-18 16:24:45');
INSERT INTO `users_device_login` VALUES ('724', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11', '192.168.1.139', '', '51020', 'en-US', '0', '2012-07-19 14:01:37');
INSERT INTO `users_device_login` VALUES ('725', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11', '192.168.1.139', '', '54211', 'en-US', '1', '2012-07-20 08:41:56');
INSERT INTO `users_device_login` VALUES ('726', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '54236', 'es-es', '1', '2012-07-20 08:42:42');
INSERT INTO `users_device_login` VALUES ('727', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.146', '', '50000', 'en-US', '1', '2012-07-20 08:48:20');
INSERT INTO `users_device_login` VALUES ('728', '0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11', '192.168.1.123', '', '50784', 'en-US', '0', '2012-07-20 15:28:26');
INSERT INTO `users_device_login` VALUES ('729', '0', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.123', '', '59989', 'en-us', '0', '2012-07-25 09:30:35');
INSERT INTO `users_device_login` VALUES ('730', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11', '192.168.1.139', '', '50252', 'en-US', '0', '2012-07-25 09:53:18');
INSERT INTO `users_device_login` VALUES ('731', '0', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.123', '', '60753', 'en-us', '0', '2012-07-25 09:56:05');
INSERT INTO `users_device_login` VALUES ('732', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '64438', 'es-es', '0', '2012-07-26 09:35:30');
INSERT INTO `users_device_login` VALUES ('733', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '64438', 'es-es', '0', '2012-07-26 09:35:34');
INSERT INTO `users_device_login` VALUES ('734', '0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11', '192.168.1.123', '', '60295', 'en-US', '0', '2012-07-26 15:43:12');
INSERT INTO `users_device_login` VALUES ('735', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.57 Safari/537.1', '192.168.1.139', '', '61607', 'en-US', '0', '2012-08-03 11:18:32');
INSERT INTO `users_device_login` VALUES ('736', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.57 Safari/537.1', '192.168.1.139', '', '49475', 'en-US', '0', '2012-08-06 09:37:34');
INSERT INTO `users_device_login` VALUES ('737', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.60 Safari/537.1', '192.168.1.125', '', '51065', 'es-ES', '1', '2012-08-06 14:17:36');
INSERT INTO `users_device_login` VALUES ('738', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '54993', 'es-es', '0', '2012-08-06 15:22:03');
INSERT INTO `users_device_login` VALUES ('739', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '54998', 'es-es', '0', '2012-08-06 15:22:08');
INSERT INTO `users_device_login` VALUES ('740', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.60 Safari/537.1', '192.168.1.125', '', '51436', 'es-ES', '0', '2012-08-06 16:21:04');
INSERT INTO `users_device_login` VALUES ('741', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '63204', 'es-es', '0', '2012-08-09 09:58:45');
INSERT INTO `users_device_login` VALUES ('742', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1', '192.168.1.139', '', '63439', 'en-US', '0', '2012-08-09 10:03:54');
INSERT INTO `users_device_login` VALUES ('743', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '63633', 'es-es', '0', '2012-08-09 10:08:56');
INSERT INTO `users_device_login` VALUES ('744', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.57 Safari/537.1', '192.168.1.140', '', '58582', 'en-US', '1', '2012-08-09 11:39:39');
INSERT INTO `users_device_login` VALUES ('745', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1', '192.168.1.139', '', '51908', 'en-US', '0', '2012-08-09 14:08:09');
INSERT INTO `users_device_login` VALUES ('746', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.57 Safari/537.1', '192.168.1.140', '', '62503', 'en-US', '0', '2012-08-09 14:09:55');
INSERT INTO `users_device_login` VALUES ('747', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1', '192.168.1.139', '', '65074', 'en-US', '1', '2012-08-13 08:33:23');
INSERT INTO `users_device_login` VALUES ('748', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1', '192.168.1.139', '', '65086', 'en-US', '1', '2012-08-13 08:33:40');
INSERT INTO `users_device_login` VALUES ('749', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1', '192.168.1.139', '', '65086', 'en-US', '1', '2012-08-13 08:33:47');
INSERT INTO `users_device_login` VALUES ('750', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1', '192.168.1.139', '', '65103', 'en-US', '1', '2012-08-13 08:34:17');
INSERT INTO `users_device_login` VALUES ('751', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1', '192.168.1.139', '', '65218', 'en-US', '0', '2012-08-13 08:40:22');
INSERT INTO `users_device_login` VALUES ('752', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1', '192.168.1.139', '', '49231', 'en-US', '1', '2012-08-13 08:58:13');
INSERT INTO `users_device_login` VALUES ('753', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1', '192.168.1.139', '', '61232', 'en-US', '0', '2012-08-14 11:01:02');
INSERT INTO `users_device_login` VALUES ('754', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.124', '', '59335', 'en-us', '1', '2012-08-14 11:27:49');
INSERT INTO `users_device_login` VALUES ('755', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '62374', 'es-es', '0', '2012-08-14 11:46:43');
INSERT INTO `users_device_login` VALUES ('756', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '62385', 'es-es', '1', '2012-08-14 11:47:05');
INSERT INTO `users_device_login` VALUES ('757', '0', 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0', '192.168.1.141', '', '58180', 'en-us', '1', '2012-08-14 15:25:24');
INSERT INTO `users_device_login` VALUES ('758', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1', '192.168.1.140', '', '49870', 'en-US', '0', '2012-08-14 15:26:13');
INSERT INTO `users_device_login` VALUES ('759', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.128', '', '52678', 'en-US', '1', '2012-08-14 15:40:12');
INSERT INTO `users_device_login` VALUES ('760', '124', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.128', '', '42946', 'en-US', '1', '2012-08-14 15:42:46');
INSERT INTO `users_device_login` VALUES ('761', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '55918', 'es-es', '0', '2012-08-17 11:10:31');
INSERT INTO `users_device_login` VALUES ('762', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '55920', 'es-es', '0', '2012-08-17 11:10:37');
INSERT INTO `users_device_login` VALUES ('763', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:14.0) Gecko/20100101 Firefox/14.0.1', '192.168.1.139', '', '56644', 'es-es', '1', '2012-08-17 11:39:15');
INSERT INTO `users_device_login` VALUES ('764', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.79 Safari/537.1', '192.168.1.139', '', '60711', 'en-US', '0', '2012-08-20 10:46:12');
INSERT INTO `users_device_login` VALUES ('765', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.82 Safari/537.1', '192.168.1.140', '', '63069', 'en-US', '0', '2012-08-24 12:17:22');
INSERT INTO `users_device_login` VALUES ('766', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1', '192.168.1.125', '', '50660', 'es-ES', '0', '2012-09-07 11:28:25');
INSERT INTO `users_device_login` VALUES ('767', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1', '192.168.1.125', '', '50667', 'es-ES', '1', '2012-09-07 11:28:38');
INSERT INTO `users_device_login` VALUES ('768', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1', '192.168.1.139', '', '55001', 'en-US', '1', '2012-09-11 11:21:31');
INSERT INTO `users_device_login` VALUES ('769', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1', '192.168.1.139', '', '62587', 'en-US', '1', '2012-09-14 09:30:38');
INSERT INTO `users_device_login` VALUES ('770', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1', '127.0.0.1', '', '53305', 'en-US', '1', '2012-09-26 10:02:31');
INSERT INTO `users_device_login` VALUES ('771', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', '::1', '', '51582', 'en-US', '1', '2012-10-02 08:30:42');
INSERT INTO `users_device_login` VALUES ('772', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:15.0) Gecko/20100101 Firefox/15.0.1', '::1', '', '55339', 'es-es', '1', '2012-10-02 11:21:05');
INSERT INTO `users_device_login` VALUES ('773', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', '192.168.1.139', '', '56060', 'en-US', '1', '2012-10-02 11:53:23');
INSERT INTO `users_device_login` VALUES ('774', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.120', '', '33846', 'en-US', '0', '2012-10-02 11:54:59');
INSERT INTO `users_device_login` VALUES ('775', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:15.0) Gecko/20100101 Firefox/15.0.1', '192.168.1.139', '', '56973', 'es-es', '0', '2012-10-02 13:07:19');
INSERT INTO `users_device_login` VALUES ('776', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:15.0) Gecko/20100101 Firefox/15.0.1', '192.168.1.139', '', '56985', 'es-es', '0', '2012-10-02 13:07:35');
INSERT INTO `users_device_login` VALUES ('777', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:15.0) Gecko/20100101 Firefox/15.0.1', '192.168.1.139', '', '57000', 'es-es', '0', '2012-10-02 13:08:26');
INSERT INTO `users_device_login` VALUES ('778', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:15.0) Gecko/20100101 Firefox/15.0.1', '192.168.1.139', '', '57000', 'es-es', '0', '2012-10-02 13:08:29');
INSERT INTO `users_device_login` VALUES ('779', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:15.0) Gecko/20100101 Firefox/15.0.1', '192.168.1.139', '', '57017', 'es-es', '1', '2012-10-02 13:09:10');
INSERT INTO `users_device_login` VALUES ('780', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.120', '', '51449', 'en-US', '1', '2012-10-02 13:10:31');
INSERT INTO `users_device_login` VALUES ('781', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', '192.168.1.139', '', '61117', 'en-US', '0', '2012-10-03 08:28:26');
INSERT INTO `users_device_login` VALUES ('782', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', '192.168.1.139', '', '61127', 'en-US', '1', '2012-10-03 08:28:39');
INSERT INTO `users_device_login` VALUES ('783', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.122', '', '36701', 'en-US', '0', '2012-10-03 08:46:31');
INSERT INTO `users_device_login` VALUES ('784', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.122', '', '34314', 'en-US', '1', '2012-10-03 08:46:53');
INSERT INTO `users_device_login` VALUES ('785', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:15.0) Gecko/20100101 Firefox/15.0.1', '192.168.1.139', '', '63272', 'es-es', '0', '2012-10-03 09:58:24');
INSERT INTO `users_device_login` VALUES ('786', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.122', '', '40013', 'en-US', '1', '2012-10-03 10:11:00');
INSERT INTO `users_device_login` VALUES ('787', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', '192.168.1.140', '', '49332', 'en-US', '0', '2012-10-03 10:12:19');
INSERT INTO `users_device_login` VALUES ('788', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', '192.168.1.123', '', '51191', 'es-ES', '1', '2012-10-03 10:14:20');
INSERT INTO `users_device_login` VALUES ('789', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', '192.168.1.139', '', '63675', 'en-US', '0', '2012-10-03 10:16:01');
INSERT INTO `users_device_login` VALUES ('790', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.122', '', '60755', 'en-US', '1', '2012-10-03 10:19:36');
INSERT INTO `users_device_login` VALUES ('791', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.122', '', '49369', 'en-US', '1', '2012-10-03 10:34:15');
INSERT INTO `users_device_login` VALUES ('792', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', '192.168.1.123', '', '52644', 'es-ES', '0', '2012-10-03 11:32:34');
INSERT INTO `users_device_login` VALUES ('793', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', '192.168.1.140', '', '53115', 'en-US', '1', '2012-10-03 14:47:48');
INSERT INTO `users_device_login` VALUES ('794', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.122', '', '41985', 'en-US', '0', '2012-10-03 15:10:06');
INSERT INTO `users_device_login` VALUES ('795', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.122', '', '56039', 'en-US', '1', '2012-10-03 15:10:50');
INSERT INTO `users_device_login` VALUES ('796', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/537.4', '127.0.0.1', '', '50044', 'en-US', '0', '2012-10-05 09:07:03');
INSERT INTO `users_device_login` VALUES ('797', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:15.0) Gecko/20100101 Firefox/15.0.1', '::1', '', '50164', 'es-es', '0', '2012-10-05 09:08:25');
INSERT INTO `users_device_login` VALUES ('798', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.139', '', '54720', 'en-US', '1', '2012-10-15 12:14:39');
INSERT INTO `users_device_login` VALUES ('799', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.139', '', '54720', 'en-US', '0', '2012-10-15 12:14:40');
INSERT INTO `users_device_login` VALUES ('800', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.139', '', '54737', 'en-US', '0', '2012-10-15 12:14:54');
INSERT INTO `users_device_login` VALUES ('801', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.139', '', '54739', 'en-US', '0', '2012-10-15 12:15:01');
INSERT INTO `users_device_login` VALUES ('802', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.139', '', '54740', 'en-US', '0', '2012-10-15 12:15:10');
INSERT INTO `users_device_login` VALUES ('803', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.139', '', '54768', 'en-US', '1', '2012-10-15 12:15:59');
INSERT INTO `users_device_login` VALUES ('804', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.125', '', '50631', 'es-ES', '1', '2012-10-15 12:16:02');
INSERT INTO `users_device_login` VALUES ('805', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:15.0) Gecko/20100101 Firefox/15.0.1', '192.168.1.139', '', '55432', 'es-es', '1', '2012-10-15 12:26:58');
INSERT INTO `users_device_login` VALUES ('806', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.139', '', '61946', 'en-US', '0', '2012-10-31 16:22:51');
INSERT INTO `users_device_login` VALUES ('807', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.125', '', '62233', 'es-ES', '0', '2012-10-31 16:25:55');
INSERT INTO `users_device_login` VALUES ('808', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.139', '', '49926', 'en-US', '0', '2012-11-01 09:10:48');
INSERT INTO `users_device_login` VALUES ('809', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '::1', '', '50287', 'en-US', '0', '2012-11-01 09:22:43');
INSERT INTO `users_device_login` VALUES ('810', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '::1', '', '50413', 'en-US', '0', '2012-11-01 09:25:48');
INSERT INTO `users_device_login` VALUES ('811', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '::1', '', '50516', 'en-US', '0', '2012-11-01 09:26:40');
INSERT INTO `users_device_login` VALUES ('812', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '::1', '', '50737', 'en-US', '0', '2012-11-01 09:41:57');
INSERT INTO `users_device_login` VALUES ('813', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '::1', '', '53288', 'en-US', '0', '2012-11-01 13:27:14');
INSERT INTO `users_device_login` VALUES ('814', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '49417', 'en-US', '0', '2012-11-07 14:45:43');
INSERT INTO `users_device_login` VALUES ('815', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '49599', 'es-ES', '0', '2012-11-07 14:49:07');
INSERT INTO `users_device_login` VALUES ('816', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '49711', 'es-ES', '0', '2012-11-07 14:50:28');
INSERT INTO `users_device_login` VALUES ('817', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '50169', 'es-ES', '0', '2012-11-07 14:56:56');
INSERT INTO `users_device_login` VALUES ('818', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '51664', 'es-ES', '0', '2012-11-07 15:47:57');
INSERT INTO `users_device_login` VALUES ('819', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '52392', 'es-ES', '0', '2012-11-07 16:03:20');
INSERT INTO `users_device_login` VALUES ('820', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '52563', 'es-ES', '0', '2012-11-07 16:06:19');
INSERT INTO `users_device_login` VALUES ('821', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '52763', 'es-ES', '0', '2012-11-07 16:09:54');
INSERT INTO `users_device_login` VALUES ('822', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '52894', 'es-ES', '0', '2012-11-07 16:11:32');
INSERT INTO `users_device_login` VALUES ('823', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.125', '', '52757', 'es-ES', '0', '2012-11-07 16:13:26');
INSERT INTO `users_device_login` VALUES ('824', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '51302', 'en-US', '0', '2012-11-08 08:51:04');
INSERT INTO `users_device_login` VALUES ('825', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4', '192.168.1.125', '', '50814', 'es-ES', '1', '2012-11-08 09:04:00');
INSERT INTO `users_device_login` VALUES ('826', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '52660', 'en-US', '0', '2012-11-09 11:25:28');
INSERT INTO `users_device_login` VALUES ('827', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '53867', 'en-US', '1', '2012-11-09 11:44:13');
INSERT INTO `users_device_login` VALUES ('828', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '49619', 'en-US', '0', '2012-11-09 13:47:43');
INSERT INTO `users_device_login` VALUES ('829', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '49763', 'en-US', '0', '2012-11-09 13:51:04');
INSERT INTO `users_device_login` VALUES ('830', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '49778', 'es-ES', '0', '2012-11-09 13:51:45');
INSERT INTO `users_device_login` VALUES ('831', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '49911', 'en-US', '0', '2012-11-12 08:55:12');
INSERT INTO `users_device_login` VALUES ('832', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '49996', 'en-US', '1', '2012-11-12 08:56:14');
INSERT INTO `users_device_login` VALUES ('833', '0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.112', '', '50001', 'en-us', '1', '2012-11-12 09:01:04');
INSERT INTO `users_device_login` VALUES ('834', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '50287', 'es-ES', '0', '2012-11-12 09:08:12');
INSERT INTO `users_device_login` VALUES ('835', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.115', '', '41061', 'en-US', '1', '2012-11-12 09:11:56');
INSERT INTO `users_device_login` VALUES ('836', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-us; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.115', '', '48359', 'en-US', '1', '2012-11-12 09:15:37');
INSERT INTO `users_device_login` VALUES ('837', '0', 'Mozilla/5.0 (Linux; U; Android 4.0.4; en-us; SAMSUNG-SGH-I727 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '192.168.1.117', '', '43766', 'en-US', '1', '2012-11-12 15:48:54');
INSERT INTO `users_device_login` VALUES ('838', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '52810', 'es-ES', '0', '2012-11-14 09:00:04');
INSERT INTO `users_device_login` VALUES ('839', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '53139', 'en-US', '0', '2012-11-14 09:01:53');
INSERT INTO `users_device_login` VALUES ('840', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '54435', 'en-US', '1', '2012-11-14 09:37:46');
INSERT INTO `users_device_login` VALUES ('841', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:16.0) Gecko/20100101 Firefox/16.0', '192.168.1.139', '', '54949', 'es-ES', '1', '2012-11-14 10:04:16');
INSERT INTO `users_device_login` VALUES ('842', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '192.168.1.139', '', '55971', 'en-US', '1', '2012-11-15 14:21:29');
INSERT INTO `users_device_login` VALUES ('843', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11', '::1', '', '52585', 'en-US', '0', '2012-11-21 10:03:58');
INSERT INTO `users_device_login` VALUES ('844', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11', '192.168.1.139', '', '60252', 'en-US', '0', '2012-12-06 10:25:09');
INSERT INTO `users_device_login` VALUES ('845', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11', '192.168.1.139', '', '60306', 'en-US', '0', '2012-12-06 10:26:41');
INSERT INTO `users_device_login` VALUES ('846', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11', '192.168.1.125', '', '63576', 'es-ES', '0', '2012-12-13 15:11:16');
INSERT INTO `users_device_login` VALUES ('847', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11', '192.168.1.123', '', '52162', 'es-ES', '0', '2012-12-13 15:11:54');
INSERT INTO `users_device_login` VALUES ('848', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '62475', 'en-US', '0', '2012-12-18 15:00:19');
INSERT INTO `users_device_login` VALUES ('849', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '50643', 'en-US', '0', '2013-01-07 10:24:57');
INSERT INTO `users_device_login` VALUES ('850', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '50708', 'en-US', '0', '2013-01-07 10:28:34');
INSERT INTO `users_device_login` VALUES ('851', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '56558', 'en-US', '0', '2013-01-07 14:33:59');
INSERT INTO `users_device_login` VALUES ('852', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '50478', 'en-US', '0', '2013-01-08 08:50:08');
INSERT INTO `users_device_login` VALUES ('853', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '51390', 'en-US', '0', '2013-01-08 09:44:44');
INSERT INTO `users_device_login` VALUES ('854', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '51590', 'en-US', '0', '2013-01-08 09:55:23');
INSERT INTO `users_device_login` VALUES ('855', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '59509', 'en-US', '0', '2013-01-08 15:33:13');
INSERT INTO `users_device_login` VALUES ('856', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '50586', 'en-US', '0', '2013-01-09 09:37:16');
INSERT INTO `users_device_login` VALUES ('857', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '53777', 'en-US', '0', '2013-01-09 14:22:20');
INSERT INTO `users_device_login` VALUES ('858', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.139', '', '49890', 'en-US', '0', '2013-01-10 08:37:35');
INSERT INTO `users_device_login` VALUES ('859', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.134', '', '62241', 'en-US', '0', '2013-01-10 16:02:51');
INSERT INTO `users_device_login` VALUES ('860', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '50941', 'en-US', '0', '2013-01-11 10:09:13');
INSERT INTO `users_device_login` VALUES ('861', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '51029', 'en-US', '0', '2013-01-11 10:13:03');
INSERT INTO `users_device_login` VALUES ('862', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '51150', 'en-US', '0', '2013-01-11 10:15:47');
INSERT INTO `users_device_login` VALUES ('863', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '51198', 'en-US', '0', '2013-01-11 10:17:31');
INSERT INTO `users_device_login` VALUES ('864', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '55542', 'en-US', '0', '2013-01-11 14:41:52');
INSERT INTO `users_device_login` VALUES ('865', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '55544', 'en-US', '0', '2013-01-11 14:41:54');
INSERT INTO `users_device_login` VALUES ('866', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '55545', 'en-US', '0', '2013-01-11 14:41:54');
INSERT INTO `users_device_login` VALUES ('867', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '55547', 'en-US', '0', '2013-01-11 14:41:55');
INSERT INTO `users_device_login` VALUES ('868', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '55543', 'en-US', '0', '2013-01-11 14:41:55');
INSERT INTO `users_device_login` VALUES ('869', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '49739', 'en-US', '0', '2013-01-14 08:30:46');
INSERT INTO `users_device_login` VALUES ('870', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '::1', '', '54526', 'en-US', '0', '2013-01-14 14:59:03');
INSERT INTO `users_device_login` VALUES ('871', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '52266', 'es-ES', '0', '2013-01-16 11:24:29');
INSERT INTO `users_device_login` VALUES ('872', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '52972', 'en-US', '0', '2013-01-16 11:55:28');
INSERT INTO `users_device_login` VALUES ('873', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.101 Safari/537.11', '192.168.1.134', '', '60112', 'en-US', '0', '2013-01-16 14:12:01');
INSERT INTO `users_device_login` VALUES ('874', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '56161', 'en-US', '0', '2013-01-16 16:32:25');
INSERT INTO `users_device_login` VALUES ('875', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '56180', 'en-US', '0', '2013-01-16 16:33:44');
INSERT INTO `users_device_login` VALUES ('876', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '49696', 'en-US', '0', '2013-01-17 09:28:13');
INSERT INTO `users_device_login` VALUES ('877', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '50597', 'en-US', '0', '2013-01-17 11:34:44');
INSERT INTO `users_device_login` VALUES ('878', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.141', '', '50380', 'es-ES', '0', '2013-01-17 13:11:40');
INSERT INTO `users_device_login` VALUES ('879', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '51482', 'en-US', '0', '2013-01-17 14:34:32');
INSERT INTO `users_device_login` VALUES ('880', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '52490', 'es-ES', '0', '2013-01-17 15:23:39');
INSERT INTO `users_device_login` VALUES ('881', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '50085', 'en-US', '0', '2013-01-18 14:51:12');
INSERT INTO `users_device_login` VALUES ('882', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '50231', 'en-US', '0', '2013-01-21 09:34:39');
INSERT INTO `users_device_login` VALUES ('883', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17', '192.168.1.139', '', '53150', 'en-US', '0', '2013-01-22 15:35:16');
INSERT INTO `users_device_login` VALUES ('884', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', '192.168.1.139', '', '55835', 'en-US', '0', '2013-01-23 11:05:45');
INSERT INTO `users_device_login` VALUES ('885', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', '192.168.1.139', '', '49540', 'en-US', '0', '2013-01-24 09:18:30');
INSERT INTO `users_device_login` VALUES ('886', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '50967', 'es-ES', '0', '2013-01-24 11:00:32');
INSERT INTO `users_device_login` VALUES ('887', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', '::1', '', '56248', 'en-US', '0', '2013-01-25 08:50:58');
INSERT INTO `users_device_login` VALUES ('888', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', '192.168.1.139', '', '56372', 'en-US', '0', '2013-01-25 09:13:05');
INSERT INTO `users_device_login` VALUES ('889', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '57048', 'es-ES', '0', '2013-01-25 10:32:15');
INSERT INTO `users_device_login` VALUES ('890', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', '192.168.1.139', '', '59171', 'en-US', '0', '2013-01-25 11:51:22');
INSERT INTO `users_device_login` VALUES ('891', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '60949', 'es-ES', '0', '2013-01-25 14:01:19');
INSERT INTO `users_device_login` VALUES ('892', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '61739', 'es-ES', '0', '2013-01-25 14:29:40');
INSERT INTO `users_device_login` VALUES ('893', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.123', '', '56628', 'es-ES', '0', '2013-01-25 14:49:45');
INSERT INTO `users_device_login` VALUES ('894', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', '192.168.1.139', '', '49587', 'en-US', '0', '2013-01-28 09:10:29');
INSERT INTO `users_device_login` VALUES ('895', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', '192.168.1.139', '', '51712', 'en-US', '0', '2013-01-28 13:16:46');
INSERT INTO `users_device_login` VALUES ('896', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '56942', 'es-ES', '0', '2013-01-29 12:05:42');
INSERT INTO `users_device_login` VALUES ('897', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', '192.168.1.139', '', '61277', 'en-US', '0', '2013-01-29 15:33:33');
INSERT INTO `users_device_login` VALUES ('898', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '61868', 'es-ES', '0', '2013-01-29 15:41:09');
INSERT INTO `users_device_login` VALUES ('899', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', '192.168.1.139', '', '54493', 'en-US', '0', '2013-01-30 11:13:31');
INSERT INTO `users_device_login` VALUES ('900', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17', '192.168.1.139', '', '49324', 'en-US', '0', '2013-01-30 11:44:46');
INSERT INTO `users_device_login` VALUES ('901', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '52996', 'es-ES', '0', '2013-01-30 15:21:18');
INSERT INTO `users_device_login` VALUES ('902', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '55068', 'es-ES', '0', '2013-01-30 16:38:22');
INSERT INTO `users_device_login` VALUES ('903', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '56214', 'en-US', '0', '2013-01-31 17:00:35');
INSERT INTO `users_device_login` VALUES ('904', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '49687', 'en-US', '0', '2013-02-01 09:13:36');
INSERT INTO `users_device_login` VALUES ('905', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '51435', 'en-US', '0', '2013-02-01 11:35:52');
INSERT INTO `users_device_login` VALUES ('906', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '52112', 'es-ES', '0', '2013-02-01 12:34:44');
INSERT INTO `users_device_login` VALUES ('907', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '56186', 'en-US', '0', '2013-02-04 10:09:59');
INSERT INTO `users_device_login` VALUES ('908', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '56991', 'en-US', '0', '2013-02-04 11:28:27');
INSERT INTO `users_device_login` VALUES ('909', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '49912', 'en-US', '0', '2013-02-05 09:01:46');
INSERT INTO `users_device_login` VALUES ('910', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '52666', 'en-US', '1', '2013-02-05 13:47:15');
INSERT INTO `users_device_login` VALUES ('911', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '53054', 'en-US', '1', '2013-02-05 14:18:04');
INSERT INTO `users_device_login` VALUES ('912', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '53054', 'en-US', '0', '2013-02-05 14:18:05');
INSERT INTO `users_device_login` VALUES ('913', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '53134', 'en-US', '0', '2013-02-05 14:26:06');
INSERT INTO `users_device_login` VALUES ('914', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '49853', 'en-US', '0', '2013-02-06 13:52:29');
INSERT INTO `users_device_login` VALUES ('915', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '52811', 'en-US', '1', '2013-02-06 16:33:58');
INSERT INTO `users_device_login` VALUES ('916', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '52834', 'en-US', '0', '2013-02-06 16:37:01');
INSERT INTO `users_device_login` VALUES ('917', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '52853', 'en-US', '1', '2013-02-06 16:40:10');
INSERT INTO `users_device_login` VALUES ('918', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '54989', 'en-US', '0', '2013-02-07 10:39:08');
INSERT INTO `users_device_login` VALUES ('919', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '54989', 'en-US', '0', '2013-02-07 10:39:09');
INSERT INTO `users_device_login` VALUES ('920', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '55002', 'en-US', '1', '2013-02-07 10:40:17');
INSERT INTO `users_device_login` VALUES ('921', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '55023', 'en-US', '0', '2013-02-07 10:40:52');
INSERT INTO `users_device_login` VALUES ('922', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '55023', 'en-US', '0', '2013-02-07 10:40:53');
INSERT INTO `users_device_login` VALUES ('923', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '60504', 'en-US', '0', '2013-02-08 08:16:33');
INSERT INTO `users_device_login` VALUES ('924', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '61223', 'en-US', '1', '2013-02-08 09:21:22');
INSERT INTO `users_device_login` VALUES ('925', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '62632', 'en-US', '0', '2013-02-15 15:55:51');
INSERT INTO `users_device_login` VALUES ('926', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '50340', 'en-US', '0', '2013-02-16 12:06:31');
INSERT INTO `users_device_login` VALUES ('927', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '49892', 'en-US', '0', '2013-02-18 09:34:15');
INSERT INTO `users_device_login` VALUES ('928', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '50786', 'en-US', '1', '2013-02-18 10:37:31');
INSERT INTO `users_device_login` VALUES ('929', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '55955', 'es-ES', '0', '2013-02-18 15:47:49');
INSERT INTO `users_device_login` VALUES ('930', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '63541', 'en-US', '0', '2013-02-19 11:21:22');
INSERT INTO `users_device_login` VALUES ('931', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '49302', 'es-ES', '0', '2013-02-19 14:32:07');
INSERT INTO `users_device_login` VALUES ('932', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:18.0) Gecko/20100101 Firefox/18.0', '192.168.1.139', '', '49322', 'es-ES', '0', '2013-02-19 14:33:53');
INSERT INTO `users_device_login` VALUES ('933', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '52565', 'en-US', '0', '2013-02-19 17:12:23');
INSERT INTO `users_device_login` VALUES ('934', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '50084', 'en-US', '0', '2013-02-20 09:31:41');
INSERT INTO `users_device_login` VALUES ('935', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '50173', 'en-US', '0', '2013-02-20 09:35:58');
INSERT INTO `users_device_login` VALUES ('936', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '50002', 'en-US', '0', '2013-02-21 09:42:18');
INSERT INTO `users_device_login` VALUES ('937', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '51454', 'en-US', '0', '2013-02-22 08:51:31');
INSERT INTO `users_device_login` VALUES ('938', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.104', '', '49922', 'es-ES', '1', '2013-02-22 14:53:13');
INSERT INTO `users_device_login` VALUES ('939', '0', 'Mozilla/5.0 (Linux; U; Android 4.0.4; en-us; SAMSUNG-SGH-I727 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '192.168.1.105', '', '40662', 'en-US', '1', '2013-02-22 15:02:07');
INSERT INTO `users_device_login` VALUES ('940', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '54315', 'en-US', '0', '2013-02-25 13:31:32');
INSERT INTO `users_device_login` VALUES ('941', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '192.168.1.139', '', '56733', 'en-US', '0', '2013-02-25 16:02:01');
INSERT INTO `users_device_login` VALUES ('942', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.99 Safari/537.22', '192.168.1.139', '', '50054', 'en-US', '0', '2013-02-27 10:44:39');
INSERT INTO `users_device_login` VALUES ('943', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.99 Safari/537.22', '192.168.1.139', '', '50965', 'en-US', '0', '2013-02-27 12:14:11');
INSERT INTO `users_device_login` VALUES ('944', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.99 Safari/537.22', '192.168.1.139', '', '49732', 'en-US', '0', '2013-03-01 09:18:28');
INSERT INTO `users_device_login` VALUES ('945', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.99 Safari/537.22', '192.168.1.139', '', '49872', 'en-US', '0', '2013-03-01 09:26:11');
INSERT INTO `users_device_login` VALUES ('946', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.99 Safari/537.22', '192.168.1.139', '', '54294', 'en-US', '0', '2013-03-01 16:59:50');
INSERT INTO `users_device_login` VALUES ('947', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.99 Safari/537.22', '192.168.1.139', '', '60182', 'en-US', '0', '2013-03-02 12:54:59');
INSERT INTO `users_device_login` VALUES ('948', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.152 Safari/537.22', '192.168.1.139', '', '52609', 'en-US', '0', '2013-03-04 13:40:40');
INSERT INTO `users_device_login` VALUES ('949', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '52625', 'es-ES', '0', '2013-03-04 13:41:08');
INSERT INTO `users_device_login` VALUES ('950', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.105', '', '56790', 'es-ES', '1', '2013-03-05 17:06:06');
INSERT INTO `users_device_login` VALUES ('951', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.105', '', '59558', 'es-ES', '1', '2013-03-05 17:11:35');
INSERT INTO `users_device_login` VALUES ('952', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.152 Safari/537.22', '::1', '', '60971', 'en-US', '0', '2013-03-06 08:52:21');
INSERT INTO `users_device_login` VALUES ('953', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.152 Safari/537.22', '192.168.1.139', '', '61225', 'en-US', '0', '2013-03-06 09:03:15');
INSERT INTO `users_device_login` VALUES ('954', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.152 Safari/537.22', '192.168.1.134', '', '62846', 'en-US', '0', '2013-03-06 09:23:05');
INSERT INTO `users_device_login` VALUES ('955', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.155 Safari/537.22', '192.168.1.139', '', '50321', 'en-US', '0', '2013-03-08 09:09:45');
INSERT INTO `users_device_login` VALUES ('956', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '51131', 'es-ES', '0', '2013-03-08 10:04:07');
INSERT INTO `users_device_login` VALUES ('957', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '50813', 'es-ES', '0', '2013-03-11 15:43:05');
INSERT INTO `users_device_login` VALUES ('958', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.160 Safari/537.22', '192.168.1.134', '', '57445', 'en-US', '0', '2013-03-12 09:27:02');
INSERT INTO `users_device_login` VALUES ('959', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '59666', 'es-ES', '0', '2013-03-12 09:34:27');
INSERT INTO `users_device_login` VALUES ('960', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22', '192.168.1.139', '', '50749', 'en-US', '0', '2013-03-14 10:09:58');
INSERT INTO `users_device_login` VALUES ('961', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22', '192.168.1.134', '', '51940', 'en-US', '0', '2013-03-14 12:16:28');
INSERT INTO `users_device_login` VALUES ('962', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '55770', 'es-ES', '0', '2013-03-14 14:49:45');
INSERT INTO `users_device_login` VALUES ('963', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '55947', 'es-ES', '0', '2013-03-14 14:54:51');
INSERT INTO `users_device_login` VALUES ('964', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '49486', 'es-ES', '0', '2013-03-15 13:24:59');
INSERT INTO `users_device_login` VALUES ('965', '0', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22', '192.168.1.123', '', '53905', 'es-ES', '0', '2013-03-15 13:28:12');
INSERT INTO `users_device_login` VALUES ('966', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '51923', 'es-ES', '0', '2013-03-15 14:38:41');
INSERT INTO `users_device_login` VALUES ('967', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22', '192.168.1.139', '', '57507', 'en-US', '0', '2013-03-18 09:42:09');
INSERT INTO `users_device_login` VALUES ('968', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '57824', 'es-ES', '0', '2013-03-18 10:06:03');
INSERT INTO `users_device_login` VALUES ('969', '0', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.101', '', '51814', 'es-es', '1', '2013-03-18 15:45:04');
INSERT INTO `users_device_login` VALUES ('970', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22', '192.168.1.139', '', '57328', 'en-US', '0', '2013-03-19 15:52:48');
INSERT INTO `users_device_login` VALUES ('971', '0', 'Mozilla/5.0 (Linux; U; Android 4.0.4; en-us; SAMSUNG-SGH-I727 Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '192.168.1.107', '', '56791', 'en-US', '1', '2013-03-20 10:45:09');
INSERT INTO `users_device_login` VALUES ('972', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22', '192.168.1.139', '', '56912', 'en-US', '0', '2013-03-20 14:43:28');
INSERT INTO `users_device_login` VALUES ('973', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22', '192.168.1.139', '', '54383', 'en-US', '0', '2013-03-22 10:54:43');
INSERT INTO `users_device_login` VALUES ('974', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22', '192.168.1.139', '', '58294', 'en-US', '0', '2013-03-22 13:51:52');
INSERT INTO `users_device_login` VALUES ('975', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '59276', 'es-ES', '0', '2013-03-22 14:37:04');
INSERT INTO `users_device_login` VALUES ('976', '0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22', '192.168.1.139', '', '62557', 'en-US', '0', '2013-03-26 08:38:26');
INSERT INTO `users_device_login` VALUES ('977', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '47347', 'es-ES', '1', '2013-03-27 11:40:38');
INSERT INTO `users_device_login` VALUES ('978', '0', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '60871', 'es-ES', '1', '2013-04-01 10:57:22');
INSERT INTO `users_device_login` VALUES ('979', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '44993', 'es-ES', '1', '2013-04-01 11:09:50');
INSERT INTO `users_device_login` VALUES ('980', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '56415', 'es-ES', '1', '2013-04-01 13:28:35');
INSERT INTO `users_device_login` VALUES ('981', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '42161', 'es-ES', '1', '2013-04-01 13:42:58');
INSERT INTO `users_device_login` VALUES ('982', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '59246', 'es-ES', '1', '2013-04-01 14:23:14');
INSERT INTO `users_device_login` VALUES ('983', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '50600', 'es-ES', '1', '2013-04-01 14:56:17');
INSERT INTO `users_device_login` VALUES ('984', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '34738', 'es-ES', '1', '2013-04-01 15:40:48');
INSERT INTO `users_device_login` VALUES ('985', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '38925', 'es-ES', '1', '2013-04-03 14:48:40');
INSERT INTO `users_device_login` VALUES ('986', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '48761', 'es-ES', '1', '2013-04-03 14:59:09');
INSERT INTO `users_device_login` VALUES ('987', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '54260', 'es-ES', '1', '2013-04-03 15:05:54');
INSERT INTO `users_device_login` VALUES ('988', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '47599', 'es-ES', '1', '2013-04-03 15:19:35');
INSERT INTO `users_device_login` VALUES ('989', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '49760', 'es-ES', '1', '2013-04-03 15:39:53');
INSERT INTO `users_device_login` VALUES ('990', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '34657', 'es-ES', '1', '2013-04-03 15:47:21');
INSERT INTO `users_device_login` VALUES ('991', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '50891', 'es-ES', '1', '2013-04-03 16:07:21');
INSERT INTO `users_device_login` VALUES ('992', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '55428', 'es-ES', '1', '2013-04-03 16:15:19');
INSERT INTO `users_device_login` VALUES ('993', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '40894', 'es-ES', '1', '2013-04-03 16:33:46');
INSERT INTO `users_device_login` VALUES ('994', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '53293', 'es-ES', '1', '2013-04-04 10:10:23');
INSERT INTO `users_device_login` VALUES ('995', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '47122', 'es-ES', '1', '2013-04-04 10:30:36');
INSERT INTO `users_device_login` VALUES ('996', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.139', '', '52965', 'en-US', '0', '2013-04-04 13:55:49');
INSERT INTO `users_device_login` VALUES ('997', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.139', '', '53026', 'en-US', '0', '2013-04-04 14:03:14');
INSERT INTO `users_device_login` VALUES ('998', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.139', '', '53202', 'en-US', '1', '2013-04-04 14:18:35');
INSERT INTO `users_device_login` VALUES ('999', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '41107', 'es-ES', '1', '2013-04-04 14:21:15');
INSERT INTO `users_device_login` VALUES ('1000', '2', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.101', '', '52943', 'es-es', '1', '2013-04-04 15:35:23');
INSERT INTO `users_device_login` VALUES ('1001', '125', 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_1_2 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B146 Safari/8536.25', '192.168.1.102', '', '49938', 'es-es', '1', '2013-04-04 15:38:58');
INSERT INTO `users_device_login` VALUES ('1002', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.106', '', '51366', 'es-ES', '1', '2013-04-04 15:39:42');
INSERT INTO `users_device_login` VALUES ('1003', '2', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.101', '', '53038', 'es-es', '1', '2013-04-04 16:14:22');
INSERT INTO `users_device_login` VALUES ('1004', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.139', '', '55883', 'en-US', '0', '2013-04-05 09:52:28');
INSERT INTO `users_device_login` VALUES ('1005', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '55939', 'es-ES', '0', '2013-04-05 09:54:56');
INSERT INTO `users_device_login` VALUES ('1006', '101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/536.26.17 (KHTML, like Gecko) Version/6.0.2 Safari/536.26.17', '192.168.1.139', '', '56445', 'en-us', '0', '2013-04-05 10:29:54');
INSERT INTO `users_device_login` VALUES ('1007', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:19.0) Gecko/20100101 Firefox/19.0', '192.168.1.139', '', '58030', 'es-ES', '0', '2013-04-05 11:32:30');
INSERT INTO `users_device_login` VALUES ('1008', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.139', '', '55956', 'en-US', '0', '2013-04-08 14:26:37');
INSERT INTO `users_device_login` VALUES ('1009', '2', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.102', '', '54298', 'es-es', '1', '2013-04-09 13:54:04');
INSERT INTO `users_device_login` VALUES ('1010', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.65 Safari/537.31', '192.168.1.139', '', '49927', 'en-US', '0', '2013-04-15 08:00:10');
INSERT INTO `users_device_login` VALUES ('1011', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.65 Safari/537.31', '192.168.1.139', '', '54780', 'en-US', '0', '2013-04-15 12:00:02');
INSERT INTO `users_device_login` VALUES ('1012', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.65 Safari/537.31', '192.168.1.134', '', '64807', 'en-US', '0', '2013-04-16 09:07:49');
INSERT INTO `users_device_login` VALUES ('1013', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.65 Safari/537.31', '192.168.1.139', '', '60434', 'en-US', '0', '2013-04-16 09:45:20');
INSERT INTO `users_device_login` VALUES ('1014', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.107', '', '55895', 'es-ES', '1', '2013-04-16 10:36:28');
INSERT INTO `users_device_login` VALUES ('1015', '101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.65 Safari/537.31', '192.168.1.139', '', '62167', 'en-US', '0', '2013-04-16 10:40:18');
INSERT INTO `users_device_login` VALUES ('1016', '101', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.107', '', '49967', 'es-ES', '1', '2013-04-16 10:48:01');
INSERT INTO `users_device_login` VALUES ('1017', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.107', '', '48895', 'es-ES', '1', '2013-04-16 10:52:01');
INSERT INTO `users_device_login` VALUES ('1018', '2', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.107', '', '55101', 'es-ES', '1', '2013-04-16 10:53:16');
INSERT INTO `users_device_login` VALUES ('1019', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '51232', 'es-419', '0', '2013-04-16 10:54:08');
INSERT INTO `users_device_login` VALUES ('1020', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '51410', 'es-VE', '0', '2013-04-16 10:56:49');
INSERT INTO `users_device_login` VALUES ('1021', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0', '192.168.1.141', '', '51777', 'es-cl', '0', '2013-04-16 11:01:32');
INSERT INTO `users_device_login` VALUES ('1022', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0', '192.168.1.141', '', '51778', 'es-cl', '0', '2013-04-16 11:01:33');
INSERT INTO `users_device_login` VALUES ('1023', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '55969', 'es-VE', '0', '2013-04-16 14:15:33');
INSERT INTO `users_device_login` VALUES ('1024', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.65 Safari/537.31', '192.168.1.139', '', '58536', 'en-US', '1', '2013-04-17 09:21:39');
INSERT INTO `users_device_login` VALUES ('1025', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '58195', 'es-419', '0', '2013-04-18 13:25:51');
INSERT INTO `users_device_login` VALUES ('1026', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '58622', 'es-419', '0', '2013-04-18 13:54:41');
INSERT INTO `users_device_login` VALUES ('1027', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '58725', 'es-419', '0', '2013-04-18 14:02:00');
INSERT INTO `users_device_login` VALUES ('1028', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '58750', 'es-419', '0', '2013-04-18 14:03:09');
INSERT INTO `users_device_login` VALUES ('1029', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '58758', 'es-419', '0', '2013-04-18 14:03:30');
INSERT INTO `users_device_login` VALUES ('1030', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '58788', 'es-419', '0', '2013-04-18 14:04:44');
INSERT INTO `users_device_login` VALUES ('1031', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '58802', 'es-VE', '0', '2013-04-18 14:05:04');
INSERT INTO `users_device_login` VALUES ('1032', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0', '192.168.1.141', '', '58855', 'es-cl', '0', '2013-04-18 14:06:09');
INSERT INTO `users_device_login` VALUES ('1033', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0', '192.168.1.141', '', '59064', 'es-cl', '0', '2013-04-18 14:11:12');
INSERT INTO `users_device_login` VALUES ('1034', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '59324', 'es-419', '0', '2013-04-18 14:16:45');
INSERT INTO `users_device_login` VALUES ('1035', '187', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '59573', 'es-419', '0', '2013-04-18 14:21:09');
INSERT INTO `users_device_login` VALUES ('1036', '187', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '59574', 'es-419', '0', '2013-04-18 14:21:09');
INSERT INTO `users_device_login` VALUES ('1037', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '60029', 'es-419', '0', '2013-04-18 14:27:51');
INSERT INTO `users_device_login` VALUES ('1038', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '60766', 'es-419', '0', '2013-04-18 14:40:24');
INSERT INTO `users_device_login` VALUES ('1039', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '60783', 'es-419', '0', '2013-04-18 14:40:50');
INSERT INTO `users_device_login` VALUES ('1040', '188', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '60929', 'es-419', '0', '2013-04-18 14:43:49');
INSERT INTO `users_device_login` VALUES ('1041', '188', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '60930', 'es-419', '0', '2013-04-18 14:43:49');
INSERT INTO `users_device_login` VALUES ('1042', '189', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '32976', 'es-419', '0', '2013-04-18 14:49:33');
INSERT INTO `users_device_login` VALUES ('1043', '189', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '32977', 'es-419', '0', '2013-04-18 14:49:33');
INSERT INTO `users_device_login` VALUES ('1044', '189', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33077', 'es-419', '0', '2013-04-18 14:51:51');
INSERT INTO `users_device_login` VALUES ('1045', '189', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33199', 'es-419', '0', '2013-04-18 14:54:34');
INSERT INTO `users_device_login` VALUES ('1046', '189', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33200', 'es-419', '0', '2013-04-18 14:54:34');
INSERT INTO `users_device_login` VALUES ('1047', '189', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33254', 'es-419', '0', '2013-04-18 14:55:42');
INSERT INTO `users_device_login` VALUES ('1048', '190', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33315', 'es-419', '0', '2013-04-18 14:56:57');
INSERT INTO `users_device_login` VALUES ('1049', '190', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33385', 'es-419', '0', '2013-04-18 14:58:22');
INSERT INTO `users_device_login` VALUES ('1050', '190', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33437', 'es-419', '0', '2013-04-18 14:59:25');
INSERT INTO `users_device_login` VALUES ('1051', '190', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33438', 'es-419', '0', '2013-04-18 14:59:25');
INSERT INTO `users_device_login` VALUES ('1052', '192', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33681', 'es-419', '0', '2013-04-18 15:13:59');
INSERT INTO `users_device_login` VALUES ('1053', '192', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33682', 'es-419', '0', '2013-04-18 15:13:59');
INSERT INTO `users_device_login` VALUES ('1054', '192', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33733', 'es-419', '0', '2013-04-18 15:15:48');
INSERT INTO `users_device_login` VALUES ('1055', '192', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33748', 'es-419', '0', '2013-04-18 15:16:15');
INSERT INTO `users_device_login` VALUES ('1056', '193', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33912', 'es-419', '0', '2013-04-18 15:25:55');
INSERT INTO `users_device_login` VALUES ('1057', '193', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33913', 'es-419', '0', '2013-04-18 15:25:55');
INSERT INTO `users_device_login` VALUES ('1058', '194', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '34136', 'es-419', '0', '2013-04-18 15:35:46');
INSERT INTO `users_device_login` VALUES ('1059', '195', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '34355', 'es-419', '0', '2013-04-18 15:43:10');
INSERT INTO `users_device_login` VALUES ('1060', '195', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '34356', 'es-419', '0', '2013-04-18 15:43:10');
INSERT INTO `users_device_login` VALUES ('1061', '195', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '34367', 'es-419', '0', '2013-04-18 15:43:20');
INSERT INTO `users_device_login` VALUES ('1062', '195', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '34371', 'es-419', '0', '2013-04-18 15:43:30');
INSERT INTO `users_device_login` VALUES ('1063', '196', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '34409', 'es-419', '0', '2013-04-18 15:45:04');
INSERT INTO `users_device_login` VALUES ('1064', '196', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '34410', 'es-419', '0', '2013-04-18 15:45:04');
INSERT INTO `users_device_login` VALUES ('1065', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '35701', 'es-VE', '0', '2013-04-18 16:24:11');
INSERT INTO `users_device_login` VALUES ('1066', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '35750', 'es-419', '0', '2013-04-18 16:24:51');
INSERT INTO `users_device_login` VALUES ('1067', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '36244', 'es-419', '0', '2013-04-18 16:32:34');
INSERT INTO `users_device_login` VALUES ('1068', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '36243', 'es-419', '0', '2013-04-18 16:32:34');
INSERT INTO `users_device_login` VALUES ('1069', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '37275', 'es-419', '0', '2013-04-18 17:00:27');
INSERT INTO `users_device_login` VALUES ('1070', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '44920', 'es-419', '0', '2013-04-22 08:53:44');
INSERT INTO `users_device_login` VALUES ('1071', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '45016', 'es-VE', '0', '2013-04-22 08:58:54');
INSERT INTO `users_device_login` VALUES ('1072', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '46518', 'es-419', '0', '2013-04-22 09:27:38');
INSERT INTO `users_device_login` VALUES ('1073', '101', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0', '192.168.1.141', '', '46599', 'es-cl', '0', '2013-04-22 09:30:01');
INSERT INTO `users_device_login` VALUES ('1074', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '55323', 'es-VE', '0', '2013-04-22 14:13:33');
INSERT INTO `users_device_login` VALUES ('1075', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '51292', 'es-419', '0', '2013-04-23 08:21:43');
INSERT INTO `users_device_login` VALUES ('1076', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '57008', 'es-419', '0', '2013-04-24 08:26:59');
INSERT INTO `users_device_login` VALUES ('1077', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.103', '', '59718', 'en-GB', '1', '2013-04-24 08:55:04');
INSERT INTO `users_device_login` VALUES ('1078', '2', 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_1 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B142 Safari/8536.25', '192.168.1.105', '', '52502', 'en-us', '1', '2013-04-24 09:50:38');
INSERT INTO `users_device_login` VALUES ('1079', '197', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.103', '', '38096', 'en-GB', '1', '2013-04-24 09:50:48');
INSERT INTO `users_device_login` VALUES ('1080', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.103', '', '58355', 'en-GB', '1', '2013-04-24 10:27:08');
INSERT INTO `users_device_login` VALUES ('1081', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '59495', 'es-VE', '0', '2013-04-24 10:28:01');
INSERT INTO `users_device_login` VALUES ('1082', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.103', '', '46518', 'en-GB', '1', '2013-04-24 10:57:28');
INSERT INTO `users_device_login` VALUES ('1083', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.103', '', '33444', 'en-GB', '1', '2013-04-24 11:16:11');
INSERT INTO `users_device_login` VALUES ('1084', '197', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.103', '', '36809', 'en-GB', '1', '2013-04-24 11:28:36');
INSERT INTO `users_device_login` VALUES ('1085', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.103', '', '58322', 'en-GB', '1', '2013-04-24 11:30:46');
INSERT INTO `users_device_login` VALUES ('1086', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '43510', 'es-419', '0', '2013-04-24 13:04:49');
INSERT INTO `users_device_login` VALUES ('1087', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '43696', 'es-419', '1', '2013-04-24 13:21:01');
INSERT INTO `users_device_login` VALUES ('1088', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.103', '', '48878', 'en-GB', '1', '2013-04-24 13:25:18');
INSERT INTO `users_device_login` VALUES ('1089', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.103', '', '33433', 'en-GB', '1', '2013-04-24 13:39:49');
INSERT INTO `users_device_login` VALUES ('1090', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '44666', 'es-419', '1', '2013-04-24 14:16:28');
INSERT INTO `users_device_login` VALUES ('1091', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '45229', 'es-419', '1', '2013-04-24 15:15:50');
INSERT INTO `users_device_login` VALUES ('1092', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '45781', 'es-419', '1', '2013-04-24 15:49:35');
INSERT INTO `users_device_login` VALUES ('1093', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '45965', 'es-419', '1', '2013-04-24 16:26:27');
INSERT INTO `users_device_login` VALUES ('1094', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.109', '', '50311', 'es-es', '1', '2013-04-24 16:35:25');
INSERT INTO `users_device_login` VALUES ('1095', '101', 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_1_2 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B146 Safari/8536.25', '192.168.1.101', '', '51510', 'es-es', '1', '2013-04-24 16:37:28');
INSERT INTO `users_device_login` VALUES ('1096', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '34307', 'es-419', '0', '2013-04-25 08:18:20');
INSERT INTO `users_device_login` VALUES ('1097', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.109', '', '49346', 'es-es', '1', '2013-04-25 09:13:47');
INSERT INTO `users_device_login` VALUES ('1098', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.103', '', '34377', 'en-GB', '1', '2013-04-25 10:07:08');
INSERT INTO `users_device_login` VALUES ('1099', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.131', '', '49571', 'es-es', '1', '2013-04-25 11:45:04');
INSERT INTO `users_device_login` VALUES ('1100', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.131', '', '49631', 'es-es', '1', '2013-04-25 13:17:53');
INSERT INTO `users_device_login` VALUES ('1101', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '45584', 'es-VE', '0', '2013-04-25 15:09:36');
INSERT INTO `users_device_login` VALUES ('1102', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '48275', 'es-419', '0', '2013-04-25 16:19:34');
INSERT INTO `users_device_login` VALUES ('1103', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.131', '', '49967', 'es-es', '1', '2013-04-25 17:06:25');
INSERT INTO `users_device_login` VALUES ('1104', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.131', '', '49991', 'es-es', '1', '2013-04-25 17:09:52');
INSERT INTO `users_device_login` VALUES ('1105', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; en-gb; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.127', '', '51827', 'en-GB', '1', '2013-04-26 08:55:40');
INSERT INTO `users_device_login` VALUES ('1106', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '44654', 'es-419', '0', '2013-04-26 08:58:30');
INSERT INTO `users_device_login` VALUES ('1107', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.131', '', '50092', 'es-es', '1', '2013-04-26 09:10:28');
INSERT INTO `users_device_login` VALUES ('1108', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.131', '', '50114', 'es-es', '1', '2013-04-26 09:25:48');
INSERT INTO `users_device_login` VALUES ('1109', '199', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '45277', 'es-419', '1', '2013-04-26 09:35:18');
INSERT INTO `users_device_login` VALUES ('1110', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '45425', 'es-419', '0', '2013-04-26 09:42:40');
INSERT INTO `users_device_login` VALUES ('1111', '199', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '45443', 'es-419', '0', '2013-04-26 09:43:29');
INSERT INTO `users_device_login` VALUES ('1112', '199', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '45452', 'es-419', '0', '2013-04-26 09:43:47');
INSERT INTO `users_device_login` VALUES ('1113', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '45519', 'es-419', '0', '2013-04-26 09:47:59');
INSERT INTO `users_device_login` VALUES ('1114', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '45674', 'es-VE', '0', '2013-04-26 09:51:58');
INSERT INTO `users_device_login` VALUES ('1115', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '46256', 'es-419', '0', '2013-04-26 10:07:18');
INSERT INTO `users_device_login` VALUES ('1116', '199', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.131', '', '50160', 'es-es', '1', '2013-04-26 10:16:16');
INSERT INTO `users_device_login` VALUES ('1117', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.131', '', '50437', 'es-es', '1', '2013-04-26 10:41:33');
INSERT INTO `users_device_login` VALUES ('1118', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '49650', 'es-419', '1', '2013-04-26 11:40:28');
INSERT INTO `users_device_login` VALUES ('1119', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.131', '', '50787', 'es-es', '1', '2013-04-26 13:59:19');
INSERT INTO `users_device_login` VALUES ('1120', '101', 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_1_2 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B146 Safari/8536.25', '192.168.1.122', '', '50227', 'es-es', '1', '2013-04-26 14:05:10');
INSERT INTO `users_device_login` VALUES ('1121', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '47841', 'es-419', '0', '2013-04-29 08:38:04');
INSERT INTO `users_device_login` VALUES ('1122', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '48211', 'es-419', '0', '2013-04-29 08:50:38');
INSERT INTO `users_device_login` VALUES ('1123', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '57230', 'es-419', '0', '2013-04-29 14:34:56');
INSERT INTO `users_device_login` VALUES ('1124', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '60897', 'es-VE', '0', '2013-04-29 16:53:49');
INSERT INTO `users_device_login` VALUES ('1125', '7', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '32844', 'es-VE', '0', '2013-04-29 16:56:10');
INSERT INTO `users_device_login` VALUES ('1126', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '32947', 'es-VE', '0', '2013-04-29 16:57:18');
INSERT INTO `users_device_login` VALUES ('1127', '7', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '33004', 'es-VE', '0', '2013-04-29 16:58:16');
INSERT INTO `users_device_login` VALUES ('1128', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '39388', 'es-419', '0', '2013-04-30 08:33:35');
INSERT INTO `users_device_login` VALUES ('1129', '2', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.130', '', '50817', 'es-VE', '0', '2013-04-30 10:17:14');
INSERT INTO `users_device_login` VALUES ('1130', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.43 Safari/537.31', '192.168.1.141', '', '33263', 'es-419', '0', '2013-05-02 08:37:31');
INSERT INTO `users_device_login` VALUES ('1131', '7', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '34152', 'es-VE', '0', '2013-05-02 08:55:20');
INSERT INTO `users_device_login` VALUES ('1132', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0', '192.168.1.141', '', '36273', 'es-cl', '0', '2013-05-02 09:51:10');
INSERT INTO `users_device_login` VALUES ('1133', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '52021', 'es-419', '1', '2013-05-03 09:00:51');
INSERT INTO `users_device_login` VALUES ('1134', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '52031', 'es-419', '0', '2013-05-03 09:01:15');
INSERT INTO `users_device_login` VALUES ('1135', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '52316', 'es-419', '1', '2013-05-03 09:06:11');
INSERT INTO `users_device_login` VALUES ('1136', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '52341', 'es-419', '0', '2013-05-03 09:07:58');
INSERT INTO `users_device_login` VALUES ('1137', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '52644', 'es-419', '1', '2013-05-03 09:28:34');
INSERT INTO `users_device_login` VALUES ('1138', '7', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '52675', 'es-VE', '0', '2013-05-03 09:30:02');
INSERT INTO `users_device_login` VALUES ('1139', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '53841', 'es-419', '1', '2013-05-03 10:15:40');
INSERT INTO `users_device_login` VALUES ('1140', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '54071', 'es-419', '0', '2013-05-03 10:24:56');
INSERT INTO `users_device_login` VALUES ('1141', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '54326', 'es-419', '1', '2013-05-03 10:35:54');
INSERT INTO `users_device_login` VALUES ('1142', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '56034', 'es-419', '1', '2013-05-03 11:15:12');
INSERT INTO `users_device_login` VALUES ('1143', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '56053', 'es-VE', '0', '2013-05-03 11:16:26');
INSERT INTO `users_device_login` VALUES ('1144', '201', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '60723', 'es-419', '1', '2013-05-03 14:04:23');
INSERT INTO `users_device_login` VALUES ('1145', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '59974', 'es-419', '0', '2013-05-06 09:38:14');
INSERT INTO `users_device_login` VALUES ('1146', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '60910', 'es-419', '1', '2013-05-06 10:25:22');
INSERT INTO `users_device_login` VALUES ('1147', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '60958', 'es-419', '1', '2013-05-06 10:27:13');
INSERT INTO `users_device_login` VALUES ('1148', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '33069', 'es-419', '1', '2013-05-06 10:43:41');
INSERT INTO `users_device_login` VALUES ('1149', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '33144', 'es-419', '1', '2013-05-06 10:48:31');
INSERT INTO `users_device_login` VALUES ('1150', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '33220', 'es-419', '1', '2013-05-06 10:50:32');
INSERT INTO `users_device_login` VALUES ('1151', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '33233', 'es-419', '0', '2013-05-06 10:50:48');
INSERT INTO `users_device_login` VALUES ('1152', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '33359', 'es-419', '0', '2013-05-06 10:58:52');
INSERT INTO `users_device_login` VALUES ('1153', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '33360', 'es-419', '0', '2013-05-06 10:58:52');
INSERT INTO `users_device_login` VALUES ('1154', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0', '192.168.1.141', '', '33480', 'es-cl', '0', '2013-05-06 11:02:53');
INSERT INTO `users_device_login` VALUES ('1155', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '34655', 'es-419', '0', '2013-05-06 15:17:45');
INSERT INTO `users_device_login` VALUES ('1156', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0', '192.168.1.141', '', '36745', 'es-cl', '0', '2013-05-07 08:36:11');
INSERT INTO `users_device_login` VALUES ('1157', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '37292', 'es-VE', '0', '2013-05-07 08:51:11');
INSERT INTO `users_device_login` VALUES ('1158', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.105', '', '52834', 'es-ES', '1', '2013-05-07 14:00:32');
INSERT INTO `users_device_login` VALUES ('1159', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17 Phonegap/Cordova', '192.168.1.105', '', '56215', 'es-ES', '1', '2013-05-07 14:05:11');
INSERT INTO `users_device_login` VALUES ('1160', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '55957', 'es-VE', '0', '2013-05-07 14:17:55');
INSERT INTO `users_device_login` VALUES ('1161', '184', 'Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3', '192.168.1.101', '', '49805', 'es-es', '1', '2013-05-07 16:31:42');
INSERT INTO `users_device_login` VALUES ('1162', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '56648', 'es-419', '0', '2013-05-09 08:57:18');
INSERT INTO `users_device_login` VALUES ('1163', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '33244', 'es-419', '0', '2013-05-09 13:52:17');
INSERT INTO `users_device_login` VALUES ('1164', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '33329', 'es-419', '0', '2013-05-09 15:27:01');
INSERT INTO `users_device_login` VALUES ('1165', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '43281', 'es-419', '0', '2013-05-10 08:09:10');
INSERT INTO `users_device_login` VALUES ('1166', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '42525', 'es-419', '0', '2013-05-10 08:25:33');
INSERT INTO `users_device_login` VALUES ('1167', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '44871', 'es-419', '0', '2013-05-10 10:01:13');
INSERT INTO `users_device_login` VALUES ('1168', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '50134', 'es-419', '0', '2013-05-10 13:34:45');
INSERT INTO `users_device_login` VALUES ('1169', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '58762', 'es-419', '0', '2013-05-13 08:02:48');
INSERT INTO `users_device_login` VALUES ('1170', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '53566', 'es-419', '0', '2013-05-13 13:33:48');
INSERT INTO `users_device_login` VALUES ('1171', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '53742', 'es-419', '0', '2013-05-13 13:45:28');
INSERT INTO `users_device_login` VALUES ('1172', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '50185', 'es-419', '0', '2013-05-14 08:25:49');
INSERT INTO `users_device_login` VALUES ('1173', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '51158', 'es-419', '0', '2013-05-14 09:28:26');
INSERT INTO `users_device_login` VALUES ('1174', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '55283', 'es-419', '0', '2013-05-14 14:09:20');
INSERT INTO `users_device_login` VALUES ('1175', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '38598', 'es-419', '0', '2013-05-15 08:30:12');
INSERT INTO `users_device_login` VALUES ('1176', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '47075', 'es-419', '0', '2013-05-15 13:33:32');
INSERT INTO `users_device_login` VALUES ('1177', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '47117', 'es-419', '0', '2013-05-15 13:35:53');
INSERT INTO `users_device_login` VALUES ('1178', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0', '192.168.1.141', '', '49409', 'es-cl', '0', '2013-05-15 15:13:19');
INSERT INTO `users_device_login` VALUES ('1179', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '49597', 'es-VE', '0', '2013-05-15 15:19:10');
INSERT INTO `users_device_login` VALUES ('1180', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '54081', 'es-419', '0', '2013-05-16 08:11:39');
INSERT INTO `users_device_login` VALUES ('1181', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '55700', 'es-VE', '0', '2013-05-16 09:23:48');
INSERT INTO `users_device_login` VALUES ('1182', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '56506', 'es-VE', '0', '2013-05-16 09:32:41');
INSERT INTO `users_device_login` VALUES ('1183', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '56621', 'es-VE', '0', '2013-05-16 09:33:44');
INSERT INTO `users_device_login` VALUES ('1184', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '35949', 'es-VE', '0', '2013-05-16 13:23:44');
INSERT INTO `users_device_login` VALUES ('1185', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) Gecko/20100101 Firefox/20.0', '192.168.1.141', '', '36395', 'es-cl', '0', '2013-05-16 13:31:11');
INSERT INTO `users_device_login` VALUES ('1186', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '53586', 'es-419', '0', '2013-05-17 08:24:55');
INSERT INTO `users_device_login` VALUES ('1187', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '53693', 'es-VE', '0', '2013-05-17 08:25:33');
INSERT INTO `users_device_login` VALUES ('1188', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '55998', 'es-VE', '0', '2013-05-17 09:29:45');
INSERT INTO `users_device_login` VALUES ('1189', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.65 Safari/537.31', '192.168.1.139', '', '61451', 'en-US', '0', '2013-05-17 10:25:21');
INSERT INTO `users_device_login` VALUES ('1190', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '39173', 'es-419', '0', '2013-05-17 14:23:11');
INSERT INTO `users_device_login` VALUES ('1191', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '39475', 'es-419', '0', '2013-05-17 14:29:30');
INSERT INTO `users_device_login` VALUES ('1192', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '35848', 'es-419', '0', '2013-05-20 08:18:41');
INSERT INTO `users_device_login` VALUES ('1193', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '37544', 'es-VE', '0', '2013-05-20 09:12:32');
INSERT INTO `users_device_login` VALUES ('1194', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '42308', 'es-419', '0', '2013-05-20 11:15:18');
INSERT INTO `users_device_login` VALUES ('1195', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '38655', 'es-419', '0', '2013-05-20 13:34:15');
INSERT INTO `users_device_login` VALUES ('1196', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '39517', 'es-VE', '0', '2013-05-20 14:02:52');
INSERT INTO `users_device_login` VALUES ('1197', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '34435', 'es-419', '0', '2013-05-21 08:31:40');
INSERT INTO `users_device_login` VALUES ('1198', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '34647', 'es-VE', '0', '2013-05-21 08:38:57');
INSERT INTO `users_device_login` VALUES ('1199', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '57166', 'es-419', '0', '2013-05-21 16:54:21');
INSERT INTO `users_device_login` VALUES ('1200', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '57922', 'es-419', '0', '2013-05-22 08:21:30');
INSERT INTO `users_device_login` VALUES ('1201', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '58131', 'es-VE', '0', '2013-05-22 08:28:53');
INSERT INTO `users_device_login` VALUES ('1202', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '47799', 'es-419', '0', '2013-05-22 14:26:06');
INSERT INTO `users_device_login` VALUES ('1203', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31', '192.168.1.123', '', '63902', 'es-ES', '1', '2013-05-22 15:16:59');
INSERT INTO `users_device_login` VALUES ('1204', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.65 Safari/537.31', '192.168.1.139', '', '58618', 'en-US', '1', '2013-05-22 15:40:52');
INSERT INTO `users_device_login` VALUES ('1205', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31', '192.168.1.123', '', '64277', 'es-ES', '1', '2013-05-22 16:06:15');
INSERT INTO `users_device_login` VALUES ('1206', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31', '192.168.1.123', '', '64299', 'es-ES', '1', '2013-05-22 16:08:51');
INSERT INTO `users_device_login` VALUES ('1207', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31', '192.168.1.123', '', '64347', 'es-ES', '1', '2013-05-22 16:26:17');
INSERT INTO `users_device_login` VALUES ('1208', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '39607', 'es-419', '0', '2013-05-23 08:08:04');
INSERT INTO `users_device_login` VALUES ('1209', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '39760', 'es-VE', '0', '2013-05-23 08:10:51');
INSERT INTO `users_device_login` VALUES ('1210', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '40991', 'en-US', '0', '2013-05-23 08:35:55');
INSERT INTO `users_device_login` VALUES ('1211', '2', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.130', '', '60159', 'es-VE', '0', '2013-05-23 08:52:39');
INSERT INTO `users_device_login` VALUES ('1212', '2', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.130', '', '62197', 'es-VE', '0', '2013-05-23 09:32:56');
INSERT INTO `users_device_login` VALUES ('1213', '2', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.130', '', '57023', 'es-VE', '0', '2013-05-23 11:03:08');
INSERT INTO `users_device_login` VALUES ('1214', '184', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.100', '', '54635', 'en-us', '0', '2013-05-23 11:10:37');
INSERT INTO `users_device_login` VALUES ('1215', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31', '192.168.1.141', '', '34336', 'es-419', '0', '2013-05-23 15:28:41');
INSERT INTO `users_device_login` VALUES ('1216', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '59290', 'es-419', '1', '2013-05-24 08:07:00');
INSERT INTO `users_device_login` VALUES ('1217', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '33325', 'es-VE', '0', '2013-05-24 09:47:05');
INSERT INTO `users_device_login` VALUES ('1218', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '33900', 'es-cl', '0', '2013-05-24 10:02:49');
INSERT INTO `users_device_login` VALUES ('1219', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '36251', 'es-419', '0', '2013-05-24 10:53:10');
INSERT INTO `users_device_login` VALUES ('1220', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '53580', 'es-VE', '0', '2013-05-24 15:55:31');
INSERT INTO `users_device_login` VALUES ('1221', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '53080', 'es-419', '0', '2013-05-27 08:01:24');
INSERT INTO `users_device_login` VALUES ('1222', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '56580', 'es-VE', '0', '2013-05-27 10:05:24');
INSERT INTO `users_device_login` VALUES ('1223', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '60147', 'es-419', '0', '2013-05-27 11:18:26');
INSERT INTO `users_device_login` VALUES ('1224', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '41296', 'es-419', '0', '2013-05-27 13:30:06');
INSERT INTO `users_device_login` VALUES ('1225', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '45845', 'es-VE', '0', '2013-05-27 16:41:36');
INSERT INTO `users_device_login` VALUES ('1226', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '49716', 'es-419', '0', '2013-05-28 08:15:48');
INSERT INTO `users_device_login` VALUES ('1227', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '50669', 'es-419', '0', '2013-05-28 09:14:21');
INSERT INTO `users_device_login` VALUES ('1228', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '50680', 'es-419', '0', '2013-05-28 09:14:55');
INSERT INTO `users_device_login` VALUES ('1229', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '50819', 'es-419', '0', '2013-05-28 09:24:33');
INSERT INTO `users_device_login` VALUES ('1230', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '51599', 'es-VE', '0', '2013-05-28 09:27:55');
INSERT INTO `users_device_login` VALUES ('1231', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '51751', 'es-419', '0', '2013-05-28 09:31:40');
INSERT INTO `users_device_login` VALUES ('1232', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '51767', 'es-419', '0', '2013-05-28 09:32:11');
INSERT INTO `users_device_login` VALUES ('1233', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '39390', 'es-VE', '0', '2013-05-28 14:43:58');
INSERT INTO `users_device_login` VALUES ('1234', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '35294', 'es-419', '0', '2013-05-29 08:24:55');
INSERT INTO `users_device_login` VALUES ('1235', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '37860', 'es-VE', '0', '2013-05-29 08:56:30');
INSERT INTO `users_device_login` VALUES ('1236', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '47330', 'es-419', '0', '2013-05-29 10:38:50');
INSERT INTO `users_device_login` VALUES ('1237', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '52408', 'es-419', '0', '2013-05-29 14:25:56');
INSERT INTO `users_device_login` VALUES ('1238', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '54691', 'es-VE', '0', '2013-05-29 16:20:45');
INSERT INTO `users_device_login` VALUES ('1239', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '38252', 'es-419', '0', '2013-05-30 08:25:57');
INSERT INTO `users_device_login` VALUES ('1240', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '41893', 'es-VE', '0', '2013-05-30 11:43:45');
INSERT INTO `users_device_login` VALUES ('1241', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '53508', 'es-VE', '0', '2013-05-30 14:34:21');
INSERT INTO `users_device_login` VALUES ('1242', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '55571', 'es-VE', '0', '2013-05-30 14:51:59');
INSERT INTO `users_device_login` VALUES ('1243', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '41459', 'es-419', '0', '2013-05-31 08:13:52');
INSERT INTO `users_device_login` VALUES ('1244', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '43240', 'es-419', '0', '2013-05-31 09:43:54');
INSERT INTO `users_device_login` VALUES ('1245', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '43303', 'es-VE', '0', '2013-05-31 09:44:19');
INSERT INTO `users_device_login` VALUES ('1246', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '47277', 'es-419', '0', '2013-05-31 13:27:27');
INSERT INTO `users_device_login` VALUES ('1247', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '48480', 'es-VE', '0', '2013-05-31 14:19:13');
INSERT INTO `users_device_login` VALUES ('1248', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '52696', 'es-cl', '0', '2013-05-31 15:18:07');
INSERT INTO `users_device_login` VALUES ('1249', '101', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '52817', 'es-cl', '0', '2013-05-31 15:19:14');
INSERT INTO `users_device_login` VALUES ('1250', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '41742', 'es-VE', '0', '2013-05-31 16:33:47');
INSERT INTO `users_device_login` VALUES ('1251', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '38534', 'es-419', '0', '2013-06-03 08:19:11');
INSERT INTO `users_device_login` VALUES ('1252', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '39373', 'es-VE', '0', '2013-06-03 08:53:39');
INSERT INTO `users_device_login` VALUES ('1253', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '36495', 'es-419', '0', '2013-06-03 13:51:39');
INSERT INTO `users_device_login` VALUES ('1254', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '36700', 'es-VE', '0', '2013-06-03 13:52:21');
INSERT INTO `users_device_login` VALUES ('1255', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '55693', 'es-419', '0', '2013-06-04 08:37:46');
INSERT INTO `users_device_login` VALUES ('1256', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '56700', 'es-cl', '0', '2013-06-04 09:22:18');
INSERT INTO `users_device_login` VALUES ('1257', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '33036', 'es-419', '0', '2013-06-04 11:11:45');
INSERT INTO `users_device_login` VALUES ('1258', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '33080', 'es-419', '0', '2013-06-04 11:12:44');
INSERT INTO `users_device_login` VALUES ('1259', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '47319', 'es-419', '0', '2013-06-04 15:06:29');
INSERT INTO `users_device_login` VALUES ('1260', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '36911', 'es-419', '0', '2013-06-05 08:24:28');
INSERT INTO `users_device_login` VALUES ('1261', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '39203', 'es-VE', '0', '2013-06-05 09:44:01');
INSERT INTO `users_device_login` VALUES ('1262', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '43376', 'es-cl', '0', '2013-06-05 10:41:24');
INSERT INTO `users_device_login` VALUES ('1263', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '37553', 'es-419', '0', '2013-06-05 13:35:57');
INSERT INTO `users_device_login` VALUES ('1264', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '37578', 'es-VE', '0', '2013-06-05 13:36:40');
INSERT INTO `users_device_login` VALUES ('1265', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '37622', 'es-VE', '0', '2013-06-05 13:38:01');
INSERT INTO `users_device_login` VALUES ('1266', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '42300', 'es-419', '0', '2013-06-06 08:06:54');
INSERT INTO `users_device_login` VALUES ('1267', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '48269', 'es-VE', '0', '2013-06-06 09:02:08');
INSERT INTO `users_device_login` VALUES ('1268', '184', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.130', '', '53318', 'es-VE', '0', '2013-06-06 09:51:38');
INSERT INTO `users_device_login` VALUES ('1269', '101', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '60158', 'es-cl', '0', '2013-06-06 10:07:52');
INSERT INTO `users_device_login` VALUES ('1270', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '52610', 'es-419', '0', '2013-06-06 11:11:06');
INSERT INTO `users_device_login` VALUES ('1271', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '52878', 'es-VE', '0', '2013-06-06 11:23:23');
INSERT INTO `users_device_login` VALUES ('1272', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '52962', 'es-419', '0', '2013-06-06 11:24:05');
INSERT INTO `users_device_login` VALUES ('1273', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '57962', 'es-419', '0', '2013-06-06 15:38:30');
INSERT INTO `users_device_login` VALUES ('1274', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '57976', 'es-419', '0', '2013-06-06 15:38:55');
INSERT INTO `users_device_login` VALUES ('1275', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '58015', 'es-419', '0', '2013-06-06 15:41:31');
INSERT INTO `users_device_login` VALUES ('1276', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '60039', 'es-419', '0', '2013-06-06 16:14:34');
INSERT INTO `users_device_login` VALUES ('1277', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '36898', 'es-VE', '0', '2013-06-06 17:05:30');
INSERT INTO `users_device_login` VALUES ('1278', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '48496', 'es-419', '0', '2013-06-07 08:15:46');
INSERT INTO `users_device_login` VALUES ('1279', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '49103', 'es-VE', '0', '2013-06-07 08:40:16');
INSERT INTO `users_device_login` VALUES ('1280', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.93 Safari/537.36', '192.168.1.141', '', '49282', 'es-419', '0', '2013-06-07 08:44:31');
INSERT INTO `users_device_login` VALUES ('1281', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '49498', 'es-cl', '0', '2013-06-07 08:51:30');
INSERT INTO `users_device_login` VALUES ('1282', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '42731', 'es-419', '0', '2013-06-07 13:56:26');
INSERT INTO `users_device_login` VALUES ('1283', '184', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.100', '', '56402', 'en-us', '0', '2013-06-07 14:00:12');
INSERT INTO `users_device_login` VALUES ('1284', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '45622', 'es-419', '0', '2013-06-07 15:40:12');
INSERT INTO `users_device_login` VALUES ('1285', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '38451', 'es-419', '0', '2013-06-10 08:38:07');
INSERT INTO `users_device_login` VALUES ('1286', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '33967', 'es-419', '0', '2013-06-10 14:03:30');
INSERT INTO `users_device_login` VALUES ('1287', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '38411', 'es-VE', '0', '2013-06-10 15:17:38');
INSERT INTO `users_device_login` VALUES ('1288', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '43944', 'es-cl', '0', '2013-06-10 16:02:51');
INSERT INTO `users_device_login` VALUES ('1289', '184', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.20 Safari/537.36  OPR/15.0.1147.18 (Edition Next)', '192.168.1.130', '', '64539', 'es-ES', '0', '2013-06-10 16:04:16');
INSERT INTO `users_device_login` VALUES ('1290', '184', 'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.15', '192.168.1.130', '', '64823', 'es-VE', '0', '2013-06-10 16:05:46');
INSERT INTO `users_device_login` VALUES ('1291', '184', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.130', '', '64966', 'es-VE', '0', '2013-06-10 16:07:08');
INSERT INTO `users_device_login` VALUES ('1292', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '48662', 'es-419', '0', '2013-06-11 08:10:37');
INSERT INTO `users_device_login` VALUES ('1293', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '48769', 'es-VE', '0', '2013-06-11 08:11:17');
INSERT INTO `users_device_login` VALUES ('1294', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '49469', 'es-VE', '0', '2013-06-11 08:25:49');
INSERT INTO `users_device_login` VALUES ('1295', '184', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.100', '', '49217', 'en-us', '0', '2013-06-11 09:15:09');
INSERT INTO `users_device_login` VALUES ('1296', '184', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '51158', 'es-cl', '0', '2013-06-11 09:26:57');
INSERT INTO `users_device_login` VALUES ('1297', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '51189', 'es-VE', '0', '2013-06-11 09:27:20');
INSERT INTO `users_device_login` VALUES ('1298', '184', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '54015', 'es-VE', '0', '2013-06-11 10:32:45');
INSERT INTO `users_device_login` VALUES ('1299', '101', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '54834', 'es-cl', '0', '2013-06-11 10:51:46');
INSERT INTO `users_device_login` VALUES ('1300', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '34053', 'es-419', '1', '2013-06-11 14:29:40');
INSERT INTO `users_device_login` VALUES ('1301', '184', 'Mozilla/5.0 (Linux; U; Android 2.1-update1; es-es; SGH-T959 Build/ECLAIR) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17', '192.168.1.140', '', '40118', 'es-ES', '1', '2013-06-11 14:39:35');
INSERT INTO `users_device_login` VALUES ('1302', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '38770', 'es-VE', '0', '2013-06-11 16:43:50');
INSERT INTO `users_device_login` VALUES ('1303', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '48559', 'es-419', '0', '2013-06-12 08:08:28');
INSERT INTO `users_device_login` VALUES ('1304', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '48718', 'es-419', '0', '2013-06-12 08:17:46');
INSERT INTO `users_device_login` VALUES ('1305', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '51554', 'es-VE', '0', '2013-06-12 10:03:27');
INSERT INTO `users_device_login` VALUES ('1306', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '38904', 'es-VE', '0', '2013-06-12 16:56:20');
INSERT INTO `users_device_login` VALUES ('1307', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '36517', 'es-419', '0', '2013-06-13 08:11:52');
INSERT INTO `users_device_login` VALUES ('1308', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.139', '', '50446', 'en-US', '0', '2013-06-13 09:12:10');
INSERT INTO `users_device_login` VALUES ('1309', '184', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.139', '', '50500', 'en-US', '0', '2013-06-13 09:14:13');
INSERT INTO `users_device_login` VALUES ('1310', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '38569', 'es-VE', '0', '2013-06-13 09:44:01');
INSERT INTO `users_device_login` VALUES ('1311', '184', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.130', '', '53023', 'es-VE', '0', '2013-06-13 12:31:10');
INSERT INTO `users_device_login` VALUES ('1312', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '46324', 'es-VE', '0', '2013-06-13 15:28:46');
INSERT INTO `users_device_login` VALUES ('1313', '101', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '48467', 'es-cl', '0', '2013-06-13 16:35:17');
INSERT INTO `users_device_login` VALUES ('1314', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '42128', 'es-419', '0', '2013-06-14 08:01:12');
INSERT INTO `users_device_login` VALUES ('1315', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '45071', 'es-VE', '0', '2013-06-14 09:18:29');
INSERT INTO `users_device_login` VALUES ('1316', '101', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '48227', 'es-cl', '0', '2013-06-14 11:04:19');
INSERT INTO `users_device_login` VALUES ('1317', '101', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '52394', 'es-cl', '0', '2013-06-14 13:56:23');
INSERT INTO `users_device_login` VALUES ('1318', '2', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '52695', 'es-cl', '0', '2013-06-14 14:06:30');
INSERT INTO `users_device_login` VALUES ('1319', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '52946', 'es-419', '0', '2013-06-14 14:15:35');
INSERT INTO `users_device_login` VALUES ('1320', '2', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0', '192.168.1.141', '', '53036', 'es-cl', '0', '2013-06-14 14:22:15');
INSERT INTO `users_device_login` VALUES ('1321', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '53080', 'es-419', '0', '2013-06-14 14:23:33');
INSERT INTO `users_device_login` VALUES ('1322', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '53410', 'es-419', '0', '2013-06-14 14:34:18');
INSERT INTO `users_device_login` VALUES ('1323', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '53593', 'es-419', '0', '2013-06-14 14:41:30');
INSERT INTO `users_device_login` VALUES ('1324', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '53638', 'es-419', '0', '2013-06-14 14:43:05');
INSERT INTO `users_device_login` VALUES ('1325', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '53752', 'es-419', '0', '2013-06-14 14:46:51');
INSERT INTO `users_device_login` VALUES ('1326', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '56180', 'es-419', '0', '2013-06-17 07:59:50');
INSERT INTO `users_device_login` VALUES ('1327', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '49523', 'es-419', '0', '2013-06-20 08:16:23');
INSERT INTO `users_device_login` VALUES ('1328', '2', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '50630', 'es-VE', '0', '2013-06-20 09:35:09');
INSERT INTO `users_device_login` VALUES ('1329', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '50797', 'es-VE', '0', '2013-06-20 09:37:50');
INSERT INTO `users_device_login` VALUES ('1330', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '127.0.0.1', '', '50139', 'es-419', '0', '2013-06-20 13:41:35');
INSERT INTO `users_device_login` VALUES ('1331', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '50966', 'es-419', '0', '2013-06-21 08:19:35');
INSERT INTO `users_device_login` VALUES ('1332', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '53998', 'es-VE', '0', '2013-06-21 09:48:55');
INSERT INTO `users_device_login` VALUES ('1333', '101', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '54093', 'es-419', '0', '2013-06-21 09:49:38');
INSERT INTO `users_device_login` VALUES ('1334', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '55091', 'es-419', '0', '2013-06-21 10:06:51');
INSERT INTO `users_device_login` VALUES ('1335', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '55488', 'es-419', '0', '2013-06-21 10:09:11');
INSERT INTO `users_device_login` VALUES ('1336', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36', '192.168.1.141', '', '33158', 'es-419', '0', '2013-06-25 08:03:37');
INSERT INTO `users_device_login` VALUES ('1337', '101', 'Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.15', '192.168.1.141', '', '36808', 'es-VE', '0', '2013-06-25 09:24:32');
INSERT INTO `users_device_login` VALUES ('1338', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '50274', 'es-ES', '0', '2013-06-25 14:15:43');
INSERT INTO `users_device_login` VALUES ('1339', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '57239', 'es-ES', '0', '2013-06-26 08:44:41');
INSERT INTO `users_device_login` VALUES ('1340', '101', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.123', '', '50138', 'es-VE', '0', '2013-06-26 11:25:29');
INSERT INTO `users_device_login` VALUES ('1341', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', '192.168.1.123', '', '50317', 'es-ES', '0', '2013-06-26 11:26:59');
INSERT INTO `users_device_login` VALUES ('1342', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '50579', 'es-ES', '0', '2013-06-26 11:28:54');
INSERT INTO `users_device_login` VALUES ('1343', '101', 'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.15', '192.168.1.123', '', '50987', 'es-VE', '0', '2013-06-26 11:31:00');
INSERT INTO `users_device_login` VALUES ('1344', '7', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.123', '', '63019', 'es-VE', '0', '2013-06-26 14:16:21');
INSERT INTO `users_device_login` VALUES ('1345', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', '192.168.1.123', '', '63274', 'es-ES', '0', '2013-06-26 14:17:09');
INSERT INTO `users_device_login` VALUES ('1346', '7', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.123', '', '50695', 'es-VE', '0', '2013-06-27 07:58:48');
INSERT INTO `users_device_login` VALUES ('1347', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '51371', 'es-ES', '0', '2013-06-27 08:00:24');
INSERT INTO `users_device_login` VALUES ('1348', '2', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '60137', 'es-ES', '0', '2013-06-28 15:24:07');
INSERT INTO `users_device_login` VALUES ('1349', '2', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.147', '', '62676', 'en-US', '0', '2013-06-28 15:24:53');
INSERT INTO `users_device_login` VALUES ('1350', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '60227', 'es-ES', '0', '2013-06-28 15:25:03');
INSERT INTO `users_device_login` VALUES ('1351', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '58724', 'es-ES', '0', '2013-07-01 09:07:27');
INSERT INTO `users_device_login` VALUES ('1352', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', '192.168.1.123', '', '59887', 'es-ES', '0', '2013-07-01 09:29:27');
INSERT INTO `users_device_login` VALUES ('1353', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '52565', 'es-ES', '0', '2013-07-01 11:24:36');
INSERT INTO `users_device_login` VALUES ('1354', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '54973', 'es-ES', '0', '2013-07-01 11:57:17');
INSERT INTO `users_device_login` VALUES ('1355', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '64423', 'es-ES', '0', '2013-07-01 13:59:29');
INSERT INTO `users_device_login` VALUES ('1356', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '65191', 'es-ES', '0', '2013-07-01 14:07:14');
INSERT INTO `users_device_login` VALUES ('1357', '7', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.123', '', '56630', 'es-VE', '0', '2013-07-02 12:04:41');
INSERT INTO `users_device_login` VALUES ('1358', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', '192.168.1.123', '', '56639', 'es-ES', '0', '2013-07-02 12:04:44');
INSERT INTO `users_device_login` VALUES ('1359', '2', 'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.15', '192.168.1.123', '', '56731', 'es-VE', '0', '2013-07-02 12:05:17');
INSERT INTO `users_device_login` VALUES ('1360', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '56809', 'es-ES', '0', '2013-07-02 12:05:31');
INSERT INTO `users_device_login` VALUES ('1361', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36', '192.168.1.125', '', '50019', 'es-ES', '0', '2013-07-09 08:40:32');
INSERT INTO `users_device_login` VALUES ('1362', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '127.0.0.1', '', '49247', 'es-ES', '0', '2013-07-09 17:54:34');
INSERT INTO `users_device_login` VALUES ('1363', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '54816', 'es-ES', '0', '2013-07-10 08:20:11');
INSERT INTO `users_device_login` VALUES ('1364', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '49568', 'es-ES', '0', '2013-07-10 11:24:46');
INSERT INTO `users_device_login` VALUES ('1365', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '55819', 'es-ES', '0', '2013-07-10 15:28:46');
INSERT INTO `users_device_login` VALUES ('1366', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '55818', 'es-ES', '0', '2013-07-10 15:28:47');
INSERT INTO `users_device_login` VALUES ('1367', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '49791', 'es-ES', '0', '2013-07-11 09:30:12');
INSERT INTO `users_device_login` VALUES ('1368', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '49790', 'es-ES', '0', '2013-07-11 09:30:13');
INSERT INTO `users_device_login` VALUES ('1369', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '52271', 'es-ES', '0', '2013-07-11 10:45:23');
INSERT INTO `users_device_login` VALUES ('1370', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '54053', 'es-ES', '0', '2013-07-11 15:08:28');
INSERT INTO `users_device_login` VALUES ('1371', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '54054', 'es-ES', '0', '2013-07-11 15:08:29');
INSERT INTO `users_device_login` VALUES ('1372', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '55478', 'es-ES', '0', '2013-07-11 16:36:11');
INSERT INTO `users_device_login` VALUES ('1373', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36', '192.168.1.123', '', '55480', 'es-ES', '0', '2013-07-11 16:36:12');
INSERT INTO `users_device_login` VALUES ('1374', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', '192.168.1.123', '', '60036', 'es-ES', '0', '2013-07-12 11:33:07');
INSERT INTO `users_device_login` VALUES ('1375', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36', '192.168.1.123', '', '50186', 'es-ES', '0', '2013-07-15 08:09:56');
INSERT INTO `users_device_login` VALUES ('1376', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36', '127.0.0.1', '', '49570', 'es-ES', '0', '2013-07-16 08:18:49');
INSERT INTO `users_device_login` VALUES ('1377', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36', '192.168.1.123', '', '54387', 'es-ES', '0', '2013-07-16 10:10:46');
INSERT INTO `users_device_login` VALUES ('1378', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36', '192.168.1.123', '', '63798', 'es-ES', '0', '2013-07-16 15:05:52');
INSERT INTO `users_device_login` VALUES ('1379', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36', '192.168.1.123', '', '63898', 'es-ES', '0', '2013-07-16 15:08:40');
INSERT INTO `users_device_login` VALUES ('1380', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36', '192.168.1.123', '', '63924', 'es-ES', '0', '2013-07-16 15:08:40');
INSERT INTO `users_device_login` VALUES ('1381', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36', '192.168.1.123', '', '64829', 'es-ES', '0', '2013-07-16 15:47:18');
INSERT INTO `users_device_login` VALUES ('1382', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36', '127.0.0.1', '', '49232', 'es-ES', '0', '2013-07-16 18:27:18');
INSERT INTO `users_device_login` VALUES ('1383', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36', '192.168.1.123', '', '49233', 'es-ES', '0', '2013-07-18 05:35:03');
INSERT INTO `users_device_login` VALUES ('1384', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36', '192.168.1.123', '', '52155', 'es-ES', '0', '2013-07-19 10:22:07');
INSERT INTO `users_device_login` VALUES ('1385', '7', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.123', '', '59161', 'es-VE', '0', '2013-07-19 13:35:40');
INSERT INTO `users_device_login` VALUES ('1386', '2', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '59385', 'es-ES', '0', '2013-07-19 13:37:56');
INSERT INTO `users_device_login` VALUES ('1387', '83', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', '192.168.1.123', '', '59494', 'es-ES', '0', '2013-07-19 13:38:40');
INSERT INTO `users_device_login` VALUES ('1388', '7', 'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.15', '192.168.1.123', '', '61054', 'es-VE', '0', '2013-07-19 13:47:47');
INSERT INTO `users_device_login` VALUES ('1389', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36', '192.168.1.123', '', '49550', 'es-ES', '0', '2013-08-05 08:57:14');
INSERT INTO `users_device_login` VALUES ('1390', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36', '192.168.1.123', '', '50549', 'es-ES', '0', '2013-08-05 09:10:37');
INSERT INTO `users_device_login` VALUES ('1391', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '49451', 'es-ES', '0', '2013-08-08 08:39:06');
INSERT INTO `users_device_login` VALUES ('1392', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '50262', 'es-ES', '0', '2013-08-08 09:27:03');
INSERT INTO `users_device_login` VALUES ('1393', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '49270', 'es-ES', '0', '2013-08-08 13:34:10');
INSERT INTO `users_device_login` VALUES ('1394', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '49900', 'es-ES', '0', '2013-08-08 14:11:56');
INSERT INTO `users_device_login` VALUES ('1395', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '49407', 'es-ES', '0', '2013-08-09 09:18:40');
INSERT INTO `users_device_login` VALUES ('1396', '101', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '192.168.1.123', '', '53898', 'es-VE', '0', '2013-08-09 11:41:52');
INSERT INTO `users_device_login` VALUES ('1397', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:22.0) Gecko/20100101 Firefox/22.0', '192.168.1.123', '', '53928', 'es-ES', '0', '2013-08-09 11:41:58');
INSERT INTO `users_device_login` VALUES ('1398', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '53987', 'es-ES', '0', '2013-08-09 11:42:13');
INSERT INTO `users_device_login` VALUES ('1399', '101', 'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.15', '192.168.1.123', '', '54039', 'es-VE', '0', '2013-08-09 11:42:24');
INSERT INTO `users_device_login` VALUES ('1400', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '49413', 'es-ES', '0', '2013-08-12 08:02:32');
INSERT INTO `users_device_login` VALUES ('1401', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '50735', 'es-ES', '0', '2013-08-13 08:50:44');
INSERT INTO `users_device_login` VALUES ('1402', '184', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.141', '', '47205', 'es-419', '0', '2013-08-14 08:46:51');
INSERT INTO `users_device_login` VALUES ('1403', '124', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.125', '', '50724', 'es-ES', '0', '2013-08-14 08:47:52');
INSERT INTO `users_device_login` VALUES ('1404', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '50081', 'es-ES', '0', '2013-08-14 08:48:35');
INSERT INTO `users_device_login` VALUES ('1405', '7', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '50213', 'es-ES', '0', '2013-08-14 08:49:13');
INSERT INTO `users_device_login` VALUES ('1406', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.130', '', '50975', 'es', '0', '2013-08-14 08:51:34');
INSERT INTO `users_device_login` VALUES ('1407', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.130', '', '52217', 'es', '0', '2013-08-14 09:28:43');
INSERT INTO `users_device_login` VALUES ('1408', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.134', '', '56969', 'en-US', '0', '2013-08-14 09:28:44');
INSERT INTO `users_device_login` VALUES ('1409', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '58991', 'es-ES', '0', '2013-08-19 11:17:28');
INSERT INTO `users_device_login` VALUES ('1410', '204', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '49592', 'es-ES', '0', '2013-08-20 09:50:30');
INSERT INTO `users_device_login` VALUES ('1411', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '50120', 'es-ES', '0', '2013-08-20 10:09:09');
INSERT INTO `users_device_login` VALUES ('1412', '204', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '50556', 'es-ES', '0', '2013-08-20 10:18:59');
INSERT INTO `users_device_login` VALUES ('1413', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '50805', 'es-ES', '0', '2013-08-20 10:29:01');
INSERT INTO `users_device_login` VALUES ('1414', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '52630', 'es-ES', '0', '2013-08-20 11:48:51');
INSERT INTO `users_device_login` VALUES ('1415', '204', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '52695', 'es-ES', '0', '2013-08-20 11:49:42');
INSERT INTO `users_device_login` VALUES ('1416', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '54265', 'es-ES', '0', '2013-08-20 12:47:37');
INSERT INTO `users_device_login` VALUES ('1417', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '63517', 'es-ES', '0', '2013-08-23 15:21:49');
INSERT INTO `users_device_login` VALUES ('1418', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36', '192.168.1.123', '', '63981', 'es-ES', '0', '2013-08-23 15:33:25');
INSERT INTO `users_device_login` VALUES ('1419', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '64137', 'es-ES', '0', '2013-08-26 13:09:42');
INSERT INTO `users_device_login` VALUES ('1420', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '64364', 'es-ES', '0', '2013-08-26 13:18:46');
INSERT INTO `users_device_login` VALUES ('1421', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '64548', 'es-ES', '0', '2013-08-26 13:24:37');
INSERT INTO `users_device_login` VALUES ('1422', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '53430', 'es-ES', '0', '2013-08-26 15:42:32');
INSERT INTO `users_device_login` VALUES ('1423', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '53523', 'es-ES', '0', '2013-08-26 15:43:57');
INSERT INTO `users_device_login` VALUES ('1424', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '56429', 'es-VE', '0', '2013-08-27 12:08:28');
INSERT INTO `users_device_login` VALUES ('1425', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '56507', 'es-ES', '0', '2013-08-27 12:09:24');
INSERT INTO `users_device_login` VALUES ('1426', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '56738', 'es-VE', '0', '2013-08-27 12:12:01');
INSERT INTO `users_device_login` VALUES ('1427', '103', 'Opera/9.80 (Windows NT 6.2; WOW64) Presto/2.12.388 Version/12.15', '192.168.1.123', '', '56836', 'es-VE', '0', '2013-08-27 12:12:17');
INSERT INTO `users_device_login` VALUES ('1428', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0', '192.168.1.123', '', '56940', 'es-ES', '0', '2013-08-27 12:12:33');
INSERT INTO `users_device_login` VALUES ('1429', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '51140', 'es-ES', '0', '2013-08-27 14:44:23');
INSERT INTO `users_device_login` VALUES ('1430', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '51466', 'es-VE', '0', '2013-08-27 14:47:09');
INSERT INTO `users_device_login` VALUES ('1431', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '54486', 'es-ES', '0', '2013-08-27 15:33:03');
INSERT INTO `users_device_login` VALUES ('1432', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '58586', 'es-ES', '0', '2013-08-27 16:20:11');
INSERT INTO `users_device_login` VALUES ('1433', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '60269', 'es-ES', '0', '2013-08-27 16:43:34');
INSERT INTO `users_device_login` VALUES ('1434', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '59338', 'es-ES', '0', '2013-08-29 15:23:17');
INSERT INTO `users_device_login` VALUES ('1435', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '51933', 'es-ES', '0', '2013-08-30 09:22:41');
INSERT INTO `users_device_login` VALUES ('1436', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '55938', 'es-ES', '0', '2013-08-30 14:39:35');
INSERT INTO `users_device_login` VALUES ('1437', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '56203', 'en-US', '0', '2013-08-30 14:41:54');
INSERT INTO `users_device_login` VALUES ('1438', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '50497', 'es-ES', '0', '2013-09-02 08:04:49');
INSERT INTO `users_device_login` VALUES ('1439', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '52910', 'es-ES', '0', '2013-09-02 08:52:14');
INSERT INTO `users_device_login` VALUES ('1440', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '53558', 'es-ES', '0', '2013-09-02 09:01:37');
INSERT INTO `users_device_login` VALUES ('1441', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36', '192.168.1.123', '', '54500', 'es-ES', '0', '2013-09-02 09:15:53');
INSERT INTO `users_device_login` VALUES ('1442', '184', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.62 Safari/537.36', '192.168.1.141', '', '49315', 'es-419', '0', '2013-09-03 07:38:18');
INSERT INTO `users_device_login` VALUES ('1443', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.62 Safari/537.36', '192.168.1.123', '', '51683', 'es-ES', '0', '2013-09-03 07:43:45');
INSERT INTO `users_device_login` VALUES ('1444', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '59146', 'en-US', '0', '2013-09-04 09:02:30');
INSERT INTO `users_device_login` VALUES ('1445', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.62 Safari/537.36', '192.168.1.123', '', '50202', 'es-ES', '0', '2013-09-04 16:05:01');
INSERT INTO `users_device_login` VALUES ('1446', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '55227', 'es-ES', '0', '2013-09-08 10:49:38');
INSERT INTO `users_device_login` VALUES ('1447', '184', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.62 Safari/537.36', '192.168.1.141', '', '61625', 'es-419', '0', '2013-09-09 16:52:41');
INSERT INTO `users_device_login` VALUES ('1448', '184', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.141', '', '56029', 'es-419', '0', '2013-09-10 09:55:18');
INSERT INTO `users_device_login` VALUES ('1449', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '50566', 'es-ES', '0', '2013-09-11 08:20:49');
INSERT INTO `users_device_login` VALUES ('1450', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '55207', 'es-ES', '0', '2013-09-11 08:50:48');
INSERT INTO `users_device_login` VALUES ('1451', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '55599', 'es-ES', '0', '2013-09-11 09:01:58');
INSERT INTO `users_device_login` VALUES ('1452', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '59911', 'es-ES', '0', '2013-09-11 13:18:20');
INSERT INTO `users_device_login` VALUES ('1453', '124', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '64839', 'es-ES', '0', '2013-09-11 16:23:14');
INSERT INTO `users_device_login` VALUES ('1454', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '53183', 'es-ES', '0', '2013-09-12 09:32:43');
INSERT INTO `users_device_login` VALUES ('1455', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '61465', 'es-ES', '0', '2013-09-12 11:22:37');
INSERT INTO `users_device_login` VALUES ('1456', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '62598', 'es-ES', '0', '2013-09-12 11:39:23');
INSERT INTO `users_device_login` VALUES ('1457', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '62817', 'es-ES', '0', '2013-09-12 11:41:57');
INSERT INTO `users_device_login` VALUES ('1458', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '63770', 'es-ES', '0', '2013-09-12 11:57:42');
INSERT INTO `users_device_login` VALUES ('1459', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '63912', 'es-ES', '0', '2013-09-12 11:59:38');
INSERT INTO `users_device_login` VALUES ('1460', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '64125', 'es-ES', '0', '2013-09-12 12:04:52');
INSERT INTO `users_device_login` VALUES ('1461', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '64265', 'es-ES', '0', '2013-09-12 12:06:59');
INSERT INTO `users_device_login` VALUES ('1462', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '65346', 'es-ES', '0', '2013-09-12 12:37:23');
INSERT INTO `users_device_login` VALUES ('1463', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '49373', 'es-ES', '0', '2013-09-12 12:42:10');
INSERT INTO `users_device_login` VALUES ('1464', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '50124', 'es-ES', '0', '2013-09-12 12:52:22');
INSERT INTO `users_device_login` VALUES ('1465', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '50312', 'es-ES', '0', '2013-09-12 12:54:48');
INSERT INTO `users_device_login` VALUES ('1466', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '50510', 'es-ES', '0', '2013-09-12 12:57:19');
INSERT INTO `users_device_login` VALUES ('1467', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '53389', 'es-ES', '0', '2013-09-12 13:30:24');
INSERT INTO `users_device_login` VALUES ('1468', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '53874', 'es-ES', '0', '2013-09-12 13:35:17');
INSERT INTO `users_device_login` VALUES ('1469', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '55445', 'es-ES', '0', '2013-09-12 13:53:51');
INSERT INTO `users_device_login` VALUES ('1470', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '55828', 'es-ES', '0', '2013-09-12 13:58:34');
INSERT INTO `users_device_login` VALUES ('1471', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '58411', 'es-ES', '0', '2013-09-12 14:40:11');
INSERT INTO `users_device_login` VALUES ('1472', '184', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.141', '', '55305', 'es-419', '0', '2013-09-12 14:45:16');
INSERT INTO `users_device_login` VALUES ('1473', '119', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.130', '', '64108', 'es', '0', '2013-09-12 14:48:40');
INSERT INTO `users_device_login` VALUES ('1474', '119', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.130', '', '64112', 'es', '0', '2013-09-12 14:48:42');
INSERT INTO `users_device_login` VALUES ('1475', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '63388', 'es-ES', '0', '2013-09-12 16:04:38');
INSERT INTO `users_device_login` VALUES ('1476', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '64506', 'es-ES', '0', '2013-09-12 16:12:57');
INSERT INTO `users_device_login` VALUES ('1477', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '64540', 'es-ES', '0', '2013-09-12 16:13:20');
INSERT INTO `users_device_login` VALUES ('1478', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '64666', 'es-ES', '0', '2013-09-12 16:14:39');
INSERT INTO `users_device_login` VALUES ('1479', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '65247', 'es-ES', '0', '2013-09-12 16:28:13');
INSERT INTO `users_device_login` VALUES ('1480', '119', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '49458', 'es-ES', '0', '2013-09-12 16:34:07');
INSERT INTO `users_device_login` VALUES ('1481', '124', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '50281', 'es-ES', '0', '2013-09-12 16:44:54');
INSERT INTO `users_device_login` VALUES ('1482', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '55269', 'es-ES', '0', '2013-09-13 09:54:46');
INSERT INTO `users_device_login` VALUES ('1483', '120', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '65079', 'es-ES', '0', '2013-09-13 16:49:45');
INSERT INTO `users_device_login` VALUES ('1484', '120', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '65078', 'es-ES', '0', '2013-09-13 16:49:47');
INSERT INTO `users_device_login` VALUES ('1485', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0', '192.168.1.123', '', '60260', 'es-ES', '0', '2013-09-16 10:55:44');
INSERT INTO `users_device_login` VALUES ('1486', '120', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '59423', 'es-ES', '0', '2013-09-17 16:21:26');
INSERT INTO `users_device_login` VALUES ('1487', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '52242', 'en-US', '1', '2013-09-18 09:20:03');
INSERT INTO `users_device_login` VALUES ('1488', '120', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '53509', 'es-ES', '0', '2013-09-18 09:38:01');
INSERT INTO `users_device_login` VALUES ('1489', '101', 'Mozilla/5.0 (iPad; CPU OS 6_1_3 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B329 Safari/8536.25', '192.168.1.104', '', '49315', 'es-es', '0', '2013-09-18 11:47:29');
INSERT INTO `users_device_login` VALUES ('1490', '120', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '50692', 'es-ES', '0', '2013-09-19 09:00:09');
INSERT INTO `users_device_login` VALUES ('1491', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '192.168.1.123', '', '54920', 'es-ES', '0', '2013-09-20 09:37:59');
INSERT INTO `users_device_login` VALUES ('1492', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '60061', 'es-ES', '0', '2013-09-20 10:26:11');
INSERT INTO `users_device_login` VALUES ('1493', '120', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36', '192.168.1.123', '', '50871', 'es-ES', '0', '2013-09-23 08:52:32');
INSERT INTO `users_device_login` VALUES ('1494', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '51122', 'en-US', '0', '2013-09-24 17:00:39');
INSERT INTO `users_device_login` VALUES ('1495', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '53776', 'en-US', '0', '2013-09-25 09:06:24');
INSERT INTO `users_device_login` VALUES ('1496', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.76 Safari/537.36', '192.168.1.123', '', '55159', 'es-ES', '0', '2013-09-26 10:09:36');
INSERT INTO `users_device_login` VALUES ('1497', '120', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '50327', 'en-US', '0', '2013-09-26 16:04:23');
INSERT INTO `users_device_login` VALUES ('1498', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.76 Safari/537.36', '192.168.1.123', '', '56612', 'es-ES', '0', '2013-09-27 14:12:49');
INSERT INTO `users_device_login` VALUES ('1499', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '53330', 'es-ES', '0', '2013-10-07 09:39:36');
INSERT INTO `users_device_login` VALUES ('1500', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '65250', 'es-ES', '0', '2013-10-07 15:38:12');
INSERT INTO `users_device_login` VALUES ('1501', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '50885', 'es-ES', '0', '2013-10-08 15:00:06');
INSERT INTO `users_device_login` VALUES ('1502', '120', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '52899', 'en-US', '0', '2013-10-08 15:26:24');
INSERT INTO `users_device_login` VALUES ('1503', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '53504', 'en-US', '0', '2013-10-08 15:28:10');
INSERT INTO `users_device_login` VALUES ('1504', '101', 'Opera/9.80 (Windows NT 6.2; WOW64) Presto/2.12.388 Version/12.16', '192.168.1.123', '', '55808', 'en-US', '0', '2013-10-08 15:37:10');
INSERT INTO `users_device_login` VALUES ('1505', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '61173', 'es-ES', '0', '2013-10-09 15:10:11');
INSERT INTO `users_device_login` VALUES ('1506', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '50208', 'es-ES', '0', '2013-10-10 11:05:18');
INSERT INTO `users_device_login` VALUES ('1507', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '63737', 'es-ES', '0', '2013-10-10 15:01:46');
INSERT INTO `users_device_login` VALUES ('1508', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '50232', 'es-ES', '0', '2013-10-10 15:52:25');
INSERT INTO `users_device_login` VALUES ('1509', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '51444', 'en-US', '0', '2013-10-10 16:11:13');
INSERT INTO `users_device_login` VALUES ('1510', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '192.168.1.123', '', '57395', 'es-ES', '0', '2013-10-11 10:53:24');
INSERT INTO `users_device_login` VALUES ('1511', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '57837', 'en-US', '0', '2013-10-11 10:56:52');
INSERT INTO `users_device_login` VALUES ('1512', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '49570', 'en-US', '0', '2013-10-11 13:26:24');
INSERT INTO `users_device_login` VALUES ('1513', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '56772', 'es-ES', '0', '2013-10-11 14:29:48');
INSERT INTO `users_device_login` VALUES ('1514', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.125', '', '52628', 'es-ES', '0', '2013-10-11 16:01:09');
INSERT INTO `users_device_login` VALUES ('1515', '184', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.141', '', '63080', 'es-419', '0', '2013-10-11 16:01:39');
INSERT INTO `users_device_login` VALUES ('1516', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '51684', 'es-ES', '0', '2013-10-11 16:03:25');
INSERT INTO `users_device_login` VALUES ('1517', '184', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.141', '', '63311', 'es-419', '0', '2013-10-11 16:08:30');
INSERT INTO `users_device_login` VALUES ('1518', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.130', '', '59904', 'es', '0', '2013-10-11 16:08:31');
INSERT INTO `users_device_login` VALUES ('1519', '206', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '56162', 'es-ES', '0', '2013-10-15 09:16:35');
INSERT INTO `users_device_login` VALUES ('1520', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '57963', 'es-ES', '0', '2013-10-15 09:59:47');
INSERT INTO `users_device_login` VALUES ('1521', '206', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '60318', 'es-ES', '0', '2013-10-15 10:16:24');
INSERT INTO `users_device_login` VALUES ('1522', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '61009', 'es-ES', '0', '2013-10-15 10:23:01');
INSERT INTO `users_device_login` VALUES ('1523', '206', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '62149', 'es-ES', '0', '2013-10-15 10:30:54');
INSERT INTO `users_device_login` VALUES ('1524', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.123', '', '57325', 'es-ES', '0', '2013-10-17 09:11:45');
INSERT INTO `users_device_login` VALUES ('1525', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '192.168.1.123', '', '57437', 'es-ES', '0', '2013-10-17 09:12:03');
INSERT INTO `users_device_login` VALUES ('1526', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '57800', 'es-ES', '0', '2013-10-21 10:40:13');
INSERT INTO `users_device_login` VALUES ('1527', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '59380', 'es-ES', '0', '2013-10-21 11:03:22');
INSERT INTO `users_device_login` VALUES ('1528', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '55924', 'en-US', '0', '2013-10-21 14:06:24');
INSERT INTO `users_device_login` VALUES ('1529', '7', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '64913', 'en-US', '0', '2013-10-21 15:22:43');
INSERT INTO `users_device_login` VALUES ('1530', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '51902', 'es-ES', '0', '2013-10-21 15:42:00');
INSERT INTO `users_device_login` VALUES ('1531', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '52070', 'es-ES', '0', '2013-10-21 15:42:58');
INSERT INTO `users_device_login` VALUES ('1532', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '53567', 'es-ES', '0', '2013-10-21 15:53:01');
INSERT INTO `users_device_login` VALUES ('1533', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '54220', 'en-US', '0', '2013-10-22 08:55:14');
INSERT INTO `users_device_login` VALUES ('1534', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '63947', 'es-ES', '0', '2013-10-22 09:53:21');
INSERT INTO `users_device_login` VALUES ('1535', '184', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.141', '', '57747', 'es-419', '0', '2013-10-22 09:54:57');
INSERT INTO `users_device_login` VALUES ('1536', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', '192.168.1.130', '', '57269', 'es', '0', '2013-10-22 09:58:33');
INSERT INTO `users_device_login` VALUES ('1537', '101', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.141', '', '58638', 'es-419', '0', '2013-10-22 10:21:56');
INSERT INTO `users_device_login` VALUES ('1538', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '59409', 'es-ES', '0', '2013-10-22 15:17:48');
INSERT INTO `users_device_login` VALUES ('1539', '206', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '54206', 'es-ES', '0', '2013-10-22 16:40:50');
INSERT INTO `users_device_login` VALUES ('1540', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '54142', 'es-ES', '0', '2013-10-23 09:59:57');
INSERT INTO `users_device_login` VALUES ('1541', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '54688', 'es-ES', '0', '2013-10-23 10:08:42');
INSERT INTO `users_device_login` VALUES ('1542', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '54875', 'es-ES', '0', '2013-10-23 10:12:40');
INSERT INTO `users_device_login` VALUES ('1543', '206', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '55868', 'es-ES', '0', '2013-10-23 14:30:40');
INSERT INTO `users_device_login` VALUES ('1544', '7', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '56033', 'es-VE', '0', '2013-10-23 14:31:26');
INSERT INTO `users_device_login` VALUES ('1545', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '192.168.1.123', '', '56438', 'es-ES', '0', '2013-10-23 14:33:41');
INSERT INTO `users_device_login` VALUES ('1546', '120', 'Opera/9.80 (Windows NT 6.2; WOW64) Presto/2.12.388 Version/12.16', '192.168.1.123', '', '62115', 'es-VE', '0', '2013-10-23 15:51:43');
INSERT INTO `users_device_login` VALUES ('1547', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '59681', 'es-ES', '0', '2013-10-30 14:18:32');
INSERT INTO `users_device_login` VALUES ('1548', '206', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '59610', 'es-ES', '0', '2013-11-04 07:53:39');
INSERT INTO `users_device_login` VALUES ('1549', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '59623', 'es-ES', '0', '2013-11-04 07:53:52');
INSERT INTO `users_device_login` VALUES ('1550', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '54386', 'es-ES', '0', '2013-11-04 14:17:23');
INSERT INTO `users_device_login` VALUES ('1551', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '54875', 'es-ES', '0', '2013-11-04 14:22:01');
INSERT INTO `users_device_login` VALUES ('1552', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '57888', 'es-ES', '0', '2013-11-04 14:46:47');
INSERT INTO `users_device_login` VALUES ('1553', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '51978', 'es-ES', '0', '2013-11-05 09:55:54');
INSERT INTO `users_device_login` VALUES ('1554', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '53399', 'es-ES', '0', '2013-11-11 09:31:03');
INSERT INTO `users_device_login` VALUES ('1555', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '58596', 'es-ES', '0', '2013-11-11 16:08:44');
INSERT INTO `users_device_login` VALUES ('1556', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '52526', 'es-ES', '0', '2013-11-13 09:14:24');
INSERT INTO `users_device_login` VALUES ('1557', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '53596', 'es-ES', '0', '2013-11-13 09:35:12');
INSERT INTO `users_device_login` VALUES ('1558', '206', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '56918', 'es-ES', '0', '2013-11-13 10:36:50');
INSERT INTO `users_device_login` VALUES ('1559', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '58208', 'es-ES', '0', '2013-11-13 10:56:06');
INSERT INTO `users_device_login` VALUES ('1560', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '59704', 'es-ES', '0', '2013-11-13 11:09:22');
INSERT INTO `users_device_login` VALUES ('1561', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '60374', 'es-ES', '0', '2013-11-13 11:14:22');
INSERT INTO `users_device_login` VALUES ('1562', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '61705', 'es-ES', '0', '2013-11-14 15:37:39');
INSERT INTO `users_device_login` VALUES ('1563', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36', '192.168.1.123', '', '62602', 'es-ES', '0', '2013-11-14 16:28:50');
INSERT INTO `users_device_login` VALUES ('1564', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '56502', 'es-ES', '0', '2013-11-19 09:39:00');
INSERT INTO `users_device_login` VALUES ('1565', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '58371', 'es-ES', '0', '2013-11-19 10:08:11');
INSERT INTO `users_device_login` VALUES ('1566', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '52115', 'es-ES', '0', '2013-11-19 14:05:30');
INSERT INTO `users_device_login` VALUES ('1567', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '52813', 'es-ES', '0', '2013-11-19 14:15:45');
INSERT INTO `users_device_login` VALUES ('1568', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '58634', 'es-ES', '0', '2013-11-19 15:12:08');
INSERT INTO `users_device_login` VALUES ('1569', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '50780', 'es-ES', '0', '2013-11-22 09:25:36');
INSERT INTO `users_device_login` VALUES ('1570', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '53853', 'es-ES', '0', '2013-11-27 11:25:39');
INSERT INTO `users_device_login` VALUES ('1571', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '55350', 'es-ES', '0', '2013-11-27 12:28:12');
INSERT INTO `users_device_login` VALUES ('1572', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '55625', 'es-ES', '0', '2013-11-27 12:34:00');
INSERT INTO `users_device_login` VALUES ('1573', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '58133', 'es-ES', '0', '2013-11-27 14:52:08');
INSERT INTO `users_device_login` VALUES ('1574', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '50645', 'es-ES', '0', '2013-11-28 12:01:28');
INSERT INTO `users_device_login` VALUES ('1575', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '50750', 'es-ES', '0', '2013-11-28 12:02:47');
INSERT INTO `users_device_login` VALUES ('1576', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '51922', 'es-ES', '0', '2013-11-28 12:53:47');
INSERT INTO `users_device_login` VALUES ('1577', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '53890', 'es-ES', '0', '2013-11-28 14:14:43');
INSERT INTO `users_device_login` VALUES ('1578', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '54566', 'es-ES', '0', '2013-11-28 14:23:30');
INSERT INTO `users_device_login` VALUES ('1579', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '54657', 'es-US', '0', '2013-11-28 14:24:11');
INSERT INTO `users_device_login` VALUES ('1580', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '192.168.1.123', '', '55050', 'es-ES', '0', '2013-11-28 14:27:57');
INSERT INTO `users_device_login` VALUES ('1581', '101', 'Opera/9.80 (Windows NT 6.2; WOW64) Presto/2.12.388 Version/12.16', '192.168.1.123', '', '57062', 'es-US', '0', '2013-11-28 14:40:23');
INSERT INTO `users_device_login` VALUES ('1582', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '50262', 'es-ES', '0', '2013-12-02 08:24:41');
INSERT INTO `users_device_login` VALUES ('1583', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '55326', 'es-ES', '0', '2013-12-02 10:46:59');
INSERT INTO `users_device_login` VALUES ('1584', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '60329', 'es-ES', '0', '2013-12-02 13:22:03');
INSERT INTO `users_device_login` VALUES ('1585', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '49798', 'es-ES', '0', '2013-12-03 08:50:29');
INSERT INTO `users_device_login` VALUES ('1586', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '53656', 'es-ES', '0', '2013-12-03 11:31:39');
INSERT INTO `users_device_login` VALUES ('1587', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '54296', 'es-ES', '0', '2013-12-03 11:52:36');
INSERT INTO `users_device_login` VALUES ('1588', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '56793', 'es-ES', '0', '2013-12-03 13:15:30');
INSERT INTO `users_device_login` VALUES ('1589', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '56850', 'es-ES', '0', '2013-12-03 13:27:10');
INSERT INTO `users_device_login` VALUES ('1590', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '57398', 'es-ES', '0', '2013-12-03 13:42:53');
INSERT INTO `users_device_login` VALUES ('1591', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '57502', 'es-ES', '0', '2013-12-03 13:44:12');
INSERT INTO `users_device_login` VALUES ('1592', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '57629', 'es-ES', '0', '2013-12-03 13:46:58');
INSERT INTO `users_device_login` VALUES ('1593', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '57723', 'es-ES', '0', '2013-12-03 13:56:07');
INSERT INTO `users_device_login` VALUES ('1594', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '58058', 'es-ES', '0', '2013-12-03 14:00:53');
INSERT INTO `users_device_login` VALUES ('1595', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '58179', 'es-ES', '0', '2013-12-03 14:02:13');
INSERT INTO `users_device_login` VALUES ('1596', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '::1', '', '58419', 'es-ES', '0', '2013-12-03 14:07:51');
INSERT INTO `users_device_login` VALUES ('1597', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '49731', 'es-ES', '0', '2013-12-03 14:18:11');
INSERT INTO `users_device_login` VALUES ('1598', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '50430', 'es-ES', '0', '2013-12-03 14:32:18');
INSERT INTO `users_device_login` VALUES ('1599', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '50512', 'es-ES', '0', '2013-12-03 14:33:10');
INSERT INTO `users_device_login` VALUES ('1600', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '49769', 'es-ES', '0', '2013-12-04 10:29:32');
INSERT INTO `users_device_login` VALUES ('1601', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '50927', 'es-ES', '0', '2013-12-05 09:05:01');
INSERT INTO `users_device_login` VALUES ('1602', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '58310', 'es-ES', '0', '2013-12-06 10:47:42');
INSERT INTO `users_device_login` VALUES ('1603', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', '192.168.1.123', '', '54732', 'es-ES', '0', '2013-12-06 14:03:53');
INSERT INTO `users_device_login` VALUES ('1604', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '192.168.1.123', '', '51434', 'es-ES', '0', '2013-12-09 08:37:04');
INSERT INTO `users_device_login` VALUES ('1605', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '57011', 'es-ES', '0', '2013-12-09 09:58:08');
INSERT INTO `users_device_login` VALUES ('1606', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0', '192.168.1.123', '', '49592', 'es-ES', '0', '2013-12-09 11:15:03');
INSERT INTO `users_device_login` VALUES ('1607', '103', 'Opera/9.80 (Windows NT 6.2; WOW64) Presto/2.12.388 Version/12.16', '192.168.1.123', '', '49852', 'es-US', '0', '2013-12-09 11:16:19');
INSERT INTO `users_device_login` VALUES ('1608', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '53482', 'es-ES', '0', '2013-12-09 13:47:27');
INSERT INTO `users_device_login` VALUES ('1609', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '56147', 'es-US', '0', '2013-12-09 14:07:26');
INSERT INTO `users_device_login` VALUES ('1610', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '192.168.1.123', '', '55998', 'es-ES', '0', '2013-12-10 13:21:50');
INSERT INTO `users_device_login` VALUES ('1611', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '59589', 'es-ES', '0', '2013-12-10 14:24:04');
INSERT INTO `users_device_login` VALUES ('1612', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '54286', 'es-ES', '0', '2013-12-11 08:51:05');
INSERT INTO `users_device_login` VALUES ('1613', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '58231', 'es-US', '0', '2013-12-11 09:04:53');
INSERT INTO `users_device_login` VALUES ('1614', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '192.168.1.123', '', '56825', 'es-ES', '0', '2013-12-13 10:30:19');
INSERT INTO `users_device_login` VALUES ('1615', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '192.168.1.123', '', '62096', 'es-ES', '1', '2013-12-13 11:44:17');
INSERT INTO `users_device_login` VALUES ('1616', '103', 'Mozilla/5.0 (iPad; CPU OS 6_1_3 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B329 Safari/8536.25', '192.168.1.148', '', '51165', 'es-es', '1', '2013-12-13 13:42:14');
INSERT INTO `users_device_login` VALUES ('1617', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '192.168.1.123', '', '49667', 'es-ES', '0', '2014-01-14 08:43:50');
INSERT INTO `users_device_login` VALUES ('1618', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '192.168.1.123', '', '55781', 'es-ES', '0', '2014-01-14 11:06:35');
INSERT INTO `users_device_login` VALUES ('1619', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '192.168.1.123', '', '55866', 'es-ES', '0', '2014-01-14 11:08:03');
INSERT INTO `users_device_login` VALUES ('1620', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36', '192.168.1.123', '', '53185', 'es-ES', '0', '2014-01-16 14:27:44');
INSERT INTO `users_device_login` VALUES ('1621', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36', '192.168.1.123', '', '54452', 'es-ES', '0', '2014-01-16 15:14:14');
INSERT INTO `users_device_login` VALUES ('1622', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '54502', 'es-US', '0', '2014-01-16 15:14:51');
INSERT INTO `users_device_login` VALUES ('1623', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '58401', 'es-US', '0', '2014-01-21 09:01:27');
INSERT INTO `users_device_login` VALUES ('1624', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36', '192.168.1.123', '', '49623', 'es-ES', '0', '2014-01-22 14:39:01');
INSERT INTO `users_device_login` VALUES ('1625', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36', '192.168.1.123', '', '54940', 'es-ES', '0', '2014-01-23 14:15:11');
INSERT INTO `users_device_login` VALUES ('1626', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36', '192.168.1.123', '', '60570', 'es-ES', '0', '2014-01-27 10:10:36');
INSERT INTO `users_device_login` VALUES ('1627', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36', '192.168.1.123', '', '58467', 'es-ES', '0', '2014-01-28 16:55:31');
INSERT INTO `users_device_login` VALUES ('1628', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '65065', 'es-US', '0', '2014-01-29 13:46:41');
INSERT INTO `users_device_login` VALUES ('1629', '120', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '65151', 'es-ES', '0', '2014-01-29 13:47:08');
INSERT INTO `users_device_login` VALUES ('1630', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '59772', 'es-ES', '0', '2014-01-29 15:52:06');
INSERT INTO `users_device_login` VALUES ('1631', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36', '192.168.1.123', '', '60360', 'es-ES', '0', '2014-01-29 15:56:26');
INSERT INTO `users_device_login` VALUES ('1632', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.102 Safari/537.36', '192.168.1.123', '', '51205', 'es-ES', '0', '2014-01-30 08:18:25');
INSERT INTO `users_device_login` VALUES ('1633', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.102 Safari/537.36', '192.168.1.123', '', '61683', 'es-ES', '0', '2014-01-30 14:41:03');
INSERT INTO `users_device_login` VALUES ('1634', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.102 Safari/537.36', '192.168.1.123', '', '61784', 'es-ES', '0', '2014-01-30 14:41:53');
INSERT INTO `users_device_login` VALUES ('1635', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.102 Safari/537.36', '192.168.1.123', '', '50290', 'es-ES', '0', '2014-01-31 08:46:45');
INSERT INTO `users_device_login` VALUES ('1636', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.102 Safari/537.36', '192.168.1.123', '', '50478', 'es-ES', '0', '2014-01-31 08:53:55');
INSERT INTO `users_device_login` VALUES ('1637', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '54532', 'es-US', '0', '2014-02-04 15:02:04');
INSERT INTO `users_device_login` VALUES ('1638', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.102 Safari/537.36', '192.168.1.123', '', '57008', 'es-ES', '0', '2014-02-04 16:44:02');
INSERT INTO `users_device_login` VALUES ('1639', '103', 'Mozilla/5.0 (iPad; CPU OS 6_1_3 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B329 Safari/8536.25', '192.168.1.147', '', '50120', 'es-es', '0', '2014-02-05 14:22:53');
INSERT INTO `users_device_login` VALUES ('1640', '103', 'Mozilla/5.0 (iPad; CPU OS 6_1_3 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B329 Safari/8536.25', '192.168.1.147', '', '50432', 'es-es', '0', '2014-02-05 15:53:09');
INSERT INTO `users_device_login` VALUES ('1641', '103', 'Mozilla/5.0 (iPad; CPU OS 6_1_3 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B329 Safari/8536.25', '192.168.1.147', '', '50474', 'es-es', '0', '2014-02-05 16:00:27');
INSERT INTO `users_device_login` VALUES ('1642', '101', 'Mozilla/5.0 (Linux; U; Android 2.2.1; en-us; SCH-I500 Build/FROYO) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', '192.168.1.105', '', '45798', 'en-US', '1', '2014-02-06 10:55:58');
INSERT INTO `users_device_login` VALUES ('1643', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.123', '', '52383', 'es-ES', '1', '2014-02-06 10:57:23');
INSERT INTO `users_device_login` VALUES ('1644', '101', 'Mozilla/5.0 (Linux; U; Android 2.2.1; en-us; SCH-I500 Build/FROYO) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', '192.168.1.105', '', '57385', 'en-US', '1', '2014-02-06 10:58:16');
INSERT INTO `users_device_login` VALUES ('1645', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.123', '', '59499', 'es-ES', '0', '2014-02-06 14:06:24');
INSERT INTO `users_device_login` VALUES ('1646', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '60072', 'es-US', '0', '2014-02-06 14:15:18');
INSERT INTO `users_device_login` VALUES ('1647', '101', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '62954', 'es-ES', '0', '2014-02-06 15:04:07');
INSERT INTO `users_device_login` VALUES ('1648', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.123', '', '52966', 'es-ES', '0', '2014-02-07 09:48:55');
INSERT INTO `users_device_login` VALUES ('1649', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.123', '', '51747', 'es-ES', '0', '2014-02-10 09:24:31');
INSERT INTO `users_device_login` VALUES ('1650', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.123', '', '51988', 'es-ES', '1', '2014-02-10 09:38:56');
INSERT INTO `users_device_login` VALUES ('1651', '103', 'Mozilla/5.0 (iPad; CPU OS 6_1_3 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B329 Safari/8536.25', '192.168.1.135', '', '50652', 'es-es', '1', '2014-02-10 15:27:04');
INSERT INTO `users_device_login` VALUES ('1652', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.123', '', '55226', 'es-ES', '0', '2014-02-10 15:28:55');
INSERT INTO `users_device_login` VALUES ('1653', '101', 'Mozilla/5.0 (Linux; U; Android 2.2.1; en-us; SCH-I500 Build/FROYO) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', '192.168.1.136', '', '43337', 'en-US', '1', '2014-02-11 09:17:11');
INSERT INTO `users_device_login` VALUES ('1654', '120', 'Mozilla/5.0 (Linux; U; Android 2.2.1; en-us; SCH-I500 Build/FROYO) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', '192.168.1.136', '', '34441', 'en-US', '1', '2014-02-11 14:42:21');
INSERT INTO `users_device_login` VALUES ('1655', '120', 'Mozilla/5.0 (Linux; U; Android 2.2.1; en-us; SCH-I500 Build/FROYO) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', '192.168.1.136', '', '34308', 'en-US', '1', '2014-02-11 14:43:39');
INSERT INTO `users_device_login` VALUES ('1656', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '56085', 'es-US', '0', '2014-02-13 11:37:54');
INSERT INTO `users_device_login` VALUES ('1657', '7', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '62660', 'es-US', '0', '2014-02-13 14:31:57');
INSERT INTO `users_device_login` VALUES ('1658', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.123', '', '62716', 'es-ES', '0', '2014-02-13 14:32:23');
INSERT INTO `users_device_login` VALUES ('1659', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.123', '', '63239', 'es-ES', '1', '2014-02-13 14:43:32');
INSERT INTO `users_device_login` VALUES ('1660', '7', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.129', '', '49773', 'es-ES', '1', '2014-02-13 14:47:45');
INSERT INTO `users_device_login` VALUES ('1661', '184', 'Mozilla/5.0 (iPad; CPU OS 7_0_4 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11B554a Safari/9537.53', '192.168.1.126', '', '50891', 'es-es', '1', '2014-02-13 14:47:48');
INSERT INTO `users_device_login` VALUES ('1662', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.130', '', '63745', 'es', '0', '2014-02-13 14:47:56');
INSERT INTO `users_device_login` VALUES ('1663', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.123', '', '63562', 'es-ES', '1', '2014-02-13 14:48:50');
INSERT INTO `users_device_login` VALUES ('1664', '120', 'Mozilla/5.0 (iPad; CPU OS 6_1_3 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10B329 Safari/8536.25', '192.168.1.126', '', '51633', 'es-es', '1', '2014-02-14 11:24:58');
INSERT INTO `users_device_login` VALUES ('1665', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.123', '', '57740', 'es-ES', '0', '2014-02-17 13:56:45');
INSERT INTO `users_device_login` VALUES ('1666', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '192.168.1.141', '', '59225', 'es-419', '0', '2014-02-18 10:12:09');
INSERT INTO `users_device_login` VALUES ('1667', '120', 'Mozilla/5.0 (Linux; U; Android 2.2.1; en-us; SCH-I500 Build/FROYO) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', '192.168.1.124', '', '55013', 'en-US', '1', '2014-02-26 15:11:12');
INSERT INTO `users_device_login` VALUES ('1668', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.117 Safari/537.36', '192.168.1.141', '', '54380', 'es-419', '1', '2014-02-26 16:10:54');
INSERT INTO `users_device_login` VALUES ('1669', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36', '192.168.1.123', '', '56317', 'es-ES', '0', '2014-03-06 09:09:27');
INSERT INTO `users_device_login` VALUES ('1670', '7', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '50117', 'es-US', '1', '2014-03-10 11:32:07');
INSERT INTO `users_device_login` VALUES ('1671', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36', '192.168.1.123', '', '63350', 'es-ES', '0', '2014-03-11 10:26:52');
INSERT INTO `users_device_login` VALUES ('1672', '7', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '64087', 'es-US', '0', '2014-03-11 10:36:18');
INSERT INTO `users_device_login` VALUES ('1673', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '64245', 'es-ES', '0', '2014-03-11 10:37:03');
INSERT INTO `users_device_login` VALUES ('1674', '101', 'Mozilla/5.0 (iPad; CPU OS 7_0_4 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11B554a Safari/9537.53', '192.168.1.127', '', '54473', 'es-es', '0', '2014-03-12 10:38:16');
INSERT INTO `users_device_login` VALUES ('1675', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '59189', 'es-ES', '0', '2014-03-12 10:42:07');
INSERT INTO `users_device_login` VALUES ('1676', '103', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '59776', 'es-ES', '0', '2014-03-12 10:55:27');
INSERT INTO `users_device_login` VALUES ('1677', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36', '192.168.1.123', '', '57933', 'es-ES', '0', '2014-03-14 10:07:39');
INSERT INTO `users_device_login` VALUES ('1678', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36', '192.168.1.123', '', '50311', 'es-ES', '0', '2014-05-08 14:21:47');
INSERT INTO `users_device_login` VALUES ('1679', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', '192.168.1.123', '', '52681', 'es-ES', '0', '2014-05-30 11:21:00');
INSERT INTO `users_device_login` VALUES ('1680', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', '192.168.1.123', '', '58867', 'es-ES', '0', '2014-05-30 13:55:57');
INSERT INTO `users_device_login` VALUES ('1681', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0', '192.168.1.123', '', '64241', 'es-ES', '0', '2014-06-02 11:23:27');
INSERT INTO `users_device_login` VALUES ('1682', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '192.168.1.123', '', '64402', 'en-US', '0', '2014-06-02 11:24:19');
INSERT INTO `users_device_login` VALUES ('1683', '7', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '64562', 'es-ES', '0', '2014-06-02 11:24:52');
INSERT INTO `users_device_login` VALUES ('1684', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', '192.168.1.123', '', '49538', 'es-ES', '0', '2014-06-02 11:32:21');
INSERT INTO `users_device_login` VALUES ('1685', '7', 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', '192.168.1.123', '', '49653', 'es-ES', '0', '2014-06-02 11:32:46');
INSERT INTO `users_device_login` VALUES ('1686', '120', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0', '192.168.1.123', '', '50547', 'es-ES', '0', '2014-06-02 11:38:15');
INSERT INTO `users_device_login` VALUES ('1687', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.132 Safari/537.36 OPR/21.0.1432.67', '192.168.1.123', '', '55560', 'es-ES', '0', '2014-06-02 12:14:11');
INSERT INTO `users_device_login` VALUES ('1688', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36', '192.168.1.123', '', '51362', 'es-ES', '1', '2014-06-10 14:57:19');
INSERT INTO `users_device_login` VALUES ('1689', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '::1', '', '59629', 'es-ES', '0', '2014-07-09 13:36:49');
INSERT INTO `users_device_login` VALUES ('1690', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '::1', '', '60718', 'es-ES', '0', '2014-07-11 17:01:19');
INSERT INTO `users_device_login` VALUES ('1691', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '::1', '', '63463', 'es-ES', '0', '2014-07-17 15:40:42');
INSERT INTO `users_device_login` VALUES ('1692', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '62477', 'es-ES', '0', '2014-07-18 14:15:24');
INSERT INTO `users_device_login` VALUES ('1693', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '63029', 'es-ES', '0', '2014-07-18 14:27:51');
INSERT INTO `users_device_login` VALUES ('1694', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '50056', 'es-ES', '0', '2014-07-18 15:58:22');
INSERT INTO `users_device_login` VALUES ('1695', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '50067', 'es-ES', '0', '2014-07-22 15:18:51');
INSERT INTO `users_device_login` VALUES ('1696', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '57839', 'es-ES', '0', '2014-07-23 09:45:39');
INSERT INTO `users_device_login` VALUES ('1697', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '192.168.1.129', '', '54775', 'es-ES', '0', '2014-07-25 17:08:37');
INSERT INTO `users_device_login` VALUES ('1698', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '59145', 'es-ES', '0', '2014-07-28 10:06:16');
INSERT INTO `users_device_login` VALUES ('1699', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '192.168.1.141', '', '57687', 'es-419', '0', '2014-07-29 10:40:34');
INSERT INTO `users_device_login` VALUES ('1700', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '192.168.1.129', '', '52758', 'es-ES', '0', '2014-07-29 10:40:37');
INSERT INTO `users_device_login` VALUES ('1701', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '61455', 'es-ES', '0', '2014-07-31 17:12:50');
INSERT INTO `users_device_login` VALUES ('1702', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '61866', 'es-ES', '0', '2014-07-31 17:14:59');
INSERT INTO `users_device_login` VALUES ('1703', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '62514', 'es-ES', '0', '2014-07-31 17:17:46');
INSERT INTO `users_device_login` VALUES ('1704', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '63122', 'es-ES', '0', '2014-07-31 17:34:21');
INSERT INTO `users_device_login` VALUES ('1705', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '63318', 'es-ES', '0', '2014-07-31 17:41:18');
INSERT INTO `users_device_login` VALUES ('1706', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '63476', 'es-ES', '0', '2014-07-31 17:41:29');
INSERT INTO `users_device_login` VALUES ('1707', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '63707', 'es-ES', '0', '2014-07-31 17:46:18');
INSERT INTO `users_device_login` VALUES ('1708', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '63902', 'es-ES', '0', '2014-07-31 17:47:06');
INSERT INTO `users_device_login` VALUES ('1709', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '64094', 'es-ES', '0', '2014-07-31 17:48:04');
INSERT INTO `users_device_login` VALUES ('1710', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '64112', 'es-ES', '0', '2014-07-31 17:48:14');
INSERT INTO `users_device_login` VALUES ('1711', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '64514', 'es-ES', '0', '2014-07-31 17:51:02');
INSERT INTO `users_device_login` VALUES ('1712', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '65160', 'es-ES', '0', '2014-08-01 14:11:09');
INSERT INTO `users_device_login` VALUES ('1713', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '51057', 'es-ES', '0', '2014-08-01 14:41:00');
INSERT INTO `users_device_login` VALUES ('1714', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '55727', 'es-ES', '0', '2014-08-04 15:42:29');
INSERT INTO `users_device_login` VALUES ('1715', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '60793', 'es-ES', '0', '2014-08-05 09:13:09');
INSERT INTO `users_device_login` VALUES ('1716', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '63610', 'es-ES', '0', '2014-08-05 10:45:00');
INSERT INTO `users_device_login` VALUES ('1717', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '49477', 'es-ES', '0', '2014-08-06 13:46:33');
INSERT INTO `users_device_login` VALUES ('1718', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '51129', 'es-ES', '0', '2014-08-06 14:15:25');
INSERT INTO `users_device_login` VALUES ('1719', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36', '::1', '', '52741', 'es-ES', '0', '2014-08-11 13:48:02');
INSERT INTO `users_device_login` VALUES ('1720', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '192.168.1.129', '', '57759', 'es-ES', '0', '2014-08-18 09:45:22');
INSERT INTO `users_device_login` VALUES ('1721', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '192.168.1.141', '', '50948', 'es-419', '0', '2014-08-18 09:45:28');
INSERT INTO `users_device_login` VALUES ('1722', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36 OPR/23.0.1522.75', '192.168.1.141', '', '51383', 'es-ES', '0', '2014-08-18 09:51:52');
INSERT INTO `users_device_login` VALUES ('1723', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '192.168.1.129', '', '59351', 'es-ES', '0', '2014-08-18 09:52:29');
INSERT INTO `users_device_login` VALUES ('1724', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36 OPR/23.0.1522.75', '192.168.1.141', '', '51417', 'es-ES', '0', '2014-08-18 09:52:30');
INSERT INTO `users_device_login` VALUES ('1725', '7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '192.168.1.134', '', '51387', 'en-US', '0', '2014-08-18 09:53:45');
INSERT INTO `users_device_login` VALUES ('1726', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '192.168.1.129', '', '63567', 'es-ES', '0', '2014-08-18 10:34:06');
INSERT INTO `users_device_login` VALUES ('1727', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '192.168.1.129', '', '63758', 'es-ES', '0', '2014-08-18 10:34:38');
INSERT INTO `users_device_login` VALUES ('1728', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '192.168.1.129', '', '63867', 'es-ES', '0', '2014-08-18 10:35:08');
INSERT INTO `users_device_login` VALUES ('1729', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '52866', 'es-ES', '0', '2014-08-18 12:14:10');
INSERT INTO `users_device_login` VALUES ('1730', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '50943', 'es-ES', '0', '2014-08-25 09:07:36');
INSERT INTO `users_device_login` VALUES ('1731', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '52438', 'es-ES', '0', '2014-08-25 10:06:40');
INSERT INTO `users_device_login` VALUES ('1732', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '54500', 'es-ES', '0', '2014-08-25 12:09:09');
INSERT INTO `users_device_login` VALUES ('1733', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '54270', 'es-ES', '0', '2014-08-26 14:24:16');
INSERT INTO `users_device_login` VALUES ('1734', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '54381', 'es-ES', '0', '2014-08-26 15:01:09');
INSERT INTO `users_device_login` VALUES ('1735', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '192.168.1.129', '', '64075', 'es-ES', '0', '2014-08-27 17:10:01');
INSERT INTO `users_device_login` VALUES ('1736', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '58535', 'es-ES', '0', '2014-08-28 14:04:47');
INSERT INTO `users_device_login` VALUES ('1737', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0', '::1', '', '61744', 'es-ES', '0', '2014-09-01 11:59:07');
INSERT INTO `users_device_login` VALUES ('1738', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '58872', 'es-ES', '0', '2014-09-02 11:58:18');
INSERT INTO `users_device_login` VALUES ('1739', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '60434', 'es-ES', '0', '2014-09-02 13:16:58');
INSERT INTO `users_device_login` VALUES ('1740', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '192.168.1.129', '', '54331', 'es-ES', '0', '2014-09-03 09:57:24');
INSERT INTO `users_device_login` VALUES ('1741', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '60868', 'es-ES', '0', '2014-09-04 14:30:29');
INSERT INTO `users_device_login` VALUES ('1742', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '51099', 'es-ES', '0', '2014-09-04 15:54:52');
INSERT INTO `users_device_login` VALUES ('1743', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36', '::1', '', '51392', 'es-ES', '0', '2014-09-04 16:01:43');
INSERT INTO `users_device_login` VALUES ('1744', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', '192.168.1.141', '', '60933', 'es-419', '0', '2014-09-30 16:13:47');
INSERT INTO `users_device_login` VALUES ('1745', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', '192.168.1.129', '', '60506', 'es-ES', '0', '2014-09-30 16:17:07');
INSERT INTO `users_device_login` VALUES ('1746', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '::1', '', '55620', 'es-US', '0', '2014-10-01 17:44:36');
INSERT INTO `users_device_login` VALUES ('1747', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', '::1', '', '54737', 'es-ES', '0', '2014-10-03 10:03:52');
INSERT INTO `users_device_login` VALUES ('1748', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', '192.168.1.122', '', '52965', 'es-ES', '0', '2014-10-10 10:01:25');
INSERT INTO `users_device_login` VALUES ('1749', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', '::1', '', '56496', 'es-ES', '0', '2014-10-10 14:00:23');
INSERT INTO `users_device_login` VALUES ('1750', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', '192.168.1.122', '', '61247', 'es-ES', '0', '2014-10-10 15:04:06');
INSERT INTO `users_device_login` VALUES ('1751', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', '::1', '', '58080', 'es-ES', '0', '2014-10-14 15:53:42');
INSERT INTO `users_device_login` VALUES ('1752', '124', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53', '192.168.1.112', '', '64266', 'es-es', '1', '2014-11-07 10:07:54');
INSERT INTO `users_device_login` VALUES ('1753', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36', '::1', '', '54227', 'es-ES', '0', '2014-11-12 11:10:07');
INSERT INTO `users_device_login` VALUES ('1754', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36', '::1', '', '54317', 'es-ES', '0', '2014-11-12 11:10:21');
INSERT INTO `users_device_login` VALUES ('1755', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36', '::1', '', '54679', 'es-ES', '0', '2014-11-12 11:13:58');
INSERT INTO `users_device_login` VALUES ('1756', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36', '::1', '', '57190', 'es-ES', '0', '2014-11-12 11:43:29');
INSERT INTO `users_device_login` VALUES ('1757', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36', '::1', '', '51584', 'es-ES', '0', '2014-11-12 16:17:41');
INSERT INTO `users_device_login` VALUES ('1758', '124', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53', '192.168.1.112', '', '55148', 'es-es', '1', '2014-11-17 16:53:24');
INSERT INTO `users_device_login` VALUES ('1759', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36', '192.168.1.122', '', '60920', 'es-ES', '1', '2014-11-26 16:53:06');
INSERT INTO `users_device_login` VALUES ('1760', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36', '192.168.1.123', '', '65013', 'es-419', '1', '2014-11-26 16:54:35');
INSERT INTO `users_device_login` VALUES ('1761', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.65 Safari/537.36', '192.168.1.127', '', '57077', 'es-ES', '0', '2014-11-26 16:54:43');
INSERT INTO `users_device_login` VALUES ('1762', '124', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53', '192.168.1.112', '', '50061', 'es-es', '1', '2014-11-26 17:08:38');
INSERT INTO `users_device_login` VALUES ('1763', '124', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53', '192.168.1.112', '', '50889', 'es-es', '1', '2014-11-27 08:52:28');
INSERT INTO `users_device_login` VALUES ('1764', '124', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53', '192.168.1.112', '', '50954', 'es-es', '1', '2014-11-27 09:20:58');
INSERT INTO `users_device_login` VALUES ('1765', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36', '::1', '', '63561', 'es-ES', '0', '2014-12-11 11:01:19');
INSERT INTO `users_device_login` VALUES ('1766', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36', '::1', '', '50607', 'es-ES', '0', '2014-12-17 04:46:09');
INSERT INTO `users_device_login` VALUES ('1767', '124', 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_1_2 like Mac OS X) AppleWebKit/537.51.2 (KHTML, like Gecko) Version/7.0 Mobile/11D257 Safari/9537.53', '192.168.5.148', '', '53243', 'es-es', '1', '2014-12-19 16:53:36');
INSERT INTO `users_device_login` VALUES ('1768', '183', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36', '::1', '', '56617', 'es-ES', '0', '2014-12-22 18:31:52');
INSERT INTO `users_device_login` VALUES ('1769', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36', '192.168.1.122', '', '51042', 'es-ES', '1', '2015-01-13 14:52:04');
INSERT INTO `users_device_login` VALUES ('1770', '183', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36', '::1', '', '51791', 'es-ES', '0', '2015-01-14 10:53:50');
INSERT INTO `users_device_login` VALUES ('1771', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36', '::1', '', '51781', 'es-ES', '0', '2015-01-15 15:38:24');
INSERT INTO `users_device_login` VALUES ('1772', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '::1', '', '52746', 'es-ES', '0', '2015-01-15 15:42:38');
INSERT INTO `users_device_login` VALUES ('1773', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36', '::1', '', '53044', 'es-ES', '0', '2015-01-15 15:44:37');
INSERT INTO `users_device_login` VALUES ('1774', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '::1', '', '53296', 'es-ES', '0', '2015-01-15 15:45:51');
INSERT INTO `users_device_login` VALUES ('1775', '103', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '::1', '', '54093', 'es-ES', '0', '2015-01-15 15:53:48');
INSERT INTO `users_device_login` VALUES ('1776', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36', '::1', '', '56174', 'es-ES', '0', '2015-01-19 09:39:38');
INSERT INTO `users_device_login` VALUES ('1777', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36', '::1', '', '57606', 'es-ES', '0', '2015-01-19 09:58:17');
INSERT INTO `users_device_login` VALUES ('1778', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36', '::1', '', '58514', 'es-ES', '0', '2015-01-19 10:17:11');
INSERT INTO `users_device_login` VALUES ('1779', '2', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '::1', '', '60558', 'es-ES', '0', '2015-01-19 10:39:39');
INSERT INTO `users_device_login` VALUES ('1780', '101', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36', '192.168.1.127', '', '65177', 'es-ES', '0', '2015-01-19 11:01:00');
INSERT INTO `users_device_login` VALUES ('1781', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36', '::1', '', '57766', 'es-ES', '0', '2015-01-19 17:39:49');
INSERT INTO `users_device_login` VALUES ('1782', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '::1', '', '65485', 'es-ES', '0', '2015-01-22 08:40:38');
INSERT INTO `users_device_login` VALUES ('1783', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '::1', '', '49758', 'es-US', '0', '2015-01-26 10:32:04');
INSERT INTO `users_device_login` VALUES ('1784', '184', 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '::1', '', '59718', 'es-US', '0', '2015-01-26 15:49:36');
INSERT INTO `users_device_login` VALUES ('1785', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.93 Safari/537.36', '::1', '', '57206', 'es-ES', '0', '2015-02-02 11:10:56');
INSERT INTO `users_device_login` VALUES ('1786', '124', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', '::1', '', '65107', 'es-ES', '0', '2015-03-02 09:53:56');

-- ----------------------------
-- Table structure for users_groups
-- ----------------------------
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_group` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `is_admin` char(1) DEFAULT '0',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_update` datetime NOT NULL,
  `status` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=253 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_groups
-- ----------------------------
INSERT INTO `users_groups` VALUES ('230', '50', '184', '1', '2013-08-14 08:53:47', '2013-08-14 08:53:47', '1');
INSERT INTO `users_groups` VALUES ('229', '42', '103', '0', '2013-08-13 16:37:24', '2013-08-13 16:37:24', '1');
INSERT INTO `users_groups` VALUES ('228', '39', '103', '0', '2013-08-13 16:32:27', '2013-08-13 16:32:27', '1');
INSERT INTO `users_groups` VALUES ('227', '48', '103', '0', '2013-08-13 16:31:42', '2013-08-13 16:31:42', '1');
INSERT INTO `users_groups` VALUES ('196', '39', '101', '0', '2013-08-13 15:41:47', '2013-08-13 15:41:47', '1');
INSERT INTO `users_groups` VALUES ('195', '41', '101', '0', '2013-08-13 15:41:46', '2013-08-13 15:41:46', '1');
INSERT INTO `users_groups` VALUES ('194', '38', '101', '0', '2013-08-13 15:41:45', '2013-08-13 15:41:45', '1');
INSERT INTO `users_groups` VALUES ('193', '37', '101', '0', '2013-08-13 15:41:44', '2013-08-13 15:41:44', '1');
INSERT INTO `users_groups` VALUES ('192', '35', '101', '0', '2013-08-13 15:41:06', '2013-08-13 15:41:06', '1');
INSERT INTO `users_groups` VALUES ('191', '47', '101', '0', '2013-08-13 15:41:04', '2013-08-13 15:41:04', '1');
INSERT INTO `users_groups` VALUES ('189', '44', '101', '0', '2013-08-12 16:50:42', '2013-08-12 16:50:42', '1');
INSERT INTO `users_groups` VALUES ('188', '42', '101', '0', '2013-08-12 16:50:41', '2013-08-12 16:50:41', '1');
INSERT INTO `users_groups` VALUES ('187', '46', '101', '0', '2013-08-12 16:11:20', '2013-08-12 16:11:20', '1');
INSERT INTO `users_groups` VALUES ('186', '48', '101', '0', '2013-08-12 16:11:18', '2013-08-12 16:11:18', '1');
INSERT INTO `users_groups` VALUES ('185', '48', '83', '1', '2013-07-19 14:15:38', '2013-07-19 14:15:38', '1');
INSERT INTO `users_groups` VALUES ('184', '47', '7', '1', '2013-07-19 14:01:58', '2013-07-19 14:01:58', '1');
INSERT INTO `users_groups` VALUES ('183', '46', '83', '1', '2013-07-19 14:01:43', '2013-07-19 14:01:43', '1');
INSERT INTO `users_groups` VALUES ('182', '45', '101', '1', '2013-07-19 14:01:28', '2013-07-19 14:01:28', '1');
INSERT INTO `users_groups` VALUES ('181', '44', '83', '1', '2013-07-19 13:57:54', '2013-07-19 13:57:54', '1');
INSERT INTO `users_groups` VALUES ('180', '43', '101', '1', '2013-07-19 13:57:33', '2013-07-19 13:57:33', '0');
INSERT INTO `users_groups` VALUES ('179', '43', '2', '1', '2013-07-19 13:57:12', '2013-07-19 13:57:12', '1');
INSERT INTO `users_groups` VALUES ('178', '42', '7', '1', '2013-07-19 13:56:46', '2013-07-19 13:56:46', '1');
INSERT INTO `users_groups` VALUES ('177', '41', '83', '1', '2013-07-19 13:56:23', '2013-07-19 13:56:23', '1');
INSERT INTO `users_groups` VALUES ('176', '40', '101', '1', '2013-07-19 13:56:00', '2013-07-19 13:56:00', '1');
INSERT INTO `users_groups` VALUES ('175', '39', '7', '1', '2013-07-19 13:53:23', '2013-07-19 13:53:23', '1');
INSERT INTO `users_groups` VALUES ('174', '38', '7', '1', '2013-07-19 13:50:42', '2013-07-19 13:50:42', '1');
INSERT INTO `users_groups` VALUES ('173', '37', '83', '1', '2013-07-19 13:48:55', '2013-07-19 13:48:55', '1');
INSERT INTO `users_groups` VALUES ('171', '36', '101', '1', '2013-07-19 13:47:14', '2013-07-19 13:45:13', '1');
INSERT INTO `users_groups` VALUES ('170', '36', '2', '1', '2013-07-19 13:39:49', '2013-07-19 13:39:49', '1');
INSERT INTO `users_groups` VALUES ('169', '35', '83', '1', '2013-07-19 13:39:18', '2013-07-19 13:39:18', '1');
INSERT INTO `users_groups` VALUES ('168', '34', '101', '1', '2013-07-19 13:35:10', '2013-07-19 13:35:10', '1');
INSERT INTO `users_groups` VALUES ('231', '51', '101', '1', '2013-08-28 16:04:14', '2013-08-28 16:04:14', '1');
INSERT INTO `users_groups` VALUES ('232', '52', '101', '1', '2013-12-05 10:37:15', '2013-12-05 10:37:15', '1');
INSERT INTO `users_groups` VALUES ('235', '54', '103', '1', '2013-12-09 16:02:04', '2013-12-09 16:02:04', '1');
INSERT INTO `users_groups` VALUES ('236', '54', '101', '0', '2014-06-02 12:15:05', '2014-06-02 12:15:05', '1');
INSERT INTO `users_groups` VALUES ('237', '55', '103', '1', '2013-12-11 08:51:43', '2013-12-11 08:51:43', '1');
INSERT INTO `users_groups` VALUES ('238', '56', '103', '1', '2013-12-11 09:02:26', '2013-12-11 09:02:26', '1');
INSERT INTO `users_groups` VALUES ('239', '57', '101', '1', '2013-12-11 09:03:25', '2013-12-11 09:03:25', '1');
INSERT INTO `users_groups` VALUES ('240', '58', '120', '1', '2013-12-11 09:08:39', '2013-12-11 09:08:39', '1');
INSERT INTO `users_groups` VALUES ('241', '59', '103', '1', '2013-12-11 09:08:46', '2013-12-11 09:08:46', '1');
INSERT INTO `users_groups` VALUES ('242', '60', '101', '1', '2013-12-11 09:08:51', '2013-12-11 09:08:51', '1');
INSERT INTO `users_groups` VALUES ('243', '59', '120', '0', '2013-12-11 09:12:46', '2013-12-11 09:12:46', '1');
INSERT INTO `users_groups` VALUES ('244', '60', '120', '0', '2013-12-11 09:09:44', '2013-12-11 09:09:44', '1');
INSERT INTO `users_groups` VALUES ('245', '34', '120', '0', '2014-02-26 16:01:28', '2014-02-26 16:01:28', null);
INSERT INTO `users_groups` VALUES ('246', '61', '101', '1', '2014-06-02 15:37:54', '2014-06-02 15:37:54', '1');
INSERT INTO `users_groups` VALUES ('247', '61', '2', '0', '2014-06-02 15:46:08', '2014-06-02 15:46:08', '1');
INSERT INTO `users_groups` VALUES ('248', '61', '7', '0', '2014-06-02 15:48:22', '2014-06-02 15:46:58', '1');
INSERT INTO `users_groups` VALUES ('249', '61', '103', '0', '2014-06-02 15:48:09', '2014-06-02 15:46:58', '1');
INSERT INTO `users_groups` VALUES ('252', '61', '120', '0', '2014-06-02 16:01:34', '2014-06-02 16:00:55', '1');

-- ----------------------------
-- Table structure for users_links
-- ----------------------------
DROP TABLE IF EXISTS `users_links`;
CREATE TABLE `users_links` (
  `id_user` bigint(20) NOT NULL,
  `id_friend` bigint(20) NOT NULL,
  `is_friend` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_user`,`id_friend`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_links
-- ----------------------------
INSERT INTO `users_links` VALUES ('184', '84', '0');
INSERT INTO `users_links` VALUES ('103', '201', '0');
INSERT INTO `users_links` VALUES ('184', '118', '0');
INSERT INTO `users_links` VALUES ('184', '168', '0');
INSERT INTO `users_links` VALUES ('103', '171', '0');
INSERT INTO `users_links` VALUES ('103', '205', '0');
INSERT INTO `users_links` VALUES ('103', '176', '0');
INSERT INTO `users_links` VALUES ('103', '84', '0');
INSERT INTO `users_links` VALUES ('103', '122', '0');
INSERT INTO `users_links` VALUES ('103', '184', '1');
INSERT INTO `users_links` VALUES ('103', '169', '0');
INSERT INTO `users_links` VALUES ('103', '2', '1');
INSERT INTO `users_links` VALUES ('103', '178', '0');
INSERT INTO `users_links` VALUES ('103', '198', '0');
INSERT INTO `users_links` VALUES ('103', '172', '0');
INSERT INTO `users_links` VALUES ('103', '85', '0');
INSERT INTO `users_links` VALUES ('103', '183', '1');
INSERT INTO `users_links` VALUES ('103', '131', '0');
INSERT INTO `users_links` VALUES ('103', '199', '0');
INSERT INTO `users_links` VALUES ('103', '162', '0');
INSERT INTO `users_links` VALUES ('103', '196', '0');
INSERT INTO `users_links` VALUES ('103', '168', '0');
INSERT INTO `users_links` VALUES ('103', '125', '0');
INSERT INTO `users_links` VALUES ('103', '180', '0');
INSERT INTO `users_links` VALUES ('103', '165', '0');
INSERT INTO `users_links` VALUES ('103', '160', '0');
INSERT INTO `users_links` VALUES ('103', '124', '1');
INSERT INTO `users_links` VALUES ('103', '204', '0');
INSERT INTO `users_links` VALUES ('103', '181', '0');
INSERT INTO `users_links` VALUES ('103', '173', '0');
INSERT INTO `users_links` VALUES ('2', '178', '0');
INSERT INTO `users_links` VALUES ('2', '101', '1');
INSERT INTO `users_links` VALUES ('120', '181', '0');
INSERT INTO `users_links` VALUES ('7', '120', '1');
INSERT INTO `users_links` VALUES ('7', '184', '1');
INSERT INTO `users_links` VALUES ('7', '101', '1');
INSERT INTO `users_links` VALUES ('2', '7', '1');
INSERT INTO `users_links` VALUES ('7', '2', '1');
INSERT INTO `users_links` VALUES ('101', '171', '0');
INSERT INTO `users_links` VALUES ('101', '158', '0');
INSERT INTO `users_links` VALUES ('101', '203', '0');
INSERT INTO `users_links` VALUES ('101', '164', '0');
INSERT INTO `users_links` VALUES ('101', '174', '0');
INSERT INTO `users_links` VALUES ('101', '118', '0');
INSERT INTO `users_links` VALUES ('101', '208', '0');
INSERT INTO `users_links` VALUES ('101', '173', '0');
INSERT INTO `users_links` VALUES ('120', '125', '0');
INSERT INTO `users_links` VALUES ('120', '84', '0');
INSERT INTO `users_links` VALUES ('120', '7', '1');
INSERT INTO `users_links` VALUES ('120', '2', '0');
INSERT INTO `users_links` VALUES ('101', '204', '0');
INSERT INTO `users_links` VALUES ('101', '126', '0');
INSERT INTO `users_links` VALUES ('101', '160', '0');
INSERT INTO `users_links` VALUES ('101', '165', '0');
INSERT INTO `users_links` VALUES ('101', '123', '0');
INSERT INTO `users_links` VALUES ('101', '131', '0');
INSERT INTO `users_links` VALUES ('101', '125', '0');
INSERT INTO `users_links` VALUES ('7', '103', '1');
INSERT INTO `users_links` VALUES ('101', '162', '0');
INSERT INTO `users_links` VALUES ('101', '83', '0');
INSERT INTO `users_links` VALUES ('101', '163', '0');
INSERT INTO `users_links` VALUES ('101', '178', '0');
INSERT INTO `users_links` VALUES ('101', '103', '1');
INSERT INTO `users_links` VALUES ('101', '7', '1');
INSERT INTO `users_links` VALUES ('103', '206', '1');
INSERT INTO `users_links` VALUES ('183', '195', '0');
INSERT INTO `users_links` VALUES ('101', '206', '1');
INSERT INTO `users_links` VALUES ('206', '103', '1');
INSERT INTO `users_links` VALUES ('206', '101', '1');
INSERT INTO `users_links` VALUES ('206', '175', '0');
INSERT INTO `users_links` VALUES ('120', '101', '1');
INSERT INTO `users_links` VALUES ('101', '2', '1');
INSERT INTO `users_links` VALUES ('101', '84', '0');
INSERT INTO `users_links` VALUES ('101', '124', '1');
INSERT INTO `users_links` VALUES ('120', '126', '0');
INSERT INTO `users_links` VALUES ('120', '184', '1');
INSERT INTO `users_links` VALUES ('120', '103', '1');
INSERT INTO `users_links` VALUES ('120', '83', '0');
INSERT INTO `users_links` VALUES ('101', '120', '1');
INSERT INTO `users_links` VALUES ('124', '2', '1');
INSERT INTO `users_links` VALUES ('124', '103', '1');
INSERT INTO `users_links` VALUES ('124', '85', '0');
INSERT INTO `users_links` VALUES ('124', '101', '1');
INSERT INTO `users_links` VALUES ('101', '196', '0');
INSERT INTO `users_links` VALUES ('101', '184', '1');
INSERT INTO `users_links` VALUES ('101', '181', '0');
INSERT INTO `users_links` VALUES ('101', '169', '0');
INSERT INTO `users_links` VALUES ('101', '179', '0');
INSERT INTO `users_links` VALUES ('103', '123', '0');
INSERT INTO `users_links` VALUES ('103', '200', '0');
INSERT INTO `users_links` VALUES ('103', '203', '0');
INSERT INTO `users_links` VALUES ('184', '124', '1');
INSERT INTO `users_links` VALUES ('184', '180', '0');
INSERT INTO `users_links` VALUES ('184', '101', '1');
INSERT INTO `users_links` VALUES ('184', '126', '0');
INSERT INTO `users_links` VALUES ('184', '7', '1');
INSERT INTO `users_links` VALUES ('184', '198', '0');
INSERT INTO `users_links` VALUES ('184', '196', '0');
INSERT INTO `users_links` VALUES ('184', '160', '0');
INSERT INTO `users_links` VALUES ('184', '127', '0');
INSERT INTO `users_links` VALUES ('184', '119', '0');
INSERT INTO `users_links` VALUES ('184', '165', '0');
INSERT INTO `users_links` VALUES ('184', '202', '0');
INSERT INTO `users_links` VALUES ('184', '2', '1');
INSERT INTO `users_links` VALUES ('184', '175', '0');
INSERT INTO `users_links` VALUES ('184', '203', '0');
INSERT INTO `users_links` VALUES ('184', '176', '0');
INSERT INTO `users_links` VALUES ('184', '171', '0');
INSERT INTO `users_links` VALUES ('184', '162', '0');
INSERT INTO `users_links` VALUES ('184', '123', '0');
INSERT INTO `users_links` VALUES ('184', '122', '0');
INSERT INTO `users_links` VALUES ('184', '200', '0');
INSERT INTO `users_links` VALUES ('184', '177', '0');
INSERT INTO `users_links` VALUES ('184', '125', '0');
INSERT INTO `users_links` VALUES ('184', '199', '0');
INSERT INTO `users_links` VALUES ('184', '181', '0');
INSERT INTO `users_links` VALUES ('184', '197', '0');
INSERT INTO `users_links` VALUES ('184', '131', '0');
INSERT INTO `users_links` VALUES ('184', '159', '0');
INSERT INTO `users_links` VALUES ('184', '204', '0');
INSERT INTO `users_links` VALUES ('184', '170', '0');
INSERT INTO `users_links` VALUES ('184', '183', '1');
INSERT INTO `users_links` VALUES ('184', '164', '0');
INSERT INTO `users_links` VALUES ('184', '161', '0');
INSERT INTO `users_links` VALUES ('184', '103', '1');
INSERT INTO `users_links` VALUES ('184', '83', '0');
INSERT INTO `users_links` VALUES ('184', '179', '0');
INSERT INTO `users_links` VALUES ('184', '166', '0');
INSERT INTO `users_links` VALUES ('184', '121', '0');
INSERT INTO `users_links` VALUES ('184', '169', '0');
INSERT INTO `users_links` VALUES ('184', '157', '0');
INSERT INTO `users_links` VALUES ('184', '172', '0');
INSERT INTO `users_links` VALUES ('184', '205', '0');
INSERT INTO `users_links` VALUES ('184', '174', '0');
INSERT INTO `users_links` VALUES ('184', '163', '0');
INSERT INTO `users_links` VALUES ('184', '201', '0');
INSERT INTO `users_links` VALUES ('184', '85', '0');
INSERT INTO `users_links` VALUES ('184', '195', '0');
INSERT INTO `users_links` VALUES ('184', '120', '1');
INSERT INTO `users_links` VALUES ('184', '158', '0');
INSERT INTO `users_links` VALUES ('184', '178', '0');
INSERT INTO `users_links` VALUES ('184', '167', '0');
INSERT INTO `users_links` VALUES ('184', '173', '0');
INSERT INTO `users_links` VALUES ('103', '101', '1');
INSERT INTO `users_links` VALUES ('103', '175', '0');
INSERT INTO `users_links` VALUES ('103', '118', '0');
INSERT INTO `users_links` VALUES ('103', '158', '0');
INSERT INTO `users_links` VALUES ('103', '164', '0');
INSERT INTO `users_links` VALUES ('103', '119', '0');
INSERT INTO `users_links` VALUES ('103', '170', '0');
INSERT INTO `users_links` VALUES ('103', '159', '0');
INSERT INTO `users_links` VALUES ('103', '121', '0');
INSERT INTO `users_links` VALUES ('103', '166', '0');
INSERT INTO `users_links` VALUES ('103', '202', '0');
INSERT INTO `users_links` VALUES ('103', '174', '0');
INSERT INTO `users_links` VALUES ('103', '179', '0');
INSERT INTO `users_links` VALUES ('103', '167', '0');
INSERT INTO `users_links` VALUES ('103', '161', '0');
INSERT INTO `users_links` VALUES ('103', '197', '0');
INSERT INTO `users_links` VALUES ('103', '127', '0');
INSERT INTO `users_links` VALUES ('103', '83', '0');
INSERT INTO `users_links` VALUES ('103', '120', '1');
INSERT INTO `users_links` VALUES ('103', '126', '0');
INSERT INTO `users_links` VALUES ('103', '163', '0');
INSERT INTO `users_links` VALUES ('103', '195', '0');
INSERT INTO `users_links` VALUES ('103', '177', '0');
INSERT INTO `users_links` VALUES ('103', '157', '0');
INSERT INTO `users_links` VALUES ('103', '7', '1');
INSERT INTO `users_links` VALUES ('2', '124', '1');
INSERT INTO `users_links` VALUES ('2', '184', '1');
INSERT INTO `users_links` VALUES ('124', '196', '0');
INSERT INTO `users_links` VALUES ('124', '184', '1');
INSERT INTO `users_links` VALUES ('124', '84', '0');
INSERT INTO `users_links` VALUES ('124', '205', '0');
INSERT INTO `users_links` VALUES ('183', '184', '1');
INSERT INTO `users_links` VALUES ('183', '103', '1');
INSERT INTO `users_links` VALUES ('2', '103', '1');
INSERT INTO `users_links` VALUES ('124', '174', '0');

-- ----------------------------
-- Table structure for users_notifications
-- ----------------------------
DROP TABLE IF EXISTS `users_notifications`;
CREATE TABLE `users_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) NOT NULL,
  `id_source` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_friend` int(11) NOT NULL,
  `revised` char(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1846 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_notifications
-- ----------------------------
INSERT INTO `users_notifications` VALUES ('1', '4', '823', '7', '2', '1', '2011-11-22 10:06:09');
INSERT INTO `users_notifications` VALUES ('2', '4', '823', '2', '7', '1', '2011-11-22 10:06:27');
INSERT INTO `users_notifications` VALUES ('3', '2', '494', '101', '103', '1', '2011-11-23 15:44:01');
INSERT INTO `users_notifications` VALUES ('566', '2', '1532', '2', '7', '1', '2012-03-23 08:50:53');
INSERT INTO `users_notifications` VALUES ('565', '8', '1532', '2', '7', '1', '2012-03-23 08:50:51');
INSERT INTO `users_notifications` VALUES ('564', '2', '1530', '7', '101', '1', '2012-03-23 08:48:53');
INSERT INTO `users_notifications` VALUES ('563', '8', '1530', '7', '101', '1', '2012-03-23 08:48:47');
INSERT INTO `users_notifications` VALUES ('562', '4', '1529', '2', '0', '1', '2012-03-22 16:13:43');
INSERT INTO `users_notifications` VALUES ('586', '4', '1552', '2', '103', '1', '2012-03-23 10:10:08');
INSERT INTO `users_notifications` VALUES ('587', '4', '1552', '2', '103', '1', '2012-03-23 10:10:45');
INSERT INTO `users_notifications` VALUES ('61', '4', '971', '2', '7', '1', '2011-12-07 14:18:34');
INSERT INTO `users_notifications` VALUES ('57', '4', '906', '84', '2', '1', '2011-12-02 09:28:48');
INSERT INTO `users_notifications` VALUES ('13', '2', '838', '101', '2', '1', '2011-11-24 11:47:35');
INSERT INTO `users_notifications` VALUES ('14', '4', '839', '84', '2', '1', '2011-11-24 11:48:00');
INSERT INTO `users_notifications` VALUES ('15', '2', '837', '101', '2', '1', '2011-11-24 11:48:26');
INSERT INTO `users_notifications` VALUES ('16', '4', '838', '101', '2', '1', '2011-11-24 11:49:33');
INSERT INTO `users_notifications` VALUES ('58', '4', '906', '2', '84', '0', '2011-12-05 14:59:47');
INSERT INTO `users_notifications` VALUES ('18', '4', '833', '84', '7', '1', '2011-11-24 11:49:50');
INSERT INTO `users_notifications` VALUES ('19', '4', '833', '84', '7', '1', '2011-11-24 11:49:56');
INSERT INTO `users_notifications` VALUES ('20', '4', '838', '2', '101', '1', '2011-11-24 11:50:31');
INSERT INTO `users_notifications` VALUES ('21', '4', '494', '101', '103', '1', '2011-11-24 11:51:15');
INSERT INTO `users_notifications` VALUES ('22', '2', '577', '101', '2', '1', '2011-11-24 11:51:58');
INSERT INTO `users_notifications` VALUES ('23', '2', '835', '101', '2', '1', '2011-11-24 11:53:14');
INSERT INTO `users_notifications` VALUES ('24', '2', '833', '101', '7', '1', '2011-11-24 11:53:23');
INSERT INTO `users_notifications` VALUES ('25', '4', '833', '101', '84', '0', '2011-11-24 11:53:33');
INSERT INTO `users_notifications` VALUES ('26', '4', '833', '101', '7', '1', '2011-11-24 11:53:33');
INSERT INTO `users_notifications` VALUES ('27', '4', '833', '84', '101', '1', '2011-11-24 11:54:42');
INSERT INTO `users_notifications` VALUES ('28', '4', '833', '84', '7', '1', '2011-11-24 11:54:42');
INSERT INTO `users_notifications` VALUES ('29', '4', '833', '84', '101', '1', '2011-11-24 11:54:45');
INSERT INTO `users_notifications` VALUES ('30', '4', '833', '84', '7', '1', '2011-11-24 11:54:45');
INSERT INTO `users_notifications` VALUES ('31', '4', '833', '84', '101', '1', '2011-11-24 11:54:46');
INSERT INTO `users_notifications` VALUES ('32', '4', '833', '84', '7', '1', '2011-11-24 11:54:46');
INSERT INTO `users_notifications` VALUES ('33', '4', '833', '84', '101', '1', '2011-11-24 11:54:52');
INSERT INTO `users_notifications` VALUES ('34', '4', '833', '84', '7', '1', '2011-11-24 11:54:52');
INSERT INTO `users_notifications` VALUES ('35', '2', '836', '101', '2', '1', '2011-11-24 12:00:07');
INSERT INTO `users_notifications` VALUES ('36', '2', '831', '101', '7', '1', '2011-11-24 12:06:53');
INSERT INTO `users_notifications` VALUES ('37', '2', '853', '2', '7', '1', '2011-11-24 14:27:58');
INSERT INTO `users_notifications` VALUES ('38', '2', '851', '2', '7', '1', '2011-11-24 14:28:58');
INSERT INTO `users_notifications` VALUES ('39', '2', '853', '2', '7', '1', '2011-11-24 14:43:07');
INSERT INTO `users_notifications` VALUES ('40', '2', '853', '2', '7', '1', '2011-11-24 14:44:08');
INSERT INTO `users_notifications` VALUES ('41', '2', '853', '2', '7', '1', '2011-11-24 14:49:57');
INSERT INTO `users_notifications` VALUES ('42', '2', '853', '2', '7', '1', '2011-11-24 14:50:53');
INSERT INTO `users_notifications` VALUES ('43', '2', '853', '2', '7', '1', '2011-11-24 14:52:00');
INSERT INTO `users_notifications` VALUES ('44', '2', '853', '2', '7', '1', '2011-11-24 14:52:06');
INSERT INTO `users_notifications` VALUES ('45', '2', '853', '2', '7', '1', '2011-11-24 15:06:34');
INSERT INTO `users_notifications` VALUES ('46', '2', '853', '2', '7', '1', '2011-11-24 15:58:07');
INSERT INTO `users_notifications` VALUES ('47', '2', '853', '2', '7', '1', '2011-11-24 16:08:12');
INSERT INTO `users_notifications` VALUES ('48', '2', '853', '2', '7', '1', '2011-11-24 16:08:19');
INSERT INTO `users_notifications` VALUES ('49', '2', '853', '2', '7', '1', '2011-11-24 16:11:14');
INSERT INTO `users_notifications` VALUES ('50', '2', '853', '2', '7', '1', '2011-11-24 16:11:23');
INSERT INTO `users_notifications` VALUES ('51', '2', '853', '2', '7', '1', '2011-11-24 16:12:56');
INSERT INTO `users_notifications` VALUES ('52', '2', '853', '2', '7', '1', '2011-11-24 16:26:03');
INSERT INTO `users_notifications` VALUES ('53', '2', '853', '2', '7', '1', '2011-11-24 16:28:07');
INSERT INTO `users_notifications` VALUES ('54', '2', '853', '2', '7', '1', '2011-11-24 16:31:01');
INSERT INTO `users_notifications` VALUES ('55', '2', '853', '2', '7', '1', '2011-11-24 16:31:45');
INSERT INTO `users_notifications` VALUES ('56', '2', '854', '2', '84', '0', '2011-11-24 16:36:39');
INSERT INTO `users_notifications` VALUES ('59', '2', '906', '84', '2', '1', '2011-12-06 11:42:10');
INSERT INTO `users_notifications` VALUES ('60', '2', '906', '113', '2', '1', '2011-12-06 15:01:22');
INSERT INTO `users_notifications` VALUES ('62', '4', '971', '7', '2', '1', '2011-12-07 14:18:45');
INSERT INTO `users_notifications` VALUES ('63', '4', '971', '84', '2', '1', '2011-12-07 14:18:47');
INSERT INTO `users_notifications` VALUES ('64', '4', '971', '84', '7', '1', '2011-12-07 14:18:47');
INSERT INTO `users_notifications` VALUES ('65', '4', '971', '84', '2', '1', '2011-12-07 14:18:50');
INSERT INTO `users_notifications` VALUES ('66', '4', '971', '84', '7', '1', '2011-12-07 14:18:50');
INSERT INTO `users_notifications` VALUES ('67', '4', '971', '101', '2', '1', '2011-12-07 14:19:06');
INSERT INTO `users_notifications` VALUES ('68', '4', '971', '101', '7', '1', '2011-12-07 14:19:06');
INSERT INTO `users_notifications` VALUES ('69', '4', '971', '101', '84', '0', '2011-12-07 14:19:06');
INSERT INTO `users_notifications` VALUES ('70', '4', '971', '101', '2', '1', '2011-12-07 14:19:23');
INSERT INTO `users_notifications` VALUES ('71', '4', '971', '101', '7', '1', '2011-12-07 14:19:23');
INSERT INTO `users_notifications` VALUES ('72', '4', '971', '101', '84', '0', '2011-12-07 14:19:23');
INSERT INTO `users_notifications` VALUES ('73', '4', '971', '7', '2', '1', '2011-12-07 14:20:00');
INSERT INTO `users_notifications` VALUES ('74', '4', '971', '7', '84', '0', '2011-12-07 14:20:00');
INSERT INTO `users_notifications` VALUES ('75', '4', '971', '7', '101', '1', '2011-12-07 14:20:00');
INSERT INTO `users_notifications` VALUES ('76', '2', '971', '101', '7', '1', '2011-12-07 14:20:35');
INSERT INTO `users_notifications` VALUES ('77', '4', '971', '113', '2', '1', '2011-12-07 14:20:56');
INSERT INTO `users_notifications` VALUES ('78', '4', '971', '113', '7', '1', '2011-12-07 14:20:56');
INSERT INTO `users_notifications` VALUES ('79', '4', '971', '113', '84', '0', '2011-12-07 14:20:56');
INSERT INTO `users_notifications` VALUES ('80', '4', '971', '113', '101', '1', '2011-12-07 14:20:56');
INSERT INTO `users_notifications` VALUES ('81', '4', '971', '101', '2', '1', '2011-12-07 14:22:20');
INSERT INTO `users_notifications` VALUES ('82', '4', '971', '101', '7', '1', '2011-12-07 14:22:20');
INSERT INTO `users_notifications` VALUES ('83', '4', '971', '101', '84', '0', '2011-12-07 14:22:20');
INSERT INTO `users_notifications` VALUES ('84', '4', '971', '101', '113', '0', '2011-12-07 14:22:20');
INSERT INTO `users_notifications` VALUES ('85', '4', '971', '84', '2', '1', '2011-12-07 14:24:29');
INSERT INTO `users_notifications` VALUES ('86', '4', '971', '84', '7', '1', '2011-12-07 14:24:29');
INSERT INTO `users_notifications` VALUES ('87', '4', '971', '84', '101', '1', '2011-12-07 14:24:29');
INSERT INTO `users_notifications` VALUES ('88', '4', '971', '84', '113', '0', '2011-12-07 14:24:29');
INSERT INTO `users_notifications` VALUES ('89', '4', '971', '84', '2', '1', '2011-12-07 14:24:30');
INSERT INTO `users_notifications` VALUES ('90', '4', '971', '84', '7', '1', '2011-12-07 14:24:30');
INSERT INTO `users_notifications` VALUES ('91', '4', '971', '84', '101', '1', '2011-12-07 14:24:30');
INSERT INTO `users_notifications` VALUES ('92', '4', '971', '84', '113', '0', '2011-12-07 14:24:30');
INSERT INTO `users_notifications` VALUES ('93', '2', '1004', '7', '2', '1', '2011-12-07 14:40:49');
INSERT INTO `users_notifications` VALUES ('94', '4', '1004', '84', '7', '1', '2011-12-07 14:40:57');
INSERT INTO `users_notifications` VALUES ('95', '4', '1004', '84', '2', '1', '2011-12-07 14:40:57');
INSERT INTO `users_notifications` VALUES ('96', '4', '1004', '101', '7', '1', '2011-12-07 14:41:01');
INSERT INTO `users_notifications` VALUES ('97', '4', '1004', '101', '84', '0', '2011-12-07 14:41:01');
INSERT INTO `users_notifications` VALUES ('98', '4', '1004', '101', '2', '1', '2011-12-07 14:41:01');
INSERT INTO `users_notifications` VALUES ('99', '4', '1004', '101', '7', '1', '2011-12-07 14:41:06');
INSERT INTO `users_notifications` VALUES ('100', '4', '1004', '101', '84', '0', '2011-12-07 14:41:06');
INSERT INTO `users_notifications` VALUES ('101', '4', '1004', '101', '2', '1', '2011-12-07 14:41:06');
INSERT INTO `users_notifications` VALUES ('102', '4', '1004', '7', '84', '0', '2011-12-07 14:41:08');
INSERT INTO `users_notifications` VALUES ('103', '4', '1004', '7', '101', '1', '2011-12-07 14:41:08');
INSERT INTO `users_notifications` VALUES ('104', '4', '1004', '7', '2', '1', '2011-12-07 14:41:08');
INSERT INTO `users_notifications` VALUES ('105', '2', '1004', '101', '2', '1', '2011-12-07 14:41:09');
INSERT INTO `users_notifications` VALUES ('106', '4', '1004', '101', '7', '1', '2011-12-07 14:41:31');
INSERT INTO `users_notifications` VALUES ('107', '4', '1004', '101', '84', '0', '2011-12-07 14:41:31');
INSERT INTO `users_notifications` VALUES ('108', '4', '1004', '101', '2', '1', '2011-12-07 14:41:31');
INSERT INTO `users_notifications` VALUES ('109', '4', '1004', '113', '7', '1', '2011-12-07 14:41:40');
INSERT INTO `users_notifications` VALUES ('110', '4', '1004', '113', '84', '0', '2011-12-07 14:41:40');
INSERT INTO `users_notifications` VALUES ('111', '4', '1004', '113', '101', '1', '2011-12-07 14:41:40');
INSERT INTO `users_notifications` VALUES ('112', '4', '1004', '113', '2', '1', '2011-12-07 14:41:40');
INSERT INTO `users_notifications` VALUES ('113', '4', '1004', '84', '7', '1', '2011-12-07 14:42:07');
INSERT INTO `users_notifications` VALUES ('114', '4', '1004', '84', '101', '1', '2011-12-07 14:42:07');
INSERT INTO `users_notifications` VALUES ('115', '4', '1004', '84', '113', '0', '2011-12-07 14:42:07');
INSERT INTO `users_notifications` VALUES ('116', '4', '1004', '84', '2', '1', '2011-12-07 14:42:07');
INSERT INTO `users_notifications` VALUES ('117', '4', '1004', '7', '84', '0', '2011-12-07 14:42:21');
INSERT INTO `users_notifications` VALUES ('118', '4', '1004', '7', '101', '1', '2011-12-07 14:42:21');
INSERT INTO `users_notifications` VALUES ('119', '4', '1004', '7', '113', '0', '2011-12-07 14:42:21');
INSERT INTO `users_notifications` VALUES ('120', '4', '1004', '7', '2', '1', '2011-12-07 14:42:21');
INSERT INTO `users_notifications` VALUES ('121', '4', '1004', '7', '84', '0', '2011-12-07 14:42:52');
INSERT INTO `users_notifications` VALUES ('122', '4', '1004', '7', '101', '1', '2011-12-07 14:42:52');
INSERT INTO `users_notifications` VALUES ('123', '4', '1004', '7', '113', '0', '2011-12-07 14:42:52');
INSERT INTO `users_notifications` VALUES ('124', '4', '1004', '7', '2', '1', '2011-12-07 14:42:52');
INSERT INTO `users_notifications` VALUES ('130', '4', '1054', '84', '101', '1', '2011-12-08 11:25:23');
INSERT INTO `users_notifications` VALUES ('126', '4', '1004', '101', '7', '1', '2011-12-07 14:43:42');
INSERT INTO `users_notifications` VALUES ('127', '4', '1004', '101', '84', '0', '2011-12-07 14:43:42');
INSERT INTO `users_notifications` VALUES ('128', '4', '1004', '101', '113', '0', '2011-12-07 14:43:42');
INSERT INTO `users_notifications` VALUES ('129', '4', '1004', '101', '2', '1', '2011-12-07 14:43:42');
INSERT INTO `users_notifications` VALUES ('882', '2', '1616', '7', '2', '1', '2012-08-09 14:44:38');
INSERT INTO `users_notifications` VALUES ('250', '4', '1201', '101', '2', '1', '2012-02-14 11:50:39');
INSERT INTO `users_notifications` VALUES ('249', '4', '1201', '2', '101', '1', '2012-02-14 11:50:11');
INSERT INTO `users_notifications` VALUES ('138', '2', '1063', '7', '2', '1', '2011-12-08 15:17:27');
INSERT INTO `users_notifications` VALUES ('139', '4', '1069', '2', '84', '0', '2011-12-08 16:07:24');
INSERT INTO `users_notifications` VALUES ('140', '2', '1069', '2', '84', '0', '2011-12-08 16:07:39');
INSERT INTO `users_notifications` VALUES ('141', '2', '1069', '7', '84', '0', '2011-12-13 15:26:20');
INSERT INTO `users_notifications` VALUES ('248', '4', '1201', '2', '101', '1', '2012-02-14 11:49:55');
INSERT INTO `users_notifications` VALUES ('143', '2', '1104', '7', '101', '1', '2012-01-12 15:11:11');
INSERT INTO `users_notifications` VALUES ('144', '2', '748', '7', '101', '1', '2012-01-12 15:16:46');
INSERT INTO `users_notifications` VALUES ('145', '2', '1104', '7', '101', '1', '2012-01-12 15:21:28');
INSERT INTO `users_notifications` VALUES ('146', '4', '807', '101', '84', '0', '2012-01-13 11:06:59');
INSERT INTO `users_notifications` VALUES ('205', '2', '1134', '124', '2', '1', '2012-02-02 09:48:45');
INSERT INTO `users_notifications` VALUES ('148', '4', '1106', '2', '7', '1', '2012-01-13 11:07:23');
INSERT INTO `users_notifications` VALUES ('274', '4', '1241', '2', '124', '1', '2012-02-24 10:26:41');
INSERT INTO `users_notifications` VALUES ('152', '2', '1126', '7', '101', '1', '2012-01-13 14:16:19');
INSERT INTO `users_notifications` VALUES ('246', '1', '1199', '2', '101', '1', '2012-02-13 16:26:13');
INSERT INTO `users_notifications` VALUES ('245', '1', '1198', '2', '101', '1', '2012-02-13 16:22:00');
INSERT INTO `users_notifications` VALUES ('244', '1', '1196', '2', '101', '1', '2012-02-13 16:19:17');
INSERT INTO `users_notifications` VALUES ('158', '2', '1121', '7', '2', '1', '2012-01-13 14:55:01');
INSERT INTO `users_notifications` VALUES ('159', '4', '1133', '2', '7', '1', '2012-01-17 09:10:23');
INSERT INTO `users_notifications` VALUES ('160', '4', '1133', '2', '7', '1', '2012-01-17 09:10:28');
INSERT INTO `users_notifications` VALUES ('161', '4', '1133', '2', '7', '1', '2012-01-17 09:30:25');
INSERT INTO `users_notifications` VALUES ('162', '4', '1133', '2', '7', '1', '2012-01-17 09:30:28');
INSERT INTO `users_notifications` VALUES ('163', '4', '1133', '2', '7', '1', '2012-01-17 09:30:30');
INSERT INTO `users_notifications` VALUES ('164', '4', '1133', '2', '7', '1', '2012-01-17 09:30:32');
INSERT INTO `users_notifications` VALUES ('165', '4', '1133', '2', '7', '1', '2012-01-17 09:30:34');
INSERT INTO `users_notifications` VALUES ('166', '4', '1133', '2', '7', '1', '2012-01-17 09:30:35');
INSERT INTO `users_notifications` VALUES ('167', '4', '1133', '2', '7', '1', '2012-01-17 09:30:37');
INSERT INTO `users_notifications` VALUES ('168', '4', '1133', '2', '7', '1', '2012-01-17 09:30:42');
INSERT INTO `users_notifications` VALUES ('169', '2', '1133', '2', '7', '1', '2012-01-17 09:35:26');
INSERT INTO `users_notifications` VALUES ('170', '2', '1133', '2', '7', '1', '2012-01-17 09:35:35');
INSERT INTO `users_notifications` VALUES ('171', '2', '1133', '2', '7', '1', '2012-01-17 09:35:41');
INSERT INTO `users_notifications` VALUES ('172', '2', '1133', '2', '7', '1', '2012-01-17 09:35:44');
INSERT INTO `users_notifications` VALUES ('173', '2', '1133', '2', '7', '1', '2012-01-17 09:35:45');
INSERT INTO `users_notifications` VALUES ('174', '2', '1133', '2', '7', '1', '2012-01-17 09:35:52');
INSERT INTO `users_notifications` VALUES ('175', '2', '1133', '2', '7', '1', '2012-01-17 09:35:57');
INSERT INTO `users_notifications` VALUES ('176', '2', '1133', '2', '7', '1', '2012-01-17 10:34:36');
INSERT INTO `users_notifications` VALUES ('177', '2', '1133', '2', '7', '1', '2012-01-17 10:35:08');
INSERT INTO `users_notifications` VALUES ('178', '2', '1133', '2', '7', '1', '2012-01-17 10:37:52');
INSERT INTO `users_notifications` VALUES ('179', '2', '1133', '2', '7', '1', '2012-01-17 10:38:20');
INSERT INTO `users_notifications` VALUES ('180', '2', '1133', '2', '7', '1', '2012-01-17 11:28:01');
INSERT INTO `users_notifications` VALUES ('181', '2', '1133', '2', '7', '1', '2012-01-17 11:29:21');
INSERT INTO `users_notifications` VALUES ('182', '2', '1133', '2', '7', '1', '2012-01-17 11:36:22');
INSERT INTO `users_notifications` VALUES ('183', '2', '1133', '2', '7', '1', '2012-01-17 11:36:26');
INSERT INTO `users_notifications` VALUES ('273', '4', '1241', '2', '124', '1', '2012-02-24 10:26:39');
INSERT INTO `users_notifications` VALUES ('208', '2', '1134', '124', '2', '1', '2012-02-02 10:52:51');
INSERT INTO `users_notifications` VALUES ('186', '2', '1136', '2', '7', '1', '2012-01-18 11:31:53');
INSERT INTO `users_notifications` VALUES ('881', '8', '1616', '7', '2', '1', '2012-08-09 14:44:18');
INSERT INTO `users_notifications` VALUES ('838', '6', '12', '101', '7', '1', '2012-04-30 12:00:53');
INSERT INTO `users_notifications` VALUES ('837', '6', '12', '101', '7', '1', '2012-04-30 12:00:23');
INSERT INTO `users_notifications` VALUES ('818', '2', '1607', '7', '101', '1', '2012-04-17 11:34:29');
INSERT INTO `users_notifications` VALUES ('874', '8', '1615', '2', '101', '1', '2012-08-09 11:56:10');
INSERT INTO `users_notifications` VALUES ('824', '6', '10', '2', '101', '1', '2012-04-23 08:46:32');
INSERT INTO `users_notifications` VALUES ('823', '6', '10', '2', '7', '1', '2012-04-23 08:46:31');
INSERT INTO `users_notifications` VALUES ('196', '1', '1148', '2', '101', '1', '2012-01-30 14:20:50');
INSERT INTO `users_notifications` VALUES ('197', '1', '1148', '2', '7', '1', '2012-01-30 14:20:50');
INSERT INTO `users_notifications` VALUES ('271', '4', '1241', '2', '124', '1', '2012-02-24 10:26:34');
INSERT INTO `users_notifications` VALUES ('270', '4', '1241', '2', '124', '1', '2012-02-24 10:26:32');
INSERT INTO `users_notifications` VALUES ('269', '2', '1241', '2', '124', '1', '2012-02-24 10:26:18');
INSERT INTO `users_notifications` VALUES ('209', '2', '1134', '124', '2', '1', '2012-02-02 10:53:15');
INSERT INTO `users_notifications` VALUES ('210', '2', '1138', '124', '7', '1', '2012-02-02 11:00:21');
INSERT INTO `users_notifications` VALUES ('211', '8', '1163', '101', '7', '1', '2012-02-02 16:06:15');
INSERT INTO `users_notifications` VALUES ('812', '12', '6', '101', '103', '1', '2012-04-13 09:31:06');
INSERT INTO `users_notifications` VALUES ('807', '12', '1', '101', '103', '1', '2012-04-12 15:50:07');
INSERT INTO `users_notifications` VALUES ('806', '6', '1', '103', '2', '1', '2012-04-12 15:48:48');
INSERT INTO `users_notifications` VALUES ('805', '6', '1', '103', '2', '1', '2012-04-12 15:47:41');
INSERT INTO `users_notifications` VALUES ('804', '12', '4', '103', '157', '0', '2012-04-12 14:13:03');
INSERT INTO `users_notifications` VALUES ('800', '12', '1', '157', '103', '1', '2012-04-12 13:14:01');
INSERT INTO `users_notifications` VALUES ('795', '2', '1607', '103', '101', '1', '2012-04-12 09:43:01');
INSERT INTO `users_notifications` VALUES ('794', '4', '1604', '7', '103', '1', '2012-04-11 16:11:18');
INSERT INTO `users_notifications` VALUES ('793', '4', '1604', '7', '101', '1', '2012-04-11 16:11:18');
INSERT INTO `users_notifications` VALUES ('792', '4', '1604', '7', '2', '1', '2012-04-11 16:11:17');
INSERT INTO `users_notifications` VALUES ('791', '4', '1535', '7', '101', '1', '2012-04-11 16:08:25');
INSERT INTO `users_notifications` VALUES ('790', '4', '1535', '7', '2', '1', '2012-04-11 16:08:25');
INSERT INTO `users_notifications` VALUES ('789', '4', '1535', '2', '0', '1', '2012-04-11 16:05:48');
INSERT INTO `users_notifications` VALUES ('225', '9', '1082', '101', '2', '1', '2012-02-03 15:28:32');
INSERT INTO `users_notifications` VALUES ('226', '8', '1180', '2', '101', '1', '2012-02-03 16:01:12');
INSERT INTO `users_notifications` VALUES ('228', '8', '1181', '101', '2', '1', '2012-02-06 08:52:35');
INSERT INTO `users_notifications` VALUES ('229', '8', '1182', '2', '101', '1', '2012-02-06 09:12:21');
INSERT INTO `users_notifications` VALUES ('272', '4', '1241', '2', '124', '1', '2012-02-24 10:26:36');
INSERT INTO `users_notifications` VALUES ('231', '5', '118', '2', '118', '0', '2012-02-06 09:40:37');
INSERT INTO `users_notifications` VALUES ('232', '2', '1138', '124', '7', '1', '2012-02-06 16:43:50');
INSERT INTO `users_notifications` VALUES ('788', '4', '1535', '2', '101', '1', '2012-04-11 16:05:47');
INSERT INTO `users_notifications` VALUES ('234', '2', '1187', '2', '101', '1', '2012-02-13 09:42:33');
INSERT INTO `users_notifications` VALUES ('235', '1', '1188', '101', '2', '1', '2012-02-13 10:03:42');
INSERT INTO `users_notifications` VALUES ('236', '1', '1189', '101', '2', '1', '2012-02-13 10:27:12');
INSERT INTO `users_notifications` VALUES ('237', '8', '1190', '2', '101', '1', '2012-02-13 11:58:29');
INSERT INTO `users_notifications` VALUES ('238', '1', '1191', '2', '101', '1', '2012-02-13 14:02:25');
INSERT INTO `users_notifications` VALUES ('239', '1', '1192', '101', '2', '1', '2012-02-13 14:03:32');
INSERT INTO `users_notifications` VALUES ('240', '2', '1192', '2', '101', '1', '2012-02-13 14:04:55');
INSERT INTO `users_notifications` VALUES ('241', '8', '1193', '2', '101', '1', '2012-02-13 14:04:57');
INSERT INTO `users_notifications` VALUES ('242', '1', '1194', '2', '101', '1', '2012-02-13 16:16:16');
INSERT INTO `users_notifications` VALUES ('243', '1', '1195', '2', '101', '1', '2012-02-13 16:17:52');
INSERT INTO `users_notifications` VALUES ('787', '4', '1535', '2', '7', '1', '2012-04-11 16:05:47');
INSERT INTO `users_notifications` VALUES ('1238', '12', '49', '101', '103', '1', '2013-08-13 08:53:46');
INSERT INTO `users_notifications` VALUES ('254', '2', '0', '2', '0', '1', '2012-02-15 09:43:18');
INSERT INTO `users_notifications` VALUES ('255', '2', '0', '2', '0', '1', '2012-02-15 09:43:21');
INSERT INTO `users_notifications` VALUES ('256', '2', '0', '2', '0', '1', '2012-02-15 09:43:23');
INSERT INTO `users_notifications` VALUES ('257', '8', '0', '2', '0', '1', '2012-02-15 09:43:24');
INSERT INTO `users_notifications` VALUES ('258', '8', '0', '2', '0', '1', '2012-02-15 09:43:26');
INSERT INTO `users_notifications` VALUES ('260', '8', '1213', '2', '101', '1', '2012-02-16 11:54:49');
INSERT INTO `users_notifications` VALUES ('261', '2', '1212', '2', '101', '1', '2012-02-16 11:54:52');
INSERT INTO `users_notifications` VALUES ('262', '9', '1212', '2', '101', '1', '2012-02-16 11:55:08');
INSERT INTO `users_notifications` VALUES ('263', '8', '1214', '125', '101', '1', '2012-02-16 13:46:23');
INSERT INTO `users_notifications` VALUES ('264', '2', '1212', '125', '101', '1', '2012-02-16 13:46:26');
INSERT INTO `users_notifications` VALUES ('265', '8', '1237', '101', '103', '1', '2012-02-17 11:22:25');
INSERT INTO `users_notifications` VALUES ('266', '2', '1236', '101', '103', '1', '2012-02-17 11:22:27');
INSERT INTO `users_notifications` VALUES ('267', '8', '1239', '124', '2', '1', '2012-02-22 11:18:54');
INSERT INTO `users_notifications` VALUES ('268', '8', '1240', '124', '101', '1', '2012-02-22 11:19:01');
INSERT INTO `users_notifications` VALUES ('275', '4', '1241', '2', '124', '1', '2012-02-24 10:26:43');
INSERT INTO `users_notifications` VALUES ('276', '4', '1241', '2', '124', '1', '2012-02-24 10:26:46');
INSERT INTO `users_notifications` VALUES ('277', '4', '1241', '2', '124', '1', '2012-02-24 10:26:48');
INSERT INTO `users_notifications` VALUES ('278', '4', '1241', '2', '124', '1', '2012-02-24 10:26:50');
INSERT INTO `users_notifications` VALUES ('279', '4', '1241', '2', '124', '1', '2012-02-24 10:26:54');
INSERT INTO `users_notifications` VALUES ('280', '4', '1241', '84', '2', '1', '2012-02-24 10:27:02');
INSERT INTO `users_notifications` VALUES ('281', '4', '1241', '84', '124', '1', '2012-02-24 10:27:02');
INSERT INTO `users_notifications` VALUES ('282', '2', '1241', '84', '124', '1', '2012-02-24 10:27:05');
INSERT INTO `users_notifications` VALUES ('786', '4', '1535', '101', '7', '1', '2012-04-11 16:02:23');
INSERT INTO `users_notifications` VALUES ('785', '4', '1535', '7', '101', '1', '2012-04-11 15:58:47');
INSERT INTO `users_notifications` VALUES ('784', '4', '1535', '7', '0', '1', '2012-04-11 15:54:17');
INSERT INTO `users_notifications` VALUES ('783', '4', '1535', '7', '101', '1', '2012-04-11 15:54:17');
INSERT INTO `users_notifications` VALUES ('782', '4', '1535', '7', '0', '1', '2012-04-11 15:42:37');
INSERT INTO `users_notifications` VALUES ('781', '4', '1535', '7', '101', '1', '2012-04-11 15:42:36');
INSERT INTO `users_notifications` VALUES ('780', '4', '1604', '7', '0', '1', '2012-04-11 15:41:56');
INSERT INTO `users_notifications` VALUES ('779', '4', '1604', '7', '103', '1', '2012-04-11 15:41:55');
INSERT INTO `users_notifications` VALUES ('778', '4', '1604', '7', '101', '1', '2012-04-11 15:41:55');
INSERT INTO `users_notifications` VALUES ('777', '4', '1604', '7', '2', '1', '2012-04-11 15:41:55');
INSERT INTO `users_notifications` VALUES ('776', '4', '1525', '7', '0', '1', '2012-04-11 15:33:52');
INSERT INTO `users_notifications` VALUES ('775', '4', '1525', '7', '103', '1', '2012-04-11 15:33:52');
INSERT INTO `users_notifications` VALUES ('295', '2', '1298', '103', '101', '1', '2012-03-01 09:56:39');
INSERT INTO `users_notifications` VALUES ('296', '8', '1311', '103', '101', '1', '2012-03-01 10:39:47');
INSERT INTO `users_notifications` VALUES ('297', '2', '748', '124', '101', '1', '2012-03-01 12:07:00');
INSERT INTO `users_notifications` VALUES ('298', '4', '1166', '84', '7', '1', '2012-03-01 15:40:57');
INSERT INTO `users_notifications` VALUES ('299', '4', '1187', '84', '2', '1', '2012-03-01 15:44:38');
INSERT INTO `users_notifications` VALUES ('300', '4', '1187', '84', '101', '1', '2012-03-01 15:44:38');
INSERT INTO `users_notifications` VALUES ('301', '4', '1187', '101', '2', '1', '2012-03-01 15:50:42');
INSERT INTO `users_notifications` VALUES ('302', '4', '1187', '101', '84', '0', '2012-03-01 15:50:42');
INSERT INTO `users_notifications` VALUES ('774', '4', '1525', '7', '2', '1', '2012-04-11 15:33:51');
INSERT INTO `users_notifications` VALUES ('773', '4', '1604', '7', '0', '1', '2012-04-11 15:19:00');
INSERT INTO `users_notifications` VALUES ('772', '4', '1604', '7', '103', '1', '2012-04-11 15:19:00');
INSERT INTO `users_notifications` VALUES ('771', '4', '1604', '7', '101', '1', '2012-04-11 15:18:59');
INSERT INTO `users_notifications` VALUES ('418', '10', '1499', '103', '2', '1', '2012-03-13 11:33:25');
INSERT INTO `users_notifications` VALUES ('308', '10', '1368', '101', '103', '1', '2012-03-01 16:45:43');
INSERT INTO `users_notifications` VALUES ('361', '10', '1413', '103', '101', '1', '2012-03-05 08:42:05');
INSERT INTO `users_notifications` VALUES ('311', '10', '1369', '103', '101', '1', '2012-03-01 16:57:58');
INSERT INTO `users_notifications` VALUES ('770', '4', '1604', '7', '2', '1', '2012-04-11 15:18:58');
INSERT INTO `users_notifications` VALUES ('769', '4', '1535', '7', '0', '1', '2012-04-11 15:18:00');
INSERT INTO `users_notifications` VALUES ('314', '10', '1370', '2', '101', '1', '2012-03-02 09:23:17');
INSERT INTO `users_notifications` VALUES ('324', '10', '1402', '7', '103', '1', '2012-03-02 11:45:40');
INSERT INTO `users_notifications` VALUES ('358', '10', '1411', '101', '2', '1', '2012-03-02 17:00:32');
INSERT INTO `users_notifications` VALUES ('322', '10', '1402', '7', '118', '0', '2012-03-02 11:45:40');
INSERT INTO `users_notifications` VALUES ('321', '10', '1402', '7', '125', '0', '2012-03-02 11:45:40');
INSERT INTO `users_notifications` VALUES ('320', '10', '1402', '7', '101', '1', '2012-03-02 11:45:40');
INSERT INTO `users_notifications` VALUES ('325', '10', '1403', '7', '101', '1', '2012-03-02 11:47:27');
INSERT INTO `users_notifications` VALUES ('326', '10', '1403', '7', '125', '0', '2012-03-02 11:47:27');
INSERT INTO `users_notifications` VALUES ('327', '10', '1403', '7', '118', '0', '2012-03-02 11:47:27');
INSERT INTO `users_notifications` VALUES ('359', '10', '1412', '101', '2', '1', '2012-03-05 08:40:55');
INSERT INTO `users_notifications` VALUES ('329', '10', '1403', '7', '103', '1', '2012-03-02 11:47:27');
INSERT INTO `users_notifications` VALUES ('330', '10', '1404', '7', '101', '1', '2012-03-02 11:48:04');
INSERT INTO `users_notifications` VALUES ('331', '10', '1404', '7', '125', '0', '2012-03-02 11:48:04');
INSERT INTO `users_notifications` VALUES ('332', '10', '1404', '7', '118', '0', '2012-03-02 11:48:04');
INSERT INTO `users_notifications` VALUES ('360', '10', '1413', '103', '2', '1', '2012-03-05 08:42:05');
INSERT INTO `users_notifications` VALUES ('334', '10', '1404', '7', '103', '1', '2012-03-02 11:48:04');
INSERT INTO `users_notifications` VALUES ('335', '10', '1405', '7', '101', '1', '2012-03-02 11:48:12');
INSERT INTO `users_notifications` VALUES ('336', '10', '1405', '7', '125', '0', '2012-03-02 11:48:12');
INSERT INTO `users_notifications` VALUES ('337', '10', '1405', '7', '118', '0', '2012-03-02 11:48:12');
INSERT INTO `users_notifications` VALUES ('768', '4', '1535', '7', '101', '1', '2012-04-11 15:18:00');
INSERT INTO `users_notifications` VALUES ('339', '10', '1405', '7', '103', '1', '2012-03-02 11:48:12');
INSERT INTO `users_notifications` VALUES ('340', '10', '1406', '7', '101', '1', '2012-03-02 11:49:20');
INSERT INTO `users_notifications` VALUES ('341', '10', '1406', '7', '125', '0', '2012-03-02 11:49:20');
INSERT INTO `users_notifications` VALUES ('342', '10', '1406', '7', '118', '0', '2012-03-02 11:49:20');
INSERT INTO `users_notifications` VALUES ('427', '11', '101', '7', '101', '2', '2012-03-13 15:52:49');
INSERT INTO `users_notifications` VALUES ('344', '10', '1406', '7', '103', '1', '2012-03-02 11:49:20');
INSERT INTO `users_notifications` VALUES ('345', '10', '1407', '7', '101', '1', '2012-03-02 11:51:37');
INSERT INTO `users_notifications` VALUES ('346', '10', '1407', '7', '125', '0', '2012-03-02 11:51:37');
INSERT INTO `users_notifications` VALUES ('347', '10', '1407', '7', '118', '0', '2012-03-02 11:51:37');
INSERT INTO `users_notifications` VALUES ('767', '4', '1535', '7', '0', '1', '2012-04-11 15:15:46');
INSERT INTO `users_notifications` VALUES ('349', '10', '1407', '7', '103', '1', '2012-03-02 11:51:37');
INSERT INTO `users_notifications` VALUES ('350', '10', '1408', '7', '101', '1', '2012-03-02 11:54:35');
INSERT INTO `users_notifications` VALUES ('351', '10', '1408', '7', '125', '0', '2012-03-02 11:54:35');
INSERT INTO `users_notifications` VALUES ('352', '10', '1408', '7', '118', '0', '2012-03-02 11:54:35');
INSERT INTO `users_notifications` VALUES ('450', '11', '101', '84', '101', '2', '2012-03-14 14:44:32');
INSERT INTO `users_notifications` VALUES ('354', '10', '1408', '7', '103', '1', '2012-03-02 11:54:35');
INSERT INTO `users_notifications` VALUES ('362', '10', '1414', '101', '2', '1', '2012-03-05 08:43:26');
INSERT INTO `users_notifications` VALUES ('363', '10', '1414', '101', '103', '1', '2012-03-05 08:43:26');
INSERT INTO `users_notifications` VALUES ('364', '2', '748', '124', '101', '1', '2012-03-06 16:50:50');
INSERT INTO `users_notifications` VALUES ('365', '8', '1475', '103', '2', '1', '2012-03-08 09:07:19');
INSERT INTO `users_notifications` VALUES ('366', '2', '1474', '103', '2', '1', '2012-03-08 09:07:22');
INSERT INTO `users_notifications` VALUES ('367', '2', '1474', '101', '2', '1', '2012-03-08 09:08:12');
INSERT INTO `users_notifications` VALUES ('368', '8', '1476', '101', '2', '1', '2012-03-08 09:08:13');
INSERT INTO `users_notifications` VALUES ('369', '1', '1477', '101', '7', '1', '2012-03-08 10:27:09');
INSERT INTO `users_notifications` VALUES ('370', '1', '1477', '101', '103', '1', '2012-03-08 10:27:09');
INSERT INTO `users_notifications` VALUES ('371', '1', '1478', '101', '7', '1', '2012-03-08 10:28:10');
INSERT INTO `users_notifications` VALUES ('372', '1', '1478', '101', '103', '1', '2012-03-08 10:28:10');
INSERT INTO `users_notifications` VALUES ('373', '1', '1479', '101', '2', '1', '2012-03-08 13:16:40');
INSERT INTO `users_notifications` VALUES ('374', '8', '1482', '2', '103', '1', '2012-03-08 13:19:31');
INSERT INTO `users_notifications` VALUES ('375', '9', '1484', '2', '103', '1', '2012-03-08 13:21:44');
INSERT INTO `users_notifications` VALUES ('376', '9', '1483', '103', '101', '1', '2012-03-08 13:21:59');
INSERT INTO `users_notifications` VALUES ('377', '9', '1483', '2', '101', '1', '2012-03-08 13:22:47');
INSERT INTO `users_notifications` VALUES ('379', '4', '1485', '2', '103', '1', '2012-03-08 15:07:29');
INSERT INTO `users_notifications` VALUES ('380', '4', '1485', '101', '103', '1', '2012-03-08 15:07:54');
INSERT INTO `users_notifications` VALUES ('381', '4', '1485', '103', '101', '1', '2012-03-08 15:08:32');
INSERT INTO `users_notifications` VALUES ('766', '4', '1535', '7', '101', '1', '2012-04-11 15:15:46');
INSERT INTO `users_notifications` VALUES ('765', '4', '1525', '7', '0', '1', '2012-04-11 15:02:37');
INSERT INTO `users_notifications` VALUES ('764', '4', '1525', '7', '103', '1', '2012-04-11 15:02:37');
INSERT INTO `users_notifications` VALUES ('385', '10', '1486', '101', '103', '1', '2012-03-08 15:22:25');
INSERT INTO `users_notifications` VALUES ('386', '10', '1486', '101', '2', '1', '2012-03-08 15:22:25');
INSERT INTO `users_notifications` VALUES ('1039', '9', '1687', '184', '184', '1', '2013-04-16 11:08:59');
INSERT INTO `users_notifications` VALUES ('421', '11', '83', '7', '83', '1', '2012-03-13 15:30:36');
INSERT INTO `users_notifications` VALUES ('420', '10', '1500', '103', '101', '1', '2012-03-13 11:54:15');
INSERT INTO `users_notifications` VALUES ('417', '10', '1499', '103', '101', '1', '2012-03-13 11:33:25');
INSERT INTO `users_notifications` VALUES ('763', '4', '1525', '7', '2', '1', '2012-04-11 15:02:36');
INSERT INTO `users_notifications` VALUES ('850', '2', '1607', '84', '101', '1', '2012-05-24 16:34:40');
INSERT INTO `users_notifications` VALUES ('419', '10', '1500', '103', '2', '1', '2012-03-13 11:54:15');
INSERT INTO `users_notifications` VALUES ('422', '11', '118', '7', '118', '0', '2012-03-13 15:30:37');
INSERT INTO `users_notifications` VALUES ('423', '5', '118', '7', '118', '0', '2012-03-13 15:30:37');
INSERT INTO `users_notifications` VALUES ('424', '11', '103', '7', '103', '2', '2012-03-13 15:30:39');
INSERT INTO `users_notifications` VALUES ('425', '11', '125', '7', '125', '0', '2012-03-13 15:30:41');
INSERT INTO `users_notifications` VALUES ('426', '5', '125', '7', '125', '0', '2012-03-13 15:30:41');
INSERT INTO `users_notifications` VALUES ('429', '11', '84', '7', '84', '0', '2012-03-13 15:54:08');
INSERT INTO `users_notifications` VALUES ('433', '11', '7', '84', '7', '1', '2012-03-13 16:08:29');
INSERT INTO `users_notifications` VALUES ('432', '5', '7', '101', '7', '1', '2012-03-13 16:07:36');
INSERT INTO `users_notifications` VALUES ('434', '5', '7', '84', '7', '1', '2012-03-13 16:08:29');
INSERT INTO `users_notifications` VALUES ('849', '2', '1607', '84', '101', '1', '2012-05-24 16:34:26');
INSERT INTO `users_notifications` VALUES ('436', '11', '7', '103', '7', '1', '2012-03-14 13:45:34');
INSERT INTO `users_notifications` VALUES ('437', '5', '7', '103', '7', '1', '2012-03-14 13:45:34');
INSERT INTO `users_notifications` VALUES ('760', '4', '1590', '7', '101', '1', '2012-04-10 15:36:21');
INSERT INTO `users_notifications` VALUES ('759', '4', '1590', '7', '101', '1', '2012-04-10 15:32:52');
INSERT INTO `users_notifications` VALUES ('443', '2', '1501', '2', '7', '1', '2012-03-14 14:08:07');
INSERT INTO `users_notifications` VALUES ('444', '2', '1501', '101', '7', '1', '2012-03-14 14:08:50');
INSERT INTO `users_notifications` VALUES ('445', '2', '1502', '2', '7', '1', '2012-03-14 14:09:34');
INSERT INTO `users_notifications` VALUES ('446', '2', '1503', '101', '7', '1', '2012-03-14 14:09:48');
INSERT INTO `users_notifications` VALUES ('447', '2', '1503', '2', '7', '1', '2012-03-14 14:09:51');
INSERT INTO `users_notifications` VALUES ('448', '2', '1503', '84', '7', '1', '2012-03-14 14:13:27');
INSERT INTO `users_notifications` VALUES ('449', '2', '1503', '124', '7', '1', '2012-03-14 14:14:28');
INSERT INTO `users_notifications` VALUES ('451', '11', '101', '103', '101', '2', '2012-03-14 14:44:34');
INSERT INTO `users_notifications` VALUES ('452', '5', '101', '124', '101', '2', '2012-03-14 14:44:39');
INSERT INTO `users_notifications` VALUES ('453', '5', '7', '101', '7', '1', '2012-03-14 14:45:35');
INSERT INTO `users_notifications` VALUES ('454', '5', '84', '101', '84', '0', '2012-03-14 14:45:37');
INSERT INTO `users_notifications` VALUES ('455', '5', '103', '101', '103', '2', '2012-03-14 14:45:39');
INSERT INTO `users_notifications` VALUES ('456', '5', '131', '101', '131', '0', '2012-03-14 14:45:46');
INSERT INTO `users_notifications` VALUES ('457', '2', '1506', '101', '103', '1', '2012-03-14 15:04:54');
INSERT INTO `users_notifications` VALUES ('458', '2', '1507', '7', '84', '0', '2012-03-14 15:48:49');
INSERT INTO `users_notifications` VALUES ('459', '2', '1507', '2', '84', '0', '2012-03-14 15:57:07');
INSERT INTO `users_notifications` VALUES ('460', '5', '124', '84', '124', '2', '2012-03-14 16:26:51');
INSERT INTO `users_notifications` VALUES ('461', '5', '125', '84', '125', '0', '2012-03-14 16:26:52');
INSERT INTO `users_notifications` VALUES ('462', '5', '131', '2', '131', '0', '2012-03-15 11:57:16');
INSERT INTO `users_notifications` VALUES ('758', '4', '1590', '7', '101', '1', '2012-04-10 15:28:44');
INSERT INTO `users_notifications` VALUES ('757', '4', '1590', '7', '101', '1', '2012-04-10 15:14:58');
INSERT INTO `users_notifications` VALUES ('756', '4', '1590', '7', '101', '1', '2012-04-10 11:30:46');
INSERT INTO `users_notifications` VALUES ('755', '4', '1590', '7', '101', '1', '2012-04-10 11:22:05');
INSERT INTO `users_notifications` VALUES ('754', '4', '1604', '7', '0', '1', '2012-04-10 11:20:54');
INSERT INTO `users_notifications` VALUES ('753', '4', '1604', '7', '103', '1', '2012-04-10 11:20:54');
INSERT INTO `users_notifications` VALUES ('752', '4', '1604', '7', '101', '1', '2012-04-10 11:20:54');
INSERT INTO `users_notifications` VALUES ('751', '4', '1604', '7', '2', '1', '2012-04-10 11:20:54');
INSERT INTO `users_notifications` VALUES ('750', '4', '1604', '7', '0', '1', '2012-04-10 11:16:10');
INSERT INTO `users_notifications` VALUES ('749', '4', '1604', '7', '103', '1', '2012-04-10 11:16:10');
INSERT INTO `users_notifications` VALUES ('748', '4', '1604', '7', '101', '1', '2012-04-10 11:16:10');
INSERT INTO `users_notifications` VALUES ('747', '4', '1604', '7', '2', '1', '2012-04-10 11:16:09');
INSERT INTO `users_notifications` VALUES ('746', '4', '1604', '7', '0', '1', '2012-04-10 11:14:14');
INSERT INTO `users_notifications` VALUES ('745', '4', '1604', '7', '103', '1', '2012-04-10 11:14:14');
INSERT INTO `users_notifications` VALUES ('744', '4', '1604', '7', '101', '1', '2012-04-10 11:14:14');
INSERT INTO `users_notifications` VALUES ('743', '4', '1604', '7', '2', '1', '2012-04-10 11:14:13');
INSERT INTO `users_notifications` VALUES ('742', '4', '1604', '7', '0', '1', '2012-04-10 10:46:16');
INSERT INTO `users_notifications` VALUES ('741', '4', '1604', '7', '103', '1', '2012-04-10 10:46:16');
INSERT INTO `users_notifications` VALUES ('740', '4', '1604', '7', '101', '1', '2012-04-10 10:46:16');
INSERT INTO `users_notifications` VALUES ('739', '4', '1604', '7', '2', '1', '2012-04-10 10:46:15');
INSERT INTO `users_notifications` VALUES ('738', '4', '1604', '7', '0', '1', '2012-04-09 16:04:11');
INSERT INTO `users_notifications` VALUES ('737', '4', '1604', '7', '103', '1', '2012-04-09 16:04:11');
INSERT INTO `users_notifications` VALUES ('736', '4', '1604', '7', '101', '1', '2012-04-09 16:04:11');
INSERT INTO `users_notifications` VALUES ('735', '4', '1604', '7', '2', '1', '2012-04-09 16:04:10');
INSERT INTO `users_notifications` VALUES ('734', '4', '1590', '7', '101', '1', '2012-04-09 16:01:06');
INSERT INTO `users_notifications` VALUES ('733', '4', '1590', '7', '101', '1', '2012-04-09 15:52:55');
INSERT INTO `users_notifications` VALUES ('730', '6', '3', '101', '85', '0', '2012-04-09 10:57:42');
INSERT INTO `users_notifications` VALUES ('490', '10', '1508', '2', '7', '1', '2012-03-15 15:04:32');
INSERT INTO `users_notifications` VALUES ('491', '10', '1508', '2', '83', '1', '2012-03-15 15:04:32');
INSERT INTO `users_notifications` VALUES ('492', '10', '1508', '2', '84', '0', '2012-03-15 15:04:32');
INSERT INTO `users_notifications` VALUES ('493', '10', '1508', '2', '101', '1', '2012-03-15 15:04:32');
INSERT INTO `users_notifications` VALUES ('494', '10', '1508', '2', '103', '1', '2012-03-15 15:04:32');
INSERT INTO `users_notifications` VALUES ('495', '10', '1508', '2', '118', '0', '2012-03-15 15:04:32');
INSERT INTO `users_notifications` VALUES ('496', '10', '1508', '2', '124', '1', '2012-03-15 15:04:32');
INSERT INTO `users_notifications` VALUES ('497', '10', '1508', '2', '125', '0', '2012-03-15 15:04:32');
INSERT INTO `users_notifications` VALUES ('498', '10', '1508', '2', '131', '0', '2012-03-15 15:04:32');
INSERT INTO `users_notifications` VALUES ('732', '4', '1590', '7', '0', '1', '2012-04-09 15:29:06');
INSERT INTO `users_notifications` VALUES ('729', '6', '3', '101', '131', '0', '2012-04-09 10:57:42');
INSERT INTO `users_notifications` VALUES ('728', '6', '3', '101', '7', '1', '2012-04-09 10:57:42');
INSERT INTO `users_notifications` VALUES ('731', '6', '3', '101', '157', '0', '2012-04-09 10:57:42');
INSERT INTO `users_notifications` VALUES ('797', '12', '1', '84', '103', '1', '2012-04-12 11:58:39');
INSERT INTO `users_notifications` VALUES ('727', '6', '3', '101', '2', '1', '2012-04-09 10:57:42');
INSERT INTO `users_notifications` VALUES ('799', '6', '1', '103', '2', '1', '2012-04-12 13:12:27');
INSERT INTO `users_notifications` VALUES ('658', '6', '2', '7', '124', '1', '2012-04-02 11:02:02');
INSERT INTO `users_notifications` VALUES ('657', '6', '2', '7', '84', '0', '2012-04-02 11:02:02');
INSERT INTO `users_notifications` VALUES ('508', '8', '1509', '84', '7', '1', '2012-03-16 11:50:57');
INSERT INTO `users_notifications` VALUES ('509', '8', '1510', '101', '7', '1', '2012-03-16 11:51:01');
INSERT INTO `users_notifications` VALUES ('510', '8', '1511', '124', '2', '1', '2012-03-16 11:51:41');
INSERT INTO `users_notifications` VALUES ('511', '8', '1512', '84', '2', '1', '2012-03-16 11:54:08');
INSERT INTO `users_notifications` VALUES ('512', '8', '1513', '124', '2', '1', '2012-03-16 11:54:11');
INSERT INTO `users_notifications` VALUES ('513', '8', '1514', '84', '2', '1', '2012-03-16 12:02:25');
INSERT INTO `users_notifications` VALUES ('514', '8', '1514', '101', '2', '1', '2012-03-16 12:02:28');
INSERT INTO `users_notifications` VALUES ('515', '8', '1514', '124', '2', '1', '2012-03-16 12:02:28');
INSERT INTO `users_notifications` VALUES ('516', '8', '1518', '84', '2', '1', '2012-03-16 12:19:24');
INSERT INTO `users_notifications` VALUES ('517', '8', '1518', '101', '2', '1', '2012-03-16 12:19:26');
INSERT INTO `users_notifications` VALUES ('518', '8', '1518', '124', '2', '1', '2012-03-16 12:19:58');
INSERT INTO `users_notifications` VALUES ('519', '4', '1522', '103', '101', '1', '2012-03-22 11:56:13');
INSERT INTO `users_notifications` VALUES ('520', '4', '1522', '2', '103', '1', '2012-03-22 11:57:13');
INSERT INTO `users_notifications` VALUES ('521', '4', '1522', '2', '101', '1', '2012-03-22 11:57:13');
INSERT INTO `users_notifications` VALUES ('522', '4', '1522', '101', '2', '1', '2012-03-22 11:58:22');
INSERT INTO `users_notifications` VALUES ('523', '4', '1522', '101', '103', '1', '2012-03-22 11:58:22');
INSERT INTO `users_notifications` VALUES ('524', '4', '1522', '103', '2', '1', '2012-03-22 11:59:57');
INSERT INTO `users_notifications` VALUES ('525', '4', '1522', '103', '101', '1', '2012-03-22 11:59:57');
INSERT INTO `users_notifications` VALUES ('526', '4', '1523', '101', '103', '1', '2012-03-22 12:01:39');
INSERT INTO `users_notifications` VALUES ('527', '4', '1523', '2', '101', '1', '2012-03-22 12:01:52');
INSERT INTO `users_notifications` VALUES ('528', '4', '1523', '2', '103', '1', '2012-03-22 12:01:52');
INSERT INTO `users_notifications` VALUES ('529', '4', '1523', '2', '101', '1', '2012-03-22 12:09:14');
INSERT INTO `users_notifications` VALUES ('530', '4', '1523', '2', '103', '1', '2012-03-22 12:09:14');
INSERT INTO `users_notifications` VALUES ('531', '4', '1523', '7', '2', '1', '2012-03-22 12:10:32');
INSERT INTO `users_notifications` VALUES ('532', '4', '1523', '7', '101', '1', '2012-03-22 12:10:32');
INSERT INTO `users_notifications` VALUES ('533', '4', '1523', '7', '103', '1', '2012-03-22 12:10:32');
INSERT INTO `users_notifications` VALUES ('534', '4', '1524', '2', '101', '1', '2012-03-22 12:23:15');
INSERT INTO `users_notifications` VALUES ('535', '4', '1524', '103', '2', '1', '2012-03-22 12:23:24');
INSERT INTO `users_notifications` VALUES ('536', '4', '1524', '103', '101', '1', '2012-03-22 12:23:24');
INSERT INTO `users_notifications` VALUES ('537', '4', '1524', '103', '2', '1', '2012-03-22 12:23:33');
INSERT INTO `users_notifications` VALUES ('538', '4', '1524', '103', '101', '1', '2012-03-22 12:23:33');
INSERT INTO `users_notifications` VALUES ('539', '4', '1524', '2', '103', '1', '2012-03-22 12:23:47');
INSERT INTO `users_notifications` VALUES ('540', '4', '1524', '2', '101', '1', '2012-03-22 12:23:47');
INSERT INTO `users_notifications` VALUES ('541', '8', '1525', '103', '101', '1', '2012-03-22 13:35:25');
INSERT INTO `users_notifications` VALUES ('542', '2', '1525', '103', '101', '1', '2012-03-22 13:35:27');
INSERT INTO `users_notifications` VALUES ('543', '8', '1525', '2', '101', '1', '2012-03-22 13:35:35');
INSERT INTO `users_notifications` VALUES ('544', '2', '1525', '2', '101', '1', '2012-03-22 13:35:37');
INSERT INTO `users_notifications` VALUES ('545', '4', '1525', '2', '103', '1', '2012-03-22 13:35:43');
INSERT INTO `users_notifications` VALUES ('546', '4', '1525', '2', '101', '1', '2012-03-22 13:35:43');
INSERT INTO `users_notifications` VALUES ('547', '4', '1525', '103', '2', '1', '2012-03-22 13:35:49');
INSERT INTO `users_notifications` VALUES ('548', '4', '1525', '103', '101', '1', '2012-03-22 13:35:49');
INSERT INTO `users_notifications` VALUES ('585', '4', '1552', '2', '103', '1', '2012-03-23 10:02:22');
INSERT INTO `users_notifications` VALUES ('550', '4', '0', '103', '0', '1', '2012-03-22 13:36:04');
INSERT INTO `users_notifications` VALUES ('551', '9', '1525', '103', '101', '1', '2012-03-22 13:36:40');
INSERT INTO `users_notifications` VALUES ('584', '4', '1552', '103', '2', '1', '2012-03-23 10:01:39');
INSERT INTO `users_notifications` VALUES ('553', '4', '0', '103', '0', '1', '2012-03-22 13:37:04');
INSERT INTO `users_notifications` VALUES ('554', '4', '1525', '7', '2', '1', '2012-03-22 13:38:18');
INSERT INTO `users_notifications` VALUES ('555', '4', '1525', '7', '103', '1', '2012-03-22 13:38:18');
INSERT INTO `users_notifications` VALUES ('556', '4', '1525', '7', '101', '1', '2012-03-22 13:38:18');
INSERT INTO `users_notifications` VALUES ('583', '2', '1552', '103', '2', '1', '2012-03-23 10:00:34');
INSERT INTO `users_notifications` VALUES ('558', '4', '0', '103', '0', '1', '2012-03-22 13:39:42');
INSERT INTO `users_notifications` VALUES ('567', '8', '1532', '101', '7', '1', '2012-03-23 08:51:01');
INSERT INTO `users_notifications` VALUES ('568', '2', '1532', '101', '7', '1', '2012-03-23 08:51:05');
INSERT INTO `users_notifications` VALUES ('569', '8', '1535', '2', '101', '1', '2012-03-23 09:11:08');
INSERT INTO `users_notifications` VALUES ('570', '2', '1535', '2', '101', '1', '2012-03-23 09:11:09');
INSERT INTO `users_notifications` VALUES ('571', '2', '1535', '7', '101', '1', '2012-03-23 09:11:23');
INSERT INTO `users_notifications` VALUES ('572', '8', '1535', '7', '101', '1', '2012-03-23 09:11:24');
INSERT INTO `users_notifications` VALUES ('573', '4', '1535', '7', '2', '1', '2012-03-23 09:11:30');
INSERT INTO `users_notifications` VALUES ('574', '4', '1535', '7', '101', '1', '2012-03-23 09:11:30');
INSERT INTO `users_notifications` VALUES ('575', '4', '1535', '7', '2', '1', '2012-03-23 09:11:37');
INSERT INTO `users_notifications` VALUES ('576', '4', '1535', '7', '101', '1', '2012-03-23 09:11:37');
INSERT INTO `users_notifications` VALUES ('577', '4', '1535', '7', '2', '1', '2012-03-23 09:11:43');
INSERT INTO `users_notifications` VALUES ('578', '4', '1535', '7', '101', '1', '2012-03-23 09:11:43');
INSERT INTO `users_notifications` VALUES ('579', '4', '1535', '101', '2', '1', '2012-03-23 09:12:17');
INSERT INTO `users_notifications` VALUES ('580', '4', '1535', '101', '7', '1', '2012-03-23 09:12:17');
INSERT INTO `users_notifications` VALUES ('581', '4', '1535', '101', '2', '1', '2012-03-23 09:12:42');
INSERT INTO `users_notifications` VALUES ('582', '4', '1535', '101', '7', '1', '2012-03-23 09:12:42');
INSERT INTO `users_notifications` VALUES ('588', '4', '1552', '2', '103', '1', '2012-03-23 10:13:24');
INSERT INTO `users_notifications` VALUES ('589', '4', '1552', '103', '2', '1', '2012-03-23 10:14:37');
INSERT INTO `users_notifications` VALUES ('590', '4', '1552', '103', '2', '1', '2012-03-23 10:14:51');
INSERT INTO `users_notifications` VALUES ('591', '4', '1552', '103', '2', '1', '2012-03-23 10:14:55');
INSERT INTO `users_notifications` VALUES ('592', '8', '1552', '103', '2', '1', '2012-03-23 10:46:32');
INSERT INTO `users_notifications` VALUES ('617', '2', '1604', '103', '2', '1', '2012-03-26 15:15:48');
INSERT INTO `users_notifications` VALUES ('616', '8', '0', '103', '0', '1', '2012-03-26 14:24:06');
INSERT INTO `users_notifications` VALUES ('615', '8', '0', '103', '7', '1', '2012-03-26 14:24:06');
INSERT INTO `users_notifications` VALUES ('614', '8', '0', '103', '2', '1', '2012-03-26 14:24:06');
INSERT INTO `users_notifications` VALUES ('613', '8', '0', '103', '0', '1', '2012-03-26 14:23:10');
INSERT INTO `users_notifications` VALUES ('612', '8', '0', '103', '7', '1', '2012-03-26 14:23:10');
INSERT INTO `users_notifications` VALUES ('611', '8', '0', '103', '2', '1', '2012-03-26 14:23:10');
INSERT INTO `users_notifications` VALUES ('610', '4', '1552', '103', '2', '1', '2012-03-26 14:16:43');
INSERT INTO `users_notifications` VALUES ('873', '1', '1619', '0', '0', '1', '2012-08-09 11:45:48');
INSERT INTO `users_notifications` VALUES ('832', '6', '12', '101', '7', '1', '2012-04-30 11:59:56');
INSERT INTO `users_notifications` VALUES ('607', '4', '1529', '103', '2', '1', '2012-03-26 10:54:35');
INSERT INTO `users_notifications` VALUES ('606', '4', '1529', '103', '2', '1', '2012-03-26 09:52:37');
INSERT INTO `users_notifications` VALUES ('605', '8', '1552', '101', '2', '1', '2012-03-23 11:31:46');
INSERT INTO `users_notifications` VALUES ('618', '4', '1604', '103', '2', '1', '2012-03-26 15:15:55');
INSERT INTO `users_notifications` VALUES ('619', '2', '1604', '101', '2', '1', '2012-03-26 15:17:37');
INSERT INTO `users_notifications` VALUES ('620', '8', '1604', '101', '2', '1', '2012-03-26 15:17:42');
INSERT INTO `users_notifications` VALUES ('621', '4', '1604', '101', '103', '1', '2012-03-26 15:18:04');
INSERT INTO `users_notifications` VALUES ('622', '4', '1604', '101', '2', '1', '2012-03-26 15:18:04');
INSERT INTO `users_notifications` VALUES ('623', '4', '1604', '101', '103', '1', '2012-03-26 15:27:43');
INSERT INTO `users_notifications` VALUES ('624', '4', '1604', '101', '2', '1', '2012-03-26 15:27:43');
INSERT INTO `users_notifications` VALUES ('625', '4', '1604', '2', '101', '1', '2012-03-26 15:57:53');
INSERT INTO `users_notifications` VALUES ('626', '4', '1604', '2', '103', '1', '2012-03-26 15:57:53');
INSERT INTO `users_notifications` VALUES ('627', '8', '1604', '84', '2', '1', '2012-03-29 10:19:07');
INSERT INTO `users_notifications` VALUES ('628', '8', '1590', '84', '101', '1', '2012-03-29 10:24:03');
INSERT INTO `users_notifications` VALUES ('1229', '12', '5', '101', '103', '1', '2013-07-18 05:48:59');
INSERT INTO `users_notifications` VALUES ('798', '12', '3', '84', '101', '1', '2012-04-12 13:10:25');
INSERT INTO `users_notifications` VALUES ('654', '6', '2', '7', '124', '1', '2012-04-02 11:00:35');
INSERT INTO `users_notifications` VALUES ('1228', '12', '4', '101', '157', '0', '2013-07-18 05:48:49');
INSERT INTO `users_notifications` VALUES ('653', '6', '2', '7', '84', '0', '2012-04-02 11:00:35');
INSERT INTO `users_notifications` VALUES ('696', '12', '1', '7', '103', '1', '2012-04-03 11:30:34');
INSERT INTO `users_notifications` VALUES ('848', '12', '12', '103', '7', '1', '2012-05-03 10:37:57');
INSERT INTO `users_notifications` VALUES ('872', '1', '1618', '2', '7', '1', '2012-08-09 10:27:00');
INSERT INTO `users_notifications` VALUES ('846', '6', '12', '101', '7', '1', '2012-04-30 12:05:39');
INSERT INTO `users_notifications` VALUES ('847', '12', '12', '101', '7', '1', '2012-04-30 16:05:06');
INSERT INTO `users_notifications` VALUES ('1048', '11', '121', '184', '121', '0', '2013-04-18 16:25:37');
INSERT INTO `users_notifications` VALUES ('1037', '9', '1664', '2', '2', '1', '2013-04-16 11:05:07');
INSERT INTO `users_notifications` VALUES ('1036', '9', '1686', '101', '101', '1', '2013-04-16 11:04:26');
INSERT INTO `users_notifications` VALUES ('1035', '9', '1676', '101', '101', '1', '2013-04-16 10:54:39');
INSERT INTO `users_notifications` VALUES ('855', '4', '1607', '2', '0', '1', '2012-06-20 12:21:28');
INSERT INTO `users_notifications` VALUES ('856', '4', '1607', '2', '0', '1', '2012-06-20 12:21:37');
INSERT INTO `users_notifications` VALUES ('857', '4', '1607', '2', '0', '1', '2012-06-20 12:22:44');
INSERT INTO `users_notifications` VALUES ('858', '4', '1607', '2', '101', '1', '2012-06-20 12:23:41');
INSERT INTO `users_notifications` VALUES ('859', '4', '1607', '2', '101', '1', '2012-06-20 12:28:10');
INSERT INTO `users_notifications` VALUES ('860', '4', '1607', '2', '101', '1', '2012-06-20 12:28:53');
INSERT INTO `users_notifications` VALUES ('861', '4', '1607', '2', '101', '1', '2012-06-20 12:30:32');
INSERT INTO `users_notifications` VALUES ('862', '4', '1607', '2', '101', '1', '2012-06-20 12:31:26');
INSERT INTO `users_notifications` VALUES ('863', '4', '1607', '2', '0', '1', '2012-06-20 12:32:49');
INSERT INTO `users_notifications` VALUES ('864', '4', '1607', '2', '101', '1', '2012-06-20 12:35:26');
INSERT INTO `users_notifications` VALUES ('865', '4', '1607', '2', '101', '1', '2012-06-20 12:36:13');
INSERT INTO `users_notifications` VALUES ('866', '4', '1607', '2', '101', '1', '2012-06-20 12:47:04');
INSERT INTO `users_notifications` VALUES ('867', '4', '1607', '2', '101', '1', '2012-06-20 12:48:16');
INSERT INTO `users_notifications` VALUES ('868', '4', '1617', '2', '0', '1', '2012-07-18 11:05:12');
INSERT INTO `users_notifications` VALUES ('869', '4', '1617', '2', '0', '1', '2012-07-18 11:05:22');
INSERT INTO `users_notifications` VALUES ('870', '4', '1617', '2', '0', '1', '2012-07-18 11:05:40');
INSERT INTO `users_notifications` VALUES ('871', '4', '1617', '2', '0', '1', '2012-07-18 11:05:42');
INSERT INTO `users_notifications` VALUES ('880', '2', '1616', '7', '2', '1', '2012-08-09 14:44:07');
INSERT INTO `users_notifications` VALUES ('879', '4', '1616', '7', '0', '1', '2012-08-09 14:43:24');
INSERT INTO `users_notifications` VALUES ('935', '4', '1625', '124', '2', '1', '2012-11-07 16:09:16');
INSERT INTO `users_notifications` VALUES ('936', '4', '1625', '124', '101', '1', '2012-11-07 16:09:16');
INSERT INTO `users_notifications` VALUES ('937', '4', '1625', '101', '2', '1', '2012-11-07 16:10:21');
INSERT INTO `users_notifications` VALUES ('938', '4', '1625', '101', '124', '1', '2012-11-07 16:10:21');
INSERT INTO `users_notifications` VALUES ('889', '6', '16', '2', '101', '1', '2012-09-14 10:30:58');
INSERT INTO `users_notifications` VALUES ('890', '6', '16', '2', '101', '1', '2012-09-14 10:32:49');
INSERT INTO `users_notifications` VALUES ('891', '6', '16', '2', '7', '1', '2012-09-14 10:32:49');
INSERT INTO `users_notifications` VALUES ('892', '6', '16', '2', '101', '1', '2012-09-14 10:37:10');
INSERT INTO `users_notifications` VALUES ('893', '6', '16', '2', '7', '1', '2012-09-14 10:37:10');
INSERT INTO `users_notifications` VALUES ('894', '10', '1626', '2', '7', '1', '2012-09-14 10:39:19');
INSERT INTO `users_notifications` VALUES ('895', '10', '1626', '2', '101', '1', '2012-09-14 10:39:19');
INSERT INTO `users_notifications` VALUES ('933', '4', '1625', '2', '124', '1', '2012-11-07 16:09:09');
INSERT INTO `users_notifications` VALUES ('934', '4', '1625', '2', '101', '1', '2012-11-07 16:09:09');
INSERT INTO `users_notifications` VALUES ('939', '4', '1625', '2', '124', '1', '2012-11-07 16:10:38');
INSERT INTO `users_notifications` VALUES ('940', '4', '1625', '2', '101', '1', '2012-11-07 16:10:38');
INSERT INTO `users_notifications` VALUES ('941', '4', '1625', '7', '2', '1', '2012-11-07 16:11:58');
INSERT INTO `users_notifications` VALUES ('942', '4', '1625', '7', '124', '1', '2012-11-07 16:11:58');
INSERT INTO `users_notifications` VALUES ('943', '4', '1625', '7', '101', '1', '2012-11-07 16:11:58');
INSERT INTO `users_notifications` VALUES ('945', '13', '17', '2', '124', '1', '2012-11-08 08:53:00');
INSERT INTO `users_notifications` VALUES ('1837', '11', '205', '124', '205', '0', '2014-12-11 10:15:16');
INSERT INTO `users_notifications` VALUES ('947', '11', '166', '2', '166', '0', '2012-11-09 14:59:41');
INSERT INTO `users_notifications` VALUES ('948', '11', '85', '2', '85', '0', '2012-11-09 14:59:55');
INSERT INTO `users_notifications` VALUES ('949', '11', '182', '2', '182', '0', '2012-11-09 15:00:12');
INSERT INTO `users_notifications` VALUES ('950', '11', '127', '2', '127', '0', '2012-11-09 15:00:27');
INSERT INTO `users_notifications` VALUES ('951', '11', '157', '2', '157', '0', '2012-11-09 15:00:45');
INSERT INTO `users_notifications` VALUES ('952', '11', '122', '2', '122', '0', '2012-11-09 15:01:02');
INSERT INTO `users_notifications` VALUES ('1843', '5', '124', '2', '124', '0', '2015-01-15 15:45:27');
INSERT INTO `users_notifications` VALUES ('954', '5', '124', '2', '124', '2', '2012-11-09 15:02:10');
INSERT INTO `users_notifications` VALUES ('955', '5', '124', '2', '124', '2', '2012-11-09 15:03:01');
INSERT INTO `users_notifications` VALUES ('956', '5', '124', '2', '124', '2', '2012-11-09 15:07:41');
INSERT INTO `users_notifications` VALUES ('980', '4', '1625', '2', '7', '1', '2013-01-23 13:45:11');
INSERT INTO `users_notifications` VALUES ('979', '2', '1625', '2', '101', '1', '2013-01-22 16:03:54');
INSERT INTO `users_notifications` VALUES ('978', '2', '1625', '2', '101', '1', '2013-01-22 16:03:52');
INSERT INTO `users_notifications` VALUES ('977', '2', '1625', '2', '101', '1', '2013-01-21 11:05:34');
INSERT INTO `users_notifications` VALUES ('976', '4', '1625', '2', '101', '1', '2013-01-17 15:03:18');
INSERT INTO `users_notifications` VALUES ('975', '4', '1625', '2', '124', '1', '2013-01-17 15:03:18');
INSERT INTO `users_notifications` VALUES ('974', '4', '1625', '2', '7', '1', '2013-01-17 15:03:18');
INSERT INTO `users_notifications` VALUES ('981', '4', '1625', '2', '124', '1', '2013-01-23 13:45:11');
INSERT INTO `users_notifications` VALUES ('982', '4', '1625', '2', '101', '1', '2013-01-23 13:45:11');
INSERT INTO `users_notifications` VALUES ('983', '4', '1625', '2', '7', '1', '2013-01-23 14:24:17');
INSERT INTO `users_notifications` VALUES ('984', '4', '1625', '2', '124', '1', '2013-01-23 14:24:17');
INSERT INTO `users_notifications` VALUES ('985', '4', '1625', '2', '101', '1', '2013-01-23 14:24:17');
INSERT INTO `users_notifications` VALUES ('986', '8', '1611', '2', '101', '1', '2013-01-23 16:37:33');
INSERT INTO `users_notifications` VALUES ('987', '2', '1611', '2', '101', '1', '2013-01-23 16:37:38');
INSERT INTO `users_notifications` VALUES ('988', '2', '1611', '2', '101', '1', '2013-01-23 16:37:40');
INSERT INTO `users_notifications` VALUES ('989', '8', '1607', '2', '101', '1', '2013-01-25 09:45:54');
INSERT INTO `users_notifications` VALUES ('990', '8', '1625', '2', '101', '1', '2013-01-30 16:17:39');
INSERT INTO `users_notifications` VALUES ('991', '10', '1635', '2', '124', '1', '2013-02-18 09:42:28');
INSERT INTO `users_notifications` VALUES ('992', '10', '1635', '2', '124', '1', '2013-02-18 09:43:17');
INSERT INTO `users_notifications` VALUES ('993', '6', '17', '2', '101', '1', '2013-02-18 09:49:53');
INSERT INTO `users_notifications` VALUES ('994', '6', '17', '2', '125', '0', '2013-02-18 09:49:53');
INSERT INTO `users_notifications` VALUES ('995', '6', '17', '2', '118', '0', '2013-02-18 09:49:53');
INSERT INTO `users_notifications` VALUES ('996', '6', '17', '2', '131', '0', '2013-02-18 09:49:53');
INSERT INTO `users_notifications` VALUES ('997', '6', '17', '2', '84', '0', '2013-02-18 09:49:53');
INSERT INTO `users_notifications` VALUES ('998', '6', '17', '2', '7', '1', '2013-02-18 09:49:53');
INSERT INTO `users_notifications` VALUES ('999', '6', '17', '2', '103', '1', '2013-02-18 09:49:53');
INSERT INTO `users_notifications` VALUES ('1000', '6', '17', '2', '83', '1', '2013-02-18 09:49:53');
INSERT INTO `users_notifications` VALUES ('1001', '10', '1654', '2', '124', '1', '2013-03-15 14:41:09');
INSERT INTO `users_notifications` VALUES ('1002', '10', '1654', '2', '84', '0', '2013-03-15 14:41:09');
INSERT INTO `users_notifications` VALUES ('1003', '10', '1654', '2', '131', '0', '2013-03-15 14:41:09');
INSERT INTO `users_notifications` VALUES ('1004', '10', '1654', '2', '118', '0', '2013-03-15 14:41:09');
INSERT INTO `users_notifications` VALUES ('1005', '10', '1654', '2', '125', '0', '2013-03-15 14:41:09');
INSERT INTO `users_notifications` VALUES ('1006', '10', '1654', '2', '101', '1', '2013-03-15 14:41:09');
INSERT INTO `users_notifications` VALUES ('1007', '10', '1654', '2', '7', '1', '2013-03-15 14:41:09');
INSERT INTO `users_notifications` VALUES ('1008', '10', '1654', '2', '103', '1', '2013-03-15 14:41:09');
INSERT INTO `users_notifications` VALUES ('1009', '10', '1654', '2', '83', '1', '2013-03-15 14:41:09');
INSERT INTO `users_notifications` VALUES ('1010', '12', '6', '2', '103', '1', '2013-03-15 14:48:58');
INSERT INTO `users_notifications` VALUES ('1011', '10', '1656', '2', '124', '1', '2013-03-20 10:55:42');
INSERT INTO `users_notifications` VALUES ('1012', '10', '1656', '2', '84', '0', '2013-03-20 10:55:42');
INSERT INTO `users_notifications` VALUES ('1013', '10', '1656', '2', '131', '0', '2013-03-20 10:55:42');
INSERT INTO `users_notifications` VALUES ('1014', '10', '1656', '2', '118', '0', '2013-03-20 10:55:42');
INSERT INTO `users_notifications` VALUES ('1015', '10', '1656', '2', '125', '0', '2013-03-20 10:55:42');
INSERT INTO `users_notifications` VALUES ('1016', '10', '1656', '2', '101', '1', '2013-03-20 10:55:42');
INSERT INTO `users_notifications` VALUES ('1017', '10', '1656', '2', '7', '1', '2013-03-20 10:55:42');
INSERT INTO `users_notifications` VALUES ('1018', '10', '1656', '2', '103', '1', '2013-03-20 10:55:42');
INSERT INTO `users_notifications` VALUES ('1019', '10', '1656', '2', '83', '1', '2013-03-20 10:55:42');
INSERT INTO `users_notifications` VALUES ('1020', '1', '1657', '2', '103', '1', '2013-03-22 10:55:19');
INSERT INTO `users_notifications` VALUES ('1021', '1', '1657', '2', '124', '1', '2013-03-22 10:55:19');
INSERT INTO `users_notifications` VALUES ('1022', '1', '1658', '2', '7', '1', '2013-03-22 13:52:44');
INSERT INTO `users_notifications` VALUES ('1023', '1', '1658', '2', '124', '1', '2013-03-22 13:52:44');
INSERT INTO `users_notifications` VALUES ('1024', '1', '1659', '2', '124', '1', '2013-03-22 13:58:58');
INSERT INTO `users_notifications` VALUES ('1025', '1', '1659', '2', '7', '1', '2013-03-22 13:58:58');
INSERT INTO `users_notifications` VALUES ('1026', '1', '1660', '2', '7', '1', '2013-03-22 14:00:32');
INSERT INTO `users_notifications` VALUES ('1027', '1', '1660', '2', '124', '1', '2013-03-22 14:00:32');
INSERT INTO `users_notifications` VALUES ('1028', '1', '1661', '2', '7', '1', '2013-03-22 14:01:23');
INSERT INTO `users_notifications` VALUES ('1029', '1', '1661', '2', '124', '1', '2013-03-22 14:01:23');
INSERT INTO `users_notifications` VALUES ('1030', '1', '1662', '2', '7', '1', '2013-03-22 14:05:30');
INSERT INTO `users_notifications` VALUES ('1031', '4', '1667', '2', '0', '1', '2013-04-04 16:32:08');
INSERT INTO `users_notifications` VALUES ('1032', '9', '1669', '2', '2', '1', '2013-04-05 10:01:59');
INSERT INTO `users_notifications` VALUES ('1033', '9', '1675', '101', '101', '1', '2013-04-16 10:41:05');
INSERT INTO `users_notifications` VALUES ('1034', '9', '1671', '101', '101', '1', '2013-04-16 10:41:34');
INSERT INTO `users_notifications` VALUES ('1040', '11', '131', '196', '131', '0', '2013-04-18 16:22:28');
INSERT INTO `users_notifications` VALUES ('1041', '11', '85', '196', '85', '0', '2013-04-18 16:22:30');
INSERT INTO `users_notifications` VALUES ('1042', '11', '127', '196', '127', '0', '2013-04-18 16:22:34');
INSERT INTO `users_notifications` VALUES ('1043', '11', '2', '196', '2', '1', '2013-04-18 16:23:13');
INSERT INTO `users_notifications` VALUES ('1044', '11', '7', '196', '7', '1', '2013-04-18 16:23:17');
INSERT INTO `users_notifications` VALUES ('1045', '11', '101', '196', '101', '2', '2013-04-18 16:23:21');
INSERT INTO `users_notifications` VALUES ('1047', '11', '122', '184', '122', '0', '2013-04-18 16:25:09');
INSERT INTO `users_notifications` VALUES ('1049', '11', '83', '184', '83', '1', '2013-04-18 16:25:44');
INSERT INTO `users_notifications` VALUES ('1068', '5', '2', '184', '2', '1', '2013-04-22 10:56:49');
INSERT INTO `users_notifications` VALUES ('1051', '8', '1711', '2', '184', '1', '2013-04-18 16:52:55');
INSERT INTO `users_notifications` VALUES ('1052', '8', '1715', '2', '184', '1', '2013-04-18 16:53:39');
INSERT INTO `users_notifications` VALUES ('1053', '8', '1708', '184', '2', '1', '2013-04-18 16:55:03');
INSERT INTO `users_notifications` VALUES ('1054', '8', '1725', '184', '2', '1', '2013-04-22 09:20:50');
INSERT INTO `users_notifications` VALUES ('1055', '8', '1727', '184', '2', '1', '2013-04-22 09:20:59');
INSERT INTO `users_notifications` VALUES ('1056', '2', '1726', '184', '2', '1', '2013-04-22 09:25:01');
INSERT INTO `users_notifications` VALUES ('1057', '2', '1724', '184', '2', '1', '2013-04-22 09:25:03');
INSERT INTO `users_notifications` VALUES ('1058', '11', '2', '101', '2', '1', '2013-04-22 09:34:47');
INSERT INTO `users_notifications` VALUES ('1644', '11', '125', '184', '125', '0', '2013-09-10 10:13:42');
INSERT INTO `users_notifications` VALUES ('1060', '8', '1728', '101', '2', '1', '2013-04-22 09:36:23');
INSERT INTO `users_notifications` VALUES ('1061', '8', '1726', '184', '2', '1', '2013-04-22 09:37:58');
INSERT INTO `users_notifications` VALUES ('1062', '8', '1724', '184', '2', '1', '2013-04-22 09:39:42');
INSERT INTO `users_notifications` VALUES ('1063', '8', '1735', '101', '184', '1', '2013-04-22 09:56:32');
INSERT INTO `users_notifications` VALUES ('1064', '8', '1735', '2', '184', '1', '2013-04-22 09:58:35');
INSERT INTO `users_notifications` VALUES ('1065', '8', '1738', '101', '184', '1', '2013-04-22 10:23:13');
INSERT INTO `users_notifications` VALUES ('1078', '8', '1760', '184', '2', '1', '2013-04-22 15:41:14');
INSERT INTO `users_notifications` VALUES ('1067', '5', '101', '184', '101', '2', '2013-04-22 10:27:17');
INSERT INTO `users_notifications` VALUES ('1077', '8', '1761', '184', '2', '1', '2013-04-22 15:41:07');
INSERT INTO `users_notifications` VALUES ('1076', '8', '1752', '101', '184', '1', '2013-04-22 11:07:55');
INSERT INTO `users_notifications` VALUES ('1073', '5', '101', '2', '101', '2', '2013-04-22 10:58:47');
INSERT INTO `users_notifications` VALUES ('1081', '2', '1766', '2', '184', '1', '2013-04-24 09:50:58');
INSERT INTO `users_notifications` VALUES ('1082', '4', '1766', '2', '0', '1', '2013-04-24 09:51:20');
INSERT INTO `users_notifications` VALUES ('1086', '11', '184', '197', '184', '1', '2013-04-24 09:59:02');
INSERT INTO `users_notifications` VALUES ('1087', '2', '1763', '197', '184', '1', '2013-04-24 10:13:26');
INSERT INTO `users_notifications` VALUES ('1088', '8', '1763', '197', '2', '1', '2013-04-24 10:13:31');
INSERT INTO `users_notifications` VALUES ('1089', '8', '1758', '197', '184', '1', '2013-04-24 10:15:37');
INSERT INTO `users_notifications` VALUES ('1090', '2', '1758', '197', '184', '1', '2013-04-24 10:17:43');
INSERT INTO `users_notifications` VALUES ('1091', '8', '1722', '197', '184', '1', '2013-04-24 10:20:27');
INSERT INTO `users_notifications` VALUES ('1092', '2', '1722', '197', '184', '1', '2013-04-24 10:20:30');
INSERT INTO `users_notifications` VALUES ('1093', '1', '1774', '2', '184', '1', '2013-04-24 10:28:44');
INSERT INTO `users_notifications` VALUES ('1094', '4', '1777', '184', '0', '1', '2013-04-24 13:28:42');
INSERT INTO `users_notifications` VALUES ('1095', '4', '1777', '184', '0', '1', '2013-04-24 13:40:13');
INSERT INTO `users_notifications` VALUES ('1096', '4', '1777', '184', '0', '1', '2013-04-24 13:40:30');
INSERT INTO `users_notifications` VALUES ('1097', '4', '1778', '184', '0', '1', '2013-04-25 08:42:29');
INSERT INTO `users_notifications` VALUES ('1098', '4', '1778', '184', '0', '1', '2013-04-25 08:43:11');
INSERT INTO `users_notifications` VALUES ('1099', '4', '1778', '184', '0', '1', '2013-04-25 08:44:30');
INSERT INTO `users_notifications` VALUES ('1100', '4', '1778', '184', '0', '1', '2013-04-25 08:44:45');
INSERT INTO `users_notifications` VALUES ('1101', '4', '1778', '184', '0', '1', '2013-04-25 08:46:00');
INSERT INTO `users_notifications` VALUES ('1102', '4', '1778', '184', '0', '1', '2013-04-25 08:46:36');
INSERT INTO `users_notifications` VALUES ('1103', '4', '1778', '184', '0', '1', '2013-04-25 08:49:01');
INSERT INTO `users_notifications` VALUES ('1104', '4', '1778', '184', '0', '1', '2013-04-25 08:49:16');
INSERT INTO `users_notifications` VALUES ('1105', '4', '1778', '184', '0', '1', '2013-04-25 08:57:04');
INSERT INTO `users_notifications` VALUES ('1106', '4', '1778', '184', '0', '1', '2013-04-25 08:58:15');
INSERT INTO `users_notifications` VALUES ('1107', '4', '1778', '184', '0', '1', '2013-04-25 08:59:06');
INSERT INTO `users_notifications` VALUES ('1108', '4', '1778', '184', '0', '1', '2013-04-25 08:59:15');
INSERT INTO `users_notifications` VALUES ('1109', '4', '1778', '184', '0', '1', '2013-04-25 08:59:30');
INSERT INTO `users_notifications` VALUES ('1110', '4', '1778', '184', '0', '1', '2013-04-25 11:31:50');
INSERT INTO `users_notifications` VALUES ('1111', '4', '1778', '184', '0', '1', '2013-04-25 11:34:53');
INSERT INTO `users_notifications` VALUES ('1112', '4', '1778', '184', '0', '1', '2013-04-25 11:40:11');
INSERT INTO `users_notifications` VALUES ('1113', '4', '1778', '184', '0', '1', '2013-04-25 11:45:24');
INSERT INTO `users_notifications` VALUES ('1114', '6', '23', '2', '184', '1', '2013-04-25 15:14:11');
INSERT INTO `users_notifications` VALUES ('1116', '10', '1810', '2', '184', '1', '2013-04-25 15:34:10');
INSERT INTO `users_notifications` VALUES ('1117', '10', '1811', '2', '184', '1', '2013-04-25 15:34:13');
INSERT INTO `users_notifications` VALUES ('1118', '10', '1812', '2', '184', '1', '2013-04-25 15:34:43');
INSERT INTO `users_notifications` VALUES ('1119', '10', '1813', '2', '184', '1', '2013-04-25 15:34:47');
INSERT INTO `users_notifications` VALUES ('1120', '10', '1814', '2', '184', '1', '2013-04-25 15:34:50');
INSERT INTO `users_notifications` VALUES ('1121', '10', '1815', '2', '184', '1', '2013-04-25 15:36:52');
INSERT INTO `users_notifications` VALUES ('1122', '10', '1816', '2', '184', '1', '2013-04-25 15:36:58');
INSERT INTO `users_notifications` VALUES ('1123', '10', '1817', '2', '184', '1', '2013-04-25 15:37:01');
INSERT INTO `users_notifications` VALUES ('1124', '10', '1818', '2', '184', '1', '2013-04-25 15:40:37');
INSERT INTO `users_notifications` VALUES ('1125', '10', '1819', '2', '184', '1', '2013-04-25 15:40:40');
INSERT INTO `users_notifications` VALUES ('1126', '10', '1820', '2', '184', '1', '2013-04-25 15:41:04');
INSERT INTO `users_notifications` VALUES ('1127', '10', '1821', '2', '184', '1', '2013-04-25 15:41:07');
INSERT INTO `users_notifications` VALUES ('1128', '10', '1822', '2', '184', '1', '2013-04-25 15:41:10');
INSERT INTO `users_notifications` VALUES ('1129', '10', '1823', '2', '184', '1', '2013-04-25 15:41:13');
INSERT INTO `users_notifications` VALUES ('1130', '10', '1824', '2', '184', '1', '2013-04-25 15:41:35');
INSERT INTO `users_notifications` VALUES ('1131', '10', '1825', '2', '184', '1', '2013-04-25 15:41:39');
INSERT INTO `users_notifications` VALUES ('1132', '10', '1826', '2', '184', '1', '2013-04-25 15:41:41');
INSERT INTO `users_notifications` VALUES ('1133', '10', '1827', '2', '184', '1', '2013-04-25 15:45:48');
INSERT INTO `users_notifications` VALUES ('1134', '10', '1828', '2', '184', '1', '2013-04-25 15:45:51');
INSERT INTO `users_notifications` VALUES ('1135', '10', '1829', '2', '184', '1', '2013-04-25 15:45:54');
INSERT INTO `users_notifications` VALUES ('1136', '10', '1830', '184', '2', '1', '2013-04-25 16:02:43');
INSERT INTO `users_notifications` VALUES ('1137', '10', '1834', '2', '184', '1', '2013-04-25 16:08:49');
INSERT INTO `users_notifications` VALUES ('1138', '10', '1841', '2', '184', '1', '2013-04-25 16:11:04');
INSERT INTO `users_notifications` VALUES ('1139', '10', '1842', '2', '184', '1', '2013-04-25 16:11:07');
INSERT INTO `users_notifications` VALUES ('1140', '10', '1843', '2', '184', '1', '2013-04-25 16:11:10');
INSERT INTO `users_notifications` VALUES ('1141', '9', '1880', '2', '2', '1', '2013-04-26 10:02:51');
INSERT INTO `users_notifications` VALUES ('1142', '9', '1879', '2', '2', '1', '2013-04-26 10:03:37');
INSERT INTO `users_notifications` VALUES ('1143', '9', '1878', '2', '2', '1', '2013-04-26 10:04:01');
INSERT INTO `users_notifications` VALUES ('1144', '9', '1877', '2', '2', '1', '2013-04-26 10:04:22');
INSERT INTO `users_notifications` VALUES ('1145', '9', '1876', '2', '2', '1', '2013-04-26 10:05:10');
INSERT INTO `users_notifications` VALUES ('1146', '9', '1875', '2', '2', '1', '2013-04-26 10:05:34');
INSERT INTO `users_notifications` VALUES ('1147', '9', '1874', '2', '2', '1', '2013-04-26 10:06:02');
INSERT INTO `users_notifications` VALUES ('1148', '9', '1873', '2', '2', '1', '2013-04-26 10:06:21');
INSERT INTO `users_notifications` VALUES ('1149', '9', '1872', '2', '2', '1', '2013-04-26 10:06:41');
INSERT INTO `users_notifications` VALUES ('1150', '9', '1871', '2', '2', '1', '2013-04-26 10:06:57');
INSERT INTO `users_notifications` VALUES ('1151', '5', '2', '184', '2', '1', '2013-04-26 10:29:43');
INSERT INTO `users_notifications` VALUES ('1152', '8', '1880', '184', '2', '1', '2013-04-26 10:29:48');
INSERT INTO `users_notifications` VALUES ('1153', '8', '1879', '184', '2', '1', '2013-04-26 10:41:59');
INSERT INTO `users_notifications` VALUES ('1154', '8', '1876', '184', '2', '1', '2013-04-26 10:42:18');
INSERT INTO `users_notifications` VALUES ('1155', '8', '1875', '184', '2', '1', '2013-04-26 10:42:53');
INSERT INTO `users_notifications` VALUES ('1156', '5', '196', '101', '196', '0', '2013-04-26 14:07:08');
INSERT INTO `users_notifications` VALUES ('1157', '11', '197', '101', '197', '0', '2013-04-26 14:10:25');
INSERT INTO `users_notifications` VALUES ('1158', '2', '1884', '101', '184', '1', '2013-04-26 14:12:29');
INSERT INTO `users_notifications` VALUES ('1159', '4', '1885', '2', '184', '1', '2013-04-29 16:54:01');
INSERT INTO `users_notifications` VALUES ('1160', '11', '184', '7', '184', '1', '2013-04-29 16:56:30');
INSERT INTO `users_notifications` VALUES ('1161', '4', '1885', '7', '2', '1', '2013-04-29 16:56:42');
INSERT INTO `users_notifications` VALUES ('1162', '4', '1885', '7', '184', '1', '2013-04-29 16:56:42');
INSERT INTO `users_notifications` VALUES ('1163', '4', '1885', '101', '2', '1', '2013-04-29 16:57:28');
INSERT INTO `users_notifications` VALUES ('1164', '4', '1885', '101', '7', '1', '2013-04-29 16:57:28');
INSERT INTO `users_notifications` VALUES ('1165', '4', '1885', '101', '184', '1', '2013-04-29 16:57:28');
INSERT INTO `users_notifications` VALUES ('1166', '1', '1893', '7', '101', '1', '2013-05-03 09:30:47');
INSERT INTO `users_notifications` VALUES ('1167', '1', '1894', '7', '101', '1', '2013-05-03 09:31:06');
INSERT INTO `users_notifications` VALUES ('1168', '1', '1895', '7', '101', '1', '2013-05-03 09:31:22');
INSERT INTO `users_notifications` VALUES ('1169', '1', '1896', '7', '101', '1', '2013-05-03 09:31:39');
INSERT INTO `users_notifications` VALUES ('1170', '1', '1897', '7', '101', '1', '2013-05-03 09:31:55');
INSERT INTO `users_notifications` VALUES ('1171', '1', '1898', '7', '101', '1', '2013-05-03 09:32:15');
INSERT INTO `users_notifications` VALUES ('1174', '13', '26', '2', '184', '1', '2013-05-03 11:50:44');
INSERT INTO `users_notifications` VALUES ('1175', '4', '1904', '184', '0', '1', '2013-05-07 16:32:28');
INSERT INTO `users_notifications` VALUES ('1176', '12', '26', '184', '2', '1', '2013-06-11 14:41:58');
INSERT INTO `users_notifications` VALUES ('1177', '11', '162', '101', '162', '0', '2013-06-26 10:37:57');
INSERT INTO `users_notifications` VALUES ('1178', '11', '198', '101', '198', '0', '2013-06-26 10:44:45');
INSERT INTO `users_notifications` VALUES ('1179', '11', '171', '101', '171', '0', '2013-06-26 10:44:52');
INSERT INTO `users_notifications` VALUES ('1180', '11', '170', '101', '170', '0', '2013-06-26 10:44:57');
INSERT INTO `users_notifications` VALUES ('1181', '11', '179', '101', '179', '0', '2013-06-26 10:51:01');
INSERT INTO `users_notifications` VALUES ('1182', '11', '168', '101', '168', '0', '2013-06-26 10:51:06');
INSERT INTO `users_notifications` VALUES ('1183', '11', '119', '101', '119', '0', '2013-06-26 11:29:19');
INSERT INTO `users_notifications` VALUES ('1184', '2', '1915', '7', '101', '1', '2013-06-26 14:16:42');
INSERT INTO `users_notifications` VALUES ('1185', '8', '1915', '7', '101', '1', '2013-06-26 14:50:56');
INSERT INTO `users_notifications` VALUES ('1186', '4', '1915', '7', '101', '1', '2013-06-26 14:51:08');
INSERT INTO `users_notifications` VALUES ('1187', '11', '85', '101', '85', '0', '2013-06-26 14:51:46');
INSERT INTO `users_notifications` VALUES ('1188', '2', '1917', '101', '103', '1', '2013-06-26 15:27:22');
INSERT INTO `users_notifications` VALUES ('1189', '2', '1918', '7', '103', '1', '2013-06-26 15:29:08');
INSERT INTO `users_notifications` VALUES ('1190', '11', '176', '103', '176', '0', '2013-06-27 08:00:54');
INSERT INTO `users_notifications` VALUES ('1191', '11', '169', '103', '169', '0', '2013-06-27 08:00:58');
INSERT INTO `users_notifications` VALUES ('1735', '5', '101', '7', '101', '2', '2014-06-02 12:06:26');
INSERT INTO `users_notifications` VALUES ('1193', '11', '167', '7', '167', '0', '2013-06-27 08:01:12');
INSERT INTO `users_notifications` VALUES ('1194', '11', '123', '101', '123', '0', '2013-06-27 08:01:25');
INSERT INTO `users_notifications` VALUES ('1195', '11', '157', '101', '157', '0', '2013-06-27 08:01:26');
INSERT INTO `users_notifications` VALUES ('1733', '5', '101', '120', '101', '2', '2014-06-02 12:05:23');
INSERT INTO `users_notifications` VALUES ('1197', '11', '183', '103', '183', '1', '2013-06-27 08:16:42');
INSERT INTO `users_notifications` VALUES ('1198', '11', '85', '7', '85', '0', '2013-06-27 08:16:43');
INSERT INTO `users_notifications` VALUES ('1199', '11', '121', '7', '121', '0', '2013-06-27 08:16:58');
INSERT INTO `users_notifications` VALUES ('1200', '11', '170', '7', '170', '0', '2013-06-27 08:17:09');
INSERT INTO `users_notifications` VALUES ('1201', '11', '176', '7', '176', '0', '2013-06-27 08:17:23');
INSERT INTO `users_notifications` VALUES ('1202', '5', '125', '103', '125', '0', '2013-06-27 08:23:11');
INSERT INTO `users_notifications` VALUES ('1203', '11', '127', '7', '127', '0', '2013-06-27 08:23:26');
INSERT INTO `users_notifications` VALUES ('1204', '11', '171', '7', '171', '0', '2013-06-27 09:31:49');
INSERT INTO `users_notifications` VALUES ('1205', '11', '165', '103', '165', '0', '2013-06-27 09:31:49');
INSERT INTO `users_notifications` VALUES ('1206', '2', '1917', '7', '103', '1', '2013-06-27 09:32:18');
INSERT INTO `users_notifications` VALUES ('1207', '2', '1914', '103', '101', '1', '2013-06-27 09:32:26');
INSERT INTO `users_notifications` VALUES ('1208', '11', '127', '103', '127', '0', '2013-06-27 09:45:01');
INSERT INTO `users_notifications` VALUES ('1209', '11', '165', '7', '165', '0', '2013-06-27 09:45:04');
INSERT INTO `users_notifications` VALUES ('1210', '11', '196', '103', '196', '0', '2013-06-27 09:45:19');
INSERT INTO `users_notifications` VALUES ('1211', '11', '160', '103', '160', '0', '2013-06-27 10:07:16');
INSERT INTO `users_notifications` VALUES ('1212', '11', '159', '7', '159', '0', '2013-06-27 10:07:23');
INSERT INTO `users_notifications` VALUES ('1213', '11', '201', '103', '201', '0', '2013-06-27 10:07:53');
INSERT INTO `users_notifications` VALUES ('1214', '11', '119', '7', '119', '0', '2013-06-27 10:08:25');
INSERT INTO `users_notifications` VALUES ('1215', '11', '173', '103', '173', '0', '2013-06-27 10:08:46');
INSERT INTO `users_notifications` VALUES ('1216', '11', '179', '103', '179', '0', '2013-06-27 10:08:47');
INSERT INTO `users_notifications` VALUES ('1217', '2', '1919', '101', '103', '1', '2013-06-27 10:11:27');
INSERT INTO `users_notifications` VALUES ('1218', '2', '1920', '103', '101', '1', '2013-06-27 10:11:45');
INSERT INTO `users_notifications` VALUES ('1219', '5', '131', '7', '131', '0', '2013-06-27 10:12:47');
INSERT INTO `users_notifications` VALUES ('1220', '11', '85', '103', '85', '0', '2013-06-27 10:13:03');
INSERT INTO `users_notifications` VALUES ('1221', '2', '1920', '7', '101', '1', '2013-06-27 10:13:30');
INSERT INTO `users_notifications` VALUES ('1222', '11', '163', '7', '163', '0', '2013-06-27 10:13:39');
INSERT INTO `users_notifications` VALUES ('1223', '11', '127', '101', '127', '0', '2013-06-28 11:56:31');
INSERT INTO `users_notifications` VALUES ('1224', '11', '131', '103', '131', '0', '2013-07-01 10:22:31');
INSERT INTO `users_notifications` VALUES ('1225', '11', '195', '101', '195', '0', '2013-07-10 10:16:01');
INSERT INTO `users_notifications` VALUES ('1226', '11', '178', '101', '178', '0', '2013-07-16 16:47:56');
INSERT INTO `users_notifications` VALUES ('1227', '11', '176', '101', '176', '0', '2013-07-16 16:48:05');
INSERT INTO `users_notifications` VALUES ('1230', '11', '181', '101', '181', '0', '2013-07-18 16:04:40');
INSERT INTO `users_notifications` VALUES ('1231', '11', '183', '101', '183', '1', '2013-07-18 16:08:29');
INSERT INTO `users_notifications` VALUES ('1232', '11', '180', '101', '180', '0', '2013-07-18 16:11:17');
INSERT INTO `users_notifications` VALUES ('1233', '11', '161', '101', '161', '0', '2013-07-18 16:11:18');
INSERT INTO `users_notifications` VALUES ('1236', '11', '0', '101', '0', '1', '2013-08-09 14:07:49');
INSERT INTO `users_notifications` VALUES ('1239', '10', '1974', '103', '101', '1', '2013-08-13 16:37:39');
INSERT INTO `users_notifications` VALUES ('1240', '10', '1974', '103', '7', '1', '2013-08-13 16:37:39');
INSERT INTO `users_notifications` VALUES ('1241', '11', '122', '101', '122', '0', '2013-08-14 09:30:40');
INSERT INTO `users_notifications` VALUES ('1242', '10', '1975', '7', '101', '1', '2013-08-15 14:33:42');
INSERT INTO `users_notifications` VALUES ('1243', '10', '1976', '7', '101', '1', '2013-08-15 14:35:36');
INSERT INTO `users_notifications` VALUES ('1244', '11', '170', '204', '170', '0', '2013-08-20 10:07:47');
INSERT INTO `users_notifications` VALUES ('1245', '11', '131', '204', '131', '0', '2013-08-20 10:07:50');
INSERT INTO `users_notifications` VALUES ('1246', '11', '199', '204', '199', '0', '2013-08-20 10:07:53');
INSERT INTO `users_notifications` VALUES ('1247', '11', '169', '204', '169', '0', '2013-08-20 10:08:20');
INSERT INTO `users_notifications` VALUES ('1248', '11', '7', '204', '7', '1', '2013-08-20 10:08:38');
INSERT INTO `users_notifications` VALUES ('1249', '11', '173', '101', '173', '0', '2013-08-20 10:09:42');
INSERT INTO `users_notifications` VALUES ('1250', '11', '204', '101', '204', '1', '2013-08-20 10:11:18');
INSERT INTO `users_notifications` VALUES ('1251', '11', '127', '204', '127', '0', '2013-08-20 11:49:54');
INSERT INTO `users_notifications` VALUES ('1252', '11', '202', '101', '202', '0', '2013-08-20 15:15:20');
INSERT INTO `users_notifications` VALUES ('1253', '11', '159', '101', '159', '0', '2013-08-20 15:15:26');
INSERT INTO `users_notifications` VALUES ('1254', '11', '200', '101', '200', '0', '2013-08-20 15:15:28');
INSERT INTO `users_notifications` VALUES ('1255', '11', '121', '101', '121', '0', '2013-08-20 15:15:31');
INSERT INTO `users_notifications` VALUES ('1256', '11', '166', '101', '166', '0', '2013-08-20 15:15:34');
INSERT INTO `users_notifications` VALUES ('1257', '11', '172', '101', '172', '0', '2013-08-21 10:23:55');
INSERT INTO `users_notifications` VALUES ('1258', '11', '203', '101', '203', '0', '2013-08-21 10:43:44');
INSERT INTO `users_notifications` VALUES ('1259', '11', '199', '101', '199', '0', '2013-08-21 10:49:52');
INSERT INTO `users_notifications` VALUES ('1260', '11', '167', '101', '167', '0', '2013-08-22 10:05:31');
INSERT INTO `users_notifications` VALUES ('1261', '11', '160', '101', '160', '0', '2013-08-22 10:07:12');
INSERT INTO `users_notifications` VALUES ('1262', '5', '125', '101', '125', '0', '2013-08-22 10:09:20');
INSERT INTO `users_notifications` VALUES ('1263', '11', '169', '101', '169', '0', '2013-08-22 10:25:23');
INSERT INTO `users_notifications` VALUES ('1264', '11', '126', '101', '126', '0', '2013-08-22 10:35:45');
INSERT INTO `users_notifications` VALUES ('1265', '11', '163', '101', '163', '0', '2013-08-22 10:35:50');
INSERT INTO `users_notifications` VALUES ('1266', '11', '201', '101', '201', '0', '2013-08-22 10:35:55');
INSERT INTO `users_notifications` VALUES ('1267', '11', '165', '101', '165', '0', '2013-08-23 13:58:53');
INSERT INTO `users_notifications` VALUES ('1268', '11', '177', '101', '177', '0', '2013-08-23 15:06:59');
INSERT INTO `users_notifications` VALUES ('1269', '11', '174', '101', '174', '0', '2013-08-23 15:09:34');
INSERT INTO `users_notifications` VALUES ('1270', '11', '164', '101', '164', '0', '2013-08-23 15:09:43');
INSERT INTO `users_notifications` VALUES ('1271', '11', '158', '101', '158', '0', '2013-08-23 15:17:34');
INSERT INTO `users_notifications` VALUES ('1272', '11', '175', '101', '175', '0', '2013-08-23 15:22:23');
INSERT INTO `users_notifications` VALUES ('1273', '11', '162', '103', '162', '0', '2013-08-23 15:33:56');
INSERT INTO `users_notifications` VALUES ('1274', '11', '181', '103', '181', '0', '2013-08-23 15:38:38');
INSERT INTO `users_notifications` VALUES ('1275', '11', '175', '103', '175', '0', '2013-08-23 15:42:08');
INSERT INTO `users_notifications` VALUES ('1276', '11', '203', '103', '203', '0', '2013-08-23 15:45:05');
INSERT INTO `users_notifications` VALUES ('1277', '11', '158', '103', '158', '0', '2013-08-23 15:45:18');
INSERT INTO `users_notifications` VALUES ('1278', '11', '168', '103', '168', '0', '2013-08-23 15:46:18');
INSERT INTO `users_notifications` VALUES ('1279', '11', '174', '103', '174', '0', '2013-08-23 15:46:23');
INSERT INTO `users_notifications` VALUES ('1280', '11', '180', '103', '180', '0', '2013-08-23 15:57:14');
INSERT INTO `users_notifications` VALUES ('1281', '11', '178', '103', '178', '0', '2013-08-23 15:58:50');
INSERT INTO `users_notifications` VALUES ('1282', '11', '126', '103', '126', '0', '2013-08-23 16:00:25');
INSERT INTO `users_notifications` VALUES ('1283', '11', '119', '103', '119', '0', '2013-08-23 16:00:34');
INSERT INTO `users_notifications` VALUES ('1284', '11', '118', '103', '118', '0', '2013-08-26 15:44:26');
INSERT INTO `users_notifications` VALUES ('1285', '11', '167', '103', '167', '0', '2013-09-03 07:54:56');
INSERT INTO `users_notifications` VALUES ('1286', '11', '164', '103', '164', '0', '2013-09-03 07:56:56');
INSERT INTO `users_notifications` VALUES ('1287', '11', '202', '103', '202', '0', '2013-09-03 07:59:18');
INSERT INTO `users_notifications` VALUES ('1288', '5', '157', '103', '157', '0', '2013-09-03 08:01:58');
INSERT INTO `users_notifications` VALUES ('1289', '11', '197', '103', '197', '0', '2013-09-03 08:02:31');
INSERT INTO `users_notifications` VALUES ('1290', '11', '198', '103', '198', '0', '2013-09-03 08:02:49');
INSERT INTO `users_notifications` VALUES ('1291', '11', '171', '103', '171', '0', '2013-09-03 08:04:08');
INSERT INTO `users_notifications` VALUES ('1292', '11', '170', '103', '170', '0', '2013-09-03 08:04:18');
INSERT INTO `users_notifications` VALUES ('1293', '11', '161', '103', '161', '0', '2013-09-03 08:04:29');
INSERT INTO `users_notifications` VALUES ('1294', '11', '204', '103', '204', '0', '2013-09-03 09:34:04');
INSERT INTO `users_notifications` VALUES ('1295', '11', '195', '103', '195', '0', '2013-09-08 10:52:18');
INSERT INTO `users_notifications` VALUES ('1296', '11', '200', '103', '200', '0', '2013-09-08 10:53:03');
INSERT INTO `users_notifications` VALUES ('1297', '11', '199', '103', '199', '0', '2013-09-08 10:53:25');
INSERT INTO `users_notifications` VALUES ('1298', '11', '177', '103', '177', '0', '2013-09-08 10:53:38');
INSERT INTO `users_notifications` VALUES ('1299', '11', '163', '103', '163', '0', '2013-09-08 10:53:48');
INSERT INTO `users_notifications` VALUES ('1300', '11', '172', '103', '172', '0', '2013-09-08 10:54:03');
INSERT INTO `users_notifications` VALUES ('1301', '11', '184', '103', '184', '0', '2013-09-08 10:54:19');
INSERT INTO `users_notifications` VALUES ('1302', '11', '123', '103', '123', '0', '2013-09-08 10:54:30');
INSERT INTO `users_notifications` VALUES ('1303', '11', '159', '103', '159', '0', '2013-09-08 10:55:46');
INSERT INTO `users_notifications` VALUES ('1304', '11', '118', '103', '118', '0', '2013-09-08 11:35:22');
INSERT INTO `users_notifications` VALUES ('1305', '11', '84', '103', '84', '0', '2013-09-09 08:20:22');
INSERT INTO `users_notifications` VALUES ('1306', '11', '166', '103', '166', '0', '2013-09-09 08:23:05');
INSERT INTO `users_notifications` VALUES ('1307', '11', '173', '103', '173', '0', '2013-09-09 08:25:14');
INSERT INTO `users_notifications` VALUES ('1308', '11', '199', '103', '199', '0', '2013-09-09 08:28:15');
INSERT INTO `users_notifications` VALUES ('1309', '11', '203', '103', '203', '0', '2013-09-09 08:33:01');
INSERT INTO `users_notifications` VALUES ('1310', '11', '121', '103', '121', '0', '2013-09-09 08:37:45');
INSERT INTO `users_notifications` VALUES ('1311', '11', '200', '103', '200', '0', '2013-09-09 08:43:45');
INSERT INTO `users_notifications` VALUES ('1312', '11', '184', '103', '184', '0', '2013-09-09 08:48:40');
INSERT INTO `users_notifications` VALUES ('1313', '11', '177', '103', '177', '0', '2013-09-09 08:52:10');
INSERT INTO `users_notifications` VALUES ('1314', '11', '158', '103', '158', '0', '2013-09-09 08:52:49');
INSERT INTO `users_notifications` VALUES ('1315', '11', '183', '103', '183', '1', '2013-09-09 09:02:37');
INSERT INTO `users_notifications` VALUES ('1316', '11', '201', '103', '201', '0', '2013-09-09 09:04:01');
INSERT INTO `users_notifications` VALUES ('1317', '11', '162', '103', '162', '0', '2013-09-09 09:05:08');
INSERT INTO `users_notifications` VALUES ('1318', '11', '123', '103', '123', '0', '2013-09-09 09:05:46');
INSERT INTO `users_notifications` VALUES ('1319', '11', '161', '103', '161', '0', '2013-09-09 09:10:36');
INSERT INTO `users_notifications` VALUES ('1320', '11', '176', '103', '176', '0', '2013-09-09 09:11:55');
INSERT INTO `users_notifications` VALUES ('1321', '11', '174', '103', '174', '0', '2013-09-09 09:17:36');
INSERT INTO `users_notifications` VALUES ('1322', '11', '196', '103', '196', '0', '2013-09-09 09:20:55');
INSERT INTO `users_notifications` VALUES ('1323', '11', '178', '103', '178', '0', '2013-09-09 09:41:45');
INSERT INTO `users_notifications` VALUES ('1324', '11', '168', '103', '168', '0', '2013-09-09 09:44:33');
INSERT INTO `users_notifications` VALUES ('1325', '11', '204', '103', '204', '0', '2013-09-09 09:45:09');
INSERT INTO `users_notifications` VALUES ('1326', '11', '119', '103', '119', '0', '2013-09-09 09:48:44');
INSERT INTO `users_notifications` VALUES ('1327', '11', '7', '103', '7', '1', '2013-09-09 09:49:41');
INSERT INTO `users_notifications` VALUES ('1328', '11', '181', '103', '181', '0', '2013-09-09 09:51:03');
INSERT INTO `users_notifications` VALUES ('1329', '11', '2', '103', '2', '1', '2013-09-09 09:58:29');
INSERT INTO `users_notifications` VALUES ('1330', '11', '160', '103', '160', '0', '2013-09-09 09:59:19');
INSERT INTO `users_notifications` VALUES ('1331', '11', '165', '103', '165', '0', '2013-09-09 10:01:49');
INSERT INTO `users_notifications` VALUES ('1332', '11', '85', '103', '85', '0', '2013-09-09 10:04:54');
INSERT INTO `users_notifications` VALUES ('1333', '11', '198', '103', '198', '0', '2013-09-09 10:07:52');
INSERT INTO `users_notifications` VALUES ('1334', '11', '127', '103', '127', '0', '2013-09-09 10:11:28');
INSERT INTO `users_notifications` VALUES ('1335', '11', '201', '103', '201', '0', '2013-09-09 10:12:07');
INSERT INTO `users_notifications` VALUES ('1336', '11', '161', '103', '161', '0', '2013-09-09 10:13:11');
INSERT INTO `users_notifications` VALUES ('1337', '11', '157', '103', '157', '0', '2013-09-09 10:14:14');
INSERT INTO `users_notifications` VALUES ('1338', '11', '183', '103', '183', '1', '2013-09-09 10:15:47');
INSERT INTO `users_notifications` VALUES ('1339', '11', '173', '103', '173', '0', '2013-09-09 10:17:01');
INSERT INTO `users_notifications` VALUES ('1340', '11', '131', '103', '131', '0', '2013-09-09 10:17:40');
INSERT INTO `users_notifications` VALUES ('1341', '11', '158', '103', '158', '0', '2013-09-09 10:22:21');
INSERT INTO `users_notifications` VALUES ('1342', '11', '120', '103', '120', '2', '2013-09-09 10:22:27');
INSERT INTO `users_notifications` VALUES ('1343', '11', '126', '103', '126', '0', '2013-09-09 10:22:37');
INSERT INTO `users_notifications` VALUES ('1344', '11', '2', '103', '2', '1', '2013-09-09 10:27:19');
INSERT INTO `users_notifications` VALUES ('1345', '11', '171', '103', '171', '0', '2013-09-09 10:27:56');
INSERT INTO `users_notifications` VALUES ('1346', '11', '118', '103', '118', '0', '2013-09-09 10:28:55');
INSERT INTO `users_notifications` VALUES ('1347', '11', '166', '103', '166', '0', '2013-09-09 10:29:52');
INSERT INTO `users_notifications` VALUES ('1348', '11', '125', '103', '125', '0', '2013-09-09 10:30:18');
INSERT INTO `users_notifications` VALUES ('1349', '11', '200', '103', '200', '0', '2013-09-09 10:30:26');
INSERT INTO `users_notifications` VALUES ('1350', '11', '160', '103', '160', '0', '2013-09-09 10:30:58');
INSERT INTO `users_notifications` VALUES ('1351', '11', '101', '103', '101', '2', '2013-09-09 10:31:50');
INSERT INTO `users_notifications` VALUES ('1352', '11', '204', '103', '204', '0', '2013-09-09 10:32:00');
INSERT INTO `users_notifications` VALUES ('1353', '11', '124', '103', '124', '2', '2013-09-09 10:34:03');
INSERT INTO `users_notifications` VALUES ('1354', '11', '175', '103', '175', '0', '2013-09-09 10:34:12');
INSERT INTO `users_notifications` VALUES ('1355', '11', '195', '103', '195', '0', '2013-09-09 10:34:37');
INSERT INTO `users_notifications` VALUES ('1356', '11', '83', '103', '83', '0', '2013-09-09 10:41:54');
INSERT INTO `users_notifications` VALUES ('1357', '11', '84', '103', '84', '0', '2013-09-09 10:44:27');
INSERT INTO `users_notifications` VALUES ('1358', '11', '119', '103', '119', '0', '2013-09-09 10:45:32');
INSERT INTO `users_notifications` VALUES ('1359', '11', '176', '103', '176', '0', '2013-09-09 10:50:14');
INSERT INTO `users_notifications` VALUES ('1360', '11', '196', '103', '196', '0', '2013-09-09 10:53:34');
INSERT INTO `users_notifications` VALUES ('1361', '11', '162', '103', '162', '0', '2013-09-09 10:54:57');
INSERT INTO `users_notifications` VALUES ('1362', '11', '174', '103', '174', '0', '2013-09-09 10:56:09');
INSERT INTO `users_notifications` VALUES ('1363', '11', '122', '103', '122', '0', '2013-09-09 10:58:18');
INSERT INTO `users_notifications` VALUES ('1364', '11', '180', '103', '180', '0', '2013-09-09 10:59:21');
INSERT INTO `users_notifications` VALUES ('1365', '11', '164', '103', '164', '0', '2013-09-09 11:00:41');
INSERT INTO `users_notifications` VALUES ('1366', '11', '167', '103', '167', '0', '2013-09-09 11:07:11');
INSERT INTO `users_notifications` VALUES ('1367', '11', '199', '103', '199', '0', '2013-09-09 11:08:19');
INSERT INTO `users_notifications` VALUES ('1368', '11', '172', '103', '172', '0', '2013-09-09 11:12:41');
INSERT INTO `users_notifications` VALUES ('1369', '11', '168', '103', '168', '0', '2013-09-09 11:13:29');
INSERT INTO `users_notifications` VALUES ('1370', '11', '169', '103', '169', '0', '2013-09-09 11:16:18');
INSERT INTO `users_notifications` VALUES ('1371', '11', '163', '103', '163', '0', '2013-09-09 11:17:09');
INSERT INTO `users_notifications` VALUES ('1372', '11', '165', '103', '165', '0', '2013-09-09 11:20:21');
INSERT INTO `users_notifications` VALUES ('1373', '11', '85', '103', '85', '0', '2013-09-09 11:31:13');
INSERT INTO `users_notifications` VALUES ('1374', '11', '7', '103', '7', '1', '2013-09-09 11:32:37');
INSERT INTO `users_notifications` VALUES ('1375', '11', '170', '103', '170', '0', '2013-09-09 11:33:50');
INSERT INTO `users_notifications` VALUES ('1376', '11', '121', '103', '121', '0', '2013-09-09 11:35:10');
INSERT INTO `users_notifications` VALUES ('1377', '11', '184', '103', '184', '0', '2013-09-09 11:37:16');
INSERT INTO `users_notifications` VALUES ('1378', '11', '177', '103', '177', '0', '2013-09-09 11:38:53');
INSERT INTO `users_notifications` VALUES ('1379', '11', '159', '103', '159', '0', '2013-09-09 11:42:46');
INSERT INTO `users_notifications` VALUES ('1380', '11', '205', '103', '205', '0', '2013-09-09 11:46:52');
INSERT INTO `users_notifications` VALUES ('1381', '11', '197', '103', '197', '0', '2013-09-09 11:53:35');
INSERT INTO `users_notifications` VALUES ('1382', '11', '178', '103', '178', '0', '2013-09-09 11:54:23');
INSERT INTO `users_notifications` VALUES ('1383', '11', '179', '103', '179', '0', '2013-09-09 11:58:22');
INSERT INTO `users_notifications` VALUES ('1384', '11', '123', '103', '123', '0', '2013-09-09 12:01:21');
INSERT INTO `users_notifications` VALUES ('1385', '11', '181', '103', '181', '0', '2013-09-09 12:02:16');
INSERT INTO `users_notifications` VALUES ('1386', '11', '203', '103', '203', '0', '2013-09-09 12:02:41');
INSERT INTO `users_notifications` VALUES ('1387', '11', '202', '103', '202', '0', '2013-09-09 12:03:44');
INSERT INTO `users_notifications` VALUES ('1388', '11', '164', '103', '164', '0', '2013-09-09 12:07:43');
INSERT INTO `users_notifications` VALUES ('1389', '11', '131', '103', '131', '0', '2013-09-09 12:09:07');
INSERT INTO `users_notifications` VALUES ('1390', '11', '7', '103', '7', '1', '2013-09-09 12:10:31');
INSERT INTO `users_notifications` VALUES ('1391', '11', '174', '103', '174', '0', '2013-09-09 12:11:32');
INSERT INTO `users_notifications` VALUES ('1392', '11', '202', '103', '202', '0', '2013-09-09 12:12:40');
INSERT INTO `users_notifications` VALUES ('1393', '11', '84', '103', '84', '0', '2013-09-09 12:12:49');
INSERT INTO `users_notifications` VALUES ('1394', '11', '118', '103', '118', '0', '2013-09-09 12:12:55');
INSERT INTO `users_notifications` VALUES ('1395', '11', '167', '103', '167', '0', '2013-09-09 12:13:04');
INSERT INTO `users_notifications` VALUES ('1396', '11', '126', '103', '126', '0', '2013-09-09 12:13:10');
INSERT INTO `users_notifications` VALUES ('1397', '11', '175', '103', '175', '0', '2013-09-09 12:13:18');
INSERT INTO `users_notifications` VALUES ('1398', '11', '200', '103', '200', '0', '2013-09-09 12:13:26');
INSERT INTO `users_notifications` VALUES ('1399', '11', '173', '103', '173', '0', '2013-09-09 12:13:33');
INSERT INTO `users_notifications` VALUES ('1400', '11', '196', '103', '196', '0', '2013-09-09 12:15:30');
INSERT INTO `users_notifications` VALUES ('1401', '11', '173', '103', '173', '0', '2013-09-09 12:20:09');
INSERT INTO `users_notifications` VALUES ('1402', '11', '127', '103', '127', '0', '2013-09-09 12:20:17');
INSERT INTO `users_notifications` VALUES ('1403', '11', '201', '103', '201', '0', '2013-09-09 12:20:24');
INSERT INTO `users_notifications` VALUES ('1404', '11', '203', '103', '203', '0', '2013-09-09 12:20:30');
INSERT INTO `users_notifications` VALUES ('1405', '11', '122', '103', '122', '0', '2013-09-09 12:20:36');
INSERT INTO `users_notifications` VALUES ('1406', '11', '170', '103', '170', '0', '2013-09-09 12:20:43');
INSERT INTO `users_notifications` VALUES ('1407', '11', '131', '103', '131', '0', '2013-09-09 12:20:51');
INSERT INTO `users_notifications` VALUES ('1408', '11', '172', '103', '172', '0', '2013-09-09 12:20:56');
INSERT INTO `users_notifications` VALUES ('1409', '11', '202', '103', '202', '0', '2013-09-09 12:22:33');
INSERT INTO `users_notifications` VALUES ('1410', '11', '120', '103', '120', '2', '2013-09-09 12:22:40');
INSERT INTO `users_notifications` VALUES ('1411', '11', '101', '103', '101', '2', '2013-09-09 12:26:02');
INSERT INTO `users_notifications` VALUES ('1412', '11', '163', '103', '163', '0', '2013-09-09 12:30:37');
INSERT INTO `users_notifications` VALUES ('1413', '11', '121', '103', '121', '0', '2013-09-09 12:32:14');
INSERT INTO `users_notifications` VALUES ('1414', '11', '7', '103', '7', '1', '2013-09-09 12:45:31');
INSERT INTO `users_notifications` VALUES ('1415', '11', '164', '103', '164', '0', '2013-09-09 12:45:39');
INSERT INTO `users_notifications` VALUES ('1416', '11', '177', '103', '177', '0', '2013-09-09 12:45:44');
INSERT INTO `users_notifications` VALUES ('1417', '11', '195', '103', '195', '0', '2013-09-09 12:45:53');
INSERT INTO `users_notifications` VALUES ('1418', '11', '163', '103', '163', '0', '2013-09-09 12:46:00');
INSERT INTO `users_notifications` VALUES ('1419', '11', '126', '103', '126', '0', '2013-09-09 12:46:08');
INSERT INTO `users_notifications` VALUES ('1420', '11', '120', '103', '120', '2', '2013-09-09 12:46:14');
INSERT INTO `users_notifications` VALUES ('1421', '11', '83', '103', '83', '0', '2013-09-09 12:46:20');
INSERT INTO `users_notifications` VALUES ('1422', '11', '127', '103', '127', '0', '2013-09-09 12:46:27');
INSERT INTO `users_notifications` VALUES ('1423', '11', '197', '103', '197', '0', '2013-09-09 12:46:34');
INSERT INTO `users_notifications` VALUES ('1424', '11', '161', '103', '161', '0', '2013-09-09 12:46:41');
INSERT INTO `users_notifications` VALUES ('1425', '11', '167', '103', '167', '0', '2013-09-09 12:46:47');
INSERT INTO `users_notifications` VALUES ('1426', '11', '179', '103', '179', '0', '2013-09-09 12:46:54');
INSERT INTO `users_notifications` VALUES ('1427', '11', '174', '103', '174', '0', '2013-09-09 12:46:59');
INSERT INTO `users_notifications` VALUES ('1428', '11', '202', '103', '202', '0', '2013-09-09 12:47:06');
INSERT INTO `users_notifications` VALUES ('1429', '11', '166', '103', '166', '0', '2013-09-09 12:47:15');
INSERT INTO `users_notifications` VALUES ('1430', '11', '121', '103', '121', '0', '2013-09-09 12:47:21');
INSERT INTO `users_notifications` VALUES ('1431', '11', '118', '103', '118', '0', '2013-09-09 12:47:23');
INSERT INTO `users_notifications` VALUES ('1432', '11', '170', '103', '170', '0', '2013-09-09 12:47:31');
INSERT INTO `users_notifications` VALUES ('1433', '11', '119', '103', '119', '0', '2013-09-09 12:47:33');
INSERT INTO `users_notifications` VALUES ('1434', '11', '159', '103', '159', '0', '2013-09-09 12:47:37');
INSERT INTO `users_notifications` VALUES ('1435', '11', '158', '103', '158', '0', '2013-09-09 15:09:31');
INSERT INTO `users_notifications` VALUES ('1436', '11', '157', '103', '157', '0', '2013-09-09 15:09:33');
INSERT INTO `users_notifications` VALUES ('1437', '11', '101', '103', '101', '2', '2013-09-09 15:09:35');
INSERT INTO `users_notifications` VALUES ('1438', '11', '165', '103', '165', '0', '2013-09-09 15:09:47');
INSERT INTO `users_notifications` VALUES ('1439', '11', '200', '103', '200', '0', '2013-09-09 15:09:49');
INSERT INTO `users_notifications` VALUES ('1440', '11', '183', '103', '183', '1', '2013-09-09 15:09:57');
INSERT INTO `users_notifications` VALUES ('1441', '11', '199', '103', '199', '0', '2013-09-09 15:09:59');
INSERT INTO `users_notifications` VALUES ('1442', '11', '2', '103', '2', '1', '2013-09-09 15:10:01');
INSERT INTO `users_notifications` VALUES ('1443', '11', '131', '103', '131', '0', '2013-09-09 15:14:00');
INSERT INTO `users_notifications` VALUES ('1444', '11', '162', '103', '162', '0', '2013-09-09 15:14:04');
INSERT INTO `users_notifications` VALUES ('1445', '11', '125', '103', '125', '0', '2013-09-09 15:14:17');
INSERT INTO `users_notifications` VALUES ('1446', '11', '168', '103', '168', '0', '2013-09-09 15:14:21');
INSERT INTO `users_notifications` VALUES ('1447', '11', '124', '103', '124', '2', '2013-09-09 15:14:37');
INSERT INTO `users_notifications` VALUES ('1448', '11', '123', '103', '123', '0', '2013-09-09 15:14:39');
INSERT INTO `users_notifications` VALUES ('1449', '11', '203', '103', '203', '0', '2013-09-09 15:14:53');
INSERT INTO `users_notifications` VALUES ('1450', '11', '173', '103', '173', '0', '2013-09-09 15:14:55');
INSERT INTO `users_notifications` VALUES ('1451', '11', '84', '103', '84', '0', '2013-09-09 15:15:05');
INSERT INTO `users_notifications` VALUES ('1452', '11', '160', '103', '160', '0', '2013-09-09 15:15:07');
INSERT INTO `users_notifications` VALUES ('1453', '11', '201', '103', '201', '0', '2013-09-09 15:15:09');
INSERT INTO `users_notifications` VALUES ('1454', '11', '169', '103', '169', '0', '2013-09-09 15:15:36');
INSERT INTO `users_notifications` VALUES ('1455', '11', '176', '103', '176', '0', '2013-09-09 15:15:38');
INSERT INTO `users_notifications` VALUES ('1456', '11', '198', '103', '198', '0', '2013-09-09 15:15:48');
INSERT INTO `users_notifications` VALUES ('1457', '11', '181', '103', '181', '0', '2013-09-09 15:15:52');
INSERT INTO `users_notifications` VALUES ('1458', '11', '122', '103', '122', '0', '2013-09-09 15:16:06');
INSERT INTO `users_notifications` VALUES ('1459', '11', '205', '103', '205', '0', '2013-09-09 15:16:12');
INSERT INTO `users_notifications` VALUES ('1460', '11', '171', '103', '171', '0', '2013-09-09 15:16:16');
INSERT INTO `users_notifications` VALUES ('1461', '11', '184', '103', '184', '0', '2013-09-09 15:16:22');
INSERT INTO `users_notifications` VALUES ('1462', '11', '196', '103', '196', '0', '2013-09-09 15:16:24');
INSERT INTO `users_notifications` VALUES ('1463', '11', '85', '103', '85', '0', '2013-09-09 15:16:32');
INSERT INTO `users_notifications` VALUES ('1464', '11', '180', '103', '180', '0', '2013-09-09 15:16:34');
INSERT INTO `users_notifications` VALUES ('1465', '11', '204', '103', '204', '0', '2013-09-09 15:16:36');
INSERT INTO `users_notifications` VALUES ('1466', '11', '172', '103', '172', '0', '2013-09-09 15:24:56');
INSERT INTO `users_notifications` VALUES ('1467', '11', '175', '103', '175', '0', '2013-09-09 15:27:05');
INSERT INTO `users_notifications` VALUES ('1468', '11', '180', '103', '180', '0', '2013-09-09 15:28:43');
INSERT INTO `users_notifications` VALUES ('1469', '11', '178', '103', '178', '0', '2013-09-09 15:28:53');
INSERT INTO `users_notifications` VALUES ('1470', '11', '196', '103', '196', '0', '2013-09-09 15:28:55');
INSERT INTO `users_notifications` VALUES ('1471', '11', '172', '103', '172', '0', '2013-09-09 15:31:28');
INSERT INTO `users_notifications` VALUES ('1472', '11', '181', '103', '181', '0', '2013-09-09 15:33:15');
INSERT INTO `users_notifications` VALUES ('1473', '11', '175', '103', '175', '0', '2013-09-09 15:33:37');
INSERT INTO `users_notifications` VALUES ('1474', '11', '85', '103', '85', '0', '2013-09-09 15:37:27');
INSERT INTO `users_notifications` VALUES ('1475', '11', '171', '103', '171', '0', '2013-09-09 15:38:11');
INSERT INTO `users_notifications` VALUES ('1476', '11', '204', '103', '204', '0', '2013-09-09 15:38:30');
INSERT INTO `users_notifications` VALUES ('1477', '11', '176', '103', '176', '0', '2013-09-09 15:39:52');
INSERT INTO `users_notifications` VALUES ('1478', '11', '205', '103', '205', '0', '2013-09-09 15:40:57');
INSERT INTO `users_notifications` VALUES ('1479', '11', '122', '103', '122', '0', '2013-09-09 15:42:06');
INSERT INTO `users_notifications` VALUES ('1480', '11', '198', '103', '198', '0', '2013-09-09 15:50:01');
INSERT INTO `users_notifications` VALUES ('1481', '11', '184', '103', '184', '0', '2013-09-09 16:01:03');
INSERT INTO `users_notifications` VALUES ('1482', '11', '199', '103', '199', '0', '2013-09-09 16:02:04');
INSERT INTO `users_notifications` VALUES ('1483', '11', '131', '103', '131', '0', '2013-09-09 16:02:19');
INSERT INTO `users_notifications` VALUES ('1484', '11', '183', '103', '183', '1', '2013-09-09 16:02:26');
INSERT INTO `users_notifications` VALUES ('1485', '11', '200', '103', '200', '0', '2013-09-09 16:02:35');
INSERT INTO `users_notifications` VALUES ('1486', '11', '2', '103', '2', '1', '2013-09-09 16:02:46');
INSERT INTO `users_notifications` VALUES ('1487', '11', '125', '103', '125', '0', '2013-09-09 16:02:53');
INSERT INTO `users_notifications` VALUES ('1488', '11', '168', '103', '168', '0', '2013-09-09 16:03:15');
INSERT INTO `users_notifications` VALUES ('1489', '11', '123', '103', '123', '0', '2013-09-09 16:03:29');
INSERT INTO `users_notifications` VALUES ('1490', '11', '165', '103', '165', '0', '2013-09-09 16:05:01');
INSERT INTO `users_notifications` VALUES ('1491', '11', '203', '103', '203', '0', '2013-09-09 16:06:37');
INSERT INTO `users_notifications` VALUES ('1492', '11', '178', '103', '178', '0', '2013-09-09 16:07:34');
INSERT INTO `users_notifications` VALUES ('1493', '11', '176', '103', '176', '0', '2013-09-09 16:09:10');
INSERT INTO `users_notifications` VALUES ('1494', '11', '160', '103', '160', '0', '2013-09-09 16:14:19');
INSERT INTO `users_notifications` VALUES ('1495', '11', '162', '103', '162', '0', '2013-09-09 16:14:34');
INSERT INTO `users_notifications` VALUES ('1496', '11', '85', '103', '85', '0', '2013-09-09 16:17:22');
INSERT INTO `users_notifications` VALUES ('1497', '11', '84', '103', '84', '0', '2013-09-09 16:21:44');
INSERT INTO `users_notifications` VALUES ('1498', '11', '171', '103', '171', '0', '2013-09-09 16:22:31');
INSERT INTO `users_notifications` VALUES ('1499', '11', '200', '103', '200', '0', '2013-09-09 16:23:14');
INSERT INTO `users_notifications` VALUES ('1500', '11', '181', '103', '181', '0', '2013-09-09 16:24:11');
INSERT INTO `users_notifications` VALUES ('1501', '11', '175', '103', '175', '0', '2013-09-09 16:24:59');
INSERT INTO `users_notifications` VALUES ('1502', '11', '101', '103', '101', '2', '2013-09-09 16:25:11');
INSERT INTO `users_notifications` VALUES ('1503', '11', '165', '103', '165', '0', '2013-09-09 16:27:10');
INSERT INTO `users_notifications` VALUES ('1504', '11', '180', '103', '180', '0', '2013-09-09 16:27:20');
INSERT INTO `users_notifications` VALUES ('1505', '11', '173', '103', '173', '0', '2013-09-09 16:28:27');
INSERT INTO `users_notifications` VALUES ('1506', '11', '162', '103', '162', '0', '2013-09-09 16:29:13');
INSERT INTO `users_notifications` VALUES ('1507', '11', '183', '103', '183', '1', '2013-09-09 16:29:23');
INSERT INTO `users_notifications` VALUES ('1508', '11', '131', '103', '131', '0', '2013-09-09 16:29:54');
INSERT INTO `users_notifications` VALUES ('1509', '11', '125', '103', '125', '0', '2013-09-09 16:30:00');
INSERT INTO `users_notifications` VALUES ('1510', '11', '168', '103', '168', '0', '2013-09-09 16:30:07');
INSERT INTO `users_notifications` VALUES ('1511', '11', '84', '103', '84', '0', '2013-09-09 16:30:13');
INSERT INTO `users_notifications` VALUES ('1512', '11', '123', '103', '123', '0', '2013-09-09 16:30:28');
INSERT INTO `users_notifications` VALUES ('1513', '11', '199', '103', '199', '0', '2013-09-09 16:30:33');
INSERT INTO `users_notifications` VALUES ('1514', '11', '2', '103', '2', '1', '2013-09-09 16:30:39');
INSERT INTO `users_notifications` VALUES ('1515', '11', '204', '103', '204', '0', '2013-09-09 16:30:41');
INSERT INTO `users_notifications` VALUES ('1516', '11', '124', '103', '124', '2', '2013-09-09 16:30:51');
INSERT INTO `users_notifications` VALUES ('1517', '11', '160', '103', '160', '0', '2013-09-09 16:30:53');
INSERT INTO `users_notifications` VALUES ('1518', '11', '169', '103', '169', '0', '2013-09-09 16:31:05');
INSERT INTO `users_notifications` VALUES ('1519', '11', '85', '103', '85', '0', '2013-09-09 16:34:21');
INSERT INTO `users_notifications` VALUES ('1520', '11', '184', '103', '184', '0', '2013-09-09 16:35:16');
INSERT INTO `users_notifications` VALUES ('1521', '11', '171', '103', '171', '0', '2013-09-09 16:36:37');
INSERT INTO `users_notifications` VALUES ('1522', '11', '201', '103', '201', '0', '2013-09-09 16:38:02');
INSERT INTO `users_notifications` VALUES ('1523', '11', '203', '103', '203', '0', '2013-09-09 16:38:40');
INSERT INTO `users_notifications` VALUES ('1524', '11', '123', '103', '123', '0', '2013-09-09 16:39:04');
INSERT INTO `users_notifications` VALUES ('1525', '11', '2', '103', '2', '1', '2013-09-09 16:39:17');
INSERT INTO `users_notifications` VALUES ('1526', '11', '84', '103', '84', '0', '2013-09-09 16:40:51');
INSERT INTO `users_notifications` VALUES ('1527', '11', '184', '103', '184', '0', '2013-09-09 16:41:59');
INSERT INTO `users_notifications` VALUES ('1528', '11', '176', '103', '176', '0', '2013-09-09 16:42:47');
INSERT INTO `users_notifications` VALUES ('1529', '11', '169', '103', '169', '0', '2013-09-09 16:42:59');
INSERT INTO `users_notifications` VALUES ('1530', '11', '178', '103', '178', '0', '2013-09-09 16:43:09');
INSERT INTO `users_notifications` VALUES ('1531', '11', '171', '103', '171', '0', '2013-09-09 16:43:16');
INSERT INTO `users_notifications` VALUES ('1532', '11', '157', '184', '157', '0', '2013-09-09 16:53:12');
INSERT INTO `users_notifications` VALUES ('1533', '11', '118', '184', '118', '0', '2013-09-09 16:53:36');
INSERT INTO `users_notifications` VALUES ('1534', '11', '173', '184', '173', '0', '2013-09-09 16:54:06');
INSERT INTO `users_notifications` VALUES ('1535', '11', '167', '184', '167', '0', '2013-09-09 16:54:08');
INSERT INTO `users_notifications` VALUES ('1536', '11', '178', '184', '178', '0', '2013-09-09 16:54:10');
INSERT INTO `users_notifications` VALUES ('1537', '11', '158', '184', '158', '0', '2013-09-09 16:54:12');
INSERT INTO `users_notifications` VALUES ('1538', '11', '120', '184', '120', '2', '2013-09-09 16:54:16');
INSERT INTO `users_notifications` VALUES ('1539', '11', '195', '184', '195', '0', '2013-09-09 16:54:18');
INSERT INTO `users_notifications` VALUES ('1540', '11', '85', '184', '85', '0', '2013-09-09 16:54:39');
INSERT INTO `users_notifications` VALUES ('1541', '11', '201', '184', '201', '0', '2013-09-09 16:54:41');
INSERT INTO `users_notifications` VALUES ('1542', '11', '163', '184', '163', '0', '2013-09-09 16:54:43');
INSERT INTO `users_notifications` VALUES ('1642', '11', '174', '184', '174', '0', '2013-09-10 10:13:22');
INSERT INTO `users_notifications` VALUES ('1544', '11', '205', '184', '205', '0', '2013-09-09 16:54:49');
INSERT INTO `users_notifications` VALUES ('1545', '11', '168', '184', '168', '0', '2013-09-09 16:54:51');
INSERT INTO `users_notifications` VALUES ('1546', '11', '84', '184', '84', '0', '2013-09-09 16:55:31');
INSERT INTO `users_notifications` VALUES ('1547', '11', '169', '184', '169', '0', '2013-09-09 16:56:21');
INSERT INTO `users_notifications` VALUES ('1548', '11', '121', '184', '121', '0', '2013-09-09 16:57:55');
INSERT INTO `users_notifications` VALUES ('1549', '11', '166', '184', '166', '0', '2013-09-09 16:58:02');
INSERT INTO `users_notifications` VALUES ('1550', '11', '179', '184', '179', '0', '2013-09-09 16:58:12');
INSERT INTO `users_notifications` VALUES ('1551', '11', '83', '184', '83', '0', '2013-09-09 16:58:23');
INSERT INTO `users_notifications` VALUES ('1552', '5', '103', '184', '103', '2', '2013-09-09 16:58:25');
INSERT INTO `users_notifications` VALUES ('1553', '11', '161', '184', '161', '0', '2013-09-09 16:58:27');
INSERT INTO `users_notifications` VALUES ('1554', '11', '164', '184', '164', '0', '2013-09-09 16:58:38');
INSERT INTO `users_notifications` VALUES ('1646', '11', '183', '184', '183', '1', '2013-09-10 10:15:53');
INSERT INTO `users_notifications` VALUES ('1641', '11', '170', '184', '170', '0', '2013-09-10 10:13:12');
INSERT INTO `users_notifications` VALUES ('1557', '11', '204', '184', '204', '0', '2013-09-09 16:58:55');
INSERT INTO `users_notifications` VALUES ('1558', '11', '159', '184', '159', '0', '2013-09-09 16:58:57');
INSERT INTO `users_notifications` VALUES ('1639', '11', '131', '184', '131', '0', '2013-09-10 10:12:52');
INSERT INTO `users_notifications` VALUES ('1560', '11', '197', '184', '197', '0', '2013-09-09 16:59:03');
INSERT INTO `users_notifications` VALUES ('1561', '11', '181', '184', '181', '0', '2013-09-09 16:59:07');
INSERT INTO `users_notifications` VALUES ('1562', '11', '199', '184', '199', '0', '2013-09-09 16:59:26');
INSERT INTO `users_notifications` VALUES ('1563', '11', '101', '184', '101', '2', '2013-09-09 16:59:28');
INSERT INTO `users_notifications` VALUES ('1564', '11', '177', '184', '177', '0', '2013-09-09 16:59:30');
INSERT INTO `users_notifications` VALUES ('1565', '11', '200', '184', '200', '0', '2013-09-09 16:59:32');
INSERT INTO `users_notifications` VALUES ('1566', '11', '122', '184', '122', '0', '2013-09-09 16:59:47');
INSERT INTO `users_notifications` VALUES ('1567', '11', '123', '184', '123', '0', '2013-09-09 16:59:51');
INSERT INTO `users_notifications` VALUES ('1568', '11', '162', '184', '162', '0', '2013-09-09 16:59:55');
INSERT INTO `users_notifications` VALUES ('1569', '11', '171', '184', '171', '0', '2013-09-09 17:00:02');
INSERT INTO `users_notifications` VALUES ('1570', '11', '176', '184', '176', '0', '2013-09-09 17:00:04');
INSERT INTO `users_notifications` VALUES ('1571', '11', '203', '184', '203', '0', '2013-09-09 17:00:28');
INSERT INTO `users_notifications` VALUES ('1572', '11', '175', '184', '175', '0', '2013-09-09 17:00:30');
INSERT INTO `users_notifications` VALUES ('1587', '11', '2', '184', '2', '1', '2013-09-09 17:03:46');
INSERT INTO `users_notifications` VALUES ('1574', '11', '202', '184', '202', '0', '2013-09-09 17:00:41');
INSERT INTO `users_notifications` VALUES ('1575', '11', '165', '184', '165', '0', '2013-09-09 17:00:43');
INSERT INTO `users_notifications` VALUES ('1576', '11', '119', '184', '119', '0', '2013-09-09 17:00:45');
INSERT INTO `users_notifications` VALUES ('1577', '11', '127', '184', '127', '0', '2013-09-09 17:00:49');
INSERT INTO `users_notifications` VALUES ('1640', '11', '160', '184', '160', '0', '2013-09-10 10:13:02');
INSERT INTO `users_notifications` VALUES ('1579', '11', '196', '184', '196', '0', '2013-09-09 17:01:00');
INSERT INTO `users_notifications` VALUES ('1580', '11', '198', '184', '198', '0', '2013-09-09 17:01:11');
INSERT INTO `users_notifications` VALUES ('1581', '11', '7', '184', '7', '1', '2013-09-09 17:01:15');
INSERT INTO `users_notifications` VALUES ('1582', '11', '126', '184', '126', '0', '2013-09-09 17:01:17');
INSERT INTO `users_notifications` VALUES ('1643', '11', '101', '184', '101', '2', '2013-09-10 10:13:32');
INSERT INTO `users_notifications` VALUES ('1584', '11', '180', '184', '180', '0', '2013-09-09 17:01:26');
INSERT INTO `users_notifications` VALUES ('1585', '11', '124', '184', '124', '2', '2013-09-09 17:01:34');
INSERT INTO `users_notifications` VALUES ('1645', '11', '172', '184', '172', '0', '2013-09-10 10:14:45');
INSERT INTO `users_notifications` VALUES ('1589', '11', '199', '103', '199', '0', '2013-09-09 17:07:23');
INSERT INTO `users_notifications` VALUES ('1590', '11', '85', '103', '85', '0', '2013-09-09 17:09:09');
INSERT INTO `users_notifications` VALUES ('1591', '11', '205', '103', '205', '0', '2013-09-09 17:13:12');
INSERT INTO `users_notifications` VALUES ('1592', '11', '122', '103', '122', '0', '2013-09-09 17:13:14');
INSERT INTO `users_notifications` VALUES ('1593', '11', '172', '103', '172', '0', '2013-09-09 17:13:16');
INSERT INTO `users_notifications` VALUES ('1594', '11', '198', '103', '198', '0', '2013-09-09 17:13:20');
INSERT INTO `users_notifications` VALUES ('1595', '11', '178', '103', '178', '0', '2013-09-09 17:13:22');
INSERT INTO `users_notifications` VALUES ('1596', '11', '196', '103', '196', '0', '2013-09-09 17:16:22');
INSERT INTO `users_notifications` VALUES ('1597', '11', '173', '103', '173', '0', '2013-09-09 17:16:28');
INSERT INTO `users_notifications` VALUES ('1598', '11', '183', '103', '183', '1', '2013-09-09 17:16:42');
INSERT INTO `users_notifications` VALUES ('1599', '11', '162', '103', '162', '0', '2013-09-09 17:16:54');
INSERT INTO `users_notifications` VALUES ('1600', '11', '201', '103', '201', '0', '2013-09-09 17:17:11');
INSERT INTO `users_notifications` VALUES ('1601', '11', '178', '103', '178', '0', '2013-09-09 17:20:04');
INSERT INTO `users_notifications` VALUES ('1602', '11', '198', '103', '198', '0', '2013-09-09 17:20:10');
INSERT INTO `users_notifications` VALUES ('1603', '11', '2', '103', '2', '1', '2013-09-10 08:04:14');
INSERT INTO `users_notifications` VALUES ('1604', '11', '169', '103', '169', '0', '2013-09-10 08:06:08');
INSERT INTO `users_notifications` VALUES ('1605', '5', '184', '103', '184', '0', '2013-09-10 08:07:24');
INSERT INTO `users_notifications` VALUES ('1606', '11', '122', '103', '122', '0', '2013-09-10 08:08:27');
INSERT INTO `users_notifications` VALUES ('1607', '11', '84', '103', '84', '0', '2013-09-10 08:16:11');
INSERT INTO `users_notifications` VALUES ('1608', '11', '176', '103', '176', '0', '2013-09-10 08:17:38');
INSERT INTO `users_notifications` VALUES ('1609', '11', '205', '103', '205', '0', '2013-09-10 08:18:10');
INSERT INTO `users_notifications` VALUES ('1610', '11', '172', '103', '172', '0', '2013-09-10 08:24:53');
INSERT INTO `users_notifications` VALUES ('1611', '11', '198', '103', '198', '0', '2013-09-10 08:24:59');
INSERT INTO `users_notifications` VALUES ('1612', '11', '178', '103', '178', '0', '2013-09-10 08:25:11');
INSERT INTO `users_notifications` VALUES ('1613', '11', '203', '103', '203', '0', '2013-09-10 08:26:36');
INSERT INTO `users_notifications` VALUES ('1614', '11', '200', '103', '200', '0', '2013-09-10 08:26:47');
INSERT INTO `users_notifications` VALUES ('1615', '11', '123', '103', '123', '0', '2013-09-10 08:27:01');
INSERT INTO `users_notifications` VALUES ('1616', '11', '173', '103', '173', '0', '2013-09-10 08:49:17');
INSERT INTO `users_notifications` VALUES ('1617', '11', '125', '103', '125', '0', '2013-09-10 08:50:31');
INSERT INTO `users_notifications` VALUES ('1618', '11', '168', '103', '168', '0', '2013-09-10 08:51:25');
INSERT INTO `users_notifications` VALUES ('1619', '11', '196', '103', '196', '0', '2013-09-10 08:55:04');
INSERT INTO `users_notifications` VALUES ('1620', '11', '199', '103', '199', '0', '2013-09-10 08:55:54');
INSERT INTO `users_notifications` VALUES ('1621', '11', '131', '103', '131', '0', '2013-09-10 08:56:02');
INSERT INTO `users_notifications` VALUES ('1622', '11', '183', '103', '183', '1', '2013-09-10 08:56:13');
INSERT INTO `users_notifications` VALUES ('1623', '11', '85', '103', '85', '0', '2013-09-10 08:56:21');
INSERT INTO `users_notifications` VALUES ('1624', '11', '171', '103', '171', '0', '2013-09-10 08:56:27');
INSERT INTO `users_notifications` VALUES ('1625', '11', '118', '103', '118', '0', '2013-09-10 09:50:00');
INSERT INTO `users_notifications` VALUES ('1626', '11', '158', '103', '158', '0', '2013-09-10 09:50:14');
INSERT INTO `users_notifications` VALUES ('1627', '11', '164', '103', '164', '0', '2013-09-10 09:50:20');
INSERT INTO `users_notifications` VALUES ('1628', '11', '159', '103', '159', '0', '2013-09-10 09:50:29');
INSERT INTO `users_notifications` VALUES ('1629', '11', '157', '103', '157', '0', '2013-09-10 09:51:09');
INSERT INTO `users_notifications` VALUES ('1630', '11', '200', '103', '200', '0', '2013-09-10 09:53:40');
INSERT INTO `users_notifications` VALUES ('1631', '11', '203', '103', '203', '0', '2013-09-10 09:53:46');
INSERT INTO `users_notifications` VALUES ('1632', '11', '157', '184', '157', '0', '2013-09-10 09:56:41');
INSERT INTO `users_notifications` VALUES ('1633', '11', '183', '184', '183', '1', '2013-09-10 09:56:51');
INSERT INTO `users_notifications` VALUES ('1634', '11', '168', '184', '168', '0', '2013-09-10 09:56:54');
INSERT INTO `users_notifications` VALUES ('1635', '11', '118', '184', '118', '0', '2013-09-10 09:56:56');
INSERT INTO `users_notifications` VALUES ('1636', '11', '84', '184', '84', '0', '2013-09-10 09:57:00');
INSERT INTO `users_notifications` VALUES ('1647', '11', '179', '101', '179', '0', '2013-09-11 08:51:15');
INSERT INTO `users_notifications` VALUES ('1648', '11', '169', '101', '169', '0', '2013-09-11 08:51:18');
INSERT INTO `users_notifications` VALUES ('1649', '11', '181', '101', '181', '0', '2013-09-11 08:51:20');
INSERT INTO `users_notifications` VALUES ('1650', '5', '184', '101', '184', '0', '2013-09-11 09:03:10');
INSERT INTO `users_notifications` VALUES ('1651', '11', '196', '101', '196', '0', '2013-09-11 09:05:14');
INSERT INTO `users_notifications` VALUES ('1652', '11', '101', '124', '101', '2', '2013-09-11 16:23:43');
INSERT INTO `users_notifications` VALUES ('1653', '11', '85', '124', '85', '0', '2013-09-12 08:34:16');
INSERT INTO `users_notifications` VALUES ('1654', '5', '103', '124', '103', '2', '2013-09-12 08:34:41');
INSERT INTO `users_notifications` VALUES ('1836', '5', '2', '124', '2', '0', '2014-12-05 14:43:46');
INSERT INTO `users_notifications` VALUES ('1699', '11', '120', '101', '120', '2', '2014-01-29 16:20:35');
INSERT INTO `users_notifications` VALUES ('1657', '11', '83', '120', '83', '0', '2013-09-13 16:50:38');
INSERT INTO `users_notifications` VALUES ('1658', '5', '103', '120', '103', '2', '2013-09-13 16:50:40');
INSERT INTO `users_notifications` VALUES ('1659', '5', '184', '120', '184', '0', '2013-09-16 10:57:56');
INSERT INTO `users_notifications` VALUES ('1660', '11', '126', '120', '126', '0', '2013-09-16 10:59:42');
INSERT INTO `users_notifications` VALUES ('1661', '5', '124', '101', '124', '1', '2013-09-18 13:09:37');
INSERT INTO `users_notifications` VALUES ('1662', '11', '84', '101', '84', '0', '2013-09-18 13:10:05');
INSERT INTO `users_notifications` VALUES ('1663', '11', '2', '101', '2', '1', '2013-09-18 13:10:18');
INSERT INTO `users_notifications` VALUES ('1701', '10', '2164', '120', '101', '1', '2014-02-26 15:55:12');
INSERT INTO `users_notifications` VALUES ('1665', '11', '175', '206', '175', '0', '2013-10-15 11:37:52');
INSERT INTO `users_notifications` VALUES ('1666', '11', '101', '206', '101', '2', '2013-10-15 11:37:57');
INSERT INTO `users_notifications` VALUES ('1667', '11', '103', '206', '103', '2', '2013-10-15 11:38:29');
INSERT INTO `users_notifications` VALUES ('1668', '5', '206', '101', '206', '0', '2013-10-17 09:12:37');
INSERT INTO `users_notifications` VALUES ('1669', '11', '195', '183', '195', '0', '2013-10-21 10:38:46');
INSERT INTO `users_notifications` VALUES ('1670', '5', '206', '103', '206', '0', '2013-10-21 14:07:41');
INSERT INTO `users_notifications` VALUES ('1671', '11', '7', '101', '7', '1', '2013-10-21 14:11:06');
INSERT INTO `users_notifications` VALUES ('1672', '5', '103', '101', '103', '1', '2013-10-21 14:11:37');
INSERT INTO `users_notifications` VALUES ('1673', '11', '178', '101', '178', '0', '2013-10-21 14:24:36');
INSERT INTO `users_notifications` VALUES ('1674', '11', '163', '101', '163', '0', '2013-10-21 14:24:38');
INSERT INTO `users_notifications` VALUES ('1675', '11', '83', '101', '83', '0', '2013-10-21 14:24:41');
INSERT INTO `users_notifications` VALUES ('1676', '11', '162', '101', '162', '0', '2013-10-21 14:24:43');
INSERT INTO `users_notifications` VALUES ('1677', '5', '103', '7', '103', '1', '2013-10-21 15:27:20');
INSERT INTO `users_notifications` VALUES ('1678', '11', '125', '101', '125', '0', '2013-12-05 10:56:21');
INSERT INTO `users_notifications` VALUES ('1679', '11', '131', '101', '131', '0', '2013-12-05 10:56:52');
INSERT INTO `users_notifications` VALUES ('1680', '11', '123', '101', '123', '0', '2013-12-05 10:57:00');
INSERT INTO `users_notifications` VALUES ('1681', '11', '165', '101', '165', '0', '2013-12-05 10:57:14');
INSERT INTO `users_notifications` VALUES ('1682', '11', '160', '101', '160', '0', '2013-12-05 11:08:15');
INSERT INTO `users_notifications` VALUES ('1683', '11', '126', '101', '126', '0', '2013-12-06 14:14:31');
INSERT INTO `users_notifications` VALUES ('1684', '11', '204', '101', '204', '0', '2013-12-06 15:05:56');
INSERT INTO `users_notifications` VALUES ('1744', '2', '2185', '103', '2', '1', '2014-06-02 12:19:52');
INSERT INTO `users_notifications` VALUES ('1689', '1', '2107', '101', '124', '1', '2014-01-22 15:32:00');
INSERT INTO `users_notifications` VALUES ('1688', '13', '59', '103', '120', '2', '2013-12-11 09:12:46');
INSERT INTO `users_notifications` VALUES ('1690', '1', '2112', '101', '124', '1', '2014-01-22 15:50:41');
INSERT INTO `users_notifications` VALUES ('1691', '1', '2114', '101', '184', '0', '2014-01-22 15:52:34');
INSERT INTO `users_notifications` VALUES ('1692', '1', '2115', '101', '124', '1', '2014-01-22 15:53:22');
INSERT INTO `users_notifications` VALUES ('1693', '1', '2115', '101', '103', '1', '2014-01-22 15:53:22');
INSERT INTO `users_notifications` VALUES ('1694', '1', '2115', '101', '184', '0', '2014-01-22 15:53:22');
INSERT INTO `users_notifications` VALUES ('1702', '11', '2', '120', '2', '1', '2014-03-06 10:36:53');
INSERT INTO `users_notifications` VALUES ('1734', '11', '7', '120', '7', '1', '2014-06-02 12:06:06');
INSERT INTO `users_notifications` VALUES ('1704', '11', '84', '120', '84', '0', '2014-03-06 10:37:01');
INSERT INTO `users_notifications` VALUES ('1705', '11', '125', '120', '125', '0', '2014-03-06 10:37:05');
INSERT INTO `users_notifications` VALUES ('1706', '16', '273', '427', '120', '1', '2014-03-10 10:07:26');
INSERT INTO `users_notifications` VALUES ('1707', '16', '274', '427', '120', '1', '2014-03-10 10:58:06');
INSERT INTO `users_notifications` VALUES ('1708', '16', '275', '427', '120', '1', '2014-03-10 11:24:48');
INSERT INTO `users_notifications` VALUES ('1709', '16', '276', '427', '7', '1', '2014-03-10 11:35:08');
INSERT INTO `users_notifications` VALUES ('1710', '8', '2165', '101', '120', '1', '2014-03-11 10:27:28');
INSERT INTO `users_notifications` VALUES ('1711', '2', '2175', '101', '103', '1', '2014-03-11 10:50:02');
INSERT INTO `users_notifications` VALUES ('1712', '2', '2174', '101', '7', '1', '2014-03-11 10:56:45');
INSERT INTO `users_notifications` VALUES ('1713', '8', '2174', '101', '7', '1', '2014-03-11 10:56:58');
INSERT INTO `users_notifications` VALUES ('1714', '8', '2175', '101', '103', '1', '2014-03-11 10:58:27');
INSERT INTO `users_notifications` VALUES ('1715', '8', '2171', '101', '7', '1', '2014-03-11 11:04:08');
INSERT INTO `users_notifications` VALUES ('1716', '8', '2175', '7', '103', '1', '2014-03-11 11:04:15');
INSERT INTO `users_notifications` VALUES ('1717', '8', '2176', '103', '7', '1', '2014-03-11 11:04:26');
INSERT INTO `users_notifications` VALUES ('1718', '11', '173', '101', '173', '0', '2014-03-18 10:39:10');
INSERT INTO `users_notifications` VALUES ('1719', '11', '208', '101', '208', '0', '2014-03-18 15:17:54');
INSERT INTO `users_notifications` VALUES ('1720', '11', '118', '101', '118', '0', '2014-03-18 15:20:02');
INSERT INTO `users_notifications` VALUES ('1721', '11', '174', '101', '174', '0', '2014-03-18 15:20:54');
INSERT INTO `users_notifications` VALUES ('1722', '11', '164', '101', '164', '0', '2014-03-18 15:22:05');
INSERT INTO `users_notifications` VALUES ('1723', '11', '203', '101', '203', '0', '2014-03-18 15:25:10');
INSERT INTO `users_notifications` VALUES ('1724', '11', '158', '101', '158', '0', '2014-03-18 15:26:13');
INSERT INTO `users_notifications` VALUES ('1725', '11', '171', '101', '171', '0', '2014-03-18 15:29:15');
INSERT INTO `users_notifications` VALUES ('1726', '2', '2182', '101', '2', '1', '2014-06-02 11:29:22');
INSERT INTO `users_notifications` VALUES ('1727', '2', '2184', '101', '2', '1', '2014-06-02 11:54:00');
INSERT INTO `users_notifications` VALUES ('1728', '2', '2184', '120', '2', '1', '2014-06-02 11:54:01');
INSERT INTO `users_notifications` VALUES ('1732', '5', '2', '7', '2', '1', '2014-06-02 12:02:34');
INSERT INTO `users_notifications` VALUES ('1731', '5', '7', '2', '7', '1', '2014-06-02 12:00:36');
INSERT INTO `users_notifications` VALUES ('1736', '5', '184', '7', '184', '0', '2014-06-02 12:06:31');
INSERT INTO `users_notifications` VALUES ('1737', '5', '120', '7', '120', '2', '2014-06-02 12:06:34');
INSERT INTO `users_notifications` VALUES ('1738', '2', '1108', '120', '7', '1', '2014-06-02 12:09:05');
INSERT INTO `users_notifications` VALUES ('1739', '2', '2184', '103', '2', '1', '2014-06-02 12:14:36');
INSERT INTO `users_notifications` VALUES ('1740', '2', '2183', '103', '7', '1', '2014-06-02 12:14:38');
INSERT INTO `users_notifications` VALUES ('1741', '2', '2182', '103', '2', '1', '2014-06-02 12:14:41');
INSERT INTO `users_notifications` VALUES ('1742', '2', '2181', '103', '101', '1', '2014-06-02 12:14:43');
INSERT INTO `users_notifications` VALUES ('1743', '13', '54', '103', '101', '1', '2014-06-02 12:15:05');
INSERT INTO `users_notifications` VALUES ('1745', '2', '2186', '103', '101', '1', '2014-06-02 14:32:06');
INSERT INTO `users_notifications` VALUES ('1746', '8', '2186', '103', '101', '1', '2014-06-02 14:32:09');
INSERT INTO `users_notifications` VALUES ('1747', '8', '2181', '120', '101', '1', '2014-06-02 14:48:42');
INSERT INTO `users_notifications` VALUES ('1748', '2', '2181', '120', '101', '1', '2014-06-02 14:48:49');
INSERT INTO `users_notifications` VALUES ('1749', '11', '181', '120', '181', '0', '2014-06-02 14:49:47');
INSERT INTO `users_notifications` VALUES ('1750', '8', '2184', '101', '2', '1', '2014-06-02 14:56:45');
INSERT INTO `users_notifications` VALUES ('1751', '8', '2184', '7', '2', '1', '2014-06-02 14:56:54');
INSERT INTO `users_notifications` VALUES ('1752', '1', '2192', '101', '7', '1', '2014-06-02 15:20:12');
INSERT INTO `users_notifications` VALUES ('1753', '1', '2192', '101', '103', '1', '2014-06-02 15:20:12');
INSERT INTO `users_notifications` VALUES ('1754', '1', '2192', '101', '120', '1', '2014-06-02 15:20:12');
INSERT INTO `users_notifications` VALUES ('1755', '5', '101', '2', '101', '1', '2014-06-02 15:21:08');
INSERT INTO `users_notifications` VALUES ('1756', '2', '2192', '103', '101', '1', '2014-06-02 15:21:56');
INSERT INTO `users_notifications` VALUES ('1757', '2', '2192', '120', '101', '1', '2014-06-02 15:21:58');
INSERT INTO `users_notifications` VALUES ('1758', '2', '2192', '7', '101', '1', '2014-06-02 15:22:00');
INSERT INTO `users_notifications` VALUES ('1759', '1', '2193', '101', '2', '1', '2014-06-02 15:26:22');
INSERT INTO `users_notifications` VALUES ('1760', '11', '178', '2', '178', '0', '2014-06-02 15:27:37');
INSERT INTO `users_notifications` VALUES ('1763', '6', '61', '101', '7', '2', '2014-06-02 15:46:58');
INSERT INTO `users_notifications` VALUES ('1762', '13', '61', '101', '2', '1', '2014-06-02 15:46:08');
INSERT INTO `users_notifications` VALUES ('1764', '6', '61', '101', '103', '1', '2014-06-02 15:46:58');
INSERT INTO `users_notifications` VALUES ('1765', '10', '2195', '103', '101', '1', '2014-06-02 15:49:08');
INSERT INTO `users_notifications` VALUES ('1766', '10', '2195', '103', '2', '1', '2014-06-02 15:49:08');
INSERT INTO `users_notifications` VALUES ('1767', '10', '2195', '103', '7', '1', '2014-06-02 15:49:08');
INSERT INTO `users_notifications` VALUES ('1768', '10', '2196', '7', '101', '1', '2014-06-02 15:49:22');
INSERT INTO `users_notifications` VALUES ('1769', '10', '2196', '7', '2', '1', '2014-06-02 15:49:22');
INSERT INTO `users_notifications` VALUES ('1770', '10', '2196', '7', '103', '1', '2014-06-02 15:49:22');
INSERT INTO `users_notifications` VALUES ('1773', '6', '61', '101', '120', '2', '2014-06-02 16:00:55');
INSERT INTO `users_notifications` VALUES ('1774', '10', '2197', '103', '101', '1', '2014-06-02 16:09:30');
INSERT INTO `users_notifications` VALUES ('1775', '10', '2197', '103', '2', '1', '2014-06-02 16:09:30');
INSERT INTO `users_notifications` VALUES ('1776', '10', '2197', '103', '7', '1', '2014-06-02 16:09:30');
INSERT INTO `users_notifications` VALUES ('1777', '10', '2197', '103', '120', '1', '2014-06-02 16:09:30');
INSERT INTO `users_notifications` VALUES ('1778', '10', '2198', '120', '101', '1', '2014-06-02 16:09:51');
INSERT INTO `users_notifications` VALUES ('1779', '10', '2198', '120', '2', '1', '2014-06-02 16:09:51');
INSERT INTO `users_notifications` VALUES ('1780', '10', '2198', '120', '7', '1', '2014-06-02 16:09:51');
INSERT INTO `users_notifications` VALUES ('1781', '10', '2198', '120', '103', '1', '2014-06-02 16:09:51');
INSERT INTO `users_notifications` VALUES ('1782', '10', '2199', '120', '101', '1', '2014-06-02 16:10:32');
INSERT INTO `users_notifications` VALUES ('1783', '10', '2199', '120', '2', '1', '2014-06-02 16:10:32');
INSERT INTO `users_notifications` VALUES ('1784', '10', '2199', '120', '7', '1', '2014-06-02 16:10:32');
INSERT INTO `users_notifications` VALUES ('1785', '10', '2199', '120', '103', '1', '2014-06-02 16:10:32');
INSERT INTO `users_notifications` VALUES ('1786', '10', '2200', '103', '101', '1', '2014-06-02 16:11:25');
INSERT INTO `users_notifications` VALUES ('1787', '10', '2200', '103', '2', '1', '2014-06-02 16:11:25');
INSERT INTO `users_notifications` VALUES ('1788', '10', '2200', '103', '7', '1', '2014-06-02 16:11:25');
INSERT INTO `users_notifications` VALUES ('1789', '10', '2200', '103', '120', '1', '2014-06-02 16:11:25');
INSERT INTO `users_notifications` VALUES ('1790', '10', '2201', '120', '101', '1', '2014-06-02 16:11:41');
INSERT INTO `users_notifications` VALUES ('1791', '10', '2201', '120', '2', '1', '2014-06-02 16:11:41');
INSERT INTO `users_notifications` VALUES ('1792', '10', '2201', '120', '7', '1', '2014-06-02 16:11:41');
INSERT INTO `users_notifications` VALUES ('1793', '10', '2201', '120', '103', '1', '2014-06-02 16:11:41');
INSERT INTO `users_notifications` VALUES ('1794', '10', '2202', '103', '101', '1', '2014-06-02 16:12:55');
INSERT INTO `users_notifications` VALUES ('1795', '10', '2202', '103', '2', '1', '2014-06-02 16:12:55');
INSERT INTO `users_notifications` VALUES ('1796', '10', '2202', '103', '7', '1', '2014-06-02 16:12:55');
INSERT INTO `users_notifications` VALUES ('1797', '10', '2202', '103', '120', '1', '2014-06-02 16:12:55');
INSERT INTO `users_notifications` VALUES ('1798', '10', '2203', '101', '2', '1', '2014-06-02 16:13:51');
INSERT INTO `users_notifications` VALUES ('1799', '10', '2203', '101', '7', '1', '2014-06-02 16:13:51');
INSERT INTO `users_notifications` VALUES ('1800', '10', '2203', '101', '103', '1', '2014-06-02 16:13:51');
INSERT INTO `users_notifications` VALUES ('1801', '10', '2203', '101', '120', '1', '2014-06-02 16:13:51');
INSERT INTO `users_notifications` VALUES ('1802', '10', '2204', '120', '101', '1', '2014-06-02 16:14:50');
INSERT INTO `users_notifications` VALUES ('1803', '10', '2204', '120', '2', '1', '2014-06-02 16:14:50');
INSERT INTO `users_notifications` VALUES ('1804', '10', '2204', '120', '7', '1', '2014-06-02 16:14:50');
INSERT INTO `users_notifications` VALUES ('1805', '10', '2204', '120', '103', '1', '2014-06-02 16:14:50');
INSERT INTO `users_notifications` VALUES ('1806', '10', '2205', '2', '101', '1', '2014-06-02 16:14:58');
INSERT INTO `users_notifications` VALUES ('1807', '10', '2205', '2', '7', '1', '2014-06-02 16:14:58');
INSERT INTO `users_notifications` VALUES ('1808', '10', '2205', '2', '103', '1', '2014-06-02 16:14:58');
INSERT INTO `users_notifications` VALUES ('1809', '10', '2205', '2', '120', '1', '2014-06-02 16:14:58');
INSERT INTO `users_notifications` VALUES ('1810', '10', '2206', '2', '101', '1', '2014-06-02 16:15:51');
INSERT INTO `users_notifications` VALUES ('1811', '10', '2206', '2', '7', '1', '2014-06-02 16:15:51');
INSERT INTO `users_notifications` VALUES ('1812', '10', '2206', '2', '103', '1', '2014-06-02 16:15:51');
INSERT INTO `users_notifications` VALUES ('1813', '10', '2206', '2', '120', '1', '2014-06-02 16:15:51');
INSERT INTO `users_notifications` VALUES ('1814', '10', '2207', '101', '2', '1', '2014-06-02 16:16:18');
INSERT INTO `users_notifications` VALUES ('1815', '10', '2207', '101', '7', '1', '2014-06-02 16:16:18');
INSERT INTO `users_notifications` VALUES ('1816', '10', '2207', '101', '103', '1', '2014-06-02 16:16:18');
INSERT INTO `users_notifications` VALUES ('1817', '10', '2207', '101', '120', '1', '2014-06-02 16:16:18');
INSERT INTO `users_notifications` VALUES ('1818', '10', '2208', '2', '101', '1', '2014-06-02 16:19:09');
INSERT INTO `users_notifications` VALUES ('1819', '10', '2208', '2', '7', '1', '2014-06-02 16:19:09');
INSERT INTO `users_notifications` VALUES ('1820', '10', '2208', '2', '103', '1', '2014-06-02 16:19:09');
INSERT INTO `users_notifications` VALUES ('1821', '10', '2208', '2', '120', '1', '2014-06-02 16:19:09');
INSERT INTO `users_notifications` VALUES ('1822', '1', '2212', '2', '101', '1', '2014-06-03 09:41:59');
INSERT INTO `users_notifications` VALUES ('1823', '16', '278', '427', '101', '1', '2014-06-03 10:52:17');
INSERT INTO `users_notifications` VALUES ('1824', '16', '281', '427', '103', '1', '2014-06-03 10:56:55');
INSERT INTO `users_notifications` VALUES ('1825', '16', '282', '427', '103', '1', '2014-06-03 15:24:12');
INSERT INTO `users_notifications` VALUES ('1826', '16', '283', '427', '2', '0', '2014-06-03 15:28:21');
INSERT INTO `users_notifications` VALUES ('1828', '5', '124', '2', '124', '1', '2014-08-18 09:52:55');
INSERT INTO `users_notifications` VALUES ('1829', '5', '184', '2', '184', '0', '2014-08-18 09:52:56');
INSERT INTO `users_notifications` VALUES ('1830', '11', '196', '124', '196', '0', '2014-08-18 10:35:17');
INSERT INTO `users_notifications` VALUES ('1831', '5', '184', '124', '184', '0', '2014-08-18 10:35:36');
INSERT INTO `users_notifications` VALUES ('1832', '2', '2249', '124', '184', '0', '2014-08-19 09:46:19');
INSERT INTO `users_notifications` VALUES ('1833', '2', '2248', '124', '184', '0', '2014-08-19 09:46:25');
INSERT INTO `users_notifications` VALUES ('1834', '2', '2245', '124', '184', '0', '2014-08-19 09:46:47');
INSERT INTO `users_notifications` VALUES ('1835', '11', '84', '124', '84', '0', '2014-12-05 14:36:46');
INSERT INTO `users_notifications` VALUES ('1838', '5', '184', '183', '184', '0', '2015-01-15 10:38:13');
INSERT INTO `users_notifications` VALUES ('1839', '5', '103', '183', '103', '0', '2015-01-15 10:38:19');
INSERT INTO `users_notifications` VALUES ('1844', '5', '103', '2', '103', '0', '2015-01-15 15:45:31');
INSERT INTO `users_notifications` VALUES ('1845', '11', '174', '124', '174', '0', '2015-01-20 15:52:43');

-- ----------------------------
-- Table structure for users_panel
-- ----------------------------
DROP TABLE IF EXISTS `users_panel`;
CREATE TABLE `users_panel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` mediumtext COLLATE utf8_spanish_ci,
  `apellidos` mediumtext COLLATE utf8_spanish_ci,
  `login` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `code` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `modulos` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records of users_panel
-- ----------------------------
INSERT INTO `users_panel` VALUES ('1', 'SendUrTag', '.com', 'admin', 'admin', '0', '123', '');
INSERT INTO `users_panel` VALUES ('2', 'Adrain', 'Esqueda', 'aesqueda', 'rastashe1983', '1', '123456', 'vistas/languages/master.php,vistas/languages/sections.php,vistas/languages/template.php,vistas/languages/translations.php');

-- ----------------------------
-- Table structure for users_plan_purchase
-- ----------------------------
DROP TABLE IF EXISTS `users_plan_purchase`;
CREATE TABLE `users_plan_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `init_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of users_plan_purchase
-- ----------------------------
INSERT INTO `users_plan_purchase` VALUES ('4', '103', '1', '2013-08-13', '2015-04-30');
INSERT INTO `users_plan_purchase` VALUES ('5', '120', '1', '2013-08-14', '2100-08-29');
INSERT INTO `users_plan_purchase` VALUES ('6', '184', '1', '2013-08-14', '2213-08-14');
INSERT INTO `users_plan_purchase` VALUES ('7', '2', '1', '2014-02-13', '2213-08-14');
INSERT INTO `users_plan_purchase` VALUES ('8', '7', '1', '2014-02-13', '2213-08-14');

-- ----------------------------
-- Table structure for users_preferences
-- ----------------------------
DROP TABLE IF EXISTS `users_preferences`;
CREATE TABLE `users_preferences` (
  `id_user` bigint(20) NOT NULL,
  `id_preference` bigint(5) NOT NULL,
  `preference` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_preferences
-- ----------------------------
INSERT INTO `users_preferences` VALUES ('2', '1', '422,Comer,punta brava');
INSERT INTO `users_preferences` VALUES ('2', '2', '1013,1012,Cagar,tirar,llorar');
INSERT INTO `users_preferences` VALUES ('2', '3', '1047,Trabajar,mirar,tetar');
INSERT INTO `users_preferences` VALUES ('101', '0', '');
INSERT INTO `users_preferences` VALUES ('101', '1', 'prueba 2,mercantil,hombres ');
INSERT INTO `users_preferences` VALUES ('101', '2', 'todo,1427,culo peluo');
INSERT INTO `users_preferences` VALUES ('101', '3', 'swift,pene,hombres,amor');
INSERT INTO `users_preferences` VALUES ('84', '0', '');
INSERT INTO `users_preferences` VALUES ('7', '0', '');
INSERT INTO `users_preferences` VALUES ('131', '0', '');
INSERT INTO `users_preferences` VALUES ('124', '2', '979');
INSERT INTO `users_preferences` VALUES ('124', '1', '136,376');
INSERT INTO `users_preferences` VALUES ('124', '0', '');
INSERT INTO `users_preferences` VALUES ('7', '1', 'hola,casa,carro,uno');
INSERT INTO `users_preferences` VALUES ('7', '2', 'perro,comida,dos');
INSERT INTO `users_preferences` VALUES ('7', '3', 'tres,carro');
INSERT INTO `users_preferences` VALUES ('184', '1', '11');
INSERT INTO `users_preferences` VALUES ('184', '3', '1018,que');
INSERT INTO `users_preferences` VALUES ('184', '2', '988,hola');
INSERT INTO `users_preferences` VALUES ('120', '1', 'curdas');
INSERT INTO `users_preferences` VALUES ('120', '3', '');
INSERT INTO `users_preferences` VALUES ('120', '2', 'culo');
INSERT INTO `users_preferences` VALUES ('124', '3', '1010');

-- ----------------------------
-- Table structure for users_profile_showbirthday
-- ----------------------------
DROP TABLE IF EXISTS `users_profile_showbirthday`;
CREATE TABLE `users_profile_showbirthday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_profile_showbirthday
-- ----------------------------
INSERT INTO `users_profile_showbirthday` VALUES ('1', 'USERPROFILE_LBLCBO_SHOWFULLBIRTHDAY');
INSERT INTO `users_profile_showbirthday` VALUES ('2', 'USERPROFILE_LBLCBO_SHOWONLYMONTH');
INSERT INTO `users_profile_showbirthday` VALUES ('3', 'USERPROFILE_LBLCBO_NOSHOWBIRTHDAY');

-- ----------------------------
-- Table structure for users_publicity
-- ----------------------------
DROP TABLE IF EXISTS `users_publicity`;
CREATE TABLE `users_publicity` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `id_tag` bigint(11) NOT NULL,
  `id_type_publicity` int(11) NOT NULL,
  `id_cost` int(11) NOT NULL,
  `id_user` bigint(11) NOT NULL,
  `id_currency` int(11) NOT NULL,
  `title` varchar(25) NOT NULL,
  `message` varchar(90) DEFAULT NULL,
  `link` mediumtext NOT NULL,
  `picture` varchar(100) NOT NULL,
  `picture_title_tag` varchar(100) NOT NULL,
  `cost_investment` decimal(15,2) NOT NULL,
  `click_max` int(11) NOT NULL,
  `click_current` int(11) NOT NULL,
  `status` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_publicity
-- ----------------------------
INSERT INTO `users_publicity` VALUES ('6', '1675', '1', '4', '101', '0', 'playa azul chichiriviche', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://seemytag.com', 'fe0429139aaa0dadb369210fa5b2c484/745316258276d39fc08a3276590d0e6d.jpg', '', '10.00', '1000', '68', '1');
INSERT INTO `users_publicity` VALUES ('7', '1671', '1', '4', '101', '0', 'Hotmail enterprise', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://seemytag.com', 'fe0429139aaa0dadb369210fa5b2c484/22f42ae15599b24f59457a5471adb372.jpg', '', '10.00', '1000', '5', '1');
INSERT INTO `users_publicity` VALUES ('8', '1676', '1', '4', '101', '0', 'banco Mercantil oooooooo', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://seemytag.com', 'fe0429139aaa0dadb369210fa5b2c484/a11e8eb68ebd362a3009c216209daf3d.jpg', '', '10.00', '1000', '6', '1');
INSERT INTO `users_publicity` VALUES ('5', '1669', '1', '4', '2', '0', 'sera ', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://seemytag.com', '', '', '10.00', '1000', '1', '1');
INSERT INTO `users_publicity` VALUES ('9', '1686', '1', '4', '101', '0', 'Mierda en pasta', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://dddddddddddddd.vcom', 'fe0429139aaa0dadb369210fa5b2c484/c21d38d7020bb1982f5953693c625bf0.jpg', '', '10.00', '1000', '5', '1');
INSERT INTO `users_publicity` VALUES ('10', '1664', '1', '4', '2', '0', 'culos bellos', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://aaa.com', '', '', '10.00', '1000', '5', '1');
INSERT INTO `users_publicity` VALUES ('11', '1687', '1', '4', '184', '0', 'swift 1.6 sinc ano 92', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://hhhhhhhhhh.com', 'fe0429139aaa0dadb369210fa5b2c484/c21d38d7020bb1982f5953693c625bf0.jpg', '', '10.00', '1000', '5', '1');
INSERT INTO `users_publicity` VALUES ('12', '1880', '1', '4', '2', '0', 'publi1', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://megabuenas.com', '', '', '10.00', '1000', '1', '1');
INSERT INTO `users_publicity` VALUES ('13', '1879', '1', '4', '2', '0', 'publi 2', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://megabuenas.com', '', '', '10.00', '1000', '3', '1');
INSERT INTO `users_publicity` VALUES ('14', '1878', '1', '4', '2', '0', 'publi 3', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://megabuenas.com', '', '', '10.00', '1000', '0', '1');
INSERT INTO `users_publicity` VALUES ('15', '1877', '1', '4', '2', '0', 'prueba 2', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://megabuenas.com', '', '', '10.00', '1000', '6', '1');
INSERT INTO `users_publicity` VALUES ('16', '1876', '1', '4', '2', '0', 'publie444', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://megabuenas.com', '', '', '10.00', '1000', '2', '1');
INSERT INTO `users_publicity` VALUES ('17', '1875', '1', '4', '2', '0', 'perrasss', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://megabuenas.com', '', '', '10.00', '1000', '4', '1');
INSERT INTO `users_publicity` VALUES ('18', '1874', '1', '4', '2', '0', 'mardita jjjjjjjjjjjjj', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://megabuenas.com', '', '', '10.00', '1000', '3', '1');
INSERT INTO `users_publicity` VALUES ('19', '1873', '1', '4', '2', '0', 'clitorisss', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://megabuenas.com', '', '', '10.00', '1000', '3', '1');
INSERT INTO `users_publicity` VALUES ('20', '1872', '1', '4', '2', '0', 'putas mmmmmmm', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://megabuenas.com', '', '', '10.00', '1000', '2', '1');
INSERT INTO `users_publicity` VALUES ('21', '1871', '1', '4', '2', '0', 'cel cel', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://megabuenas.com', '', '', '10.00', '1000', '6', '1');
INSERT INTO `users_publicity` VALUES ('22', '0', '2', '8', '184', '1', 'mimimimimimi', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://seemytag.com', '3a4ad9a63825f8c78c321ac7bab8e1ce/5de58fe83e446140859462570c52ef4e.jpg', '', '9999999999999.99', '0', '0', '1');
INSERT INTO `users_publicity` VALUES ('23', '0', '2', '4', '184', '1', 'xxxxxxxxxxx', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://xxxxxxxxxxxxxxxx.com', '3a4ad9a63825f8c78c321ac7bab8e1ce/5de58fe83e446140859462570c52ef4e.jpg', '', '10.00', '1000', '0', '1');
INSERT INTO `users_publicity` VALUES ('24', '0', '2', '4', '184', '1', '1231316', 'Banco mercantil onc oqn ienfie fiobe didie dieqnd edipen d edihenfoeq iheq keqnfoemfphrwg ', 'http://a132132123.com', '3a4ad9a63825f8c78c321ac7bab8e1ce/2ad95d9bd97c824a4068f30c2e5188fc.jpg', '', '10.00', '1000', '0', '1');
INSERT INTO `users_publicity` VALUES ('25', '0', '2', '4', '103', '1', 'aaaaa', 'hdhdhdhdhd hdhdhdhdhd hdhdhdhdhd hdhdhdhdhd hdhdhdhdhd hdhdhdhdhd hdhdhdhdhd hdhdhdhdhd hd', 'http://aa.com', '4267a3d7f83b0c37ebed6a8b5ba94bf2/da9e78f180de1500ba2fee872f6528da.jpg', '', '10.00', '1000', '0', '1');
INSERT INTO `users_publicity` VALUES ('26', '0', '2', '4', '103', '1', 'Ford Motors de venezuela.', 'jhgkjhkjh ij  h n guig g iug  trdf rtwer dtewrt rs gigyu yfytdrydygfcyutrd yurdtry iiyre5e', 'http://ko.com', '4267a3d7f83b0c37ebed6a8b5ba94bf2/974b9cd56acc6839186d4997c005a282.jpg', '', '10.00', '1000', '0', '1');
INSERT INTO `users_publicity` VALUES ('27', '0', '2', '4', '2', '1', 'Ultima', 'ultimaaaaa', 'http://uti.com', 'e1eadabf4124d00a82b548c383841364/1e34d625eb3502bff6804941c22ead30.jpg', '', '10.00', '1000', '0', '1');

-- ----------------------------
-- Table structure for users_publicity_validation
-- ----------------------------
DROP TABLE IF EXISTS `users_publicity_validation`;
CREATE TABLE `users_publicity_validation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_publicity` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `timep` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_publicity_validation
-- ----------------------------
INSERT INTO `users_publicity_validation` VALUES ('25', '120', '6', '192.168.1.123', '2013-09-17 11:08:22');
INSERT INTO `users_publicity_validation` VALUES ('26', '120', '11', '192.168.1.123', '2013-09-16 10:10:36');
INSERT INTO `users_publicity_validation` VALUES ('27', '120', '11', '192.168.1.123', '2013-09-17 11:12:00');
INSERT INTO `users_publicity_validation` VALUES ('28', '120', '15', '192.168.1.123', '2013-09-16 11:13:34');
INSERT INTO `users_publicity_validation` VALUES ('29', '120', '15', '192.168.1.123', '2013-09-17 11:14:17');
INSERT INTO `users_publicity_validation` VALUES ('37', '120', '21', '192.168.1.123', '2013-09-17 12:52:50');
INSERT INTO `users_publicity_validation` VALUES ('36', '120', '8', '192.168.1.123', '2013-09-17 11:40:24');
INSERT INTO `users_publicity_validation` VALUES ('38', '0', '6', '192.168.1.123', '2013-09-18 08:09:57');
INSERT INTO `users_publicity_validation` VALUES ('39', '120', '6', '192.168.1.123', '2013-09-18 14:00:44');
INSERT INTO `users_publicity_validation` VALUES ('40', '0', '6', '192.168.1.123', '2013-09-19 08:17:59');
INSERT INTO `users_publicity_validation` VALUES ('41', '184', '23', '192.168.1.141', '2014-02-18 10:12:32');
INSERT INTO `users_publicity_validation` VALUES ('42', '184', '25', '192.168.1.141', '2014-02-18 10:12:50');
INSERT INTO `users_publicity_validation` VALUES ('43', '184', '26', '192.168.1.141', '2014-02-18 10:13:05');
INSERT INTO `users_publicity_validation` VALUES ('44', '184', '24', '192.168.1.141', '2014-02-18 10:13:14');
INSERT INTO `users_publicity_validation` VALUES ('45', '2', '24', '192.168.1.123', '2014-06-02 15:29:48');

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

-- ----------------------------
-- Table structure for users_search_preferences
-- ----------------------------
DROP TABLE IF EXISTS `users_search_preferences`;
CREATE TABLE `users_search_preferences` (
  `id` int(10) unsigned NOT NULL,
  `sex_preference` tinyint(3) unsigned NOT NULL,
  `wish_to` tinyint(3) unsigned NOT NULL,
  `min_age` tinyint(3) unsigned NOT NULL,
  `max_age` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_search_preferences
-- ----------------------------
INSERT INTO `users_search_preferences` VALUES ('124', '0', '0', '13', '70');

-- ----------------------------
-- Table structure for users_sex_preferences
-- ----------------------------
DROP TABLE IF EXISTS `users_sex_preferences`;
CREATE TABLE `users_sex_preferences` (
  `id` tinyint(4) unsigned NOT NULL,
  `label` varchar(15) DEFAULT NULL,
  `description` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_sex_preferences
-- ----------------------------
INSERT INTO `users_sex_preferences` VALUES ('0', 'ALL_P', 'all / todos');
INSERT INTO `users_sex_preferences` VALUES ('1', 'males', 'males / hombres');
INSERT INTO `users_sex_preferences` VALUES ('2', 'females', 'females / mujeres');

-- ----------------------------
-- Table structure for users_wish_to
-- ----------------------------
DROP TABLE IF EXISTS `users_wish_to`;
CREATE TABLE `users_wish_to` (
  `id` tinyint(11) unsigned NOT NULL,
  `label` varchar(10) NOT NULL,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_wish_to
-- ----------------------------
INSERT INTO `users_wish_to` VALUES ('0', 'all', 'all / todo');
INSERT INTO `users_wish_to` VALUES ('1', 'chat', 'chat / chatear');
INSERT INTO `users_wish_to` VALUES ('2', 'date', 'date / cita');
INSERT INTO `users_wish_to` VALUES ('4', 'friendship', 'friendship / amistad');
